<?php

if(!defined('INSIDE')){ die(header("location:../../"));}

class FlyingFleetsTable
{
    private function BuildHostileFleetPlayerLink($FleetRow, $Names)
    {
		global $LNG, $USER;

		return $Names['own_username'].' <a href="javascript:f(\'game.php?page=messages&amp;mode=write&amp;id='.$FleetRow['fleet_owner'].'\',\'\');"><img src="'.$USER['dpath'].'img/m.gif" title="'.$LNG['write_message'].'" border="0" alt=""></a>';
	}

	// For ShowFlyingFleets.php in admin panel.
	public function BuildFlyingFleetTable()
	{
		global $LNG, $db;
		$Table	= array();
		
		$FlyingFleets = $db->query("SELECT * FROM ".FLEETS." ORDER BY `fleet_end_time` ASC;");

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
			
			if($CurrentFleet['fleet_busy'] == 0)
				$Bloc['lock']	= "<a href='?id=".$CurrentFleet['fleet_id']."&lock=1'><font color='red'>".$LNG['ff_lock']."</font></a>";
			else
				$Bloc['lock']	= "<a href='?id=".$CurrentFleet['fleet_id']."&lock=0'><font color='green'>".$LNG['ff_unlock']."</font></a>";
			
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
			$FRessource  .= "<tr><td width=50% align=left><font color=white>".$LNG['Metal']."<font></td><td width=50% align=right><font color=white>". pretty_number($FleetRow['fleet_resource_metal']) ."<font></td></tr>";
			$FRessource  .= "<tr><td width=50% align=left><font color=white>".$LNG['Crystal']."<font></td><td width=50% align=right><font color=white>". pretty_number($FleetRow['fleet_resource_crystal']) ."<font></td></tr>";
			$FRessource  .= "<tr><td width=50% align=left><font color=white>".$LNG['Deuterium']."<font></td><td width=50% align=right><font color=white>". pretty_number($FleetRow['fleet_resource_deuterium']) ."<font></td></tr>";
			if($FleetRow['fleet_resource_darkmatter'] > 0)
				$FRessource  .= "<tr><td width=50% align=left><font color=white>".$LNG['Darkmatter']."<font></td><td width=50% align=right><font color=white>". pretty_number($FleetRow['fleet_resource_darkmatter']) ."<font></td></tr>";
			$FRessource  .= "</table>";
			$MissionPopup  = "<a href='#' onmouseover=\"return overlib('". $FRessource ."');";
			$MissionPopup .= "\" onmouseout=\"return nd();\" class=\"". $FleetType ."\">" . $Texte ."</a>";
		}
		else
			$MissionPopup  = $Texte;

