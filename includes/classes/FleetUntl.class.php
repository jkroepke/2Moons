<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan
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
 * @author Jan <info@2moons.cc>
 * @copyright 2006 Perberos <ugamela@perberos.com.ar> (UGamela)
 * @copyright 2008 Chlorel (XNova)
 * @copyright 2009 Lucky (XGProyecto)
 * @copyright 2012 Jan <info@2moons.cc> (2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.0 (2012-05-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

class FleetUntl 
{
	static $allowedSpeed	= array(10 => 100, 9 => 90, 8 => 80, 7 => 70, 6 => 60, 5 => 50, 4 => 40, 3 => 30, 2 => 20, 1 => 10);
	
	private static function GetShipConsumption($elementID, $Player)
	{
		if(($Player['impulse_motor_tech'] >= 5 && $elementID == 202) || ($Player['hyperspace_motor_tech'] >= 8 && $elementID == 211))
		{
			return $GLOBALS['VARS']['ELEMENT'][$elementID]['fleetData']['consumption2'];
		}
		else
		{
			return $GLOBALS['VARS']['ELEMENT'][$elementID]['fleetData']['consumption'];
		}
	}

	private static function OnlyShipByID($shipArray, $elementID)
	{
		return isset($shipArray[$elementID]) && count($elementIDs) === 1;
	}

	private static function GetShipSpeed($elementID, $Player)
	{
		$techSpeed	= $GLOBALS['VARS']['ELEMENT'][$elementID]['fleetData']['tech'];
		
		if($techSpeed == 4)
		{
			$techSpeed = $Player['impulse_motor_tech'] >= 5 ? 2 : 1;
		}
		
		if($techSpeed == 5)
		{
			$techSpeed = $Player['hyperspace_motor_tech'] >= 8 ? 3 : 2;
		}
		
		switch($techSpeed)
		{
			case 1:
				$speed	= $GLOBALS['VARS']['ELEMENT'][$elementID]['fleetData']['speed'] * (1 + (0.1 * $Player['combustion_tech']));
			break;
			case 2:
				$speed	= $GLOBALS['VARS']['ELEMENT'][$elementID]['fleetData']['speed'] * (1 + (0.2 * $Player['impulse_motor_tech']));
			break;
			case 3:
				$speed	= $GLOBALS['VARS']['ELEMENT'][$elementID]['fleetData']['speed'] * (1 + (0.3 * $Player['hyperspace_motor_tech']));
			break;
			default:
				$speed	= 0;
			break;
		}

		return $speed;
	}
	
	public static function getExpeditionLimit($USER)
	{
		return floor(sqrt($USER[$GLOBALS['VARS']['ELEMENT'][124]['name']]));
	}
	
	public static function getDMMissionLimit($USER)
	{
		global $uniConfig;
		return $uniConfig['fleetLimitDMMissions'];
	}
	
	public static function getMissileRange($Level)
	{
		return max(($Level * 5) - 1, 0);
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

	public static function GetMissionDuration($SpeedFactor, $MaxFleetSpeed, $Distance, $GameSpeed, $USER)
	{
		$SpeedFactor	= (3500 / ($SpeedFactor * 0.1));
		$SpeedFactor	*= pow($Distance * 10 / $MaxFleetSpeed, 0.5);
		$SpeedFactor	+= 10;
		$SpeedFactor	/= $GameSpeed;
		
		return max($SpeedFactor, MIN_FLEET_TIME);
	}

	public static function GetGameSpeedFactor()
	{
		global $uniConfig;
		return $uniConfig['fleetSpeed'];
	}
	
	public static function GetMaxFleetSlots($USER)
	{
		return 1 + $USER[$GLOBALS['VARS']['ELEMENT'][108]['name']] + $USER['factor']['FleetSlots'];
	}

	public static function GetFleetRoom($Fleet)
	{
		$FleetRoom 				= 0;
		foreach ($Fleet as $elementID => $amount)
		{
			$FleetRoom		   += $GLOBALS['VARS']['ELEMENT'][$elementID]['fleetData']['capacity'] * $amount;
		}
		return $FleetRoom;
	}
	
	public static function GetFleetMaxSpeed ($Fleets, $Player)
	{
		$FleetArray = (!is_array($Fleets)) ? array($Fleets => 1) : $Fleets;
		$speedalls 	= array();
		
		foreach ($FleetArray as $elementID => $Count) {
			$speedalls[$elementID] = self::GetShipSpeed($elementID, $Player);
		}
		
		return min($speedalls);
	}

	public static function GetFleetConsumption($FleetArray, $MissionDuration, $MissionDistance, $FleetMaxSpeed, $Player, $GameSpeed)
	{
		$consumption = 0;

		foreach ($FleetArray as $elementID => $Count)
		{
			$elementIDSpeed          = self::GetShipSpeed($elementID, $Player);
			$elementIDConsumption    = self::GetShipConsumption($elementID, $Player);
			
			$spd                = 35000 / (round($MissionDuration, 0) * $GameSpeed - 10) * sqrt($MissionDistance * 10 / $elementIDSpeed);
			$basicConsumption   = $elementIDConsumption * $Count;
			$consumption        += $basicConsumption * $MissionDistance / 35000 * (($spd / 10) + 1) * (($spd / 10) + 1);
		}
		return (round($consumption) + 1);
	}

	public static function GetFleetMissions($USER, $MisInfo, $Planet)
	{
		global $uniAllConfig;

		$uniConfig	= $uniAllConfig[$USER['universe']];
		
		$Missions	= self::GetAvailableMissions($USER, $MisInfo, $Planet);
		$stayBlock	= array();;
		if (in_array(15, $Missions)) {
			for($i = 1; $i <= $USER[$GLOBALS['VARS']['ELEMENT'][124]['name']];$i++) {	
				$stayBlock[$i]	= $i / $uniConfig['expeditionSpeed'];
			}
		}
		elseif(in_array(5, $Missions)) {
			$stayBlock = array(1 => 1, 2 => 2, 4 => 4, 8 => 8, 12 => 12, 16 => 16, 32 => 32);
		}
		
		return array('MissionSelector' => $Missions, 'StayBlock' => $stayBlock);
	}
	
	public static function GetACSDuration($FleetGroup)
	{
				if(empty($FleetGroup))
			return 0;
			
		$GetAKS 	= $GLOBALS['DATABASE']->countquery("SELECT ankunft FROM ".AKS." WHERE id = ".$FleetGroup.";");

		return !empty($GetAKS) ? $GetAKS - TIMESTAMP : 0;
	}
	
	public static function setACSTime($timeDifference, $FleetGroup)
	{
		
		if(empty($FleetGroup))
			return false;
			
		$GLOBALS['DATABASE']->multi_query("UPDATE ".AKS." SET ankunft = ankunft + ".$timeDifference." WHERE id = ".$FleetGroup.";
						  UPDATE ".FLEETS.", ".FLEETS_EVENT." SET 
						  fleet_start_time = fleet_start_time + ".$timeDifference.",
						  fleet_end_stay   = fleet_end_stay + ".$timeDifference.",
						  fleet_end_time   = fleet_end_time + ".$timeDifference.",
						  time             = time + ".$timeDifference."
						  WHERE fleet_group = ".$FleetGroup." AND fleet_id = fleetID;");

        return true;
	}

	public static function GetCurrentFleets($USERID, $Mission = 0)
	{
		$ActualFleets = $GLOBALS['DATABASE']->getFirstRow("SELECT COUNT(*) as state FROM ".FLEETS." WHERE fleet_owner = '".$USERID."' AND ".(($Mission != 0)?"fleet_mission = '".$Mission."'":"fleet_mission != 10").";");
		return $ActualFleets['state'];
	}	
	
	public static function SendFleetBack($USER, $FleetID)
	{
		$FleetRow = $GLOBALS['DATABASE']->getFirstRow("SELECT start_time, fleet_mission, fleet_group, fleet_owner, fleet_mess FROM ".FLEETS." WHERE fleet_id = '". $FleetID ."';");
		if ($FleetRow['fleet_owner'] != $USER['id'] || $FleetRow['fleet_mess'] == 1)
			return;
			
		$sqlWhere	= 'fleet_id';

		if($FleetRow['fleet_mission'] == 1 && $FleetRow['fleet_group'] != 0)
		{
			$acsResult = $GLOBALS['DATABASE']->countquery("SELECT COUNT(*) FROM ".USERS_ACS." WHERE acsID = ".$FleetRow['fleet_group'].";");

			if($acsResult != 0)
			{
				$GLOBALS['DATABASE']->multi_query("DELETE FROM ".AKS." WHERE id = ".$FleetRow['fleet_group'].";
								  DELETE FROM ".USERS_ACS." WHERE acsID = ".$FleetRow['fleet_group'].";");
				
				$FleetID	= $FleetRow['fleet_group'];
				$sqlWhere	= 'fleet_group';
			}
		}
		
		$fleetEndTime	= (TIMESTAMP - $FleetRow['start_time']) + TIMESTAMP;
		
		$GLOBALS['DATABASE']->multi_query("UPDATE ".FLEETS.", ".FLEETS_EVENT." SET 
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
		foreach ($FleetArray as $elementIDID => $Amount) {
			$FleetInfo[$elementIDID]	= array('consumption' => self::GetShipConsumption($elementIDID, $Player), 'speed' => self::GetFleetMaxSpeed($elementIDID, $Player), 'amount' => floattostring($Amount));
		}
		return $FleetInfo;
	}
	
	public static function GotoFleetPage($Code = 0)
	{	
		#global $LNG;
		#$temp = debug_backtrace();
		#exit(str_replace($_SERVER["DOCUMENT_ROOT"],'.',$temp[0]['file'])." on ".$temp[0]['line']. " | Code: ".$Code." | Error: ".isset($LNG['fl_send_error'][$Code]) ? $LNG['fl_send_error'][$Code] : '');
		
		HTTP::redirectTo('game.php?page=fleetTable&code='.$Code);
	}
	
	public static function GetAvailableMissions($USER, $MissionInfo, $GetInfoPlanet)
	{	
		global $uniConfig;
		$YourPlanet				= (!empty($GetInfoPlanet['id_owner']) && $GetInfoPlanet['id_owner'] == $USER['id']) ? true : false;
		$UsedPlanet				= (!empty($GetInfoPlanet['id_owner'])) ? true : false;
		$avalibleMissions		= array();
		
		if ($MissionInfo['planet'] == ($uniConfig['planetMaxPosition'] + 1) && isModulAvalible(MODULE_MISSION_EXPEDITION))
		{
			$avalibleMissions[MISSION_EXPEDITION]			= MISSION_EXPEDITION;	
		} 
		elseif ($MissionInfo['planettype'] == 2)
		{
			if ((isset($MissionInfo['Ship'][209]) || isset($MissionInfo['Ship'][219])) && isModulAvalible(MODULE_MISSION_RECYCLE) && ($GetInfoPlanet['der_metal'] > 0 || $GetInfoPlanet['der_crystal'] > 0))
			{
				$avalibleMissions[MISSION_RECYCLE]			= MISSION_RECYCLE;
			}
		}
		else
		{
			if (!$UsedPlanet)
			{
				if (isset($MissionInfo['Ship'][208]) && $MissionInfo['planettype'] == 1 && isModulAvalible(MODULE_MISSION_COLONY))
				{
					$avalibleMissions[MISSION_COLONY]		= MISSION_COLONY;
				}
			}
			else
			{
				if (isModulAvalible(MODULE_MISSION_TRANSPORT))
				{
					$avalibleMissions[MISSION_TRANSPORT]	= MISSION_TRANSPORT;
				}

				if (!$YourPlanet)
				{
					if (isModulAvalible(MODULE_MISSION_SPY) && self::OnlyShipByID($MissionInfo['Ship'], 210))
					{
						$avalibleMissions[MISSION_SPY]		= MISSION_SPY;
					}
				
					if (isModulAvalible(MODULE_MISSION_ATTACK))
					{
						$avalibleMissions[MISSION_ATTACK]	= MISSION_ATTACK;
					}
					
					if (isModulAvalible(MODULE_MISSION_HOLD))
					{
						$avalibleMissions[MISSION_HOLD]		= MISSION_HOLD;
					}
						
					if (!empty($MissionInfo['IsAKS']) && isModulAvalible(MODULE_MISSION_ATTACK) && isModulAvalible(MODULE_MISSION_ACS))
					{
						$avalibleMissions[MISSION_ACS]		= MISSION_ACS;
					}

					if ($MissionInfo['planettype'] == 3 && isset($MissionInfo['Ship'][214]) && isModulAvalible(MODULE_MISSION_DESTROY))
					{
						$avalibleMissions[MISSION_DESTROY]	= MISSION_DESTROY;
					}
				}
				else
				{
					if (isModulAvalible(MODULE_MISSION_STATION))
					{
						$avalibleMissions[MISSION_STATION]		= MISSION_STATION;
					}
					
					if ($MissionInfo['planettype'] == 3 && isModulAvalible(MODULE_MISSION_DARKMATTER) && self::OnlyShipByID($MissionInfo['Ship'], 220))
					{
						$avalibleMissions[MISSION_DMMISSION]	= MISSION_DMMISSION;
					}
				}
			}
		}
				
		return $avalibleMissions;
	}
	
	public static function CheckBash($Target)
	{
		global $USER;
		if (!BASH_ON)
		{
			return false;
		}
		
		$Count	= $GLOBALS['DATABASE']->countquery("SELECT COUNT(*) FROM uni1_log_fleets
		WHERE fleet_owner = ".$USER['id']." 
		AND fleet_end_id = ".$Target." 
		AND fleet_state != 2 
		AND fleet_start_time > ".(TIMESTAMP - BASH_TIME)." 
		AND fleet_mission IN (1,2,9);");
		return $Count >= BASH_COUNT;
	}
	
	public static function sendFleet($fleetArray, $fleetMission, $fleetStartOwner, $fleetStartPlanetID, $fleetStartPlanetGalaxy, $fleetStartPlanetSystem, $fleetStartPlanetPlanet, $fleetStartPlanetType, $fleetTargetOwner, $fleetTargetPlanetID, $fleetTargetPlanetGalaxy, $fleetTargetPlanetSystem, $fleetTargetPlanetPlanet, $fleetTargetPlanetType, $fleetRessource, $fleetStartTime, $fleetStayTime, $fleetEndTime, $fleetGroup = 0, $missleTarget = 0)
	{
		global $resource, $UNI;
		$fleetShipCount	= array_sum($fleetArray);
		$fleetData		= array();
		$planetQuery	= "";
		$resourceSQL	= "";
		foreach($fleetArray as $elementIDID => $elementIDCount)
		{
			$fleetData[]	= $elementIDID.','.$elementIDCount;
			$planetQuery[]	= $GLOBALS['VARS']['ELEMENT'][$elementIDID]['name']." = ".$GLOBALS['VARS']['ELEMENT'][$elementIDID]['name']." - ".$elementIDCount;
		}
		
		foreach($fleetRessource as $resourceID => $amount) {
			$resourceSQL	.= ",fleet_resource_".$GLOBALS['VARS']['ELEMENT'][$resourceID]['name']." = ".$fleetRessource[$resourceID];
		}
		
		$SQL	= "LOCK TABLE ".LOG_FLEETS." WRITE, ".FLEETS_EVENT." WRITE, ".FLEETS." WRITE, ".PLANETS." WRITE;
				   INSERT INTO ".FLEETS." SET
				   fleet_owner              = ".$fleetStartOwner.",
				   fleet_target_owner       = ".$fleetTargetOwner.",
				   fleet_mission            = ".$fleetMission.",
				   fleet_amount             = ".$fleetShipCount.",
				   fleet_array              = '".implode(';',$fleetData)."',
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
				   fleet_end_type           = ".$fleetTargetPlanetType."
				   ".$resourceSQL.",
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
				   fleet_end_type           = ".$fleetTargetPlanetType."
				   ".$resourceSQL.",
				   fleet_group              = ".$fleetGroup.",
				   fleet_target_obj         = ".$missleTarget.",
				   start_time               = ".TIMESTAMP.";
				   UPDATE ".PLANETS." SET ".implode(", ", $planetQuery)." WHERE id = ".$fleetStartPlanetID.";
				   UNLOCK TABLES;";
		$GLOBALS['DATABASE']->multi_query($SQL);
	}
}
