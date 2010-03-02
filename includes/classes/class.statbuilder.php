<?php

class statbuilder{

	function __construct()
	{
		$this->lang			= $GLOBALS['lang'];
		$this->resource		= $GLOBALS['resource'];
		$this->pricelist	= $GLOBALS['pricelist'];
		$this->reslist		= $GLOBALS['reslist'];
		$this->config		= $GLOBALS['game_config'];
		$this->db			= $GLOBALS['db'];
	
		$this->starttime   	= microtime(true);
		$this->memory		= array(round(memory_get_usage() / 1024,1),round(memory_get_usage(1) / 1024,1));
		$this->time   		= time();
	}

	private function SomeStatsInfos()
	{
		$result['stats_time']		= $this->time;
		$result['totaltime']    	= (microtime(true) - $this->starttime);
		$result['memory_peak']		= array(round(memory_get_peak_usage() / 1024,1),round(memory_get_peak_usage(1) / 1024,1));
		$result['initial_memory']	= $this->memory;
		$result['end_memory']		= array(round(memory_get_usage() / 1024,1),round(memory_get_usage(1) / 1024,1));
		return $result;
	}
	
	private function SetMaxInfo($ID, $Count, $Name)
	{
		if(!isset($this->maxinfos[$ID]))
			$this->maxinfos[$ID] = array('maxlvl' => 0, 'username' => '');

		if($this->maxinfos[$ID]['maxlvl'] < $Count)
			$this->maxinfos[$ID] = array('maxlvl' => $Count, 'username' => $Name);
	}
	
	private function AnotherCronJobs()
	{
		
	}	
	
	private function DeleteSome()
	{
		//Delete old messages
		$del_before 	= time() - (60 * 60 * 24 * 3); // 3 DAY
		$del_inactive 	= time() - (60 * 60 * 24 * 30); // 1 MONTH
		$del_deleted 	= time() - (60 * 60 * 24 * 7); // 1 WEEK
		$this->db->multi_query("DELETE FROM `".MESSAGES."` WHERE `message_time` < '". $del_before ."';DELETE FROM `".RW."` WHERE `time` < '". $del_before ."';DELETE FROM ".SUPP." WHERE `time` < '".$del_before."' AND `status` = 0;DELETE FROM ".CHAT." WHERE `timestamp` < '".$del_before."';DELETE FROM ".ALLIANCE." WHERE `ally_members` = '0';");
		
		$ChooseToDelete = $this->db->query("SELECT `id` FROM `".USERS."` WHERE ((`db_deaktjava` < '".$del_deleted."' AND `db_deaktjava` <> 0) OR `onlinetime` < '".$del_inactive."') AND `authlevel` = '0';");
		
		if($ChooseToDelete)
		{
			include_once(ROOT_PATH.'includes/functions/DeleteSelectedUser.'.PHP_EXT);
			while($delete = $this->db->fetch_array($ChooseToDelete))
			{
				DeleteSelectedUser($delete['id']);
			}
		}
	
	}

	private function RebuildRecordCache() 
	{
		$array		= "";
		foreach(array_merge($this->reslist['build'], $this->reslist['tech'], $this->reslist['fleet'], $this->reslist['defense']) as $ElementID) {
			$array	.= $ElementID." => array('username' => '".$this->maxinfos[$ElementID]['username']."', 'maxlvl' => '".$this->maxinfos[$ElementID]['maxlvl']."'),\n";
		}
		$file	= "<?php \n//The File is created on ".date("d. M y H:i:s", time())."\n$"."RecordsArray = array(\n".$array."\n);\n?>";
		file_put_contents(ROOT_PATH."cache/CacheRecords.php", $file);
	}
	
