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
 
#$GLOBALS['DATABASE']->query("LOCK TABLE ".AKS." WRITE, ".RW." WRITE, ".MESSAGES." WRITE, ".CONFIG." WRITE, ".FLEETS_EVENT." WRITE, ".FLEETS." WRITE, ".PLANETS." WRITE, ".PLANETS." as p WRITE, ".TOPKB." WRITE, ".USERS." WRITE, ".USERS." as u WRITE, ".STATPOINTS." WRITE;");	

$token			= getRandomString();

$fleetResult	= $GLOBALS['DATABASE']->query("UPDATE ".FLEETS_EVENT." SET `lock` = '".$token."' WHERE `lock` IS NULL AND `time` <= ". TIMESTAMP .";");

if($GLOBALS['DATABASE']->affectedRows() !== 0) {
	require_once(ROOT_PATH . 'includes/classes/class.FlyingFleetHandler.php');
	
	$fleetObj	= new FlyingFleetHandler();
	$fleetObj->setToken($token);
	$fleetObj->run();

	$GLOBALS['DATABASE']->query("UPDATE ".FLEETS_EVENT." SET `lock` = NULL WHERE `lock` = '".$token."';"); #UNLOCK TABLES
}