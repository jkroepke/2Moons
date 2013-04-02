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
 * @version 1.7.2 (2013-03-18)
 * @info $Id$
 * @link http://2moons.cc/
 */

class ShowAlliancePage extends AbstractPage
{
	public static $requireModule = MODULE_ALLIANCE;

	private $allianceData;
	private $ranks;
	private $rights;
	private $hasAlliance = false;
	private $hasApply = false;
	public $avalibleRanks	= array(
		'MEMBERLIST',
		'ONLINESTATE',
		'TRANSFER',
		'SEEAPPLY',
		'MANAGEAPPLY',
		'ROUNDMAIL',
		'ADMIN',
		'KICK',
		'DIPLOMATIC',
		'RANKS',
		'MANAGEUSERS',
		'EVENTS'
	);
	
	function __construct() 
	{
		global $USER;
		parent::__construct();
		$this->hasAlliance	= $USER['ally_id'] != 0;
		$this->hasApply		= $this->isApply();
		if($this->hasAlliance && !$this->hasApply) {
			$this->setAllianceData($USER['ally_id']);
		}
	}
	
	private function setAllianceData($allianceID)
	{
		global $USER;
		$db	= Database::get();

        $sql	= "SELECT * FROM %%ALLIANCE%% WHERE id = :allianceID;";
        $this->allianceData = $db->selectSingle($sql, array(
            ':allianceID'	=> $allianceID
        ));

        if($USER['ally_id'] == $allianceID)
		{
			if ($this->allianceData['ally_owner'] == $USER['id']) {
				$this->rights	= array_combine($this->avalibleRanks, array_fill(0, count($this->avalibleRanks), true));
			} elseif($USER['ally_rank_id'] != 0) {
				$sql	= "SELECT :availableRanks FROM %%ALLIANCE_RANK%% WHERE allianceID = :allianceID AND rankID = :ally_rank_id;";
                $this->rights = $db->selectSingle($sql, array(
                    ':allianceID'		=> $allianceID,
                    ':ally_rank_id'		=> $USER['ally_rank_id'],
					':availableRanks'	=> implode(", ", $this->avalibleRanks)
                ));
            }
			
			if(!isset($this->rights)) {
				$this->rights	= array_combine($this->avalibleRanks, array_fill(0, count($this->avalibleRanks), false));
			}
		
			if(isset($this->tplObj))
			{
				$this->tplObj->assign_vars(array(
					'rights'		=> $this->rights,
					'AllianceOwner'	=> $this->allianceData['ally_owner'] == $USER['id'],
				));
			}
		}
	}
	
	private function isApply()
	{
		global $USER;
        $db	= Database::get();
        $sql = "SELECT COUNT(*) as count FROM %%ALLIANCE_REQUEST%% WHERE userID = :userID;";
        return $db->selectSingle($sql, array(
            ':userID'	=> $USER['id']
        ), 'count');
    }
	
	function info() 
	{
		global $LNG, $USER, $PLANET;
		
		$allianceID = HTTP::_GP('id', 0);
		
		$this->setAllianceData($allianceID);

		if(!isset($this->allianceData))
		{
			$this->printMessage($LNG['al_not_exists']);
		}
		
		require_once('includes/functions/BBCode.php');
		
		if ($this->allianceData['ally_diplo'] == 1)
		{
			$this->tplObj->assign_vars(array(
				'DiploInfo'			=> $this->getDiplomatic(),
			));
		}
		
		if ($this->allianceData['ally_stats'] == 1)
		{
			$db	= Database::get();
            $sql	= "SELECT SUM(wons) as wons, SUM(loos) as loos, SUM(draws) as draws, SUM(kbmetal) as kbmetal, SUM(kbcrystal) as kbcrystal, SUM(lostunits) as lostunits, SUM(desunits) as desunits
                        FROM %%USERS%% WHERE ally_id = :allyID;";
            $StatsData = $db->selectSingle($sql, array(
                ':allyID'	=> $this->allianceData['id']
            ));

            $this->tplObj->assign_vars(array(
				'totalfight'	=> $StatsData['wons'] + $StatsData['loos'] + $StatsData['draws'],
				'fightwon'		=> $StatsData['wons'],
				'fightlose'		=> $StatsData['loos'],
				'fightdraw'		=> $StatsData['draws'],
				'unitsshot'		=> pretty_number($StatsData['desunits']),
				'unitslose'		=> pretty_number($StatsData['lostunits']),
				'dermetal'		=> pretty_number($StatsData['kbmetal']),
				'dercrystal'	=> pretty_number($StatsData['kbcrystal']),
			));
		}

		$this->tplObj->assign_vars(array(
			'ally_description' 				=> bbcode($this->allianceData['ally_description']),
			'ally_id'	 					=> $this->allianceData['id'],
			'ally_image' 					=> $this->allianceData['ally_image'],
			'ally_web'						=> $this->allianceData['ally_web'],
			'ally_member_scount' 			=> $this->allianceData['ally_members'],
			'ally_max_members' 				=> $this->allianceData['ally_max_members'],
			'ally_name' 					=> $this->allianceData['ally_name'],
			'ally_tag' 						=> $this->allianceData['ally_tag'],
			'ally_stats' 					=> $this->allianceData['ally_stats'],
			'ally_diplo' 					=> $this->allianceData['ally_diplo'],
			'ally_request'              	=> !$this->hasAlliance && !$this->hasApply && $this->allianceData['ally_request_notallow'] == 0 && $this->allianceData['ally_max_members'] > $this->allianceData['ally_members'],
			'ally_request_min_points'		=> $USER['total_points'] >= $this->allianceData['ally_request_min_points'],
			'ally_request_min_points_info'  => sprintf($LNG['al_requests_min_points'], pretty_number($this->allianceData['ally_request_min_points']))
		));
		
		$this->display('page.alliance.info.tpl');
	}
	
	function show() 
	{
		if($this->hasAlliance) {
			$this->homeAlliance();
		} elseif($this->hasApply) {		
			$this->applyWaitScreen();
		} else {		
			$this->createSelection();
		}
	}
	
	private function redirectToHome()
	{
		$this->redirectTo('game.php?page=alliance');
	}
	
	private function getAction()
	{
		return HTTP::_GP('action', '');
	}
	
	private function applyWaitScreen()
	{
		global $USER, $LNG;
		
		$db	= Database::get();
        $sql	= "SELECT a.ally_tag FROM %%ALLIANCE_REQUEST%% r INNER JOIN %%ALLIANCE%% a ON a.id = r.allianceID WHERE r.userID = :userID;";
        $allianceResult = $db->selectSingle($sql, array(
            ':userID'	=> $USER['id_planet']
        ));

        $this->tplObj->assign_vars(array(
			'request_text'	=> sprintf($LNG['al_request_wait_message'], $allianceResult['ally_tag']),
		));     

		$this->display('page.alliance.applyWait.tpl');		
	}
	
	private function createSelection()
	{
		$this->display('page.alliance.createSelection.tpl');		
	}

