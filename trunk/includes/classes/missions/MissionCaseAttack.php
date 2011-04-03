<?php

/**
 *  2Moons
 *  Copyright (C) 2011  Slaver
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package 2Moons
 * @author Slaver <slaver7@gmail.com>
 * @copyright 2009 Lucky <lucky@xgproyect.net> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.3 (2011-01-21)
 * @link http://code.google.com/p/2moons/
 */

class MissionCaseAttack extends MissionFunctions
{
	function __construct($Fleet)
	{
		$this->_fleet	= $Fleet;
	}
	
	function TargetEvent()
	{	
		global $pricelist, $resource, $reslist, $db, $LANG;
		
		$targetPlanet 	= $db->uniquequery("SELECT * FROM ".PLANETS." WHERE `id` = '". $this->_fleet['fleet_end_id'] ."';");
		$targetUser   	= $db->uniquequery("SELECT * FROM ".USERS." WHERE id = '".$targetPlanet['id_owner']."';");
				
		require_once(ROOT_PATH.'includes/classes/class.PlanetRessUpdate.php');
		
		list($targetUser['factor'], $targetPlanet['factor'])	= getFactors($targetUser, $targetPlanet);
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
				$attackFleets[$fleet['fleet_id']]['fleet'] 				= $fleet;
				$attackFleets[$fleet['fleet_id']]['user'] 				= $db->uniquequery("SELECT id,username,military_tech,defence_tech,shield_tech,rpg_amiral,dm_defensive,dm_attack FROM ".USERS." WHERE `id` = '".$fleet['fleet_owner']."';");
				$attackFleets[$fleet['fleet_id']]['user']['factor'] 	= getFactors($attackFleets[$fleet['fleet_id']]['user'], null, 'attack');
				$attackFleets[$fleet['fleet_id']]['detail'] 			= array();
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
			$attackFleets[$this->_fleet['fleet_id']]['fleet']			= $this->_fleet;
			$attackFleets[$this->_fleet['fleet_id']]['user'] 			= $db->uniquequery("SELECT id,username,military_tech,defence_tech,shield_tech,rpg_amiral,dm_defensive,dm_attack FROM ".USERS." WHERE id = '".$this->_fleet['fleet_owner']."';");
			$attackFleets[$this->_fleet['fleet_id']]['user']['factor'] 	= getFactors($attackFleets[$fleet['fleet_id']]['user'], null, 'attack');
			$attackFleets[$this->_fleet['fleet_id']]['detail'] 			= array();
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

		$def = $db->query("SELECT * FROM ".FLEETS." WHERE `fleet_mission` = '5' AND `fleet_end_id` = '".$this->_fleet['fleet_end_id']."' AND fleet_start_time <= '".TIMESTAMP."' AND fleet_end_stay >= '".TIMESTAMP."';");
		while ($defRow = $db->fetch_array($def))
		{
			$defense[$defRow['fleet_id']]['user'] = $db->uniquequery("SELECT id,username,military_tech,defence_tech,shield_tech,rpg_amiral,dm_defensive,dm_attack FROM ".USERS." WHERE id = '".$defRow['fleet_owner']."';");
			$attackFleets[$this->_fleet['fleet_id']]['user']['factor'] 	= getFactors($attackFleets[$fleet['fleet_id']]['user'], null, 'attack');;
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
		$defense[0]['user']['factor'] 	= getFactors($defense[0]['user']['factor'], null, 'attack');		
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
		
		require_once('calculateAttack.php');
		$result 	= calculateAttack($attackFleets, $defense, $GLOBALS['CONFIG'][$this->_fleet['fleet_universe']]['Fleet_Cdr'], $GLOBALS['CONFIG'][$this->_fleet['fleet_universe']]['Defs_Cdr']);
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
			
			$SQL .= $totalCount <= 0 ? "DELETE FROM ".FLEETS." WHERE `fleet_id`= '".$fleetID."';" : "UPDATE ".FLEETS." SET `fleet_mess` = '1', `fleet_array` = '".substr($fleetArray, 0, -1)."', `fleet_amount` = '".$totalCount."' WHERE `fleet_id` = '".$fleetID."';";
		}	
		
		if ($result['won'] == "a")
		{
			require_once('calculateSteal.php');
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
				
				$SQL .= $totalCount <= 0 ? "DELETE FROM ".FLEETS." WHERE `fleet_id`= '".$fleetID."';" : "UPDATE ".FLEETS." SET `fleet_array` = '".substr($fleetArray, 0, -1)."', `fleet_amount` = '".$totalCount."' WHERE `fleet_id` = '".$fleetID."';";
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
				$SQL .= "`id` = '".$this->_fleet['fleet_end_id']."';";
			}
		}
		
