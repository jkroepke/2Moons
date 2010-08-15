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
set_time_limit(120);
error_reporting(E_ALL ^ E_NOTICE);
ini_set('zlib.output_compression', 'On');
ini_set('display_errors', 1);
date_default_timezone_set("Europe/Berlin");
header('Content-Type: text/html; charset=UTF-8');
define('TIMESTAMP',	$_SERVER['REQUEST_TIME']);

if(file_exists(ROOT_PATH . 'config.php'))
	require_once(ROOT_PATH . 'config.'.PHP_EXT);
	
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
ini_set('session.gc_divisor',  '1000');
	
if(!defined('LOGIN'))
	session_start();
	
if(!function_exists('bcadd'))
	require_once(ROOT_PATH.'includes/bcmath.'.PHP_EXT);

require_once(ROOT_PATH . 'includes/classes/class.MySQLi.'.PHP_EXT);
require_once(ROOT_PATH . 'includes/GeneralFunctions.'.PHP_EXT);
require_once(ROOT_PATH . 'includes/vars.'.PHP_EXT);
set_error_handler('msg_handler', E_ALL);
set_exception_handler('exception_handler');

if($database)
	$db = new DB_MySQLi();
elseif(INSTALL != true)
	redirectTo("install/");

unset($database);

if (INSTALL != true)
{
	require_once(ROOT_PATH.'includes/functions/GetBuildingTime.'.PHP_EXT);
	require_once(ROOT_PATH.'includes/functions/SortUserPlanets.'.PHP_EXT);
	
	$cfgresult = $db->query("SELECT HIGH_PRIORITY * FROM `".CONFIG."`;");

	while ($row = $db->fetch_array($cfgresult))
	{
		$CONF[$row['config_name']] = $row['config_value'];
	}
	$db->free_result($cfgresult);
	
	$CONF['moduls']		= explode(";", $CONF['moduls']);
	$CONF['alllangs']	= GetLangs();
	define('VERSION'		, $CONF['VERSION']);
	if (!defined('LOGIN') && !defined('IN_CRON'))
	{
		require_once(ROOT_PATH . 'includes/classes/class.CheckSession.'.PHP_EXT);

		$Session       	= new CheckSession();
		if(!$Session->CheckUser()) exit(header('Location: index.php'));
	
		$Session		= NULL;	
		unset($Session);
		
		if($CONF['game_disable'] == 0 && $_SESSION['authlevel'] == 0)
		{
			trigger_error($CONF['close_reason'], E_USER_NOTICE);
		}
		
		if(request_var('ajax', 0) == 0 /*&& $CONF['stats_fly_lock'] == 0*/ && !defined('IN_ADMIN'))
		{	
			update_config('stats_fly_lock', TIMESTAMP);
			$db->query("LOCK TABLE ".AKS." WRITE, ".RW." WRITE, ".MESSAGES." WRITE, ".FLEETS." WRITE, ".PLANETS." WRITE, ".PLANETS." as p WRITE, ".TOPKB." WRITE, ".USERS." WRITE, ".USERS." as u WRITE, ".STATPOINTS." WRITE;");
			
			$FLEET = $db->query("SELECT * FROM ".FLEETS." WHERE (`fleet_start_time` <= '". TIMESTAMP ."' AND `fleet_mess` = '0') OR (`fleet_end_time` <= '". TIMESTAMP ."' AND `fleet_mess` = '1') OR (`fleet_end_stay` <= '". TIMESTAMP ."' AND `fleet_mess` = '2') ORDER BY `fleet_start_time` ASC;");
			if($db->num_rows($FLEET) > 0)
			{
				require_once(ROOT_PATH . 'includes/classes/class.FlyingFleetHandler.'.PHP_EXT);
			
				new FlyingFleetHandler($FLEET);
			}
			$db->free_result($FLEET);
			$db->query("UNLOCK TABLES");  
			update_config('stats_fly_lock', 0);
		}
		elseif (TIMESTAMP >= ($CONF['stats_fly_lock'] + (60 * 5))){
			update_config('stats_fly_lock', 0);
		}
				
		$USER	= $db->uniquequery("SELECT u.*, s.`total_rank`, s.`total_points` FROM ".USERS." as u LEFT JOIN ".STATPOINTS." as s ON s.`id_owner` = u.`id` AND s.`stat_type` = '1' WHERE u.`id` = '".$_SESSION['id']."';");
		if(empty($USER)) {
			exit(header('Location: index.php'));
		} elseif(empty($USER['lang'])) {
			$USER['lang']	= $CONF['lang'];
			$db->query("UPDATE ".USERS." SET `lang` ='".$USER['lang']."' WHERE `id` = '".$USER['id']."';");
		}
		
		define('DEFAULT_LANG', $USER['lang']);
		includeLang('INGAME');
		includeLang('TECH');
		
		if($USER['bana'] == 1)
		{
			require_once(ROOT_PATH . 'includes/classes/class.template.'.PHP_EXT);
			$template	= new template();
			$template->message("<font size=\"6px\">".$LNG['css_account_banned_message']."</font><br><br>".sprintf($LNG['css_account_banned_expire'],date("d. M y H:i", $USER['banaday']))."<br><br>".$LNG['css_goto_homeside'], false, 0, true);
			exit;
		}
			
		if (!defined('IN_ADMIN'))
		{
			require_once(ROOT_PATH . 'includes/classes/class.PlanetRessUpdate.'.PHP_EXT);
			$PLANET = $db->uniquequery("SELECT * FROM `".PLANETS."` WHERE `id` = '".$USER['current_planet']."';");

			if(empty($PLANET)){
				$PLANET = $db->uniquequery("SELECT * FROM `".PLANETS."` WHERE `id` = '".$USER['id_planet']."';");
				
				if(empty($PLANET)){
					throw new Exception("Main Planet does not exist!");
				}
			}
				
			require_once(ROOT_PATH.'includes/functions/CheckPlanetUsedFields.' . PHP_EXT);
			CheckPlanetUsedFields($PLANET);
		} else {
			includeLang('ADMIN');
		}
		
		require_once(ROOT_PATH.'includes/classes/class.template.'.PHP_EXT);
	} else {
		//Login
		define('DEFAULT_LANG'	, (!empty($_REQUEST['lang'])) ? $_REQUEST['lang'] : $CONF['lang']);
		includeLang('INGAME');
		require_once(ROOT_PATH.'includes/classes/class.template.'.PHP_EXT);
	}
}
else
{
	require_once(ROOT_PATH.'includes/classes/class.template.'.PHP_EXT);
}

?>