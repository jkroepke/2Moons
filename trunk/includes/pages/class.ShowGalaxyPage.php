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
 * @version 1.4 (2011-07-10)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

include_once(ROOT_PATH . 'includes/classes/class.GalaxyRows.php');

class ShowGalaxyPage extends GalaxyRows
{
	private function ShowGalaxyRows($Galaxy, $System)
	{
		global $PLANET, $USER, $db, $LNG, $UNI, $CONF;
		$GalaxyPlanets		= $db->query("SELECT SQL_BIG_RESULT DISTINCT p.`planet`, p.`id`, p.`id_owner`, p.`name`, p.`image`, p.`last_update`, p.`diameter`, p.`temp_min`, p.`destruyed`, p.`der_metal`, p.`der_crystal`, p.`id_luna`, u.`id` as `userid`, u.`ally_id`, u.`username`, u.`onlinetime`, u.`urlaubs_modus`, u.`banaday`, s.`total_points`, s.`total_rank`, a.`id` as `allyid`, a.`ally_tag`, a.`ally_web`, a.`ally_members`, a.`ally_name`, allys.`total_rank` as `ally_rank` FROM ".PLANETS." p	LEFT JOIN ".USERS." u ON p.`id_owner` = u.`id` LEFT JOIN ".STATPOINTS." s ON s.`id_owner` = u.`id` AND s.`stat_type` = '1'	LEFT JOIN ".ALLIANCE." a ON a.`id` = u.`ally_id` LEFT JOIN ".STATPOINTS." allys ON allys.`stat_type` = '2' AND allys.`id_owner` = a.`id` WHERE p.`universe` = '".$UNI."' AND p.`galaxy` = '".$Galaxy."' AND p.`system` = '".$System."' AND p.`planet_type` = '1' ORDER BY p.`planet` ASC;");
		$COUNT				= $db->num_rows($GalaxyPlanets);
		while($GalaxyRowPlanets = $db->fetch_array($GalaxyPlanets))
		{
			$PlanetsInGalaxy[$GalaxyRowPlanets['planet']]	= $GalaxyRowPlanets;
		}

		$db->free_result($GalaxyPlanets);
		
		for ($Planet = 1; $Planet < (1 + $CONF['max_planets']); $Planet++)
		{
			if (!isset($PlanetsInGalaxy[$Planet])) 
			{
				$Result[$Planet]	= false;
				continue;
			}
			
			$GalaxyRowPlanet			= $PlanetsInGalaxy[$Planet];
			$GalaxyRowPlanet['galaxy']	= $Galaxy;
			$GalaxyRowPlanet['system']	= $System;
			
			if ($GalaxyRowPlanet['destruyed'] != 0)
			{
				$Result[$Planet]	= $LNG['gl_planet_destroyed'];
				continue;
			}
			
			if ($GalaxyRowPlanet['id_luna'] != 0)
			{
				$GalaxyRowMoon 				= $db->uniquequery("SELECT `destruyed`, `id`, `id_owner`, `diameter`, `name`, `temp_min`, `last_update` FROM ".PLANETS." WHERE `id` = '".$GalaxyRowPlanet['id_luna']."' AND planet_type='3';");
				$Result[$Planet]['moon']	= $this->GalaxyRowMoon($GalaxyRowMoon);
				
				$GalaxyRowPlanet['last_update'] = max($GalaxyRowPlanet['last_update'], $GalaxyRowMoon['last_update']);
			} else {
				$Result[$Planet]['moon']	= false;
			}
			
			$Result[$Planet]['user']		= $this->GalaxyRowUser($GalaxyRowPlanet);
			$Result[$Planet]['planet']		= $this->GalaxyRowPlanet($GalaxyRowPlanet);
			$Result[$Planet]['planetname']	= $this->GalaxyRowPlanetName ($GalaxyRowPlanet);
			
			$Result[$Planet]['action']	= $GalaxyRowPlanet['userid'] != $USER['id'] ? $this->GalaxyRowActions($GalaxyRowPlanet) : false;
			$Result[$Planet]['ally']	= $GalaxyRowPlanet['ally_id'] != 0 ? $this->GalaxyRowAlly($GalaxyRowPlanet) : false;
			$Result[$Planet]['derbis']	= $GalaxyRowPlanet['der_metal'] > 0 || $GalaxyRowPlanet['der_crystal'] > 0 ? $this->GalaxyRowDebris($GalaxyRowPlanet) : false;
											
		}
		return array('Result' => $Result, 'planetcount' => $COUNT);
	}

