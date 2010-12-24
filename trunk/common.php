<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
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

if(!defined('INSTALL') || !defined('IN_ADMIN') || !defined('IN_CRON'))
	define("STARTTIME",	microtime(true));

ignore_user_abort(true);
error_reporting(E_ALL ^ E_NOTICE);
ini_set('zlib.output_compression', 'On');
ini_set('display_errors', 1);
date_default_timezone_set("Europe/Berlin");
header('Content-Type: text/html; charset=UTF-8');
define('TIMESTAMP',	$_SERVER['REQUEST_TIME']);

if(file_exists(ROOT_PATH . 'includes/config.php'))
	require_once(ROOT_PATH . 'includes/config.'.PHP_EXT);
	
require_once(ROOT_PATH . 'includes/constants.'.PHP_EXT);

ini_set('session.save_path', ROOT_PATH.'cache/sessions');
ini_set('upload_tmp_dir', ROOT_PATH.'cache/sessions');
ini_set('session.use_cookies', '1');
ini_set('session.use_only_cookies', '1');
session_set_cookie_params(SESSION_LIFETIME, '/');
session_cache_limiter('nocache');
session_name($dbsettings["secretword"]);
ini_set('session.use_trans_sid', 0);
ini_set('session.auto_start', '0');
ini_set('session.serialize_handler', 'php');  
ini_set('session.gc_maxlifetime', SESSION_LIFETIME);
ini_set('session.gc_probability', '1');
ini_set('session.gc_divisor', '1000');
ini_set('session.bug_compat_warn', '0');
ini_set('session.bug_compat_42', '0');
ini_set('session.cookie_httponly', true);
ini_set('magic_quotes_runtime', 0);
ini_set('error_log', ROOT_PATH.'/includes/error.log');

if(!defined('LOGIN') && INSTALL == false)
	session_start();
	
require_once(ROOT_PATH . 'includes/classes/class.MySQLi.'.PHP_EXT);
require_once(ROOT_PATH . 'includes/classes/class.Lang.'.PHP_EXT);
require_once(ROOT_PATH . 'includes/classes/class.Session.'.PHP_EXT);
require_once(ROOT_PATH . 'includes/GeneralFunctions.'.PHP_EXT);
require_once(ROOT_PATH . 'includes/vars.'.PHP_EXT);
set_exception_handler('exception_handler');

if($database)
	$db = new DB_MySQLi();
elseif(INSTALL != true)
	redirectTo("install/");

$LANG	= new Language();	
$BCMATH	= function_exists('bcadd');
unset($database);

