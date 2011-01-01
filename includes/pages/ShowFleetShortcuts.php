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

function ShowFleetShortcuts()
{
	global $USER, $LNG, $db;

	$a = request_var('a','');
	$mode = request_var('mode', '');
	
	$template	= new template();
	$template->isPopup(true);
	if ($mode == "add")
	{
		if ($_POST)
		{
			$name	= request_var('n', $LNG['fl_anonymous']);
			$gala	= request_var('g', 0);
			$sys	= request_var('s', 0);
			$plan	= request_var('p', 0);
			$type	= request_var('t', 0);
			$USER['fleet_shortcut'] .= $name.','.$gala.','.$sys.','.$plan.','.$type."\r\n";
			$db->query("UPDATE ".USERS." SET `fleet_shortcut` = '".$USER['fleet_shortcut']."' WHERE `id` = '".$USER['id']."';");
			redirectTo("game.".PHP_EXT."?page=shortcuts");
		}
	
		$template->assign_vars(array(	
			'fl_shortcut_add_title'	=> $LNG['fl_shortcut_add_title'],
			'fl_clean'				=> $LNG['fl_clean'],
			'fl_register_shorcut'	=> $LNG['fl_register_shorcut'],
			'fl_back'				=> $LNG['fl_back'],
			'typeselector'			=> array(1 => $LNG['fl_planet'], 2 => $LNG['fl_debris'], 3 =>$LNG['fl_moon']),
		));
		
		$template->show("fleet_shortcuts_add.tpl");
	}
	elseif (is_numeric($a))
	{
	
		$scarray = explode("\r\n", $USER['fleet_shortcut']);
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
			$USER['fleet_shortcut'] = implode("\r\n", $scarray);
			$db->query("UPDATE ".USERS." SET fleet_shortcut='".$USER['fleet_shortcut']."' WHERE id=".$USER['id'].";");
			exit(redirectTo("game.".PHP_EXT."?page=shortcuts"));
		}

		if (empty($USER['fleet_shortcut']))
			redirectTo("game.".PHP_EXT."?page=shortcuts");
		
		$template->assign_vars(array(	
			'fl_back'				=> $LNG['fl_back'],
			'fl_shortcut_edition'	=> $LNG['fl_shortcut_edition'],
			'fl_reset_shortcut'		=> $LNG['fl_reset_shortcut'],
			'fl_register_shorcut'	=> $LNG['fl_register_shorcut'],
			'fl_dlte_shortcut'		=> $LNG['fl_dlte_shortcut'],
			'typeselector'			=> array(1 => $LNG['fl_planet'], 2 => $LNG['fl_debris'], 3 =>$LNG['fl_moon']),
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
		$scarray = explode("\r\n", $USER['fleet_shortcut']);
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
		'fl_back'				=> $LNG['fl_back'],
		'fl_planet_shortcut'	=> $LNG['fl_planet_shortcut'],
		'fl_moon_shortcut'		=> $LNG['fl_moon_shortcut'],
		'fl_debris_shortcut'	=> $LNG['fl_debris_shortcut'],
		'fl_no_shortcuts'		=> $LNG['fl_no_shortcuts'],
		'fl_shortcuts'			=> $LNG['fl_shortcuts'],
		'fl_shortcut_add'		=> $LNG['fl_shortcut_add'],
	));
	
	$template->show("fleet_shortcuts.tpl");
	}
}
?>