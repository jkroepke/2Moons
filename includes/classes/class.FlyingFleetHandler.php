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
 * @version 1.6.1 (2011-11-19)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

if (!defined('INSIDE')) die(header("location:../../"));

class FlyingFleetHandler
{	
	function __construct($fleetquery)
	{
		global $db;
		$MissionsPattern	= array(
			1	=> 'MissionCaseAttack',
			2	=> 'MissionCaseACS',
			3	=> 'MissionCaseTransport',
			4	=> 'MissionCaseStay',
			5	=> 'MissionCaseStayAlly',
			6	=> 'MissionCaseSpy',
			7	=> 'MissionCaseColonisation',
			8	=> 'MissionCaseRecycling',
			9	=> 'MissionCaseDestruction',
			10	=> 'MissionCaseMIP',
			11	=> 'MissionCaseFoundDM',
			15	=> 'MissionCaseExpedition',
		);
		
		require_once(ROOT_PATH.'includes/classes/class.MissionFunctions.php');
		while ($CurrentFleet = $db->fetch_array($fleetquery))
		{
			if(!isset($MissionsPattern[$CurrentFleet['fleet_mission']])) {
				$db->query("DELETE FROM ".FLEETS." WHERE `fleet_id` = '".$CurrentFleet['fleet_id']."';");
				continue;
			}
			
			if(!$this->IfFleetBusy($CurrentFleet['fleet_id'])) continue;
			getConfig($CurrentFleet['fleet_universe']);
			
			require_once(ROOT_PATH.'includes/classes/missions/'.$MissionsPattern[$CurrentFleet['fleet_mission']].'.php');
			$Mission	= new $MissionsPattern[$CurrentFleet['fleet_mission']]($CurrentFleet);
			
			if($CurrentFleet['fleet_mess'] == 0 && $CurrentFleet['fleet_start_time'] <= TIMESTAMP)
				$Mission->TargetEvent();
			elseif($CurrentFleet['fleet_mess'] == 2 && $CurrentFleet['fleet_end_stay'] <= TIMESTAMP)	
				$Mission->EndStayEvent();
			elseif($CurrentFleet['fleet_mess'] == 1 && $CurrentFleet['fleet_end_time'] <= TIMESTAMP)
				$Mission->ReturnEvent();
				
			$Mission = NULL;
			unset($Mission);

			$db->query("UPDATE ".FLEETS." SET `fleet_busy` = '0' WHERE `fleet_id` = '".$CurrentFleet['fleet_id']."';");
		}
	}
	
	function IfFleetBusy($FleetID)
	{
		global $db;
		$FleetInfo	= $db->uniquequery("SELECT fleet_busy FROM ".FLEETS." WHERE `fleet_id` = '".$FleetID."';");
		if($FleetInfo['fleet_busy'] == 1) {
			return false;
		} else {
			$db->query("UPDATE ".FLEETS." SET `fleet_busy` = '1' WHERE `fleet_id` = '".$FleetID."';");
			return true;
		}
	}
}
?>