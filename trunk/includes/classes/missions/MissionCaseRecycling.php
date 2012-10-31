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
 * @version 1.7.0 (2012-12-31)
 * @info $Id$
 * @link http://2moons.cc/
 */

class MissionCaseRecycling extends MissionFunctions
{
	function __construct($Fleet)
	{
		$this->_fleet	= $Fleet;
	}
	
	function TargetEvent()
	{	
		global $pricelist, $LANG, $reslist, $resource;
		
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
		
		$targetData	= $GLOBALS['DATABASE']->getFirstRow("SELECT ".implode(',', $resQuery).", (".implode(' + ', $resQuery).") as total FROM ".PLANETS." WHERE id = ".$this->_fleet['fleet_end_id'].";");
		if(isset($targetData))
		{
			$targetUser			= $GLOBALS['DATABASE']->getFirstRow("SELECT * FROM ".USERS." WHERE id = ".$this->_fleet['fleet_owner'].";");
			$targetUserFactors	= getFactors($targetUser);
			$shipStorageFactor	= 1 + $targetUserFactors['ShipStorage'];
		
			// Get fleet capacity
			$fleetData	= explode(";", $this->_fleet['fleet_array']);

			$recyclerStorage	= 0;
			$otherFleetStorage	= 0;
			
			foreach ($fleetData as $fleetRow)
			{
				if (empty($fleetRow)) continue;
					
				$temp        = explode (",", $fleetRow);

				if ($temp[0] == 209 || $temp[0] == 219)
				{
					$recyclerStorage   += $pricelist[$temp[0]]['capacity'] * $temp[1];
				}
				else
				{
					$otherFleetStorage += $pricelist[$temp[0]]['capacity'] * $temp[1];
				}
			}
			
			$recyclerStorage	*= $shipStorageFactor;
			$otherFleetStorage	*= $shipStorageFactor;
			
			unset($temp);

			$incomingGoods		= 0;
			foreach($resourceIDs as $resourceID)
			{
				$incomingGoods	+= $this->_fleet['fleet_resource_'.$resource[$debrisID]];
			}
			
			$totalStorage = $recyclerStorage + min(0, $otherFleetStorage - $incomingGoods);

			// fast way
			$collectFactor	= min(1, $totalStorage / $targetData['total']);
			foreach($debrisIDs as $debrisID)
			{
				$collectedGoods[$debrisID]	= ceil($targetData['der_'.$resource[$debrisID]] * $collectFactor);
				$collectQuery[]				= 'der_'.$resource[$debrisID].' = GREATEST(0, der_'.$resource[$debrisID].' - '.$collectedGoods[$debrisID].')';
				$this->UpdateFleet('fleet_resource_'.$resource[$debrisID], $this->_fleet['fleet_resource_'.$resource[$debrisID]] + $collectedGoods[$debrisID]);
			}
			
			$GLOBALS['DATABASE']->query("UPDATE ".PLANETS." SET ".implode(',', $collectQuery)." WHERE id = ".$this->_fleet['fleet_end_id'].";");
		}
		
		$LNG			= $LANG->GetUserLang($this->_fleet['fleet_owner']);
		
		$Message 		= sprintf($LNG['sys_recy_gotten'], 
								  pretty_number($collectedGoods[901]), $LNG['tech'][901], 
								  pretty_number($collectedGoods[902]), $LNG['tech'][902]
		);
						
		SendSimpleMessage($this->_fleet['fleet_owner'], 0, $this->_fleet['fleet_start_time'], 5, $LNG['sys_mess_tower'], $LNG['sys_recy_report'], $Message);
		$this->setState(FLEET_RETURN);
		$this->SaveFleet();
	}
	
	function EndStayEvent()
	{
		return;
	}
	
	function ReturnEvent()
	{
		global $LANG;
		$LNG		= $LANG->GetUserLang($this->_fleet['fleet_owner']);
		
		$TargetName	= $GLOBALS['DATABASE']->getFirstCell("SELECT name FROM ".PLANETS." WHERE id = ".$this->_fleet['fleet_end_id'].";");
	
		$Message	= sprintf($LNG['sys_tran_mess_owner'], $TargetName, GetStartAdressLink($this->_fleet, ''), pretty_number($this->_fleet['fleet_resource_metal']), $LNG['tech'][901], pretty_number($this->_fleet['fleet_resource_crystal']), $LNG['tech'][902], pretty_number($this->_fleet['fleet_resource_deuterium']), $LNG['tech'][903] );
		SendSimpleMessage($this->_fleet['fleet_owner'], 0, $this->_fleet['fleet_end_time'], 5, $LNG['sys_mess_tower'], $LNG['sys_mess_fleetback'], $Message);

		$this->RestoreFleet();
	}
}
?>