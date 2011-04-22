<?php

/**
 *  2Moons
 *  Copyright (C) 2011  Slaver
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
 * @author Slaver <slaver7@gmail.com>
 * @copyright 2009 Lucky <lucky@xgproyect.net> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.3.5 (2011-04-22)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

class Language
{
	public static $langs   = array(
		'de' => 'Deutsch', 
		'en' => 'English', 
		'pt' => 'Português',
		'ru' => 'Русский', 
	);
	
	public $Default	= '';
	public $User	= '';
	
	function __construct()
	{
		$this->Default	= DEFAULT_LANG;
		$this->User		= DEFAULT_LANG;
	}
	
	static function getAllowedLangs($OnlyKey = true)
	{
		return $OnlyKey ? array_keys(self::$langs) : self::$langs;		
	}
	
	function setDefault($LANG)
	{
		if(!empty($LANG) && in_array($LANG, self::getAllowedLangs())) {
			$this->Default	= $LANG;
			$this->User		= $LANG;	
		}
	}
	
	function setUser($LANG)
	{
		if(!empty($LANG) && in_array($LANG, self::getAllowedLangs()))
			$this->User	= $LANG;		
	}
	
	function getUser()
	{
		return $this->User;	
	}
	
	function GetLangFromBrowser($strict_mode = true) 
	{
   		if(defined('LOGIN') && isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], self::getAllowedLangs())) {
			$this->setUser($_COOKIE['lang']);
			return $this->User;
		}
		
   		if(isset($_REQUEST['lang']) && in_array($_REQUEST['lang'], self::getAllowedLangs())) {
			$this->setUser($_REQUEST['lang']);
			return $this->User;
		}
		
	    if (empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            return $this->Default;
        }

        $accepted_languages = preg_split('/,\s*/', $_SERVER['HTTP_ACCEPT_LANGUAGE']);

        $current_lang = $this->Default;
        $current_q = 0;

        foreach ($accepted_languages as $accepted_language) {
            $res = preg_match ('/^([a-z]{1,8}(?:-[a-z]{1,8})*)'.'(?:;\s*q=(0(?:\.[0-9]{1,3})?|1(?:\.0{1,3})?))?$/i', $accepted_language, $matches);

            if (!$res) {
                continue;
            }
                
            $LANG_code = explode ('-', $matches[1]);
			$LANG_quality = isset($matches[2]) ? (float)$matches[2] : 1.0;

            while (count ($LANG_code)) {
                if (in_array (strtolower (join ('-', $LANG_code)),  self::getAllowedLangs())) {
                    if ($LANG_quality > $current_q) {
                        $current_lang = strtolower (join ('-', $LANG_code));
                        $current_q = $LANG_quality;
                        break;
                    }
                }
                if ($strict_mode) {
                    break;
                }
                array_pop ($LANG_code);
            }
        }
        $this->setUser($current_lang);
		return $this->User;
	}
	
	function includeLang($Files)
	{
		global $LNG;
		while (list(,$File) = each($Files)){
			require(ROOT_PATH . "language/de/".$File.'.php');
			require(ROOT_PATH . "language/".$this->User."/".$File.'.php');
		}
	}
	
	function GetUserLang($ID, $Files = array())
	{
		global $db, $CONF;	
		$LANGUAGE = is_numeric($ID) && !in_array($ID, self::getAllowedLangs()) ? $db->countquery("SELECT `lang` FROM ".USERS." WHERE `id` = '".$ID."';") : $ID;
	
		if(!in_array($LANGUAGE, self::getAllowedLangs()))
			$LANGUAGE	= $this->Default;
	
		if(empty($Files))
			$Files	= array('FLEET');
	
		while (list(,$File) = each($Files)){
			require(ROOT_PATH . "language/".$LANGUAGE."/".$File.'.php');
		}
			
		return $LNG;
	}
}

?>