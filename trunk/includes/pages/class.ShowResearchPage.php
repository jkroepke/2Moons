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
 * @version 1.3 (2011-01-21)
 * @link http://code.google.com/p/2moons/
 */

class ShowResearchPage
{
	private function CheckLabSettingsInQueue()
	{
		global $PLANET, $CONF;
		if ($PLANET['b_building_id'] == 0)
			return true;
			
		$QueueArray		= explode (";", $PLANET['b_building_id']);

		for($i = 0; $i < $CONF['max_elements_build']; $i++)	{
			$ListIDArray	= explode (",", $QueueArray[$i]);
			if($ListIDArray[0] == 6 || $ListIDArray[0] == 31)
				return false;
		}

		return true;
	}
	
	private function GetRestPrice($Element)
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
	
	private function CancelBuildingFromQueue($PlanetRess)
	{
		global $PLANET, $USER, $db, $resource;
		$CurrentQueue  = $USER['b_tech_queue'];
		if (empty($CurrentQueue) || empty($USER['b_tech']))
		{
			$USER['b_tech_queue']	= '';
			$USER['b_tech_planet']	= 0;
			$USER['b_tech_id']		= 0;
			$USER['b_tech']			= 0;
			return false;
		}

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
	
	
		$QueueArray          = explode ( ";", $CurrentQueue );
		$ActualCount         = count ( $QueueArray );
		$CanceledIDArray     = explode ( ",", $QueueArray[0] );

		array_shift($QueueArray);
		if (count($QueueArray) == 0) {
			$USER['b_tech_queue']	= '';
			$USER['b_tech_planet']	= 0;
			$USER['b_tech_id']		= 0;
			$USER['b_tech']			= 0;
		} else {
			$BuildEndTime	= TIMESTAMP;
			foreach($QueueArray as $ID => $Elements)
			{
				$ListIDArray        = explode(',', $Elements);
				if($ListIDArray[4] != $PLANET['id'])
					$CPLANET		= $db->uniquequery("SELECT `".$resource[6]."`, `".$resource[31]."` FROM ".PLANETS." WHERE `id` = '".$ListIDArray[4]."';");
				else
					$CPLANET		= $PLANET;
				
				$CPLANET[$resource[31].'_inter']	= $PlanetRess->CheckAndGetLabLevel($USER, $CPLANET);
				$BuildEndTime       += GetBuildingTime($USER, $CPLANET, $ListIDArray[0]);
				$ListIDArray[3]		= $BuildEndTime;
				$NewQueueArray[]	= implode(',', $ListIDArray);				
			}
			
			$BuildArray   				= explode (",", $NewQueueArray[0]);
			$USER['b_tech']    			= $BuildArray[3];
			$USER['b_tech_queue'] 		= implode(";", $NewQueueArray);
			$PlanetRess->USER			= $USER;
			$PlanetRess->PLANET			= $PLANET;
			$PlanetRess->SetNextQueueTechOnTop();
			$USER						= $PlanetRess->USER;
			$PLANET						= $PlanetRess->PLANET;
		}
		
		return $ReturnValue;
	}

	private function RemoveBuildingFromQueue($QueueID, $PlanetRess)
	{
		global $USER, $PLANET;
		if ($QueueID <= 1 || empty($USER['b_tech_queue']))
			return;
		$CurrentQueue  = $USER['b_tech_queue'];

		$QueueArray    = explode(";", $CurrentQueue);
		$ActualCount   = count($QueueArray);
		if($ActualCount <= 1)
			return $this->CancelBuildingFromQueue($PlanetRess);
				
		$ListIDArray   = explode( ",", $QueueArray[$QueueID - 2]);
		$BuildEndTime  = $ListIDArray[3];
		for ($ID = $QueueID; $ID < $ActualCount; $ID++ )
		{
			$ListIDArray         		= explode ( ",", $QueueArray[$ID] );
			if($ListIDArray[4] != $PLANET['id'])
				$CPLANET				= $db->uniquequery("SELECT `".$resource[6]."`, `".$resource[31]."` FROM ".PLANETS." WHERE `id` = '".$ListIDArray[4].";");
			else
				$CPLANET				= $PLANET;
			
			$CPLANET[$resource[31].'_inter']	= $PlanetRess->CheckAndGetLabLevel($USER, $CPLANET);
			
			$BuildEndTime        		+= GetBuildingTime($USER, $CPLANET, $ListIDArray[0]);
			$ListIDArray[3]       		= $BuildEndTime;
			$QueueArray[$ID - 1]  		= implode ( ",", $ListIDArray );
		}
		unset($QueueArray[$ActualCount - 1]);
		$NewQueue     = implode ( ";", $QueueArray );
		$USER['b_tech_queue'] = $NewQueue;
	}

