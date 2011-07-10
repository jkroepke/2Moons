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
 * @version 1.3.5 (2011-04-22)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */



class ShowBuildingsPage
{	
	private function GetRestPrice($Element)
	{
		global $pricelist, $resource, $LNG, $USER, $PLANET;

		$array = array(
			'metal'      => $LNG['Metal'],
			'crystal'    => $LNG['Crystal'],
			'deuterium'  => $LNG['Deuterium'],
			'energy_max' => $LNG['Energy'],
			'darkmatter' => $LNG['Darkmatter'],
		);
		
		$restprice	= array();
		
		foreach ($array as $ResType => $ResTitle)
		{
			if ($pricelist[$Element][$ResType] == 0)
				continue;

			$cost = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $PLANET[$resource[$Element]]));
			
			$restprice[$ResTitle] = pretty_number(max($cost - (($PLANET[$ResType]) ? $PLANET[$ResType] : $USER[$ResType]), 0));
		}

		return $restprice;
	}
	
	private function CancelBuildingFromQueue($PlanetRess)
	{
		global $PLANET, $USER;
		$CurrentQueue  = unserialize($PLANET['b_building_id']);
		if (empty($CurrentQueue))
		{
			$PLANET['b_building_id']	= '';
			$PLANET['b_building']		= 0;
			return;
		}
	
		$Element             	= $CurrentQueue[0][0];
		$BuildMode          	= $CurrentQueue[0][4];
		
		$Needed                 = GetBuildingPrice ($USER, $PLANET, $Element, true, $BuildMode == 'destroy');
		$PLANET['metal']		+= $Needed['metal'];
		$PLANET['crystal']		+= $Needed['crystal'];
		$PLANET['deuterium']	+= $Needed['deuterium'];
		$USER['darkmatter']		+= $Needed['darkmatter'];
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
					
				$BuildEndTime       += GetBuildingTime($USER, $PLANET, $ListIDArray[0], $ListIDArray[4] == 'destroy');
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
		
		return $ReturnValue;
	}

	private function RemoveBuildingFromQueue($QueueID, $PlanetRess)
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
				if($Element == $ListIDArray[0])
					continue;

				$BuildEndTime       += GetBuildingTime($USER, $CPLANET, $ListIDArray[0]);
				$ListIDArray[3]		= $BuildEndTime;
				$NewQueueArray[]	= $ListIDArray;				
			}
		}
		$PLANET['b_building_id'] = serialize($NewQueueArray);
		FirePHP::getInstance(true)->log("Queue(Build): ".$PLANET['b_building_id']);
	}

	private function AddBuildingToQueue ($Element, $AddMode = true)
	{
		global $PLANET, $USER, $resource, $CONF, $reslist;
		
		if(!in_array($Element, $reslist['allow'][$PLANET['planet_type']])
			|| !IsTechnologieAccessible($USER, $PLANET, $Element) 
			|| !IsElementBuyable($USER, $PLANET, $Element, true, !$AddMode)
			|| ($Element == 31 && $USER["b_tech_planet"] != 0) 
			|| (($Element == 15 || $Element == 21) && !empty($PLANET['b_hangar_id']))
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
		
		if ($ActualCount == $CONF['max_elements_build'] || ($AddMode && $PLANET["field_current"] >= ($CurrentMaxFields - $ActualCount)))
			return;
	
		$BuildMode 		= $AddMode ? 'build' : 'destroy';;
		$BuildLevel		= $PLANET[$resource[$Element]] + (int) $AddMode;
						  
		if($ActualCount == 0)
		{	
			if(!IsElementBuyable($USER, $PLANET, $Element, true, $ForDestroy))
				return;

			$Resses			= GetBuildingPrice($USER, $PLANET, $Element, true, !$AddMode);
			$BuildTime   	= GetBuildingTime($USER, $PLANET, $Element, !$AddMode);	
			
			$PLANET['metal']			-= $Resses['metal'];
			$PLANET['crystal']			-= $Resses['crystal'];
			$PLANET['deuterium']		-= $Resses['deuterium'];
			$USER['darkmatter']			-= $Resses['darkmatter'];
			$BuildEndTime				= TIMESTAMP + $BuildTime;
			$PLANET['b_building_id']	= serialize(array(array($Element, $BuildLevel, $BuildTime, $BuildEndTime, $BuildMode)));
			$PLANET['b_building']		= $BuildEndTime;
		} else {
			$InArray = 0;
			foreach($CurrentQueue as $QueueSubArray)
			{
				if($QueueSubArray[0] == $Element) {
					if($QueueSubArray[4] == 'build')
						$InArray++;
					else
						$InArray--;
				}
			}
			$PLANET[$resource[$Element]] += $InArray;
			$BuildTime  				= GetBuildingTime($USER, $PLANET, $Element, !$AddMode);
			$PLANET[$resource[$Element]] -= $InArray;
			$BuildEndTime				= $CurrentQueue[$ActualCount - 1][3] + $BuildTime;
			$BuildLevel					+= $InArray;
			$CurrentQueue[]				= array($Element, $BuildLevel, $BuildTime, $BuildEndTime, $BuildMode);
			$PLANET['b_building_id']	= serialize($CurrentQueue);		
		}
		FirePHP::getInstance(true)->log("Queue(Build): ".$PLANET['b_building_id']);
	}

	private function ShowBuildingQueue()
	{
		global $LNG, $CONF, $PLANET, $USER;
		
		if ($PLANET['b_building'] == 0)
			return array();
		
		$CurrentQueue   = unserialize($PLANET['b_building_id']);

		$ListIDRow		= "";
		$ScriptData		= array();
		foreach($CurrentQueue as $BuildArray) {
			if ($BuildArray[3] < TIMESTAMP)
				continue;

			$ScriptData[] = array(
				'element'	=> $BuildArray[0], 
				'level' 	=> $BuildArray[1], 
				'time' 		=> $BuildArray[2], 
				'resttime' 	=> ($BuildArray[3] - TIMESTAMP), 
				'destroy' 	=> ($BuildArray[4] == 'destroy'), 
				'endtime' 	=> $BuildArray[3]
			);
		}
		return $ScriptData;
	}

	public function __construct()
	{
		global $ProdGrid, $LNG, $resource, $reslist, $CONF, $db, $PLANET, $USER;

		include_once(ROOT_PATH . 'includes/functions/IsTechnologieAccessible.php');
		include_once(ROOT_PATH . 'includes/functions/GetElementPrice.php');
		
		$TheCommand  	= request_var('cmd', '');
        $Element     	= request_var('building', 0);
        $ListID      	= request_var('listid', 0);

		$PlanetRess 	= new ResourceUpdate();
		$PlanetRess->CalcResource();
		
		if($USER['urlaubs_modus'] == 0)
		{
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
		
		// wellformed buildURLs
		if($_SERVER['REQUEST_METHOD'] === 'POST') {
			header('HTTP/1.0 204 No Content');
			exit;
		}
		
		$Queue	 			= $this->ShowBuildingQueue();
		$QueueCount			= count($Queue);
		$CanBuildElement 	= $QueueCount < $CONF['max_elements_build'];
		$CurrentMaxFields   = CalculateMaxPlanetFields($PLANET);
		$RoomIsOk 			= $PLANET['field_current'] < ($CurrentMaxFields - $QueueCount);
				
		$BuildEnergy		= $USER[$resource[113]];
		$BuildLevelFactor   = 10;
		$BuildTemp          = $PLANET['temp_max'];
		
		$Elements			= $reslist['allow'][$PLANET['planet_type']];
		
		foreach($Elements as $ID => $Element)
		{
			if (!IsTechnologieAccessible($USER, $PLANET, $Element))
				continue;

			$EnergyNeed		= 0;
			
			if(in_array($Element, $reslist['prod']))
			{
				$BuildLevel	= $PLANET[$resource[$Element]];
				$Need		= floor(eval($ProdGrid[$Element]['energy']) * $CONF['resource_multiplier']) * (1 + ($USER['rpg_ingenieur'] * 0.05));
				$BuildLevel	+= 1;
				$Prod		= floor(eval($ProdGrid[$Element]['energy']) * $CONF['resource_multiplier']) * (1 + ($USER['rpg_ingenieur'] * 0.05));
				$EnergyNeed	= $Prod - $Need;
				unset($Need, $BuildLevel, $Prod);
			}
			
			$BuildInfoList[]	= array(
				'id'			=> $Element,
				'level'			=> $PLANET[$resource[$Element]],
				'destroyress'	=> array_map('pretty_number', GetBuildingPrice($USER, $PLANET, $Element, true, true)),
				'destroytime'	=> pretty_time(GetBuildingTime($USER, $PLANET, $Element, true)),
				'price'			=> GetElementPrice($USER, $PLANET, $Element, true),
				'time'        	=> pretty_time(GetBuildingTime($USER, $PLANET, $Element)),
				'EnergyNeed'	=> (!empty($EnergyNeed)) ? sprintf(($EnergyNeed < 0) ? $LNG['bd_need_engine'] : $LNG['bd_more_engine'] , pretty_number(abs($EnergyNeed)), $LNG['Energy']) : "",
				'restprice'		=> $this->GetRestPrice($Element),
				'buyable'		=> IsElementBuyable($USER, $PLANET, $Element, true, false),
			);
		}

		$template			= new template();
		
		if ($PLANET['b_building'] != 0)
		{
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