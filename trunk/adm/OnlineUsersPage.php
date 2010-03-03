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

define('ROOT_PATH', './../');
include(ROOT_PATH . 'extension.inc');
include(ROOT_PATH . 'common.' . PHP_EXT);
include('AdminFunctions/Autorization.' . PHP_EXT);

if ($Observation != 1) die();

$parse	= $lang;

if ($_GET['cmd'] == 'sort')
	$TypeSort = $_GET['type'];
else
	$TypeSort = "id";

$queryuser 	= "u.id, u.username, u.user_agent, u.current_page, u.user_lastip, u.ally_name, u.onlinetime, u.email, u.galaxy, u.system, u.planet, u.urlaubs_modus, u.bana";
$querystat 	= "s.total_points";
$Last15Mins = $db->query("SELECT DISTINCT ". $queryuser .", ". $querystat ." FROM ".USERS." as u, ".STATPOINTS." as s
							WHERE u.onlinetime >= '". (time() - 15 * 60) ."' AND u.id=s.id_owner AND s.stat_type=1 AND u.current_page != '/game.php?page=logout'
							ORDER BY `". $db->sql_escape($TypeSort) ."` ASC;", '');


$Count      = 0;
$Color      = "lime";

while ($TheUser = $db->fetch_array($Last15Mins) )
{
	if ($PrevIP != "")
		if ($PrevIP == $TheUser['user_lastip'])
			$Color = "red";
	else
		$Color = "lime";

	$Bloc['dpath']              = $dpath;
	$Bloc['adm_ov_data_id']     = $TheUser['id'];
	$Bloc['adm_ov_data_name']   = $TheUser['username'];
	$Bloc['adm_ov_data_agen']   = $TheUser['user_agent'];
	$Bloc['current_page']    	= str_replace("%20", " ", $TheUser['current_page']);
	$Bloc['usr_s_id']    		= $TheUser['id'];
	$Bloc['adm_ov_data_clip']   = $Color;
	$Bloc['adm_ov_data_adip']   = $TheUser['user_lastip'];
	$Bloc['adm_ov_data_ally']   = ($TheUser['ally_name'] != '') ? $TheUser['ally_name'] : '-';
	$Bloc['adm_ov_data_point']  = pretty_number ( $TheUser['total_points'] );
	$Bloc['adm_ov_data_activ']  = pretty_time ( time() - $TheUser['onlinetime'] );
	$Bloc['adm_ov_data_pict']   = "m.gif";
	$PrevIP                     = $TheUser['user_lastip'];
	$Bloc['usr_email']    		= $TheUser['email'];
	$Bloc['state_vacancy'] 		= ($TheUser['urlaubs_modus'] == 1) ? $lang['ou_yes_yes'] : $lang['ou_not_banned'];
	$Bloc['is_banned']  		= ($TheUser['bana'] == 1) ? $lang['ou_yes_yes'] : $lang['ou_not_banned'];
	$Bloc['usr_planet_gal']    	= $TheUser['galaxy'];
	$Bloc['usr_planet_sys']    	= $TheUser['system'];
	$Bloc['usr_planet_pos']    	= $TheUser['planet'];
	$parse['adm_ov_data_table'] .= parsetemplate( gettemplate('adm/OnlineUsersRow'), $Bloc );
	$Count++;
}

$parse['adm_ov_data_count']  	= $Count;

display ( parsetemplate(gettemplate('adm/OnlineUsersBody'), $parse), false, '', true, false);

?>