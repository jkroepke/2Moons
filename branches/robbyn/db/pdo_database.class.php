<?php
/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package 2Moons
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.2 (2013-03-18)
 * @info $Id: admin.php 2640 2013-03-23 19:23:26Z slaver7 $
 * @link http://2moons.cc/
 */

class pdo_database extends PDO
{
	/**
	 * PDO Datenbank Verbindung aufbauen
	 *
	 * @param string $dsn => mysql;host=localhost;dbname=database;charset:utf-8
	 * @param string $username => benutzername
	 * @param string $passwd => password
	 * @return void
	 */
	public function __construct($dsn, $username, $passwd)
	{
		parent::__construct($dsn, $username, $passwd, null);

		parent::setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);//Default return Ergebniss fetch_assoc

		parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //PDO-Exception aktivieren
		parent::setAttribute(PDO::ATTR_EMULATE_PREPARES, 0); //Für Multi-Querys
	}

	/**
	 * Führt eine oder mehrere Query aus
	 *
	 * @param string $statement
	 * @return array|boolean $query
	 */
	public function query($statement)
	{
		try{
			$query	=	parent::query($statement);
		}catch(PDOException $e){
			$this->error($e->errorInfo);
		}

		if(empty($query))
		{
			return false;
		}

		return $query;
	}

	/**
	 * Liefert ein einfaches Fetch Assoc Array zurück
	 *
	 * @param string $statement
	 * @return array
	 */
	public function quefetch($statement)
	{
		if(!is_string($statement) || empty($statement))
		{
			$this->error('$statement ist kein string oder ist leer');
		}

		$stmt 	= 	$this->query($statement);
		$stmt	=	$stmt->fetchAll();

		if(empty($stmt))
		{
			return array();
		}
		else
		{
			return $stmt[0];
		}
	}



	/**
	 * Führt die Query aus und gibt ein fetch_assoc Array zurück
	 *
	 * @param string $statement
	 * @param string $result
	 * @return array
	 */
	public function result_array($statement, $result = PDO::FETCH_ASSOC)
	{
		if(!is_string($statement) || empty($statement))
		{
			$this->error('$statement ist kein string oder ist leer');
		}

		$stmt = $this->query($statement);

		return $stmt->fetchAll($result);
	}


	/**
	 * Führt eine multi_query durch
	 *
	 * @param string $statement
	 * @return boolean
	 */
	public function multi_query($statement)
	{
		try{
			$exec	=	$this->exec($statement);
		}catch(PDOException $e){
			$this->error($e->errorInfo);
		}

		return true;
	}


	/**
	 * Selektiert und gibt das Resultat zurück
	 *
	 * Mittels dieser Funktion sind mehrer Tabellenverschachtelungen möglich, aber keine JOINS
	 *
	 * @param array $select Hier gibt man an welche Felder in der Tabelle selektiert werden sollen
	 * @param string $table Der Tabellenname kommt hier rein
	 * @param array $where Ob es bedingungen für die selektion geben soll kann man hier angeben
	 * @param string $result Hier gibt man an was zurück kommen soll, dafür stehen die PDO:: Variablen zur Verfügung z.b. PDO::FETCH_ASSOC, PDO::FETCH_BOTH, PDO::FETCH_BOUND
	 * @return boolean|array
	 */
	public function select($select, $table, $where, $groupBy = '', $result = PDO::FETCH_ASSOC)
	{
		$sql = '';

		if(!is_string($table) || empty($table))
		{
			$this->error('$table ist kein string oder ist leer');
		}

		if($select == '*')
		{
			$sql	=	'SELECT * FROM '.$table;
		}
		else
		{
			if(!is_array($select) || empty($select))
			{
				$this->error('$select ist kein array oder ist leer');
			}

			$sql	=	'SELECT '.implode(',',$select).' FROM '.$table;
		}

		if(!is_array($where) && !empty($where))
		{
			$this->error('$where ist kein array');
		}

		if(!empty($where))
		{
			$sql .= ' WHERE ';
		}

		$executeValue = array();

		foreach($where as $field => $value)
		{
			$sql .= $field.' = ? AND ';

			$executeValue[] = $value;
		}

		$sql	=	substr($sql,0,-4);


		if(!empty($groupBy))
		{
			$sql	.=	' GROUP BY `'.$groupBy.'`;';
		}

		try{
			$stmt =  parent::prepare($sql);
			$stmt->execute($executeValue);
		}catch(PDOException $e){
			$this->error($e->errorInfo);
		}

		return $stmt->fetchAll($result);
	}


	/**
	 * Updatet einen/mehrere Wert(e) in der Datenbank
	 *
	 * @param string $table => Tabellenname
	 * @param array $update => die Felder die geupdatet werden sollen
	 * @param array $where => die Where Anweisungen
	 * @return boolean
	 */
	public function update($table, $update, $where)
	{
		if(!is_string($table) || empty($table))
		{
			$this->error('$table ist kein string oder ist leer');
		}

		if(!is_array($update) || empty($update))
		{
			$this->error('$update ist kein array oder ist leer');
		}

		if(!is_array($where) || empty($where))
		{
			$this->error('$where ist kein array oder ist leer');
		}

		$sql			=	'UPDATE '.$table.' SET ';
		$executeValue	=	array();

		foreach($update as $field => $value)
		{
			if($value === 'NOW()')
			{
				$sql	.=	'`'.$field.'` = NOW(),';
				continue;
			}
			elseif(preg_match('/IN/', $value) == 1)
			{
				$sql	.=	'`'.$field.'` '.$value.' AND';
				continue;
			}

			$executeValue[]	=	$value;
			$sql	.=	'`'.$field.'` = ?,';
		}

		$sql	=	substr($sql,0,-1);

		$sql .= ' WHERE ';

		foreach($where as $f => $v)
		{
			$executeValue[]	=	$v;
			$sql .= '`'.$f.'` = ? AND';
		}

		$sql	=	substr($sql,0,-3);

		try{
			$stmt =  parent::prepare($sql);
			$stmt->execute($executeValue);
		}catch(PDOException $e){
			$this->error($e->errorInfo);
		}

		return true;
	}


	/**
	 * Fügt ein Wert in eine Tabelle ein
	 *
	 * @param string $table => Tabellenname
	 * @param array $set => die Felder die beim hinzufügen gefüllt werden
	 * @return boolean
	 */
	public function insert($table, $set)
	{
		if(!is_string($table) || empty($table))
		{
			$this->error('$table ist kein string oder ist leer');
		}

		if(!is_array($set) || empty($set))
		{
			$this->error('$set ist kein array oder ist leer');
		}

		$sql			=	'INSERT INTO `'.$table.'` SET ';
		$executeValue	=	array();

		foreach($set as $field => $value)
		{
			if($value === 'NOW()')
			{
				$sql	.=	'`'.$field.'` = NOW(), ';
				continue;
			}
			elseif(preg_match('/IN/', $value) == 1)
			{
				$sql	.=	'`'.$field.'` '.$value.' AND';
				continue;
			}

			$executeValue[]	=	$value;
			$sql .= '`'.$field.'` = ?, ';
		}

		$sql	=	substr($sql,0,-2);

		try{
			$stmt =  parent::prepare($sql);
			$stmt->execute($executeValue);
		}catch(PDOException $e){
			$this->error($e->errorInfo);
			return false;
		}

		return true;
	}



	/**
	 * Löscht einen(mehrer) Datensätze aus der Datenbank
	 *
	 * @param string $table => Tabellenname
	 * @param array $where => welche Datensätze sind betroffen
	 * @param int $limit => Anzahl der zu löschenden Datensätze
	 * @return boolean
	 */
	public function delete($table, $where, $limit = 1)
	{
		if(!is_string($table) || empty($table))
		{
			$this->error('$table ist kein string oder ist leer');
		}

		if(!is_array($where) || empty($where))
		{
			$this->error('$where ist kein array oder ist leer');
		}

		$sql			=	'DELETE FROM `'.$table.'` WHERE ';
		$executeValue	=	array();

		foreach($where as $field => $value)
		{
			if(is_array($value))
			{
				$this->error('$value ist ein Array');
			}

			if($value === 'NOW()')
			{
				$sql	.=	'`'.$field.'` = NOW() AND ';
				continue;
			}
			elseif(preg_match('/IN/', $value) == 1)
			{
				$sql	.=	'`'.$field.'` '.$value.' AND';
				continue;
			}

			$executeValue[]	=	$value;
			$sql	.=	'`'.$field.'` = ? AND ';
		}

		$sql	=	substr($sql,0,-4);

		if(!empty($limit))
		{
			$sql .=	' LIMIT '.$limit;
		}

		try{
			$stmt =  parent::prepare($sql);
			$stmt->execute($executeValue);
		}catch(PDOException $e){
			$this->error($e->errorInfo);
			return false;
		}

		return true;
	}


	/**
	 * Setzt einen Fehler
	 *
	 * @param string $message
	 */
	protected function error($message)
	{
		throw new Exception($message);
	}
}
