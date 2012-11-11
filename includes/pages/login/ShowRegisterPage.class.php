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
		$universeSelect	= array();	
		$referralData	= array('id' => 0, 'name' => '');
		$accountName	= "";
		
		$externalAuth	= HTTP::_GP('externalAuth', array());
		$referralID 	= HTTP::_GP('referralID', 0);
		
		$uniAllConfig	= Config::getAll('universe');
		
		foreach($uniAllConfig as $uniID => $uniConfig)
		{
			$universeSelect[$uniID]	= $uniConfig['uni_name'].($uniConfig['game_disable'] == 0 || $uniConfig['reg_closed'] == 1 ? t('uni_closed') : '');
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
		
		if(!empty($externalAuth['account']) && file_exists(ROOT_PATH.'includes/extauth/'.$externalAuth['method'].'.class.php'))
		{
			require(ROOT_PATH.'includes/extauth/'.$externalAuth['method'].'.class.php');
			$methodClass	= ucwords($externalAuth['method']).'Auth';
			$authObj		= new $methodClass;
			
			if(!$authObj->isActiveMode()) {
				$this->redirectTo('index.php?code=5');
			}
			
			if(!$authObj->isVaild()) {
				$this->redirectTo('index.php?code=4');
			}
			
			$accountData	= $authObj->getAccountData();
			$accountName	= $accountData['name'];
		}
		
		if(Config::get('ref_active') == 1 && !empty($referralID))
		{
			$referralAccountName	= $GLOBALS['DATABASE']->getFirstCell("SELECT username FROM ".USERS." WHERE id = ".$referralID." AND universe = ".$GLOBALS['UNI'].";");
			
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
			'registerRulesDesc'	=> t('registerRulesDesc', '<a href="index.php?page=rules">'.t('menu_rules').'</a>')
		));
		
		$this->render('page.register.default.tpl');
	}
	
	function send() 
	{			
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
		
		if(Config::get('game_disable') == 0 || Config::get('reg_closed') == 1) {
			$this->printMessage(t('registerErrorUniClosed'), NULL, array(array(
				'label'	=> t('registerBack'),
				'url'	=> 'javascript:window.history.back()',
			)));
		}
		
		if(empty($userName)) {
			$errors[]	= t('registerErrorUsernameEmpty');
		}
		
		if(!PlayerUtil::isNameValid($userName)) {
			$errors[]	= t('registerErrorUsernameChar');
		}
		
		if(strlen($password) < 6) {
			$errors[]	= t('registerErrorPasswordLength');
		}
			
		if($password != $password2) {
			$errors[]	= t('registerErrorPasswordSame');
		}
			
		if(!PlayerUtil::isMailValid($mailAddress)) {
			$errors[]	= t('registerErrorMailInvalid');
		}
			
		if(empty($mailAddress)) {
			$errors[]	= t('registerErrorMailEmpty');
		}
		
		if($mailAddress != $mailAddress2) {
			$errors[]	= t('registerErrorMailSame');
		}
		
		if($rulesChecked != 1) {
			$errors[]	= t('registerErrorRules');
		}
		
		$countUsername	= $GLOBALS['DATABASE']->getFirstCell("SELECT (
			SELECT COUNT(*) 
			FROM ".USERS." 
			WHERE universe = ".$GLOBALS['UNI']."
			AND username = '".$GLOBALS['DATABASE']->escape($userName)."'
		) + (
			SELECT COUNT(*)
			FROM ".USERS_VALID."
			WHERE universe = ".$GLOBALS['UNI']."
			AND username = '".$GLOBALS['DATABASE']->escape($userName)."'
		);");
		
		$countMail		= $GLOBALS['DATABASE']->getFirstCell("SELECT (
			SELECT COUNT(*)
			FROM ".USERS."
			WHERE universe = ".$GLOBALS['UNI']."
			AND (
				email = '".$GLOBALS['DATABASE']->escape($mailAddress)."'
				OR email_2 = '".$GLOBALS['DATABASE']->escape($mailAddress)."'
			)
		) + (
			SELECT COUNT(*)
			FROM ".USERS_VALID."
			WHERE universe = ".$GLOBALS['UNI']."
			AND email = '".$GLOBALS['DATABASE']->escape($mailAddress)."'
		);");
		
		if($countUsername!= 0) {
			$errors[]	= t('registerErrorUsernameExist');
		}
			
		if($countMail != 0) {
			$errors[]	= t('registerErrorMailExist');
		}
		
		if (Config::get('capaktiv') === '1') {
			require_once('includes/libs/reCAPTCHA/recaptchalib.php');
			
			$resp = recaptcha_check_answer(Config::get('capprivate'), $_SERVER['REMOTE_ADDR'], $_REQUEST['recaptcha_challenge_field'], $_REQUEST['recaptcha_response_field']);
		
			if (!$resp->is_valid)
			{
				$errors[]	= t('registerErrorCaptcha');
			}
		}
						
		if (!empty($errors)) {
			$this->printMessage(implode("<br>\r\n", $errors), NULL, array(array(
				'label'	=> t('registerBack'),
				'url'	=> 'javascript:window.history.back()',
			)));
		}
		
		if(!empty($externalAuth['account']) && file_exists(ROOT_PATH.'includes/extauth/'.$externalAuthMethod.'.class.php'))
		{
			require(ROOT_PATH.'includes/extauth/'.$externalAuthMethod.'.class.php');
			$methodClass	= ucwords($externalAuthMethod).'Auth';
			$authObj		= new $methodClass;
			
			if(!$authObj->isActiveMode()) {
				$externalAuthUID	= 0;
			}
			
			if(!$authObj->isVaild()) {
				$externalAuthUID	= 0;
			}
			
			$externalAuthUID	= $authObj->getAccount();
		}
		
		if(Config::get('ref_active') == 1 && !empty($referralID))
		{
			$Count	= $GLOBALS['DATABASE']->getFirstCell("SELECT COUNT(*) FROM ".USERS." WHERE id = ".$referralID." AND universe = ".$GLOBALS['UNI'].";");
			
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
	
		$SQL = "INSERT INTO ".USERS_VALID." SET
				`userName` = '".$GLOBALS['DATABASE']->escape($userName)."',
				`validationKey` = '".$validationKey."',
				`password` = '".PlayerUtil::cryptPassword($password)."',
				`email` = '".$GLOBALS['DATABASE']->escape($mailAddress)."',
				`date` = '".TIMESTAMP."',
				`ip` = '".$_SERVER['REMOTE_ADDR']."',
				`language` = '".$GLOBALS['DATABASE']->escape($language)."',
				`universe` = ".$GLOBALS['UNI'].",
				`referralID` = ".$referralID.",
				`externalAuthUID` = '".$GLOBALS['DATABASE']->escape($externalAuthUID)."',
				`externalAuthMethod` = '".$externalAuthMethod."';";
				
		$GLOBALS['DATABASE']->query($SQL);
		
		$validationID	= $GLOBALS['DATABASE']->GetInsertID();
		$vertifyURL	= 'index.php?page=vertify&i='.$validationID.'&k='.$validationKey;
		
		if(Config::get('user_valid') == 0 || !empty($externalAuthUID))
		{
			$this->redirectTo($vertifyURL);
		}
		else
		{
			require(ROOT_PATH.'includes/classes/Mail.class.php');
			$MailSubject 	= t('registerMailVertifyTitle');
			$MailRAW		= $GLOBALS['LANG']->getMail('email_vaild_reg');
			$MailContent	= str_replace(array(
				'{USERNAME}',
				'{PASSWORD}',
				'{GAMENAME}',
				'{VERTIFYURL}',
				'{GAMEMAIL}',
			), array(
				$userName,
				$password,
				Config::get('game_name').' - '.Config::get('uni_name'),
				HTTP_PATH.$vertifyURL,
				Config::get('smtp_sendmail'),
			), $MailRAW);
			
			try {
				Mail::send($mailAddress, $userName, t('registerMailVertifyTitle', Config::get('game_name')), $MailContent);
			}
			catch (Exception $e)
			{
				$this->printMessage(t('registerMailError', $e->getMessage()));
			}
			
			$this->printMessage(t('registerSendComplete'));
		}
	}
}