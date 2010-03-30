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

if(!defined('INSIDE')){ die(header("location:../../"));}

class ShowBuildingsPage
{	
	private function BuildingSavePlanetRecord ($CurrentPlanet)
	{
		global $db;
		
		$QryUpdatePlanet  = "UPDATE ".PLANETS." SET ";
		$QryUpdatePlanet .= "`b_building_id` = '". $CurrentPlanet['b_building_id'] ."', ";
		$QryUpdatePlanet .= "`b_building` = '".    $CurrentPlanet['b_building']    ."' ";
		$QryUpdatePlanet .= "WHERE ";
		$QryUpdatePlanet .= "`id` = '".            $CurrentPlanet['id']            ."';";
		$db->query($QryUpdatePlanet);

		return;
	}
	
	private function GetRestPrice ($user, $planet, $Element, $userfactor = true)
	{
		global $pricelist, $resource, $lang;

		if ($userfactor)
		{
			$level = ($planet[$resource[$Element]]) ? $planet[$resource[$Element]] : $user[$resource[$Element]];
		}

		$array = array(
			'metal'      => $lang['Metal'],
			'crystal'    => $lang['Crystal'],
			'deuterium'  => $lang['Deuterium'],
			'energy_max' => $lang['Energy'],
			'darkmatter' => $lang['Darkmatter'],
		);
		$restprice	= array();
		foreach ($array as $ResType => $ResTitle)
		{
			if ($pricelist[$Element][$ResType] != 0)
			{
				if ($userfactor)
				{
					$cost = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level));
				}
				else
				{
					$cost = floor($pricelist[$Element][$ResType]);
				}
				$restprice[$ResTitle] = pretty_number(max($cost - (($planet[$ResType]) ? $planet[$ResType] : $user[$ResType]), 0));
			}
		}

		return $restprice;
	}
	
	private function CancelBuildingFromQueue (&$CurrentPlanet, &$CurrentUser)
	{
		$CurrentQueue  = $CurrentPlanet['b_building_id'];
		if ($CurrentQueue != 0)
		{
			$QueueArray          = explode ( ";", $CurrentQueue );
			$ActualCount         = count ( $QueueArray );
			$CanceledIDArray     = explode ( ",", $QueueArray[0] );
			$Element             = $CanceledIDArray[0];
			$BuildMode           = $CanceledIDArray[4];

			if ($ActualCount > 1)
			{
				array_shift( $QueueArray );
				$NewCount        = count( $QueueArray );
				$BuildEndTime    = time();
				for ($ID = 0; $ID < $NewCount ; $ID++ )
				{
					$ListIDArray          = explode ( ",", $QueueArray[$ID] );
					$BuildEndTime        += $ListIDArray[2];
					$ListIDArray[3]       = $BuildEndTime;
					$QueueArray[$ID]      = implode ( ",", $ListIDArray );
				}
				$NewQueue        = implode(";", $QueueArray );
				$ReturnValue     = true;
				$BuildEndTime    = 0;
			}
			else
			{
				$NewQueue        = '0';
				$ReturnValue     = false;
				$BuildEndTime    = 0;
			}

			if ($BuildMode == 'destroy')
			{
				$ForDestroy = true;
			}
			else
			{
				$ForDestroy = false;
			}

			if ( $Element != false ) {
				$Needed                        = GetBuildingPrice ($CurrentUser, $CurrentPlanet, $Element, true, $ForDestroy);
				$CurrentPlanet['metal']       += $Needed['metal'];
				$CurrentPlanet['crystal']     += $Needed['crystal'];
				$CurrentPlanet['deuterium']   += $Needed['deuterium'];
				$CurrentUser['darkmatter']	  += $Needed['darkmatter'];
			}

		}
		else
		{
			$NewQueue          = '0';
			$BuildEndTime      = 0;
			$ReturnValue       = false;
		}

		$CurrentPlanet['b_building_id']  = $NewQueue;
		$CurrentPlanet['b_building']     = $BuildEndTime;

		return $ReturnValue;
	}

	private function RemoveBuildingFromQueue ( &$CurrentPlanet, $CurrentUser, $QueueID )
	{
		if ($QueueID > 1)
		{
			$CurrentQueue  = $CurrentPlanet['b_building_id'];
			if ($CurrentQueue != 0)
			{
				$QueueArray    = explode ( ";", $CurrentQueue );
				$ActualCount   = count ( $QueueArray );
				if($ActualCount <= 1)
					exit(header("Location: game.php?page=buildings&cmd=cancel"));
					
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
			}
			$CurrentPlanet['b_building_id'] = $NewQueue;
		}
		return $QueueID;
	}

	private function AddBuildingToQueue (&$CurrentPlanet, $CurrentUser, $Element, $AddMode = true)
	{
		global $resource;
			
		$CurrentQueue  		= $CurrentPlanet['b_building_id'];

		$Queue 				= $this->ShowBuildingQueue($CurrentPlanet, $CurrentUser);
		$CurrentMaxFields  	= CalculateMaxPlanetFields($CurrentPlanet);

		if ($CurrentPlanet["field_current"] >= ($CurrentMaxFields - $Queue['lenght']) && $_GET['cmd'] != 'destroy')
			die(header("location:game.php?page=buildings"));

		if ($CurrentQueue != 0)
		{
			$QueueArray    = explode ( ";", $CurrentQueue );
			$ActualCount   = count ( $QueueArray );
		}
		else
		{
			$QueueArray    = "";
			$ActualCount   = 0;
		}

		if ($AddMode == true)
			$BuildMode = 'build';
		else
			$BuildMode = 'destroy';

		if ($ActualCount < MAX_BUILDING_QUEUE_SIZE)
			$QueueID      = $ActualCount + 1;
		else
			$QueueID      = false;

		if ($QueueID != false)
		{
			if ($QueueID > 1)
			{
				$InArray = 0;
				for ( $QueueElement = 0; $QueueElement < $ActualCount; $QueueElement++ )
				{
					$QueueSubArray = explode ( ",", $QueueArray[$QueueElement] );
					if ($QueueSubArray[0] == $Element)
					{
						$InArray++;
					}
				}
			}
			else
			{
				$InArray = 0;
			}

			if ($InArray != 0)
			{
				$ActualLevel  = $CurrentPlanet[$resource[$Element]];
				if ($AddMode == true)
				{
					$BuildLevel   = $ActualLevel + 1 + $InArray;
					$CurrentPlanet[$resource[$Element]] += $InArray;
					$BuildTime    = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
					$CurrentPlanet[$resource[$Element]] -= $InArray;
				}
				else
				{
					$BuildLevel   = $ActualLevel - 1 - $InArray;
					$CurrentPlanet[$resource[$Element]] -= $InArray;
					$BuildTime    = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
					$CurrentPlanet[$resource[$Element]] += $InArray;
				}
			}
			else
			{
				$ActualLevel  = $CurrentPlanet[$resource[$Element]];
				if ($AddMode == true)
				{
					$BuildLevel   = $ActualLevel + 1;
					$BuildTime    = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
				}
				else
				{
					$BuildLevel   = $ActualLevel - 1;
					$BuildTime    = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
				}
			}
			if ($QueueID == 1)
			{
				$BuildEndTime = time() + $BuildTime;
			}
			else
			{
				$PrevBuild = explode (",", $QueueArray[$ActualCount - 1]);
				$BuildEndTime = $PrevBuild[3] + $BuildTime;
			}
			
			$QueueArray[$ActualCount]       = $Element .",". $BuildLevel .",". $BuildTime .",". $BuildEndTime .",". $BuildMode;
			$NewQueue                       = implode ( ";", $QueueArray );
			$CurrentPlanet['b_building_id'] = $NewQueue;
		}
		return $QueueID;
	}

	private function ShowBuildingQueue ( $CurrentPlanet, $CurrentUser )
	{
		global $lang, $game_config;
		$CurrentQueue   = $CurrentPlanet['b_building_id'];
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
			$PlanetID     = $CurrentPlanet['id'];
			for ($QueueID = 0; $QueueID < $ActualCount; $QueueID++)
			{
				$BuildArray   = explode (",", $QueueArray[$QueueID]);
				$BuildEndTime = floor($BuildArray[3]);
				$CurrentTime  = floor(time());
				if ($BuildEndTime >= $CurrentTime)
				{
					$ListID       = $QueueID + 1;
					$Element      = $BuildArray[0];
					$BuildLevel   = $BuildArray[1];
					$BuildMode    = $BuildArray[4];
					$BuildTime    = $BuildEndTime - time();
					$ElementTitle = $lang['tech'][$Element];

					if ($ListID > 0)
					{
						$ListIDRow .= "<tr>";
						$ListIDRow .= "<td class=\"l\" width=\"70%\">". $ListID .".: ". $ElementTitle ." ".(($BuildMode != 'build') ?($BuildLevel+1)." ".$lang['bd_dismantle'] : $BuildLevel)."</td>";
						$ListIDRow .= "<th>";

						if ($ListID == 1)
						{
							$ListIDRow .= "		<div id=\"blc\" class=\"z\">". $BuildTime ."<br>";
							$ListIDRow .= "		<a href=\"game.php?page=buildings&amp;cmd=cancel\">".$lang['bd_interrupt']."</a></div>";
							$ListIDRow .= "		<script type=\"text/javascript\">";
							$ListIDRow .= "			pp = \"". $BuildTime ."\";\n";
							$ListIDRow .= "			pk = \"". $ListID ."\";\n";
							$ListIDRow .= "			pm = \"cancel\";\n";
							$ListIDRow .= "			pl = \"". $PlanetID ."\";\n";
							$ListIDRow .= "			t();\n";
							$ListIDRow .= "		</script>\n";
							$ListIDRow .= "		<script type=\"text/javascript\">\n";
							$ListIDRow .= "		function title() \n {var datem = document.getElementById('blc').innerHTML.split(\"<\");\n document.title = datem[0] + \" - ". $ElementTitle ." - ".$game_config['game_name']."\";\n  window.setTimeout('title();', 1000);}\n title();";
							$ListIDRow .= "		</script>";
							$ListIDRow .= "		<br><font color=\"lime\">". date("j/m H:i:s" ,$BuildEndTime) ."</font>";
						}
						else
						{
							$ListIDRow .= "		<font color=\"red\">";
							$ListIDRow .= "		<a href=\"game.php?page=buildings&amp;cmd=remove&amp;listid=". $ListID ."\">".$lang['bd_cancel']."</a></font>";
						}
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

	public function ShowBuildingsPage (&$CurrentPlanet, $CurrentUser)
	{
		global $ProdGrid, $lang, $resource, $reslist, $dpath, $game_config, $db;

		include_once(ROOT_PATH . 'includes/functions/IsTechnologieAccessible.' . PHP_EXT);
		include_once(ROOT_PATH . 'includes/functions/GetElementPrice.' . PHP_EXT);
		
		CheckPlanetUsedFields($CurrentPlanet);
		
		$PlanetRess = new ResourceUpdate($CurrentUser, $CurrentPlanet);

		
        $TheCommand   = request_var('cmd','');
        $Element      = request_var('building',0);
        $ListID       = request_var('listid',0);

		if ((IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Element) && in_array($Element, $reslist['allow'][$CurrentPlanet['planet_type']]) && ($Element == 31 && $CurrentUser["b_tech_planet"] == 0 || $Element != 31)) || $TheCommand == "cancel" || $TheCommand == "remove")
		{
			switch($TheCommand)
			{
				case 'cancel':
					$this->CancelBuildingFromQueue ($CurrentPlanet, $CurrentUser);
				break;
				case 'remove':
					$this->RemoveBuildingFromQueue ($CurrentPlanet, $CurrentUser, $ListID);
				break;
				case 'insert':
					$this->AddBuildingToQueue($CurrentPlanet, $CurrentUser, $Element, true);
				break;
				case 'destroy':
					$this->AddBuildingToQueue($CurrentPlanet, $CurrentUser, $Element, false);
				break;
			}
		}
		SetNextQueueElementOnTop($CurrentPlanet, $CurrentUser); 
		$Queue = $this->ShowBuildingQueue($CurrentPlanet, $CurrentUser);
		$this->BuildingSavePlanetRecord($CurrentPlanet);

		$template	= new template();
		$template->set_vars($CurrentUser, $CurrentPlanet);
		$template->page_header();	
		$template->page_topnav();
		$template->page_leftmenu();
		$template->page_planetmenu();
		$template->page_footer();
		
		$CanBuildElement 	= ($Queue['lenght'] < (MAX_BUILDING_QUEUE_SIZE)) ? true : false;
		$BuildingPage       = "";
		$CurrentMaxFields   = CalculateMaxPlanetFields($CurrentPlanet);
		$RoomIsOk 			= ($CurrentPlanet["field_current"] < ($CurrentMaxFields - $Queue['lenght'])) ? true : false;
				
		$BuildEnergy		= $CurrentUser[$resource[113]];
		$BuildLevelFactor   = 10;
		$BuildTemp          = $CurrentPlanet['temp_max'];
		foreach($reslist['allow'][$CurrentPlanet['planet_type']] as $ID => $Element)
		{
			if (IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Element))
			{
				$HaveRessources        	= IsElementBuyable ($CurrentUser, $CurrentPlanet, $Element, true, false);
				if(in_array($Element, $reslist['prod']))
				{
					$BuildLevel         	= $CurrentPlanet[$resource[$Element]];
					$Need 	                = floor(eval($ProdGrid[$Element]['formule']['energy']) * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_ingenieur'] * 0.05));
					$BuildLevel			   += 1;
					$Prod 	                = floor(eval($ProdGrid[$Element]['formule']['energy']) * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_ingenieur'] * 0.05));
					$EnergyNeed        		= $Prod - $Need;
				} else
					unset($EnergyNeed);
				$parse['click']        	= '';
				$NextBuildLevel        	= $CurrentPlanet[$resource[$Element]] + 1;

				if ($RoomIsOk && $CanBuildElement)
					$parse['click'] = ($HaveRessources == true) ? "<a href=\"game.php?page=buildings&amp;cmd=insert&amp;building=". $Element ."\"><font color=\"#00FF00\">".(($Queue['lenght'] != 0) ? $lang['bd_add_to_list'] : (($NextBuildLevel == 1) ? $lang['bd_build'] : $lang['bd_build_next_level'] . $NextBuildLevel))."</font></a>" : "<font color=\"#FF0000\">".(($NextBuildLevel == 1) ? $lang['bd_build'] : $lang['bd_build_next_level'] . $NextBuildLevel)."</font>";
				elseif ($RoomIsOk && !$CanBuildElement)
					$parse['click'] = "<font color=\"#FF0000\">".(($NextBuildLevel == 1) ? $lang['bd_build'] : $lang['bd_build_next_level'] . $NextBuildLevel) ."</font>";
				else
					$parse['click'] = "<font color=\"#FF0000\">".$lang['bd_no_more_fields']."</font>";

				if ($Element == 31 && $CurrentUser["b_tech_planet"] != 0)
					$parse['click'] = "<font color=\"#FF0000\">".$lang['bd_working']."</font>";
				elseif (($Element == 15 || $Element == 21) && !empty($CurrentPlanet['b_hangar_id']))
					$parse['click'] = "<font color=\"#FF0000\">".$lang['bd_working']."</font>";
				
				$BuildInfoList[]	= array(
					'id'			=> $Element,
					'name'			=> $lang['tech'][$Element],
					'descriptions'	=> $lang['res']['descriptions'][$Element],
					'level'			=> $CurrentPlanet[$resource[$Element]],
					'destroyress'	=> array_map('pretty_number', GetBuildingPrice ($CurrentUser, $CurrentPlanet, $Element, true, true)),
					'destroytime'	=> pretty_time(GetBuildingTime($CurrentUser, $CurrentPlanet, $Element, true)),
					'price'			=> GetElementPrice($CurrentUser, $CurrentPlanet, $Element, true),
					'time'        	=> pretty_time(GetBuildingTime($CurrentUser, $CurrentPlanet, $Element)),
					'EnergyNeed'	=> (isset($EnergyNeed)) ? sprintf(($EnergyNeed < 0) ? $lang['bd_need_engine'] : $lang['bd_more_engine'] , pretty_number(abs($EnergyNeed)), $lang['Energy']) : "",
					'BuildLink'		=> $parse['click'],
					'restprice'		=> $this->GetRestPrice($CurrentUser, $CurrentPlanet, $Element, true),
				);
			}
		}

		if ($Queue['lenght'] > 0)
		{
			include(ROOT_PATH . 'includes/functions/InsertBuildListScript.' . PHP_EXT);
			$template->assign_vars(array(
				'BuildListScript'  	=> InsertBuildListScript("buildings"),
				'BuildList'			=> $Queue['buildlist'],
			));
		}

		$template->assign_vars(array(
			'BuildInfoList'			=> $BuildInfoList,
			'bd_lvl'				=> $lang['bd_lvl'],
			'bd_next_level'			=> $lang['bd_next_level'],
			'Metal'					=> $lang['Metal'],
			'Crystal'				=> $lang['Crystal'],
			'Deuterium'				=> $lang['Deuterium'],
			'Darkmatter'       		=> $lang['Darkmatter'],
			'bd_dismantle'			=> $lang['bd_dismantle'],
			'fgf_time'				=> $lang['fgf_time'],
			'bd_remaining'			=> $lang['bd_remaining'],
			'bd_jump_gate_action'	=> $lang['bd_jump_gate_action'],
		));
			
		$template->show("buildings_overview.tpl");
		$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
	}
}
?>