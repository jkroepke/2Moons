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

if ($USER['authlevel'] != AUTH_ADM) exit();

function exitupdate($LOG){
	$Page	= "";
	if(is_array($LOG['debug'])) {
		foreach($LOG['debug'] as $key => $content) {
			$Page .= $content."<br>";
		}
	}
	
	if(is_array($LOG['update'])) {
		foreach($LOG['update'] as $rev => $content) {
			foreach($content as $file => $status) {
				$Page.= "File ".$file." (Rev. ".$rev."): ".$status."<br>";
			}
		}
	}
		
	if(is_array($LOG['finish'])) {	
		foreach($LOG['finish'] as $key => $content) {
			$Page .= $content."<br>";
		}
	}
	$Page .= "<br><a href='?page=update'>Weiter</a>";

	$template = new template();
	$template->message($Page, false, 0, true);
				
	exit;
}

function ShowUpdatePage()
{
	global $LNG, $CONF, $db;
	$Patchlevel	= explode(".",VERSION);
	if($_REQUEST['action'] == 'history')
		$Level		= 0;	
	elseif(isset($Patchlevel[2]))
		$Level		= $Patchlevel[2];
	else
		$Level		= 748;
		
	$opts = array('http' => array('method'=> "GET", 'header'=> "Patchlevel: ".$Level."\r\n"));
			
	$context 		= stream_context_create($opts);
	
	switch($_REQUEST['action'])
	{
		case "download":
			require_once(ROOT_PATH.'includes/libs/zip/zip.lib.'.PHP_EXT);
			$UpdateArray 	= unserialize(file_get_contents("http://update.2moons.xnova-reloaded.eu/index.php?action=getupdate",FALSE,$context));
			if(!is_array($UpdateArray['revs']))
				exitupdate(array('debug' => array('noupdate' => "Kein Update vorhanden!")));
				
			$SVN_ROOT		= $UpdateArray['info']['svn'];
			
			$zipfile 	= new zipfile();
			$TodoDelete	= "";
			foreach($UpdateArray['revs'] as $Rev => $RevInfo) 
			{
				if(!empty($RevInfo['add']))
				{
					foreach($RevInfo['add'] as $File)
					{	
						if (strpos($File, '.') !== false)
							$zipfile->addFile(file_get_contents($SVN_ROOT.$File), str_replace("/trunk/", "", $File), $RevInfo['timestamp']);					
					}
				}
				if(!empty($RevInfo['edit']))
				{
					foreach($RevInfo['edit'] as $File)
					{	
						if (strpos($File, '.') !== false)
							$zipfile->addFile(file_get_contents($SVN_ROOT.$File), str_replace("/trunk/", "", $File), $RevInfo['timestamp']);
					}
				}
				if(!empty($RevInfo['del']))
				{
					foreach($RevInfo['del'] as $File)
					{
						if (strpos($File, '.') !== false) {
							$TodoDelete	.= str_replace("/trunk/", "", $File)."\r\n";
						}
					}
				}
				$LastRev = $Rev;
			}	
			
			if(!empty($TodoDelete))
				$zipfile->addFile($TodoDelete, "!TodoDelete!.txt", $RevInfo['timestamp']);
			
			update_config('VERSION', str_replace("RC","",$Patchlevel[0]).".".$Patchlevel[1].".".$LastRev);
			// Header für Download senden
			header("HTTP/1.1 200 OK");
			header("Content-Type: application/force-download");
			header('Content-Disposition: attachment; filename="patch_'.$Level.'_to_'.$LastRev.'.zip"');
			header("Content-Transfer-Encoding: binary");

			// Zip File senden
			echo $zipfile->file(); 
			exit;			
		break;
		case "update":
			require_once(ROOT_PATH.'includes/libs/ftp/ftp.class.'.PHP_EXT);
			require_once(ROOT_PATH.'includes/libs/ftp/ftpexception.class.'.PHP_EXT);
			$UpdateArray 	= unserialize(file_get_contents("http://update.2moons.xnova-reloaded.eu/index.php?action=getupdate",FALSE,$context));
			if(!is_array($UpdateArray['revs']))
				exitupdate(array('debug' => array('noupdate' => "Kein Update vorhanden!")));
				
			$SVN_ROOT		= $UpdateArray['info']['svn'];
			$CONFIG 		= array("host" => $CONF['ftp_server'], "username" => $CONF['ftp_user_name'], "password" => $CONF['ftp_user_pass'], "port"     => 21 ); 
			try
			{
				$ftp = FTP::getInstance(); 
				$ftp->connect($CONFIG);
				$LOG['debug']['connect']	= "FTP-Verbindungsaufbau: OK!";
			}
			catch (FTPException $error)
			{
				$LOG['debug']['connect']	= "FTP-Verbindungsaufbau: ERROR! ".$error->getMessage();
				exitupdate($LOG);
			}	
						
			if($ftp->changeDir($CONF['ftp_root_path']))
			{
				$LOG['debug']['chdir']	= "FTP-Changedir(".$CONF['ftp_root_path']."): OK!";
			}
			else
			{
				$LOG['debug']['chdir']	= "FTP-Changedir(".$CONF['ftp_root_path']."): ERROR! Pfad nicht gefunden!";
				exitupdate($LOG);
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
								$Data = fopen($SVN_ROOT.$File, "r");
								if ($ftp->uploadFromFile($Data, str_replace("/trunk/", "", $File))) {
									$LOG['update'][$Rev][$File]	= "OK! - Updated";
								} else {
									$LOG['update'][$Rev][$File]	= "ERROR! - Konnte Datei nicht hochladen";
								}
								fclose($Data);
							} else {
								if ($ftp->makeDir(str_replace("/trunk/", "", $File), 1)) {
									$LOG['update'][$Rev][$File]	= "OK! - Updated";
								} else {
									$LOG['update'][$Rev][$File]	= "ERROR! - Konnte Datei nicht hochladen";
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
									$LOG['update'][$Rev][$File]	= "OK! - Updated";
								} else {
									$LOG['update'][$Rev][$File]	= "ERROR! - Konnte Datei nicht hochladen";
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
								$LOG['update'][$Rev][$File]	= "OK! - Gel&ouml;scht";
							} else {
								$LOG['update'][$Rev][$File]	= "ERROR! - Konnte Datei nicht l&ouml;schen";
							}
						} else {
							if ($ftp->removeDir(str_replace("/trunk/", "", $File), 1 )) {
								$LOG['update'][$Rev][$File]	= "OK! - Gel&ouml;scht";
							} else {
								$LOG['update'][$Rev][$File]	= "ERROR! - Konnte Datei nicht l&ouml;schen";
							}						
						}
					}
				}
				$LastRev = $Rev;
			}
			$LOG['finish']['atrev'] = "UPDATE: OK! At Revision: ".$LastRev;
			
			// Verbindung schließen
			update_config('VERSION', str_replace("RC","",$Patchlevel[0]).".".$Patchlevel[1].".".$LastRev);
			exitupdate($LOG);
		break;
		default:
			$template 	= new template();
			$template->page_header();
			
			$RevList	= '';
			$Update		= '';
			$Info		= '';
			
			if(!function_exists('file_get_contents') || !function_exists('fsockopen')) {
				$template->message('Function file_get_contents oder fsockopen deactive', false, 0, true);
			} elseif(($RAW = @file_get_contents("http://update.2moons.xnova-reloaded.eu/index.php?action=update",FALSE,$context)) !== false) {
				$UpdateArray 	= unserialize($RAW);
				if(is_array($UpdateArray['revs']))
				{
					foreach($UpdateArray['revs'] as $Rev => $RevInfo) 
					{
						if(!(empty($RevInfo['add']) && empty($RevInfo['edit'])) && $Patchlevel[2] < $Rev){
							$Update		= "<tr><th><a href=\"?page=update&amp;action=update\">Update</a> - <a href=\"?page=update&amp;action=download\">Download Patch Files</a></th></tr>";
							$Info		= "<tr><td class=\"c\" colspan=\"5\">Aktuelle Updates</td></tr>";
						}
						
						$edit	= "";
						if(!empty($RevInfo['edit']) || is_array($RevInfo['edit'])){
							foreach($RevInfo['edit'] as $file) {							
								$edit	.= '<a href="http://code.google.com/p/2moons/source/diff?spec=svn'.$Rev.'&r='.$Rev.'&format=side&path='.$file.'" target="diff">'.str_replace("/trunk/", "", $file).'</a><br>';
							}
						}

						$RevList .= "<tr>
						".(($Patchlevel[2] == $Rev)?"<td class=c colspan=5>Momentane Version</td></tr><tr>":((($Patchlevel[2] - 1) == $Rev)?"<td class=c colspan=5>Alte Updates</td></tr><tr>":""))."
						<td class=c >".(($Patchlevel[2] == $Rev)?"<font color=\"red\">":"")."Revision " . $Rev . " ".date("d. M y H:i:s", $RevInfo['timestamp'])." von ".$RevInfo['author'].(($Patchlevel[2] == $Rev)?"</font>":"")."</td></tr>
						<tr><th>".makebr($RevInfo['log'])."</th></tr>
						".((!empty($RevInfo['add']))?"<tr><th>ADD:<br>".str_replace("/trunk/", "", implode("<br>\n", $RevInfo['add']))."</b></th></tr>":"")."
						".((!empty($RevInfo['edit']))?"<tr><th>EDIT:<br>".$edit."</b></th></tr>":"")."
						".((!empty($RevInfo['del']))?"<tr><th>DEL:<br>".str_replace("/trunk/", "", implode("<br>\n", $RevInfo['del']))."</b></th></tr>":"")."
						</tr>";
					}
				}
								
				$template->assign_vars(array(	
					'RevList'	=> $RevList,
					'Update'	=> $Update,
					'Info'		=> $Info,
				));
					
				$template->show('adm/UpdatePage.tpl');
			} else {
				$template->message('Update Server currently not available', false, 0, true);
			}
		break;
	}
}
?>