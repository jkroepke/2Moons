<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan
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
 * @author Jan <info@2moons.cc>
 * @copyright 2006 Perberos <ugamela@perberos.com.ar> (UGamela)
 * @copyright 2008 Chlorel (XNova)
 * @copyright 2009 Lucky (XGProyecto)
 * @copyright 2012 Jan <info@2moons.cc> (2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 2.0.$Revision: 2242 $ (2012-11-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

class Statistical {
	
	private $startTime;
	
	private $flyingFleet	= array();
	private $oldRanks		= array();
	private $elementUnit	= array();
	
	private $planetData;
	private $userData;
	private $allianceData;
	
	private $userPoints;
	private $alliancePoints;
	
	private $frendlyShips	= array();
	
	function reBuildStatistics()
	{
		$this->startTime	= microtime(true);
		
		$this->calculatePointsPerElement();
		
		$this->getUserData();
		$this->getOldRanks();
		
		$this->calculateBuildPoints();
		$this->calculateTechPoints();
		$this->calculateFleetPoints();
		$this->calculateDefensivePoints();
		$this->calculateMilitaryPoints();
		$this->calculateAlliancePoints();
	}
	
	function calculatePointsPerElement()
	{
		global $uniConfig;
		foreach($elementIDs as $elementID)
		{
			if(elementHasFlag($elementID, ELEMENT_BUILD) || elementHasFlag($elementID, ELEMENT_TECH))
			{
				$this->elementUnit[$elementID] = array_sum(BuildFunctions::getElementPrice(NULL, NULL, $elementID, false, 2)) / $uniConfig['highscorePointsPerResource'];
			}
			
			if(elementHasFlag($elementID, ELEMENT_TECH) || elementHasFlag($elementID, ELEMENT_TECH))
			{
				$this->elementUnit[$elementID] = array_sum(BuildFunctions::getElementPrice(NULL, NULL, $elementID)) / $uniConfig['highscorePointsPerResource'];
			}
		}		
	}
	
	function getUserData()
	{
		$fieldsBuild		= array();
		$fieldsTech			= array();
		$fieldsFleet		= array();
		$fieldsDefensive	=	'';
		
		$elementIDs	= array_keys($GLOBALS['VARS']['ELEMENT']);
		
		foreach($elementIDs as $elementID)
		{
			if(elementHasFlag($elementID, ELEMENT_BUILD))
			{
				$fieldsBuild[]		= $GLOBALS['VARS']['ELEMENT'][$elementID]['name'];
			}
			
			if(elementHasFlag($elementID, ELEMENT_TECH))
			{
				$fieldsTech[]		= $GLOBALS['VARS']['ELEMENT'][$elementID]['name'];
			}
			
			if(elementHasFlag($elementID, ELEMENT_TECH))
			{
				$fieldsFleet[]		= $GLOBALS['VARS']['ELEMENT'][$elementID]['name'];
			}
			
			if(elementHasFlag($elementID, ELEMENT_TECH))
			{
				$fieldsDefensive[]	= $GLOBALS['VARS']['ELEMENT'][$elementID]['name'];
			}
		}
		
		$GLOBALS['DATABASE']->free_result($SQLFleets);
		
		$planetResult	= $GLOBALS['DATABASE']->query("SELECT SQL_BIG_RESULT
													   id, id_owner, planet_type, universe, ".implode(', ', $fieldsBuild).",  ".implode(', ', $fieldsFleet).", ,  ".implode(', ', $fieldsDefensive)."
													   FROM ".PLANETS.";");
		
		while($planetRow = $GLOBALS['DATABASE']->fetchArray($planetResult))
		{
			$this->planetData[$planetRow['id_owner']]	= $planetRow;
		}
		
		$GLOBALS['DATABASE']->close($planetResult);
		
		$userResult		= $GLOBALS['DATABASE']->query("SELECT SQL_BIG_RESULT
													   id, authlevel, universe, id_ally, ".implode(', ', $fieldsTech).", IF(banID = null, 1, 0) as isBanned
													   FROM ".USERS."
													   LEFT JOIN ".BANNED." ON until > ".TIMESTAMP." AND userID = id;");
		
		while($userRow = $GLOBALS['DATABASE']->fetchArray($userResult))
		{
			$this->userData[$userRow['id']]	= $userRow;
		}
		
		$GLOBALS['DATABASE']->close($userResult);

		$allianceResult	= $GLOBALS['DATABASE']->query("SELECT
													   allianceID, universe
													   FROM ".ALLIANCE.";");
		
		while($allianceRow = $GLOBALS['DATABASE']->fetchArray($allianceResult))
		{
			$this->allianceData[$allianceRow['id']]	= $allianceRow;
		}
		
		$GLOBALS['DATABASE']->close($allianceResult);
	}
	
	function getOldRanks()
	{												  
		$rankResult	= $GLOBALS['DATABASE']->query("SELECT SQL_BIG_RESULT
												   ownerID, type, techRank, buildRank, defensiveRank, fleetRank, economyRank, militaryRank, totalRank
												   FROM ".STATPOINTS.";");

		while($rankRow = $GLOBALS['DATABASE']->fetchArray($rankResult))
		{
			$this->oldRanks[$rankRow['type']][$rankRow['ownerID']] = array(
				'techRank'		=> $rankRow['techRank'],
				'buildRank'		=> $rankRow['buildRank'],
				'defensiveRank'	=> $rankRow['defensiveRank'],
				'fleetRank'		=> $rankRow['fleetRank'],
				'economyRank'	=> $rankRow['economyRank'],
				'militaryRank'	=> $rankRow['militaryRank'],
				'totalRank'		=> $rankRow['totalRank'],
			);
		}
		
		$GLOBALS['DATABASE']->close($rankResult);
	}
	
	function getFlyingFleets()
	{
		$fleetsResult	= $GLOBALS['DATABASE']->query("SELECT fleet_array, fleet_owner FROM ".FLEETS.";");
		
		while ($fleetsRow = $GLOBALS['DATABASE']->fetchArray($fleetsResult))
		{
			$shipArray	= explode(";", $fleetsRow['fleet_array']);
				
			foreach($shipArray as $shipGroup) {
				if (empty($shipGroup))
				{	
					continue;
				}
				
				$shipInfo	= explode(",", $shipGroup);
				
				if (isset($GLOBALS['VARS']['ELEMENT'][$shipInfo[0]]))
				{	
					continue;
				}
				
				if(!isset($FlyingFleets[$CurFleets['fleet_owner']][$shipInfo[0]]))
				{
					$this->flyingFleet[$CurFleets['fleet_owner']][$shipInfo[0]]	= 0;
				}
				
				$this->flyingFleet[$CurFleets['fleet_owner']][$shipInfo[0]]	+= $shipInfo[1];
			}
		}
	}

	function calculateBuildPoints()
	{
		foreach($this->planetData as $userID => $planetData)
		{
			foreach($GLOBALS['VARS']['LIST'][ELEMENT_BUILD] as $elementID)
			{
				$Level = $planetData[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']];
				
				if(empty($Level)) continue;
				
				if(isset($this->userPoints[$userID]['buildPoints']))
				{
					$this->userPoints[$userID]['buildPoints']	= 0;
					$this->userPoints[$userID]['buildCount']		= 0;
				}
				
				$this->userPoints[$userID]['buildPoints']	+= $this->calculateSum($this->elementUnit[$elementID], $Level, $GLOBALS['VARS']['ELEMENT'][$elementID]['factor']);
				$this->userPoints[$userID]['buildCount']		+= $Level;
			}
		}
	}
	
	function calculateTechPoints()
	{
		foreach($this->userData as $userID => $userData)
		{
			foreach($GLOBALS['VARS']['LIST'][ELEMENT_TECH] as $elementID)
			{
				$Level = $userData[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']];
				
				if(empty($Level)) continue;
				
				if(isset($this->userPoints[$userID]['techPoints']))
				{
					$this->userPoints[$userID]['techPoints']	= 0;
					$this->userPoints[$userID]['techCount']	= 0;
				}
				
				$this->userPoints[$userID]['techPoints']	+= $this->calculateSum($this->elementUnit[$elementID], $Level, $GLOBALS['VARS']['ELEMENT'][$elementID]['factor']);
				$this->userPoints[$userID]['techCount']	+= $Level;
			}
		}
	}
	
	function calculateFleetPoints()
	{
		foreach($this->planetData as $userID => $planetData)
		{
			foreach($GLOBALS['VARS']['LIST'][ELEMENT_FLEET] as $elementID)
			{				
				$Level = $planetData[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']];
				
				if(empty($Level)) continue;
				
				if(isset($this->userPoints[$userID]['fleetPoints']))
				{
					$this->userPoints[$userID]['fleetPoints']	= 0;
					$this->userPoints[$userID]['fleetCount']		= 0;
				}
				
				$this->userPoints[$userID]['fleetPoints']	+= $this->calculateSum($this->elementUnit[$elementID], $Level, $GLOBALS['VARS']['ELEMENT'][$elementID]['factor']);
				$this->userPoints[$userID]['fleetCount']		+= $Level;
			}
		}
		
		foreach($this->flyingFleet as $userID => $fleetData)
		{
			foreach($fleetData as $elementID => $shipAmount)
			{
				if(empty($shipAmount)) continue;
				
				if(isset($this->userPoints[$userID]['fleetPoints']))
				{
					$this->userPoints[$userID]['fleetPoints']	= 0;
					$this->userPoints[$userID]['fleetCount']		= 0;
				}
				
				$this->userPoints[$userID]['fleetPoints']	+= $this->calculateSum($this->elementUnit[$elementID], $shipAmount, $GLOBALS['VARS']['ELEMENT'][$elementID]['factor']);
				$this->userPoints[$userID]['fleetCount']	+= $shipAmount;
			}
		}
	}
	
	function calculateDefensivePoints()
	{
		foreach($this->planetData as $userID => $planetData)
		{
			foreach($GLOBALS['VARS']['LIST'][ELEMENT_DEFENSIVE] as $elementID)
			{				
				$Level = $planetData[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']];
				
				if(empty($Level)) continue;
				
				if(isset($this->userPoints[$userID]['defensivePoints']))
				{
					$this->userPoints[$userID]['defensivePoints']	= 0;
					$this->userPoints[$userID]['defensiveCount']		= 0;
				}
				
				$this->userPoints[$userID]['defensivePoints']	+= $this->calculateSum($this->elementUnit[$elementID], $Level, $GLOBALS['VARS']['ELEMENT'][$elementID]['factor']);
				$this->userPoints[$userID]['defensiveCount']		+= $Level;
			}
		}
		
		foreach($this->flyingFleet as $userID => $fleetData)
		{
			foreach($fleetData as $elementID => $shipAmount)
			{
				if(empty($shipAmount)) continue;
				
				if(isset($this->userPoints[$userID]['fleetPoints']))
				{
					$this->userPoints[$userID]['fleetPoints']	= 0;
					$this->userPoints[$userID]['fleetCount']		= 0;
				}
				
				$this->userPoints[$userID]['fleetPoints']	+= $this->calculateSum($this->elementUnit[$elementID], $shipAmount, $GLOBALS['VARS']['ELEMENT'][$elementID]['factor']);
				$this->userPoints[$userID]['fleetCount']	+= $shipAmount;
			}
		}
	}

	function calculateEconomyPoints()
	{
		/* Der Ökonomie-Highscore berücksichtigt die verbauten Rohstoffe für Gebäude und Verteidigungsanlagen, sowie zu 50% die verbauten Rohstoffe ziviler Schiffe, Phalanxen und Sprungtore. */

		if(isset($this->userPoints[$userID]['economyPoints']))
		{
			$this->userPoints[$userID]['economyPoints']	= 0;
			$this->userPoints[$userID]['economyCount']	= 0;
		}

		foreach($this->planetData as $userID => $planetData)
		{
			foreach($GLOBALS['VARS']['LIST'][ELEMENT_BUILD] as $elementID)
			{
				$Level = $planetData[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']];
				
				if(empty($Level)) continue;
				
				$Points	= $this->calculateSum($this->elementUnit[$elementID], $Level, $GLOBALS['VARS']['ELEMENT'][$elementID]['factor']);
				$Count	= $Level;
				
				if($elementID == 42 || $elementID == 43)
				{
					$Points	= round($Points / 2, 0);
					$Count	= round($Count / 2, 0);
				}
				
				$this->userPoints[$userID]['economyPoints']	+= $Points;
				$this->userPoints[$userID]['economyCount']	+= $Count;
			}
			
			foreach($GLOBALS['VARS']['LIST'][ELEMENT_FLEET_CIVIL] as $elementID)
			{
				$Level = $planetData[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']];
				
				if(empty($Level)) continue;
				
				$this->userPoints[$userID]['economyPoints']	+= round($this->calculateSum($this->elementUnit[$elementID], $Level, $GLOBALS['VARS']['ELEMENT'][$elementID]['factor']) / 2);
				$this->userPoints[$userID]['economyCount']	+= round($Level / 2);
			}
		}
	}
	
	function calculateMilitaryPoints()
	{
		if(isset($this->userPoints[$userID]['militaryPoints']))
		{
			$this->userPoints[$userID]['militaryPoints']	= 0;
			$this->userPoints[$userID]['militaryCount']	= 0;
		}
		
		$this->userPoints[$userID]['militaryPoints']	+= $this->userPoints[$userID]['defensivePoints'];
		$this->userPoints[$userID]['militaryCount']	+= $this->userPoints[$userID]['defensiveCount'];
		
		foreach($this->planetData as $userID => $planetData)
		{
			foreach(array(42, 43) as $elementID)
			{				
				$Level = $planetData[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']];
				
				if(empty($Level)) continue;
				
				$this->userPoints[$userID]['militaryPoints']	+= round($this->calculateSum($this->elementUnit[$elementID], $Level, $GLOBALS['VARS']['ELEMENT'][$elementID]['factor']) / 2, 0);
				$this->userPoints[$userID]['militaryCount']	+= round($Level / 2, 0);
			}
		}
			
		foreach($GLOBALS['VARS']['LIST'][ELEMENT_FLEET] as $elementID)
		{
			$Level = $planetData[$GLOBALS['VARS']['ELEMENT'][$elementID]['name']];
			
			if(empty($Level)) continue;
				
			$Points	= $this->calculateSum($this->elementUnit[$elementID], $Level, $GLOBALS['VARS']['ELEMENT'][$elementID]['factor']);
			$Count	= $Level;
			
			if(elementHasFlag($elementID, ELEMENT_FLEET_CIVIL))
			{
				$Points	= round($Points / 2, 0);
				$Count	= round($Count / 2, 0);
			}
			
			$this->userPoints[$userID]['economyPoints']	+= $Points;
			$this->userPoints[$userID]['economyCount']	+= $Count;
		}
	}
	
	function calculateTotalPoints()
	{
		foreach($this->userData as $userID => $userData)
		{
			if(isset($this->userPoints[$userID]['totalCount']))
			{
				$this->userPoints[$userID]['totalCount']		= 0;
				$this->userPoints[$userID]['totalPoints']		= 0;
			}
			
			$this->userPoints[$userID]['totalCount']	+= $this->userPoints[$userID]['techCount'];
			$this->userPoints[$userID]['totalPoints']	+= $this->userPoints[$userID]['techPoints'];
			
			$this->userPoints[$userID]['totalCount']	+= $this->userPoints[$userID]['buildCount'];
			$this->userPoints[$userID]['totalPoints']	+= $this->userPoints[$userID]['buildPoints'];
			
			$this->userPoints[$userID]['totalCount']	+= $this->userPoints[$userID]['defensiveCount'];
			$this->userPoints[$userID]['totalPoints']	+= $this->userPoints[$userID]['defensivePoints'];
			
			$this->userPoints[$userID]['totalCount']	+= $this->userPoints[$userID]['fleetCount'];
			$this->userPoints[$userID]['totalPoints']	+= $this->userPoints[$userID]['fleetPoints'];
			
			$this->userPoints[$userID]['totalCount']	+= $this->userPoints[$userID]['economyCount'];
			$this->userPoints[$userID]['totalPoints']	+= $this->userPoints[$userID]['economyPoints'];
			
			$this->userPoints[$userID]['totalCount']	+= $this->userPoints[$userID]['militaryCount'];
			$this->userPoints[$userID]['totalPoints']	+= $this->userPoints[$userID]['militaryPoints'];
		}
	}
	
	function calculateAlliancePoints()
	{
		foreach($this->userData as $userID => $userData)
		{
			if(isset($this->alliancePoints[$userData['id_ally']]))
			{
				$this->alliancePoints[$userData['id_ally']]['techCount']		= 0;
				$this->alliancePoints[$userData['id_ally']]['techPoints']		= 0;
				$this->alliancePoints[$userData['id_ally']]['buildCount']		= 0;
				$this->alliancePoints[$userData['id_ally']]['buildPoints']		= 0;
				$this->alliancePoints[$userData['id_ally']]['defensiveCount']	= 0;
				$this->alliancePoints[$userData['id_ally']]['defensivePoints']	= 0;
				$this->alliancePoints[$userData['id_ally']]['fleetCount']		= 0;
				$this->alliancePoints[$userData['id_ally']]['fleetPoints']		= 0;
				$this->alliancePoints[$userData['id_ally']]['economyCount']		= 0;
				$this->alliancePoints[$userData['id_ally']]['economyPoints']	= 0;
				$this->alliancePoints[$userData['id_ally']]['militaryCount']	= 0;
				$this->alliancePoints[$userData['id_ally']]['militaryPoints']	= 0;
				$this->alliancePoints[$userData['id_ally']]['totalCount']		= 0;
				$this->alliancePoints[$userData['id_ally']]['totalPoints']		= 0;
			}
			
			$this->alliancePoints[$userData['id_ally']]['techCount']		+= $this->userPoints[$userID]['techCount'];
			$this->alliancePoints[$userData['id_ally']]['techPoints']		+= $this->userPoints[$userID]['techPoints'];
			$this->alliancePoints[$userData['id_ally']]['buildCount']		+= $this->userPoints[$userID]['buildCount'];
			$this->alliancePoints[$userData['id_ally']]['buildPoints']		+= $this->userPoints[$userID]['buildPoints'];
			$this->alliancePoints[$userData['id_ally']]['defensiveCount']	+= $this->userPoints[$userID]['defensiveCount'];
			$this->alliancePoints[$userData['id_ally']]['defensivePoints']	+= $this->userPoints[$userID]['defensivePoints'];
			$this->alliancePoints[$userData['id_ally']]['fleetCount']		+= $this->userPoints[$userID]['fleetCount'];
			$this->alliancePoints[$userData['id_ally']]['fleetPoints']		+= $this->userPoints[$userID]['fleetPoints'];
			$this->alliancePoints[$userData['id_ally']]['economyCount']		+= $this->userPoints[$userID]['economyCount'];
			$this->alliancePoints[$userData['id_ally']]['economyPoints']	+= $this->userPoints[$userID]['economyPoints'];
			$this->alliancePoints[$userData['id_ally']]['militaryCount']	+= $this->userPoints[$userID]['militaryCount'];
			$this->alliancePoints[$userData['id_ally']]['militaryPoints']	+= $this->userPoints[$userID]['militaryPoints'];
			$this->alliancePoints[$userData['id_ally']]['totalCount']		+= $this->userPoints[$userID]['totalCount'];
			$this->alliancePoints[$userData['id_ally']]['totalPoints']		+= $this->userPoints[$userID]['totalPoints'];
		}
	}
	
	function calculateSum($Number, $To, $Factor)
	{
		$Total = 0;
		if($Factor != 1)
		{
			for($i = 1; $i <= $To; $i++)
			{
				$Total	+= $Number * pow($Factor, $i);
			}
		}
		else
		{
			$Total	+= $Number * $i;
		}
		return $Total;
	}
}