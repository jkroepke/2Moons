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
 * @version 1.4 (2011-07-10)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

require(ROOT_PATH.'includes/classes/class.Records.php');

class statbuilder extends records
{
	function __construct()
	{
		$this->starttime   	= microtime(true);
		$this->memory		= array(round(memory_get_usage() / 1024,1),round(memory_get_usage(1) / 1024,1));
		$this->time   		= TIMESTAMP;
	}

	private function SomeStatsInfos()
	{
		global $db;
		return array(
			'stats_time'		=> $this->time,
			'totaltime'    		=> round(microtime(true) - $this->starttime, 7),
			'memory_peak'		=> array(round(memory_get_peak_usage() / 1024,1), round(memory_get_peak_usage(1) / 1024,1)),
			'initial_memory'	=> $this->memory,
			'end_memory'		=> array(round(memory_get_usage() / 1024,1), round(memory_get_usage(1) / 1024,1)),
			'sql_count'			=> $db->get_sql(),
		);
	}
	
	private function AnotherCronJobs()
	{
		
	}	
	
	private function CheckUniverseAccounts($UniData)
	{
		foreach($UniData as $Uni => $Amount) {
			update_config(array('users_amount' => $Amount), $Uni);
		}
	}	
	
	private function DeleteSome()
	{
		global $db, $CONF;

		$db->query("LOCK TABLES ".ALLIANCE." WRITE, ".BUDDY." WRITE, ".CONFIG." WRITE, ".FLEETS." WRITE, ".NOTES." WRITE, ".MESSAGES." WRITE, ".PLANETS." WRITE, ".RW." WRITE, ".SESSION." WRITE,  ".SUPP." WRITE, ".STATPOINTS." WRITE, ".TOPKB." WRITE, ".USERS." WRITE;");
	
		//Delete old messages
		$del_before 	= TIMESTAMP - ($CONF['del_oldstuff'] * 86400);
		$del_inactive 	= TIMESTAMP - ($CONF['del_user_automatic'] * 86400);
		$del_deleted 	= TIMESTAMP - ($CONF['del_user_manually'] * 86400);

		$db->multi_query("DELETE FROM `".MESSAGES."` WHERE `message_time` < '". $del_before ."';DELETE FROM ".SUPP." WHERE `time` < '".$del_before."' AND `status` = 0;DELETE FROM ".ALLIANCE." WHERE `ally_members` = '0';DELETE FROM ".PLANETS." WHERE `destruyed` < ".TIMESTAMP." AND `destruyed` != 0;UPDATE ".USERS." SET `email_2` = `email` WHERE `setmail` < '".TIMESTAMP."';DELETE FROM ".SESSION." WHERE `user_lastactivity` < '".(TIMESTAMP - SESSION_LIFETIME)."';UPDATE ".USERS." SET `banaday` = '0', `bana` = '0' WHERE `banaday` <= '".TIMESTAMP."';");

		$ChooseToDelete = $db->query("SELECT `id` FROM `".USERS."` WHERE `authlevel` = '".AUTH_USR."' AND ((`db_deaktjava` != 0 AND `db_deaktjava` < '".$del_deleted."') OR `onlinetime` < '".$del_inactive."');");

		if(isset($ChooseToDelete))
		{
			include_once(ROOT_PATH.'includes/functions/DeleteSelectedUser.php');
			while($delete = $db->fetch_array($ChooseToDelete))
			{
				DeleteSelectedUser($delete['id']);
			}	
		}
		
		$db->free_result($ChooseToDelete);

		$DelRW	= $db->query("SELECT `rid` FROM ".RW." WHERE `time` < '". $del_before ."';");
		
		if($db->num_rows($DelRW) !== 0)
		{
			while($RID = $db->fetch_array($DelRW))
			{
				if(file_exists(ROOT_PATH.'raports/raport_'.$RID['rid'].'.php'))
					unlink(ROOT_PATH.'raports/raport_'.$RID['rid'].'.php');
			}	
			$db->query("DELETE FROM ".RW." WHERE `time` < '". $del_before ."';");
		}
		$db->free_result($DelRW);
		
		$TopKBLow		= $db->uniquequery("SELECT gesamtunits FROM ".TOPKB." ORDER BY gesamtunits DESC LIMIT 99,1;");
		
		if(isset($TopKBLow))
		{
			$TKBRW			= $db->query("SELECT `rid` FROM ".TOPKB." WHERE `gesamtunits` < '".((isset($TopKBLow)) ? $TopKBLow['gesamtunits'] : 0)."';");	
			if(isset($TKBRW))
			{
				while($RID = $db->fetch_array($TKBRW))
				{
					if(file_exists(ROOT_PATH.'raports/topkb_'.$RID['rid'].'.php'))
						unlink(ROOT_PATH.'raports/topkb_'.$RID['rid'].'.php');
				}	
				$db->query("DELETE FROM ".TOPKB." WHERE `gesamtunits` < '".((isset($TopKBLow)) ? $TopKBLow['gesamtunits'] : 0)."';");
			}
			
			$db->free_result($TKBRW);
		}
		
		$db->query("UNLOCK TABLES;");
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
			$select_fleets		.= " SUM(p.".$resource[$Fleet].") as ".$resource[$Fleet].",";
		}	
		
