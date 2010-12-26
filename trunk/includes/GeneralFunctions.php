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

function update_config($Values, $Global = false, $SpecUni = 0)
{
	global $CONF, $db;
	$SQL	= "";
	$UNI	= (empty($SpecUni)) ? $GLOBALS['UNI'] : $SpecUni;
	
	foreach($Values as $Name => $Value) {
		if(!isset($CONF[$Name]))
			continue;
			
		$CONF[$Name]	= $Value;
		$SQL	.= "`".$Name."` = '".$db->sql_escape($Value)."', ";
	}
	$db->query("UPDATE ".CONFIG." SET ".substr($SQL, 0, -2).(!$Global ? " WHERE `uni` = '".$UNI."'":"").";");
}

function ValidateAddress($address) {
    if (function_exists('filter_var')) {
		return filter_var($address, FILTER_VALIDATE_EMAIL) !== FALSE;
    } else {
		return preg_match('/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/', $address);
    }
}

function message($mes, $dest = "", $time = "3", $topnav = false, $menu = true)
{
	require_once(ROOT_PATH . 'includes/classes/class.template.'.PHP_EXT);
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

	if ($hs < 10) { $hh = "0" . $hs; } else { $hh = $hs; }
	if ($ms < 10) { $mm = "0" . $ms; } else { $mm = $ms; }
	if ($sr < 10) { $ss = "0" . $sr; } else { $ss = $sr; }

	$time = '';
	if ($day != 0) { $time .= $day . 'd '; }
	if ($hs  != 0) { $time .= $hh . 'h ';  } else { $time .= '00h '; }
	if ($ms  != 0) { $time .= $mm . 'm ';  } else { $time .= '00m '; }
	$time .= $ss . 's';

	return $time;
}

function pretty_time_hour ($seconds)
{
	$min = floor($seconds / 60 % 60);
	$time = '';
	if ($min != 0) { $time .= $min . 'min '; }
	return $time;
}

function GetStartAdressLink ( $FleetRow, $FleetType )
{
	$Link  = "<a href=\"game.php?page=galaxy&amp;mode=3&amp;galaxy=".$FleetRow['fleet_start_galaxy']."&amp;system=".$FleetRow['fleet_start_system']."\" class=\"". $FleetType ."\">";
	$Link .= "[".$FleetRow['fleet_start_galaxy'].":".$FleetRow['fleet_start_system'].":".$FleetRow['fleet_start_planet']."]</a>";
	return $Link;
}

function GetTargetAdressLink ( $FleetRow, $FleetType )
{
	$Link  = "<a href=\"game.php?page=galaxy&amp;mode=3&amp;galaxy=".$FleetRow['fleet_end_galaxy']."&amp;system=".$FleetRow['fleet_end_system']."\" class=\"". $FleetType ."\">";
	$Link .= "[".$FleetRow['fleet_end_galaxy'].":".$FleetRow['fleet_end_system'].":".$FleetRow['fleet_end_planet']."]</a>";
	return $Link;
}

