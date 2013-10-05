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

class MissionCaseAttack extends AbstractMission
{
	public function arrivalEndTargetEvent()
	{
		$db				= Database::get();
		$config			= Config::get($this->fleetData['fleet_universe']);

		$fleetAttack	= array();
		$fleetDefend	= array();
		
		$userAttack		= array();
		$userDefend		= array();

		$incomingFleets	= array();

		$stealResource	= array(
			901	=> 0,
			902	=> 0,
			903	=> 0,
		);
		
		$debris			= array();
		$planetDebris	= array();
		
		$debrisResource	= array(901, 902);
		
		$messageHTML	= <<<HTML
<div class="raportMessage">
	<table>
		<tr>
			<td colspan="2"><a href="game.php?page=raport&raport=%s" target="_blank"><span class="%s">%s %s (%s)</span></a></td>
		</tr>
		<tr>
			<td>%s</td><td><span class="%s">%s: %s</span>&nbsp;<span class="%s">%s: %s</span></td>
		</tr>
		<tr>
			<td>%s</td><td><span>%s:&nbsp;<span class="reportSteal element901">%s</span>&nbsp;</span><span>%s:&nbsp;<span class="reportSteal element902">%s</span>&nbsp;</span><span>%s:&nbsp;<span class="reportSteal element903">%s</span></span></td>
		</tr>
		<tr>
			<td>%s</td><td><span>%s:&nbsp;<span class="reportDebris element901">%s</span>&nbsp;</span><span>%s:&nbsp;<span class="reportDebris element902">%s</span></span></td>
		</tr>
	</table>
</div>
HTML;
		//Minize HTML
		$messageHTML	= str_replace(array("\n", "\t", "\r"), "", $messageHTML);

		$sql			= "SELECT * FROM %%PLANETS%% WHERE id = :planetId;";
		$targetPlanet 	= $db->selectSingle($sql, array(
			':planetId'	=> $this->fleetData['fleet_end_id']
		));

		$sql			= "SELECT * FROM %%USERS%% WHERE id = :userId;";
		$targetUser		= $db->selectSingle($sql, array(
			':userId'	=> $targetPlanet['id_owner']
		));
		$targetUser['factor']	= PlayerUtil::getFactors($targetUser, $this->fleetData['fleet_start_time']);

		$planetUpdater	= new Economy();
		
		list($targetUser, $targetPlanet)	= $planetUpdater->CalcResource($targetUser, $targetPlanet, true, $this->fleetData['fleet_start_time']);
		
		if($this->fleetData['fleet_group'] != 0)
		{
			$sql	= "DELETE FROM %%AKS%% WHERE id = :acsId;";
			$db->delete($sql, array(
				':acsId'	=> $this->fleetData['fleet_group'],
			));

			$sql	= "SELECT * FROM %%FLEETS%% WHERE fleet_group = :acsId;";

			$incomingFleetsResult = $db->select($sql, array(
				':acsId'	=> $this->fleetData['fleet_group'],
			));
		
			foreach($incomingFleetsResult as $incomingFleetRow)
			{
				$incomingFleets[$incomingFleetRow['fleetId']] = $incomingFleetRow;
			}
			
			unset($incomingFleetsResult);
		}
		else
		{
			$incomingFleets = array($this->fleetData['fleetId'] => $this->fleetData);
		}
		
		foreach($incomingFleets as $fleetId => $fleetDetail)
		{
			$sql	= "SELECT * FROM %%USERS%% WHERE id = :userId;";
			$fleetAttack[$fleetId]['player']	= $db->selectSingle($sql, array(
				':userId'	=> $fleetDetail['fleet_owner']
			));

			$fleetAttack[$fleetId]['player']['factor']	= PlayerUtil::getFactors($fleetAttack[$fleetId]['player'], $this->fleetData['fleet_start_time']);
			$fleetAttack[$fleetId]['fleetDetail']		= $fleetDetail;
			$fleetAttack[$fleetId]['unit']				= FleetUtil::unserialize($fleetDetail['fleet_array']);
			
			$userAttack[$fleetAttack[$fleetId]['player']['id']]	= $fleetAttack[$fleetId]['player']['username'];
		}

		$sql	= "SELECT * FROM %%FLEETS%%
		WHERE fleet_mission		= :mission
		AND fleet_end_id		= :fleetEndId
		AND fleet_start_time 	<= :timeStamp
		AND fleet_end_stay 		>= :timeStamp;";

		$targetFleetsResult = $db->select($sql, array(
			':mission'		=> 5,
			':fleetEndId'	=> $this->fleetData['fleet_end_id'],
			':timeStamp'	=> TIMESTAMP
		));

		foreach($targetFleetsResult as $fleetDetail)
		{
			$fleetId	= $fleetDetail['fleetId'];

			$sql	= "SELECT * FROM %%USERS%% WHERE id = :userId;";
			$fleetDefend[$fleetId]['player']			= $db->selectSingle($sql, array(
				':userId'	=> $fleetDetail['fleet_owner']
			));

			$fleetDefend[$fleetId]['player']['factor']	= PlayerUtil::getFactors($fleetDefend[$fleetId]['player'], $this->fleetData['fleet_start_time']);
			$fleetDefend[$fleetId]['fleetDetail']		= $fleetDetail;
			$fleetDefend[$fleetId]['unit']				= FleetUtil::unserialize($fleetDetail['fleet_array']);
			
			$userDefend[$fleetDefend[$fleetId]['player']['id']]	= $fleetDefend[$fleetId]['player']['username'];
		}
			
		unset($targetFleetsResult);
		
		$fleetDefend[0]['player']			= $targetUser;
		$fleetDefend[0]['player']['factor']	= PlayerUtil::getFactors($fleetDefend[0]['player'], $this->fleetData['fleet_start_time']);
		$fleetDefend[0]['fleetDetail']		= array(
			'fleet_start_galaxy'	=> $targetPlanet['galaxy'], 
			'fleet_start_system'	=> $targetPlanet['system'], 
			'fleet_start_planet'	=> $targetPlanet['planet'], 
			'fleet_start_type'		=> $targetPlanet['planet_type'], 
		);
		
		$fleetDefend[0]['unit']				= array();
		
		foreach(array_merge($reslist['fleet'], $reslist['defense']) as $elementID)
		{
			if (empty($targetPlanet[$resource[$elementID]])) continue;

			$fleetDefend[0]['unit'][$elementID] = $targetPlanet[$resource[$elementID]];
		}
			
		$userDefend[$fleetDefend[0]['player']['id']]	= $fleetDefend[0]['player']['username'];
		
		require_once 'includes/classes/missions/functions/calculateAttack.php';

		$fleetIntoDebris	= $config->Fleet_Cdr;
		$defIntoDebris		= $config->Defs_Cdr;
		
		$combatResult 		= calculateAttack($fleetAttack, $fleetDefend, $fleetIntoDebris, $defIntoDebris);

		foreach ($fleetAttack as $fleetId => $fleetDetail)
		{
			$fleetArray = '';
			$totalCount = 0;
			
			$fleetDetail['unit']	= array_filter($fleetDetail['unit']);
			foreach ($fleetDetail['unit'] as $elementID => $amount)
			{				
				$fleetArray .= $elementID.','.floattostring($amount).';';
				$totalCount += $amount;
			}
			
			if($totalCount == 0)
			{
				if($this->fleetData['fleetId'] == $fleetId)
				{
					$this->KillFleet();
				}
				else
				{
					$sql	= 'DELETE %%FLEETS%%, %%FLEETS_EVENT%%
					FROM %%FLEETS%%
					INNER JOIN %%FLEETS_EVENT%% ON fleetId = fleetId
					WHERE fleetId = :fleetId;';

					$db->delete($sql, array(
						':fleetId'	=> $fleetId
					));
				}
				
				$sql	= 'UPDATE %%LOG_FLEETS%% SET fleet_state = :fleetState WHERE fleetId = :fleetId;';
				$db->update($sql, array(
					':fleetId'		=> $fleetId,
					':fleetState'	=> FLEET_HOLD,
				));

				unset($fleetAttack[$fleetId]);
			}
			elseif($totalCount > 0)
			{
				$sql = "UPDATE %%FLEETS%% fleet, %%LOG_FLEETS%% log SET
				fleet.fleet_array	= :fleetData,
				fleet.fleet_amount	= :fleetCount,
				log.fleet_array		= :fleetData,
				log.fleet_amount	= :fleetCount
				WHERE log.fleetId = :fleetId AND log.fleetId = :fleetId;";

				$db->update($sql, array(
					':fleetData'	=> substr($fleetArray, 0, -1),
					':fleetCount'	=> $totalCount,
					':fleetId'		=> $fleetId
			  	));
			}
			else
			{
				throw new OutOfRangeException("Negative Fleet amount ....");
			}
		}
		
		foreach ($fleetDefend as $fleetId => $fleetDetail)
		{
			if($fleetId != 0)
			{
				// Stay fleet
				$fleetArray = '';
				$totalCount = 0;
				
				$fleetDetail['unit']	= array_filter($fleetDetail['unit']);
				
				foreach ($fleetDetail['unit'] as $elementID => $amount)
				{				
					$fleetArray .= $elementID.','.floattostring($amount).';';
					$totalCount += $amount;
				}
				
				if($totalCount == 0)
				{
					$sql	= 'DELETE %%FLEETS%%, %%FLEETS_EVENT%%
					FROM %%FLEETS%%
					INNER JOIN %%FLEETS_EVENT%% ON fleetId = fleetId
					WHERE fleetId = :fleetId;';

					$db->delete($sql, array(
						':fleetId'	=> $fleetId
					));

					$sql	= 'UPDATE %%LOG_FLEETS%% SET fleet_state = :fleetState WHERE fleetId = :fleetId;';
					$db->update($sql, array(
						':fleetId'		=> $fleetId,
						':fleetState'	=> FLEET_HOLD,
					));

					unset($fleetAttack[$fleetId]);
				}
				elseif($totalCount > 0)
				{
					$sql = "UPDATE %%FLEETS%% fleet, %%LOG_FLEETS%% log SET
					fleet.fleet_array	= :fleetData,
					fleet.fleet_amount	= :fleetCount,
					log.fleet_array		= :fleetData,
					log.fleet_amount	= :fleetCount
					WHERE log.fleetId = :fleetId AND log.fleetId = :fleetId;";

					$db->update($sql, array(
	   					':fleetData'	=> substr($fleetArray, 0, -1),
						':fleetCount'	=> $totalCount,
						':fleetId'		=> $fleetId
					));
				}
				else
				{
					throw new OutOfRangeException("Negative Fleet amount ....");
				}
			}
			else
			{
				$params	= array(':planetId' => $this->fleetData['fleet_end_id']);

				// Planet fleet
				$fleetArray = array();
				foreach ($fleetDetail['unit'] as $elementID => $amount)
				{				
					$fleetArray[] = '`'.$resource[$elementID].'` = :'.$resource[$elementID];
					$params[':'.$resource[$elementID]]	= $amount;
				}
				
				if(!empty($fleetArray))
				{
					$sql = 'UPDATE %%PLANETS%% SET '.implode(', ', $fleetArray).' WHERE id = :planetId;';
					$db->update($sql, $params);
				}
			}
		}
		
		if ($combatResult['won'] == "a")
		{
			require_once 'includes/classes/missions/functions/calculateSteal.php';
			$stealResource = calculateSteal($fleetAttack, $targetPlanet);
		}
		
		if($this->fleetData['fleet_end_type'] == 3)
		{
			// Use planet debris, if attack on moons
			$sql			= "SELECT der_metal, der_crystal FROM %%PLANETS%% WHERE id_luna = :moonId;";
			$targetDebris	= $db->selectSingle($sql, array(
				':moonId'	=> $this->fleetData['fleet_end_id']
			));
			$targetPlanet 	+= $targetDebris;
		}
		
		foreach($debrisResource as $elementID)
		{
			$debris[$elementID]			= $combatResult['debris']['attacker'][$elementID] + $combatResult['debris']['defender'][$elementID];
			$planetDebris[$elementID]	= $targetPlanet['der_'.$resource[$elementID]] + $debris[$elementID];
		}
		
		$debrisTotal		= array_sum($debris);
		
		$moonFactor			= $config->moon_factor;
		$maxMoonChance		= $config->moon_chance;
		
		if($targetPlanet['id_luna'] == 0 && $targetPlanet['planet_type'] == 1)
		{
			$chanceCreateMoon	= round($debrisTotal / 100000 * $moonFactor);
			$chanceCreateMoon	= min($chanceCreateMoon, $maxMoonChance);
		}
		else
		{
			$chanceCreateMoon	= 0;
		}

		$reportInfo	= array(
			'thisFleet'				=> $this->fleetData,
			'debris'				=> $debris,
			'stealResource'			=> $stealResource,
			'moonChance'			=> $chanceCreateMoon,
			'moonDestroy'			=> false,
			'moonName'				=> NULL,
			'moonDestroyChance'		=> NULL,
			'moonDestroySuccess'	=> NULL,
			'fleetDestroyChance'	=> NULL,
			'fleetDestroySuccess'	=> NULL,
		);
		
		$randChance	= mt_rand(1, 100);
		if ($randChance <= $chanceCreateMoon)
		{
			$LNG					= $this->getLanguage($targetUser['lang']);
			$reportInfo['moonName']	= $LNG['type_planet'][3];
			
			PlayerUtil::createMoon(
				$this->fleetData['fleet_universe'],
				$this->fleetData['fleet_end_galaxy'],
				$this->fleetData['fleet_end_system'],
				$this->fleetData['fleet_end_planet'],
				$targetUser['id'],
				$reportInfo['moonName'],
				$chanceCreateMoon,
				$this->fleetData['fleet_start_time']
			);
			
			if(Config::get($this->fleetData['fleet_universe'])->debris_moon == 1)
			{
				foreach($debrisResource as $elementID)
				{
					$planetDebris[$elementID]	= 0;
				}
			}
		}
		
		require_once 'includes/classes/missions/functions/GenerateReport.php';
		$reportData	= GenerateReport($combatResult, $reportInfo);
		
		switch($combatResult['won'])
		{
			case "a":
				// Win
				$attackStatus	= 'wons';
				$defendStatus	= 'loos';
				$class			= array('raportWin', 'raportLose');
				break;
			case "r":
				// Lose
				$attackStatus	= 'loos';
				$defendStatus	= 'wons';
				$class			= array('raportLose', 'raportWin');
				break;
			case "w":
			default:
				// Draw
				$attackStatus	= 'draws';
				$defendStatus	= 'draws';
				$class			= array('raportDraw', 'raportDraw');
				break;
		}
		
		$reportID	= md5(uniqid('', true).TIMESTAMP);
		
		$sql	= 'INSERT INTO %%RW%% SET
		rid 		= :reportId,
		raport 		= :reportData,
		time 		= :time,
		attacker	= :attackers,
		defender	= :defenders;';

		$db->insert($sql, array(
			':reportId'		=> $reportID,
			':reportData'	=> serialize($reportData),
			':time'			=> $this->fleetData['fleet_start_time'],
			':attackers'	=> implode(',', array_keys($userAttack)),
			':defenders'	=> implode(',', array_keys($userDefend))
		));

		$i = 0;

		foreach(array($userAttack, $userDefend) as $data)
		{
			$thisClass	= $class[$i];
			foreach($data as $userID => $userName)
			{
				$LNG		= $this->getLanguage(NULL, $userID);
				
				$message	= sprintf($messageHTML,
					$reportID,
					$thisClass[$i],
					$LNG['sys_mess_attack_report'],
					sprintf(
						$LNG['sys_adress_planet'],
						$this->fleetData['fleet_end_galaxy'],
						$this->fleetData['fleet_end_system'],
						$this->fleetData['fleet_end_planet']
					),
					$LNG['type_planet_short'][$this->fleetData['fleet_end_type']],
					$LNG['sys_lost'],
					$thisClass[0],
					$LNG['sys_attack_attacker_pos'],
					pretty_number($combatResult['unitLost']['attacker']),
					$thisClass[1],
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

				PlayerUtil::sendMessage($userID, 0, $LNG['sys_mess_tower'], 3, $LNG['sys_mess_attack_report'],
					$message, $this->fleetData['fleet_start_time'], NULL, 1, $this->fleetData['fleet_universe']);

				$sql	= "INSERT INTO %%TOPKB_USERS%% SET
				rid			= :reportId,
				role		= :userRole,
				username	= :username,
				uid			= :userId;";

				$db->insert($sql, array(
					':reportId'	=> $reportID,
					':userRole'	=> 1,
					':username'	=> $userName,
					':userId'	=> $userID
				));
			}

			$i++;
		}
		
		if($this->fleetData['fleet_end_type'] == 3)
		{
			$debrisType	= 'id_luna';
		}
		else
		{
			$debrisType	= 'id';
		}
		
		$sql = 'UPDATE %%PLANETS%% SET
		der_metal	= :metal,
		der_crystal	= :crystal
		WHERE '.$debrisType.' = :planetId;';

		$db->update($sql, array(
			':metal'	=> $planetDebris[901],
			':crystal'	=> $planetDebris[902],
			':planetId'	=> $this->fleetData['fleet_end_id']
		));

		$sql = 'UPDATE %%PLANETS%% SET
		metal		= metal - :metal,
		crystal		= crystal - :crystal,
		deuterium	= deuterium - :deuterium
		WHERE id = :planetId;';

		$db->update($sql, array(
			':metal'		=> $stealResource[901],
			':crystal'		=> $stealResource[902],
			':deuterium'	=> $stealResource[903],
			':planetId'		=> $this->fleetData['fleet_end_id']
		));

		$sql = 'INSERT INTO %%TOPKB%% SET
		units 		= :units,
		rid			= :reportId,
		time		= :time,
		universe	= :universe,
		result		= :result;';

		$db->insert($sql, array(
			':units'	=> $combatResult['unitLost']['attacker'] + $combatResult['unitLost']['defender'],
			':reportId'	=> $reportID,
			':time'		=> $this->fleetData['fleet_start_time'],
			':universe'	=> $this->fleetData['fleet_universe'],
			':result'	=> $combatResult['won']
		));

		$sql = 'UPDATE %%USERS%% SET
		`'.$attackStatus.'` = `'.$attackStatus.'` + 1,
		kbmetal		= kbmetal + :debrisMetal,
		kbcrystal	= kbcrystal + :debrisCrystal,
		lostunits	= lostunits + :lostUnits,
		desunits	= desunits + :destroyedUnits
		WHERE id IN ('.implode(',', array_keys($userAttack)).');';

		$db->update($sql, array(
			':debrisMetal'		=> $debris[901],
			':debrisCrystal'	=> $debris[902],
			':lostUnits'		=> $combatResult['unitLost']['attacker'],
			':destroyedUnits'	=> $combatResult['unitLost']['defender']
	  	));

		$sql = 'UPDATE %%USERS%% SET
		`'.$defendStatus.'` = `'.$defendStatus.'` + 1,
		kbmetal		= kbmetal + :debrisMetal,
		kbcrystal	= kbcrystal + :debrisCrystal,
		lostunits	= lostunits + :lostUnits,
		desunits	= desunits + :destroyedUnits
		WHERE id IN ('.implode(',', array_keys($userDefend)).');';

		$db->update($sql, array(
			':debrisMetal'		=> $debris[901],
			':debrisCrystal'	=> $debris[902],
			':lostUnits'		=> $combatResult['unitLost']['defender'],
			':destroyedUnits'	=> $combatResult['unitLost']['attacker']
		));

		$this->setNextState(FLEET_RETURN);
	}

	public function arrivalStartTargetEvent()
	{
		$sql		= 'SELECT name, lang FROM %%PLANETS%% INNER JOIN %%USERS%% ON id = id_owner WHERE id = :planetId;';
		$userData	= Database::get()->selectSingle($sql, array(
			':planetId'	=> $this->fleetData['fleet_start_id'],
		));

		$LNG		= $this->getLanguage($userData['language']);

		$resourceList	= array();
		foreach($this->fleetData['elements'][Vars::CLASS_RESOURCE] as $resourceElementId => $value)
		{
			$resourceList[$LNG['tech'][$resourceElementId]]	= $value;
		}

		$playerMessage 	= sprintf(
			$LNG['sys_fleet_won'],
			$userData['name'],
			GetTargetAdressLink($this->fleetData, ''),
			Language::createHumanReadableList($resourceList)
		);

		PlayerUtil::sendMessage($this->fleetData['fleet_owner'], 0, $LNG['sys_mess_tower'], 4, $LNG['sys_mess_fleetback'],
			$playerMessage, $this->fleetData['fleet_end_time'], NULL, 1, $this->fleetData['fleet_universe']);

		$this->arrivalTo($this->fleetData['fleet_start_id'],
			$this->fleetData['elements'][Vars::CLASS_FLEET], $this->fleetData['elements'][Vars::CLASS_RESOURCE]);
	}
}