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

function ShowBannedPage()
{
	global $USER, $PLANET, $LNG, $db;
	
	$PlanetRess = new ResourceUpdate();
	$PlanetRess->CalcResource();
	$PlanetRess->SavePlanetToDB();

	$template	= new template();
	$query			= $db->query("SELECT * FROM ".BANNED." ORDER BY `id`;");
	$PrangerList	= array();
	
	while($u = $db->fetch_array($query))
	{
		$PrangerList[]	= array(
			'player'	=> $u['who'],
			'theme'		=> $u['theme'],
			'from'		=> date(TDFORMAT,$u['time']),
			'to'		=> date(TDFORMAT,$u['longer']),
			'admin'		=> $u['author'],
			'mail'		=> $u['email'],
			'info'		=> sprintf($LNG['bn_writemail'], $u['author']),
		);
	}
	
	$db->free_result($query);
	
	$template->assign_vars(array(	
		'PrangerList'				=> $PrangerList,
		'bn_no_players_banned'		=> $LNG['bn_no_players_banned'],
		'bn_exists'					=> $LNG['bn_exists'],
		'bn_players_banned'			=> $LNG['bn_players_banned'],
		'bn_players_banned_list'	=> $LNG['bn_players_banned_list'],
		'bn_player'					=> $LNG['bn_player'],
		'bn_reason'					=> $LNG['bn_reason'],
		'bn_from'					=> $LNG['bn_from'],
		'bn_until'					=> $LNG['bn_until'],
		'bn_by'						=> $LNG['bn_by'],
	));
	
	$template->show("banned_overview.tpl");
}
?>