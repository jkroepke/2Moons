<?php

/**
 *  2Moons 
 *   by Jan-Otto Kröpke 2009-2016
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan-Otto Kröpke <slaver7@gmail.com>
 * @copyright 2009 Lucky
 * @copyright 2016 Jan-Otto Kröpke <slaver7@gmail.com>
 * @licence MIT
 * @version 1.8.0
 * @link https://github.com/jkroepke/2Moons
 */

class statbuilder
{
	function __construct()
	{
		$this->starttime   	= microtime(true);
		$this->memory		= array(round(memory_get_usage() / 1024,1),round(memory_get_usage(1) / 1024,1));
		$this->time   		= TIMESTAMP;

		$this->recordData  	= array();
		$this->Unis			= array();

		$uniResult	= Database::get()->select("SELECT uni FROM %%CONFIG%% ORDER BY uni ASC;");
		foreach($uniResult as $uni)
		{
			$this->Unis[]	= $uni['uni'];
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
		$UniData	= $UniData + array_combine($this->Unis, array_fill(1, count($this->Unis), 0));
		foreach($UniData as $Uni => $Amount) {
			$config	= Config::get($Uni);
			$config->users_amount = $Amount;
			$config->save();
		}
	}
	
	private function GetUsersInfosFromDB()
	{
		global $resource, $reslist;
		$select_defenses	=	'';
		$select_buildings	=	'';
		$selected_tech		=	'';
		$select_fleets		=	'';
				
		foreach($reslist['build'] as $Building){
			$select_buildings	.= " p.".$resource[$Building].",";
		}
		
		foreach($reslist['tech'] as $Techno){
			$selected_tech		.= " u.".$resource[$Techno].",";
		}	
		
		foreach($reslist['fleet'] as $Fleet){
			$select_fleets		.= " SUM(p.".$resource[$Fleet].") as ".$resource[$Fleet].",";
		}	
		
		foreach($reslist['defense'] as $Defense){
			$select_defenses	.= " SUM(p.".$resource[$Defense].") as ".$resource[$Defense].",";
		}
		
		foreach($reslist['missile'] as $Defense){
			$select_defenses	.= " SUM(p.".$resource[$Defense].") as ".$resource[$Defense].",";
		}

		$database		= Database::get();
		$FlyingFleets	= array();
		$SQLFleets		= $database->select('SELECT fleet_array, fleet_owner FROM %%FLEETS%%;');
		foreach($SQLFleets as $CurFleets)
		{
			$FleetRec   	= explode(";", $CurFleets['fleet_array']);
			
			if(!is_array($FleetRec)) continue;
				
			foreach($FleetRec as $Group) {
				if (empty($Group)) continue;
				
				$Ship    	   = explode(",", $Group);
				if(!isset($FlyingFleets[$CurFleets['fleet_owner']][$Ship[0]]))
					$FlyingFleets[$CurFleets['fleet_owner']][$Ship[0]]	= $Ship[1];
				else
					$FlyingFleets[$CurFleets['fleet_owner']][$Ship[0]]	+= $Ship[1];
			}
		}
		
		$Return['Fleets'] 	= $FlyingFleets;		
		$Return['Planets']	= $database->select('SELECT SQL_BIG_RESULT DISTINCT '.$select_buildings.' p.id, p.universe, p.id_owner, u.authlevel, u.bana, u.username FROM %%PLANETS%% as p LEFT JOIN %%USERS%% as u ON u.id = p.id_owner;');
		$Return['Users']	= $database->select('SELECT SQL_BIG_RESULT DISTINCT '.$selected_tech.$select_fleets.$select_defenses.' u.id, u.ally_id, u.authlevel, u.bana, u.universe, u.username, s.tech_rank AS old_tech_rank, s.build_rank AS old_build_rank, s.defs_rank AS old_defs_rank, s.fleet_rank AS old_fleet_rank, s.total_rank AS old_total_rank FROM %%USERS%% as u LEFT JOIN %%STATPOINTS%% as s ON s.stat_type = 1 AND s.id_owner = u.id LEFT JOIN %%PLANETS%% as p ON u.id = p.id_owner GROUP BY s.id_owner, u.id, u.authlevel;');
		$Return['Alliance']	= $database->select('SELECT SQL_BIG_RESULT DISTINCT a.id, a.ally_universe, s.tech_rank AS old_tech_rank, s.build_rank AS old_build_rank, s.defs_rank AS old_defs_rank, s.fleet_rank AS old_fleet_rank, s.total_rank AS old_total_rank FROM %%ALLIANCE%% as a LEFT JOIN %%STATPOINTS%% as s ON s.stat_type = 2 AND s.id_owner = a.id;');
	
		return $Return;
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

	private function GetTechnoPoints($USER) 
	{
		global $resource, $reslist, $pricelist;
		$TechCounts = 0;
		$TechPoints = 0;

		foreach($reslist['tech'] as $Techno) 
		{
			if($USER[$resource[$Techno]] == 0) continue;

            // Points = (All resources / PointsPerCost) * Factor * ( 2 * ( Factor ^ Level ) - Factor) + 1)
            // PointsPerCot == Config::get()->stat_settings
			$TechCounts		+= $USER[$resource[$Techno]];
            $TechPoints     +=
                ($pricelist[$Techno]['cost'][901] + $pricelist[$Techno]['cost'][902] + $pricelist[$Techno]['cost'][903])
                * $pricelist[$Techno]['factor']
                * (
                    2 * (
                        pow($pricelist[$Techno]['factor'], $USER[$resource[$Techno]]) - $pricelist[$Techno]['factor']
                    ) + 1
                );


            $this->setRecords($USER['id'], $Techno, $USER[$resource[$Techno]]);
		}
		
		return array('count' => $TechCounts, 'points' => ($TechPoints / Config::get()->stat_settings));
	}

	private function GetBuildPoints($PLANET) 
	{
		global $resource, $reslist, $pricelist;
		$BuildCounts = 0;
		$BuildPoints = 0;
		
		foreach($reslist['build'] as $Build)
		{
			if($PLANET[$resource[$Build]] == 0) continue;

            // Points = (All resources / PointsPerCost) * Factor * ( 2 * ( Factor ^ Level ) - Factor) + 1)
            // PointsPerCot == Config::get()->stat_settings
            $BuildPoints     +=
                ($pricelist[$Build]['cost'][901] + $pricelist[$Build]['cost'][902] + $pricelist[$Build]['cost'][903])
                * $pricelist[$Build]['factor']
                * (
                    2 * (
                        pow($pricelist[$Build]['factor'], $PLANET[$resource[$Build]]) - $pricelist[$Build]['factor']
                    ) + 1
                );
			
			$BuildCounts	+= $PLANET[$resource[$Build]];
			
			$this->setRecords($PLANET['id_owner'], $Build, $PLANET[$resource[$Build]]);
		}
		return array('count' => $BuildCounts, 'points' => ($BuildPoints / Config::get()->stat_settings));
	}

	private function GetDefensePoints($USER) 
	{
		global $resource, $reslist, $pricelist;
		$DefenseCounts = 0;
		$DefensePoints = 0;
				
		foreach(array_merge($reslist['defense'], $reslist['missile']) as $Defense) {
			if($USER[$resource[$Defense]] == 0) continue;
			
			$Units			= $pricelist[$Defense]['cost'][901] + $pricelist[$Defense]['cost'][902] + $pricelist[$Defense]['cost'][903];
			$DefensePoints += $Units * $USER[$resource[$Defense]];
			$DefenseCounts += $USER[$resource[$Defense]];
		
			$this->setRecords($USER['id'], $Defense, $USER[$resource[$Defense]]);
		}
		
		return array('count' => $DefenseCounts, 'points' => ($DefensePoints / Config::get()->stat_settings));
	}

	private function GetFleetPoints($USER) 
	{
		global $resource, $reslist, $pricelist;
		$FleetCounts = 0;
		$FleetPoints = 0;
	
		foreach($reslist['fleet'] as $Fleet) {	
			if($USER[$resource[$Fleet]] == 0) continue;
			
			$Units			= $pricelist[$Fleet]['cost'][901] + $pricelist[$Fleet]['cost'][902] + $pricelist[$Fleet]['cost'][903];
			$FleetPoints   += $Units * $USER[$resource[$Fleet]];
			$FleetCounts   += $USER[$resource[$Fleet]];
			
			$this->setRecords($USER['id'], $Fleet, $USER[$resource[$Fleet]]);
		}
		
		return array('count' => $FleetCounts, 'points' => ($FleetPoints / Config::get()->stat_settings));
	}
	
	private function SetNewRanks()
	{
		foreach($this->Unis as $uni)
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

		$tableHeader = "INSERT INTO  %%STATPOINTS%% (id_owner, id_ally, stat_type, universe, tech_old_rank, tech_points, tech_count, build_old_rank, build_points, build_count, defs_old_rank, defs_points, defs_count, fleet_old_rank, fleet_points, fleet_count, total_old_rank, total_points, total_count) VALUES ";

		$FinalSQL	.= $tableHeader;

		foreach($TotalData['Planets'] as $PlanetData)
		{		
			if((in_array(Config::get()->stat, array(1, 2)) && $PlanetData['authlevel'] >= Config::get()->stat_level) || !empty($PlanetData['bana'])) continue;
			
 			if(!isset($UserPoints[$PlanetData['id_owner']])) {
				$UserPoints[$PlanetData['id_owner']]['build']['count'] = $UserPoints[$PlanetData['id_owner']]['build']['points'] = 0;
			}
			
			$BuildPoints												= $this->GetBuildPoints($PlanetData);
			$UserPoints[$PlanetData['id_owner']]['build']['count'] 		+= $BuildPoints['count'];
			$UserPoints[$PlanetData['id_owner']]['build']['points'] 	+= $BuildPoints['points'];
		}
		
		$UniData	= array();

		$i = 0;

		foreach($TotalData['Users'] as $UserData)
		{
		    $i++;
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
			
			$TechnoPoints		= $this->GetTechnoPoints($UserData);
			$FleetPoints		= $this->GetFleetPoints($UserData);
			$DefensePoints		= $this->GetDefensePoints($UserData);
			
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

			if ($i >= 50) {
                $FinalSQL = substr($FinalSQL, 0, -2).';';
                $this->SaveDataIntoDB($FinalSQL);
                $FinalSQL = $tableHeader;
			}
		}

		if (!empty($FinalSQL) && $FinalSQL != $tableHeader) {
		    $FinalSQL = substr($FinalSQL, 0, -2).';';
            $this->SaveDataIntoDB($FinalSQL);
            unset($UserPoints);
		}

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