	private function GetUsersInfosFromDB()
	{
		$select_defenses	=	'';
		$select_buildings	=	'';
		$selected_tech		=	'';
		$select_fleets		=	'';
		
		foreach($this->reslist['defense'] as $Defense){
			$select_defenses	.= " p.".$this->resource[$Defense].",";
		}
				
		foreach($this->reslist['build'] as $Building){
			$select_buildings	.= " p.".$this->resource[$Building].",";
		}
		
		foreach($this->reslist['tech'] as $Techno){
			$selected_tech	.= " u.".$this->resource[$Techno].",";
		}	
		
		foreach($this->reslist['fleet'] as $Fleet){
			$select_fleets	.= " p.".$this->resource[$Fleet].",";
		}		

		$SQLFleets	=  $this->db->query('SELECT fleet_array, fleet_owner, fleet_id FROM '.FLEETS.';');
		while ($CurFleets = $this->db->fetch($SQLFleets))
		{
			$FlyingFleets[$CurFleets['fleet_owner']][$CurFleets['fleet_id']]	= $CurFleets['fleet_array'];
		}
		
		$Return['Fleets'] 	= $FlyingFleets;		
		$Return['Planets']	= $this->db->query('SELECT '.$select_defenses.$select_fleets.$select_buildings.' p.id_owner, u.authlevel, u.bana, u.id, u.username FROM '.PLANETS.' as p LEFT JOIN '.USERS.' as u ON u.id = p.id_owner;');
		$Return['Users']	= $this->db->query('SELECT '.$selected_tech.' u.id, u.ally_id, u.authlevel, u.bana, u.username, s.tech_rank AS old_tech_rank, s.build_rank AS old_build_rank, s.defs_rank AS old_defs_rank, s.fleet_rank AS old_fleet_rank, s.total_rank AS old_total_rank FROM '.USERS.' as u LEFT JOIN '.STATPOINTS.' as s ON s.stat_type = 1 AND s.stat_code = 1 AND s.id_owner = u.id GROUP BY s.id_owner, u.id, u.authlevel;');
		$Return['Alliance']	= $this->db->query('SELECT a.id, s.tech_rank AS old_tech_rank, s.build_rank AS old_build_rank, s.defs_rank AS old_defs_rank, s.fleet_rank AS old_fleet_rank, s.total_rank AS old_total_rank FROM '.ALLIANCE.' as a LEFT JOIN '.STATPOINTS.' as s ON s.stat_type = 2 AND s.stat_code = 1 AND s.id_owner = a.id;');
		
		update_config('users_amount', $this->db->num_rows($Return['Users']));
		
		return $Return;
	}
	
	private function SaveDataIntoDB($Data)
	{
		$this->db->multi_query($Data);
	}

	private function GetTechnoPoints($CurrentUser) 
	{
		$TechCounts = 0;
		$TechPoints = 0;

		foreach($this->reslist['tech'] as $Techno) 
		{
			if($CurrentUser[$this->resource[$Techno]] == 0) continue;

			$this->SetMaxInfo($Techno, $CurrentUser[$this->resource[$Techno]], $CurrentUser['username']);
			
			$Units	= ($this->pricelist[$Techno]['metal'] + $this->pricelist[$Techno]['crystal'] + $this->pricelist[$Techno]['deuterium']);
			for($Level = 1; $Level < $CurrentUser[$this->resource[$Techno]]; $Level++)
			{
				$TechPoints	+= $Units * pow($this->pricelist[$Techno]['factor'], $Level);
				$TechCounts	+= $CurrentUser[$this->resource[$Techno]];
			}
		}
		$RetValue['count'] = $TechCounts;
		$RetValue['points'] = $TechPoints / $this->config['stat_settings'];

		return $RetValue;
	}

	private function GetBuildPoints($CurrentPlanet) 
	{
		$BuildCounts = 0;
		$BuildPoints = 0;
		reset($this->reslist['build']);
		
		foreach($this->reslist['build'] as $Build)
		{
			if($CurrentPlanet[$this->resource[$Build]] == 0) continue;

			$this->SetMaxInfo($Build, $CurrentPlanet[$this->resource[$Build]], $CurrentPlanet['username']);
			
			$Units			 = $this->pricelist[$Build]['metal'] + $this->pricelist[$Build]['crystal'] + $this->pricelist[$Build]['deuterium'];
			for($Level = 1; $Level < $CurrentPlanet[$this->resource[$Build]]; $Level++)
			{
				$BuildPoints	+= $Units * pow($this->pricelist[$Build]['factor'], $Level);
				$BuildCounts	+= $CurrentPlanet[$this->resource[$Build]];
			}
		}
		$RetValue['count'] = $BuildCounts;
		$RetValue['points'] = $BuildPoints / $this->config['stat_settings'];
		return $RetValue;
	}

