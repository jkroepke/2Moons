<?php

/**
 *  2Moons 
 *   by Jan-Otto Kröpke 2009-2016
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan-Otto Kröpke <slaver7@gmail.com>
 * @copyright 2009 Lucky
 * @copyright 2016 Jan-Otto Kröpke <slaver7@gmail.com>
 * @licence MIT
 * @version 1.8.0
 * @link https://github.com/jkroepke/2Moons
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