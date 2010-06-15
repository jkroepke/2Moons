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

if(!defined('INSIDE')) die('Hacking attempt!');

function ShowMessagesPage()
{
	global $USER, $PLANET, $CONF, $dpath, $LNG, $db;

	$MessCategory  	= request_var('messcat',0);
	$MessPageMode  	= request_var('mode', '');
	$DeleteWhat    	= request_var('deletemessages','');
	$Send 		  	= request_var('send',0);
	$OwnerID       	= request_var('id', 0);
	$Subject 		= request_var('subject', '', true);
	
	$MessageType   	= array ( 0, 1, 2, 3, 4, 5, 15, 50, 99, 100, 999);
	$TitleColor    	= array ( 0 => '#FFFF00', 1 => '#FF6699', 2 => '#FF3300', 3 => '#FF9900', 4 => '#773399', 5 => '#009933', 15 => '#6495ed', 50 => '#666600', 99 => '#007070', 100 => '#ABABAB', 999 => '#CCCCCC');

	$template		= new template();
	
	switch ($MessPageMode)
	{
		case 'write':
			$template->page_header();
			$template->page_footer();		
			$OwnerRecord = $db->uniquequery("SELECT a.galaxy, a.system, a.planet, b.username, b.id_planet FROM ".PLANETS." as a, ".USERS." as b WHERE b.id = '".$OwnerID."' AND a.id = b.id_planet;");

			if (!$OwnerRecord)
				$template->message($LNG['mg_error'], false, 0, true);
			
			if ($Send)
			{
				$Owner   = $OwnerID;
				$Message = makebr(request_var('text', '', true));
				$From    = $USER['username'].' ['.$USER['galaxy'].':'.$USER['system'].':'.$USER['planet'].']';
				SendSimpleMessage($OwnerID, $USER['id'], '', 1, $From, $Subject, $Message);
				exit($LNG['mg_message_send']);
			}

			$template->assign_vars(array(	
				'mg_send_new'	=> $LNG['mg_send_new'],
				'mg_send_to'	=> $LNG['mg_send_to'],
				'mg_send'		=> $LNG['mg_send'],
				'mg_message'	=> $LNG['mg_message'],
				'mg_characters'	=> $LNG['mg_characters'],
				'mg_subject'	=> $LNG['mg_subject'],
				'mg_empty_text'	=> $LNG['mg_empty_text'],
				'subject'		=> (empty($Subject)) ? $LNG['mg_no_subject'] : $Subject,
				'id'			=> $OwnerID,
				'username'		=> $OwnerRecord['username'],
				'galaxy'		=> $OwnerRecord['galaxy'],
				'system'		=> $OwnerRecord['system'],
				'planet'		=> $OwnerRecord['planet'],
			));
			
			$template->show("message_send_form.tpl");		
		break;
		case 'delete':
			$DeleteWhat = request_var('deletemessages','');
			$MessType	= request_var('mess_type', 0);
			
			if($MessType == 100 && $DeleteWhat == 'deletetypeall')
				$DeleteWhat	= 'deleteall';
				
			switch($DeleteWhat)
			{
				case 'deleteall':
					$db->query("DELETE FROM ".MESSAGES." WHERE `message_owner` = '". $USER['id'] ."';");
				break;
				case 'deletetypeall':
					$db->query("DELETE FROM ".MESSAGES." WHERE `message_owner` = '". $USER['id'] ."' AND `message_type` = '".$MessType."';");
				case 'deletemarked':
					if(!empty($_POST['delmes']) && is_array($_POST['delmes']))
					{
						$SQLWhere = array();
						foreach($_POST['delmes'] as $id => $b)
						{
							$SQLWhere[] = "`message_id` = '".(int) $id."'";
						}
						
						$db->query("DELETE FROM ".MESSAGES." WHERE (".implode(" OR ",$SQLWhere).") AND `message_owner` = '". $USER['id'] ."'".(($MessType != 100)? " AND `message_type` = '".$MessType."' ":"").";");
					}
				break;
				case 'deleteunmarked':
					if(!empty($_POST['delmes']) && is_array($_POST['delmes']))
					{
						$SQLWhere = array();
						foreach($_POST['delmes'] as $id => $b)
						{
							$SQLWhere[] = "`message_id` != '".(int) $id."'";
						}
						
						$db->query("DELETE FROM ".MESSAGES." WHERE (".implode(" AND ",$SQLWhere).") AND `message_owner` = '". $USER['id'] ."'".(($MessType != 100)? " AND `message_type` = '".$MessType."' ":"").";");
					}
				break;
			}
			header("Location:game.php?page=messages");
		break;
		case 'show':
			if($MessCategory == 999)
			{
				$UsrMess = $db->query("SELECT * FROM ".MESSAGES." WHERE `message_sender` = '".$USER['id']."' ORDER BY `message_time` DESC;");
					
				while ($CurMess = $db->fetch_array($UsrMess))
				{
					$CurrUsername	= $db->fetch_array($db->query("SELECT `username`, `galaxy`, `system`, `planet` FROM ".USERS." WHERE id = '".$CurMess['message_owner']."';"));
					
					$MessageList[$CurMess['message_id']]	= array(
						'time'		=> date("d. M Y, H:i:s", $CurMess['message_time']),
						'from'		=> $CurrUsername['username']." [".$CurrUsername['galaxy'].":".$CurrUsername['system'].":".$CurrUsername['planet']."]",
						'subject'	=> $CurMess['message_subject'],
						'type'		=> $CurMess['message_type'],
						'text'		=> $CurMess['message_text'],
					);
				}			
			} else {
				if($MessCategory == 50)
					$UsrMess = $db->query("SELECT * FROM ".MESSAGES." WHERE `message_owner` = '0' AND `message_type` = '".$MessCategory."' ORDER BY `message_time` DESC;");
				elseif($MessCategory == 100)
					$UsrMess = $db->query("SELECT * FROM ".MESSAGES." WHERE `message_owner` = '".$USER['id']."' ORDER BY `message_time` DESC;");
				else
					$UsrMess = $db->query("SELECT * FROM ".MESSAGES." WHERE `message_owner` = '".$USER['id']."' AND `message_type` = '".$MessCategory."' ORDER BY `message_time` DESC;");
				
				$UnRead	= 0;
					
				while ($CurMess = $db->fetch_array($UsrMess))
				{
					$UnRead	+= $CurMess['message_unread'];
					$MessageList[$CurMess['message_id']]	= array(
						'time'		=> date("d. M Y, H:i:s", $CurMess['message_time']),
						'from'		=> $CurMess['message_from'],
						'subject'	=> stripslashes($CurMess['message_subject']),
						'type'		=> $CurMess['message_type'],
						'sender'	=> $CurMess['message_sender'],
						'text'		=> stripslashes($CurMess['message_text']),
					);
				}
				
				$db->free_result($UsrMess);
				$db->multi_query("UPDATE ".USERS." SET `new_message` = ".(($MessCategory != 100) ? "IF(`new_message` - '".$UnRead."' < 0, `new_message` - '".$UnRead."', 0)" : "'0'")." WHERE `id` = '".$USER['id']."';UPDATE ".MESSAGES." SET `message_unread` = '0' WHERE `message_owner` = '".$USER['id']."'".(($MessCategory != 100) ? " AND `message_type` = '".$MessCategory."'" : "").";");
			}
			
			$template->assign_vars(array(	
				'MessageList'						=> $MessageList,
				'mg_message_title'					=> $LNG['mg_message_title'],
				'mg_action'							=> $LNG['mg_action'],
				'mg_date'							=> $LNG['mg_date'],
				'mg_from'							=> $LNG['mg_from'],
				'mg_to'								=> $LNG['mg_to'],
				'mg_subject'						=> $LNG['mg_subject'],
				'mg_show_only_header_spy_reports'	=> $LNG['mg_show_only_header_spy_reports'],
				'mg_delete_marked'					=> $LNG['mg_delete_marked'],
				'mg_delete_type_all'				=> $LNG['mg_delete_type_all'],
				'mg_delete_unmarked'				=> $LNG['mg_delete_unmarked'],
				'mg_delete_all'						=> $LNG['mg_delete_all'],
				'mg_confirm_delete'					=> $LNG['mg_confirm_delete'],
				'mg_game_message'					=> $LNG['mg_game_message'],
				'dpath'								=> $USER['dpath'],
				'MessCategory'						=> $MessCategory,
			));
			$template->show("message_show.tpl");			
		break;
		default:
			$PlanetRess = new ResourceUpdate();
			$PlanetRess->CalcResource();
			$PlanetRess->SavePlanetToDB();
			
			$template->page_header();
			$template->page_topnav();
			$template->page_leftmenu();
			$template->page_planetmenu();
			$template->page_footer();
	
			$UsrMess 	= $db->query("SELECT `message_type`, `message_unread` FROM ".MESSAGES." WHERE `message_owner` = '".$USER['id']."' OR `message_type` = '50';");
			$GameOps 	= $db->query("SELECT `username`, `email` FROM ".USERS." WHERE `authlevel` != '0' ORDER BY `username` ASC;");
			$MessOut	= $db->uniquequery("SELECT COUNT(*) as count FROM ".MESSAGES." WHERE message_sender = '".$USER['id']."';");
			
			while($Ops = $db->fetch_array($GameOps))
			{	
				$OpsList[]	= array(
					'username'	=> $Ops['username'],
					'email'		=> $Ops['email'],
				);
			}

			$db->free_result($GameOps);
			
			while ($CurMess = $db->fetch_array($UsrMess))
			{
				$UnRead[$CurMess['message_type']]		+= $CurMess['message_unread'];
				$TotalMess[$CurMess['message_type']]	+= 1;
			}
			
			$db->free_result($UsrMess);
			
			$UnRead[100]		= is_array($UnRead) ? array_sum($UnRead) : 0;
			$TotalMess[100]		= is_array($TotalMess) ? (array_sum($TotalMess) - $TotalMess[50]) : 0;
			$TotalMess[999]		= $MessOut['count'];
			
			
			foreach($TitleColor as $MessageID => $MessageColor) {
				$MessageList[$MessageID]	= array(
					'color'		=> $MessageColor,
					'unread'	=> !empty($UnRead[$MessageID]) ? $UnRead[$MessageID] : 0,
					'total'		=> !empty($TotalMess[$MessageID]) ? $TotalMess[$MessageID] : 0,
					'lang'		=> $LNG['mg_type'][$MessageID],
				);
			}
			
			$template->assign_vars(array(	
				'MessageList'		=> $MessageList,
				'OpsList'			=> $OpsList,
				'mg_overview'		=> $LNG['mg_overview'],
				'mg_game_operators'	=> $LNG['mg_game_operators'],
			));
			
			$template->show("message_overview.tpl");
		break;
	}
}
?>