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

function ShowUpdatePage()
{
	global $LNG, $CONF;
	$template	= new template();
	$template->message('<p>This Site is currently under construction, because the update system brings somtimes inconsistent game installations.</p><p>Alternate update process: <a href="http://2moons.cc/b4-support/b7-installation-update-und-konvertierung/t1721-howto-update-your-2moons-game-with-private-modifications-without-edit-files-one-by-one/" target="blank"><u>2moons.cc Board</u></a></p><p>We apologize for any inconvenience.</p>');
	exit;
	
	if(!function_exists('curl_init'))
	{
		$template	= new template();
		$template->message($LNG['up_need_curl']);
	}
	
	if(isset($_REQUEST['version']))
	{
		$Temp		= explode('.', $_REQUEST['version']);
		$Temp		= array_map('intval', $Temp);

		if(count(GetLogs($Temp[2]), COUNT_RECURSIVE) > 8)
			Config::update(array('VERSION' => $Temp[0].'.'.$Temp[1].'.'.$Temp[2]));
	}
	
	$ACTION	= HTTP::_GP('action', '');
	switch($ACTION)
	{
		case "download":
			DownloadUpdates();
		break;
		case "check":
			CheckPermissions();
		break;
		case "update":
			ExecuteUpdates();
		break;
		default:
			DisplayUpdates();
		break;
	}
}

function DownloadUpdates() {
exit;
	// Header für Download senden
	header('Content-length: '.strlen($File));
	header('Content-Type: application/force-download');
	header('Content-Disposition: attachment; filename="patch_'.$FirstRev.'_to_'.$LastRev.'.zip"');
	header('Content-Transfer-Encoding: binary');

	// Zip File senden
	echo $File; 
	exit;
}

function CheckPermissions() {
	global $LNG;
	$DIRS	= array_unique($_REQUEST['dirs']);
	$errors	= array();
	foreach($DIRS as $DIR) {
		if(!file_exists(ROOT_PATH.$DIR))
			@mkdir(ROOT_PATH.$DIR);

		if(!is_writable(ROOT_PATH.$DIR))
			$errors[]	= "./".$DIR;
	}
	
	if(!empty($errors))
		echo json_encode(array('status' => $LNG['up_chmod_error']."\r\n".implode("\r\n", $errors), 'error' => true));
	else
		echo json_encode(array('status' => 'OK', 'error' => false));
}

function ExecuteUpdates() {
	clearstatcache();
	copy(ROOT_PATH.'includes/update.php', ROOT_PATH.'update.php');
}

function DisplayUpdates() {
	global $LNG;
	$Patchlevel	= getVersion();
	
	$template	= new template();
	$template->loadscript('update.js');
	$template->assign_vars(array(
		'up_submit'					=> $LNG['up_submit'],
		'up_version'				=> $LNG['up_version'],
		'up_revision'				=> $LNG['up_revision'],
		'up_add'					=> $LNG['up_add'],
		'up_edit'					=> $LNG['up_edit'],
		'up_del'					=> $LNG['up_del'],
		'ml_from'					=> $LNG['ml_from'],
		'up_aktuelle_updates'		=> $LNG['up_aktuelle_updates'],
		'up_momentane_version'		=> $LNG['up_momentane_version'],
		'up_alte_updates'			=> $LNG['up_alte_updates'],
		'up_download'				=> $LNG['up_download_patch_files'],
		'version'					=> implode('.', $Patchlevel),
		'RevList'					=> json_encode(GetLogs(isset($_REQUEST['history']) ? 0 : $Patchlevel[2])),
		'Rev'						=> $Patchlevel[2],
		'canDownload'				=> function_exists('gzcompress'),
	));
		
	$template->show('UpdatePage.tpl');
}

