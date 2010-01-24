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

	function IsVacationMode($CurrentUser)
	{
		global $game_config, $db;

		if($CurrentUser['urlaubs_modus'] == 1)
		{
			$query = $db->query("SELECT id FROM ".PLANETS." WHERE id_owner = '".$CurrentUser['id']."';");

			while($id = $db->fetch_array($query))
			{
				$db->query("UPDATE ".PLANETS." SET
				metal_perhour = '".$game_config['metal_basic_income']."',
				crystal_perhour = '".$game_config['crystal_basic_income']."',
				deuterium_perhour = '".$game_config['deuterium_basic_income']."',
				metal_mine_porcent = '0',
				crystal_mine_porcent = '0',
				deuterium_sintetizer_porcent = '0',
				solar_plant_porcent = '0',
				fusion_plant_porcent = '0',
				solar_satelit_porcent = '0'
				WHERE id = '".$id['id']."' AND `planet_type` = '1';");
			}
			return true;
		}
		return false;
	}
?>