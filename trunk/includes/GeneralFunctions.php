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

function unset_vars( $prefix )
{
	$vars = array_keys($GLOBALS);
	for( $n = 0, $i = 0;  $i < count($vars);  $i ++ )
		if( strpos($vars[$i], $prefix) === 0 )
		{
			unset($GLOBALS[$vars[$i]]);
			$n ++;
		}

	return $n;
}

function update_config($config_name, $config_value )
{
	global $game_config, $db;
	if(isset($game_config[$config_name]))
		$db->query("UPDATE ".CONFIG." SET `config_value` = '".$config_value."' WHERE `config_name` = '".$config_name."';");
	else
		$db->query("INSERT INTO ".CONFIG." (`config_name`, `config_value`) VALUES ('".$config_name."', '".$config_value."');");
}

function ValidateAddress($address) {
    if (function_exists('filter_var')) {
		if(filter_var($address, FILTER_VALIDATE_EMAIL) === FALSE) {
			return false;
		} else {
			return true;
		}
    } else {
		return preg_match('/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/', $address);
    }
}

function message ($mes, $dest = "", $time = "3", $topnav = false, $menu = true)
{
	if(defined('IN_ADMIN') || (defined('INSTALL') && INSTALL != false)) {
		display(parsetemplate(gettemplate('adm/message_body'), array('mes' => $mes)), $topnav, (($dest != "") ? "<meta http-equiv=\"refresh\" content=\"$time;URL=$dest\">" : ""), true, (!defined('IN_ADMIN')? $menu : false));
	} else {
		require_once(ROOT_PATH . 'includes/classes/class.template.'.PHP_EXT);
		$template = new template();
		$template->message($mes, $dest, $time, !$topnav);
	}
	exit;
}

function display ($page, $topnav = true, $metatags = '', $AdminPage = false, $menu = true)
{
	global $game_config, $user, $planetrow, $db;
	
	if (!headers_sent()) {
		header('Last-Modified: '.date('D, d M Y H:i:s T'));
		header('Expires: 0');
		header('Pragma: no-cache');
		header('Cache-Control: private, no-store, no-cache, must-revalidate, max-age=0');
		header('Cache-Control: post-check=0, pre-check=0', false); 
	}
	
	$DisplayPage = AdminUserHeader($metatags);
	$DisplayPage .= "\n<center>\n". $page ."\n</center>\n";
	$DisplayPage .= parsetemplate(gettemplate('adm/simple_footer'), $parse);
	
	echo $DisplayPage;
}

