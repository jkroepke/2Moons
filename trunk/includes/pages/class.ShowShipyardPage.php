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
 * @version 1.3.5 (2011-04-22)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */
 
class ShowShipyardPage
{
	private function GetMaxConstructibleElements($Element)
	{
		global $pricelist, $PLANET, $USER, $reslist;

		$Cost	= $pricelist[$Element];
		if (!empty($Cost['metal']))
			$MAX[]	= floor($PLANET['metal'] / $Cost['metal']);

		if (!empty($Cost['crystal']))
			$MAX[]	= floor($PLANET['crystal'] / $Cost['crystal']);

		if (!empty($Cost['deuterium']))
			$MAX[]	= floor($PLANET['deuterium'] / $Cost['deuterium']);
			
		if (!empty($Cost['darkmatter']))
			$MAX[]	= floor($USER['darkmatter'] / $Cost['darkmatter']);

		if (!empty($Cost['energy_max']))
			$MAX[]	= floor($PLANET['energy_max'] / $Cost['energy_max']);
		
		if (in_array($Element, $reslist['one']))
			$MAX[]	= 1;		
		
		return min($MAX);
	}
	private function GetMaxConstructibleRockets($Missiles)
	{
		global $resource, $PLANET, $USER, $CONF;

		$BuildArray  	  	= !empty($PLANET['b_hangar_id']) ? unserialize($PLANET['b_hangar_id']) : array();
		$MaxMissiles   		= $PLANET[$resource[44]] * 5 * max($CONF['silo_factor'], 1);

		foreach($BuildArray as $ElementArray) {
			if(isset($Missiles[$ElementArray[0]]))
				$Missiles[$ElementArray[0]] += $ElementArray[1];
		}
		
		$ActuMissiles  = $Missiles[502] + (2 * $Missiles[503]);
		$MissilesSpace = max(0, $MaxMissiles - $ActuMissiles);
		return array(
			502	=> $MissilesSpace,
			503	=> floor($MissilesSpace / 2),
		);
	}

	private function GetElementRessources($Element, $Count)
	{
		global $pricelist;

		$ResType['metal']     	= ($pricelist[$Element]['metal']     * $Count);
		$ResType['crystal']  	= ($pricelist[$Element]['crystal']   * $Count);
		$ResType['deuterium'] 	= ($pricelist[$Element]['deuterium'] * $Count);
		$ResType['darkmatter'] 	= ($pricelist[$Element]['darkmatter'] * $Count);

		return $ResType;
	}
	
	private function CancelAuftr($CancelArray) 
	{
		global $USER, $PLANET;
		$ElementQueue = unserialize($PLANET['b_hangar_id']);
		foreach ($CancelArray as $ID => $Auftr)
		{
			if($Auftr == 0)
				$PLANET['b_hangar']	= 0;
				
			$ElementQ	= $ElementQueue[$Auftr];
			$Element	= $ElementQ[0];
			$Count		= $ElementQ[1];
			
			if ($Element == 214 && $USER['rpg_destructeur'] == 1)
				$Count = $Count / 2;
			
			$Resses					= $this->GetElementRessources($Element, $Count);
			$PLANET['metal']		+= $Resses['metal']			* 0.6;
			$PLANET['crystal']		+= $Resses['crystal']		* 0.6;
			$PLANET['deuterium']	+= $Resses['deuterium']		* 0.6;
			$USER['darkmatter']		+= $Resses['darkmatter']	* 0.6;
			unset($ElementQueue[$Auftr]);
		}
		$PLANET['b_hangar_id']	= serialize(array_values($ElementQueue));
		FirePHP::getInstance(true)->log("Queue(Hanger): ".$PLANET['b_hangar_id']);
	}
	
