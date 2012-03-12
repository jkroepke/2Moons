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

function getUniverse()
{
	if(defined('IN_ADMIN') && isset($_SESSION['adminuni'])) {
		$UNI	= (int) $_SESSION['adminuni'];
	} elseif(defined('LOGIN') && isset($_REQUEST['uni'])) {
		$UNI	= (int) $_REQUEST['uni'];
	} elseif(defined('LOGIN') && isset($_COOKIE['uni'])) {
		$UNI	= (int) $_COOKIE['uni'];
	} elseif(UNIS_HTACCESS === true) {
		// Enable htaccess
		if(isset($_SERVER["REDIRECT_UNI"])) {
			$UNI	= $_SERVER["REDIRECT_UNI"];
		} else {
			HTTP::redirectTo("uni".ROOT_UNI."/".basename($_SERVER['SCRIPT_FILENAME']).(!empty($_SERVER["QUERY_STRING"]) ? "?".$_SERVER["QUERY_STRING"]: ""));
		}
	} else {
		if(UNIS_WILDCAST === true) {
			$UNI	= explode('.', $_SERVER['HTTP_HOST']);
			$UNI	= substr($UNI[0], 3);
			if(!is_numeric($UNI))
				$UNI	= ROOT_UNI;
		} else {
			$UNI	= ROOT_UNI;
		}
	}
	
	return $UNI;
}

function getFactors($USER, $Type = 'basic', $TIME = NULL) {
	global $CONF, $resource, $pricelist, $reslist;
	if(empty($TIME))
		$TIME	= TIMESTAMP;
		
	$factor	= array(
		'Attack'			=> 0,
		'Defensive'			=> 0,
		'Shield'			=> 0,
		'BuildTime'			=> 0,
		'ResearchTime'		=> 0,
		'ShipTime'			=> 0,
		'DefensiveTime'		=> 0,
		'Resource'			=> 0,
		'Energy'			=> 0,
		'ResourceStorage'	=> 0,
		'ShipStorage'		=> 0,
		'FlyTime'			=> 0,
		'FleetSlots'		=> 0,
		'Planets'			=> 0,
	);
	
	foreach($reslist['bonus'] as $elementID) {
		$bonus = $pricelist[$elementID]['bonus'];
		
		if (isset($PLANET[$resource[$elementID]])) {
			$elementLevel = $PLANET[$resource[$elementID]];
		} elseif (isset($USER[$resource[$elementID]])) {
			$elementLevel = $USER[$resource[$elementID]];
		} else {
			continue;
		}
		
		if(in_array($elementID, $reslist['dmfunc'])) {
			if(DMExtra($elementLevel, $TIME, false, true)) {
				continue;
			}
			
			$factor['Attack']			+= $bonus['Attack'];
			$factor['Defensive']		+= $bonus['Defensive'];
			$factor['Shield']			+= $bonus['Shield'];
			$factor['BuildTime']		+= $bonus['BuildTime'];
			$factor['ResearchTime']		+= $bonus['ResearchTime'];
			$factor['ShipTime']			+= $bonus['ShipTime'];
			$factor['DefensiveTime']	+= $bonus['DefensiveTime'];
			$factor['Resource']			+= $bonus['Resource'];
			$factor['Energy']			+= $bonus['Energy'];
			$factor['ResourceStorage']	+= $bonus['ResourceStorage'];
			$factor['ShipStorage']		+= $bonus['ShipStorage'];
			$factor['FlyTime']			+= $bonus['FlyTime'];
			$factor['FleetSlots']		+= $bonus['FleetSlots'];
			$factor['Planets']			+= $bonus['Planets'];
		} else {
			$factor['Attack']			+= $elementLevel * $bonus['Attack'];
			$factor['Defensive']		+= $elementLevel * $bonus['Defensive'];
			$factor['Shield']			+= $elementLevel * $bonus['Shield'];
			$factor['BuildTime']		+= $elementLevel * $bonus['BuildTime'];
			$factor['ResearchTime']		+= $elementLevel * $bonus['ResearchTime'];
			$factor['ShipTime']			+= $elementLevel * $bonus['ShipTime'];
			$factor['DefensiveTime']	+= $elementLevel * $bonus['DefensiveTime'];
			$factor['Resource']			+= $elementLevel * $bonus['Resource'];
			$factor['Energy']			+= $elementLevel * $bonus['Energy'];
			$factor['ResourceStorage']	+= $elementLevel * $bonus['ResourceStorage'];
			$factor['ShipStorage']		+= $elementLevel * $bonus['ShipStorage'];
			$factor['FlyTime']			+= $elementLevel * $bonus['FlyTime'];
			$factor['FleetSlots']		+= $elementLevel * $bonus['FleetSlots'];
			$factor['Planets']			+= $elementLevel * $bonus['Planets'];
		}
	}
	
	return $factor;
}