		$db->multi_query($SQL);
		
		if($this->_fleet['fleet_end_type'] == 3)
			$targetPlanet 		= array_merge($targetPlanet, $db->uniquequery("SELECT `der_metal`, `der_crystal` FROM ".PLANETS." WHERE `id_luna` = '".$this->_fleet['fleet_end_id']."';"));
		$ShootMetal			= $result['debree']['att'][0] + $result['debree']['def'][0];
		$ShootCrystal		= $result['debree']['att'][1] + $result['debree']['def'][1];
		$FleetDebris		= $ShootMetal + $ShootCrystal;
		$DerbisMetal		= $targetPlanet['der_metal']+ $ShootMetal;
		$DerbisCrystal		= $targetPlanet['der_crystal']+ $ShootCrystal;		
		$MoonChance       	= min(round($FleetDebris / 100000 *  $GLOBALS['CONFIG'][$this->_fleet['fleet_universe']]['moon_factor'], 0), $GLOBALS['CONFIG'][$this->_fleet['fleet_universe']]['moon_chance']);
		$UserChance 		= mt_rand(1, 100);
		
		if ($targetPlanet['planet_type'] == 1 && $targetPlanet['id_luna'] == 0 && $MoonChance > 0 && $UserChance <= $MoonChance)
		{		
			require_once(ROOT_PATH.'includes/functions/CreateOneMoonRecord.php');
			$INFO['moon']['name'] 	= CreateOneMoonRecord($this->_fleet['fleet_end_galaxy'], $this->_fleet['fleet_end_system'], $this->_fleet['fleet_end_planet'], $this->_fleet['fleet_universe'], $TargetUserID, $this->_fleet['fleet_start_time'], '', $MoonChance);
			$INFO['end_galaxy'] = $this->_fleet['fleet_end_galaxy'];
			$INFO['end_system'] = $this->_fleet['fleet_end_system'];
			$INFO['end_planet'] = $this->_fleet['fleet_end_planet'];
			
			if($GLOBALS['CONFIG'][$this->_fleet['fleet_universe']]['debris_moon'] == 1) {
				$DerbisMetal	  = 0;
				$DerbisCrystal	  = 0;
			}
		}

		$INFO['steal']				= $steal;
		$INFO['fleet_start_time']	= $this->_fleet['fleet_start_time'];
		$INFO['moon']['des']		= 0;
		$INFO['moon']['chance'] 	= $MoonChance;
		$INFO['attvsdef']			= implode(' & ', $Attacker['name']).' vs '.implode(' & ', $Defender['name']);
		require_once('GenerateReport.php');
		$raport						= GenerateReport($result, $INFO);
		$rid						= md5(microtime(true).mt_rand(1,100));
	
		file_put_contents(ROOT_PATH.'raports/raport_'.$rid.'.php', '<?php'."\n".'$raport = '.$raport.';'."\n".'?>');
		file_put_contents(ROOT_PATH.'raports/topkb_'.$rid.'.php', '<?php'."\n".'$raport = '.preg_replace("/\[\d+\:\d+\:\d+\]/i", "[X:X:X]", $raport).';'."\n".'?>');
	