function AdminUserHeader ($metatags = '')
{
	global $game_config;

	$parse['title'] 	 = (!defined('IN_ADMIN')) ? "2Moons - Installer" : $game_config['game_name']." - Admin CP";
	$parse['meta'] 		 = $metatags;
	return parsetemplate(gettemplate('adm/simple_header'), $parse);
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

function parsetemplate ($template, $array)
{
	return preg_replace('#\{([a-z0-9\-_]*?)\}#Ssie', '( ( isset($array[\'\1\']) ) ? $array[\'\1\'] : \'\' );', $template);
}

function gettemplate ($templatename)
{
	if(!($temp = @file_get_contents(ROOT_PATH . TEMPLATE_DIR . $templatename . ".tpl")))
	{
		trigger_error("Konnte Templatefile ". $templatename . " nicht finden!", E_USER_WARNING);
	}
	return $temp;
}

function includeLang ($filename, $ext = '.php')
{
	global $lang;

	include_once(ROOT_PATH . "language/".DEFAULT_LANG."/".$filename.$ext);
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

function BuildPlanetAdressLink ( $CurrentPlanet )
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
	return '<font color="#ff0000">' . $n . '</font>';
}

function colorGreen($n)
{
	return '<font color="#00ff00">' . $n . '</font>';
}

function pretty_number($n, $floor = true)
{
	return number_format(($floor) ? floattostring($n) : $n, 0, (!empty($GLOBALS['lang']['locale']['decimal_point']) ? $GLOBALS['lang']['locale']['decimal_point'] : ","), (!empty($GLOBALS['lang']['locale']['thousands_sep']) ? $GLOBALS['lang']['locale']['thousands_sep'] : "."));
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

	if (!isset($_REQUEST[$var_name]) || (is_array($_REQUEST[$var_name]) && !is_array($default)) || (is_array($default) && !is_array($_REQUEST[$var_name])))
	{
		return (is_array($default)) ? array() : $default;
	}

	$var = $_REQUEST[$var_name];
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

function msg_handler($errno, $msg_text, $errfile, $errline)
{
	global  $msg_title, $msg_long_text, $game_config, $db;
	if (!error_reporting()) return false;
	switch ($errno)
	{
		case E_USER_WARNING:
		case E_WARNING:		
			echo "<div style='border: 2px solid red; margin-left: 190.5px; margin-bottom: 1px; padding: 2px; color:#FFFFFF;'><b>[2Moons Debug] PHP Warning </b> in file <b>" . $errfile . "</b> on line <b>" . $errline . "</b>: <b>" . $msg_text . "</b></div>\n";
			return;

		break;	
		case E_STRICT:
			echo "<div style='border: 2px solid red; margin-left: 190.5px; margin-bottom: 1px; padding: 2px;color:#FFFFFF;'><b>[2Moons Debug] PHP Notice </b> in file <b>" . $errfile . "</b> on line <b>" . $errline . "</b>: <b>" . $msg_text . "</b></div>\n";
			return;

		break;
		case E_USER_ERROR:
			@ob_flush();
			@ob_start();
			echo '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">';
			echo '<html>';
			echo '<head>';
			echo '<meta http-equiv="content-type" content="text/html; charset=UTF-8">';
			echo '<meta http-equiv="content-script-type" content="text/javascript">';
			echo '<meta http-equiv="content-style-type" content="text/css">';
			echo '<meta http-equiv="content-language" content="de">';
			echo '<title>'.$game_config['game_name'].' - FATAL ERROR</title>';
			echo '<link rel="shortcut icon" href="./favicon.ico">';
			echo '<link rel="stylesheet" type="text/css" href="styles/css/default.css">';
			echo '<link rel="stylesheet" type="text/css" href="styles/css/formate.css">';
			echo '<link rel="stylesheet" type="text/css" href="'.DEFAULT_SKINPATH.'formate.css">';
			echo '<script type="text/javascript" src="scripts/overlib.js"></script>';
			echo '<script language="JavaScript"> ';
			echo 'function blockError(){return true;} ';
			echo 'window.onerror = blockError; ';
			echo '</script>';
			echo '</head>';
			echo '<body>';
			echo '<table width="80%" align="center">';
			echo '<tr>';
            echo '<th class="errormessage">PHP: ERROR in file <b>' . $errfile . '</b> on line <b>' . $errline . '</b>:<br> <b>' . $msg_text . '</b></th>';
			echo '</tr>';
			echo '</table>';
			echo '</body>';			
			echo '</html>';	
			exit;
		break;
		case E_USER_NOTICE:
			@ob_flush();
			@ob_start();
			echo '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">';
			echo '<html>';
			echo '<head>';
			echo '<meta http-equiv="content-type" content="text/html; charset=UTF-8">';
			echo '<meta http-equiv="content-script-type" content="text/javascript">';
			echo '<meta http-equiv="content-style-type" content="text/css">';
			echo '<meta http-equiv="content-language" content="de">';
			echo '<title>'.$game_config['game_name'].' - FATAL ERROR</title>';
			echo '<link rel="shortcut icon" href="./favicon.ico">';
			echo '<link rel="stylesheet" type="text/css" href="styles/css/default.css">';
			echo '<link rel="stylesheet" type="text/css" href="styles/css/formate.css">';
			echo '<link rel="stylesheet" type="text/css" href="'.DEFAULT_SKINPATH.'formate.css">';
			echo '<script type="text/javascript" src="scripts/overlib.js"></script>';
			echo '<script language="JavaScript"> ';
			echo 'function blockError(){return true;} ';
			echo 'window.onerror = blockError; ';
			echo '</script>';
			echo '</head>';
			echo '<body>';
			echo '<table style="width:80%;position:absolute;top:30%;bottom:50%;left:10%;right:10%;" align="center">';
			echo '<tr>';
			echo '<td class="c">';
			echo 'Informationen:';
			echo '</td>';
			echo '</tr>';
            echo '<th class="errormessage"><b>' . $msg_text . '</b></th>';
			echo '</tr>';
			echo '</table>';
			echo '</body>';			
			echo '</html>';	
			exit;
		break;
	}
	return true;
}

function GetUserByID($UserID, $GetInfo = "*")
{
	global $db;
	
	if(is_array($GetInfo)){
		$GetOnSelect = "";
		foreach($GetInfo as $id => $col)
		{
			$GetOnSelect .= "`".$col."`,";
		}
		$GetOnSelect = substr($GetOnSelect, 0, -1);
	}
	else
		$GetOnSelect = $GetInfo;
	
	$User = $db->fetch_array($db->query("SELECT ".$GetOnSelect." FROM ".USERS." WHERE `id` = '". $UserID ."';"));
	return $User;
}

function MailSend($MailTarget, $MailTargetName, $MailSubject, $MailContent)
{
	global $game_config;
	require_once('./includes/classes/class.phpmailer.php');
	$mail             = new PHPMailer();
	$mail->IsSMTP();
	try{
		$mail->SMTPDebug  = 0;    
		$mail->SMTPAuth   = true;  
		$mail->IsHTML(true);		
		$mail->SMTPSecure = $game_config['smtp_ssl'];  						
		$mail->Host       = $game_config['smtp_host'];
		$mail->Port       = $game_config['smtp_port'];
		$mail->Username   = $game_config['smtp_user'];
		$mail->Password   = $game_config['smtp_pass'];
		$mail->SetFrom($game_config['smtp_sendmail'], $game_config['game_name']);
		$mail->AddAddress($MailTarget, $MailTargetName);
		$mail->Subject    = $MailSubject;
		$mail->AltBody    = strip_tags($MailContent);
		$mail->MsgHTML(makebr($MailContent));
		$mail->Send();
		return true;
	} catch (phpmailerException $e) {
		message($e->errorMessage(), "./", 10, false, false );
	} catch (Exception $e) {
		message($e->getMessage(), "./", 10, false, false );
	}
	
}

function makebr($text, $xhtml = false)
{
    // XHTML FIX for PHP 5.3.0
	// Danke an Meikel
	
    $BR = ($xhtml === true) ? "<br />\n" : "<br>\n";
    return (version_compare(PHP_VERSION, "5.3.0", ">=")) ? nl2br($text, $xhtml) : strtr($text, array("\r\n" => $BR, "\r" => $BR, "\n" => $BR)); 
}

function CheckPlanetIfExist($Galaxy, $System, $Planet, $Planettype = 1)
{
	global $db;
	$QrySelectGalaxy = $db->fetch_array($db->query("SELECT id FROM ".PLANETS." WHERE `galaxy` = '".$Galaxy."' AND `system` = '".$System."' AND `planet` = '".$Planet."' AND `planet_type` = '".$Planettype."';"));
	return (isset($QrySelectGalaxy)) ? true : false;
}


function CheckNoobProtec($OwnerPlayer, $TargetPlayer, $TargetOnline)
{	
	global $game_config;
	
	$Noobplayer			= false;
	$StrongPlayer		= false;
	$IamNoobplayer		= ($OwnerPlayer['total_points'] <= $game_config['noobprotectiontime']) ? true : false;
	$TargetNoobplayer	= ($TargetPlayer['total_points'] <= $game_config['noobprotectiontime']) ? true : false;
	if($TargetOnline >= (time() - 60 * 60 * 24 * 7) && $game_config['noobprotection'])
	{
		$StrongPlayer	= ($OwnerPlayer['total_points'] * 5 < $TargetPlayer['total_points'] && $IamNoobplayer) ? true : false;
		$Noobplayer		= ((round($OwnerPlayer['total_points'] * 0.2) > $TargetPlayer['total_points'] && $IamNoobplayer) || ($TargetNoobplayer && !$IamNoobplayer)) ? true : false;
	}
	return array("NoobPlayer" => $Noobplayer, "StrongPlayer" => $StrongPlayer);
}

function GetRealHostName()
{
	$array = explode(".",$_SERVER['HTTP_HOST']);
	return (count($array) == 3) ? $array[1].".".$array[2] : $_SERVER['HTTP_HOST'];
}

function CheckName($String)
{
	return(ctype_alnum($String) || UTF8_SUPPORT) ? true : false;
}

function isBuggyIe() {
    $ua = $_SERVER['HTTP_USER_AGENT'];
    // quick escape for non-IEs
    if (0 !== strpos($ua, 'Mozilla/4.0 (compatible; MSIE ')
        || false !== strpos($ua, 'Opera')) {
        return false;
    }
    // no regex = faaast
    $version = (float)substr($ua, 30);
    return (
        $version < 6
        || ($version == 6  && false === strpos($ua, 'SV1'))
    );
}

function exception_handler($exception) {
	@ob_flush();
	@ob_start();
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">';
	echo '<html>';
	echo '<head>';
	echo '<meta http-equiv="content-type" content="text/html; charset=UTF-8">';
	echo '<meta http-equiv="content-script-type" content="text/javascript">';
	echo '<meta http-equiv="content-style-type" content="text/css">';
	echo '<meta http-equiv="content-language" content="de">';
	echo '<title>'.$game_config['game_name'].' - FATAL ERROR</title>';
	echo '<link rel="shortcut icon" href="./favicon.ico">';
	echo '<link rel="stylesheet" type="text/css" href="styles/css/default.css">';
	echo '<link rel="stylesheet" type="text/css" href="styles/css/formate.css">';
	echo '<link rel="stylesheet" type="text/css" href="'.DEFAULT_SKINPATH.'formate.css">';
	echo '<script type="text/javascript" src="scripts/overlib.js"></script>';
	echo '<script language="JavaScript"> ';
	echo 'function blockError(){return true;} ';
	echo 'window.onerror = blockError; ';
	echo '</script>';
	echo '</head>';
	echo '<body>';
	echo '<table width="80%" align="center">';
	echo '<tr>';
    echo '<th class="errormessage"><b>'.makebr($exception). '</b></th>';
	echo '</tr>';
	echo '</table>';
	echo '</body>';			
	echo '</html>';	
}

function shortly_number($number)
{
	// MAS DEL TRILLON
	if ($number >= 1000000000000000000000000)
		return pretty_number(($number/1000000000000000000000))."&nbsp;<font color=lime>T+</font>";
	
	// TRILLON
	elseif ($number >= 1000000000000000000 && $number < 1000000000000000000000000)
		return pretty_number(($number/1000000000000000000))."&nbsp;<font color=lime>T</font>";
		
	// BILLON
	elseif ($number >= 1000000000000 && $number < 1000000000000000000)
		return pretty_number(($number/1000000000000))."&nbsp;<font color=lime>B</font>";
	
	// MILLON
	elseif ($number >= 1000000 && $number < 1000000000000)
		return pretty_number(($number/1000000))."&nbsp;<font color=lime>M</font>";
		
	// MIL
	elseif ($number >= 1000 && $number < 1000000)
		return pretty_number(($number/1000))."&nbsp;<font color=lime>K</font>";
	
	// NUMERO SIN DEFINIR	
	else
		return pretty_number($number);
}

function floattostring($Numeric, $Pro = 0, $Output = false){
	return ($Output) ? str_replace(",",".", sprintf("%.".$Pro."f", $Numeric)) : sprintf("%.".$Pro."f", $Numeric);
}

function CheckModule($ID)
{
	return ($GLOBALS['user']['authlevel'] == 0 && $GLOBALS['game_config']['moduls'][$ID] == 0) ? true : false;
}

?>