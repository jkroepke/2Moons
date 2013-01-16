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
 * @version 1.7.0 (2013-01-17)
 * @info $Id$
 * @link http://2moons.cc/
 */

class ShowOverviewPage extends AbstractPage 
{
	public static $requireModule = 0;

	function __construct() 
	{
		parent::__construct();
	}
	
	private function GetTeamspeakData()
	{
		global $CONF, $USER, $LNG;
		if (Config::get('ts_modon') == 0)
		{
			return false;
		}
		
		$GLOBALS['CACHE']->add('teamspeak', 'TeamspeakBuildCache');
		$tsInfo	= $GLOBALS['CACHE']->get('teamspeak', false);
		
		if(empty($tsInfo))
		{
			return array(
				'error'	=> $LNG['ov_teamspeak_not_online']
			);
		}
		
		switch(Config::get('ts_version'))
		{
			case 2:
				$url = 'teamspeak://%s:%s?nickname=%s';
			break;
			case 3:
				$url = 'ts3server://%s?port=%d&amp;nickname=%s&amp;password=%s';
			break;
		}
		
		return array(
			'url'		=> sprintf($url, Config::get('ts_server'), Config::get('ts_tcpport'), $USER['username'], $tsInfo['password']),
			'current'	=> $tsInfo['current'],
			'max'		=> $tsInfo['maxuser'],
			'error'		=> false,
		);
	}

	private function GetFleets() {
		global $USER, $PLANET;
		require_once(ROOT_PATH . 'includes/classes/class.FlyingFleetsTable.php');
		$fleetTableObj = new FlyingFleetsTable;
		$fleetTableObj->setUser($USER['id']);
		$fleetTableObj->setPlanet($PLANET['id']);
		return $fleetTableObj->renderTable();
	}
	
