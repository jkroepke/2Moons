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
 * @version 1.6 (2011-11-17)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) exit;

function ShowVertify() 
{
	global $CONF, $LNG;
	$EXT		= explode("|", request_var("ext", ""));
	$action 	= request_var("action", "");
	$file	 	= request_var("file", "");
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
			$SVNHASH	= crc32(curl_exec($ch));
			if(curl_errno($ch)) {
				if(curl_getinfo($ch, CURLINFO_HTTP_CODE) == 404)
					echo 4;
				else 
					echo 3;
			}
			
			curl_close($ch);
			
			$LOCALHASH	= crc32(preg_replace('/\$Id[^\$]+\$/', '$Id$', file_get_contents(ROOT_PATH.$file)));
			if($SVNHASH == $LOCALHASH) {
				echo 1;
			} else {
				echo 2;
			}
			exit;
		break;
		case 'vertify':
			$template->loadscript('vertify.js');
			$template->show("adm/VertifyPageResult.tpl");
			exit;
		break;
		case 'getFileList':
			exit(json_encode(dir_tree(ROOT_PATH, $EXT)));
		break;
	}
	
	$template->show("adm/VertifyPage.tpl");
}

function dir_tree($dir, $EXT) {
	$path = '';
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
					} elseif (is_dir($current_file)) {
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