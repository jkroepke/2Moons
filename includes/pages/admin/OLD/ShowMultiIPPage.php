<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan
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
 * @author Jan <info@2moons.cc>
 * @copyright 2006 Perberos <ugamela@perberos.com.ar> (UGamela)
 * @copyright 2008 Chlorel (XNova)
 * @copyright 2009 Lucky (XGProyecto)
 * @copyright 2012 Jan <info@2moons.cc> (2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.0 (2012-05-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) exit;

function ShowMultiIPPage()
{
	global $LNG;
	$Query	= $GLOBALS['DATABASE']->query("SELECT id, username, email, register_time, onlinetime, user_lastip FROM ".USERS." WHERE `universe` = '".$_SESSION['adminuni']."' AND user_lastip IN (SELECT user_lastip FROM ".USERS." WHERE `universe` = '".$_SESSION['adminuni']."' GROUP BY user_lastip HAVING COUNT(*)>1) ORDER BY user_lastip, id ASC;");
	$IPs	= array();
	while($Data = $GLOBALS['DATABASE']->fetchArray($Query)) {
		if(!isset($IPs[$Data['user_lastip']]))
			$IPs[$Data['user_lastip']]	= array();
		
		$Data['register_time']	= _date($LNG['php_tdformat'], $Data['register_time']);
		$Data['onlinetime']		= _date($LNG['php_tdformat'], $Data['onlinetime']);
		
		$IPs[$Data['user_lastip']][$Data['id']]	= $Data;
	}
	
	$template	= new Template();
	$template->assign(array(
		'IPs'		=> $IPs,
		'mip_ip'	=> $LNG['mip_ip'],
	));
	$template->show('MultiIPs.tpl');
}
