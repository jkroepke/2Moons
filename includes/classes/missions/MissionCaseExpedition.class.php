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
 * @version 1.8.0 (2013-03-18)
 * @info $Id$
 * @link http://2moons.cc/
 */

class MissionCaseExpedition extends AbstractMission
{
	public function arrivalEndTargetEvent()
	{
		$this->setNextState(FLEET_HOLD);
	}

	public function endStayTimeEvent()
	{
		$sql		= 'SELECT * FROM %%USERS%% WHERE id = :userId;';
		$senderUser	= Database::get()->selectSingle($sql, array(
			':userId'	=> $this->fleetData['fleet_owner'],
		), 'lang');

		$senderUser['factor']	= PlayerUtil::getFactors($senderUser, $this->fleetData['fleet_start_time']);

		$LNG	= $this->getLanguage($senderUser['lang']);
		$config	= Config::get($this->fleetData['fleet_universe']);

		$fleetPoints 	= 0;
		foreach($this->fleetData['elements'][Vars::CLASS_FLEET] as $shipElementId => $amount)
		{
			$fleetPoints   	+= $amount * FleetUtil::calcStructurePoints(Vars::getElement($shipElementId)) * 5 / 1000;
		}

		$selectEvent	= mt_rand(1, 9);

        $playerMessage        = $LNG['sys_expe_nothing_'.mt_rand(1,8)];

		switch($selectEvent)
		{
			case 1:
				$eventSize		= mt_rand(0, 100);
                $factor			= 0;

				if(10 < $eventSize)
				{
					$playerMessage	= $LNG['sys_expe_found_ress_1_'.mt_rand(1,4)];
					$factor		= mt_rand(10, 50);
				}
				elseif(0 < $eventSize && 10 >= $eventSize)
				{
					$playerMessage	= $LNG['sys_expe_found_ress_2_'.mt_rand(1,3)];
					$factor		= mt_rand(50, 100);
				}
				elseif(0 == $eventSize)
				{
					$playerMessage	= $LNG['sys_expe_found_ress_3_'.mt_rand(1,2)];
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
					':universe'	=> $this->fleetData['fleet_universe']
				), 'total');

				if($topPoints > 5000000)
				{
					$maxFactor	= 12000;
				}
				elseif($topPoints > 1000000)
				{
					$maxFactor	= 9000;
				}
				elseif($topPoints > 100000)
				{
					$maxFactor	= 6000;
				}
				else
				{
					$maxFactor	= 2400;
				}

				$fleetRoom	= FleetUtil::GetFleetRoom($this->fleetData['elements'][Vars::CLASS_FLEET]);
				$fleetRoom	+= PlayerUtil::getBonusValue($fleetRoom, 'ShipStorage', $senderUser);
				$fleetRoom  -= array_sum($this->fleetData['elements'][Vars::CLASS_RESOURCE]);

				$found	= round(min($fleetRoom, min($maxFactor, max(200, $factor)) * $fleetPoints));

				$this->fleetData['elements'][Vars::CLASS_RESOURCE][$resourceId]	+= $found;
			break;
			case 2:
				$eventSize  = mt_rand(0, 100);
				$found	= 0;

				if(10 < $eventSize) {
					$found		= mt_rand(100, 300);
					$playerMessage	= $LNG['sys_expe_found_dm_1_'.mt_rand(1,5)];
				} elseif(0 < $eventSize && 10 >= $eventSize) {
					$found		= mt_rand(301, 600);
					$playerMessage	= $LNG['sys_expe_found_dm_2_'.mt_rand(1,3)];
				} elseif(0 == $eventSize) {
					$found		= mt_rand(601, 3000);
					$playerMessage	= $LNG['sys_expe_found_dm_3_'.mt_rand(1,2)];
				}

				$fleetRoom	= FleetUtil::GetFleetRoom($this->fleetData['elements'][Vars::CLASS_FLEET]);
				$fleetRoom	+= PlayerUtil::getBonusValue($fleetRoom, 'ShipStorage', $senderUser);
				$fleetRoom  -= array_sum($this->fleetData['elements'][Vars::CLASS_RESOURCE]);

				$this->fleetData['elements'][Vars::CLASS_RESOURCE][921]	+= min($fleetRoom, $found);
			break;
			case 3:
				$eventSize	= mt_rand(0, 100);
                $Size       = 0;
                $playerMessage    = "";

				if(10 < $eventSize) {
					$Size		= mt_rand(10, 50);
					$playerMessage	= $LNG['sys_expe_found_ships_1_'.mt_rand(1,4)];
				} elseif(0 < $eventSize && 10 >= $eventSize) {
					$Size		= mt_rand(52, 100);
					$playerMessage	= $LNG['sys_expe_found_ships_2_'.mt_rand(1,2)];
				} elseif(0 == $eventSize) {
					$Size	 	= mt_rand(102, 200);
					$playerMessage	= $LNG['sys_expe_found_ships_3_'.mt_rand(1,2)];
				}

				$sql		= "SELECT MAX(total_points) as total FROM %%STATPOINTS%%
				WHERE `stat_type` = :type AND `universe` = :universe;";

				$topPoints	= Database::get()->selectSingle($sql, array(
					':type'		=> 1,
					':universe'	=> $this->fleetData['fleet_universe']
				), 'total');

				$MaxPoints 		= ($topPoints < 5000000) ? 4500 : 6000;

				$maxFoundPoints	= max(round($Size * min($fleetPoints, $MaxPoints)), 10000);
				
				$foundReport	= "";

				foreach(Vars::getElements(Vars::CLASS_FLEET) as $fleetElementId => $fleetElementObj)
				{
					if(!isset($this->fleetData['elements'][Vars::CLASS_FLEET][$fleetElementId]) || $fleetElementId == 208 || $fleetElementId == 209 || $fleetElementId == 214)
						continue;

					$structurePoints		= FleetUtil::calcStructurePoints($fleetElementObj);

					$maxFoundAmount			= floor($maxFoundPoints / $structurePoints);

					if($maxFoundAmount <= 0) continue;
						
					$found					= mt_rand(0, $maxFoundAmount);

					if($found <= 0) continue;

					$maxFoundPoints			-= $found * $structurePoints;
					$foundReport	  		.= '<br>'.$LNG['tech'][$fleetElementId].': '.pretty_number($found);

					$this->fleetData['elements'][Vars::CLASS_FLEET][$fleetElementId]	+= $found;

					if($maxFoundPoints <= 0) break;
				}
				
				if (empty($foundReport)) {
					$foundReport .= '<br><br>'.$LNG['sys_expe_found_ships_nothing'];
				}
				
				$playerMessage	.= $foundReport;
			break;
			case 4:
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
						$playerMessage    		= $LNG['sys_expe_attack_1_1_5'];
						$attackFactor			= 30 + mt_rand(-3, 3) / 100;
						$targetFleetData[204]	= 5;
					}
					elseif(0 < $eventSize && 10 >= $eventSize)
					{
						$playerMessage    		= $LNG['sys_expe_attack_1_2_3'];
						$attackFactor			= 50 + mt_rand(-5, 5) / 100;
						$targetFleetData[206]	= 3;
					}
					else
					{
						$playerMessage   		= $LNG['sys_expe_attack_1_3_2'];
						$attackFactor			= 80 + mt_rand(-8, 8) / 100;
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
						$playerMessage    		= $LNG['sys_expe_attack_1_1_5'];
						$attackFactor			= 40 + mt_rand(-4, 4) / 100;
						$targetFleetData[204]	= 5;
					}
					elseif(0 < $eventSize && 10 >= $eventSize)
					{
						$playerMessage    		= $LNG['sys_expe_attack_1_3_3'];
						$attackFactor			= 60 + mt_rand(-6, 6) / 100;
						$targetFleetData[215]	= 3;
					}
					else
					{
						$playerMessage    		= $LNG['sys_expe_attack_1_3_2'];
						$attackFactor			= 90 + mt_rand(-9, 9) / 100;
						$targetFleetData[213]	= 2;
					}
				}
					
				foreach($this->fleetData['elements'][Vars::CLASS_FLEET] as $shipId => $shipAmount)
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
					':userId'	=> $this->fleetData['fleet_owner']
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
				
				$fleetId	= $this->fleetData['fleetId'];
				
				$fleetAttack[$fleetId]['fleetDetail']		= $this->fleetData;
				$fleetAttack[$fleetId]['player']			= $senderData;
				$fleetAttack[$fleetId]['player']['factor']	= PlayerUtil::getFactors($fleetAttack[$this->fleetData['fleetId']]['player'], $this->fleetData['fleet_start_time']);
				$fleetAttack[$fleetId]['unit']				= $this->fleetData['elements'][Vars::CLASS_FLEET];
				
				$fleetDefend = array();

				$fleetDefend[0]['fleetDetail'] = array(
					'fleet_start_galaxy'		=> $this->fleetData['fleet_end_galaxy'],
					'fleet_start_system'		=> $this->fleetData['fleet_end_system'],
					'fleet_start_planet'		=> $this->fleetData['fleet_end_planet'],
					'fleet_start_type'			=> 1,
					'fleet_end_galaxy'			=> $this->fleetData['fleet_end_galaxy'],
					'fleet_end_system'			=> $this->fleetData['fleet_end_system'],
					'fleet_end_planet'			=> $this->fleetData['fleet_end_planet'],
					'fleet_end_type'			=> 1,
					'fleet_resource_metal'		=> 0,
					'fleet_resource_crystal'	=> 0,
					'fleet_resource_deuterium'	=> 0
				);

				$bonusList	= BuildUtil::getBonusList();

				$fleetDefend[0]['player']	= $targetData;
				$fleetDefend[0]['player']['factor']	= ArrayUtil::combineArrayWithSingleElement($bonusList, 0);
				$fleetDefend[0]['unit']		= $targetFleetData;

				require_once 'includes/classes/missions/functions/calculateAttack.php';
				$combatResult	= calculateAttack($fleetAttack, $fleetDefend, $config->Fleet_Cdr, $config->Defs_Cdr);

				$fleetAttack[$fleetId]['unit']	= array_filter($fleetAttack[$fleetId]['unit']);

				$this->fleetData['elements'][Vars::CLASS_FLEET]	= array();
				foreach ($fleetAttack[$fleetId]['unit'] as $element => $amount)
				{
					$this->fleetData['elements'][Vars::CLASS_FLEET][$element]	= $amount;
				}

				if (empty($this->fleetData['elements'][Vars::CLASS_FLEET]))
				{
					$this->killFleet();
				}

				require_once('includes/classes/missions/functions/GenerateReport.php');
			
			
				$debrisResourceIds	= array_keys(Vars::getElements(Vars::CLASS_RESOURCE, Vars::FLAG_DEBRIS));
				$debris				= ArrayUtil::combineArrayWithSingleElement($debrisResourceIds, 0);

				$stealResourceIds	= array_keys(Vars::getElements(Vars::CLASS_RESOURCE, Vars::FLAG_STEAL));
				$steal				= ArrayUtil::combineArrayWithSingleElement($stealResourceIds, 0);
			
				$reportInfo	= array(
					'thisFleet'				=> $this->fleetData,
					'debris'				=> $debris,
					'stealResource'			=> $steal,
					'moonChance'			=> 0,
					'moonDestroy'			=> false,
					'moonName'				=> NULL,
					'moonDestroyChance'		=> NULL,
					'moonDestroySuccess'	=> NULL,
					'fleetDestroyChance'	=> NULL,
					'fleetDestroySuccess'	=> NULL,
				);
				
				$reportData	= GenerateReport($combatResult, $reportInfo);
			
				$reportId	= md5(uniqid('', true).TIMESTAMP);

				$sql		= "INSERT INTO %%RW%% SET
				rid			= :reportId,
				raport		= :reportData,
				time		= :time,
				attacker	= :attacker;";

				Database::get()->insert($sql, array(
					':reportId'		=> $reportId,
					':reportData'	=> serialize($reportData),
					':time'			=> $this->fleetData['fleet_start_time'],
					':attacker'		=> $this->fleetData['fleet_owner'],
				));
			
				switch($combatResult['won'])
				{
					case "a":
						$attackClass	= 'reportWin';
						$defendClass	= 'reportLose';
					break;
					case "r":
						$attackClass	= 'reportLose';
						$defendClass	= 'reportWin';
					break;
					default:
						$attackClass	= 'reportDraw';
						$defendClass	= 'reportDraw';
					break;
				}


				$template	= $this->getTplObj($LNG);
				$template->assign_vars(array(
					'reportId'		=> $reportId,
					'attackClass'	=> $attackClass,
					'defendClass'	=> $defendClass,
					'planetPos'		=> array(
						'galaxy'		=> $this->fleetData['fleet_end_galaxy'],
						'system'		=> $this->fleetData['fleet_end_system'],
						'planet'		=> $this->fleetData['fleet_end_planet'],
						'type'			=> $this->fleetData['fleet_end_type']
					),
					'unitLost'		=> $combatResult['unitLost'],
					'steal'			=> $steal,
					'debris'		=> $debris,
				));

				$message	= $template->getSmartyObj()->fetch('shared.mission.short.tpl');
				
				PlayerUtil::sendMessage($this->fleetData['fleet_owner'], 0, $this->fleetData['fleet_end_stay'], 3,
					$LNG['sys_mess_tower'], $LNG['sys_mess_attack_report'], $message);

			break;
			case 5:
				$this->killFleet();
				$playerMessage	= $LNG['sys_expe_lost_fleet_'.mt_rand(1,4)];
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

					$normalBackTime	= $this->fleetData['fleet_end_time'] - $this->fleetData['fleet_end_stay'];
					$stayTime		= $this->fleetData['fleet_end_stay'] - $this->fleetData['fleet_start_time'];
					$factor			= $Wrapper[mt_rand(0, 9)];

					$endTime		= $this->fleetData['fleet_end_stay'] + $normalBackTime + $stayTime + $factor;
					$playerMessage = $LNG['sys_expe_time_slow_'.mt_rand(1,6)];
				}
				else
				{
					$normalBackTime	= $this->fleetData['fleet_end_time'] - $this->fleetData['fleet_end_stay'];
					$stayTime		= $this->fleetData['fleet_end_stay'] - $this->fleetData['fleet_start_time'];
					$factor			= $Wrapper[mt_rand(0, 9)];

					$endTime		= max(1, $normalBackTime - $stayTime / 3 * $factor);
					$playerMessage = $LNG['sys_expe_time_fast_'.mt_rand(1,3)];
				}

				$this->fleetData['fleet_end_time']	= $endTime;
			break;
		}

		PlayerUtil::sendMessage($this->fleetData['fleet_owner'], 0, $LNG['sys_mess_tower'], 15,
			$LNG['sys_expe_report'], $playerMessage, $this->fleetData['fleet_end_stay'], NULL, 1, $this->fleetData['fleet_universe']);

		$this->setNextState(FLEET_RETURN);
	}
	
	public function arrivalStartTargetEvent()
	{
		$sql		= 'SELECT name, lang FROM %%PLANETS%% INNER JOIN %%USERS%% ON id = id_owner WHERE id = :planetId;';
		$senderUser	= Database::get()->selectSingle($sql, array(
			':planetId'	=> $this->fleetData['fleet_start_id'],
		));

		$LNG		= $this->getLanguage($senderUser['language']);

		$resourceList	= array();
		foreach($this->fleetData['elements'][Vars::CLASS_RESOURCE] as $resourceElementId => $value)
		{
			$resourceList[$LNG['tech'][$resourceElementId]]	= $value;
		}

		$playerMessage 	= sprintf($LNG['sys_expe_back_home'], Language::createHumanReadableList($resourceList));

		PlayerUtil::sendMessage($this->fleetData['fleet_owner'], 0, $LNG['sys_mess_tower'], 4, $LNG['sys_mess_fleetback'],
			$playerMessage, $this->fleetData['fleet_end_time'], NULL, 1, $this->fleetData['fleet_universe']);

		$this->arrivalTo($this->fleetData['fleet_start_id'],
			$this->fleetData['elements'][Vars::CLASS_FLEET], $this->fleetData['elements'][Vars::CLASS_RESOURCE]);
	}
}
