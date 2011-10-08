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
 * @version 1.5 (2011-07-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */
 
if (isset($_GET['action']) && $_GET['action'] == 'keepalive')
{
	header('Content-Type: image/gif');
	exit("\x47\x49\x46\x38\x39\x61\x01\x00\x01\x00\x80\x00\x00\x00\x00\x00\x00\x00\x00\x21\xF9\x04\x01\x00\x00\x00\x00\x2C\x00\x00\x00\x00\x01\x00\x01\x00\x00\x02\x02\x44\x01\x00\x3B");
}

define('INSIDE', true );
define('LOGIN', true );

define('ROOT_PATH', str_replace('\\', '/',dirname(__FILE__)).'/');

if(!file_exists(ROOT_PATH.'includes/config.php')) {
	header('Location: install/index.php');
	exit;
}

require(ROOT_PATH . 'includes/common.php');
	
$template	= new template();
$template->cache = true;
$THEME->isHome();
$page = request_var('page', '');
$action = request_var('action', '');
$mode = request_var('mode', '');

switch ($page) {
	case 'lostpassword': 
		if($CONF['mail_active'] == 0)
			redirectTo("index.php");

		$Username = request_var('username', '');
		$Usermail = request_var('email', '');
		
		if(empty($Username) || empty($Usermail) || !ValidateAddress($Usermail)) {
			echo json_encode(array('message' => $LNG['lost_empty'], 'error' => true));
			exit;
		}
			
		$UserID 	= $db->countquery("SELECT `id` FROM ".USERS." WHERE `universe` = '".$UNI."' AND `username` = '".$Username."' AND (`email` = '".$db->sql_escape($Usermail)."' OR `email_2` = '".$db->sql_escape($Usermail)."');");
		
		if (!isset($UserID)) {
			echo json_encode(array('message' => $LNG['lost_not_exists'], 'error' => true));
			exit;
		} else {
			$NewPass		= uniqid();
			$MailRAW		= file_get_contents('./language/'.$LANG->getUser().'/email/email_lost_password.txt');
			$MailContent	= sprintf($MailRAW, $Usermail, $CONF['game_name'], $NewPass, "http://".$_SERVER['SERVER_NAME'].$_SERVER["PHP_SELF"]);			
		
			$Mail			= MailSend($Usermail, $Username, $LNG['mail_title'], $MailContent);
			$db->query("UPDATE ".USERS." SET `password` = '".md5($NewPass)."' WHERE `id` = '".$UserID."';");
			echo json_encode(array('message' => $LNG['mail_sended'], 'error' => false));
		}
	break;
	case 'reg' :
		switch ($action) {
			case 'check' :
				$value	= request_var('value', '', UTF8_SUPPORT);
				switch($mode) {
					case 'username' :
						$Count 	= $db->countquery("SELECT (SELECT COUNT(*) FROM ".USERS." WHERE `universe` = '".$UNI."' AND `username` = '".$db->sql_escape($value)."') + (SELECT COUNT(*) FROM ".USERS_VALID." WHERE `universe` = '".$Universe."' AND `username` = '".$db->sql_escape($value)."')");
					break;
					case 'email' :
						$Count 	= $db->countquery("SELECT (SELECT COUNT(*) FROM ".USERS." WHERE `universe` = '".$UNI."' AND (`email` = '".$db->sql_escape($value)."' OR `email_2` = '".$db->sql_escape($value)."')) + (SELECT COUNT(*) FROM ".USERS_VALID." WHERE `universe` = '".$Universe."' AND `email` = '".$db->sql_escape($value)."')");
					break;
					case 'fbid' :
						$Count 	= $db->countquery("SELECT COUNT(*) FROM ".USERS." WHERE `universe` = '".$UNI."' AND `fb_id` = '".$db->sql_escape($value)."';");
					break;
					case 'ref' :
						$Count 	= $db->countquery("SELECT `universe` FROM ".USERS." WHERE `id` = '".$db->sql_escape($value)."';");
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
					
				$UserName 	= request_var('username', '', UTF8_SUPPORT);
				$UserPass 	= request_var('password', '');
				$UserPass2 	= request_var('password_2', '');
				$UserEmail 	= request_var('email', '');
				$UserEmail2	= request_var('email_2', '');
				$agbrules 	= request_var('rgt', '');
				$UserPlanet	= request_var('planetname', '', UTF8_SUPPORT);
				$UserLang 	= request_var('lang', '');
				$FACEBOOK 	= request_var('fb_id', 0);
				$RefID	 	= request_var('ref_id', 0);
	
				$errors 	= array();
				
				if ($CONF['capaktiv'] === '1') {
					require_once('includes/libs/reCAPTCHA/recaptchalib.php');
					$resp = recaptcha_check_answer($CONF['capprivate'], $_SERVER['REMOTE_ADDR'], $_REQUEST['recaptcha_challenge_field'], $_REQUEST['recaptcha_response_field']);
					if (!$resp->is_valid)
						$errors[]	= array('captcha', $LNG['wrong_captcha']);
				}
				
				$ExistsUser 	= $db->countquery("SELECT (SELECT COUNT(*) FROM ".USERS." WHERE `universe` = '".$UNI."' AND `username` = '".$db->sql_escape($UserName)."') + (SELECT COUNT(*) FROM ".USERS_VALID." WHERE `universe` = '".$UNI."' AND `username` = '".$db->sql_escape($UserName)."')");
				$ExistsMails	= $db->countquery("SELECT (SELECT COUNT(*) FROM ".USERS." WHERE `universe` = '".$UNI."' AND (`email` = '".$db->sql_escape($value)."' OR `email_2` = '".$db->sql_escape($value)."')) + (SELECT COUNT(*) FROM ".USERS_VALID." WHERE `universe` = '".$UNI."' AND `email` = '".$db->sql_escape($value)."')");
				
				if(empty($UserName))
					$errors[]	= array('username', $LNG['empty_user_field']);
	
				if(!CheckName($UserName))
					$errors[]	= array('username', UTF8_SUPPORT ? $LNG['user_field_no_space'] : $LNG['user_field_no_alphanumeric']);

				if($ExistsUser != 0)
					$errors[]	= array('username', $LNG['user_already_exists']);
					
				if(!isset($UserPass{5}))
					$errors[]	= array('password', $LNG['password_lenght_error']);
					
				if($UserPass != $UserPass2)
					$errors[]	= array('password_2', $LNG['different_passwords']);
					
				if($ExistsMails != 0)
					$errors[]	= array('email', $LNG['mail_already_exists']);
					
				if(!ValidateAddress($UserEmail))
					$errors[]	= array('email', $LNG['invalid_mail_adress']);
					
				if($UserEmail != $UserEmail2)
					$errors[]	= array('email_2', $LNG['different_mails']);
					
				if(empty($UserPlanet))
					$errors[]	= array('planetname', $LNG['planet_field_no']);
				
				if(!CheckName($UserPlanet))
					$errors[]	= array('planetname', UTF8_SUPPORT ? $LNG['planet_field_no_space'] : $LNG['planet_field_no_alphanumeric']);	

				if($agbrules != 'on')
					$errors[]	= array('rgt', $LNG['terms_and_conditions']);
								
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
					$Count	= $db->countquery("SELECT COUNT(*) FROM ".USERS." WHERE `id` = '".$RefID."';");
					if($Count == 0)
						$RefID	= 0;
				} else {
					$RefID	= 0;
				}
				
				
				$clef		= uniqid('2m');
				$SQL = "INSERT INTO ".USERS_VALID." SET ";
				$SQL .= "`username` = '".$db->sql_escape($UserName)."', ";
				$SQL .= "`email` = '".$db->sql_escape($UserEmail)."', ";
				$SQL .= "`lang` = '".$db->sql_escape($UserLang)."', ";
				$SQL .= "`planet` = '".$db->sql_escape($UserPlanet)."', ";
				$SQL .= "`date` = '".TIMESTAMP."', ";
				$SQL .= "`cle` = '".$clef."', ";
				$SQL .= "`universe` = '".$UNI."', ";
				$SQL .= "`password` = '".md5($UserPass)."', ";
				$SQL .= "`ip` = '".$_SERVER['REMOTE_ADDR']."', ";
				$SQL .= "`ref_id` = '".$RefID."', ";
				$SQL .= "`fb_id` = '".$FACEBOOK."'; ";
				$db->query($SQL);
				
				if(!empty($FACEBOOK) || $CONF['user_valid'] == 0 || $CONF['mail_active'] == 0) {
					redirectTo("index.php?uni=".$UNI."&page=reg&action=valid&clef=".$clef);
				} else {
					$MailSubject 	= $LNG['reg_mail_message_pass'];
					$MailRAW		= file_get_contents("./language/".$UserLang."/email/email_vaild_reg.txt");
					$MailContent	= sprintf($MailRAW, $UserName, $CONF['game_name'].' - '.$CONF['uni_name'], "http://".$_SERVER['SERVER_NAME'].$_SERVER["PHP_SELF"], $clef, $UserPass, $CONF['smtp_sendmail'], $UNI);
			
					MailSend($UserEmail, $UserName, $MailSubject, $MailContent);
					
					echo json_encode(array('error' => false, 'message' => $LNG['reg_completed']));
				}								
			break;
			case 'valid' :
				$clef 		= request_var('clef', '');
				$admin 	 	= request_var('admin', 0);
				$Valider	= $db->uniquequery("SELECT * FROM ".USERS_VALID." WHERE `cle` = '".$db->sql_escape($clef)."' AND `universe` = '".$UNI."';");
				
				if(!isset($Valider)) 
					redirectTo('index.php');
				
				$UserName 	= $Valider['username'];
				$UserPass 	= $Valider['password'];
				$UserMail 	= $Valider['email'];
				$UserIP 	= $Valider['ip'];
				$UserPlanet	= $Valider['planet'];
				$UserLang 	= $Valider['lang'];
				$UserUni 	= $Valider['universe'];
				$UserFID 	= $Valider['fb_id'];
				$UserRID 	= $Valider['ref_id'];
				
				if($CONF['mail_active'] == 1) {
					$MailSubject	= sprintf($LNG['reg_mail_reg_done'], $CONF['game_name']);	
					$MailRAW		= file_get_contents("./language/".$UserLang."/email/email_reg_done.txt");
					$MailContent	= sprintf($MailRAW, $UserName, $CONF['game_name'].' - '.$CONF['uni_name']);	
					MailSend($UserMail, $UserName, $MailSubject, $MailContent);
				}
				
				$SQL = "INSERT INTO ".USERS." SET ";
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
				$SQL .= "`dpath` = '".DEFAULT_THEME."', ";
				$SQL .= "`darkmatter` = '".$CONF['darkmatter_start']."', ";
				$SQL .= "`ref_id` = '".$UserRID."', ";
				$SQL .= "`timezone` = '".$CONF['timezone']."', ";
				if($UserRID != 0)
					$SQL .= "`ref_bonus` = '1', ";
				$SQL .= "`fb_id` = '".$UserFID."', ";
				$SQL .= "`uctime`= '0';";
				$db->query($SQL);
				
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
						if ($LastSettedSystemPos > $CONF['max_system']) {
							$LastSettedGalaxyPos += 1;
							$LastSettedSystemPos = 1;
							$LastSettedPlanetPos = 1;
						} else {
							$LastSettedSystemPos += 1;
							$LastSettedPlanetPos = 1;
						}
						
						if($LastSettedGalaxyPos  > $CONF['max_system'])
							$LastSettedGalaxyPos	= 1;
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
				$SQL .= "INSERT INTO ".STATPOINTS." (`id_owner`, `id_ally`, `stat_type`, `universe`, `tech_rank`, `tech_old_rank`, `tech_points`, `tech_count`, `build_rank`, `build_old_rank`, `build_points`, `build_count`, `defs_rank`, `defs_old_rank`, `defs_points`, `defs_count`, `fleet_rank`, `fleet_old_rank`, `fleet_points`, `fleet_count`, `total_rank`, `total_old_rank`, `total_points`, `total_count`) VALUES ";
				$SQL .= "(".$NewUser.", 0, 1, ".$UserUni.", '".($CONF['users_amount'] + 1)."', '".($CONF['users_amount'] + 1)."', 0, 0, '".($CONF['users_amount'] + 1)."', '".($CONF['users_amount'] + 1)."', 0, 0, '".($CONF['users_amount'] + 1)."', '".($CONF['users_amount'] + 1)."', 0, 0, '".($CONF['users_amount'] + 1)."', '".($CONF['users_amount'] + 1)."', 0, 0, '".($CONF['users_amount'] + 1)."', '".($CONF['users_amount'] + 1)."', 0, 0);";
				$db->multi_query($SQL);
				
				$from 		= $LNG['welcome_message_from'];
				$Subject 	= $LNG['welcome_message_subject'];
				$message 	= sprintf($LNG['welcome_message_content'], $CONF['game_name']);
				SendSimpleMessage($NewUser, 1, $Time, 1, $from, $Subject, $message);
				
				update_config(array('users_amount' => $CONF['users_amount'] + 1, 'LastSettedGalaxyPos' => $LastSettedGalaxyPos, 'LastSettedSystemPos' => $LastSettedSystemPos, 'LastSettedPlanetPos' => $LastSettedPlanetPos));
				if ($admin == 1) {
					echo sprintf($LNG['user_active'], $UserName);
				} else {
					session_start();
					$SESSION       	= new Session();
					$SESSION->CreateSession($NewUser, $UserName, $PlanetID, $UserUni);
					if($CONF['user_valid'] == 0 || $CONF['mail_active'] == 0)
						echo json_encode(array('error' => false, 'message' => 'done'));
					else
						redirectTo("game.php?page=overview");
				}
			break;
			default:
				redirectTo("index.php");
			break;
		}
		break;
	case 'agb' :
		$template->assign_vars(array(
			'contentbox'		=> true,
			'agb'				=> $LNG['agb'],
			'agb_overview'		=> $LNG['agb_overview'],
		));
		$template->show('index_agb.tpl');
		break;
	case 'rules' :
		$template->assign_vars(array(
			'contentbox'		=> true,
			'rules'				=> $LNG['rules'],
			'rules_overview'	=> $LNG['rules_overview'],
			'rules_info1'		=> sprintf($LNG['rules_info1'], $CONF['forum_url']),
			'rules_info2'		=> $LNG['rules_info2'],
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
		$top = $db->query("SELECT * FROM ".TOPKB." WHERE `universe` = '".$UNI."' ORDER BY units DESC LIMIT 100;");
		$TopKBList	= array();
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
		
		$AvailableUnis[$CONF['uni']]	= $CONF['uni_name'].($CONF['game_disable'] == 0 ? $LNG['uni_closed'] : '');
		$Query	= $db->query("SELECT `uni`, `game_disable`, `uni_name` FROM ".CONFIG." WHERE `uni` != '".$UNI."' ORDER BY `uni` ASC;");
		while($Unis	= $db->fetch_array($Query)) {
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
		$PrangerRAW 	= $db->query("SELECT * FROM ".BANNED." WHERE `universe` = '".$UNI."' ORDER BY `id`;");
		$PrangerList	= array();
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
		
		$AvailableUnis[$CONF['uni']]	= $CONF['uni_name'].($CONF['game_disable'] == 0 ? $LNG['uni_closed'] : '');
		$Query	= $db->query("SELECT `uni`, `game_disable`, `uni_name` FROM ".CONFIG." WHERE `uni` != '".$UNI."' ORDER BY `uni` ASC;");
		while($Unis	= $db->fetch_array($Query)) {
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
		$NewsRAW	= $db->query ("SELECT date,title,text,user FROM ".NEWS." ORDER BY id DESC;");
		$NewsList	= array();
		while ($NewsRow = $db->fetch_array($NewsRAW)) {
			$NewsList[]	= array(
				'title' => $NewsRow['title'],
				'from' 	=> sprintf($LNG['news_from'], date("d. M Y H:i:s", $NewsRow['date']), $NewsRow['user']),
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
	case 'fblogin':
		if($CONF['fb_on'] == 0)
			redirectTo("index.php");
		
		require(ROOT_PATH.'/includes/libs/facebook/facebook.php');
		$facebook = new Facebook(array(
			'appId'  => $CONF['fb_apikey'],
			'secret' => $CONF['fb_skey'],
			'cookie' => true,
		));	

		$uid = $facebook->getUser();
		
		if(!isset($uid))
			redirectTo("index.php");			
			
		if($mode == 'register') {
			$me = $facebook->api('/me');
			
			$ValidReg	= $db->countquery("SELECT `cle` FROM ".USERS_VALID." WHERE `universe` = '".$UNI."' AND `email` = '".$db->sql_escape($me['email'])."';");
			if(!empty($ValidReg))
				redirectTo("index.php?uni=".$UNI."&page=reg&action=valid&clef=".$ValidReg);
								
			$db->query("UPDATE ".USERS." SET `fb_id` = '".$uid."' WHERE `email` = '".$db->sql_escape($me['email'])."' OR `email_2` = '".$db->sql_escape($me['email'])."';");
		}
		
		$login = $db->uniquequery("SELECT `id`, `username`, `dpath`, `authlevel`, `id_planet` FROM ".USERS." WHERE `universe` = '".$UNI."' AND `fb_id` = '".$uid."';");
		session_start();
		$SESSION       	= new Session();
		$SESSION->CreateSession($login['id'], $login['username'], $login['id_planet'], $UNI, $login['authlevel'], $login['dpath']);
		redirectTo("game.php");	
	break;
	case 'login':
		if (empty($_POST))
			redirectTo("index.php");	
			
		$luser = request_var('username', '', UTF8_SUPPORT);
		$lpass = request_var('password', '', UTF8_SUPPORT);
		$login = $db->uniquequery("SELECT `id`, `username`, `dpath`, `authlevel`, `id_planet` FROM ".USERS." WHERE `universe` = '".$UNI."' AND `username` = '".$db->sql_escape($luser)."' AND `password` = '".md5($lpass)."';");
			
		if (isset($login)) {
			session_start();
			$SESSION       	= new Session();
			$SESSION->CreateSession($login['id'], $login['username'], $login['id_planet'], $UNI, $login['authlevel'], $login['dpath']);
			redirectTo('game.php');	
		} else {
			redirectTo('index.php?code=1');	
		}
	case '':
		$AvailableUnis[$CONF['uni']]	= $CONF['uni_name'].($CONF['game_disable'] == 0 ? $LNG['uni_closed'] : '');
		$RegClosed	= array($CONF['uni'] => (int)$CONF['reg_closed']);
		$Query	= $db->query("SELECT `uni`, `game_disable`, `uni_name`, `reg_closed` FROM ".CONFIG." WHERE `uni` != '".$UNI."' ORDER BY `uni` ASC;");
		while($Unis	= $db->fetch_array($Query)) {
			$AvailableUnis[$Unis['uni']]	= $Unis['uni_name'].($Unis['game_disable'] == 0 ? $LNG['uni_closed'] : '');
			$RegClosed[$Unis['uni']]		= (int)$Unis['reg_closed'];
		}
		ksort($AvailableUnis);
		$Code	= request_var('code', 0);
		if(!empty($Code)) {
			$template->assign_vars(array(
				'code'					=> $LNG['login_error_'.$Code],
			));
		}

		if($CONF['ref_active'] && isset($_REQUEST['ref']) && is_numeric($_REQUEST['ref'])) {
			$RefUser	= $db->countquery("SELECT `universe` FROM ".USERS." WHERE `id` = '".(int) $_REQUEST['ref']."';");
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
		redirectTo("index.php");
	break;
}
?>