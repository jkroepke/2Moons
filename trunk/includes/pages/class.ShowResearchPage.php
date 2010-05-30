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

class ShowResearchPage
{
	private function CheckLabSettingsInQueue()
	{
		global $PLANET;
		if ($PLANET['b_building_id'] != 0)
		{
			$CurrentQueue = $PLANET['b_building_id'];
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

	private function CheckAndGetLabLevel()
	{
		global $resource, $db, $USER, $PLANET;

		if($USER[$resource[123]] == 0)
			$lablevel = $PLANET[$resource[31]];
		else {
			$LevelRow = $db->query("SELECT ".$resource[31]." FROM ".PLANETS." WHERE `id` != '".$PLANET['id']."' AND `id_owner` = '".$USER['id']."' AND `destruyed` = 0 ORDER BY ".$resource[31]." DESC LIMIT ".($USER[$resource[123]]).";");
			$lablevel[]	= $PLANET[$resource[31]];
			while($Levels = $db->fetch_array($LevelRow))
			{
				$lablevel[]	= $Levels[$resource[31]];
			}
			$db->free_result($LevelRow);
		}
		return $lablevel;
	}
	
	private function GetRestPrice ($Element, $Factor = true)
	{
		global $USER, $PLANET, $pricelist, $resource, $LNG;

		if ($Factor)
		{
			$level = ($PLANET[$resource[$Element]]) ? $PLANET[$resource[$Element]] : $USER[$resource[$Element]];
		}

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
			if ($pricelist[$Element][$ResType] != 0)
			{
				if ($Factor)
				{
					$cost = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level));
				}
				else
				{
					$cost = floor($pricelist[$Element][$ResType]);
				}
				$restprice[$ResTitle] = pretty_number(max($cost - (($PLANET[$ResType]) ? $PLANET[$ResType] : $USER[$ResType]), 0));
			}
		}

