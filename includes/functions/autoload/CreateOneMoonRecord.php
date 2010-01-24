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

if(!defined('INSIDE')){ die(header("location:../../"));}

	function CreateOneMoonRecord ( $Galaxy, $System, $Planet, $Owner, $MoonID, $MoonName, $Chance)
	{
		global $lang, $user, $db;

		$PlanetName            = "";

		$QryGetMoonPlanetData  = "SELECT id_luna,id_level,planet_type,id,name,temp_max,temp_min FROM ".PLANETS." ";
		$QryGetMoonPlanetData .= "WHERE ";
		$QryGetMoonPlanetData .= "`galaxy` = '". $Galaxy ."' AND ";
		$QryGetMoonPlanetData .= "`system` = '". $System ."' AND ";
		$QryGetMoonPlanetData .= "`planet` = '". $Planet ."';";
		$MoonPlanet = $db->fetch_array($db->query ( $QryGetMoonPlanetData));

		if ($MoonPlanet['id_luna'] == 0 && $MoonPlanet['id'] != 0 && $MoonPlanet['planet_type'] == 1)
		{
			$SizeMin                = zround(pow ((3 * $Chance)+10,0.5) * 1000 );
			$SizeMax                = zround(pow ((3 * $Chance)+20,0.5) * 1000 );

			$PlanetName             = $MoonPlanet['name'];

			$maxtemp                = $MoonPlanet['temp_max'] - rand(10, 45);
			$mintemp                = $MoonPlanet['temp_min'] - rand(10, 45);
			$size                   = rand ($SizeMin, $SizeMax);

			$QryInsertMoonInPlanet  = "INSERT INTO ".PLANETS." SET ";
			$QryInsertMoonInPlanet .= "`name` = '". ( ($MoonName == '') ? $lang['fcm_moon'] : $MoonName ) ."', ";
			$QryInsertMoonInPlanet .= "`id_owner` = '". $Owner ."', ";
			$QryInsertMoonInPlanet .= "`id_level` = '".$MoonPlanet['id_level']."', ";
			$QryInsertMoonInPlanet .= "`galaxy` = '". $Galaxy ."', ";
			$QryInsertMoonInPlanet .= "`system` = '". $System ."', ";
			$QryInsertMoonInPlanet .= "`planet` = '". $Planet ."', ";
			$QryInsertMoonInPlanet .= "`last_update` = '". time() ."', ";
			$QryInsertMoonInPlanet .= "`planet_type` = '3', ";
			$QryInsertMoonInPlanet .= "`image` = 'mond', ";
			$QryInsertMoonInPlanet .= "`diameter` = '". $size ."', ";
			$QryInsertMoonInPlanet .= "`field_max` = '1', ";
			$QryInsertMoonInPlanet .= "`temp_min` = '". $mintemp ."', ";
			$QryInsertMoonInPlanet .= "`temp_max` = '". $maxtemp ."', ";
			$QryInsertMoonInPlanet .= "`metal` = '0', ";
			$QryInsertMoonInPlanet .= "`metal_perhour` = '0', ";
			$QryInsertMoonInPlanet .= "`metal_max` = '".BASE_STORAGE_SIZE."', ";
			$QryInsertMoonInPlanet .= "`crystal` = '0', ";
			$QryInsertMoonInPlanet .= "`crystal_perhour` = '0', ";
			$QryInsertMoonInPlanet .= "`crystal_max` = '".BASE_STORAGE_SIZE."', ";
			$QryInsertMoonInPlanet .= "`deuterium` = '0', ";
			$QryInsertMoonInPlanet .= "`deuterium_perhour` = '0', ";
			$QryInsertMoonInPlanet .= "`deuterium_max` = '".BASE_STORAGE_SIZE."';";
			$db->query( $QryInsertMoonInPlanet , 'planets');
				
			$QryGetMoonPlanetData  = "SELECT id FROM ".PLANETS." ";
			$QryGetMoonPlanetData .= "WHERE ";
			$QryGetMoonPlanetData .= "`galaxy` = '". $Galaxy ."' AND ";
			$QryGetMoonPlanetData .= "`system` = '". $System ."' AND ";
			$QryGetMoonPlanetData .= "`planet` = '". $Planet ."' AND ";
			$QryGetMoonPlanetData .= "`planet_type` = '3';";
			$Moonid = $db->fetch_array($db->query ($QryGetMoonPlanetData));
				

			$QryUpdateMoonInGalaxy  = "UPDATE ".PLANETS." SET ";
			$QryUpdateMoonInGalaxy .= "`id_luna` = '". $Moonid['id'] ."' ";
			$QryUpdateMoonInGalaxy .= "WHERE ";
			$QryUpdateMoonInGalaxy .= "`galaxy` = '". $Galaxy ."' AND ";
			$QryUpdateMoonInGalaxy .= "`system` = '". $System ."' AND ";
			$QryUpdateMoonInGalaxy .= "`planet` = '". $Planet ."' AND ";
			$QryUpdateMoonInGalaxy .= "`planet_type` = '1';";				
			$db->query( $QryUpdateMoonInGalaxy);
		}

		return $PlanetName;
	}

?>