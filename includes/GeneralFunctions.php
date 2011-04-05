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
 * @version 1.3 (2011-01-21)
 * @link http://code.google.com/p/2moons/
 */

function getUniverse()
{
	if(defined('IN_ADMIN') && isset($_SESSION['adminuni'])) {
		$UNI	= (int) $_SESSION['adminuni'];
	} elseif(defined('LOGIN') && isset($_REQUEST['uni'])) {
		$UNI	= (int) $_REQUEST['uni'];
	} elseif(defined('LOGIN') && isset($_COOKIE['uni'])) {
		$UNI	= (int) $_COOKIE['uni'];
	} elseif(isset($_SESSION['uni'])) {
		$UNI	= $_SESSION['uni'];
	} else {
		if(UNIS_WILDCAST === true) {
			$UNI	= explode('.', $_SERVER['HTTP_HOST']);
			$UNI	= substr($UNI[0], 3);
			if(!is_numeric($UNI))
				$UNI	= 1;
		} else {
			$UNI	= 1;
		}
	}
	
	return $UNI;
}

function getFactors($USER, $PLANET, $Type = 'basic', $TIME = 0) {
	global $CONF, $resource, $OfficerInfo, $ExtraDM;
	if(empty($TIME))
		$TIME	= TIMESTAMP;
		
	if($Type == 'basic') {
		return array(
			array(
				'shipspeed'		=> 1 + DMExtra($USER[$resource[706]], $TIME, $ExtraDM[701]['add'], 0)
			),
			array(
				'bulidspeed'	=> 1 - (1 - pow(0.5, $PLANET[$resource[15]])) - $USER[$resource[605]] * $OfficerInfo[605]['info'] - DMExtra($USER[$resource[702]], $TIME, $ExtraDM[702]['add'], 0),
				'techspeed'		=> 1 - $USER[$resource[606]] * $OfficerInfo[606]['info'] - (1 - pow(1 - $CONF['factor_university'] / 100, $PLANET[$resource[6]])) - DMExtra($USER[$resource[705]], $TIME, $ExtraDM[705]['add'], 0),
				'fleetspeed'	=> 1 - (1 - pow(0.5, $PLANET[$resource[15]])) - $USER[$resource[613]] * $OfficerInfo[613]['info'] - $USER[$resource[604]] * $OfficerInfo[604]['info'],
				'defspeed'		=> 1 - (1 - pow(0.5, $PLANET[$resource[15]])) - $USER[$resource[613]] * $OfficerInfo[613]['info'] - $USER[$resource[608]] * $OfficerInfo[608]['info'],
				'metal'			=> 1 + ($USER[$resource[601]] * $OfficerInfo[601]['info']) + ($USER[$resource[131]] * 0.02) + DMExtra($USER[$resource[703]], $TIME, $ExtraDM[703]['add'], 0),
				'crystal'		=> 1 + ($USER[$resource[601]] * $OfficerInfo[601]['info']) + ($USER[$resource[132]] * 0.02) + DMExtra($USER[$resource[703]], $TIME, $ExtraDM[703]['add'], 0),
				'deuterium'		=> 1 + ($USER[$resource[601]] * $OfficerInfo[601]['info']) + ($USER[$resource[133]] * 0.02) + DMExtra($USER[$resource[703]], $TIME, $ExtraDM[703]['add'], 0),
				'energy'		=> 1 + ($USER[$resource[603]] * $OfficerInfo[603]['info']) + DMExtra($USER[$resource[704]], $TIME, $ExtraDM[704]['add'], 0),
			)
		);
	}

	if($Type == 'attack') {
		return array(
			'attack'		=> $USER[$resource[602]] * $OfficerInfo[602]['info'] + DMExtra($USER[$resource[700]], $TIME, $ExtraDM[700]['add'], 0),
			'defensive'		=> $USER[$resource[602]] * $OfficerInfo[602]['info'] + DMExtra($USER[$resource[701]], $TIME, $ExtraDM[701]['add'], 0),
			'shield'		=> $USER[$resource[602]] * $OfficerInfo[602]['info'],
		);
	}
}

