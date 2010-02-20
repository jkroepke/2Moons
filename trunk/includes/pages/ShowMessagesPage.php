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

if(!defined('INSIDE')){ die(header("location:../../"));}

function ShowMessagesPage($CurrentUser, $CurrentPlanet)
{
	global $xgp_root, $phpEx, $game_config, $dpath, $lang, $db;

	$MessCategory  	= request_var('messcat',0);
	$MessPageMode  	= request_var('mode', '');
	$DeleteWhat    	= request_var('deletemessages','');
	$Send 		  	= request_var('send',0);
	$OwnerID       	= request_var('id',0);
	$Subject 		= request_var('subject','',true);
	
	$MessageType   	= array ( 0, 1, 2, 3, 4, 5, 15, 50, 99, 100, 999);
	$TitleColor    	= array ( 0 => '#FFFF00', 1 => '#FF6699', 2 => '#FF3300', 3 => '#FF9900', 4 => '#773399', 5 => '#009933', 15 => '#030070', 50 => '#666600', 99 => '#007070', 100 => '#ABABAB', 999 => '#CCCCCC');

	$template		= new template();
	
	switch ($MessPageMode)
	{
		case 'write':
			$template->page_header();
			$template->page_footer();		
			$OwnerRecord = $db->fetch_array($db->query("SELECT a.galaxy, a.system, a.planet, b.username, b.id_planet FROM ".PLANETS." as a, ".USERS." as b WHERE b.id = '".$OwnerID."' AND a.id = b.id_planet;"));

			if (!$OwnerRecord)
				message($lang['mg_error'],"javascript:window.close()","3", false, false);
			
			if ($Send)
			{
				$Owner   = $OwnerID;
				$Message = makebr(request_var('text','',true));
				$Sender  = $CurrentUser['id'];
				$From    = $CurrentUser['username'] ." [".$CurrentUser['galaxy'].":".$CurrentUser['system'].":".$CurrentUser['planet']."]";
				SendSimpleMessage($Owner, $Sender, '', 1, $From, $Subject, $Message);
			}

			$template->assign_vars(array(	
				'mg_send_new'	=> $lang['mg_send_new'],
				'mg_send_to'	=> $lang['mg_send_to'],
				'mg_send'		=> $lang['mg_send'],
				'mg_message'	=> $lang['mg_message'],
				'mg_characters'	=> $lang['mg_characters'],
				'mg_subject'	=> $lang['mg_subject'],
				'subject'		=> (empty($Subject)) ? $lang['mg_no_subject'] : $Subject,
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
			switch($DeleteWhat)
			{
				case 'deleteall':
					$db->query("DELETE FROM ".MESSAGES." WHERE `message_owner` = '". $CurrentUser['id'] ."';");
				break;
				case 'deletetypeall':
					$db->query("DELETE FROM ".MESSAGES." WHERE `message_owner` = '". $CurrentUser['id'] ."' AND `message_type` = '".$MessType."';");
				case 'deletemarked':
					if(!empty($_POST['delmes']) && is_array($_POST['delmes']))
					{
						$SQLWhere = array();
						foreach($_POST['delmes'] as $id => $b)
						{
							$SQLWhere[] = "`message_id` = '".$id."'";
						}
						
						$db->query("DELETE FROM ".MESSAGES." WHERE (".implode(" OR ",$SQLWhere).") AND `message_owner` = '". $CurrentUser['id'] ."';");
					}
				break;
				case 'deleteunmarked':
					if(!empty($_POST['delmes']) && is_array($_POST['delmes']))
					{
						$SQLWhere = array();
						foreach($_POST['delmes'] as $id => $b)
						{
							$SQLWhere[] = "`message_id` != '".$id."'";
						}
						
						$db->query("DELETE FROM ".MESSAGES." WHERE (".implode(" AND ",$SQLWhere).") AND `message_owner` = '". $CurrentUser['id'] ."';");
					}
				break;
			}
			header("Location:game.php?page=messages");
		break;
		case 'show':
			if($MessCategory == 999)
			{
				$UsrMess = $db->query("SELECT * FROM ".MESSAGES." WHERE `message_sender` = '".$CurrentUser['id']."' ORDER BY `message_time` DESC;");
					
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
					$UsrMess = $db->query("SELECT * FROM ".MESSAGES." WHERE `message_owner` = '".$CurrentUser['id']."' OR (`message_owner` = '0' AND `message_type` = '50') ORDER BY `message_time` DESC;");
				else
					$UsrMess = $db->query("SELECT * FROM ".MESSAGES." WHERE `message_owner` = '".$CurrentUser['id']."' AND `message_type` = '".$MessCategory."' ORDER BY `message_time` DESC;");
				
					
				$db->query("UPDATE ".USERS." SET `new_message` = '0' WHERE `id` = '".$CurrentUser['id']."';");
					
				while ($CurMess = $db->fetch_array($UsrMess))
				{
					$MessageList[$CurMess['message_id']]	= array(
						'time'		=> date("d. M Y, H:i:s", $CurMess['message_time']),
						'from'		=> $CurMess['message_from'],
						'subject'	=> $CurMess['message_subject'],
						'type'		=> $CurMess['message_type'],
						'sender'	=> $CurMess['message_sender'],
						'text'		=> $CurMess['message_text'],
					);
				}
			}
			
			$template->assign_vars(array(	
				'MessageList'						=> $MessageList,
				'mg_message_title'					=> $lang['mg_message_title'],
				'mg_action'							=> $lang['mg_action'],
				'mg_date'							=> $lang['mg_date'],
				'mg_from'							=> $lang['mg_from'],
				'mg_to'								=> $lang['mg_to'],
				'mg_subject'						=> $lang['mg_subject'],
				'mg_show_only_header_spy_reports'	=> $lang['mg_show_only_header_spy_reports'],
				'mg_delete_marked'					=> $lang['mg_delete_marked'],
				'mg_delete_type_all'				=> $lang['mg_delete_type_all'],
				'mg_delete_unmarked'				=> $lang['mg_delete_unmarked'],
				'mg_delete_all'						=> $lang['mg_delete_all'],
				'mg_confirm_delete'					=> $lang['mg_confirm_delete'],
				'mg_game_message'					=> $lang['mg_game_message'],
				'dpath'								=> $dpath,
				'MessCategory'						=> $MessCategory,
			));
			$template->show("message_show.tpl");			
		break;
		default:
			$PlanetRess = new ResourceUpdate($CurrentUser, $CurrentPlanet);
			
			$template->set_vars($CurrentUser, $CurrentPlanet);
			$template->page_header();
			$template->page_topnav();
			$template->page_leftmenu();
			$template->page_planetmenu();
			$template->page_footer();
	
			$UsrMess 	= $db->query("SELECT `message_type` FROM ".MESSAGES." WHERE `message_owner` = '".$CurrentUser['id']."' OR `message_owner` = '0';");
			$GameOps 	= $db->query("SELECT `username`, `email` FROM ".USERS." WHERE `authlevel` != '0' ORDER BY `username` ASC;");
			$MessOut	= $db->fetch_array($db->query("SELECT COUNT(*) as count FROM ".MESSAGES." WHERE message_sender = '".$CurrentUser['id']."';"));
			
			while ($CurMess = $db->fetch_array($UsrMess))
			{
				$MessType              = $CurMess['message_type'];
				$TotalMess[$MessType] += 1;
				$TotalMess[100]       += 1;
			}

			$TotalMess[999]		= $MessOut['count'];
			
			while($Ops = $db->fetch($GameOps))
				$OpsList[]	= array(
					'username'	=> $Ops['username'],
					'email'		=> $Ops['email'],
				);
			
			foreach($TitleColor as $MessageID => $MessageColor) {
				$MessageList[$MessageID]	= array(
					'color'		=> $MessageColor,
					'total'		=> !empty($TotalMess[$MessageID]) ? $TotalMess[$MessageID] : 0,
					'lang'		=> $lang['mg_type'][$MessageID],
				);
			}
			
			$template->assign_vars(array(	
				'MessageList'		=> $MessageList,
				'OpsList'			=> $OpsList,
				'mg_overview'		=> $lang['mg_overview'],
				'mg_game_operators'	=> $lang['mg_game_operators'],
			));
			
			$template->show("message_overview.tpl");
			$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
		break;
	}
}
?>