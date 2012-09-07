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

class ShowFleetStep1Page extends AbstractPage
{
	public static $requireModule = MODULE_FLEET_TABLE;

	function __construct() 
	{
		parent::__construct();
	}
	
	public function show()
	{
		global $USER, $PLANET, $resource, $pricelist, $reslist, $LNG;
		
		$targetGalaxy 			= HTTP::_GP('galaxy', $PLANET['galaxy']);
		$targetSystem 			= HTTP::_GP('system', $PLANET['system']);
		$targetPlanet			= HTTP::_GP('planet', $PLANET['planet']);
		$targetType 			= HTTP::_GP('type', $PLANET['planet_type']);
		
		$mission				= HTTP::_GP('target_mission', 0);
				
		$Fleet		= array();
		$FleetRoom	= 0;
		foreach ($reslist['fleet'] as $id => $ShipID)
		{
			$amount		 				= max(0, round(HTTP::_GP('ship'.$ShipID, 0.0, 0.0)));
			
			if ($amount < 1 || $ShipID == 212) continue;

			$Fleet[$ShipID]				= $amount;
			$FleetRoom			   	   += $pricelist[$ShipID]['capacity'] * $amount;
		}
		
		$FleetRoom	*= 1 + $USER['factor']['ShipStorage'];
		
		if (empty($Fleet))
			FleetFunctions::GotoFleetPage();
	
		$FleetData	= array(
			'fleetroom'			=> floattostring($FleetRoom),
			'gamespeed'			=> FleetFunctions::GetGameSpeedFactor(),
			'fleetspeedfactor'	=> 1 - $USER['factor']['FlyTime'],
			'planet'			=> array('galaxy' => $PLANET['galaxy'], 'system' => $PLANET['system'], 'planet' => $PLANET['planet'], 'planet_type' => $PLANET['planet_type']),
			'maxspeed'			=> FleetFunctions::GetFleetMaxSpeed($Fleet, $USER),
			'ships'				=> FleetFunctions::GetFleetShipInfo($Fleet, $USER),
		);
		
		$token		= getRandomString();
		
		$_SESSION['fleet'][$token]	= array(
			'time'		=> TIMESTAMP,
			'fleet'		=> $Fleet,
			'fleetRoom'	=> $FleetRoom,
		);

		$shortcutList	= $this->GetUserShotcut();
		$colonyList 	= $this->GetColonyList();
		$ACSList 		= $this->GetAvalibleACS();
		
		if(!empty($shortcutList)) {
			$shortcutAmount	= max(array_keys($shortcutList));
		} else {
			$shortcutAmount	= 0;
		}
		
		$this->tplObj->loadscript('flotten.js');
		$this->tplObj->execscript('updateVars();FleetTime();window.setInterval("FleetTime()", 1000);');
		$this->tplObj->assign_vars(array(
			'token'			=> $token,
			'mission'		=> $mission,
			'shortcutList'	=> $shortcutList,
			'shortcutMax'	=> $shortcutAmount,
			'colonyList' 	=> $colonyList,
			'ACSList' 		=> $ACSList,
			'galaxy' 		=> $targetGalaxy,
			'system' 		=> $targetSystem,
			'planet' 		=> $targetPlanet,
			'type'			=> $targetType,
			'speedSelect'	=> FleetFunctions::$allowedSpeed,
			'typeSelect'   	=> array(1 => $LNG['type_planet'][1], 2 => $LNG['type_planet'][2], 3 => $LNG['type_planet'][3]),
			'fleetdata'		=> $FleetData,
		));
		
		$this->display('page.fleetStep1.default.tpl');
	}
	
