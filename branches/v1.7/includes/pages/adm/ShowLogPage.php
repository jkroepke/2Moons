<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package 2Moons
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2009 Lucky <douglas@crockford.com> (XGProyecto)
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.3 (2011-01-21)
 * @link http://2moons.cc/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) throw new Exception("Permission error!");
function ShowLog()
{
	global $LNG, $resources;
	
	$table = HTTP::_GP('type', '');
	
	# Modes:
	# 1 => Playerlist Changes
	#	target => Player-ID
	# 2 => Planetlist Changes
	#	target => Planet-ID
	# 3 => Div. Settings Pages
	#	target 0 => Server-Settings
	#	target 1 => Universe-Settings
	#	target 2 => Stat-Settings
	#	target 3 => Chat-Settings
	#	target 4 => TeamSpeak-Settings
	#	target 5 => Impressum-Settings
	# 4 => Presents
	#
	# TODO: LOG Search
	
	switch ($table) {
		case 'planet':
			ShowLogPlanetsList();
		break;
		case 'player':
			ShowLogPlayersList();
		break;
		case 'settings':
			ShowLogSettingsList();
		break;
		case 'present':
			ShowLogPresent();
		break;
		case 'detail':
			ShowLogDetail();
		break;
		default:
			ShowLogOverview();
		break;
	}
}

function ShowLogOverview() {
	global $LNG;
	$template	= new template();	
	$template->show("LogOverview.tpl");
}

function ShowLogDetail() {
	global $LNG;
	$logid = HTTP::_GP('id', 0);
	$result   	= $GLOBALS['DATABASE']->getFirstRow("SELECT l.*, u_a.username as admin_username FROM ".LOG." as l LEFT JOIN ".USERS." as u_a ON  u_a.id = l.admin  WHERE l.id = ".$logid."");
	
	$data = unserialize($result['data']);
	$conf_before	= array();
	$conf_after		= array();
	foreach ($data[0] as $key => $i) {
		$conf_before[$key] = $i;
	}
	foreach ($data[1] as $key => $i) {
		$conf_after[$key] = $i;
	}
	
	$Wrapper = array(
		'resource_multiplier' 		=> $LNG['se_resources_producion_speed'],
		'forum_url' 				=> $LNG['se_forum_link'],
		'game_speed' 				=> $LNG['se_general_speed'],
		'chat_socket_chatid_info' 	=> $LNG['ch_socket_chatid_info'],
		'chat_socket_port_info' 	=> $LNG['ch_socket_port_info'],
		'chat_socket_ip_info' 		=> $LNG['ch_socket_ip_info'],
		'chat_socket_host_info' 	=> $LNG['ch_socket_host_info'],
		'chat_socket_chatid' 		=> $LNG['ch_socket_chatid'],
		'chat_socket_port' 			=> $LNG['ch_socket_port'],
		'chat_socket_ip' 			=> $LNG['ch_socket_ip'],
		'chat_socket_host' 			=> $LNG['ch_socket_host'],
		'chat_socket_active' 		=> $LNG['ch_socket_active'],
		'chat_socket' 				=> $LNG['ch_socket'],
		'chat_closed' 				=> $LNG['ch_closed'],
		'chat_allowchan' 			=> $LNG['ch_allowchan'],
		'chat_allowmes' 			=> $LNG['ch_allowmes'],
		'chat_allowdelmes' 			=> $LNG['ch_allowcelmes'],
		'chat_logmessage' 			=> $LNG['ch_logmessage'],
		'chat_nickchange' 			=> $LNG['ch_nickchange'],
		'chat_botname' 				=> $LNG['ch_botname'],
		'chat_channelname' 			=> $LNG['ch_channelname'],
		
		'ts_modon' 			=> $LNG['ts_active'],
		'ts_server' 		=> $LNG['ts_serverip'],
		'ts_password' 		=> $LNG['ts_pass'],
		'ts_cron_interval' 	=> $LNG['ts_cron'],
		
		'stat_settings' 	=> $LNG['cs_point_per_resources_used'],
		'stat' 				=> $LNG['cs_points_to_zero'],
		'stat_update_time' 	=> $LNG['cs_time_between_updates'],
		'stat_level' 		=> $LNG['cs_access_lvl'],
		
		'capaktiv' 		=> $LNG['se_recaptcha_active'],
		'cappublic' 	=> $LNG['se_recaptcha_public'],
		'capprivate' 	=> $LNG['se_recaptcha_private'],
		'ga_key' 		=> $LNG['se_google_key'],
		
		'metal'			=> $LNG['tech'][901],
		'crystal'		=> $LNG['tech'][902],
		'deuterium'		=> $LNG['tech'][903],
		'darkmatter'	=> $LNG['tech'][921],
		
		'authattack'	=> $LNG['qe_authattack'],
		'username'		=> $LNG['adm_username'],
		'field_max'		=> $LNG['qe_fields'],
	);
	
	foreach ($conf_before as $key => $val) {
		if ($key != 'universe') {
			if(isset($LNG['tech'][$key]))
				$Element = $LNG['tech'][$key];
			elseif(isset($LNG['se_'.$key]))
				$Element = $LNG['se_'.$key];
			elseif(isset($LNG[$key]))
				$Element = $LNG[$key];
			elseif(isset($Wrapper[$key]))
				$Element = $Wrapper[$key];
			else
				$Element = $key;
			
			$LogArray[]	= array(
				'Element'	=> $Element,
				'old'		=> ($Element == 'urlaubs_until' ? _date($LNG['php_tdformat'], $val) : (is_numeric($val) ? pretty_number($val) : $val)),
				'new'		=> ($Element == 'urlaubs_until' ? _date($LNG['php_tdformat'], $conf_after[$key]) : (is_numeric($conf_after[$key]) ? pretty_number($conf_after[$key]) : $conf_after[$key])),
			);
		}
	}
		
	$template	= new template();	
	$template->assign_vars(array(	
		'LogArray'		=> $LogArray,
		'admin'			=> $result['admin_username'],
		'target'		=> $result['universe'],
		'id'			=> $result['id'],
		'time'			=> _date($LNG['php_tdformat'], $result['time'], $USER['timezone']),
		'log_info'		=> $LNG['log_info'],
		'log_admin'		=> $LNG['log_admin'],
		'log_time'		=> $LNG['log_time'],
		'log_target'	=> $LNG['log_universe'],
		'log_id'		=> $LNG['log_id'],
		'log_element'	=> $LNG['log_element'],
		'log_old'		=> $LNG['log_old'],
		'log_new'		=> $LNG['log_new'],
	));
	
	$template->show("LogDetail.tpl");
}

