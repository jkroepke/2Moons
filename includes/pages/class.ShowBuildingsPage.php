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


class ShowBuildingsPage
{	
	public function CancelBuildingFromQueue($PlanetRess)
	{
		global $PLANET, $USER, $resource;
		$CurrentQueue  = unserialize($PLANET['b_building_id']);
		if (empty($CurrentQueue))
		{
			$PLANET['b_building_id']	= '';
			$PLANET['b_building']		= 0;
			return;
		}
	
		$Element             	= $CurrentQueue[0][0];
		$BuildMode          	= $CurrentQueue[0][4];
		
		$costRessources			= BuildFunctions::getElementPrice($USER, $PLANET, $Element, $BuildMode == 'destroy');
		
		if(isset($costRessources[901])) { $PLANET[$resource[901]]	+= $costRessources[901]; }
		if(isset($costRessources[902])) { $PLANET[$resource[902]]	+= $costRessources[902]; }
		if(isset($costRessources[903])) { $PLANET[$resource[903]]	+= $costRessources[903]; }
		if(isset($costRessources[921])) { $USER[$resource[921]]		+= $costRessources[921]; }
		array_shift($CurrentQueue);
		if (count($CurrentQueue) == 0) {
			$PLANET['b_building']    	= 0;
			$PLANET['b_building_id'] 	= '';
		} else {
			$BuildEndTime	= TIMESTAMP;
			$NewQueueArray	= array();
			foreach($CurrentQueue as $ListIDArray) {
				if($Element == $ListIDArray[0])
					continue;
					
				$BuildEndTime       += BuildFunctions::getBuildingTime($USER, $PLANET, $ListIDArray[0], NULL, $ListIDArray[4] == 'destroy');
				$ListIDArray[3]		= $BuildEndTime;
				$NewQueueArray[]	= $ListIDArray;					
			}
			
			if(!empty($NewQueueArray)) {
				$PLANET['b_building']    	= TIMESTAMP;
				$PLANET['b_building_id'] 	= serialize($NewQueueArray);
				$PlanetRess->USER			= $USER;
				$PlanetRess->PLANET			= $PLANET;
				$PlanetRess->SetNextQueueElementOnTop();
				$USER						= $PlanetRess->USER;
				$PLANET						= $PlanetRess->PLANET;
			} else {
				$PLANET['b_building']    	= 0;
				$PLANET['b_building_id'] 	= '';
				FirePHP::getInstance(true)->log("Queue(Build): ".$PLANET['b_building_id']);
			}
		}
	}

	public function RemoveBuildingFromQueue($QueueID, $PlanetRess)
	{
		global $USER, $PLANET;
		if ($QueueID <= 1 || empty($PLANET['b_building_id']))
			return;
		
		$CurrentQueue  = unserialize($PLANET['b_building_id']);
		$ActualCount   = count($CurrentQueue);
		if($ActualCount <= 1)
			return $this->CancelBuildingFromQueue($PlanetRess);
				
		$Element		= $CurrentQueue[$QueueID - 2][0];
		$BuildEndTime	= $CurrentQueue[$QueueID - 2][3];
		unset($CurrentQueue[$QueueID - 1]);
		$NewQueueArray	= array();
		foreach($CurrentQueue as $ID => $ListIDArray)
		{				
			if ($ID < $QueueID - 1) {
				$NewQueueArray[]	= $ListIDArray;
			} else {
				if($Element == $ListIDArray[0] || empty($ListIDArray[0]))
					continue;

				$BuildEndTime       += BuildFunctions::getBuildingTime($USER, $CPLANET, $ListIDArray[0]);
				$ListIDArray[3]		= $BuildEndTime;
				$NewQueueArray[]	= $ListIDArray;				
			}
		}
		if(!empty($NewQueueArray))
			$PLANET['b_building_id'] = serialize($NewQueueArray);
		else
			$PLANET['b_building_id'] = "";
			
		FirePHP::getInstance(true)->log("Queue(Build): ".$PLANET['b_building_id']);
	}

