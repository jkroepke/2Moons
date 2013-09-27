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
 * @version 1.8.0 (2013-03-18)
 * @info $Id$
 * @link http://2moons.cc/
 */

class ShowFleetStep2Page extends AbstractGamePage
{
	public static $requireModule = MODULE_FLEET_TABLE;

	function __construct() 
	{
		parent::__construct();
	}
	
	public function show()
	{
		global $USER, $PLANET, $LNG;
		
		$targetGalaxy	= HTTP::_GP('targetGalaxy', 0);
		$targetSystem	= HTTP::_GP('targetSystem', 0);
		$targetPlanet	= HTTP::_GP('targetPlanet', 0);
		$targetType 	= HTTP::_GP('targetType', 0);
		$targetMission	= HTTP::_GP('targetMission', 0);
		$fleetSpeed 	= HTTP::_GP('fleetSpeed', 0);
		$fleetGroup 	= HTTP::_GP('fleetGroup', 0);
		$token			= HTTP::_GP('token', '');

		$session		= Session::load();

		if (!isset($session->fleet[$token]))
		{
			$this->printMessage($LNG['invalid_action'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleetTable'
			)));
		}

		$missionData	= $session->fleet[$token];

        $db = Database::get();
        $sql = "SELECT id, id_owner, der_metal, der_crystal FROM %%PLANETS%% WHERE universe = :universe AND galaxy = :targetGalaxy AND system = :targetSystem AND planet = :targetPlanet AND planet_type = '1';";
        $targetPlanetData = $db->selectSingle($sql, array(
            ':universe' => Universe::current(),
            ':targetGalaxy' => $targetGalaxy,
            ':targetSystem' => $targetSystem,
            ':targetPlanet' => $targetPlanet
        ));

        if($targetType == 2 && $targetPlanetData['der_metal'] == 0 && $targetPlanetData['der_crystal'] == 0)
		{
			unset($session->fleet[$token]);
			$this->printMessage($LNG['fl_error_empty_derbis'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleet1'
			)));
		}
			
		$MisInfo		     		= array();		
		$MisInfo['galaxy']     		= $targetGalaxy;		
		$MisInfo['system'] 	  		= $targetSystem;	
		$MisInfo['planet'] 	  		= $targetPlanet;		
		$MisInfo['planettype'] 		= $targetType;	
		$MisInfo['IsAKS']			= $fleetGroup;
		$MisInfo['Ship'] 			= $fleetArray;		
		
		$MissionOutput	 			= FleetUtil::GetFleetMissions($USER, $MisInfo, $targetPlanetData);
		
		if(empty($MissionOutput['MissionSelector']))
		{
			unset($session->fleet[$token]);
			$this->printMessage($LNG['fl_empty_target'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleetTable'
			)));
		}
		
		$GameSpeedFactor   		 	= FleetUtil::GetGameSpeedFactor();
		$MaxFleetSpeed 				= FleetUtil::GetFleetMaxSpeed($fleetArray, $USER);

		$distance      				= FleetUtil::GetTargetDistance(
			array($PLANET['galaxy'], $PLANET['system'], $PLANET['planet']),
			array($targetGalaxy, $targetSystem, $targetPlanet)
		);

		$duration      				= FleetUtil::GetMissionDuration($fleetSpeed, $MaxFleetSpeed, $distance, $GameSpeedFactor, $USER);
		$consumption				= FleetUtil::GetFleetConsumption($fleetArray, $duration, $distance, $USER, $GameSpeedFactor);
		
		if($consumption > $PLANET['deuterium'])
		{
			unset($session->fleet[$token]);
			$this->printMessage($LNG['fl_not_enough_deuterium'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleetTable'
			)));
		}
		
		if(!FleetUtil::isValidCustomFleetSpeed($fleetSpeed))
		{
			unset($session->fleet[$token]);
			$this->printMessage($LNG['invalid_action'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleetTable'
			)));
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
		);

		$this->assign(array(
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
		
		$this->display('page.fleetStep2.default.tpl');
	}
}