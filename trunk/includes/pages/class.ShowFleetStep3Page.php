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

class ShowFleetStep3Page
{
	public static function show()
	{
		global $USER, $PLANET, $resource, $pricelist, $reslist, $CONF, $db, $LNG, $UNI;
			
		$template	= new template();
		$template->loadscript('flotten.js');
		$template->gotoside('?page=fleet');

		if (IsVacationMode($USER))
			exit($template->message($LNG['fl_vacation_mode_active'], 'game.php?page=overview', 2));
		
		$targetMission 			= request_var('mission', 3);
		$TransportMetal			= request_outofint('metal');
		$TransportCrystal		= request_outofint('crystal');
		$TransportDeuterium		= request_outofint('deuterium');
		$stayTime 				= request_var('staytime', 0);
		$token					= request_var('token', '');
		
		if (!isset($_SESSION['fleet'][$token]))
			FleetFunctions::GotoFleetPage(1);

	
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
			$ACSTime = $db->countquery("SELECT ankunft
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
		
		$targetPlanetData  	= $db->uniquequery("SELECT id, id_owner, der_metal, der_crystal, destruyed, ally_deposit FROM ".PLANETS." WHERE universe = ".$UNI." AND galaxy = ".$targetGalaxy." AND system = ".$targetSystem." AND planet = ".$targetPlanet." AND planet_type = ".($targetType == 2 ? 1 : $targetType).";");

		if ($targetMission != 15) {
			if ($targetPlanetData["destruyed"] != 0) {
				FleetFunctions::GotoFleetPage(7);
			}
				
			if ($targetMission != 7 && !isset($targetPlanetData)) {
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

		if($myPlanet) {
			$targetPlayerData	= $USER;
		} else {
			$targetPlayerData	= $db->uniquequery("SELECT 
			user.id, user.onlinetime, user.ally_id, user.urlaubs_modus, user.banaday, user.authattack, 
			stat.total_points
			FROM ".USERS." as user 
			LEFT JOIN ".STATPOINTS." as stat ON stat.id_owner = user.id AND stat.stat_type = '1' 
			WHERE user.id = ".$targetPlanetData['id_owner'].";");
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
				$buddy	= $db->countquery("
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
		$duration		= $duration * (1 - $USER['factor']['shipspeed']);
		
		$StayDuration    = 0;
		
		switch($targetMission) 
		{
			case 5:
				if(in_array($stayTime, $avalibleMissions['StayBlock'])) {
					FleetFunctions::GotoFleetPage(2);
				}
				
				$StayDuration    = $stayTime * 3600;
			break;
			case 11:
				if(in_array($stayTime, $avalibleMissions['StayBlock'])) {
					FleetFunctions::GotoFleetPage(2);
				}
				
				$StayDuration    = 3600 / $CONF['halt_speed'];
			break;
			case 15:
				if(in_array($stayTime, $avalibleMissions['StayBlock'])) {
					FleetFunctions::GotoFleetPage(2);
				}
				
				$StayDuration    = (3600 * $stayTime) / $CONF['halt_speed'];
			break;
		}
		
		
		$fleetStorage		-= $consumption;
		
		$PlanetRess = new ResourceUpdate();
		$PlanetRess->CalcResource();
		$fleetRessource	= array(
			901	=> min($TransportMetal, $PLANET['metal']),
			902	=> min($TransportCrystal, $PLANET['crystal']),
			903	=> min($TransportDeuterium, $PLANET['deuterium'] - $consumption),
		);
		
		$StorageNeeded		= array_sum($fleetRessource);
	
		if ($PLANET['deuterium'] < $consumption)
		{
			$PlanetRess->SavePlanetToDB();
			FleetFunctions::GotoFleetPage(19);
		}
		
		if ($StorageNeeded > $fleetStorage)
		{
			$PlanetRess->SavePlanetToDB();
			FleetFunctions::GotoFleetPage(20);
		}
				
		$PLANET['metal']		-= $TransportMetal;
		$PLANET['crystal']		-= $TransportCrystal;
		$PLANET['deuterium']	-= ($TransportDeuterium + $consumption);
		$PlanetRess->SavePlanetToDB();
		
		if(connection_aborted())
			exit;

		$fleetStartTime		= $duration + TIMESTAMP;
		$fleetStayTime		= $fleetStartTime + $StayDuration;
		$fleetEndTime		= $fleetStayTime + $duration;
		$timeDifference		= max(0, $fleetStartTime - $ACSTime);
		
		if($fleetGroup != 0 && $timeDifference != 0) {
			FleetFunctions::setACSTime($timeDifference, $fleetGroup);
		}
		
		FleetFunctions::sendFleet($fleetArray, $targetMission, $USER['id'], $PLANET['id'], $PLANET['galaxy'], $PLANET['system'], $PLANET['planet'], $PLANET['planet_type'], $targetPlanetData['id_owner'],  $targetPlanetData['id'], $targetGalaxy, $targetSystem, $targetPlanet, $targetType, $fleetRessource, $fleetStartTime, $fleetStayTime, $fleetEndTime, $fleetGroup);
		
		foreach ($fleetArray as $Ship => $Count)
		{
			$fleetList[$LNG['tech'][$Ship]]	= $Count;
		}
	
		$template->assign_vars(array(
			'targetMission'		=> $targetMission,
			'distance'			=> $distance,
			'consumption'		=> $consumption,
			'from'				=> $PLANET['galaxy'] .":". $PLANET['system']. ":". $PLANET['planet'],
			'destination'		=> $targetGalaxy .":". $targetSystem .":". $targetPlanet,
			'fleetStartTime'	=> tz_date($fleetStartTime),
			'fleetEndTime'		=> tz_date($fleetEndTime),
			'MaxFleetSpeed'		=> $fleetMaxSpeed,
			'FleetList'			=> $fleetArray,
		));
		
		$template->show('fleet3_table.tpl');
	}
}
?>