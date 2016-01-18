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


class ShowFleetDealerPage extends AbstractGamePage
{
	public static $requireModule = MODULE_FLEET_TRADER;

	function __construct() 
	{
		parent::__construct();
	}
	
	public function send()
	{
		global $USER, $PLANET, $LNG, $pricelist, $resource;
		
		$shipID			= HTTP::_GP('shipID', 0);
		$Count			= max(0, round(HTTP::_GP('count', 0.0)));
		$allowedShipIDs	= explode(',', Config::get()->trade_allowed_ships);
		
		if(!empty($shipID) && !empty($Count) && in_array($shipID, $allowedShipIDs) && $PLANET[$resource[$shipID]] >= $Count)
		{
			$tradeCharge					= 1 - (Config::get()->trade_charge / 100);
			$PLANET[$resource[901]]			+= $Count * $pricelist[$shipID]['cost'][901] * $tradeCharge;
			$PLANET[$resource[902]]			+= $Count * $pricelist[$shipID]['cost'][902] * $tradeCharge;
			$PLANET[$resource[903]]			+= $Count * $pricelist[$shipID]['cost'][903] * $tradeCharge;
			$USER[$resource[921]]			+= $Count * $pricelist[$shipID]['cost'][921] * $tradeCharge;
			
			$PLANET[$resource[$shipID]]		-= $Count;

            $sql = 'UPDATE %%PLANETS%% SET '.$resource[$shipID].' = '.$resource[$shipID].' - :count WHERE id = :planetID;';
			Database::get()->update($sql, array(
                ':count'        => $Count,
                ':planetID'     => $PLANET['id']
            ));

            $this->printMessage($LNG['tr_exchange_done'], array(array(
				'label'	=> $LNG['sys_forward'],
				'url'	=> 'game.php?page=fleetDealer'
			)));
		}
		else
		{
			$this->printMessage($LNG['tr_exchange_error'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleetDealer'
			)));
		}
		
	}
	
	function show()
	{
		global $PLANET, $LNG, $pricelist, $resource, $reslist;
		
		$Cost		= array();
		
		$allowedShipIDs	= explode(',', Config::get()->trade_allowed_ships);
		
		foreach($allowedShipIDs as $shipID)
		{
			if(in_array($shipID, $reslist['fleet']) || in_array($shipID, $reslist['defense'])) {
				$Cost[$shipID]	= array($PLANET[$resource[$shipID]], $LNG['tech'][$shipID], $pricelist[$shipID]['cost']);
			}
		}
		
		if(empty($Cost))
		{
			$this->printMessage($LNG['ft_empty'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=fleetDealer'
			)));
		}

		$this->assign(array(
			'shipIDs'	=> $allowedShipIDs,
			'CostInfos'	=> $Cost,
			'Charge'	=> Config::get()->trade_charge,
		));
		
		$this->display('page.fleetDealer.default.tpl');
	}
}