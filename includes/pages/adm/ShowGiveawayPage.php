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
 * @copyright 2009 Lucky <douglas@crockford.com> (XGProyecto)
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.3 (2011-01-21)
 * @link http://2moons.cc/
 */
 
 if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) throw new Exception("Permission error!");
function ShowGiveaway()
{
	global $LNG, $resource, $reslist;
	$template	= new template();	
	$action	= HTTP::_GP('action', '');
	if ($action == 'send') {
		$planet			= HTTP::_GP('planet', 0);
		$moon			= HTTP::_GP('moon', 0);
		$mainplanet		= HTTP::_GP('mainplanet', 0);
		$no_inactive	= HTTP::_GP('no_inactive', 0);
		
		if (!$planet && !$moon) {
			$template->message($LNG['ga_selectplanettype']);
			exit;
		}
		
		$planetIN	= array();
		
		if ($planet) {
			$planetIN[]	= "'1'";
		} 
		
		if ($moon) {
			$planetIN[]	= "'3'";
		} 
		
		$data		= array();
		
		$DataIDs	= array_merge($reslist['resstype'][1], $reslist['resstype'][3], $reslist['build'], $reslist['tech'], $reslist['fleet'], $reslist['defense'], $reslist['officier']);
		
		$logOld		= array();
		$logNew		= array();
		
		foreach($DataIDs as $ID)
		{
			$amount	= max(0, round(HTTP::_GP('element_'.$ID, 0.0)));
			$data[]	= $resource[$ID]." = ".$resource[$ID]." + ".$amount;
			
			$logOld[$ID]	= 0;
			$logNew[$ID]	= $amount;
		}
		
		$SQL		= "UPDATE ".PLANETS." p INNER JOIN ".USERS." u ON p.id_owner = u.id";
		
		if ($mainplanet == true) {
			$SQL	.= " AND CONCAT_WS(':', p.universe, p.galaxy, p.system, p.planet) = CONCAT_WS(':', u.universe, u.galaxy, u.system, u.planet)";
		}
		
		if ($no_inactive == true) {
			$SQL	.= " AND u.onlinetime < ".(TIMESTAMP - INACTIVE);
		}
		
		$SQL	.= " SET ".implode(', ', $data)." WHERE p.universe = ".$_SESSION['adminuni']." AND p.planet_type IN (".implode(',', $planetIN).")";
		
		$GLOBALS['DATABASE']->query($SQL);
		
		$LOG = new Log(4);
		$LOG->target = 0;
		$LOG->old = $logOld;
		$LOG->new = $logNew;
		$LOG->save();
		
		$template->message($LNG['ga_success']);
		exit;
	}	
	
	$template->assign_vars(array(	
		'reslist'		=> $reslist
	));
	$template->show("giveaway.tpl");
}

