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
 
class Config
{
	#static private $uniConfig;
	#static private $gameConfig;
	static private $config;
	
	static function init(pdo_database $db)
	{	
		$configResult = $db->result_array("SELECT * FROM ".CONFIG.";");

		foreach($configResult as $configRow)
		{
			$configRow['moduls']		= explode(";", $configRow['moduls']);
			self::$config[$configRow['uni']]	= $configRow;
		}
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
			$universe	= 1;
		}
		
		if(isset(self::$config[$universe][$key]))
		{
			return self::$config[$universe][$key];
		}

		throw new Exception("Unkown Config Key ".$key."!");
	}
	
	static function getAll($configType, $universe = NULL)
	{
		switch($configType)
		{
			default:
				if(is_null($universe) || !isset(self::$config[$universe]))
				{
					return self::$config;
				}
				else
				{
					return self::$config[$universe];
				}
			break;
		}
		
		throw new Exception("Unkown ConfigType ".$configType."!");
	}
	
	static function update($newConfig, $universe = NULL, pdo_database $db)
	{
		if(is_null($universe) || !isset(self::$config[$universe]))
		{
			$universe	= 1;
		}
		
		$gameUpdate			= 	array();
		$uniUpdate			= 	array();

		$addUni				=	array();
		$addGame			=	array();

		if(isset($GLOBALS['BASICCONFIG']) === false)
		{
			$GLOBALS['BASICCONFIG']	=	1;
		}


		foreach($newConfig as $configKey => $value)
		{
			if(!isset(self::$config[$universe][$configKey]))
			{
				throw new Exception("Unkown Config Key ".$configKey."!");
			}
			
			if(in_array($configKey, $GLOBALS['BASICCONFIG']) === true)
			{
				foreach(array_keys(self::$config) as $uniID)
				{
					self::$config[$uniID][$configKey]	= $value;
				}

				$addGame	=	array(
					$configKey	=>	$value
				);

				$gameUpdate	=	array_merge($addGame, $gameUpdate);

				#$gameUpdate[]	= $configKey." = '".$GLOBALS['DATABASE']->escape($value)."'";
			}
			else
			{
				self::$config[$universe][$configKey]	= $value;
				$uniUpdate	=	array(
				);

				$addUni	=	array(
					$configKey	=>	$value
				);

				$uniUpdate	=	array_merge($addUni, $uniUpdate);

				#$uniUpdate[]	= $configKey." = '".$GLOBALS['DATABASE']->escape($value)."'";
			}
		}
		
		if(!empty($uniUpdate))
		{
			$db->update(CONFIG, $uniUpdate, array('uni' => $universe));
			#$GLOBALS['DATABASE']->query("UPDATE ".CONFIG." SET ".implode(', ', $uniUpdate)." WHERE uni = ".$universe.";");
		}
		
		if(!empty($gameUpdate))
		{
			$db->update(CONFIG, $gameUpdate, array('1' => '1'));
			#$GLOBALS['DATABASE']->query("UPDATE ".CONFIG." SET ".implode(', ', $gameUpdate).";");
		}

		#$GLOBALS['CONFIG']	= self::$config;
		#$GLOBALS['CONF']	= self::$config[$GLOBALS['UNI']];
	}
}
