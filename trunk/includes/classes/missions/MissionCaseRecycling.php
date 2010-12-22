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
		$Target				 = $db->uniquequery("SELECT der_metal, der_crystal FROM ".PLANETS." WHERE `id` = '".$this->_fleet['fleet_end_id']."';");
		$FleetRecord         = explode(";", $this->_fleet['fleet_array']);
		$RecyclerCapacity    = 0;
		$OtherFleetCapacity  = 0;
		
		foreach ($FleetRecord as $Item => $Group)
		{
			if (empty($Group)) continue;

			$Class       			= explode (",", $Group);
			if ($Class[0] == 209 || $Class[0] == 219)
				$RecyclerCapacity   = HLadd($RecyclerCapacity, HLmul($pricelist[$Class[0]]['capacity'], $Class[1]));
			else
				$OtherFleetCapacity = HLadd($OtherFleetCapacity, HLmul($pricelist[$Class[0]]['capacity'], $Class[1]));
		}		
		
		$IncomingFleetGoods 	= $this->_fleet['fleet_resource_metal'] + $this->_fleet['fleet_resource_crystal'] + $this->_fleet['fleet_resource_deuterium'];
		if ($IncomingFleetGoods > $OtherFleetCapacity)
			$RecyclerCapacity	= HLsub($RecyclerCapacity, HLsub($IncomingFleetGoods, $OtherFleetCapacity));		
		
		$RecycledGoods['metal']   	= min($Target['der_metal'], HLdiv($RecyclerCapacity, 2));
		$RecycledGoods['crystal'] 	= min($Target['der_crystal'], HLdiv($RecyclerCapacity, 2));		
		$Target['der_metal']		= HLsub($Target['der_metal'], $RecycledGoods['metal']);
		$Target['der_crystal']		= HLsub($Target['der_crystal'], $RecycledGoods['crystal']);
		
		$RecyclerCapacity			= HLsub($RecyclerCapacity, HLadd($RecycledGoods['metal'], $RecycledGoods['crystal']));
		if($Target['der_metal'] !== '0')
			$RecycledGoods['metal']   = HLadd($RecycledGoods['metal'], min($Target['der_metal'], $RecyclerCapacity));
		elseif($Target['der_crystal'] !== '0')
			$RecycledGoods['crystal'] = HLadd($RecycledGoods['crystal'], min($Target['der_crystal'], $RecyclerCapacity));
	
	
		$db->query("UPDATE ".PLANETS." SET `der_metal` = `der_metal` - '".$RecycledGoods['metal']."', `der_crystal` = `der_crystal` - '".$RecycledGoods['crystal']."' WHERE `id` = '".$this->_fleet['fleet_end_id']."';");

		$LNG			= $LANG->GetUserLang($this->_fleet['fleet_owner']);
		$Message 		= sprintf($LNG['sys_recy_gotten'], pretty_number($RecycledGoods['metal']), $LNG['Metal'], pretty_number($RecycledGoods['crystal']), $LNG['Crystal']);
		SendSimpleMessage($this->_fleet['fleet_owner'], '', $this->_fleet['fleet_start_time'], 4, $LNG['sys_mess_tower'], $LNG['sys_recy_report'], $Message);
		
		$this->UpdateFleet('fleet_resource_metal', HLadd($this->_fleet['fleet_resource_metal'], $RecycledGoods['metal']));
		$this->UpdateFleet('fleet_resource_crystal', HLadd($this->_fleet['fleet_resource_crystal'], $RecycledGoods['crystal']));
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