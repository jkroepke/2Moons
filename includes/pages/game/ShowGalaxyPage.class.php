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

require_once('includes/classes/class.GalaxyRows.php');

class ShowGalaxyPage extends AbstractGamePage
{
    public static $requireModule = MODULE_RESEARCH;

	function __construct() 
	{
		parent::__construct();
	}
	
	public function show()
	{
		global $USER, $PLANET, $LNG;

		$config			= Config::get();

		$action 		= HTTP::_GP('action', '');
		$galaxyLeft		= HTTP::_GP('galaxyLeft', '');
		$galaxyRight	= HTTP::_GP('galaxyRight', '');
		$systemLeft		= HTTP::_GP('systemLeft', '');
		$systemRight	= HTTP::_GP('systemRight', '');
		$galaxy			= min(max(HTTP::_GP('galaxy', (int) $PLANET['galaxy']), 1), $config->max_galaxy);
		$system			= min(max(HTTP::_GP('system', (int) $PLANET['system']), 1), $config->max_system);
		$planet			= min(max(HTTP::_GP('planet', (int) $PLANET['planet']), 1), $config->max_planets);
		$type			= HTTP::_GP('type', 1);
		$current		= HTTP::_GP('current', 0);

		$missileSelector	= array();
		$missileList	= array();
		$recycleList	= array();
		$spyList		= array();


        if (!empty($galaxyLeft))
            $galaxy	= max($galaxy - 1, 1);
        elseif (!empty($galaxyRight))
            $galaxy	= min($galaxy + 1, $config->max_galaxy);

        if (!empty($systemLeft))
            $system	= max($system - 1, 1);
        elseif (!empty($systemRight))
            $system	= min($system + 1, $config->max_system);

		if ($galaxy != $PLANET['galaxy'] || $system != $PLANET['system'])
		{
			if($PLANET['deuterium'] < $config->deuterium_cost_galaxy)
			{	
				$this->printMessage($LNG['gl_no_deuterium_to_view_galaxy'], array(array(
					'label'	=> $LNG['sys_back'],
					'url'	=> 'game.php?page=galaxy'
				)));
			} else {
				$PLANET['deuterium']	-= $config->deuterium_cost_galaxy;
            }
		}

		if($action == 'sendMissle')
		{
			$targetDefensive    = array_keys(Vars::getElements(Vars::CLASS_DEFENSE) + Vars::getElements(Vars::CLASS_MISSILE, Vars::FLAG_ATTACK_MISSILE));
			$missileSelector[0]	= $LNG['gl_all_defenses'];

			foreach($targetDefensive as $elementId)
			{
				$missileSelector[$elementId] = $LNG['tech'][$elementId];
			}
		}

		foreach(Vars::getElements(Vars::CLASS_MISSILE, Vars::FLAG_ATTACK_MISSILE) as $elementId => $elementObj)
		{
			$missileList[$elementId]	= $PLANET[$elementObj->name];
		}

		foreach(Vars::getElements(Vars::CLASS_FLEET, Vars::FLAG_COLLECT) as $elementId => $elementObj)
		{
			$recycleList[$elementId]	= $PLANET[$elementObj->name];
		}

		foreach(Vars::getElements(Vars::CLASS_FLEET, Vars::FLAG_SPY) as $elementId => $elementObj)
		{
			$spyList[$elementId]	= $PLANET[$elementObj->name];
		}

		$sql	= 'SELECT total_points
		FROM %%STATPOINTS%%
		WHERE id_owner = :userId AND stat_type = :statType';

		$USER	+= Database::get()->selectSingle($sql, array(
			':userId'	=> $USER['id'],
			':statType'	=> 1
		));

		$galaxyRows	= new GalaxyRows;
		$galaxyRows->setGalaxy($galaxy);
		$galaxyRows->setSystem($system);
		$Result	= $galaxyRows->getGalaxyData();

        $this->tplObj->loadscript('galaxy.js');
        $this->assign(array(
			'GalaxyRows'				=> $Result,
			'planetcount'				=> sprintf($LNG['gl_populed_planets'], count($Result)),
			'action'					=> $action,
			'galaxy'					=> $galaxy,
			'system'					=> $system,
			'planet'					=> $planet,
			'type'						=> $type,
			'current'					=> $current,
			'maxfleetcount'				=> FleetUtil::GetCurrentFleets($USER['id']),
			'fleetmax'					=> FleetUtil::GetMaxFleetSlots($USER),
			'currentmip'				=> $recycleList,
			'grecyclers'   				=> $missileList,
			'recyclers'   				=> $spyList,
			'settings_fleetactions'		=> $USER['settings_fleetactions'],
			'current_galaxy'			=> $PLANET['galaxy'],
			'current_system'			=> $PLANET['system'],
			'current_planet'			=> $PLANET['planet'],
			'planet_type' 				=> $PLANET['planet_type'],
            'max_planets'               => $config->max_planets,
			'missileSelector'			=> $missileSelector,
			'ShortStatus'				=> array(
				'vacation'					=> $LNG['gl_short_vacation'],
				'banned'					=> $LNG['gl_short_ban'],
				'inactive'					=> $LNG['gl_short_inactive'],
				'longinactive'				=> $LNG['gl_short_long_inactive'],
				'noob'						=> $LNG['gl_short_newbie'],
				'strong'					=> $LNG['gl_short_strong'],
				'enemy'						=> $LNG['gl_short_enemy'],
				'friend'					=> $LNG['gl_short_friend'],
				'member'					=> $LNG['gl_short_member'],
			),
		));
		
		$this->display('page.galaxy.default.tpl');
	}
}