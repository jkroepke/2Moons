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
$parse     = $LNG;
		
		
if($_GET['ticket'] == 0){
/// Deteilsanzeige des eigenen tickets
		$query = $db->query("SELECT s.* ,u.id, u.username FROM ".SUPP." as s, ".USERS." as u WHERE u.id=s.player_id ORDER BY s.time;");
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
		if($ticket['status'] == 0){	
		$parse['tickets_g'] .= "<tr>"
						    ."<th>".$ticket['ID']."</th>"
						    ."<th>".$playername."</th>"
							."<th><a href='?ticket=".$ticket['ID']."'>".$ticket['subject']."</a></th>"
							."<th>". $status ."</th>"
							."<th>".date("j. M Y H:i:s",$ticket['time'])."</th>"
							."</tr>";
		}else {
		$parse['tickets'] .= "<tr>"
						    ."<th>".$ticket['ID']."</th>"
						    ."<th>".$playername."</th>"
							."<th><a href='?ticket=".$ticket['ID']."'>".$ticket['subject']."</a></th>"
							."<th>". $status ."</th>"
							."<th>".date("j. M Y H:i:s",$ticket['time'])."</th>"
							."</tr>";		
		}
		}
		display(parsetemplate(gettemplate('adm/supp'), $parse), false, '', true, false);
		




}elseif($_GET['sendenticket'] =="1"){
/// Eintragen eines Neuen Tickets


$subject = $_POST['senden_ticket_subject'];
$tickettext = $_POST['senden_ticket_text'];
$time = TIMESTAMP;

if(empty($tickettext) OR empty($subject)){

	display(parsetemplate(gettemplate('adm/supp_t_send_error'),$parse), false, '', true, false);
}else{
		$Qryinsertticket  = "INSERT ".SUPP." SET ";
		$Qryinsertticket .= "`player_id` = '". $USER['id'] ."',";
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
/// Pr¸fen ob beide felder mit Text versehen sind
		display(parsetemplate(gettemplate('adm/supp_t_send_error'), $parse), false, '', true, false);
}else{

		$query = $db->query("SELECT * FROM ".SUPP." WHERE `id` = '".$antwortticketid."';");
		while($ticket = $db->fetch_array($query))
		{
		$newtext = $ticket['text'].'<br><br><hr>'.$USER['username'].'(Admin) schreib am '.date("j. M Y H:i:s", TIMESTAMP).'<br><br><font color="red">'.$antworttext.'</font>';

		$QryUpdatemsg  = "UPDATE ".SUPP." SET ";
		$QryUpdatemsg .= "`text` = '".$db->sql_escape($newtext)."',";
		$QryUpdatemsg .= "`status` = '2'";
		$QryUpdatemsg .= "WHERE ";
		$QryUpdatemsg .= "`id` = '". $antwortticketid ."' ";
		$db->query( $QryUpdatemsg);
		$SuppTicket	= $db->fetch_array($db->query("SELECT player_id FROM ".SUPP." WHERE `id` = '". $antwortticketid ."'"));
		SendSimpleMessage($SuppTicket['player_id'], '', TIMESTAMP, 4, $USER['username'], "Support Ticket #".$antwortticketid, "Es wurde auf Ihr Ticket #".$antwortticketid." eine Antwort geschreiben!");
		header("Location: SupportPage.php");
	}

}
}elseif($_GET['schliessen'] =="1"){
		$schlieﬂen = $_GET['ticket'];
		$ticket = $db->fetch_array($db->query("SELECT text FROM ".SUPP." WHERE `id` = '".$schlieﬂen."';"));
		$newtext = $ticket['text'].'<br><br><hr>'.$USER['username'].'(Admin) hat das Ticket am '.date("j. M Y H:i:s", TIMESTAMP).' geschlossen!';
		$QryUpdatemsg  = "UPDATE ".SUPP." SET ";
		$QryUpdatemsg .= "`text` = '".$db->sql_escape($newtext)."',";
		$QryUpdatemsg .= "`status` = '0'";
		$QryUpdatemsg .= "WHERE ";
		$QryUpdatemsg .= "`id` = '". $schlieﬂen ."' ";
		$db->query( $QryUpdatemsg);
		header("Location: SupportPage.php");
	
}elseif($_GET['offnen'] =="1"){
		$schlieﬂen = $_GET['ticket'];
		$ticket = $db->fetch_array($db->query("SELECT text FROM ".SUPP." WHERE `id` = '".$schlieﬂen."';"));
		$newtext = $ticket['text'].'<br><br><hr>'.$USER['username'].'(Admin) hat das Ticket am '.date("j. M Y H:i:s", TIMESTAMP).' ge&ouml;ffnet!';
		$QryUpdatemsg  = "UPDATE ".SUPP." SET ";
		$QryUpdatemsg .= "`text` = '".$db->sql_escape($newtext)."',";
		$QryUpdatemsg .= "`status` = '2'";
		$QryUpdatemsg .= "WHERE ";
		$QryUpdatemsg .= "`id` = '". $schlieﬂen ."' ";
		$db->query( $QryUpdatemsg);
		header("Location: SupportPage.php");
	
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
	
		$parse['closeopen'] = ($ticket2['status'] != 0) ? "<form action=\"?ticket=".$ticket2['ID']."&schliessen=1\" method=\"POST\"><input type=\"hidden\" name=\"ticket\" value=\"".$ticket2['ID']."\"> <center><input type=\"submit\" value=\"".$LNG['close_ticket']."\"></center> </form>" : "<form action=\"?ticket=".$ticket2['ID']."&offnen=1\" method=\"POST\"><input type=\"hidden\" name=\"ticket\" value=\"".$ticket2['ID']."\"><center><input type=\"submit\" value=\"".$LNG['open_ticket']."\"></center></form>";
	display(parsetemplate(gettemplate('adm/supp_detail'), $parse), false, '', true, false);
}

}
	
?>