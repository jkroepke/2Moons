<?php

##############################################################################
# *                                                                          #
# * 2MOONS                                                                   #
# *                                                                          #
# * @copyright Copyright (C) 2010 By ShadoX from titanspace.org              #
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

class MissionCaseSpy extends MissionFunctions
{
		
	function __construct($Fleet)
	{
		$this->_fleet	= $Fleet;
	}
	
	function TargetEvent()
	{
		global $db;
		$LNG			     = $this->GetUserLang($this->_fleet['fleet_owner']);
		$LNG			     += $this->GetUserLang($this->_fleet['fleet_owner'], 'TECH');
		
		$CurrentUser         = $db->uniquequery("SELECT spy_tech,rpg_espion FROM ".USERS." WHERE `id` = '".$this->_fleet['fleet_owner']."';");
		$CurrentUserID       = $this->_fleet['fleet_owner'];
		$QryGetTargetPlanet  = "SELECT * FROM ".PLANETS." ";
		$QryGetTargetPlanet .= "WHERE ";
		$QryGetTargetPlanet .= "`galaxy` = '". $this->_fleet['fleet_end_galaxy'] ."' AND ";
		$QryGetTargetPlanet .= "`system` = '". $this->_fleet['fleet_end_system'] ."' AND ";
		$QryGetTargetPlanet .= "`planet` = '". $this->_fleet['fleet_end_planet'] ."' AND ";
		$QryGetTargetPlanet .= "`planet_type` = '". $this->_fleet['fleet_end_type'] ."';";
		$TargetPlanet        = $db->uniquequery($QryGetTargetPlanet);
		$TargetUserID        = $TargetPlanet['id_owner'];
		$CurrentPlanet       = $db->uniquequery("SELECT name,system,galaxy,planet FROM ".PLANETS." WHERE `galaxy` = '".$this->_fleet['fleet_start_galaxy']."' AND `system` = '".$this->_fleet['fleet_start_system']."' AND `planet` = '".$this->_fleet['fleet_start_planet']."';");
		$CurrentSpyLvl       = max(($CurrentUser['spy_tech'] + ($CurrentUser['rpg_espion'] * ESPION)), 1);
		$TargetUser          = $db->uniquequery("SELECT * FROM ".USERS." WHERE `id` = '".$TargetUserID."';");
		$TargetSpyLvl        = max(($TargetUser['spy_tech'] + ($TargetUser['rpg_espion'] * ESPION)), 1);
		$fleet               = explode(";", $this->_fleet['fleet_array']);
			
		require_once(ROOT_PATH.'includes/classes/class.PlanetRessUpdate.'.PHP_EXT);
		
		$PlanetRess = new ResourceUpdate();
		list($TargetUser, $TargetPlanet)	= $PlanetRess->CalcResource($TargetUser, $TargetPlanet, true, $this->_fleet['fleet_start_time']);

		foreach ($fleet as $a => $b)
		{
			if (empty($b))
				continue;

			$a = explode(",", $b);
			if ($a[0] != 210)
				continue;

			$LS		= $a[1];
			break;
		}


		$Diffence	 = abs($CurrentSpyLvl - $TargetSpyLvl);
		$MinAmount 	 = ($CurrentSpyLvl > $TargetSpyLvl) ? -1 * pow($Diffence, 2) : pow($Diffence, 2);
		$SpyFleet	 = ($LS >= $MinAmount) ? true : false;
		$SpyDef		 = ($LS >= $MinAmount + 1) ? true : false;
		$SpyBuild	 = ($LS >= $MinAmount + 3) ? true : false;
		$SpyTechno	 = ($LS >= $MinAmount + 5) ? true : false;
		
		$MaterialsInfo    	= $this->SpyTarget($TargetPlanet, 0, $LNG['sys_spy_maretials'], $LNG);
		$GetSB	    		= $MaterialsInfo['String'];
		$Array				= $MaterialsInfo['Array'];
		$Count				= array();
			
		if($SpyFleet){
			$PlanetFleetInfo  = $this->SpyTarget($TargetPlanet, 1, $LNG['sys_spy_fleet'], $LNG);
			$GetSB     		 .= $PlanetFleetInfo['String'];
			$Count['Fleet']	  = $PlanetFleetInfo['Count'];
			$Array			  = $Array + $PlanetFleetInfo['Array'];
		}
		if($SpyDef){
			$PlanetDefenInfo  = $this->SpyTarget($TargetPlanet, 2, $LNG['sys_spy_defenses'], $LNG);
			$GetSB	    	 .= $PlanetDefenInfo['String'];
			$Count['Def']	  = $PlanetDefenInfo['Count'];
			$Array			  = $Array + $PlanetDefenInfo['Array'];
		}
		if($SpyBuild){
			$PlanetBuildInfo  = $this->SpyTarget($TargetPlanet, 3, $LNG['tech'][0], $LNG);
			$GetSB	    	 .= $PlanetBuildInfo['String'];
		}
		if($SpyTechno){
			$TargetTechnInfo  = $this->SpyTarget($TargetUser, 4, $LNG['tech'][100], $LNG);
			$GetSB		  	 .= $TargetTechnInfo['String'];
			$Array			  = $Array + $TargetTechnInfo['Array'];
		}
		
		foreach($Array as $ID => $Amount)
		{
			$string .= "&amp;im[".$ID."]=".$Amount;
		}
			
		if(array_sum($Count) == 0){
			$TargetChances	= 0;
			$SpyerChances	= 1; 
		} else {
			$TargetChances 	= mt_rand(0, min(($LS/4) * ($TargetSpyLvl / $CurrentSpyLvl), 100));
			$SpyerChances  	= mt_rand(0, 100);
		}
		
		if ($TargetChances >= $SpyerChances)
			$DestProba = $LNG['sys_mess_spy_destroyed'];
		else
			$DestProba = sprintf( $LNG['sys_mess_spy_lostproba'], $TargetChances);

		$AttackLink  = "<center>";
		$AttackLink .= "<a href=\"game.php?page=fleet&amp;galaxy=". $this->_fleet['fleet_end_galaxy'] ."&amp;system=". $this->_fleet['fleet_end_system'] ."";
		$AttackLink .= "&amp;planet=".$this->_fleet['fleet_end_planet']."&amp;planettype=".$this->_fleet['fleet_end_type']."";
		$AttackLink .= "&amp;target_mission=1";
		$AttackLink .= " \">". $LNG['type_mission'][1];
		$AttackLink .= "</a></center>";
		$MessageEnd  = "<center>".$DestProba."<br>".((ENABLE_SIMULATOR_LINK == true) ? "<a href=\"game.php?page=battlesim".$string."\">".$LNG['fl_simulate']."</a>":"")."</center>";
			
		$SpyMessage = "<br>".$GetSB."<br>".$AttackLink.$MessageEnd;
		SendSimpleMessage($CurrentUserID, '', $this->_fleet['fleet_start_time'], 0, $LNG['sys_mess_qg'], $LNG['sys_mess_spy_report'], $SpyMessage);
		$TargetMessage  = $LNG['sys_mess_spy_ennemyfleet'] ." ". $CurrentPlanet['name'];

		if($this->_fleet['fleet_start_type'] == 3)
			$TargetMessage .= $LNG['sys_mess_spy_report_moon'].' ';

		$TargetMessage .= "<a href=\"game.php?page=galaxy&mode=3&galaxy=". $CurrentPlanet["galaxy"] ."&system=". $CurrentPlanet["system"] ."\">";
		$TargetMessage .= "[". $CurrentPlanet["galaxy"] .":". $CurrentPlanet["system"] .":". $CurrentPlanet["planet"] ."]</a> ";
		$TargetMessage .= $LNG['sys_mess_spy_seen_at'] ." ". $TargetPlanet['name'];
		$TargetMessage .= " [". $TargetPlanet["galaxy"] .":". $TargetPlanet["system"] .":". $TargetPlanet["planet"] ."] ". $LNG['sys_mess_spy_seen_at2'] .".";

		SendSimpleMessage($TargetUserID, '', $this->_fleet['fleet_start_time'], 0, $LNG['sys_mess_spy_control'], $LNG['sys_mess_spy_activity'], $TargetMessage);

		if ($TargetChances >= $SpyerChances)
		{
			$Qry  = "UPDATE ".PLANETS." SET ";
			$Qry .= "`der_crystal` = `der_crystal` + '".($LS * 300)."' ";
			$Qry .= "WHERE `galaxy` = '". $TargetPlanet['galaxy'] ."' AND ";
			$Qry .= "`system` = '". $TargetPlanet['system'] ."' AND ";
			$Qry .= "`planet` = '". $TargetPlanet['planet'] ."' AND ";
			$Qry .= "`planet_type` = '1';";
			
			$db->query($Qry);
			$this->KillFleet();
		}
		else
		{
			$this->UpdateFleet('fleet_mess', 1);
			$this->SaveFleet();
		}
	}
	
