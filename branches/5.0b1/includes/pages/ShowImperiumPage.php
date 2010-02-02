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

function ShowImperiumPage($CurrentUser)
{
	global $lang, $resource, $reslist, $dpath, $db;
	
	$build = $fleet = $def = "";
	foreach($reslist['build'] as $id => $gid){
		$build .= ",`".$resource[$gid]."`";
	}
	
	foreach($reslist['fleet'] as $id => $gid){
		$fleet .= ",`".$resource[$gid]."`";
	}
	
	foreach($reslist['defense'] as $id => $gid){
		$def .= ",`".$resource[$gid]."`";
	}
	
	$planetsrow = $db->query("
	SELECT `id`,`name`,`galaxy`,`system`,`planet`,`planet_type`,
	`image`,`field_current`,`field_max`,`metal`,`metal_perhour`,
	`crystal`,`crystal_perhour`,`deuterium`,`deuterium_perhour`,
	`energy_used`,`energy_max` ".$build.$fleet.$def." FROM ".PLANETS." WHERE `id_owner` = '" . $CurrentUser['id'] . "' AND `destruyed` = 0;");

	$parse 	= $lang;
	$planet = array();

	while ($p = $db->fetch_array($planetsrow))
	{
		$planet[] = $p;
	}

	$parse['mount'] = count($planet) + 1;

	foreach ($planet as $p)
	{
		$datat = array('<a href="game.php?page=overview&cp=' . $p['id'] . '&amp;re=0"><img src="' . $dpath . 'planeten/small/s_' . $p['image'] . '.jpg" border="0" height="80" width="80"></a>', $p['name'], "[<a href=\"game.php?page=galaxy&mode=3&galaxy={$p['galaxy']}&system={$p['system']}\">{$p['galaxy']}:{$p['system']}:{$p['planet']}</a>]", $p['field_current'] . '/' . $p['field_max'], '<a href="game.php?page=resources&cp=' . $p['id'] . '&amp;re=0&amp;planettype=' . $p['planet_type'] . '">' . pretty_number($p['metal']) . '</a> / ' . pretty_number($p['metal_perhour']), '<a href="game.php?page=resources&cp=' . $p['id'] . '&amp;re=0&amp;planettype=' . $p['planet_type'] . '">' . pretty_number($p['crystal']) . '</a> / ' . pretty_number($p['crystal_perhour']), '<a href="game.php?page=resources&cp=' . $p['id'] . '&amp;re=0&amp;planettype=' . $p['planet_type'] . '">' . pretty_number($p['deuterium']) . '</a> / ' . pretty_number($p['deuterium_perhour']), pretty_number($p['energy_max'] - $p['energy_used']) . ' / ' . pretty_number($p['energy_max']));
		$f = array('file_images', 'file_names', 'file_coordinates', 'file_fields', 'file_metal', 'file_crystal', 'file_deuterium', 'file_energy');
		for ($k = 0; $k < 8; $k++)
		{
			$data['text'] = $datat[$k];
			$parse[$f[$k]] .= parsetemplate(gettemplate('empire/empire_row'), $data);
		}

		foreach ($resource as $i => $res)
		{
			$data['text'] = ($p[$resource[$i]] == 0 && $CurrentUser[$resource[$i]] == 0) ? '-' : ((in_array($i, $reslist['build'])) ? "<a href=\"game.php?page=buildings&cp={$p['id']}&amp;re=0&amp;planettype={$p['planet_type']}\">{$p[$resource[$i]]}</a>" : ((in_array($i, $reslist['tech'])) ? "<a href=\"game.php?page=buildings&mode=research&cp={$p['id']}&amp;re=0&amp;planettype={$p['planet_type']}\">{$CurrentUser[$resource[$i]]}</a>" : ((in_array($i, $reslist['fleet'])) ? "<a href=\"game.php?page=buildings&mode=fleet&cp={$p['id']}&amp;re=0&amp;planettype={$p['planet_type']}\">{$p[$resource[$i]]}</a>" : ((in_array($i, $reslist['defense'])) ? "<a href=\"game.php?page=buildings&mode=defense&cp={$p['id']}&amp;re=0&amp;planettype={$p['planet_type']}\">{$p[$resource[$i]]}</a>" : '-'))));
			$r[$i] .= parsetemplate(gettemplate('empire/empire_row'), $data);
		}
	}

	$m = array('build', 'tech', 'fleet', 'defense');

	$n = array('building_row', 'technology_row', 'fleet_row', 'defense_row');

	for ($j = 0; $j < 4; $j++)
	{
		foreach ($reslist[$m[$j]] as $a => $i)
		{
			$data['text'] = $lang['tech'][$i];
			$parse[$n[$j]] .= "<tr>" . parsetemplate(gettemplate('empire/empire_row'), $data) . $r[$i] . "</tr>";
		}
	}

	return display(parsetemplate(gettemplate('empire/empire_table'), $parse), false);
}
?>