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
 * @version 1.8.0 (2013-03-18)
 * @info $Id$
 * @link http://2moons.cc/
 */

$token	= getRandomString();
$db		= Database::get();

$fleetResult	= $db->update("UPDATE %%FLEETS_EVENT%% SET `lock` = :token WHERE `lock` IS NULL AND `time` <= :time;", array(
	':time'		=> TIMESTAMP,
	':token'	=> $token
));

if($db->rowCount() !== 0) {
	require 'includes/classes/class.FlyingFleetHandler.php';
	
	$fleetObj	= new FlyingFleetHandler();
	$fleetObj->setToken($token);
	$fleetObj->run();

	$db->update("UPDATE %%FLEETS_EVENT%% SET `lock` = NULL WHERE `lock` = :token;", array(
		':token' => $token
	));
}