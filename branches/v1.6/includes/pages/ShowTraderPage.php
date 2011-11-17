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
 * @version 1.6 (2011-11-17)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

function ShowTraderPage()
{
	global $USER, $PLANET, $LNG, $CONF, $db;
	$ress	 	= request_var('ress', '');
	$action		= request_var('action', '');
	$res1		= round(request_var('ress1', 0.0), 0);
	$res2		= round(request_var('ress2', 0.0), 0);

	$PlanetRess = new ResourceUpdate();
	$PlanetRess->CalcResource();
	$PlanetRess->SavePlanetToDB();
		
	$template	= new template();
	$template->loadscript("trader.js");
	
	$Charge		= array(
		'metal'		=> array('crystal', 2, 'deuterium', 4),
		'crystal'	=> array('metal', 0.5, 'deuterium', 2),
		'deuterium'	=> array('metal', 0.25, 'crystal', 0.5),
	);
	
	if(isset($Charge[$ress]))
	{
		if($action == "trade")
		{
			if ($USER['darkmatter'] < $CONF['darkmatter_cost_trader'])
				$template->message(sprintf($LNG['tr_empty_darkmatter'], $LNG['Darkmatter']), "game.php?page=trader", 1);
			elseif ($res1 < 0 || $res2 < 0)
				$template->message($LNG['tr_only_positive_numbers'], "game.php?page=trader", 1);
			else
			{
				$trade	= $res1 * $Charge[$ress][1] + $res2 * $Charge[$ress][3];
				$PlanetRess->CalcResource();
				if ($PLANET[$ress] > $trade)
				{
					$PLANET[$ress]     			-= $trade;
					$PLANET[$Charge[$ress][0]]  += $res1;
					$PLANET[$Charge[$ress][2]] 	+= $res2;
					$USER['darkmatter']				-= $CONF['darkmatter_cost_trader'];
					$db->multi_query("UPDATE ".PLANETS." SET 
					`".$ress."` = `".$ress."` - ".floattostring($trade).", 
					`".$Charge[$ress][0]."` = `".$Charge[$ress][0]."` + ".floattostring($res1).", 
					`".$Charge[$ress][2]."` = `".$Charge[$ress][2]."` + ".floattostring($res2)."
					WHERE `id` = ".$PLANET['id'].";
					UPDATE ".USERS." SET 
					`darkmatter` = `darkmatter` - ".$CONF['darkmatter_cost_trader']."
					WHERE `id` = ".$USER['id'].";");
					$template->message($LNG['tr_exchange_done'], "game.php?page=trader", 1);
				}
				else
					$template->message($LNG['tr_not_enought_metal'], "game.php?page=trader", 1);
			}
		} else {
			$template->assign_vars(array(
				'ress'				=> $LNG[ucwords($ress)],
				'ress1'				=> $LNG[ucwords($Charge[$ress][0])],
				'ress2'				=> $LNG[ucwords($Charge[$ress][2])],
				'ress1_charge' 		=> $Charge[$ress][1],
				'ress2_charge' 		=> $Charge[$ress][3],
			));

			$template->show("trader_trade.tpl");	
		}
		exit;
	}
	
	$template->assign_vars(array(
		'tr_cost_dm_trader'	=> sprintf($LNG['tr_cost_dm_trader'], pretty_number($CONF['darkmatter_cost_trader']), $LNG['Darkmatter']),
		'charge'			=> $Charge['metal'][1].'/1/'.$Charge['deuterium'][3],
	));

	$template->show("trader_overview.tpl");
}
?>