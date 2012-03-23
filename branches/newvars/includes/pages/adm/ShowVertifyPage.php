 <?php

/**
 *  2Moons
 *  Copyright (C) 2011 Jan Kröpke
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
 * @copyright 2009 Lucky
 * @copyright 2011 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.0 (2011-12-10)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) exit;



function ShowVertify() 
{
	global $CONF, $LNG;
	$EXT		= explode("|", HTTP::_GP("ext", ""));
	$action 	= HTTP::_GP("action", "");
	$file	 	= HTTP::_GP("file", "");
	$template	= new template();
	
	switch($action) {
		case 'check':
			$REV	= explode(".", $CONF["VERSION"]);
			$REV	= $REV[2];
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_AUTOREFERER, true);
			curl_setopt($ch, CURLOPT_URL, 'http://2moons.googlecode.com/svn-history/r'.$REV.'/trunk/'.$file);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_USERAGENT, "2Moons Update API");
			curl_setopt($ch, CURLOPT_CRLF, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$FILE		= curl_exec($ch);
			$SVNHASH	= crc32(preg_replace(array("/(\r\n)|(\r)/", '/(\\/\\*[\\d\\D]*?\\*\\/)/', '/\$I'.'d[^\$]+\$/'), array("\n", '', ''), $FILE));
			
			if(curl_getinfo($ch, CURLINFO_HTTP_CODE) == 404) {
				echo 4;
				exit;
			}
			
			if(curl_errno($ch)) {
				echo 3;
				exit;
			}
			
			curl_close($ch);
			$FILE2	= file_get_contents(ROOT_PATH.$file);
			$LOCALHASH	= crc32(preg_replace(array("/(\r\n)|(\r)/", '/(\\/\\*[\\d\\D]*?\\*\\/)/', '/\$I'.'d[^\$]+\$/'), array("\n", '', ''), $FILE2));
			if($SVNHASH == $LOCALHASH) {
				echo 1;
				exit;
			} else {
				echo 2;
				exit;
			}
			exit;
		break;
		case 'vertify':
			$template->loadscript('vertify.js');
			$template->show("VertifyPageResult.tpl");
			exit;
		break;
		case 'getFileList':
			echo json_encode(array_merge(
				dir_tree(ROOT_PATH, $EXT, false), 
				dir_tree(ROOT_PATH.'chat/', $EXT),
				dir_tree(ROOT_PATH.'includes/', $EXT),
				dir_tree(ROOT_PATH.'includes/', $EXT),
				dir_tree(ROOT_PATH.'language/', $EXT),
				dir_tree(ROOT_PATH.'scripts/', $EXT),
				dir_tree(ROOT_PATH.'styles/', $EXT)
			));
			exit;
		break;
	}
	
	$template->show("VertifyPage.tpl");
}

function dir_tree($dir, $EXT, $subDir = true) {
	$path = array();
	$stack[] = $dir;
	while ($stack) {
		$thisdir = array_pop($stack);
		if ($dircont = scandir($thisdir)) {
			$i=0;
			while (isset($dircont[$i])) {
				if (!in_array($dircont[$i], array('.', '..', '.svn', '.info'))) {
					$current_file = $thisdir.$dircont[$i];
					if (is_file($current_file))
					{
						foreach($EXT as $FILEXT)
						{
							if(preg_match("/\.".preg_quote($FILEXT)."$/i", $current_file))
							{
								$path[]	= str_replace(ROOT_PATH, '', str_replace('\\', '/', $current_file));
								break;
							}
						}
					} elseif ($subDir && is_dir($current_file)) {
						$stack[] = $current_file."/";
					}
				}
				$i++;
			}
		}
	}
	return $path;
}

?>