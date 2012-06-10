<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan
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
 * @author Jan <info@2moons.cc>
 * @copyright 2006 Perberos <ugamela@perberos.com.ar> (UGamela)
 * @copyright 2008 Chlorel (XNova)
 * @copyright 2009 Lucky (XGProyecto)
 * @copyright 2012 Jan <info@2moons.cc> (2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 2.0.$Revision$ (2012-11-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

class ShowFleetStep1Page extends AbstractPage
{
	public static $requireModule = MODULE_FLEET_TABLE;

	function __construct() 
	{
		parent::__construct();
	}
	
	public function show()
	{
		global $USER, $PLANET, $LNG;
		
		$targetGalaxy 			= HTTP::_GP('galaxy', $PLANET['galaxy']);
		$targetSystem 			= HTTP::_GP('system', $PLANET['system']);
		$targetPlanet			= HTTP::_GP('planet', $PLANET['planet']);
		$targetType 			= HTTP::_GP('type', $PLANET['planet_type']);
		
		$mission				= HTTP::_GP('target_mission', 0);
				
		$fleet		= array();
		$fleetRoom	= 0;
		
		foreach($GLOBALS['VARS']['LIST'][ELEMENT_FLEET] as $elementID)
		{
			$amount	= max(0, round(HTTP::_GP('ship'.$elementID, 0.0, 0.0)));
			
			if ($amount < 1) {
				continue;
			}
			
			$fleet[$elementID]	= $amount;
		}
		
		if (empty($fleet))
		{
			FleetUtil::GotoFleetPage();
		}
		
		$fleetSpeed	= FleetUtil::GetFleetMaxSpeed($fleet, $USER);
				
		if (empty($fleetSpeed))
		{
			FleetUtil::GotoFleetPage();
		}		
		
		$fleetRoom	= FleetUtil::GetFleetRoom($fleet);		
		$fleetRoom	*= 1 + $USER['factor']['ShipStorage'];
		
		$fleetData	= array(
			'fleetroom'			=> floattostring($fleetRoom),
			'gamespeed'			=> FleetUtil::GetGameSpeedFactor(),
			'fleetspeedfactor'	=> 1 - $USER['factor']['FlyTime'],
			'planet'			=> array('galaxy' => $PLANET['galaxy'], 'system' => $PLANET['system'], 'planet' => $PLANET['planet'], 'planet_type' => $PLANET['planet_type']),
			'maxspeed'			=> $fleetSpeed,
			'ships'				=> FleetUtil::GetFleetShipInfo($fleet, $USER),
		);
		
		$token		= getRandomString();
		
		$_SESSION['fleet'][$token]	= array(
			'time'		=> TIMESTAMP,
			'fleet'		=> $fleet,
			'fleetRoom'	=> $fleetRoom,
		);

		$shortcutList	= $this->GetUserShotcut();
		$colonyList 	= $this->GetColonyList();
		$ACSList 		= $this->GetAvalibleACS();
		
		if(!empty($shortcutList)) 
		{
			$shortcutAmount	= max(array_keys($shortcutList));
		}
		else
		{
			$shortcutAmount	= 0;
		}
		
		$this->loadscript('flotten.js');
		$this->execscript('updateVars();FleetTime();window.setInterval("FleetTime()", 1000);');
		$this->assign(array(
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
			'speedSelect'	=> FleetUtil::$allowedSpeed,
			'typeSelect'   	=> array(1 => $LNG['type_planet'][1], 2 => $LNG['type_planet'][2], 3 => $LNG['type_planet'][3]),
			'fleetdata'		=> $fleetData,
		));
		
		$this->render('page.fleetStep1.default.tpl');
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
				name = '".$GLOBALS['DATABASE']->escape($Data['name'])."', 
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
					SET name = '".$GLOBALS['DATABASE']->escape($Data['name'])."', 
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

		while($ShortcutRow = $GLOBALS['DATABASE']->fetchArray($ShortcutResult)) {						
			$ShortcutList[$ShortcutRow['shortcutID']] = $ShortcutRow;
		}
		
		$GLOBALS['DATABASE']->free_result($ShortcutResult);
		
		return $ShortcutList;
	}
	
	private function GetAvalibleACS()
	{
		global $USER, $uniConfig;
		
		$ACSResult 	= $GLOBALS['DATABASE']->query("SELECT acs.id, acs.name, planet.galaxy, planet.system, planet.planet, planet.planet_type 
		FROM ".USERS_ACS."
		INNER JOIN ".AKS." acs ON acsID = acs.id
		INNER JOIN ".PLANETS." planet ON planet.id = acs.target 
		WHERE userID = ".$USER['id']." AND ".$uniConfig['fleetMaxUsersPerACS']." > (SELECT COUNT(*) FROM ".FLEETS." WHERE fleet_group = acsID);");
		
		$ACSList	= array();
		
		while($ACSRow = $GLOBALS['DATABASE']->fetchArray($ACSResult)) {
			$ACSList[]	= $ACSRow;
		}
		
		$GLOBALS['DATABASE']->free_result($ACSResult);
		
		return $ACSList;
	}
	
	function checkTarget()
	{
		global $PLANET, $LNG, $UNI, $USER, $uniConfig, $gameConfig;
		$TargetGalaxy 					= HTTP::_GP('galaxy', 0);
		$TargetSystem 					= HTTP::_GP('system', 0);
		$TargetPlanet					= HTTP::_GP('planet', 0);
		$TargetPlanettype 				= HTTP::_GP('planet_type', 1);
	
		if($TargetGalaxy == $PLANET['galaxy'] && $TargetSystem == $PLANET['system'] && $TargetPlanet == $PLANET['planet'] && $TargetPlanettype == $PLANET['planet_type'])
		{
			$this->sendJSON($LNG['fl_error_same_planet']);
		}
		
		if ($TargetPlanet != $uniConfig['planetMaxPosition'] + 1) {
			$Data	= $GLOBALS['DATABASE']->getFirstRow("SELECT u.id, u.urlaubs_modus, u.user_lastip, u.authattack, p.destruyed, p.der_metal, p.der_crystal, p.destruyed 
														 FROM ".PLANETS." as p
														 INNER JOIN ".USERS." as u ON u.id = p.id_owner
														 WHERE p.universe = ".$UNI."
														 AND p.galaxy = ".$TargetGalaxy."
														 AND p.system = ".$TargetSystem."
														 AND p.planet = ".$TargetPlanet."
														 AND p.planet_type = '".(($TargetPlanettype == 2) ? 1 : $TargetPlanettype)."';");

			if ($TargetPlanettype == 3 && !isset($Data))
			{
				$this->sendJSON($LNG['fl_error_no_moon']);
			}
			elseif ($TargetPlanettype != 2 && $Data['urlaubs_modus'])
			{
				$this->sendJSON($LNG['fl_in_vacation_player']);
			}
			elseif ($gameConfig['adminProtection'] == 1 && $Data['authattack'] > $USER['authlevel'])
			{
				$this->sendJSON($LNG['fl_admins_cannot_be_attacked']);
			}
			elseif ($Data['destruyed'] != 0)
			{
				$this->sendJSON($LNG['fl_error_not_avalible']);
			}
			elseif ($TargetPlanettype == 2 && $Data['der_metal'] == 0 && $Data['der_crystal'] == 0)
			{
				$this->sendJSON($LNG['fl_error_empty_derbis']);
			}
			elseif ($USER['id'] != $Data['id'] && $USER['user_lastip'] == $Data['user_lastip'])
			{
				$this->sendJSON($LNG['fl_multi_alarm']);
			}
		} else {
			$activeExpedition	= FleetUtil::GetCurrentFleets($USER['id'], 15);

			if ($activeExpedition >= FleetUtil::getExpeditionLimit($USER))
			{
				$this->sendJSON($LNG['fl_no_expedition_slot']);
			}
		}
		
		$this->sendJSON(true);	
	}
}
