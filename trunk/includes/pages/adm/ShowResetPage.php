<?php

##############################################################################
# *                                                                          #
# * 2MOONS                                                                   #
# *                                                                          #
# * @copyright Copyright (C) 2010 By ShadoX from titanspace.de               #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
# *                                                                          #
# *	                                                                         #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.                                     #
# *	                                                                         #
# *  This program is distributed in the hope that it will be useful,         #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of          #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           #
# *  GNU General Public License for more details.                            #
# *                                                                          #
##############################################################################

if ($USER['id'] != 1 || $_GET['sid'] != session_id()) exit;

function ShowResetPage()
{
	global $db, $LNG, $reslist, $resource;
	$template	= new template();
	if ($_POST)
	{		
		foreach($reslist['build'] as $ID)
		{
			$dbcol['build'][$ID]	= "`".$resource[$ID]."` = '0'";
		}
		
		foreach($reslist['tech'] as $ID)
		{
			$dbcol['tech'][$ID]		= "`".$resource[$ID]."` = '0'";
		}
		
		foreach($reslist['fleet'] as $ID)
		{
			$dbcol['fleet'][$ID]	= "`".$resource[$ID]."` = '0'";
		}
		
		foreach($reslist['defense'] as $ID)
		{
			$dbcol['defense'][$ID]	= "`".$resource[$ID]."` = '0'";
		}
		foreach($reslist['officier'] as $ID)
		{
			$dbcol['officier'][$ID]	= "`".$resource[$ID]."` = '0'";
		}
		
		// HANGARES Y DEFENSAS
		if ($_POST['defenses']	==	'on')
			$db->query("UPDATE ".PLANETS." SET ".implode(", ",$dbcol['defense'])." AND `universe` = '".$_SESSION['adminuni']."';");
	
		if ($_POST['ships']	==	'on')
			$db->query("UPDATE ".PLANETS." SET ".implode(", ",$dbcol['fleet'])." AND `universe` = '".$_SESSION['adminuni']."';");
	
		if ($_POST['h_d']	==	'on')
			$db->query("UPDATE ".PLANETS." SET `b_hangar` = '0', `b_hangar_plus` = '0', `b_hangar_id` = '' AND `universe` = '".$_SESSION['adminuni']."';");
	

		// EDIFICIOS
		if ($_POST['edif_p']	==	'on')
			$db->query("UPDATE ".PLANETS." SET ".implode(", ",$dbcol['build'])." WHERE `planet_type` = '1' AND `universe` = '".$_SESSION['adminuni']."';");
	
		if ($_POST['edif_l']	==	'on')
			$db->query("UPDATE ".PLANETS." SET ".implode(", ",$dbcol['build'])." WHERE `planet_type` = '3' AND `universe` = '".$_SESSION['adminuni']."';");
	
		if ($_POST['edif']	==	'on')
			$db->query("UPDATE ".PLANETS." SET `b_building` = '0', `b_building_id` = '' WHERE `universe` = '".$_SESSION['adminuni']."';");
	

		// INVESTIGACIONES Y OFICIALES
		if ($_POST['inves']	==	'on')
			$db->query("UPDATE ".USERS." SET ".implode(", ",$dbcol['tech'])." WHERE `universe` = '".$_SESSION['adminuni']."';");
	
		if ($_POST['ofis']	==	'on')
			$db->query("UPDATE ".USERS." SET ".implode(", ",$dbcol['officier'])." WHERE`universe` = '".$_SESSION['adminuni']."';");
	
		if ($_POST['inves_c']	==	'on')
			$db->query("UPDATE ".USERS." SET `b_tech_planet` = '0', `b_tech` = '0', `b_tech_id` = '0' WHERE `universe` = '".$_SESSION['adminuni']."';");
	
	
		// RECURSOS
		if ($_POST['dark']	==	'on')
			$db->query("UPDATE ".USERS." SET `darkmatter` = '0';");
	
		if ($_POST['resources']	==	'on')
			$db->query("UPDATE ".PLANETS." SET `metal` = '0', `crystal` = '0', `deuterium` = '0' WHERE `universe` = '".$_SESSION['adminuni']."';");
	
		// GENERAL
		if ($_POST['notes']	==	'on')
			$db->query("TRUNCATE TABLE ".NOTES.";");

		if ($_POST['rw']	==	'on'){
			$TKBRW			= $db->query("SELECT `rid` FROM ".TOPKB." WHERE `universe` = '".$_SESSION['adminuni']."';");
		
			if(isset($TKBRW))
			{
				while($RID = $db->fetch_array($TKBRW)) {
					@unlink(ROOT_PATH.'raports/topkb_'.$RID['rid'].'.php');
				}
				$db->query("DELETE FROM ".TOPKB." WHERE `universe` = '".$_SESSION['adminuni']."';");		
			}
		}

		if ($_POST['friends']	==	'on')
			$db->query("TRUNCATE TABLE ".BUDDY.";");

		if ($_POST['alliances']	==	'on'){
			$db->query("DELETE FROM ".ALLIANCE." WHERE `ally_universe` = '".$_SESSION['adminuni']."';");
			$db->query("UPDATE ".USERS." SET `ally_id` = '0', `ally_name` = '', `ally_request` = '0', `ally_request_text` = 'NULL', `ally_register_time` = '0', `ally_rank_id` = '0' WHERE `universe` = '".$_SESSION['adminuni']."';");}

		if ($_POST['fleets']	==	'on')
			$db->query("DELETE FROM ".FLEETS." WHERE `fleet_universe` = '".$_SESSION['adminuni']."';");

		if ($_POST['banneds']	==	'on'){
			$db->query("DELETE FROM ".BANNED." WHERE `universe` = '".$_SESSION['adminuni']."';");
			$db->query("UPDATE ".USERS." SET `bana` = '0', `banaday` = '0' WHERE `universe` = '".$_SESSION['adminuni']."';");}

		if ($_POST['messages']	==	'on'){
			$db->query("DELETE FROM ".MESSAGES." WHERE `message_universe` = '".$_SESSION['adminuni']."';");
			$db->query("UPDATE ".USERS." SET `new_message` = '0' WHERE `universe` = '".$_SESSION['adminuni']."';");}

		if ($_POST['statpoints']	==	'on'){
			$db->query("DELETE FROM ".STATPOINTS." WHERE `universe` = '".$_SESSION['adminuni']."';");}

		if ($_POST['moons']	==	'on'){
			$db->query("DELETE FROM ".PLANETS." WHERE `planet_type` = '3' AND `universe` = '".$_SESSION['adminuni']."';");
			$db->query("UPDATE ".PLANETS." SET `id_luna` = '0' WHERE `universe` = '".$_SESSION['adminuni']."';");}

		$template->message($LNG['re_reset_excess'], '?page=reset&sid='.session_id(), 3);
		exit;
	}

	$template->assign_vars(array(	
		'button_submit'				=> $LNG['button_submit'],
		're_reset_all'				=> $LNG['re_reset_all'],
		're_defenses_and_ships'		=> $LNG['re_defenses_and_ships'],
		're_reset_buldings'			=> $LNG['re_reset_buldings'],
		're_buildings_lu'			=> $LNG['re_buildings_lu'],
		're_buildings_pl'			=> $LNG['re_buildings_pl'],
		're_buldings'				=> $LNG['re_buldings'],
		're_reset_hangar'			=> $LNG['re_reset_hangar'],
		're_ships'					=> $LNG['re_ships'],
		're_defenses'				=> $LNG['re_defenses'],
		're_resources_met_cry'		=> $LNG['re_resources_met_cry'],
		're_resources_dark'			=> $LNG['re_resources_dark'],
		're_resources'				=> $LNG['re_resources'],
		're_reset_invest'			=> $LNG['re_reset_invest'],
		're_investigations'			=> $LNG['re_investigations'],
		're_ofici'					=> $LNG['re_ofici'],
		're_inve_ofis'				=> $LNG['re_inve_ofis'],
		're_reset_statpoints'		=> $LNG['re_reset_statpoints'],
		're_reset_messages'			=> $LNG['re_reset_messages'],
		're_reset_banned'			=> $LNG['re_reset_banned'],
		're_reset_errors'			=> $LNG['re_reset_errors'],
		're_reset_fleets'			=> $LNG['re_reset_fleets'],
		're_reset_allys'			=> $LNG['re_reset_allys'],
		're_reset_buddies'			=> $LNG['re_reset_buddies'],
		're_reset_rw'				=> $LNG['re_reset_rw'],
		're_reset_notes'			=> $LNG['re_reset_notes'],
		're_reset_moons'			=> $LNG['re_reset_moons'],
		're_general'				=> $LNG['re_general'],
	));
	
	$template->show('adm/ResetPage.tpl');
}

?>