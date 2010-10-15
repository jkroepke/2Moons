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

if(!defined('INSIDE')) die('Hacking attempt!');

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
		$CurrentQueue  = $PLANET['b_building_id'];
		if (empty($CurrentQueue))
		{
			$PLANET['b_building_id']	= '';
			$PLANET['b_building']		= 0;
			return;
		}
	
		$QueueArray          = explode ( ";", $CurrentQueue );
		$ActualCount         = count ( $QueueArray );
		$CanceledIDArray     = explode ( ",", $QueueArray[0] );
		$Element             = $CanceledIDArray[0];
		$BuildMode           = $CanceledIDArray[4];
		
		$ForDestroy 			 = ($BuildMode == 'destroy') ? true : false;
		$Needed                  = GetBuildingPrice ($USER, $PLANET, $Element, true, $ForDestroy);
		$PLANET['metal']		+= $Needed['metal'];
		$PLANET['crystal']		+= $Needed['crystal'];
		$PLANET['deuterium']	+= $Needed['deuterium'];
		$USER['darkmatter']		+= $Needed['darkmatter'];
		array_shift($QueueArray);
		if (count($QueueArray) == 0) {
			$PLANET['b_building']    	= 0;
			$PLANET['b_building_id'] 	= '';
		} else {
			$BuildEndTime	= TIMESTAMP;
			foreach($QueueArray as $ID => $Elements)
			{
				$ListIDArray        = explode(',', $Elements);
				$BuildEndTime       += $ListIDArray[2];
				$ListIDArray[3]		= $BuildEndTime;
				$NewQueueArray[]	= implode(',', $ListIDArray);				
			}
			
			$BuildArray   				= explode (",", $NewQueueArray[0]);
			$PLANET['b_building']    	= $BuildArray[3];
			$PLANET['b_building_id'] 	= implode(";", $NewQueueArray);
			list($USER, $PLANET)		= $PlanetRess->SetNextQueueElementOnTop($USER, $PLANET, TIMESTAMP);
		}
		
		return $ReturnValue;
	}

	private function RemoveBuildingFromQueue($QueueID, $PlanetRess)
	{
		global $PLANET;
		if ($QueueID <= 1 || empty($PLANET['b_building_id']))
			return;
		
		$CurrentQueue  = $PLANET['b_building_id'];

		$QueueArray    = explode ( ";", $CurrentQueue );
		$ActualCount   = count ( $QueueArray );
		if($ActualCount <= 1)
			return $this->CancelBuildingFromQueue($PlanetRess);
				
		$ListIDArray   = explode ( ",", $QueueArray[$QueueID - 2] );
		$BuildEndTime  = $ListIDArray[3];
		for ($ID = $QueueID; $ID < $ActualCount; $ID++ )
		{
			$ListIDArray          = explode ( ",", $QueueArray[$ID] );
			$BuildEndTime        += $ListIDArray[2];
			$ListIDArray[3]       = $BuildEndTime;
			$QueueArray[$ID - 1]  = implode ( ",", $ListIDArray );
		}
		unset ($QueueArray[$ActualCount - 1]);
		$NewQueue     = implode ( ";", $QueueArray );
	
		$PLANET['b_building_id'] = $NewQueue;
	}

	private function AddBuildingToQueue ($Element, $AddMode = true)
	{
		global $PLANET, $USER, $resource;
			
		$CurrentQueue  		= $PLANET['b_building_id'];

		if (!empty($CurrentQueue))
		{
			$QueueArray    = explode( ";", $CurrentQueue);
			$ActualCount   = count($QueueArray);
		}
		else
		{
			$QueueArray    = array();
			$ActualCount   = 0;
		}
		
		$CurrentMaxFields  	= CalculateMaxPlanetFields($PLANET);
		
		if (($ActualCount == MAX_BUILDING_QUEUE_SIZE) || ($PLANET["field_current"] >= ($CurrentMaxFields - $ActualCount) && $_GET['cmd'] != 'destroy'))
			return;
	
		if ($AddMode == true) {
			$BuildMode 		= 'build';
			$BuildLevel		= $PLANET[$resource[$Element]] + 1;
		} else {
			$BuildMode 		= 'destroy';
			$BuildLevel		= $PLANET[$resource[$Element]];
		}		

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
			$PLANET['b_building_id']	= $Element .",". $BuildLevel .",". $BuildTime .",". $BuildEndTime .",". $BuildMode;
			$PLANET['b_building']		= $BuildEndTime;
		} else {
			$InArray = 0;
			foreach($QueueArray as $QueueSub)
			{
				$QueueSubArray = explode ( ",",$QueueSub);
				if ($QueueSubArray[0] == $Element)
				{
					if($QueueSubArray[4] == 'build')
						$InArray++;
					else
						$InArray--;
				}		
			}
			$PLANET[$resource[$Element]] += $InArray;
			$BuildTime  	= GetBuildingTime($USER, $PLANET, $Element, !$AddMode);
			$PLANET[$resource[$Element]] -= $InArray;
			$LastQueue 		= explode( ",",$QueueArray[$ActualCount - 1]);
			$BuildEndTime	= $LastQueue[3] + $BuildTime;
			$BuildLevel		+= $InArray;
			$PLANET['b_building_id']	 = $CurrentQueue.";".$Element .",". $BuildLevel .",". $BuildTime .",". $BuildEndTime .",". $BuildMode;
		}
	}

	private function ShowBuildingQueue()
	{
		global $LNG, $CONF, $PLANET, $USER;
		
		if ($PLANET['b_building'] == 0)
			return array();
		
		$CurrentQueue   = $PLANET['b_building_id'];
		$QueueArray   	= explode(";", $CurrentQueue);
		$ActualCount  	= count($QueueArray);

		$ListIDRow		= "";
		$ScriptData		= array();
		
		for ($QueueID = 0; $QueueID < $ActualCount; $QueueID++)
		{
			$BuildArray   = explode (",", $QueueArray[$QueueID]);
			if ($BuildArray[3] < TIMESTAMP)
				continue;

			$ScriptData[] = array('element' => $BuildArray[0], 'level' => $BuildArray[1], 'time' => $BuildArray[2], 'name' => $LNG['tech'][$BuildArray[0]], 'mode' => (($BuildArray[4] == 'destroy') ? ' '.$LNG['bd_dismantle'] : ''), 'endtime' => $BuildArray[3]);
		}
		return $ScriptData;
	}

	public function __construct()
	{
		global $ProdGrid, $LNG, $resource, $reslist, $CONF, $db, $PLANET, $USER;

		include_once(ROOT_PATH . 'includes/functions/IsTechnologieAccessible.' . PHP_EXT);
		include_once(ROOT_PATH . 'includes/functions/GetElementPrice.' . PHP_EXT);
		
		CheckPlanetUsedFields($PLANET);
		$TheCommand  	= request_var('cmd','');
        $Element     	= request_var('building',0);
        $ListID      	= request_var('listid',0);

		$PlanetRess 	= new ResourceUpdate();
		$PlanetRess->CalcResource();
		
		if(!empty($Element) && $USER['urlaubs_modus'] == 0 && (IsTechnologieAccessible($USER, $PLANET, $Element) && in_array($Element, $reslist['allow'][$PLANET['planet_type']]) && ($Element == 31 && $USER["b_tech_planet"] == 0 || $Element != 31) && ((($Element == 15 || $Element == 21) && empty($PLANET['b_hangar_id'])) || ($Element != 15 || $Element != 21))) || $TheCommand == "cancel" || $TheCommand == "remove")
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

		$Queue	 = $this->ShowBuildingQueue();

		$template	= new template();
		$template->page_header();	
		$template->page_topnav();
		$template->page_leftmenu();
		$template->page_planetmenu();
		$template->page_footer();
		
		$CanBuildElement 	= (count($Queue) < MAX_BUILDING_QUEUE_SIZE) ? true : false;
		$BuildingPage       = "";
		$CurrentMaxFields   = CalculateMaxPlanetFields($PLANET);
		$RoomIsOk 			= ($PLANET["field_current"] < ($CurrentMaxFields - count($Queue))) ? true : false;
				
		$BuildEnergy		= $USER[$resource[113]];
		$BuildLevelFactor   = 10;
		$BuildTemp          = $PLANET['temp_max'];
		foreach($reslist['allow'][$PLANET['planet_type']] as $ID => $Element)
		{
			if (!IsTechnologieAccessible($USER, $PLANET, $Element))
				continue;

			$HaveRessources        	= IsElementBuyable ($USER, $PLANET, $Element, true, false);
			if(in_array($Element, $reslist['prod']))
			{
				$BuildLevel         	= $PLANET[$resource[$Element]];
				$Need 	                = floor(eval($ProdGrid[$Element]['formule']['energy']) * $CONF['resource_multiplier']) * (1 + ($USER['rpg_ingenieur'] * 0.05));
				$BuildLevel			   += 1;
				$Prod 	                = floor(eval($ProdGrid[$Element]['formule']['energy']) * $CONF['resource_multiplier']) * (1 + ($USER['rpg_ingenieur'] * 0.05));
				$EnergyNeed        		= $Prod - $Need;
			} else
				unset($EnergyNeed);
				
			$parse['click']        	= '';
			$NextBuildLevel        	= $PLANET[$resource[$Element]] + 1;

			if ($RoomIsOk && $CanBuildElement)
				$parse['click'] = ($HaveRessources == true) ? "<a href=\"game.php?page=buildings&amp;cmd=insert&amp;building=". $Element ."\"><span style=\"color:#00FF00\">".(($PLANET['b_building'] != 0) ? $LNG['bd_add_to_list'] : (($NextBuildLevel == 1) ? $LNG['bd_build'] : $LNG['bd_build_next_level'] . $NextBuildLevel))."</span></a>" : "<span style=\"color:#FF0000\">".(($NextBuildLevel == 1) ? $LNG['bd_build'] : $LNG['bd_build_next_level'] . $NextBuildLevel)."</span>";
			elseif ($RoomIsOk && !$CanBuildElement)
				$parse['click'] = "<span style=\"color:#FF0000\">".(($NextBuildLevel == 1) ? $LNG['bd_build'] : $LNG['bd_build_next_level'] . $NextBuildLevel) ."</span>";
			else
				$parse['click'] = "<span style=\"color:#FF0000\">".$LNG['bd_no_more_fields']."</span>";

			if (($Element == 6 || $Element == 31) && $USER['b_tech'] > TIMESTAMP)
				$parse['click'] = "<span style=\"color:#FF0000\">".$LNG['bd_working']."</span>";
			elseif (($Element == 14 || $Element == 15 || $Element == 21) && !empty($PLANET['b_hangar_id']))
				$parse['click'] = "<span style=\"color:#FF0000\">".$LNG['bd_working']."</span>";
			
			$BuildInfoList[]	= array(
				'id'			=> $Element,
				'name'			=> $LNG['tech'][$Element],
				'descriptions'	=> $LNG['res']['descriptions'][$Element],
				'level'			=> $PLANET[$resource[$Element]],
				'destroyress'	=> array_map('pretty_number', GetBuildingPrice ($USER, $PLANET, $Element, true, true)),
				'destroytime'	=> pretty_time(GetBuildingTime($USER, $PLANET, $Element, true)),
				'price'			=> GetElementPrice($USER, $PLANET, $Element, true),
				'time'        	=> pretty_time(GetBuildingTime($USER, $PLANET, $Element)),
				'EnergyNeed'	=> (isset($EnergyNeed)) ? sprintf(($EnergyNeed < 0) ? $LNG['bd_need_engine'] : $LNG['bd_more_engine'] , pretty_number(abs($EnergyNeed)), $LNG['Energy']) : "",
				'BuildLink'		=> $parse['click'],
				'restprice'		=> $this->GetRestPrice($Element),
			);
		}

		if ($PLANET['b_building'] != 0)
		{
			$template->execscript('ReBuildView();Buildlist();');
			$template->loadscript('buildlist.js');
			$template->assign_vars(array(
				'data'				=> json_encode(array('bd_cancel' => $LNG['bd_cancel'], 'bd_continue' => $LNG['bd_continue'], 'bd_finished' => $LNG['bd_finished'], 'build' => $Queue)),
			));
		}

		$template->assign_vars(array(
			'BuildInfoList'			=> $BuildInfoList,
			'bd_lvl'				=> $LNG['bd_lvl'],
			'bd_next_level'			=> $LNG['bd_next_level'],
			'Metal'					=> $LNG['Metal'],
			'Crystal'				=> $LNG['Crystal'],
			'Deuterium'				=> $LNG['Deuterium'],
			'Darkmatter'       		=> $LNG['Darkmatter'],
			'bd_dismantle'			=> $LNG['bd_dismantle'],
			'fgf_time'				=> $LNG['fgf_time'],
			'bd_remaining'			=> $LNG['bd_remaining'],
			'bd_jump_gate_action'	=> $LNG['bd_jump_gate_action'],
		));
			
		$template->show("buildings_overview.tpl");
	}
}
?>