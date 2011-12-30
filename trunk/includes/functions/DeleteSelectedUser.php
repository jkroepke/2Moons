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

require_once(ROOT_PATH.'includes/classes/class.FleetFunctions.php');
 
function DeleteSelectedUser($UserID)
{
	global $db ,$CONF;
	
	if(ROOT_USER == $UserId)
		return false;
		
	$TheUser = $db->uniquequery("SELECT universe, ally_id FROM ".USERS." WHERE `id` = '".$UserID."';");
	$SQL 	 = "";
	
	if ($TheUser['ally_id'] != 0 )
	{
		$TheAlly =  $db->uniquequery("SELECT ally_members FROM ".ALLIANCE." WHERE `id` = '".$TheUser['ally_id']."';");
		$TheAlly['ally_members'] -= 1;

		if ($TheAlly['ally_members'] > 0)
		{
			$SQL .= "UPDATE ".ALLIANCE." SET `ally_members` = '".$TheAlly['ally_members']."' WHERE `id` = '".$TheUser['ally_id']."';";
		}
		else
		{
			$SQL .= "DELETE FROM ".ALLIANCE." WHERE `id` = '" . $TheUser['ally_id'] . "';";
			$SQL .= "DELETE FROM ".STATPOINTS." WHERE `stat_type` = '2' AND `id_owner` = '".$TheUser['ally_id']."';";
		}
	}
	
	$SQL .= "DELETE FROM ".BUDDY." WHERE `owner` = ".$UserID." OR `sender` = ".$UserID.";";
	$SQL .= "DELETE FROM ".FLEETS." WHERE `fleet_owner` = ".$UserID.";";
	$SQL .= "DELETE FROM ".MESSAGES." WHERE `message_owner` = ".$UserID.";";
	$SQL .= "DELETE FROM ".NOTES." WHERE `owner` = ".$UserID.";";
	$SQL .= "DELETE FROM ".PLANETS." WHERE `id_owner` = ".$UserID.";";
	$SQL .= "DELETE FROM ".USERS." WHERE `id` = ".$UserID.";";
	$SQL .= "DELETE FROM ".STATPOINTS." WHERE `stat_type` = '1' AND `id_owner` = ".$UserID.";";
	$db->multi_query($SQL);
	
	$SQL	= $db->query("SELECT fleet_id FROM ".FLEETS." WHERE `fleet_target_owner` = '".$UserID."';");
	while($FleetID = $db->fetch_array($SQL)) {
		FleetFunctions::SendFleetBack($UserID, $FleetID);
	}
	update_config(array('users_amount' => $CONF['users_amount'] - 1), $TheUser['universe']);
}

function DeleteSelectedPlanet($planetID)
{
	global $db;

	$QueryPlanet = $db->uniquequery("SELECT universe, galaxy, system, planet, planet_type FROM ".PLANETS." WHERE id = ".$planetID.";");

	$SQL	= $db->query("SELECT fleet_id FROM ".FLEETS." WHERE `fleet_target_id` = '".$planetID."';");
	
	while($FleetID = $db->fetch_array($SQL)) {
		FleetFunctions::SendFleetBack($planetID, $FleetID);
	}
	
	if ($QueryPlanet['planet_type'] == '3')
		$db->multi_query("DELETE FROM ".PLANETS." WHERE id = '".$planetID."';UPDATE ".PLANETS." SET id_luna = '0' WHERE id_luna = ".$planetID.";");
	else
		$db->query("DELETE FROM ".PLANETS." WHERE universe = ".$QueryPlanet['universe']." AND galaxy = ".$QueryPlanet['galaxy']." AND system = ".$QueryPlanet['system']." AND planet = ".$QueryPlanet['planet'].";");
}

?>