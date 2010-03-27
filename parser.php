<?php
/*
Written by Adromir http://www.die-vaganten.de Email: adromir@gmx.de
Sometimes i realized, that when you embed more than one external Javascript in your html-document,
some functions are not availible, because not all files were loaded. This way, you can integrate several external
js-files with only one embed, which combines the multiple files into one.
To improve the performance, i added some compression and caching features to this script.
         
Thanks go to Rizzo ()Mod from http://www.traum-projekt.com) for his caching tutorial and http://www.webcodingtech.com for the gzip function
*/

// [Start of Configuration]  
// Edit lines before using to set the desired configuration 

// Caching Configuration   
$caching = TRUE; // TRUE when cashing shall be used, otherwise set to FALSE        
$cache_file = "./cache/js-cache.php"; // leave empty, when $caching is set to FALSE or when the caching directory is the same as of this script. Otherwise set a relative path e.g. "/cache/"
$cache_timeout = "3600"; // time in seconds, when a new cachefile should be generated. Default is 3600s = 1h.

// Compression Configuration
$mod_gzip = false;  // TRUE when your Server supports mod_gzip and you want to use it, otherwise set to FALSE. $zlib should be favoured
$zlib = TRUE;    // Use TRUE, when your Server supports the zlib. $mod_gzip must be set to FALSE.
$zlib_compression = '5'; //compression level for the zlib module. Set to values from 0 (off) to 9 (highest). Higher values increases the serverload, but don't result necessarily in better compression rates! 

// Removes unnecessary Code from the JS- Files. 
// Please regard the License of the Scripts, when using this feature. 
// It can cause troubles with some Javascript framweworks.
$remove_whitespaces = false; // removes linebreaks and spare spaces in the script.
$remove_comments = false; // removes Comments from the Javascript. Please regard the License of the Scripts, when using this feature. Can cause troubles with some Javascript framweworks.

// js- Files
// Insert the path to the js-files relative from the location of this script. Like in the given example$file		= $_GET['js'];

foreach($_GET['js'] as $name)
{
	$files[]	= "./scripts/".$name;
}
$cache_file = "./cache/".md5(implode("",$files)).".js.php";
// [End of Configuration]  
// Do not edit behind this line!

function print_gzipped_page($compression) {

    global $HTTP_ACCEPT_ENCODING;
    if( headers_sent() ){
        $encoding = false;
    }elseif( strpos($HTTP_ACCEPT_ENCODING, 'x-gzip') !== false ){
        $encoding = 'x-gzip';
    }elseif( strpos($HTTP_ACCEPT_ENCODING,'gzip') !== false ){
        $encoding = 'gzip';
    }else{
        $encoding = false;
    }

    if( $encoding ){
        $contents = ob_get_contents();
        ob_end_clean();
        header('Content-Encoding: '.$encoding);
        print("\x1f\x8b\x08\x00\x00\x00\x00\x00");
        $size = strlen($contents);
        $contents = gzcompress($contents, $compression);
        $contents = substr($contents, 0, $size);
        print($contents);
        exit();
    }else{
        ob_end_flush();
        exit();
    }
}


if($mod_gzip == TRUE && $zlib == TRUE)  die("zlib and gzip compression are both set to TRUE. Please check your configuration");

if($mod_gzip == TRUE) ob_start("ob_gzhandler"); 
    elseif($zlib == TRUE) {  ob_start();
        ob_implicit_flush(0);
    }
else {
     ob_start();
     }

header('Content-type: text/javascript');

if (file_exists( $cache_file ) &&
   (time() - filemtime( $cache_file )) < $cache_timeout && $caching == TRUE )
{           
// controls browsercache 
$exp_gmt = gmdate("D, d M Y H:i:s", time() + $cache_timeout) ." GMT";
$mod_gmt = gmdate("D, d M Y H:i:s", getlastmod()) ." GMT";
header("Expires: " . $exp_gm);
header("Last-Modified: " . $mod_gmt);
header("Cache-Control: public, max-age=" . $cache_timeout);
header("Cache-Control: pre-check=" . $cache_timeout, FALSE);

// includes the static Cache-File
    include( $cache_file );
   ($zlib == TRUE)? print_gzipped_page($zlib_compression) : ob_end_flush(); 
       EXIT;
       
} 

$data	= "";
foreach($files AS $file) {
    $handle = fopen ($file, "r");
    $data .= fread ($handle, filesize ($file));
    fclose ($handle);
}

if($remove_comments == TRUE) {
    $data = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', "", $data);
    $data = preg_replace('!\/\/[^\n]*!', "", $data); 
}

if($remove_whitespaces == TRUE) $data = preg_replace("/\s+/", " ", $data);



echo $data;

if($caching == TRUE) {
$handle = fopen( $cache_file, "w" );
fwrite( $handle, $data );
fclose( $handle ); 
}

($zlib == TRUE)? print_gzipped_page($zlib_compression) : ob_end_flush();   

  
?>
