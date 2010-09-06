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

function ShowLogoutPage()
{
	global $LNG;
	session_destroy();
	$params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
	
	$template	= new template();
	$template->page_header();
	$template->page_footer();	
	$template->assign_vars(array(
		'lo_title'		=> $LNG['lo_title'],
		'lo_logout'		=> $LNG['lo_logout'],
		'lo_redirect'	=> $LNG['lo_redirect'],
		'lo_notify'		=> $LNG['lo_notify'],
		'lo_continue'	=> $LNG['lo_continue'],
	));
	$template->show("logout_overview.tpl");
}
?>