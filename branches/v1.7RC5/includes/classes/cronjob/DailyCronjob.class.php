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

class DailyCronJob
{
	function run()
	{
		$this->optimizeTables();
		$this->clearCache();
		$this->reCalculateCronjobs();
		$this->clearEcoCache();
	}
	
	function optimizeTables()
	{
		$tables	= $GLOBALS['DATABASE']->query("SHOW TABLE STATUS FROM ".DB_NAME.";");
		$SQL 	= array();
		while($table = $GLOBALS['DATABASE']->fetch_array($tables)){
			$prefix = explode("_", $table['Name']);  
			
			if($prefix[0].'_' === DB_PREFIX && $prefix[1] !== 'session')
				$SQL[]	= $table['Name'];
		}

		$GLOBALS['DATABASE']->query("OPTIMIZE TABLE ".implode(', ',$SQL).";");
	}
	
	function clearCache()
	{
		ClearCache();
	}
	
	function reCalculateCronjobs()
	{
		Cronjob::reCalculateCronjobs();
	}
	
	function clearEcoCache()
	{
		$GLOBALS['DATABASE']->query("UPDATE uni1_planets SET eco_hash = '';");
	}
}

?>