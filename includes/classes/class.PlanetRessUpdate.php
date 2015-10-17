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

class ResourceUpdate
{

	/**
	 * reference of the config object
	 * @var Config
	 */
	private $config			= NULL;

	private $isGlobalMode 	= NULL;
	private $TIME			= NULL;
	private $HASH			= NULL;
	private $ProductionTime	= NULL;

	private $PLANET			= array();
	private $USER			= array();
	private $Builded		= array();

	function __construct($Build = true, $Tech = true)
	{
		$this->Build	= $Build;
		$this->Tech		= $Tech;
	}

	public function setData($USER, $PLANET)
	{
		$this->USER		= $USER;
		$this->PLANET	= $PLANET;
	}

	public function getData()
	{
		return array($this->USER, $this->PLANET);
	}
	
	public function ReturnVars() {
		if($this->isGlobalMode)
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
		
		$ressource	= array_merge(array(), $reslist['resstype'][1], $reslist['resstype'][2]);
		foreach($ressource as $ID) {
			$Hash[]	= $this->config->{$resource[$ID].'_basic_income'};
		}
		
		$Hash[]	= $this->config->resource_multiplier;
		$Hash[]	= $this->config->energySpeed;
		$Hash[]	= $this->USER['factor']['Resource'];
		$Hash[]	= $this->USER['factor']['Energy'];
		$Hash[]	= $this->PLANET[$resource[22]];
		$Hash[]	= $this->PLANET[$resource[23]];
		$Hash[]	= $this->PLANET[$resource[24]];
		$Hash[]	= $this->USER[$resource[131]];
		$Hash[]	= $this->USER[$resource[132]];
		$Hash[]	= $this->USER[$resource[133]];
		return md5(implode("::", $Hash));
	}
	
	public function CalcResource($USER = NULL, $PLANET = NULL, $SAVE = false, $TIME = NULL, $HASH = true)
	{			
		$this->isGlobalMode	= !isset($USER, $PLANET) ? true : false;
		$this->USER			= $this->isGlobalMode ? $GLOBALS['USER'] : $USER;
		$this->PLANET		= $this->isGlobalMode ? $GLOBALS['PLANET'] : $PLANET;
		$this->TIME			= is_null($TIME) ? TIMESTAMP : $TIME;
		$this->config		= Config::get($this->USER['universe']);
		
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
		
		$this->UpdateResource($this->TIME, $HASH);
			
		if($SAVE === true)
			$this->SavePlanetToDB($this->USER, $this->PLANET);
			
		return $this->ReturnVars();
	}
	
