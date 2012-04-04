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

class ShowTraderPage extends AbstractPage
{
	public static $requireModule = MODULE_TRADER;

	function __construct() 
	{
		parent::__construct();
	}
	
	public static $Charge = array(
		901	=> array(901 => 1, 902 => 2, 903 => 4),
		902	=> array(901 => 0.5, 902 => 1, 903 => 2),
		903	=> array(901 => 0.25, 902 => 0.5, 903 => 1),
	);
	
	public function show() 
	{
		global $LNG, $uniConfig, $USER;
		
		$this->tplObj->assign_vars(array(
			'tr_cost_dm_trader'		=> sprintf($LNG['tr_cost_dm_trader'], pretty_number($uniConfig['traderResourceCost']), $LNG['tech'][921]),
			'charge'				=> self::$Charge,
			'requiredDarkMatter'	=> $USER['darkmatter'] < $uniConfig['traderResourceCost'] ? sprintf($LNG['tr_empty_darkmatter'], $LNG['tech'][921]) : false,
		));

		$this->display("page.trader.default.tpl");
	}
		
	function trade()
	{
		global $LNG, $uniConfig, $USER;
		
		if ($USER['darkmatter'] < $uniConfig['traderResourceCost']) {
			$this->redirectTo('game.php?page=trader');
		}
		
		$resourceID	= HTTP::_GP('resource', 0);
		
		if(!in_array($resourceID, $reslist['resstype'][1])) {
			$this->printMessage($LNG['invalid_action']);
		}
		
		$tradeResources	= array_values(array_diff($reslist['resstype'][1], array($resourceID)));
		
		$this->tplObj->loadscript("trader.js");
		$this->tplObj->assign_vars(array(
			'resourceID'		=> $resourceID,
			'tradeRessources'	=> $tradeResources,
			'charge' 			=> self::$Charge[$resourceID],
		));

		$this->display('page.trader.trade.tpl');
	}
	
	function send()
	{
		global $USER, $PLANET, $LNG, $uniConfig;
		
		if ($USER['darkmatter'] < $uniConfig['traderResourceCost']) {
			$this->redirectTo('game.php?page=trader');
		}
		
		$resourceID	= HTTP::_GP('resource', 0);
		
		if(!in_array($resourceID, $reslist['resstype'][1])) {
			$this->printMessage($LNG['invalid_action']);
		}

		$getTradeResources	= HTTP::_GP('trade', array());
		
		$tradeResources		= array_values(array_diff($reslist['resstype'][1], array($resourceID)));
		$tradeSum 			= 0;
		
		foreach($tradeResources as $tradeRessID) {
			$tradeAmount	= min(max(0, round((float) $getTradeResources[$tradeRessID])), $PLANET[$GLOBALS['VARS']['ELEMENT'][$tradeRessID]['name']]);
			$tradeSum	   += $tradeAmount;
			if(empty($tradeAmount)) {
				continue;  
			}
			
			$PLANET[$GLOBALS['VARS']['ELEMENT'][$resourceID]['name']]	-= $tradeAmount * self::$Charge[$resourceID][$tradeRessID];			
			$PLANET[$GLOBALS['VARS']['ELEMENT'][$tradeRessID]['name']]	+= $tradeAmount * (1 - $uniConfig['traderResourceCharge']);
		}
		
		if ($tradeSum > 0) {
			$USER[$GLOBALS['VARS']['ELEMENT'][921]['name']]	-= $uniConfig['traderResourceCost'];
		}

		$this->printMessage($LNG['tr_exchange_done'], array("game.php?page=trader", 3));
	}
}
