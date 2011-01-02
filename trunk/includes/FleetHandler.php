<?php

if(php_sapi_name() === 'cli') {
	define('CLI', true);
	define('INSIDE', true);
	define('ROOT_PATH', str_replace('\\', '/', dirname(dirname(__FILE__))).'/');
	include_once(ROOT_PATH . 'extension.inc');
	include_once(ROOT_PATH . 'common.php');
	ini_set('display_errors', 0);
}
function init() {
	global $db;
	if(CLI === true && (defined('IN_ADMIN') || request_var('ajax', 0) != 0)) 
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
if(CLI === true) {
	echo 'OK! - '.date("H:i:s")."\r\n";
}
?>