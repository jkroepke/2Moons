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

class MissionCaseTransport extends AbstractMission
{
	
	public function arrivalEndTargetEvent()
	{
		$sql	= 'SELECT name, lang FROM %%PLANETS%% INNER JOIN %%USERS%% ON id = id_owner WHERE id = :planetId;';

		$targetUserData	= Database::get()->selectSingle($sql, array(
			':planetId'	=> $this->fleetData['fleet_end_id']
		));
		
		$LNG			= $this->getLanguage($targetUserData['lang']);

		$resourceList	= array();
		foreach($this->fleetData['elements'][Vars::CLASS_RESOURCE] as $resourceElementId => $value)
		{
			$resourceList[$LNG['tech'][$resourceElementId]]	= $value;
		}

		$playerMessage		= sprintf($LNG['sys_tran_mess_owner'],
			$targetUserData['name'], GetTargetAdressLink($this->fleetData, ''),
			Language::createHumanReadableList($resourceList)
		);

		PlayerUtil::sendMessage($this->fleetData['fleet_owner'], 0, $LNG['sys_mess_tower'], 5,
			$LNG['sys_mess_transport'], $playerMessage, $this->fleetData['fleet_start_time'], NULL, 1, $this->fleetData['fleet_universe']);

		if ($this->fleetData['fleet_target_owner'] != $this->fleetData['fleet_owner'])
		{
			$startUserData	= Database::get()->selectSingle($sql, array(
				':planetId'	=> $this->fleetData['fleet_start_id'],
			));

			if($startUserData['lang'] != $targetUserData['lang'])
			{
				$LNG			= $this->getLanguage($targetUserData['lang']);

				$resourceList	= array();
				foreach($this->fleetData['elements'][Vars::CLASS_RESOURCE] as $resourceElementId => $value)
				{
					$resourceList[$LNG['tech'][$resourceElementId]]	= $value;
				}
			}

			$playerMessage        = sprintf($LNG['sys_tran_mess_user'],
				$startUserData['name'], GetStartAdressLink($this->fleetData, ''),
				$targetUserData['name'], GetTargetAdressLink($this->fleetData, ''),
				Language::createHumanReadableList($resourceList)
			);

			PlayerUtil::sendMessage($this->fleetData['fleet_target_owner'], 0, $LNG['sys_mess_tower'], 5,
				$LNG['sys_mess_transport'], $playerMessage, $this->fleetData['fleet_start_time'], NULL, 1, $this->fleetData['fleet_universe']);
		}

		$this->arrivalTo($this->fleetData['fleet_end_id'],
			array(), $this->fleetData['elements'][Vars::CLASS_RESOURCE]);

		$this->setNextState(FLEET_RETURN);
	}
	
	public function arrivalStartTargetEvent()
	{
		$sql		= 'SELECT name, lang FROM %%PLANETS%% INNER JOIN %%USERS%% ON id = id_owner WHERE id = :planetId;';
		$userData	= Database::get()->selectSingle($sql, array(
			':planetId'	=> $this->fleetData['fleet_start_id'],
		));

		$LNG		= $this->getLanguage($userData['language']);

		$playerMessage	= sprintf($LNG['sys_tran_mess_back'], $userData['name'], GetStartAdressLink($this->fleetData, ''));

		PlayerUtil::sendMessage($this->fleetData['fleet_owner'], 0, $LNG['sys_mess_tower'], 4, $LNG['sys_mess_fleetback'],
			$playerMessage, $this->fleetData['fleet_end_time'], NULL, 1, $this->fleetData['fleet_universe']);

		$this->arrivalTo($this->fleetData['fleet_start_id'],
			$this->fleetData['elements'][Vars::CLASS_FLEET], $this->fleetData['elements'][Vars::CLASS_RESOURCE]);
	}
}