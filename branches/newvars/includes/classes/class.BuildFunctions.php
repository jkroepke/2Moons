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
		global $resource;
		
		if(!isset($elementPrice)) {
			$elementPrice	= self::getElementPrice($USER, $PLANET, $Element);
		}
		
		$overflow	= array();
		
		foreach ($elementPrice as $resType => $resPrice) {
			$avalible			= isset($PLANET[$GLOBALS['ELEMENT'][$resType]['name']]) ? $PLANET[$GLOBALS['ELEMENT'][$resType]['name']] : $USER[$GLOBALS['ELEMENT'][$resType]['name']];
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
		} elseif (isset($PLANET[$GLOBALS['ELEMENT'][$Element]['name']])) {
			$elementLevel = $PLANET[$GLOBALS['ELEMENT'][$Element]['name']];
		} elseif (isset($USER[$GLOBALS['ELEMENT'][$Element]['name']])) {
			$elementLevel = $USER[$GLOBALS['ELEMENT'][$Element]['name']];
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
		global $requeriments, $resource;
		
		if(!isset($requeriments[$Element]))
			return true;		

		foreach($requeriments[$Element] as $ReqElement => $EleLevel)
		{
			if (
				(isset($USER[$GLOBALS['ELEMENT'][$ReqElement]['name']]) && $USER[$GLOBALS['ELEMENT'][$ReqElement]['name']] < $EleLevel) || 
				(isset($PLANET[$GLOBALS['ELEMENT'][$ReqElement]['name']]) && $PLANET[$GLOBALS['ELEMENT'][$ReqElement]['name']] < $EleLevel)
			) {
				return false;
			}
		}
		return true;
	}
	
	public static function getBuildingTime($USER, $PLANET, $Element, $elementPrice = NULL, $forDestroy = false, $forLevel = NULL)
	{
		global $resource, $reslist, $requeriments;
		
		$CONF	= getConfig($USER['universe']);

        $time   = 0;

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
			$time	= $elementCost / ($CONF['game_speed'] * (1 + $PLANET[$GLOBALS['ELEMENT'][14]['name']])) * pow(0.5, $PLANET[$GLOBALS['ELEMENT'][15]['name']]) * (1 + $USER['factor']['BuildTime']);
		} elseif (in_array($Element, $reslist['fleet'])) {
			$time	= $elementCost / ($CONF['game_speed'] * (1 + $PLANET[$GLOBALS['ELEMENT'][21]['name']])) * pow(0.5, $PLANET[$GLOBALS['ELEMENT'][15]['name']]) * (1 + $USER['factor']['ShipTime']);	
		} elseif (in_array($Element, $reslist['defense'])) {
			$time	= $elementCost / ($CONF['game_speed'] * (1 + $PLANET[$GLOBALS['ELEMENT'][21]['name']])) * pow(0.5, $PLANET[$GLOBALS['ELEMENT'][15]['name']]) * (1 + $USER['factor']['DefensiveTime']);
		} elseif (in_array($Element, $reslist['tech'])) {
			if(is_numeric($PLANET[$GLOBALS['ELEMENT'][31]['name'].'_inter']))
			{
				$Level	= $PLANET[$GLOBALS['ELEMENT'][31]['name']];
			} else {
				$Level = 0;
				foreach($PLANET[$GLOBALS['ELEMENT'][31]['name'].'_inter'] as $Levels)
				{
					if($Levels >= $requeriments[$Element][31])
						$Level += $Levels;
				}
			}
			
			$time	= $elementCost / (1000 * (1 + $Level)) / ($CONF['game_speed'] / 2500) * pow(1 - $CONF['factor_university'] / 100, $PLANET[$GLOBALS['ELEMENT'][6]['name']]) * (1 + $USER['factor']['ResearchTime']);
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
		$rest	= self::getRestPrice($USER, $PLANET, $Element, $elementPrice, $forDestroy, $forLevel);
		return count(array_filter($rest)) === 0;
	}
	
	public static function getMaxConstructibleElements($USER, $PLANET, $Element, $elementPrice = NULL)
	{
		global $resource, $reslist;
		
		if(!isset($elementPrice)) {
			$elementPrice	= self::getElementPrice($USER, $PLANET, $Element);
		}

		$maxElement	= array();
		
		foreach($elementPrice as $resourceID => $price)
		{
			$maxElement[]	= floor($PLANET[$GLOBALS['ELEMENT'][$resourceID]['name']] / $price);
		}
		
		if(in_array($Element, $reslist['one'])) {
			$maxElement[]	= 1;
		}
		
		return min($maxElement);
	}
	
	public static function getMaxConstructibleRockets($USER, $PLANET, $Missiles = NULL)
	{
		global $resource, $CONF;

		if(!isset($Missiles)) {
			$Missiles			= array(
				502	=> $PLANET[$GLOBALS['ELEMENT'][502]['name']],
				503	=> $PLANET[$GLOBALS['ELEMENT'][503]['name']],
			);
		}
		$BuildArray  	  	= !empty($PLANET['b_hangar_id']) ? unserialize($PLANET['b_hangar_id']) : array();
		$MaxMissiles   		= $PLANET[$GLOBALS['ELEMENT'][44]['name']] * 10 * max($CONF['silo_factor'], 1);

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
	
	public static function getAvalibleBonus($Element)
	{
		global $pricelist;
			
		$avalibleBonus	= array('Attack', 'Defensive', 'Shield'	, 'BuildTime', 'ResearchTime', 'ShipTime', 'DefensiveTime', 'Resource', 'Energy', 'ResourceStorage', 'ShipStorage', 'FlyTime', 'FleetSlots', 'Planets');
		$elementBonus	= array();
		
		foreach($avalibleBonus as $bonus) {
			if(empty($pricelist[$Element]['bonus'][$bonus]))
				continue;
				
			$tmp	= (float) $pricelist[$Element]['bonus'][$bonus];
			if(!empty($tmp)) {
				$elementBonus[$bonus]	= $tmp;
			}
		}
		
		return $elementBonus;
	}
}