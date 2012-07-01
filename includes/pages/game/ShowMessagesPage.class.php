<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan
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
 * @author Jan <info@2moons.cc>
 * @copyright 2006 Perberos <ugamela@perberos.com.ar> (UGamela)
 * @copyright 2008 Chlorel (XNova)
 * @copyright 2009 Lucky (XGProyecto)
 * @copyright 2012 Jan <info@2moons.cc> (2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 2.0.$Revision$ (2012-11-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
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
		
		$site  			= HTTP::_GP('site', 1);
		
		$this->initTemplate();
		$this->setWindow('ajax');
		
		$MessageList	= array();
		$MesagesID		= array();
		
		if($MessCategory == 999)  {
			$MessageCount	= $GLOBALS['DATABASE']->countquery("SELECT COUNT(*) FROM ".MESSAGES." WHERE userID = ".$USER['id']." AND messageType != 50;");
			
			$maxSite	= max(1, ceil($MessageCount / MESSAGES_PER_PAGE));
			$site		= min($site, $maxSite);
			
			$MessageResult	= $GLOBALS['DATABASE']->query("SELECT messageID, time, username as senderName, subject, senderID, messageType, hasRead, text FROM ".MESSAGES." INNER JOIN ".USERS." ON id = userID WHERE senderID = ".$USER['id']." AND messageType != 50 ORDER BY time DESC LIMIT ".(($site - 1) * MESSAGES_PER_PAGE).", ".MESSAGES_PER_PAGE.";");
		} else {
			$MessageCount 	= $GLOBALS['DATABASE']->countquery("SELECT COUNT(*) FROM ".MESSAGES." WHERE userID = ".$USER['id'].($MessCategory != 100 ? " AND messageType = ".$MessCategory : "").";");
			
			$maxSite	= max(1, ceil($MessageCount / MESSAGES_PER_PAGE));
			$site		= min($site, $maxSite);
			
			$MessageResult	= $GLOBALS['DATABASE']->query("SELECT messageID, time, senderName, subject, senderID, messageType, hasRead, text FROM ".MESSAGES." WHERE userID = ".$USER['id'].($MessCategory != 100 ? " AND messageType = ".$MessCategory:"")." ORDER BY time DESC LIMIT ".(($site - 1) * MESSAGES_PER_PAGE).", ".MESSAGES_PER_PAGE.";");
		}
		
		while ($MessageRow = $GLOBALS['DATABASE']->fetchArray($MessageResult))
		{
			$MesagesID[]	= $MessageRow['messageID'];
			
			$MessageList[]	= array(
				'id'		=> $MessageRow['messageID'],
				'time'		=> DateUtil::formatDate($LNG['php_tdformat'], $MessageRow['time'], $USER['timezone']),
				'from'		=> $MessageRow['senderName'],
				'subject'	=> $MessageRow['subject'],
				'sender'	=> $MessageRow['senderID'],
				'type'		=> $MessageRow['messageType'],
				'unread'	=> $MessageRow['hasRead'],
				'text'		=> $MessageRow['text'],
			);
		}
		
		if(!empty($MesagesID) && $MessCategory != 999) {
			$GLOBALS['DATABASE']->query("UPDATE ".MESSAGES." SET hasRead = 1 WHERE userID = ".$USER['id']." AND messageID IN (".implode(',', $MesagesID).");");
		}
		
		$GLOBALS['DATABASE']->free_result($MessageResult);		

		$this->assign(array(
			'MessID'		=> $MessCategory,
			'MessageCount'	=> $MessageCount,
			'MessageList'	=> $MessageList,
			'site'			=> $site,
			'maxSite'		=> $maxSite,
		));
		
		$this->render('page.messages.view.tpl');
	}
	
	function delete()
	{
		global $USER;
		$DeleteWhat 	= HTTP::_GP('deletemessages','');
		$MessCategory  	= HTTP::_GP('messcat', 100);
		
		if($DeleteWhat == 'deleteunmarked' && (empty($_REQUEST['delmes']) || !is_array($_REQUEST['delmes'])))
			$DeleteWhat	= 'deletetypeall';
		
		if($DeleteWhat == 'deletetypeall' && $MessCategory == 100)
			$DeleteWhat	= 'deleteall';
		
		
		switch($DeleteWhat)
		{
			case 'deleteall':
				$GLOBALS['DATABASE']->query("DELETE FROM ".MESSAGES." WHERE userID = ".$USER['id'].";");
			break;
			case 'deletetypeall':
				$GLOBALS['DATABASE']->query("DELETE FROM ".MESSAGES." WHERE userID = ".$USER['id']." AND messageType = ".$MessCategory.";");
			case 'deletemarked':
				$SQLWhere = array();
				if(empty($_REQUEST['delmes']) || !is_array($_REQUEST['delmes']))
					$this->redirectTo('game.php?page=messages');
					
				foreach($_REQUEST['delmes'] as $MessID => $b)
				{
					$SQLWhere[] = "messageID = '".(int) $MessID."'";
				}
				
				$GLOBALS['DATABASE']->query("DELETE FROM ".MESSAGES." WHERE (".implode(" OR ",$SQLWhere).") AND userID = ".$USER['id'].(($MessCategory != 100)? " AND messageType = ".$MessCategory." ":"").";");
			break;
			case 'deleteunmarked':
				if(!empty($_REQUEST['delmes']) && is_array($_REQUEST['delmes']))
				{
					$SQLWhere = array();
					foreach($_REQUEST['delmes'] as $MessID => $b)
					{
						$SQLWhere[] = "messageID != '".(int) $MessID."'";
					}
					
					$GLOBALS['DATABASE']->query("DELETE FROM ".MESSAGES." WHERE (".implode(" AND ",$SQLWhere).") AND userID = '".$USER['id']."'".(($MessCategory != 100)? " AND messageType = '".$MessCategory."' ":"").";");
				}
			break;
		}
		$this->redirectTo('game.php?page=messages');
	}
	
	function send() 
	{
		global $USER, $LNG;
		$userID		= HTTP::_GP('userID', 0);
		$parentID	= HTTP::_GP('parentID', 0);
		$Subject 	= HTTP::_GP('subject', $LNG['mg_no_subject'], true);
		$Message 	= HTTP::_GP('text', '', true);
				
		require_once(ROOT_PATH.'includes/functions/BBCode.php');
		
		$Message	= bbcode(makebr($Message));
		
		$senderName	= $USER['username'].' ['.$USER['galaxy'].':'.$USER['system'].':'.$USER['planet'].']';

		if ($_SESSION['messtoken'] != md5($USER['id'].'|'.$userID))
		{
			$this->printMessage($LNG['mg_error_token'], NULL, array($LNG['common_continue'] => 'javascript:parent.$.fancybox.close()'), false);
		}
		
		unset($_SESSION['messtoken']);
		
		$userExists	= $GLOBALS['DATABASE']->countquery("SELECT COUNT(*) FROM ".USERS." WHERE id = ".$userID.";");
		
		if (empty($userExists))
		{
			$this->printMessage($LNG['mg_error_user'], NULL, array($LNG['common_continue'] => 'javascript:parent.$.fancybox.close()'), false);
		}
		
		if (empty($Message))
		{
			$this->printMessage($LNG['mg_error_text'], NULL, array($LNG['common_continue'] => 'javascript:history.back()'), false);
		}
		
		if (empty($Subject))
		{
			$this->printMessage($LNG['mg_error_subject'], NULL, array($LNG['common_continue'] => 'javascript:history.back()'), false);
		}
			
		PlayerUtil::sendMessage($userID, $USER['id'], $senderName, 1, $Subject, $Message, TIMESTAMP, $parentID);
		
		$this->printMessage($LNG['mg_message_send'], NULL, array($LNG['common_continue'] => 'javascript:parent.$.fancybox.close()'), false);
	}
	
	function write() 
	{
		global $LNG, $USER;
		$this->setWindow('popup');
		$this->initTemplate();
		
		$userID 	= HTTP::_GP('userID', 0);
		$parentID	= HTTP::_GP('parentID', 0);
		$Subject	= HTTP::_GP('subject', $LNG['mg_no_subject'], true);
		
		$owner		= $GLOBALS['DATABASE']->getFirstRow("SELECT a.galaxy, a.system, a.planet, b.username, b.id_planet FROM ".PLANETS." as a, ".USERS." as b WHERE b.id = '".$userID."' AND a.id = b.id_planet;");

		if (empty($owner))
		{
			$this->printMessage($LNG['mg_error'], NULL, array($LNG['common_continue'] => 'javascript:parent.$.fancybox.close()'), false);
		}
			
		$_SESSION['messtoken'] = md5($USER['id'].'|'.$userID);
		
		$this->assign(array(	
			'subject'	=> $Subject,
			'userID'	=> $userID,
			'parentID'	=> $parentID,
			'owner'		=> $owner
		));
		
		$this->render('page.messages.write.tpl');
	}
	
	function show()
	{
		global $USER, $PLANET, $CONF, $UNI;
		
		$CategoryType   = array(0, 1, 2, 3, 4, 5, 15, 50, 99, 100, 999);
		$TitleColor    	= array(0 => '#FFFF00', 1 => '#FF6699', 2 => '#FF3300', 3 => '#FF9900', 4 => '#773399', 5 => '#009933', 15 => '#6495ed', 50 => '#666600', 99 => '#007070', 100 => '#ABABAB', 999 => '#CCCCCC');
		
		$OperatorList	= array();
		$UnRead			= array(0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 15 => 0, 50 => 0, 99 => 0, 100 => 0, 999 => 0);
		$Total			= $UnRead;
		
		$OperatorResult 	= $GLOBALS['DATABASE']->query("SELECT username, email FROM ".USERS." WHERE universe = ".$UNI." AND authlevel != ".AUTH_USR." ORDER BY username ASC;");		
		while($OperatorRow = $GLOBALS['DATABASE']->fetchArray($OperatorResult))
		{	
			$OperatorList[$OperatorRow['username']]	= $OperatorRow['email'];
		}
		
		$GLOBALS['DATABASE']->free_result($OperatorResult);

		$CategoryResult 	= $GLOBALS['DATABASE']->query("SELECT messageType, COUNT(messageID) - SUM(hasRead) as unRead, COUNT(messageID) as count FROM ".MESSAGES." WHERE userID = ".$USER['id']." GROUP BY messageType;");	
		while ($CategoryRow = $GLOBALS['DATABASE']->fetchArray($CategoryResult))
		{
			$UnRead[$CategoryRow['messageType']]	= $CategoryRow['unRead'];
			$Total[$CategoryRow['messageType']]		= $CategoryRow['count'];
		}
		
		$GLOBALS['DATABASE']->free_result($CategoryResult);
		
		$MessOut		= $GLOBALS['DATABASE']->countquery("SELECT COUNT(*) FROM ".MESSAGES." WHERE userID = ".$USER['id']." AND messageType != 50;");
				
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
		
		$this->loadscript('message.js');
		$this->assign(array(	
			'CategoryList'	=> $CategoryList,
			'OperatorList'	=> $OperatorList,
		));
		
		$this->render('page.messages.default.tpl');
	}
}
