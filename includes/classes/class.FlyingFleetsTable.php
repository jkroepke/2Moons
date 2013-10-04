<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kr?pke
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
 * @author Jan Kr?pke <info@2moons.cc>
 * @copyright 2012 Jan Kr?pke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.5 (2011-07-31)
 * @info $Id$
 * @link http://2moons.cc/
 */

class FlyingFleetsTable
{
	protected $Mode = null;
	protected $userId	= null;
	protected $planetId = null;
	protected $IsPhalanx = false;
	protected $missions = false;

	public function __construct() {
		
	}

	public function setUser($userId) {
		$this->userId = $userId;
	}

	public function setPlanet($planetId) {
		$this->planetId = $planetId;
	}

	public function setPhalanxMode() {
		$this->IsPhalanx = true;
	}

	public function setMissions($missions) {
		$this->missions = $missions;
	}
	
	private function getFleets($acsID = false)
	{
		$currentFleets	= array();

		if($this->IsPhalanx) {
			$where = '(fleet_start_id = :planetId AND fleet_mission != :missionId) OR
					  (fleet_end_id = :planetId AND fleet_mess IN (0, 2))';
			$param = array(
				':planetId'		=> $this->planetId,
				':missionId'	=> 4
			);
		} elseif(!empty($acsID)) {
			$where	= 'fleet_group = :acsId';
			$param = array(
				':acsId'	=> $acsID
			);
		} elseif($this->missions) {
			$where = '(fleet_owner = :userId OR fleet_target_owner = :userId) AND fleet_mission IN ('.$this->missions.')';
			$param = array(
				':userId'	=> $this->userId
			);
		} else {
			$where  = 'fleet_owner = :userId OR (fleet_target_owner = :userId AND fleet_mission != :missionId)';
			$param = array(
				':userId'		=> $this->userId,
				':missionId'	=> 8
			);
		}

		$sql = 'SELECT DISTINCT fleet.*, ownuser.username as own_username, targetuser.username as target_username,
		ownplanet.name as own_planetname, targetplanet.name as target_planetname
		FROM %%FLEETS%% fleet
		LEFT JOIN %%USERS%% ownuser ON (ownuser.id = fleet.fleet_owner)
		LEFT JOIN %%USERS%% targetuser ON (targetuser.id = fleet.fleet_target_owner)
		LEFT JOIN %%PLANETS%% ownplanet ON (ownplanet.id = fleet.fleet_start_id)
		LEFT JOIN %%PLANETS%% targetplanet ON (targetplanet.id = fleet.fleet_end_id)
		WHERE '.$where.';';

		$fleetResult	= Database::get()->select($sql, $param);

		foreach($fleetResult as $fleetRow)
		{
			$currentFleets[$fleetRow['fleetId']]	= $fleetRow;
		}

		$sql = "SELECT * FROM %%FLEETS_ELEMENTS%% WHERE fleetId IN (".implode(',', array_keys($currentFleets)).");";
		$elementResult = Database::get()->select($sql);

		foreach($elementResult as $elementRow)
		{
			if(!isset($currentFleets[$elementRow['fleetId']])) continue;

			$currentFleets[$elementRow['fleetId']]['elements'][Vars::getElement($elementRow['elementId'])->class][$elementRow['elementId']]	= $elementRow['amount'];
		}

		return $currentFleets;
	}

