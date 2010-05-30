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

class MissionCaseTransport extends MissionFunctions
{		
	function __construct($Fleet)
	{
		$this->_fleet	= $Fleet;
	}
	
	function TargetEvent()
	{
		global $db;
		$Qry	  	= "SELECT name FROM ".PLANETS." 
					   WHERE 
					   `galaxy` = '". $this->_fleet['fleet_start_galaxy'] ."' AND
					   `system` = '". $this->_fleet['fleet_start_system'] ."' AND
					   `planet` = '". $this->_fleet['fleet_start_planet'] ."' AND
					   `planet_type` = '". $this->_fleet['fleet_start_type'] ."';";
		$Result     	= $db->uniquequery($Qry);
		$StartName      = $Result['name'];
		$StartOwner     = $this->_fleet['fleet_owner'];

		$Qry		= "SELECT name FROM ".PLANETS."
					   WHERE
					   `galaxy` = '". $this->_fleet['fleet_end_galaxy'] ."' AND
					   `system` = '". $this->_fleet['fleet_end_system'] ."' AND
					   `planet` = '". $this->_fleet['fleet_end_planet'] ."' AND
					   `planet_type` = '". $this->_fleet['fleet_end_type'] ."';";
		$Result     	= $db->uniquequery($Qry);
		$TargetName     = $TargetPlanet['name'];
		$TargetOwner    = $this->_fleet['fleet_target_owner'];
		
		$this->StoreGoodsToPlanet();
		$LNG			= $this->GetUserLang($StartOwner);
		$Message        = sprintf( $LNG['sys_tran_mess_owner'], $TargetName, GetTargetAdressLink($this->_fleet, ''), pretty_number($this->_fleet['fleet_resource_metal']), $LNG['Metal'], pretty_number($this->_fleet['fleet_resource_crystal']), $LNG['Crystal'], pretty_number($this->_fleet['fleet_resource_deuterium']), $LNG['Deuterium'] );

		SendSimpleMessage($StartOwner, '', $this->_fleet['fleet_start_time'], 5, $LNG['sys_mess_tower'], $LNG['sys_mess_transport'], $Message);
		if ($TargetOwner != $StartOwner) 
		{
			$LNG			= $this->GetUserLang($TargetOwner);
			$Message        = sprintf($LNG['sys_tran_mess_user'], $StartName, GetStartAdressLink($this->_fleet, ''), $TargetName, GetTargetAdressLink($this->_fleet, ''), pretty_number($this->_fleet['fleet_resource_metal']), $LNG['Metal'], pretty_number($this->_fleet['fleet_resource_crystal']), $LNG['Crystal'], pretty_number($this->_fleet['fleet_resource_deuterium']), $LNG['Deuterium'] );
			SendSimpleMessage($TargetOwner, '', $this->_fleet['fleet_start_time'], 5, $LNG['sys_mess_tower'], $LNG['sys_mess_transport'], $Message);
		}
		
		$this->UpdateFleet('fleet_resource_metal', 0);
		$this->UpdateFleet('fleet_resource_crystal', 0);
		$this->UpdateFleet('fleet_resource_deuterium', 0);
		$this->UpdateFleet('fleet_mess', 1);
		$this->SaveFleet();
	}
	
	function EndStayEvent()
	{
		return;
	}
	
	function ReturnEvent()
	{
		$LNG			= $this->GetUserLang($this->_fleet['fleet_owner']);

		$Message		= sprintf ($LNG['sys_tran_mess_back'], $StartName, GetStartAdressLink($this->_fleet, ''));
		SendSimpleMessage($this->_fleet['fleet_owner'], '', $this->_fleet['fleet_end_time'], 5, $LNG['sys_mess_tower'], $LNG['sys_mess_fleetback'], $Message);
		$this->RestoreFleet();
	}
}
?>