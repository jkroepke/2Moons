<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
# *																			 #
# *																			 #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.									 #
# *																			 #
# *  This program is distributed in the hope that it will be useful,		 #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of			 #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 #
# *  GNU General Public License for more details.							 #
# *																			 #
##############################################################################

if(!defined('INSIDE')){ die(header("location:../../"));}

class FlyingFleetsTable
{
	private function CreateFleetPopupedMissionLink($FleetRow, $Texte, $FleetType)
	{
		global $lang;

		$FleetTotalC  = $FleetRow['fleet_resource_metal'] + $FleetRow['fleet_resource_crystal'] + $FleetRow['fleet_resource_deuterium'];
		if ($FleetTotalC <> 0)
		{
			$FRessource   = "<table width=200>";
			$FRessource  .= "<tr><td width=50% align=left><font color=white>".$lang['Metal']."<font></td><td width=50% align=right><font color=white>". pretty_number($FleetRow['fleet_resource_metal']) ."<font></td></tr>";
			$FRessource  .= "<tr><td width=50% align=left><font color=white>".$lang['Crystal']."<font></td><td width=50% align=right><font color=white>". pretty_number($FleetRow['fleet_resource_crystal']) ."<font></td></tr>";
			$FRessource  .= "<tr><td width=50% align=left><font color=white>".$lang['Deuterium']."<font></td><td width=50% align=right><font color=white>". pretty_number($FleetRow['fleet_resource_deuterium']) ."<font></td></tr>";
			if($FleetRow['fleet_resource_darkmatter'] > 0)
				$FRessource  .= "<tr><td width=50% align=left><font color=white>".$lang['Darkmatter']."<font></td><td width=50% align=right><font color=white>". pretty_number($FleetRow['fleet_resource_darkmatter']) ."<font></td></tr>";
			$FRessource  .= "</table>";
		}
		else
			$FRessource   = "";

		if ($FRessource <> "")
		{
			$MissionPopup  = "<a href='#' onmouseover=\"return overlib('". $FRessource ."');";
			$MissionPopup .= "\" onmouseout=\"return nd();\" class=\"". $FleetType ."\">" . $Texte ."</a>";
		}
		else
			$MissionPopup  = $Texte ."";

		return $MissionPopup;
	}

	private function CreateFleetPopupedFleetLink($FleetRow, $Texte, $FleetType)
	{
		global $lang, $user;

		$FleetRec     = explode(";", $FleetRow['fleet_array']);
		$FleetPopup   = "<a href='#' onmouseover=\"return overlib('";
		$FleetPopup  .= "<table width=200>";
		if(!defined('IN_ADMIN'))
		{
			if($user['spy_tech'] < 2 && $FleetRow['fleet_owner'] != $user['id'])
			{
				$FleetPopup .= "<tr><td width=50% align=left><font color=white>".$lang['cff_no_fleet_data']."<font></td></tr>";
			}
			elseif($user['spy_tech'] >= 2 && $user['spy_tech'] < 4 && $FleetRow['fleet_owner'] != $user['id'])
			{
				$FleetPopup .= "<tr><td width=50% align=left><font color=white>".$lang['cff_aproaching'].$FleetRow[fleet_amount].$lang['cff_ships']."<font></td></tr>";
			}
			else
			{
				if($FleetRow['fleet_owner'] != $user['id'])
					$FleetPopup .= "<tr><td width=100% align=left><font color=white>".$lang['cff_aproaching'].$FleetRow[fleet_amount].$lang['cff_ships'].":<font></td></tr>";

				foreach($FleetRec as $Item => $Group)
				{
					if ($Group  != '')
					{
						$Ship    = explode(",", $Group);
						if($FleetRow['fleet_owner'] == $user['id'])
							$FleetPopup .= "<tr><td width=50% align=left><font color=white>". $lang['tech'][$Ship[0]] .":<font></td><td width=50% align=right><font color=white>". pretty_number($Ship[1]) ."<font></td></tr>";
						elseif($FleetRow['fleet_owner'] != $user['id'])
						{
							if($user['spy_tech'] >= 4 && $user['spy_tech'] < 8)
								$FleetPopup .= "<tr><td width=50% align=left><font color=white>". $lang['tech'][$Ship[0]] ."<font></td></tr>";
							elseif($user['spy_tech'] >= 8)
								$FleetPopup .= "<tr><td width=50% align=left><font color=white>". $lang['tech'][$Ship[0]] .":<font></td><td width=50% align=right><font color=white>". pretty_number($Ship[1]) ."<font></td></tr>";
						}
					}
				}
			}
		}
		elseif(defined('IN_ADMIN'))
		{
			foreach($FleetRec as $Item => $Group)
			{
				if ($Group  != '')
				{
					$Ship    = explode(",", $Group);
					$FleetPopup .= "<tr><td width=50% align=left><font color=white>". $lang['tech'][$Ship[0]] .":<font></td><td width=50% align=right><font color=white>". pretty_number($Ship[1]) ."<font></td></tr>";
				}
			}
		}

		$FleetPopup  .= "</table>";
		$FleetPopup  .= "');\" onmouseout=\"return nd();\" class=\"". $FleetType ."\">". $Texte ."</a>";

		return $FleetPopup;
	}

