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
 * @version 1.6.1 (2011-11-19)
 * @info $Id$
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
		
		$targetUser['factor']				= getFactors($targetUser, 'basic', $this->_fleet['fleet_start_time']);
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
				$attackFleets[$fleet['fleet_id']]['user'] 				= $db->uniquequery("SELECT `id`, `username`, `military_tech`, `defence_tech`, `shield_tech`, `rpg_amiral`, `dm_defensive`, `dm_attack`  FROM ".USERS." WHERE `id` = '".$fleet['fleet_owner']."';");
				$attackFleets[$fleet['fleet_id']]['user']['factor'] 	= getFactors($attackFleets[$fleet['fleet_id']]['user'], 'attack', $this->_fleet['fleet_start_time']);
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
			}
		}
		else
		{
			$attackFleets[$this->_fleet['fleet_id']]['fleet']			= $this->_fleet;
			$attackFleets[$this->_fleet['fleet_id']]['user'] 			= $db->uniquequery("SELECT `id`, `username`, `military_tech`, `defence_tech`, `shield_tech`, `rpg_amiral`, `dm_defensive`, `dm_attack`  FROM ".USERS." WHERE id = '".$this->_fleet['fleet_owner']."';");
			$attackFleets[$this->_fleet['fleet_id']]['user']['factor'] 	= getFactors($attackFleets[$this->_fleet['fleet_id']]['user'], 'attack', $this->_fleet['fleet_start_time']);
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
		}

		$defense = array();

		$def = $db->query("SELECT * FROM ".FLEETS." WHERE `fleet_mission` = '5' AND `fleet_end_id` = '".$this->_fleet['fleet_end_id']."' AND fleet_start_time <= '".TIMESTAMP."' AND fleet_end_stay >= '".TIMESTAMP."';");
		while ($defRow = $db->fetch_array($def))
		{
			$defense[$defRow['fleet_id']]['user'] = $db->uniquequery("SELECT `id`, `username`, `military_tech`, `defence_tech`, `shield_tech`, `rpg_amiral`, `dm_defensive`, `dm_attack`  FROM ".USERS." WHERE id = '".$defRow['fleet_owner']."';");
			$attackFleets[$this->_fleet['fleet_id']]['user']['factor'] 	= getFactors($defense[$defRow['fleet_id']]['user'], 'attack', $this->_fleet['fleet_start_time']);
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
		}

		$defense[0]['def'] 				= array();
		$defense[0]['user'] 			= $targetUser;
		$defense[0]['user']['factor'] 	= getFactors($defense[0]['user'], 'attack', $this->_fleet['fleet_start_time']);		
		$DefenderRow['id'][] 			= $defense[0]['user']['id'];
		
		foreach(array_merge($reslist['fleet'], $reslist['defense']) as $ID)
		{
			if ($ID >= 500 || $targetPlanet[$resource[$ID]] == 0)
				continue;

			$defense[0]['def'][$ID] = $targetPlanet[$resource[$ID]];
		}

		$Attacker['id']		= array_unique($AttackerRow['id']);
		$Defender['id']		= array_unique($DefenderRow['id']);
		
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
			
			if($totalCount <= 0) {
				$SQL .= "DELETE FROM ".FLEETS." WHERE `fleet_id`= '".$fleetID."';";
				$SQL .= "UPDATE ".LOG_FLEETS." SET `fleet_state` = 1 WHERE `fleet_id`= '".$fleetID."';";
			} else {
				$SQL .= "UPDATE ".FLEETS." SET `fleet_array` = '".substr($fleetArray, 0, -1)."', `fleet_amount` = '".$totalCount."' WHERE `fleet_id` = '".$fleetID."';";
				$SQL .= "UPDATE ".LOG_FLEETS." SET `fleet_array` = '".substr($fleetArray, 0, -1)."', `fleet_amount` = '".$totalCount."', `fleet_state` = 1 WHERE `fleet_id` = '".$fleetID."';";
			}	
		}
		
		$steal	= array(
			'metal'		=> 0,
			'crystal'	=> 0,
			'deuterium'	=> 0,
		);
		
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
				
				if($totalCount <= 0) {
					$SQL .= "DELETE FROM ".FLEETS." WHERE `fleet_id`= '".$fleetID."';";
					$SQL .= "UPDATE ".LOG_FLEETS." SET `fleet_state` = 1 WHERE `fleet_id`= '".$fleetID."';";
				} else {
					$SQL .= "UPDATE ".FLEETS." SET `fleet_array` = '".substr($fleetArray, 0, -1)."', `fleet_amount` = '".$totalCount."' WHERE `fleet_id` = '".$fleetID."';";
					$SQL .= "UPDATE ".LOG_FLEETS." SET `fleet_array` = '".substr($fleetArray, 0, -1)."', `fleet_amount` = '".$totalCount."' , `fleet_state` = 1 WHERE `fleet_id` = '".$fleetID."';";
				}
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
				$SQL .= "`metal` = `metal` - ".$steal['metal'].", ";
				$SQL .= "`crystal` = `crystal` - ".$steal['crystal'].", ";
				$SQL .= "`deuterium` = `deuterium` - ".$steal['deuterium']." ";
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
		$DerbisMetal		= $targetPlanet['der_metal'] + $ShootMetal;
		$DerbisCrystal		= $targetPlanet['der_crystal'] + $ShootCrystal;		
		$MoonChance       	= min(round($FleetDebris / 100000 * $GLOBALS['CONFIG'][$this->_fleet['fleet_universe']]['moon_factor'], 0), $GLOBALS['CONFIG'][$this->_fleet['fleet_universe']]['moon_chance']);
		$UserChance 		= mt_rand(1, 100);
		
		$INFO						= $this->_fleet;
		$INFO['steal']				= $steal;
		$INFO['moon']['des']		= 0;
		$INFO['moon']['desfail']	= false;
		$INFO['moon']['chance2']	= false;
		$INFO['moon']['fleetfail']	= false;
		
		$INFO['moon']['chance'] 	= $MoonChance;
		$INFO['moon']['name']		= "";
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
		
		require_once('GenerateReport.php');
		$raport						= GenerateReport($result, $INFO);
		$Won = 0;
		$Lose = 0; 
		$Draw = 0;
		
		switch($result['won'])
		{
			case "a":
				$Won = 1;
				$ColorAtt = "green";
				$ColorDef = "red";
			break;
			case "w":
				$Draw = 1;
				$ColorAtt = "orange";
				$ColorDef = "orange";
			break;
			case "r":
				$Lose = 1;
				$ColorAtt = "red";
				$ColorDef = "green";
			break;
		}
		
		$SQL = "INSERT INTO ".RW." SET ";
		$SQL .= "`raport` = '".serialize($raport)."', ";
		$SQL .= "`time` = '".$this->_fleet['fleet_start_time']."';";
		$db->query($SQL);
	
		$WhereAtt = "";
		$WhereDef = "";
		
		$rid	= $db->GetInsertID();
		$SQL = "";
		
		foreach ($Attacker['id'] as $AttackersID)
		{
			if(empty($AttackersID))
				continue;

			$LNG			= $LANG->GetUserLang($AttackersID);
			$MessageAtt 	= sprintf('<a href="CombatReport.php?raport=%s" target="_blank"><center><font color="%s">%s %s</font></a><br><br><font color="%s">%s: %s</font> <font color="%s">%s: %s</font><br>%s %s:<font color="#adaead">%s</font> %s:<font color="#ef51ef">%s</font> %s:<font color="#f77542">%s</font><br>%s %s:<font color="#adaead">%s</font> %s:<font color="#ef51ef">%s</font><br></center>', $rid, $ColorAtt, $LNG['sys_mess_attack_report'], sprintf($LNG['sys_adress_planet'], $this->_fleet['fleet_end_galaxy'], $this->_fleet['fleet_end_system'], $this->_fleet['fleet_end_planet']), $ColorAtt, $LNG['sys_perte_attaquant'], pretty_number($result['lost']['att']), $ColorDef, $LNG['sys_perte_defenseur'], pretty_number($result['lost']['def']), $LNG['sys_gain'], $LNG['tech'][901], pretty_number($steal['metal']), $LNG['tech'][902], pretty_number($steal['crystal']), $LNG['tech'][903], pretty_number($steal['deuterium']), $LNG['sys_debris'], $LNG['tech'][901], pretty_number($result['debree']['att'][0]+$result['debree']['def'][0]), $LNG['tech'][902], pretty_number($result['debree']['att'][1]+$result['debree']['def'][1]));
			SendSimpleMessage($AttackersID, 0, $this->_fleet['fleet_start_time'], 3, $LNG['sys_mess_tower'], $LNG['sys_mess_attack_report'], $MessageAtt);
			$SQL .= "INSERT INTO ".TOPKB_USERS." SET ";
			$SQL .= "`rid` = ".$rid.", ";
			$SQL .= "`role` = 1, ";
			$SQL .= "`uid` = ".$AttackersID.";";
			$WhereAtt .= "`id` = '".$AttackersID."' OR ";
		}

		foreach ($Defender['id'] as $DefenderID)
		{
			if(empty($DefenderID))
				continue;
				
			$LNG			= $LANG->GetUserLang($DefenderID);
			$MessageDef 	= sprintf('<a href="CombatReport.php?raport=%s" target="_blank"><center><font color="%s">%s %s</font></a><br><br><font color="%s">%s: %s</font> <font color="%s">%s: %s</font><br>%s %s:<font color="#adaead">%s</font> %s:<font color="#ef51ef">%s</font> %s:<font color="#f77542">%s</font><br>%s %s:<font color="#adaead">%s</font> %s:<font color="#ef51ef">%s</font><br></center>', $rid, $ColorDef, $LNG['sys_mess_attack_report'], sprintf($LNG['sys_adress_planet'], $this->_fleet['fleet_end_galaxy'], $this->_fleet['fleet_end_system'], $this->_fleet['fleet_end_planet']), $ColorDef, $LNG['sys_perte_attaquant'], pretty_number($result['lost']['att']), $ColorAtt, $LNG['sys_perte_defenseur'], pretty_number($result['lost']['def']), $LNG['sys_gain'], $LNG['tech'][901], pretty_number($steal['metal']), $LNG['tech'][902], pretty_number($steal['crystal']), $LNG['tech'][903], pretty_number($steal['deuterium']), $LNG['sys_debris'], $LNG['tech'][901], pretty_number($result['debree']['att'][0]+$result['debree']['def'][0]), $LNG['tech'][902], pretty_number($result['debree']['att'][1]+$result['debree']['def'][1]));
			SendSimpleMessage($DefenderID, 0, $this->_fleet['fleet_start_time'], 3, $LNG['sys_mess_tower'], $LNG['sys_mess_attack_report'], $MessageDef);
			$SQL .= "INSERT INTO ".TOPKB_USERS." SET ";
			$SQL .= "`rid` = ".$rid.", ";
			$SQL .= "`role` = 2, ";
			$SQL .= "`uid` = ".$DefenderID.";";
			$WhereDef .= "`id` = '".$DefenderID."' OR ";
		}
		
		$WhereCol	= $this->_fleet['fleet_end_type'] == 3 ? "id_luna" : "id";		
		$SQL .= "UPDATE ".PLANETS." SET ";
		$SQL .= "`der_metal` = ".$DerbisMetal.", ";
		$SQL .= "`der_crystal` = ".$DerbisCrystal." ";
		$SQL .= "WHERE ";
		$SQL .= "`".$WhereCol."` = ".$this->_fleet['fleet_end_id'].";";
		$SQL .= "INSERT INTO ".TOPKB." SET ";
		$SQL .= "`units` = ".($result['lost']['att'] + $result['lost']['def']).", ";
		$SQL .= "`rid` = ".$rid.", ";
		$SQL .= "`time` = ".$this->_fleet['fleet_start_time'].", ";
		$SQL .= "`universe` = ".$this->_fleet['fleet_universe'].", ";
		$SQL .= "`result` = '".$result['won'] ."';";		
		$SQL .= "UPDATE ".USERS." SET ";
        $SQL .= "`wons` = wons + ".$Won.", ";
        $SQL .= "`loos` = loos + ".$Lose.", ";
        $SQL .= "`draws` = draws + ".$Draw.", ";
        $SQL .= "`kbmetal` = kbmetal + ".$ShootMetal.", ";
        $SQL .= "`kbcrystal` = kbcrystal + ".$ShootCrystal.", ";
        $SQL .= "`lostunits` = lostunits + ".$result['lost']['att'].", ";
        $SQL .= "`desunits` = desunits + ".$result['lost']['def']." ";
        $SQL .= "WHERE ";
        $SQL .= substr($WhereAtt, 0, -4).";";
		$SQL .= "UPDATE ".USERS." SET ";
        $SQL .= "`wons` = wons + ". $Lose .", ";
        $SQL .= "`loos` = loos + ". $Won .", ";
        $SQL .= "`draws` = draws + ". $Draw  .", ";
        $SQL .= "`kbmetal` = kbmetal + ".$ShootMetal.", ";
        $SQL .= "`kbcrystal` = kbcrystal + ".$ShootCrystal.", ";
        $SQL .= "`lostunits` = lostunits + ".$result['lost']['def'].", ";
        $SQL .= "`desunits` = desunits + ".$result['lost']['att']." ";
        $SQL .= "WHERE ";
        $SQL .= substr($WhereDef, 0, -4).";";
		$db->multi_query($SQL);
		
		$this->setState(FLEET_RETURN);
		$this->SaveFleet();
	}
	
	function EndStayEvent()
	{
		return;
	}
	
	function ReturnEvent()
	{
		global $LANG, $db;
		$LNG		= $LANG->GetUserLang($this->_fleet['fleet_owner']);
		$TargetName	= $db->countquery("SELECT name FROM ".PLANETS." WHERE id = ".$this->_fleet['fleet_end_id'].";");
		$Message	= sprintf( $LNG['sys_fleet_won'], $TargetName, GetTargetAdressLink($this->_fleet, ''), pretty_number($this->_fleet['fleet_resource_metal']), $LNG['tech'][901], pretty_number($this->_fleet['fleet_resource_crystal']), $LNG['tech'][902], pretty_number($this->_fleet['fleet_resource_deuterium']), $LNG['tech'][903]);

		SendSimpleMessage($this->_fleet['fleet_owner'], 0, $this->_fleet['fleet_end_time'], 3, $LNG['sys_mess_tower'], $LNG['sys_mess_fleetback'], $Message);
			
		$this->RestoreFleet();
	}
}
	
?>