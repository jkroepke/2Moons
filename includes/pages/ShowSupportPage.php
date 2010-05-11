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

class ShowSupportPage 
{
	public function ShowSupportPage($CurrentUser, $CurrentPlanet)
	{
		$action 		= request_var('action', "");
		$id 			= request_var('id', 0);
		$this->template	= new template();
		$this->template->set_vars($CurrentUser, $CurrentPlanet);
		$this->template->page_header();
		$this->template->page_topnav();
		$this->template->page_leftmenu();
		$this->template->page_planetmenu();
		$this->template->page_footer();
		switch($action){
			case 'newticket':
				$this->CreaeTicket($CurrentUser);
			break;
			case 'send':
				$this->UpdateTicket($CurrentUser, $id);
			break;
			default:
				$this->ShowSupportTickets($CurrentUser, $CurrentPlanet);
			break;
		}
	}

	private function CreaeTicket($CurrentUser)
	{
		global $db, $lang;
		
		$subject = request_var('subject','',true);
		$text 	 = makebr(request_var('text','',true));

		if(empty($text) || empty($subject))
			exit($this->template->message($lang['sendit_error_msg'],"game.php?page=support", 3));

		$Qryinsertticket  = "INSERT ".SUPP." SET ";
		$Qryinsertticket .= "`player_id` = '". $CurrentUser['id'] ."',";
		$Qryinsertticket .= "`subject` = '". $db->sql_escape($subject) ."',";
		$Qryinsertticket .= "`text` = '" .$db->sql_escape($text) ."',";
		$Qryinsertticket .= "`time` = '". time() ."',";
		$Qryinsertticket .= "`status` = '1'";
		$db->query($Qryinsertticket);
		var_dump($text);
		$this->template->message($lang['sendit_t'],"game.php?page=support", 30);
	}
	
	private function UpdateTicket($CurrentUser, $TicketID) 
	{
		global $db, $lang;
		
		$text = request_var('text','',true);

		if(empty($text))
			exit($this->template->message($lang['sendit_error_msg'],"game.php?page=support", 3));
		
		$ticket = $db->fetch_array($db->query("SELECT text FROM ".SUPP." WHERE `id` = '".$TicketID."';"));

		$text 	= $ticket['text'].'<br><br><hr>'.$CurrentUser['username'].' schreib am '.date("d. M Y H:i:s", time()).'<br><br>'.makebr($text).'';
		$db->query("UPDATE ".SUPP." SET `text` = '".$db->sql_escape($text) ."',`status` = '3' WHERE `id` = '". $db->sql_escape($TicketID) ."';");
		$this->template->message($lang['sendit_a'],"game.php?page=support", 3);
	}
	
	private function ShowSupportTickets($CurrentUser, $CurrentPlanet)
	{
		global $db, $lang;
		$PlanetRess = new ResourceUpdate($CurrentUser, $CurrentPlanet);
		$this->template->set_vars($CurrentUser, $CurrentPlanet);
			
		$query		= $db->query("SELECT ID,time,text,subject,status FROM ".SUPP." WHERE `player_id` = '".$CurrentUser['id']."';");
		
		while($ticket = $db->fetch_array($query)){	
			$TicketsList[$ticket['ID']]	= array(
				'status'	=> $ticket['status'],
				'subject'	=> $ticket['subject'],
				'date'		=> date("j. M Y H:i:s",$ticket['time']),
				'text'		=> html_entity_decode($ticket['text'], ENT_NOQUOTES, "UTF-8"),
			);
		}		
			
		$this->template->assign_vars(array(	
			'TicketsList'			=> $TicketsList,
			'text'					=> $lang['text'],
			'supp_header'			=> $lang['supp_header'],
			'ticket_id'				=> $lang['ticket_id'],
			'subject'				=> $lang['subject'],
			'status'				=> $lang['status'],
			'ticket_posted'			=> $lang['ticket_posted'],
			'supp_close'			=> $lang['supp_close'],
			'supp_open'				=> $lang['supp_open'],
			'supp_admin_answer'		=> $lang['supp_admin_answer'],
			'supp_player_answer'	=> $lang['supp_player_answer'],
			'supp_ticket_close'		=> $lang['supp_ticket_close'],	
			'subject'				=> $lang['subject'],
			'status'				=> $lang['status'],
			'ticket_new'			=> $lang['ticket_new'],		
		));
			
		$this->template->show("support_overview.tpl");
		$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);	
	}
}
?>