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
 * @version 1.8.0 (2013-03-18)
 * @info $Id$
 * @link http://2moons.cc/
 */

require_once('AbstractGamePage.class.php');

class ShowResearchPage extends AbstractGamePage
{
	public static $requireModule = MODULE_RESEARCH;

	function __construct() 
	{
		parent::__construct();
	}
	
	private function CheckLabSettingsInQueue()
	{
		global $PLANET;
		if ($PLANET['b_building'] == 0)
			return true;
			
		$CurrentQueue		= unserialize($PLANET['b_building_id']);
		foreach($CurrentQueue as $ListIDArray) {
			if($ListIDArray[0] == 6 || $ListIDArray[0] == 31)
				return false;
		}

		return true;
	}
	
	private function CancelBuildingFromQueue()
	{
		global $PLANET, $USER;
		$CurrentQueue  = unserialize($USER['b_tech_queue']);
		if (empty($CurrentQueue) || empty($USER['b_tech']))
		{
			$USER['b_tech_queue']	= '';
			$USER['b_tech_planet']	= 0;
			$USER['b_tech_id']		= 0;
			$USER['b_tech']			= 0;

			return false;
		}

		$db = Database::get();

		$elementId		= $USER['b_tech_id'];
		$costResources	= BuildUtil::getElementPrice($USER, $PLANET, $elementId);
		
		if($PLANET['id'] == $USER['b_tech_planet'])
		{
			if(isset($costResources[901])) { $PLANET[$resource[901]]	+= $costResources[901]; }
			if(isset($costResources[902])) { $PLANET[$resource[902]]	+= $costResources[902]; }
			if(isset($costResources[903])) { $PLANET[$resource[903]]	+= $costResources[903]; }
		}
		else
		{
			$params = array('techPlanet' => $USER['b_tech_planet']);
			$sql = "UPDATE %%PLANETS%% SET ";
			if(isset($costResources[901])) {
				$sql	.= $resource[901]." = ".$resource[901]." + :".$resource[901].", ";
				$params[':'.$resource[901]] = $costResources[901];
			}
			if(isset($costResources[902])) {
				$sql	.= $resource[902]." = ".$resource[902]." + :".$resource[902].", ";
				$params[':'.$resource[902]] = $costResources[902];
			}
			if(isset($costResources[903])) {
				$sql	.= $resource[903]." = ".$resource[903]." + :".$resource[903].", ";
				$params[':'.$resource[903]] = $costResources[903];
			}

			$sql = substr($sql, 0, -2);
			$sql .= " WHERE id = :techPlanet;";

			$db->update($sql, $params);
		}
		
		if(isset($costResources[921])) { $USER[$resource[921]]		+= $costResources[921]; }
		
		$USER['b_tech_id']			= 0;
		$USER['b_tech']      		= 0;
		$USER['b_tech_planet']		= 0;

		array_shift($CurrentQueue);

		if (count($CurrentQueue) == 0) {
			$USER['b_tech_queue']	= '';
			$USER['b_tech_planet']	= 0;
			$USER['b_tech_id']		= 0;
			$USER['b_tech']			= 0;
		} else {
			$BuildEndTime		= TIMESTAMP;
			$NewCurrentQueue	= array();
			foreach($CurrentQueue as $ListIDArray)
			{
				if($elementId == $ListIDArray[0] || empty($ListIDArray[0]))
					continue;
					
				if($ListIDArray[4] != $PLANET['id']) {
					$sql = "SELECT :resource6, :resource31 FROM %%PLANETS%% WHERE id = :id;";
					$CPLANET = $db->selectSingle($sql, array(
						':resource6'	=> $resource[6],
						':resource31'	=> $resource[31],
						':id'			=> $ListIDArray[4]
					));
				} else
					$CPLANET		= $PLANET;
				
				$CPLANET[$resource[31].'_inter']	= $this->ecoObj->getNetworkLevel($USER, $CPLANET);
				$BuildEndTime       				+= BuildUtil::getBuildingTime($USER, $CPLANET, NULL, $ListIDArray[0]);
				$ListIDArray[3]						= $BuildEndTime;
				$NewCurrentQueue[]					= $ListIDArray;				
			}
			
			if(!empty($NewCurrentQueue)) {
				$USER['b_tech']    			= TIMESTAMP;
				$USER['b_tech_queue'] 		= serialize($NewCurrentQueue);
				$this->ecoObj->setData($USER, $PLANET);
				$this->ecoObj->SetNextQueueTechOnTop();
				list($USER, $PLANET)		= $this->ecoObj->getData();
			} else {
				$USER['b_tech']    			= 0;
				$USER['b_tech_queue'] 		= '';
			}
		}

		return true;
	}