		return $MissionPopup;
	}

	private function CreateFleetPopupedFleetLink($FleetRow, $Texte, $FleetType)
	{
		global $LNG, $USER;

		$FleetRec     = explode(";", $FleetRow['fleet_array']);
		$FleetPopup   = "<a href='#' onmouseover=\"return overlib('";
		$FleetPopup  .= "<table width=200>";
		if(!defined('IN_ADMIN'))
		{
			if($USER['spy_tech'] < 2 && $FleetRow['fleet_owner'] != $USER['id'])
			{
				$FleetPopup .= "<tr><td width=50% align=left><font color=white>".$LNG['cff_no_fleet_data']."<font></td></tr>";
			}
			elseif($USER['spy_tech'] >= 2 && $USER['spy_tech'] < 4 && $FleetRow['fleet_owner'] != $USER['id'])
			{
				$FleetPopup .= "<tr><td width=50% align=left><font color=white>".$LNG['cff_aproaching'].$FleetRow['fleet_amount'].$LNG['cff_ships']."<font></td></tr>";
			}
			else
			{
				if($FleetRow['fleet_owner'] != $USER['id'])
					$FleetPopup .= "<tr><td width=100% align=left><font color=white>".$LNG['cff_aproaching'].$FleetRow['fleet_amount'].$LNG['cff_ships'].":<font></td></tr>";

				foreach($FleetRec as $Item => $Group)
				{
					if ($Group  != '')
					{
						$Ship    = explode(",", $Group);
						if($FleetRow['fleet_owner'] == $USER['id'])
							$FleetPopup .= "<tr><td width=50% align=left><font color=white>". $LNG['tech'][$Ship[0]] .":<font></td><td width=50% align=right><font color=white>". pretty_number($Ship[1]) ."<font></td></tr>";
						elseif($FleetRow['fleet_owner'] != $USER['id'])
						{
							if($USER['spy_tech'] >= 4 && $USER['spy_tech'] < 8)
								$FleetPopup .= "<tr><td width=50% align=left><font color=white>". $LNG['tech'][$Ship[0]] ."<font></td></tr>";
							elseif($USER['spy_tech'] >= 8)
								$FleetPopup .= "<tr><td width=50% align=left><font color=white>". $LNG['tech'][$Ship[0]] .":<font></td><td width=50% align=right><font color=white>". pretty_number($Ship[1]) ."<font></td></tr>";
						}
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
					$FleetPopup .= "<tr><td width=50% align=left><font color=white>". $LNG['tech'][$Ship[0]] .":<font></td><td width=50% align=right><font color=white>". pretty_number($Ship[1]) ."<font></td></tr>";
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
		tu.username as target_username,
		op.name as own_planetname,
		tp.name as target_planetname
		FROM ".USERS." as ou
		LEFT JOIN ".USERS." tu ON tu.id = '".$FleetRow['fleet_target_owner']."'
		LEFT JOIN ".PLANETS." op ON op.`galaxy` = '".$FleetRow['fleet_start_galaxy']."' AND op.`system` = '".$FleetRow['fleet_start_system']."' AND op.`planet` = '".$FleetRow['fleet_start_planet']."' AND op.`planet_type` = '".$FleetRow['fleet_start_type']."'
		LEFT JOIN ".PLANETS." tp ON tp.`galaxy` = '".$FleetRow['fleet_end_galaxy']."' AND tp.`system` = '".$FleetRow['fleet_end_system']."' AND tp.`planet` = '".$FleetRow['fleet_end_planet']."' AND tp.`planet_type` = '".$FleetRow['fleet_end_type']."'
		WHERE ou.id = '".$FleetRow['fleet_owner']."';");
	}
       
	public function GetEventString($FleetRow, $Status, $Owner, $Label, $Record)
	{
		global $LNG, $USER;
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
		$FleetContent   = $this->CreateFleetPopupedFleetLink($FleetRow, (($MissionType == 1 || $MissionType == 2) && $FleetRow['fleet_owner'] != $USER['id'] && $Status == 0 && $Owner == true) ? $LNG['cff_acs_fleet'] : $LNG['ov_fleet'], $FleetPrefix.$FleetStyle[$MissionType]);
		$FleetCapacity  = $this->CreateFleetPopupedMissionLink($FleetRow, $LNG['type_mission'][$MissionType], $FleetPrefix.$FleetStyle[$MissionType]);
		$StartType      = $FleetRow['fleet_start_type'];
		$TargetType     = $FleetRow['fleet_end_type'];
		$FleetGroup     = $FleetRow['fleet_group'];
		$FleetStatus    = array ( 0 => 'flight', 1 => 'return' , 2 => 'holding');


		if (($MissionType == 1 || $MissionType == 2) && $FleetRow['fleet_owner'] != $USER['id'] && $Status == 0 && $Owner == true)
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
				if (($MissionType == 1 || $MissionType == 2) && $Status == 0 && $FleetRow['fleet_owner'] != $USER['id']) {
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
				$FleetInfo['fleet_return'] = date('G:i:s', $FleetRow['fleet_start_time']);
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
				$FleetInfo['fleet_return'] = date('G:i:s', $FleetRow['fleet_end_time']);
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
				$FleetInfo['fleet_return'] = date('G:i:s', $FleetRow['fleet_end_stay']);
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
	       
		if ($isAKS == true && $Status == 0 && ($FleetRow['fleet_mission'] == 1 || $FleetRow['fleet_mission'] == 2) && $FleetRow['fleet_group'] != 0)
		{
			$AKSFleets	      = $db->query("SELECT * FROM ".FLEETS." WHERE `fleet_group` = '".$FleetRow['fleet_group']."' ORDER BY `fleet_id` ASC;");
			$EventString	    = '';
			while($AKSRow = $db->fetch_array($AKSFleets))
			{
				$Return	  = $this->GetEventString($AKSRow, $Status, $Owner, $Label, $Record);
				$Rest	    = $Return[0];
				$EventString    .= $Return[1].'<br><br>';
				$Time			= $Return[2];
			}
			$db->free_result($AKSFleets);
		} else {
			list($Rest, $EventString, $Time) = $this->GetEventString($FleetRow, $Status, $Owner, $Label, $Record);
			$EventString    .= '<br><br>';
		}

		$FleetInfo['fleet_javai']  = InsertJavaScriptChronoApplet ( $Label, $Record, $Rest, true );
		$FleetInfo['fleet_order']  = $Label . $Record;
		$FleetInfo['fleet_descr']  = substr($EventString, 0, -8);
		$FleetInfo['fleet_javas']  = InsertJavaScriptChronoApplet ( $Label, $Record, $Rest, false );
		$FleetInfo['fleet_return'] = date('G:i:s', $Time);

		return $FleetInfo;
	}
}
?>