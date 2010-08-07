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
		
		$targetPlanet 	= $db->uniquequery("SELECT * FROM ".PLANETS." WHERE `galaxy` = '". $this->_fleet['fleet_end_galaxy'] ."' AND `system` = '". $this->_fleet['fleet_end_system']."' AND `planet` = '".$this->_fleet['fleet_end_planet']."' AND `planet_type` = '".$this->_fleet['fleet_end_type']."';");
		$targetUser   	= $db->uniquequery("SELECT * FROM ".USERS." WHERE id = '".$targetPlanet['id_owner']."';");
				
		require_once(ROOT_PATH.'includes/classes/class.PlanetRessUpdate.'.PHP_EXT);
		
		$PlanetRess 						= new ResourceUpdate();
		list($targetUser, $targetPlanet)	= $PlanetRess->CalcResource($targetUser, $targetPlanet, true, $this->_fleet['fleet_start_time']);

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
		
		foreach(array_merge($reslist['fleet'], $reslist['defense']) as $ID)
		{
			if ($ID >= 500)
				continue;

			$defense[0]['def'][$ID] = $targetPlanet[$resource[$ID]];
		}

		$Attacker['id']		= array_unique($AttackerRow['id']);
		$Attacker['name']	= array_unique($AttackerRow['name']);
		$Defender['id']		= array_unique($DefenderRow['id']);
		$Defender['name']	= array_unique($DefenderRow['name']);

		require_once('calculateAttack.'.PHP_EXT);

		$result 	= calculateAttack($attackFleets, $defense);
		$SQL		= "";
			
		foreach ($attackFleets as $fleetID => $attacker)
		{
			$fleetArray = '';
			$totalCount = 0;
			foreach ($attacker['detail'] as $element => $amount)
			{				
				if ($amount)
					$fleetArray .= $element.','.floattostring($amount).';';

				$totalCount += $amount;
			}
			
			if ($totalCount <= 0)
				$SQL	.= "DELETE FROM ".FLEETS." WHERE `fleet_id`= '".$fleetID."';";
			else
				$SQL	.= "UPDATE ".FLEETS." SET `fleet_mess` = '1', `fleet_array` = '".substr($fleetArray, 0, -1)."', `fleet_amount` = '".$totalCount."' WHERE `fleet_id` = '".$fleetID."';";
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
					if ($amount)
						$fleetArray .= $element.','.floattostring($amount).';';
						
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
				foreach ($defender['def'] as $element => $amount)
				{
					$fleetArray .= "`".$resource[$element]."` = '".floattostring($amount)."', ";
				}
				
				$SQL .= "UPDATE ".PLANETS." SET ";
				$SQL .= $fleetArray;
				$SQL .= "`metal` = `metal` - '".$steal['metal']."', ";
				$SQL .= "`crystal` = `crystal` - '".$steal['crystal']."', ";
				$SQL .= "`deuterium` = `deuterium` - '".$steal['deuterium']."' ";
				$SQL .= "WHERE ";
				$SQL .= "`galaxy` = '".$this->_fleet['fleet_end_galaxy']."' AND ";
				$SQL .= "`system` = '".$this->_fleet['fleet_end_system']."' AND ";
				$SQL .= "`planet` = '".$this->_fleet['fleet_end_planet']."' AND ";
				$SQL .= "`planet_type` = '".$this->_fleet['fleet_end_type']."';";
			}
		}
		
		$db->multi_query($SQL);
		
		if($this->_fleet['fleet_end_type'] == 3)
			$targetPlanet 		= array_merge($targetPlanet, $db->uniquequery("SELECT `der_metal`, `der_crystal` FROM ".PLANETS." WHERE `galaxy` = '". $this->_fleet['fleet_end_galaxy'] ."' AND `system` = '". $this->_fleet['fleet_end_system']."' AND `planet` = '".$this->_fleet['fleet_end_planet']."' AND `planet_type` = '1';"));
		
		$DerbisMetal		= bcadd($targetPlanet['der_metal'], bcadd($result['debree']['att'][0], $result['debree']['def'][0]));
		$DerbisCrystal		= bcadd($targetPlanet['der_crystal'], bcadd($result['debree']['att'][1], $result['debree']['def'][1]));	
		$FleetDebris		= bcadd($DerbisMetal, $DerbisCrystal);
		$MoonChance       	= min(round(bcdiv($FleetDebris, "100000") * MOON_CHANCE_FACTOR, 0), 20);
		$UserChance 		= mt_rand(1, 100);
		
		if ($targetPlanet['planet_type'] == 1 && $targetPlanet['id_luna'] == 0 && $MoonChance > 0 && $UserChance <= $MoonChance)
		{		
			require_once(ROOT_PATH.'includes/functions/CreateOneMoonRecord.'.PHP_EXT);
			$INFO['moon']['name'] 	= CreateOneMoonRecord($this->_fleet['fleet_end_galaxy'], $this->_fleet['fleet_end_system'], $this->_fleet['fleet_end_planet'], $TargetUserID, $this->_fleet['fleet_start_time'], '', $MoonChance);
			$INFO['end_galaxy'] = $this->_fleet['fleet_end_galaxy'];
			$INFO['end_system'] = $this->_fleet['fleet_end_system'];
			$INFO['end_planet'] = $this->_fleet['fleet_end_planet'];
			
			if(DESTROY_DERBIS_MOON_CREATE) {
				$DerbisMetal	  = 0;
				$DerbisCrystal	  = 0;
			}
		}

		$INFO['steal']				= $steal;
		$INFO['fleet_start_time']	= $this->_fleet['fleet_start_time'];
		$INFO['moon']['des']		= 0;
		$INFO['moon']['chance'] 	= $MoonChance;
		
		require_once('GenerateReport.'.PHP_EXT);
		$raport		= GenerateReport($result, $INFO);
		$rid		= md5(microtime(true).mt_rand(1,100));
	
		file_put_contents(ROOT_PATH.'raports/raport_'.$rid.'.php', '<?php'."\n".'$raport = '.$raport.';'."\n".'?>');
		file_put_contents(ROOT_PATH.'raports/topkb_'.$rid.'.php', '<?php'."\n".'$raport = '.preg_replace(array("/\[\d+\:\d+\:\d+\]/i", "/\d{3}\%/i"), array("[X:X:X]", "XXX%"), $raport).';'."\n".'?>');
		
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
							
		$SQL  = "UPDATE ".PLANETS." SET ";
		$SQL .= "`der_metal` = '".$DerbisMetal."', ";
		$SQL .= "`der_crystal` = '".$DerbisCrystal."' ";
		$SQL .= "WHERE ";
		$SQL .= "`galaxy` = '" . $this->_fleet['fleet_end_galaxy'] . "' AND ";
		$SQL .= "`system` = '" . $this->_fleet['fleet_end_system'] . "' AND ";
		$SQL .= "`planet` = '" . $this->_fleet['fleet_end_planet'] . "' AND ";
		$SQL .= "`planet_type` = '1';";
		$SQL .= "INSERT INTO ".RW." SET ";
		$SQL .= "`time` = '".$this->_fleet['fleet_start_time']."', ";
		$SQL .= "`owners` = '".implode(',', array_merge($Attacker['id'], $Defender['id']))."', ";
		$SQL .= "`rid` = '".$rid."', ";
		$SQL .= "`raport` = '';";
		$SQL .= "INSERT INTO ".TOPKB." SET ";
		$SQL .= "`time` = '".$this->_fleet['fleet_start_time']."', ";
		$SQL .= "`id_owner1` = '".implode(',', $Attacker['id'])."', ";
		$SQL .= "`angreifer` = '".implode(' & ', $Attacker['name'])."', ";
		$SQL .= "`id_owner2` = '".implode(',', $Defender['id'])."', ";
		$SQL .= "`defender` = '".implode(' & ', $Defender['name'])."', ";
		$SQL .= "`gesamtunits` = '".floattostring($result['lost']['att'] + $result['lost']['def'])."', ";
		$SQL .= "`rid` = '". $rid ."', ";
		$SQL .= "`raport` = '',";
		$SQL .= "`fleetresult` = '". $result['won'] ."';";		
		$SQL .= "UPDATE ".USERS." SET ";
        $SQL .= "`wons` = wons + ".$Won.", ";
        $SQL .= "`loos` = loos + ".$Lose.", ";
        $SQL .= "`draws` = draws + ".$Draw.", ";
        $SQL .= "`kbmetal` = kbmetal + ".floattostring($result['debree']['att'][0] + $result['debree']['def'][0]).", ";
        $SQL .= "`kbcrystal` = kbcrystal + ".floattostring($result['debree']['att'][1] + $result['debree']['def'][1]).", ";
        $SQL .= "`lostunits` = lostunits + ".floattostring($result['lost']['att']).", ";
        $SQL .= "`desunits` = desunits + ".floattostring($result['lost']['def'])." ";
        $SQL .= "WHERE ";
        $SQL .= substr($WhereAtt, 0, -4).";";
		$SQL .= "UPDATE ".USERS." SET ";
        $SQL .= "`wons` = wons + ". $Lose .", ";
        $SQL .= "`loos` = loos + ". $Won .", ";
        $SQL .= "`draws` = draws + ". $Draw  .", ";
        $SQL .= "`kbmetal` = kbmetal + ".floattostring($result['debree']['att'][0] + $result['debree']['def'][0]).", ";
        $SQL .= "`kbcrystal` = kbcrystal + ".floattostring($result['debree']['att'][1] + $result['debree']['def'][1]).", ";
        $SQL .= "`lostunits` = lostunits + ".floattostring($result['lost']['def']).", ";
        $SQL .= "`desunits` = desunits + ".floattostring($result['lost']['att'])." ";
        $SQL .= "WHERE ";
        $SQL .= substr($WhereDef, 0, -4).";";
		$db->multi_query($SQL);
		
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
		
		foreach ($Attacker['id'] as $AttackersID)
		{
			$LNG			= $this->GetUserLang($AttackersID);
			$MessageAtt 	= sprintf($LNG['sys_mess_attack_report_mess'], $rid, $ColorAtt, $LNG['sys_mess_attack_report'], sprintf($LNG['sys_adress_planet'], $this->_fleet['fleet_end_galaxy'], $this->_fleet['fleet_end_system'], $this->_fleet['fleet_end_planet']), $ColorAtt, $LNG['sys_perte_attaquant'], pretty_number($result['lost']['att']), $ColorDef, $LNG['sys_perte_defenseur'], pretty_number($result['lost']['def']), $LNG['sys_gain'], $LNG['Metal'], pretty_number($steal['metal']), $LNG['Crystal'], pretty_number($steal['crystal']), $LNG['Deuterium'], pretty_number($steal['deuterium']), $LNG['sys_debris'], $LNG['Metal'], pretty_number($result['debree']['att'][0]+$result['debree']['def'][0]), $LNG['Crystal'], pretty_number($result['debree']['att'][1]+$result['debree']['def'][1]));
			SendSimpleMessage($AttackersID, '', $this->_fleet['fleet_start_time'], 3, $LNG['sys_mess_tower'], $LNG['sys_mess_attack_report'], $MessageAtt);
		}

		foreach ($Defender['id'] as $DefenderID)
		{
			$LNG			= $this->GetUserLang($DefenderID);
			$MessageDef 	= sprintf($LNG['sys_mess_attack_report_mess'], $rid, $ColorDef, $LNG['sys_mess_attack_report'], sprintf($LNG['sys_adress_planet'], $this->_fleet['fleet_end_galaxy'], $this->_fleet['fleet_end_system'], $this->_fleet['fleet_end_planet']), $ColorDef, $LNG['sys_perte_attaquant'], pretty_number($result['lost']['att']), $ColorAtt, $LNG['sys_perte_defenseur'], pretty_number($result['lost']['def']), $LNG['sys_gain'], $LNG['Metal'], pretty_number($steal['metal']), $LNG['Crystal'], pretty_number($steal['crystal']), $LNG['Deuterium'], pretty_number($steal['deuterium']), $LNG['sys_debris'], $LNG['Metal'], pretty_number($result['debree']['att'][0]+$result['debree']['def'][0]), $LNG['Crystal'], pretty_number($result['debree']['att'][1]+$result['debree']['def'][1]));
			SendSimpleMessage($DefenderID, '', $this->_fleet['fleet_start_time'], 3, $LNG['sys_mess_tower'], $LNG['sys_mess_attack_report'], $MessageDef);
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
		SendSimpleMessage($this->_fleet['fleet_owner'], '', $this->_fleet['fleet_end_time'], 3, $LNG['sys_mess_tower'], $LNG['sys_mess_fleetback'], $Message);
			
		$this->RestoreFleet();
	}
}
	
?>