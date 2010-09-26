<?php

##############################################################################
# *                                                                          #
# * 2MOONS                                                                   #
# *                                                                          #
# * @copyright Copyright (C) 2010 By ShadoX from titanspace.de               #
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

define('INSIDE', true );
define('INSTALL', false );
define('AJAX', true );

define('ROOT_PATH', str_replace('\\', '/',dirname(__FILE__)).'/');
	
include_once(ROOT_PATH . 'extension.inc');
include_once(ROOT_PATH . 'common.' . PHP_EXT);
$SESSION       	= new Session();

if(!$SESSION->IsUserLogin() || ($CONF['game_disable'] == 0 && $_SESSION['authlevel'] == 0))
	exit(json_encode(array()));

includeLang('INGAME');
	
$action	= request_var('action', '');
switch($action)
{
	case 'getfleets':
		$OwnFleets = $db->query("SELECT DISTINCT * FROM ".FLEETS." WHERE `fleet_owner` = '".$_SESSION['id']."' OR `fleet_target_owner` = '".$_SESSION['id']."';");
		$Record = 0;
		if($db->num_rows($OwnFleets) > 0){
			require_once(ROOT_PATH . 'includes/classes/class.FlyingFleetsTable.' . PHP_EXT);
			$FlyingFleetsTable = new FlyingFleetsTable();
		}
		
		$ACSDone	= array();
		$FleetData 	= array();
		while ($FleetRow = $db->fetch_array($OwnFleets))
		{
			$Record++;
			$IsOwner	= ($FleetRow['fleet_owner'] == $_SESSION['id']) ? true : false;
			
			if ($FleetRow['fleet_mess'] == 0 && $FleetRow['fleet_start_time'] > TIMESTAMP && ($FleetRow['fleet_group'] == 0 || !in_array($FleetRow['fleet_group'], $ACSDone)))
			{
				$ACSDone[]		= $FleetRow['fleet_group'];
				
				$FleetData[$FleetRow['fleet_start_time'].$FleetRow['fleet_id']] = $FlyingFleetsTable->BuildFleetEventTable($FleetRow, 0, $IsOwner, 'fs', $Record, true);
			}

			if ($FleetRow['fleet_mission'] == 10 || ($FleetRow['fleet_mission'] == 4 && $FleetRow['fleet_mess'] == 0))
				continue;

			if ($FleetRow['fleet_mess'] != 1 && $FleetRow['fleet_end_stay'] > TIMESTAMP)
				$FleetData[$FleetRow['fleet_end_stay'].$FleetRow['fleet_id']] = $FlyingFleetsTable->BuildFleetEventTable($FleetRow, 2, $IsOwner, 'ft', $Record);
		
			if ($IsOwner == false)
				continue;
		
			if ($FleetRow['fleet_end_time'] > TIMESTAMP)
				$FleetData[$FleetRow['fleet_end_time'].$FleetRow['fleet_id']] = $FlyingFleetsTable->BuildFleetEventTable($FleetRow, 1, $IsOwner, 'fe', $Record);
		}
		$db->free_result($OwnFleets);
		ksort($FleetData);
		echo json_encode($FleetData);
		exit;
	break;
	case 'fleet1':
		includeLang('TECH');
		$USER							= $db->uniquequery("SELECT u.`".$resource[124]."`, p.`galaxy`, p.`system`, p.`planet`, p.`planet_type` FROM ".USERS." as u, ".PLANETS." as p WHERE p.`id` = '".$_SESSION['planet']."' AND u.`id` = '".$_SESSION['id']."';");
		$TargetGalaxy 					= request_var('galaxy', $USER['galaxy']);
		$TargetSystem 					= request_var('system', $USER['system']);
		$TargetPlanet					= request_var('planet', $USER['planet']);
		$TargetPlanettype 				= request_var('planet_type', $USER['planet_type']);
		
		if($TargetGalaxy == $USER['galaxy'] && $TargetSystem == $USER['system'] && $TargetPlanet == $USER['planet'] && $TargetPlanettype == $USER['planet_type'])
			exit($LNG['fl_error_same_planet']);
		
		if ($TargetPlanet != 16) {
			$Data	= $db->uniquequery("SELECT u.`urlaubs_modus`, p.`id_level`, p.`destruyed`, p.`der_metal`, p.`der_crystal`, p.`destruyed` FROM ".USERS." as u, ".PLANETS." as p WHERE p.`galaxy` = '".$TargetGalaxy."' AND p.`system` = '".$TargetSystem."' AND p.`planet` = '".$TargetPlanet."'  AND p.`planet_type` = '".(($TargetPlanettype == 2) ? 1 : $TargetPlanettype)."' AND `u`.`id` = p.`id_owner`;");
			if ($TargetPlanettype == 3 && !isset($Data))
				exit($LNG['fl_error_no_moon']);
			elseif ($Data['urlaubs_modus'])
				exit($LNG['fl_in_vacation_player']);
			elseif ($Data['id_level'] > $_SESSION['authlevel'])
				exit($LNG['fl_admins_cannot_be_attacked']);
			elseif ($Data['destruyed'] != 0)
				exit($LNG['fl_error_not_avalible']);
			elseif($TargetPlanettype == 2 && $Data['der_metal'] == 0 && $Data['der_crystal'] == 0)
				exit($LNG['fl_error_empty_derbis']);
		} else {
			if ($USER[$resource[124]] == 0)
				exit($LNG['fl_expedition_tech_required']);
			
			$ActualFleets = $db->uniquequery("SELECT COUNT(*) as state FROM ".FLEETS." WHERE `fleet_owner` = '".$_SESSION['id']."' AND `fleet_mission` = '15';");

			if ($ActualFleets['state'] >= floor(sqrt($USER[$resource[124]])))
				exit($LNG['fl_expedition_fleets_limit']);
		}
		exit('OK');
	break;
}
?>