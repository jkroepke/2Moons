<?php

class statbuilder{

	function __construct()
	{
		$this->starttime   	= microtime(true);
		$this->memory		= array(round(memory_get_usage() / 1024,1),round(memory_get_usage(1) / 1024,1));
		$this->time   		= TIMESTAMP;
	}

	private function SomeStatsInfos()
	{
		global $db;
		$result['stats_time']		= $this->time;
		$result['totaltime']    	= round(microtime(true) - $this->starttime, 7);
		$result['memory_peak']		= array(round(memory_get_peak_usage() / 1024,1),round(memory_get_peak_usage(1) / 1024,1));
		$result['initial_memory']	= $this->memory;
		$result['end_memory']		= array(round(memory_get_usage() / 1024,1),round(memory_get_usage(1) / 1024,1));
		$result['sql_count']		= $db->get_sql();
		return $result;
	}
	
	private function SetMaxInfo($ID, $Count, $Name)
	{
		if(!isset($this->maxinfos[$ID]))
			$this->maxinfos[$ID] = array('maxlvl' => 0, 'username' => array());
		
		if($Count == 0)
			return false;
		
		if($this->maxinfos[$ID]['maxlvl'] < $Count)
			$this->maxinfos[$ID] = array('maxlvl' => $Count, 'username' => array($Name));
		elseif($this->maxinfos[$ID]['maxlvl'] == $Count)
			$this->maxinfos[$ID]['username']	= array_merge($this->maxinfos[$ID]['username'], array($Name));
	}
	
	private function AnotherCronJobs()
	{
		
	}	
	
	private function DeleteSome()
	{
		global $db;

		$db->query("LOCK TABLES ".ALLIANCE." WRITE, ".BUDDY." WRITE, ".CHAT." WRITE, ".CONFIG." WRITE, ".FLEETS." WRITE, ".NOTES." WRITE, ".MESSAGES." WRITE, ".PLANETS." WRITE, ".RW." WRITE, ".SESSION." WRITE,  ".SUPP." WRITE, ".STATPOINTS." WRITE, ".TOPKB." WRITE, ".USERS." WRITE;");
	
		//Delete old messages
		$del_before 	= strtotime("-3 day");
		$del_inactive 	= strtotime("-30 day");
		$del_deleted 	= strtotime("-7 day");
		
		$db->multi_query("DELETE FROM `".MESSAGES."` WHERE `message_time` < '". $del_before ."';DELETE FROM ".SUPP." WHERE `time` < '".$del_before."' AND `status` = 0;DELETE FROM ".CHAT." WHERE `timestamp` < '".$del_before."';DELETE FROM ".ALLIANCE." WHERE `ally_members` = '0';DELETE FROM ".PLANETS." WHERE `destruyed` < ".TIMESTAMP." AND `destruyed` != 0;UPDATE ".USERS." SET `email_2` = `email` WHERE `setmail` < '".TIMESTAMP."';DELETE FROM ".SESSION." WHERE `user_lastactivity` < '".(TIMESTAMP - SESSION_LIFETIME)."';");

		$ChooseToDelete = $db->query("SELECT `id` FROM `".USERS."` WHERE `authlevel` = '0' AND ((`db_deaktjava` != 0 AND `db_deaktjava` < '".$del_deleted."') OR `onlinetime` < '".$del_inactive."');");
		
		if(isset($ChooseToDelete))
		{
			include_once(ROOT_PATH.'includes/functions/DeleteSelectedUser.'.PHP_EXT);
			while($delete = $db->fetch_array($ChooseToDelete))
			{
				DeleteSelectedUser($delete['id']);
			}	
		}
		
		$db->free_result($ChooseToDelete);

		$DelRW	= $db->query("SELECT `rid` FROM ".RW." WHERE `time` < '". $del_before ."';");
		
		if(isset($DelRW))
		{
			while($RID = $db->fetch_array($DelRW))
			{
				@unlink(ROOT_PATH.'raports/raport_'.$RID['rid'].'.php');
			}	
			$db->query("DELETE FROM ".RW." WHERE `time` < '". $del_before ."';");
		}
		$db->free_result($DelRW);
		
		$TopKBLow		= $db->uniquequery("SELECT gesamtunits FROM ".TOPKB." ORDER BY gesamtunits DESC LIMIT 99,1");
	
		$TKBRW			= $db->query("SELECT `rid` FROM ".TOPKB." WHERE `gesamtunits` < '".((isset($TopKBLow)) ? $TopKBLow['gesamtunits'] : 0)."';");
		
		if(isset($TKBRW))
		{
			while($RID = $db->fetch_array($TKBRW))
			{
				@unlink(ROOT_PATH.'raports/topkb_'.$RID['rid'].'.php');
			}	
			$db->query("DELETE FROM ".TOPKB." WHERE `gesamtunits` < '".((isset($TopKBLow)) ? $TopKBLow['gesamtunits'] : 0)."';");
		}
		
		$db->free_result($TKBRW);
		
		$db->query("UNLOCK TABLES;");
	}

