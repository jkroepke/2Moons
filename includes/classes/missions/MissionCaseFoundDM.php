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
 * @version 1.3 (2011-01-21)
 * @link http://code.google.com/p/2moons/
 */

class MissionCaseFoundDM extends MissionFunctions
{
	const CHANCE = 30; 
	const CHANCE_SHIP = 0.25; 
	const MIN_FOUND = 423; 
	const MAX_FOUND = 1278; 
	const MAX_CHANCE = 50; 
		
	function __construct($Fleet)
	{
		$this->_fleet	= $Fleet;
	}
	
	function TargetEvent()
	{
		$this->UpdateFleet('fleet_mess', 2);
		$this->SaveFleet();
	}
	
	function EndStayEvent()
	{
		global $LANG;
		$LNG			= $LANG->GetUserLang($this->_fleet['fleet_owner']);
		$chance 		= mt_rand(0, 100);
		if($chance <= min(self::MAX_CHANCE, (self::CHANCE + $this->_fleet['fleet_amount'] * self::CHANCE_SHIP))) {
			$FoundDark 	= mt_rand(self::MIN_FOUND, self::MAX_FOUND);
			$this->UpdateFleet('fleet_resource_darkmatter', $FoundDark);
			$Message 	= $LNG['sys_expe_found_dm_'.mt_rand(1, 3).'_'.mt_rand(1, 2).''];
		} else {
			$Message 	= $LNG['sys_expe_nothing_'.mt_rand(1, 9)];
		}
		$this->UpdateFleet('fleet_mess', 1);
		$this->SaveFleet();
		SendSimpleMessage($this->_fleet['fleet_owner'], '', $this->_fleet['fleet_end_stay'], 15, $LNG['sys_mess_tower'], $LNG['sys_expe_report'], $Message);
	}
	
	function ReturnEvent()
	{
		global $LANG;
		$LNG			= $LANG->GetUserLang($this->_fleet['fleet_owner']);
		if($this->_fleet['fleet_resource_darkmatter'] > 0) {
			SendSimpleMessage($this->_fleet['fleet_owner'], '', $this->_fleet['fleet_end_time'], 15, $LNG['sys_mess_tower'], $LNG['sys_expe_report'], sprintf($LNG['sys_expe_back_home_with_dm'], $LNG['Darkmatter'], pretty_number($this->_fleet['fleet_resource_darkmatter']), $LNG['Darkmatter']));
			$this->UpdateFleet('fleet_array', '220,0;');
		} else {
			SendSimpleMessage($this->_fleet['fleet_owner'], '', $this->_fleet['fleet_end_time'], 15, $LNG['sys_mess_tower'], $LNG['sys_expe_report'], $LNG['sys_expe_back_home_without_dm']);
		}
		$this->RestoreFleet();
	}
}

?>