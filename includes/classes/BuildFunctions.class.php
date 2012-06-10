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
 * @version 1.7.0 (2012-05-31)
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
		
		$resourceIDs	= array_merge($GLOBALS['VARS']['LIST'][ELEMENT_PLANET_RESOURCE], $GLOBALS['VARS']['LIST'][ELEMENT_USER_RESOURCE], $GLOBALS['VARS']['LIST'][ELEMENT_ENERGY]);
		
		foreach ($resourceIDs as $resourceID) 
		{
			$price[$resourceID] = 0;
			
			$ressourceAmount	= $GLOBALS['VARS']['ELEMENT'][$elementID]['cost'][$resourceID];
			
			if ($ressourceAmount == 0) {
				continue;
			}
			
			$price[$resourceID]	= $ressourceAmount;
			if($GLOBALS['VARS']['ELEMENT'][$elementID]['factor'] > 1) {
				$price[$resourceID]	*= pow($GLOBALS['VARS']['ELEMENT'][$elementID]['factor'], $elementLevel);
			}
			
			if($forLevel && (elementHasFlag($elementID, ELEMENT_FLEET) || elementHasFlag($elementID, ELEMENT_PREMIUM))) {
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
		global $uniAllConfig;
		
		$uniConfig	= $uniAllConfig[$USER['universe']];

        $time		= 0;

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
		
		if	   	 (elementHasFlag($elementID, ELEMENT_BUILD))
		{
			$time	= $elementCost / ($uniConfig['gameSpeed'] * 2500 * (1 + $PLANET[$GLOBALS['VARS']['ELEMENT'][14]['name']])) * pow(0.5, $PLANET[$GLOBALS['VARS']['ELEMENT'][15]['name']]) * (1 + $USER['factor']['BuildTime']);
		}
		elseif (elementHasFlag($elementID, ELEMENT_FLEET))
		{
			$time	= $elementCost / ($uniConfig['gameSpeed'] * 2500 * (1 + $PLANET[$GLOBALS['VARS']['ELEMENT'][21]['name']])) * pow(0.5, $PLANET[$GLOBALS['VARS']['ELEMENT'][15]['name']]) * (1 + $USER['factor']['ShipTime']);	
		}
		elseif (elementHasFlag($elementID, ELEMENT_DEFENSIVE))
		{
			$time	= $elementCost / ($uniConfig['gameSpeed'] * 2500 * (1 + $PLANET[$GLOBALS['VARS']['ELEMENT'][21]['name']])) * pow(0.5, $PLANET[$GLOBALS['VARS']['ELEMENT'][15]['name']]) * (1 + $USER['factor']['DefensiveTime']);
		}
		elseif (elementHasFlag($elementID, ELEMENT_TECH))
		{
			if(is_numeric($PLANET[$GLOBALS['VARS']['ELEMENT'][31]['name'].'_inter']))
			{
				$Level	= $PLANET[$GLOBALS['VARS']['ELEMENT'][31]['name']];
			}
			else
			{
				$Level = 0;
				foreach($PLANET[$GLOBALS['VARS']['ELEMENT'][31]['name'].'_inter'] as $Levels)
				{
					if($Levels >= $GLOBALS['VARS']['ELEMENT'][$elementID]['require'][31])
						$Level += $Levels;
				}
			}
			
			$time	= ($elementCost / (1000 * (1 + $Level)) / $uniConfig['gameSpeed']) * (1 + $USER['factor']['ResearchTime']);
		}
		
		if($forDestroy) {
			$time	= floor($time * 1300);
		} else {
			$time	= floor($time * 3600);
		}
		
		return max($time, $uniConfig['buildMinBuildTime']);
	}
	
	public static function isElementBuyable($USER, $PLANET, $elementID, $elementPrice = NULL, $forDestroy = false, $forLevel = NULL)
	{
		$rest	= self::getRestPrice($USER, $PLANET, $elementID, $elementPrice, $forDestroy, $forLevel);
		return count(array_filter($rest)) === 0;
	}
	
	public static function getMaxConstructibleElements($USER, $PLANET, $elementID, $elementPrice = NULL)
	{		
		if(!isset($elementPrice)) {
			$elementPrice	= self::getElementPrice($USER, $PLANET, $elementID);
		}

		$maxElement	= array();
		$elementPrice	= array_filter($elementPrice);
		
		foreach($elementPrice as $resourceID => $price)
		{
			if(isset($PLANET[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name']))
			{
				$maxElement[]	= floor($PLANET[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name']] / $price);
			}
			elseif(isset($USER[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name']]))
			{
				$maxElement[]	= floor($USER[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name']] / $price);
			}
			else
			{
				throw new Exception("Unknown Ressource ".$resourceID." at element ".$Element.".");
			}
		}
		
		if(elementHasFlag($elementID, ELEMENT_ONEPERPLANET)) {
			$maxElement[]	= 1;
		}
		
		return min($maxElement);
	}
	
	public static function getMaxConstructibleRockets($USER, $PLANET, $Missiles = NULL)
	{
		global $uniAllConfig;

		$uniConfig	= $uniAllConfig[$USER['universe']];
		
		if(!isset($Missiles)) {
			$Missiles			= array(
				502	=> $PLANET[$GLOBALS['VARS']['ELEMENT'][502]['name']],
				503	=> $PLANET[$GLOBALS['VARS']['ELEMENT'][503]['name']],
			);
		}
		$BuildArray  	  	= !empty($PLANET['b_hangar_id']) ? unserialize($PLANET['b_hangar_id']) : array();
		$MaxMissiles   		= $PLANET[$GLOBALS['VARS']['ELEMENT'][44]['name']] * 10 * max($uniConfig['rocketStorageFactor'], 1);

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