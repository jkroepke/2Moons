<?php

/**
 *  2Moons
 *  Copyright (C) 2011  Slaver
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
 * @author Slaver <slaver7@gmail.com>
 * @copyright 2009 Lucky <lucky@xgproyect.net> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.5 (2011-07-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */


function GetTeamspeakData()
{
	global $CONF, $USER, $LNG;
	if ($CONF['ts_modon'] == 0)
		return false;
	elseif(!file_exists(ROOT_PATH.'cache/teamspeak_cache.php'))
		return $LNG['ov_teamspeak_not_online'];
	
	$Data		= unserialize(file_get_contents(ROOT_PATH.'cache/teamspeak_cache.php'));
	if(!is_array($Data))
		return $LNG['ov_teamspeak_not_online'];
		
	$Teamspeak 	= '';			

	if($CONF['ts_version'] == 2) {
		$trafges 	= pretty_number($Data[1]['total_bytessend'] / 1048576 + $Data[1]['total_bytesreceived'] / 1048576);
		$Teamspeak	= sprintf($LNG['ov_teamspeak_v2'], $CONF['ts_server'], $CONF['ts_udpport'], $USER['username'], $Data[0]["server_currentusers"], $Data[0]["server_maxusers"], $Data[0]["server_currentchannels"], $trafges);
	} elseif($CONF['ts_version'] == 3){
		$trafges 	= pretty_number($Data['data']['connection_bytes_received_total'] / 1048576 + $Data['data']['connection_bytes_sent_total'] / 1048576);
		$Teamspeak	= sprintf($LNG['ov_teamspeak_v3'], $CONF['ts_server'], $CONF['ts_tcpport'], $USER['username'], $Data['data']['virtualserver_password'], ($Data['data']['virtualserver_clientsonline'] - 1), $Data['data']['virtualserver_maxclients'], $Data['data']['virtualserver_channelsonline'], $trafges);
	}
	return $Teamspeak;
}

