<?php

function isBuggyIe() {
    $ua = $_SERVER['HTTP_USER_AGENT'];
    // quick escape for non-IEs
    if (0 !== strpos($ua, 'Mozilla/4.0 (compatible; MSIE ')
        || false !== strpos($ua, 'Opera')) {
        return false;
    }
    // no regex = faaast
    $version = (float)substr($ua, 30);
    return (
        $version < 6
        || ($version == 6  && false === strpos($ua, 'SV1'))
    );
}

$file		= $_GET['js'];
$content	= "";

foreach($file as $name)
{
	$content	.= (is_readable("./scripts/".$name)) ? file_get_contents("./scripts/".$name) : "";
	$lastedit[]	 = filemtime("./scripts/".$name);
}


header('Content-Type: application/javascript');
header('Last-Modified: '.date('D, d M Y H:i:s T', min($lastedit)));
header('Expires: '.date('D, d M Y H:i:s T', time() + 604800));
header('Cache-Control: public, max-age=604800, s-maxage=604800');

if(!isBuggyIe())
{
	header('Content-Encoding: deflate'); 
	echo gzdeflate($content);
} else {
	echo $content;
}
?>