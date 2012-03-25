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

require_once('class.AbstractPage.php');

class ShowResearchPage extends AbstractPage
{
	public static $requireModule = MODULE_RESEARCH;

	function __construct() 
	{
		parent::__construct();
	}
	
	private function CheckLabSettingsInQueue()
	{
		global $PLANET, $CONF;
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
		global $PLANET, $USER, $resource;
		$CurrentQueue  = unserialize($USER['b_tech_queue']);
		if (empty($CurrentQueue) || empty($USER['b_tech']))
		{
			$USER['b_tech_queue']	= '';
			$USER['b_tech_planet']	= 0;
			$USER['b_tech_id']		= 0;
			$USER['b_tech']			= 0;

			return false;
		}
		
		$elementID		= $USER['b_tech_id'];
		$costRessources	= BuildFunctions::getElementPrice($USER, $PLANET, $elementID);
		
		if($PLANET['id'] == $USER['b_tech_planet'])
		{
			foreach ($GLOBALS['VARS']['LIST'][ELEMENT_PLANET_RESOURCE] as $resourceID) {
				$PLANET[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name']]	+= $costRessources[$resourceID];
			}
		} else {
			$SQL	= "UPDATE ".PLANETS." SET ";
			
			foreach ($GLOBALS['VARS']['LIST'][ELEMENT_PLANET_RESOURCE] as $resourceID) {
				$SQL	.= $GLOBALS['VARS']['ELEMENT'][$resourceID]['name']." = ".$GLOBALS['VARS']['ELEMENT'][$resourceID]['name']." + ".$costRessources[$resourceID].", ";
			}
			
			$SQL	.= " WHERE `id` = ".$USER['b_tech_planet'].";";
			
			$GLOBALS['DATABASE']->query($SQL);
		}
		
		foreach ($GLOBALS['VARS']['LIST'][ELEMENT_USER_RESOURCE] as $resourceID)  {
			$USER[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name']]		+= $costRessources[$resourceID];
		}
		
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
				if($elementID == $ListIDArray[0] || empty($ListIDArray[0]))
					continue;
					
				if($ListIDArray[4] != $PLANET['id'])
					$CPLANET		= $GLOBALS['DATABASE']->uniquequery("SELECT ".$GLOBALS['VARS']['ELEMENT'][6]['name'].", ".$GLOBALS['VARS']['ELEMENT'][31]['name']." FROM ".PLANETS." WHERE `id` = ".$ListIDArray[4].";");
				else
					$CPLANET		= $PLANET;
				
				$CPLANET[$GLOBALS['VARS']['ELEMENT'][31]['name'].'_inter']	= $this->ecoObj->getNetworkLevel($USER, $CPLANET);
				$BuildEndTime       				+= BuildFunctions::getBuildingTime($USER, $CPLANET, NULL, $ListIDArray[0]);
				$ListIDArray[3]						= $BuildEndTime;
				$NewCurrentQueue[]					= $ListIDArray;				
			}
			
			if(!empty($NewCurrentQueue)) {
				$USER['b_tech']    			= TIMESTAMP;
				$USER['b_tech_queue'] 		= serialize($NewCurrentQueue);
				$this->ecoObj->USER			= $USER;
				$this->ecoObj->PLANET		= $PLANET;
				$this->ecoObj->SetNextQueueTechOnTop();
				$USER						= $this->ecoObj->USER;
				$PLANET						= $this->ecoObj->PLANET;
			} else {
				$USER['b_tech']    			= 0;
				$USER['b_tech_queue'] 		= '';

			}
		}
	}

	private function RemoveBuildingFromQueue($QueueID)
	{
		global $USER, $PLANET, $resource;
		
		$CurrentQueue  = unserialize($USER['b_tech_queue']);
		if ($QueueID <= 1 || empty($CurrentQueue))
			return;
			
		$ActualCount   = count($CurrentQueue);
		if ($ActualCount <= 1)
			return $this->CancelBuildingFromQueue();

		if(!isset($CurrentQueue[$QueueID - 2]))
			return;
			
		$elementID 		= $CurrentQueue[$QueueID - 2][0];
		$BuildEndTime	= $CurrentQueue[$QueueID - 2][3];
		unset($CurrentQueue[$QueueID - 1]);
		$NewCurrentQueue	= array();
		foreach($CurrentQueue as $ID => $ListIDArray)
		{				
			if ($ID < $QueueID - 1) {
				$NewCurrentQueue[]	= $ListIDArray;
			} else {
				if($elementID == $ListIDArray[0])
					continue;
					
				if($ListIDArray[4] != $PLANET['id'])
					$CPLANET				= $GLOBALS['DATABASE']->uniquequery("SELECT `".$GLOBALS['VARS']['ELEMENT'][6]['name']."`, `".$GLOBALS['VARS']['ELEMENT'][31]['name']."` FROM ".PLANETS." WHERE `id` = ".$ListIDArray[4].";");
				else
					$CPLANET				= $PLANET;
				
				$CPLANET[$GLOBALS['VARS']['ELEMENT'][31]['name'].'_inter']	= $this->ecoObj->getNetworkLevel($USER, $CPLANET);
				
				$BuildEndTime       += BuildFunctions::getBuildingTime($USER, $CPLANET, NULL, $ListIDArray[0]);
				$ListIDArray[3]		= $BuildEndTime;
				$NewCurrentQueue[]	= $ListIDArray;				
			}
		}
		
		if(!empty($NewCurrentQueue))
			$USER['b_tech_queue'] = serialize($NewCurrentQueue);
		else
			$USER['b_tech_queue'] = "";
			

	}

