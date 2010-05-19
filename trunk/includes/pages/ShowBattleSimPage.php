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


function ShowBattleSimPage($CurrentUser, $CurrentPlanet)
{
	global $reslist, $pricelist, $lang, $db;
	
	$action			= request_var('action', '');
	$Slots			= request_var('slots', 1);

	if(isset($_REQUEST['im']))
	{
		$Array		= $_REQUEST['im'];
		foreach($Array as $ID => $Count)
		{
			$BattleArray[0][1][$ID]	= $Count;
		}
	}
	else
		$BattleArray	= $_REQUEST['battleinput'];		

	if($action == 'send')
	{
		foreach($BattleArray as $BattleSlotID => $BattleSlot)
		{
			if(isset($BattleSlot[0]) && (array_sum($BattleSlot[0]) > 0 || $BattleSlotID == 0))
			{
				$Att	= mt_rand(1, 1000);
				$attack[$Att]['fleet'] 		= array('fleet_start_galaxy' => 1, 'fleet_start_system' => 33, 'fleet_start_planet' => 7, 'fleet_end_galaxy' => 1, 'fleet_end_system' => 33, 'fleet_end_planet' => 7, 'metal' => 0, 'crystal' => 0, 'deuterium' => 0);
				$attack[$Att]['user'] 		= array('username'	=> $lang['bs_atter'].' Nr.'.($BattleSlotID+1), 'military_tech' => $BattleSlot[0][109], 'defence_tech' => $BattleSlot[0][110], 'shield_tech' => $BattleSlot[0][111], 0, 'dm_defensive' => 0, 'dm_attack' => 0);

				foreach($BattleSlot[0] as $ID => $Count)
				{
					if(!in_array($ID, $reslist['fleet']) || $BattleSlot[0][$ID] <= 0)
						unset($BattleSlot[0][$ID]);
				}
					
				$attack[$Att]['detail'] 	= $BattleSlot[0];
			}
				
			if(isset($BattleSlot[1]) && (array_sum($BattleSlot[1]) > 0 || $BattleSlotID == 0))
			{
				$Def	= mt_rand(1 ,1000);
				
				$defense[$Def]['fleet'] 	= array('fleet_start_galaxy' => 1, 'fleet_start_system' => 33, 'fleet_start_planet' => 7, 'fleet_end_galaxy' => 1, 'fleet_end_system' => 33, 'fleet_end_planet' => 7, 'metal' => 0, 'crystal' => 0, 'deuterium' => 0);
				$defense[$Def]['user'] 		= array('username'	=> $lang['bs_deffer'].' Nr.'.($BattleSlotID+1), 'military_tech' => $BattleSlot[1][109], 'defence_tech' => $BattleSlot[1][110], 'shield_tech' => $BattleSlot[1][111], 0, 'dm_defensive' => 0, 'dm_attack' => 0);

				foreach($BattleSlot[1] as $ID => $Count)
				{
					if(!in_array($ID, $reslist['fleet']) && !in_array($ID, $reslist['defense']))
						unset($BattleSlot[1][$ID]);
				}
					
				$defense[$Def]['def']	 	= $BattleSlot[1];
			}
		}
			
		require_once(ROOT_PATH.'includes/classes/class.FlyingFleetMissions.'.PHP_EXT);
		$start 				= microtime(true);
		$result 			= FlyingFleetMissions::calculateAttack($attack, $defense);
		$totaltime 			= microtime(true) - $start;
		$steal				= FlyingFleetMissions::calculateAKSSteal($attack, NULL, array('metal' => $BattleArray[0][1][1], 'crystal' => $BattleArray[0][1][2], 'deuterium' => $BattleArray[0][1][3]), true);
		$FleetDebris      	= $result['debree']['att'][0] + $result['debree']['def'][0] + $result['debree']['att'][1] + $result['debree']['def'][1];
		$StrAttackerUnits 	= sprintf($lang['sys_attacker_lostunits'], $result['lost']['att']);
		$StrDefenderUnits 	= sprintf($lang['sys_defender_lostunits'], $result['lost']['def']);
		$StrRuins         	= sprintf($lang['sys_gcdrunits'], $result['debree']['def'][0] + $result['debree']['att'][0], $lang['Metal'], $result['debree']['def'][1] + $result['debree']['att'][1], $lang['Crystal']);
		$DebrisField      	= $StrAttackerUnits ."<br>". $StrDefenderUnits ."<br>". $StrRuins;
		$MoonChance       	= min(round($FleetDebris / 100000,0),20);
		$UserChance 	 	= mt_rand(1, 100);
		$ChanceMoon 		= sprintf($lang['sys_moonproba'], $MoonChance);
		$AllSteal			= array_sum($steal);
		
		if ($UserChance <= $MoonChance)
			$GottenMoon       = sprintf($lang['sys_moonbuilt'], $lang['fl_moon'], 1, 33, 7)."<br>";
		
		$RaportInfo			= sprintf($lang['bs_derbis_raport'], 
		ceil($FleetDebris / $pricelist[219]['capacity']), $lang['tech'][219],
		ceil($FleetDebris / $pricelist[209]['capacity']), $lang['tech'][209])."<br>";
		$RaportInfo			.= sprintf($lang['bs_steal_raport'], 
		ceil($AllSteal / $pricelist[202]['capacity']), $lang['tech'][202], 
		ceil($AllSteal / $pricelist[203]['capacity']), $lang['tech'][203], 
		ceil($AllSteal / $pricelist[217]['capacity']), $lang['tech'][217])."<br>";
		
		$formatted_cr 		= FlyingFleetMissions::GenerateReport($result, $steal, $MoonChance, $GottenMoon, $totaltime, array('fleet_start_time' => time()), '', $RaportInfo);

		$raport 			= $formatted_cr['html'];
		$rid   				= md5($raport);
		
		$SQLQuery  = "INSERT INTO ".RW." SET ";
		$SQLQuery .= "`time` = '".time()."', ";
		$SQLQuery .= "`owners` = '".$CurrentUser['id'].",0', ";
		$SQLQuery .= "`rid` = '".$rid."', ";
		$SQLQuery .= "`a_zestrzelona` = '".count($result['rounds'])."', ";
		$SQLQuery .= "`raport` = '".$db->sql_escape($raport)."';";
		$db->query($SQLQuery);
		echo($rid);
		exit;
	}
		
	foreach($reslist['fleet'] as $ID)
	{
		$GetFleet[$ID]	= $lang['tech'][$ID];
	}
	
	foreach($reslist['defense'] as $ID)
	{
		if($ID >= 501) break;
		
		$GetDef[$ID]	= $lang['tech'][$ID];
	}

	$PlanetRess = new ResourceUpdate($CurrentUser, $CurrentPlanet);
	$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
    
	$template	= new template();
	
	$template->assign_vars(array(
		'lm_battlesim'	=> $lang['lm_battlesim'],
		'bs_names'		=> $lang['bs_names'],
		'bs_atter'		=> $lang['bs_atter'],
		'bs_deffer'		=> $lang['bs_deffer'],
		'bs_steal'		=> $lang['bs_steal'],
		'bs_techno'		=> $lang['bs_techno'],
		'bs_send'		=> $lang['bs_send'],
		'bs_cancel'		=> $lang['bs_cancel'],
		'bs_wait'		=> $lang['bs_wait'],
		'Metal'			=> $lang['Metal'],
		'Crystal'		=> $lang['Crystal'],
		'Deuterium'		=> $lang['Deuterium'],
		'attack_tech'	=> $lang['tech'][109],
		'shield_tech'	=> $lang['tech'][110],
		'tank_tech'		=> $lang['tech'][111],
		'GetFleet'		=> $GetFleet,
		'GetDef'		=> $GetDef,
		'Slots'			=> $Slots,
		'battleinput'	=> $BattleArray,
	));
			
			
	$template->set_vars($CurrentUser, $CurrentPlanet);
	$template->page_header();
	$template->page_topnav();
	$template->page_leftmenu();
	$template->page_planetmenu();
	$template->page_footer();
	$template->show("battlesim.tpl");   
}

?>