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
			'sendmail_inactive'		=> $CONF['sendmail_inactive']
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
			'sendmail_inactive'		=> $CONF['sendmail_inactive']
		);
		
		update_config($config_after);
		
		$LOG = new Log(3);
		$LOG->target = 0;
		$LOG->old = $config_before;
		$LOG->new = $config_after;
		$LOG->save();

	}
	
	$template	= new template();

	$template->assign_vars(array(
		'se_game_name'					=> $LNG['se_game_name'],
		'se_server_parameters'			=> $LNG['se_server_parameters'],
		'se_recaptcha_head'				=> $LNG['se_recaptcha_head'],
		'se_recaptcha_active'			=> $LNG['se_recaptcha_active'],
		'se_recaptcha_desc'				=> $LNG['se_recaptcha_desc'],
		'se_recaptcha_public'			=> $LNG['se_recaptcha_public'],
		'se_recaptcha_private'			=> $LNG['se_recaptcha_private'],
		'se_smtp'						=> $LNG['se_smtp'],
		'se_ttf_file'					=> $LNG['se_ttf_file'],
		'se_ttf_file_info'				=> $LNG['se_ttf_file_info'],
		'se_mail_active'				=> $LNG['se_mail_active'],
		'se_mail_use'					=> $LNG['se_mail_use'],
		'se_smail_path'					=> $LNG['se_smail_path'],
		'se_smtp_info'					=> $LNG['se_smtp_info'],
		'se_smtp_host'					=> $LNG['se_smtp_host'],
		'se_smtp_host_info'				=> $LNG['se_smtp_host_info'],
		'se_smtp_ssl'					=> $LNG['se_smtp_ssl'],
		'se_smtp_ssl_info'				=> $LNG['se_smtp_ssl_info'],
		'se_smtp_port'					=> $LNG['se_smtp_port'],
		'se_smtp_port_info'				=> $LNG['se_smtp_port_info'],
		'se_smtp_user'					=> $LNG['se_smtp_user'],
		'se_smtp_pass'					=> $LNG['se_smtp_pass'],
		'se_smtp_sendmail'				=> $LNG['se_smtp_sendmail'],
		'se_smtp_sendmail_info'			=> $LNG['se_smtp_sendmail_info'],
		'se_google'						=> $LNG['se_google'],
		'se_google_active'				=> $LNG['se_google_active'],
		'se_google_info'				=> $LNG['se_google_info'],
		'se_google_key'					=> $LNG['se_google_key'],
		'se_google_key_info'			=> $LNG['se_google_key_info'],
		'se_save_parameters'			=> $LNG['se_save_parameters'],
		'se_ttf_file'					=> $LNG['se_ttf_file'],
		'se_ttf_file_info'				=> $LNG['se_ttf_file_info'],
		'se_player_settings'			=> $LNG['se_player_settings'],
		'se_del_oldstuff'				=> $LNG['se_del_oldstuff'],
		'se_del_oldstuff_info'			=> $LNG['se_del_oldstuff_info'],
		'se_del_user_manually'			=> $LNG['se_del_user_manually'],
		'se_del_user_manually_info'		=> $LNG['se_del_user_manually_info'],
		'se_del_user_automatic'			=> $LNG['se_del_user_automatic'],
		'se_del_user_automatic_info'	=> $LNG['se_del_user_automatic_info'],
		'se_del_user_sendmail'			=> $LNG['se_del_user_sendmail'],
		'se_del_user_sendmail_info'		=> $LNG['se_del_user_sendmail_info'],
		'se_sendmail_inactive'			=> $LNG['se_sendmail_inactive'],
		'se_days'						=> $LNG['se_days'],
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
		'Selector'						=> array('mail' => $LNG['se_mail_sel'], 'encry' => array('' => $LNG['se_smtp_ssl_1'], 'ssl' => $LNG['se_smtp_ssl_2'], 'tls' => $LNG['se_smtp_ssl_3'])),
	));
	
	$template->show('adm/ConfigBasicBody.tpl');
}

?>