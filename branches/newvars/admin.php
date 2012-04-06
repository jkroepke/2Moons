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

define('MODE', 'ADMIN');
define('ROOT_PATH', str_replace('\\', '/',dirname(__FILE__)).'/');

require(ROOT_PATH . 'includes/common.php');

if ($USER['authlevel'] == AUTH_USR) {
	HTTP::redirectTo('game.php');
}

if($USER['authlevel'] == AUTH_ADM)
{
	$ADMINUNI	= HTTP::_GP('uni', 0);
	if(!empty($ADMINUNI)) {
		$_SESSION['adminuni']	= $ADMINUNI;
	} elseif(!empty($_SESSION['adminuni'])) {
		$ADMINUNI				= $_SESSION['adminuni'];
	} else {
		$_SESSION['adminuni']	= $UNI;
		$ADMINUNI				= $UNI;
	}
} else {
	$ADMINUNI	= $UNI;
}

$page 		= HTTP::_GP('page', 'overview');
$mode 		= HTTP::_GP('mode', 'show');
$mode		= str_replace(array('_', '\\', '/', '.', "\0"), '', $mode);
$pageClass	= 'Show'.ucwords($page).'Page';

if(!isset($_SESSION['admin_login']) || $_SESSION['admin_login'] != $USER['password'])
{
	$page	= 'login';
}

if(!class_exists($pageClass)) {
	ShowErrorPage::printError($LNG['page_doesnt_exist']);
}

$pageObj	= new $pageClass;
// PHP 5.2 FIX
// can't use $pageObj::$requireModule
$pageProps	= get_class_vars(get_class($pageObj));

if(isset($pageProps['requireModule']) && $pageProps['requireModule'] !== 0 && !isModulAvalible($pageProps['requireModule'])) {
	ShowErrorPage::printError($LNG['sys_module_inactive']);
}

if(!method_exists($pageObj, $mode) || !is_callable(array($pageObj, $mode))) {	
	if(!isset($pageProps['defaultController']) || !is_callable(array($pageObj, $pageProps['defaultController']))) {
		ShowErrorPage::printError($LNG['page_doesnt_exist']);
	}
	$mode	= $pageProps['defaultController'];
}

$pageObj->{$mode}();