	private function RemoveBuildingFromQueue($QueueID)
	{
		global $USER, $PLANET;
		
		$CurrentQueue  = unserialize($USER['b_tech_queue']);
		if ($QueueID <= 1 || empty($CurrentQueue))
		{
			return false;
		}

		$ActualCount   = count($CurrentQueue);
		if ($ActualCount <= 1)
		{
			return $this->CancelBuildingFromQueue();
		}

		if(!isset($CurrentQueue[$QueueID - 2]))
		{
			return false;
		}
			
		$elementId 		= $CurrentQueue[$QueueID - 2][0];
		$BuildEndTime	= $CurrentQueue[$QueueID - 2][3];
		unset($CurrentQueue[$QueueID - 1]);
		$NewCurrentQueue	= array();
		foreach($CurrentQueue as $ID => $ListIDArray)
		{				
			if ($ID < $QueueID - 1) {
				$NewCurrentQueue[]	= $ListIDArray;
			} else {
				if($elementId == $ListIDArray[0])
					continue;

				if($ListIDArray[4] != $PLANET['id']) {
					$db = Database::get();

					$sql = "SELECT :resource6, :resource31 FROM %%PLANETS%% WHERE id = :id;";
					$CPLANET = $db->selectSingle($sql, array(
						':resource6'	=> $resource[6],
						':resource31'	=> $resource[31],
						':id'			=> $ListIDArray[4]
					));
				} else
					$CPLANET				= $PLANET;
				
				$CPLANET[$resource[31].'_inter']	= $this->ecoObj->getNetworkLevel($USER, $CPLANET);
				
				$BuildEndTime       += BuildUtil::getBuildingTime($USER, $CPLANET, NULL, $ListIDArray[0]);
				$ListIDArray[3]		= $BuildEndTime;
				$NewCurrentQueue[]	= $ListIDArray;				
			}
		}
		
		if(!empty($NewCurrentQueue))
			$USER['b_tech_queue'] = serialize($NewCurrentQueue);
		else
			$USER['b_tech_queue'] = "";

		return true;
	}

	private function AddBuildingToQueue($elementId, $AddMode = true)
	{
		global $PLANET, $USER;

		if(!in_array($elementId, $reslist['tech'])
			|| !BuildUtil::requirementsAvailable($USER, $PLANET, $elementId)
			|| !$this->CheckLabSettingsInQueue($PLANET)
		)
		{
			return false;
		}

		$CurrentQueue  		= unserialize($USER['b_tech_queue']);
		
		if (!empty($CurrentQueue)) {
			$ActualCount   	= count($CurrentQueue);
		} else {
			$CurrentQueue  	= array();
			$ActualCount   	= 0;
		}
				
		if(Config::get()->max_elements_tech != 0 && Config::get()->max_elements_tech <= $ActualCount)
		{
			return false;
		}

		$BuildLevel					= $USER[$resource[$elementId]] + 1;
		if($ActualCount == 0)
		{
			if($pricelist[$elementId]['max'] < $BuildLevel)
			{
				return false;
			}

			$costResources		= BuildUtil::getElementPrice($USER, $PLANET, $elementId, !$AddMode);
			
			if(!BuildUtil::isElementBuyable($USER, $PLANET, $elementId, $costResources))
			{
				return false;
			}
			
			if(isset($costResources[901])) { $PLANET[$resource[901]]	-= $costResources[901]; }
			if(isset($costResources[902])) { $PLANET[$resource[902]]	-= $costResources[902]; }
			if(isset($costResources[903])) { $PLANET[$resource[903]]	-= $costResources[903]; }
			if(isset($costResources[921])) { $USER[$resource[921]]		-= $costResources[921]; }
			
			$elementTime    			= BuildUtil::getBuildingTime($USER, $PLANET, $elementId, $costResources);
			$BuildEndTime				= TIMESTAMP + $elementTime;
			
			$USER['b_tech_queue']		= serialize(array(array($elementId, $BuildLevel, $elementTime, $BuildEndTime, $PLANET['id'])));
			$USER['b_tech']				= $BuildEndTime;
			$USER['b_tech_id']			= $elementId;
			$USER['b_tech_planet']		= $PLANET['id'];
		} else {
			$addLevel = 0;
			foreach($CurrentQueue as $QueueSubArray)
			{
				if($QueueSubArray[0] != $elementId)
					continue;
					
				$addLevel++;
			}
				
			$BuildLevel					+= $addLevel;
				
			if($pricelist[$elementId]['max'] < $BuildLevel)
			{
				return false;
			}
				
			$elementTime    			= BuildUtil::getBuildingTime($USER, $PLANET, $elementId, NULL, !$AddMode, $BuildLevel);
			
			$BuildEndTime				= $CurrentQueue[$ActualCount - 1][3] + $elementTime;
			$CurrentQueue[]				= array($elementId, $BuildLevel, $elementTime, $BuildEndTime, $PLANET['id']);
			$USER['b_tech_queue']		= serialize($CurrentQueue);
		}
		return true;
	}