function ShowLogSettingsList() {
	global $LNG;
	$result    = $GLOBALS['DATABASE']->query("SELECT l.id, l.admin, l.time, l.universe, l.target,u_a.username as admin_username FROM ".LOG." as l LEFT JOIN ".USERS." as u_a ON  u_a.id = l.admin WHERE mode = 3 ORDER BY id DESC");

	$template	= new template();	
	if(!$result)
		$template->message($LNG['log_no_data']);
	
	$targetkey = array(
		0 => $LNG['log_ssettings'],
		1 => $LNG['log_usettings'],
		2 => $LNG['log_statsettings'],
		3 => $LNG['log_chatsettings'],
		4 => $LNG['log_tssettings'],
		5 => $LNG['log_disclamersettings']
	);
	
	while ($LogRow = $GLOBALS['DATABASE']->fetch_array($result))
	{			
		$LogArray[]	= array(
			'id'			=> $LogRow['id'],
			'admin'			=> $LogRow['admin_username'],
			'target_uni'	=> ($LogRow['target'] == 0 ? '' : $LogRow['universe']),
			'target'		=> $targetkey[$LogRow['target']],
			'time'			=> _date($LNG['php_tdformat'], $LogRow['time'], $USER['timezone']),
		);
	}
	$GLOBALS['DATABASE']->free_result($result);
	$template->assign_vars(array(	
		'LogArray'				=> $LogArray,
		'log_log'		=> $LNG['log_log'],
		'log_admin'		=> $LNG['log_admin'],
		'log_time'		=> $LNG['log_time'],
		'log_uni'		=> $LNG['log_uni_short'],
		'log_target'	=> $LNG['log_target_universe'],
		'log_id'		=> $LNG['log_id'],
		'log_view'		=> $LNG['log_view'],
	));
	$template->show("LogList.tpl");
}