function getPlanets($USER)
{
		if(isset($USER['PLANETS']))
		return $USER['PLANETS'];
		
	$Order = $USER['planet_sort_order'] == 1 ? "DESC" : "ASC" ;
	$Sort  = $USER['planet_sort'];

	$QryPlanets  = "SELECT `id`, `name`, `galaxy`, `system`, `planet`, `planet_type`, `image`, `b_building`, `b_building_id` FROM ".PLANETS." WHERE `id_owner` = '".$USER['id']."' AND `destruyed` = '0' ORDER BY ";

	if($Sort == 0)
		$QryPlanets .= "`id` ". $Order;
	elseif($Sort == 1)
		$QryPlanets .= "`galaxy`, `system`, `planet`, `planet_type` ". $Order;
	elseif ($Sort == 2)
		$QryPlanets .= "`name` ". $Order;

	$PlanetRAW = $GLOBALS['DATABASE']->query($QryPlanets);
	
	while($Planet = $GLOBALS['DATABASE']->fetch_array($PlanetRAW))
		$Planets[$Planet['id']]	= $Planet;

	$GLOBALS['DATABASE']->free_result($PlanetRAW);
	return $Planets;
}

function get_timezone_selector() {
	global $LNG;
	
	// New Timezone Selector, better support for changes in tzdata (new russian timezones, e.g.)
	// http://www.php.net/manual/en/datetimezone.listidentifiers.php
	
	$timezones = array();
	$timezone_identifiers = DateTimeZone::listIdentifiers();

	foreach( $timezone_identifiers as $value )
	{
		if ( preg_match( '/^(America|Antartica|Arctic|Asia|Atlantic|Europe|Indian|Pacific)\//', $value ) )
		{
			$ex=explode('/',$value); //obtain continent,city
			$city = isset($ex[2])? $ex[1].' - '.$ex[2]:$ex[1]; //in case a timezone has more than one
			$timezones[$ex[0]][$value] = str_replace('_', ' ', $city);
		}
	}
	return $timezones; 
}

function locale_date_format($format, $time, $LNG = NULL) {

	//Workaound for locale Names.

	if(!isset($LNG)) {
		$LNG	= $GLOBALS['LNG'];		
	}
	
	$weekDay	= date('w', $time);
	$months		= date('n', $time) - 1;
	
	$format     = str_replace(array('D', 'M'), array('$D$', '$M$'), $format);
	$format		= str_replace('$D$', addcslashes($LNG['week_day'][$weekDay], 'A..z'), $format);
	$format		= str_replace('$M$', addcslashes($LNG['months'][$months], 'A..z'), $format);
	
	return $format;
}

function _date($format, $time = null, $toTimeZone = null, $LNG = NULL) {
	global $CONF;
	
	if(!isset($time)) {
		$time	= TIMESTAMP;
	}
	
	if(isset($toTimeZone))
	{
		$date = new DateTime();
		if(method_exists($date, 'setTimestamp'))
		{	// PHP > 5.3			
			$date->setTimestamp($time);
		} else {
			// PHP < 5.3
			$tempDate = getdate((int) $time);
			$date->setDate($tempDate['year'], $tempDate['mon'], $tempDate['mday']);
			$date->setTime($tempDate['hours'], $tempDate['minutes'], $tempDate['seconds']);
		}
		
		$time	-= $date->getOffset();
		try {
			$date->setTimezone(new DateTimeZone($toTimeZone));
		} catch (Exception $e) {
			
		}
		$time	+= $date->getOffset();
	}
	
	$format	= locale_date_format($format, $time, $LNG);
	return date($format, $time);
}

