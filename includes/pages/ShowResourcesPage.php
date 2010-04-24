<?php

##############################################################################
# *                                                                          #
# * 2MOONS                                                                   #
# *                                                                          #
# * @copyright Copyright (C) 2010 By ShadoX from titanspace.de               #
# *                                                                          #
# *	                                                                         #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.                                     #
# *	                                                                         #
# *  This program is distributed in the hope that it will be useful,         #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of          #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           #
# *  GNU General Public License for more details.                            #
# *                                                                          #
##############################################################################

if(!defined('INSIDE')){ die(header("location:../../"));}

function ShowResourcesPage($CurrentUser, $CurrentPlanet)
{
	global $lang, $ProdGrid, $resource, $reslist, $game_config, $db, $ExtraDM;
	
	if ($CurrentPlanet['planet_type'] == 3)
	{
		$game_config['metal_basic_income']     = 0;
		$game_config['crystal_basic_income']   = 0;
		$game_config['deuterium_basic_income'] = 0;
	}

	$SubQry               = "";

	if ($_POST)
	{
		foreach($_POST as $Field => $Value)
		{
			$FieldName = $Field."_porcent";
			if (isset($CurrentPlanet[$FieldName]) && in_array($Value, $reslist['procent']))
			{
				$Value                        = $Value / 10;
				$CurrentPlanet[ $FieldName ]  = $Value;
				$SubQry                      .= ", `".$FieldName."` = '".$Value."'";
			}
		}
		if(isset($SubQry))
		{
			$QryUpdatePlanet  = "UPDATE ".PLANETS." SET ";
			$QryUpdatePlanet .= "`id` = '". $CurrentPlanet['id'] ."' ";
			$QryUpdatePlanet .= $SubQry;
			$QryUpdatePlanet .= "WHERE ";
			$QryUpdatePlanet .= "`id` = '". $CurrentPlanet['id'] ."';";
			$db->query($QryUpdatePlanet);
		}
		header("Location: game.php?page=resources");
		exit;		
	}
	
	$PlanetRess = new ResourceUpdate($CurrentUser, $CurrentPlanet);
	$template	= new template();

	$template->set_vars($CurrentUser, $CurrentPlanet);
	$template->page_header();
	$template->page_topnav();
	$template->page_leftmenu();
	$template->page_planetmenu();
	$template->page_footer();
	
	if ($CurrentPlanet['energy_max'] == 0 && $CurrentPlanet['energy_used'] > 0)
	{
		$post_porcent = 0;
	}
	elseif ($CurrentPlanet['energy_max']  > 0 && abs($CurrentPlanet['energy_used']) > $CurrentPlanet['energy_max'])
	{
		$post_porcent = floor(($CurrentPlanet['energy_max']) / ($CurrentPlanet['energy_used']*-1) * 100);
	}
	elseif ($CurrentPlanet['energy_max'] == 0 && abs($CurrentPlanet['energy_used']) > $CurrentPlanet['energy_max'])
	{
		$post_porcent = 0;
	}
	else
	{
		$post_porcent = 100;
	}

	if ($post_porcent > 100)
	{
		$post_porcent = 100;
	}
	$BuildTemp      = $CurrentPlanet['temp_max'];
	$BuildEnergy	= $CurrentUser[$resource[113]];
	$metal			= array();
	$crystal		= array();
	$deuterium		= array();
	$deu_en			= array();
	$energy			= array();
	$energy_en		= array();
	
	foreach($reslist['prod'] as $ProdID)
	{
		if ($CurrentPlanet[$resource[$ProdID]] > 0 && isset($ProdGrid[$ProdID]))
		{
			$BuildLevelFactor       = $CurrentPlanet[ $resource[$ProdID]."_porcent" ];
			$BuildLevel             = $CurrentPlanet[ $resource[$ProdID] ];
			$metal[$ProdID]     	= floor(eval($ProdGrid[$ProdID]['formule']['metal'])     * (0.01 * $post_porcent) * ($game_config['resource_multiplier']));
			$crystal[$ProdID] 		= floor(eval($ProdGrid[$ProdID]['formule']['crystal'])   * (0.01 * $post_porcent) * ($game_config['resource_multiplier']));
		
			if ($ProdID < 4)
			{
				$deuterium[$ProdID]	= floor(eval($ProdGrid[$ProdID]['formule']['deuterium']) * (0.01 * $post_porcent) * ($game_config['resource_multiplier']));
				$energy[$ProdID]	= floor(eval($ProdGrid[$ProdID]['formule']['energy'])    * ($game_config['resource_multiplier']));
			} else {
				$deu_en[$ProdID]	= floor(eval($ProdGrid[$ProdID]['formule']['deuterium']) * ($game_config['resource_multiplier']));
				$energy_en[$ProdID]	= floor(eval($ProdGrid[$ProdID]['formule']['energy']) * ($game_config['resource_multiplier']));
			}

			$thisdeu				= ((isset($deuterium[$ProdID])) ? $deuterium[$ProdID] : $deu_en[$ProdID]);
			$thisenergy				= ((isset($energy[$ProdID])) ? $energy[$ProdID] : $energy_en[$ProdID]);

			$CurrPlanetList[]	= array(
				'name'              => $resource[$ProdID],
				'type'  			=> $lang['tech'][$ProdID],
				'level'     	    => ($ProdID > 200) ? $lang['rs_amount'] : $lang['rs_lvl'],
				'level_type'        => $CurrentPlanet[$resource[$ProdID]],
				'metal_type'        => colorNumber(pretty_number($metal[$ProdID])),
				'crystal_type'      => colorNumber(pretty_number($crystal[$ProdID])),
				'deuterium_type'    => colorNumber(pretty_number($thisdeu)),
				'energy_type'       => colorNumber(pretty_number($thisenergy)),
				'optionsel'			=> $CurrentPlanet[$resource[$ProdID]."_porcent"] * 10,
			);
		}
	}


	$metal_total		            = $CurrentPlanet['metal_perhour'] + $game_config['metal_basic_income'] * $game_config['resource_multiplier'];
	$crystal_total			        = $CurrentPlanet['crystal_perhour'] + $game_config['crystal_basic_income'] * $game_config['resource_multiplier'];
	$deuterium_total  		        = $CurrentPlanet['deuterium_perhour'] + $game_config['deuterium_basic_income'] * $game_config['resource_multiplier'];
	$energy_total					= $CurrentPlanet['energy_max'] + $game_config['energy_basic_income'] * $game_config['resource_multiplier'] - abs($CurrentPlanet['energy_used']);
	
	foreach($reslist['procent'] as $procent){
		$OptionSelector[$procent]	= $procent."%";
	}

	$template->assign_vars(array(	
		'bonus_metal'							=> colorNumber(pretty_number(array_sum($metal)		* (($CurrentUser['rpg_geologue'] * GEOLOGUE) + ($CurrentUser['metal_proc_tech'] * 0.02) + ((time() - $CurrentUser[$resource[703]] <= 0) ? ($ExtraDM[703]['add']) : 0)))),
		'bonus_crystal'							=> colorNumber(pretty_number(array_sum($crystal) 	* (($CurrentUser['rpg_geologue'] * GEOLOGUE) + ($CurrentUser['crystal_proc_tech'] * 0.02) + ((time() - $CurrentUser[$resource[703]] <= 0) ? ($ExtraDM[703]['add']) : 0)))),
		'bonus_deuterium'						=> colorNumber(pretty_number(array_sum($deuterium) 	* (($CurrentUser['rpg_geologue'] * GEOLOGUE) + ($CurrentUser['deuterium_proc_tech'] * 0.02) + ((time() - $CurrentUser[$resource[703]] <= 0) ? ($ExtraDM[703]['add']) : 0)))),
		'bonus_energy'							=> colorNumber(pretty_number(array_sum($energy_en) 	* (($CurrentUser['rpg_ingenieur'] * INGENIEUR) + ((time() - $CurrentUser[$resource[704]] <= 0) ? ($ExtraDM[704]['add']) : 0)))),
		'CurrPlanetList'						=> $CurrPlanetList,	
		'Production_of_resources_in_the_planet'	=> str_replace('%s', $CurrentPlanet['name'], $lang['rs_production_on_planet']),
		'metal_basic_income'    				=> $game_config['metal_basic_income']     * $game_config['resource_multiplier'],
		'crystal_basic_income'  				=> $game_config['crystal_basic_income']   * $game_config['resource_multiplier'],
		'deuterium_basic_income'				=> $game_config['deuterium_basic_income'] * $game_config['resource_multiplier'],
		'energy_basic_income'   				=> $game_config['energy_basic_income']    * $game_config['resource_multiplier'],
		'metalmax'             					=> colorNumber($CurrentPlanet['metal_max'] / 1000, pretty_number($CurrentPlanet['metal_max'] / 1000) ."k"),
		'crystalmax'          					=> colorNumber($CurrentPlanet['crystal_max'] / 1000, pretty_number($CurrentPlanet['crystal_max'] / 1000) ."k"),
		'deuteriummax'         					=> colorNumber($CurrentPlanet['deuterium_max'] / 1000, pretty_number($CurrentPlanet['deuterium_max'] / 1000) ."k"),
		'metal_total'           				=> colorNumber(pretty_number($metal_total)),
		'crystal_total'         				=> colorNumber(pretty_number($crystal_total)),
		'option'								=> $OptionSelector,
		'deuterium_total'       				=> colorNumber(pretty_number($deuterium_total)),
		'energy_total'          				=> colorNumber(pretty_number($energy_total)),
		'daily_metal'           				=> colorNumber(pretty_number(floor($metal_total     * 24))),
		'weekly_metal'          				=> colorNumber(pretty_number(floor($metal_total     * 24 * 7))),
		'daily_crystal'         				=> colorNumber(pretty_number(floor($crystal_total   * 24))),
		'weekly_crystal'        				=> colorNumber(pretty_number(floor($crystal_total   * 24 * 7))),
		'daily_deuterium'       				=> colorNumber(pretty_number(floor($deuterium_total * 24))),
		'weekly_deuterium'      				=> colorNumber(pretty_number(floor($deuterium_total * 24 * 7))),
		'Metal'									=> $lang['Metal'], 
		'Crystal'								=> $lang['Crystal'], 
		'Deuterium'								=> $lang['Deuterium'], 
		'Energy'								=> $lang['Energy'],
		'rs_basic_income'						=> $lang['rs_basic_income'], 
		'rs_storage_capacity'					=> $lang['rs_storage_capacity'], 
		'rs_sum'								=> $lang['rs_sum'], 
		'rs_daily'								=> $lang['rs_daily'], 
		'rs_weekly'								=> $lang['rs_weekly'], 	
		'rs_calculate'							=> $lang['rs_calculate'], 	
		'rs_ress_bonus'							=> $lang['rs_ress_bonus'], 	
	));
	
	$template->show("resources_overview.tpl");
	$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
}

?>