	public function saveShortcuts()
	{
		global $USER, $LNG;
		
		if(!isset($_REQUEST['shortcut'])) {
			$this->sendJSON($LNG['fl_shortcut_saved']);
		}
		
		$Shortcut		= array();
		$ShortcutData	= $_REQUEST['shortcut'];
		$ShortcutUser	= $this->GetUserShotcut();
		foreach($ShortcutData as $ID => $Data) {
			if(!isset($ShortcutUser[$ID])) {
				if(empty($Data['name']) || empty($Data['galaxy']) || empty($Data['system']) || empty($Data['planet'])) {
					continue;
				}
				
				$GLOBALS['DATABASE']->query("INSERT INTO ".SHORTCUTS." 
				SET ownerID = ".$USER['id'].",
				name = '".$GLOBALS['DATABASE']->sql_escape($Data['name'])."', 
				galaxy = ".((int) $Data['galaxy']).", 
				system = ".((int) $Data['system']).",
				planet = ".((int) $Data['planet']).",
				type = ".((int) $Data['type']).";");
			} elseif(empty($Data['name'])) {
				$GLOBALS['DATABASE']->query("DELETE FROM ".SHORTCUTS." WHERE shortcutID = ".((int) $ID)." AND ownerID = ".$USER['id'].";");
			} else {
				$Data['ownerID']		= $USER['id'];
				$Data['shortcutID']		= $ID;
				if($Data != $ShortcutUser[$ID]) {
					$GLOBALS['DATABASE']->query("UPDATE ".SHORTCUTS." 
					SET name = '".$GLOBALS['DATABASE']->sql_escape($Data['name'])."', 
					galaxy = ".((int) $Data['galaxy']).", 
					system = ".((int) $Data['system']).",
					planet = ".((int) $Data['planet']).",
					type = ".((int) $Data['type'])."
					WHERE shortcutID = ".((int) $ID)." AND ownerID = ".$USER['id'].";");
				}				
			}
		}
		
		$this->sendJSON($LNG['fl_shortcut_saved']);
	}
	
	private function GetColonyList()
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
	
	private function GetUserShotcut()
	{
		global $USER;
		
		if (!isModulAvalible(MODULE_SHORTCUTS))
			return array();
			
		$ShortcutResult	= $GLOBALS['DATABASE']->query("SELECT * FROM ".SHORTCUTS." WHERE ownerID = ".$USER['id'].";");
			
		$ShortcutList	= array();

		while($ShortcutRow = $GLOBALS['DATABASE']->fetch_array($ShortcutResult)) {						
			$ShortcutList[$ShortcutRow['shortcutID']] = $ShortcutRow;
		}
		
		$GLOBALS['DATABASE']->free_result($ShortcutResult);
		
		return $ShortcutList;
	}
	
	private function GetAvalibleACS()
	{
		global $USER, $CONF;
		
		$ACSResult 	= $GLOBALS['DATABASE']->query("SELECT acs.id, acs.name, planet.galaxy, planet.system, planet.planet, planet.planet_type 
		FROM ".USERS_ACS."
		INNER JOIN ".AKS." acs ON acsID = acs.id
		INNER JOIN ".PLANETS." planet ON planet.id = acs.target 
		WHERE userID = ".$USER['id']." AND ".$CONF['max_fleets_per_acs']." > (SELECT COUNT(*) FROM ".FLEETS." WHERE fleet_group = acsID);");
		
		$ACSList	= array();
		
		while($ACSRow = $GLOBALS['DATABASE']->fetch_array($ACSResult)) {
			$ACSList[]	= $ACSRow;
		}
		
		$GLOBALS['DATABASE']->free_result($ACSResult);
		
		return $ACSList;
	}
	
	function checkTarget()
	{
		global $PLANET, $LNG, $UNI, $CONF, $USER, $resource;
		$TargetGalaxy 					= HTTP::_GP('galaxy', 0);
		$TargetSystem 					= HTTP::_GP('system', 0);
		$TargetPlanet					= HTTP::_GP('planet', 0);
		$TargetPlanettype 				= HTTP::_GP('planet_type', 1);
	
		if($TargetGalaxy == $PLANET['galaxy'] && $TargetSystem == $PLANET['system'] && $TargetPlanet == $PLANET['planet'] && $TargetPlanettype == $PLANET['planet_type'])
		{
			exit($LNG['fl_send_error'][3]);
		}
		
		if ($TargetPlanet != $CONF['max_planets'] + 1) {
			$Data	= $GLOBALS['DATABASE']->uniquequery("SELECT u.id, u.urlaubs_modus, u.user_lastip, u.authattack, p.destruyed, p.der_metal, p.der_crystal, p.destruyed FROM ".USERS." as u, ".PLANETS." as p WHERE p.universe = ".$UNI." AND p.galaxy = ".$TargetGalaxy." AND p.system = ".$TargetSystem." AND p.planet = ".$TargetPlanet."  AND p.planet_type = '".(($TargetPlanettype == 2) ? 1 : $TargetPlanettype)."' AND u.id = p.id_owner;");

			if ($TargetPlanettype == 3 && !isset($Data))
				exit($LNG['fl_error_no_moon']);
			elseif ($TargetPlanettype != 2 && $Data['urlaubs_modus'])
				exit($LNG['fl_in_vacation_player']);
			elseif ($CONF['adm_attack'] == 1 && $Data['authattack'] > $USER['authlevel'])
				exit($LNG['fl_admins_cannot_be_attacked']);
			elseif ($Data['destruyed'] != 0)
				exit($LNG['fl_error_not_avalible']);
			elseif($TargetPlanettype == 2 && $Data['der_metal'] == 0 && $Data['der_crystal'] == 0)
				exit($LNG['fl_error_empty_derbis']);
			elseif(ENABLE_MULTIALERT && $USER['id'] != $Data['id'] && $USER['user_lastip'] == $Data['user_lastip'] && $GLOBALS['DATABASE']->countquery("SELECT (SELECT COUNT(*) FROM ".MULTI." WHERE userID = ".$USER['id'].") + (SELECT COUNT(*) FROM ".MULTI." WHERE userID = ".$Data['id'].")") != 2)
			{
				exit($LNG['fl_multi_alarm']);
			}
		} else {
			if ($USER[$resource[124]] == 0)
				exit($LNG['fl_send_error'][10]);
			
			$ActualFleets = $GLOBALS['DATABASE']->countquery("SELECT COUNT(*) FROM ".FLEETS." WHERE fleet_owner = ".$USER['id']." AND fleet_mission = '15';");

			if ($ActualFleets['state'] >= floor(sqrt($USER[$resource[124]])))
				exit($LNG['fl_send_error'][9]);
		}
		exit('OK');	
	}
}
?>