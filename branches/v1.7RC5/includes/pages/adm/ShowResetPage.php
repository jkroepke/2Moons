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

if ($USER['id'] != ROOT_USER || $_GET['sid'] != session_id()) exit;

function ShowResetPage()
{
	global $LNG, $reslist, $resource;
	$template	= new template();
	$CONF	= Config::getAll(NULL, ROOT_UNI);
	
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
		
		foreach($reslist['resstype'][1] as $ID)
		{
			if(isset($CONF[$resource[$ID].'_start']))
			{
				$dbcol['resource_planet_start'][$ID]	= "`".$resource[$ID]."` = ".$CONF[$resource[$ID].'_start'];
			}
		}
		
		foreach($reslist['resstype'][3] as $ID)
		{
			if(isset($CONF[$resource[$ID].'_start']))
			{
				$dbcol['resource_user_start'][$ID]	= "`".$resource[$ID]."` = ".$CONF[$resource[$ID].'_start'];
			}
		}
		
		// Players and Planets
		
		if ($_POST['players'] == 'on'){
			$ID	= $GLOBALS['DATABASE']->getFirstCell("SELECT `id_owner` FROM ".PLANETS." WHERE `universe` = ".$_SESSION['adminuni']." AND `galaxy` = '1' AND `system` = '1' AND `planet` = '1';");
			$GLOBALS['DATABASE']->multi_query("DELETE FROM ".USERS." WHERE `universe` = ".$_SESSION['adminuni']." AND `id` != '".$ID."';DELETE FROM ".PLANETS." WHERE `universe` = ".$_SESSION['adminuni']." AND `id_owner` != '".$ID."';");
		}
		
		if ($_POST['planets'] == 'on')
			$GLOBALS['DATABASE']->multi_query("DELETE FROM ".PLANETS." WHERE `universe` = ".$_SESSION['adminuni']." AND `id` NOT IN (SELECT id_planet FROM ".USERS."  WHERE `universe` = ".$_SESSION['adminuni'].");UPDATE ".PLANETS." SET `id_luna` = '0' WHERE `universe` = ".$_SESSION['adminuni'].";");
			
		if ($_POST['moons']	== 'on'){
			$GLOBALS['DATABASE']->multi_query("DELETE FROM ".PLANETS." WHERE `planet_type` = '3' AND `universe` = ".$_SESSION['adminuni'].";UPDATE ".PLANETS." SET `id_luna` = '0' WHERE `universe` = ".$_SESSION['adminuni'].";");}

		// HANGARES Y DEFENSAS
		if ($_POST['defenses']	==	'on')
			$GLOBALS['DATABASE']->query("UPDATE ".PLANETS." SET ".implode(", ",$dbcol['defense'])." AND `universe` = ".$_SESSION['adminuni'].";");
	
		if ($_POST['ships']	==	'on')
			$GLOBALS['DATABASE']->query("UPDATE ".PLANETS." SET ".implode(", ",$dbcol['fleet'])." AND `universe` = ".$_SESSION['adminuni'].";");
	
		if ($_POST['h_d']	==	'on')
			$GLOBALS['DATABASE']->query("UPDATE ".PLANETS." SET `b_hangar` = '0', `b_hangar_id` = '' AND `universe` = ".$_SESSION['adminuni'].";");
	

		// EDIFICIOS
		if ($_POST['edif_p']	==	'on')
			$GLOBALS['DATABASE']->query("UPDATE ".PLANETS." SET ".implode(", ",$dbcol['build']).", `field_current` = '0' WHERE `planet_type` = '1' AND `universe` = ".$_SESSION['adminuni'].";");
	
		if ($_POST['edif_l']	==	'on')
			$GLOBALS['DATABASE']->query("UPDATE ".PLANETS." SET ".implode(", ",$dbcol['build']).", `field_current` = '0' WHERE `planet_type` = '3' AND `universe` = ".$_SESSION['adminuni'].";");
	
		if ($_POST['edif']	==	'on')
			$GLOBALS['DATABASE']->query("UPDATE ".PLANETS." SET `b_building` = '0', `b_building_id` = '' WHERE `universe` = ".$_SESSION['adminuni'].";");
	

		// INVESTIGACIONES Y OFICIALES
		if ($_POST['inves']	==	'on')
			$GLOBALS['DATABASE']->query("UPDATE ".USERS." SET ".implode(", ",$dbcol['tech'])." WHERE `universe` = ".$_SESSION['adminuni'].";");
	
		if ($_POST['ofis']	==	'on')
			$GLOBALS['DATABASE']->query("UPDATE ".USERS." SET ".implode(", ",$dbcol['officier'])." WHERE `universe` = ".$_SESSION['adminuni'].";");
	
		if ($_POST['inves_c']	==	'on')
			$GLOBALS['DATABASE']->query("UPDATE ".USERS." SET `b_tech_planet` = '0', `b_tech` = '0', `b_tech_id` = '0', `b_tech_queue` = '' WHERE `universe` = ".$_SESSION['adminuni'].";");
	
	
		// RECURSOS
		if ($_POST['dark']	==	'on')
			$GLOBALS['DATABASE']->query("UPDATE ".USERS." SET ".implode(", ",$dbcol['resource_user_start'])." WHERE `universe` = ".$_SESSION['adminuni'].";");
	
		if ($_POST['resources']	==	'on')
			$GLOBALS['DATABASE']->query("UPDATE ".PLANETS." SET ".implode(", ",$dbcol['resource_planet_start'])." WHERE `universe` = ".$_SESSION['adminuni'].";");
	
		// GENERAL
		if ($_POST['notes']	==	'on')
			$GLOBALS['DATABASE']->query("DELETE FROM ".NOTES." WHERE `universe` = ".$_SESSION['adminuni'].";");

		if ($_POST['rw']	==	'on')
			$GLOBALS['DATABASE']->query("DELETE FROM ".TOPKB." WHERE `universe` = ".$_SESSION['adminuni'].";");

		if ($_POST['friends']	==	'on')
			$GLOBALS['DATABASE']->query("DELETE FROM ".BUDDY." WHERE `universe` = ".$_SESSION['adminuni'].";");

		if ($_POST['alliances']	==	'on')
			$GLOBALS['DATABASE']->multi_query("DELETE FROM ".ALLIANCE." WHERE `ally_universe` = '".$_SESSION['adminuni']."';UPDATE ".USERS." SET `ally_id` = '0', `ally_register_time` = '0', `ally_rank_id` = '0' WHERE `universe` = ".$_SESSION['adminuni'].";");

		if ($_POST['fleets']	==	'on')
			$GLOBALS['DATABASE']->query("DELETE FROM ".FLEETS." WHERE `fleet_universe` = '".$_SESSION['adminuni']."';");

		if ($_POST['banneds']	==	'on')
			$GLOBALS['DATABASE']->multi_query("DELETE FROM ".BANNED." WHERE `universe` = ".$_SESSION['adminuni'].";UPDATE ".USERS." SET `bana` = '0', `banaday` = '0' WHERE `universe` = ".$_SESSION['adminuni'].";");

		if ($_POST['messages']	==	'on')
			$GLOBALS['DATABASE']->multi_query("DELETE FROM ".MESSAGES." WHERE `message_universe` = '".$_SESSION['adminuni']."';");

		if ($_POST['statpoints']	==	'on')
			$GLOBALS['DATABASE']->query("DELETE FROM ".STATPOINTS." WHERE `universe` = ".$_SESSION['adminuni'].";");

		$template->message($LNG['re_reset_excess'], '?page=reset&sid='.session_id(), 3);
		exit;
	}

	$template->assign_vars(array(	
		'button_submit'						=> $LNG['button_submit'],
		're_reset_universe_confirmation'	=> $LNG['re_reset_universe_confirmation'],
		're_reset_all'						=> $LNG['re_reset_all'],
		're_reset_all'						=> $LNG['re_reset_all'],
		're_defenses_and_ships'				=> $LNG['re_defenses_and_ships'],
		're_reset_buldings'					=> $LNG['re_reset_buldings'],
		're_buildings_lu'					=> $LNG['re_buildings_lu'],
		're_buildings_pl'					=> $LNG['re_buildings_pl'],
		're_buldings'						=> $LNG['re_buldings'],
		're_reset_hangar'					=> $LNG['re_reset_hangar'],
		're_ships'							=> $LNG['re_ships'],
		're_defenses'						=> $LNG['re_defenses'],
		're_resources_met_cry'				=> $LNG['re_resources_met_cry'],
		're_resources_dark'					=> $LNG['re_resources_dark'],
		're_resources'						=> $LNG['re_resources'],
		're_reset_invest'					=> $LNG['re_reset_invest'],
		're_investigations'					=> $LNG['re_investigations'],
		're_ofici'							=> $LNG['re_ofici'],
		're_inve_ofis'						=> $LNG['re_inve_ofis'],
		're_reset_statpoints'				=> $LNG['re_reset_statpoints'],
		're_reset_messages'					=> $LNG['re_reset_messages'],
		're_reset_banned'					=> $LNG['re_reset_banned'],
		're_reset_errors'					=> $LNG['re_reset_errors'],
		're_reset_fleets'					=> $LNG['re_reset_fleets'],
		're_reset_allys'					=> $LNG['re_reset_allys'],
		're_reset_buddies'					=> $LNG['re_reset_buddies'],
		're_reset_rw'						=> $LNG['re_reset_rw'],
		're_reset_notes'					=> $LNG['re_reset_notes'],
		're_reset_moons'					=> $LNG['re_reset_moons'],
		're_reset_planets'					=> $LNG['re_reset_planets'],
		're_reset_player'					=> $LNG['re_reset_player'],
		're_player_and_planets'				=> $LNG['re_player_and_planets'],
		're_general'						=> $LNG['re_general'],
	));
	
	$template->show('ResetPage.tpl');
}

?>