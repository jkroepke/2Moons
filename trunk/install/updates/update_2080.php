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
 

define('INSIDE', true );

define("BETA", false);
define('ROOT_PATH', str_replace('\\', '/', dirname(__FILE__)).'/');
require_once(ROOT_PATH . 'includes/config.php');
require_once(ROOT_PATH . 'includes/constants.php');	
require_once(ROOT_PATH . 'includes/classes/class.MySQLi.php');
$db 	= new DB_MySQLi();

$RW		= $db->query("SELECT rid, raport FROM ".RW.";");

while($raport = $db->fetch_array($RW)) {
	$OLD	= unserialize($raport['raport']);
	$NEW 	= $OLD;

	unset($NEW['rounds']);

	foreach($OLD['rounds'] as $Key => $OldRounds) {
		foreach($OldRounds['attacker'] as $PlayerID => $Player) {
			if(isset($Player['userID'])) {
				$Temp	= $Player;
			} else {
				$Temp	= array();
				$Temp['userID']	= $PlayerID;
				$Temp['ships']	= $Player;
			}
			$NEW['rounds'][$Key]['attacker'][]	= $Temp;
		}
		foreach($OldRounds['defender'] as $PlayerID => $Player) {
			if(isset($Player['userID'])) {
				$Temp	= $Player;
			} else {
				$Temp	= array();
				$Temp['userID']	= $PlayerID;
				$Temp['ships']	= $Player;
			}
			
			$NEW['rounds'][$Key]['defender'][]	= $Temp;
		}
		if(isset($OldRounds['info']))
			$NEW['rounds'][$Key]['info']	= $OldRounds['info'];
		else
			$NEW['rounds'][$Key]['info']	= array(NULL, NULL, NULL, NULL);
	}
	$db->query("UPDATE ".RW." SET raport = '".serialize($NEW)."' WHERE rid = ".$raport['rid'].";");
}
	exit("Done");
?>