	function search() 
	{

		if($this->hasApply) {
			$this->redirectToHome();
		}
		
		$searchText	= HTTP::_GP('searchtext', '', UTF8_SUPPORT);
		$searchList	= array();

		if (!empty($searchText))
		{
			$db	= Database::get();
            $sql	= "SELECT id, ally_name, ally_tag, ally_members
			FROM %%ALLIANCE%%
			WHERE ally_universe = :universe AND ally_name LIKE :searchText
			ORDER BY (
			  IF(ally_name = :searchText, 1, 0) + IF(ally_name LIKE :searchText, 1, 0)
			) DESC,ally_name ASC LIMIT :limit;";

            $searchResult	= $db->select($sql, array(
                ':universe' => Universe::current(),
                ':searchText'   => '%'.$searchText.'%',
                ':limit'	=> 25
            ));

            foreach($searchResult as $searchRow)
            {
                $searchList[]	= array(
                    'id'		=> $searchRow['id'],
                    'tag'		=> $searchRow['ally_tag'],
                    'members'	=> $searchRow['ally_members'],
                    'name'		=> $searchRow['ally_name'],
                );
            }
		}
		
		$this->tplObj->assign_vars(array(
			'searchText'	=> $searchText,
			'searchList'	=> $searchList,
		));	
		
		$this->display('page.alliance.search.tpl');	
	}
	
	function apply()
	{
		global $LNG, $USER;
		
		if($this->hasApply) {
			$this->redirectToHome();
		}
		
		$text		= HTTP::_GP('text' , '', true);
		$allianceID	= HTTP::_GP('id', 0);
			
		$db = Database::get();
        $sql	= "SELECT ally_tag, ally_request, ally_request_notallow FROM %%ALLIANCE%% WHERE id = :allianceID AND ally_universe = :universe;";
        $allianceResult = $db->selectSingle($sql, array(
            ':allianceID'	=> $allianceID,
            ':universe'     => Universe::current()
        ));

        if (!isset($allianceResult)) {
			$this->redirectToHome();
		}
		
		if($allianceResult['ally_request_notallow'] == 1)
		{
			$this->printMessage($LNG['al_alliance_closed']);
		}

		if (!empty($text))
		{
			$sql = "INSERT INTO %%ALLIANCE_REQUEST%% SET
                allianceID		= :allianceID,
                text		= :text,
                time		= :time,
                userID		= :userID;";

            $db->insert($sql, array(
                ':allianceID'	=> $allianceID,
                ':text'	=> $text,
                ':time'		=> TIMESTAMP,
                ':userID'		=> $USER['id']
            ));

            $this->printMessage($LNG['al_request_confirmation_message']);
		}
		
		$this->tplObj->assign_vars(array(
			'allyid'			=> $allianceID,
			'applytext'			=> $allianceResult['ally_request'],
			'al_write_request'	=> sprintf($LNG['al_write_request'], $allianceResult['ally_tag']),
		));	
		
		$this->display('page.alliance.apply.tpl');
	}
	
	function cancelApply()
	{
		global $LNG, $USER;
		
		if(!$this->hasApply) {
			$this->redirectToHome();
		}
		$db = Database::get();
        $sql	= "SELECT a.ally_tag FROM %%ALLIANCE_REQUEST%% r INNER JOIN %%ALLIANCE%% a ON a.id = r.allianceID WHERE r.userID = :userID;";
        $allyTag = $db->selectSingle($sql, array(
            ':userID'	=> $USER['id']
        ), 'ally_tag');
		$sql = "DELETE FROM %%ALLIANCE_REQUEST%% WHERE userID = :userID;";
		$db->delete($sql, array(
			':userID'	=> $USER['id']
		), 'ally_tag');
		
		$this->printMessage(sprintf($LNG['al_request_deleted'], $allyTag));
	}
	
	function create()
	{
		if($this->hasApply) {
			$this->redirectToHome();
		}
		
		$user_points = $GLOBALS['USER']['total_points'];
		$min_points = $GLOBALS['CONF']['alliance_create_min_points'];
		
		if($user_points >= $min_points)
		{
			$action    = $this->getAction();
		if($action == "send") {
			$this->createAlliance();
		} else {
			$this->display('page.alliance.create.tpl');
		}
	}
		else
		{
			$diff_points = $min_points - $user_points;
			$this->printMessage(sprintf($GLOBALS['LNG']['al_make_ally_insufficient_points'], pretty_number($min_points), pretty_number($diff_points)));
		}
	}
	
	private function createAlliance()
	{
		$action	= $this->getAction();
		if($action == "send") {
			$this->createAllianceProcessor();
		} else {
			$this->display('page.alliance.create.tpl');
		}
	}
		
	private function createAllianceProcessor() 
	{
		global $USER, $LNG;
		$atag	= HTTP::_GP('atag' , '', UTF8_SUPPORT);
		$aname	= HTTP::_GP('aname', '', UTF8_SUPPORT);
		
		if (empty($atag)) {
			$this->printMessage($LNG['al_tag_required'], true, array("?page=alliance&mode=create", 3));
		}
		
		if (empty($aname)) {
			$this->printMessage($LNG['al_name_required'], true, array("?page=alliance&mode=create", 3));
		}
		
		if (!CheckName($aname) || !CheckName($atag)) {
			$this->printMessage($LNG['al_newname_specialchar'], true, array("?page=alliance&mode=create", 3));
		}
		
		$db	= Database::get();
        $sql	= "SELECT COUNT(*) as count FROM %%ALLIANCE%% WHERE ally_universe = :universe AND (ally_tag = :allianceTag OR ally_name = :allianceName);";
        $allianceCount = $db->selectSingle($sql, array(
            ':universe'	=> Universe::current(),
            ':allianceTag' => $atag,
            ':allianceName' => $aname
        ), 'count');

        if ($allianceCount != 0) {
			$this->printMessage(sprintf($LNG['al_already_exists'], $aname), true, array("?page=alliance&mode=create", 3));
		}

        $sql	= "INSERT INTO %%ALLIANCE%% SET ally_name = :allianceName, ally_tag = :allianceTag, ally_owner = :userID, ally_owner_range = :allianceOwnerRange, ally_members = 1, ally_register_time = :time, ally_universe = :universe;";
        $db->insert($sql, array(
            ':allianceName'			=> $aname,
            ':allianceTag'			=> $atag,
            ':userID'			    => $USER['id'],
            ':allianceOwnerRange'	=> $LNG['al_default_leader_name'],
            ':time'                 => TIMESTAMP,
            ':universe'             => Universe::current(),
        ));

        $LastAllianceID = $db->lastInsertId();

        $sql	= "UPDATE %%USERS%% SET ally_id	= :allianceID, ally_rank_id	= 0, ally_register_time = :time WHERE id = :userID;";
        $db->update($sql, array(
            ':allianceID'	=> $LastAllianceID,
            ':time'			=> TIMESTAMP,
            ':userID'       => $USER['id']
        ));

        $sql	= "UPDATE %%STATPOINTS%% SET id_ally = :allianceID WHERE id = :userID;";
        $db->update($sql, array(
            ':allianceID'	=> $LastAllianceID,
            ':userID'       => $USER['id']
        ));

        $this->printMessage(sprintf($LNG['al_created'], $aname.' ['.$atag.']'), true, array('?page=alliance', 3));

	}
	
