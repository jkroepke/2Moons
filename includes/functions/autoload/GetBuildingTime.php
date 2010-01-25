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

	function GetBuildingTime ($user, $planet, $Element)
	{
		global $pricelist, $resource, $reslist, $game_config, $requeriments;


		$level = ($planet[$resource[$Element]]) ? $planet[$resource[$Element]] : $user[$resource[$Element]];
		if(in_array($Element, $reslist['build']))
		{
			$cost_metal   = floor($pricelist[$Element]['metal']   * pow($pricelist[$Element]['factor'], $level));
			$cost_crystal = floor($pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $level));
			$time         = (($cost_crystal + $cost_metal) / ($game_config['game_speed'] * (1 + $planet[$resource[14]]))) * pow(0.5, $planet[$resource[15]]);
			$time         = floor(($time * 60 * 60) * (1 - (($user[$resource[605]]) * CONSTRUCTEUR)));
		}
		elseif (in_array($Element, $reslist['tech']))
		{
			$cost_metal   = floor($pricelist[$Element]['metal']   * pow($pricelist[$Element]['factor'], $level));
			$cost_crystal = floor($pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $level));
			if(is_array($planet[$resource[31]]))
			{
				$Level = 0;
				foreach($planet[$resource[31]] as $Levels)
				{
					if($Levels >= $requeriments[$Element][31])
						$Level += $Levels;
				}
			}
			else
				$Level	= $planet[$resource[31]];
				
			$time         = (($cost_metal + $cost_crystal) / (1000 * (1 + $Level))) / $game_config['game_speed'];
			$time         = floor($time * (1 - $user[$resource[606]] * SCIENTIFIQUE) * 3600);
		}
		elseif (in_array($Element, $reslist['defense']))
		{
			$time         = (($pricelist[$Element]['metal'] + $pricelist[$Element]['crystal']) / $game_config['game_speed']) * (1 / ($planet[$resource['21']] + 1)) * pow(1 / 2, $planet[$resource['15']]);
			$time         = floor(($time * 60 * 60) * (1 - ((($user[$resource[613]]) * GENERAL) + (($user[$resource[608]]) * DEFENSEUR))));
		}
		elseif (in_array($Element, $reslist['fleet']))
		{
			$time         = (($pricelist[$Element]['metal'] + $pricelist[$Element]['crystal']) / $game_config['game_speed']) * (1 / ($planet[$resource['21']] + 1)) * pow(1 / 2, $planet[$resource['15']]);
			$time         = floor(($time * 60 * 60) * (1 - ((($user[$resource[613]]) * GENERAL) + (($user[$resource[604]]) * TECHNOCRATE))));
		}
		
		return max($time, $game_config['min_build_time']);
	}

?>