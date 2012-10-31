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

require_once(ROOT_PATH.'includes/classes/class.FleetFunctions.php');
 
function DeleteSelectedUser($userID)
{
	global $db ,$CONF;
	
	if(ROOT_USER == $userID) {
		return false;
	}
	
	$userData = $GLOBALS['DATABASE']->getFirstRow("SELECT universe, ally_id FROM ".USERS." WHERE id = '".$userID."';");
	$SQL 	 = "";
	
	if ($userData['ally_id'] != 0)
	{
		$memberCount =  $GLOBALS['DATABASE']->getFirstCell("SELECT ally_members FROM ".ALLIANCE." WHERE id = ".$userData['ally_id'].";");

		if ($memberCount >= 2)
		{
			$SQL .= "UPDATE ".ALLIANCE." SET ally_members = ally_members - 1 WHERE id = ".$userData['ally_id'].";";
		}
		else
		{
			$SQL .= "DELETE FROM ".ALLIANCE." WHERE id = ".$userData['ally_id'].";";
			$SQL .= "DELETE FROM ".STATPOINTS." WHERE stat_type = '2' AND id_owner = ".$userID.";";
			$SQL .= "UPDATE ".STATPOINTS." SET id_ally = 0 WHERE id_ally = ".$userData['ally_id'].";";
		}
	}
	
	$SQL .= "DELETE FROM ".ALLIANCE_REQUEST." WHERE userID = ".$userID.";";
	$SQL .= "DELETE FROM ".BUDDY." WHERE owner = ".$userID." OR sender = ".$userID.";";
	$SQL .= "DELETE FROM ".FLEETS." WHERE fleet_owner = ".$userID.";";
	$SQL .= "DELETE FROM ".MESSAGES." WHERE message_owner = ".$userID.";";
	$SQL .= "DELETE FROM ".NOTES." WHERE owner = ".$userID.";";
	$SQL .= "DELETE FROM ".PLANETS." WHERE id_owner = ".$userID.";";
	$SQL .= "DELETE FROM ".USERS." WHERE id = ".$userID.";";
	$SQL .= "DELETE FROM ".STATPOINTS." WHERE stat_type = '1' AND id_owner = ".$userID.";";
	$GLOBALS['DATABASE']->multi_query($SQL);
	
	$fleetData	= $GLOBALS['DATABASE']->query("SELECT fleet_id FROM ".FLEETS." WHERE fleet_target_owner = ".$userID.";");
	
	while($FleetID = $GLOBALS['DATABASE']->fetch_array($fleetData)) {
		FleetFunctions::SendFleetBack($userID, $FleetID['fleet_id']);
	}
	
	$GLOBALS['DATABASE']->free_result($fleetData);
	
	update_config(array('users_amount' => $CONF['users_amount'] - 1), $userData['universe']);
}

function DeleteSelectedPlanet($planetID)
{
	$planetData = $GLOBALS['DATABASE']->getFirstRow("SELECT planet_type FROM ".PLANETS." WHERE id = ".$planetID." AND id NOT IN (SELECT id_planet FROM ".USERS.");");
	
	if(empty($planetData)) {
		return false;
	}
	
	$fleetData	= $GLOBALS['DATABASE']->query("SELECT fleet_id FROM ".FLEETS." WHERE fleet_end_id = ".$planetID.";");
	
	while($FleetID = $GLOBALS['DATABASE']->fetch_array($fleetData)) {
		FleetFunctions::SendFleetBack($$planetID, $FleetID['fleet_id']);
	}
	
	$GLOBALS['DATABASE']->free_result($fleetData);
	
	if ($planetData['planet_type'] == 3) {
		$GLOBALS['DATABASE']->multi_query("DELETE FROM ".PLANETS." WHERE id = ".$planetID.";UPDATE ".PLANETS." SET id_luna = 0 WHERE id_luna = ".$planetID.";");
	} else {
		$GLOBALS['DATABASE']->query("DELETE FROM ".PLANETS." WHERE id = ".$planetID." OR id_luna = ".$planetID.";");
	}
}

?>