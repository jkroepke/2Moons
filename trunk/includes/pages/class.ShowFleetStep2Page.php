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

class ShowFleetStep2Page
{
	public static function show()
	{
		global $USER, $PLANET, $db, $LNG, $UNI;
	
		$PlanetRess = new ResourceUpdate();
		$PlanetRess->CalcResource();
		$PlanetRess->SavePlanetToDB();
		
		$template	= new template();
		$template->loadscript('flotten.js');
		
		$targetGalaxy  				= request_var('galaxy', 0);
		$targetSystem   			= request_var('system', 0);
		$targetPlanet   			= request_var('planet', 0);
		$targetType 				= request_var('type', 0);
		$targetMission 				= request_var('mission', 0);
		$fleetSpeed  				= request_var('speed', 0);		
		$fleetGroup 				= request_var('fleet_group', 0);
		$token						= request_var('token', '');

		if (!isset($_SESSION['fleet'][$token]))
			FleetFunctions::GotoFleetPage();

		$fleetArray    				= $_SESSION['fleet'][$token]['fleet'];
		$targetPlanetData			= $db->uniquequery("SELECT `id`, `id_owner`, `der_metal`, `der_crystal` FROM `".PLANETS."` WHERE `universe` = ".$UNI." AND `galaxy` = ".$targetGalaxy." AND `system` = ".$targetSystem." AND `planet` = ".$targetPlanet." AND `planet_type` = '1';");
				
		if($targetType == 2 && $targetPlanetData['der_metal'] == 0 && $targetPlanetData['der_crystal'] == 0) {
			$template->message("<font color=\"red\"><b>".$LNG['fl_no_empty_derbis']."</b></font>", "game.php?page=fleet", 2);
			exit;
		}
			
		$MisInfo		     		= array();		
		$MisInfo['galaxy']     		= $targetGalaxy;		
		$MisInfo['system'] 	  		= $targetSystem;	
		$MisInfo['planet'] 	  		= $targetPlanet;		
		$MisInfo['planettype'] 		= $targetType;	
		$MisInfo['IsAKS']			= $fleetGroup;
		$MisInfo['Ship'] 			= $fleetArray;		
		
		$MissionOutput	 			= FleetFunctions::GetFleetMissions($USER, $MisInfo, $targetPlanetData);
		
		if(empty($MissionOutput))
		{
			$template->message("<font color=\"red\"><b>". $LNG['fl_empty_target']."</b></font>", "game.php?page=fleet", 2);
			exit;
		}
		
		$GameSpeedFactor   		 	= FleetFunctions::GetGameSpeedFactor();		
		$MaxFleetSpeed 				= FleetFunctions::GetFleetMaxSpeed($fleetArray, $USER);
		$distance      				= FleetFunctions::GetTargetDistance($PLANET['galaxy'], $targetGalaxy, $PLANET['system'], $targetSystem, $PLANET['planet'], $targetPlanet);
		$duration      				= FleetFunctions::GetMissionDuration($fleetSpeed, $MaxFleetSpeed, $distance, $GameSpeedFactor, $USER);
		$consumption				= FleetFunctions::GetFleetConsumption($fleetArray, $duration, $distance, $MaxFleetSpeed, $USER, $GameSpeedFactor);
		$duration					= $duration * (1 - $USER['factor']['shipspeed']);
		
		if($consumption > $PLANET['deuterium']) {
			FleetFunctions::GotoFleetPage(19); # No Deuterium
		}
		
		if(!FleetFunctions::CheckUserSpeed($fleetSpeed)) {
			FleetFunctions::GotoFleetPage(0);
		}
		
		$_SESSION['fleet'][$token]['speed']			= $MaxFleetSpeed;
		$_SESSION['fleet'][$token]['distance']		= $distance;
		$_SESSION['fleet'][$token]['targetGalaxy']	= $targetGalaxy;
		$_SESSION['fleet'][$token]['targetSystem']	= $targetSystem;
		$_SESSION['fleet'][$token]['targetPlanet']	= $targetPlanet;
		$_SESSION['fleet'][$token]['targetType']	= $targetType;
		$_SESSION['fleet'][$token]['fleetGroup']	= $fleetGroup;
		$_SESSION['fleet'][$token]['fleetSpeed']	= $fleetSpeed;
		
		if(!empty($fleet_group))
			$targetMission	= 2;

		$fleetData	= array(
			'fleetroom'			=> floattostring($_SESSION['fleet'][$token]['fleetRoom']),
			'consumption'		=> floattostring($consumption),
			'consumption'		=> 0,
		);
			
		$template->execscript('calculateTransportCapacity();');
		$template->assign_vars(array(
			'fleetdata'						=> $fleetData,
			'consumption'					=> floattostring($consumption),
			'mission'						=> $targetMission,
			'galaxy'			 			=> $PLANET['galaxy'],
			'system'			 			=> $PLANET['system'],
			'planet'			 			=> $PLANET['planet'],
			'type'			 				=> $PLANET['planet_type'],
			'MissionSelector' 				=> $MissionOutput['MissionSelector'],
			'StaySelector' 					=> $MissionOutput['StayBlock'],
			'fl_dm_alert_message'			=> sprintf($LNG['fl_dm_alert_message'], $LNG['type_mission'][11], $LNG['tech'][921]),
			'fl_continue'					=> $LNG['fl_continue'],
			'token' 						=> $token,
		));
		
		$template->show('fleet2_table.tpl');
	}
}
?>