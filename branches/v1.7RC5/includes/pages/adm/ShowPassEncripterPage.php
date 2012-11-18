<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
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
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.0 (2012-12-31)
 * @info $Id$
 * @link http://2moons.cc/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) throw new Exception("Permission error!");

function ShowPassEncripterPage()
{
	global $LNG;
	$Password	= HTTP::_GP('md5q', '', true);
	
	$template	= new template();

	$template->assign_vars(array(
		'md5_md5' 			=> $Password,
		'md5_enc' 			=> cryptPassword($Password),
		'et_md5_encripter' 	=> $LNG['et_md5_encripter'],
		'et_encript' 		=> $LNG['et_encript'],
		'et_result' 		=> $LNG['et_result'],
		'et_pass' 			=> $LNG['et_pass'],
	));
	
	$template->show('PassEncripterPage.tpl');
}
?>