if (INSTALL != true)
{
	if(defined('IN_ADMIN') && isset($_SESSION['adminuni'])) {
		$UNI = $_SESSION['adminuni'];
	} elseif(!isset($_SESSION['uni'])) {
		if(UNIS_WILDCAST) {
			$UNI	= explode('.', $_SERVER['HTTP_HOST']);
			$UNI	= substr($UNI[0], 3);
			if(!is_numeric($UNI))
				$UNI	= 1;
		} else {
			$UNI	= 1;
		}
	} else {
		$UNI	= $_SESSION['uni'];
	}	
	
	$CONF = $db->uniquequery("SELECT HIGH_PRIORITY * FROM `".CONFIG."` WHERE `uni` = '".$UNI."';");
	$CONF['moduls']		= explode(";", $CONF['moduls']);
	$LANG->setDefault($CONF['lang']);
		
	define('VERSION'		, $CONF['VERSION']);
	if (!defined('LOGIN') && !defined('IN_CRON') && !defined('AJAX'))
	{
		$SESSION       	= new Session();
		
		if(!$SESSION->IsUserLogin()) redirectTo('index.php?code=3');
		
		$SESSION->UpdateSession();
		
		if($CONF['game_disable'] == 0 && $_SESSION['authlevel'] == 0)
		{
			message($CONF['close_reason']);
		}
		if(request_var('ajax', 0) == 0 && !defined('IN_ADMIN'))
		{	
			update_config(array('stats_fly_lock' => TIMESTAMP), true);
			$db->query("LOCK TABLE ".AKS." WRITE, ".RW." WRITE, ".MESSAGES." WRITE, ".FLEETS." WRITE, ".PLANETS." WRITE, ".PLANETS." as p WRITE, ".TOPKB." WRITE, ".USERS." WRITE, ".USERS." as u WRITE, ".STATPOINTS." WRITE;");
			
			$FLEET = $db->query("SELECT * FROM ".FLEETS." WHERE (`fleet_start_time` <= '". TIMESTAMP ."' AND `fleet_mess` = '0') OR (`fleet_end_time` <= '". TIMESTAMP ."' AND `fleet_mess` = '1') OR (`fleet_end_stay` <= '". TIMESTAMP ."' AND `fleet_mess` = '2') ORDER BY `fleet_start_time` ASC;");
			if($db->num_rows($FLEET) > 0)
			{
				require_once(ROOT_PATH . 'includes/classes/class.FlyingFleetHandler.'.PHP_EXT);
			
				new FlyingFleetHandler($FLEET);
			}
			$db->free_result($FLEET);
			$db->query("UNLOCK TABLES");  
			update_config(array('stats_fly_lock' => 0), true);
		} elseif (TIMESTAMP >= ($CONF['stats_fly_lock'] + (60 * 5))) {
			update_config(array('stats_fly_lock' => 0), true);
		}
				
		$USER	= $db->uniquequery("SELECT u.*, s.`total_points`, s.`total_rank` FROM ".USERS." as u LEFT JOIN ".STATPOINTS." as s ON s.`id_owner` = u.`id` AND s.`stat_type` = '1' WHERE u.`id` = '".$_SESSION['id']."';");
		if(empty($USER)) {
			exit(header('Location: index.php'));
		} elseif(empty($USER['lang'])) {
			$USER['lang']	= $CONF['lang'];
			$db->query("UPDATE ".USERS." SET `lang` = '".$USER['lang']."' WHERE `id` = '".$USER['id']."';");
		}
		
		$LANG->setUser($USER['lang']);	
		$LANG->includeLang(array('INGAME', 'TECH'));
		
		if($USER['bana'] == 1)
		{
			message("<font size=\"6px\">".$LNG['css_account_banned_message']."</font><br><br>".sprintf($LNG['css_account_banned_expire'],date("d. M y H:i", $USER['banaday']))."<br><br>".$LNG['css_goto_homeside']);
			exit;
		}
		
		if($_SESSION['authlevel'] != $USER['authlevel']) {
			$db->query("UPDATE ".USERS." SET `authlevel` = '".$_SESSION['authlevel']."' WHERE `id` = ".$USER['id'].";");
			redirectTo('index.php');		
		}
		
		$_SESSION['USER']	= $USER;
		if (!defined('IN_ADMIN'))
		{
			require_once(ROOT_PATH . 'includes/classes/class.PlanetRessUpdate.'.PHP_EXT);
			$PLANET = $db->uniquequery("SELECT * FROM `".PLANETS."` WHERE `id` = '".$_SESSION['planet']."';");

			if(empty($PLANET)){
				$PLANET = $db->uniquequery("SELECT * FROM `".PLANETS."` WHERE `id` = '".$USER['id_planet']."';");
				
				if(empty($PLANET)){
					throw new Exception("Main Planet does not exist!");
				}
			}
			$_SESSION['PLANET']	= $PLANET;
		} else {
			$USER['rights']	= unserialize($USER['rights']);
			$LANG->includeLang(array('ADMIN'));
		}
	} elseif(defined('LOGIN')) {
		//Login
		$LANG->GetLangFromBrowser();
		$LANG->includeLang(array('INGAME', 'PUBLIC'));
	}
}

if (!defined('AJAX'))
	require_once(ROOT_PATH.'includes/classes/class.template.'.PHP_EXT);

?>