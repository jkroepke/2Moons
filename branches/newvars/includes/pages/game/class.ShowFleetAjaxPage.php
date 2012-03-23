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

require_once(ROOT_PATH . 'includes/classes/class.FleetFunctions.php');


class ShowFleetAjaxPage extends AbstractPage
{
	public $returnData	= array();

    public static $requireModule = 0;

	function __construct() 
	{
		parent::__construct();
		$this->setWindow('ajax');
	}
	
	private function sendData($Code, $Message) {
		$this->returnData['code']	= $Code;
		$this->returnData['mess']	= $Message;
		$this->sendJSON($this->returnData);
	}
	
	public function show()
	{
		global $USER, $PLANET, $resource, $LNG, $CONF;
		
		$UserRecycles   = $PLANET[$resource[209]];
		$UserSpyProbes  = $PLANET[$resource[210]];
		$UserGRecycles  = $PLANET[$resource[219]];
		$UserDeuterium  = $PLANET['deuterium'];
		
		$planetID 		= HTTP::_GP('planetID', 0);
		$targetMission	= HTTP::_GP('mission', 0);
		
		$activeSlots	= FleetFunctions::GetCurrentFleets($USER['id']);
		$maxSlots		= FleetFunctions::GetMaxFleetSlots($USER);
		
		$this->returnData['slots']		= $activeSlots;
		$this->returnData['ship'][209]	= $UserRecycles;
		$this->returnData['ship'][210]	= $UserSpyProbes;
		$this->returnData['ship'][219]	= $UserGRecycles;
		
		if (IsVacationMode($USER)) {
			$this->sendData(620, $LNG['fa_vacation_mode_current']);
		}
		
		if (empty($planetID)) {
			$this->sendData(601, $LNG['fa_planet_not_exist']);
		}
		
		if ($maxSlots <= $activeSlots) {
			$this->sendData(612, $LNG['fa_no_more_slots']);
		}

		$fleetArray = array();

		switch($targetMission)
		{
			case 6:
				if(!isModulAvalible(MODULE_MISSION_SPY)) {
					$this->sendData(699, $LNG['sys_module_inactive']);
				}
				
				$SpyProbes	= (int) $_REQUEST['ship'][210];
				$SpyProbes	= min($SpyProbes, $UserSpyProbes);
				
				if(empty($SpyProbes)) {
					$this->sendData(611, $LNG['fa_no_spios']);
				}
				$fleetArray = array(210 => $SpyProbes);
			break;
			case 8:
				if(!isModulAvalible(MODULE_MISSION_RECYCLE)) {
					$this->sendData(699, $LNG['sys_module_inactive']);
				}
				
				$GRecycles	= (int) $_REQUEST['ship'][219];
				$Recycles	= (int) $_REQUEST['ship'][209];
				
				if(empty($Recycles) && empty($GRecycles)) {
					$this->sendData(611, $LNG['fa_no_recyclers']);
				}
					
				$fleetArray = array(209 => $Recycles, 219 => $GRecycles);
				break;
			default:
				$this->sendData(610, $LNG['fa_not_enough_probes']);
			break;
		}
		
		$fleetArray	= array_filter($fleetArray);
		
		if(empty($fleetArray)) {
			$this->sendData(610, $LNG['fa_not_enough_probes']);
		}
		
		$targetData	= $GLOBALS['DATABASE']->uniquequery("SELECT planet.id_owner as id_owner, 
										planet.galaxy as galaxy, 
										planet.system as system, 
										planet.planet as planet,
										planet.planet_type as planet_type, 
										total_points, onlinetime, urlaubs_modus, banaday, authattack
										FROM ".PLANETS." planet
										INNER JOIN ".USERS." user ON planet.id_owner = user.id
										INNER JOIN ".STATPOINTS." as stat ON stat.id_owner = user.id AND stat.stat_type = '1' 
										WHERE planet.id = ".$planetID.";");
		if (empty($targetData)) {
			$this->sendData(601, $LNG['fa_planet_not_exist']);
		}
		
		if($targetMission == 6)
		{
			if($CONF['adm_attack'] == 1 && $targetData['authattack'] > $USER['authlevel']) {
				$this->sendData(619, $LNG['fa_action_not_allowed']);
			}
			
			if (IsVacationMode($targetData)) {
				$this->sendData(605, $LNG['fa_vacation_mode']);
			}
			
			$IsNoobProtec	= CheckNoobProtec($USER, $targetData, $targetData);
			
			if ($IsNoobProtec['NoobPlayer']) {
				$this->sendData(603, $LNG['fa_week_player']);
			}
			
			if ($IsNoobProtec['StrongPlayer']) {
				$this->sendData(604, $LNG['fa_strong_player']);
			}

			if ($USER['id'] == $targetData['id_owner']) {
				$this->sendData(618, $LNG['fa_not_spy_yourself']);
			}
		}
		
		$SpeedFactor    	= FleetFunctions::GetGameSpeedFactor();
		$Distance    		= FleetFunctions::GetTargetDistance(array($PLANET['galaxy'], $PLANET['system'], $PLANET['planet']), array($targetData['galaxy'], $targetData['system'], $targetData['planet']));
		$SpeedAllMin		= FleetFunctions::GetFleetMaxSpeed($fleetArray, $USER);
		$Duration			= FleetFunctions::GetMissionDuration(10, $SpeedAllMin, $Distance, $SpeedFactor, $USER);
		$consumption		= FleetFunctions::GetFleetConsumption($fleetArray, $Duration, $Distance, $SpeedAllMin, $USER, $SpeedFactor);
		$Duration			= $Duration * (1 - $USER['factor']['FlyTime']);

		$UserDeuterium   	-= $consumption;

		if($UserDeuterium < 0) {
			$this->sendData(613, $LNG['fa_not_enough_fuel']);
		}
		
		if($consumption > FleetFunctions::GetFleetRoom($fleetArray)) {
			$this->sendData(613, $LNG['fa_no_fleetroom']);
		}
		
		if(connection_aborted())
			exit;
			
		$this->returnData['slots']++;
		
		$fleetRessource	= array(
			901	=> 0,
			902	=> 0,
			903	=> 0,
		);

		$fleetStartTime		= $Duration + TIMESTAMP;
		$fleetStayTime		= $fleetStartTime;
		$fleetEndTime		= $fleetStayTime + $Duration;
		
		$shipID				= array_keys($fleetArray);
		
		FleetFunctions::sendFleet($fleetArray, $targetMission, $USER['id'], $PLANET['id'], $PLANET['galaxy'], $PLANET['system'], $PLANET['planet'], $PLANET['planet_type'],
		$targetData['id_owner'], $planetID, $targetData['galaxy'], $targetData['system'], $targetData['planet'], $targetData['planet_type'], $fleetRessource, $fleetStartTime, $fleetStayTime, $fleetEndTime);
		$this->sendData(600, $LNG['fa_sending']." ".array_sum($fleetArray)." ". $LNG['tech'][$shipID[0]] ." ".$LNG['gl_to']." ".$targetData['galaxy'].":".$targetData['system'].":".$targetData['planet']." ...");
	}
}
?>