		return $restprice;
	}

	public function ShowResearchPage ()
	{
		global $PLANET, $USER, $LNG, $resource, $reslist, $CONF, $db, $pricelist;

		include_once(ROOT_PATH . 'includes/functions/IsTechnologieAccessible.' . PHP_EXT);
		include_once(ROOT_PATH . 'includes/functions/GetElementPrice.' . PHP_EXT);
		include_once(ROOT_PATH . 'includes/functions/HandleTechnologieBuild.' . PHP_EXT);
		
		$PlanetRess = new ResourceUpdate();
		$PlanetRess->CalcResource()->SavePlanetToDB();
		
		$template	= new template();
		$template->page_header();	
		$template->page_topnav();
		$template->page_leftmenu();
		$template->page_planetmenu();
		$template->page_footer();				
		
		$IsWorking = HandleTechnologieBuild($PLANET, $USER);
		$ThePlanet	= $IsWorking['WorkOn'];
		$InResearch	= $IsWorking['OnWork'];
		
		if ($PLANET[$resource[31]] == 0)
		{
			$template->message($LNG['bd_lab_required']);
			exit;
		}
		
		$bContinue	= (!$this->CheckLabSettingsInQueue($PLANET)) ? true : false;
		
		$PLANET[$resource[31].'_inter']	= $this->CheckAndGetLabLevel($USER, $PLANET);		
		
		$TheCommand		= request_var('cmd','');
		$Techno     	= request_var('tech', 0);
							
		if (empty($USER['b_tech_planet']) && !empty($TheCommand) && !empty($Techno) && in_array($Techno, $reslist['tech']) && isset($pricelist[$Techno]['max']) && $USER[$resource[$Techno]] < $pricelist[$Techno]['max'])
		{
			$WorkingPlanet = (is_array($ThePlanet)) ? $ThePlanet : $PLANET;
			switch($TheCommand)
			{
				case 'cancel':
					if ($ThePlanet['b_tech_id'] != $Techno)
						break;
						
					$costs                        = GetBuildingPrice($USER, $WorkingPlanet, $Techno);
					$WorkingPlanet['metal']      += $costs['metal'];
					$WorkingPlanet['crystal']    += $costs['crystal'];
					$WorkingPlanet['deuterium']  += $costs['deuterium'];
					$USER['darkmatter']  		 += $costs['darkmatter'];
					$WorkingPlanet['b_tech_id']   = 0;
					$WorkingPlanet["b_tech"]      = 0;
					$USER['b_tech_planet'] 		  = 0;
					$UpdateData                   = true;
					$InResearch                   = false;
				break;
				case 'search':
					if (!IsTechnologieAccessible($USER, $WorkingPlanet, $Techno) || !IsElementBuyable($USER, $WorkingPlanet, $Techno))
						break;
						
					$costs                        = GetBuildingPrice($USER, $WorkingPlanet, $Techno);
					$WorkingPlanet['metal']      -= $costs['metal'];
					$WorkingPlanet['crystal']    -= $costs['crystal'];
					$WorkingPlanet['deuterium']  -= $costs['deuterium'];
					$USER['darkmatter']   		 -= $costs['darkmatter'];
					$WorkingPlanet["b_tech_id"]   = $Techno;
					$WorkingPlanet["b_tech"]      = TIMESTAMP + GetBuildingTime($USER, $WorkingPlanet, $Techno);
					$USER["b_tech_planet"] 		  = $WorkingPlanet["id"];
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
				$QryUpdateUser .= "`b_tech_planet` = '". $USER['b_tech_planet'] ."', ";
				$QryUpdateUser .= "`darkmatter`    = '". $USER['darkmatter']."' ";
				$QryUpdateUser .= "WHERE ";
				$QryUpdateUser .= "`id` = '".            $USER['id']            ."';";
				$db->multi_query($QryUpdateUser);
			}
			
			if (is_array($ThePlanet))
			{
				$ThePlanet     = $WorkingPlanet;
			}
			else
			{
				$PLANET = $WorkingPlanet;
				if ($TheCommand == 'search')
				{
					$ThePlanet = $PLANET;
				}
			}
		}
		
		foreach($reslist['tech'] as $ID => $Element)
		{
			if (IsTechnologieAccessible($USER, $PLANET, $Element))
			{
				$CanBeDone               = IsElementBuyable($USER, $PLANET, $Element);
		
				if(isset($pricelist[$Element]['max']) && $USER[$resource[$Element]] >= $pricelist[$Element]['max'])
				{
					$TechnoLink  =	"<font color=\"#FF0000\">".$LNG['bd_maxlevel']."</font>";
				}
				elseif (!$InResearch)
				{
					$LevelToDo = 1 + $USER[$resource[$Element]];
					if ($CanBeDone && $this->CheckLabSettingsInQueue($PLANET))
					{
						$TechnoLink = "<a href=\"game.php?page=buildings&amp;mode=research&amp;cmd=search&amp;tech=".$Element."\"><font color=\"#00FF00\">".$LNG['bd_research'].(($LevelToDo == 1) ? "" : "<br>".$LNG['bd_lvl']." ".$LevelToDo)."</font></a>";
					}
					else
					{
						$TechnoLink = "<font color=\"#FF0000\">".$LNG['bd_research'].(($LevelToDo == 1) ? "" : "<br>".$LNG['bd_lvl']." ".$LevelToDo)."</font>";
					}
				}
				else
				{
					if ($ThePlanet["b_tech_id"] == $Element)
					{
						$bloc       = $LNG;
						if ($ThePlanet['id'] != $PLANET['id'])
						{
							$template->assign_vars(array(
								'tech_time'		=> $ThePlanet["b_tech"] - TIMESTAMP,
								'tech_name'		=> $LNG['bd_on']."<br>". $ThePlanet["name"],
								'tech_home'		=> $ThePlanet["id"],
								'tech_id'		=> $ThePlanet["b_tech_id"],
								'game_name'		=> $CONF['game_name'],
								'tech_lang'		=> $LNG['tech'][$PLANET["b_tech_id"]],
								'bd_cancel'		=> $LNG['bd_cancel'],
								'bd_ready'		=> $LNG['bd_ready'],
								'bd_continue'	=> $LNG['bd_continue'],
							));
						}
						else
						{
							$template->assign_vars(array(
								'tech_time'		=> $PLANET["b_tech"] - TIMESTAMP,
								'tech_name'		=> "",
								'game_name'		=> $CONF['game_name'],
								'tech_lang'		=> $LNG['tech'][$PLANET["b_tech_id"]],
								'tech_home'		=> $PLANET["id"],
								'tech_id'		=> $PLANET["b_tech_id"],					
								'bd_cancel'		=> $LNG['bd_cancel'],
								'bd_ready'		=> $LNG['bd_ready'],
								'bd_continue'	=> $LNG['bd_continue'],
							));
						}
						$TechnoLink  = $template->fetch("buildings_research_script.tpl");
					}
					else
						$TechnoLink  = "<center>-</center>";
				}
				
				$ResearchList[] = array(
					'id'		=> $Element,
					'maxinfo'	=> (isset($pricelist[$Element]['max']) && $pricelist[$Element]['max'] != 255) ? sprintf($LNG['bd_max_lvl'], $pricelist[$Element]['max']):"",
					'name'  	=> $LNG['tech'][$Element],
					'descr'  	=> $LNG['res']['descriptions'][$Element],
					'price'  	=> GetElementPrice($USER, $PLANET, $Element),					
					'time' 		=> pretty_time(GetBuildingTime($USER, $PLANET, $Element)),
					'restprice'	=> $this->GetRestPrice($Element, true),
					'elvl'		=> ($Element == 106) ? ($USER['rpg_espion'] * ESPION)." (".$LNG['tech'][610].")" : (($Element == 108) ? ($USER['rpg_commandant'] * COMMANDANT)." (".$LNG['tech'][611].")" : false),
					'lvl'		=> $USER[$resource[$Element]],
					'link'  	=> $TechnoLink,
				);
			}
		}
		$template->assign_vars(array(
			'ResearchList'			=> $ResearchList,
			'IsLabinBuild'			=> $bContinue,
			'bd_building_lab'		=> $LNG['bd_building_lab'],
			'bd_remaining'			=> $LNG['bd_remaining'],			
			'bd_lvl'				=> $LNG['bd_lvl'],			
			'fgf_time'				=> $LNG['fgf_time'],
		));
		
		$template->show('buildings_research.tpl');
	}
}