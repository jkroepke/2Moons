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
 

class ShowShipyardPage extends AbstractPage
{
	public static $requireModule = 0;
	
	public static $defaultController = 'show';

	function __construct() 
	{
		parent::__construct();
	}
	
	private function CancelAuftr() 
	{
		global $USER, $PLANET, $resource;
		$elementIDQueue = unserialize($PLANET['b_hangar_id']);
		
		$CancelArray	= HTTP::_GP('auftr', array());
		
		foreach ($CancelArray as $Auftr)
		{
			if(!isset($elementIDQueue[$Auftr])) {
				continue;
			}
			
			if($Auftr == 0) {
				$PLANET['b_hangar']	= 0;
			}
			
			$elementID		= $elementIDQueue[$Auftr][0];
			$Count			= $elementIDQueue[$Auftr][1];
			
			$costRessources	= BuildFunctions::getElementPrice($USER, $PLANET, $elementID, false, $Count);
			
			foreach ($GLOBALS['VARS']['LIST'][ELEMENT_PLANET_RESOURCE] as $resourceID) {
				$PLANET[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name']]	+= $costRessources[$resourceID] * FACTOR_CANCEL_SHIPYARD;;
			}
			
			foreach ($GLOBALS['VARS']['LIST'][ELEMENT_USER_RESOURCE] as $resourceID)  {
				$USER[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name']]		+= $costRessources[$resourceID] * FACTOR_CANCEL_SHIPYARD;;
			}
			
			unset($elementIDQueue[$Auftr]);
		}
		
		if(empty($elementIDQueue)) {
			$PLANET['b_hangar_id']	= '';
		} else {
			$PLANET['b_hangar_id']	= serialize(array_values($elementIDQueue));
		}

	}
	
	private function BuildAuftr($fmenge, $mode)
	{
		global $USER, $PLANET, $reslist, $CONF, $resource;	
		
		$Missiles	= array(
			502	=> $PLANET[$GLOBALS['VARS']['ELEMENT'][502]['name']],
			503	=> $PLANET[$GLOBALS['VARS']['ELEMENT'][503]['name']],
		);

		if($mode == 'defense') {
			$elementFlag	= ELEMENT_DEFENSIVE;
		} else {
			$elementFlag	= ELEMENT_FLEET;
		}
		
		foreach($fmenge as $elementID => $Count)
		{
			if(empty($Count) || !elementHasFlag($elementID, $elementFlag) || !BuildFunctions::isTechnologieAccessible($USER, $PLANET, $elementID)) {
				continue;
			}
			
			$MaxElements 	= BuildFunctions::getMaxConstructibleElements($USER, $PLANET, $elementID);
			$Count			= is_numeric($Count) ? round($Count) : 0;
			$Count 			= max(min($Count, $CONF['max_fleet_per_build']), 0);
			$Count 			= min($Count, $MaxElements);
			
			$BuildArray    	= !empty($PLANET['b_hangar_id']) ? unserialize($PLANET['b_hangar_id']) : array();
			if ($elementID == 502 || $elementID == 503)
			{
				$MaxMissiles		= BuildFunctions::getMaxConstructibleRockets($USER, $PLANET, $Missiles);
				$Count 				= min($Count, $MaxMissiles[$elementID]);

				$Missiles[$elementID] += $Count;
			} elseif(elementHasFlag($elementID, ELEMENT_ONEPERPLANET)) {
				$InBuild	= false;
				foreach($BuildArray as $elementIDArray) {
					if($elementIDArray[1] == $elementID) {
						$InBuild	= true;
						break;
					}
				}
				
				if($Count != 0 && $PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']] == 0 && $InBuild === false)
					$Count =  1;
			}

			if(empty($Count))
				continue;
				
			$costRessources	= BuildFunctions::getElementPrice($USER, $PLANET, $elementID, false, $Count);
		
			
			foreach ($GLOBALS['VARS']['LIST'][ELEMENT_PLANET_RESOURCE] as $resourceID) {
				$PLANET[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name']]	-= $costRessources[$resourceID];
			}
			
			foreach ($GLOBALS['VARS']['LIST'][ELEMENT_USER_RESOURCE] as $resourceID)  {
				$USER[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name']]		-= $costRessources[$resourceID];
			}
			
			$BuildArray[]			= array($elementID, $Count);
			$PLANET['b_hangar_id']	= serialize($BuildArray);

		}
	}
	
	public function show()
	{
		global $USER, $PLANET, $LNG, $resource, $dpath, $reslist, $CONF;
		
		if ($PLANET[$GLOBALS['VARS']['ELEMENT'][21]['name']] == 0)
		{
			$this->printMessage($LNG['bd_shipyard_required']);
		}

		$fmenge	= isset($_POST['fmenge']) ? $_POST['fmenge'] : array();
		$action	= HTTP::_GP('action', '');
								
		$NotBuilding = true;
		if (!empty($PLANET['b_building_id']))
		{
			$CurrentQueue 	= unserialize($PLANET['b_building_id']);
			foreach($CurrentQueue as $elementIDArray) {
				if($elementIDArray[0] == 21 || $elementIDArray[0] == 15) {
					$NotBuilding = false;
					break;
				}
			}
		}
		
		$elementIDQueue 	= unserialize($PLANET['b_hangar_id']);
	
		if(empty($elementIDQueue)) {
			$Count	= 0;
		} else {
			$Count	= count($elementIDQueue);
		}
				
		$mode		= HTTP::_GP('mode', 'fleet');
		
		if($USER['urlaubs_modus'] == 0) {
			if (!empty($fmenge) && $NotBuilding == true) {
				if ($CONF['max_elements_ships'] != 0 && $Count >= $CONF['max_elements_ships']) {
					$this->printMessage(sprintf($LNG['bd_max_builds'], $CONF['max_elements_ships']));
					exit;
				}
				$this->BuildAuftr($fmenge, $mode);
				$this->redirectTo('game.php?page=shipyard&mode='.$mode);
			}
					
			if ($action == "delete") {
				$this->CancelAuftr();
				$this->redirectTo('game.php?page=shipyard&mode='.$mode);
			}
		}
		
		if($mode == 'defense') {
			$elementIDs	= $GLOBALS['VARS']['LIST'][ELEMENT_DEFENSIVE];
		} else {
			$elementIDs	= $GLOBALS['VARS']['LIST'][ELEMENT_FLEET];
		}
		
		$Missiles	= array(
			502	=> $PLANET[$GLOBALS['VARS']['ELEMENT'][502]['name']],
			503	=> $PLANET[$GLOBALS['VARS']['ELEMENT'][503]['name']],
		);
		
		$MaxMissiles	= BuildFunctions::getMaxConstructibleRockets($USER, $PLANET, $Missiles);
		
		foreach($elementIDs as $elementID)
		{
			if(!BuildFunctions::isTechnologieAccessible($USER, $PLANET, $elementID))
				continue;
			
			$costRessources		= BuildFunctions::getElementPrice($USER, $PLANET, $elementID);
			$costOverflow		= BuildFunctions::getRestPrice($USER, $PLANET, $elementID, $costRessources);
			$elementTime    	= BuildFunctions::getBuildingTime($USER, $PLANET, $elementID, $costRessources);
			$buyable			= BuildFunctions::isElementBuyable($USER, $PLANET, $elementID, $costRessources);
			$maxBuildable		= BuildFunctions::getMaxConstructibleElements($USER, $PLANET, $elementID, $costRessources);

			if(isset($MaxMissiles[$elementID])) {
				$maxBuildable	= min($maxBuildable, $MaxMissiles[$elementID]);
			}
			
			$AlreadyBuild		= elementHasFlag($elementID, ELEMENT_ONEPERPLANET) && (strpos($PLANET['b_hangar_id'], $elementID.",") !== false || $PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']] != 0);
			
			$elementList[$elementID]	= array(
				'id'				=> $elementID,
				'available'			=> $PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']],
				'costRessources'	=> array_filter($costRessources),
				'costOverflow'		=> $costOverflow,
				'elementTime'    	=> $elementTime,
				'buyable'			=> $buyable,
				'maxBuildable'		=> floattostring($maxBuildable),
				'AlreadyBuild'		=> $AlreadyBuild,
			);
		}
		
		
		$elementIDQueue 	= unserialize($PLANET['b_hangar_id']);
		$Buildlist		= array();
		if(!empty($elementIDQueue))
		{
			$Shipyard		= array();
			$QueueTime		= 0;
			foreach($elementIDQueue as $elementID)
			{
				if (empty($elementID))
					continue;
					
				$elementIDTime  	= BuildFunctions::getBuildingTime( $USER, $PLANET, $elementID[0]);
				$QueueTime   	+= $elementIDTime * $elementID[1];
				$Shipyard[]		= array($LNG['tech'][$elementID[0]], $elementID[1], $elementIDTime, $elementID[0]);		
			}

			$this->tplObj->loadscript('bcmath.js');
			$this->tplObj->loadscript('shipyard.js');
			$this->tplObj->execscript('ShipyardInit();');
			
			$Buildlist	= array(
				'Queue' 				=> $Shipyard,
				'b_hangar_id_plus' 		=> $PLANET['b_hangar'],
				'pretty_time_b_hangar' 	=> pretty_time(max($QueueTime - $PLANET['b_hangar'],0)),
			);
		}
		
		$this->tplObj->assign_vars(array(
			'elementList'	=> $elementList,
			'NotBuilding'	=> $NotBuilding,
			'BuildList'		=> $Buildlist,
			'maxlength'		=> strlen($CONF['max_fleet_per_build']),
			'mode'			=> $mode,
		));

		$this->display('page.shipyard.default.tpl');
	}
}