function update_config($Values, $UNI = 0)
{
	global $CONF;
	$SQLBASE	= "";
	$SQLUNI		= "";
	$UNI		= (empty($UNI)) ? $GLOBALS['UNI'] : $UNI;
	$BasicConf	= array('VERSION', 'game_name', 'stat', 'stat_level', 'stat_last_update', 'stat_settings', 'stat_update_time', 'stat_last_db_update', 'stats_fly_lock', 'cron_lock', 'ts_modon', 'ts_server', 'ts_tcpport', 'ts_udpport', 'ts_timeout', 'ts_version', 'ts_cron_last', 'ts_cron_interval', 'ts_login', 'ts_password', 'capaktiv', 'cappublic', 'capprivate', 'mail_active', 'mail_use', 'smtp_host', 'smtp_port', 'smtp_user', 'smtp_pass', 'smtp_ssl', 'smtp_sendmail', 'smail_path', 'fb_on', 'fb_apikey', 'fb_skey', 'ga_active', 'ga_key', 'chat_closed', 'chat_allowchan', 'chat_allowmes', 'chat_allowdelmes', 'chat_logmessage', 'chat_nickchange', 'chat_botname', 'chat_channelname', 'chat_socket_active', 'chat_socket_host', 'chat_socket_ip', 'chat_socket_port', 'chat_socket_chatid', 'ttf_file', 'sendmail_inactive', 'del_user_sendmail', 'del_user_automatic', 'del_oldstuff', 'del_user_manually', 'ref_max_referals');
	
	foreach($Values as $Name => $Value) {
		if(!isset($CONF[$Name]))
			continue;
			
		$GLOBALS['CONFIG'][$UNI][$Name]	= $Value;
		
		$CONF[$Name]	= $Value;
		if(in_array($Name, $BasicConf))
			$SQLBASE	.= "`".$Name."` = '".$GLOBALS['DATABASE']->sql_escape($Value)."', ";
		else
			$SQLUNI		.= "`".$Name."` = '".$GLOBALS['DATABASE']->sql_escape($Value)."', ";
	}
	if(!empty($SQLBASE))
		$GLOBALS['DATABASE']->query("UPDATE ".CONFIG." SET ".substr($SQLBASE, 0, -2).";");
	
	if(!empty($SQLUNI))
		$GLOBALS['DATABASE']->query("UPDATE ".CONFIG." SET ".substr($SQLUNI, 0, -2)." WHERE `uni` = '".$UNI."';");
	
}

function getConfig($UNI) {
		if(isset($GLOBALS['CONFIG'][$UNI]))
		return $GLOBALS['CONFIG'][$UNI];
		
	$CONF = $GLOBALS['DATABASE']->uniquequery("SELECT HIGH_PRIORITY * FROM `".CONFIG."` WHERE `uni` = '".$UNI."';");
	if(!isset($CONF))
		HTTP::redirectTo('index.php');
		
	$CONF['moduls']			= explode(";", $CONF['moduls']);

	
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
	return '<a href="game.php?page=galaxy&amp;galaxy='.$FleetRow['fleet_start_galaxy'].'&amp;system='.$FleetRow['fleet_start_system'].'" class="'. $FleetType .'">['.$FleetRow['fleet_start_galaxy'].':'.$FleetRow['fleet_start_system'].':'.$FleetRow['fleet_start_planet'].']</a>';
}

function GetTargetAdressLink($FleetRow, $FleetType)
{
	return '<a href="game.php?page=galaxy&amp;galaxy='.$FleetRow['fleet_end_galaxy'].'&amp;system='.$FleetRow['fleet_end_system'].'" class="'. $FleetType .'">['.$FleetRow['fleet_end_galaxy'].':'.$FleetRow['fleet_end_system'].':'.$FleetRow['fleet_end_planet'].']</a>';
}

function BuildPlanetAdressLink($CurrentPlanet)
{
	return '<a href="game.php?page=galaxy&amp;galaxy='.$CurrentPlanet['galaxy'].'&amp;system='.$CurrentPlanet['system'].'">['.$CurrentPlanet['galaxy'].':'.$CurrentPlanet['system'].':'.$CurrentPlanet['planet'].']</a>';
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
	return number_format(floattostring($n, $dec), $dec, ',', '.');
}

