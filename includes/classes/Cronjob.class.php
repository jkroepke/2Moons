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
 * @version 1.8.0 (2013-03-18)
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
		$lockToken	= md5(TIMESTAMP);

		$db	= Database::get();

		$sql = 'SELECT class FROM %%CRONJOBS%% WHERE isActive = :isActive AND cronjobID = :cronjobId AND `lock` IS NULL;';

		$cronjobClassName	= $db->selectSingle($sql, array(
			':isActive'		=> 1,
			':cronjobId'	=> $cronjobID
		), 'class');

		if(empty($cronjobClassName))
		{
			throw new Exception(sprintf("Unknown cronjob %s or cronjob is deactive!", $cronjobID));
		}
		
		$sql = 'UPDATE %%CRONJOBS%% SET `lock` = :lock WHERE cronjobID = :cronjobId;';

		$db->update($sql, array(
			':lock'			=> $lockToken,
			':cronjobId'	=> $cronjobID
		));
		
		$cronjobPath		= 'includes/classes/cronjob/'.$cronjobClassName.'.class.php';
		
		// die hard, if file not exists.
		require_once($cronjobPath);

		/** @var $cronjobObj CronjobTask */
		$cronjobObj			= new $cronjobClassName;
		$cronjobObj->run();

		self::reCalculateCronjobs($cronjobID);
		$sql = 'UPDATE %%CRONJOBS%% SET `lock` = NULL WHERE cronjobID = :cronjobId;';

		$db->update($sql, array(
			':cronjobId'	=> $cronjobID
		));

		$sql = 'INSERT INTO %%CRONJOBS_LOG%% SET `cronjobId` = :cronjobId,
		`executionTime` = :executionTime, `lockToken` = :lockToken';

		$db->insert($sql, array(
			':cronjobId'		=> $cronjobID,
			':executionTime'	=> Database::formatDate(TIMESTAMP),
			':lockToken'		=> $lockToken
		));
	}
	
	static function getNeedTodoExecutedJobs()
	{
		$sql			= 'SELECT cronjobID
		FROM %%CRONJOBS%%
		WHERE isActive = :isActive AND nextTime < :time AND `lock` IS NULL;';

		$cronjobResult	= Database::get()->select($sql, array(
			':isActive'	=> 1,
			':time'		=> TIMESTAMP
 		));

		$cronjobList	= array();

		foreach($cronjobResult as $cronjobRow)
		{
			$cronjobList[]	= $cronjobRow['cronjobID'];
		}
		
		return $cronjobList;
	}

	static function getLastExecutionTime($cronjobName)
	{
		require_once 'includes/libs/tdcron/class.tdcron.php';
		require_once 'includes/libs/tdcron/class.tdcron.entry.php';

		$sql		= 'SELECT MAX(executionTime) as executionTime FROM %%CRONJOBS_LOG%% INNER JOIN %%CRONJOBS%% USING(cronjobId) WHERE name = :cronjobName;';
		$lastTime	= Database::get()->selectSingle($sql, array(
			':cronjobName' => $cronjobName
		), 'executionTime');

		if(empty($lastTime))
		{
			return false;
		}

		return strtotime($lastTime);
	}
	
	static function reCalculateCronjobs($cronjobID = NULL)
	{
		require_once 'includes/libs/tdcron/class.tdcron.php';
		require_once 'includes/libs/tdcron/class.tdcron.entry.php';

		$db	= Database::get();

		if(!empty($cronjobID))
		{
			$sql			= 'SELECT cronjobID, min, hours, dom, month, dow FROM %%CRONJOBS%% WHERE cronjobID = :cronjobId;';
			$cronjobResult	= $db->select($sql, array(
				':cronjobId' => $cronjobID
			));
		}
		else
		{
			$sql			= 'SELECT cronjobID, min, hours, dom, month, dow FROM %%CRONJOBS%%;';
			$cronjobResult	= $db->select($sql);
		}

		$sql = 'UPDATE %%CRONJOBS%% SET nextTime = :nextTime WHERE cronjobID = :cronjobId;';

		foreach($cronjobResult as $cronjobRow)
		{
			$cronTabString	= implode(' ', array($cronjobRow['min'], $cronjobRow['hours'], $cronjobRow['dom'], $cronjobRow['month'], $cronjobRow['dow']));
			$nextTime		= tdCron::getNextOccurrence($cronTabString, TIMESTAMP + 60);

			$db->update($sql, array(
				':nextTime'		=> $nextTime,
				':cronjobId'	=> $cronjobRow['cronjobID'],
			));
		}
	}
}