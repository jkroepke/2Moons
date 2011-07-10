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
 * @version 1.4 (2011-07-10)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */
 
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
	
$db->query("LOCK TABLE ".AKS." WRITE, ".RW." WRITE, ".MESSAGES." WRITE, ".CONFIG." WRITE, ".FLEETS." WRITE, ".PLANETS." WRITE, ".PLANETS." as p WRITE, ".TOPKB." WRITE, ".USERS." WRITE, ".USERS." as u WRITE, ".STATPOINTS." WRITE;");	

$FLEET = $db->query("SELECT * FROM ".FLEETS." WHERE (`fleet_start_time` <= '". TIMESTAMP ."' AND `fleet_mess` = '0') OR (`fleet_end_time` <= '". TIMESTAMP ."' AND `fleet_mess` = '1') OR (`fleet_end_stay` <= '". TIMESTAMP ."' AND `fleet_mess` = '2') ORDER BY `fleet_start_time` ASC;");
if($db->num_rows($FLEET) > 0)
{
	require_once(ROOT_PATH . 'includes/classes/class.FlyingFleetHandler.php');

	new FlyingFleetHandler($FLEET);
}
$db->free_result($FLEET);
$db->query("UNLOCK TABLES");  

if(php_sapi_name() === 'cli') {
	echo 'OK! - '.date(TIMEFORMAT)."\r\n";
}
?>