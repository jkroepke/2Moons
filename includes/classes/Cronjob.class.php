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

class Cronjob
{
	function __construct()
	{
		
	}
	
	static function execute($cronjobID)
	{
		$cronjobsList		= array();
		$cronjobsClassName	= $GLOBALS['DATABASE']->getFirstCell("SELECT class FROM ".CRONJOBS." WHERE isActive = 1 AND cronjobID = ".$cronjobID." AND `lock` IS NULL;");
		if(empty($cronjobsClassName))
		{
			throw new Exception("Unkown cronjob ".$cronjobID." or is deactived");
		}
		
		$GLOBALS['DATABASE']->query("UPDATE ".CRONJOBS." SET `lock` = '".md5(TIMESTAMP)."' WHERE cronjobID = ".$cronjobID.";");
		
		$cronjobsPath		= ROOT_PATH.'includes/classes/cronjob/'.$cronjobsClassName.'.class.php';
		
		// die hard, if file not exists.
		require_once($cronjobsPath);
		
		$cronjobObj			= new $cronjobsClassName;
		$cronjobObj->run();
		self::reCalculateCronjobs($cronjobID);
		$GLOBALS['DATABASE']->query("UPDATE ".CRONJOBS." SET `lock` = NULL WHERE cronjobID = ".$cronjobID.";");	
	}
	
	static function getNeedTodoExecutedJobs()
	{
		$cronjobsList	= array();
		$cronjobsRaw	= $GLOBALS['DATABASE']->query("SELECT cronjobID FROM ".CRONJOBS." WHERE isActive = 1 AND nextTime < ".TIMESTAMP." AND `lock` IS NULL;");
		while($cronjobRow = $GLOBALS['DATABASE']->fetchArray($cronjobsRaw))
		{
			$cronjobsList[]	= $cronjobRow['cronjobID'];
		}
		
		$GLOBALS['DATABASE']->free_result($cronjobsRaw);
		
		return $cronjobsList;
	}
	
	static function reCalculateCronjobs($cronjobID = NULL)
	{
		require_once ROOT_PATH.'includes/libs/Crontab/Crontab.class.php';
		$cronjobsList	= array();
		$SQL			= "";
		$where			= "";
		
		if(!empty($cronjobID))
		{
			$where	= " WHERE cronjobID = ".$cronjobID;
		}
		
		$cronjobsRaw	= $GLOBALS['DATABASE']->query("SELECT cronjobID, min, hours, dom, month, dow FROM ".CRONJOBS.$where.";");

		while($cronjobRow = $GLOBALS['DATABASE']->fetchArray($cronjobsRaw))
		{
			$cronTabString	= implode(' ', array($cronjobRow['min'], $cronjobRow['hours'], $cronjobRow['dom'], $cronjobRow['month'], $cronjobRow['dow']));
			$nextTime		= Crontab::parse($cronTabString, TIMESTAMP);
			
			$SQL			.= "UPDATE ".CRONJOBS." SET nextTime = ".$nextTime." WHERE cronjobID = ".$cronjobRow['cronjobID'].";";
		}
		
		$GLOBALS['DATABASE']->multi_query($SQL);
	}
}