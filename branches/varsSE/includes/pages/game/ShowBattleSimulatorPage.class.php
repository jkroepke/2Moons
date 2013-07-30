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

class ShowBattleSimulatorPage extends AbstractPage 
{
	public static $requireModule = MODULE_SIMULATOR;

	function __construct() 
	{
		parent::__construct();
	}

	function send()
	{
		global $reslist, $pricelist, $LNG;
		
		if(!isset($_REQUEST['battleinput'])) {
			$this->sendJSON(0);
		}
		
		$BattleArray	= $_REQUEST['battleinput'];
		$elements	= array(0, 0);
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
				
				$attacker['player']['factor']	= getFactors($attacker['player']);
				
				foreach($BattleSlot[0] as $ID => $Count)
				{
					if(!in_array($ID, $reslist['fleet']) || $BattleSlot[0][$ID] <= 0)
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
				
				$defender['player']['factor']	= getFactors($defender['player']);
				
				foreach($BattleSlot[1] as $ID => $Count)
				{
					if((!in_array($ID, $reslist['fleet']) && !in_array($ID, $reslist['defense'])) || $BattleSlot[1][$ID] <= 0)
					{
						unset($BattleSlot[1][$ID]);
					}
				}
				
				$defender['unit'] 	= $BattleSlot[1];
				$defenders[]	= $defender;
			}
		}
		
		$LNG->includeData(array('FLEET'));
		
		require_once 'includes/classes/missions/functions/calculateAttack.php';
		require_once 'includes/classes/missions/functions/calculateSteal.php';
		require_once 'includes/classes/missions/functions/GenerateReport.php';
		
		$combatResult	= calculateAttack($attackers, $defenders, Config::get()->Fleet_Cdr, Config::get()->Defs_Cdr);
		
		if($combatResult['won'] == "a")
		{
			$stealResource = calculateSteal($attackers, array(
				'metal' => $BattleArray[0][1][1],
				'crystal' => $BattleArray[0][1][2],
				'deuterium' => $BattleArray[0][1][3]
			), true);
		}
		else
		{
			$stealResource = array(
				901 => 0,
				902 => 0,
				903 => 0
			);
		}
		
		$debris	= array();
		
		foreach(array(901, 902) as $elementID)
		{
			$debris[$elementID]			= $combatResult['debris']['attacker'][$elementID] + $combatResult['debris']['defender'][$elementID];
		}
		
		$debrisTotal		= array_sum($debris);
		
		$moonFactor			= Config::get()->moon_factor;
		$maxMoonChance		= Config::get()->moon_chance;
		
		$chanceCreateMoon	= round($debrisTotal / 100000 * $moonFactor);
		$chanceCreateMoon	= min($chanceCreateMoon, $maxMoonChance);
		
		$sumSteal	= array_sum($stealResource);
		
		$stealResourceInformation	= sprintf($LNG['bs_derbis_raport'], 
			pretty_number(ceil($debrisTotal / $pricelist[219]['capacity'])), $LNG['tech'][219],
			pretty_number(ceil($debrisTotal / $pricelist[209]['capacity'])), $LNG['tech'][209]
		);
		
		$stealResourceInformation	.= '<br>';
		
		$stealResourceInformation	.= sprintf($LNG['bs_steal_raport'], 
			pretty_number(ceil($sumSteal / $pricelist[202]['capacity'])), $LNG['tech'][202], 
			pretty_number(ceil($sumSteal / $pricelist[203]['capacity'])), $LNG['tech'][203], 
			pretty_number(ceil($sumSteal / $pricelist[217]['capacity'])), $LNG['tech'][217]
		);

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
		global $USER, $PLANET, $reslist, $resource;

		$Slots			= HTTP::_GP('slots', 1);


		$BattleArray[0][0][109]	= $USER[$resource[109]];
		$BattleArray[0][0][110]	= $USER[$resource[110]];
		$BattleArray[0][0][111]	= $USER[$resource[111]];
		
		if(empty($_REQUEST['battleinput']))
		{
			foreach($reslist['fleet'] as $ID)
			{
				if(FleetFunctions::GetFleetMaxSpeed($ID, $USER) > 0)
				{
					// Add just flyable elements
					$BattleArray[0][0][$ID]	= $PLANET[$resource[$ID]];
				}
			}
		}
		else
		{
			$BattleArray	= HTTP::_GP('battleinput', array());
		}
		
		if(isset($_REQUEST['im']))
		{
			foreach($_REQUEST['im'] as $ID => $Count)
			{
				$BattleArray[0][1][$ID]	= floattostring($Count);
			}
		}
		
		$this->tplObj->loadscript('battlesim.js');
		
		$this->assign(array(
			'Slots'			=> $Slots,
			'battleinput'	=> $BattleArray,
			'fleetList'		=> $reslist['fleet'],
			'defensiveList'	=> $reslist['defense'],
		));
		
		$this->display('page.battleSimulator.default.tpl');   
	}
}
