<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
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
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.0 (2012-12-31)
 * @info $Id$
 * @link http://2moons.cc/
 */

function CreateOneMoonRecord($Galaxy, $System, $Planet, $Universe, $Owner, $MoonName, $Chance, $time = 0, $Size = 0)
{
	global $USER;

	$SQL  = "SELECT id_luna,planet_type,id,name,temp_max,temp_min FROM ".PLANETS." ";
	$SQL .= "WHERE ";
	$SQL .= "universe = '".$Universe."' AND ";
	$SQL .= "galaxy = '".$Galaxy."' AND ";
	$SQL .= "system = '".$System."' AND ";
	$SQL .= "planet = '".$Planet."' AND ";
	$SQL .= "planet_type = '1';";
	$MoonPlanet = $GLOBALS['DATABASE']->getFirstRow($SQL);

	if ($MoonPlanet['id_luna'] != 0)
		return false;

	if($Size == 0) {
		$size	= floor(pow(mt_rand(10, 20) + 3 * $Chance, 0.5) * 1000); # New Calculation - 23.04.2011
	} else {
		$size	= $Size;
	}
	
	$maxtemp	= $MoonPlanet['temp_max'] - mt_rand(10, 45);
	$mintemp	= $MoonPlanet['temp_min'] - mt_rand(10, 45);

	$GLOBALS['DATABASE']->multi_query("INSERT INTO ".PLANETS." SET
					  name = '".$MoonName."',
					  id_owner = ".$Owner.",
					  universe = ".$Universe.",
					  galaxy = ".$Galaxy.",
					  system = ".$System.",
					  planet = ".$Planet.",
					  last_update = ".TIMESTAMP.",
					  planet_type = '3',
					  image = 'mond',
					  diameter = ".$size.",
					  field_max = '1',
					  temp_min = ".$mintemp.",
					  temp_max = ".$maxtemp.",
					  metal = 0,
					  metal_perhour = 0,
					  crystal = 0,
					  crystal_perhour = 0,
					  deuterium = 0,
					  deuterium_perhour = 0;
					  SET @moonID = LAST_INSERT_ID();
					  UPDATE ".PLANETS." SET
					  id_luna = @moonID
					  WHERE
					  id = ".$MoonPlanet['id'].";");

	return true;
}

?>