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

define('MODE', 'INDEX');
define('ROOT_PATH', str_replace('\\', '/',dirname(__FILE__)).'/');

if(!file_exists(ROOT_PATH.'includes/config.php')) {
	require(ROOT_PATH . 'includes/constants.php');
	require(ROOT_PATH . 'includes/classes/HTTP.class.php');
	HTTP::redirectTo("install/index.php");
}

require(ROOT_PATH . 'includes/common.php');
	
$template	= new template();
$LANG->GetLangFromBrowser();
$LANG->includeLang(array('L18N', 'INGAME', 'PUBLIC', 'CUSTOM'));

$THEME->isHome();
$page	= HTTP::_GP('page', '');
$action	= HTTP::_GP('action', '');
$mode 	= HTTP::_GP('mode', '');

switch ($page) {
	case 'lostpassword': 

	break;
	case 'reg' :
		switch ($action) {
			case 'check' :
				
			break;
			case 'send' :
										
			break;
			case 'valid' :
				
			break;
			default:
				HTTP::redirectTo("index.php");
			break;
		}
		break;
	
	case 'extauth':
		
	break;