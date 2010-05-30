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


if ($EditUsers != 1) die(message ($LNG['404_page']));

$parse = $LNG;


if ($_GET['order'] == 'id')
	$ORDER	=	"id";
else
	$ORDER	=	"username";
	
	
	
if ($USER['authlevel'] != 3)
	$ListWHERE		=	"WHERE `authlevel` != 3";
	
	
if ($_GET['view'] == 'bana' && $USER['authlevel'] != 3)
	$WHEREBANA	=	"AND `bana` = 1";
elseif ($_GET['view'] == 'bana' && $USER['authlevel'] == 3)
	$WHEREBANA	=	"WHERE `bana` = 1";

$UserList		=	$db->query("SELECT `username`, `id`, `bana` FROM ".USERS." ".$ListWHERE." ".$WHEREBANA." ORDER BY ".$ORDER." ASC;");

$Users	=	0;
while ($a	=	$db->fetch_array($UserList))
{
	if ($a['bana']	==	'1')
		$SuspendedNow	=	$LNG['bo_characters_suus'];
	else
		$SuspendedNow	=	"";
		
	$parse['List']	.=	'<option value="'.$a['username'].'">'.$a['username'].'&nbsp;&nbsp;(ID:&nbsp;'.$a['id'].')'.$SuspendedNow.'</option>';
	$Users++;
}


if ($_GET['order2'] == 'id')
	$ORDER2	=	"id";
else
	$ORDER2	=	"username";
	
$Banneds	=	0;
$UserListBan	=	$db->query("SELECT `username`, `id` FROM ".USERS." WHERE `bana` = '1' ORDER BY ".$ORDER2." ASC;");
while ($b	=	$db->fetch_array($UserListBan))
{
	$parse['ListBan']	.=	'<option value="'.$b['username'].'">'.$b['username'].'&nbsp;&nbsp;(ID:&nbsp;'.$b['id'].')</option>';
	$Banneds++;
}

$parse['userss']	=	"<font color=lime>".$Users."</font>";
$parse['banneds']	=	"<font color=lime>".$Banneds."</font>";


$db->free_result($UserList);
$db->free_result($UserListBan);

