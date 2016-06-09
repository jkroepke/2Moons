<?php

/**
 *  2Moons 
 *   by Jan-Otto Kröpke 2009-2016
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan-Otto Kröpke <slaver7@gmail.com>
 * @copyright 2009 Lucky
 * @copyright 2016 Jan-Otto Kröpke <slaver7@gmail.com>
 * @licence MIT
 * @version 1.8.0
 * @link https://github.com/jkroepke/2Moons
 */

class CacheFile {
	private $path;
	public function __construct()
	{
		$this->path	= is_writable(CACHE_PATH) ? CACHE_PATH : $this->getTempPath();
	}

	private function getTempPath()
	{
		require_once 'includes/libs/wcf/BasicFileUtil.class.php';
		return BasicFileUtil::getTempFolder();
	}

	public function store($Key, $Value) {
		return file_put_contents($this->path.'cache.'.$Key.'.php', $Value);
	}
	
	public function open($Key) {
		if(!file_exists($this->path.'cache.'.$Key.'.php'))
			return false;
			
		return file_get_contents($this->path.'cache.'.$Key.'.php');
	}
	
	public function flush($Key) {
		if(!file_exists($this->path.'cache.'.$Key.'.php'))
			return false;
		
		return unlink($this->path.'cache.'.$Key.'.php');
	}
}