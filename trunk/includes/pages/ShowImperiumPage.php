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

function ShowImperiumPage($CurrentUser, $CurrentPlanet)
{
	global $lang, $resource, $reslist, $dpath, $db;

	$PlanetRess = new ResourceUpdate($CurrentUser, $CurrentPlanet);
	$template	= new template();
	$template->loadscript("trader.js");
	$template->set_vars($CurrentUser, $CurrentPlanet);
	$template->page_topnav();
	$template->page_header();
	$template->page_leftmenu();
	$template->page_planetmenu();
	$template->page_footer();
	
	$SQLArray 	= array_merge($reslist['build'], $reslist['fleet'], $reslist['defense']);
	$Query		= "";
	
	foreach($SQLArray as $id => $gid){
		$Query .= ",`".$resource[$gid]."`";
	}
	
	
	$PlanetsRAW = $db->query("
	SELECT `id`,`name`,`galaxy`,`system`,`planet`,`planet_type`,
	`image`,`field_current`,`field_max`,`metal`,`crystal`,`deuterium`,
	`energy_used`,`energy_max` ".$Query." FROM ".PLANETS." WHERE `id_owner` = '" . $CurrentUser['id'] . "' AND `destruyed` = '0';");


	while ($Planet = $db->fetch_array($PlanetsRAW))
	{
		$InfoList	= array(
			'id'			=> $Planet['id'],
			'name'			=> $Planet['name'],
			'image'			=> $Planet['image'],
			'galaxy'		=> $Planet['galaxy'],
			'system'		=> $Planet['system'],
			'planet'		=> $Planet['planet'],
			'field_current'	=> $Planet['field_current'],
			'field_max'		=> CalculateMaxPlanetFields($Planet),
			'metal'			=> pretty_number($Planet['metal']),
			'crystal'		=> pretty_number($Planet['crystal']),
			'deuterium'		=> pretty_number($Planet['deuterium']),
			'energy_used'	=> pretty_number($Planet['energy_max'] + $Planet['energy_used']),
			'energy_max'	=> pretty_number($Planet['energy_max']),
		);
		
		foreach($reslist['build'] as $gid){
			$BuildsList[$gid] = pretty_number($Planet[$resource[$gid]]);
		}
		
		foreach($reslist['fleet'] as $gid){
			$FleetsList[$gid] = pretty_number($Planet[$resource[$gid]]);
		}
		
		foreach($reslist['defense'] as $gid){
			$DefensesList[$gid] = pretty_number($Planet[$resource[$gid]]);
		}

		$PlanetsList[]	= array(
			'InfoList'		=> $InfoList,
			'BuildsList'	=> $BuildsList,
			'FleetsList'	=> $FleetsList,
			'DefensesList'	=> $DefensesList,
		);
	}

	foreach($reslist['tech'] as $gid){
		$ResearchList[$gid] = pretty_number($CurrentUser[$resource[$gid]]);
	}
		
	$template->assign_vars(array(
		'colspan'			=> count($PlanetsList) + 1,
		'PlanetsList'		=> $PlanetsList,
		'ResearchList'		=> $ResearchList,
		'iv_imperium_title'	=> $lang['iv_imperium_title'],
		'iv_planet'			=> $lang['iv_planet'],
		'iv_name'			=> $lang['iv_name'],
		'iv_coords'			=> $lang['iv_coords'],
		'iv_fields'			=> $lang['iv_fields'],
		'iv_resources'		=> $lang['iv_resources'],
		'Metal'				=> $lang['Metal'],
		'Crystal'			=> $lang['Crystal'],
		'Deuterium'			=> $lang['Deuterium'],
		'Energy'			=> $lang['Energy'],
		'iv_buildings'		=> $lang['iv_buildings'],
		'iv_technology'		=> $lang['iv_technology'],
		'iv_ships'			=> $lang['iv_ships'],
		'iv_defenses'		=> $lang['iv_defenses'],
		'tech'				=> $lang['tech'],
		'build'				=> $reslist['build'], 
		'fleet'				=> $reslist['fleet'], 
		'defense'			=> $reslist['defense'],
		'research'			=> $reslist['tech'],
	));

	$template->show("empire_overview.tpl");
}
?>