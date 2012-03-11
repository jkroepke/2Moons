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
 
if(!defined('IN_ADMIN') || !defined('IN_CRON'))
	define("STARTTIME",	microtime(true));

define("BETA", 0);

if (isset($_POST['GLOBALS']) || isset($_GET['GLOBALS'])) {
	exit('You cannot set the GLOBALS-array from outside the script.');
}

// Magic Quotes work around.
if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc() == 1) {
	foreach($_GET as $k => $v) $_GET[$k] = stripslashes($v);
	foreach($_POST as $k => $v) $_POST[$k] = stripslashes($v);
	foreach($_COOKIE as $k => $v) $_COOKIE[$k] = stripslashes($v);
	
    $_REQUEST	= array_merge($_GET, $_POST);
}

if (function_exists('mb_internal_encoding')) {
	mb_internal_encoding("UTF-8");
}

ignore_user_abort(true);
error_reporting(E_ALL & ~E_STRICT);
ini_set('display_errors', 1);
header('Content-Type: text/html; charset=UTF-8');
define('TIMESTAMP',	time());

require_once(ROOT_PATH . 'includes/config.php');	
require_once(ROOT_PATH . 'includes/constants.php');
require_once(ROOT_PATH . 'includes/dbtables.php');

ini_set('upload_tmp_dir', ROOT_PATH.'cache/');
ini_set('log_errors', 'On');
ini_set('error_log', ROOT_PATH.'includes/error.log');
require_once(ROOT_PATH . 'includes/GeneralFunctions.php');
set_exception_handler('exception_handler');

require_once(ROOT_PATH . 'includes/classes/class.Cache.php');
require_once(ROOT_PATH . 'includes/classes/class.Database.php');
require_once(ROOT_PATH . 'includes/classes/class.Lang.php');
require_once(ROOT_PATH . 'includes/classes/class.theme.php');
require_once(ROOT_PATH . 'includes/classes/class.Session.php');
require_once(ROOT_PATH . 'includes/classes/class.template.php');
require_once(ROOT_PATH . 'includes/classes/HTTP.class.php');

define('AJAX_REQUEST', HTTP::_GP('ajax', 0));

$SESSION	= new Session();
$DATABASE	= new Database();
$THEME		= new Theme();	
$LANG		= new Language();
$CACHE		= new Cache();
$CONFIG		= array();

$UNI		= getUniverse();
unset($database);

// Say Browsers to Allow ThirdParty Cookies (Thanks to morktadela)
HTTP::sendHeader('P3P', 'CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');

$CONF	= getConfig($UNI);

$LANG->setDefault($CONF['lang']);

require_once(ROOT_PATH.'includes/vars.php');

if (MODE === 'INGAME' || MODE === 'ADMIN' || MODE === 'CHAT')
{	
	if(!$SESSION->IsUserLogin()) HTTP::redirectTo('index.php?code=3');
	
	$SESSION->UpdateSession();
	
	if(!AJAX_REQUEST && MODE === 'INGAME' && isModulAvalible(MODULE_FLEET_EVENTS)) {
		require(ROOT_PATH.'includes/FleetHandler.php');
	}
		
	$USER	= $GLOBALS['DATABASE']->uniquequery("SELECT 
	user.*, 
	stat.`total_points`, 
	stat.`total_rank`,
	COUNT(message.message_id) as messages
	FROM ".USERS." as user 
	LEFT JOIN ".STATPOINTS." as stat ON stat.id_owner = user.id AND stat.stat_type = '1' 
	LEFT JOIN ".MESSAGES." as message ON message.message_owner = user.id AND message.message_unread = '1'
	WHERE user.`id` = ".$_SESSION['id']."
	GROUP BY message.message_owner;");
	
	if(empty($USER)) {
		exit(header('Location: index.php'));
	}
	
	$LANG->setUser($USER['lang']);	
	$LANG->includeLang(array('L18N', 'INGAME', 'TECH', 'CUSTOM'));
	$THEME->setUserTheme($USER['dpath']);
	
	if($CONF['game_disable'] == 0 && $USER['authlevel'] == AUTH_USR) {
		ShowErrorPage::printError($LNG['sys_closed_game'].'<br><br>'.$CONF['close_reason'], false);
	}

	if($USER['bana'] == 1)
	{
		ShowErrorPage::printError("<font size=\"6px\">".$LNG['css_account_banned_message']."</font><br><br>".sprintf($LNG['css_account_banned_expire'], _date($LNG['php_tdformat'], $USER['banaday'], $USER['timezone']))."<br><br>".$LNG['css_goto_homeside'], false);
	}
	
	if (MODE === 'INGAME')
	{
		require_once(ROOT_PATH . 'includes/classes/class.PlanetRessUpdate.php');
		$PLANET = $GLOBALS['DATABASE']->uniquequery("SELECT * FROM ".PLANETS." WHERE id = ".$_SESSION['planet'].";");

		if(empty($PLANET))
		{
			$PLANET = $GLOBALS['DATABASE']->uniquequery("SELECT * FROM ".PLANETS." WHERE id = ".$USER['id_planet'].";");
			
			if(empty($PLANET))
			{
				throw new Exception("Main Planet does not exist!");
			}
		}
		
		$USER['factor']		= getFactors($USER);
		$USER['PLANETS']	= getPlanets($USER);
	} else {
		error_reporting(E_ALL ^ E_NOTICE);
		
		$USER['rights']		= unserialize($USER['rights']);
		$LANG->includeLang(array('ADMIN'));
	}
}
	
?>