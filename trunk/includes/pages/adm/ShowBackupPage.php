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


function ShowBackupPage()
{
	global $db, $LNG;
	
	$template	= new template();
	$template->page_header();
	
	if(isset($_POST['download']))
	{
		$datei	=	request_var('download','',true);
		
		$downloadfile = "backup/".$datei."";
		$filename = $datei;
		
		header("Content-Disposition: attachment; filename=$filename");
		
		readfile($downloadfile);
		exit;
	}
	
	if(isset($_POST['erstellen']))
	{
		$tabellen	=	$db->query("SHOW TABLES FROM ".DB_NAME."");
		
		$wert .= "# Datum der Sicherung: ".date("d.m.Y, H:i:s")." Uhr\r\n\r\n";
	    $wert .= "USE ".DB_NAME.";\r\n\r\n";
		
		while($row = $db->fetch_num($tabellen))
		{
			$daten	=	$db->query("SELECT * FROM ".$row[0]."");
			
			while($d = $db->fetch_num($daten))
			{
			  $val = "";
			  $wert .= "INSERT INTO ".$row[0]." VALUES(";
			  for ($i=0;$i<count($d);$i++) { $val .= "'".$d[$i]."',"; }
			  $val = substr($val,0,strlen($val)-1); 
			  $wert .= $val.");\r\n";
	
			}
		}
		
		$zeit	=	date('d.M.Y',time());
		
		$datei = fopen("backup/".$zeit.".txt","a+");	

		fwrite($datei, $wert);
		
		fclose($datei);
		
		$_SESSION['erstellt']	=	$LNG['backup_erstellt'];
		

	}
	
	$path = "backup";
	if($dir=opendir($path))
	{
	 while($file=readdir($dir))
	 {
	  if (!is_dir($file) && $file != "." && $file != "..")
	  {
	   $date .= $files[]="<input type='submit' name='download' value='".$file."'><br>";
	  }
	 }
	closedir($dir);
	}
	
	if(empty($date))
		$date = $LNG['keine_backups'];
	$template->assign_vars(array(
	'files'				=>	$date,
	'backup_datei'		=>	$LNG['backup_datei'],
	'backup_system'		=>	$LNG['backup_system'],
	'neu_erstellen'		=>	$LNG['backup_erstellen'],
	'erstellt'			=>	$_SESSION['erstellt'],
	'backup'			=>	1,
	));
	$template->show('adm/backup.tpl');
	unset($_SESSION['erstellt']);
}

?>