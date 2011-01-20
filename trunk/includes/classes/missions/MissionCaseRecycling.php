<?php

##############################################################################
# *                                                                          #
# * 2MOONS                                                                   #
# *                                                                          #
# * @copyright Copyright (C) 2010 By ShadoX from titanspace.org              #
# *                                                                          #
# *	                                                                         #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.                                     #
# *	                                                                         #
# *  This program is distributed in the hope that it will be useful,         #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of          #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           #
# *  GNU General Public License for more details.                            #
# *                                                                          #
##############################################################################

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
			if (empty($Group)) continue;

			$Class       			= explode(",", $Group);
			$RecyclerCapacity		= $Class[0] == 209 || $Class[0] == 219 ? bcadd($RecyclerCapacity, bcmul($pricelist[$Class[0]]['capacity'], $Class[1])) : bcadd($OtherFleetCapacity, bcmul($pricelist[$Class[0]]['capacity'], $Class[1]));
		}		
		
		$IncomingFleetGoods 	= bcadd($this->_fleet['fleet_resource_metal'], bcadd($this->_fleet['fleet_resource_crystal'], $this->_fleet['fleet_resource_deuterium']));
		if ($IncomingFleetGoods > $OtherFleetCapacity)
			$RecyclerCapacity	= bcsub($RecyclerCapacity, bcsub($IncomingFleetGoods, $OtherFleetCapacity));		
		
		$RecycledGoods	= array('metal' => 0, 'crystal' => 0);

		if(bccomp($RecyclerCapacity, $Target['der_total'], 0) !== -1){
			$RecycledGoods['metal'] 	= $Target['der_metal'];
			$RecycledGoods['crystal'] 	= $Target['der_crystal'];
		} else {
			$PC = bcdiv($RecyclerCapacity, $Target['der_total'], 50);
			
			$RecycledGoods['metal'] 	= bcmul($Target['der_metal'], $PC , 0);
			$RecycledGoods['crystal'] 	= bcmul($Target['der_crystal'], $PC, 0);
		}		
	
		$db->query("UPDATE ".PLANETS." SET `der_metal` = `der_metal` - ".$RecycledGoods['metal'].", `der_crystal` = `der_crystal` - ".$RecycledGoods['crystal']." WHERE `id` = '".$this->_fleet['fleet_end_id']."';");

		$LNG			= $LANG->GetUserLang($this->_fleet['fleet_owner']);
		$Message 		= sprintf($LNG['sys_recy_gotten'], pretty_number($RecycledGoods['metal']), $LNG['Metal'], pretty_number($RecycledGoods['crystal']), $LNG['Crystal']);
		SendSimpleMessage($this->_fleet['fleet_owner'], '', $this->_fleet['fleet_start_time'], 4, $LNG['sys_mess_tower'], $LNG['sys_recy_report'], $Message);
		
		$this->UpdateFleet('fleet_resource_metal', bcadd($this->_fleet['fleet_resource_metal'], $RecycledGoods['metal']));
		$this->UpdateFleet('fleet_resource_crystal', bcadd($this->_fleet['fleet_resource_crystal'], $RecycledGoods['crystal']));
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