	function EndStayEvent()
	{
		return;
	}
	
	function ReturnEvent()
	{	
		$this->RestoreFleet();
	}
	
	private function SpyTarget($TargetPlanet, $Mode, $TitleString, $LNG)
	{
		global $resource, $db;

		$LookAtLoop = true;
		if ($Mode == 0)
		{
			$String  = '<table style="width:100%;"><tr><th colspan="5">'.$TitleString.' '.$TargetPlanet['name'];
			$String .= ' <a href="game.php?page=galaxy&mode=3&galaxy='. $TargetPlanet['galaxy'] .'&system='. $TargetPlanet['system']. '">';
			$String .= '['. $TargetPlanet['galaxy'] .':'. $TargetPlanet['system'] .':'. $TargetPlanet['planet'] .']</a>';
			$String .= ' von '. date('d. M Y H:i:s', $this->_fleet['fleet_start_time']) .'</th>';
			$String .= '</tr><tr>';
			$String .= '<td style="width:25%;" class="left transparent">'. $LNG['Metal']     .'</td><td style="width:25%;" class="left transparent">'. pretty_number($TargetPlanet['metal'])      .'</td><td class="transparent">&nbsp;</td>';
			$String .= '<td style="width:25%;" class="left transparent">'. $LNG['Crystal']   .'</td><td style="width:25%;" class="left transparent">'. pretty_number($TargetPlanet['crystal'])    .'</td>';
			$String .= '</tr><tr>';
			$String .= '<td style="width:25%;" class="left transparent">'. $LNG['Deuterium'] .'</td><td style="width:25%;" class="left transparent">'. pretty_number($TargetPlanet['deuterium'])  .'</td><td class="transparent">&nbsp;</td>';
			$String .= '<td style="width:25%;" class="left transparent">'. $LNG['Energy']    .'</td><td style="width:25%;" class="left transparent">'. pretty_number($TargetPlanet['energy_max']) .'</td>';
			$String .= '</tr>';
			$Array[1]	= $TargetPlanet['metal'];
			$Array[2]	= $TargetPlanet['crystal'];
			$Array[3]	= $TargetPlanet['deuterium'];
			
			$LookAtLoop = false;
		}
		elseif ($Mode == 1)
		{
			$ResFrom[0] = 200;
			$ResTo[0]   = 299;
			$Loops      = 1;
		}
		elseif ($Mode == 2)
		{
			$ResFrom[0] = 400;
			$ResTo[0]   = 499;
			$ResFrom[1] = 500;
			$ResTo[1]   = 599;
			$Loops      = 2;
		}
		elseif ($Mode == 3)
		{
			$ResFrom[0] = 1;
			$ResTo[0]   = 99;
			$Loops      = 1;
		}
		elseif ($Mode == 4)
		{
			$ResFrom[0] = 100;
			$ResTo[0]   = 199;
			$Loops      = 1;
		}
	
		if ($Mode == 1)
		{
			$def = $db->query('SELECT * FROM '.FLEETS.' WHERE `fleet_mission` = 5 AND `fleet_end_galaxy` = '. $this->_fleet['fleet_end_galaxy'] .' AND `fleet_end_system` = '. $this->_fleet['fleet_end_system'] .' AND `fleet_end_type` = '. $this->_fleet['fleet_end_type'] .' AND `fleet_end_planet` = '. $this->_fleet['fleet_end_planet'] .' AND fleet_start_time<'.TIMESTAMP.' AND fleet_end_stay>='.TIMESTAMP.';');
			while ($defRow = $db->fetch_array($def))
			{
				$defRowDef = explode(';', $defRow['fleet_array']);
				foreach ($defRowDef as $Element)
				{
					$Element = explode(',', $Element);

					if ($Element[0] < 100) continue;

					if (!isset($TargetPlanet[$resource[$Element[0]]]))
						$TargetPlanet[$resource[$Element[0]]] = 0;

					$TargetPlanet[$resource[$Element[0]]] += $Element[1];
				}
			}
		}
		
		if ($LookAtLoop == true)
		{
			$String  	 = '<table style="width:100%;"><tr><th colspan="'. ((2 * SPY_REPORT_ROW) + (SPY_REPORT_ROW - 1)).'">'. $TitleString .'</th></tr>';
			$Count       = 0;
			$CurrentLook = 0;
			while ($CurrentLook < $Loops)
			{
				$row     = 0;
				for ($Item = $ResFrom[$CurrentLook]; $Item <= $ResTo[$CurrentLook]; $Item++)
				{
					if ($TargetPlanet[$resource[$Item]] <= 0)
						continue;

					if ($row == 0)
						$String  .= "<tr>";

					$String  .= '<td style="width:25%;" class="left transparent">'.$LNG['tech'][$Item].'</td><td style="width:25%;" class="left transparent">'.$TargetPlanet[$resource[$Item]].'</td>';
						
					$Array[$Item]	=  $TargetPlanet[$resource[$Item]];
					$Count			+=  $TargetPlanet[$resource[$Item]];
					$row++;
					if ($row == SPY_REPORT_ROW)
					{
						$String  .= '</tr>';
						$row      = 0;
					} else {
						$String  .= '<td class="transparent">&nbsp;</td>';
					}
				}

				while ($row != 0)
				{
					$String  	.= '<td class="transparent">&nbsp;</td><td class="transparent">&nbsp;</td>';
					$row++;
					if ($row == SPY_REPORT_ROW)
					{
						$String  .= '</tr>';
						$row      = 0;
					}
				}
				$CurrentLook++;
			}
		}
		
		$String .= '</table>';

		$return['String'] = $String;
		$return['Array']  = (is_array($Array) ? $Array : array());
		$return['Count']  = $Count;

		return $return;
	}
}

?>