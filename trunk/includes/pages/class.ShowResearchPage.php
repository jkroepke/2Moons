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



class ShowResearchPage
{
	private function CheckLabSettingsInQueue()
	{
		global $PLANET;
		if ($PLANET['b_building_id'] == 0)
			return true;
			
		$QueueArray		= explode (";", $PLANET['b_building_id']);

		for($i = 0; $i < MAX_BUILDING_QUEUE_SIZE; $i++)	{
			$ListIDArray	= explode (",", $QueueArray[$i]);
			if($ListIDArray[0] == 6 || $ListIDArray[0] == 31)
				return false;
		}

		return true;
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

	public function __construct()
	{
		global $PLANET, $USER, $LNG, $resource, $reslist, $CONF, $db, $pricelist, $OfficerInfo;

		include_once(ROOT_PATH . 'includes/functions/IsTechnologieAccessible.' . PHP_EXT);
		include_once(ROOT_PATH . 'includes/functions/GetElementPrice.' . PHP_EXT);
		
		$template	= new template();			
		
		if ($PLANET[$resource[31]] == 0)
		{
			$template->message($LNG['bd_lab_required']);
			exit;
		}
		
		$bContinue		= $this->CheckLabSettingsInQueue($PLANET) ? true : false;
		
		$PLANET[$resource[31].'_inter']	= $this->CheckAndGetLabLevel($USER, $PLANET);		
		
		$TheCommand		= request_var('cmd','');
		$Element     	= request_var('tech', 0);
		$PlanetRess 	= new ResourceUpdate();
		if ($USER['urlaubs_modus'] == 0 && !empty($TheCommand) && $bContinue)
		{
			switch($TheCommand)
			{
				case 'cancel':
					if (empty($USER['b_tech']))
						break;

					$costs						= GetBuildingPrice($USER, $PLANET, $USER['b_tech_id']);
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
				break;
				case 'search':
					if (!empty($USER['b_tech']) || empty($Element) || !in_array($Element, $reslist['tech']) || $USER[$resource[$Element]] >= $pricelist[$Element]['max'] || !IsTechnologieAccessible($USER, $PLANET, $Element) || !IsElementBuyable($USER, $PLANET, $Element))
						break;
						
					$costs						= GetBuildingPrice($USER, $PLANET, $Element);
					$PLANET['metal']      		-= $costs['metal'];
					$PLANET['crystal']    		-= $costs['crystal'];
					$PLANET['deuterium'] 		-= $costs['deuterium'];
					$USER['darkmatter']			-= $costs['darkmatter'];
					$USER['b_tech_id']			= $Element;
					$USER['b_tech']      		= TIMESTAMP + GetBuildingTime($USER, $PLANET, $Element);
					$USER['b_tech_planet']		= $PLANET['id'];
				break;
			}
		}
		
		$PlanetRess->CalcResource();
		$PlanetRess->SavePlanetToDB();
		$ScriptInfo	= array();
	
		foreach($reslist['tech'] as $ID => $Element)
		{
			if (IsTechnologieAccessible($USER, $PLANET, $Element))
			{
				$CanBeDone               = IsElementBuyable($USER, $PLANET, $Element);
		
				if(isset($pricelist[$Element]['max']) && $USER[$resource[$Element]] >= $pricelist[$Element]['max'])
				{
					$TechnoLink  =	"<font color=\"#FF0000\">".$LNG['bd_maxlevel']."</font>";
				}
				elseif ($USER['b_tech_id'] == 0)
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
					if ($USER['b_tech_id'] == $Element)
					{
						if ($USER['b_tech_planet'] == $PLANET['id'])
						{
							$template->loadscript('research.js');
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
							$THEPLANET	= $db->uniquequery("SELECT `name` FROM ".PLANETS." WHERE `id` = '".$USER['b_tech_planet']."';");
							$template->loadscript('research.js');
							$ScriptInfo	= array(
								'tech_time'		=> $USER['b_tech'],
								'tech_name'		=> $LNG['bd_on'].'<br>'.$THEPLANET['name'],
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
				);
			}
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