	private function AddBuildingToQueue($Element, $AddMode = true)
	{
		global $PLANET, $USER, $resource, $CONF;
			
		$CurrentQueue  		= $USER['b_tech_queue'];

		if (!empty($CurrentQueue)) {
			$QueueArray    = explode( ";", $CurrentQueue);
			$ActualCount   = count($QueueArray);
		} else {
			$QueueArray    = array();
			$ActualCount   = 0;
		}
				
		if($CONF['max_elements_tech'] <= $ActualCount)
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
			$USER['b_tech_queue']		= $Element .",". $BuildLevel .",". $BuildTime .",". $BuildEndTime .",".$PLANET['id'];
			$USER['b_tech']				= $BuildEndTime;
			$USER['b_tech_id']			= $Element;
			$USER['b_tech_planet']		= $PLANET['id'];
		} else {
			$InArray = 0;
			foreach($QueueArray as $QueueSub)
			{
				$QueueSubArray = explode ( ",",$QueueSub);
				if($QueueSubArray[0] == $Element) 
					$InArray++;
			}
			$USER[$resource[$Element]] += $InArray;
			$BuildTime  				= GetBuildingTime($USER, $PLANET, $Element);
			$USER[$resource[$Element]] -= $InArray;
			$LastQueue 					= explode( ",",$QueueArray[$ActualCount - 1]);
			$BuildEndTime				= $LastQueue[3] + $BuildTime;
			$BuildLevel					+= $InArray;
			$USER['b_tech_queue']		= $CurrentQueue.";".$Element .",". $BuildLevel .",". $BuildTime .",". $BuildEndTime .",".$PLANET['id'];
		}
	}

	private function ShowTechQueue()
	{
		global $LNG, $CONF, $PLANET, $USER, $db;
		
		if ($USER['b_tech'] == 0)
			return array();
		
		$CurrentQueue   = $USER['b_tech_queue'];
		$QueueArray   	= explode(";", $CurrentQueue);
		$ActualCount  	= count($QueueArray);

		$ListIDRow		= "";
		$ScriptData		= array();
		
		for ($QueueID = 0; $QueueID < $ActualCount; $QueueID++)
		{
			$BuildArray   = explode (",", $QueueArray[$QueueID]);
			if ($BuildArray[3] < TIMESTAMP)
				continue;
			
			if($BuildArray[4] != $PLANET['id'])
				$PlanetName	= $db->countquery("SELECT `name` FROM ".PLANETS." WHERE `id` = '".$BuildArray[4]."';");
			else
				$PlanetName	= '';
				
			$ScriptData[] = array('element' => $BuildArray[0], 'level' => $BuildArray[1], 'time' => $BuildArray[2], 'name' => $LNG['tech'][$BuildArray[0]], 'planet' => $PlanetName, 'endtime' => $BuildArray[3], 'reload' => in_array($BuildArray[0], array(123)));
		}
		return $ScriptData;
		exit;
	}

	public function __construct()
	{
		global $PLANET, $USER, $LNG, $resource, $reslist, $CONF, $db, $pricelist, $OfficerInfo;

		include_once(ROOT_PATH . 'includes/functions/IsTechnologieAccessible.php');
		include_once(ROOT_PATH . 'includes/functions/GetElementPrice.php');
		
		$template	= new template();			
		
		if ($PLANET[$resource[31]] == 0)
		{
			$template->message($LNG['bd_lab_required']);
			exit;
		}
		
		$bContinue		= $this->CheckLabSettingsInQueue($PLANET) ? true : false;
			
		$TheCommand		= request_var('cmd','');
		$Element     	= request_var('tech', 0);
		$ListID     	= request_var('listid', 0);
		$PlanetRess 	= new ResourceUpdate();
		$PLANET[$resource[31].'_inter']	= $PlanetRess->CheckAndGetLabLevel($USER, $PLANET);	

		$PlanetRess->CalcResource();
		if(!empty($Element) && $bContinue && $USER['urlaubs_modus'] == 0 && ($USER[$resource[$Element]] < $pricelist[$Element]['max'] && IsTechnologieAccessible($USER, $PLANET, $Element) && in_array($Element, $reslist['tech'])) || $TheCommand == "cancel" || $TheCommand == "remove")
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
		$ScriptInfo	= array();
		$TechQueue	= $this->ShowTechQueue();
		foreach($reslist['tech'] as $ID => $Element)
		{
			if (!IsTechnologieAccessible($USER, $PLANET, $Element))
				continue;
				
			$CanBeDone               = IsElementBuyable($USER, $PLANET, $Element);
			
			if(isset($pricelist[$Element]['max']) && $USER[$resource[$Element]] >= $pricelist[$Element]['max']) {
				$TechnoLink  =	"<font color=\"#FF0000\">".$LNG['bd_maxlevel']."</font>";
			} elseif($CONF['max_elements_tech'] > 1) {
				$LevelToDo 	= 1 + $USER[$resource[$Element]];
				$TechnoLink = $CanBeDone && $bContinue ? "<a href=\"game.php?page=buildings&amp;mode=research&amp;cmd=insert&amp;tech=".$Element."\"><font color=\"#00FF00\">".(($USER['b_tech_id'] != 0) ? $LNG['bd_add_to_list'] : $LNG['bd_research'].(($LevelToDo == 1) ? "" : "<br>".$LNG['bd_lvl']." ".$LevelToDo))."</font></a>" : "<font color=\"#FF0000\">".$LNG['bd_research'].(($LevelToDo == 1) ? "" : "<br>".$LNG['bd_lvl']." ".$LevelToDo)."</font>";

				if($USER['b_tech_id'] != 0) {
					$template->loadscript('researchlist.js');
					$template->execscript('ReBuildView();Techlist();');
					$ScriptInfo	= array('bd_cancel' => $LNG['bd_cancel'], 'bd_continue' => $LNG['bd_continue'], 'bd_finished' => $LNG['bd_finished'], 'build' => $TechQueue);
				}
			} else {
				if ($USER['b_tech_id'] == 0) {
					$LevelToDo = 1 + $USER[$resource[$Element]];
					
					$TechnoLink = $CanBeDone && $bContinue ? "<a href=\"game.php?page=buildings&amp;mode=research&amp;cmd=insert&amp;tech=".$Element."\"><font color=\"#00FF00\">".$LNG['bd_research'].(($LevelToDo == 1) ? "" : "<br>".$LNG['bd_lvl']." ".$LevelToDo)."</font></a>" : "<font color=\"#FF0000\">".$LNG['bd_research'].(($LevelToDo == 1) ? "" : "<br>".$LNG['bd_lvl']." ".$LevelToDo)."</font>";
				} else {
					if ($USER['b_tech_id'] == $Element) {
						$template->loadscript('research.js');
						if ($USER['b_tech_planet'] == $PLANET['id']) {
							$ScriptInfo	= array(
								'tech_time'		=> $USER['b_tech'],
								'tech_name'		=> '',
								'game_name'		=> $CONF['game_name'],
								'tech_lang'		=> $LNG['tech'][$USER['b_tech_id']],
								'tech_home'		=> $USER['b_tech_planet'],
								'tech_id'		=> $USER['b_tech_id'],					
								'bd_cancel'		=> $LNG['bd_cancel'],
								'bd_ready'		=> $LNG['bd_ready'],
								'bd_continue'	=> $LNG['bd_continue'],
							);
						} else {
							$ScriptInfo	= array(
								'tech_time'		=> $USER['b_tech'],
								'tech_name'		=> $LNG['bd_on'].'<br>'.$TechQueue['planet'],
								'tech_home'		=> $USER['b_tech_planet'],
								'tech_id'		=> $USER['b_tech_id'],
								'game_name'		=> $CONF['game_name'],
								'tech_lang'		=> $LNG['tech'][$USER['b_tech_id']],
								'bd_cancel'		=> $LNG['bd_cancel'],
								'bd_ready'		=> $LNG['bd_ready'],
								'bd_continue'	=> $LNG['bd_continue'],
							);
						}

						$TechnoLink  = '<div id="research"></div>';
					}
					else
						$TechnoLink  = '<center>-</center>';
				}
			}
			
			$ResearchList[] = array(
				'id'		=> $Element,
				'maxinfo'	=> (isset($pricelist[$Element]['max']) && $pricelist[$Element]['max'] != 255) ? sprintf($LNG['bd_max_lvl'], $pricelist[$Element]['max']):'',
				'name'  	=> $LNG['tech'][$Element],
				'descr'  	=> $LNG['res']['descriptions'][$Element],
				'price'  	=> GetElementPrice($USER, $PLANET, $Element),					
				'time' 		=> pretty_time(GetBuildingTime($USER, $PLANET, $Element)),
				'restprice'	=> $this->GetRestPrice($Element),
				'elvl'		=> ($Element == 106) ? ($USER['rpg_espion'] * $OfficerInfo[610]['info'])." (".$LNG['tech'][610].")" : (($Element == 108) ? ($USER['rpg_commandant'] * $OfficerInfo[611]['info'])." (".$LNG['tech'][611].")" : false),
				'lvl'		=> $USER[$resource[$Element]],
				'link'  	=> $TechnoLink,
				'oldlink'  	=> $CONF['max_elements_tech'] == 1,
				'queue'  	=> $TechQueue,
			);
		}
		$template->assign_vars(array(
			'ResearchList'			=> $ResearchList,
			'IsLabinBuild'			=> !$bContinue,
			'ScriptInfo'			=> json_encode($ScriptInfo),
			'bd_building_lab'		=> $LNG['bd_building_lab'],
			'bd_remaining'			=> $LNG['bd_remaining'],			
			'bd_lvl'				=> $LNG['bd_lvl'],			
			'fgf_time'				=> $LNG['fgf_time'],
		));
		
		$template->show('buildings_research.tpl');
	}
}