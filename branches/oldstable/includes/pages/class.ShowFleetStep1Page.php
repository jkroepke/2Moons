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

require_once(ROOT_PATH . 'includes/classes/class.FleetFunctions.php');

class ShowFleetStep1Page
{
	public function show()
	{
		global $USER, $PLANET, $resource, $pricelist, $reslist, $db, $LNG;
		
		$targetGalaxy 			= request_var('galaxy', $PLANET['galaxy']);
		$targetSystem 			= request_var('system', $PLANET['system']);
		$targetPlanet			= request_var('planet', $PLANET['planet']);
		$targetType 			= request_var('type', $PLANET['planet_type']);
		
		$mission				= request_var('target_mission', 0);
		
		$PlanetRess = new ResourceUpdate();
		$PlanetRess->CalcResource();
		$PlanetRess->SavePlanetToDB();
		
		$Fleet		= array();
		$FleetRoom	= 0;
		foreach ($reslist['fleet'] as $id => $ShipID)
		{
			$amount		 				= request_outofint('ship'.$ShipID, 0.0);
			
			if ($amount < 1 || $ShipID == 212) continue;

			$Fleet[$ShipID]				= $amount;
			$FleetRoom			   	   += $pricelist[$ShipID]['capacity'] * $amount;
		}
		
		
		if (empty($Fleet))
			FleetFunctions::GotoFleetPage();
	
		$FleetData	= array(
			'fleetroom'			=> floattostring($FleetRoom),
			'gamespeed'			=> FleetFunctions::GetGameSpeedFactor(),
			'fleetspeedfactor'	=> 1 - $USER['factor']['shipspeed'],
			'planet'			=> array('galaxy' => $PLANET['galaxy'], 'system' => $PLANET['system'], 'planet' => $PLANET['planet'], 'planet_type' => $PLANET['planet_type']),
			'maxspeed'			=> FleetFunctions::GetFleetMaxSpeed($Fleet, $USER),
			'ships'				=> FleetFunctions::GetFleetShipInfo($Fleet, $USER),
		);
		
		$token		= getRandomString();
		
		$_SESSION['fleet'][$token]	= array(
			'fleet'		=> $Fleet,
			'fleetRoom'	=> $FleetRoom,
		);

		$template	= new template();
		$template->loadscript('flotten.js');
		$template->execscript('updateVars();FleetTime();window.setInterval("FleetTime()", 1000);');
		$template->assign_vars(array(
			'token'			=> $token,
			'mission'		=> $mission,
			'shoutcutList'	=> $this->GetUserShotcut(),
			'colonyList' 	=> $this->GetColonyList(),
			'ACSList' 		=> $this->GetAvalibleACS(),
			'galaxy' 		=> $targetGalaxy,
			'system' 		=> $targetSystem,
			'planet' 		=> $targetPlanet,
			'type'			=> $targetType,
			'speedSelect'	=> FleetFunctions::$allowedSpeed,
			'typeSelect'   	=> array(1 => $LNG['type_planet'][1], 2 => $LNG['type_planet'][2], 3 => $LNG['type_planet'][3]),
			'fleetdata'		=> $FleetData,
		));
		
		$template->show('fleet1_table.tpl');
	}
	
	function GetColonyList()
	{
		global $PLANET, $USER;
		
		$ColonyList	= array();
		
		foreach($USER['PLANETS'] as $CurPlanetID => $CurPlanet)
		{
			if ($PLANET['id'] == $CurPlanet['id'])
				continue;
			
			$ColonyList[] = array(
				'name'		=> $CurPlanet['name'],
				'galaxy'	=> $CurPlanet['galaxy'],
				'system'	=> $CurPlanet['system'],
				'planet'	=> $CurPlanet['planet'],
				'type'		=> $CurPlanet['planet_type'],
			);	
		}
			
		return $ColonyList;
	}
	
	function GetUserShotcut()
	{
		global $USER;
		$Shoutcut 		= unserialize($USER['fleet_shortcut']);
		
		if (empty($Shoutcut) || !isModulAvalible(MODUL_SHOTCUTS))
			return array();
			
		$ShortCutList	= array();

		foreach ($Shoutcut as $ShortCutRow)
		{						
			$ShortCutList[] = array(
				'name'		=> $ShortCutRow[0],
				'galaxy'	=> $ShortCutRow[1],
				'system'	=> $ShortCutRow[2],
				'planet'	=> $ShortCutRow[3],
				'type'		=> $ShortCutRow[4],
			);
		}
		
		return $ShortCutList;
	}
	
	function GetAvalibleACS()
	{
		global $USER, $db, $CONF;
		
		$ACSResult 	= $db->query("SELECT acs.id, acs.name, planet.galaxy, planet.system, planet.planet, planet.planet_type 
		FROM ".USERS_ACS."
		INNER JOIN ".AKS." acs ON acsID = acs.id
		INNER JOIN ".PLANETS." planet ON planet.id = acs.target 
		WHERE userID = ".$USER['id']." AND ".$CONF['max_fleets_per_acs']." > (SELECT COUNT(*) FROM ".FLEETS." WHERE fleet_group = acsID);");
		
		$ACSList	= array();
		
		while($ACSRow = $db->fetch_array($ACSResult))
			$ACSList[]	= $ACSRow;
		
		$db->free_result($ACSResult);
		
		return $ACSList;
	}
}
?>