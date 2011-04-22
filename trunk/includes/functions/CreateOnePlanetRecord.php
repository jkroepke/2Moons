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
 * @version 1.3.5 (2011-04-22)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

function CreateOnePlanetRecord($Galaxy, $System, $Position, $Universe, $PlanetOwnerID, $PlanetName = '', $HomeWorld = false, $AuthLevel = 0)
{
	global $LNG, $db;

	$CONF	= getConfig($Universe);

	if ($CONF['max_galaxy'] < $Galaxy || 1 > $Galaxy) {
		throw new Exception("Access denied for CreateOnePlanetRecord.php.<br>Try to create a planet at position:".$Galaxy.":".$System.":".$Position);
	}	
	
	if ($CONF['max_system'] < $System || 1 > $System) {
		throw new Exception("Access denied for CreateOnePlanetRecord.php.<br>Try to create a planet at position:".$Galaxy.":".$System.":".$Position);
	}	
	
	if ($CONF['max_planets'] < $Position || 1 > $Position) {
		throw new Exception("Access denied for CreateOnePlanetRecord.php.<br>Try to create a planet at position:".$Galaxy.":".$System.":".$Position);
	}
	
	if (CheckPlanetIfExist($Galaxy, $System, $Position, $Universe)) {
		return false;
	}

	$FieldFactor		= $CONF['planet_factor'];
	$Position			= ($Position > 15) ? mt_rand(1,15) : $Position;

	switch($Position) {
		case 1:
			$PlanetType         = array('trocken', 'wuesten');
			$PlanetClass        = array('planet');
			$PlanetDesign       = array('trocken' => rand(1,10), 'wuesten' => rand(1,4));
			$TMax				= rand(220, 260);
			$TMin				= $TMax - 40;
			$Fields				= rand(95,108) * $FieldFactor;					
		break;
		case 2:
			$PlanetType         = array('trocken', 'wuesten');
			$PlanetClass        = array('planet');
			$PlanetDesign       = array('trocken' => rand(1,10), 'wuesten' => rand(1,4));
			$TMax				= rand(170, 210);
			$TMin				= $TMax - 40;
			$Fields				= rand(97,110) * $FieldFactor;					
		break;
		case 3:
			$PlanetType         = array('trocken', 'wuesten');
			$PlanetClass        = array('planet');
			$PlanetDesign       = array('trocken' => rand(1,10), 'wuesten' => rand(1,4));
			$TMax				= rand(120, 160);
			$TMin				= $TMax - 40;
			$Fields				= rand(98, 137) * $FieldFactor;					
		break;
		case 4:
			$PlanetType         = array('dschjungel');
			$PlanetClass        = array('planet');
			$PlanetDesign       = array('dschjungel' => rand(1,10));
			$TMax				= rand(70, 110);
			$TMin				= $TMax - 40;
			$Fields				= rand(123, 203) * $FieldFactor;					
		break;
		case 5:
			$PlanetType         = array('dschjungel');
			$PlanetClass        = array('planet');
			$PlanetDesign       = array('dschjungel' => rand(1,10));
			$TMax				= rand(60, 100);
			$TMin				= $TMax - 40;
			$Fields				= rand(148, 210) * $FieldFactor;				
		break;
		case 6:
			$PlanetType         = array('dschjungel');
			$PlanetClass        = array('planet');
			$PlanetDesign       = array('dschjungel' => rand(1,10));
			$TMax				= rand(50, 90);
			$TMin				= $TMax - 40;
			$Fields				= rand(148, 226) * $FieldFactor;						
		break;
		case 7:
			$PlanetType         = array('normaltemp');
			$PlanetClass        = array('planet');
			$PlanetDesign       = array('normaltemp' => rand(1,7));
			$TMax				= rand(40, 80);
			$TMin				= $TMax - 40;
			$Fields				= rand(141, 273) * $FieldFactor;						
		break;
		case 8:
			$PlanetType         = array('normaltemp');
			$PlanetClass        = array('planet');
			$PlanetDesign       = array('normaltemp' => rand(1,7));
			$TMax				= rand(30, 70);
			$TMin				= $TMax - 40;
			$Fields				= rand(169, 246) * $FieldFactor;						
		break;
		case 9:
			$PlanetType         = array('normaltemp', 'wasser');
			$PlanetClass        = array('planet');
			$PlanetDesign       = array('normaltemp' => rand(1,7), 'wasser' => rand(1,9));
			$TMax				= rand(20, 60);
			$TMin				= $TMax - 40;
			$Fields				= rand(161, 238) * $FieldFactor;						
		break;
		case 10:
			$PlanetType         = array('wasser');
			$PlanetClass        = array('planet');
			$PlanetDesign       = array('wasser' => rand(1,9));
			$TMax				= rand(10, 50);
			$TMin				= $TMax - 40;
			$Fields				= rand(154, 224) * $FieldFactor;						
		break;
		case 11:
			$PlanetType         = array('wasser');
			$PlanetClass        = array('planet');
			$PlanetDesign       = array('wasser' => rand(1,9));
			$TMax				= rand(0, 40);
			$TMin				= $TMax - 40;
			$Fields				= rand(148, 204) * $FieldFactor;						
		break;
		case 12:
			$PlanetType         = array('wasser');
			$PlanetClass        = array('planet');
			$PlanetDesign       = array('wasser' => rand(1,9));
			$TMax				= rand(-10, 30);
			$TMin				= $TMax - 40;
			$Fields				= rand(136, 171) * $FieldFactor;						
		break;
		case 13:
			$PlanetType         = array('eis');
			$PlanetClass        = array('planet');
			$PlanetDesign       = array('eis' => rand(1,10));
			$TMax				= rand(-50, -10);
			$TMin				= $TMax - 40;
			$Fields				= rand(109, 121) * $FieldFactor;						
		break;
		case 14:
			$PlanetType         = array('eis', 'gas');
			$PlanetClass        = array('planet');
			$PlanetDesign       = array('eis' => rand(1,10), 'gas' => rand(1,8));
			$TMax				= rand(-90, -50);
			$TMin				= $TMax - 40;
			$Fields				= rand(81, 93) * $FieldFactor;						
		break;
		case 15:
			$PlanetType         = array('eis', 'gas');
			$PlanetClass        = array('planet');
			$PlanetDesign       = array('eis' => rand(1,10), 'gas' => rand(1,8));
			$TMax				= rand(-130, -90);
			$TMin				= $TMax - 40;
			$Fields				= rand(65, 74) * $FieldFactor;				
		break;
	}
	
	$Type					= $PlanetType[array_rand($PlanetType)];
	$Class					= $PlanetClass[array_rand($PlanetClass)];
	
	$SQL  = "INSERT INTO ".PLANETS." SET ";

	if(!empty($PlanetName))
		$SQL .= "`name` = '".$PlanetName."', ";
	
	if($CONF['adm_attack'] == 0)
		$AuthLevel = AUTH_USR;
	
	$SQL .= "`universe` = '".$Universe."', ";
	$SQL .= "`id_owner` = '".$PlanetOwnerID."', ";
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
	$SQL .= "`metal` = '".$CONF['metal_start']."', ";
	$SQL .= "`metal_perhour` = '".$CONF['metal_basic_income']."', ";
	$SQL .= "`crystal` = '".$CONF['crystal_start']."', ";
	$SQL .= "`crystal_perhour` = '".$CONF['crystal_basic_income']."', ";
	$SQL .= "`deuterium` = '".$CONF['deuterium_start']."', ";
	$SQL .= "`deuterium_perhour` = '".$CONF['deuterium_basic_income']."';";
	
	$db->query($SQL);
	return $db->GetInsertID();
}
?>