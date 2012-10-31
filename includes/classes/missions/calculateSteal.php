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

function calculateSteal($attackFleets, $defenderPlanet, $simMode = false)
{	
	//Steal-Math by Slaver for 2Moons(http://www.2moons.cc) based on http://www.owiki.de/Beute
	global $pricelist, $resource;
	
	$firstResource	= 901;
	$secondResource	= 902;
	$thirdResource	= 903;
	
	$SortFleets 	= array();
	$capacity  	= 0;
	
	$stealResource	= array(
		$firstResource => 0,
		$secondResource => 0,
		$thirdResource => 0
	);
	
	foreach($attackFleets as $FleetID => $Attacker)
	{
		$SortFleets[$FleetID]		= 0;
		
		foreach($Attacker['unit'] as $Element => $amount)	
		{
			$SortFleets[$FleetID]		+= $pricelist[$Element]['capacity'] * $amount;
		}
		
		$SortFleets[$FleetID]	*= (1 + $Attacker['player']['factor']['ShipStorage']);
		
		$SortFleets[$FleetID]	-= $Attacker['fleetDetail']['fleet_resource_metal'];
		$SortFleets[$FleetID]	-= $Attacker['fleetDetail']['fleet_resource_crystal'];
		$SortFleets[$FleetID]	-= $Attacker['fleetDetail']['fleet_resource_deuterium'];
		$capacity				+= $SortFleets[$FleetID];
	}
	
	$AllCapacity		= $capacity;
	if($AllCapacity <= 0)
	{
		return $stealResource;
	}
	
	// Step 1
	$stealResource[$firstResource]		= min($capacity / 3, $defenderPlanet[$resource[$firstResource]] / 2);
	$capacity	-= $stealResource[$firstResource];
	 
	// Step 2
	$stealResource[$secondResource] 	= min($capacity / 2, $defenderPlanet[$resource[$secondResource]] / 2);
	$capacity	-= $stealResource[$secondResource];
	 
	// Step 3
	$stealResource[$thirdResource] 		= min($capacity, $defenderPlanet[$resource[$thirdResource]] / 2);
	$capacity	-= $stealResource[$thirdResource];
		 
	// Step 4
	$oldMetalBooty  					= $stealResource[$firstResource];
	$stealResource[$firstResource] 		+= min($capacity / 2, $defenderPlanet[$resource[$firstResource]] / 2 - $stealResource[$firstResource]);
	$capacity	-= $stealResource[$firstResource] - $oldMetalBooty;
		 
	// Step 5
	$stealResource[$secondResource] 	+= min($capacity, $defenderPlanet[$resource[$secondResource]] / 2 - $stealResource[$secondResource]);
			
	if($simMode)
	{
		return $stealResource;
	}
	
	$sqlQuery	= "";
	foreach($SortFleets as $FleetID => $Capacity)
	{
		$slotFactor	= $Capacity / $AllCapacity;
		
		$sqlQuery .= "UPDATE ".FLEETS." SET ";
		$sqlQuery .= "`fleet_resource_metal` = `fleet_resource_metal` + '".($stealResource[$firstResource] * $slotFactor)."', ";
		$sqlQuery .= "`fleet_resource_crystal` = `fleet_resource_crystal` + '".($stealResource[$secondResource] * $slotFactor)."', ";
		$sqlQuery .= "`fleet_resource_deuterium` = `fleet_resource_deuterium` + '".($stealResource[$thirdResource] * $slotFactor)."' ";
		$sqlQuery .= "WHERE fleet_id = '".$FleetID."';";		
	}
	
	$GLOBALS['DATABASE']->multi_query($sqlQuery);
	
	return $stealResource;
}
	
?>