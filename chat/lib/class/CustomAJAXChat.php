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
 * @version 1.7.0 (2012-05-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

class CustomAJAXChat extends AJAXChat {

	function initCustomConfig() {
		global $gameConfig;
		$this->setConfig('dbConnection', 'link', $GLOBALS['DATABASE']);
		$this->setConfig('chatBotName', false, $gameConfig['chatBotName']);
		$this->setConfig('allowUserMessageDelete', false, (bool) $gameConfig['chatAllowDeleteOwnMessage']);
		$this->setConfig('allowNickChange', false, (bool) $gameConfig['chatAllowNameChange']);
		$this->setConfig('chatClosed', false, !$gameConfig['chatEnable']);
		$this->setConfig('allowPrivateChannels', false, (bool) $gameConfig['chatAllowDeleteOwnMessage']);
		$this->setConfig('allowPrivateMessages', false, (bool) $gameConfig['chatAllowPrivateMessage']);
		$this->setConfig('defaultChannelName', false, $gameConfig['chatChannelName']);
		$this->setConfig('showChannelMessages', false, (bool) $gameConfig['chatEnableLog']);
		$this->setConfig('langAvailable', false, Language::getAllowedLangs());
		$this->setConfig('langNames', false, Language::getAllowedLangs(false));
	}

	function initCustomRequestVars() {
		$this->setRequestVar('login', true);
		$this->setRequestVar('action', isset($_REQUEST['action']) ? $_REQUEST['action'] : '');
	}

	function revalidateUserID() {
		global $user;
		
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
		
		$userResult = $this->db->sqlQuery("SELECT authlevel, username, ally_id FROM ".USERS." WHERE id = ".$_SESSION['id'].";")->fetch();
		
		$userData = array();
		$userData['userID'] = $_SESSION['id'];

		$userData['userName'] = $this->trimUserName($userResult['username']);
		$userData['userAlly'] = $userResult['ally_id'];
		
		if($userResult['authlevel'] == AUTH_ADM)
			$userData['userRole'] = AJAX_CHAT_ADMIN;
		elseif($userResult['authlevel'] > AUTH_USR)
			$userData['userRole'] = AJAX_CHAT_MODERATOR;
		else
			$userData['userRole'] = AJAX_CHAT_USER;
		
		if($this->getRequestVar('action') == 'alliance') {
			$this->setConfig('defaultChannelID', false, $userData['userAlly']);
		}
			
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
				if($value == $this->getConfig('defaultChannelID') || $this->getUserRole() == AJAX_CHAT_ADMIN) {
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
			$this->_allChannels = array();
			$result = $this->db->sqlQuery("SELECT `id`, `ally_name` FROM ".ALLIANCE.";");

			$defaultChannelFound = false;

			while($row = $result->fetch()) {
				$this->_allChannels[$this->trimChannelName($row['ally_name'])] = $row['id'];
				if($this->getConfig('defaultChannelID') == $row['id'])
					$this->setConfig('defaultChannelName', false, $this->trimChannelName($row['ally_name']));
					
				if(!$defaultChannelFound && $this->getRequestVar('action') == 'alliance' && $row['id'] == $this->getConfig('defaultChannelID')) {
					$defaultChannelFound = true;
				}
			}

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
