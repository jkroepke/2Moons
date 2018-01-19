<?php

/**
 *  2Moons 
 *   by Jan-Otto Kröpke 2009-2016
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan-Otto Kröpke <slaver7@gmail.com>
 * @copyright 2009 Lucky
 * @copyright 2016 Jan-Otto Kröpke <slaver7@gmail.com>
 * @licence MIT
 * @version 1.8.0
 * @link https://github.com/jkroepke/2Moons
 */

define('MODE', 'CRON');
define('ROOT_PATH', str_replace('\\', '/',dirname(__FILE__)).'/');
set_include_path(ROOT_PATH);

require 'includes/common.php';

$session	= Session::load();

// Output transparent gif
HTTP::sendHeader('Cache-Control', 'no-cache');
HTTP::sendHeader('Content-Type', 'image/gif');
HTTP::sendHeader('Expires', '0');


echo("\x47\x49\x46\x38\x39\x61\x01\x00\x01\x00\x80\x00\x00\x00\x00\x00\x00\x00\x00\x21\xF9\x04\x01\x00\x00\x00\x00\x2C\x00\x00\x00\x00\x01\x00\x01\x00\x00\x02\x02\x44\x01\x00\x3B");

if(!$session->isValidSession())
{
	exit;
}

$cronjobID	= HTTP::_GP('cronjobID', 0);

if(empty($cronjobID))
{
	exit;
}

require 'includes/classes/Cronjob.class.php';

$cronjobsTodo	= Cronjob::getNeedTodoExecutedJobs();
if(!in_array($cronjobID, $cronjobsTodo))
{
	exit;
}

Cronjob::execute($cronjobID);
