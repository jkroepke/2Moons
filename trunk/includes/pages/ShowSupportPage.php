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
	public function ShowSupportPage()
	{
		$action 		= request_var('action', "");
		$id 			= request_var('id', 0);
		
		$PlanetRess = new ResourceUpdate();
		$PlanetRess->CalcResource();
		$PlanetRess->SavePlanetToDB();
		
		$this->template	= new template();
		
		$this->template->page_header();
		$this->template->page_topnav();
		$this->template->page_leftmenu();
		$this->template->page_planetmenu();
		$this->template->page_footer();
		switch($action){
			case 'newticket':
				$this->CreaeTicket();
			break;
			case 'send':
				$this->UpdateTicket($id);
			break;
			default:
				$this->ShowSupportTickets();
			break;
		}
	}

	private function CreaeTicket()
	{
		global $USER, $db, $LNG;
		
		$subject = request_var('subject','',true);
		$text 	 = makebr(request_var('text','',true));

		if(empty($text) || empty($subject))
			exit($this->template->message($LNG['sendit_error_msg'],"game.php?page=support", 3));

		$Qryinsertticket  = "INSERT ".SUPP." SET ";
		$Qryinsertticket .= "`player_id` = '". $USER['id'] ."',";
		$Qryinsertticket .= "`subject` = '". $db->sql_escape($subject) ."',";
		$Qryinsertticket .= "`text` = '" .$db->sql_escape($text) ."',";
		$Qryinsertticket .= "`time` = '". TIMESTAMP ."',";
		$Qryinsertticket .= "`status` = '1'";
		$db->query($Qryinsertticket);
		
		$this->template->message($LNG['sendit_t'],"game.php?page=support", 3);
	}
	
	private function UpdateTicket($TicketID) 
	{
		global $USER, $db, $LNG;
		
		$text = request_var('text','',true);
		
		if(empty($text))
			exit($this->template->message($LNG['sendit_error_msg'],"game.php?page=support", 3));
		
		$ticket = $db->uniquequery("SELECT text FROM ".SUPP." WHERE `id` = '".$TicketID."';");

		$text 	= $ticket['text'].'<br><br><hr>'.$USER['username'].' schreib am '.date("d. M Y H:i:s", TIMESTAMP).'<br><br>'.makebr($text).'';
		$db->query("UPDATE ".SUPP." SET `text` = '".$db->sql_escape($text) ."',`status` = '3' WHERE `id` = '". $db->sql_escape($TicketID) ."';");
		$this->template->message($LNG['sendit_a'],"game.php?page=support", 3);
	}
	
	private function ShowSupportTickets()
	{
		global $USER, $PLANET, $db, $LNG;
				
		$query		= $db->query("SELECT ID,time,text,subject,status FROM ".SUPP." WHERE `player_id` = '".$USER['id']."';");
		
		while($ticket = $db->fetch_array($query)){	
			$TicketsList[$ticket['ID']]	= array(
				'status'	=> $ticket['status'],
				'subject'	=> $ticket['subject'],
				'date'		=> date("j. M Y H:i:s",$ticket['time']),
				'text'		=> html_entity_decode($ticket['text'], ENT_NOQUOTES, "UTF-8"),
			);
		}

		$db->free_result($query);
			
		$this->template->assign_vars(array(	
			'TicketsList'			=> $TicketsList,
			'text'					=> $LNG['text'],
			'supp_header'			=> $LNG['supp_header'],
			'ticket_id'				=> $LNG['ticket_id'],
			'subject'				=> $LNG['subject'],
			'status'				=> $LNG['status'],
			'ticket_posted'			=> $LNG['ticket_posted'],
			'supp_send'				=> $LNG['supp_send'],
			'supp_close'			=> $LNG['supp_close'],
			'supp_open'				=> $LNG['supp_open'],
			'supp_admin_answer'		=> $LNG['supp_admin_answer'],
			'supp_player_answer'	=> $LNG['supp_player_answer'],
			'supp_ticket_close'		=> $LNG['supp_ticket_close'],	
			'subject'				=> $LNG['subject'],
			'status'				=> $LNG['status'],
			'ticket_new'			=> $LNG['ticket_new'],		
		));
			
		$this->template->show("support_overview.tpl");
	}
}
?>