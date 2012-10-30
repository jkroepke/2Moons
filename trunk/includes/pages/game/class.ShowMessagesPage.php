<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
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
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.0 (2012-12-31)
 * @info $Id$
 * @link http://2moons.cc/
 */

class ShowMessagesPage extends AbstractPage
{
	public static $requireModule = MODULE_MESSAGES;

	function __construct() 
	{
		parent::__construct();
	}
	
	function view()
	{
		global $THEME, $LNG, $USER;
		$MessCategory  	= HTTP::_GP('messcat', 100);
		
		$page  			= HTTP::_GP('site', 1);
		
		$this->initTemplate();
		$this->setWindow('ajax');
		
		$MessageList	= array();
		$MesagesID		= array();
		
		if($MessCategory == 999)  {
			$MessageCount	= $GLOBALS['DATABASE']->getFirstCell("SELECT COUNT(*) FROM ".MESSAGES." WHERE message_sender = ".$USER['id']." AND message_type != 50;");
			
			$maxPage	= max(1, ceil($MessageCount / MESSAGES_PER_PAGE));
			$page		= max(1, min($page, $maxPage));
			
			$MessageResult	= $GLOBALS['DATABASE']->query("SELECT message_id, message_time, CONCAT(username, ' [',galaxy, ':', system, ':', planet,']') as message_from, message_subject, message_sender, message_type, message_unread, message_text FROM ".MESSAGES." INNER JOIN ".USERS." ON id = message_owner WHERE message_sender = ".$USER['id']." AND message_type != 50 ORDER BY message_time DESC LIMIT ".(($page - 1) * MESSAGES_PER_PAGE).", ".MESSAGES_PER_PAGE.";");
		} else {
			$MessageCount 	= $GLOBALS['DATABASE']->getFirstCell("SELECT COUNT(*) FROM ".MESSAGES." WHERE message_owner = ".$USER['id'].($MessCategory != 100 ? " AND message_type = ".$MessCategory : "").";");
			
			$maxPage	= max(1, ceil($MessageCount / MESSAGES_PER_PAGE));
			$page		= max(1, min($page, $maxPage));
			
			$MessageResult	= $GLOBALS['DATABASE']->query("SELECT message_id, message_time, message_from, message_subject, message_sender, message_type, message_unread, message_text FROM ".MESSAGES." WHERE message_owner = ".$USER['id'].($MessCategory != 100 ? " AND message_type = ".$MessCategory:"")." ORDER BY message_time DESC LIMIT ".(($page - 1) * MESSAGES_PER_PAGE).", ".MESSAGES_PER_PAGE.";");
		}

		while ($MessageRow = $GLOBALS['DATABASE']->fetch_array($MessageResult))
		{
			$MesagesID[]	= $MessageRow['message_id'];
			
			$MessageList[]	= array(
				'id'		=> $MessageRow['message_id'],
				'time'		=> _date($LNG['php_tdformat'], $MessageRow['message_time'], $USER['timezone']),
				'from'		=> $MessageRow['message_from'],
				'subject'	=> $MessageRow['message_subject'],
				'sender'	=> $MessageRow['message_sender'],
				'type'		=> $MessageRow['message_type'],
				'unread'	=> $MessageRow['message_unread'],
				'text'		=> $MessageRow['message_text'],
			);
		}
		
		if(!empty($MesagesID) && $MessCategory != 999) {
			$GLOBALS['DATABASE']->query("UPDATE ".MESSAGES." SET message_unread = 0 WHERE message_id IN (".implode(',', $MesagesID).") AND message_owner = ".$USER['id'].";");
		}
		
		$GLOBALS['DATABASE']->free_result($MessageResult);		

		$this->tplObj->assign_vars(array(
			'MessID'		=> $MessCategory,
			'MessageCount'	=> $MessageCount,
			'MessageList'	=> $MessageList,
			'page'			=> $page,
			'maxPage'		=> $maxPage,
		));
		
		$this->display('page.messages.view.tpl');
	}
	
	
	function action()
	{
		global $USER;
		
		$MessCategory  	= HTTP::_GP('messcat', 100);
		$page		 	= HTTP::_GP('page', 1);
		$messageIDs		= HTTP::_GP('messageID', array());
		
		$redirectUrl	= 'game.php?page=messages&category='.$MessCategory.'&side='.$page;
		
		if(isset($_POST['submitTop']))
		{
			$action	= HTTP::_GP('actionTop', '');
		}
		elseif(isset($_POST['submitBottom']))
		{
			$action	= HTTP::_GP('actionBottom', '');
		}
		else
		{
			$this->redirectTo($redirectUrl);
		}
		
		if($action == 'deleteunmarked' && empty($messageIDs))
			$action	= 'deletetypeall';
		
		if($action == 'deletetypeall' && $MessCategory == 100)
			$action	= 'deleteall';
		
		if($action == 'readtypeall' && $MessCategory == 100)
			$action	= 'readall';
		
		switch($action)
		{
			case 'readall':
				$GLOBALS['DATABASE']->query("UPDATE ".MESSAGES." SET message_unread = 0 WHERE message_owner = ".$USER['id'].";");
			break;
			case 'readtypeall':
				$GLOBALS['DATABASE']->query("UPDATE ".MESSAGES." SET message_unread = 0 WHERE message_owner = ".$USER['id']." AND message_type = ".$MessCategory.";");
			break;
			case 'readmarked':
				if(empty($messageIDs))
				{
					$this->redirectTo($redirectUrl);
				}	
				
				$messageIDs	= array_filter($messageIDs, 'is_numeric');
				
				if(empty($messageIDs))
				{
					$this->redirectTo($redirectUrl);
				}
				
				$GLOBALS['DATABASE']->query("UPDATE ".MESSAGES." SET message_unread = 0 WHERE message_id IN (".implode(',', array_keys($messageIDs)).") AND message_owner = ".$USER['id'].";");
			break;
			case 'deleteall':
				$GLOBALS['DATABASE']->query("DELETE FROM ".MESSAGES." WHERE message_owner = ".$USER['id'].";");
			break;
			case 'deletetypeall':
				$GLOBALS['DATABASE']->query("DELETE FROM ".MESSAGES." WHERE message_owner = ".$USER['id']." AND message_type = ".$MessCategory.";");
			break;
			case 'deletemarked':
				if(empty($messageIDs))
				{
					$this->redirectTo($redirectUrl);
				}	
				
				$messageIDs	= array_filter($messageIDs, 'is_numeric');
				
				if(empty($messageIDs))
				{
					$this->redirectTo($redirectUrl);
				}
				
				$GLOBALS['DATABASE']->query("DELETE FROM ".MESSAGES." WHERE message_id IN (".implode(',', array_keys($messageIDs)).") AND message_owner = ".$USER['id'].";");
			break;
			case 'deleteunmarked':
				if(empty($messageIDs) || !is_array($messageIDs))
				{
					$this->redirectTo($redirectUrl);
				}	
				
				$messageIDs	= array_filter($messageIDs, 'is_numeric');
				
				if(empty($messageIDs))
				{
					$this->redirectTo($redirectUrl);
				}
				
				$GLOBALS['DATABASE']->query("DELETE FROM ".MESSAGES." WHERE message_id NOT IN (".implode(',', array_keys($messageIDs)).") AND message_owner = ".$USER['id'].";");
			break;
		}
		$this->redirectTo($redirectUrl);
	}
	
