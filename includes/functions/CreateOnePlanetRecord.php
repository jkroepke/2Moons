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

	function CreateOnePlanetRecord($Galaxy, $System, $Position, $PlanetOwnerID, $PlanetName = '', $HomeWorld = false, $AuthLevel = 0)
	{
		global $LNG, $db, $CONF;
	
		if(MAX_GALAXY_IN_WORLD < $Galaxy || 1 > $Galaxy) {
			throw new Exception("Access denied for CreateOnePlanetRecord.php.<br>Try to create a planet at position:".$Galaxy.":".$System.":".$Position);
		}	
		
		if(MAX_SYSTEM_IN_GALAXY < $System || 1 > $System) {
			throw new Exception("Access denied for CreateOnePlanetRecord.php.<br>Try to create a planet at position:".$Galaxy.":".$System.":".$Position);
		}	
		
		if(MAX_PLANET_IN_SYSTEM < $Position || 1 > $Position) {
			throw new Exception("Access denied for CreateOnePlanetRecord.php.<br>Try to create a planet at position:".$Galaxy.":".$System.":".$Position);
		}
		
		if (CheckPlanetIfExist($Galaxy, $System, $Position)) {
			return false;
		}

		$FieldFactor		= ($CONF['initial_fields'] / 163) * PLANET_SIZE_FACTOR;
		$Position			= ($Position > 15) ? mt_rand(1,15) : $Position;

		switch($Position) {
			case 1:
				$PlanetType         = array('trocken', 'wuesten');
				$PlanetClass        = array('planet');
				$PlanetDesign       = array('trocken' => rand(1,10), 'wuesten' => rand(1,4));
				$TMax				= rand(200, 240);
				$TMin				= $TMax - 40;
				$Fields				= rand(95,108) * $FieldFactor;					
			break;
			case 2:
				$PlanetType         = array('trocken', 'wuesten');
				$PlanetClass        = array('planet');
				$PlanetDesign       = array('trocken' => rand(1,10), 'wuesten' => rand(1,4));
				$TMax				= rand(150, 190);
				$TMin				= $TMax - 40;
				$Fields				= rand(97,110) * $FieldFactor;					
			break;
			case 3:
				$PlanetType         = array('trocken', 'wuesten');
				$PlanetClass        = array('planet');
				$PlanetDesign       = array('trocken' => rand(1,10), 'wuesten' => rand(1,4));
				$TMax				= rand(100, 140);
				$TMin				= $TMax - 40;
				$Fields				= rand(98, 137) * $FieldFactor;					
			break;
			case 4:
				$PlanetType         = array('dschjungel');
				$PlanetClass        = array('planet');
				$PlanetDesign       = array('dschjungel' => rand(1,10));
				$TMax				= rand(50, 90);
				$TMin				= $TMax - 40;
				$Fields				= rand(123, 203) * $FieldFactor;					
			break;
			case 5:
				$PlanetType         = array('dschjungel');
				$PlanetClass        = array('planet');
				$PlanetDesign       = array('dschjungel' => rand(1,10));
				$TMax				= rand(40, 80);
				$TMin				= $TMax - 40;
				$Fields				= rand(148, 210) * $FieldFactor;				
			break;
			case 6:
				$PlanetType         = array('dschjungel');
				$PlanetClass        = array('planet');
				$PlanetDesign       = array('dschjungel' => rand(1,10));
				$TMax				= rand(30, 70);
				$TMin				= $TMax - 40;
				$Fields				= rand(148, 226) * $FieldFactor;						
			break;
			case 7:
				$PlanetType         = array('normaltemp');
				$PlanetClass        = array('planet');
				$PlanetDesign       = array('normaltemp' => rand(1,7));
				$TMax				= rand(20, 60);
				$TMin				= $TMax - 40;
				$Fields				= rand(141, 273) * $FieldFactor;						
			break;
			case 8:
				$PlanetType         = array('normaltemp');
				$PlanetClass        = array('planet');
				$PlanetDesign       = array('normaltemp' => rand(1,7));
				$TMax				= rand(10, 50);
				$TMin				= $TMax - 40;
				$Fields				= rand(169, 246) * $FieldFactor;						
			break;
			case 9:
				$PlanetType         = array('normaltemp', 'wasser');
				$PlanetClass        = array('planet');
				$PlanetDesign       = array('normaltemp' => rand(1,7), 'wasser' => rand(1,9));
				$TMax				= rand(0, 40);
				$TMin				= $TMax - 40;
				$Fields				= rand(161, 238) * $FieldFactor;						
			break;
			case 10:
				$PlanetType         = array('wasser');
				$PlanetClass        = array('planet');
				$PlanetDesign       = array('wasser' => rand(1,9));
				$TMax				= rand(-10, 30);
				$TMin				= $TMax - 40;
				$Fields				= rand(154, 224) * $FieldFactor;						
			break;
			case 11:
				$PlanetType         = array('wasser');
				$PlanetClass        = array('planet');
				$PlanetDesign       = array('wasser' => rand(1,9));
				$TMax				= rand(-20, 20);
				$TMin				= $TMax - 40;
				$Fields				= rand(148, 204) * $FieldFactor;						
			break;
			case 12:
				$PlanetType         = array('wasser');
				$PlanetClass        = array('planet');
				$PlanetDesign       = array('wasser' => rand(1,9));
				$TMax				= rand(-30, 10);
				$TMin				= $TMax - 40;
				$Fields				= rand(136, 171) * $FieldFactor;						
			break;
			case 13:
			$PlanetType         = array('eis');
				$PlanetClass        = array('planet');
				$PlanetDesign       = array('eis' => rand(1,10));
				$TMax				= rand(-70, -30);
				$TMin				= $TMax - 40;
				$Fields				= rand(109, 121) * $FieldFactor;						
			break;
			case 14:
				$PlanetType         = array('eis', 'gas');
				$PlanetClass        = array('planet');
				$PlanetDesign       = array('eis' => rand(1,10), 'gas' => rand(1,8));
				$TMax				= rand(-110, -70);
				$TMin				= $TMax - 40;
				$Fields				= rand(81, 93) * $FieldFactor;						
			break;
			case 15:
				$PlanetType         = array('eis', 'gas');
				$PlanetClass        = array('planet');
				$PlanetDesign       = array('eis' => rand(1,10), 'gas' => rand(1,8));
				$TMax				= rand(-150, -110);
				$TMin				= $TMax - 40;
				$Fields				= rand(65, 74) * $FieldFactor;				
			break;
		}
		
		$Type					= $PlanetType[array_rand($PlanetType)];
		$Class					= $PlanetClass[array_rand($PlanetClass)];
		
		$SQL  = "INSERT INTO ".PLANETS." SET ";

		if($HomeWorld == false)
			$SQL .= "`name` = '".$PlanetName."', ";
		
		$SQL .= "`id_owner` = '".$PlanetOwnerID."', ";
		$SQL .= "`id_level` = '".$AuthLevel."', ";
		$SQL .= "`galaxy` = '".$Galaxy."', ";
		$SQL .= "`system` = '".$System."', ";
		$SQL .= "`planet` = '".$Position."', ";
		$SQL .= "`last_update` = '".TIMESTAMP."', ";
		$SQL .= "`planet_type` = '1', ";
		$SQL .= "`image` = '".($Type.$Class.(($PlanetDesign[$Type] <= 9)?'0':'').$PlanetDesign[$Type])."', ";
		$SQL .= "`diameter` = '".floor(1000 * sqrt($Fields))."', ";
		$SQL .= "`field_max` = '".(($HomeWorld) ? $CONF['initial_fields'] : floor($Fields))."', ";
		$SQL .= "`temp_min` = '".$TMin."', ";
		$SQL .= "`temp_max` = '".$TMax."', ";
		$SQL .= "`metal` = '".BUILD_METAL."', ";
		$SQL .= "`metal_perhour` = '".$CONF['metal_basic_income']."', ";
		$SQL .= "`crystal` = '".BUILD_CRISTAL."', ";
		$SQL .= "`crystal_perhour` = '".$CONF['crystal_basic_income']."', ";
		$SQL .= "`deuterium` = '".BUILD_DEUTERIUM."', ";
		$SQL .= "`deuterium_perhour` = '".$CONF['deuterium_basic_income']."';";
		
		$db->query($SQL);
		return true;
	}
?>