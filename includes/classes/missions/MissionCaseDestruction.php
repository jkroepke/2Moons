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
 * @version 1.4 (2011-07-10)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

class MissionCaseDestruction extends MissionFunctions
{
	function __construct($Fleet)
	{
		$this->_fleet	= $Fleet;
	}
	
	function TargetEvent()
	{
		global $pricelist, $resource, $reslist, $db, $LANG;
		$TargetPlanet = $db->uniquequery("SELECT * FROM ".PLANETS." WHERE `id` = '".$this->_fleet['fleet_end_id']."' ;");
		$TargetUser   = $db->uniquequery("SELECT * FROM ".USERS." WHERE `id` = '".$TargetPlanet['id_owner']."';");
		$TargetUserID = $TargetUser['id'];
		$attackFleets = array();
	
		require_once(ROOT_PATH.'includes/classes/class.PlanetRessUpdate.php');
		
		$TargetUser['factor']				= getFactors($targetUser, 'basic', $this->_fleet['fleet_start_time']);
		$PlanetRess 						= new ResourceUpdate();
		list($TargetUser, $TargetPlanet)	= $PlanetRess->CalcResource($TargetUser, $TargetPlanet, true, $this->_fleet['fleet_start_time']);

		
		$attackFleets[$this->_fleet['fleet_id']]['fleet'] = $this->_fleet;
		$attackFleets[$this->_fleet['fleet_id']]['user'] = $db->uniquequery("SELECT `id`, `username`, `military_tech`, `defence_tech`, `shield_tech`, `rpg_amiral`, `dm_defensive`, `dm_attack` FROM ".USERS." WHERE id = '".$this->_fleet['fleet_owner']."';");
		$attackFleets[$this->_fleet['fleet_id']]['user']['factor'] 	= getFactors($attackFleets[$this->_fleet['fleet_id']]['user'], 'attack', $this->_fleet['fleet_start_time']);
		$attackFleets[$this->_fleet['fleet_id']]['detail'] = array();
		$temp = explode(';', $this->_fleet['fleet_array']);
		foreach ($temp as $temp2)
		{
			$temp2 = explode(',', $temp2);
			if ($temp2[0] < 100) continue;

			if (!isset($attackFleets[$this->_fleet['fleet_id']]['detail'][$temp2[0]]))
				$attackFleets[$this->_fleet['fleet_id']]['detail'][$temp2[0]] = 0;

			$attackFleets[$this->_fleet['fleet_id']]['detail'][$temp2[0]] += $temp2[1];
			$AttackerRow['id'][] 	= $attackFleets[$this->_fleet['fleet_id']]['user']['id'];
			$AttackerRow['name'][]	= $attackFleets[$this->_fleet['fleet_id']]['user']['username'];
		}
		
		$defense = array();

		$def = $db->query('SELECT * FROM '.FLEETS.' WHERE `fleet_end_galaxy` = '. $this->_fleet['fleet_end_galaxy'] .' AND `fleet_end_system` = '. $this->_fleet['fleet_end_system'] .' AND `fleet_end_type` = '. $this->_fleet['fleet_end_type'] .' AND `fleet_end_planet` = '. $this->_fleet['fleet_end_planet'] .' AND fleet_start_time<'.TIMESTAMP.' AND fleet_end_stay>='.TIMESTAMP.';');
		while ($defRow = $db->fetch_array($def))
		{
			$defRowDef = explode(';', $defRow['fleet_array']);
			foreach ($defRowDef as $Element)
			{
				$Element = explode(',', $Element);
				if ($Element[0] < 100) continue;

				if (!isset($defense[$defRow['fleet_id']]['def'][$Element[0]]))
					$defense[$defRow['fleet_id']][$Element[0]] = 0;

				$defense[$defRow['fleet_id']]['def'][$Element[0]] 	+= $Element[1];
				$defense[$defRow['fleet_id']]['user']				= $db->uniquequery("SELECT `id`, `username`, `military_tech`, `defence_tech`, `shield_tech`, `rpg_amiral`, `dm_defensive`, `dm_attack` FROM ".USERS." WHERE id = '".$defRow['fleet_owner']."';");
				$defense[$defRow['fleet_id']]['user']['factor'] 	= getFactors($defense[$defRow['fleet_id']]['user'], 'attack', $this->_fleet['fleet_start_time']);
			}
			$DefenderRow['id'][] 	= $defense[$defRow['fleet_id']]['user']['id'];
			$DefenderRow['name'][]	= $defense[$defRow['fleet_id']]['user']['username'];
		}

		$defense[0]['def'] = array();
		$defense[0]['user'] = $TargetUser;
		$defense[0]['user']['factor'] 	= getFactors($defense[0]['user'], 'attack', $this->_fleet['fleet_start_time']);		
		$DefenderRow['id'][] 	= $defense[0]['user']['id'];
		$DefenderRow['name'][]	= $defense[0]['user']['username'];
		for ($i = 200; $i < 500; $i++)
		{
			if (isset($resource[$i]) && isset($TargetPlanet[$resource[$i]]))
			{
				$defense[0]['def'][$i] = $TargetPlanet[$resource[$i]];
			}
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
			
			$SQL .= $totalCount <= 0 ? "DELETE FROM ".FLEETS." WHERE `fleet_id`= '".$fleetID."';" : "UPDATE ".FLEETS." SET `fleet_mess` = '1', `fleet_array` = '".substr($fleetArray, 0, -1)."', `fleet_amount` = '".floattostring($totalCount)."' WHERE `fleet_id` = '".$fleetID."';";
		}	
	
		$db->multi_query($SQL);
		$SQL	= "";
		
		if ($result['won'] == "a")
		{
			require_once('calculateSteal.php');
			$steal = calculateSteal($attackFleets, $TargetPlanet);
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
				$SQL .= $totalCount <= 0 ? "DELETE FROM ".FLEETS." WHERE `fleet_id`= '".$fleetID."';" : "UPDATE ".FLEETS." SET `fleet_array` = '".substr($fleetArray, 0, -1)."', `fleet_amount` = '".floattostring($totalCount)."' WHERE `fleet_id` = '".$fleetID."';";
			}
			else
			{
				$fleetArray = '';
				$totalCount = 0;

				foreach ($defender['def'] as $element => $amount)
				{
					$fleetArray .= "`".$resource[$element]."` = '".floattostring($amount)."', ";
				}

				$SQL .= "UPDATE ".PLANETS." SET ";
				$SQL .= $fleetArray;
				$SQL .= "`metal` = `metal` - '".floattostring($steal['metal'])."', `crystal` = `crystal` - '".floattostring($steal['crystal'])."', `deuterium` = `deuterium` - '".floattostring($steal['deuterium'])."' WHERE `id` = '".$this->_fleet['fleet_end_id']."';";
			}
		}
		
