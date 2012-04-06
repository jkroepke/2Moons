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
 * @version 1.7.0 (2012-05-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

class ShowGalaxyPage extends AbstractPage
{
    public static $requireModule = MODULE_RESEARCH;

	function __construct() 
	{
		parent::__construct();
	}
	
	public function show()
	{
		global $USER, $PLANET, $LNG, $uniConfig;

		$action 		= HTTP::_GP('action', '');
		$galaxyLeft		= HTTP::_GP('galaxyLeft', '');
		$galaxyRight	= HTTP::_GP('galaxyRight', '');
		$systemLeft		= HTTP::_GP('systemLeft', '');
		$systemRight	= HTTP::_GP('systemRight', '');
		$galaxy			= min(max(HTTP::_GP('galaxy', $PLANET['galaxy']), 1), $uniConfig['planetMaxGalaxy']);
		$system			= min(max(HTTP::_GP('system', $PLANET['system']), 1), $uniConfig['planetMaxSystem']);
		$planet			= min(max(HTTP::_GP('planet', $PLANET['planet']), 1), $uniConfig['planetMaxPosition']);
		$type			= HTTP::_GP('type', 1);
		$current		= HTTP::_GP('current', 0);
			
        if (!empty($galaxyLeft))
            $galaxy	= max($galaxy - 1, 1);
        elseif (!empty($galaxyRight))
            $galaxy	= min($galaxy + 1, $uniConfig['planetMaxGalaxy']);

        if (!empty($systemLeft))
            $system	= max($system - 1, 1);
        elseif (!empty($systemRight))
            $system	= min($system + 1, $uniConfig['planetMaxSystem']);

		if ($galaxy != $PLANET['galaxy'] || $system != $PLANET['system'])
		{
			if($PLANET['deuterium'] < $uniConfig['galaxyNavigationDeuterium'])
			{	
				$this->printMessage($LNG['gl_no_deuterium_to_view_galaxy'], array("game.php?page=galaxy", 3));
				exit;
			} else {
				$PLANET['deuterium']	-= $uniConfig['galaxyNavigationDeuterium'];
            }
		}

        $targetDefensive    = array_diff($GLOBALS['VARS']['LIST'][ELEMENT_DEFENSIVE], array(502, 503));
		$MissleSelector[0]	= $LNG['gl_all_defenses'];
		foreach($targetDefensive as $Element)
		{	
			$MissleSelector[$Element] = $LNG['tech'][$Element];
		}
				
		$galaxyRows	= new GalaxyRows;
		$galaxyRows->setGalaxy($galaxy);
		$galaxyRows->setSystem($system);
		$Result	= $galaxyRows->getGalaxyData();

        $this->loadscript('galaxy.js');
        $this->assign_vars(array(
			'GalaxyRows'				=> $Result,
			'planetcount'				=> sprintf($LNG['gl_populed_planets'], count($Result)),
			'action'					=> $action,
			'galaxy'					=> $galaxy,
			'system'					=> $system,
			'planet'					=> $planet,
			'type'						=> $type,
			'current'					=> $current,
			'maxfleetcount'				=> FleetFunctions::GetCurrentFleets($USER['id']),
			'fleetmax'					=> FleetFunctions::GetMaxFleetSlots($USER),
			'currentmip'				=> $PLANET[$GLOBALS['VARS']['ELEMENT'][503]['name']],
			'grecyclers'   				=> $PLANET[$GLOBALS['VARS']['ELEMENT'][219]['name']],
			'recyclers'   				=> $PLANET[$GLOBALS['VARS']['ELEMENT'][209]['name']],
			'spyprobes'   				=> $PLANET[$GLOBALS['VARS']['ELEMENT'][210]['name']],
			'missile_count'				=> sprintf($LNG['gl_missil_to_launch'], $PLANET[$GLOBALS['VARS']['ELEMENT'][503]['name']]),
			'spyShips'					=> array(210 => $USER['spio_anz']),
			'settings_fleetactions'		=> $USER['settings_fleetactions'],
			'current_galaxy'			=> $PLANET['galaxy'],
			'current_system'			=> $PLANET['system'],
			'current_planet'			=> $PLANET['planet'],
			'planet_type' 				=> $PLANET['planet_type'],
            'max_planets'               => $uniConfig['planetMaxPosition'],
			'MissleSelector'			=> $MissleSelector,
			'ShortStatus'				=> array(
				'vacation'					=> $LNG['gl_short_vacation'],
				'banned'					=> $LNG['gl_short_ban'],
				'inactive'					=> $LNG['gl_short_inactive'],
				'longinactive'				=> $LNG['gl_short_long_inactive'],
				'noob'						=> $LNG['gl_short_newbie'],
				'strong'					=> $LNG['gl_short_strong'],
			),
		));
		
		$this->render('page.galaxy.default.tpl');
	}
}
