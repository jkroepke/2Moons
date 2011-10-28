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
 * @version 1.5 (2011-07-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

class CustomAJAXChat extends AJAXChat {

	function initCustomConfig() {
		global $db, $CONF;
		$this->setConfig('dbConnection', 'link', $db);
		$this->setConfig('socketServerEnabled', false, (bool)$CONF['chat_socket_active']);
		$this->setConfig('socketServerHost', false, empty($CONF['chat_socket_host']) ? NULL : $CONF['chat_socket_host']);
		$this->setConfig('socketServerIP', false, $CONF['chat_socket_ip']);
		$this->setConfig('socketServerPort', false, $CONF['chat_socket_port']);
		$this->setConfig('socketServerChatID', false, $CONF['chat_socket_chatid']);
		$this->setConfig('chatBotName', false, $CONF['chat_botname']);
		$this->setConfig('allowUserMessageDelete', false, (bool) $CONF['chat_allowdelmes']);
		$this->setConfig('allowNickChange', false, (bool) $CONF['chat_nickchange']);
		$this->setConfig('chatClosed', false, (bool) $CONF['chat_closed']);
		$this->setConfig('allowPrivateChannels', false, (bool) $CONF['chat_allowchan']);
		$this->setConfig('allowPrivateMessages', false, (bool) $CONF['chat_allowmes']);
		$this->setConfig('defaultChannelName', false, $CONF['chat_channelname']);
		$this->setConfig('showChannelMessages', false, (bool) $CONF['chat_logmessage']);
		$this->setConfig('langAvailable', false, Language::getAllowedLangs());
		$this->setConfig('langNames', false, Language::getAllowedLangs(false));
	}

	function initCustomRequestVars() {
		$this->setRequestVar('login', true);
		$this->setRequestVar('chat_type', isset($_REQUEST['chat_type']) ? $_REQUEST['chat_type'] : '');
		
		if($this->getRequestVar('chat_type') == 'ally' && $_SESSION['USER']['ally_request'] == 0) {
			$this->setConfig('defaultChannelID', false, $_SESSION['USER']['ally_id']);
		}
	}

	function revalidateUserID() {
		global $user;
		
		if($this->getUserID() === $_SESSION['id']) {
			return true;
		}
		return false;
	}

	function getValidLoginUserData() {
		global $auth,$user;
		
		// Return false if given user is a bot:
		if(!isset($_SESSION)) {
			return false;
		}
		
		$userData = array();
		$userData['userID'] = $_SESSION['id'];

		$userData['userName'] = $this->trimUserName($_SESSION['username']);
		
		if($_SESSION['authlevel'] == AUTH_ADM)
			$userData['userRole'] = AJAX_CHAT_ADMIN;
		elseif($_SESSION['authlevel'] > AUTH_USR)
			$userData['userRole'] = AJAX_CHAT_MODERATOR;
		else
			$userData['userRole'] = AJAX_CHAT_USER;

		return $userData;
	}

	// Store the channels the current user has access to
	// Make sure channel names don't contain any whitespace
	function getChannels() {
		if($this->_channels === null) {
			global $auth;

			$this->_channels = array();

			$allChannels = $this->getAllChannels();

			foreach($allChannels as $key=>$value) {
				// Check if we have to limit the available channels:
				if($this->getConfig('limitChannelList') && !in_array($value, $this->getConfig('limitChannelList'))) {
					continue;
				}

				// Add the valid channels to the channel list (the defaultChannelID is always valid):
				if($value == $this->getConfig('defaultChannelID') || $_SESSION['USER']['ally_id'] == $value) {
					$this->_channels[$key] = $value;
				}
			}
		}
		return $this->_channels;
	}

	// Store all existing channels
	// Make sure channel names don't contain any whitespace
	function getAllChannels() {
		if($this->_allChannels === null) {
			global $db;

			$this->_allChannels = array();
			$result = $db->query("SELECT `id`, `ally_name` FROM ".ALLIANCE.";");

			$defaultChannelFound = false;

			while ($row = $db->fetch_array($result)) {
				$this->_allChannels[$this->trimChannelName($row['ally_name'])] = $row['id'];
				if($this->getConfig('defaultChannelID') == $row['id'])
					$this->setConfig('defaultChannelName', false, $this->trimChannelName($row['ally_name']));
					
				if(!$defaultChannelFound && $this->getRequestVar('chat_type') == 'ally' && $row['id'] == $_SESSION['USER']['ally_id']) {
					$defaultChannelFound = true;
				}
			}
			$db->free_result($result);

			if(!$defaultChannelFound) {
				// Add the default channel as first array element to the channel list:
				$this->_allChannels = array_merge(
					array(
						$this->trimChannelName($this->getConfig('defaultChannelName'))=>$this->getConfig('defaultChannelID')
					),
					$this->_allChannels
				);
			}
		}
		return $this->_allChannels;
	}
}
?>