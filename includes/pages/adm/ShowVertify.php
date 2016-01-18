 <?php

/**
 *  2Moons
 *  Copyright (C) 2011 Jan Kröpke
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2009 Lucky
 * @copyright 2011 Jan Kröpke <info@2moons.cc>
 * @licence MIT
 * @version 1.7.0 (2011-12-10)
 * @info $Id$
 * @link http://2moons.cc/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) throw new Exception("Permission error!");

function ShowVertify() 
{
	$EXT		= explode("|", HTTP::_GP("ext", ""));
	$action 	= HTTP::_GP("action", "");
	$file	 	= HTTP::_GP("file", "");
	$template	= new template();
	
	switch($action) {
		case 'check':
			$REV	= explode(".", Config::get("VERSION"));
			$REV	= $REV[2];
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_AUTOREFERER, true);
			curl_setopt($ch, CURLOPT_URL, 'https://raw.githubusercontent.com/jkroepke/2Moons/master/'.$file);
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
		break;
		case 'vertify':
			$template->loadscript('vertify.js');
			$template->show("VertifyPageResult.tpl");
			exit;
		break;
		case 'getFileList':
			echo json_encode(array_merge(
				dir_tree('./', $EXT, false), 
				dir_tree('chat/', $EXT),
				dir_tree('includes/', $EXT),
				dir_tree('includes/', $EXT),
				dir_tree('language/', $EXT),
				dir_tree('scripts/', $EXT),
				dir_tree('styles/', $EXT)
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
