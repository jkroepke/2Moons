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
	);
		
	function setToken($token)
	{
		$this->token	= $token;
	}
	
	function run()
	{
		require_once 'includes/classes/MissionUtil.class.php';
		$db	= Database::get();

		$sql = 'SELECT %%FLEETS%%.*
		FROM %%FLEETS_EVENT%%
		INNER JOIN %%FLEETS%% USING(fleetId)
		WHERE lockToken = :lockToken;';

		$fleetResult = $db->select($sql, array(
			':lockToken'	=> $this->token
		));

		$currentFleets	= array();

		foreach($fleetResult as $fleetRow)
		{
			if(!isset(self::$missionObjPattern[$fleetRow['fleet_mission']])) {
				$sql = 'DELETE FROM %%FLEETS%% WHERE fleetId = :fleetId;';

				$db->delete($sql, array(
					':fleetId'	=> $fleetRow['fleetId']
			  	));

				continue;
			}

			$currentFleets[$fleetRow['fleetId']]	= $fleetRow;
		}

		$currentFleets	= FleetUtil::getFleetElements($currentFleets);

		foreach($currentFleets as $fleetRow)
		{
			$missionName	= self::$missionObjPattern[$fleetRow['fleet_mission']];

			$path	= 'includes/classes/missions/'.$missionName.'.class.php';
			require_once $path;
			/** @var $missionObj AbstractMission */
			$missionObj	= new $missionName($fleetRow);
			
			switch($fleetRow['fleet_mess'])
			{
				case FLEET_OUTWARD:
					$missionObj->arrivalEndTargetEvent();
				break;
				case FLEET_RETURN:
					$missionObj->arrivalStartTargetEvent();
				break;
				case FLEET_HOLD:
					$missionObj->endStayTimeEvent();
				break;
			}

			$missionObj->saveFleet();
		}
	}
}