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

class ShowInfosPage
{
	private function GetNextJumpWaitTime($CurMoon)
	{
		global $resource;

		$JumpGateLevel  = $CurMoon[$resource[43]];
		$LastJumpTime   = $CurMoon['last_jump_time'];
		if ($JumpGateLevel > 0)
		{
			$WaitBetweenJmp = (60 * 60) * (1 / $JumpGateLevel);
			$NextJumpTime   = $LastJumpTime + $WaitBetweenJmp;
			if ($NextJumpTime >= time())
			{
				$RestWait   = $NextJumpTime - time();
				$RestString = " ". pretty_time($RestWait);
			}
			else
			{
				$RestWait   = 0;
				$RestString = "";
			}
		}
		else
		{
			$RestWait   = 0;
			$RestString = "";
		}
		$RetValue['string'] = $RestString;
		$RetValue['value']  = $RestWait;

		return $RetValue;
	}

	private function DoFleetJump ($CurrentUser, $CurrentPlanet)
	{
		global $resource, $lang, $db;

		if ($_POST)
		{
			$RestString   = $this->GetNextJumpWaitTime ($CurrentPlanet);
			$NextJumpTime = $RestString['value'];
			$JumpTime     = time();

			if ( $NextJumpTime == 0 )
			{
				$TargetPlanet = request_var('jmpto',0);
				$TargetGate   = $db->fetch_array($db->query("SELECT `id`, `sprungtor`, `last_jump_time` FROM ".PLANETS." WHERE `id` = '". $db->sql_escape($TargetPlanet) ."';"));

				if ($TargetGate['sprungtor'] > 0)
				{
					$RestString   = $this->GetNextJumpWaitTime ( $TargetGate );
					$NextDestTime = $RestString['value'];

					if ( $NextDestTime == 0 )
					{
						$ShipArray   = array();
						$SubQueryOri = "";
						$SubQueryDes = "";

						for ( $Ship = 200; $Ship < 300; $Ship++ )
						{
							$ShipLabel = "c". $Ship;

							$gemi_kontrol	=	abs(intval($_POST[ $ShipLabel ]));

							if ( $gemi_kontrol > $CurrentPlanet[ $resource[ $Ship ] ] && ctype_digit($_POST[ $ShipLabel ]))
							{
								$ShipArray[ $Ship ] = $CurrentPlanet[ $resource[ $Ship ] ];
							}
							else
							{
								$ShipArray[ $Ship ] = $gemi_kontrol;
							}

							if ($ShipArray[ $Ship ] <> 0)
							{
								$SubQueryOri .= "`". $resource[ $Ship ] ."` = `". $resource[ $Ship ] ."` - '". $ShipArray[ $Ship ] ."', ";
								$SubQueryDes .= "`". $resource[ $Ship ] ."` = `". $resource[ $Ship ] ."` + '". $ShipArray[ $Ship ] ."', ";
							}
						}

						if ($SubQueryOri != "")
						{
							$QryUpdate  = "UPDATE ".PLANETS." SET ";
							$QryUpdate .= $SubQueryOri;
							$QryUpdate .= "`last_jump_time` = '". $JumpTime ."' ";
							$QryUpdate .= "WHERE ";
							$QryUpdate .= "`id` = '". $CurrentPlanet['id'] ."';";
							$QryUpdate .= "UPDATE ".PLANETS." SET ";
							$QryUpdate .= $SubQueryDes;
							$QryUpdate .= "`last_jump_time` = '". $JumpTime ."' ";
							$QryUpdate .= "WHERE ";
							$QryUpdate .= "`id` = '". $TargetGate['id'] ."';";
							$db->multi_query($QryUpdate);

							$CurrentPlanet['last_jump_time'] = $JumpTime;
							$RestString    = $this->GetNextJumpWaitTime ( $CurrentPlanet );
							$RetMessage    = $lang['in_jump_gate_done'] . $RestString['string'];
						}
						else
						{
							$RetMessage = $lang['in_jump_gate_error_data'];
						}
					}
					else
					{
						$RetMessage = $lang['in_jump_gate_not_ready_target'] . $RestString['string'];
					}
				}
				else
				{
					$RetMessage = $lang['in_jump_gate_doesnt_have_one'];
				}
			}
			else
			{
				$RetMessage = $lang['in_jump_gate_already_used'] . $RestString['string'];
			}
		}

		return $RetMessage;
	}

	private function BuildFleetListRows ($CurrentPlanet)
	{
		global $reslist, $resource, $lang;

		foreach($reslist['fleet'] as $Ship)
		{
			if ($CurrentPlanet[$resource[$Ship]] > 0)
			{
				$GateFleetList[]	= array(
					'id'        => $Ship,
					'name'      => $lang['tech'][$Ship],
					'max'       => pretty_number($CurrentPlanet[$resource[$Ship]]),
				);
			}
		}
		
		return $GateFleetList;
	}

