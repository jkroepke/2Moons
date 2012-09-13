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
		$this->allianceData	= $GLOBALS['DATABASE']->uniquequery("SELECT * FROM ".ALLIANCE." WHERE id = ".$allianceID.";");
		
		if($USER['ally_id'] == $allianceID)
		{
			if ($this->allianceData['ally_owner'] == $USER['id']) {
				$this->rights	= array_combine($this->avalibleRanks, array_fill(0, count($this->avalibleRanks), true));
			} elseif($USER['ally_rank_id'] != 0) {
				$this->rights	= $GLOBALS['DATABASE']->uniquequery("SELECT ".implode(", ", $this->avalibleRanks)." FROM ".ALLIANCE_RANK." WHERE allianceID = ".$allianceID." AND rankID = ".$USER['ally_rank_id'].";");
			}
			
			if(!isset($this->rights)) {
				$this->rights	= array_combine($this->avalibleRanks, array_fill(0, count($this->avalibleRanks), false));
			}
		
			if(isset($this->tplObj))
			{
				$this->tplObj->assign_vars(array(
					'rights'		=> $this->rights,
					'AllianceOwner'	=> $USER['ally_rank_id'] == 0,
				));
			}
		}
	}
	
	private function isApply()
	{
		global $USER;
		return $GLOBALS['DATABASE']->countquery("SELECT COUNT(*) FROM ".ALLIANCE_REQUEST." WHERE userID = ".$USER['id'].";");
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
		
		require_once(ROOT_PATH.'includes/functions/BBCode.php');
		
		if ($this->allianceData['ally_diplo'] == 1)
		{
			$this->tplObj->assign_vars(array(
				'DiploInfo'			=> $this->getDiplomatic(),
			));
		}
		
		if ($this->allianceData['ally_stats'] == 1)
		{
			$StatsData 					= $GLOBALS['DATABASE']->uniquequery("SELECT SUM(wons) as wons, SUM(loos) as loos, SUM(draws) as draws, SUM(kbmetal) as kbmetal, SUM(kbcrystal) as kbcrystal, SUM(lostunits) as lostunits, SUM(desunits) as desunits FROM ".USERS." WHERE ally_id='" . $this->allianceData['id'] . "';");

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
			'ally_description' 			=> bbcode($this->allianceData['ally_description']),
			'ally_id'	 				=> $this->allianceData['id'],
			'ally_image' 				=> $this->allianceData['ally_image'],
			'ally_web'					=> $this->allianceData['ally_web'],
			'ally_member_scount' 		=> $this->allianceData['ally_members'],
			'ally_name' 				=> $this->allianceData['ally_name'],
			'ally_tag' 					=> $this->allianceData['ally_tag'],
			'ally_stats' 				=> $this->allianceData['ally_stats'],
			'ally_diplo' 				=> $this->allianceData['ally_diplo'],
			'ally_request'          	=> !$this->hasAlliance && !$this->hasApply && $this->allianceData['ally_request_notallow'] == 0,
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
		
		$allianceResult = $GLOBALS['DATABASE']->uniquequery("SELECT a.ally_tag FROM ".ALLIANCE_REQUEST." r INNER JOIN ".ALLIANCE." a ON a.id = r.allianceID WHERE r.userID = ".$USER['id'].";");
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
		global $UNI;
		if($this->hasApply) {
			$this->redirectToHome();
		}
		
		$searchText	= HTTP::_GP('searchtext', '', UTF8_SUPPORT);
		$searchList	= array();

		if (!empty($searchText))
		{
			$searchResult = $GLOBALS['DATABASE']->query("SELECT 
			id, ally_name, ally_tag, ally_members
			FROM ".ALLIANCE."
			WHERE ally_universe = ".$UNI." AND ally_name LIKE '%".$GLOBALS['DATABASE']->sql_escape($searchText, true)."%'
			ORDER BY (
			  IF(ally_name = '".$GLOBALS['DATABASE']->sql_escape($searchText, true)."', 1, 0)
			  + IF(ally_name LIKE '".$GLOBALS['DATABASE']->sql_escape($searchText, true)."%', 1, 0)
			) DESC,ally_name ASC LIMIT 25;");
			
			while($searchRow = $GLOBALS['DATABASE']->fetch_array($searchResult))
			{
				$searchList[]	= array(
					'id'		=> $searchRow['id'],
					'tag'		=> $searchRow['ally_tag'],
					'members'	=> $searchRow['ally_members'],
					'name'		=> $searchRow['ally_name'],
				);
			}
			
			$GLOBALS['DATABASE']->free_result($searchResult);
		}
		
		$this->tplObj->assign_vars(array(
			'searchText'	=> $searchText,
			'searchList'	=> $searchList,
		));	
		
		$this->display('page.alliance.search.tpl');	
	}
	
	function apply()
	{
		global $UNI, $LNG, $USER;
		
		if($this->hasApply) {
			$this->redirectToHome();
		}
		
		$text		= HTTP::_GP('text' , '', true);
		$allianceID	= HTTP::_GP('id', 0);
			
		$allianceResult = $GLOBALS['DATABASE']->uniquequery("SELECT ally_tag, ally_request, ally_request_notallow FROM ".ALLIANCE." WHERE id = ".$allianceID." AND ally_universe = ".$UNI.";");

		if (!isset($allianceResult)) {
			$this->redirectToHome();
		}
		
		if($allianceResult['ally_request_notallow'] == 1)
		{
			$this->printMessage($LNG['al_alliance_closed']);
		}
		
		if (!empty($text))
		{
			$GLOBALS['DATABASE']->query("INSERT INTO ".ALLIANCE_REQUEST." SET 
			allianceID = ".$allianceID.", 
			text = '".$GLOBALS['DATABASE']->sql_escape($text)."', 
			time = ".TIMESTAMP.", 
			userID = ".$USER['id'].";");

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
		global $UNI, $LNG, $USER;
		
		if(!$this->hasApply) {
			$this->redirectToHome();
		}
		
		$allyquery 	= $GLOBALS['DATABASE']->uniquequery("SELECT a.ally_tag FROM ".ALLIANCE_REQUEST." r INNER JOIN ".ALLIANCE." a ON a.id = r.allianceID WHERE r.userID = ".$USER['id'].";");
		$GLOBALS['DATABASE']->query("DELETE FROM ".ALLIANCE_REQUEST." WHERE userID = ".$USER['id'].";");
		
		$this->printMessage(sprintf($LNG['al_request_deleted'], $allyquery['ally_tag']));
	}
	
	function create()
	{
		if($this->hasApply) {
			$this->redirectToHome();
		}
		
		$action	= $this->getAction();
		if($action == "send") {
			$this->createAlliance();
		} else {
			$this->display('page.alliance.create.tpl');
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
		global $USER, $UNI, $LNG;
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
		
		$allianceCount = $GLOBALS['DATABASE']->countquery("SELECT COUNT(*) FROM ".ALLIANCE." WHERE ally_universe = ".$UNI." AND (ally_tag = '".$GLOBALS['DATABASE']->sql_escape($atag)."' OR ally_name = '".$GLOBALS['DATABASE']->sql_escape($aname)."');");

		if ($allianceCount != 0) {
			$this->printMessage(sprintf($LNG['al_already_exists'], $aname), true, array("?page=alliance&mode=create", 3));
		}
		
		$GLOBALS['DATABASE']->multi_query("INSERT INTO ".ALLIANCE." SET
						ally_name				= '".$GLOBALS['DATABASE']->sql_escape($aname)."',
						ally_tag				= '".$GLOBALS['DATABASE']->sql_escape($atag)."' ,
						ally_owner				= ".$USER['id'].",
						ally_owner_range		= '".$LNG['al_default_leader_name']."',
						ally_members			= 1,
						ally_register_time		= ".TIMESTAMP.",
						ally_universe 			= ".$UNI.";
						SET @allianceID = LAST_INSERT_ID();
						UPDATE ".USERS." SET
						ally_id					= @allianceID,
						ally_register_time 		= ".TIMESTAMP."
						WHERE id = ".$USER['id'].";
						UPDATE ".STATPOINTS." SET
						id_ally 				= @allianceID
						WHERE id_owner = ".$USER['id'].";");
						
		$this->printMessage(sprintf($LNG['al_created'], $aname.' ['.$atag.']'), true, array("?page=alliance", 3));
	}
	
	private function getDiplomatic()
	{
		$Return	= array();
		$Diplos	= $GLOBALS['DATABASE']->query("SELECT d.level, d.accept, d.accept_text, d.id, a.id as ally_id, a.ally_name, a.ally_tag, d.owner_1, d.owner_2 FROM ".DIPLO." as d INNER JOIN ".ALLIANCE." as a ON IF(".$this->allianceData['id']." = d.owner_1, a.id = d.owner_2, a.id = d.owner_1) WHERE ".$this->allianceData['id']." = d.owner_1 OR ".$this->allianceData['id']." = d.owner_2");
		while($CurDiplo = $GLOBALS['DATABASE']->fetch_array($Diplos))
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
		global $USER, $UNI, $LNG;
		require_once(ROOT_PATH.'includes/functions/BBCode.php');
		
		if ($this->allianceData['ally_owner'] == $USER['id']) {
			$rankName	= ($this->allianceData['ally_owner_range'] != '') ? $this->allianceData['ally_owner_range'] : $LNG['al_founder_rank_text'];
		} elseif ($USER['ally_rank_id'] != 0) {
			$rankName	= $GLOBALS['DATABASE']->countquery("SELECT rankName FROM ".ALLIANCE_RANK." WHERE rankID = ".$USER['ally_rank_id'].";");	
		}
		
		if (empty($rankName)) {
			$rankName	= $LNG['al_new_member_rank_text'];
		}
		
		$StatsData 					= $GLOBALS['DATABASE']->uniquequery("SELECT SUM(wons) as wons, SUM(loos) as loos, SUM(draws) as draws, 
														SUM(kbmetal) as kbmetal, SUM(kbcrystal) as kbcrystal, 
														SUM(lostunits) as lostunits, SUM(desunits) as desunits 
														FROM ".USERS." WHERE ally_id = ".$this->allianceData['id'].";");
														
		$ApplyCount					= $GLOBALS['DATABASE']->countquery("SELECT COUNT(*) FROM ".ALLIANCE_REQUEST." WHERE allianceID = ".$this->allianceData['id'].";");
		
		$this->tplObj->assign_vars(array(
			'DiploInfo'					=> $this->getDiplomatic(),
			'ally_web'					=> $this->allianceData['ally_web'],
			'ally_tag'	 				=> $this->allianceData['ally_tag'],
			'ally_members'	 			=> $this->allianceData['ally_members'],
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
		));
		
		$this->display('page.alliance.home.tpl');
	}
	
	function memberList()
	{
		global $USER, $LNG;
		if (!$this->rights['MEMBERLIST']) {
			$this->redirectToHome();
		}
		
		$rankResult	= $GLOBALS['DATABASE']->query("SELECT rankID, rankName FROM ".ALLIANCE_RANK." WHERE allianceID = ".$this->allianceData['id'].";");
		$rankList	= array();
		
		while($rankRow = $GLOBALS['DATABASE']->fetch_array($rankResult))
			$rankList[$rankRow['rankID']]	= $rankRow['rankName'];
		
		$GLOBALS['DATABASE']->free_result($rankResult);
		
		$memberListResult = $GLOBALS['DATABASE']->query("SELECT DISTINCT u.id, u.username,u.galaxy, u.system, u.planet, u.ally_register_time, u.onlinetime, u.ally_rank_id, s.total_points 
										FROM ".USERS." u
										LEFT JOIN ".STATPOINTS." as s ON s.stat_type = '1' AND s.id_owner = u.id 
										WHERE ally_id = ".$this->allianceData['id'].";");

		$memberList	= array();
										
		while ($memberListRow = $GLOBALS['DATABASE']->fetch_array($memberListResult))
		{
			if ($this->allianceData['ally_owner'] == $memberListRow['id'])
				$memberListRow['ally_rankName'] = empty($this->allianceData['ally_owner_range']) ? $LNG['al_founder_rank_text'] : $this->allianceData['ally_owner_range'];
			elseif ($memberListRow['ally_rank_id'] != 0 && $rankList[$memberListRow['ally_rank_id']])
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
		
		$GLOBALS['DATABASE']->free_result($memberListResult);
		
		$this->tplObj->assign_vars(array(
			'memberList'		=> $memberList,
			'al_users_list'		=> sprintf($LNG['al_users_list'], count($memberList)),
		));
		
		$this->display('page.alliance.memberList.tpl');
	}
	
	function close()
	{
		global $USER, $LNG;
		
		$GLOBALS['DATABASE']->multi_query("
		UPDATE ".USERS." SET ally_id = 0, ally_register_time = 0, ally_register_time = 5 WHERE id = ".$USER['id'].";
		UPDATE ".STATPOINTS." SET id_ally = 0 WHERE id_owner = ".$USER['id']." AND stat_type = 1;
		UPDATE ".ALLIANCE." SET ally_members = (SELECT COUNT(*) FROM ".USERS." WHERE ally_id = ".$this->allianceData['id'].") WHERE id = ".$this->allianceData['id'].";");
		
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
			
			if($rankID == 0) {
				$sendUsersResult	= $GLOBALS['DATABASE']->query("SELECT id, username FROM ".USERS." WHERE ally_id = ".$this->allianceData['id'].";");
			} else {
				$sendUsersResult	= $GLOBALS['DATABASE']->query("SELECT id, username FROM ".USERS." WHERE ally_id = ".$this->allianceData['id']." AND ally_rank_id = ".$rankID.";");
			}
			
			$sendList 	= $LNG['al_circular_sended'];
			$title		= $LNG['al_circular_alliance'].$this->allianceData['ally_tag'];
			$text		= sprintf($LNG['al_circular_front_text'], $USER['username'])."\r\n".$text;
			
			while ($sendUsersRow = $GLOBALS['DATABASE']->fetch_array($sendUsersResult))
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
			$this->allianceData['ally_owner_range'] 		= HTTP::_GP('owner_range', '', true);
			$this->allianceData['ally_web'] 				= filter_var(HTTP::_GP('web', ''), FILTER_VALIDATE_URL);
			$this->allianceData['ally_image'] 				= filter_var(HTTP::_GP('image', ''), FILTER_VALIDATE_URL);
			$this->allianceData['ally_request_notallow'] 	= HTTP::_GP('request_notallow', 0);
			$this->allianceData['ally_stats'] 				= HTTP::_GP('stats', 0);
			$this->allianceData['ally_diplo'] 				= HTTP::_GP('diplo', 0);

			if ($this->allianceData['ally_request_notallow'] != 0 && $this->allianceData['ally_request_notallow'] != 1) {
				$this->allianceData['ally_request_notallow']	= 0;
			}

			$text 		= HTTP::_GP('text', '', true);
			$textMode  	= HTTP::_GP('textMode', 'external');
			
			$textSQL	= "";
			
			switch($textMode)
			{
				case 'external':
					$textSQL	= "ally_description = '".$GLOBALS['DATABASE']->sql_escape($text)."', ";
				break;
				case 'internal':
					$textSQL	= "ally_text = '".$GLOBALS['DATABASE']->sql_escape($text)."', ";
				break;
				case 'apply':
					$textSQL	= "ally_request = '".$GLOBALS['DATABASE']->sql_escape($text)."', ";
				break;
			}
			
			$GLOBALS['DATABASE']->query("UPDATE ".ALLIANCE." SET
			".$textSQL."
			ally_owner_range = '".$GLOBALS['DATABASE']->sql_escape($this->allianceData['ally_owner_range'])."',
			ally_image = '".$GLOBALS['DATABASE']->sql_escape($this->allianceData['ally_image'])."',
			ally_web = '".$GLOBALS['DATABASE']->sql_escape($this->allianceData['ally_web'])."',
			ally_request_notallow = ".$this->allianceData['ally_request_notallow'].",
			ally_stats = ".$this->allianceData['ally_stats'].",
			ally_diplo = ".$this->allianceData['ally_diplo']."
			WHERE id = ".$this->allianceData['id'].";");
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
			'ally_web' 					=> $this->allianceData['ally_web'],
			'ally_image'				=> $this->allianceData['ally_image'],
			'ally_request_notallow' 	=> $this->allianceData['ally_request_notallow'],
			'ally_owner_range'			=> $this->allianceData['ally_owner_range'],
			'ally_stats_data'			=> $this->allianceData['ally_stats'],
			'ally_diplo_data'			=> $this->allianceData['ally_diplo'],
		));
		
		$this->display('page.alliance.admin.overview.tpl');
	}
	
	private function adminClose() {
		global $USER;
		if ($this->allianceData['ally_owner'] == $USER['id']) {
			$GLOBALS['DATABASE']->multi_query("UPDATE ".USERS." SET ally_id = '0' WHERE ally_id = ".$this->allianceData['id'].";
			UPDATE ".STATPOINTS." SET id_ally = '0' WHERE id_ally = ".$this->allianceData['id'].";
			DELETE FROM ".STATPOINTS." WHERE id_owner = ".$this->allianceData['id']." AND stat_type = 2;
			DELETE FROM ".ALLIANCE." WHERE id = ".$this->allianceData['id'].";
			DELETE FROM ".ALLIANCE_REQUEST." WHERE allianceID = ".$this->allianceData['id'].";
			DELETE FROM ".DIPLO." WHERE owner_1 = ".$this->allianceData['id']." OR owner_2 = ".$this->allianceData['id'].";");
		}
		
		$this->redirectToHome();
	}
	
	private function adminChangeTag() {
		global $UNI, $LNG;
		
		$name = HTTP::_GP('newname', '', UTF8_SUPPORT);
		
		if(!empty($name) && $name != $this->allianceData['ally_tag']) {
			$allianceCount = $GLOBALS['DATABASE']->countquery("SELECT COUNT(*) FROM ".ALLIANCE." WHERE ally_universe = ".$UNI." AND ally_tag = '".$GLOBALS['DATABASE']->sql_escape($name)."';");

			if ($allianceCount != 0) {
				$this->printMessage(sprintf($LNG['al_already_exists'], $name));
			}
			
			$GLOBALS['DATABASE']->query("UPDATE ".ALLIANCE." SET ally_tag = '".$GLOBALS['DATABASE']->sql_escape($name)."' WHERE id = ".$this->allianceData['id'].";");
		}

		$this->display('page.alliance.admin.rename.tag.tpl');
	}
	
	private function adminChangeName() {
		global $UNI, $LNG;
		
		$name = HTTP::_GP('newname', '', UTF8_SUPPORT);
		
		if(!empty($name) && $name != $this->allianceData['ally_name']) {
			$allianceCount = $GLOBALS['DATABASE']->countquery("SELECT COUNT(*) FROM ".ALLIANCE." WHERE ally_universe = ".$UNI." AND ally_name = '".$GLOBALS['DATABASE']->sql_escape($name)."';");

			if ($allianceCount != 0) {
				$this->printMessage(sprintf($LNG['al_already_exists'], $name));
			}
			
			$GLOBALS['DATABASE']->query("UPDATE ".ALLIANCE." SET ally_name = '".$GLOBALS['DATABASE']->sql_escape($name)."' WHERE id = ".$this->allianceData['id'].";");
		}

		$this->display('page.alliance.admin.rename.name.tpl');
	}
	
	private function adminTransfer()
	{
		global $LNG, $USER;

		if($this->allianceData['ally_owner'] != $USER['id'])
			$this->redirectToHome();
			
		$postleader = HTTP::_GP('newleader', 0);
		if (!empty($postleader))
		{
			$Rank = $GLOBALS['DATABASE']->uniquequery("SELECT ally_rank_id FROM ".USERS." WHERE id = ".$postleader.";");
			$GLOBALS['DATABASE']->multi_query("UPDATE ".USERS." SET ally_rank_id = '".$Rank['ally_rank_id']."' WHERE id = '".$USER['id']."';
			UPDATE ".USERS." SET ally_rank_id = 0 WHERE id = ".$postleader.";UPDATE ".ALLIANCE." SET ally_owner = ".$postleader." WHERE id = ".$this->allianceData['id'].";");
			$this->redirectToHome();
		}
		else
		{
			$transferUserResult	= $GLOBALS['DATABASE']->query("SELECT u.id, r.rankName, u.username 
											  FROM ".USERS." u 
											  INNER JOIN ".ALLIANCE_RANK." r ON r.rankID = u.ally_rank_id AND r.TRANSFER = 1
											  WHERE u.ally_id = ".$this->allianceData['id']."
											  AND id != ".$this->allianceData['ally_owner'].";");
			$transferUserList	= array();

			while ($trasferUserRow = $GLOBALS['DATABASE']->fetch_array($transferUserResult))
			{
				$transferUserList[$trasferUserRow['id']]	= $trasferUserRow['username']." [".$trasferUserRow['rankName']."]";
			}
			
			$GLOBALS['DATABASE']->free_result($transferUserResult);

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

		$applyResult	= $GLOBALS['DATABASE']->query("SELECT applyID, u.username, r.time FROM ".ALLIANCE_REQUEST." r INNER JOIN ".USERS." u ON r.userID = u.id WHERE r.allianceID = ".$this->allianceData['id'].";");
		$applyList		= array();
		
		while ($applyRow = $GLOBALS['DATABASE']->fetch_array($applyResult))
		{
			$applyList[]	= array(
				'username'	=> $applyRow['username'],
				'id'		=> $applyRow['applyID'],
				'time' 		=> _date($LNG['php_tdformat'], $applyRow['time'], $USER['timezone']),
			);
		}
		
		$GLOBALS['DATABASE']->free_result($applyResult);
		
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

		$id	= HTTP::_GP('id', 0);

		$applyDetail = $GLOBALS['DATABASE']->uniquequery("SELECT applyID, u.username, r.time, r.text FROM ".ALLIANCE_REQUEST." r LEFT JOIN ".USERS." u ON r.userID = u.id WHERE applyID = ".$id.";");

		if(empty($applyDetail)) {
			$this->printMessage($LNG['al_apply_not_exists']);
		}
		
		$this->tplObj->assign_vars(array(
			'applyDetail'		=> $applyDetail,
		));
		
		$this->display('page.alliance.admin.detailApply.tpl');
	}
	
	private function adminSendAnswerToApply()
	{
		global $LNG, $USER;
		if(!$this->rights['SEEAPPLY'] || !$this->rights['MANAGEAPPLY']) {
			$this->redirectToHome();
		}

		$text  		= makebr(HTTP::_GP('text', '', true));
		$answer		= HTTP::_GP('answer', '');
		
		$applyID	= HTTP::_GP('id', 0);
		$userID 	= $GLOBALS['DATABASE']->countquery("SELECT id FROM ".ALLIANCE_REQUEST." LEFT JOIN ".USERS." ON userID = id WHERE applyID = ".$applyID.";");

		if ($answer == 'yes')
		{
			$GLOBALS['DATABASE']->multi_query("
				DELETE FROM ".ALLIANCE_REQUEST." WHERE applyID = ".$applyID.";
				UPDATE ".USERS." SET ally_id = ".$this->allianceData['id'].", ally_register_time = ".TIMESTAMP.", ally_rank_id = 0 WHERE id = ".$userID.";
				UPDATE ".STATPOINTS." SET id_ally = ".$this->allianceData['id']." WHERE id_owner = ".$userID." AND stat_type = 1;
				UPDATE ".ALLIANCE." SET ally_members = (SELECT COUNT(*) FROM ".USERS." WHERE ally_id = ".$this->allianceData['id'].") WHERE id = ".$this->allianceData['id'].";");

			SendSimpleMessage($userID, $USER['id'], TIMESTAMP, 2, $this->allianceData['ally_tag'], $LNG['al_you_was_acceted'] . $this->allianceData['ally_name'], $LNG['al_hi_the_alliance'] . $this->allianceData['ally_name'] . $LNG['al_has_accepted'] . $text);
		}
		elseif($answer == 'no')
		{
			$GLOBALS['DATABASE']->query("DELETE FROM ".ALLIANCE_REQUEST." WHERE applyID = ".$applyID.";");
			SendSimpleMessage($userID, $USER['id'], TIMESTAMP, 2, $this->allianceData['ally_tag'], $LNG['al_you_was_declined'] . $this->allianceData['ally_name'], $LNG['al_hi_the_alliance'] . $this->allianceData['ally_name'] . $LNG['al_has_declined'] . $text);
		}

		$this->redirectTo('game.php?page=alliance&mode=admin&action=mangeApply');
	}
	
	private function adminPermissions()
	{	
		if(!$this->rights['RANKS']) {
			$this->redirectToHome();
		}
		
		$rankResult	= $GLOBALS['DATABASE']->query("SELECT * FROM ".ALLIANCE_RANK." WHERE allianceID = ".$this->allianceData['id'].";");
		$rankList	= array();
		
		while($rankRow = $GLOBALS['DATABASE']->fetch_array($rankResult))
			$rankList[$rankRow['rankID']]	= $rankRow;
		
		$GLOBALS['DATABASE']->free_result($rankResult);

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
		
		$newrank	= HTTP::_GP('newrank', '', true);
		$delete		= HTTP::_GP('deleteRank', 0);
		$rankData	= HTTP::_GP('rank', array());
		
		if(!empty($newrank)) {
			$GLOBALS['DATABASE']->query("INSERT INTO ".ALLIANCE_RANK." SET rankName = '".$GLOBALS['DATABASE']->sql_escape($newrank)."', allianceID = ".$this->allianceData['id'].";");
		}
		
		if(!empty($delete)) {
			$GLOBALS['DATABASE']->query("DELETE FROM ".ALLIANCE_RANK." WHERE rankID = ".$delete." AND allianceID = ".$this->allianceData['id'].";");
			$GLOBALS['DATABASE']->query("UPDATE ".USERS." SET ally_rank_id = 0 WHERE rankID = ".$delete." AND ally_id = ".$this->allianceData['id'].";");
		}
		
		foreach($rankData as $rankID => $rankRow) {
			$SQL	= array();
			foreach($this->avalibleRanks as $rankName) {
				if(!$this->rights[$rankName]) {
					continue;
				}
				
				$SQL[]	= $rankName." = ".(isset($rankRow[$rankName]) ? 1 : 0);
			}
			
			$SQL[]	= "rankName = '".$GLOBALS['DATABASE']->sql_escape($rankRow['name'])."'";			
			$GLOBALS['DATABASE']->query("UPDATE ".ALLIANCE_RANK." SET ".implode(", ", $SQL)." WHERE rankID = ".((int) $rankID)." AND allianceID = ".$this->allianceData['id'].";");
		}
		
		$this->redirectTo('game.php?page=alliance&mode=admin&action=permissions');
	}
	
	private function adminMembers()
	{
		global $USER, $LNG;
		if (!$this->rights['MANAGEUSERS']) {
			$this->redirectToHome();
		}
		
		$rankResult		= $GLOBALS['DATABASE']->query("SELECT rankID, rankName FROM ".ALLIANCE_RANK." WHERE allianceID = ".$this->allianceData['id'].";");
		$rankList		= array();
		$rankList[0]	= $LNG['al_new_member_rank_text'];
		
		while($rankRow = $GLOBALS['DATABASE']->fetch_array($rankResult))
			$rankList[$rankRow['rankID']]	= $rankRow['rankName'];
		
		$GLOBALS['DATABASE']->free_result($rankResult);
		
		$memberListResult = $GLOBALS['DATABASE']->query("SELECT DISTINCT u.id, u.username,u.galaxy, u.system, u.planet, u.ally_register_time, u.onlinetime, u.ally_rank_id, s.total_points 
										FROM ".USERS." u
										LEFT JOIN ".STATPOINTS." as s ON s.stat_type = '1' AND s.id_owner = u.id 
										WHERE ally_id = ".$this->allianceData['id'].";");

		$memberList	= array();
										
		while ($memberListRow = $GLOBALS['DATABASE']->fetch_array($memberListResult))
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
		
		$GLOBALS['DATABASE']->free_result($memberListResult);
			
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
		global $USER, $LNG;
		if (!$this->rights['MANAGEUSERS']) {
			$this->redirectToHome();
		}
		
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
			
			$GLOBALS['DATABASE']->query("UPDATE ".USERS." SET ally_rank_id = ".((int) $rankID)." WHERE id = ".((int) $userID)." AND ally_id = ".$this->allianceData['id'].";");
		}
		
		$this->redirectTo('game.php?page=alliance&mode=admin&action=members');
	}
	
	private function adminMembersKick()
	{
		global $USER, $LNG;
		if (!$this->rights['KICK']) {
			$this->redirectToHome();
		}
		
		$id	= HTTP::_GP('id', 0);
		
		$GLOBALS['DATABASE']->multi_query("
		UPDATE ".USERS." SET ally_id = 0, ally_register_time = 0, ally_rank_id = 0 WHERE id = ".$id.";
		UPDATE ".STATPOINTS." SET id_ally = 0 WHERE id_owner = ".$id." AND stat_type = 1;
		UPDATE ".ALLIANCE." SET ally_members = (SELECT COUNT(*) FROM ".USERS." WHERE ally_id = ".$this->allianceData['id'].") WHERE id = ".$this->allianceData['id'].";");
		
		$this->redirectTo('game.php?page=alliance&mode=admin&action=members');
	}
	
	private function adminDiplomacy()
	{
		global $USER, $LNG;
		if (!$this->rights['DIPLOMATIC']) {
			$this->redirectToHome();
		}
		
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
		
		$diploResult	= $GLOBALS['DATABASE']->query("SELECT d.id, d.level, d.accept, d.owner_1, d.owner_2, a.ally_name FROM ".DIPLO." d
		INNER JOIN ".ALLIANCE." a ON IF(".$this->allianceData['id']." = d.owner_1, a.id = d.owner_2, a.id = d.owner_1)
		WHERE owner_1 = ".$this->allianceData['id']." OR owner_2 = ".$this->allianceData['id'].";");
		
		while($diploRow = $GLOBALS['DATABASE']->fetch_array($diploResult)) {
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
		
		$GLOBALS['DATABASE']->query("UPDATE ".DIPLO." SET accept = 1 WHERE id = ".HTTP::_GP('id', 0)." AND owner_2 = ".$this->allianceData['id'].";");
		$this->redirectTo('game.php?page=alliance&mode=admin&action=diplomacy');
	}
	
	private function adminDiplomacyDelete()
	{
		if (!$this->rights['DIPLOMATIC']) {
			$this->redirectToHome();
		}
		
		$GLOBALS['DATABASE']->query("DELETE FROM ".DIPLO." WHERE id = ".HTTP::_GP('id', 0)." AND (owner_1 = ".$this->allianceData['id']." OR owner_2 = ".$this->allianceData['id'].");");
		$this->redirectTo('game.php?page=alliance&mode=admin&action=diplomacy');
	}
	
	private function adminDiplomacyCreate()
	{
		global $USER, $LNG;
		if (!$this->rights['DIPLOMATIC']) {
			$this->redirectToHome();
		}
		
		$this->initTemplate();
		$this->setWindow('popup');
		
		
		$diploMode	= HTTP::_GP('diploMode', 0);
				
		
		$this->tplObj->assign_vars(array(
			'diploMode'	=> $diploMode,
		));
		
		$this->display('page.alliance.admin.diplomacy.create.tpl');
	}
	
	private function adminDiplomacyCreateProcessor()
	{
		global $UNI, $LNG, $USER;
		if (!$this->rights['DIPLOMATIC']) {
			$this->redirectToHome();
		}
		
		$name	= HTTP::_GP('name', '', UTF8_SUPPORT);
		
		$targetAlliance	= $GLOBALS['DATABASE']->uniquequery("SELECT id, ally_owner, ally_tag FROM ".ALLIANCE." WHERE ally_universe = ".$UNI." AND ally_name = '".$GLOBALS['DATABASE']->sql_escape($name)."';");
		
		if(empty($targetAlliance)) {
			$this->sendJSON(array(
				'error'		=> true,
				'message'	=> sprintf($LNG['al_diplo_no_alliance'], $name),
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
		
		if($level == 6)
		{
			SendSimpleMessage($targetAlliance['ally_owner'], $USER['id'], 0, 1, $LNG['al_circular_alliance'].$this->allianceData['ally_tag'], $LNG['al_diplo_war'], sprintf($LNG['al_diplo_war_mes'], $this->allianceData['ally_tag'], $targetAlliance['ally_tag'], $LNG['al_diplo_level'][$level], $text));
		}
		else
		{
			SendSimpleMessage($targetAlliance['ally_owner'], $USER['id'], 0, 1, $LNG['al_circular_alliance'].$this->allianceData['ally_tag'], $LNG['al_diplo_ask'], sprintf($LNG['al_diplo_ask_mes'], $LNG['al_diplo_level'][$level], $this->allianceData['ally_tag'], $targetAlliance['ally_tag'], $text));
		}
		
		$GLOBALS['DATABASE']->query("INSERT INTO ".DIPLO." SET 
		owner_1		= ".$this->allianceData['id'].",
		owner_2		= ".$targetAlliance['id'].", 
		level		= ".$level.", 
		accept		= 0, 
		accept_text	= '".$GLOBALS['DATABASE']->sql_escape($text)."', 
		universe	= ".$UNI.";");
		
		$this->sendJSON(array(
			'error'		=> false,
			'message'	=> $LNG['al_diplo_create_done'],
		));
	}
}
?>