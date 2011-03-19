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
 * @version 1.3 (2011-01-21)
 * @link http://code.google.com/p/2moons/
 */

function ShowTraderPage()
{
	global $USER, $PLANET, $LNG, $db;
	$ress 		= request_var('ress', '');
	$action 	= request_var('action', '');
	$metal		= round(request_var('metal', 0.0), 0);
	$crystal 	= round(request_var('crystal', 0.0), 0);
	$deut		= round(request_var('deuterium', 0.0), 0);

	$PlanetRess = new ResourceUpdate();
	
	$template	= new template();
	$template->loadscript("trader.js");

	if ($ress != '')
	{
		switch ($ress) {
			case 'metal':
				if($action == "trade")
				{
					if ($USER['darkmatter'] < DARKMATTER_FOR_TRADER)
						$template->message(sprintf($LNG['tr_empty_darkmatter'], $LNG['Darkmatter']), "game.php?page=trader", 1);
					elseif ($crystal < 0 || $deut < 0)
						$template->message($LNG['tr_only_positive_numbers'], "game.php?page=trader",1);
					else
					{
						$trade	= ($crystal * 2 + $deut * 4);
						$PlanetRess->CalcResource();
						if ($PLANET['metal'] > $trade)
						{
							$PLANET['metal']     -= $trade;
							$PLANET['crystal']   += $crystal;
							$PLANET['deuterium'] += $deut;
							$USER['darkmatter']	-= DARKMATTER_FOR_TRADER;
							$template->message($LNG['tr_exchange_done'],"game.php?page=trader",1);
						}
						else
							$template->message($LNG['tr_not_enought_metal'], "game.php?page=trader", 1);
							
						$PlanetRess->SavePlanetToDB();
					}
				} else {
					$template->assign_vars(array(
						'tr_resource'		=> $LNG['tr_resource'],
						'tr_sell_metal'		=> $LNG['tr_sell_metal'],
						'tr_amount'			=> $LNG['tr_amount'],
						'tr_exchange'		=> $LNG['tr_exchange'],	
						'tr_quota_exchange'	=> $LNG['tr_quota_exchange'],
						'Metal'				=> $LNG['Metal'],
						'Crystal'			=> $LNG['Crystal'],
						'Deuterium'			=> $LNG['Deuterium'],
						'mod_ma_res_a' 		=> "2",
						'mod_ma_res_b' 		=> "4",
						'ress' 				=> $ress,
					));

					$template->show("trader_metal.tpl");	
				}
			break;
			case 'crystal':
				if($action == "trade")
				{
					if ($USER['darkmatter'] < DARKMATTER_FOR_TRADER)
						$template->message(sprintf($LNG['tr_empty_darkmatter'], $LNG['Darkmatter']), "game.php?page=trader", 1);
					elseif ($metal < 0 || $deut < 0)
						$template->message($LNG['tr_only_positive_numbers'], "game.php?page=trader",1);
					else
					{
						$trade	= ($metal * 0.5 + $deut * 2);						
						$PlanetRess->CalcResource();
						if ($PLANET['crystal'] > $trade)
						{
							$PLANET['metal']     += $metal;
							$PLANET['crystal']   -= $trade;
							$PLANET['deuterium'] += $deut;
							$USER['darkmatter']	-= DARKMATTER_FOR_TRADER;
							$template->message($LNG['tr_exchange_done'],"game.php?page=trader",1);
						}
						else
							$template->message($LNG['tr_not_enought_crystal'], "game.php?page=trader", 1);
						
						$PlanetRess->SavePlanetToDB();
					}
				} else {
					$template->assign_vars(array(
						'tr_resource'		=> $LNG['tr_resource'],
						'tr_sell_crystal'	=> $LNG['tr_sell_crystal'],
						'tr_amount'			=> $LNG['tr_amount'],
						'tr_exchange'		=> $LNG['tr_exchange'],	
						'tr_quota_exchange'	=> $LNG['tr_quota_exchange'],
						'Metal'				=> $LNG['Metal'],
						'Crystal'			=> $LNG['Crystal'],
						'Deuterium'			=> $LNG['Deuterium'],
						'mod_ma_res_a' 		=> "0.5",
						'mod_ma_res_b' 		=> "2",
						'ress' 				=> $ress,
					));

					$template->show("trader_crystal.tpl");	
				}
			break;
			case 'deuterium':
				if($action == "trade")
				{
					if ($USER['darkmatter'] < DARKMATTER_FOR_TRADER)
						$template->message(sprintf($LNG['tr_empty_darkmatter'], $LNG['Darkmatter']), "game.php?page=trader", 1);
					elseif ($metal < 0 || $crystal < 0)
						message($LNG['tr_only_positive_numbers'], "game.php?page=trader",1);
					else
					{
						$trade	= ($metal * 0.25 + $crystal * 0.5);						
						$PlanetRess->CalcResource();
						if ($PLANET['deuterium'] > $trade)
						{
							$PLANET['metal']     += $metal;
							$PLANET['crystal']   += $crystal;
							$PLANET['deuterium'] -= $trade;
							$USER['darkmatter']	-= DARKMATTER_FOR_TRADER;
							$template->message($LNG['tr_exchange_done'],"game.php?page=trader", 1);
						}
						else
							$template->message($LNG['tr_not_enought_deuterium'], "game.php?page=trader", 1);
							
						$PlanetRess->SavePlanetToDB();
					}
				} else {
					$template->assign_vars(array(
						'tr_resource'		=> $LNG['tr_resource'],
						'tr_sell_deuterium'	=> $LNG['tr_sell_deuterium'],
						'tr_amount'			=> $LNG['tr_amount'],
						'tr_exchange'		=> $LNG['tr_exchange'],	
						'tr_quota_exchange'	=> $LNG['tr_quota_exchange'],
						'Metal'				=> $LNG['Metal'],
						'Crystal'			=> $LNG['Crystal'],
						'Deuterium'			=> $LNG['Deuterium'],
						'mod_ma_res_a' 		=> "0.25",
						'mod_ma_res_b' 		=> "0.5",
						'ress' 				=> $ress,
					));

					$template->show("trader_deuterium.tpl");	
				}
			break;
		}
	}
	else
	{
		$PlanetRess->CalcResource();
		$PlanetRess->SavePlanetToDB();
		$template->assign_vars(array(
			'tr_cost_dm_trader'			=> sprintf($LNG['tr_cost_dm_trader'], pretty_number(DARKMATTER_FOR_TRADER), $LNG['Darkmatter']),
			'tr_call_trader_who_buys'	=> $LNG['tr_call_trader_who_buys'],
			'tr_call_trader'			=> $LNG['tr_call_trader'],
			'tr_exchange_quota'			=> $LNG['tr_exchange_quota'],
			'tr_call_trader_submit'		=> $LNG['tr_call_trader_submit'],
			'Metal'						=> $LNG['Metal'],
			'Crystal'					=> $LNG['Crystal'],
			'Deuterium'					=> $LNG['Deuterium'],
		));

		$template->show("trader_overview.tpl");
	}
}
?>