	private function GetRestPrice($Element, $Factor = true)
	{
		global $USER, $PLANET, $pricelist, $resource, $LNG;

		if ($Factor)
			$level = isset($PLANET[$resource[$Element]]) ? $PLANET[$resource[$Element]] : $USER[$resource[$Element]];

		$array = array(
			'metal'      => $LNG['Metal'],
			'crystal'    => $LNG['Crystal'],
			'deuterium'  => $LNG['Deuterium'],
			'energy_max' => $LNG['Energy'],
			'darkmatter' => $LNG['Darkmatter'],
		);
		
		$restprice	= array();
		foreach ($array as $ResType => $ResTitle)
		{
			if ($pricelist[$Element][$ResType] == 0)
				continue;
			
			$cost = $Factor ? floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level)) : floor($pricelist[$Element][$ResType]);
			
			$restprice[$ResTitle] = pretty_number(max($cost - (($PLANET[$ResType]) ? $PLANET[$ResType] : $USER[$ResType]), 0));
		}

		return $restprice;
	}
	
	public function BuildAuftr($fmenge)
	{
		global $USER, $PLANET, $reslist, $CONF, $resource;
		$Missiles	= array(502 => $PLANET[$resource[502]], 503 => $PLANET[$resource[503]]);
		foreach($fmenge as $Element => $Count)
		{
			if(empty($Count) || !in_array($Element, array_merge($reslist['fleet'], $reslist['defense'])) || !IsTechnologieAccessible($USER, $PLANET, $Element))
				continue;
				
			$Count			= is_numeric($Count) ? round($Count) : 0;
			$Count 			= max(min($Count, $CONF['max_fleet_per_build']), 0);
			$MaxElements 	= $this->GetMaxConstructibleElements($Element);
			$Count 			= min($Count, $MaxElements);
			$BuildArray    	= !empty($PLANET['b_hangar_id']) ? unserialize($PLANET['b_hangar_id']) : array();
			
			if ($Element == 502 || $Element == 503)
			{
				$MaxMissiles	= $this->GetMaxConstructibleRockets($Missiles);
				$Count 			= min($Count, $MaxMissiles[$Element]);

				$Missiles[$Element] += $Count;
			} elseif(in_array($Element, $reslist['one'])) {
				$InBuild	= false;
				foreach($BuildArray as $ElementArray) {
					if($ElementArray[1] == $Element) {
						$InBuild	= true;
						break;
					}
				}
				$Count 		= ($PLANET[$resource[$Element]] == 0 && $InBuild === false) ? 1 : 0;
			}

			if(empty($Count))
				continue;
				
			$Ressource 	 			= $this->GetElementRessources($Element, $Count);
			$PLANET['metal']	 	-= $Ressource['metal'];
			$PLANET['crystal']   	-= $Ressource['crystal'];
			$PLANET['deuterium'] 	-= $Ressource['deuterium'];
			$USER['darkmatter']  	-= $Ressource['darkmatter'];

			if ($Element == 214 && $USER['rpg_destructeur'] == 1)
				$Count = 2 * $Count;

			$BuildArray[]			= array($Element, floattostring($Count));
			$PLANET['b_hangar_id']	= serialize($BuildArray);
			FirePHP::getInstance(true)->log("Queue(Hanger): ".$PLANET['b_hangar_id']);
		}
	}
	
	public function FleetBuildingPage()
	{
		global $PLANET, $USER, $LNG, $resource, $dpath, $db, $reslist, $CONF;

		include_once(ROOT_PATH . 'includes/functions/IsTechnologieAccessible.php');
		include_once(ROOT_PATH . 'includes/functions/GetElementPrice.php');
		
		$template	= new template();
		
		$PlanetRess = new ResourceUpdate();
		$PlanetRess->CalcResource();
		
		if ($PLANET[$resource[21]] == 0)
		{
			$PlanetRess->SavePlanetToDB();
			$template->message($LNG['bd_shipyard_required']);
			exit;
		}
		
		$fmenge	= isset($_POST['fmenge']) ? $_POST['fmenge'] : array();
		$cancel	= request_var('auftr', range(0, $CONF['max_elements_ships'] - 1));
		$action	= request_var('action', '');
		
		$NotBuilding = true;

		if (!empty($PLANET['b_building_id']))
		{
			$CurrentQueue 	= unserialize($PLANET['b_building_id']);
			foreach($CurrentQueue as $ElementArray) {
				if($ElementArray[0] == 21 || $ElementArray[0] == 15) {
					$NotBuilding = false;
					break;
				}
			}
		}
		
		$ElementQueue 	= unserialize($PLANET['b_hangar_id']);
		if(empty($ElementQueue))
			$Count	= 0;
		else
			$Count	= count($ElementQueue);
		if($USER['urlaubs_modus'] == 0) {
			if (!empty($fmenge) && $NotBuilding == true) {
				if ($Count >= $CONF['max_elements_ships']) {
					$template->message(sprintf($LNG['bd_max_builds'], $CONF['max_elements_ships']), "?page=buildings&mode=fleet", 3);
					exit;
				}
				$this->BuildAuftr($fmenge);
			}
			if ($action == "delete" && is_array($cancel))
				$this->CancelAuftr($cancel);
		}
		$PlanetRess->SavePlanetToDB();
				
		foreach($reslist['fleet'] as $Element)
		{
			if(!IsTechnologieAccessible($USER, $PLANET, $Element))
				continue;
			
			$FleetList[]	= array(
				'id'			=> $Element,
				'price'			=> GetElementPrice($USER, $PLANET, $Element, false),
				'restprice'		=> $this->GetRestPrice($Element, false),
				'time'			=> pretty_time(GetBuildingTime($USER, $PLANET, $Element)),
				'GetMaxAmount'	=> floattostring($this->GetMaxConstructibleElements($Element)),
				'IsAvailable'	=> IsElementBuyable($USER, $PLANET, $Element, false),
				'Available'		=> pretty_number($PLANET[$resource[$Element]]),
			);
		}
		
		$Buildlist	= array();
		
		$ElementQueue 	= unserialize($PLANET['b_hangar_id']);
		if(!empty($ElementQueue))
		{
			$Shipyard		= array();
			$QueueTime		= 0;
			foreach($ElementQueue as $Element)
			{
				if (empty($Element))
					continue;
					
				$ElementTime  	= GetBuildingTime($USER, $PLANET, $Element[0]);
				$QueueTime   	+= $ElementTime * $Element[1];
				$Shipyard[]		= array($LNG['tech'][$Element[0]], $Element[1], $ElementTime, $Element[0]);		
			}

			$template->loadscript('bcmath.js');
			$template->loadscript('shipyard.js');
			$template->execscript('ShipyardInit();');
			
			$Buildlist	= array(
				'Queue' 				=> $Shipyard,
				'b_hangar_id_plus' 		=> $PLANET['b_hangar'],
				'pretty_time_b_hangar' 	=> pretty_time(max($QueueTime - $PLANET['b_hangar'],0)),
			);
		}
		
		$template->assign_vars(array(
			'FleetList'				=> $FleetList,
			'NotBuilding'			=> $NotBuilding,
			'MaxMissiles'			=> array(),
			'BuildList'				=> json_encode($Buildlist),
			'maxlength'				=> strlen($CONF['max_fleet_per_build']),
		));
		$template->show("shipyard_fleet.tpl");
	}

	public function DefensesBuildingPage()
	{
		global $USER, $PLANET, $LNG, $resource, $dpath, $reslist, $CONF;

		include_once(ROOT_PATH . 'includes/functions/IsTechnologieAccessible.php');
		include_once(ROOT_PATH . 'includes/functions/GetElementPrice.php');

		$template	= new template();

		$PlanetRess = new ResourceUpdate();
		$PlanetRess->CalcResource();
		if ($PLANET[$resource[21]] == 0)
		{
			$PlanetRess->SavePlanetToDB();
			$template->message($LNG['bd_shipyard_required']);
			exit;
		}

		$fmenge	= isset($_POST['fmenge']) ? $_POST['fmenge'] : array();
		$cancel	= request_var('auftr', range(0, $CONF['max_elements_ships'] - 1));
		$action	= request_var('action', '');
								
		$NotBuilding = true;
		if (!empty($PLANET['b_building_id']))
		{
			$CurrentQueue 	= unserialize($PLANET['b_building_id']);
			foreach($CurrentQueue as $ElementArray) {
				if($ElementArray[0] == 21 || $ElementArray[0] == 15) {
					$NotBuilding = false;
					break;
				}
			}
		}
		
		$ElementQueue 	= unserialize($PLANET['b_hangar_id']);
		if(empty($ElementQueue))
			$Count	= 0;
		else
			$Count	= count($ElementQueue);
		if($USER['urlaubs_modus'] == 0) {
			if (!empty($fmenge) && $NotBuilding == true) {
				if ($Count >= $CONF['max_elements_ships']) {
					$template->message(sprintf($LNG['bd_max_builds'], $CONF['max_elements_ships']), "?page=buildings&mode=defense", 3);
					exit;
				}
				$this->BuildAuftr($fmenge);
			}
					
			if ($action == "delete" && is_array($cancel) && $USER['urlaubs_modus'] == 0)
				$this->CancelAuftr($cancel);
		}
		$PlanetRess->SavePlanetToDB();
		
		$MaxMissiles	= $this->GetMaxConstructibleRockets(array(502 => $PLANET[$resource[502]], 503 => $PLANET[$resource[503]]));
		
		foreach($reslist['defense'] as $Element)
		{
			if(!IsTechnologieAccessible($USER, $PLANET, $Element))
				continue;
				
			if(isset($MaxMissiles[$Element]))
				$GetMaxAmount	= floattostring(min($this->GetMaxConstructibleElements($Element), $MaxMissiles[$Element]));
			else
				$GetMaxAmount	= floattostring($this->GetMaxConstructibleElements($Element));
			
			$DefenseList[]	= array(
				'id'			=> $Element,
				'price'			=> GetElementPrice($USER, $PLANET, $Element, false),
				'restprice'		=> $this->GetRestPrice($Element),
				'time'			=> pretty_time(GetBuildingTime($USER, $PLANET, $Element)),
				'IsAvailable'	=> IsElementBuyable($USER, $PLANET, $Element, false),
				'GetMaxAmount'	=> $GetMaxAmount,
				'Available'		=> pretty_number($PLANET[$resource[$Element]]),
				'AlreadyBuild'	=> (in_array($Element, $reslist['one']) && (strpos($PLANET['b_hangar_id'], $Element.",") !== false || $PLANET[$resource[$Element]] != 0)) ? true : false,
			);
		}
		
		$ElementQueue 	= unserialize($PLANET['b_hangar_id']);
		$Buildlist		= array();
		if(!empty($ElementQueue))
		{
			$Shipyard		= array();
			$QueueTime		= 0;
			foreach($ElementQueue as $Element)
			{
				if (empty($Element))
					continue;
					
				$ElementTime  	= GetBuildingTime( $USER, $PLANET, $Element[0]);
				$QueueTime   	+= $ElementTime * $Element[1];
				$Shipyard[]		= array($LNG['tech'][$Element[0]], $Element[1], $ElementTime, $Element[0]);		
			}

			$template->loadscript('bcmath.js');
			$template->loadscript('shipyard.js');
			$template->execscript('ShipyardInit();');
			
			$Buildlist	= array(
				'Queue' 				=> $Shipyard,
				'b_hangar_id_plus' 		=> $PLANET['b_hangar'],
				'pretty_time_b_hangar' 	=> pretty_time(max($QueueTime - $PLANET['b_hangar'],0)),
			);
		}
		
		$template->assign_vars(array(
			'DefenseList'					=> $DefenseList,
			'NotBuilding'					=> $NotBuilding,
			'MaxMissiles'					=> $MaxMissiles,
			'BuildList'						=> json_encode($Buildlist),
			'maxlength'						=> strlen($CONF['max_fleet_per_build']),
		));
		$template->show("shipyard_defense.tpl");
	}
}
?>