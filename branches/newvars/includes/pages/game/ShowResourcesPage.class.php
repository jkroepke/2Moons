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
 * @version 2.0.$Revision$ (2012-11-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

class ShowResourcesPage extends AbstractPage
{
	public static $requireModule = MODULE_RESSOURCE_LIST;

	function __construct() 
	{
		parent::__construct();
	}
	
	function send()
	{
		global $LNG, $USER, $PLANET;
		
		if ($USER['urlaubs_modus'] == 0)
		{
			$updateSQL	= array();
			foreach($GLOBALS['VARS']['LIST'][ELEMENT_PRODUCTION] as $elementID)
			{	
				if(!isset($_POST['prod'][$elementID])) {
					continue;
				}
				
				$percent	= (int) $_POST['prod'][$elementID];
				
				$fieldName = $GLOBALS['VARS']['ELEMENT'][$elementID]['name'].'_percent';
				
				if (!in_array($percent, range(0, 100, 10)) || $PLANET[$fieldName] == $percent) {
					continue;
				}
				
				$updateSQL[]	= $FieldName." = ".$Value;
				
				$PLANET[$FieldName]	= $Value;
			}

			if(!empty($updateSQL))
			{
				$GLOBALS['DATABASE']->query("UPDATE ".PLANETS." SET ".implode(", ", $updateSQL)." WHERE `id` = ".$PLANET['id'] .";");
				
				$this->ecoObj->ReBuildCache();
				$this->ecoObj->PLANET['eco_hash'] = $this->ecoObj->CreateHash();
				$PLANET = $this->ecoObj->PLANET;
			}
		}
		
		$this->save();
		$this->redirectTo('game.php?page=resources');	
	}
	
	function show()
	{
		global $LNG, $USER, $PLANET, $uniConfig;
		
		$ressIDs	= array_merge($GLOBALS['VARS']['LIST'][ELEMENT_PLANET_RESOURCE], $GLOBALS['VARS']['LIST'][ELEMENT_ENERGY]);
		
		if ($PLANET['planet_type'] == 3)
		{
			foreach($ressIDs as $resourceID)
			{
				$uniConfig['planetResource'.$resourceID.'BasicIncome']	= 0;
			}
		}
		
		$temp		= ArrayUtil::combineArrayWithSingleElement($ressIDs, array(
			'plus'	=> 0,
			'minus'	=> 0,
		));
		
		$BuildTemp		= $PLANET['temp_max'];
		$BuildEnergy	= $USER[$GLOBALS['VARS']['ELEMENT'][113]['name']];
		
		if($PLANET['energy_used'] != 0) {
			$prodLevel	= min(1, $PLANET['energy'] / abs($PLANET['energy_used']));
		} else {
			$prodLevel	= 0;
		}
		
		$productionList	= array();
		
		foreach($GLOBALS['VARS']['LIST'][ELEMENT_PRODUCTION] as $elementID)
		{	
			$BuildLevel 		= $PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']];
		
			if(empty($BuildLevel)) {
				continue;
			}
			
			$productionList[$elementID]	= array(
				'production'	=> array(901 => 0, 902 => 0, 903 => 0, 911 => 0),
				'elementLevel'	=> $PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']],
				'prodLevel'		=> $PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name'].'_percent'],
			);
			
			foreach($ressIDs as $resourceID) 
			{
				if(!isset($GLOBALS['VARS']['ELEMENT'][$elementID]['production'][$resourceID]))
					continue;
					
				$Production	= eval(ResourceUpdate::getProd($GLOBALS['VARS']['ELEMENT'][$elementID]['production'][$resourceID]));
				$Production	*= $PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name'].'_percent'] / 100;
				
				if($resourceID != 911) {
					$Production	*= $prodLevel * $uniConfig['ecoSpeed'];
				}
				
				$productionList[$elementID]['production'][$resourceID]	= $Production;
				
				if($Production > 0) {
					if($PLANET[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name']] == 0) continue;
					
					$temp[$resourceID]['plus']	+= $Production;
				} else {
					$temp[$resourceID]['minus']	+= $Production;
				}
			}
		}
		
		$storage			= array();
		$basicProduction	= array();
		$totalProduction	= array();
		$bonusProduction	= array();
		$dailyProduction	= array();
		$weeklyProduction	= array();
		
		foreach($GLOBALS['VARS']['LIST'][ELEMENT_PLANET_RESOURCE] as $resourceID) 
		{	
			$storage[$resourceID]			= shortly_number($PLANET[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name'].'_max']);
			$basicProduction[$resourceID]	= $uniConfig['planetResource'.$resourceID.'BasicIncome'] * $uniConfig['ecoSpeed'];
			$totalProduction[$resourceID]	= $PLANET[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name'].'_perhour'] + $basicProduction[$resourceID];
			$bonusProduction[$resourceID]	= $temp[$resourceID]['plus'] * $USER['factor']['Resource'];
			$dailyProduction[$resourceID]	= $totalProduction[$resourceID] * 24;
			$weeklyProduction[$resourceID]	= $totalProduction[$resourceID] * 168;
		}
		
		foreach($GLOBALS['VARS']['LIST'][ELEMENT_ENERGY] as $resourceID) 
		{	
			$storage[$resourceID]			= '-';
			$basicProduction[$resourceID]	= $uniConfig['planetResource'.$resourceID.'BasicIncome'] * $uniConfig['ecoSpeed'];
			$totalProduction[$resourceID]	= $PLANET[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name']] + $basicProduction[$resourceID] + $PLANET[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name'].'_used'];
			$bonusProduction[$resourceID]	= $temp[$resourceID]['plus'] * $USER['factor']['Energy'];
			$dailyProduction[$resourceID]	= $totalProduction[$resourceID];
			$weeklyProduction[$resourceID]	= $totalProduction[$resourceID];
		}
			
		$prodSelector	= array();
		
		foreach(range(0, 100, 10) as $procent) {
			$prodSelector[$procent]	= $procent.'%';
		}
		
		$this->assign(array(	
			'header'			=> sprintf($LNG['rs_production_on_planet'], $PLANET['name']),
			'prodSelector'		=> $prodSelector,
			'productionList'	=> $productionList,
			'basicProduction'	=> $basicProduction,
			'totalProduction'	=> $totalProduction,
			'bonusProduction'	=> $bonusProduction,
			'dailyProduction'	=> $dailyProduction,
			'weeklyProduction'	=> $weeklyProduction,
			'storage'			=> $storage,
			'ressIDs'			=> $ressIDs,
		));
		
		$this->render('page.resources.default.tpl');
	}
}
