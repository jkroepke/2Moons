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
		
		$isValid	= $GLOBALS['DATABASE']->getFirstCell("SELECT COUNT(*) FROM ".LOSTPASSWORD." WHERE userID = ".$userID." AND `key` = '".$validationKey."' AND time > ".(TIMESTAMP - 1800)." AND hasChanged = 0;");
		
		if(empty($isValid))
		{
			$this->printMessage(t('passwordValidInValid'), NULL, array(array(
				'label'	=> t('passwordBack'),
				'url'	=> 'index.php',
			)));
		}
		
		$newPassword	= uniqid();

		$userData		= $GLOBALS['DATABASE']->getFirstRow("SELECT username, email_2 as mail FROM ".USERS." WHERE id = ".$userID.";");

		$MailRAW		= $GLOBALS['LANG']->getMail('email_lost_password_changed');
		$MailContent	= sprintf($MailRAW, $userData['username'], $newPassword, Config::get('game_name'));
		
		$GLOBALS['DATABASE']->query("UPDATE ".USERS." SET password = '".PlayerUtil::cryptPassword($newPassword)."' WHERE id = ".$userID.";");
		
		require ROOT_PATH.'includes/classes/Mail.class.php';		
		Mail::send($userData['mail'], $userData['username'], t('passwordChangedMailTitle', Config::get('game_name')), $MailContent);
		
		$GLOBALS['DATABASE']->query("UPDATE ".LOSTPASSWORD." SET hasChanged = 1 WHERE userID = ".$userID." AND `key` = '".$validationKey."';");
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
		
		
		$userID	= $GLOBALS['DATABASE']->getFirstCell("SELECT id FROM ".USERS." WHERE universe = ".$GLOBALS['UNI']." AND username = '".$GLOBALS['DATABASE']->escape($username)."' AND email_2 = '".$GLOBALS['DATABASE']->escape($mail)."';");
		
		if(empty($userID))
		{
			$this->printMessage(t('passwordErrorUnknown'), NULL, array(array(
				'label'	=> t('passwordBack'),
				'url'	=> 'index.php?page=lostPassword',
			)));
		}
		
		$hasChanged	= $GLOBALS['DATABASE']->getFirstCell("SELECT COUNT(*) FROM ".LOSTPASSWORD." WHERE userID = ".$userID." AND time > ".(TIMESTAMP - 86400)." AND hasChanged = 0;");
		if(!empty($hasChanged))
		{
			$this->printMessage(t('passwordErrorOnePerDay'), NULL, array(array(
				'label'	=> t('passwordBack'),
				'url'	=> 'index.php?page=lostPassword',
			)));
		}
		
		$validationKey	= md5(uniqid());
						
		$MailRAW		= $GLOBALS['LANG']->getMail('email_lost_password_validation');
		$MailContent	= sprintf($MailRAW, $username, HTTP_PATH.'index.php?page=lostPassword&mode=newPassword&u='.$userID.'&k='.$validationKey, Config::get('game_name'));
		
		require ROOT_PATH.'includes/classes/Mail.class.php';		
		Mail::send($mail, $username, t('passwordValidMailTitle', Config::get('game_name')), $MailContent);
		
		$GLOBALS['DATABASE']->query("INSERT INTO ".LOSTPASSWORD." SET userID = ".$userID.", `key` = '".$validationKey."', time = ".TIMESTAMP.", fromIP = '".$_SERVER['REMOTE_ADDR']."';");
		
		$this->printMessage(t('passwordValidMailSend'), NULL, array(array(
			'label'	=> t('passwordNext'),
			'url'	=> 'index.php',
		)));
	}
}