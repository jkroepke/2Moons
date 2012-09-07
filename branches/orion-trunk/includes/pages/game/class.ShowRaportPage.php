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

class ShowRaportPage extends AbstractPage
{
	public static $requireModule = 0;
	
	protected $disableEcoSystem = true;

	function __construct() 
	{
		parent::__construct();
	}
	
	function battlehall() 
	{
		global $LNG, $USER;
		
		$this->setWindow('popup');
		
		$RID		= HTTP::_GP('raport', 0);
		
		$Raport		= $GLOBALS['DATABASE']->uniquequery("SELECT 
		raport, time,
		(
			SELECT 
			GROUP_CONCAT(username SEPARATOR ' & ') as attacker
			FROM ".USERS." 
			WHERE id IN (SELECT uid FROM ".TOPKB_USERS." WHERE ".TOPKB_USERS.".rid = ".RW.".rid AND role = 1)
		) as attacker,
		(
			SELECT 
			GROUP_CONCAT(username SEPARATOR ' & ') as defender
			FROM ".USERS." 
			WHERE id IN (SELECT uid FROM ".TOPKB_USERS." WHERE ".TOPKB_USERS.".rid = ".RW.".rid AND role = 2)
		) as defender
		FROM ".RW."
		WHERE rid = ".$RID.";");
		
		$Info		= array($Raport["attacker"], $Raport["defender"]);
		
		if(!isset($Raport)) {
			$this->printMessage($LNG['sys_raport_not_found']);
		}
		
		$CombatRaport			= unserialize($Raport['raport']);
		$CombatRaport['time']	= _date($LNG['php_tdformat'], $CombatRaport['time'], $USER['timezone']);

		$this->tplObj->assign_vars(array(
			'Raport'	=> $CombatRaport,
			'Info'		=> $Info,
		));
		
		$this->display('shared.mission.raport.tpl');
	}
	
	function show() 
	{
		global $LNG, $USER;
		
		$this->setWindow('popup');
		
		$RID		= HTTP::_GP('raport', 0);
		
		$Raport		= $GLOBALS['DATABASE']->countquery("SELECT raport FROM ".RW." WHERE rid = ".$RID.";");
		$Info		= array();
		
		if(!isset($Raport)) {
			$this->printMessage($LNG['sys_raport_not_found']);
		}

		$CombatRaport	= unserialize($Raport);
		$CombatRaport['time']	= _date($LNG['php_tdformat'], $CombatRaport['time'], (isset($USER['timezone']) ? $USER['timezone'] : $CONF['timezone']));
		
		if(isset($INFO['moon']['desfail']))
		{
			// 2Moons BC r2321
			$CombatRaport['moon']	= array(
				'moonName'				=> $CombatRaport['moon']['name'],
				'moonChance'			=> $CombatRaport['moon']['chance'],
				'moonDestroySuccess'	=> !$CombatRaport['moon']['desfail'],
				'fleetDestroyChance'	=> $CombatRaport['moon']['chance2'],
				'fleetDestroySuccess'	=> !$INFO['moon']['fleetfail']
			);
		}
		
		$this->tplObj->assign_vars(array(
			'Raport'	=> $CombatRaport,
		));
		
		$this->display('shared.mission.raport.tpl');
	}
}
?>