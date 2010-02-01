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

$xgp_root = './';

include ($xgp_root . 'extension.inc.php');
include ($xgp_root . 'common.' . $phpEx);

includeLang ( 'PUBLIC' );
$parse = $lang;
$page = request_var ( 'page', '' );
$mode = request_var ( 'mode', '' );


$parse['servername'] 	= $game_config['game_name'];
$parse['forum_url'] 	= $game_config['forum_url'];
$parse['game_url']		= REALPATH;
$parse['jscap']			= ($game_config ['capaktiv'] === '1') ? "<script src=\"http://api.recaptcha.net/js/recaptcha_ajax.js\" type=\"text/javascript\"></script>
<script type=\"text/javascript\">
function showRecaptcha(element, themeName) {
  Recaptcha.create(\"".$game_config['cappublic']."\", element, {
        theme: themeName,
        tabindex: 0,
        callback: Recaptcha.focus_response_field
  });
}
</script>
":"";
$getajax				= request_var ( 'getajax', 0 );
$parse['game_captcha']	= $game_config ['capaktiv'];
$parse['game_close']	= $game_config ['reg_closed'];
$parse['header'] 		= (!$getajax) ? parsetemplate ( gettemplate ( 'public/index_header' ), $parse ):"";
$parse['footer']	 	= (!$getajax) ? parsetemplate ( gettemplate ( 'public/index_footer' ), $parse ):"";

