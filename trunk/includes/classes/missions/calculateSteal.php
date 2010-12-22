<?php

##############################################################################
# *                                                                          #
# * 2MOONS                                                                   #
# *                                                                          #
# * @copyright Copyright (C) 2010 By ShadoX from titanspace.org              #
# *                                                                          #
# *	                                                                         #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.                                     #
# *	                                                                         #
# *  This program is distributed in the hope that it will be useful,         #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of          #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           #
# *  GNU General Public License for more details.                            #
# *                                                                          #
##############################################################################

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
			$SortFleets[$FleetID]		= HLadd($SortFleets[$FleetID], HLmul($pricelist[$Element]['capacity'], floattostring($amount)));
		}
		
		$SortFleets[$FleetID]	= HLsub($SortFleets[$FleetID], $Attacker['fleet']['fleet_resource_metal']);
		$SortFleets[$FleetID]	= HLsub($SortFleets[$FleetID], $Attacker['fleet']['fleet_resource_crystal']);
		$SortFleets[$FleetID]	= HLsub($SortFleets[$FleetID], $Attacker['fleet']['fleet_resource_deuterium']);
		$Sumcapacity			= HLadd($Sumcapacity, $SortFleets[$FleetID]);
	}
	
	$AllCapacity		= $Sumcapacity;

	// Step 1
	$booty['metal'] 	= min(HLdiv($Sumcapacity, 3), HLdiv(floattostring($defenderPlanet['metal']), 2));
	$Sumcapacity		= HLsub($Sumcapacity, $booty['metal']);
	 
	// Step 2
	$booty['crystal'] 	= min(HLdiv($Sumcapacity, 2), HLdiv(floattostring($defenderPlanet['crystal']), 2));
	$Sumcapacity		= HLsub($Sumcapacity, $booty['crystal']);
	 
	// Step 3
	$booty['deuterium'] = min($Sumcapacity, HLdiv(floattostring($defenderPlanet['deuterium']), 2));
	$Sumcapacity		= HLsub($Sumcapacity, $booty['deuterium']);
		 
	// Step 4
	$oldMetalBooty  	= $booty['metal'];
	$booty['metal'] 	= HLadd($booty['metal'], min(HLdiv($Sumcapacity, 2), max(HLsub(HLdiv(floattostring($defenderPlanet['metal']), 2), $booty['metal']), 0)));
	$Sumcapacity		= HLsub($Sumcapacity, HLsub($booty['metal'], $oldMetalBooty));
		 
	// Step 5
	$booty['crystal'] 	= HLadd($booty['crystal'], min($Sumcapacity, max(HLsub(HLdiv(floattostring($defenderPlanet['crystal']), 2), $booty['crystal']), 0)));
			
	if($ForSim) 
		return $booty;

	$Qry	= "";

	
	foreach($SortFleets as $FleetID => $Capacity)
	{
		$Factor			= HLdiv($Capacity, $AllCapacity, 10);
		$Qry .= "UPDATE ".FLEETS." SET ";
		$Qry .= "`fleet_resource_metal` = `fleet_resource_metal` + '".HLmul($booty['metal'], $Factor, 0)."', ";
		$Qry .= "`fleet_resource_crystal` = `fleet_resource_crystal` + '".HLmul($booty['crystal'], $Factor, 0)."', ";
		$Qry .= "`fleet_resource_deuterium` = `fleet_resource_deuterium` + '".HLmul($booty['deuterium'], $Factor, 0)."' ";
		$Qry .= "WHERE fleet_id = '".$FleetID."';";		
	}
	
	$db->multi_query($Qry);
	return $booty;
}
	
?>