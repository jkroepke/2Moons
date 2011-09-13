<?php

/**
 *  2Moons
 *  Copyright (C) 2011  Slaver
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package 2Moons
 * @author Slaver <slaver7@gmail.com>
 * @copyright 2009 Lucky <lucky@xgproyect.net> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.4 (2011-07-10)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */


class ShowMessagesPage
{	
	function __construct() {
		// 2Moons 1.5TO1.4 PageClass Wrapper
		$ACTION	= request_var('mode', 'display');
		if(method_exists($this, $ACTION))
			$this->$ACTION();
		else
			$this->display();
	}
	
	function getMessages()
	{
		global $db, $THEME, $LNG;
		$MessCategory  	= request_var('messcat', 100);
		$MessageList	= array();
		if($MessCategory == 999) 
		{
			$UsrMess = $db->query("SELECT `message_id`, `message_time`, CONCAT(`username`, ' [',`galaxy`, ':', `system`, ':', `planet`,']') as `message_from`, `message_subject`, `message_sender`, `message_type`, `message_unread`, `message_text` FROM ".MESSAGES." INNER JOIN ".USERS." ON `id` = `message_owner` WHERE `message_sender` = '".$_SESSION['id']."' AND `message_type` != 50 ORDER BY `message_time` DESC;");
		} else {
			$UsrMess = $db->query("SELECT `message_id`, `message_time`, `message_from`, `message_subject`, `message_sender`, `message_type`, `message_unread`, `message_text` FROM ".MESSAGES." WHERE `message_owner` = '".$_SESSION['id']."'".($MessCategory != 100 ? " AND `message_type` = ".$MessCategory:"")." ORDER BY `message_time` DESC;");

			if($MessCategory == 100)
				$db->query("UPDATE ".MESSAGES." SET `message_unread` = '0' WHERE `message_owner` = '".$_SESSION['id']."';");			
			else
				$db->query("UPDATE ".MESSAGES." SET `message_unread` = '0' WHERE `message_owner` = '".$_SESSION['id']."' AND `message_type` = '".$MessCategory."';");
		}

		while ($CurMess = $db->fetch_array($UsrMess))
		{
			$MessageList[]	= array(
				'id'		=> $CurMess['message_id'],
				'time'		=> tz_date($CurMess['message_time']),
				'from'		=> $CurMess['message_from'],
				'subject'	=> $CurMess['message_subject'],
				'sender'	=> $CurMess['message_sender'],
				'type'		=> $CurMess['message_type'],
				'unread'	=> $CurMess['message_unread'],
				'text'		=> $CurMess['message_text'],
			);
		}
		
		$db->free_result($UsrMess);		

		$template		= new template();
		$template->isDialog(true);	
		$template->assign_vars(array(	
			'MessID'		=> $MessCategory,
			'MessageList'	=> $MessageList,
            'dpath'			=> $THEME->getTheme(),
		));
		$template->show("message_list.tpl");
	}
	
	function DelMessages()
	{
		global $db;
		$DeleteWhat 	= request_var('deletemessages','');
		$MessCategory  	= request_var('messcat', 100);
		
		if($DeleteWhat == 'deleteunmarked' && (empty($_REQUEST['delmes']) || !is_array($_REQUEST['delmes'])))
			$DeleteWhat	= 'deletetypeall';
		
		if($DeleteWhat == 'deletetypeall' && $MessCategory == 100)
			$DeleteWhat	= 'deleteall';
		
		
		switch($DeleteWhat)
		{
			case 'deleteall':
				$db->multi_query("DELETE FROM ".MESSAGES." WHERE `message_owner` = '".$_SESSION['id']."';UPDATE ".USERS." SET `new_message_0` = 0, `new_message_1` = 0, `new_message_2` = 0, `new_message_3` = 0, `new_message_4` = 0, `new_message_5` = 0, `new_message_15` = 0, `new_message_50` = 0, `new_message_99` = 0 WHERE `id` = '".$_SESSION['id']."';");
			break;
			case 'deletetypeall':
				$db->multi_query("DELETE FROM ".MESSAGES." WHERE `message_owner` = '".$_SESSION['id']."' AND `message_type` = '".$MessCategory."';");
			case 'deletemarked':
				$SQLWhere = array();
				if(empty($_REQUEST['delmes']) || !is_array($_REQUEST['delmes']))
					redirectTo('game.php?page=messages');
					
				foreach($_REQUEST['delmes'] as $MessID => $b)
				{
					$SQLWhere[] = "`message_id` = '".(int) $MessID."'";
				}
				
				$db->query("DELETE FROM ".MESSAGES." WHERE (".implode(" OR ",$SQLWhere).") AND `message_owner` = '".$_SESSION['id']."'".(($MessCategory != 100)? " AND `message_type` = '".$MessCategory."' ":"").";");
			break;
			case 'deleteunmarked':
				if(!empty($_REQUEST['delmes']) && is_array($_REQUEST['delmes']))
				{
					$SQLWhere = array();
					foreach($_REQUEST['delmes'] as $MessID => $b)
					{
						$SQLWhere[] = "`message_id` != '".(int) $MessID."'";
					}
					
					$db->query("DELETE FROM ".MESSAGES." WHERE (".implode(" AND ",$SQLWhere).") AND `message_owner` = '".$_SESSION['id']."'".(($MessCategory != 100)? " AND `message_type` = '".$MessCategory."' ":"").";");
				}
			break;
		}
		redirectTo('game.php?page=messages');
	}
	
