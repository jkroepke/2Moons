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
 * @version 1.7.0 (2012-05-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

class ShowBanListPage extends AbstractPage 
{
	public static $requireModule = MODULE_BANLIST;

	function __construct() 
	{
		parent::__construct();
	}

	function show()
	{
		global $USER, $PLANET, $LNG, $UNI;
		
		$page  		= HTTP::_GP('site', 1);
		
		$banCount	= $GLOBALS['DATABASE']->countquery("SELECT COUNT(*) FROM ".BANNED." WHERE universe = ".$UNI." ORDER BY time DESC;");
		
		$maxPage	= ceil($banCount / BANNED_USERS_PER_PAGE);
		$page		= max(1, min($page, $maxPage));
		
		$banResult	= $GLOBALS['DATABASE']->query("SELECT * FROM ".BANNED." WHERE universe = ".$UNI." ORDER BY time DESC LIMIT ".(($page - 1) * BANNED_USERS_PER_PAGE).", ".BANNED_USERS_PER_PAGE.";");
		$banList	= array();
		
		while($banRow = $GLOBALS['DATABASE']->fetchArray($banResult))
		{
			$banList[]	= array(
				'player'	=> $banRow['who'],
				'theme'		=> $banRow['theme'],
				'from'		=> DateUtil::formatDate($LNG['php_tdformat'], $banRow['time'], $USER['timezone']),
				'to'		=> DateUtil::formatDate($LNG['php_tdformat'], $banRow['longer'], $USER['timezone']),
				'admin'		=> $banRow['author'],
				'mail'		=> $banRow['email'],
				'info'		=> sprintf($LNG['bn_writemail'], $banRow['author']),
			);
		}
		
		$GLOBALS['DATABASE']->free_result($banResult);
		
		$this->assign(array(	
			'banList'	=> $banList,
			'banCount'	=> $banCount,
			'page'		=> $page,
			'maxPage'	=> $maxPage,
		));
		
		$this->render('page.banList.default.tpl');
	}
}