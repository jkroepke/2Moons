<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
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
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.8.0 (2013-03-18)
 * @info $Id$
 * @link http://2moons.cc/
 */

class StatisticBuilder
{
	private $recordData = array();
	private $universes  = array();

	function __construct()
	{
		$this->starttime   	= microtime(true);
		$this->memory		= array(round(memory_get_usage() / 1024,1),round(memory_get_usage(1) / 1024,1));
		$this->time   		= TIMESTAMP;

		$uniResult	= Database::get()->select("SELECT uni FROM %%CONFIG%% ORDER BY uni ASC;");
		foreach($uniResult as $uni)
		{
			$this->universes[]	= $uni['uni'];
		}
	}

	private function SomeStatsInfos()
	{
		return array(
			'stats_time'		=> $this->time,
			'totaltime'    		=> round(microtime(true) - $this->starttime, 7),
			'memory_peak'		=> array(round(memory_get_peak_usage() / 1024,1), round(memory_get_peak_usage(1) / 1024,1)),
			'initial_memory'	=> $this->memory,
			'end_memory'		=> array(round(memory_get_usage() / 1024,1), round(memory_get_usage(1) / 1024,1)),
			'sql_count'			=> Database::get()->getQueryCounter(),
		);
	}
	
	private function CheckUniverseAccounts($UniData)
	{
		$UniData	= $UniData + array_combine($this->universes, array_fill(1, count($this->universes), 0));
		foreach($UniData as $Uni => $Amount) {
			$config	= Config::get($Uni);
			$config->users_amount = $Amount;
			$config->save();
		}
	}
	