function ShowLogPlanetsList() {
	global $LNG;

	$result    = $GLOBALS['DATABASE']->query("SELECT DISTINCT l.id, l.admin, l.target, l.time, l.universe,u_t.username as target_username, p.galaxy as target_galaxy, p.system as target_system, p.planet as target_planet,u_a.username as admin_username FROM ".LOG." as l LEFT JOIN ".USERS." as u_a ON  u_a.id = l.admin LEFT JOIN ".PLANETS." as p ON p.id = l.target LEFT JOIN ".USERS." as u_t ON u_t.id = p.id_owner WHERE mode = 2 ORDER BY id DESC");

	$template	= new template();	
	if(!$result)
		$template->message($LNG['log_no_data']);
		
	while ($LogRow = $GLOBALS['DATABASE']->fetch_array($result))
	{			
		$LogArray[]	= array(
			'id'		=> $LogRow['id'],
			'admin'		=> $LogRow['admin_username'],
			'target_uni'=> $LogRow['universe'],
			'target'	=> '['.$LogRow['target_galaxy'].':'.$LogRow['target_system'].':'.$LogRow['target_planet'].'] -> '.$LogRow['target_username'],
			'time'		=> _date($LNG['php_tdformat'], $LogRow['time'], $USER['timezone']),
		);
	}
	$GLOBALS['DATABASE']->free_result($result);
	$template	= new template();	
	$template->assign_vars(array(	
		'LogArray'		=> $LogArray,
		'log_log'		=> $LNG['log_log'],
		'log_admin'		=> $LNG['log_admin'],
		'log_time'		=> $LNG['log_time'],
		'log_uni'		=> $LNG['log_uni_short'],
		'log_target'	=> $LNG['log_target_planet'],
		'log_id'		=> $LNG['log_id'],
		'log_view'		=> $LNG['log_view'],
	));
	$template->show("LogList.tpl");
}

function ShowLogPlayersList() {
	global $LNG;

	$result    = $GLOBALS['DATABASE']->query("SELECT DISTINCT l.id, l.admin, l.target, l.time, l.universe,u_t.username as target_username,u_a.username as admin_username FROM ".LOG." as l LEFT JOIN ".USERS." as u_a ON  u_a.id = l.admin LEFT JOIN ".USERS." as u_t ON u_t.id = l.target WHERE mode = 1 ORDER BY l.id DESC");

	$template	= new template();	
	if(!$result)
		$template->message($LNG['log_no_data']);
		
	while ($LogRow = $GLOBALS['DATABASE']->fetch_array($result))
	{			
		$LogArray[]	= array(
			'id'		=> $LogRow['id'],
			'admin'		=> $LogRow['admin_username'],
			'target_uni'=> $LogRow['universe'],
			'target'	=> $LogRow['target_username'],
			'time'		=> _date($LNG['php_tdformat'], $LogRow['time'], $USER['timezone']),
		);
	}
	$GLOBALS['DATABASE']->free_result($result);
	$template->assign_vars(array(	
		'LogArray'		=> $LogArray,
		'log_log'		=> $LNG['log_log'],
		'log_admin'		=> $LNG['log_admin'],
		'log_time'		=> $LNG['log_time'],
		'log_uni'		=> $LNG['log_uni_short'],
		'log_target'	=> $LNG['log_target_user'],
		'log_id'		=> $LNG['log_id'],
		'log_view'		=> $LNG['log_view'],
	));
	$template->show("LogList.tpl");
}

function ShowLogPresent() {
	global $LNG;

	$result    = $GLOBALS['DATABASE']->query("SELECT DISTINCT l.id, l.admin, l.target, l.time, l.universe, u_a.username as admin_username FROM ".LOG." as l LEFT JOIN ".USERS." as u_a ON u_a.id = l.admin WHERE mode = 4 ORDER BY l.id DESC;");

	$template	= new template();	
	if(!$result)
		$template->message($LNG['log_no_data']);
		
	while ($LogRow = $GLOBALS['DATABASE']->fetch_array($result))
	{			
		$LogArray[]	= array(
			'id'		=> $LogRow['id'],
			'admin'		=> $LogRow['admin_username'],
			'target_uni'=> $LogRow['universe'],
			'target'	=> $LNG['fcm_universe'],
			'time'		=> _date($LNG['php_tdformat'], $LogRow['time'], $USER['timezone']),
		);
	}
	$GLOBALS['DATABASE']->free_result($result);
	$template->assign_vars(array(	
		'LogArray'		=> $LogArray,
		'log_log'		=> $LNG['log_log'],
		'log_admin'		=> $LNG['log_admin'],
		'log_time'		=> $LNG['log_time'],
		'log_uni'		=> $LNG['log_uni_short'],
		'log_target'	=> $LNG['log_target_user'],
		'log_id'		=> $LNG['log_id'],
		'log_view'		=> $LNG['log_view'],
	));
	$template->show("LogList.tpl");
}