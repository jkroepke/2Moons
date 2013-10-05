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

class MissionCaseRecycling extends AbstractMission
{
	public function arrivalEndTargetEvent()
	{
		$debrisElements		= Vars::getElements(Vars::CLASS_RESOURCE, Vars::FLAG_DEBRIS);

		$resQuery		= array();
		$collectQuery	= array();
		
		$collectedGoods = array();
		foreach($debrisElements as $debrisElementId => $debrisElementObj)
		{
			$collectedGoods[$debrisElementId] = 0;
			$resQuery[]	= 'der_'.$debrisElementObj->name;
		}

		$sql	= 'SELECT '.implode(',', $resQuery).', ('.implode(' + ', $resQuery).') as total
		FROM %%PLANETS%% WHERE id = :planetId';

		$targetData	= Database::get()->selectSingle($sql, array(
			':planetId'	=> $this->fleetData['fleet_end_id']
		));

		if(!empty($targetData['total']))
		{
			$sql				= 'SELECT * FROM %%USERS%% WHERE id = :userId;';
			$targetUser			= Database::get()->selectSingle($sql, array(
				':userId'	=> $this->fleetData['fleet_owner']
			));

			$targetUserFactors	= PlayerUtil::getFactors($targetUser);
			$shipStorageFactor	= 1 + $targetUserFactors['ShipStorage'];
		
			// Get fleet capacity
			$fleetData			= $this->fleetData['elements'][Vars::CLASS_FLEET];

			$recyclerStorage	= 0;
			$otherFleetStorage	= 0;

			foreach ($fleetData as $recyclerElementId => $shipAmount)
			{
				$recyclerElementObj	= Vars::getElement($recyclerElementId);

				if ($recyclerElementObj->hasFlag(Vars::FLAG_DEBRIS))
				{
					$recyclerStorage   += $recyclerElementObj->capacity * $shipAmount;
				}
				else
				{
					$otherFleetStorage += $recyclerElementObj->capacity * $shipAmount;
				}
			}
			
			$recyclerStorage	*= $shipStorageFactor;
			$otherFleetStorage	*= $shipStorageFactor;

			$incomingGoods		= array_sum($this->fleetData['elements'][Vars::CLASS_RESOURCE]);
			$totalStorage		= $recyclerStorage + min(0, $otherFleetStorage - $incomingGoods);

			$param	= array(
				':planetId'	=> $this->fleetData['fleet_end_id']
			);

			// fast way
			$collectFactor	= min(1, $totalStorage / $targetData['total']);
			foreach($debrisElements as $debrisElementId => $debrisElementObj)
			{
				$debrisColName	= 'der_'.$debrisElementObj->name;

				$collectedGoods[$debrisElementId]	= ceil($targetData[$debrisColName] * $collectFactor);
				$collectQuery[]						= $debrisColName.' = GREATEST(0, '.$debrisColName.' - :'.$debrisElementObj->name.')';
				$param[':'.$debrisElementObj->name]	= $collectedGoods[$debrisElementId];

				if(!isset($this->fleetData['elements'][Vars::CLASS_RESOURCE][$debrisElementId]))
				{
					$this->fleetData['elements'][Vars::CLASS_RESOURCE][$debrisElementId]	= 0;
				}

				$this->fleetData['elements'][Vars::CLASS_RESOURCE][$debrisElementId]	+= $collectedGoods[$debrisElementId];
			}

			$sql	= 'UPDATE %%PLANETS%% SET '.implode(',', $collectQuery).' WHERE id = :planetId;';

			Database::get()->update($sql, $param);
		}
		
		$LNG		= $this->getLanguage(NULL, $this->fleetData['fleet_owner']);

		$resourceList	= array();
		foreach($collectedGoods as $resourceElementId => $value)
		{
			$resourceList[$LNG['tech'][$resourceElementId]]	= $value;
		}

		$playerMessage 	= sprintf($LNG['sys_recy_gotten'], Language::createHumanReadableList($resourceList));

		PlayerUtil::sendMessage($this->fleetData['fleet_owner'], 0, $LNG['sys_mess_tower'], 5,
			$LNG['sys_recy_report'], $playerMessage, $this->fleetData['fleet_start_time'], NULL, 1, $this->fleetData['fleet_universe']);

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

		$playerMessage 	= sprintf(
			$LNG['sys_tran_mess_owner'],
			$userData['name'],
			GetTargetAdressLink($this->fleetData, ''),
			Language::createHumanReadableList($resourceList)
		);

		PlayerUtil::sendMessage($this->fleetData['fleet_owner'], 0, $LNG['sys_mess_tower'], 4, $LNG['sys_mess_fleetback'],
			$playerMessage, $this->fleetData['fleet_end_time'], NULL, 1, $this->fleetData['fleet_universe']);

		$this->arrivalTo($this->fleetData['fleet_start_id'],
			$this->fleetData['elements'][Vars::CLASS_FLEET], $this->fleetData['elements'][Vars::CLASS_RESOURCE]);
	}
}