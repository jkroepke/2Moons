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

class ShowVertifyPage extends AbstractPage
{
	public static $requireModule = 0;

	function __construct() 
	{
		parent::__construct();
	}
	
	function show() 
	{
		global $LNG, $gameConfig, $uniConfig, $UNI;
		
		$clef 		= HTTP::_GP('clef', '');
		$admin 	 	= HTTP::_GP('admin', 0);
		
		$userData	= $GLOBALS['DATABASE']->getFirstRow("SELECT * FROM ".USERS_VALID." WHERE cle = '".$GLOBALS['DATABASE']->sql_escape($clef)."' AND universe = ".$UNI.";");
		$GLOBALS['DATABASE']->query("DELETE FROM ".USERS_VALID." WHERE cle = '".$GLOBALS['DATABASE']->sql_escape($clef)."' AND universe = ".$UNI.";");
		
		if(!isset($userData))
		{
			$this->printMessage($LNG['invalid_vertify']);
		}
		
		$UserName 	= $userData['username'];
		$UserPass 	= $userData['password'];
		$UserMail 	= $userData['email'];
		$UserIP 	= $userData['ip'];
		$UserPlanet	= $userData['planet'];
		$UserLang 	= $userData['lang'];
		$UserUni 	= $userData['universe'];
		$UserRID 	= $userData['ref_id'];
		
		list($userID, $planetID) = PlayerUntl::createPlayer(1, $userData['username'], $userData['password'], $userData['email']);
		
		if($gameConfig['mailEnable'] == 1) {
			$MailSubject	= sprintf($LNG['reg_mail_reg_done'], $gameConfig['gameName']);	
			$MailRAW		= $LANG->getMail('email_reg_done');
			$MailContent	= sprintf($MailRAW, $UserName, $gameConfig['gameName'].' - '.$uniConfig['uniName']);	
			MailSend($UserMail, $UserName, $MailSubject, $MailContent);
		}
		
		$from 		= $LNG['welcome_message_from'];
		$Subject 	= $LNG['welcome_message_subject'];
		$message 	= sprintf($LNG['welcome_message_content'], $gameConfig['gameName']);
		
		SendSimpleMessage($userID, 1, TIMESTAMP, 1, $from, $Subject, $message);
		
		if ($admin == 1)
		{
			$this->sendJSON(sprintf($LNG['user_active'], $UserName));
		}
		else
		{
			Session::Create($userID, $planetID);
			HTTP::redirectTo('game.php');
		}
	}
}