	public function renderTable()
	{
		$fleetResult	= $this->getFleets();
		$ACSDone		= array();
		$FleetData		= array();
		
		foreach($fleetResult as $fleetRow)
		{
			if ($fleetRow['fleet_mess'] == 0 && $fleetRow['fleet_start_time'] > TIMESTAMP && ($fleetRow['fleet_group'] == 0 || !isset($ACSDone[$fleetRow['fleet_group']])))
			{
				$ACSDone[$fleetRow['fleet_group']]		= true;
				$FleetData[$fleetRow['fleet_start_time'].$fleetRow['fleetId']] = $this->BuildFleetEventTable($fleetRow, 0);
			}
				
			if ($fleetRow['fleet_mission'] == 10 || ($fleetRow['fleet_mission'] == 4 && $fleetRow['fleet_mess'] == 0))
				continue;
				
			if ($fleetRow['fleet_end_stay'] != $fleetRow['fleet_start_time'] && $fleetRow['fleet_end_stay'] > TIMESTAMP && ($this->IsPhalanx && $fleetRow['fleet_end_id'] == $this->planetId))
				$FleetData[$fleetRow['fleet_end_stay'].$fleetRow['fleetId']] = $this->BuildFleetEventTable($fleetRow, 2);
		
			if ($fleetRow['fleet_owner'] != $this->userId)
				continue;
		
			if ($fleetRow['fleet_end_time'] > TIMESTAMP)
				$FleetData[$fleetRow['fleet_end_time'].$fleetRow['fleetId']] = $this->BuildFleetEventTable($fleetRow, 1);
		}
		
		ksort($FleetData);
		return $FleetData;
	}

	private function BuildFleetEventTable($fleetRow, $FleetState)
	{
		$Time	= 0;
		$Rest	= 0;

		if ($FleetState == 0 && !$this->IsPhalanx && $fleetRow['fleet_group'] != 0)
		{
			$acsResult		= $this->getFleets($fleetRow['fleet_group']);
			$EventString	= '';

			foreach($acsResult as $acsRow)
			{
				$Return			= $this->getEventData($acsRow, $FleetState);
					
				$Rest			= $Return[0];
				$EventString    .= $Return[1].'<br><br>';
				$Time			= $Return[2];
			}

			$EventString	= substr($EventString, 0, -8);
		}
		else
		{
			list($Rest, $EventString, $Time) = $this->getEventData($fleetRow, $FleetState);
		}
		
		return array(
			'text'			=> $EventString,
			'returntime'	=> $Time,
			'resttime'		=> $Rest
		);
	}
	
