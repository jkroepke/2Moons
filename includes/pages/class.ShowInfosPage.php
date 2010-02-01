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
							$QryUpdate .= "UPDATE ".USERS." SET ";
							$QryUpdate .= "`current_planet` = '". $TargetGate['id'] ."' ";
							$QryUpdate .= "WHERE ";
							$QryUpdate .= "`id` = '". $CurrentUser['id'] ."';";
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
		else
		{
			$RetMessage = $lang['in_jump_gate_error_data'];
		}

		return $RetMessage;
	}

	private function BuildFleetListRows ($CurrentPlanet)
	{
		global $resource, $lang;

		$RowsTPL  = gettemplate('infos/info_gate_rows');
		$CurrIdx  = 1;
		$Result   = "";
		for ($Ship = 300; $Ship > 200; $Ship-- )
		{
			if ($resource[$Ship] != "")
			{
				if ($CurrentPlanet[$resource[$Ship]] > 0)
				{
					$bloc['idx']             = $CurrIdx;
					$bloc['fleet_id']        = $Ship;
					$bloc['fleet_name']      = $lang['tech'][$Ship];
					$bloc['fleet_max']       = pretty_number ( $CurrentPlanet[$resource[$Ship]] );
					$bloc['gate_ship_dispo'] = $lang['in_jump_gate_available'];
					$Result                 .= parsetemplate ( $RowsTPL, $bloc );
					$CurrIdx++;
				}
			}
		}
		return $Result;
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

	private function ShowProductionTable ($CurrentUser, $CurrentPlanet, $BuildID, $Template)
	{
		global $ProdGrid, $resource, $game_config;

		$BuildLevelFactor = $CurrentPlanet[ $resource[$BuildID]."_porcent" ];
		$BuildTemp        = $CurrentPlanet[ 'temp_max' ];
		$CurrentBuildtLvl = $CurrentPlanet[ $resource[$BuildID] ];

		$BuildLevel       = ($CurrentBuildtLvl > 0) ? $CurrentBuildtLvl : 1;
		$Prod[1]          = (floor(eval($ProdGrid[$BuildID]['formule']['metal'])     * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_geologue']  * GEOLOGUE)));
		$Prod[2]          = (floor(eval($ProdGrid[$BuildID]['formule']['crystal'])   * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_geologue']  * GEOLOGUE)));
		$Prod[3]          = (floor(eval($ProdGrid[$BuildID]['formule']['deuterium']) * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_geologue']  * GEOLOGUE)));

		if( $BuildID >= 4 )
			$Prod[4] = (floor(eval($ProdGrid[$BuildID]['formule']['energy'])    * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_ingenieur'] * INGENIEUR)));
		else
			$Prod[4] = (floor(eval($ProdGrid[$BuildID]['formule']['energy'])    * $game_config['resource_multiplier']));

		$ActualProd       = floor($Prod[$BuildID]);

		if ($BuildID != 12)
			$ActualNeed       = floor($Prod[4]);
		else
			$ActualNeed       = floor($Prod[3]);

		$BuildStartLvl    = $CurrentBuildtLvl - 2;
		if ($BuildStartLvl < 1)
			$BuildStartLvl = 1;

		$Table     = "";
		$ProdFirst = 0;

		for ( $BuildLevel = $BuildStartLvl; $BuildLevel < $BuildStartLvl + 15; $BuildLevel++ )
		{
			if ($BuildID != 42)
			{
				$Prod[1] = (floor(eval($ProdGrid[$BuildID]['formule']['metal'])     * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_geologue']  * GEOLOGUE)));
				$Prod[2] = (floor(eval($ProdGrid[$BuildID]['formule']['crystal'])   * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_geologue']  * GEOLOGUE)));
				$Prod[3] = (floor(eval($ProdGrid[$BuildID]['formule']['deuterium']) * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_geologue']  * GEOLOGUE)));

				if( $BuildID >= 4 )
					$Prod[4] = (floor(eval($ProdGrid[$BuildID]['formule']['energy'])    * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_ingenieur'] * INGENIEUR)));
				else
					$Prod[4] = (floor(eval($ProdGrid[$BuildID]['formule']['energy'])    * $game_config['resource_multiplier']));

				$bloc['build_lvl']       = ($CurrentBuildtLvl == $BuildLevel) ? "<font color=\"#ff0000\">".$BuildLevel."</font>" : $BuildLevel;

				if ($ProdFirst > 0)
					if ($BuildID != 12)
						$bloc['build_gain']      = "<font color=\"lime\">(". pretty_number(floor($Prod[$BuildID] - $ProdFirst)) .")</font>";
					else
						$bloc['build_gain']      = "<font color=\"lime\">(". pretty_number(floor($Prod[4] - $ProdFirst)) .")</font>";
				else
					$bloc['build_gain']      = "";

				if ($BuildID != 12)
				{
					$bloc['build_prod']      = pretty_number(floor($Prod[$BuildID]));
					$bloc['build_prod_diff'] = colorNumber( pretty_number(floor($Prod[$BuildID] - $ActualProd)) );
					$bloc['build_need']      = colorNumber( pretty_number(floor($Prod[4])) );
					$bloc['build_need_diff'] = colorNumber( pretty_number(floor($Prod[4] - $ActualNeed)) );
				}
				else
				{
					$bloc['build_prod']      = pretty_number(floor($Prod[4]));
					$bloc['build_prod_diff'] = colorNumber( pretty_number(floor($Prod[4] - $ActualProd)) );
					$bloc['build_need']      = colorNumber( pretty_number(floor($Prod[3])) );
					$bloc['build_need_diff'] = colorNumber( pretty_number(floor($Prod[3] - $ActualNeed)) );
				}
				if ($ProdFirst == 0)
				{
					if ($BuildID != 12)
						$ProdFirst = floor($Prod[$BuildID]);
					else
						$ProdFirst = floor($Prod[4]);
				}
			}
			else
			{
				$bloc['build_lvl']       = ($CurrentBuildtLvl == $BuildLevel) ? "<font color=\"#ff0000\">".$BuildLevel."</font>" : $BuildLevel;
				$bloc['build_range']     = ($BuildLevel * $BuildLevel) - 1;
			}
			$Table    .= parsetemplate($Template, $bloc);
		}

		return $Table;
	}

	private function ShowRapidFireTo ($BuildID)
	{
		global $lang, $CombatCaps;
		$ResultString = "";
		for ($Type = 200; $Type < 500; $Type++)
		{
			if ($CombatCaps[$BuildID]['sd'][$Type] > 1)
				$ResultString .= $lang['in_rf_again']. " ". $lang['tech'][$Type] ." <font color=\"#00ff00\">".$CombatCaps[$BuildID]['sd'][$Type]."</font><br>";
		}
		return $ResultString;
	}

	private function ShowRapidFireFrom ($BuildID)
	{
		global $lang, $CombatCaps;

		$ResultString = "";
		for ($Type = 200; $Type < 500; $Type++)
		{
			if ($CombatCaps[$Type]['sd'][$BuildID] > 1)
				$ResultString .= $lang['in_rf_from']. " ". $lang['tech'][$Type] ." <font color=\"#ff0000\">".$CombatCaps[$Type]['sd'][$BuildID]."</font><br>";
		}
		return $ResultString;
	}

	public function ShowInfosPage ($CurrentUser, $CurrentPlanet)
	{
		global $dpath, $lang, $resource, $pricelist, $CombatCaps, $phpEx, $xgp_root;

		$BuildID 			  = request_var('gid', 0);
		$GateTPL              = '';
		$DestroyTPL           = '';
		$TableHeadTPL         = '';

		$parse                = $lang;
		$parse['dpath']       = $dpath;
		$parse['name']        = $lang['info'][$BuildID]['name'];
		$parse['image']       = $BuildID;
		$parse['description'] = $lang['info'][$BuildID]['description'];

		if ($BuildID >=   1 && $BuildID <=   3)
		{
			$PageTPL              = gettemplate('infos/info_buildings_table');
			$DestroyTPL           = gettemplate('infos/info_buildings_destroy');
			$TableHeadTPL         = "<tr><td class=\"c\">{in_level}</td><td class=\"c\">{in_prod_p_hour}</td><td class=\"c\">{in_difference}</td><td class=\"c\">{in_used_energy}</td><td class=\"c\">{in_difference}</td></tr>";
			$TableTPL             = "<tr><th>{build_lvl}</th><th>{build_prod} {build_gain}</th><th>{build_prod_diff}</th><th>{build_need}</th><th>{build_need_diff}</th></tr>";
		}
		elseif ($BuildID ==   4)
		{
			$PageTPL              = gettemplate('infos/info_buildings_table');
			$DestroyTPL           = gettemplate('infos/info_buildings_destroy');
			$TableHeadTPL         = "<tr><td class=\"c\">{in_level}</td><td class=\"c\">{in_prod_energy}</td><td class=\"c\">{in_difference}</td></tr>";
			$TableTPL             = "<tr><th>{build_lvl}</th><th>{build_prod} {build_gain}</th><th>{build_prod_diff}</th></tr>";
		}
		elseif ($BuildID ==  12)
		{
			$PageTPL              = gettemplate('infos/info_buildings_table');
			$DestroyTPL           = gettemplate('infos/info_buildings_destroy');
			$TableHeadTPL         = "<tr><td class=\"c\">{in_level}</td><td class=\"c\">{in_prod_energy}</td><td class=\"c\">{in_difference}</td><td class=\"c\">{in_used_deuter}</td><td class=\"c\">{in_difference}</td></tr>";
			$TableTPL             = "<tr><th>{build_lvl}</th><th>{build_prod} {build_gain}</th><th>{build_prod_diff}</th><th>{build_need}</th><th>{build_need_diff}</th></tr>";
		}
		elseif ($BuildID >=  14 && $BuildID <=  32)
		{
			$PageTPL              = gettemplate('infos/info_buildings_general');
			$DestroyTPL           = gettemplate('infos/info_buildings_destroy');
		}
		elseif ($BuildID ==  33)
		{
			$PageTPL              = gettemplate('infos/info_buildings_general');
		}
		elseif ($BuildID ==  34)
		{
			$PageTPL              = gettemplate('infos/info_buildings_general');
			$DestroyTPL           = gettemplate('infos/info_buildings_destroy');
		}
		elseif ($BuildID ==  44)
		{
			$PageTPL              = gettemplate('infos/info_buildings_general');
			$DestroyTPL           = gettemplate('infos/info_buildings_destroy');
		}
		elseif ($BuildID ==  41)
		{
			$PageTPL              = gettemplate('infos/info_buildings_general');
		}
		elseif ($BuildID ==  42)
		{
			$PageTPL              = gettemplate('infos/info_buildings_table');
			$TableHeadTPL         = "<tr><td class=\"c\">{in_level}</td><td class=\"c\">{in_range}</td></tr>";
			$TableTPL             = "<tr><th>{build_lvl}</th><th>{build_range}</th></tr>";
			$DestroyTPL           = gettemplate('infos/info_buildings_destroy');
		}
		elseif ($BuildID ==  43)
		{
			$PageTPL              = gettemplate('infos/info_buildings_general');
			$GateTPL              = gettemplate('infos/info_gate_table');
			$DestroyTPL           = gettemplate('infos/info_buildings_destroy');

			if($_POST)
				message($this->DoFleetJump($CurrentUser, $CurrentPlanet), "game.php?page=infos&gid=43", 2);
		}
		elseif ($BuildID >= 106 && $BuildID <= 199)
		{
			$PageTPL              = gettemplate('infos/info_buildings_general');
		}
		elseif ($BuildID >= 202 && $BuildID <= 224)
		{
			$PageTPL              = gettemplate('infos/info_buildings_fleet');
			$parse['element_typ'] = $lang['tech'][200];
			$parse['rf_info_to']  = $this->ShowRapidFireTo($BuildID);
			$parse['rf_info_fr']  = $this->ShowRapidFireFrom($BuildID);
			$parse['hull_pt']     = pretty_number ($pricelist[$BuildID]['metal'] + $pricelist[$BuildID]['crystal']);
			$parse['shield_pt']   = pretty_number ($CombatCaps[$BuildID]['shield']);
			$parse['attack_pt']   = pretty_number ($CombatCaps[$BuildID]['attack']);
			$parse['capacity_pt'] = pretty_number ($pricelist[$BuildID]['capacity']);
			$parse['base_speed']  = pretty_number ($pricelist[$BuildID]['speed']);
			$parse['base_conso']  = pretty_number ($pricelist[$BuildID]['consumption']);
			if ($BuildID == 202)
			{
				$parse['upd_speed']   = "<font color=\"yellow\">(". pretty_number ($pricelist[$BuildID]['speed2']) .")</font>";
				$parse['upd_conso']   = "<font color=\"yellow\">(". pretty_number ($pricelist[$BuildID]['consumption2']) .")</font>";
			}
			elseif ($BuildID == 211)
				$parse['upd_speed']   = "<font color=\"yellow\">(". pretty_number ($pricelist[$BuildID]['speed2']) .")</font>";
		}
		elseif ($BuildID >= 401 && $BuildID <= 411)
		{
			$PageTPL              = gettemplate('infos/info_buildings_defense');
			$parse['element_typ'] = $lang['tech'][400];

			$parse['rf_info_to']  = $this->ShowRapidFireTo ($BuildID);
			$parse['rf_info_fr']  = $this->ShowRapidFireFrom ($BuildID);
			$parse['hull_pt']     = pretty_number ($pricelist[$BuildID]['metal'] + $pricelist[$BuildID]['crystal']);
			$parse['shield_pt']   = pretty_number ($CombatCaps[$BuildID]['shield']);
			$parse['attack_pt']   = pretty_number ($CombatCaps[$BuildID]['attack']);
		}
		elseif ($BuildID >= 502 && $BuildID <= 503)
		{
			$PageTPL              = gettemplate('infos/info_buildings_defense');
			$parse['element_typ'] = $lang['tech'][400];
			$parse['hull_pt']     = pretty_number ($pricelist[$BuildID]['metal'] + $pricelist[$BuildID]['crystal']);
			$parse['shield_pt']   = pretty_number ($CombatCaps[$BuildID]['shield']);
			$parse['attack_pt']   = pretty_number ($CombatCaps[$BuildID]['attack']);
		}
		elseif ($BuildID >= 601 && $BuildID <= 615)
			$PageTPL              = gettemplate('infos/info_officiers_general');

		if ($TableHeadTPL != '')
		{
			$parse['table_head']  = parsetemplate ($TableHeadTPL, $lang);
			$parse['table_data']  = $this->ShowProductionTable ($CurrentUser, $CurrentPlanet, $BuildID, $TableTPL);
		}

		$page  = parsetemplate($PageTPL, $parse);
		if ($GateTPL != '')
		{
			if ($CurrentPlanet[$resource[$BuildID]] > 0)
			{
				$RestString               = $this->GetNextJumpWaitTime ( $CurrentPlanet );
				$parse['gate_start_link'] = BuildPlanetAdressLink ( $CurrentPlanet );
				if ($RestString['value'] != 0)
				{
					include($xgp_root . 'includes/functions/InsertJavaScriptChronoApplet.' . $phpEx);

					$parse['gate_time_script'] = InsertJavaScriptChronoApplet ( "Gate", "1", $RestString['value'], true );
					$parse['gate_wait_time']   = "<div id=\"bxx". "Gate" . "1" ."\"></div>";
					$parse['gate_script_go']   = InsertJavaScriptChronoApplet ( "Gate", "1", $RestString['value'], false );
				}
				else
				{
					$parse['gate_time_script'] = "";
					$parse['gate_wait_time']   = "";
					$parse['gate_script_go']   = "";
				}
				$parse['gate_dest_moons'] = $this->BuildJumpableMoonCombo ($CurrentUser, $CurrentPlanet);
				$parse['gate_fleet_rows'] = $this->BuildFleetListRows ($CurrentPlanet);
				$page .= parsetemplate($GateTPL, $parse);
			}
		}

		if ($DestroyTPL != '')
		{
			if ($CurrentPlanet[$resource[$BuildID]] > 0)
			{
				$NeededRessources     = GetBuildingPrice ($CurrentUser, $CurrentPlanet, $BuildID, true, true);
				$DestroyTime          = GetBuildingTime  ($CurrentUser, $CurrentPlanet, $BuildID) / 2;
				$parse['destroyurl']  = "game.php?page=buildings&cmd=destroy&building=".$BuildID;
				$parse['levelvalue']  = $CurrentPlanet[$resource[$BuildID]];
				$parse['nfo_metal']   = $lang['Metal'];
				$parse['nfo_crysta']  = $lang['Crystal'];
				$parse['nfo_deuter']  = $lang['Deuterium'];
				$parse['metal']       = pretty_number ($NeededRessources['metal']);
				$parse['crystal']     = pretty_number ($NeededRessources['crystal']);
				$parse['deuterium']   = pretty_number ($NeededRessources['deuterium']);
				$parse['destroytime'] = pretty_time   ($DestroyTime);
				$page .= parsetemplate($DestroyTPL, $parse);
			}
		}
		return display($page, false, '', false, false);
	}
}
?>