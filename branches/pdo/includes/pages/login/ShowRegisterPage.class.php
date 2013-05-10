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

class ShowRegisterPage extends AbstractPage
{
	function __construct() 
	{
		parent::__construct();
	}
	
	function show()
	{
		global $LNG;
		$universeSelect	= array();	
		$referralData	= array('id' => 0, 'name' => '');
		$accountName	= "";
		
		$externalAuth	= HTTP::_GP('externalAuth', array());
		$referralID 	= HTTP::_GP('referralID', 0);

		foreach(Universe::availableUniverses() as $uniId)
		{
			$config = Config::get($uniId);
			$universeSelect[$uniId]	= $config->uni_name.($config->game_disable == 0 || $config->reg_closed == 1 ? $LNG['uni_closed'] : '');
		}
		
		if(!isset($externalAuth['account'], $externalAuth['method']))
		{
			$externalAuth['account']	= 0;
			$externalAuth['method']		= '';
		}
		else
		{
			$externalAuth['method']		= strtolower(str_replace(array('_', '\\', '/', '.', "\0"), '', $externalAuth['method']));
		}
		
		if(!empty($externalAuth['account']) && file_exists('includes/extauth/'.$externalAuth['method'].'.class.php'))
		{
			$path	= 'includes/extauth/'.$externalAuth['method'].'.class.php';
			require($path);
			$methodClass	= ucwords($externalAuth['method']).'Auth';
			/** @var $authObj externalAuth */
			$authObj		= new $methodClass;
			
			if(!$authObj->isActiveMode())
			{
				$this->redirectTo('index.php?code=5');
			}
			
			if(!$authObj->isValid())
			{
				$this->redirectTo('index.php?code=4');
			}
			
			$accountData	= $authObj->getAccountData();
			$accountName	= $accountData['name'];
		}

		$config			= Config::get();
		if($config->ref_active == 1 && !empty($referralID))
		{
			$db = Database::get();

			$sql = "SELECT username FROM %%USERS%% WHERE id = :referralID AND universe = :universe;";
			$referralAccountName = $db->selectSingle($sql, array(
				':referralID'	=> $referralID,
				':universe'		=> Universe::current()
			), 'username');

			if(!empty($referralAccountName))
			{
				$referralData	= array('id' => $referralID, 'name' => $referralAccountName);
			}
		}
		
		$this->assign(array(
			'referralData'		=> $referralData,
			'accountName'		=> $accountName,
			'externalAuth'		=> $externalAuth,
			'universeSelect'	=> $universeSelect,
			'registerRulesDesc'	=> sprintf($LNG['registerRulesDesc'], '<a href="index.php?page=rules">'.$LNG['menu_rules'].'</a>')
		));
		
		$this->display('page.register.default.tpl');
	}
	
	function send() 
	{
		global $LNG;
		$config		= Config::get();

		if($config->game_disable == 0 || $config->reg_closed == 1)
		{
			$this->printMessage($LNG['registerErrorUniClosed'], array(array(
				'label'	=> $LNG['registerBack'],
				'url'	=> 'javascript:window.history.back()',
			)));
		}

		$userName 		= HTTP::_GP('username', '', UTF8_SUPPORT);
		$password 		= HTTP::_GP('password', '', true);
		$password2 		= HTTP::_GP('passwordReplay', '', true);
		$mailAddress 	= HTTP::_GP('email', '');
		$mailAddress2	= HTTP::_GP('emailReplay', '');
		$rulesChecked	= HTTP::_GP('rules', 0);
		$language 		= HTTP::_GP('lang', '');
		
		$referralID 	= HTTP::_GP('referralID', 0);

		$externalAuth	= HTTP::_GP('externalAuth', array());
		if(!isset($externalAuth['account'], $externalAuth['method']))
		{
			$externalAuthUID	= 0;
			$externalAuthMethod	= '';
		}
		else
		{
			$externalAuthUID	= $externalAuth['account'];
			$externalAuthMethod	= strtolower(str_replace(array('_', '\\', '/', '.', "\0"), '', $externalAuth['method']));
		}
		
		$errors 	= array();
		
		if(empty($userName)) {
			$errors[]	= $LNG['registerErrorUsernameEmpty'];
		}
		
		if(!PlayerUtil::isNameValid($userName)) {
			$errors[]	= $LNG['registerErrorUsernameChar'];
		}
		
		if(strlen($password) < 6) {
			$errors[]	= $LNG['registerErrorPasswordLength'];
		}
			
		if($password != $password2) {
			$errors[]	= $LNG['registerErrorPasswordSame'];
		}
			
		if(!PlayerUtil::isMailValid($mailAddress)) {
			$errors[]	= $LNG['registerErrorMailInvalid'];
		}
			
		if(empty($mailAddress)) {
			$errors[]	= $LNG['registerErrorMailEmpty'];
		}
		
		if($mailAddress != $mailAddress2) {
			$errors[]	= $LNG['registerErrorMailSame'];
		}
		
		if($rulesChecked != 1) {
			$errors[]	= $LNG['registerErrorRules'];
		}
		
		$db = Database::get();

		$sql = "SELECT (
				SELECT COUNT(*)
				FROM %%USERS%%
				WHERE universe = :universe
				AND username = :userName
			) + (
				SELECT COUNT(*)
				FROM %%USERS_VALID%%
				WHERE universe = :universe
				AND username = :userName
			) as count;";