if($_GET['panel'])
{
	$QueryUserBan			=	$db->fetch_array($db->query("SELECT * FROM ".BANNED." WHERE `who` = '".$_GET['ban_name']."';"));
	$QueryUserBanVacation	=	$db->fetch_array($db->query("SELECT urlaubs_modus FROM ".USERS." WHERE `username` = '".$_GET['ban_name']."';"));
		
	if (!$QueryUserBan)
	{
		$parse['title']			=	$LNG['bo_bbb_title_1'];
		$parse['changedate']	=	$LNG['bo_bbb_title_2'];
	}
	else
	{
		$parse['title']			=	$LNG['bo_bbb_title_3'];
		$parse['changedate']	=	$LNG['bo_bbb_title_6'];
		$parse['changedate_advert']	=	"<td class=c width=5%><img src=\"../styles/images/Adm/i.gif\" onMouseOver='return overlib(\"".$LNG['bo_bbb_title_4']."\", 
			CENTER, OFFSETX, -80, OFFSETY, -65, WIDTH, 250);' onMouseOut='return nd();'></td>";
			
		$parse['reas']			=	$QueryUserBan['theme'];
		$parse['timesus']		=	
			"<tr>
				<th>".$LNG['bo_bbb_title_5']."</th>
				<th height=25 colspan=2>".date("d-m-Y H:i:s", $QueryUserBan['longer'])."</th>
			</tr>";
	}
	
	
	if ($QueryUserBanVacation['urlaubs_modus'] == 1)
		$parse['vacation']	=	'checked	=	"checked"';
	else
		$parse['vacation']	=	'';
		
	$parse['name']			=	$_GET['ban_name'];



	if ($_POST['bannow'])
	{
		if(!is_numeric($_POST['days']) || !is_numeric($_POST['hour']) || !is_numeric($_POST['mins']) || !is_numeric($_POST['secs']))
			return display( parsetemplate(gettemplate("adm/BanOptionsResultBody"), $parse), false, '', true, false);
			
		$name              = $_POST['ban_name'];
		$reas              = $_POST['why'];
		$days              = $_POST['days'];
		$hour              = $_POST['hour'];
		$mins              = $_POST['mins'];
		$secs              = $_POST['secs'];
		$admin             = $USER['username'];
		$mail              = $USER['email'];
		$Now               = TIMESTAMP;
		$BanTime           = $days * 86400;
		$BanTime          += $hour * 3600;
		$BanTime          += $mins * 60;
		$BanTime          += $secs;
		if ($QueryUserBan['longer'] > TIMESTAMP)
			$BanTime          += ($QueryUserBan['longer'] - TIMESTAMP);
			
		if (($BanTime + $Now) < TIMESTAMP)
			$BannedUntil       = $Now;
		else
			$BannedUntil       = $Now + $BanTime;
		
		
		if ($QueryUserBan)
		{
			$QryInsertBan      = "UPDATE ".BANNED." SET ";
			$QryInsertBan     .= "`who` = '". $name ."', ";
			$QryInsertBan     .= "`theme` = '". $reas ."', ";
			$QryInsertBan     .= "`who2` = '". $name ."', ";
			$QryInsertBan     .= "`time` = '". $Now ."', ";
			$QryInsertBan     .= "`longer` = '". $BannedUntil ."', ";
			$QryInsertBan     .= "`author` = '". $admin ."', ";
			$QryInsertBan     .= "`email` = '". $mail ."' ";
			$QryInsertBan     .= "WHERE `who2` = '".$name."';";
			$db->query( $QryInsertBan);
		}
		else
		{
			$QryInsertBan      = "INSERT INTO ".BANNED." SET ";
			$QryInsertBan     .= "`who` = '". $name ."', ";
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
			$ASD	=	1;
		}
		else
		{
			$QryUpdateUser    .= "`urlaubs_modus` = '0'";
			$ASD	=	0;
		}

		$QryUpdateUser    .= "WHERE ";
		$QryUpdateUser    .= "`username` = '". $name ."';";
		$db->query( $QryUpdateUser);

		$PunishThePlanets     = "UPDATE ".PLANETS." SET ";
		$PunishThePlanets    .= "`metal_mine_porcent` = '0', ";
		$PunishThePlanets    .= "`crystal_mine_porcent` = '0', ";
		$PunishThePlanets    .= "`deuterium_sintetizer_porcent` = '0'";
		$PunishThePlanets    .= "WHERE ";
		$PunishThePlanets    .= "`id_owner` = '". $GetUserData['id'] ."';";
		$db->query( $PunishThePlanets);
		
		
		
		$Log	.=	"\n".$LNG['log_suspended_title']."\n";
		$Log	.=	$LNG['log_the_user'].$USER['username']." ".$LNG['log_suspended_1'].$name.$LNG['log_suspended_2']."\n";
		$Log	.=	$LNG['log_reason'].$reas."\n";
		$Log	.=	$LNG['log_time'].date("d-m-Y H:i:s", TIMESTAMP)."\n";
		$Log	.=	$LNG['log_longer'].date("d-m-Y H:i:s", $BannedUntil)."\n";
		$Log	.=	$LNG['log_vacations'].$LNG['log_viewmod'][$ASD]."\n";
				
		LogFunction($Log, "GeneralLog", $LogCanWork);


		header ("Location: BanPage.php?panel=ban_name&ban_name=".$_GET['ban_name']."&succes=yes");
	}
	if ($_GET['succes']	==	'yes')
		$parse['display']	=	"<tr><th colspan=\"2\"><font color=lime>". $LNG['bo_the_player'] . $name . $LNG['bo_banned'] ."</font></th></tr>";
	display( parsetemplate(gettemplate("adm/BanOptionsResultBody"), $parse), false, '', true, false);
}
elseif($_POST && $_POST['unban_name'])
{
	$name = $_POST['unban_name'];
	$db->query("DELETE FROM ".BANNED." WHERE who = '".$name."';");
	$db->query("UPDATE ".USERS." SET bana = '0', banaday = '0' WHERE username = '".$name."';");
	
	
	
	$Log	.=	"\n".$LNG['log_suspended_title']."\n";
	$Log	.=	$LNG['log_the_user'].$USER['username']." ".$LNG['log_suspended_3'].$name."\n";
				
	LogFunction($Log, "GeneralLog", $LogCanWork);
	
	header ("Location: BanPage.php?succes2=yes");
}
	if ($_GET['succes2'] == 'yes')
		$parse['display2']	=	"<tr><th colspan=\"2\"><font color=lime>". $LNG['bo_the_player2'] . $name . $LNG['bo_unbanned'] ."</font></th></tr>";



display( parsetemplate(gettemplate("adm/BanOptions"), $parse), false, '', true, false);
?>