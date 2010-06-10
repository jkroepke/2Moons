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

if(!defined('INSIDE')) die('Hacking attempt!');

	function CreateOnePlanetRecord($Galaxy, $System, $Position, $PlanetOwnerID, $PlanetName = '', $HomeWorld = false)
	{
		global $LNG, $db, $CONF;
	
		if(MAX_GALAXY_IN_WORLD < $Galaxy || 1 > $Galaxy) {
			throw new Exception("Access denied for CreateOnePlanetRecord.php.<br>Try to create a planet at position:".$Galaxy.":".$System.":".$Position);
		}	
		elseif(MAX_SYSTEM_IN_GALAXY < $System || 1 > $System) {
			throw new Exception("Access denied for CreateOnePlanetRecord.php.<br>Try to create a planet at position:".$Galaxy.":".$System.":".$Position);
		}	
		elseif(MAX_PLANET_IN_SYSTEM < $Position || 1 > $Position) {
			throw new Exception("Access denied for CreateOnePlanetRecord.php.<br>Try to create a planet at position:".$Galaxy.":".$System.":".$Position);
		}
		
		if (!CheckPlanetIfExist($Galaxy, $System, $Position))
		{
			$FieldFactor				 = ($CONF['initial_fields'] / 163) * PLANET_SIZE_FACTOR;
			$planet['metal']             = BUILD_METAL;
			$planet['crystal']           = BUILD_CRISTAL;
			$planet['deuterium']         = BUILD_DEUTERIUM;
			$planet['metal_perhour']     = $CONF['metal_basic_income'];
			$planet['crystal_perhour']   = $CONF['crystal_basic_income'];
			$planet['deuterium_perhour'] = $CONF['deuterium_basic_income'];
			$planet['metal_max']         = BASE_STORAGE_SIZE;
			$planet['crystal_max']       = BASE_STORAGE_SIZE;
			$planet['deuterium_max']     = BASE_STORAGE_SIZE;

			$planet['galaxy'] 			= $Galaxy;
			$planet['system'] 			= $System;
			$planet['planet'] 			= $Position;
			
			$Position					= ($Position > 15) ? mt_rand(1,15) : $Position;
			switch($Position) {
				case 1:
					$PlanetType         = array('trocken', 'wuesten');
					$PlanetClass        = array('planet');
					$PlanetDesign       = array('trocken' => rand(1,10), 'wuesten' => rand(1,4));
					$planet['temp_max'] = rand(200, 240);
					$planet['temp_min'] = $planet['temp_max'] - 40;
					$planet['field_max']= rand(95,108) * $FieldFactor;					
				break;
				case 2:
					$PlanetType         = array('trocken', 'wuesten');
					$PlanetClass        = array('planet');
					$PlanetDesign       = array('trocken' => rand(1,10), 'wuesten' => rand(1,4));
					$planet['temp_max'] = rand(150, 190);
					$planet['temp_min'] = $planet['temp_max'] - 40;
					$planet['field_max']= rand(97,110) * $FieldFactor;					
				break;
				case 3:
					$PlanetType         = array('trocken', 'wuesten');
					$PlanetClass        = array('planet');
					$PlanetDesign       = array('trocken' => rand(1,10), 'wuesten' => rand(1,4));
					$planet['temp_max'] = rand(100, 140);
					$planet['temp_min'] = $planet['temp_max'] - 40;
					$planet['field_max']= rand(98, 137) * $FieldFactor;					
				break;
				case 4:
					$PlanetType         = array('dschjungel');
					$PlanetClass        = array('planet');
					$PlanetDesign       = array('dschjungel' => rand(1,10));
					$planet['temp_max'] = rand(50, 90);
					$planet['temp_min'] = $planet['temp_max'] - 40;
					$planet['field_max']= rand(123, 203) * $FieldFactor;					
				break;
				case 5:
					$PlanetType         = array('dschjungel');
					$PlanetClass        = array('planet');
					$PlanetDesign       = array('dschjungel' => rand(1,10));
					$planet['temp_max'] = rand(40, 80);
					$planet['temp_min'] = $planet['temp_max'] - 40;
					$planet['field_max']= rand(148, 210) * $FieldFactor;				
				break;
				case 6:
					$PlanetType         = array('dschjungel');
					$PlanetClass        = array('planet');
					$PlanetDesign       = array('dschjungel' => rand(1,10));
					$planet['temp_max'] = rand(30, 70);
					$planet['temp_min'] = $planet['temp_max'] - 40;
					$planet['field_max']= rand(148, 226) * $FieldFactor;						
				break;
				case 7:
					$PlanetType         = array('normaltemp');
					$PlanetClass        = array('planet');
					$PlanetDesign       = array('normaltemp' => rand(1,7));
					$planet['temp_max'] = rand(20, 60);
					$planet['temp_min'] = $planet['temp_max'] - 40;
					$planet['field_max']= rand(141, 273) * $FieldFactor;						
				break;
				case 8:
					$PlanetType         = array('normaltemp');
					$PlanetClass        = array('planet');
					$PlanetDesign       = array('normaltemp' => rand(1,7));
					$planet['temp_max'] = rand(10, 50);
					$planet['temp_min'] = $planet['temp_max'] - 40;
					$planet['field_max']= rand(169, 246) * $FieldFactor;						
				break;
				case 9:
					$PlanetType         = array('normaltemp', 'wasser');
					$PlanetClass        = array('planet');
					$PlanetDesign       = array('normaltemp' => rand(1,7), 'wasser' => rand(1,9));
					$planet['temp_max'] = rand(0, 40);
					$planet['temp_min'] = $planet['temp_max'] - 40;
					$planet['field_max']= rand(161, 238) * $FieldFactor;						
				break;
				case 10:
					$PlanetType         = array('wasser');
					$PlanetClass        = array('planet');
					$PlanetDesign       = array('wasser' => rand(1,9));
					$planet['temp_max'] = rand(-10, 30);
					$planet['temp_min'] = $planet['temp_max'] - 40;
					$planet['field_max']= rand(154, 224) * $FieldFactor;						
				break;
				case 11:
					$PlanetType         = array('wasser');
					$PlanetClass        = array('planet');
					$PlanetDesign       = array('wasser' => rand(1,9));
					$planet['temp_max'] = rand(-20, 20);
					$planet['temp_min'] = $planet['temp_max'] - 40;
					$planet['field_max']= rand(148, 204) * $FieldFactor;						
				break;
				case 12:
					$PlanetType         = array('wasser');
					$PlanetClass        = array('planet');
					$PlanetDesign       = array('wasser' => rand(1,9));
					$planet['temp_max'] = rand(-30, 10);
					$planet['temp_min'] = $planet['temp_max'] - 40;
					$planet['field_max']= rand(136, 171) * $FieldFactor;						
				break;
				case 13:
					$PlanetType         = array('eis');
					$PlanetClass        = array('planet');
					$PlanetDesign       = array('eis' => rand(1,10));
					$planet['temp_max'] = rand(-70, -30);
					$planet['temp_min'] = $planet['temp_max'] - 40;
					$planet['field_max']= rand(109, 121) * $FieldFactor;						
				break;
				case 14:
					$PlanetType         = array('eis', 'gas');
					$PlanetClass        = array('planet');
					$PlanetDesign       = array('eis' => rand(1,10), 'gas' => rand(1,8));
					$planet['temp_max'] = rand(-110, -70);
					$planet['temp_min'] = $planet['temp_max'] - 40;
					$planet['field_max']= rand(81, 93) * $FieldFactor;						
				break;
				case 15:
					$PlanetType         = array('eis', 'gas');
					$PlanetClass        = array('planet');
					$PlanetDesign       = array('eis' => rand(1,10), 'gas' => rand(1,8));
					$planet['temp_max'] = rand(-150, -110);
					$planet['temp_min'] = $planet['temp_max'] - 40;
					$planet['field_max']= rand(65, 74) * $FieldFactor;				
				break;
			}
			$planet['field_max']	= ($HomeWorld) ? $CONF['initial_fields'] : floor($planet['field_max']);
			$Type					= $PlanetType[array_rand($PlanetType)];
			$Class					= $PlanetClass[array_rand($PlanetClass)];
			$planet['image']		= $Type;
			$planet['image'] 	   .= $Class;
			$planet['image'] 	   .= (($PlanetDesign[$Type] <= 9) ? "0":"").$PlanetDesign[$Type];
			$planet['planet_type'] 	= 1;
			$planet['id_owner']    	= $PlanetOwnerID;
			$planet['last_update'] 	= TIMESTAMP;
			$planet['name']        	= ($PlanetName == '') ? $LNG['sys_colo_defaultname'] : $PlanetName;
			$planet['diameter']		= floor(1000 * sqrt($planet['field_max']));

			$QryInsertPlanet  = "INSERT INTO ".PLANETS." SET ";

			if($HomeWorld == false)
				$QryInsertPlanet .= "`name` = '".$LNG['fcp_colony']."', ";

			$QryInsertPlanet .= "`id_owner` = '".          $planet['id_owner']          ."', ";
			$QryInsertPlanet .= "`id_level` = '".          $USER['authlevel']           ."', ";
			$QryInsertPlanet .= "`galaxy` = '".            $planet['galaxy']            ."', ";
			$QryInsertPlanet .= "`system` = '".            $planet['system']            ."', ";
			$QryInsertPlanet .= "`planet` = '".            $planet['planet']            ."', ";
			$QryInsertPlanet .= "`last_update` = '".       $planet['last_update']       ."', ";
			$QryInsertPlanet .= "`planet_type` = '".       $planet['planet_type']       ."', ";
			$QryInsertPlanet .= "`image` = '".             $planet['image']             ."', ";
			$QryInsertPlanet .= "`diameter` = '".          $planet['diameter']          ."', ";
			$QryInsertPlanet .= "`field_max` = '".         $planet['field_max']         ."', ";
			$QryInsertPlanet .= "`temp_min` = '".          $planet['temp_min']          ."', ";
			$QryInsertPlanet .= "`temp_max` = '".          $planet['temp_max']          ."', ";
			$QryInsertPlanet .= "`metal` = '".             $planet['metal']             ."', ";
			$QryInsertPlanet .= "`metal_perhour` = '".     $planet['metal_perhour']     ."', ";
			$QryInsertPlanet .= "`metal_max` = '".         $planet['metal_max']         ."', ";
			$QryInsertPlanet .= "`crystal` = '".           $planet['crystal']           ."', ";
			$QryInsertPlanet .= "`crystal_perhour` = '".   $planet['crystal_perhour']   ."', ";
			$QryInsertPlanet .= "`crystal_max` = '".       $planet['crystal_max']       ."', ";
			$QryInsertPlanet .= "`deuterium` = '".         $planet['deuterium']         ."', ";
			$QryInsertPlanet .= "`deuterium_perhour` = '". $planet['deuterium_perhour'] ."', ";
			$QryInsertPlanet .= "`deuterium_max` = '".     $planet['deuterium_max']     ."';";
			
			$db->query( $QryInsertPlanet);

			$RetValue = true;
		}
		else
		{
			$RetValue = false;
		}

		return $RetValue;
	}
?>