		if(DEBUG_EXTRA)
			file_put_contents(ROOT_PATH.'includes/attack.log', date('[d-M-Y H:i:s]', $this->_fleet['fleet_start_time']).'(FleetID: '.$this->_fleet['fleet_id'].') Attacker: '.$this->_fleet['fleet_owner'].'/ Defender: '.$this->_fleet['fleet_target_owner'].' | TF: '.floattostring($DerbisMetal).'/'.floattostring($DerbisCrystal));
		
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
		$SQL .= "`der_metal` = ".floattostring($DerbisMetal).", ";
		$SQL .= "`der_crystal` = ".floattostring($DerbisCrystal)." ";
		$SQL .= "WHERE ";
		$SQL .= "`universe` = '" . $this->_fleet['fleet_universe'] . "' AND ";
		$SQL .= "`galaxy` = '" . $this->_fleet['fleet_end_galaxy'] . "' AND ";
        $SQL .= "`system` = '" . $this->_fleet['fleet_end_system'] . "' AND ";
        $SQL .= "`planet` = '" . $this->_fleet['fleet_end_planet'] . "' AND ";
        $SQL .= "`planet_type` = '1';";
		$SQL .= "INSERT INTO ".RW." SET ";
		$SQL .= "`time` = '".$this->_fleet['fleet_start_time']."', ";
		$SQL .= "`owners` = '".implode(',', array_merge($Attacker['id'], $Defender['id']))."', ";
		$SQL .= "`rid` = '".$rid."';";
		$SQL .= "INSERT INTO ".TOPKB." SET ";
		$SQL .= "`time` = '".$this->_fleet['fleet_start_time']."', ";
		$SQL .= "`id_owner1` = '".implode(',', $Attacker['id'])."', ";
		$SQL .= "`angreifer` = '".implode(' & ', $Attacker['name'])."', ";
		$SQL .= "`id_owner2` = '".implode(',', $Defender['id'])."', ";
		$SQL .= "`defender` = '".implode(' & ', $Defender['name'])."', ";
		$SQL .= "`gesamtunits` = '".floattostring($result['lost']['att'] + $result['lost']['def'])."', ";
		$SQL .= "`rid` = '". $rid ."', ";
		$SQL .= "`universe` = '".$this->_fleet['fleet_universe']."', ";
		$SQL .= "`fleetresult` = '". $result['won'] ."';";		
		$SQL .= "UPDATE ".USERS." SET ";
        $SQL .= "`wons` = wons + ".$Won.", ";
        $SQL .= "`loos` = loos + ".$Lose.", ";
        $SQL .= "`draws` = draws + ".$Draw.", ";
        $SQL .= "`kbmetal` = kbmetal + ".floattostring($ShootMetal).", ";
        $SQL .= "`kbcrystal` = kbcrystal + ".floattostring($ShootCrystal).", ";
        $SQL .= "`lostunits` = lostunits + ".floattostring($result['lost']['att']).", ";
        $SQL .= "`desunits` = desunits + ".floattostring($result['lost']['def'])." ";
        $SQL .= "WHERE ";
        $SQL .= substr($WhereAtt, 0, -4).";";
		$SQL .= "UPDATE ".USERS." SET ";
        $SQL .= "`wons` = wons + ". $Lose .", ";
        $SQL .= "`loos` = loos + ". $Won .", ";
        $SQL .= "`draws` = draws + ". $Draw  .", ";
        $SQL .= "`kbmetal` = kbmetal + ".floattostring($ShootMetal).", ";
        $SQL .= "`kbcrystal` = kbcrystal + ".floattostring($ShootCrystal).", ";
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
			if(empty($AttackersID))
				continue;

