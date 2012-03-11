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



function ShowImperiumPage()
{
	global $LNG, $USER, $PLANET, $resource, $reslist, $db;

	if($USER['planet_sort'] == 0)
		$Order	= "`id` ";
	elseif($USER['planet_sort'] == 1)
		$Order	= "`galaxy`, `system`, `planet`, `planet_type` ";
	elseif ($USER['planet_sort'] == 2)
		$Order	= "`name` ";	
		
	$Order .= ($USER['planet_sort_order'] == 1) ? "DESC" : "ASC" ;
	
	$PlanetsRAW = $db->query("SELECT * FROM ".PLANETS." WHERE `id` != ".$PLANET['id']." AND `id_owner` = '".$USER['id']."' AND `destruyed` = '0' ORDER BY ".$Order.";");
	$PLANETS	= array($PLANET);
	
	$PlanetRess = new ResourceUpdate();
	$PlanetRess->CalcResource();
	$PlanetRess->SavePlanetToDB();
	
	while($CPLANET = $db->fetch_array($PlanetsRAW))
	{
		$PlanetRess = new ResourceUpdate();
		list($USER, $CPLANET)	= $PlanetRess->CalcResource($USER, $CPLANET, true);
		
		$PLANETS[]	= $CPLANET;
		unset($CPLANET);
	}

	$template	= new template();
	$template->loadscript("trader.js");
	
	foreach($PLANETS as $Planet)
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
			'energy_used'	=> pretty_number($Planet['energy'] + $Planet['energy_used']),
			'energy'	=> pretty_number($Planet['energy']),
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
		$ResearchList[$gid] = pretty_number($USER[$resource[$gid]]);
	}
		
	$template->assign_vars(array(
		'colspan'			=> count($PlanetsList) + 1,
		'PlanetsList'		=> $PlanetsList,
		'ResearchList'		=> $ResearchList,
		'iv_imperium_title'	=> $LNG['iv_imperium_title'],
		'iv_planet'			=> $LNG['iv_planet'],
		'iv_name'			=> $LNG['iv_name'],
		'iv_coords'			=> $LNG['iv_coords'],
		'iv_fields'			=> $LNG['iv_fields'],
		'iv_resources'		=> $LNG['iv_resources'],
		'Metal'				=> $LNG['tech'][901],
		'Crystal'			=> $LNG['tech'][902],
		'Deuterium'			=> $LNG['tech'][903],
		'Energy'			=> $LNG['tech'][911],
		'iv_buildings'		=> $LNG['iv_buildings'],
		'iv_technology'		=> $LNG['iv_technology'],
		'iv_ships'			=> $LNG['iv_ships'],
		'iv_defenses'		=> $LNG['iv_defenses'],
		'tech'				=> $LNG['tech'],
		'build'				=> $reslist['build'], 
		'fleet'				=> $reslist['fleet'], 
		'defense'			=> $reslist['defense'],
		'research'			=> $reslist['tech'],
	));

	$template->show("empire_overview.tpl");
}
?>