	private function GetUsersInfosFromDB()
	{
		$queryUser      = array();
		$queryPlanet    = array();
				
		foreach(Vars::getElements(Vars::CLASS_BUILDING) as $elementObj)
		{
			$queryPlanet[]  = "planet.".$elementObj->name;
		}

		foreach(Vars::getElements(Vars::CLASS_TECH) as $elementObj)
		{
			$queryUser[]    = "user.".$elementObj->name;
		}

		foreach(Vars::getElements(Vars::CLASS_FLEET) as $elementObj)
		{
			$queryUser[]    = "SUM(planet.".$elementObj->name.") as ".$elementObj->name;
		}

		foreach(Vars::getElements(Vars::CLASS_DEFENSE) as $elementObj)
		{
			$queryUser[]    = "SUM(planet.".$elementObj->name.") as ".$elementObj->name;
		}

		foreach(Vars::getElements(Vars::CLASS_MISSILE) as $elementObj)
		{
			$queryUser[]    = "SUM(planet.".$elementObj->name.") as ".$elementObj->name;
		}

		$flyingFleets	= array();
		$db	            = Database::get();

		$fleetResult    = $db->select('SELECT %%FLEETS_ELEMENTS%%.*,fleet_owner FROM %%FLEETS_ELEMENTS%% INNER JOIN %%FLEETS%% on fleet_id = fleetId;');
		foreach($fleetResult as $fleetRow)
		{
			if(!isset($flyingFleets[$fleetRow['fleet_owner']]))
			{
				$flyingFleets[$fleetRow['fleet_owner']] = array();
			}

			if(!isset($flyingFleets[$fleetRow['fleet_owner']][$fleetRow['elementId']]))
			{
				$flyingFleets[$fleetRow['fleet_owner']][$fleetRow['elementId']] = 0;
			}

			$flyingFleets[$fleetRow['fleet_owner']][$fleetRow['elementId']] += $fleetRow['amount'];
		}
		
		$statData['Fleets'] 	= $flyingFleets;
		$statData['Planets']	= $db->select('SELECT '.implode(',',$queryPlanet).', planet.id, planet.universe, planet.id_owner, user.authlevel, user.bana, user.username
			FROM %%PLANETS%% as planet
			LEFT JOIN %%USERS%% as user ON user.id = planet.id_owner;');

		$statData['Users']	= $db->select('SELECT '.implode(',',$queryUser).', user.id, user.ally_id, user.authlevel, user.bana, user.universe, user.username,
			stats.tech_rank AS old_tech_rank, stats.build_rank AS old_build_rank, stats.defs_rank AS old_defs_rank, stats.fleet_rank AS old_fleet_rank, stats.total_rank AS old_total_rank
			FROM %%USERS%% as user
			LEFT JOIN %%STATPOINTS%% as stats ON stats.stat_type = 1 AND stats.id_owner = user.id
			LEFT JOIN %%PLANETS%% as planet ON user.id = planet.id_owner
			GROUP BY stats.id_owner;');

		$statData['Alliance']	= $db->select('SELECT alliance.id, alliance.ally_universe,
		stats.tech_rank AS old_tech_rank, stats.build_rank AS old_build_rank, stats.defs_rank AS old_defs_rank, stats.fleet_rank AS old_fleet_rank, stats.total_rank AS old_total_rank
		FROM %%ALLIANCE%% as alliance
		LEFT JOIN %%STATPOINTS%% as stats ON stats.stat_type = 2 AND stats.id_owner = alliance.id;');
	
		return $statData;
	}
	
	private function setRecords($userID, $elementID, $amount)
	{
		$this->recordData[$elementID][$amount][]	= $userID;
	}
	
	private function writeRecordData()
	{
		$QueryData	= array();
		foreach($this->recordData as $elementID => $elementArray) {
			krsort($elementArray, SORT_NUMERIC);
			$userWinner		= reset($elementArray);
			$maxAmount		= key($elementArray);
			$userWinner		= array_unique($userWinner);

			if(count($userWinner) > 3)
			{
				$keys			= array_rand($userWinner, 3);

				foreach($keys as $key)
				{
					$QueryData[]	= "(".$userWinner[$key].",".$elementID.",".$maxAmount.")";
				}
			}
			else
			{
				foreach($userWinner as $userID) {
					$QueryData[]	= "(".$userID.",".$elementID.",".$maxAmount.")";
				}
			}
		}
		
		if(!empty($QueryData)) {
			$SQL	= "TRUNCATE TABLE %%RECORDS%%;";
			$SQL	.= "INSERT INTO %%RECORDS%% (userID, elementID, level) VALUES ".implode(', ', $QueryData).";";
			$this->SaveDataIntoDB($SQL);
		}
	}
	
	private function SaveDataIntoDB($Data)
	{
		$queries	= explode(';', $Data);
		$queries	= array_filter($queries);
		foreach($queries as $query)
		{
			Database::get()->nativeQuery($query);
		}
	}

	private function calculatePoints($data, $class)
	{
		$count = 0;
		$points = 0;

		foreach(Vars::getElements($class) as $elementId => $elementObj)
		{
			if($data[$elementObj->name] == 0) continue;

			$units  = 0;
			foreach(array_keys(Vars::getElements(Vars::CLASS_RESOURCE, Vars::FLAG_RESOURCE_PLANET)) as $resourceElementId)
			{
				$units  += $elementObj->cost[$resourceElementId];
			}

			$elementLevel   = $data[$elementObj->name];

			if($elementObj->factor == 0 || $elementObj->factor == 1)
			{
				$points	+= $units * $elementLevel;
			}
			else
			{
				for($level = 1; $level <= $elementLevel; $level++)
				{
					$points	+= $units * pow($elementObj->factor, $level);
				}
			}
			
			$count		+= $elementLevel;
			
			$this->setRecords(isset($data['id_owner']) ? $data['id_owner'] : $data['id'], $elementId, $elementLevel);
		}
		
		return array(
			'count'     => $count,
			'points'    => ($points / Config::get()->stat_settings)
		);
	}
	
	private function SetNewRanks()
	{
		foreach($this->universes as $uni)
		{
			foreach(array('tech', 'build', 'defs', 'fleet', 'total') as $type)
			{
				Database::get()->nativeQuery('SELECT @i := 0;');

				$sql = 'UPDATE %%STATPOINTS%% SET '.$type.'_rank = (SELECT @i := @i + 1)
				WHERE universe = :uni AND stat_type = :type
				ORDER BY '.$type.'_points DESC, id_owner ASC;';

				Database::get()->update($sql, array(
					':uni'	=> $uni,
					':type'	=> 1,
				));

				Database::get()->nativeQuery('SELECT @i := 0;');

				Database::get()->update($sql, array(
					':uni'	=> $uni,
					':type'	=> 2,
				));
			}
		}
	}
	
	final public function MakeStats()
	{
		global $resource;
		$AllyPoints	= array();
		$UserPoints	= array();
		$TotalData	= $this->GetUsersInfosFromDB();
		$FinalSQL	= 'TRUNCATE TABLE %%STATPOINTS%%;';
		$FinalSQL	.= "INSERT INTO %%STATPOINTS%% (id_owner, id_ally, stat_type, universe, tech_old_rank, tech_points, tech_count, build_old_rank, build_points, build_count, defs_old_rank, defs_points, defs_count, fleet_old_rank, fleet_points, fleet_count, total_old_rank, total_points, total_count) VALUES ";

		foreach($TotalData['Planets'] as $PlanetData)
		{		
			if((in_array(Config::get()->stat, array(1, 2)) && $PlanetData['authlevel'] >= Config::get()->stat_level) || !empty($PlanetData['bana'])) continue;
			
 			if(!isset($UserPoints[$PlanetData['id_owner']])) {
				$UserPoints[$PlanetData['id_owner']]['build']['count'] = $UserPoints[$PlanetData['id_owner']]['build']['points'] = 0;
			}
			
			$BuildPoints = $this->calculatePoints($PlanetData, Vars::CLASS_BUILDING);

			$UserPoints[$PlanetData['id_owner']]['build']['count'] 		+= $BuildPoints['count'];
			$UserPoints[$PlanetData['id_owner']]['build']['points'] 	+= $BuildPoints['points'];
		}
		
		$UniData	= array();

		foreach($TotalData['Users'] as $UserData)
		{
			if(!isset($UniData[$UserData['universe']]))
				$UniData[$UserData['universe']] = 0;
			
			$UniData[$UserData['universe']]++;
				
			if ((in_array(Config::get()->stat, array(1, 2)) && $UserData['authlevel'] >= Config::get()->stat_level) || !empty($UserData['bana']))
			{	
				$FinalSQL  .= "(".$UserData['id'].",".$UserData['ally_id'].",1,".$UserData['universe'].",0,0,0,0,0,0,0,0,0,0,0,0,0,0,0), ";
				continue;
			}

			if(isset($TotalData['Fleets'][$UserData['id']])) {
				foreach($TotalData['Fleets'][$UserData['id']] as $ID => $Amount)
					$UserData[$resource[$ID]]	+= $Amount;
			}
			
			$TechnoPoints		= $this->calculatePoints($UserData, Vars::CLASS_TECH);
			$FleetPoints		= $this->calculatePoints($UserData, Vars::CLASS_FLEET);
			$DefensePoints		= $this->calculatePoints($UserData, Vars::CLASS_DEFENSE) + $this->calculatePoints($UserData, Vars::CLASS_MISSILE);
			
			$UserPoints[$UserData['id']]['fleet']['count'] 		= $FleetPoints['count'];
			$UserPoints[$UserData['id']]['fleet']['points'] 	= $FleetPoints['points'];
			$UserPoints[$UserData['id']]['defense']['count'] 	= $DefensePoints['count'];
			$UserPoints[$UserData['id']]['defense']['points']	= $DefensePoints['points'];
			$UserPoints[$UserData['id']]['techno']['count'] 	= $TechnoPoints['count'];
			$UserPoints[$UserData['id']]['techno']['points'] 	= $TechnoPoints['points'];
			
			$UserPoints[$UserData['id']]['total']['count'] 		= $UserPoints[$UserData['id']]['techno']['count']
																+ $UserPoints[$UserData['id']]['build']['count']
																+ $UserPoints[$UserData['id']]['defense']['count']
																+ $UserPoints[$UserData['id']]['fleet']['count'];
																
			$UserPoints[$UserData['id']]['total']['points'] 	= $UserPoints[$UserData['id']]['techno']['points']
																+ $UserPoints[$UserData['id']]['build']['points']
																+ $UserPoints[$UserData['id']]['defense']['points'] 
																+ $UserPoints[$UserData['id']]['fleet']['points'];

			if($UserData['ally_id'] != 0)
			{
				if(!isset($AllyPoints[$UserData['ally_id']]))
				{
					$AllyPoints[$UserData['ally_id']]['build']['count']		= 0;
					$AllyPoints[$UserData['ally_id']]['build']['points']	= 0;
					$AllyPoints[$UserData['ally_id']]['fleet']['count']		= 0;
					$AllyPoints[$UserData['ally_id']]['fleet']['points']	= 0;
					$AllyPoints[$UserData['ally_id']]['defense']['count']	= 0;
					$AllyPoints[$UserData['ally_id']]['defense']['points']	= 0;
					$AllyPoints[$UserData['ally_id']]['techno']['count']	= 0;
					$AllyPoints[$UserData['ally_id']]['techno']['points']	= 0;
					$AllyPoints[$UserData['ally_id']]['total']['count']		= 0;
					$AllyPoints[$UserData['ally_id']]['total']['points']	= 0;				
				}
			
				$AllyPoints[$UserData['ally_id']]['build']['count']		+= $UserPoints[$UserData['id']]['build']['count'];
				$AllyPoints[$UserData['ally_id']]['build']['points']	+= $UserPoints[$UserData['id']]['build']['points'];
				$AllyPoints[$UserData['ally_id']]['fleet']['count']		+= $UserPoints[$UserData['id']]['fleet']['count'];
				$AllyPoints[$UserData['ally_id']]['fleet']['points']	+= $UserPoints[$UserData['id']]['fleet']['points'];
				$AllyPoints[$UserData['ally_id']]['defense']['count']	+= $UserPoints[$UserData['id']]['defense']['count'];
				$AllyPoints[$UserData['ally_id']]['defense']['points']	+= $UserPoints[$UserData['id']]['defense']['points'];
				$AllyPoints[$UserData['ally_id']]['techno']['count']	+= $UserPoints[$UserData['id']]['techno']['count'];
				$AllyPoints[$UserData['ally_id']]['techno']['points']	+= $UserPoints[$UserData['id']]['techno']['points'];
				$AllyPoints[$UserData['ally_id']]['total']['count']		+= $UserPoints[$UserData['id']]['total']['count'];
				$AllyPoints[$UserData['ally_id']]['total']['points']	+= $UserPoints[$UserData['id']]['total']['points'];
			}
			
			$FinalSQL  .= "(".
			$UserData['id'].", ".
			$UserData['ally_id'].", 1, ".
			$UserData['universe'].", ".
			(isset($UserData['old_tech_rank']) ? $UserData['old_tech_rank'] : 0).", ".
			(isset($UserPoints[$UserData['id']]['techno']['points']) ? min($UserPoints[$UserData['id']]['techno']['points'], 1E50) : 0).", ".
			(isset($UserPoints[$UserData['id']]['techno']['count']) ? $UserPoints[$UserData['id']]['techno']['count'] : 0).", ".
			(isset($UserData['old_build_rank']) ? $UserData['old_build_rank'] : 0).", ".
			(isset($UserPoints[$UserData['id']]['build']['points']) ? min($UserPoints[$UserData['id']]['build']['points'], 1E50) : 0).", ".
			(isset($UserPoints[$UserData['id']]['build']['count']) ? $UserPoints[$UserData['id']]['build']['count'] : 0).", ".
			(isset($UserData['old_defs_rank']) ? $UserData['old_defs_rank'] : 0).", ".
			(isset($UserPoints[$UserData['id']]['defense']['points']) ? min($UserPoints[$UserData['id']]['defense']['points'], 1E50) : 0).", ".
			(isset($UserPoints[$UserData['id']]['defense']['count']) ? $UserPoints[$UserData['id']]['defense']['count'] : 0).", ".
			(isset($UserData['old_fleet_rank']) ? $UserData['old_fleet_rank'] : 0).", ".
			(isset($UserPoints[$UserData['id']]['fleet']['points']) ? min($UserPoints[$UserData['id']]['fleet']['points'], 1E50) : 0).", ".
			(isset($UserPoints[$UserData['id']]['fleet']['count']) ? $UserPoints[$UserData['id']]['fleet']['count'] : 0).", ".
			(isset($UserData['old_total_rank']) ? $UserData['old_total_rank'] : 0).", ".
			(isset($UserPoints[$UserData['id']]['total']['points']) ? min($UserPoints[$UserData['id']]['total']['points'], 1E50) : 0).", ".
			(isset($UserPoints[$UserData['id']]['total']['count']) ? $UserPoints[$UserData['id']]['total']['count'] : 0)."), ";
		}

		$FinalSQL	= substr($FinalSQL, 0, -2).';';
		
		$this->SaveDataIntoDB($FinalSQL);
		unset($UserPoints);
		
		if(count($AllyPoints) != 0)
		{
			$AllySQL = "INSERT INTO %%STATPOINTS%% (id_owner, id_ally, stat_type, universe, tech_old_rank, tech_points, tech_count, build_old_rank, build_points, build_count, defs_old_rank, defs_points, defs_count, fleet_old_rank, fleet_points, fleet_count, total_old_rank, total_points, total_count) VALUES ";
			foreach($TotalData['Alliance'] as $AllianceData)
			{
				$AllySQL  .= "(".
				$AllianceData['id'].", 0, 2, ".
				$AllianceData['ally_universe'].", ".
				(isset($AllyPoints['old_tech_rank']) ? $AllyPoints['old_tech_rank'] : 0).", ".
				(isset($AllyPoints[$AllianceData['id']]['techno']['points']) ? min($AllyPoints[$AllianceData['id']]['techno']['points'], 1E50) : 0).", ".
				(isset($AllyPoints[$AllianceData['id']]['techno']['count']) ? $AllyPoints[$AllianceData['id']]['techno']['count'] : 0).", ".
				(isset($AllianceData['old_build_rank']) ? $AllianceData['old_build_rank'] : 0).", ".
				(isset($AllyPoints[$AllianceData['id']]['build']['points']) ? min($AllyPoints[$AllianceData['id']]['build']['points'], 1E50) : 0).", ".
				(isset($AllyPoints[$AllianceData['id']]['build']['count']) ? $AllyPoints[$AllianceData['id']]['build']['count'] : 0).", ".
				(isset($AllianceData['old_defs_rank']) ? $AllianceData['old_defs_rank'] : 0).", ".
				(isset($AllyPoints[$AllianceData['id']]['defense']['points']) ? min($AllyPoints[$AllianceData['id']]['defense']['points'], 1E50) : 0).", ".
				(isset($AllyPoints[$AllianceData['id']]['defense']['count']) ? $AllyPoints[$AllianceData['id']]['defense']['count'] : 0).", ".
				(isset($AllianceData['old_fleet_rank']) ? $AllianceData['old_fleet_rank'] : 0).", ".
				(isset($AllyPoints[$AllianceData['id']]['fleet']['points']) ? min($AllyPoints[$AllianceData['id']]['fleet']['points'], 1E50) : 0).", ".
				(isset($AllyPoints[$AllianceData['id']]['fleet']['count']) ? $AllyPoints[$AllianceData['id']]['fleet']['count'] : 0).", ".
				(isset($AllianceData['old_total_rank']) ? $AllianceData['old_total_rank'] : 0).", ".
				(isset($AllyPoints[$AllianceData['id']]['total']['points']) ? min($AllyPoints[$AllianceData['id']]['total']['points'], 1E50) : 0).", ".
				(isset($AllyPoints[$AllianceData['id']]['total']['count']) ? $AllyPoints[$AllianceData['id']]['total']['count'] : 0)."), ";
			}
			unset($AllyPoints);
			$AllySQL	= substr($AllySQL, 0, -2).';';
			$this->SaveDataIntoDB($AllySQL);
		}

		$this->SetNewRanks();

		$this->CheckUniverseAccounts($UniData);		
		$this->writeRecordData();

		return $this->SomeStatsInfos();
	}
}