	private function getDiplomatic()
	{
		$Return	= array();
		$db = Database::get();

        $sql	= "SELECT d.level, d.accept, d.accept_text, d.id, a.id as ally_id, a.ally_name, a.ally_tag, d.owner_1, d.owner_2 FROM %%DIPLO%% as d INNER JOIN %%ALLIANCE%% as a ON IF(:allianceID = d.owner_1, a.id = d.owner_2, a.id = d.owner_1) WHERE :allianceID = d.owner_1 OR :allianceID = d.owner_2;";
        $DiploResult	= $db->select($sql, array(
            ':allianceID'		=> $this->allianceData['id'],
         ));

        foreach($DiploResult as $CurDiplo)
        {
            if($CurDiplo['accept'] == 0 && $CurDiplo['owner_2'] == $this->allianceData['id'])
                $Return[5][$CurDiplo['id']] = array($CurDiplo['ally_name'], $CurDiplo['ally_id'], $CurDiplo['level'], $CurDiplo['accept_text'], $CurDiplo['ally_tag']);
            elseif($CurDiplo['accept'] == 0 && $CurDiplo['owner_1'] == $this->allianceData['id'])
                $Return[6][$CurDiplo['id']] = array($CurDiplo['ally_name'], $CurDiplo['ally_id'], $CurDiplo['level'], $CurDiplo['accept_text'], $CurDiplo['ally_tag']);
            else
                $Return[$CurDiplo['level']][$CurDiplo['id']] = array($CurDiplo['ally_name'], $CurDiplo['ally_id'], $CurDiplo['owner_1'], $CurDiplo['ally_tag']);
        }
        return $Return;
	}

	private function homeAlliance()
	{
		global $USER, $LNG;
		require_once('includes/functions/BBCode.php');
        $db	= Database::get();
		if ($this->allianceData['ally_owner'] == $USER['id']) {
			$rankName	= ($this->allianceData['ally_owner_range'] != '') ? $this->allianceData['ally_owner_range'] : $LNG['al_founder_rank_text'];
		} elseif ($USER['ally_rank_id'] != 0) {
            $sql	= "SELECT rankName FROM &&ALLIANCE_RANK&& WHERE rankID = :UserRankID;";
            $rankName = $db->selectSingle($sql, array(
                ':UserRankID'	=> $USER['ally_rank_id']
            ),'rankName');
        }
		
		if (empty($rankName)) {
			$rankName	= $LNG['al_new_member_rank_text'];
		}

        $sql	= "SELECT SUM(wons) as wons, SUM(loos) as loos, SUM(draws) as draws, SUM(kbmetal) as kbmetal, SUM(kbcrystal) as kbcrystal, SUM(lostunits) as lostunits, SUM(desunits) as desunits FROM %%USERS%% WHERE ally_id = :AllianceID;";
        $StatsData = $db->selectSingle($sql, array(
            ':AllianceID'	=> $this->allianceData['id']
        ));

        $sql = "SELECT COUNT(*) as count FROM %%ALLIANCE_REQUEST%% WHERE allianceID = :AllianceID;";
        $ApplyCount = $db->selectSingle($sql, array(
            ':AllianceID'	=> $this->allianceData['id']
        ),'count');

		$ally_events = array();
		
		if(!empty($this->allianceData['ally_events']))
		{
			$sql = "SELECT id, username FROM %%USERS%% WHERE ally_id = :AllianceID;";
            $result = $db->select($sql, array(
                ':AllianceID'	=> $this->allianceData['id']
            ));


			require_once('includes/classes/class.FlyingFleetsTable.php');
			$FlyingFleetsTable = new FlyingFleetsTable;
			
			$this->tplObj->loadscript('overview.js');
			
			foreach($result as $row)
			{
				$FlyingFleetsTable->setUser($row['id']);
				$FlyingFleetsTable->setMissions($this->allianceData['ally_events']);
				$ally_events[$row['username']] = $FlyingFleetsTable->renderTable();
			}
			
			$ally_events = array_filter($ally_events);
		}
		
		$this->tplObj->assign_vars(array(
			'DiploInfo'					=> $this->getDiplomatic(),
			'ally_web'					=> $this->allianceData['ally_web'],
			'ally_tag'	 				=> $this->allianceData['ally_tag'],
			'ally_members'	 			=> $this->allianceData['ally_members'],
			'ally_max_members'	 		=> $this->allianceData['ally_members'],
			'ally_name'					=> $this->allianceData['ally_name'],
			'ally_image'				=> $this->allianceData['ally_image'],
			'ally_description'			=> bbcode($this->allianceData['ally_description']),
			'ally_text' 				=> bbcode($this->allianceData['ally_text']),
			'rankName'					=> $rankName,
			'requests'					=> sprintf($LNG['al_new_requests'], $ApplyCount),
			'applyCount'				=> $ApplyCount,
			'totalfight'				=> $StatsData['wons'] + $StatsData['loos'] + $StatsData['draws'],
			'fightwon'					=> $StatsData['wons'],
			'fightlose'					=> $StatsData['loos'],
			'fightdraw'					=> $StatsData['draws'],
			'unitsshot'					=> pretty_number($StatsData['desunits']),
			'unitslose'					=> pretty_number($StatsData['lostunits']),
			'dermetal'					=> pretty_number($StatsData['kbmetal']),
			'dercrystal'				=> pretty_number($StatsData['kbcrystal']),
			'isOwner'					=> $this->allianceData['ally_owner'] == $USER['id'],
			'ally_events'				=> $ally_events
		));
		
		$this->display('page.alliance.home.tpl');
	}
	
	function memberList()
	{
		global $USER, $LNG;
		if (!$this->rights['MEMBERLIST']) {
			$this->redirectToHome();
		}

        $rankList	= array();

        $db = Database::get();
        $sql = "SELECT rankID, rankName FROM %%ALLIANCE_RANK%% WHERE allianceID = :AllianceID";
        $rankResult = $db->select($sql, array(
            ':AllianceID'	=> $this->allianceData['id']
        ));

        foreach($rankResult as $rankRow)
			$rankList[$rankRow['rankID']]	= $rankRow['rankName'];

        $memberList	= array();

        $sql = "SELECT DISTINCT u.id, u.username,u.galaxy, u.system, u.planet, u.ally_register_time, u.onlinetime, u.ally_rank_id, s.total_points FROM %%USERS%% u LEFT JOIN %%STATPOINTS%% as s ON s.stat_type = '1' AND s.id_owner = u.id WHERE ally_id = :AllianceID;";
        $memberListResult = $db->select($sql, array(
            ':AllianceID'	=> $this->allianceData['id']
        ));

        foreach ($memberListResult as $memberListRow)
		{
			if ($this->allianceData['ally_owner'] == $memberListRow['id'])
				$memberListRow['ally_rankName'] = empty($this->allianceData['ally_owner_range']) ? $LNG['al_founder_rank_text'] : $this->allianceData['ally_owner_range'];
			elseif ($memberListRow['ally_rank_id'] != 0 && isset($rankList[$memberListRow['ally_rank_id']]))
				$memberListRow['ally_rankName'] = $rankList[$memberListRow['ally_rank_id']];
			else
				$memberListRow['ally_rankName'] = $LNG['al_new_member_rank_text'];
			
			$memberList[$memberListRow['id']]	= array(
				'username'		=> $memberListRow['username'],
				'galaxy'		=> $memberListRow['galaxy'],
				'system'		=> $memberListRow['system'],
				'planet'		=> $memberListRow['planet'],
				'register_time'	=> _date($LNG['php_tdformat'], $memberListRow['ally_register_time'], $USER['timezone']),
				'points'		=> pretty_number($memberListRow['total_points']),
				'rankName'		=> $memberListRow['ally_rankName'],
				'onlinetime'	=> floor((TIMESTAMP - $memberListRow['onlinetime']) / 60),
			);
		}		
		
		$this->tplObj->assign_vars(array(
			'memberList'		=> $memberList,
			'al_users_list'		=> sprintf($LNG['al_users_list'], count($memberList)),
		));
		
		$this->display('page.alliance.memberList.tpl');
	}
	
