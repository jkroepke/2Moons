<?php

##############################################################################
# *                                                                          #
# * 2MOONS                                                                   #
# *                                                                          #
# * @copyright Copyright (C) 2010 By ShadoX from titanspace.de               #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
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

if ($USER['rights']['CONFGame'] == 0) exit;

function ShowModulePage()
{
	global $CONF, $LNG;
	if($_GET['mode']) {
		$CONF['moduls'][request_var('id', 0)]	= ($_GET['mode'] == 'aktiv') ? 1 : 0;
		update_config('moduls', implode(";", $CONF['moduls']));
		$CONF['moduls']		= explode(";", $CONF['moduls']);
	}

	foreach($LNG['modul'] as $ID => $Name) {
		$Modules[$ID]	= array(
			'name'	=> $Name, 
			'state'	=> $CONF['moduls'][$ID],
		);
	}
	
	$template	= new template();
	$template->page_header();
	$template->assign_vars(array(
		'Modules'				=> $Modules,
		'mod_module'			=> $LNG['mod_module'],
		'mod_info'				=> $LNG['mod_info'],
		'mod_active'			=> $LNG['mod_active'],
		'mod_deactive'			=> $LNG['mod_deactive'],
		'mod_change_active'		=> $LNG['mod_change_active'],
		'mod_change_deactive'	=> $LNG['mod_change_deactive'],
	));
	
	$template->show('adm/ModulePage.tpl');
}
?>