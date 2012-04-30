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


class ShowLostPasswordPage extends AbstractPage
{
	public static $requireModule = 0;

	function __construct() 
	{
		parent::__construct();
	}
	
	function show() 
	{
		global $gameConfig;
		
		if($gameConfig['mailEnable'] == 0)
		{
			HTTP::redirectTo("index.php");
		}
		
		$username	= HTTP::_GP('username', '', UTF8_SUPPORT);
		$eMail		= HTTP::_GP('email', '');
		
		if(empty($username) || empty($eMail) || !PlayerUtil::isMailValid($eMail)) {
			echo json_encode(array('message' => $LNG['lost_empty'], 'error' => true));
			exit;
		}
			
		$UserID 	= $GLOBALS['DATABASE']->countquery("SELECT id FROM ".USERS." 
		WHERE universe = ".$UNI." 
		AND username = '".$GLOBALS['DATABASE']->escape($username)."'
		AND email_2 = '".$GLOBALS['DATABASE']->escape($eMail)."';");
		
		if (!isset($UserID))
		{
			$this->sendJSON(array('message' => $LNG['lost_not_exists'], 'error' => true));
		}
		else
		{
			$NewPass		= uniqid();
			$MailRAW		= $LANG->getMail('email_lost_password');
			$MailContent	= sprintf($MailRAW, $eMail, $gameConfig['gameName'], $NewPass, HTTP_ROOT);	
			$Mail			= MailSend($eMail, $username, $LNG['lost_mail_title'], $MailContent);
			
			$GLOBALS['DATABASE']->query("UPDATE ".USERS." SET password = '".cryptPassword($NewPass)."' WHERE id = ".$UserID.";");
			$this->sendJSON(array('message' => sprintf($LNG['mail_sended'],$eMail), 'error' => false));
		}
	}
}
