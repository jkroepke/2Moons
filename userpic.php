<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @licence MIT
 * @version 1.7.2 (2013-03-18)
 * @info $Id$
 * @link http://2moons.cc/
 */

define('MODE', 'BANNER');
define('ROOT_PATH', str_replace('\\', '/',dirname(__FILE__)).'/');
set_include_path(ROOT_PATH);

if(!extension_loaded('gd')) {
	clearGIF();
}

require 'includes/common.php';
$id = HTTP::_GP('id', 0);

if(!isModuleAvailable(MODULE_BANNER) || $id == 0) {
	clearGIF();
}

$LNG = new Language;
$LNG->getUserAgentLanguage();
$LNG->includeData(array('L18N', 'BANNER', 'CUSTOM'));

require 'includes/classes/class.StatBanner.php';

$banner = new StatBanner();
$Data	= $banner->GetData($id);
if(!isset($Data) || !is_array($Data)) {
	clearGIF();
}
	
$ETag	= md5(implode('', $Data));
header('ETag: '.$ETag);

if(isset($_SERVER['HTTP_IF_NONE_MATCH']) && $_SERVER['HTTP_IF_NONE_MATCH'] == $ETag) {
	HTTP::sendHeader('HTTP/1.0 304 Not Modified');
	exit;
}

$banner->CreateUTF8Banner($Data);