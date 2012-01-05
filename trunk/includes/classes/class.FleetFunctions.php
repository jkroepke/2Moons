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

class FleetFunctions 
{
	static $allowedSpeed	= array(10 => 100, 9 => 90, 8 => 80, 7 => 70, 6 => 60, 5 => 50, 4 => 40, 3 => 30, 2 => 20, 1 => 10);
	
	private static function GetShipConsumption($Ship, $Player)
	{
		global $pricelist;

		return (($Player['impulse_motor_tech'] >= 5 && $Ship == 202) || ($Player['hyperspace_motor_tech'] >= 8 && $Ship == 211)) ? $pricelist[$Ship]['consumption2'] : $pricelist[$Ship]['consumption'];
	}

	private static function OnlyShipByID($Ships, $ShipID)
	{
		return isset($Ships[$ShipID]) && count($Ships) === 1;
	}

	private static function GetShipSpeed($Ship, $Player)
	{
		global $pricelist;
		
		$techSpeed	= $pricelist[$Ship]['tech'];
		
		if($techSpeed == 4) {
			$techSpeed = $Player['impulse_motor_tech'] >= 5 ? 2 : 1;
		}
		if($techSpeed == 5) {
			$techSpeed = $Player['hyperspace_motor_tech'] >= 8 ? 3 : 2;
		}
			
		
		switch($techSpeed)
		{
			case 1:
				$speed	= $pricelist[$Ship]['speed'] * (1 + (0.1 * $Player['combustion_tech']));
			break;
			case 2:
				$speed	= $pricelist[$Ship]['speed'] * (1 + (0.2 * $Player['impulse_motor_tech']));
			break;
			case 3:
				$speed	= $pricelist[$Ship]['speed'] * (1 + (0.3 * $Player['hyperspace_motor_tech']));
			break;
			default:
				$speed	= 0;
			break;
		}

		return $speed;
	}
	
	public static function CheckUserSpeed($speed)
	{
		return isset(self::$allowedSpeed[$speed]);
	}

	public static function GetTargetDistance($start, $target)
	{
		if ($start[0] != $target[0])
			return abs($start[0] - $target[0]) * 20000;
		
		if ($start[1] != $target[1])
			return abs($start[1] - $target[1]) * 95 + 2700;
		
		if ($start[2] != $target[2])
			return abs($start[2] - $target[2]) * 5 + 1000;

		return 5;
	}

	public static function GetMissionDuration($SpeedFactor, $MaxFleetSpeed, $Distance, $GameSpeed, $CurrentUser)
	{
		global $resource;
		$SpeedFactor	= (3500 / ($SpeedFactor * 0.1));
		$SpeedFactor	*= pow($Distance * 10 / $MaxFleetSpeed, 0.5);
		$SpeedFactor	+= 10;
		$SpeedFactor	/= $GameSpeed;
		
		return max($SpeedFactor, MIN_FLEET_TIME);
	}

	public static function GetGameSpeedFactor()
	{
		return $GLOBALS['CONF']['fleet_speed'] / 2500;
	}
	
	public static function GetMaxFleetSlots($CurrentUser)
	{
		global $resource, $pricelist;
		return (1 + $CurrentUser[$resource[108]]) + ($CurrentUser['rpg_commandant'] * $pricelist[611]['info']);
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
		$consumption2 = 0;
		$basicConsumption = 0;

		foreach ($FleetArray as $Ship => $Count)
		{
			$ShipSpeed         = self::GetShipSpeed($Ship, $Player);
			$ShipConsumption   = self::GetShipConsumption($Ship, $Player);
			
			$spd               = 35000 / (round($MissionDuration, 0) * $GameSpeed - 10) * sqrt($MissionDistance * 10 / $ShipSpeed);
			$basicConsumption  = $ShipConsumption * $Count;
			$consumption2     += $basicConsumption * $MissionDistance / 35000 * (($spd / 10) + 1) * (($spd / 10) + 1);
		}
		return (round($consumption + $consumption2) + 1);
	}

	public static function GetFleetArray($FleetArray)
	{
		$FleetArray	= unserialize(base64_decode(str_rot13($FleetArray)));
		if(!is_array($FleetArray))
			self::GotoFleetPage();
		
		return $FleetArray;
	}
	
