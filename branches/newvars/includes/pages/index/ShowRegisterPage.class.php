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

class ShowRegisterPage extends AbstractPage
{
	function __construct() 
	{
		parent::__construct();
	}
	
	function send() 
	{
		global $uniConfig, $gameConfig, $LNG, $UNI;
		if($uniConfig['enableRegistration'] == 0) {
			$this->sendJSON(array('error' => true, 'message' => array(array('universe', $LNG['register_closed']))));
		}
			
		$userName 		= HTTP::_GP('username', '', UTF8_SUPPORT);
		$password 		= HTTP::_GP('password', '', UTF8_SUPPORT);
		$password2 		= HTTP::_GP('password_2', '', UTF8_SUPPORT);
		$mailAddress 	= HTTP::_GP('email', '');
		$mailAddress2	= HTTP::_GP('email_2', '');
		$rulesChecked	= HTTP::_GP('rgt', 0);
		$language 		= HTTP::_GP('lang', '');
		$refferalID		= HTTP::_GP('ref_id', 0);
		$facebookID 	= HTTP::_GP('fb_id', 0);

		$errors 	= array();
		
		if ($gameConfig['recaptchaEnable'] === '1') {
			require_once('includes/libs/reCAPTCHA/recaptchalib.php');
			
			$resp = recaptcha_check_answer($gameConfig['recaptchaPrivateKey'], $_SERVER['REMOTE_ADDR'], $_REQUEST['recaptcha_challenge_field'], $_REQUEST['recaptcha_response_field']);
		
			if (!$resp->is_valid)
			{
				$errors[]	= array('captcha', $LNG['wrong_captcha']);
			}
		}
		
		if(empty($userName)) {
			$errors[]	= array('username', $LNG['empty_user_field']);
		}
		
		if(!PlayerUntl::isNameValid($userName)) {
			$errors[]	= array('username', $LNG['user_field_specialchar']);
		}
		
		if(!isset($password{5})) {
			$errors[]	= array('password', $LNG['password_lenght_error']);
		}
			
		if($password != $password2) {
			$errors[]	= array('password_2', $LNG['different_passwords']);
		}
			
		if(!PlayerUntl::isMailValid($mailAddress)) {
			$errors[]	= array('email', $LNG['invalid_mail_adress']);
		}
			
		if($mailAddress != $mailAddress2) {
			$errors[]	= array('email_2', $LNG['different_mails']);
		}
		
		if($rulesChecked != 1) {
			$errors[]	= array('rgt', $LNG['terms_and_conditions']);
		}
		
		$countUsername	= $GLOBALS['DATABASE']->countquery("SELECT (
			SELECT COUNT(*) 
			FROM ".USERS." 
			WHERE universe = ".$UNI."
			AND username = '".$GLOBALS['DATABASE']->sql_escape($userName)."'
		) + (
			SELECT COUNT(*)
			FROM ".USERS_VALID."
			WHERE universe = ".$UNI."
			AND username = '".$GLOBALS['DATABASE']->sql_escape($userName)."'
		);");
		
		$countMail		= $GLOBALS['DATABASE']->countquery("SELECT (
			SELECT COUNT(*)
			FROM ".USERS."
			WHERE universe = ".$UNI."
			AND (
				email = '".$GLOBALS['DATABASE']->sql_escape($mailAddress)."'
				OR email_2 = '".$GLOBALS['DATABASE']->sql_escape($mailAddress)."'
			)
		) + (
			SELECT COUNT(*)
			FROM ".USERS_VALID."
			WHERE universe = ".$UNI."
			AND email = '".$GLOBALS['DATABASE']->sql_escape($mailAddress)."'
		);");
		
		if($countUsername!= 0) {
			$errors[]	= array('username', $LNG['user_already_exists']);
		}
			
		if($countMail != 0) {
			$errors[]	= array('email', $LNG['mail_already_exists']);
		}
						
		if (!empty($errors)) {
			echo json_encode(array('error' => true, 'message' => $errors));
			exit;
		}
		
		if($gameConfig['facebookEnable'] == 1 && !empty($FACEBOOK)) {
			require(ROOT_PATH.'/includes/libs/facebook/facebook.php');
			
			$facebook = new Facebook(array(
				'appId'  => $gameConfig['facebookAPIKey'],
				'secret' => $gameConfig['facebookSecureKey'],
				'cookie' => true,
			));	

			$FACEBOOK	= $facebook->getUser();
		} else {
			$FACEBOOK	= 0;
		}
		
		if($gameConfig['referralEnable'] == 1 && !empty($refferalID))
		{
			$Count	= $GLOBALS['DATABASE']->countquery("SELECT COUNT(*) FROM ".USERS." WHERE id = ".$refferalID." AND universe = ".$UNI.";");
			
			if($Count == 0)
			{
				$refferalID	= 0;
			}
		}
		else
		{
			$refferalID	= 0;
		}
		
		$clef		= uniqid('2m');
	
		$SQL = "INSERT INTO ".USERS_VALID." SET 
				username = '".$GLOBALS['DATABASE']->sql_escape($userName)."',
				email = '".$GLOBALS['DATABASE']->sql_escape($mailAddress)."',
				lang = '".$GLOBALS['DATABASE']->sql_escape($language)."',
				planet = '',
				date = '".TIMESTAMP."',
				cle = '".$clef."',
				universe = ".$UNI.",
				password = '".PlayerUntl::cryptPassword($password)."',
				ip = '".$_SERVER['REMOTE_ADDR']."',
				ref_id = ".$refferalID.";";
				
		$GLOBALS['DATABASE']->query($SQL);
		
		$vertifyURL	= HTTP_PATH.'index.php?page=vertify&clef='.$clef;
		
		if($gameConfig['userVertification'] == 0 || $CONF['mailEnable'] == 0)
		{
			$this->sendJSON(array('error' => false, 'message' => NULL, 'location' => $vertifyURL));
		}
		else
		{
			$MailSubject 	= $LNG['reg_mail_message_pass'];
			$MailRAW		= $LANG->getMail('email_vaild_reg');
			$MailContent	= sprintf($MailRAW, $userName, $password, $gameName['gameName'].' - '.$uniConfig['uniName'], $vertifyURL);
			
			$errorMail		= MailSend($mailAddress, $userName, $MailSubject, $MailContent);
			
			if($errorMail !== true)
			{
				$this->sendJSON(array('error' => true, 'message' => $errorMail));
			}
			else
			{
				$this->sendJSON(array('error' => false, 'message' => $LNG['reg_completed']));
			}
		}
	}
}