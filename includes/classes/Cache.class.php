<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @licence MIT
 * @version 1.7.2 (2013-03-18)
 * @info $Id$
 * @link http://2moons.cc/
 */

require 'includes/classes/cache/builder/BuildCache.interface.php';
require 'includes/classes/cache/resource/CacheFile.class.php';

class Cache
{
	private $cacheResource = NULL;
	private $cacheBuilder = array();
	private $cacheObj = array();

	static private $obj = NULL;

	static public function get()
	{
		if(is_null(self::$obj))
		{
			self::$obj	= new self;
		}

		return self::$obj;
	}

	private function __construct() {
		$this->cacheResource = new CacheFile();
	}
	
	public function add($Key, $ClassName) {
		$this->cacheBuilder[$Key]	= $ClassName;
	}

	public function getData($Key, $rebuild = true) {
		if(!isset($this->cacheObj[$Key]) && !$this->load($Key))
		{
			if($rebuild)
			{
				$this->buildCache($Key);
			}
			else
			{
				return array();
			}
		}
		return $this->cacheObj[$Key];
	}

	public function flush($Key) {
		if(!isset($this->cacheObj[$Key]) && !$this->load($Key))
			$this->buildCache($Key);
		
		$this->cacheResource->flush($Key);
		return $this->buildCache($Key);
	}

	public function load($Key) {
		$cacheData	= $this->cacheResource->open($Key);
		
		if($cacheData === false)
			return false;
			
		$cacheData	= unserialize($cacheData);
		if($cacheData === false)
			return false;
		
		$this->cacheObj[$Key] = $cacheData;
		return true;
	}

	public function buildCache($Key) {
		$className		= $this->cacheBuilder[$Key];

		$path			= 'includes/classes/cache/builder/'.$className.'.class.php';
		require_once $path;

		/** @var $cacheBuilder BuildCache */
		$cacheBuilder	= new $className();
		$cacheData		= $cacheBuilder->buildCache();
		$cacheData		= (array) $cacheData;
		$this->cacheObj[$Key] = $cacheData;
		$cacheData		= serialize($cacheData);
		$this->cacheResource->store($Key, $cacheData);
		return true;
	}
}