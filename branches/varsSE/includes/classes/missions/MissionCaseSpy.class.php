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

class MissionCaseSpy extends AbstractMission
{
		
	public function arrivalEndTargetEvent()
	{
		$db				= Database::get();

		$sql			= 'SELECT * FROM %%USERS%% WHERE id = :userId;';
		$senderUser		= $db->selectSingle($sql, array(
			':userId'	=> $this->fleetData['fleet_owner']
		));

		$targetUser		= $db->selectSingle($sql, array(
			':userId'	=> $this->fleetData['fleet_target_owner']
		));

		$sql			= 'SELECT * FROM %%PLANETS%% WHERE id = :planetId;';
		$targetPlanet	= $db->selectSingle($sql, array(
			':planetId'	=> $this->fleetData['fleet_end_id']
		));

		$sql				= 'SELECT name FROM %%PLANETS%% WHERE id = :planetId;';
		$senderPlanetName	= $db->selectSingle($sql, array(
			':planetId'	=> $this->fleetData['fleet_start_id']
		), 'name');

		$LNG	= $this->getLanguage($senderUser['lang']);

		$senderUser['factor']	= PlayerUtil::getFactors($senderUser, $this->fleetData['fleet_start_time']);
		$targetUser['factor']	= PlayerUtil::getFactors($targetUser, $this->fleetData['fleet_start_time']);

		$planetUpdater 						= new Economy();
		list($targetUser, $targetPlanet)	= $planetUpdater->CalcResource($targetUser, $targetPlanet, true, $this->fleetData['fleet_start_time']);

		$sql	= 'SELECT * FROM %%FLEETS%% WHERE fleet_end_id = :planetId AND fleet_mission = 5 AND fleet_end_stay > :time;';

		$targetStayFleets	= $db->select($sql, array(
			':planetId'	=> $this->fleetData['fleet_end_id'],
			':time'		=> $this->fleetData['fleet_start_time'],
		));

		$currentFleets	= array();

		foreach($targetStayFleets as $fleetRow)
		{
			$currentFleets[$fleetRow['fleetId']]	= $fleetRow;
		}

		$currentFleets	= FleetUtil::getFleetElements($currentFleets);

		foreach($currentFleets as $fleetRow)
		{
			foreach($fleetRow['elements'][Vars::CLASS_FLEET] as $shipElementId => $value)
			{
				$targetPlanet[Vars::getElement($shipElementId)->name]	+= $value;
			}
		}
		
		$fleetAmount	= array_sum($this->fleetData['elements'][Vars::CLASS_FLEET]) * (1 + $senderUser['factor']['SpyPower']);

		$senderSpyTech	= max($senderUser['spy_tech'], 1);
		$targetSpyTech	= max($targetUser['spy_tech'], 1);

		$techDifference	= abs($senderSpyTech - $targetSpyTech);
		$MinAmount		= ($senderSpyTech > $targetSpyTech ? -1 : 1) * pow($techDifference * SPY_DIFFENCE_FACTOR, 2);
		$SpyFleet		= $fleetAmount >= $MinAmount;
		$SpyDef			= $fleetAmount >= $MinAmount + 1 * SPY_VIEW_FACTOR;
		$SpyBuild		= $fleetAmount >= $MinAmount + 3 * SPY_VIEW_FACTOR;
		$SpyTechno		= $fleetAmount >= $MinAmount + 5 * SPY_VIEW_FACTOR;

		$toSpyElements[Vars::CLASS_RESOURCE]		= Vars::getElements(Vars::CLASS_RESOURCE, array(Vars::FLAG_RESOURCE_PLANET, Vars::FLAG_ENERGY));
				
		if($SpyFleet) 
		{
			$toSpyElements[Vars::CLASS_FLEET]		= Vars::getElements(Vars::CLASS_FLEET);
		}
		
		if($SpyDef) 
		{
			$toSpyElements[Vars::CLASS_DEFENSE]		= Vars::getElements(Vars::CLASS_DEFENSE) + Vars::getElements(Vars::CLASS_MISSILE);
		}
		
		if($SpyBuild) 
		{
			$toSpyElements[Vars::CLASS_BUILDING]	= Vars::getElements(Vars::CLASS_BUILDING);
		}
		
		if($SpyTechno) 
		{
			$toSpyElements[Vars::CLASS_TECH]		= Vars::getElements(Vars::CLASS_TECH);
		}
		
		$targetChance 	= mt_rand(0, min(($fleetAmount/4) * ($targetSpyTech / $senderSpyTech), 100));
		$spyChance  	= mt_rand(0, 100);
		$spyData		= array();

		foreach($toSpyElements as $classId => $elements)
		{
			/** @var $elementObj Element */
			foreach($elements as $elementId => $elementObj)
			{
				if($elementObj->isUserResource())
				{
					$spyData[$classId][$elementId]	= $targetUser[$elementObj->name];
				}
				else 
				{
					$spyData[$classId][$elementId]	= $targetPlanet[$elementObj->name];
				}
			}
		
			if($senderUser['spyMessagesMode'] == 1)
			{
				$spyData[$classId]	= array_filter($spyData[$classId]);
			}
		}
		
		// I'm use template class here, because i want to exclude HTML in PHP.
		
		require_once 'includes/classes/Template.class.php';
		
		$template	= new template;
		
		$template->caching		= true;
		$template->compile_id	= $senderUser['lang'];
		$template->loadFilter('output', 'trimwhitespace');
		list($tplDir)	= $template->getTemplateDir();
		$template->setTemplateDir($tplDir.'game/');
		$template->assign_vars(array(
			'spyData'		=> $spyData,
			'targetPlanet'	=> $targetPlanet,
			'targetChance'	=> $targetChance,
			'spyChance'		=> $spyChance,
			'isBattleSim'	=> ENABLE_SIMULATOR_LINK == true && isModulAvalible(MODULE_SIMULATOR),
			'title'			=> sprintf($LNG['sys_mess_head'], $targetPlanet['name'], $targetPlanet['galaxy'], $targetPlanet['system'], $targetPlanet['planet'], _date($LNG['php_tdformat'], $this->fleetData['fleet_end_time'], $targetUser['timezone'], $LNG)),
		));
		
		$template->assign_vars(array(
			'LNG'			=> $LNG
		), false);
				
		$spyReport	= $template->fetch('shared.mission.spyReport.tpl');

		PlayerUtil::sendMessage($this->fleetData['fleet_owner'], 0, $LNG['sys_mess_qg'], 0, $LNG['sys_mess_spy_report'],
			$spyReport, $this->fleetData['fleet_start_time'], NULL, 1, $this->fleetData['fleet_universe']);
		
		$LNG			= $this->getLanguage($targetUser['lang']);
		$targetMessage  = $LNG['sys_mess_spy_ennemyfleet'] ." ". $senderPlanetName;

		if($this->fleetData['fleet_start_type'] == 3)
		{
			$targetMessage .= $LNG['sys_mess_spy_report_moon'].' ';
		}

		$targetMessage .= implode(' ',
			GetStartAdressLink($this->fleetData),
			$LNG['sys_mess_spy_seen_at'],
			$targetPlanet['name'],
			GetTargetAdressLink($this->fleetData),
			$LNG['sys_mess_spy_seen_at2']
		);

		PlayerUtil::sendMessage($this->fleetData['fleet_target_owner'], 0, $LNG['sys_mess_spy_control'], 0,
			$LNG['sys_mess_spy_activity'], $targetMessage, $this->fleetData['fleet_start_time'], NULL, 1, $this->fleetData['fleet_universe']);

		if ($targetChance >= $spyChance)
		{
			$config		= Config::get($this->fleetData['fleet_universe']);
			$whereCol	= $this->fleetData['fleet_end_type'] == 3 ? 'id_luna' : 'id';

			$param		= array(
				':planetId'	=> $this->fleetData['fleet_end_id']
			);

			$updateQuery	= array();

			foreach($this->fleetData['elements'][Vars::CLASS_FLEET] as $shipElementId => $shipValue)
			{
				foreach(Vars::getElement($shipElementId)->cost as $resourceElementId => $resourceValue)
				{
					$resourceElementObj	= Vars::getElement($resourceElementId);
					if(!$resourceElementObj->hasFlag(Vars::FLAG_DEBRIS))
					{
						continue;
					}

					$updateQuery[]	= 'der_'.$resourceElementObj->name.' = der_'.$resourceElementObj->name.' + :'.$resourceElementObj->name;
					$param[':'.$resourceElementObj->name]	= $fleetAmount * $resourceValue * $config->Fleet_Cdr / 100;
				}
			}

			if(!empty($updateQuery))
			{
				$sql		= 'UPDATE %%PLANETS%% SET
				'.implode(',', $updateQuery).'
				WHERE '.$whereCol.' = :planetId;';
				$db->update($sql, $param);
			}

			$this->killFleet();
		}
		else
		{
			$this->setNextState(FLEET_RETURN);
		}
	}
	
	public function arrivalStartTargetEvent()
	{
		$this->arrivalTo($this->fleetData['fleet_start_id'],
			$this->fleetData['elements'][Vars::CLASS_FLEET], $this->fleetData['elements'][Vars::CLASS_RESOURCE]);
	}
}
