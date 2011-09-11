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
 * @version 1.4 (2011-07-10)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) exit;

function ShowVertify() 
{
	global $CONF, $LNG;
	$Patchlevel	= explode(".", $CONF['VERSION']);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'http://2moons.cc/hash/hash.php?r='.$Patchlevel[2]);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_CRLF, true);
	curl_setopt($ch, CURLOPT_USERAGENT, "2Moons WebInstaller");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$RAWHash	= curl_exec($ch);
	curl_close($ch);
	if(empty($RAWHash))
		message($LNG['vt_error']);
		
	$RAWHash	= explode("\r\n", $RAWHash);
	foreach($RAWHash as $Temp) {
		$Temp	= explode(":", $Temp);
		$Hash[$Temp[0]]	= $Temp[1];
	}
	$Fail	= array();
	$List	= dir_tree(substr(ROOT_PATH, 0, -1));
	foreach($List as $File => $MD5) {
		if(!isset($Hash[$File]))
			continue;
			
		if($MD5 !== $Hash[$File])
			$Fail[$File]	= $MD5;
	}
	$template	= new template();
	$template->assign_vars(array(
		'Fail'			=> $Fail,
		'Patchlevel'	=> $Patchlevel[2],
	));
	
	$template->show("adm/VertifyPage.tpl");
}


function dir_tree($dir) {
	$path = '';
	$stack[] = $dir;
	while ($stack) {
		$thisdir = array_pop($stack);
		if ($dircont = scandir($thisdir)) {
			$i=0;
			while (isset($dircont[$i])) {
				if (!in_array($dircont[$i], array('.', '..', '.svn', '.info'))) {
					$current_file = $thisdir."/".$dircont[$i];
					if (is_file($current_file)) {
						$path[str_replace(ROOT_PATH, '', str_replace('\\', '/', $current_file))]	= md5_file($current_file);
					} elseif (is_dir($current_file)) {
						$stack[] = $current_file;
					}
				}
				$i++;
			}
		}
	}
	return $path;
}

?>