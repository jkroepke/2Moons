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
	$parse					= $lang;

	$FlyingFleetsTable = new FlyingFleetsTable();

	$lunarow = $db->fetch_array($db->query("SELECT * FROM ".PLANETS." WHERE `id_owner` = '".$CurrentPlanet['id_owner'] . "' AND `galaxy` = '" . $CurrentPlanet['galaxy'] . "' AND `system` = '" . $CurrentPlanet['system'] . "' AND  `planet` = '" . $CurrentPlanet['planet'] . "' AND `planet_type`='3';"));

	if (empty($lunarow))
		unset($lunarow);
	else
		CheckPlanetUsedFields($lunarow);

	$parse['planet_id'] 	= $CurrentPlanet['id'];
	$parse['planet_name'] 	= $CurrentPlanet['name'];
	$parse['galaxy_galaxy'] = $CurrentPlanet['galaxy'];
	$parse['galaxy_system'] = $CurrentPlanet['system'];
	$parse['galaxy_planet'] = $CurrentPlanet['planet'];

	$mode = request_var('mode','');
	
	switch ($mode)
	{
		case 'renameplanet':

			if ($_POST['action'] == $lang['ov_planet_rename_action'])
			{
				$newname        = $db->sql_escape($_POST['newname']);

				if (preg_match("/[^A-z0-9_\- ]/", $newname) == 1)
				{
					message($lang['ov_newname_error'], "game.php?page=overview&mode=renameplanet",2);
				}
				if ($newname != "")
				{
					$db->query("UPDATE ".PLANETS." SET `name` = '" . $newname . "' WHERE `id` = '" . $CurrentUser['current_planet'] . "';");
				}
			}
			elseif ($_POST['action'] == $lang['ov_abandon_planet'])
			{
				return display(parsetemplate(gettemplate('overview/overview_deleteplanet'), $parse));
			}
			elseif ($_POST['kolonieloeschen'] == 1 && intval($_POST['deleteid']) == $CurrentUser['current_planet'])
			{
				$filokontrol = $db->query("SELECT fleet_owner,fleet_target_owner,fleet_end_type,fleet_mess FROM ".FLEETS." WHERE (fleet_owner = '{$user['id']}' AND fleet_start_galaxy='{$CurrentPlanet['galaxy']}' AND fleet_start_system='{$CurrentPlanet['system']}' AND fleet_start_planet='{$CurrentPlanet['planet']}') OR (fleet_target_owner = '{$user['id']}' AND fleet_end_galaxy='{$CurrentPlanet['galaxy']}' AND fleet_end_system='{$CurrentPlanet['system']}' AND fleet_end_planet='{$CurrentPlanet['planet']}');");

				while($satir = $db->fetch_array($filokontrol))
				{
					$kendifilo 	= $satir['fleet_owner'];
					$digerfilo 	= $satir['fleet_target_owner'];
					$harabeyeri = $satir['fleet_end_type'];
					$mess 		= $satir['fleet_mess'];
				}

				if ($kendifilo > 0)
				{
					message($lang['ov_abandon_planet_not_possible'], 'game.php?page=overview&mode=renameplanet');
				}
				elseif ((($digerfilo > 0) && ($mess < 1 )) && $gezoay <> 2  )
				{
					message($lang['ov_abandon_planet_not_possible'], 'game.php?page=overview&mode=renameplanet');
				}
				else
				{
					if (md5($_POST['pw']) == $CurrentUser["password"] && $CurrentUser['id_planet'] != $CurrentUser['current_planet'])
					{
						$db->query("UPDATE ".PLANETS." SET `destruyed` = '".(time()+ 86400)."' WHERE `id` = '".$db->sql_escape($CurrentUser['current_planet'])."';");
						$db->query("UPDATE ".USERS." SET `current_planet` = `id_planet` WHERE `id` = '". $db->sql_escape($CurrentUser['id']) ."';");
						$db->query("DELETE FROM ".PLANETS." WHERE `galaxy` = '". $CurrentPlanet['galaxy'] ."' AND `system` = '". $CurrentPlanet['system'] ."' AND `planet` = '". $CurrentPlanet['planet'] ."' AND `planet_type` = 3;");

						message($lang['ov_planet_abandoned'], 'game.php?page=overview&mode=renameplanet');
					}
					elseif ($CurrentUser['id_planet'] == $CurrentUser["current_planet"])
					{
						message($lang['ov_principal_planet_cant_abanone'], 'game.php?page=overview&mode=renameplanet');
					}
					else
					{
						message($lang['ov_wrong_pass'], 'game.php?page=overview&mode=renameplanet');
					}
				}
			}

			return display(parsetemplate(gettemplate('overview/overview_renameplanet'), $parse));
		break;

		default:
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
						$parse['ov_ts'] = "<tr><th>Teamspeak</th><th colspan=\"3\"><a href=\"teamspeak://".$game_config['ts_server'].":".$game_config['ts_udpport']."?username=".$CurrentUser['username']."\" alt=\"Teamspeak Connect\" name=\"Teamspeak Connect\">Connect</a>&nbsp;&bull;&nbsp;Online: " . $useronline . "/" . $maxusers . "&nbsp;&bull;&nbsp;Channels: " . $channels . "&nbsp;&bull;&nbsp;Traffic IN: " . $trafin . " MB&nbsp;&bull;&nbsp;Traffic Out: " . $trafout . " MB&nbsp;&bull;&nbsp;Traffic ges.: " . $trafges . " MB</th></tr>";
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
			if($OnlineAdmins) {
				$AdminsNr = 1;
				$parse['OnlineAdmins'] = "";
					while ($oas = $db->fetch_array($OnlineAdmins)) {
						if ($AdminsNr == 1) {
							$parse['OnlineAdmins'] .= "<a href=\"javascript:f('game.php?page=messages&amp;mode=write&amp;id=". $oas['id'] ."','');\" title=\"Nachricht an ". $oas['username'] ." senden\">". $oas['username'] ."</a>";
							$AdminsNr = 0;
						} else {
							$parse['OnlineAdmins'] .= "&nbsp;&bull;&nbsp;<a href=\"javascript:f('game.php?page=messages&amp;mode=write&amp;id=". $oas['id'] ."','');\" title=\"Nachricht an ". $oas['username'] ." senden\">". $oas['username'] ."</a>";					
						}
					}
				} else {
				$parse['OnlineAdmins'] = "-";
			}

			if ($CurrentUser['new_message'] != 0)
			{
				$Have_new_message = "<tr>";
				if ($CurrentUser['new_message'] == 1)
				{
					$Have_new_message .= "<th colspan=4><a href=game.".$phpEx."?page=messages>". $lang['ov_have_new_message'] ."</a></th>";
				}
				elseif ($CurrentUser['new_message'] > 1)
				{
					$Have_new_message .= "<th colspan=4><a href=game.".$phpEx."?page=messages>";
					$Have_new_message .= str_replace('%m', pretty_number($CurrentUser['new_message']), $lang['ov_have_new_messages']);
					$Have_new_message .= "</a></th>";
				}
				$Have_new_message .= "</tr>";
			}

			$parse['ov_banner'] = "<tr><td class=\"c\" colspan=\"4\">Statistiken-Banner</td></tr><tr><th colspan=\"4\"><img src=\"userpic.".$phpEx."?id=" . $CurrentUser['id'] . "\" alt=\"Dein Userbanner\"><br><br>HTML:<input type=\"text\" value='<a href=\"http://".$_SERVER["SERVER_NAME"]."/\"><img src=\"http://".$_SERVER["SERVER_NAME"]."/userpic.php?id=" . $CurrentUser['id'] . "\" alt=\"Dein Userbanner\"></a>' readonly style=\"width:450px;\"><br>BBCode:<input type=\"text\" value='[url=http://".$_SERVER["SERVER_NAME"]."/][img]http://".$_SERVER["SERVER_NAME"]."/userpic.php?id=" . $CurrentUser['id'] . "[/img][/url]' readonly style=\"width:450px;\"></th></tr>";
			
			$OwnFleets = $db->query("SELECT * FROM ".FLEETS." WHERE `fleet_owner` = '" . $CurrentUser['id'] . "';");
			$Record = 0;

			while ($FleetRow = $db->fetch_array($OwnFleets))
			{
				$Record++;

				$StartTime 	= $FleetRow['fleet_start_time'];
				$StayTime 	= $FleetRow['fleet_end_stay'];
				$EndTime 	= $FleetRow['fleet_end_time'];
				/////// // ### LUCKY , CODES ARE BELOW
				$hedefgalaksi = $FleetRow['fleet_end_galaxy'];
				$hedefsistem = $FleetRow['fleet_end_system'];
				$hedefgezegen = $FleetRow['fleet_end_planet'];
				$mess = $FleetRow['fleet_mess'];
				$filogrubu = $FleetRow['fleet_group'];
				//////
				$Label = "fs";
				if ($StartTime > time())
				{
					$fpage[$StartTime] = $FlyingFleetsTable->BuildFleetEventTable ($FleetRow, 0, true, $Label, $Record);
				}

				if(($FleetRow['fleet_mission'] <> 4) && ($FleetRow['fleet_mission'] <> 10))
				{
					$Label = "ft";

					if ($StayTime > time())
					{
						$fpage[$StayTime] = $FlyingFleetsTable->BuildFleetEventTable ($FleetRow, 1, true, $Label, $Record);
					}
					$Label = "fe";

					if ($EndTime > time())
					{
						$fpage[$EndTime] = $FlyingFleetsTable->BuildFleetEventTable ($FleetRow, 2, true, $Label, $Record);
					}
				}
			}
			$db->free_result($OwnFleets);
			//iss ye katilan filo////////////////////////////////////

			// ### LUCKY , CODES ARE BELOW

			$dostfilo = $db->query("SELECT * FROM ".FLEETS." WHERE `fleet_end_galaxy` = '" . $hedefgalaksi . "' AND `fleet_end_system` = '" . $hedefsistem . "' AND `fleet_end_planet` = '" . $hedefgezegen . "' AND `fleet_group` = '" . $filogrubu . "';");
			$Record1 = 0;
			while ($FleetRow = $db->fetch_array($dostfilo)) {


				$StartTime = $FleetRow['fleet_start_time'];
				$StayTime = $FleetRow['fleet_end_stay'];
				$EndTime = $FleetRow['fleet_end_time'];

				///////
				$hedefgalaksi = $FleetRow['fleet_end_galaxy'];
				$hedefsistem = $FleetRow['fleet_end_system'];
				$hedefgezegen = $FleetRow['fleet_end_planet'];
				$mess = $FleetRow['fleet_mess'];
				$filogrubu = $FleetRow['fleet_group'];
				///////
				if (($FleetRow['fleet_mission'] == 2) && ($FleetRow['fleet_owner'] != $CurrentUser['id'])) {
					$Record1++;
					//		if (($FleetRow['fleet_mission'] == 2) ){
					if($mess > 0){
						$StartTime = "";
					}else{
						$StartTime = $FleetRow['fleet_start_time'];
					}

					if ($StartTime > time()) {
						$Label = "ofs";
						$fpage[$StartTime] =$FlyingFleetsTable-> BuildFleetEventTable ($FleetRow, 0, false, $Label, $Record1);
					}

					//	}
				} ///""

				if (($FleetRow['fleet_mission'] == 1) && ($FleetRow['fleet_owner'] != $CurrentUser['id']) && ($filogrubu > 0 ) ){
					$Record++;
					if($mess > 0){
						$StartTime = "";
					}else{
						$StartTime = $FleetRow['fleet_start_time'];
					}
					if ($StartTime > time()) {
						$Label = "ofs";
						$fpage[$StartTime] = $FlyingFleetsTable-> BuildFleetEventTable ($FleetRow, 0, false, $Label, $Record);
					}

				}

			}
			$db->free_result($dostfilo);
			//
			//////////////////////////////////////////////////

			$OtherFleets = $db->query("SELECT * FROM ".FLEETS." WHERE `fleet_target_owner` = '" . $CurrentUser['id'] . "';");

			$Record = 2000;
			while ($FleetRow = $db->fetch_array($OtherFleets))
			{
				if ($FleetRow['fleet_owner'] != $CurrentUser['id'])
				{
					if ($FleetRow['fleet_mission'] != 8)
					{
						$Record++;
						$StartTime = $FleetRow['fleet_start_time'];
						$StayTime = $FleetRow['fleet_end_stay'];

						if ($StartTime > time())
						{
							$Label = "ofs";
							$fpage[$StartTime] = $FlyingFleetsTable->BuildFleetEventTable ($FleetRow, 0, false, $Label, $Record);
						}
						if ($FleetRow['fleet_mission'] == 5)
						{
							$Label = "oft";
							if ($StayTime > time())
							{
								$fpage[$StayTime] = $FlyingFleetsTable->BuildFleetEventTable ($FleetRow, 1, false, $Label, $Record);
							}
						}
					}
				}
			}
			$db->free_result($OtherFleets);

			if ($game_config['OverviewNewsFrame'] == '1') {
				$News = "<tr><th>" . $lang['ov_news'] . "</th><th colspan=\"3\">".makebr($game_config['OverviewNewsText'])."</th></tr>";
            } 
			
			$planets_query = $db->query("SELECT * FROM `".PLANETS."` WHERE id_owner='".$CurrentUser['id']."' AND `destruyed` = 0");
			$Colone  	= 1;
			
			
			$AllPlanets = "<tr>"; 

			while ($CurrentUserPlanet = $db->fetch_array($planets_query))
			{
				if ($CurrentUserPlanet["id"] != $CurrentUser["current_planet"] && $CurrentUserPlanet['planet_type'] != 3)
				{
					$Coloneshow++;
					$AllPlanets .= "<th>". $CurrentUserPlanet['name'] ."<br>";
					$AllPlanets .= "<a href=\"game.php?page=overview&cp=". $CurrentUserPlanet['id'] ."&re=0\" title=\"". $CurrentUserPlanet['name'] ."\"><img src=\"". $dpath ."planeten/small/s_". $CurrentUserPlanet['image'] .".jpg\" height=\"50\" width=\"50\"></a><br>";
					$AllPlanets .= "<center>";

					if ($CurrentUserPlanet['b_building'] != 0)
					{
						UpdatePlanetBatimentQueueList($CurrentUserPlanet, $CurrentUser);
						if ($CurrentUserPlanet['b_building'] != 0 )
						{
							$BuildQueue      = $CurrentUserPlanet['b_building_id'];
							$QueueArray      = explode ( ";", $BuildQueue );
							$CurrentBuild    = explode ( ",", $QueueArray[0] );
							$BuildElement    = $CurrentBuild[0];
							$BuildLevel      = $CurrentBuild[1];
							$BuildRestTime   = pretty_time( $CurrentBuild[3] - time() );
							$AllPlanets     .= '' . $lang['tech'][$BuildElement] . ' (' . $BuildLevel . ')';
							$AllPlanets     .= "<br><font color=\"#7f7f7f\">(". $BuildRestTime .")</font>";
						}
						else
						{
							CheckPlanetUsedFields ($CurrentUserPlanet);
							$AllPlanets     .= $lang['ov_free'];
						}
					}
					else
					{
						$AllPlanets    .= $lang['ov_free'];
					}

					$AllPlanets .= "</center></th>";

					if ($Colone <= 1)
						$Colone++;
					else
					{
						$AllPlanets .= "</tr><tr>";
						$Colone = 1;
					}
				}
			}
			
			$db->free_result($planets_query);
			
			$AllPlanets .= "</tr>";
			
			if ($lunarow['id'] <> 0 && $lunarow['destruyed'] == 0 && $CurrentPlanet['planet_type'] == 1)
			{
				$parse['moon_img'] = "<a href=\"game.php?page=overview&amp;cp=" . $lunarow['id'] . "&amp;re=0\" title=\"" . $lunarow['name'] . "\"><img src=\"" . $dpath . "planeten/" . $lunarow['image'] . ".jpg\" height=\"50\" width=\"50\"></a>";
				$parse['moon'] = $lunarow['name'] ." (" . $lang['fcm_moon'] . ")";
			}
			else
			{
				$parse['moon_img'] = "";
				$parse['moon'] = "";
			}

			$parse['planet_diameter'] 		= pretty_number($CurrentPlanet['diameter']);
			$parse['planet_field_current']  = $CurrentPlanet['field_current'];
			$parse['planet_field_max'] 		= CalculateMaxPlanetFields($CurrentPlanet);
			$parse['planet_temp_min'] 		= $CurrentPlanet['temp_min'];
			$parse['planet_temp_max'] 		= $CurrentPlanet['temp_max'];

			$StatRecord = $db->fetch_array($db->query("SELECT `total_rank`,`total_points` FROM `".STATPOINTS."` WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '" . $CurrentUser['id'] . "';"));

			$parse['user_username']        = $CurrentUser['username'];

			if (isset($fpage) && count($fpage) > 0)
			{
				ksort($fpage);
				foreach ($fpage as $time => $content)
				{
					$flotten .= $content . "\n";
				}
			}

			if ($CurrentPlanet['b_building'] != 0)
			{
				include($xgp_root . 'includes/functions/InsertBuildListScript.' . $phpEx);

				UpdatePlanetBatimentQueueList ($planetrow, $user);
				if ($CurrentPlanet['b_building'] != 0)
				{
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
					$parse['building'] 	 = $Build;
				}
				else
				{
					$parse['building'] = $lang['ov_free'];
				}
			}
			else
			{
				$parse['building'] = $lang['ov_free'];
			}

			$parse['fleet_list']  			= (isset($flotten)) ? $flotten : "";
			$parse['Have_new_message'] 		= (isset($Have_new_message)) ? $Have_new_message : "";
			$parse['planet_image'] 			= $CurrentPlanet['image'];
			$parse['NewsFrame']				= (isset($News)) ? $News : "";
			$parse['anothers_planets'] 		= ($AllPlanets != "<tr></tr>") ? "<table class=\"s\" border=\"0\">".$AllPlanets."</table>" : "";
			$parse["dpath"] 				= $dpath;
			if($game_config['stat'] == 0)
				$parse['user_rank']			= pretty_number($StatRecord['total_points']) . " (". $lang['ov_place'] ." <a href=\"game.php?page=statistics&amp;range=".$StatRecord['total_rank']."\">".$StatRecord['total_rank']."</a> ". $lang['ov_of'] ." ".$game_config['users_amount'].")";
			elseif($game_config['stat'] == 1 && $CurrentUser['authlevel'] < $game_config['stat_level'])
				$parse['user_rank']			= pretty_number($StatRecord['total_points']) . " (". $lang['ov_place'] ." <a href=\"game.php?page=statistics&amp,range=".$StatRecord['total_rank']."\">".$StatRecord['total_rank']."</a> ". $lang['ov_of'] ." ".$game_config['users_amount'].")";
			else
				$parse['user_rank']			= "-";

			$parse['date_time']				= date("D M j H:i:s", time());
			return display(parsetemplate(gettemplate('overview/overview_body'), $parse));
		break;
	}
}
?>