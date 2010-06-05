<?php

##############################################################################
# *                                                                          #
# * 2MOONS                                                                   #
# *                                                                          #
# * @copyright Copyright (C) 2010 By ShadoX from titanspace.org              #
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

class MissionCaseAttack extends MissionFunctions
{
	function __construct($Fleet)
	{
		$this->_fleet	= $Fleet;
	}
	
	function TargetEvent()
	{	
		global $pricelist, $resource, $reslist, $db;
		$LNG			= $this->GetUserLang(0);
		
		$targetPlanet 	= $db->uniquequery("SELECT * FROM ".PLANETS." WHERE `galaxy` = ". $this->_fleet['fleet_end_galaxy'] ." AND `system` = ". $this->_fleet['fleet_end_system'] ." AND `planet_type` = ". $this->_fleet['fleet_end_type'] ." AND `planet` = ". $this->_fleet['fleet_end_planet'] .";");
		$targetUser   	= $db->uniquequery("SELECT * FROM ".USERS." WHERE id = '".$targetPlanet['id_owner']."';");
				
		require_once(ROOT_PATH.'includes/classes/class.PlanetRessUpdate.'.PHP_EXT);
		
		$PlanetRess = new ResourceUpdate();
		list($TargetUser, $targetPlanet)	= $PlanetRess->CalcResource($TargetUser, $targetPlanet)->SavePlanetToDB($TargetUser, $targetPlanet);

		$TargetUserID	= $targetUser['id'];
		$attackFleets	= array();
		$AttackerRow['id']		= array();
		$AttackerRow['name']	= array();
		$DefenderRow['id']		= array();
		$DefenderRow['name']	= array();

		if ($this->_fleet['fleet_group'] != 0)
		{
			$db->query("DELETE FROM ".AKS." WHERE `id` = '".$this->_fleet['fleet_group']."';");
			$fleets = $db->query("SELECT * FROM ".FLEETS." WHERE fleet_group = '".$this->_fleet['fleet_group']."';");
			while ($fleet = $db->fetch_array($fleets))
			{
				$attackFleets[$fleet['fleet_id']]['fleet'] 	= $fleet;
				$attackFleets[$fleet['fleet_id']]['user'] 	= $db->uniquequery("SELECT id,username,military_tech,defence_tech,shield_tech,rpg_amiral,dm_defensive,dm_attack FROM ".USERS." WHERE `id` = '".$fleet['fleet_owner']."';");
				$attackFleets[$fleet['fleet_id']]['detail'] = array();
				$temp = explode(';', $fleet['fleet_array']);
				foreach ($temp as $temp2)
				{
					$temp2 = explode(',', $temp2);
					if ($temp2[0] < 100) continue;

					if (!isset($attackFleets[$fleet['fleet_id']]['detail'][$temp2[0]]))
						$attackFleets[$fleet['fleet_id']]['detail'][$temp2[0]] = 0;

					$attackFleets[$fleet['fleet_id']]['detail'][$temp2[0]] += $temp2[1];
				}
				$AttackerRow['id'][] 	= $attackFleets[$fleet['fleet_id']]['user']['id'];
				$AttackerRow['name'][]	= $attackFleets[$fleet['fleet_id']]['user']['username'];
			}
		}
		else
		{
			$attackFleets[$this->_fleet['fleet_id']]['fleet'] = $this->_fleet;
			$attackFleets[$this->_fleet['fleet_id']]['user'] = $db->uniquequery("SELECT id,username,military_tech,defence_tech,shield_tech,rpg_amiral,dm_defensive,dm_attack FROM ".USERS." WHERE id = '".$this->_fleet['fleet_owner']."';");
			$attackFleets[$this->_fleet['fleet_id']]['detail'] = array();
			$temp = explode(';', $this->_fleet['fleet_array']);
			foreach ($temp as $temp2)
			{
				$temp2 = explode(',', $temp2);
				if ($temp2[0] < 100) continue;

				if (!isset($attackFleets[$this->_fleet['fleet_id']]['detail'][$temp2[0]]))
					$attackFleets[$this->_fleet['fleet_id']]['detail'][$temp2[0]] = 0;

				$attackFleets[$this->_fleet['fleet_id']]['detail'][$temp2[0]] += $temp2[1];
			}
			$AttackerRow['id'][] 	= $attackFleets[$this->_fleet['fleet_id']]['user']['id'];
			$AttackerRow['name'][]	= $attackFleets[$this->_fleet['fleet_id']]['user']['username'];
		}

		$defense = array();

		$def = $db->query("SELECT * FROM ".FLEETS." WHERE `fleet_mission` = '5' AND `fleet_end_galaxy` = '". $this->_fleet['fleet_end_galaxy']."' AND `fleet_end_system` = '".$this->_fleet['fleet_end_system']."' AND `fleet_end_type` = '".$this->_fleet['fleet_end_type']."' AND `fleet_end_planet` = '".$this->_fleet['fleet_end_planet']."' AND fleet_start_time <= '".TIMESTAMP."' AND fleet_end_stay >= '".TIMESTAMP."';");
		while ($defRow = $db->fetch_array($def))
		{
			$defense[$defRow['fleet_id']]['user'] = $db->uniquequery("SELECT id,username,military_tech,defence_tech,shield_tech,rpg_amiral,dm_defensive,dm_attack FROM ".USERS." WHERE id = '".$defRow['fleet_owner']."';");
			$defRowDef = explode(';', $defRow['fleet_array']);
			foreach ($defRowDef as $Element)
			{
				$Element = explode(',', $Element);

				if ($Element[0] < 100) continue;

				if (!isset($defense[$defRow['fleet_id']]['def'][$Element[0]]))
					$defense[$defRow['fleet_id']][$Element[0]] = 0;

				$defense[$defRow['fleet_id']]['def'][$Element[0]] += $Element[1];
			}
			$DefenderRow['id'][] 	= $defense[$defRow['fleet_id']]['user']['id'];
			$DefenderRow['name'][]	= $defense[$defRow['fleet_id']]['user']['username'];
		}

		$defense[0]['def'] 		= array();
		$defense[0]['user'] 	= $targetUser;
		$DefenderRow['id'][] 	= $defense[0]['user']['id'];
		$DefenderRow['name'][]	= $defense[0]['user']['username'];
		
		foreach(array_merge($reslist['defense'], $reslist['fleet']) as $ID)
		{
			if ($ID > 500)
				break;

			$defense[0]['def'][$ID] = $targetPlanet[$resource[$ID]];
		}

		$Attacker['id']		= array_unique($AttackerRow['id']);
		$Attacker['name']	= array_unique($AttackerRow['name']);
		$Defender['id']		= array_unique($DefenderRow['id']);
		$Defender['name']	= array_unique($DefenderRow['name']);

		require_once('calculateAttack.'.PHP_EXT);

		$start 		= microtime(true);
		$result 	= calculateAttack($attackFleets, $defense);
		$totaltime 	= microtime(true) - $start;
			
		foreach ($attackFleets as $fleetID => $attacker)
		{
			$fleetArray = '';
			$totalCount = 0;
			foreach ($attacker['detail'] as $element => $amount)
			{
				if ($amount)
					$fleetArray .= $element.','.$amount.';';

				$totalCount += $amount;
			
				if ($totalCount <= 0)
					$SQL	.= "DELETE FROM ".FLEETS." WHERE `fleet_id`= '".$fleetID."';";
				else
					$SQL	.= "UPDATE ".FLEETS." SET `fleet_array` = '".substr($fleetArray, 0, -1)."', `fleet_amount` = '".$totalCount."', `fleet_mess` = '1' WHERE `fleet_id` = '".$fleetID."';";
			}
		}	
		
		if ($result['won'] == "a")
		{
			require_once('calculateSteal.'.PHP_EXT);
			$steal = calculateSteal($attackFleets, $targetPlanet);
		}
			
		foreach ($defense as $fleetID => $defender)
		{
			if ($fleetID != 0)
			{
				$fleetArray = '';
				$totalCount = 0;

				foreach ($defender['def'] as $element => $amount)
				{
					if ($amount) $fleetArray .= $element.','.$amount.';';
						$totalCount += $amount;
				}

				if ($totalCount <= 0)
					$SQL	.= "DELETE FROM ".FLEETS." WHERE `fleet_id`= '".$fleetID."';";
				else
					$SQL	.= "UPDATE ".FLEETS." SET `fleet_array` = '".substr($fleetArray, 0, -1)."', `fleet_amount` = '".$totalCount."' WHERE `fleet_id` = '".$fleetID."';";
			}
			else
			{
				$fleetArray = '';
				$totalCount = 0;

				foreach ($defender['def'] as $element => $amount)
				{
					$fleetArray .= "`".$resource[$element]."` = '".$amount."', ";
				}

				$SQL .= "UPDATE ".PLANETS." SET ";
				$SQL .= $fleetArray;
				$SQL .= "`metal` = `metal` - '". $steal['metal'] ."',
						 `crystal` = `crystal` - '". $steal['crystal'] ."',
						 `deuterium` = `deuterium` - '". $steal['deuterium'] ."'
						 WHERE
						 `galaxy` = '". $this->_fleet['fleet_end_galaxy'] ."' AND
						 `system` = '". $this->_fleet['fleet_end_system'] ."' AND
						 `planet` = '". $this->_fleet['fleet_end_planet'] ."' AND
						 `planet_type` = '". $this->_fleet['fleet_end_type'] ."'
						 LIMIT 1;";
			}
		}
		
		$db->multi_query($SQL);

		$FleetDebris      	= $result['debree']['att'][0] + $result['debree']['def'][0] + $result['debree']['att'][1] + $result['debree']['def'][1];
		$StrAttackerUnits 	= sprintf($LNG['sys_attacker_lostunits'], $result['lost']['att']);
		$StrDefenderUnits 	= sprintf($LNG['sys_defender_lostunits'], $result['lost']['def']);
		$StrRuins         	= sprintf($LNG['sys_gcdrunits'], $result['debree']['def'][0] + $result['debree']['att'][0], $LNG['Metal'], $result['debree']['def'][1] + $result['debree']['att'][1], $LNG['Crystal']);
		$DebrisField      	= $StrAttackerUnits ."<br>". $StrDefenderUnits ."<br>". $StrRuins;
		$MoonChance       	= min(round($FleetDebris / 100000 * MOON_CHANCE_FACTOR ,0), 20);

		$UserChance 		= ($MoonChance != 0) ? mt_rand(1, 100) : 0;
			
		$ChanceMoon			= sprintf ($LNG['sys_moonproba'], $MoonChance);

		if (($UserChance > 0) && ($UserChance <= $MoonChance) && ($targetPlanet['id_luna'] == 0) && ($targetPlanet['planet_type'] == 1))
		{		
			require_once(ROOT_PATH.'includes/functions/CreateOneMoonRecord.'.PHP_EXT);
			$TargetPlanetName = CreateOneMoonRecord($this->_fleet['fleet_end_galaxy'], $this->_fleet['fleet_end_system'], $this->_fleet['fleet_end_planet'], $TargetUserID, $this->_fleet['fleet_start_time'], '', $MoonChance );
			$GottenMoon       = sprintf($LNG['sys_moonbuilt'], $TargetPlanetName, $this->_fleet['fleet_end_galaxy'], $this->_fleet['fleet_end_system'], $this->_fleet['fleet_end_planet']);
			$GottenMoon 	 .= "<br>";
			if(DESTROY_DERBIS_MOON_CREATE) {
				$DerbisMetal	  = 0;
				$DerbisCrystal	  = 0;
			} else {
				$DerbisMetal	  = bcadd($targetPlanet['der_metal'], bcadd($result['debree']['att'][0], $result['debree']['def'][0]));
				$DerbisCrystal	  = bcadd($targetPlanet['der_crystal'], bcadd($result['debree']['att'][1], $result['debree']['def'][1]));				
			}
		}
		else
		{
			$GottenMoon 	  = "";
			$DerbisMetal	  = bcadd($targetPlanet['der_metal'], bcadd($result['debree']['att'][0], $result['debree']['def'][0]));
			$DerbisCrystal	  = bcadd($targetPlanet['der_crystal'], bcadd($result['debree']['att'][1], $result['debree']['def'][1]));
		}

							
		$Qry = "UPDATE ".PLANETS." SET ";
		$Qry .= "`der_metal` = '".$DerbisMetal."', ";
		$Qry .= "`der_crystal` = '".$DerbisCrystal."' ";
		$Qry .= "WHERE ";
		$Qry .= "`galaxy` = '" . $this->_fleet['fleet_end_galaxy'] . "' AND ";
		$Qry .= "`system` = '" . $this->_fleet['fleet_end_system'] . "' AND ";
		$Qry .= "`planet` = '" . $this->_fleet['fleet_end_planet'] . "' AND ";
		$Qry .= "`planet_type` = '1' ";
		$Qry .= "LIMIT 1;";
		$db->query($Qry);

		require_once('GenerateReport.'.PHP_EXT);
		$raport 		  = GenerateReport($result, $steal, $MoonChance,$GottenMoon, $totaltime, $this->_fleet, $LNG);
			
		$WhereAtt = "";
		$WhereDef = "";
			
		foreach($Attacker['id'] as $id)
		{
			$WhereAtt .= "`id` = '".$id."' OR ";
		}
		foreach($Defender['id'] as $id)
		{
			$WhereDef .= "`id` = '".$id."' OR ";
		}

		$Won = 0;
		$Lose = 0; 
		$Draw = 0;
		switch($result['won'])
		{
			case "a":
				$Won = 1;
			break;
			case "w":
				$Draw = 1;
			break;
			case "r":
				$Lose = 1;
			break;
		}
		
		$rid	= md5(microtime(true));
			
		$SQLQuery  = "INSERT INTO ".RW." SET ";
		$SQLQuery .= "`time` = '".$this->_fleet['fleet_start_time']."', ";
		$SQLQuery .= "`owners` = '".implode(',', array_merge($Attacker['id'], $Defender['id']))."', ";
		$SQLQuery .= "`rid` = '".$rid."', ";
		$SQLQuery .= "`raport` = '".$db->sql_escape($raport)."';";
		$SQLQuery .= "INSERT INTO ".TOPKB." SET ";
		$SQLQuery .= "`time` = '".$this->_fleet['fleet_start_time']."', ";
		$SQLQuery .= "`id_owner1` = '".implode(',', $Attacker['id'])."', ";
		$SQLQuery .= "`angreifer` = '".implode(' & ', $Attacker['name'])."', ";
		$SQLQuery .= "`id_owner2` = '".implode(',', $Defender['id'])."', ";
		$SQLQuery .= "`defender` = '".implode(' & ', $Defender['name'])."', ";
		$SQLQuery .= "`gesamtunits` = '".floattostring($result['lost']['att'] + $result['lost']['def'])."', ";
		$SQLQuery .= "`rid` = '". $rid ."', ";
		$SQLQuery .= "`raport` = '". $db->sql_escape(preg_replace("/\[(\d+)\:(\d+)\:(\d+)\]/i", "[X:X:X]", $raport)) ."',";
		$SQLQuery .= "`fleetresult` = '". $result['won'] ."';";		
		$SQLQuery .= "UPDATE ".USERS." SET ";
        $SQLQuery .= "`wons` = wons + ".$Won.", ";
        $SQLQuery .= "`loos` = loos + ".$Lose.", ";
        $SQLQuery .= "`draws` = draws + ".$Draw.", ";
        $SQLQuery .= "`kbmetal` = kbmetal + ".floattostring($result['debree']['att'][0]+$result['debree']['def'][0]).", ";
        $SQLQuery .= "`kbcrystal` = kbcrystal + ".floattostring($result['debree']['att'][1]+$result['debree']['def'][1]).", ";
        $SQLQuery .= "`lostunits` = lostunits + ".floattostring($result['lost']['att']).", ";
        $SQLQuery .= "`desunits` = desunits + ".floattostring($result['lost']['def'])." ";
        $SQLQuery .= "WHERE ";
        $SQLQuery .= substr($WhereAtt, 0, -4).";";
		$SQLQuery .= "UPDATE ".USERS." SET ";
        $SQLQuery .= "`wons` = wons + ". $Lose .", ";
        $SQLQuery .= "`loos` = loos + ". $Won .", ";
        $SQLQuery .= "`draws` = draws + ". $Draw  .", ";
        $SQLQuery .= "`kbmetal` = kbmetal + ".floattostring($result['debree']['att'][0]+$result['debree']['def'][0]).", ";
        $SQLQuery .= "`kbcrystal` = kbcrystal + ".floattostring($result['debree']['att'][1]+$result['debree']['def'][1]).", ";
        $SQLQuery .= "`lostunits` = lostunits + ".floattostring($result['lost']['def']).", ";
        $SQLQuery .= "`desunits` = desunits + ".floattostring($result['lost']['att'])." ";
        $SQLQuery .= "WHERE ";
        $SQLQuery .= substr($WhereDef, 0, -4).";";
		$db->multi_query($SQLQuery);
			
		switch($result['won'])
		{
			case "r":
				$ColorAtt = "red";
				$ColorDef = "green";
			break;
			case "w":
				$ColorAtt = "orange";
				$ColorDef = "orange";	
			case "a":
				$ColorAtt = "green";
				$ColorDef = "red";
			break;
		}
		
		$MessageAtt = sprintf($LNG['sys_mess_attack_report_mess'], $rid, $ColorAtt, $LNG['sys_mess_attack_report'], sprintf($LNG['sys_adress_planet'], $this->_fleet['fleet_end_galaxy'], $this->_fleet['fleet_end_system'], $this->_fleet['fleet_end_planet']), $ColorAtt, $LNG['sys_perte_attaquant'], pretty_number($result['lost']['att']), $ColorDef, $LNG['sys_perte_defenseur'], pretty_number($result['lost']['def']), $LNG['sys_gain'], $LNG['Metal'], pretty_number($steal['metal']), $LNG['Crystal'], pretty_number($steal['crystal']), $LNG['Deuterium'], pretty_number($steal['deuterium']), $LNG['sys_debris'], $LNG['Metal'], pretty_number($result['debree']['att'][0]+$result['debree']['def'][0]), $LNG['Crystal'], pretty_number($result['debree']['att'][1]+$result['debree']['def'][1]));
		$MessageDef = sprintf($LNG['sys_mess_attack_report_mess'], $rid, $ColorDef, $LNG['sys_mess_attack_report'], sprintf($LNG['sys_adress_planet'], $this->_fleet['fleet_end_galaxy'], $this->_fleet['fleet_end_system'], $this->_fleet['fleet_end_planet']), $ColorDef, $LNG['sys_perte_attaquant'], pretty_number($result['lost']['att']), $ColorAtt, $LNG['sys_perte_defenseur'], pretty_number($result['lost']['def']), $LNG['sys_gain'], $LNG['Metal'], pretty_number($steal['metal']), $LNG['Crystal'], pretty_number($steal['crystal']), $LNG['Deuterium'], pretty_number($steal['deuterium']), $LNG['sys_debris'], $LNG['Metal'], pretty_number($result['debree']['att'][0]+$result['debree']['def'][0]), $LNG['Crystal'], pretty_number($result['debree']['att'][1]+$result['debree']['def'][1]));
		
		foreach ($Attacker['id'] as $AttackersID)
		{
			SendSimpleMessage($AttackersID, 0, $this->_fleet['fleet_start_time'], 3, $LNG['sys_mess_tower'], $LNG['sys_mess_attack_report'], $MessageAtt);
		}
		foreach ($Defender['id'] as $DefenderID)
		{
			SendSimpleMessage($DefenderID, 0, $this->_fleet['fleet_start_time'], 3, $LNG['sys_mess_tower'], $LNG['sys_mess_attack_report'], $MessageDef);
		}
	}
	
	function EndStayEvent()
	{
		return;
	}
	
	function ReturnEvent()
	{
		$LNG			= $this->GetUserLang($this->_fleet['fleet_owner']);
	
		$Message		= sprintf( $LNG['sys_fleet_won'], $TargetName, GetTargetAdressLink($this->_fleet, ''), pretty_number($this->_fleet['fleet_resource_metal']), $LNG['Metal'], pretty_number($this->_fleet['fleet_resource_crystal']), $LNG['Crystal'], pretty_number($this->_fleet['fleet_resource_deuterium']), $LNG['Deuterium']);
		SendSimpleMessage ( $this->_fleet['fleet_owner'], '', $this->_fleet['fleet_end_time'], 3, $LNG['sys_mess_tower'], $LNG['sys_mess_fleetback'], $Message);
			
		$this->RestoreFleet();
	}
}
	
?>