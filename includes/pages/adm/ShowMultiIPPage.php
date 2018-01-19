<?php

/**
 *  2Moons 
 *   by Jan-Otto Kröpke 2009-2016
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan-Otto Kröpke <slaver7@gmail.com>
 * @copyright 2009 Lucky
 * @copyright 2016 Jan-Otto Kröpke <slaver7@gmail.com>
 * @licence MIT
 * @version 1.8.0
 * @link https://github.com/jkroepke/2Moons
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
	$Query	= $GLOBALS['DATABASE']->query("SELECT id, username, email, register_time, onlinetime, user_lastip, IFNULL(multiID, 0) as isKnown FROM ".USERS." LEFT JOIN ".MULTI." ON userID = id WHERE `universe` = '".Universe::getEmulated()."' AND user_lastip IN (SELECT user_lastip FROM ".USERS." WHERE `universe` = '".Universe::getEmulated()."' GROUP BY user_lastip HAVING COUNT(*)>1) ORDER BY user_lastip, id ASC;");
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

