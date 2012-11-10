<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
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
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.0 (2012-12-31)
 * @info $Id$
 * @link http://2moons.cc/
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
		
		if($targetMission != 2)
		{
			$fleetGroup	= 0;
		}
			
		if ($PLANET['galaxy'] == $targetGalaxy && $PLANET['system'] == $targetSystem && $PLANET['planet'] == $targetPlanet && $PLANET['planet_type'] == $targetType)
		{
			$this->printMessage($LNG['fl_error_same_planet']);
		}

		if ($targetGalaxy < 1 || $targetGalaxy > Config::get('max_galaxy') || 
			$targetSystem < 1 || $targetSystem > Config::get('max_system') || 
			$targetPlanet < 1 || $targetPlanet > (Config::get('max_planets') + 1) ||
			($targetType !== 1 && $targetType !== 2 && $targetType !== 3)) {
			$this->printMessage($LNG['fl_invalid_target']);
		}

		if ($targetMission == 3 && $TransportMetal + $TransportCrystal + $TransportDeuterium < 1)
		{
			$this->printMessage($LNG['fl_no_noresource']);
		}
		
		$ActualFleets		= FleetFunctions::GetCurrentFleets($USER['id']);
		
		if (FleetFunctions::GetMaxFleetSlots($USER) <= $ActualFleets)
		{
			$this->printMessage($LNG['fl_no_slots']);
		}
		
		$ACSTime = 0;
		
		if(!empty($fleetGroup))
		{
			$ACSTime = $GLOBALS['DATABASE']->getFirstCell("SELECT ankunft
			FROM ".USERS_ACS." 
			INNER JOIN ".AKS." ON id = acsID
			WHERE acsID = ".$fleetGroup."
			AND ".Config::get('max_fleets_per_acs')." > (SELECT COUNT(*) FROM ".FLEETS." WHERE fleet_group = ".$fleetGroup.");");
			
			if (empty($ACSTime)) {
				$fleetGroup	= 0;
				$targetMission	= 1;
			}
		}
				
		$ActualFleets 		= FleetFunctions::GetCurrentFleets($USER['id']);
		
		$targetPlanetData  	= $GLOBALS['DATABASE']->getFirstRow("SELECT id, id_owner, der_metal, der_crystal, destruyed, ally_deposit FROM ".PLANETS." WHERE universe = ".$UNI." AND galaxy = ".$targetGalaxy." AND system = ".$targetSystem." AND planet = ".$targetPlanet." AND planet_type = '".($targetType == 2 ? 1 : $targetType)."';");
		
		if ($targetMission == 7 && isset($targetPlanetData)) {
			$this->printMessage($LNG['fl_target_exists']);
		}
		elseif ($targetMission == 7 || $targetMission == 15) {
			$targetPlanetData	= array('id' => 0, 'id_owner' => 0, 'planettype' => 1);
		}
		else {
			if ($targetPlanetData["destruyed"] != 0) {
				$this->printMessage($LNG['fl_no_target']);
			}
				
			if (!isset($targetPlanetData)) {
				$this->printMessage($LNG['fl_no_target']);
			}
		}
		
		foreach ($fleetArray as $Ship => $Count)
		{
			if ($Count > $PLANET[$resource[$Ship]]) {
				$this->printMessage($LNG['fl_not_all_ship_avalible']);
			}
		}
		
		if ($targetMission == 11)
		{
			$activeExpedition	= FleetFunctions::GetCurrentFleets($USER['userID'], 11);
			$maxExpedition		= FleetFunctions::getDMMissionLimit($USER);

			if ($activeExpedition >= $maxExpedition) {
				$this->printMessage($LNG['fl_no_expedition_slot']);
			}
		}
		elseif ($targetMission == 15)
		{		
			$activeExpedition	= FleetFunctions::GetCurrentFleets($USER['userID'], 15);
			$maxExpedition		= FleetFunctions::getExpeditionLimit($USER);
			
			if ($activeExpedition >= $maxExpedition) {
				$this->printMessage($LNG['fl_no_expedition_slot']);
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
			$targetPlayerData	= $GLOBALS['DATABASE']->getFirstRow("SELECT 
			user.id, user.onlinetime, user.ally_id, user.urlaubs_modus, user.banaday, user.authattack, 
			stat.total_points
			FROM ".USERS." as user 
			LEFT JOIN ".STATPOINTS." as stat ON stat.id_owner = user.id AND stat.stat_type = '1' 
			WHERE user.id = ".$targetPlanetData['id_owner'].";");
		} else {
			$this->printMessage($LNG['fl_empty_target']);
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
			$this->printMessage($LNG['fl_invalid_mission']);
		}
		
		if ($targetMission != 8 && IsVacationMode($targetPlayerData)) {
			$this->printMessage($LNG['fl_target_exists']);
		}
		
		
		if ($targetMission == 7) {
			if ($targetType != 1) {
				$this->printMessage($LNG['fl_only_planets_colonizable']);
			}
			
			$techLevel	= PlayerUtil::allowPlanetPosition($USER, $targetPlanet);
			
			if($techLevel > $USER[$GLOBALS['VARS']['ELEMENT'][124]['name']]) {
				$this->printMessage(sprintf($LNG['fl_tech_for_position_required'], $LNG['tech'][124], $techLevel));
			}
		}
		
		if($targetMission == 1 || $targetMission == 2 || $targetMission == 9) {
			if(FleetFunctions::CheckBash($targetPlanetData['id'])) {
				$this->printMessage($LNG['fl_bash_protection']);
			}
		}
		
		if($targetMission == 1 || $targetMission == 2 || $targetMission == 5 || $targetMission == 6 || $targetMission == 9) {
			if(Config::get('adm_attack') == 1 && $usedPlanet['authattack'] > $USER['authlevel']) {
				$this->printMessage($LNG['fl_admin_attack']);
			}
		
			$IsNoobProtec	= CheckNoobProtec($USER, $targetPlayerData, $targetPlayerData);
			
			if ($IsNoobProtec['NoobPlayer']) {
				$this->printMessage($LNG['fl_player_is_noob']);
			}
			
			if ($IsNoobProtec['StrongPlayer']) {
				$this->printMessage($LNG['fl_player_is_strong']);
			}
		}

		if ($targetMission == 5) {
		
			if($targetType == 3)
			{
				$ally_deposit	= $GLOBALS['DATABASE']->getFirstCell("SELECT ally_deposit FROM ".PLANETS." WHERE id_luna = ".$targetPlanetData['id'].";");
				if ($ally_deposit < 1) {
					$this->printMessage($LNG['fl_no_hold_depot']);
				}
			}
			else
			{
				if ($targetPlanetData['ally_deposit'] < 1) {
					$this->printMessage($LNG['fl_no_hold_depot']);
				}
			}
			ally_deposit
					
			if($targetPlayerData['ally_id'] != $USER['ally_id']) {
				$buddy	= $GLOBALS['DATABASE']->getFirstCell("
				SELECT COUNT(*) FROM ".BUDDY." 
				WHERE id NOT IN (SELECT id FROM ".BUDDY_REQUEST." WHERE ".BUDDY_REQUEST.".id = ".BUDDY.".id) AND 
				(owner = ".$targetPlayerData['id']." AND sender = ".$USER['id'].") OR
				(owner = ".$USER['id']." AND sender = ".$targetPlayerData['id'].");");
				
				if($buddy == 0) {
					$this->printMessage($LNG['fl_no_same_alliance']);
				}
			}
		}

		$fleetMaxSpeed 	= FleetFunctions::GetFleetMaxSpeed($fleetArray, $USER);
		$SpeedFactor    = FleetFunctions::GetGameSpeedFactor();
		$duration      	= FleetFunctions::GetMissionDuration($fleetSpeed, $fleetMaxSpeed, $distance, $SpeedFactor, $USER);
		$consumption   	= FleetFunctions::GetFleetConsumption($fleetArray, $duration, $distance, $fleetMaxSpeed, $USER, $SpeedFactor);
	
		if ($PLANET[$resource[903]] < $consumption) {
			$this->printMessage($LNG['fl_not_enough_deuterium']);
		}
		
		$StayDuration    = 0;
		
		if($targetMission == 5 || $targetMission == 11 || $targetMission == 15)
		{
			if(!isset($avalibleMissions['StayBlock'][$stayTime])) {
				$this->printMessage($LNG['fl_hold_time_not_exists']);
			}
			
			$StayDuration    = round($avalibleMissions['StayBlock'][$stayTime] * 3600, 0);
		}
		
		$fleetStorage		-= $consumption;
		
		$fleetRessource	= array(
			901	=> min($TransportMetal, floor($PLANET[$resource[901]])),
			902	=> min($TransportCrystal, floor($PLANET[$resource[902]])),
			903	=> min($TransportDeuterium, floor($PLANET[$resource[903]] - $consumption)),
		);
		
		$StorageNeeded		= array_sum($fleetRessource);
		
		if ($StorageNeeded > $fleetStorage) {
			$this->printMessage($LNG['fl_not_enough_space']);
		}
		
		$PLANET[$resource[901]]	-= $fleetRessource[901];
		$PLANET[$resource[902]]	-= $fleetRessource[902];
		$PLANET[$resource[903]]	-= $fleetRessource[903] + $consumption;

		if(connection_aborted())
			exit;
		
		$fleetStartTime		= $duration + TIMESTAMP;
		$timeDifference		= round(max(0, $fleetStartTime - $ACSTime));
		
		if($fleetGroup != 0)
		{
			if($timeDifference != 0)
			{
				FleetFunctions::setACSTime($timeDifference, $fleetGroup);
			}
			else
			{
				$fleetStartTime		= $ACSTime;
			}
		}
		
		$fleetStayTime		= $fleetStartTime + $StayDuration;
		$fleetEndTime		= $fleetStayTime + $duration;
		
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