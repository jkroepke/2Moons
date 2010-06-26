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
	}
	
	public function CalcResource($USER = NULL, $PLANET = NULL, $SAVE = false)
	{
		if(empty($USER))
			global $USER;
			
		if(empty($PLANET))
			global $PLANET;
			
		if($USER['urlaubs_modus'] == 1)
			return array($USER, $PLANET);
			
		if($this->Build)
		{
			list($USER, $PLANET)	= $this->ShipyardQueue($USER, $PLANET);
			
			if($USER['b_tech'] != 0 && $USER['b_tech'] < TIMESTAMP)
				list($USER, $PLANET)	= $this->ResearchQueue($USER, $PLANET);
			if($PLANET['b_building'] != 0)
				list($USER, $PLANET)	= $this->BuildingQueue($USER, $PLANET);
		}	

		list($USER, $PLANET)	= $this->UpdateRessource($USER, $PLANET, TIMESTAMP);
		
		if($SAVE == true)
			list($USER, $PLANET)	= $this->SavePlanetToDB($USER, $PLANET);
			
		return array($USER, $PLANET);
	}
	
	private function UpdateRessource($USER, $PLANET, $TIME)
	{
		global $ProdGrid, $resource, $reslist, $CONF, $ExtraDM;
		
		$PLANET['metal_max']			= floor(2.5 * pow(1.8331954764, $PLANET[$resource[22]])) * 5000 * (1 + ($USER['rpg_stockeur'] * 0.5)) * $CONF['resource_multiplier'] * STORAGE_FACTOR;
		$PLANET['crystal_max']			= floor(2.5 * pow(1.8331954764, $PLANET[$resource[23]])) * 5000 * (1 + ($USER['rpg_stockeur'] * 0.5)) * $CONF['resource_multiplier'] * STORAGE_FACTOR;
		$PLANET['deuterium_max']		= floor(2.5 * pow(1.8331954764, $PLANET[$resource[24]])) * 5000 * (1 + ($USER['rpg_stockeur'] * 0.5)) * $CONF['resource_multiplier'] * STORAGE_FACTOR;
		
		$MaxMetalStorage                = $PLANET['metal_max']     * MAX_OVERFLOW;
		$MaxCristalStorage              = $PLANET['crystal_max']   * MAX_OVERFLOW;
		$MaxDeuteriumStorage            = $PLANET['deuterium_max'] * MAX_OVERFLOW;
		$this->ProductionTime          	= ($TIME - $PLANET['last_update']);

		$PLANET['last_update']   		= $TIME;

		if ($PLANET['planet_type'] == 3)
		{
			$CONF['metal_basic_income']     = 0;
			$CONF['crystal_basic_income']   = 0;
			$CONF['deuterium_basic_income'] = 0;
			$PLANET['metal_perhour']        = 0;
			$PLANET['crystal_perhour']      = 0;
			$PLANET['deuterium_perhour']    = 0;
			$PLANET['energy_used']          = 0;
			$PLANET['energy_max']           = 0;
		}
		else
		{
			$Caps           = array();
			$BuildTemp      = $PLANET['temp_max'];
			$BuildEnergy	= $USER[$resource[113]];
			$Caps['metal_perhour'] = $Caps['crystal_perhour'] = $Caps['deuterium_perhour'] = $Caps['energy_used'] = $Caps['energy_max'] = $Caps['deuterium_used'] = 0;

			foreach($reslist['prod'] as $id => $ProdID)
			{
				$BuildLevelFactor	= $PLANET[$resource[$ProdID]."_porcent" ];
				$BuildLevel 		= $PLANET[$resource[$ProdID]];
				$Caps['metal_perhour']		+= floor(eval($ProdGrid[$ProdID]['formule']['metal'])     * $CONF['resource_multiplier'] * (1 + (($USER['rpg_geologue'] * 0.05) + ($USER['metal_proc_tech'] * 0.02) + ((TIMESTAMP - $USER[$resource[703]] <= 0) ? ($ExtraDM[703]['add']) : 0))));
				$Caps['crystal_perhour']	+= floor(eval($ProdGrid[$ProdID]['formule']['crystal'])   * $CONF['resource_multiplier'] * (1 + (($USER['rpg_geologue'] * 0.05) + ($USER['crystal_proc_tech'] * 0.02) + ((TIMESTAMP - $USER[$resource[703]] <= 0) ? ($ExtraDM[703]['add']) : 0))));
			
				if ($ProdID < 4) {
					$Caps['deuterium_perhour'] 	+= floor(eval($ProdGrid[$ProdID]['formule']['deuterium']) * $CONF['resource_multiplier'] * (1 + (($USER['rpg_geologue'] * 0.05) + ($USER['deuterium_proc_tech'] * 0.02) + ((TIMESTAMP - $USER[$resource[703]] <= 0) ? ($ExtraDM[703]['add']) : 0))));
					$Caps['energy_used']   		+= floor(eval($ProdGrid[$ProdID]['formule']['energy']) * ($CONF['resource_multiplier']));
				} else {
					if($ProdID == 12 && $PLANET['deuterium'] == 0)
						continue;

					$Caps['deuterium_used'] 	+= floor(eval($ProdGrid[$ProdID]['formule']['deuterium']) * ($CONF['resource_multiplier']));
					$Caps['energy_max']			+= floor(eval($ProdGrid[$ProdID]['formule']['energy']) * ($CONF['resource_multiplier']) * (1 + ($USER['rpg_ingenieur'] * 0.05)) * ((TIMESTAMP - $USER[$resource[704]] <= 0) ? (1 + $ExtraDM[704]['add']) : 1));
				}
			}
			
			if ($Caps['energy_max'] == 0)
			{
				$PLANET['metal_perhour']     = $CONF['metal_basic_income'];
				$PLANET['crystal_perhour']   = $CONF['crystal_basic_income'];
				$PLANET['deuterium_perhour'] = $CONF['deuterium_basic_income'];
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
			
			$PLANET['metal_perhour']        = $Caps['metal_perhour'] * (0.01 * $LEVEL);
			$PLANET['crystal_perhour']      = $Caps['crystal_perhour'] * (0.01 * $LEVEL);
			$PLANET['deuterium_perhour']    = $Caps['deuterium_perhour'] * (0.01 * $LEVEL) + $Caps['deuterium_used'];
			$PLANET['energy_used']          = $Caps['energy_used'];
			$PLANET['energy_max']           = $Caps['energy_max'];

			if ($PLANET['metal'] <= $MaxMetalStorage)
			{
				$MetalTheorical 		= $PLANET['metal'] + ($this->ProductionTime * (($CONF['metal_basic_income'] * $CONF['resource_multiplier']) + $PLANET['metal_perhour']) / 3600);
				$PLANET['metal']  		= min($MetalTheorical, $MaxMetalStorage);
			}
			
			if ($PLANET['crystal'] <= $MaxCristalStorage)
			{
				$CristalTheorical  		= $PLANET['crystal'] + ($this->ProductionTime * (($CONF['crystal_basic_income'] * $CONF['resource_multiplier']) + $PLANET['crystal_perhour']) / 3600);
				$PLANET['crystal']  	= min($CristalTheorical, $MaxCristalStorage);
			}
			
			if ($PLANET['deuterium'] <= $MaxDeuteriumStorage)
			{
				$DeuteriumTheorical		= $PLANET['deuterium'] + ($this->ProductionTime * (($CONF['deuterium_basic_income'] * $CONF['resource_multiplier']) + $PLANET['deuterium_perhour']) / 3600);
				$PLANET['deuterium']	= min($DeuteriumTheorical, $MaxDeuteriumStorage);
			}
		}
		
		$PLANET['metal']		= max($PLANET['metal'], 0);
		$PLANET['crystal']		= max($PLANET['crystal'], 0);
		$PLANET['deuterium']	= max($PLANET['deuterium'], 0);
		return array($USER, $PLANET);
	}
	
	private function ShipyardQueue($USER, $PLANET)
	{
		global $resource;

		if (empty($PLANET['b_hangar_id']))
		{
			$PLANET['b_hangar'] = 0;
			return array($USER, $PLANET);
		}
		
		$BuildQueue                 = explode(';', $PLANET['b_hangar_id']);
		$AcumTime					= 0;
		$PLANET['b_hangar'] 		+= (TIMESTAMP - $PLANET['last_update']);
		foreach ($BuildQueue as $Node => $Array)
		{
			if (empty($Array))
				continue;
			
			$Item              = explode(',', $Array);
			$AcumTime		   += GetBuildingTime($USER, $PLANET, $Item[0]);
			$BuildArray[$Node] = array($Item[0], $Item[1], $AcumTime);
		}

		$PLANET['b_hangar_id'] 		= '';
		$UnFinished 					= false;
		
		foreach($BuildArray as $Node => $Item)
		{
			$Element   = $Item[0];
			$Count     = $Item[1];
			$BuildTime = $Item[2];
			
			if($BuildTime == 0) {
				$this->Builded[$Element]		= bcadd($Count, $this->Builded[$Element]);
				$PLANET[$resource[$Element]]	= bcadd($Count, $PLANET[$resource[$Element]]);
				continue;					
			}
			
			$GetBuildShips					= max(min(bcdiv($PLANET['b_hangar'], $BuildTime, 0), $Count), 0);
			
			if($GetBuildShips == 0)
			{
				$PLANET['b_hangar_id'] .= $Element.",".$Count.";";
				continue;
			}
			
			$PLANET['b_hangar']				-= bcmul($GetBuildShips, $BuildTime);
			$this->Builded[$Element]		= bcadd($GetBuildShips, $this->Builded[$Element]);
			$PLANET[$resource[$Element]]	= bcadd($GetBuildShips, $PLANET[$resource[$Element]]);
			$Count							= bcsub($Count, $GetBuildShips);						
			
			if ($Count == 0)
				continue;
			
			$PLANET['b_hangar_id'] .= $Element.",".$Count.";";
		}
		return array($USER, $PLANET);
	}
	
	private function BuildingQueue($USER, $PLANET) 
	{
		while(true)
		{	
			list($USER, $PLANET, $Result)	= $this->CheckPlanetBuildingQueue($USER, $PLANET);
			if(!$Result)
				break;
			
			list($USER, $PLANET)	= $this->SetNextQueueElementOnTop($USER, $PLANET);
		}
		
		return array($USER, $PLANET);
	}
	
	private function CheckPlanetBuildingQueue($USER, $PLANET)
	{
		global $resource, $db;
		
		if (empty($PLANET['b_building_id']))
			return array($USER, $PLANET, false);
		
		$CurrentQueue  	= $PLANET['b_building_id'];
		$QueueArray    	= explode(";", $PLANET['b_building_id']);
		$ActualCount   	= count($QueueArray);

		$BuildArray   	= explode (",", $QueueArray[0]);
		$Element      	= $BuildArray[0];
		$Level      	= $BuildArray[1];
		$BuildEndTime 	= $BuildArray[3];
		$BuildMode    	= $BuildArray[4];
			
		if ($BuildEndTime > TIMESTAMP)
			return array($USER, $PLANET, false);

		$ForDestroy = ($BuildMode == 'destroy') ? true : false;
		
		if ($ForDestroy == false)
		{
			$PLANET['field_current']		+= 1;
			$PLANET[$resource[$Element]]	+= 1;
			$this->Builded[$Element]		+= 1;
		}
		else
		{
			$PLANET['field_current'] 		-= 1;
			$PLANET[$resource[$Element]] 	-= 1;
			$this->Builded[$Element]		-= 1;
		}
	
		array_shift($QueueArray);		
		list($USER, $PLANET)	= $this->UpdateRessource($USER, $PLANET, $BuildEndTime);			
			
		if (count($QueueArray) == 0) {
			$PLANET['b_building']    	= 0;
			$PLANET['b_building_id'] 	= '';
			return array($USER, $PLANET, false);
		} else {
			$BuildArray   				= explode (",", $QueueArray[0]);
			$PLANET['b_building']    	= $BuildArray[3];
			$PLANET['b_building_id'] 	= implode(";", $QueueArray);
			return array($USER, $PLANET, true);
		}
	}	
	
	public function SetNextQueueElementOnTop($USER, $PLANET)
	{
		global $LNG, $resource, $db;

		if (empty($PLANET['b_building_id']))
		{
			$PLANET['b_building']    = 0;
			$PLANET['b_building_id'] = '';
			return array($USER, $PLANET);
		}

		$QueueArray 	= explode (";", $PLANET['b_building_id']);
		$Loop       	= true;
		$BuildEndTime	= TIMESTAMP;
		while ($Loop == true)
		{
			$ListIDArray         = explode ( ",", $QueueArray[0]);
			$Element             = $ListIDArray[0];
			$Level               = $ListIDArray[1];
			$BuildTime  	     = $ListIDArray[2];
			$BuildEndTime        = $ListIDArray[3];
			$BuildMode           = $ListIDArray[4];
			$ForDestroy 		 = ($BuildMode == 'destroy') ? true : false;

			$HaveNoMoreLevel     = false;
								
			$HaveRessources 	 = IsElementBuyable($USER, $PLANET, $Element, true, $ForDestroy);
				
			if($ForDestroy && $PLANET[$resource[$Element]] == 0) {
				$HaveRessources  = false;
				$HaveNoMoreLevel = true;
			}

			if($HaveRessources == true) {
				$Needed                 = GetBuildingPrice ($USER, $PLANET, $Element, true, $ForDestroy);
				$PLANET['metal']       -= $Needed['metal'];
				$PLANET['crystal']     -= $Needed['crystal'];
				$PLANET['deuterium']   -= $Needed['deuterium'];
				$USER['darkmatter']    -= $Needed['darkmatter'];					
				$NewQueue               = implode( ";", $QueueArray);
				$Loop                   = false;
			} else {
				if($USER['hof'] == 1) {
					if ($HaveNoMoreLevel == true)
						$Message     = sprintf($LNG['sys_nomore_level'], $LNG['tech'][$Element]);
					else
					{
						$Needed      = GetBuildingPrice($USER, $PLANET, $Element, true, $ForDestroy);
						$Message     = sprintf($LNG['sys_notenough_money'], $PLANET['name'], $PLANET['id'], $PLANET['galaxy'], $PLANET['system'], $PLANET['planet'], $LNG['tech'][$Element], pretty_number ($PLANET['metal']), $LNG['Metal'], pretty_number ($PLANET['crystal']), $LNG['Crystal'], pretty_number ($PLANET['deuterium']), $LNG['Deuterium'], pretty_number ($Needed['metal']), $LNG['Metal'], pretty_number ($Needed['crystal']), $LNG['Crystal'], pretty_number ($Needed['deuterium']), $LNG['Deuterium']);
					}
					SendSimpleMessage($USER['id'], '', ($BuildEndTime - $BuildTime), 99, $LNG['sys_buildlist'], $LNG['sys_buildlist_fail'], $Message);
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
						$BaseTime			+= $ListIDArray[2];
						$ListIDArray[3]		= $BaseTime;
						$QueueArray[$ID]	= implode(",", $ListIDArray);
					}
				}
			}
		}
			
		$PLANET['b_building']    = $BuildEndTime;
		$PLANET['b_building_id'] = $NewQueue;
		return array($USER, $PLANET);
	}
	
	private function ResearchQueue($USER, $PLANET)
	{
		global $resource;		
		$this->Builded[$USER['b_tech_id']]		= 1;
		$USER[$resource[$USER['b_tech_id']]]	+= 1;
		$USER['b_tech_id']						= 0;
		$USER['b_tech']      					= 0;
		$USER['b_tech_planet']					= 0;
		
		return array($USER, $PLANET);
	}
	
	public function SavePlanetToDB($USER = NULL, $PLANET = NULL)
	{
		global $resource, $db, $reslist;
		
		if(empty($USER))
			global $USER;
			
		if(empty($PLANET))
			global $PLANET;
		
		if($USER['urlaubs_modus'] == 1)
			return array($USER, $PLANET);
			
		$Qry	= "LOCK TABLE ".PLANETS." as p WRITE, ".USERS." as u WRITE;
				   UPDATE ".PLANETS." as p, ".USERS." as u SET
				   `p`.`metal` = '".floattostring($PLANET['metal'], 6)."',
				   `p`.`crystal` = '".floattostring($PLANET['crystal'], 6)."',
				   `p`.`deuterium` = '".floattostring($PLANET['deuterium'], 6)."',
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
				   `p`.`energy_max` = '".$PLANET['energy_max']."', ";
		if (!empty($this->Builded))
		{
			foreach($this->Builded as $Element => $Count)
			{
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
		$Qry	.= "`p`.`b_hangar` = '". $PLANET['b_hangar'] ."',
					`u`.`darkmatter` = '".$USER['darkmatter']."',
					`u`.`b_tech` = '".$USER['b_tech']."',
					`u`.`b_tech_id` = '".$USER['b_tech_id']."',
					`u`.`b_tech_planet` = '".$USER['b_tech_planet']."'
					WHERE
					`p`.`id` = '". $PLANET['id'] ."' AND
					`u`.`id` = '".$USER['id']."';
					UNLOCK TABLES;";
		$db->multi_query($Qry);
		return array($USER, $PLANET);
	}
}
?>