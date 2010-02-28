<?php

##############################################################################
# *																			 #
# * RN FRAMEWORK															 #
# *  																		 #
# * @copyright Copyright (C) 2009 By ShadoX from xnova-reloaded.de	 		 #
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

define('ROOT_PATH', './../');
include(ROOT_PATH . 'extension.inc');
include(ROOT_PATH . 'common.' . PHP_EXT);
include('AdminFunctions/Autorization.' . PHP_EXT);

if ($EditUsers != 1) die();

$parse = $lang;

$UserList 	= 	$db->query("SELECT `username` FROM ".USERS.";");
while ($a	=	$db->fetch_array($UserList))
{
	$parse['List']	.=	'<option value="'.$a['username'].'">'.$a['username'].'</option>';
}

$UserListBan	=	$db->query("SELECT `username` FROM ".USERS." WHERE `bana` = '1';");
while ($b	=	$db->fetch_array($UserListBan))
{
	$parse['ListBan']	.=	'<option value="'.$b['username'].'">'.$b['username'].'</option>';
}

if($_POST && $_POST['ban_name'])
{
	$QueryUserExist	=	$db->query("SELECT * FROM ".USERS." WHERE `username` LIKE '%{$_POST['ban_name']}%';");
	if ($db->num_rows($QueryUserExist) != 0)
	{
		$name              = $_POST['ban_name'];
		$reas              = $_POST['why'];
		$days              = $_POST['days'];
		$hour              = $_POST['hour'];
		$mins              = $_POST['mins'];
		$secs              = $_POST['secs'];
		$admin             = $user['username'];
		$mail              = $user['email'];
		$Now               = time();
		$BanTime           = $days * 86400;
		$BanTime          += $hour * 3600;
		$BanTime          += $mins * 60;
		$BanTime          += $secs;
		$BannedUntil       = $Now + $BanTime;

		$QueryUserBan	=	$db->query("SELECT * FROM ".BANNED." WHERE `who` LIKE '%{$name}%';");
		if ($db->num_rows($QueryUserBan) != 0)
		{
			$QryInsertBan      = "UPDATE ".BANNED." SET ";
			$QryInsertBan     .= "`who` = \"". $name ."\", ";
			$QryInsertBan     .= "`theme` = '". $reas ."', ";
			$QryInsertBan     .= "`who2` = '". $name ."', ";
			$QryInsertBan     .= "`time` = '". $Now ."', ";
			$QryInsertBan     .= "`longer` = '". $BannedUntil ."', ";
			$QryInsertBan     .= "`author` = '". $admin ."', ";
			$QryInsertBan     .= "`email` = '". $mail ."' ";
			$QryInsertBan     .= "WHERE `who2` = '{$name}';";
			$db->query( $QryInsertBan);
		}
		else
		{
			$QryInsertBan      = "INSERT INTO ".BANNED." SET ";
			$QryInsertBan     .= "`who` = \"". $name ."\", ";
			$QryInsertBan     .= "`theme` = '". $reas ."', ";
			$QryInsertBan     .= "`who2` = '". $name ."', ";
			$QryInsertBan     .= "`time` = '". $Now ."', ";
			$QryInsertBan     .= "`longer` = '". $BannedUntil ."', ";
			$QryInsertBan     .= "`author` = '". $admin ."', ";
			$QryInsertBan     .= "`email` = '". $mail ."';";
			$db->query( $QryInsertBan);
		}

		$QryUpdateUser     = "UPDATE ".USERS." SET ";
		$QryUpdateUser    .= "`bana` = '1', ";
		$QryUpdateUser    .= "`banaday` = '". $BannedUntil ."', ";

		if(isset($_POST['vacat']))
		{
			$QryUpdateUser    .= "`urlaubs_modus` = '1'";
		}
		else
		{
			$QryUpdateUser    .= "`urlaubs_modus` = '0'";
		}

		$QryUpdateUser    .= " WHERE ";
		$QryUpdateUser    .= "`username` = '". $name ."';";
		$db->query( $QryUpdateUser, 'users');

		$PunishThePlanets     = "UPDATE ".PLANETS." SET ";
		$PunishThePlanets    .= "`metal_mine_porcent` = '0', ";
		$PunishThePlanets    .= "`crystal_mine_porcent` = '0', ";
		$PunishThePlanets    .= "`deuterium_sintetizer_porcent` = '0'";
		$PunishThePlanets    .= "WHERE ";
		$PunishThePlanets    .= "`id_owner` = \"". $GetUserData['id'] ."\";";
		$db->query( $PunishThePlanets);

		$parse['display']	=	"<tr><th colspan=\"2\"><font color=lime>". $lang['bo_the_player'] ." ". $name . " - " . $lang['bo_banned'] ."</font></th></tr>";
	}
	else
	{
		$parse['display']	=	"<tr><th colspan=\"2\"><font color=red>".$lang['bo_user_doesnt_exist']."</font></th></tr>";
	}
}
elseif($_POST && $_POST['unban_name'])
{
	$name = $_POST['unban_name'];
	$db->query("DELETE FROM ".BANNED." WHERE who2='".$name."';");
	$db->query("UPDATE ".USERS." SET bana = '0', banaday = '0' WHERE username='".$name."';");
	
	$parse['display2']	=	"<tr><th colspan=\"2\"><font color=lime>". $lang['bo_the_player2'] . $name . $lang['bo_unbanned'] ."</font></th></tr>";
}



display( parsetemplate(gettemplate("adm/BanOptions"), $parse), false, '', true, false);
?>