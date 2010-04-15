<?php

##############################################################################
# *                                                                          #
# * 2MOONS                                                                   #
# *                                                                          #
# * @copyright Copyright (C) 2010 By ShadoX from titanspace.de               #
# *                                                                          #
# *	                                                                         #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.                                     #
# *	                                                                         #
# *  This program is distributed in the hope that it will be useful,         #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of          #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           #
# *  GNU General Public License for more details.                            #
# *                                                                          #
##############################################################################

if(!defined('INSIDE')){ die(header("location:../../"));}

class ShowShipyardPage
{
	private function GetMaxConstructibleElements ($Element, $Ressources)
	{
		global $pricelist;

		if ($pricelist[$Element]['metal'] != 0)
		{
			$Buildable        = floor($Ressources["metal"] / $pricelist[$Element]['metal']);
			$MaxElements      = $Buildable;
		}

		if ($pricelist[$Element]['crystal'] != 0)
			$Buildable        = floor($Ressources["crystal"] / $pricelist[$Element]['crystal']);

		if (!isset($MaxElements))
			$MaxElements      = $Buildable;
		elseif($MaxElements > $Buildable)
			$MaxElements      = $Buildable;

		if ($pricelist[$Element]['deuterium'] != 0)
			$Buildable        = floor($Ressources["deuterium"] / $pricelist[$Element]['deuterium']);

		if (!isset($MaxElements))
			$MaxElements      = $Buildable;
		elseif ($MaxElements > $Buildable)
			$MaxElements      = $Buildable;

		if ($pricelist[$Element]['energy'] != 0)
			$Buildable        = floor($Ressources["energy_max"] / $pricelist[$Element]['energy']);

		if ($Buildable < 1)
			$MaxElements      = 0;

		return $MaxElements;
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
	private function CancelAuftr(&$CurrentUser, &$CurrentPlanet, $CancelArray) 
	{
		$ElementQueue = explode(';', $CurrentPlanet['b_hangar_id']);
		foreach ($CancelArray as $ID => $Auftr)
		{
			$ElementQ	= explode(',', $ElementQueue[$Auftr-1]);
			$Element	= $ElementQ[0];
			$Count		= $ElementQ[1];
			if ($Element == 214 && $CurrentUser['rpg_destructeur'] == 1) $Count = $Count / 2;
			
			$Resses		= $this->GetElementRessources($Element, $Count);
			$CurrentPlanet['metal']		+= $Resses['metal']			* 0.6;
			$CurrentPlanet['crystal']	+= $Resses['crystal']		* 0.6;
			$CurrentPlanet['deuterium']	+= $Resses['deuterium']		* 0.6;
			$CurrentUser['darkmatter']	+= $Resses['darkmatter']	* 0.6;
			unset($ElementQueue[$Auftr-1]);
		}
		$CurrentPlanet['b_hangar_id']	= implode(';', $ElementQueue);
	}
	
	private function GetRestPrice ($user, $planet, $Element, $userfactor = true)
	{
		global $pricelist, $resource, $lang;

		if ($userfactor)
		{
			$level = ($planet[$resource[$Element]]) ? $planet[$resource[$Element]] : $user[$resource[$Element]];
		}

		$array = array(
			'metal'      => $lang['Metal'],
			'crystal'    => $lang['Crystal'],
			'deuterium'  => $lang['Deuterium'],
			'energy_max' => $lang['Energy'],
			'darkmatter' => $lang['Darkmatter'],
		);
		$restprice	= array();
		foreach ($array as $ResType => $ResTitle)
		{
			if ($pricelist[$Element][$ResType] != 0)
			{
				if ($userfactor)
				{
					$cost = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level));
				}
				else
				{
					$cost = floor($pricelist[$Element][$ResType]);
				}
				$restprice[$ResTitle] = pretty_number(max($cost - (($planet[$ResType]) ? $planet[$ResType] : $user[$ResType]), 0));
			}
		}