	public function AddBuildingToQueue($Element, $AddMode = true)
	{
		global $PLANET, $USER, $resource, $CONF, $reslist, $pricelist;
		
		if(!in_array($Element, $reslist['allow'][$PLANET['planet_type']])
			|| !BuildFunctions::isTechnologieAccessible($USER, $PLANET, $Element) 
			|| ($Element == 31 && $USER["b_tech_planet"] != 0) 
			|| (($Element == 15 || $Element == 21) && !empty($PLANET['b_hangar_id']))
			|| (!$AddMode && $PLANET[$resource[$Element]] == 0)
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
		$BuildLevel			= $PLANET[$resource[$Element]] + (int) $AddMode;
		
		if($ActualCount == 0)
		{
			if($pricelist[$Element]['max'] < $BuildLevel)
				return;

			$costRessources		= BuildFunctions::getElementPrice($USER, $PLANET, $Element, !$AddMode);
			
			if(!BuildFunctions::isElementBuyable($USER, $PLANET, $Element, $costRessources))
				return;
			
			if(isset($costRessources[901])) { $PLANET[$resource[901]]	-= $costRessources[901]; }
			if(isset($costRessources[902])) { $PLANET[$resource[902]]	-= $costRessources[902]; }
			if(isset($costRessources[903])) { $PLANET[$resource[903]]	-= $costRessources[903]; }
			if(isset($costRessources[921])) { $USER[$resource[921]]		-= $costRessources[921]; }
			
			$elementTime    			= BuildFunctions::getBuildingTime($USER, $PLANET, $Element, $costRessources);
			$BuildEndTime				= TIMESTAMP + $elementTime;
			
			$PLANET['b_building_id']	= serialize(array(array($Element, $BuildLevel, $elementTime, $BuildEndTime, $BuildMode)));
			$PLANET['b_building']		= $BuildEndTime;
			
		} else {
			$addLevel = 0;
			foreach($CurrentQueue as $QueueSubArray)
			{
				if($QueueSubArray[0] != $Element)
					continue;
					
				if($QueueSubArray[4] == 'build')
					$addLevel++;
				else
					$addLevel--;
			}
			
			$BuildLevel					+= $addLevel;
			
			if(!$AddMode && $BuildLevel == 0)
				return;
				
			if($pricelist[$Element]['max'] < $BuildLevel)
				return;
				
			$elementTime    			= BuildFunctions::getBuildingTime($USER, $PLANET, $Element, NULL, !$AddMode, $BuildLevel);
			$BuildEndTime				= $CurrentQueue[$ActualCount - 1][3] + $elementTime;
			$CurrentQueue[]				= array($Element, $BuildLevel, $elementTime, $BuildEndTime, $BuildMode);
			$PLANET['b_building_id']	= serialize($CurrentQueue);		
		}
		FirePHP::getInstance(true)->log("Queue(Build): ".$PLANET['b_building_id']);
	}

	public function getQueueData()
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
				'endtime' 	=> $BuildArray[3]
			);
		}
		
		return $scriptData;
	}

	public function show()
	{
		global $ProdGrid, $LNG, $resource, $reslist, $CONF, $db, $PLANET, $USER, $pricelist;
		
		$TheCommand		= request_var('cmd', '');

		$PlanetRess 	= new ResourceUpdate();
		$PlanetRess->CalcResource();
		
		// wellformed buildURLs
		if(!empty($TheCommand) && $_SERVER['REQUEST_METHOD'] === 'POST' && $USER['urlaubs_modus'] == 0)
		{
			$Element     	= request_var('building', 0);
			$ListID      	= request_var('listid', 0);
			switch($TheCommand)
			{
				case 'cancel':
					$this->CancelBuildingFromQueue($PlanetRess);
				break;
				case 'remove':
					$this->RemoveBuildingFromQueue($ListID, $PlanetRess);
				break;
				case 'insert':
					$this->AddBuildingToQueue($Element, true);
				break;
				case 'destroy':
					$this->AddBuildingToQueue($Element, false);
				break;
			}
		}
		$PlanetRess->SavePlanetToDB();
		
		
		$Queue	 			= $this->getQueueData();
		$QueueCount			= count($Queue);
		$CanBuildElement 	= isVacationMode($USER) || $CONF['max_elements_build'] == 0 || $QueueCount < $CONF['max_elements_build'];
		$CurrentMaxFields   = CalculateMaxPlanetFields($PLANET);
		
		$RoomIsOk 			= $PLANET['field_current'] < ($CurrentMaxFields - $QueueCount);
				
		$BuildEnergy		= $USER[$resource[113]];
		$BuildLevelFactor   = 10;
		$BuildTemp          = $PLANET['temp_max'];
		
		$Elements			= $reslist['allow'][$PLANET['planet_type']];
		
		foreach($Elements as $ID => $Element)
		{
			if (!BuildFunctions::isTechnologieAccessible($USER, $PLANET, $Element))
				continue;

			$infoEnergy	= "";
			
			if(in_array($Element, $reslist['prod']))
			{
				$BuildLevel	= $PLANET[$resource[$Element]];
				$Need		= round(eval($ProdGrid[$Element][911]) * $CONF['resource_multiplier']);
				
				if($Need > 0)
					$Need	= $Need * $USER['factor']['ressource'][911];
					
				$BuildLevel	+= 1;
				$Prod		= round(eval($ProdGrid[$Element][911]) * $CONF['resource_multiplier']);
				if($Prod > 0)
					$Need	= $Need * $USER['factor']['ressource'][911];
					
				$requireEnergy	= $Prod - $Need;
				
				if($requireEnergy < 0) {
					$infoEnergy	= sprintf($LNG['bd_need_engine'], pretty_number(abs($requireEnergy)), $LNG['tech'][911]);
				} else {
					$infoEnergy	= sprintf($LNG['bd_more_engine'], pretty_number(abs($requireEnergy)), $LNG['tech'][911]);
				}
			}
			
			$costRessources		= BuildFunctions::getElementPrice($USER, $PLANET, $Element);
			$costOverflow		= BuildFunctions::getRestPrice($USER, $PLANET, $Element, $costRessources);
			$elementTime    	= BuildFunctions::getBuildingTime($USER, $PLANET, $Element, $costRessources);
			$destroyRessources	= BuildFunctions::getElementPrice($USER, $PLANET, $Element, true);
			$destroyTime		= BuildFunctions::getBuildingTime($USER, $PLANET, $Element, $destroyRessources);
			$buyable			= $QueueCount != 0 || BuildFunctions::isElementBuyable($USER, $PLANET, $Element, $costRessources);

			$BuildInfoList[$Element]	= array(
				'level'				=> $PLANET[$resource[$Element]],
				'maxLevel'			=> $pricelist[$Element]['max'],
				'infoEnergy'		=> $infoEnergy,
				'costRessources'	=> $costRessources,
				'costOverflow'		=> $costOverflow,
				'elementTime'    	=> $elementTime,
				'destroyRessources'	=> $destroyRessources,
				'destroyTime'		=> $destroyTime,
				'buyable'			=> $buyable,
			);
		}

		$template			= new template();
		
		if ($QueueCount != 0) {
			$template->loadscript('buildlist.js');
		}
		
		$template->assign_vars(array(
			'BuildInfoList'		=> $BuildInfoList,
			'CanBuildElement'	=> $CanBuildElement,
			'RoomIsOk'			=> $RoomIsOk,
			'Queue'				=> $Queue,
			'isBusy'			=> array('shipyard' => !empty($PLANET['b_hangar_id']), 'research' => $USER['b_tech_planet'] != 0),
			'HaveMissiles'		=> (bool) $PLANET[$resource[503]] + $PLANET[$resource[502]],
		));
			
		$template->show("buildings_overview.tpl");
	}
}
?>