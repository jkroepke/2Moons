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
 * @version 1.6 (2011-11-17)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) exit;

require_once(ROOT_PATH. 'includes/classes/class.FlyingFleetsTable.php');

function ShowFlyingFleetPage()
{
	global $LNG, $db;
	
	$id	= request_var('id', 0);
	if(!empty($id)){
		$db->query("UPDATE ".FLEETS." SET `fleet_busy` = '".request_var('lock', 0)."' WHERE `fleet_id` = '".$id."' AND `fleet_universe` = '".$_SESSION['adminuni']."';;");
	} 

	$FlyingFleetsTable 	= new FlyingFleetsTable();
	$template			= new template();
	

	$template->assign_vars(array(
		'FleetList'			=> $FlyingFleetsTable->BuildFlyingFleetTable(),
		'ff_id'				=> $LNG['ff_id'],
		'ff_ammount'		=> $LNG['ff_ammount'],
		'ff_mission'		=> $LNG['ff_mission'],
		'ff_beginning'		=> $LNG['ff_beginning'],
		'ff_departure'		=> $LNG['ff_departure'],
		'ff_departure_hour'	=> $LNG['ff_departure_hour'],
		'ff_objective'		=> $LNG['ff_objective'],
		'ff_arrival'		=> $LNG['ff_arrival'],
		'ff_arrival_hour'	=> $LNG['ff_arrival_hour'],
		'ff_hold_position'	=> $LNG['ff_hold_position'],
		'ff_lock'			=> $LNG['ff_lock'],
		'ff_no_fleets'		=> $LNG['ff_no_fleets'],
	));
	$template->show('adm/FlyingFleetPage.tpl');
}
?>