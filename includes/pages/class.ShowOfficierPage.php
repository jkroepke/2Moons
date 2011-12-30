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

class ShowOfficierPage
{
	public function UpdateExtra($Element)
	{
		global $PLANET, $USER, $resource, $pricelist, $db;
		
		$costRessources		= BuildFunctions::getElementPrice($USER, $PLANET, $Element);
			
		if (!BuildFunctions::isElementBuyable($USER, $PLANET, $Element, $costRessources)) {
			return;
		}
			
		$USER[$resource[$Element]]	= max($USER[$resource[$Element]], TIMESTAMP) + $pricelist[$Element]['time'];
			
		if(isset($costRessources[901])) { $PLANET[$resource[901]]	-= $costRessources[901]; }
		if(isset($costRessources[902])) { $PLANET[$resource[902]]	-= $costRessources[902]; }
		if(isset($costRessources[903])) { $PLANET[$resource[903]]	-= $costRessources[903]; }
		if(isset($costRessources[921])) { $USER[$resource[921]]		-= $costRessources[921]; }
		
		$db->query("UPDATE ".USERS." SET
				   ".$resource[$Element]." = ".$USER[$resource[$Element]]."
				   WHERE
				   id = ".$USER['id'].";");
	}

	public function UpdateOfficier($Element)
	{
		global $USER, $PLANET, $reslist, $resource, $db, $pricelist;
		
		$costRessources		= BuildFunctions::getElementPrice($USER, $PLANET, $Element);
			
		if (!BuildFunctions::isTechnologieAccessible($USER, $PLANET, $Element) 
			|| !BuildFunctions::isElementBuyable($USER, $PLANET, $Element, $costRessources) 
			|| $pricelist[$Element]['max'] <= $USER[$resource[$Element]]) {
			return;
		}
		
		$USER[$resource[$Element]]	+= 1;
		
		if(isset($costRessources[901])) { $PLANET[$resource[901]]	-= $costRessources[901]; }
		if(isset($costRessources[902])) { $PLANET[$resource[902]]	-= $costRessources[902]; }
		if(isset($costRessources[903])) { $PLANET[$resource[903]]	-= $costRessources[903]; }
		if(isset($costRessources[921])) { $USER[$resource[921]]		-= $costRessources[921]; }
		
		$db->query("UPDATE ".USERS." SET
				   ".$resource[$Element]." = ".$USER[$resource[$Element]]."
				   WHERE
				   id = ".$USER['id'].";");
	}
	
	public function show()
	{
		global $USER, $CONF, $PLANET, $resource, $reslist, $LNG, $db, $pricelist;
		
		$Offi	  = request_var('offi', 0);
		$Extra	  = request_var('extra', 0);
		
		$PlanetRess = new ResourceUpdate();
		$PlanetRess->CalcResource();
		
		if ($_SERVER['REQUEST_METHOD'] === 'POST' && $USER['urlaubs_modus'] == 0)
		{
			if(!empty($Offi) && isModulAvalible(MODUL_OFFICIER) && in_array($Offi, $reslist['officier'])) {
				$this->UpdateOfficier($Offi);
			} elseif(!empty($Extra) && isModulAvalible(MODUL_DMEXTRAS) && in_array($Extra, $reslist['dmfunc'])){
				$this->UpdateExtra($Extra);
			}
		}
		
		$PlanetRess->SavePlanetToDB();
		
		$template	= new template();
		$template->loadscript('officier.js');		
		
		$darkmatterList	= array();
		$officierList	= array();
		
		if(isModulAvalible(MODUL_DMEXTRAS)) 
		{
			foreach($reslist['dmfunc'] as $Element)
			{
				if($USER[$resource[$Element]] > TIMESTAMP) {
					$template->execscript("GetOfficerTime(".$Element.", ".($USER[$resource[$Element]] - TIMESTAMP).");");
				}
			
				$costRessources		= BuildFunctions::getElementPrice($USER, $PLANET, $Element);
				$buyable			= BuildFunctions::isElementBuyable($USER, $PLANET, $Element, $costRessources);
				$costOverflow		= BuildFunctions::getRestPrice($USER, $PLANET, $Element, $costRessources);

				$darkmatterList[$Element]	= array(
					'timeLeft'			=> max($USER[$resource[$Element]] - TIMESTAMP, 0),
					'costRessources'	=> $costRessources,
					'buyable'			=> $buyable,
					'bonus'				=> $pricelist[$Element]['add'] * 100,
					'time'				=> $pricelist[$Element]['time'],
					'costOverflow'		=> $costOverflow,
					'description'		=> sprintf($LNG['res']['descriptions'][$Element], $pricelist[$Element]['add'] * 100)
				);
			}
		}
		
		if(isModulAvalible(MODUL_OFFICIER))
		{
			foreach($reslist['officier'] as $Element)
			{
				if (!BuildFunctions::isTechnologieAccessible($USER, $PLANET, $Element))
					continue;
					
				$costRessources		= BuildFunctions::getElementPrice($USER, $PLANET, $Element);
				$buyable			= BuildFunctions::isElementBuyable($USER, $PLANET, $Element, $costRessources);
				$costOverflow		= BuildFunctions::getRestPrice($USER, $PLANET, $Element, $costRessources);

				if($pricelist[$Element]['info']) {
					$description = sprintf($LNG['info'][$Element]['description'], is_int($pricelist[$Element]['info']) ? $pricelist[$Element]['info'] : $pricelist[$Element]['info'] * 100);
				} else {
					$description = sprintf($LNG['info'][$Element]['description']);
				}
				
				$officierList[$Element]	= array(
					'level'				=> $USER[$resource[$Element]],
					'maxLevel'			=> $pricelist[$Element]['max'],
					'costRessources'	=> $costRessources,
					'buyable'			=> $buyable,
					'bonus'				=> $pricelist[$Element]['info'] * 100,
					'costOverflow'		=> $costOverflow,
					'description'		=> $description,
				);
			}
		}
		
		$template->assign_vars(array(	
			'officierList'		=> $officierList,
			'darkmatterList'	=> $darkmatterList,
			'of_dm_trade'		=> sprintf($LNG['of_dm_trade'], $LNG['tech'][921]),
		));
		
		$template->show("officier_overview.tpl");
	}
}
?>