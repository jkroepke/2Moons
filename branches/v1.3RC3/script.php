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
 * @copyright 2009 Lucky <douglas@crockford.com> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.3 (2011-01-21)
 * @link http://code.google.com/p/2moons/
 */

header('Cache-Control: must-revalidate, max-age=86400');
header('Expires: '.gmdate('D, d M Y H:i:s', time() + 86400).' GMT');
header('Content-Type: application/x-javascript');

ini_set('zlib.output_compression', 'On');
define('ROOT_PATH', str_replace('\\', '/',dirname(__FILE__)).'/');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(!isset($_GET['script']))
	exit(header('HTTP/1.1 204 No Content'));

$CACHE	= ROOT_PATH.'cache/'.md5($_GET['script']).'.js.php';
if(file_exists($CACHE) && !isset($_GET['cache'])) {
	include($CACHE);
	exit;
} else {
	file_put_contents($CACHE, '');
}

require_once(ROOT_PATH.'includes/libs/JSMin/jsmin.php');

$SCRIPTS	= explode(';', str_replace(array('/', '\\', '-', '.'), '', $_GET['script']));
if(!is_array($SCRIPTS))
	exit(header('HTTP/1.1 204 No Content'));
	
foreach($SCRIPTS as $FILE) {
	$JSSOUCRE	= JSMin::minify(file_get_contents(ROOT_PATH.'scripts/'.$FILE.'.js'));
	echo $JSSOUCRE;
	file_put_contents($CACHE, $JSSOUCRE, FILE_APPEND);
}

?>