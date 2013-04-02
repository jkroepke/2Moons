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
		$universeSelect	= array();		
		$uniAllConfig	= Config::getAll('universe');
		
		foreach($uniAllConfig as $uniID => $uniConfig)
		{
			$universeSelect[$uniID]	= $uniConfig['uni_name'];
		}
		
		$this->assign(array(
			'universeSelect'	=> $universeSelect
		));
		
		$this->render('page.lostPassword.default.tpl');
	}
	
	function newPassword() 
	{
		$userID			= HTTP::_GP('u', 0);
		$validationKey	= HTTP::_GP('k', '');

		$db = Database::get();

		$sql = "SELECT COUNT(*) FROM %%LOSTPASSWORD%% WHERE userID = :userID AND key = :$validationKey AND time > :time AND hasChanged = 0;";
		$isValid = $db->selectSingle($sql, array(
			':userID'			=> $userID,
			':validationKey'	=> $validationKey,
			':time'				=> (TIMESTAMP - 1800)
		), 'count');

		if(empty($isValid))
		{
			$this->printMessage(t('passwordValidInValid'), NULL, array(array(
				'label'	=> t('passwordBack'),
				'url'	=> 'index.php',
			)));
		}
		
		$newPassword	= uniqid();

		$sql = "SELECT username, email_2 as mail FROM %%USERS%% WHERE id = :userID;";
		$userData = $db->selectSingle($sql, array(
			':userID'	=> $userID,
		));

		$MailRAW		= $GLOBALS['LNG']->getTemplate('email_lost_password_changed');
		$MailContent	= str_replace(array(
			'{USERNAME}',
			'{GAMENAME}',
			'{GAMEMAIL}',
			'{PASSWORD}',
		), array(
			$userData['username'],
			Config::get('game_name').' - '.Config::get('uni_name'),
			Config::get('smtp_sendmail'),
			$newPassword,
		), $MailRAW);
		
		$sql = "UPDATE %%USERS%% SET password = :newPassword WHERE id = :userID;";
		$db->update($sql, array(
			':userID'		=> $userID,
			':nwPassword'	=> $newPassword
		));

		require 'includes/classes/Mail.class.php';
		Mail::send($userData['mail'], $userData['username'], t('passwordChangedMailTitle', Config::get('game_name')), $MailContent);

		$sql = "UPDATE %%LOSTPASSWORD%% SET hasChanged = 1 WHERE userID = :userID AND key = :validationKey;";
		$db->update($sql, array(
			':userID'		=> $userID,
			':validationKey'	=> $validationKey
		));

		$this->printMessage(t('passwordChangedMailSend'), NULL, array(array(
			'label'	=> t('passwordNext'),
			'url'	=> 'index.php',
		)));
	}
	
	function send()
	{
		$username	= HTTP::_GP('username', '', UTF8_SUPPORT);
		$mail		= HTTP::_GP('mail', '', true);
		
		$errorMessages	= array();
		
		if(empty($username))
		{
			$errorMessages[]	= t('passwordUsernameEmpty');
		}
		
		if(empty($mail))
		{
			$errorMessages[]	= t('passwordErrorMailEmpty');
		}
		
		
		if (Config::get('capaktiv') === '1') {
			require_once('includes/libs/reCAPTCHA/recaptchalib.php');
			
			$resp = recaptcha_check_answer(Config::get('capprivate'), $_SERVER['REMOTE_ADDR'], $_REQUEST['recaptcha_challenge_field'], $_REQUEST['recaptcha_response_field']);
		
			if (!$resp->is_valid)
			{
				$errorMessages[]	=  t('registerErrorCaptcha');
			}
		}
		
		if(!empty($errorMessages))
		{
			$message	= implode("<br>\r\n", $errorMessages);
			$this->printMessage($message, NULL, array(array(
				'label'	=> t('passwordBack'),
				'url'	=> 'index.php?page=lostPassword',
			)));
		}
		
		$db = Database::get();

		$sql = "SELECT id FROM %%USERS%% WHERE universe = :universeAND username = :username AND email_2 = :mail;";
		$userID = $db->selectSingle($sql, array(
			':universe'	=> $GLOBALS['UNI'],
			':username'	=> $username,
			':mail'		=> $mail
		), 'id');

		if(empty($userID))
		{
			$this->printMessage(t('passwordErrorUnknown'), NULL, array(array(
				'label'	=> t('passwordBack'),
				'url'	=> 'index.php?page=lostPassword',
			)));
		}

		$sql = "SELECT COUNT(*) FROM %%LOSTPASSWORD%% WHERE userID = :userID AND time > :time AND hasChanged = 0;";
		$hasChanged = $db->selectSingle($sql, array(
			':userID'	=> $userID,
			':time'		=> (TIMESTAMP - 86400)
		), 'count');

		if(!empty($hasChanged))
		{
			$this->printMessage(t('passwordErrorOnePerDay'), NULL, array(array(
				'label'	=> t('passwordBack'),
				'url'	=> 'index.php?page=lostPassword',
			)));
		}
		
		$validationKey	= md5(uniqid());
						
		$MailRAW		= $GLOBALS['LNG']->getTemplate('email_lost_password_validation');
		
		$MailContent	= str_replace(array(
			'{USERNAME}',
			'{GAMENAME}',
			'{VALIDURL}',
		), array(
			$username,
			Config::get('game_name').' - '.Config::get('uni_name'),
			HTTP_PATH.'index.php?page=lostPassword&mode=newPassword&u='.$userID.'&k='.$validationKey,
		), $MailRAW);
		
		require 'includes/classes/Mail.class.php';
		
		Mail::send($mail, $username, t('passwordValidMailTitle', Config::get('game_name')), $MailContent);
		
		$sql = "INSERT INTO %%LOSTPASSWORD%% SET userID = :userID, key = :validationKey, time = :timestamp, fromIP = :remoteAddr;";
		$db->insert($sql, array(
			':userID'		=> $userID,
			':timestamp'	=> TIMESTAMP,
			':validationKey'=> $validationKey,
			':remoteAddr'	=> $_SERVER['REMOTE_ADDR']
		));

		$this->printMessage(t('passwordValidMailSend'), NULL, array(array(
			'label'	=> t('passwordNext'),
			'url'	=> 'index.php',
		)));
	}
}