	private function BuildHostileFleetPlayerLink($FleetRow)
	{
		global $lang, $dpath, $db;

		$PlayerName  = $db->fetch_array($db->query("SELECT `username` FROM ".USERS." WHERE `id` = '". $FleetRow['fleet_owner']."';"));
		$Link  		 = $PlayerName['username']. " ";
		$Link 		.= "<a href=\"javascript:f('game.php?page=messages&amp;mode=write&amp;id=".$FleetRow['fleet_owner']."','');\">";
		$Link 		.= "<img src=\"".$dpath."/img/m.gif\" title=\"".$lang['write_message']."\" border=\"0\"></a>";

		return $Link;
	}

	// For ShowFlyingFleets.php in admin panel.
	public function BuildFlyingFleetTable ()
	{
		global $lang, $db;

		$FlyingFleets = $db->query("SELECT * FROM ".FLEETS." ORDER BY `fleet_end_time` ASC;");

		while ($CurrentFleet = $db->fetch_array($FlyingFleets))
		{
			$FleetOwner       = $db->fetch_array($db->query("SELECT `username` FROM ".USERS." WHERE `id` = '". $CurrentFleet['fleet_owner'] ."';"));
			$TargetOwner      = $db->fetch_array($db->query("SELECT `username` FROM ".USERS." WHERE `id` = '". $CurrentFleet['fleet_target_owner'] ."';"));

			$Bloc['Id']       = $CurrentFleet['fleet_id'];
			$Bloc['Mission']  = $this->CreateFleetPopupedMissionLink ( $CurrentFleet, $lang['type_mission'][ $CurrentFleet['fleet_mission'] ], '' );
			$Bloc['Mission'] .= "<br>". (($CurrentFleet['fleet_mess'] == 1) ? "R" : "A" );
			$Bloc['Fleet']    = $this->CreateFleetPopupedFleetLink ( $CurrentFleet, $lang['tech'][200], '' );
			$Bloc['St_Owner'] = "[". $CurrentFleet['fleet_owner'] ."]<br>". $FleetOwner['username'];
			$Bloc['St_Posit'] = "[".$CurrentFleet['fleet_start_galaxy'] .":". $CurrentFleet['fleet_start_system'] .":". $CurrentFleet['fleet_start_planet'] ."]<br>". ( ($CurrentFleet['fleet_start_type'] == 1) ? "[P]": (($CurrentFleet['fleet_start_type'] == 2) ? "D" : "L"  )) ."";
			$Bloc['St_Time']  = date('G:i:s d/n/Y', $CurrentFleet['fleet_start_time']);
			if (is_array($TargetOwner))
				$Bloc['En_Owner'] = "[". $CurrentFleet['fleet_target_owner'] ."]<br>". $TargetOwner['username'];
			else
				$Bloc['En_Owner'] = "";

			$Bloc['En_Posit'] = "[".$CurrentFleet['fleet_end_galaxy'] .":". $CurrentFleet['fleet_end_system'] .":". $CurrentFleet['fleet_end_planet'] ."]<br>". ( ($CurrentFleet['fleet_end_type'] == 1) ? "[P]": (($CurrentFleet['fleet_end_type'] == 2) ? "D" : "L"  )) ."";

			if ($CurrentFleet['fleet_mission'] == 5)
			{
				if ($CurrentFleet['fleet_mess'] == 2)
					$Bloc['Wa_Time']  = date('G:i:s d/n/Y', $CurrentFleet['fleet_end_stay']);
				elseif ($CurrentFleet['fleet_mess'] == 1)
					$Bloc['Wa_Time']  = $lang['cff_back'];
				else
					$Bloc['Wa_Time']  = $lang['cff_to_destination'];
			}
			else
			{
				$Bloc['Wa_Time']  = "";
			}

			$Bloc['En_Time']  = date('G:i:s d/n/Y', $CurrentFleet['fleet_end_time']);

			$table .= parsetemplate(gettemplate('adm/fleet_rows'), $Bloc);
		}

		return $table;
	}

