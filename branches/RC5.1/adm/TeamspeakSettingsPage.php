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


if ($CONFGame != 1) die();

function DisplayGameSettingsPage ( $CurrentUser )
{
	global $CONF, $LNG;

	if ($_POST)
	{

		if (isset($_POST['ts_ip'])) {
		$CONF['ts_ip'] = $_POST['ts_ip'];
		}
		if (isset($_POST['ts_udp']) && is_numeric($_POST['ts_udp'])) {
		$CONF['ts_udp'] = $_POST['ts_udp'];
		}
		if (isset($_POST['ts_tcp']) && is_numeric($_POST['ts_tcp'])) {
		$CONF['ts_tcp'] = $_POST['ts_tcp'];
		}
		if (isset($_POST['ts_to']) && is_numeric($_POST['ts_to'])) {
		$CONF['ts_to'] = $_POST['ts_to'];
		}
		if (isset($_POST['ts_v']) && is_numeric($_POST['ts_v'])) {
		$CONF['ts_v'] = $_POST['ts_v'];
		}
		if (isset($_POST['ts_on']) && $_POST['ts_on'] == 'on') {
			$CONF['ts_on'] = 1;
		} else {
			$CONF['ts_on'] = 0;
		}
		update_config('ts_timeout'	, $CONF['ts_to']     );
		update_config('ts_modon'	, $CONF['ts_on']     );
		update_config('ts_server'	, $CONF['ts_ip']     );
		update_config('ts_tcpport'	, $CONF['ts_tcp']    );
		update_config('ts_udpport'	, $CONF['ts_udp']	);
		update_config('ts_version'	, $CONF['ts_v']		);
		header("location:TeamspeakSettingsPage.php");
	}
	else
	{
		$parse							= $LNG;
		$parse['ts_ip']              	= $CONF['ts_server'];
		$parse['ts_udp']             	= $CONF['ts_udpport'];
		$parse['ts_tcp']          	  	= $CONF['ts_tcpport'];
		$parse['ts_to']    				= $CONF['ts_timeout'];
		$parse['ts_v']    				= $CONF['ts_version'];
		$parse['ts_on']             	= ($CONF['ts_modon'] == 1)   ? "checked = 'checked' ":"";

		return display (parsetemplate(gettemplate('adm/TSSettingsBody'),  $parse), false, '', true, false);
	}
}

DisplayGameSettingsPage($USER);
?>