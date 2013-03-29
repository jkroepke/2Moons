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
 
class theme
{
	static public $Themes;
	private $THEMESETTINGS;
	
	function __construct()
	{	
		$this->skininfo = array();
		$this->skin		= isset($_SESSION['dpath']) ? $_SESSION['dpath'] : DEFAULT_THEME;
		$this->setUserTheme($this->skin);
	}
	
	function isHome()
	{
		$this->template		= ROOT.'styles'.SEP.'home'.SEP;
		$this->customtpls	= array();
	}
	
	function setUserTheme($Theme)
	{
		if(!is_file(ROOT.'styles'.SEP.'theme'.SEP.$Theme.SEP.'style.cfg'))
		{
			return false;
		}

		$this->skin		= $Theme;
		$this->parseStyleCFG();
		$this->setStyleSettings();
	}
		
	function getTheme()
	{
		return '.'.SEP.'styles'.SEP.'theme'.SEP.$this->skin.SEP;
	}
	
	function getThemeName()
	{
		return $this->skin;
	}
	
	function getTemplatePath()
	{
		return ROOT.'styles'.SEP.'templates'.SEP.$this->skin.SEP;
	}
		
	function isCustomTPL($tpl)
	{
		if(!isset($this->customtpls))
		{
			return false;
		}

		return in_array($tpl, $this->customtpls);
	}
	
	function parseStyleCFG()
	{
		require ROOT.'styles'.SEP.'theme'.SEP.$this->skin.SEP.'style.cfg';

		$this->skininfo		= $Skin;
		$this->customtpls	= (array)$Skin['templates'];
	}
	
	function setStyleSettings()
	{
		if(is_file(ROOT.'styles'.SEP.'theme'.SEP.$this->skin.SEP.'settings.cfg'))
		{
			require ROOT.'styles'.SEP.'theme'.SEP.$this->skin.SEP.'settings.cfg';
		}
		
		$this->THEMESETTINGS	= array_merge(array(
			'PLANET_ROWS_ON_OVERVIEW' => 2,
			'SHORTCUT_ROWS_ON_FLEET1' => 2,
			'COLONY_ROWS_ON_FLEET1' => 2,
			'ACS_ROWS_ON_FLEET1' => 1,
			'TOPNAV_SHORTLY_NUMBER' => 0,
		), $THEMESETTINGS);
	}
	
	function getStyleSettings()
	{
		return $this->THEMESETTINGS;
	}
	
	static function getAvalibleSkins()
	{
		if(!isset(self::$Themes))
		{
			if(is_file(ROOT.'cache'.SEP.'cache.themes.php'))
			{
				self::$Themes	= unserialize(file_get_contents(ROOT.'cache'.SEP.'cache.themes.php'));
			}
			else
			{
				$Skins	= array_diff(scandir(ROOT.'styles'.SEp.'theme'.SEP), array('..', '.', '.svn', '.htaccess', 'index.htm'));
				$Themes	= array();
				foreach($Skins as $Theme)
				{
					if(!is_file(ROOT.'styles'.SEP.'theme'.SEP.$Theme.SEP.'style.cfg'))
					{
						continue;
					}

					require ROOT.'styles'.SEP.'theme'.SEP.$Theme.SEP.'style.cfg';
					$Themes[$Theme]	= $Skin['name'];
				}

				file_put_contents(ROOT.'cache'.SEP.'cache.themes.php', serialize($Themes));
				self::$Themes	= $Themes;
			}
		}
		return self::$Themes;
	}
}
