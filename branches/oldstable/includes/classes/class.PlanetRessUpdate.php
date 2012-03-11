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
		global $reslist, $resource;
		$Hash	= array();
		foreach($reslist['prod'] as $ID) {
			$Hash[]	= $this->PLANET[$resource[$ID]];
			$Hash[]	= $this->PLANET[$resource[$ID].'_porcent'];
		}
		
		$ressource	= array_merge($reslist['resstype'][1], $reslist['resstype'][2]);
		foreach($ressource as $ID) {
			$Hash[]	= $this->CONF[$resource[$ID].'_basic_income'];
			$Hash[]	= $this->PLANET[$resource[$ID]];
			$Hash[]	= $this->USER['factor']['ressource'][$ID];
		}
		
		$Hash[]	= $this->PLANET[$resource[22]];
		$Hash[]	= $this->PLANET[$resource[23]];
		$Hash[]	= $this->PLANET[$resource[24]];
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
		FirePHP::getInstance(true)->log("Start UpdateRessource on Planet(ID: ".$this->PLANET['id']."): ".date("H:i:s", $this->PLANET['last_update'])." to ".date("H:i:s", $this->TIME)." (".pretty_number($this->ProductionTime)."s)");
		if($this->ProductionTime > 0)
		{
			$this->PLANET['last_update']	= $TIME;
			if($HASH === false) {
				$this->ReBuildCache($TIME);
			} else {
				$this->HASH		= $this->CreateHash();
				if($this->PLANET['eco_hash'] !== $this->HASH) {
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
			
		$MaxMetalStorage                	= $this->PLANET['metal_max']     * $this->CONF['max_overflow'];
		$MaxCristalStorage              	= $this->PLANET['crystal_max']   * $this->CONF['max_overflow'];
		$MaxDeuteriumStorage     		    = $this->PLANET['deuterium_max'] * $this->CONF['max_overflow'];
		$MetalTheorical						= 0;
		$CristalTheorical					= 0;
		$DeuteriumTheorical					= 0;
		
		$MetalTheorical		= round($this->ProductionTime * (($this->CONF['metal_basic_income'] * $this->CONF['resource_multiplier']) + $this->PLANET['metal_perhour']) / 3600);
		
		if($MetalTheorical < 0)
		{
			$this->PLANET['metal']      = max($this->PLANET['metal'] + $MetalTheorical, 0);
		} 
		elseif ($this->PLANET['metal'] <= $MaxMetalStorage)
		{
			$this->PLANET['metal']      = min($this->PLANET['metal'] + $MetalTheorical, $MaxMetalStorage);
		}
		
		$CristalTheorical	= round($this->ProductionTime * (($this->CONF['crystal_basic_income'] * $this->CONF['resource_multiplier']) + $this->PLANET['crystal_perhour']) / 3600);
		if ($CristalTheorical < 0)
		{
			$this->PLANET['crystal']      = max($this->PLANET['crystal'] + $CristalTheorical, 0);
		} 
		elseif ($this->PLANET['crystal'] <= $MaxCristalStorage ) 
		{
			$this->PLANET['crystal']      = min($this->PLANET['crystal'] + $CristalTheorical, $MaxCristalStorage);
		}
		
		$DeuteriumTheorical	= round($this->ProductionTime * (($this->CONF['deuterium_basic_income'] * $this->CONF['resource_multiplier']) + $this->PLANET['deuterium_perhour']) / 3600);
		if ($DeuteriumTheorical < 0)
		{
			$this->PLANET['deuterium']    = max($this->PLANET['deuterium'] + $DeuteriumTheorical, 0);
		} 
		elseif($this->PLANET['deuterium'] <= $MaxDeuteriumStorage) 
		{
			$this->PLANET['deuterium']    = min($this->PLANET['deuterium'] + $DeuteriumTheorical, $MaxDeuteriumStorage);
		}
		
		FirePHP::getInstance(true)->log("Add: Metal: ".pretty_number($MetalTheorical)." Crystal: ".pretty_number($CristalTheorical)." Deuterium: ".pretty_number($DeuteriumTheorical));
		$this->PLANET['metal']		= max($this->PLANET['metal'], 0);
		$this->PLANET['crystal']	= max($this->PLANET['crystal'], 0);
		$this->PLANET['deuterium']	= max($this->PLANET['deuterium'], 0);
	}
	
	public function ReBuildCache()
	{
		global $ProdGrid, $resource, $reslist, $pricelist;
		
		$this->PLANET['metal_max']			= floor(2.5 * pow(1.8331954764, $this->PLANET[$resource[22]])) * 5000 * (1 + ($this->USER['rpg_stockeur'] * $pricelist[607]['info'])) * $this->CONF['resource_multiplier'] * STORAGE_FACTOR;
		$this->PLANET['crystal_max']		= floor(2.5 * pow(1.8331954764, $this->PLANET[$resource[23]])) * 5000 * (1 + ($this->USER['rpg_stockeur'] * $pricelist[607]['info'])) * $this->CONF['resource_multiplier'] * STORAGE_FACTOR;
		$this->PLANET['deuterium_max']		= floor(2.5 * pow(1.8331954764, $this->PLANET[$resource[24]])) * 5000 * (1 + ($this->USER['rpg_stockeur'] * $pricelist[607]['info'])) * $this->CONF['resource_multiplier'] * STORAGE_FACTOR;
		
		FirePHP::getInstance(true)->log("Storage: Metal: ".pretty_number($this->PLANET['metal_max'])." Crystal: ".pretty_number($this->PLANET['crystal_max'])." Deuterium: ".pretty_number($this->PLANET['deuterium_max']));

		if ($this->PLANET['planet_type'] == 3)
		{
			$this->CONF['metal_basic_income']     	= 0;
			$this->CONF['crystal_basic_income']   	= 0;
			$this->CONF['deuterium_basic_income'] 	= 0;
		}
		$temp						= array();
		
		$temp['metal_proc']			= 0;
		$temp['metal_proc_use']		= 0;
		$temp['crystal_proc']		= 0;
		$temp['crystal_proc_use']	= 0;
		$temp['deuterium_proc']		= 0;
		$temp['deuterium_proc_use']	= 0;
		$temp['energy_proc']		= 0;
		$temp['energy_proc_use']	= 0;
		
		$BuildTemp      			= $this->PLANET['temp_max'];
		$BuildEnergy				= $this->USER[$resource[113]];

		foreach($reslist['prod'] as $ProdID)
		{	
			
			$BuildLevelFactor	= $this->PLANET[$resource[$ProdID].'_porcent'];			
			$BuildLevel 		= $this->PLANET[$resource[$ProdID]];
			
			$Prod				= array();
			$Prod[901]			= round(eval($ProdGrid[$ProdID][901]) * $this->CONF['resource_multiplier']);
			$Prod[902]			= round(eval($ProdGrid[$ProdID][902]) * $this->CONF['resource_multiplier']);
			$Prod[903]			= round(eval($ProdGrid[$ProdID][903]) * $this->CONF['resource_multiplier']);
			$Prod[911]			= round(eval($ProdGrid[$ProdID][911]) * $this->CONF['resource_multiplier']);
			
			if($Prod[901] < 0 && $this->PLANET[$resource[901]] == 0)
				continue;
				
			if($Prod[902] < 0 && $this->PLANET[$resource[902]] == 0)
				continue;
				
			if($Prod[903] < 0 && $this->PLANET[$resource[903]] == 0)
				continue;
			
			if($Prod[901] < 0)
				$temp['metal_proc']			+= $Prod[901];
			else	
				$temp['metal_proc_use']		+= $Prod[901];
			
			if($Prod[902] < 0)
				$temp['crystal_proc']		+= $Prod[902];
			else
				$temp['crystal_proc_use']	+= $Prod[902];
			
			if($Prod[903] < 0)
				$temp['deuterium_proc']		+= $Prod[903];
			else
				$temp['deuterium_proc_use']	+= $Prod[903];
			
			if($Prod[911] < 0)
				$temp['energy_proc_use']	+= $Prod[911];
			else
				$temp['energy_proc']		+= $Prod[911];
		}
		
		$this->PLANET['energy']				= round($temp['energy_proc'] * $this->USER['factor']['ressource'][911]);
		$this->PLANET['energy_used']		= $temp['energy_proc_use'];
		
		if($this->PLANET['energy_used'] == 0) {
			$this->PLANET['level_proc']			= 0;
			
			$this->PLANET['metal_perhour']		= 0;
			$this->PLANET['crystal_perhour']	= 0;
			$this->PLANET['deuterium_perhour']	= 0;
		} else {
			$this->PLANET['level_proc']			= min(1, $this->PLANET['energy'] / abs($this->PLANET['energy_used']));
			
			$this->PLANET['metal_perhour']		= round($temp['metal_proc'] * $this->USER['factor']['ressource'][901] * $this->PLANET['level_proc'] + $temp['metal_proc_use']);
			$this->PLANET['crystal_perhour']	= round($temp['crystal_proc'] * $this->USER['factor']['ressource'][902] * $this->PLANET['level_proc'] + $temp['crystal_proc_use']);
			$this->PLANET['deuterium_perhour']	= round($temp['deuterium_proc'] * $this->USER['factor']['ressource'][903] * $this->PLANET['level_proc'] + $temp['deuterium_proc_use']);
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
			$Element   = $Item[0];
			$Count     = $Item[1];

			if($Done == false) {
				$BuildTime = $Item[2];
				$Element   = (int)$Element;
				if($BuildTime == 0) {			
					if(!isset($this->Builded[$Element]))
						$this->Builded[$Element] = 0;
						
					$this->Builded[$Element]			+= $Count;
					$this->PLANET[$resource[$Element]]	+= $Count;
					continue;					
				}
				
				$Build			= max(min(floor($this->PLANET['b_hangar'] / $BuildTime), $Count), 0);

				if($Build == 0) {
					$NewQueue[]	= array($Element, $Count);
					$Done		= true;
					continue;
				}
				
				FirePHP::getInstance(true)->log("Done(Ship[ID:".$Element."]): ".pretty_number($Build));
		
				if(!isset($this->Builded[$Element]))
					$this->Builded[$Element] = 0;
				
				$this->Builded[$Element]			+= $Build;
				$this->PLANET['b_hangar']			-= $Build * $BuildTime;
				$this->PLANET[$resource[$Element]]	+= $Build;
				$Count								-= $Build;
				
				if ($Count == 0)
					continue;
				else
					$Done	= true;
			}	
			$NewQueue[]	= array($Element, $Count);
		}
		$this->PLANET['b_hangar_id']	= !empty($NewQueue) ? serialize($NewQueue) : '';
		FirePHP::getInstance(true)->log("Queue(Hanger): ".$this->PLANET['b_hangar_id']);
	}
	
	private function BuildingQueue() 
	{
		while($this->CheckPlanetBuildingQueue())
			$this->SetNextQueueElementOnTop();
	}
	
	private function CheckPlanetBuildingQueue()
	{
		global $resource, $db, $reslist;
		
		if (empty($this->PLANET['b_building_id']) || $this->PLANET['b_building'] > $this->TIME)
			return false;
		
		$CurrentQueue	= unserialize($this->PLANET['b_building_id']);

		$Element      	= $CurrentQueue[0][0];
		$Level      	= $CurrentQueue[0][1];
		$BuildEndTime 	= $CurrentQueue[0][3];
		$BuildMode    	= $CurrentQueue[0][4];
		
		if(!isset($this->Builded[$Element]))
			$this->Builded[$Element] = 0;
		
		if ($BuildMode == 'build')
		{
			$this->PLANET['field_current']		+= 1;
			$this->PLANET[$resource[$Element]]	+= 1;
			$this->Builded[$Element]			+= 1;
		}
		else
		{
			$this->PLANET['field_current'] 		-= 1;
			$this->PLANET[$resource[$Element]] 	-= 1;
			$this->Builded[$Element]			-= 1;
		}
	
		FirePHP::getInstance(true)->log("Done: Build(ID: ".$Element."): ".($this->PLANET[$resource[$Element]] - ($BuildMode == 'build' ? 1 : -1))." -> ".$this->PLANET[$resource[$Element]]);
		array_shift($CurrentQueue);
		$OnHash	= in_array($Element, $reslist['prod']);
		$this->UpdateRessource($BuildEndTime, !$OnHash);			
			
		if (count($CurrentQueue) == 0) {
			$this->PLANET['b_building']    	= 0;
			$this->PLANET['b_building_id'] 	= '';
			FirePHP::getInstance(true)->log("Queue(Builds): ".$this->PLANET['b_building_id']);
			return false;
		} else {
			$this->PLANET['b_building_id'] 	= serialize($CurrentQueue);
			return true;
		}
	}	

	public function SetNextQueueElementOnTop()
	{
		global $resource, $db, $LNG;

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
			$Element			= $ListIDArray[0];
			$Level				= $ListIDArray[1];
			$BuildMode			= $ListIDArray[4];
			$ForDestroy			= ($BuildMode == 'destroy') ? true : false;
			$costRessources		= BuildFunctions::getElementPrice($this->USER, $this->PLANET, $Element, $ForDestroy);
			$BuildTime			= BuildFunctions::getBuildingTime($this->USER, $this->PLANET, $Element, $costRessources);
			$HaveRessources		= BuildFunctions::isElementBuyable($this->USER, $this->PLANET, $Element, $costRessources);
			$BuildEndTime		= $this->PLANET['b_building'] + $BuildTime;
			$CurrentQueue[0]	= array($Element, $Level, $BuildTime, $BuildEndTime, $BuildMode);
			$HaveNoMoreLevel	= false;
				
			if($ForDestroy && $this->PLANET[$resource[$Element]] == 0) {
				$HaveRessources  = false;
				$HaveNoMoreLevel = true;
			}

			if($HaveRessources === true) {
				if(isset($costRessources[901])) { $this->PLANET[$resource[901]]	-= $costRessources[901]; }
				if(isset($costRessources[902])) { $this->PLANET[$resource[902]]	-= $costRessources[902]; }
				if(isset($costRessources[903])) { $this->PLANET[$resource[903]]	-= $costRessources[903]; }
				if(isset($costRessources[921])) { $this->USER[$resource[921]]	-= $costRessources[921]; }
				$NewQueue               	= serialize($CurrentQueue);
				$Loop                  		= false;
			} else {
				if($this->USER['hof'] == 1){
					if ($HaveNoMoreLevel) {
						$Message     = sprintf($LNG['sys_nomore_level'], $LNG['tech'][$Element]);
					} else {
						if(!isset($costRessources[901])) { $costRessources[901] = 0; }
						if(!isset($costRessources[902])) { $costRessources[902] = 0; }
						if(!isset($costRessources[903])) { $costRessources[903] = 0; }
						
						$Message     = sprintf($LNG['sys_notenough_money'], $this->PLANET['name'], $this->PLANET['id'], $this->PLANET['galaxy'], $this->PLANET['system'], $this->PLANET['planet'], $LNG['tech'][$Element], pretty_number ($this->PLANET['metal']), $LNG['tech'][901], pretty_number($this->PLANET['crystal']), $LNG['tech'][902], pretty_number ($this->PLANET['deuterium']), $LNG['tech'][903], pretty_number($costRessources[901]), $LNG['tech'][901], pretty_number ($costRessources[902]), $LNG['tech'][902], pretty_number ($costRessources[903]), $LNG['tech'][903]);
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
		FirePHP::getInstance(true)->log("Queue(Builds): ".$this->PLANET['b_building_id']);
	}
		
	private function ResearchQueue()
	{
		while($this->CheckUserTechQueue())
			$this->SetNextQueueTechOnTop();
	}
	
	private function CheckUserTechQueue()
	{
		global $resource, $db;
		
		if (empty($this->USER['b_tech_id']) || $this->USER['b_tech'] > $this->TIME)
			return false;
		
		if(!isset($this->Builded[$this->USER['b_tech_id']]))
			$this->Builded[$this->USER['b_tech_id']]	= 0;
			
		$this->Builded[$this->USER['b_tech_id']]			+= 1;
		$this->USER[$resource[$this->USER['b_tech_id']]]	+= 1;
	
		FirePHP::getInstance(true)->log("Done: Tech(ID:".$this->USER['b_tech_id']."): ".($this->USER[$resource[$this->USER['b_tech_id']]] - 1)." -> ".$this->USER[$resource[$this->USER['b_tech_id']]]);
		$CurrentQueue	= unserialize($this->USER['b_tech_queue']);
		array_shift($CurrentQueue);		
			
		$this->USER['b_tech_id']		= 0;
		if (count($CurrentQueue) == 0) {
			$this->USER['b_tech'] 			= 0;
			$this->USER['b_tech_id']		= 0;
			$this->USER['b_tech_planet']	= 0;
			$this->USER['b_tech_queue']		= '';
			FirePHP::getInstance(true)->log("Queue(Tech): ".$this->USER['b_tech_queue']);
			return false;
		} else {
			$this->USER['b_tech_queue'] 	= serialize(array_values($CurrentQueue));
			return true;
		}
	}	
	
	public function SetNextQueueTechOnTop()
	{
		global $resource, $db, $LNG;

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
				$PLANET				= $db->uniquequery("SELECT * FROM ".PLANETS." WHERE `id` = '".$ListIDArray[4]."';");
			else
				$PLANET				= $this->PLANET;
			
			$PLANET[$resource[31].'_inter']	= $this->CheckAndGetLabLevel($this->USER, $PLANET);
			
			$Element            = $ListIDArray[0];
			$Level              = $ListIDArray[1];
			$costRessources		= BuildFunctions::getElementPrice($this->USER, $PLANET, $Element);
			$BuildTime			= BuildFunctions::getBuildingTime($this->USER, $PLANET, $Element, $costRessources);
			$HaveRessources		= BuildFunctions::isElementBuyable($this->USER, $PLANET, $Element, $costRessources);
			$BuildEndTime       = $this->USER['b_tech'] + $BuildTime;
			$CurrentQueue[0]	= array($Element, $Level, $BuildTime, $BuildEndTime, $PLANET['id']);
			
			if($PLANET['id'] != $this->PLANET['id']) {
				$IsHash			= !in_array($Element, array(131, 132, 133));
				$RPLANET 		= new ResourceUpdate(true, false);
				list(, $PLANET)	= $RPLANET->CalcResource($this->USER, $PLANET, false, $this->USER['b_tech'], $IsHash);
			}
			
			if($HaveRessources == true) {
				if(isset($costRessources[901])) { $PLANET[$resource[901]]		-= $costRessources[901]; }
				if(isset($costRessources[902])) { $PLANET[$resource[902]]		-= $costRessources[902]; }
				if(isset($costRessources[903])) { $PLANET[$resource[903]]		-= $costRessources[903]; }
				if(isset($costRessources[921])) { $this->USER[$resource[921]]	-= $costRessources[921]; }
				$this->USER['b_tech_id']		= $Element;
				$this->USER['b_tech']      		= $BuildEndTime;
				$this->USER['b_tech_planet']	= $PLANET['id'];
				$this->USER['b_tech_queue'] 	= serialize($CurrentQueue);

				$Loop                  			= false;
			} else {
				if($this->USER['hof'] == 1){
					if(!isset($costRessources[901])) { $costRessources[901] = 0; }
					if(!isset($costRessources[902])) { $costRessources[902] = 0; }
					if(!isset($costRessources[903])) { $costRessources[903] = 0; }
					
					$Message     = sprintf($LNG['sys_notenough_money'], $PLANET['name'], $PLANET['id'], $PLANET['galaxy'], $PLANET['system'], $PLANET['planet'], $LNG['tech'][$Element], pretty_number ($PLANET['metal']), $LNG['tech'][901], pretty_number($PLANET['crystal']), $LNG['tech'][902], pretty_number ($PLANET['deuterium']), $LNG['tech'][903], pretty_number($costRessources[901]), $LNG['tech'][901], pretty_number ($costRessources[902]), $LNG['tech'][902], pretty_number ($costRessources[903]), $LNG['tech'][903]);
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
		FirePHP::getInstance(true)->log("Queue(Tech): ".$this->USER['b_tech_queue']);
	}
	
	public function CheckAndGetLabLevel()
	{
		global $resource, $db, $USER, $PLANET;

		if($USER[$resource[123]] == 0)
			$lablevel = $PLANET[$resource[31]];
		else {
			$LevelRow = $db->query("SELECT ".$resource[31]." FROM ".PLANETS." WHERE `id` != '".$PLANET['id']."' AND `id_owner` = '".$USER['id']."' AND `destruyed` = 0 ORDER BY ".$resource[31]." DESC LIMIT ".($USER[$resource[123]]).";");
			$lablevel[]	= $PLANET[$resource[31]];
			while($Levels = $db->fetch_array($LevelRow))
			{
				$lablevel[]	= $Levels[$resource[31]];
			}
			$db->free_result($LevelRow);
		}
		return $lablevel;
	}
	
	public function SavePlanetToDB($USER = NULL, $PLANET = NULL)
	{
		global $resource, $db, $reslist;
		
		if(is_null($USER))
			global $USER;
			
		if(is_null($PLANET))
			global $PLANET;
			
		$Qry	= "LOCK TABLE ".PLANETS." as p WRITE, ".USERS." as u WRITE, ".SESSION." as s WRITE;
				   UPDATE ".PLANETS." as p, ".USERS." as u, ".SESSION." as s SET
				   `p`.`metal` = '".floattostring($PLANET['metal'])."',
				   `p`.`crystal` = '".floattostring($PLANET['crystal'])."',
				   `p`.`deuterium` = '".floattostring($PLANET['deuterium'])."',
				   `p`.`eco_hash` = '".$PLANET['eco_hash']."',
				   `p`.`last_update` = '".$PLANET['last_update']."',
				   `p`.`b_building` = '".$PLANET['b_building']."',
				   `p`.`b_building_id` = '".$PLANET['b_building_id']."',
				   `p`.`field_current` = '".$PLANET['field_current']."',
				   `p`.`b_hangar_id` = '".$PLANET['b_hangar_id']."',
				   `p`.`metal_perhour` = '".$PLANET['metal_perhour']."',
				   `p`.`crystal_perhour` = '".$PLANET['crystal_perhour']."',
				   `p`.`deuterium_perhour` = '".$PLANET['deuterium_perhour']."',
				   `p`.`metal_max` = '".$PLANET['metal_max']."',
				   `p`.`crystal_max` = '".$PLANET['crystal_max']."',
				   `p`.`deuterium_max` = '".$PLANET['deuterium_max']."',
				   `p`.`energy_used` = '".$PLANET['energy_used']."',
				   `p`.`energy` = '".$PLANET['energy']."',
				   `p`.`b_hangar` = '". $PLANET['b_hangar'] ."', ";
		if (!empty($this->Builded))
		{
			foreach($this->Builded as $Element => $Count)
			{
				$Element	= (int)$Element;
				if(empty($resource[$Element]) || empty($Count))
					continue;
				
				if(in_array($Element, $reslist['one']))
					$Qry	.= "`p`.`".$resource[$Element]."` = '1', ";					
				elseif(isset($PLANET[$resource[$Element]]))
					$Qry	.= "`p`.`".$resource[$Element]."` = `p`.`".$resource[$Element]."` + '".$Count."', ";
				elseif(isset($USER[$resource[$Element]]))
					$Qry	.= "`u`.`".$resource[$Element]."` = `u`.`".$resource[$Element]."` + '".$Count."', ";
			}
		}
		$Qry	.= "`u`.`darkmatter` = '".$USER['darkmatter']."',
					`u`.`b_tech` = '".$USER['b_tech']."',
					`u`.`b_tech_id` = '".$USER['b_tech_id']."',
					`u`.`b_tech_planet` = '".$USER['b_tech_planet']."',
					`u`.`b_tech_queue` = '".$USER['b_tech_queue']."'
					WHERE
					`p`.`id` = '". $PLANET['id'] ."' AND
					`u`.`id` = '".$USER['id']."' AND 
					`s`.`sess_id` = '".session_id()."';
					UNLOCK TABLES;";
		$db->multi_query($Qry);
		$this->Builded	= array();
		
		FirePHP::getInstance(true)->log("Total: Metal: ".pretty_number($PLANET['metal'])." Crystal: ".pretty_number($PLANET['crystal'])." Deuterium: ".pretty_number($PLANET['deuterium']));
		return array($USER, $PLANET);
	}
}
?>