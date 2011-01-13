<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
# *																			 #
# *																			 #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.									 #
# *																			 #
# *  This program is distributed in the hope that it will be useful,		 #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of			 #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 #
# *  GNU General Public License for more details.							 #
# *																			 #
##############################################################################

if(!defined('INSIDE')) die('Hacking attempt!');

	function GetBuildingTime ($USER, $PLANET, $Element, $Destroy = false)
	{
		global $pricelist, $resource, $reslist, $CONF, $requeriments, $ExtraDM, $OfficerInfo;

		$level = isset($PLANET[$resource[$Element]]) ? $PLANET[$resource[$Element]] : $USER[$resource[$Element]];
		if	   (in_array($Element, $reslist['build']))
			$time			=  round($pricelist[$Element]['metal'] * pow($pricelist[$Element]['factor'], $level) + $pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $level)) / ($CONF['game_speed'] * (1 + $PLANET[$resource[14]])) * pow(0.5, $PLANET[$resource[15]]) * 3600 * (1 - ($USER[$resource[605]] * $OfficerInfo[605]['info']) - ((TIMESTAMP - $USER[$resource[702]] <= 0) ? ($ExtraDM[702]['add']) : 0));
		elseif (in_array($Element, $reslist['defense']))
			$time			=  round($pricelist[$Element]['metal'] * pow($pricelist[$Element]['factor'], $level) + $pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $level)) / ($CONF['game_speed'] * (1 + $PLANET[$resource[21]])) * pow(0.5, $PLANET[$resource[15]]) * 3600 * (1 - ($USER[$resource[613]] * $OfficerInfo[613]['info']) - ($USER[$resource[608]] * $OfficerInfo[608]['info']));
		elseif (in_array($Element, $reslist['fleet']))
			$time			=  round($pricelist[$Element]['metal'] * pow($pricelist[$Element]['factor'], $level) + $pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $level)) / ($CONF['game_speed'] * (1 + $PLANET[$resource[21]])) * pow(0.5, $PLANET[$resource[15]]) * 3600 * (1 - ($USER[$resource[613]] * $OfficerInfo[613]['info']) - ($USER[$resource[604]] * $OfficerInfo[604]['info']));	
		elseif (in_array($Element, $reslist['tech']))
		{
			$cost_metal   = floor($pricelist[$Element]['metal']   * pow($pricelist[$Element]['factor'], $level));
			$cost_crystal = floor($pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $level));
			if(is_array($PLANET[$resource[31].'_inter']))
			{
				$Level = 0;
				foreach($PLANET[$resource[31].'_inter'] as $Levels)
				{
					($Levels >= $requeriments[$Element][31]) ? 
						$Level += $Levels : '';
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