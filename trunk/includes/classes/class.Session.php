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

class Session
{
	function __construct()
	{
		ini_set('session.use_cookies', '1');
		ini_set('session.use_only_cookies', '1');
		ini_set('session.use_trans_sid', 0);
		ini_set('session.auto_start', '0');
		ini_set('session.serialize_handler', 'php');  
		ini_set('session.gc_maxlifetime', SESSION_LIFETIME);
		ini_set('session.gc_probability', '1');
		ini_set('session.gc_divisor', '1000');
		ini_set('session.bug_compat_warn', '0');
		ini_set('session.bug_compat_42', '0');
		ini_set('session.cookie_httponly', true);
		
		//session_set_cookie_params(SESSION_LIFETIME, HTTP_ROOT, HTTP_HOST, HTTPS, true);
		session_set_cookie_params(SESSION_LIFETIME, HTTP_ROOT, NULL, HTTPS, true);
		session_cache_limiter('nocache');
		session_name('2Moons');
	}
	
	function IsUserLogin()
	{
		if(!isset($_SESSION)) {
			session_start();
		}
		return !empty($_SESSION['id']);
	}
	
	function GetSessionFromDB()
	{
		return $GLOBALS['DATABASE']->uniquequery("SELECT * FROM ".SESSION." WHERE sessionID = '".session_id()."' AND userID = ".$_SESSION['id'].";");
	}
	
	function ErrorMessage($Code)
	{
		HTTP::redirectTo('index.php?code='.$Code);
	}
	
	function CreateSession($ID, $Username, $MainPlanet, $Universe, $Authlevel = 0, $dpath = DEFAULT_THEME)
	{
		if(!isset($_SESSION)) {
			session_start();
		}
		
		$Path					= $this->GetPath();
		
		$GLOBALS['DATABASE']->query("DELETE FROM ".SESSION." WHERE userID = ".$ID." OR sessionID = '".session_id()."';");		
		$GLOBALS['DATABASE']->query("INSERT INTO ".SESSION." SET
		userID = ".$ID.",
		sessionID = '".session_id()."',
		lastonline = ".TIMESTAMP.",
		userIP = '".$_SERVER['REMOTE_ADDR']."';");
		$_SESSION['id']			= $ID;
		$_SESSION['username']	= $Username;
		$_SESSION['authlevel']	= $Authlevel;	
		$_SESSION['path']		= $Path;
		$_SESSION['dpath']		= $dpath;
		$_SESSION['planet']		= $MainPlanet;
		$_SESSION['uni']		= $Universe;
		$_SESSION['agent']		= $_SERVER['HTTP_USER_AGENT'];
	}
	
	function GetPath()
	{
		return basename($_SERVER['SCRIPT_NAME']).(!empty($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : '');
	}
	
	function UpdateSession()
	{
		global $CONF;
		
		if(HTTP::_GP('ajax', 0) == 1)
			return true;
			
		$_SESSION['last']	= $this->GetSessionFromDB();
		if(empty($_SESSION['last']) || !$this->CompareIPs($_SESSION['last']['userIP'])) {
			$this->DestroySession();
			$this->ErrorMessage(2);
		}
		
		$SelectPlanet  		= HTTP::_GP('cp',0);
		if(!empty($SelectPlanet))
			$IsPlanetMine 	=	$GLOBALS['DATABASE']->uniquequery("SELECT id FROM ".PLANETS." WHERE id = '".$SelectPlanet."' AND id_owner = '".$_SESSION['id']."';");
			
		$_SESSION['path']		= $this->GetPath();
		$_SESSION['planet']		= !empty($IsPlanetMine['id']) ? $IsPlanetMine['id'] : $_SESSION['planet'];

		$GLOBALS['DATABASE']->query("UPDATE ".USERS.", ".SESSION." SET 
		onlinetime = ".TIMESTAMP.",
		lastonline = ".TIMESTAMP.",
		user_lastip = '".$_SERVER['REMOTE_ADDR']."',
		userIP = '".$_SERVER['REMOTE_ADDR']."'
		WHERE
		sessionID = '".session_id()."' AND id = userID;");
		return true;
	}
	
	function CompareIPs($IP)
	{
		if (strpos($_SERVER['REMOTE_ADDR'], ':') !== false && strpos($IP, ':') !== false)
		{
			$s_ip = $this->short_ipv6($IP, COMPARE_IP_BLOCKS);
			$u_ip = $this->short_ipv6($_SERVER['REMOTE_ADDR'], COMPARE_IP_BLOCKS);
		}
		else
		{
			$s_ip = implode('.', array_slice(explode('.', $IP), 0, COMPARE_IP_BLOCKS));
			$u_ip = implode('.', array_slice(explode('.', $_SERVER['REMOTE_ADDR']), 0, COMPARE_IP_BLOCKS));
		}
		
		return ($s_ip == $u_ip);
	}

	function short_ipv6($ip, $length)
	{
		if ($length < 1)
		{
			return '';
		}

		$blocks = substr_count($ip, ':') + 1;
		if ($blocks < 9)
		{
			$ip = str_replace('::', ':' . str_repeat('0000:', 9 - $blocks), $ip);
		}
		if ($ip[0] == ':')
		{
			$ip = '0000' . $ip;
		}
		if ($length < 4)
		{
			$ip = implode(':', array_slice(explode(':', $ip), 0, 1 + $length));
		}

		return $ip;
	}
	
	function DestroySession()
	{
		$GLOBALS['DATABASE']->query("DELETE FROM ".SESSION." WHERE sessionID = '".session_id()."';"); 
		@session_destroy();
	}
}
?>