function update_config($Values, $UNI = 0)
{
	global $CONF, $db;
	$SQLBASE	= "";
	$SQLUNI		= "";
	$UNI		= (empty($UNI)) ? $GLOBALS['UNI'] : $UNI;
	$BasicConf	= array('VERSION', 'game_name', 'stat', 'stat_level', 'stat_last_update', 'stat_settings', 'stat_update_time', 'stat_last_db_update', 'stats_fly_lock', 'cron_lock', 'ts_modon', 'ts_server', 'ts_tcpport', 'ts_udpport', 'ts_timeout', 'ts_version', 'ts_cron_last', 'ts_cron_interval', 'ts_login', 'ts_password', 'capaktiv', 'cappublic', 'capprivate', 'mail_active', 'mail_use', 'smtp_host', 'smtp_port', 'smtp_user', 'smtp_pass', 'smtp_ssl', 'smtp_sendmail', 'smail_path', 'fb_on', 'fb_apikey', 'fb_skey', 'ga_active', 'ga_key', 'chat_closed', 'chat_allowchan', 'chat_allowmes', 'chat_allowdelmes', 'chat_logmessage', 'chat_nickchange', 'chat_botname', 'chat_channelname', 'chat_socket_active', 'chat_socket_host', 'chat_socket_ip', 'chat_socket_port', 'chat_socket_chatid', 'ttf_file');
	foreach($Values as $Name => $Value) {
		if(!isset($CONF[$Name]))
			continue;
			
		$GLOBALS['CONFIG'][$UNI][$Name]	= $Value;
		
		$CONF[$Name]	= $Value;
		if(in_array($Name, $BasicConf))
			$SQLBASE	.= "`".$Name."` = '".$db->sql_escape($Value)."', ";
		else
			$SQLUNI		.= "`".$Name."` = '".$db->sql_escape($Value)."', ";
	}
	if(!empty($SQLBASE))
		$db->query("UPDATE ".CONFIG." SET ".substr($SQLBASE, 0, -2).";");
	
	if(!empty($SQLUNI))
		$db->query("UPDATE ".CONFIG." SET ".substr($SQLUNI, 0, -2)." WHERE `uni` = '".$UNI."';");
}

function getConfig($UNI) {
	global $db;
	if(isset($GLOBALS['CONFIG'][$UNI]))
		return $GLOBALS['CONFIG'][$UNI];
		
	$CONF = $db->uniquequery("SELECT HIGH_PRIORITY * FROM `".CONFIG."` WHERE `uni` = '".$UNI."';");
	$CONF['moduls']			= explode(";", $CONF['moduls']);
	$CONF['ref_active']			= 0;
	$CONF['ref_bonus']			= 1000;
	$CONF['ref_minpoints']		= 2000;
	$CONF['del_oldstuff']		= 259200;
	$CONF['del_user_manually']	= 604800;
	$CONF['del_user_automatic']	= 2592000;
	$CONF['del_user_sendmail']	= 1814400;
	$CONF['sendmail_inactive']	= 0;
	
	$GLOBALS['CONFIG'][$UNI]	= $CONF;
	return $CONF;
}

function ValidateAddress($address) {
	
	$ValideAdress = function_exists('filter_var') ? filter_var($address, FILTER_VALIDATE_EMAIL) !== FALSE : preg_match('/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/', $address);
	
	return $ValideAdress;
}

function message($mes, $dest = "", $time = "3", $topnav = false, $menu = true)
{
	require_once(ROOT_PATH . 'includes/classes/class.template.php');
	$template = new template();
	$template->message($mes, $dest, $time, !$topnav);
	exit;
}

function CalculateMaxPlanetFields($planet)
{
	global $resource;
	return $planet['field_max'] + ($planet[$resource[33]] * FIELDS_BY_TERRAFORMER) + ($planet[$resource[41]] * FIELDS_BY_MOONBASIS_LEVEL);
}

