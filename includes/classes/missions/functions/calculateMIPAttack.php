<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @licence MIT
 * @version 1.7.2 (2013-03-18)
 * @info $Id$
 * @link http://2moons.cc/
 */

function calculateMIPAttack($TargetDefTech, $OwnerAttTech, $missiles, $targetDefensive, $firstTarget, $defenseMissles)
{
	global $pricelist, $CombatCaps;
	
	$destroyShips		= array();
	$countMissles 		= $missiles - $defenseMissles;
	
	if($countMissles == 0)
	{
		return $destroyShips;
	}

	$totalAttack 		= $countMissles * $CombatCaps[503]['attack'] * (1 +  0.1 * $OwnerAttTech);
	
	// Select primary target, if exists
	if(isset($targetDefensive[$firstTarget]))
	{
		$firstTargetData	= array($firstTarget => $targetDefensive[$firstTarget]);
		unset($targetDefensive[$firstTarget]);
		$targetDefensive	= $firstTargetData + $targetDefensive;
	}
	
	foreach($targetDefensive as $element => $count)
	{
		if($element == 0)
		{
			throw new Exception("Unknown error. Please report this error on tracker.2moons.cc. Debuginforations:<br><br>".serialize(array($TargetDefTech, $OwnerAttTech, $missiles, $targetDefensive, $firstTarget, $defenseMissles)));
		}
		$elementStructurePoints = ($pricelist[$element]['cost'][901] + $pricelist[$element]['cost'][902]) * (1 + 0.1 * $TargetDefTech) / 10;
		$destroyCount           = floor($totalAttack / $elementStructurePoints);
		$destroyCount           = min($destroyCount, $count);
		$totalAttack  	       -= $destroyCount * $elementStructurePoints;
		
		$destroyShips[$element]	= $destroyCount;
		if($totalAttack <= 0)
		{
			return $destroyShips;
		}
	}
		
	return $destroyShips;
}