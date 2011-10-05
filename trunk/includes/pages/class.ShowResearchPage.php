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

class ShowResearchPage
{
	public function CheckLabSettingsInQueue()
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
	
	public function GetRestPrice($Element)
	{
		global $USER, $PLANET, $pricelist, $resource, $LNG;

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
			if (empty($pricelist[$Element][$ResType]))
				continue;

			$cost = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $USER[$resource[$Element]]));

			$restprice[$ResTitle] = pretty_number(max($cost - (($PLANET[$ResType]) ? $PLANET[$ResType] : $USER[$ResType]), 0));
		}

		return $restprice;
	}
	
	public function CancelBuildingFromQueue($PlanetRess)
	{
		global $PLANET, $USER, $db, $resource;
		$CurrentQueue  = unserialize($USER['b_tech_queue']);
		if (empty($CurrentQueue) || empty($USER['b_tech']))
		{
			$USER['b_tech_queue']	= '';
			$USER['b_tech_planet']	= 0;
			$USER['b_tech_id']		= 0;
			$USER['b_tech']			= 0;
			FirePHP::getInstance(true)->log("Queue(Tech): ".$USER['b_tech_queue']);
			return false;
		}
		$Element						= $USER['b_tech_id'];
		$costs							= GetBuildingPrice($USER, $PLANET, $USER['b_tech_id']);
		if($PLANET['id'] == $USER['b_tech_planet'])
		{
			$PLANET['metal']      		+= $costs['metal'];
			$PLANET['crystal']    		+= $costs['crystal'];
			$PLANET['deuterium'] 		+= $costs['deuterium'];	
		} else {
			$db->query("UPDATE ".PLANETS." SET `metal` = `metal` + '".$costs['metal']."', `crystal` = `crystal` + '".$costs['crystal']."', `deuterium` = `deuterium` + '".$costs['deuterium']."' WHERE `id` = '".$USER['b_tech_planet']."';");
		}
		
		$USER['darkmatter']			+= $costs['darkmatter'];
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
			$BuildEndTime	= TIMESTAMP;
			$NewCurrentQueue	= array();
			foreach($CurrentQueue as $ListIDArray)
			{
				if($Element == $ListIDArray[0] || empty($ListIDArray[0]))
					continue;
					
				if($ListIDArray[4] != $PLANET['id'])
					$CPLANET		= $db->uniquequery("SELECT `".$resource[6]."`, `".$resource[31]."` FROM ".PLANETS." WHERE `id` = '".$ListIDArray[4]."';");
				else
					$CPLANET		= $PLANET;
				
				$CPLANET[$resource[31].'_inter']	= $PlanetRess->CheckAndGetLabLevel($USER, $CPLANET);
				$BuildEndTime       += GetBuildingTime($USER, $CPLANET, $ListIDArray[0]);
				$ListIDArray[3]		= $BuildEndTime;
				$NewCurrentQueue[]	= $ListIDArray;				
			}
			if(!empty($NewCurrentQueue)) {
				$USER['b_tech']    			= TIMESTAMP;
				$USER['b_tech_queue'] 		= serialize($NewCurrentQueue);
				$PlanetRess->USER			= $USER;
				$PlanetRess->PLANET			= $PLANET;
				$PlanetRess->SetNextQueueTechOnTop();
				$USER						= $PlanetRess->USER;
				$PLANET						= $PlanetRess->PLANET;
			} else {
				$USER['b_tech']    			= 0;
				$USER['b_tech_queue'] 		= '';
				FirePHP::getInstance(true)->log("Queue(Tech): ".$USER['b_tech_queue']);
			}
		}
	}

	public function RemoveBuildingFromQueue($QueueID, $PlanetRess)
	{
		global $USER, $PLANET, $db;
		
		$CurrentQueue  = unserialize($USER['b_tech_queue']);
		if ($QueueID <= 1 || empty($CurrentQueue))
			return;
			
		$ActualCount   = count($CurrentQueue);
		if ($ActualCount <= 1)
			return $this->CancelBuildingFromQueue($PlanetRess);

		if(!isset($CurrentQueue[$QueueID - 2]))
			return;
			
		$Element 		= $CurrentQueue[$QueueID - 2][0];
		$BuildEndTime	= $CurrentQueue[$QueueID - 2][3];
		unset($CurrentQueue[$QueueID - 1]);
		$NewCurrentQueue	= array();
		foreach($CurrentQueue as $ID => $ListIDArray)
		{				
			if ($ID < $QueueID - 1) {
				$NewCurrentQueue[]	= $ListIDArray;
			} else {
				if($Element == $ListIDArray[0])
					continue;
					
				if($ListIDArray[4] != $PLANET['id'])
					$CPLANET				= $db->uniquequery("SELECT `".$resource[6]."`, `".$resource[31]."` FROM ".PLANETS." WHERE `id` = '".$ListIDArray[4].";");
				else
					$CPLANET				= $PLANET;
				
				$CPLANET[$resource[31].'_inter']	= $PlanetRess->CheckAndGetLabLevel($USER, $CPLANET);
				
				$BuildEndTime       += GetBuildingTime($USER, $CPLANET, $ListIDArray[0]);
				$ListIDArray[3]		= $BuildEndTime;
				$NewCurrentQueue[]	= $ListIDArray;				
			}
		}
		
		if(!empty($NewCurrentQueue))
			$USER['b_tech_queue'] = serialize($NewCurrentQueue);
		else
			$USER['b_tech_queue'] = "";
			
		FirePHP::getInstance(true)->log("Queue(Tech): ".$USER['b_tech_queue']);
	}

	public function AddBuildingToQueue($Element, $AddMode = true)
	{
		global $PLANET, $USER, $resource, $CONF;
			
		$CurrentQueue  		= unserialize($USER['b_tech_queue']);
		
		if (!empty($CurrentQueue)) {
			$ActualCount   	= count($CurrentQueue);
		} else {
			$CurrentQueue  	= array();
			$ActualCount   	= 0;
		}
				
		if($CONF['max_elements_tech'] != 0 && $CONF['max_elements_tech'] <= $ActualCount)
			return false;
			
		$BuildLevel					= $USER[$resource[$Element]] + 1;
		if($ActualCount == 0)
		{	
			if(!IsElementBuyable($USER, $PLANET, $Element))
				return;

			$Resses						= GetBuildingPrice($USER, $PLANET, $Element);
			$BuildTime   				= GetBuildingTime($USER, $PLANET, $Element);	
					
			$PLANET['metal']			-= $Resses['metal'];
			$PLANET['crystal']			-= $Resses['crystal'];
			$PLANET['deuterium']		-= $Resses['deuterium'];
			$USER['darkmatter']			-= $Resses['darkmatter'];
			$BuildEndTime				= TIMESTAMP + $BuildTime;
			$USER['b_tech_queue']		= serialize(array(array($Element, $BuildLevel, $BuildTime, $BuildEndTime, $PLANET['id'])));
			$USER['b_tech']				= $BuildEndTime;
			$USER['b_tech_id']			= $Element;
			$USER['b_tech_planet']		= $PLANET['id'];
		} else {
			$InArray = 0;
			foreach($CurrentQueue as $QueueSubArray) {
				if($QueueSubArray[0] == $Element) 
					$InArray++;
			}
			$USER[$resource[$Element]] += $InArray;
			$BuildTime  				= GetBuildingTime($USER, $PLANET, $Element);
			$USER[$resource[$Element]] -= $InArray;
			$BuildEndTime				= $CurrentQueue[$ActualCount - 1][3] + $BuildTime;
			$BuildLevel					+= $InArray;
			$CurrentQueue[]				= array($Element, $BuildLevel, $BuildTime, $BuildEndTime, $PLANET['id']);
			$USER['b_tech_queue']		= serialize($CurrentQueue);
		}
		FirePHP::getInstance(true)->log("Queue(Tech): ".$USER['b_tech_queue']);
	}

	public function ShowTechQueue()
	{
		global $LNG, $CONF, $PLANET, $USER, $db;
		
		if ($USER['b_tech'] == 0)
			return array();
		
		$CurrentQueue   = unserialize($USER['b_tech_queue']);

		$ListIDRow		= "";
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
				'endtime' 	=> (int) tz_date($BuildArray[3], 'U'),
				'planet'	=> $PlanetName,
			);
		}
		return $ScriptData;
	}

	public function __construct()
	{
		global $PLANET, $USER, $LNG, $resource, $reslist, $CONF, $db, $pricelist;

		include_once(ROOT_PATH . 'includes/functions/IsTechnologieAccessible.php');
		include_once(ROOT_PATH . 'includes/functions/GetElementPrice.php');
		
		$template	= new template();			
		
		$PlanetRess 	= new ResourceUpdate();
		$PlanetRess->CalcResource();
		if ($PLANET[$resource[31]] == 0)
		{
			$PlanetRess->SavePlanetToDB();
			$template->message($LNG['bd_lab_required']);
			exit;
		}
		
		$bContinue		= $this->CheckLabSettingsInQueue($PLANET) ? true : false;
			
		$TheCommand		= request_var('cmd','');
		$Element     	= request_var('tech', 0);
		$ListID     	= request_var('listid', 0);
		$PLANET[$resource[31].'_inter']	= $PlanetRess->CheckAndGetLabLevel($USER, $PLANET);	

		if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($Element) && $bContinue && $USER['urlaubs_modus'] == 0 && ($USER[$resource[$Element]] < $pricelist[$Element]['max'] && IsTechnologieAccessible($USER, $PLANET, $Element) && in_array($Element, $reslist['tech'])) || $TheCommand == "cancel" || $TheCommand == "remove")
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
		
		$TechQueue		= $this->ShowTechQueue();
		$ResearchList	= array();

		foreach($reslist['tech'] as $ID => $Element)
		{
			if (!IsTechnologieAccessible($USER, $PLANET, $Element))
				continue;
				
			$ResearchList[]	= array(
				'id'			=> $Element,
				'level'			=> $USER[$resource[$Element]],
				'max'			=> $pricelist[$Element]['max'],
				'price'			=> GetElementPrice($USER, $PLANET, $Element, true),
				'time'        	=> pretty_time(GetBuildingTime($USER, $PLANET, $Element)),
				'restprice'		=> $this->GetRestPrice($Element),
				'buyable'		=> IsElementBuyable($USER, $PLANET, $Element, true, false),
			);
		}
		
		if($USER['b_tech_id'] != 0)
			$template->loadscript('research.js');

		$Bonus	= array(
			106	=> $USER['rpg_espion'] * $pricelist[610]['info'],
			108	=> $USER['rpg_commandant'] * $pricelist[611]['info'],
		);
		
		$template->assign_vars(array(
			'ResearchList'	=> $ResearchList,
			'IsLabinBuild'	=> !$bContinue,
			'IsFullQueue'	=> $CONF['max_elements_tech'] == 0 || $CONF['max_elements_tech'] == count($TechQueue),
			'Queue'			=> $TechQueue,
			'oldLink'  		=> $CONF['max_elements_tech'] == 1,
			'Bonus'  		=> $Bonus,
		));
		
		$template->show('buildings_research.tpl');
	}
}