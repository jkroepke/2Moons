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

abstract class load_functions extends GlobalFunction
{
	public function __construct()
	{
		parent::setCacheClass();
		parent::setLanguageClass();
		parent::setThemeClass();
		parent::setTemplateClass();
		parent::setDatabaseData();
		parent::setDatabaseClass();
		parent::setUserData();
		parent::setConfigClass();
		parent::setSessionClass();

		$this->lang->initializeExternClass($this->cache);
		$this->lang->getUserAgentLanguage();
		$this->lang->includeData(array('L18N', 'INGAME', 'INSTALL'));

		$language	= HTTP::_GP('lang', '');

		if(!empty($language) && in_array($language, $this->lang->getAllowedLangs(true, $this->cache)))
		{
			setcookie('lang', $language);
		}

		parent::setLanguageData();
		parent::setGeneralFunctionsClass();

		$this->theme->setUserTheme(DEFAULT_THEME);


		$this->tmp->initialiseExternClass($this->lang, $this->LNG, $this->USER, $this->theme);

		$this->tmp->assign(array(
			'lang'			=> $this->lang->getLanguage(),
			'Selector'		=> $this->lang->getAllowedLangs(false, $this->cache),
			'title'			=> $this->LNG['title_install'].' &bull; 2Moons',
			'header'		=> $this->LNG['menu_install'],
			'HTTP_PATH'		=> HTTP_PATH,
			'canUpgrade'	=> (is_file(ROOT.'includes'.SEP.'config.php') === true && filesize(ROOT.'includes'.SEP.'config.php') !== 0),
		));
	}
}