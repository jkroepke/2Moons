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
	private function GetRestPrice($Element, $Factor = true)
	{
		global $pricelist, $resource, $LNG, $USER, $PLANET;

		if ($Factor)
			$level = ($PLANET[$resource[$Element]]) ? $PLANET[$resource[$Element]] : $USER[$resource[$Element]];

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

			if ($Factor)
				$cost = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level));
			else
				$cost = floor($pricelist[$Element][$ResType]);
			
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

	private function RemoveBuildingFromQueue($QueueID)
	{
		global $PLANET;
		if ($QueueID <= 1 || empty($PLANET['b_building_id']))
			return;
		
		$CurrentQueue  = $PLANET['b_building_id'];

		$QueueArray    = explode ( ";", $CurrentQueue );
		$ActualCount   = count ( $QueueArray );
		if($ActualCount <= 1)
			return $this->CancelBuildingFromQueue();
				
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

	private function __construct()
	{
		global $LNG, $CONF, $PLANET, $USER;
		
		$CurrentQueue   = $PLANET['b_building_id'];
		$QueueID        = 0;
		if ($CurrentQueue != 0)
		{
			$QueueArray    = explode ( ";", $CurrentQueue );
			$ActualCount   = count ( $QueueArray );
		}
		else
		{
			$QueueArray    = "0";
			$ActualCount   = 0;
		}

		$ListIDRow    = "";

		if ($ActualCount != 0)
		{
			$PlanetID     = $PLANET['id'];
			for ($QueueID = 0; $QueueID < $ActualCount; $QueueID++)
			{
				$BuildArray   = explode (",", $QueueArray[$QueueID]);
				$BuildEndTime = $BuildArray[3];
				$CurrentTime  = TIMESTAMP;
				if ($BuildEndTime >= $CurrentTime)
				{
					$ListID       = $QueueID + 1;
					$Element      = $BuildArray[0];
					$BuildLevel   = $BuildArray[1];
					$BuildCTime   = $BuildArray[2];
					$BuildMode    = $BuildArray[4];
					$BuildTime    = $BuildEndTime - TIMESTAMP;
					$ElementTitle = $LNG['tech'][$Element];

					if ($ListID > 0)
					{
						$ListIDRow .= "<tr>";
						if ($ListID == 1)
						{
							$ListIDRow .= "<td class=\"l\" width=\"70%\">". $ListID .".: ". $ElementTitle ." ".$BuildLevel.(($BuildMode == 'destroy') ? ' '.$LNG['bd_dismantle'] : '')."<br><br><div id=\"progressbar\"></div></td>";
							$ListIDRow .= "<th>";
							$ListIDRow .= "		<div id=\"blc\" class=\"z\">". $BuildTime ."<br>";
							$ListIDRow .= "		<a href=\"game.php?page=buildings&amp;cmd=cancel\">".$LNG['bd_interrupt']."</a></div>";
							$ListIDRow .= "		<script type=\"text/javascript\">";
							$ListIDRow .= "			pp = '". $BuildTime ."';\n";
							$ListIDRow .= "			pm = 'cancel';\n";
							$ListIDRow .= "			pl = '".$PLANET['id']."';\n";
							$ListIDRow .= "			loc = 'buildings';\n";
							$ListIDRow .= "			ne = '".$ElementTitle."';\n";
							$ListIDRow .= "			gamename = '".$CONF['game_name']."';\n";
							$ListIDRow .= "			bd_continue = '".$LNG['bd_continue']."';\n";
							$ListIDRow .= "			bd_finished = '".$LNG['bd_finished']."';\n";
							$ListIDRow .= "			bd_cancel = '".$LNG['bd_cancel']."';\n";
							$ListIDRow .= "			Buildlist();;\n";
							$ListIDRow .= "		</script>\n";
							$ListIDRow .= "		<script type=\"text/javascript\">\n";
							$ListIDRow .= "		function title() \n {var datem = document.getElementById('blc').innerHTML.split(\"<\");\n document.title = datem[0] + \" - ". $ElementTitle ." - ".$CONF['game_name']."\";\n  window.setTimeout('title();', 1000);}\n title();";
							$ListIDRow .= "		$(function() {";
							$ListIDRow .= "			$(\"#progressbar\").progressbar({";
							$ListIDRow .= "				value: ".(($BuildCTime != 0) ? floattostring(abs(100 - ($BuildTime / $BuildCTime) * 100), 2, true):100)."";
							$ListIDRow .= "			});";
							$ListIDRow .= "			$(\".ui-progressbar-value\").animate({ width: \"100%\" }, ".($BuildTime * 1000).", \"linear\");";
							$ListIDRow .= "		});";
							$ListIDRow .= "		</script>";
						}
						else
						{
							$ListIDRow .= "<td class=\"l\" width=\"70%\">". $ListID .".: ". $ElementTitle ." ".$BuildLevel.(($BuildMode == 'destroy') ? ' '.$LNG['bd_dismantle'] : '')."</td>";
							$ListIDRow .= "<th>";
							$ListIDRow .= "		<a href=\"game.php?page=buildings&amp;cmd=remove&amp;listid=". $ListID ."\">".$LNG['bd_cancel']."</a></font>";
						}
						$ListIDRow .= "<br><font color=\"lime\">". date("d. M y H:i:s" ,$BuildEndTime) ."</font>";
						$ListIDRow .= "	</th>";
						$ListIDRow .= "</tr>";
					}
				}
			}
		}

		$RetValue['lenght']    = $ActualCount;
		$RetValue['buildlist'] = $ListIDRow;

		return $RetValue;
	}

	public function ShowBuildingsPage()
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
		
		if(!empty($Element) && (IsTechnologieAccessible($USER, $PLANET, $Element) && in_array($Element, $reslist['allow'][$PLANET['planet_type']]) && ($Element == 31 && $USER["b_tech_planet"] == 0 || $Element != 31) && ((($Element == 15 || $Element == 21) && empty($PLANET['b_hangar_id'])) || ($Element != 15 || $Element != 21))) || $TheCommand == "cancel" || $TheCommand == "remove")
		{
			switch($TheCommand)
			{
				case 'cancel':
					$this->CancelBuildingFromQueue($PlanetRess);
				break;
				case 'remove':
					$this->RemoveBuildingFromQueue($ListID);
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

		$Queue = $this->ShowBuildingQueue();

		$template	= new template();
		$template->page_header();	
		$template->page_topnav();
		$template->page_leftmenu();
		$template->page_planetmenu();
		$template->page_footer();
		
		$CanBuildElement 	= ($Queue['lenght'] < (MAX_BUILDING_QUEUE_SIZE)) ? true : false;
		$BuildingPage       = "";
		$CurrentMaxFields   = CalculateMaxPlanetFields($PLANET);
		$RoomIsOk 			= ($PLANET["field_current"] < ($CurrentMaxFields - $Queue['lenght'])) ? true : false;
				
		$BuildEnergy		= $USER[$resource[113]];
		$BuildLevelFactor   = 10;
		$BuildTemp          = $PLANET['temp_max'];
		foreach($reslist['allow'][$PLANET['planet_type']] as $ID => $Element)
		{
			if (IsTechnologieAccessible($USER, $PLANET, $Element))
			{
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
					$parse['click'] = ($HaveRessources == true) ? "<a href=\"game.php?page=buildings&amp;cmd=insert&amp;building=". $Element ."\"><font color=\"#00FF00\">".(($Queue['lenght'] != 0) ? $LNG['bd_add_to_list'] : (($NextBuildLevel == 1) ? $LNG['bd_build'] : $LNG['bd_build_next_level'] . $NextBuildLevel))."</font></a>" : "<font color=\"#FF0000\">".(($NextBuildLevel == 1) ? $LNG['bd_build'] : $LNG['bd_build_next_level'] . $NextBuildLevel)."</font>";
				elseif ($RoomIsOk && !$CanBuildElement)
					$parse['click'] = "<font color=\"#FF0000\">".(($NextBuildLevel == 1) ? $LNG['bd_build'] : $LNG['bd_build_next_level'] . $NextBuildLevel) ."</font>";
				else
					$parse['click'] = "<font color=\"#FF0000\">".$LNG['bd_no_more_fields']."</font>";

				if ($Element == 31 && $USER['b_tech'] > TIMESTAMP)
					$parse['click'] = "<font color=\"#FF0000\">".$LNG['bd_working']."</font>";
				elseif (($Element == 15 || $Element == 21) && !empty($PLANET['b_hangar_id']))
					$parse['click'] = "<font color=\"#FF0000\">".$LNG['bd_working']."</font>";
				
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
					'restprice'		=> $this->GetRestPrice($Element, true),
				);
			}
		}

		if ($Queue['lenght'] > 0)
		{
			$template->loadscript('buildlist.js');
			$template->assign_vars(array(
				'BuildList'			=> $Queue['buildlist'],
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