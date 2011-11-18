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
 * @version 1.6.1 (2011-11-19)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) exit;

function ShowMultiIPPage()
{
	global $LNG, $db;
	$Query	= $db->query("SELECT id, username, user_lastip FROM ".USERS." WHERE `universe` = '".$_SESSION['adminuni']."' AND user_lastip IN (SELECT user_lastip FROM ".USERS." WHERE `universe` = '".$_SESSION['adminuni']."' GROUP BY user_lastip HAVING COUNT(*)>1) ORDER BY user_lastip, id ASC;");
	$IPs	= array();
	while($Data = $db->fetch_array($Query)) {
		if(!isset($IPs[$Data['user_lastip']]))
			$IPs[$Data['user_lastip']]	= array();
		
		$IPs[$Data['user_lastip']][$Data['id']]	= $Data['username'];
	}
	$template	= new template();
	$template->assign_vars(array(
		'IPs'		=> $IPs,
		'mip_ip'	=> $LNG['mip_ip'],
		'mip_user'	=> $LNG['mip_user'],
	));
	$template->show('adm/MultiIPs.tpl');
}


?>