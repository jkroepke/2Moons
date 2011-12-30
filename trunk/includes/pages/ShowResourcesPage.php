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

function ShowResourcesPage()
{
	global $LNG, $ProdGrid, $resource, $reslist, $CONF, $db, $pricelist, $USER, $PLANET;
	
	$PLANET['eco_hash']	= NULL;
	$PlanetRess = new ResourceUpdate();
	$PlanetRess->CalcResource();
	$PlanetRess->SavePlanetToDB();
	
	if (isset($_POST['send']) && $USER['urlaubs_modus'] == 0)
	{
		$updateSQL	= array();
		foreach($_POST['prod'] as $ressourceID => $Value)
		{
			$FieldName = $resource[$ressourceID].'_porcent';
			if (!isset($PLANET[$FieldName]) || !in_array($Value, range(0, 10)))
				continue;
			
			$updateSQL[]	= $FieldName." = ".(int) $Value;
			
			$PLANET[$FieldName]	= $Value;
		}

		if(!empty($updateSQL))
		{
			$db->query("UPDATE ".PLANETS." SET ".implode(", ", $updateSQL)." WHERE `id` = ".$PLANET['id'] .";");
		}	
	}
	
	if ($PLANET['planet_type'] == 3 || $USER['urlaubs_modus'] == 1)
	{
		$CONF['metal_basic_income']     = 0;
		$CONF['crystal_basic_income']   = 0;
		$CONF['deuterium_basic_income'] = 0;
	}
	
	$BuildTemp      = $PLANET['temp_max'];
	$BuildEnergy	= $USER[$resource[113]];

	$productionList	= array();
	
	$temp						= array();
	
	$temp['metal_proc']			= 0;
	$temp['metal_proc_use']		= 0;
	$temp['crystal_proc']		= 0;
	$temp['crystal_proc_use']	= 0;
	$temp['deuterium_proc']		= 0;
	$temp['deuterium_proc_use']	= 0;
	$temp['energy_proc']		= 0;
	$temp['energy_proc_use']	= 0;
	
	foreach($reslist['prod'] as $ProdID)
	{	
		
		$BuildLevelFactor	= $PLANET[$resource[$ProdID].'_porcent'];			
		$BuildLevel 		= $PLANET[$resource[$ProdID]];
		
		$Prod				= array();
		$Prod[901]			= round(eval($ProdGrid[$ProdID][901]) * $CONF['resource_multiplier']);
		$Prod[902]			= round(eval($ProdGrid[$ProdID][902]) * $CONF['resource_multiplier']);
		$Prod[903]			= round(eval($ProdGrid[$ProdID][903]) * $CONF['resource_multiplier']);
		$Prod[911]			= round(eval($ProdGrid[$ProdID][911]) * $CONF['resource_multiplier']);
			
		if($Prod[901] < 0 && $this->PLANET[$resource[901]] == 0)
			continue;
			
		if($Prod[902] < 0 && $this->PLANET[$resource[902]] == 0)
			continue;
			
		if($Prod[903] < 0 && $this->PLANET[$resource[903]] == 0)
			continue;
		
		$productionList[]	= array(
			'production'	=> $Prod,
			'elementID'		=> $ProdID,
			'elementLevel'	=> $PLANET[$resource[$ProdID]],
			'prodLevel'		=> $PLANET[$resource[$ProdID].'_porcent'],
		);
			
		if($Prod[901] < 0)
			$temp['metal_proc']			+= $Prod[901];
		else	
			$temp['metal_proc_use']		+= $Prod[901];
		
		if($Prod[902] < 0)
			$temp['crystal_proc']		+= $Prod[902];
		else
			$temp['crystal_proc_use']	+= $Prod[902];
		
		if($Prod[903] < 0)
			$temp['deuterium_proc']		+= $Prod[903];
		else
			$temp['deuterium_proc_use']	+= $Prod[903];
		
		if($Prod[911] < 0)
			$temp['energy_proc_use']	+= $Prod[911];
		else
			$temp['energy_proc']		+= $Prod[911];
	}
	
	$storage	= array(
		901 => shortly_number($PLANET[$resource[901].'_max']),
		902 => shortly_number($PLANET[$resource[902].'_max']),
		903 => shortly_number($PLANET[$resource[903].'_max']),
	);
	
	$basicProduction	= array(
		901 => $CONF[$resource[901].'_basic_income'] * $CONF['resource_multiplier'],
		902 => $CONF[$resource[902].'_basic_income'] * $CONF['resource_multiplier'],
		903	=> $CONF[$resource[903].'_basic_income'] * $CONF['resource_multiplier'],
		911	=> $CONF[$resource[911].'_basic_income'] * $CONF['resource_multiplier'],
	);
	
	$totalProduction	= array(
		901 => $PLANET[$resource[901].'_perhour'] + $basicProduction[901],
		902 => $PLANET[$resource[902].'_perhour'] + $basicProduction[902],
		903	=> $PLANET[$resource[903].'_perhour'] + $basicProduction[903],
		911	=> $PLANET[$resource[911]] + $basicProduction[911],
	);
	
	$bonusProduction	= array(
		901 => $temp['metal_proc'] * (1 - $USER['factor']['ressource'][901]),
		902 => $temp['crystal_proc'] * (1 - $USER['factor']['ressource'][902]),
		903	=> $temp['deuterium_proc'] * (1 - $USER['factor']['ressource'][903]),
		911	=> $temp['energy_proc_use'] * (1 - $USER['factor']['ressource'][911]),
	);
	
	$dailyProduction	= array(
		901 => $totalProduction[901] * 24,
		902 => $totalProduction[902] * 24,
		903	=> $totalProduction[903] * 24,
		911	=> $totalProduction[911],
	);
	
	$weeklyProduction	= array(
		901 => $totalProduction[901] * 168,
		902 => $totalProduction[902] * 168,
		903	=> $totalProduction[903] * 168,
		911	=> $totalProduction[911],
	);
		
	$prodSelector	= array();
	
	foreach(range(0, 10) as $procent) {
		$prodSelector[$procent]	= ($procent * 10).'%';
	}
	
	$template		= new template();
	$template->assign_vars(array(	
		'header'			=> sprintf($LNG['rs_production_on_planet'], $PLANET['name']),
		'prodSelector'		=> $prodSelector,
		'productionList'	=> $productionList,
		'basicProduction'	=> $basicProduction,
		'totalProduction'	=> $totalProduction,
		'bonusProduction'	=> $bonusProduction,
		'dailyProduction'	=> $dailyProduction,
		'weeklyProduction'	=> $weeklyProduction,
		'storage'			=> $storage,
	));
	
	$template->show("resources_overview.tpl");
}

?>