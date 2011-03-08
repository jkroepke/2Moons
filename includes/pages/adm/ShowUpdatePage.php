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
@set_time_limit(0);

function ShowUpdatePage()
{
	global $LNG, $CONF, $db;
	if(isset($_REQUEST['version']))
	{
		$Temp	= explode('.', $_REQUEST['version']);
		$Temp	= array_map('intval', $Temp);
		update_config(array('VERSION' => $Temp[0].'.'.$Temp[1].'.'.$Temp[2]), true);
	}
	
	$Patchlevel	= explode(".",$GLOBALS['CONF']['VERSION']);
	if($_REQUEST['action'] == 'history')
		$Level		= 0;	
	elseif(isset($Patchlevel[2]))
		$Level		= $Patchlevel[2];
			
	switch($_REQUEST['action'])
	{
		case "download":
			$UpdateArray 	= getDatafromServer('getupdate');
			if(!is_array($UpdateArray['revs']))
				exitupdate(array('debug' => array('noupdate' => $LNG['up_kein_update'])));

			require_once(ROOT_PATH.'includes/libs/zip/zip.lib.php');				
			$SVN_ROOT		= $UpdateArray['info']['svn'];
			
			$zipfile 	= new zipfile();
			$TodoDelete	= "";
			$Files		= array('add' => array(), 'edit' => array(), 'del' => array());
			$FirstRev	= 0;
			$LastRev	= 0;
			foreach($UpdateArray['revs'] as $Rev => $RevInfo) 
			{
				if(!empty($RevInfo['add']))
				{
					foreach($RevInfo['add'] as $File)
					{	
						if(in_array($File, $Files['add']) || strpos($File, '.') === false)
							continue;
							
						$Files['add'][] = $File;
						
						$zipfile->addFile(@file_get_contents($SVN_ROOT.$File), str_replace("/trunk/", "", $File), $RevInfo['timestamp']);					
					}
				}
				if(!empty($RevInfo['edit']))
				{
					foreach($RevInfo['edit'] as $File)
					{	
						if(in_array($File, $Files['edit']) || strpos($File, '.') === false) 
							continue;
							
							$Files['edit'][] = $File;
							
							$zipfile->addFile(@file_get_contents($SVN_ROOT.$File), str_replace("/trunk/", "", $File), $RevInfo['timestamp']);
						
					}
				}
				if(!empty($RevInfo['del']))
				{
					foreach($RevInfo['del'] as $File)
					{
						if(in_array($File, $Files['del']) || strpos($File, '.') === false)
							continue;
						$Files['del'][] = $File;

						$TodoDelete	.= str_replace("/trunk/", "", $File)."\r\n";
					}
				}
				if($FirstRev === 0)
					$FirstRev = $Rev;
					
				$LastRev = $Rev;
			}	
			
			if(!empty($TodoDelete))
				$zipfile->addFile($TodoDelete, "!TodoDelete!.txt", $RevInfo['timestamp']);
			
			update_config(array('VERSION' => $Patchlevel[0].".".$Patchlevel[1].".".$LastRev), true);
			// Header für Download senden
			$File	= $zipfile->file(); 		
			header("Content-length: ".strlen($File));
			header("Content-Type: application/force-download");
			header('Content-Disposition: attachment; filename="patch_'.$FirstRev.'_to_'.$LastRev.'.zip"');
			header("Content-Transfer-Encoding: binary");

			// Zip File senden
			echo $File; 
			exit;			
		break;
		case "update":
			ExecuteUpdates();
		break;
		default:
			DisplayUpdates();
		break;
	}
}

