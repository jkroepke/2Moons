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

define('MODE', 'INDEX');

define('ROOT_PATH', str_replace('\\', '/',dirname(__FILE__)).'/');

require(ROOT_PATH.'includes/common.php');
require(ROOT_PATH.'includes/pages/game/class.AbstractPage.php');
require(ROOT_PATH.'includes/pages/game/class.ShowErrorPage.php');

if($SESSION->IsUserLogin()) {
	$USER	= $GLOBALS['DATABASE']->getFirstRow("SELECT id, authlevel, timezone, lang, urlaubs_modus FROM ".USERS." WHERE id = ".$_SESSION['id'].";");
} else {

	// Simluate User
	// It isn't clean, but i haven't others solutions at this time.
	
	$USER	= array(
		'lang'	=> $LANG->GetLangFromBrowser(),
		'timezone'	=> Config::get('timezone'),
		'urlaubs_modus'	=> 0,
		'authlevel'	=> 0
	);
}

$LANG->setUser($USER['lang']);
$LANG->includeLang(array('L18N', 'INGAME', 'TECH', 'FLEET', 'CUSTOM'));

require(ROOT_PATH.'includes/pages/game/class.ShowRaportPage.php');

$pageObj	= new ShowRaportPage;
$mode		= HTTP::_GP('mode', 'show');

// PHP 5.2 FIX
// can't use $pageObj::$requireModule
$pageProps	= get_class_vars(get_class($pageObj));

if(!is_callable(array($pageObj, $mode))) {	
	if(!isset($pageProps['defaultController']) || !is_callable(array($pageObj, $pageProps['defaultController']))) {
		ShowErrorPage::printError($LNG['page_doesnt_exist']);
	}
	
	$mode	= $pageProps['defaultController'];
}

$pageObj->{$mode}();


?>