	private function BuildJumpableMoonCombo ( $CurrentUser, $CurrentPlanet )
	{
		global $resource, $db;
		$QrySelectMoons  = "SELECT ".$resource[43].", id, galaxy, system, planet FROM ".PLANETS." WHERE `planet_type` = '3' AND `id_owner` = '". $CurrentUser['id'] ."';";
		$MoonList        = $db->query ( $QrySelectMoons);
		$Combo           = "";
		while ( $CurMoon = $db->fetch($MoonList) )
		{
			if ( $CurMoon['id'] != $CurrentPlanet['id'] )
			{
				$RestString = $this->GetNextJumpWaitTime ( $CurMoon );
				if ($CurMoon[$resource[43]] >= 1)
					$Combo .= "<option value=\"". $CurMoon['id'] ."\">[". $CurMoon['galaxy'] .":". $CurMoon['system'] .":". $CurMoon['planet'] ."] ". $CurMoon['name'] . $RestString['string'] ."</option>\n";
			}
		}
		return $Combo;
	}

	public function ShowInfosPage ($CurrentUser, $CurrentPlanet)
	{
		global $dpath, $lang, $resource, $pricelist, $reslist, $CombatCaps, $phpEx, $ProdGrid, $xgp_root, $game_config;

		$BuildID 	= request_var('gid', 0);
		
		$template	= new template();

		$template->page_header();
		$template->page_footer();
	
		if(in_array($BuildID, $reslist['prod']) && $BuildID != 212)
		{
			$BuildLevelFactor	= 10;
			$BuildTemp       	= $CurrentPlanet['temp_max'];
			$CurrentBuildtLvl	= $CurrentPlanet[$resource[$BuildID]];
			$BuildEnergy		= $CurrentUser[$resource[113]];
			$BuildLevel     	= ($CurrentBuildtLvl > 0) ? $CurrentBuildtLvl : 1;
			$Prod[1]         	= (floor(eval($ProdGrid[$BuildID]['formule']['metal'])     * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_geologue']  * GEOLOGUE)));
			$Prod[2]         	= (floor(eval($ProdGrid[$BuildID]['formule']['crystal'])   * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_geologue']  * GEOLOGUE)));
			$Prod[3]          	= (floor(eval($ProdGrid[$BuildID]['formule']['deuterium']) * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_geologue']  * GEOLOGUE)));
			$BuildStartLvl   	= max($CurrentBuildtLvl - 2, 1);

			if( $BuildID >= 4 )
				$Prod[4] = (floor(eval($ProdGrid[$BuildID]['formule']['energy'])    * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_ingenieur'] * INGENIEUR)));
			else
				$Prod[4] = (floor(eval($ProdGrid[$BuildID]['formule']['energy'])    * $game_config['resource_multiplier']));

			$ActualProd       = floor($Prod[$BuildID]);

			if ($BuildID != 12)
				$ActualNeed       = floor($Prod[4]);
			else
				$ActualNeed       = floor($Prod[3]);

			$ProdFirst = 0;
			
			for($BuildLevel = $BuildStartLvl; $BuildLevel < $BuildStartLvl + 15; $BuildLevel++ )
			{
				$Prod[1] = floor(eval($ProdGrid[$BuildID]['formule']['metal'])     * $game_config['resource_multiplier']);
				$Prod[2] = floor(eval($ProdGrid[$BuildID]['formule']['crystal'])   * $game_config['resource_multiplier']);
				$Prod[3] = floor(eval($ProdGrid[$BuildID]['formule']['deuterium']) * $game_config['resource_multiplier']);

				if($BuildID >= 4)
					$Prod[4] = floor(eval($ProdGrid[$BuildID]['formule']['energy'])    * $game_config['resource_multiplier']);
				else
					$Prod[4] = floor(eval($ProdGrid[$BuildID]['formule']['energy'])    * $game_config['resource_multiplier']);
				
				$bloc['build_lvl']       = ($CurrentBuildtLvl == $BuildLevel) ? "<font color=\"#ff0000\">".$BuildLevel."</font>" : $BuildLevel;

				if ($BuildID != 12)
				{
					$prod      = pretty_number(floor($Prod[$BuildID]));
					$prod_diff = colorNumber( pretty_number(floor($Prod[$BuildID] - $ActualProd)) );
					$need      = colorNumber( pretty_number(floor($Prod[4])) );
					$need_diff = colorNumber( pretty_number(floor($Prod[4] - $ActualNeed)) );
				}
				else
				{
					$prod      = pretty_number(floor($Prod[4]));
					$prod_diff = colorNumber( pretty_number(floor($Prod[4] - $ActualProd)) );
					$need      = colorNumber( pretty_number(floor($Prod[3])) );
					$need_diff = colorNumber( pretty_number(floor($Prod[3] - $ActualNeed)) );
				}
				if ($ProdFirst == 0)
				{
					if ($BuildID != 12)
						$ProdFirst = floor($Prod[$BuildID]);
					else
						$ProdFirst = floor($Prod[4]);
				}					
				
				$ProductionTable[] = array(
					'BuildLevel'		=> $BuildLevel,
					'prod'	     		=> $prod,
					'prod_diff'			=> $prod_diff,
					'need'				=> $need,
					'need_diff'			=> $need_diff,
				);
			}
		}
		elseif(in_array($BuildID, $reslist['fleet']))
		{
			for ($Type = 200; $Type < 500; $Type++)
			{
				if ($CombatCaps[$BuildID]['sd'][$Type] > 1)
					$RapidFire['to'][$lang['tech'][$Type]] = $CombatCaps[$BuildID]['sd'][$Type];
					
				if ($CombatCaps[$Type]['sd'][$BuildID] > 1)
					$RapidFire['from'][$lang['tech'][$Type]] = $CombatCaps[$Type]['sd'][$BuildID];
			}

			$FleetInfo[$lang['in_struct_pt']]		= pretty_number($pricelist[$BuildID]['metal'] + $pricelist[$BuildID]['crystal']);
			$FleetInfo[$lang['in_shield_pt']]		= pretty_number($CombatCaps[$BuildID]['shield']);
			$FleetInfo[$lang['in_attack_pt']]		= pretty_number($CombatCaps[$BuildID]['attack']);
			$FleetInfo[$lang['in_capacity']]		= pretty_number($pricelist[$BuildID]['capacity']);
			$FleetInfo[$lang['in_base_speed']][]	= pretty_number($pricelist[$BuildID]['speed']);
			$FleetInfo[$lang['in_consumption']][]	= pretty_number($pricelist[$BuildID]['consumption']);
			$FleetInfo[$lang['in_base_speed']][]	= pretty_number($pricelist[$BuildID]['speed2']);
			$FleetInfo[$lang['in_consumption']][]	= pretty_number($pricelist[$BuildID]['consumption2']);
		}
		elseif (in_array($BuildID, $reslist['defense']))
		{
			for ($Type = 200; $Type < 500; $Type++)
			{
				if ($CombatCaps[$BuildID]['sd'][$Type] > 1)
					$RapidFire['to'][$lang['tech'][$Type]] = $CombatCaps[$BuildID]['sd'][$Type];
					
				if ($CombatCaps[$Type]['sd'][$BuildID] > 1)
					$RapidFire['from'][$lang['tech'][$Type]] = $CombatCaps[$Type]['sd'][$BuildID];
			}

			$FleetInfo[$lang['in_struct_pt']]		= pretty_number($pricelist[$BuildID]['metal'] + $pricelist[$BuildID]['crystal']);
			$FleetInfo[$lang['in_shield_pt']]		= pretty_number($CombatCaps[$BuildID]['shield']);
			$FleetInfo[$lang['in_attack_pt']]		= pretty_number($CombatCaps[$BuildID]['attack']);
		}
		elseif($BuildID == 43 && $CurrentPlanet[$resource[43]] > 0)
		{
			$GateFleetList['jump']			= $this->DoFleetJump($CurrentUser, $CurrentPlanet);
			$RestString               		= $this->GetNextJumpWaitTime ( $CurrentPlanet );
			if ($RestString['value'] != 0)
			{
				include_once($xgp_root . 'includes/functions/InsertJavaScriptChronoApplet.' . $phpEx);
				$template->assign_vars(array(
					'gate_time_script'	=> InsertJavaScriptChronoApplet("Gate", "1", $RestString['value'], true),
					'gate_script_go'	=> InsertJavaScriptChronoApplet("Gate", "1", $RestString['value'], false),
				));
			}
			
			$GateFleetList['start_link']	= BuildPlanetAdressLink($CurrentPlanet);
			$GateFleetList['moons']			= $this->BuildJumpableMoonCombo($CurrentUser, $CurrentPlanet);
			$GateFleetList['fleets']		= $this->BuildFleetListRows($CurrentPlanet);
		}
		$template->assign_vars(array(		
			'id'							=> $BuildID,
			'name'							=> $lang['info'][$BuildID]['name'],
			'image'							=> $BuildID,
			'description'					=> $lang['info'][$BuildID]['description'],
			'ProductionTable'				=> $ProductionTable,
			'RapidFire'						=> $RapidFire,
			'Level'							=> $CurrentBuildtLvl,
			'FleetInfo'						=> $FleetInfo,
			'GateFleetList'					=> $GateFleetList,
			'in_jump_gate_jump' 			=> $lang['in_jump_gate_jump'],
			'gate_ship_dispo' 				=> $lang['in_jump_gate_available'],
			'in_level'						=> $lang['in_level'],
			'in_prod_p_hour'				=> $lang['in_prod_p_hour'],
			'in_difference'					=> $lang['in_difference'],
			'in_used_energy'				=> $lang['in_used_energy'],
			'in_prod_energy'				=> $lang['in_prod_energy'],
			'in_used_deuter'				=> $lang['in_used_deuter'],
			'in_rf_again'					=> $lang['in_rf_again'],
			'in_rf_from'					=> $lang['in_rf_from'],
			'in_jump_gate_select_ships'		=> $lang['in_jump_gate_select_ships'],
			'in_jump_gate_start_moon'		=> $lang['in_jump_gate_start_moon'],
			'in_jump_gate_finish_moon'		=> $lang['in_jump_gate_finish_moon'],
			'in_jump_gate_wait_time'		=> $lang['in_jump_gate_wait_time'],
		));
		
		$template->show('info_overview.tpl');
	}
}
?>