	public function getEventData($fleetRow, $Status)
	{
		global $LNG;
		$Owner			= $fleetRow['fleet_owner'] == $this->userId;
		$FleetStyle  = array (
			1 => 'attack',
			2 => 'federation',
			3 => 'transport',
			4 => 'deploy',
			5 => 'hold',
			6 => 'espionage',
			7 => 'colony',
			8 => 'harvest',
			9 => 'destroy',
			10 => 'missile',
			11 => 'transport',
			15 => 'transport',
		);
		
	    $GoodMissions	= array(3, 5);
		$MissionType    = $fleetRow['fleet_mission'];

		$FleetPrefix    = ($Owner == true) ? 'own' : '';
		$FleetType		= $FleetPrefix.$FleetStyle[$MissionType];
		$FleetName		= (!$Owner && ($MissionType == 1 || $MissionType == 2) && $Status == FLEET_OUTWARD && $fleetRow['fleet_target_owner'] != $this->userId) ? $LNG['cff_acs_fleet'] : $LNG['ov_fleet'];
		$FleetContent   = $this->CreateFleetPopupedFleetLink($fleetRow, $FleetName, $FleetPrefix.$FleetStyle[$MissionType]);
		$FleetCapacity  = $this->CreateFleetPopupedMissionLink($fleetRow, $LNG['type_mission'][$MissionType], $FleetPrefix.$FleetStyle[$MissionType]);
		$FleetStatus    = array(0 => 'flight', 1 => 'return' , 2 => 'holding');
		$StartType		= $LNG['type_planet'][$fleetRow['fleet_start_type']];
		$TargetType		= $LNG['type_planet'][$fleetRow['fleet_end_type']];
	
		if ($MissionType == 8) {
			if ($Status == FLEET_OUTWARD)
				$EventString = sprintf($LNG['cff_mission_own_recy_0'], $FleetContent, $StartType, $fleetRow['own_planetname'], GetStartAdressLink($fleetRow, $FleetType), GetTargetAdressLink($fleetRow, $FleetType), $FleetCapacity);
			else
				$EventString = sprintf($LNG['cff_mission_own_recy_1'], $FleetContent, GetTargetAdressLink($fleetRow, $FleetType), $StartType, $fleetRow['own_planetname'], GetStartAdressLink($fleetRow, $FleetType), $FleetCapacity);
		} elseif ($MissionType == 10) {
			if ($Owner)
				$EventString = sprintf($LNG['cff_mission_own_mip'], $fleetRow['fleet_amount'], $StartType, $fleetRow['own_planetname'], GetStartAdressLink($fleetRow, $FleetType), $TargetType, $fleetRow['target_planetname'], GetTargetAdressLink($fleetRow, $FleetType));
			else
				$EventString = sprintf($LNG['cff_mission_target_mip'], $fleetRow['fleet_amount'], $this->BuildHostileFleetPlayerLink($fleetRow, $fleetRow), $StartType, $fleetRow['own_planetname'], GetStartAdressLink($fleetRow, $FleetType), $TargetType, $fleetRow['target_planetname'], GetTargetAdressLink($fleetRow, $FleetType));
		} elseif ($MissionType == 11 || $MissionType == 15) {		
			if ($Status == FLEET_OUTWARD)
				$EventString = sprintf($LNG['cff_mission_own_expo_0'], $FleetContent, $StartType, $fleetRow['own_planetname'], GetStartAdressLink($fleetRow, $FleetType), GetTargetAdressLink($fleetRow, $FleetType), $FleetCapacity);
			elseif ($Status == FLEET_HOLD)
				$EventString = sprintf($LNG['cff_mission_own_expo_2'], $FleetContent, $StartType, $fleetRow['own_planetname'], GetStartAdressLink($fleetRow, $FleetType), GetTargetAdressLink($fleetRow, $FleetType), $FleetCapacity);	
			else
				$EventString = sprintf($LNG['cff_mission_own_expo_1'], $FleetContent, GetTargetAdressLink($fleetRow, $FleetType), $StartType, $fleetRow['own_planetname'], GetStartAdressLink($fleetRow, $FleetType), $FleetCapacity);	
		} else {
			if ($Owner == true) {
				if ($Status == FLEET_OUTWARD) {
					if (!$Owner && ($MissionType == 1 || $MissionType == 2))
						$Message  = $LNG['cff_mission_acs']	;
					else
						$Message  = $LNG['cff_mission_own_0'];
						
					$EventString  = sprintf($Message, $FleetContent, $StartType, $fleetRow['own_planetname'], GetStartAdressLink($fleetRow, $FleetType), $TargetType, $fleetRow['target_planetname'], GetTargetAdressLink($fleetRow, $FleetType), $FleetCapacity);
				} elseif($Status == FLEET_RETURN)
					$EventString  = sprintf($LNG['cff_mission_own_1'], $FleetContent, $TargetType, $fleetRow['target_planetname'], GetTargetAdressLink($fleetRow, $FleetType), $StartType, $fleetRow['own_planetname'], GetStartAdressLink($fleetRow, $FleetType), $FleetCapacity);		
				else
					$EventString  = sprintf($LNG['cff_mission_own_2'], $FleetContent, $StartType, $fleetRow['own_planetname'], GetStartAdressLink($fleetRow, $FleetType), $TargetType, $fleetRow['target_planetname'], GetTargetAdressLink($fleetRow, $FleetType), $FleetCapacity);	
			} else {
				if ($Status == FLEET_HOLD)
					$Message	= $LNG['cff_mission_target_stay'];
				elseif(in_array($MissionType, $GoodMissions))
					$Message	= $LNG['cff_mission_target_good'];
				else
					$Message	= $LNG['cff_mission_target_bad'];

				$EventString	= sprintf($Message, $FleetContent, $this->BuildHostileFleetPlayerLink($fleetRow, $fleetRow), $StartType, $fleetRow['own_planetname'], GetStartAdressLink($fleetRow, $FleetType), $TargetType, $fleetRow['target_planetname'], GetTargetAdressLink($fleetRow, $FleetType), $FleetCapacity);
			}		       
		}
		$EventString = '<span class="'.$FleetStatus[$Status].' '.$FleetType.'">'.$EventString.'</span>';

		if ($Status == FLEET_OUTWARD)
			$Time = $fleetRow['fleet_start_time'];
		elseif ($Status == FLEET_RETURN)
			$Time = $fleetRow['fleet_end_time'];
		elseif ($Status == FLEET_HOLD)
			$Time = $fleetRow['fleet_end_stay'];
		else
			$Time = TIMESTAMP;

		$Rest	= $Time - TIMESTAMP;
		return array($Rest, $EventString, $Time);
	}

