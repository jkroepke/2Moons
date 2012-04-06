<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan
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
 * @author Jan <info@2moons.cc>
 * @copyright 2006 Perberos <ugamela@perberos.com.ar> (UGamela)
 * @copyright 2008 Chlorel (XNova)
 * @copyright 2009 Lucky (XGProyecto)
 * @copyright 2012 Jan <info@2moons.cc> (2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.0 (2012-05-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

class MissionFunctions
{	
	public $kill	= 0;
	public $_fleet	= array();
	public $_upd	= array();
	
	function UpdateFleet($Option, $Value)
	{
		$this->_fleet[$Option] = $Value;
		$this->_upd[$Option] = $Value;
	}

	function setState($Value)
	{
		$this->_fleet['fleet_mess'] = $Value;
		$this->_upd['fleet_mess']	= $Value;
		
		switch($Value)
		{
			case FLEET_OUTWARD:
				$this->eventTime = $this->_fleet['fleet_start_time'];
			break;
			case FLEET_RETURN:
				$this->eventTime = $this->_fleet['fleet_end_time'];
			break;
			case FLEET_HOLD:
				$this->eventTime = $this->_fleet['fleet_end_stay'];
			break;
		}
	}

	function clearResource()
	{
		foreach(array_merge($GLOBALS['VARS']['LIST'][ELEMENT_PLANET_RESOURCE], $GLOBALS['VARS']['LIST'][ELEMENT_USER_RESOURCE]) as $resourceID)
		{
			$this->UpdateFleet('fleet_resource_'.$GLOBALS['VARS']['ELEMENT'][$resourceID]['name'], 0);
		}
	}
	
	function SaveFleet()
	{
		if($this->kill == 1)
			return;
			
		$Qry	= array();
		
		foreach($this->_upd as $Opt => $Val)
		{
			$Qry[]	= $Opt." = '".$Val."'";
		}
		
		if(!empty($Qry)) {
			$GLOBALS['DATABASE']->multi_query("UPDATE ".FLEETS." SET ".implode(', ',$Qry)." WHERE fleet_id = ".$this->_fleet['fleet_id'].";
											   UPDATE ".FLEETS_EVENT." SET time = ".$this->eventTime." WHERE `fleetID` = ".$this->_fleet['fleet_id'].";");
		}
	}
		
	function RestoreFleet($Start = true)
	{
		global $resource;

		$FleetRecord	= explode(';', $this->_fleet['fleet_array']);
		$updateSQL		= array();
		
		foreach ($FleetRecord as $Item => $Group)
		{
			if (empty($Group)) continue;

			$Class			= explode(',', $Group);
			$updateSQL[]	= $GLOBALS['VARS']['ELEMENT'][$Class[0]['name']]." = ".$GLOBALS['VARS']['ELEMENT'][$Class[0]['name']]." + ".$Class[1];
		}
	
		foreach(array_merge($GLOBALS['VARS']['LIST'][ELEMENT_PLANET_RESOURCE], $GLOBALS['VARS']['LIST'][ELEMENT_USER_RESOURCE]) as $resourceID)
		{
			$updateSQL[]	= $GLOBALS['VARS']['ELEMENT'][$resourceID]['name'].' = '.$GLOBALS['VARS']['ELEMENT'][$resourceID]['name'].' + '.$this->_fleet['fleet_resource_metal'].", ";
		}
		
		if(!empty($updateSQL))
		{
			$Qry   = "UPDATE ".PLANETS." as p, ".USERS." as u SET
					 ".implode(', ', $updateSQL)."
					 WHERE p.`id` = ".($Start == true ? $this->_fleet['fleet_start_id'] : $this->_fleet['fleet_end_id'])."
					 AND u.id = p.id_owner;";
					 
			$GLOBALS['DATABASE']->query($Qry);
		}
		
		$this->KillFleet();
	}
	
	function StoreGoodsToPlanet($Start = false)
	{
				$Qry   = "UPDATE ".PLANETS." SET ";
		$Qry  .= "`metal` = `metal` + ".$this->_fleet['fleet_resource_metal'].", ";
		$Qry  .= "`crystal` = `crystal` + ".$this->_fleet['fleet_resource_crystal'].", ";
		$Qry  .= "`deuterium` = `deuterium` + ".$this->_fleet['fleet_resource_deuterium']." ";
		$Qry  .= "WHERE ";
		$Qry  .= "`id` = ".($Start == true ? $this->_fleet['fleet_start_id'] : $this->_fleet['fleet_end_id']).";";
		$GLOBALS['DATABASE']->query($Qry);
		
		$this->UpdateFleet('fleet_resource_metal', '0');
		$this->UpdateFleet('fleet_resource_crystal', '0');
		$this->UpdateFleet('fleet_resource_deuterium', '0');
	}
	
	function KillFleet()
	{
		$this->kill	= 1;
		$GLOBALS['DATABASE']->multi_query("DELETE FROM ".FLEETS." WHERE `fleet_id` = ".$this->_fleet['fleet_id'].";
		DELETE FROM ".FLEETS_EVENT." WHERE `fleetID` = ".$this->_fleet['fleet_id'].";");
	}	
}
