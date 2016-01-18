<?php

/**
 *  2Moons
 *  Copyright (C) 2011 Jan Kröpke
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2009 Lucky
 * @copyright 2011 Jan Kröpke <info@2moons.cc>
 * @licence MIT
 * @version 1.7.0 (2011-12-10)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

require_once 'includes/classes/cronjob/CronjobTask.interface.php';

class CleanerCronjob implements CronjobTask
{
	function run()
	{
        $config	= Config::get(ROOT_UNI);

		$unis	= Universe::availableUniverses();
	
		//Delete old messages
		$del_before 	= TIMESTAMP - ($config->del_oldstuff * 86400);
		$del_inactive 	= TIMESTAMP - ($config->del_user_automatic * 86400);
		$del_deleted 	= TIMESTAMP - ($config->del_user_manually * 86400);

		if($del_inactive === TIMESTAMP)
		{
			$del_inactive = 2147483647;
		}

		$sql	= 'DELETE FROM %%MESSAGES%% WHERE `message_time` < :time;';
		Database::get()->delete($sql, array(
			':time'	=> $del_before
		));

		$sql	= 'DELETE FROM %%ALLIANCE%% WHERE `ally_members` = 0;';
		Database::get()->delete($sql);

		$sql	= 'DELETE FROM %%PLANETS%% WHERE `destruyed` < :time AND `destruyed` != 0;';
		Database::get()->delete($sql, array(
			':time'	=> TIMESTAMP
		));

		$sql	= 'DELETE FROM %%SESSION%% WHERE `lastonline` < :time;';
		Database::get()->delete($sql, array(
			':time'	=> TIMESTAMP - SESSION_LIFETIME
		));

		$sql	= 'DELETE FROM %%FLEETS_EVENT%% WHERE fleetID NOT IN (SELECT fleet_id FROM %%FLEETS%%);';
		Database::get()->delete($sql);

		$sql	= 'UPDATE %%USERS%% SET `email_2` = `email` WHERE `setmail` < :time;';
		Database::get()->update($sql, array(
			':time'	=> TIMESTAMP
		));

		$sql	= 'SELECT `id` FROM %%USERS%% WHERE `authlevel` = :authlevel
		AND ((`db_deaktjava` != 0 AND `db_deaktjava` < :timeDeleted) OR `onlinetime` < :timeInactive);';

		$deleteUserIds = Database::get()->select($sql, array(
			':authlevel'	=> AUTH_USR,
			':timeDeleted'	=> $del_deleted,
			':timeInactive'	=> $del_inactive
		));

		if(empty($deleteUserIds))
		{
			foreach($deleteUserIds as $dataRow)
			{
				PlayerUtil::deletePlayer($dataRow['id']);
			}	
		}
		
		foreach($unis as $uni)
		{
			$sql	= 'SELECT units FROM %%TOPKB%% WHERE `universe` = :universe ORDER BY units DESC LIMIT 99,1;';

			$battleHallLowest	= Database::get()->selectSingle($sql, array(
				':universe'	=> $uni
			),'units');

			if(!is_null($battleHallLowest))
			{
				$sql	= 'DELETE %%TOPKB%%, %%TOPKB_USERS%%
				FROM %%TOPKB%%
				INNER JOIN %%TOPKB_USERS%% USING (rid)
				WHERE `universe` = :universe AND `units` < :battleHallLowest;';

				Database::get()->delete($sql, array(
					':universe'			=> $uni,
					':battleHallLowest'	=> $battleHallLowest
				));
			}
		}

		$sql	= 'DELETE FROM %%RW%% WHERE `time` < :time AND `rid` NOT IN (SELECT `rid` FROM %%TOPKB%%);';
		Database::get()->delete($sql, array(
			':time'	=> $del_before
		));
	}
}