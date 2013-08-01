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

class MissionCaseAttack extends MissionFunctions implements Mission
{
	function __construct($Fleet)
	{
		$this->_fleet	= $Fleet;
	}
	
	function TargetEvent()
	{	
		global $resource, $reslist;

		$db				= Database::get();
		$config			= Config::get($this->_fleet['fleet_universe']);

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
			':planetId'	=> $this->_fleet['fleet_end_id']
		));

		$sql			= "SELECT * FROM %%USERS%% WHERE id = :userId;";
		$targetUser		= $db->selectSingle($sql, array(
			':userId'	=> $targetPlanet['id_owner']
		));
		$targetUser['factor']	= PlayerUtil::getFactors($targetUser, $this->_fleet['fleet_start_time']);

		$planetUpdater	= new ResourceUpdate();
		
		list($targetUser, $targetPlanet)	= $planetUpdater->CalcResource($targetUser, $targetPlanet, true, $this->_fleet['fleet_start_time']);
		
		if($this->_fleet['fleet_group'] != 0)
		{
			$sql	= "DELETE FROM %%AKS%% WHERE id = :acsId;";
			$db->delete($sql, array(
				':acsId'	=> $this->_fleet['fleet_group'],
			));

			$sql	= "SELECT * FROM %%FLEETS%% WHERE fleet_group = :acsId;";

			$incomingFleetsResult = $db->select($sql, array(
				':acsId'	=> $this->_fleet['fleet_group'],
			));
		
			foreach($incomingFleetsResult as $incomingFleetRow)
			{
				$incomingFleets[$incomingFleetRow['fleet_id']] = $incomingFleetRow;
			}
			
			unset($incomingFleetsResult);
		}
		else
		{
			$incomingFleets = array($this->_fleet['fleet_id'] => $this->_fleet);
		}
		
		foreach($incomingFleets as $fleetID => $fleetDetail)
		{
			$sql	= "SELECT * FROM %%USERS%% WHERE id = :userId;";
			$fleetAttack[$fleetID]['player']	= $db->selectSingle($sql, array(
				':userId'	=> $fleetDetail['fleet_owner']
			));

			$fleetAttack[$fleetID]['player']['factor']	= PlayerUtil::getFactors($fleetAttack[$fleetID]['player'], $this->_fleet['fleet_start_time']);
			$fleetAttack[$fleetID]['fleetDetail']		= $fleetDetail;
			$fleetAttack[$fleetID]['unit']				= FleetFunctions::unserialize($fleetDetail['fleet_array']);
			
			$userAttack[$fleetAttack[$fleetID]['player']['id']]	= $fleetAttack[$fleetID]['player']['username'];
		}

		$sql	= "SELECT * FROM %%FLEETS%%
		WHERE fleet_mission		= :mission
		AND fleet_end_id		= :fleetEndId
		AND fleet_start_time 	<= :timeStamp
		AND fleet_end_stay 		>= :timeStamp;";

		$targetFleetsResult = $db->select($sql, array(
			':mission'		=> 5,
			':fleetEndId'	=> $this->_fleet['fleet_end_id'],
			':timeStamp'	=> TIMESTAMP
		));

		foreach($targetFleetsResult as $fleetDetail)
		{
			$fleetID	= $fleetDetail['fleet_id'];

			$sql	= "SELECT * FROM %%USERS%% WHERE id = :userId;";
			$fleetDefend[$fleetID]['player']			= $db->selectSingle($sql, array(
				':userId'	=> $fleetDetail['fleet_owner']
			));

			$fleetDefend[$fleetID]['player']['factor']	= PlayerUtil::getFactors($fleetDefend[$fleetID]['player'], $this->_fleet['fleet_start_time']);
			$fleetDefend[$fleetID]['fleetDetail']		= $fleetDetail;
			$fleetDefend[$fleetID]['unit']				= FleetFunctions::unserialize($fleetDetail['fleet_array']);
			
			$userDefend[$fleetDefend[$fleetID]['player']['id']]	= $fleetDefend[$fleetID]['player']['username'];
		}
			
		unset($targetFleetsResult);
		
		$fleetDefend[0]['player']			= $targetUser;
		$fleetDefend[0]['player']['factor']	= PlayerUtil::getFactors($fleetDefend[0]['player'], $this->_fleet['fleet_start_time']);
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

		foreach ($fleetAttack as $fleetID => $fleetDetail)
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
				if($this->_fleet['fleet_id'] == $fleetID)
				{
					$this->KillFleet();
				}
				else
				{
					$sql	= 'DELETE %%FLEETS%%, %%FLEETS_EVENT%%
					FROM %%FLEETS%%
					INNER JOIN %%FLEETS_EVENT%% ON fleetID = fleet_id
					WHERE fleet_id = :fleetId;';

					$db->delete($sql, array(
						':fleetId'	=> $fleetID
					));
				}
				
				$sql	= 'UPDATE %%LOG_FLEETS%% SET fleet_state = :fleetState WHERE fleet_id = :fleetId;';
				$db->update($sql, array(
					':fleetId'		=> $fleetID,
					':fleetState'	=> FLEET_HOLD,
				));

				unset($fleetAttack[$fleetID]);
			}
			elseif($totalCount > 0)
			{
				$sql = "UPDATE %%FLEETS%% fleet, %%LOG_FLEETS%% log SET
				fleet.fleet_array	= :fleetData,
				fleet.fleet_amount	= :fleetCount,
				log.fleet_array		= :fleetData,
				log.fleet_amount	= :fleetCount
				WHERE log.fleet_id = :fleetId AND log.fleet_id = :fleetId;";

				$db->update($sql, array(
					':fleetData'	=> substr($fleetArray, 0, -1),
					':fleetCount'	=> $totalCount,
					':fleetId'		=> $fleetID
			  	));
			}
			else
			{
				throw new OutOfRangeException("Negative Fleet amount ....");
			}
		}
		
		foreach ($fleetDefend as $fleetID => $fleetDetail)
		{
			if($fleetID != 0)
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
					INNER JOIN %%FLEETS_EVENT%% ON fleetID = fleet_id
					WHERE fleet_id = :fleetId;';

					$db->delete($sql, array(
						':fleetId'	=> $fleetID
					));

					$sql	= 'UPDATE %%LOG_FLEETS%% SET fleet_state = :fleetState WHERE fleet_id = :fleetId;';
					$db->update($sql, array(
						':fleetId'		=> $fleetID,
						':fleetState'	=> FLEET_HOLD,
					));

					unset($fleetAttack[$fleetID]);
				}
				elseif($totalCount > 0)
				{
					$sql = "UPDATE %%FLEETS%% fleet, %%LOG_FLEETS%% log SET
					fleet.fleet_array	= :fleetData,
					fleet.fleet_amount	= :fleetCount,
					log.fleet_array		= :fleetData,
					log.fleet_amount	= :fleetCount
					WHERE log.fleet_id = :fleetId AND log.fleet_id = :fleetId;";

					$db->update($sql, array(
	   					':fleetData'	=> substr($fleetArray, 0, -1),
						':fleetCount'	=> $totalCount,
						':fleetId'		=> $fleetID
					));
				}
				else
				{
					throw new OutOfRangeException("Negative Fleet amount ....");
				}
			}
			else
			{
				$params	= array(':planetId' => $this->_fleet['fleet_end_id']);

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
		
		if($this->_fleet['fleet_end_type'] == 3)
		{
			// Use planet debris, if attack on moons
			$sql			= "SELECT der_metal, der_crystal FROM %%PLANETS%% WHERE id_luna = :moonId;";
			$targetDebris	= $db->selectSingle($sql, array(
				':moonId'	=> $this->_fleet['fleet_end_id']
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
			'thisFleet'				=> $this->_fleet,
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
				$this->_fleet['fleet_universe'],
				$this->_fleet['fleet_end_galaxy'],
				$this->_fleet['fleet_end_system'],
				$this->_fleet['fleet_end_planet'],
				$targetUser['id'],
				$reportInfo['moonName'],
				$chanceCreateMoon,
				$this->_fleet['fleet_start_time']
			);
			
			if(Config::get($this->_fleet['fleet_universe'])->debris_moon == 1)
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
			':time'			=> $this->_fleet['fleet_start_time'],
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
						$this->_fleet['fleet_end_galaxy'],
						$this->_fleet['fleet_end_system'],
						$this->_fleet['fleet_end_planet']
					),
					$LNG['type_planet_short'][$this->_fleet['fleet_end_type']],
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
					$message, $this->_fleet['fleet_start_time'], NULL, 1, $this->_fleet['fleet_universe']);

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
		
		if($this->_fleet['fleet_end_type'] == 3)
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
			':planetId'	=> $this->_fleet['fleet_end_id']
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
			':planetId'		=> $this->_fleet['fleet_end_id']
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
			':time'		=> $this->_fleet['fleet_start_time'],
			':universe'	=> $this->_fleet['fleet_universe'],
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

		$this->setState(FLEET_RETURN);
		$this->SaveFleet();
	}
	
	function EndStayEvent()
	{
		return;
	}
	
	function ReturnEvent()
	{
		$LNG		= $this->getLanguage(NULL, $this->_fleet['fleet_owner']);


		$sql		= 'SELECT name FROM %%PLANETS%% WHERE id = :planetId;';
		$planetName	= Database::get()->selectSingle($sql, array(
			':planetId'	=> $this->_fleet['fleet_start_id'],
		), 'name');

		$Message	= sprintf(
			$LNG['sys_fleet_won'],
			$planetName,
			GetTargetAdressLink($this->_fleet, ''),
			pretty_number($this->_fleet['fleet_resource_metal']),
			$LNG['tech'][901],
			pretty_number($this->_fleet['fleet_resource_crystal']),
			$LNG['tech'][902],
			pretty_number($this->_fleet['fleet_resource_deuterium']),
			$LNG['tech'][903]
		);

		PlayerUtil::sendMessage($this->_fleet['fleet_owner'], 0, $LNG['sys_mess_tower'], 4, $LNG['sys_mess_fleetback'],
			$Message, $this->_fleet['fleet_end_time'], NULL, 1, $this->_fleet['fleet_universe']);

		$this->RestoreFleet();
	}
}