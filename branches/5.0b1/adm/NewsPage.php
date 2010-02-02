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

if ($Observation != 1) die();

	$query = $db->query("SELECT * FROM ".NEWS." ORDER BY id ASC");
	$i = 0;
	while ($u = $db->fetch_array($query)) {
		$parse['planetes'] .= "<tr>"
		. "<td class=b><center><b><a href='?action=edit&id=".$u['id'] ."'>" . $u['id'] . "</a></center></b></td>"
		. "<td class=b><center><b><a href='?action=edit&id=".$u['id'] ."'>" . $u['title'] . "</a></center></b></td>"
		. "<td class=b><center><b><a href='?action=edit&id=".$u['id'] ."'>" . date("d.m.Y H:i:s",$u['date']) . "</a></center></b></td>"
		. "<td class=b><center><b><a href='?action=edit&id=".$u['id'] ."'>" . $u['user'] . "</a></center></b></td>"
		. "<td class=b align=\"center\"><a href='?action=delete&id=".$u['id'] ."' onclick=\"return confirm('Bist du sicher, dass du die Nachricht " . $u['title'] . " entfernen willst?');\"><img border=\"0\" src=\"../styles/images/r1.png\"></a></td>"
		. "</tr>";
		$i++;
	}
	$parse['planetes'] .= "<tr><td colspan=\"5\" align=\"center\"><a href=\"?action=create\">News erstellen</a></td></tr>";
	$parse['planetes'] .= "<tr><th class=\"b\" colspan=\"8\">Insgesamt {$i} News vorhanden</th></tr>";

	if(($_GET['action'] == 'edit') && isset($_GET['id'])) {
		$query = $db->query("SELECT * FROM ".NEWS." WHERE id = '".$db->sql_escape($_GET['id'])."';");
		$id = intval($_GET['id']);
		$planet = $db->fetch_array($query);
		$parse['show_edit_form'] = parsetemplate(gettemplate('adm/news_edit_form'),$planet);
	}
	elseif($_GET['action'] == 'create') {
		$parse['show_edit_form'] = gettemplate('adm/news_create_form');
	}
	elseif(($_GET['action'] == 'delete') && isset($_GET['id'])) {
		$db->query("DELETE FROM ".NEWS." WHERE `id` = '".$_GET['id']."' LIMIT 1;");
	}
	if(isset($_POST['submit'])) {
		$edit_id 	= request_var('currid',0);
		$title 		= $db->sql_escape(request_var('title','',true));
		$text 		= $db->sql_escape(request_var('text','',true));
		$query		= (isset($_GET['gone'])) ? "INSERT INTO ".NEWS." (`id` ,`user` ,`date` ,`title` ,`text`) VALUES ( NULL , '".$user['username']."', '".time()."', '".$title."', '".$text."');" : "UPDATE ".NEWS." SET `title` = '".$title."', `text` = '".$text."', `date` = '".time()."' WHERE `id` = '".$edit_id."' LIMIT 1;";
		
		$db->query($query);
		
		header("location:NewsPage.php");	
	}
	display(parsetemplate(gettemplate('adm/newslist_body'), $parse), false, '', true, false);

// Created by e-Zobar. All rights reversed (C) XNova Team 2008
?>