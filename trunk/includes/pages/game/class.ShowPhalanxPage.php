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


class ShowPhalanxPage extends AbstractPage
{
	public static $requireModule = MODULE_PHALANX;
	
	static function allowPhalanx($toGalaxy, $toSystem)
	{
		global $PLANET, $resource;

		if ($PLANET['galaxy'] != $toGalaxy || $PLANET[$resource[42]] == 0 || !isModulAvalible(MODULE_PHALANX) || $PLANET[$resource[903]] < PHALANX_DEUTERIUM) {
			return false;
		}
		
		$PhRange	= self::GetPhalanxRange($PLANET[$resource[42]]);
		$systemMin  = max(1, $PLANET['system'] - $PhRange);
		$systemMax  = $PLANET['system'] + $PhRange;
		
		return $toSystem >= $systemMin && $toSystem <= $systemMax;
	}

	static function GetPhalanxRange($PhalanxLevel)
	{
		return ($PhalanxLevel == 1) ? 1 : pow($PhalanxLevel, 2) - 1;
	}
	
	function __construct() {
		
	}
	
	function show()
	{
		global $USER, $PLANET, $LNG, $UNI;

		$FlyingFleetsTable 	= new FlyingFleetsTable();

		$this->setWindow('popup');

		$this->tplObj->loadscript('phalanx.js');
		
		$PhRange 		 	= self::GetPhalanxRange($PLANET[$resource[43]]);
		$Galaxy 			= HTTP::_GP('id', 0);
		
		if($Galaxy != $PLANET['galaxy'] || $System > ($PLANET['system'] + $PhRange) || $System < max(1, $PLANET['system'] - $PhRange))
		{
			$this->printMessage($LNG['px_out_of_range']);
		}
		
		if ($PLANET[$resource[903]] == PHALANX_DEUTERIUM)
		{
			$this->printMessage($LNG['px_no_deuterium']);
		}

		$GLOBALS['DATABASE']->query("UPDATE ".PLANETS." SET `deuterium` = `deuterium` - ".PHALANX_DEUTERIUM." WHERE `id` = '".$PLANET['id']."';");
		
		$TargetInfo = $GLOBALS['DATABASE']->uniquequery("SELECT id, name, id_owner FROM ".PLANETS." WHERE`universe` = '".$UNI."' AND `galaxy` = '".$Galaxy."' AND `system` = '".$System."' AND `planet` = '".$Planet."' AND `planet_type` = '1';");
		
		if(empty($TargetInfo))
		{
			$this->printMessage($LNG['px_out_of_range']);
		}
		
		require_once(ROOT_PATH . 'includes/classes/class.FlyingFleetsTable.php');
		$fleetTableObj = new FlyingFleetsTable;
		$fleetTableObj->setPhalanxMode();
		$fleetTableObj->setUser($TargetInfo['id_owner']);
		$fleetTableObj->setPlanet($TargetInfo['id']);
		$fleetTable	=  $fleetTableObj->renderTable();
		
		$this->tplObj->assign_vars(array(
			'galaxy'  		=> $Galaxy,
			'system'  		=> $System,
			'planet'   		=> $Planet,
			'name'    		=> $TargetInfo['name'],
			'fleetTables'	=> $fleetTable,
		));
		
		$this->display('page.phalanx.default.tpl');			
	}
}
?>