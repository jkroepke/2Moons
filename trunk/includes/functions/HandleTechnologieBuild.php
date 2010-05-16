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

	function HandleTechnologieBuild ( &$CurrentPlanet, &$CurrentUser )
	{
		global $resource, $db;

		if ($CurrentUser['b_tech_planet'] != 0)
		{
			if ($CurrentUser['b_tech_planet'] != $CurrentPlanet['id'])
				$WorkingPlanet = $db->fetch_array($db->query("SELECT id, b_tech, b_tech_id, name, metal, crystal, deuterium FROM ".PLANETS." WHERE `id` = '". $CurrentUser['b_tech_planet'] ."';"));

			if ($WorkingPlanet)
				$ThePlanet = $WorkingPlanet;
			else
				$ThePlanet = $CurrentPlanet;

			if ($ThePlanet['b_tech'] <= time() && $ThePlanet['b_tech_id'] != 0)
			{
				$CurrentUser[$resource[$ThePlanet['b_tech_id']]]++;

				$QryUpdate  = "UPDATE ".PLANETS." SET ";
				$QryUpdate .= "`b_tech` = '0', ";
				$QryUpdate .= "`b_tech_id` = '0' ";
				$QryUpdate .= "WHERE ";
				$QryUpdate .= "`id` = '". $ThePlanet['id'] ."';";
				$QryUpdate .= "UPDATE ".USERS." SET ";
				$QryUpdate .= "`".$resource[$ThePlanet['b_tech_id']]."` = '". $CurrentUser[$resource[$ThePlanet['b_tech_id']]] ."', ";
				$QryUpdate .= "`b_tech_planet` = '0' ";
				$QryUpdate .= "WHERE ";
				$QryUpdate .= "`id` = '". $CurrentUser['id'] ."';";
				$db->multi_query($QryUpdate);
								
				$ThePlanet["b_tech_id"] = 0;

				if (isset($WorkingPlanet))
					$WorkingPlanet = $ThePlanet;
				else
					$CurrentPlanet = $ThePlanet;

				$Result['WorkOn'] = "";
				$Result['OnWork'] = false;
			}
			elseif ($ThePlanet["b_tech_id"] == 0)
			{
				$db->query("UPDATE ".USERS." SET `b_tech_planet` = '0'  WHERE `id` = '". $CurrentUser['id'] ."';");
				$Result['WorkOn'] = "";
				$Result['OnWork'] = false;
			}
			else
			{
				$Result['WorkOn'] = $ThePlanet;
				$Result['OnWork'] = true;
			}
		}
		else
		{
			$Result['WorkOn'] = "";
			$Result['OnWork'] = false;
		}

		return $Result;
	}
?>