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

// Magic Quotes work around.
if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc() == 1)
{
	if (isset($_POST['GLOBALS']) || isset($_GET['GLOBALS']))
	{
		exit('You cannot set the GLOBALS-array from outside the script.');
	}
	
	foreach ($_GET as $k => $v)
	{
		$_GET[$k] = stripslashes($v);
	}
	
	foreach ($_POST as $k => $v)
	{
		$_POST[$k] = stripslashes($v);
	}
	
	foreach ($_COOKIE as $k => $v)
	{
		$_COOKIE[$k] = stripslashes($v);
	}
	
	$_REQUEST = array_merge($_GET, $_POST);
}

if (function_exists('mb_internal_encoding'))
{
	mb_internal_encoding("UTF-8");
}

require(ROOT_PATH.'includes/constants.php');

ignore_user_abort(true);
error_reporting(E_ALL & ~E_STRICT);
define('TIMESTAMP', time());

ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', ROOT_PATH.'includes/error.log');

require(ROOT_PATH.'includes/GeneralFunctions.php');
set_exception_handler('exceptionHandler');
set_error_handler('errorHandler');


require(ROOT_PATH.'includes/classes/Cache.class.php');
$CACHE = new Cache();

require(ROOT_PATH.'includes/classes/Autoload.class.php');
spl_autoload_register(array('Autoload', 'load'));

// Say Browsers to Allow ThirdParty Cookies (Thanks to morktadela)
HTTP::sendHeader('P3P', 'CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
HTTP::sendHeader('Content-Type', 'text/html; charset=UTF-8');

define('AJAX_REQUEST', HTTP::_GP('ajax', 0));

$THEME = new Theme();
$LANG  = new Language();

if (MODE !== 'INSTALL')
{
	require(ROOT_PATH.'includes/config.php');
	require(ROOT_PATH.'includes/dbtables.php');
	
	$SESSION  = new Session();
	$DATABASE = new Database();
	
	unset($database);
	
	$CACHE->add('vars', 'VarsBuildCache');
	$CACHE->add('config', 'ConfigBuildCache');
	$CACHE->add('configuni', 'ConfigUniverseBuildCache');
	$CACHE->add('module', 'ModuleBuildCache');
	$CACHE->add('universe', 'UniverseBuildCache');
	
	$VARS         = $CACHE->get('vars');
	$gameConfig   = $CACHE->get('config');
	$uniAllConfig = $CACHE->get('configuni');
	date_default_timezone_set($gameConfig['timezone']);
	
	$UNI = getUniverse();
	
	if (!isset($uniAllConfig[$UNI]))
	{
		throw new Exception('Invalid Universe!');
	}
	else
	{
		$uniConfig = $uniAllConfig[$UNI];
	}
	
	HTTP::sendHeader('X-2MOONS-VERSION', $gameConfig['version']);
	
	$LANG->setDefault($gameConfig['language']);
	
	if (MODE === 'GAME' || MODE === 'ADMIN' || MODE === 'CHAT')
	{
		if (!$SESSION->IsUserLogin())
		{
			HTTP::redirectTo('index.php?code=3');
		}
		
		$SESSION->UpdateSession();
		
		$module       = $CACHE->get('module');
			
		if (!AJAX_REQUEST && MODE === 'GAME' && isModulAvalible(MODULE_FLEET_EVENTS))
		{
			require(ROOT_PATH.'includes/FleetHandler.php');
		}
		
		$USER = $GLOBALS['DATABASE']->getFirstRow("SELECT 
		user.*, 
		stat.total_points, 
		stat.total_rank,
		COUNT(message.message_id) as messages
		FROM ".USERS." as user 
		LEFT JOIN ".STATPOINTS." as stat ON stat.id_owner = user.id AND stat.stat_type = '1' 
		LEFT JOIN ".MESSAGES." as message ON message.message_owner = user.id AND message.message_unread = '1'
		WHERE user.id = ".$_SESSION['id']."
		GROUP BY message.message_owner;");
		
		if (empty($USER))
		{
			HTTP::redirectTo('index.php?code=3');
		}
		
		$LANG->setUser($USER['lang']);
		$LANG->includeLang(array(
			'L18N',
			'INGAME',
			'TECH',
			'CUSTOM'
		));
		
		$THEME->setUserTheme($USER['dpath']);
		
		if ($uniConfig['enable'] == 0 && $USER['authlevel'] != AUTH_ADM)
		{
			ShowErrorPage::printGameClosedMessage();
		}
		
		if ($USER['bana'] == 1)
		{
			ShowErrorPage::printBanMessage();
		}
		
		if (MODE === 'GAME')
		{			
			$PLANET = $GLOBALS['DATABASE']->getFirstRow("SELECT * FROM ".PLANETS." WHERE id = ".$_SESSION['planet'].";");
			
			if (empty($PLANET))
			{
				$PLANET = $GLOBALS['DATABASE']->getFirstRow("SELECT * FROM ".PLANETS." WHERE id = ".$USER['id_planet'].";");
				
				if (empty($PLANET))
				{
					throw new Exception("Main Planet does not exist!");
				}
				
				$_SESSION['planet'] = $USER['id_planet'];
			}
			
			$USER['factor']  = getFactors($USER);
			$USER['PLANETS'] = getPlanets($USER);
		}
		else
		{
			$USER['rights'] = unserialize($USER['rights']);
			$LANG->includeLang(array(
				'ADMIN'
			));
		}
	}
	elseif (MODE === 'INDEX')
	{
		$LANG->GetLangFromBrowser();
		$LANG->includeLang(array(
			'L18N',
			'INGAME',
			'PUBLIC',
			'CUSTOM'
		));
	}
}