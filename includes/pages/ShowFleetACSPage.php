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

function ShowFleetACSPage($CurrentUser, $CurrentPlanet)
{
	global $resource, $pricelist, $reslist, $phpEx, $lang, $db;

	$parse			= $lang;
	$fleetid 		= request_var('fleetid',0);
	$addname		= request_var('addtogroup','');
	$aks_invited_mr	= request_var('aks_invited_mr',0);
	$add_member		= request_var('add_member_to_aks','');
	if (!is_numeric($fleetid) || empty($fleetid))
		exit(header("Location: game.".$phpEx."?page=fleet"));

	if($add_member != '')
	{
		$added_user_id_mr 	= 0;
		$member_qry_mr 		= $db->query("SELECT `id` FROM ".USERS." WHERE `username` ='".$db->sql_escape($addname)."' ;");

		while($row = $db->fetch_array($member_qry_mr))
		{
			$added_user_id_mr .= $row['id'];
		}

		if($added_user_id_mr > 0)
		{
			$new_eingeladen_mr = $aks_invited_mr.','.$added_user_id_mr;
			$db->query("UPDATE ".AKS." SET `eingeladen` = '".$db->sql_escape($new_eingeladen_mr)."' ;");
			$add_user_message_mr = "<font color=\"lime\">".$lang['fl_player']." ".$addname." ". $lang['fl_add_to_attack'];
		}
		else
		{
			$add_user_message_mr = "<font color=\"red\">".$lang['fl_player']." ".$addname." ".$lang['fl_dont_exist']."";
		}

		$invite_message = $lang['fl_player'] . $CurrentUser['username'] . $lang['fl_acs_invitation_message'];
		SendSimpleMessage ($added_user_id_mr, $CurrentUser['id'], time(), 1, $CurrentUser['username'], $lang['fl_acs_invitation_title'], $invite_message);
	}

	$query = $db->query("SELECT * FROM ".FLEETS." WHERE fleet_id = '" . $fleetid . "';");

	if ($db->num_rows($query) != 1)
		exit(header("Location: game.".$phpEx."?page=fleet"));

	$daten = $db->fetch_array($query);

	if ($daten['fleet_start_time'] <= time() || $daten['fleet_end_time'] < time() || $daten['fleet_mess'] == 1)
		exit(header("Location: game.".$phpEx."?page=fleet"));

	if (!isset($_POST['send']))
	{
		SetSelectedPlanet($CurrentUser);

		$galaxyrow 		= $CurrentPlanet;
		$maxfleet  		= $db->fetch_array($db->query("SELECT COUNT(fleet_owner) as ilosc FROM ".FLEETS." WHERE fleet_owner='".$CurrentUser['id']."';"));
		$maxfleet_count = $maxfleet["ilosc"];

		$fleet = $db->fetch_array($db->query("SELECT * FROM ".FLEETS." WHERE fleet_id = '" . $fleetid . "';"));

		if (empty($fleet['fleet_group']))
		{
			$rand 			= mt_rand(100000, 999999999);
			$aks_code_mr 	= "AG".$rand;
			$aks_invited_mr = $CurrentUser['id'];

			$db->query(
			"INSERT INTO ".AKS." SET
			`name` = '" . $aks_code_mr . "',
			`teilnehmer` = '" . $CurrentUser['id'] . "',
			`flotten` = '" . $fleetid . "',
			`ankunft` = '" . $fleet['fleet_start_time'] . "',
			`galaxy` = '" . $fleet['fleet_end_galaxy'] . "',
			`system` = '" . $fleet['fleet_end_system'] . "',
			`planet` = '" . $fleet['fleet_end_planet'] . "',
			`planet_type` = '" . $fleet['fleet_end_type'] . "',
			`eingeladen` = '" . $aks_invited_mr . "'
			");

			$aks = $db->fetch_array($db->query(
			"SELECT * FROM ".AKS." WHERE
			`name` = '" . $aks_code_mr . "' AND
			`teilnehmer` = '" . $CurrentUser['id'] . "' AND
			`flotten` = '" . $fleetid . "' AND
			`ankunft` = '" . $fleet['fleet_start_time'] . "' AND
			`galaxy` = '" . $fleet['fleet_end_galaxy'] . "' AND
			`system` = '" . $fleet['fleet_end_system'] . "' AND
			`planet` = '" . $fleet['fleet_end_planet'] . "' AND
			`eingeladen` = '" . $CurrentUser['id'] . "';
			"));

			$aks_madnessred = $db->query(
			"SELECT * FROM ".AKS." WHERE
			`name` = '" . $aks_code_mr . "' AND
			`teilnehmer` = '" . $CurrentUser['id'] . "' AND
			`flotten` = '" . $fleetid . "' AND
			`ankunft` = '" . $fleet['fleet_start_time'] . "' AND
			`galaxy` = '" . $fleet['fleet_end_galaxy'] . "' AND
			`system` = '" . $fleet['fleet_end_system'] . "' AND
			`planet` = '" . $fleet['fleet_end_planet'] . "' AND
			`eingeladen` = '" . $CurrentUser['id'] . "';
			");

			$db->query(
			"UPDATE ".FLEETS." SET
			fleet_group = '" . $aks['id'] . "'
			WHERE
			fleet_id = '" . $fleetid . "';");
			
		}
		else
		{
			$aks = $db->query("SELECT * FROM ".AKS." WHERE id = '" . $fleet['fleet_group'] . "';");
			$aks_madnessred = $aks;

			if ($db->num_rows($aks) != 1)
				exit(header("Location: game.".$phpEx."?page=fleet"));

			$aks = $db->num_rows($aks);
		}

		$missiontype = array(
				1 => $lang['type_mission'][1],
				2 => $lang['type_mission'][2],
				3 => $lang['type_mission'][3],
				4 => $lang['type_mission'][4],
				5 => $lang['type_mission'][5],
				6 => $lang['type_mission'][6],
				7 => $lang['type_mission'][7],
				8 => $lang['type_mission'][8],
				9 => $lang['type_mission'][9],
				15 => $lang['type_mission'][15],
				16 => $lang['type_mission'][16],
				17 => $lang['type_mission'][17],
				);

		$speed = array(
				10 => 100,
				9 => 90,
				8 => 80,
				7 => 70,
				6 => 60,
				5 => 50,
				4 => 40,
				3 => 30,
				2 => 20,
				1 => 10,
		);

		$galaxy 		= intval($_GET['galaxy']);
		$system 		= intval($_GET['system']);
		$planet 		= intval($_GET['planet']);
		$planettype 	= intval($_GET['planettype']);
		$target_mission = intval($_GET['target_mission']);

		if (!$galaxy)
			$galaxy = $CurrentPlanet['galaxy'];
		if (!$system)
			$system = $CurrentPlanet['system'];
		if (!$planet)
			$planet = $CurrentPlanet['planet'];
		if (!$planettype)
			$planettype = $CurrentPlanet['planet_type'];

		$ile 	= '' . (1 + $CurrentUser[$resource[108]]) + ($CurrentUser['rpg_commandant'] * COMMANDANT) . '';

		$parse['ile']	= $ile;

		$fq = $db->query("SELECT * FROM ".FLEETS." WHERE fleet_owner='$CurrentUser[id]' AND fleet_mission <> 10;");

		$i = 0;
		while ($f = $db->fetch_array($fq))
		{
			$i++;

			$page .= "<tr height=20><th>$i</th><th>";

			$page .= "<a title=\"\">".$missiontype[$f[fleet_mission]]."</a>";

			if (($f['fleet_start_time'] + 1) == $f['fleet_end_time'])
				$page .= " <a title=\"".$lang['fl_returning']."\">".$lang['fl_r']."</a>";

			$page .= "</th><th><a title=\"";

			$fleet = explode(";", $f['fleet_array']);
			$e = 0;
			foreach($fleet as $a => $b)
			{
				if ($b != '')
				{
					$e++;
					$a 		= explode(",", $b);
					$page  .= "{$lang['tech']{$a[0]}}: {$a[1]}\n";
					if ($e > 1)
						$page .= "\t";
				}
			}
			$page .= "\">" . pretty_number($f[fleet_amount]) . "</a></th>";
			$page .= "<th>[{$f[fleet_start_galaxy]}:{$f[fleet_start_system]}:{$f[fleet_start_planet]}]</th>";
			$page .= "<th>" . date("d. M Y H:i:s", $f['fleet_start_time']) . "</th>";
			$page .= "<th>[{$f[fleet_end_galaxy]}:{$f[fleet_end_system]}:{$f[fleet_end_planet]}]</th>";
			$page .= "<th>" . date("d. M Y H:i:s", $f['fleet_end_time']) . "</th>";
			$page .= " </form>";
			$page .= "<th><font color=\"lime\"><div id=\"time_0\"><font>" . pretty_time(floor($f['fleet_end_time'] + 1 - time())) . "</font></th><th>";

			if ($f['fleet_mess'] == 0)
			{
				$page .= "<form action=\"SendFleetBack.php\" method=\"post\">
				<input name=\"zawracanie\" value=" . $f['fleet_id'] . " type=hidden>
				<input value=\"".$lang['fl_send_back']."\" type=\"submit\">
				</form></th>";
			}
			else
				$page .= "&nbsp;</th>";

			$page .= "</div></font></tr>";
		}

		if ($i == 0)
			$page .= "<th>-</th><th>-</th><th>-</th><th>-</th><th>-</th><th>-</th><th>-</th><th>-</th><th>-</th>";

		$parse['page1']	= $page;

		if ($ile == $maxfleet_count)
			$maxflot = "<tr height=\"20\"><th colspan=\"9\"><font color=\"red\">".$lang['fl_no_more_slots']."</font></th></tr>";

		while($row = $db->fetch_array($aks_madnessred))
		{
			$aks_code_mr  	= $row['name'];
			$aks_invited_mr .= $row['eingeladen'];
		}

		$parse['maxflot']		= $maxflot;
		$parse['aks_code_mr']	= $aks_code_mr;

		$members = explode(",", $aks_invited_mr);
		foreach($members as $a => $b)
		{
			if ($b != '')
			{
				$member_qry_mr = $db->query("SELECT `username` FROM ".USERS." WHERE `id` ='".$b."' ;");
				while($row = $db->fetch_array($member_qry_mr))
				{
					$pageDos .= "<option>".$row['username']."</option>";
				}
			}
		}
		$parse['page2']					= isset($pageDos) ? $pageDos : "<option>".$CurrentUser['username']."</option>";
		$parse['fleetid']				= request_var('fleetid','');
		$parse['aks_invited_mr']		= $aks_invited_mr;
		$parse['add_user_message_mr']	= $add_user_message_mr;

		if (!$CurrentPlanet)
			exit(header("Location: game.".$phpEx."?page=fleet"));

		foreach($reslist['fleet'] as $n => $i)
		{
			if ($CurrentPlanet[$resource[$i]] > 0)
			{
				if ($i == 202 or $i == 203 or $i == 204 or $i == 209 or $i == 210)
					$pricelist[$i]['speed'] = $pricelist[$i]['speed'] + (($pricelist[$i]['speed'] * $CurrentUser['combustion_tech']) * 0.1);
				if ($i == 205 or $i == 206 or $i == 208 or $i == 211)
					$pricelist[$i]['speed'] = $pricelist[$i]['speed'] + (($pricelist[$i]['speed'] * $CurrentUser['impulse_motor_tech']) * 0.2);
				if ($i == 207 or $i == 213 or $i == 214 or $i == 215 or $i == 216)
					$pricelist[$i]['speed'] = $pricelist[$i]['speed'] + (($pricelist[$i]['speed'] * $CurrentUser['hyperspace_motor_tech']) * 0.3);

				$page3 .= '<tr height="20">
				<th><a title="'. $lang[fl_fleet_speed]. ': ' . $pricelist[$i]['speed'] . '">' . $lang['tech'][$i] . '</a></th>
				<th>' . pretty_number($CurrentPlanet[$resource[$i]]) . '
				<input type="hidden" name="maxship' . $i . '" value="' . $CurrentPlanet[$resource[$i]] . '"/></th>

				<input type="hidden" name="consumption' . $i . '" value="' . $pricelist[$i]['consumption'] . '"/>

				<input type="hidden" name="speed' . $i . '" value="' . $pricelist[$i]['speed'] . '" />
				<input type="hidden" name="galaxy" value="' . $galaxy . '"/>

				<input type="hidden" name="system" value="' . $system . '"/>
				<input type="hidden" name="planet" value="' . $planet . '"/>
				<input type="hidden" name="planet_type" value="' . $planettype . '"/>
				<input type="hidden" name="mission" value="' . $target_mission . '"/>
				</th>
				<input type="hidden" name="capacity' . $i . '" value="' . $pricelist[$i]['capacity'] . '" />
				</th>';
				if ($i == 212)
					$page3 .= '<th></th><th></th></tr>';
				else
				{
					$page3 .= '<th><a href="javascript:maxShip(\'ship' . $i . '\'); shortInfo();">'.$lang['fl_max'].'</a> </th>
					<th><input name="ship' . $i . '" size="10" value="0" onfocus="javascript:if(this.value == \'0\') this.value=\'\';" onblur="javascript:if(this.value == \'\') this.value=\'0\';" alt="' . $lang['tech'][$i] . $CurrentPlanet[$resource[$i]] . '"  onChange="shortInfo()" onKeyUp="shortInfo()"/></th>
					</tr>';
				}
				$have_ships = true;
			}
		}

		if (!$have_ships)
		{
			$page3 .= '<tr height="20">
			<th colspan="4">'.$lang['fl_no_ships'].'/th>
			</tr>
			<tr height="20">
			<th colspan="4">
			<input type="button" value="'.$lang['fl_continue'].'" enabled/></th>
			</tr>
			</table>
			</center>
			</form>';
		}
		else
		{
			$page3 .= '
			<tr height="20">
			<th colspan="2"><a href="javascript:noShips();shortInfo();noResources();" >'.$lang['fl_remove_all_ships'].'</a></th>
			<th colspan="2"><a href="javascript:maxShips();shortInfo();" >'.$lang['fl_select_all_ships'].'</a></th>
			</tr>';

			$przydalej = '<tr height="20"><th colspan="4"><input type="submit" value="'.$lang['fl_continue'].'" /></th></tr>';
			if ($ile == $maxfleet_count)
				$przydalej = '';
			$page3 .= '
			' . $przydalej . '
			<tr><th colspan="4">
			<br><center></center><br>
			</th></tr>
			</table>
			</center>
			</form>';
		}

		$parse['page3']	= $page3;
	}

	display(parsetemplate(gettemplate('fleet/fleetACS_table'), $parse));

}
?>