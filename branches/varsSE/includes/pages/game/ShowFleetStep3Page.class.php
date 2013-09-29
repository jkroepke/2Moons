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

class ShowFleetStep3Page extends AbstractGamePage
{
	public static $requireModule = MODULE_FLEET_TABLE;

	function __construct()
	{
		parent::__construct();
	}

	public function show()
	{
		global $USER, $PLANET, $LNG;

		$transportResource	= HTTP::_GP('transportResource', array());

		$targetMission	= HTTP::_GP('targetMission', 0);
		$holdTime		= HTTP::_GP('holdTime', 0);
		$token			= HTTP::_GP('token', '');

		$session	    = Session::load();

		$fleetGroupArrivalTime	= 0;
		$holdDuration   		= 0;

		$fleetResource		= array();
		$targetPlayerData	= array();

		if (!isset($session->{"fleet_$token"}))
		{
			$this->printMessage($LNG['invalid_action'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleetTable'
			)));
		}

		$missionData	= $session->{"fleet_$token"};
		#unset($session->{"fleet_$token"});

		if ($missionData['time'] < TIMESTAMP - 180)
		{
			$this->printMessage($LNG['invalid_action'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleetTable'
			)));
		}

		if($missionData['userId'] != $USER['id'] || $missionData['planetId'] != $PLANET['id'])
		{
			unset($session->{"fleet_$token"});
			$this->printMessage($LNG['invalid_action'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleetTable'
			)));
		}

		$duration			= $missionData['duration'];
		$distance			= $missionData['distance'];
		$targetGalaxy		= $missionData['targetGalaxy'];
		$targetSystem		= $missionData['targetSystem'];
		$targetPlanet		= $missionData['targetPlanet'];
		$targetType			= $missionData['targetType'];
		$fleetGroup			= $missionData['fleetGroup'];
		$fleetData  		= $missionData['fleetData'];
		$fleetStorage		= $missionData['fleetRoom'];
		$fleetSpeed			= $missionData['fleetSpeed'];
		$availableMissions	= $missionData['availableMissions'];
		$consumption		= $missionData['consumption'];
		$stayTimes			= $missionData['stayTimes'];

		unset($missionData);

		if (array_sum($consumption) + array_sum($transportResource) > $fleetStorage)
		{
			$this->printMessage($LNG['fl_not_enough_space'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleetTable'
			)));
		}

		if (!in_array($targetMission, $availableMissions))
		{
			$this->printMessage($LNG['fl_invalid_mission'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleet2'
			)));
		}

		if($targetMission == 5 || $targetMission == 11 || $targetMission == 15)
		{
			if(!isset($stayTimes[$holdTime]))
			{
				$this->printMessage($LNG['fl_hold_time_not_exists'], array(array(
					'label'	=> $LNG['sys_back'],
					'url'	=> 'game.php?page=fleetTable'
				)));
			}

			$holdDuration    = round($stayTimes[$holdTime] * 3600, 0);
		}

		$usedFleetSlots	= FleetUtil::getUsedSlots($USER['id']);

		if (FleetUtil::GetMaxFleetSlots($USER) <= $usedFleetSlots)
		{
			$this->printMessage($LNG['fl_no_slots'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleetTable'
			)));
		}

		if($targetMission != 2)
		{
			$fleetGroup	= 0;
		}

		$db = Database::get();

		if(!empty($fleetGroup))
		{
			$sql = "SELECT ankunft FROM %%USERS_ACS%% INNER JOIN %%AKS%% ON id = acsID
			WHERE acsID = :acsID AND :maxFleets > (SELECT COUNT(*) FROM %%FLEETS%% WHERE fleet_group = :acsID);";
			$fleetGroupArrivalTime = $db->selectSingle($sql, array(
				':acsID'        => $fleetGroup,
				':maxFleets'    => Config::get()->max_fleets_per_acs,
			), 'ankunft');

			if (empty($fleetGroupArrivalTime)) {
				$this->printMessage($LNG['invalid_action'], array(array(
					'label'	=> $LNG['sys_back'],
					'url'	=> 'game.php?page=fleetTable'
				)));
			}
		}

		$sql = "SELECT id, id_owner, der_metal, der_crystal, destroyed, ally_deposit FROM %%PLANETS%% WHERE universe = :universe AND galaxy = :targetGalaxy AND system = :targetSystem AND planet = :targetPlanet AND planet_type = :targetType;";
		$targetPlanetData = $db->selectSingle($sql, array(
			':universe'     => Universe::current(),
			':targetGalaxy' => $targetGalaxy,
			':targetSystem' => $targetSystem,
			':targetPlanet' => $targetPlanet,
			':targetType'	=> ($targetType == 2 ? 1 : $targetType),
		));

		if ($targetMission == 7)
		{
			if (!empty($targetPlanetData)) {
				$this->printMessage($LNG['fl_target_exists'], array(array(
					'label'	=> $LNG['sys_back'],
					'url'	=> 'game.php?page=fleetTable'
				)));
			}

			if ($targetType != 1) {
				$this->printMessage($LNG['fl_only_planets_colonizable'], array(array(
					'label'	=> $LNG['sys_back'],
					'url'	=> 'game.php?page=fleetTable'
				)));
			}
		}

		if ($targetMission == 7 || $targetMission == 15)
		{
			$targetPlanetData	= array('id' => 0, 'id_owner' => 0, 'planet_type' => 1);
		}
		elseif (empty($targetPlanetData) || $targetPlanetData["destroyed"] != 0)
		{
			$this->printMessage($LNG['fl_no_target'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleetTable'
			)));
		}

		if ($targetMission == 11)
		{
			$activeExpedition	= FleetUtil::getUsedSlots($USER['id'], 11);
			$maxExpedition		= FleetUtil::getDMMissionLimit($USER);

			if ($activeExpedition >= $maxExpedition) {
				$this->printMessage($LNG['fl_no_expedition_slot'], array(array(
					'label'	=> $LNG['sys_back'],
					'url'	=> 'game.php?page=fleetTable'
				)));
			}
		}
		elseif ($targetMission == 15)
		{
			$activeExpedition	= FleetUtil::getUsedSlots($USER['id'], 15, true);
			$maxExpedition		= FleetUtil::getExpeditionLimit($USER);

			if ($activeExpedition >= $maxExpedition) {
				$this->printMessage($LNG['fl_no_expedition_slot'], array(array(
					'label'	=> $LNG['sys_back'],
					'url'	=> 'game.php?page=fleetTable'
				)));
			}
		}

		$usedPlanet			= isset($targetPlanetData['id_owner']);
		$myPlanet			= $usedPlanet && $targetPlanetData['id_owner'] == $USER['id'];

		if($targetMission == 7 || $targetMission == 15)
		{
			$targetPlayerData	= array(
				'id'				=> 0,
				'onlinetime'		=> TIMESTAMP,
				'ally_id'			=> 0,
				'urlaubs_modus'		=> 0,
				'authattack'		=> 0,
				'total_points'		=> 0,
			);
		}
		elseif($myPlanet)
		{
			$targetPlayerData	= $USER;
		}
		elseif(!empty($targetPlanetData['id_owner']))
		{
			$sql = "SELECT user.id, user.onlinetime, user.ally_id, user.urlaubs_modus, user.banaday, user.authattack,
                stat.total_points
                FROM %%USERS%% as user
                LEFT JOIN %%STATPOINTS%% as stat ON stat.id_owner = user.id AND stat.stat_type = '1'
                WHERE user.id = :ownerID;";

			$targetPlayerData = $db->selectSingle($sql, array(
				':ownerID'  => $targetPlanetData['id_owner']
			));
		}

		if(empty($targetPlayerData))
		{
			$this->printMessage($LNG['fl_empty_target'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleetTable'
			)));
		}

		if ($targetMission != 8 && IsVacationMode($targetPlayerData))
		{
			$this->printMessage($LNG['fl_target_exists'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleetTable'
			)));
		}

		if(($targetMission == 1 || $targetMission == 2 || $targetMission == 9) && FleetUtil::CheckBash($targetPlanetData['id'], $USER))
		{
			$this->printMessage($LNG['fl_bash_protection'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleetTable'
			)));
		}

		if($targetMission == 1 || $targetMission == 2 || $targetMission == 5 || $targetMission == 6 || $targetMission == 9)
		{
			if(Config::get()->adm_attack == 1 && $targetPlayerData['authattack'] > $USER['authlevel'])
			{
				$this->printMessage($LNG['fl_admin_attack'], array(array(
					'label'	=> $LNG['sys_back'],
					'url'	=> 'game.php?page=fleetTable'
				)));
			}

			$sql	= 'SELECT total_points
			FROM %%STATPOINTS%%
			WHERE id_owner = :userId AND stat_type = :statType';

			$USER	+= Database::get()->selectSingle($sql, array(
				':userId'	=> $USER['id'],
				':statType'	=> 1
			));

			$playerStatus	= CheckNoobProtec($USER, $targetPlayerData, $targetPlayerData);

			if ($playerStatus['NoobPlayer'])
			{
				$this->printMessage($LNG['fl_player_is_noob'], array(array(
					'label'	=> $LNG['sys_back'],
					'url'	=> 'game.php?page=fleetTable'
				)));
			}

			if ($playerStatus['StrongPlayer'])
			{
				$this->printMessage($LNG['fl_player_is_strong'], array(array(
					'label'	=> $LNG['sys_back'],
					'url'	=> 'game.php?page=fleetTable'
				)));
			}
		}

		if ($targetMission == 5 && $targetPlayerData['ally_id'] != $USER['ally_id'])
		{
			$sql = "SELECT COUNT(*) as state FROM %%BUDDY%%
			WHERE id NOT IN (SELECT id FROM %%BUDDY_REQUEST%% WHERE %%BUDDY_REQUEST%%.id = %%BUDDY%%.id) AND
			(owner = :ownerID AND sender = :userID) OR (owner = :userID AND sender = :ownerID);";
			$buddy = $db->selectSingle($sql, array(
				':ownerID'  => $targetPlayerData['id'],
				':userID'   => $USER['id']
			), 'state');

			if($buddy == 0)
			{
				$this->printMessage($LNG['fl_no_same_alliance'], array(array(
					'label'	=> $LNG['sys_back'],
					'url'	=> 'game.php?page=fleetTable'
				)));
			}
		}

		$_USER		= $USER;
		$_PLANET	= $PLANET;

		foreach($consumption as $resourceElementId => $value)
		{
			$resourceElementObj	= Vars::getElement($resourceElementId);
			if ($resourceElementObj->isUserResource())
			{
				if($value > $_USER[$resourceElementObj->name])
				{
					$this->printMessage($LNG['fl_not_enough_consumption'].' '.($value - $_USER[$resourceElementObj->name]).' '.$LNG['tech'][$resourceElementId], array(array(
						'label'	=> $LNG['sys_back'],
						'url'	=> 'game.php?page=fleetTable'
					)));
				}
				else
				{
					$_USER[$resourceElementObj->name] -= $value;
				}
			}
			else
			{
				if($value > $_PLANET[$resourceElementObj->name])
				{
					$this->printMessage($LNG['fl_not_enough_consumption'].' '.($value - $_PLANET[$resourceElementObj->name]).' '.$LNG['tech'][$resourceElementId], array(array(
						'label'	=> $LNG['sys_back'],
						'url'	=> 'game.php?page=fleetTable'
					)));
				}
				else
				{
					$_PLANET[$resourceElementObj->name] -= $value;
				}
			}
		}

		$USER		= $_USER;
		$PLANET		= $_PLANET;
		unset($_USER, $_PLANET);

		foreach(Vars::getElements(Vars::CLASS_RESOURCE, Vars::FLAG_TRANSPORT) as $elementId => $elementObj)
		{
			if(!isset($transportResource[$elementId]) || !is_numeric($transportResource[$elementId]))
			{
				$fleetResource[$elementId]	= 0;
				continue;
			}

			if($elementObj->isUserResource())
			{
				$fleetResource[$elementId]	= min(round($transportResource[$elementId]), $USER[$elementObj->name]);
				$USER[$elementObj->name]	= max(0, $USER[$elementObj->name] - $fleetResource[$elementId]);
			}
			else
			{
				$fleetResource[$elementId]	= min(round($transportResource[$elementId]), $PLANET[$elementObj->name]);
				$PLANET[$elementObj->name]	= max(0, $PLANET[$elementObj->name] - $fleetResource[$elementId]);
			}
		}

		$fleetArrivalTime	= $duration + TIMESTAMP;
		$timeDifference		= round(max(0, $fleetArrivalTime - $fleetGroupArrivalTime));

		if($fleetGroup != 0)
		{
			if($timeDifference != 0)
			{
				FleetUtil::setACSTime($timeDifference, $fleetGroup);
			}
			else
			{
				$fleetArrivalTime	= $fleetGroupArrivalTime;
			}
		}

		$fleetStayTime	= $fleetArrivalTime + $holdDuration;
		$fleetEndTime	= $fleetStayTime + $duration;



		foreach ($fleetData as $elementId => $amount)
		{
			if ($amount > $PLANET[Vars::getElement($elementId)->name])
			{
				$this->printMessage($LNG['fl_not_all_ship_avalible'], array(array(
					'label'	=> $LNG['sys_back'],
					'url'	=> 'game.php?page=fleetTable'
				)));
			}

			$PLANET[Vars::getElement($elementId)->name]	-= $amount;
			$this->ecoObj->saveToDatabase('PLANET', Vars::getElement($elementId)->name);
		}

		FleetUtil::sendFleet($fleetData, $targetMission, $USER['id'], $PLANET['id'], $PLANET['galaxy'],
			$PLANET['system'], $PLANET['planet'], $PLANET['planet_type'], $targetPlanetData['id_owner'],
			$targetPlanetData['id'], $targetGalaxy, $targetSystem, $targetPlanet, $targetType, $fleetResource,
			$fleetArrivalTime, $fleetStayTime, $fleetEndTime, $fleetGroup);

		$this->assign(array(
			'targetMission'		=> $targetMission,
			'distance'			=> $distance,
			'consumption'		=> $consumption,
			'from'				=> $PLANET['galaxy'] .":". $PLANET['system']. ":". $PLANET['planet'],
			'destination'		=> $targetGalaxy .":". $targetSystem .":". $targetPlanet,
			'fleetArrivalTime'	=> _date($LNG['php_tdformat'], $fleetArrivalTime, $USER['timezone']),
			'fleetEndTime'		=> _date($LNG['php_tdformat'], $fleetEndTime, $USER['timezone']),
			'fleetSpeed'		=> $fleetSpeed,
			'fleetList'			=> $fleetData,
		));

		$this->display('page.fleetStep3.default.tpl');
	}
}