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
 
class Config
{
	#static private $uniConfig;
	#static private $gameConfig;
	static private $config;
	
	static function init()
	{	
		$configResult = $GLOBALS['DATABASE']->query("SELECT * FROM ".CONFIG.";");

		while($configRow = $GLOBALS['DATABASE']->fetch_array($configResult))
		{
			$configRow['moduls']		= explode(";", $configRow['moduls']);
			self::$config[$configRow['uni']]	= $configRow;
		}

		$GLOBALS['DATABASE']->free_result($configResult);
	}
	
	static function setGlobals()
	{	
		// BC Wrapper
		$GLOBALS['CONFIG']	= self::$config;
		$GLOBALS['CONF']	= self::$config[$GLOBALS['UNI']];
	}
	
	static function get($key, $universe = NULL)
	{
		if(is_null($universe) || !isset(self::$config[$universe]))
		{
			$universe	= $GLOBALS['UNI'];
		}
		
		if(isset(self::$config[$universe][$key]))
		{
			return self::$config[$universe][$key];
		}
		
		
		/* New Config
		if(is_null($universe) || !isset(self::$uniConfig[$universe]))
		{
			$universe	= $GLOBALS['UNI'];
		}
		
		if(isset(self::$uniConfig[$universe][$key]))
		{
			return self::$uniConfig[$universe][$key];
		}
		
		if(isset(self::$gameConfig[$key]))
		{
			return self::$gameConfig[$key];
		}
		*/
		throw new Exception("Unkown Config Key ".$key."!");
	}
	
	static function getAll($configType, $universe = NULL)
	{
		switch($configType)
		{
			default:
				if(is_null($universe) || !isset(self::$config[$universe])) {
					return self::$config;
				}
				else {
					return self::$config[$universe];
				}
			break;
			/* New Config
			case 'universe':
				return self::$uniConfig;
			break;
			case 'global':
				return self::$gameConfig;
			break; */
		}
		
		throw new Exception("Unkown ConfigType ".$configType."!");
	}
	
	static function update($newConfig, $universe = NULL)
	{
		if(is_null($universe) || !isset(self::$config[$universe])) {
			$universe	= $GLOBALS['UNI'];
		}
		
		$gameUpdate			= array();
		$uniUpdate			= array();
		
		foreach($newConfig as $configKey => $value)
		{
			if(!isset(self::$config[$universe][$configKey]))
			{
				throw new Exception("Unkown Config Key ".$configKey."!");
			}
			
			if(in_array($configKey, $GLOBALS['BASICCONFIG']))
			{
				foreach(array_keys(self::$config) as $uniID)
				{
					self::$config[$uniID][$configKey]	= $value;
				}
				$gameUpdate[]	= $configKey." = '".$GLOBALS['DATABASE']->escape($value)."'";
			}
			else
			{
				self::$config[$universe][$configKey]	= $value;
				$uniUpdate[]	= $configKey." = '".$GLOBALS['DATABASE']->escape($value)."'";
			}
		}
		
		if(!empty($uniUpdate))
		{
			$GLOBALS['DATABASE']->query("UPDATE ".CONFIG." SET ".implode(', ', $uniUpdate)." WHERE uni = ".$universe.";");
		}
		
		if(!empty($gameUpdate))
		{
			$GLOBALS['DATABASE']->query("UPDATE ".CONFIG." SET ".implode(', ', $gameUpdate).";");
		}
		
		$GLOBALS['CONFIG']	= self::$config;
		$GLOBALS['CONF']	= self::$config[$GLOBALS['UNI']];
	}
}

?>