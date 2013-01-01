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

class Language implements ArrayAccess {
    private $container = array();
    private $langauge = array();
    static private $allLangauges = array();
	
	static function getAllowedLangs($OnlyKey = true)
	{
		if(count(self::$allLangauges) == 0) {
			$GLOBALS['CACHE']->add('language', 'LanguageBuildCache');
			self::$allLangauges = $GLOBALS['CACHE']->get('language');
		}
		
		if($OnlyKey) {
			return array_keys(self::$allLangauges);
		}
		else {
			return self::$allLangauges;
		}
	}
	
	public function getUserAgentLanguage()
	{
   		if(MODE === 'INDEX' && isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], self::getAllowedLangs())) {
			$this->setLanguage($_COOKIE['lang']);
			return true;
		}
		
   		if(isset($_REQUEST['lang']) && in_array($_REQUEST['lang'], self::getAllowedLangs())) {
			$this->setLanguage($_REQUEST['lang']);
			return true;
		}
		
	    if (empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            return false;
        }

		$quality = 0;
		
		$x = explode(",", $_SERVER['HTTP_ACCEPT_LANGUAGE']);
		foreach ($x as $val) {
			if(preg_match("/(.*);q=([0-1]{0,1}\.\d{0,4})/i", $val, $matches))
			{
				if($quality < ((float) $matches[2]))
				{
					$quality	= (float) $matches[2];
					$deflang	= $matches[1];
				}
			}
			else
			{
				$deflang = $val;
				break;
			}
		}
		
		$this->setLanguage($deflang);
	}
	
    public function __construct($langauge = NULL)
	{
		$this->setLanguage($langauge);
    }
	
    public function setLanguage($langauge)
	{
		if(is_null($langauge) || !in_array($langauge, self::getAllowedLangs()))
		{
			$this->langauge	= Config::get('lang');
		}
		else
		{
			$this->langauge = $langauge;
		}
    }
	
    public function addData($data) {
		$this->container = array_merge($this->container, $data);
    }
	
	public function getLanguage()
	{
		return $this->langauge;
	}
	
	public function getTemplate($templateName)
	{
		if(file_exists(ROOT_PATH.'language/'.$this->getLanguage().'/templates/'.$templateName.'.txt'))
		{
			return file_get_contents(ROOT_PATH.'language/'.$this->getLanguage().'/templates/'.$templateName.'.txt');
		}
		else
		{
			return '### Template "'.$templateName.'" on language "'.$this->getLanguage().'" not found! ###';
		}
	}
	
	public function includeData($Files)
	{
		// Fixed BOM problems.
		ob_start();
		
        foreach($Files as $File) {
			require(ROOT_PATH.'language/'.$this->getLanguage().'/'.$File.'.php');
		}
		
		if(file_exists(ROOT_PATH.'language/'.$this->getLanguage().'/CUSTOM.php'))
		{
			require(ROOT_PATH.'language/'.$this->getLanguage().'/CUSTOM.php');
		}
		
		ob_end_clean();
		$this->addData($LNG);
	}
	
	public function insertData($Files)
	{
		
	}
	
	/** ArrayAccess Functions **/
	
    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }
	
    public function offsetExists($offset) {
        return isset($this->container[$offset]);
    }
	
    public function offsetUnset($offset) {
        unset($this->container[$offset]);
    }
	
    public function offsetGet($offset) {
        return isset($this->container[$offset]) ? $this->container[$offset] : $offset;
    }
}