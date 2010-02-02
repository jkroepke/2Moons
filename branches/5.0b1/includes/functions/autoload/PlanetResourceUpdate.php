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

function PlanetResourceUpdate ( $CurrentUser, &$CurrentPlanet, $UpdateTime, $Simul = false )
{
	global $ProdGrid, $resource, $reslist, $game_config, $db;
	
	$CurrentPlanet['metal_max']		= floor(2.5 * pow(1.8331954764,$CurrentPlanet[$resource[22]])) * 5000 * (1 + ($CurrentUser['rpg_stockeur'] * 0.5)) * $game_config['resource_multiplier'] * STORAGE_FACTOR;
	$CurrentPlanet['crystal_max']	= floor(2.5 * pow(1.8331954764,$CurrentPlanet[$resource[23]])) * 5000 * (1 + ($CurrentUser['rpg_stockeur'] * 0.5)) * $game_config['resource_multiplier'] * STORAGE_FACTOR;
	$CurrentPlanet['deuterium_max']	= floor(2.5 * pow(1.8331954764,$CurrentPlanet[$resource[24]])) * 5000 * (1 + ($CurrentUser['rpg_stockeur'] * 0.5)) * $game_config['resource_multiplier'] * STORAGE_FACTOR;

	$MaxMetalStorage                = $CurrentPlanet['metal_max']     * MAX_OVERFLOW;
	$MaxCristalStorage              = $CurrentPlanet['crystal_max']   * MAX_OVERFLOW;
	$MaxDeuteriumStorage            = $CurrentPlanet['deuterium_max'] * MAX_OVERFLOW;
	$ProductionTime               	= ($UpdateTime - $CurrentPlanet['last_update']);
	$CurrentPlanet['last_update'] 		   = $UpdateTime;

	if ($CurrentPlanet['planet_type'] == 3)
	{
		$game_config['metal_basic_income']     = 0;
		$game_config['crystal_basic_income']   = 0;
		$game_config['deuterium_basic_income'] = 0;
		$CurrentPlanet['metal_perhour']        = 0;
		$CurrentPlanet['crystal_perhour']      = 0;
		$CurrentPlanet['deuterium_perhour']    = 0;
		$CurrentPlanet['energy_used']          = 0;
		$CurrentPlanet['energy_max']           = 0;
	}
	else
	{
		$Caps             = array();
		$BuildTemp        = $CurrentPlanet['temp_max'];

		$Caps['metal_perhour'] = $Caps['crystal_perhour'] = $Caps['deuterium_perhour'] = $Caps['energy_used'] = $Caps['energy_max'] = $Caps['deuterium_used'] = 0;

		foreach($reslist['prod'] as $id => $ProdID)
		{
			$BuildLevelFactor = $CurrentPlanet[ $resource[$ProdID]."_porcent" ];
			$BuildLevel = $CurrentPlanet[ $resource[$ProdID] ];
			$Caps['metal_perhour']		+= floor(eval($ProdGrid[$ProdID]['formule']['metal'])     * ($game_config['resource_multiplier']) * (1 + ( $CurrentUser['rpg_geologue'] * GEOLOGUE )));
			$Caps['crystal_perhour']	+= floor(eval($ProdGrid[$ProdID]['formule']['crystal'])   * ($game_config['resource_multiplier']) * (1 + ( $CurrentUser['rpg_geologue'] * GEOLOGUE )));
			
			if ($ProdID < 4)
			{
				$Caps['deuterium_perhour'] 	+= floor(eval($ProdGrid[$ProdID]['formule']['deuterium']) * ($game_config['resource_multiplier']) * 1 + ( $CurrentUser['rpg_geologue'] * GEOLOGUE ));
				$Caps['energy_used']   		+= floor(eval($ProdGrid[$ProdID]['formule']['energy']) * ($game_config['resource_multiplier']));
			}
			elseif ($ProdID >= 4 )
			{
				$Caps['deuterium_used'] 	+= floor(eval($ProdGrid[$ProdID]['formule']['deuterium']) * ($game_config['resource_multiplier']));
				$Caps['energy_max']			+= floor(eval($ProdGrid[$ProdID]['formule']['energy']) * ($game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_ingenieur'] * 0.05 ) ) );
			}
		}

		if ($Caps['energy_max'] == 0)
		{
			$CurrentPlanet['metal_perhour']     = $game_config['metal_basic_income'];
			$CurrentPlanet['crystal_perhour']   = $game_config['crystal_basic_income'];
			$CurrentPlanet['deuterium_perhour'] = $game_config['deuterium_basic_income'];
			$production_level            = 100;
		}
		elseif ($Caps["energy_max"] >= abs($Caps["energy_used"]))
		{
			$production_level = 100;
		}
		else
		{
			$production_level = floor($Caps['energy_max'] / abs($Caps['energy_used']) * 100);
		}
		if($production_level > 100)
		{
			$production_level = 100;
		}
		elseif ($production_level < 0)
		{
			$production_level = 0;
		}
		
		$CurrentPlanet['metal_perhour']        = $Caps['metal_perhour']* (0.01 * $production_level);
		$CurrentPlanet['crystal_perhour']      = $Caps['crystal_perhour'] * (0.01 * $production_level);
		$CurrentPlanet['deuterium_perhour']    = $Caps['deuterium_perhour'] * (0.01 * $production_level) + $Caps['deuterium_used'];
		$CurrentPlanet['energy_used']          = $Caps['energy_used'];
		$CurrentPlanet['energy_max']           = $Caps['energy_max'];

		if ( $CurrentPlanet['metal'] <= $MaxMetalStorage )
		{
			$MetalProduction = (($ProductionTime * ($CurrentPlanet['metal_perhour'] / 3600)) * $game_config['resource_multiplier']);
			$MetalBaseProduc = (($ProductionTime * ($game_config['metal_basic_income'] / 3600 )) * $game_config['resource_multiplier']);
			$MetalTheorical  = $CurrentPlanet['metal'] + $MetalProduction  +  $MetalBaseProduc;
			if ( $MetalTheorical <= $MaxMetalStorage )
			{
				$CurrentPlanet['metal']  = $MetalTheorical;
			}
			else
			{
				$CurrentPlanet['metal']  = $MaxMetalStorage;
			}
		}

		if ( $CurrentPlanet['crystal'] <= $MaxCristalStorage )
		{
			$CristalProduction = (($ProductionTime * ($CurrentPlanet['crystal_perhour'] / 3600)) * $game_config['resource_multiplier']);
			$CristalBaseProduc = (($ProductionTime * ($game_config['crystal_basic_income'] / 3600 )) * $game_config['resource_multiplier']);
			$CristalTheorical  = $CurrentPlanet['crystal'] + $CristalProduction  +  $CristalBaseProduc;
			if ( $CristalTheorical <= $MaxCristalStorage )
			{
				$CurrentPlanet['crystal']  = $CristalTheorical;
			}
			else
			{
				$CurrentPlanet['crystal']  = $MaxCristalStorage;
			}
		}

		if ( $CurrentPlanet['deuterium'] <= $MaxDeuteriumStorage )
		{
			$DeuteriumProduction = (($ProductionTime * ($CurrentPlanet['deuterium_perhour'] / 3600)) * $game_config['resource_multiplier']);
			$DeuteriumBaseProduc = (($ProductionTime * ($game_config['deuterium_basic_income'] / 3600 )) * $game_config['resource_multiplier']);
			$DeuteriumTheorical  = $CurrentPlanet['deuterium'] + $DeuteriumProduction  +  $DeuteriumBaseProduc;
			if ( $DeuteriumTheorical <= $MaxDeuteriumStorage )
			{
				$CurrentPlanet['deuterium']  = $DeuteriumTheorical;
			}
			else
			{
				$CurrentPlanet['deuterium']  = $MaxDeuteriumStorage;
			}
		}
	}
	if ($Simul == false)
	{
		$Builded          = HandleElementBuildingQueue ( $CurrentUser, $CurrentPlanet, $ProductionTime );

		$QryUpdatePlanet  = "UPDATE ".PLANETS." SET ";
		$QryUpdatePlanet .= "`metal` = '"            . $CurrentPlanet['metal']             	."', ";
		$QryUpdatePlanet .= "`crystal` = '"          . $CurrentPlanet['crystal']           	."', ";
		$QryUpdatePlanet .= "`deuterium` = '"        . $CurrentPlanet['deuterium']         	."', ";
		$QryUpdatePlanet .= "`last_update` = '"      . $CurrentPlanet['last_update']       	."', ";
		$QryUpdatePlanet .= "`b_hangar_id` = '"      . $CurrentPlanet['b_hangar_id']       	."', ";
		$QryUpdatePlanet .= "`metal_perhour` = '"    . $CurrentPlanet['metal_perhour']     	."', ";
		$QryUpdatePlanet .= "`crystal_perhour` = '"  . $CurrentPlanet['crystal_perhour']   	."', ";
		$QryUpdatePlanet .= "`deuterium_perhour` = '". $CurrentPlanet['deuterium_perhour'] 	."', ";
		$QryUpdatePlanet .= "`metal_max` = '"        . $CurrentPlanet['metal_max']     		."', ";
        $QryUpdatePlanet .= "`crystal_max` = '"      . $CurrentPlanet['crystal_max']   		."', ";
        $QryUpdatePlanet .= "`deuterium_max` = '"    . $CurrentPlanet['deuterium_max'] 		."', ";
		$QryUpdatePlanet .= "`energy_used` = '"      . $CurrentPlanet['energy_used']    	."', ";
		$QryUpdatePlanet .= "`energy_max` = '"       . $CurrentPlanet['energy_max']        	."', ";
		if ( $Builded != '' )
		{
			foreach ( $Builded as $Element => $Count )
			{
				if ($resource[$Element] != '')
				{
					$QryUpdatePlanet .= "`". $resource[$Element] ."` = '". $CurrentPlanet[$resource[$Element]] ."', ";
				}
			}
		}
		$QryUpdatePlanet .= "`b_hangar` = '". $CurrentPlanet['b_hangar'] ."' ";
		$QryUpdatePlanet .= "WHERE ";
		$QryUpdatePlanet .= "`id` = '". $CurrentPlanet['id'] ."';";
		$db->query($QryUpdatePlanet);
	}
}
?>