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

class ShowResearchPage
{
	private function CheckLabSettingsInQueue ($CurrentPlanet)
	{
		if ($CurrentPlanet['b_building_id'] != 0)
		{
			$CurrentQueue = $CurrentPlanet['b_building_id'];
			if (strpos ($CurrentQueue, ";"))
			{
				// FIX BY LUCKY - IF THE LAB IS IN QUEUE THE USER CANT RESEARCH ANYTHING...
				$QueueArray		= explode (";", $CurrentQueue);

				for($i = 0; $i < MAX_BUILDING_QUEUE_SIZE; $i++)
				{
					$ListIDArray	= explode (",", $QueueArray[$i]);
					$Element		= $ListIDArray[0];

					if($Element == 31)
						break;
				}
				// END - FIX
			}
			else
			{
				$CurrentBuilding = $CurrentQueue;
			}

			if ($CurrentBuilding == 31 or $Element == 31) // ADDED (or $Element == 31) BY LUCKY
			{
				$return = false;
			}
			else
			{
				$return = true;
			}
		}
		else
		{
			$return = true;
		}

		return $return;
	}

	private function CheckAndGetLabLevel($user, $planet){
		
		global $resource, $db;

		if($user[$resource[123]] == 0)
			$lablevel = $planet[$resource[31]];
		else {
			$LevelRow = $db->query("SELECT ".$resource[31]." FROM ".PLANETS." WHERE `id_owner` = '".$user['id']."' ORDER BY ".$resource[31]." DESC limit ".($user[$resource[123]] + 1).";");
			while($Levels = $db->fetch_array($LevelRow))
			{
			$lablevel[]	= $Levels[$resource[31]];
			}
		}
		return $lablevel;
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
		'energy_max' => $lang['Energy']
		);

