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

function ShowFleetTraderPage()
{
	global $USER, $PLANET, $LNG, $CONF, $pricelist, $resource, $reslist;
	$PlanetRess = new ResourceUpdate();
	$PlanetRess->CalcResource();
	$CONF['trade_allowed_ships']	= explode(',', $CONF['trade_allowed_ships']);
	$ID								= request_var('id', 0);
	if(!empty($ID) && in_array($ID, $CONF['trade_allowed_ships'])) {
		$Count						= min(request_outofint('count'), $PLANET[$resource[$ID]]);
		$PLANET['metal']			+= $Count * $pricelist[$ID]['metal'] * (1 - ($CONF['trade_charge'] / 100));
		$PLANET['crystal']			+= $Count * $pricelist[$ID]['crystal'] * (1 - ($CONF['trade_charge'] / 100));
		$PLANET['deuterium']		+= $Count * $pricelist[$ID]['deuterium'] * (1 - ($CONF['trade_charge'] / 100));
		$USER['darkmatter']			+= $Count * $pricelist[$ID]['darkmatter'] * (1 - ($CONF['trade_charge'] / 100));
		$PLANET[$resource[$ID]]		-= $Count;
		$PlanetRess->Builded[$ID]	-= $Count;
	}
	$PlanetRess->SavePlanetToDB();

	$template	= new template();
	$template->loadscript('fleettrader.js');
	$template->execscript('updateVars();');
	$Cost	= array();
	foreach($CONF['trade_allowed_ships'] as $ID)
	{
		if(in_array($ID, $reslist['fleet']) || in_array($ID, $reslist['defense']))
			$Cost[$ID]	= array($PLANET[$resource[$ID]], $pricelist[$ID]['metal'], $pricelist[$ID]['crystal'], $pricelist[$ID]['deuterium'], $pricelist[$ID]['darkmatter']);
	}
	
	if(empty($Cost)) {
		$template->message($LNG['ft_empty']);
		exit;
	}
	$template->assign_vars(array(	
		'tech'						=> $LNG['tech'],
		'ft_head'					=> $LNG['ft_head'],
		'ft_count'					=> $LNG['ft_count'],
		'ft_max'					=> $LNG['ft_max'],
		'ft_total'					=> $LNG['ft_total'],
		'ft_charge'					=> $LNG['ft_charge'],
		'ft_absenden'				=> $LNG['ft_absenden'],
		'trade_allowed_ships'		=> $CONF['trade_allowed_ships'],
		'CostInfos'					=> json_encode($Cost),
		'Charge'					=> $CONF['trade_charge'],
	));
	
	$template->show("fleettrader_overview.tpl");
}
?>