	private function getQueueData()
	{
		global $LNG, $PLANET, $USER;

		$scriptData		= array();
		$quickinfo		= array();
		
		if ($USER['b_tech'] == 0)
		return array('queue' => $scriptData, 'quickinfo' => $quickinfo);
		
		$CurrentQueue   = unserialize($USER['b_tech_queue']);
		
		foreach($CurrentQueue as $BuildArray) {
			if ($BuildArray[3] < TIMESTAMP)
				continue;
			
			$PlanetName	= '';
		
			$quickinfo[$BuildArray[0]]	= $BuildArray[1];
			
			if($BuildArray[4] != $PLANET['id'])
				$PlanetName		= $USER['PLANETS'][$BuildArray[4]]['name'];
				
			$scriptData[] = array(
				'element'	=> $BuildArray[0], 
				'level' 	=> $BuildArray[1], 
				'time' 		=> $BuildArray[2], 
				'resttime' 	=> ($BuildArray[3] - TIMESTAMP), 
				'destroy' 	=> ($BuildArray[4] == 'destroy'), 
				'endtime' 	=> _date('U', $BuildArray[3], $USER['timezone']),
				'display' 	=> _date($LNG['php_tdformat'], $BuildArray[3], $USER['timezone']),
				'planet'	=> $PlanetName,
			);
		}
		
		return array('queue' => $scriptData, 'quickinfo' => $quickinfo);
	}

	public function show()
	{
		global $PLANET, $USER, $LNG;
		
		if ($PLANET[$resource[31]] == 0)
		{
			$this->printMessage($LNG['bd_lab_required']);
		}
			
		$TheCommand		= HTTP::_GP('cmd','');
		$elementId     	= HTTP::_GP('tech', 0);
		$ListID     	= HTTP::_GP('listid', 0);
		
		$PLANET[$resource[31].'_inter']	= Economy::getNetworkLevel($USER, $PLANET);

		if(!empty($TheCommand) && $_SERVER['REQUEST_METHOD'] === 'POST' && $USER['urlaubs_modus'] == 0)
		{
			switch($TheCommand)
			{
				case 'cancel':
					$this->CancelBuildingFromQueue();
				break;
				case 'remove':
					$this->RemoveBuildingFromQueue($ListID);
				break;
				case 'insert':
					$this->AddBuildingToQueue($elementId, true);
				break;
				case 'destroy':
					$this->AddBuildingToQueue($elementId, false);
				break;
			}
			
			$this->redirectTo('game.php?page=research');
		}
		
		$bContinue		= $this->CheckLabSettingsInQueue($PLANET);
		
		$queueData		= $this->getQueueData();
		$TechQueue		= $queueData['queue'];
		$QueueCount		= count($TechQueue);
		$ResearchList	= array();

		foreach($reslist['tech'] as $elementId)
		{
			if (!BuildUtil::requirementsAvailable($USER, $PLANET, $elementId))
				continue;
				
			if(isset($queueData['quickinfo'][$elementId]))
			{
				$levelToBuild	= $queueData['quickinfo'][$elementId];
			}
			else
			{
				$levelToBuild	= $USER[$resource[$elementId]];
			}
			
			$costResources		= BuildUtil::getElementPrice($USER, $PLANET, $elementId, false, $levelToBuild);
			$costOverflow		= BuildUtil::getRestPrice($USER, $PLANET, $elementId, $costResources);
			$elementTime    	= BuildUtil::getBuildingTime($USER, $PLANET, $elementId, $costResources);
			$buyable			= $QueueCount != 0 || BuildUtil::isElementBuyable($USER, $PLANET, $elementId, $costResources);

			$ResearchList[$elementId]	= array(
				'id'				=> $elementId,
				'level'				=> $USER[$resource[$elementId]],
				'maxLevel'			=> $pricelist[$elementId]['max'],
				'costResources'		=> $costResources,
				'costOverflow'		=> $costOverflow,
				'elementTime'    	=> $elementTime,
				'buyable'			=> $buyable,
				'levelToBuild'		=> $levelToBuild,
			);
		}
		
		$this->assign(array(
			'ResearchList'	=> $ResearchList,
			'IsLabinBuild'	=> !$bContinue,
			'IsFullQueue'	=> Config::get()->max_elements_tech == 0 || Config::get()->max_elements_tech == count($TechQueue),
			'Queue'			=> $TechQueue,
		));
		
		$this->display('page.research.default.tpl');
	}
}