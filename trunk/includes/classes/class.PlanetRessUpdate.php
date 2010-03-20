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

class ResourceUpdate
{
	function __construct($CurrentUser, &$CurrentPlanet, $Hanger = true)
	{
		global $ProdGrid, $resource, $reslist, $game_config, $ExtraDM;

		$this->Builded					= UpdatePlanetBatimentQueueList($CurrentPlanet, $CurrentUser);
		$CurrentPlanet['metal_max']		= floor(2.5 * pow(1.8331954764, $CurrentPlanet[$resource[22]])) * 5000 * (1 + ($CurrentUser['rpg_stockeur'] * 0.5)) * $game_config['resource_multiplier'] * STORAGE_FACTOR;
		$CurrentPlanet['crystal_max']	= floor(2.5 * pow(1.8331954764, $CurrentPlanet[$resource[23]])) * 5000 * (1 + ($CurrentUser['rpg_stockeur'] * 0.5)) * $game_config['resource_multiplier'] * STORAGE_FACTOR;
		$CurrentPlanet['deuterium_max']	= floor(2.5 * pow(1.8331954764, $CurrentPlanet[$resource[24]])) * 5000 * (1 + ($CurrentUser['rpg_stockeur'] * 0.5)) * $game_config['resource_multiplier'] * STORAGE_FACTOR;
		
		$MaxMetalStorage                = $CurrentPlanet['metal_max']     * MAX_OVERFLOW;
		$MaxCristalStorage              = $CurrentPlanet['crystal_max']   * MAX_OVERFLOW;
		$MaxDeuteriumStorage            = $CurrentPlanet['deuterium_max'] * MAX_OVERFLOW;
		$this->ProductionTime          	= (time() - $CurrentPlanet['last_update']);

		$CurrentPlanet['last_update']   = time();

		if ($CurrentPlanet['planet_type'] == 3 || $CurrentUser['urlaubs_modus'] == 1)
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
			$Caps           = array();
			$BuildTemp      = $CurrentPlanet['temp_max'];
			$BuildEnergy	= $CurrentUser[$resource[113]];
			$Caps['metal_perhour'] = $Caps['crystal_perhour'] = $Caps['deuterium_perhour'] = $Caps['energy_used'] = $Caps['energy_max'] = $Caps['deuterium_used'] = 0;

			foreach($reslist['prod'] as $id => $ProdID)
			{
				$BuildLevelFactor	= $CurrentPlanet[$resource[$ProdID]."_porcent" ];
				$BuildLevel 		= $CurrentPlanet[$resource[$ProdID]];
				$Caps['metal_perhour']		+= floor(eval($ProdGrid[$ProdID]['formule']['metal'])     * ($game_config['resource_multiplier']) * ((1 + ($CurrentUser['rpg_geologue'] * 0.05)) + ((time() - $CurrentUser[$resource[703]] <= 0) ? (1 + $ExtraDM[703]['add']) : 0)));
				$Caps['crystal_perhour']	+= floor(eval($ProdGrid[$ProdID]['formule']['crystal'])   * ($game_config['resource_multiplier']) * ((1 + ($CurrentUser['rpg_geologue'] * 0.05)) + ((time() - $CurrentUser[$resource[703]] <= 0) ? (1 + $ExtraDM[703]['add']) : 0)));
				if ($ProdID < 4)
				{
					$Caps['deuterium_perhour'] 	+= floor(eval($ProdGrid[$ProdID]['formule']['deuterium']) * ($game_config['resource_multiplier']) * ((1 + ($CurrentUser['rpg_geologue'] * 0.05)) + ((time() - $CurrentUser[$resource[703]] <= 0) ? (1 + $ExtraDM[703]['add']) : 0)));
					$Caps['energy_used']   		+= floor(eval($ProdGrid[$ProdID]['formule']['energy']) * ($game_config['resource_multiplier']));
				}
				elseif ($ProdID >= 4 )
				{
					$Caps['deuterium_used'] 	+= floor(eval($ProdGrid[$ProdID]['formule']['deuterium']) * ($game_config['resource_multiplier']));
					$Caps['energy_max']			+= floor(eval($ProdGrid[$ProdID]['formule']['energy']) * ($game_config['resource_multiplier']) * ((1 + ($CurrentUser['rpg_ingenieur'] * 0.05)) + ((time() - $CurrentUser[$resource[704]] <= 0) ? (1 + $ExtraDM[704]['add']) : 0)));
				}
			}
			
			if ($Caps['energy_max'] == 0)
			{
				$CurrentPlanet['metal_perhour']     = $game_config['metal_basic_income'];
				$CurrentPlanet['crystal_perhour']   = $game_config['crystal_basic_income'];
				$CurrentPlanet['deuterium_perhour'] = $game_config['deuterium_basic_income'];
				$production_level            = 0;
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
				$MetalProduction = (($this->ProductionTime * ($CurrentPlanet['metal_perhour'] / 3600)) * $game_config['resource_multiplier']);
				$MetalBaseProduc = (($this->ProductionTime * ($game_config['metal_basic_income'] / 3600 )) * $game_config['resource_multiplier']);
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
				$CristalProduction = (($this->ProductionTime * ($CurrentPlanet['crystal_perhour'] / 3600)) * $game_config['resource_multiplier']);
				$CristalBaseProduc = (($this->ProductionTime * ($game_config['crystal_basic_income'] / 3600 )) * $game_config['resource_multiplier']);
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
				$DeuteriumProduction = (($this->ProductionTime * ($CurrentPlanet['deuterium_perhour'] / 3600)) * $game_config['resource_multiplier']);
				$DeuteriumBaseProduc = (($this->ProductionTime * ($game_config['deuterium_basic_income'] / 3600 )) * $game_config['resource_multiplier']);
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
				
		$CurrentPlanet['metal']		= max($CurrentPlanet['metal'], 0);
		$CurrentPlanet['crystal']	= max($CurrentPlanet['crystal'], 0);
		$CurrentPlanet['deuterium']	= max($CurrentPlanet['deuterium'], 0);
		if($Hanger)
			$this->Builded    	   += HandleElementBuildingQueue($CurrentUser, $CurrentPlanet, $this->ProductionTime);
	}
	
	public function SavePlanetToDB($CurrentUser, $CurrentPlanet)
	{
		global $resource, $db, $user;
			
		$QryUpdatePlanet  = "UPDATE ".PLANETS." SET ";
		$QryUpdatePlanet .= "`metal` = '"            . $CurrentPlanet['metal']             	."', ";
		$QryUpdatePlanet .= "`crystal` = '"          . $CurrentPlanet['crystal']           	."', ";
		$QryUpdatePlanet .= "`deuterium` = '"        . $CurrentPlanet['deuterium']         	."', ";
		$QryUpdatePlanet .= "`last_update` = '"      . $CurrentPlanet['last_update']       	."', ";
		$QryUpdatePlanet .= "`b_building` = '"       . $CurrentPlanet['b_building']         ."', ";
		$QryUpdatePlanet .= "`b_building_id` = '"    . $CurrentPlanet['b_building_id']      ."', ";
		$QryUpdatePlanet .= "`field_current` = '"    . $CurrentPlanet['field_current']      ."', ";
		$QryUpdatePlanet .= "`field_max` = '"        . $CurrentPlanet['field_max']          ."', ";
		$QryUpdatePlanet .= "`b_hangar_id` = '"      . $CurrentPlanet['b_hangar_id']       	."', ";
		$QryUpdatePlanet .= "`metal_perhour` = '"    . $CurrentPlanet['metal_perhour']     	."', ";
		$QryUpdatePlanet .= "`crystal_perhour` = '"  . $CurrentPlanet['crystal_perhour']   	."', ";
		$QryUpdatePlanet .= "`deuterium_perhour` = '". $CurrentPlanet['deuterium_perhour'] 	."', ";
		$QryUpdatePlanet .= "`metal_max` = '"        . $CurrentPlanet['metal_max']     		."', ";
		$QryUpdatePlanet .= "`crystal_max` = '"      . $CurrentPlanet['crystal_max']   		."', ";
		$QryUpdatePlanet .= "`deuterium_max` = '"    . $CurrentPlanet['deuterium_max'] 		."', ";
		$QryUpdatePlanet .= "`energy_used` = '"      . $CurrentPlanet['energy_used']    	."', ";
		$QryUpdatePlanet .= "`energy_max` = '"       . $CurrentPlanet['energy_max']        	."', ";
		if (!empty($this->Builded))
		{
			foreach($this->Builded as $Element => $Count )
			{
				$QryUpdatePlanet .= "`". $resource[$Element] ."` = '". $CurrentPlanet[$resource[$Element]] ."', ";
			}
		}
		$QryUpdatePlanet .= "`b_hangar` = '". $CurrentPlanet['b_hangar'] ."' ";
		$QryUpdatePlanet .= "WHERE ";
		$QryUpdatePlanet .= "`id` = '". $CurrentPlanet['id'] ."';";
		$QryUpdatePlanet .= "UPDATE ".USERS." SET ";
		$QryUpdatePlanet .= "`darkmatter` = ".$CurrentUser['darkmatter']." ";
		$QryUpdatePlanet .= "WHERE ";
		$QryUpdatePlanet .= "`id` = '".$CurrentUser['id']."';";
		$db->multi_query($QryUpdatePlanet);
	}
}
?>