	function close()
	{
		global $USER;

        $db = Database::get();

        $sql	= "UPDATE %%USERS%% SET ally_id = 0, ally_register_time = 0, ally_register_time = 5 WHERE id = :UserID;";
        $db->update($sql, array(
            ':UserID'			=> $USER['id']
        ));

        $sql	= "UPDATE %%STATPOINTS%% SET id_ally = 0 WHERE id_owner = :UserID AND stat_type = 1;";
        $db->update($sql, array(
            ':UserID'			=> $USER['id']
        ));

        $sql	= "UPDATE %%ALLIANCE%% SET ally_members = (SELECT COUNT(*) FROM %%USERS%% WHERE ally_id = :AllianceID) WHERE id = :AllianceID;";
        $db->update($sql, array(
            ':AllianceID'			=> $this->allianceData['id']
        ));

        $this->redirectTo('game.php?page=alliance');
	}
	
	function circular() 
	{
		global $LNG, $USER;

		if (!$this->rights['ROUNDMAIL'])
			$this->redirectToHome();
		
		$action	= HTTP::_GP('action', '');

		if ($action == "send")
		{
			$rankID		= HTTP::_GP('rankID', 0);
			$subject 	= HTTP::_GP('subject', '', true);
			$text 		= HTTP::_GP('text', $LNG['mg_no_subject'], true);
			
			if(empty($text)) {
				$this->sendJSON(array('message' => $LNG['mg_empty_text'], 'error' => true));
			}

            $db = Database::get();

			if($rankID == 0) {
				$sql	= "SELECT id, username FROM %%USERS%% WHERE ally_id = :AllianceID;";
				$sendUsersResult	= $db->select($sql, array(
					':AllianceID'	=> $this->allianceData['id'],
				));
			} else {
				$sql	= "SELECT id, username FROM %%USERS%% WHERE ally_id = :AllianceID AND ally_rank_id = :RankID;";
				$sendUsersResult	= $db->select($sql, array(
					':AllianceID'	=> $this->allianceData['id'],
					':RankID'	    => $rankID
				));
			}

            $sendList 	= $LNG['al_circular_sended'];
			$title		= $LNG['al_circular_alliance'].$this->allianceData['ally_tag'];
			$text		= sprintf($LNG['al_circular_front_text'], $USER['username'])."\r\n".$text;
			
			foreach ($sendUsersResult as $sendUsersRow)
			{
				SendSimpleMessage($sendUsersRow['id'], $USER['id'], TIMESTAMP, 2, $title, $subject, makebr($text));
				$sendList	.= "\n".$sendUsersRow['username'];
			}
				
			$this->sendJSON(array('message' => $sendList, 'error' => false));
		}

		$this->initTemplate();
		$this->setWindow('popup');
		$RangeList[]	= $LNG['al_all_players'];

		if (is_array($this->ranks))
		{
			foreach($this->ranks as $id => $array)
			{
				$RangeList[$id + 1]	= $array['name'];
			}
		}
		
		$this->tplObj->assign_vars(array(
			'RangeList'						=> $RangeList,
		));
		
		$this->display('page.alliance.circular.tpl');
	}
	
	function admin() 
	{
		global $LNG;
		
		$action		= HTTP::_GP('action', 'overview');
		$methodName	= 'admin'.ucwords($action);
		
		if(!is_callable(array($this, $methodName))) {
			ShowErrorPage::printError($LNG['page_doesnt_exist']);
		}

		$this->{$methodName}();
	}
	
	private function adminOverview() 
	{
		global $LNG;
		$send 		= HTTP::_GP('send', 0);
		$textMode  	= HTTP::_GP('textMode', 'external');
		
		if ($send)
		{
            $db = Database::get();

			$this->allianceData['ally_owner_range'] 		= HTTP::_GP('owner_range', '', true);
			$this->allianceData['ally_web'] 				= filter_var(HTTP::_GP('web', ''), FILTER_VALIDATE_URL);
			$this->allianceData['ally_image'] 				= filter_var(HTTP::_GP('image', ''), FILTER_VALIDATE_URL);
			$this->allianceData['ally_request_notallow'] 	= HTTP::_GP('request_notallow', 0);
			$this->allianceData['ally_max_members'] 		= max(HTTP::_GP('ally_max_members', ''), $this->allianceData['ally_members']);
			$this->allianceData['ally_request_min_points']  = filter_var(HTTP::_GP('request_min_points', 0), FILTER_VALIDATE_INT);
			$this->allianceData['ally_stats'] 				= HTTP::_GP('stats', 0);
			$this->allianceData['ally_diplo'] 				= HTTP::_GP('diplo', 0);
			$this->allianceData['ally_events'] 				= implode(',', HTTP::_GP('events', array()));

			$new_ally_tag 	= HTTP::_GP('ally_tag', '', UTF8_SUPPORT);
			$new_ally_name	= HTTP::_GP('ally_name', '', UTF8_SUPPORT);
		
			if(!empty($new_ally_tag) && $this->allianceData['ally_tag'] != $new_ally_tag)
			{
				$sql = "SELECT COUNT(*) as count FROM %%ALLIANCE%% WHERE ally_universe = :universe AND ally_tag = :NewAllianceTag;";
                $allianceCount = $db->selectSingle($sql, array(
                    ':universe'	        => Universe::current(),
                    ':NewAllianceTag'   => $new_ally_tag
                ), 'count');

                if($allianceCount != 0)
				{
					$this->printMessage(sprintf($LNG['al_already_exists'], $new_ally_tag));
				}
				else
				{
					$this->allianceData['ally_tag'] = $new_ally_tag;
				}
			}
			
			if(!empty($new_ally_name) && $this->allianceData['ally_name'] != $new_ally_name)
			{
                $sql = "SELECT COUNT(*) as count FROM %%ALLIANCE%% WHERE ally_universe = :universe AND ally_name = :NewAllianceName;";
                $allianceCount = $db->selectSingle($sql, array(
                    ':universe'	        => Universe::current(),
                    ':NewAllianceName'   => $new_ally_name
                ), 'count');

				if($allianceCount != 0)
				{
					$this->printMessage(sprintf($LNG['al_already_exists'], $new_ally_name));
				}
				else
				{
					$this->allianceData['ally_name'] = $new_ally_name;
				}
			}
			
			if ($this->allianceData['ally_request_notallow'] != 0 && $this->allianceData['ally_request_notallow'] != 1) {
				$this->allianceData['ally_request_notallow']	= 0;
			}

			$text 		= HTTP::_GP('text', '', true);
			$textMode  	= HTTP::_GP('textMode', 'external');
			
			$textSQL	= "";
			
			switch($textMode)
			{
				case 'external':
					$textSQL	= "ally_description = :text, ";
				break;
				case 'internal':
					$textSQL	= "ally_text = :text, ";
				break;
				case 'apply':
					$textSQL	= "ally_request = :text, ";
				break;
			}
			
			$sql = "UPDATE %%ALLIANCE%% SET
			".$textSQL."
			ally_tag = :AllianceTag,
			ally_name = :AllianceName,
			ally_owner_range = :AllianceOwnerRange,
			ally_image = :AllianceImage,
			ally_web = :AllianceImage,
			ally_request_notallow = :AllianceWeb,
			ally_max_members = :AllianceRequestNotallow,
			ally_request_min_points = :AllianceRequestMinpoints,
			ally_stats = :AllianceStats,
			ally_diplo = :AllianceDiplo,
			ally_events = :AllianceEvents
			WHERE id = :AllianceID;";
            $db->update($sql, array(
                ':AllianceTag'				=> $this->allianceData['ally_tag'],
                ':AllianceName'				=> $this->allianceData['ally_name'],
                ':AllianceOwnerRange'		=> $this->allianceData['ally_owner_range'],
                ':AllianceImage'			=> $this->allianceData['ally_image'],
                ':AllianceWeb'				=> $this->allianceData['ally_web'],
                ':AllianceRequestNotallow'	=> $this->allianceData['ally_request_notallow'],
                ':AllianceRequestMinpoints'	=> $this->allianceData['ally_request_min_points'],
                ':AllianceStats'			=> $this->allianceData['ally_stats'],
                ':AllianceDiplo'			=> $this->allianceData['ally_diplo'],
                ':AllianceEvents'			=> $this->allianceData['ally_events'],
                ':AllianceID'				=> $this->allianceData['id'],
                ':text'						=> $text
            ));

		} else {
			switch($textMode)
			{
				case 'internal':
					$text	= $this->allianceData['ally_text'];
				break;
				case 'apply':
					$text	= $this->allianceData['ally_request'];
				break;
				default:
					$text	= $this->allianceData['ally_description'];
				break;
			}
		}
		
		$this->tplObj->assign_vars(array(
			'RequestSelector'			=> array(0 => $LNG['al_requests_allowed'], 1 => $LNG['al_requests_not_allowed']),
			'YesNoSelector'				=> array(1 => $LNG['al_go_out_yes'], 0 => $LNG['al_go_out_no']),
			'textMode' 					=> $textMode,
			'text' 						=> $text,
			'ally_tag' 					=> $this->allianceData['ally_tag'],
			'ally_name'					=> $this->allianceData['ally_name'],
			'ally_web' 					=> $this->allianceData['ally_web'],
			'ally_image'				=> $this->allianceData['ally_image'],
			'ally_request_notallow' 	=> $this->allianceData['ally_request_notallow'],
			'ally_members' 				=> $this->allianceData['ally_members'],
			'ally_max_members' 			=> $this->allianceData['ally_max_members'],
			'ally_request_min_points'   => $this->allianceData['ally_request_min_points'],
			'ally_owner_range'			=> $this->allianceData['ally_owner_range'],
			'ally_stats_data'			=> $this->allianceData['ally_stats'],
			'ally_diplo_data'			=> $this->allianceData['ally_diplo'],
			'ally_events'				=> explode(',', $this->allianceData['ally_events']),
			'aviable_events'			=> $LNG['type_mission']
		));
		
		$this->display('page.alliance.admin.overview.tpl');
	}
	
