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
	
	$template	= new template();
	$template->page_header();
	$template->page_footer();
	if ($mode == "add")
	{
		if ($_POST)
		{
			$name	= request_var('n', $lang['fl_anonymous']);
			$gala	= request_var('g', 0);
			$sys	= request_var('s', 0);
			$plan	= request_var('p', 0);
			$type	= request_var('t', 0);
			$CurrentUser['fleet_shortcut'] .= $name.','.$gala.','.$sys.','.$plan.','.$type."\r\n";
			$db->query("UPDATE ".USERS." SET `fleet_shortcut` = '".$CurrentUser['fleet_shortcut']."' WHERE `id` = '".$CurrentUser['id']."';");
			header("Location: game.".PHP_EXT."?page=shortcuts");
		}
	
		$template->assign_vars(array(	
			'fl_shortcut_add_title'	=> $lang['fl_shortcut_add_title'],
			'fl_clean'				=> $lang['fl_clean'],
			'fl_register_shorcut'	=> $lang['fl_register_shorcut'],
			'fl_back'				=> $lang['fl_back'],
			'typeselector'			=> array(1 => $lang['fl_planet'], 2 => $lang['fl_debris'], 3 =>$lang['fl_moon']),
		));
		
		$template->show("fleet_shortcuts_add.tpl");
	}
	elseif (is_numeric($a))
	{
	
		$scarray = explode("\r\n", $CurrentUser['fleet_shortcut']);
		$r = explode(",", $scarray[$a]);
		
		if ($_POST)
		{
			if ($_POST['delete'])
			{
				unset($scarray[$a]);
			}
			else
			{
				$r[0] = request_var('n', '');
				$r[1] = request_var('g', 0);
				$r[2] = request_var('s', 0);
				$r[3] = request_var('p', 0);
				$r[4] = request_var('t', 0);
				$scarray[$a] = implode(",", $r);
			}
			$CurrentUser['fleet_shortcut'] = implode("\r\n", $scarray);
			$db->query("UPDATE ".USERS." SET fleet_shortcut='".$CurrentUser['fleet_shortcut']."' WHERE id=".$CurrentUser['id'].";");
			exit(header("Location: ?page=shortcuts"));
		}

		if (empty($CurrentUser['fleet_shortcut']))
			header("Location: ?page=shortcuts");
		
		$template->assign_vars(array(	
			'fl_back'				=> $lang['fl_back'],
			'fl_shortcut_edition'	=> $lang['fl_shortcut_edition'],
			'fl_reset_shortcut'		=> $lang['fl_reset_shortcut'],
			'fl_register_shorcut'	=> $lang['fl_register_shorcut'],
			'fl_dlte_shortcut'		=> $lang['fl_dlte_shortcut'],
			'typeselector'			=> array(1 => $lang['fl_planet'], 2 => $lang['fl_debris'], 3 =>$lang['fl_moon']),
			'name'					=> $r[0],
			'galaxy'				=> $r[1],
			'system'				=> $r[2],
			'planet'				=> $r[3],
			'type'					=> $r[4],
			'id'					=> $a,
		));
		
		$template->show("fleet_shortcuts_edit.tpl");
	}
	else
	{
		$scarray = explode("\r\n", $CurrentUser['fleet_shortcut']);
		foreach($scarray as $b)
		{
			if(empty($b))
				continue;
				
			$c = explode(',', $b);
			$ShortCuts[]	= array(
				'name'		=> $c[0],
				'galaxy'	=> $c[1],
				'system'	=> $c[2],
				'planet'	=> $c[3],
				'type'		=> $c[4],
			);
		}
	
	$template->assign_vars(array(	
		'ShortCuts'				=> $ShortCuts,
		'fl_back'				=> $lang['fl_back'],
		'fl_planet_shortcut'	=> $lang['fl_planet_shortcut'],
		'fl_moon_shortcut'		=> $lang['fl_moon_shortcut'],
		'fl_debris_shortcut'	=> $lang['fl_debris_shortcut'],
		'fl_no_shortcuts'		=> $lang['fl_no_shortcuts'],
		'fl_shortcuts'			=> $lang['fl_shortcuts'],
		'fl_shortcut_add'		=> $lang['fl_shortcut_add'],
	));
	
	$template->show("fleet_shortcuts.tpl");
	}
}
?>