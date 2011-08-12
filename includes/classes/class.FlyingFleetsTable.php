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

if(!defined('INSIDE')){ die(header("location:../../"));}

class FlyingFleetsTable
{
    private function BuildHostileFleetPlayerLink($FleetRow, $Names)
    {
		global $LNG, $USER;

		return $Names['own_username'].' <a href="#" onclick="return Dialog.PM('.$FleetRow['fleet_owner'].')">(N)</a>';
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
			$Bloc['St_Time']  = date($LNG['php_tdformat'], $CurrentFleet['fleet_start_time']);
			if (is_array($TargetOwner))
				$Bloc['En_Owner'] = "[". $CurrentFleet['fleet_target_owner'] ."]<br>". $TargetOwner['username'];
			else
				$Bloc['En_Owner'] = "";

			$Bloc['En_Posit'] = "[".$CurrentFleet['fleet_end_galaxy'] .":". $CurrentFleet['fleet_end_system'] .":". $CurrentFleet['fleet_end_planet'] ."]<br>". ( ($CurrentFleet['fleet_end_type'] == 1) ? "[P]": (($CurrentFleet['fleet_end_type'] == 2) ? "D" : "L"  )) ."";

			if ($CurrentFleet['fleet_mission'] == 5)
			{
				if ($CurrentFleet['fleet_mess'] == 2)
					$Bloc['Wa_Time']  = date($LNG['php_tdformat'], $CurrentFleet['fleet_end_stay']);
				elseif ($CurrentFleet['fleet_mess'] == 1)
					$Bloc['Wa_Time']  = $LNG['cff_back'];
				else
					$Bloc['Wa_Time']  = $LNG['cff_to_destination'];
			}
			else
			{
				$Bloc['Wa_Time']  = "";
			}

			$Bloc['En_Time']  = date($LNG['php_tdformat'], $CurrentFleet['fleet_end_time']);
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
			$FRessource   = '<table width=200>';
			$FRessource  .= '<tr><td style=\'width:50%;color:white\'>'.$LNG['Metal'].'</td><td style=\'width:50%;color:white\'>'. pretty_number($FleetRow['fleet_resource_metal']).'</td></tr>';
			$FRessource  .= '<tr><td style=\'width:50%;color:white\'>'.$LNG['Crystal'].'</td><td style=\'width:50%;color:white\'>'. pretty_number($FleetRow['fleet_resource_crystal']).'</td></tr>';
			$FRessource  .= '<tr><td style=\'width:50%;color:white\'>'.$LNG['Deuterium'].'</td><td style=\'width:50%;color:white\'>'. pretty_number($FleetRow['fleet_resource_deuterium']).'</td></tr>';
			if($FleetRow['fleet_resource_darkmatter'] > 0)
				$FRessource  .= '<tr><td style=\'width:50%;color:white\'>'.$LNG['Darkmatter'].'</td><td style=\'width:50%;color:white\'>'. pretty_number($FleetRow['fleet_resource_darkmatter']).'</td></tr>';
			$FRessource  .= '</table>';
			$MissionPopup  = '<a name="'.$FRessource.'" class="tooltip '.$FleetType.'">'.$Texte.'</a>';
		}
		else
			$MissionPopup  = $Texte;

