<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
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
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.1 (2013-01-18)
 * @info $Id$
 * @link http://2moons.cc/
 */

class MissionCaseMIP extends MissionFunctions
{
	function __construct($Fleet)
	{
		$this->_fleet	= $Fleet;
	}
	
	function TargetEvent()
	{
		global $resource, $reslist;
		$SQL = "";
		
		$elementIDs	= array_merge($reslist['defense'], $reslist['missile']);
		foreach($elementIDs as $elementID)
		{
			$SQL	.= PLANETS.".".$resource[$elementID].", ";
		}
			
		$QryTarget		 	= "SELECT ".USERS.".lang, ".USERS.".shield_tech, ".PLANETS.".id, ".PLANETS.".name, ".PLANETS.".id_owner, ".substr($SQL, 0, -2)."
							   FROM ".PLANETS.", ".USERS."
							   WHERE ".PLANETS.".id = '".$this->_fleet['fleet_end_id']."' AND 
							   ".PLANETS.".id_owner = ".USERS.".id;";
		$targetData			= $GLOBALS['DATABASE']->getFirstRow($QryTarget);

		if($this->_fleet['fleet_end_type'] == 3)
		{
			$targetData[$resource[502]]	= $GLOBALS['DATABASE']->getFirstCell("SELECT ".$resource[502]." FROM ".PLANETS." WHERE id_luna = ".$this->_fleet['fleet_end_id'].";");
		}

		$OwnerInfo			= $GLOBALS['DATABASE']->getFirstRow("SELECT lang, military_tech FROM ".USERS." WHERE id = '".$this->_fleet['fleet_owner']."';");					   
		$Target				= (!in_array($this->_fleet['fleet_target_obj'], $reslist['defense']) || $this->_fleet['fleet_target_obj'] == 502 || $this->_fleet['fleet_target_obj'] == 0) ? 401 : $this->_fleet['fleet_target_obj'];

        $targetDefensive    = array();

		foreach($elementIDs as $elementID)	
		{
			$targetDefensive[$elementID]	= $targetData[$resource[$elementID]];
		}
		
		unset($targetDefensive[502]);
		
		$SQL 		= "";
		$LNG		= $this->getLanguage($GLOBALS['CONFIG'][$this->_fleet['fleet_universe']]['lang'], array('L18N', 'FLEET', 'TECH'));
				
		if ($targetData[$resource[502]] >= $this->_fleet['fleet_amount'])
		{
			$message 	= $LNG['sys_irak_no_att'];
			$where 		= $this->_fleet['fleet_end_type'] == 3 ? 'id_luna' : 'id';
			
			$SQL .= "UPDATE ".PLANETS." SET ".$resource[502]." = ".$resource[502]." - ".$this->_fleet['fleet_amount']." WHERE ".$where." = ".$targetData['id'].";";
		}
		else
		{
			if ($targetData[$resource[502]] > 0)
			{
				$where 		= $this->_fleet['fleet_end_type'] == 3 ? 'id_luna' : 'id';
				$GLOBALS['DATABASE']->query("UPDATE ".PLANETS." SET ".$resource[502]." = 0 WHERE ".$where." = ".$targetData['id'].";");
			}
			
			$targetDefensive = array_filter($targetDefensive);
			
			if(!empty($targetDefensive))
			{
				require_once 'calculateMIPAttack.php';
				$irak   	= calculateMIPAttack($targetData["shield_tech"], $OwnerInfo["military_tech"], $this->_fleet['fleet_amount'], $targetDefensive, $Target, $targetData[$resource[502]]);
				$irak		= array_filter($irak);
				
				$message	= sprintf($LNG['sys_irak_def'], $targetData[$resource[502]]).'<br><br>';
				
				ksort($irak, SORT_NUMERIC);
				
				foreach ($irak as $Element => $destroy)
				{
					$message .= $LNG['tech'][$Element].' (- '.$destroy.')<br>';
					
					if(in_array($Element, $reslist['one']))
						$SQL .= "UPDATE ".PLANETS." SET ".$resource[$Element]." = '0' WHERE id = ".$targetData['id'].";";
					else
						$SQL .= "UPDATE ".PLANETS." SET ".$resource[$Element]." = ".$resource[$Element]." - ".$destroy." WHERE id = ".$targetData['id'].";";
				}
			}
			else
			{
				$message = $LNG['sys_irak_no_def'];
			}
		}
				
		$UserPlanet 		= $GLOBALS['DATABASE']->getFirstRow("SELECT name FROM ".PLANETS." WHERE id = ".$this->_fleet['fleet_start_id'].";");
		$OwnerLink			= $UserPlanet['name']." [".$this->_fleet['fleet_start_galaxy'].":".$this->_fleet['fleet_start_system'].":".$this->_fleet['fleet_start_planet']."]";
		$TargetLink 		= $targetData['name']." [".$this->_fleet['fleet_end_galaxy'].":".$this->_fleet['fleet_end_system'].":".$this->_fleet['fleet_end_planet']."]";
		$Message			= sprintf($LNG['sys_irak_mess'], $this->_fleet['fleet_amount'], $OwnerLink, $TargetLink).$message;
	
		SendSimpleMessage($this->_fleet['fleet_owner'], 0, $this->_fleet['fleet_start_time'], 3, $LNG['sys_mess_tower'], $LNG['sys_irak_subject'], $Message);
		SendSimpleMessage($this->_fleet['fleet_target_owner'], 0, $this->_fleet['fleet_start_time'], 3, $LNG['sys_mess_tower'], $LNG['sys_irak_subject'], $Message);
		$SQL				.= "DELETE FROM ".FLEETS." WHERE fleet_id = '".$this->_fleet['fleet_id']."';";
		$GLOBALS['DATABASE']->multi_query($SQL);
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
