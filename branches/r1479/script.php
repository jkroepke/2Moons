<?php
header('Cache-Control: must-revalidate, max-age=86400');
header('Expires: '.gmdate('D, d M Y H:i:s', time() + 86400).' GMT');
header('Content-Type: application/x-javascript');

ini_set('zlib.output_compression', 'On');
define('ROOT_PATH', str_replace('\\', '/',dirname(__FILE__)).'/');
error_reporting(E_ALL);
ini_set('display_errors', 1);

(!isset($_GET['script'])) ? exit(header('HTTP/1.1 204 No Content')) : '';

$CACHE	= ROOT_PATH.'cache/'.md5($_GET['script']).'.js.php';
if(file_exists($CACHE) && !isset($_GET['cache'])) {
	include($CACHE);
	exit;
} else {
	file_put_contents($CACHE, '');
}

require_once(ROOT_PATH.'includes/libs/JSMin/jsmin.php');

$SCRIPTS	= explode(';', str_replace(array('/', '\\', '-', '.'), '', $_GET['script']));
(!is_array($SCRIPTS)) ? exit(header('HTTP/1.1 204 No Content')) : '';
	
foreach($SCRIPTS as $FILE) {
	$JSSOUCRE	= JSMin::minify(file_get_contents(ROOT_PATH.'scripts/'.$FILE.'.js'));
	echo $JSSOUCRE;
	file_put_contents($CACHE, $JSSOUCRE, FILE_APPEND);
}

?>