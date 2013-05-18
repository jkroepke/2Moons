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
 * @copyright 2012 Jan <info@2moons.cc> (2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 2.0.$Revision: 2242 $ (2012-11-31)
 * @info $Id$
 * @link http://2moons.cc/
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
		global $LNG;

		$db = Database::get();

		$page  		= HTTP::_GP('side', 1);

		$sql = "SELECT COUNT(*) as count FROM %%BANNED%% WHERE universe = :universe ORDER BY time DESC;";
		$banCount = $db->selectSingle($sql, array(
			':universe'	=> Universe::current(),
		), 'count');

		$maxPage	= ceil($banCount / BANNED_USERS_PER_PAGE);
		$page		= max(1, min($page, $maxPage));
		
		$sql = "SELECT * FROM %%BANNED%% WHERE universe = :universe ORDER BY time DESC LIMIT :offset, :limit;";
		$banResult = $db->select($sql, array(
			':universe'	=> Universe::current(),
			':offset'	=> (($page - 1) * BANNED_USERS_PER_PAGE),
			':limit'	=> BANNED_USERS_PER_PAGE
		));

		$banList	= array();
		
		foreach($banResult as $banRow)
		{
			$banList[]	= array(
				'player'	=> $banRow['who'],
				'theme'		=> $banRow['theme'],
				'from'		=> _date($LNG['php_tdformat'], $banRow['time'], Config::get()->timezone),
				'to'		=> _date($LNG['php_tdformat'], $banRow['longer'], Config::get()->timezone),
				'admin'		=> $banRow['author'],
				'mail'		=> $banRow['email'],
				'info'		=> sprintf($LNG['bn_writemail'], $banRow['author']),
			);
		}

		$universeSelect	= $this->getUniverseSelector();
		
		$this->assign(array(
			'universeSelect'	=> $universeSelect,
			'banList'			=> $banList,
			'banCount'			=> $banCount,
			'page'				=> $page,
			'maxPage'			=> $maxPage,
		));
		
		$this->display('page.banList.default.tpl');
	}
}