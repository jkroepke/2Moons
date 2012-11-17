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

define('MODE', 'CRON');

define('ROOT_PATH', str_replace('\\', '/',dirname(__FILE__)).'/');
require(ROOT_PATH . 'includes/common.php');

// Output transparent gif
HTTP::sendHeader('Cache-Control', 'no-cache');
HTTP::sendHeader('Content-Type', 'image/gif');
HTTP::sendHeader('Expires', '0');
$isSessionActive	= $SESSION->isActiveSession();
echo("\x47\x49\x46\x38\x39\x61\x01\x00\x01\x00\x80\x00\x00\x00\x00\x00\x00\x00\x00\x21\xF9\x04\x01\x00\x00\x00\x00\x2C\x00\x00\x00\x00\x01\x00\x01\x00\x00\x02\x02\x44\x01\x00\x3B");

if($isSessionActive)
{
	exit;
}



$cronjobID	= HTTP::_GP('cronjobID', 0);

if(empty($cronjobID))
{
	exit;
}

require ROOT_PATH.'includes/classes/Cronjob.class.php';

$cronjobsTodo	= Cronjob::getNeedTodoExecutedJobs();
if(!in_array($cronjobID, $cronjobsTodo))
{
	exit;
}

Cronjob::execute($cronjobID);