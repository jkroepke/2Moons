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
 * @version 1.7.2 (2013-03-18)
 * @info $Id$
 * @link http://2moons.cc/
 */

class ShowBattleSimulatorPage extends AbstractGamePage 
{
	public static $requireModule = MODULE_SIMULATOR;

	function __construct() 
	{
		parent::__construct();
	}

	function send()
	{
		global $LNG;
		
		if(!isset($_REQUEST['battleinput'])) {
			$this->sendJSON(0);
		}
		
		$BattleArray	    = $_REQUEST['battleinput'];
		$stealElementIds    = Vars::getElements(Vars::CLASS_RESOURCE, Vars::FLAG_STEAL);
		$debrisElementIds   = Vars::getElements(Vars::CLASS_RESOURCE, Vars::FLAG_DEBRIS);
		$debrisShipIds      = Vars::getElements(Vars::CLASS_FLEET, Vars::FLAG_COLLECT);

        $fleetElements      = Vars::getElements(Vars::CLASS_FLEET);

        $combatElements     = array_merge(
            array_keys($fleetElements),
            array_keys(Vars::getElements(Vars::CLASS_DEFENSE))
        );

		foreach($BattleArray as $BattleSlotID => $BattleSlot)
		{
			if(isset($BattleSlot[0]) && (array_sum($BattleSlot[0]) > 0 || $BattleSlotID == 0))
			{
				$attacker	= array();
				$attacker['fleetDetail'] 		= array(
					'fleet_start_galaxy' => 1,
					'fleet_start_system' => 33,
					'fleet_start_planet' => 7, 
					'fleet_start_type' => 1, 
					'fleet_end_galaxy' => 1, 
					'fleet_end_system' => 33, 
					'fleet_end_planet' => 7, 
					'fleet_end_type' => 1, 
					'fleet_resource_metal' => 0,
					'fleet_resource_crystal' => 0,
					'fleet_resource_deuterium' => 0
				);
				
				$attacker['player']				= array(
					'id' => (1000 + $BattleSlotID + 1),
					'username'	=> $LNG['bs_atter'].' Nr.'.($BattleSlotID + 1),
					'military_tech' => $BattleSlot[0][109],
					'defence_tech' => $BattleSlot[0][110],
					'shield_tech' => $BattleSlot[0][111],
					'dm_defensive' => 0,
					'dm_attack' => 0
				); 
				
				$attacker['player']['factor']	= PlayerUtil::getFactors($attacker['player']);
				
				foreach($BattleSlot[0] as $ID => $Count)
				{
					if(!in_array($ID, $fleetElements) || $BattleSlot[0][$ID] <= 0)
					{
						unset($BattleSlot[0][$ID]);
					}
				}
				
				$attacker['unit'] 	= $BattleSlot[0];
				
				$attackers[]	= $attacker;
			}
				
			if(isset($BattleSlot[1]) && (array_sum($BattleSlot[1]) > 0 || $BattleSlotID == 0))
			{
				$defender	= array();
				$defender['fleetDetail'] 		= array(
					'fleet_start_galaxy' => 1,
					'fleet_start_system' => 33,
					'fleet_start_planet' => 7, 
					'fleet_start_type' => 1, 
					'fleet_end_galaxy' => 1, 
					'fleet_end_system' => 33, 
					'fleet_end_planet' => 7, 
					'fleet_end_type' => 1, 
					'fleet_resource_metal' => 0,
					'fleet_resource_crystal' => 0,
					'fleet_resource_deuterium' => 0
				);
				
				$defender['player']				= array(
					'id' => (2000 + $BattleSlotID + 1),
					'username'	=> $LNG['bs_deffer'].' Nr.'.($BattleSlotID + 1),
					'military_tech' => $BattleSlot[1][109],
					'defence_tech' => $BattleSlot[1][110],
					'shield_tech' => $BattleSlot[1][111],
					'dm_attack' => 0,
					'dm_defensive' => 0,
				); 
				
				$defender['player']['factor']	= PlayerUtil::getFactors($defender['player']);
				
				foreach(array_keys($BattleSlot[1]) as $elementId)
				{
					if(!in_array($elementId, $combatElements) || $BattleSlot[1][$elementId] <= 0)
					{
						unset($BattleSlot[1][$elementId]);
					}
				}
				
				$defender['unit'] 	= $BattleSlot[1];
				$defenders[]	    = $defender;
			}
		}
		
		$LNG->includeData(array('FLEET'));
		
		require_once 'includes/classes/missions/functions/calculateAttack.php';
		require_once 'includes/classes/missions/functions/calculateSteal.php';
		require_once 'includes/classes/missions/functions/GenerateReport.php';
		
		$combatResult	= calculateAttack($attackers, $defenders, Config::get()->Fleet_Cdr, Config::get()->Defs_Cdr);
		
		if($combatResult['won'] == "a")
		{
            $stealData  = array();
            foreach(array_keys($stealElementIds) as $elementId)
            {
                $stealData[$elementId]  = $BattleArray[0][1][$elementId];
            }

			$stealResource  = calculateSteal($attackers, $stealData, true);
		}
		else
		{
            $stealResource  = ArrayUtil::combineArrayWithSingleElement(array_keys($stealElementIds), 0);
		}
		
		$debris	= array();
		
		foreach(array_keys($debrisElementIds) as $elementId)
		{
			$debris[$elementId] = $combatResult['debris']['attacker'][$elementId] + $combatResult['debris']['defender'][$elementId];
		}
		
		$debrisTotal		= array_sum($debris);
		
		$moonFactor			= Config::get()->moon_factor;
		$maxMoonChance		= Config::get()->moon_chance;
		
		$chanceCreateMoon	= round($debrisTotal / 100000 * $moonFactor);
		$chanceCreateMoon	= min($chanceCreateMoon, $maxMoonChance);
		
		$sumSteal	        = array_sum($stealResource);


        $shipData           = array();
        foreach($debrisShipIds as $elementId => $elementObj)
        {
            $shipData[] = pretty_number(ceil($debrisTotal / $elementObj->capacity)).' '.$LNG['tech'][$elementId];
        }

		$stealResourceInformation	= sprintf($LNG['bs_derbis_raport'], Language::createHumanReadableList($shipData), $LNG['d_or']);

        $stealResourceInformation	.= '<br>';
		
		$stealResourceInformation	.= sprintf($LNG['bs_steal_raport'], Language::createHumanReadableList(array(
			pretty_number(ceil($sumSteal / Vars::getElement(202)->capacity)), $LNG['tech'][202],
			pretty_number(ceil($sumSteal / Vars::getElement(203)->capacity)), $LNG['tech'][203],
			pretty_number(ceil($sumSteal / Vars::getElement(217)->capacity)), $LNG['tech'][217]
        )), $LNG['d_or']);

		$reportInfo	= array(
			'thisFleet'				=> array(
				'fleet_start_galaxy'	=> 1,
				'fleet_start_system'	=> 33,
				'fleet_start_planet'	=> 7,
				'fleet_start_type'		=> 1,
				'fleet_end_galaxy'		=> 1,
				'fleet_end_system'		=> 33,
				'fleet_end_planet'		=> 7,
				'fleet_end_type'		=> 1,
				'fleet_start_time'		=> TIMESTAMP,
			),
			'debris'				=> $debris,
			'stealResource'			=> $stealResource,
			'moonChance'			=> $chanceCreateMoon,
			'moonDestroy'			=> false,
			'moonName'				=> NULL,
			'moonDestroyChance'		=> NULL,
			'moonDestroySuccess'	=> NULL,
			'fleetDestroyChance'	=> NULL,
			'fleetDestroySuccess'	=> NULL,
			'additionalInfo'		=> $stealResourceInformation,
		);
		
		$reportData	= GenerateReport($combatResult, $reportInfo);
		$reportID	= md5(uniqid('', true).TIMESTAMP);

        $db = Database::get();

        $sql = "INSERT INTO %%RW%% SET rid = :reportID, raport = :reportData, time = :time;";
        $db->insert($sql,array(
            ':reportID'     => $reportID,
            ':reportData'   => serialize($reportData),
            ':time'         => TIMESTAMP
        ));

        $this->sendJSON($reportID);
	}
	
