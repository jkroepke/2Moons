<?php

##############################################################################
# *																			 #
# * RN FRAMEWORK															 #
# *  																		 #
# * @copyright Copyright (C) 2009 By ShadoX from xnova-reloaded.de	    	 #
# *																			 #
# *																			 #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.									 #
# *																			 #
# *  This program is distributed in the hope that it will be useful,		 #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of			 #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 #
# *  GNU General Public License for more details.							 #
# *																			 #
##############################################################################

abstract class FleetFunctions 
{
	private static function GetShipConsumption($Ship, $Player)
	{
		global $pricelist;

		return (($Player['impulse_motor_tech'] >= 5 && $Ship == 202) || ($Player['hyperspace_motor_tech'] >= 8 && $Ship == 211)) ? $pricelist[$Ship]['consumption2'] : $pricelist[$Ship]['consumption'];
	}

	private static function OnlyShipByID($Ships, $ShipID)
	{
		foreach($Ships as $Ship => $Amount){
			if($ShipID != $Ship && $Amount != 0) return false;
		}
			
		return true;
	}

	private static function GetShipSpeed($Ship, $Player)
	{
		global $pricelist;
		switch($Ship)
		{
			case 202:
				return (($Player['impulse_motor_tech'] >= 5) ? $pricelist[$Ship]['speed2'] * (1 + (0.2 * $Player['impulse_motor_tech'])) : $pricelist[$Ship]['speed'] * (1 + (0.1 * $Player['combustion_tech'])));
			break;
			case 203:
			case 204:
			case 209:
			case 210:
			case 226:
				return $pricelist[$Ship]['speed'] * (1 + (0.1 * $Player['combustion_tech']));
			break;
			case 205:
			case 206:
			case 208:
				return $pricelist[$Ship]['speed'] * (1 + (0.2 * $Player['impulse_motor_tech']));
			break;
			case 211:
				return (($Player['hyperspace_motor_tech'] >= 8) ? $pricelist[$Ship]['speed2'] * (1 + (0.3 * $Player['hyperspace_motor_tech'])) : $pricelist[$Ship]['speed'] * (1 + (0.2 * $Player['impulse_motor_tech'])));
			break;
			case 207:
			case 213:
			case 214:
			case 215:
			case 216:
			case 217:
			case 218:
			case 219:
			case 220:
			default:
				return $pricelist[$Ship]['speed'] * (1 + (0.3 * $Player['hyperspace_motor_tech']));
			break;
		}
	}
	
	public static function GetAvailableSpeeds()
	{
		return array(10 => 100, 9 => 90, 8 => 80, 7 => 70, 6 => 60, 5 => 50, 4 => 40, 3 => 30, 2 => 20, 1 => 10);
	}
	
	Public static function CheckUserSpeed($GenFleetSpeed)
	{
		return (array_key_exists($GenFleetSpeed, self::GetAvailableSpeeds())) ? true : false;
	}

	public static function GetTargetDistance ($OrigGalaxy, $DestGalaxy, $OrigSystem, $DestSystem, $OrigPlanet, $DestPlanet)
	{
		if (($OrigGalaxy - $DestGalaxy) != 0)
			$distance = abs($OrigGalaxy - $DestGalaxy) * 20000;
		elseif (($OrigSystem - $DestSystem) != 0)
			$distance = abs($OrigSystem - $DestSystem) * 95 + 2700;
		elseif (($OrigPlanet - $DestPlanet) != 0)
			$distance = abs($OrigPlanet - $DestPlanet) * 5 + 1000;
		else
			$distance = 5;

		return $distance;
	}

	public static function GetMissionDuration($SpeedFactor, $MaxFleetSpeed, $Distance, $GameSpeed, $CurrentUser)
	{
		global $ExtraDM, $resource;
			return max(((((3500 / ($SpeedFactor * 0.1)) * pow($Distance * 10 / $MaxFleetSpeed, 0.5) + 10) * (((TIMESTAMP - $CurrentUser[$resource[706]] <= 0) ? (1 - $ExtraDM[706]['add']) : 1) - (GENERAL * $CurrentUser['rpg_general']))) / $GameSpeed), 5);
	}

