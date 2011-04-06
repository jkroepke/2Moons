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
 * @version 1.3 (2011-01-21)
 * @link http://code.google.com/p/2moons/
 */

if(!defined('INSIDE')) die('Hacking attempt!');

	function GetBuildingTime ($USER, $PLANET, $Element, $Destroy = false)
	{
		global $pricelist, $resource, $reslist, $requeriments, $ExtraDM, $OfficerInfo;
		$CONF	= getConfig($USER['universe']);
		$level	= isset($PLANET[$resource[$Element]]) ? $PLANET[$resource[$Element]] : $USER[$resource[$Element]];
		
		$Cost   = floor($pricelist[$Element]['metal'] * pow($pricelist[$Element]['factor'], $level)) + floor($pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $level));
	
		if	   (in_array($Element, $reslist['build']))
			$time			= $Cost / ($CONF['game_speed'] * (1 + $PLANET[$resource[14]])) * pow(0.5, $PLANET[$resource[15]]) * $PLANET['factor']['bulidspeed'];
		elseif (in_array($Element, $reslist['fleet']))
			$time			= $Cost / ($CONF['game_speed'] * (1 + $PLANET[$resource[21]])) * pow(0.5, $PLANET[$resource[15]]) * $PLANET['factor']['fleetspeed'];	
		elseif (in_array($Element, $reslist['defense']))
			$time			= $Cost / ($CONF['game_speed'] * (1 + $PLANET[$resource[21]])) * pow(0.5, $PLANET[$resource[15]]) * $PLANET['factor']['defspeed'];
		elseif (in_array($Element, $reslist['tech']))
		{
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
			
			$time	= $Cost / (1000 * (1 + $Level)) / ($CONF['game_speed'] / 2500) * pow(1 - $CONF['factor_university'] / 100, $PLANET[$resource[6]]) * $PLANET['factor']['techspeed'];
		}
		
		if(!$Destroy)
			$time	= floor($time * 3600);
		else
			$time	= floor($time * 1300);
		
		return max($time, $CONF['min_build_time']);
	}

?>