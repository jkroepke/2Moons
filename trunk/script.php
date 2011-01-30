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

ini_set('zlib.output_compression', 'Off');
header('Content-Type: application/x-javascript');
define('ROOT_PATH', str_replace('\\', '/',dirname(__FILE__)).'/');

function CreateCache($CACHE) {
	$SCRIPTS	= explode(';', str_replace(array('/', '\\', '-', '.'), '', $_GET['script']));
	if(!is_array($SCRIPTS))
		exit(header('HTTP/1.1 204 No Content'));

	$JSSOUCRE	= '';
	foreach($SCRIPTS as $FILE)
		$JSSOUCRE	.= file_get_contents(ROOT_PATH.'scripts/'.$FILE.'.js')."\n";

	require_once(ROOT_PATH.'includes/libs/JSMin/jsmin.php');
	$JSMIN	= JSMin::minify($JSSOUCRE);
	$PHP	= '<?php'."\r\n";
	$PHP	.= '$REV	= "'.(int)$_GET['v'].'";'."\r\n";
	$PHP	.= 'function output() {'."\r\n";
	$PHP	.= '?>';
	$PHP	.= $JSMIN;
	$PHP	.= '<?php }'."\r\n";
	$PHP	.= '?>';
	file_put_contents(ROOT_PATH.'cache/'.$CACHE.'.js.php', $PHP);
	return $JSMIN;
}
 

if(!isset($_GET['script']))
	exit(header('HTTP/1.1 204 No Content'));


$CACHE	= md5($_GET['script']);
$ETag	= $CACHE;
header('ETag: '.$ETag);
if(file_exists(ROOT_PATH.'cache/'.$CACHE.'.js.php')) {
	include(ROOT_PATH.'cache/'.$CACHE.'.js.php');
	if($REV	== (int)$_GET['v']) {
		if(isset($_SERVER['HTTP_IF_NONE_MATCH']) && $_SERVER['HTTP_IF_NONE_MATCH'] == $ETag) {
			header('HTTP/1.0 304 Not Modified');
		} else {
			output();
		}
		exit;
	} else {
		unlink(ROOT_PATH.'cache/'.$CACHE.'.js.php');
	}
}
echo CreateCache($CACHE);

?>