function pretty_time ($seconds)
{
	$day = floor($seconds / (24 * 3600));
	$hs = floor($seconds / 3600 % 24);
	$ms = floor($seconds / 60 % 60);
	$sr = floor($seconds / 1 % 60);

	$hh = $hs < 10 ? "0" . $hs : $hs;
	$mm = $ms < 10 ? "0" . $ms : $ms;
	$ss = $sr < 10 ? "0" . $sr : $sr;

	$time  = '';
	$time .= $day != 0 ? $day . 'd ' : '';
	$time .= $hs  != 0 ? $hh . 'h ' : '00h ';
	$time .= $ms  != 0 ? $mm . 'm ' : '00m ';
	$time .= $ss . 's';

	return $time;
}

function pretty_time_hour ($seconds)
{
	$min = floor($seconds / 60 % 60);
	$time  = '';
	$time .= $min != 0 ? $min . 'min ' : '';
	return $time;
}

function GetStartAdressLink($FleetRow, $FleetType)
{
	return '<a href="game.php?page=galaxy&amp;mode=3&amp;galaxy='.$FleetRow['fleet_start_galaxy'].'&amp;system='.$FleetRow['fleet_start_system'].'" class="'. $FleetType .'">['.$FleetRow['fleet_start_galaxy'].':'.$FleetRow['fleet_start_system'].':'.$FleetRow['fleet_start_planet'].']</a>';
}

function GetTargetAdressLink($FleetRow, $FleetType)
{
	return '<a href="game.php?page=galaxy&amp;mode=3&amp;galaxy='.$FleetRow['fleet_end_galaxy'].'&amp;system='.$FleetRow['fleet_end_system'].'" class="'. $FleetType .'">['.$FleetRow['fleet_end_galaxy'].':'.$FleetRow['fleet_end_system'].':'.$FleetRow['fleet_end_planet'].']</a>';
}

function BuildPlanetAdressLink($CurrentPlanet)
{
	return '<a href="game.php?page=galaxy&amp;mode=3&amp;galaxy='.$CurrentPlanet['galaxy'].'&amp;system='.$CurrentPlanet['system'].'">['.$CurrentPlanet['galaxy'].':'.$CurrentPlanet['system'].':'.$CurrentPlanet['planet'].']</a>';
}

function colorNumber($n, $s = '')
{
	if ($n > 0)
		return (empty($s)) ? colorGreen($n) : colorGreen($s);
	elseif ($n < 0)
		return (empty($s)) ? colorRed($n) : colorRed($s);
	else
		return (empty($s)) ? $n : $s;
}

function colorRed($n)
{
	return '<span style="color:#ff0000">' . $n . '</span>';
}

function colorGreen($n)
{
	return '<span style="color:#00ff00">' . $n . '</span>';
}

function pretty_number($n, $dec = 0)
{
	return number_format(floattostring($n, $dec), 0, ',', '.');
}

function set_var(&$result, $var, $type, $multibyte = false)
{
	settype($var, $type);
	$result = $var;

	if ($type == 'string')
	{
		$result = trim(htmlspecialchars(str_replace(array("\r\n", "\r", "\0"), array("\n", "\n", ''), $result), ENT_COMPAT, 'UTF-8'));

		if (!empty($result))
		{
			// Make sure multibyte characters are wellformed
			if ($multibyte)
			{
				if (!preg_match('/^./u', $result))
				{
					$result = '';
				}
			}
			else
			{
				// no multibyte, allow only ASCII (0-127)
				$result = preg_replace('/[\x80-\xFF]/', '?', $result);
			}
		}
	}
}

