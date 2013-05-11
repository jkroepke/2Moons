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


class ShowLostPasswordPage extends AbstractPage
{
	public static $requireModule = 0;

	function __construct() 
	{
		parent::__construct();
	}
	
	function show() 
	{
		$universeSelect	= $this->getUniverseSelector();
		
		$this->assign(array(
			'universeSelect'	=> $universeSelect
		));
		
		$this->display('page.lostPassword.default.tpl');
	}
	
	function newPassword() 
	{
		global $LNG;
		$userID			= HTTP::_GP('u', 0);
		$validationKey	= HTTP::_GP('k', '');

		$db = Database::get();

		$sql = "SELECT COUNT(*) as state FROM %%LOSTPASSWORD%% WHERE userID = :userID AND `key` = :validationKey AND `time` > :time AND hasChanged = 0;";
		$isValid = $db->selectSingle($sql, array(
			':userID'			=> $userID,
			':validationKey'	=> $validationKey,
			':time'				=> (TIMESTAMP - 1800)
		), 'state');

		if(empty($isValid))
		{
			$this->printMessage($LNG['passwordValidInValid'], array(array(
				'label'	=> $LNG['passwordBack'],
				'url'	=> 'index.php',
			)));
		}
		
		$newPassword	= uniqid();

		$sql = "SELECT username, email_2 as mail, universe FROM %%USERS%% WHERE id = :userID;";
		$userData = $db->selectSingle($sql, array(
			':userID'	=> $userID,
		));

		$config			= Config::get($userData['universe']);

		$MailRAW		= $LNG->getTemplate('email_lost_password_changed');
		$MailContent	= str_replace(array(
			'{USERNAME}',
			'{GAMENAME}',
			'{GAMEMAIL}',
			'{PASSWORD}',
		), array(
			$userData['username'],
			$config->game_name.' - '.$config->uni_name,
			$config->smtp_sendmail,
			$newPassword,
		), $MailRAW);
		
		$sql = "UPDATE %%USERS%% SET password = :newPassword WHERE id = :userID;";
		$db->update($sql, array(
			':userID'		=> $userID,
			':nwPassword'	=> $newPassword
		));

		require 'includes/classes/Mail.class.php';

		$subject	= sprintf($LNG['passwordChangedMailTitle'], $config->game_name);
		Mail::send($userData['mail'], $userData['username'], $subject, $MailContent);

		$sql = "UPDATE %%LOSTPASSWORD%% SET hasChanged = 1 WHERE userID = :userID AND `key` = :validationKey;";
		$db->update($sql, array(
			':userID'			=> $userID,
			':validationKey'	=> $validationKey
		));

		$this->printMessage($LNG['passwordChangedMailSend'], array(array(
			'label'	=> $LNG['passwordNext'],
			'url'	=> 'index.php',
		)));
	}
	
	function send()
	{
		global $LNG;
		$username	= HTTP::_GP('username', '', UTF8_SUPPORT);
		$mail		= HTTP::_GP('mail', '', true);
		
		$errorMessages	= array();
		
		if(empty($username))
		{
			$errorMessages[]	= $LNG['passwordUsernameEmpty'];
		}
		
		if(empty($mail))
		{
			$errorMessages[]	= $LNG['passwordErrorMailEmpty'];
		}

		$config	= Config::get();

		if ($config->capaktiv == 1)
		{
			require_once('includes/libs/reCAPTCHA/recaptchalib.php');
			$recaptcha_challenge_field	= HTTP::_GP('recaptcha_challenge_field', '');
			$recaptcha_response_field	= HTTP::_GP('recaptcha_response_field', '');
			
			$resp = recaptcha_check_answer($config->capprivate, $_SERVER['REMOTE_ADDR'], $recaptcha_challenge_field, $recaptcha_response_field);
		
			if (!$resp->is_valid)
			{
				$errorMessages[]	=  $LNG['registerErrorCaptcha'];
			}
		}
		
		if(!empty($errorMessages))
		{
			$message	= implode("<br>\r\n", $errorMessages);
			$this->printMessage($message, array(array(
				'label'	=> $LNG['passwordBack'],
				'url'	=> 'index.php?page=lostPassword',
			)));
		}
		
		$db = Database::get();

		$sql = "SELECT id FROM %%USERS%% WHERE universe = :universe AND username = :username AND email_2 = :mail;";
		$userID = $db->selectSingle($sql, array(
			':universe'	=> Universe::current(),
			':username'	=> $username,
			':mail'		=> $mail
		), 'id');

		if(empty($userID))
		{
			$this->printMessage($LNG['passwordErrorUnknown'], array(array(
				'label'	=> $LNG['passwordBack'],
				'url'	=> 'index.php?page=lostPassword',
			)));
		}

		$sql = "SELECT COUNT(*) as state FROM %%LOSTPASSWORD%% WHERE userID = :userID AND time > :time AND hasChanged = 0;";
		$hasChanged = $db->selectSingle($sql, array(
			':userID'	=> $userID,
			':time'		=> (TIMESTAMP - 86400)
		), 'state');

		if(!empty($hasChanged))
		{
			$this->printMessage($LNG['passwordErrorOnePerDay'], array(array(
				'label'	=> $LNG['passwordBack'],
				'url'	=> 'index.php?page=lostPassword',
			)));
		}

		$validationKey	= md5(uniqid());
						
		$MailRAW		= $LNG->getTemplate('email_lost_password_validation');
		
		$MailContent	= str_replace(array(
			'{USERNAME}',
			'{GAMENAME}',
			'{VALIDURL}',
		), array(
			$username,
			$config->game_name.' - '.$config->uni_name,
			HTTP_PATH.'index.php?page=lostPassword&mode=newPassword&u='.$userID.'&k='.$validationKey,
		), $MailRAW);
		
		require 'includes/classes/Mail.class.php';

		$subject	= sprintf($LNG['passwordValidMailTitle'], $config->game_name);

		Mail::send($mail, $username, $subject, $MailContent);

		$sql = "INSERT INTO %%LOSTPASSWORD%% SET userID = :userID, `key` = :validationKey, `time` = :timestamp, fromIP = :remoteAddr;";
		$db->insert($sql, array(
			':userID'		=> $userID,
			':timestamp'	=> TIMESTAMP,
			':validationKey'=> $validationKey,
			':remoteAddr'	=> $_SERVER['REMOTE_ADDR']
		));

		$this->printMessage($LNG['passwordValidMailSend'], array(array(
			'label'	=> $LNG['passwordNext'],
			'url'	=> 'index.php',
		)));
	}
}