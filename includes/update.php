<?php 

function rrmdir($dir) {
	if (is_dir($dir)) {
		$objects = scandir($dir);
		foreach ($objects as $object) {
			if ($object != "." && $object != "..") {
				if (filetype($dir."/".$object) == "dir") 
					rrmdir($dir."/".$object); 
				else 
					unlink($dir."/".$object);
			}
		}
		rmdir($dir);
	}
}

function createDir($FILE) {
	$CreateDirs = array();
	
	while(!file_exists(dirname($FILE))) {
		$FILE			= dirname($FILE);
		$CreateDirs[]	= $FILE;
	}
	
	if(empty($CreateDirs))
		return true;
		
	$CreateDirs	= array_reverse($CreateDirs);
	
	foreach($CreateDirs as $Dirs) {
		mkdir($Dirs);
		chmod($Dirs, 0777);
	}
	
	return true;
}

function DLFile($FILE) {
	createDir($FILE);
		
	$ch = curl_init();
	$fp	= fopen(ROOT_PATH.$FILE, 'w');
	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_AUTOREFERER, true);
	curl_setopt($ch, CURLOPT_URL, 'http://2moons.googlecode.com/svn/trunk/'.$FILE);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_USERAGENT, "2Moons Update API");
	curl_setopt($ch, CURLOPT_CRLF, true);
	$DATA	= curl_exec($ch);
	
	if(curl_errno($ch))
		return curl_error($ch);
		
	curl_close($ch);
	fclose($fp);
	return true;
}

define('ROOT_PATH', str_replace('\\', '/', dirname(__FILE__)).'/');
require_once(ROOT_PATH . 'includes/config.php');	
require_once(ROOT_PATH . 'includes/classes/class.MySQLi.php');
$db		= new DB_MySQLi();
$FILE	= $_REQUEST['file'];
$MODE	= $_REQUEST['mode'];
$REV	= $_REQUEST['r'];

switch($MODE) {
	case 'add':
		if($FILE == "updates/update_".$REV.".sql") {
			try {
				if(($ERROR	= DLFile($FILE)) !== true) {
					echo json_encode(array('status' => $ERROR, 'error' => true));
				} else {
					$db->multi_query(str_replace('prefix_', $database['tableprefix'], file_get_contents(ROOT_PATH.$FILE)));
					echo json_encode(array('status' => 'OK', 'error' => false));
				}
			} catch (Exception $ERROR) {
				echo json_encode(array('status' => $ERROR, 'error' => true));
			}
		} elseif($FILE == "updates/update_".$REV.".php") {
			if(($ERROR	= DLFile($FILE)) !== true) {
				echo json_encode(array('status' => $ERROR, 'error' => true));
			} else {	
				copy(ROOT_PATH.$FILE, ROOT_PATH.'update_'.$REV.'.php');
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $_SERVER['SERVER_NAME'].str_replace('update.php', 'update_'.$REV.'.php', $_SERVER['PHP_SELF']));
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_NOBODY, true);
				curl_setopt($ch, CURLOPT_MUTE, true);
				curl_exec($ch);
				curl_close($ch);
				unlink(ROOT_PATH.'update_'.$REV.'.php');
				echo json_encode(array('status' => 'OK', 'error' => false));
			}
		} elseif(strpos($FILE, '.') !== false) {		
			if(($ERROR	= DLFile($FILE)) !== true)
				echo json_encode(array('status' => $ERROR, 'error' => true));
			else
				echo json_encode(array('status' => 'OK', 'error' => false));			
		} else {
			if(!file_exists(ROOT_PATH.$FILE))
				mkdir(ROOT_PATH.$FILE);		

			echo json_encode(array('status' => 'OK', 'error' => false));			
		}
	break;
	case 'edit':
		if(strpos($FILE, '.') === false) {
			echo json_encode(array('status' => 'OK', 'error' => false));
			break;
		}
		
		if(($ERROR	= DLFile($FILE)) !== true)
			echo json_encode(array('status' => $ERROR, 'error' => true));
		else
			echo json_encode(array('status' => 'OK', 'error' => false));
	break;
	case 'del':
		if(file_exists(ROOT_PATH.$FILE)) {
			if(strpos($FILE, '.') !== false)
				unlink(ROOT_PATH.$FILE);			
			else
				rrmdir(ROOT_PATH.$FILE);	
		}
		echo json_encode(array('status' => 'OK', 'error' => false));	
	break;
	case 'update':
		$db->query("UPDATE ".$database['tableprefix']."config SET `VERSION` = '1.5.".$REV."';");
	break;
	case 'unlink':
		unlink(__FILE__);
	break;
}
?>