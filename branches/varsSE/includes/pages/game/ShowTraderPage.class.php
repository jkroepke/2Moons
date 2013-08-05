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


class ShowTraderPage extends AbstractGamePage
{
	public static $requireModule = MODULE_TRADER;

    public static $Charge = array(
        901	=> array(901 => 1, 902 => 2, 903 => 4),
        902	=> array(901 => 0.5, 902 => 1, 903 => 2),
        903	=> array(901 => 0.25, 902 => 0.5, 903 => 1),
    );

    private $allowedElements    = NULL;

	function __construct() 
	{
		parent::__construct();
        $this->allowedElements = Vars::getElements(VARS::CLASS_RESOURCE, VARS::FLAG_TRADE);
	}
	
	public function show() 
	{
		global $LNG, $USER;

		$darkmatter_cost_trader	= Config::get()->darkmatter_cost_trader;

		$this->assign(array(
			'tr_cost_dm_trader'		=> sprintf($LNG['tr_cost_dm_trader'], pretty_number($darkmatter_cost_trader), $LNG['tech'][921]),
			'charge'				=> self::$Charge,
			'elementData'			=> $this->allowedElements,
			'requiredDarkMatter'	=> $USER['darkmatter'] < $darkmatter_cost_trader ? sprintf($LNG['tr_not_enought'], $LNG['tech'][921]) : false,
		));
		
		$this->display("page.trader.default.tpl");
	}
		
	function trade()
	{
		global $USER, $LNG;
		
		if ($USER['darkmatter'] < Config::get()->darkmatter_cost_trader)
        {
			$this->redirectTo('game.php?page=trader');
		}
		
		$elementId	= HTTP::_GP('resource', 0);
		
		if(!in_array($elementId, array_keys($this->allowedElements)))
        {
			$this->printMessage($LNG['invalid_action'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=trader'
			)));
		}
		
		$tradeResources	= array_values(array_diff(array_keys(self::$Charge[$elementId]), array($elementId)));

		$this->tplObj->loadscript("trader.js");
		$this->assign(array(
			'tradeResourceID'	=> $elementId,
			'tradeResources'	=> $tradeResources,
			'charge' 			=> self::$Charge[$elementId],
		));

		$this->display('page.trader.trade.tpl');
	}
	
	function send()
	{
		global $USER, $PLANET, $LNG;
		
		if ($USER['darkmatter'] < Config::get()->darkmatter_cost_trader) {
			$this->redirectTo('game.php?page=trader');
		}
		
		$elementId	= HTTP::_GP('resource', 0);
		
		if(!in_array($elementId, array_keys($this->allowedElements))) {
			$this->printMessage($LNG['invalid_action'], array(array(
				'label'	=> $LNG['sys_back'],
				'url'	=> 'game.php?page=trader'
			)));
		}

        $elementName        = Vars::getElement($elementId)->name;

		$getTradeResources	= HTTP::_GP('trade', array());
		
		$tradeResources		= array_values(array_diff(array_keys(self::$Charge[$elementId]), array($elementId)));
		$tradeSum 			= 0;
		
		foreach($tradeResources as $tradeElementId)
		{
			if(!isset($getTradeResources[$tradeElementId]))
			{
				continue;
			}
			$tradeAmount	= max(0, round((float) $getTradeResources[$tradeElementId]));
			
			if(empty($tradeAmount) || !isset(self::$Charge[$elementId][$tradeElementId]))
			{
				continue;  
			}

			if(isset($PLANET[$elementName]))
			{
				$usedResources	= $tradeAmount * self::$Charge[$elementId][$tradeElementId];
				
				if($usedResources > $PLANET[$elementName])
				{
					$this->printMessage(sprintf($LNG['tr_not_enought'], $LNG['tech'][$elementId]), array(array(
						'label'	=> $LNG['sys_back'],
						'url'	=> 'game.php?page=trader'
					)));
				}
				
				$tradeSum               += $tradeAmount;
				$PLANET[$elementName]   -= $usedResources;
			}
			elseif(isset($USER[$elementName]))
			{
				if($elementId == 921)
				{
					$USER[$elementName]	-= Config::get()->darkmatter_cost_trader;
				}
				
				$usedResources	= $tradeAmount * self::$Charge[$elementId][$tradeElementId];
				
				if($usedResources > $USER[$elementName])
				{
					$this->printMessage(sprintf($LNG['tr_not_enought'], $LNG['tech'][$elementId]), array(array(
						'label'	=> $LNG['sys_back'],
						'url'	=> 'game.php?page=trader'
					)));
				}
				
				$tradeSum           += $tradeAmount;
                $USER[$elementName] -= $usedResources;
				
				if($elementId == 921)
				{
					$USER[$elementName]	+= Config::get()->darkmatter_cost_trader;
				}
			}
			else
			{
				throw new Exception('Unknown resource ID #'.$elementId);
			}

            $tradeElementName    = Vars::getElement($tradeElementId)->name;
			
			if(isset($PLANET[$tradeElementName]))
			{
				$PLANET[$tradeElementName]  += $tradeAmount;
			}
			elseif(isset($USER[$tradeElementName]))
			{
				$USER[$tradeElementName]    += $tradeAmount;
			}
			else
			{
				throw new Exception('Unknown resource ID #'.$tradeElementId);
			}
		}
		
		if ($tradeSum > 0)
		{
			$USER[Vars::getElement(921)->name]	-= Config::get()->darkmatter_cost_trader;
		}
		
		$this->printMessage($LNG['tr_exchange_done'], array(array(
			'label'	=> $LNG['sys_forward'],
			'url'	=> 'game.php?page=trader'
		)));
	}
}