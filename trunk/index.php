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
 * @copyright 2009 Lucky <lucky@xgproyect.net> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.6.1 (2011-11-19)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

define('MODE', 'INDEX');
define('ROOT_PATH', str_replace('\\', '/',dirname(__FILE__)).'/');

if(!file_exists(ROOT_PATH.'includes/config.php')) {
	require(ROOT_PATH . 'includes/constants.php');
	require(ROOT_PATH . 'includes/classes/HTTP.class.php');
	HTTP::redirectTo("install/index.php");
}

require(ROOT_PATH . 'includes/common.php');
	
$template	= new template();
$LANG->GetLangFromBrowser();
$LANG->includeLang(array('L18N', 'INGAME', 'PUBLIC', 'CUSTOM'));

$THEME->isHome();
$page	= HTTP::_GP('page', '');
$action	= HTTP::_GP('action', '');
$mode 	= HTTP::_GP('mode', '');

switch ($page) {
	case 'lostpassword': 
		if($CONF['mail_active'] == 0)
			HTTP::redirectTo("index.php");

		$Username = HTTP::_GP('username', '', UTF8_SUPPORT);
		$Usermail = HTTP::_GP('email', '');
		
		if(empty($Username) || empty($Usermail) || !ValidateAddress($Usermail)) {
			echo json_encode(array('message' => $LNG['lost_empty'], 'error' => true));
			exit;
		}
			
		$UserID 	= $GLOBALS['DATABASE']->countquery("SELECT id FROM ".USERS." 
		WHERE universe = ".$UNI." 
		AND username = '".$GLOBALS['DATABASE']->sql_escape($Username)."' 
		AND (email = '".$GLOBALS['DATABASE']->sql_escape($Usermail)."' 
		OR email_2 = '".$GLOBALS['DATABASE']->sql_escape($Usermail)."');");
		
		if (!isset($UserID)) {
			echo json_encode(array('message' => $LNG['lost_not_exists'], 'error' => true));
			exit;
		} else {
			$NewPass		= uniqid();
			$MailRAW		= $LANG->getMail('email_lost_password');
			$MailContent	= sprintf($MailRAW, $Usermail, $CONF['game_name'], $NewPass, "http://".$_SERVER['SERVER_NAME'].$_SERVER["PHP_SELF"]);			
		
			$Mail			= MailSend($Usermail, $Username, $LNG['lost_mail_title'], $MailContent);
			$GLOBALS['DATABASE']->query("UPDATE ".USERS." SET password = '".cryptPassword($NewPass)."' WHERE id = '".$UserID."';");
			echo json_encode(array('message' => sprintf($LNG['mail_sended'],$Usermail), 'error' => false));
		}
	break;
	case 'reg' :
		switch ($action) {
			case 'check' :
				$value	= HTTP::_GP('value', '', UTF8_SUPPORT);
				switch($mode) {
					case 'username' :
						$Count 	= $GLOBALS['DATABASE']->countquery("SELECT (SELECT COUNT(*) FROM ".USERS." WHERE universe = ".$UNI." AND username = '".$GLOBALS['DATABASE']->sql_escape($value)."') + (SELECT COUNT(*) FROM ".USERS_VALID." WHERE universe = ".$UNI." AND username = '".$GLOBALS['DATABASE']->sql_escape($value)."')");
					break;
					case 'email' :
						$Count 	= $GLOBALS['DATABASE']->countquery("SELECT (SELECT COUNT(*) FROM ".USERS." WHERE universe = ".$UNI." AND (email = '".$GLOBALS['DATABASE']->sql_escape($value)."' OR email_2 = '".$GLOBALS['DATABASE']->sql_escape($value)."')) + (SELECT COUNT(*) FROM ".USERS_VALID." WHERE universe = ".$UNI." AND email = '".$GLOBALS['DATABASE']->sql_escape($value)."')");
					break;
					case 'fbid' :
						$Count 	= $GLOBALS['DATABASE']->countquery("SELECT COUNT(*) FROM ".USERS_AUTH." WHERE account = '".$GLOBALS['DATABASE']->sql_escape($value)."' AND mode = 'facebook';");
					break;
					case 'ref' :
						$Count 	= $GLOBALS['DATABASE']->countquery("SELECT universe FROM ".USERS." WHERE id = '".$GLOBALS['DATABASE']->sql_escape($value)."';");
					break;
				}
				
				if($Count == 0)
					echo json_encode(array('exists' => false));
				else
					echo json_encode(array('exists' => true, 'Message' => $Count));
			break;
			case 'send' :
				if($CONF['reg_closed'] == 1) {
					echo json_encode(array('error' => true, 'message' => array(array('universe', $LNG['register_closed']))));
					exit;
				}
					
				$UserName 	= HTTP::_GP('username', '', UTF8_SUPPORT);
				$UserPass 	= HTTP::_GP('password', '');
				$UserPass2 	= HTTP::_GP('password_2', '');
				$UserEmail 	= HTTP::_GP('email', '');
				$UserEmail2	= HTTP::_GP('email_2', '');
				$agbrules 	= HTTP::_GP('rgt', '');
				$UserPlanet	= HTTP::_GP('planetname', '', UTF8_SUPPORT);
				$UserLang 	= HTTP::_GP('lang', '');
				$FACEBOOK 	= HTTP::_GP('fb_id', 0);
				$RefID	 	= HTTP::_GP('ref_id', 0);
	
				$errors 	= array();
				
				if ($CONF['capaktiv'] === '1') {
					require_once('includes/libs/reCAPTCHA/recaptchalib.php');
					$resp = recaptcha_check_answer($CONF['capprivate'], $_SERVER['REMOTE_ADDR'], $_REQUEST['recaptcha_challenge_field'], $_REQUEST['recaptcha_response_field']);
					if (!$resp->is_valid)
						$errors[]	= array('captcha', $LNG['wrong_captcha']);
				}
				
				$ExistsUser 	= $GLOBALS['DATABASE']->countquery("SELECT (SELECT COUNT(*) FROM ".USERS." WHERE universe = '".$UNI."' AND username = '".$GLOBALS['DATABASE']->sql_escape($UserName)."') + (SELECT COUNT(*) FROM ".USERS_VALID." WHERE universe = '".$UNI."' AND username = '".$GLOBALS['DATABASE']->sql_escape($UserName)."')");
				$ExistsMails	= $GLOBALS['DATABASE']->countquery("SELECT (SELECT COUNT(*) FROM ".USERS." WHERE universe = '".$UNI."' AND (email = '".$GLOBALS['DATABASE']->sql_escape($UserEmail)."' OR email_2 = '".$GLOBALS['DATABASE']->sql_escape($UserEmail)."')) + (SELECT COUNT(*) FROM ".USERS_VALID." WHERE universe = '".$UNI."' AND email = '".$GLOBALS['DATABASE']->sql_escape($UserEmail)."')");
				
				if(empty($UserName)) {
					$errors[]	= array('username', $LNG['empty_user_field']);
				}
				
				if(!CheckName($UserName)) {
					$errors[]	= array('username', $LNG['user_field_specialchar']);
				}
				
				if($ExistsUser != 0) {
					$errors[]	= array('username', $LNG['user_already_exists']);
				}
				
				if(!isset($UserPass{5})) {
					$errors[]	= array('password', $LNG['password_lenght_error']);
				}
					
				if($UserPass != $UserPass2) {
					$errors[]	= array('password_2', $LNG['different_passwords']);
				}
					
				if($ExistsMails != 0) {
					$errors[]	= array('email', $LNG['mail_already_exists']);
				}
					
				if(!ValidateAddress($UserEmail)) {
					$errors[]	= array('email', $LNG['invalid_mail_adress']);
				}
					
				if($UserEmail != $UserEmail2) {
					$errors[]	= array('email_2', $LNG['different_mails']);
				}
					
				if(empty($UserPlanet)) {
					$errors[]	= array('planetname', $LNG['planet_field_no']);
				}
				
				if(!CheckName($UserPlanet)) {
					$errors[]	= array('planetname', $LNG['planet_field_specialchar']);	
				}
				
				if($agbrules != 'on') {
					$errors[]	= array('rgt', $LNG['terms_and_conditions']);
				}
								
				if (!empty($errors)) {
					echo json_encode(array('error' => true, 'message' => $errors));
					exit;
				}
				
				if($CONF['fb_on'] == 1 && !empty($FACEBOOK)) {
				
					require(ROOT_PATH.'/includes/libs/facebook/facebook.php');
					$facebook = new Facebook(array(
						'appId'  => $CONF['fb_apikey'],
						'secret' => $CONF['fb_skey'],
						'cookie' => true,
					));	

					$FACEBOOK	= $facebook->getUser();
				} else {
					$FACEBOOK	= 0;
				}
				
				if($CONF['ref_active'] == 1 && !empty($RefID)) {
					$Count	= $GLOBALS['DATABASE']->countquery("SELECT COUNT(*) FROM ".USERS." WHERE id = '".$RefID."';");
					if($Count == 0)
						$RefID	= 0;
				} else {
					$RefID	= 0;
				}
				
				$clef		= uniqid('2m');
				$SQL = "INSERT INTO ".USERS_VALID." SET ";
				$SQL .= "username = '".$GLOBALS['DATABASE']->sql_escape($UserName)."', ";
				$SQL .= "email = '".$GLOBALS['DATABASE']->sql_escape($UserEmail)."', ";
				$SQL .= "lang = '".$GLOBALS['DATABASE']->sql_escape($UserLang)."', ";
				$SQL .= "planet = '".$GLOBALS['DATABASE']->sql_escape($UserPlanet)."', ";
				$SQL .= "date = '".TIMESTAMP."', ";
				$SQL .= "cle = '".$clef."', ";
				$SQL .= "universe = '".$UNI."', ";
				$SQL .= "password = '".cryptPassword($UserPass)."', ";
				$SQL .= "ip = '".$_SERVER['REMOTE_ADDR']."', ";
				$SQL .= "ref_id = ".$RefID."; ";
				$GLOBALS['DATABASE']->query($SQL);
				
				if(!empty($FACEBOOK) || $CONF['user_valid'] == 0 || $CONF['mail_active'] == 0) {
					HTTP::redirectTo("index.php?uni=".$UNI."&page=reg&action=valid&clef=".$clef);
				} else {
					$MailSubject 	= $LNG['reg_mail_message_pass'];
					$MailRAW		= $LANG->getMail('email_vaild_reg');
					$MailContent	= sprintf($MailRAW, $UserName, $CONF['game_name'].' - '.$CONF['uni_name'], "http://".$_SERVER['SERVER_NAME'].$_SERVER["PHP_SELF"], $clef, $UserPass, $CONF['smtp_sendmail'], $UNI);
					ob_start();
					MailSend($UserEmail, $UserName, $MailSubject, $MailContent);
					$Debug	= ob_get_clean();
					if(!empty($Debug))
						$Debug	.= "<br />";
						
					echo json_encode(array('error' => false, 'message' => $Debug.$LNG['reg_completed']));
				}								
			break;
			case 'valid' :
				$clef 		= HTTP::_GP('clef', '');
				$admin 	 	= HTTP::_GP('admin', 0);
				$userData	= $GLOBALS['DATABASE']->uniquequery("SELECT * FROM ".USERS_VALID." WHERE cle = '".$GLOBALS['DATABASE']->sql_escape($clef)."' AND universe = ".$UNI.";");
				$GLOBALS['DATABASE']->query("DELETE FROM ".USERS_VALID." WHERE cle = '".$GLOBALS['DATABASE']->sql_escape($clef)."' AND universe = ".$UNI.";");
				
				if(!isset($userData)) {
					HTTP::redirectTo('index.php');
				}
				
				$UserName 	= $userData['username'];
				$UserPass 	= $userData['password'];
				$UserMail 	= $userData['email'];
				$UserIP 	= $userData['ip'];
				$UserPlanet	= $userData['planet'];
				$UserLang 	= $userData['lang'];
				$UserUni 	= $userData['universe'];
				$UserRID 	= $userData['ref_id'];
				
				if($CONF['mail_active'] == 1) {
					$MailSubject	= sprintf($LNG['reg_mail_reg_done'], $CONF['game_name']);	
					$MailRAW		= $LANG->getMail('email_reg_done');
					$MailContent	= sprintf($MailRAW, $UserName, $CONF['game_name'].' - '.$CONF['uni_name']);	
					MailSend($UserMail, $UserName, $MailSubject, $MailContent);
				}
				
				$SQL = "INSERT INTO ".USERS." SET
				username		= '".$GLOBALS['DATABASE']->sql_escape($UserName)."',
				email			= '".$GLOBALS['DATABASE']->sql_escape($UserMail)."',
				email_2			= '".$GLOBALS['DATABASE']->sql_escape($UserMail)."',
				universe		= ".$UserUni.",
				lang			= '".$UserLang."',
				ip_at_reg		= '".$UserIP."',
				id_planet		= 0,
				onlinetime		= ".TIMESTAMP.",
				register_time	= ".TIMESTAMP.",
				password		= '".$UserPass."',
				dpath			= '".DEFAULT_THEME."',
				darkmatter		= ".$CONF['darkmatter_start'].",
				ref_id			= ".$UserRID.",
				timezone		= '".$CONF['timezone']."',
				ref_bonus		= ".($UserRID != 0 ? 1 : 0).",
				uctime			= 0;";
				
				$GLOBALS['DATABASE']->query($SQL);
				
				$userID = $GLOBALS['DATABASE']->GetInsertID();

				$LastSettedGalaxyPos = $CONF['LastSettedGalaxyPos'];
				$LastSettedSystemPos = $CONF['LastSettedSystemPos'];
				$LastSettedPlanetPos = $CONF['LastSettedPlanetPos'];
				require_once(ROOT_PATH.'includes/functions/CreateOnePlanetRecord.php');	
				$PlanetID = false;
				
				while ($PlanetID === false) {
					$Planet = mt_rand(round($CONF['max_planets'] * 0.2), round($CONF['max_planets'] * 0.8));
					if ($LastSettedPlanetPos < 3) {
						$LastSettedPlanetPos += 1;
					} else {
						if ($LastSettedSystemPos >= $CONF['max_system']) {
							$LastSettedGalaxyPos += 1;
							$LastSettedSystemPos = 1;
						} else {
							$LastSettedSystemPos += 1;
						}
						
						if($LastSettedGalaxyPos  >= $CONF['max_galaxy']) {
							$LastSettedGalaxyPos	= 1;
						}
					}
					
					$PlanetID = CreateOnePlanetRecord($LastSettedGalaxyPos, $LastSettedSystemPos, $Planet, $UserUni, $userID, $UserPlanet, true);
				}
			
				$SQL = "UPDATE ".USERS." SET 
				id_planet	= ".$PlanetID.",
				galaxy		= ".$LastSettedGalaxyPos.",
				system		= ".$LastSettedSystemPos.",
				planet		= ".$Planet."
				WHERE
				id			= ".$userID.";
				INSERT INTO ".STATPOINTS." SET 
				id_owner	= ".$userID.",
				universe	= ".$UserUni.",
				stat_type	= 1,
				tech_rank	= ".($CONF['users_amount'] + 1).",
				build_rank	= ".($CONF['users_amount'] + 1).",
				defs_rank	= ".($CONF['users_amount'] + 1).",
				fleet_rank	= ".($CONF['users_amount'] + 1).",
				total_rank	= ".($CONF['users_amount'] + 1).";";
				$GLOBALS['DATABASE']->multi_query($SQL);
				
				$from 		= $LNG['welcome_message_from'];
				$Subject 	= $LNG['welcome_message_subject'];
				$message 	= sprintf($LNG['welcome_message_content'], $CONF['game_name']);
				SendSimpleMessage($userID, 1, TIMESTAMP, 1, $from, $Subject, $message);
				
				update_config(array('users_amount' => $CONF['users_amount'] + 1, 'LastSettedGalaxyPos' => $LastSettedGalaxyPos, 'LastSettedSystemPos' => $LastSettedSystemPos, 'LastSettedPlanetPos' => $LastSettedPlanetPos));
				
				if ($admin == 1) {
					echo sprintf($LNG['user_active'], $UserName);
				} else {
					$SESSION       	= new Session();
					$SESSION->CreateSession($userID, $UserName, $PlanetID, $UserUni);
					if($CONF['user_valid'] == 0 || $CONF['mail_active'] == 0) {
						echo json_encode(array('error' => false, 'message' => 'done'));
					} else {
						HTTP::redirectTo("game.php?page=overview");
					}
				}
			break;
			default:
				HTTP::redirectTo("index.php");
			break;
		}
		break;
	case 'rules' :
		$template->assign_vars(array(
			'contentbox'		=> true,
			'rules'				=> $LANG->getExtra('rules'),
		));
		$template->show('index_rules.tpl');
		break;
	case 'screens':
		$template->assign_vars(array(
			'contentbox'			=> true,
			'screenshots'           => $LNG['screenshots'],
		));
		$template->show('index_screens.tpl');
		break;
	case 'top100' :
		$top = $GLOBALS['DATABASE']->query("SELECT *, (
			SELECT DISTINCT
			GROUP_CONCAT(username SEPARATOR ' & ') as attacker
			FROM ".TOPKB_USERS." INNER JOIN ".USERS." ON uid = id AND role = 1
			WHERE ".TOPKB_USERS.".rid = ".TOPKB.".rid
		) as attacker,
		(
			SELECT DISTINCT
			GROUP_CONCAT(username SEPARATOR ' & ') as attacker
			FROM ".TOPKB_USERS." INNER JOIN ".USERS." ON uid = id AND role = 2
			WHERE ".TOPKB_USERS.".rid = ".TOPKB.".rid
		) as defender  
		FROM ".TOPKB." WHERE universe = '".$UNI."' ORDER BY units DESC LIMIT 100;");
		$TopKBList	= array();
		while($data = $GLOBALS['DATABASE']->fetch_array($top)) {
			$TopKBList[]	= array(
				'result'	=> $data['result'],
				'time'		=> _date($LNG['php_tdformat'], $data['time']),
				'units'		=> pretty_number($data['units']),
				'rid'		=> $data['rid'],
				'attacker'	=> $data['attacker'],
				'defender'	=> $data['defender'],
			);
		}
		
		$AvailableUnis[$CONF['uni']]	= $CONF['uni_name'].($CONF['game_disable'] == 0 ? $LNG['uni_closed'] : '');
		$Query	= $GLOBALS['DATABASE']->query("SELECT uni, game_disable, uni_name FROM ".CONFIG." WHERE uni != '".$UNI."' ORDER BY uni ASC;");
		while($Unis	= $GLOBALS['DATABASE']->fetch_array($Query)) {
			$AvailableUnis[$Unis['uni']]	= $Unis['uni_name'].($Unis['game_disable'] == 0 ? $LNG['uni_closed'] : '');
		}
		ksort($AvailableUnis);
			
		$template->assign_vars(array(	
			'contentbox'	=> true,
			'AvailableUnis'	=> $AvailableUnis,
			'ThisUni'		=> $UNI,
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
			
		$template->show('index_top100.tpl');
		break;
	case 'pranger' :
		$PrangerRAW 	= $GLOBALS['DATABASE']->query("SELECT * FROM ".BANNED." WHERE universe = '".$UNI."' ORDER BY id DESC;");
		$PrangerList	= array();
		while($u = $GLOBALS['DATABASE']->fetch_array($PrangerRAW))
		{
			$PrangerList[]	= array(
				'player'	=> $u['who'],
				'theme'		=> $u['theme'],
				'from'		=> _date($LNG['php_tdformat'], $u['time']),
				'to'		=> _date($LNG['php_tdformat'], $u['longer']),
				'admin'		=> $u['author'],
				'mail'		=> $u['email'],
				'info'		=> sprintf($LNG['bn_writemail'], $u['author']),
			);
		}
		
		$AvailableUnis[$CONF['uni']]	= $CONF['uni_name'].($CONF['game_disable'] == 0 ? $LNG['uni_closed'] : '');
		$Query	= $GLOBALS['DATABASE']->query("SELECT uni, game_disable, uni_name FROM ".CONFIG." WHERE uni != '".$UNI."' ORDER BY uni ASC;");
		while($Unis	= $GLOBALS['DATABASE']->fetch_array($Query)) {
			$AvailableUnis[$Unis['uni']]	= $Unis['uni_name'].($Unis['game_disable'] == 0 ? $LNG['uni_closed'] : '');
		}
		ksort($AvailableUnis);
		
		$template->assign_vars(array(
			'contentbox'				=> true,
			'AvailableUnis'				=> $AvailableUnis,
			'ThisUni'					=> $UNI,
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
		
		$template->show('index_pranger.tpl');
		break;
	case 'disclamer':
		$template->assign_vars(array(
			'contentbox'		=> true,
			'disclamer'			=> $LNG['disclamer'],
			'disclamer_name'	=> $LNG['disclamer_name'],
			'disclamer_adress'	=> $LNG['disclamer_adress'],
			'disclamer_tel'		=> $LNG['disclamer_tel'],
			'disclamer_email'	=> $LNG['disclamer_email'],
		));
		$template->show('index_disclamer.tpl');
		break;
	case 'news' :
		$NewsRAW	= $GLOBALS['DATABASE']->query ("SELECT date,title,text,user FROM ".NEWS." ORDER BY id DESC;");
		$NewsList	= array();
		while ($NewsRow = $GLOBALS['DATABASE']->fetch_array($NewsRAW)) {
			$NewsList[]	= array(
				'title' => $NewsRow['title'],
				'from' 	=> sprintf($LNG['news_from'], _date($LNG['php_tdformat'], $NewsRow['date']), $NewsRow['user']),
				'text' 	=> makebr($NewsRow['text']),
			);
		}
		$template->assign_vars(array(
			'contentbox'			=> true,
			'NewsList'				=> $NewsList,
			'news_overview'			=> $LNG['news_overview'],
			'news_does_not_exist'	=> $LNG['news_does_not_exist'],
		));
		
		$template->show('index_news.tpl');
	break;
	case 'extauth':
		$method			= HTTP::_GP('method', '');
		$method			= str_replace(array('_', '\\', '/', '.', "\0"), '', $method);
		
		if(!file_exists(ROOT_PATH.'includes/extauth/'.$method.'.php')) {
			HTTP::redirectTo('index.php');			
		}
		
		require(ROOT_PATH.'includes/extauth/'.$method.'.php');
		
		$methodClass	= ucwords($method).'Auth';
		$authObj		= new $methodClass;
		
		if(!$authObj->isVaild()) {
			HTTP::redirectTo('index.php?code=4');
		}
		
		if($mode == 'register') {
			$authObj->register();
		}
		
		$loginData	= $authObj->getLoginData();
		
		if(empty($loginData)) {
			HTTP::redirectTo('index.php?code=5');
		}
		
		$SESSION       	= new Session();
		$SESSION->CreateSession($loginData['id'], $loginData['username'], $loginData['id_planet'], $UNI, $loginData['authlevel'], $loginData['dpath']);
		HTTP::redirectTo("game.php");	
	break;
	case 'login':
		if (empty($_POST))
			HTTP::redirectTo("index.php");	
			
		$luser = HTTP::_GP('username', '', UTF8_SUPPORT);
		$lpass = HTTP::_GP('password', '', true);
		$login = $GLOBALS['DATABASE']->uniquequery("SELECT id, username, password, dpath, authlevel, id_planet, banaday FROM ".USERS." WHERE universe = ".$UNI." AND username = '".$GLOBALS['DATABASE']->sql_escape($luser)."';");
			
		if (isset($login)) {
			if($login['password'] != cryptPassword($lpass)) {
				// Fallback pre 1.7
				if($login['password'] == md5($lpass)) {
					$GLOBALS['DATABASE']->query("UPDATE ".USERS." SET password = '".cryptPassword($lpass)."' WHERE id = ".$login['id'].";");
				} else {
					HTTP::redirectTo('index.php?code=1');	
				}
			}
			
			if ($login['banaday'] <= TIMESTAMP) {
				$db->query("UPDATE " . USERS . " SET `banaday` = '0', `bana` = '0' WHERE `username` = '" . $login ['username'] . "';");
			}
			
			$SESSION       	= new Session();
			$SESSION->CreateSession($login['id'], $login['username'], $login['id_planet'], $UNI, $login['authlevel'], $login['dpath']);
			HTTP::redirectTo('game.php');	
		}
	case '':
		$AvailableUnis[$CONF['uni']]	= $CONF['uni_name'].($CONF['game_disable'] == 0 ? $LNG['uni_closed'] : '');
		$RegClosed	= array($CONF['uni'] => (int)$CONF['reg_closed']);
		$Query	= $GLOBALS['DATABASE']->query("SELECT uni, game_disable, uni_name, reg_closed FROM ".CONFIG." WHERE uni != '".$UNI."' ORDER BY uni ASC;");
		while($Unis	= $GLOBALS['DATABASE']->fetch_array($Query)) {
			$AvailableUnis[$Unis['uni']]	= $Unis['uni_name'].($Unis['game_disable'] == 0 ? $LNG['uni_closed'] : '');
			$RegClosed[$Unis['uni']]		= (int)$Unis['reg_closed'];
		}
		ksort($AvailableUnis);
		$Code	= HTTP::_GP('code', 0);
		if(!empty($Code)) {
			$template->assign_vars(array(
				'code'					=> $LNG['login_error_'.$Code],
			));
		}

		if($CONF['ref_active'] && isset($_REQUEST['ref']) && is_numeric($_REQUEST['ref'])) {
			$RefUser	= $GLOBALS['DATABASE']->countquery("SELECT universe FROM ".USERS." WHERE id = '".(int) $_REQUEST['ref']."';");
			if(isset($RefUser)) {
				$template->assign_vars(array(
					'ref_id'	=> (int) $_REQUEST['ref'],
					'ref_uni'	=> $RefUser,
				));
			}
		}
		
		$template->assign_vars(array(
			'contentbox'			=> false,
			'AvailableUnis'			=> $AvailableUnis,
			'ref_id'				=> ($CONF['ref_active'] == 1 && isset($_REQUEST['ref'])) ? (int) $_REQUEST['ref'] : 0,
			'RegClosedUnis'			=> json_encode($RegClosed),
			'welcome_to'			=> $LNG['welcome_to'],
			'uni_closed'			=> $LNG['uni_closed'],
			'server_description'	=> sprintf($LNG['server_description'], $CONF['game_name']),
			'server_infos'			=> $LNG['server_infos'],
			'login'					=> $LNG['login'],
			'login_info'			=> $LNG['login_info'],
			'accept_terms_cond'		=> $LNG['accept_terms_and_conditions'],
			'user'					=> $LNG['user'],
			'pass'					=> $LNG['pass'],
			'lostpassword'			=> $LNG['lostpassword'],
			'register_now'			=> $LNG['register_now'],
			'screenshots'			=> $LNG['screenshots'],
			'chose_a_uni'			=> $LNG['chose_a_uni'],
			'universe'				=> $LNG['universe'],
			'register'				=> $LNG['register'],
			'pass_2'				=> $LNG['pass2_reg'],
			'email'					=> $LNG['email_reg'],
			'email_2'				=> $LNG['email2_reg'],
			'planetname'			=> $LNG['planet_reg'],
			'language'				=> $LNG['lang_reg'],
			'captcha_reg'			=> $LNG['captcha_reg'],
		));
		$template->show('index_main.tpl');
	break;
	default:
		HTTP::redirectTo("index.php");
	break;
}
?>