		foreach($reslist['defense'] as $Defense){
			$select_defenses	.= " SUM(p.".$resource[$Defense].") as ".$resource[$Defense].",";
		}	
		$FlyingFleets	= array();
		$SQLFleets		= $db->query('SELECT fleet_array, fleet_owner FROM '.FLEETS.';');
		while ($CurFleets = $db->fetch_array($SQLFleets))
		{
			$FleetRec   	= explode(";", $CurFleets['fleet_array']);
			
			if(!is_array($FleetRec)) continue;
				
			foreach($FleetRec as $Item => $Group) {
				if (empty($Group)) continue;
				
				$Ship    	   = explode(",", $Group);
				if(!isset($FlyingFleets[$CurFleets['fleet_owner']][$Ship[0]]))
					$FlyingFleets[$CurFleets['fleet_owner']][$Ship[0]]	= $Ship[1];
				else
					$FlyingFleets[$CurFleets['fleet_owner']][$Ship[0]]	+= $Ship[1];
			}
		}
		
		$db->free_result($SQLFleets);
		
		$Return['Fleets'] 	= $FlyingFleets;		
		$Return['Planets']	= $db->query('SELECT SQL_BIG_RESULT DISTINCT '.$select_buildings.' p.id, p.universe, p.id_owner, u.authlevel, u.bana, u.username FROM '.PLANETS.' as p LEFT JOIN '.USERS.' as u ON u.id = p.id_owner;');
		$Return['Users']	= $db->query('SELECT SQL_BIG_RESULT DISTINCT '.$selected_tech.$select_fleets.$select_defenses.' u.id, u.ally_id, u.authlevel, u.bana, u.universe, u.username, s.tech_rank AS old_tech_rank, s.build_rank AS old_build_rank, s.defs_rank AS old_defs_rank, s.fleet_rank AS old_fleet_rank, s.total_rank AS old_total_rank FROM '.USERS.' as u LEFT JOIN '.STATPOINTS.' as s ON s.stat_type = 1 AND s.id_owner = u.id LEFT JOIN '.PLANETS.' as p ON u.id = p.id_owner GROUP BY s.id_owner, u.id, u.authlevel;');
		$Return['Alliance']	= $db->query('SELECT SQL_BIG_RESULT DISTINCT a.id, a.ally_universe, s.tech_rank AS old_tech_rank, s.build_rank AS old_build_rank, s.defs_rank AS old_defs_rank, s.fleet_rank AS old_fleet_rank, s.total_rank AS old_total_rank FROM '.ALLIANCE.' as a LEFT JOIN '.STATPOINTS.' as s ON s.stat_type = 2 AND s.id_owner = a.id;');
	
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

			$this->SetIfRecord($Techno, $CurrentUser);
			
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

			$this->SetIfRecord($Build, $CurrentPlanet);
			
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
			$this->SetIfRecord($Defense, $CurrentPlanet);
			
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
		
			$this->SetIfRecord($Fleet, $CurrentPlanet);
			
