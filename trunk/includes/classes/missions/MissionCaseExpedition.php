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

class MissionCaseExpedition extends MissionFunctions
{
	function __construct($fleet)
	{
		$this->_fleet	= $fleet;
	}
	
	function TargetEvent()
	{
		$this->setState(FLEET_HOLD);
		$this->SaveFleet();
	}
	
	function EndStayEvent()
	{
		global $pricelist, $reslist, $LANG;
		$LNG			= $LANG->GetUserLang($this->_fleet['fleet_owner']);

        $expeditionPoints       = array();

		foreach($reslist['fleet'] as $ID)
		{
			$expeditionPoints[$ID]	= ($pricelist[$ID]['cost'][901] + $pricelist[$ID]['cost'][902]) / 1000;
		}
		
		$expeditionPoints[202] = 12;
		$expeditionPoints[203] = 47;
		$expeditionPoints[204] = 12;
		$expeditionPoints[205] = 110;
		$expeditionPoints[206] = 47;
		$expeditionPoints[207] = 160;
			
		$fleetRaw 			= explode(";", $this->_fleet['fleet_array']);
		$fleetPoints 		= 0;
		$fleetCapacity		= 0;
		$fleetArray         = array();

		foreach ($fleetRaw as $Group)
		{
			if (empty($Group)) continue;

			$Class 						= explode (",", $Group);
			$fleetArray[$Class[0]]		= $Class[1];
			$fleetCapacity 			   += $Class[1] * $pricelist[$Class[0]]['capacity'];
			$fleetPoints   			   += $Class[1] * $expeditionPoints[$Class[0]];
		}

		$fleetCapacity  -= $this->_fleet['fleet_resource_metal'] + $this->_fleet['fleet_resource_crystal'] + $this->_fleet['fleet_resource_deuterium'] + $this->_fleet['fleet_resource_darkmatter'];

		$GetEvent       = mt_rand(1, 9);

        $Message        = $LNG['sys_expe_nothing_'.mt_rand(1,8)];

		switch($GetEvent)
		{
			case 1:
				$WitchFound	= mt_rand(1,3);
				$FindSize   = mt_rand(0, 100);
                $Factor     = 0;

				if(10 < $FindSize) {
					$Factor 	= (mt_rand(10, 50) / $WitchFound) * $GLOBALS['CONFIG'][$this->_fleet['fleet_universe']]['resource_multiplier'];
					$Message	= $LNG['sys_expe_found_ress_1_'.mt_rand(1,4)];
				} elseif(0 < $FindSize && 10 >= $FindSize) {
					$Factor 	= (mt_rand(52, 100) / $WitchFound) * $GLOBALS['CONFIG'][$this->_fleet['fleet_universe']]['resource_multiplier'];
					$Message	= $LNG['sys_expe_found_ress_2_'.mt_rand(1,3)];
				} elseif(0 == $FindSize) {
					$Factor 	= (mt_rand(102, 200) / $WitchFound) * $GLOBALS['CONFIG'][$this->_fleet['fleet_universe']]['resource_multiplier'];
					$Message	= $LNG['sys_expe_found_ress_3_'.mt_rand(1,2)];
				}

				$StatFactor = $GLOBALS['DATABASE']->uniquequery("SELECT MAX(total_points) as total FROM `".STATPOINTS."` WHERE `stat_type` = 1 AND `universe` = '".$this->_fleet['fleet_universe']."';");

				$MaxPoints	= ($StatFactor['total'] < 5000000) ? 9000 : 12000;
				$Size		= min($Factor * MAX(MIN($fleetPoints / 1000, $MaxPoints), 200), $fleetCapacity);

				switch($WitchFound)
				{
					case 1:
						$this->UpdateFleet('fleet_resource_metal', $this->_fleet['fleet_resource_metal'] + $Size);
					break;
					case 2:
						$this->UpdateFleet('fleet_resource_crystal', $this->_fleet['fleet_resource_crystal'] + $Size);
					break;
					case 3:
						$this->UpdateFleet('fleet_resource_deuterium', $this->_fleet['fleet_resource_deuterium'] + $Size);
					break;
				}

			break;
			case 2:
				$FindSize   = mt_rand(0, 100);
                $Size       = 0;

				if(10 < $FindSize) {
					$Size		= mt_rand(100, 300);
					$Message	= $LNG['sys_expe_found_dm_1_'.mt_rand(1,5)];
				} elseif(0 < $FindSize && 10 >= $FindSize) {
					$Size		= mt_rand(301, 600);
					$Message	= $LNG['sys_expe_found_dm_2_'.mt_rand(1,4)];
				} elseif(0 == $FindSize) {
					$Size	 	= mt_rand(601, 3000);
					$Message	= $LNG['sys_expe_found_dm_3_'.mt_rand(1,2)];
				}

				$this->UpdateFleet('fleet_resource_darkmatter', $this->_fleet['fleet_resource_darkmatter'] + $Size);
			break;
			case 3:
			default:
				$FindSize   = mt_rand(0, 100);
                $Size       = 0;
                $Message    = "";

				if(10 < $FindSize) {
					$Size		= mt_rand(10, 50);
					$Message	= $LNG['sys_expe_found_ships_1_'.mt_rand(1,4)];
				} elseif(0 < $FindSize && 10 >= $FindSize) {
					$Size		= mt_rand(52, 100);
					$Message	= $LNG['sys_expe_found_ships_2_'.mt_rand(1,2)];
				} elseif(0 == $FindSize) {
					$Size	 	= mt_rand(102, 200);
					$Message	= $LNG['sys_expe_found_ships_3_'.mt_rand(1,2)];
				}

				$StatFactor 	= $GLOBALS['DATABASE']->countquery("SELECT MAX(total_points) FROM `".STATPOINTS."` WHERE `stat_type` = 1 AND `universe` = '".$this->_fleet['fleet_universe']."';");

				$MaxPoints 		= ($StatFactor < 5000000) ? 4500 : 6000;

				$FoundShips		= max(round($Size * min($fleetPoints, $MaxPoints)), 10000);
				
				$FoundShipMess	= "";	
				$NewFleetArray 	= "";

				$LNG			+= $LANG->GetUserLang($this->_fleet['fleet_owner'], array('TECH'));
				$Found			= array();
				foreach($reslist['fleet'] as $ID) 
				{
					if(!isset($fleetArray[$ID]) || $ID == 208 || $ID == 209 || $ID == 214)
						continue;
					
					$MaxFound			= floor($FoundShips / ($pricelist[$ID]['cost'][901] + $pricelist[$ID]['cost'][902]));
					if($MaxFound <= 0) 
						continue;
						
					$Count				= mt_rand(0, $MaxFound);
					if($Count <= 0) 
						continue;
						
					$Found[$ID]			= $Count;
					$FoundShips	 		-= $Count * ($pricelist[$ID]['cost'][901] + $pricelist[$ID]['cost'][902]);
					$FoundShipMess   	.= '<br>'.$LNG['tech'][$ID].': '.pretty_number($Count);
					if($FoundShips <= 0)
						break;
				}
				
				foreach($fleetArray as $ID => $Count)
				{
					if(!empty($Found[$ID]))
					{
						$Count	+= $Found[$ID];
					}
					
					$NewFleetArray  	.= $ID.",".floattostring($Count).';';
				}	
				
				$Message	.= $FoundShipMess;
							
				$this->UpdateFleet('fleet_array', $NewFleetArray);
				$this->UpdateFleet('fleet_amount', array_sum($fleetArray));
			break;
			case 4:
		    	$Chance	= mt_rand(1,2);
				if($Chance == 1) {
					$Points	= array(-3,-5,-8);
					$Which	= 1;
					$Def	= -3;
					$Name	= $LNG['sys_expe_attackname_1'];
					$Add	= 0;
					$Rand	= array(5,3,2);	
					$DefenderFleetArray	= "204,5;206,3;207,2;";								
				} else { 
					$Points	= array(-4,-6,-9);
					$Which	= 2;
					$Def	= 3;
					$Name	= $LNG['sys_expe_attackname_2'];
					$Add	= 0.1;
					$Rand	= array(4,3,2);
					$DefenderFleetArray	= "205,5;215,3;213,2;";
				}

				$LNG        += $LANG->GetUserLang($this->_fleet['fleet_owner'], array('L18N'));
			
				$messageHTML	= <<<HTML
				<div class="raportMessage">
				<table>
				<tr>
				<td colspan="2"><a href="CombatReport.php?raport=%s" target="_blank"><span class="%s">%s %s</span></a></td>
				</tr>
				<tr>
				<td>%s</td><td><span class="%s">%s: %s</span>&nbsp;<span class="%s">%s: %s</span></td>
				</tr>
				<tr>
				<td>%s</td><td><span>%s:&nbsp;<span class="raportSteal element901">%s</span>&nbsp;</span><span>%s:&nbsp;<span class="raportSteal element902">%s</span>&nbsp;</span><span>%s:&nbsp;<span class="raportSteal element903">%s</span></span></td>
				</tr>
				<tr>
				<td>%s</td><td><span>%s:&nbsp;<span class="raportDebris element901">%s</span>&nbsp;</span><span>%s:&nbsp;<span class="raportDebris element902">%s</span></span></td>
				</tr>
				</table>
				</div>
HTML;
				//Minize HTML
				$messageHTML	= str_replace(array("\n", "\t", "\r"), "", $messageHTML);
				
				
				$FindSize   = mt_rand(0, 100);
                $maxAttack  = 0;

				if(10 < $FindSize) {
					$Message    = $LNG['sys_expe_attack_'.$Which.'_1_'.$Rand[0]];
					$maxAttack	= 0.3 + $Add + (mt_rand($Points[0], abs($Points[0])) * 0.01);
				} elseif(0 < $FindSize && 10 >= $FindSize) {
					$Message    = $LNG['sys_expe_attack_'.$Which.'_2_'.$Rand[1]];
					$maxAttack	= 0.3 + $Add + (mt_rand($Points[1], abs($Points[1])) * 0.01);
				} elseif(0 == $FindSize) {
					$Message    = $LNG['sys_expe_attack_'.$Which.'_3_'.$Rand[2]];
					$maxAttack	= 0.3 + $Add + (mt_rand($Points[2], abs($Points[2])) * 0.01);
				}
					
				foreach($fleetArray as $ID => $count)
				{
					$DefenderFleetArray	.= $ID.",".round($count * $maxAttack).";";
				}

				$AttackerTechno	= $GLOBALS['DATABASE']->uniquequery("SELECT * FROM ".USERS." WHERE id = ".$this->_fleet['fleet_owner'].";");
				$DefenderTechno	= array(
					'id' => 0,
					'username' => $Name,
					'military_tech' => (min($AttackerTechno['military_tech'] + $Def,0)),
					'defence_tech' => (min($AttackerTechno['defence_tech'] + $Def,0)),
					'shield_tech' => (min($AttackerTechno['shield_tech'] + $Def,0)),
					'rpg_amiral' => 0,
					'dm_defensive' => 0,
					'dm_attack' => 0
				);
				
				$fleetID	= $this->_fleet['fleet_id'];
				
				$fleetAttack[$fleetID]['fleetDetail']		= $this->_fleet;
				$fleetAttack[$fleetID]['player']			= $AttackerTechno;
				$fleetAttack[$fleetID]['player']['factor']	= getFactors($fleetAttack[$this->_fleet['fleet_id']]['player'], 'attack', $this->_fleet['fleet_start_time']);
				$fleetAttack[$fleetID]['unit']				= array();
				
				$temp = explode(';', $this->_fleet['fleet_array']);
				foreach ($temp as $temp2)
				{
					$temp2 = explode(',', $temp2);
					
					if ($temp2[0] < 100)
					{
						continue;
					}
					
					if (!isset($fleetAttack[$fleetID]['unit'][$temp2[0]]))
					{
						$fleetAttack[$fleetID]['unit'][$temp2[0]] = 0;
					}
					
					$fleetAttack[$fleetID]['unit'][$temp2[0]] += $temp2[1];
				}
				
				$fleetDefend = array();

				$defRowDef = explode(';', $DefenderFleetArray);
				foreach ($defRowDef as $Element)
				{
					$Element = explode(',', $Element);

					if ($Element[0] < 100) continue;

					if (!isset($fleetDefend[0]['unit'][$Element[0]]))
					    $fleetDefend[0]['unit'][$Element[0]] = 0;

					$fleetDefend[0]['unit'][$Element[0]] += $Element[1];
				}
				
				$fleetDefend[0]['fleetDetail'] = array(
					'fleet_start_galaxy' => $this->_fleet['fleet_end_galaxy'],
					'fleet_start_system' => $this->_fleet['fleet_end_system'],
					'fleet_start_planet' => $this->_fleet['fleet_end_planet'], 
					'fleet_start_type' => 1, 
					'fleet_end_galaxy' => $this->_fleet['fleet_end_galaxy'], 
					'fleet_end_system' => $this->_fleet['fleet_end_system'], 
					'fleet_end_planet' => $this->_fleet['fleet_end_planet'], 
					'fleet_end_type' => 1, 
					'fleet_resource_metal' => 0,
					'fleet_resource_crystal' => 0,
					'fleet_resource_deuterium' => 0
				);
				$fleetDefend[0]['player'] = $DefenderTechno;
				$fleetDefend[0]['player']['factor']	= 0;

				require_once('calculateAttack.php');
			
				$fleetIntoDebris	= $GLOBALS['CONFIG'][$this->_fleet['fleet_universe']]['Fleet_Cdr'];
				$defIntoDebris		= $GLOBALS['CONFIG'][$this->_fleet['fleet_universe']]['Defs_Cdr'];
				
				$combatResult 		= calculateAttack($fleetAttack, $fleetDefend, $fleetIntoDebris, $defIntoDebris);

				$fleetArray = '';
				$totalCount = 0;
				
				$fleetAttack[$fleetID]['unit']	= array_filter($fleetAttack[$fleetID]['unit']);
				foreach ($fleetAttack[$fleetID]['unit'] as $element => $amount)
				{
					$fleetArray .= $element.','.$amount.';';
					$totalCount += $amount;
				}

				if ($totalCount <= 0)
				{
					$this->KillFleet();
				}
				else
				{
					$this->UpdateFleet('fleet_array', substr($fleetArray, 0, -1));
					$this->UpdateFleet('fleet_amount', $totalCount);
				}

				require_once('GenerateReport.php');
			
			
				$debrisRessource	= array(901, 902);
				foreach($debrisRessource as $elementID)
				{
					$debris[$elementID]			= 0;
				}
				
				$stealResource	= array(901 => 0, 902 => 0, 903 => 0);
			
				$raportInfo	= array(
					'thisFleet'				=> $this->_fleet,
					'debris'				=> $debris,
					'stealResource'			=> $stealResource,
					'moonChance'			=> 0,
					'moonDestroy'			=> false,
					'moonName'				=> null,
					'moonDestroyChance'		=> null,
					'moonDestroySuccess'	=> null,
					'fleetDestroyChance'	=> null,
					'fleetDestroySuccess'	=> null,
				);
				
				$raportData	= GenerateReport($combatResult, $raportInfo);
			
				$sqlQuery = "INSERT INTO ".RW." SET raport = '".serialize($raportData)."', time = '".$this->_fleet['fleet_start_time']."';";
				$GLOBALS['DATABASE']->query($sqlQuery);
				$raportID	= $GLOBALS['DATABASE']->GetInsertID();
			
				switch($combatResult['won'])
				{
					case "a":
					$attackStatus	= 'wons';
					$defendStatus	= 'loos';
					$attackClass	= 'raportWin';
					$defendClass	= 'raportLose';
					break;
					case "w":
					$attackStatus	= 'draws';
					$defendStatus	= 'draws';
					$attackClass	= 'raportDraw';
					$defendClass	= 'raportDraw';
					break;
					case "r":
					$attackStatus	= 'loos';
					$defendStatus	= 'wons';
					$attackClass	= 'raportLose';
					$defendClass	= 'raportWin';
					break;
				}

				$message	= sprintf($messageHTML,
					$raportID,
					$attackClass,
					$LNG['sys_mess_attack_report'],
					sprintf(
						$LNG['sys_adress_planet'],
						$this->_fleet['fleet_end_galaxy'],
						$this->_fleet['fleet_end_system'],
						$this->_fleet['fleet_end_planet']
					),
					$LNG['sys_lost'],
					$attackClass,
					$LNG['sys_attack_attacker_pos'],
					pretty_number($combatResult['unitLost']['attacker']),
					$defendClass,
					$LNG['sys_attack_defender_pos'],
					pretty_number($combatResult['unitLost']['defender']),
					$LNG['sys_gain'],
					$LNG['tech'][901],
					pretty_number($stealResource[901]),
					$LNG['tech'][902],
					pretty_number($stealResource[902]),
					$LNG['tech'][903],
					pretty_number($stealResource[903]),
					$LNG['sys_debris'],
					$LNG['tech'][901],
					pretty_number($debris[901]), 
					$LNG['tech'][902],
					pretty_number($debris[902])
				);
				
				SendSimpleMessage($this->_fleet['fleet_owner'], 0, $this->_fleet['fleet_end_stay'], 3, $LNG['sys_mess_tower'], $LNG['sys_mess_attack_report'], $message);
			break;
			case 5:
				$this->KillFleet();
				$Message	= $LNG['sys_expe_lost_fleet_'.mt_rand(1,4)];
			break;
			case 6:
				# http://owiki.de/Expedition#Ver.C3.A4nderte_Flugzeit
				$MoreTime	= mt_rand(0, 100);
				$Wrapper	= array();
				$Wrapper[]	= 2;
				$Wrapper[]	= 2;
				$Wrapper[]	= 2;
				$Wrapper[]	= 2;
				$Wrapper[]	= 2;
				$Wrapper[]	= 2;
				$Wrapper[]	= 2;
				$Wrapper[]	= 3;
				$Wrapper[]	= 3;
				$Wrapper[]	= 5;
			
				if($MoreTime < 75) {
					$this->UpdateFleet('fleet_end_time', $this->_fleet['fleet_end_stay'] + (($this->_fleet['fleet_end_time'] - $this->_fleet['fleet_end_stay']) + ($this->_fleet['fleet_end_stay'] - $this->_fleet['fleet_start_time']) * $Wrapper[mt_rand(0, 9)]));
					$Message = $LNG['sys_expe_time_slow_'.mt_rand(1,6)];
				} else {
					$this->UpdateFleet('fleet_end_time', $this->_fleet['fleet_end_stay'] + max(1, ($this->_fleet['fleet_end_time'] - $this->_fleet['fleet_end_stay']) - ($this->_fleet['fleet_end_stay'] - $this->_fleet['fleet_start_time']) / 3 * $Wrapper[mt_rand(0, 9)]));
					$Message = $LNG['sys_expe_time_fast_'.mt_rand(1,3)];
				}
			break;
		}
			
		SendSimpleMessage($this->_fleet['fleet_owner'], 0, $this->_fleet['fleet_end_stay'], 15, $LNG['sys_mess_tower'], $LNG['sys_expe_report'], $Message);
		$this->setState(FLEET_RETURN);
		$this->SaveFleet();
	}
	
	function ReturnEvent()
	{
		global $LANG;
		$LNG			= $LANG->GetUserLang($this->_fleet['fleet_owner']);
		$Message 		= sprintf($LNG['sys_expe_back_home'], $LNG['tech'][901], pretty_number($this->_fleet['fleet_resource_metal']), $LNG['tech'][902], pretty_number($this->_fleet['fleet_resource_crystal']),  $LNG['tech'][903], pretty_number($this->_fleet['fleet_resource_deuterium']), $LNG['tech'][921], pretty_number($this->_fleet['fleet_resource_darkmatter']));
		SendSimpleMessage($this->_fleet['fleet_owner'], 0, $this->_fleet['fleet_end_time'], 15, $LNG['sys_mess_tower'], $LNG['sys_expe_report'], $Message);
		$this->RestoreFleet();
	}
}

?>