	function savePlanetAction()
	{
		global $USER, $PLANET;
		$password =	HTTP::_GP('password', '', true);
		if (!empty($password))
		{
			$IfFleets	= $GLOBALS['DATABASE']->getFirstCell("SELECT COUNT(*) FROM ".FLEETS." WHERE 
			(
				fleet_owner = ".$USER['id']."
				AND (
					fleet_start_id = ".$PLANET['id']." OR fleet_start_id = ".$PLANET['id_luna']."
				)
			) OR (
				fleet_target_owner = ".$USER['id']." 
				AND (
					fleet_end_id = ".$PLANET['id']." OR fleet_end_id = ".$PLANET['id_luna']."
				)
			);");
			
			if ($IfFleets > 0)
				exit(json_encode(array('message' => $LNG['ov_abandon_planet_not_possible'])));
			elseif ($USER['id_planet'] == $PLANET['id'])
				exit(json_encode(array('message' => $LNG['ov_principal_planet_cant_abanone'])));
			elseif (cryptPassword($password) != $USER['password'])
				exit(json_encode(array('message' => $LNG['ov_wrong_pass'])));
			else
			{
				if($PLANET['planet_type'] == 1) {
					$GLOBALS['DATABASE']->multi_query("UPDATE ".PLANETS." SET destruyed = ".(TIMESTAMP+ 86400)." WHERE id = ".$PLANET['id'].";DELETE FROM ".PLANETS." WHERE id = ".$PLANET['id_luna'].";");
				} else {
					$GLOBALS['DATABASE']->multi_query("UPDATE ".PLANETS." SET id_luna = 0 WHERE id_luna = ".$PLANET['id'].";DELETE FROM ".PLANETS." WHERE id = ".$PLANET['id'].";");
				}
				
				$PLANET['id']	= $USER['id_planet'];
				exit(json_encode(array('ok' => true, 'message' => $LNG['ov_planet_abandoned'])));
			}
		}
	}
		
	function show()
	{
		global $CONF, $LNG, $PLANET, $USER, $resource, $UNI;
		
		$AdminsOnline 	= array();
		$chatOnline 	= array();
		$AllPlanets		= array();
		$Moon 			= array();
		$RefLinks		= array();
		$Buildtime		= 0;
		
		foreach($USER['PLANETS'] as $ID => $CPLANET)
		{		
			if ($ID == $PLANET['id'] || $CPLANET['planet_type'] == 3)
				continue;

			if (!empty($CPLANET['b_building']) && $CPLANET['b_building'] > TIMESTAMP) {
				$Queue				= unserialize($CPLANET['b_building_id']);
				$BuildPlanet		= $LNG['tech'][$Queue[0][0]]." (".$Queue[0][1].")<br><span style=\"color:#7F7F7F;\">(".pretty_time($Queue[0][3] - TIMESTAMP).")</span>";
			} else {
				$BuildPlanet     = $LNG['ov_free'];
			}
			
			$AllPlanets[] = array(
				'id'	=> $CPLANET['id'],
				'name'	=> $CPLANET['name'],
				'image'	=> $CPLANET['image'],
				'build'	=> $BuildPlanet,
			);
		}
		
		if ($PLANET['id_luna'] != 0) {
			$Moon		= $GLOBALS['DATABASE']->getFirstRow("SELECT id, name FROM ".PLANETS." WHERE id = '".$PLANET['id_luna']."';");
		}
			
		if ($PLANET['b_building'] - TIMESTAMP > 0) {
			$Queue			= unserialize($PLANET['b_building_id']);
			$buildInfo['buildings']	= array(
				'id'		=> $Queue[0][0],
				'level'		=> $Queue[0][1],
				'timeleft'	=> $PLANET['b_building'] - TIMESTAMP,
				'time'		=> $PLANET['b_building'],
				'starttime'	=> pretty_time($PLANET['b_building'] - TIMESTAMP),
			);
		}
		else {
			$buildInfo['buildings']	= false;
		}
		
		/* As FR#206 (http://tracker.2moons.cc/view.php?id=206), i added the shipyard and research status here, but i add not them the template. */
		
		if (!empty($PLANET['b_hangar_id'])) {
			$Queue	= unserialize($PLANET['b_hangar_id']);
			$time	= BuildFunctions::getBuildingTime($USER, $PLANET, $Queue[0][0]) * $Queue[0][1];
			$buildInfo['fleet']	= array(
				'id'		=> $Queue[0][0],
				'level'		=> $Queue[0][1],
				'timeleft'	=> $time - $PLANET['b_hangar'],
				'time'		=> $time,
				'starttime'	=> pretty_time($time - $PLANET['b_hangar']),
			);
		}
		else {
			$buildInfo['fleet']	= false;
		}
		
		if ($USER['b_tech'] - TIMESTAMP > 0) {
			$Queue			= unserialize($USER['b_tech_queue']);
			$buildInfo['tech']	= array(
				'id'		=> $Queue[0][0],
				'level'		=> $Queue[0][1],
				'timeleft'	=> $USER['b_tech'] - TIMESTAMP,
				'time'		=> $USER['b_tech'],
				'starttime'	=> pretty_time($USER['b_tech'] - TIMESTAMP),
			);
		}
		else {
			$buildInfo['tech']	= false;
		}
		
		
		
		$OnlineAdmins 	= $GLOBALS['DATABASE']->query("SELECT id,username FROM ".USERS." WHERE universe = ".$UNI." AND onlinetime >= ".(TIMESTAMP-10*60)." AND authlevel > '".AUTH_USR."';");
		while ($AdminRow = $GLOBALS['DATABASE']->fetch_array($OnlineAdmins)) {
			$AdminsOnline[$AdminRow['id']]	= $AdminRow['username'];
		}
		$GLOBALS['DATABASE']->free_result($OnlineAdmins);

		
		$chatUsers 	= $GLOBALS['DATABASE']->query("SELECT userName FROM ".CHAT_ON." WHERE dateTime > DATE_SUB(NOW(), interval 2 MINUTE) AND channel = 0");
		while ($chatRow = $GLOBALS['DATABASE']->fetch_array($chatUsers)) {
			$chatOnline[]	= $chatRow['userName'];
		}

		$GLOBALS['DATABASE']->free_result($chatUsers);
		
		$this->tplObj->loadscript('overview.js');

		$Messages		= $USER['messages'];
		
		// Fehler: Wenn Spieler gelöscht werden, werden sie nicht mehr in der Tabelle angezeigt.
		$RefLinksRAW	= $GLOBALS['DATABASE']->query("SELECT u.id, u.username, s.total_points FROM ".USERS." as u LEFT JOIN ".STATPOINTS." as s ON s.id_owner = u.id AND s.stat_type = '1' WHERE ref_id = ".$USER['id'].";");
		
		if(Config::get('ref_active')) 
		{
			while ($RefRow = $GLOBALS['DATABASE']->fetch_array($RefLinksRAW)) {
				$RefLinks[$RefRow['id']]	= array(
					'username'	=> $RefRow['username'],
					'points'	=> min($RefRow['total_points'], Config::get('ref_minpoints'))
				);
			}
		}
		
		if($USER['total_rank'] == 0) {
			$rankInfo	= "-";
		} else {
			$rankInfo	= sprintf($LNG['ov_userrank_info'], pretty_number($USER['total_points']), $LNG['ov_place'], $USER['total_rank'], $USER['total_rank'], $LNG['ov_of'], Config::get('users_amount'));
		}
		
		$this->tplObj->assign_vars(array(
			'rankInfo'					=> $rankInfo,
			'is_news'					=> Config::get('OverviewNewsFrame'),
			'news'						=> makebr(Config::get('OverviewNewsText')),
			'planetname'				=> $PLANET['name'],
			'planetimage'				=> $PLANET['image'],
			'galaxy'					=> $PLANET['galaxy'],
			'system'					=> $PLANET['system'],
			'planet'					=> $PLANET['planet'],
			'planet_type'				=> $PLANET['planet_type'],
			'username'					=> $USER['username'],
			'userid'					=> $USER['id'],
			'buildInfo'					=> $buildInfo,
			'Moon'						=> $Moon,
			'fleets'					=> $this->GetFleets(),
			'AllPlanets'				=> $AllPlanets,
			'AdminsOnline'				=> $AdminsOnline,
			'teamspeakData'				=> $this->GetTeamspeakData(),
			'messages'					=> ($Messages > 0) ? (($Messages == 1) ? $LNG['ov_have_new_message'] : sprintf($LNG['ov_have_new_messages'], pretty_number($Messages))): false,
			'planet_diameter'			=> pretty_number($PLANET['diameter']),
			'planet_field_current' 		=> $PLANET['field_current'],
			'planet_field_max' 			=> CalculateMaxPlanetFields($PLANET),
			'planet_temp_min' 			=> $PLANET['temp_min'],
			'planet_temp_max' 			=> $PLANET['temp_max'],
			'ref_active'				=> Config::get('ref_active'),
			'ref_minpoints'				=> Config::get('ref_minpoints'),
			'RefLinks'					=> $RefLinks,
			'chatOnline'				=> $chatOnline,
			'servertime'				=> _date("M D d H:i:s", TIMESTAMP, $USER['timezone']),
			'path'						=> HTTP_PATH,
		));
		
		$this->display('page.overview.default.tpl');
	}
	
	function actions() 
	{
		global $LNG, $PLANET;

		$this->initTemplate();
		$this->setWindow('popup');
		
		$this->tplObj->loadscript('overview.actions.js');
		$this->tplObj->assign_vars(array(
			'ov_security_confirm'		=> sprintf($LNG['ov_security_confirm'], $PLANET['name'].' ['.$PLANET['galaxy'].':'.$PLANET['system'].':'.$PLANET['planet'].']'),
		));
		$this->display('page.overview.actions.tpl');
	}
	
	function rename() 
	{
		global $LNG, $PLANET;

		$newname        = HTTP::_GP('name', '', UTF8_SUPPORT);
		if (!empty($newname))
		{
			if (!CheckName($newname)) {
				$this->sendJSON(array('message' => $LNG['ov_newname_specialchar'], 'error' => true));
			} else {
				$GLOBALS['DATABASE']->query("UPDATE ".PLANETS." SET name = '".$GLOBALS['DATABASE']->sql_escape($newname)."' WHERE id = ".$PLANET['id'].";");
				$this->sendJSON(array('message' => $LNG['ov_newname_done'], 'error' => false));
			}
		}
	}
	
	function delete() 
	{
		global $LNG, $PLANET, $USER;
		$password	= HTTP::_GP('password', '', true);
		
		if (!empty($password))
		{
			$IfFleets	= $GLOBALS['DATABASE']->getFirstCell("SELECT COUNT(*) FROM ".FLEETS." WHERE 
			(
				fleet_owner = '".$USER['id']."'
				AND (
						fleet_start_id = ".$PLANET['id']." OR fleet_start_id = ".$PLANET['id_luna']."
				)
			) OR (
				fleet_target_owner = '".$USER['id']."' 
				AND (
						fleet_end_id = '".$PLANET['id']."' OR fleet_end_id = ".$PLANET['id_luna']."
				)
			);");

			if ($IfFleets > 0) {
				$this->sendJSON(array('message' => $LNG['ov_abandon_planet_not_possible']));
			} elseif ($USER['id_planet'] == $PLANET['id']) {
				$this->sendJSON(array('message' => $LNG['ov_principal_planet_cant_abanone']));
			} elseif (cryptPassword($password) != $USER['password']) {
				$this->sendJSON(array('message' => $LNG['ov_wrong_pass']));
			} else {
				if($PLANET['planet_type'] == 1) {
					$GLOBALS['DATABASE']->multi_query("UPDATE ".PLANETS." SET destruyed = ".(TIMESTAMP + 86400)." WHERE id = ".$PLANET['id'].";DELETE FROM ".PLANETS." WHERE id = ".$PLANET['id_luna'].";");
				} else {
					$GLOBALS['DATABASE']->multi_query("UPDATE ".PLANETS." SET id_luna = '0' WHERE id_luna = ".$PLANET['id'].";DELETE FROM ".PLANETS." WHERE id = ".$PLANET['id'].";");
				}
				
				$_SESSION['planet']     = $USER['id_planet'];
				$this->sendJSON(array('ok' => true, 'message' => $LNG['ov_planet_abandoned']));
			}
		}
	}
}