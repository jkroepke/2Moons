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

function CreateOnePlanetRecord($Galaxy, $System, $Position, $Universe, $PlanetOwnerID, $PlanetName = '', $HomeWorld = false, $AuthLevel = 0)
{
	global $LNG, $db;

	$CONF	= getConfig($Universe);

	if ($CONF['max_galaxy'] < $Galaxy || 1 > $Galaxy) {
		throw new Exception("Access denied for CreateOnePlanetRecord.php.<br>Try to create a planet at position:".$Galaxy.":".$System.":".$Position);
	}	
	
	if ($CONF['max_system'] < $System || 1 > $System) {
		throw new Exception("Access denied for CreateOnePlanetRecord.php.<br>Try to create a planet at position:".$Galaxy.":".$System.":".$Position);
	}	
	
	if ($CONF['max_planets'] < $Position || 1 > $Position) {
		throw new Exception("Access denied for CreateOnePlanetRecord.php.<br>Try to create a planet at position:".$Galaxy.":".$System.":".$Position);
	}
	
	if (CheckPlanetIfExist($Galaxy, $System, $Position, $Universe)) {
		return false;
	}

	$FieldFactor		= $CONF['planet_factor'];
	require(ROOT_PATH.'includes/PlanetData.php');
	$Pos                = ceil($Position / ($CONF['max_planets'] / count($PlanetData))); 
	$TMax				= $PlanetData[$Pos]['temp'];
	$TMin				= $TMax - 40;
	$Fields				= $PlanetData[$Pos]['fields'] * $CONF['planet_factor'];
	$Types				= array_keys($PlanetData[$Pos]['image']);
	$Type				= $Types[array_rand($Types)];
	$Class				= $Type.'planet'.($PlanetData[$Pos]['image'][$Type] < 10 ? '0' : '').$PlanetData[$Pos]['image'][$Type];
	$Name				= !empty($PlanetName) ? $db->sql_escape($PlanetName) : $LNG['type_planet'][1];
	
	$db->query("INSERT INTO ".PLANETS." SET
				name = '".$Name."',
				universe = ".$Universe.",
				id_owner = ".$PlanetOwnerID.",
				galaxy = ".$Galaxy.",
				system = ".$System.",
				planet = ".$Position.",
				last_update = ".TIMESTAMP.",
				planet_type = '1',
				image = '".$Class."',
				diameter = ".floor(1000 * sqrt($Fields)).",
				field_max = ".(($HomeWorld) ? $CONF['initial_fields'] : floor($Fields)).",
				temp_min = ".$TMin.",
				temp_max = ".$TMax.",
				metal = ".$CONF['metal_start'].",
				metal_perhour = ".$CONF['metal_basic_income'].",
				crystal = 0,
				crystal_perhour = ".$CONF['crystal_basic_income'].",
				deuterium = ".$CONF['deuterium_start'].",
				deuterium_perhour = ".$CONF['deuterium_basic_income'].";");

	return $db->GetInsertID();
}
?>