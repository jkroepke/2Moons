<?php

##############################################################################
# *																			 #
# * RN FRAMEWORK															 #
# *  																		 #
# * @copyright Copyright (C) 2009 By ShadoX from xnova-reloaded.de	    	 #
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

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

define('ROOT_PATH', './../');
include(ROOT_PATH . 'extension.inc');
include(ROOT_PATH . 'common.' . PHP_EXT);
include('AdminFunctions/Autorization.' . PHP_EXT);

if ($EditUsers != 1) die();

	$parse = $lang;
	$query = $db->query("SELECT `id`, `id_owner`, `name`,  `field_current`, `field_max`, `galaxy`, `system`, `planet` FROM ".PLANETS." WHERE planet_type=1 ORDER BY id ASC");
	$i = 0;
	while ($u = $db->fetch_array($query)) {
		$parse['planetes'] .= "<tr>"
		. "<td class=b><center><b><a href='?action=edit&id=".$u['id'] ."'>" . $u['id'] . "</a></center></b></td>"
		. "<td class=b><center><b><a href='?action=edit&id=".$u['id'] ."'>" . $u['id_owner'] . "</a></center></b></td>"
		. "<td class=b><center><b><a href='?action=edit&id=".$u['id'] ."'>" . $u['name'] . "</a></center></b></td>"
		. "<td class=b><center><b><a href='?action=edit&id=".$u['id'] ."'>" . $u['field_max'] . "</a></center></b></td>"
		. "<td class=b><center><b><a href='?action=edit&id=".$u['id'] ."'>" . $u['field_current'] . "</a></center></b></td>"
		. "<td class=b><center><b><a href='?action=edit&id=".$u['id'] ."'>" . $u['galaxy'] . "</a></center></b></td>"
		. "<td class=b><center><b><a href='?action=edit&id=".$u['id'] ."'>" . $u['system'] . "</a></center></b></td>"
		. "<td class=b><center><b><a href='?action=edit&id=".$u['id'] ."'>" . $u['planet'] . "</a></center></b></td>"
		. "</tr>";
		$i++;
	}

	if ($i == "1")
	$parse['planetes'] .= "<tr><th class=b colspan=8>Insgesamt 1 Planet</th></tr>";
	else
	$parse['planetes'] .= "<tr><th class=b colspan=8>Insgesamt {$i} Planeten</th></tr>";

	if(isset($_GET['action']) && isset($_GET['id'])) {
		$id 	= intval($_GET['id']);
		$query  = $db->query("SELECT * FROM ".PLANETS." WHERE planet_type=1 AND id='".$id."' LIMIT 1");
		$parse 	= array_merge($db->fetch_array($query), $lang);
		
		$parse['show_edit_form'] = parsetemplate(gettemplate('adm/PlanetListEdit'),$parse);
	}
	if(isset($_POST['submit'])) {

		$edit_id 	= intval($_POST['currid']);
		$planetname = $db->sql_escape($_POST['planetname']);
		$fields_max = intval($_POST['felder']);
		$db->query("UPDATE ".PLANETS." SET
							`name` 				= '".$planetname."', 
							`field_max` 		= '".$fields_max."',
							`metal`				= '".$_POST['metal']."',
							`crystal`			= '".$_POST['crystal']."',
							`deuterium`			= '".$_POST['deuterium']."', 
							`small_ship_cargo` 	= '".$_POST['small_ship_cargo']."', 
							`big_ship_cargo` 	= '".$_POST['big_ship_cargo']."', 
							`light_hunter`		= '".$_POST['light_hunter']."', 
							`heavy_hunter`		= '".$_POST['heavy_hunter']."', 
							`crusher`			= '".$_POST['crusher']."', 
							`battle_ship`		= '".$_POST['battle_ship']."', 
							`colonizer`			= '".$_POST['colonizer']."', 
							`recycler`			= '".$_POST['recycler']."', 
							`spy_sonde`			= '".$_POST['spy_sonde']."', 
							`bomber_ship`		= '".$_POST['bomber_ship']."', 
							`solar_satelit`		= '".$_POST['solar_satelit']."', 
							`destructor`		= '".$_POST['destructor']."', 
							`dearth_star`		= '".$_POST['dearth_star']."', 
							`lune_noir`			= '".$_POST['lune_noir']."',
							`ev_transporter`	= '".$_POST['ev_transporter']."',
							`star_crasher`		= '".$_POST['star_crasher']."',
							`giga_recykler`		= '".$_POST['giga_recykler']."',
							`dm_ship`			= '".$_POST['dm_ship']."',
							`misil_launcher`	= '".$_POST['misil_launcher']."',
							`small_laser`		= '".$_POST['small_laser']."',
							`big_laser`			= '".$_POST['big_laser']."',
							`gauss_canyon`		= '".$_POST['gauss_canyon']."',
							`ionic_canyon`		= '".$_POST['ionic_canyon']."',
							`buster_canyon`		= '".$_POST['buster_canyon']."',
							`small_protection_shield` 	= '".$_POST['small_protection_shield']."',
							`big_protection_shield` 	= '".$_POST['big_protection_shield']."',
							`interceptor_misil` 		= '".$_POST['interceptor_misil']."',
							`interplanetary_misil` 		= '".$_POST['interplanetary_misil']."',
							`metal_mine`				= '".$_POST['metal_mine']."',
							`crystal_mine`				= '".$_POST['crystal_mine']."',
							`deuterium_sintetizer`		= '".$_POST['deuterium_sintetizer']."',
							`solar_plant`				= '".$_POST['solar_plant']."',
							`fusion_plant`				= '".$_POST['fusion_plant']."',
							`robot_factory`				= '".$_POST['robot_factory']."',
							`nano_factory`				= '".$_POST['nano_factory']."',
							`hangar`					= '".$_POST['hangar']."',
							`metal_store`				= '".$_POST['metal_store']."',
							`crystal_store`				= '".$_POST['crystal_store']."',
							`deuterium_store`			= '".$_POST['deuterium_store']."',
							`laboratory`				= '".$_POST['laboratory']."',
							`terraformer`				= '".$_POST['terraformer']."',
							`ally_deposit`				= '".$_POST['ally_deposit']."',
							`silo`						= '".$_POST['silo']."'
							  WHERE `id` = '".$edit_id."';");
		// AdminLOG - Helmchen
		$fp = @fopen('logs/adminlog_'.date('d.m.Y').'.txt','a');
		fwrite($fp,date("d.m.Y H:i:s",time())." - ".$user['username']." - ".$user['user_lastip']." - ".__FILE__." - changed values from planet with ID: ".$edit_id."\n");
		fclose($fp);
		// AdminLOG ENDE

		header("location:PlanetListPage.php");
	}
	display(parsetemplate(gettemplate('adm/PlanetListBody'), $parse), false, '', true, false);

// Created by e-Zobar. All rights reversed (C) XNova Team 2008
?>