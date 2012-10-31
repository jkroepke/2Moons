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

class HTTP {
	
	static public function redirectTo($URL)
	{
		self::sendHeader('Location', HTTP_PATH.$URL);
		exit;
	}
	
	static public function sendHeader($name, $value = NULL)
	{
		header($name.(!is_null($value) ? ': '.$value : ''));
	}
	
	static public function _GP($name, $default, $multibyte = false, $highnum = false)
	{
		if(!isset($_REQUEST[$name]))
		{
			return $default;
		}
		
		if(is_int($default))
		{
			return (int) $_REQUEST[$name];			
		}
		
		if(is_float($default))
		{
			return (float) $_REQUEST[$name];			
		}
		
		if(is_string($default))
		{
			$var = trim(htmlspecialchars(str_replace(array("\r\n", "\r", "\0"), array("\n", "\n", ''), $_REQUEST[$name]), ENT_QUOTES, 'UTF-8'));
			
			if (empty($var)) {
				return $default;				
			}
			
			if ($multibyte) {
				if (!preg_match('/^./u', $var)) {
					$var = '';
				}
			} else {
				$var = preg_replace('/[\x80-\xFF]/', '?', $var); // no multibyte, allow only ASCII (0-127)
			}
			
			return $var;
		}
		
		if(is_array($default))
		{
			return (array) $_REQUEST[$name];
			
			/* $varArray		= array();
			$requestData	= $_REQUEST[$name];
			foreach($default as $key => $subdefault)
			{
				if(!isset($requestData[$key])) {
					continue;
				}
				
				if(is_int($subdefault)) {
					$varArray[$key]	= (int) $requestData[$key];
					continue;
				}
				
				if(is_float($subdefault)) {
					$varArray[$key]	= (float) $requestData[$key];	
					continue;		
				}
				
				if(is_string($subdefault)) {
					$var = trim(htmlspecialchars(str_replace(array("\r\n", "\r", "\0"), array("\n", "\n", ''), $requestData[$key]), ENT_QUOTES, 'UTF-8'));
					
					if (empty($var)) {
						return $subdefault;				
					}
					
					if ($multibyte) {
						if (!preg_match('/^./u', $var)) {
							$var = '';
						}
					} else {
						$var = preg_replace('/[\x80-\xFF]/', '?', $var); // no multibyte, allow only ASCII (0-127)
					}
					
					$varArray[$key]	= $var;	
				}
			}
			
			return $varArray; */
		}
		
		return $default;
	}
}