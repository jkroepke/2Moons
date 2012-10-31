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
 * @version 1.7.0 (2012-12-31)
 * @info $Id$
 * @link http://2moons.cc/
 */

class MissionCaseSpy extends MissionFunctions
{
		
	function __construct($Fleet)
	{
		$this->_fleet	= $Fleet;
	}
	
	function TargetEvent()
	{
		global $pricelist, $reslist, $resource, $LANG;		
		$ownUser		= $GLOBALS['DATABASE']->getFirstRow("SELECT * FROM ".USERS." WHERE id = ".$this->_fleet['fleet_owner'].";");
		$ownPlanet		= $GLOBALS['DATABASE']->getFirstRow("SELECT name, galaxy, system, planet FROM ".PLANETS." WHERE id = ".$this->_fleet['fleet_start_id'].";");
		$ownSpyLvl		= max($ownUser['spy_tech'], 1);
		
		$LNG			= $LANG->GetUserLang($ownUser['lang']);
		
		$targetUser		= $GLOBALS['DATABASE']->getFirstRow("SELECT * FROM ".USERS." WHERE id = ".$this->_fleet['fleet_target_owner'].";");
		$targetPlanet	= $GLOBALS['DATABASE']->getFirstRow("SELECT * FROM ".PLANETS." WHERE id = ".$this->_fleet['fleet_end_id'].";");
		
		$targetSpyLvl	= max($targetUser['spy_tech'], 1);
		
		$targetUser['factor']				= getFactors($targetUser, 'basic', $this->_fleet['fleet_start_time']);
		$PlanetRess 						= new ResourceUpdate();
		list($targetUser, $targetPlanet)	= $PlanetRess->CalcResource($targetUser, $targetPlanet, true, $this->_fleet['fleet_start_time']);

		$targetStayFleets	= $GLOBALS['DATABASE']->query("SELECT * FROM ".FLEETS." WHERE fleet_end_id = ".$this->_fleet['fleet_end_id']." AND fleet_mission = 5 AND fleet_end_stay > ".$this->_fleet['fleet_start_time'].";");
		
		while($fleetRow = $GLOBALS['DATABASE']->fetch_array($targetStayFleets))
		{
			$temp = explode(';', $fleetRow['fleet_array']);
			foreach ($temp as $temp2)
			{
				$temp2 = explode(',', $temp2);
				if (!isset($targetPlanet[$resource[$temp2[0]]]))
				{
					$targetPlanet[$resource[$temp2[0]]] = 0;
				}
				
				$targetPlanet[$resource[$temp2[0]]] += $temp2[1];
			}
		}
		
		$GLOBALS['DATABASE']->free_result($targetStayFleets);
		
		$fleetAmount	= $this->_fleet['fleet_amount'];
		
		$Diffence		= abs($ownSpyLvl - $targetSpyLvl);
		$MinAmount		= $ownSpyLvl > $targetSpyLvl ? -1 * pow($Diffence, 2) : pow($Diffence, 2);
		$SpyFleet		= $fleetAmount >= $MinAmount;
		$SpyDef			= $fleetAmount >= $MinAmount + 1;
		$SpyBuild		= $fleetAmount >= $MinAmount + 3;
		$SpyTechno		= $fleetAmount >= $MinAmount + 5;
			

		$classIDs[900]	= array_merge($reslist['resstype'][1], $reslist['resstype'][2]);
				
		if($SpyFleet) 
		{
			$classIDs[200]	= $reslist['fleet'];
		}
		
		if($SpyDef) 
		{
			$classIDs[400]	= $reslist['defense'];
		}
		
		if($SpyBuild) 
		{
			$classIDs[0]	= $reslist['build'];
		}
		
		if($SpyTechno) 
		{
			$classIDs[100]	= $reslist['tech'];
		}
		
		$targetChance 	= mt_rand(0, min(($fleetAmount/4) * ($targetSpyLvl / $ownSpyLvl), 100));
		$spyChance  	= mt_rand(0, 100);
		
		foreach($classIDs as $classID => $elementIDs)
		{
			foreach($elementIDs as $elementID)
			{
				if($classID == 100)
				{
					$spyData[$classID][$elementID]	= $targetUser[$resource[$elementID]];
				}
				else 
				{
					$spyData[$classID][$elementID]	= $targetPlanet[$resource[$elementID]];
				}
			}
		
			if($ownUser['spyMessagesMode'] == 1)
			{
				$spyData[$classID]	= array_filter($spyData[$classID]);
			}
		}
		
		// I'm use template class here, because i want to exclude HTML in PHP.
		
		require_once(ROOT_PATH.'includes/classes/class.template.php');
		
		$template	= new template;
		
		$template->caching		= true;
		$template->compile_id	= $ownUser['lang'];
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
				
		$spyRaport	= $template->fetch('shared.mission.spyraport.tpl');

		SendSimpleMessage($this->_fleet['fleet_owner'], 0, $this->_fleet['fleet_start_time'], 0, $LNG['sys_mess_qg'], $LNG['sys_mess_spy_report'], $spyRaport);
		
		$LNG		    = $LANG->GetUserLang($targetUser['lang']);
		$targetMessage  = $LNG['sys_mess_spy_ennemyfleet'] ." ". $ownPlanet['name'];

		if($this->_fleet['fleet_start_type'] == 3)
			$targetMessage .= $LNG['sys_mess_spy_report_moon'].' ';

		$targetMessage .= '<a href="game.php?page=galaxy&amp;galaxy='.$ownPlanet["galaxy"].'&amp;system='.$ownPlanet["system"].'">'.
						  '['.$ownPlanet['galaxy'].':'.$ownPlanet['system'].':'.$ownPlanet['planet'].']</a> '.
						  $LNG['sys_mess_spy_seen_at'].' '.$targetPlanet['name'].
						  ' ['. $targetPlanet['galaxy'].':'.$targetPlanet['system'].':'.$targetPlanet['planet'].'] '.$LNG['sys_mess_spy_seen_at2'].'.';

		SendSimpleMessage($this->_fleet['fleet_target_owner'], 0, $this->_fleet['fleet_start_time'], 0, $LNG['sys_mess_spy_control'], $LNG['sys_mess_spy_activity'], $targetMessage);

		if ($targetChance >= $spyChance)
		{
			$CONF		= getConfig($this->_fleet['fleet_universe']);
			$WhereCol	= $this->_fleet['fleet_end_type'] == 3 ? "id_luna" : "id";		
			$GLOBALS['DATABASE']->query("UPDATE ".PLANETS." SET
			der_metal = der_metal + ".($fleetAmount * $pricelist[210]['cost'][901] * ($CONF['Fleet_Cdr'] / 100)).", 
			der_crystal = der_crystal + ".($fleetAmount * $pricelist[210]['cost'][902] * ($CONF['Fleet_Cdr'] / 100))." 
			WHERE ".$WhereCol." = ".$this->_fleet['fleet_end_id'].";");
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

?>