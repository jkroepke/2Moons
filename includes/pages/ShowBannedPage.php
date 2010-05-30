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

if(!defined('INSIDE')) die('Hacking attempt!');

function ShowBannedPage()
{
	global $USER, $PLANET, $LNG, $db;
	$PlanetRess = new ResourceUpdate();
	$PlanetRess->CalcResource()->SavePlanetToDB();

	$template	= new template();
	$template->page_header();
	$template->page_topnav();
	$template->page_leftmenu();
	$template->page_planetmenu();
	$template->page_footer();

	$query = $db->query("SELECT * FROM ".BANNED." ORDER BY `id`;");

	while($u = $db->fetch_array($query))
	{
		$PrangerList[]	= array(
			'player'	=> $u['who'],
			'theme'		=> $u['theme'],
			'from'		=> date("d. M Y H:i:s",$u['time']),
			'to'		=> date("d. M Y H:i:s",$u['longer']),
			'admin'		=> $u['author'],
			'mail'		=> $u['email'],
			'info'		=> sprintf($LNG['bn_writemail'], $u['author']),
		);
	}
	
	$db->free_result($query);
	
	$template->assign_vars(array(	
		'PrangerList'					=> $PrangerList,
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