	function show()
	{
		global $USER, $PLANET;

		$Slots			= HTTP::_GP('slots', 1);


        $fleetElements    = Vars::getElements(Vars::CLASS_FLEET);
        $defendElements    = Vars::getElements(Vars::CLASS_FLEET);

		$BattleArray[0][0][109]	= $USER[Vars::getElement(109)->name];
		$BattleArray[0][0][110]	= $USER[Vars::getElement(110)->name];
		$BattleArray[0][0][111]	= $USER[Vars::getElement(111)->name];
		
		if(empty($_REQUEST['battleinput']))
		{
			foreach($fleetElements as $elementId => $elementObj)
			{
				if(FleetFunctions::GetFleetMaxSpeed($elementObj, $USER) > 0)
				{
					// Add just flyable elements
					$BattleArray[0][0][$elementId]	= $PLANET[$elementObj->name];
				}
			}
		}
		else
		{
			$BattleArray	= HTTP::_GP('battleinput', array());
		}
		
		if(isset($_REQUEST['im']))
		{
			foreach($_REQUEST['im'] as $key => $value)
			{
				$BattleArray[0][1][$key]	= floattostring($value);
			}
		}
		
		$this->tplObj->loadscript('battlesim.js');
		
		$this->assign(array(
			'Slots'			=> $Slots,
			'battleinput'	=> $BattleArray,
			'fleetList'		=> array_keys($fleetElements),
			'defensiveList'	=> array_keys($defendElements),
		));
		
		$this->display('page.battleSimulator.default.tpl');   
	}
}
