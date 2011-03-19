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

class MissionCaseACS extends MissionFunctions
{
		
	function __construct($Fleet)
	{
		$this->_fleet	= $Fleet;
	}
	
	function TargetEvent()
	{
		return;
	}
	
	function EndStayEvent()
	{
		return;
	}
	
	function ReturnEvent()
	{
		global $LANG;
		$LNG		= $LANG->GetUserLang($this->_fleet['fleet_owner']);
	
		$Message 	= sprintf($LNG['sys_fleet_won'], $TargetName, GetTargetAdressLink($this->_fleet, ''), pretty_number($this->_fleet['fleet_resource_metal']), $LNG['Metal'], pretty_number($this->_fleet['fleet_resource_crystal']), $LNG['Crystal'], pretty_number($this->_fleet['fleet_resource_deuterium']), $LNG['Deuterium'] );
		SendSimpleMessage($this->_fleet['fleet_owner'], '', $this->_fleet['fleet_end_time'], 3, $LNG['sys_mess_tower'], $LNG['sys_mess_fleetback'], $Message);

		$this->RestoreFleet();
	}
}

?>