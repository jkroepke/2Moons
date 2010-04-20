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

@set_time_limit(120);

if (!(function_exists("spl_autoload_register")))
	exit("PHP is missing <a href=\"http://php.net/spl\">Standard PHP Library (SPL)</a> support");


if((!file_exists(ROOT_PATH . 'config.php') || filesize(ROOT_PATH . 'config.php') == 0) && INSTALL != true)
	exit(header("Location:" . ROOT_PATH .  "install/"));


if(!defined('INSTALL') || !defined('IN_ADMIN') || !defined('IN_CRON'))
	define("STARTTIME",	microtime(true));
	
date_default_timezone_set("Europe/Berlin");

error_reporting(E_ALL ^ E_NOTICE);

header('Content-Type: text/html; charset=UTF-8');

$game_config   	= array();
$user          	= array();
$lang          	= array();
$addmenu       	= array();
$IsUserChecked 	= false;

if(file_exists(ROOT_PATH . 'config.php'))
	require_once(ROOT_PATH . 'config.'.PHP_EXT);
	
require_once(ROOT_PATH . 'includes/constants.'.PHP_EXT);
require_once(ROOT_PATH . 'includes/classes/class.MySQLi.'.PHP_EXT);
require_once(ROOT_PATH . 'includes/GeneralFunctions.'.PHP_EXT);
require_once(ROOT_PATH . 'includes/vars.'.PHP_EXT);
isBuggyIe() || ob_start("ob_gzhandler");

set_error_handler('msg_handler', E_ALL);
set_exception_handler('exception_handler');

if(function_exists('ini_set')) {
	ini_set('display_errors', 1);
	ini_set('register_globals', "off");
	ini_set('register_long_arrays', "off");
	#ini_set('precision', 30);
}

if ($database)
	$db = new DB_MySQLi($database["host"], $database["user"], $database["userpw"], $database["databasename"], $database["port"]);

unset($database);

if (INSTALL != true)
{
	if(!is_object($db))
		trigger_error("Fehler mit Dantenbankconnection! config.php angepasst und eingef&uuml;gt?", E_USER_ERROR);
	$funcdir = ROOT_PATH . 'includes/functions/autoload/';
	if ($handle = opendir($funcdir)) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != ".." && $file != ".svn") {
				include_once($funcdir.$file);
			}
		}
		closedir($handle);
	}
	$cfgresult = $db->query("SELECT HIGH_PRIORITY * FROM `".CONFIG."`;");

	while ($row = $db->fetch($cfgresult))
	{
		$game_config[$row['config_name']] = $row['config_value'];
	}
	$db->free_result($cfgresult);
	define('DEFAULT_LANG'	, ($game_config['lang'] 	== '') ? "deutsch" : $game_config['lang']);
	define('VERSION'		, ($game_config['VERSION'] == '') ? "" : "RC".$game_config['VERSION']);

	includeLang('INGAME');
	@setlocale(LC_ALL, $lang['local_info'][0], $lang['local_info'][1], $lang['local_info'][2]);
	$lang['locale'] = localeconv();
	if (!defined('LOGIN') && !defined('IN_CRON'))
	{
		require_once(ROOT_PATH . 'includes/classes/class.CheckSession.'.PHP_EXT);

		$Result        	= new CheckSession();
		$Result			= $Result->CheckUser($IsUserChecked);
		$IsUserChecked 	= $Result['state'];
		$user          	= $Result['record'];
		if (!$IsUserChecked) die(header('Location: '.ROOT_PATH.'index.php'));
		
		if($game_config['game_disable'] == 0 && $user['authlevel'] == 0)
		{
			trigger_error($game_config['close_reason'], E_USER_NOTICE);
		}
		if (isset($user))
		{
			includeLang('TECH');
			
			if(request_var('ajax', 0) == 0 && $game_config['stats_fly_lock'] == 0 && !defined('IN_ADMIN'))
			{	
				update_config('stats_fly_lock', time());
				$db->multi_query("UNLOCK TABLES;LOCK TABLE ".AKS." WRITE, ".RW." WRITE, ".MESSAGES." WRITE, ".FLEETS." WRITE, ".PLANETS." WRITE, ".TOPKB." WRITE, ".USERS." WRITE, ".STATPOINTS." WRITE;");
					
				$fleetquery = $db->query("SELECT * FROM ".FLEETS." WHERE (`fleet_start_time` <= '". time() ."' AND `fleet_mess` = '0') OR (`fleet_end_time` <= '". time() ."' AND `fleet_mess` = '1') OR (`fleet_end_stay` <= '". time() ."' AND `fleet_mess` = '2') ORDER BY `fleet_start_time` ASC;");
				if($db->num_rows($fleetquery) > 0)
				{
					require_once(ROOT_PATH . 'includes/classes/class.FlyingFleetHandler.'.PHP_EXT);
				
					new FlyingFleetHandler($fleetquery);
				}
				$db->query("UNLOCK TABLES");  
				update_config('stats_fly_lock', 0);
			}
			elseif (time() >= ($game_config['stats_fly_lock'] + (60 * 5))){
				update_config('stats_fly_lock', 0);
			}
			
			if (defined('IN_ADMIN'))
			{
				require_once('AdminFunctions/Autorization.' . PHP_EXT);
				includeLang('ADMIN');
				$dpath     = "../". DEFAULT_SKINPATH;			
			}
			else
			{
				require_once(ROOT_PATH . 'includes/classes/class.template.'.PHP_EXT);
				require_once(ROOT_PATH . 'includes/classes/class.PlanetRessUpdate.'.PHP_EXT);
				$dpath     = empty($user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
			}
			
			
			require_once(ROOT_PATH . 'includes/functions/SetSelectedPlanet.' . PHP_EXT);
			SetSelectedPlanet ($user);

			$planetrow = $db->fetch_array($db->query("SELECT p.*, u.`darkmatter`, u.`new_message` FROM `".PLANETS."` as p LEFT JOIN `".USERS."` as u ON u.`id` = p.`id_owner` WHERE p.`id` = '".$user['current_planet']."';"));

			if(empty($planetrow)){
				$db->query("UPDATE ".USERS." SET `current_planet` = `id_planet` WHERE `id` = '". $user['id'] ."' LIMIT 1");
				exit(header("Location: game.php?page=overview"));
			}
				
			// Some Darkmatter Update after FleetMissions
			$user['darkmatter'] = $planetrow['darkmatter'];
			$user['new_message'] = $planetrow['new_message'];
			include_once(ROOT_PATH.'includes/functions/CheckPlanetUsedFields.' . PHP_EXT);
			CheckPlanetUsedFields($planetrow);
			include_once(ROOT_PATH.'includes/classes/class.plugins.'.PHP_EXT);
			$mod_plug = new modPl();
			$mod_plug->run();
 		}
	} else {
		//Login
		require_once(ROOT_PATH . 'includes/classes/class.template.'.PHP_EXT);
	}
}
else
{
	$dpath     = "../" . DEFAULT_SKINPATH;
}

?>