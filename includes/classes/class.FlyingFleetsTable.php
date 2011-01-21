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
 * @copyright 2009 Lucky <douglas@crockford.com> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.3 (2011-01-21)
 * @link http://code.google.com/p/2moons/
 */

if(!defined('INSIDE')){ die(header("location:../../"));}

class FlyingFleetsTable
{
    private function BuildHostileFleetPlayerLink($FleetRow, $Names)
    {
		global $LNG, $USER;

		return $Names['own_username'].' <a href="#" onclick="OpenPopup(\'game.php?page=messages&amp;mode=write&amp;id='.$FleetRow['fleet_owner'].'\', \'\', 720, 300);return falase;">(N)</a>';
	}

	// For ShowFlyingFleets.php in admin panel.
	public function BuildFlyingFleetTable()
	{
		global $LNG, $db;
		$Table	= array();
		
		$FlyingFleets = $db->query("SELECT * FROM ".FLEETS." WHERE `fleeT_universe` = '".$_SESSION['adminuni']."' ORDER BY `fleet_end_time` ASC;");

		while ($CurrentFleet = $db->fetch_array($FlyingFleets))
		{
			$FleetOwner       = $db->uniquequery("SELECT `username` FROM ".USERS." WHERE `id` = '". $CurrentFleet['fleet_owner'] ."';");
			$TargetOwner      = $db->uniquequery("SELECT `username` FROM ".USERS." WHERE `id` = '". $CurrentFleet['fleet_target_owner'] ."';");

			$Bloc['Id']       = $CurrentFleet['fleet_id'];
			$Bloc['Mission']  = $this->CreateFleetPopupedMissionLink ( $CurrentFleet, $LNG['type_mission'][ $CurrentFleet['fleet_mission'] ], '' );
			$Bloc['Mission'] .= "<br>". (($CurrentFleet['fleet_mess'] == 1) ? "R" : "A" );
			$Bloc['Fleet']    = $this->CreateFleetPopupedFleetLink ( $CurrentFleet, $LNG['tech'][200], '' );
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
					$Bloc['Wa_Time']  = $LNG['cff_back'];
				else
					$Bloc['Wa_Time']  = $LNG['cff_to_destination'];
			}
			else
			{
				$Bloc['Wa_Time']  = "";
			}

			$Bloc['En_Time']  = date('G:i:s d/n/Y', $CurrentFleet['fleet_end_time']);
			$Bloc['lock'] 	  = $CurrentFleet['fleet_busy'] == 0 ? "<a href='?page=fleets&amp;id=".$CurrentFleet['fleet_id']."&amp;lock=1'><font color='red'>".$LNG['ff_lock']."</font></a>" : "<a href='?page=fleets&amp;id=".$CurrentFleet['fleet_id']."&amp;lock=0'><font color='green'>".$LNG['ff_unlock']."</font></a>";
			
			$Table[]	= $Bloc;
		}

