<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan
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
 * @author Jan <info@2moons.cc>
 * @copyright 2006 Perberos <ugamela@perberos.com.ar> (UGamela)
 * @copyright 2008 Chlorel (XNova)
 * @copyright 2009 Lucky (XGProyecto)
 * @copyright 2012 Jan <info@2moons.cc> (2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 2.0.$Revision$ (2012-11-31)
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
	
	// Attack / Defensive bonus
	
	$attackFactor		= 1 + $OwnerAttTech * 10 - $TargetDefTech * 10;
	
	// kill destroyed missiles
	$totalAttack		= ($missiles - $defenseMissles) * $CombatCaps[503]['attack'] * $attackFactor * 10;
	
	$firstTargetData	= array($firstTarget => $targetDefensive[$firstTarget]);
	unset($targetDefensive[$firstTarget]);
	
	$targetDefensive	= ($firstTargetData + array_diff_key($targetDefensive, $firstTargetData));
	
	foreach($targetDefensive as $element => $count)
	{
		$destroyCount	= floor($totalAttack / ($GLOBALS['VARS']['ELEMENT'][$element]['cost'][901] + $GLOBALS['VARS']['ELEMENT'][$element]['cost'][902]));
		$destroyCount	= min($destroyCount, $count);
		
		$costAttack		= $destroyCount * ($GLOBALS['VARS']['ELEMENT'][$element]['cost'][901] + $GLOBALS['VARS']['ELEMENT'][$element]['cost'][902]);
		
		$totalAttack	-= $costAttack;
		
		$destroyShips[$element]	= $destroyCount;
	}
		
	return $destroyShips;
}
