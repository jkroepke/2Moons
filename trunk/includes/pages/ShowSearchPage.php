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

if(!defined('INSIDE')) die('Hacking attempt!');

function ShowSearchPage()
{
	global $USER, $PLANET, $dpath, $LNG, $db;

	$PlanetRess = new ResourceUpdate();
	$PlanetRess->CalcResource();
	$PlanetRess->SavePlanetToDB();

	$template	= new template();

	$template->page_header();
	$template->page_topnav();
	$template->page_leftmenu();
	$template->page_planetmenu();
	$template->page_footer();	
	
	$type 		= request_var('type','');
	$searchtext = request_var('searchtext','');
	switch($type) {
		case 'playername':
			$search = $db->query("SELECT a.id, a.username, a.ally_id, a.ally_name, a.galaxy, a.system, a.planet, b.name, c.total_rank FROM ".USERS." as a LEFT JOIN ".PLANETS." as b ON b.id = a.id_planet LEFT JOIN ".STATPOINTS." as c ON c.stat_type = 1 AND c.id_owner = a.id WHERE a.`universe` = "'.$UNI.'" AND a.username LIKE '%".$db->sql_escape($searchtext, true)."%' LIMIT 25;");
			while($s = $db->fetch_array($search))
			{
				$SearchResult[]	= array(
					'planetname'	=> $s['name'],
					'username' 		=> $s['username'],
					'userid' 		=> $s['id'],
					'allyname'	 	=> $s['ally_name'],
					'allyid'		=> $s['ally_id'],
					'galaxy' 		=> $s['galaxy'],
					'system'		=> $s['system'],
					'planet'		=> $s['planet'],
					'rank'			=> $s['total_rank'],
				);	
			}
			
			$db->free_result($search);
		break;
		case 'planetname':
			$search = $db->query("SELECT a.name, a.galaxy, a.planet, a.system, b.ally_name, b.id, b.ally_id, b.username, c.total_rank FROM ".PLANETS." as a LEFT JOIN ".USERS." as b ON b.id = a.id_owner LEFT JOIN  ".STATPOINTS." as c ON c.stat_type = 1 AND c.id_owner = b.id WHERE a.`universe` = '".$UNI."' AND a.name LIKE '%".$db->sql_escape($searchtext, true)."%' LIMIT 25;");
			while($s = $db->fetch_array($search))
			{
				$SearchResult[]	= array(
					'planetname'	=> $s['name'],
					'username' 		=> $s['username'],
					'userid' 		=> $s['id'],
					'allyname'	 	=> $s['ally_name'],
					'allyid'		=> $s['ally_id'],
					'galaxy' 		=> $s['galaxy'],
					'system'		=> $s['system'],
					'planet'		=> $s['planet'],
					'rank'			=> $s['total_rank'],
				);	
			}
			
			$db->free_result($search);
		break;
		case "allytag":
			$search = $db->query("SELECT a.ally_name, a.ally_tag, a.ally_members, b.total_points FROM ".ALLIANCE." as a, ".STATPOINTS." as b WHERE a.`ally_universe` = '".$UNI."' AND b.stat_type = 1 AND b.id_owner = a.id AND a.ally_tag LIKE '%".$db->sql_escape($searchtext, true)."%' LIMIT 25;");
			while($s = $db->fetch_array($search))
			{
				$SearchResult[]	= array(
					'allypoints'	=> pretty_number($s['total_points']),
					'allytag'		=> $s['ally_tag'],
					'allymembers'	=> $s['ally_members'],
					'allyname'		=> $s['ally_name'],
				);
			}
			
			$db->free_result($search);
		break;
		case "allyname":
			$search = $db->query("SELECT a.ally_name, a.ally_tag, a.ally_members, b.total_points FROM ".ALLIANCE." as a, ".STATPOINTS." as b WHERE a.`ally_universe` = '".$UNI."' AND b.stat_type = 1 AND b.id_owner = a.id AND a.ally_name LIKE '%".$db->sql_escape($searchtext, true)."%' LIMIT 25;");
			while($s = $db->fetch_array($search))
			{
				$SearchResult[]	= array(
					'allypoints'	=> pretty_number($s['total_points']),
					'allytag'		=> $s['ally_tag'],
					'allymembers'	=> $s['ally_members'],
					'allyname'		=> $s['ally_name'],
				);
			}
			
			$db->free_result($search);
		break;
	}

	$SeachTypes	= array("playername" => $LNG['sh_player_name'], "planetname" => $LNG['sh_planet_name'], "allytag" => $LNG['sh_alliance_tag'], "allyname" => $LNG['sh_alliance_name']);
	$template->assign_vars(array(
		'SearchResult'				=> $SearchResult,
		'SeachTypes'				=> $SeachTypes,
		'SeachInput'				=> $searchtext,
		'SeachType'					=> $type,
		'sh_search'					=> $LNG['sh_search'],
		'sh_search_in_the_universe'	=> $LNG['sh_search_in_the_universe'],
		'sh_buddy_request'			=> $LNG['sh_buddy_request'],
		'sh_write_message'			=> $LNG['sh_write_message'],
		'sh_name'					=> $LNG['sh_name'],
		'sh_alliance'				=> $LNG['sh_alliance'],
        'sh_planet'					=> $LNG['sh_planet'],
		'sh_coords'					=> $LNG['sh_coords'],
		'sh_position'				=> $LNG['sh_position'],
		'sh_tag'					=> $LNG['sh_tag'],
		'sh_members'				=> $LNG['sh_members'],
		'sh_points'					=> $LNG['sh_points'],
	));
	
	$template->show("search_body.tpl");
}
?>