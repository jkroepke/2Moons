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
 * @copyright 2009 Lucky <douglas@crockford.com> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.3 (2011-01-21)
 * @link http://code.google.com/p/2moons/
 */

if(!defined('INSIDE')) die('Hacking attempt!');

	function GetBuildingTime ($USER, $PLANET, $Element, $Destroy = false)
	{
		global $pricelist, $resource, $reslist, $CONF, $requeriments, $ExtraDM, $OfficerInfo;
		
/*
		Der einheitlich keit über würde ich das mit in die einZeiler Berechnung einlfießen lassen, und zwar so:
		((TIMESTAMP - $USER['premium'] <= 0) ($CONF['bauzeit_fleet'] * 0.01) ? 0)
		Das für Werte kommen in $CONF['bauzeit_*'] ?
		Robbyn(Antwort): Es kommen dort die Prozentwerte hinein also umwieviel Prozent die Bauzeiten der Gebäude/Flotten/Verteidigungen verringert werden.
		
 		if($CONF['premium'] == 1 && $USER['premium_aktiv'] > 0){
			$bauzeit_build = ($CONF['bauzeit_build'] * 0.01);
			$bauzeit_defense = ($CONF['bauzeit_defense'] * 0.01);
			$bauzeit_fleet = ($CONF['bauzeit_fleet'] * 0.01);
		}else{
			$bauzeit_build = 1;
			$bauzeit_defense = 1;
			$bauzeit_fleet = 1;
		} */
		
		//Müssen vorhanden sein da ich diese Werte schon in die Berechnung mit eingebracht habe ansonsten kommt es zu fehlern in der Bauzeit
			$bauzeit_build = 1;
			$bauzeit_defense = 1;
			$bauzeit_fleet = 1;

		$level = isset($PLANET[$resource[$Element]]) ? $PLANET[$resource[$Element]] : $USER[$resource[$Element]];
		if	   (in_array($Element, $reslist['build']))
			$time			=  round($pricelist[$Element]['metal'] * pow($pricelist[$Element]['factor'], $level) + $pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $level)) / ($CONF['game_speed'] / $bauzeit_build * (1 + $PLANET[$resource[14]])) * pow(0.5, $PLANET[$resource[15]]) * 3600 * (1 - ($USER[$resource[605]] * $OfficerInfo[605]['info']) - ((TIMESTAMP - $USER[$resource[702]] <= 0) ? ($ExtraDM[702]['add']) : 0));
		elseif (in_array($Element, $reslist['defense']))
			$time			=  round($pricelist[$Element]['metal'] * pow($pricelist[$Element]['factor'], $level) + $pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $level)) / ($CONF['game_speed'] / $bauzeit_defense * (1 + $PLANET[$resource[21]])) * pow(0.5, $PLANET[$resource[15]]) * 3600 * (1 - ($USER[$resource[613]] * $OfficerInfo[613]['info']) - ($USER[$resource[608]] * $OfficerInfo[608]['info']));
		elseif (in_array($Element, $reslist['fleet']))
			$time			=  round($pricelist[$Element]['metal'] * pow($pricelist[$Element]['factor'], $level) + $pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $level)) / ($CONF['game_speed'] / $bauzeit_fleet * (1 + $PLANET[$resource[21]])) * pow(0.5, $PLANET[$resource[15]]) * 3600 * (1 - ($USER[$resource[613]] * $OfficerInfo[613]['info']) - ($USER[$resource[604]] * $OfficerInfo[604]['info']));	
		elseif (in_array($Element, $reslist['tech']))
		{
			$cost_metal   = floor($pricelist[$Element]['metal']   * pow($pricelist[$Element]['factor'], $level));
			$cost_crystal = floor($pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $level));
			if(is_array($PLANET[$resource[31].'_inter']))
			{
				$Level = 0;
				foreach($PLANET[$resource[31].'_inter'] as $Levels)
				{
					if($Levels >= $requeriments[$Element][31])
						$Level += $Levels;
				}
			}
			else
				$Level	= $PLANET[$resource[31]];
			
			if(NEW_RESEARCH)
				$time		  = ((($cost_metal + $cost_crystal) / (1000 * (1 + $Level)) * (1 - $USER[$resource[606]] * $OfficerInfo[606]['info'])) / ($CONF['game_speed'] / 2500)) * 3600;
			else {
				$time         = (($cost_metal + $cost_crystal) / $CONF['game_speed']) / (($Level + 1) * 2);
				$time         = $time * (1 - $USER[$resource[606]] * $OfficerInfo[606]['info']) * 3600;
			}
			$time         = floor($time * ((TIMESTAMP - $USER[$resource[705]] <= 0) ? (1 - $ExtraDM[705]['add']) : 1) * pow((1 - UNIVERISTY_RESEARCH_REDUCTION), $PLANET[$resource[6]]));
		}
		
		return max((($Destroy)?floor($time / 2):floor($time)), $CONF['min_build_time']);
	}

?>