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

class MissionCaseSpy extends MissionFunctions implements Mission
{
		
	function __construct($Fleet)
	{
		$this->_fleet	= $Fleet;
	}
	
	function TargetEvent()
	{
		global $pricelist, $reslist, $resource;

		$db				= Database::get();

		$sql			= 'SELECT * FROM %%USERS%% WHERE id = :userId;';
		$senderUser		= $db->selectSingle($sql, array(
			':userId'	=> $this->_fleet['fleet_owner']
		));

		$targetUser		= $db->selectSingle($sql, array(
			':userId'	=> $this->_fleet['fleet_target_owner']
		));

		$sql			= 'SELECT * FROM %%PLANETS%% WHERE id = :planetId;';
		$targetPlanet	= $db->selectSingle($sql, array(
			':planetId'	=> $this->_fleet['fleet_end_id']
		));

		$sql				= 'SELECT name FROM %%PLANETS%% WHERE id = :planetId;';
		$senderPlanetName	= $db->selectSingle($sql, array(
			':planetId'	=> $this->_fleet['fleet_start_id']
		), 'name');

		$LNG			= $this->getLanguage($senderUser['lang']);

		$senderUser['factor']	= getFactors($senderUser, $this->_fleet['fleet_start_time']);
		$targetUser['factor']	= getFactors($targetUser, $this->_fleet['fleet_start_time']);

		$planetUpdater 						= new ResourceUpdate();
		list($targetUser, $targetPlanet)	= $planetUpdater->CalcResource($targetUser, $targetPlanet, true, $this->_fleet['fleet_start_time']);

		$sql	= 'SELECT * FROM %%FLEETS%% WHERE fleet_end_id = :planetId AND fleet_mission = 5 AND fleet_end_stay > :time;';

		$targetStayFleets	= $db->select($sql, array(
			':planetId'	=> $this->_fleet['fleet_end_id'],
			':time'		=> $this->_fleet['fleet_start_time'],
		));

		foreach($targetStayFleets as $fleetRow)
		{
			$fleetData	= FleetFunctions::unserialize($fleetRow['fleet_array']);
			foreach($fleetData as $shipId => $shipAmount)
			{
				$targetPlanet[$resource[$shipId]]	+= $shipAmount;
			}
		}
		
		$fleetAmount	= $this->_fleet['fleet_amount'] * (1 + $senderUser['factor']['SpyPower']);

		$senderSpyTech	= max($senderUser['spy_tech'], 1);
		$targetSpyTech	= max($targetUser['spy_tech'], 1);

		$techDifference	= abs($senderSpyTech - $targetSpyTech);
		$MinAmount		= ($senderSpyTech > $targetSpyTech ? -1 : 1) * pow($techDifference * SPY_DIFFENCE_FACTOR, 2);
		$SpyFleet		= $fleetAmount >= $MinAmount;
		$SpyDef			= $fleetAmount >= $MinAmount + 1 * SPY_VIEW_FACTOR;
		$SpyBuild		= $fleetAmount >= $MinAmount + 3 * SPY_VIEW_FACTOR;
		$SpyTechno		= $fleetAmount >= $MinAmount + 5 * SPY_VIEW_FACTOR;
			

		$classIDs[900]	= array_merge($reslist['resstype'][1], $reslist['resstype'][2]);
				
		if($SpyFleet) 
		{
			$classIDs[200]	= $reslist['fleet'];
		}
		
		if($SpyDef) 
		{
			$classIDs[400]	= array_merge($reslist['defense'], $reslist['missile']);
		}
		
		if($SpyBuild) 
		{
			$classIDs[0]	= $reslist['build'];
		}
		
		if($SpyTechno) 
		{
			$classIDs[100]	= $reslist['tech'];
		}
		
		$targetChance 	= mt_rand(0, min(($fleetAmount/4) * ($targetSpyTech / $senderSpyTech), 100));
		$spyChance  	= mt_rand(0, 100);
		$spyData		= array();

		foreach($classIDs as $classID => $elementIDs)
		{
			foreach($elementIDs as $elementID)
			{
				if(isset($targetUser[$resource[$elementID]]))
				{
					$spyData[$classID][$elementID]	= $targetUser[$resource[$elementID]];
				}
				else 
				{
					$spyData[$classID][$elementID]	= $targetPlanet[$resource[$elementID]];
				}
			}
		
			if($senderUser['spyMessagesMode'] == 1)
			{
				$spyData[$classID]	= array_filter($spyData[$classID]);
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
			'title'			=> sprintf($LNG['sys_mess_head'], $targetPlanet['name'], $targetPlanet['galaxy'], $targetPlanet['system'], $targetPlanet['planet'], _date($LNG['php_tdformat'], $this->_fleet['fleet_end_time'], $targetUser['timezone'], $LNG)),
		));
		
		$template->assign_vars(array(
			'LNG'			=> $LNG
		), false);
				
		$spyReport	= $template->fetch('shared.mission.spyReport.tpl');

		PlayerUtil::sendMessage($this->_fleet['fleet_owner'], 0, $LNG['sys_mess_qg'], 0, $LNG['sys_mess_spy_report'],
			$spyReport, $this->_fleet['fleet_start_time'], NULL, 1, $this->_fleet['fleet_universe']);
		
		$LNG			= $this->getLanguage($targetUser['lang']);
		$targetMessage  = $LNG['sys_mess_spy_ennemyfleet'] ." ". $senderPlanetName;

		if($this->_fleet['fleet_start_type'] == 3)
		{
			$targetMessage .= $LNG['sys_mess_spy_report_moon'].' ';
		}

		$text	= '<a href="game.php?page=galaxy&amp;galaxy=%1$s&amp;system=%2$s">[%1$s:%2$s:%3$s]</a> %7$s
		%8$s <a href="game.php?page=galaxy&amp;galaxy=%4$s&amp;system=%5$s">[%4$s:%5$s:%6$s]</a> %9$s';

		$targetMessage .= sprintf($text,
			$this->_fleet['fleet_start_galaxy'],
			$this->_fleet['fleet_start_system'],
			$this->_fleet['fleet_start_planet'],
			$this->_fleet['fleet_end_galaxy'],
			$this->_fleet['fleet_end_system'],
			$this->_fleet['fleet_end_planet'],
			$LNG['sys_mess_spy_seen_at'],
			$targetPlanet['name'],
			$LNG['sys_mess_spy_seen_at2']
		);


		PlayerUtil::sendMessage($this->_fleet['fleet_target_owner'], 0, $LNG['sys_mess_spy_control'], 0,
			$LNG['sys_mess_spy_activity'], $targetMessage, $this->_fleet['fleet_start_time'], NULL, 1, $this->_fleet['fleet_universe']);

		if ($targetChance >= $spyChance)
		{
			$config		= Config::get($this->_fleet['fleet_universe']);
			$whereCol	= $this->_fleet['fleet_end_type'] == 3 ? "id_luna" : "id";

			$sql		= 'UPDATE %%PLANETS%% SET
			der_metal	= der_metal + :metal,
			der_crystal = der_crystal + :crystal
			WHERE '.$whereCol.' = :planetId;';

			$db->update($sql, array(
				':metal'	=> $fleetAmount * $pricelist[210]['cost'][901] * $config->Fleet_Cdr / 100,
				':crystal'	=> $fleetAmount * $pricelist[210]['cost'][902] * $config->Fleet_Cdr / 100,
				':planetId'	=> $this->_fleet['fleet_end_id']
			));

			$this->KillFleet();
		}
		else
		{
			$this->setState(FLEET_RETURN);
			$this->SaveFleet();
		}
	}
	
	function EndStayEvent()
	{
		return;
	}
	
	function ReturnEvent()
	{	
		$this->RestoreFleet();
	}
}
