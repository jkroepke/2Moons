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

function printIni($a = array()) {
    if (count($a)== 0)
	    return;
	
	$r		= "";
	foreach($a as $key)
	{	
		$r .= $key.": ".ini_get($key)."\r\n";
    }
    return $r;
}


function ShowInformationPage()
{
	global $db, $LNG, $CONF;

	$i = array(
		'asp_tags',
		'auto_append_file',
		'auto_prepend_file',
		'disable_classes',
		'disable_functions',
		'display_errors',
		'error_log',
		'include_path',
		'log_errors',
		'magic_quotes_gpc',
		'magic_quotes_runtime',
		'magic_quotes_sybase',
		'open_basedir',
		'post_max_size',
		'register_argc_argv',
		'register_globals',
		'register_long_arrays',
		'safe_mode',
		'short_open_tag',
		'SMTP',
		'suhosin.request.max_value_length',
		'smtp_port',
		'upload_max_filesize',
		'upload_tmp_dir',
		'user_ini.filename',
		'date.timezone',
	);
	
	$s = array(
		'session.bug_compat_42',
		'session.bug_compat_warn',
		'session.cookie_path',
		'session.save_path',
		'session.use_cookies',
		'session.use_only_cookies',
		'session.use_trans_sid',
	);

	$DATA .= sprintf(
'Core:
%s
Session:
%s',
	printIni($i),
	printIni($s));

	$template	= new template();
	$template->assign_vars(array(
		'info_information'	=> sprintf($LNG['info_information'], 'http://2moons.cc/index.php?page=Board&boardID=5'),
		'info'				=> $_SERVER['SERVER_SOFTWARE'],
		'vPHP'				=> PHP_VERSION,
		'vAPI'				=> PHP_SAPI,
		'vGame'				=> $CONF['VERSION'],
		'vMySQLc'			=> $db->getVersion(),
		'vMySQLs'			=> $db->getServerVersion(),
		'root'				=> $_SERVER['SERVER_NAME'],
		'gameroot'			=> $_SERVER['SERVER_NAME'].str_replace('/admin.php', '', $_SERVER['PHP_SELF']),
		'json'				=> function_exists('json_encode') ? 'Ja' : 'Nein',
		'bcmath'			=> extension_loaded('bcmath') ? 'Ja' : 'Nein',
		'curl'				=> extension_loaded('curl') ? 'Ja' : 'Nein',
		'browser'			=> $_SERVER['HTTP_USER_AGENT'],
		'safemode'			=> ini_get('safe_mode') ? 'Ja' : 'Nein',
		'memory'			=> ini_get('memory_limit'),
		'DATA'				=> $DATA
	));

	$template->show('adm/ShowInformationPage.tpl');
}

?>