	private function GetDefensePoints($CurrentPlanet) 
	{
		$DefenseCounts = 0;
		$DefensePoints = 0;
				
		foreach($this->reslist['defense'] as $Defense) {
			$this->SetMaxInfo($Defense, $CurrentPlanet[$this->resource[$Defense]], $CurrentPlanet['username']);
			
			$Units			= $this->pricelist[$Defense]['metal'] + $this->pricelist[$Defense]['crystal'] + $this->pricelist[$Defense]['deuterium'];
			$DefensePoints += $Units * $CurrentPlanet[$this->resource[$Defense]];
			$DefenseCounts += $CurrentPlanet[$this->resource[$Defense]];
		}
		
		$RetValue['count'] = $DefenseCounts;
		$RetValue['points'] = $DefensePoints / $this->config['stat_settings'];
		return $RetValue;
	}

	private function GetFleetPoints($CurrentPlanet) 
	{
		$FleetCounts = 0;
		$FleetPoints = 0;
	
		foreach($this->reslist['fleet'] as $Fleet) {
		
			$this->SetMaxInfo($Fleet, $CurrentPlanet[$this->resource[$Fleet]], $CurrentPlanet['username']);
			
			$Units			= $this->pricelist[$Fleet]['metal'] + $this->pricelist[$Fleet]['crystal'] + $this->pricelist[$Fleet]['deuterium'];
			$FleetPoints   += $Units * $CurrentPlanet[$this->resource[$Fleet]];
			$FleetCounts   += $CurrentPlanet[$this->resource[$Fleet]];
		}
		$RetValue['count'] = $FleetCounts;
		$RetValue['points'] = $FleetPoints / $this->config['stat_settings'];

		return $RetValue;
	}

	private function GetFlyingFleetPoints($FleetArray) 
	{
		$FleetRec   	= explode(";", $FleetArray);
		$FleetCounts	= 0;
		$FleetPoints	= 0;
		
		if(!is_array($FleetRec))
		{
			$RetValue['count'] 	= 0;
			$RetValue['points'] = 0;
			return $RetValue;
			
		}
		
		foreach($FleetRec as $Item => $Group)
		{
			if (empty($Group)) continue;
			
			$Ship    	   = explode(",", $Group);
			$Units         = $this->pricelist[$Ship[0]]['metal'] + $this->pricelist[$Ship[0]]['crystal'] + $this->pricelist[$Ship[0]]['deuterium'];
			$FleetPoints   += $Units * $Ship[1];
			$FleetCounts   += $Ship[1];
		}
		
		
		$RetValue['count'] 	= $FleetCounts;
		$RetValue['points'] = $FleetPoints / $this->config['stat_settings'];
		return $RetValue;
	}

	private function removeE($Numeric)
	{
		return number_format($Numeric, 0, '', '');
	}
	
	private function SetNewRanks()
	{
		$QryUpdateStats = "";
		for ($StatType = 1; $i <= 2; $i++) 
		{
			$Rank           = 1;
			$RankQry        = $this->db->query("SELECT `id_owner` FROM ".STATPOINTS." WHERE `stat_type` = '".$StatType."' AND `stat_code` = '1' ORDER BY `tech_points` DESC;", 'statpoints');
			while ($CurUser = $this->db->fetch($RankQry) )
			{
				$tech[$CurUser['id_owner']]	=	$Rank;
				$Rank++;
			}
			unset($Rank,$RankQry,$QryUpdateStats,$CurUser);
			$Rank           = 1;
			$RankQry        = $this->db->query("SELECT `id_owner` FROM ".STATPOINTS." WHERE `stat_type` = '".$StatType."' AND `stat_code` = '1' ORDER BY `build_points` DESC;", 'statpoints');
			while ($CurUser = $this->db->fetch($RankQry) )
			{
				$build[$CurUser['id_owner']]	=	$Rank;
				$Rank++;
			}
			unset($Rank,$RankQry,$QryUpdateStats,$CurUser);
			$Rank           = 1;
			$RankQry        = $this->db->query("SELECT `id_owner` FROM ".STATPOINTS." WHERE `stat_type` = '".$StatType."' AND `stat_code` = '1' ORDER BY `defs_points` DESC;", 'statpoints');
			while ($CurUser = $this->db->fetch($RankQry) )
			{
				$defs[$CurUser['id_owner']]	=	$Rank;
				$Rank++;
			}
			unset($Rank,$RankQry,$QryUpdateStats,$CurUser);
			$Rank           = 1;
			$RankQry        = $this->db->query("SELECT `id_owner` FROM ".STATPOINTS." WHERE `stat_type` = '".$StatType."' AND `stat_code` = '1' ORDER BY `fleet_points` DESC;", 'statpoints');
			while ($CurUser = $this->db->fetch($RankQry) )
			{
				$fleet[$CurUser['id_owner']]	=	$Rank;
				$Rank++;
			}
			unset($Rank,$RankQry,$QryUpdateStats,$CurUser);
			$Rank           = 1;
			$RankQry        = $this->db->query("SELECT `id_owner` FROM ".STATPOINTS." WHERE `stat_type` = '".$StatType."' AND `stat_code` = '1' ORDER BY `total_points` DESC;", 'statpoints');
			
			
			while($CurUser = $this->db->fetch_array($RankQry))
			{
				$QryUpdateStats .= "UPDATE ".STATPOINTS." SET `tech_rank` = '". $tech[$CurUser['id_owner']] ."', `build_rank` = '". $build[$CurUser['id_owner']] ."', `defs_rank` = '". $defs[$CurUser['id_owner']] ."', `fleet_rank` = '". $fleet[$CurUser['id_owner']] ."', `total_rank` = '". $Rank ."' WHERE  `stat_type` = '".$StatType."' AND `stat_code` = '1' AND `id_owner` = '". $CurUser['id_owner'] ."';";
				$Rank++;
			}
		}
		return $QryUpdateStats;
	}
	
