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
 * @copyright 2012 Jan <info@2moons.cc> (2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 2.0.$Revision: 2242 $ (2012-11-31)
 * @info $Id$
 * @link http://2moons.cc/
 */

class ShowVertifyPage extends AbstractPage
{
	public static $requireModule = 0;

	function __construct() 
	{
		parent::__construct();
	}

	private function _activeUser()
	{
		$validationID	= HTTP::_GP('i', 0);
		$validationKey	= HTTP::_GP('k', '');
		
		$userData	= $GLOBALS['DATABASE']->getFirstRow("SELECT * FROM ".USERS_VALID." WHERE validationID = ".$validationID." AND validationKey = '".$GLOBALS['DATABASE']->escape($validationKey)."';");

		if(!isset($userData))
		{
			$this->printMessage(t('vertifyNoUserFound'));
		}
		
		$GLOBALS['DATABASE']->query("DELETE FROM ".USERS_VALID." WHERE validationID = ".$validationID.";");
		
		list($userID, $planetID) = PlayerUtil::createPlayer($userData['universe'], $userData['userName'], $userData['password'], $userData['email'], $userData['language']);
		
		if(Config::get('mail_active', $userData['universe']) == 1) {
			require(ROOT_PATH.'includes/classes/Mail.class.php');
			$MailSubject	= t('registerMailCompleteTitle', Config::get('game_name', $userData['universe']));	
			$MailRAW		= $GLOBALS['LANG']->getMail('email_reg_done');
			$MailContent	= str_replace(array(
				'{USERNAME}',
				'{GAMENAME}',
				'{GAMEMAIL}',
			), array(
				$userData['userName'],
				Config::get('game_name').' - '.Config::get('uni_name'),
				Config::get('smtp_sendmail'),
			), $MailRAW);
			
			try {
				Mail::send($userData['email'], $userData['userName'], $MailSubject, $MailContent);
			}
			catch (Exception $e)
			{
				// This mail is wayne.
			}
		}
		
		if(!empty($userData['referralID']))
		{
			$GLOBALS['DATABASE']->query("UPDATE ".USERS." SET
			`ref_id`	= ".$userData['referralID'].",
			`ref_bonus`	= 1
			WHERE
			`id`		= ".$userID.";");
		}
		
		if(!empty($userData['externalAuthUID']))
		{
			$GLOBALS['DATABASE']->query("INSERT INTO ".USERS_AUTH." SET
			`id`		= ".$userID.",
			`account`	= '".$GLOBALS['DATABASE']->escape($userData['externalAuthUID'])."',
			`mode`		= '".$GLOBALS['DATABASE']->escape($userData['externalAuthMethod'])."';");
		}
		
		$nameSender = t('registerWelcomePMSenderName');
		$subject 	= t('registerWelcomePMSubject');
		$message 	= t('registerWelcomePMText', Config::get('game_name', $userData['universe']));
		
		SendSimpleMessage($userID, 1, TIMESTAMP, 1, $nameSender, $subject, $message);
		return array(
			'userID'	=> $userID,
			'userName'	=> $userData['userName'],
			'planetID'	=> $planetID
		);
	}
	
	function show() 
	{	
		$userData	= $this->_activeUser();
		Session::Create($userData['userID'], $userData['planetID']);
		HTTP::redirectTo('game.php');
	}
	
	function json() 
	{	
		$userData	= $this->_activeUser();
		$this->sendJSON(t('vertifyAdminMessage', $userData['userName']));
	}
}