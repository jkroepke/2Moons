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

if ($USER['rights'][str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__)] != 1) exit;

function ShowTeamspeakPage() {
	global $CONF, $LNG;

	if ($_POST)
	{
		if (isset($_POST['ts_on']) && $_POST['ts_on'] == 'on') {
			$CONF['ts_modon'] = 1;
		} else {
			$CONF['ts_modon'] = 0;
		}
		
		$CONF['ts_server']			= request_var('ts_ip', '');
		$CONF['ts_tcpport']			= request_var('ts_tcp', 0);
		$CONF['ts_udpport']			= request_var('ts_udp', 0);
		$CONF['ts_timeout']			= request_var('ts_to', 0);
		$CONF['ts_version']			= request_var('ts_v', 0);
		$CONF['ts_login']			= request_var('ts_login', '');
		$CONF['ts_password']		= request_var('ts_password', '', true);
		$CONF['ts_cron_interval']	= request_var('ts_cron', 0);
		
		update_config(array(
			'ts_timeout'		=> $CONF['ts_timeout'],
			'ts_modon'			=> $CONF['ts_modon'],
			'ts_server'			=> $CONF['ts_server'],
			'ts_tcpport'		=> $CONF['ts_tcpport'],
			'ts_udpport'		=> $CONF['ts_udpport'],
			'ts_version'		=> $CONF['ts_version'],
			'ts_login'			=> $CONF['ts_login'],
			'ts_password'		=> $CONF['ts_password'],
			'ts_cron_interval'	=> $CONF['ts_cron_interval']
		), true);
	}
	$template	= new template();
	
	$template->page_header();
	$template->assign_vars(array(
		'se_save_parameters'	=> $LNG['se_save_parameters'],
		'ts_tcpport'			=> $LNG['ts_tcpport'],
		'ts_serverip'			=> $LNG['ts_serverip'],
		'ts_version'			=> $LNG['ts_version'],
		'ts_active'				=> $LNG['ts_active'],
		'ts_settings'			=> $LNG['ts_settings'],
		'ts_udpport'			=> $LNG['ts_udpport'],
		'ts_timeout'			=> $LNG['ts_timeout'],
		'ts_server_query'		=> $LNG['ts_server_query'],
		'ts_sq_login'			=> $LNG['ts_login'],
		'ts_sq_pass'			=> $LNG['ts_pass'],
		'ts_lng_cron'			=> $LNG['ts_cron'],
		'ts_to'					=> $CONF['ts_timeout'],
		'ts_on'					=> $CONF['ts_modon'],
		'ts_ip'					=> $CONF['ts_server'],
		'ts_tcp'				=> $CONF['ts_tcpport'],
		'ts_udp'				=> $CONF['ts_udpport'],
		'ts_v'					=> $CONF['ts_version'],
		'ts_login'				=> $CONF['ts_login'],
		'ts_password'			=> $CONF['ts_password'],
		'ts_cron'				=> $CONF['ts_cron_interval']
	));
	$template->show('adm/TeamspeakPage.tpl');

}
?>