<?php

include(ROOT_PATH.'includes/classes/cache/ressource/CacheFile.class.php');

class Cache {
	private $cacheRessource;
	private $cacheBuilder = array();
	private $cacheObj = array();
	
	function __construct() {
		$this->cacheRessource = new CacheFile();
	}
	
	function add($Key, $ClassName) {
		$this->cacheBuilder[$Key]	= $ClassName;
	}
	
	function get($Key) {
		if(!isset($this->cacheObj[$Key]) && !$this->load($Key))
			$this->buildCache($Key);
		
		return $this->cacheObj[$Key];
	}
	
	function load($Key) {
		$cacheData	= $this->cacheRessource->open($Key);
		
		if($cacheData === false)
			return false;
			
		$cacheData	= unserialize($cacheData);
		if($cacheData === false)
			return false;
		
		$this->cacheObj[$Key] = $cacheData;
		return true;
	}
	
	function buildCache($Key) {
		$className		= $this->cacheBuilder[$Key];
		include_once(ROOT_PATH.'includes/classes/cache/builder/'.$className.'.class.php');
		$cacheBuilder	= new $className();
		$cacheData		= $cacheBuilder->buildCache();
		$cacheData		= (array) $cacheData;
		$this->cacheObj[$Key] = $cacheData;
		$cacheData		= serialize($cacheData);
		$this->cacheRessource->store($Key, $cacheData);
		return true;
	}
}