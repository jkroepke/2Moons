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

$revision = '$Rev$';
$version  = substr($revision, 6, -2);

setlocale (LC_ALL, 'de_DE@euro', 'de_DE', 'de', 'ge');
ignore_user_abort(true);

@set_time_limit(0);

if((!file_exists($xgp_root . 'config.php') || filesize($xgp_root . 'config.php') == 0) && INSTALL != true)
	exit(header("Location:" . $xgp_root .  "install/"));


if(!defined('INSTALL') || !defined('IN_ADMIN') || !defined('IN_CRON'))
	define("STARTTIME",	microtime(true));
	

if (!(function_exists("spl_autoload_register"))) {
   exit("PHP is missing <a href=\"http://php.net/spl\">Standard PHP Library (SPL)</a> support");
}

date_default_timezone_set("Europe/Berlin");

error_reporting(E_ALL ^ E_NOTICE);

$phpEx			= "php";
$game_config   	= array();
$user          	= array();
$lang          	= array();
$link          	= "";
$IsUserChecked 	= false;


if(file_exists($xgp_root . 'config.php'))
	require_once($xgp_root . 'config.'.$phpEx);

require_once($xgp_root . 'includes/classes/class.db.'.$phpEx);
require_once($xgp_root . 'includes/classes/class.MySQLi.'.$phpEx);
require_once($xgp_root . 'includes/constants.'.$phpEx);
require_once($xgp_root . 'includes/GeneralFunctions.'.$phpEx);
require_once($xgp_root . 'includes/vars.'.$phpEx);
require_once($xgp_root . 'includes/classes/class.template.'.$phpEx);
require_once($xgp_root . 'includes/classes/class.PlanetRessUpdate.'.$phpEx);

set_error_handler('msg_handler', E_ALL);

if(function_exists('ini_set')) {
	ini_set('display_errors', 1);
	ini_set('register_globals', "off");
	ini_set('register_long_arrays', "off");
}

if ($database)
	$db = new DB_MySQLi($database["host"], $database["user"], $database["userpw"], $database["databasename"], $database["port"]);

unset($database);

if (INSTALL != true)
{
	if(!is_object($db))
		trigger_error("Fehler mit Dantenbankconnection! config.php angepasst und eingef&uuml;gt?", E_USER_ERROR);
		
	$funcdir = $xgp_root . 'includes/functions/autoload/';
	if ($handle = opendir($funcdir)) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != ".." && $file != ".svn") {
				include_once($funcdir.$file);
			}
		}
		closedir($handle);
	}
	$cfgresult = $db->query("SELECT HIGH_PRIORITY SQL_CACHE * FROM `".CONFIG."`;");

	while ($row = $db->fetch($cfgresult))
	{
		$game_config[$row['config_name']] = $row['config_value'];
	}
	$db->free_result($cfgresult);
	define('DEFAULT_LANG'	, ($game_config['lang'] 	== '') ? "deutsch" : $game_config['lang']);
	define('VERSION'		, ($game_config['VERSION'] == '') ? "" : "RC".$game_config['VERSION'].".".$version);

	includeLang('INGAME');

	if (!defined('LOGIN') && !defined('IN_CRON'))
	{
		require_once($xgp_root . 'includes/classes/class.CheckSession.'.$phpEx);

		$Result        	= new CheckSession();
		$Result			= $Result->CheckUser($IsUserChecked);
		$IsUserChecked 	= $Result['state'];
		$user          	= $Result['record'];
		
		if (!$IsUserChecked) die(header('Location: '.$xgp_root.'index.php'));
		
		if($game_config['game_disable'] == 0 && $user['authlevel'] == 0)
		{
			trigger_error($game_config['close_reason'], E_USER_NOTICE);
		}
		
		if($game_config['stats_fly_lock'] == 0 && !defined('IN_ADMIN'))
		{	
			$fleetquery = $db->query("SELECT * FROM ".FLEETS." WHERE `fleet_start_time` <= '". time() ."' OR (`fleet_end_time` <= '". time() ."' AND `fleet_mess` = '1') ORDER BY `fleet_start_time` ASC;");
			if($db->num_rows($fleetquery) > 0)
			{
				update_config('stats_fly_lock', time());
				$db->multi_query("UNLOCK TABLES;LOCK TABLE ".AKS." WRITE, ".RW." WRITE, ".MESSAGES." WRITE, ".FLEETS." WRITE, ".PLANETS." WRITE, ".TOPKB." WRITE, ".USERS." WRITE;");
				require_once($xgp_root . 'includes/classes/class.FlyingFleetHandler.'.$phpEx);
			
				new FlyingFleetHandler($fleetquery);
				
				$db->query("UNLOCK TABLES"); 
				update_config('stats_fly_lock', 0); 
			}
		}
		elseif (time() >= ($game_config['stats_fly_lock'] + (60 * 5))){
			update_config('stats_fly_lock', 0);
		}

		if (isset($user))
		{
			if (defined('IN_ADMIN'))
			{
				includeLang('ADMIN');

				$dpath     = "../". DEFAULT_SKINPATH  ;
			}
			else
			{
				$dpath     = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
			}

			require_once($xgp_root . 'includes/functions/SetSelectedPlanet.' . $phpEx);
			SetSelectedPlanet ($user);

			$planetrow = $db->fetch_array($db->query("SELECT p.*,u.`darkmatter` FROM `".PLANETS."` as p, `".USERS."` as u WHERE  u.`id` = p.`id_owner` AND p.`id` = '".$user['current_planet']."';"));

			if(empty($planetrow)){
				$db->query("UPDATE ".USERS." SET `current_planet` = `id_planet` WHERE `id` = '". $user['id'] ."' LIMIT 1");
				exit(header("Location: game.php?page=overview"));
			}
			// Some Darkmatter Update after FleetMissions
			$user['darkmatter'] = $planetrow['darkmatter'];
			include($xgp_root . 'includes/functions/CheckPlanetUsedFields.' . $phpEx);
			CheckPlanetUsedFields($planetrow);
		}
	}	
}
else
{
	$dpath     = "../" . DEFAULT_SKINPATH;
}
?>