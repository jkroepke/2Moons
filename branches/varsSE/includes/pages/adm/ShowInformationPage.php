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
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.8.0 (2013-03-18)
 * @info $Id$
 * @link http://2moons.cc/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) throw new Exception("Permission error!");

function ShowInformationPage()
{
	global $LNG, $USER;

	$config = Config::get();

	// @ for open_basedir
	if(@file_exists(ini_get('error_log')))
		$Lines	= count(file(ini_get('error_log')));
	else
		$Lines	= 0;
	
	try {
		$dateTimeZoneServer = new DateTimeZone($config->timezone);
	} catch (Exception $e) {
		$dateTimeZoneServer	= new DateTimeZone(date_default_timezone_get());
	}
	
	try {
		$dateTimeZoneUser	= new DateTimeZone($USER['timezone']);
	} catch (Exception $e) {
		$dateTimeZoneUser	= new DateTimeZone(date_default_timezone_get());
	}
	
	try {
		$dateTimeZonePHP	= new DateTimeZone(ini_get('date.timezone'));
	} catch (Exception $e) {
		$dateTimeZonePHP	= new DateTimeZone(date_default_timezone_get());
	}
	
	$dateTimeServer		= new DateTime("now", $dateTimeZoneServer);
	$dateTimeUser		= new DateTime("now", $dateTimeZoneUser);
	$dateTimePHP		= new DateTime("now", $dateTimeZonePHP);
	
	$template	= new Template();
	$template->assign_vars(array(
		'info_information'	=> sprintf($LNG['info_information'], 'http://tracker.2moons.cc/'),
		'info'				=> $_SERVER['SERVER_SOFTWARE'],
		'vPHP'				=> PHP_VERSION,
		'vAPI'				=> PHP_SAPI,
		'vGame'				=> $config->VERSION,
		'vMySQLc'			=> $GLOBALS['DATABASE']->getVersion(),
		'vMySQLs'			=> $GLOBALS['DATABASE']->getServerVersion(),
		'root'				=> $_SERVER['SERVER_NAME'],
		'gameroot'			=> $_SERVER['SERVER_NAME'].str_replace('/admin.php', '', $_SERVER['PHP_SELF']),
		'json'				=> function_exists('json_encode') ? 'Ja' : 'Nein',
		'bcmath'			=> extension_loaded('bcmath') ? 'Ja' : 'Nein',
		'curl'				=> extension_loaded('curl') ? 'Ja' : 'Nein',
		'browser'			=> $_SERVER['HTTP_USER_AGENT'],
		'safemode'			=> ini_get('safe_mode') ? 'Ja' : 'Nein',
		'memory'			=> ini_get('memory_limit'),
		'suhosin'			=> ini_get('suhosin.request.max_value_length') ? 'Ja' : 'Nein',
		'log_errors'		=> ini_get('log_errors') ? 'Aktiv' : 'Inaktiv',
		'errorlog'			=> ini_get('error_log'),
		'errorloglines'		=> $Lines,
		'php_tz'			=> $dateTimePHP->getOffset() / 3600,
		'conf_tz'			=> $dateTimeServer->getOffset() / 3600,
		'user_tz'			=> $dateTimeUser->getOffset() / 3600,
	));

	$template->show('ShowInformationPage.tpl');
}
