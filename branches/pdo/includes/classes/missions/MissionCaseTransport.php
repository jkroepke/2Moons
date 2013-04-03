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
 * @version 1.7.2 (2013-03-18)
 * @info $Id$
 * @link http://2moons.cc/
 */
class MissionCaseTransport extends MissionFunctions
{		
	function __construct($Fleet)
	{
		$this->_fleet	= $Fleet;
	}
	
	function TargetEvent()
	{
		$StartPlanet	= $GLOBALS['DATABASE']->getFirstRow("SELECT name FROM ".PLANETS." WHERE `id` = '". $this->_fleet['fleet_start_id'] ."';");
		$StartName		= $StartPlanet['name'];
		$StartOwner		= $this->_fleet['fleet_owner'];

		$TargetPlanet	= $GLOBALS['DATABASE']->getFirstRow("SELECT name FROM ".PLANETS." WHERE `id` = '". $this->_fleet['fleet_end_id'] ."';");
		$TargetName		= $TargetPlanet['name'];
		$TargetOwner	= $this->_fleet['fleet_target_owner'];
		
		$LNG			= $this->getLanguage(NULL, $StartOwner);
		$Message		= sprintf($LNG['sys_tran_mess_owner'], $TargetName, GetTargetAdressLink($this->_fleet, ''), pretty_number($this->_fleet['fleet_resource_metal']), $LNG['tech'][901], pretty_number($this->_fleet['fleet_resource_crystal']), $LNG['tech'][902], pretty_number($this->_fleet['fleet_resource_deuterium']), $LNG['tech'][903]);
		PlayerUtil::sendMessage($StartOwner, 0, $this->_fleet['fleet_start_time'], 5, $LNG['sys_mess_tower'], $LNG['sys_mess_transport'], $Message);
		if ($TargetOwner != $StartOwner) 
		{
			$LNG			= $this->getLanguage(NULL, $TargetOwner);
			$Message        = sprintf($LNG['sys_tran_mess_user'], $StartName, GetStartAdressLink($this->_fleet, ''), $TargetName, GetTargetAdressLink($this->_fleet, ''), pretty_number($this->_fleet['fleet_resource_metal']), $LNG['tech'][901], pretty_number($this->_fleet['fleet_resource_crystal']), $LNG['tech'][902], pretty_number($this->_fleet['fleet_resource_deuterium']), $LNG['tech'][903] );
			PlayerUtil::sendMessage($TargetOwner, 0, $this->_fleet['fleet_start_time'], 5, $LNG['sys_mess_tower'], $LNG['sys_mess_transport'], $Message);
		}
	
		$this->StoreGoodsToPlanet();
		$this->setState(FLEET_RETURN);
		$this->SaveFleet();
	}
	
	function EndStayEvent()
	{
		return;
	}
	
	function ReturnEvent()
	{
		$LNG		= $this->getLanguage(NULL, $this->_fleet['fleet_owner']);
		$StartName	= $GLOBALS['DATABASE']->getFirstCell("SELECT name FROM ".PLANETS." WHERE id = ".$this->_fleet['fleet_start_id'].";");
		$Message	= sprintf($LNG['sys_tran_mess_back'], $StartName, GetStartAdressLink($this->_fleet, ''));
		PlayerUtil::sendMessage($this->_fleet['fleet_owner'], 0, $this->_fleet['fleet_end_time'], 5, $LNG['sys_mess_tower'], $LNG['sys_mess_fleetback'], $Message);
		$this->RestoreFleet();
	}
}