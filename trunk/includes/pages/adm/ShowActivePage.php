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

if ($USER['rights']['EditUsers'] == 0) exit();

function ShowActivePage()
{
	global $LNG, $db, $USER;
	$id = request_var('id', 0);
	if($_GET['action'] == 'delete' && !empty($id))
		$db->query("DELETE FROM ".USERS_VALID." WHERE `id` = '".$id."';");

	$query = $db->query("SELECT * FROM ".USERS_VALID." ORDER BY id ASC");

	$Users	= array();
	while ($User = $db->fetch_array($query)) {
		$Users[]	= array(
			'id'		=> $User['id'],
			'name'		=> $User['username'],
			'date'		=> date("d.m.Y H:i:s", $User['date']),
			'email'		=> $User['email'],
			'ip'		=> $User['ip'],
			'password'	=> $User['password'],
			'cle'		=> $User['cle']
		);
	}

	$template	= new template();
	$template->page_header();
	$template->assign_vars(array(	
		'Users'		=> $Users,
		'UserLang'	=> $USER['lang'],
	));
	
	$template->show('adm/ActivePage.tpl');
}
?>