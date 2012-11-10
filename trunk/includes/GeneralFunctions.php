<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
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
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.0 (2012-12-31)
 * @info $Id$
 * @link http://2moons.cc/
 */

function getUniverse()
{
	$gameConfig	= Config::getAll(NULL);
	
	if(MODE == 'ADMIN' && isset($_SESSION['adminuni']))
	{
		$UNI	= (int) $_SESSION['adminuni'];
	}
	elseif(MODE == 'LOGIN')
	{
		if(isset($_COOKIE['uni']))
		{
			$UNI	= (int) $_COOKIE['uni'];
		}

		if(isset($_REQUEST['uni']))
		{
			$UNI	= (int) $_REQUEST['uni'];
		}
	}
	
	if(!isset($UNI))
	{
		if(UNIS_WILDCAST === true) {
			$UNI	= explode('.', $_SERVER['HTTP_HOST']);
			$UNI	= substr($UNI[0], 3);
			if(!is_numeric($UNI))
			{
				$UNI	= ROOT_UNI;
			}
		} else {
			if(count($gameConfig) == 1)
			{
				if(HTTP_ROOT != HTTP_BASE)
				{
					HTTP::redirectTo(PROTOCOL.HTTP_HOST.HTTP_BASE.HTTP_FILE, true);
				}
				
				$UNI = ROOT_UNI;
			}
			else
			{
				if(isset($_SERVER['REDIRECT_UNI'])) {
					// Apache - faster then preg_match
					$UNI	= $_SERVER["REDIRECT_UNI"];
				}
				elseif(isset($_SERVER['REDIRECT_REDIRECT_UNI']))
				{
					// Patch for www.top-hoster.de - Hoster
					$UNI	= $_SERVER["REDIRECT_REDIRECT_UNI"];
				}
				elseif(strpos($_SERVER['SERVER_SOFTWARE'], 'Apache/') === false)
				{
					preg_match('!/uni([0-9]+)/!', HTTP_PATH, $match);
					if(isset($match[1]))
					{
						$UNI	= $match[1];
					}
				}
				
				if(!isset($UNI) || !isset($gameConfig[$UNI]))
				{
					HTTP::redirectTo(PROTOCOL.HTTP_HOST.HTTP_BASE."uni".ROOT_UNI."/".HTTP_FILE, true);
				}
			}
		}
	}
	
	return $UNI;
}

