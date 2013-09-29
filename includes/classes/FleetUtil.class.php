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

class FleetUtil
{
	static $allowedSpeed	= array(100, 90, 80, 70, 60, 50, 40, 30, 20, 10);
	
	private static function GetShipConsumption(Element $elementObj, $USER)
	{
        $techLevel      = self::getShipTechLevel($elementObj, $USER);

        $consumption    = array();
        foreach(array_keys(Vars::getElements(NULL, array(Vars::FLAG_RESOURCE_PLANET, Vars::FLAG_RESOURCE_USER))) as $elementId)
        {
            $consumption[$elementId]    = $elementObj->consumption[$techLevel][$elementId];
        }

		return $consumption;
	}

	private static function OnlyShipByID($Ships, $elementId)
	{
		return isset($Ships[$elementId]) && count($Ships) === 1;
	}

	public static function getShipTechLevel(Element $elementObj, $USER)
	{
        if(is_null($elementObj->speed2Tech))
        {
            return 1;
        }

        $tech2ElementObj    = Vars::getElement($elementObj->speed2Tech);

        if($USER[$tech2ElementObj->name] < $elementObj->speed2onLevel)
        {
            return 1;
        }

        if(is_null($elementObj->speed3Tech))
        {
            return 2;
        }

        $tech3ElementObj    = Vars::getElement($elementObj->speed3Tech);

        if($USER[$tech3ElementObj->name] < $elementObj->speed3onLevel)
        {
            return 2;
        }

        return 3;
	}

	private static function GetShipSpeed(Element $elementObj, $USER)
	{
        $techLevel  = self::getShipTechLevel($elementObj, $USER);

        $techElementObj = $elementObj->{'speed'.$techLevel.'Tech'};

        $speed	    = $elementObj->{'speed'.$techLevel};

		switch($elementObj->{'speed'.$techLevel.'Tech'})
		{
			case 115:
				$speed	*= 1 + (0.1 * $USER[$techElementObj->name]);
			break;
			case 117:
				$speed	*= 1 + (0.2 * $USER[$techElementObj->name]);
			break;
			case 118:
				$speed	*= 1 + (0.3 * $USER[$techElementObj->name]);
			break;
		}

		return $speed;
	}
	
	public static function getExpeditionLimit($USER)
	{
		return floor(sqrt($USER[Vars::getElement(124)->name]));
	}
	
	public static function getDMMissionLimit($USER)
	{
		return Config::get($USER['universe'])->max_dm_missions;
	}
	
	public static function getMissileRange($USER)
	{
		return max(($USER[Vars::getElement(117)->name] * 5) - 1, 0);
	}
	
	public static function isValidCustomFleetSpeed($speed)
	{
		return in_array($speed, self::$allowedSpeed);
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
		$duration	= (3500 / ($SpeedFactor / 100)) * pow($Distance * 10 / $MaxFleetSpeed, 0.5) + 10;
		$duration	/= $GameSpeed;
		$duration	+= PlayerUtil::getBonusValue($SpeedFactor, 'FlyTime', $USER);

		return max(round($duration), MIN_FLEET_TIME);
	}
 
	public static function getMissileDuration($startSystem, $targetSystem)
	{
		$Distance = abs($startSystem - $targetSystem);
		$Duration = max(round((30 + 60 * $Distance) / self::GetGameSpeedFactor()), MIN_FLEET_TIME);
		
		return $Duration;
	}

	public static function GetGameSpeedFactor()
	{
		return Config::get()->fleet_speed / 2500;
	}
	
	public static function GetMaxFleetSlots($USER)
	{
		return 1 + PlayerUtil::getBonusValue(1, 'FleetSlots', $USER);
	}

	public static function GetFleetRoom($fleetArray)
	{
		$FleetRoom 				= 0;
		foreach ($fleetArray as $elementId => $count)
		{
			$FleetRoom		   += Vars::getElement($elementId)->capacity * $count;
		}

		return $FleetRoom;
	}
	
