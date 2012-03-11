<?php

class CacheFile {
	function store($Key, $Value) {
		file_put_contents(CACHE_PATH.'cache.'.$Key.'.php', $Value);
	}
	
	function open($Key) {
		if(!file_exists(CACHE_PATH.'cache.'.$Key.'.php'))
			return false;
			
		return file_get_contents(CACHE_PATH.'cache.'.$Key.'.php');
	}
	
	function flush() {
		
	}
}