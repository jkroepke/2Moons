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

function ShowFleetShortcuts($CurrentUser)
{
	global $lang, $db;

	$a = request_var('a','');
	$mode = request_var('mode', '');
	if ($mode == "add")
	{
		if ($_POST)
		{
			if ($_POST["n"] == "")
				$_POST["n"] = $lang['fl_anonymous'];

			$r = strip_tags($_POST[n]) . "," . intval($_POST[g]) . "," . intval($_POST[s]) . "," . intval($_POST[p]) . "," . intval($_POST[t]) . "\r\n";
			$CurrentUser['fleet_shortcut'] .= $r;
			$db->query("UPDATE ".USERS." SET fleet_shortcut='".$CurrentUser['fleet_shortcut']."' WHERE id=".$CurrentUser['id'].";");
			header("location:game.".PHP_EXT."?page=shortcuts");
		}

		$page = "<div id=\"content\"><form method=POST><table border=0 cellpadding=0 cellspacing=1 width=519>
				<tr height=20>
				<td colspan=2 class=c>".$lang['fl_shortcut_add_title']."</td>
				</tr><tr height=\"20\"><th>
				<input type=text name=n value=\"$g\" size=32 maxlength=32 title=\"".$lang['fl_shortcut_name']."\">
				<input type=text name=g value=\"$s\" size=3 maxlength=1 title=\"".$lang['fl_shortcut_galaxy']."\">
				<input type=text name=s value=\"$p\" size=3 maxlength=3 title=\"".$lang['fl_shortcut_solar_system']."\">
				<input type=text name=p value=\"$t\" size=3 maxlength=3 title=\"".$lang['fl_planet']."\">
				<select name=t>";
		$page .= '<option value="1"' . (($c[4] == 1)?" SELECTED":"") . ">".$lang['fl_planet']."</option>";
		$page .= '<option value="2"' . (($c[4] == 2)?" SELECTED":"") . ">".$lang['fl_debris']."</option>";
		$page .= '<option value="3"' . (($c[4] == 3)?" SELECTED":"") . ">".$lang['fl_moon']."</option>";
		$page .= "</select>
				</th></tr><tr>
				<th><input type=\"reset\" value=\"".$lang['fl_clean']."\"> <input type=\"submit\" value=\"".$lang['fl_register_shorcut']."\">";
		$page .= "</th></tr>";
		$page .= "<tr><td colspan=2 class=c><a href=\"game.".PHP_EXT ."?page=shortcuts\">".$lang['fl_shortcuts']."</a></td></tr></tr></table></form></div>";
	}
	elseif (is_numeric($a))
	{
		if ($_POST)
		{
			$scarray = explode("\r\n", $CurrentUser['fleet_shortcut']);
			if ($_POST["delete"])
			{
				unset($scarray[$a]);
				$CurrentUser['fleet_shortcut'] = implode("\r\n", $scarray);
				$db->query("UPDATE ".USERS." SET fleet_shortcut='".$CurrentUser['fleet_shortcut']."' WHERE id=".$CurrentUser['id'].";");
				header("location:game.".PHP_EXT."?page=shortcuts");
			}
			else
			{
				$r = explode(",", $scarray[$a]);
				$r[0] = strip_tags($_POST['n']);
				$r[1] = intval($_POST['g']);
				$r[2] = intval($_POST['s']);
				$r[3] = intval($_POST['p']);
				$r[4] = intval($_POST['t']);
				$scarray[$a] = implode(",", $r);
				$CurrentUser['fleet_shortcut'] = implode("\r\n", $scarray);
				$db->query("UPDATE ".USERS." SET fleet_shortcut='".$CurrentUser['fleet_shortcut']."' WHERE id=".$CurrentUser['id'].";");
				header("location:game.".PHP_EXT."?page=shortcuts");
			}
		}

		if ($CurrentUser['fleet_shortcut'])
		{
			$scarray = explode("\r\n", $CurrentUser['fleet_shortcut']);
			$c = explode(',', $scarray[$a]);
			$page = "<div id=\"content\"><form method=POST><table border=0 cellpadding=0 cellspacing=1 width=519>
					<tr height=20>
					<td colspan=2 class=c>". $lang['fl_shortcut_edition'] ."{$c[0]} [{$c[1]}:{$c[2]}:{$c[3]}]</td>
					</tr>";
			$page .= "<tr height=\"20\"><th>
					<input type=hidden name=a value=$a>
					<input type=text name=n value=\"{$c[0]}\" size=32 maxlength=32>
					<input type=text name=g value=\"{$c[1]}\" size=3 maxlength=1>
					<input type=text name=s value=\"{$c[2]}\" size=3 maxlength=3>
					<input type=text name=p value=\"{$c[3]}\" size=3 maxlength=3>
					<select name=t>";
			$page .= '<option value="1"' . (($c[4] == 1)?" SELECTED":"") . ">".$lang['fl_planet']."</option>";
			$page .= '<option value="2"' . (($c[4] == 2)?" SELECTED":"") . ">".$lang['fl_debris']."</option>";
			$page .= '<option value="3"' . (($c[4] == 3)?" SELECTED":"") . ">".$lang['fl_moon']."</option>";
			$page .= "</select>
					</th></tr><tr>
					<th><input type=\"reset\" value=\"".$lang['fl_reset_shortcut']."\"><input type=submit value=\"".$lang['fl_register_shorcut']."\"> <input type=submit name=delete value=\"".$lang['fl_dlte_shortcut']."\">";
			$page .= "</th></tr>";
		}
		else
			header("location:game.".PHP_EXT."?page=shortcuts");

		$page .= "<tr><td colspan=2 class=c><a href=\"game.".PHP_EXT ."?page=shortcuts\">".$lang['fl_back']."</a></td></tr></tr></table></form></div>";
	}
	else
	{
		$page = "<div id=\"content\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"1\" width=\"519\">
				<tr height=\"20\">
				<td class=\"c\" colspan=\"2\">".$lang['fl_shortcuts']." (<a href=\"game.".PHP_EXT."?page=shortcuts&mode=add\">".$lang['fl_shortcut_add']."</a>)</td>
				</tr>";

		if ($CurrentUser['fleet_shortcut'])
		{
			$scarray = explode("\r\n", $CurrentUser['fleet_shortcut']);
			$i = $e = 0;
			foreach($scarray as $a => $b)
			{
				if ($b != "") {
					$c = explode(',', $b);
					if ($i == 0)
						$page .= "<tr height=\"20\">";

					$page .= "<th><a href=\"game.".PHP_EXT ."?page=shortcuts&a=" . $e++ . "\">";
					$page .= "{$c[0]} {$c[1]}:{$c[2]}:{$c[3]}";

					if ($c[4] == 2)
						$page .= " " . $lang['fl_debris_shortcut'];
					elseif ($c[4] == 3)
						$page .= " " . $lang['fl_moon_shortcut'];

					$page .= "</a></th>";
					if ($i == 1)
						$page .= "</tr>";

					if ($i == 1)
						$i = 0;
					else
						$i = 1;
				}
			}
			if ($i == 1)
				$page .= "<th></th></tr>";
		}
		else
			$page .= "<th colspan=\"2\">".$lang['fl_no_shortcuts']."</th>";

		$page .= "<tr><td class=c colspan=2><a href=game.php?page=fleet>".$lang['fl_back']."</a></td></tr></tr></table></div>";
	}
	display($page);
}
?>