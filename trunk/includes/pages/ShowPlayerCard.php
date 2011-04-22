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
 * @version 1.3.5 (2011-04-22)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

function ShowPlayerCard()
{
	global $USER, $PLANET, $LNG, $UNI, $db;
	
	$template	= new template();
	$template->isDialog(true);
	
    $playerid 	= request_var('id', 0);
		
    $query 		= $db->uniquequery("SELECT a.wons, a.loos, a.draws, a.kbmetal, a.kbcrystal, a.lostunits, a.desunits, a.ally_id, a.ally_name, a.username, a.galaxy, a.system, a.planet, b.name, c.tech_rank, c.tech_points, c.build_rank, c.build_points, c.defs_rank, c.defs_points, c.fleet_rank, c.fleet_points, c.total_rank, c.total_points FROM ".USERS." as a, ".PLANETS." as b, ".STATPOINTS." as c WHERE a.universe = '".$UNI."' AND a.id = '". $db->sql_escape($playerid) ."' AND a.id_planet = b.id AND a.id = c.id_owner AND c.stat_type = 1;");

	$totalfights = $query['wons'] + $query['loos'] + $query['draws'];
	
	if ($totalfights == 0) {
		$siegprozent                = 0;
		$loosprozent                = 0;
		$drawsprozent               = 0;
	}
	else {
		$siegprozent                = 100 / $totalfights * $query['wons'];
		$loosprozent                = 100 / $totalfights * $query['loos'];
		$drawsprozent               = 100 / $totalfights * $query['draws'];
	}

	$template->assign_vars(array(	
		'id'			=> $playerid,
		'yourid'		=> $USER['id'],
		'name'			=> $query['username'],
		'homeplanet'	=> $query['name'],
		'galaxy'		=> $query['galaxy'],
		'system'		=> $query['system'],
		'planet'		=> $query['planet'],
		'allyid'		=> $query['ally_id'],
		'tech_rank'     => pretty_number($query['tech_rank']),
		'tech_points'   => pretty_number($query['tech_points']),
		'build_rank'    => pretty_number($query['build_rank']),
		'build_points'  => pretty_number($query['build_points']),
		'defs_rank'     => pretty_number($query['defs_rank']),
		'defs_points'   => pretty_number($query['defs_points']),
		'fleet_rank'    => pretty_number($query['fleet_rank']),
		'fleet_points'  => pretty_number($query['fleet_points']),
		'total_rank'    => pretty_number($query['total_rank']),
		'total_points'  => pretty_number($query['total_points']),
		'allyname'		=> $query['ally_name'],
		'playerdestory' => sprintf($LNG['pl_destroy'], $query['username']),
		'wons'          => pretty_number($query['wons']),
		'loos'          => pretty_number($query['loos']),
		'draws'         => pretty_number($query['draws']),
		'kbmetal'       => pretty_number($query['kbmetal']),
		'kbcrystal'     => pretty_number($query['kbcrystal']),
		'lostunits'     => pretty_number($query['lostunits']),
		'desunits'      => pretty_number($query['desunits']),
		'totalfights'   => pretty_number($totalfights),
		'siegprozent'   => round($siegprozent, 2),
		'loosprozent'   => round($loosprozent, 2),
		'drawsprozent'  => round($drawsprozent, 2),
		'pl_name'		=> $LNG['pl_name'],
		'pl_overview'	=> $LNG['pl_overview'],
		'pl_ally'		=> $LNG['pl_ally'],
		'pl_message'	=> $LNG['pl_message'],
		'pl_range'		=> $LNG['pl_range'],
		'pl_builds'		=> $LNG['pl_builds'],
		'pl_tech'		=> $LNG['pl_tech'],
		'pl_fleet'		=> $LNG['pl_fleet'],
		'pl_def'		=> $LNG['pl_def'],
		'pl_fightstats'	=> $LNG['pl_fightstats'],
		'pl_fights'		=> $LNG['pl_fights'],
		'pl_fprocent'	=> $LNG['pl_fprocent'],
		'pl_fightstats'	=> $LNG['pl_fightstats'],
		'pl_fights'		=> $LNG['pl_fights'],
		'pl_fprocent'	=> $LNG['pl_fprocent'],
		'pl_fightwon'	=> $LNG['pl_fightwon'],
		'pl_fightdraw'	=> $LNG['pl_fightdraw'],
		'pl_fightlose'	=> $LNG['pl_fightlose'],
		'pl_totalfight'	=> $LNG['pl_totalfight'],
		'pl_unitsshot'	=> $LNG['pl_unitsshot'],
		'pl_unitslose'	=> $LNG['pl_unitslose'],
		'pl_dermetal'	=> $LNG['pl_dermetal'],
		'pl_dercrystal'	=> $LNG['pl_dercrystal'],
		'pl_total'		=> $LNG['pl_total'],
		'pl_buddy'		=> $LNG['pl_buddy'],
		'pl_points'		=> $LNG['pl_points'],
		'pl_homeplanet'	=> $LNG['pl_homeplanet'],
		'pl_etc'		=> $LNG['pl_etc'],
	));
	
	$template->show("playercard_overview.tpl");

}
?>