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
		global $db, $pricelist;
		$Qry 	= "SELECT der_metal as metal,der_crystal as crystal FROM ".PLANETS."
				   WHERE 
				   `galaxy` = '".$this->_fleet['fleet_end_galaxy']."' AND
				   `system` = '".$this->_fleet['fleet_end_system']."' AND 
				   `planet` = '".$this->_fleet['fleet_end_planet']."' AND
				   `planet_type` = '1';";
		
		$Target	= $db->uniquequery($Qry);

		$FleetRecord         = explode(";", $this->_fleet['fleet_array']);
		$RecyclerCapacity    = 0;
		$OtherFleetCapacity  = 0;
		foreach ($FleetRecord as $Item => $Group)
		{
			if (empty($Group)) continue;

			$Class       			= explode (",", $Group);
			if ($Class[0] == 209 || $Class[0] == 219)
				$RecyclerCapacity   = bcadd($RecyclerCapacity, bcmul($pricelist[$Class[0]]['capacity'], $Class[1]));
			else
				$OtherFleetCapacity = bcadd($OtherFleetCapacity, bcmul($pricelist[$Class[0]]['capacity'], $Class[1]));
		}

		$IncomingFleetGoods = $this->_fleet['fleet_resource_metal'] + $this->_fleet['fleet_resource_crystal'] + $this->_fleet['fleet_resource_deuterium'];
		if ($IncomingFleetGoods > $OtherFleetCapacity)
			$RecyclerCapacity	= bcsub($RecyclerCapacity, bcsub($IncomingFleetGoods, $OtherFleetCapacity));
				
		$RecycledGoods['metal']   = min($Target['metal'], bcdiv($RecyclerCapacity, 2));
		$RecycledGoods['crystal'] = min($Target['crystal'], bcdiv($RecyclerCapacity, 2));	
		
		$RecyclerCapacity		  = bcsub($RecyclerCapacity, bcadd($RecycledGoods['metal'], $RecycledGoods['crystal']));
		
		if($RecyclerCapacity !== '0')
		{
			if(max($RecycledGoods['metal'], $Target['metal']) === $Target['metal'])
				$RecycledGoods['crystal'] = bcadd($RecycledGoods['crystal'], min(bcsub($Target['crystal'], $RecycledGoods['crystal']), $RecyclerCapacity));
			else
				$RecycledGoods['metal']   = bcadd($RecycledGoods['metal'], min(bcsub($Target['metal'], $RecycledGoods['metal']), $RecyclerCapacity));
		}
		
		$Qry	= "UPDATE ".PLANETS." SET
				  `der_metal` = `der_metal` - '".$RecycledGoods['metal']."',
				  `der_crystal` = `der_crystal` - '".$RecycledGoods['crystal']."'
				  WHERE
				  `galaxy` = '".$this->_fleet['fleet_end_galaxy']."' AND
				  `system` = '".$this->_fleet['fleet_end_system']."' AND
				  `planet` = '".$this->_fleet['fleet_end_planet']."' AND
				  `planet_type` = '1';";
		$db->query($Qry);

		$LNG			= $this->GetUserLang($this->_fleet['fleet_owner']);
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
		$LNG				= $this->GetUserLang($this->_fleet['fleet_owner']);
	
		$Message         = sprintf( $LNG['sys_tran_mess_owner'], $TargetName, GetStartAdressLink($this->_fleet, ''), pretty_number($this->_fleet['fleet_resource_metal']), $LNG['Metal'], pretty_number($this->_fleet['fleet_resource_crystal']), $LNG['Crystal'], pretty_number($this->_fleet['fleet_resource_deuterium']), $LNG['Deuterium'] );
		SendSimpleMessage($this->_fleet['fleet_owner'], '', $this->_fleet['fleet_end_time'], 4, $LNG['sys_mess_tower'], $LNG['sys_mess_fleetback'], $Message);

		$this->RestoreFleet();
	}
}
?>