function GetUserByID($UserID, $GetInfo = "*")
{
		
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
	
	$User = $GLOBALS['DATABASE']->uniquequery("SELECT ".$GetOnSelect." FROM ".USERS." WHERE `id` = '". $UserID ."';");
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
		$QrySelectGalaxy = $GLOBALS['DATABASE']->countquery("SELECT COUNT(*) FROM ".PLANETS." WHERE `universe` = '".$Universe."' AND `galaxy` = '".$Galaxy."' AND `system` = '".$System."' AND `planet` = '".$Planet."' AND `planet_type` = '".$Planettype."';");
	return $QrySelectGalaxy ? true : false;
}

function CheckNoobProtec($OwnerPlayer, $TargetPlayer, $Player)
{	
	global $CONF;
	if(
		$CONF['noobprotection'] == 0 
		|| $CONF['noobprotectiontime'] == 0 
		|| $CONF['noobprotectionmulti'] == 0 
		|| $Player['banaday'] > TIMESTAMP
		|| $Player['onlinetime'] < TIMESTAMP - INACTIVE
	) {
		return array('NoobPlayer' => false, 'StrongPlayer' => false);
	}
	
	return array(
		'NoobPlayer' => (
			/* WAHR: 
				Wenn Spieler mehr als 25000 Punkte hat UND
				Wenn ZielSpieler weniger als 80% der Punkte des Spieler hat.
				ODER weniger als 5.000 hat.
			*/
			// Addional Comment: Letzteres ist eigentlich sinnfrei, bitte testen.a
			($TargetPlayer['total_points'] <= $CONF['noobprotectiontime']) && // Default: 25.000
			($OwnerPlayer['total_points'] > $TargetPlayer['total_points'] * $CONF['noobprotectionmulti'])
		), 
		'StrongPlayer' => (
			/* WAHR: 
				Wenn Spieler weniger als 5000 Punkte hat UND
				Mehr als das funfache der eigende Punkte hat
			*/
			($OwnerPlayer['total_points'] < $CONF['noobprotectiontime']) && // Default: 5.000
			($OwnerPlayer['total_points'] * $CONF['noobprotectionmulti'] < $TargetPlayer['total_points'])
		),
	);
}

function CheckName($name)
{
	if(UTF8_SUPPORT) {
		return preg_match("/^[A-z0-9_\-. ]*$/", $name);
	} else {
		return preg_match("/^[\p{L}_\-. ]*$/u", $name);
	}
}

function SendSimpleMessage($Owner, $Sender, $Time, $Type, $From, $Subject, $Message)
{
			
	$SQL	= "INSERT INTO ".MESSAGES." SET 
	`message_owner` = ".(int) $Owner.", 
	`message_sender` = ".(int) $Sender.", 
	`message_time` = ".(int) $Time.", 
	`message_type` = ".(int) $Type.", 
	`message_from` = '".$GLOBALS['DATABASE']->sql_escape($From) ."', 
	`message_subject` = '". $GLOBALS['DATABASE']->sql_escape($Subject) ."', 
	`message_text` = '".$GLOBALS['DATABASE']->sql_escape($Message)."', 
	`message_unread` = '1', 
	`message_universe` = ".$GLOBALS['UNI'].";";

	$GLOBALS['DATABASE']->query($SQL);
}

function shortly_number($number, $decial = NULL)
{
	$negate	= $number < 0 ? -1 : 1;
	$number	= abs($number);
    $unit	= array("", "K", "M", "B", "T", "Q", "Q+", "S", "S+", "O", "N");
	$key	= 0;
	
	if($number >= 1000000) {
		++$key;
		while($number >= 1000000)
		{
			++$key;
			$number = $number / 1000000;
		}
	} elseif($number >= 1000) {
		++$key;
		$number = $number / 1000;
	}
	
	$decial	= !is_numeric($decial) ? ((int) ($number != 0 && $number < 100)) : $decial;
	
	return pretty_number($negate * $number, $decial).'&nbsp;'.$unit[$key];
}

function floattostring($Numeric, $Pro = 0, $Output = false){
	return ($Output) ? str_replace(",",".", sprintf("%.".$Pro."f", $Numeric)) : sprintf("%.".$Pro."f", $Numeric);
}

