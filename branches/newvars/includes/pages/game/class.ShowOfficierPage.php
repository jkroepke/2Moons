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


class ShowOfficierPage extends AbstractPage
{
	public static $requireModule = 0;

	function __construct() 
	{
		parent::__construct();
	}
	
	public function UpdateExtra($elementID)
	{
		global $PLANET, $USER, $resource, $pricelist;
		
		$costRessources		= BuildFunctions::getElementPrice($USER, $PLANET, $elementID);
			
		if (!BuildFunctions::isElementBuyable($USER, $PLANET, $elementID, $costRessources)) {
			return;
		}
			
		$USER[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']]	= max($USER[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']], TIMESTAMP) + $GLOBALS['VARS']['ELEMENT'][$elementID]['timeBonus'];
			
		foreach ($GLOBALS['VARS']['LIST'][ELEMENT_PLANET_RESOURCE] as $resourceID) {
			$PLANET[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name']]	-= $costRessources[$resourceID];
		}
		
		foreach ($GLOBALS['VARS']['LIST'][ELEMENT_USER_RESOURCE] as $resourceID)  {
			$USER[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name']]		-= $costRessources[$resourceID];
		}
		
		$GLOBALS['DATABASE']->query("UPDATE ".USERS." SET ".$GLOBALS['VARS']['ELEMENT'][$elementID]['name']." = ".$USER[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']]." WHERE id = ".$USER['id'].";");
	}

	public function UpdateOfficier($elementID)
	{
		global $USER, $PLANET, $reslist, $resource, $pricelist;
		
		$costRessources		= BuildFunctions::getElementPrice($USER, $PLANET, $elementID);
			
		if (!BuildFunctions::isTechnologieAccessible($USER, $PLANET, $elementID) 
			|| !BuildFunctions::isElementBuyable($USER, $PLANET, $elementID, $costRessources) 
			|| $pricelist[$elementID]['max'] <= $USER[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']]) {
			return;
		}
		
		$USER[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']]	+= 1;
		
		foreach ($GLOBALS['VARS']['LIST'][ELEMENT_PLANET_RESOURCE] as $resourceID) {
			$PLANET[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name']]	-= $costRessources[$resourceID];
		}
		
		foreach ($GLOBALS['VARS']['LIST'][ELEMENT_USER_RESOURCE] as $resourceID)  {
			$USER[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name']]		-= $costRessources[$resourceID];
		}
		
		$GLOBALS['DATABASE']->query("UPDATE ".USERS." SET ".$GLOBALS['VARS']['ELEMENT'][$elementID]['name']." = ".$USER[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']]." WHERE id = ".$USER['id'].";");
	}
	
	public function show()
	{
		global $USER, $CONF, $PLANET, $resource, $reslist, $LNG, $pricelist;
		
		$updateID	  = HTTP::_GP('id', 0);
				
		if (!empty($updateID) && $_SERVER['REQUEST_METHOD'] === 'POST' && $USER['urlaubs_modus'] == 0)
		{
			if(isModulAvalible(MODULE_OFFICIER) && ielementHasFlag($elementID, ELEMENT_OFFICIER)) {
				$this->UpdateOfficier($updateID);
			} elseif(isModulAvalible(MODULE_DMEXTRAS) && elementHasFlag($elementID, ELEMENT_BONUS)) {
				$this->UpdateExtra($updateID);
			}
		}
		
		$this->tplObj->loadscript('officier.js');		
		
		$darkmatterList	= array();
		$officierList	= array();
		
		if(isModulAvalible(MODULE_DMEXTRAS)) 
		{
			foreach($GLOBALS['VARS']['LIST'][ELEMENT_BONUS] as $elementID)
			{
				if($USER[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']] > TIMESTAMP) {
					$this->tplObj->execscript("GetOfficerTime(".$elementID.", ".($USER[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']] - TIMESTAMP).");");
				}
			
				$costRessources		= BuildFunctions::getElementPrice($USER, $PLANET, $elementID);
				$buyable			= BuildFunctions::isElementBuyable($USER, $PLANET, $elementID, $costRessources);
				$costOverflow		= BuildFunctions::getRestPrice($USER, $PLANET, $elementID, $costRessources);
				$elementBonus		= BuildFunctions::getAvalibleBonus($elementID);

				$darkmatterList[$elementID]	= array(
					'timeLeft'			=> max($USER[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']] - TIMESTAMP, 0),
					'costRessources'	=> array_filter($costRessources),
					'buyable'			=> $buyable,
					'time'				=> $GLOBALS['VARS']['ELEMENT'][$elementID]['timeBonus'],
					'costOverflow'		=> $costOverflow,
					'elementBonus'		=> $elementBonus,
				);
			}
		}
		
		if(isModulAvalible(MODULE_OFFICIER))
		{
			foreach($GLOBALS['VARS']['LIST'][ELEMENT_OFFICIER] as $elementID)
			{
				if (!BuildFunctions::isTechnologieAccessible($USER, $PLANET, $elementID))
					continue;
					
				$costRessources		= BuildFunctions::getElementPrice($USER, $PLANET, $elementID);
				$buyable			= BuildFunctions::isElementBuyable($USER, $PLANET, $elementID, $costRessources);
				$costOverflow		= BuildFunctions::getRestPrice($USER, $PLANET, $elementID, $costRessources);
				$elementBonus		= BuildFunctions::getAvalibleBonus($elementID);
				
				$officierList[$elementID]	= array(
					'level'				=> $USER[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']],
					'maxLevel'			=> $pricelist[$elementID]['max'],
					'costRessources'	=> array_filter($costRessources),
					'buyable'			=> $buyable,
					'costOverflow'		=> $costOverflow,
					'elementBonus'		=> $elementBonus,
				);
			}
		}
		
		$this->tplObj->assign_vars(array(	
			'officierList'		=> $officierList,
			'darkmatterList'	=> $darkmatterList,
			'of_dm_trade'		=> sprintf($LNG['of_dm_trade'], $LNG['tech'][921]),
		));
		
		$this->display('page.officier.default.tpl');
	}
}