	public static function GetGameSpeedFactor()
	{
		global $CONF;
		return $CONF['fleet_speed'] / 2500;
	}
	
	public static function GetMaxFleetSlots($CurrentUser)
	{
		global $resource;
		return (1 + $CurrentUser[$resource[108]]) + ($CurrentUser['rpg_commandant'] * COMMANDANT);
	}

	public static function GetFleetRoom($Fleet)
	{
		global $pricelist;
		$FleetRoom 				= 0;
		foreach ($Fleet as $ShipID => $amount)
		{
			$FleetRoom		   += $pricelist[$ShipID]['capacity'] * $amount;
		}
		return $FleetRoom;
	}
	
	public static function GetFleetMaxSpeed ($Fleets, $Player)
	{
		global $reslist, $pricelist;

		$FleetArray = (!is_array($Fleets)) ? array($Fleets => 1) : $Fleets;
		$speedalls 	= array();
		
		foreach ($FleetArray as $Ship => $Count) {
			$speedalls[$Ship] = self::GetShipSpeed($Ship, $Player);
		}
		
		return (is_array($Fleets)) ? min($speedalls) : $speedalls[$Ship];
	}

	public static function GetFleetConsumption($FleetArray, $MissionDuration, $MissionDistance, $FleetMaxSpeed, $Player, $GameSpeed)
	{
		$consumption = 0;
		$basicConsumption = 0;

		foreach ($FleetArray as $Ship => $Count)
		{
			$ShipSpeed         = self::GetShipSpeed($Ship, $Player);
			$ShipConsumption   = self::GetShipConsumption($Ship, $Player);
			$spd               = 35000 / (round($MissionDuration, 0) * $GameSpeed - 10) * sqrt($MissionDistance * 10 / $ShipSpeed);
			$basicConsumption  = $ShipConsumption * $Count;
			$consumption      += $basicConsumption * $MissionDistance / 35000 * (($spd / 10) + 1) * (($spd / 10) + 1);
		}
		return (round($consumption) + 1);
	}

	public static function GetFleetArray($FleetArray)
	{
		$FleetArray	= unserialize(base64_decode(str_rot13($FleetArray)));
		if(!is_array($FleetArray))
			self::GotoFleetPage();
		
		return $FleetArray;
	}
	
	public static function SetFleetArray($FleetArray)
	{
		return str_rot13(base64_encode(serialize($FleetArray)));
	}	

	public static function CleanFleetArray(&$FleetArray)
	{
		foreach($FleetArray as $ShipID => $Count) {
			if ($Count <= 0) unset($FleetArray[$ShipID]);
		}
	}
	
	public static function GetFleetMissions($MisInfo)
	{
		global $LNG, $resource, $CONF;
		$Missions 			= self::GetAvailableMissions($MisInfo);

		if (!empty($Missions[15])) {
			for($i = 1;$i <= $MisInfo['CurrentUser'][$resource[124]];$i++) {	
				$StayBlock[$i]	= $i / $CONF['halt_speed'];
			}
		}
		elseif(!empty($Missions[5]))
			$StayBlock = array(1 => 1, 2 => 2, 4 => 4, 8 => 8, 12 => 12, 16 => 16, 32 => 32);
		
		
		return array('MissionSelector' => $Missions, 'StayBlock' => $StayBlock);
	}	
	
	public static function GetUserShotcut($CurrentUser)
	{
		if (empty($CurrentUser['fleet_shortcut']))
			return array();

		$Shoutcut 		= explode("\r\n", $CurrentUser['fleet_shortcut']);
		$ShortCutList	= array();

		foreach ($Shoutcut as $a => $b)
		{
			if (empty($b)) continue;
			
			$ShortCutRow = explode(',', $b);
			
			$ShortCutList[] = array(
				'name'			=> $ShortCutRow[0],
				'galaxy'		=> $ShortCutRow[1],
				'system'		=> $ShortCutRow[2],
				'planet'		=> $ShortCutRow[3],
				'planet_type'	=> $ShortCutRow[4],
			);
		}
		return $ShortCutList;
	}
	