function GetLogs($fromRev) {
	global $LNG;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_AUTOREFERER, true);
	curl_setopt($ch, CURLOPT_URL, 'http://2moons.googlecode.com/svn/trunk/');
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type' => 'text/xml', 'Depth' => 1));
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'REPORT');
	curl_setopt($ch, CURLOPT_USERAGENT, "2Moons Update API");
	curl_setopt($ch, CURLOPT_CRLF, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, sprintf('<?xml version="1.0" encoding="utf-8"?> <S:log-report xmlns:S="svn:"> <S:start-revision>%d</S:start-revision><S:end-revision>%d</S:end-revision><S:path></S:path><S:discover-changed-paths/></S:log-report>', $fromRev, -1));
	$DATA	= curl_exec($ch);
	curl_close($ch);
	if(function_exists('xml_parser_create'))
	{
		$xml2Array	= new xml2Array();
		$arrOutput	= $xml2Array->xmlParse($DATA);
		if((array) $arrOutput['children'] === $arrOutput['children'])
		{
			$fileLogs	= array();
			foreach($arrOutput['children'] as $value) {
				if(empty($value['children']))
					continue;
					
				$array			= array();
				$array['add']	= array();
				$array['edit']	= array();
				$array['del']	= array();
				foreach($value['children'] as $entry) {
					if ($entry['name'] == 'D:VERSION-NAME') $array['version'] = $entry['tagData'];
					if ($entry['name'] == 'D:CREATOR-DISPLAYNAME') $array['author'] = $entry['tagData'];
					if ($entry['name'] == 'S:DATE') $array['date'] = _date($LNG['php_tdformat'], strtotime($entry['tagData']), $USER['timezone']);
					if ($entry['name'] == 'D:COMMENT') $array['comment'] = makebr($entry['tagData']);

					if (($entry['name'] == 'S:ADDED-PATH') || ($entry['name'] == 'S:MODIFIED-PATH') || ($entry['name'] == 'S:DELETED-PATH')) {
						if(strpos($entry['tagData'], 'trunk/') === false)
							continue;
						else
							$entry['tagData']	= substr($entry['tagData'], 7);
					
						if ($entry['name'] == 'S:ADDED-PATH') $array['add'][] = $entry['tagData'];
						if ($entry['name'] == 'S:MODIFIED-PATH') $array['edit'][] = $entry['tagData'];
						if ($entry['name'] == 'S:DELETED-PATH') $array['del'][] = $entry['tagData'];
					}
				}
				array_push($fileLogs, $array);
			}
		} else {
			$fileLogs	= array(array(
				'error'	=> $LNG['up_offline'],
			));
	}
	} else {
		$fileLogs	= array(array(
			'error'	=> $LNG['up_no_xml_ext'],
		));
	}
	return $fileLogs;
}

function getVersion() {
	return explode('.', $GLOBALS['CONF']['VERSION']);
}

class xml2Array {
   
	private $arrOutput = array();
	private $resParser;
	private $strXmlData;

	public function xmlParse($strInputXML) {
		$this->resParser = xml_parser_create();
		xml_set_object($this->resParser,$this);
		xml_set_element_handler($this->resParser, "tagOpen", "tagClosed");
		xml_set_character_data_handler($this->resParser, "tagData");

		$this->strXmlData = xml_parse($this->resParser,$strInputXML );
		if(!$this->strXmlData) {
			die(sprintf("XML error: %s at line %d",
				xml_error_string(xml_get_error_code($this->resParser)),
				xml_get_current_line_number($this->resParser)));
		}

		xml_parser_free($this->resParser);
		// Changed by Deadpan110
		//return $this->arrOutput;
		return $this->arrOutput[0];
	}

	private function tagOpen($parser, $name, $attrs) {
		$tag=array("name"=>$name,"attrs"=>$attrs);
		array_push($this->arrOutput,$tag);
	}

	private function tagData($parser, $tagData) {
		if(trim($tagData)) {
			if(isset($this->arrOutput[count($this->arrOutput)-1]['tagData'])) {
				$this->arrOutput[count($this->arrOutput)-1]['tagData'] .= $tagData;
			} else {
				$this->arrOutput[count($this->arrOutput)-1]['tagData'] = $tagData;
			}
		}
	}

	private function tagClosed($parser, $name) {
		$this->arrOutput[count($this->arrOutput)-2]['children'][] = $this->arrOutput[count($this->arrOutput)-1];
		array_pop($this->arrOutput);
	}
}

?>