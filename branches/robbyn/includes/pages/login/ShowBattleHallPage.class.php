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

class ShowBattleHallPage extends AbstractPage
{
	public static $requireModule = 0;

	function __construct() 
	{
		parent::__construct();
	}
	
	function show() 
	{
		$hallRaw = $GLOBALS['DATABASE']->query("SELECT *, (
			SELECT DISTINCT
			IF(".TOPKB_USERS.".username = '', GROUP_CONCAT(".USERS.".username SEPARATOR ' & '), GROUP_CONCAT(".TOPKB_USERS.".username SEPARATOR ' & '))
			FROM ".TOPKB_USERS."
			LEFT JOIN ".USERS." ON uid = ".USERS.".id
			WHERE ".TOPKB_USERS.".`rid` = ".TOPKB.".`rid` AND `role` = 1
		) as `attacker`,
		(
			SELECT DISTINCT
			IF(".TOPKB_USERS.".username = '', GROUP_CONCAT(".USERS.".username SEPARATOR ' & '), GROUP_CONCAT(".TOPKB_USERS.".username SEPARATOR ' & '))
			FROM ".TOPKB_USERS." INNER JOIN ".USERS." ON uid = id
			WHERE ".TOPKB_USERS.".`rid` = ".TOPKB.".`rid` AND `role` = 2
		) as `defender`  
		FROM ".TOPKB." WHERE `universe` = '".$GLOBALS['UNI']."' ORDER BY units DESC LIMIT 100;");
		
		$hallList	= array();
		while($hallRow = $GLOBALS['DATABASE']->fetch_array($hallRaw)) {
			$hallList[]	= array(
				'result'	=> $hallRow['result'],
				'time'		=> _date(t('php_tdformat'), $hallRow['time']),
				'units'		=> $hallRow['units'],
				'rid'		=> $hallRow['rid'],
				'attacker'	=> $hallRow['attacker'],
				'defender'	=> $hallRow['defender'],
			);
		}
	
		$GLOBALS['DATABASE']->free_result($hallRaw);
	
		$universeSelect	= array();		
		$uniAllConfig	= Config::getAll('universe');
		
		foreach($uniAllConfig as $uniID => $uniConfig)
		{
			$universeSelect[$uniID]	= $uniConfig['uni_name'];
		}
		
		$this->assign(array(
			'universeSelect'	=> $universeSelect,
			'hallList'			=> $hallList,
		));
		$this->render('page.battleHall.default.tpl');
	}
}