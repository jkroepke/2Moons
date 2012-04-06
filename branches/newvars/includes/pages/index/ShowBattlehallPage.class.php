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


class ShowBattleHallPage extends AbstractPage
{
	public static $requireModule = 0;

	function __construct() 
	{
		parent::__construct();
	}
	
	function show() 
	{
		global $uniAllConfig, $gameConfig, $UNI;
		
		$banResult 	= $GLOBALS['DATABASE']->query("SELECT * FROM ".BANNED." WHERE universe = '".$UNI."' ORDER BY id DESC;");
		$banList	= array();
		
		while($banRow = $GLOBALS['DATABASE']->fetchArray($banResult))
		{
			$banList[]	= array(
				'player'	=> $banRow['who'],
				'theme'		=> $banRow['theme'],
				'from'		=> _date($LNG['php_tdformat'], $banRow['time']),
				'to'		=> _date($LNG['php_tdformat'], $banRow['longer']),
				'admin'		=> $banRow['author'],
				'mail'		=> $banRow['email'],
				'info'		=> sprintf($LNG['bn_writemail'], $banRow['author']),
			);
		}
		
		$AvailableUnis	= array();
		foreach($uniAllConfig as $uniID => $config)
		{
			$AvailableUnis[$uniID]	= $config['uniName'];
		}
		
		ksort($AvailableUnis);
		
		$this->assign_vars(array(
			'AvailableUnis'	=> $AvailableUnis,
			'banList'		=> $banList,
		));
		$this->render('page.banlist.default.tpl');
	}
}