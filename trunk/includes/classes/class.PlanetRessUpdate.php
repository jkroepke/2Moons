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
 * @version 1.5 (2011-07-31)
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
		$this->DEBUG	= FirePHP::getInstance(true);	
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
		$Hash[]	= $this->CONF['metal_basic_income'];
		$Hash[]	= $this->CONF['crystal_basic_income'];
		$Hash[]	= $this->CONF['deuterium_basic_income'];
		foreach($reslist['prod'] as $ID) {
			$Hash[]	= $this->PLANET[$resource[$ID]];
			$Hash[]	= $this->PLANET[$resource[$ID].'_porcent'];
		}
		
		$Hash[]	= $this->PLANET[$resource[22]];
		$Hash[]	= $this->PLANET[$resource[23]];
		$Hash[]	= $this->PLANET[$resource[24]];
		$Hash[]	= $this->USER['factor']['metal'];
		$Hash[]	= $this->USER['factor']['crystal'];
		$Hash[]	= $this->USER['factor']['deuterium'];
		$Hash[]	= $this->USER['factor']['energy'];
		return md5(implode("::", $Hash));
	}
	
	public function CalcResource($USER = NULL, $PLANET = NULL, $SAVE = false, $TIME = NULL, $HASH = true)
	{			
		$this->GLOBALS	= !isset($USER, $PLANET) ? true : false;
		$this->USER		= $this->GLOBALS ? $GLOBALS['USER'] : $USER;
		$this->PLANET	= $this->GLOBALS ? $GLOBALS['PLANET'] : $PLANET;
		$this->TIME		= is_null($TIME) ? TIMESTAMP : $TIME;
		$this->CONF		= getConfig($this->USER['universe']);
		
		if(EH_ACTIVE_ECO === true || $this->USER['urlaubs_modus'] == 1)
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
		$this->DEBUG->log("Start UpdateRessource on Planet(ID: ".$this->PLANET['id']."): ".date("H:i:s", $this->PLANET['last_update'])." to ".date("H:i:s", $this->TIME)." (".pretty_number($this->ProductionTime)."s)");
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
		
		$this->DEBUG->log("Add: Metal: ".pretty_number($MetalTheorical)." Crystal: ".pretty_number($CristalTheorical)." Deuterium: ".pretty_number($DeuteriumTheorical));
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
		
		$this->DEBUG->log("Storage: Metal: ".pretty_number($this->PLANET['metal_max'])." Crystal: ".pretty_number($this->PLANET['crystal_max'])." Deuterium: ".pretty_number($this->PLANET['deuterium_max']));

		if ($this->PLANET['planet_type'] == 3)
		{
			$this->CONF['metal_basic_income']     	= 0;
			$this->CONF['crystal_basic_income']   	= 0;
			$this->CONF['deuterium_basic_income'] 	= 0;
			$this->PLANET['metal_perhour']			= 0;
			$this->PLANET['crystal_perhour']		= 0;
			$this->PLANET['deuterium_perhour']		= 0;
			$this->PLANET['energy_used']			= 0;
			$this->PLANET['metal_proc']				= array(0);
			$this->PLANET['crystal_proc']			= array(0);
			$this->PLANET['deuterium_proc']			= array(0);
			$this->PLANET['deuterium_userd_proc']	= array(0);
			$this->PLANET['energy_used_proc']		= array(0);
			if($this->PLANET[$resource[212]] == 0) {
				$this->PLANET['energy_max_proc']		= array(0);
				$this->PLANET['energy_max']         	= 0;
			} else {
				$BuildTemp      						= $this->PLANET['temp_max'];
				$BuildLevelFactor						= $this->PLANET[$resource[212].'_porcent'];
				$BuildLevel 							= $this->PLANET[$resource[212]];
				$this->PLANET['energy_max_proc'][212]	= round(eval($ProdGrid[212]['energy']) * ($this->CONF['resource_multiplier']));
				$this->PLANET['energy_max']         	= $this->PLANET['energy_max_proc'][212];
			}
		}
		else
		{
			$this->PLANET['metal_proc']				= array();
			$this->PLANET['crystal_proc']			= array();
			$this->PLANET['deuterium_proc']			= array();
			$this->PLANET['deuterium_userd_proc']	= array();
			$this->PLANET['energy_used_proc']		= array();
			$this->PLANET['energy_max_proc']		= array();
			$BuildTemp      = $this->PLANET['temp_max'];
			$BuildEnergy	= $this->USER[$resource[113]];

			foreach($reslist['prod'] as $id => $ProdID)
			{	
				$BuildLevelFactor						= $this->PLANET[$resource[$ProdID].'_porcent'];			
				$BuildLevel 							= $this->PLANET[$resource[$ProdID]];
				$this->PLANET['metal_proc'][$ProdID]	= round(eval($ProdGrid[$ProdID]['metal'])     * $this->CONF['resource_multiplier']);
				$this->PLANET['crystal_proc'][$ProdID]	= round(eval($ProdGrid[$ProdID]['crystal'])   * $this->CONF['resource_multiplier']);
				
				$Energy	= round(eval($ProdGrid[$ProdID]['energy']) * ($this->CONF['resource_multiplier']));
				if ($Energy < 0) {
					$this->PLANET['deuterium_proc'][$ProdID]		= round(eval($ProdGrid[$ProdID]['deuterium']) * $this->CONF['resource_multiplier']);
					$this->PLANET['energy_used_proc'][$ProdID]		= $Energy;
				} else {
					if($ProdID == 12 && $this->PLANET['deuterium'] == 0)
						continue;

					$this->PLANET['deuterium_userd_proc'][$ProdID]	= round(eval($ProdGrid[$ProdID]['deuterium']) * ($this->CONF['resource_multiplier']));
					$this->PLANET['energy_max_proc'][$ProdID]		= $Energy;
				}
			}

			$this->PLANET['energy_used']          = array_sum($this->PLANET['energy_used_proc']);
			$this->PLANET['energy_max']           = round(array_sum($this->PLANET['energy_max_proc']) * $this->USER['factor']['energy']);
			
			if ($this->PLANET['energy_max']  == 0)
			{
				$this->PLANET['metal_perhour']     = $this->CONF['metal_basic_income'];
				$this->PLANET['crystal_perhour']   = $this->CONF['crystal_basic_income'];
				$this->PLANET['deuterium_perhour'] = $this->CONF['deuterium_basic_income'];
				$this->PLANET['level_proc']	= 0;
			}
			elseif ($this->PLANET['energy_max']  >= abs($this->PLANET['energy_used'] ))
				$this->PLANET['level_proc']	= 1;
			else
				$this->PLANET['level_proc']	= $this->PLANET['energy_max'] / abs($this->PLANET['energy_used']);
				
			if($this->PLANET['level_proc'] > 100)
				$this->PLANET['level_proc']	= 1;
			elseif ($this->PLANET['level_proc'] < 0)
				$this->PLANET['level_proc']	= 0;				
			
			$this->PLANET['metal_perhour']        = round(array_sum($this->PLANET['metal_proc']) * $this->USER['factor']['metal'] * $this->PLANET['level_proc']);
			$this->PLANET['crystal_perhour']      = round(array_sum($this->PLANET['crystal_proc']) * $this->USER['factor']['crystal'] * $this->PLANET['level_proc']);
			$this->PLANET['deuterium_perhour']    = round(array_sum($this->PLANET['deuterium_proc']) * $this->USER['factor']['deuterium'] * $this->PLANET['level_proc'] + array_sum($this->PLANET['deuterium_userd_proc']));
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
			$AcumTime		   += GetBuildingTime($this->USER, $this->PLANET, $Item[0]);
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
				
				$this->DEBUG->log("Done(Ship[ID:".$Element."]): ".pretty_number($Build));
		
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
		$this->DEBUG->log("Queue(Hanger): ".$this->PLANET['b_hangar_id']);
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
	
		$this->DEBUG->log("Done: Build(ID: ".$Element."): ".($this->PLANET[$resource[$Element]] - ($BuildMode == 'build' ? 1 : -1))." -> ".$this->PLANET[$resource[$Element]]);
		array_shift($CurrentQueue);
		$OnHash	= in_array($Element, $reslist['prod']);
		$this->UpdateRessource($BuildEndTime, !$OnHash);			
			
		if (count($CurrentQueue) == 0) {
			$this->PLANET['b_building']    	= 0;
			$this->PLANET['b_building_id'] 	= '';
			$this->DEBUG->log("Queue(Builds): ".$this->PLANET['b_building_id']);
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
			$ListIDArray         = $CurrentQueue[0];
			$Element             = $ListIDArray[0];
			$Level               = $ListIDArray[1];
			$BuildMode           = $ListIDArray[4];
			$ForDestroy 		 = ($BuildMode == 'destroy') ? true : false;
			$BuildTime  	     = GetBuildingTime($this->USER, $this->PLANET, $Element, $ForDestroy);
			$BuildEndTime        = $this->PLANET['b_building'] + $BuildTime;
			$CurrentQueue[0]	 = array($Element, $Level, $BuildTime, $BuildEndTime, $BuildMode);
			$HaveNoMoreLevel     = false;
								
			$HaveRessources 	 = IsElementBuyable($this->USER, $this->PLANET, $Element, true, $ForDestroy);
				
			if($ForDestroy && $this->PLANET[$resource[$Element]] == 0) {
				$HaveRessources  = false;
				$HaveNoMoreLevel = true;
			}

			if($HaveRessources == true) {
				$Needed                 	= GetBuildingPrice ($this->USER, $this->PLANET, $Element, true, $ForDestroy);
				$this->PLANET['metal']      -= $Needed['metal'];
				$this->PLANET['crystal']    -= $Needed['crystal'];
				$this->PLANET['deuterium']  -= $Needed['deuterium'];
				$this->USER['darkmatter']   -= $Needed['darkmatter'];
				$NewQueue               	= serialize($CurrentQueue);
				$Loop                  		= false;
			} else {
				if($this->USER['hof'] == 1){
					if ($ForDestroy || $HaveNoMoreLevel)
						$Message     = sprintf($LNG['sys_nomore_level'], $LNG['tech'][$Element]);
					else
					{
						$Needed      = GetBuildingPrice($this->USER, $this->PLANET, $Element, true, $ForDestroy);
						$Message     = sprintf($LNG['sys_notenough_money'], $this->PLANET['name'], $this->PLANET['id'], $this->PLANET['galaxy'], $this->PLANET['system'], $this->PLANET['planet'], $LNG['tech'][$Element], pretty_number ($this->PLANET['metal']), $LNG['Metal'], pretty_number ($this->PLANET['crystal']), $LNG['Crystal'], pretty_number ($this->PLANET['deuterium']), $LNG['Deuterium'], pretty_number ($Needed['metal']), $LNG['Metal'], pretty_number ($Needed['crystal']), $LNG['Crystal'], pretty_number ($Needed['deuterium']), $LNG['Deuterium']);
					}
					SendSimpleMessage($this->USER['id'], '', $this->TIME, 99, $LNG['sys_buildlist'], $LNG['sys_buildlist_fail'], $Message);				
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
						$ListIDArray[2]		= GetBuildingTime($this->USER, $this->PLANET, $ListIDArray[0], $ListIDArray[4] == 'destroy');
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
		$this->DEBUG->log("Queue(Builds): ".$this->PLANET['b_building_id']);
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
	
		$this->DEBUG->log("Done: Ship(ID:".$Element."): ".($this->USER[$resource[$this->USER['b_tech_id']]] - 1)." -> ".$this->USER[$resource[$this->USER['b_tech_id']]]);
		$CurrentQueue	= unserialize($this->USER['b_tech_queue']);
		array_shift($CurrentQueue);		
			
		$this->USER['b_tech_id']		= 0;
		if (count($CurrentQueue) == 0) {
			$this->USER['b_tech'] 			= 0;
			$this->USER['b_tech_id']		= 0;
			$this->USER['b_tech_planet']	= 0;
			$this->USER['b_tech_queue']		= '';
			$this->DEBUG->log("Queue(Tech): ".$this->USER['b_tech_queue']);
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
			$BuildTime  	    = GetBuildingTime($this->USER, $PLANET, $Element);
			$BuildEndTime       = $this->USER['b_tech'] + $BuildTime;
			$CurrentQueue[0]	= array($Element, $Level, $BuildTime, $BuildEndTime, $PLANET['id']);
			
			if($PLANET['id'] != $this->PLANET['id']) {
				$IsHash			= in_array($Element, array(131, 132, 133));
				$RPLANET 		= new ResourceUpdate(true, false);
				list(, $PLANET)	= $RPLANET->CalcResource($this->USER, $PLANET, false, $BuildEndTime, $IsHash);
			}
			
			$HaveRessources 	= IsElementBuyable($this->USER, $PLANET, $Element, true, false);
			
			if($HaveRessources == true) {
				$Needed							= GetBuildingPrice($this->USER, $PLANET, $Element);
				$PLANET['metal']				-= $Needed['metal'];
				$PLANET['crystal']				-= $Needed['crystal'];
				$PLANET['deuterium']			-= $Needed['deuterium'];
				$this->USER['darkmatter']		-= $Needed['darkmatter'];
				$this->USER['b_tech_id']		= $Element;
				$this->USER['b_tech']      		= $BuildEndTime;
				$this->USER['b_tech_planet']	= $PLANET['id'];
				$this->USER['b_tech_queue'] 	= serialize($CurrentQueue);

				$Loop                  			= false;
				
				if($ListIDArray[4] != $this->PLANET['id'])
					$RPLANET->SavePlanetToDB($this->USER, $PLANET);
				else
					$this->PLANET		= $PLANET;
			} else {
				if($this->USER['hof'] == 1){
					$Needed      = GetBuildingPrice($this->USER, $RPLANET->PLANET, $Element, true, $ForDestroy);
					$Message     = sprintf($LNG['sys_notenough_money'], $PLANET['name'], $PLANET['id'], $PLANET['galaxy'], $PLANET['system'], $PLANET['planet'], $LNG['tech'][$Element], pretty_number($RPLANET->PLANET['metal']), $LNG['Metal'], pretty_number($RPLANET->PLANET['crystal']), $LNG['Crystal'], pretty_number($RPLANET->PLANET['deuterium']), $LNG['Deuterium'], pretty_number ($Needed['metal']), $LNG['Metal'], pretty_number ($Needed['crystal']), $LNG['Crystal'], pretty_number ($Needed['deuterium']), $LNG['Deuterium']);
					SendSimpleMessage($this->USER['id'], '', $this->TIME, 99, $LNG['sys_techlist'], $LNG['sys_buildlist_fail'], $Message);				
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
						$ListIDArray[2]				= GetBuildingTime($this->USER, $Planet, $ListIDArray[0]);
						$BaseTime					+= $ListIDArray[2];
						$ListIDArray[3]				= $BaseTime;
						$NewQueue[]					= $ListIDArray;
					}
					$CurrentQueue					= $NewQueue;
				}
			}
		}
		$this->DEBUG->log("Queue(Tech): ".$this->USER['b_tech_queue']);
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
				   `p`.`energy_max` = '".$PLANET['energy_max']."',
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
		
		$this->DEBUG->log("Total: Metal: ".pretty_number($PLANET['metal'])." Crystal: ".pretty_number($PLANET['crystal'])." Deuterium: ".pretty_number($PLANET['deuterium']));
		return array($USER, $PLANET);
	}
}
?>