<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
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
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.2 (2013-03-18)
 * @info $Id: Cache.class.php 2640 2013-03-23 19:23:26Z slaver7 $
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