		return $Table;
	}

       
	private function CreateFleetPopupedMissionLink($FleetRow, $Texte, $FleetType)
	{
		global $LNG;

		$FleetTotalC  = $FleetRow['fleet_resource_metal'] + $FleetRow['fleet_resource_crystal'] + $FleetRow['fleet_resource_deuterium'] + $FleetRow['fleet_resource_darkmatter'];
		if ($FleetTotalC <> 0)
		{
			$FRessource   = "<table width=200>";
			$FRessource  .= "<tr><td style=\'width:50%\' class=\'transparent\'><span style=\'color:white\'>".$LNG['Metal']."</span></td><td style=\'width:50%\' class=\'transparent\'><span style=\'color:white\'>". pretty_number($FleetRow['fleet_resource_metal']) ."</span></td></tr>";
			$FRessource  .= "<tr><td style=\'width:50%\' class=\'transparent\'><span style=\'color:white\'>".$LNG['Crystal']."</span></td><td style=\'width:50%\' class=\'transparent\'><span style=\'color:white\'>". pretty_number($FleetRow['fleet_resource_crystal']) ."</span></td></tr>";
			$FRessource  .= "<tr><td style=\'width:50%\' class=\'transparent\'><span style=\'color:white\'>".$LNG['Deuterium']."</span></td><td style=\'width:50%\' class=\'transparent\'><span style=\'color:white\'>". pretty_number($FleetRow['fleet_resource_deuterium']) ."</span></td></tr>";
			if($FleetRow['fleet_resource_darkmatter'] > 0)
				$FRessource  .= "<tr><td style=\'width:50%\' class=\'transparent\'><span style=\'color:white\'>".$LNG['Darkmatter']."</span></td><td style=\'width:50%\' class=\'transparent\'><span style=\'color:white\'>". pretty_number($FleetRow['fleet_resource_darkmatter']) ."</span></td></tr>";
			$FRessource  .= "</table>";
			$MissionPopup  = "<a href='#' onmouseover=\"return overlib('". $FRessource ."');";
			$MissionPopup .= "\" onmouseout=\"return nd();\" class=\"".$FleetType ."\">" . $Texte ."</a>";
		}
		else
			$MissionPopup  = $Texte;

		return $MissionPopup;
	}

	private function CreateFleetPopupedFleetLink($FleetRow, $Texte, $FleetType, $Names = array())
	{
		global $LNG;

		$FleetRec     = explode(";", $FleetRow['fleet_array']);
		$FleetPopup   = "<a href='#' onmouseover=\"return overlib('";
		$FleetPopup  .= "<table width=200>";
		if(!defined('IN_ADMIN'))
		{
			if($Names['spy_tech'] < 2 && $FleetRow['fleet_owner'] != $_SESSION['id'])
			{
				$FleetPopup .= "<tr><td style=\'width:100%\' class=\'transparent\'><span style=\'color:white\'>".$LNG['cff_no_fleet_data']."</span></td></tr>";
			}
			elseif($Names['spy_tech'] >= 2 && $Names['spy_tech'] < 4 && $FleetRow['fleet_owner'] != $_SESSION['id'])
			{
				$FleetPopup .= "<tr><td style=\'width:100%\' class=\'transparent\'><span style=\'color:white\'>".$LNG['cff_aproaching'].$FleetRow['fleet_amount'].$LNG['cff_ships']."</span></td></tr>";
			}
			else
			{
				if($FleetRow['fleet_owner'] != $_SESSION['id'])
					$FleetPopup .= "<tr><td style=\'width:100%\' class=\'transparent\'><span style=\'color:white\'>".$LNG['cff_aproaching'].$FleetRow['fleet_amount'].$LNG['cff_ships'].":</span></td></tr>";

				foreach($FleetRec as $Item => $Group)
				{
					if (empty($Group))
						continue;
						
					$Ship    = explode(",", $Group);
					if($FleetRow['fleet_owner'] == $_SESSION['id'])
						$FleetPopup .= "<tr><td style=\'width:50%\' class=\'transparent\'><span style=\'color:white\'>". $LNG['tech'][$Ship[0]] .":</span></td><td style=\'width:50%\' class=\'transparent\'><span style=\'color:white\'>". pretty_number($Ship[1]) ."</span></td></tr>";
					elseif($FleetRow['fleet_owner'] != $_SESSION['id'])
					{
						if($Names['spy_tech'] >= 4 && $Names['spy_tech'] < 8)
							$FleetPopup .= "<tr><td style=\'width:100%\' class=\'transparent\'><span style=\'color:white\'>". $LNG['tech'][$Ship[0]] ."</span></td></tr>";
						elseif($Names['spy_tech'] >= 8)
							$FleetPopup .= "<tr><td style=\'width:50%\' class=\'transparent\'><span style=\'color:white\'>". $LNG['tech'][$Ship[0]] .":</span></td><td style=\'width:50%\' class=\'transparent\'><span style=\'color:white\'>". pretty_number($Ship[1]) ."</span></td></tr>";
					}
				}
			}
		}
		else
		{
			foreach($FleetRec as $Item => $Group)
			{
				if ($Group  != '')
				{
					$Ship    = explode(",", $Group);
					$FleetPopup .= "<tr><td style=\'width:50%\' class=\'left\'><span style=\'color:white\'>". $LNG['tech'][$Ship[0]] .":</span></td><td width=50% align=right><span style=\'color:white\'>". pretty_number($Ship[1]) ."</span></td></tr>";
				}
			}
		}

		$FleetPopup  .= "</table>";
		$FleetPopup  .= "');\" onmouseout=\"return nd();\" class=\"". $FleetType ."\">". $Texte ."</a>";

		return $FleetPopup;
	}
       
	public function GetNames($FleetRow)
	{
		global $db;
		return $db->uniquequery("SELECT ou.username as own_username,
		ou.spy_tech as spy_tech,
		tu.username as target_username,
		op.name as own_planetname,
		tp.name as target_planetname
		FROM ".USERS." as ou
		LEFT JOIN ".USERS." tu ON tu.id = '".$FleetRow['fleet_target_owner']."'
		LEFT JOIN ".PLANETS." op ON op.`id` = '".$FleetRow['fleet_start_id']."'
		LEFT JOIN ".PLANETS." tp ON tp.`id` = '".$FleetRow['fleet_end_id']."'
		WHERE ou.id = '".$FleetRow['fleet_owner']."';");
	}
       
	public function GetEventString($FleetRow, $Status, $Owner, $Label, $Record)
	{
		global $LNG;
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
	       
		$Names		  = $this->GetNames($FleetRow);
		$FleetPrefix    = ($Owner == true) ? 'own' : '';
		$MissionType    = $FleetRow['fleet_mission'];
		$FleetContent   = $this->CreateFleetPopupedFleetLink($FleetRow, (($MissionType == 1 || $MissionType == 2) && $FleetRow['fleet_owner'] != $_SESSION['id'] && $Status == 0 && $Owner == true) ? $LNG['cff_acs_fleet'] : $LNG['ov_fleet'], $FleetPrefix.$FleetStyle[$MissionType], $Names);
		$FleetCapacity  = $this->CreateFleetPopupedMissionLink($FleetRow, $LNG['type_mission'][$MissionType], $FleetPrefix.$FleetStyle[$MissionType]);
		$StartType      = $FleetRow['fleet_start_type'];
		$TargetType     = $FleetRow['fleet_end_type'];
		$FleetGroup     = $FleetRow['fleet_group'];
		$FleetStatus    = array ( 0 => 'flight', 1 => 'return' , 2 => 'holding');


		if (($MissionType == 1 || $MissionType == 2) && $FleetRow['fleet_owner'] != $_SESSION['id'] && $Status == 0 && $Owner == true)
		{
			$StartID = $LNG['cff_of'].' '.$Names['own_username'].' ';
			$StartID  .= $LNG['cff_goes'];

			$StartID .= $Names['own_planetname']." ".GetStartAdressLink($FleetRow, $FleetPrefix.$FleetStyle[$MissionType]);

			if ($TargetType == 1)
				$TargetID  = $LNG['cff_the_planet'];
			elseif ($TargetType == 2)
				$TargetID  = $LNG['cff_debris_field'];
			elseif ($TargetType == 3)
				$TargetID  = $LNG['cff_to_the_moon'];
		       
			$TargetID .= $Names['target_planetname']." ";
			$TargetID .= GetTargetAdressLink ( $FleetRow, $FleetPrefix . $FleetStyle[ $MissionType ] );
		}
		elseif ($Status != 2)
		{
			if ($StartType == 1)
				$StartID  = $LNG['cff_from_the_planet'];
			elseif ($StartType == 3)
				$StartID  = $LNG['cff_from_the_moon'];

			$StartID .= $Names['own_planetname']." ".GetStartAdressLink($FleetRow, $FleetPrefix.$FleetStyle[$MissionType]);

			if ($MissionType != 15)
			{
				if ($TargetType == 1)
					$TargetID  = $LNG['cff_the_planet'];
				elseif ($TargetType == 2)
					$TargetID  = $LNG['cff_debris_field'];
				elseif ($TargetType == 3)
					$TargetID  = $LNG['cff_to_the_moon'];
			}
			else
				$TargetID  = $LNG['cff_the_position'];

			$TargetID .= $Names['target_planetname']." ";
			$TargetID .= GetTargetAdressLink($FleetRow, $FleetPrefix . $FleetStyle[ $MissionType ] );
		}
		else
		{
			if($StartType == 1)
				$StartID  = $LNG['cff_to_the_planet'];
			elseif ($StartType == 3)
				$StartID  = $LNG['cff_the_moon'];

			$StartID .= $Names['own_planetname'].' '.GetStartAdressLink($FleetRow, $FleetPrefix.$FleetStyle[ $MissionType ] );

			if ($MissionType != 15)
			{
				if($TargetType == 1)
					$TargetID  = $LNG['cff_from_planet'];
				elseif ($TargetType == 2)
					$TargetID  = $LNG['cff_from_debris_field'];
				elseif ($TargetType == 3)
					$TargetID  = $LNG['cff_from_the_moon'];
			}
			else
				$TargetID  = $LNG['cff_from_position'];

			$TargetID .= $Names['target_planetname'].' '.GetTargetAdressLink($FleetRow, $FleetPrefix.$FleetStyle[$MissionType]);
		}
	       
		if ($MissionType == 10)
		{
			$EventString  = $LNG['cff_missile_attack']." (".str_replace("503,","",$FleetRow["fleet_array"]).")";
			$Time	 = $FleetRow['fleet_start_time'];
			$Rest	 = $Time - TIMESTAMP;
			$EventString .= $LNG['cff_from'];
			$EventString .= $StartID;
			$EventString .= $LNG['cff_to'];
			$EventString .= $TargetID;
			$EventString .= ".";
		}
		else
		{
			if ($Owner == true)
			{
				if (($MissionType == 1 || $MissionType == 2) && $Status == 0 && $FleetRow['fleet_owner'] != $_SESSION['id']) {
					$EventString  = $LNG['cff_a'];
				} else {
					$EventString  = $LNG['cff_one_of_your'];
				}
				$EventString .= $FleetContent;
			}
			else
			{
				$EventString  = $LNG['cff_a'];
				$EventString .= $FleetContent;
				$EventString .= $LNG['cff_of'];
				$EventString .= $this->BuildHostileFleetPlayerLink($FleetRow, $Names);
			}

			if ($Status == 0)
			{
				$Time	 = $FleetRow['fleet_start_time'];
				$Rest	 = $Time - TIMESTAMP;
				$EventString .= $LNG['cff_goes'];
				$EventString .= $StartID;
				$EventString .= $LNG['cff_toward'];
				$EventString .= $TargetID;
				$EventString .= $LNG['cff_with_the_mission_of'];
			}
			elseif ($Status == 1)
			{
				$Time	 = $FleetRow['fleet_end_time'];
				$Rest	 = $Time - TIMESTAMP;
				$EventString .= $LNG['cff_comming_back'];
				$EventString .= $TargetID;
				$EventString .= $LNG['cff_back_to_the_planet'];			
				$EventString .= $StartID;
				$EventString .= $LNG['cff_with_the_mission_of'];
			}
			elseif ($Status == 2)
			{								
				$Time	 = $FleetRow['fleet_end_stay'];
				$Rest	 = $Time - TIMESTAMP;
				$EventString .= $LNG['cff_goes'];
				$EventString .= $StartID;
				$EventString .= $LNG['cff_to_explore'];
				$EventString .= $TargetID;
				$EventString .= $LNG['cff_with_the_mission_of'];
			}
			$EventString .= $FleetCapacity;
			$EventString = '<span class="'.$FleetStatus[$Status].' '.$FleetPrefix.$FleetStyle[$FleetRow['fleet_mission']].'">'.$EventString.'</span>';
		       
		}
		return array($Rest, $EventString, $Time);
	}
       
	//For overview and phalanx
	public function BuildFleetEventTable($FleetRow, $Status, $Owner, $Label, $Record, $isAKS = false)
	{
		global $LNG, $db;
		
		if(($FleetRow['fleet_mission'] == 8 && $_SESSION['id'] == $FleetRow['fleet_owner']) || $FleetRow['fleet_mission'] != 8)
		{
			if ($isAKS == true && $Status == 0 && ($FleetRow['fleet_mission'] == 1 || $FleetRow['fleet_mission'] == 2) && $FleetRow['fleet_group'] != 0)
			{
				$AKSFleets		= $db->query("SELECT * FROM ".FLEETS." WHERE `fleet_group` = '".$FleetRow['fleet_group']."' ORDER BY `fleet_id` ASC;");
				$EventString	= '';
				while($AKSRow = $db->fetch_array($AKSFleets))
				{
					$Return			= $this->GetEventString($AKSRow, $Status, $Owner, $Label, $Record);
					$Rest			= $Return[0];
					$EventString    .= $Return[1].'<br><br>';
					$Time			= $Return[2];
				}
				$db->free_result($AKSFleets);
			}
			else
			{
				list($Rest, $EventString, $Time) = $this->GetEventString($FleetRow, $Status, $Owner, $Label, $Record);
				$EventString    .= '<br><br>';	
			}
			
			$FleetInfo['fleet_order']	= $Label . $Record;
			$FleetInfo['fleet_descr']	= substr($EventString, 0, -8);
			$FleetInfo['fleet_return']	= $Time;
	
			return $FleetInfo;
		}
	}
}
?>