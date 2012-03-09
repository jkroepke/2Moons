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

ignore_user_abort(true);
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', 1);
header('Content-Type: text/html; charset=UTF-8');
define('TIMESTAMP',	$_SERVER['REQUEST_TIME']);

require_once(ROOT_PATH . 'includes/config.php');	
require_once(ROOT_PATH . 'includes/constants.php');
require_once(ROOT_PATH . 'includes/dbtables.php');

ini_set('upload_tmp_dir', ROOT_PATH.'cache/');
ini_set('error_log', ROOT_PATH.'includes/error.log');
require_once(ROOT_PATH . 'includes/GeneralFunctions.php');
set_exception_handler('exception_handler');

require_once(ROOT_PATH . 'includes/classes/class.MySQLi.php');
require_once(ROOT_PATH . 'includes/classes/class.Lang.php');
require_once(ROOT_PATH . 'includes/classes/class.theme.php');
require_once(ROOT_PATH . 'includes/classes/class.Session.php');
	
$db 		= new Database();
$THEME		= new Theme();	
$LANG		= new Language();
$SESSION	= new Session();
$CONFIG		= array();

$UNI	= getUniverse();
unset($database);

// Say Browsers to Allow ThirdParty Cookies (Thanks to morktadela)
header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');

if(UNIS_MULTIVARS)
	require_once(ROOT_PATH.'includes/vars_uni'.$UNI.'.php');
else
	require_once(ROOT_PATH.'includes/vars.php');
	
$CONF	= getConfig($UNI);
$LANG->setDefault($CONF['lang']);
require(ROOT_PATH.'includes/libs/FirePHP/FirePHP.class.php');
require(ROOT_PATH.'includes/libs/FirePHP/fb.php');
$FirePHP	= FirePHP::getInstance(true);
$FirePHP->setEnabled((bool) $GLOBALS['CONF']['debug']);
if($GLOBALS['CONF']['debug']) {
	ob_start();
	$FirePHP->registerErrorHandler(true);
}

if (!defined('LOGIN') && !defined('IN_CRON') && !defined('ROOT'))
{	
	if(!$SESSION->IsUserLogin()) redirectTo('index.php?code=3');
	
	$SESSION->UpdateSession();
	
	if($CONF['game_disable'] == 0 && $_SESSION['authlevel'] == AUTH_USR) {
		message($CONF['close_reason']);
	}

	if(isModulAvalible(MODUL_FLEET_EVENTS) && !defined('AJAX') && !defined('IN_ADMIN') && request_var('ajax', 0) == 0) {
		require(ROOT_PATH.'includes/FleetHandler.php');
	}
		
	$USER	= $db->uniquequery("SELECT 
	user.*, 
	stat.`total_points`, 
	stat.`total_rank`,
	COUNT(message.message_id) as messages
	FROM ".USERS." as user 
	LEFT JOIN ".STATPOINTS." as stat ON stat.id_owner = user.id AND stat.stat_type = '1' 
	LEFT JOIN ".MESSAGES." as message ON message.message_owner = user.id AND message.message_unread = '1'
	WHERE user.`id` = ".$_SESSION['id']."
	GROUP BY message.message_id;");
	
	$FirePHP->log("Load User: ".$USER['id']);
	if(empty($USER)) {
		exit(header('Location: index.php'));
	} elseif(empty($USER['lang'])) {
		$USER['lang']	= $CONF['lang'];
		$db->query("UPDATE ".USERS." SET `lang` = '".$USER['lang']."' WHERE `id` = '".$USER['id']."';");
		$FirePHP->log("Load User: ".$USER['id']);
	}
	
	$LANG->setUser($USER['lang']);	
	$LANG->includeLang(array('L18N', 'INGAME', 'TECH', 'CUSTOM'));
	$THEME->setUserTheme($USER['dpath']);
	if($USER['bana'] == 1)
	{
		message("<font size=\"6px\">".$LNG['css_account_banned_message']."</font><br><br>".sprintf($LNG['css_account_banned_expire'],date("d. M y H:i", $USER['banaday']))."<br><br>".$LNG['css_goto_homeside']);
		exit;
	}
	
	if (!defined('IN_ADMIN'))
	{
		require_once(ROOT_PATH . 'includes/classes/class.PlanetRessUpdate.php');
		$PLANET = $db->uniquequery("SELECT * FROM `".PLANETS."` WHERE `id` = '".$_SESSION['planet']."';");

		if(empty($PLANET)){
			$PLANET = $db->uniquequery("SELECT * FROM `".PLANETS."` WHERE `id` = '".$USER['id_planet']."';");
			
			if(empty($PLANET)){
				throw new Exception("Main Planet does not exist!");
			}
		}
		$USER['factor']		= getFactors($USER);
		$USER['PLANETS']	= getPlanets($USER);
		$FirePHP->log("Load Planet: ".$PLANET['id']);
	} else {
		$USER['rights']	= unserialize($USER['rights']);
		$LANG->includeLang(array('ADMIN'));
		error_reporting(E_ALL ^ E_NOTICE);
	}
} elseif(defined('LOGIN')) {
	//Login
	$LANG->GetLangFromBrowser();
	$LANG->includeLang(array('INGAME', 'PUBLIC'));
}

if (!defined('AJAX') && !defined('CLI'))
	require_once(ROOT_PATH.'includes/classes/class.template.php');
	
?>