	public static function GetColonyList($Colony)
	{
		global $PLANET;
		foreach($Colony as $CurPlanetID => $CurPlanet)
		{
			if ($PLANET['galaxy'] == $CurPlanet['galaxy'] && $PLANET['system'] == $CurPlanet['system'] && $PLANET['planet'] == $CurPlanet['planet'] && $PLANET['planet_type'] == $CurPlanet['planet_type']) continue;
			
			$ColonyList[] = array(
				'name'			=> $CurPlanet['name'],
				'galaxy'		=> $CurPlanet['galaxy'],
				'system'		=> $CurPlanet['system'],
				'planet'		=> $CurPlanet['planet'],
				'planet_type'	=> $CurPlanet['planet_type'],
			);	
		}
			
		return $ColonyList;
	}
	
	public static function IsAKS($CurrentUserID)
	{
		global $db;
		
		$GetAKS 	= $db->query("SELECT a.`id`, a.`name`, a.`galaxy`, a.`system`, a.`planet`, a.`planet_type` FROM ".AKS." as a WHERE '".MAX_FLEETS_PER_ACS."' > (SELECT COUNT(*) FROM ".FLEETS." WHERE `fleet_group` = a.`id`) AND (a.`teilnehmer` = '".$CurrentUserID."' OR a.`eingeladen` LIKE '%,".$CurrentUserID.",%');");
		$AKSList	= array();
		
		while($row = $db->fetch_array($GetAKS))
		{
			$AKSList[]	= array(
				'id'			=> $row['id'],
				'name'			=> $row['name'],
				'galaxy'		=> $row['galaxy'],
				'system'		=> $row['system'],
				'planet'		=> $row['planet'],
				'planet_type'	=> $row['planet_type'],
			);
		}
		
		$db->free_result($GetAKS);
		
		return $AKSList;
	}

	public static function GetCurrentFleets($CurrentUserID, $Mission = 0)
	{
		global $db;

		$ActualFleets = $db->uniquequery("SELECT COUNT(*) as state FROM ".FLEETS." WHERE `fleet_owner` = '".$CurrentUserID."' AND ".(($Mission != 0)?"`fleet_mission` = '".$Mission."'":"`fleet_mission` != 10").";");
		return $ActualFleets['state'];
	}	
	
	public static function SendFleetBack($CurrentUser, $FleetID)
	{
		global $db;	

		$FleetRow = $db->uniquequery("SELECT `start_time`, `fleet_mission`, `fleet_group`, `fleet_owner`, `fleet_mess` FROM ".FLEETS." WHERE `fleet_id` = '". $FleetID ."';");
		if ($FleetRow['fleet_owner'] != $CurrentUser['id'] || $FleetRow['fleet_mess'] == 1)
			return;
			
		$where		= 'fleet_id';

		if($FleetRow['fleet_mission'] == 1 && $FleetRow['fleet_group'] > 0)
		{
			$Aks = $db->uniquequery("SELECT teilnehmer FROM ".AKS." WHERE id = '". $FleetRow['fleet_group'] ."';");

			if($Aks['teilnehmer'] == $FleetRow['fleet_owner'])
			{
				$db->query("DELETE FROM ".AKS." WHERE id ='". $FleetRow['fleet_group'] ."';");
				$FleetID	= $FleetRow['fleet_group'];
				$where		= 'fleet_group';
			}
		}
		
		$db->query("UPDATE ".FLEETS." SET `fleet_group` = '0', `start_time` = '".TIMESTAMP."', `fleet_end_stay` = '".TIMESTAMP."', `fleet_end_time` = '".((TIMESTAMP - $FleetRow['start_time']) + TIMESTAMP)."', `fleet_mess` = '1' WHERE `".$where."` = '".$FleetID."';");
	}
	
	public static function GetFleetShipInfo($FleetArray, $Player)
	{
		$FleetInfo	= array();
		foreach ($FleetArray as $ShipID => $Amount) {
			$FleetInfo[$ShipID]	= array('consumption' => self::GetShipConsumption($ShipID, $Player), 'speed' => self::GetFleetMaxSpeed($ShipID, $Player), 'amount' => floattostring($Amount));
		}
		return $FleetInfo;
	}
	
	public static function GotoFleetPage()
	{
		redirectTo("game.".PHP_EXT."?page=fleet");
	}

