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

if(!defined('INSIDE')) die('Hacking attempt!');

function ShowOverviewPage()
{
	global $CONF, $LNG, $PLANET, $USER, $db, $resource;

	include_once(ROOT_PATH . 'includes/functions/InsertJavaScriptChronoApplet.' . PHP_EXT);
	include_once(ROOT_PATH . 'includes/classes/class.FlyingFleetsTable.' . PHP_EXT);
	
	$PlanetRess = new ResourceUpdate();
	$PlanetRess->CalcResource()->SavePlanetToDB();

	$template	= new template();
	$template->page_header();
	$template->page_topnav();
	$template->page_leftmenu();
	$template->page_planetmenu();
	$template->page_footer();	

	$mode = request_var('mode','');
	
	switch ($mode)
	{
		case 'renameplanet':
			$newname        = trim(request_var('newname', '', UTF8_SUPPORT));
			if (!empty($newname))
			{
				if (!CheckName($newname))
					$template->message((UTF8_SUPPORT) ? $LNG['ov_newname_no_space'] : $LNG['ov_newname_alphanum'], "game.php?page=overview&mode=renameplanet",2);
				else
				{
					$db->query("UPDATE ".PLANETS." SET `name` = '".$db->sql_escape($newname)."' WHERE `id` = '". $USER['current_planet'] . "' LIMIT 1;");
					header("Location: ./game.".PHP_EXT."?page=overview&mode=renameplanet");
				}
			}
			else
			{
				$template->assign_vars(array(
					'galaxy'					=> $PLANET['galaxy'],
					'system'					=> $PLANET['system'],
					'planet'					=> $PLANET['planet'],
					'planetname'				=> $PLANET['name'],
					'ov_your_planet'			=> $LNG['ov_your_planet'],
					'ov_coords'					=> $LNG['ov_coords'],
					'ov_planet_name'			=> $LNG['ov_planet_name'],
					'ov_actions'				=> $LNG['ov_actions'],
					'ov_abandon_planet'			=> $LNG['ov_abandon_planet'],
					'ov_planet_rename'			=> $LNG['ov_planet_rename'],
					'ov_planet_rename_action'	=> $LNG['ov_planet_rename_action'],
				));
				
				$template->show('overview_renameplanet.tpl');
			}
		break;
		case 'deleteplanet':
			$password =	request_var('password', '');
			if (!empty($password))
			{
				$IfFleets = $db->query("SELECT fleet_id FROM ".FLEETS." WHERE (`fleet_owner` = '".$USER['id']."' AND `fleet_start_galaxy` = '".$PLANET['galaxy']."' AND `fleet_start_system` = '".$PLANET['system']."' AND `fleet_start_planet` = '".$PLANET['planet']."') OR (`fleet_target_owner` = '".$USER['id']."' AND `fleet_end_galaxy` = '".$PLANET['galaxy']."' AND `fleet_end_system` = '".$PLANET['system']."' AND `fleet_end_planet` = '".$PLANET['planet']."');");
				
				if ($db->num_rows($IfFleets) > 0)
					$template->message($LNG['ov_abandon_planet_not_possible'], '?page=overview&mode=deleteplanet', 3);
				elseif ($USER['id_planet'] == $USER["current_planet"])
					$template->message($LNG['ov_principal_planet_cant_abanone'], '?page=overview&mode=deleteplanet', 3);
				elseif (md5($password) != $USER["password"])
					$template->message($LNG['ov_wrong_pass'], '?page=overview&mode=deleteplanet', 3);
				else
				{
					if($PLANET['planet_type'] == 1)
					{
						$db->multi_query("UPDATE ".PLANETS." SET `destruyed` = '".(TIMESTAMP+ 86400)."' WHERE `id` = '".$USER['current_planet']."' LIMIT 1;UPDATE ".USERS." SET `current_planet` = `id_planet` WHERE `id` = '".$USER['id']."';DELETE FROM ".PLANETS." WHERE `id` = '".$PLANET['id_luna']."' LIMIT 1;");
					} else {
						$db->multi_query("DELETE FROM ".PLANETS." WHERE `id` = '".$PLANET['id']."' LIMIT 1;
						UPDATE ".PLANETS." SET `id_luna` = '0' WHERE `id_luna` = '".$PLANET['id']."' LIMIT 1;
						UPDATE ".USERS." SET `current_planet` = `id_planet` WHERE `id` = '".$USER['id']."';");
					}
					$template->message($LNG['ov_planet_abandoned'], '?page=overview', 3);
				}
			}
			else
			{
				$template->assign_vars(array(
					'name'						=> $PLANET['name'],
					'galaxy'					=> $PLANET['galaxy'],
					'system'					=> $PLANET['system'],
					'planet'					=> $PLANET['planet'],
					'ov_password'				=> $LNG['ov_password'],
					'ov_with_pass'				=> $LNG['ov_with_pass'],
					'ov_security_confirm'		=> $LNG['ov_security_confirm'],
					'ov_security_request'		=> $LNG['ov_security_request'],
					'ov_delete_planet'			=> $LNG['ov_delete_planet'],
				));
				
				$template->show('overview_deleteplanet.tpl');
			}
		break;
		default:
			
			$FlyingFleetsTable = new FlyingFleetsTable();
			
			$OwnFleets = $db->query("SELECT * FROM ".FLEETS." WHERE `fleet_owner` = '" . $USER['id'] . "';");
			$Record = 0;

			while ($FleetRow = $db->fetch_array($OwnFleets))
			{
				$Record++;

				$StartTime 		= $FleetRow['fleet_start_time'];
				$StayTime 		= $FleetRow['fleet_end_stay'];
				$EndTime 		= $FleetRow['fleet_end_time'];
				/////// // ### LUCKY , CODES ARE BELOW
				$hedefgalaksi 	= $FleetRow['fleet_end_galaxy'];
				$hedefsistem 	= $FleetRow['fleet_end_system'];
				$hedefgezegen 	= $FleetRow['fleet_end_planet'];
				$mess 			= $FleetRow['fleet_mess'];
				$filogrubu 		= $FleetRow['fleet_group'];
				$id 			= $FleetRow['fleet_id'];
				//////
				$Label = "fs";
				
				if ($StartTime > TIMESTAMP)
				{
					$fpage[$StartTime.$id] = $FlyingFleetsTable->BuildFleetEventTable ($FleetRow, 0, true, $Label, $Record);
				}

				if(($FleetRow['fleet_mission'] != 4 || ($FleetRow['fleet_mission'] == 4 && $FleetRow['fleet_mess'] == 1)) && ($FleetRow['fleet_mission'] != 10))
				{
					$Label = "ft";

					if ($StayTime > TIMESTAMP)
					{
						$fpage[$StayTime.$id] = $FlyingFleetsTable->BuildFleetEventTable ($FleetRow, 1, true, $Label, $Record);
					}
					$Label = "fe";

					if ($EndTime > TIMESTAMP)
					{
						$fpage[$EndTime.$id] = $FlyingFleetsTable->BuildFleetEventTable ($FleetRow, 2, true, $Label, $Record);
					}
				}
			}
			$db->free_result($OwnFleets);
			//iss ye katilan filo////////////////////////////////////

			// ### LUCKY , CODES ARE BELOW
			if(!empty($hedefgalaksi) && !empty($hedefsistem) && !empty($hedefgezegen))
			{
				$dostfilo = $db->query("SELECT * FROM ".FLEETS." WHERE `fleet_end_galaxy` = '" . $hedefgalaksi . "' AND `fleet_end_system` = '" . $hedefsistem . "' AND `fleet_end_planet` = '" . $hedefgezegen . "' AND `fleet_group` = '" . $filogrubu . "';");
				$Record1 = 0;
				while ($FleetRow = $db->fetch_array($dostfilo)) {
					$StartTime		= $FleetRow['fleet_start_time'];
					$StayTime 		= $FleetRow['fleet_end_stay'];
					$EndTime 		= $FleetRow['fleet_end_time'];
					$hedefgalaksi 	= $FleetRow['fleet_end_galaxy'];
					$hedefsistem 	= $FleetRow['fleet_end_system'];
					$hedefgezegen 	= $FleetRow['fleet_end_planet'];
					$mess 			= $FleetRow['fleet_mess'];
					$filogrubu 		= $FleetRow['fleet_group'];
					$id 			= $FleetRow['fleet_id'];
					
					if (($FleetRow['fleet_mission'] == 2) && ($FleetRow['fleet_owner'] != $USER['id'])) {
						$Record1++;
						
						if($mess > 0){
							$StartTime = "";
						}else{
							$StartTime = $FleetRow['fleet_start_time'];
						}

						if ($StartTime > TIMESTAMP) {
							$Label = "ofs";
							$fpage[$StartTime.$id] = $FlyingFleetsTable->BuildFleetEventTable ($FleetRow, 0, false, $Label, $Record1, true);
						}
					}

					if (($FleetRow['fleet_mission'] == 1) && ($FleetRow['fleet_owner'] != $USER['id']) && ($filogrubu > 0 ) ){
						$Record++;
						if($mess > 0){
							$StartTime = "";
						}else{
							$StartTime = $FleetRow['fleet_start_time'];
						}
						if ($StartTime > TIMESTAMP) {
							$Label = "ofs";
							$fpage[$StartTime.$id] = $FlyingFleetsTable->BuildFleetEventTable ($FleetRow, 0, false, $Label, $Record, true);
						}

					}

				}
				$db->free_result($dostfilo);
			}

			$OtherFleets = $db->query("SELECT * FROM ".FLEETS." WHERE `fleet_target_owner` = '" . $USER['id'] . "';");

			$Record = 2000;
			while ($FleetRow = $db->fetch_array($OtherFleets))
			{
				if ($FleetRow['fleet_owner'] != $USER['id'])
				{
					if ($FleetRow['fleet_mission'] != 8)
					{
						$Record++;
						$StartTime 	= $FleetRow['fleet_start_time'];
						$StayTime 	= $FleetRow['fleet_end_stay'];
						$id 		= $FleetRow['fleet_id'];

						if ($StartTime > TIMESTAMP)
						{
							$Label = "ofs";
							$fpage[$StartTime.$id] = $FlyingFleetsTable->BuildFleetEventTable ($FleetRow, 0, false, $Label, $Record);
						}
						if ($FleetRow['fleet_mission'] == 5)
						{
							$Label = "oft";
							if ($StayTime > TIMESTAMP)
							{
								$fpage[$StayTime.$id] = $FlyingFleetsTable->BuildFleetEventTable ($FleetRow, 1, false, $Label, $Record);
							}
						}
					}
				}
			}
			$db->free_result($OtherFleets);
			
			$template->getplanets();
			
			foreach($template->UserPlanets as $ID => $USERPlanet)
			{		
				if ($ID == $USER["current_planet"] || $USERPlanet['planet_type'] == 3)
					continue;

				if (!empty($USERPlanet['b_building_id']))
				{
					$QueueArray      = explode ( ";", $USERPlanet['b_building_id']);
					$CurrentBuild    = explode ( ",", $QueueArray[0] );
					
					if($CurrentBuild[3] - TIMESTAMP > 0)
						$BuildPlanet	 = $LNG['tech'][$CurrentBuild[0]]." (".$CurrentBuild[1].") <br><font color=\"#7f7f7f\">(".pretty_time($CurrentBuild[3] - TIMESTAMP).")</font>";
					else
						$BuildPlanet     = $LNG['ov_free'];
				}
				else
					$BuildPlanet     = $LNG['ov_free'];
					
				$AllPlanets[] = array(
					'id'	=> $USERPlanet['id'],
					'name'	=> $USERPlanet['name'],
					'image'	=> $USERPlanet['image'],
					'build'	=> $BuildPlanet,
				);
			}
				
			if ($PLANET['id_luna'] != 0)
			{
				$lunarow = $db->uniquequery("SELECT `id`, `name` FROM ".PLANETS." WHERE `id` = '".$PLANET['id_luna']."';");
				$Moon = array(
					'id'	=> $lunarow['id'],
					'name'	=> $lunarow['name'],
				);
			}

			if (!empty($PLANET['b_building_id']))
			{
				include_once(ROOT_PATH . 'includes/functions/InsertBuildListScript.' . PHP_EXT);

				$BuildQueue  		 = explode (";", $PLANET['b_building_id']);
				$CurrBuild 	 		 = explode (",", $BuildQueue[0]);
				$RestTime 	 		 = $CurrBuild[3] - TIMESTAMP;
				$PlanetID 	 		 = $PLANET['id'];
				$Build 		 		 = InsertBuildListScript ("overview");
				$Build 	   			.= $LNG['tech'][$CurrBuild[0]] . ' (' . ($CurrBuild[1]) . ')';
				$Build 				.= "<br /><div id=\"blc\" class=\"z\">" . pretty_time($RestTime) . "</div>";
				$Build 				.= "\n<script language=\"JavaScript\">";
				$Build 				.= "\n	pp = \"" . $RestTime . "\";\n";
				$Build 				.= "\n	pk = \"" . 1 . "\";\n";
				$Build 				.= "\n	pm = \"cancel\";\n";
				$Build 				.= "\n	pl = \"" . $PlanetID . "\";\n";
				$Build 				.= "\n	t();\n";
				$Build 				.= "\n</script>\n";
				$Build 				.= "<script type=\"text/javascript\">\n";
				$Build 				.= "function title(){\n";
				$Build 				.= "var datem = document.getElementById('blc').innerHTML.split('<br><a ');\n";
				$Build 				.= "document.title = datem[0] + ' - ". $LNG['tech'][$CurrBuild[0]]." - ".$CONF['game_name']."';\n";
				$Build 				.= "window.setTimeout('title();', 1000);}\n";
				$Build 				.= "title();\n</script>";
			}
			else
			{
				$Build = $LNG['ov_free'];
			}

			if ($CONF['ts_modon'] == 1) {
				if($CONF['ts_version'] == 2){
					include_once(ROOT_PATH . "includes/libs/teamspeak/class.teamspeak2.".PHP_EXT);
					$ts = new cyts();
					if($ts->connect($CONF['ts_server'], $CONF['ts_tcpport'], $CONF['ts_udpport'], $CONF['ts_timeout']))
					{
						$tsdata 	= $ts->info_serverInfo();
						$tsdata2 	= $ts->info_globalInfo();
						$ts->disconnect();
						$trafges 	= pretty_number(($tsdata2["total_bytessend"] / 1024 / 1024) + $tsdata2["total_bytesreceived"] / 1024 / 1024);
						$Teamspeak	= sprintf($LNG['ov_teamspeak_v2'], $CONF['ts_server'], $CONF['ts_udpport'], $USER['username'], $tsdata["server_currentusers"], $tsdata["server_maxusers"], $tsdata["server_currentchannels"], $trafges);
					} else {
						$Teamspeak	= $LNG['ov_teamspeak_not_online'];
					}
				} elseif($CONF['ts_version'] == 3){
					$ip 	= $CONF['ts_server'];
					$port 	= $CONF['ts_tcpport'];
					$t_port = $CONF['ts_udpport'];
					$sid 	= $CONF['ts_timeout']; 
					require_once(ROOT_PATH . "includes/libs/teamspeak/class.teamspeak3.".PHP_EXT);

					$tsAdmin = new ts3admin($ip, $t_port);
					if($tsAdmin->connect())
					{
						$tsAdmin->selectServer($sid);
						$sinfo	= $tsAdmin->serverInfo();
						$tsAdmin->logout();
						$tsAdmin->quit();
						$trafges 	= round(($sinfo['connection_bytes_received_total'] / 1024 / 1024) + ($sinfo['connection_bytes_sent_total'] / 1024 / 1024), 2);
						$Debug		= $tsAdmin->getDebugLog();
						if($Debug == "Error while fetching: 'error id=518 msg=not logged in'<br>")
							$Teamspeak	= sprintf($LNG['ov_teamspeak_v3'], $ip, $port, $USER['username'], $sinfo['virtualserver_password'], ($sinfo['virtualserver_clientsonline'] - 1), $sinfo['virtualserver_maxclients'], $sinfo['virtualserver_channelsonline'], $trafges);
						else
							$Teamspeak	= $Debug;
					} else {
						$Teamspeak 	= $LNG['ov_teamspeak_not_online'];		
					}
				}
			}
			
			$OnlineAdmins = $db->query("SELECT `id`,`username` FROM ".USERS." WHERE `onlinetime` >= '".(TIMESTAMP-10*60)."' AND `authlevel` > '0';");
			
			if(isset($OnlineAdmins)) {
				while ($AdminRow = $db->fetch_array($OnlineAdmins)) {
					$AdminsOnline[$AdminRow['id']]	= $AdminRow['username'];
				}
			}
			
			$db->free_result($OnlineAdmins);
			
			if (isset($fpage) && is_array($fpage))
				ksort($fpage);
				
			$template->assign_vars(array(
				'date_time'					=> date("D M j H:i:s", TIMESTAMP),
				'user_rank'					=> sprintf($LNG['ov_userrank_info'], pretty_number($USER['total_points']), $LNG['ov_place'], $USER['total_rank'], $USER['total_rank'], $LNG['ov_of'], $CONF['users_amount']),
				'is_news'					=> $CONF['OverviewNewsFrame'],
				'news'						=> makebr($CONF['OverviewNewsText']),
				'planetname'				=> $PLANET['name'],
				'planetimage'				=> $PLANET['image'],
				'galaxy'					=> $PLANET['galaxy'],
				'system'					=> $PLANET['system'],
				'planet'					=> $PLANET['planet'],
				'userid'					=> $USER['id'],
				'username'					=> $USER['username'],
				'fleets'					=> $fpage,
				'build'						=> $Build,
				'Moon'						=> $Moon,
				'AllPlanets'				=> $AllPlanets,
				'AdminsOnline'				=> $AdminsOnline,
				'Teamspeak'					=> $Teamspeak,
				'messages'					=> ($USER['new_message'] > 0) ? (($USER['new_message'] == 1) ? $LNG['ov_have_new_message'] : sprintf($LNG['ov_have_new_messages'], pretty_number($USER['new_message']))): false,
				'planet_diameter'			=> pretty_number($PLANET['diameter']),
				'planet_field_current' 		=> $PLANET['field_current'],
				'planet_field_max' 			=> CalculateMaxPlanetFields($PLANET),
				'planet_temp_min' 			=> $PLANET['temp_min'],
				'planet_temp_max' 			=> $PLANET['temp_max'],
				'ov_news'					=> $LNG['ov_news'],
				'fcm_moon'					=> $LNG['fcm_moon'],
				'ov_server_time'			=> $LNG['ov_server_time'],
				'ov_planet'					=> $LNG['ov_planet'],
				'ov_planetmenu'				=> $LNG['ov_planetmenu'],
				'ov_diameter'				=> $LNG['ov_diameter'],
				'ov_distance_unit'			=> $LNG['ov_distance_unit'],
				'ov_developed_fields'		=> $LNG['ov_developed_fields'],
				'ov_max_developed_fields'	=> $LNG['ov_max_developed_fields'],
				'ov_fields'					=> $LNG['ov_fields'],
				'ov_temperature'			=> $LNG['ov_temperature'],
				'ov_aprox'					=> $LNG['ov_aprox'	], 
				'ov_temp_unit'				=> $LNG['ov_temp_unit'],
				'ov_to'						=> $LNG['ov_to'],
				'ov_position'				=> $LNG['ov_position'],
				'ov_points'					=> $LNG['ov_points'],
				'ov_events'					=> $LNG['ov_events'],
				'ov_admins_online'			=> $LNG['ov_admins_online'],
				'ov_no_admins_online'		=> $LNG['ov_no_admins_online'],
				'ov_userbanner'				=> $LNG['ov_userbanner'],
				'ov_teamspeak'				=> $LNG['ov_teamspeak'],
			));
			
			$template->show("overview_body.tpl");
		break;
	}
}
?>