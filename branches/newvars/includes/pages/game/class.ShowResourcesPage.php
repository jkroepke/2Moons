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

class ShowResourcesPage extends AbstractPage
{
	public static $requireModule = MODULE_RESSOURCE_LIST;

	function __construct() 
	{
		parent::__construct();
	}
	
	function send()
	{
		global $LNG, $resource, $USER, $PLANET;
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
				$GLOBALS['DATABASE']->query("UPDATE ".PLANETS." SET ".implode(", ", $updateSQL).", ecohash = '' WHERE `id` = ".$PLANET['id'] .";");
			}	
		}
		
		$this->save();
		$this->redirectTo('game.php?page=resources');
	}
	function show()
	{
		global $LNG, $ProdGrid, $resource, $reslist, $CONF, $pricelist, $USER, $PLANET;
		
		if ($PLANET['planet_type'] == 3)
		{
			$CONF['metal_basic_income']     	= 0;
			$CONF['crystal_basic_income']   	= 0;
			$CONF['deuterium_basic_income'] 	= 0;
		}
		
		$ressIDs	= array_merge($GLOBALS['VARS']['LIST'][ELEMENT_PLANET_RESOURCE], $GLOBALS['VARS']['LIST'][ELEMENT_ENERGY]);
		$temp		= combineArrayWithSingleElement($ressIDs, array(
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
		
		foreach($GLOBALS['VARS']['LIST'][ELEMENT_PRODUCTION] as $elementID)
		{	
			$BuildLevel 		= $PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']];
		
			$productionList[$elementID]	= array(
				'production'	=> array(901 => 0, 902 => 0, 903 => 0, 911 => 0),
				'elementLevel'	=> $PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']],
				'prodLevel'		=> $PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name'].'_percent'],
			);
			
			foreach($ressIDs as $ID) 
			{
				if(!isset($ProdGrid[$elementID]['production'][$ID]))
					continue;
					
				$Production	= eval(ResourceUpdate::getProd($ProdGrid[$elementID]['production'][$ID]));
				$Production	*= $this->PLANET[$GLOBALS['VARS']['ELEMENT'][$prodID]['name'].'_percent'] / 100;
				
				if($ID != 911) {
					$Production	*= $prodLevel * $CONF['resource_multiplier'];
				}
				
				$productionList[$elementID]['production'][$ID]	= $Production;
				
				if($Production > 0) {
					if($PLANET[$GLOBALS['VARS']['ELEMENT'][$ID]['name']] == 0) continue;
					
					$temp[$ID]['plus']	+= $Production;
				} else {
					$temp[$ID]['minus']	+= $Production;
				}
			}
		}
		
		$storage	= array();
		$basicProduction	= array();
		$totalProduction	= array();
		$bonusProduction	= array();
		$dailyProduction	= array();
		$weeklyProduction	= array();
		
		foreach($GLOBALS['VARS']['LIST'][ELEMENT_PLANET_RESOURCE] as $elementID) 
		{	
			$storage[$elementID]			= shortly_number($PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name'].'_max']);
			$basicProduction[$elementID]	= $CONF[$GLOBALS['VARS']['ELEMENT'][$elementID]['name'].'_basic_income'] * $CONF['resource_multiplier'];
			$totalProduction[$elementID]	= $PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name'].'_perhour'] + $basicProduction[$elementID];
			$bonusProduction[$elementID]	= $temp[$elementID]['plus'] * $USER['factor']['Resource'];
			$dailyProduction[$elementID]	= $totalProduction[$elementID] * 24;
			$weeklyProduction[$elementID]	= $totalProduction[$elementID] * 168;
		}
		
		foreach($GLOBALS['VARS']['LIST'][ELEMENT_ENERGY] as $elementID) 
		{	
			$basicProduction[$elementID]	= $CONF[$GLOBALS['VARS']['ELEMENT'][$elementID]['name'].'_basic_income'] * $CONF['resource_multiplier'];
			$totalProduction[$elementID]	= $PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']] + $basicProduction[$elementID] + $PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name'].'_used'];
			$bonusProduction[$elementID]	= $temp[$elementID]['plus'] * $USER['factor']['Energy'];
			$dailyProduction[$elementID]	= $totalProduction[$elementID];
			$weeklyProduction[$elementID]	= $totalProduction[$elementID];
		}
			
		$prodSelector	= array();
		
		foreach(range(0, 100, 10) as $procent) {
			$prodSelector[$procent]	= $procent.'%';
		}
		
		$this->tplObj->assign_vars(array(	
			'header'			=> sprintf($LNG['rs_production_on_planet'], $PLANET['name']),
			'prodSelector'		=> $prodSelector,
			'productionList'	=> $productionList,
			'basicProduction'	=> $basicProduction,
			'totalProduction'	=> $totalProduction,
			'bonusProduction'	=> $bonusProduction,
			'dailyProduction'	=> $dailyProduction,
			'weeklyProduction'	=> $weeklyProduction,
			'storage'			=> $storage,
		));
		
		$this->display('page.resources.default.tpl');
	}
}
