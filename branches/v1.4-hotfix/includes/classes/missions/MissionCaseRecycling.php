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
 * @version 1.4 (2011-07-10)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

class MissionCaseRecycling extends MissionFunctions
{
	function __construct($Fleet)
	{
		$this->_fleet	= $Fleet;
	}
	
	function TargetEvent()
	{	
		global $db, $pricelist, $LANG;
		$Target				 = $db->uniquequery("SELECT der_metal, der_crystal, (der_metal + der_crystal) as der_total FROM ".PLANETS." WHERE `id` = '".$this->_fleet['fleet_end_id']."';");
		$FleetRecord         = explode(";", $this->_fleet['fleet_array']);
		$RecyclerCapacity    = 0;
		$OtherFleetCapacity  = 0;
		foreach ($FleetRecord as $Item => $Group)
		{
			if (empty($Group))
				continue;
				
			$Class        = explode (",", $Group);
			if ($Class[0] == 209 || $Class[0] == 219)
				$RecyclerCapacity   += $pricelist[$Class[0]]['capacity'] * $Class[1];
			else
				$OtherFleetCapacity += $pricelist[$Class[0]]['capacity'] * $Class[1];
		}
		$RecycledGoods	= array('metal' => 0, 'crystal' => 0);
		$IncomingFleetGoods = $FleetRow['fleet_resource_metal'] + $FleetRow['fleet_resource_crystal'] + $FleetRow['fleet_resource_deuterium'];
		if ($IncomingFleetGoods > $OtherFleetCapacity)
			$RecyclerCapacity -= ($IncomingFleetGoods - $OtherFleetCapacity);

		if ($Target['der_total'] <= $RecyclerCapacity) {
			$RecycledGoods['metal']   = $Target['der_metal'];
			$RecycledGoods['crystal'] = $Target['der_crystal'];
		} elseif (($Target['der_metal'] > $RecyclerCapacity / 2) && ($Target['der_crystal'] > $RecyclerCapacity / 2)) {
			$RecycledGoods['metal']   = $RecyclerCapacity / 2;
			$RecycledGoods['crystal'] = $RecyclerCapacity / 2;
		} elseif ($Target['der_metal'] > $Target['der_crystal']) {
			$RecycledGoods['crystal'] = $Target['der_crystal'];
			if ($Target['der_metal'] > ($RecyclerCapacity - $RecycledGoods['crystal']))
				$RecycledGoods['metal'] = $RecyclerCapacity - $RecycledGoods['crystal'];
			else
				$RecycledGoods['metal'] = $Target['der_metal'];
		} else {
			$RecycledGoods['metal'] = $Target['der_metal'];
			if ($Target['der_crystal'] > ($RecyclerCapacity - $RecycledGoods['metal']))
				$RecycledGoods['crystal'] = $RecyclerCapacity - $RecycledGoods['metal'];
			else
				$RecycledGoods['crystal'] = $Target['der_crystal'];
		}		
	
		$db->query("UPDATE ".PLANETS." SET `der_metal` = `der_metal` - ".$RecycledGoods['metal'].", `der_crystal` = `der_crystal` - ".$RecycledGoods['crystal']." WHERE `id` = '".$this->_fleet['fleet_end_id']."';");

		$LNG			= $LANG->GetUserLang($this->_fleet['fleet_owner']);
		$Message 		= sprintf($LNG['sys_recy_gotten'], pretty_number($RecycledGoods['metal']), $LNG['Metal'], pretty_number($RecycledGoods['crystal']), $LNG['Crystal']);
		SendSimpleMessage($this->_fleet['fleet_owner'], '', $this->_fleet['fleet_start_time'], 4, $LNG['sys_mess_tower'], $LNG['sys_recy_report'], $Message);
		
		$this->UpdateFleet('fleet_resource_metal', $this->_fleet['fleet_resource_metal'] + $RecycledGoods['metal']);
		$this->UpdateFleet('fleet_resource_crystal', $this->_fleet['fleet_resource_crystal'] + $RecycledGoods['crystal']);
		$this->UpdateFleet('fleet_mess', 1);
		$this->SaveFleet();
	}
	
	function EndStayEvent()
	{
		return;
	}
	
	function ReturnEvent()
	{
		global $LANG;
		$LNG				= $LANG->GetUserLang($this->_fleet['fleet_owner']);
	
		$Message         = sprintf( $LNG['sys_tran_mess_owner'], $TargetName, GetStartAdressLink($this->_fleet, ''), pretty_number($this->_fleet['fleet_resource_metal']), $LNG['Metal'], pretty_number($this->_fleet['fleet_resource_crystal']), $LNG['Crystal'], pretty_number($this->_fleet['fleet_resource_deuterium']), $LNG['Deuterium'] );
		SendSimpleMessage($this->_fleet['fleet_owner'], '', $this->_fleet['fleet_end_time'], 4, $LNG['sys_mess_tower'], $LNG['sys_mess_fleetback'], $Message);

		$this->RestoreFleet();
	}
}
?>