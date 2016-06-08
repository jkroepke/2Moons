<?php

/**
 *  2Moons 
 *   by Jan-Otto Kröpke 2009-2016
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan-Otto Kröpke <slaver7@gmail.com>
 * @copyright 2009 Lucky
 * @copyright 2016 Jan-Otto Kröpke <slaver7@gmail.com>
 * @licence MIT
 * @version 1.8.0
 * @link https://github.com/jkroepke/2Moons
 */

class MissionCaseExpedition extends MissionFunctions implements Mission
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
		global $pricelist, $reslist, $resource;
		$LNG	= $this->getLanguage(NULL, $this->_fleet['fleet_owner']);

		$config	= Config::get($this->_fleet['fleet_universe']);

        $expeditionPoints       = array();

		foreach($reslist['fleet'] as $shipId)
		{
			$expeditionPoints[$shipId]	= ($pricelist[$shipId]['cost'][901] + $pricelist[$shipId]['cost'][902]) * 5 / 1000;
		}
			
		$fleetArray		= FleetFunctions::unserialize($this->_fleet['fleet_array']);
		$fleetPoints 	= 0;
		$fleetCapacity	= 0;

		foreach ($fleetArray as $shipId => $shipAmount)
		{
			$fleetCapacity 			   += $shipAmount * $pricelist[$shipId]['capacity'];
			$fleetPoints   			   += $shipAmount * $expeditionPoints[$shipId];
		}

		$fleetCapacity  -= $this->_fleet['fleet_resource_metal'] + $this->_fleet['fleet_resource_crystal']
			+ $this->_fleet['fleet_resource_deuterium'] + $this->_fleet['fleet_resource_darkmatter'];

		$GetEvent       = mt_rand(1, 9);

        $Message        = $LNG['sys_expe_nothing_'.mt_rand(1,8)];

		switch($GetEvent)
		{
			case 1:
				$eventSize		= mt_rand(0, 100);
                $factor			= 0;

				if(10 < $eventSize)
				{
					$Message	= $LNG['sys_expe_found_ress_1_'.mt_rand(1,4)];
					$factor		= mt_rand(10, 50);
				}
				elseif(0 < $eventSize && 10 >= $eventSize)
				{
					$Message	= $LNG['sys_expe_found_ress_2_'.mt_rand(1,3)];
					$factor		= mt_rand(50, 100);
				}
				elseif(0 == $eventSize)
				{
					$Message	= $LNG['sys_expe_found_ress_3_'.mt_rand(1,2)];
					$factor		= mt_rand(100, 200);
				}

				$chanceToFound	= mt_rand(1, 6);
				if($chanceToFound > 3)
				{
					$resourceId	= 901;
				}
				elseif($chanceToFound > 1)
				{
					$resourceId	= 902;
					$factor		= $factor / 2;
				}
				else
				{
					$resourceId	= 903;
					$factor		= $factor / 3;
				}

				$sql		= "SELECT MAX(total_points) as total FROM %%STATPOINTS%%
				WHERE `stat_type` = :type AND `universe` = :universe;";

				$topPoints	= Database::get()->selectSingle($sql, array(
					':type'		=> 1,
					':universe'	=> $this->_fleet['fleet_universe']
				), 'total');

				if($topPoints > 5000000)
				{
					$maxFactor		= 12000;
				}
				elseif($topPoints > 1000000)
				{
					$maxFactor		= 9000;
				}
				elseif($topPoints > 100000)
				{
					$maxFactor		= 6000;
				}
				else
				{
					$maxFactor		= 2400;
				}

				$founded		= round(min($maxFactor, max(200, $factor)) * $fleetPoints);

				$fleetColName	= 'fleet_resource_'.$resource[$resourceId];
				$this->UpdateFleet($fleetColName, $this->_fleet[$fleetColName] + $founded);
			break;
			case 2:
				$eventSize   = mt_rand(0, 100);
                $Size       = 0;

				if(10 < $eventSize) {
					$Size		= mt_rand(100, 300);
					$Message	= $LNG['sys_expe_found_dm_1_'.mt_rand(1,5)];
				} elseif(0 < $eventSize && 10 >= $eventSize) {
					$Size		= mt_rand(301, 600);
					$Message	= $LNG['sys_expe_found_dm_2_'.mt_rand(1,3)];
				} elseif(0 == $eventSize) {
					$Size	 	= mt_rand(601, 3000);
					$Message	= $LNG['sys_expe_found_dm_3_'.mt_rand(1,2)];
				}

				$this->UpdateFleet('fleet_resource_darkmatter', $this->_fleet['fleet_resource_darkmatter'] + $Size);
			break;
			case 3:
				$eventSize	= mt_rand(0, 100);
                $Size       = 0;
                $Message    = "";

				if(10 < $eventSize) {
					$Size		= mt_rand(10, 50);
					$Message	= $LNG['sys_expe_found_ships_1_'.mt_rand(1,4)];
				} elseif(0 < $eventSize && 10 >= $eventSize) {
					$Size		= mt_rand(52, 100);
					$Message	= $LNG['sys_expe_found_ships_2_'.mt_rand(1,2)];
				} elseif(0 == $eventSize) {
					$Size	 	= mt_rand(102, 200);
					$Message	= $LNG['sys_expe_found_ships_3_'.mt_rand(1,2)];
				}

				$sql		= "SELECT MAX(total_points) as total FROM %%STATPOINTS%%
				WHERE `stat_type` = :type AND `universe` = :universe;";

				$topPoints	= Database::get()->selectSingle($sql, array(
					':type'		=> 1,
					':universe'	=> $this->_fleet['fleet_universe']
				), 'total');

				$MaxPoints 		= ($topPoints < 5000000) ? 4500 : 6000;

				$FoundShips		= max(round($Size * min($fleetPoints, $MaxPoints)), 10000);
				
				$FoundShipMess	= "";	
				$NewFleetArray 	= "";
				
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
				
				if (empty($Found)) {
					$FoundShipMess .= '<br><br>'.$LNG['sys_expe_found_ships_nothing'];
				}

				foreach($fleetArray as $ID => $Count)
				{
					if(!empty($Found[$ID]))
					{
						$Count	+= $Found[$ID];
					}
					
					$NewFleetArray  	.= $ID.",".floatToString($Count).';';
				}	
				
				$Message	.= $FoundShipMess;
							
				$this->UpdateFleet('fleet_array', $NewFleetArray);
				$this->UpdateFleet('fleet_amount', array_sum($fleetArray));
			break;
			case 4:
			
				$messageHTML	= <<<HTML
<div class="raportMessage">
<table>
<tr>
<td colspan="2"><a href="CombatReport.php?raport=%s" target="_blank"><span class="%s">%s %s (%s)</span></a></td>
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

				// pirate or alien
				$attackType	= mt_rand(1,2);
				$eventSize	= mt_rand(0, 100);

				$targetFleetData	= array();

				if($attackType == 1)
				{
					$techBonus		= -3;
					$targetName		= $LNG['sys_expe_attackname_1'];
					$roundFunction	= 'floor';

					if(10 < $eventSize)
					{
						$Message    			= $LNG['sys_expe_attack_1_1_5'];
						$attackFactor			= (30 + mt_rand(-3, 3)) / 100;
						$targetFleetData[204]	= 5;
					}
					elseif(0 < $eventSize && 10 >= $eventSize)
					{
						$Message    			= $LNG['sys_expe_attack_1_2_3'];
						$attackFactor			= (50 + mt_rand(-5, 5)) / 100;
						$targetFleetData[206]	= 3;
					}
					else
					{
						$Message   				= $LNG['sys_expe_attack_1_3_2'];
						$attackFactor			= (80 + mt_rand(-8, 8)) / 100;
						$targetFleetData[207]	= 2;
					}
				}
				else
				{
					$techBonus		= 3;
					$targetName		= $LNG['sys_expe_attackname_2'];
					$roundFunction	= 'ceil';

					if(10 < $eventSize)
					{
						$Message    			= $LNG['sys_expe_attack_1_1_5'];
						$attackFactor			= (40 + mt_rand(-4, 4)) / 100;
						$targetFleetData[204]	= 5;
					}
					elseif(0 < $eventSize && 10 >= $eventSize)
					{
						$Message    			= $LNG['sys_expe_attack_1_3_3'];
						$attackFactor			= (60 + mt_rand(-6, 6)) / 100;
						$targetFleetData[215]	= 3;
					}
					else
					{
						$Message    			= $LNG['sys_expe_attack_1_3_2'];
						$attackFactor			= (90 + mt_rand(-9, 9)) / 100;
						$targetFleetData[213]	= 2;
					}
				}
					
				foreach($fleetArray as $shipId => $shipAmount)
				{
					if(isset($targetFleetData[$shipId]))
					{
						$targetFleetData[$shipId]	= 0;
					}

					$targetFleetData[$shipId]	= $roundFunction($shipAmount * $attackFactor);
				}

				$targetFleetData	= array_filter($targetFleetData);

				$sql = 'SELECT * FROM %%USERS%% WHERE id = :userId;';

				$senderData	= Database::get()->selectSingle($sql, array(
					':userId'	=> $this->_fleet['fleet_owner']
				));

				$targetData	= array(
					'id'			=> 0,
					'username'		=> $targetName,
					'military_tech'	=> min($senderData['military_tech'] + $techBonus, 0),
					'defence_tech'	=> min($senderData['defence_tech'] + $techBonus, 0),
					'shield_tech'	=> min($senderData['shield_tech'] + $techBonus, 0),
					'rpg_amiral'	=> 0,
					'dm_defensive'	=> 0,
					'dm_attack' 	=> 0
				);
				
				$fleetID	= $this->_fleet['fleet_id'];
				
				$fleetAttack[$fleetID]['fleetDetail']		= $this->_fleet;
				$fleetAttack[$fleetID]['player']			= $senderData;
				$fleetAttack[$fleetID]['player']['factor']	= getFactors($fleetAttack[$this->_fleet['fleet_id']]['player'], 'attack', $this->_fleet['fleet_start_time']);
				$fleetAttack[$fleetID]['unit']				= $fleetArray;
				
				$fleetDefend = array();

				$fleetDefend[0]['fleetDetail'] = array(
					'fleet_start_galaxy'		=> $this->_fleet['fleet_end_galaxy'],
					'fleet_start_system'		=> $this->_fleet['fleet_end_system'],
					'fleet_start_planet'		=> $this->_fleet['fleet_end_planet'],
					'fleet_start_type'			=> 1,
					'fleet_end_galaxy'			=> $this->_fleet['fleet_end_galaxy'],
					'fleet_end_system'			=> $this->_fleet['fleet_end_system'],
					'fleet_end_planet'			=> $this->_fleet['fleet_end_planet'],
					'fleet_end_type'			=> 1,
					'fleet_resource_metal'		=> 0,
					'fleet_resource_crystal'	=> 0,
					'fleet_resource_deuterium'	=> 0
				);

				$bonusList	= BuildFunctions::getBonusList();

				$fleetDefend[0]['player']	= $targetData;
				$fleetDefend[0]['player']['factor']	= ArrayUtil::combineArrayWithSingleElement($bonusList, 0);
				$fleetDefend[0]['unit']		= $targetFleetData;

				require_once 'includes/classes/missions/functions/calculateAttack.php';
				$combatResult	= calculateAttack($fleetAttack, $fleetDefend, $config->Fleet_Cdr, $config->Defs_Cdr);

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

				require_once('includes/classes/missions/functions/GenerateReport.php');
			
			
				$debrisResource	= array(901, 902);
				$debris			= array();

				foreach($debrisResource as $elementID)
				{
					$debris[$elementID]			= 0;
				}
				
				$stealResource	= array(901 => 0, 902 => 0, 903 => 0);
			
				$reportInfo	= array(
					'thisFleet'				=> $this->_fleet,
					'debris'				=> $debris,
					'stealResource'			=> $stealResource,
					'moonChance'			=> 0,
					'moonDestroy'			=> false,
					'moonName'				=> NULL,
					'moonDestroyChance'		=> NULL,
					'moonDestroySuccess'	=> NULL,
					'fleetDestroyChance'	=> NULL,
					'fleetDestroySuccess'	=> NULL,
				);
				
				$reportData	= GenerateReport($combatResult, $reportInfo);
			
				$reportID	= md5(uniqid('', true).TIMESTAMP);

				$sql		= "INSERT INTO %%RW%% SET
				rid			= :reportId,
				raport		= :reportData,
				time		= :time,
				attacker	= :attacker;";

				Database::get()->insert($sql, array(
					':reportId'		=> $reportID,
					':reportData'	=> serialize($reportData),
					':time'			=> $this->_fleet['fleet_start_time'],
					':attacker'		=> $this->_fleet['fleet_owner'],
				));
			
				switch($combatResult['won'])
				{
					case "a":
						$attackClass	= 'raportWin';
						$defendClass	= 'raportLose';
					break;
					case "r":
						$attackClass	= 'raportLose';
						$defendClass	= 'raportWin';
					break;
					default:
						$attackClass	= 'raportDraw';
						$defendClass	= 'raportDraw';
					break;
				}

				$message	= sprintf($messageHTML,
					$reportID,
					$attackClass,
					$LNG['sys_mess_attack_report'],
					sprintf(
						$LNG['sys_adress_planet'],
						$this->_fleet['fleet_end_galaxy'],
						$this->_fleet['fleet_end_system'],
						$this->_fleet['fleet_end_planet']
					),
					$LNG['type_planet_short'][$this->_fleet['fleet_end_type']],
					$LNG['sys_lost'],
					$attackClass,
					$LNG['sys_attack_attacker_pos'], pretty_number($combatResult['unitLost']['attacker']),
					$defendClass,
					$LNG['sys_attack_defender_pos'], pretty_number($combatResult['unitLost']['defender']),
					$LNG['sys_gain'],
					$LNG['tech'][901], pretty_number($stealResource[901]),
					$LNG['tech'][902], pretty_number($stealResource[902]),
					$LNG['tech'][903], pretty_number($stealResource[903]),
					$LNG['sys_debris'],
					$LNG['tech'][901], pretty_number($debris[901]),
					$LNG['tech'][902], pretty_number($debris[902])
				);
				
				PlayerUtil::sendMessage($this->_fleet['fleet_owner'], 0, $LNG['sys_mess_tower'], 3,
					$LNG['sys_mess_attack_report'], $message, $this->_fleet['fleet_end_stay']);

			break;
			case 5:
				$this->KillFleet();
				$Message	= $LNG['sys_expe_lost_fleet_'.mt_rand(1,4)];
			break;
			case 6:
				# http://owiki.de/Expedition#Ver.C3.A4nderte_Flugzeit
				$chance	= mt_rand(0, 100);

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
			
				if($chance < 75)
				{
					// More return time

					$normalBackTime	= $this->_fleet['fleet_end_time'] - $this->_fleet['fleet_end_stay'];
					$stayTime		= $this->_fleet['fleet_end_stay'] - $this->_fleet['fleet_start_time'];
					$factor			= $Wrapper[mt_rand(0, 9)];

					$endTime		= $this->_fleet['fleet_end_stay'] + $normalBackTime + $stayTime + $factor;
					$this->UpdateFleet('fleet_end_time', $endTime);
					$Message = $LNG['sys_expe_time_slow_'.mt_rand(1,6)];
				}
				else
				{
					$normalBackTime	= $this->_fleet['fleet_end_time'] - $this->_fleet['fleet_end_stay'];
					$stayTime		= $this->_fleet['fleet_end_stay'] - $this->_fleet['fleet_start_time'];
					$factor			= $Wrapper[mt_rand(0, 9)];

					$endTime		= max(1, $normalBackTime - $stayTime / 3 * $factor);
					$this->UpdateFleet('fleet_end_time', $endTime);
					$Message = $LNG['sys_expe_time_fast_'.mt_rand(1,3)];
				}
			break;
		}

		PlayerUtil::sendMessage($this->_fleet['fleet_owner'], 0, $LNG['sys_mess_tower'], 15,
			$LNG['sys_expe_report'], $Message, $this->_fleet['fleet_end_stay'], NULL, 1, $this->_fleet['fleet_universe']);

		$this->setState(FLEET_RETURN);
		$this->SaveFleet();
	}
	
	function ReturnEvent()
	{
		$LNG		= $this->getLanguage(NULL, $this->_fleet['fleet_owner']);
		$Message 	= sprintf(
			$LNG['sys_expe_back_home'],
			$LNG['tech'][901], pretty_number($this->_fleet['fleet_resource_metal']),
			$LNG['tech'][902], pretty_number($this->_fleet['fleet_resource_crystal']),
			$LNG['tech'][903], pretty_number($this->_fleet['fleet_resource_deuterium']),
			$LNG['tech'][921], pretty_number($this->_fleet['fleet_resource_darkmatter'])
		);

		PlayerUtil::sendMessage($this->_fleet['fleet_owner'], 0, $LNG['sys_mess_tower'], 4, $LNG['sys_mess_fleetback'],
			$Message, $this->_fleet['fleet_end_time'], NULL, 1, $this->_fleet['fleet_universe']);

		$this->RestoreFleet();
	}
}
