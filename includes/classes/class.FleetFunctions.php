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

	private static function GetAvailableMissions($MissionInfo)
	{
		global $lang, $db;
		$GetInfoPlanet 			= $db->fetch_array($db->query("SELECT `id_owner` FROM `".PLANETS."` WHERE `galaxy` = ".$MissionInfo['galaxy']." AND `system` = ".$MissionInfo['system']." AND `planet` = ".$MissionInfo['planet']." AND `planet_type` = '1';"));
		$YourPlanet				= (isset($GetInfoPlanet['id_owner']) && $GetInfoPlanet['id_owner'] == $MissionInfo['CurrentUser']['id']) ? true : false;
		$UsedPlanet				= (isset($GetInfoPlanet['id_owner'])) ? true : false;
		
		if ($MissionInfo['planet'] == 16)
			$missiontype[15] = $lang['type_mission'][15];	
		elseif ($MissionInfo['planettype'] == 2) {
			if (isset($MissionInfo['Ship'][209]) || isset($MissionInfo['Ship'][219]))
				$missiontype[8] = $lang['type_mission'][8];

		} else {
			if (!$UsedPlanet) {
				if (isset($MissionInfo['Ship'][208]) && $MissionInfo['planettype'] == 1)
					$missiontype[7] = $lang['type_mission'][7];
			} else {
				
				$missiontype[3] = $lang['type_mission'][3];

				if ($YourPlanet && $MissionInfo['planettype'] == 3 && self::OnlyShipByID($MissionInfo['Ship'], 220))
					$missiontype[11] = $lang['type_mission'][11];
					
				if (!$YourPlanet && self::OnlyShipByID($MissionInfo['Ship'], 210))
					$missiontype[6] = $lang['type_mission'][6];

				if (!$YourPlanet) {
					$missiontype[1] = $lang['type_mission'][1];
					$missiontype[5] = $lang['type_mission'][5];}
				else {
					$missiontype[4] = $lang['type_mission'][4];}
					
				if ($MissionInfo['IsAKS'] != "0:0:0" && $UsedPlanet)
					$missiontype[2] = $lang['type_mission'][2];

				if (!$YourPlanet && $MissionInfo['planettype'] == 3 && isset($MissionInfo['Ship'][214]))
					$missiontype[9] = $lang['type_mission'][9];
			}
		}
				
		if (empty($missiontype))
			exit(header("location:game.php?page=fleet"));
			
		return $missiontype;
	}	
	
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
		switch($Ship){
			case "202":
				return $pricelist[$Ship]['speed'] * (($Player['impulse_motor_tech'] >= 5) ? (1 + (0.2 * $Player['impulse_motor_tech'])) : (1 + (0.1 * $Player['combustion_tech'])));
			break;
			case "203":
			case "204":
			case "209":
			case "210":
				return $pricelist[$Ship]['speed'] * (1 + (0.1 * $Player['combustion_tech']));
			break;
			case "205":
			case "206":
			case "208":
			case "221":
			case "222":
			case "224":
				return $pricelist[$Ship]['speed'] * (1 + (0.2 * $Player['impulse_motor_tech']));
			break;
			case "211":
				return $pricelist[$Ship]['speed'] * (($Player['hyperspace_motor_tech'] >= 8) ? (1 + (0.3 * $Player['hyperspace_motor_tech'])) : (1 + (0.2 * $Player['impulse_motor_tech'])));
			break;
			case "207":
			case "213":
			case "214":
			case "215":
			case "216":
			case "217":
			case "218":
			case "219":
			case "220":
				return $pricelist[$Ship]['speed'] * (1 + (0.3 * $Player['hyperspace_motor_tech']));
			break;
		}
	}
	
	public static function GetAvailableSpeeds()
	{
		return array(10 => 100, 9 => 90, 8 => 80, 7 => 70, 6 => 60, 5 => 50, 4 => 40, 3 => 30, 2 => 20, 1 => 10);
	}
	
	Public static function CheckUserSpeed()
	{
		return (in_array($GenFleetSpeed, self::GetAvailableSpeeds())) ? true : false;
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

	public static function GetMissionDuration($SpeedFactor, $MaxFleetSpeed, $Distance, $GameSpeed)
	{
		return max(((3500 / ($SpeedFactor * 0.1)) * pow($Distance * 10 / $MaxFleetSpeed, 0.5) + 10) / $GameSpeed, 5);
	}

	public static function GetGameSpeedFactor()
	{
		global $game_config;
		return $game_config['fleet_speed'] / 2500;
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
			$spd               = 35000 / (round($MissionDuration,0) * $GameSpeed - 10) * sqrt($MissionDistance * 10 / $ShipSpeed);
			$basicConsumption  = $ShipConsumption * $Count;
			$consumption      += $basicConsumption * $MissionDistance / 35000 * (($spd / 10) + 1) * (($spd / 10) + 1);
		}
		return (round($consumption) + 1);
	}

	public static function GetFleetArray($FleetArray)
	{
		return unserialize(base64_decode(str_rot13($FleetArray)));
	}
	
	public static function SetFleetArray($FleetArray)
	{
		return str_rot13(base64_encode(serialize($FleetArray)));
	}	

	public static function CleanFleetArray($FleetArray)
	{
		foreach($FleetArray as $ShipID => $Count) {
			if ($Count <= 0) unset($FleetArray[$ShipID]);
		}
		return $FleetArray;
	}
	
	public static function GetFleetMissions($MisInfo, $TargetMission)
	{
		global $lang, $resource;
		$Missions 			= self::GetAvailableMissions($MisInfo);
		$MissionSelector 	= "";
		$i = 0;
		
		foreach ($Missions as $a => $b)
		{
			$MissionSelector .= "<tr height=\"20\">
								 <th>
								 <input id=\"inpuT_".$i."\" type=\"radio\" name=\"mission\" value=\"".$a."\"". (($TargetMission == $a) ? " checked" : "") .">
								 <label for=\"inpuT_".$i."\">".$b."</label><br>"
								 .(($a == 15) ? "<br><p style=\"color:red;padding-left:13px;\">".$lang['fl_expedition_alert_message']."</p><br>" : "")."</th>"
								 .(($a == 11) ? "<br><p style=\"color:red;padding-left:13px;\">".$lang['fl_dm_alert_message']."</p><br>" : "")."</th>
								 </tr>";
			$i++;
		}

		if (!empty($Missions[15]))
		{
			$StayBlock  = "<tr height=\"20\">";
			$StayBlock .= "<td class=\"c\" colspan=\"3\">".$lang['fl_hold_time']."</td>";
			$StayBlock .= "</tr>";
			$StayBlock .= "<tr height=\"20\">";
			$StayBlock .= "<th colspan=\"3\">";
			$StayBlock .= "<select name=\"expeditiontime\" >";
			for($i = 1;$i <= $MisInfo['CurrentUser'][$resource[124]];$i++){	
				$StayBlock .= "<option value=\"".$i."\">".$i."</option>";
			}
			$StayBlock .= "</select>";
			$StayBlock .= "Stunde(n)";
			$StayBlock .= "</th>";
			$StayBlock .= "</tr>";
		}
		elseif(!empty($Missions[5]))
		{
			$StayBlock  = "<tr height=\"20\">";
			$StayBlock .= "<td class=\"c\" colspan=\"3\">".$lang['fl_hold_time']."</td>";
			$StayBlock .= "</tr>";
			$StayBlock .= "<tr height=\"20\">";
			$StayBlock .= "<th colspan=\"3\">";
			$StayBlock .= "<select name=\"holdingtime\" >";
			$StayBlock .= "<option value=\"0\">0</option>";
			$StayBlock .= "<option value=\"1\">1</option>";
			$StayBlock .= "<option value=\"2\">2</option>";
			$StayBlock .= "<option value=\"4\">4</option>";
			$StayBlock .= "<option value=\"8\">8</option>";
			$StayBlock .= "<option value=\"16\">16</option>";
			$StayBlock .= "<option value=\"32\">32</option>";
			$StayBlock .= "</select>";
			$StayBlock .= "Stunde(n)";
			$StayBlock .= "</th>";
			$StayBlock .= "</tr>";
		}
		
		return array('MissionSelector' => $MissionSelector, 'StayBlock' => $StayBlock);
	}	
	
	public static function GetUserShotcut($Shortcuts)
	{
		global $lang;
		
		$ShortCut = "";
		
		if ($Shortcuts)
		{
			$scarray = explode("\r\n", $Shortcuts);
			$i = 0;
			foreach ($scarray as $a => $b)
			{
				if ($b != "")
				{
					$c = explode(',', $b);
					if ($i == 0)
						$ShortCut .= "<tr height=\"20\">";

					$ShortCut .= "<th><a href=\"javascript:setTarget(". $c[1] .",". $c[2] .",". $c[3] .",". $c[4] ."); shortInfo();\"";
					$ShortCut .= ">". $c[0] ." ". $c[1] .":". $c[2] .":". $c[3] ." ";

					if ($c[4] == 1)
						$ShortCut .= $lang['fl_planet_shortcut'];
					elseif ($c[4] == 2)
						$ShortCut .= $lang['fl_debris_shortcut'];
					elseif ($c[4] == 3)
						$ShortCut .= $lang['fl_moon_shortcut'];

					$ShortCut .= "</a></th>";

					if ($i == 1)
						$ShortCut .= "</tr>";

					if ($i == 1)
						$i = 0;
					else
						$i = 1;
				}
			}
			if ($i == 1)
				$ShortCut .= "<th></th></tr>";
		}
		else
		{
			$ShortCut .= "<tr height=\"20\">";
			$ShortCut .= "<th colspan=\"2\">".$lang['fl_no_shortcuts']."</th>";
			$ShortCut .= "</tr>";
		}
		
		return $ShortCut;
	}
	
	public static function GetColonyList($CurrentUser)
	{
		global $lang, $db;

		$ColonyList 	= "";
		
		$Colony 		= SortUserPlanets($CurrentUser);

		if (count($Colony) > 1)
		{
			$i = 0;
			$w = 0;
			$tr = true;
			foreach($Colony as $CurPlanetID => $CurPlanet)
			{
				if ($w == 0 && $tr)
				{
					$ColonyList .= "<tr height=\"20\">";
					$tr = false;
				} 
				elseif ($w == 2)
				{
					$ColonyList .= "</tr>";
					$w = 0;
					$tr = true;
				}

				if ($CurPlanet['planet_type'] == 3)
					$CurPlanet['name'] .= " ". $lang['fl_moon_shortcut'];

				if (!($CurrentPlanet['galaxy'] == $CurPlanet['galaxy'] && $CurrentPlanet['system'] == $CurPlanet['system'] &&
					$CurrentPlanet['planet'] == $CurPlanet['planet'] && $CurrentPlanet['planet_type'] == $CurPlanet['planet_type']))
				{
					$ColonyList .= "<th><a href=\"javascript:setTarget(". $CurPlanet['galaxy'] .",". $CurPlanet['system'] .",". $CurPlanet['planet'] .",". $CurPlanet['planet_type'] ."); shortInfo();\">". $CurPlanet['name'] ." ". $CurPlanet['galaxy'] .":". $CurPlanet['system'] .":". $CurPlanet['planet'] ."</a></th>";
					$w++;
					$i++;
				}
			}

			if ($i % 2 != 0)
				$ColonyList .= "<th>&nbsp;</th></tr>";
			elseif ($w == 2)
				$ColonyList .= "</tr>";
		}
		else
			$ColonyList .= "<th colspan=\"2\">".$lang['fl_no_colony']."</th>";
			
		return $ColonyList;
	}
	
	public static function IsAKS($CurrentUserID)
	{
		global $db;
		$aks_madnessred = $db->query("SELECT * FROM ".AKS.";");

		$aks_fleets_mr = '';

		while($row = $db->fetch_array($aks_madnessred))
		{
			$members = explode(",", $row['eingeladen']);
			foreach($members as $a => $b)
			{
				if ($b == $CurrentUserID)
				{
					$aks_fleets_mr .= "<tr height=\"20\">";
					$aks_fleets_mr .= "<th colspan=\"2\">";
					$aks_fleets_mr .= "<a href=\"javascript:";
					$aks_fleets_mr .= "setTarget(". $row['galaxy'] .",". $row['system'] .",". $row['planet'] ."); ";
					$aks_fleets_mr .= "shortInfo(); ";
					$aks_fleets_mr .= "setACS(". $row['id'] ."); ";
					$aks_fleets_mr .= "setACS_target('"."g". $row['galaxy'] ."s". $row['system'] ."p". $row['planet'] ."t". $row['planet_type'] ."');";
					$aks_fleets_mr .= "\">";
					$aks_fleets_mr .= "(".$row['name'].")";
					$aks_fleets_mr .= "</a>";
					$aks_fleets_mr .= "</th>";
					$aks_fleets_mr .= "</tr>";
				}
			}
		}
			
		return (!empty($aks_fleets_mr) ? $aks_fleets_mr : "");
	}

	public static function GetCurrentFleets($CurrentUserID, $Mission = 0)
	{
		global $db;

		$ActualFleets = $db->num_rows($db->query("SELECT fleet_id FROM ".FLEETS." WHERE `fleet_owner`='".$CurrentUserID."'".(($Mission != 0)?" AND `fleet_mission` = '".$Mission."'":"")." AND `fleet_mission` <> 10;"));
		return $ActualFleets;
	}	
	
	public static function SendFleetBack($CurrentUser, $FleetID)
	{
		global $db;	

		$FleetRow = $db->fetch_array($db->query("SELECT * FROM ".FLEETS." WHERE `fleet_id` = '". $FleetID ."';"));
		if ($FleetRow['fleet_owner'] == $CurrentUser['id'] && $FleetRow['fleet_mess'] == 0)
		{
			if($FleetRow['fleet_group'] > 0)
			{
				$Aks = $db->fetch_array($db->query("SELECT teilnehmer FROM ".AKS." WHERE id = '". $FleetRow['fleet_group'] ."';"));

				if ($Aks['teilnehmer'] == $FleetRow['fleet_owner'] && $FleetRow['fleet_mission'] == 1)
				{
					$db->query("DELETE FROM ".AKS." WHERE id ='". $FleetRow['fleet_group'] ."';");
					$db->query("UPDATE ".FLEETS." SET `fleet_group` = '0' WHERE `fleet_group` = '". $FleetRow['fleet_group'] ."';");
				}
				if ($FleetRow['fleet_mission'] == 2)
				{
					$db->query("UPDATE ".FLEETS." SET `fleet_group` = '0' WHERE `fleet_id` = '".  $FleetID ."';");
				}
			}
			$CurrentFlyingTime = time() - $FleetRow['start_time'];

			$ReturnFlyingTime  = $CurrentFlyingTime + time();
			$QryUpdateFleet  = "UPDATE ".FLEETS." SET ";
			$QryUpdateFleet .= "`fleet_start_time` = '". (time() - 1) ."', ";
			$QryUpdateFleet .= "`fleet_end_stay` = '0', ";
			$QryUpdateFleet .= "`fleet_end_time` = '". ($ReturnFlyingTime + 1) ."', ";
			$QryUpdateFleet .= "`fleet_mess` = '1' ";
			$QryUpdateFleet .= "WHERE ";
			$QryUpdateFleet .= "`fleet_id` = '" . $FleetID . "';";
			$db->query($QryUpdateFleet);
			
		}
	}
	
	public static function GetExtraInputs($FleetArray, $Player)
	{
		$FleetHiddenBlock = "";
		foreach ($FleetArray as $ShipID => $Amount)
		{
			$FleetHiddenBlock	.= "<input type=\"hidden\" name=\"consumption". $ShipID ."\" value=\"". self::GetShipConsumption($ShipID, $Player) ."\">\n";
			$FleetHiddenBlock	.= "<input type=\"hidden\" name=\"speed". $ShipID ."\"       value=\"". self::GetFleetMaxSpeed($ShipID, $Player) ."\">\n";
			$FleetHiddenBlock	.= "<input type=\"hidden\" name=\"ship". $ShipID ."\"        value=\"". $Amount ."\">\n";
		}
		return $FleetHiddenBlock;
	}
	
	public static function GotoFleetPage()
	{
		global $phpEx;
		if (!headers_sent()) {
			$temp = debug_backtrace();
			header("Location: game." . $phpEx . "?page=fleet");
			header("X-FAIL-AT-LINE: ".str_replace($_SERVER["DOCUMENT_ROOT"],'.',$temp[0]['file'])." on ".$temp[0]['line']);
		}
		exit;
	}

	function GetAKSPage($CurrentUser, $CurrentPlanet, $fleetid)
	{
		global $resource, $pricelist, $reslist, $phpEx, $lang, $db;

		$parse			= $lang;
		$fleetid 		= $fleetid;
		$addname		= request_var('addtogroup','');
		$aks_invited_mr	= request_var('aks_invited_mr',0);

		if(!empty($addname))
		{
			$member_qry_mr 		= $db->fetch_array($db->query("SELECT `id` FROM ".USERS." WHERE `username` ='".$db->sql_escape($addname)."' ;"));
			$added_user_id_mr 	= $member_qry_mr['id'];

			if(empty($added_user_id_mr))
				$add_user_message_mr = "<font color=\"red\">".$lang['fl_player']." ".$addname." ".$lang['fl_dont_exist'];
			else
			{
				$new_eingeladen_mr = $aks_invited_mr.','.$added_user_id_mr;
				$db->query("UPDATE ".AKS." SET `eingeladen` = '".$db->sql_escape($new_eingeladen_mr)."' ;");
				$add_user_message_mr = "<font color=\"lime\">".$lang['fl_player']." ".$addname." ". $lang['fl_add_to_attack'];
				$invite_message = $lang['fl_player'] . $CurrentUser['username'] . $lang['fl_acs_invitation_message'];
				SendSimpleMessage ($added_user_id_mr, $CurrentUser['id'], time(), 1, $CurrentUser['username'], $lang['fl_acs_invitation_title'], $invite_message);
			}
		}

		$query = $db->query("SELECT * FROM ".FLEETS." WHERE fleet_id = '" . $fleetid . "';");

		if ($db->num_rows($query) != 1)
			exit(header("Location: game.".$phpEx."?page=fleet"));

		$daten = $db->fetch_array($query);

		if ($daten['fleet_start_time'] <= time() || $daten['fleet_end_time'] < time() || $daten['fleet_mess'] == 1)
			exit(header("Location: game.".$phpEx."?page=fleet"));

		if (empty($daten['fleet_group']))
		{
			$rand 			= mt_rand(100000, 999999999);
			$aks_code_mr 	= "AG".$rand;
			$aks_invited_mr = $CurrentUser['id'];

			$db->multi_query(
			"INSERT INTO ".AKS." SET
			`name` = '" . $aks_code_mr . "',
			`teilnehmer` = '" . $CurrentUser['id'] . "',
			`flotten` = '" . $fleetid . "',
			`ankunft` = '" . $daten['fleet_start_time'] . "',
			`galaxy` = '" . $daten['fleet_end_galaxy'] . "',
			`system` = '" . $daten['fleet_end_system'] . "',
			`planet` = '" . $daten['fleet_end_planet'] . "',
			`planet_type` = '" . $daten['fleet_end_type'] . "',
			`eingeladen` = '" . $aks_invited_mr . "';
			UPDATE ".FLEETS." SET
			`fleet_group` = '" . $aks['id'] . "'
			WHERE
			`fleet_id` = '" . $fleetid . "';");

			$aks = array(
				'name' 			=> $aks_code_mr,
				'eingeladen' 	=> $CurrentUser['id'],
			);
		}
		else
		{
			$aks = $db->query("SELECT `eingeladen`, `name` FROM ".AKS." WHERE `id` = '" . $fleet['fleet_group'] . "';");

			if ($db->num_rows($aks) != 1)
				exit(header("Location: game.".$phpEx."?page=fleet"));
		}

		$members = explode(",", $aks['eingeladen']);
		foreach($members as $a => $b)
		{
			if (!empty($b))
			{
				$member_qry_mr = $db->query("SELECT `username` FROM ".USERS." WHERE `id` ='".$b."' ;");
				while($row = $db->fetch_array($member_qry_mr))
				{
					$pageDos .= "<option>".$row['username']."</option>";
				}
			}
		}

		$AKSArray	= array(
			'selector'				=> $pageDos,
			'fleetid'				=> $fleetid,
			'aks_invited_mr'		=> $aks['eingeladen'],
			'aks_code_mr'			=> $aks['name'],
			'add_user_message_mr'	=> $add_user_message_mr,
		);
		return $AKSArray;
	}
}
?>