	private function BuildHostileFleetPlayerLink($fleetRow, $fleetRow)
    {
		global $LNG;
		return $fleetRow['own_username'].' <a href="#" onclick="return Dialog.PM('.$fleetRow['fleet_owner'].')">'.$LNG['PM'].'</a>';
	}

	private function CreateFleetPopupedMissionLink($fleetRow, $label, $FleetType)
	{
		global $LNG;
		if (array_sum($fleetRow['elements'][Vars::CLASS_RESOURCE]))
		{
			$toolTipHTML   = '<table style=\'width:200px\'>';
			foreach($fleetRow['elements'][Vars::CLASS_RESOURCE] as $elementId => $amount)
			{
				$toolTipHTML  .= '<tr><td style=\'width:50%;color:white\'>'.$LNG['tech'][$elementId].'</td><td style=\'width:50%;color:white\'>'. pretty_number($amount).'</td></tr>';
			}

			$toolTipHTML  .= '</table>';
			
			$MissionPopup  = '<a data-tooltip-content="'.$toolTipHTML.'" class="tooltip '.$FleetType.'">'.$label.'</a>';
		}
		else
		{
			$MissionPopup  = $label;
		}

		return $MissionPopup;
	}

	private function CreateFleetPopupedFleetLink($fleetRow, $Text, $FleetType)
	{
		global $LNG, $USER;
		$SpyTech		= $USER[Vars::getElement(106)->name];
		$Owner			= $fleetRow['fleet_owner'] == $this->userId;
		$FleetPopup		= '<a href="#" data-tooltip-content="<table style=\'width:200px\'>';
		$textForBlind	= '';

		$fleetData		= $fleetRow['fleet_mission'] == 10 ? $fleetRow['elements'][Vars::CLASS_MISSILE] : $fleetRow['elements'][Vars::CLASS_FLEET];

		if ($this->IsPhalanx || $SpyTech >= 4 || $Owner)
		{
			
			if($SpyTech < 8 && !$Owner)
			{
				$FleetPopup		.= '<tr><td style=\'width:100%;color:white\'>'.$LNG['cff_aproaching'].$fleetRow['fleet_amount'].$LNG['cff_ships'].':</td></tr>';
				$textForBlind	= $LNG['cff_aproaching'].$fleetRow['fleet_amount'].$LNG['cff_ships'].': ';
			}
			$shipsData	= array();
			foreach($fleetData as $elementId => $amount)
			{
				if($Owner)
				{
					$FleetPopup 	.= '<tr><td style=\'width:50%;color:white\'>'.$LNG['tech'][$elementId].':</td><td style=\'width:50%;color:white\'>'.pretty_number($amount).'</td></tr>';
						$shipsData[]	= floattostring($amount).' '.$LNG['tech'][$elementId];
				}
				else
				{
					if($SpyTech >= 8)
					{
						$FleetPopup 	.= '<tr><td style=\'width:50%;color:white\'>'.$LNG['tech'][$elementId].':</td><td style=\'width:50%;color:white\'>'.pretty_number($amount).'</td></tr>';
						$shipsData[]	= floattostring($amount).' '.$LNG['tech'][$elementId];
					}
					else
					{
						$FleetPopup		.= '<tr><td style=\'width:100%;color:white\'>'.$LNG['tech'][$elementId].'</td></tr>';
						$shipsData[]	= $LNG['tech'][$elementId];
					}
				}
			}
			
			$textForBlind	.= implode('; ', $shipsData);
		}
		else
		{
			$FleetPopup 	.= '<tr><td style=\'width:100%;color:white\'>'.$LNG['cff_no_fleet_data'].'</span></td></tr>';
			$textForBlind	= $LNG['cff_no_fleet_data'];
		}
		
		$FleetPopup  .= '</table>" class="tooltip '. $FleetType .'">'. $Text .'</a><span class="textForBlind"> ('.$textForBlind.')</span>';

		return $FleetPopup;
	}	
}
?>