function GetFleets() {
	global $USER, $db;
	$OwnFleets = $db->query("SELECT DISTINCT * FROM ".FLEETS." WHERE `fleet_owner` = ".$USER['id']." OR `fleet_target_owner` = ".$USER['id'].";");
	$Record = 0;
	if($db->num_rows($OwnFleets) == 0)
		return array();
	
	require_once(ROOT_PATH . 'includes/classes/class.FlyingFleetsTable.php');
	$FlyingFleetsTable = new FlyingFleetsTable();
	
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
	foreach($FleetData as $key => $Val) {
		if(empty($FleetData[$key]['fleet_descr']))
			unset($FleetData[$key]);
	}
	ksort($FleetData);
	return $FleetData;
}
function ShowOverviewPage()
{
	global $CONF, $LNG, $PLANET, $USER, $db, $resource, $UNI;
	$PlanetRess = new ResourceUpdate();
	$PlanetRess->CalcResource();
	$PlanetRess->SavePlanetToDB();
	
	$template		= new template();	
	$AdminsOnline 	= array();
	$AllPlanets		= array();
	$Moon 			= array();
	$RefLinks		= array();
	$Buildtime		= 0;
	
	foreach($USER['PLANETS'] as $ID => $CPLANET)
	{		
		if ($ID == $_SESSION['planet'] || $CPLANET['planet_type'] == 3)
			continue;

		if (!empty($CPLANET['b_building']) && $CPLANET['b_building'] > TIMESTAMP) {
			$Queue				= unserialize($CPLANET['b_building_id']);
			$BuildPlanet		= $LNG['tech'][$Queue[0][0]]." (".$Queue[0][1].")<br><span style=\"color:#7F7F7F;\">(".pretty_time($Queue[0][3] - TIMESTAMP).")</span>";
		} else {
			$BuildPlanet     = $LNG['ov_free'];
		}
		
		$AllPlanets[] = array(
			'id'	=> $CPLANET['id'],
			'name'	=> $CPLANET['name'],
			'image'	=> $CPLANET['image'],
			'build'	=> $BuildPlanet,
		);
	}
	
	if ($PLANET['id_luna'] != 0)
		$Moon		= $db->uniquequery("SELECT `id`, `name` FROM ".PLANETS." WHERE `id` = '".$PLANET['id_luna']."';");

	if ($PLANET['b_building'] - TIMESTAMP > 0) {
		$Queue		= unserialize($PLANET['b_building_id']);
		$Build		= $LNG['tech'][$Queue[0][0]].' ('.$Queue[0][1].')<br><div id="blc">'.pretty_time($PLANET['b_building'] - TIMESTAMP).'</div>';
		$Buildtime	= $PLANET['b_building'] - TIMESTAMP;
		$template->execscript('BuildTime();');
	}
	else
	{
		$Build 		= $LNG['ov_free'];
	}
	
	$OnlineAdmins 	= $db->query("SELECT `id`,`username` FROM ".USERS." WHERE `universe` = ".$UNI." AND `onlinetime` >= ".(TIMESTAMP-10*60)." AND `authlevel` > '".AUTH_USR."';");
	while ($AdminRow = $db->fetch_array($OnlineAdmins)) {
		$AdminsOnline[$AdminRow['id']]	= $AdminRow['username'];
	}

	$db->free_result($OnlineAdmins);
	
	$template->loadscript('overview.js');

	$Messages		= $db->countquery("SELECT COUNT(*) FROM ".MESSAGES." WHERE `message_owner` = ".$USER['id']." AND `message_unread` = '1'");
	
	// Fehler: Wenn Spieler gelöscht werden, werden sie nicht mehr in der Tabelle angezeigt.
	$RefLinksRAW	= $db->query("SELECT u.`id`, u.`username`, s.`total_points` FROM ".USERS." as u LEFT JOIN ".STATPOINTS." as s ON s.`id_owner` = u.`id` AND s.`stat_type` = '1' WHERE `ref_id` = ".$USER['id'].";");
	
	if($CONF['ref_active']) 
	{
		while ($RefRow = $db->fetch_array($RefLinksRAW)) {
			$RefLinks[$RefLinks['id']]	= array(
				'username'	=> $RefLinks['username'],
				'points'	=> $RefLinks['total_points']
			);
		}
	}
	
	$template->assign_vars(array(
		'user_rank'					=> sprintf($LNG['ov_userrank_info'], pretty_number($USER['total_points']), $LNG['ov_place'], $USER['total_rank'], $USER['total_rank'], $LNG['ov_of'], $CONF['users_amount']),
		'is_news'					=> $CONF['OverviewNewsFrame'],
		'news'						=> makebr($CONF['OverviewNewsText']),
		'planetname'				=> $PLANET['name'],
		'planetimage'				=> $PLANET['image'],
		'galaxy'					=> $PLANET['galaxy'],
		'system'					=> $PLANET['system'],
		'planet'					=> $PLANET['planet'],
		'buildtime'					=> $Buildtime,
		'userid'					=> $USER['id'],
		'username'					=> $USER['username'],
		'build'						=> $Build,
		'Moon'						=> $Moon,
		'fleets'					=> GetFleets(),
		'AllPlanets'				=> $AllPlanets,
		'AdminsOnline'				=> $AdminsOnline,
		'Teamspeak'					=> GetTeamspeakData(),
		'messages'					=> ($Messages > 0) ? (($Messages == 1) ? $LNG['ov_have_new_message'] : sprintf($LNG['ov_have_new_messages'], pretty_number($Messages))): false,
		'planet_diameter'			=> pretty_number($PLANET['diameter']),
		'planet_field_current' 		=> $PLANET['field_current'],
		'planet_field_max' 			=> CalculateMaxPlanetFields($PLANET),
		'planet_temp_min' 			=> $PLANET['temp_min'],
		'planet_temp_max' 			=> $PLANET['temp_max'],
		'ov_security_confirm'		=> sprintf($LNG['ov_security_confirm'], $PLANET['name']),
		'ref_active'				=> $CONF['ref_active'],
		'ref_minpoints'				=> $CONF['ref_minpoints'],
		'RefLinks'					=> $RefLinks,
		'path'						=> PROTOCOL.$_SERVER['HTTP_HOST'].HTTP_ROOT,
	));
	
	$template->show("overview_body.tpl");
}
?>