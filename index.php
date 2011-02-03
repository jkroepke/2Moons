<?php

/**
 *  2Moons
 *  Copyright (C) 2011  Slaver
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
 * @author Slaver <slaver7@gmail.com>
 * @copyright 2009 Lucky <douglas@crockford.com> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.3 (2011-01-21)
 * @link http://code.google.com/p/2moons/
 */

if (isset($_GET['action']) && $_GET['action'] == 'keepalive')
{
	header('Content-Type: image/gif');
	die("\x47\x49\x46\x38\x39\x61\x01\x00\x01\x00\x80\x00\x00\x00\x00\x00\x00\x00\x00\x21\xF9\x04\x01\x00\x00\x00\x00\x2C\x00\x00\x00\x00\x01\x00\x01\x00\x00\x02\x02\x44\x01\x00\x3B");
}

define('INSIDE', true );
define('INSTALL', false );
define('LOGIN', true );

define('ROOT_PATH', str_replace('\\', '/',dirname(__FILE__)).'/');
	
include_once(ROOT_PATH . 'common.php');

$template	= new template();
$template->cache = true;

$page = request_var('page', '');
$mode = request_var('mode', '');

switch ($page) {
	case 'facebook':
		if($CONF['fb_on'] == 0)
			redirectTo("index.php");

		$CONF		= $db->uniquequery("SELECT `fb_apikey`, `fb_skey`, `initial_fields`, `LastSettedGalaxyPos`, `LastSettedSystemPos`, `LastSettedPlanetPos`, `smtp_host`, `smtp_port`, `smtp_user`, `smtp_pass`, `game_name`, `users_amount` FROM ".CONFIG." WHERE `uni` = ".$UNI.";");
			
		include_once(ROOT_PATH . 'includes/libs/facebook/facebook.php');
		$facebook = new Facebook(array(
		  'appId'  => $CONF['fb_apikey'],
		  'secret' => $CONF['fb_skey'],
		  'cookie' => true,
		));
		$session = $facebook->getSession();

		// Session based API call.
		if (!$session)
			redirectTo("index.php");

		$uid = $facebook->getUser();

		if (!$uid)
		redirectTo("index.php");

		$login = $db->uniquequery("SELECT `id`, `username`, `dpath`, `authlevel`, `id_planet` FROM ".USERS." WHERE `universe` = '".$UNI."' AND `fb_id` = '".$uid."';");
		if (isset($login)) {
			session_start();
			$SESSION       	= new Session();
			$SESSION->CreateSession($login['id'], $login['username'], $login['id_planet'], $UNI, $login['authlevel'], $login['dpath']);
			
			redirectTo("game.php?page=overview");
		} else {
			$me = $facebook->api('/me');
			$UserMail 	=  $me['email'];
			
			$Exist['alruser'] = $db->uniquequery("SELECT `id`, `username`, `dpath`, `authlevel`, `id_planet` FROM ".USERS." WHERE `email` = '".$UserMail."';");
			if(isset($Exist['alruser']))
			{
				$db->query("UPDATE `".USERS."` SET `fb_id` = '".$uid."' WHERE `id` = '".$Exist['alruser']['id']."';");
				session_start();
				$SESSION       	= new Session();
				$SESSION->CreateSession($Exist['alruser']['id'], $Exist['alruser']['username'], $Exist['alruser']['id_planet'], $UNI, $Exist['alruser']['authlevel'], $Exist['alruser']['dpath']);
				redirectTo("game.php?page=overview");
			}
			
			$Caracters = "aazertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN1234567890";
			$Count = strlen($Caracters);
			$Taille = 8;
			$NewPass = "";
			for($i = 0; $i < $Taille; $i ++) {
				$CaracterBoucle = rand ( 0, $Count - 1 );
				$NewPass .= substr ( $Caracters, $CaracterBoucle, 1 );
			}
			
			$UserName 		= $db->sql_escape($me['name']);
			$UserIP 		= $_SERVER["REMOTE_ADDR"];				
			$UserPass		= md5($NewPass);
			$IfNameExist	= false;
			$i				= "(1)";
			
			while(!$IfNameExist)
			{
				$Exist['userv'] = $db->uniquequery("SELECT username FROM ".USERS." WHERE username = '".$UserName."' AND `universe` = '".$UNI."';");
				$Exist['valid'] = $db->uniquequery("SELECT username FROM ".USERS_VALID." WHERE username = '".$UserName."' AND `universe` = '".$UNI."';");
				if(!isset($Exist['userv']) && !isset($Exist['valid']))
					$IfNameExist	= true;
				else
					$UserName		= $i.$UserName;
			}
			
			$SQL = "INSERT INTO ".USERS." SET ";
			$SQL .= "`username` = '" .$db->sql_escape($UserName)."', ";
			$SQL .= "`universe` = '" .$UNI."', ";
			$SQL .= "`email` = '" . $UserMail . "', ";
			$SQL .= "`email_2` = '" . $UserMail . "', ";
			$SQL .= "`ip_at_reg` = '" . $UserIP . "', ";
			$SQL .= "`id_planet` = '0', ";
			$SQL .= "`onlinetime` = '".TIMESTAMP."', ";
			$SQL .= "`register_time` = '".TIMESTAMP."', ";
			$SQL .= "`password` = '" . $UserPass . "', ";
			$SQL .= "`lang` = '".$LANG->GetUser()."', ";
			$SQL .= "`dpath` = '" . DEFAULT_SKINPATH . "', ";
			$SQL .= "`fb_id` = '" . $uid . "', ";
			$SQL .= "`uctime`= '0';";
			$db->query($SQL);
		
			if($CONF['smtp_host'] != '' && $CONF['smtp_port'] != 0 && $CONF['smtp_user'] != '' && $CONF['smtp_pass'] != '')
			{				
				$MailSubject	= sprintf($LNG['reg_mail_reg_done'], $CONF['game_name']);	
				$MailRAW		= file_get_contents("./language/".$CONF['lang']."/email/email_reg_done.txt");
				$MailContent	= sprintf($MailRAW, $UserName, $CONF['game_name']);	
				MailSend($UserMail, $UserName, $MailSubject, $MailContent);
				$MailRAW		= file_get_contents("./language/".$CONF['lang']."/email/email_lost_password.txt");
				$MailContent	= sprintf($MailRAW, $ExistMail['username'], $CONF['game_name'], $NewPass, "http://".$_SERVER['SERVER_NAME'].$_SERVER["PHP_SELF"]);			
				MailSend($UserMail, $UserName, $LNG['mail_title'], $MailContent);		
			}
			
			$NewUser = $db->GetInsertID();
			
			$LastSettedGalaxyPos = $CONF['LastSettedGalaxyPos'];
			$LastSettedSystemPos = $CONF['LastSettedSystemPos'];
			$LastSettedPlanetPos = $CONF['LastSettedPlanetPos'];
			require_once(ROOT_PATH.'includes/functions/CreateOnePlanetRecord.php');
			$PlanetID = false;
			
			while ($PlanetID === false) {
				$Planet = mt_rand(4, 12);
				if ($LastSettedPlanetPos < 3) {
					$LastSettedPlanetPos += 1;
				} else {
					if ($LastSettedSystemPos == MAX_SYSTEM_IN_GALAXY) {
						$LastSettedGalaxyPos += 1;
						$LastSettedSystemPos = 1;
						$LastSettedPlanetPos = 1;
					} else {
						$LastSettedSystemPos += 1;
						$LastSettedPlanetPos = 1;
					}
				}
				
				$PlanetID = CreateOnePlanetRecord($LastSettedGalaxyPos, $LastSettedSystemPos, $Planet, $UNI, $NewUser, $UserPlanet, true);
			}
			
			$SQL = "UPDATE " .USERS." SET ";
			$SQL .= "`id_planet` = '".$PlanetID."', ";
			$SQL .= "`galaxy` = '".$LastSettedGalaxyPos."', ";
			$SQL .= "`system` = '".$LastSettedSystemPos."', ";
			$SQL .= "`planet` = '".$Planet."' ";
			$SQL .= "WHERE ";
			$SQL .= "`id` = '".$NewUser."' ";
			$SQL .= "LIMIT 1;";
			$SQL .= "INSERT INTO ".STATPOINTS." (`id_owner`, `id_ally`, `stat_type`, `tech_rank`, `tech_old_rank`, `tech_points`, `tech_count`, `build_rank`, `build_old_rank`, `build_points`, `build_count`, `defs_rank`, `defs_old_rank`, `defs_points`, `defs_count`, `fleet_rank`, `fleet_old_rank`, `fleet_points`, `fleet_count`, `total_rank`, `total_old_rank`, `total_points`, `total_count`) VALUES (".$NewUser.", 0, 1, '".($CONF ['users_amount'] + 1)."', '".($CONF ['users_amount'] + 1)."', 0, 0, '".($CONF ['users_amount'] + 1)."', '".($CONF ['users_amount'] + 1)."', 0, 0, '".($CONF ['users_amount'] + 1)."', '".($CONF ['users_amount'] + 1)."', 0, 0, 1, 0, 0, 0, '".($CONF ['users_amount'] + 1)."', '".($CONF ['users_amount'] + 1)."', 0, 0);";				
			$db->multi_query ( $SQL );
			
			$from 		= $LNG ['welcome_message_from'];
			$Subject 	= $LNG ['welcome_message_subject'];
			$message 	= sprintf($LNG['welcome_message_content'], $CONF['game_name']);
			SendSimpleMessage($NewUser, 1, $Time, 1, $from, $Subject, $message );
							
			update_config(array('LastSettedGalaxyPos' => $LastSettedGalaxyPos, 'LastSettedSystemPos' => $LastSettedSystemPos, 'LastSettedPlanetPos' => $LastSettedPlanetPos, 'users_amount' => $CONF['users_amount'] + 1), false, $UNI);
			session_start();
			$SESSION       	= new Session();
			$SESSION->CreateSession($NewUser, $UserName, $PlanetID, $UNI);
			redirectTo("game.php?page=overview");
		}
	break;
	case 'lostpassword': 
		if ($mode == "send") {
			$USERmail = request_var('email', '');
			$Universe = request_var('universe', 0);
			$ExistMail = $db->uniquequery("SELECT `username` FROM ".USERS." WHERE `email` = '".$db->sql_escape($USERmail)."' AND `universe` = '".$Universe."';");
			if (empty($ExistMail['username'])) {
				$template->message($LNG['mail_not_exist'], "index.php?page=lostpassword&lang=".$LANG->getUser(), 3, true);
			} else {
				$Caracters = "aazertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN1234567890";
				$Count = strlen($Caracters);
				$Taille = 8;
				$NewPass = "";
				for($i = 0; $i < $Taille; $i ++) {
					$CaracterBoucle = rand ( 0, $Count - 1 );
					$NewPass .= substr ( $Caracters, $CaracterBoucle, 1 );
				}

				$MailRAW		= file_get_contents("./language/".$CONF['lang']."/email/email_lost_password.txt");
				$MailContent	= sprintf($MailRAW, $ExistMail['username'], $CONF['game_name'], $NewPass, "http://".$_SERVER['SERVER_NAME'].$_SERVER["PHP_SELF"]);			
			
				$Mail			= MailSend($USERmail, $ExistMail['username'], $LNG['mail_title'], $MailContent);
				
				if(true === true)
				{
					$db->query("UPDATE ".USERS." SET `password` ='" . md5($NewPass) . "' WHERE `username` = '".$ExistMail['username']."' AND `universe` = '".$Universe."';");
					$template->message($LNG['mail_sended'], "./?lang=".$LANG->getUser(), 5, true);
				} else {
					$template->message($LNG['mail_sended_fail'], "./?lang=".$LANG->getUser(), 5, true);
				}
			
			}
		} else {
			$AvailableUnis[$CONF['uni']]	= $CONF['game_name'].($CONF['game_disable'] == 0 ? $LNG['uni_closed'] : '');
			$Query	= $db->query("SELECT `uni`, `game_disable`, `game_name` FROM ".CONFIG." WHERE `uni` != '".$UNI."' ORDER BY `uni` ASC;");
			while($Unis	= $db->fetch_array($Query)) {
				$AvailableUnis[$Unis['uni']]	= $Unis['game_name'].($Unis['game_disable'] == 0 ? $LNG['uni_closed'] : '');
			}
			ksort($AvailableUnis);
			$template->assign_vars(array(
				'email'				=> $LNG['email'],
				'uni_reg'			=> $LNG['uni_reg'],
				'send'				=> $LNG['send'],
				'AvailableUnis'		=> $AvailableUnis,
				'chose_a_uni'		=> $LNG['chose_a_uni'],
				'lost_pass_title'	=> $LNG['lost_pass_title'],
			));
			$template->show('public/lostpassword.tpl');
		}
		break;
	case 'reg' :
		if ($CONF['reg_closed'] == 1){
			$template->assign_vars(array(
				'closed'	=> $LNG['reg_closed'],
				'info'		=> $LNG['info'],
			));
			$template->show('public/registry_closed.tpl');
			exit;
		}
		switch ($mode) {
			case 'send' :
				$UserPass 	= request_var('password', '');
				$UserPass2 	= request_var('password2', '');
				$UserName 	= request_var('character', '', UTF8_SUPPORT);
				$UserPlanet	= request_var('planet', '', UTF8_SUPPORT);
				$UserEmail 	= request_var('email', '');
				$UserEmail2	= request_var('email2', '');
				$agbrules 	= request_var('rgt', '');
				$UserLang 	= request_var('lang', '');
				$Universe 	= request_var('universe', 0);
	
				if ($CONF['capaktiv'] === '1') {
					require_once('includes/libs/reCAPTCHA/recaptchalib.php');
					$resp = recaptcha_check_answer($CONF['capprivate'], $_SERVER['REMOTE_ADDR'], $_REQUEST['recaptcha_challenge_field'], $_REQUEST['recaptcha_response_field']);
					if (!$resp->is_valid)
						$errors .= $LNG['wrong_captcha'];
				}
				
				$Exist['userv'] = $db->uniquequery("SELECT username, email FROM ".USERS." WHERE `universe` = '".$Universe."' AND (username = '".$db->sql_escape($UserName)."' OR email = '".$db->sql_escape($UserEmail)."');");
				$Exist['valid'] = $db->uniquequery("SELECT username, email FROM ".USERS_VALID." WHERE `universe` = '".$Universe."' AND (username = '".$db->sql_escape($UserName)."' OR email = '".$db->sql_escape($UserEmail)."');");
				
				$errors 	= '';
				$errors	   .= !ValidateAddress($UserEmail) ? $LNG['invalid_mail_adress'] : '';
				$errors	   .= empty($UserName) ? $LNG['empty_user_field'] : '';
				$errors	   .= empty($UserPlanet) ? 	$LNG['empty_planet_field'] : '';			
				$errors	   .= !isset($UserPass{5}) ? $LNG['password_lenght_error'] : '';					
				$errors	   .= $UserPass != $UserPass2 ? $LNG['different_passwords'] : '';				
				$errors	   .= $UserEmail != $UserEmail2 ? $LNG['different_mails'] : '';		
				$errors	   .= $agbrules != 'on' ? $LNG['terms_and_conditions'] : '';
				$errors    .= (isset($Exist['userv']['username']) || isset($Exist['valid']['username']) && ($UserName == $Exist['userv']['username'] || $UserName == $Exist['valid']['username'])) ? $LNG['user_already_exists'] : '';
				$errors    .= (isset($Exist['userv']['email']) || isset($Exist['valid']['email'])) && ($UserEmail == $Exist['userv']['email'] || $UserEmail == $Exist['valid']['email']) ? $LNG['mail_already_exists'] : '';
				
				if (!CheckName($UserName))
					$errors .= (UTF8_SUPPORT) ? $LNG['user_field_no_space'] : $LNG['user_field_no_alphanumeric'];				
				
				if (!CheckName($UserPlanet))
					$errors .= (UTF8_SUPPORT) ? $LNG['planet_field_no_space'] : $LNG['planet_field_no_alphanumeric'];			
								
				if (!empty($errors)) {
					$template->message($errors, '?page=reg&lang='.$LANG->getUser(), 3, true);
					exit;
				}
				
				$md5newpass = md5($UserPass);
					
				$clef	= uniqid('2m');

				$SQL = "INSERT INTO ".USERS_VALID." SET ";
				$SQL .= "`username` = '".$db->sql_escape($UserName)."', ";
				$SQL .= "`email` = '".$db->sql_escape($UserEmail)."', ";
				$SQL .= "`lang` = '".$db->sql_escape($UserLang)."', ";
				$SQL .= "`planet` = '".$db->sql_escape($UserPlanet)."', ";
				$SQL .= "`date` = '".TIMESTAMP."', ";
				$SQL .= "`cle` = '".$clef."', ";
				$SQL .= "`universe` = '".$Universe."', ";
				$SQL .= "`password` = '".$md5newpass."', ";
				$SQL .= "`ip` = '".$_SERVER['REMOTE_ADDR']."'; ";
				$db->query($SQL);
				
				if($CONF['user_valid'] == 0) {
					redirectTo("index.php?page=reg&mode=valid&lang=".$UserLang."&clef=".$clef);
				} else {
					$MailSubject 	= $LNG['reg_mail_message_pass'];
					$MailRAW		= file_get_contents("./language/".$UserLang."/email/email_vaild_reg.txt");
					$MailContent	= sprintf($MailRAW, $UserName, $CONF['game_name'], "http://".$_SERVER['SERVER_NAME'].$_SERVER["PHP_SELF"], $clef, $UserPass, $CONF['smtp_sendmail'], $UserLang);
			
					MailSend($UserEmail, $UserName, $MailSubject, $MailContent);
					$template->message($LNG['reg_completed'], '?lang='.$UserLang, 10, true);
				}								
			break;
			case 'valid' :		
				$pseudo 	= request_var('id', '');
				$clef 		= request_var('clef', '');
				$admin 	 	= request_var('admin', 0);
				$Valider	= $db->uniquequery("SELECT `username`, `password`, `email`, `ip`, `planet`, `lang`, `universe` FROM ".USERS_VALID." WHERE `cle` = '".$db->sql_escape($clef)."';");
				if(!isset($Valider)) 
					redirectTo('index.php?page=reg');
				
				$UserName 	= $Valider['username'];
				$UserPass 	= $Valider['password'];
				$UserMail 	= $Valider['email'];
				$UserIP 	= $Valider['ip'];
				$UserPlanet	= $Valider['planet'];
				$UserLang 	= $Valider['lang'];
				$UserUni 	= $Valider['universe'];
				$CONF		= $db->uniquequery("SELECT `initial_fields`, `LastSettedGalaxyPos`, `LastSettedSystemPos`, `LastSettedPlanetPos`, `smtp_host`, `smtp_port`, `smtp_user`, `smtp_pass`, `smtp_ssl`, `smtp_sendmail`, `game_name`, `users_amount`, `metal_basic_income`, `crystal_basic_income`, `deuterium_basic_income` FROM ".CONFIG." WHERE `uni` = ".$UserUni.";");
				
				$SQL = "INSERT INTO " . USERS . " SET ";
				$SQL .= "`username` = '".$UserName . "', ";
				$SQL .= "`universe` = '".$UserUni . "', ";
				$SQL .= "`email` = '".$UserMail."', ";
				$SQL .= "`email_2` = '".$UserMail."', ";
				$SQL .= "`lang` = '".$UserLang."', ";
				$SQL .= "`ip_at_reg` = '".$UserIP."', ";
				$SQL .= "`id_planet` = '0', ";
				$SQL .= "`onlinetime` = '".TIMESTAMP."', ";
				$SQL .= "`register_time` = '".TIMESTAMP. "', ";
				$SQL .= "`password` = '".$UserPass."', ";
				$SQL .= "`dpath` = '".DEFAULT_SKINPATH."', ";
				$SQL .= "`uctime`= '0';";
				$db->query($SQL);
				$NewUser = $db->GetInsertID();
				
				$MailSubject	= sprintf($LNG['reg_mail_reg_done'], $CONF['game_name']);	
				$MailRAW		= file_get_contents("./language/".$UserLang."/email/email_reg_done.txt");
				$MailContent	= sprintf($MailRAW, $UserName, $CONF['game_name']);	
				MailSend($UserMail, $UserName, $MailSubject, $MailContent);
			
				$LastSettedGalaxyPos = $CONF['LastSettedGalaxyPos'];
				$LastSettedSystemPos = $CONF['LastSettedSystemPos'];
				$LastSettedPlanetPos = $CONF['LastSettedPlanetPos'];
				require_once(ROOT_PATH.'includes/functions/CreateOnePlanetRecord.php');	
				$PlanetID = false;
				
				while ($PlanetID === false) {
					$Planet = mt_rand(4, 12);
					if ($LastSettedPlanetPos < 3) {
						$LastSettedPlanetPos += 1;
					} else {
						if ($LastSettedSystemPos == MAX_SYSTEM_IN_GALAXY) {
							$LastSettedGalaxyPos += 1;
							$LastSettedSystemPos = 1;
							$LastSettedPlanetPos = 1;
						} else {
							$LastSettedSystemPos += 1;
							$LastSettedPlanetPos = 1;
						}
					}
					
					$PlanetID = CreateOnePlanetRecord($LastSettedGalaxyPos, $LastSettedSystemPos, $Planet, $UserUni, $NewUser, $UserPlanet, true);
				}
			
				$SQL = "DELETE FROM ".USERS_VALID." WHERE `cle` = '".$db->sql_escape($clef)."';";
				$SQL .= "UPDATE ".USERS." SET ";
				$SQL .= "`id_planet` = '".$PlanetID."', ";
				$SQL .= "`galaxy` = '".$LastSettedGalaxyPos."', ";
				$SQL .= "`system` = '".$LastSettedSystemPos."', ";
				$SQL .= "`planet` = '".$Planet."' ";
				$SQL .= "WHERE ";
				$SQL .= "`id` = '".$NewUser."' ";
				$SQL .= "LIMIT 1;";
				$SQL .= "INSERT INTO ".STATPOINTS." (`id_owner`, `id_ally`, `stat_type`, `universe`, `tech_rank`, `tech_old_rank`, `tech_points`, `tech_count`, `build_rank`, `build_old_rank`, `build_points`, `build_count`, `defs_rank`, `defs_old_rank`, `defs_points`, `defs_count`, `fleet_rank`, `fleet_old_rank`, `fleet_points`, `fleet_count`, `total_rank`, `total_old_rank`, `total_points`, `total_count`) VALUES (".$NewUser.", 0, 1, ".$UserUni.", '".($CONF ['users_amount'] + 1)."', '".($CONF ['users_amount'] + 1)."', 0, 0, '".($CONF ['users_amount'] + 1)."', '".($CONF ['users_amount'] + 1)."', 0, 0, '".($CONF ['users_amount'] + 1)."', '".($CONF ['users_amount'] + 1)."', 0, 0, '".($CONF ['users_amount'] + 1)."', '".($CONF ['users_amount'] + 1)."', 0, 0, '".($CONF ['users_amount'] + 1)."', '".($CONF ['users_amount'] + 1)."', 0, 0);";
				$db->multi_query($SQL);
				
				$from 		= $LNG['welcome_message_from'];
				$Subject 	= $LNG['welcome_message_subject'];
				$message 	= sprintf($LNG['welcome_message_content'], $CONF['game_name']);
				SendSimpleMessage($NewUser, 1, $Time, 1, $from, $Subject, $message);
				
				update_config(array('users_amount' => $CONF['users_amount'] + 1, 'LastSettedGalaxyPos' => $LastSettedGalaxyPos, 'LastSettedSystemPos' => $LastSettedSystemPos, 'LastSettedPlanetPos' => $LastSettedPlanetPos), false, $UserUni);
				if ($admin == 1) {
					echo sprintf($LNG['user_active'], $UserName);
				} else {
					session_start();
					$SESSION       	= new Session();
					$SESSION->CreateSession($NewUser, $UserName, $PlanetID, $UserUni);

					redirectTo("game.php?page=overview");
				}
			break;
			default:
				$AvailableUnis[$CONF['uni']]	= $CONF['game_name'].($CONF['game_disable'] == 0 ? $LNG['uni_closed'] : '');
				$Query	= $db->query("SELECT `uni`, `game_disable`, `game_name` FROM ".CONFIG." WHERE `uni` != '".$UNI."' ORDER BY `uni` ASC;");
				while($Unis	= $db->fetch_array($Query)) {
					$AvailableUnis[$Unis['uni']]	= $Unis['game_name'].($Unis['game_disable'] == 0 ? $LNG['uni_closed'] : '');
				}
				ksort($AvailableUnis);
				$template->assign_vars(array(
					'server_message_reg'			=> $LNG['server_message_reg'],
					'register_at_reg'				=> $LNG['register_at_reg'],
					'user_reg'						=> $LNG['user_reg'],
					'pass_reg'						=> $LNG['pass_reg'],
					'pass2_reg'						=> $LNG['pass2_reg'],
					'email_reg'						=> $LNG['email_reg'],
					'email2_reg'					=> $LNG['email2_reg'],
					'planet_reg'					=> $LNG['planet_reg'],
					'lang_reg'						=> $LNG['lang_reg'],
					'captcha_reg'					=> $LNG['captcha_reg'],
					'register_now'					=> $LNG['register_now'],
					'accept_terms_and_conditions'	=> sprintf($LNG['accept_terms_and_conditions'], $LANG->getUser()),
					'captcha_reload'				=> $LNG['captcha_reload'],
					'captcha_help'					=> $LNG['captcha_help'],
					'captcha_get_image'				=> $LNG['captcha_get_image'],
					'captcha_reload'				=> $LNG['captcha_reload'],
					'captcha_get_audio'				=> $LNG['captcha_get_audio'],
					'AvailableUnis'					=> $AvailableUnis,
					'AvailableLangs'				=> $LANG->getAllowedLangs(false),
					'uni_reg'						=> $LNG['uni_reg'],
					'chose_a_uni'					=> $LNG['chose_a_uni'],
					'register'						=> $LNG['register'],
					'send'							=> $LNG['send'],
					'uni_closed'					=> $LNG['uni_closed'],
				));
				$template->show('public/registry_form.tpl');
			break;
		}
		break;
	case 'agb' :
		$template->assign_vars(array(
			'agb'				=> $LNG['agb'],
			'agb_overview'		=> $LNG['agb_overview'],
		));
		$template->show('public/index_agb.tpl');
		break;
	case 'rules' :
		$template->assign_vars(array(
			'rules'				=> $LNG['rules'],
			'rules_overview'	=> $LNG['rules_overview'],
			'rules_info1'		=> sprintf($LNG['rules_info1'], $CONF['forum_url']),
			'rules_info2'		=> $LNG['rules_info2'],
		));
		$template->show('public/index_rules.tpl');
		break;
	case 'screens':
		$template->assign_vars(array(
			'screenshots'           => $LNG['screenshots'],
		));
		$template->show('public/index_screens.tpl');
		break;
	case 'top100' :
		$Universe = request_var('universe', 1);
		$top = $db->query("SELECT * FROM ".TOPKB." WHERE `universe` = '".$Universe."' ORDER BY gesamtunits DESC LIMIT 100;");
		while($data = $db->fetch_array($top)) {
			$TopKBList[]	= array(
				'result'	=> $data['fleetresult'],
				'time'		=> date("D d M H:i:s", $data['time']),
				'units'		=> pretty_number($data['gesamtunits']),
				'rid'		=> $data['rid'],
				'attacker'	=> $data['angreifer'],
				'defender'	=> $data['defender'],
				'result'	=> $data['fleetresult'],
			);
		}
		
		$AvailableUnis[$CONF['uni']]	= $CONF['game_name'].($CONF['game_disable'] == 0 ? $LNG['uni_closed'] : '');
		$Query	= $db->query("SELECT `uni`, `game_disable`, `game_name` FROM ".CONFIG." WHERE `uni` != '".$UNI."' ORDER BY `uni` ASC;");
		while($Unis	= $db->fetch_array($Query)) {
			$AvailableUnis[$Unis['uni']]	= $Unis['game_name'].($Unis['game_disable'] == 0 ? $LNG['uni_closed'] : '');
		}
		ksort($AvailableUnis);
			
		$template->assign_vars(array(	
			'AvailableUnis'	=> $AvailableUnis,
			'ThisUni'		=> $ThisUni,
			'tkb_units'		=> $LNG['tkb_units'],
			'tkb_datum'		=> $LNG['tkb_datum'],
			'tkb_owners'	=> $LNG['tkb_owners'],
			'tkb_platz'		=> $LNG['tkb_platz'],
			'tkb_top'		=> $LNG['tkb_top'],
			'tkb_gratz'		=> $LNG['tkb_gratz'],
			'tkb_legende'	=> $LNG['tkb_legende'],
			'tkb_gewinner'	=> $LNG['tkb_gewinner'],
			'tkb_verlierer'	=> $LNG['tkb_verlierer'],
			'TopKBList'		=> $TopKBList,
		));
			
		$template->show('public/index_top100.tpl');
		break;
	case 'pranger' :
		$Universe = request_var('universe', 1);
		$PrangerRAW = $db->query("SELECT * FROM ".BANNED." WHERE `universe` = '".$Universe."' ORDER BY `id`;");

		while($u = $db->fetch_array($PrangerRAW))
		{
			$PrangerList[]	= array(
				'player'	=> $u['who'],
				'theme'		=> $u['theme'],
				'from'		=> date("d. M Y H:i:s",$u['time']),
				'to'		=> date("d. M Y H:i:s",$u['longer']),
				'admin'		=> $u['author'],
				'mail'		=> $u['email'],
				'info'		=> sprintf($LNG['bn_writemail'], $u['author']),
			);
		}
		
		$AvailableUnis[$CONF['uni']]	= $CONF['game_name'].($CONF['game_disable'] == 0 ? $LNG['uni_closed'] : '');
		$Query	= $db->query("SELECT `uni`, `game_disable`, `game_name` FROM ".CONFIG." WHERE `uni` != '".$UNI."' ORDER BY `uni` ASC;");
		while($Unis	= $db->fetch_array($Query)) {
			$AvailableUnis[$Unis['uni']]	= $Unis['game_name'].($Unis['game_disable'] == 0 ? $LNG['uni_closed'] : '');
		}
		ksort($AvailableUnis);
		
		$template->assign_vars(array(	
			'AvailableUnis'				=> $AvailableUnis,
			'ThisUni'					=> $ThisUni,
			'PrangerList'				=> $PrangerList,
			'bn_no_players_banned'		=> $LNG['bn_no_players_banned'],
			'bn_exists'					=> $LNG['bn_exists'],
			'bn_players_banned'			=> $LNG['bn_players_banned'],
			'bn_players_banned_list'	=> $LNG['bn_players_banned_list'],
			'bn_player'					=> $LNG['bn_player'],
			'bn_reason'					=> $LNG['bn_reason'],
			'bn_from'					=> $LNG['bn_from'],
			'bn_until'					=> $LNG['bn_until'],
			'bn_by'						=> $LNG['bn_by'],
		));
		
		$template->show('public/index_pranger.tpl');
		break;
	case 'disclamer':
		$template->assign_vars(array(
			'disclamer'			=> $LNG['disclamer'],
			'disclamer_name'	=> $LNG['disclamer_name'],
			'disclamer_adress'	=> $LNG['disclamer_adress'],
			'disclamer_tel'		=> $LNG['disclamer_tel'],
			'disclamer_email'	=> $LNG['disclamer_email'],
		));
		$template->show('public/index_disclamer.tpl');
		break;
	case 'news' :
		$NewsRAW	= $db->query ("SELECT date,title,text,user FROM ".NEWS." ORDER BY id DESC;");
		while ($NewsRow = $db->fetch_array($NewsRAW)) {
			$NewsList[]	= array(
				'title' => $NewsRow['title'],
				'from' 	=> sprintf($LNG['news_from'], date("d. M Y H:i:s", $NewsRow['date']), $NewsRow['user']),
				'text' 	=> makebr($NewsRow['text']),
			);
		}
		$template->assign_vars(array(
			'NewsList'				=> $NewsList,
			'news_overview'			=> $LNG['news_overview'],
			'news_does_not_exist'	=> $LNG['news_does_not_exist'],
		));
		
		$template->show('public/index_news.tpl');
	break;
	default :
		if ($_POST) {
			$luser = request_var('username', '', UTF8_SUPPORT);
			$lpass = request_var('password', '', UTF8_SUPPORT);
			$luniv = request_var('universe', 1);
			$login = $db->uniquequery("SELECT `id`, `username`, `dpath`, `authlevel`, `id_planet` FROM ".USERS." WHERE `username` = '".$db->sql_escape($luser)."' AND `universe` = '".$luniv."' AND `password` = '".md5($lpass)."';");
			
			if (isset($login)) {
				session_start();
				$SESSION       	= new Session();
				$SESSION->CreateSession($login['id'], $login['username'], $login['id_planet'], $luniv, $login['authlevel'], $login['dpath']);

				redirectTo("game.php?page=overview");
			} else {
				redirectTo('index.php?code=1');
			}
		} else {
			$AvailableUnis[$CONF['uni']]	= $CONF['game_name'].($CONF['game_disable'] == 0 ? $LNG['uni_closed'] : '');
			$Query	= $db->query("SELECT `uni`, `game_disable`, `game_name` FROM ".CONFIG." WHERE `uni` != '".$UNI."' ORDER BY `uni` ASC;");
			while($Unis	= $db->fetch_array($Query)) {
				$AvailableUnis[$Unis['uni']]	= $Unis['game_name'].($Unis['game_disable'] == 0 ? $LNG['uni_closed'] : '');
			}
			ksort($AvailableUnis);
			$Code	= request_var('code', 0);
			if(!empty($Code)) {
				$template->assign_vars(array(
					'code'					=> $LNG['login_error_'.$Code],
				));
			}
			$template->assign_vars(array(
				'AvailableUnis'			=> $AvailableUnis,
				'welcome_to'			=> $LNG['welcome_to'],
				'server_description'	=> sprintf($LNG['server_description'], $CONF['game_name']),
				'server_infos'			=> $LNG['server_infos'],
				'login'					=> $LNG['login'],
				'login_info'			=> sprintf($LNG['login_info'], $LANG->getUser()),
				'user'					=> $LNG['user'],
				'pass'					=> $LNG['pass'],
				'lostpassword'			=> $LNG['lostpassword'],
				'register_now'			=> $LNG['register_now'],
				'screenshots'			=> $LNG['screenshots'],
				'chose_a_uni'			=> $LNG['chose_a_uni'],
				'universe'				=> $LNG['universe'],
			));
			$template->show('public/index_body.tpl');
		}
	break;
}
?>