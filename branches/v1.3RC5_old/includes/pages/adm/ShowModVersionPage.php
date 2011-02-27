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

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) exit;

function ShowModVersionPage()
{
	global $LNG, $USER;
	$MVC	= array();
	$Files	= scandir(ROOT_PATH.'includes/functions/mvc/');
	foreach($Files as $File) {
		if(substr($File, 0, 4) == 'mvc_')
			require(ROOT_PATH.'includes/functions/mvc/'.$File);
	}
	
	foreach($MVC as &$Mod) {
		$Mod['description']	= $Mod['description'][$USER['lang']];
		$Update	= @simplexml_load_file($Mod['update']);
		$Update	= $Update->$Mod['tag'];
		if(version_compare($Mod['version'], $Update->version, '<')) {
			$Mod['update']		= colorRed($LNG['mvc_update_yes']);
			$Mod['udetails']	= array('version' => $Update->version, 'date' => $Update->date, 'download' => $Update->download, 'announcement' => $Update->announcement);
		} else {
			$Mod['update']		= colorGreen($LNG['mvc_update_no']);
			$Mod['udetails']	= false;
		}		
	}
	
	$template	= new template();
	$template->assign_vars(array(
		'MVC'					=> $MVC,
		'mvc_title'				=> $LNG['mvc_title'],
		'mvc_author'			=> $LNG['mvc_author'],
		'mvc_version'			=> $LNG['mvc_version'],
		'mvc_link'				=> $LNG['mvc_link'],
		'mvc_update_version'	=> $LNG['mvc_update_version'],
		'mvc_update_date'		=> $LNG['mvc_update_date'],
		'mvc_announcement'		=> $LNG['mvc_announcement'],
		'mvc_download'			=> $LNG['mvc_download'],
		'mvc_desc'				=> $LNG['mvc_desc'],
	));
	$template->show('adm/ModVersionPage.tpl');
}

?>