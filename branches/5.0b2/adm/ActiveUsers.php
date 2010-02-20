<?php

##############################################################################
# *																			 #
# * RN FRAMEWORK															 #
# *  																		 #
# * @copyright Copyright (C) 2009 By ShadoX from xnova-reloaded.de	 		 #
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

if ($EditUsers != 1) die();

$parse = $lang;
$query = $db->query("SELECT * FROM ".USERS_VALID." ORDER BY id ASC");
$id = request_var('id',0);
$i = 0;
while ($u = $db->fetch_array($query)) {
	$parse['planetes'] .= "<tr>"
	. "<th><center><b>" . $u['id'] . "</center></b></th>"
	. "<th><center><b>" . $u['username'] . "</center></b></th>"
	. "<th><center><b><nobr>" . date("d.m.Y H:i:s",$u['date']) . "</nobr></center></b></th>"
	. "<th><center><b>" . $u['email'] . "</center></b></th>"
	. "<th><center><b>" . $u['ip'] . "</center></b></th>"
	. "<th align=\"center\"><a href=\"javascript:ajax('../index.php?page=reg&mode=valid&id=" . $u['password'] . "&clef=" . $u['cle'] . "&admin=1&getajax=1','".$u['username']."');\">Aktivieren</a></th>"
	. "<th align=\"center\"><a href='?action=delete&id=".$u['id']."' onclick=\"return confirm('Bist du sicher, dass du den User " . $u['username'] . " entfernen willst?');\"><img border=\"0\" src=\"../styles/images/r1.png\"></a></th>"
	. "</tr>";
	$i++;
}
$parse['planetes'] .= "<tr><th class=\"b\" colspan=\"8\">Insgesamt ".$i." nicht aktivierte User vorhanden</th></tr>";

if(($_GET['action'] == 'delete') && $id) {
	$db->query("DELETE FROM ".USERS_VALID." WHERE `id` = '".$db->sql_escape($id)."' LIMIT 1;");
	header("location:ActiveUsers.php");
}
display(parsetemplate(gettemplate('adm/ActiveUsersBody'), $parse), false, '', true, false);


// Created by e-Zobar. All rights reversed (C) XNova Team 2008
?>