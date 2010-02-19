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

if(!defined('INSIDE')){ die(header("location:../../"));}

function ShowOverviewPage($CurrentUser, $CurrentPlanet)
{
	global $xgp_root, $phpEx, $dpath, $game_config, $lang, $planetrow, $user, $db, $resource;

	include_once($xgp_root . 'includes/functions/InsertJavaScriptChronoApplet.' . $phpEx);
	include_once($xgp_root . 'includes/classes/class.FlyingFleetsTable.' . $phpEx);
	
	$PlanetRess = new ResourceUpdate($CurrentUser, $CurrentPlanet);

	$template	= new template();

	$template->set_vars($CurrentUser, $CurrentPlanet);
	$template->page_header();
	$template->page_topnav();
	$template->page_leftmenu();
	$template->page_planetmenu();
	$template->page_footer();	


	$parse['planet_id'] 	= $CurrentPlanet['id'];
	$parse['planet_name'] 	= $CurrentPlanet['name'];
	$parse['galaxy_galaxy'] = $CurrentPlanet['galaxy'];
	$parse['galaxy_system'] = $CurrentPlanet['system'];
	$parse['galaxy_planet'] = $CurrentPlanet['planet'];

	$mode = request_var('mode','');
	
	switch ($mode)
	{
		case 'renameplanet':
			$newname        = trim(request_var('newname', ''));
			if (!empty($newname))
			{
				if (!CheckName($newname))
					$template->message((UTF8_SUPPORT) ? $lang['ov_newname_no_space'] : $lang['ov_newname_alphanum'], "game.php?page=overview&mode=renameplanet",2);
				else
				{
					$db->query("UPDATE ".PLANETS." SET `name` = '".$db->sql_escape($newname)."' WHERE `id` = '". $CurrentUser['current_planet'] . "';");
					header("Location: ./game.".$phpEx."?page=overview&mode=renameplanet");
				}
			}
			else
			{
				$template->assign_vars(array(
					'galaxy'					=> $CurrentPlanet['galaxy'],
					'system'					=> $CurrentPlanet['system'],
					'planet'					=> $CurrentPlanet['planet'],
					'planetname'				=> $CurrentPlanet['name'],
					'ov_your_planet'			=> $lang['ov_your_planet'],
					'ov_coords'					=> $lang['ov_coords'],
					'ov_planet_name'			=> $lang['ov_planet_name'],
					'ov_actions'				=> $lang['ov_actions'],
					'ov_abandon_planet'			=> $lang['ov_abandon_planet'],
					'ov_planet_rename'			=> $lang['ov_planet_rename'],
					'ov_planet_rename_action'	=> $lang['ov_planet_rename_action'],
				));
				
				$template->show('overview_renameplanet.tpl');
			}
		break;
		case 'deleteplanet':
			$password =	request_var('password', '');
			if (!empty($password))
			{
				$IfFleets = $db->query("SELECT fleet_id FROM ".FLEETS." WHERE (`fleet_owner` = '".$CurrentUser['id']."' AND `fleet_start_galaxy` = '".$CurrentPlanet['galaxy']."' AND `fleet_start_system` = '".$CurrentPlanet['system']."' AND `fleet_start_planet` = '".$CurrentPlanet['planet']."') OR (`fleet_target_owner` = '".$CurrentUser['id']."' AND `fleet_end_galaxy` = '".$CurrentPlanet['galaxy']."' AND `fleet_end_system` = '".$CurrentPlanet['system']."' AND `fleet_end_planet` = '".$CurrentPlanet['planet']."');");
				
				if ($db->num_rows($IfFleets) > 0)
					$template->message($lang['ov_abandon_planet_not_possible'], 'game.php?page=overview&mode=deleteplanet', 3);
				elseif ($CurrentUser['id_planet'] == $CurrentUser["current_planet"])
					$template->message($lang['ov_principal_planet_cant_abanone'], 'game.php?page=overview&mode=deleteplanet', 3);
				elseif (md5($password) != $CurrentUser["password"])
					$template->message($lang['ov_wrong_pass'], 'game.php?page=overview&mode=deleteplanet', 3);
				else
				{
					$db->multi_query("UPDATE ".PLANETS." SET `destruyed` = '".(time()+ 86400)."' WHERE `id` = '".$CurrentUser['current_planet']."';UPDATE ".USERS." SET `current_planet` = `id_planet` WHERE `id` = '".$CurrentUser['id']."';DELETE FROM ".PLANETS." WHERE `id` = '".$CurrentPlanet['id_luna']."';");
					$template->message($lang['ov_planet_abandoned'], 'game.php?page=overview', 3);
				}
			}
			else
			{
				$template->assign_vars(array(
					'name'						=> $CurrentPlanet['name'],
					'galaxy'					=> $CurrentPlanet['galaxy'],
					'system'					=> $CurrentPlanet['system'],
					'planet'					=> $CurrentPlanet['planet'],
					'ov_password'				=> $lang['ov_password'],
					'ov_with_pass'				=> $lang['ov_with_pass'],
					'ov_security_confirm'		=> $lang['ov_security_confirm'],
					'ov_security_request'		=> $lang['ov_security_request'],
					'ov_delete_planet'			=> $lang['ov_delete_planet'],
				));
				
				$template->show('overview_deleteplanet.tpl');
			}
		break;
		default:
			
			$FlyingFleetsTable = new FlyingFleetsTable();
			
			$OwnFleets = $db->query("SELECT * FROM ".FLEETS." WHERE `fleet_owner` = '" . $CurrentUser['id'] . "';");
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
				
				if ($StartTime > time())
				{
					$fpage[$StartTime.$id] = $FlyingFleetsTable->BuildFleetEventTable ($FleetRow, 0, true, $Label, $Record);
				}

				if(($FleetRow['fleet_mission'] <> 4) && ($FleetRow['fleet_mission'] <> 10))
				{
					$Label = "ft";

					if ($StayTime > time())
					{
						$fpage[$StayTime.$id] = $FlyingFleetsTable->BuildFleetEventTable ($FleetRow, 1, true, $Label, $Record);
					}
					$Label = "fe";

					if ($EndTime > time())
					{
						$fpage[$EndTime.$id] = $FlyingFleetsTable->BuildFleetEventTable ($FleetRow, 2, true, $Label, $Record);
					}
				}
			}
			$db->free_result($OwnFleets);
			//iss ye katilan filo////////////////////////////////////

			// ### LUCKY , CODES ARE BELOW

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
				
				if (($FleetRow['fleet_mission'] == 2) && ($FleetRow['fleet_owner'] != $CurrentUser['id'])) {
					$Record1++;
					
					if($mess > 0){
						$StartTime = "";
					}else{
						$StartTime = $FleetRow['fleet_start_time'];
					}

					if ($StartTime > time()) {
						$Label = "ofs";
						$fpage[$StartTime.$id] =$FlyingFleetsTable-> BuildFleetEventTable ($FleetRow, 0, false, $Label, $Record1);
					}
				}

				if (($FleetRow['fleet_mission'] == 1) && ($FleetRow['fleet_owner'] != $CurrentUser['id']) && ($filogrubu > 0 ) ){
					$Record++;
					if($mess > 0){
						$StartTime = "";
					}else{
						$StartTime = $FleetRow['fleet_start_time'];
					}
					if ($StartTime > time()) {
						$Label = "ofs";
						$fpage[$StartTime.$id] = $FlyingFleetsTable-> BuildFleetEventTable ($FleetRow, 0, false, $Label, $Record);
					}

				}

			}
			$db->free_result($dostfilo);
			

			$OtherFleets = $db->query("SELECT * FROM ".FLEETS." WHERE `fleet_target_owner` = '" . $CurrentUser['id'] . "';");

			$Record = 2000;
			while ($FleetRow = $db->fetch_array($OtherFleets))
			{
				if ($FleetRow['fleet_owner'] != $CurrentUser['id'])
				{
					if ($FleetRow['fleet_mission'] != 8)
					{
						$Record++;
						$StartTime 	= $FleetRow['fleet_start_time'];
						$StayTime 	= $FleetRow['fleet_end_stay'];
						$id 		= $FleetRow['fleet_id'];

						if ($StartTime > time())
						{
							$Label = "ofs";
							$fpage[$StartTime.$id] = $FlyingFleetsTable->BuildFleetEventTable ($FleetRow, 0, false, $Label, $Record);
						}
						if ($FleetRow['fleet_mission'] == 5)
						{
							$Label = "oft";
							if ($StayTime > time())
							{
								$fpage[$StayTime.$id] = $FlyingFleetsTable->BuildFleetEventTable ($FleetRow, 1, false, $Label, $Record);
							}
						}
					}
				}
			}
			$db->free_result($OtherFleets);

			$AnotherPlanets = $db->query("SELECT * FROM `".PLANETS."` WHERE id_owner='".$CurrentUser['id']."' AND `destruyed` = 0");

			while ($CurrentUserPlanet = $db->fetch_array($AnotherPlanets))
			{
				if ($CurrentUserPlanet["id"] != $CurrentUser["current_planet"] && $CurrentUserPlanet['planet_type'] != 3)
				{
					if ($CurrentUserPlanet['b_building'] != 0)
					{
						UpdatePlanetBatimentQueueList($CurrentUserPlanet, $CurrentUser);
						$BuildQueue      = $CurrentUserPlanet['b_building_id'];
						$QueueArray      = explode ( ";", $BuildQueue );
						$CurrentBuild    = explode ( ",", $QueueArray[0] );
						$BuildPlanet	 = $lang['tech'][$CurrentBuild[0]]." (".$CurrentBuild[1].") <br><font color=\"#7f7f7f\">(".pretty_time($CurrentBuild[3] - time()).")</font>";
					}
					else
					{
						$BuildPlanet     = $lang['ov_free'];
					}
					
					$AllPlanets[] = array(
						'id'	=> $CurrentUserPlanet['id'],
						'name'	=> $CurrentUserPlanet['name'],
						'image'	=> $CurrentUserPlanet['image'],
						'build'	=> $BuildPlanet,
					);
				}
			}
			
			$db->free_result($AnotherPlanets);
	
			if ($CurrentPlanet['id_luna'] != 0)
			{
				$lunarow = $db->fetch_array($db->query("SELECT * FROM ".PLANETS." WHERE `id` = '".$CurrentPlanet['id_luna']."';"));
				if ($lunarow['destruyed'] == 0 && $CurrentPlanet['planet_type'] == 1)
				{
					CheckPlanetUsedFields($lunarow);
					$Moon = array(
						'id'	=> $lunarow['id'],
						'name'	=> $lunarow['name'],
					);
				}
			}	

			$StatRecord = $db->fetch_array($db->query("SELECT `total_rank`,`total_points` FROM `".STATPOINTS."` WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '" . $CurrentUser['id'] . "';"));

			if ($CurrentPlanet['b_building'] != 0)
			{
				include($xgp_root . 'includes/functions/InsertBuildListScript.' . $phpEx);

				UpdatePlanetBatimentQueueList ($planetrow, $user);

				$BuildQueue  		 = explode (";", $CurrentPlanet['b_building_id']);
				$CurrBuild 	 		 = explode (",", $BuildQueue[0]);
				$RestTime 	 		 = $CurrentPlanet['b_building'] - time();
				$PlanetID 	 		 = $CurrentPlanet['id'];
				$Build 		 		 = InsertBuildListScript ("overview");
				$Build 	   			.= $lang['tech'][$CurrBuild[0]] . ' (' . ($CurrBuild[1]) . ')';
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
				$Build 				.= "document.title = datem[0] + ' - ". $lang['tech'][$CurrBuild[0]]." - ".$game_config['game_name']."';\n";
				$Build 				.= "window.setTimeout('title();', 1000);}\n";
				$Build 				.= "title();\n</script>";
			}
			else
			{
				$Build = $lang['ov_free'];
			}

			if ($game_config['ts_modon'] == 1) {
				if($game_config['ts_version'] == 2){
					include_once($xgp_root . "includes/libs/teamspeak/class.teamspeak2.".$phpEx);
					$ts = new cyts();
					if($ts->connect($game_config['ts_server'], $game_config['ts_tcpport'], $game_config['ts_udpport'], $game_config['ts_timeout'])){
						$tsdata = $ts->info_serverInfo();
						$tsdata2 = $ts->info_globalInfo();
						$maxusers = $tsdata["server_maxusers"];
						$useronline = $tsdata["server_currentusers"];
						$channels = $tsdata["server_currentchannels"];
						$trafin = round($tsdata2["total_bytesreceived"] / 1024 / 1024, 2);
						$trafout = round($tsdata2["total_bytessend"] / 1024 / 1024, 2);
						$trafges = $trafin + $trafout;
						$parse['ov_ts'] = "<tr><th>Teamspeak</th><th colspan=\"3\"><a href=\"teamspeak://".$game_config['ts_server'].":".$game_config['ts_udpport']."?nickname=".$CurrentUser['username']."\" alt=\"Teamspeak Connect\" name=\"Teamspeak Connect\">Connect</a>&nbsp;&bull;&nbsp;Online: " . $useronline . "/" . $maxusers . "&nbsp;&bull;&nbsp;Channels: " . $channels . "&nbsp;&bull;&nbsp;Traffic IN: " . $trafin . " MB&nbsp;&bull;&nbsp;Traffic Out: " . $trafout . " MB&nbsp;&bull;&nbsp;Traffic ges.: " . $trafges . " MB</th></tr>";
						$ts->disconnect();
					} else {
						$parse['ov_ts'] = "<tr><th>Teamspeak</th><th colspan=\"3\">Server&nbsp;zurzeit&nbsp;nicht&nbsp;erreichbar.&nbsp;Wir&nbsp;bitten&nbsp;um&nbsp;verst&auml;ndnis.</th></tr>";
					}
				} elseif($game_config['ts_version'] == 3){
					$ip 	= $game_config['ts_server'];
					$port 	= $game_config['ts_tcpport'];
					$t_port = $game_config['ts_udpport'];
					$sid 	= $game_config['ts_timeout']; 
					require_once($xgp_root . "includes/libs/teamspeak/class.teamspeak3.".$phpEx);

					$tsAdmin = new ts3admin($ip, $t_port);
					if($tsAdmin->connect()){
						$tsAdmin->selectServer($sid);
						$sinfo	= $tsAdmin->serverInfo();
						$tsAdmin->logout();
						$tsAdmin->quit();
						$trafin 	= round($sinfo['connection_bytes_received_total'] / 1024 / 1024, 2);
						$trafout	= round($sinfo['connection_bytes_sent_total'] / 1024 / 1024, 2);
						$trafges 	= $trafin + $trafout;
						$version	= explode('\s',$sinfo['virtualserver_version']);
						$parse['ov_ts'] = "<tr><th>Teamspeak</th><th colspan=\"3\"><a href=\"ts3server://".$ip."?port=".$port."&amp;nickname=".$CurrentUser['username']."&amp;password=".$sinfo['virtualserver_password']."\" alt=\"Teamspeak Connect\" name=\"Teamspeak Connect\">Connect</a>&nbsp;&bull;&nbsp;Online: " . $sinfo['virtualserver_clientsonline'] . "/" . $sinfo['virtualserver_maxclients'] . "&nbsp;&bull;&nbsp;Channels: " . $sinfo['virtualserver_channelsonline'] . "&nbsp;&bull;&nbsp;Traffic IN: " . $trafin . " MB&nbsp;&bull;&nbsp;Traffic Out: " . $trafout . " MB&nbsp;&bull;&nbsp;Traffic ges.: " . $trafges . " MB&nbsp;&bull;&nbsp;Version: " .$version[0] . "</th></tr>";
					} else {
						$parse['ov_ts'] = "<tr><th>Teamspeak</th><th colspan=\"3\">Server&nbsp;zurzeit&nbsp;nicht&nbsp;erreichbar.&nbsp;Wir&nbsp;bitten&nbsp;um&nbsp;verst&auml;ndnis.</th></tr>";		
					}
				}
			} else {
				$parse['ov_ts'] = "";
			}
			$OnlineAdmins = $db->query("SELECT `id`,`username` FROM ".USERS." WHERE onlinetime >=' ".(time()-10*60)."' AND authlevel > 0;");
			
			if(isset($OnlineAdmins)) {
				while ($AdminRow = $db->fetch_array($OnlineAdmins)) {
					$AdminsOnline[$AdminRow['id']]	= $AdminRow['username'];
				}
			}
		
			if (isset($fpage) && is_array($fpage))
				ksort($fpage);

			$template->assign_vars(array(
				'date_time'					=> date("D M j H:i:s", time()),
				'user_rank'					=> sprintf($lang['ov_userrank_info'], pretty_number($StatRecord['total_points']), $lang['ov_place'], $StatRecord['total_rank'], $StatRecord['total_rank'], $lang['ov_of'], $game_config['users_amount']),
				'is_news'					=> $game_config['OverviewNewsFrame'],
				'news'						=> makebr($game_config['OverviewNewsText']),
				'planetname'				=> $CurrentPlanet['name'],
				'planetimage'				=> $CurrentPlanet['image'],
				'galaxy'					=> $CurrentPlanet['galaxy'],
				'system'					=> $CurrentPlanet['system'],
				'planet'					=> $CurrentPlanet['planet'],
				'userid'					=> $CurrentUser['id'],
				'username'					=> $CurrentUser['username'],
				'fleets'					=> $fpage,
				'build'						=> $Build,
				'Moon'						=> $Moon,
				'AllPlanets'				=> $AllPlanets,
				'AdminsOnline'				=> $AdminsOnline,
				'messages'					=> ($CurrentUser['new_message'] > 0) ? (($CurrentUser['new_message'] == 1) ? $lang['ov_have_new_message'] : sprintf($lang['ov_have_new_messages'], pretty_number($CurrentUser['new_message']))): false,
				'planet_diameter'			=> pretty_number($CurrentPlanet['diameter']),
				'planet_field_current' 		=> $CurrentPlanet['field_current'],
				'planet_field_max' 			=> CalculateMaxPlanetFields($CurrentPlanet),
				'planet_temp_min' 			=> $CurrentPlanet['temp_min'],
				'planet_temp_max' 			=> $CurrentPlanet['temp_max'],
				'ov_news'					=> $lang['ov_news'],
				'fcm_moon'					=> $lang['fcm_moon'],
				'ov_server_time'			=> $lang['ov_server_time'],
				'ov_planet'					=> $lang['ov_planet'],
				'ov_planetmenu'				=> $lang['ov_planetmenu'],
				'ov_diameter'				=> $lang['ov_diameter'],
				'ov_distance_unit'			=> $lang['ov_distance_unit'],
				'ov_developed_fields'		=> $lang['ov_developed_fields'],
				'ov_max_developed_fields'	=> $lang['ov_max_developed_fields'],
				'ov_fields'					=> $lang['ov_fields'],
				'ov_temperature'			=> $lang['ov_temperature'],
				'ov_aprox'					=> $lang['ov_aprox'	], 
				'ov_temp_unit'				=> $lang['ov_temp_unit'],
				'ov_to'						=> $lang['ov_to'],
				'ov_position'				=> $lang['ov_position'],
				'ov_points'					=> $lang['ov_points'],
				'ov_events'					=> $lang['ov_events'],
				'ov_admins_online'			=> $lang['ov_admins_online'],
				'ov_no_admins_online'		=> $lang['ov_no_admins_online'],
				'ov_userbanner'				=> $lang['ov_userbanner'],
			));
			
			$template->show("overview_body.tpl");
		break;
	}
	$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
}
?>