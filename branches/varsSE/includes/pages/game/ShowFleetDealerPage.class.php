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
 * @version 1.8.0 (2013-03-18)
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
		global $USER, $PLANET, $LNG;

		$elementId		= HTTP::_GP('shipId', 0);
		$amount			= max(0, round(HTTP::_GP('count', 0.0)));
		$allowedShipIDs	= array_merge(Vars::getElements(Vars::CLASS_FLEET, Vars::FLAG_TRADE), Vars::getElements(Vars::CLASS_DEFENSE, Vars::FLAG_TRADE));

        $elementObj     = Vars::getElement($elementId);
		if(!empty($amount) && in_array($elementId, $allowedShipIDs) && $PLANET[$elementObj->name] >= $amount)
		{
			$tradeCharge					= 1 - (Config::get()->trade_charge / 100);
            $costResource                   = BuildUtil::getElementPrice($elementObj, $amount * $tradeCharge);
            foreach($costResource as $resourceElementId => $resourceAmount)
            {
                $resourceElementObj = Vars::getElement($resourceElementId);

                if($resourceElementObj->isUserResource())
                {
                    $USER[$resourceElementObj->name]    += $resourceAmount;
                }
                else
                {
                    $PLANET[$resourceElementObj->name]    += $resourceAmount;
                }
            }
			
			$PLANET[$elementObj->name]  -= $amount;
            $this->ecoObj->saveToDatabase('PLANET', $elementObj->name);

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
		global $PLANET, $LNG;
		
		$elementsData   = array();

        $allowedShipIDs = Vars::getElements(Vars::CLASS_FLEET, Vars::FLAG_TRADE) + Vars::getElements(Vars::CLASS_DEFENSE, Vars::FLAG_TRADE);

		foreach($allowedShipIDs as $elementId => $elementObj)
		{
            $elementsData[$elementId]	= array(
                'available' => $PLANET[$elementObj->name],
                'price'     => BuildUtil::getElementPrice($elementObj)
            );
		}

		if(empty($elementsData))
		{
			$this->printMessage($LNG['ft_empty']);
		}

		$this->assign(array(
			'elementsData'	=> $elementsData,
			'Charge'	    => Config::get()->trade_charge,
		));
		
		$this->display('page.fleetDealer.default.tpl');
	}
}