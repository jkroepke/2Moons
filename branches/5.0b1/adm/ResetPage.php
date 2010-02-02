<?php

##############################################################################
# *																			 #
# * RN FRAMEWORK															 #
# *  																		 #
# * @copyright Copyright (C) 2009 By ShadoX from xnova-reloaded.de	    	 #
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

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xgp_root = './../';
include($xgp_root . 'extension.inc.php');
include($xgp_root . 'common.'.$phpEx);
$parse	=	$lang;

if ($user['id'] != 1) die(message($lang['not_enough_permissions']));

function ResetUniverse ( $CurrentUser )
{
	global $phpEx, $db;

		$db->query( "RENAME TABLE ".PLANETS." TO ".PLANETS."_s;");
		$db->query( "RENAME TABLE ".USERS." TO ".USERS."_s;");

		$db->query( "CREATE  TABLE IF NOT EXISTS ".PLANETS." ( LIKE ".PLANETS."_s );");
		$db->query( "CREATE  TABLE IF NOT EXISTS ".USERS." ( LIKE ".USERS."_s );");

		$db->query( "TRUNCATE TABLE ".AKS.";", 'aks');
		$db->query( "TRUNCATE TABLE ".ALLIANCE.";", 'alliance');
		$db->query( "TRUNCATE TABLE ".BANNED.";", 'banned');
		$db->query( "TRUNCATE TABLE ".BUDDY.";", 'buddy');
		$db->query( "TRUNCATE TABLE ".ERRORS.";", 'errors');
		$db->query( "TRUNCATE TABLE ".FLEETS.";", 'fleets');
		$db->query( "TRUNCATE TABLE ".MESSAGES.";", 'messages');
		$db->query( "TRUNCATE TABLE ".NOTES.";", 'notes');
		$db->query( "TRUNCATE TABLE ".RW.";", 'rw');
		$db->query( "TRUNCATE TABLE ".STATPOINTS.";", 'statpoints');

		$AllUsers  = $db->query("SELECT `username`,`password`,`email`, `email_2`,`authlevel`,`galaxy`,`system`,`planet`, `dpath`, `onlinetime`, `register_time`, `id_planet` FROM ".USERS."_s WHERE 1;");
		$LimitTime = time() - (15 * (24 * (60 * 60)));
		$TransUser = 0;
		while ( $TheUser = $db->fetch($AllUsers) )
		{
			if ( $TheUser['onlinetime'] > $LimitTime )
			{
				$UserPlanet     = $db->fetch_array($db->query("SELECT `name` FROM ".PLANETS."_s WHERE `id` = '". $TheUser['id_planet']."';"));
				if ($UserPlanet['name'] != "")
				{
					$Time	=	time();

					$QryInsertUser  = "INSERT INTO ".USERS." SET ";
					$QryInsertUser .= "`username` = '".      $TheUser['username']      ."', ";
					$QryInsertUser .= "`email` = '".         $TheUser['email']         ."', ";
					$QryInsertUser .= "`email_2` = '".       $TheUser['email_2']       ."', ";
					$QryInsertUser .= "`id_planet` = '0', ";
					$QryInsertUser .= "`authlevel` = '".     $TheUser['authlevel']     ."', ";
					$QryInsertUser .= "`dpath` = '".         $TheUser['dpath']         ."', ";
					$QryInsertUser .= "`galaxy` = '".        $TheUser['galaxy']        ."', ";
					$QryInsertUser .= "`system` = '".        $TheUser['system']        ."', ";
					$QryInsertUser .= "`planet` = '".        $TheUser['planet']        ."', ";
					$QryInsertUser .= "`register_time` = '". $TheUser['register_time'] ."', ";
					$QryInsertUser .= "`onlinetime` = '". 	 $Time ."', ";
					$QryInsertUser .= "`password` = '".      $TheUser['password']      ."';";
					$db->query( $QryInsertUser);
					$db->query("UPDATE ".USERS." SET `bana` = '0' WHERE `id` > '1';");

					$NewUser        = $db->fetch_array($db->query("SELECT `id` FROM ".USERS." WHERE `username` = '". $TheUser['username'] ."' LIMIT 1;"));

					CreateOnePlanetRecord ($TheUser['galaxy'], $TheUser['system'], $TheUser['planet'], $NewUser['id'], $UserPlanet['name'], true);

					$db->query("UPDATE ".PLANETS." SET `id_level` = '".$TheUser['authlevel']."' WHERE `id_owner` = '".$NewUser['id']."';");
					$PlanetID       = $db->fetch_array($db->query("SELECT `id` FROM ".PLANETS." WHERE `id_owner` = '". $NewUser['id'] ."' LIMIT 1;"));

					$QryUpdateUser  = "UPDATE ".USERS." SET ";
					$QryUpdateUser .= "`id_planet` = '".      $PlanetID['id'] ."', ";
					$QryUpdateUser .= "`current_planet` = '". $PlanetID['id'] ."' ";
					$QryUpdateUser .= "WHERE ";
					$QryUpdateUser .= "`id` = '".             $NewUser['id']  ."';";
					$db->query( $QryUpdateUser);
					$TransUser++;
				}
			}
		}
		$db->query("UPDATE ".CONFIG." SET `config_value` = '". $TransUser ."' WHERE `config_name` = 'users_amount' LIMIT 1;");
		$db->query("DROP TABLE ".PLANETS."_s;");
		$db->query("DROP TABLE ".USERS."_s;");
}