		$countUsername = $db->selectSingle($sql, array(
			':universe'	=> Universe::current(),
			':userName'	=> $userName,
		), 'count');

		$sql = "SELECT (
			SELECT COUNT(*)
			FROM %%USERS%%
			WHERE universe = :universe
			AND (
				email = :mailAddress
				OR email_2 = :mailAddress
			)
		) + (
			SELECT COUNT(*)
			FROM %%USERS_VALID%%
			WHERE universe = :universe
			AND email = :mailAddress
		) as count;";

		$countMail = $db->selectSingle($sql, array(
			':universe'		=> Universe::current(),
			':mailAddress'	=> $mailAddress,
		), 'count');
		
		if($countUsername!= 0) {
			$errors[]	= $LNG['registerErrorUsernameExist'];
		}
			
		if($countMail != 0) {
			$errors[]	= $LNG['registerErrorMailExist'];
		}
		
		if ($config->capaktiv === '1') {
			require_once('includes/libs/reCAPTCHA/recaptchalib.php');
			
			$recaptcha_challenge_field	= HTTP::_GP('recaptcha_challenge_field', '');
			$recaptcha_response_field	= HTTP::_GP('recaptcha_response_field', '');
			
			$resp = recaptcha_check_answer($config->capprivate, $_SERVER['REMOTE_ADDR'], $recaptcha_challenge_field, $recaptcha_response_field);
		
			if (!$resp->is_valid)
			{
				$errors[]	= $LNG['registerErrorCaptcha'];
			}
		}
						
		if (!empty($errors)) {
			$this->printMessage(implode("<br>\r\n", $errors), array(array(
				'label'	=> $LNG['registerBack'],
				'url'	=> 'javascript:window.history.back()',
			)));
		}

		$path	= 'includes/extauth/'.$externalAuthMethod.'.class.php';

		if(!empty($externalAuth['account']) && file_exists($path))
		{
			require($path);

			$methodClass		= ucwords($externalAuthMethod).'Auth';
			/** @var $authObj externalAuth */
			$authObj			= new $methodClass;
			$externalAuthUID	= 0;
			if($authObj->isActiveMode() && $authObj->isValid()) {
				$externalAuthUID	= $authObj->getAccount();
			}
		}
		
		if($config->ref_active == 1 && !empty($referralID))
		{
			$sql = "SELECT COUNT(*) FROM %%USERS%% WHERE id = :referralID AND universe = :universe;";
			$Count = $db->selectSingle($sql, array(
				':referralID' 	=> $referralID,
				':universe'		=> Universe::current()
			), 'count');

			if($Count == 0)
			{
				$referralID	= 0;
			}
		}
		else
		{
			$referralID	= 0;
		}
		
		$validationKey	= md5(uniqid('2m'));

		$sql = "INSERT INTO %%USERS_VALID%% SET
				`userName` = :userName,
				`validationKey` = :validationKey,
				`password` = :password,
				`email` = :mailAddress,
				`date` = :timestamp,
				`ip` = :remoteAddr,
				`language` = :language,
				`universe` = :universe,
				`referralID` = :referralID,
				`externalAuthUID` = :externalAuthUID,
				`externalAuthMethod` = :externalAuthMethod;";


		$db->insert($sql, array(
			':userName'				=> $userName,
			':validationKey'		=> $validationKey,
			':password'				=> $password,
			':mailAddress'			=> $mailAddress,
			':timestamp'			=> TIMESTAMP,
			':remoteAddr'			=> $_SERVER['REMOTE_ADDR'],
			':language'				=> $language,
			':universe'				=> Universe::current(),
			':referralID'			=> $referralID,
			':externalAuthUID'		=> $externalAuthUID,
			':externalAuthMethod'	=> $externalAuthMethod
		));

		$validationID	= $db->lastInsertId();
		$verifyURL	= 'index.php?page=vertify&i='.$validationID.'&k='.$validationKey;
		
		if($config->user_valid == 0 || !empty($externalAuthUID))
		{
			$this->redirectTo($verifyURL);
		}
		else
		{
			require 'includes/classes/Mail.class.php';
			$MailRAW		= $LNG->getTemplate('email_vaild_reg');
			$MailContent	= str_replace(array(
				'{USERNAME}',
				'{PASSWORD}',
				'{GAMENAME}',
				'{VERTIFYURL}',
				'{GAMEMAIL}',
			), array(
				$userName,
				$password,
				$config->game_name.' - '.$config->uni_name,
				HTTP_PATH.$verifyURL,
				$config->smtp_sendmail,
			), $MailRAW);

			$subject	= sprintf($LNG['registerMailVertifyTitle'], $config->game_name);
			Mail::send($mailAddress, $userName, $subject, $MailContent);
			
			$this->printMessage($LNG['registerSendComplete']);
		}
	}
}