		$db->multi_query($SQL);
		
		switch ($result['won']) {
			case "a":
				$chance		 	= max(min(round((100 - sqrt($TargetPlanet['diameter'])) * sqrt($attackFleets[$this->_fleet['fleet_id']]['detail'][214]), 1), 100), 0);
				$chance2  		= round(sqrt($TargetPlanet['diameter'])/2);                 

				$tirage 		= rand(0, 100);
				$tirage2  		= rand(0, 100);

				$INFO['moon']['chance']		= $chance;
				$INFO['moon']['chance2']	= $chance2;
				
				if($tirage <= $chance) {
					$EndPlanet		= $db->uniquequery("SELECT `id` FROM ".PLANETS." WHERE `id_luna` = '".$this->_fleet['fleet_end_id']."';");
					$db->multi_query("DELETE FROM ".PLANETS." WHERE `id` = '".$TargetPlanet['id']."';UPDATE ".PLANETS." SET `id_luna` = '0' WHERE `id_luna` = '".$TargetPlanet['id']."';UPDATE ".FLEETS." SET `fleet_start_type` = '1', `fleet_start_id` = '".$EndPlanet['id']."' WHERE `fleet_start_id` = '".$this->_fleet['fleet_end_id']."';UPDATE ".FLEETS." SET `fleet_end_type` = '1', `fleet_end_id` = '".$EndPlanet['id']."', `fleet_mission` = IF(`fleet_mission` = 9, 1, `fleet_mission`) WHERE `fleet_end_id` = '".$this->_fleet['fleet_end_id']."' AND `fleet_id` != '".$this->_fleet['fleet_id']."';");
					$INFO['moon']['desfail'] = 0;
				} else {
					$INFO['moon']['desfail'] = 2;
				}
				
				if($tirage2 <= $chance2) {
					$INFO['moon']['fleetfail'] = 1;
					$db->query("DELETE FROM ".FLEETS." WHERE `fleet_id` = '". $this->_fleet["fleet_id"] ."';");
				} else {
					$INFO['moon']['fleetfail'] = 0;
				}
			break;
			case "r":
				$INFO['moon']['desfail'] = 1;
				$destext 		  .= sprintf ($LNG['sys_destruc_mess'], $this->_fleet['fleet_start_galaxy'], $this->_fleet['fleet_start_system'], $this->_fleet['fleet_start_planet'], $this->_fleet['fleet_end_galaxy'], $this->_fleet['fleet_end_system'], $this->_fleet['fleet_end_planet'])."<br>";
				$destext 		  .= $LNG['sys_destruc_stop'] ."<br>";
			break;
			case "w":
				$INFO['moon']['desfail'] = 1;
				$destext 		  .= sprintf ($LNG['sys_destruc_mess'], $this->_fleet['fleet_start_galaxy'], $this->_fleet['fleet_start_system'], $this->_fleet['fleet_start_planet'], $this->_fleet['fleet_end_galaxy'], $this->_fleet['fleet_end_system'], $this->_fleet['fleet_end_planet'])."<br>";
				$destext 		  .= $LNG['sys_destruc_stop'] ."<br>";
			break;
		}
		