	public static function GetFleetMaxSpeed($fleetArray, $USER)
	{
        $fleetArray = !is_array($fleetArray) ? array($fleetArray) : array_keys($fleetArray);
		$shipSpeeds = array();
		
		foreach ($fleetArray as $elementId)
        {
            $shipSpeeds[$elementId] = self::GetShipSpeed(Vars::getElement($elementId), $USER);
		}
		
		return min($shipSpeeds);
	}

	public static function GetFleetConsumption($fleetData, $MissionDuration, $MissionDistance, $USER, $GameSpeed)
	{
		$elementResourceIds	= array_keys(Vars::getElements(Vars::CLASS_RESOURCE, array(Vars::FLAG_RESOURCE_PLANET, Vars::FLAG_RESOURCE_USER)));
		$missionConsumption = ArrayUtil::combineArrayWithSingleElement($elementResourceIds, 0);

		foreach ($fleetData as $elementId => $shipAmount)
		{
            $elementObj         = Vars::getElement($elementId);
			$shipSpeed          = self::GetShipSpeed($elementObj, $USER);
			$shipConsumption    = self::GetShipConsumption($elementObj, $USER);

			$basicValue			= 35000 / (round($MissionDuration, 0) * $GameSpeed - 10) * sqrt($MissionDistance * 10 / $shipSpeed);

			foreach($shipConsumption as $elementResourceId => $consumption)
			{
				$missionConsumption[$elementResourceId]	+= round($consumption * $shipAmount * $MissionDistance / 35000 * pow($basicValue / 10 + 1, 2));
			}
		}

		return $missionConsumption;
	}

	public static function getStayTimes($USER, $availableMissions)
	{
		$stayTimes	= array();

		$haltSpeed	= Config::get($USER['universe'])->halt_speed;

		$availableMissions	= array_keys($availableMissions);

		if (isset($availableMissions[15]))
		{
			$level = $USER[Vars::getElement(124)->name];

			for($i = 1;$i <= $level;$i++)
			{
				$stayTimes[$i]	= round($i / $haltSpeed, 2);
			}
		}
		elseif(isset($availableMissions[11]))
		{
			$stayTimes = array(1 => 1);
		}
		elseif(isset($availableMissions[5]))
		{
			$stayTimes = array(1 => 1, 2 => 2, 4 => 4, 8 => 8, 12 => 12, 16 => 16, 32 => 32);
		}
		
		return $stayTimes;
	}

	/*
	 *
	 * Unserialize an Fleetstring to an array
	 *
	 * @param string
	 *
	 * @return array
	 *
	 */

	public static function unserialize($fleetAmount)
	{
		$fleetType		= explode(';', $fleetAmount);

		$fleetAmount	= array();

		foreach ($fleetType as $fleetTyp)
		{
			$temp = explode(',', $fleetTyp);

			if (empty($temp[0])) continue;

			if (!isset($fleetAmount[$temp[0]]))
			{
				$fleetAmount[$temp[0]] = 0;
			}

			$fleetAmount[$temp[0]] += $temp[1];
		}

		return $fleetAmount;
	}

	public static function GetACSDuration($acsId)
	{
		if(empty($acsId))
		{
			return 0;
		}

		$sql			= 'SELECT ankunft FROM %%AKS%% WHERE id = :acsId;';
		$acsEndTime 	= Database::get()->selectSingle($sql, array(
			':acsId'	=> $acsId
		), 'ankunft');
		
		return empty($acsEndTime) ? $acsEndTime - TIMESTAMP : 0;
	}
	
