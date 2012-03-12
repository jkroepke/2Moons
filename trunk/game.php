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

define('MODE', 'INGAME');
define('ROOT_PATH', str_replace('\\', '/',dirname(__FILE__)).'/');

require(ROOT_PATH.'includes/pages/game/class.AbstractPage.php');
require(ROOT_PATH.'includes/pages/game/class.ShowErrorPage.php');
require(ROOT_PATH.'includes/classes/class.BuildFunctions.php');
require(ROOT_PATH.'includes/common.php');

$page 		= HTTP::_GP('page', 'overview');
$mode 		= HTTP::_GP('mode', 'show');
$mode		= str_replace(array('_', '\\', '/', '.', "\0"), '', $mode);
$pageClass	= 'Show'.ucwords($page).'Page';

if(!file_exists(ROOT_PATH . 'includes/pages/game/class.'.$pageClass.'.php')) {
	ShowErrorPage::printError($LNG['page_doesnt_exist']);
}

// Added Autoload in feature Versions
require(ROOT_PATH . 'includes/pages/game/class.'.$pageClass.'.php');

$pageObj	= new $pageClass;
// PHP 5.2 FIX
// can't use $pageObj::$requireModule
$pageProps	= get_class_vars(get_class($pageObj));

if(isset($pageProps['requireModule']) && $pageProps['requireModule'] !== 0 && !isModulAvalible($pageProps['requireModule'])) {
	ShowErrorPage::printError($LNG['sys_module_inactive']);
}

if(!is_callable(array($pageObj, $mode))) {	
	if(!isset($pageProps['defaultController']) || !is_callable(array($pageObj, $pageProps['defaultController']))) {
		ShowErrorPage::printError($LNG['page_doesnt_exist']);
	}
	$mode	= $pageProps['defaultController'];
}

$pageObj->{$mode}();

?>