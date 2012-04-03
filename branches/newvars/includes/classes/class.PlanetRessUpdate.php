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

class ResourceUpdate
{
	function __construct($Build = true, $Tech = true)
	{
		$this->Builded	= array();	
		$this->Build	= $Build;
		$this->Tech		= $Tech;
		$this->USER		= array();
		$this->PLANET	= array();	
	}
	
	public function ReturnVars() {
		if($this->GLOBALS)
		{
			$GLOBALS['USER']	= $this->USER;
			$GLOBALS['PLANET']	= $this->PLANET;
			return true;
		} else {
			return array($this->USER, $this->PLANET);
		}
	}
	
	public function CreateHash() {
		$Hash	= array();
		
		$elementIDs	= array_keys($GLOBALS['VARS']['ELEMENT']);
		foreach($elementIDs as $elementID)
		{
			if(elementHasFlag($elementID, ELEMENT_PLANET_RESOURCE) || elementHasFlag($elementID, ELEMENT_ENERGY))
			{
				$Hash[]	= $this->CONF[$GLOBALS['VARS']['ELEMENT'][$elementID]['name'].'_basic_income'];
			}
			
			if(elementHasFlag($elementID, ELEMENT_PRODUCTION))
			{
				$Hash[]	= $this->PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']];
				$Hash[]	= $this->PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name'].'_percent'];
			}
			
			if(elementHasFlag($elementID, ELEMENT_STORAGE))
			{
				$Hash[]	= $this->PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']];
			}
		}
		
		$Hash[]	= $this->CONF['resource_multiplier'];
		$Hash[]	= $this->USER['factor']['Resource'];
		
		return md5(implode("::", $Hash));
	}
	
	public function CalcResource($USER = NULL, $PLANET = NULL, $SAVE = false, $TIME = NULL, $HASH = true)
	{			
		$this->GLOBALS	= !isset($USER, $PLANET) ? true : false;
		$this->USER		= $this->GLOBALS ? $GLOBALS['USER'] : $USER;
		$this->PLANET	= $this->GLOBALS ? $GLOBALS['PLANET'] : $PLANET;
		$this->TIME		= is_null($TIME) ? TIMESTAMP : $TIME;
		$this->CONF		= getConfig($this->USER['universe']);
		
		if($this->USER['urlaubs_modus'] == 1)
			return $this->ReturnVars();
			
		if($this->Build)
		{
			$this->ShipyardQueue();
			if($this->Tech == true && $this->USER['b_tech'] != 0 && $this->USER['b_tech'] < $this->TIME)
				$this->ResearchQueue();
			if($this->PLANET['b_building'] != 0)
				$this->BuildingQueue();
		}
		
		$this->UpdateRessource($this->TIME, $HASH);
			
		if($SAVE === true)
			$this->SavePlanetToDB($this->USER, $this->PLANET);
			
		return $this->ReturnVars();
	}
	
	public function UpdateRessource($TIME, $HASH = false)
	{
		$this->ProductionTime  			= ($TIME - $this->PLANET['last_update']);
		
		if($this->ProductionTime > 0)
		{
			$this->PLANET['last_update']	= $TIME;
			if($HASH === false) {
				$this->ReBuildCache();
			} else {
				$this->HASH		= $this->CreateHash();
				
				if(true || $this->PLANET['eco_hash'] !== $this->HASH) {
					$this->PLANET['eco_hash'] = $this->HASH;
					$this->ReBuildCache();
				}
			}
			$this->ExecCalc();
		}
	}
	