switch ($page) {
	case 'lostpassword' :
		$usermail = request_var ( 'email', '' );
		if (! empty ( $_POST )) {
			$ExistMail = $db->fetch_array ( $db->query ( "SELECT `username` FROM " . USERS . " WHERE `email` = '" . $db->sql_escape($usermail) . "' LIMIT 1;" ) );
			if (empty($ExistMail['username'])) {
				message($lang ['mail_not_exist'], "index.php?page=lostpassword", 3, false, false );
			} else {
				$Caracters = "aazertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN1234567890";
				$Count = strlen ( $Caracters );
				$NewPass = "";
				$Taille = 6;
				for($i = 0; $i < $Taille; $i ++) {
					$CaracterBoucle = rand ( 0, $Count - 1 );
					$NewPass = $NewPass . substr ( $Caracters, $CaracterBoucle, 1 );
				}
				
				$Body = "Hallo ".$ExistMail['username'].",<br /><br />";
				$Body .= "dein Passwort für " . $game_config ['game_name'] . " lautet:<br /><br />";
				$Body .= $NewPass . "<br /><br />";
				$Body .= "Du kannst dich damit unter http://".$_SERVER['SERVER_NAME'].$_SERVER["PHP_SELF"] . " einloggen.<br /><br />";
				$Body .= "Wir verschicken Passwörter nur an die von dir im Spiel angegebenen Mailadressen. Solltest du diese Mail nicht angefordert haben kannst du sie also einfach ignorieren.<br /><br />";
				$Body .= "Wir wünschen dir weiterhin viel Erfolg beim Spielen von " . $game_config ['game_name'] . "!<br /><br />";
				$Body .= "Dein " . $game_config ['game_name'] . "-Team<br /><br />";
				
			
				if($game_config['smtp_host'] == '' || $game_config['smtp_port'] == '' || $game_config['smtp_user'] == '' || $game_config['smtp_pass'] == '')
					message ($lang["mail_sended_fail"], "./", 2, false, false );
				
				MailSend($usermail, $ExistMail['username'], $lang['mail_title'], $Body);
			
			$QryPassChange = "UPDATE ".USERS." SET `password` ='" . $NewPassSql . "' WHERE `email`='" . $db->sql_escape($usermail) . "' LIMIT 1;";
				$db->query ( $QryPassChange );
			}
		} else {
			$parse ['forum_url'] = $game_config ['forum_url'];
			echo parsetemplate ( gettemplate ( 'public/lostpassword' ), $parse );
		}
		break;
	case 'reg' :
		
		if ($game_config ['reg_closed'] == 1){
			echo parsetemplate ( gettemplate ( 'public/registry_closed' ), $parse);
			exit;
		}
		switch ($mode) {
			case 'send' :
				$errors = 0;
				$errorlist = "";
				if ($game_config ['capaktiv'] === '1') {
					require_once ('includes/libs/reCAPTCHA/recaptchalib.php');
					$privatekey = $game_config ['capprivate'];
					$resp = recaptcha_check_answer ( $privatekey, $_SERVER ["REMOTE_ADDR"], request_var ( 'recaptcha_challenge_field', '' ), request_var ( 'recaptcha_response_field', '' ) );
					if (!$resp->is_valid) {
						$errorlist .= "Sicherheitscode falsch!<br />";
						$errors ++;
					}
				}
				
				$UserPass 	= request_var ( 'passwrd', '' );
				$UserName 	= request_var ( 'character', '' );
				$UserEmail 	= request_var ( 'email', '' );
				$agbrules 	= request_var ( 'rgt', '' );
				$Exist['userv'] = $db->fetch_array($db->query("SELECT username, email FROM ".USERS." WHERE username = '".$db->sql_escape($UserName)."' OR email = '".$db->sql_escape($UserEmail)."';"));
				$Exist['vaild'] = $db->fetch_array($db->query("SELECT username, email FROM ".USERS_VALID." WHERE username = '".$db->sql_escape($UserName)."' OR email = '".$db->sql_escape($UserEmail)."';"));
				if (! is_email ( $UserEmail )) {
					$errorlist .= $lang ['invalid_mail_adress'];
					$errors ++;
				}
				
				if (! $UserName) {
					$errorlist .= $lang ['empty_user_field'];
					$errors ++;
				}
				
				if (strlen ( $UserPass ) < 6) {
					$errorlist .= $lang ['password_lenght_error'];
					$errors ++;
				}
				
				if (!ctype_alnum($UserName)) {
					$errorlist .= $lang ['user_field_no_alphanumeric'];
					$errors ++;
				}
				
				if ($agbrules != 'on') {
					$errorlist .= $lang ['terms_and_conditions'];
					$errors ++;
				}
				
				if ((isset($Exist['userv']['username']) || isset($Exist['vaild']['username']) && ($UserName == $Exist['userv']['username'] || $UserName == $Exist['vaild']['username']))) {
					$errorlist .= $lang ['user_already_exists'];
					$errors ++;
				}
				if ((isset($Exist['userv']['email']) || isset($Exist['vaild']['email'])) && ($UserEmail == $Exist['userv']['email'] || $UserEmail == $Exist['vaild']['email'])) {
					$errorlist .= $lang ['mail_already_exists'];
					$errors ++;
				}
				
				if ($errors != 0) {
					message ( $errorlist, "index.php?page=reg", "3", false, false );
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
						
						exit(header("Location: index.php?page=reg&mode=valid&pseudo=" . $UserName . "&clef=" . $clef));
					}					

					$MailSubject 	= $lang['reg_mail_message_pass'];
					$MailRAW		= file_get_contents("./language/deutsch/email/email_vaild_reg.txt");
					$MailContent	= sprintf($MailRAW, $UserName, $game_config['game_name'], "http://".$_SERVER['SERVER_NAME'].$_SERVER["PHP_SELF"] ,$clef, $UserPass, ADMINEMAIL);
		
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
				$pseudo 	 = request_var('pseudo', '');
				$clef 		 = request_var('clef', '');
				$admin 	 	 = request_var('admin', 0);
				$Valider	 = $db->fetch_array($db->query("SELECT username, password, email, ip FROM ".USERS_VALID." WHERE cle = '".$db->sql_escape($clef)."' AND username = '".$db->sql_escape($pseudo)."';"));
				
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
				$QryInsertUser .= "`register_time` = '" . time () . "', ";
				$QryInsertUser .= "`password` = '" . $UserPass . "', ";
				$QryInsertUser .= "`dpath` = '" . DEFAULT_SKINPATH . "', ";
				$QryInsertUser .= "`uctime`= '0';";
				$QryInsertUser .= "DELETE FROM " . USERS_VALID . " WHERE username='" . $UserName . "';";
				$db->multi_query($QryInsertUser);
			
				if($game_config['smtp_host'] != '' && $game_config['smtp_port'] != 0 && $game_config['smtp_user'] != '' && $game_config['smtp_pass'] != '')
				{				
					$MailSubject	= sprintf($lang['reg_mail_reg_done'], $game_config['game_name']);	
					$MailRAW		= file_get_contents("./language/deutsch/email/email_reg_done.txt");
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
				$QryUpdateUser .= "INSERT INTO ".STATPOINTS." (`id_owner`, `id_ally`, `stat_type`, `stat_code`, `tech_rank`, `tech_old_rank`, `tech_points`, `tech_count`, `build_rank`, `build_old_rank`, `build_points`, `build_count`, `defs_rank`, `defs_old_rank`, `defs_points`, `defs_count`, `fleet_rank`, `fleet_old_rank`, `fleet_points`, `fleet_count`, `total_rank`, `total_old_rank`, `total_points`, `total_count`, `stat_date`) VALUES (1, 0, 1, 1, 1, 0, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1263934230);";
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
					setcookie ( $game_config ['COOKIE_NAME'], $cookie, 0, "/", "", 0 );
					
					unset($dbsettings);
					
					header("location:game.php?page=overview");
				
				}
			break;
			default :
				$parse ['servername'] = $game_config ['game_name'];
				$parse ['forum_url'] = $game_config ['forum_url'];
				echo parsetemplate ( gettemplate ( 'public/registry_form' ), $parse );
			break;
		}
		break;
	case 'agb' :
		echo parsetemplate ( gettemplate ( 'public/index_agb' ), $parse );
		break;
	case 'rules' :
		echo parsetemplate ( gettemplate ( 'public/index_rules' ), $parse );
		break;
	case 'screens' :
		echo parsetemplate ( gettemplate ( 'public/index_screens' ), $parse );
		break;
	case 'impressum' :
		echo parsetemplate ( gettemplate ( 'public/index_impressum' ), $parse );
		break;
	case 'news' :
		$query = $db->query ("SELECT * FROM ".NEWS." ORDER BY id DESC;");
		$news = "";
		while ($NewsRow = $db->fetch($query)) {
			$parse ['name']		= $NewsRow ['user'];
			$parse ['title'] 	= $NewsRow ['title'];
			$parse ['date'] 	= date ( "d.m.Y H:i:s", $NewsRow ['date'] );
			$parse ['text'] 	= makebr($NewsRow['text']);
			$news .= parsetemplate ( gettemplate ( 'public/index_news_rows' ), $parse );
		}
		$parse ['news'] = $news;

		echo parsetemplate ( gettemplate ( 'public/index_news_body' ), $parse );
		break;
	default :
		if ($_POST) {
			$luser = request_var ( 'username', '' );
			$lpass = request_var ( 'password', '' );
			$lre = request_var ( 'rememberme', 0 );
			$login = $db->fetch_array ( $db->query ( "SELECT `id`,`username`,`password`,`banaday` FROM " . USERS . " WHERE `username` = '" . $db->sql_escape ( $luser ) . "' AND `password` = '" . md5 ( $lpass ) . "';" ) );
			
			if ($login ['banaday'] <= time () && $login ['banaday'] != '0') {
				$db->multi_query ("UPDATE " . USERS . " SET `banaday` = '0', `bana` = '0' WHERE `username` = '" . $login ['username'] . "';DELETE FROM " . BANNED . " WHERE `who` = '" . $login ['username'] . "';" );
			}
			
			if ($login) {
				if ($lre) {
					$expiretime = time () + 31536000;
					$rememberme = 1;
				} else {
					$expiretime = 0;
					$rememberme = 0;
				}
				
				@include ('config.php');
				$cookie = $login ["id"] . "/%/" . $login ["username"] . "/%/" . md5 ( $login ["password"] . "--" . $dbsettings ["secretword"] ) . "/%/" . $rememberme;
				setcookie ( $game_config ['COOKIE_NAME'], $cookie, $expiretime, "/", "", 0 );
				
				$db->query ( "UPDATE `" . USERS . "` SET `current_planet` = `id_planet` WHERE `id` ='" . $login ["id"] . "';" );
				
				unset ( $dbsettings );
				header ( "Location: ./game.php?page=overview" );
				exit ();
			} else {
				message ( $lang ['login_error'], "./", 2, false, false );
			}
		} else {
			echo parsetemplate ( gettemplate ( 'public/index_body' ), $parse );
		}
	break;
}
?>