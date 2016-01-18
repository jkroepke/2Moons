<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @licence MIT
 * @version 1.7.2 (2013-03-18)
 * @info $Id$
 * @link http://2moons.cc/
 */

class ShowBanListPage extends AbstractGamePage
{
	public static $requireModule = MODULE_BANLIST;

	function __construct()
	{
		parent::__construct();
	}

	function show()
	{
		global $USER, $LNG;

		$page  	= HTTP::_GP('side', 1);
		$db 	= Database::get();

		$sql = "SELECT COUNT(*) as count FROM %%BANNED%% WHERE universe = :universe ORDER BY time DESC;";
		$banCount = $db->selectSingle($sql, array(
			':universe'	=> Universe::current()
		), 'count');

		$maxPage	= ceil($banCount / BANNED_USERS_PER_PAGE);
		$page		= max(1, min($page, $maxPage));

		$sql = "SELECT * FROM %%BANNED%% WHERE universe = :universe ORDER BY time DESC LIMIT :offset, :limit;";
		$banResult = $db->select($sql, array(
			':universe'	=> Universe::current(),
			':offset'   => (($page - 1) * BANNED_USERS_PER_PAGE),
			':limit'    => BANNED_USERS_PER_PAGE,
		));

		$banList	= array();

		foreach ($banResult as $banRow)
		{
			$banList[]	= array(
				'player'	=> $banRow['who'],
				'theme'		=> $banRow['theme'],
				'from'		=> _date($LNG['php_tdformat'], $banRow['time'], $USER['timezone']),
				'to'		=> _date($LNG['php_tdformat'], $banRow['longer'], $USER['timezone']),
				'admin'		=> $banRow['author'],
				'mail'		=> $banRow['email'],
				'info'		=> sprintf($LNG['bn_writemail'], $banRow['author']),
			);
		}

		$this->assign(array(
			'banList'	=> $banList,
			'banCount'	=> $banCount,
			'page'		=> $page,
			'maxPage'	=> $maxPage,
		));

		$this->display('page.banList.default.tpl');
	}
}