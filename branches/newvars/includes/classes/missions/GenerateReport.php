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

function GenerateReport($RESULT, $INFO)
{
	$Destroy	= array('att' => 0, 'def' => 0);
	$DATA		= array();
	$DATA['mode']	= (int) $INFO['moon']['des'];
	$DATA['time']	= $INFO['fleet_start_time'];
	$DATA['start']	= array($INFO['fleet_start_galaxy'], $INFO['fleet_start_system'], $INFO['fleet_start_planet'], $INFO['fleet_start_type']);
	$DATA['koords']	= array($INFO['fleet_end_galaxy'], $INFO['fleet_end_system'], $INFO['fleet_end_planet'], $INFO['fleet_end_type']);
	$DATA['units']	= array($RESULT['lost']['att'], $RESULT['lost']['def']);
	$DATA['debris']	= array($RESULT['debree']['att'][0] + $RESULT['debree']['def'][0], $RESULT['debree']['att'][1] + $RESULT['debree']['def'][1]);
	$DATA['steal']	= array($INFO['steal']['metal'], $INFO['steal']['crystal'], $INFO['steal']['deuterium']);
	$DATA['result']	= $RESULT['won'];
	$DATA['moon']	= array(
		(int) $INFO['moon']['chance'],
		$INFO['moon']['name'],
		(int) $INFO['moon']['desfail'],
		(int) $INFO['moon']['chance2'],
		(int) $INFO['moon']['fleetfail']
	);
	
	$DATA['simu']	= isset($INFO['battlesim']) ? $INFO['battlesim'] : "";
	
	foreach($RESULT['rw'][0]['attackers'] as $Player)
	{
		$DATA['players'][$Player['user']['id']]	= array(
			'name'		=> $Player['user']['username'],
			'koords'	=> array($Player['fleet']['fleet_start_galaxy'], $Player['fleet']['fleet_start_system'], $Player['fleet']['fleet_start_planet']),
			'tech'		=> array($Player['techs'][0] * 100, $Player['techs'][1] * 100, $Player['techs'][2] * 100),
		);
	}
	foreach($RESULT['rw'][0]['defenders'] as $FleetID => $Player)
	{
		if($FleetID == 0) {
			$Koords	= $DATA['koords'];
		} else {
			$Koords	= array(
				$Player['fleet']['fleet_start_galaxy'], 
				$Player['fleet']['fleet_start_system'], 
				$Player['fleet']['fleet_start_planet']
			);
		}
		
		$DATA['players'][$Player['user']['id']]	= array(
			'name'		=> $Player['user']['username'],
			'koords'	=> $Koords,
			'tech'		=> array($Player['techs'][0] * 100, $Player['techs'][1] * 100, $Player['techs'][2] * 100),
		);
	}
	
	foreach($RESULT['rw'] as $Round => $RoundInfo)
	{
		foreach($RoundInfo['attackers'] as $FleetID => $Player)
		{	
			$PlayerData	= array('userID' => $Player['user']['id'], 'ships' => array());
			
			if(array_sum($Player['detail']) == 0) {
				$DATA['rounds'][$Round]['attacker'][] = $PlayerData;
				$Destroy['att']++;
				continue;
			}
			
			foreach($Player['detail'] as $ShipID => $Amount)
			{
				if ($Amount <= 0)
					continue;
					
				$ShipInfo	= $RoundInfo['infoA'][$FleetID][$ShipID];
				$PlayerData['ships'][$ShipID]	= array(
					$Amount, $ShipInfo['att'], $ShipInfo['def'], $ShipInfo['shield']
				);
			}
			
			$DATA['rounds'][$Round]['attacker'][] = $PlayerData;
		}
		
		foreach($RoundInfo['defenders'] as $FleetID => $Player)
		{	
			$PlayerData	= array('userID' => $Player['user']['id'], 'ships' => array());
			if(array_sum($Player['def']) == 0) {
				$DATA['rounds'][$Round]['defender'][] = $PlayerData;
				$Destroy['def']++;
				continue;
			}
				
			foreach($Player['def'] as $ShipID => $Amount)
			{
				if ($Amount <= 0) {
					$Destroy['def']++;
					continue;
				}
					
				$ShipInfo	= $RoundInfo['infoD'][$FleetID][$ShipID];
				$PlayerData['ships'][$ShipID]	= array(
					$Amount, $ShipInfo['att'], $ShipInfo['def'], $ShipInfo['shield']
				);
			}
			$DATA['rounds'][$Round]['defender'][] = $PlayerData;
		}
		
		if ($Round >= MAX_ATTACK_ROUNDS || $Destroy['att'] == count($RoundInfo['attackers']) || $Destroy['def'] == count($RoundInfo['defenders']))
			break;
		
		if(isset($RoundInfo['attack'], $RoundInfo['attackShield'], $RoundInfo['defense'], $RoundInfo['defShield']))
			$DATA['rounds'][$Round]['info']	= array($RoundInfo['attack'], $RoundInfo['attackShield'], $RoundInfo['defense'], $RoundInfo['defShield']);
		else
			$DATA['rounds'][$Round]['info']	= array(NULL, NULL, NULL, NULL);
	}
	return $DATA;
}
	
?>