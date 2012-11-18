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

require_once(ROOT_PATH . 'includes/classes/class.FleetFunctions.php');
require_once(ROOT_PATH . 'includes/pages/game/class.ShowPhalanxPage.php');

class GalaxyRows
{
	private $Galaxy;
	private $System;
	private $galaxyData;
	private $galaxyRow;
	
	const PLANET_DESTROYED = false;
	
	function __construct() {
		
	}
	
	public function setGalaxy($Galaxy) {
		$this->Galaxy	= $Galaxy;
		return $this;
	}
	
	public function setSystem($System) {
		$this->System	= $System;
		return $this;
	}
	
	public function getGalaxyData()
	{
		global $UNI, $USER;

        $galaxyResult	= $GLOBALS['DATABASE']->query("SELECT SQL_BIG_RESULT DISTINCT
		p.galaxy, p.system, p.planet, p.id, p.id_owner, p.name, p.image, p.last_update, p.diameter, p.temp_min, p.destruyed, p.der_metal, p.der_crystal, p.id_luna, 
		u.id as userid, u.ally_id, u.username, u.onlinetime, u.urlaubs_modus, u.banaday, 
		m.id as m_id, m.diameter as m_diameter, m.name as m_name, m.temp_min as m_temp_min, m.last_update as m_last_update,
		s.total_points, s.total_rank, 
		a.id as allyid, a.ally_tag, a.ally_web, a.ally_members, a.ally_name, 
		allys.total_rank as ally_rank,
		COUNT(buddy.id) as buddy,
		d.level as diploLevel
		FROM ".PLANETS." p 
		LEFT JOIN ".USERS." u ON p.id_owner = u.id 
		LEFT JOIN ".PLANETS." m ON m.id = p.id_luna
		LEFT JOIN ".STATPOINTS." s ON s.id_owner = u.id AND s.stat_type = '1'	
		LEFT JOIN ".ALLIANCE." a ON a.id = u.ally_id 
		LEFT JOIN ".DIPLO." as d ON (d.owner_1 = ".$USER['ally_id']." AND d.owner_2 = a.id) OR (d.owner_1 = a.id AND d.owner_2 = ".$USER['ally_id'].") AND d.accept = 1
		LEFT JOIN ".STATPOINTS." allys ON allys.stat_type = '2' AND allys.id_owner = a.id
		LEFT JOIN ".BUDDY." buddy ON (buddy.sender = ".$USER['id']." AND buddy.owner = u.id ) OR (buddy.sender = u.id AND buddy.owner = ".$USER['id'].")
		WHERE p.universe = ".$UNI." AND p.galaxy = ".$this->Galaxy." AND p.system = ".$this->System." AND p.planet_type = '1'
		GROUP BY p.id;");

        while($this->galaxyRow = $GLOBALS['DATABASE']->fetch_array($galaxyResult))
		{
			if ($this->galaxyRow['destruyed'] != 0)
			{
                $this->galaxyData[$this->galaxyRow['planet']]	= self::PLANET_DESTROYED;
				continue;
			}
			
			$this->galaxyData[$this->galaxyRow['planet']]	= array();
			
			$this->isOwnPlanet();
			$this->setLastActivity();
			
			$this->getAllowedMissions();
			
			$this->getPlayerData();
			$this->getPlanetData();
			$this->getAllianceData();
			$this->getDebrisData();
			$this->getMoonData();
			$this->getActionButtons();
		}

		$GLOBALS['DATABASE']->free_result($galaxyResult);
		
		return $this->galaxyData;
	}
	
	protected function setLastActivity()
	{
		global $LNG;
		
		$lastActivity	= floor((TIMESTAMP - max($this->galaxyRow['last_update'], $this->galaxyRow['m_last_update'])) / 60);
		
		if ($lastActivity < 4) {
			$this->galaxyData[$this->galaxyRow['planet']]['lastActivity']	= $LNG['gl_activity'];
		} elseif($lastActivity < 15) {
			$this->galaxyData[$this->galaxyRow['planet']]['lastActivity']	= sprintf($LNG['gl_activity_inactive'], $lastActivity);
		} else {
			$this->galaxyData[$this->galaxyRow['planet']]['lastActivity']	= '';
		}
	}
	
	protected function isOwnPlanet()
	{
		global $USER;
		
		$this->galaxyData[$this->galaxyRow['planet']]['ownPlanet']	= $this->galaxyRow['id_owner'] == $USER['id'];
	}
	
	protected function getAllowedMissions()
	{
		global $PLANET, $resource;
		
		$this->galaxyData[$this->galaxyRow['planet']]['missions']	= array(
			1	=> !$this->galaxyData[$this->galaxyRow['planet']]['ownPlanet'] && isModulAvalible(MODULE_MISSION_ATTACK),
			3	=> isModulAvalible(MODULE_MISSION_TRANSPORT),
			4	=> $this->galaxyData[$this->galaxyRow['planet']]['ownPlanet'] && isModulAvalible(MODULE_MISSION_STATION),
			5	=> !$this->galaxyData[$this->galaxyRow['planet']]['ownPlanet'] && isModulAvalible(MODULE_MISSION_HOLD),
			6	=> !$this->galaxyData[$this->galaxyRow['planet']]['ownPlanet'] && isModulAvalible(MODULE_MISSION_SPY),
			8	=> isModulAvalible(MODULE_MISSION_RECYCLE),
			9	=> !$this->galaxyData[$this->galaxyRow['planet']]['ownPlanet'] && $PLANET[$resource[214]] > 0 && isModulAvalible(MODULE_MISSION_DESTROY),
			10	=> !$this->galaxyData[$this->galaxyRow['planet']]['ownPlanet'] && $PLANET[$resource[503]] > 0 && isModulAvalible(MODULE_MISSION_ATTACK) && isModulAvalible(MODULE_MISSILEATTACK) && $this->inMissileRange(),
		);
	}

	protected function inMissileRange()
	{
		global $USER, $PLANET, $resource;
		
		if ($this->galaxyRow['galaxy'] != $PLANET['galaxy'])
			return false;
		
		$Range		= FleetFunctions::GetMissileRange($USER[$resource[117]]);
		$systemMin	= $PLANET['system'] - $Range;
		$systemMax	= $PLANET['system'] + $Range;
		
		return $this->galaxyRow['system'] >= $systemMin && $this->galaxyRow['system'] <= $systemMax;
	}
	
	protected function getActionButtons()
	{
		global $USER;
        if($this->galaxyData[$this->galaxyRow['planet']]['ownPlanet']) {
            $this->galaxyData[$this->galaxyRow['planet']]['action'] = false;
        } else {
            $this->galaxyData[$this->galaxyRow['planet']]['action'] = array(
                'esp'		=> $USER['settings_esp'] == 1 && $this->galaxyData[$this->galaxyRow['planet']]['missions'][6],
                'message'	=> $USER['settings_wri'] == 1 && isModulAvalible(MODULE_MESSAGES),
                'buddy'		=> $USER['settings_bud'] == 1 && isModulAvalible(MODULE_BUDDYLIST) && $this->galaxyRow['buddy'] == 0,
                'missle'	=> $USER['settings_mis'] == 1 && $this->galaxyData[$this->galaxyRow['planet']]['missions'][10],
            );
        }
	}

	protected function getPlayerData()
	{
		global $USER, $LNG;

		$IsNoobProtec		= CheckNoobProtec($USER, $this->galaxyRow, $this->galaxyRow);
		$Class		 		= array();

		if ($this->galaxyRow['banaday'] > TIMESTAMP && $this->galaxyRow['urlaubs_modus'] == 1)
		{
			$Class		 	= array('vacation', 'banned');
		}
		elseif ($this->galaxyRow['banaday'] > TIMESTAMP)
		{
			$Class		 	= array('banned');
		}
		elseif ($this->galaxyRow['urlaubs_modus'] == 1)
		{
			$Class		 	= array('vacation');
		}
		elseif ($this->galaxyRow['onlinetime'] < TIMESTAMP - INACTIVE_LONG)
		{
			$Class		 	= array('inactive', 'longinactive');
		}
		elseif ($this->galaxyRow['onlinetime'] < TIMESTAMP - INACTIVE)
		{
			$Class		 	= array('inactive');
		}
		elseif ($IsNoobProtec['NoobPlayer'])
		{
			$Class		 	= array('noob');
		}
		elseif ($IsNoobProtec['StrongPlayer'])
		{
			$Class		 	= array('strong');
		}
		
        $this->galaxyData[$this->galaxyRow['planet']]['user']	= array(
			'id'			=> $this->galaxyRow['userid'],
			'username'		=> htmlspecialchars($this->galaxyRow['username'], ENT_QUOTES, "UTF-8"),
			'rank'			=> $this->galaxyRow['total_rank'],
			'points'		=> pretty_number($this->galaxyRow['total_points']),
			'playerrank'	=> sprintf($LNG['gl_in_the_rank'], htmlspecialchars($this->galaxyRow['username'],ENT_QUOTES,"UTF-8"), $this->galaxyRow['total_rank']),
			'class'			=> $Class,
			'isBuddy'		=> $this->galaxyRow['buddy'] == 0,
		);
	}
	
	protected function getAllianceData()
	{
		global $USER, $LNG;
		if(empty($this->galaxyRow['allyid'])) {
			$this->galaxyData[$this->galaxyRow['planet']]['alliance']	= false;
		} else {
			$Class	= array();
			switch($this->galaxyRow['diploLevel'])
			{
				case 1:
				case 2:
					$Class	= array('member');
				break;
				case 4:
					$Class	= array('friend');
				break;
				case 5:
					$Class	= array('enemy');
				break;
			}
			
			if($USER['ally_id'] == $this->galaxyRow['ally_id'])
			{
				$Class	= array('member');
			}
			
			$this->galaxyData[$this->galaxyRow['planet']]['alliance']	= array(
				'id'		=> $this->galaxyRow['allyid'],
				'name'		=> htmlspecialchars($this->galaxyRow['ally_name'], ENT_QUOTES, "UTF-8"),
				'member'	=> sprintf(($this->galaxyRow['ally_members'] == 1) ? $LNG['gl_member_add'] : $LNG['gl_member'], $this->galaxyRow['ally_members']),
				'web'		=> $this->galaxyRow['ally_web'],
				'tag'		=> $this->galaxyRow['ally_tag'],
				'rank'		=> $this->galaxyRow['ally_rank'],
				'class'		=> $Class,
			);
		}
	}

	protected function getDebrisData()
	{
		$total		= $this->galaxyRow['der_metal'] + $this->galaxyRow['der_crystal'];
		if($total == 0) {
			$this->galaxyData[$this->galaxyRow['planet']]['debris']	= false;
		} else {
			$this->galaxyData[$this->galaxyRow['planet']]['debris']	= array(
				'metal'			=> $this->galaxyRow['der_metal'],
				'crystal'		=> $this->galaxyRow['der_crystal'],
			);
		}
	}

	protected function getMoonData()
	{		
		if(!isset($this->galaxyRow['m_id'])) {
			$this->galaxyData[$this->galaxyRow['planet']]['moon']	= false;
		} else {
			$this->galaxyData[$this->galaxyRow['planet']]['moon']	= array(
				'id'		=> $this->galaxyRow['m_id'],
				'name'		=> htmlspecialchars($this->galaxyRow['m_name'], ENT_QUOTES, "UTF-8"),
				'temp_min'	=> $this->galaxyRow['m_temp_min'], 
				'diameter'	=> $this->galaxyRow['m_diameter'],
			);
		}
	}

	protected function getPlanetData()
	{
		$this->galaxyData[$this->galaxyRow['planet']]['planet']	= array(
			'id'			=> $this->galaxyRow['id'],
			'name'			=> htmlspecialchars($this->galaxyRow['name'], ENT_QUOTES, "UTF-8"),
			'image'			=> $this->galaxyRow['image'],
			'phalanx'		=> isModulAvalible(MODULE_PHALANX) && ShowPhalanxPage::allowPhalanx($this->galaxyRow['galaxy'], $this->galaxyRow['system']),
		);
	}
}