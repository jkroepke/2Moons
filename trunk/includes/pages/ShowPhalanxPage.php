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

function ShowPhalanxPage()
{
	global $USER, $PLANET, $LNG, $db, $UNI;

	include_once(ROOT_PATH.'includes/classes/class.FlyingFleetsTable.php');
	include_once(ROOT_PATH.'includes/classes/class.GalaxyRows.php');

	$FlyingFleetsTable 	= new FlyingFleetsTable();
	$GalaxyRows 		= new GalaxyRows();

	$template			= new template();
	$template->isPopup(true);
	$template->loadscript('phalanx.js');
	$template->execscript('FleetTime();window.setInterval("FleetTime()", 1000);');
	
	$PhRange 		 	= $GalaxyRows->GetPhalanxRange($PLANET[$resource[43]]);
	$Galaxy 			= request_var('id', 0);
	
	if($Galaxy != $PLANET['galaxy'] || $System > ($PLANET['system'] + $PhRange) || $System < max(1, $PLANET['system'] - $PhRange))
	{
		$template->message($LNG['px_out_of_range'], false, 0, true);
		exit;	
	}
	
	if ($PLANET[$resource[903]] == PHALANX_DEUTERIUM)
	{
		$template->message($LNG['px_no_deuterium'], false, 0, true);
		exit;
	}

	$db->query("UPDATE ".PLANETS." SET `deuterium` = `deuterium` - ".PHALANX_DEUTERIUM." WHERE `id` = '".$PLANET['id']."';");
	
	$TargetInfo = $db->uniquequery("SELECT id, name, id_owner FROM ".PLANETS." WHERE`universe` = '".$UNI."' AND `galaxy` = '".$Galaxy."' AND `system` = '".$System."' AND `planet` = '".$Planet."' AND `planet_type` = '1';");
	
	if(empty($TargetInfo))
	{
		$template->message($LNG['px_out_of_range'], false, 0, true);
		exit;	
	}
	
	require_once(ROOT_PATH . 'includes/classes/class.FlyingFleetsTable.php');
	$fleetTableObj = new FlyingFleetsTable;
	$fleetTableObj->setPhalanxMode();
	$fleetTableObj->setUser($TargetInfo['id_owner']);
	$fleetTableObj->setPlanet($TargetInfo['id']);
	$fpage	=  $fleetTableObj->renderTable();
	
	$template->assign_vars(array(
		'phl_pl_galaxy'  	=> $Galaxy,
		'phl_pl_system'  	=> $System,
		'phl_pl_place'   	=> $Planet,
		'phl_pl_name'    	=> $TargetInfo['name'],
		'fleets'		 	=> $fpage,
		'FleetData'		 	=> json_encode($FleetData),
		'px_scan_position'	=> $LNG['px_scan_position'],
		'px_no_fleet'		=> $LNG['px_no_fleet'],
		'px_fleet_movement'	=> $LNG['px_fleet_movement'],
	));
	
	$template->show('phalax_body.tpl');			
}
?>