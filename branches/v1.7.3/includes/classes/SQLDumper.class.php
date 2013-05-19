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
 * @version 1.7.3 (2013-05-19)
 * @info $Id$
 * @link http://2moons.cc/
 */

class SQLDumper
{	
	public function dumpTablesToFile($dbTables, $filePath)
	{
		if($this->canNative('mysqldump'))
		{
			return $this->nativeDumpToFile($dbTables, $filePath);
		}
		else
		{
			return $this->softwareDumpToFile($dbTables, $filePath);
		}
	}
	
	private function setTimelimit()
	{
		@set_time_limit(600); // 10 Minutes
	}
		
	private function canNative($command)
	{
		return function_exists('shell_exec') && function_exists('escapeshellarg') && shell_exec($command) !== NULL;
	}
	
	private function nativeDumpToFile($dbTables, $filePath)
	{
		require 'includes/config.php';
		$dbTables	= array_map('escapeshellarg', $dbTables);
		$sqlDump	= shell_exec("mysqldump --host='".escapeshellarg($database['host'])."' --port=".((int) $database['port'])." --user='".escapeshellarg($database['user'])."' --password='".escapeshellarg($database['userpw'])."' --no-create-db --order-by-primary --add-drop-table --comments --complete-insert --hex-blob '".escapeshellarg($database['databasename'])."' ".implode(' ', $dbTables)." 2>&1 1> ".$filePath);
		if(strlen($sqlDump) !== 0) #mysqldump error
		{
			throw new Exception($sqlDump);
		}
	}
	
	private function softwareDumpToFile($dbTables, $filePath)
	{
		$this->setTimelimit();
		require 'includes/config.php';
		$intergerTypes	= array('tinyint', 'smallint', 'mediumint', 'int', 'bigint', 'decimal', 'float', 'double', 'real');
		$gameVersion	= Config::get('VERSION');
		$serverVersion	= $GLOBALS['DATABASE']->getServerVersion();
		$fp	= fopen($filePath, 'w');
		fwrite($fp, "-- MySQL dump | 2Moons dumper v{$gameVersion}
--
-- Host: {$database['host']}    Database: {$database['databasename']}
-- ------------------------------------------------------
-- Server version       {$serverVersion}

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

");

		foreach($dbTables as $dbTable)
		{
			$columNames	= array();
			$numColums	= array();
			$firstRow	= true;
			
			fwrite($fp, "--
-- Table structure for table `{$dbTable}`
--

DROP TABLE IF EXISTS `{$dbTable}`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;

");
			$createTable	= $GLOBALS['DATABASE']->getFirstRow("SHOW CREATE TABLE ".$dbTable);
			fwrite($fp, $createTable['Create Table'].';');
			fwrite($fp, "
			
/*!40101 SET character_set_client = @saved_cs_client */;");
			if($GLOBALS['DATABASE']->getFirstCell("SELECT COUNT(*) FROM ".$dbTable.";") == 0)
			{
			fwrite($fp, "
			
--
-- No data for table `{$dbTable}`
--

");
				continue;
			}
			fwrite($fp, "
			
--
-- Dumping data for table `{$dbTable}`
--

LOCK TABLES `{$dbTable}` WRITE;
/*!40000 ALTER TABLE `{$dbTable}` DISABLE KEYS */;

");
			$columsData	= $GLOBALS['DATABASE']->query("SHOW COLUMNS FROM `".$dbTable."`");

			$columNames	= array();
			while($columData = $GLOBALS['DATABASE']->fetchArray($columsData))
			{
				$columNames[]	= $columData['Field'];
				foreach($intergerTypes as $type)
				{
					if(strpos($columData['Type'], $type.'(') !== false)
					{
						$numColums[]	= $columData['Field'];
						break;
					}
				}
			}
			$GLOBALS['DATABASE']->free_result($columsData);
			
			
			$insertInto	= "INSERT INTO `{$dbTable}` (`".implode("`, `", $columNames)."`) VALUES\r\n";
			
			fwrite($fp, $insertInto);
			$i = 0;
			$tableData	= $GLOBALS['DATABASE']->query("SELECT * FROM ".$dbTable);
			while($tableRow = $GLOBALS['DATABASE']->fetchArray($tableData))
			{
				$rowData = array();
				$i++;
				if(($i % 50) === 0)
				{
					$firstRow	= true;
					fwrite($fp, ";\r\n");
					fwrite($fp, $insertInto);
				}
				
				if(!$firstRow)
				{
					fwrite($fp, ",\r\n");
				}
				else
				{
					$firstRow = false;
				}
				
				foreach($tableRow as $colum => $value)
				{
					if(in_array($colum, $numColums))
					{
						$rowData[]	= $value === NULL ? 'NULL' : $value;
					}
					else
					{
						$rowData[]	= $value === NULL ? 'NULL' : "'".$GLOBALS['DATABASE']->escape($value)."'";
					}
				}
				fwrite($fp, "(".implode(", ",$rowData).")");
			}
			$GLOBALS['DATABASE']->free_result($tableData);
			fwrite($fp, ";
			
/*!40000 ALTER TABLE `{$dbTable}` ENABLE KEYS */;
UNLOCK TABLES;

");
		}
		fwrite($fp, "/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on ".date("Y-d-m H:i:s"));
		fclose($fp);
	}
	
	public function restoreDatabase($filePath)
	{
		// Ugly.
		$this->setTimelimit();
		
		if($this->canNative('mysql'))
		{
		
			$sqlDump	= shell_exec("mysql --host='".escapeshellarg($database['host'])."' --port=".((int) $database['port'])." --user='".escapeshellarg($database['user'])."' --password='".escapeshellarg($database['userpw'])."' '".escapeshellarg($database['databasename'])."' < ".escapeshellarg($filePath)." 2>&1 1> /dev/null");
			if(strlen($sqlDump) !== 0) #mysql error
			{
				throw new Exception($sqlDump);
			}
		}
		else
		{
			$backupQuery	= explode(";\r\n", file_get_contents($filePath));
			foreach($backupQuery as $query)
			{
				$GLOBALS['DATABASE']->multi_query($query);
			}
		}
	}
}