		$INFO['steal']				= $steal;
		$INFO['moon']['des']		= 1;
		$INFO['fleet_start_time']	= $this->_fleet['fleet_start_time'];
		$INFO['start_galaxy'] 		= $this->_fleet['fleet_start_galaxy'];
		$INFO['start_system']		= $this->_fleet['fleet_start_system'];
		$INFO['start_planet']		= $this->_fleet['fleet_start_planet'];
		$INFO['end_galaxy'] 		= $this->_fleet['fleet_end_galaxy'];
		$INFO['end_system']			= $this->_fleet['fleet_end_system'];
		$INFO['end_planet']			= $this->_fleet['fleet_end_planet'];
		$INFO['attvsdef']			= implode(' & ', $Attacker['name']).' vs '.implode(' & ', $Defender['name']);
			
		require_once('GenerateReport.php');
		$raport		= GenerateReport($result, $INFO);
		$rid		= md5(microtime(true).mt_rand(1,100));
	
		file_put_contents(ROOT_PATH.'raports/raport/'.$rid.'.php', $raport);
		file_put_contents(ROOT_PATH.'raports/topkb/'.$rid.'.php', preg_replace("/\[\d+\:\d+\:\d+\]/i", "[X:X:X]", $raport));
		
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

		$ShootMetal			= floattostring($result['debree']['att'][0] + $result['debree']['def'][0]);
		$ShootCrystal		= floattostring($result['debree']['att'][1] + $result['debree']['def'][1]);	
		