		$text  = $lang['bd_remaining'];
		foreach ($array as $ResType => $ResTitle)
		{
			if ($pricelist[$Element][$ResType] != 0)
			{
				$text .= "<br>".$ResTitle . ": <b>";
				if ($userfactor)
				{
					$cost = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level));
				}
				else
				{
					$cost = floor($pricelist[$Element][$ResType]);
				}
				$text .= pretty_number(max($cost - $planet[$ResType],0))."</b>";
			}
		}
		$text .= "";

		return $text;
	}

	public function ShowResearchPage (&$CurrentPlanet, $CurrentUser, $InResearch, $ThePlanet)
	{
		global $lang, $resource, $reslist, $phpEx, $dpath, $game_config, $db, $pricelist;

		include_once($xgp_root . 'includes/functions/IsTechnologieAccessible.' . $phpEx);
		include_once($xgp_root . 'includes/functions/GetElementPrice.' . $phpEx);

		$PageParse			= $lang;
		$NoResearchMessage 	= "";
		$bContinue         	= true;

			
		if ($CurrentPlanet[$resource[31]] == 0)
			message($lang['bd_lab_required'], '', '', true);

		$CurrentPlanet[$resource[31]]	= $this->CheckAndGetLabLevel($CurrentUser, $CurrentPlanet);
				
		if (!$this->CheckLabSettingsInQueue ($CurrentPlanet))
		{
			$NoResearchMessage = $lang['bd_building_lab'];
			$bContinue         = false;
		}
		$TheCommand			= request_var('cmd','');				
		if (!empty($TheCommand))
		{
			$Techno     	= request_var('tech', 0);
			if (!empty($Techno) && in_array($Techno, $reslist['tech']) && isset($pricelist[$Techno]['max']) && $CurrentUser[$resource[$Techno]] < $pricelist[$Techno]['max'])
			{
				$WorkingPlanet = (is_array($ThePlanet)) ? $ThePlanet : $CurrentPlanet;
				switch($TheCommand)
				{
					case 'cancel':
						if ($ThePlanet['b_tech_id'] == $Techno)
						{
							$costs                        = GetBuildingPrice($CurrentUser, $WorkingPlanet, $Techno);
							$WorkingPlanet['metal']      += $costs['metal'];
							$WorkingPlanet['crystal']    += $costs['crystal'];
							$WorkingPlanet['deuterium']  += $costs['deuterium'];
							$WorkingPlanet['b_tech_id']   = 0;
							$WorkingPlanet["b_tech"]      = 0;
							$CurrentUser['b_tech_planet'] = $WorkingPlanet["id"];
							$UpdateData                   = true;
							$InResearch                   = false;
						}
					break;
					case 'search':
						if (IsTechnologieAccessible($CurrentUser, $WorkingPlanet, $Techno) && IsElementBuyable($CurrentUser, $WorkingPlanet, $Techno))
						{
							$costs                        = GetBuildingPrice($CurrentUser, $WorkingPlanet, $Techno);
							$WorkingPlanet['metal']      -= $costs['metal'];
							$WorkingPlanet['crystal']    -= $costs['crystal'];
							$WorkingPlanet['deuterium']  -= $costs['deuterium'];
							$WorkingPlanet["b_tech_id"]   = $Techno;
							$WorkingPlanet["b_tech"]      = time() + GetBuildingTime($CurrentUser, $WorkingPlanet, $Techno);
							$CurrentUser["b_tech_planet"] = $WorkingPlanet["id"];
							$UpdateData                   = true;
							$InResearch                   = true;
						}
					break;
					default:
						exit(header("Location: game.".$phpEx."?page=buildings&amp;mode=research"));
					break;
				}
				if ($UpdateData == true)
				{
					$QryUpdateUser  = "UPDATE ".PLANETS." SET ";
					$QryUpdateUser .= "`b_tech_id` = '".   $WorkingPlanet['b_tech_id']   ."', ";
					$QryUpdateUser .= "`b_tech` = '".      $WorkingPlanet['b_tech']      ."', ";
					$QryUpdateUser .= "`metal` = '".       $WorkingPlanet['metal']       ."', ";
					$QryUpdateUser .= "`crystal` = '".     $WorkingPlanet['crystal']     ."', ";
					$QryUpdateUser .= "`deuterium` = '".   $WorkingPlanet['deuterium']   ."' ";
					$QryUpdateUser .= "WHERE ";
					$QryUpdateUser .= "`id` = '".          $WorkingPlanet['id']          ."';";
					$QryUpdateUser .= "UPDATE ".USERS." SET ";
					$QryUpdateUser .= "`b_tech_planet` = '". $CurrentUser['b_tech_planet'] ."' ";
					$QryUpdateUser .= "WHERE ";
					$QryUpdateUser .= "`id` = '".            $CurrentUser['id']            ."';";
					$db->multi_query($QryUpdateUser);
				}

				$CurrentPlanet = $WorkingPlanet;
				if (is_array($ThePlanet))
				{
					$ThePlanet     = $WorkingPlanet;
				}
				else
				{
					$CurrentPlanet = $WorkingPlanet;
					if ($TheCommand == 'search')
					{
						$ThePlanet = $CurrentPlanet;
					}
				}
			}
			else
			{
				exit(header("location:game.php?page=buildings&mode=research"));
			}
		}

		$TechRowTPL = gettemplate('buildings/buildings_research_row');
		$TechScrTPL = gettemplate('buildings/buildings_research_script');
		
		foreach($reslist['tech'] as $ID => $Element)
		{
			if (IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Element))
			{
				$parse                	 = $lang;
				$parse['dpath']       	 = $dpath;
				$parse['name']        	 = $lang['tech'][$Element];
				$parse['image']       	 = $Element;
				$parse['description'] 	 = $lang['res']['descriptions'][$Element];
				$infodiv 				.= parsetemplate(gettemplate('buildings/buildings_research_info_row'), $parse);
				$RowParse['dpath']       = $dpath;
				$RowParse['tech_id']     = $Element;
				$CurrentLevel        	 = $CurrentUser[$resource[$Element]];

				if($Element == 106)
				{
					$RowParse['tech_level']  = ($CurrentLevel == 0) ? "" : " (". $lang['bd_lvl'] . " ".$CurrentLevel .")" ;
					$RowParse['tech_level']  .= ($CurrentUser['rpg_espion'] == 0) ? "" : "<strong><font color=\"lime\"> +" . ($CurrentUser['rpg_espion'] * ESPION) . $lang['bd_spy']	. "</font></strong>";
				}
				elseif($Element == 108)
				{
					$RowParse['tech_level']  = ($CurrentLevel == 0) ? "" : " (". $lang['bd_lvl'] . " ".$CurrentLevel .")";
					$RowParse['tech_level']  .= ($CurrentUser['rpg_commandant'] == 0) ? "" : "<strong><font color=\"lime\"> +" . ($CurrentUser['rpg_commandant'] * COMMANDANT) . $lang['bd_commander'] . "</font></strong>";
				}
				else
					$RowParse['tech_level']  = ($CurrentLevel == 0) ? "" : " (". $lang['bd_lvl'] . " ".$CurrentLevel.")";
					
				$RowParse['tech_level']	.= (isset($pricelist[$Element]['max']) && $pricelist[$Element]['max'] != 255) ? " (Max. Level: ".$pricelist[$Element]['max'].")":"";
				$RowParse['tech_name']   = $lang['tech'][$Element];
				$RowParse['tech_descr']  = $lang['res']['descriptions'][$Element];
				$RowParse['tech_price']  = GetElementPrice($CurrentUser, $CurrentPlanet, $Element);
				$SearchTime              = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
				$RowParse['search_time'] = ShowBuildTime($SearchTime);
				$RowParse['tech_restp']  = $this->GetRestPrice ($CurrentUser, $CurrentPlanet, $Element, true);
				$CanBeDone               = IsElementBuyable($CurrentUser, $CurrentPlanet, $Element);
		
				if(isset($pricelist[$Element]['max']) && $CurrentUser[$resource[$Element]] >= $pricelist[$Element]['max'])
				{
					$TechnoLink  =	"<font color=#FF0000>".$lang['bd_maxlevel']."</font>";
				}
				elseif (!$InResearch)
				{
					$LevelToDo = 1 + $CurrentUser[$resource[$Element]];
					if ($CanBeDone && $this->CheckLabSettingsInQueue($CurrentPlanet))
					{
						$TechnoLink = "<a href=\"game.php?page=buildings&mode=research&cmd=search&tech=".$Element."\"><font color=#00FF00>".$lang['bd_research'].(($LevelToDo == 1) ? "" : "<br>".$lang['bd_lvl']." ".$LevelToDo)."</font></a>";
					}
					else
					{
						$TechnoLink = "<font color=#FF0000>".$lang['bd_research'].(($LevelToDo == 1) ? "" : "<br>".$lang['bd_lvl']." ".$LevelToDo)."</font>";
					}
				}
				else
				{
					if ($ThePlanet["b_tech_id"] == $Element)
					{
						$bloc       = $lang;
						if ($ThePlanet['id'] != $CurrentPlanet['id'])
						{
							$bloc['tech_time']  = $ThePlanet["b_tech"] - time();
							$bloc['tech_name']  = $lang['bd_on']."<br>". $ThePlanet["name"];
							$bloc['tech_home']  = $ThePlanet["id"];
							$bloc['tech_id']    = $ThePlanet["b_tech_id"];
							$bloc['game_name']  = $game_config['game_name'];
							$bloc['tech_lang']  = $lang['tech'][$CurrentPlanet["b_tech_id"]];
						}
						else
						{
							$bloc['tech_time']  = $CurrentPlanet["b_tech"] - time();
							$bloc['tech_name']  = "";
							$bloc['game_name']  = $game_config['game_name'];
							$bloc['tech_lang']  = $lang['tech'][$CurrentPlanet["b_tech_id"]];
							$bloc['tech_home']  = $CurrentPlanet["id"];
							$bloc['tech_id']    = $CurrentPlanet["b_tech_id"];
						}
						$TechnoLink  = parsetemplate($TechScrTPL, $bloc);
					}
					else
					{
						$TechnoLink  = "<center>-</center>";
					}
				}
				$RowParse['tech_link']  = $TechnoLink;
				$TechnoList            .= parsetemplate($TechRowTPL, $RowParse);
			}
		}
		$PageParse['infodiv']	  = $infodiv;
		$PageParse['noresearch']  = $NoResearchMessage;
		$PageParse['technolist']  = $TechnoList;
		$Page                    .= parsetemplate(gettemplate('buildings/buildings_research'), $PageParse);

		display($Page);
	}
}