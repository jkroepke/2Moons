<?php

/**
 *  2Moons 
 *   by Jan-Otto Kröpke 2009-2016
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan-Otto Kröpke <slaver7@gmail.com>
 * @copyright 2009 Lucky
 * @copyright 2016 Jan-Otto Kröpke <slaver7@gmail.com>
 * @licence MIT
 * @version 1.8.0
 * @link https://github.com/jkroepke/2Moons
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

    $sql	= "SELECT dbVersion FROM %%SYSTEM%%;";

    $dbVersion	= Database::get()->selectSingle($sql, array(), 'dbVersion');

	$template	= new template();
	$template->assign_vars(array(
		'info_information'	=> sprintf($LNG['info_information'], 'https://github.com/jkroepke/2Moons/issues'),
		'info'				=> $_SERVER['SERVER_SOFTWARE'],
		'vPHP'				=> PHP_VERSION,
		'vAPI'				=> PHP_SAPI,
		'vGame'				=> $config->VERSION.(file_exists(ROOT_PATH.'/.git/ORIG_HEAD') ? ' ('.trim(file_get_contents(ROOT_PATH.'/.git/ORIG_HEAD')).')': ''),
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
        'dbVersion'         => $dbVersion,
		'php_tz'			=> $dateTimePHP->getOffset() / 3600,
		'conf_tz'			=> $dateTimeServer->getOffset() / 3600,
		'user_tz'			=> $dateTimeUser->getOffset() / 3600,
	));

	$template->show('ShowInformationPage.tpl');
}
