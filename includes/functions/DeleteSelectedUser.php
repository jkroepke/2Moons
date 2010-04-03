<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
# *																			 #
# *																			 #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.									 #
# *																			 #
# *  This program is distributed in the hope that it will be useful,		 #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of			 #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 #
# *  GNU General Public License for more details.							 #
# *																			 #
##############################################################################

if(!defined('INSIDE')){ die(header("location:../../"));}

	function DeleteSelectedUser($UserID)
	{
		global $db ,$game_config;
		
		$TheUser = $db->fetch_array($db->query("SELECT ally_id FROM ".USERS." WHERE `id` = '" . $UserID . "';"));
		$sql 	 = "";
		
		if ($TheUser['ally_id'] != 0 )
		{
			$TheAlly =  $db->fetch_array($db->query("SELECT ally_members FROM ".ALLIANCE." WHERE `id` = '" . $TheUser['ally_id'] . "';"));
			$TheAlly['ally_members'] -= 1;

			if ($TheAlly['ally_members'] > 0)
			{
				$sql .= "UPDATE ".ALLIANCE." SET `ally_members` = '" . $TheAlly['ally_members'] . "' WHERE `id` = '" . $TheUser['ally_id'] . "';";
			}
			else
			{
				$sql .= "DELETE FROM ".ALLIANCE." WHERE `id` = '" . $TheUser['ally_id'] . "';";
				$sql .= "DELETE FROM ".STATPOINTS." WHERE `stat_type` = '2' AND `id_owner` = '" . $TheUser['ally_id'] . "';";
			}
		}

		$sql .= "DELETE FROM ".STATPOINTS." WHERE `stat_type` = '1' AND `id_owner` = '" . $UserID . "';";
		$sql .= "DELETE FROM ".PLANETS." WHERE `id_owner` = '" . $UserID . "';";
		$sql .= "DELETE FROM ".MESSAGES." WHERE `message_owner` = '" . $UserID . "' OR `message_sender` = '" . $UserID . "';";
		$sql .= "DELETE FROM ".NOTES." WHERE `owner` = '" . $UserID . "';";
		$sql .= "DELETE FROM ".FLEETS." WHERE `fleet_owner` = '" . $UserID . "';";
		$sql .= "DELETE FROM ".BUDDY." WHERE `owner` = '" . $UserID . "' OR `sender` = '" . $UserID . "';";
		$sql .= "DELETE FROM ".USERS." WHERE `id` = '" . $UserID . "';";
		$db->multi_query($sql);
		update_config("users_amount", $game_config['users_amount'] - 1);
	}
   
	function DeleteSelectedPlanet ($ID)
	{
		global $lang, $db;

		$QueryPlanet = $db->fetch_array($db->query("SELECT galaxy,planet,system,planet_type FROM ".PLANETS." WHERE id = '".$ID."';"));

		if ($QueryPlanet['planet_type'] == '3')
		{
			$db->multi_query("DELETE FROM ".PLANETS." WHERE id = '".$ID."';UPDATE ".PLANETS." SET id_luna = 0 WHERE id_luna = '".$ID."';");
		}
		else
		{
			$db->query("DELETE FROM ".PLANETS." WHERE galaxy = '".$QueryPlanet['galaxy']."' AND system = '".$QueryPlanet['system']."' AND planet = '".$QueryPlanet['planet']."';");
		}
	}
?>