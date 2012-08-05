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
 * @version 1.6.1 (2011-11-19)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

function calculateMIPAttack($TargetDefTech, $OwnerAttTech, $missiles, $targetDefensive, $firstTarget, $defenseMissles)
{
	global $pricelist, $reslist, $CombatCaps;
	/* Interplanetarraketen haben eine Grundangriffskraft von 12.000 und richten damit bei 
	ausgeglichenem Technologielevel zwischen Angreifer und Verteidiger immer einen 
	Schaden von Metall+Kristall = 120.000 an. Wieviel davon Metall bzw. Kristall ist 
	fließt nicht in die Berechnung mit ein. Ebenso wenig, wie das Deuterium. */
	
	// unset Missiles
	unset($targetDefensive[503]);
	
	$destroyShips		= array();
	
	// kill destroyed missiles
	$totalAttack		= ($missiles - $defenseMissles) * $CombatCaps[503]['attack'] * (1 + $OwnerAttTech / 10);
	
	$firstTargetData	= array($firstTarget => $targetDefensive[$firstTarget]);
	unset($targetDefensive[$firstTarget]);
	
	$targetDefensive	= ($firstTargetData + array_diff_key($targetDefensive, $firstTargetData));
	
	foreach($targetDefensive as $element => $count)
	{
		$elementDefensive		= ($pricelist[$element]['cost'][901] + $pricelist[$element]['cost'][902]) * (1 + $TargetDefTech / 10);
		$destroyCount			= floor($totalAttack / $elementDefensive);
		$destroyCount			= min($destroyCount, $count);
		
		$totalAttack			-= $destroyCount * $elementDefensive;
		
		$destroyShips[$element]	= $destroyCount;
	}
		
	return $destroyShips;
}
	
?>