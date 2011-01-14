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

class MissionCaseColonisation extends MissionFunctions
{
	function __construct($Fleet)
	{
		$this->_fleet	= $Fleet;
	}
	
	function TargetEvent()
	{	
		global $db, $resource, $LANG;
		$iPlanetCount 	= $db->countquery("SELECT count(*) FROM ".PLANETS." WHERE `id_owner` = '". $this->_fleet['fleet_owner'] ."' AND `planet_type` = '1' AND `destruyed` = '0';");
		$iGalaxyPlace 	= $db->countquery("SELECT count(*) AS plani FROM ".PLANETS." WHERE `id` = '".$this->_fleet['fleet_end_id']."';");
		$Player			= $db->uniquequery("SELECT `lang`, `authlevel`, `".$resource[124]."` FROM ".USERS." WHERE `id` = '".$this->_fleet['fleet_owner']."';");
		$LNG			= $LANG->GetUserLang($Player['lang']);
		$MaxPlanets		= MaxPlanets($Player[$resource[124]]);
		if ($iGalaxyPlace != 0)
		{
			$TheMessage = sprintf($LNG['sys_colo_notfree'], GetTargetAdressLink($this->_fleet, ''));
			$this->UpdateFleet('fleet_mess', 1);
		}
		elseif($iPlanetCount >= $MaxPlanets)
		{
			$TheMessage = sprintf($LNG['sys_colo_maxcolo'] , GetTargetAdressLink($this->_fleet, ''), $MaxPlanets);
			$this->UpdateFleet('fleet_mess', 1);
		}
		else
		{
			require_once(ROOT_PATH.'includes/functions/CreateOnePlanetRecord.php');
			$NewOwnerPlanet = CreateOnePlanetRecord($this->_fleet['fleet_end_galaxy'], $this->_fleet['fleet_end_system'], $this->_fleet['fleet_end_planet'], $this->_fleet['fleet_universe'], $this->_fleet['fleet_owner'], $LNG['fcp_colony'], false, $Player['authlevel']);
			if($NewOwnerPlanet === false)
			{
				$TheMessage = sprintf($LNG['sys_colo_badpos'], GetTargetAdressLink($this->_fleet, ''));
				$this->UpdateFleet('fleet_mess', 1);
			}
			else
			{
				$this->_fleet['fleet_end_id']	= $NewOwnerPlanet;
				$TheMessage = sprintf($LNG['sys_colo_allisok'], GetTargetAdressLink($this->_fleet, ''));
				$this->StoreGoodsToPlanet();
				if ($this->_fleet['fleet_amount'] == 1) {
					$this->KillFleet();
				} else {
					$CurrentFleet = explode(";", $this->_fleet['fleet_array']);
					$NewFleet     = '';
					foreach ($CurrentFleet as $Item => $Group)
					{
						if (empty($Group)) continue;

						$Class = explode (",", $Group);
						if ($Class[0] == 208 && $Class[1] > 1)
							$NewFleet  .= $Class[0].",".($Class[1] - 1).";";
						elseif ($Class[0] != 208 && $Class[1] > 0)
							$NewFleet  .= $Class[0].",".$Class[1].";";
					}
					$this->UpdateFleet('fleet_array', $NewFleet);
					$this->UpdateFleet('fleet_amount', ($this->_fleet['fleet_amount'] - 1));
					$this->UpdateFleet('fleet_resource_metal', 0);
					$this->UpdateFleet('fleet_resource_crystal', 0);
					$this->UpdateFleet('fleet_resource_deuterium', 0);
					$this->UpdateFleet('fleet_mess', 1);
				}
			}
		}
		SendSimpleMessage($this->_fleet['fleet_owner'], 0, $this->_fleet['fleet_start_time'], 4, $LNG['sys_colo_mess_from'], $LNG['sys_colo_mess_report'], $TheMessage);
		$this->SaveFleet();
	}
	
	function EndStayEvent()
	{
		return;
	}
	
	function ReturnEvent()
	{
		$this->RestoreFleet();
	}
}
?>