/**
* request_var
*
* Used to get passed variable
*/
function request_var($var_name, $default, $multibyte = false, $cookie = false)
{
	if (!$cookie && isset($_COOKIE[$var_name]))
	{
		if (!isset($_GET[$var_name]) && !isset($_POST[$var_name]))
		{
			return (is_array($default)) ? array() : $default;
		}
		$_REQUEST[$var_name] = isset($_POST[$var_name]) ? $_POST[$var_name] : $_GET[$var_name];
	}

	$super_global = ($cookie) ? '_COOKIE' : '_REQUEST';
	if (!isset($GLOBALS[$super_global][$var_name]) || is_array($GLOBALS[$super_global][$var_name]) != is_array($default))
	{
		return (is_array($default)) ? array() : $default;
	}

	$var = $GLOBALS[$super_global][$var_name];
	if (!is_array($default))
	{
		$type = gettype($default);
	}
	else
	{
		list($key_type, $type) = each($default);
		$type = gettype($type);
		$key_type = gettype($key_type);
		if ($type == 'array')
		{
			reset($default);
			$default = current($default);
			list($sub_key_type, $sub_type) = each($default);
			$sub_type = gettype($sub_type);
			$sub_type = ($sub_type == 'array') ? 'NULL' : $sub_type;
			$sub_key_type = gettype($sub_key_type);
		}
	}

	if (is_array($var))
	{
		$_var = $var;
		$var = array();

		foreach ($_var as $k => $v)
		{
			set_var($k, $k, $key_type);
			if ($type == 'array' && is_array($v))
			{
				foreach ($v as $_k => $_v)
				{
					if (is_array($_v))
					{
						$_v = null;
					}
					set_var($_k, $_k, $sub_key_type);
					set_var($var[$k][$_k], $_v, $sub_type, $multibyte);
				}
			}
			else
			{
				if ($type == 'array' || is_array($v))
				{
					$v = null;
				}
				set_var($var[$k], $v, $type, $multibyte);
			}
		}
	}
	else
	{
		set_var($var, $var, $type, $multibyte);
	}

	return $var;
}

function request_outofint($var_name, $Negative = false)
{
	return $Negative ? floor(request_var($var_name, 0.0), 0) : max(floor(request_var($var_name, 0.0), 0), 0) ;
}

function GetUserByID($UserID, $GetInfo = "*")
{
	global $db;
	
	if(is_array($GetInfo)) {
		$GetOnSelect = "";
		foreach($GetInfo as $id => $col)
		{
			$GetOnSelect .= "`".$col."`,";
		}
		$GetOnSelect = substr($GetOnSelect, 0, -1);
	}
	else
		$GetOnSelect = $GetInfo;
	
	$User = $db->uniquequery("SELECT ".$GetOnSelect." FROM ".USERS." WHERE `id` = '". $UserID ."';");
	return $User;
}

function MailSend($MailTarget, $MailTargetName, $MailSubject, $MailContent)
{
	global $CONF;
	require_once('./includes/classes/class.phpmailer.php');
	$mail             	= new PHPMailer(true);
	if($CONF['mail_use'] == 2) {
		$mail->IsSMTP();  
		$mail->SMTPAuth   	= true; 
		$mail->SMTPSecure 	= $CONF['smtp_ssl'];  						
		$mail->Host      	= $CONF['smtp_host'];
		$mail->Port      	= $CONF['smtp_port'];
		$mail->Username  	= $CONF['smtp_user'];
		$mail->Password  	= $CONF['smtp_pass'];
		$mail->SMTPDebug  	= ($CONF['debug'] == 1) ? 2 : 0;   
	} elseif($CONF['mail_use'] == 1) {
		$mail->IsSendmail();
		$mai->Sendmail		= $CONF['smail_path'];
	} else {
		$mail->IsMail();
	}
	$mail->CharSet		= 'UTF-8';		
	$mail->Subject   	= $MailSubject;
	$mail->Body   		= $MailContent;
	$mail->SetFrom($CONF['smtp_sendmail'], $CONF['game_name']);
	$mail->AddAddress($MailTarget, $MailTargetName);
	$mail->Send();	
}

function makebr($text)
{
    // XHTML FIX for PHP 5.3.0
	// Danke an Meikel
	
    $BR = "<br>\n";
    return (version_compare(PHP_VERSION, "5.3.0", ">=")) ? nl2br($text, false) : strtr($text, array("\r\n" => $BR, "\r" => $BR, "\n" => $BR)); 
}

function CheckPlanetIfExist($Galaxy, $System, $Planet, $Universe, $Planettype = 1)
{
	global $db;
	$QrySelectGalaxy = $db->uniquequery("SELECT id FROM ".PLANETS." WHERE `universe` = '".$Universe."' AND `galaxy` = '".$Galaxy."' AND `system` = '".$System."' AND `planet` = '".$Planet."' AND `planet_type` = '".$Planettype."';");
	return (isset($QrySelectGalaxy)) ? true : false;
}

