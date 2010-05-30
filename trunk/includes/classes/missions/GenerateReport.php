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

function GenerateReport($result_array, $steal_array, $moon_int, $moon_string, $time_float, $FleetRow, $LNG, $moondes = '', $ForSim = false)
{
	$html 		= "";
	
	if($moondes)
		$html 		.= $LNG['sys_destruc_title']." ".date("D M j H:i:s", $FleetRow['fleet_start_time']).".<br><br>";
	else
		$html 		.= $LNG['sys_attack_title']." ".date("D M j H:i:s", $FleetRow['fleet_start_time']).".<br><br>";
	
	$round_no 	= 1;
	$des = 0;
	foreach($result_array['rw'] as $round => $data1)
	{
		if($round_no > 6)
			break;
		
		$html 		.= $LNG['sys_attack_round']." ".$round_no." :<br><br>";
		$attackers1 = $data1['attackers'];
		$attackers2 = $data1['infoA'];
		$attackers3 = $data1['attackA'];
		$defenders1 = $data1['defenders'];
		$defenders2 = $data1['infoD'];
		$defenders3 = $data1['defenseA'];
		$coord4 	= 0;
		$coord5 	= 0;
		$coord6 	= 0;
		$html		.= "<table><tr>";
		foreach($attackers1 as $fleet_id1 => $data2)
		{
			$name 	= $data2['user']['username'];
			$coord1 = $data2['fleet']['fleet_start_galaxy'];
			$coord2 = $data2['fleet']['fleet_start_system'];
			$coord3 = $data2['fleet']['fleet_start_planet'];
			$weap 	= ($data2['user']['military_tech'] * 10);
			$shie 	= ($data2['user']['defence_tech'] * 10);
			$armr 	= ($data2['user']['shield_tech'] * 10);

			if($coord4 == 0){$coord4 += $data2['fleet']['fleet_end_galaxy'];}
			if($coord5 == 0){$coord5 += $data2['fleet']['fleet_end_system'];}
			if($coord6 == 0){$coord6 += $data2['fleet']['fleet_end_planet'];}

			$fl_info1  	= "<td><table><tr><th>";
			$fl_info1 	.= $LNG['sys_attack_attacker_pos']." ".$name." ([".$coord1.":".$coord2.":".$coord3."])<br>";
			$fl_info1 	.= $LNG['sys_ship_weapon']." ".$weap."% - ".$LNG['sys_ship_shield']." ".$shie."% - ".$LNG['sys_ship_armour']." ".$armr."%";
			$table1  	= "<table border=1 align=\"center\" width=\"100%\">";

			if (array_sum($data2['detail']) != 0)
			{
				$ships1  = "<tr><th>".$LNG['sys_ship_type']."</th>";
				$count1  = "<tr><th>".$LNG['sys_ship_count']."</th>";

				foreach($data2['detail'] as $ship_id1 => $ship_count1)
				{
					if ($ship_count1 <= 0)
						continue;

					$ships1 .= "<th>[ship[".$ship_id1."]]</th>";
					$count1 .= "<th>".pretty_number($ship_count1)."</th>";
				}

				$ships1 .= "</tr>";
				$count1 .= "</tr>";
			}
			else
			{
				$des = 1;
				$ships1 = "<tr><br><br>". $LNG['sys_destroyed']."<br></tr>";
				$count1 = "";
			}

			$info_part1[$fleet_id1] = $fl_info1.$table1.$ships1.$count1;
		}

		foreach($attackers2 as $fleet_id2 => $data3)
		{
			$weap1  = "<tr><th>".$LNG['sys_ship_weapon']."</th>";
			$shields1  = "<tr><th>".$LNG['sys_ship_shield']."</th>";
			$armour1  = "<tr><th>".$LNG['sys_ship_armour']."</th>";
			foreach($data3 as $ship_id2 => $ship_points1)
			{
				if($ship_points1['shield'] <= 0)
					continue;

				$weap1 		.= "<th>".pretty_number($ship_points1['att'])."</th>";
				$shields1 	.= "<th>".pretty_number($ship_points1['def'])."</th>";
				$armour1 	.= "<th>".pretty_number($ship_points1['shield'])."</th>";
			}

			$weap1 		.= "</tr>";
			$shields1 	.= "</tr>";
			$armour1 	.= "</tr>";
			$endtable1 	= "</table></th></tr></table></td>";

			$info_part2[$fleet_id2] = $weap1.$shields1.$armour1.$endtable1;

			if (array_sum($attackers1[$fleet_id2]['detail']) != 0)
			{
				$html .= $info_part1[$fleet_id2].$info_part2[$fleet_id2];
			}
			else
			{
				$html .= $info_part1[$fleet_id2];
				$html .= "</table></th></tr></table><br><br>";
			}
		}
		
		$html .= "</tr></table>";
		$html .= "<br><br>";
		$html .= "<table><tr>";
		foreach( $defenders1 as $fleet_id1 => $data2)
		{
			$name = $data2['user']['username'];
			$weap = ($data2['user']['military_tech'] * 10);
			$shie = ($data2['user']['defence_tech'] * 10);
			$armr = ($data2['user']['shield_tech'] * 10);

			$fl_info1  = "<td><table><tr><th>";
			$fl_info1 .= $LNG['sys_attack_defender_pos']." ".$name." ([".$coord4.":".$coord5.":".$coord6."])<br>";
			$fl_info1 .= $LNG['sys_ship_weapon']." ".$weap."% - ".$LNG['sys_ship_shield']." ".$shie."% - ".$LNG['sys_ship_armour']." ".$armr."%";

			$table1  = "<table border=1 align=\"center\" width=\"100%\">";

			if (array_sum($data2['def']) != 0)
			{
				$ships1  = "<tr><th>".$LNG['sys_ship_type']."</th>";
				$count1  = "<tr><th>".$LNG['sys_ship_count']."</th>";

				foreach($data2['def'] as $ship_id1 => $ship_count1)
				{
					if ($ship_count1 == 0)
						continue;

					$ships1 .= "<th>[ship[".$ship_id1."]]</th>";
					$count1 .= "<th>".pretty_number($ship_count1)."</th>";
				}

				$ships1 .= "</tr>";
				$count1 .= "</tr>";
			}
			else
			{
				$des = 1;
				$ships1 = "<tr><br><br>". $LNG['sys_destroyed']."<br></tr>";
				$count1 = "";
			}

			$info_part1[$fleet_id1] = $fl_info1.$table1.$ships1.$count1;
		}

		foreach($defenders2 as $fleet_id2 => $data3)
		{
			$weap1  	= "<tr><th>".$LNG['sys_ship_weapon']."</th>";
			$shields1  	= "<tr><th>".$LNG['sys_ship_shield']."</th>";
			$armour1  	= "<tr><th>".$LNG['sys_ship_armour']."</th>";

			foreach( $data3 as $ship_id2 => $ship_points1)
			{
				if($ship_points1['shield'] > 0)
				{
					$weap1 .= "<th>".pretty_number($ship_points1['att'])."</th>";
					$shields1 .= "<th>".pretty_number($ship_points1['def'])."</th>";
					$armour1 .= "<th>".pretty_number($ship_points1['shield'])."</th>";
				}
			}

			$weap1 		.= "</tr>";
			$shields1 	.= "</tr>";
			$armour1 	.= "</tr>";
			$endtable1 	= "</table></th></tr></table>";

			$info_part2[$fleet_id2] = $weap1.$shields1.$armour1.$endtable1;

			if (array_sum($defenders1[$fleet_id2]['def']) != 0)
			{
				$html .= $info_part1[$fleet_id2].$info_part2[$fleet_id2];
				$html .= "<br><br>";
			}
			else
			{
				$html .= $info_part1[$fleet_id2];
				$html .= "</table></th></tr></table><br><br>";
			}
		}
				
		$html .= "</tr></table>";
		if ($des) break;
				
		$html .=  $LNG['fleet_attack_1']." ".pretty_number($data1['attack']['total'])." ".$LNG['fleet_attack_2']." ".pretty_number(min($data1['defShield'], $data1['attack']['total']))." ".$LNG['damage']."<br>";
		$html .= $LNG['fleet_defs_1']." ".pretty_number($data1['defense']['total'])." ".$LNG['fleet_defs_2']." ".pretty_number(min($data1['attackShield'], $data1['defense']['total']))." ".$LNG['damage']."<br><br>";
		$round_no++;			
	}

	if ($result_array['won'] == "r")
	{
		$result1  = $LNG['sys_defender_won']."<br>";
	}
	elseif ($result_array['won'] == "a")
	{
		$result1  = $LNG['sys_attacker_won']."<br>";
		$result1 .= $LNG['sys_stealed_ressources']." ".pretty_number($steal_array['metal'])." ".$LNG['Metal'].", ".pretty_number($steal_array['crystal'])." ".$LNG['Crystal']." ".$LNG['and']." ".pretty_number($steal_array['deuterium'])." ".$LNG['Deuterium']."<br>";
	}
	else
	{
		$result1  = $LNG['sys_both_won'].".<br>";
	}

	$html .= "<br><br>";
	$html .= $result1;
	$html .= "<br>";

	$debirs_meta = pretty_number($result_array['debree']['att'][0] + $result_array['debree']['def'][0]);
	$debirs_crys = pretty_number($result_array['debree']['att'][1] + $result_array['debree']['def'][1]);

	$html .= $LNG['sys_attacker_lostunits']." ".pretty_number($result_array['lost']['att'])." ".$LNG['sys_units']."<br>";
	$html .= $LNG['sys_defender_lostunits']." ".pretty_number($result_array['lost']['def'])." ".$LNG['sys_units']."<br>";
	$html .= $LNG['debree_field_1']." ".$debirs_meta." ".$LNG['Metal']." ".$LNG['sys_and']." ".$debirs_crys." ".$LNG['Crystal']." ".$LNG['debree_field_2']."<br><br>";
		
	if($moondes)
	{
		$html .= $moondes;
	} else {
		$html .= $LNG['sys_moonproba']." ".$moon_int." %<br>";
		$html .= $moon_string."<br><br>";
	}
		
	if($ForSim)
	{
		$html .= $ForSim;
	}
	return $html;
}
	
?>