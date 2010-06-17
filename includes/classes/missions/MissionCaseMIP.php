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

class MissionCaseMIP extends MissionFunctions
{
	function __construct($Fleet)
	{
		$this->_fleet	= $Fleet;
	}
	
	function TargetEvent()
	{
		global $db, $resource, $reslist;
		$SQL = "";
		foreach($reslist['defense'] as $Element)
		{
			$SQL	.= PLANETS.".".$resource[$Element].", ";
		}
			
		$QryTarget		 	= "SELECT ".USERS.".defence_tech, ".PLANETS.".id, ".PLANETS.".id_owner, ".substr($SQL, 0, -2)."
							   FROM ".PLANETS.", ".USERS."
							   WHERE ".PLANETS.".`galaxy` = '".$this->_fleet['fleet_end_galaxy']."' AND 
							   ".PLANETS.".`system` = '".$this->_fleet['fleet_end_system']."' AND 
							   ".PLANETS.".`planet` = '".$this->_fleet['fleet_end_planet']."' AND 
							   ".PLANETS.".`planet_type` = '1' AND 
							   ".PLANETS.".id_owner = ".USERS.".id;";
								   
		$TargetInfo			= $db->uniquequery($QryTarget);					   
		$OwnerInfo			= $db->uniquequery("SELECT `military_tech` FROM ".USERS." WHERE `id` = '".$this->_fleet['fleet_owner']."';");					   
		$Target				= (!in_array($this->_fleet['fleet_target_obj'], $reslist['defense']) || $this->_fleet['fleet_target_obj'] == 502 || $this->_fleet['fleet_target_obj'] == 0) ? 401 : $this->_fleet['fleet_target_obj'];
		foreach($reslist['defense'] as $Element)		
		{
			$TargetDefensive[$Element]	= $TargetInfo[$resource[$Element]];
		}

		$message 			= "";
		$SQL 				= "";
			
		$LNG				= $this->GetUserLang(0);
		$LNG				+= $this->GetUserLang(0, 'TECH');
		
		require_once('calculateMIPAttack.'.PHP_EXT);	
		if ($TargetInfo[$resource[502]] >= $this->_fleet['fleet_amount'])
		{
			$message 	= $LNG['sys_irak_no_att'];
			$x 		 	= $resource[502];
			$SQL .= "UPDATE ".PLANETS." SET " . $x . " = " . $x . "-" . $this->_fleet['fleet_amount'] . " WHERE id = " . $TargetInfo['id'].";";
		}
		else
		{
			if ($TargetInfo[$resource[502]] > 0)
			{
				$db->query("UPDATE ".PLANETS." SET " . $resource[502] . " = '0'  WHERE id = " . $TargetInfo['id'].";");
				$message .= sprintf($LNG['sys_irak_def'], $TargetInfo[$resource[502]]);
			}
			
			$irak 	= calculateMIPAttack($TargetInfo["defence_tech"], $OwnerInfo["military_tech"], $this->_fleet['fleet_amount'], $TargetDefensive, $Target, $TargetInfo[$resource[502]]);
			ksort($irak, SORT_NUMERIC);
			$Count = 0;
			foreach ($irak as $Element => $destroy)
			{
				if(empty($Element))
					continue;

				if ($id != 502)
					$message .= $LNG['tech'][$id] . " (- " . $destroy . ")<br>";
				
				if ($destroy == 0)
					continue;

				$SQL 	.= "UPDATE ".PLANETS." SET `".$resource[$Element]."` = `".$resource[$Element]."` - '".$destroy."' WHERE id = ".$TargetInfo['id'].";";
			}
		}
				
		$UserPlanet 		= $db->fetch_array($db->query("SELECT name FROM ".PLANETS." WHERE id = '" . $this->_fleet['fleet_owner'] . "';"));
		$OwnerLink			= $UserPlanet['name']."[".$this->_fleet['fleet_start_galaxy'].":".$this->_fleet['fleet_start_system'].":".$this->_fleet['fleet_start_planet']."]";
		$TargetLink 		= $TargetInfo['name']."[".$this->_fleet['fleet_end_galaxy'].":".$this->_fleet['fleet_end_system'].":".$this->_fleet['fleet_end_planet']."]";;
		$Message			= sprintf($LNG['sys_irak_mess'], $this->_fleet['fleet_amount'], $OwnerLink, $TargetLink).(empty($message) ? $LNG['sys_irak_no_def'] : $message);
	
		SendSimpleMessage($this->_fleet['fleet_owner'], '', $this->_fleet['fleet_start_time'], 3, $LNG['sys_mess_tower'], $LNG['sys_irak_subject'] , $Message);
		SendSimpleMessage($TargetInfo['id_owner'], '', $this->_fleet['fleet_start_time'], 3, $LNG['sys_mess_tower'], $LNG['sys_irak_subject'] , $Message);
		$SQL				.= "DELETE FROM ".FLEETS." WHERE fleet_id = '" . $this->_fleet['fleet_id'] . "';";
		$db->multi_query($SQL);
	}
	
	function EndStayEvent()
	{
		return;
	}
	
	function ReturnEvent()
	{
		return;
	}
}

?>