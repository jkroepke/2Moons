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

		$ResType['metal']     = ($pricelist[$Element]['metal']     * $Count);
		$ResType['crystal']   = ($pricelist[$Element]['crystal']   * $Count);
		$ResType['deuterium'] = ($pricelist[$Element]['deuterium'] * $Count);

		return $ResType;
	}
	private function CancelAuftr(&$CurrentPlanet, $CancelArray) 
	{
		$ElementQueue = explode(';', $CurrentPlanet['b_hangar_id']);
		foreach ($CancelArray as $ID => $Auftr)
		{
			$ElementQ	= explode(',', $ElementQueue[$Auftr-1]);
			$Element	= $ElementQ[0];
			$Count		= $ElementQ[1];
			$Resses		= $this->GetElementRessources($Element, $Count);
			$CurrentPlanet['metal']		+= $Resses['metal']		* 0.6;
			$CurrentPlanet['crystal']	+= $Resses['crystal']	* 0.6;
			$CurrentPlanet['deuterium']	+= $Resses['deuterium']	* 0.6;
			unset($ElementQueue[$Auftr-1]);
		}
		$CurrentPlanet['b_hangar_id']	= implode(';', $ElementQueue);
	}
	
	private function ElementBuildListBox ( $CurrentUser, $CurrentPlanet )
	{
		global $lang, $pricelist;

		$ElementQueue = explode(';', $CurrentPlanet['b_hangar_id']);
		$NbrePerType  = "";
		$NamePerType  = "";
		$TimePerType  = "";

		foreach($ElementQueue as $ElementLine => $Element)
		{
			if ($Element != '')
			{
				$Element 		= explode(',', $Element);
				$ElementTime  	= GetBuildingTime( $CurrentUser, $CurrentPlanet, $Element[0] );
				$QueueTime   	+= $ElementTime * $Element[1];
				$TimePerType 	.= "".$ElementTime.",";
				$NamePerType 	.= "'".html_entity_decode($lang['tech'][$Element[0]], ENT_NOQUOTES, "UTF-8")."',";
				$NbrePerType 	.= "".$Element[1].",";
			}
		}

		$parse 							= $lang;
		$parse['a'] 					= $NbrePerType;
		$parse['b'] 					= $NamePerType;
		$parse['c'] 					= $TimePerType;
		$parse['b_hangar_id_plus'] 		= $CurrentPlanet['b_hangar'];
		$parse['pretty_time_b_hangar'] 	= pretty_time(max($QueueTime - $CurrentPlanet['b_hangar'],0));
		$text .= parsetemplate(gettemplate('buildings/buildings_script'), $parse);

		return $text;
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
		'energy_max' => $lang['Energy']
		);

		$text  = $lang['bd_remaining'];
		foreach ($array as $ResType => $ResTitle)
		{
			if ($pricelist[$Element][$ResType] != 0)
			{
				$text .= "<br>".$ResTitle . ": <b>";
				if ($userfactor)
				{
					$cost = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level));
				}
				else
				{
					$cost = floor($pricelist[$Element][$ResType]);
				}
				$text .= pretty_number(max($cost - $planet[$ResType],0))."</b>";
			}
		}
		$text .= "";

		return $text;
	}
	
	public function FleetBuildingPage ( &$CurrentPlanet, $CurrentUser )
	{
		global $lang, $resource, $phpEx, $dpath, $xgp_root;

		include_once($xgp_root . 'includes/functions/IsTechnologieAccessible.' . $phpEx);
		include_once($xgp_root . 'includes/functions/GetElementPrice.' . $phpEx);

		$parse = $lang;
			
		if ($CurrentPlanet[$resource[21]] == 0)
			message($lang['bd_shipyard_required'], '', '', true);
			
		if (isset($_POST['fmenge']))
		{
			$AddedInQueue = false;

			foreach($_POST['fmenge'] as $Element => $Count)
			{
				$Element = intval($Element);
				$Count 	 = min(intval($Count), MAX_FLEET_OR_DEFS_PER_ROW);
				$ebuild  = explode(";",$CurrentPlanet['b_hangar_id']);
				if (count($ebuild) - 1 >= MAX_FLEET_OR_DEFS_IN_BUILD)
				{
					message(sprintf($lang['bd_max_builds'], MAX_FLEET_OR_DEFS_IN_BUILD), "?page=buildings&mode=fleet", 3, true);
				}
				elseif ($Count > 0 && IsTechnologieAccessible ($CurrentUser, $CurrentPlanet, $Element))
				{
					$MaxElements = $this->GetMaxConstructibleElements ( $Element, $CurrentPlanet );
					$Count		 = min($MaxElements, $Count);
					$Ressource 	 = $this->GetElementRessources ( $Element, $Count );
					$CurrentPlanet['metal']          -= $Ressource['metal'];
					$CurrentPlanet['crystal']        -= $Ressource['crystal'];
					$CurrentPlanet['deuterium']      -= $Ressource['deuterium'];

					if ($Element == 214 && $CurrentUser['rpg_destructeur'] == 1)
						$Count = 2 * $Count;

					$CurrentPlanet['b_hangar_id']    .= "". $Element .",". $Count .";";
				}
			}
		}
		
		if (isset($_POST['action']) && $_POST['action'] == "delete" && is_array($_POST['auftr']))
			$this->CancelAuftr($CurrentPlanet, $_POST['auftr']);

		$NotBuilding = true;

		if ($CurrentPlanet['b_building_id'] != 0)
		{
			$CurrentQueue = $CurrentPlanet['b_building_id'];
			if (strpos ($CurrentQueue, ";"))
			{
				// FIX BY LUCKY - IF THE SHIPYARD IS IN QUEUE THE USER CANT RESEARCH ANYTHING...
				$QueueArray		= explode (";", $CurrentQueue);

				for($i = 0; $i < MAX_BUILDING_QUEUE_SIZE; $i++)
				{
					$ListIDArray	= explode (",", $QueueArray[$i]);
					$Element		= $ListIDArray[0];

					if ( ($Element == 21 ) or ( $Element == 15 ) )
					{
						break;
					}
				}
				// END - FIX
			}
			else
			{
				$CurrentBuilding = $CurrentQueue;
			}

			if ( ( ( $CurrentBuilding == 21 ) or ( $CurrentBuilding == 15 ) ) or  (($Element == 21 ) or ( $Element == 15 )) ) // ADDED (or $Element == 21) BY LUCKY
			{
				$parse[message] = "<font color=\"red\">".$lang['bd_building_shipyard']."</font>";
				$NotBuilding = false;
			}
		}

		$TabIndex = 0;
		foreach($lang['tech'] as $Element => $ElementName)
		{
			if ($Element > 201 && $Element <= 399)
			{
				if (IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Element))
				{
					$CanBuildOne         = IsElementBuyable($CurrentUser, $CurrentPlanet, $Element, false);
					$BuildOneElementTime = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
					$ElementCount        = $CurrentPlanet[$resource[$Element]];
					$ElementNbre         = ($ElementCount == 0) ? "" : " (". $lang['bd_available'] . pretty_number($ElementCount) . ")";

					
					$PageTable .= "<tr>";
					$PageTable .= "<th class=\"l\" rowspan=\"2\" width=\"120\">";
					$PageTable .= "<a href=\"javascript:infodiv(".$Element.");javascript:animatedcollapse.toggle('".$Element."')\">";
					$PageTable .= "<img border=\"0\" src=\"".$dpath."gebaeude/".$Element.".gif\" alt=\"".$ElementName."\" align=\"top\" width=\"120\" height=\"120\">";
					$PageTable .= "</a>";
					$PageTable .= "</th>";
					$PageTable .= "<td class=\"c\">";
					$PageTable .= "<img src=\"./styles/images/transparent.gif\" alt=\"\" width=\"0\" height=\"0\">&nbsp;<a href=\"javascript:infodiv(".$Element.");javascript:animatedcollapse.toggle('".$Element."')\">".$ElementName."</a>".$ElementNbre."</td>";
					$PageTable .= "</td>";
					$PageTable .= "</tr>";
					$PageTable .= "<tr>";
					$PageTable .= "<td colspan=\"1\" class=\"l\">";
					$PageTable .= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
					$PageTable .= "<tbody>";
					$PageTable .= "<tr>";
					$PageTable .= "<td width=\"10px\"><img src=\"./styles/images/transparent.gif\" alt=\"\" width=\"0\" height=\"100\"></td>";
					$PageTable .= "<td width=\"90%\">".$lang['res']['descriptions'][$Element]."<br><br>".GetElementPrice($CurrentUser, $CurrentPlanet, $Element, false)."</td>";
					$PageTable .= "<td width=\"100px\" style=\"text-align:center;vertical-align:middle;\">";
					if ($CanBuildOne && $NotBuilding)
					{
						$TabIndex++;
						$PageTable .= "<input type=text name=fmenge[".$Element."] alt='".$lang['tech'][$Element]."' size=7 maxlength=7 value=0 tabindex=".$TabIndex.">";
					}
					$PageTable .= "</td>";
					$PageTable .= "</tr>";
					$PageTable .= "</tbody>";
					$PageTable .= "</table>";
					$PageTable .= "</td>";
					$PageTable .= "</tr>";
					$PageTable .= "<tr>";
					$PageTable .= "<td colspan=\"2\" style=\"padding:0px;\">";
					$PageTable .= "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
					$PageTable .= "<tbody>";
					$PageTable .= "<tr>";
					$PageTable .= "<td class=\"b\">";
					$PageTable .= "<table width=\"100%\" align=\"center\" cellpadding=\"2\" cellspacing=\"0\">";
					$PageTable .= "<tbody>";
					$PageTable .= "<tr>";
					$PageTable .= "<td>";
					$PageTable .= $this->GetRestPrice ($CurrentUser, $CurrentPlanet, $Element, true);
					$PageTable .= "</td>";
					$PageTable .= "<td colspan=\"2\">";
					$PageTable .= "<br><br>";
					$PageTable .= "</td>";
					$PageTable .= "</tr>";
					$PageTable .= "<tr>";
					$PageTable .= "<td width=\"68%\" rowspan=\"3\">";
					$PageTable .= "</td>";
					$PageTable .= "<td width=\"15%\">";
					$PageTable .= "<nobr>".ShowBuildTime($BuildOneElementTime)."</nobr>";
					$PageTable .= "</td>";
					$PageTable .= "</tr>";			
					$PageTable .= "</tbody>";
					$PageTable .= "</table>";
					$PageTable .= "</td>";
					$PageTable .= "</tr>";
					$PageTable .= "</tbody>";
					$PageTable .= "</table>";
					$PageTable .= "</td>";
					$PageTable .= "</tr>";
					$PageTable .= "<tr>";
					$PageTable .= "<td colspan=\"2\"><img src=\"./styles/images/transparent.gif\" alt=\"\" width=\"1\" height=\"10\"></td>";
					$PageTable .= "</tr>";

					if($NotBuilding)
					{
						$parse['build_fleet'] = "<tr><td class=\"c\" colspan=\"2\" style=\"text-align:center\"><input type=\"submit\" value=\"".$lang['bd_build_ships']."\"></td></tr>";
					}
				}
			}
		}

		if ($CurrentPlanet['b_hangar_id'] != '')
			$BuildQueue .= $this->ElementBuildListBox( $CurrentUser, $CurrentPlanet );

		$parse['buildinglist'] 	= $BuildQueue;
		$parse['buildlist']    	= $PageTable;

		display(parsetemplate(gettemplate('buildings/buildings_fleet'), $parse));
	}

	public function DefensesBuildingPage ( &$CurrentPlanet, $CurrentUser )
	{
		global $lang, $resource, $phpEx, $dpath, $_POST,$xgp_root;

		include_once($xgp_root . 'includes/functions/IsTechnologieAccessible.' . $phpEx);
		include_once($xgp_root . 'includes/functions/GetElementPrice.' . $phpEx);

		$parse = $lang;
			
		if ($CurrentPlanet[$resource[21]] == 0)
			message($lang['bd_shipyard_required'], '', '', true);
			
		if (isset($_POST['fmenge']))
		{
			$Missiles[502] = $CurrentPlanet[ $resource[502] ];
			$Missiles[503] = $CurrentPlanet[ $resource[503] ];
			$SiloSize      = $CurrentPlanet[ $resource[44] ];
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


			foreach($_POST['fmenge'] as $Element => $Count)
			{
				$Element = intval($Element);
				$Count 	 = min(intval($Count), MAX_FLEET_OR_DEFS_PER_ROW);
				$ebuild  = explode(";",$CurrentPlanet['b_hangar_id']);
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
					elseif($Element == 407 || $Element == 408 || $Element == 409)
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

					$Ressource = $this->GetElementRessources ( $Element, $Count );

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
		
		if (isset($_POST['action']) && $_POST['action'] == "delete" && is_array($_POST['auftr']))
			$this->CancelAuftr($CurrentPlanet, $_POST['auftr']);

		$NotBuilding = true;

		if ($CurrentPlanet['b_building_id'] != 0)
		{
			$CurrentQueue = $CurrentPlanet['b_building_id'];
			if (strpos ($CurrentQueue, ";"))
			{
				// FIX BY LUCKY - IF THE SHIPYARD IS IN QUEUE THE USER CANT RESEARCH ANYTHING...
				$QueueArray		= explode (";", $CurrentQueue);

				for($i = 0; $i < MAX_BUILDING_QUEUE_SIZE; $i++)
				{
					$ListIDArray	= explode (",", $QueueArray[$i]);
					$Element		= $ListIDArray[0];

					if ( ($Element == 21 ) or ( $Element == 15 ) )
					{
						break;
					}
				}
				// END - FIX
			}
			else
			{
				$CurrentBuilding = $CurrentQueue;
			}

			if ( ( ( $CurrentBuilding == 21 ) or ( $CurrentBuilding == 15 ) ) or  (($Element == 21 ) or  ( $Element == 15 )) ) // ADDED (or $Element == 21) BY LUCKY
			{
				$parse[message] = "<font color=\"red\">".$lang['bd_building_shipyard']."</font>";
				$NotBuilding = false;
			}


		}

		$TabIndex  = 0;
		$PageTable = "";
		foreach($lang['tech'] as $Element => $ElementName)
		{
			if ($Element > 400 && $Element <= 599)
			{
				if (IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Element))
				{
					$CanBuildOne         = IsElementBuyable($CurrentUser, $CurrentPlanet, $Element, false);
					$BuildOneElementTime = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
					$ElementCount        = $CurrentPlanet[$resource[$Element]];
					$ElementNbre         = ($ElementCount == 0) ? "" : " (". $lang['bd_available'] . pretty_number($ElementCount) . ")";

					$PageTable .= "<tr>";
					$PageTable .= "<th class=\"l\" rowspan=\"2\" width=\"120\">";
					$PageTable .= "<a href=\"javascript:infodiv(".$Element.");javascript:animatedcollapse.toggle('".$Element."')\">";
					$PageTable .= "<img border=\"0\" src=\"".$dpath."gebaeude/".$Element.".gif\" alt=\"".$ElementName."\" align=\"top\" width=\"120\" height=\"120\">";
					$PageTable .= "</a>";
					$PageTable .= "</th>";
					$PageTable .= "<td class=\"c\">";
					$PageTable .= "<img src=\"./styles/images/transparent.gif\" alt=\"\" width=\"0\" height=\"0\">&nbsp;<a href=\"javascript:infodiv(".$Element.");javascript:animatedcollapse.toggle('".$Element."')\">".$ElementName."</a>".$ElementNbre."</td>";
					$PageTable .= "</td>";
					$PageTable .= "</tr>";
					$PageTable .= "<tr>";
					$PageTable .= "<td colspan=\"1\" class=\"l\">";
					$PageTable .= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
					$PageTable .= "<tbody>";
					$PageTable .= "<tr>";
					$PageTable .= "<td width=\"10px\"><img src=\"./styles/images/transparent.gif\" alt=\"\" width=\"0\" height=\"100\"></td>";
					$PageTable .= "<td width=\"90%\">".$lang['res']['descriptions'][$Element]."<br><br>".GetElementPrice($CurrentUser, $CurrentPlanet, $Element, false)."</td>";
					$PageTable .= "<td width=\"100px\" style=\"text-align:center;vertical-align:middle;\">";
					if ($CanBuildOne)
					{
						$InQueue = strpos ( $CurrentPlanet['b_hangar_id'], $Element.",");
						$IsBuildp = ($CurrentPlanet[$resource[407]] >= 1) ? TRUE : FALSE;
						$IsBuildg = ($CurrentPlanet[$resource[408]] >= 1) ? TRUE : FALSE;
						$IsBuildpp = ($CurrentPlanet[$resource[409]] >= 1) ? TRUE : FALSE;
						$BuildIt = TRUE;
						if ($Element == 407 || $Element == 408 || $Element == 409)
						{
							$BuildIt = false;

							if ( $Element == 407 && !$IsBuildp && $InQueue === FALSE )
								$BuildIt = TRUE;

							if ( $Element == 408 && !$IsBuildg && $InQueue === FALSE )
								$BuildIt = TRUE;

							if ( $Element == 409 && !$IsBuildpp && $InQueue === FALSE )
								$BuildIt = TRUE;

						}

						if (!$BuildIt)
							$PageTable .= "<font color=\"red\">".$lang['bd_protection_shield_only_one']."</font>";
						elseif($NotBuilding)
						{
							$TabIndex++;
							$PageTable .= "<input type=text name=fmenge[".$Element."] alt='".$lang['tech'][$Element]."' size=6 maxlength=6 value=0 tabindex=".$TabIndex.">";
						}
					}
					$PageTable .= "</td>";
					$PageTable .= "</tr>";
					$PageTable .= "</tbody>";
					$PageTable .= "</table>";
					$PageTable .= "</td>";
					$PageTable .= "</tr>";
					$PageTable .= "<tr>";
					$PageTable .= "<td colspan=\"2\" style=\"padding:0px;\">";
					$PageTable .= "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
					$PageTable .= "<tbody>";
					$PageTable .= "<tr>";
					$PageTable .= "<td class=\"b\">";
					$PageTable .= "<table width=\"100%\" align=\"center\" cellpadding=\"2\" cellspacing=\"0\">";
					$PageTable .= "<tbody>";
					$PageTable .= "<tr>";
					$PageTable .= "<td>";
					$PageTable .= $this->GetRestPrice ($CurrentUser, $CurrentPlanet, $Element, true);
					$PageTable .= "</td>";
					$PageTable .= "<td colspan=\"2\">";
					$PageTable .= "<br><br>";
					$PageTable .= "</td>";
					$PageTable .= "</tr>";
					$PageTable .= "<tr>";
					$PageTable .= "<td width=\"68%\" rowspan=\"3\">";
					$PageTable .= "</td>";
					$PageTable .= "<td width=\"15%\">";
					$PageTable .= "<nobr>".ShowBuildTime($BuildOneElementTime)."</nobr>";
					$PageTable .= "</td>";
					$PageTable .= "</tr>";			
					$PageTable .= "</tbody>";
					$PageTable .= "</table>";
					$PageTable .= "</td>";
					$PageTable .= "</tr>";
					$PageTable .= "</tbody>";
					$PageTable .= "</table>";
					$PageTable .= "</td>";
					$PageTable .= "</tr>";
					$PageTable .= "<tr>";
					$PageTable .= "<td colspan=\"2\"><img src=\"./styles/images/transparent.gif\" alt=\"\" width=\"1\" height=\"10\"></td>";
					$PageTable .= "</tr>";					
					
					if($NotBuilding)
					{
						$parse['build_defenses'] = "<tr><td class=\"c\" colspan=\"2\" style=\"text-align:center\"><input type=\"submit\" value=\"".$lang['bd_build_defenses']."\"></td></tr>";
					}					
				}
			}
		}

		if ($CurrentPlanet['b_hangar_id'] != '')
			$BuildQueue .= $this->ElementBuildListBox( $CurrentUser, $CurrentPlanet );

		$parse['buildlist']    	= $PageTable;
		$parse['buildinglist'] 	= $BuildQueue;
		display(parsetemplate(gettemplate('buildings/buildings_defense'), $parse));
	}
}
?>