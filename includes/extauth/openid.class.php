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

require(ROOT_PATH.'/includes/libs/OpenID/openid.php');

class OpenIDAuth extends LightOpenID {
	
	function __construct()
	{
		parent::__construct(PROTOCOL.HTTP_HOST);
		if(!$this->mode) {
			if(isset($_REQUEST['openid_identifier'])) {
				$this->identity = $_REQUEST['openid_identifier'];
				
				$this->required = array('contact/email');
				$this->optional = array('namePerson', 'namePerson/friendly');
				header('Location: ' . $this->authUrl());
				exit;
			} else {
				HTTP::redirectTo('index.php?code=4');
			}
		}
	}
	
	function isVaild() {
		return $this->mode && $this->mode != 'cancel';
	}
	
	function getAccount() {
		$user	= $this->getAttributes();
		
		if(!empty($user['contact/email'])) {
			return $user['contact/email'];
		}
		
		if(!empty($user['namePerson/friendly'])) {
			return $user['namePerson/friendly'];
		}
		
		if(!empty($user['namePerson'])) {
			return $user['namePerson'];
		}		
		
		HTTP::redirectTo('index.php?code=4');
	}
	
	function register() 
	{
				
		$uid	= getAccount();
		$user	= $this->getAttributes();
		
		if(empty($user['contact/email'])) {
			$user['contact/email'] = "";
		}
		
		if(!empty($user['namePerson/friendly'])) {
			$username	= $user['namePerson/friendly'];
		} elseif(!empty($user['namePerson'])) {
			$username	= $user['namePerson'];
		}
		
		$ValidReg	= $GLOBALS['DATABASE']->getFirstCell("SELECT cle FROM ".USERS_VALID." WHERE universe = ".$UNI." AND email = '".$GLOBALS['DATABASE']->sql_escape($user['contact/email'])."';");
		if(!empty($ValidReg))
			HTTP::redirectTo("index.php?uni=".$UNI."&page=reg&action=valid&clef=".$ValidReg);
					
		$GLOBALS['DATABASE']->query("INSERT INTO ".USERS_AUTH." SET
		id = (SELECT id FROM ".USERS." WHERE email = '".$GLOBALS['DATABASE']->sql_escape($me['email'])."' OR email_2 = '".$GLOBALS['DATABASE']->sql_escape($user['contact/email'])."'),
		account = '".$uid."',
		mode = '".$GLOBALS['DATABASE']->sql_escape($_REQUEST['openid_identifier'])."';");
	}
	
	function getLoginData()
	{
		global $UNI;
		
		try {
			$user = $this->getAttributes();
		} catch (FacebookApiException $e) {
			HTTP::redirectTo('index.php?code=4');
		}
		
		return $GLOBALS['DATABASE']->getFirstRow("SELECT 
		user.id, user.username, user.dpath, user.authlevel, user.id_planet 
		FROM ".USERS_AUTH." auth 
		INNER JOIN ".USERS." user ON auth.id = user.id AND user.universe = ".$UNI."
		WHERE auth.account = '".$user['contact/email']."' AND mode = '".$GLOBALS['DATABASE']->sql_escape($_REQUEST['openid_identifier'])."';");
	}
}