	private function adminClose() {
		global $USER;
		if ($this->allianceData['ally_owner'] == $USER['id']) {
            $db = Database::get();

            $sql = "UPDATE %%USERS%% SET ally_id = '0' WHERE ally_id = :AllianceID;";
            $db->update($sql, array(
                ':AllianceID'	=> $this->allianceData['id']
            ));

            $sql = "UPDATE %%STATPOINTS%% SET id_ally = '0' WHERE id_ally = :AllianceID;";
            $db->update($sql, array(
                ':AllianceID'	=> $this->allianceData['id']
            ));

            $sql = "DELETE FROM %%STATPOINTS%% WHERE id_owner = :AllianceID AND stat_type = 2;";
            $db->delete($sql, array(
                ':AllianceID'	=> $this->allianceData['id']
            ));

            $sql = "DELETE FROM %%ALLIANCE%% WHERE id = :AllianceID;";
            $db->delete($sql, array(
                ':AllianceID'	=> $this->allianceData['id']
            ));

            $sql = "DELETE FROM %%ALLIANCE_REQUEST%% WHERE allianceID = :AllianceID;";
            $db->delete($sql, array(
                ':AllianceID'	=> $this->allianceData['id']
            ));

            $sql = "DELETE FROM %%DIPLO%% WHERE owner_1 = :AllianceID OR owner_2 = :AllianceID;";
            $db->delete($sql, array(
                ':AllianceID'	=> $this->allianceData['id']
            ));
        }
		
		$this->redirectToHome();
	}
	
	private function adminTransfer()
	{
		global $LNG, $USER;

		if($this->allianceData['ally_owner'] != $USER['id'])
			$this->redirectToHome();
        $db	= Database::get();

		$postleader = HTTP::_GP('newleader', 0);
		if (!empty($postleader))
		{
            $sql = "SELECT ally_rank_id FROM %%USERS%% WHERE id = :LeaderID;";
            $Rank = $db->selectSingle($sql, array(
                ':LeaderID'	=> $postleader
            ));

            $sql = "UPDATE %%USERS%% SET ally_rank_id = :AllyRank WHERE id = :UserID;";
            $db->update($sql, array(
                ':UserID'	=> $USER['id'],
                ':AllyRank' => $Rank['ally_rank_id']
            ));

            $sql = "UPDATE %%USERS%% SET ally_rank_id = 0 WHERE id = :LeaderID;";
            $db->update($sql, array(
                ':LeaderID'	=> $postleader
            ));

            $sql = "UPDATE %%ALLIANCE%% SET ally_owner = :LeaderID WHERE id = :AllianceID;";
            $db->update($sql, array(
                ':LeaderID'	    => $postleader,
                ':AllianceID'   => $this->allianceData['id']
            ));

            $this->redirectToHome();
		}
		else
		{
			$sql = "SELECT u.id, r.rankName, u.username FROM %%USERS%% u INNER JOIN %%ALLIANCE_RANK%% r ON r.rankID = u.ally_rank_id AND r.TRANSFER = 1 WHERE u.ally_id = :allianceID AND id != ':allianceOwner;";
            $transferUserResult = $db->select($sql, array(
                ':allianceOwner'    => $this->allianceData['ally_owner'],
                ':allianceID'       => $this->allianceData['id']
            ));

            $transferUserList	= array();

			foreach ($transferUserResult as $transferUserRow)
			{
				$transferUserList[$transferUserRow['id']]	= $transferUserRow['username']." [".$transferUserRow['rankName']."]";
			}
			
			$this->tplObj->assign_vars(array(
				'transferUserList'	=> $transferUserList,
			));	
			
			$this->display('page.alliance.admin.transfer.tpl');
		}
	}
	
	private function adminMangeApply()
	{
		global $LNG, $USER;
		if(!$this->rights['SEEAPPLY'] || !$this->rights['MANAGEAPPLY']) {
			$this->redirectToHome();
		}

		$db = Database::get();

        $sql = "SELECT applyID, u.username, r.time FROM %%ALLIANCE_REQUEST%% r INNER JOIN %%USERS%% u ON r.userID = u.id WHERE r.allianceID = :allianceID;";
        $applyResult = $db->select($sql, array(
            ':allianceID'	=> $this->allianceData['id']
        ));

        $applyList		= array();
		
		foreach ($applyResult as $applyRow)
		{
			$applyList[]	= array(
				'username'	=> $applyRow['username'],
				'id'		=> $applyRow['applyID'],
				'time' 		=> _date($LNG['php_tdformat'], $applyRow['time'], $USER['timezone']),
			);
		}
		
		$this->tplObj->assign_vars(array(
			'applyList'		=> $applyList,
		));
		
		$this->display('page.alliance.admin.mangeApply.tpl');
	}
	
