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

class MissionCaseStay extends AbstractMission
{
	public function arrivalEndTargetEvent()
	{
		$sql			= 'SELECT * FROM %%USERS%% WHERE id = :userId;';
		$senderUser		= Database::get()->selectSingle($sql, array(
			':userId'	=> $this->fleetData['fleet_owner']
		));

		$senderUser['factor']	= PlayerUtil::getFactors($senderUser, $this->fleetData['fleet_start_time']);
		
		$fleetArray		= FleetUtil::unserialize($this->fleetData['fleet_array']);
		$duration		= $this->fleetData['fleet_start_time'] - $this->fleetData['start_time'];

		$distance		= FleetUtil::GetTargetDistance(
			array($this->fleetData['fleet_start_galaxy'], $this->fleetData['fleet_start_system'], $this->fleetData['fleet_start_planet']),
			array($this->fleetData['fleet_end_galaxy'], $this->fleetData['fleet_end_system'], $this->fleetData['fleet_end_planet'])
		);
		
		$consumption	= FleetUtil::GetFleetConsumption($fleetArray, $duration, $distance, $senderUser, FleetUtil::GetGameSpeedFactor());

		foreach($consumption as $resourceElementId => $value)
		{
			if(!isset($this->fleetData['elements'][Vars::CLASS_RESOURCE][$resourceElementId]))
			{
				$this->fleetData['elements'][Vars::CLASS_RESOURCE][$resourceElementId]	= 0;
			}

			$this->fleetData['elements'][Vars::CLASS_RESOURCE][$resourceElementId]	+= $value / 2;
		}

		$LNG	= $this->getLanguage($senderUser['lang']);
		$resourceList	= array();
		foreach($this->fleetData['elements'][Vars::CLASS_RESOURCE] as $resourceElementId => $value)
		{
			$resourceList[$LNG['tech'][$resourceElementId]]	= $value;
		}

		$playerMessage	= sprintf($LNG['sys_stat_mess'],
			GetTargetAdressLink($this->fleetData, ''),
			Language::createHumanReadableList($resourceList)
		);

		PlayerUtil::sendMessage($this->fleetData['fleet_target_owner'], 0, $LNG['sys_mess_tower'], 5,
			$LNG['sys_stat_mess_stay'], $playerMessage, $this->fleetData['fleet_start_time'], NULL, 1, $this->fleetData['fleet_universe']);

		$this->arrivalTo($this->fleetData['fleet_end_id'],
			$this->fleetData['elements'][Vars::CLASS_FLEET], $this->fleetData['elements'][Vars::CLASS_RESOURCE]);
	}
	
	public function arrivalStartTargetEvent()
	{
		$sql		= 'SELECT name, lang FROM %%PLANETS%% INNER JOIN %%USERS%% ON id = id_owner WHERE id = :planetId;';
		$userData	= Database::get()->selectSingle($sql, array(
			':planetId'	=> $this->fleetData['fleet_start_id'],
		));

		$LNG		= $this->getLanguage($userData['language']);

		$resourceList	= array();
		foreach($this->fleetData['elements'][Vars::CLASS_RESOURCE] as $resourceElementId => $value)
		{
			$resourceList[$LNG['tech'][$resourceElementId]]	= $value;
		}

		$playerMessage	= sprintf($LNG['sys_stat_mess'],
			GetStartAdressLink($this->fleetData, ''),
			Language::createHumanReadableList($resourceList)
		);

		PlayerUtil::sendMessage($this->fleetData['fleet_owner'], 0, $LNG['sys_mess_tower'], 4, $LNG['sys_mess_fleetback'],
			$playerMessage, $this->fleetData['fleet_end_time'], NULL, 1, $this->fleetData['fleet_universe']);

		$this->arrivalTo($this->fleetData['fleet_start_id'],
			$this->fleetData['elements'][Vars::CLASS_FLEET], $this->fleetData['elements'][Vars::CLASS_RESOURCE]);
	}
}