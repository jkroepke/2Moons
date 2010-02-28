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

if ($ConfigGame != 1) die();

function DisplayGameSettingsPage ( $CurrentUser )
{
	global $game_config, $lang;

	if ($CurrentUser['authlevel'] < 3) die(message ($lang['not_enough_permissions']));

	if ($_POST)
	{

		if (isset($_POST['ts_ip'])) {
		$game_config['ts_ip'] = $_POST['ts_ip'];
		}
		if (isset($_POST['ts_udp']) && is_numeric($_POST['ts_udp'])) {
		$game_config['ts_udp'] = $_POST['ts_udp'];
		}
		if (isset($_POST['ts_tcp']) && is_numeric($_POST['ts_tcp'])) {
		$game_config['ts_tcp'] = $_POST['ts_tcp'];
		}
		if (isset($_POST['ts_to']) && is_numeric($_POST['ts_to'])) {
		$game_config['ts_to'] = $_POST['ts_to'];
		}
		if (isset($_POST['ts_v']) && is_numeric($_POST['ts_v'])) {
		$game_config['ts_v'] = $_POST['ts_v'];
		}
		if (isset($_POST['ts_on']) && $_POST['ts_on'] == 'on') {
			$game_config['ts_on'] = 1;
		} else {
			$game_config['ts_on'] = 0;
		}
		update_config('ts_modon'	, $game_config['ts_on']     );
		update_config('ts_modon'	, $game_config['ts_on']     );
		update_config('ts_server'	, $game_config['ts_ip']     );
		update_config('ts_tcpport'	, $game_config['ts_tcp']    );
		update_config('ts_udpport'	, $game_config['ts_udp']	);
		update_config('ts_version'	, $game_config['ts_v']		);
		header("location:TeamspeakSettingsPage.php");
	}
	else
	{
		$parse							= $lang;
		$parse['ts_ip']              	= $game_config['ts_server'];
		$parse['ts_udp']             	= $game_config['ts_udpport'];
		$parse['ts_tcp']          	  	= $game_config['ts_tcpport'];
		$parse['ts_to']    				= $game_config['ts_timeout'];
		$parse['ts_v']    				= $game_config['ts_version'];
		$parse['ts_on']             	= ($game_config['ts_modon'] == 1)   ? "checked = 'checked' ":"";

		return display (parsetemplate(gettemplate('adm/TSSettingsBody'),  $parse), false, '', true, false);
	}
}

DisplayGameSettingsPage($user);
?>