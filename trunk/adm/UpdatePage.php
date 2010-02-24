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

$xgp_root = './../';
include($xgp_root . 'extension.inc.php');
include($xgp_root . 'common.' . $phpEx);
include('AdminFunctions/Autorization.' . $phpEx);

if ($user['authlevel'] != 3) die();

function exitupdate($conn_id, $Result){

	$parse['planetes'] = "<tr><th>";
	foreach($Result['debug'] as $key => $content)
	{
		$parse['planetes'] .= $content."<br>";
	}

	foreach($Result['update'] as $rev => $content)
	{
		foreach($content as $file => $status)
		{
			$parse['planetes'] .= "Update File ".$file.": ".$status."<br>";
		}
	}
	$parse['planetes'] .= "</th></tr>";
	
	if(!empty($coon_id))
		ftp_close($conn_id);		
	
	display(parsetemplate(gettemplate('adm/update_body'), $parse), false, '', true, false);
	exit;
}


	$Patchlevel	= explode(".",VERSION);

	if(isset($Patchlevel[2]))
		$Level		= $Patchlevel[2];
	elseif($_REQUEST['history'] == 1)
		$Level		= 0;
	else
		$Level		= 252;


	switch($_REQUEST['mode'])
	{
		case "update":
			$opts = array(
			  'http'=>array(
				'method'=> "GET",
				'header'=> "Patchlevel: ".$Level."\r\n"
			  )
			);

			$context 		= stream_context_create($opts);
			$UpdateArray 	= unserialize(file_get_contents("http://update.jango-online.de/index.php?action=getupdate",FALSE,$context));
			if(!is_array($UpdateArray['revs']))
				exitupdate(NULL, array('debug' => array('noupdate' => "Kein Update vorhanden!")));
				
			$SVN_ROOT		= $UpdateArray['info']['svn'];
			
			$conn_id 		= ftp_connect($game_config['ftp_server']);
			$login_result 	= ftp_login($conn_id, $game_config['ftp_user_name'], $game_config['ftp_user_pass']);
			$Result			= array();
			
			if ($conn_id) {
				$Result['debug']['connect']	= "FTP-Verbindungsaufbau: OK!";
			} else {
				$Result['debug']['connect']	= "FTP-Verbindungsaufbau: ERROR! HOST: ".$game_config['ftp_server'];
				exitupdate($conn_id, $Result);
			}
			
			if ($login_result) {
				$Result['debug']['login']	= "FTP-LOGIN: OK!";
			} else {
				$Result['debug']['login']	= "FTP-LOGIN: ERROR! USER: ".$game_config['ftp_user_name']." PASS: ".$game_config['ftp_user_pass']." @ ".$game_config['ftp_server'];
				exitupdate($conn_id, $Result);
			}
			
			if(ftp_pasv($conn_id, true))
			{
				$Result['debug']['mode']	= "FTP-Mode: Setze Passiver Modus!";
			}
			else
			{
				$Result['debug']['mode']	= "FTP-Mode: Konnte Passiven Modus nicht setzten!";
				exitupdate($conn_id, $Result);
			}			
			if(ftp_chdir($conn_id, $game_config['ftp_root_path']))
			{
				$Result['debug']['chdir']	= "FTP-Changedir(".$game_config['ftp_root_path']."): OK!";
			}
			else
			{
				$Result['debug']['chdir']	= "FTP-Changedir(".$game_config['ftp_root_path']."): ERROR! Pfad nicht gefunden!";
				exitupdate($conn_id, $Result);
			}
			
			foreach($UpdateArray['revs'] as $Rev => $RevInfo) 
			{
				foreach($RevInfo['add'] as $File)
				{	
					if($File == "/trunk/update.sql")
					{
						$db->multi_query(str_replace("prefix_", DB_PREFIX, file_get_contents($SVN_ROOT.$File)));
						continue;
					}
					$Data = fopen($SVN_ROOT.$File, "r");
					if (ftp_fput($conn_id, str_replace("/trunk/", "", $File), $Data, FTP_ASCII)) {
						$Result['update'][$Rev][$File]	= "OK!";
					} else {
						$Result['update'][$Rev][$File]	= "ERROR! - Konnte Datei nicht updaten";
					}
					fclose($Data);
				}
				foreach($RevInfo['edit'] as $File)
				{	
					if($File == "/trunk/update.sql")
					{
						$db->multi_query(str_replace("prefix_", DB_PREFIX, file_get_contents($SVN_ROOT.$File)));
						continue;
					}
					$Data = fopen($SVN_ROOT.$File, "r");
					if (ftp_fput($conn_id, str_replace("/trunk/", "", $File), $Data, FTP_ASCII)) {
						$Result['update'][$Rev][$File]	= "OK!";
					} else {
						$Result['update'][$Rev][$File]	= "ERROR! - Konnte Datei nicht updaten";
					}
					fclose($Data);
				}
				foreach($RevInfo['del'] as $File)
				{
					if (ftp_delete($conn_id, str_replace("/trunk/", "", $File))) {
						$Result['update'][$Rev][$File]	= "OK!";
					} else {
						$Result['update'][$Rev][$File]	= "ERROR! - Konnte Datei nicht updaten";
					}
				}
				$LastRev = $Rev;
			}
			$Result['debug']['atrev'] = "UPDATE: OK! At Revision: ".$LastRev;
			
			// Verbindung schließen
			update_config('VERSION', $Patchlevel[0].".".$Patchlevel[1].".".$LastRev);
			exitupdate($conn_id, $Result);
		break;
		default:
				
			$opts = array(
			  'http'=>array(
				'method'=> "GET",
				'header'=> "Patchlevel: ".$Level."\r\n"
			  )
			);
			$i = 0;
			$context 		= stream_context_create($opts);
			if(($RAW = @file_get_contents("http://update.jango-online.de/index.php?action=update",FALSE,$context)) === true)
			{
				$UpdateArray 	= unserialize($RAW);
				
				foreach($UpdateArray['revs'] as $Rev => $RevInfo) 
				{
					if(is_array()){
						$parse['update']	= "<tr><th><a href=\"?action=update\">Update</a></th></tr>";
						$parse['info']		= "<tr><td class=\"c\" colspan=\"5\">Aktuelle Updates</td></tr>";
					}
					$parse['planetes'] .= "<tr>
					".(($Patchlevel[2] == $Rev)?"<td class=c colspan=5>Momentane Version</td></tr><tr>":((($Patchlevel[2] - 1) == $Rev)?"<td class=c colspan=5>Alte Updates</td></tr><tr>":""))."
					<th>".(($Patchlevel[2] == $Rev)?"<font color=\"red\">":"")."Revision " . $Rev . " ".date("d. M y H:i:s", $RevInfo['timestamp'])." von ".$RevInfo['author'].(($Patchlevel[2] == $Rev)?"</font>":"")."</th></tr>
					".((!empty($RevInfo['add']))?"<tr><td class=b>ADD:<br>".str_replace("/trunk/", "", implode("<br>\n", $RevInfo['add']))."</b></td></tr>":"")."
					".((!empty($RevInfo['edit']))?"<tr><td class=b>EDIT:<br>".str_replace("/trunk/", "", implode("<br>\n", $RevInfo['edit']))."</b></td></tr>":"")."
					".((!empty($RevInfo['del']))?"<tr><td class=b>DEL:<br>".str_replace("/trunk/", "", implode("<br>\n", $RevInfo['del']))."</b></td></tr>":"")."
					</tr>";
					if($i == 0)
						$LastRev	= $Rev;
					$i++;
				}
			} else {
				$parse['planetes'] = "<tr><th>Update Server currently not available</th></tr>";
			}
		break;
	}
	display(parsetemplate(gettemplate('adm/update_body'), $parse), false, '', true, false);

// Created by e-Zobar. All rights reversed (C) XNova Team 2008
?>