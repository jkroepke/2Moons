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

class FlyingFleetHandler
{
	protected $token;

	public static $missionObjPattern	= array(
		1	=> 'MissionCaseAttack',
		2	=> 'MissionCaseACS',
		3	=> 'MissionCaseTransport',
		4	=> 'MissionCaseStay',
		5	=> 'MissionCaseStayAlly',
		6	=> 'MissionCaseSpy',
		7	=> 'MissionCaseColonisation',
		8	=> 'MissionCaseRecycling',
		9	=> 'MissionCaseDestruction',
		10	=> 'MissionCaseMIP',
		11	=> 'MissionCaseFoundDM',
		15	=> 'MissionCaseExpedition',
		16	=> 'MissionCaseTrade',
	);

	function setToken($token)
	{
		$this->token	= $token;
	}

	function run()
	{
		require_once 'includes/classes/class.MissionFunctions.php';
		require_once 'includes/classes/missions/Mission.interface.php';

		$db	= Database::get();

		$sql = 'SELECT %%FLEETS%%.*
		FROM %%FLEETS_EVENT%%
		INNER JOIN %%FLEETS%% ON fleetID = fleet_id
		WHERE `lock` = :token;';

		$fleetResult = $db->select($sql, array(
			':token'	=> $this->token
		));

		foreach($fleetResult as $fleetRow)
		{
			if(!isset(self::$missionObjPattern[$fleetRow['fleet_mission']])) {
				$sql = 'DELETE FROM %%FLEETS%% WHERE fleet_id = :fleetId;';

				$db->delete($sql, array(
					':fleetId'	=> $fleetRow['fleet_id']
			  	));

				continue;
			}

			$missionName	= self::$missionObjPattern[$fleetRow['fleet_mission']];

			$path	= 'includes/classes/missions/'.$missionName.'.class.php';
			require_once $path;
			/** @var $missionObj Mission */
			$missionObj	= new $missionName($fleetRow);

			switch($fleetRow['fleet_mess'])
			{
				case 0:
					$missionObj->TargetEvent();
				break;
				case 1:
					$missionObj->ReturnEvent();
				break;
				case 2:
					$missionObj->EndStayEvent();
				break;
			}
		}
	}
}
