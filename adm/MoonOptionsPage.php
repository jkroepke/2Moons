<?php

##############################################################################
# *                                                                          #
# * 2MOONS                                                                   #
# *                                                                          #
# * @copyright Copyright (C) 2010 By ShadoX from titanspace.de               #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
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
define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

define('ROOT_PATH', './../');
include(ROOT_PATH . 'extension.inc');
include(ROOT_PATH . 'common.'.PHP_EXT);
include('AdminFunctions/Autorization.' . PHP_EXT);

if ($EditUsers != 1) die();

$parse	= $lang;


if ($_POST && $_POST['add_moon'])
{
	$PlanetID  	= $_POST['add_moon'];
	$MoonName  	= $_POST['name'];
	$Diameter	= $_POST['diameter'];
	$TempMin	= $_POST['temp_min'];
	$TempMax	= $_POST['temp_max'];
	$FieldMax	= $_POST['field_max'];
	
	$search			=	$db->fetch_array($db->query("SELECT * FROM ".PLANETS." WHERE `id` LIKE '%{$PlanetID}%';"));
	$MoonPlanet		= 	$db->fetch_array($db->query("SELECT * FROM ".PLANETS." WHERE `id` = '".$PlanetID."';"));


if ($db->num_rows($search) != 0)
{
	if ($MoonPlanet['id_luna'] == 0 && $MoonPlanet['planet_type'] == 1 && $MoonPlanet['destruyed'] == 0)
	{
		$Galaxy    = $MoonPlanet['galaxy'];
		$System    = $MoonPlanet['system'];
		$Planet    = $MoonPlanet['planet'];
		$Owner     = $MoonPlanet['id_owner'];
		$MoonID    = time();


		if ($_POST['diameter_check'] == 'on')
		{
			$SizeMin	= 4500;
			$SizeMax    = 9999;
			$size       = rand ($SizeMin, $SizeMax);
		}
		elseif ($_POST['diameter_check'] != 'on' && is_numeric($Diameter))
		{
			$size	=	$Diameter;
		}
		else
		{
			message ($lang['mo_only_numbers'], "MoonOptionsPage.php", 2);
		}
				
				
		if ($_POST['temp_check']	==	'on')
		{
			$maxtemp	= $MoonPlanet['temp_max'] - rand(10, 45);
			$mintemp	= $MoonPlanet['temp_min'] - rand(10, 45);
		}
		elseif ($_POST['temp_check']	!=	'on' && is_numeric($TempMax) && is_numeric($TempMin) )
		{
			$maxtemp	=	$TempMax;
			$mintemp	=	$TempMin;
		}
		else
		{
			message ($lang['mo_only_numbers'], "MoonOptionsPage.php", 2);
		}
			$QueryFind	=	$db->fetch_array($db->query("SELECT `id_level` FROM ".PLANETS." WHERE `id` = '".$PlanetID."';"));
			
			$QryInsertMoonInPlanet  = "INSERT INTO ".PLANETS." SET ";
			$QryInsertMoonInPlanet .= "`name` = '".$MoonName."', ";
			$QryInsertMoonInPlanet .= "`id_owner` = '". $Owner ."', ";
			$QryInsertMoonInPlanet .= "`id_level` = '". $QueryFind['id_level'] ."', ";
			$QryInsertMoonInPlanet .= "`galaxy` = '". $Galaxy ."', ";
			$QryInsertMoonInPlanet .= "`system` = '". $System ."', ";
			$QryInsertMoonInPlanet .= "`planet` = '". $Planet ."', ";
			$QryInsertMoonInPlanet .= "`last_update` = '". time() ."', ";
			$QryInsertMoonInPlanet .= "`planet_type` = '3', ";
			$QryInsertMoonInPlanet .= "`image` = 'mond', ";
			$QryInsertMoonInPlanet .= "`diameter` = '". $size ."', ";
			$QryInsertMoonInPlanet .= "`field_max` = '".$FieldMax."', ";
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
			$db->query($QryInsertMoonInPlanet);
			
			$QryGetMoonIdFromLunas  = "SELECT * FROM ".PLANETS." WHERE ";
			$QryGetMoonIdFromLunas .= "`galaxy` = '".  $Galaxy ."' AND ";
			$QryGetMoonIdFromLunas .= "`system` = '".  $System ."' AND ";
			$QryGetMoonIdFromLunas .= "`planet` = '". $Planet ."' AND ";
			$QryGetMoonIdFromLunas .= "`planet_type` = '3';";
			$PlanetRow = $db->fetch_array($db->query( $QryGetMoonIdFromLunas));

			$QryUpdateMoonInGalaxy  = "UPDATE ".PLANETS." SET ";
			$QryUpdateMoonInGalaxy .= "`id_luna` = '". $PlanetRow['id'] ."', ";
			$QryUpdateMoonInGalaxy .= "WHERE ";
			$QryUpdateMoonInGalaxy .= "`galaxy` = '". $Galaxy ."' AND ";
			$QryUpdateMoonInGalaxy .= "`system` = '". $System ."' AND ";
			$QryUpdateMoonInGalaxy .= "`planet` = '". $Planet ."' AND ";
			$QryGetMoonIdFromLunas .= "`planet_type` = '1';";
			$db->query( $QryUpdateMoonInGalaxy);
			
			message ($lang['mo_moon_added'],"MoonOptionsPage.php",2);
		}
		else
		{
			message ($lang['mo_moon_unavaible'],"MoonOptionsPage.php",2);
		}
	}
	else
	{
		message ($lang['mo_planet_doesnt_exist'],"MoonOptionsPage.php",2);
	}
}
elseif($_POST && $_POST['del_moon'])
{
	$MoonID	= $_POST['del_moon'];

	$search	=	$db->query("SELECT * FROM ".PLANETS." WHERE `id` LIKE '%{$MoonID}%';");
	if ($db->num_rows($search) != 0)
	{
		$MoonSelected  			= $db->fetch_array($db->query("SELECT * FROM ".PLANETS." WHERE `id` = '". $MoonID ."';"));
		
		if ($MoonSelected['planet_type'] == 3)
		{
			$Galaxy    = $MoonSelected['galaxy'];
			$System    = $MoonSelected['system'];
			$Planet    = $MoonSelected['planet'];
		
			$db->query("DELETE FROM ".PLANETS." WHERE `galaxy` ='".$Galaxy."' AND `system` ='".$System."' AND `planet` ='".$Planet."' AND `planet_type` = '3'");

			$QryUpdateGalaxy  = "UPDATE ".PLANETS." SET ";
			$QryUpdateGalaxy .= "`id_luna` = '0' ";
			$QryUpdateGalaxy .= "WHERE ";
			$QryUpdateGalaxy .= "`galaxy` = '". $Galaxy ."' AND ";
			$QryUpdateGalaxy .= "`system` = '". $System ."' AND ";
			$QryUpdateGalaxy .= "`planet` = '". $Planet ."' AND ";
			$QryUpdateGalaxy .= "`planet_type` = '1';";
			$QryUpdateGalaxy .= "LIMIT 1;";
			$db->query( $QryUpdateGalaxy);

			message ($lang['mo_moon_deleted'], "MoonOptionsPage.php", 2);
		}
		else
		{
			message ($lang['mo_moon_only'], "MoonOptionsPage.php", 2);
		}
	}
	else
	{
		message ($lang['mo_moon_doesnt_exist'], "MoonOptionsPage.php", 2);
	}
}
elseif($_POST && $_POST['search_moon'])
{
	$UserID		=	$_POST['search_moon'];
	$search_m	=	$db->query("SELECT id,galaxy,system,planet,name FROM ".PLANETS." WHERE `id_owner` LIKE '%{$UserID}%' AND `planet_type` = '3';");

	while ($c = $db->fetch_array($search_m))
	{
		$parse['moonlist']	.=	"<tr><td colspan=\"2\" class=\"big\">".$c['name']." [".$c['galaxy'].":".$c['system'].":".$c['planet']."] ID: ".$c['id']."</td></tr>";
	}
}

$search_u	=	$db->query("SELECT id,username FROM ".USERS.";");
while ($b = $db->fetch_array($search_u))
{
	$parse['list']	.=	"<option value=\"".$b['id']."\">".$b['username']."</option>";
}


display (parsetemplate(gettemplate("adm/MoonOptionsBody"), $parse), false, '', true, false);

?>