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

if (!defined('INSIDE')) exit;

class MissionFunctions
{	
	function __construct()
	{
		$this->kill	= 0;
	}

	function UpdateFleet($Option, $Value)
	{
		$this->_fleet[$Option] = $Value;
		$this->_upd[$Option] = $Value;
	}
	
	function SaveFleet()
	{
		global $db;
		if($this->kill == 1)
			return;
			
		foreach($this->_upd as $Opt => $Val)
		{
			$Qry[]	= "`".$Opt."` = '".$Val."'";
		}
		
		$db->query("UPDATE ".FLEETS." SET ".implode(', ',$Qry)." WHERE `fleet_id` = '".$this->_fleet['fleet_id']."';");
	}
		
	function RestoreFleet($Start = true)
	{
		global $resource, $db;

		$FleetRecord         = explode(';', $this->_fleet['fleet_array']);
		$QryUpdFleet         = '';
		foreach ($FleetRecord as $Item => $Group)
		{
			if (empty($Group)) continue;

			$Class			= explode(',', $Group);
			$QryUpdFleet	.= "p.`".$resource[$Class[0]]."` = p.`".$resource[$Class[0]]."` + '".floattostring($Class[1])."', ";
		}

		$Qry   = "UPDATE ".PLANETS." as p, ".USERS." as u SET ";
		if (!empty($QryUpdFleet))
			$Qry  .= $QryUpdFleet;

		$Qry  .= "p.`metal` = p.`metal` + '".floattostring($this->_fleet['fleet_resource_metal'])."', ";
		$Qry  .= "p.`crystal` = p.`crystal` + '".floattostring($this->_fleet['fleet_resource_crystal'])."', ";
		$Qry  .= "p.`deuterium` = p.`deuterium` + '".floattostring($this->_fleet['fleet_resource_deuterium'])."', ";
		$Qry  .= "u.`darkmatter` = u.`darkmatter` + '".floattostring($this->_fleet['fleet_resource_darkmatter'])."' ";
		$Qry  .= "WHERE ";
		$Qry  .= "p.`id` = '".($Start == true ? $this->_fleet['fleet_start_id'] : $this->_fleet['fleet_end_id'])."' ";
		$Qry  .= "AND u.id = p.id_owner;";
		$Qry  .= "DELETE FROM ".FLEETS." WHERE `fleet_id` = '".$this->_fleet['fleet_id']."';";
		$db->multi_query($Qry);
	}
	
	function StoreGoodsToPlanet($Start = false)
	{
		global $db;
		$Qry   = "UPDATE ".PLANETS." SET ";
		$Qry  .= "`metal` = `metal` + '".floattostring($this->_fleet['fleet_resource_metal'])."', ";
		$Qry  .= "`crystal` = `crystal` + '".floattostring($this->_fleet['fleet_resource_crystal'])."', ";
		$Qry  .= "`deuterium` = `deuterium` + '".floattostring($this->_fleet['fleet_resource_deuterium'])."' ";
		$Qry  .= "WHERE ";
		$Qry  .= "`id` = '".($Start == true ? $this->_fleet['fleet_start_id'] : $this->_fleet['fleet_end_id'])."';";
		$db->query($Qry);
		
		$this->UpdateFleet('fleet_resource_metal', '0');
		$this->UpdateFleet('fleet_resource_crystal', '0');
		$this->UpdateFleet('fleet_resource_deuterium', '0');
	}
	
	function KillFleet()
	{
		global $db;
		$this->kill	= 1;
		$db->query("DELETE FROM ".FLEETS." WHERE `fleet_id` = '".$this->_fleet['fleet_id']."';");
	}	
}
?>