	private function RebuildRecordCache() 
	{
		global $reslist;
		$array	= "";
		foreach(array_merge($reslist['build'], $reslist['tech'], $reslist['fleet'], $reslist['defense']) as $ElementID) {
			$array	.= $ElementID." => array('username' => array('".implode("', '", array_unique($this->maxinfos[$ElementID]['username']))."'), 'maxlvl' => '".$this->maxinfos[$ElementID]['maxlvl']."'),\n";
		}
		$file	= "<?php \n//The File is created on ".date("d. M y H:i:s", TIMESTAMP)."\n$"."RecordsArray = array(\n".$array."\n);\n?>";
		file_put_contents(ROOT_PATH."cache/CacheRecords.php", $file);
	}
	
	private function GetUsersInfosFromDB()
	{
		global $db, $resource, $reslist;
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
			$select_fleets		.= " p.".$resource[$Fleet].",";
		}	
		
		foreach($reslist['defense'] as $Defense){
			$select_defenses	.= " p.".$resource[$Defense].",";
		}	

		$SQLFleets	=  $db->query('SELECT fleet_array, fleet_owner FROM '.FLEETS.';');
		while ($CurFleets = $db->fetch_array($SQLFleets))
		{
			$FlyingFleets[$CurFleets['fleet_owner']][]	= $CurFleets['fleet_array'];
		}
		
		$db->free_result($SQLFleets);
		
		$Return['Fleets'] 	= $FlyingFleets;		
		$Return['Planets']	= $db->query('SELECT SQL_BIG_RESULT DISTINCT '.$select_buildings.$select_fleets.$select_defenses.'p.id, p.id_owner, u.authlevel, u.bana, u.username FROM '.PLANETS.' as p LEFT JOIN '.USERS.' as u ON u.id = p.id_owner;');
		$Return['Users']	= $db->query('SELECT SQL_BIG_RESULT DISTINCT '.$selected_tech.' u.id, u.ally_id, u.authlevel, u.bana, u.username, s.tech_rank AS old_tech_rank, s.build_rank AS old_build_rank, s.defs_rank AS old_defs_rank, s.fleet_rank AS old_fleet_rank, s.total_rank AS old_total_rank FROM '.USERS.' as u LEFT JOIN '.STATPOINTS.' as s ON s.stat_type = 1 AND s.stat_code = 1 AND s.id_owner = u.id GROUP BY s.id_owner, u.id, u.authlevel;');
		$Return['Alliance']	= $db->query('SELECT SQL_BIG_RESULT DISTINCT a.id, s.tech_rank AS old_tech_rank, s.build_rank AS old_build_rank, s.defs_rank AS old_defs_rank, s.fleet_rank AS old_fleet_rank, s.total_rank AS old_total_rank FROM '.ALLIANCE.' as a LEFT JOIN '.STATPOINTS.' as s ON s.stat_type = 2 AND s.stat_code = 1 AND s.id_owner = a.id;');
		update_config('users_amount', $db->num_rows($Return['Users']));
		
