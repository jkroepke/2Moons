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

if(!defined('INSIDE')){ die(header("location:../../"));}

function ShowBannedPage()
{
	global $lang, $db;

	$template	= new template();
	$template->page_header();
	$template->page_topnav();
	$template->page_leftmenu();
	$template->page_planetmenu();
	$template->page_header();
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
		);
	}
	
	$template->assign_vars(array(	
		'PrangerList'					=> $PrangerList,
		'bn_no_players_banned'		=> $lang['bn_no_players_banned'],
		'bn_exists'					=> $lang['bn_exists'],
		'bn_players_banned'			=> $lang['bn_players_banned'],
		'bn_players_banned_list'	=> $lang['bn_players_banned_list'],
		'bn_player'					=> $lang['bn_player'],
		'bn_reason'					=> $lang['bn_reason'],
		'bn_from'					=> $lang['bn_from'],
		'bn_until'					=> $lang['bn_until'],
		'bn_by'						=> $lang['bn_by'],
	));
	
	$template->display("banned_overview.tpl");
}
?>