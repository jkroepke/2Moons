<?php

/**
 *  2Moons
 *  Copyright (C) 2011  Slaver
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
 * @author Slaver <slaver7@gmail.com>
 * @copyright 2009 Lucky <lucky@xgproyect.net> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.3 (2011-01-21)
 * @link http://code.google.com/p/2moons/
 */

function calculateSteal($attackFleets, $defenderPlanet, $ForSim = false)
{	
	//Steal-Math by Slaver for 2Moons(http://www.titanspace.org) based on http://www.owiki.de/Beute
	global $pricelist, $db;
	
	$SortFleets = array();
	$Sumcapacity  = '0';
	foreach($attackFleets as $FleetID => $Attacker)
	{
		$SortFleets[$FleetID]		= '0';
		foreach($Attacker['detail'] as $Element => $amount)	
		{
			$SortFleets[$FleetID]		= bcadd($SortFleets[$FleetID], bcmul($pricelist[$Element]['capacity'], floattostring($amount)));
		}
		
		$SortFleets[$FleetID]	= bcsub($SortFleets[$FleetID], $Attacker['fleet']['fleet_resource_metal']);
		$SortFleets[$FleetID]	= bcsub($SortFleets[$FleetID], $Attacker['fleet']['fleet_resource_crystal']);
		$SortFleets[$FleetID]	= bcsub($SortFleets[$FleetID], $Attacker['fleet']['fleet_resource_deuterium']);
		$Sumcapacity			= bcadd($Sumcapacity, $SortFleets[$FleetID]);
	}
	
	$AllCapacity		= $Sumcapacity;

	// Step 1
	$booty['metal'] 	= min(bcdiv($Sumcapacity, 3), bcdiv(floattostring($defenderPlanet['metal']), 2));
	$Sumcapacity		= bcsub($Sumcapacity, $booty['metal']);
	 
	// Step 2
	$booty['crystal'] 	= min(bcdiv($Sumcapacity, 2), bcdiv(floattostring($defenderPlanet['crystal']), 2));
	$Sumcapacity		= bcsub($Sumcapacity, $booty['crystal']);
	 
	// Step 3
	$booty['deuterium'] = min($Sumcapacity, bcdiv(floattostring($defenderPlanet['deuterium']), 2));
	$Sumcapacity		= bcsub($Sumcapacity, $booty['deuterium']);
		 
	// Step 4
	$oldMetalBooty  	= $booty['metal'];
	$booty['metal'] 	= bcadd($booty['metal'], min(bcdiv($Sumcapacity, 2), max(bcsub(bcdiv(floattostring($defenderPlanet['metal']), 2), $booty['metal']), 0)));
	$Sumcapacity		= bcsub($Sumcapacity, bcsub($booty['metal'], $oldMetalBooty));
		 
	// Step 5
	$booty['crystal'] 	= bcadd($booty['crystal'], min($Sumcapacity, max(bcsub(bcdiv(floattostring($defenderPlanet['crystal']), 2), $booty['crystal']), 0)));
			
	if($ForSim) 
		return $booty;

	$Qry	= "";

	
	foreach($SortFleets as $FleetID => $Capacity)
	{
		$Factor			= bcdiv($Capacity, $AllCapacity, 10);
		$Qry .= "UPDATE ".FLEETS." SET ";
		$Qry .= "`fleet_resource_metal` = `fleet_resource_metal` + '".bcmul($booty['metal'], $Factor, 0)."', ";
		$Qry .= "`fleet_resource_crystal` = `fleet_resource_crystal` + '".bcmul($booty['crystal'], $Factor, 0)."', ";
		$Qry .= "`fleet_resource_deuterium` = `fleet_resource_deuterium` + '".bcmul($booty['deuterium'], $Factor, 0)."' ";
		$Qry .= "WHERE fleet_id = '".$FleetID."';";		
	}
	
	$db->multi_query($Qry);
	return $booty;
}
	
?>