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
 * @version 1.6 (2011-11-17)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

function calculateSteal($attackFleets, $defenderPlanet, $ForSim = false)
{	
	//Steal-Math by Slaver for 2Moons(http://www.2moons.cc) based on http://www.owiki.de/Beute
	global $pricelist, $db;
	
	$SortFleets 	= array();
	$Sumcapacity  	= 0;
	$booty			= array('metal' => 0, 'crystal' => 0, 'deuterium' => 0);
	foreach($attackFleets as $FleetID => $Attacker)
	{
		$SortFleets[$FleetID]		= 0;
		foreach($Attacker['detail'] as $Element => $amount)	
		{
			$SortFleets[$FleetID]		+= $pricelist[$Element]['capacity'] * $amount;
		}
		
		$SortFleets[$FleetID]	-= $Attacker['fleet']['fleet_resource_metal'];
		$SortFleets[$FleetID]	-= $Attacker['fleet']['fleet_resource_crystal'];
		$SortFleets[$FleetID]	-= $Attacker['fleet']['fleet_resource_deuterium'];
		$Sumcapacity			+= $SortFleets[$FleetID];
	}
	
	$AllCapacity		= $Sumcapacity;
	if($AllCapacity <= 0)
		return $booty;
		
	// Step 1
	$booty['metal'] 	= min($Sumcapacity / 3, $defenderPlanet['metal'] / 2);
	$Sumcapacity		-= $booty['metal'];
	 
	// Step 2
	$booty['crystal'] 	= min($Sumcapacity / 2, $defenderPlanet['crystal'] / 2);
	$Sumcapacity		-= $booty['crystal'];
	 
	// Step 3
	$booty['deuterium'] = min($Sumcapacity, $defenderPlanet['deuterium'] / 2);
	$Sumcapacity		-= $booty['deuterium'];
		 
	// Step 4
	$oldMetalBooty  	= $booty['metal'];
	$booty['metal'] 	+= min($Sumcapacity / 2, $defenderPlanet['metal'] / 2 - $booty['metal']);
	$Sumcapacity		-= $booty['metal'] - $oldMetalBooty;
		 
	// Step 5
	$booty['crystal'] 	+= min($Sumcapacity, $defenderPlanet['crystal'] / 2 - $booty['crystal']);
			
	if($ForSim) 
		return $booty;

	$Qry	= "";

	
	foreach($SortFleets as $FleetID => $Capacity)
	{
		$Factor			= $Capacity / $AllCapacity;
		$Qry .= "UPDATE ".FLEETS." SET ";
		$Qry .= "`fleet_resource_metal` = `fleet_resource_metal` + '".$booty['metal'] * $Factor."', ";
		$Qry .= "`fleet_resource_crystal` = `fleet_resource_crystal` + '".$booty['crystal'] * $Factor."', ";
		$Qry .= "`fleet_resource_deuterium` = `fleet_resource_deuterium` + '".$booty['deuterium'] * $Factor."' ";
		$Qry .= "WHERE fleet_id = '".$FleetID."';";		
	}
	
	$db->multi_query($Qry);
	return $booty;
}
	
?>