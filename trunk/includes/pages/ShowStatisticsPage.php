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

function ShowStatisticsPage($CurrentUser, $CurrentPlanet)
{
	global $game_config, $dpath, $lang, $db;
	
	$PlanetRess = new ResourceUpdate($CurrentUser, $CurrentPlanet);

	$template	= new template();
	
	$template->set_vars($CurrentUser, $CurrentPlanet);
	$template->page_header();
	$template->page_topnav();
	$template->page_leftmenu();
	$template->page_planetmenu();
	$template->page_footer();

	$who   	= request_var('who', 1);
	$type  	= request_var('type', 1);
	$range 	= request_var('range', 1);
	
	switch ($type)
	{
		case 1:
			$Order   = "total_points";
			$Points  = "total_points";
			$Counts  = "total_count";
			$Rank    = "total_rank";
			$OldRank = "total_old_rank";
		break;
		case 2:
			$Order   = "fleet_points";
			$Points  = "fleet_points";
			$Counts  = "fleet_count";
			$Rank    = "fleet_rank";
			$OldRank = "fleet_old_rank";
		break;
		case 3:
			$Order   = "tech_points";
			$Points  = "tech_points";
			$Counts  = "tech_count";
			$Rank    = "tech_rank";
			$OldRank = "tech_old_rank";
		break;
		case 4:
			$Order   = "build_points";
			$Points  = "build_points";
			$Counts  = "build_count";
			$Rank    = "build_rank";
			$OldRank = "build_old_rank";
		break;
		case 5:
			$Order   = "defs_points";
			$Points  = "defs_points";
			$Counts  = "defs_count";
			$Rank    = "defs_rank";
			$OldRank = "defs_old_rank";
		break;
		default:
			$Order   = "total_points";
			$Points  = "total_points";
			$Counts  = "total_count";
			$Rank    = "total_rank";
			$OldRank = "total_old_rank";
		break;
	}
	switch($who)
	{
		case 1:
			$MaxUsers = $db->fetch_array($db->query("SELECT COUNT(*) AS `count` FROM ".USERS." WHERE `db_deaktjava` = '0';"));
			
			$LastPage = min(floor($MaxUsers['count'] / 100), 1);

			for ($Page = 0; $Page <= $LastPage; $Page++)
			{
				$PageValue      				= ($Page * 100) + 1;
				$PageRange      				= $PageValue + 99;
				$Selector['range'][$PageValue] 	= $PageValue."-".$PageRange;
			}

			$start = floor($range / 100 % 100) * 100;

			$stats_sql	=	'SELECT DISTINCT s.*, u.id, u.username, u.ally_id, u.ally_name FROM '.STATPOINTS.' as s
			INNER JOIN '.USERS.' as u ON u.id = s.id_owner
			WHERE s.`stat_type` = 1 AND s.`stat_code` = 1 '.(($game_config['stat'] == 2)?'AND u.`authlevel` < '.$game_config['stat_level'].' ':'').'
			ORDER BY `'. $Order .'` DESC LIMIT '. $start .',100;';

			$query = $db->query($stats_sql);

			while ($StatRow = $db->fetch_array($query))
			{			
				$RangeList[]	= array(
					'id'		=> $StatRow['id'],
					'name'		=> $StatRow['username'],
					'points'	=> pretty_number($StatRow[$Order]),
					'allyid'	=> $StatRow['ally_id'],
					'rank'		=> $StatRow[$Rank],
					'allyname'	=> $StatRow['ally_name'],
					'ranking'	=> $StatRow[$OldRank] - $StatRow[$Rank],
				);
			}
		break;
		case 2:
			$MaxAllys = $db->fetch_array($db->query("SELECT COUNT(*) AS `count` FROM ".ALLIANCE.";"));

				$LastPage = min(floor($MaxAllys['count'] / 100), 1);

				for ($Page = 0; $Page <= $LastPage; $Page++)
				{
					$PageValue      				= ($Page * 100) + 1;
					$PageRange      				= $PageValue + 99;
					$Selector['range'][$PageValue] 	= $PageValue."-".$PageRange;
				}

			$start = floor($range / 100 % 100) * 100;

			$stats_sql	=	'SELECT DISTINCT s.*, a.id, a.ally_members, a.ally_name FROM '.STATPOINTS.' as s
			INNER JOIN '.ALLIANCE.' as a ON a.id = s.id_owner
			WHERE `stat_type` = 2 AND `stat_code` = 1
			ORDER BY `'. $Order .'` DESC LIMIT '. $start .',100;';

			$query = $db->query($stats_sql);

			while ($StatRow = $db->fetch($query))
			{
				$RangeList[]	= array(
					'id'		=> $StatRow['id'],
					'name'		=> $StatRow['ally_name'],
					'members'	=> $StatRow['ally_members'],
					'rank'		=> $StatRow[$Rank],
					'mppoints'	=> pretty_number(floor($StatRow[$Order] / $StatRow['ally_members'])),
					'points'	=> pretty_number($StatRow[$Order]),
					'ranking'	=> $StatRow[$OldRank] - $StatRow[$Rank],
				);
			}
		break;
	}
	
	$Selector['who'] 	= array(1 => $lang['st_player'], 2 => $lang['st_alliance'],);
	$Selector['type']	= array(1 => $lang['st_points'], 2 => $lang['st_fleets'], 3 => $lang['st_researh'], 4 => $lang['st_buildings'], 5 => $lang['st_defenses'],);
	$template->assign_vars(array(	
		'Selectors'				=> $Selector,
		'who'					=> $who,
		'type'					=> $type,
		'range'					=> floor(($range - 1) / 100) * 100 + 1,
		'RangeList'				=> $RangeList,
		'CUser_ally'			=> $CurrentUser['ally_id'],
		'CUser_id'				=> $CurrentUser['id'],
		'st_members'			=> $lang['st_members'],
		'st_per_member'			=> $lang['st_per_member'],
		'st_position'			=> $lang['st_position'],
		'st_player'				=> $lang['st_player'],
		'st_alliance'			=> $lang['st_alliance'],
		'st_write_message'		=> $lang['st_write_message'],
		'st_points'				=> $lang['st_points'],
		'st_per'				=> $lang['st_per'],
		'st_statistics'			=> $lang['st_statistics'],
		'st_updated'			=> $lang['st_updated'],
		'stat_date'				=> date("d. M Y, H:i:s", $game_config['stat_last_update']),
		'st_show'				=> $lang['st_show'],
		'st_in_the_positions'	=> $lang['st_in_the_positions'],
	));
	
	$template->show("stat_overview.tpl");
	$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
}
?>