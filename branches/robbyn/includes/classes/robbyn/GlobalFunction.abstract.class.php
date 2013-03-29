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
 * @info $Id$
 * @link http://2moons.cc/
 */

abstract class GlobalFunction
{
	protected $tmp, $cache, $lang, $LNG, $theme, $db, $USER, $database, $SESSION, $GeneralFunctions;

	/**
	 * Initialisiert die Template Klasse
	 *
	 * @return void
	 */
	protected function setTemplateClass()
	{
		$this->tmp	=	autoload::get('template');
	}

	/**
	 * Initialisiert die Cache Klasse
	 *
	 * @return void
	 */
	protected function setCacheClass()
	{
		$this->cache	=	autoload::get('cache');
	}


	/**
	 * Initialisiert die Language Klasse
	 *
	 * @return void
	 */
	protected function setLanguageClass()
	{
		$this->lang	=	autoload::get('Language');
	}


	/**
	 * Initialisiert die Theme Klasse
	 *
	 * @return void
	 */
	protected function setThemeClass()
	{
		$this->theme	=	autoload::get('theme');
	}


	/**
	 * Initialisiert die Datenbank Klasse
	 *
	 * @param array
	 * @return void
	 */
	protected function setDatabaseClass($database = null)
	{
		require_once 'pdo_database.class.php';

		if($database !== null)
		{
			$dsn		=	$database['typ'].':host='.$database['host'].';dbname='.$database['databasename'].';charset:utf-8';
			$this->db	=	new pdo_database($dsn, $database['user'], $database['userpw']);
		}
		else
		{
			if(!empty($this->database['typ']))
			{
				$dsn		=	$this->database['typ'].':host='.$this->database['host'].';dbname='.$this->database['databasename'].';charset:utf-8';
				$this->db	=	new pdo_database($dsn, $this->database['user'], $this->database['userpw']);
			}
		}
	}


	/**
	 * Initialisiert die Benutzerdaten
	 *
	 * @return void
	 */
	protected function setUserData()
	{
		$userID	=	(isset($_SESSION['id']) ? (int)$_SESSION['id'] : 0);

		if($userID !== 0 && is_int($userID) === true)
		{
			$this->USER	=	$this->db->quefetch('
			SELECT
				user.*,
				stat.`total_points`,
				stat.`total_rank`,
				COUNT(message.*) as messages
			FROM
				`'.USERS.'` as user
			LEFT JOIN
				'.STATPOINTS.' as stat
			ON(
				stat.`id_owner` 	= user.`id` AND
				stat.`stat_type` 	= "1"
			)
			LEFT JOIN
				`'.MESSAGES.'` as message
			ON(
				message.`message_owner` 	= user.`id` AND
				message.`message_unread` 	= "1"
			)
			WHERE
				user.`id` = '.$userID.'
			GROUP BY
				message.`message_owner`;
			');
		}
		else
		{
			$this->USER	=	array();
		}
	}


	/**
	 * Initialisiert die Language Daten
	 *
	 * @return void
	 */
	protected function setLanguageData()
	{
		$this->LNG	=	$this->lang->getLanguageVariables();
	}


	/**
	 * Initialisiert die Config Klasse
	 *
	 * @return void
	 */
	protected function setConfigClass()
	{
		autoload::get('Config');

		if(!empty($this->db) && !empty($this->USER))
		{
			Config::init($this->db);
		}
	}


	/**
	 * Initialisiert die Session Klasse
	 *
	 * @return void
	 */
	protected function setSessionClass()
	{
		$this->SESSION	=	autoload::get('session');
	}


	/**
	 * Initialisiert die GeneralFunctions Klasse
	 *
	 * @return void
	 */
	protected function setGeneralFunctionsClass()
	{
		if(empty($this->db) === false)
		{
			$this->GeneralFunctions	=	autoload::get('GeneralFunctions');
			$this->GeneralFunctions->initializeExternClass($this->db, $this->LNG, $this->USER, $this->tmp);
		}
	}


	/**
	 * Initialisiert die Datenbankdaten
	 *
	 * @return void
	 */
	protected function setDatabaseData()
	{
		$database					= array();
		$database['host']			= '';
		$database['port']			= '';
		$database['user']			= '';
		$database['userpw']			= '';
		$database['databasename']	= '';
		$database['tableprefix']	= '';
		$database['typ']			= '';

		if(is_file(ROOT.'includes'.SEP.'config.php') === true && filesize(ROOT.'includes'.SEP.'config.php') != 0)
		{
			require ROOT.'includes'.SEP.'config.php';
		}

		$this->database	=	$database;
	}


	/**
	 * Erstellt einen neuen Planeten
	 *
	 * @param int $galaxy
	 * @param int $system
	 * @param int $position
	 * @param int $universe
	 * @param int $planetOwnerID
	 * @param string $planetName
	 * @param boolean $homeWorld
	 * @param int $authLvl
	 * @return int
	 */
	protected function createOnePlanetRecord($galaxy, $system, $position, $universe, $planetOwnerID, $planetName, $homeWorld = false, $authLvl = 0)
	{
		require 'CreateOnePlanetRecord.php';

		return CreateOnePlanetRecord($galaxy, $system, $position, $universe, $planetOwnerID, $planetName, $homeWorld, $authLvl, $this->LNG, $this->GeneralFunctions, $this->db);
	}
}