function t($key)
{
	global $LNG;
	
	if(strpos($key, '.') === false)
	{
		$text = $LNG[$key];
	}
	else
	{
		$keys = explode('.', $key);
		$text = $LNG[$keys[0]][$keys[1]];
	}
	
	$args = func_get_args();
	array_shift($args);
	
	switch (count($args)) {
		case 0: return $text; break;
		case 1: return sprintf($text, $args[0]); break;
		case 2: return sprintf($text, $args[0], $args[1]); break;
		case 3: return sprintf($text, $args[0], $args[1], $args[2]); break;
		case 4: return sprintf($text, $args[0], $args[1], $args[2], $args[3]); break;
		case 5: return sprintf($text, $args[0], $args[1], $args[2], $args[3], $args[4]); break;
		case 6: return sprintf($text, $args[0], $args[1], $args[2], $args[3], $args[4], $args[5]); break;
		case 7: return sprintf($text, $args[0], $args[1], $args[2], $args[3], $args[4], $args[5], $args[6]); break;
		case 8: return sprintf($text, $args[0], $args[1], $args[2], $args[3], $args[4], $args[5], $args[6], $args[7]); break;
		case 9: return sprintf($text, $args[0], $args[1], $args[2], $args[3], $args[4], $args[5], $args[6], $args[7], $args[8]); break;
		case 10: return call_user_func_array('sprintf', $args); break;
	}
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

	$QryPlanets  = "SELECT id, name, galaxy, system, planet, planet_type, image, b_building, b_building_id FROM ".PLANETS." WHERE id_owner = '".$USER['id']."' AND destruyed = '0' ORDER BY ";

	if($Sort == 0)
		$QryPlanets .= "id ". $Order;
	elseif($Sort == 1)
		$QryPlanets .= "galaxy, system, planet, planet_type ". $Order;
	elseif ($Sort == 2)
		$QryPlanets .= "name ". $Order;

	$PlanetRAW = $GLOBALS['DATABASE']->query($QryPlanets);
	
	$Planets	= array();
	
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

function ValidateAddress($address) {
	
	if(function_exists('filter_var')) {
		return filter_var($address, FILTER_VALIDATE_EMAIL) !== FALSE;
	} else {
		/*
			Regex expression from swift mailer (http://swiftmailer.org)
			RFC 2822
		*/
		return preg_match('/^(?:(?:(?:(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?(?:[a-zA-Z0-9!#\$%&\'\*\+\-\/=\?\^_\{\}\|~]+(\.[a-zA-Z0-9!#\$%&\'\*\+\-\/=\?\^_\{\}\|~]+)*)+(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?)|(?:(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?"((?:(?:[ \t]*(?:\r\n))?[ \t])?(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21\x23-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])))*(?:(?:[ \t]*(?:\r\n))?[ \t])?"(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?))@(?:(?:(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?(?:[a-zA-Z0-9!#\$%&\'\*\+\-\/=\?\^_\{\}\|~]+(\.[a-zA-Z0-9!#\$%&\'\*\+\-\/=\?\^_\{\}\|~]+)*)+(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?)|(?:(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?\[((?:(?:[ \t]*(?:\r\n))?[ \t])?(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x5A\x5E-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])))*?(?:(?:[ \t]*(?:\r\n))?[ \t])?\](?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?)))$/D', $address);
	}
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

function pretty_time($seconds)
{
	global $LNG;
	
	$day	= floor($seconds / 86400);
	$hour	= floor($seconds / 3600 % 24);
	$minute	= floor($seconds / 60 % 60);
	$second	= floor($seconds % 60);
	
	$time  = '';
	
	if($day >= 10) {
		$time .= $day.$LNG['short_day'].' ';
	} elseif($day > 0) {
		$time .= '0'.$day.$LNG['short_day'].' ';
	}
	
	if($hour >= 10) {
		$time .= $hour.$LNG['short_hour'].' ';
	} else {
		$time .= '0'.$hour.$LNG['short_hour'].' ';
	}
	
	if($minute >= 10) {
		$time .= $minute.$LNG['short_minute'].' ';
	} else {
		$time .= '0'.$minute.$LNG['short_minute'].' ';
	}
	
	if($second >= 10) {
		$time .= $second.$LNG['short_second'].' ';
	} else {
		$time .= '0'.$second.$LNG['short_second'].' ';
	}

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
			$GetOnSelect .= "".$col.",";
		}
		$GetOnSelect = substr($GetOnSelect, 0, -1);
	}
	else
		$GetOnSelect = $GetInfo;
	
	$User = $GLOBALS['DATABASE']->getFirstRow("SELECT ".$GetOnSelect." FROM ".USERS." WHERE id = '". $UserID ."';");
	return $User;
}

function MailSend($MailTarget, $MailTargetName, $MailSubject, $MailContent)
{
	global $CONF;
	require_once('./includes/classes/class.phpmailer.php');
	$mail             	= new PHPMailer(true);
	if(Config::get('mail_use') == 2) {
		$mail->IsSMTP();  
		$mail->SMTPAuth   	= true; 
		$mail->SMTPSecure 	= Config::get('smtp_ssl');  						
		$mail->Host      	= Config::get('smtp_host');
		$mail->Port      	= Config::get('smtp_port');
		$mail->Username  	= Config::get('smtp_user');
		$mail->Password  	= Config::get('smtp_pass');
		$mail->SMTPDebug  	= (Config::get('debug') == 1) ? 2 : 0;   
	} elseif(Config::get('mail_use') == 1) {
		$mail->IsSendmail();
		$mai->Sendmail		= Config::get('smail_path');
	} else {
		$mail->IsMail();
	}
	$mail->CharSet		= 'UTF-8';		
	$mail->Subject   	= $MailSubject;
	$mail->Body   		= $MailContent;
	$mail->SetFrom(Config::get('smtp_sendmail'), Config::get('game_name'));
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
	$QrySelectGalaxy = $GLOBALS['DATABASE']->getFirstCell("SELECT COUNT(*) FROM ".PLANETS." WHERE universe = '".$Universe."' AND galaxy = '".$Galaxy."' AND system = '".$System."' AND planet = '".$Planet."' AND planet_type = '".$Planettype."';");
	return $QrySelectGalaxy ? true : false;
}

