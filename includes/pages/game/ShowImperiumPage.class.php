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


class ShowImperiumPage extends AbstractPage
{
	public static $requireModule = MODULE_IMPERIUM;

	function __construct() 
	{
		parent::__construct();
	}

	function show()
	{
		global $LNG, $USER, $PLANET, $resource, $reslist;

		if($USER['planet_sort'] == 0) {
			$Order	= "id ";
		} elseif($USER['planet_sort'] == 1) {
			$Order	= "galaxy, system, planet, planet_type ";
		} elseif ($USER['planet_sort'] == 2) {
			$Order	= "name ";	
		}
		
		$Order .= ($USER['planet_sort_order'] == 1) ? "DESC" : "ASC" ;
		
		$PlanetsRAW = $GLOBALS['DATABASE']->query("SELECT * FROM ".PLANETS." WHERE id != ".$PLANET['id']." AND id_owner = '".$USER['id']."' AND destruyed = '0' ORDER BY ".$Order.";");
		$PLANETS	= array($PLANET);
		
		$PlanetRess	= new ResourceUpdate();
		
		while($CPLANET = $GLOBALS['DATABASE']->fetchArray($PlanetsRAW))
		{

			list($USER, $CPLANET)	= $PlanetRess->CalcResource($USER, $CPLANET, true);
			
			$PLANETS[]	= $CPLANET;
			unset($CPLANET);
		}

		$this->loadscript("trader.js");

        $planetList	= array();
			
		$elementIDs	= array_keys($GLOBALS['VARS']['ELEMENT']);

		foreach($PLANETS as $Planet)
		{
			$planetID									= $Planet['id'];
			$planetList['name'][$planetID]				= $Planet['name'];
			$planetList['image'][$planetID]				= $Planet['image'];
			
			$planetList['coords'][$planetID]['galaxy']	= $Planet['galaxy'];
			$planetList['coords'][$planetID]['system']	= $Planet['system'];
			$planetList['coords'][$planetID]['planet']	= $Planet['planet'];
			
			$planetList['field'][$planetID]['current']	= $Planet['field_current'];
			$planetList['field'][$planetID]['max']		= CalculateMaxPlanetFields($Planet);
			
			$planetList['energy_used'][$planetID]		= $Planet['energy'] + $Planet['energy_used'];
			
			foreach($elementIDs as $elementID)
			{
				if(elementHasFlag($elementID, ELEMENT_PLANET_RESOURCE) || elementHasFlag($elementID, ELEMENT_ENERGY))
				{
					$list	= 'resource';
				} elseif(elementHasFlag($elementID, ELEMENT_BUILD)) {
					$list	= 'build';
				} elseif(elementHasFlag($elementID, ELEMENT_FLEET)) {
					$list	= 'fleet';
				} elseif(elementHasFlag($elementID, ELEMENT_DEFENSIVE)) {
					$list	= 'defense';
				} else {
					continue;
				}
				
				$planetList[$list][$elementID][$planetID]	= $Planet[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']];
			}
		}
		
		foreach($GLOBALS['VARS']['LIST'][ELEMENT_TECH] as $elementID) {
			$planetList['tech'][$elementID]	= $USER[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']];
		}
		
		$this->assign(array(
			'colspan'		=> count($planetList) + 3,
			'planetList'	=> $planetList,
		));

		$this->render('page.empire.default.tpl');
	}
}
