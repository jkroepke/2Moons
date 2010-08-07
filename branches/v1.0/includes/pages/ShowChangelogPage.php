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


function ShowChangelogPage()
{
	global $USER, $PLANET, $LNG;

	$PlanetRess = new ResourceUpdate();
	$PlanetRess->CalcResource();
	$PlanetRess->SavePlanetToDB();

	$template	= new template();

	$template->page_header();
	$template->page_topnav();
	$template->page_leftmenu();
	$template->page_planetmenu();
	$template->page_footer();

	includeLang('CHANGELOG');	
	$template->assign_vars(array(	
		'ChangelogList'	=> array_map('makebr',$LNG['changelog']),
		'Version'		=> $LNG['Version'],
		'Description'	=> $LNG['Description'],
	));
	
	$template->show("changelog_overview.tpl");
}
?>