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
 * @version 1.7.0 (2012-12-31)
 * @info $Id$
 * @link http://2moons.cc/
 */

if ($USER['authlevel'] == AUTH_USR)
{
	throw new PagePermissionException("Permission error!");
}

function ShowDumpPage()
{
	global $LNG;
	switch($_REQUEST['action'])
	{
		case 'dump':
			$dbTables	= HTTP::_GP('dbtables', array());
			if(empty($dbTables)) {
				$template	= new template();
				$template->message($LNG['du_not_tables_selected']);
				exit;
			}
			$fileName	= '2MoonsBackup_'.date('d_m_Y_H_i_s', TIMESTAMP).'.sql';
			$filePath	= ROOT_PATH.'includes/backups/'.$fileName;
			if(function_exists('shell_exec') && function_exists('escapeshellarg') && shell_exec('mysqldump') !== NULL)
			{
				$dbTables	= array_map('escapeshellarg', $dbTables);
				
				require ROOT_PATH.'includes/config.php';
				
				$sqlDump	= shell_exec("mysqldump --host='".escapeshellarg($database['host'])."' --port=".((int) $database['port'])." --user='".escapeshellarg($database['user'])."' --password='".escapeshellarg($database['userpw'])."' --no-create-db --order-by-primary --add-drop-table --comments --complete-insert --hex-blob '".escapeshellarg($database['databasename'])."' '".implode(' ', $dbTables)."' 2>&1 1> ".$filePath);
				if(strlen($sqlDump) !== 0) #mysqldump error
				{
					throw new Exception($sqlDump);
				}
			}
			else
			{
				$intergerTypes	= array('tinyint', 'smallint', 'mediumint', 'int', 'bigint', 'decimal', 'float', 'double', 'real');
				set_time_limit(600); // 10 Minutes
				$gameVersion	= Config::get('VERSION');
				$serverVersion	= $GLOBALS['DATABASE']->getServerVersion();
				$fp	= fopen($filePath, 'w');
				fwrite($fp, "-- MySQL dump | 2Moons dumper v{$gameVersion}
--
-- Host: {$database['host']}    Database: {$database['databasename']}
-- ------------------------------------------------------
-- Server version       5.5.28-0ubuntu0.12.04.3-log

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
					$columsData	= $GLOBALS['DATABASE']->query("SHOW COLUMNS FROM ".$dbTable);

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
					
					fwrite($fp, "INSERT INTO `{$dbTable}` (`".implode("`, `", $columNames)."`) VALUES\r\n");
						
					$tableData	= $GLOBALS['DATABASE']->query("SELECT * FROM ".$dbTable);
					while($tableRow = $GLOBALS['DATABASE']->fetchArray($tableData))
					{
						$rowData = array();
					
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
			
			$template	= new template();
			$template->message(sprintf($LNG['du_success'], 'includes/backups/'.$fileName));
		break;
		default:
			$dumpData['perRequest']		= 100;

			$dumpData		= array();

			$prefixCounts	= strlen(DB_PREFIX);

			$dumpData['sqlTables']	= array();
			$sqlTableRaw			= $GLOBALS['DATABASE']->query("SHOW TABLE STATUS FROM ".DB_NAME.";");

			while($table = $GLOBALS['DATABASE']->fetchArray($sqlTableRaw))
			{
				if(DB_PREFIX == substr($table['Name'], 0, $prefixCounts))
				{
					$dumpData['sqlTables'][]	= $table['Name'];
				}
			}

			$template	= new template();

			$template->assign_vars(array(	
				'dumpData'	=> $dumpData,
			));
			
			$template->show('DumpPage.tpl');
		break;
	}
}