	private function adminDetailApply()
	{
		global $LNG, $USER;
		if(!$this->rights['SEEAPPLY'] || !$this->rights['MANAGEAPPLY']) {
			$this->redirectToHome();
		}

		$id    = HTTP::_GP('id', 0);

        $db = Database::get();

		$sql = '
		SELECT
			r.`applyID`,
			r.`time`,
			r.`text`,
			u.`username`,
			u.`register_time`,
			u.`onlinetime`,
			u.`galaxy`,
			u.`system`,
			u.`planet`,
			CONCAT_WS(\':\', u.`galaxy`, u.`system`, u.`planet`) AS `coordinates`,
			@total_fights := u.`wons` + u.`loos` + u.`draws`,
			@total_fights_percentage := @total_fights / 100,
			@total_fights AS `total_fights`,
			u.`wons`,
			ROUND(u.`wons` / @total_fights_percentage, 2) AS `wons_percentage`,
			u.`loos`,
			ROUND(u.`loos` / @total_fights_percentage, 2) AS `loos_percentage`,
			u.`draws`,
			ROUND(u.`draws` / @total_fights_percentage, 2) AS `draws_percentage`,
			u.`kbmetal`,
			u.`kbcrystal`,
			u.`lostunits`,
			u.`desunits`,
			stat.`tech_rank`,
			stat.`tech_points`,
			stat.`build_rank`,
			stat.`build_points`,
			stat.`defs_rank`,
			stat.`defs_points`,
			stat.`fleet_rank`,
			stat.`fleet_points`,
			stat.`total_rank`,
			stat.`total_points`,
			p.`name`
		FROM
			%%ALLIANCE_REQUEST%% AS r
		LEFT JOIN
			%%USERS%% AS u ON r.userID = u.id
		INNER JOIN
			%%STATPOINTS%% AS stat
		LEFT JOIN
			%%PLANETS%% AS p ON p.id = u.id_planet
		WHERE
			applyID = :applyID;';

        $applyDetail = $db->selectSingle($sql, array(
            ':applyID'	=> $id
        ));

        if(empty($applyDetail)) {
			$this->printMessage($LNG['al_apply_not_exists']);
		}
		
		require_once('includes/functions/BBCode.php');
		$applyDetail['text']    	= bbcode($applyDetail['text']);
		$applyDetail['kbmetal']    	= pretty_number($applyDetail['kbmetal']);
		$applyDetail['kbcrystal']   = pretty_number($applyDetail['kbcrystal']);
		$applyDetail['lostunits']   = pretty_number($applyDetail['lostunits']);
		$applyDetail['desunits']    = pretty_number($applyDetail['desunits']);
		
		$this->tplObj->assign_vars(array(
			'applyDetail'	=> $applyDetail,
			'apply_time'    => _date($LNG['php_tdformat'], $applyDetail['time'], $USER['timezone']),
			'register_time' => _date($LNG['php_tdformat'], $applyDetail['register_time'], $USER['timezone']),
			'onlinetime'    => _date($LNG['php_tdformat'], $applyDetail['onlinetime'], $USER['timezone']),
		));
		
		$this->display('page.alliance.admin.detailApply.tpl');
	}
	
	private function adminSendAnswerToApply()
	{
		global $LNG, $USER;
		if(!$this->rights['SEEAPPLY'] || !$this->rights['MANAGEAPPLY']) {
			$this->redirectToHome();
		}

		$db = Database::get();

        $text  		= makebr(HTTP::_GP('text', '', true));
		$answer		= HTTP::_GP('answer', '');
		$applyID	= HTTP::_GP('id', 0);

        $sql = "SELECT id FROM %%ALLIANCE_REQUEST%% LEFT JOIN %%USERS%% ON userID = id WHERE applyID = :applyID;";
        $userID = $db->selectSingle($sql, array(
            ':applyID'	=> $applyID
        ), 'id');

		if ($answer == 'yes')
		{
			$sql = "DELETE FROM %%ALLIANCE_REQUEST%% WHERE applyID = :applyID";
            $db->delete($sql, array(
                ':applyID'	=> $applyID
            ));

            $sql = "UPDATE %%USERS%% SET ally_id = :allianceID, ally_register_time = :time, ally_rank_id = 0 WHERE id = :userID;";
            $db->update($sql, array(
                ':allianceID'	=> $this->allianceData['id'],
                ':time'         => TIMESTAMP,
                ':userID'       => $userID
            ));

            $sql = "UPDATE %%STATPOINTS%% SET id_ally = :allianceID WHERE id_owner = :userID AND stat_type = 1;";
            $db->update($sql, array(
                ':allianceID'	=> $this->allianceData['id'],
                ':userID'       => $userID
            ));

            $sql = "UPDATE %%ALLIANCE%% SET ally_members = (SELECT COUNT(*) FROM %%USERS%% WHERE ally_id = :allianceID) WHERE id = :allianceID;";
            $db->update($sql, array(
                ':allianceID'	=> $this->allianceData['id'],
            ));

            SendSimpleMessage($userID, $USER['id'], TIMESTAMP, 2, $this->allianceData['ally_tag'], $LNG['al_you_was_acceted'] . $this->allianceData['ally_name'], $LNG['al_hi_the_alliance'] . $this->allianceData['ally_name'] . $LNG['al_has_accepted'] . $text);
		}
		elseif($answer == 'no')
		{
            $sql = "DELETE FROM %%ALLIANCE_REQUEST%% WHERE applyID = :applyID";
            $db->delete($sql, array(
                ':applyID'	=> $applyID
            ));

            SendSimpleMessage($userID, $USER['id'], TIMESTAMP, 2, $this->allianceData['ally_tag'], $LNG['al_you_was_declined'] . $this->allianceData['ally_name'], $LNG['al_hi_the_alliance'] . $this->allianceData['ally_name'] . $LNG['al_has_declined'] . $text);
		}

		$this->redirectTo('game.php?page=alliance&mode=admin&action=mangeApply');
	}
	
	private function adminPermissions()
	{	
		if(!$this->rights['RANKS']) {
			$this->redirectToHome();
		}

        $db = Database::get();

        $sql = "SELECT * FROM %%ALLIANCE_RANK%% WHERE allianceID = :allianceID;";
        $rankResult =  $db->select($sql, array(
            ':allianceID'	=> $this->allianceData['id']
        ));

        $rankList	= array();
		
		foreach ($rankResult as $rankRow)
			$rankList[$rankRow['rankID']]	= $rankRow;
		
		$this->tplObj->assign_vars(array(
			'rankList'		=> $rankList,
			'ownRights'		=> $this->rights,
			'avalibleRanks'	=> $this->avalibleRanks,
		));	

		$this->display('page.alliance.admin.permissions.tpl');
	}
	
	private function adminPermissionsSend()
	{	
		if(!$this->rights['RANKS']) {
			$this->redirectToHome();
		}
		
		$newrank	= HTTP::_GP('newrank', array(), true);
		$delete		= HTTP::_GP('deleteRank', 0);
		$rankData	= HTTP::_GP('rank', array());

        $db = Database::get();

		if(!empty($newrank['rankName'])) 
		{
			$sql = "INSERT INTO `".ALLIANCE_RANK."` SET "; 

			foreach($newrank as $key => $value)
				$sql .= "`" . $GLOBALS['DATABASE']->sql_escape($key) ."` = '" . $GLOBALS['DATABASE']->sql_escape($value) . "',";
		
			$sql .= "`allianceID` = ".$this->allianceData['id']."";
				
			$GLOBALS['DATABASE']->query($sql);
		} else {
			if(!empty($delete)) 
			{
				$sql = "DELETE FROM %%ALLIANCE_RANK%% WHERE rankID = :rankID AND allianceID = :allianceID;";
                $db->delete($sql, array(
                    ':allianceID'	=> $this->allianceData['id'],
                    ':rankID'       => $delete
                ));
                $sql = "UPDATE %%USERS%% SET ally_rank_id = 0 WHERE ally_rank_id = :rankID AND ally_id = :allianceID;";
                $db->update($sql, array(
                    ':allianceID'	=> $this->allianceData['id'],
                    ':rankID'       => $delete
                ));
			}
			else
			{
				$Query = '';
				foreach ($rankData as $k => $rankRow)
				{
					$SQL	= array();
					foreach($this->avalibleRanks as $rankName) 
					{
						if(!$this->rights[$rankName])
							continue;
						
						$SQL[]	= $rankName." = ".(isset($rankRow[$rankName]) ? 1 : 0);
					}
					$SQL[]	= "rankName = '".$GLOBALS['DATABASE']->sql_escape($rankRow['name'])."'";
					$Query .= "UPDATE ".ALLIANCE_RANK." SET ".implode(", ", $SQL)." WHERE rankID = ".((int) $GLOBALS['DATABASE']->sql_escape($k))." AND allianceID = ".$this->allianceData['id'].";";
				}
				$GLOBALS['DATABASE']->multi_query($Query);
			}
		}
		
		$this->redirectTo('game.php?page=alliance&mode=admin&action=permissions');
	}
	
	private function adminMembers()
	{
		global $USER, $LNG;
		if (!$this->rights['MANAGEUSERS']) {
			$this->redirectToHome();
		}
		
		$db = Database::get();

        $sql = "SELECT rankID, rankName FROM %%ALLIANCE_RANK%% WHERE allianceID = :allianceID;";
        $rankResult = $db->select($sql, array(
            ':allianceID'	=> $this->allianceData['id'],
        ));

        $rankList		= array();
		$rankList[0]	= $LNG['al_new_member_rank_text'];
		
		foreach ($rankResult as $rankRow)
			$rankList[$rankRow['rankID']]	= $rankRow['rankName'];
		
		$sql = "SELECT DISTINCT u.id, u.username,u.galaxy, u.system, u.planet, u.ally_register_time, u.onlinetime, u.ally_rank_id, s.total_points
										FROM %%USERS%% u
										LEFT JOIN %%STATPOINTS%% as s ON s.stat_type = '1' AND s.id_owner = u.id
										WHERE ally_id = :allianceID;";
        $memberListResult = $db->select($sql, array(
            ':allianceID'	=> $this->allianceData['id'],
        ));

		$memberList	= array();
										
		foreach ($memberListResult as $memberListRow)
		{
			if ($this->allianceData['ally_owner'] == $memberListRow['id'])
				$memberListRow['ally_rank_id'] = -1;
			elseif ($memberListRow['ally_rank_id'] != 0)
				$memberListRow['ally_rank_id'] = $memberListRow['ally_rank_id'];
			else
				$memberListRow['ally_rank_id'] = 0;
			
			$memberList[$memberListRow['id']]	= array(
				'username'		=> $memberListRow['username'],
				'galaxy'		=> $memberListRow['galaxy'],
				'system'		=> $memberListRow['system'],
				'planet'		=> $memberListRow['planet'],
				'register_time'	=> _date($LNG['php_tdformat'], $memberListRow['ally_register_time'], $USER['timezone']),
				'points'		=> $memberListRow['total_points'],
				'rankID'		=> $memberListRow['ally_rank_id'],
				'onlinetime'	=> floor((TIMESTAMP - $memberListRow['onlinetime']) / 60),
				'kickQuestion'	=> sprintf($LNG['al_kick_player'], $memberListRow['username'])
			);
		}
		
		$this->tplObj->assign_vars(array(
			'memberList'	=> $memberList,
			'rankList'		=> $rankList,
			'founder'		=> empty($this->allianceData['ally_owner_range']) ? $LNG['al_founder_rank_text'] : $this->allianceData['ally_owner_range'],
			'al_users_list'	=> sprintf($LNG['al_users_list'], count($memberList)),
			'canKick'		=> $this->rights['KICK'],
		));
		
		$this->display('page.alliance.admin.members.tpl');
	}
	
	private function adminMembersSave()
	{
		if (!$this->rights['MANAGEUSERS']) {
			$this->redirectToHome();
		}

        $db = Database::get();

		$rankResult		= $GLOBALS['DATABASE']->query("SELECT rankID, ".implode(", ", $this->avalibleRanks)." FROM ".ALLIANCE_RANK." WHERE allianceID = ".$this->allianceData['id'].";");
		$rankList		= array();
		$rankList[0]	= array_combine($this->avalibleRanks, array_fill(0, count($this->avalibleRanks), true));
		
		while($rankRow = $GLOBALS['DATABASE']->fetch_array($rankResult))
			$rankList[$rankRow['rankID']]	= $rankRow;
			
		$userRanks	= HTTP::_GP('rank', array());
		foreach($userRanks as $userID => $rankID) {
			if($userID == $this->allianceData['ally_owner'] || !isset($rankList[$rankID])) {
				continue;
			}
			
			unset($rankList[$rankID]['rankID']);
			
			foreach($rankList[$rankID] as $permission => $value) {
				if($this->rights[$permission] < $value)
					continue;
			}

            $sql = "UPDATE %%USERS%% SET ally_rank_id = :rankID WHERE id = :userID AND ally_id = :allianceID;";
            $db->update($sql, array(
                ':allianceID'	=> $this->allianceData['id'],
                ':rankID'       => (int) $rankID,
                ':userID'       => (int) $userID
            ));
		}
		
		$this->redirectTo('game.php?page=alliance&mode=admin&action=members');
	}
	
	private function adminMembersKick()
	{
		if (!$this->rights['KICK']) {
			$this->redirectToHome();
		}

        $db = Database::get();

		$id	= HTTP::_GP('id', 0);

        $sql = "UPDATE %%USERS%% SET ally_id = 0, ally_register_time = 0, ally_rank_id = 0 WHERE id = :id;";
        $db->update($sql, array(
            ':id'	=> $id
        ));

        $sql = "UPDATE %%STATPOINTS%% SET id_ally = 0 WHERE id_owner = :id AND stat_type = 1;";
        $db->update($sql, array(
            ':id'	=> $id
        ));

        $sql = "UPDATE %%ALLIANCE%% SET ally_members = (SELECT COUNT(*) FROM %%USERS%% WHERE ally_id = :allianceID) WHERE id = :allianceID;";
        $db->update($sql, array(
            ':id'	        => $id,
            ':allianceID'   => $this->allianceData['id']
        ));

        $this->redirectTo('game.php?page=alliance&mode=admin&action=members');
	}
	
	private function adminDiplomacy()
	{
		if (!$this->rights['DIPLOMATIC']) {
			$this->redirectToHome();
		}

        $db = Database::get();
		
		$diploList	= array(
			0 => array(
				1 => array(),
				2 => array(),
				3 => array(),
				4 => array(),
				5 => array(),
				6 => array()
			),
			1 => array(
				1 => array(),
				2 => array(),
				3 => array(),
				4 => array(),
				5 => array(),
				6 => array()
			),
			2 => array(
				1 => array(),
				2 => array(),
				3 => array(),
				4 => array(),
				5 => array(),
				6 => array()
			)
		);

        $sql = "SELECT d.id, d.level, d.accept, d.owner_1, d.owner_2, a.ally_name FROM %%DIPLO%% d
		INNER JOIN %%ALLIANCE%% a ON IF(:allianceID = d.owner_1, a.id = d.owner_2, a.id = d.owner_1)
		WHERE owner_1 = :allianceID OR owner_2 = :allianceID;";
        $diploResult =  $db->select($sql, array(
            ':allianceID'   => $this->allianceData['id']
        ));

		foreach($diploResult as $diploRow) {
			$own	= $diploRow['owner_1'] == $this->allianceData['id'];
			if($diploRow['accept'] == 1) {
				$diploList[0][$diploRow['level']][$diploRow['id']] = $diploRow['ally_name'];
			} elseif($own) {
				$diploList[2][$diploRow['level']][$diploRow['id']] = $diploRow['ally_name'];
			} else {
				$diploList[1][$diploRow['level']][$diploRow['id']] = $diploRow['ally_name'];
			}
		}
		
		$this->tplObj->assign_vars(array(
			'diploList'	=> $diploList,
		));
		
		$this->display('page.alliance.admin.diplomacy.default.tpl');
	}
	
	private function adminDiplomacyAccept()
	{
		if (!$this->rights['DIPLOMATIC']) {
			$this->redirectToHome();
		}

        $db = Database::get();

        $sql = "UPDATE %%DIPLO%% SET accept = 1 WHERE id = :id AND owner_2 = :allianceID;";
        $db->update($sql, array(
            ':allianceID'   => $this->allianceData['id'],
            ':id'           => HTTP::_GP('id', 0)
        ));

        $this->redirectTo('game.php?page=alliance&mode=admin&action=diplomacy');
	}
	
	private function adminDiplomacyDelete()
	{
		if (!$this->rights['DIPLOMATIC']) {
			$this->redirectToHome();
		}

        $db = Database::get();

        $sql = "DELETE FROM %%DIPLO%% WHERE id = :id AND (owner_1 = :allianceID OR owner_2 = :allianceID);";
        $db->update($sql, array(
            ':allianceID'   => $this->allianceData['id'],
            ':id'           => HTTP::_GP('id', 0)
        ));

        $this->redirectTo('game.php?page=alliance&mode=admin&action=diplomacy');
	}
	
	private function adminDiplomacyCreate()
	{
		global $USER;
		if (!$this->rights['DIPLOMATIC']) {
			$this->redirectToHome();
		}

        $db = Database::get();
		
		$this->initTemplate();
		$this->setWindow('popup');
		
		$diploMode	= HTTP::_GP('diploMode', 0);

        $sql = "SELECT ally_tag,ally_name,id FROM %%ALLIANCE%% WHERE id != :allianceID ORDER BY ally_tag ASC;";
        $diploAlly = $db->select($sql, array(
            ':allianceID'   => $USER['ally_id']
        ));

        $AllyList = array();
		$IdList = array();
		foreach ($diploAlly as $i)
		{
			$IdList[] = $i['id'];
			$AllyList[] = $i['ally_name'];
		}
		$this->tplObj->assign_vars(array(
			'diploMode'	=> $diploMode,
			'AllyList'	=> $AllyList,
			'IdList'	=> $IdList,
		));
		
		$this->display('page.alliance.admin.diplomacy.create.tpl');
	}
	
	private function adminDiplomacyCreateProcessor()
	{
		global $LNG, $USER;
		if (!$this->rights['DIPLOMATIC']) {
			$this->redirectToHome();
		}

        $db = Database::get();

		$id	= HTTP::_GP('ally_id', '', UTF8_SUPPORT);

        $sql = "SELECT id, ally_name, ally_owner, ally_tag, (SELECT level FROM %%DIPLO%% WHERE (owner_1 = :id AND owner_2 = :allianceID) OR (owner_2 = :id AND owner_1 = :allianceID)) as diplo FROM %%ALLIANCE%% WHERE ally_universe = :universe AND id = :id;";
        $targetAlliance = $db->selectSingle($sql, array(
            ':allianceID'   => $USER['ally_id'],
            ':id'           => $id,
            ':universe'     => Universe::current()
        ));

        if(empty($targetAlliance)) {
			$this->sendJSON(array(
				'error'		=> true,
				'message'	=> sprintf($LNG['al_diplo_no_alliance'], $targetAlliance['id']),
			));	
		}
		
		if(!empty($targetAlliance['diplo'])) {
			$this->sendJSON(array(
				'error'		=> true,
				'message'	=> sprintf($LNG['al_diplo_exists'], $targetAlliance['ally_name']),
			));	
		}
		if($targetAlliance['id'] == $this->allianceData['id']) {
			$this->sendJSON(array(
				'error'		=> true,
				'message'	=> $LNG['al_diplo_same_alliance'],
			));	
		}
		
		$this->setWindow('ajax');
		
		$level	= HTTP::_GP('level', 0);
		$text	= HTTP::_GP('text', '', true);
		
		if($level == 5)
		{
			SendSimpleMessage($targetAlliance['ally_owner'], $USER['id'], TIMESTAMP, 1, $LNG['al_circular_alliance'].$this->allianceData['ally_tag'], $LNG['al_diplo_war'], sprintf($LNG['al_diplo_war_mes'], "[".$this->allianceData['ally_tag']."] ".$this->allianceData['ally_name'], "[".$targetAlliance['ally_tag']."] ".$targetAlliance['ally_name'], $LNG['al_diplo_level'][$level], $text));
		}
		else
		{
			SendSimpleMessage($targetAlliance['ally_owner'], $USER['id'], TIMESTAMP, 1, $LNG['al_circular_alliance'].$this->allianceData['ally_tag'], $LNG['al_diplo_ask'], sprintf($LNG['al_diplo_ask_mes'], $LNG['al_diplo_level'][$level], "[".$this->allianceData['ally_tag']."] ".$this->allianceData['ally_name'], "[".$targetAlliance['ally_tag']."] ".$targetAlliance['ally_name'], $text));
		}
		
		$sql = "INSERT INTO %%DIPLO%% SET owner_1 = :allianceID, owner_2 = :allianceTargetID, level	= :level, accept = 0, accept_text = :text, universe	= :universe";
        $db->insert($sql, array(
            ':allianceID'   => $USER['ally_id'],
            ':allianceTargetID'  => $targetAlliance['id'],
            ':level'             => $level,
            ':text'           => $text,
            ':universe'     => Universe::current()
        ));

        $this->sendJSON(array(
			'error'		=> false,
			'message'	=> $LNG['al_diplo_create_done'],
		));
	}
}