	public function UpdateResource($TIME, $HASH = false)
	{
		$this->ProductionTime  			= ($TIME - $this->PLANET['last_update']);
		
		if($this->ProductionTime > 0)
		{
			$this->PLANET['last_update']	= $TIME;
			if($HASH === false) {
				$this->ReBuildCache();
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
			
		$MaxMetalStorage		= $this->PLANET['metal_max']     * $this->config->max_overflow;
		$MaxCristalStorage		= $this->PLANET['crystal_max']   * $this->config->max_overflow;
		$MaxDeuteriumStorage	= $this->PLANET['deuterium_max'] * $this->config->max_overflow;
		
		$MetalTheoretical		= $this->ProductionTime * (($this->config->metal_basic_income * $this->config->resource_multiplier) + $this->PLANET['metal_perhour']) / 3600;
		
		if($MetalTheoretical < 0)
		{
			$this->PLANET['metal']      = max($this->PLANET['metal'] + $MetalTheoretical, 0);
		} 
		elseif ($this->PLANET['metal'] <= $MaxMetalStorage)
		{
			$this->PLANET['metal']      = min($this->PLANET['metal'] + $MetalTheoretical, $MaxMetalStorage);
		}
		
		$CristalTheoretical	= $this->ProductionTime * (($this->config->crystal_basic_income * $this->config->resource_multiplier) + $this->PLANET['crystal_perhour']) / 3600;
		if ($CristalTheoretical < 0)
		{
			$this->PLANET['crystal']      = max($this->PLANET['crystal'] + $CristalTheoretical, 0);
		} 
		elseif ($this->PLANET['crystal'] <= $MaxCristalStorage ) 
		{
			$this->PLANET['crystal']      = min($this->PLANET['crystal'] + $CristalTheoretical, $MaxCristalStorage);
		}
		
		$DeuteriumTheoretical	= $this->ProductionTime * (($this->config->deuterium_basic_income * $this->config->resource_multiplier) + $this->PLANET['deuterium_perhour']) / 3600;
		if ($DeuteriumTheoretical < 0)
		{
			$this->PLANET['deuterium']    = max($this->PLANET['deuterium'] + $DeuteriumTheoretical, 0);
		} 
		elseif($this->PLANET['deuterium'] <= $MaxDeuteriumStorage) 
		{
			$this->PLANET['deuterium']    = min($this->PLANET['deuterium'] + $DeuteriumTheoretical, $MaxDeuteriumStorage);
		}
		
		$this->PLANET['metal']		= max($this->PLANET['metal'], 0);
		$this->PLANET['crystal']	= max($this->PLANET['crystal'], 0);
		$this->PLANET['deuterium']	= max($this->PLANET['deuterium'], 0);
	}
	
	public static function getProd($Calculation)
	{
		return 'return '.$Calculation.';';
	}
	
	public static function getNetworkLevel($USER, $PLANET)
	{
		global $resource;

		$researchLevelList	= array($PLANET[$resource[31]]);
		if($USER[$resource[123]] > 0)
		{
			$sql = 'SELECT '.$resource[31].' FROM %%PLANETS%% WHERE id != :planetId AND id_owner = :userId AND destruyed = 0 ORDER BY '.$resource[31].' DESC LIMIT :limit;';
			$researchResult = Database::get()->select($sql, array(
				':limit'	=> (int) $USER[$resource[123]],
				':planetId'	=> $PLANET['id'],
				':userId'	=> $USER['id']
			));

			foreach($researchResult as $researchRow)
			{
				$researchLevelList[]	= $researchRow[$resource[31]];
			}
		}
		
		return $researchLevelList;
	}
	
	public function ReBuildCache()
	{
		global $ProdGrid, $resource, $reslist;
		
		if ($this->PLANET['planet_type'] == 3)
		{
			$this->config->metal_basic_income     	= 0;
			$this->config->crystal_basic_income   	= 0;
			$this->config->deuterium_basic_income 	= 0;
		}
		
		$temp	= array(
			901	=> array(
				'max'	=> 0,
				'plus'	=> 0,
				'minus'	=> 0,
			),
			902	=> array(
				'max'	=> 0,
				'plus'	=> 0,
				'minus'	=> 0,
			),
			903	=> array(
				'max'	=> 0,
				'plus'	=> 0,
				'minus'	=> 0,
			),
			911	=> array(
				'plus'	=> 0,
				'minus'	=> 0,
			)
		);
		
		$BuildTemp		= $this->PLANET['temp_max'];
		$BuildEnergy	= $this->USER[$resource[113]];
		
		foreach($reslist['storage'] as $ProdID)
		{
			foreach($reslist['resstype'][1] as $ID) 
			{
				if(!isset($ProdGrid[$ProdID]['storage'][$ID]))
					continue;
					
				$BuildLevel 		= $this->PLANET[$resource[$ProdID]];
				$temp[$ID]['max']	+= round(eval(self::getProd($ProdGrid[$ProdID]['storage'][$ID])));
			}
		}
		
		$ressIDs	= array_merge(array(), $reslist['resstype'][1], $reslist['resstype'][2]);
		
		foreach($reslist['prod'] as $ProdID)
		{	
			$BuildLevelFactor	= $this->PLANET[$resource[$ProdID].'_porcent'];
			$BuildLevel 		= $this->PLANET[$resource[$ProdID]];
			
			foreach($ressIDs as $ID) 
			{
				if(!isset($ProdGrid[$ProdID]['production'][$ID]))
					continue;
				
				$Production	= eval(self::getProd($ProdGrid[$ProdID]['production'][$ID]));
				
				if($Production > 0) {					
					$temp[$ID]['plus']	+= $Production;
				} else {
					if(in_array($ID, $reslist['resstype'][1]) && $this->PLANET[$resource[$ID]] == 0) {
						 continue;
					}
					
					$temp[$ID]['minus']	+= $Production;
				}
			}
		}
		
		$this->PLANET['metal_max']			= $temp[901]['max'] * $this->config->resource_multiplier * STORAGE_FACTOR * (1 + $this->USER['factor']['ResourceStorage']);
		$this->PLANET['crystal_max']		= $temp[902]['max'] * $this->config->resource_multiplier * STORAGE_FACTOR * (1 + $this->USER['factor']['ResourceStorage']);
		$this->PLANET['deuterium_max']		= $temp[903]['max'] * $this->config->resource_multiplier * STORAGE_FACTOR * (1 + $this->USER['factor']['ResourceStorage']);

		$this->PLANET['energy']				= round($temp[911]['plus'] * $this->config->energySpeed * (1 + $this->USER['factor']['Energy']));
		$this->PLANET['energy_used']		= $temp[911]['minus'] * $this->config->energySpeed;
		if($this->PLANET['energy_used'] == 0) {
			$this->PLANET['metal_perhour']		= 0;
			$this->PLANET['crystal_perhour']	= 0;
			$this->PLANET['deuterium_perhour']	= 0;
		} else {
			$prodLevel	= min(1, $this->PLANET['energy'] / abs($this->PLANET['energy_used']));
			
			$this->PLANET['metal_perhour']		= ($temp[901]['plus'] * (1 + $this->USER['factor']['Resource'] + 0.02 * $this->USER[$resource[131]]) * $prodLevel + $temp[901]['minus']) * $this->config->resource_multiplier;
			$this->PLANET['crystal_perhour']	= ($temp[902]['plus'] * (1 + $this->USER['factor']['Resource'] + 0.02 * $this->USER[$resource[132]]) * $prodLevel + $temp[902]['minus']) * $this->config->resource_multiplier;
			$this->PLANET['deuterium_perhour']	= ($temp[903]['plus'] * (1 + $this->USER['factor']['Resource'] + 0.02 * $this->USER[$resource[133]]) * $prodLevel + $temp[903]['minus']) * $this->config->resource_multiplier;
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

		return true;
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

		$Element      	= $CurrentQueue[0][0];
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
	

		array_shift($CurrentQueue);
		$OnHash	= in_array($Element, $reslist['prod']);
		$this->UpdateResource($BuildEndTime, !$OnHash);			
			
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

		$BuildEndTime	= 0;
		$NewQueue		= '';

		while ($Loop === true)
		{
			$ListIDArray		= $CurrentQueue[0];
			$Element			= $ListIDArray[0];
			$Level				= $ListIDArray[1];
			$BuildMode			= $ListIDArray[4];
			$ForDestroy			= ($BuildMode == 'destroy') ? true : false;
			$costResources		= BuildFunctions::getElementPrice($this->USER, $this->PLANET, $Element, $ForDestroy);
			$BuildTime			= BuildFunctions::getBuildingTime($this->USER, $this->PLANET, $Element, $costResources);
			$HaveResources		= BuildFunctions::isElementBuyable($this->USER, $this->PLANET, $Element, $costResources);
			$BuildEndTime		= $this->PLANET['b_building'] + $BuildTime;
			$CurrentQueue[0]	= array($Element, $Level, $BuildTime, $BuildEndTime, $BuildMode);
			$HaveNoMoreLevel	= false;
				
			if($ForDestroy && $this->PLANET[$resource[$Element]] == 0) {
				$HaveResources  = false;
				$HaveNoMoreLevel = true;
			}

			if($HaveResources === true) {
				if(isset($costResources[901])) { $this->PLANET[$resource[901]]	-= $costResources[901]; }
				if(isset($costResources[902])) { $this->PLANET[$resource[902]]	-= $costResources[902]; }
				if(isset($costResources[903])) { $this->PLANET[$resource[903]]	-= $costResources[903]; }
				if(isset($costResources[921])) { $this->USER[$resource[921]]	-= $costResources[921]; }
				$NewQueue               	= serialize($CurrentQueue);
				$Loop                  		= false;
			} else {
				if($this->USER['hof'] == 1){
					if ($HaveNoMoreLevel) {
						$Message     = sprintf($LNG['sys_nomore_level'], $LNG['tech'][$Element]);
					} else {
						if(!isset($costResources[901])) { $costResources[901] = 0; }
						if(!isset($costResources[902])) { $costResources[902] = 0; }
						if(!isset($costResources[903])) { $costResources[903] = 0; }
						
						$Message     = sprintf($LNG['sys_notenough_money'], $this->PLANET['name'], $this->PLANET['id'], $this->PLANET['galaxy'], $this->PLANET['system'], $this->PLANET['planet'], $LNG['tech'][$Element], pretty_number ($this->PLANET['metal']), $LNG['tech'][901], pretty_number($this->PLANET['crystal']), $LNG['tech'][902], pretty_number ($this->PLANET['deuterium']), $LNG['tech'][903], pretty_number($costResources[901]), $LNG['tech'][901], pretty_number ($costResources[902]), $LNG['tech'][902], pretty_number ($costResources[903]), $LNG['tech'][903]);
					}

					PlayerUtil::sendMessage($this->USER['id'], 0,$LNG['sys_buildlist'], 99,
						$LNG['sys_buildlist_fail'], $Message, $this->TIME);
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

		return true;
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
		$this->USER[$resource[$this->USER['b_tech_id']]]	+= 1;
	

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
			$isAnotherPlanet	= $ListIDArray[4] != $this->PLANET['id'];
			if($isAnotherPlanet)
			{
				$sql	= 'SELECT * FROM %%PLANETS%% WHERE id = :planetId;';
				$PLANET	= Database::get()->selectSingle($sql, array(
					':planetId'	=> $ListIDArray[4],
				));

				$RPLANET 		= new ResourceUpdate(true, false);
				list(, $PLANET)	= $RPLANET->CalcResource($this->USER, $PLANET, false, $this->USER['b_tech']);
			}
			else
			{
				$PLANET	= $this->PLANET;
			}

			$PLANET[$resource[31].'_inter']	= self::getNetworkLevel($this->USER, $PLANET);
			
			$Element            = $ListIDArray[0];
			$Level              = $ListIDArray[1];
			$costResources		= BuildFunctions::getElementPrice($this->USER, $PLANET, $Element);
			$BuildTime			= BuildFunctions::getBuildingTime($this->USER, $PLANET, $Element, $costResources);
			$HaveResources		= BuildFunctions::isElementBuyable($this->USER, $PLANET, $Element, $costResources);
			$BuildEndTime       = $this->USER['b_tech'] + $BuildTime;
			$CurrentQueue[0]	= array($Element, $Level, $BuildTime, $BuildEndTime, $PLANET['id']);
			
			if($HaveResources == true) {
				if(isset($costResources[901])) { $PLANET[$resource[901]]		-= $costResources[901]; }
				if(isset($costResources[902])) { $PLANET[$resource[902]]		-= $costResources[902]; }
				if(isset($costResources[903])) { $PLANET[$resource[903]]		-= $costResources[903]; }
				if(isset($costResources[921])) { $this->USER[$resource[921]]	-= $costResources[921]; }
				$this->USER['b_tech_id']		= $Element;
				$this->USER['b_tech']      		= $BuildEndTime;
				$this->USER['b_tech_planet']	= $PLANET['id'];
				$this->USER['b_tech_queue'] 	= serialize($CurrentQueue);

				$Loop                  			= false;
			} else {
				if($this->USER['hof'] == 1){
					if(!isset($costResources[901])) { $costResources[901] = 0; }
					if(!isset($costResources[902])) { $costResources[902] = 0; }
					if(!isset($costResources[903])) { $costResources[903] = 0; }
					
					$Message     = sprintf($LNG['sys_notenough_money'], $PLANET['name'], $PLANET['id'], $PLANET['galaxy'], $PLANET['system'], $PLANET['planet'], $LNG['tech'][$Element], pretty_number ($PLANET['metal']), $LNG['tech'][901], pretty_number($PLANET['crystal']), $LNG['tech'][902], pretty_number ($PLANET['deuterium']), $LNG['tech'][903], pretty_number($costResources[901]), $LNG['tech'][901], pretty_number ($costResources[902]), $LNG['tech'][902], pretty_number ($costResources[903]), $LNG['tech'][903]);
					PlayerUtil::sendMessage($this->USER['id'], 0, $this->USER['b_tech'], 99, $LNG['sys_techlist'], $LNG['sys_buildlist_fail'], $Message);
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
				
			if($isAnotherPlanet)
			{
				$RPLANET->SavePlanetToDB($this->USER, $PLANET);
				$RPLANET		= NULL;
				unset($RPLANET);
			}
			else
			{
				$this->PLANET	= $PLANET;
			}
		}

		return true;
	}
	
	public function SavePlanetToDB($USER = NULL, $PLANET = NULL)
	{
		global $resource, $reslist;
		
		if(is_null($USER))
			global $USER;
			
		if(is_null($PLANET))
			global $PLANET;

		$buildQueries	= array();

		$params	= array(
			':userId'				=> $USER['id'],
			':planetId'				=> $PLANET['id'],
			':metal'				=> $PLANET['metal'],
			':crystal'				=> $PLANET['crystal'],
			':deuterium'			=> $PLANET['deuterium'],
			':ecoHash'				=> $PLANET['eco_hash'],
			':lastUpdateTime'		=> $PLANET['last_update'],
			':b_building'			=> $PLANET['b_building'],
			':b_building_id' 		=> $PLANET['b_building_id'],
			':field_current' 		=> $PLANET['field_current'],
			':b_hangar_id'			=> $PLANET['b_hangar_id'],
			':metal_perhour'		=> $PLANET['metal_perhour'],
			':crystal_perhour'		=> $PLANET['crystal_perhour'],
			':deuterium_perhour'	=> $PLANET['deuterium_perhour'],
			':metal_max'			=> $PLANET['metal_max'],
			':crystal_max'			=> $PLANET['crystal_max'],
			':deuterium_max'		=> $PLANET['deuterium_max'],
			':energy_used'			=> $PLANET['energy_used'],
			':energy'				=> $PLANET['energy'],
			':b_hangar'				=> $PLANET['b_hangar'],
			':darkmatter'			=> $USER['darkmatter'],
			':b_tech'				=> $USER['b_tech'],
			':b_tech_id'			=> $USER['b_tech_id'],
			':b_tech_planet'		=> $USER['b_tech_planet'],
			':b_tech_queue'			=> $USER['b_tech_queue']
		);

		if (!empty($this->Builded))
		{
			foreach($this->Builded as $Element => $Count)
			{
				$Element	= (int) $Element;
				
				if(empty($resource[$Element]) || empty($Count)) {
					continue;
				}
				
				if(in_array($Element, $reslist['one']))
				{
					$buildQueries[]						= ', p.'.$resource[$Element].' = :'.$resource[$Element];
					$params[':'.$resource[$Element]]	= '1';
				}
				elseif(isset($PLANET[$resource[$Element]]))
				{
					$buildQueries[]						= ', p.'.$resource[$Element].' = p.'.$resource[$Element].' + :'.$resource[$Element];
					$params[':'.$resource[$Element]]	= floatToString($Count);
				}
				elseif(isset($USER[$resource[$Element]]))
				{
					$buildQueries[]						= ', u.'.$resource[$Element].' = u.'.$resource[$Element].' + :'.$resource[$Element];
					$params[':'.$resource[$Element]]	= floatToString($Count);
				}
			}
		}

		$sql = 'UPDATE %%PLANETS%% as p,%%USERS%% as u SET
		p.metal				= :metal,
		p.crystal			= :crystal,
		p.deuterium			= :deuterium,
		p.eco_hash			= :ecoHash,
		p.last_update		= :lastUpdateTime,
		p.b_building		= :b_building,
		p.b_building_id 	= :b_building_id,
		p.field_current 	= :field_current,
		p.b_hangar_id		= :b_hangar_id,
		p.metal_perhour		= :metal_perhour,
		p.crystal_perhour	= :crystal_perhour,
		p.deuterium_perhour	= :deuterium_perhour,
		p.metal_max			= :metal_max,
		p.crystal_max		= :crystal_max,
		p.deuterium_max		= :deuterium_max,
		p.energy_used		= :energy_used,
		p.energy			= :energy,
		p.b_hangar			= :b_hangar,
		u.darkmatter		= :darkmatter,
		u.b_tech			= :b_tech,
		u.b_tech_id			= :b_tech_id,
		u.b_tech_planet		= :b_tech_planet,
		u.b_tech_queue		= :b_tech_queue
		'.implode("\n", $buildQueries).'
		WHERE p.id = :planetId AND u.id = :userId;';

		Database::get()->update($sql, $params);

		$this->Builded	= array();

		return array($USER, $PLANET);
	}
}