	function send() 
	{
		global $USER, $LNG;
		$OwnerID	= HTTP::_GP('id', 0);
		$Subject 	= HTTP::_GP('subject', $LNG['mg_no_subject'], true);
		$Message 	= makebr(HTTP::_GP('text', '', true));
		$From    	= $USER['username'].' ['.$USER['galaxy'].':'.$USER['system'].':'.$USER['planet'].']';

		if (empty($OwnerID) || empty($Message) || !isset($_SESSION['messtoken']) || $_SESSION['messtoken'] != md5($USER['id'].'|'.$OwnerID))
			exit($LNG['mg_error']);
		
		unset($_SESSION['messtoken']);
		
		if (empty($Subject))
			$Subject	= $LNG['mg_no_subject'];
			
		SendSimpleMessage($OwnerID, $USER['id'], TIMESTAMP, 1, $From, $Subject, $Message);
		exit($LNG['mg_message_send']);
	}
	
	function write() 
	{
		global $LNG, $USER;
		$this->setWindow('popup');
		$this->initTemplate();
		$OwnerID       	= HTTP::_GP('id', 0);
		$Subject 		= HTTP::_GP('subject', $LNG['mg_no_subject'], true);
		$OwnerRecord 	= $GLOBALS['DATABASE']->getFirstRow("SELECT a.galaxy, a.system, a.planet, b.username, b.id_planet FROM ".PLANETS." as a, ".USERS." as b WHERE b.id = '".$OwnerID."' AND a.id = b.id_planet;");

		if (!$OwnerRecord)
			exit($LNG['mg_error']);
			
		$_SESSION['messtoken'] = md5($USER['id'].'|'.$OwnerID);
		
		$this->tplObj->assign_vars(array(	
			'subject'		=> $Subject,
			'id'			=> $OwnerID,
			'OwnerRecord'	=> $OwnerRecord,
		));
		
		$this->display('page.messages.write.tpl');
	}
	