function isModulAvalible($ID)
{
	if(!isset($GLOBALS['CONF']['moduls'][$ID])) 
		$GLOBALS['CONF']['moduls'][$ID] = 1;
	
	return $GLOBALS['CONF']['moduls'][$ID] == 1 || (isset($_SESSION) && $_SESSION['authlevel'] > AUTH_USR);
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
	// http://owiki.de/index.php/Astrophysik#.C3.9Cbersicht
	return min($GLOBALS['CONFIG'][$Universe]['min_player_planets'] + ceil($Level / 2) * PLANETS_PER_TECH, $GLOBALS['CONFIG'][$Universe]['max_player_planets']);
}

function allowPlanetPosition($Pos, $techLevel)
{
	// http://owiki.de/index.php/Astrophysik#.C3.9Cbersicht
	
	switch($Pos) {
		case 1:
		case 15:
			return $techLevel >= 8;
		break;
		case 2:
		case 14:
			return $techLevel >= 6;
		break;
		case 3:
		case 13:
			return $techLevel >= 4;
		break;
		default:
			return $techLevel >= 1;
		break;
	}
	
	
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
	global $USER;
	return ($USER['authlevel'] == AUTH_ADM || (isset($USER['rights']) && $USER['rights'][$side] == 1));
}

function isactiveDMExtra($Extra, $Time) {
	return $Time - $Extra <= 0;
}

function DMExtra($Extra, $Time, $true, $false) {
	return isactiveDMExtra($Extra, $Time) ? $true : $false;
}

function getRandomString() {
	return md5(uniqid());
}

function isVacationMode($USER)
{
	return ($USER['urlaubs_modus'] == 1) ? true : false;
}

function cryptPassword($password)
{
	// http://www.phpgangsta.de/schoener-hashen-mit-bcrypt
	global $resource, $salt;
	if(!CRYPT_BLOWFISH || !isset($salt))
	{
		return md5($password);
	} else {
		return crypt($password, '$2a$09$'.$salt.'$');
	}
}

function clearGIF() {
	header('Cache-Control: no-cache');
	header('Content-type: image/gif');
	header('Content-length: 43');
	header('Expires: 0');
	echo("\x47\x49\x46\x38\x39\x61\x01\x00\x01\x00\x80\x00\x00\x00\x00\x00\x00\x00\x00\x21\xF9\x04\x01\x00\x00\x00\x00\x2C\x00\x00\x00\x00\x01\x00\x01\x00\x00\x02\x02\x44\x01\x00\x3B");
	exit;
}

