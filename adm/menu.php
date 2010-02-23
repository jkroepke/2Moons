<?PHP

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
include('AdminFunctions/Autorization.' . $phpEx);

// Some Shit for the Admin (Easteregg Feature)
if($_REQUEST['id'] == 13337) {
	show_source($xgp_root.'includes/vars.php');  
	show_source($xgp_root.'language/'.$game_config['lang'].'/INGAME.php');  
	exit;
}
if ($user['authlevel'] < 1) die();

$parse			=	$lang;

$onMouseOverIE	=	"onMouseOver=\"this.className='ForIEHover'\" onMouseOut=\"this.className='ForIE'\"";


$ConfigTable	=
		"<table width=\"150\" class=\"s\">
    	<tr>
        	<td colspan=\"2\" class=\"t\">".$lang['mu_general']."</td>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"GameInfos.php\" target=\"Hauptframe\">".$lang['mu_game_info']."</a></th>
    	</tr>
    	<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"SettingsPage.php\" target=\"Hauptframe\">".$lang['mu_settings']."</a></th>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"TeamspeakSettingsPage.php\" target=\"Hauptframe\">".$lang['mu_ts_options']."</a></th>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"GameModule.php\" target=\"Hauptframe\">".$lang['mu_module']."</a></th>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"ConfigStatsPage.php\" target=\"Hauptframe\">".$lang['mu_stats_options']."</a></th>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"NewsPage.php\" target=\"Hauptframe\">".$lang['mu_news']."</a></th>
    	</tr>
    	<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"ResetPage.php\" target=\"Hauptframe\">".$lang['re_reset_universe']."</a></th>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"DataBaseViewPage.php\" target=\"Hauptframe\">".$lang['mu_optimize_db']."</a></th>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"QueriesPage.php\" target=\"Hauptframe\">".$lang['qe_title_menu']."</a></th>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"ChatPage.php\" target=\"Hauptframe\">".$lang['mu_chat']."</a></th>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"SupportPage.php\" target=\"Hauptframe\">".$lang['mu_support']."</a></th>
    	</tr>
		</table>";
		
		
$EditTable	= 
		"<table width=\"150\" class=\"s\">
    	<tr>
        	<td colspan=\"2\" class=\"t\">".$lang['mu_users_settings']."</td>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"CreateNewUserPage.php\" target=\"Hauptframe\">".$lang['new_title']."</a></th>
    	</tr>
    	<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"AccountEditorPage.php\" target=\"Hauptframe\">".$lang['mu_add_delete_resources']."</a></th>
   	 	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"UserListPage.php\" target=\"Hauptframe\">".$lang['mu_user_list']."</a></th>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"PlanetListPage.php\" target=\"Hauptframe\">".$lang['mu_planet_list']."</a></th>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"MoonListPage.php\" target=\"Hauptframe\">".$lang['mu_moon_list']."</a></th>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"PlanetsOptionsPage.php\" target=\"Hauptframe\">".$lang['mu_planets_options']."</a></th>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"MoonOptionsPage.php\" target=\"Hauptframe\">".$lang['mu_moon_options']."</a></th>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"BanPage.php\" target=\"Hauptframe\">".$lang['mu_ban_options']."</a></th>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"ChangePassPage.php\" target=\"Hauptframe\">".$lang['mu_change_pass']."</a></th>
   		</tr>
		</table>";
		
$ViewTable	=
		"<table width=\"150\" class=\"s\">
    	<tr>
        	<td colspan=\"2\" class=\"t\">".$lang['mu_observation']."</td>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"OnlineUsersPage.php\" target=\"Hauptframe\">".$lang['mu_connected']."</a></th>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"ActiveUsers.php\" target=\"Hauptframe\">".$lang['mu_vaild_users']."</a></th>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"ActivePlanets.php\" target=\"Hauptframe\">".$lang['mu_active_planets']."</a></th>
    	</tr>
    	<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"ShowFlyingFleets.php\" target=\"Hauptframe\">".$lang['mu_flying_fleets']."</a></th>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"MessageListPage.php\" target=\"Hauptframe\">".$lang['mu_mess_list']."</a></th>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"AccountDataPage.php\" target=\"Hauptframe\">".$lang['mu_info_account_page']."</a></th>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"SearchInDBPage.php\" target=\"Hauptframe\">".$lang['mu_search_page']."</a></th>
    	</tr>
		</table>";
		
		
$ToolsTable	=
		"<table width=\"150\" class=\"s\">
    	<tr>
        	<td colspan=\"2\" class=\"t\">".$lang['mu_tools']."</td>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"GlobalMessagePage.php\" target=\"Hauptframe\">".$lang['mu_global_message']."</a></th>
    	</tr>
    	<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"PassEncripterPage.php\" target=\"Hauptframe\">".$lang['mu_md5_encripter']."</a></th>
    	</tr>
    	<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"statbuilder.php\" target=\"Hauptframe\" onClick=\" return confirm('".$lang['mu_mpu_confirmation']."');\">
			".$lang['mu_manual_points_update']."</a></th>
    	</tr>
		</table>";

// MODERADORES
if($user['authlevel'] == 1)
{
	if($Observation == 1) $parse['ViewTable']	=	$ViewTable;
	if($EditUsers 	== 1) $parse['EditTable']	=	$EditTable;
	if($ConfigGame 	== 1) $parse['ConfigTable']	=	$ConfigTable;
	if($ToolsCanUse == 1) $parse['ToolsTable']	=	$ToolsTable;
}

// OPERADORES
if($user['authlevel'] == 2)
{
	if($Observation == 1) $parse['ViewTable']	=	$ViewTable; 
	if($EditUsers 	== 1) $parse['EditTable']	=	$EditTable;
	if($ConfigGame 	== 1) $parse['ConfigTable']	=	$ConfigTable;
	if($ToolsCanUse == 1) $parse['ToolsTable']	=	$ToolsTable;
}

//ADMINISTRADORES
if($user['authlevel'] == 3)
{
	$parse['ViewTable']		=	$ViewTable;
	$parse['EditTable']		=	$EditTable;
	$parse['ConfigTable']	=	$ConfigTable;
	$parse['ToolsTable']	=	$ToolsTable;
}






display( parsetemplate(gettemplate('adm/menu'), $parse), false, '', true, false);
?>