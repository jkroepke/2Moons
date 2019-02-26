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

require_once 'includes/classes/cronjob/CronjobTask.interface.php';

class ReferralCronJob implements CronjobTask
{
	function run()
	{		
		if(Config::get(ROOT_UNI)->ref_active != 1)
		{
			return null;
		}
		/** @var $langObjects Language[] */
		$langObjects	= array();

		$db	= Database::get();

		$sql	= 'SELECT user.`username`, user.`ref_id`, user.`id`, ref_users.`lang`, user.`universe`
		FROM %%USERS%% user
		INNER JOIN %%USERS%% as ref_users
		ON ref_users.`id` = user.`ref_id`
		INNER JOIN %%STATPOINTS%% as stats
		ON stats.`id_owner` = user.`id` AND stats.`stat_type` = :type AND stats.`total_points` >= :points
		WHERE user.`ref_bonus` = 1;';

		$userArray	= $db->select($sql, array(
			':type'		=> 1,
			':points'	=> Config::get(ROOT_UNI)->ref_minpoints
		));

		foreach($userArray as $user)
		{
			if(!isset($langObjects[$user['lang']]))
			{
				$langObjects[$user['lang']]	= new Language($user['lang']);
				$langObjects[$user['lang']]->includeData(array('L18N', 'INGAME', 'TECH', 'CUSTOM'));
			}

			$userConfig	= Config::get($user['universe']);
			
			$LNG	= $langObjects[$user['lang']];
			$sql	= 'UPDATE %%USERS%% SET `darkmatter` = `darkmatter` + :bonus WHERE `id` = :userId;';

			$db->update($sql, array(
				':bonus'	=> $userConfig->ref_bonus,
				':userId'	=> $user['ref_id']
			));

			$sql	= 'UPDATE %%USERS%% SET `ref_bonus` = 0 WHERE `id` = :userId;';

			$db->update($sql, array(
				':userId'	=> $user['id']
			));

			$Message	= sprintf($LNG['sys_refferal_text'], $user['username'], pretty_number($userConfig->ref_minpoints), pretty_number($userConfig->ref_bonus), $LNG['tech'][921]);
			PlayerUtil::sendMessage($user['ref_id'], 0, $LNG['sys_refferal_from'], 4, sprintf($LNG['sys_refferal_title'], $user['username']), $Message, TIMESTAMP);
		}

		return true;
	}
}
