<?php

##############################################################################
# *                                                                          #
# * 2MOONS                                                                   #
# *                                                                          #
# * @copyright Copyright (C) 2010 By ShadoX from titanspace.de               #
# *                                                                          #
# *	                                                                         #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.                                     #
# *	                                                                         #
# *  This program is distributed in the hope that it will be useful,         #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of          #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           #
# *  GNU General Public License for more details.                            #
# *                                                                          #
##############################################################################

class ResourceUpdate
{
	function __construct($Build = true)
	{
		$this->Builded					= array();	
		$this->Build					= $Build;
		$this->USER						= array();
		$this->PLANET					= array();
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
	
	public function CalcResource($USER = NULL, $PLANET = NULL, $SAVE = false, $TIME = NULL)
	{
		$this->GLOBALS	= !isset($USER, $PLANET) ? true : false;
		$this->USER		= $this->GLOBALS ? $GLOBALS['USER'] : $USER;
		$this->PLANET	= $this->GLOBALS ? $GLOBALS['PLANET'] : $PLANET;
		$this->TIME		= is_null($TIME) ? TIMESTAMP : $TIME;
			
		if($this->USER['urlaubs_modus'] == 1)
			return $this->ReturnVars();
			
		if($this->Build)
		{
			$this->ShipyardQueue();
			
			if($this->USER['b_tech'] != 0 && $this->USER['b_tech'] < $this->TIME)
				$this->ResearchQueue();
			if($this->PLANET['b_building'] != 0)
				$this->BuildingQueue();
		}	

		$this->UpdateRessource();
		if($SAVE === true)
			$this->SavePlanetToDB($this->USER, $this->PLANET);
			
		return $this->ReturnVars();
	}
	
	private function UpdateRessource()
	{
		global $ProdGrid, $resource, $reslist, $CONF, $ExtraDM, $OfficerInfo;
		
		$this->PLANET['metal_max']			= floor(2.5 * pow(1.8331954764, $this->PLANET[$resource[22]])) * 5000 * (1 + ($this->USER['rpg_stockeur'] * $OfficerInfo[607]['info'])) * $CONF['resource_multiplier'] * STORAGE_FACTOR;
		$this->PLANET['crystal_max']		= floor(2.5 * pow(1.8331954764, $this->PLANET[$resource[23]])) * 5000 * (1 + ($this->USER['rpg_stockeur'] * $OfficerInfo[607]['info'])) * $CONF['resource_multiplier'] * STORAGE_FACTOR;
		$this->PLANET['deuterium_max']		= floor(2.5 * pow(1.8331954764, $this->PLANET[$resource[24]])) * 5000 * (1 + ($this->USER['rpg_stockeur'] * $OfficerInfo[607]['info'])) * $CONF['resource_multiplier'] * STORAGE_FACTOR;
		
		$MaxMetalStorage                	= $this->PLANET['metal_max']     * MAX_OVERFLOW;
		$MaxCristalStorage              	= $this->PLANET['crystal_max']   * MAX_OVERFLOW;
		$MaxDeuteriumStorage     		    = $this->PLANET['deuterium_max'] * MAX_OVERFLOW;
		$this->ProductionTime    			= ($this->TIME - $this->PLANET['last_update']);

		$this->PLANET['last_update']   		= $this->TIME;

		if ($this->PLANET['planet_type'] == 3)
		{
			$CONF['metal_basic_income']     	= 0;
			$CONF['crystal_basic_income']   	= 0;
			$CONF['deuterium_basic_income'] 	= 0;
			$this->PLANET['metal_perhour']      = 0;
			$this->PLANET['crystal_perhour']    = 0;
			$this->PLANET['deuterium_perhour']  = 0;
			$this->PLANET['energy_used']        = 0;
			$this->PLANET['energy_max']         = 0;
		}
		else
		{
			$Caps           = array();
			$BuildTemp      = $this->PLANET['temp_max'];
			$BuildEnergy	= $this->USER[$resource[113]];
			$Caps['metal_perhour'] = $Caps['crystal_perhour'] = $Caps['deuterium_perhour'] = $Caps['energy_used'] = $Caps['energy_max'] = $Caps['deuterium_used'] = 0;

			foreach($reslist['prod'] as $id => $ProdID)
			{
				$BuildLevelFactor	= $this->PLANET[$resource[$ProdID]."_porcent" ];
				$BuildLevel 		= $this->PLANET[$resource[$ProdID]];
				$Caps['metal_perhour']		+= floor(eval($ProdGrid[$ProdID]['formule']['metal'])     * $CONF['resource_multiplier'] * (1 + (($this->USER['rpg_geologue'] * 0.05) + ($this->USER['metal_proc_tech'] * 0.02) + (($this->TIME - $this->USER[$resource[703]] <= 0) ? ($ExtraDM[703]['add']) : 0))));
				$Caps['crystal_perhour']	+= floor(eval($ProdGrid[$ProdID]['formule']['crystal'])   * $CONF['resource_multiplier'] * (1 + (($this->USER['rpg_geologue'] * 0.05) + ($this->USER['crystal_proc_tech'] * 0.02) + (($this->TIME - $this->USER[$resource[703]] <= 0) ? ($ExtraDM[703]['add']) : 0))));
			
				if ($ProdID < 4) {
					$Caps['deuterium_perhour'] 	+= floor(eval($ProdGrid[$ProdID]['formule']['deuterium']) * $CONF['resource_multiplier'] * (1 + (($this->USER['rpg_geologue'] * 0.05) + ($this->USER['deuterium_proc_tech'] * 0.02) + (($this->TIME - $this->USER[$resource[703]] <= 0) ? ($ExtraDM[703]['add']) : 0))));
					$Caps['energy_used']   		+= floor(eval($ProdGrid[$ProdID]['formule']['energy']) * ($CONF['resource_multiplier']));
				} else {
					if($ProdID == 12 && $this->PLANET['deuterium'] == 0)
						continue;

					$Caps['deuterium_used'] 	+= floor(eval($ProdGrid[$ProdID]['formule']['deuterium']) * ($CONF['resource_multiplier']));
					$Caps['energy_max']			+= floor(eval($ProdGrid[$ProdID]['formule']['energy']) * ($CONF['resource_multiplier']) * (1 + ($this->USER['rpg_ingenieur'] * 0.05)) * (($this->TIME - $this->USER[$resource[704]] <= 0) ? (1 + $ExtraDM[704]['add']) : 1));
				}
			}
			
			if ($Caps['energy_max'] == 0)
			{
				$this->PLANET['metal_perhour']     = $CONF['metal_basic_income'];
				$this->PLANET['crystal_perhour']   = $CONF['crystal_basic_income'];
				$this->PLANET['deuterium_perhour'] = $CONF['deuterium_basic_income'];
				$LEVEL          			 = 0;
			}
			elseif ($Caps["energy_max"] >= abs($Caps["energy_used"]))
				$LEVEL = 100;
			else
				$LEVEL = floor($Caps['energy_max'] / abs($Caps['energy_used']) * 100);
				
			if($LEVEL > 100)
				$LEVEL = 100;
			elseif ($LEVEL < 0)
				$LEVEL = 0;				
			
			$this->PLANET['metal_perhour']        = $Caps['metal_perhour'] * (0.01 * $LEVEL);
			$this->PLANET['crystal_perhour']      = $Caps['crystal_perhour'] * (0.01 * $LEVEL);
			$this->PLANET['deuterium_perhour']    = $Caps['deuterium_perhour'] * (0.01 * $LEVEL) + $Caps['deuterium_used'];
			$this->PLANET['energy_used']          = $Caps['energy_used'];
			$this->PLANET['energy_max']           = $Caps['energy_max'];

			if ($this->PLANET['metal'] <= $MaxMetalStorage)
			{
				$MetalTheorical 		= $this->PLANET['metal'] + ($this->ProductionTime * (($CONF['metal_basic_income'] * $CONF['resource_multiplier']) + $this->PLANET['metal_perhour']) / 3600);
				$this->PLANET['metal']  		= min($MetalTheorical, $MaxMetalStorage);
			}
			
			if ($this->PLANET['crystal'] <= $MaxCristalStorage)
			{
				$CristalTheorical  		= $this->PLANET['crystal'] + ($this->ProductionTime * (($CONF['crystal_basic_income'] * $CONF['resource_multiplier']) + $this->PLANET['crystal_perhour']) / 3600);
				$this->PLANET['crystal']  	= min($CristalTheorical, $MaxCristalStorage);
			}
			
			if ($this->PLANET['deuterium'] <= $MaxDeuteriumStorage)
			{
				$DeuteriumTheorical		= $this->PLANET['deuterium'] + ($this->ProductionTime * (($CONF['deuterium_basic_income'] * $CONF['resource_multiplier']) + $this->PLANET['deuterium_perhour']) / 3600);
				$this->PLANET['deuterium']	= min($DeuteriumTheorical, $MaxDeuteriumStorage);
			}
		}
		
		$this->PLANET['metal']		= max($this->PLANET['metal'], 0);
		$this->PLANET['crystal']	= max($this->PLANET['crystal'], 0);
		$this->PLANET['deuterium']	= max($this->PLANET['deuterium'], 0);
	}
	
	private function ShipyardQueue()
	{
		global $resource;

		if (empty($this->PLANET['b_hangar_id'])) {
			$this->PLANET['b_hangar'] = 0;
			return false;
		}
		
		$BuildQueue                 = explode(';', $this->PLANET['b_hangar_id']);
		$AcumTime					= 0;
		$this->PLANET['b_hangar'] 	+= ($this->TIME - $this->PLANET['last_update']);
		$BuildArray	= array();
		foreach($BuildQueue as $Node => $Array)
		{
			if (empty($Array))
				continue;
			
			$Item              = explode(',', $Array);
			$AcumTime		   += GetBuildingTime($this->USER, $this->PLANET, $Item[0]);
			$BuildArray[$Node] = array($Item[0], $Item[1], $AcumTime);
		}

		$this->PLANET['b_hangar_id'] 		= '';
		$UnFinished 					= false;
		
		foreach($BuildArray as $Node => $Item)
		{
			$Element   = $Item[0];
			$Count     = $Item[1];
			$BuildTime = $Item[2];
			$Element   = (int)$Element;
			if($BuildTime == 0) {
				$this->Builded[$Element]			= bcadd($Count, $this->Builded[$Element]);
				$this->PLANET[$resource[$Element]]	= bcadd($Count, $this->PLANET[$resource[$Element]]);
				continue;					
			}
			
			$GetBuildShips						= max(min(round(bcdiv($this->PLANET['b_hangar'], $BuildTime)), $Count), 0);
			if($GetBuildShips == 0)
			{
				$this->PLANET['b_hangar_id'] 	.= $Element.",".$Count.";";
				continue;
			}
			
			if(!isset($this->Builded[$Element]))
				$this->Builded[$Element] = 0;
				
			$this->PLANET['b_hangar']			-= bcmul($GetBuildShips, $BuildTime);
			$this->Builded[$Element]			= bcadd($GetBuildShips, $this->Builded[$Element]);
			$this->PLANET[$resource[$Element]]	= bcadd($GetBuildShips, $this->PLANET[$resource[$Element]]);
			$Count								= bcsub($Count, $GetBuildShips);						
			
			if ($Count == 0)
				continue;
			
			$this->PLANET['b_hangar_id'] .= $Element.",".$Count.";";
		}
	}
	
	private function BuildingQueue() 
	{
		while(true)
		{	
			if(!$this->CheckPlanetBuildingQueue())
				break;
			
			$this->SetNextQueueElementOnTop();
		}
	}
	
	private function CheckPlanetBuildingQueue()
	{
		global $resource, $db;
		
		if (empty($this->PLANET['b_building_id']))
			return false;
		
		$CurrentQueue  	= $this->PLANET['b_building_id'];
		$QueueArray    	= explode(";", $this->PLANET['b_building_id']);
		$ActualCount   	= count($QueueArray);

		$BuildArray   	= explode (",", $QueueArray[0]);
		$Element      	= $BuildArray[0];
		$Level      	= $BuildArray[1];
		$BuildEndTime 	= $BuildArray[3];
		$BuildMode    	= $BuildArray[4];
			
		if ($BuildEndTime > $this->TIME)
			return false;

		$ForDestroy = ($BuildMode == 'destroy') ? true : false;
		
		if ($ForDestroy == false)
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
	
		array_shift($QueueArray);		
		$this->UpdateRessource($BuildEndTime);			
			
		if (count($QueueArray) == 0) {
			$this->PLANET['b_building']    	= 0;
			$this->PLANET['b_building_id'] 	= '';
			return false;
		} else {
			$BuildArray 	  				= explode (",", $QueueArray[0]);
			$this->PLANET['b_building']    	= $BuildArray[3];
			$this->PLANET['b_building_id'] 	= implode(";", $QueueArray);
			return true;
		}
	}	
	
	public function SetNextQueueElementOnTop()
	{
		global $resource, $db, $LNG;

		if (empty($this->PLANET['b_building_id']))
		{
			$this->PLANET['b_building']    = 0;
			$this->PLANET['b_building_id'] = '';
		}

		$QueueArray 	= explode (";", $this->PLANET['b_building_id']);
		$Loop       	= true;
		$BuildEndTime	= $this->TIME;
		while ($Loop == true)
		{
			$ListIDArray         = explode(",", $QueueArray[0]);
			$Element             = $ListIDArray[0];
			$Level               = $ListIDArray[1];
			$BuildTime  	     = GetBuildingTime($this->USER, $this->PLANET, $Element, $ListIDArray[4] == 'destroy');
			$BuildEndTime        = $this->TIME + $BuildTime;
			$BuildMode           = $ListIDArray[4];
			$QueueArray[0]		 = implode(",", array($Element, $Level, $BuildTime, $BuildEndTime, $BuildMode));
			$ForDestroy 		 = ($BuildMode == 'destroy') ? true : false;
			$HaveNoMoreLevel     = false;
								
			$HaveRessources 	 = IsElementBuyable($this->USER, $this->PLANET, $Element, true, $ForDestroy);
				
			if($ForDestroy && $this->PLANET[$resource[$Element]] == 0) {
				$HaveRessources  = false;
				$HaveNoMoreLevel = true;
			}

			if($HaveRessources == true) {
				$Needed                 = GetBuildingPrice ($this->USER, $this->PLANET, $Element, true, $ForDestroy);
				$this->PLANET['metal']       -= $Needed['metal'];
				$this->PLANET['crystal']     -= $Needed['crystal'];
				$this->PLANET['deuterium']   -= $Needed['deuterium'];
				$this->USER['darkmatter']    -= $Needed['darkmatter'];					
				$NewQueue               = implode( ";", $QueueArray);
				$Loop                   = false;
			} else {
				if($this->USER['hof'] == 1){
					if ($Mode == true)
						$Message     = sprintf($LNG['sys_nomore_level'], $LNG['tech'][$Element]);
					else
					{
						$Needed      = GetBuildingPrice($this->USER, $this->PLANET, $Element, true, $ForDestroy);
						$Message     = sprintf($LNG['sys_notenough_money'], $this->PLANET['name'], $this->PLANET['id'], $this->PLANET['galaxy'], $this->PLANET['system'], $this->PLANET['planet'], $LNG['tech'][$Element], pretty_number ($this->PLANET['metal']), $LNG['Metal'], pretty_number ($this->PLANET['crystal']), $LNG['Crystal'], pretty_number ($this->PLANET['deuterium']), $LNG['Deuterium'], pretty_number ($Needed['metal']), $LNG['Metal'], pretty_number ($Needed['crystal']), $LNG['Crystal'], pretty_number ($Needed['deuterium']), $LNG['Deuterium']);
					}
					SendSimpleMessage($this->USER['id'], '', $this->TIME, 99, $LNG['sys_buildlist'], $LNG['sys_buildlist_fail'], $Message);				
				}

				array_shift($QueueArray);
					
				if (count($QueueArray) == 0) {
					$BuildEndTime  = 0;
					$NewQueue      = '';
					$Loop          = false;
				} else {
					$BaseTime			= $BuildEndTime - $BuildTime;
					foreach($QueueArray as $ID => $QueueInfo)
					{
						$ListIDArray        = explode(",", $QueueInfo);
						$ListIDArray[2]		= GetBuildingTime($this->USER, $this->PLANET, $ListIDArray[0], $ListIDArray[4] == 'destroy');
						$BaseTime			+= $ListIDArray[2];
						$ListIDArray[3]		= $BaseTime;
						$QueueArray[$ID]	= implode(",", $ListIDArray);
					}
				}
			}
		}
			
		$this->PLANET['b_building']    = $BuildEndTime;
		$this->PLANET['b_building_id'] = $NewQueue;
	}
	
	private function ResearchQueue()
	{
		global $resource;		
		$this->Builded[$this->USER['b_tech_id']]			= 1;
		$this->USER[$resource[$this->USER['b_tech_id']]]	+= 1;
		$this->USER['b_tech_id']							= 0;
		$this->USER['b_tech']      							= 0;
		$this->USER['b_tech_planet']						= 0;
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
				if(empty($resource[$Element]))
					throw new Exception('ID '.$Element.' is not on $resource!');
				
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
					`u`.`b_tech_planet` = '".$USER['b_tech_planet']."'
					WHERE
					`p`.`id` = '". $PLANET['id'] ."' AND
					`u`.`id` = '".$USER['id']."' AND 
					`s`.`sess_id` = '".session_id()."';
					UNLOCK TABLES;";
		$db->multi_query($Qry);
		$this->Builded	= array();
		return array($USER, $PLANET);
	}
}
?>