	function send() 
	{
		global $USER, $LNG;
		$OwnerID	= request_var('id', 0);
		$Subject 	= request_var('subject', $LNG['mg_no_subject'], true);
		$Message 	= makebr(request_var('text', '', true));
		$From    	= $USER['username'].' ['.$USER['galaxy'].':'.$USER['system'].':'.$USER['planet'].']';

		if (empty($OwnerID) || empty($Message) || $_SESSION['messtoken'] != md5($USER['id'].'|'.$OwnerID))
			exit($LNG['mg_error']);
		
		unset($_SESSION['messtoken']);
		
		if (empty($Subject))
			$Subject	= $LNG['mg_no_subject'];
			
		SendSimpleMessage($OwnerID, $USER['id'], TIMESTAMP, 1, $From, $Subject, $Message);
		exit($LNG['mg_message_send']);
	}
	
	function write() 
	{
		global $db, $LNG, $USER;
		$OwnerID       	= request_var('id', 0);
		$Subject 		= request_var('subject', $LNG['mg_no_subject'], true);
		$OwnerRecord 	= $db->uniquequery("SELECT a.galaxy, a.system, a.planet, b.username, b.id_planet FROM ".PLANETS." as a, ".USERS." as b WHERE b.id = '".$OwnerID."' AND a.id = b.id_planet;");

		if (!$OwnerRecord)
			exit($LNG['mg_error']);
			
		$_SESSION['messtoken'] = md5($USER['id'].'|'.$OwnerID);
		
		$template		= new template();
		$template->isPopup(true);	
		$template->assign_vars(array(	
			'subject'		=> $Subject,
			'id'			=> $OwnerID,
			'OwnerRecord'	=> $OwnerRecord,
		));
		
		$template->show("message_send_form.tpl");	
	}
	
	function display()
	{
		global $USER, $PLANET, $CONF, $db, $UNI;
		
		$MessageType   	= array ( 0, 1, 2, 3, 4, 5, 15, 50, 99, 100, 999);
		$TitleColor    	= array ( 0 => '#FFFF00', 1 => '#FF6699', 2 => '#FF3300', 3 => '#FF9900', 4 => '#773399', 5 => '#009933', 15 => '#6495ed', 50 => '#666600', 99 => '#007070', 100 => '#ABABAB', 999 => '#CCCCCC');

	
		$PlanetRess = new ResourceUpdate();
		$PlanetRess->CalcResource();
		$PlanetRess->SavePlanetToDB();
		
		$MessOut	= $db->countquery("SELECT COUNT(*) FROM ".MESSAGES." WHERE message_sender = '".$USER['id']."' AND `message_type` != 50;");
		$OpsList	= array();
		$TotalMess	= array(0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 15 => 0, 50 => 0, 99 => 0, 100 => 0, 999 => 0);
		$UnRead		= array(0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 15 => 0, 50 => 0, 99 => 0, 100 => 0, 999 => 0);
		$GameOps 	= $db->query("SELECT `username`, `email` FROM ".USERS." WHERE `universe` = '".$UNI."' AND `authlevel` != '".AUTH_USR."' ORDER BY `username` ASC;");		
		while($Ops = $db->fetch_array($GameOps))
		{	
			$OpsList[]	= array(
				'username'	=> $Ops['username'],
				'email'		=> $Ops['email'],
			);
		}
		$db->free_result($GameOps);

		$UsrMess 	= $db->query("SELECT `message_type`, SUM(`message_unread` - 1) as message_unread, COUNT(*) as count FROM ".MESSAGES." WHERE `message_owner` = '".$USER['id']."' GROUP BY `message_type`;");	
		while ($CurMess = $db->fetch_array($UsrMess))
		{
			$UnRead[$CurMess['message_type']]		= $CurMess['message_unread'];
			$TotalMess[$CurMess['message_type']]	= $CurMess['count'];
		}
		
		$db->free_result($UsrMess);
		
		$UnRead[100]		= is_array($UnRead) ? array_sum($UnRead) : 0;
		$TotalMess[100]		= is_array($TotalMess) ? array_sum($TotalMess) : 0;
		$TotalMess[999]		= $MessOut;
		
		foreach($TitleColor as $MessageID => $MessageColor) {
			$MessageList[$MessageID]	= array(
				'color'		=> $MessageColor,
				'unread'	=> !empty($UnRead[$MessageID]) ? $UnRead[$MessageID] : 0,
				'total'		=> !empty($TotalMess[$MessageID]) ? $TotalMess[$MessageID] : 0,
			);
		}
		
		$template		= new template();
		$template->loadscript('message.js');
		$template->assign_vars(array(	
			'MessageList'	=> $MessageList,
			'OpsList'		=> $OpsList,
		));
		
		$template->show("message_overview.tpl");
	}
}
?>