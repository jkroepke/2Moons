<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
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
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.2 (2013-03-18)
 * @info $Id$
 * @link http://2moons.cc/
 */

class ShowBuildingsPage extends AbstractGamePage
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
			return false;
		}
	
		$Element             	= $CurrentQueue[0][0];
		$BuildMode          	= $CurrentQueue[0][4];
		
		$costResources			= BuildFunctions::getElementPrice($USER, $PLANET, $Element, $BuildMode == 'destroy');
		
		if(isset($costResources[901])) { $PLANET[$resource[901]]	+= $costResources[901]; }
		if(isset($costResources[902])) { $PLANET[$resource[902]]	+= $costResources[902]; }
		if(isset($costResources[903])) { $PLANET[$resource[903]]	+= $costResources[903]; }
		if(isset($costResources[921])) { $USER[$resource[921]]		+= $costResources[921]; }
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
				$this->ecoObj->setData($USER, $PLANET);
				$this->ecoObj->SetNextQueueElementOnTop();
				list($USER, $PLANET)		= $this->ecoObj->getData();
			} else {
				$PLANET['b_building']    	= 0;
				$PLANET['b_building_id'] 	= '';
			}
		}
		return true;
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

	private function AddBuildingToQueue($Element, $AddMode = true)
	{
		global $PLANET, $USER, $resource, $reslist, $pricelist;
		
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

		$config	= Config::get();

		if (($config->max_elements_build != 0 && $ActualCount == $config->max_elements_build)
			|| ($AddMode && $PLANET["field_current"] >= ($CurrentMaxFields - $ActualCount)))
		{
			return;
		}
	
		$BuildMode 			= $AddMode ? 'build' : 'destroy';
		$BuildLevel			= $PLANET[$resource[$Element]] + (int) $AddMode;
		
		if($ActualCount == 0)
		{
			if($pricelist[$Element]['max'] < $BuildLevel)
				return;

			$costResources		= BuildFunctions::getElementPrice($USER, $PLANET, $Element, !$AddMode);
			
			if(!BuildFunctions::isElementBuyable($USER, $PLANET, $Element, $costResources))
				return;
			
			if(isset($costResources[901])) { $PLANET[$resource[901]]	-= $costResources[901]; }
			if(isset($costResources[902])) { $PLANET[$resource[902]]	-= $costResources[902]; }
			if(isset($costResources[903])) { $PLANET[$resource[903]]	-= $costResources[903]; }
			if(isset($costResources[921])) { $USER[$resource[921]]		-= $costResources[921]; }
			
			$elementTime    			= BuildFunctions::getBuildingTime($USER, $PLANET, $Element, $costResources);
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

	}

	private function getQueueData()
	{
		global $LNG, $PLANET, $USER;
		
		$scriptData		= array();
		$quickinfo		= array();
		
		if ($PLANET['b_building'] == 0 || $PLANET['b_building_id'] == "")
			return array('queue' => $scriptData, 'quickinfo' => $quickinfo);
		
		$buildQueue		= unserialize($PLANET['b_building_id']);
		
		foreach($buildQueue as $BuildArray) {
			if ($BuildArray[3] < TIMESTAMP)
				continue;
			
			$quickinfo[$BuildArray[0]]	= $BuildArray[1];
			
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
		
		return array('queue' => $scriptData, 'quickinfo' => $quickinfo);
	}

	public function show()
	{
		global $ProdGrid, $LNG, $resource, $reslist, $PLANET, $USER, $pricelist;
		
		$TheCommand		= HTTP::_GP('cmd', '');

		// wellformed buildURLs
		if(!empty($TheCommand) && $_SERVER['REQUEST_METHOD'] === 'POST' && $USER['urlaubs_modus'] == 0)
		{
			$Element     	= HTTP::_GP('building', 0);
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
					$this->AddBuildingToQueue($Element, true);
				break;
				case 'destroy':
					$this->AddBuildingToQueue($Element, false);
				break;
			}
			
			$this->redirectTo('game.php?page=buildings');
		}

		$config				= Config::get();

		$queueData	 		= $this->getQueueData();
		$Queue	 			= $queueData['queue'];
		$QueueCount			= count($Queue);
		$CanBuildElement 	= isVacationMode($USER) || $config->max_elements_build == 0 || $QueueCount < $config->max_elements_build;
		$CurrentMaxFields   = CalculateMaxPlanetFields($PLANET);
		
		$RoomIsOk 			= $PLANET['field_current'] < ($CurrentMaxFields - $QueueCount);
				
		$BuildEnergy		= $USER[$resource[113]];
		$BuildLevelFactor   = 10;
		$BuildTemp          = $PLANET['temp_max'];

        $BuildInfoList      = array();

		$Elements			= $reslist['allow'][$PLANET['planet_type']];
		
		foreach($Elements as $Element)
		{
			if (!BuildFunctions::isTechnologieAccessible($USER, $PLANET, $Element))
				continue;

			$infoEnergy	= "";
			
			if(isset($queueData['quickinfo'][$Element]))
			{
				$levelToBuild	= $queueData['quickinfo'][$Element];
			}
			else
			{
				$levelToBuild	= $PLANET[$resource[$Element]];
			}
			
			if(in_array($Element, $reslist['prod']))
			{
				$BuildLevel	= $PLANET[$resource[$Element]];
				$Need		= eval(ResourceUpdate::getProd($ProdGrid[$Element]['production'][911]));
									
				$BuildLevel	= $levelToBuild + 1;
				$Prod		= eval(ResourceUpdate::getProd($ProdGrid[$Element]['production'][911]));
					
				$requireEnergy	= $Prod - $Need;
				$requireEnergy	= round($requireEnergy * $config->energySpeed);

				if($requireEnergy < 0) {
					$infoEnergy	= sprintf($LNG['bd_need_engine'], pretty_number(abs($requireEnergy)), $LNG['tech'][911]);
				} else {
					$infoEnergy	= sprintf($LNG['bd_more_engine'], pretty_number(abs($requireEnergy)), $LNG['tech'][911]);
				}
			}
			
			$costResources		= BuildFunctions::getElementPrice($USER, $PLANET, $Element, false, $levelToBuild);
			$costOverflow		= BuildFunctions::getRestPrice($USER, $PLANET, $Element, $costResources);
			$elementTime    	= BuildFunctions::getBuildingTime($USER, $PLANET, $Element, $costResources);
			$destroyResources	= BuildFunctions::getElementPrice($USER, $PLANET, $Element, true);
			$destroyTime		= BuildFunctions::getBuildingTime($USER, $PLANET, $Element, $destroyResources);
			$destroyOverflow	= BuildFunctions::getRestPrice($USER, $PLANET, $Element, $destroyResources);
			$buyable			= $QueueCount != 0 || BuildFunctions::isElementBuyable($USER, $PLANET, $Element, $costResources);

			$BuildInfoList[$Element]	= array(
				'level'				=> $PLANET[$resource[$Element]],
				'maxLevel'			=> $pricelist[$Element]['max'],
				'infoEnergy'		=> $infoEnergy,
				'costResources'		=> $costResources,
				'costOverflow'		=> $costOverflow,
				'elementTime'    	=> $elementTime,
				'destroyResources'	=> $destroyResources,
				'destroyTime'		=> $destroyTime,
				'destroyOverflow'	=> $destroyOverflow,
				'buyable'			=> $buyable,
				'levelToBuild'		=> $levelToBuild,
			);
		}

		
		if ($QueueCount != 0) {
			$this->tplObj->loadscript('buildlist.js');
		}
		
		$this->assign(array(
			'BuildInfoList'		=> $BuildInfoList,
			'CanBuildElement'	=> $CanBuildElement,
			'RoomIsOk'			=> $RoomIsOk,
			'Queue'				=> $Queue,
			'isBusy'			=> array('shipyard' => !empty($PLANET['b_hangar_id']), 'research' => $USER['b_tech_planet'] != 0),
			'HaveMissiles'		=> (bool) $PLANET[$resource[503]] + $PLANET[$resource[502]],
		));
			
		$this->display('page.buildings.default.tpl');
	}
}