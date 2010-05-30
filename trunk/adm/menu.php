<?PHP

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


if ($USER['authlevel'] < 1) die(message ($LNG['404_page']));

$parse			=	$LNG;

$onMouseOverIE		=	"onMouseOver=\"this.className='ForIEHover'\" onMouseOut=\"this.className='ForIE'\"";
$onMouseOverIELime	=	"onMouseOver=\"this.className='ForIEHoverLime'\" onMouseOut=\"this.className='ForIEHoverr'\"";


$CONFTable	=
		"<table width=\"150\" class=\"s\">
    	<tr>
        	<td colspan=\"2\" class=\"t\">".$LNG['mu_general']."</td>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"GameInfos.php\" target=\"Hauptframe\">".$LNG['mu_game_info']."</a></th>
    	</tr>
    	<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"SettingsPage.php\" target=\"Hauptframe\">".$LNG['mu_settings']."</a></th>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"TeamspeakSettingsPage.php\" target=\"Hauptframe\">".$LNG['mu_ts_options']."</a></th>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"FacebookSettingsPage.php\" target=\"Hauptframe\">".$LNG['mu_fb_options']."</a></th>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"GameModule.php\" target=\"Hauptframe\">".$LNG['mu_module']."</a></th>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"LogToolPage.php\" target=\"Hauptframe\">".$LNG['mu_user_logs']."</a></th>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"DataBaseViewPage.php\" target=\"Hauptframe\">".$LNG['mu_optimize_db']."</a></th>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"ConfigStatsPage.php\" target=\"Hauptframe\">".$LNG['mu_stats_options']."</a></th>
    	</tr> 
		<tr>
            <th ".$onMouseOverIE." class=\"ForIE\"><a href=\"ChatPage.php\" target=\"Hauptframe\">".$LNG['mu_chat']."</a></th>
        </tr>
        <tr>
            <th ".$onMouseOverIE." class=\"ForIE\"><a href=\"UpdatePage.php\" target=\"Hauptframe\">".$LNG['mu_update']."</a></th>
        </tr>
		</table>";
		
		
$EditTable	= 
		"<table width=\"150\" class=\"s\">
    	<tr>
        	<td colspan=\"2\" class=\"t\">".$LNG['mu_users_settings']."</td>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"MakerPage.php\" target=\"Hauptframe\">".$LNG['new_creator_title']."</a></th>
   	 	</tr>
    	<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"AccountEditorPage.php\" target=\"Hauptframe\">".$LNG['mu_add_delete_resources']."</a></th>
   	 	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"BanPage.php\" target=\"Hauptframe\">".$LNG['mu_ban_options']."</a></th>
    	</tr>
		</table>";
		
$ViewTable	=
		"<table width=\"150\" class=\"s\">
    	<tr>
        	<td colspan=\"2\" class=\"t\">".$LNG['mu_observation']."</td>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"SearchingPage.php?search=online&minimize=on\" target=\"Hauptframe\">".$LNG['mu_connected']."</a></th>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"SupportPage.php\" target=\"Hauptframe\">".$LNG['mu_support']."</a></th>
    	</tr> 
		<tr>
            <th ".$onMouseOverIE." class=\"ForIE\"><a href=\"ActiveUsers.php\" target=\"Hauptframe\">".$LNG['mu_vaild_users']."</a></th>
        </tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"SearchingPage.php?search=p_connect&minimize=on\" target=\"Hauptframe\">".$LNG['mu_active_planets']."</a></th>
    	</tr>
    	<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"ShowFlyingFleets.php\" target=\"Hauptframe\">".$LNG['mu_flying_fleets']."</a></th>
    	</tr>
    	<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"NewsPage.php\" target=\"Hauptframe\">".$LNG['mu_news']."</a></th>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"SearchingPage.php?search=users&minimize=on\" target=\"Hauptframe\">".$LNG['mu_user_list']."</a></th>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"SearchingPage.php?search=planet&minimize=on\" target=\"Hauptframe\">".$LNG['mu_planet_list']."</a></th>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"SearchingPage.php?search=moon&minimize=on\" target=\"Hauptframe\">".$LNG['mu_moon_list']."</a></th>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"MessageListPage.php\" target=\"Hauptframe\">".$LNG['mu_mess_list']."</a></th>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"AccountDataPage.php\" target=\"Hauptframe\">".$LNG['mu_info_account_page']."</a></th>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"SearchingPage.php\" target=\"Hauptframe\">".$LNG['mu_search_page']."</a></th>
    	</tr>
		</table>";
		
		
$ToolsTable	=
		"<table width=\"150\" class=\"s\">
    	<tr>
        	<td colspan=\"2\" class=\"t\">".$LNG['mu_tools']."</td>
    	</tr>
		<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"GlobalMessagePage.php\" target=\"Hauptframe\">".$LNG['mu_global_message']."</a></th>
    	</tr>
    	<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"PassEncripterPage.php\" target=\"Hauptframe\">".$LNG['mu_md5_encripter']."</a></th>
    	</tr>
    	<tr>
        	<th ".$onMouseOverIE." class=\"ForIE\"><a href=\"statbuilder.php\" target=\"Hauptframe\" onClick=\" return confirm('".$LNG['mu_mpu_confirmation']."');\">
			".$LNG['mu_manual_points_update']."</a></th>
		</table>";


// MODERADORES
if($USER['authlevel'] == 1)
{
	if($Observation == 1) $parse['ViewTable']	=	$ViewTable;
	if($EditUsers 	== 1) $parse['EditTable']	=	$EditTable;
	if($CONFGame 	== 1) $parse['ConfigTable']	=	$CONFTable;
	if($ToolsCanUse == 1) $parse['ToolsTable']	=	$ToolsTable;
}

// OPERADORES
if($USER['authlevel'] == 2)
{
	if($Observation == 1) $parse['ViewTable']	=	$ViewTable; 
	if($EditUsers 	== 1) $parse['EditTable']	=	$EditTable;
	if($CONFGame 	== 1) $parse['ConfigTable']	=	$CONFTable;
	if($ToolsCanUse == 1) $parse['ToolsTable']	=	$ToolsTable;
}

//ADMINISTRADORES
if($USER['authlevel'] == 3)
{
	$parse['ViewTable']		=	$ViewTable;
	$parse['EditTable']		=	$EditTable;
	$parse['ConfigTable']	=	$CONFTable;
	$parse['ToolsTable']	=	$ToolsTable;
}



display( parsetemplate(gettemplate('adm/menu'), $parse), false, '', true, false);
?>