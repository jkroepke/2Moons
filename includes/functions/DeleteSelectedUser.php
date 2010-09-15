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

function DeleteSelectedUser($UserID)
{
	global $db ,$CONF;
	
	$TheUser = $db->uniquequery("SELECT ally_id FROM ".USERS." WHERE `id` = '".$UserID."';");
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

	$SQL .= "DELETE FROM ".BUDDY." WHERE `owner` = '".$UserID."' OR `sender` = '".$UserID."';";
	$SQL .= "DELETE FROM ".FLEETS." WHERE `fleet_owner` = '".$UserID."';";
	$SQL .= "DELETE FROM ".MESSAGES." WHERE `message_owner` = '".$UserID."' OR `message_sender` = '".$UserID."';";
	$SQL .= "DELETE FROM ".NOTES." WHERE `owner` = '".$UserID."';";
	$SQL .= "DELETE FROM ".PLANETS." WHERE `id_owner` = '".$UserID."';";
	$SQL .= "DELETE FROM ".USERS." WHERE `id` = '".$UserID."';";
	$SQL .= "DELETE FROM ".STATPOINTS." WHERE `stat_type` = '1' AND `id_owner` = '".$UserID."';";
	$db->multi_query($SQL);
	update_config("users_amount", $CONF['users_amount'] - 1);
}
   
function DeleteSelectedPlanet ($ID)
{
	global $db;

	$QueryPlanet = $db->uniquequery("SELECT galaxy,planet,system,planet_type FROM ".PLANETS." WHERE id = '".$ID."';");

	if ($QueryPlanet['planet_type'] == '3')
		$db->multi_query("DELETE FROM ".PLANETS." WHERE id = '".$ID."';UPDATE ".PLANETS." SET id_luna = '0' WHERE id_luna = '".$ID."';");
	else
		$db->query("DELETE FROM ".PLANETS." WHERE galaxy = '".$QueryPlanet['galaxy']."' AND system = '".$QueryPlanet['system']."' AND planet = '".$QueryPlanet['planet']."';");
}

?>