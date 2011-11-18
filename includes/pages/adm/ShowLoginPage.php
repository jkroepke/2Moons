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
 * @copyright 2009 Lucky <lucky@xgproyect.net> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.6.1 (2011-11-19)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */
 
function ShowLoginPage()
{
	global $USER, $LNG;
	if(isset($_REQUEST['admin_pw']) && md5($_REQUEST['admin_pw']) == $USER['password']) {
		$_SESSION['admin_login']	= md5($_REQUEST['admin_pw']);
		redirectTo('admin.php');
	}

	$template	= new template();

	$template->assign_vars(array(	
		'adm_login'			=> $LNG['adm_login'],
		'adm_password'			=> $LNG['adm_password'],
		'adm_absenden'			=> $LNG['adm_absenden'],
	));
	$template->show('adm/LoginPage.tpl');
}
?>