		$SQL  = "UPDATE ".PLANETS." SET ";
		$SQL .= "`der_metal` = `der_metal` + '".$ShootMetal."', ";
		$SQL .= "`der_crystal` = `der_crystal` + '".$ShootCrystal."' ";
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
		$SQL .= "`universe` = '".$this->_fleet['fleet_universe']."', ";
		$SQL .= "`rid` = '". $rid ."', ";
		$SQL .= "`fleetresult` = '". $result['won'] ."';";		
		$SQL .= "UPDATE ".USERS." SET ";
        $SQL .= "`wons` = wons + ".$Won.", ";
        $SQL .= "`loos` = loos + ".$Lose.", ";
        $SQL .= "`draws` = draws + ".$Draw.", ";
        $SQL .= "`kbmetal` = kbmetal + ".$ShootMetal.", ";
        $SQL .= "`kbcrystal` = kbcrystal + ".$ShootCrystal.", ";
        $SQL .= "`lostunits` = lostunits + ".floattostring($result['lost']['att']).", ";
        $SQL .= "`desunits` = desunits + ".floattostring($result['lost']['def'])." ";
        $SQL .= "WHERE ";
        $SQL .= substr($WhereAtt, 0, -4).";";
		$SQL .= "UPDATE ".USERS." SET ";
        $SQL .= "`wons` = wons + ". $Lose .", ";
        $SQL .= "`loos` = loos + ". $Won .", ";
        $SQL .= "`draws` = draws + ". $Draw  .", ";
        $SQL .= "`kbmetal` = kbmetal + ".$ShootMetal.", ";
        $SQL .= "`kbcrystal` = kbcrystal + ".$ShootCrystal.", ";
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
			SendSimpleMessage($AttackersID, 0, $this->_fleet['fleet_start_time'], 3, $LNG['sys_mess_tower'], $LNG['sys_mess_attack_report'], $MessageAtt);
		}

		foreach ($Defender['id'] as $DefenderID)
		{
			if(empty($DefenderID))
				continue;
				
			$LNG			= $LANG->GetUserLang($DefenderID);
			$MessageDef 	= sprintf('<a href="CombatReport.php?raport=%s" onclick="OpenPopup(\'CombatReport.php?raport=%s\', \'combat\', screen.width, screen.height);return false" target="combat"><center><font color="%s">%s %s</font></a><br><br><font color="%s">%s: %s</font> <font color="%s">%s: %s</font><br>%s %s:<font color="#adaead">%s</font> %s:<font color="#ef51ef">%s</font> %s:<font color="#f77542">%s</font><br>%s %s:<font color="#adaead">%s</font> %s:<font color="#ef51ef">%s</font><br></center>', $rid, $rid, $ColorDef, $LNG['sys_mess_attack_report'], sprintf($LNG['sys_adress_planet'], $this->_fleet['fleet_end_galaxy'], $this->_fleet['fleet_end_system'], $this->_fleet['fleet_end_planet']), $ColorDef, $LNG['sys_perte_attaquant'], pretty_number($result['lost']['att']), $ColorAtt, $LNG['sys_perte_defenseur'], pretty_number($result['lost']['def']), $LNG['sys_gain'], $LNG['Metal'], pretty_number($steal['metal']), $LNG['Crystal'], pretty_number($steal['crystal']), $LNG['Deuterium'], pretty_number($steal['deuterium']), $LNG['sys_debris'], $LNG['Metal'], pretty_number($result['debree']['att'][0]+$result['debree']['def'][0]), $LNG['Crystal'], pretty_number($result['debree']['att'][1]+$result['debree']['def'][1]));
			SendSimpleMessage($DefenderID, 0, $this->_fleet['fleet_start_time'], 3, $LNG['sys_mess_tower'], $LNG['sys_mess_attack_report'], $MessageDef);
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
		$Message		= sprintf($LNG['sys_fleet_won'], $TargetName, GetTargetAdressLink($this->_fleet, ''),pretty_number($this->_fleet['fleet_resource_metal']), $LNG['Metal'],pretty_number($this->_fleet['fleet_resource_crystal']), $LNG['Crystal'],pretty_number($this->_fleet['fleet_resource_deuterium']), $LNG['Deuterium'] );
		SendSimpleMessage($this->_fleet['fleet_owner'], 0, $this->_fleet['fleet_end_time'], 3, $LNG['sys_mess_tower'], $LNG['sys_mess_fleetback'], $Message);
			
		$this->RestoreFleet();
	}
}

?>