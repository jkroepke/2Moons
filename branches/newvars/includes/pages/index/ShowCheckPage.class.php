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


class ShowScreensPage extends AbstractPage
{
	public static $requireModule = 0;

	function __construct() 
	{
		parent::__construct();
	}
	
	function show() 
	{
		$check	= HTTP::_GP('check', '', UTF8_SUPPORT);
		$value	= HTTP::_GP('value', '', UTF8_SUPPORT);
		switch($check) {
			case 'username' :
				$Count 	= $GLOBALS['DATABASE']->countquery("SELECT (SELECT COUNT(*) FROM ".USERS." WHERE universe = ".$UNI." AND username = '".$GLOBALS['DATABASE']->escape($value)."') + (SELECT COUNT(*) FROM ".USERS_VALID." WHERE universe = ".$UNI." AND username = '".$GLOBALS['DATABASE']->escape($value)."')");
			break;
			case 'email' :
				$Count 	= $GLOBALS['DATABASE']->countquery("SELECT (SELECT COUNT(*) FROM ".USERS." WHERE universe = ".$UNI." AND (email = '".$GLOBALS['DATABASE']->escape($value)."' OR email_2 = '".$GLOBALS['DATABASE']->escape($value)."')) + (SELECT COUNT(*) FROM ".USERS_VALID." WHERE universe = ".$UNI." AND email = '".$GLOBALS['DATABASE']->escape($value)."')");
			break;
			case 'fbid' :
				$Count 	= $GLOBALS['DATABASE']->countquery("SELECT COUNT(*) FROM ".USERS_AUTH." WHERE account = '".$GLOBALS['DATABASE']->escape($value)."' AND mode = 'facebook';");
			break;
			case 'ref' :
				$Count 	= $GLOBALS['DATABASE']->countquery("SELECT universe FROM ".USERS." WHERE id = '".$GLOBALS['DATABASE']->escape($value)."';");
			break;
		}
		
		if($Count == 0)
		{
			echo json_encode(array('exists' => false));
		}
		else
		{
			echo json_encode(array('exists' => true, 'Message' => $Count));
		}
	}
}
