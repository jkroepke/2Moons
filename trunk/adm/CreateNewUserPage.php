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


if ($EditUsers != 1) die();

$parse	=	$lang;

$name		=	$_POST['name'];
$pass 		= 	md5($_POST['password']);
$email 		= 	$_POST['email'];
$galaxy		=	$_POST['galaxy'];
$system		=	$_POST['system'];
$planet		=	$_POST['planet'];
$auth		=	$_POST['authlevel'];
$time		=	time();
$i			=	0;
if ($_POST)
{
	$CheckUser = $db->fetch_array($db->query("SELECT `username` FROM ".USERS." WHERE `username` = '" . $db->sql_escape($_POST['name']) . "' LIMIT 1;"));
	$CheckMail = $db->fetch_array($db->query("SELECT `email` FROM ".USERS." WHERE `email` = '" . $db->sql_escape($_POST['email']) . "' LIMIT 1;"));
	$CheckRows = $db->fetch_array($db->query("SELECT `id` FROM ".PLANETS." WHERE `galaxy` = '".$galaxy."' AND `system` = '".$system."' AND `planet` = '".$planet."' LIMIT 1;"));
	
	
	if (!is_numeric($galaxy) &&  !is_numeric($system) && !is_numeric($planet)){
		$parse['display']	.=	'<tr><th colspan="2" class="red">'.$lang['new_only_numbers'].'</tr></th>';
		$i++;}
	elseif ($galaxy > MAX_GALAXY_IN_WORLD || $system > MAX_SYSTEM_IN_GALAXY || $planet > MAX_PLANET_IN_SYSTEM || $galaxy < 1 || $system < 1 || $planet < 1){
		$parse['display']	.=	'<tr><th colspan="2" class="red">'.$lang['new_error_coord'].'</tr></th>';
		$i++;}
		
	if (!$name || !$pass || !$email || !$galaxy || !$system || !$planet){
		$parse['display']	.=	'<tr><th colspan="2" class="red">'.$lang['new_complete_all'].'</tr></th>';
		$i++;}
		
	if (!is_email(strip_tags($email))){
		$parse['display']	.=	'<tr><th colspan="2" class="red">'.$lang['new_error_email2'].'</tr></th>';
		$i++;}

	if ($CheckUser){
		$parse['display']	.=	'<tr><th colspan="2" class="red">'.$lang['new_error_name'].'</tr></th>';
		$i++;}
		
	if ($CheckMail){
		$parse['display']	.=	'<tr><th colspan="2" class="red">'.$lang['new_error_email'].'</tr></th>';
		$i++;}
		
	if ($CheckRows){
		$parse['display']	.=	'<tr><th colspan="2" class="red">'.$lang['new_error_galaxy'].'</tr></th>';
		$i++;}
		
		
	if ($i	==	'0'){
		$Query1  = "INSERT INTO ".USERS." SET ";
		$Query1 .= "`username` = '" . $db->sql_escape(strip_tags($name)) . "', ";
		$Query1 .= "`email` = '" . $db->sql_escape($email) . "', ";
		$Query1 .= "`email_2` = '" . $db->sql_escape($email) . "', ";
		$Query1 .= "`ip_at_reg` = '" . $_SERVER["REMOTE_ADDR"] . "', ";
		$Query1 .= "`id_planet` = '0', ";
		$Query1 .= "`register_time` = '" .$time. "', ";
		$Query1 .= "`onlinetime` = '" .$time. "', ";
		$Query1 .= "`authlevel` = '" .$auth. "', ";
		$Query1 .= "`password`='" . $pass . "';";
		$db->query($Query1);
	
		$db->query("UPDATE ".CONFIG." SET `config_value` = config_value + '1' WHERE `config_name` = 'users_amount';");

		$ID_USER 	= $db->fetch_array($db->query("SELECT `id` FROM ".USERS." WHERE `username` = '" . $db->sql_escape($name) . "' LIMIT 1;"));
		
		CreateOnePlanetRecord ($galaxy, $system, $planet, $ID_USER['id'], $UserPlanet, true);
		
		$ID_PLANET 	= $db->fetch_array($db->query("SELECT `id` FROM ".USERS." WHERE `id_owner` = '". $ID_USER['id'] ."' LIMIT 1";));
		
		$db->query("UPDATE ".PLANETS." SET `id_level` = '".$auth."' WHERE `id` = '".$ID_PLANET['id']."';");
		
		$QryUpdateUser = "UPDATE ".USERS." SET ";
		$QryUpdateUser .= "`id_planet` = '" . $ID_PLANET['id'] . "', ";
		$QryUpdateUser .= "`current_planet` = '" . $ID_PLANET['id'] . "', ";
		$QryUpdateUser .= "`galaxy` = '" . $galaxy . "', ";
		$QryUpdateUser .= "`system` = '" . $system . "', ";
		$QryUpdateUser .= "`planet` = '" . $planet . "' ";
		$QryUpdateUser .= "WHERE ";
		$QryUpdateUser .= "`id` = '" . $ID_USER['id'] . "' ";
		$QryUpdateUser .= "LIMIT 1;";
		$db->query($QryUpdateUser);
		
		$parse['display']	=	'<tr><th colspan="2"><font color=lime>'.$lang['new_user_success'].'</font></tr></th>';
	}
}



display(parsetemplate(gettemplate('adm/CreateNewUserBody'), $parse), false, '', true, false);
?>