function exceptionHandler($exception) 
{
	global $CONF;
	if(!headers_sent()) {
		if (!class_exists('HTTP', false)) {
			require_once(ROOT_PATH . 'includes/classes/HTTP.class.php');
		}
		
		HTTP::sendHeader('HTTP/1.1 503 Service Unavailable');
	}
	
	if(method_exists($exception, 'getSeverity')) {
		$errno	= $exception->getSeverity();
	} else {
		$errno	= E_USER_ERROR;
	}
	
	$errorType = array(
		E_ERROR				=> 'ERROR',
		E_WARNING			=> 'WARNING',
		E_PARSE				=> 'PARSING ERROR',
		E_NOTICE			=> 'NOTICE',
		E_CORE_ERROR		=> 'CORE ERROR',
		E_CORE_WARNING   	=> 'CORE WARNING',
		E_COMPILE_ERROR		=> 'COMPILE ERROR',
		E_COMPILE_WARNING	=> 'COMPILE WARNING',
		E_USER_ERROR		=> 'USER ERROR',
		E_USER_WARNING		=> 'USER WARNING',
		E_USER_NOTICE		=> 'USER NOTICE',
		E_STRICT			=> 'STRICT NOTICE',
		E_RECOVERABLE_ERROR	=> 'RECOVERABLE ERROR'
	);
	
	$VERSION	= isset($CONF['VERSION']) ? $CONF['VERSION'] : 'UNKNOWN';
	$DIR		= MODE == 'INSTALL' ? '..' : '.';
	echo '<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="de" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="de" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="de" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="de" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="de" class="no-js"> <!--<![endif]-->
<head>
	<title>'.(isset($CONF['game_name']) ? $CONF['game_name'].' - ' : '').$errorType[$errno].'</title>
	<meta name="generator" content="2Moons '.$VERSION.'">
	<!-- 
		This website is powered by 2Moons '.$VERSION.'
		2Moons is a free Space Browsergame initially created by Jan Kröpke and licensed under GNU/GPL.
		2Moons is copyright 2009-2012 of Jan Kröpke. Extensions are copyright of their respective owners.
		Information and contribution at http://2moons.cc/
	-->
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="'.$DIR.'/styles/css/boilerplate.css?v='.$VERSION.'">
	<link rel="stylesheet" type="text/css" href="'.$DIR.'/styles/css/ingame.css?v='.$VERSION.'">
	<link rel="stylesheet" type="text/css" href="'.$DIR.'/styles/theme/gow/formate.css?v='.$VERSION.'">
	<link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
	<script type="text/javascript">
	var ServerTimezoneOffset = -3600;
	var serverTime 	= new Date(2012, 2, 12, 14, 43, 36);
	var startTime	= serverTime.getTime();
	var localTime 	= serverTime;
	var localTS 	= startTime;
	var Gamename	= document.title;
	var Ready		= "Fertig";
	var Skin		= "'.$DIR.'/styles/theme/gow/";
	var Lang		= "de";
	var head_info	= "Information";
	var auth		= 3;
	var days 		= ["So","Mo","Di","Mi","Do","Fr","Sa"] 
	var months 		= ["Jan","Feb","Mar","Apr","Mai","Jun","Jul","Aug","Sep","Okt","Nov","Dez"] ;
	var tdformat	= "[M] [D] [d] [H]:[i]:[s]";
	var queryString	= "";

	setInterval(function() {
		serverTime.setSeconds(serverTime.getSeconds()+1);
	}, 1000);
	</script>
	<script type="text/javascript" src="'.$DIR.'/scripts/base/jquery.js?v=2123"></script>
	<script type="text/javascript" src="'.$DIR.'/scripts/base/jquery.ui.js?v=2123"></script>
	<script type="text/javascript" src="'.$DIR.'/scripts/base/jquery.cookie.js?v=2123"></script>
	<script type="text/javascript" src="'.$DIR.'/scripts/base/jquery.fancybox.js?v=2123"></script>
	<script type="text/javascript" src="'.$DIR.'/scripts/base/jquery.validationEngine.js?v=2123"></script>
	<script type="text/javascript" src="'.$DIR.'/scripts/base/tooltip.js?v=2123"></script>
	<script type="text/javascript" src="'.$DIR.'/scripts/game/base.js?v=2123"></script>
</head>
<body id="overview" class="full">
<table width="960">
	<tr>
		<th>'.$errorType[$errno].'</th>
	</tr>
	<tr>
		<td class="left">
			<b>Message: </b>'.$exception->getMessage().'<br>
			<b>File: </b>'.$exception->getFile().'<br>
			<b>Line: </b>'.$exception->getLine().'<br>
			<b>URL: </b>'.PROTOCOL.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].(!empty($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING']: '').'<br>
			<b>PHP-Version: </b>'.PHP_VERSION.'<br>
			<b>PHP-API: </b>'.php_sapi_name().'<br>
			<b>MySQL-Cleint-Version: </b>'.mysqli_get_client_info().'<br>
			<b>2Moons Version: </b>'.$CONF['VERSION'].'<br>
			<b>Debug Backtrace:</b><br>'.makebr(str_replace($_SERVER['DOCUMENT_ROOT'], '.', htmlspecialchars($exception->getTraceAsString()))).'
		</td>
	</tr>
</table>
</body>
</html>';
	if($errno === 0) {
		ini_set('display_errors', 0);
		trigger_error("Exception: ".str_replace("<br>", "\r\n", $errstr)."\r\n\r\n".str_replace($_SERVER['DOCUMENT_ROOT'], '.', $exception->getTraceAsString()), E_USER_ERROR);
	}
	exit;
}

function errorHandler($errno, $errstr, $errfile, $errline)
{
    if (error_reporting() == 0) {
        return;
    }
	
	throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}
?>