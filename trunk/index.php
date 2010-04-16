<?php

##############################################################################
# *                                                                          #
# * 2MOONS                                                                   #
# *                                                                          #
# * @copyright Copyright (C) 2010 By ShadoX from titanspace.de               #
# *                                                                          #
# *	                                                                         #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.                                     #
# *	                                                                         #
# *  This program is distributed in the hope that it will be useful,         #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of          #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           #
# *  GNU General Public License for more details.                            #
# *                                                                          #
##############################################################################

define('INSIDE', true );
define('INSTALL', false );
define('LOGIN', true );

$InLogin = true;

define('ROOT_PATH'	,'./');

include_once(ROOT_PATH . 'extension.inc');
include_once(ROOT_PATH . 'common.' . PHP_EXT);

includeLang ('PUBLIC');

// Uniconfig changed...
include_once(ROOT_PATH . 'includes/uni.config.inc.php');

$template	= new template();
$template->set_index();

$page = request_var('page', '');
$mode = request_var('mode', '');

switch ($page) {
	case 'facebook':
		if($game_config['fb_on'] == 0)
			exit(header("Location: index.php"));
			
		include_once(ROOT_PATH . 'includes/libs/facebook/facebook.php');
		$fb = new Facebook($game_config['fb_apikey'], $game_config['fb_skey']);
		$fb_user = $fb->get_loggedin_user();

		if($fb_user)
		{
			$login = $db->fetch_array($db->query("SELECT `id`,`username`,`password`,`banaday` FROM " . USERS . " WHERE `fb_id` = '".$fb_user."';"));
			if (isset($login)) {
				if ($login['banaday'] <= time () && $login['banaday'] != '0') {
					$db->query("UPDATE " . USERS . " SET `banaday` = '0', `bana` = '0' WHERE `username` = '" . $login ['username'] . "';");
				}
			
				$expiretime = 0;
				$rememberme = 0;
							
				$cookie = $login ["id"] . "/%/" . $login ["username"] . "/%/" . md5($login["password"]. "--" . $dbsettings ["secretword"]) . "/%/" . $rememberme;
				setcookie($game_config['COOKIE_NAME'], $cookie, $expiretime, "/", "", 0);
				
				$db->query ( "UPDATE `" . USERS . "` SET `current_planet` = `id_planet` WHERE `id` ='" . $login ["id"] . "';" );

				header("Location: ./game.php?page=overview");
				exit();
			} else {
				$user_details = $fb->api_client->users_getInfo($fb_user, array('first_name','last_name','proxied_email','username','contact_email'));  
				if(!empty($user_details[0]['contact_email']) && ValidateAddress($user_details[0]['contact_email'])) 
					$UserMail 	=  $user_details[0]['contact_email'];
				else 
					exit(header("Location: index.php"));
				
				$Exist['alruser'] = $db->fetch_array($db->query("SELECT id,username,password FROM ".USERS." WHERE `email` = '".$UserMail."';"));
				if(isset($Exist['alruser']))
				{
					$db->query("UPDATE `".USERS."` SET `fb_id` = '".$fb_user."' WHERE `id` ='".$Exist['alruser']['id']."';");
					$cookie = $Exist['alruser']['id']."/%/".$Exist['alruser']['username']."/%/".md5($Exist['alruser']['password']."--".$dbsettings["secretword"])."/%/0";
					setcookie($game_config['COOKIE_NAME'], $cookie, 0, "/", "", 0);
					exit(header("Location: ./game.php?page=overview"));
				}
				
				$Caracters = "aazertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN1234567890";
				$Count = strlen($Caracters);
				$Taille = 8;
				$NewPass = "";
				for($i = 0; $i < $Taille; $i ++) {
					$CaracterBoucle = rand ( 0, $Count - 1 );
					$NewPass .= substr ( $Caracters, $CaracterBoucle, 1 );
				}
				
				$UserName 		= $db->sql_escape($user_details[0]['first_name']." ".$user_details[0]['last_name']);
				$UserIP 		= $_SERVER["REMOTE_ADDR"];				
				$UserPass		= md5($NewPass);
				$IfNameExist	= false;
				$i				= "(1)";
				
				while(!$IfNameExist)
				{
					$Exist['userv'] = $db->fetch_array($db->query("SELECT username FROM ".USERS." WHERE username = '".$UserName."';"));
					$Exist['vaild'] = $db->fetch_array($db->query("SELECT username FROM ".USERS_VALID." WHERE username = '".$UserName."';"));
					if(!isset($Exist['userv']) && !isset($Exist['vaild']))
						$IfNameExist	= true;
					else
						$UserName		= $i.$UserName;
				}
				
				$QryInsertUser = "INSERT INTO ".USERS." SET ";
				$QryInsertUser .= "`username` = '" . $UserName . "', ";
				$QryInsertUser .= "`email` = '" . $UserMail . "', ";
				$QryInsertUser .= "`email_2` = '" . $UserMail . "', ";
				$QryInsertUser .= "`ip_at_reg` = '" . $UserIP . "', ";
				$QryInsertUser .= "`id_planet` = '0', ";
				$QryInsertUser .= "`onlinetime` = '" . time () . "', ";
				$QryInsertUser .= "`register_time` = '" . time () . "', ";
				$QryInsertUser .= "`password` = '" . $UserPass . "', ";
				$QryInsertUser .= "`dpath` = '" . DEFAULT_SKINPATH . "', ";
				$QryInsertUser .= "`fb_id` = '" . $fb_user . "', ";
				$QryInsertUser .= "`uctime`= '0';";
				$db->query($QryInsertUser);
			
				if($game_config['smtp_host'] != '' && $game_config['smtp_port'] != 0 && $game_config['smtp_user'] != '' && $game_config['smtp_pass'] != '')
				{				
					$MailSubject	= sprintf($lang['reg_mail_reg_done'], $game_config['game_name']);	
					$MailRAW		= file_get_contents("./language/".$game_config['lang']."/email/email_reg_done.txt");
					$MailContent	= sprintf($MailRAW, $UserName, $game_config['game_name']);	
					MailSend($UserMail, $UserName, $MailSubject, $MailContent);
					$MailRAW		= file_get_contents("./language/".$game_config['lang']."/email/email_lost_password.txt");
					$MailContent	= sprintf($MailRAW, $ExistMail['username'], $game_config['game_name'], $NewPass, "http://".$_SERVER['SERVER_NAME'].$_SERVER["PHP_SELF"]);			
					MailSend($UserMail, $UserName, $lang['mail_title'], $MailContent);		
				}
				
				$NewUser = $db->fetch_array ( $db->query ( "SELECT `id` FROM " . USERS . " WHERE `username` = '".$UserName."' AND `password` = '".$UserPass."';" ) );
				
				$LastSettedGalaxyPos = $game_config['LastSettedGalaxyPos'];
				$LastSettedSystemPos = $game_config['LastSettedSystemPos'];
				$LastSettedPlanetPos = $game_config['LastSettedPlanetPos'];
				
				while (!isset($newpos_checked)) {
					for($Galaxy = $LastSettedGalaxyPos; $Galaxy <= MAX_GALAXY_IN_WORLD; $Galaxy ++) {
						for($System = $LastSettedSystemPos; $System <= MAX_SYSTEM_IN_GALAXY; $System ++) {
							for($Posit = $LastSettedPlanetPos; $Posit <= 4; $Posit ++) {
								$Planet = round ( rand ( 4, 12 ) );
								
								switch ($LastSettedPlanetPos) {
									case 1 :
										$LastSettedPlanetPos += 1;
										break;
									case 2 :
										$LastSettedPlanetPos += 1;
										break;
									case 3 :
										if ($LastSettedSystemPos == MAX_SYSTEM_IN_GALAXY) {
											$LastSettedGalaxyPos += 1;
											$LastSettedSystemPos = 1;
											$LastSettedPlanetPos = 1;
											break;
										} else {
											$LastSettedPlanetPos = 1;
										}
										
										$LastSettedSystemPos += 1;
										break;
								}
								break;
							}
							break;
						}
						break;
					}
					
					if (!CheckPlanetIfExist($Galaxy, $System, $Planet))
					{
						CreateOnePlanetRecord ($Galaxy, $System, $Planet, $NewUser['id'], $UserPlanet, true);
						$QryInsertConfig  = "UPDATE " . CONFIG . " SET `config_value` = '" . $LastSettedGalaxyPos . "' WHERE `config_name` = 'LastSettedGalaxyPos';";
						$QryInsertConfig .= "UPDATE " . CONFIG . " SET `config_value` = '" . $LastSettedSystemPos . "' WHERE `config_name` = 'LastSettedSystemPos';";
						$QryInsertConfig .= "UPDATE " . CONFIG . " SET `config_value` = '" . $LastSettedPlanetPos . "' WHERE `config_name` = 'LastSettedPlanetPos';";
						$db->multi_query($QryInsertConfig);
						$newpos_checked = true;
					}
				}
				$PlanetID = $db->fetch_array($db->query("SELECT `id` FROM ".PLANETS." WHERE `id_owner` = '".$NewUser ['id']."';" ));
				
				$QryUpdateUser = "UPDATE " . USERS . " SET ";
				$QryUpdateUser .= "`id_planet` = '" . $PlanetID ['id'] . "', ";
				$QryUpdateUser .= "`current_planet` = '" . $PlanetID ['id'] . "', ";
				$QryUpdateUser .= "`galaxy` = '" . $Galaxy . "', ";
				$QryUpdateUser .= "`system` = '" . $System . "', ";
				$QryUpdateUser .= "`planet` = '" . $Planet . "' ";
				$QryUpdateUser .= "WHERE ";
				$QryUpdateUser .= "`id` = '" . $NewUser ['id'] . "' ";
				$QryUpdateUser .= "LIMIT 1;";
				$QryUpdateUser .= "INSERT INTO ".STATPOINTS." (`id_owner`, `id_ally`, `stat_type`, `stat_code`, `tech_rank`, `tech_old_rank`, `tech_points`, `tech_count`, `build_rank`, `build_old_rank`, `build_points`, `build_count`, `defs_rank`, `defs_old_rank`, `defs_points`, `defs_count`, `fleet_rank`, `fleet_old_rank`, `fleet_points`, `fleet_count`, `total_rank`, `total_old_rank`, `total_points`, `total_count`, `stat_date`) VALUES (".$NewUser['id'].", 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ".time().");";
				$db->multi_query ( $QryUpdateUser );
				
				$from 		= $lang ['welcome_message_from'];
				$sender 	= $lang ['welcome_message_sender'];
				$Subject 	= $lang ['welcome_message_subject'];
				$message 	= sprintf($lang['welcome_message_content'], $game_config['game_name']);
				SendSimpleMessage ( $NewUser ['id'], $sender, $Time, 1, $from, $Subject, $message );
				
				$db->query ( "UPDATE " . CONFIG . " SET `config_value` = `config_value` + '1' WHERE `config_name` = 'users_amount';" );
				if ($admin == 1) {
					echo "User ".$UserName." wurde aktiviert!";
				} else {
					include_once('config.php');
					$cookie = $NewUser ['id'] . "/%/" . $UserName . "/%/" . md5 ( $UserPass . "--" . $dbsettings ["secretword"] ) . "/%/" . 0;
					setcookie( $game_config ['COOKIE_NAME'], $cookie, 0, "/", "", 0 );
					
					unset($dbsettings);
					
					header("location:game.php?page=overview");
				
				}
			}
		} else {
			header("Location: index.php");
		}
	break;
	case 'lostpassword': 
		$usermail = request_var ( 'email', '' );
		if ($mode == "send") {
			$ExistMail = $db->fetch_array ( $db->query ( "SELECT `username` FROM " . USERS . " WHERE `email` = '" . $db->sql_escape($usermail) . "' LIMIT 1;" ) );
			if (empty($ExistMail['username'])) {
				message($lang['mail_not_exist'], "index.php?page=lostpassword", 3, false, false );
			} else {
				$Caracters = "aazertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN1234567890";
				$Count = strlen($Caracters);
				$Taille = 8;
				$NewPass = "";
				for($i = 0; $i < $Taille; $i ++) {
					$CaracterBoucle = rand ( 0, $Count - 1 );
					$NewPass .= substr ( $Caracters, $CaracterBoucle, 1 );
				}

				$MailRAW		= file_get_contents("./language/".$game_config['lang']."/email/email_lost_password.txt");
				$MailContent	= sprintf($MailRAW, $ExistMail['username'], $game_config['game_name'], $NewPass, "http://".$_SERVER['SERVER_NAME'].$_SERVER["PHP_SELF"]);			
			
				if($game_config['smtp_host'] == '' || $game_config['smtp_port'] == '' || $game_config['smtp_user'] == '' || $game_config['smtp_pass'] == '')
					message($lang["mail_sended_fail"], "./", 2, false, false );
				
				if(MailSend($usermail, $ExistMail['username'], $lang['mail_title'], $MailContent));
					$db->query("UPDATE ".USERS." SET `password` ='" . md5($NewPass) . "' WHERE `username` = '".$ExistMail['username']."';");
			}
		} else {
			$template->assign_vars(array(
				'email'			=> $lang['email'],
				'uni_reg'		=> $lang['uni_reg'],
				'send'			=> $lang['send'],
				'AvailableUnis'	=> $AvailableUnis,
				'chose_a_uni'	=> $lang['chose_a_uni'],
			));
			$template->display('public/lostpassword.tpl');
		}
		break;
	case 'reg' :
		
		if ($game_config['reg_closed'] == 1){
			$template->assign_vars(array(
				'closed'	=> $lang['reg_closed'],
				'info'		=> $lang['info'],
			));
			$template->display('public/registry_closed.tpl');
			exit;
		}
		switch ($mode) {
			case 'send' :
			
				$errors = "";
				
				$UserPass 	= request_var ('password', '');
				$UserPass2 	= request_var ('password2', '');
				$UserName 	= trim(request_var('character', '', UTF8_SUPPORT));
				$UserEmail 	= trim(request_var('email', ''));
				$UserEmail2	= trim(request_var('email2', ''));
				$agbrules 	= request_var ('rgt', '');
				$Exist['userv'] = $db->fetch_array($db->query("SELECT username, email FROM ".USERS." WHERE username = '".$db->sql_escape($UserName)."' OR email = '".$db->sql_escape($UserEmail)."';"));
				$Exist['vaild'] = $db->fetch_array($db->query("SELECT username, email FROM ".USERS_VALID." WHERE username = '".$db->sql_escape($UserName)."' OR email = '".$db->sql_escape($UserEmail)."';"));
				
				if ($game_config ['capaktiv'] === '1') {
					require_once ('includes/libs/reCAPTCHA/recaptchalib.php');
					$resp = recaptcha_check_answer($game_config['capprivate'], $_SERVER ["REMOTE_ADDR"], request_var ( 'recaptcha_challenge_field', '' ), request_var ( 'recaptcha_response_field', '' ) );
					if (!$resp->is_valid)
						$errorlist .= $lang['wrong_captcha'];
				}
				
				if (!ValidateAddress($UserEmail)) 
					$errors .= $lang['invalid_mail_adress'];
				
				if (!$UserName) 
					$errors .= $lang['empty_user_field'];
				
				if (strlen($UserPass) < 6)
					$errors .= $lang['password_lenght_error'];
				
				if ($UserPass != $UserPass2)
					$errors .= $lang['different_passwords'];				
				
				if ($UserEmail != $UserEmail2)
					$errors .= $lang['different_mails'];
				
				if (!CheckName($UserName))
					$errors .= (UTF8_SUPPORT) ? $lang['user_field_no_space'] : $lang['user_field_no_alphanumeric'];			
				
				if ($agbrules != 'on')
					$errors .= $lang['terms_and_conditions'];

				if ((isset($Exist['userv']['username']) || isset($Exist['vaild']['username']) && ($UserName == $Exist['userv']['username'] || $UserName == $Exist['vaild']['username'])))
					$errors .= $lang['user_already_exists'];

				if ((isset($Exist['userv']['email']) || isset($Exist['vaild']['email'])) && ($UserEmail == $Exist['userv']['email'] || $UserEmail == $Exist['vaild']['email']))
					$errors .= $lang['mail_already_exists'];
				
				if (!empty($errors)) {
					message($errors, "index.php?page=reg", "3", false, false );
				} else {
					$md5newpass = md5($UserPass);
					
					$characters = array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z" );
					$size = 15;
					for($i = 0; $i < $size; $i ++) {
						$clef .= ($i % 2) ? strtoupper ( $characters [array_rand ( $characters )] ) : $characters [array_rand ( $characters )];
					}

					if($game_config['user_valid'] == 0 || $game_config['smtp_host'] == '' || $game_config['smtp_port'] == 0 || $game_config['smtp_user'] == '' || $game_config['smtp_pass'] == '')
					{
						$QryInsertUser = "INSERT INTO " . USERS_VALID . " SET ";
						$QryInsertUser .= "`username` = '" . $db->sql_escape ( $UserName ) . "', ";
						$QryInsertUser .= "`email` = '" . $db->sql_escape ( $UserEmail ) . "', ";
						$QryInsertUser .= "`date` = '" . time () . "', ";
						$QryInsertUser .= "`cle` = '" . $clef . "', ";
						$QryInsertUser .= "`password`='" . $md5newpass . "', ";
						$QryInsertUser .= "`ip` = '" . $_SERVER ["REMOTE_ADDR"] . "'; ";
						$db->query($QryInsertUser);
						
						exit(header("Location: index.php?page=reg&mode=valid&id=".$md5newpass."&clef=" . $clef));
					}					

					$MailSubject 	= $lang['reg_mail_message_pass'];
					$MailRAW		= file_get_contents("./language/".$game_config['lang']."/email/email_vaild_reg.txt");
					$MailContent	= sprintf($MailRAW, $UserName, $game_config['game_name'], "http://".$_SERVER['SERVER_NAME'].$_SERVER["PHP_SELF"], $clef, $UserPass, ADMINEMAIL, $md5newpass);
		
					MailSend($UserEmail, $UserName, $MailSubject, $MailContent);
					$QryInsertUser = "INSERT INTO " . USERS_VALID . " SET ";
					$QryInsertUser .= "`username` = '" . $db->sql_escape ( $UserName ) . "', ";
					$QryInsertUser .= "`email` = '" . $db->sql_escape ( $UserEmail ) . "', ";
					$QryInsertUser .= "`date` = '" . time () . "', ";
					$QryInsertUser .= "`cle` = '" . $clef . "', ";
					$QryInsertUser .= "`password`='" . $md5newpass . "', ";
					$QryInsertUser .= "`ip` = '" . $_SERVER ["REMOTE_ADDR"] . "'; ";
					$db->query ($QryInsertUser);
					message($lang['reg_completed'], "./", 10, false, false );
				}
			break;
			case 'valid' :		
				$pseudo 	 = request_var('id', '');
				$clef 		 = request_var('clef', '');
				$admin 	 	 = request_var('admin', 0);
				$Valider	 = $db->fetch_array($db->query("SELECT `username`, `password`, `email`, `ip` FROM ".USERS_VALID." WHERE `cle` = '".$db->sql_escape($clef)."' AND `password` = '".$db->sql_escape($pseudo)."';"));
				
				if($Valider == "") 
					die(header("Location: ./"));
				
				$UserName 	 = $Valider['username'];
				$UserPass 	 = $Valider['password'];
				$UserMail 	 = $Valider['email'];
				$UserIP 	 = $Valider['ip'];
					
				$QryInsertUser = "INSERT INTO " . USERS . " SET ";
				$QryInsertUser .= "`username` = '" . $UserName . "', ";
				$QryInsertUser .= "`email` = '" . $UserMail . "', ";
				$QryInsertUser .= "`email_2` = '" . $UserMail . "', ";
				$QryInsertUser .= "`ip_at_reg` = '" . $UserIP . "', ";
				$QryInsertUser .= "`id_planet` = '0', ";
				$QryInsertUser .= "`onlinetime` = '" . time () . "', ";
				$QryInsertUser .= "`register_time` = '" . time () . "', ";
				$QryInsertUser .= "`password` = '" . $UserPass . "', ";
				$QryInsertUser .= "`dpath` = '" . DEFAULT_SKINPATH . "', ";
				$QryInsertUser .= "`uctime`= '0';";
				$QryInsertUser .= "DELETE FROM " . USERS_VALID . " WHERE username='" . $UserName . "';";
				$db->multi_query($QryInsertUser);

				if($game_config['smtp_host'] != '' && $game_config['smtp_port'] != 0 && $game_config['smtp_user'] != '' && $game_config['smtp_pass'] != '')
				{				
					$MailSubject	= sprintf($lang['reg_mail_reg_done'], $game_config['game_name']);	
					$MailRAW		= file_get_contents("./language/".$game_config['lang']."/email/email_reg_done.txt");
					$MailContent	= sprintf($MailRAW, $UserName, $game_config['game_name']);	
					MailSend($UserMail, $UserName, $MailSubject, $MailContent);
				}
				
				$NewUser = $db->fetch_array ( $db->query ( "SELECT `id` FROM " . USERS . " WHERE `username` = '" . $UserName . "';" ) );
				
				$LastSettedGalaxyPos = $game_config['LastSettedGalaxyPos'];
				$LastSettedSystemPos = $game_config['LastSettedSystemPos'];
				$LastSettedPlanetPos = $game_config['LastSettedPlanetPos'];
				
				while (!isset($newpos_checked)) {
					for($Galaxy = $LastSettedGalaxyPos; $Galaxy <= MAX_GALAXY_IN_WORLD; $Galaxy ++) {
						for($System = $LastSettedSystemPos; $System <= MAX_SYSTEM_IN_GALAXY; $System ++) {
							for($Posit = $LastSettedPlanetPos; $Posit <= 4; $Posit ++) {
								$Planet = round ( rand ( 4, 12 ) );
								
								switch ($LastSettedPlanetPos) {
									case 1 :
										$LastSettedPlanetPos += 1;
										break;
									case 2 :
										$LastSettedPlanetPos += 1;
										break;
									case 3 :
										if ($LastSettedSystemPos == MAX_SYSTEM_IN_GALAXY) {
											$LastSettedGalaxyPos += 1;
											$LastSettedSystemPos = 1;
											$LastSettedPlanetPos = 1;
											break;
										} else {
											$LastSettedPlanetPos = 1;
										}
										
										$LastSettedSystemPos += 1;
										break;
								}
								break;
							}
							break;
						}
						break;
					}
					
					if (!CheckPlanetIfExist($Galaxy, $System, $Planet))
					{
						CreateOnePlanetRecord ($Galaxy, $System, $Planet, $NewUser['id'], $UserPlanet, true);
						$QryInsertConfig  = "UPDATE " . CONFIG . " SET `config_value` = '" . $LastSettedGalaxyPos . "' WHERE `config_name` = 'LastSettedGalaxyPos';";
						$QryInsertConfig .= "UPDATE " . CONFIG . " SET `config_value` = '" . $LastSettedSystemPos . "' WHERE `config_name` = 'LastSettedSystemPos';";
						$QryInsertConfig .= "UPDATE " . CONFIG . " SET `config_value` = '" . $LastSettedPlanetPos . "' WHERE `config_name` = 'LastSettedPlanetPos';";
						$db->multi_query($QryInsertConfig);
						$newpos_checked = true;
					}
				}
				$PlanetID = $db->fetch_array($db->query("SELECT `id` FROM ".PLANETS." WHERE `id_owner` = '".$NewUser ['id']."';" ));
				
				$QryUpdateUser = "UPDATE " . USERS . " SET ";
				$QryUpdateUser .= "`id_planet` = '" . $PlanetID ['id'] . "', ";
				$QryUpdateUser .= "`current_planet` = '" . $PlanetID ['id'] . "', ";
				$QryUpdateUser .= "`galaxy` = '" . $Galaxy . "', ";
				$QryUpdateUser .= "`system` = '" . $System . "', ";
				$QryUpdateUser .= "`planet` = '" . $Planet . "' ";
				$QryUpdateUser .= "WHERE ";
				$QryUpdateUser .= "`id` = '" . $NewUser ['id'] . "' ";
				$QryUpdateUser .= "LIMIT 1;";
				$QryUpdateUser .= "INSERT INTO ".STATPOINTS." (`id_owner`, `id_ally`, `stat_type`, `stat_code`, `tech_rank`, `tech_old_rank`, `tech_points`, `tech_count`, `build_rank`, `build_old_rank`, `build_points`, `build_count`, `defs_rank`, `defs_old_rank`, `defs_points`, `defs_count`, `fleet_rank`, `fleet_old_rank`, `fleet_points`, `fleet_count`, `total_rank`, `total_old_rank`, `total_points`, `total_count`, `stat_date`) VALUES (".$NewUser['id'].", 0, 1, 1, 1, 0, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 0, 0, ".time().");";
				$db->multi_query ( $QryUpdateUser );
				
				$from 		= $lang ['welcome_message_from'];
				$sender 	= $lang ['welcome_message_sender'];
				$Subject 	= $lang ['welcome_message_subject'];
				$message 	= sprintf($lang['welcome_message_content'], $game_config['game_name']);
				SendSimpleMessage ( $NewUser ['id'], $sender, $Time, 1, $from, $Subject, $message );
				
				$db->query ( "UPDATE " . CONFIG . " SET `config_value` = `config_value` + '1' WHERE `config_name` = 'users_amount';" );
				if ($admin == 1) {
					echo "User ".$UserName." wurde aktiviert!";
				} else {
					include('config.php');
					$cookie = $NewUser ['id'] . "/%/" . $UserName . "/%/" . md5 ( $UserPass . "--" . $dbsettings ["secretword"] ) . "/%/" . 0;
					setcookie( $game_config ['COOKIE_NAME'], $cookie, 0, "/", "", 0 );
										
					unset($dbsettings);
					
					header("location:game.php?page=overview");
				
				}
			break;
			default :
				$template->assign_vars(array(
					'server_message_reg'			=> $lang['server_message_reg'],
					'register_at_reg'				=> $lang['register_at_reg'],
					'user_reg'						=> $lang['user_reg'],
					'pass_reg'						=> $lang['pass_reg'],
					'pass2_reg'						=> $lang['pass2_reg'],
					'email_reg'						=> $lang['email_reg'],
					'email2_reg'					=> $lang['email2_reg'],
					'captcha_reg'					=> $lang['captcha_reg'],
					'register_now'					=> $lang['register_now'],
					'accept_terms_and_conditions'	=> $lang['accept_terms_and_conditions'],
					'captcha_reload'				=> $lang['captcha_reload'],
					'captcha_help'					=> $lang['captcha_help'],
					'captcha_get_image'				=> $lang['captcha_get_image'],
					'captcha_reload'				=> $lang['captcha_reload'],
					'captcha_get_audio'				=> $lang['captcha_get_audio'],
					'AvailableUnis'					=> $AvailableUnis,
					'uni_reg'						=> $lang['uni_reg'],
					'chose_a_uni'					=> $lang['chose_a_uni'],
				));
				$template->display('public/registry_form.tpl');
			break;
		}
		break;
	case 'agb' :
		$template->assign_vars(array(
			'agb'				=> $lang['agb'],
			'agb_overview'		=> $lang['agb_overview'],
		));
		$template->display('public/index_agb.tpl');
		break;
	case 'rules' :
		$template->assign_vars(array(
			'rules'				=> $lang['rules'],
			'rules_overview'	=> $lang['rules_overview'],
			'rules_info1'		=> sprintf($lang['rules_info1'], $game_config['forum_url']),
			'rules_info2'		=> $lang['rules_info2'],
		));
		$template->display('public/index_rules.tpl');
		break;
	case 'screens' :
		$template->display('public/index_screens.tpl');
		break;
	case 'top100' :
		$top = $db->query("SELECT * FROM ".TOPKB." ORDER BY gesamtunits DESC LIMIT 100;");
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
			
		$template->assign_vars(array(	
			'AvailableUnis'	=> $AvailableUnis,
			'ThisUni'		=> $ThisUni,
			'tkb_units'		=> $lang['tkb_units'],
			'tkb_datum'		=> $lang['tkb_datum'],
			'tkb_owners'	=> $lang['tkb_owners'],
			'tkb_platz'		=> $lang['tkb_platz'],
			'tkb_top'		=> $lang['tkb_top'],
			'tkb_gratz'		=> $lang['tkb_gratz'],
			'tkb_legende'	=> $lang['tkb_legende'],
			'tkb_gewinner'	=> $lang['tkb_gewinner'],
			'tkb_verlierer'	=> $lang['tkb_verlierer'],
			'TopKBList'		=> $TopKBList,
		));
			
		$template->display('public/index_top100.tpl');
		break;
	case 'pranger' :
		$PrangerRAW = $db->query("SELECT * FROM ".BANNED." ORDER BY `id`;");

		while($u = $db->fetch_array($PrangerRAW))
		{
			$PrangerList[]	= array(
				'player'	=> $u['who'],
				'theme'		=> $u['theme'],
				'from'		=> date("d. M Y H:i:s",$u['time']),
				'to'		=> date("d. M Y H:i:s",$u['longer']),
				'admin'		=> $u['author'],
				'mail'		=> $u['email'],
				'info'		=> sprintf($lang['bn_writemail'], $u['author']),
			);
		}
		
		$template->assign_vars(array(	
			'AvailableUnis'				=> $AvailableUnis,
			'ThisUni'					=> $ThisUni,
			'PrangerList'				=> $PrangerList,
			'bn_no_players_banned'		=> $lang['bn_no_players_banned'],
			'bn_exists'					=> $lang['bn_exists'],
			'bn_players_banned'			=> $lang['bn_players_banned'],
			'bn_players_banned_list'	=> $lang['bn_players_banned_list'],
			'bn_player'					=> $lang['bn_player'],
			'bn_reason'					=> $lang['bn_reason'],
			'bn_from'					=> $lang['bn_from'],
			'bn_until'					=> $lang['bn_until'],
			'bn_by'						=> $lang['bn_by'],
		));
		
		$template->display('public/index_pranger.tpl');
		break;
	case 'disclamer':
		$template->assign_vars(array(
			'disclamer'			=> $lang['disclamer'],
			'disclamer_name'	=> $lang['disclamer_name'],
			'disclamer_adress'	=> $lang['disclamer_adress'],
			'disclamer_tel'		=> $lang['disclamer_tel'],
			'disclamer_email'	=> $lang['disclamer_email'],
		));
		$template->display('public/index_disclamer.tpl');
		break;
	case 'news' :
		$NewsRAW	= $db->query ("SELECT date,title,text,user FROM ".NEWS." ORDER BY id DESC;");
		while ($NewsRow = $db->fetch($NewsRAW)) {
			$NewsList[]	= array(
				'title' => $NewsRow['title'],
				'from' 	=> sprintf($lang['news_from'], date("d. M Y H:i:s", $NewsRow['date']), $NewsRow['user']),
				'text' 	=> makebr($NewsRow['text']),
			);
		}
		
		$template->assign_vars(array(
			'NewsList'				=> $NewsList,
			'news_overview'			=> $lang['news_overview'],
			'news_does_not_exist'	=> $lang['news_does_not_exist'],
		));
		
		$template->display('public/index_news.tpl');
	break;
	default :
		if ($_POST) {
			$luser = request_var('username', '');
			$lpass = request_var('password', '');
			$login = $db->fetch_array($db->query("SELECT `id`,`username`,`password`,`banaday` FROM " . USERS . " WHERE `username` = '".$db->sql_escape($luser)."' AND `password` = '".md5($lpass)."';"));
			
			if ($login) {
				if ($login['banaday'] <= time () && $login['banaday'] != '0') {
					$db->query("UPDATE " . USERS . " SET `banaday` = '0', `bana` = '0' WHERE `username` = '" . $login ['username'] . "';");
				}
			
				$expiretime = 0;
				$rememberme = 0;
							
				$cookie = $login ["id"] . "/%/" . $login ["username"] . "/%/" . md5($login["password"]. "--" . $dbsettings ["secretword"] ) . "/%/" . $rememberme;
				setcookie($game_config['COOKIE_NAME'], $cookie, $expiretime, "/", "", 0);
				
				$db->query ( "UPDATE `" . USERS . "` SET `current_planet` = `id_planet` WHERE `id` ='" . $login ["id"] . "';" );

				header("Location: ./game.php?page=overview");
				exit ();
			} else {
				message($lang['login_error'], "./", 2, false, false);
			}
		} else {
			$template->assign_vars(array(
				'AvailableUnis'			=> $AvailableUnis,
				'welcome_to'			=> $lang['welcome_to'],
				'server_description'	=> sprintf($lang['server_description'], $game_config['game_name']),
				'server_infos'			=> $lang['server_infos'],
				'login'					=> $lang['login'],
				'login_info'			=> $lang['login_info'],
				'user'					=> $lang['user'],
				'pass'					=> $lang['pass'],
				'lostpassword'			=> $lang['lostpassword'],
				'register_now'			=> $lang['register_now'],
				'screenshots'			=> $lang['screenshots'],
				'chose_a_uni'			=> $lang['chose_a_uni'],
				'universe'				=> $lang['universe'],
			));
			$template->display('public/index_body.tpl');
		}
	break;
}
?>