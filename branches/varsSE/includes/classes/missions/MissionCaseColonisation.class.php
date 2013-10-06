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

class MissionCaseColonisation extends AbstractMission
{
	public function arrivalEndTargetEvent()
	{
		$db		= Database::get();

		$sql	= 'SELECT * FROM %%USERS%% WHERE `id` = :userId;';

		$senderUser		= $db->selectSingle($sql, array(
			':userId'	=> $this->fleetData['fleet_owner'],
		));

		$senderUser['factor']	= PlayerUtil::getFactors($senderUser, $this->fleetData['fleet_start_time']);

		$LNG	= $this->getLanguage($senderUser['lang']);

		$isPositionFree	= PlayerUtil::checkPosition($this->fleetData['fleet_universe'], $this->fleetData['fleet_end_galaxy'],
			$this->fleetData['fleet_end_system'], $this->fleetData['fleet_end_planet']);

		if (!$isPositionFree)
		{
			$message = sprintf($LNG['sys_colo_notfree'], GetTargetAdressLink($this->fleetData, ''));
		}
		else
		{
			$allowPlanetPosition	= PlayerUtil::allowPlanetPosition($this->fleetData['fleet_end_planet'], $senderUser);
			if(!$allowPlanetPosition)
			{
				$message = sprintf($LNG['sys_colo_notech'] , GetTargetAdressLink($this->fleetData, ''));
			}
			else
			{
				$sql	= 'SELECT COUNT(*) as state
				FROM %%PLANETS%%
				WHERE `id_owner`	= :userId
				AND `planet_type`	= :type
				AND `destroyed`		= :destroyed;';

				$currentPlanetCount	= $db->selectSingle($sql, array(
					':userId'		=> $this->fleetData['fleet_owner'],
					':type'			=> 1,
					':destroyed'	=> 0
				), 'state');

				$maxPlanetCount		= PlayerUtil::maxPlanetCount($senderUser);

				if($currentPlanetCount >= $maxPlanetCount)
				{
					$message = sprintf($LNG['sys_colo_maxcolo'], GetTargetAdressLink($this->fleetData, ''), $maxPlanetCount);
				}
				else
				{
					$newPlanetId = PlayerUtil::createPlanet($this->fleetData['fleet_end_galaxy'], $this->fleetData['fleet_end_system'],
						$this->fleetData['fleet_end_planet'], $senderUser['universe'], $this->fleetData['fleet_owner'],
						$LNG['fcp_colony'], false, $senderUser['authlevel']);

					if($newPlanetId === false)
					{
						$message = sprintf($LNG['sys_colo_badpos'], GetTargetAdressLink($this->fleetData, ''));
					}
					else
					{
						$message = sprintf($LNG['sys_colo_allisok'], GetTargetAdressLink($this->fleetData, ''));
						if (array_sum($this->fleetData['elements'][Vars::CLASS_FLEET]) == 1)
						{
							$this->killFleet();
						}
						else
						{
							foreach(array_keys(Vars::getElements(Vars::CLASS_FLEET, Vars::FLAG_COLONIZE)) as $elementShipId)
							{
								if(isset($this->fleetData['elements'][Vars::CLASS_FLEET][$elementShipId]))
								{
									if($this->fleetData['elements'][Vars::CLASS_FLEET][$elementShipId] == 1)
									{
										unset($this->fleetData['elements'][Vars::CLASS_FLEET][$elementShipId]);
									}
									else
									{
										$this->fleetData['elements'][Vars::CLASS_FLEET][$elementShipId] -= 1;
									}
									break;
								}
							}
						}

						$this->arrivalTo($newPlanetId, array(), $this->fleetData['elements'][Vars::CLASS_RESOURCE]);
						$this->fleetData['elements'][Vars::CLASS_RESOURCE]	= array();
					}
				}
			}
		}

		PlayerUtil::sendMessage($this->fleetData['fleet_owner'], 0, $LNG['sys_colo_mess_from'], 4, $LNG['sys_colo_mess_report'],
			$message, $this->fleetData['fleet_start_time'], NULL, 1, $this->fleetData['fleet_universe']);

		$this->setNextState(FLEET_RETURN);
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