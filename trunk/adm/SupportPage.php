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

define('ROOT_PATH', './../');
include(ROOT_PATH . 'extension.inc');
include(ROOT_PATH . 'common.' . PHP_EXT);


if ($Observation != 1) die();
includeLang('INGAME');
$parse     = $lang;
		
		
if($_GET['ticket'] == 0){
/// Deteilsanzeige des eigenen tickets
		$query = $db->query("SELECT s.* ,u.id, u.username as username FROM ".SUPP." as s, ".USERS." as u WHERE status >= '1' AND  u.id=s.player_id ORDER BY s.time;");
		while($ticket = $db->fetch_array($query)){
			switch($ticket['status']){
				case 0:
				$status = "<font color=red>Geschlossen</font>";
				break;
				case 1:
				$status = "<font color=green>Offen</font>";
				break;
				case 2:
				$status = "<font color=orange>Admin-Antwort</font>";
				break;
				case 3:
				$status = "<font color=green>Spieler-Antwort</font>";
				break;
			}	
		
		$playername = $ticket['username'];	
				
		$parse['tickets'] .= "<tr>"
						    ."<th>".$ticket['ID']."</th>"
						    ."<th>".$playername."</th>"
							."<th><a href='?ticket=".$ticket['ID']."'>".$ticket['subject']."</a></th>"
							."<th>". $status ."</th>"
							."<th>".date("j. M Y H:i:s",$ticket['time'])."</th>"
							."</tr>";

		}
		display(parsetemplate(gettemplate('adm/supp'), $parse), false, '', true, false);
		




}elseif($_GET['sendenticket'] =="1"){
/// Eintragen eines Neuen Tickets


$subject = $_POST['senden_ticket_subject'];
$tickettext = $_POST['senden_ticket_text'];
$time = time();

if(empty($tickettext) OR empty($subject)){

	display(parsetemplate(gettemplate('adm/supp_t_send_error'),$parse), false, '', true, false);
}else{
		$Qryinsertticket  = "INSERT ".SUPP." SET ";
		$Qryinsertticket .= "`player_id` = '". $user['id'] ."',";
		$Qryinsertticket .= "`subject` = '". $subject ."',";
		$Qryinsertticket .= "`text` = '". $db->sql_escape($tickettext) ."',";
		$Qryinsertticket .= "`time` = '". $time ."',";
		$Qryinsertticket .= "`status` = '1'";
		$db->query( $Qryinsertticket);
		display(parsetemplate(gettemplate('adm/supp_t_send'), $parse), false, '', true, false);
}
}elseif($_GET['sendenantwort'] =="1"){
/// Eintragen der neuen Antwort
	$antworttext = nl2br($_POST['senden_antwort_text']);
	$antwortticketid = $_POST['senden_antwort_id'];

if(empty($antworttext) OR empty($antwortticketid)){
/// Prüfen ob beide felder mit Text versehen sind
		display(parsetemplate(gettemplate('adm/supp_t_send_error'), $parse), false, '', true, false);
}else{

		$query = $db->query("SELECT * FROM ".SUPP." WHERE `id` = '".$antwortticketid."';");
		while($ticket = $db->fetch_array($query))
		{
		$newtext = $ticket['text'].'<br><br><hr>'.$user['username'].'(Admin) schreib am '.date("j. M Y H:i:s", time()).'<br><br><font color="red">'.$antworttext.'</font>';

		$QryUpdatemsg  = "UPDATE ".SUPP." SET ";
		$QryUpdatemsg .= "`text` = '".$db->sql_escape($newtext)."',";
		$QryUpdatemsg .= "`status` = '2'";
		$QryUpdatemsg .= "WHERE ";
		$QryUpdatemsg .= "`id` = '". $antwortticketid ."' ";
		$db->query( $QryUpdatemsg);
		$SuppTicket	= $db->fetch_array($db->query("SELECT player_id FROM ".SUPP." WHERE `id` = '". $antwortticketid ."'"));
		SendSimpleMessage($SuppTicket['player_id'], '', time(), 4, $user['username'], "Support Ticket #".$antwortticketid, "Es wurde auf Ihr Ticket #".$antwortticketid." eine Antwort geschreiben!");
		header("Location: SupportPage.php");
	}

}
}elseif($_GET['schliessen'] =="1"){
		$schließen = $_GET['ticket'];
	
		$QryUpdatemsg  = "UPDATE ".SUPP." SET ";
		$QryUpdatemsg .= "`status` = '0'";
		$QryUpdatemsg .= "WHERE ";
		$QryUpdatemsg .= "`id` = '". $schließen ."' ";
		$db->query( $QryUpdatemsg);
		display(parsetemplate(gettemplate('adm/supp_t_close'), $parse) , false, '', true, false);
	
}else{
/// Listenanzeige des einen tickets
	$query2 = $db->query("SELECT s.*, u.username as username , u.id FROM ".SUPP." as s, ".USERS." as u  WHERE s.ID = '".$_GET['ticket']."' AND u.id=s.player_id;");
	while($ticket2 = $db->fetch_array($query2)){
			switch($ticket2['status']){
				case 0:
				$status = "<font color=red>Geschlossen</font>";
				break;
				case 1:
				$status = "<font color=green>Offen</font>";
				break;
				case 2:
				$status = "<font color=yellow>Admin-Antwort</font>";
				break;
				case 3:
				$status = "<font color=green>Spieler-Antwort</font>";
				break;
			}	
		
		$playername2 = $ticket2['username'];	
				
		$parse['tickets'] .= "<tr><td class='b'>".$ticket2['ID']."</td>"
						    ."<td class='b'>".$playername2."</td>"
							."<td class='b'>".$ticket2['subject']."</td>"
							."<td class='b'>".$status."</td>"
							."<td class='b'>".date("j. M Y H:i:s",$ticket2['time'])."</td>"
							."</tr>";

		$parse['text_view'] = $ticket2['text'];
		$parse['id'] = $ticket2['ID'];
	

	display(parsetemplate(gettemplate('adm/supp_detail'), $parse), false, '', true, false);
}

}
	
?>