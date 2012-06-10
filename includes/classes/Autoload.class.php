<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan
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
 * @author Jan <info@2moons.cc>
 * @copyright 2006 Perberos <ugamela@perberos.com.ar> (UGamela)
 * @copyright 2008 Chlorel (XNova)
 * @copyright 2009 Lucky (XGProyecto)
 * @copyright 2012 Jan <info@2moons.cc> (2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 2.0.$Revision$ (2012-11-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

class Autoload
{
	private static $classFiles;
	
	static function generateCache()
	{	
		$Iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(ROOT_PATH));
		$Regex = new RegexIterator($Iterator, '/^.+\.class\.php$/i', RecursiveRegexIterator::GET_MATCH);

		$classFiles	= array();

		foreach($Regex as $file) {
			preg_match('/^.+[\\\\|\/](.+)[\\\\|\/]([^\.]+)\.class\.php$/', $file[0], $className);
			$className				= (in_array($className[1], array('index', 'game', 'admin')) ? $className[1].'/' : '').$className[2];
			$classFiles[$className]	= str_replace('\\', '/', $file[0]);
		}
		
		return $classFiles;
    }
	
	static function load($className)
	{
		if(!isset(self::$classFiles)) {
			$GLOBALS['CACHE']->add('autoload', 'AutoloadBuildCache');
			self::$classFiles	= $GLOBALS['CACHE']->get('autoload');
		}
		
		if(substr($className, 0, 4) === 'Show' || $className === 'AbstractPage') {
			$className	= strtolower(MODE).'/'.$className;
		}
		
		if(isset(self::$classFiles[$className]) && file_exists(self::$classFiles[$className])) {
			require self::$classFiles[$className];
		}
		
		if(substr($className, 0, 6) === "smarty" && function_exists('smartyAutoload')) {
			smartyAutoload($class);
		}
    }
}
