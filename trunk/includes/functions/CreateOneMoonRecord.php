<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
# *																			 #
# *																			 #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.									 #
# *																			 #
# *  This program is distributed in the hope that it will be useful,		 #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of			 #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 #
# *  GNU General Public License for more details.							 #
# *																			 #
##############################################################################

if(!defined('INSIDE')) die('Hacking attempt!');

	function CreateOneMoonRecord($Galaxy, $System, $Planet, $Owner, $MoonID, $MoonName, $Chance)
	{
		global $LNG, $USER, $db;

		$SQL  = "SELECT id_luna,id_level,planet_type,id,name,temp_max,temp_min FROM ".PLANETS." ";
		$SQL .= "WHERE ";
		$SQL .= "`galaxy` = '". $Galaxy ."' AND ";
		$SQL .= "`system` = '". $System ."' AND ";
		$SQL .= "`planet` = '". $Planet ."' AND ";
		$SQL .= "`planet_type` = '1';";
		$MoonPlanet = $db->uniquequery($SQL);

		if ($MoonPlanet['id_luna'] != 0)
			return false;

		$SizeMin                = round(pow((3 * $Chance) + 10, 0.5) * 1000);
		$SizeMax                = round(pow((3 * $Chance) + 20, 0.5) * 1000);

		$maxtemp                = $MoonPlanet['temp_max'] - mt_rand(10, 45);
		$mintemp                = $MoonPlanet['temp_min'] - mt_rand(10, 45);
		$size                   = rand($SizeMin, $SizeMax);

		$SQL  = "INSERT INTO ".PLANETS." SET ";
		$SQL .= "`name` = '". ( ($MoonName == '') ? $LNG['fcm_moon'] : $MoonName ) ."', ";
		$SQL .= "`id_owner` = '". $Owner ."', ";
		$SQL .= "`id_level` = '".$MoonPlanet['id_level']."', ";
		$SQL .= "`galaxy` = '". $Galaxy ."', ";
		$SQL .= "`system` = '". $System ."', ";
		$SQL .= "`planet` = '". $Planet ."', ";
		$SQL .= "`last_update` = '". TIMESTAMP ."', ";
		$SQL .= "`planet_type` = '3', ";
		$SQL .= "`image` = 'mond', ";
		$SQL .= "`diameter` = '". $size ."', ";
		$SQL .= "`field_max` = '1', ";
		$SQL .= "`temp_min` = '". $mintemp ."', ";
		$SQL .= "`temp_max` = '". $maxtemp ."', ";
		$SQL .= "`metal` = '0', ";
		$SQL .= "`metal_perhour` = '0', ";
		$SQL .= "`metal_max` = '".BASE_STORAGE_SIZE."', ";
		$SQL .= "`crystal` = '0', ";
		$SQL .= "`crystal_perhour` = '0', ";
		$SQL .= "`crystal_max` = '".BASE_STORAGE_SIZE."', ";
		$SQL .= "`deuterium` = '0', ";
		$SQL .= "`deuterium_perhour` = '0', ";
		$SQL .= "`deuterium_max` = '".BASE_STORAGE_SIZE."';";
		$db->query($SQL);
				
		$SQL  = "SELECT id FROM ".PLANETS." ";
		$SQL .= "WHERE ";
		$SQL .= "`galaxy` = '". $Galaxy ."' AND ";
		$SQL .= "`system` = '". $System ."' AND ";
		$SQL .= "`planet` = '". $Planet ."' AND ";
		$SQL .= "`planet_type` = '3';";
		$Moonid = $db->uniquequery($SQL);
				
		$SQL  = "UPDATE ".PLANETS." SET ";
		$SQL .= "`id_luna` = '". $Moonid['id'] ."' ";
		$SQL .= "WHERE ";
		$SQL .= "`galaxy` = '". $Galaxy ."' AND ";
		$SQL .= "`system` = '". $System ."' AND ";
		$SQL .= "`planet` = '". $Planet ."' AND ";
		$SQL .= "`planet_type` = '1';";				
		$db->query($SQL);

		return $MoonPlanet['name'];
	}

?>