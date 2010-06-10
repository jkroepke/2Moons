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

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

define('ROOT_PATH', './../');
include(ROOT_PATH . 'extension.inc');
include(ROOT_PATH . 'common.'.PHP_EXT);

if ($USER['id'] != 1) die(message($LNG['404_page']));
$parse	=	$LNG;

function ResetUniverse ( $CurrentUser )
{
	global $db;
		$db->query("RENAME TABLE ".PLANETS." TO ".PLANETS."_s;");
		$db->query("RENAME TABLE ".USERS." TO ".USERS."_s;");

		$db->query("CREATE TABLE IF NOT EXISTS ".PLANETS." ( LIKE ".PLANETS."_s );");
		$db->query("CREATE TABLE IF NOT EXISTS ".USERS." ( LIKE ".USERS."_s );");

		$db->query("TRUNCATE TABLE ".AKS.";");
		$db->query("TRUNCATE TABLE ".ALLIANCE.";");
		$db->query("TRUNCATE TABLE ".BANNED.";");
		$db->query("TRUNCATE TABLE ".BUDDY.";");
		$db->query("TRUNCATE TABLE ".ERRORS.";");
		$db->query("TRUNCATE TABLE ".FLEETS.";");
		$db->query("TRUNCATE TABLE ".MESSAGES.";");
		$db->query("TRUNCATE TABLE ".NOTES.";");
		$db->query("TRUNCATE TABLE ".RW.";");
		$db->query("TRUNCATE TABLE ".SUPP.";");
		$db->query("TRUNCATE TABLE ".STATPOINTS.";");
		$db->query("TRUNCATE TABLE ".TOPKB.";");

		$AllUsers  = $db->query ("SELECT `username`,`password`,`email`, `email_2`,`authlevel`,`galaxy`,`system`,`planet`, `dpath`, `onlinetime`, `register_time`, `id_planet` FROM ".USERS."_s;");
		$LimitTime = TIMESTAMP - (30 * (24 * (60 * 60)));
		$TransUser = 0;
		while ( $TheUser = $db->fetch_array($AllUsers) )
		{
			if ( $TheUser['onlinetime'] > $LimitTime )
			{
				$UserPlanet     = $db->fetch_array($db->query("SELECT `name` FROM ".PLANETS."_s WHERE `id` = '". $TheUser['id_planet']."';"));
				if ($UserPlanet['name'] != "")
				{
					$Time	=	TIMESTAMP;

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
					$db->query($QryInsertUser);
					$db->query("UPDATE ".USERS." SET `bana` = '0' WHERE `id` > '1';");

					$NewUser        = $db->fetch_array($db->query("SELECT `id` FROM ".USERS." WHERE `username` = '". $TheUser['username'] ."' LIMIT 1;"));
					require_once(ROOT_PATH.'includes/functions/CreateOnePlanetRecord.'.PHP_EXT);
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
 $Log	.=	"\n".$LNG['log_the_user'].$USER['username']." ".$LNG['log_reseteo'].":\n";
 if ($_POST['resetall']	!=	'on')
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
	if ($_POST['defenses']	==	'on'){
		$db->query("UPDATE ".PLANETS." SET ".implode(", ",$dbcol['defense']).";");
		$Log	.=	$LNG['log_defenses']."\n";}

	if ($_POST['ships']	==	'on'){
		$db->query("UPDATE ".PLANETS." SET ".implode(", ",$dbcol['fleet']).";");
		$Log	.=	$LNG['log_ships']."\n";}

	if ($_POST['h_d']	==	'on'){
		$db->query("UPDATE ".PLANETS." SET `b_hangar` = '0', `b_hangar_plus` = '0', `b_hangar_id` = ''");
		$Log	.=	$LNG['log_c_hangar']."\n";}



	// EDIFICIOS
	if ($_POST['edif_p']	==	'on'){
		$db->query("UPDATE ".PLANETS." SET ".implode(", ",$dbcol['build'])." WHERE `planet_type` = '1';");
		$Log	.=	$LNG['log_buildings_planet']."\n";}

	if ($_POST['edif_l']	==	'on'){
		$db->query("UPDATE ".PLANETS." SET ".implode(", ",$dbcol['build'])." WHERE `planet_type` = '3';");
		$Log	.=	$LNG['log_buildings_moon']."\n";}

	if ($_POST['edif']	==	'on'){
		$db->query("UPDATE ".PLANETS." SET `b_building` = '0', `b_building_id` = '';");
		$Log	.=	$LNG['log_c_buildings']."\n";}



	// INVESTIGACIONES Y OFICIALES
	if ($_POST['inves']	==	'on'){
		$db->query("UPDATE ".USERS." SET ".implode(", ",$dbcol['tech']).";");
		$Log	.=	$LNG['log_researchs']."\n";}

	if ($_POST['ofis']	==	'on'){
		$db->query("UPDATE ".USERS." SET ".implode(", ",$dbcol['officier']).";");
		$Log	.=	$LNG['log_officiers']."\n";}

	if ($_POST['inves_c']	==	'on'){
		$db->query("UPDATE ".PLANETS." SET `b_tech` = '0', `b_tech_id` = '0';");
		$db->query("UPDATE ".USERS." SET `b_tech_planet` = '0';");
		$Log	.=	$LNG['log_c_researchs']."\n";}



	// RECURSOS
	if ($_POST['dark']	==	'on'){
		$db->query("UPDATE ".USERS." SET `darkmatter` = '0';");
		$Log	.=	$LNG['log_darkmatter']."\n";}

	if ($_POST['resources']	==	'on'){
		$db->query("UPDATE ".PLANETS." SET `metal` = '0', `crystal` = '0', `deuterium` = '0';");
		$Log	.=	$LNG['log_resources']."\n";}



	// GENERAL
	if ($_POST['notes']	==	'on'){
		$db->query("TRUNCATE TABLE ".NOTES.";");
		$Log	.=	$LNG['log_notes']."\n";}

	if ($_POST['rw']	==	'on'){
		$db->query("TRUNCATE TABLE ".RW.";");
		$Log	.=	$LNG['log_rw']."\n";}

	if ($_POST['friends']	==	'on'){
		$db->query("TRUNCATE TABLE ".BUDDY.";");
		$Log	.=	$LNG['log_friends']."\n";}

	if ($_POST['alliances']	==	'on'){
		$db->query("TRUNCATE TABLE ".ALLIANCE.";");
		$db->query("UPDATE".USERS." SET `ally_id` = '0', `ally_name` = '', `ally_request` = '0',
									`ally_request_text` = 'NULL', `ally_register_time` = '0', `ally_rank_id` = '0';");
		$Log	.=	$LNG['log_alliances']."\n";}


	if ($_POST['fleets']	==	'on'){
		$db->query( "TRUNCATE TABLE ".FLEETS.";");
		$Log	.=	$LNG['log_fleets']."\n";}

	if ($_POST['errors']	==	'on'){
		$db->query( "TRUNCATE TABLE ".ERRORS.";");
		$Log	.=	$LNG['log_errors']."\n";}

	if ($_POST['banneds']	==	'on'){
		$db->query("TRUNCATE TABLE ".BANNED.";");
		$db->query("UPDATE ".USERS." SET `bana` = '0', `banaday` = '0' WHERE `id` > '1';");
		$Log	.=	$LNG['log_banneds']."\n";}

	if ($_POST['messages']	==	'on'){
		$db->query("TRUNCATE TABLE ".MESSAGES.";");
		$db->query("UPDATE ".USERS." SET `new_message` = '0';");
		$Log	.=	$LNG['log_messages']."\n";}

	if ($_POST['statpoints']	==	'on'){
		$db->query("TRUNCATE TABLE ".STATPOINTS.";");
		$Log	.=	$LNG['log_statpoints']."\n";}

	if ($_POST['moons']	==	'on'){
		$db->query("DELETE FROM ".PLANETS." WHERE `planet_type` = '3';");
		$Log	.=	$LNG['log_moons']."\n";}
 }
 else // REINICIAR TODO
 {
	ResetUniverse ( $USER );
	$Log	.=	$LNG['log_all_uni']."\n";
 }

	LogFunction($Log, "ResetLog", $LogCanWork);
	$parse['good']	=	'<tr><th colspan="2"><center><font color=lime>'.$LNG['re_reset_excess'].'</font></center></th></tr>';
}


display(parsetemplate(gettemplate('adm/ResetBody'), $parse), false, '', true, false);
?>