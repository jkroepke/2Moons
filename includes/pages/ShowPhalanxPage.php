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


function ShowPhalanxPage($CurrentUser, $CurrentPlanet)
{
	global $xgp_root, $phpEx, $lang, $db;

	include_once($xgp_root . 'includes/functions/InsertJavaScriptChronoApplet.' . $phpEx);
	include_once($xgp_root . 'includes/classes/class.FlyingFleetsTable.' . $phpEx);
	include_once($xgp_root . 'includes/classes/class.GalaxyRows.' . $phpEx);

	$FlyingFleetsTable 	= new FlyingFleetsTable();
	$GalaxyRows 		= new GalaxyRows();

	$PhRange 		 = $this->GetPhalanxRange ( $HavePhalanx );
			
	$SystemLimitMin  = max(1, $CurrentSystem - $PhRange);
	$SystemLimitMax  = $CurrentSystem + $PhRange;
	$PhalanxTypeLink = ($GalaxyRowPlanet['system'] <= $SystemLimitMax && $GalaxyRowPlanet['system'] >= $SystemLimitMin)

	$galaxy = request_var('galaxy', 0);
	$system = request_var('system', 0);
	
	if ($system < $radar_menzil_min) || ( intval ( $_GET["system"] ) > $radar_menzil_max ) )
	{
		$DoScan = false;
	}

	if ($CurrentPlanet['planet_type'] == 3)
	{
		$parse['phl_pl_galaxy']    = $CurrentPlanet['galaxy'];
		$parse['phl_pl_system']    = $CurrentPlanet['system'];
		$parse['phl_pl_place']     = $CurrentPlanet['planet'];
		$parse['phl_pl_name']      = $CurrentUser['username'];

		if ($CurrentPlanet['deuterium'] > 5000)
		{
			$db->query("UPDATE ".PLANETS." SET `deuterium` = `deuterium` - '5000' WHERE `id` = '". $CurrentUser['current_planet'] ."';");
			$parse['phl_er_deuter'] = "";
			$DoScan                 = true;
		}
		else
		{
			$parse['phl_er_deuter'] = $lang['px_no_deuterium'];
			$DoScan                 = false;
		}

		if ($DoScan == true)
		{
			$Galaxy  = $_GET["galaxy"];
			$System  = $_GET["system"];
			$Planet  = $_GET["planet"];
			$PlType  = $_GET["planettype"];

			$TargetInfo = $db->fetch_array($db->query("SELECT name,id_owner FROM ".PLANETS." WHERE `galaxy` = '". $Galaxy ."' AND `system` = '". $System ."' AND `planet` = '". $Planet ."' AND `planet_type` = '". $PlType ."';"));
			$TargetName = $TargetInfo['name'];

			$QryLookFleets  = "SELECT * ";
			$QryLookFleets .= "FROM ".FLEETS." ";
			$QryLookFleets .= "WHERE ( ( ";
			$QryLookFleets .= "`fleet_start_galaxy` = '". $Galaxy ."' AND ";
			$QryLookFleets .= "`fleet_start_system` = '". $System ."' AND ";
			$QryLookFleets .= "`fleet_start_planet` = '". $Planet ."' AND ";
			$QryLookFleets .= "`fleet_start_type` = '". $PlType ."' ";
			$QryLookFleets .= ") OR ( ";
			$QryLookFleets .= "`fleet_end_galaxy` = '". $Galaxy ."' AND ";
			$QryLookFleets .= "`fleet_end_system` = '". $System ."' AND ";
			$QryLookFleets .= "`fleet_end_planet` = '". $Planet ."' AND ";
			$QryLookFleets .= "`fleet_end_type` = '". $PlType ."' ";
			$QryLookFleets .= ") ) ";
			$QryLookFleets .= "ORDER BY `fleet_start_time`;";

			$FleetToTarget  = $db->query($QryLookFleets);

			if ($db->num_rows($FleetToTarget) <> 0 )
			{
				while ($FleetRow = $db->fetch_array($FleetToTarget))
				{
					$Record++;

					$StartTime   = $FleetRow['fleet_start_time'];
					$StayTime    = $FleetRow['fleet_end_stay'];
					$EndTime     = $FleetRow['fleet_end_time'];

					if ($FleetRow['fleet_owner'] == $TargetInfo['id_owner'])
						$FleetType = true;
					else
						$FleetType = false;

					$FleetRow['fleet_resource_metal']     = 0;
					$FleetRow['fleet_resource_crystal']   = 0;
					$FleetRow['fleet_resource_deuterium'] = 0;

					$Label = "fs";
					if ($StartTime > time())
						$fpage[$StartTime] = $FlyingFleetsTable->BuildFleetEventTable ( $FleetRow, 0, $FleetType, $Label, $Record );

					if ($FleetRow['fleet_mission'] <> 4)
					{
						$Label = "ft";
						if ($StayTime > time())
							$fpage[$StayTime] = $FlyingFleetsTable->BuildFleetEventTable ( $FleetRow, 1, $FleetType, $Label, $Record );

						if ($FleetType == true)
						{
							$Label = "fe";
							if ($EndTime > time())
								$fpage[$EndTime]  = $FlyingFleetsTable->BuildFleetEventTable ( $FleetRow, 2, $FleetType, $Label, $Record );
						}
					}
				}
			}

			if (count($fpage) > 0)
			{
				ksort($fpage);
				foreach ($fpage as $FleetTime => $FleetContent)
				{
					$Fleets .= "<tr class=\"".$FleetContent['fleet_status']."\">
									<th>
									".$FleetContent['fleet_javai']."
										<div id=\"bxx".$FleetContent['fleet_order']."\" class=\"z\">-</div>
									</th><th colspan=\"3\">
										<span class=".$FleetContent['fleet_status'].$FleetContent['fleet_prefix'].$FleetContent['fleet_style']."\">".$FleetContent['fleet_descr']."</span>
									".$FleetContent['fleet_javas']."
									</th>
								</tr>\n";
				}
			}
		}

		$parse['phl_fleets_table'] = $Fleets;
	}
	else
	{
		header("location:game.php?page=overview");
	}
}
?>