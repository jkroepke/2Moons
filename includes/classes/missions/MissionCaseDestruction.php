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

class MissionCaseDestruction extends MissionFunctions
{
	function __construct($Fleet)
	{
		$this->_fleet	= $Fleet;
	}
	
	function TargetEvent()
	{
		global $pricelist, $resource, $reslist, $db;	
		$LNG			= $this->GetUserLang(0);
		$targetPlanet = $db->uniquequery("SELECT * FROM ".PLANETS." WHERE `galaxy` = ". $this->_fleet['fleet_end_galaxy'] ." AND `system` = ". $this->_fleet['fleet_end_system'] ." AND `planet_type` = ". $this->_fleet['fleet_end_type'] ." AND `planet` = ". $this->_fleet['fleet_end_planet'] .";");
		$targetUser   = $db->uniquequery("SELECT * FROM ".USERS." WHERE `id` = '".$targetPlanet['id_owner']."';");
		$TargetUserID = $targetUser['id'];
		$attackFleets = array();
	
		require_once(ROOT_PATH.'includes/classes/class.PlanetRessUpdate.'.PHP_EXT);
		
		$PlanetRess = new ResourceUpdate();
		list($TargetUser, $targetPlanet)	= $PlanetRess->CalcResource($TargetUser, $targetPlanet, $this->_fleet['fleet_start_time'])->SavePlanetToDB($TargetUser, $targetPlanet);

		
		$attackFleets[$this->_fleet['fleet_id']]['fleet'] = $this->_fleet;
		$attackFleets[$this->_fleet['fleet_id']]['user'] = $db->uniquequery('SELECT * FROM '.USERS.' WHERE id ='.$this->_fleet['fleet_owner'].';');
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
		
		$defense = array();

		$def = $db->query('SELECT * FROM '.FLEETS.' WHERE `fleet_end_galaxy` = '. $this->_fleet['fleet_end_galaxy'] .' AND `fleet_end_system` = '. $this->_fleet['fleet_end_system'] .' AND `fleet_end_type` = '. $this->_fleet['fleet_end_type'] .' AND `fleet_end_planet` = '. $this->_fleet['fleet_end_planet'] .' AND fleet_start_time<'.TIMESTAMP.' AND fleet_end_stay>='.TIMESTAMP.';');
		while ($defRow = $db->fetch($def))
		{
			$defRowDef = explode(';', $defRow['fleet_array']);
			foreach ($defRowDef as $Element)
			{
				$Element = explode(',', $Element);
				if ($Element[0] < 100) continue;

				if (!isset($defense[$defRow['fleet_id']]['def'][$Element[0]]))
					$defense[$defRow['fleet_id']][$Element[0]] = 0;

				$defense[$defRow['fleet_id']]['def'][$Element[0]] += $Element[1];
				$defense[$defRow['fleet_id']]['user'] = $db->uniquequery('SELECT * FROM '.USERS.' WHERE id='.$defRow['fleet_owner'].';');
			}
		}

		$defense[0]['def'] = array();
		$defense[0]['user'] = $targetUser;
		for ($i = 200; $i < 500; $i++)
		{
			if (isset($resource[$i]) && isset($targetPlanet[$resource[$i]]))
			{
				$defense[0]['def'][$i] = $targetPlanet[$resource[$i]];
			}
		}
		
		require_once('calculateAttack.'.PHP_EXT);

		$start 		= microtime(true);
		$result 	= calculateAttack($attackFleets, $defense);
		$totaltime 	= microtime(true) - $start;

		$DerbisMetal	  = $result['debree']['att'][0] + $result['debree']['def'][0];
		$DerbisCrystal	  = $result['debree']['att'][1] + $result['debree']['def'][1];
				
		$Qry = "UPDATE ".PLANETS." SET ";
		$Qry .= "`der_metal` = der_metal + ".floattostring($DerbisMetal).", ";
		$Qry .= "`der_crystal` = der_crystal + ".floattostring($DerbisCrystal)." ";
		$Qry .= "WHERE ";
		$Qry .= "`galaxy` = '" . $this->_fleet['fleet_end_galaxy'] . "' AND ";
		$Qry .= "`system` = '" . $this->_fleet['fleet_end_system'] . "' AND ";
		$Qry .= "`planet` = '" . $this->_fleet['fleet_end_planet'] . "' AND ";
		$Qry .= "`planet_type` = '1' ";
		$Qry .= "LIMIT 1;";
		$db->query($Qry);
				
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
		
		$FleetDebris      = $result['debree']['att'][0] + $result['debree']['def'][0] + $result['debree']['att'][1] + $result['debree']['def'][1];
		$StrAttackerUnits = sprintf ($LNG['sys_attacker_lostunits'], $result['lost']['att']);
		$StrDefenderUnits = sprintf ($LNG['sys_defender_lostunits'], $result['lost']['def']);
		$StrRuins         = sprintf ($LNG['sys_gcdrunits'], $result['debree']['def'][0] + $result['debree']['att'][0], $LNG['Metal'], $result['debree']['def'][1] + $result['debree']['att'][1], $LNG['Crystal']);
		$DebrisField      = $StrAttackerUnits ."<br>". $StrDefenderUnits ."<br>". $StrRuins;
		$steal 			  = array('metal' => 0, 'crystal' => 0, 'deuterium' => 0);
		switch ($result['won']) {
			case "a":
				$destructionl2 	= round((100 - sqrt($targetPlanet['diameter'])) * sqrt($attackFleets[$this->_fleet['fleet_id']]['detail'][214]), 1);
				$chance2  		= round(sqrt($TargetPlanet['diameter'])/2);                 
					
				if ($destructionl2 > 100) {
					$chance = 100;
				} elseif ($destructionl2 < 0) {
					$chance = 0;
				} else {
					$chance = $destructionl2;
				}
				$tirage 		= rand(0, 100);
				$tirage2  		= rand(0, 100);

				if($tirage <= $chance) {
					$db->multi_query("DELETE FROM ".PLANETS." WHERE `id` = '". $targetPlanet['id'] ."';UPDATE ".PLANETS." SET `id_luna` = '0' WHERE `id_luna` = '". $targetPlanet['id'] ."';UPDATE ".FLEETS." SET `fleet_start_type` = '1' WHERE `fleet_start_galaxy` = '".$this->_fleet['fleet_end_galaxy']."' AND `fleet_start_system` = '".$this->_fleet['fleet_end_system']."' AND `fleet_start_planet` = '".$this->_fleet['fleet_end_planet']."' AND `fleet_start_type` = '".$this->_fleet['fleet_end_type']."';UPDATE ".FLEETS." SET `fleet_end_time` = ('".TIMESTAMP."' - `start_time`) + '".TIMESTAMP."', `fleet_mess` = '1' WHERE `fleet_end_galaxy` = '".$this->_fleet['fleet_end_galaxy']."' AND `fleet_end_system` = '".$this->_fleet['fleet_end_system']."' AND `fleet_end_planet` = '".$this->_fleet['fleet_end_planet']."' AND `fleet_end_type` = '".$this->_fleet['fleet_end_type']."';");
					$destext .= sprintf ($LNG['sys_destruc_mess'], $DepName , $this->_fleet['fleet_start_galaxy'], $this->_fleet['fleet_start_system'], $this->_fleet['fleet_start_planet'], $this->_fleet['fleet_end_galaxy'], $this->_fleet['fleet_end_system'], $this->_fleet['fleet_end_planet'])."<br>";
					$destext .= sprintf ($LNG['sys_destruc_lune'], $chance) ."<br>";
					$destext .= $LNG['sys_destruc_mess1'];
					$destext .= $LNG['sys_destruc_reussi'];

					$probarip = sprintf ($LNG['sys_destruc_rip'], $chance2);
					if($tirage2 <= $chance2) {
						$destext .= $LNG['sys_destruc_echec'];
						$db->query("DELETE FROM ".FLEETS." WHERE `fleet_id` = '". $this->_fleet["fleet_id"] ."';");
					}
				} else {
			        $destructionrip = sqrt($TargetPlanet['diameter'])/2;
					$chance2  = round($destructionrip);                 
					$tirage2  = rand(0, 100);
					$probarip = sprintf ($LNG['sys_destruc_rip'], $chance2);
					$destext .= sprintf ($LNG['sys_destruc_mess'], $DepName , $this->_fleet['fleet_start_galaxy'], $this->_fleet['fleet_start_system'], $this->_fleet['fleet_start_planet'], $this->_fleet['fleet_end_galaxy'], $this->_fleet['fleet_end_system'], $this->_fleet['fleet_end_planet'])."<br>";
					$destext .= $LNG['sys_destruc_mess1'];
					$destext .= sprintf ($LNG['sys_destruc_lune'], $chance) ."<br>";
					if($tirage2 <= $chance2) {
						$destext .= $LNG['sys_destruc_echec'];
						$db->query("DELETE FROM ".FLEETS." WHERE `fleet_id` = '". $this->_fleet["fleet_id"] ."';");
					} else {
						$destext .= $LNG['sys_destruc_stop'];							
					}
				}
			break;
			case "r":
				$destext 		  .= sprintf ($LNG['sys_destruc_mess'], $DepName , $this->_fleet['fleet_start_galaxy'], $this->_fleet['fleet_start_system'], $this->_fleet['fleet_start_planet'], $this->_fleet['fleet_end_galaxy'], $this->_fleet['fleet_end_system'], $this->_fleet['fleet_end_planet'])."<br>";
				$destext 		  .= $LNG['sys_destruc_stop'] ."<br>";
			break;
			case "w":
				$destext 		  .= sprintf ($LNG['sys_destruc_mess'], $DepName , $this->_fleet['fleet_start_galaxy'], $this->_fleet['fleet_start_system'], $this->_fleet['fleet_start_planet'], $this->_fleet['fleet_end_galaxy'], $this->_fleet['fleet_end_system'], $this->_fleet['fleet_end_planet'])."<br>";
				$destext 		  .= $LNG['sys_destruc_stop'] ."<br>";
			break;
		}

		$MoonChance       = 0;
		$GottenMoon 	  = "";
		require_once('GenerateReport.'.PHP_EXT);
		$raport 		  = GenerateReport($result, $steal, $MoonChance, $GottenMoon, $totaltime, $this->_fleet, $LNG, $destext);

		$rid   = md5(microtime(true));
		$QryInsertRapport  = 'INSERT INTO '.RW.' SET ';
		$QryInsertRapport .= '`time` = '.$this->_fleet['fleet_start_time'].', ';
		foreach ($attackFleets as $fleetID => $attacker)
		{
			$USERs2[$attacker['user']['id']] = $attacker['user']['id'];
		}

		foreach ($defense as $fleetID => $defender)
		{
			$USERs2[$defender['user']['id']] = $defender['user']['id'];
		}
		$QryInsertRapport .= '`owners` = "'.implode(',', $USERs2).'", ';
		$QryInsertRapport .= '`rid` = "'. $rid .'", ';
		$QryInsertRapport .= '`raport` = "'. $db->sql_escape($raport) .'"';
		$db->query($QryInsertRapport);

		$raport  = '<a href # OnClick=\'f( "CombatReport.php?raport='. $rid .'", "");\'>';
		$raport .= '<center>';

		if     ($result['won'] == "a")
		{
			$raport .= '<font color=\'green\'>';
		}
		elseif ($result['won'] == "w")
		{
			$raport .= '<font color=\'orange\'>';
		}
		elseif ($result['won'] == "r")
		{
			$raport .= '<font color=\'red\'>';
		}

		$raport .= $LNG['sys_mess_destruc_report'] ." [". $this->_fleet['fleet_end_galaxy'] .":". $this->_fleet['fleet_end_system'] .":". $this->_fleet['fleet_end_planet'] ."] </font></a><br><br>";
		$raport .= "<font color=\"red\">". $LNG['sys_perte_attaquant'] .": ". $result['lost']['att'] ."</font>";
		$raport .= "<font color=\"green\">   ". $LNG['sys_perte_defenseur'] .": ". $result['lost']['def'] ."</font><br>" ;
		$raport .= $LNG['sys_debris'] ." ". $LNG['Metal'] .":<font color=\"#adaead\">". ($result['debree']['att'][0]+$result['debree']['def'][0]) ."</font>   ". $LNG['Crystal'] .":<font color=\"#ef51ef\">".( $result['debree']['att'][1]+$result['debree']['def'][1]) ."</font><br></center>";
		SendSimpleMessage($this->_fleet['fleet_owner'], '', $this->_fleet['fleet_start_time'], 3, $LNG['sys_mess_tower'], $LNG['sys_mess_attack_report'], $raport );


		$raport2  = "<a href # OnClick=\"f( 'CombatReport.php?raport=". $rid ."', '');\">";
		$raport2 .= "<center>";

		if	   ($result['won'] == "a")
		{
			$raport2 .= '<font color=\'red\'>';
		}
		elseif ($result['won'] == "w")
		{
			$raport2 .= '<font color=\'orange\'>';
		}
		elseif ($result['won'] == "r")
		{
			$raport2 .= '<font color=\'green\'>';
		}

		$raport2 .= $LNG['sys_mess_destruc_report'] ." [". $this->_fleet['fleet_end_galaxy'] .":". $this->_fleet['fleet_end_system'] .":". $this->_fleet['fleet_end_planet'] ."] </font></a><br><br>";

		SendSimpleMessage ( $TargetUserID, '', $this->_fleet['fleet_start_time'], 3, $LNG['sys_mess_tower'], $LNG['sys_mess_destruc_report'], $raport2 );
	}
	
	function EndStayEvent()
	{
		return;
	}
	
	function ReturnEvent()
	{
		$LNG			= $this->GetUserLang($this->_fleet['fleet_owner']);
		$Message		= sprintf($LNG['sys_fleet_won'], $TargetName, GetTargetAdressLink($this->_fleet, ''),pretty_number($this->_fleet['fleet_resource_metal']), $LNG['Metal'],pretty_number($this->_fleet['fleet_resource_crystal']), $LNG['Crystal'],pretty_number($this->_fleet['fleet_resource_deuterium']), $LNG['Deuterium'] );
		SendSimpleMessage($this->_fleet['fleet_owner'], '', $this->_fleet['fleet_end_time'], 3, $LNG['sys_mess_tower'], $LNG['sys_mess_fleetback'], $Message);
			
		$this->RestoreFleet();
	}
}

?>