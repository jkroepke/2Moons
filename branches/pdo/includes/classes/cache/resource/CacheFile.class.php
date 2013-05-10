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
 * @info $Id$
 * @link http://2moons.cc/
 */

class CacheFile {
	private $path;
	public function __construct()
	{
		$this->path	= is_writable(CACHE_PATH) ? CACHE_PATH : $this->getTempPath();
	}

	private function getTempPath()
	{
		include 'includes/libs/wcf/BasicFileUtil.class.php';
		return BasicFileUtil::getTempFolder();
	}

	private function getFilePath($key)
	{
		return $this->path.'cache.'.$key.'.php';
	}

	public function store($Key, $Value) {
		file_put_contents($this->getFilePath($Key), $Value);
	}
	
	public function open($Key) {
		if(!file_exists($this->getFilePath($Key)))
		{
			return false;
		}

		return file_get_contents($this->getFilePath($Key));
	}
	
	public function flush($Key) {
		if(!file_exists($this->getFilePath($Key)))
		{
			return false;
		}

		return unlink($this->getFilePath($Key));
	}
}