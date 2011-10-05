<?php

/**
 *  2Moons
 *  Copyright (C) 2011  Slaver
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
 * @author Slaver <slaver7@gmail.com>
 * @copyright 2009 Lucky <lucky@xgproyect.net> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.4 (2011-07-10)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) exit;

function ShowConfigBasicPage()
{
	global $CONF, $LNG, $USER, $LANG, $db;
	if (!empty($_POST))
	{

		$config_before = array(
			'ttf_file'				=> $CONF['ttf_file'],
			'game_name'				=> $CONF['game_name'],
			'mail_active'			=> $CONF['mail_active'],
			'mail_use'				=> $CONF['mail_use'],
			'smail_path'			=> $CONF['smail_path'],
			'smtp_host'				=> $CONF['smtp_host'],
			'smtp_port'				=> $CONF['smtp_port'],
			'smtp_user'				=> $CONF['smtp_user'],
			'smtp_pass'				=> $CONF['smtp_pass'],
			'smtp_ssl'				=> $CONF['smtp_ssl'],
			'smtp_sendmail'			=> $CONF['smtp_sendmail'],
			'ga_active'				=> $CONF['ga_active'],
			'ga_key'				=> $CONF['ga_key'],
			'capaktiv'				=> $CONF['capaktiv'],
			'cappublic'				=> $CONF['cappublic'],
			'capprivate'			=> $CONF['capprivate'],
			'del_oldstuff'			=> $CONF['del_oldstuff'],
			'del_user_manually'		=> $CONF['del_user_manually'],
			'del_user_automatic'	=> $CONF['del_user_automatic'],
			'del_user_sendmail'		=> $CONF['del_user_sendmail'],
			'sendmail_inactive'		=> $CONF['sendmail_inactive'],
			'timezone'				=> $CONF['timezone'],
			'dst'					=> $CONF['dst'],
		);
		
		$CONF['capaktiv'] 				= isset($_POST['capaktiv']) && $_POST['capaktiv'] == 'on' ? 1 : 0;
		$CONF['ga_active'] 				= isset($_POST['ga_active']) && $_POST['ga_active'] == 'on' ? 1 : 0;
		$CONF['sendmail_inactive'] 		= isset($_POST['sendmail_inactive']) && $_POST['sendmail_inactive'] == 'on' ? 1 : 0;
		$CONF['mail_active'] 			= isset($_POST['mail_active']) && $_POST['mail_active'] == 'on' ? 1 : 0;
		
		$CONF['OverviewNewsText']		= $_POST['NewsText'];
		$CONF['close_reason']			= request_var('close_reason', '', true);
		$CONF['game_name']				= request_var('game_name', '', true);
		$CONF['capprivate']				= request_var('capprivate', '');
		$CONF['cappublic']				= request_var('cappublic', '');
		$CONF['ga_key']					= request_var('ga_key', '', true);
		$CONF['mail_use']				= request_var('mail_use', 0);
		$CONF['smail_path']				= request_var('smail_path', '');
		$CONF['smtp_host']				= request_var('smtp_host', '', true);
		$CONF['smtp_port']				= request_var('smtp_port', 0);
		$CONF['smtp_user']				= request_var('smtp_user', '', true);
		$CONF['smtp_sendmail']			= request_var('smtp_sendmail', '', true);
		$CONF['smtp_pass']				= request_var('smtp_pass', '', true);
		$CONF['smtp_ssl']				= request_var('smtp_ssl', '');
		$CONF['del_oldstuff']			= request_var('del_oldstuff', 0);
		$CONF['del_user_manually']		= request_var('del_user_manually', 0);
		$CONF['del_user_automatic']		= request_var('del_user_automatic', 0);
		$CONF['del_user_sendmail']		= request_var('del_user_sendmail', 0);
		$CONF['timezone']				= request_var('timezone', 0.0);
		$CONF['dst']					= request_var('dst', 0);
		
		$config_after = array(
			'ttf_file'				=> $CONF['ttf_file'],
			'game_name'				=> $CONF['game_name'],
			'mail_active'			=> $CONF['mail_active'],
			'mail_use'				=> $CONF['mail_use'],
			'smail_path'			=> $CONF['smail_path'],
			'smtp_host'				=> $CONF['smtp_host'],
			'smtp_port'				=> $CONF['smtp_port'],
			'smtp_user'				=> $CONF['smtp_user'],
			'smtp_pass'				=> $CONF['smtp_pass'],
			'smtp_ssl'				=> $CONF['smtp_ssl'],
			'smtp_sendmail'			=> $CONF['smtp_sendmail'],
			'ga_active'				=> $CONF['ga_active'],
			'ga_key'				=> $CONF['ga_key'],
			'capaktiv'				=> $CONF['capaktiv'],
			'cappublic'				=> $CONF['cappublic'],
			'capprivate'			=> $CONF['capprivate'],
			'del_oldstuff'			=> $CONF['del_oldstuff'],
			'del_user_manually'		=> $CONF['del_user_manually'],
			'del_user_automatic'	=> $CONF['del_user_automatic'],
			'del_user_sendmail'		=> $CONF['del_user_sendmail'],
			'sendmail_inactive'		=> $CONF['sendmail_inactive'],
			'timezone'				=> $CONF['timezone'],
			'dst'					=> $CONF['dst'],
		);
		
		update_config($config_after);
		
		$LOG = new Log(3);
		$LOG->target = 0;
		$LOG->old = $config_before;
		$LOG->new = $config_after;
		$LOG->save();

	}
	
	$TimeZones		= tz_getlist();
	
	$template	= new template();
	
	$template->assign_vars(array(
		'del_oldstuff'					=> $CONF['del_oldstuff'],
		'del_user_manually'				=> $CONF['del_user_manually'],
		'del_user_automatic'			=> $CONF['del_user_automatic'],
		'del_user_sendmail'				=> $CONF['del_user_sendmail'],
		'sendmail_inactive'				=> $CONF['sendmail_inactive'],
		'ttf_file'						=> $CONF['ttf_file'],
		'game_name'						=> $CONF['game_name'],
		'mail_active'					=> $CONF['mail_active'],
		'mail_use'						=> $CONF['mail_use'],
		'smail_path'					=> $CONF['smail_path'],
		'smtp_host' 					=> $CONF['smtp_host'],
		'smtp_port' 					=> $CONF['smtp_port'],
		'smtp_user' 					=> $CONF['smtp_user'],
		'smtp_pass' 					=> $CONF['smtp_pass'],
		'smtp_sendmail' 				=> $CONF['smtp_sendmail'],
		'smtp_ssl'						=> $CONF['smtp_ssl'],
		'capprivate' 					=> $CONF['capprivate'],
		'cappublic' 	   				=> $CONF['cappublic'],
		'capaktiv'      	           	=> $CONF['capaktiv'],
        'ga_active'               		=> $CONF['ga_active'],
		'ga_key'           				=> $CONF['ga_key'],
		'timezone'           			=> $CONF['timezone'],
		'dst'           				=> $CONF['dst'],
		'Selector'						=> array('timezone_val' => $TimeZones, 'timezone_opt' => $LNG['timezones'], 'dst' => $LNG['se_dst_sel'], 'mail' => $LNG['se_mail_sel'], 'encry' => array('' => $LNG['se_smtp_ssl_1'], 'ssl' => $LNG['se_smtp_ssl_2'], 'tls' => $LNG['se_smtp_ssl_3'])),
	));
	
	$template->show('adm/ConfigBasicBody.tpl');
}

?>