<?php

##############################################################################
# *																			 #
# * 2MOON       															 #
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

if ($user['authlevel'] != 3) die();

	function exitupdate($Result){

		$parse['planetes'] = "<tr><th>";
		if(is_array($Result['debug'])) {
			foreach($Result['debug'] as $key => $content) {
				$parse['planetes'] .= $content."<br>";
			}
		}
		
		if(is_array($Result['update'])) {
			foreach($Result['update'] as $rev => $content) {
				foreach($content as $file => $status) {
					$parse['planetes'] .= "File ".$file." (Rev. ".$rev."): ".$status."<br>";
				}
			}
		}
		
		if(is_array($Result['finish'])) {	
			foreach($Result['finish'] as $key => $content) {
				$parse['planetes'] .= $content."<br>";
			}
		}
		$parse['planetes'] .= "</th></tr><tr><td><a href='?'>Weiter</a></th></tr>";
				
		
		display(parsetemplate(gettemplate('adm/update_body'), $parse), false, '', true, false);
		exit;
	}

	$Patchlevel	= explode(".",VERSION);
	if($_REQUEST['history'] == 1)
		$Level		= 0;	
	elseif(isset($Patchlevel[2]))
		$Level		= $Patchlevel[2];
	else
		$Level		= 464;
		
	$opts = array('http' => array('method'=> "GET", 'header'=> "Patchlevel: ".$Level."\r\n"));
			
	$context 		= stream_context_create($opts);
	
	switch($_REQUEST['action'])
	{
		case "update":
			require_once(ROOT_PATH.'includes/libs/ftp/ftp.class.'.PHP_EXT);
			require_once(ROOT_PATH.'includes/libs/ftp/ftpexception.class.'.PHP_EXT);
			$UpdateArray 	= unserialize(file_get_contents("http://update.jango-online.de/index.php?action=getupdate",FALSE,$context));
			if(!is_array($UpdateArray['revs']))
				exitupdate(array('debug' => array('noupdate' => "Kein Update vorhanden!")));
				
			$SVN_ROOT		= $UpdateArray['info']['svn'];
			$config 		= array("host" => $game_config['ftp_server'], "username" => $game_config['ftp_user_name'], "password" => $game_config['ftp_user_pass'], "port"     => 21 );
			
			try
			{
				$ftp = FTP::getInstance(); 
				$ftp->connect( $config, true, true );
				$Result['debug']['connect']	= "FTP-Verbindungsaufbau: OK!";
			}
			catch (FTPException $error)
			{
				$Result['debug']['connect']	= "FTP-Verbindungsaufbau: ERROR! ".$error->getMessage();
				exitupdate($Result);
			}	
						
			if($ftp->changeDir($game_config['ftp_root_path']))
			{
				$Result['debug']['chdir']	= "FTP-Changedir(".$game_config['ftp_root_path']."): OK!";
			}
			else
			{
				$Result['debug']['chdir']	= "FTP-Changedir(".$game_config['ftp_root_path']."): ERROR! Pfad nicht gefunden!";
				exitupdate($Result);
			}
			
			foreach($UpdateArray['revs'] as $Rev => $RevInfo) 
			{
				if(!empty($RevInfo['add']))
				{
					foreach($RevInfo['add'] as $File)
					{	
						if($File == "/trunk/updates/update_".$Rev.".sql")
						{
							$db->multi_query(str_replace("prefix_", DB_PREFIX, file_get_contents($SVN_ROOT.$File)));
							continue;
						} else {
							if (strpos($File, '.') !== false) {		
								$Data = fopen(str_replace("/trunk/", "", $File));
								if ($ftp->uploadFromFile($Data, str_replace("/trunk/", "", $File))) {
									$Result['update'][$Rev][$File]	= "OK! - Updated";
								} else {
									$Result['update'][$Rev][$File]	= "ERROR! - Konnte Datei nicht hochladen";
								}
								fclose($Data);
							} else {
								if ($ftp->makeDir(str_replace("/trunk/", "", $File), 0)) {
									$Result['update'][$Rev][$File]	= "OK! - Updated";
								} else {
									$Result['update'][$Rev][$File]	= "ERROR! - Konnte Datei nicht hochladen";
								}				
							}
						}
					}
				}
				if(!empty($RevInfo['edit']))
				{
					foreach($RevInfo['edit'] as $File)
					{	
						if (strpos($File, '.') !== false) {
							if($File == "/trunk/updates/update_".$Rev.".sql")
							{
								$db->multi_query(str_replace("prefix_", DB_PREFIX, file_get_contents($SVN_ROOT.$File)));
								continue;
							} else {
								$Data = fopen($SVN_ROOT.$File, "r");
								if ($ftp->uploadFromFile($Data, str_replace("/trunk/", "", $File))) {
									$Result['update'][$Rev][$File]	= "OK! - Updated";
								} else {
									$Result['update'][$Rev][$File]	= "ERROR! - Konnte Datei nicht hochladen";
								}
								fclose($Data);
							}
						}
					}
				}
				if(!empty($RevInfo['del']))
				{
					foreach($RevInfo['del'] as $File)
					{
						if (strpos($File, '.') !== false) {
							if ($ftp->delete(str_replace("/trunk/", "", $File))) {
								$Result['update'][$Rev][$File]	= "OK! - Gel&ouml;scht";
							} else {
								$Result['update'][$Rev][$File]	= "ERROR! - Konnte Datei nicht l&ouml;schen";
							}
						} else {
							if ($ftp->removeDir(str_replace("/trunk/", "", $File), 1 )) {
								$Result['update'][$Rev][$File]	= "OK! - Gel&ouml;scht";
							} else {
								$Result['update'][$Rev][$File]	= "ERROR! - Konnte Datei nicht l&ouml;schen";
							}						
						}
					}
				}
				$LastRev = $Rev;
			}
			$Result['finish']['atrev'] = "UPDATE: OK! At Revision: ".$LastRev;
			
			// Verbindung schließen
			update_config('VERSION', str_replace("RC","",$Patchlevel[0]).".".$Patchlevel[1].".".$LastRev);
			exitupdate($Result);
		break;
		default:
			$i = 0;
			if(($RAW = file_get_contents("http://update.jango-online.de/index.php?action=update",FALSE,$context)) !== false)
			{
				$UpdateArray 	= unserialize($RAW);
				if(is_array($UpdateArray['revs']))
				{
					foreach($UpdateArray['revs'] as $Rev => $RevInfo) 
					{
						if(!(empty($RevInfo['add']) && empty($RevInfo['edit'])) && $Patchlevel[2] < $Rev){
							$parse['update']	= "<tr><th><a href=\"?action=update\">Update</a></th></tr>";
							$parse['info']		= "<tr><td class=\"c\" colspan=\"5\">Aktuelle Updates</td></tr>";
						}
						$parse['planetes'] .= "<tr>
						".(($Patchlevel[2] == $Rev)?"<td class=c colspan=5>Momentane Version</td></tr><tr>":((($Patchlevel[2] - 1) == $Rev)?"<td class=c colspan=5>Alte Updates</td></tr><tr>":""))."
						<td class=c >".(($Patchlevel[2] == $Rev)?"<font color=\"red\">":"")."Revision " . $Rev . " ".date("d. M y H:i:s", $RevInfo['timestamp'])." von ".$RevInfo['author'].(($Patchlevel[2] == $Rev)?"</font>":"")."</td></tr>
						<tr><th>".$RevInfo['log']."</th></tr>
						".((!empty($RevInfo['add']))?"<tr><td class=b>ADD:<br>".str_replace("/trunk/", "", implode("<br>\n", $RevInfo['add']))."</b></td></tr>":"")."
						".((!empty($RevInfo['edit']))?"<tr><td class=b>EDIT:<br>".str_replace("/trunk/", "", implode("<br>\n", $RevInfo['edit']))."</b></td></tr>":"")."
						".((!empty($RevInfo['del']))?"<tr><td class=b>DEL:<br>".str_replace("/trunk/", "", implode("<br>\n", $RevInfo['del']))."</b></td></tr>":"")."
						</tr>";
						if($i == 0)
						{
							$LastRev	= $Rev;
						}
						$i++;
					}
				}
			} elseif(!function_exists('file_get_contents')) {
				$parse['planetes'] = "<tr><th>Function file_get_contents deaktiviert</th></tr>";
			} else {
				$parse['planetes'] = "<tr><th>Update Server currently not available</th></tr>";
			}
		break;
	}
	display(parsetemplate(gettemplate('adm/update_body'), $parse), false, '', true, false);

// Created by e-Zobar. All rights reversed (C) XNova Team 2008
?>