	public static function setACSTime($timeDifference, $acsId)
	{
		if(empty($acsId))
		{
			throw new InvalidArgumentException('Missing acsId on '.__CLASS__.'::'.__METHOD__);
		}

		$db		= Database::get();

		$sql	= 'UPDATE %%AKS%% SET ankunft = ankunft + :time WHERE id = :acsId;';
		$db->update($sql, array(
			':time'		=> $timeDifference,
			':acsId'	=> $acsId,
		));

		$sql	= 'UPDATE %%FLEETS%%, %%FLEETS_EVENT%% SET
		fleet_start_time = fleet_start_time + :time,
		fleet_end_stay   = fleet_end_stay + :time,
		fleet_end_time   = fleet_end_time + :time,
		time             = time + :time
		WHERE fleet_group = :acsId AND fleet_id = fleetID;';

		$db->update($sql, array(
			':time'		=> $timeDifference,
			':acsId'	=> $acsId,
		));

        return true;
	}

	public static function GetCurrentFleets($userId, $fleetMission = 10, $thisMission = false)
	{
		if($thisMission)
		{
			$sql = 'SELECT COUNT(*) as state
			FROM %%FLEETS%%
			WHERE fleet_owner = :userId
			AND fleet_mission = :fleetMission;';
		}
		else
		{
			$sql = 'SELECT COUNT(*) as state
			FROM %%FLEETS%%
			WHERE fleet_owner = :userId
			AND fleet_mission != :fleetMission;';
		}

		$ActualFleets = Database::get()->selectSingle($sql, array(
			':userId'		=> $userId,
			':fleetMission'	=> $fleetMission,
		));
		return $ActualFleets['state'];
	}	
	
	public static function SendFleetBack($USER, $FleetID)
	{
		$db				= Database::get();

		$sql			= 'SELECT start_time, fleet_mission, fleet_group, fleet_owner, fleet_mess FROM %%FLEETS%% WHERE fleet_id = :fleetId;';
		$fleetResult	= $db->selectSingle($sql, array(
			':fleetId'	=> $FleetID,
		));

		if ($fleetResult['fleet_owner'] != $USER['id'] || $fleetResult['fleet_mess'] == 1)
		{
			return false;
		}

		$sqlWhere	= 'fleet_id';

		if($fleetResult['fleet_mission'] == 1 && $fleetResult['fleet_group'] != 0)
		{
			$sql		= 'SELECT COUNT(*) as state FROM %%USERS_ACS%% WHERE acsID = :acsId;';
			$isInGroup	= $db->selectSingle($sql, array(
				':acsId'	=> $fleetResult['fleet_group'],
			), 'state');

			if($isInGroup)
			{
				$sql = 'DELETE %%AKS%%, %%USERS_ACS%%
				FROM %%AKS%%
				LEFT JOIN %%USERS_ACS%% ON acsID = %%AKS%%.id
				WHERE %%AKS%%.id = :acsId;';

				$db->delete($sql, array(
					':acsId'	=> $fleetResult['fleet_group']
			  	));
				
				$FleetID	= $fleetResult['fleet_group'];
				$sqlWhere	= 'fleet_group';
			}
		}
		
		$fleetEndTime	= (TIMESTAMP - $fleetResult['start_time']) + TIMESTAMP;
		
		$sql	= 'UPDATE %%FLEETS%%, %%FLEETS_EVENT%% SET
		fleet_group			= :fleetGroup,
		fleet_end_stay		= :endStayTime,
		fleet_end_time		= :endTime,
		fleet_mess			= :fleetState,
		hasCanceled			= :hasCanceled,
		time				= :endTime
		WHERE '.$sqlWhere.' = :id AND fleet_id = fleetID;';

		$db->update($sql, array(
			':id'			=> $FleetID,
			':endStayTime'	=> TIMESTAMP,
			':endTime'		=> $fleetEndTime,
			':fleetGroup'	=> 0,
			':hasCanceled'	=> 1,
			':fleetState'	=> FLEET_RETURN
		));

		$sql	= 'UPDATE %%LOG_FLEETS%% SET
		fleet_end_stay	= :endStayTime,
		fleet_end_time	= :endTime,
		fleet_mess		= :fleetState,
		fleet_state		= 2
		WHERE '.$sqlWhere.' = :id;';

		$db->update($sql, array(
			':id'			=> $FleetID,
			':endStayTime'	=> TIMESTAMP,
			':endTime'		=> $fleetEndTime,
			':fleetState'	=> FLEET_RETURN
		));

		return true;
	}
	
