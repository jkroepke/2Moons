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

class MissionCaseRecycling extends MissionFunctions implements Mission
{
	function __construct($Fleet)
	{
		$this->_fleet	= $Fleet;
	}
	
	function TargetEvent()
	{	
		global $pricelist, $resource;
		
		$resourceIDs	= array(901, 902, 903, 921);
		$debrisIDs		= array(901, 902);
		$resQuery		= array();
		$collectQuery	= array();
		
		$collectedGoods = array();
		foreach($debrisIDs as $debrisID)
		{
			$collectedGoods[$debrisID] = 0;
			$resQuery[]	= 'der_'.$resource[$debrisID];
		}

		$sql	= 'SELECT '.implode(',', $resQuery).', ('.implode(' + ', $resQuery).') as total
		FROM %%PLANETS%% WHERE id = :planetId';

		$targetData	= Database::get()->selectSingle($sql, array(
			':planetId'	=> $this->_fleet['fleet_end_id']
		));

		if(!empty($targetData['total']))
		{
			$sql				= 'SELECT * FROM %%USERS%% WHERE id = :userId;';
			$targetUser			= Database::get()->selectSingle($sql, array(
				':userId'	=> $this->_fleet['fleet_owner']
			));

			$targetUserFactors	= PlayerUtil::getFactors($targetUser);
			$shipStorageFactor	= 1 + $targetUserFactors['ShipStorage'];
		
			// Get fleet capacity
			$fleetData			= FleetUtil::unserialize($this->_fleet['fleet_array']);

			$recyclerStorage	= 0;
			$otherFleetStorage	= 0;

			foreach ($fleetData as $shipId => $shipAmount)
			{
				if ($shipId == 209 ||  $shipId == 219)
				{
					$recyclerStorage   += $pricelist[$shipId]['capacity'] * $shipAmount;
				}
				else
				{
					$otherFleetStorage += $pricelist[$shipId]['capacity'] * $shipAmount;
				}
			}
			
			$recyclerStorage	*= $shipStorageFactor;
			$otherFleetStorage	*= $shipStorageFactor;

			$incomingGoods		= 0;
			foreach($resourceIDs as $resourceID)
			{
				$incomingGoods	+= $this->_fleet['fleet_resource_'.$resource[$resourceID]];
			}

			$totalStorage = $recyclerStorage + min(0, $otherFleetStorage - $incomingGoods);

			$param	= array(
				':planetId'	=> $this->_fleet['fleet_end_id']
			);

			// fast way
			$collectFactor	= min(1, $totalStorage / $targetData['total']);
			foreach($debrisIDs as $debrisID)
			{
				$fleetColName	= 'fleet_resource_'.$resource[$debrisID];
				$debrisColName	= 'der_'.$resource[$debrisID];

				$collectedGoods[$debrisID]			= ceil($targetData[$debrisColName] * $collectFactor);
				$collectQuery[]						= $debrisColName.' = GREATEST(0, '.$debrisColName.' - :'.$resource[$debrisID].')';
				$param[':'.$resource[$debrisID]]	= $collectedGoods[$debrisID];

				$this->UpdateFleet($fleetColName, $this->_fleet[$fleetColName] + $collectedGoods[$debrisID]);
			}

			$sql	= 'UPDATE %%PLANETS%% SET '.implode(',', $collectQuery).' WHERE id = :planetId;';

			Database::get()->update($sql, $param);
		}
		
		$LNG		= $this->getLanguage(NULL, $this->_fleet['fleet_owner']);
		
		$Message 	= sprintf($LNG['sys_recy_gotten'], 
			pretty_number($collectedGoods[901]), $LNG['tech'][901],
			pretty_number($collectedGoods[902]), $LNG['tech'][902]
		);

		PlayerUtil::sendMessage($this->_fleet['fleet_owner'], 0, $LNG['sys_mess_tower'], 5,
			$LNG['sys_recy_report'], $Message, $this->_fleet['fleet_start_time'], NULL, 1, $this->_fleet['fleet_universe']);

		$this->setState(FLEET_RETURN);
		$this->SaveFleet();
	}
	
	function EndStayEvent()
	{
		return;
	}
	
	function ReturnEvent()
	{
		$LNG		= $this->getLanguage(NULL, $this->_fleet['fleet_owner']);

		$sql		= 'SELECT name FROM %%PLANETS%% WHERE id = :planetId;';
		$planetName	= Database::get()->selectSingle($sql, array(
			':planetId'	=> $this->_fleet['fleet_start_id'],
		), 'name');
	
		$Message	= sprintf($LNG['sys_tran_mess_owner'],
			$planetName, GetStartAdressLink($this->_fleet, ''),
			pretty_number($this->_fleet['fleet_resource_metal']), $LNG['tech'][901],
			pretty_number($this->_fleet['fleet_resource_crystal']), $LNG['tech'][902],
			pretty_number($this->_fleet['fleet_resource_deuterium']), $LNG['tech'][903]
		);

		PlayerUtil::sendMessage($this->_fleet['fleet_owner'], 0, $LNG['sys_mess_tower'], 4, $LNG['sys_mess_fleetback'],
			$Message, $this->_fleet['fleet_end_time'], NULL, 1, $this->_fleet['fleet_universe']);

		$this->RestoreFleet();
	}
}