if ($_POST)
{
 if ($_POST['resetall']	!=	'on')
 {
	// HANGARES Y DEFENSAS
	if ($_POST['defenses']	==	'on')
		$db->query("UPDATE ".PLANETS." SET `misil_launcher` = '0', `small_laser` = '0', `big_laser` = '0',
									`gauss_canyon` = '0', `ionic_canyon` = '0', `buster_canyon` = '0',
									`small_protection_shield` = '0', `planet_protector` = '0', `big_protection_shield` = '0',
									`interceptor_misil` = '0', `interplanetary_misil` = '0';");

	if ($_POST['ships']	==	'on')
		$db->query("UPDATE ".PLANETS." SET `small_ship_cargo` = '0', `big_ship_cargo` = '0', `light_hunter` = '0',
									`heavy_hunter` = '0', `crusher` = '0', `battle_ship` = '0',
									`colonizer` = '0', `recycler` = '0', `spy_sonde` = '0',
									`bomber_ship` = '0', `solar_satelit` = '0', `destructor` = '0',
									`dearth_star` = '0', `battleship` = '0', `supernova` = '0';");

	if ($_POST['h_d']	==	'on')
		$db->query("UPDATE ".PLANETS." SET `b_hangar` = '0', `b_hangar_plus` = '0', `b_hangar_id` = '';");



	// EDIFICIOS
	if ($_POST['edif_p']	==	'on')
		$db->query("UPDATE ".PLANETS." SET `metal_mine` = '0', `crystal_mine` = '0', `deuterium_sintetizer` = '0',
									`solar_plant` = '0', `fusion_plant` = '0', `robot_factory` = '0',
									`nano_factory` = '0', `hangar` = '0', `metal_store` = '0',
									`crystal_store` = '0', `deuterium_store` = '0', `laboratory` = '0',
									`terraformer` = '0', `ally_deposit` = '0', `silo` = '0' WHERE `planet_type` = '1';");

	if ($_POST['edif_l']	==	'on')
		$db->query("UPDATE ".PLANETS." SET `mondbasis` = '0', `phalanx` = '0', `sprungtor` = '0',
									`last_jump_time` = '0', `fusion_plant` = '0', `robot_factory` = '0',
									`hangar` = '0', `metal_store` = '0', `crystal_store` = '0',
									`deuterium_store` = '0', `ally_deposit` = '0' WHERE `planet_type` = '3';");

	if ($_POST['edif']	==	'on')
		$db->query("UPDATE ".PLANETS." SET `b_building` = '0', `b_building_id` = '';");



	// INVESTIGACIONES Y OFICIALES
	if ($_POST['inves']	==	'on')
		$db->query("UPDATE ".USERS." SET `spy_tech` = '0', `computer_tech` = '0', `military_tech` = '0',
									`defence_tech` = '0', `shield_tech` = '0', `energy_tech` = '0',
									`hyperspace_tech` = '0', `combustion_tech` = '0', `impulse_motor_tech` = '0',
									`hyperspace_motor_tech` = '0', `laser_tech` = '0', `ionic_tech` = '0',
									`buster_tech` = '0', `intergalactic_tech` = '0', `expedition_tech` = '0',
									`graviton_tech` = '0';");

	if ($_POST['ofis']	==	'on')
		$db->query("UPDATE ".USERS." SET `rpg_geologue` = '0', `rpg_amiral` = '0', `rpg_ingenieur` = '0',
									`rpg_technocrate` = '0', `rpg_espion` = '0', `rpg_constructeur` = '0',
									`rpg_scientifique` = '0', `rpg_commandant` = '0', `rpg_stockeur` = '0';");

	if ($_POST['inves_c']	==	'on')
		$db->query("UPDATE ".PLANETS." SET `b_tech` = '0', `b_tech_id` = '0';");
		$db->query("UPDATE ".USERS." SET `b_tech_planet` = '0';");



	// RECURSOS
	if ($_POST['dark']	==	'on')
		$db->query("UPDATE ".USERS." SET `darkmatter` = '0';");

	if ($_POST['resources']	==	'on')
		$db->query("UPDATE ".PLANETS." SET `metal` = '0', `crystal` = '0', `deuterium` = '0';");



	// GENERAL
	if ($_POST['notes']	==	'on')
		$db->query("TRUNCATE TABLE ".NOTES.";");

	if ($_POST['rw']	==	'on')
		$db->query("TRUNCATE TABLE ".PW.";");

	if ($_POST['friends']	==	'on')
		$db->query("TRUNCATE TABLE ".BUDDY.";");

	if ($_POST['alliances']	==	'on')
		$db->query("TRUNCATE TABLE ".ALLIANCE.";");
		$db->query("UPDATE ".USERS." SET `ally_id` = '0', `ally_name` = '', `ally_request` = '0',
									`ally_request_text` = 'NULL', `ally_register_time` = '0', `ally_rank_id` = '0';");


	if ($_POST['fleets']	==	'on')
		$db->query("TRUNCATE TABLE ".FLEETS.";");

	if ($_POST['errors']	==	'on')
		$db->query("TRUNCATE TABLE ".ERRORS.";");

	if ($_POST['banneds']	==	'on')
		$db->query("TRUNCATE TABLE ".BANNED.";");
		$db->query("UPDATE ".USERS." SET `bana` = '0', `banaday` = '0' WHERE `id` > '1';");

	if ($_POST['messages']	==	'on')
		$db->query("TRUNCATE TABLE ".MESSAGES.";");
		$db->query("UPDATE ".USERS." SET `new_message` = '0'", "users");

	if ($_POST['statpoints']	==	'on')
		$db->query("TRUNCATE TABLE ".STATPOINTS.";");

	if ($_POST['moons']	==	'on')
		$db->query("DELETE FROM ".PLANETS." WHERE `planet_type` = '3';");
 }
 else // REINICIAR TODO
 {
	ResetUniverse ( $user );
 }


	$parse['good']	=	'<tr><th colspan="2"><center><font color=lime>'.$lang['re_reset_excess'].'</font></center></th></tr>';
}


display(parsetemplate(gettemplate('adm/ResetBody'), $parse), false, '', true, false);
?>