	private function ExecCalc()
	{
		if($this->PLANET['planet_type'] == 3)
			return;
			
		
		foreach($GLOBALS['VARS']['LIST'][ELEMENT_PLANET_RESOURCE] as $elementID)
		{
			$maxStorage			= $this->PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name'].'_max'] * $this->CONF['max_overflow'];
			$theoricalIncome	= $this->ProductionTime * (($this->CONF['metal_basic_income'] * $this->CONF['resource_multiplier']) + $this->PLANET['metal_perhour']) / 3600;
			
			if($theoricalIncome < 0)
			{
				$this->PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']]	= max($this->PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']] + $theoricalIncome, 0);
			} 
			elseif ($this->PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']] <= $maxStorage)
			{
				$this->PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']]	= min($this->PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']] + $theoricalIncome, $maxStorage);
			}
		}
	}
	
	public static function getProd($Calculation)
	{
		return 'return '.$Calculation.';';
	}
	
	public static function getNetworkLevel($USER, $PLANET)
	{
		global $resource;

		$lablevel	= array();
		if($USER[$GLOBALS['VARS']['ELEMENT'][123]['name']] == 0) {
			$lablevel[] = $PLANET[$GLOBALS['VARS']['ELEMENT'][31]['name']];
		} else {
			$LevelRow = $GLOBALS['DATABASE']->query("SELECT ".$GLOBALS['VARS']['ELEMENT'][31]['name']." FROM ".PLANETS." WHERE id != '".$PLANET['id']."' AND id_owner = '".$USER['id']."' AND destruyed = 0 ORDER BY ".$GLOBALS['VARS']['ELEMENT'][31]['name']." DESC LIMIT ".($USER[$GLOBALS['VARS']['ELEMENT'][123]['name']]).";");
			$lablevel[]	= $PLANET[$GLOBALS['VARS']['ELEMENT'][31]['name']];
			while($Levels = $GLOBALS['DATABASE']->fetchArray($LevelRow))
			{
				$lablevel[]	= $Levels[$GLOBALS['VARS']['ELEMENT'][31]['name']];
			}
			$GLOBALS['DATABASE']->free_result($LevelRow);
		}
		
		return $lablevel;
	}
	
	public function ReBuildCache()
	{
		global $ProdGrid, $resource, $reslist, $pricelist;
		
		if ($this->PLANET['planet_type'] == 3)
		{
			$this->CONF['metal_basic_income']     	= 0;
			$this->CONF['crystal_basic_income']   	= 0;
			$this->CONF['deuterium_basic_income'] 	= 0;
		}
		
		$ressIDs	= array_merge($GLOBALS['VARS']['LIST'][ELEMENT_PLANET_RESOURCE], $GLOBALS['VARS']['LIST'][ELEMENT_ENERGY]);
		$temp		= combineArrayWithSingleElement($ressIDs, array(
			'max'	=> 0,
			'plus'	=> 0,
			'minus'	=> 0,
		));
		
		$BuildTemp		= $this->PLANET['temp_max'];
		$BuildEnergy	= $this->USER[$GLOBALS['VARS']['ELEMENT'][113]['name']];
		foreach($GLOBALS['VARS']['LIST'][ELEMENT_STORAGE] as $storageID)
		{
			foreach($GLOBALS['VARS']['LIST'][ELEMENT_PLANET_RESOURCE] as $resourceID) 
			{
				if(!isset($GLOBALS['VARS']['ELEMENT'][$storageID]['storage'][$resourceID]))
					continue;
					
				$BuildLevel 				= $this->PLANET[$GLOBALS['VARS']['ELEMENT'][$storageID]['name']];
				$temp[$resourceID]['max']	+= round(eval(self::getProd($GLOBALS['VARS']['ELEMENT'][$storageID]['storage'][$resourceID])));
			}
		}
		
		foreach($GLOBALS['VARS']['LIST'][ELEMENT_PRODUCTION] as $prodID)
		{	
			$BuildLevel 		= $this->PLANET[$GLOBALS['VARS']['ELEMENT'][$prodID]['name']];
			
			foreach($ressIDs as $resourceID)
			{
				if(!isset($GLOBALS['VARS']['ELEMENT'][$prodID]['production'][$resourceID]))
					continue;
				
				$Production	= eval(self::getProd($GLOBALS['VARS']['ELEMENT'][$prodID]['production'][$resourceID]));
				$Production	*= $this->PLANET[$GLOBALS['VARS']['ELEMENT'][$prodID]['name'].'_percent'] / 100;
				
				if($Production > 0) {					
					$temp[$resourceID]['plus']	+= $Production;
				} else {
					if(elementHasFlag($resourceID, ELEMENT_PLANET_RESOURCE) && $this->PLANET[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name']] == 0) {
						 continue;
					}
					
					$temp[$resourceID]['minus']	+= $Production;
				}
			}
		}

		$this->PLANET['energy']				= round($temp[911]['plus'] * (1 + $this->USER['factor']['Energy']));
		$this->PLANET['energy_used']		= $temp[911]['minus'];
		
		if($this->PLANET['energy_used'] == 0) {
			foreach($GLOBALS['VARS']['LIST'][ELEMENT_PLANET_RESOURCE] as $resourceID) 
			{
				$this->PLANET[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name'].'_max']		= $temp[903]['max'] * $this->CONF['resource_multiplier'] * STORAGE_FACTOR * (1 + $this->USER['factor']['ResourceStorage']);
				$this->PLANET[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name'].'_perhour']	= 0;
			}
		} else {
			$prodLevel	= min(1, $this->PLANET['energy'] / abs($this->PLANET['energy_used']));
			
			foreach($GLOBALS['VARS']['LIST'][ELEMENT_PLANET_RESOURCE] as $resourceID) 
			{
				$this->PLANET[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name'].'_max']		= $temp[903]['max'] * $this->CONF['resource_multiplier'] * STORAGE_FACTOR * (1 + $this->USER['factor']['ResourceStorage']);
				$this->PLANET[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name'].'_perhour']	= ($temp[903]['plus'] * (1 + $this->USER['factor']['Resource']) * $prodLevel + $temp[903]['minus']) * $this->CONF['resource_multiplier'];
			}
		}
	}
	
	private function ShipyardQueue()
	{
		global $resource;

		$BuildQueue 	= unserialize($this->PLANET['b_hangar_id']);
		if (!$BuildQueue) {
			$this->PLANET['b_hangar'] = 0;
			$this->PLANET['b_hangar_id'] = '';
			return false;
		}
			
		$AcumTime					= 0;
		$this->PLANET['b_hangar'] 	+= ($this->TIME - $this->PLANET['last_update']);
		$BuildArray					= array();
		foreach($BuildQueue as $Item)
		{
			$AcumTime			= BuildFunctions::getBuildingTime($this->USER, $this->PLANET, $Item[0]);
			$BuildArray[] 		= array($Item[0], $Item[1], $AcumTime);
		}

		$NewQueue	= array();
		$Done		= false;
		foreach($BuildArray as $Item)
		{
			$elementID   = $Item[0];
			$Count     = $Item[1];

			if($Done == false) {
				$BuildTime = $Item[2];
				$elementID   = (int)$elementID;
				if($BuildTime == 0) {			
					if(!isset($this->Builded[$elementID]))
						$this->Builded[$elementID] = 0;
						
					$this->Builded[$elementID]			+= $Count;
					$this->PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']]	+= $Count;
					continue;					
				}
				
				$Build			= max(min(floor($this->PLANET['b_hangar'] / $BuildTime), $Count), 0);

				if($Build == 0) {
					$NewQueue[]	= array($elementID, $Count);
					$Done		= true;
					continue;
				}
				
				if(!isset($this->Builded[$elementID]))
					$this->Builded[$elementID] = 0;
				
				$this->Builded[$elementID]			+= $Build;
				$this->PLANET['b_hangar']			-= $Build * $BuildTime;
				$this->PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']]	+= $Build;
				$Count								-= $Build;
				
				if ($Count == 0)
					continue;
				else
					$Done	= true;
			}	
			$NewQueue[]	= array($elementID, $Count);
		}
		$this->PLANET['b_hangar_id']	= !empty($NewQueue) ? serialize($NewQueue) : '';

	}
	
	private function BuildingQueue() 
	{
		while($this->CheckPlanetBuildingQueue())
			$this->SetNextQueueElementOnTop();
	}
	
	private function CheckPlanetBuildingQueue()
	{
		global $resource, $reslist;
		
		if (empty($this->PLANET['b_building_id']) || $this->PLANET['b_building'] > $this->TIME)
			return false;
		
		$CurrentQueue	= unserialize($this->PLANET['b_building_id']);

		$elementID      = $CurrentQueue[0][0];
		$Level      	= $CurrentQueue[0][1];
		$BuildEndTime 	= $CurrentQueue[0][3];
		$BuildMode    	= $CurrentQueue[0][4];
		
		if(!isset($this->Builded[$elementID]))
			$this->Builded[$elementID] = 0;
		
		if ($BuildMode == 'build')
		{
			$this->PLANET['field_current']		+= 1;
			$this->PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']]	+= 1;
			$this->Builded[$elementID]			+= 1;
		}
		else
		{
			$this->PLANET['field_current'] 		-= 1;
			$this->PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']] 	-= 1;
			$this->Builded[$elementID]			-= 1;
		}
	

		array_shift($CurrentQueue);
		$OnHash	= elementHasFlag($elementID, ELEMENT_PLANET_RESOURCE) || elementHasFlag($elementID, ELEMENT_ENERGY) || elementHasFlag($elementID, ELEMENT_PRODUCTION) || elementHasFlag($elementID, ELEMENT_STORAGE);
		$this->UpdateRessource($BuildEndTime, !$OnHash);			
			
		if (count($CurrentQueue) == 0) {
			$this->PLANET['b_building']    	= 0;
			$this->PLANET['b_building_id'] 	= '';

			return false;
		} else {
			$this->PLANET['b_building_id'] 	= serialize($CurrentQueue);
			return true;
		}
	}	

	public function SetNextQueueElementOnTop()
	{
		global $resource, $LNG;

		if (empty($this->PLANET['b_building_id'])) {
			$this->PLANET['b_building']    = 0;
			$this->PLANET['b_building_id'] = '';
			return false;
		}

		$CurrentQueue 	= unserialize($this->PLANET['b_building_id']);
		$Loop       	= true;
		while ($Loop == true)
		{
			$ListIDArray		= $CurrentQueue[0];
			$elementID			= $ListIDArray[0];
			$Level				= $ListIDArray[1];
			$BuildMode			= $ListIDArray[4];
			$ForDestroy			= ($BuildMode == 'destroy') ? true : false;
			$costRessources		= BuildFunctions::getElementPrice($this->USER, $this->PLANET, $elementID, $ForDestroy);
			$BuildTime			= BuildFunctions::getBuildingTime($this->USER, $this->PLANET, $elementID, $costRessources);
			$HaveRessources		= BuildFunctions::isElementBuyable($this->USER, $this->PLANET, $elementID, $costRessources);
			$BuildEndTime		= $this->PLANET['b_building'] + $BuildTime;
			$CurrentQueue[0]	= array($elementID, $Level, $BuildTime, $BuildEndTime, $BuildMode);
			$HaveNoMoreLevel	= false;
				
			if($ForDestroy && $this->PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']] == 0) {
				$HaveRessources  = false;
				$HaveNoMoreLevel = true;
			}

			if($HaveRessources === true) {
				foreach ($GLOBALS['VARS']['LIST'][ELEMENT_PLANET_RESOURCE] as $resourceID) {
					$this->PLANET[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name']]	-= $costRessources[$resourceID];
				}
				
				foreach ($GLOBALS['VARS']['LIST'][ELEMENT_USER_RESOURCE] as $resourceID)  {
					$this->USER[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name']]	-= $costRessources[$resourceID];
				}
				
				$NewQueue               	= serialize($CurrentQueue);
				$Loop                  		= false;
			} else {
				if($this->USER['hof'] == 1){
					if ($HaveNoMoreLevel) {
						$Message     = sprintf($LNG['sys_nomore_level'], $LNG['tech'][$elementID]);
					} else {
						foreach ($GLOBALS['VARS']['LIST'][ELEMENT_PLANET_RESOURCE] as $resourceID)
						{
							$avalible[$resourceID]	= pretty_number($costRessources[$resourceID]).' '.$LNG['tech'][$resourceID];
							$required[$resourceID]	= pretty_number($this->PLANET[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name']]).' '.$LNG['tech'][$resourceID];
						}
						
						foreach ($GLOBALS['VARS']['LIST'][ELEMENT_USER_RESOURCE] as $resourceID)
						{
							$avalible[$resourceID]	= pretty_number($costRessources[$resourceID]).' '.$LNG['tech'][$resourceID];
							$required[$resourceID]	= pretty_number($this->USER[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name']]).' '.$LNG['tech'][$resourceID];
						}
						
						$Message     = sprintf($LNG['sys_notenough_money'], $this->PLANET['name'], $this->PLANET['id'], $this->PLANET['galaxy'], $this->PLANET['system'], $this->PLANET['planet'], implode(', ', $avalible), implode(', ', $required));
					}
					
					SendSimpleMessage($this->USER['id'], 0, $this->TIME, 99, $LNG['sys_buildlist'], $LNG['sys_buildlist_fail'], $Message);				
				}

				array_shift($CurrentQueue);
					
				if (count($CurrentQueue) == 0) {
					$BuildEndTime  = 0;
					$NewQueue      = '';
					$Loop          = false;
				} else {
					$BaseTime			= $BuildEndTime - $BuildTime;
					$NewQueue			= array();
					foreach($CurrentQueue as $ListIDArray)
					{
						$ListIDArray[2]		= BuildFunctions::getBuildingTime($this->USER, $this->PLANET, $ListIDArray[0], NULL, $ListIDArray[4] == 'destroy');
						$BaseTime			+= $ListIDArray[2];
						$ListIDArray[3]		= $BaseTime;
						$NewQueue[]			= $ListIDArray;
					}
					$CurrentQueue	= $NewQueue;
				}
			}
		}
			
		$this->PLANET['b_building']    = $BuildEndTime;
		$this->PLANET['b_building_id'] = $NewQueue;
	}
		
	private function ResearchQueue()
	{
		while($this->CheckUserTechQueue())
			$this->SetNextQueueTechOnTop();
	}
	
	private function CheckUserTechQueue()
	{
		global $resource;
		
		if (empty($this->USER['b_tech_id']) || $this->USER['b_tech'] > $this->TIME)
			return false;
		
		if(!isset($this->Builded[$this->USER['b_tech_id']]))
			$this->Builded[$this->USER['b_tech_id']]	= 0;
			
		$this->Builded[$this->USER['b_tech_id']]			+= 1;
		$this->USER[$GLOBALS['VARS']['ELEMENT'][$this->USER['b_tech_id']]['name']]	+= 1;
	

		$CurrentQueue	= unserialize($this->USER['b_tech_queue']);
		array_shift($CurrentQueue);		
			
		$this->USER['b_tech_id']		= 0;
		if (count($CurrentQueue) == 0) {
			$this->USER['b_tech'] 			= 0;
			$this->USER['b_tech_id']		= 0;
			$this->USER['b_tech_planet']	= 0;
			$this->USER['b_tech_queue']		= '';

			return false;
		} else {
			$this->USER['b_tech_queue'] 	= serialize(array_values($CurrentQueue));
			return true;
		}
	}	
	
	public function SetNextQueueTechOnTop()
	{
		global $resource, $LNG;

		if (empty($this->USER['b_tech_queue'])) {
			$this->USER['b_tech'] 			= 0;
			$this->USER['b_tech_id']		= 0;
			$this->USER['b_tech_planet']	= 0;
			$this->USER['b_tech_queue']		= '';
			return false;
		}

		$CurrentQueue 	= unserialize($this->USER['b_tech_queue']);
		$Loop       	= true;
		while ($Loop == true)
		{
			$ListIDArray        = $CurrentQueue[0];
			if($ListIDArray[4] != $this->PLANET['id'])
				$PLANET				= $GLOBALS['DATABASE']->getFirstRow("SELECT * FROM ".PLANETS." WHERE id = '".$ListIDArray[4]."';");
			else
				$PLANET				= $this->PLANET;
			
			$PLANET[$GLOBALS['VARS']['ELEMENT'][31]['name'].'_inter']	= self::getNetworkLevel($this->USER, $PLANET);
			
			$elementID            = $ListIDArray[0];
			$Level              = $ListIDArray[1];
			$costRessources		= BuildFunctions::getElementPrice($this->USER, $PLANET, $elementID);
			$BuildTime			= BuildFunctions::getBuildingTime($this->USER, $PLANET, $elementID, $costRessources);
			$HaveRessources		= BuildFunctions::isElementBuyable($this->USER, $PLANET, $elementID, $costRessources);
			$BuildEndTime       = $this->USER['b_tech'] + $BuildTime;
			$CurrentQueue[0]	= array($elementID, $Level, $BuildTime, $BuildEndTime, $PLANET['id']);
			
			if($ListIDArray[4] != $this->PLANET['id']) {
				$IsHash			= !in_array($elementID, array(131, 132, 133));
				$RPLANET 		= new ResourceUpdate(true, false);
				list(, $PLANET)	= $RPLANET->CalcResource($this->USER, $PLANET, false, $this->USER['b_tech'], $IsHash);
			}
			
			if($HaveRessources == true) {
				foreach ($GLOBALS['VARS']['LIST'][ELEMENT_PLANET_RESOURCE] as $resourceID)
				{
					$this->PLANET[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name']]	-= $costRessources[$resourceID];
				}
				
				foreach ($GLOBALS['VARS']['LIST'][ELEMENT_USER_RESOURCE] as $resourceID)
				{
					$this->USER[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name']]	-= $costRessources[$resourceID];
				}
				
				$this->USER['b_tech_id']		= $elementID;
				$this->USER['b_tech']      		= $BuildEndTime;
				$this->USER['b_tech_planet']	= $PLANET['id'];
				$this->USER['b_tech_queue'] 	= serialize($CurrentQueue);

				$Loop                  			= false;
			} else {
				if($this->USER['hof'] == 1) {
					foreach ($GLOBALS['VARS']['LIST'][ELEMENT_PLANET_RESOURCE] as $resourceID)
					{
						$avalible[$resourceID]	= pretty_number($costRessources[$resourceID]).' '.$LNG['tech'][$resourceID];
						$required[$resourceID]	= pretty_number($this->PLANET[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name']]).' '.$LNG['tech'][$resourceID];
					}
					
					foreach ($GLOBALS['VARS']['LIST'][ELEMENT_USER_RESOURCE] as $resourceID)
					{
						$avalible[$resourceID]	= pretty_number($costRessources[$resourceID]).' '.$LNG['tech'][$resourceID];
						$required[$resourceID]	= pretty_number($this->USER[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name']]).' '.$LNG['tech'][$resourceID];
					}
					
					$Message     = sprintf($LNG['sys_notenough_money'], $this->PLANET['name'], $this->PLANET['id'], $this->PLANET['galaxy'], $this->PLANET['system'], $this->PLANET['planet'], implode(', ', $avalible), implode(', ', $required));
					SendSimpleMessage($this->USER['id'], 0, $this->USER['b_tech'], 99, $LNG['sys_techlist'], $LNG['sys_buildlist_fail'], $Message);				
				}

				array_shift($CurrentQueue);
					
				if (count($CurrentQueue) == 0) {
					$this->USER['b_tech'] 			= 0;
					$this->USER['b_tech_id']		= 0;
					$this->USER['b_tech_planet']	= 0;
					$this->USER['b_tech_queue']		= '';
					
					$Loop                  			= false;
				} else {
					$BaseTime						= $BuildEndTime - $BuildTime;
					$NewQueue						= array();
					foreach($CurrentQueue as $ListIDArray)
					{
						$ListIDArray[2]				= BuildFunctions::getBuildingTime($this->USER, $PLANET, $ListIDArray[0]);
						$BaseTime					+= $ListIDArray[2];
						$ListIDArray[3]				= $BaseTime;
						$NewQueue[]					= $ListIDArray;
					}
					$CurrentQueue					= $NewQueue;
				}
			}
				
			if($ListIDArray[4] != $this->PLANET['id'])
				$RPLANET->SavePlanetToDB($this->USER, $PLANET);
			else
				$this->PLANET		= $PLANET;
		}

	}
	
	public function SavePlanetToDB($USER = NULL, $PLANET = NULL)
	{
		global $resource, $reslist;
		
		if(is_null($USER))
			global $USER;
			
		if(is_null($PLANET))
			global $PLANET;
			
		$Qry	= "LOCK TABLE ".PLANETS." as p WRITE, ".USERS." as u WRITE;
				   UPDATE ".PLANETS." as p, ".USERS." as u SET
				   p.metal = ".$PLANET['metal'].",
				   p.crystal = ".$PLANET['crystal'].",
				   p.deuterium = ".$PLANET['deuterium'].",
				   p.eco_hash = '".$PLANET['eco_hash']."',
				   p.last_update = ".$PLANET['last_update'].",
				   p.b_building = '".$PLANET['b_building']."',
				   p.b_building_id = '".$PLANET['b_building_id']."',
				   p.field_current = ".$PLANET['field_current'].",
				   p.b_hangar_id = '".$PLANET['b_hangar_id']."',
				   p.metal_perhour = ".$PLANET['metal_perhour'].",
				   p.crystal_perhour = ".$PLANET['crystal_perhour'].",
				   p.deuterium_perhour = ".$PLANET['deuterium_perhour'].",
				   p.metal_max = ".$PLANET['metal_max'].",
				   p.crystal_max = ".$PLANET['crystal_max'].",
				   p.deuterium_max = ".$PLANET['deuterium_max'].",
				   p.energy_used = ".$PLANET['energy_used'].",
				   p.energy = ".$PLANET['energy'].",
				   p.b_hangar = ". $PLANET['b_hangar'] .", ";
		if (!empty($this->Builded))
		{
			foreach($this->Builded as $elementID => $Count)
			{
				$elementID	= (int) $elementID;
				
				if(empty($Count)) {
					continue;
				}
				
				if(elementHasFlag($elementID, ELEMENT_ONEPERPLANET)) {
					$Qry	.= "p.".$GLOBALS['VARS']['ELEMENT'][$elementID]['name']." = '1', ";					
				} elseif(isset($PLANET[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']])) {
					$Qry	.= "p.".$GLOBALS['VARS']['ELEMENT'][$elementID]['name']." = p.".$GLOBALS['VARS']['ELEMENT'][$elementID]['name']." + ".$Count.", ";
				} elseif(isset($USER[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']])) {
					$Qry	.= "u.".$GLOBALS['VARS']['ELEMENT'][$elementID]['name']." = u.".$GLOBALS['VARS']['ELEMENT'][$elementID]['name']." + ".$Count.", ";
				}
			}
		}
		$Qry	.= "u.darkmatter = ".$USER['darkmatter'].",
					u.b_tech = '".$USER['b_tech']."',
					u.b_tech_id = '".$USER['b_tech_id']."',
					u.b_tech_planet = '".$USER['b_tech_planet']."',
					u.b_tech_queue = '".$USER['b_tech_queue']."'
					WHERE
					p.id = ".$PLANET['id']." AND
					u.id = ".$USER['id'].";
					UNLOCK TABLES;";
		$GLOBALS['DATABASE']->multi_query($Qry);
		$this->Builded	= array();

		return array($USER, $PLANET);
	}
}
