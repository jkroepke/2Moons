<?php

/**
 *  2Moons
 *  Copyright (C) 2011 Jan Kröpke
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
 * @copyright 2009 Lucky
 * @copyright 2011 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.0 (2011-12-10)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

class TrackingCronjob
{
	function run()
	{
		$serverData['php']			= PHP_VERSION;
		
		try {
			$serverData['installSince']	= $GLOBALS['DATABASE']->getFirstCell("SELECT register_time FROM ".USERS." WHERE id = ".ROOT_USER);
		} catch (Exception $e) {
			$serverData['installSince']	= NULL;
		}
		
		try {
			$serverData['users']		= $GLOBALS['DATABASE']->getFirstCell("SELECT COUNT(*) FROM ".USERS.";");
		} catch (Exception $e) {
			$serverData['users']		= NULL;
		}
		
		try {
			$serverData['unis']			= $GLOBALS['DATABASE']->getFirstCell("SELECT COUNT(*) FROM ".CONFIG.";");
		} catch (Exception $e) {
			$serverData['unis']			= NULL;
		}
		
		try {
			$serverData['version']		= Config::get('VERSION');
		} catch (Exception $e) {
			$serverData['version']		= NULL;
		}
		
		$this->ch	= curl_init('http://tracking.2moons.cc/');
		curl_setopt($this->ch, CURLOPT_HTTPGET, true);
		curl_setopt($this->ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, $serverData);
		curl_setopt($this->ch, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; 2Moons/".Config::get('VERSION')."; +http://2moons.cc)");
		
		curl_exec($this->ch);
		curl_close($this->ch);
	}
}