			$Units			= $pricelist[$Fleet]['metal'] + $pricelist[$Fleet]['crystal'] + $pricelist[$Fleet]['deuterium'];
			$FleetPoints   += $Units * $CurrentPlanet[$resource[$Fleet]];
			$FleetCounts   += $CurrentPlanet[$resource[$Fleet]];
		}
		
		return array('count' => $FleetCounts, 'points' => ($FleetPoints / $CONF['stat_settings']));
	}
	
	private function SetNewRanks()
	{
		global $db, $CONF;
		$Unis	= array($CONF['uni']);
		$Query	= $db->query("SELECT `uni` FROM ".CONFIG." WHERE `uni` != '".$CONF['uni']."' ORDER BY `uni` ASC;");
		while($Uni	= $db->fetch_array($Query)) {
			$Unis[]	= $Uni['uni'];
		}
		
		
		$QryUpdateStats = "";
		foreach($Unis as $Uni)
		{
			$tech			= array();
			$Rank           = 1;
			$RankQry        = $db->query("SELECT s.`id_owner` FROM ".STATPOINTS." as s, ".USERS." as u WHERE s.`universe` = '".$Uni."' AND s.`stat_type` = '1' AND s.`id_owner` = `u`.id ".(($CONF['stat'] == 2)?'AND u.`authlevel` < '.$CONF['stat_level'].' ':'')." ORDER BY `tech_points` DESC;");
			while ($CurUser = $db->fetch_array($RankQry))
			{
				$tech[$CurUser['id_owner']]	= $Rank;
				$Rank++;
			}

			$db->free_result($RankQry);

			$build			= array();
			$Rank           = 1;
			$RankQry        = $db->query("SELECT s.`id_owner` FROM ".STATPOINTS." as s, ".USERS." as u WHERE s.`universe` = '".$Uni."' AND  s.`stat_type` = '1' AND s.`id_owner` = `u`.id ".(($CONF['stat'] == 2)?'AND u.`authlevel` < '.$CONF['stat_level'].' ':'')." ORDER BY `build_points` DESC;");
			while ($CurUser = $db->fetch_array($RankQry))
			{
				$build[$CurUser['id_owner']] = $Rank;
				$Rank++;
			}

			$db->free_result($RankQry);
				
			$defs			= array();
			$Rank           = 1;
			$RankQry        = $db->query("SELECT s.`id_owner` FROM ".STATPOINTS." as s, ".USERS." as u WHERE s.`universe` = '".$Uni."' AND  s.`stat_type` = '1' AND s.`id_owner` = `u`.id ".(($CONF['stat'] == 2)?'AND u.`authlevel` < '.$CONF['stat_level'].' ':'')." ORDER BY `defs_points` DESC;");
			while ($CurUser = $db->fetch_array($RankQry))
			{
				$defs[$CurUser['id_owner']]	= $Rank;
				$Rank++;
			}

			$db->free_result($RankQry);
				
			$fleet			= array();
			$Rank           = 1;
			$RankQry        = $db->query("SELECT s.`id_owner` FROM ".STATPOINTS." as s, ".USERS." as u WHERE s.`universe` = '".$Uni."' AND  s.`stat_type` = '1' AND s.`id_owner` = `u`.id ".(($CONF['stat'] == 2)?'AND u.`authlevel` < '.$CONF['stat_level'].' ':'')." ORDER BY `fleet_points` DESC;");
			while ($CurUser = $db->fetch_array($RankQry))
			{
				$fleet[$CurUser['id_owner']] = $Rank;
				$Rank++;
			}

			$db->free_result($RankQry);
				
			$Rank           = 1;
			$RankQry        = $db->query("SELECT s.`id_owner` FROM ".STATPOINTS." as s, ".USERS." as u WHERE s.`universe` = '".$Uni."' AND  s.`stat_type` = '1' AND s.`id_owner` = `u`.id ".(($CONF['stat'] == 2)?'AND u.`authlevel` < '.$CONF['stat_level'].' ':'')." ORDER BY `total_points` DESC;");

			while($CurUser = $db->fetch_array($RankQry))
			{
				$QryUpdateStats .= "UPDATE ".STATPOINTS." SET `tech_rank` = '". $tech[$CurUser['id_owner']] ."', `build_rank` = '". $build[$CurUser['id_owner']] ."', `defs_rank` = '". $defs[$CurUser['id_owner']] ."', `fleet_rank` = '". $fleet[$CurUser['id_owner']] ."', `total_rank` = '". $Rank ."' WHERE `stat_type` = '1' AND `id_owner` = '". $CurUser['id_owner'] ."';";
				$Rank++;
			}

			$db->free_result($RankQry);
				
				
			$tech			= array();
			$Rank           = 1;
			$RankQry        = $db->query("SELECT s.`id_owner` FROM ".STATPOINTS." as s WHERE s.`universe` = '".$Uni."' AND  s.`stat_type` = '2' ORDER BY `tech_points` DESC;");
			while ($CurUser = $db->fetch_array($RankQry))
			{
				$tech[$CurUser['id_owner']]	= $Rank;
				$Rank++;
			}

			$db->free_result($RankQry);
			
			$build			= array();
			$Rank           = 1;
			$RankQry        = $db->query("SELECT s.`id_owner` FROM ".STATPOINTS." as s WHERE s.`universe` = '".$Uni."' AND  s.`stat_type` = '2' ORDER BY `build_points` DESC;");
			while ($CurUser = $db->fetch_array($RankQry))
			{
				$build[$CurUser['id_owner']] = $Rank;
				$Rank++;
			}

			$db->free_result($RankQry);
				
			$defs			= array();
			$Rank           = 1;
			$RankQry        = $db->query("SELECT s.`id_owner` FROM ".STATPOINTS." as s WHERE s.`universe` = '".$Uni."' AND  s.`stat_type` = '2' ORDER BY `defs_points` DESC;");
			while ($CurUser = $db->fetch_array($RankQry))
			{
				$defs[$CurUser['id_owner']]	= $Rank;
				$Rank++;
			}

			$db->free_result($RankQry);
			
			$fleet			= array();
			$Rank           = 1;
			$RankQry        = $db->query("SELECT s.`id_owner` FROM ".STATPOINTS." as s WHERE s.`universe` = '".$Uni."' AND  s.`stat_type` = '2' ORDER BY `fleet_points` DESC;");
			while ($CurUser = $db->fetch_array($RankQry))
			{
				$fleet[$CurUser['id_owner']] = $Rank;
				$Rank++;
			}

			$db->free_result($RankQry);
				
			$Rank           = 1;
			$RankQry        = $db->query("SELECT s.`id_owner` FROM ".STATPOINTS." as s WHERE s.`universe` = '".$Uni."' AND s.`stat_type` = '2' ORDER BY `total_points` DESC;");

			while($CurUser = $db->fetch_array($RankQry))
			{
				$QryUpdateStats .= "UPDATE ".STATPOINTS." SET `tech_rank` = '". $tech[$CurUser['id_owner']] ."', `build_rank` = '". $build[$CurUser['id_owner']] ."', `defs_rank` = '". $defs[$CurUser['id_owner']] ."', `fleet_rank` = '". $fleet[$CurUser['id_owner']] ."', `total_rank` = '". $Rank ."' WHERE `stat_type` = '2' AND `id_owner` = '". $CurUser['id_owner'] ."';";
				$Rank++;
			}

			$db->free_result($RankQry);
		}
		return $QryUpdateStats;
	}
	
	final public function MakeStats()
	{
		global $db, $CONF, $resource;
		$this->DeleteSome();
		$AllyPoints	= array();
		$UserPoints	= array();
		$TotalData	= $this->GetUsersInfosFromDB();
		$FinalSQL	= 'TRUNCATE TABLE '.STATPOINTS.';';
		$FinalSQL	.= "INSERT INTO ".STATPOINTS." (`id_owner`, `id_ally`, `stat_type`, `universe`, `tech_old_rank`, `tech_points`, `tech_count`, `build_old_rank`, `build_points`, `build_count`, `defs_old_rank`, `defs_points`, `defs_count`, `fleet_old_rank`, `fleet_points`, `fleet_count`, `total_old_rank`, `total_points`, `total_count`) VALUES ";
		
		while($PlanetData = $db->fetch_array($TotalData['Planets']))
		{		
			if((in_array($CONF['stat'], array(1, 2)) && $PlanetData['authlevel'] >= $CONF['stat_level']) || !empty($PlanetData['bana'])) continue;
			
 			if(!isset($UserPoints[$PlanetData['id_owner']]))
				$UserPoints[$PlanetData['id_owner']]['build']['count'] = $UserPoints[$PlanetData['id_owner']]['build']['points'] = 0;
			
			$BuildPoints		= $this->GetBuildPoints($PlanetData);
			$UserPoints[$PlanetData['id_owner']]['build']['count'] 		+= $BuildPoints['count'];
			$UserPoints[$PlanetData['id_owner']]['build']['points'] 	+= $BuildPoints['points'];
		}
		
		$db->free_result($TotalData['Planets']);
		
		$UniData	= array();
		
		while($UserData	= $db->fetch_array($TotalData['Users']))
		{
			if(!isset($UniData[$UserData['universe']]))
				$UniData[$UserData['universe']] = 0;
			
			$UniData[$UserData['universe']]++;
				
			if ((in_array($CONF['stat'], array(1, 2)) && $UserData['authlevel'] >= $CONF['stat_level']) || !empty($UserData['bana']))
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
			
			$UserPoints[$UserData['id']]['total']['count'] 		= $UserPoints[$UserData['id']]['techno']['count'] + $UserPoints[$UserData['id']]['build']['count'] + $UserPoints[$UserData['id']]['defense']['count'] + $UserPoints[$UserData['id']]['fleet']['count'];
			$UserPoints[$UserData['id']]['total']['points'] 	= $UserPoints[$UserData['id']]['techno']['points'] + $UserPoints[$UserData['id']]['build']['points'] + $UserPoints[$UserData['id']]['defense']['points'] + $UserPoints[$UserData['id']]['fleet']['points'];

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
			
			$FinalSQL  .= "('".$UserData['id']."','".$UserData['ally_id']."', 1, ".$UserData['universe'].", '".(int)$UserData['old_tech_rank']."', '".floattostring($UserPoints[$UserData['id']]['techno']['points'])."', '".floattostring($UserPoints[$UserData['id']]['techno']['count'])."', '".(int)$UserData['old_build_rank']."','".floattostring($UserPoints[$UserData['id']]['build']['points'])."', '".floattostring($UserPoints[$UserData['id']]['build']['count'])."', '".(int)$UserData['old_defs_rank']."', '".floattostring($UserPoints[$UserData['id']]['defense']['points'])."', '".floattostring($UserPoints[$UserData['id']]['defense']['count'])."', '".(int)$UserData['old_fleet_rank']."', '".floattostring($UserPoints[$UserData['id']]['fleet']['points'])."', '".floattostring($UserPoints[$UserData['id']]['fleet']['count'])."', '".(int)$UserData['old_total_rank']."', '".floattostring($UserPoints[$UserData['id']]['total']['points'])."', '".floattostring($UserPoints[$UserData['id']]['total']['count'])."'), ";
		}
		
		$db->free_result($TotalData['Users']);
		
		$FinalSQL	= substr($FinalSQL, 0, -2).';';
		
		$this->SaveDataIntoDB($FinalSQL);
		unset($UserPoints);
		
		if(count($AllyPoints) != 0)
		{
			$AllySQL = "INSERT INTO ".STATPOINTS." (`id_owner`, `id_ally`, `stat_type`, `universe`, `tech_old_rank`, `tech_points`, `tech_count`, `build_old_rank`, `build_points`, `build_count`, `defs_old_rank`, `defs_points`, `defs_count`, `fleet_old_rank`, `fleet_points`, `fleet_count`, `total_old_rank`, `total_points`, `total_count`) VALUES ";
			while($AllianceData	= $db->fetch_array($TotalData['Alliance']))
			{
				$AllySQL  .= "('".$AllianceData['id']."', 0, 2, ".$AllianceData['ally_universe'].",'".(int)$AllyPoints['old_tech_rank']."', '".floattostring($AllyPoints[$AllianceData['id']]['techno']['points'])."', '".floattostring($AllyPoints[$AllianceData['id']]['techno']['count'])."', '".(int)$AllianceData['old_build_rank']."', '".floattostring($AllyPoints[$AllianceData['id']]['build']['points'])."', '".floattostring($AllyPoints[$AllianceData['id']]['build']['count'])."', '".(int)$AllianceData['old_defs_rank']."', '".floattostring($AllyPoints[$AllianceData['id']]['defense']['points'])."', '".floattostring($AllyPoints[$AllianceData['id']]['defense']['count'])."', '".(int)$AllianceData['old_fleet_rank']."', '".floattostring($AllyPoints[$AllianceData['id']]['fleet']['points'])."', '".floattostring($AllyPoints[$AllianceData['id']]['fleet']['count'])."', '".(int)$AllianceData['old_total_rank']."', '".floattostring($AllyPoints[$AllianceData['id']]['total']['points'])."', '".floattostring($AllyPoints[$AllianceData['id']]['total']['count'])."'), ";
			}
			unset($AllyPoints);
			$AllySQL	= substr($AllySQL, 0, -2).';';
			$this->SaveDataIntoDB($AllySQL);
		}		
			
		$db->free_result($TotalData['Alliance']);
		
		$RankSQL    = $this->SetNewRanks();

		$this->SaveDataIntoDB($RankSQL);
		$this->CheckUniverseAccounts($UniData);
		$this->BuildRecordCache();
		$this->AnotherCronJobs();		
		return $this->SomeStatsInfos();
	}
}

?>