	public static function GetFleetShipInfo($fleetData, $USER)
	{
		$FleetInfo	= array();
		foreach ($fleetData as $elementId => $Amount)
        {

			$FleetInfo[$elementId]	= array(
                'consumption'   => self::GetShipConsumption(Vars::getElement($elementId), $USER),
                'speed'         => self::GetFleetMaxSpeed($elementId, $USER),
                'amount'        => floattostring($Amount)
            );
		}
		return $FleetInfo;
	}

	public static function calcStructurePoints(Element $elementObj)
	{
        $costResources  = BuildUtil::getElementPrice($elementObj);
        $structure      = 0;

        foreach(array_keys(Vars::getElements(NULL, Vars::FLAG_CALC_FLEET_STRUCTURE)) as $elementId)
        {
            $structure  += $costResources[$elementId];
        }

        return $structure;
	}

	public static function getAvailableMissions($USER, $fleetData, $targetPlanet, $isFleetGroup)
	{	
		$ownPlanet				= !empty($targetPlanet['id_owner']) && $targetPlanet['id_owner'] == $USER['id'] ? true : false;
		$usedPlanet				= !!$targetPlanet;
		$availableMissions		= array();
		
		if ($targetPlanet['planet'] == (Config::get($USER['universe'])->max_planets + 1) && isModulAvalible(MODULE_MISSION_EXPEDITION))
		{
			$availableMissions[]	= 15;
		}
		elseif ($targetPlanet['planet_type'] == 2)
		{
			if (ArrayUtil::checkIfOneKeyExists($fleetData, array_keys(Vars::getElements(Vars::CLASS_FLEET, Vars::FLAG_COLLECT)))
				&& isModulAvalible(MODULE_MISSION_RECYCLE) && !($targetPlanet['der_metal'] == 0 && $targetPlanet['der_crystal'] == 0))
			{
				$availableMissions[]	= 8;
			}
		}
		else
		{
			if (!$usedPlanet)
			{
				if (ArrayUtil::checkIfOneKeyExists($fleetData, array_keys(Vars::getElements(Vars::CLASS_FLEET, Vars::FLAG_COLONIZE)))
					&& isModulAvalible(MODULE_MISSION_COLONY))
				{
					$availableMissions[]	= 7;
				}
			}
			else
			{
				if(isModulAvalible(MODULE_MISSION_TRANSPORT))
					$availableMissions[]	= 3;
					
				if (!$ownPlanet && ArrayUtil::hasOnlyAllowedKeys(array_keys(Vars::getElements(Vars::CLASS_FLEET, Vars::FLAG_SPY)), $fleetData) && isModulAvalible(MODULE_MISSION_SPY))
					$availableMissions[]	= 6;

				if (!$ownPlanet) {
					if(isModulAvalible(MODULE_MISSION_ATTACK))
						$availableMissions[]	= 1;
					if(isModulAvalible(MODULE_MISSION_HOLD))
						$availableMissions[]	= 5;}
						
				elseif(isModulAvalible(MODULE_MISSION_STATION)) {
					$availableMissions[]	= 4;}
					
				if ($isFleetGroup && !$ownPlanet && isModulAvalible(MODULE_MISSION_ATTACK) && isModulAvalible(MODULE_MISSION_ACS))
					$availableMissions[]	= 2;

				if (!$ownPlanet && $targetPlanet['planet_type'] == 3 && isset($fleetData[214]) && isModulAvalible(MODULE_MISSION_DESTROY))
					$availableMissions[]	= 9;

				if ($ownPlanet && $targetPlanet['planet_type'] == 3 && ArrayUtil::hasOnlyAllowedKeys(array(220), $fleetData) && isModulAvalible(MODULE_MISSION_DARKMATTER))
					$availableMissions[]	= 11;
			}
		}

		return $availableMissions;
	}
	