	private function AddBuildingToQueue($elementID, $AddMode = true)
	{
		global $PLANET, $USER, $resource, $CONF, $reslist, $pricelist;

		if(!BuildFunctions::isTechnologieAccessible($USER, $PLANET, $elementID)
			|| !$this->CheckLabSettingsInQueue($PLANET)
		)
			return;
			
		$CurrentQueue  		= unserialize($USER['b_tech_queue']);
		
		if (!empty($CurrentQueue)) {
			$ActualCount   	= count($CurrentQueue);
		} else {
			$CurrentQueue  	= array();
			$ActualCount   	= 0;
		}
				
		if($CONF['max_elements_tech'] != 0 && $CONF['max_elements_tech'] <= $ActualCount)
			return false;
			
		$BuildLevel					= $USER[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']] + 1;
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
			
			$USER['b_tech_queue']		= serialize(array(array($elementID, $BuildLevel, $elementTime, $BuildEndTime, $PLANET['id'])));
			$USER['b_tech']				= $BuildEndTime;
			$USER['b_tech_id']			= $elementID;
			$USER['b_tech_planet']		= $PLANET['id'];
		} else {
			$addLevel = 0;
			foreach($CurrentQueue as $QueueSubArray)
			{
				if($QueueSubArray[0] != $elementID)
					continue;
					
				$addLevel++;
			}
				
			$BuildLevel					+= $addLevel;
				
			if(!empty($GLOBALS['VARS']['ELEMENT'][$elementID]['maxLevel']) && $GLOBALS['VARS']['ELEMENT'][$elementID]['maxLevel'] < $BuildLevel)
				return;
				
			$elementTime    			= BuildFunctions::getBuildingTime($USER, $PLANET, $elementID, NULL, !$AddMode, $BuildLevel);
			
			$BuildEndTime				= $CurrentQueue[$ActualCount - 1][3] + $elementTime;
			$CurrentQueue[]				= array($elementID, $BuildLevel, $elementTime, $BuildEndTime, $PLANET['id']);
			$USER['b_tech_queue']		= serialize($CurrentQueue);
		}

	}

	private function ShowTechQueue()
	{
		global $LNG, $CONF, $PLANET, $USER;
		
		if ($USER['b_tech'] == 0)
			return array();
		
		$CurrentQueue   = unserialize($USER['b_tech_queue']);

		$ScriptData		= array();
		
		foreach($CurrentQueue as $BuildArray) {
			if ($BuildArray[3] < TIMESTAMP)
				continue;
			
			$PlanetName	= '';
			
			if($BuildArray[4] != $PLANET['id'])
				$PlanetName		= $USER['PLANETS'][$BuildArray[4]]['name'];
				
			$ScriptData[] = array(
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
		
		return $ScriptData;
	}

	public function show()
	{
		global $PLANET, $USER, $LNG, $resource, $reslist, $CONF, $pricelist;
		
		if ($PLANET[$GLOBALS['VARS']['ELEMENT'][31]['name']] == 0)
		{
			$this->printMessage($LNG['bd_lab_required']);
		}
			
		$TheCommand		= HTTP::_GP('cmd','');
		$elementID     	= HTTP::_GP('tech', 0);
		$ListID     	= HTTP::_GP('listid', 0);
		
		$PLANET[$GLOBALS['VARS']['ELEMENT'][31]['name'].'_inter']	= ResourceUpdate::getNetworkLevel($USER, $PLANET);	

		if(!empty($TheCommand) && $_SERVER['REQUEST_METHOD'] === 'POST' && $USER['urlaubs_modus'] == 0 && elementHasFlag($elementID, ELEMENT_TECH))
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
					$this->AddBuildingToQueue($elementID, true);
				break;
				case 'destroy':
					$this->AddBuildingToQueue($elementID, false);
				break;
			}
			
			$this->redirectTo('game.php?page=research');
		}
		
		$bContinue		= $this->CheckLabSettingsInQueue($PLANET);
		
		$TechQueue		= $this->ShowTechQueue();
		$QueueCount		= count($TechQueue);
		$ResearchList	= array();

		foreach($GLOBALS['VARS']['LIST'][ELEMENT_TECH] as $elementID)
		{
			if (!BuildFunctions::isTechnologieAccessible($USER, $PLANET, $elementID)) {
				continue;
			}
			
			$costRessources		= BuildFunctions::getElementPrice($USER, $PLANET, $elementID);
			$costOverflow		= BuildFunctions::getRestPrice($USER, $PLANET, $elementID, $costRessources);
			$elementTime    	= BuildFunctions::getBuildingTime($USER, $PLANET, $elementID, $costRessources);
			$buyable			= $QueueCount != 0 || BuildFunctions::isElementBuyable($USER, $PLANET, $elementID, $costRessources);

			$ResearchList[$elementID]	= array(
				'id'				=> $elementID,
				'level'				=> $USER[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']],
				'maxLevel'			=> $GLOBALS['VARS']['ELEMENT'][$elementID]['maxLevel'],
				'costRessources'	=> array_filter($costRessources),
				'costOverflow'		=> $costOverflow,
				'elementTime'    	=> $elementTime,
				'buyable'			=> $buyable,
			);
		}
		
		if($USER['b_tech_id'] != 0) {
			$this->tplObj->loadscript('research.js');
		}
		
		$this->tplObj->assign_vars(array(
			'ResearchList'	=> $ResearchList,
			'IsLabinBuild'	=> !$bContinue,
			'IsFullQueue'	=> $CONF['max_elements_tech'] == 0 || $CONF['max_elements_tech'] == count($TechQueue),
			'Queue'			=> $TechQueue,
		));
		
		$this->display('page.research.default.tpl');
	}
}