function BuildPlanetAdressLink($CurrentPlanet)
{
	$Link  = "<a href=\"game.php?page=galaxy&amp;mode=3&amp;galaxy=".$CurrentPlanet['galaxy']."&amp;system=".$CurrentPlanet['system']."\">";
	$Link .= "[".$CurrentPlanet['galaxy'].":".$CurrentPlanet['system'].":".$CurrentPlanet['planet']."]</a>";
	return $Link;
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
	return $Negative ? round(request_var($var_name, 0.0), 0) : max(round(request_var($var_name, 0.0), 0), 0) ;
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
	$mail             = new PHPMailer(true);
	$mail->IsSMTP();
	try{
		$mail->SMTPDebug  = 0;    
		$mail->SMTPAuth   = true;  
		$mail->IsHTML(true);		
		$mail->SMTPSecure = $CONF['smtp_ssl'];  						
		$mail->Host       = $CONF['smtp_host'];
		$mail->Port       = $CONF['smtp_port'];
		$mail->Username   = $CONF['smtp_user'];
		$mail->Password   = $CONF['smtp_pass'];
		$mail->SetFrom($CONF['smtp_sendmail'], $CONF['game_name']);
		$mail->AddAddress($MailTarget, $MailTargetName);
		$mail->Subject    = $MailSubject;
		$mail->AltBody    = strip_tags($MailContent);
		$mail->MsgHTML(makebr($MailContent));
		$mail->Send();
		return true;
	} catch (phpmailerException $e) {
		return $e->errorMessage();
	} catch (Exception $e) {
		return $e->getMessage();
	}
	
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

function CheckNoobProtec($OwnerPlayer, $TargetPlayer, $TargetOnline)
{	
	global $CONF;
	
	$Noobplayer			= false;
	$StrongPlayer		= false;
	$IamNoobplayer		= ($OwnerPlayer['total_points'] <= $CONF['noobprotectiontime']) ? true : false;
	$TargetNoobplayer	= ($TargetPlayer['total_points'] <= $CONF['noobprotectiontime']) ? true : false;
	if($TargetOnline >= (TIMESTAMP - 60 * 60 * 24 * 7) && $CONF['noobprotection'])
	{
		$StrongPlayer	= ($OwnerPlayer['total_points'] * 5 < $TargetPlayer['total_points'] && $IamNoobplayer) ? true : false;
		$Noobplayer		= ((round($OwnerPlayer['total_points'] * 0.2) > $TargetPlayer['total_points'] && $IamNoobplayer) || ($TargetNoobplayer && !$IamNoobplayer)) ? true : false;
	}
	return array("NoobPlayer" => $Noobplayer, "StrongPlayer" => $StrongPlayer);
}

function CheckName($String)
{
	return(ctype_alnum($String) || (UTF8_SUPPORT && !empty($String))) ? true : false;
}

function exception_handler($exception) {
	global $CONF;
		
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">';
	echo '<html>';
	echo '<head>';
	echo '<meta http-equiv="content-type" content="text/html; charset=UTF-8">';
	echo '<meta http-equiv="content-script-type" content="text/javascript">';
	echo '<meta http-equiv="content-style-type" content="text/css">';
	echo '<meta http-equiv="content-language" content="de">';
	echo '<title>'.$CONF['game_name'].' - FATAL ERROR</title>';
	echo '<link rel="shortcut icon" href="./favicon.ico">';
	echo '<link rel="stylesheet" type="text/css" href="'.DEFAULT_SKINPATH.'formate.css">';
	echo '<script type="text/javascript"> ';
	echo 'function blockError(){return true;} ';
	echo 'window.onerror = blockError; ';
	echo '</script>';
	echo '</head>';
	echo '<body>';
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
    echo '<b>PHP-Version: </b>'.PHP_VERSION.'<br>';
    echo '<b>PHP-API: </b>'.php_sapi_name().'<br>';
    echo '<b>2Moons Version: </b>'.VERSION.'<br>';
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
	
	return ((!isset($_SESSION) || $_SESSION['authlevel'] == 0) && $GLOBALS['CONF']['moduls'][$ID] == 0) ? true : false;
}

function redirectTo($URL)
{
	if($_SERVER['SERVER_PROTOCOL'] == 'HTTP/1.1')
		header('HTTP/1.1 303 See Other');
	
	header('Location: '.PROTOCOL.$_SERVER['HTTP_HOST'].HTTP_ROOT.$URL);
	exit;
}

function ClearCache()
{
	$DIRS	= array('cache/UserBanner/', 'cache/');
	foreach($DIRS as $DIR) {
		$FILES = array_diff(scandir($DIR), array('..', '.', '.htaccess'));
		foreach($FILES as $FILE) {
			if(is_dir(ROOT_PATH.$DIR.$FILE))
				continue;
				
			unlink(ROOT_PATH.$DIR.$FILE);
		}
	}
}

function MaxPlanets($Level)
{
	$MaxPlanets = STANDART_PLAYER_PLANETS + ceil($Level / 2) * PLANETS_PER_TECH;
	return MAX_PLANETS == -1 ? $MaxPlanets : min($MaxPlanets, MAX_PLANETS);
}

function GetCrons()
{
	global $CONF;
	$Crons	= '';
	if(TIMESTAMP >= ($CONF['stat_last_update'] + (60 * $CONF['stat_update_time'])))
		$Crons	.= '<img src="./cronjobs.php?cron=stats" alt="" height="1" width="1">';
	if($CONF['ts_modon'] == 1 && TIMESTAMP >= ($CONF['ts_cron_last'] + 60 * $CONF['ts_cron_interval']))
		$Crons	.= '<img src="./cronjobs.php?cron=teamspeak" alt="" height="1" width="1">';
	if(TIMESTAMP >= ($CONF['stat_last_db_update'] + 86400)) //Daily Cronjob
		$Crons	.= '<img src="./cronjobs.php?cron=daily" alt="" height="1" width="1">';
	return $Crons;
}

function GetTeamspeakData()
{
	global $CONF, $USER, $LNG;
	if ($CONF['ts_modon'] == 0)
		return false;
	elseif(!file_exists(ROOT_PATH.'cache/teamspeak_cache.php'))
		return $LNG['ov_teamspeak_not_online'];
	
	$Data		= unserialize(file_get_contents(ROOT_PATH.'cache/teamspeak_cache.php'));
	if(!is_array($Data))
		return $LNG['ov_teamspeak_not_online'];
		
	$Teamspeak 	= '';			

	if($CONF['ts_version'] == 2) {
		$trafges 	= pretty_number($Data[1]['total_bytessend'] / 1048576 + $Data[1]['total_bytesreceived'] / 1048576);
		$Teamspeak	= sprintf($LNG['ov_teamspeak_v2'], $CONF['ts_server'], $CONF['ts_udpport'], $USER['username'], $Data[0]["server_currentusers"], $Data[0]["server_maxusers"], $Data[0]["server_currentchannels"], $trafges);
	} elseif($CONF['ts_version'] == 3){
		$trafges 	= pretty_number($Data['data']['connection_bytes_received_total'] / 1048576 + $Data['data']['connection_bytes_sent_total'] / 1048576);
		$Teamspeak	= sprintf($LNG['ov_teamspeak_v3'], $CONF['ts_server'], $CONF['ts_tcpport'], $USER['username'], $Data['data']['virtualserver_password'], ($Data['data']['virtualserver_clientsonline'] - 1), $Data['data']['virtualserver_maxclients'], $Data['data']['virtualserver_channelsonline'], $trafges);
	}
	return $Teamspeak;
}

function r_implode($glue, $pieces)
{
	$retVal	= array();
	foreach($pieces as $r_pieces)
	{
		if(is_array($r_pieces))
			$retVal[] = r_implode($glue, $r_pieces);
		else
			$retVal[] = $r_pieces;
	}
	return implode($glue, $retVal);
} 


//Math Functions

function HLadd($Num1, $Num2) {
	return ($GLOBALS['BCMATH'] === true) ? bcadd($Num1, $Num2, 0) : ($Num1 + $Num2); // && ($Num1 > PHP_INT_MAX || $Num2 > PHP_INT_MAX)
}

function HLsub($Num1, $Num2) {
	return ($GLOBALS['BCMATH'] === true) ? bcsub($Num1, $Num2, 0) : ($Num1 - $Num2); // && ($Num1 > PHP_INT_MAX || $Num2 > PHP_INT_MAX)
}

function HLmul($Num1, $Num2) {
	return ($GLOBALS['BCMATH'] === true) ? bcmul($Num1, $Num2, 0) : ($Num1 * $Num2); // && ($Num1 > PHP_INT_MAX || $Num2 > PHP_INT_MAX)
}

function HLdiv($Num1, $Num2) {
	return ($GLOBALS['BCMATH'] === true) ? bcdiv($Num1, $Num2, 0) : ($Num1 / $Num2); // && ($Num1 > PHP_INT_MAX || $Num2 > PHP_INT_MAX)
}

if(!function_exists('ctype_alnum'))
{
    function ctype_alnum($test){
        return preg_match("/[^A-z0-9_\- ]/", $test) != 1;
    }
}
?>