		return $restprice;
	}
	
	public function FleetBuildingPage($CurrentPlanet, $CurrentUser)
	{
		global $lang, $resource, $dpath, $db, $reslist;

		include_once(ROOT_PATH . 'includes/functions/IsTechnologieAccessible.' . PHP_EXT);
		include_once(ROOT_PATH . 'includes/functions/GetElementPrice.' . PHP_EXT);
		
		
		$PlanetRess = new ResourceUpdate($CurrentUser, $CurrentPlanet);

		if ($CurrentPlanet[$resource[21]] == 0)
		{
			$template	= new template();
			$template->set_vars($CurrentUser, $CurrentPlanet);
			$template->page_header();	
			$template->page_topnav();
			$template->page_leftmenu();
			$template->page_planetmenu();
			$template->page_footer();
			$template->message($lang['bd_shipyard_required']);
			$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
			exit;
		}
		
		$fmenge	= $_POST['fmenge'];
		$cancel	= $_POST['auftr'];
		$action	= request_var('action', '');
		
		if (!empty($fmenge))
		{
			$AddedInQueue = false;

			foreach($fmenge as $Element => $Count)
			{
				$Element = in_array($Element, $reslist['fleet']) ? $Element : NULL;
				if(empty($Element))
					continue;
				
				$Count	= is_numeric($Count) ? $Count : 0;
				$Count 	= min($Count, MAX_FLEET_OR_DEFS_PER_ROW);
				$ebuild = explode(";",$CurrentPlanet['b_hangar_id']);
				if (count($ebuild) - 1 >= MAX_FLEET_OR_DEFS_IN_BUILD)
				{
					$template	= new template();
					$template->set_vars($CurrentUser, $CurrentPlanet);
					$template->page_header();	
					$template->page_topnav();
					$template->page_leftmenu();
					$template->page_planetmenu();
					$template->page_footer();
					$template->message(sprintf($lang['bd_max_builds'], MAX_FLEET_OR_DEFS_IN_BUILD), "?page=buildings&mode=fleet", 3);
					$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
					exit;
				}
				elseif ($Count > 0 && IsTechnologieAccessible ($CurrentUser, $CurrentPlanet, $Element))
				{
					$MaxElements = $this->GetMaxConstructibleElements($Element, $CurrentPlanet);
					$Count		 = min($MaxElements, $Count);
					$Ressource 	 = $this->GetElementRessources($Element, $Count);
					$CurrentPlanet['metal']		-= $Ressource['metal'];
					$CurrentPlanet['crystal']   -= $Ressource['crystal'];
					$CurrentPlanet['deuterium'] -= $Ressource['deuterium'];
					$CurrentUser['darkmatter']  -= $Ressource['darkmatter'];

					if ($Element == 214 && $CurrentUser['rpg_destructeur'] == 1)
						$Count = 2 * $Count;

					$CurrentPlanet['b_hangar_id']    .= $Element .",". $Count .";";
				}
			}
		}
				
		if ($action == "delete" && is_array($cancel))
			$this->CancelAuftr($CurrentUser, $CurrentPlanet, $cancel);

		$NotBuilding = true;

		if (!empty($CurrentPlanet['b_building_id']))
		{
			$CurrentQueue = $CurrentPlanet['b_building_id'];
			$QueueArray		= explode (";", $CurrentQueue);

			for($i = 0; $i < count($QueueArray); $i++)
			{
				$ListIDArray	= explode (",", $QueueArray[$i]);
				if($ListIDArray[0] == 21 || $ListIDArray[0] == 15)
					$NotBuilding = false;
			}
		}

		$template	= new template();
		if(!empty($CurrentPlanet['b_hangar_id']))
			$template->loadscript('shipyard.js');
		
		$template->set_vars($CurrentUser, $CurrentPlanet);
		$template->page_header();	
		$template->page_topnav();
		$template->page_leftmenu();
		$template->page_planetmenu();
		$template->page_footer();
		
		foreach($reslist['fleet'] as $Element)
		{
			if (IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Element))
			{
				$FleetList[]	= array(
					'id'			=> $Element,
					'name'			=> $lang['tech'][$Element],
					'descriptions'	=> $lang['res']['descriptions'][$Element],
					'price'			=> GetElementPrice($CurrentUser, $CurrentPlanet, $Element, false),
					'restprice'		=> $this->GetRestPrice ($CurrentUser, $CurrentPlanet, $Element),
					'time'			=> pretty_time(GetBuildingTime($CurrentUser, $CurrentPlanet, $Element)),
					'IsAvailable'	=> IsElementBuyable($CurrentUser, $CurrentPlanet, $Element, false),
					'Available'		=> pretty_number($CurrentPlanet[$resource[$Element]]),
				);
			}
		}
		
		if(!empty($CurrentPlanet['b_hangar_id']))
		{
			$ElementQueue = explode(';', $CurrentPlanet['b_hangar_id']);
			$NbrePerType  = "";
			$NamePerType  = "";
			$TimePerType  = "";

			foreach($ElementQueue as $ElementLine => $Element)
			{
				if ($Element != '')
				{
					$Element 		= explode(',', $Element);
					$ElementTime  	= GetBuildingTime( $CurrentUser, $CurrentPlanet, $Element[0]);
					$QueueTime   	+= $ElementTime * $Element[1];
					$TimePerType 	.= "".$ElementTime.",";
					$NamePerType 	.= "'".html_entity_decode($lang['tech'][$Element[0]], ENT_NOQUOTES, "UTF-8")."',";
					$NbrePerType 	.= "".$Element[1].",";
				}
			}

			$template->assign_vars(array(
				'a' 					=> $NbrePerType,
				'b' 					=> $NamePerType,
				'c' 					=> $TimePerType,
				'b_hangar_id_plus' 		=> $CurrentPlanet['b_hangar'],
				'pretty_time_b_hangar' 	=> pretty_time(max($QueueTime - $CurrentPlanet['b_hangar'],0)),
				'bd_completed'			=> $lang['bd_completed'],
				'bd_cancel_warning'		=> $lang['bd_cancel_warning'],
				'bd_cancel_send'		=> $lang['bd_cancel_send'],
				'bd_actual_production'	=> $lang['bd_actual_production'],
				'bd_operating'			=> $lang['bd_operating'],
			));
			$Buildlist	= $template->fetch('shipyard_buildlist.tpl');
		}
		
		$template->assign_vars(array(
			'FleetList'				=> $FleetList,
			'NotBuilding'			=> $NotBuilding,
			'bd_available'			=> $lang['bd_available'],
			'bd_remaining'			=> $lang['bd_remaining'],
			'fgf_time'				=> $lang['fgf_time'],
			'bd_build_ships'		=> $lang['bd_build_ships'],
			'bd_building_shipyard'	=> $lang['bd_building_shipyard'],
			'BuildList'				=> $Buildlist,
		));
		$template->show("shipyard_fleet.tpl");
		$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
	}

	public function DefensesBuildingPage ( &$CurrentPlanet, $CurrentUser )
	{
		global $lang, $resource, $dpath, $reslist;

		include_once(ROOT_PATH . 'includes/functions/IsTechnologieAccessible.' . PHP_EXT);
		include_once(ROOT_PATH . 'includes/functions/GetElementPrice.' . PHP_EXT);

		$PlanetRess = new ResourceUpdate($CurrentUser, $CurrentPlanet);
		$template	= new template();
		$template->page_header();	
		$template->page_topnav();
		$template->page_leftmenu();
		$template->page_planetmenu();
		$template->page_footer();
			
		if ($CurrentPlanet[$resource[21]] == 0)
		{
			$template->set_vars($CurrentUser, $CurrentPlanet);
			$template->message($lang['bd_shipyard_required']);
			$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
			exit;
		}
		
		
		$fmenge	= $_POST['fmenge'];
		$cancel	= $_POST['auftr'];
		$action	= request_var('action', '');
		
		if (isset($fmenge))
		{
			$Missiles[502] = $CurrentPlanet[$resource[502]];
			$Missiles[503] = $CurrentPlanet[$resource[503]];
			$SiloSize      = $CurrentPlanet[$resource[44]];
			$MaxMissiles   = $SiloSize * 10;
			$BuildQueue    = $CurrentPlanet['b_hangar_id'];
			$BuildArray    = explode (";", $BuildQueue);

			for ($QElement = 0; $QElement < count($BuildArray); $QElement++)
			{
				$ElmentArray = explode (",", $BuildArray[$QElement] );
				if($ElmentArray[0] == 502)
				{
					$Missiles[502] += $ElmentArray[1];
				}
				elseif($ElmentArray[0] == 503)
				{
					$Missiles[503] += $ElmentArray[1];
				}
			}


			foreach($fmenge as $Element => $Count)
			{
				$Element = in_array($Element, $reslist['defense']) ? $Element : NULL;
				if(empty($Element))
					continue;
					
				$Count	= is_numeric($Count) ? $Count : 0;
				$Count 	= min($Count, MAX_FLEET_OR_DEFS_PER_ROW);
				$ebuild = explode(";",$CurrentPlanet['b_hangar_id']);
				if (count($ebuild) - 1 >= MAX_FLEET_OR_DEFS_IN_BUILD)
				{
					message(sprintf($lang['bd_max_builds'], MAX_FLEET_OR_DEFS_IN_BUILD), "?page=buildings&mode=fleet", 3, true);
				}
				elseif ($Count != 0 && IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Element))
				{
					$MaxElements = $this->GetMaxConstructibleElements ( $Element, $CurrentPlanet );
					if ($Element == 502 || $Element == 503)
					{
						$ActuMissiles  = $Missiles[502] + ( 2 * $Missiles[503] );
						$MissilesSpace = $MaxMissiles - $ActuMissiles;
						if ($Element == 502)
						{
							if ( $Count > $MissilesSpace )
							{
								$Count = $MissilesSpace;
							}
						}
						else
						{
							if ( $Count > floor( $MissilesSpace / 2 ) )
							{
								$Count = floor( $MissilesSpace / 2 );
							}
						}
						if ($Count > $MaxElements)
						{
							$Count = $MaxElements;
						}
						$Missiles[$Element] += $Count;
					}
					elseif(in_array($Element, $reslist['one']))
					{
						$InQueue = strpos ( $CurrentPlanet['b_hangar_id'], $Element.",");
						$IsBuildpp = ($CurrentPlanet[$resource[$Element]] >= 1) ? TRUE : FALSE;
						if(!$IsBuildpp && $InQueue === FALSE)
						{
							$Count = 1;
						}
						else
						{
							$Count = 0;
						}
					}
					else
					{
						if ($Count > $MaxElements)
						{
							$Count = $MaxElements;
						}
					}

					$Ressource = $this->GetElementRessources($Element, $Count);
					if ($Count >= 1)
					{
						$CurrentPlanet['metal']           -= $Ressource['metal'];
						$CurrentPlanet['crystal']         -= $Ressource['crystal'];
						$CurrentPlanet['deuterium']       -= $Ressource['deuterium'];
						$CurrentPlanet['b_hangar_id']     .= "". $Element .",". $Count .";";
					}
				}
			}
		}
				
		if ($action == "delete" && is_array($cancel))
			$this->CancelAuftr($CurrentUser, $CurrentPlanet, $cancel);

		$NotBuilding = true;

		if (!empty($CurrentPlanet['b_building_id']))
		{
			$CurrentQueue = $CurrentPlanet['b_building_id'];
			$QueueArray		= explode (";", $CurrentQueue);

			for($i = 0; $i < count($QueueArray); $i++)
			{
				$ListIDArray	= explode (",", $QueueArray[$i]);
				if($ListIDArray[0] == 21 || $ListIDArray[0] == 15)
					$NotBuilding = false;
			}
		}

		if(!empty($CurrentPlanet['b_hangar_id']))
			$template->loadscript('shipyard.js');
		
		$template->set_vars($CurrentUser, $CurrentPlanet);
		
		foreach($reslist['defense'] as $Element)
		{
			if (IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Element))
			{
				if(in_array($Element, $reslist['one']))
				{
					$InQueue 		= strpos($CurrentPlanet['b_hangar_id'], $Element.",");
					$IsBuild	 	= ($CurrentPlanet[$resource[$Element]] >= 1) ? true : false;
					$AlreadyBuild 	= ($IsBuild || $InQueue) ? true : false;
				}
				else
					unset($AlreadyBuild);
					
				$DefenseList[]	= array(
					'id'			=> $Element,
					'name'			=> $lang['tech'][$Element],
					'descriptions'	=> $lang['res']['descriptions'][$Element],
					'price'			=> GetElementPrice($CurrentUser, $CurrentPlanet, $Element, false),
					'restprice'		=> $this->GetRestPrice ($CurrentUser, $CurrentPlanet, $Element),
					'time'			=> pretty_time(GetBuildingTime($CurrentUser, $CurrentPlanet, $Element)),
					'IsAvailable'	=> IsElementBuyable($CurrentUser, $CurrentPlanet, $Element, false),
					'Available'		=> pretty_number($CurrentPlanet[$resource[$Element]]),
					'AlreadyBuild'	=> $AlreadyBuild,
				);
			}
		}

		if(!empty($CurrentPlanet['b_hangar_id']))
		{
			$ElementQueue = explode(';', $CurrentPlanet['b_hangar_id']);
			$NbrePerType  = "";
			$NamePerType  = "";
			$TimePerType  = "";

			foreach($ElementQueue as $ElementLine => $Element)
			{
				if ($Element != '')
				{
					$Element 		= explode(',', $Element);
					$ElementTime  	= GetBuildingTime( $CurrentUser, $CurrentPlanet, $Element[0]);
					$QueueTime   	+= $ElementTime * $Element[1];
					$TimePerType 	.= "".$ElementTime.",";
					$NamePerType 	.= "'".html_entity_decode($lang['tech'][$Element[0]], ENT_NOQUOTES, "UTF-8")."',";
					$NbrePerType 	.= "".$Element[1].",";
				}
			}

			$template->assign_vars(array(
				'a' 					=> $NbrePerType,
				'b' 					=> $NamePerType,
				'c' 					=> $TimePerType,
				'b_hangar_id_plus' 		=> $CurrentPlanet['b_hangar'],
				'pretty_time_b_hangar' 	=> pretty_time(max($QueueTime - $CurrentPlanet['b_hangar'],0)),
				'bd_completed'			=> $lang['bd_completed'],
				'bd_cancel_warning'		=> $lang['bd_cancel_warning'],
				'bd_cancel_send'		=> $lang['bd_cancel_send'],
				'bd_actual_production'	=> $lang['bd_actual_production'],
				'bd_operating'			=> $lang['bd_operating'],
			));
			$Buildlist	= $template->fetch('shipyard_buildlist.tpl');
		}
		
		$template->assign_vars(array(
			'DefenseList'					=> $DefenseList,
			'NotBuilding'					=> $NotBuilding,
			'bd_available'					=> $lang['bd_available'],
			'bd_remaining'					=> $lang['bd_remaining'],
			'fgf_time'						=> $lang['fgf_time'],
			'bd_build_ships'				=> $lang['bd_build_ships'],
			'bd_building_shipyard'			=> $lang['bd_building_shipyard'],
			'bd_protection_shield_only_one'	=> $lang['bd_protection_shield_only_one'],
			'BuildList'						=> $Buildlist,
		));
		$template->show("shipyard_defense.tpl");
		$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
	}
}
?>