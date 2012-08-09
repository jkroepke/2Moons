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


class ShowFleetTablePage extends AbstractPage
{
	public static $requireModule = MODULE_FLEET_TABLE;

	function __construct() 
	{
		parent::__construct();
	}
	
	public function createACS($fleetID, $fleetData) {
		global $USER;
		
		$rand 			= mt_rand(100000, 999999999);
		$acsName	 	= 'AG'.$rand;
		$acsCreator		= $USER['id'];

		$GLOBALS['DATABASE']->query("INSERT INTO ".AKS." SET
					name = '".$GLOBALS['DATABASE']->sql_escape($acsName)."',
					ankunft = ".$fleetData['fleet_start_time'].",
					target = ".$fleetData['fleet_end_id'].";");
		$acsID	= $GLOBALS['DATABASE']->GetInsertID();
		
		$GLOBALS['DATABASE']->multi_query("INSERT INTO ".USERS_ACS." SET
					acsID = ".$acsID.",
					userID = ".$USER['id'].";
					UPDATE ".FLEETS." SET
					fleet_group = ".$acsID."
					WHERE fleet_id = ".$fleetID.";");
					
		return array(
			'name' 			=> $acsName,
			'id' 			=> $acsID,
		);
	}
	
	public function loadACS($fleetID, $fleetData) {
		global $USER;
		
		$acsResult = $GLOBALS['DATABASE']->query("SELECT id, name 
		FROM ".USERS_ACS." 
		INNER JOIN ".AKS." ON acsID = id 
		WHERE userID = ".$USER['id']." AND acsID = ".$fleetData['fleet_group'].";");
		
		return $GLOBALS['DATABASE']->fetch_array($acsResult);
	}
	
	public function showACSPage($fleetID)
	{
		global $USER, $PLANET, $LNG, $UNI;
		
		$fleetResult	= $GLOBALS['DATABASE']->query("SELECT fleet_start_time, fleet_end_id, fleet_group, fleet_mess 
									  FROM ".FLEETS."
									  WHERE fleet_id = ".$fleetID.";");

		if ($GLOBALS['DATABASE']->numRows($fleetResult) != 1)
			return array();
					
		$fleetData 		= $GLOBALS['DATABASE']->fetch_array($fleetResult);
		$GLOBALS['DATABASE']->free_result($fleetResult);
		
		if ($fleetData['fleet_mess'] == 1 || $fleetData['fleet_start_time'] <= TIMESTAMP)
			return array();
				
		if ($fleetData['fleet_group'] == 0)
			$acsData	= $this->createACS($fleetID, $fleetData);
		else
			$acsData	= $this->loadACS($fleetID, $fleetData);
	
		if (empty($acsData))
			return array();
			
		$acsName	= HTTP::_GP('acsName', '', UTF8_SUPPORT);
		if(!empty($acsName)) {
			if(!CheckName($acsName)) {
				exit($LNG['fl_acs_newname_alphanum']);
			}
			
			$GLOBALS['DATABASE']->query("UPDATE ".AKS." SET name = '".$GLOBALS['DATABASE']->sql_escape($acsName)."' WHERE id = ".$acsData['id'].";");
			exit;
		}
		
		$invitedUsers	= array();
		$userResult 	= $GLOBALS['DATABASE']->query("SELECT id, username
									  FROM ".USERS_ACS."
									  INNER JOIN ".USERS." ON userID = id 
									  WHERE acsID = ".$acsData['id'].";");
		
		while($userRow = $GLOBALS['DATABASE']->fetch_array($userResult))
		{
			$invitedUsers[$userRow['id']]	= $userRow['username'];
		}

		$GLOBALS['DATABASE']->free_result($userResult);
		
		$newUser		= HTTP::_GP('username', '', UTF8_SUPPORT);
		$statusMessage	= "";
		if(!empty($newUser))
		{
			$newUserID				= $GLOBALS['DATABASE']->countquery("SELECT id FROM ".USERS." WHERE universe = ".$UNI." AND username = '".$GLOBALS['DATABASE']->sql_escape($newUser)."';");
				
			if(empty($newUserID)) {
				$statusMessage			= $LNG['fl_player']." ".$newUser." ".$LNG['fl_dont_exist'];
			} elseif(isset($invitedUsers[$newUserID])) {
				$statusMessage			= $LNG['fl_player']." ".$newUser." ".$LNG['fl_already_invited'];
			} else {
				$statusMessage			= $LNG['fl_player']." ".$newUser." ".$LNG['fl_add_to_attack'];
				
				$GLOBALS['DATABASE']->query("INSERT INTO ".USERS_ACS." SET acsID = ".$acsData['id'].", userID = ".$newUserID.";");
				
				$invitedUsers[$newUserID]	= $newUser;
				
				$inviteTitle			= $LNG['fl_acs_invitation_title'];
				$inviteMessage 			= $LNG['fl_player'] . $USER['username'] . $LNG['fl_acs_invitation_message'];
				SendSimpleMessage($newUserID, $USER['id'], TIMESTAMP, 1, $USER['username'], $inviteTitle, $inviteMessage);
			}
		}
		
		return array(
			'invitedUsers'	=> $invitedUsers,
			'acsName'		=> $acsData['name'],
			'fleetID'		=> $fleetID,
			'statusMessage'	=> $statusMessage,
		);
	}
	
	public function show()
	{
		global $USER, $PLANET, $reslist, $resource, $LNG;
		
		$parse				= $LNG;
		$FleetID			= HTTP::_GP('fleetID', 0);
		$GetAction			= HTTP::_GP('action', "");
	
		$this->tplObj->loadscript('flotten.js');
		
		if(!empty($FleetID) && !IsVacationMode($USER))
		{
			switch($GetAction){
				case "sendfleetback":
					FleetFunctions::SendFleetBack($USER, $FleetID);
				break;
				case "acs":
					$data	= $this->showACSPage($FleetID);
					$this->tplObj->assign_vars($data);
				break;
			}
		}
		
		$techExpedition      = $USER[$resource[124]];

		if ($techExpedition >= 1)
		{
			$activeExpedition   = FleetFunctions::GetCurrentFleets($USER['id'], 15);
			$maxExpedition 		= floor(sqrt($techExpedition));
		}
		else
		{
			$activeExpedition 	= 0;
			$maxExpedition 		= 0;
		}

		$maxFleetSlots	= FleetFunctions::GetMaxFleetSlots($USER);

		$targetGalaxy	= HTTP::_GP('galaxy', $PLANET['galaxy']);
		$targetSystem	= HTTP::_GP('system', $PLANET['system']);
		$targetPlanet	= HTTP::_GP('planet', $PLANET['planet']);
		$targetType	= HTTP::_GP('planettype', $PLANET['planet_type']);
		$targetMission	= HTTP::_GP('target_mission', 0);
		
		$fleetResult 		= $GLOBALS['DATABASE']->query("SELECT * FROM ".FLEETS." WHERE fleet_owner = ".$USER['id']." AND fleet_mission <> 10 ORDER BY fleet_end_time ASC;");
		$activeFleetSlots	= $GLOBALS['DATABASE']->numRows($fleetResult);

		$FlyingFleetList	= array();
		
		while ($fleetsRow = $GLOBALS['DATABASE']->fetch_array($fleetResult))
		{
			$fleet = explode(";", $fleetsRow['fleet_array']);

            $FleetList  = array();

			foreach ($fleet as $shipDetail)
			{
				if (empty($shipDetail))
					continue;

				$ship = explode(",", $shipDetail);
				
				$FleetList[$fleetsRow['fleet_id']][$ship[0]] = $ship[1];
			}
			
			$FlyingFleetList[]	= array(
				'id'			=> $fleetsRow['fleet_id'],
				'mission'		=> $fleetsRow['fleet_mission'],
				'state'			=> $fleetsRow['fleet_mess'],
				'startGalaxy'	=> $fleetsRow['fleet_start_galaxy'],
				'startSystem'	=> $fleetsRow['fleet_start_system'],
				'startPlanet'	=> $fleetsRow['fleet_start_planet'],
				'startTime'		=> _date($LNG['php_tdformat'], $fleetsRow['fleet_start_time'], $USER['timezone']),
				'endGalaxy'		=> $fleetsRow['fleet_end_galaxy'],
				'endSystem'		=> $fleetsRow['fleet_end_system'],
				'endPlanet'		=> $fleetsRow['fleet_end_planet'],
				'endTime'		=> _date($LNG['php_tdformat'], $fleetsRow['fleet_end_time'], $USER['timezone']),
				'amount'		=> pretty_number($fleetsRow['fleet_amount']),
				'backin'		=> pretty_time(floor(($fleetsRow['fleet_mission'] == 4 ? $fleetsRow['fleet_start_time'] : $fleetsRow['fleet_end_time']) - TIMESTAMP)),
				'FleetList'		=> $FleetList[$fleetsRow['fleet_id']],
			);
		}

		$GLOBALS['DATABASE']->free_result($fleetResult);
		
		$FleetsOnPlanet	= array();
		
		foreach($reslist['fleet'] as $FleetID)
		{
			if ($PLANET[$resource[$FleetID]] == 0)
				continue;
				
			$FleetsOnPlanet[]	= array(
				'id'	=> $FleetID,
				'speed'	=> FleetFunctions::GetFleetMaxSpeed($FleetID, $USER),
				'count'	=> $PLANET[$resource[$FleetID]],
			);
		}
		
		$this->tplObj->assign_vars(array(
			'FleetsOnPlanet'		=> $FleetsOnPlanet,
			'FlyingFleetList'		=> $FlyingFleetList,
			'activeExpedition'		=> $activeExpedition,
			'maxExpedition'			=> $maxExpedition,
			'activeFleetSlots'		=> $activeFleetSlots,
			'maxFleetSlots'			=> $maxFleetSlots,
			'targetGalaxy'			=> $targetGalaxy,
			'targetSystem'			=> $targetSystem,
			'targetPlanet'			=> $targetPlanet,
			'targetType'			=> $targetType,
			'targetMission'			=> $targetMission,
			'isVacation'			=> IsVacationMode($USER),
			'bonusAttack'			=> $USER[$resource[109]] * 10 + (1 + $USER['factor']['Attack']) * 100,
			'bonusDefensive'		=> $USER[$resource[110]] * 10 + (1 + $USER['factor']['Defensive']) * 100,
			'bonusShield'			=> $USER[$resource[111]] * 10 + (1 + $USER['factor']['Shield']) * 100,
			'bonusCombustion'		=> $USER[$resource[115]] * 10 + (1 + $USER['factor']['FlyTime']) * 100 - 100,
			'bonusImpulse'			=> $USER[$resource[117]] * 20 + (1 + $USER['factor']['FlyTime']) * 100 - 100,
			'bonusHyperspace'		=> $USER[$resource[118]] * 30 + (1 + $USER['factor']['FlyTime']) * 100 - 100,
		));
		
		$this->display('page.fleetTable.default.tpl');
	}
}
?>