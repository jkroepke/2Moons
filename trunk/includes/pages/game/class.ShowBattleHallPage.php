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
 * @version 1.6.1 (2011-11-19)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

class ShowBattleHallPage extends AbstractPage
{
	public static $requireModule = MODULE_BATTLEHALL;
	
	function __construct() {
		parent::__construct();
	}
	
	function show()
	{
		global $USER, $PLANET, $LNG, $UNI, $LANG;
		$mode = HTTP::_GP('mode','');
		$order = HTTP::_GP('order', 'units');
		$sort = HTTP::_GP('sort', 'desc');
		$sort = strtoupper($sort);
		
		$top = $GLOBALS['DATABASE']->query("SELECT *, (
			SELECT DISTINCT
			GROUP_CONCAT(username SEPARATOR ' & ') as attacker
			FROM ".TOPKB_USERS." INNER JOIN ".USERS." ON uid = id AND `role` = 1
			WHERE ".TOPKB_USERS.".`rid` = ".TOPKB.".`rid`
		) as `attacker`,
		(
			SELECT DISTINCT
			GROUP_CONCAT(username SEPARATOR ' & ') as attacker
			FROM ".TOPKB_USERS." INNER JOIN ".USERS." ON uid = id AND `role` = 2
			WHERE ".TOPKB_USERS.".`rid` = ".TOPKB.".`rid`
		) as `defender`  
		FROM ".TOPKB." WHERE `universe` = '".$UNI."' ORDER BY units DESC LIMIT 100;");
		
		$TopKBList	= array();
		$i = 1;
		while($data = $GLOBALS['DATABASE']->fetch_array($top))
		{
			switch($order)
			{
				case 'date':
					$key = $data['time'].$data['rid'];
				break;
				case 'owner':
					$key = $data['attacker'].$data['rid'];
				break;
				case 'units':
				default:
					$key = $data['units'].$data['rid'];
				break;
			}
			
			$TopKBList[$key]	= array(
				'rank'		=> $i++,
				'result'	=> $data['result'],
				'date'		=> _date($LNG['php_tdformat'], $data['time'], $USER['timezone']),
				'time'		=> TIMESTAMP - $data['time'],
				'units'		=> $data['units'],
				'rid'		=> $data['rid'],
				'attacker'	=> $data['attacker'],
				'defender'	=> $data['defender'],
			);
		}
		
		ksort($TopKBList);

		if($sort === "DESC")
		{
			$TopKBList	= array_reverse($TopKBList);
		}
		else
		{	
			$sort = "ASC";
		}
		
		$GLOBALS['DATABASE']->free_result($top);

		$this->tplObj->assign_vars(array(
			'TopKBList'		=> $TopKBList,
			'sort'			=> $sort,
			'order'			=> $order,
		));
		
		$this->display('page.battlehall.default.tpl');
	}
}
?>