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
	global $game_config,$db;
	if(isset($game_config[$config_name]))
		$db->query("UPDATE ".CONFIG." SET `config_value` = '".$config_value."' WHERE `config_name` = '".$config_name."';");
	else
		$db->query("INSERT INTO ".CONFIG." (`config_name`, `config_value`) VALUES ('".$config_name."', '".$config_value."');");
}

function is_email($email)
{
	return (preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i", $email));
}

function message ($mes, $dest = "", $time = "3", $topnav = false, $menu = true)
{
	$parse['mes']   = $mes;

	$page = parsetemplate(gettemplate('global/message_body'), $parse);

	display ($page, $topnav, (($dest != "") ? "<meta http-equiv=\"refresh\" content=\"$time;URL=$dest\">" : ""), false, (!defined('IN_ADMIN') ? $menu : false));

	exit;
}

function display ($page, $topnav = true, $metatags = '', $AdminPage = false, $menu = true)
{
	global $game_config, $user, $planetrow, $xgp_root, $phpEx, $db;
	
	if (!headers_sent()) {
		header('Last-Modified: '.date('D, d M Y H:i:s T'));
		header('Expires: 0');
		header('Pragma: no-cache');
		header('Cache-Control: private, no-store, no-cache, must-revalidate, max-age=0');
		header('Cache-Control: post-check=0, pre-check=0', false); 
	}
	
	$DisplayPage = (!$AdminPage) ? StdUserHeader($metatags) : AdminUserHeader($metatags);

	if ($topnav)
	{
		include_once($xgp_root . 'includes/functions/ShowTopNavigationBar.' . $phpEx);
		$DisplayPage .= ShowTopNavigationBar( $user, $planetrow );
	}

	if ($menu && !$AdminPage)
	{
		include_once($xgp_root . 'includes/functions/ShowLeftMenu.' . $phpEx);
		$DisplayPage .= ShowLeftMenu ($user['authlevel']);
	}
    if ($menu && !$AdminPage && $user['settings_planetmenu'] == 1)
    {
        include_once($xgp_root . 'includes/functions/ShowPlanetMenu.' . $phpEx);
        $DisplayPage .= ShowPlanetMenu ($user, $planetrow);
    } 
	$DisplayPage .= "\n<center>\n". $page ."\n</center>\n";
	if(!defined('LOGIN') && $_GET['page'] != 'galaxy'){
		$parse['sql_num']	= ((!defined('INSTALL') || !defined('IN_ADMIN')) && $user['authlevel'] == 3 && $game_config['debug'] == 1) ? "<center><div id=\"footer\">SQL Abfragen:". $db->get_sql()." - Seiten generiert in ".round(microtime(true) - STARTTIME, 4)." Sekunden</div></center>" : "";
		$parse['cron']  	= '';
		$parse['cron'] 	   .= (time() >= ($game_config['stat_last_update'] + (60 * $game_config['stat_update_time']))) ? "<img src=\"cronjobs.php?cron=stats\" alt=\"\" height=\"1\" width=\"1\">" : "";
		$parse['cron'] 	   .= (time() >= ($game_config['stat_last_db_update'] + (60 * 60 * 24))) ? "<img src=\"cronjobs.php?cron=opdb\" alt=\"\" height=\"1\" width=\"1\">" : "";
		$DisplayPage .= parsetemplate(gettemplate('global/overall_footer'), $parse);
	}

	echo $DisplayPage;
}

function StdUserHeader ($metatags = '')
{
	global $dpath, $game_config;

	$parse['title'] 	 = $game_config['game_name'];
	$parse['dpath'] 	 = (isset($dpath)) ? $dpath : DEFAULT_SKINPATH;
	$parse['meta']		 = $metatags;

	return parsetemplate(gettemplate('global/overall_header'), $parse);
}

function AdminUserHeader ($metatags = '')
{
	global $game_config;

	$parse['title'] 	 = (!defined('IN_ADMIN')) ? "2Moons - Installer" : $game_config['game_name']." - Admin CP";
	$parse['meta'] 		 = $metatags;
	return parsetemplate(gettemplate('adm/simple_header'), $parse);
}

function CalculateMaxPlanetFields (&$planet)
{
	global $resource;
	return $planet["field_max"] + ($planet[$resource[33]] * FIELDS_BY_TERRAFORMER);
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

function ShowBuildTime($time)
{
	global $lang;
	return $lang['fgf_time']."</td><td width=\"12%\" align=\"right\">".pretty_time($time);
}

function parsetemplate ($template, $array)
{
	return preg_replace('#\{([a-z0-9\-_]*?)\}#Ssie', '( ( isset($array[\'\1\']) ) ? $array[\'\1\'] : \'\' );', $template);
}

function gettemplate ($templatename)
{
	global $xgp_root;
	if(!($temp = @file_get_contents($xgp_root . TEMPLATE_DIR . $templatename . ".tpl")))
	{
		trigger_error("Konnte Templatefile ". $templatename . " nicht finden!", E_USER_WARNING);
	}
	return $temp;
}

function includeLang ($filename, $ext = '.php')
{
	global $xgp_root, $lang;

	include_once($xgp_root . "language/". DEFAULT_LANG ."/". $filename.$ext);
}

function GetStartAdressLink ( $FleetRow, $FleetType )
{
	$Link  = "<a href=\"game.php?page=galaxy&mode=3&galaxy=".$FleetRow['fleet_start_galaxy']."&system=".$FleetRow['fleet_start_system']."\" ". $FleetType .">";
	$Link .= "[".$FleetRow['fleet_start_galaxy'].":".$FleetRow['fleet_start_system'].":".$FleetRow['fleet_start_planet']."]</a>";
	return $Link;
}

function GetTargetAdressLink ( $FleetRow, $FleetType )
{
	$Link  = "<a href=\"game.php?page=galaxy&mode=3&galaxy=".$FleetRow['fleet_end_galaxy']."&system=".$FleetRow['fleet_end_system']."\" ". $FleetType .">";
	$Link .= "[".$FleetRow['fleet_end_galaxy'].":".$FleetRow['fleet_end_system'].":".$FleetRow['fleet_end_planet']."]</a>";
	return $Link;
}

function BuildPlanetAdressLink ( $CurrentPlanet )
{
	$Link  = "<a href=\"game.php?page=galaxy&mode=3&galaxy=".$CurrentPlanet['galaxy']."&system=".$CurrentPlanet['system']."\">";
	$Link .= "[".$CurrentPlanet['galaxy'].":".$CurrentPlanet['system'].":".$CurrentPlanet['planet']."]</a>";
	return $Link;
}

function colorNumber($n, $s = '')
{
	if ($n > 0)
		$s = (empty($s)) ? colorGreen($n) : colorGreen($s);
	elseif ($n < 0)
		$s = (empty($s)) ? colorRed($n) : colorRed($s);
	else
		$s = (empty($s)) ? $n : $s;

	return $s;
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
	if ($floor)
		$n = floor($n);

	return number_format($n, 0, ",", ".");
}

function umlaute($text)
{
	return htmlentities($text, ENT_COMPAT, "UTF-8", true);
}

function zround($n) {
	return ($n < 0) ? ceil($n) : floor($n) ;
}

function roundUp($value, $precision = 0)
{
	if ( $precision == 0 )
		$precisionFactor = 1;
	else
		$precisionFactor = pow( 10, $precision );

	return ceil( $value * $precisionFactor )/$precisionFactor;
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
	global $phpEx, $msg_title, $msg_long_text, $game_config, $db;
	if (!error_reporting()) return false;
	switch ($errno)
	{
		case E_USER_WARNING:
		case E_WARNING:		
			echo "<div style='border: 2px solid red; margin-left: 190.5px; margin-bottom: 1px; padding: 2px; color:#FFFFFF;'><b>[2Moons Debug] PHP Warning </b> in file <b>" . $errfile . "</b> on line <b>" . $errline . "</b>: <b>" . $msg_text . "</b></div>\n";
			return;

		break;	
		case E_STRICT:
		case E_DEPRECATED:
			echo "<div style='border: 2px solid red; margin-left: 190.5px; margin-bottom: 1px; padding: 2px;color:#FFFFFF;'><b>[2Moons Debug] PHP Notice </b> in file <b>" . $errfile . "</b> on line <b>" . $errline . "</b>: <b>" . $msg_text . "</b></div>\n";
			return;

		break;
		case E_USER_ERROR:
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

	// If we notice an error not handled here we pass this back to PHP by returning false
	// This may not work for all php versions
	return false;
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
		$mail->SMTPDebug  = 1;    
		$mail->SMTPAuth   = true;  						
		$mail->SMTPSecure = $game_config['smtp_ssl'];  						
		$mail->Host       = $game_config['smtp_host'];
		$mail->Port       = $game_config['smtp_port'];
		$mail->Username   = $game_config['smtp_user'];
		$mail->Password   = $game_config['smtp_pass'];
		$mail->SetFrom(ADMINEMAIL, $game_config['game_name']);
		$mail->AddAddress($MailTarget, $MailTargetName);
		$mail->AddReplyTo(ADMINEMAIL, $game_config['game_name']);
		$mail->Subject    = $MailSubject;
		$mail->AltBody    = $MailContent;
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
	
    $BR = ($xhtml === true)
        ? "<br />\n"  # XHTML konformer BR Tag
        : "<br>\n";   # HTML 4 konformer BR Tag

    return (version_compare(PHP_VERSION, "5.3.0", ">="))
        ? nl2br($text, $xhtml)
        : preg_replace("/(\r\n)+|(\n|\r)+/", $BR, $text); 
}

function CheckPlanetIfExist($Galaxy, $System, $Planet, $Planettype = 1)
{
	global $db;
	$QrySelectGalaxy = $db->fetch_array($db->query("SELECT id FROM ".PLANETS." WHERE `galaxy` = '".$Galaxy."' AND `system` = '".$System."' AND `planet` = '".$Planet."' AND `planet_type` = '".$Planettype."';"));
	return (isset($QrySelectGalaxy)) ? true : false;
}

function AddPointsToPlayer($CurrentUserID, $BuildID, $Amount = 1, $Level = 0)
{
	global $db, $pricelist, $game_config;
	$DonePoints	= round((($pricelist[$BuildID]['metal'] * pow($pricelist[$BuildID]['factor'], $Level) + $pricelist[$BuildID]['crystal'] * pow($pricelist[$BuildID]['factor'], $Level) + $pricelist[$BuildID]['deuterium'] * pow($pricelist[$BuildID]['factor'], $Level)) * $Amount) / $game_config['stat_settings']);

	$db->query("UPDATE ".STATPOINTS." SET `total_points` = `total_points` + '".$DonePoints."' WHERE `id_owner` = '".$CurrentUserID."' AND `stat_type` = '1';");
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
	return((ctype_alnum($String) && !UTF8_SUPPORT) || ctype_space($String)) ? true : false;
}

?>