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
function ShowLoginPage()
{
	global $USER, $LNG;
	if(isset($_REQUEST['admin_pw']) && md5($_REQUEST['admin_pw']) == $USER['password']) {
		$_SESSION['admin_login']	= md5($_REQUEST['admin_pw']);
		redirectTo('admin.php');
	}

	$template	= new template();
	$template->page_header();
	$template->assign_vars(array(	
		'adm_login'			=> $LNG['adm_login'],
		'adm_password'			=> $LNG['adm_password'],
		'adm_absenden'			=> $LNG['adm_absenden'],
	));
	$template->show('adm/LoginPage.tpl');
}
?>