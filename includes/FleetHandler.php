<?php

if(php_sapi_name() === 'cli') {
	error_reporting(E_ALL ^ E_NOTICE);
	define('ROOT_PATH', str_replace('\\', '/', dirname(dirname(__FILE__))).'/');
	define('TIMESTAMP',	time());
	ini_set('display_errors', 0);
	ini_set('error_log', ROOT_PATH.'/includes/cli_error.log');
	if(!function_exists('bcadd'))
		require_once(ROOT_PATH . 'includes/bcmath.php');

	require_once(ROOT_PATH . 'includes/config.php');	
	require_once(ROOT_PATH . 'includes/constants.php');
	require_once(ROOT_PATH . 'includes/classes/class.MySQLi.php');
	require_once(ROOT_PATH . 'includes/classes/class.Lang.php');
	require_once(ROOT_PATH . 'includes/GeneralFunctions.php');
	require_once(ROOT_PATH . 'includes/vars.php');
	$db 	= new DB_MySQLi();
	unset($database);
	$LANG	= new Language();
}
function init() {
	global $db;
	if(php_sapi_name() === 'cli' && (defined('IN_ADMIN') || request_var('ajax', 0) != 0)) 
		return false;
	
	$db->query("LOCK TABLE ".AKS." WRITE, ".RW." WRITE, ".MESSAGES." WRITE, ".FLEETS." WRITE, ".PLANETS." WRITE, ".PLANETS." as p WRITE, ".TOPKB." WRITE, ".USERS." WRITE, ".USERS." as u WRITE, ".STATPOINTS." WRITE;");	
	
	$FLEET = $db->query("SELECT * FROM ".FLEETS." WHERE (`fleet_start_time` <= '". TIMESTAMP ."' AND `fleet_mess` = '0') OR (`fleet_end_time` <= '". TIMESTAMP ."' AND `fleet_mess` = '1') OR (`fleet_end_stay` <= '". TIMESTAMP ."' AND `fleet_mess` = '2') ORDER BY `fleet_start_time` ASC;");
	if($db->num_rows($FLEET) > 0)
	{
		require_once(ROOT_PATH . 'includes/classes/class.FlyingFleetHandler.php');
	
		new FlyingFleetHandler($FLEET);
	}
	$db->free_result($FLEET);
	$db->query("UNLOCK TABLES");  
}
init();
if(php_sapi_name() === 'cli') {
	echo 'OK! - '.date("H:i:s")."\r\n";
}
?>