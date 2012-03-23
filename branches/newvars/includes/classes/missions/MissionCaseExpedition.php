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
					$NewFleetArray  	.= $ID.",".floattostring($Count + $Found[$ID]).";";
					
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

				$AttackerTechno	= $GLOBALS['DATABASE']->uniquequery('SELECT id,username,military_tech,defence_tech,shield_tech,rpg_amiral,dm_defensive,dm_attack FROM '.USERS.' WHERE id='.$this->_fleet['fleet_owner'].";");
				$DefenderTechno	= array('id' => 0, 'username' => $Name, 'military_tech' => (min($AttackerTechno['military_tech'] + $Def,0)), 'defence_tech' => (min($AttackerTechno['defence_tech'] + $Def,0)), 'shield_tech' => (min($AttackerTechno['shield_tech'] + $Def,0)), 'rpg_amiral' => 0, 'dm_defensive' => 0, 'dm_attack' => 0);
				
				$attackFleets[$this->_fleet['fleet_id']]['fleet'] = $this->_fleet;
				$attackFleets[$this->_fleet['fleet_id']]['user'] = $AttackerTechno;
				$attackFleets[$this->_fleet['fleet_id']]['user']['factor'] = getFactors($attackFleets[$this->_fleet['fleet_id']]['user'], 'attack', $this->_fleet['fleet_start_time']);
				$attackFleets[$this->_fleet['fleet_id']]['detail'] = array();
				$temp = explode(';', $this->_fleet['fleet_array']);
				foreach ($temp as $temp2)
				{
					$temp2 = explode(',', $temp2);
					if ($temp2[0] < 100) continue;
					if (!isset($attackFleets[$this->_fleet['fleet_id']]['detail'][$temp2[0]]))
						$attackFleets[$this->_fleet['fleet_id']]['detail'][$temp2[0]] = 0;

					$attackFleets[$this->_fleet['fleet_id']]['detail'][$temp2[0]] += $temp2[1];
				}
				$defense = array();

				$defRowDef = explode(';', $DefenderFleetArray);
				foreach ($defRowDef as $Element)
				{
					$Element = explode(',', $Element);

					if ($Element[0] < 100) continue;

					if (!isset($defense[0]['def'][$Element[0]]))
					    $defense[0]['def'][$Element[0]] = 0;

					$defense[0]['def'][$Element[0]] += $Element[1];
				}
				$defense[0]['user'] = $DefenderTechno;
				$defense[0]['user']['factor']	= 0;

				require_once('calculateAttack.php');

				$result 	= calculateAttack($attackFleets, $defense, $GLOBALS['CONFIG'][$this->_fleet['fleet_universe']]['Fleet_Cdr'], $GLOBALS['CONFIG'][$this->_fleet['fleet_universe']]['Defs_Cdr']);

				foreach ($attackFleets as $attacker)
				{
					$fleetArray = '';
					$totalCount = 0;
					foreach ($attacker['detail'] as $element => $amount)
					{
						if ($amount)
							$fleetArray .= $element.','.$amount.';';

						$totalCount += $amount;
					}

					if ($totalCount <= 0)
						$this->KillFleet();
					else
					{
						$this->UpdateFleet('fleet_array', substr($fleetArray, 0, -1));
						$this->UpdateFleet('fleet_amount', $totalCount);
					}
				}

				require_once('GenerateReport.php');
				

				$INFO						= $this->_fleet;
				$INFO['steal']				= array('metal' => 0, 'crystal' => 0, 'deuterium' => 0);
				$INFO['moon']['des']		= 0;
				$INFO['moon']['chance'] 	= 0;
				$INFO['moon']['name']		= false;
				$INFO['moon']['desfail']	= false;
				$INFO['moon']['chance2']	= false;
				$INFO['moon']['fleetfail']	= false;
				
				$raport		= GenerateReport($result, $INFO);

                $SQL = "INSERT INTO ".RW." SET ";
				$SQL .= "`raport` = '".serialize($raport)."', ";
				$SQL .= "`time` = '".$this->_fleet['fleet_start_time']."';";
				$GLOBALS['DATABASE']->query($SQL);
				
				$rid	= $GLOBALS['DATABASE']->GetInsertID();
                
				$ColorAtt = "white";
				$ColorDef = "white";

				switch($result['won'])
				{
					case "r":
						$ColorAtt = "red";
						$ColorDef = "green";
					    break;
					case "w":
						$ColorAtt = "orange";
						$ColorDef = "orange";
                        break;
					case "a":
						$ColorAtt = "green";
						$ColorDef = "red";
					    break;
				}

				$MessageAtt = sprintf('<a href="CombatReport.php?raport=%s" target="_blank"><center><font color="%s">%s %s</font></a><br><br><font color="%s">%s: %s</font> <font color="%s">%s: %s</font><br>%s %s:<font color="#adaead">%s</font> %s:<font color="#ef51ef">%s</font> %s:<font color="#f77542">%s</font><br>%s %s:<font color="#adaead">%s</font> %s:<font color="#ef51ef">%s</font><br></center>', $rid, $ColorAtt, $LNG['sys_mess_attack_report'], sprintf($LNG['sys_adress_planet'], $this->_fleet['fleet_end_galaxy'], $this->_fleet['fleet_end_system'], $this->_fleet['fleet_end_planet']), $ColorAtt, $LNG['sys_perte_attaquant'], pretty_number($result['lost']['att']), $ColorDef, $LNG['sys_perte_defenseur'], pretty_number($result['lost']['def']), $LNG['sys_gain'], $LNG['tech'][901], 0, $LNG['tech'][902], 0, $LNG['tech'][903], 0, $LNG['sys_debris'], $LNG['tech'][901], 0, $LNG['tech'][902], 0);
			
				SendSimpleMessage($this->_fleet['fleet_owner'], 0, $this->_fleet['fleet_start_time'], 3, $LNG['sys_mess_tower'], $LNG['sys_mess_attack_report'], $MessageAtt);
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
					$this->UpdateFleet('fleet_end_time', ($this->_fleet['fleet_end_time'] - $this->_fleet['fleet_end_stay']) + ($this->_fleet['fleet_end_stay'] - $this->_fleet['fleet_start_time']) * $Wrapper[mt_rand(0, 9)]);
					$Message = $LNG['sys_expe_time_slow_'.mt_rand(1,6)];
				} else {
					$this->UpdateFleet('fleet_end_time', max(1, ($this->_fleet['fleet_end_time'] - $this->_fleet['fleet_end_stay']) - ($this->_fleet['fleet_end_stay'] - $this->_fleet['fleet_start_time']) / 3 * $Wrapper[mt_rand(0, 9)]));
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