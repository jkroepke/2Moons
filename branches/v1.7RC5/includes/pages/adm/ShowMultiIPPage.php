<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
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
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.0 (2012-12-31)
 * @info $Id$
 * @link http://2moons.cc/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) throw new Exception("Permission error!");

function ShowMultiIPPage()
{
	global $LNG;
	
	switch($_GET['action'])
	{
		case 'known':
			$GLOBALS['DATABASE']->query("INSERT INTO ".MULTI." SET userID = ".((int) $_GET['id']).";");
			HTTP::redirectTo("admin.php?page=multiips");
		break;
		case 'unknown':
			$GLOBALS['DATABASE']->query("DELETE FROM ".MULTI." WHERE userID = ".((int) $_GET['id']).";");
			HTTP::redirectTo("admin.php?page=multiips");
		break;
	}
	$Query	= $GLOBALS['DATABASE']->query("SELECT id, username, email, register_time, onlinetime, user_lastip, IFNULL(multiID, 0) as isKnown FROM ".USERS." LEFT JOIN ".MULTI." ON userID = id WHERE `universe` = '".$_SESSION['adminuni']."' AND user_lastip IN (SELECT user_lastip FROM ".USERS." WHERE `universe` = '".$_SESSION['adminuni']."' GROUP BY user_lastip HAVING COUNT(*)>1) ORDER BY user_lastip, id ASC;");
	$IPs	= array();
	while($Data = $GLOBALS['DATABASE']->fetch_array($Query)) {
		if(!isset($IPs[$Data['user_lastip']]))
			$IPs[$Data['user_lastip']]	= array();
		
		$Data['register_time']	= _date($LNG['php_tdformat'], $Data['register_time']);
		$Data['onlinetime']		= _date($LNG['php_tdformat'], $Data['onlinetime']);
		
		$IPs[$Data['user_lastip']][$Data['id']]	= $Data;
	}
	
	$template	= new template();
	$template->assign_vars(array(
		'multiGroups'	=> $IPs,
	));
	$template->show('MultiIPs.tpl');
}


?>