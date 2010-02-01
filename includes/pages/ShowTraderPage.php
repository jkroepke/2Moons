<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
# *																			 #
# *																			 #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.									 #
# *																			 #
# *  This program is distributed in the hope that it will be useful,		 #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of			 #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 #
# *  GNU General Public License for more details.							 #
# *																			 #
##############################################################################

if(!defined('INSIDE')){ die(header("location:../../"));}

function ShowTraderPage($CurrentUser, $CurrentPlanet)
{
	global $phpEx, $lang, $db;
	$ress 		= request_var('ress', '');
	$action 	= request_var('action', '');
	$metal		= request_var('metal', 0);
	$crystal 	= request_var('crystal', '');
	$deut		= request_var('deut', 0);

	$PlanetRess = new ResourceUpdate($CurrentUser, $CurrentPlanet);
	$template	= new template();
	$template->loadscript("trader.js");
	$template->set_vars($CurrentUser, $CurrentPlanet);
	$template->page_topnav();
	
	$template->page_header();
	$template->page_leftmenu();
	$template->page_planetmenu();
	$template->page_footer();

	if ($ress != '')
	{
		switch ($ress) {
			case 'metal':
				if($action == "trade")
				{
					if ($crystal < 0 or $deut < 0)
						$template->message($lang['tr_only_positive_numbers'], "game." . $phpEx . "?page=trader",1);
					else
					{
						$trade	= ($crystal * 2 + $deut * 4);
						
						if ($CurrentPlanet['metal'] > $trade)
						{
							$CurrentPlanet['metal']     -= $trade;
							$CurrentPlanet['crystal']   += $crystal;
							$CurrentPlanet['deuterium'] += $deut;
							$template->message($lang['tr_exchange_done'],"game." . $phpEx . "?page=trader",1);
						}
						else
							$template->message($lang['tr_not_enought_metal'], "game." . $phpEx . "?page=trader", 1);
					}
				} else {
					$template->assign_vars(array(
						'tr_resource'		=> $lang['tr_resource'],
						'tr_sell_metal'		=> $lang['tr_sell_metal'],
						'tr_amount'			=> $lang['tr_amount'],
						'tr_exchange'		=> $lang['tr_exchange'],	
						'tr_quota_exchange'	=> $lang['tr_quota_exchange'],
						'Metal'				=> $lang['Metal'],
						'Crystal'			=> $lang['Crystal'],
						'Deuterium'			=> $lang['Deuterium'],
						'mod_ma_res_a' 		=> 2,
						'mod_ma_res_b' 		=> 4,
						'ress' 				=> $ress,
					));

					$template->show("trader_metal.tpl");	
				}
			break;
			case 'crystal':
				if($action == "trade")
				{
					if ($metal < 0 or $deut < 0)
						$template->message($lang['tr_only_positive_numbers'], "game." . $phpEx . "?page=trader",1);
					else
					{
						$trade	= ($metal * 0.5 + $deut * 2);

						if ($CurrentPlanet['crystal'] > $trade)
						{
							$CurrentPlanet['metal']     += $metal;
							$CurrentPlanet['crystal']   -= $trade;
							$CurrentPlanet['deuterium'] += $deut;
							$template->message($lang['tr_exchange_done'],"game." . $phpEx . "?page=trader",1);
						}
						else
							$template->message($lang['tr_not_enought_crystal'], "game." . $phpEx . "?page=trader", 1);
					}
				} else {
					$template->assign_vars(array(
						'tr_resource'		=> $lang['tr_resource'],
						'tr_sell_crystal'	=> $lang['tr_sell_crystal'],
						'tr_amount'			=> $lang['tr_amount'],
						'tr_exchange'		=> $lang['tr_exchange'],	
						'tr_quota_exchange'	=> $lang['tr_quota_exchange'],
						'Metal'				=> $lang['Metal'],
						'Crystal'			=> $lang['Crystal'],
						'Deuterium'			=> $lang['Deuterium'],
						'mod_ma_res_a' 		=> 0.5,
						'mod_ma_res_b' 		=> 2,
						'ress' 				=> $ress,
					));

					$template->show("trader_crystal.tpl");	
				}
			break;
			case 'deuterium':
				if($action == "trade")
				{
					if ($metal < 0 or $crystal < 0)
						message($lang['tr_only_positive_numbers'], "game." . $phpEx . "?page=trader",1);
					else
					{
						$trade	= ($metal * 0.25 + $crystal * 0.5);

						if ($CurrentPlanet['deuterium'] > $trade)
						{
							$CurrentPlanet['metal']     += $metal;
							$CurrentPlanet['crystal']   += $crystal;
							$CurrentPlanet['deuterium'] -= $trade;
							$template->message($lang['tr_exchange_done'],"game." . $phpEx . "?page=trader", 1);
						}
						else
							$template->message($lang['tr_not_enought_deuterium'], "game." . $phpEx . "?page=trader", 1);
					}
				} else {
					$template->assign_vars(array(
						'tr_resource'		=> $lang['tr_resource'],
						'tr_sell_deuterium'	=> $lang['tr_sell_deuterium'],
						'tr_amount'			=> $lang['tr_amount'],
						'tr_exchange'		=> $lang['tr_exchange'],	
						'tr_quota_exchange'	=> $lang['tr_quota_exchange'],
						'Metal'				=> $lang['Metal'],
						'Crystal'			=> $lang['Crystal'],
						'Deuterium'			=> $lang['Deuterium'],
						'mod_ma_res_a' 		=> 0.25,
						'mod_ma_res_b' 		=> 0.5,
						'ress' 				=> $ress,
					));

					$template->show("trader_deuterium.tpl");	
				}
			break;
		}
	}
	else
	{
		$template->assign_vars(array(
			'tr_call_trader_who_buys'	=> $lang['tr_call_trader_who_buys'],
			'tr_call_trader'			=> $lang['tr_call_trader'],
			'tr_exchange_quota'			=> $lang['tr_exchange_quota'],
			'tr_call_trader_submit'		=> $lang['tr_call_trader_submit'],
			'Metal'						=> $lang['Metal'],
			'Crystal'					=> $lang['Crystal'],
			'Deuterium'					=> $lang['Deuterium'],
		));

		$template->show("trader_overview.tpl");
	}
	
	$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
}
?>