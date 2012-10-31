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

require(ROOT_PATH.'/includes/libs/facebook/facebook.php');
class FacebookAuth extends Facebook {
	function __construct()
	{
		if($GLOBALS['CONF']['fb_on'] == 0)
			HTTP::redirectTo("index.php");
		
		parent::__construct(array(
			'appId'  => $GLOBALS['CONF']['fb_apikey'],
			'secret' => $GLOBALS['CONF']['fb_skey'],
		));	
	}
	
	function isVaild() {
		return !!$this->getAccount();
	}
	
	function getAccount()
	{
		return $this->getUser();
	}
	
	function register() 
	{
				
		$uid	= $this->getAccount();
		
		try {
			$me = $this->api('/me');
		} catch (FacebookApiException $e) {
			HTTP::redirectTo('index.php?code=4');
		}
		
		$ValidReg	= $GLOBALS['DATABASE']->getFirstCell("SELECT cle FROM ".USERS_VALID." WHERE universe = ".$UNI." AND email = '".$GLOBALS['DATABASE']->sql_escape($me['email'])."';");
		if(!empty($ValidReg))
			HTTP::redirectTo("index.php?uni=".$UNI."&page=reg&action=valid&clef=".$ValidReg);
							
		$GLOBALS['DATABASE']->query("INSERT INTO ".USERS_AUTH." SET
		id = (SELECT id FROM ".USERS." WHERE email = '".$GLOBALS['DATABASE']->sql_escape($me['email'])."' OR email_2 = '".$GLOBALS['DATABASE']->sql_escape($me['email'])."'),
		account = ".$uid.",
		mode = 'facebook';");
	}
	
	function getLoginData()
	{
		global $UNI;
	
		$uid	= $this->getAccount();
		
		return $GLOBALS['DATABASE']->getFirstRow("SELECT 
		user.id, user.username, user.dpath, user.authlevel, user.id_planet 
		FROM ".USERS_AUTH." auth 
		INNER JOIN ".USERS." user ON auth.id = user.id AND user.universe = ".$UNI."
		WHERE auth.account = ".$uid." AND mode = 'facebook';");
	}
}