		return $Return;
	}
	
	private function SaveDataIntoDB($Data)
	{
		global $db;
		if(!empty($Data))
			$db->multi_query($Data);
	}

	private function GetTechnoPoints($CurrentUser) 
	{
		global $resource, $reslist, $pricelist, $CONF;
		$TechCounts = 0;
		$TechPoints = 0;

		foreach($reslist['tech'] as $Techno) 
		{
			if($CurrentUser[$resource[$Techno]] == 0) continue;

			$this->SetMaxInfo($Techno, $CurrentUser[$resource[$Techno]], $CurrentUser['username']);
			
			$Units	= $pricelist[$Techno]['metal'] + $pricelist[$Techno]['crystal'] + $pricelist[$Techno]['deuterium'];
			for($Level = 1; $Level <= $CurrentUser[$resource[$Techno]]; $Level++)
			{
				$TechPoints	+= $Units * pow($pricelist[$Techno]['factor'], $Level);
			}
			$TechCounts		+= $CurrentUser[$resource[$Techno]];
		}
		
		return array('count' => $TechCounts, 'points' => ($TechPoints / $CONF['stat_settings']));
	}

	private function GetBuildPoints($CurrentPlanet) 
	{
		global $resource, $reslist, $pricelist, $CONF;
		$BuildCounts = 0;
		$BuildPoints = 0;
		
		foreach($reslist['build'] as $Build)
		{
			if($CurrentPlanet[$resource[$Build]] == 0) continue;

			$this->SetMaxInfo($Build, $CurrentPlanet[$resource[$Build]], $CurrentPlanet['username']);
			
			$Units			 = $pricelist[$Build]['metal'] + $pricelist[$Build]['crystal'] + $pricelist[$Build]['deuterium'];
			for($Level = 1; $Level <= $CurrentPlanet[$resource[$Build]]; $Level++)
			{
				$BuildPoints	+= $Units * pow($pricelist[$Build]['factor'], $Level);
			}
			$BuildCounts	+= $CurrentPlanet[$resource[$Build]];
		}
		return array('count' => $BuildCounts, 'points' => ($BuildPoints / $CONF['stat_settings']));
	}

	private function GetDefensePoints($CurrentPlanet) 
	{
		global $resource, $reslist, $pricelist, $CONF;
		$DefenseCounts = 0;
		$DefensePoints = 0;
				
		foreach($reslist['defense'] as $Defense) {
			$this->SetMaxInfo($Defense, $CurrentPlanet[$resource[$Defense]], $CurrentPlanet['username']);
			
			$Units			= $pricelist[$Defense]['metal'] + $pricelist[$Defense]['crystal'] + $pricelist[$Defense]['deuterium'];
			$DefensePoints += $Units * $CurrentPlanet[$resource[$Defense]];
			$DefenseCounts += $CurrentPlanet[$resource[$Defense]];
		}
		
		return array('count' => $DefenseCounts, 'points' => ($DefensePoints / $CONF['stat_settings']));
	}

	private function GetFleetPoints($CurrentPlanet) 
	{
		global $resource, $reslist, $pricelist, $CONF;
		$FleetCounts = 0;
		$FleetPoints = 0;
	
		foreach($reslist['fleet'] as $Fleet) {
		
			$this->SetMaxInfo($Fleet, $CurrentPlanet[$resource[$Fleet]], $CurrentPlanet['username']);
			
			$Units			= $pricelist[$Fleet]['metal'] + $pricelist[$Fleet]['crystal'] + $pricelist[$Fleet]['deuterium'];
			$FleetPoints   += $Units * $CurrentPlanet[$resource[$Fleet]];
			$FleetCounts   += $CurrentPlanet[$resource[$Fleet]];
		}
		
		return array('count' => $FleetCounts, 'points' => ($FleetPoints / $CONF['stat_settings']));
	}

	private function GetFlyingFleetPoints($FleetArray) 
	{
		global $resource, $reslist, $pricelist, $CONF;
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
			$Units         = $pricelist[$Ship[0]]['metal'] + $pricelist[$Ship[0]]['crystal'] + $pricelist[$Ship[0]]['deuterium'];
			$FleetPoints   += $Units * $Ship[1];
			$FleetCounts   += $Ship[1];
		}
		
		return array('count' => $FleetCounts, 'points' => ($FleetPoints / $CONF['stat_settings']));
	}
	
	private function SetNewRanks()
	{
		global $db, $CONF;
		$QryUpdateStats = "";
		
		$Rank           = 1;
		$RankQry        = $db->query("SELECT s.`id_owner` FROM ".STATPOINTS." as s, ".USERS." as u WHERE s.`stat_type` = '1' AND s.`id_owner` = `u`.id ".(($CONF['stat'] == 2)?'AND u.`authlevel` < '.$CONF['stat_level'].' ':'')." ORDER BY `tech_points` DESC;");
		while ($CurUser = $db->fetch_array($RankQry))
		{
			$tech[$CurUser['id_owner']]	= $Rank;
			$Rank++;
		}

		$db->free_result($RankQry);

		$Rank           = 1;
		$RankQry        = $db->query("SELECT s.`id_owner` FROM ".STATPOINTS." as s, ".USERS." as u WHERE s.`stat_type` = '1' AND s.`id_owner` = `u`.id ".(($CONF['stat'] == 2)?'AND u.`authlevel` < '.$CONF['stat_level'].' ':'')." ORDER BY `build_points` DESC;");
		while ($CurUser = $db->fetch_array($RankQry))
		{
			$build[$CurUser['id_owner']] = $Rank;
			$Rank++;
		}

		$db->free_result($RankQry);
			
		$Rank           = 1;
		$RankQry        = $db->query("SELECT s.`id_owner` FROM ".STATPOINTS." as s, ".USERS." as u WHERE s.`stat_type` = '1' AND s.`id_owner` = `u`.id ".(($CONF['stat'] == 2)?'AND u.`authlevel` < '.$CONF['stat_level'].' ':'')." ORDER BY `defs_points` DESC;");
		while ($CurUser = $db->fetch_array($RankQry))
		{
			$defs[$CurUser['id_owner']]	= $Rank;
			$Rank++;
		}

		$db->free_result($RankQry);
			
		$Rank           = 1;
		$RankQry        = $db->query("SELECT s.`id_owner` FROM ".STATPOINTS." as s, ".USERS." as u WHERE s.`stat_type` = '1' AND s.`id_owner` = `u`.id ".(($CONF['stat'] == 2)?'AND u.`authlevel` < '.$CONF['stat_level'].' ':'')." ORDER BY `fleet_points` DESC;");
		while ($CurUser = $db->fetch_array($RankQry))
		{
			$fleet[$CurUser['id_owner']] = $Rank;
			$Rank++;
		}

		$db->free_result($RankQry);
			
		$Rank           = 1;
		$RankQry        = $db->query("SELECT s.`id_owner` FROM ".STATPOINTS." as s, ".USERS." as u WHERE s.`stat_type` = '1' AND s.`id_owner` = `u`.id ".(($CONF['stat'] == 2)?'AND u.`authlevel` < '.$CONF['stat_level'].' ':'')." ORDER BY `total_points` DESC;");

		while($CurUser = $db->fetch_array($RankQry))
		{
			$QryUpdateStats .= "UPDATE ".STATPOINTS." SET `tech_rank` = '". $tech[$CurUser['id_owner']] ."', `build_rank` = '". $build[$CurUser['id_owner']] ."', `defs_rank` = '". $defs[$CurUser['id_owner']] ."', `fleet_rank` = '". $fleet[$CurUser['id_owner']] ."', `total_rank` = '". $Rank ."' WHERE  `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $CurUser['id_owner'] ."';";
			$Rank++;
		}

		$db->free_result($RankQry);
			
			
		$Rank           = 1;
		$RankQry        = $db->query("SELECT s.`id_owner` FROM ".STATPOINTS." as s WHERE s.`stat_type` = '2' ORDER BY `tech_points` DESC;");
		while ($CurUser = $db->fetch_array($RankQry))
		{
			$tech[$CurUser['id_owner']]	= $Rank;
			$Rank++;
		}
	
		$db->free_result($RankQry);
		
		$Rank           = 1;
		$RankQry        = $db->query("SELECT s.`id_owner` FROM ".STATPOINTS." as s WHERE s.`stat_type` = '2' ORDER BY `build_points` DESC;");
		while ($CurUser = $db->fetch_array($RankQry))
		{
			$build[$CurUser['id_owner']] = $Rank;
			$Rank++;
		}

		$db->free_result($RankQry);
			
		$Rank           = 1;
		$RankQry        = $db->query("SELECT s.`id_owner` FROM ".STATPOINTS." as s WHERE s.`stat_type` = '2' ORDER BY `defs_points` DESC;");
		while ($CurUser = $db->fetch_array($RankQry))
		{
			$defs[$CurUser['id_owner']]	= $Rank;
			$Rank++;
		}

		$db->free_result($RankQry);
		
		$Rank           = 1;
		$RankQry        = $db->query("SELECT s.`id_owner` FROM ".STATPOINTS." as s WHERE s.`stat_type` = '2' ORDER BY `fleet_points` DESC;");
		while ($CurUser = $db->fetch_array($RankQry))
		{
			$fleet[$CurUser['id_owner']] = $Rank;
			$Rank++;
		}

		$db->free_result($RankQry);
			
		$Rank           = 1;
		$RankQry        = $db->query("SELECT s.`id_owner` FROM ".STATPOINTS." as s WHERE s.`stat_type` = '2' ORDER BY `total_points` DESC;");

		while($CurUser = $db->fetch_array($RankQry))
		{
			$QryUpdateStats .= "UPDATE ".STATPOINTS." SET `tech_rank` = '". $tech[$CurUser['id_owner']] ."', `build_rank` = '". $build[$CurUser['id_owner']] ."', `defs_rank` = '". $defs[$CurUser['id_owner']] ."', `fleet_rank` = '". $fleet[$CurUser['id_owner']] ."', `total_rank` = '". $Rank ."' WHERE  `stat_type` = '2' AND `stat_code` = '1' AND `id_owner` = '". $CurUser['id_owner'] ."';";
			$Rank++;
		}

		$db->free_result($RankQry);
		
		return $QryUpdateStats;
	}
	
	final public function MakeStats()
	{
		global $db, $CONF;
		$this->DeleteSome();
		
		$TotalData	= $this->GetUsersInfosFromDB();
		$FinalSQL	= 'TRUNCATE TABLE '.STATPOINTS.';';
		$FinalSQL	.= "INSERT INTO ".STATPOINTS." (`id_owner`, `id_ally`, `stat_type`, `stat_code`, `tech_old_rank`, `tech_points`, `tech_count`, `build_old_rank`, `build_points`, `build_count`, `defs_old_rank`, `defs_points`, `defs_count`, `fleet_old_rank`, `fleet_points`, `fleet_count`, `total_old_rank`, `total_points`, `total_count`, `stat_date`) VALUES ";
		
		while($PlanetData = $db->fetch_array($TotalData['Planets']))
		{		
			if(($CONF['stat'] == 1 && $PlanetData['authlevel'] >= $CONF['stat_level']) || !empty($PlanetData['bana'])) continue;
			
 			if(!isset($UserPoints[$PlanetData['id_owner']]))
				$UserPoints[$PlanetData['id_owner']]['build']['count'] = $UserPoints[$PlanetData['id_owner']]['build']['points'] = $UserPoints[$PlanetData['id_owner']]['fleet']['count'] = $UserPoints[$PlanetData['id_owner']]['fleet']['points'] = $UserPoints[$PlanetData['id_owner']]['defense']['count'] = $UserPoints[$PlanetData['id_owner']]['defense']['points'] = 0;
			
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
		
		$db->free_result($TotalData['Planets']);
		
		while($UserData	= $db->fetch_array($TotalData['Users']))
		{
			if (($CONF['stat'] == 1 && $UserData['authlevel'] >= $CONF['stat_level']) || !empty($UserData['bana']))
			{	
				$FinalSQL  .= "(".$UserData['id'].",".$UserData['ally_id'].",1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'".$this->time."'), ";
				continue;
			}
			
			$TechnoPoints		= $this->GetTechnoPoints($UserData);
			
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
				if(!isset($AllyPoints[$UserData['ally_id']]))
					$AllyPoints[$UserData['ally_id']]['build']['count']	= $AllyPoints[$UserData['ally_id']]['build']['points'] = $AllyPoints[$UserData['ally_id']]['fleet']['count'] = $AllyPoints[$UserData['ally_id']]['fleet']['points'] = $AllyPoints[$UserData['ally_id']]['defense']['count'] = $AllyPoints[$UserData['ally_id']]['defense']['points'] = $AllyPoints[$UserData['ally_id']]['techno']['count'] = $AllyPoints[$UserData['ally_id']]['techno']['points'] = $AllyPoints[$UserData['ally_id']]['total']['count'] = $AllyPoints[$UserData['ally_id']]['total']['points']	= 0;				

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
			
			$FinalSQL  .= "('".$UserData['id']."','".$UserData['ally_id']."',1,1,'".$UserData['old_tech_rank']."', '".floattostring($UserPoints[$UserData['id']]['techno']['points'])."', '".floattostring($UserPoints[$UserData['id']]['techno']['count'])."', '".$UserData['old_build_rank']."','".floattostring($UserPoints[$UserData['id']]['build']['points'])."', '".floattostring($UserPoints[$UserData['id']]['build']['count'])."', '".$UserData['old_defs_rank']."', '".floattostring($UserPoints[$UserData['id']]['defense']['points'])."', '".floattostring($UserPoints[$UserData['id']]['defense']['count'])."', '".$UserData['old_fleet_rank']."', '".floattostring($UserPoints[$UserData['id']]['fleet']['points'])."', '".floattostring($UserPoints[$UserData['id']]['fleet']['count'])."', '".$UserData['old_total_rank']."', '".floattostring($UserPoints[$UserData['id']]['total']['points'])."', '".floattostring($UserPoints[$UserData['id']]['total']['count'])."', '".$this->time."'), ";
		}
		
		$db->free_result($TotalData['Users']);
		
		$FinalSQL	= substr($FinalSQL, 0, -2).';';
		
		$this->SaveDataIntoDB($FinalSQL);
		unset($UserPoints);
		
		if(count($AllyPoints) != 0)
		{
			$AllySQL = "INSERT INTO ".STATPOINTS." (`id_owner`, `id_ally`, `stat_type`, `stat_code`, `tech_old_rank`, `tech_points`, `tech_count`, `build_old_rank`, `build_points`, `build_count`, `defs_old_rank`, `defs_points`, `defs_count`, `fleet_old_rank`, `fleet_points`, `fleet_count`, `total_old_rank`, `total_points`, `total_count`, `stat_date`) VALUES ";
			while($AllianceData	= $db->fetch_array($TotalData['Alliance']))
			{
				$AllySQL  .= "('".$AllianceData['id']."',0,2,1, '".$AllyPoints['old_tech_rank']."', '".floattostring($AllyPoints[$AllianceData['id']]['techno']['points'])."', '".floattostring($AllyPoints[$AllianceData['id']]['techno']['count'])."', '".$AllianceData['old_build_rank']."', '".floattostring($AllyPoints[$AllianceData['id']]['build']['points'])."', '".floattostring($AllyPoints[$AllianceData['id']]['build']['count'])."', '".$AllianceData['old_defs_rank']."', '".floattostring($AllyPoints[$AllianceData['id']]['defense']['points'])."', '".floattostring($AllyPoints[$AllianceData['id']]['defense']['count'])."', '".$AllianceData['old_fleet_rank']."', '".floattostring($AllyPoints[$AllianceData['id']]['fleet']['points'])."', '".floattostring($AllyPoints[$AllianceData['id']]['fleet']['count'])."', '".$AllianceData['old_total_rank']."', '".floattostring($AllyPoints[$AllianceData['id']]['total']['points'])."', '".floattostring($AllyPoints[$AllianceData['id']]['total']['count'])."', '".$this->time."'), ";
			}
			unset($AllyPoints);
			$AllySQL	= substr($AllySQL, 0, -2).';';
			$this->SaveDataIntoDB($AllySQL);
		}		
			
		$db->free_result($TotalData['Alliance']);
		
		$RankSQL    = $this->SetNewRanks();

		$this->SaveDataIntoDB($RankSQL);
		
		$this->RebuildRecordCache();
		
		$this->AnotherCronJobs();
		
		return $this->SomeStatsInfos();
	}
}
?>