function ExecuteUpdates($Patchlevel) {
	global $LNG;
	$Patchlevel		= getVersion();
	$UpdateArray 	= GetLogs($Patchlevel[2]);
	$Files			= array('add' => array(), 'edit' => array(), 'del' => array());
	foreach($UpdateArray as $RevInfo) 
	{	
		if(!empty($RevInfo['add']))
		{
			foreach($RevInfo['add'] as $File)
			{
				if(in_array($File, $Files['add']))
					continue;
					
				$Files['add'][] = $File;
				$File	= str_replace('/trunk/', '', $File);
				if($File == "updates/update_".$Rev.".sql") {
					$db->multi_query(str_replace("prefix_", DB_PREFIX, DLFile($File, true)));
					continue;
				} 
				if($File == "/trunk/updates/update_".$Rev.".php") {
					require($SVN_ROOT.$File);
					continue;
				} else {
					if (strpos($File, '.') !== false) {		
						$Data = fopen($SVN_ROOT.$File, "r");
						if ($ftp->uploadFromFile($Data, str_replace("/trunk/", "", $File))) {
							$LOG['update'][$Rev][$File]	= $LNG['up_ok_update'];

						} else {
							$LOG['update'][$Rev][$File]	= $LNG['up_error_update'];
						}
						fclose($Data);
					} else {
						if ($ftp->makeDir(str_replace("/trunk/", "", $File), 1)) {
							if(PHP_SAPI == 'apache2handler')
								$ftp->chmod(str_replace("/trunk/", "", $File), '0777');
							else
								$ftp->chmod(str_replace("/trunk/", "", $File), '0755');
								
							$LOG['update'][$Rev][$File]	= $LNG['up_ok_update'];
						} else {
							$LOG['update'][$Rev][$File]	= $LNG['up_error_update'];
						}				
					}
				}
			}
		}
		if(!empty($RevInfo['edit']))
		{
			foreach($RevInfo['edit'] as $File)
			{	
				if(in_array($File, $Files['edit']))
					continue;
				$Files['edit'][] = $File;
				if (strpos($File, '.') !== false) {
					if($File == "/trunk/updates/update_".$Rev.".sql")
					{
						$db->multi_query(str_replace("prefix_", DB_PREFIX, @file_get_contents($SVN_ROOT.$File)));
						continue;
					} else {
						$Data = fopen($SVN_ROOT.$File, "r");
						if ($ftp->uploadFromFile($Data, str_replace("/trunk/", "", $File))) {
							$LOG['update'][$Rev][$File]	= $LNG['up_ok_update'];
						} else {
							$LOG['update'][$Rev][$File]	= $LNG['up_error_update'];
						}
						fclose($Data);
					}
				}
			}
		}
		if(!empty($RevInfo['del']))
		{
			foreach($RevInfo['del'] as $File)
			{
				if(in_array($File, $Files['del']))
					continue;
					
				$Files['del'][] = $File;
				if (strpos($File, '.') !== false) {
					if ($ftp->delete(str_replace("/trunk/", "", $File))) {
						$LOG['update'][$Rev][$File]	= $LNG['up_delete_file'];
					} else {
						$LOG['update'][$Rev][$File]	= $LNG['up_error_delete_file'];
					}
				} else {
					if ($ftp->removeDir(str_replace("/trunk/", "", $File), 1 )) {
						$LOG['update'][$Rev][$File]	= $LNG['up_delete_file'];
					} else {
						$LOG['update'][$Rev][$File]	= $LNG['up_error_delete_file'];
					}						
				}
			}
		}
		$LastRev = $Rev;
	}
	$LOG['finish']['atrev'] = $LNG['up_update_ok_rev']." ".$LastRev;
	// Verbindung schließen
	ClearCache();
	update_config(array('VERSION' => $Patchlevel[0].".".$Patchlevel[1].".".$LastRev), true);
	exitupdate($LOG);
}

function DisplayUpdates() {
	global $LNG;
	
	$RevList		= '';
	$Update			= '';
	$Info			= '';
	$Patchlevel		= getVersion();
	
	$UpdateArray	= array_reverse(GetLogs($Patchlevel[2]));
	$template 		= new template();
	foreach($UpdateArray as $RevInfo) 
	{
		if(!(empty($RevInfo['add']) && empty($RevInfo['edit'])) && $Patchlevel[2] < $RevInfo['version']){
			$Update		= "<tr><td><a href=\"#\" onclick=\"openPWDialog();return false;\">Update</a>".(function_exists('gzcompress') ? " - <a href=\"?page=update&amp;action=download\">".$LNG['up_download_patch_files']."</a>":"")."</td></tr>";
			$Info		= "<tr><th colspan=\"5\">".$LNG['up_aktuelle_updates']."</th></tr>";
		}
		
		$edit	= "";
		if(!empty($RevInfo['edit']) || is_array($RevInfo['edit'])){
			foreach($RevInfo['edit'] as $file) {							
				$edit	.= '<a href="http://code.google.com/p/2moons/source/diff?spec=svn'.$RevInfo['version'].'&r='.$RevInfo['version'].'&format=side&path='.$file.'" target="diff">'.str_replace("/trunk/", "", $file).'</a><br>';
			}
		}

		$RevList .= "<tr>
		".(($Patchlevel[2] == $RevInfo['version'])?"<th colspan=5>".$LNG['up_momentane_version']."</th></tr><tr>":((($Patchlevel[2] - 1) == $RevInfo['version'])?"<th colspan=5>".$LNG['up_alte_updates']."</th></tr><tr>":""))."
		<th>".(($Patchlevel[2] == $RevInfo['version'])?"<font color=\"red\">":"")."".$LNG['up_revision']." ".$RevInfo['version']." ".date(TDFORMAT, strtotime($RevInfo['date']))." ".$LNG['ml_from']." ".$RevInfo['author'].(($Patchlevel[2] == $Rev)?"</font>":"")."</th></tr>
		<tr><td>".makebr($RevInfo['comment'])."</th></tr>
		".((!empty($RevInfo['add']))?"<tr><td>".$LNG['up_add']."<br>".str_replace("/trunk/", "", implode("<br>\n", $RevInfo['add']))."</b></td></tr>":"")."
		".((!empty($RevInfo['edit']))?"<tr><td>".$LNG['up_edit']."<br>".$edit."</b></td></tr>":"")."
		".((!empty($RevInfo['del']))?"<tr><td>".$LNG['up_del']."<br>".str_replace("/trunk/", "", implode("<br>\n", $RevInfo['del']))."</b></td></tr>":"")."
		</tr>";
	}		
	$template->assign_vars(array(	
		'up_password_title'	=> $LNG['up_password_title'],
		'up_password_info'	=> $LNG['up_password_info'],
		'up_password_label'	=> $LNG['up_password_label'],
		'up_submit'			=> $LNG['up_submit'],
		'up_version'		=> $LNG['up_version'],
		'version'			=> implode('.', $Patchlevel),
		'RevList'			=> $RevList,
		'Update'			=> $Update,
		'Info'				=> $Info,
	));
		
	$template->show('adm/UpdatePage.tpl');
}

