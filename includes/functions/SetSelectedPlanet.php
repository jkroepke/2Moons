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

	function SetSelectedPlanet ( &$CurrentUser )
	{
		global $db;

		$SelectPlanet  = request_var('cp',0);
		$RestorePlanet = request_var('re',1);

		if ($RestorePlanet == 0)
		{
			$IsPlanetMine = $db->fetch_array($db->query("SELECT `id` FROM ".PLANETS." WHERE `id` = '". $SelectPlanet ."' AND `id_owner` = '". $CurrentUser['id'] ."';"));
			if (isset($IsPlanetMine))
			{
				$CurrentUser['current_planet'] = $SelectPlanet;
				$db->query("UPDATE ".USERS." SET `current_planet` = '". $SelectPlanet ."' WHERE `id` = '".$CurrentUser['id']."';");
			}
		}
	}

?>