function CheckNoobProtec($OwnerPlayer, $TargetPlayer, $Player)
{	
	global $CONF;
	if($CONF['noobprotection'] == 0 || $CONF['noobprotectionmulti'] == 0 || $OwnerPlayer['total_points'] <= $CONF['noobprotectiontime'] || $Player['banaday'] > TIMESTAMP || $Player['onlinetime'] < (TIMESTAMP - 60 * 60 * 24 * 7))
		return array('NoobPlayer' => false, 'StrongPlayer' => false);
		
	return array(
		'NoobPlayer' => $OwnerPlayer['total_points'] * (1 / $CONF['noobprotectionmulti']) > $TargetPlayer['total_points'],
		'StrongPlayer' => $OwnerPlayer['total_points'] * $CONF['noobprotectionmulti'] < $TargetPlayer['total_points']
	);
}

function CheckName($String)
{
	return(ctype_alnum($String) || (UTF8_SUPPORT && !empty($String))) ? true : false;
}

function exception_handler($exception) 
{
	global $CONF;

	@session_write_close();
	if($_SERVER['SERVER_PROTOCOL'] == 'HTTP/1.1' && !headers_sent())
		header('HTTP/1.1 503 Service Unavailable');
		
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">';
	echo '<html>';
	echo '<head>';
	echo '<meta http-equiv="content-type" content="text/html; charset=UTF-8">';
	echo '<meta http-equiv="content-script-type" content="text/javascript">';
	echo '<meta http-equiv="content-style-type" content="text/css">';
	echo '<meta http-equiv="content-language" content="de">';
	echo '<title>'.$CONF['game_name'].' - FATAL ERROR</title>';
	echo '<link rel="shortcut icon" href="'.(defined('INSTALL') ? '..':'.').'/favicon.ico">';
	echo '<link rel="stylesheet" type="text/css" href="'.(defined('INSTALL') ? '..':'.').'/styles/theme/'.DEFAULT_THEME.'/formate.css">';
	echo '</head>';
	echo '<body style="margin-top:30px;">';
	echo '<table width="80%">';
	echo '<tr>';
	echo '<th>';
	echo 'Error:';
	echo '</th>';
	echo '</tr>';
	echo '<tr>';
    echo '<td class="left"><b>Message: </b>'.$exception->getMessage().'<br>';
    echo '<b>File: </b>'.$exception->getFile().'<br>';
    echo '<b>Line: </b>'.$exception->getLine().'<br>';
    echo '<b>URL: </b>'.PROTOCOL.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].(!empty($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING']: '').'<br>';
    echo '<b>PHP-Version: </b>'.PHP_VERSION.'<br>';
    echo '<b>PHP-API: </b>'.php_sapi_name().'<br>';
    echo '<b>2Moons Version: </b>'.$CONF['VERSION'].'<br>';
	echo '<b>Debug Backtrace:</b><br>'.makebr(str_replace($_SERVER['DOCUMENT_ROOT'], '.', htmlspecialchars($exception->getTraceAsString()))).'</th>';
	echo '</tr>';
	echo '</table>';
	echo '</body>';			
	echo '</html>';
	exit;
}

function SendSimpleMessage($Owner, $Sender, $Time, $Type, $From, $Subject, $Message, $Unread = 1, $Uni = 0)
{
	global $db;
	if(empty($Uni))
		$Uni	= $GLOBALS['UNI'];
		
	$SQL	= "UPDATE ".USERS." SET `new_message` = `new_message` + '1' WHERE `id` = '".$Owner."';INSERT INTO ".MESSAGES." SET `message_owner` = '".$Owner."', `message_sender` = '".(int)$Sender."', `message_time` = '".((empty($Time)) ? TIMESTAMP : $Time)."', `message_type` = '".$Type."', `message_from` = '". $db->sql_escape($From) ."', `message_subject` = '". $db->sql_escape($Subject) ."', `message_text` = '".$db->sql_escape($Message)."', `message_unread` = '".$Unread."', `message_universe` = '".$Uni."';";

	$db->multi_query($SQL);
}
	
function shortly_number($number)
{
	if ($number >= 1000000000000000000000000)
		return pretty_number($number/1000000000000000000000).' T+';
	elseif ($number >= 1000000000000000000)
		return pretty_number($number/1000000000000000000).' T';
	elseif ($number >= 1000000000000)
		return pretty_number($number/1000000000000).' B';
	elseif ($number >= 1000000)
		return pretty_number($number/1000000).' M';
	elseif ($number >= 1000)
		return pretty_number($number/1000).' K';
	else
		return pretty_number($number);
}

function floattostring($Numeric, $Pro = 0, $Output = false){
	return ($Output) ? str_replace(",",".", sprintf("%.".$Pro."f", $Numeric)) : sprintf("%.".$Pro."f", $Numeric);
}

function CheckModule($ID)
{
	if(!isset($GLOBALS['CONF']['moduls'][$ID])) 
		$GLOBALS['CONF']['moduls'][$ID] = 1;
	
	return ((!isset($_SESSION) || $_SESSION['authlevel'] == AUTH_USR) && $GLOBALS['CONF']['moduls'][$ID] == 0) ? true : false;
}

function redirectTo($URL)
{
	@session_write_close();
	if($_SERVER['SERVER_PROTOCOL'] == 'HTTP/1.1')
		header('HTTP/1.1 302 Found');
	
	header('Location: '.PROTOCOL.$_SERVER['HTTP_HOST'].HTTP_ROOT.$URL);
	exit;
}

function ClearCache()
{
	$DIRS	= array('cache/');
	foreach($DIRS as $DIR) {
		$FILES = array_diff(scandir($DIR), array('..', '.', '.htaccess'));
		foreach($FILES as $FILE) {
			if(is_dir(ROOT_PATH.$DIR.$FILE))
				continue;
				
			unlink(ROOT_PATH.$DIR.$FILE);
		}
	}
}

function MaxPlanets($Level, $Universe)
{
	return min($GLOBALS['CONFIG'][$Universe]['min_player_planets'] + ceil($Level / 2) * PLANETS_PER_TECH, $GLOBALS['CONFIG'][$Universe]['max_player_planets']);
}

function GetCrons()
{
	global $CONF;
	$Crons	= '';
	$Crons .= TIMESTAMP >= ($CONF['stat_last_update'] + (60 * $CONF['stat_update_time'])) ? '<img src="./cronjobs.php?cron=stats" alt="" height="1" width="1">' : '';
	
	$Crons .= $CONF['ts_modon'] == 1 && TIMESTAMP >= ($CONF['ts_cron_last'] + 60 * $CONF['ts_cron_interval']) ? '<img src="./cronjobs.php?cron=teamspeak" alt="" height="1" width="1">' : '';
	
	$Crons .= TIMESTAMP >= ($CONF['stat_last_db_update'] + 86400) ? '<img src="./cronjobs.php?cron=daily" alt="" height="1" width="1">' : ''; //Daily Cronjob
	
	return $Crons;
}

function r_implode($glue, $pieces)
{
	$retVal	= array();
	foreach($pieces as $r_pieces)
	{
		$retVal[] = is_array($r_pieces) ? r_implode($glue, $r_pieces) : $r_pieces;
	}
	return implode($glue, $retVal);
} 

function allowedTo($side)
{
	return ($GLOBALS['USER']['authlevel'] == AUTH_ADM || $GLOBALS['USER']['rights'][$side] == 1);
}

function isactiveDMExtra($Extra, $Time) {
	return $Time - $Extra <= 0;
}

function DMExtra($Extra, $Time, $true, $false) {
	return isactiveDMExtra($Extra, $Time) ? $true : $false;
}

if(!function_exists('ctype_alnum')):

function ctype_alnum($test){
	return preg_match("/[^A-z0-9_\- ]/", $test) != 1;
}

endif;
?>