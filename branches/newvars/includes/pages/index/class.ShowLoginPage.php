<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan
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
 * @author Jan <info@2moons.cc>
 * @copyright 2006 Perberos <ugamela@perberos.com.ar> (UGamela)
 * @copyright 2008 Chlorel (XNova)
 * @copyright 2009 Lucky (XGProyecto)
 * @copyright 2012 Jan <info@2moons.cc> (2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.0 (2012-05-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */


class ShowLoginPage extends AbstractPage
{
	public static $requireModule = 0;

	function __construct() 
	{
		parent::__construct();
	}
	
	function show() 
	{
		global $UNI;
		if (empty($_POST)) {
			HTTP::redirectTo('index.php');	
		}
		
		$username = HTTP::_GP('username', '', UTF8_SUPPORT);
		$password = HTTP::_GP('password', '', true);
		$loginData = $GLOBALS['DATABASE']->getFirstRow("SELECT id, username, password, dpath, authlevel, id_planet FROM ".USERS." WHERE universe = ".$UNI." AND username = '".$GLOBALS['DATABASE']->sql_escape($username)."';");
			
		if (isset($loginData)) {
			if($loginData['password'] != PlayerUntl::cryptPassword($password)) {
				// Fallback pre 1.7
				if($loginData['password'] == md5($password)) {
					$GLOBALS['DATABASE']->query("UPDATE ".USERS." SET password = '".PlayerUntl::cryptPassword($password)."' WHERE id = ".$loginData['id'].";");
				} else {
					HTTP::redirectTo('index.php?code=1');	
				}
			}
			
			$SESSION       	= new Session();
			$SESSION->CreateSession($loginData['id'], $loginData['username'], $loginData['id_planet'], $UNI, $loginData['authlevel'], $loginData['dpath']);
			HTTP::redirectTo('game.php');	
		}
	}
}
