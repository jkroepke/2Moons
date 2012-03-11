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
 * @version 1.6.1 (2011-11-19)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) exit;

function ShowConfigBasicPage()
{
	global $CONF, $LNG, $USER, $LANG;
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
		$CONF['ttf_file']				= HTTP::_GP('ttf_file', '');
		$CONF['close_reason']			= HTTP::_GP('close_reason', '', true);
		$CONF['game_name']				= HTTP::_GP('game_name', '', true);
		$CONF['capprivate']				= HTTP::_GP('capprivate', '');
		$CONF['cappublic']				= HTTP::_GP('cappublic', '');
		$CONF['ga_key']					= HTTP::_GP('ga_key', '', true);
		$CONF['mail_use']				= HTTP::_GP('mail_use', 0);
		$CONF['smail_path']				= HTTP::_GP('smail_path', '');
		$CONF['smtp_host']				= HTTP::_GP('smtp_host', '', true);
		$CONF['smtp_port']				= HTTP::_GP('smtp_port', 0);
		$CONF['smtp_user']				= HTTP::_GP('smtp_user', '', true);
		$CONF['smtp_sendmail']			= HTTP::_GP('smtp_sendmail', '', true);
		$CONF['smtp_pass']				= HTTP::_GP('smtp_pass', '', true);
		$CONF['smtp_ssl']				= HTTP::_GP('smtp_ssl', '');
		$CONF['del_oldstuff']			= HTTP::_GP('del_oldstuff', 0);
		$CONF['del_user_manually']		= HTTP::_GP('del_user_manually', 0);
		$CONF['del_user_automatic']		= HTTP::_GP('del_user_automatic', 0);
		$CONF['del_user_sendmail']		= HTTP::_GP('del_user_sendmail', 0);
		$CONF['timezone']				= HTTP::_GP('timezone', '');
		$CONF['dst']					= HTTP::_GP('dst', 0);
		
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
	
	$TimeZones		= get_timezone_selector();
	
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
		'Selector'						=> array('timezone' => $TimeZones, 'mail' => $LNG['se_mail_sel'], 'encry' => array('' => $LNG['se_smtp_ssl_1'], 'ssl' => $LNG['se_smtp_ssl_2'], 'tls' => $LNG['se_smtp_ssl_3'])),
	));
	
	$template->show('ConfigBasicBody.tpl');
}

?>