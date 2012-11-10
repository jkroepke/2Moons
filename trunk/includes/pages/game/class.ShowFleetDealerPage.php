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
 * @version 1.7.0 (2012-12-31)
 * @info $Id$
 * @link http://2moons.cc/
 */


class ShowFleetDealerPage extends AbstractPage
{
	public static $requireModule = MODULE_FLEET_TRADER;

	function __construct() 
	{
		parent::__construct();
	}
	
	public function send()
	{
		global $USER, $PLANET, $LNG, $CONF, $pricelist, $resource, $reslist;
		
		$shipID			= HTTP::_GP('shipID', 0);
		$Count			= max(0, round(HTTP::_GP('count', 0.0)));
		$allowedShipIDs	= explode(',', Config::get('trade_allowed_ships'));
		
		if(!empty($shipID) && in_array($shipID, $allowedShipIDs) && $PLANET[$resource[$shipID]] >= $Count)
		{
			$PLANET[$resource[901]]			+= $Count * $pricelist[$shipID]['cost'][901] * (1 - (Config::get('trade_charge') / 100));
			$PLANET[$resource[902]]			+= $Count * $pricelist[$shipID]['cost'][902] * (1 - (Config::get('trade_charge') / 100));
			$PLANET[$resource[903]]			+= $Count * $pricelist[$shipID]['cost'][903] * (1 - (Config::get('trade_charge') / 100));
			$USER[$resource[921]]			+= $Count * $pricelist[$shipID]['cost'][921] * (1 - (Config::get('trade_charge') / 100));
			
			$PLANET[$resource[$shipID]]		-= $Count;
			
			$GLOBALS['DATABASE']->query("UPDATE ".PLANETS." SET ".$resource[$shipID]." = ".$resource[$shipID]." - ".$Count." WHERE id = ".$PLANET['id'].";");
			$this->printMessage($LNG['tr_exchange_done'], array("game.php?page=fleettrader", 3));
		}
		else
		{
			$this->printMessage($LNG['tr_exchange_error'], array("game.php?page=fleettrader", 3));
		}
		
	}
	
	function show()
	{
		global $PLANET, $LNG, $CONF, $pricelist, $resource, $reslist;
		
		$Cost		= array();
		
		$allowedShipIDs	= explode(',', Config::get('trade_allowed_ships'));
		
		foreach($allowedShipIDs as $shipID)
		{
			if(in_array($shipID, $reslist['fleet']) || in_array($shipID, $reslist['defense'])) {
				$Cost[$shipID]	= array($PLANET[$resource[$shipID]], $LNG['tech'][$shipID], $pricelist[$shipID]['cost']);
			}
		}
		
		if(empty($Cost)) {
			$this->printMessage($LNG['ft_empty']);
		}

		$this->tplObj->loadscript('fleettrader.js');
		$this->tplObj->execscript('updateVars();');
		$this->tplObj->assign_vars(array(
			'shipIDs'	=> $allowedShipIDs,
			'CostInfos'	=> $Cost,
			'Charge'	=> Config::get('trade_charge'),
		));
		
		$this->display('page.fleetDealer.default.tpl');
	}
}
?>