function GetLogs($fromRev) {
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

	$xml2Array = new xml2Array();
	$arrOutput = $xml2Array->xmlParse($DATA);
	$fileLogs = array();
	foreach($arrOutput['children'] as $value) {
		$array=array();
		foreach($value['children'] as $entry) {
			if ($entry['name'] == 'D:VERSION-NAME') $array['version'] = $entry['tagData'];
			if ($entry['name'] == 'D:CREATOR-DISPLAYNAME') $array['author'] = $entry['tagData'];
			if ($entry['name'] == 'S:DATE') $array['date'] = $entry['tagData'];
			if ($entry['name'] == 'D:COMMENT') $array['comment'] = $entry['tagData'];

			if (($entry['name'] == 'S:ADDED-PATH') || ($entry['name'] == 'S:MODIFIED-PATH') || ($entry['name'] == 'S:DELETED-PATH')) {
				if ($entry['name'] == 'S:ADDED-PATH') $array['add'][] = $entry['tagData'];
				if ($entry['name'] == 'S:MODIFIED-PATH') $array['edit'][] = $entry['tagData'];
				if ($entry['name'] == 'S:DELETED-PATH') $array['del'][] = $entry['tagData'];
			}
		}
		array_push($fileLogs, $array);
	}
	
	return $fileLogs;
}

function getVersion() {
	return explode('.', $GLOBALS['CONF']['VERSION']);
}

function DLFile($FILE, $Return = false) {
	$ch = curl_init();
	if($Return === false) {
		$fp	= fopen(ROOT_PATH.$FILE, 'w');
		curl_setopt($ch, CURLOPT_FILE, $fp);
	} else {
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	}
	curl_setopt($ch, CURLOPT_AUTOREFERER, true);
	curl_setopt($ch, CURLOPT_URL, 'http://2moons.googlecode.com/svn/trunk/'.$FILE);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_USERAGENT, "2Moons Update API");
	curl_setopt($ch, CURLOPT_CRLF, true);
	$DATA	= curl_exec($ch);
	
	if(curl_errno($ch))
		return curl_error($ch);
		
	curl_close($ch);
	
	if($Return === false) {
		fclose($fp);
		return true;
	} else {
		return $DATA;
	}
}

function exitupdate($LOG){
	$Page	= "";
	if(is_array($LOG['debug'])) {
		foreach($LOG['debug'] as $key => $content) {
			$Page .= $content."<br>";
		}
	}
	
	if(is_array($LOG['update'])) {
		foreach($LOG['update'] as $rev => $content) {
			foreach($content as $file => $status) {
				$Page.= "File ".$file." (Rev. ".$rev."): ".$status."<br>";
			}
		}
	}
		
	if(is_array($LOG['finish'])) {	
		foreach($LOG['finish'] as $key => $content) {
			$Page .= $content."<br>";
		}
	}
	$Page .= "<br><a href='?page=update'>".$LNG['up_weiter']."</a>";

	$template = new template();
	$template->message($Page, false, 0, true);
				
	exit;
}


class xml2Array {
   
	private $arrOutput = array();
	private $resParser;
	private $strXmlData;

	public function xmlParse($strInputXML) {
		$this->resParser = xml_parser_create ();
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