			$LNG			= $LANG->GetUserLang($AttackersID);
			$MessageAtt 	= sprintf('<a href="CombatReport.php?raport=%s" onclick="OpenPopup(\'CombatReport.php?raport=%s\', \'combat\', screen.width, screen.height);return false" target="combat"><center><font color="%s">%s %s</font></a><br><br><font color="%s">%s: %s</font> <font color="%s">%s: %s</font><br>%s %s:<font color="#adaead">%s</font> %s:<font color="#ef51ef">%s</font> %s:<font color="#f77542">%s</font><br>%s %s:<font color="#adaead">%s</font> %s:<font color="#ef51ef">%s</font><br></center>', $rid, $rid, $ColorAtt, $LNG['sys_mess_attack_report'], sprintf($LNG['sys_adress_planet'], $this->_fleet['fleet_end_galaxy'], $this->_fleet['fleet_end_system'], $this->_fleet['fleet_end_planet']), $ColorAtt, $LNG['sys_perte_attaquant'], pretty_number($result['lost']['att']), $ColorDef, $LNG['sys_perte_defenseur'], pretty_number($result['lost']['def']), $LNG['sys_gain'], $LNG['Metal'], pretty_number($steal['metal']), $LNG['Crystal'], pretty_number($steal['crystal']), $LNG['Deuterium'], pretty_number($steal['deuterium']), $LNG['sys_debris'], $LNG['Metal'], pretty_number($result['debree']['att'][0]+$result['debree']['def'][0]), $LNG['Crystal'], pretty_number($result['debree']['att'][1]+$result['debree']['def'][1]));
			SendSimpleMessage($AttackersID, '', $this->_fleet['fleet_start_time'], 3, $LNG['sys_mess_tower'], $LNG['sys_mess_attack_report'], $MessageAtt);
		}

		foreach ($Defender['id'] as $DefenderID)
		{
			if(empty($DefenderID))
				continue;
				
			$LNG			= $LANG->GetUserLang($DefenderID);
			$MessageDef 	= sprintf('<a href="CombatReport.php?raport=%s" onclick="OpenPopup(\'CombatReport.php?raport=%s\', \'combat\', screen.width, screen.height);return false" target="combat"><center><font color="%s">%s %s</font></a><br><br><font color="%s">%s: %s</font> <font color="%s">%s: %s</font><br>%s %s:<font color="#adaead">%s</font> %s:<font color="#ef51ef">%s</font> %s:<font color="#f77542">%s</font><br>%s %s:<font color="#adaead">%s</font> %s:<font color="#ef51ef">%s</font><br></center>', $rid, $rid, $ColorDef, $LNG['sys_mess_attack_report'], sprintf($LNG['sys_adress_planet'], $this->_fleet['fleet_end_galaxy'], $this->_fleet['fleet_end_system'], $this->_fleet['fleet_end_planet']), $ColorDef, $LNG['sys_perte_attaquant'], pretty_number($result['lost']['att']), $ColorAtt, $LNG['sys_perte_defenseur'], pretty_number($result['lost']['def']), $LNG['sys_gain'], $LNG['Metal'], pretty_number($steal['metal']), $LNG['Crystal'], pretty_number($steal['crystal']), $LNG['Deuterium'], pretty_number($steal['deuterium']), $LNG['sys_debris'], $LNG['Metal'], pretty_number($result['debree']['att'][0]+$result['debree']['def'][0]), $LNG['Crystal'], pretty_number($result['debree']['att'][1]+$result['debree']['def'][1]));
			SendSimpleMessage($DefenderID, '', $this->_fleet['fleet_start_time'], 3, $LNG['sys_mess_tower'], $LNG['sys_mess_attack_report'], $MessageDef);
		}
	}
	
	function EndStayEvent()
	{
		return;
	}
	
	function ReturnEvent()
	{
		global $LANG;
		$LNG			= $LANG->GetUserLang($this->_fleet['fleet_owner']);
	
		$Message		= sprintf( $LNG['sys_fleet_won'], $TargetName, GetTargetAdressLink($this->_fleet, ''), pretty_number($this->_fleet['fleet_resource_metal']), $LNG['Metal'], pretty_number($this->_fleet['fleet_resource_crystal']), $LNG['Crystal'], pretty_number($this->_fleet['fleet_resource_deuterium']), $LNG['Deuterium']);
		SendSimpleMessage($this->_fleet['fleet_owner'], '', $this->_fleet['fleet_end_time'], 3, $LNG['sys_mess_tower'], $LNG['sys_mess_fleetback'], $Message);
			
		$this->RestoreFleet();
	}
}
	
?>