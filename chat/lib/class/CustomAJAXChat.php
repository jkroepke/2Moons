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

class CustomAJAXChat extends AJAXChat {

	function initCustomConfig() {
		global $CONF;
		$this->setConfig('dbConnection', 'link', $GLOBALS['DATABASE']);
		$this->setConfig('socketServerEnabled', false, (bool)Config::get('chat_socket_active'));
		$this->setConfig('socketServerHost', false, empty(Config::get('chat_socket_host')) ? NULL : Config::get('chat_socket_host'));
		$this->setConfig('socketServerIP', false, Config::get('chat_socket_ip'));
		$this->setConfig('socketServerPort', false, Config::get('chat_socket_port'));
		$this->setConfig('socketServerChatID', false, Config::get('chat_socket_chatid'));
		$this->setConfig('chatBotName', false, Config::get('chat_botname'));
		$this->setConfig('allowUserMessageDelete', false, (bool) Config::get('chat_allowdelmes'));
		$this->setConfig('allowNickChange', false, (bool) Config::get('chat_nickchange'));
		$this->setConfig('chatClosed', false, (bool) Config::get('chat_closed'));
		$this->setConfig('allowPrivateChannels', false, (bool) Config::get('chat_allowchan'));
		$this->setConfig('allowPrivateMessages', false, (bool) Config::get('chat_allowmes'));
		$this->setConfig('defaultChannelName', false, Config::get('chat_channelname'));
		$this->setConfig('showChannelMessages', false, (bool) Config::get('chat_logmessage'));
		$this->setConfig('langAvailable', false, Language::getAllowedLangs());
		$this->setConfig('langNames', false, Language::getAllowedLangs(false));
		$this->setConfig('forceAutoLogin', false, true);
	}
	
	function initCustomSession() {
		if(!$this->getRequestVar('ajax'))
		{
			$this->getAllChannels();
			if(!is_null($this->getChannel()))
			{
				$this->switchChannel($this->getConfig('defaultChannelName'));
			}
		}
	}
	
	function initCustomRequestVars() {
		$this->setRequestVar('action', isset($_REQUEST['action']) ? $_REQUEST['action'] : '');
	}

	function revalidateUserID() {
		if($this->getUserID() === $_SESSION['id']) {
			return true;
		}
		
		return false;
	}
	
	function getValidLoginUserData() {
		global $auth, $user;
		
		// Return false if given user is a bot:
		if(!isset($_SESSION)) {
			return false;
		}
		
		$sqlData = $this->db->sqlQuery("SELECT authlevel, username, ally_id FROM ".USERS." WHERE id = ".$_SESSION['id']." AND id NOT IN (SELECT userid FROM ".ALLIANCE_REQUEST.");")->fetch();
		
		$userData = array();
		$userData['userID'] = $_SESSION['id'];

		$userData['userName'] = $this->trimUserName($sqlData['username']);
		$userData['userAlly'] = $sqlData['ally_id'];
		
		if($sqlData['authlevel'] == AUTH_ADM)
			$userData['userRole'] = AJAX_CHAT_ADMIN;
		elseif($sqlData['authlevel'] > AUTH_USR)
			$userData['userRole'] = AJAX_CHAT_MODERATOR;
		else
			$userData['userRole'] = AJAX_CHAT_USER;
		
		return $userData;
	}

	// Store all existing channels
	// Make sure channel names don't contain any whitespace
	function getAllChannels() {
		if($this->_allChannels === null) {
			$this->_allChannels = array(
				$this->trimChannelName($this->getConfig('defaultChannelName')) => $this->getConfig('defaultChannelID')
			);
			
			$userAlly = $this->db->sqlQuery("SELECT ally_id as id FROM ".USERS." WHERE id = ".$_SESSION['id'].";")->fetch();
			$result = $this->db->sqlQuery("SELECT id, ally_name FROM ".ALLIANCE." WHERE id = ".$userAlly['id'].";");

			$defaultChannelFound = false;

			while($row = $result->fetch()) {
				$row['id'] = $row['id'] + 100;
				$this->_allChannels[$this->trimChannelName('+'.$row['ally_name'])] = $row['id'];
				if(!$defaultChannelFound && $this->getRequestVar('action') == 'alliance' && ($userAlly['id'] + 100) == $row['id'])
				{
					$this->setConfig('defaultChannelName', false, $this->trimChannelName('+'.$row['ally_name']));
					$this->setConfig('defaultChannelID', false, $row['id']);
					$defaultChannelFound = true;
				}
			}
		}
		
		return $this->_allChannels;
	}
}
?>