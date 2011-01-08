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


function ShowBattleSimPage()
{
	global $USER, $PLANET, $reslist, $pricelist, $LNG, $db, $ExtraDM, $LANG;
	
	$action			= request_var('action', '');
	$Slots			= request_var('slots', 1);

	if(isset($_REQUEST['im']))
	{
		$Array		= $_REQUEST['im'];
		foreach($Array as $ID => $Count)
		{
			$BattleArray[0][1][$ID]	= $Count;
		}
	} elseif(isset($_REQUEST['battleinput'])) {
		$BattleArray	= $_REQUEST['battleinput'];
	} else {
		$BattleArray	= array();
	}
	if($action == 'send')
	{
		$Counts	= array(0, 0);
		foreach($BattleArray as $BattleSlotID => $BattleSlot)
		{
			if(isset($BattleSlot[0]) && (array_sum($BattleSlot[0]) > 0 || $BattleSlotID == 0))
			{
				$Att	= mt_rand(1, 1000);
				$attack[$Att]['fleet'] 		= array('fleet_start_galaxy' => 1, 'fleet_start_system' => 33, 'fleet_start_planet' => 7, 'fleet_end_galaxy' => 1, 'fleet_end_system' => 33, 'fleet_end_planet' => 7, 'metal' => 0, 'crystal' => 0, 'deuterium' => 0);
				$attack[$Att]['user'] 		= array('username'	=> $LNG['bs_atter'].' Nr.'.($BattleSlotID+1), 'military_tech' => $BattleSlot[0][109], 'defence_tech' => $BattleSlot[0][110], 'shield_tech' => $BattleSlot[0][111], 0, 'dm_defensive' => 0, 'dm_attack' => 0);

				foreach($BattleSlot[0] as $ID => $Count)
				{
					if(!in_array($ID, $reslist['fleet']) || $BattleSlot[0][$ID] <= 0)
						unset($BattleSlot[0][$ID]);
				}
				
				if($Counts[0] == 0 && $BattleSlotID != 0)
					exit('ERROR');
					
				$Counts[0]					= $Counts[0] + array_sum($BattleSlot[1]);
				$attack[$Att]['detail'] 	= $BattleSlot[0];
			}
				
			if(isset($BattleSlot[1]) && (array_sum($BattleSlot[1]) > 0 || $BattleSlotID == 0))
			{
				$Def	= mt_rand(1 ,1000);
				
				$defense[$Def]['fleet'] 	= array('fleet_start_galaxy' => 1, 'fleet_start_system' => 33, 'fleet_start_planet' => 7, 'fleet_end_galaxy' => 1, 'fleet_end_system' => 33, 'fleet_end_planet' => 7, 'metal' => 0, 'crystal' => 0, 'deuterium' => 0);
				$defense[$Def]['user'] 		= array('username'	=> $LNG['bs_deffer'].' Nr.'.($BattleSlotID+1), 'military_tech' => $BattleSlot[1][109], 'defence_tech' => $BattleSlot[1][110], 'shield_tech' => $BattleSlot[1][111], 0, 'dm_defensive' => 0, 'dm_attack' => 0);

				foreach($BattleSlot[1] as $ID => $Count)
				{
					if(!in_array($ID, $reslist['fleet']) && !in_array($ID, $reslist['defense']))
						unset($BattleSlot[1][$ID]);
				}

				if($Countd[1] == 0 && $BattleSlotID != 0)
					exit('ERROR');

				$Countd[1]					= $Countd[1] + array_sum($BattleSlot[1]);
				
				$defense[$Def]['def']	 	= $BattleSlot[1];
			}
		}
		
		$LANG->includeLang(array('FLEET'));
		require_once(ROOT_PATH.'includes/classes/missions/calculateAttack.'.PHP_EXT);
		require_once(ROOT_PATH.'includes/classes/missions/calculateSteal.'.PHP_EXT);
		require_once(ROOT_PATH.'includes/classes/missions/GenerateReport.'.PHP_EXT);
		$start 				= microtime(true);
		$result 			= calculateAttack($attack, $defense);
		$totaltime 			= microtime(true) - $start;
		
		$steal = $result['won'] == "a" ? calculateSteal($attack, array('metal' => $BattleArray[0][1][1], 'crystal' => $BattleArray[0][1][2], 'deuterium' => $BattleArray[0][1][3]), true) : array('metal' => 0, 'crystal' => 0, 'deuterium' => 0);
		
		$FleetDebris      	= $result['debree']['att'][0] + $result['debree']['def'][0] + $result['debree']['att'][1] + $result['debree']['def'][1];
		$StrAttackerUnits 	= sprintf($LNG['sys_attacker_lostunits'], $result['lost']['att']);
		$StrDefenderUnits 	= sprintf($LNG['sys_defender_lostunits'], $result['lost']['def']);
		$StrRuins         	= sprintf($LNG['sys_gcdrunits'], $result['debree']['def'][0] + $result['debree']['att'][0], $LNG['Metal'], $result['debree']['def'][1] + $result['debree']['att'][1], $LNG['Crystal']);
		$DebrisField      	= $StrAttackerUnits ."<br>". $StrDefenderUnits ."<br>". $StrRuins;
		$MoonChance       	= min(round($FleetDebris / 100000, 0), 20);
		$AllSteal			= array_sum($steal);
		
		$RaportInfo			= sprintf($LNG['bs_derbis_raport'], 
		ceil($FleetDebris / $pricelist[219]['capacity']), $LNG['tech'][219],
		ceil($FleetDebris / $pricelist[209]['capacity']), $LNG['tech'][209])."<br>";
		$RaportInfo			.= sprintf($LNG['bs_steal_raport'], 
		ceil($AllSteal / $pricelist[202]['capacity']), $LNG['tech'][202], 
		ceil($AllSteal / $pricelist[203]['capacity']), $LNG['tech'][203], 
		ceil($AllSteal / $pricelist[217]['capacity']), $LNG['tech'][217])."<br>";
		$INFO['moon']['battlesim']	= $RaportInfo;
		$INFO['steal']				= $steal;
		$INFO['fleet_start_time']	= TIMESTAMP;
		$INFO['moon']['des']		= 0;
		$INFO['moon']['chance'] 	= $MoonChance;
		$raport 			= GenerateReport($result, $INFO);

		$rid   				= md5(microtime(true));
		
		file_put_contents(ROOT_PATH.'raports/raport_'.$rid.'.php', '<?php'."\n".'$raport = '.$raport.';'."\n".'?>');
			
		$SQLQuery  = "INSERT INTO ".RW." SET ";
		$SQLQuery .= "`time` = '".TIMESTAMP."', ";
		$SQLQuery .= "`owners` = '".$USER['id'].",0', ";
		$SQLQuery .= "`rid` = '".$rid."';";
		$db->query($SQLQuery);
		echo($rid);
		exit;
	}

	$PlanetRess = new ResourceUpdate();
	$PlanetRess->CalcResource();
	$PlanetRess->SavePlanetToDB();
		
	foreach($reslist['fleet'] as $ID)
	{
		$GetFleet[$ID]	= $LNG['tech'][$ID];
	}
	
	foreach($reslist['defense'] as $ID)
	{
		if($ID >= 501) break;
		
		$GetDef[$ID]	= $LNG['tech'][$ID];
	}

	$template	= new template();			
	$template->loadscript('battlesim.js');
	
	$template->assign_vars(array(
		'lm_battlesim'	=> $LNG['lm_battlesim'],
		'bs_names'		=> $LNG['bs_names'],
		'bs_atter'		=> $LNG['bs_atter'],
		'bs_deffer'		=> $LNG['bs_deffer'],
		'bs_steal'		=> $LNG['bs_steal'],
		'bs_techno'		=> $LNG['bs_techno'],
		'bs_send'		=> $LNG['bs_send'],
		'bs_cancel'		=> $LNG['bs_cancel'],
		'bs_wait'		=> $LNG['bs_wait'],
		'Metal'			=> $LNG['Metal'],
		'Crystal'		=> $LNG['Crystal'],
		'Deuterium'		=> $LNG['Deuterium'],
		'attack_tech'	=> $LNG['tech'][109],
		'shield_tech'	=> $LNG['tech'][110],
		'tank_tech'		=> $LNG['tech'][111],
		'GetFleet'		=> $GetFleet,
		'GetDef'		=> $GetDef,
		'Slots'			=> $Slots,
		'battleinput'	=> $BattleArray,
	));
			
	$template->show("battlesim.tpl");   
}

?>