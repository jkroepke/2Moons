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
	public static function getRestPrice($USER, $PLANET, $elementID, $elementPrice = NULL)
	{
		global $resource;
		
		if(!isset($elementPrice)) {
			$elementPrice	= self::getElementPrice($USER, $PLANET, $elementID);
		}
		
		$overflow	= array();
		
		foreach ($elementPrice as $resourceID => $resPrice) {
			$avalible			= isset($PLANET[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name']]) ? $PLANET[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name']] : $USER[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name']];
			$overflow[$resourceID] = max($resPrice - $avalible, 0);
		}

		return $overflow;
	}
	
	public static function getElementPrice($USER, $PLANET, $elementID, $forDestroy = false, $forLevel = NULL) { 
		global $pricelist, $resource, $reslist;

       	if (elementHasFlag($elementID, ELEMENT_FLEET) || elementHasFlag($elementID, ELEMENT_DEFENSIVE)) {
			$elementLevel = $forLevel;
		} elseif (isset($forLevel)) {
			$elementLevel = $forLevel - 1;
		} elseif (isset($PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']])) {
			$elementLevel = $PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']];
		} elseif (isset($USER[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']])) {
			$elementLevel = $USER[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']];
		} else {
			return array();
		}
		
		$price	= array();
		
		foreach (array_merge($GLOBALS['VARS']['LIST'][ELEMENT_PLANET_RESOURCE], $GLOBALS['VARS']['LIST'][ELEMENT_USER_RESOURCE],  $GLOBALS['VARS']['LIST'][ELEMENT_ENERGY]) as $resourceID) 
		{
			$price[$resourceID] = 0;
			
			if (!isset($GLOBALS['VARS']['ELEMENT'][$elementID]['cost'][$resourceID])) {
				continue;
			}
			
			$ressourceAmount	= $GLOBALS['VARS']['ELEMENT'][$elementID]['cost'][$resourceID];
			
			if ($ressourceAmount == 0) {
				continue;
			}
			
			$price[$resourceID]	= $ressourceAmount;
			
			if(isset($pricelist[$elementID]['factor']) && $pricelist[$elementID]['factor'] != 0 && $pricelist[$elementID]['factor'] != 1) {
				$price[$resourceID]	*= pow($pricelist[$elementID]['factor'], $elementLevel);
			}
			
			if($forLevel && (in_array($elementID, $reslist['fleet']) || in_array($elementID, $reslist['defense']))) {
				$price[$resourceID]	*= $elementLevel;
			}
			
			if($forDestroy === true) {
				$price[$resourceID]	/= 2;
			}
		}
		
		return $price; 
	}
	
	public static function isTechnologieAccessible($USER, $PLANET, $elementID)
	{
		global $requeriments, $resource;
		
		if(!isset($GLOBALS['VARS']['ELEMENT'][$elementID]['require']))
			return true;		

		foreach($GLOBALS['VARS']['ELEMENT'][$elementID]['require'] as $ReqElement => $EleLevel)
		{
			if (
				(isset($USER[$GLOBALS['VARS']['ELEMENT'][$ReqElement]['name']]) && $USER[$GLOBALS['VARS']['ELEMENT'][$ReqElement]['name']] < $EleLevel) || 
				(isset($PLANET[$GLOBALS['VARS']['ELEMENT'][$ReqElement]['name']]) && $PLANET[$GLOBALS['VARS']['ELEMENT'][$ReqElement]['name']] < $EleLevel)
			) {
				return false;
			}
		}
		return true;
	}
	
	public static function getBuildingTime($USER, $PLANET, $elementID, $elementPrice = NULL, $forDestroy = false, $forLevel = NULL)
	{
		global $resource, $reslist, $requeriments;
		
		$CONF	= getConfig($USER['universe']);

        $time   = 0;

        if(!isset($elementPrice)) {
			$elementPrice	= self::getElementPrice($USER, $PLANET, $elementID, $forDestroy, $forLevel);
		}
		
		$elementCost	= 0;
		
		if(isset($elementPrice[901])) {
			$elementCost	+= $elementPrice[901];
		}
		
		if(isset($elementPrice[902])) {
			$elementCost	+= $elementPrice[902];
		}
		
		if	   	 (elementHasFlag($elementID, ELEMENT_BUILD)) {
			$time	= $elementCost / ($CONF['game_speed'] * (1 + $PLANET[$GLOBALS['VARS']['ELEMENT'][14]['name']])) * pow(0.5, $PLANET[$GLOBALS['VARS']['ELEMENT'][15]['name']]) * (1 + $USER['factor']['BuildTime']);
		} elseif (elementHasFlag($elementID, ELEMENT_FLEET)) {
			$time	= $elementCost / ($CONF['game_speed'] * (1 + $PLANET[$GLOBALS['VARS']['ELEMENT'][21]['name']])) * pow(0.5, $PLANET[$GLOBALS['VARS']['ELEMENT'][15]['name']]) * (1 + $USER['factor']['ShipTime']);	
		} elseif (elementHasFlag($elementID, ELEMENT_DEFENSIVE)) {
			$time	= $elementCost / ($CONF['game_speed'] * (1 + $PLANET[$GLOBALS['VARS']['ELEMENT'][21]['name']])) * pow(0.5, $PLANET[$GLOBALS['VARS']['ELEMENT'][15]['name']]) * (1 + $USER['factor']['DefensiveTime']);
		} elseif (elementHasFlag($elementID, ELEMENT_TECH)) {
			if(is_numeric($PLANET[$GLOBALS['VARS']['ELEMENT'][31]['name'].'_inter']))
			{
				$Level	= $PLANET[$GLOBALS['VARS']['ELEMENT'][31]['name']];
			} else {
				$Level = 0;
				foreach($PLANET[$GLOBALS['VARS']['ELEMENT'][31]['name'].'_inter'] as $Levels)
				{
					if($Levels >= $GLOBALS['VARS']['ELEMENT'][$elementID]['require'][31])
						$Level += $Levels;
				}
			}
			
			$time	= $elementCost / (1000 * (1 + $Level)) / ($CONF['game_speed'] / 2500) * pow(1 - $CONF['factor_university'] / 100, $PLANET[$GLOBALS['VARS']['ELEMENT'][6]['name']]) * (1 + $USER['factor']['ResearchTime']);
		}
		
		if($forDestroy) {
			$time	= floor($time * 1300);
		} else {
			$time	= floor($time * 3600);
		}
		
		return max($time, $CONF['min_build_time']);
	}
	
	public static function isElementBuyable($USER, $PLANET, $elementID, $elementPrice = NULL, $forDestroy = false, $forLevel = NULL)
	{
		$rest	= self::getRestPrice($USER, $PLANET, $elementID, $elementPrice, $forDestroy, $forLevel);
		return count(array_filter($rest)) === 0;
	}
	
	public static function getMaxConstructibleElements($USER, $PLANET, $elementID, $elementPrice = NULL)
	{
		global $resource, $reslist;
		
		if(!isset($elementPrice)) {
			$elementPrice	= self::getElementPrice($USER, $PLANET, $elementID);
		}

		$maxElement	= array();
		
		foreach($elementPrice as $resourceID => $price)
		{
			$maxElement[]	= floor($PLANET[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name']] / $price);
		}
		
		if(in_array($elementID, $reslist['one'])) {
			$maxElement[]	= 1;
		}
		
		return min($maxElement);
	}
	
	public static function getMaxConstructibleRockets($USER, $PLANET, $Missiles = NULL)
	{
		global $resource, $CONF;

		if(!isset($Missiles)) {
			$Missiles			= array(
				502	=> $PLANET[$GLOBALS['VARS']['ELEMENT'][502]['name']],
				503	=> $PLANET[$GLOBALS['VARS']['ELEMENT'][503]['name']],
			);
		}
		$BuildArray  	  	= !empty($PLANET['b_hangar_id']) ? unserialize($PLANET['b_hangar_id']) : array();
		$MaxMissiles   		= $PLANET[$GLOBALS['VARS']['ELEMENT'][44]['name']] * 10 * max($CONF['silo_factor'], 1);

		foreach($BuildArray as $elementIDArray) {
			if(isset($Missiles[$elementIDArray[0]]))
				$Missiles[$elementIDArray[0]] += $elementIDArray[1];
		}
		
		$ActuMissiles  = $Missiles[502] + (2 * $Missiles[503]);
		$MissilesSpace = max(0, $MaxMissiles - $ActuMissiles);
		
		return array(
			502	=> $MissilesSpace,
			503	=> floor($MissilesSpace / 2),
		);
	}
	
	public static function getAvalibleBonus($elementID)
	{
		global $pricelist;
			
		$avalibleBonus	= array('Attack', 'Defensive', 'Shield'	, 'BuildTime', 'ResearchTime', 'ShipTime', 'DefensiveTime', 'Resource', 'Energy', 'ResourceStorage', 'ShipStorage', 'FlyTime', 'FleetSlots', 'Planets');
		$elementBonus	= array();
		
		foreach($avalibleBonus as $bonus) {
			if(empty($pricelist[$elementID]['bonus'][$bonus]))
				continue;
				
			$tmp	= (float) $pricelist[$elementID]['bonus'][$bonus];
			if(!empty($tmp)) {
				$elementBonus[$bonus]	= $tmp;
			}
		}
		
		return $elementBonus;
	}
}