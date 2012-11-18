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
 * @version 1.7.0 (2012-12-31)
 * @info $Id$
 * @link http://2moons.cc/
 */

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