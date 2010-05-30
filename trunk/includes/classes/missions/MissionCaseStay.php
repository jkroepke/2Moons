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

class MissionCaseStay extends MissionFunctions
{
	function __construct($Fleet)
	{
		$this->_fleet	= $Fleet;
	}
	
	function TargetEvent()
	{	
		$LNG				= $this->GetUserLang($this->_fleet['fleet_owner']);
		
		$TargetUserID       = $this->_fleet['fleet_target_owner'];
		$TargetMessage      = sprintf($LNG['sys_stat_mess'], GetTargetAdressLink($this->_fleet, ''), pretty_number($this->_fleet['fleet_resource_metal']), $LNG['Metal'], pretty_number($this->_fleet['fleet_resource_crystal']), $LNG['Crystal'], pretty_number($this->_fleet['fleet_resource_deuterium']), $LNG['Deuterium']);
		SendSimpleMessage($TargetUserID, 0, $this->_fleet['fleet_start_time'], 5, $LNG['sys_mess_tower'], $LNG['sys_stat_mess_stay'], $TargetMessage);
		
		$this->RestoreFleet(false);
	}
	
	function EndStayEvent()
	{
		return;
	}
	
	function ReturnEvent()
	{
		$LNG				= $this->GetUserLang($this->_fleet['fleet_owner']);
	
		$TargetUserID       = $this->_fleet['fleet_target_owner'];
		$TargetMessage      = sprintf($LNG['sys_stat_mess'], GetStartAdressLink($this->_fleet, ''), pretty_number($this->_fleet['fleet_resource_metal']), $LNG['Metal'], pretty_number($this->_fleet['fleet_resource_crystal']), $LNG['Crystal'], pretty_number($this->_fleet['fleet_resource_deuterium']), $LNG['Deuterium']);
		SendSimpleMessage($TargetUserID, '', $this->_fleet['fleet_end_time'], 5, $LNG['sys_mess_tower'], $LNG['sys_stat_mess_stay'], $TargetMessage);
		
		$this->RestoreFleet();
	}
}
?>