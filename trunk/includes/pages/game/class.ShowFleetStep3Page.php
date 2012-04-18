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

require_once(ROOT_PATH . 'includes/classes/class.FleetFunctions.php');

class ShowFleetStep3Page extends AbstractPage
{
	public static $requireModule = MODULE_FLEET_TABLE;

	function __construct() 
	{
		parent::__construct();
	}
	
	public function show()
	{
		global $USER, $PLANET, $resource, $pricelist, $reslist, $CONF, $LNG, $UNI;
			
		if (IsVacationMode($USER)) {
			FleetFunctions::GotoFleetPage(0);
		}
		
		$targetMission 			= HTTP::_GP('mission', 3);
		$TransportMetal			= max(0, round(HTTP::_GP('metal', 0.0)));
		$TransportCrystal		= max(0, round(HTTP::_GP('crystal', 0.0)));
		$TransportDeuterium		= max(0, round(HTTP::_GP('deuterium', 0.0)));
		$stayTime 				= HTTP::_GP('staytime', 0);
		$token					= HTTP::_GP('token', '');
		
		if (!isset($_SESSION['fleet'][$token])) {
			FleetFunctions::GotoFleetPage(1);
		}
			
		if ($_SESSION['fleet'][$token]['time'] < TIMESTAMP - 600) {
			unset($_SESSION['fleet'][$token]);
			FleetFunctions::GotoFleetPage(0);
		}
		
		$maxFleetSpeed	= $_SESSION['fleet'][$token]['speed'];
		$distance		= $_SESSION['fleet'][$token]['distance'];
		$targetGalaxy	= $_SESSION['fleet'][$token]['targetGalaxy'];
		$targetSystem	= $_SESSION['fleet'][$token]['targetSystem'];
		$targetPlanet	= $_SESSION['fleet'][$token]['targetPlanet'];
		$targetType		= $_SESSION['fleet'][$token]['targetType'];
		$fleetGroup		= $_SESSION['fleet'][$token]['fleetGroup'];
		$fleetArray  	= $_SESSION['fleet'][$token]['fleet'];
		$fleetStorage	= $_SESSION['fleet'][$token]['fleetRoom'];
		$fleetSpeed		= $_SESSION['fleet'][$token]['fleetSpeed'];
		unset($_SESSION['fleet'][$token]);
			
		if ($PLANET['galaxy'] == $targetGalaxy && $PLANET['system'] == $targetSystem && $PLANET['planet'] == $targetPlanet && $PLANET['planet_type'] == $targetType) {
			FleetFunctions::GotoFleetPage(3);
		}

		if ($targetGalaxy < 1 || $targetGalaxy > $CONF['max_galaxy'] || 
			$targetSystem < 1 || $targetSystem > $CONF['max_system'] || 
			$targetPlanet < 1 || $targetPlanet > ($CONF['max_planets'] + 1) ||
			($targetType !== 1 && $targetType !== 2 && $targetType !== 3)) {
			FleetFunctions::GotoFleetPage(4);
		}

		if ($targetMission == 3 && $TransportMetal + $TransportCrystal + $TransportDeuterium < 1) {
			FleetFunctions::GotoFleetPage(5);
		}
		
		$ActualFleets		= FleetFunctions::GetCurrentFleets($USER['id']);
		
		if (FleetFunctions::GetMaxFleetSlots($USER) <= $ActualFleets) {
			FleetFunctions::GotoFleetPage(6);
		}
		
		$ACSTime = 0;
		
		if(!empty($fleetGroup) && $targetMission == 2)
		{
			$ACSTime = $GLOBALS['DATABASE']->countquery("SELECT ankunft
			FROM ".USERS_ACS." 
			INNER JOIN ".AKS." ON id = acsID
			WHERE acsID = ".$fleetGroup."
			AND ".$CONF['max_fleets_per_acs']." > (SELECT COUNT(*) FROM ".FLEETS." WHERE fleet_group = ".$fleetGroup.");");
			
			if (empty($ACSTime)) {
				$fleetGroup	= 0;
				$targetMission	= 1;
			}
		}
				
		$ActualFleets 		= FleetFunctions::GetCurrentFleets($USER['id']);
		
		$targetPlanetData  	= $GLOBALS['DATABASE']->uniquequery("SELECT id, id_owner, der_metal, der_crystal, destruyed, ally_deposit FROM ".PLANETS." WHERE universe = ".$UNI." AND galaxy = ".$targetGalaxy." AND system = ".$targetSystem." AND planet = ".$targetPlanet." AND planet_type = '".($targetType == 2 ? 1 : $targetType)."';");

		if ($targetMission == 15 || $targetMission == 7) {
			$targetPlanetData	= array('id' => 0, 'id_owner' => 0, 'planettype' => 1);
		} else {
			if ($targetPlanetData["destruyed"] != 0) {
				FleetFunctions::GotoFleetPage(7);
			}
				
			if (!isset($targetPlanetData)) {
				FleetFunctions::GotoFleetPage(7);
			}
		}
		
		foreach ($fleetArray as $Ship => $Count)
		{
			if ($Count > $PLANET[$resource[$Ship]]) {
				FleetFunctions::GotoFleetPage(8);
			}
		}
		
		if ($targetMission == 11)
		{
			$expeditionTech = FleetFunctions::GetCurrentFleets($USER['id'], 11);

			if ($expeditionTech >= $CONF['max_dm_missions']) {
				FleetFunctions::GotoFleetPage(9);
			}
		}
		elseif ($targetMission == 15)
		{
			$expeditionTech = $USER[$resource[124]];

			if ($expeditionTech == 0) {
				FleetFunctions::GotoFleetPage(10);
			}
							
			$activeExpedition	= FleetFunctions::GetCurrentFleets($USER['id'], 15);
			$maxExpedition		= floor(sqrt($expeditionTech));
			
			if ($activeExpedition >= $maxExpedition) {
				FleetFunctions::GotoFleetPage(9);
			}
		}

		$usedPlanet	= isset($targetPlanetData['id_owner']);
		$myPlanet	= $usedPlanet && $targetPlanetData['id_owner'] == $USER['id'];
		
		if($targetMission == 7 || $targetMission == 15) {
			$targetPlayerData	= array(
				'id'				=> 0,
				'onlinetime'		=> TIMESTAMP,
				'ally_id'			=> 0,
				'urlaubs_modus'		=> 0,
				'authattack'		=> 0,
				'total_points'		=> 0,
			);
		} elseif($myPlanet) {
			$targetPlayerData	= $USER;
		} elseif(!empty($targetPlanetData['id_owner'])) {
			$targetPlayerData	= $GLOBALS['DATABASE']->uniquequery("SELECT 
			user.id, user.onlinetime, user.ally_id, user.urlaubs_modus, user.banaday, user.authattack, 
			stat.total_points
			FROM ".USERS." as user 
			LEFT JOIN ".STATPOINTS." as stat ON stat.id_owner = user.id AND stat.stat_type = '1' 
			WHERE user.id = ".$targetPlanetData['id_owner'].";");
		} else {
			FleetFunctions::GotoFleetPage(23);
		}
		
		$MisInfo		     	= array();		
		$MisInfo['galaxy']     	= $targetGalaxy;		
		$MisInfo['system'] 	  	= $targetSystem;	
		$MisInfo['planet'] 	  	= $targetPlanet;		
		$MisInfo['planettype'] 	= $targetType;	
		$MisInfo['IsAKS']		= $fleetGroup;
		$MisInfo['Ship'] 		= $fleetArray;		
		
		$avalibleMissions		= FleetFunctions::GetFleetMissions($USER, $MisInfo, $targetPlanetData);
		
		if (!in_array($targetMission, $avalibleMissions['MissionSelector'])) {
			FleetFunctions::GotoFleetPage(0);
		}
		
		if ($targetMission != 8 && IsVacationMode($targetPlayerData)) {
			FleetFunctions::GotoFleetPage(12);
		}
		
		if($targetMission == 1 || $targetMission == 2 || $targetMission == 9) {
			if(FleetFunctions::CheckBash($targetPlanetData['id'])) {
				FleetFunctions::GotoFleetPage(13);
			}
		}
		
		if($targetMission == 1 || $targetMission == 2 || $targetMission == 5 || $targetMission == 6 || $targetMission == 9) {
			if($CONF['adm_attack'] == 1 && $usedPlanet['authattack'] > $USER['authlevel']) {
				FleetFunctions::GotoFleetPage(14);
			}
		
			$IsNoobProtec	= CheckNoobProtec($USER, $targetPlayerData, $targetPlayerData);
			
			if ($IsNoobProtec['NoobPlayer']) {
				FleetFunctions::GotoFleetPage(15);
			}
			
			if ($IsNoobProtec['StrongPlayer']) {
				FleetFunctions::GotoFleetPage(16);
			}
		}

		if ($targetMission == 5) {
			if ($targetPlanetData['ally_deposit'] < 1) {
				FleetFunctions::GotoFleetPage(17);
			}
					
			if($targetPlayerData['ally_id'] != $USER['ally_id']) {
				$buddy	= $GLOBALS['DATABASE']->countquery("
				SELECT COUNT(*) FROM ".BUDDY." 
				WHERE id NOT IN (SELECT id FROM ".BUDDY_REQUEST." WHERE ".BUDDY_REQUEST.".id = ".BUDDY.".id) AND 
				(owner = ".$targetPlayerData['id']." AND sender = ".$USER['id'].") OR
				(owner = ".$USER['id']." AND sender = ".$targetPlayerData['id'].");");
				
				if($buddy == 0) {
					FleetFunctions::GotoFleetPage(18);
				}
			}
		}

		$fleetMaxSpeed 	= FleetFunctions::GetFleetMaxSpeed($fleetArray, $USER);
		$SpeedFactor    = FleetFunctions::GetGameSpeedFactor();
		$duration      	= FleetFunctions::GetMissionDuration($fleetSpeed, $fleetMaxSpeed, $distance, $SpeedFactor, $USER);
		$consumption   	= FleetFunctions::GetFleetConsumption($fleetArray, $duration, $distance, $fleetMaxSpeed, $USER, $SpeedFactor);
		$duration		= $duration * (1 - $USER['factor']['FlyTime']);
		
		$StayDuration    = 0;
		
		switch($targetMission) 
		{
			case 5:
				if(!isset($avalibleMissions['StayBlock'][$stayTime])) {
					FleetFunctions::GotoFleetPage(2);
				}
				
				$StayDuration    = $stayTime * 3600;
			break;
			case 11:
				$StayDuration    = 3600 / $CONF['halt_speed'];
			break;
			case 15:
				if(!isset($avalibleMissions['StayBlock'][$stayTime])) {
					FleetFunctions::GotoFleetPage(2);
				}
				
				$StayDuration    = (3600 * $stayTime) / $CONF['halt_speed'];
			break;
		}
		
		$fleetStorage		-= $consumption;
		
		$fleetRessource	= array(
			901	=> min($TransportMetal, floor($PLANET[$resource[901]])),
			902	=> min($TransportCrystal, floor($PLANET[$resource[902]])),
			903	=> min($TransportDeuterium, floor($PLANET[$resource[903]] - $consumption)),
		);
		
		$StorageNeeded		= array_sum($fleetRessource);
	
		if ($PLANET[$resource[903]] < $consumption) {
			FleetFunctions::GotoFleetPage(19);
		}
		
		if ($StorageNeeded > $fleetStorage) {
			FleetFunctions::GotoFleetPage(20);
		}
				
		$PLANET[$resource[901]]	-= $fleetRessource[901];
		$PLANET[$resource[902]]	-= $fleetRessource[902];
		$PLANET[$resource[903]]	-= $fleetRessource[903] + $consumption;

		if(connection_aborted())
			exit;

		$fleetStartTime		= $duration + TIMESTAMP;
		$fleetStayTime		= $fleetStartTime + $StayDuration;
		$fleetEndTime		= $fleetStayTime + $duration;
		$timeDifference		= max(0, $fleetStartTime - $ACSTime);
		
		if($fleetGroup != 0 && $timeDifference != 0) {
			FleetFunctions::setACSTime($timeDifference, $fleetGroup);
		}
		
		FleetFunctions::sendFleet($fleetArray, $targetMission, $USER['id'], $PLANET['id'], $PLANET['galaxy'], $PLANET['system'], $PLANET['planet'], $PLANET['planet_type'], $targetPlanetData['id_owner'], $targetPlanetData['id'], $targetGalaxy, $targetSystem, $targetPlanet, $targetType, $fleetRessource, $fleetStartTime, $fleetStayTime, $fleetEndTime, $fleetGroup);
		
		foreach ($fleetArray as $Ship => $Count)
		{
			$fleetList[$LNG['tech'][$Ship]]	= $Count;
		}
	
		$this->tplObj->loadscript('flotten.js');
		$this->tplObj->gotoside('game.php?page=fleetTable');
		$this->tplObj->assign_vars(array(
			'targetMission'		=> $targetMission,
			'distance'			=> $distance,
			'consumption'		=> $consumption,
			'from'				=> $PLANET['galaxy'] .":". $PLANET['system']. ":". $PLANET['planet'],
			'destination'		=> $targetGalaxy .":". $targetSystem .":". $targetPlanet,
			'fleetStartTime'	=> _date($LNG['php_tdformat'], $fleetStartTime, $USER['timezone']),
			'fleetEndTime'		=> _date($LNG['php_tdformat'], $fleetEndTime, $USER['timezone']),
			'MaxFleetSpeed'		=> $fleetMaxSpeed,
			'FleetList'			=> $fleetArray,
		));
		
		$this->display('page.fleetStep3.default.tpl');
	}
}
?>