	public static function CheckBash($Target, $USER)
	{
		if(!BASH_ON)
		{
			return false;
		}

		$sql	= 'SELECT COUNT(*) as state
		FROM %%LOG_FLEETS%%
		WHERE fleet_owner = :fleetOwner,
		AND fleet_end_id = :fleetEndId,
		AND fleet_state != :fleetState,
		AND fleet_start_time > :fleetStartTime,
		AND fleet_mission IN (1,2,9);';

		$Count	= Database::get()->selectSingle($sql, array(
			':fleetOwner'		=> $USER['id'],
			':fleetEndId'		=> $Target,
			':fleetState'		=> 2,
			':fleetStartTime'	=> TIMESTAMP - BASH_TIME,
		));

		return $Count >= BASH_COUNT;
	}
	
	public static function sendFleet($fleetArray, $fleetMission, $fleetStartOwner, $fleetStartPlanetID,
		$fleetStartPlanetGalaxy, $fleetStartPlanetSystem, $fleetStartPlanetPlanet, $fleetStartPlanetType,
		$fleetTargetOwner, $fleetTargetPlanetID, $fleetTargetPlanetGalaxy, $fleetTargetPlanetSystem,
		$fleetTargetPlanetPlanet, $fleetTargetPlanetType, $fleetResource, $fleetStartTime, $fleetStayTime,
		$fleetEndTime, $fleetGroup = 0, $missileTarget = 0)
	{
		global $resource;
		$fleetShipCount	= array_sum($fleetArray);
		$fleetData		= array();

		$db				= Database::get();

		$params			= array(':planetId'	=> $fleetStartPlanetID);

		$planetQuery	= "";
        $fleetQuery	    = array();

		foreach($fleetArray as $elementId => $ShipCount) {
			$fleetData[]	= $elementId.','.floattostring($ShipCount);
			$planetQuery[]	= $resource[$elementId]." = ".$resource[$elementId]." - :".$resource[$elementId];

			$params[':'.$resource[$elementId]]	= floattostring($ShipCount);
		}

		$sql	= 'UPDATE %%PLANETS%% SET '.implode(', ', $planetQuery).' WHERE id = :planetId;';

		$db->update($sql, $params);

        $params = array(
            ':fleetStartOwner'			=> $fleetStartOwner,
            ':fleetTargetOwner'			=> $fleetTargetOwner,
            ':fleetMission'				=> $fleetMission,
            ':fleetShipCount'			=> $fleetShipCount,
            ':fleetData'				=> implode(';', $fleetData),
            ':fleetStartTime'			=> $fleetStartTime,
            ':fleetStayTime'			=> $fleetStayTime,
            ':fleetEndTime'				=> $fleetEndTime,
            ':fleetStartPlanetID'		=> $fleetStartPlanetID,
            ':fleetStartPlanetGalaxy'	=> $fleetStartPlanetGalaxy,
            ':fleetStartPlanetSystem'	=> $fleetStartPlanetSystem,
            ':fleetStartPlanetPlanet'	=> $fleetStartPlanetPlanet,
            ':fleetStartPlanetType'		=> $fleetStartPlanetType,
            ':fleetTargetPlanetID'		=> $fleetTargetPlanetID,
            ':fleetTargetPlanetGalaxy'	=> $fleetTargetPlanetGalaxy,
            ':fleetTargetPlanetSystem'	=> $fleetTargetPlanetSystem,
            ':fleetTargetPlanetPlanet'	=> $fleetTargetPlanetPlanet,
            ':fleetTargetPlanetType'	=> $fleetTargetPlanetType,
            ':fleetGroup'				=> $fleetGroup,
            ':missileTarget'			=> $missileTarget,
            ':timestamp'				=> TIMESTAMP,
            ':universe'	   				=> Universe::current(),
        );

        foreach(Vars::getElements(Vars::CLASS_RESOURCE, Vars::FLAG_TRANSPORT) as $elementId => $elementObj) {
            $fleetQuery[]	= ', fleet_resource_'.$elementObj->name.' = :fleetResource';
            $params[':fleetResource'.$elementId]	= floattostring($fleetResource[$elementId]);
        }

		$sql	= 'INSERT INTO %%FLEETS%% SET
		fleet_owner					= :fleetStartOwner,
		fleet_target_owner			= :fleetTargetOwner,
		fleet_mission				= :fleetMission,
		fleet_amount				= :fleetShipCount,
		fleet_array					= :fleetData,
		fleet_universe				= :universe,
		fleet_start_time			= :fleetStartTime,
		fleet_end_stay				= :fleetStayTime,
		fleet_end_time				= :fleetEndTime,
		fleet_start_id				= :fleetStartPlanetID,
		fleet_start_galaxy			= :fleetStartPlanetGalaxy,
		fleet_start_system			= :fleetStartPlanetSystem,
		fleet_start_planet			= :fleetStartPlanetPlanet,
		fleet_start_type			= :fleetStartPlanetType,
		fleet_end_id				= :fleetTargetPlanetID,
		fleet_end_galaxy			= :fleetTargetPlanetGalaxy,
		fleet_end_system			= :fleetTargetPlanetSystem,
		fleet_end_planet			= :fleetTargetPlanetPlanet,
		fleet_end_type				= :fleetTargetPlanetType,
		fleet_group					= :fleetGroup,
		fleet_target_obj			= :missileTarget,
		start_time					= :timestamp
		'.implode("\n", $fleetQuery).';';

		$db->insert($sql, $params);

		$fleetId	= $db->lastInsertId();

		$sql	= 'INSERT INTO %%FLEETS_EVENT%% SET fleetID	= :fleetId, `time` = :endTime;';
		$db->insert($sql, array(
			':fleetId'	=> $fleetId,
			':endTime'	=> $fleetStartTime
		));

        $params[':fleetId'] = $fleetId;


		$sql	= 'INSERT INTO %%LOG_FLEETS%% SET
		fleet_id					= :fleetId,
		fleet_owner					= :fleetStartOwner,
		fleet_target_owner			= :fleetTargetOwner,
		fleet_mission				= :fleetMission,
		fleet_amount				= :fleetShipCount,
		fleet_array					= :fleetData,
		fleet_universe				= :universe,
		fleet_start_time			= :fleetStartTime,
		fleet_end_stay				= :fleetStayTime,
		fleet_end_time				= :fleetEndTime,
		fleet_start_id				= :fleetStartPlanetID,
		fleet_start_galaxy			= :fleetStartPlanetGalaxy,
		fleet_start_system			= :fleetStartPlanetSystem,
		fleet_start_planet			= :fleetStartPlanetPlanet,
		fleet_start_type			= :fleetStartPlanetType,
		fleet_end_id				= :fleetTargetPlanetID,
		fleet_end_galaxy			= :fleetTargetPlanetGalaxy,
		fleet_end_system			= :fleetTargetPlanetSystem,
		fleet_end_planet			= :fleetTargetPlanetPlanet,
		fleet_end_type				= :fleetTargetPlanetType,
		fleet_resource_metal		= :fleetResource901,
		fleet_resource_crystal		= :fleetResource902,
		fleet_resource_deuterium	= :fleetResource903,
		fleet_group					= :fleetGroup,
		fleet_target_obj			= :missileTarget,
		start_time					= :timestamp
		'.implode("\n", $fleetQuery).';';

		$db->insert($sql,$params);
	}
}