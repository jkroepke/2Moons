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

if(!defined('INSIDE')){ die(header("location:../../"));}

	function GetBuildingTime ($CurrentUser, $CurrentPlanet, $Element, $Destroy = false)
	{
		global $pricelist, $resource, $reslist, $game_config, $requeriments, $ExtraDM;

		$level = ($CurrentPlanet[$resource[$Element]]) ? $CurrentPlanet[$resource[$Element]] : $CurrentUser[$resource[$Element]];
		if	   (in_array($Element, $reslist['build']))
			$time			=  round($pricelist[$Element]['metal'] * pow($pricelist[$Element]['factor'], $level) + $pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $level)) / (2500 * (1 + $CurrentPlanet[$resource[14]])) * pow(0.5, $CurrentPlanet[$resource[15]]) * 3600 * (1 - ($CurrentUser[$resource[605]] * CONSTRUCTEUR) - ((time() - $CurrentUser[$resource[702]] <= 0) ? ($ExtraDM[702]['add']) : 0));
		elseif (in_array($Element, $reslist['defense']))
			$time			=  round($pricelist[$Element]['metal'] * pow($pricelist[$Element]['factor'], $level) + $pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $level)) / (2500 * (1 + $CurrentPlanet[$resource[21]])) * pow(0.5, $CurrentPlanet[$resource[15]]) * 3600 * (1 - ($CurrentUser[$resource[613]] * GENERAL) - ($CurrentUser[$resource[608]] * DEFENSEUR));
		elseif (in_array($Element, $reslist['fleet']))
			$time			=  round($pricelist[$Element]['metal'] * pow($pricelist[$Element]['factor'], $level) + $pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $level)) / (2500 * (1 + $CurrentPlanet[$resource[21]])) * pow(0.5, $CurrentPlanet[$resource[15]]) * 3600 * (1 - ($CurrentUser[$resource[613]] * GENERAL) - ($CurrentUser[$resource[604]] * TECHNOCRATE));	
		elseif (in_array($Element, $reslist['tech']))
		{
			$cost_metal   = floor($pricelist[$Element]['metal']   * pow($pricelist[$Element]['factor'], $level));
			$cost_crystal = floor($pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $level));
			if(is_array($CurrentPlanet[$resource[31]]))
			{
				$Level = 0;
				foreach($CurrentPlanet[$resource[31]] as $Levels)
				{
					if($Levels >= $requeriments[$Element][31])
						$Level += $Levels;
				}
			}
			else
				$Level	= $CurrentPlanet[$resource[31]];
			
			if(NEW_RESEARCH)
				$time		  = ((($cost_metal + $cost_crystal) / (1000 * (1 + $Level)) * (1 - $CurrentUser[$resource[606]] * SCIENTIFIQUE)) / ($game_config['game_speed'] / 2500)) * 3600;
			else {
				$time         = (($cost_metal + $cost_crystal) / $game_config['game_speed']) / (($Level + 1) * 2);
				$time         = $time * (1 - $CurrentUser[$resource[606]] * SCIENTIFIQUE) * 3600;
			}
			$time         = floor($time * ((time() - $CurrentUser[$resource[705]] <= 0) ? (1 - $ExtraDM[705]['add']) : 1) * (1 - ($CurrentPlanet[$resource[6]] * 0.08)));
		}
		
		return max((($Destroy)?floor($time / 2):floor($time)), $game_config['min_build_time']);
	}

?>