	public static function GetFleetMissions($USER, $MisInfo, $Planet)
	{
		global $LNG, $resource, $CONF;
		$Missions	= self::GetAvailableMissions($USER, $MisInfo, $Planet);
		$stayBlock	= array();
		if (!empty($Missions[15])) {
			for($i = 1;$i <= $USER[$resource[124]];$i++) {	
				$StayBlock[$i]	= $i / $CONF['halt_speed'];
			}
		}
		elseif(!empty($Missions[5]))
			$stayBlock = array(1 => 1, 2 => 2, 4 => 4, 8 => 8, 12 => 12, 16 => 16, 32 => 32);
		
		
		return array('MissionSelector' => $Missions, 'StayBlock' => $stayBlock);
	}
	
	public static function GetACSDuration($FleetGroup)
	{
		global $db;
		if(empty($FleetGroup))
			return 0;
			
		$GetAKS 	= $db->countquery("SELECT ankunft FROM ".AKS." WHERE id = ".$FleetGroup.";");

		return !empty($GetAKS) ? $GetAKS - TIMESTAMP : 0;
	}
	
	public static function setACSTime($timeDifference, $FleetGroup)
	{
		global $db;

		if(empty($FleetGroup))
			return 0;
			
		$db->multi_query("UPDATE ".AKS." SET ankunft = ankunft + ".$timeDifference." WHERE id = ".$FleetGroup.";
						  UPDATE ".FLEETS.", ".FLEETS_EVENT." SET 
						  fleet_start_time = fleet_start_time + ".$timeDifference.",
						  fleet_end_stay   = fleet_end_stay + ".$timeDifference.",
						  fleet_end_time   = fleet_end_time + ".$timeDifference.",
						  time             = time + ".$timeDifference."
						  WHERE fleet_group = ".$FleetGroup." AND fleet_id = fleetID;");
	}

	public static function GetCurrentFleets($CurrentUserID, $Mission = 0)
	{
		global $db;

		$ActualFleets = $db->uniquequery("SELECT COUNT(*) as state FROM ".FLEETS." WHERE fleet_owner = '".$CurrentUserID."' AND ".(($Mission != 0)?"fleet_mission = '".$Mission."'":"fleet_mission != 10").";");
		return $ActualFleets['state'];
	}	
	
	public static function SendFleetBack($CurrentUser, $FleetID)
	{
		global $db;	

		$FleetRow = $db->uniquequery("SELECT start_time, fleet_mission, fleet_group, fleet_owner, fleet_mess FROM ".FLEETS." WHERE fleet_id = '". $FleetID ."';");
		if ($FleetRow['fleet_owner'] != $CurrentUser['id'] || $FleetRow['fleet_mess'] == 1)
			return;
			
		$sqlWhere	= 'fleet_id';

		if($FleetRow['fleet_mission'] == 1 && $FleetRow['fleet_group'] != 0)
		{
			$acsResult = $db->countquery("SELECT COUNT(*) FROM ".USERS_ACS." WHERE acsID = ".$FleetRow['fleet_group'].";");

			if($acsResult != 0)
			{
				$db->multi_query("DELETE FROM ".AKS." WHERE id = ".$FleetRow['fleet_group'].";
								  DELETE FROM ".USERS_ACS." WHERE acsID = ".$FleetRow['fleet_group'].";");
				
				$FleetID	= $FleetRow['fleet_group'];
				$sqlWhere	= 'fleet_group';
			}
		}
		
		$fleetEndTime	= (TIMESTAMP - $FleetRow['start_time']) + TIMESTAMP;
		
		$db->multi_query("UPDATE ".FLEETS.", ".FLEETS_EVENT." SET 
						  fleet_group = 0,
						  fleet_end_stay = ".TIMESTAMP.",
						  fleet_end_time = ".$fleetEndTime.", 
						  fleet_mess = 1,
						  time = ".$fleetEndTime."
						  WHERE ".$sqlWhere." = ".$FleetID." AND fleet_id = fleetID;
						  UPDATE ".LOG_FLEETS." SET
						  fleet_end_stay = ".TIMESTAMP.",
						  fleet_end_time = ".$fleetEndTime.",
						  fleet_mess = 1,
						  fleet_state = 2
						  WHERE ".$sqlWhere." = ".$FleetID.";");
	}
	
	public static function GetFleetShipInfo($FleetArray, $Player)
	{
		$FleetInfo	= array();
		foreach ($FleetArray as $ShipID => $Amount) {
			$FleetInfo[$ShipID]	= array('consumption' => self::GetShipConsumption($ShipID, $Player), 'speed' => self::GetFleetMaxSpeed($ShipID, $Player), 'amount' => floattostring($Amount));
		}
		return $FleetInfo;
	}
	
	public static function GotoFleetPage($Code = 0)
	{	
		$temp = debug_backtrace();
		if($GLOBALS['CONF']['debug'] == 1)
			exit(str_replace($_SERVER["DOCUMENT_ROOT"],'.',$temp[0]['file'])." on ".$temp[0]['line']);
			
		redirectTo('game.php?page=fleet&code='.$Code);
	}
	
	public static function GetAvailableMissions($USER, $MissionInfo, $GetInfoPlanet)
	{	
		global $db, $UNI, $CONF;
		$YourPlanet				= (isset($GetInfoPlanet['id_owner']) && $GetInfoPlanet['id_owner'] == $USER['id']) ? true : false;
		$UsedPlanet				= (isset($GetInfoPlanet['id_owner'])) ? true : false;
		$avalibleMissions			= array();
		
		if ($MissionInfo['planet'] == ($CONF['max_planets'] + 1) && isModulAvalible(MODUL_MISSION_EXPEDITION))
			$avalibleMissions[]	= 15;	
		elseif ($MissionInfo['planettype'] == 2) {
			if ((isset($MissionInfo['Ship'][209]) || isset($MissionInfo['Ship'][219])) && isModulAvalible(MODUL_MISSION_RECYCLE) && !($GetInfoPlanet['der_metal'] == 0 && $GetInfoPlanet['der_crystal'] == 0))
				$avalibleMissions[]	= 8;
		} else {
			if (!$UsedPlanet) {
				if (isset($MissionInfo['Ship'][208]) && $MissionInfo['planettype'] == 1 && isModulAvalible(MODUL_MISSION_COLONY))
					$avalibleMissions[]	= 7;
			} else {
				if(isModulAvalible(MODUL_MISSION_TRANSPORT))
					$avalibleMissions[]	= 3;
					
				if (!$YourPlanet && self::OnlyShipByID($MissionInfo['Ship'], 210) && isModulAvalible(MODUL_MISSION_SPY))
					$avalibleMissions[]	= 6;

				if (!$YourPlanet) {
					if(isModulAvalible(MODUL_MISSION_ATTACK))
						$avalibleMissions[]	= 1;
					if(isModulAvalible(MODUL_MISSION_HOLD))
						$avalibleMissions[]	= 5;}
						
				elseif(isModulAvalible(MODUL_MISSION_STATION)) {
					$avalibleMissions[]	= 4;}
					
				if (!empty($MissionInfo['IsAKS']) && !$YourPlanet && isModulAvalible(MODUL_MISSION_ATTACK) && isModulAvalible(MODUL_MISSION_ACS))
					$avalibleMissions[]	= 2;

				if (!$YourPlanet && $MissionInfo['planettype'] == 3 && isset($MissionInfo['Ship'][214]) && isModulAvalible(MODUL_MISSION_DESTROY))
					$avalibleMissions[]	= 9;

				if ($YourPlanet && $MissionInfo['planettype'] == 3 && self::OnlyShipByID($MissionInfo['Ship'], 220) && isModulAvalible(MODUL_MISSION_DARKMATTER))
					$avalibleMissions[]	= 11;
			}
		}
		
		return $avalibleMissions;
	}
	
	public static function CheckBash($Target)
	{
		global $db, $USER;
		if(!BASH_ON)
			return false;
			
		$Count	= $db->countquery("SELECT COUNT(*) FROM uni1_log_fleets
		WHERE fleet_owner = ".$USER['id']." 
		AND fleet_end_id = ".$Target." 
		AND fleet_state != 2 
		AND fleet_start_time > ".(TIMESTAMP - BASH_TIME)." 
		AND fleet_mission IN (1,2,9);");
		return $Count >= BASH_COUNT;
	}
	
	public static function sendFleet($fleetArray, $fleetMission, $fleetStartOwner, $fleetStartPlanetID, $fleetStartPlanetGalaxy, $fleetStartPlanetSystem, $fleetStartPlanetPlanet, $fleetStartPlanetType, $fleetTargetOwner, $fleetTargetPlanetID, $fleetTargetPlanetGalaxy, $fleetTargetPlanetSystem, $fleetTargetPlanetPlanet, $fleetTargetPlanetType, $fleetRessource, $fleetStartTime, $fleetStayTime, $fleetEndTime, $fleetGroup = 0, $missleTarget = 0)
	{
		global $resource, $db, $UNI;
		$fleetShipCount	= array_sum($fleetArray);
		$fleetData		= array();
		$planetQuery	= "";
		foreach($fleetArray as $ShipID => $ShipCount) {
			$fleetData[]	= $ShipID.','.$ShipCount;
			$planetQuery[]	= $resource[$ShipID]." = ".$resource[$ShipID]." - ".$ShipCount;
		}
		
		$SQL	= "LOCK TABLE ".LOG_FLEETS." WRITE, ".FLEETS_EVENT." WRITE, ".FLEETS." WRITE, ".PLANETS." WRITE;
				   INSERT INTO ".FLEETS." SET
				   fleet_owner              = ".$fleetStartOwner.",
				   fleet_target_owner       = ".$fleetTargetOwner.",
				   fleet_mission            = ".$fleetMission.",
				   fleet_amount             = ".$fleetShipCount.",
				   fleet_array              = '".implode(',',$fleetData)."',
				   fleet_universe	        = ".$UNI.",
				   fleet_start_time         = ".$fleetStartTime.",
				   fleet_end_stay           = ".$fleetStayTime.",
				   fleet_end_time           = ".$fleetEndTime.",
				   fleet_start_id           = ".$fleetStartPlanetID.",
				   fleet_start_galaxy       = ".$fleetStartPlanetGalaxy.",
				   fleet_start_system       = ".$fleetStartPlanetSystem.",
				   fleet_start_planet       = ".$fleetStartPlanetPlanet.",
				   fleet_start_type         = ".$fleetStartPlanetType.",
				   fleet_end_id             = ".$fleetTargetPlanetID.",
				   fleet_end_galaxy         = ".$fleetTargetPlanetGalaxy.",
				   fleet_end_system         = ".$fleetTargetPlanetSystem.",
				   fleet_end_planet         = ".$fleetTargetPlanetPlanet.",
				   fleet_end_type           = ".$fleetTargetPlanetType.",
				   fleet_resource_metal     = ".$fleetRessource[901].",
				   fleet_resource_crystal   = ".$fleetRessource[902].",
				   fleet_resource_deuterium = ".$fleetRessource[903].",
				   fleet_group              = ".$fleetGroup.",
				   fleet_target_obj         = ".$missleTarget.",
				   start_time               = ".TIMESTAMP.";
				   SET @fleetID = LAST_INSERT_ID();
                   INSERT INTO ".FLEETS_EVENT." SET 
				   fleetID                  = @fleetID,
				   `time`                   = ".$fleetStartTime.";
				   INSERT INTO ".LOG_FLEETS." SET 
				   fleet_id                 = @fleetID, 
				   fleet_owner              = ".$fleetStartOwner.",
				   fleet_target_owner       = ".$fleetTargetOwner.",
				   fleet_mission            = ".$fleetMission.",
				   fleet_amount             = ".$fleetShipCount.",
				   fleet_array              = '".implode(',',$fleetData)."',
				   fleet_universe	        = ".$UNI.",
				   fleet_start_time         = ".$fleetStartTime.",
				   fleet_end_stay           = ".$fleetStayTime.",
				   fleet_end_time           = ".$fleetEndTime.",
				   fleet_start_id           = ".$fleetStartPlanetID.",
				   fleet_start_galaxy       = ".$fleetStartPlanetGalaxy.",
				   fleet_start_system       = ".$fleetStartPlanetSystem.",
				   fleet_start_planet       = ".$fleetStartPlanetPlanet.",
				   fleet_start_type         = ".$fleetStartPlanetType.",
				   fleet_end_id             = ".$fleetTargetPlanetID.",
				   fleet_end_galaxy         = ".$fleetTargetPlanetGalaxy.",
				   fleet_end_system         = ".$fleetTargetPlanetSystem.",
				   fleet_end_planet         = ".$fleetTargetPlanetPlanet.",
				   fleet_end_type           = ".$fleetTargetPlanetType.",
				   fleet_resource_metal     = ".$fleetRessource[901].",
				   fleet_resource_crystal   = ".$fleetRessource[902].",
				   fleet_resource_deuterium = ".$fleetRessource[903].",
				   fleet_group              = ".$fleetGroup.",
				   fleet_target_obj         = ".$missleTarget.",
				   start_time               = ".TIMESTAMP.";
				   UPDATE ".PLANETS." SET ".implode(", ", $planetQuery)." WHERE id = ".$fleetStartPlanetID.";
				   UNLOCK TABLES;";
		$db->multi_query($SQL);
	}
}
?>