	public function __construct()
	{
		global $USER, $PLANET, $dpath, $resource, $LNG, $db, $reslist, $pricelist, $CONF;
		
		$template		= new template();	
		$template->loadscript('galaxy.js');	
		
		$maxfleet       = $db->num_rows($db->query("SELECT fleet_id FROM ".FLEETS." WHERE `fleet_owner` = '". $USER['id'] ."' AND `fleet_mission` != 10;"));
		
		$mode			= request_var('mode', 0);
		$galaxyLeft		= request_var('galaxyLeft', '');
		$galaxyRight	= request_var('galaxyRight', '');
		$systemLeft		= request_var('systemLeft', '');
		$systemRight	= request_var('systemRight', '');
		$galaxy			= min(max(abs(request_var('galaxy', $PLANET['galaxy'])), 1), $CONF['max_galaxy']);
		$system			= min(max(abs(request_var('system', $PLANET['system'])), 1), $CONF['max_system']);
		$planet			= min(max(abs(request_var('planet', $PLANET['planet'])), 1), $CONF['max_planets']);
		$current		= request_var('current', 0);
			
		if ($mode == 1)
		{
			if (!empty($galaxyLeft))
				$galaxy	= max($galaxy - 1, 1);
			elseif (!empty($galaxyRight))
				$galaxy	= min($galaxy + 1, $CONF['max_galaxy']);

			if (!empty($systemLeft))
				$system	= max($system - 1, 1);
			elseif (!empty($systemRight))
				$system	= min($system + 1, $CONF['max_system']);
		}

		if (!($galaxy == $PLANET['galaxy'] && $system == $PLANET['system']) && $mode != 0)
		{
			if($PLANET['deuterium'] < $CONF['deuterium_cost_galaxy'])
			{	
				$template->message($LNG['gl_no_deuterium_to_view_galaxy'], "game.php?page=galaxy&mode=0", 2);
				exit;
			}
			else
				$PLANET['deuterium']	-= $CONF['deuterium_cost_galaxy'];
		}
		
		$PlanetRess = new ResourceUpdate();
		$PlanetRess->CalcResource();
		$PlanetRess->SavePlanetToDB();
	
		unset($reslist['defense'][array_search(502, $reslist['defense'])]);
		$MissleSelector[0]	= $LNG['gl_all_defenses'];
		foreach($reslist['defense'] as $Element)
		{	
			$MissleSelector[$Element] = $LNG['tech'][$Element];
		}
		
		$Result	= $this->ShowGalaxyRows($galaxy, $system);

		$template->assign_vars(array(	
			'GalaxyRows'				=> $Result['Result'],
			'planetcount'				=> sprintf($LNG['gl_populed_planets'], $Result['planetcount']),
			'mode'						=> $mode,
			'galaxy'					=> $galaxy,
			'system'					=> $system,
			'planet'					=> $planet,
			'current'					=> $current,
			'currentmip'				=> pretty_number($PLANET[$resource[503]]),
			'maxfleetcount'				=> $maxfleet,
			'fleetmax'					=> ($USER['computer_tech'] + 1) + ($USER['rpg_commandant'] * $pricelist[611]['info']),
			'grecyclers'   				=> pretty_number($PLANET[$resource[219]]),
			'recyclers'   				=> pretty_number($PLANET[$resource[209]]),
			'spyprobes'   				=> pretty_number($PLANET[$resource[210]]),
			'missile_count'				=> sprintf($LNG['gl_missil_to_launch'], $PLANET[$resource[503]]),
			'spio_anz'					=> $USER['spio_anz'],
			'settings_fleetactions'		=> $USER['settings_fleetactions'],
			'current_galaxy'			=> $PLANET['galaxy'],
			'current_system'			=> $PLANET['system'],
			'current_planet'			=> $PLANET['planet'],
			'planet_type' 				=> $PLANET['planet_type'],
			'MissleSelector'			=> $MissleSelector,
		));
		
		$template->show('galaxy_overview.tpl');	
	}
}
?>