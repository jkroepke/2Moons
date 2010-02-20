<?php

##############################################################################
# *                                                                          #
# * 2MOONS                                                                   #
# *                                                                          #
# * @copyright Copyright (C) 2010 By ShadoX from titanspace.de               #
# *                                                                          #
# *	                                                                         #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.                                     #
# *	                                                                         #
# *  This program is distributed in the hope that it will be useful,         #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of          #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           #
# *  GNU General Public License for more details.                            #
# *                                                                          #
##############################################################################

if(!defined('INSIDE')){ die(header("location:../../"));}

function ShowPlayerCard($CurrentUser)
{
	global $lang, $db;
	
	$template	= new template();
	$template->page_header();
	$template->page_footer();
	
    $playerid 	= request_var('id', 0);
		
    $query 		= $db->fetch_array($db->query("SELECT a.wons, a.loos, a.draws, a.kbmetal, a.kbcrystal, a.lostunits, a.desunits, a.ally_id, a.ally_name, a.username, a.galaxy, a.system, a.planet, b.name, c.tech_rank, c.tech_points, c.build_rank, c.build_points, c.defs_rank, c.defs_points, c.fleet_rank, c.fleet_points, c.total_rank, c.total_points FROM ".USERS." as a, ".PLANETS." as b, ".STATPOINTS." as c WHERE a.id = '". $db->sql_escape($playerid) ."' AND a.id_planet = b.id AND a.id = c.id_owner AND c.stat_type = 1;"));

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
		'playerdestory' => sprintf($lang['pl_destroy'], $query['username']),
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
		'pl_name'		=> $lang['pl_name'],
		'pl_overview'	=> $lang['pl_overview'],
		'pl_ally'		=> $lang['pl_ally'],
		'pl_message'	=> $lang['pl_message'],
		'pl_range'		=> $lang['pl_range'],
		'pl_builds'		=> $lang['pl_builds'],
		'pl_tech'		=> $lang['pl_tech'],
		'pl_fleet'		=> $lang['pl_fleet'],
		'pl_def'		=> $lang['pl_def'],
		'pl_fightstats'	=> $lang['pl_fightstats'],
		'pl_fights'		=> $lang['pl_fights'],
		'pl_fprocent'	=> $lang['pl_fprocent'],
		'pl_fightstats'	=> $lang['pl_fightstats'],
		'pl_fights'		=> $lang['pl_fights'],
		'pl_fprocent'	=> $lang['pl_fprocent'],
		'pl_fightwon'	=> $lang['pl_fightwon'],
		'pl_fightdraw'	=> $lang['pl_fightdraw'],
		'pl_fightlose'	=> $lang['pl_fightlose'],
		'pl_totalfight'	=> $lang['pl_totalfight'],
		'pl_unitsshot'	=> $lang['pl_unitsshot'],
		'pl_unitslose'	=> $lang['pl_unitslose'],
		'pl_dermetal'	=> $lang['pl_dermetal'],
		'pl_dercrytal'	=> $lang['pl_dercrytal'],
		'pl_total'		=> $lang['pl_total'],
		'pl_buddy'		=> $lang['pl_buddy'],
		'pl_points'		=> $lang['pl_points'],
		'pl_homeplanet'	=> $lang['pl_homeplanet'],
		'pl_etc'		=> $lang['pl_etc'],
	));
	
	$template->show("playercard_overview.tpl");

}
?>