	final public function MakeStats()
	{
		$this->DeleteSome();
		
		$TotalData	= $this->GetUsersInfosFromDB();
		$FinalSQL	= 'TRUNCATE TABLE '.STATPOINTS.';';
		$FinalSQL	.= "INSERT INTO ".STATPOINTS." (`id_owner`, `id_ally`, `stat_type`, `stat_code`, `tech_old_rank`, `tech_points`, `tech_count`, `build_old_rank`, `build_points`, `build_count`, `defs_old_rank`, `defs_points`, `defs_count`, `fleet_old_rank`, `fleet_points`, `fleet_count`, `total_old_rank`, `total_points`, `total_count`, `stat_date`) VALUES ";
		
		while($PlanetData = $this->db->fetch_array($TotalData['Planets']))
		{		
			if (($PlanetData['authlevel'] >= $this->config['stat_level'] && $this->config['stat'] == 1) || !empty($PlanetData['bana'])) continue;
			
 			if(!isset($UserPoints[$PlanetData['id_owner']]['build']['count']))
				$UserPoints[$PlanetData['id_owner']]['build']['count'] = 0;
			if(!isset($UserPoints[$PlanetData['id_owner']]['build']['points']))
				$UserPoints[$PlanetData['id_owner']]['build']['points'] = 0;			
			if(!isset($UserPoints[$PlanetData['id_owner']]['fleet']['count']))
				$UserPoints[$PlanetData['id_owner']]['fleet']['count'] = 0;
			if(!isset($UserPoints[$PlanetData['id_owner']]['fleet']['points']))
				$UserPoints[$PlanetData['id_owner']]['fleet']['points'] = 0;
			if(!isset($UserPoints[$PlanetData['id_owner']]['defense']['count']))
				$UserPoints[$PlanetData['id_owner']]['defense']['count'] = 0;
			if(!isset($UserPoints[$PlanetData['id_owner']]['defense']['points']))
				$UserPoints[$PlanetData['id_owner']]['defense']['points'] = 0;
				
			$BuildPoints		= $this->GetBuildPoints($PlanetData);
			$FleetPoints		= $this->GetFleetPoints($PlanetData);
			$DefensePoints		= $this->GetDefensePoints($PlanetData);

			$UserPoints[$PlanetData['id_owner']]['build']['count'] 		+= $BuildPoints['count'];
			$UserPoints[$PlanetData['id_owner']]['build']['points'] 	+= $BuildPoints['points'];
			$UserPoints[$PlanetData['id_owner']]['fleet']['count'] 		+= $FleetPoints['count'];
			$UserPoints[$PlanetData['id_owner']]['fleet']['points'] 	+= $FleetPoints['points'];
			$UserPoints[$PlanetData['id_owner']]['defense']['count'] 	+= $DefensePoints['count'];
			$UserPoints[$PlanetData['id_owner']]['defense']['points']	+= $DefensePoints['points'];
		}
		
		while($UserData	= $this->db->fetch_array($TotalData['Users']))
		{
			if (($UserData['authlevel'] >= $this->config['stat_level'] && $this->config['stat'] == 1) || !empty($UserData['bana']))
			{
				$FinalSQL  .= '('.$UserData['id'].','.$UserData['ally_id'].',1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'.$this->time.'),';
				continue;
			}
			
			$TechnoPoints			= $this->GetTechnoPoints($UserData);
			
			$UserPoints[$UserData['id']]['techno']['count'] 	= $TechnoPoints['count'];
			$UserPoints[$UserData['id']]['techno']['points'] 	= $TechnoPoints['points'];

			if(isset($TotalData['Fleets'][$UserData['id']]))
			{
				foreach($TotalData['Fleets'][$UserData['id']] as $FleetArray)
				{
					$FlyingFleetPoints									= $this->GetFlyingFleetPoints($FleetArray);
					$UserPoints[$UserData['id']]['fleet']['count'] 		+= $FlyingFleetPoints['count'];
					$UserPoints[$UserData['id']]['fleet']['points'] 	+= $FlyingFleetPoints['points'];
				}
			}
			
			$UserPoints[$UserData['id']]['total']['count'] 	= $UserPoints[$UserData['id']]['techno']['count'] + $UserPoints[$UserData['id']]['build']['count'] + $UserPoints[$UserData['id']]['defense']['count'] + $UserPoints[$UserData['id']]['fleet']['count'];
			$UserPoints[$UserData['id']]['total']['points'] = $UserPoints[$UserData['id']]['techno']['points'] + $UserPoints[$UserData['id']]['build']['points'] + $UserPoints[$UserData['id']]['defense']['points'] + $UserPoints[$UserData['id']]['fleet']['points'];

			if($UserData['ally_id'] != 0)
			{
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
			
			$FinalSQL  .= "('".$UserData['id']."','".$UserData['ally_id']."',1,1,'".$UserData['old_tech_rank']."', '".$this->removeE($UserPoints[$UserData['id']]['techno']['points'])."', '".$this->removeE($UserPoints[$UserData['id']]['techno']['count'])."', '".$UserData['old_build_rank']."','".$this->removeE($UserPoints[$UserData['id']]['build']['points'])."', '".$this->removeE($UserPoints[$UserData['id']]['build']['count'])."', '".$UserData['old_defs_rank']."', '".$this->removeE($UserPoints[$UserData['id']]['defense']['points'])."', '".$this->removeE($UserPoints[$UserData['id']]['defense']['count'])."', '".$UserData['old_fleet_rank']."', '".$this->removeE($UserPoints[$UserData['id']]['fleet']['points'])."', '".$this->removeE($UserPoints[$UserData['id']]['fleet']['count'])."', '".$UserData['old_total_rank']."', '".$this->removeE($UserPoints[$UserData['id']]['total']['points'])."', '".$this->removeE($UserPoints[$UserData['id']]['total']['count'])."', '".$this->time."'), ";
		}
		
		while($AllianceData	= $this->db->fetch_array($TotalData['Alliance']))
		{
			$FinalSQL  .= "('".$AllianceData['id']."',0,2,1, '".$AllyPoints['old_tech_rank']."', '".$this->removeE($AllyPoints[$AllianceData['id']]['techno']['points'])."', '".$this->removeE($AllyPoints[$AllianceData['id']]['techno']['count'])."', '".$AllianceData['old_build_rank']."', '".$this->removeE($AllyPoints[$AllianceData['id']]['build']['points'])."', '".$this->removeE($AllyPoints[$AllianceData['id']]['build']['count'])."', '".$AllianceData['old_defs_rank']."', '".$this->removeE($AllyPoints[$AllianceData['id']]['defense']['points'])."', '".$this->removeE($AllyPoints[$AllianceData['id']]['defense']['count'])."', '".$AllianceData['old_fleet_rank']."', '".$this->removeE($AllyPoints[$AllianceData['id']]['fleet']['points'])."', '".$this->removeE($AllyPoints[$AllianceData['id']]['fleet']['count'])."', '".$AllianceData['old_total_rank']."', '".$this->removeE($AllyPoints[$AllianceData['id']]['total']['points'])."', '".$this->removeE($AllyPoints[$AllianceData['id']]['total']['count'])."', '".$this->time."'), ";
		}
		$FinalSQL	= substr($FinalSQL, 0, -2).';';
		$this->SaveDataIntoDB($FinalSQL);
		
		$RankSQL	= $this->SetNewRanks();
		$this->SaveDataIntoDB($RankSQL);
		
		$this->RebuildRecordCache();
		
		$this->AnotherCronJobs();
		
		return $this->SomeStatsInfos();
	}
}
?>