	//For overview and phalanx
	public function BuildFleetEventTable($FleetRow, $Status, $Owner, $Label, $Record)
	{
		global $lang, $db;

		$FleetStyle  = array (
		1 => 'attack',
		2 => 'federation',
		3 => 'transport',
		4 => 'deploy',
		5 => 'hold',
		6 => 'espionage',
		7 => 'colony',
		8 => 'harvest',
		9 => 'destroy',
		10 => 'missile',
		15 => 'transport',
		);

		$FleetStatus = array ( 0 => 'flight', 1 => 'holding', 2 => 'return' );

		if ( $Owner == true )
			$FleetPrefix = 'own';
		else
			$FleetPrefix = '';

		$RowsTPL        = gettemplate('overview/overview_fleet_event');
		$MissionType    = $FleetRow['fleet_mission'];
		$FleetContent   = $this->CreateFleetPopupedFleetLink ( $FleetRow, $lang['ov_fleet'], $FleetPrefix . $FleetStyle[ $MissionType ] );
		$FleetCapacity  = $this->CreateFleetPopupedMissionLink ( $FleetRow, $lang['type_mission'][ $MissionType ], $FleetPrefix . $FleetStyle[ $MissionType ] );
		$StartPlanet    = $db->fetch_array($db->query("SELECT `name` FROM ".PLANETS." WHERE `galaxy` = '".$FleetRow['fleet_start_galaxy']."' AND `system` = '".$FleetRow['fleet_start_system']."' AND `planet` = '".$FleetRow['fleet_start_planet']."' AND `planet_type` = '".$FleetRow['fleet_start_type']."';"));
		$StartType      = $FleetRow['fleet_start_type'];
		$TargetPlanet   = $db->fetch_array($db->query("SELECT `name` FROM ".PLANETS." WHERE `galaxy` = '".$FleetRow['fleet_end_galaxy']."' AND `system` = '".$FleetRow['fleet_end_system']."' AND `planet` = '".$FleetRow['fleet_end_planet']."' AND `planet_type` = '".$FleetRow['fleet_end_type']."';"));
		$TargetType     = $FleetRow['fleet_end_type'];

		if ($Status != 2)
		{
			if ($StartType == 1)
				$StartID  = $lang['cff_from_the_planet'];
			elseif ($StartType == 3)
				$StartID  = $lang['cff_from_the_moon'];

			$StartID .= $StartPlanet['name'] ." ";
			$StartID .= GetStartAdressLink ( $FleetRow, $FleetPrefix . $FleetStyle[ $MissionType ] );

			if ($MissionType != 15)
			{
				if ($TargetType == 1)
					$TargetID  = $lang['cff_the_planet'];
				elseif ($TargetType == 2)
					$TargetID  = $lang['cff_debris_field'];
				elseif ($TargetType == 3)
					$TargetID  = $lang['cff_to_the_moon'];
			}
			else
				$TargetID  = $lang['cff_the_position'];

			$TargetID .= $TargetPlanet['name'] ." ";
			$TargetID .= GetTargetAdressLink ( $FleetRow, $FleetPrefix . $FleetStyle[ $MissionType ] );
		}
		else
		{
			if($StartType == 1)
				$StartID  = $lang['cff_to_the_planet'];
			elseif ($StartType == 3)
				$StartID  = $lang['cff_the_moon'];

			$StartID .= $StartPlanet['name'] ." ";
			$StartID .= GetStartAdressLink ( $FleetRow, $FleetPrefix . $FleetStyle[ $MissionType ] );

			if ( $MissionType != 15 )
			{
				if($TargetType == 1)
					$TargetID  = $lang['cff_from_planet'];
				elseif ($TargetType == 2)
					$TargetID  = $lang['cff_from_debris_field'];
				elseif ($TargetType == 3)
					$TargetID  = $lang['cff_from_the_moon'];
			}
			else
				$TargetID  = $lang['cff_from_position'];

			$TargetID .= $TargetPlanet['name'] ." ";
			$TargetID .= GetTargetAdressLink ( $FleetRow, $FleetPrefix . $FleetStyle[ $MissionType ] );
		}

		if ($MissionType == 10)
		{
			$EventString  = $lang['cff_missile_attack']." (".str_replace("503,","",$FleetRow["fleet_array"]).")";
			$Time         = $FleetRow['fleet_start_time'];
			$Rest         = $Time - time();
			$EventString .= $lang['cff_from'];
			$EventString .= $StartID;
			$EventString .= $lang['cff_to'];
			$EventString .= $TargetID;
			$EventString .= ".";
		}
		else
		{
			if ($Owner == true)
			{
				$EventString  = $lang['cff_one_of_your'];
				$EventString .= $FleetContent;
			}
			else
			{
				$EventString  = $lang['cff_a'];
				$EventString .= $FleetContent;
				$EventString .= $lang['cff_of'];
				$EventString .= $this->BuildHostileFleetPlayerLink ( $FleetRow );
			}

			if ($Status == 0)
			{
				$Time         = $FleetRow['fleet_start_time'];
				$Rest         = $Time - time();
				$EventString .= $lang['cff_goes'];
				$EventString .= $StartID;
				$EventString .= $lang['cff_toward'];
				$EventString .= $TargetID;
				$EventString .= $lang['cff_with_the_mission_of'];
			}
			elseif ($Status == 1)
			{
				$Time         = $FleetRow['fleet_end_stay'];
				$Rest         = $Time - time();
				$EventString .= $lang['cff_goes'];
				$EventString .= $StartID;
				$EventString .= $lang['cff_to_explore'];
				$EventString .= $TargetID;
				$EventString .= $lang['cff_with_the_mission_of'];
			}
			elseif ($Status == 2)
			{
				$Time         = $FleetRow['fleet_end_time'];
				$Rest         = $Time - time();
				$EventString .= $lang['cff_comming_back'];
				$EventString .= $TargetID;
				$EventString .= $lang['cff_back_to_the_planet'];				
				$EventString .= $StartID;
				$EventString .= $lang['cff_with_the_mission_of'];
			}
			$EventString .= $FleetCapacity;
		}

		$bloc['fleet_status'] = $FleetStatus[ $Status ];
		$bloc['fleet_prefix'] = $FleetPrefix;
		$bloc['fleet_style']  = $FleetStyle[ $MissionType ];
		$bloc['fleet_javai']  = InsertJavaScriptChronoApplet ( $Label, $Record, $Rest, true );
		$bloc['fleet_order']  = $Label . $Record;
		$bloc['fleet_descr']  = $EventString;
		$bloc['fleet_javas']  = InsertJavaScriptChronoApplet ( $Label, $Record, $Rest, false );

		return parsetemplate($RowsTPL, $bloc);
	}
}
?>