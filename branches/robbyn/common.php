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
 * @version 1.7.2 (2013-03-18)
 * @info $Id$
 * @link http://2moons.cc/
 */


session_start();

header('Content-Type: text/html; charset=UTF-8');

//Systemunabhängiger Seperator
define('SEP', DIRECTORY_SEPARATOR);

//Hauptverzeichniss
define('ROOT', dirname(__FILE__).SEP);

$include_path_seperator	=	(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')? ';' : ':';

$myPaths	=	array(
	ROOT.SEP.'db',
	ROOT.SEP.'chat',
	ROOT.SEP.'includes',
	ROOT.SEP.'includes'.SEP.'backups',
	ROOT.SEP.'includes'.SEP.'classes',
	ROOT.SEP.'includes'.SEP.'classes'.SEP.'cache',
	ROOT.SEP.'includes'.SEP.'classes'.SEP.'cache'.SEP.'ressource',
	ROOT.SEP.'includes'.SEP.'classes'.SEP.'cache'.SEP.'builder',
	ROOT.SEP.'includes'.SEP.'classes'.SEP.'cronjob',
	ROOT.SEP.'includes'.SEP.'classes'.SEP.'missions',
	ROOT.SEP.'includes'.SEP.'classes'.SEP.'robbyn',
	ROOT.SEP.'includes'.SEP.'extauth',
	ROOT.SEP.'includes'.SEP.'functions',
	ROOT.SEP.'includes'.SEP.'libs',
	ROOT.SEP.'includes'.SEP.'libs'.SEP.'facebook',
	ROOT.SEP.'includes'.SEP.'libs'.SEP.'ftp',
	ROOT.SEP.'includes'.SEP.'libs'.SEP.'OpenID',
	ROOT.SEP.'includes'.SEP.'libs'.SEP.'reCAPTCHA',
	ROOT.SEP.'includes'.SEP.'libs'.SEP.'Smarty',
	ROOT.SEP.'includes'.SEP.'libs'.SEP.'Smarty'.SEP.'plugins',
	ROOT.SEP.'includes'.SEP.'libs'.SEP.'Smarty'.SEP.'sysplugins',
	ROOT.SEP.'includes'.SEP.'libs'.SEP.'tdcron',
	ROOT.SEP.'includes'.SEP.'libs'.SEP.'teamspeak',
	ROOT.SEP.'includes'.SEP.'libs'.SEP.'wcf',
	ROOT.SEP.'includes'.SEP.'libs'.SEP.'zip',
	ROOT.SEP.'includes'.SEP.'pages',
	ROOT.SEP.'includes'.SEP.'pages',
	ROOT.SEP.'includes'.SEP.'pages'.SEP.'adm',
	ROOT.SEP.'includes'.SEP.'pages'.SEP.'game',
	ROOT.SEP.'includes'.SEP.'pages'.SEP.'install',
	ROOT.SEP.'includes'.SEP.'pages'.SEP.'login',
);

ini_set('include_path', get_include_path().$include_path_seperator.implode($include_path_seperator, $myPaths));

require 'autoload.class.php';
require 'constants.php';

if(is_file(ROOT.'includes'.SEP.'config.php') === true && filesize(ROOT.'includes'.SEP.'config.php') != 0)
{
	require ROOT.'includes'.SEP.'config.php';
}
else
{
	require 'config.sample.php';
}

require 'dbtables.php';
require 'HTTP.class.php';
require 'AbstractPage.class.php';
require 'ShowErrorPage.class.php';
require 'Smarty.class.php';
require 'CacheFile.class.php';
require 'GlobalFunction.abstract.class.php';
require 'load_functions.abstract.class.php';