	public static function GetAKSPage($CurrentUser, $CurrentPlanet, $fleetid)
	{
		global $resource, $pricelist, $reslist, $LNG, $db;

		$addname		= request_var('addtogroup', '', UTF8_SUPPORT);
		$aks_invited_mr	= request_var('aks_invited_mr', 0);
		$name			= request_var('name', '', UTF8_SUPPORT);
		

		$query = $db->query("SELECT * FROM ".FLEETS." WHERE fleet_id = '" . $fleetid . "';");

		if ($db->num_rows($query) != 1)
			self::GotoFleetPage();

		$daten = $db->fetch_array($query);

		if ($daten['fleet_start_time'] <= TIMESTAMP || $daten['fleet_end_time'] < TIMESTAMP || $daten['fleet_mess'] == 1)
			self::GotoFleetPage();
				
		if (empty($daten['fleet_group']))
		{
			$rand 			= mt_rand(100000, 999999999);
			$aks_code_mr 	= "AG".$rand;
			$aks_invited_mr = $CurrentUser['id'];

			$db->query(
			"INSERT INTO ".AKS." SET
			`name` = '" . $aks_code_mr . "',
			`teilnehmer` = '" . $CurrentUser['id'] . "',
			`ankunft` = '" . $daten['fleet_start_time'] . "',
			`galaxy` = '" . $daten['fleet_end_galaxy'] . "',
			`system` = '" . $daten['fleet_end_system'] . "',
			`planet` = '" . $daten['fleet_end_planet'] . "',
			`planet_type` = '" . $daten['fleet_end_type'] . "',
			`eingeladen` = '".$aks_invited_mr.",';
			");

			$db->query("UPDATE ".FLEETS." SET
			`fleet_group` = (SELECT `id` FROM ".AKS." aks WHERE aks.name = '".$aks_code_mr."')
			WHERE
			`fleet_id` = '" . $fleetid . "';");
			
			$aks = array(
				'name' 			=> $aks_code_mr,
				'eingeladen' 	=> $CurrentUser['id'],
			);
		}
		else
		{
			$AKSRAW = $db->query("SELECT `id`, `eingeladen`, `name` FROM ".AKS." WHERE `id` = '" . $daten['fleet_group'] . "';");

			if ($db->num_rows($AKSRAW) != 1)
				self::GotoFleetPage();
			
			$aks	= $db->fetch_array($AKSRAW);
		}
	
		if(!empty($name)) {
			if(UTF8_SUPPORT && !ctype_alnum($name)) {
				exit($LNG['fl_acs_newname_alphanum']);
			}
			$db->query("UPDATE ".AKS." SET `name` = '".$db->sql_escape($name)."' WHERE `id` = '".$daten['fleet_group']."';");
			exit;
		}	

		if(!empty($addname))
		{
			$member_qry_mr 		= $db->uniquequery("SELECT `id` FROM ".USERS." WHERE `username` = '".$db->sql_escape($addname)."';");
			$added_user_id_mr 	= $member_qry_mr['id'];
			
			foreach(explode(",", $aks['eingeladen']) as $a => $b)
			{
				if (!empty($b) && $added_user_id_mr == $b)
					redirectTo("game.php?page=fleet&action=getakspage&fleetid=".$daten['fleet_id']);
			}

			if(empty($added_user_id_mr))
				$add_user_message_mr = "<font color=\"red\">".$LNG['fl_player']." ".$addname." ".$LNG['fl_dont_exist'];
			else
			{
				$aks['eingeladen'] = $aks['eingeladen'].$added_user_id_mr.',';
				$db->query("UPDATE ".AKS." SET `eingeladen` = '".$aks['eingeladen']."' WHERE `id` = '".$daten['fleet_group']."';");
				$add_user_message_mr = "<font color=\"lime\">".$LNG['fl_player']." ".$addname." ". $LNG['fl_add_to_attack'];
				$invite_message = $LNG['fl_player'] . $CurrentUser['username'] . $LNG['fl_acs_invitation_message'];
				SendSimpleMessage ($added_user_id_mr, $CurrentUser['id'], TIMESTAMP, 1, $CurrentUser['username'], $LNG['fl_acs_invitation_title'], $invite_message);
			}
		}
		$members = explode(",", $aks['eingeladen']);
		foreach($members as $a => $b)
		{
			if (empty($b))
				continue;

			$member_qry_mr = $db->query("SELECT `username` FROM ".USERS." WHERE `id` ='".$b."' ;");
			while($row = $db->fetch_array($member_qry_mr))
			{
				$pageDos .= "<option>".$row['username']."</option>";
			}
		}

		$AKSArray	= array(
			'selector'				=> $pageDos,
			'fleetid'				=> $fleetid,
			'aks_invited_mr'		=> $aks['eingeladen'],
			'aks_code_mr'			=> $aks['name'],
			'add_user_message_mr'	=> $add_user_message_mr,
			'fl_acs_change'			=> $LNG['fl_acs_change'],
			'fl_acs_change_name'	=> $LNG['fl_acs_change_name'],
			'fl_invite_members'		=> $LNG['fl_invite_members'],
			'fl_members_invited'	=> $LNG['fl_members_invited'],
			'fl_modify_sac_name'	=> $LNG['fl_modify_sac_name'],
			'fl_sac_of_fleet'		=> $LNG['fl_sac_of_fleet'],
			'fl_continue'			=> $LNG['fl_continue'],
		);
		return $AKSArray;
	}
	
	public static function GetAvailableMissions($MissionInfo)
	{
		global $LNG, $db, $UNI;
		$GetInfoPlanet 			= $db->uniquequery("SELECT `id_owner`, `der_metal`, `der_crystal` FROM `".PLANETS."` WHERE `universe` = '".$UNI."' AND `galaxy` = ".$MissionInfo['galaxy']." AND `system` = ".$MissionInfo['system']." AND `planet` = ".$MissionInfo['planet']." AND `planet_type` = '1';");
		$YourPlanet				= (isset($GetInfoPlanet['id_owner']) && $GetInfoPlanet['id_owner'] == $MissionInfo['CurrentUser']['id']) ? true : false;
		$UsedPlanet				= (isset($GetInfoPlanet['id_owner'])) ? true : false;
		
		if ($MissionInfo['planet'] == (MAX_PLANET_IN_SYSTEM + 1) && !CheckModule(30))
			$missiontype[15] = $LNG['type_mission'][15];	
		elseif ($MissionInfo['planettype'] == 2) {
			if ((isset($MissionInfo['Ship'][209]) || isset($MissionInfo['Ship'][219])) && !CheckModule(32) && !($GetInfoPlanet['der_metal'] == 0 && $GetInfoPlanet['der_crystal'] == 0))
				$missiontype[8] = $LNG['type_mission'][8];
		} else {
			if (!$UsedPlanet) {
				if (isset($MissionInfo['Ship'][208]) && $MissionInfo['planettype'] == 1 && !CheckModule(35))
					$missiontype[7] = $LNG['type_mission'][7];
			} else {
				if(!CheckModule(34))
					$missiontype[3] = $LNG['type_mission'][3];
					
				if (!$YourPlanet && self::OnlyShipByID($MissionInfo['Ship'], 210) && !CheckModule(24))
					$missiontype[6] = $LNG['type_mission'][6];

				if (!$YourPlanet) {
					if(!CheckModule(1))
						$missiontype[1] = $LNG['type_mission'][1];
					if(!CheckModule(32))
						$missiontype[5] = $LNG['type_mission'][5];}
						
				elseif(!CheckModule(36)) {
					$missiontype[4] = $LNG['type_mission'][4];}
					
				if (!empty($MissionInfo['IsAKS']) && !$YourPlanet && !CheckModule(1))
					$missiontype[2] = $LNG['type_mission'][2];

				if (!$YourPlanet && $MissionInfo['planettype'] == 3 && isset($MissionInfo['Ship'][214]) && !CheckModule(29))
					$missiontype[9] = $LNG['type_mission'][9];

				if ($YourPlanet && $MissionInfo['planettype'] == 3 && self::OnlyShipByID($MissionInfo['Ship'], 220) && !CheckModule(31))
					$missiontype[11] = $LNG['type_mission'][11];
			}
		}
		
		return $missiontype;
	}
}
?>