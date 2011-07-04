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
	$template->isPopup(true);
	
    $PlayerID 	= request_var('id', 0);
		
    $query 		= $db->uniquequery("SELECT 
						u.username, u.galaxy, u.system, u.planet, u.wons, u.loos, u.draws, u.kbmetal, u.kbcrystal, u.lostunits, u.desunits, u.ally_id, 
						p.name, 
						s.tech_rank, s.tech_points, s.build_rank, s.build_points, s.defs_rank, s.defs_points, s.fleet_rank, s.fleet_points, s.total_rank, s.total_points, 
						a.ally_name 
						FROM ".USERS." u 
						INNER JOIN ".PLANETS." p ON p.id = u.id_planet 
						LEFT JOIN ".STATPOINTS." s ON s.id_owner = u.id AND s.stat_type = 1 
						LEFT JOIN ".ALLIANCE." a ON a.id = u.ally_id
						WHERE u.id = ".$PlayerID." AND u.universe = ".$UNI.";");

	$totalfights = $query['wons'] + $query['loos'] + $query['draws'];
	
	if ($totalfights == 0) {
		$siegprozent                = 0;
		$loosprozent                = 0;
		$drawsprozent               = 0;
	} else {
		$siegprozent                = 100 / $totalfights * $query['wons'];
		$loosprozent                = 100 / $totalfights * $query['loos'];
		$drawsprozent               = 100 / $totalfights * $query['draws'];
	}

	$template->assign_vars(array(	
		'id'			=> $PlayerID,
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
	));
	
	$template->show("playercard_overview.tpl");

}
?>