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

class BuildFunctions
{
	public static function getRestPrice($USER, $PLANET, $Element, $elementPrice = NULL)
	{
		global $pricelist, $resource;
		
		if(!isset($elementPrice)) {
			$elementPrice	= self::getElementPrice($USER, $PLANET, $Element);
		}
		
		$overflow	= array();
		
		foreach ($elementPrice as $resType => $resPrice) {
			$avalible			= isset($PLANET[$resource[$resType]]) ? $PLANET[$resource[$resType]] : $USER[$resource[$resType]];
			$overflow[$resType] = max($resPrice - $avalible, 0);
		}

		return $overflow;
	}
	
	public static function getElementPrice($USER, $PLANET, $Element, $forDestroy = false, $forLevel = NULL) { 
		global $pricelist, $resource, $reslist;
		
		if (in_array($Element, $reslist['fleet']) || in_array($Element, $reslist['defense'])) {
			$elementLevel = $forLevel;
		} elseif (isset($forLevel)) {
			$elementLevel = $forLevel - 1;
		} elseif (isset($PLANET[$resource[$Element]])) {
			$elementLevel = $PLANET[$resource[$Element]];
		} elseif (isset($USER[$resource[$Element]])) {
			$elementLevel = $USER[$resource[$Element]];
		} else {
			return array();
		}
		
		$price	= array();
		
		foreach ($reslist['ressources'] as $resType)
		{
			if (!isset($pricelist[$Element]['cost'][$resType])) {
				continue;
			}
			$ressourceAmount	= $pricelist[$Element]['cost'][$resType];
			
			if ($ressourceAmount == 0) {
				continue;
			}
			
			$price[$resType]	= $ressourceAmount;
			
			if(isset($pricelist[$Element]['factor']) && $pricelist[$Element]['factor'] != 0 && $pricelist[$Element]['factor'] != 1) {
				$price[$resType]	*= pow($pricelist[$Element]['factor'], $elementLevel);
			}
			
			if($forLevel && (in_array($Element, $reslist['fleet']) || in_array($Element, $reslist['defense']))) {
				$price[$resType]	*= $elementLevel;
			}
			
			if($forDestroy === true) {
				$price[$resType]	/= 2;
			}
		}
		
		return $price; 
	}
	
	public static function isTechnologieAccessible($USER, $PLANET, $Element)
	{
		global $requeriments, $resource, $reslist;
		
		if(!isset($requeriments[$Element]))
			return true;		

		foreach($requeriments[$Element] as $ReqElement => $EleLevel)
		{
			if (
				(isset($USER[$resource[$ReqElement]]) && $USER[$resource[$ReqElement]] < $EleLevel) || 
				(isset($PLANET[$resource[$ReqElement]]) && $PLANET[$resource[$ReqElement]] < $EleLevel)
			) {
				return false;
			}
		}
		return true;
	}
	
	public static function getBuildingTime($USER, $PLANET, $Element, $elementPrice = NULL, $forDestroy = false, $forLevel = NULL)
	{
		global $pricelist, $resource, $reslist, $requeriments;
		
		$CONF	= getConfig($USER['universe']);

		if(!isset($elementPrice)) {
			$elementPrice	= self::getElementPrice($USER, $PLANET, $Element, $forDestroy, $forLevel);
		}
		
		$elementCost	= 0;
		
		if(isset($elementPrice[901])) {
			$elementCost	+= $elementPrice[901];
		}
		
		if(isset($elementPrice[902])) {
			$elementCost	+= $elementPrice[902];
		}
		
		if	   (in_array($Element, $reslist['build'])) {
			$time	= $elementCost / ($CONF['game_speed'] * (1 + $PLANET[$resource[14]])) * pow(0.5, $PLANET[$resource[15]]) * $USER['factor']['bulidspeed'];
		} elseif (in_array($Element, $reslist['fleet'])) {
			$time	= $elementCost / ($CONF['game_speed'] * (1 + $PLANET[$resource[21]])) * pow(0.5, $PLANET[$resource[15]]) * $USER['factor']['fleetspeed'];	
		} elseif (in_array($Element, $reslist['defense'])) {
			$time	= $elementCost / ($CONF['game_speed'] * (1 + $PLANET[$resource[21]])) * pow(0.5, $PLANET[$resource[15]]) * $USER['factor']['defspeed'];
		} elseif (in_array($Element, $reslist['tech'])) {
			if(is_numeric($PLANET[$resource[31].'_inter']))
			{
				$Level	= $PLANET[$resource[31]];
			} else {
				$Level = 0;
				foreach($PLANET[$resource[31].'_inter'] as $Levels)
				{
					if($Levels >= $requeriments[$Element][31])
						$Level += $Levels;
				}
			}
			
			$time	= $elementCost / (1000 * (1 + $Level)) / ($CONF['game_speed'] / 2500) * pow(1 - $CONF['factor_university'] / 100, $PLANET[$resource[6]]) * $USER['factor']['techspeed'];
		}
		
		if($forDestroy) {
			$time	= floor($time * 1300);
		} else {
			$time	= floor($time * 3600);
		}
		
		return max($time, $CONF['min_build_time']);
	}
	
	public static function isElementBuyable($USER, $PLANET, $Element, $elementPrice = NULL, $forDestroy = false, $forLevel = NULL)
	{
		global $pricelist, $resource;
		
		$rest	= self::getRestPrice($USER, $PLANET, $Element, $elementPrice, $forDestroy, $forLevel);
		return count(array_filter($rest)) === 0;
	}
	
	public static function getMaxConstructibleElements($USER, $PLANET, $Element, $elementPrice = NULL)
	{
		global $pricelist, $resource, $reslist;
		
		if(!isset($elementPrice)) {
			$elementPrice	= self::getElementPrice($USER, $PLANET, $Element);
		}

		$Cost	= $pricelist[$Element]['cost'];
		
		$maxElement	= array();
		
		foreach($elementPrice as $resourceID => $price)
		{
			$maxElement[]	= floor($PLANET[$resource[$resourceID]] / $price);
		}
		
		if(in_array($Element, $reslist['one'])) {
			$maxElement[]	= 1;
		}
		
		return min($maxElement);
	}
	
	public function getMaxConstructibleRockets($USER, $PLANET, $Missiles = NULL)
	{
		global $resource, $CONF;

		if(!isset($Missiles)) {
			$Missiles			= array(
				502	=> $PLANET[$resource[502]],
				503	=> $PLANET[$resource[503]],
			);
		}
		$BuildArray  	  	= !empty($PLANET['b_hangar_id']) ? unserialize($PLANET['b_hangar_id']) : array();
		$MaxMissiles   		= $PLANET[$resource[44]] * 10 * max($CONF['silo_factor'], 1);

		foreach($BuildArray as $ElementArray) {
			if(isset($Missiles[$ElementArray[0]]))
				$Missiles[$ElementArray[0]] += $ElementArray[1];
		}
		
		$ActuMissiles  = $Missiles[502] + (2 * $Missiles[503]);
		$MissilesSpace = max(0, $MaxMissiles - $ActuMissiles);
		
		return array(
			502	=> $MissilesSpace,
			503	=> floor($MissilesSpace / 2),
		);
	}
}