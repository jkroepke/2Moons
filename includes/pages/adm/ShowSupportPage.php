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

if ($USER['rights'][str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__)] != 1) exit;
		
function ShowSupportPage()
{
	global $USER, $LNG, $db;

	$template			= new template();
	
	$ID	= request_var('id', 0);
	
	switch($_GET['action'])
	{
		case 'send':
			$text	= nl2br(request_var('text', '', true));
			if(empty($text)){
				$template->message($LNG['sendit_error_msg'], '?page=support&action=detail&id='.$ID);
				exit;
			}

			$ticket = $db->uniquequery("SELECT `player_id`, `text` FROM ".SUPP." WHERE `id` = '".$ID."';");
			$newtext = $ticket['text'].'<br><br><hr>'.sprintf($LNG['sp_admin_answer'], $USER['username'], date("j. M Y H:i:s", TIMESTAMP), $text);

			$SQL  = "UPDATE ".SUPP." SET ";
			$SQL .= "`text` = '".$db->sql_escape($newtext)."',";
			$SQL .= "`status` = '2'";
			$SQL .= "WHERE ";
			$SQL .= "`id` = '".$ID."' ";
			$db->query($SQL);
			SendSimpleMessage($ticket['player_id'], '', TIMESTAMP, 4, $USER['username'], sprintf($LNG['sp_answer_message_title'], $ID), sprintf($LNG['sp_answer_message'], $ID)); 
		break;
		case 'open':
			$ticket = $db->uniquequery("SELECT text FROM ".SUPP." WHERE `id` = '".$ID."';");
			$newtext = $ticket['text'].'<br><br><hr>'.sprintf($LNG['sp_admin_closed'], $USER['username'], date("j. M Y H:i:s", TIMESTAMP));
			$SQL  = "UPDATE ".SUPP." SET ";
			$SQL .= "`text` = '".$db->sql_escape($newtext)."',";
			$SQL .= "`status` = '2'";
			$SQL .= "WHERE ";
			$SQL .= "`id` = '".$ID."' ";
			$db->query($SQL);
		break;
		case 'close':
			$ticket = $db->uniquequery("SELECT text FROM ".SUPP." WHERE `id` = '".$ID."';");
			$newtext = $ticket['text'].'<br><br><hr>'.sprintf($LNG['sp_admin_open'], $USER['username'], date("j. M Y H:i:s", TIMESTAMP));
			$SQL  = "UPDATE ".SUPP." SET ";
			$SQL .= "`text` = '".$db->sql_escape($newtext)."',";
			$SQL .= "`status` = '0'";
			$SQL .= "WHERE ";
			$SQL .= "`id` = '".$ID."' ";
			$db->query($SQL);
		break;
	}
	
	$tickets	= array('open' => array(), 'closed' => array());
	$query = $db->query("SELECT s.*, u.username FROM ".SUPP." as s, ".USERS." as u WHERE u.id = s.player_id ORDER BY s.time;");
	while($ticket = $db->fetch_array($query))
	{
		switch($ticket['status']){
			case 0:
				$status = '<font color="red">'.$LNG['supp_close'].'</font>';
			break;
			case 1:
				$status = '<font color="green">'.$LNG['supp_open'].'</font>';
			break;
			case 2:
				$status = '<font color="orange">'.$LNG['supp_admin_answer'].'</font>';
			break;
			case 3:
				$status = '<font color="green">'.$LNG['supp_player_answer'].'</font>';
			break;
		}
		
		if($_GET['action'] == 'detail' && $ID == $ticket['ID'])
			$TINFO	= $ticket;
			
		if($ticket['status'] == 0){	
			if($_GET['action'] == 'detail')
				continue;
				
			$tickets['closed'][]	= array(
				'id'		=> $ticket['ID'],
				'username'	=> $ticket['username'],
				'subject'	=> $ticket['subject'],
				'status'	=> $status,
				'date'		=> date("j. M Y H:i:s",$ticket['time'])
			);	
		} else {
			$tickets['open'][]	= array(
				'id'		=> $ticket['ID'],
				'username'	=> $ticket['username'],
				'subject'	=> $ticket['subject'],
				'status'	=> $status,
				'date'		=> date("j. M Y H:i:s",$ticket['time'])
			);
		}
		
	}
	
	if($_GET['action'] == 'detail')
	{
		switch($TINFO['status']){
			case 0:
				$status = '<font color="red">'.$LNG['supp_close'].'</font>';
			break;
			case 1:
				$status = '<font color="green">'.$LNG['supp_open'].'</font>';
			break;
			case 2:
				$status = '<font color="orange">'.$LNG['supp_admin_answer'].'</font>';
			break;
			case 3:
				$status = '<font color="green">'.$LNG['supp_player_answer'].'</font>';
			break;
		}		
			
		$template->assign_vars(array(
			't_id'			=> $TINFO['ID'],
			't_username'	=> $TINFO['username'],
			't_statustext'	=> $status,
			't_status'		=> $TINFO['status'],
			't_text'		=> $TINFO['text'],
			't_subject'		=> $TINFO['subject'],
			't_date'		=> date("j. M Y H:i:s", $TINFO['time']),
			'text'			=> $LNG['text'],
			'answer_new'	=> $LNG['answer_new'],
			'button_submit'	=> $LNG['button_submit'],
			'open_ticket'	=> $LNG['open_ticket'],
			'close_ticket'	=> $LNG['close_ticket'],
		));	
	}	
	
	$template->assign_vars(array(
		'tickets'			=> $tickets,
		'supp_header'		=> $LNG['supp_header'],
		'supp_header_g'		=> $LNG['supp_header_g'],
		'ticket_id'			=> $LNG['ticket_id'],
		'player'			=> $LNG['player'],
		'subject'			=> $LNG['subject'],
		'status'			=> $LNG['status'],
		'ticket_posted'		=> $LNG['ticket_posted'],
	));

	$template->show('adm/SupportPage.tpl');

}	
?>