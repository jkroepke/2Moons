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
        $config		    = Config::get();

		if (!isset($session->{"fleet_$token"}))
		{
			$this->printMessage($LNG['invalid_action'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleetTable'
			)));
		}

        if ($PLANET['galaxy'] == $targetGalaxy && $PLANET['system'] == $targetSystem && $PLANET['planet'] == $targetPlanet && $PLANET['planet_type'] == $targetType)
        {
            $this->printMessage($LNG['fl_error_same_planet'], array(array(
                'label'	=> $LNG['sys_back'],
                'url'	=> 'game.php?page=fleetTable'
            )));
        }

        if ($targetGalaxy < 1 || $targetGalaxy > $config->max_galaxy ||
            $targetSystem < 1 || $targetSystem > $config->max_system ||
            $targetPlanet < 1 || $targetPlanet > ($config->max_planets + 1) ||
            ($targetType !== 1 && $targetType !== 2 && $targetType !== 3)) {
            $this->printMessage($LNG['fl_invalid_target'], array(array(
                'label'	=> $LNG['sys_back'],
                'url'	=> 'game.php?page=fleetTable'
            )));
        }

		if(!FleetUtil::isValidCustomFleetSpeed($fleetSpeed))
		{
			unset($session->{"fleet_$token"});
			$this->printMessage($LNG['invalid_action'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleetTable'
			)));
		}

		$missionData	= $session->{"fleet_$token"};

		if($missionData['userId'] != $USER['id'] || $missionData['planetId'] != $PLANET['id'])
		{
			unset($session->{"fleet_$token"});
			$this->printMessage($LNG['invalid_action'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleetTable'
			)));
		}

        $db = Database::get();
        $sql = "SELECT id, id_owner, der_metal, der_crystal FROM %%PLANETS%% WHERE universe = :universe AND galaxy = :targetGalaxy AND system = :targetSystem AND planet = :targetPlanet AND planet_type = '1';";
        $targetPlanetData = $db->selectSingle($sql, array(
            ':universe' => Universe::current(),
            ':targetGalaxy' => $targetGalaxy,
            ':targetSystem' => $targetSystem,
            ':targetPlanet' => $targetPlanet
        ));

        if($targetType != PLANET && $targetPlanetData === false)
		{
			unset($session->{"fleet_$token"});
			$this->printMessage($LNG['fl_target_not_exists'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleet1'
			)));
		}

        if($targetType == DEBRIS && $targetPlanetData['der_metal'] == 0 && $targetPlanetData['der_crystal'] == 0)
		{
			unset($session->{"fleet_$token"});
			$this->printMessage($LNG['fl_error_empty_derbis'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleet1'
			)));
		}

		$availableMissions	= FleetUtil::getAvailableMissions($USER, $missionData['fleetData'], $targetPlanetData,!!$fleetGroup);

		if(empty($availableMissions))
		{
			unset($session->{"fleet_$token"});
			$this->printMessage($LNG['fl_empty_target'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleetTable'
			)));
		}
		
		$GameSpeedFactor	= FleetUtil::GetGameSpeedFactor();
		$MaxFleetSpeed 		= FleetUtil::GetFleetMaxSpeed($missionData['fleetData'], $USER);

		$distance			= FleetUtil::GetTargetDistance(
			array($PLANET['galaxy'], $PLANET['system'], $PLANET['planet']),
			array($targetGalaxy, $targetSystem, $targetPlanet)
		);

		$duration			= FleetUtil::GetMissionDuration($fleetSpeed, $MaxFleetSpeed, $distance, $GameSpeedFactor, $USER);
		$consumption		= FleetUtil::GetFleetConsumption($missionData['fleetData'], $duration, $distance, $USER, $GameSpeedFactor);

		$restResources		= array();
		$missingResources	= array();

		foreach($consumption as $elementResourceId => $value)
		{
			$elementResourceObj	= Vars::getElement($elementResourceId);
			if($elementResourceObj->isUserResource())
			{
				$currentAmount = $USER[$elementResourceObj->name];
			}
			else
			{
				$currentAmount = $PLANET[$elementResourceObj->name];
			}

			$restResources[$elementResourceId]	= $currentAmount - $value;
			if($restResources[$elementResourceId] < 0)
			{
				$missingResources[$elementResourceId] = abs($currentAmount - $value);
			}
		}

		if(!empty($missingResources))
		{
			unset($session->{"fleet_$token"});

			$missingList	= array();
			foreach($missingResources as $elementResourceId => $value)
			{
				$missingList[$LNG['tech'][$elementResourceId]]	= $value;
			}

			$this->printMessage($LNG['fl_not_enough_consumption'].' '.Language::createHumanReadableList($missingList), array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleetTable'
			)));
		}

		$stayTimes	= FleetUtil::getStayTimes($USER, $availableMissions);

		$missionData['distance']			= $distance;
		$missionData['duration']			= $duration;
		$missionData['targetGalaxy']		= $targetGalaxy;
		$missionData['targetSystem']		= $targetSystem;
		$missionData['targetPlanet']		= $targetPlanet;
		$missionData['targetType']			= $targetType;
		$missionData['fleetGroup']		    = $fleetGroup;
		$missionData['fleetSpeed']			= $MaxFleetSpeed;
        $missionData['availableMissions']	= $availableMissions;
        $missionData['consumption']			= $consumption;
        $missionData['stayTimes']			= $stayTimes;

		$session->{"fleet_$token"}		= $missionData;

		if(!empty($fleet_group))
		{
			$targetMission	= 2;
		}

		$fleetData	= array(
			'fleetRoom'		=> floattostring($missionData['fleetRoom']),
			'restResources'	=> array_map('floattostring', $restResources),
			'consumption'	=> floattostring(array_sum($consumption)),
		);

		$this->assign(array(
			'token' 				=> $token,
			'ownPlanet'			 	=> array(
				'galaxy'	=> $PLANET['galaxy'],
				'system'	=> $PLANET['system'],
				'planet'	=> $PLANET['planet'],
				'type'		=> $PLANET['planet_type']
			),
			'fleetData'				=> $fleetData,
			'targetMission'			=> $targetMission,
			'availableMissions' 	=> $availableMissions,
			'StaySelector' 			=> $stayTimes,
			'fl_dm_alert_message'	=> sprintf($LNG['fl_dm_alert_message'], $LNG['type_mission'][11], $LNG['tech'][921]),
		));

		// Cache it
		$this->assign(array(
			'resourceElementIds'	=> array_keys(Vars::getElements(Vars::CLASS_RESOURCE, Vars::FLAG_TRANSPORT)),
		), false);
		
		$this->display('page.fleetStep2.default.tpl');
	}
}