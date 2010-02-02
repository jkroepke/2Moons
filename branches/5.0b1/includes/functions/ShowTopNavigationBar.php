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

	function ShowTopNavigationBar ($CurrentUser, $CurrentPlanet)
	{
		global $lang, $game_config, $dpath, $db;

		if($CurrentUser['urlaubs_modus'] == 0)
			PlanetResourceUpdate($CurrentUser, $CurrentPlanet, time());
		else
			$db->query("UPDATE ".PLANETS." SET `deuterium_sintetizer_porcent` = 0, `metal_mine_porcent` = 0, `crystal_mine_porcent` = 0 WHERE id_owner = ".$CurrentUser['id']);

		$parse				 			= $lang;
		$parse['dpath']      			= $dpath;
		$parse['image']      			= $CurrentPlanet['image'];
		$parse['show_umod_notice']  	= $CurrentUser['urlaubs_modus'] ? '<table width="100%" style="border: 3px solid red; text-align:center;"><tr><td>' . $lang['tn_vacation_mode'] . date('d.m.Y h:i:s',$CurrentUser['urlaubs_until']).'</td></tr></table>' : '';
		$parse['show_umod_notice']		= $CurrentUser['db_deaktjava'] ? '<table width="100%" style="border: 3px solid red; text-align:center;"><tr><td>' . $lang['tn_delete_mode'] . date('d.m.Y h:i:s',$CurrentUser['db_deaktjava'] + (60 * 60 * 24 * 7)).'</td></tr></table>' : '';
		$parse['planetlist'] 			= '';
		$ThisUsersPlanets    			= SortUserPlanets ( $CurrentUser );
		$mode							= request_var('mode','');
		$page							= request_var('page','');
		$gid							= request_var('gid','');
		foreach ($ThisUsersPlanets as $CurPlanet)
		{
			$parse['planetlist'] .= "\n<option ";
			if ($CurPlanet['id'] == $CurrentUser['current_planet'])
				$parse['planetlist'] .= "selected=\"selected\" ";
			
			$parse['planetlist'] .= "value=\"game.php?page=".$page."&amp;gid=".$gid."&amp;cp=".$CurPlanet['id']."";
			$parse['planetlist'] .= "&amp;mode=".$mode;
			$parse['planetlist'] .= "&amp;re=0\">";
			if($CurPlanet['planet_type'] != 3)
				$parse['planetlist'] .= "".$CurPlanet['name'];
			else
				$parse['planetlist'] .= "".$CurPlanet['name'] . " (" . $lang['fcm_moon'] . ")";
			
			$parse['planetlist'] .= "&nbsp;[".$CurPlanet['galaxy'].":";
			$parse['planetlist'] .= "".$CurPlanet['system'].":";
			$parse['planetlist'] .= "".$CurPlanet['planet'];
			$parse['planetlist'] .= "]&nbsp;&nbsp;</option>";
		}

		$energy 					= pretty_number($CurrentPlanet["energy_max"] + $CurrentPlanet["energy_used"]) . "/" . pretty_number($CurrentPlanet["energy_max"]);

		$parse['energy']			= (($CurrentPlanet["energy_max"] + $CurrentPlanet["energy_used"]) < 0) ? colorRed($energy) : $energy ;
		$parse['metal']				= ($CurrentPlanet["metal"] >= $CurrentPlanet["metal_max"]) ? colorRed(pretty_number($CurrentPlanet["metal"])) : pretty_number($CurrentPlanet["metal"]);
		$parse["crystal"] 			= ($CurrentPlanet["crystal"] >= $CurrentPlanet["crystal_max"]) ? colorRed(pretty_number($CurrentPlanet["crystal"])) : pretty_number($CurrentPlanet["crystal"]);
		$parse['deuterium'] 		= ($CurrentPlanet["deuterium"] >= $CurrentPlanet["deuterium_max"]) ? colorRed(pretty_number($CurrentPlanet["deuterium"])) : pretty_number($CurrentPlanet["deuterium"]);
		$parse['darkmatter'] 		= pretty_number($CurrentUser["darkmatter"]);
		$parse['metal_max'] 		= pretty_number($CurrentPlanet["metal_max"]);
		$parse['crystal_max'] 		= pretty_number($CurrentPlanet["crystal_max"]);
		$parse['deuterium_max'] 	= pretty_number($CurrentPlanet["deuterium_max"]);
		$parse['js_metal_hr']		= $CurrentPlanet['metal_perhour'];
		$parse['js_crystal_hr']		= $CurrentPlanet['crystal_perhour'];
		$parse['js_deuterium_hr']	= $CurrentPlanet['deuterium_perhour'];
		$TopBar 			 		= parsetemplate(gettemplate('global/overall_topnav'), $parse);

		return $TopBar;
	}
?>