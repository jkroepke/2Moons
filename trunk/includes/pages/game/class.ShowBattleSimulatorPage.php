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

class ShowBattleSimulatorPage extends AbstractPage 
{
	public static $requireModule = MODULE_SIMULATOR;

	function __construct() 
	{
		parent::__construct();
	}

	function send()
	{
		global $USER, $PLANET, $reslist, $pricelist, $LNG, $LANG, $CONF;
		
		if(!isset($_REQUEST['battleinput'])) {
			$this->sendJSON(0);
		}
		
		$BattleArray	= $_REQUEST['battleinput'];
		$elements	= array(0, 0);
		foreach($BattleArray as $BattleSlotID => $BattleSlot)
		{
			if(isset($BattleSlot[0]) && (array_sum($BattleSlot[0]) > 0 || $BattleSlotID == 0))
			{
				$Att	= mt_rand(1, 1000);
				$attack[$Att]['fleet'] 		= array('fleet_start_galaxy' => 1, 'fleet_start_system' => 33, 'fleet_start_planet' => 7, 'fleet_start_type' => 1, 'fleet_end_galaxy' => 1, 'fleet_end_system' => 33, 'fleet_end_planet' => 7, 'fleet_end_type' => 1, 'fleet_resource_metal' => 0, 'fleet_resource_crystal' => 0, 'fleet_resource_deuterium' => 0);
				$attack[$Att]['user'] 		= array('id' => (1000+$BattleSlotID+1), 'username'	=> $LNG['bs_atter'].' Nr.'.($BattleSlotID+1), 'military_tech' => $BattleSlot[0][109], 'defence_tech' => $BattleSlot[0][110], 'shield_tech' => $BattleSlot[0][111], 0, 'dm_defensive' => 0, 'dm_attack' => 0);
				$attack[$Att]['user']['factor']	= getFactors($attack[$Att]['user'], 'attack');
				
				foreach($BattleSlot[0] as $ID => $Count)
				{
					if(!in_array($ID, $reslist['fleet']) || $BattleSlot[0][$ID] <= 0)
						unset($BattleSlot[0][$ID]);
				}
				
				if($elements[0] == 0 && $BattleSlotID != 0)
					exit('ERROR');
					
				$elements[0]				= $elements[0] + array_sum($BattleSlot[1]);
				$attack[$Att]['detail'] 	= $BattleSlot[0];
			}
				
			if(isset($BattleSlot[1]) && (array_sum($BattleSlot[1]) > 0 || $BattleSlotID == 0))
			{
				$Def	= mt_rand(1 ,1000);
				
				$defense[$Def]['fleet'] 			= array('fleet_start_galaxy' => 1, 'fleet_start_system' => 33, 'fleet_start_planet' => 7, 'fleet_start_type' => 1, 'fleet_end_galaxy' => 1, 'fleet_end_system' => 33, 'fleet_end_planet' => 7, 'fleet_end_type' => 1, 'fleet_resource_metal' => 0, 'fleet_resource_crystal' => 0, 'fleet_resource_deuterium' => 0);
				$defense[$Def]['user'] 				= array('id' => (2000+$BattleSlotID+1), 'username'	=> $LNG['bs_deffer'].' Nr.'.($BattleSlotID+1), 'military_tech' => $BattleSlot[1][109], 'defence_tech' => $BattleSlot[1][110], 'shield_tech' => $BattleSlot[1][111], 0, 'dm_defensive' => 0, 'dm_attack' => 0);
				$defense[$Def]['user']['factor']	= getFactors($defense[$Def]['user'], 'attack');
			
				foreach($BattleSlot[1] as $ID => $Count)
				{
					if(!in_array($ID, $reslist['fleet']) && !in_array($ID, $reslist['defense']))
						unset($BattleSlot[1][$ID]);
				}

				if($elements[1] == 0 && $BattleSlotID != 0)
					exit('ERROR');

				$elements[1]					= $elements[1] + array_sum($BattleSlot[1]);
				
				$defense[$Def]['def']	 	= $BattleSlot[1];
			}
		}
		
		$LANG->includeLang(array('FLEET'));
		require_once(ROOT_PATH.'includes/classes/missions/calculateAttack.php');
		require_once(ROOT_PATH.'includes/classes/missions/calculateSteal.php');
		require_once(ROOT_PATH.'includes/classes/missions/GenerateReport.php');
		$start 				= microtime(true);
		$result 			= calculateAttack($attack, $defense, $CONF['Fleet_Cdr'], $CONF['Defs_Cdr']);
		$totaltime 			= microtime(true) - $start;
		
		$steal = $result['won'] == "a" ? calculateSteal($attack, array('metal' => $BattleArray[0][1][1], 'crystal' => $BattleArray[0][1][2], 'deuterium' => $BattleArray[0][1][3]), true) : array('metal' => 0, 'crystal' => 0, 'deuterium' => 0);
		
		$FleetDebris      	= $result['debree']['att'][0] + $result['debree']['def'][0] + $result['debree']['att'][1] + $result['debree']['def'][1];
		$MoonChance       	= min(round($FleetDebris / 100000 * $CONF['moon_factor'], 0), $CONF['moon_chance']);
		
		$AllSteal			= array_sum($steal);
		
		$RaportInfo			= sprintf($LNG['bs_derbis_raport'], 
		pretty_number(ceil($FleetDebris / $pricelist[219]['capacity'])), $LNG['tech'][219],
		pretty_number(ceil($FleetDebris / $pricelist[209]['capacity'])), $LNG['tech'][209])."<br>";
		$RaportInfo			.= sprintf($LNG['bs_steal_raport'], 
		pretty_number(ceil($AllSteal / $pricelist[202]['capacity'])), $LNG['tech'][202], 
		pretty_number(ceil($AllSteal / $pricelist[203]['capacity'])), $LNG['tech'][203], 
		pretty_number(ceil($AllSteal / $pricelist[217]['capacity'])), $LNG['tech'][217])."<br>";
		$INFO						= array();
		$INFO['battlesim']			= $RaportInfo;
		$INFO['steal']				= $steal;
		$INFO['fleet_start_galaxy']	= 1;
		$INFO['fleet_start_system']	= 33;
		$INFO['fleet_start_planet']	= 7;
		$INFO['fleet_start_type']	= 1;
		$INFO['fleet_end_galaxy']	= 1;
		$INFO['fleet_end_system']	= 33;
		$INFO['fleet_end_planet']	= 7;
		$INFO['fleet_end_type']		= 1;
		$INFO['fleet_start_time']	= TIMESTAMP;
		$INFO['moon']['des']		= 0;
		$INFO['moon']['chance'] 	= $MoonChance;
		$INFO['moon']['name']		= false;
		$INFO['moon']['desfail']	= false;
		$INFO['moon']['chance2']	= false;
		$INFO['moon']['fleetfail']	= false;
		$raport 			= GenerateReport($result, $INFO);
			
		$SQL = "INSERT INTO ".RW." SET ";
		$SQL .= "`raport` = '".serialize($raport)."', ";
		$SQL .= "`time` = '".TIMESTAMP."';";
		$GLOBALS['DATABASE']->query($SQL);
		$rid	= $GLOBALS['DATABASE']->GetInsertID();
		
		$this->sendJSON($rid);
	}
	
	function show()
	{
		global $USER, $PLANET, $reslist, $pricelist, $resource, $LNG, $LANG, $CONF;
	
		$action			= HTTP::_GP('action', '');
		$Slots			= HTTP::_GP('slots', 1);
		
		$BattleArray	= array();
		$BattleArray[0][0][109]	= $USER[$resource[109]];
		$BattleArray[0][0][110]	= $USER[$resource[110]];
		$BattleArray[0][0][111]	= $USER[$resource[111]];

		foreach($reslist['fleet'] as $ID)
		{
			$BattleArray[0][0][$ID]	= $PLANET[$resource[$ID]];
		}
		
		if(isset($_REQUEST['im']))
		{
			foreach($_REQUEST['im'] as $ID => $Count)
			{
				$BattleArray[0][1][$ID]	= floattostring($Count);
			}
		}
		
		$this->tplObj->loadscript('battlesim.js');
		
		$this->tplObj->assign_vars(array(
			'Slots'			=> $Slots,
			'battleinput'	=> $BattleArray,
			'reslist'		=> $reslist,
		));
				
		$this->display('page.battleSimulator.default.tpl');   
	}
}

?>