	function show()
	{
		global $USER, $PLANET, $CONF, $UNI;
		
		$category      	= HTTP::_GP('category', 0);
		$side			= HTTP::_GP('side', 1);
		
		$CategoryType   = array ( 0, 1, 2, 3, 4, 5, 15, 50, 99, 100, 999);
		$TitleColor    	= array ( 0 => '#FFFF00', 1 => '#FF6699', 2 => '#FF3300', 3 => '#FF9900', 4 => '#773399', 5 => '#009933', 15 => '#6495ed', 50 => '#666600', 99 => '#007070', 100 => '#ABABAB', 999 => '#CCCCCC');
		
		$MessOut		= $GLOBALS['DATABASE']->getFirstCell("SELECT COUNT(*) FROM ".MESSAGES." WHERE message_sender = ".$USER['id']." AND message_type != 50;");
		
		$OperatorList	= array();
		$Total			= array(0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 15 => 0, 50 => 0, 99 => 0, 100 => 0, 999 => 0);
		$UnRead			= array(0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 15 => 0, 50 => 0, 99 => 0, 100 => 0, 999 => 0);
		
		$OperatorResult 	= $GLOBALS['DATABASE']->query("SELECT username, email FROM ".USERS." WHERE universe = ".$UNI." AND authlevel != ".AUTH_USR." ORDER BY username ASC;");		
		while($OperatorRow = $GLOBALS['DATABASE']->fetch_array($OperatorResult))
		{	
			$OperatorList[$OperatorRow['username']]	= $OperatorRow['email'];
		}
		
		$GLOBALS['DATABASE']->free_result($OperatorResult);

		$CategoryResult 	= $GLOBALS['DATABASE']->query("SELECT message_type, SUM(message_unread) as message_unread, COUNT(*) as count FROM ".MESSAGES." WHERE message_owner = ".$USER['id']." GROUP BY message_type;");	
		while ($CategoryRow = $GLOBALS['DATABASE']->fetch_array($CategoryResult))
		{
			$UnRead[$CategoryRow['message_type']]	= $CategoryRow['message_unread'];
			$Total[$CategoryRow['message_type']]	= $CategoryRow['count'];
		}
		
		$GLOBALS['DATABASE']->free_result($CategoryResult);
		
		$UnRead[100]	= array_sum($UnRead);
		$Total[100]		= array_sum($Total);
		$Total[999]		= $MessOut;

        $CategoryList        = array();

		foreach($TitleColor as $CategoryID => $CategoryColor) {
			$CategoryList[$CategoryID]	= array(
				'color'		=> $CategoryColor,
				'unread'	=> $UnRead[$CategoryID],
				'total'		=> $Total[$CategoryID],
			);
		}
		
		$this->tplObj->loadscript('message.js');
		$this->tplObj->assign_vars(array(	
			'CategoryList'	=> $CategoryList,
			'OperatorList'	=> $OperatorList,
			'category'		=> $category,
			'side'			=> $side,
		));
		
		$this->display('page.messages.default.tpl');
	}
}
?>