function CheckNoobProtec($OwnerPlayer, $TargetPlayer, $Player)
{	
	global $CONF;
	if(
		Config::get('noobprotection') == 0 
		|| Config::get('noobprotectiontime') == 0 
		|| Config::get('noobprotectionmulti') == 0 
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
			($TargetPlayer['total_points'] <= Config::get('noobprotectiontime')) && // Default: 25.000
			($OwnerPlayer['total_points'] > $TargetPlayer['total_points'] * Config::get('noobprotectionmulti'))
		), 
		'StrongPlayer' => (
			/* WAHR: 
				Wenn Spieler weniger als 5000 Punkte hat UND
				Mehr als das funfache der eigende Punkte hat
			*/
			($OwnerPlayer['total_points'] < Config::get('noobprotectiontime')) && // Default: 5.000
			($OwnerPlayer['total_points'] * Config::get('noobprotectionmulti') < $TargetPlayer['total_points'])
		),
	);
}

function CheckName($name)
{
	if(UTF8_SUPPORT) {
		return preg_match("/^[\p{L}\p{N}_\-. ]*$/u", $name);
	} else {
		return preg_match("/^[A-z0-9_\-. ]*$/", $name);
	}
}

function SendSimpleMessage($Owner, $Sender, $Time, $Type, $From, $Subject, $Message)
{
			
	$SQL	= "INSERT INTO ".MESSAGES." SET 
	message_owner = ".(int) $Owner.", 
	message_sender = ".(int) $Sender.", 
	message_time = ".(int) $Time.", 
	message_type = ".(int) $Type.", 
	message_from = '".$GLOBALS['DATABASE']->sql_escape($From) ."', 
	message_subject = '". $GLOBALS['DATABASE']->sql_escape($Subject) ."', 
	message_text = '".$GLOBALS['DATABASE']->sql_escape($Message)."', 
	message_unread = '1', 
	message_universe = ".$GLOBALS['UNI'].";";

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
	
	return $GLOBALS['CONF']['moduls'][$ID] == 1 || (isset($USER['authlevel']) && $USER['authlevel'] > AUTH_USR);
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
	$Crons .= TIMESTAMP >= (Config::get('stat_last_update') + (60 * Config::get('stat_update_time'))) ? '<img src="./cronjobs.php?cron=stats" alt="" height="1" width="1">' : '';
	
	$Crons .= Config::get('ts_modon') == 1 && TIMESTAMP >= (Config::get('ts_cron_last') + 60 * Config::get('ts_cron_interval')) ? '<img src="./cronjobs.php?cron=teamspeak" alt="" height="1" width="1">' : '';
	
	$Crons .= TIMESTAMP >= (Config::get('stat_last_db_update') + 86400) ? '<img src="./cronjobs.php?cron=daily" alt="" height="1" width="1">' : ''; //Daily Cronjob
	
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

function combineArrayWithSingleElement($keys, $var) {
	return array_combine($keys, array_fill(0, count($keys), $var));
}

function clearGIF() {
	header('Cache-Control: no-cache');
	header('Content-type: image/gif');
	header('Content-length: 43');
	header('Expires: 0');
	echo("\x47\x49\x46\x38\x39\x61\x01\x00\x01\x00\x80\x00\x00\x00\x00\x00\x00\x00\x00\x21\xF9\x04\x01\x00\x00\x00\x00\x2C\x00\x00\x00\x00\x01\x00\x01\x00\x00\x02\x02\x44\x01\x00\x3B");
	exit;
}

function fleetAmountToArray($fleetAmount)
{
	$fleetTyps		= explode(';', $fleetAmount);
	
	$fleetAmount	= array();
	
	foreach ($fleetTyps as $fleetTyp)
	{
		$temp = explode(',', $fleetTyp);
		
		if (empty($temp[0])) continue;

		if (!isset($fleetAmount[$temp[0]]))
		{
			$fleetAmount[$temp[0]] = 0;
		}
		
		$fleetAmount[$temp[0]] += $temp[1];
	}
	
	return $fleetAmount;
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
	
	try
	{
		if(!class_exists('Config', false))
		{
			throw new Exception("No config class");
		}
		$VERSION	= Config::get('VERSION');
	} catch(Exception $e) {
		if(file_exists(ROOT_PATH.'install/VERSION'))
		{
			$VERSION	= file_get_contents(ROOT_PATH.'install/VERSION').' (FILE)';
		}
		else
		{
			$VERSION	= 'UNKNOWN';
		}
	}
	
	try
	{
		if(!class_exists('Config', false))
		{
			throw new Exception("No config class");
		}
		$gameName	= Config::get('game_name');
	} catch(Exception $e) {
		$gameName	= '-';
	}
	
	$DIR		= MODE == 'INSTALL' ? '..' : '.';
	echo '<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="de" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="de" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="de" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="de" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="de" class="no-js"> <!--<![endif]-->
<head>
	<title>'.$gameName.' - '.$errorType[$errno].'</title>
	<meta name="generator" content="2Moons '.$VERSION.'">
	<!-- 
		This website is powered by 2Moons '.$VERSION.'
		2Moons is a free Space Browsergame initially created by Jan Kr�pke and licensed under GNU/GPL.
		2Moons is copyright 2009-2012 of Jan Kröpke. Extensions are copyright of their respective owners.
		Information and contribution at http://2moons.cc/
	-->
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="'.$DIR.'/styles/resource/css/base/boilerplate.css?v='.$VERSION.'">
	<link rel="stylesheet" type="text/css" href="'.$DIR.'/styles/resource/css/ingame/main.css?v='.$VERSION.'">
	<link rel="stylesheet" type="text/css" href="'.$DIR.'/styles/resource/css/base/jquery.css?v='.$VERSION.'">
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
			<b>URL: </b>'.PROTOCOL.HTTP_HOST.$_SERVER['REQUEST_URI'].'<br>
			<b>PHP-Version: </b>'.PHP_VERSION.'<br>
			<b>PHP-API: </b>'.php_sapi_name().'<br>
			<b>MySQL-Cleint-Version: </b>'.mysqli_get_client_info().'<br>
			<b>2Moons Version: </b>'.$VERSION.'<br>
			<b>Debug Backtrace:</b><br>'.makebr(str_replace(ROOT_PATH, '/', htmlspecialchars(str_replace('\\', '/',$exception->getTraceAsString())))).'
		</td>
	</tr>
</table>
</body>
</html>';
	
	$errorText	= date("[d-M-Y H:i:s]", TIMESTAMP).' '.$errorType[$errno].': "'.strip_tags($exception->getMessage())."\"\r\n";
	$errorText	.= 'File: '.$exception->getFile().' | Line: '.$exception->getLine()."\r\n";
	$errorText	.= 'URL: '.PROTOCOL.HTTP_HOST.$_SERVER['REQUEST_URI'].' | Version: '.$VERSION."\r\n";
	$errorText	.= "Stack trace:\r\n";
	$errorText	.= str_replace(ROOT_PATH, '/', htmlspecialchars(str_replace('\\', '/',$exception->getTraceAsString())))."\r\n";
	
	if(is_writable(ROOT_PATH.'includes/error.log'))
	{
		file_put_contents(ROOT_PATH.'includes/error.log', $errorText, FILE_APPEND);
	}
}

function errorHandler($errno, $errstr, $errfile, $errline)
{
    if (!($errno & error_reporting())) {
        return;
    }
	
	throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}