		return $MissionPopup;
	}

	private function CreateFleetPopupedFleetLink($FleetRow, $Texte, $FleetType)
	{
		global $LNG;

		$FleetRec     = explode(';', $FleetRow['fleet_array']);
		$FleetPopup   = '<a href="#" name="';
		$FleetPopup  .= '<table style=\'width:200px\'>';
		if(!defined('IN_ADMIN'))
		{
			if($_SESSION['USER']['spy_tech'] < 2 && $FleetRow['fleet_owner'] != $_SESSION['id']) {
				$FleetPopup .= '<tr><td style=\'width:100%;color:white\'>'.$LNG['cff_no_fleet_data'].'</span></td></tr>';
			} elseif($_SESSION['USER']['spy_tech'] < 4 && $FleetRow['fleet_owner'] != $_SESSION['id']) {
				$FleetPopup .= '<tr><td style=\'width:100%;color:white\'>'.$LNG['cff_aproaching'].$FleetRow['fleet_amount'].$LNG['cff_ships'].'</td></tr>';
			} else {
				if($_SESSION['USER']['spy_tech'] < 8 && $FleetRow['fleet_owner'] != $_SESSION['id'])
					$FleetPopup .= '<tr><td style=\'width:100%;color:white\'>'.$LNG['cff_aproaching'].$FleetRow['fleet_amount'].$LNG['cff_ships'].':</td></tr>';

				foreach($FleetRec as $Item => $Group)
				{
					if (empty($Group))
						continue;
						
					$Ship    = explode(',', $Group);
					if($FleetRow['fleet_owner'] == $_SESSION['id'])
						$FleetPopup .= '<tr><td style=\'width:50%;color:white\'>'. $LNG['tech'][$Ship[0]] .':</td><td style=\'width:50%;color:white\'>'.pretty_number($Ship[1]).'</td></tr>';
					elseif($FleetRow['fleet_owner'] != $_SESSION['id'])
					{
						if($_SESSION['USER']['spy_tech'] >= 8)
							$FleetPopup .= '<tr><td style=\'width:50%;color:white\'>'. $LNG['tech'][$Ship[0]] .':</td><td style=\'width:50%;color:white\'>'.pretty_number($Ship[1]).'</td></tr>';
						else
							$FleetPopup .= '<tr><td style=\'width:100%;color:white\'>'. $LNG['tech'][$Ship[0]] .'</td></tr>';
						
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
					$Ship    = explode(',', $Group);
					$FleetPopup .= '<tr><td style=\'width:50%\' class=\'left\'><span style=\'color:white\'>'. $LNG['tech'][$Ship[0]] .':</span></td><td width=50% align=right><span style=\'color:white\'>'. pretty_number($Ship[1]) .'</span></td></tr>';
				}
			}
		}

		$FleetPopup  .= '</table>" class="tooltip '. $FleetType .'">'. $Texte .'</a>';

		return $FleetPopup;
	}
       
	public function GetNames($FleetRow)
	{
		global $db;
		return $db->uniquequery("SELECT ou.username as own_username, tu.username as target_username, op.name as own_planetname, tp.name as target_planetname
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
	    $GoodMissions	= array(3, 5);
		$MissionType    = $FleetRow['fleet_mission'];

		$Names		  	= $this->GetNames($FleetRow);
		$FleetPrefix    = ($Owner == true) ? 'own' : '';
		$FleetType		= $FleetPrefix.$FleetStyle[$MissionType];
		$FleetContent   = $this->CreateFleetPopupedFleetLink($FleetRow, (($MissionType == 1 || $MissionType == 2) && $FleetRow['fleet_owner'] != $_SESSION['id'] && $Status == 0 && $Owner == true) ? $LNG['cff_acs_fleet'] : $LNG['ov_fleet'], $FleetPrefix.$FleetStyle[$MissionType]);
		$FleetCapacity  = $this->CreateFleetPopupedMissionLink($FleetRow, $LNG['type_mission'][$MissionType], $FleetPrefix.$FleetStyle[$MissionType]);
		$FleetStatus    = array(0 => 'flight', 1 => 'return' , 2 => 'holding');
		$StartType		= $FleetRow['fleet_start_type'] == 1 ? $LNG['fcm_planet'] : $LNG['fcm_moon'];
		$TargetType		= $FleetRow['fleet_end_type'] == 1 ? $LNG['fcm_planet'] : $LNG['fcm_moon'];
	
		if ($MissionType == 8) {
			if ($Status == 0)
				$EventString = sprintf($LNG['cff_mission_own_recy_0'], $FleetContent, $StartType, $Names['own_planetname'], GetStartAdressLink($FleetRow, $FleetType), GetTargetAdressLink($FleetRow, $FleetType), $FleetCapacity);
			else
				$EventString = sprintf($LNG['cff_mission_own_recy_1'], $FleetContent, GetTargetAdressLink($FleetRow, $FleetType), $StartType, $Names['own_planetname'], GetStartAdressLink($FleetRow, $FleetType), $FleetCapacity);
		} elseif ($MissionType == 10) {
			if ($Owner)
				$EventString = sprintf($LNG['cff_mission_own_mip'], $FleetRow['fleet_amount'], $StartType, $Names['own_planetname'], GetStartAdressLink($FleetRow, $FleetType), $TargetType, $Names['target_planetname'], GetTargetAdressLink($FleetRow, $FleetType));
			else
				$EventString = sprintf($LNG['cff_mission_target_mip'], $FleetRow['fleet_amount'], $this->BuildHostileFleetPlayerLink($FleetRow, $Names), $StartType, $Names['own_planetname'], GetStartAdressLink($FleetRow, $FleetType), $TargetType, $Names['target_planetname'], GetTargetAdressLink($FleetRow, $FleetType));
		} elseif ($MissionType == 11 || $MissionType == 15) {		
			if ($Status == 0)
				$EventString = sprintf($LNG['cff_mission_own_expo_0'], $FleetContent, $StartType, $Names['own_planetname'], GetStartAdressLink($FleetRow, $FleetType), GetTargetAdressLink($FleetRow, $FleetType), $FleetCapacity);
			elseif ($Status == 2)
				$EventString = sprintf($LNG['cff_mission_own_expo_2'], $FleetContent, $StartType, $Names['own_planetname'], GetStartAdressLink($FleetRow, $FleetType), GetTargetAdressLink($FleetRow, $FleetType), $FleetCapacity);	
			else
				$EventString = sprintf($LNG['cff_mission_own_expo_1'], $FleetContent, GetTargetAdressLink($FleetRow, $FleetType), $StartType, $Names['own_planetname'], GetStartAdressLink($FleetRow, $FleetType), $FleetCapacity);	
		} else {
			if ($Owner == true) {
				if ($Status == 0) {
					if (($MissionType == 1 || $MissionType == 2) && $Status == 0 && $FleetRow['fleet_owner'] != $_SESSION['id'])
						$Message  = $LNG['cff_mission_acs']	;
					else
						$Message  = $LNG['cff_mission_own_0'];
						
					$EventString  = sprintf($Message, $FleetContent, $StartType, $Names['own_planetname'], GetStartAdressLink($FleetRow, $FleetType), $TargetType, $Names['target_planetname'], GetTargetAdressLink($FleetRow, $FleetType), $FleetCapacity);
				} elseif($Status == 1)
					$EventString  = sprintf($LNG['cff_mission_own_1'], $FleetContent, $TargetType, $Names['target_planetname'], GetTargetAdressLink($FleetRow, $FleetType), $StartType, $Names['own_planetname'], GetStartAdressLink($FleetRow, $FleetType), $FleetCapacity);		
				else
					$EventString  = sprintf($LNG['cff_mission_own_2'], $FleetContent, $StartType, $Names['own_planetname'], GetStartAdressLink($FleetRow, $FleetType), $TargetType, $Names['target_planetname'], GetTargetAdressLink($FleetRow, $FleetType), $FleetCapacity);	
			} else {
				if ($Status == 2)
					$Message	= $LNG['cff_mission_target_stay'];
				elseif(in_array($MissionType, $GoodMissions))
					$Message	= $LNG['cff_mission_target_good'];
				else
					$Message	= $LNG['cff_mission_target_bad'];

				$EventString	= sprintf($Message, $FleetContent, $this->BuildHostileFleetPlayerLink($FleetRow, $Names), $StartType, $Names['own_planetname'], GetStartAdressLink($FleetRow, $FleetType), $TargetType, $Names['target_planetname'], GetTargetAdressLink($FleetRow, $FleetType), $FleetCapacity);
			}		       
		}
		$EventString = '<span class="'.$FleetStatus[$Status].' '.$FleetType.'">'.$EventString.'</span>';
		if ($Status == 0)
			$Time	 = $FleetRow['fleet_start_time'];
		elseif ($Status == 1)
			$Time	 = $FleetRow['fleet_end_time'];
		elseif ($Status == 2)
			$Time	 = $FleetRow['fleet_end_stay'];
		$Rest	 = $Time - TIMESTAMP;
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
		return array('fleet_order' => 0, 'fleet_descr' => '', 'fleet_return'=> 0);
	}
}
?>