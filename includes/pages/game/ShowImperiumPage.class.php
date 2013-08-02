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


class ShowImperiumPage extends AbstractGamePage
{
	public static $requireModule = MODULE_IMPERIUM;

	function __construct() 
	{
		parent::__construct();
	}

	function show()
	{
		global $USER, $PLANET;

        $db = Database::get();

		switch($USER['planet_sort'])
        {
            case 1:
                $orderBy	= 'galaxy, system, planet, planet_type';
            break;
            case 2:
                $orderBy    = 'name';
            break;
            default:
                $orderBy    = 'id';
            break;
		}

		$orderBy .= ' '.($USER['planet_sort_order'] == 1) ? 'DESC' : 'ASC';

        $sql = "SELECT * FROM %%PLANETS%% WHERE id != :planetID AND id_owner = :userID AND destruyed = '0' ORDER BY :order;";
        $PlanetsRAW = $db->select($sql, array(
            ':planetID' => $PLANET['id'],
            ':userID'   => $USER['id'],
            ':order'    => $orderBy,
        ));

        $PLANETS	= array($PLANET);
		
		$PlanetRess	= new Economy();
		
		foreach ($PlanetsRAW as $CPLANET)
		{
            list($USER, $CPLANET)	= $PlanetRess->CalcResource($USER, $CPLANET, true);
			
			$PLANETS[]	= $CPLANET;
			unset($CPLANET);
		}

        $planetList	= array();

        $buildElements          = Vars::getElements(Vars::CLASS_BUILDING);
        $techElements           = Vars::getElements(Vars::CLASS_TECH);
        $fleetElements          = Vars::getElements(Vars::CLASS_FLEET);
        $defenseElements        = Vars::getElements(Vars::CLASS_DEFENSE);
        $resourcePlanetElements = Vars::getElements(NULL, Vars::FLAG_RESOURCE_PLANET);
        $energyElements         = Vars::getElements(NULL, Vars::FLAG_ENERGY);

		foreach($PLANETS as $Planet)
		{
			$planetList['name'][$Planet['id']]					= $Planet['name'];
			$planetList['image'][$Planet['id']]					= $Planet['image'];
			
			$planetList['coords'][$Planet['id']]['galaxy']		= $Planet['galaxy'];
			$planetList['coords'][$Planet['id']]['system']		= $Planet['system'];
			$planetList['coords'][$Planet['id']]['planet']		= $Planet['planet'];
			
			$planetList['field'][$Planet['id']]['current']		= $Planet['field_current'];
			$planetList['field'][$Planet['id']]['max']			= CalculateMaxPlanetFields($Planet);

            foreach($resourcePlanetElements as $elementId => $elementObj)
            {
                $planetList['resource'][$elementId][$Planet['id']]	= $Planet[$elementObj->name];
            }

            foreach($energyElements as $elementId => $elementObj)
            {
				$planetList['resource'][$elementId][$Planet['id']]	= $Planet[$elementObj->name] + $Planet[$elementObj->name.'_used'];
			}

            foreach($buildElements as $elementId => $elementObj)
            {
				$planetList['build'][$elementId][$Planet['id']]	    = $Planet[$elementObj->name];
			}

            foreach($fleetElements as $elementId => $elementObj)
            {
				$planetList['fleet'][$elementId][$Planet['id']]	    = $Planet[$elementObj->name];
			}
			
			foreach($defenseElements as $elementId => $elementObj)
            {
				$planetList['defense'][$elementId][$Planet['id']]	= $Planet[$elementObj->name];
			}
		}

        foreach($techElements as $elementId => $elementObj)
        {
			$planetList['tech'][$elementId]	= $USER[$elementObj->name];
		}
		
		$this->assign(array(
			'colspan'		=> count($PLANETS) + 2,
			'planetList'	=> $planetList,
		));

		$this->display('page.empire.default.tpl');
	}
}