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

function calculateMIPAttack($TargetDefTech, $OwnerAttTech, $ipm, $TargetDefensive, $pri_target, $adm)
{
	global $pricelist, $reslist, $CombatCaps;
	// Based on http://websim.speedsim.net/ JS-IRak Simulation
	unset($TargetDefensive[503]);
	$GetTargetKeys	= array_keys($TargetDefensive);
	
	$life_fac		= $TargetDefTech / 10 + 1;
	$life_fac_a 	= $CombatCaps[503]['attack'] * ($OwnerAttTech / 10 + 1);
	
	$ipm -= $adm;
	$adm = 0;
	$max_dam = $ipm * $life_fac_a;
	$i = 0;	

	$ship_res = array();
	foreach($TargetDefensive as $Element => $Count)
	{
		if($i == 0)
			$target = $pri_target;
		elseif($Element <= $pri_target)
			$target = $Element - 1;
		else
			$target = $Element;
		
		
		$Dam = $max_dam - ($pricelist[$target]['metal'] + $pricelist[$target]['crystal']) / 10 * $TargetDefensive[$target] * $life_fac;
			
		if($Dam > 0)
		{
			$dest = $TargetDefensive[$target];
			$ship_res[$target] = $dest;
		}
		else
		{
			// not enough damage for all items
			$dest = floor($max_dam / (($pricelist[$target]['metal'] + $pricelist[$target]['crystal']) / 10 * $life_fac));
			$ship_res[$target] = $dest;
		}
		$max_dam -= $dest * round(($pricelist[$target]['metal'] + $pricelist[$target]['crystal']) / 10 * $life_fac);
		$i++;
	}
		
	return $ship_res;
}
	
?>