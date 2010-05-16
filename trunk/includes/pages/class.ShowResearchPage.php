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
			$LevelRow = $db->query("SELECT ".$resource[31]." FROM ".PLANETS." WHERE `id` != '".$planet['id']."' AND `id_owner` = '".$user['id']."' AND `destruyed` = 0 ORDER BY ".$resource[31]." DESC LIMIT ".($user[$resource[123]]).";");
			$lablevel[]	= $planet[$resource[31]];
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

	public function ShowResearchPage ($CurrentPlanet, $CurrentUser)
	{
		global $lang, $resource, $reslist, $dpath, $game_config, $db, $pricelist;

		include_once(ROOT_PATH . 'includes/functions/IsTechnologieAccessible.' . PHP_EXT);
		include_once(ROOT_PATH . 'includes/functions/GetElementPrice.' . PHP_EXT);
		include_once(ROOT_PATH . 'includes/functions/HandleTechnologieBuild.' . PHP_EXT);
		
		$PlanetRess = new ResourceUpdate($CurrentUser, $CurrentPlanet);
		$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
		
		$template	= new template();
		$template->page_header();	
		$template->page_topnav();
		$template->page_leftmenu();
		$template->page_planetmenu();
		$template->page_footer();				
		
		$template->set_vars($CurrentUser, $CurrentPlanet);
		$IsWorking = HandleTechnologieBuild($CurrentPlanet, $CurrentUser);
		$ThePlanet	= $IsWorking['WorkOn'];
		$InResearch	= $IsWorking['OnWork'];
		
		if ($CurrentPlanet[$resource[31]] == 0)
		{
			$template->message($lang['bd_lab_required']);
			exit;
		}
		
		$bContinue	= (!$this->CheckLabSettingsInQueue($CurrentPlanet)) ? true : false;
		
		$Level									= $CurrentPlanet[$resource[31]];
		$CurrentPlanet[$resource[31].'_inter']	= $this->CheckAndGetLabLevel($CurrentUser, $CurrentPlanet);		
		
		$TheCommand		= request_var('cmd','');
		$Techno     	= request_var('tech', 0);
							
		if (!empty($TheCommand) && !empty($Techno) && in_array($Techno, $reslist['tech']) && isset($pricelist[$Techno]['max']) && $CurrentUser[$resource[$Techno]] < $pricelist[$Techno]['max'])
		{
			$WorkingPlanet = (is_array($ThePlanet)) ? $ThePlanet : $CurrentPlanet;
			switch($TheCommand)
			{
				case 'cancel':
					if ($ThePlanet['b_tech_id'] != $Techno)
						break;
						
					$costs                        = GetBuildingPrice($CurrentUser, $WorkingPlanet, $Techno);
					$WorkingPlanet['metal']      += $costs['metal'];
					$WorkingPlanet['crystal']    += $costs['crystal'];
					$WorkingPlanet['deuterium']  += $costs['deuterium'];
					$CurrentUser['darkmatter']   += $costs['darkmatter'];
					$WorkingPlanet['b_tech_id']   = 0;
					$WorkingPlanet["b_tech"]      = 0;
					$CurrentUser['b_tech_planet'] = 0;
					$UpdateData                   = true;
					$InResearch                   = false;
				break;
				case 'search':
					if (!IsTechnologieAccessible($CurrentUser, $WorkingPlanet, $Techno) || !IsElementBuyable($CurrentUser, $WorkingPlanet, $Techno))
						break;
						
					$costs                        = GetBuildingPrice($CurrentUser, $WorkingPlanet, $Techno);
					$WorkingPlanet['metal']      -= $costs['metal'];
					$WorkingPlanet['crystal']    -= $costs['crystal'];
					$WorkingPlanet['deuterium']  -= $costs['deuterium'];
					$CurrentUser['darkmatter']   -= $costs['darkmatter'];
					$WorkingPlanet["b_tech_id"]   = $Techno;
					$WorkingPlanet["b_tech"]      = time() + GetBuildingTime($CurrentUser, $WorkingPlanet, $Techno);
					$CurrentUser["b_tech_planet"] = $WorkingPlanet["id"];
					$UpdateData                   = true;
					$InResearch                   = true;
				break;
				default:
					$UpdateData == false;
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
				$QryUpdateUser .= "`id` = '".$WorkingPlanet["id"]."';";
				$QryUpdateUser .= "UPDATE ".USERS." SET ";
				$QryUpdateUser .= "`b_tech_planet` = '". $CurrentUser['b_tech_planet'] ."' ";
				$QryUpdateUser .= "WHERE ";
				$QryUpdateUser .= "`id` = '".            $CurrentUser['id']            ."';";
				$db->multi_query($QryUpdateUser);
			}
				
			$template->set_vars($CurrentUser, $CurrentPlanet);
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
		
		foreach($reslist['tech'] as $ID => $Element)
		{
			if (IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Element))
			{
				$CanBeDone               = IsElementBuyable($CurrentUser, $CurrentPlanet, $Element);
		
				if(isset($pricelist[$Element]['max']) && $CurrentUser[$resource[$Element]] >= $pricelist[$Element]['max'])
				{
					$TechnoLink  =	"<font color=\"#FF0000\">".$lang['bd_maxlevel']."</font>";
				}
				elseif (!$InResearch)
				{
					$LevelToDo = 1 + $CurrentUser[$resource[$Element]];
					if ($CanBeDone && $this->CheckLabSettingsInQueue($CurrentPlanet))
					{
						$TechnoLink = "<a href=\"game.php?page=buildings&amp;mode=research&amp;cmd=search&amp;tech=".$Element."\"><font color=\"#00FF00\">".$lang['bd_research'].(($LevelToDo == 1) ? "" : "<br>".$lang['bd_lvl']." ".$LevelToDo)."</font></a>";
					}
					else
					{
						$TechnoLink = "<font color=\"#FF0000\">".$lang['bd_research'].(($LevelToDo == 1) ? "" : "<br>".$lang['bd_lvl']." ".$LevelToDo)."</font>";
					}
				}
				else
				{
					if ($ThePlanet["b_tech_id"] == $Element)
					{
						$bloc       = $lang;
						if ($ThePlanet['id'] != $CurrentPlanet['id'])
						{
							$template->assign_vars(array(
								'tech_time'		=> $ThePlanet["b_tech"] - time(),
								'tech_name'		=> $lang['bd_on']."<br>". $ThePlanet["name"],
								'tech_home'		=> $ThePlanet["id"],
								'tech_id'		=> $ThePlanet["b_tech_id"],
								'game_name'		=> $game_config['game_name'],
								'tech_lang'		=> $lang['tech'][$CurrentPlanet["b_tech_id"]],
								'bd_cancel'		=> $lang['bd_cancel'],
								'bd_ready'		=> $lang['bd_ready'],
								'bd_continue'	=> $lang['bd_continue'],
							));
						}
						else
						{
							$template->assign_vars(array(
								'tech_time'		=> $CurrentPlanet["b_tech"] - time(),
								'tech_name'		=> "",
								'game_name'		=> $game_config['game_name'],
								'tech_lang'		=> $lang['tech'][$CurrentPlanet["b_tech_id"]],
								'tech_home'		=> $CurrentPlanet["id"],
								'tech_id'		=> $CurrentPlanet["b_tech_id"],					
								'bd_cancel'		=> $lang['bd_cancel'],
								'bd_ready'		=> $lang['bd_ready'],
								'bd_continue'	=> $lang['bd_continue'],
							));
						}
						$TechnoLink  = $template->fetch("buildings_research_script.tpl");
					}
					else
						$TechnoLink  = "<center>-</center>";
				}
				
				$ResearchList[] = array(
					'id'		=> $Element,
					'maxinfo'	=> (isset($pricelist[$Element]['max']) && $pricelist[$Element]['max'] != 255) ? sprintf($lang['bd_max_lvl'], $pricelist[$Element]['max']):"",
					'name'  	=> $lang['tech'][$Element],
					'descr'  	=> $lang['res']['descriptions'][$Element],
					'price'  	=> GetElementPrice($CurrentUser, $CurrentPlanet, $Element),					
					'time' 		=> pretty_time(GetBuildingTime($CurrentUser, $CurrentPlanet, $Element)),
					'restprice'	=> $this->GetRestPrice($CurrentUser, $CurrentPlanet, $Element, true),
					'elvl'		=> ($Element == 106) ? ($CurrentUser['rpg_espion'] * ESPION)." (".$lang['tech'][610].")" : (($Element == 108) ? ($CurrentUser['rpg_commandant'] * COMMANDANT)." (".$lang['tech'][611].")" : false),
					'lvl'		=> $CurrentUser[$resource[$Element]],
					'link'  	=> $TechnoLink,
				);
			}
		}
		$template->assign_vars(array(
			'ResearchList'			=> $ResearchList,
			'IsLabinBuild'			=> $bContinue,
			'bd_building_lab'		=> $lang['bd_building_lab'],
			'bd_remaining'			=> $lang['bd_remaining'],			
			'bd_lvl'				=> $lang['bd_lvl'],			
			'fgf_time'				=> $lang['fgf_time'],
		));
		
		$template->show('buildings_research.tpl');
	}
}