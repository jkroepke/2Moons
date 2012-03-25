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

class ShowBuildingsPage extends AbstractPage
{	
	public static $requireModule = MODULE_BUILDING;

	function __construct() 
	{
		parent::__construct();
	}
	
	private function CancelBuildingFromQueue()
	{
		global $PLANET, $USER, $resource;
		$CurrentQueue  = unserialize($PLANET['b_building_id']);
		if (empty($CurrentQueue))
		{
			$PLANET['b_building_id']	= '';
			$PLANET['b_building']		= 0;
			return;
		}
	
		$elementID             	= $CurrentQueue[0][0];
		$BuildMode          	= $CurrentQueue[0][4];
		
		$costRessources			= BuildFunctions::getElementPrice($USER, $PLANET, $elementID, $BuildMode == 'destroy');
		
		foreach ($GLOBALS['VARS']['LIST'][ELEMENT_PLANET_RESOURCE] as $resourceID) {
			$PLANET[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name']]	+= $costRessources[$resourceID];
		}
		
		foreach ($GLOBALS['VARS']['LIST'][ELEMENT_USER_RESOURCE] as $resourceID)  {
			$USER[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name']]		+= $costRessources[$resourceID];
		}
				
		array_shift($CurrentQueue);
		if (count($CurrentQueue) == 0) {
			$PLANET['b_building']    	= 0;
			$PLANET['b_building_id'] 	= '';
		} else {
			$BuildEndTime	= TIMESTAMP;
			$NewQueueArray	= array();
			foreach($CurrentQueue as $ListIDArray) {
				if($elementID == $ListIDArray[0])
					continue;
					
				$BuildEndTime       += BuildFunctions::getBuildingTime($USER, $PLANET, $ListIDArray[0], NULL, $ListIDArray[4] == 'destroy');
				$ListIDArray[3]		= $BuildEndTime;
				$NewQueueArray[]	= $ListIDArray;					
			}
			
			if(!empty($NewQueueArray)) {
				$PLANET['b_building']    	= TIMESTAMP;
				$PLANET['b_building_id'] 	= serialize($NewQueueArray);
				$this->ecoObj->USER			= $USER;
				$this->ecoObj->PLANET		= $PLANET;
				$this->ecoObj->SetNextQueueElementOnTop();
				$USER						= $this->ecoObj->USER;
				$PLANET						= $this->ecoObj->PLANET;
			} else {
				$PLANET['b_building']    	= 0;
				$PLANET['b_building_id'] 	= '';

			}
		}
	}

	private function RemoveBuildingFromQueue($QueueID)
	{
		global $USER, $PLANET;
		if ($QueueID <= 1 || empty($PLANET['b_building_id'])) {
            return false;
        }

		$CurrentQueue  = unserialize($PLANET['b_building_id']);
		$ActualCount   = count($CurrentQueue);
		if($ActualCount <= 1) {
			return $this->CancelBuildingFromQueue();
        }

		$elementID		= $CurrentQueue[$QueueID - 2][0];
		$BuildEndTime	= $CurrentQueue[$QueueID - 2][3];
		unset($CurrentQueue[$QueueID - 1]);
		$NewQueueArray	= array();
		foreach($CurrentQueue as $elementID => $ListIDArray)
		{				
			if ($elementID < $QueueID - 1) {
				$NewQueueArray[]	= $ListIDArray;
			} else {
				if($elementID == $ListIDArray[0] || empty($ListIDArray[0]))
					continue;

				$BuildEndTime       += BuildFunctions::getBuildingTime($USER, $PLANET, $ListIDArray[0]);
				$ListIDArray[3]		= $BuildEndTime;
				$NewQueueArray[]	= $ListIDArray;				
			}
		}

		if(!empty($NewQueueArray))
			$PLANET['b_building_id'] = serialize($NewQueueArray);
		else
			$PLANET['b_building_id'] = "";

        return true;
	}

	private function AddBuildingToQueue($elementID, $AddMode = true)
	{
		global $PLANET, $USER, $resource, $CONF, $reslist, $pricelist;
		
		if(!BuildFunctions::isTechnologieAccessible($USER, $PLANET, $elementID) 
			|| ($elementID == 31 && $USER['b_tech_planet'] != 0) 
			|| (($elementID == 15 || $elementID == 21) && !empty($PLANET['b_hangar_id']))
			|| (!$AddMode && $PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']] == 0)
		)
			return;
			
		$CurrentQueue  		= unserialize($PLANET['b_building_id']);

				
		if (!empty($CurrentQueue)) {
			$ActualCount	= count($CurrentQueue);
		} else {
			$CurrentQueue	= array();
			$ActualCount	= 0;
		}
		
		$CurrentMaxFields  	= CalculateMaxPlanetFields($PLANET);
		
		if (($CONF['max_elements_build'] != 0 && $ActualCount == $CONF['max_elements_build']) || ($AddMode && $PLANET["field_current"] >= ($CurrentMaxFields - $ActualCount)))
			return;
	
		$BuildMode 			= $AddMode ? 'build' : 'destroy';
		$BuildLevel			= $PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']] + (int) $AddMode;
		
		if($ActualCount == 0)
		{
			if(!empty($GLOBALS['VARS']['ELEMENT'][$elementID]['maxLevel']) && $GLOBALS['VARS']['ELEMENT'][$elementID]['maxLevel'] < $BuildLevel)
				return;

			$costRessources		= BuildFunctions::getElementPrice($USER, $PLANET, $elementID, !$AddMode);
			
			if(!BuildFunctions::isElementBuyable($USER, $PLANET, $elementID, $costRessources))
				return;
			
			foreach ($GLOBALS['VARS']['LIST'][ELEMENT_PLANET_RESOURCE] as $resourceID) {
				$PLANET[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name']]	-= $costRessources[$resourceID];
			}
			
			foreach ($GLOBALS['VARS']['LIST'][ELEMENT_USER_RESOURCE] as $resourceID)  {
				$USER[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name']]		-= $costRessources[$resourceID];
			}
			
			$elementTime    			= BuildFunctions::getBuildingTime($USER, $PLANET, $elementID, $costRessources);
			$BuildEndTime				= TIMESTAMP + $elementTime;
			
			$PLANET['b_building_id']	= serialize(array(array($elementID, $BuildLevel, $elementTime, $BuildEndTime, $BuildMode)));
			$PLANET['b_building']		= $BuildEndTime;
			
		} else {
			$addLevel = 0;
			foreach($CurrentQueue as $QueueSubArray)
			{
				if($QueueSubArray[0] != $elementID)
					continue;
					
				if($QueueSubArray[4] == 'build')
					$addLevel++;
				else
					$addLevel--;
			}
			
			$BuildLevel					+= $addLevel;
			
			if(!$AddMode && $BuildLevel == 0)
				return;
				
			if(!empty($GLOBALS['VARS']['ELEMENT'][$elementID]['maxLevel']) && $GLOBALS['VARS']['ELEMENT'][$elementID]['maxLevel'] < $BuildLevel)
				return;
				
			$elementTime    			= BuildFunctions::getBuildingTime($USER, $PLANET, $elementID, NULL, !$AddMode, $BuildLevel);
			$BuildEndTime				= $CurrentQueue[$ActualCount - 1][3] + $elementTime;
			$CurrentQueue[]				= array($elementID, $BuildLevel, $elementTime, $BuildEndTime, $BuildMode);
			$PLANET['b_building_id']	= serialize($CurrentQueue);		
		}

	}

	private function getQueueData()
	{
		global $LNG, $CONF, $PLANET, $USER;
		
		$scriptData		= array();
		$buildLevels	= array();
		
		if ($PLANET['b_building'] == 0 || $PLANET['b_building_id'] == "")
			return array();
		
		$buildQueue		= unserialize($PLANET['b_building_id']);
		
		foreach($buildQueue as $BuildArray) {
			if ($BuildArray[3] < TIMESTAMP)
				continue;

			$scriptData[] = array(
				'element'	=> $BuildArray[0], 
				'level' 	=> $BuildArray[1], 
				'time' 		=> $BuildArray[2], 
				'resttime' 	=> ($BuildArray[3] - TIMESTAMP), 
				'destroy' 	=> ($BuildArray[4] == 'destroy'), 
				'endtime' 	=> _date('U', $BuildArray[3], $USER['timezone']),
				'display' 	=> _date($LNG['php_tdformat'], $BuildArray[3], $USER['timezone']),
			);
		}
		
		return $scriptData;
	}

	public function show()
	{
		global $ProdGrid, $LNG, $resource, $reslist, $CONF, $PLANET, $USER, $pricelist;
		
		$TheCommand		= HTTP::_GP('cmd', '');

		$planetFlag		= $PLANET['planet_type'] == 3 ? ELEMENT_BUILD_ON_MOON : ELEMENT_BUILD_ON_PLANET;
		
		// wellformed buildURLs
		if(!empty($TheCommand) && $_SERVER['REQUEST_METHOD'] === 'POST' && $USER['urlaubs_modus'] == 0 && elementHasFlag($elementID, $planetFlag))
		{
			$elementID     	= HTTP::_GP('building', 0);
			$ListID      	= HTTP::_GP('listid', 0);
			switch($TheCommand)
			{
				case 'cancel':
					$this->CancelBuildingFromQueue();
				break;
				case 'remove':
					$this->RemoveBuildingFromQueue($ListID);
				break;
				case 'insert':
					$this->AddBuildingToQueue($elementID, true);
				break;
				case 'destroy':
					$this->AddBuildingToQueue($elementID, false);
				break;
			}
			
			$this->redirectTo('game.php?page=buildings');
		}
		
		$Queue	 			= $this->getQueueData();
		$QueueCount			= count($Queue);
		$CanBuildElement 	= isVacationMode($USER) || $CONF['max_elements_build'] == 0 || $QueueCount < $CONF['max_elements_build'];
		$CurrentMaxFields   = CalculateMaxPlanetFields($PLANET);
		
		$RoomIsOk 			= $PLANET['field_current'] < ($CurrentMaxFields - $QueueCount);
				
		$BuildEnergy		= $USER[$GLOBALS['VARS']['ELEMENT'][113]['name']];
		$BuildTemp          = $PLANET['temp_max'];

        $BuildInfoList      = array();

		foreach($GLOBALS['VARS']['LIST'][ELEMENT_BUILD] as $elementID)
		{
			if (!BuildFunctions::isTechnologieAccessible($USER, $PLANET, $elementID) || !elementHasFlag($elementID, $planetFlag)) {
				continue;
			}
			
			$infoEnergy	= "";
			
			if(elementHasFlag($elementID, ELEMENT_PRODUCTION))
			{
				$BuildLevel	= $PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']];
				$Need		= round(eval(ResourceUpdate::getProd($GLOBALS['VARS']['ELEMENT'][$elementID]['production'][911])));
				
				if($Need > 0)
					$Need	= $Need * (1 + $USER['factor']['Energy']);
					
				$BuildLevel	+= 1;
				$Prod		= round(eval(ResourceUpdate::getProd($GLOBALS['VARS']['ELEMENT'][$elementID]['production'][911])));
				if($Prod > 0)
					$Need	= $Need * (1 + $USER['factor']['Energy']);
					
				$requireEnergy	= $Prod - $Need;
				
				if($requireEnergy < 0) {
					$infoEnergy	= sprintf($LNG['bd_need_engine'], pretty_number(abs($requireEnergy)), $LNG['tech'][911]);
				} else {
					$infoEnergy	= sprintf($LNG['bd_more_engine'], pretty_number(abs($requireEnergy)), $LNG['tech'][911]);
				}
			}
			
			$costRessources		= BuildFunctions::getElementPrice($USER, $PLANET, $elementID);
			$costOverflow		= BuildFunctions::getRestPrice($USER, $PLANET, $elementID, $costRessources);
			$elementTime    	= BuildFunctions::getBuildingTime($USER, $PLANET, $elementID, $costRessources);
			$destroyRessources	= BuildFunctions::getElementPrice($USER, $PLANET, $elementID, true);
			$destroyTime		= BuildFunctions::getBuildingTime($USER, $PLANET, $elementID, $destroyRessources);
			$buyable			= $QueueCount != 0 || BuildFunctions::isElementBuyable($USER, $PLANET, $elementID, $costRessources);

			$BuildInfoList[$elementID]	= array(
				'level'				=> $PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']],
				'maxLevel'			=> $GLOBALS['VARS']['ELEMENT'][$elementID]['maxLevel'],
				'infoEnergy'		=> $infoEnergy,
				'costRessources'	=> array_filter($costRessources),
				'costOverflow'		=> $costOverflow,
				'elementTime'    	=> $elementTime,
				'destroyRessources'	=> array_filter($destroyRessources),
				'destroyTime'		=> $destroyTime,
				'buyable'			=> $buyable,
			);
		}

		
		if ($QueueCount != 0) {
			$this->tplObj->loadscript('buildlist.js');
		}
		
		$this->tplObj->assign_vars(array(
			'BuildInfoList'		=> $BuildInfoList,
			'CanBuildElement'	=> $CanBuildElement,
			'RoomIsOk'			=> $RoomIsOk,
			'Queue'				=> $Queue,
			'isBusy'			=> array('shipyard' => !empty($PLANET['b_hangar_id']), 'research' => $USER['b_tech_planet'] != 0),
			'HaveMissiles'		=> (bool) $PLANET[$GLOBALS['VARS']['ELEMENT'][503]['name']] + $PLANET[$GLOBALS['VARS']['ELEMENT'][502]['name']],
		));
			
		$this->display('page.buildings.default.tpl');
	}
}
?>