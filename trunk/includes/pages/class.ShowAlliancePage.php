<?php

##############################################################################
# *                                                                          #
# * 2MOONS                                                                   #
# *                                                                          #
# * @copyright Copyright (C) 2010 By ShadoX from titanspace.de               #
# *                                                                          #
# *	                                                                         #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.                                     #
# *	                                                                         #
# *  This program is distributed in the hope that it will be useful,         #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of          #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           #
# *  GNU General Public License for more details.                            #
# *                                                                          #
##############################################################################

if(!defined('INSIDE')) die('Hacking attempt!');

class ShowAlliancePage
{
	private function GetDiplo($allyid)
	{
		global $db;
		$Return	= array();
		$Diplos	= $db->query("SELECT d.level, d.accept, d.accept_text, d.id, a.id as ally_id, a.ally_name, d.owner_1, d.owner_2 FROM ".DIPLO." as d INNER JOIN ".ALLIANCE." as a ON IF('".$allyid."' = d.owner_1, a.id = d.owner_2, a.id = d.owner_1) WHERE '".$allyid."' = d.owner_1 OR '".$allyid."' = d.owner_2");
		while($CurDiplo = $db->fetch_array($Diplos))
		{
			if($CurDiplo['accept'] == 0 && $CurDiplo['owner_2'] == $allyid)
				$Return[5][$CurDiplo['id']] = array($CurDiplo['ally_name'], $CurDiplo['ally_id'], $CurDiplo['level'], $CurDiplo['accept_text'], $CurDiplo['ally_tag']);
			elseif($CurDiplo['accept'] == 0 && $CurDiplo['owner_1'] == $allyid)
				$Return[6][$CurDiplo['id']] = array($CurDiplo['ally_name'], $CurDiplo['ally_id'], $CurDiplo['level'], $CurDiplo['accept_text'], $CurDiplo['ally_tag']);
			else
				$Return[$CurDiplo['level']][$CurDiplo['id']] = array($CurDiplo['ally_name'], $CurDiplo['ally_id'], $CurDiplo['owner_1'], $CurDiplo['ally_tag']);				
		}
		return $Return;
	}

	private function ainfo($ally) 
	{
		global $LNG, $db, $USER, $PLANET;
		
		require_once(ROOT_PATH.'includes/functions/BBCode.php');
		
		if ($ally['ally_diplo'] == 1 && ($DiploInfo = $this->GetDiplo($ally['id'])) !== array())
		{
			$this->template->assign_vars(array(
				'DiploInfo'			=> $DiploInfo,		
				'al_diplo_level'	=> $LNG['al_diplo_level'],
				'al_diplo'			=> $LNG['al_diplo'],
			));
		}	
		if ($ally['ally_stats'] == 1)
		{
			$StatsData 					= $db->uniquequery("SELECT SUM(wons) as wons, SUM(loos) as loos, SUM(draws) as draws, SUM(kbmetal) as kbmetal, SUM(kbcrystal) as kbcrystal, SUM(lostunits) as lostunits, SUM(desunits) as desunits FROM ".USERS." WHERE ally_id='" . $ally['id'] . "';");

			$this->template->assign_vars(array(
				'al_Allyquote'	=> $LNG['al_Allyquote'],
				'pl_totalfight'	=> $LNG['pl_totalfight'],
				'pl_fightwon'	=> $LNG['pl_fightwon'],
				'pl_fightlose'	=> $LNG['pl_fightlose'],
				'pl_fightdraw'	=> $LNG['pl_fightdraw'],
				'pl_unitsshot'	=> $LNG['pl_unitsshot'],
				'pl_unitslose'	=> $LNG['pl_unitslose'],
				'pl_dermetal'	=> $LNG['pl_dermetal'],
				'pl_dercrystal'	=> $LNG['pl_dercrystal'],
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
		$this->template->assign_vars(array(
			'al_ally_info_members'		=> $LNG['al_ally_info_members'],
			'al_ally_info_name'			=> $LNG['al_ally_info_name'],
			'al_ally_info_tag'			=> $LNG['al_ally_info_tag'],
			'al_ally_information'		=> $LNG['al_ally_information'],
			'al_description_message'	=> $LNG['al_description_message'],
			'al_web_text'				=> $LNG['al_web_text'],
			'al_click_to_send_request'	=> $LNG['al_click_to_send_request'],
			'al_request'				=> $LNG['al_request'],
			'al_web_text'				=> $LNG['al_web_text'],
			'ally_description' 			=> bbcode($ally['ally_description']),
			'ally_id'	 				=> $ally['id'],
			'ally_image' 				=> $ally['ally_image'],
			'ally_web'					=> $ally['ally_web'],
			'ally_member_scount' 		=> $ally['ally_members'],
			'ally_name' 				=> $ally['ally_name'],
			'ally_tag' 					=> $ally['ally_tag'],
			'ally_stats' 				=> $ally['ally_stats'],
			'ally_diplo' 				=> $ally['ally_diplo'],
			'ally_request'          	=> ($USER['ally_id'] == 0 && $ally['ally_request_notallow'] == 0) ? true : false,
		));
		
		$this->template->show("alliance_ainfo.tpl");
	}
	
	public function __construct()
	{
		global $USER, $PLANET, $LNG, $db, $UNI;

		$parse 		= $LNG;

		$mode  		= request_var('mode' 		, '');
		$a     		= request_var('a'    		, 1 );
		$sort1 		= request_var('sort1'		, '');
		$sort2 		= request_var('sort2'		, '');
		$edit 		= request_var('edit' 		, '');
		$rank 		= request_var('rank' 		, '');
		$kick 		= request_var('kick' 		, '');
		$id 		= request_var('id' 			, '');
		$action   	= request_var('action' 		, '');
		$allyid   	= request_var('allyid'  	, '');
		$tag      	= request_var('tag' 		, '');

		if (empty($sort2))	unset($sort2);
		if (empty($a))		unset($a);
		if (empty($mode)) 	unset($mode);
		if (empty($sort1))	unset($sort1);
		if (empty($edit))	unset($edit);
		if (empty($rank))	unset($rank);
		if (empty($kick))	unset($kick);
		if (empty($id))		unset($id);
		
		$PlanetRess = new ResourceUpdate();
		$PlanetRess->CalcResource();
		$PlanetRess->SavePlanetToDB();
			
	
		$this->template	= new template();
	
		$this->template->page_topnav();
		$this->template->page_header();
		$this->template->page_leftmenu();
		$this->template->page_planetmenu();
		$this->template->page_footer();

		if ($USER['ally_id'] != 0 && $USER['ally_request'] != 0)
		{
			$db->query("UPDATE `".USERS."` SET `ally_id` = 0 WHERE `id` = ".$USER['id'].";");
			header("location:?page=alliance");
		}
		
		switch($USER['ally_id'])
		{
			case 0:
				switch($mode){
					case 'ainfo':
						$allyrow = $db->fetch_array($db->query("SELECT * FROM ".ALLIANCE." WHERE ally_tag='".$db->sql_escape($tag)."' OR id='".$db->sql_escape($a)."';"));

						if (!$allyrow) die(redirectTo("game.".PHP_EXT."?page=alliance"));
						
						$this->ainfo($allyrow, $USER, $PLANET);					
					break;
					case 'make':
						if($USER['ally_request'] == 0)
						{	
							if ($action == "send")
							{
								$atag	= request_var('atag' , '', UTF8_SUPPORT);
								$aname	= request_var('aname', '', UTF8_SUPPORT);
								
								if (empty($atag))
								{
									$this->template->message($LNG['al_tag_required'], "?page=alliance&mode=make", 3);
									exit;
								}

								if (empty($aname))
								{
									$this->template->message($LNG['al_name_required'], "?page=alliance&mode=make", 3);
									exit;
								}
								
								if (!CheckName($aname) || !CheckName($atag))
								{
									$this->template->message((UTF8_SUPPORT) ? $LNG['al_newname_no_space'] : $LNG['al_newname_alphanum'], "?page=alliance&mode=make", 3);
									exit;
								}
								
								$tagquery = $db->fetch_array($db->query("SELECT `id` FROM `".ALLIANCE."` WHERE ally_tag = '".$db->sql_escape($atag)."' OR ally_name = '".$db->sql_escape($aname)."';"));

								if (isset($tagquery))
								{
									$this->template->message(sprintf($LNG['al_already_exists'], $aname), "?page=alliance&mode=make", 3);
									exit;
								}
								
								$db->multi_query("INSERT INTO ".ALLIANCE." SET
                                `ally_name`='".$db->sql_escape($aname)."',
                                `ally_tag`='".$db->sql_escape($atag)."' ,
                                `ally_owner`='".$USER['id']."',
                                `ally_owner_range`='Leader',
                                `ally_members`='1',
                                `ally_register_time`='" . TIMESTAMP."',
								`ally_universe` ='".$UNI."';
                                UPDATE ".USERS." SET
                                `ally_id`= (SELECT `id` FROM ".ALLIANCE." WHERE ally_name = '".$db->sql_escape($aname)."'),
                                `ally_name` = '".$db->sql_escape($aname)."',
                                `ally_register_time` = '" . TIMESTAMP . "'
                                WHERE `id` = '".$USER['id']."';
                                UPDATE ".STATPOINTS." SET
                                `id_ally` = (SELECT `id` FROM ".ALLIANCE." WHERE ally_name = '".$db->sql_escape($aname)."')
                                WHERE `id_owner` = '".$USER['id']."';");
											
								$this->template->message(sprintf($LNG['al_created'], $atag),"?page=alliance", 3);
							} else {
								$this->template->assign_vars(array(
									'al_make_alliance'				=> $LNG['al_make_alliance'],
									'al_make_ally_tag_required'		=> $LNG['al_make_ally_tag_required'],
									'al_make_ally_name_required'	=> $LNG['al_make_ally_name_required'],
									'al_make_submit'				=> $LNG['al_make_submit'],
								));	
								$this->template->show("alliance_make.tpl");
							}		
						
						} else {
							redirectTo("game.".PHP_EXT."?page=alliance");
						}
					break;
					case 'search';
						if($USER['ally_request'] == 0)
						{
							$searchtext	= request_var('searchtext', '', UTF8_SUPPORT);

							if (!empty($searchtext))
							{
								$Search = $db->query("SELECT id, ally_tag, ally_name, ally_members FROM ".ALLIANCE." WHERE ally_name LIKE '%".$db->sql_escape($searchtext, true)."%' OR ally_tag LIKE '%".$db->sql_escape($searchtext, true)."%' LIMIT 30;");
								$SeachResult	= array();
								
								while ($CurrRow = $db->fetch_array($Search))
								{
									$SeachResult[]	= array(
										'id'		=> $CurrRow['id'],
										'tag'		=> $CurrRow['ally_tag'],
										'name'		=> $CurrRow['ally_name'],
										'members' 	=> $CurrRow['ally_members'],									
									);
								}
							}
							$this->template->assign_vars(array(
								'searchtext'						=> $searchtext,
								'SeachResult'						=> $SeachResult,
								'al_find_submit'					=> $LNG['al_find_submit'],
								'al_find_text'						=> $LNG['al_find_text'],
								'al_find_alliances'					=> $LNG['al_find_alliances'],
								'al_make_submit'					=> $LNG['al_make_submit'],
								'al_find_no_alliances'				=> $LNG['al_find_no_alliances'],
								'al_ally_info_members'				=> $LNG['al_ally_info_members'],
								'al_ally_info_name'					=> $LNG['al_ally_info_name'],
								'al_ally_info_tag'					=> $LNG['al_ally_info_tag'],
							));	
							
							$this->template->show("alliance_searchform.tpl");
						} else {
							redirectTo("game.".PHP_EXT."?page=alliance");
						}
					break;
					case 'apply':
						if($USER['ally_request'] == 0)
						{
							$text	= request_var('text' , '', true);
							
							$allyrow = $db->uniquequery("SELECT `ally_tag`, `ally_request`, `ally_request_notallow` FROM ".ALLIANCE." WHERE id='".$db->sql_escape($allyid)."';");

							if (!$allyrow)
								redirectTo("game.".PHP_EXT."?page=alliance");
									
							if($allyrow['ally_request_notallow'] == 1)
							{
								$this->template->message($LNG['al_alliance_closed']);
								exit;
							}
							else
							{
								if ($action == "send")
								{
									$db->query("UPDATE ".USERS." SET `ally_request`='".$db->sql_escape($allyid)."', ally_request_text='" .$db->sql_escape($text). "', ally_register_time='" . TIMESTAMP . "' WHERE `id`='" . $USER['id'] . "';");

									$this->template->message($LNG['al_request_confirmation_message'], "?page=alliance");
								} else {
									$this->template->assign_vars(array(
										'allyid'					=> $allyid,
										'al_your_request_title'		=> $LNG['al_your_request_title'],
										'applytext'					=> (!empty($allyrow['ally_request'])) ? $allyrow['ally_request'] : $LNG['al_default_request_text'],
										'al_write_request'			=> sprintf($LNG['al_write_request'], $allyrow['ally_tag']),
										'al_applyform_reload'		=> $LNG['al_applyform_reload'],
										'al_applyform_send'			=> $LNG['al_applyform_send'],
										'al_message'				=> $LNG['al_message'],
									));	
									
									$this->template->show("alliance_applyform.tpl");
								}
							}
						} else {
							redirectTo("game.".PHP_EXT."?page=alliance");
						}
					break;
					default:
						if ($USER['ally_request'] != 0) 
						{
							$allyquery 	= $db->fetch_array($db->query("SELECT ally_tag FROM ".ALLIANCE." WHERE id = '".$USER['ally_request']. "' ORDER BY `id`;"));
							$bcancel	= request_var('bcancel', '');
							
							if ($bcancel)
							{
								$db->query("UPDATE ".USERS." SET `ally_request`= 0 WHERE `id`='".$USER['id']."';");
								$this->template->assign_vars(array(
									'al_your_request_title'			=> $LNG['al_your_request_title'],
									'button_text'					=> $LNG['al_continue'],
									'request_text'					=> sprintf($LNG['al_request_deleted'], $allyquery['ally_tag']),
									'al_make_submit'				=> $LNG['al_continue'],
								));	
							}
							else
							{								
								$this->template->assign_vars(array(
									'al_your_request_title'			=> $LNG['al_your_request_title'],
									'button_text'					=> $LNG['al_delete_request'],
									'request_text'					=> sprintf($LNG['al_request_wait_message'], $allyquery['ally_tag']),
									'al_make_submit'				=> $LNG['al_make_submit'],
								));	
							}

							$this->template->show("alliance_apply_waitform.tpl");
						}
						else
						{
							$this->template->assign_vars(array(
								'al_alliance_search'			=> $LNG['al_alliance_search'],
								'al_alliance_make'				=> $LNG['al_alliance_make'],
								'al_alliance'					=> $LNG['al_alliance'],
							));	
							$this->template->show("alliance_defaultmenu.tpl");
						}
					break;
				}
			break;
			default:

				$ally = $db->uniquequery("SELECT * FROM ".ALLIANCE." WHERE id='".$USER['ally_id']."';");
				if (!$ally)
				{
					$db->query("UPDATE `".USERS."` SET `ally_id` = 0 WHERE `id` = ".$USER['id'].";");
					redirectTo("game.".PHP_EXT."?page=alliance");
				}
				$ally_ranks = unserialize($ally['ally_ranks']);
				
				$USER['rights']['memberlist_on']	= ($ally_ranks[$USER['ally_rank_id']-1]['onlinestatus'] == 1 || $ally['ally_owner'] == $USER['id']) ? true : false;
				$USER['rights']['memberlist']	= ($ally_ranks[$USER['ally_rank_id']-1]['memberlist'] == 1 || $ally['ally_owner'] == $USER['id']) ? true : false;
				$USER['rights']['roundmail']		= ($ally_ranks[$USER['ally_rank_id']-1]['mails'] == 1 || $ally['ally_owner'] == $USER['id']) ? true : false;
				$USER['rights']['kick']			= ($ally_ranks[$USER['ally_rank_id']-1]['kick'] == 1 || $ally['ally_owner'] == $USER['id']) ? true : false;
				$USER['rights']['righthand']		= ($ally_ranks[$USER['ally_rank_id']-1]['rechtehand'] == 1 || $ally['ally_owner'] == $USER['id']) ? true : false;
				$USER['rights']['close']			= ($ally_ranks[$USER['ally_rank_id']-1]['delete'] == 1 || $ally['ally_owner'] == $USER['id']) ? true : false;
				$USER['rights']['seeapply']		= ($ally_ranks[$USER['ally_rank_id']-1]['bewerbungen'] == 1 || $ally['ally_owner'] == $USER['id']) ? true : false;
				$USER['rights']['changeapply']	= ($ally_ranks[$USER['ally_rank_id']-1]['bewerbungenbearbeiten'] == 1 || $ally['ally_owner'] == $USER['id']) ? true : false;
				$USER['rights']['admin']			= ($ally_ranks[$USER['ally_rank_id']-1]['administrieren'] == 1 || $ally['ally_owner'] == $USER['id']) ? true : false;

				switch($mode){
					case 'ainfo':
						$allyrow = $db->fetch_array($db->query("SELECT * FROM ".ALLIANCE." WHERE ally_tag='".$db->sql_escape($tag)."' OR id='".$db->sql_escape($a)."';"));

						if (!$allyrow) redirectTo("game.".PHP_EXT."?page=alliance");
						
						$this->ainfo($allyrow, $USER, $PLANET);	
					break;
					case 'exit':
						if ($ally['ally_owner'] == $USER['id'])
							$this->template->message($LNG['al_founder_cant_leave_alliance'], "?page=alliance", 3);
						elseif ($action = "send")
						{
							$db->multi_query("UPDATE ".USERS." SET `ally_id` = 0, `ally_name` = '', ally_rank_id = 0 WHERE `id`='".$USER['id']."';UPDATE ".ALLIANCE." SET `ally_members` = `ally_members` - 1 WHERE `id`='".$ally['id']."';UPDATE ".STATPOINTS." SET `id_ally` = '0' WHERE `id_ally` = '".$ally['id']."' AND `id_owner` = '".$USER['id']."';");
							$this->template->message(sprintf($LNG['al_leave_sucess'], $ally['ally_name']), "game.php?page=alliance", 2);
						}
						else
							$this->template->message(sprintf($LNG['al_do_you_really_want_to_go_out'], $ally['ally_name'])."<br><a href=\"?page=alliance&amp;mode=exit&amp;action=send\">".$LNG['al_go_out_yes']."</a>");
					break;
					case 'memberslist':
						if (!$USER['rights']['memberlist'])
							redirectTo("game.".PHP_EXT."?page=alliance");
						
						if ($sort1 && $sort2)
						{
							switch($sort1)
							{
								case 1:
									$sort = " ORDER BY `username`";
								break;
								case 2:
									$sort = " ORDER BY `ally_rank_id`";
								break;
								case 3:
									$sort = " ORDER BY `total_points`";
								break;
								case 4:
									$sort = " ORDER BY `ally_register_time`";
								break;
								case 5:
									$sort = " ORDER BY `onlinetime`";
								break;
								default:
									$sort = " ORDER BY `id`";
								break;
							}

							if ($sort2 == 1) {
								$sort .= " DESC;";
							} elseif ($sort2 == 2) {
								$sort .= " ASC;";
							}
							
							$listuser = $db->query("SELECT DISTINCT u.id, u.username,u.galaxy, u.system, u.planet, u.ally_register_time, u.onlinetime, u.ally_rank_id, s.total_points FROM `".USERS."` as u LEFT JOIN ".STATPOINTS." as s ON s.`stat_type` = '1' AND s.`id_owner` = u.`id` WHERE ally_id = '".$USER['ally_id']."'".$sort.";");
						}
						else
							$listuser = $db->query("SELECT DISTINCT u.id, u.username,u.galaxy, u.system, u.planet, u.ally_register_time, u.onlinetime, u.ally_rank_id, s.total_points FROM `".USERS."` as u LEFT JOIN ".STATPOINTS." as s ON s.`stat_type` = '1' AND s.`id_owner` = u.`id` WHERE `ally_id` = '".$USER['ally_id']."';");

						while ($UserRow = $db->fetch_array($listuser))
						{
							if ($ally['ally_owner'] == $UserRow['id'])
								$UserRow['ally_range'] = ($ally['ally_owner_range'] == '')?$LNG['al_founder_rank_text']:$ally['ally_owner_range'];
							elseif ($UserRow['ally_rank_id'] != 0)
								$UserRow['ally_range'] = $ally_ranks[$UserRow['ally_rank_id']-1]['name'];
							else
								$UserRow['ally_range'] = $LNG['al_new_member_rank_text'];
							
							$Memberlist[]	= array(
								'id'			=> $UserRow['id'],
								'username'		=> $UserRow['username'],
								'galaxy'		=> $UserRow['galaxy'],
								'system'		=> $UserRow['system'],
								'planet'		=> $UserRow['planet'],
								'register_time'	=> date("Y-m-d h:i:s", $UserRow['ally_register_time']),
								'points'		=> pretty_number($UserRow['total_points']),
								'range'			=> $UserRow['ally_range'],
								'onlinetime'	=> floor((TIMESTAMP - $UserRow['onlinetime']) / 60),
							);
						}
						
						if (count($Memberlist) != $ally['ally_members'])
							$db->query("UPDATE ".ALLIANCE." SET `ally_members`='".count($Memberlist)."' WHERE `id`='".$ally['id']."';");				
						
						$this->template->assign_vars(array(
							'Memberlist'		=> $Memberlist,
							'sort'				=> ($sort2 == 1) ? 2 : 1,
							'seeonline'			=> $USER['rights']['memberlist_on'],
							'al_users_list'		=> sprintf($LNG['al_users_list'], count($Memberlist)),
							'al_num'			=> $LNG['al_num'],
							'al_back'			=> $LNG['al_back'],
							'al_message'		=> $LNG['al_message'],
							'al_member'			=> $LNG['al_member'],
							'al_position'		=> $LNG['al_position'],
							'al_points'			=> $LNG['al_points'],
							'al_coords'			=> $LNG['al_coords'],
							'al_member_since'	=> $LNG['al_member_since'],
							'al_estate'			=> $LNG['al_estate'],
							'al_memberlist_on'	=> $LNG['al_memberlist_on'],
							'al_memberlist_off'	=> $LNG['al_memberlist_off'],
							'al_memberlist_min'	=> $LNG['al_memberlist_min'],
						));
						
						$this->template->show("alliance_memberslist.tpl");						
					break;
					case 'circular':
						if (!$USER['rights']['roundmail'])
							redirectTo("game.".PHP_EXT."?page=alliance");

						if ($action == "send")
						{
							$r 		= request_var('r', 0);
							$text 	= makebr(request_var('text', '', true));

							if ($r == 0)
								$sq = $db->query("SELECT id, username FROM ".USERS." WHERE ally_id = '".$USER['ally_id']."';");
							else
								$sq = $db->query("SELECT id, username FROM ".USERS." WHERE ally_id = '".$USER['ally_id']."' AND ally_rank_id='".$r."';");

							$list = '';

							while ($u = $db->fetch_array($sq))
							{
								SendSimpleMessage($u['id'],$USER['id'],'',2,$LNG['al_circular_alliance'].$ally['ally_tag'],$USER['username'],$text);

								$list .= "\n".$u['username'];
							}

							exit($LNG['al_circular_sended'].$list);
						}

						$RangeList[]	= $LNG['al_all_players'];

						if (is_array($ally_ranks))
						{
							foreach($ally_ranks as $id => $array)
							{
								$RangeList[$id + 1]	= $array['name'];
							}
						}
						
						$this->template->assign_vars(array(
							'RangeList'						=> $RangeList,
							'al_circular_send_ciruclar'		=> $LNG['al_circular_send_ciruclar'],
							'al_circular_reset'				=> $LNG['al_circular_reset'],
							'al_receiveral_message'			=> $LNG['al_receiveral_message'],
							'al_circular_send_submit'		=> $LNG['al_circular_send_submit'],
							'al_characters'					=> $LNG['al_characters'],
							'al_receiver'					=> $LNG['al_receiver'],
						));	
						$this->template->show("alliance_circular.tpl");
					break;
					case 'admin':
						if(!$USER['rights']['admin']) exit(redirectTo("game.".PHP_EXT."?page=alliance"));
						switch($edit) {
							case 'rights':
								if (!$USER['rights']['righthand']) exit(redirectTo("game.".PHP_EXT."?page=alliance"));
								
								$rankname 	= request_var('newrangname', '', UTF8_SUPPORT);
								$pid 		= $_POST['id'];			
								$d    		= request_var('d', 1337 );
								if (!empty($rankname))
								{
									$pid	= request_var('id','');
									$ally_ranks[] = array('name' => $rankname,
										'mails' => 0,
										'delete' => 0,
										'kick' => 0,
										'bewerbungen' => 0,
										'administrieren' => 0,
										'bewerbungenbearbeiten' => 0,
										'memberlist' => 0,
										'onlinestatus' => 0,
										'rechtehand' => 0
									);

									$ranks = serialize($ally_ranks);
									$db->query("UPDATE ".ALLIANCE." SET `ally_ranks`='" . $ranks . "' WHERE `id`='" . $ally['id']."';");

									redirectTo("game.".PHP_EXT."?page=alliance&mode=admin&edit=rights");
									exit();
								}
								elseif (is_array($pid))
								{
									$ally_ranks_new = array();
									foreach ($pid as $id)
									{
										$ally_ranks_new[$id]['name'] 					= $ally_ranks[$id]['name'];
										$ally_ranks_new[$id]['delete'] 					= (isset($_POST['u'.$id.'r0']) && $USER['rights']['close']) ? 1 : 0;
										$ally_ranks_new[$id]['kick'] 					= (isset($_POST['u'.$id.'r1']) && $USER['rights']['kick']) ? 1 : 0;
										$ally_ranks_new[$id]['bewerbungen'] 			= (isset($_POST['u'.$id.'r2']) && $USER['rights']['seeapply']) ? 1 : 0;
										$ally_ranks_new[$id]['memberlist'] 				= (isset($_POST['u'.$id.'r3']) && $USER['rights']['memberlist']) ? 1 : 0;
										$ally_ranks_new[$id]['bewerbungenbearbeiten'] 	= (isset($_POST['u'.$id.'r4']) && $USER['rights']['changeapply']) ? 1 : 0;
										$ally_ranks_new[$id]['administrieren'] 			= (isset($_POST['u'.$id.'r5']) && $USER['rights']['admin']) ? 1 : 0;
										$ally_ranks_new[$id]['onlinestatus'] 			= (isset($_POST['u'.$id.'r6']) && $USER['rights']['memberlist_on']) ? 1 : 0;
										$ally_ranks_new[$id]['mails'] 					= (isset($_POST['u'.$id.'r7']) && $USER['rights']['roundmail']) ? 1 : 0;
										$ally_ranks_new[$id]['rechtehand'] 				= (isset($_POST['u'.$id.'r8']) && $USER['rights']['righthand']) ? 1 : 0;
									}

									$ranks = serialize($ally_ranks_new);

									$db->query("UPDATE ".ALLIANCE." SET `ally_ranks`='" . $ranks . "' WHERE `id`='" . $ally['id'] ."';");
									redirectTo("game.".PHP_EXT."?page=alliance&mode=admin&edit=rights");
									exit;

								}
								elseif(isset($ally_ranks[$d]))
								{
									unset($ally_ranks[$d]);
									$db->query("UPDATE ".ALLIANCE." SET `ally_ranks`='".serialize($ally_ranks)."' WHERE `id`='".$ally['id']."';");
								}
													
								if (is_array($ally_ranks))
								{
									foreach($ally_ranks as $a => $b)
									{
										$AllyRanks[]	= array(
											'id'			=> $a,
											'name'			=> $b['name'],
											'memberlist_on'	=> $b['onlinestatus'],
											'memberlist'	=> $b['memberlist'],
											'roundmail'		=> $b['mails'],
											'kick'			=> $b['kick'],
											'righthand'		=> $b['rechtehand'],
											'close'			=> $b['delete'],
											'seeapply'		=> $b['bewerbungen'],
											'changeapply'	=> $b['bewerbungenbearbeiten'],
											'admin'			=> $b['administrieren'],
										);
									}
								}

								$this->template->assign_vars(array(
									'AllyRanks'						=> $AllyRanks,
									'memberlist_on'					=> $USER['rights']['memberlist_on'],
									'memberlist'					=> $USER['rights']['memberlist'],
									'roundmail'						=> $USER['rights']['roundmail'],
									'kick'							=> $USER['rights']['kick'],
									'righthand'						=> $USER['rights']['righthand'],
									'close'							=> $USER['rights']['close'],
									'seeapply'						=> $USER['rights']['seeapply'],
									'changeapply'					=> $USER['rights']['changeapply'],
									'admin'							=> $USER['rights']['admin'],
									'al_configura_ranks'			=> $LNG['al_configura_ranks'],
									'al_save'						=> $LNG['al_configura_ranks'],
									'Delete_range'					=> $LNG['Delete_range'],
									'al_rank_name'					=> $LNG['al_rank_name'],
									'al_dlte'						=> $LNG['al_dlte'],
									'al_create'						=> $LNG['al_create'],
									'al_rank_name'					=> $LNG['al_rank_name'],
									'al_create_new_rank'			=> $LNG['al_create_new_rank'],
									'al_back'						=> $LNG['al_back'],
									'al_legend'						=> $LNG['al_legend'],
									'al_no_ranks_defined'			=> $LNG['al_no_ranks_defined'],  	
									'al_legend_kick_users'          => $LNG['al_legend_kick_users'],
									'al_legend_disolve_alliance'	=> $LNG['al_legend_disolve_alliance'],
									'al_legend_see_requests'		=> $LNG['al_legend_see_requests'],
									'al_legend_see_users_list'		=> $LNG['al_legend_see_users_list'],
									'al_legend_check_requests'		=> $LNG['al_legend_check_requests'],
									'al_legend_admin_alliance'		=> $LNG['al_legend_admin_alliance'],
									'al_legend_see_connected_users'	=> $LNG['al_legend_see_connected_users'],
									'al_legend_create_circular'		=> $LNG['al_legend_create_circular'],
									'al_legend_right_hand'			=> $LNG['al_legend_right_hand'],
								));	

								$this->template->show("alliance_admin_ranks.tpl");
							break;
							case 'members':
								$NewRang	= request_var('newrang', '');

								if($NewRang != '')
								{
									$q = $db->uniquequery("SELECT id FROM ".USERS." WHERE id='".$db->sql_escape($id)."';");

									if (isset($ally_ranks[$NewRang-1]) && $q['id'] != $ally['ally_owner'])
									{
										$db->query("UPDATE ".USERS." SET `ally_rank_id`='" . $db->sql_escape($NewRang) . "' WHERE `id`='".$db->sql_escape($id) . "';");
									}
								}
								elseif($action == "kick" && !empty($id) && $USER['rights']['kick'])
								{
									$u = $db->uniquequery("SELECT id FROM ".USERS." WHERE id = '".$db->sql_escape($id)."' AND `ally_id` = '".$ally['id']."' AND 'id' != '".$ally['ally_owner']."';");
									
									if (!empty($u['id']))
                                        $db->multi_query("UPDATE ".USERS." SET `ally_id` = '0', `ally_name` = '', `ally_rank_id` = 0 WHERE `id` = '".$u['id']."';UPDATE ".ALLIANCE." SET `ally_members` = ally_members - 1 WHERE `id` = '".$ally['id']."';UPDATE ".STATPOINTS." SET `id_ally` = '0' WHERE `id_ally` = '".$ally['id']."' AND `id_owner` = '".$u['id']."';");
								}

								if ($sort1 && $sort2)
								{
									switch($sort1)
									{
										case 1:
											$sort = " ORDER BY `username`";
										break;
										case 2:
											$sort = " ORDER BY `ally_rank_id`";
										break;
										case 3:
											$sort = " ORDER BY `total_points`";
										break;
										case 4:
											$sort = " ORDER BY `ally_register_time`";
										break;
										case 5:
											$sort = " ORDER BY `onlinetime`";
										break;
										default:
											$sort = " ORDER BY `id`";
										break;
									}

									if ($sort2 == 1) {
										$sort .= " DESC;";
									} elseif ($sort2 == 2) {
										$sort .= " ASC;";
									}
									
									$listuser = $db->query("SELECT DISTINCT u.id, u.username,u.galaxy, u.system, u.planet, u.ally_register_time, u.ally_rank_id, u.onlinetime, s.total_points FROM `".USERS."` as u LEFT JOIN ".STATPOINTS." as s ON s.`stat_type` = '1' AND s.`id_owner` = u.`id` WHERE ally_id = '".$USER['ally_id']."'".$sort.";");
								}
								else
									$listuser = $db->query("SELECT DISTINCT u.id, u.username,u.galaxy, u.system, u.planet, u.ally_register_time, u.ally_rank_id, u.onlinetime, s.total_points FROM `".USERS."` as u LEFT JOIN ".STATPOINTS." as s ON s.`stat_type` = '1' AND s.`id_owner` = u.`id` WHERE `ally_id` = '".$USER['ally_id']."';");

								$Selector[0] = $LNG['al_new_member_rank_text'];
								
								if(is_array($ally_ranks))
								{
									foreach($ally_ranks as $a => $b)
									{
										$Selector[$a + 1] = $b['name'];
									}
								}	
								while ($UserRow = $db->fetch_array($listuser))
								{
									if ($ally['ally_owner'] == $UserRow['id'])
										$UserRow['ally_range'] = ($ally['ally_owner_range'] == '')?$LNG['al_founder_rank_text']:$ally['ally_owner_range'];
									elseif ($UserRow['ally_rank_id'] == 0 )
										$UserRow['ally_range'] = $LNG['al_new_member_rank_text'];
									else
										$UserRow['ally_range'] = $ally_ranks[$UserRow['ally_rank_id']-1]['name'];
									
									$Memberlist[]	= array(
										'id'			=> $UserRow['id'],
										'username'		=> $UserRow['username'],
										'galaxy'		=> $UserRow['galaxy'],
										'system'		=> $UserRow['system'],
										'planet'		=> $UserRow['planet'],
										'rank_id'		=> $UserRow['ally_rank_id']-1,
										'register_time'	=> date("Y-m-d h:i:s", $UserRow['ally_register_time']),
										'points'		=> pretty_number($UserRow['total_points']),
										'range'			=> $UserRow['ally_range'],
										'onlinetime'	=> sprintf("%d d", floor(TIMESTAMP - $UserRow['onlinetime']) / 86400),
										'action'		=> ($ally['ally_owner'] == $UserRow['id'] || $rank == $UserRow['id']) ? 0 : (($USER['rights']['kick'] == 1) ? 2 : 1),
										'kick'			=> sprintf($LNG['al_kick_player'], $UserRow['username'])
									);
								}
								
								if (count($Memberlist) != $ally['ally_members'])
									$db->query("UPDATE ".ALLIANCE." SET `ally_members`='".count($Memberlist)."' WHERE `id`='".$ally['id']."';");				
								
								$this->template->assign_vars(array(
									'Selector'			=> $Selector,
									'Memberlist'		=> $Memberlist,
									'sort'				=> ($sort2 == 1) ? 2 : 1,
									'seeonline'			=> $USER['rights']['memberlist_on'],
									'al_users_list'		=> sprintf($LNG['al_users_list'], count($Memberlist)),
									'id'				=> ($NewRang == '') ? $id : 0,
									'al_num'			=> $LNG['al_num'],
									'al_back'			=> $LNG['al_back'],
									'al_message'		=> $LNG['al_message'],
									'al_member'			=> $LNG['al_member'],
									'al_position'		=> $LNG['al_position'],
									'al_points'			=> $LNG['al_points'],
									'al_coords'			=> $LNG['al_coords'],
									'al_member_since'	=> $LNG['al_member_since'],
									'al_estate'			=> $LNG['al_estate'],
									'al_actions'		=> $LNG['al_actions'],
									'al_ok'				=> $LNG['al_ok'],
								));
								$this->template->show("alliance_admin_members.tpl");
							break;
							case 'diplo':
								if (!$USER['rights']['righthand'])
									header("location:?page=alliance");
								
								$action		= request_var('action', '');
								$id			= request_var('id', 0);
								$Level		= request_var('level', 0);
								$DiploInfo	= $this->GetDiplo($ally['id']);
								switch($action)
								{
									case 'new':
										if(!empty($id))
										{
											$text		= request_var('text', '', true);
											$Alliances	= $db->uniquequery("SELECT `ally_tag`, `ally_name` FROM ".ALLIANCE." WHERE id = '".$id."';");
											if($Level == 4)
											{
												$AllyUsers 	= $db->query("SELECT `id` FROM ".USERS." as s WHERE s.ally_id = '".$ally['id']."' OR s.ally_id = '".$id."';");
												while($User = $db->fetch_array($AllyUsers)) {	
													SendSimpleMessage($User['id'], $USER['id'],'', 2,$LNG['al_circular_alliance'].$ally['ally_tag']." &amp; ".$Alliances['ally_tag'], $LNG['al_diplo_war'], sprintf($LNG['al_diplo_war_mes'], $ally['ally_name'], $Alliances['ally_name'], $LNG['al_diplo_level'][$Level], $text));
												}											
											} else {
												$RanksRAW = $db->uniquequery("SELECT `ally_ranks`, `ally_owner` FROM ".ALLIANCE." WHERE id = '".$id."';");
												$Ranks = unserialize($RanksRAW['ally_ranks']);
												if(is_array($Ranks))
												{
													foreach($Ranks as $ID => $RankInfo)
													{
														if($RankInfo['rechtehand'] == 0) continue;
														$SendRank[1] = "`ally_rank_id` ='".($ID+1)."' OR ";
													}
												}
												if(is_array($ally_ranks))
												{
													foreach($ally_ranks as $ID => $RankInfo)
													{
														if($RankInfo['rechtehand'] == 0) continue;
														$SendRank[0] = "`ally_rank_id` ='".($ID+1)."' OR ";
													}
												}
												$AllyUsers = $db->query("SELECT `id` FROM ".USERS." WHERE (ally_id = '".$ally['id']."' AND (".$SendRank[0]."`id` = '".$ally['ally_owner']."')) OR (ally_id = '".$id."' AND (".$SendRank[1]."`id` = '".$RanksRAW['ally_owner']."'));");
												while($User = $db->fetch_array($AllyUsers)) {	
													SendSimpleMessage($User['id'], $USER['id'],'', 2,$LNG['al_circular_alliance'].$ally['ally_tag']." &amp; ".$Alliances['ally_tag'], $LNG['al_diplo_ask'], sprintf($LNG['al_diplo_ask_mes'], $LNG['al_diplo_level'][$Level], $ally['ally_name'], $Alliances['ally_name'], $text));
												}

											}
											$db->query("INSERT INTO ".DIPLO." (`id` ,`owner_1` ,`owner_2` ,`level` ,`accept` ,`accept_text`) VALUES (NULL , '".$ally['id']."', '".$id."', '".$Level."', '".($Level == 4 ? 1 : 0)."', '".$db->sql_escape($text)."');");
											exit($LNG['al_diplo_create_done']);
											}
										$Alliances	= $db->query("SELECT `id`, `ally_name` FROM ".ALLIANCE." WHERE id != '".$ally['id']."';");
										while($Alliance = $db->fetch_array($Alliances))
										{
											$AllianceList[$Alliance['id']]	= $Alliance['ally_name'];
										}
										$this->template->assign_vars(array(
											'AllianceList' 			=> $AllianceList,
											'al_diplo_create' 		=> $LNG['al_diplo_create'],
											'al_diplo_ally' 		=> $LNG['al_diplo_ally'],
											'al_diplo_level' 		=> $LNG['al_diplo_level'],
											'al_diplo_text' 		=> $LNG['al_diplo_text'],
											'al_diplo_level_des' 	=> $LNG['al_diplo_level_des'],
											'al_applyform_send'		=> $LNG['al_applyform_send'],
										));
										$this->template->show("alliance_admin_diplo_form.tpl");
									break;
									case 'accept':
										if(!empty($id))
										{
											$AllyUsers = $db->query("SELECT `id` FROM ".USERS." as s WHERE s.ally_id = '".$ally['id']."' OR s.ally_id = '".$DiploInfo[5][$id][1]."';");
											while($User = $db->fetch_array($AllyUsers)) {	
												SendSimpleMessage($User['id'], $USER['id'],'', 2,$LNG['al_circular_alliance'].$ally['ally_tag']." &amp; ".$DiploInfo[5][$id][5], $LNG['al_diplo_accept_yes'], sprintf($LNG['al_diplo_accept_yes_mes'], $LNG['al_diplo_level'][$Level], $ally['ally_name'], $DiploInfo[5][$id][0]));
											}
											$db->query("UPDATE ".DIPLO." SET `accept` = '1', `accept_text` = '' WHERE `id`='".$id."' LIMIT 1;");
										}
										redirectTo("game.".PHP_EXT."?page=alliance&mode=admin&edit=diplo");
									break;
									case 'decline':
										if(!empty($id))
										{
											$AllyUsers 	= $db->query("SELECT `id` FROM ".USERS." as s WHERE s.ally_id = '".$ally['id']."' OR s.ally_id = '".$DiploInfo[5][$id][1]."';");
											while($User = $db->fetch_array($AllyUsers)) {	
												SendSimpleMessage($User['id'], $USER['id'],'', 2,$LNG['al_circular_alliance'].$ally['ally_tag']." &amp; ".$DiploInfo[5][$id][5], $LNG['al_diplo_accept_no'], sprintf($LNG['al_diplo_accept_no_mes'], $LNG['al_diplo_level'][$Level], $ally['ally_name'], $DiploInfo[5][$id][0]));
											}
											$db->query("DELETE FROM ".DIPLO." WHERE `id` ='".$id."' LIMIT 1;");
										}
										redirectTo("game.".PHP_EXT."?page=alliance&mode=admin&edit=diplo");
									break;
									case 'delete':
										if(!empty($id))
										{
											if(isset($DiploInfo[$Level][$id][1]))
											{
												$AllyUsers = $db->query("SELECT `id` FROM ".USERS." as s WHERE s.ally_id = '".$ally['id']."' OR s.ally_id = '".$DiploInfo[$Level][$id][1]."';");
												while($User = $db->fetch_array($AllyUsers)) {	
													SendSimpleMessage($User['id'], $USER['id'],'', 2,$LNG['al_circular_alliance'].$ally['ally_tag']." &amp; ".$DiploInfo[$Level][$id][3], $LNG['al_diplo_delete'], sprintf($LNG['al_diplo_delete_mes'], $LNG['al_diplo_level'][$Level], $ally['ally_name'], $DiploInfo[$Level][$id][0]));
												}
											}
											$db->query("DELETE FROM ".DIPLO." WHERE `id` ='".$id."' LIMIT 1;");
										}
										redirectTo("game.".PHP_EXT."?page=alliance&mode=admin&edit=diplo");
									break;
									default:
										$this->template->assign_vars(array(
											'DiploInfo' 					=> $DiploInfo,
											'al_diplo_create' 				=> $LNG['al_diplo_create'],
											'al_diplo_level' 				=> $LNG['al_diplo_level'],
											'al_diplo_accept' 				=> $LNG['al_diplo_accept'],
											'al_diplo_accept_send' 			=> $LNG['al_diplo_accept_send'],
											'al_diplo_no_entry' 			=> $LNG['al_diplo_no_entry'],
											'al_diplo_no_accept' 			=> $LNG['al_diplo_no_accept'],
											'al_diplo_confirm_delete'		=> $LNG['al_diplo_confirm_delete'],
											'al_diplo_accept_yes_confirm'	=> $LNG['al_diplo_accept_yes_confirm'],
											'al_diplo_accept_no_confirm'	=> $LNG['al_diplo_accept_no_confirm'],
											'al_diplo_ground'				=> $LNG['al_diplo_ground'],
											'al_back'						=> $LNG['al_back'],
											'ally_id'						=> $ally['id'],
										));
										$this->template->show("alliance_admin_diplo.tpl");
									break;
								}
							break;
							case 'requests':
							
								if (!$USER['rights']['seeapply'] || !$USER['rights']['changeapply'])
									header("location:?page=alliance");

								$text  	= makebr(request_var('text', '', true));

								if ($action == $LNG['al_acept_request'])
                                {
                                    $db->multi_query("UPDATE ".ALLIANCE." SET `ally_members` = `ally_members` + 1 WHERE id='".$ally['id']."';UPDATE ".USERS." SET ally_name='".$ally['ally_name']."', ally_request_text='', ally_request='0', ally_id='".$ally['id']."' WHERE id='".$db->sql_escape($id)."';UPDATE ".STATPOINTS." SET `id_ally` = '".$ally['id']."' WHERE `id_owner` = '".$id."';");

                                    SendSimpleMessage($id, $USER['id'],'', 2,$ally['ally_tag'],$LNG['al_you_was_acceted'] . $ally['ally_name'], $LNG['al_hi_the_alliance'] . $ally['ally_name'] . $LNG['al_has_accepted'] . $text);

                                    redirectTo('game.'.PHP_EXT.'?page=alliance&mode=admin&edit=ally');
                                }
								elseif($action == $LNG['al_decline_request'])
								{
									$db->query("UPDATE ".USERS." SET ally_request_text='',ally_request='0',ally_id='0' WHERE id='".$db->sql_escape($id)."';");

									SendSimpleMessage($id, $USER['id'],'', 2,$ally['ally_tag'],$LNG['al_you_was_declined'] . $ally['ally_name'], $LNG['al_hi_the_alliance'] . $ally['ally_name'] . $LNG['al_has_declined'] . $text);

									redirectTo('game.'.PHP_EXT.'?page=alliance&mode=admin&edit=ally');
								}

								$query = $db->query("SELECT id,username,ally_request_text,ally_register_time FROM ".USERS." WHERE ally_request='".$ally['id']."';");

								while ($RequestRow = $db->fetch_array($query))
								{
									$RequestList[]	= array(
										'username'	=> $RequestRow['username'],
										'text'		=> makebr($RequestRow['ally_request_text']),
										'id'		=> $RequestRow['id'],
										'time' 		=> date("Y-m-d h:i:s", $RequestRow['ally_register_time']),
									);
								}
								
								$this->template->assign_vars(array(
									'RequestList'			=> $RequestList,
									'requestcount'			=> sprintf($LNG['al_no_request_pending'],count($RequestList)),
									'al_no_requests'		=> $LNG['al_no_requests'],
									'al_candidate'			=> $LNG['al_candidate'],
									'al_request_date'		=> $LNG['al_request_date'],
									'al_request_list'		=> $LNG['al_request_list'],
									'al_back'				=> $LNG['al_back'],
									'al_reason'				=> $LNG['al_reason'],
									'al_characters'			=> $LNG['al_characters'],
									'al_request_from_user'	=> $LNG['al_request_from_user'],
									'al_acept_request'		=> $LNG['al_acept_request'],
									'al_decline_request'	=> $LNG['al_decline_request'],
									'al_reply_to_request'	=> $LNG['al_reply_to_request'],
								));	
								$this->template->show("alliance_admin_request.tpl");
							break;
							case 'tag':
								$name = request_var('newname', '', UTF8_SUPPORT);
								
								if (!empty($name))
									$db->query("UPDATE ".ALLIANCE." SET `ally_tag` = '". $db->sql_escape($name) ."' WHERE `id` = '". $USER['ally_id'] ."';");
									
								$this->template->assign_vars(array(
									'caso'					=> $LNG['al_tag'],
									'caso_titulo'			=> $LNG['al_new_tag'],
									'al_change_submit'		=> $LNG['al_change_submit'],
									'al_back'				=> $LNG['al_back'],
								));	
								$this->template->show("alliance_admin_rename.tpl");
							break;
							case 'name':
								$name = request_var('newname', '', UTF8_SUPPORT);
								
								if (!empty($name))
									$db->multi_query("UPDATE ".ALLIANCE." SET `ally_name` = '". $db->sql_escape($name) ."' WHERE `id` = '". $USER['ally_id'] ."';UPDATE ".USERS." SET `ally_name` = '". $db->sql_escape($name) ."' WHERE `ally_id` = '". $ally['id'] ."';");
					
								$this->template->assign_vars(array(
									'caso'					=> $LNG['al_name'],
									'caso_titulo'			=> $LNG['al_new_name'],
									'al_change_submit'		=> $LNG['al_change_submit'],
									'al_back'				=> $LNG['al_back'],
								));	
								$this->template->show("alliance_admin_rename.tpl");
							break;
							case 'exit':
								if (!$USER['rights']['close'])
									redirectTo("game.".PHP_EXT."?page=alliance");

								$db->multi_query("UPDATE ".USERS." SET `ally_name` = '', `ally_id` = '0' WHERE `ally_id`='".$ally['id']."';UPDATE ".STATPOINTS." SET `id_ally` = '0' WHERE `id_ally` = '".$ally['id']."';DELETE FROM ".ALLIANCE." WHERE id = '".$ally['id']."';DELETE FROM ".DIPLO." WHERE `owner_1` = '".$ally['id']."' OR `owner_2` = '".$ally['id']."';");
								redirectTo("game.".PHP_EXT."?page=alliance");
							break;
							case 'transfer':
								if ($ally['ally_owner'] != $USER['id'])
									redirectTo("game.".PHP_EXT."?page=alliance");
									
								$postleader = request_var('newleader', 0);
								if (!empty($postleader))
								{
									$Rank = $db->uniquequery("SELECT `ally_rank_id` FROM ".USERS." WHERE `id` = '".$postleader."';");
									$db->multi_query("UPDATE ".USERS." SET `ally_rank_id` = '".$Rank['ally_rank_id']."' WHERE `id` = '".$USER['id']."';UPDATE ".USERS." SET `ally_rank_id`= '0' WHERE `id` = '".$postleader."';UPDATE ".ALLIANCE." SET `ally_owner` = '".$postleader."' WHERE `id` = '".$USER['ally_id']."';");
									redirectTo("game.".PHP_EXT."?page=alliance");
								}
								else
								{
									$listuser 		= $db->query("SELECT id,ally_rank_id,username FROM ".USERS." WHERE ally_id = '".$USER['ally_id']."';");

									while ($u = $db->fetch_array($listuser))
									{
										if (!empty($u['ally_rank_id']) && $ally['ally_owner'] != $u['id'] && $ally_ranks[$u['ally_rank_id']-1]['rechtehand'] == 1)
										{
											$TransferUsers[$u['id']]	= $u['username']." [".$ally_ranks[$u['ally_rank_id']-1]['name']."]";
										}
									}
						
									$this->template->assign_vars(array(
										'TransferUsers'					=> $TransferUsers,
										'al_transfer_alliance'			=> $LNG['al_transfer_alliance'],
										'al_transfer_to'				=> $LNG['al_transfer_to'],
										'al_back'						=> $LNG['al_back'],
										'al_transfer_submit'			=> $LNG['al_transfer_submit'],
									));	
									$this->template->show("alliance_admin_transfer.tpl");
								}
							break;
							default:
								$text 		= request_var('text', '0', true);
								$t        	= request_var('t', 1 );
								
								if ($_POST['options'])
								{

									$ally['ally_owner_range'] 		= request_var('owner_range','', true);
									$ally['ally_web'] 				= request_var('web','');
									$ally['ally_image'] 			= request_var('image','');
									$ally['ally_request_notallow'] 	= request_var('request_notallow', 0);
									$ally['ally_stats'] 			= request_var('stats', 0);
									$ally['ally_diplo'] 			= request_var('diplo', 0);

									if ($ally['ally_request_notallow'] != 0 && $ally['ally_request_notallow'] != 1)
										exit(redirectTo("game.".PHP_EXT."?page=alliance"));

									$db->query("UPDATE ".ALLIANCE." SET
									`ally_owner_range` = '".$db->sql_escape($ally['ally_owner_range'])."',
									`ally_image` = '".$db->sql_escape($ally['ally_image'])."',
									`ally_web` = '".$db->sql_escape($ally['ally_web'])."',
									`ally_request_notallow` = '".$ally['ally_request_notallow']."',
									`ally_stats` = '".$ally['ally_stats']."',
									`ally_diplo` = '".$ally['ally_diplo']."'
									WHERE `id`='".$ally['id']."';");
								}
								elseif($text !== '0')
								{
									$QryText = "UPDATE ".ALLIANCE." SET ";
									if ($t == 3)
										$QryText .= "`ally_request`='".$db->sql_escape($text)."' ";
									elseif ($t == 2)
										$QryText .= "`ally_text`='".$db->sql_escape($text). "' ";
									else
										$QryText .= "`ally_description`='".$db->sql_escape($text)."' ";
									$QryText .= "WHERE `id`='".$ally['id']."';";
									$db->query($QryText);
								}

								switch($t)
								{
									case 2:
										$text = ($text !== '0') ? $text : $ally['ally_text'];		
									break;
									case 3:
										$text = ($text !== '0') ? $text : $ally['ally_request'];	
									break;
									default:
										$text = ($text !== '0') ? $text : $ally['ally_description'];
									break;
								}

								$this->template->loadscript('alliance.js');
								$this->template->execscript("$('#cntChars').text($('#text').val().length);");
								$this->template->assign_vars(array(
									'al_characters'				=> $LNG['al_characters'],
									'al_manage_alliance'		=> $LNG['al_manage_alliance'],
									'al_textsal_message'		=> $LNG['al_textsal_message'],
									'al_manage_ranks'			=> $LNG['al_manage_ranks'],
									'al_manage_members'			=> $LNG['al_manage_members'],
									'al_manage_change_tag'		=> $LNG['al_manage_change_tag'],
									'al_manage_change_name'		=> $LNG['al_manage_change_name'],
									'al_outside_text'			=> $LNG['al_outside_text'],
									'al_inside_text'			=> $LNG['al_inside_text'],
									'al_request_text'			=> $LNG['al_request_text'],
									'al_circular_reset'			=> $LNG['al_circular_reset'],
									'al_save'					=> $LNG['al_save'],
									'al_continue'				=> $LNG['al_continue'],
									'al_manage_options'			=> $LNG['al_manage_options'],
									'al_web_site'				=> $LNG['al_web_site'],
									'al_manage_image'			=> $LNG['al_manage_image'],
									'al_manage_requests'		=> $LNG['al_manage_requests'],
									'al_manage_founder_rank'	=> $LNG['al_manage_founder_rank'],
									'al_manage_diplo'			=> $LNG['al_manage_diplo'],
									'al_view_stats'				=> $LNG['al_view_stats'],
									'al_view_diplo'				=> $LNG['al_view_diplo'],
									'al_disolve_alliance'		=> $LNG['al_disolve_alliance'],
									'al_transfer_alliance'		=> $LNG['al_transfer_alliance'],
									'al_close_ally'				=> $LNG['al_close_ally'],
									'al_message'				=> ($t == 2) ? $LNG['al_inside_text'] : (($t == 3) ? $LNG['al_request_text'] : $LNG['al_outside_text']),
									'RequestSelector'			=> array(0 => $LNG['al_requests_allowed'], 1 => $LNG['al_requests_not_allowed']),
									'YesNoSelector'				=> array(1 => $LNG['al_go_out_yes'], 0 => $LNG['al_go_out_no']),
									't' 						=> $t,
									'text' 						=> $text,
									'righthand'					=> $USER['rights']['righthand'],
									'ally_web' 					=> $ally['ally_web'],
									'ally_image'				=> $ally['ally_image'],
									'ally_request_notallow' 	=> $ally['ally_request_notallow'],
									'ally_owner_range'			=> $ally['ally_owner_range'],
									'ally_stats_data'			=> $ally['ally_stats'],
									'ally_diplo_data'			=> $ally['ally_diplo'],
								));	
								$this->template->show("alliance_admin.tpl");
							break;
						}
					break;
					default:
						require_once(ROOT_PATH.'includes/functions/BBCode.php');
						if ($ally['ally_owner'] == $USER['id'])
							$range = ($ally['ally_owner_range'] != '') ? $ally['ally_owner_range'] : $LNG['al_founder_rank_text'];
						elseif ($USER['ally_rank_id'] != 0 && isset($ally_ranks[$USER['ally_rank_id']-1]['name']))
							$range = $ally_ranks[$USER['ally_rank_id']-1]['name'];
						else
							$range = $LNG['al_new_member_rank_text'];

						$StatsData 					= $db->uniquequery("SELECT SUM(wons) as wons, SUM(loos) as loos, SUM(draws) as draws, SUM(kbmetal) as kbmetal, SUM(kbcrystal) as kbcrystal, SUM(lostunits) as lostunits, SUM(desunits) as desunits FROM ".USERS." WHERE ally_id='" . $ally['id'] . "';");
						$Reuqests					= $db->uniquequery("SELECT COUNT(*) as state FROM ".USERS." WHERE ally_request='".$ally['id']."';");
						$this->template->assign_vars(array(
							'DiploInfo'					=> $this->GetDiplo($ally['id']),		
							'al_diplo_level'			=> $LNG['al_diplo_level'],
							'al_diplo'					=> $LNG['al_diplo'],
							'ally_web'					=> $ally['ally_web'],
							'ally_tag'	 				=> $ally['ally_tag'],
							'ally_members'	 			=> $ally['ally_members'],
							'ally_name'					=> $ally['ally_name'],
							'ally_image'				=> $ally['ally_image'],
							'ally_description'			=> bbcode($ally['ally_description']),
							'ally_text' 				=> bbcode($ally['ally_text']),
							'range'						=> $range,
							'requests'					=> sprintf($LNG['al_new_requests'], $Reuqests['state']),
							'req_count'					=> $Reuqests['state'],
							'al_requests'				=> $LNG['al_requests'],
							'al_leave_alliance'			=> $LNG['al_leave_alliance'],
							'al_rank'					=> $LNG['al_rank'],
							'al_ally_info_tag'			=> $LNG['al_ally_info_tag'],
							'al_user_list'				=> $LNG['al_user_list'],
							'al_ally_info_name'			=> $LNG['al_ally_info_name'],
							'al_ally_info_members'		=> $LNG['al_ally_info_members'],
							'al_manage_alliance'		=> $LNG['al_manage_alliance'],
							'al_your_ally'				=> $LNG['al_your_ally'],
							'al_Allyquote'				=> $LNG['al_Allyquote'],
							'al_web_text'				=> $LNG['al_web_text'],
							'al_circular_message'		=> $LNG['al_circular_message'],
							'al_send_circular_message'	=> $LNG['al_send_circular_message'],
							'al_description_message'	=> $LNG['al_description_message'] ,
							'al_inside_section'			=> $LNG['al_inside_section'],
							'pl_totalfight'				=> $LNG['pl_totalfight'],
							'pl_fightwon'				=> $LNG['pl_fightwon'],
							'pl_fightlose'				=> $LNG['pl_fightlose'],
							'pl_fightdraw'				=> $LNG['pl_fightdraw'],
							'pl_unitsshot'				=> $LNG['pl_unitsshot'],
							'pl_unitslose'				=> $LNG['pl_unitslose'],
							'pl_dermetal'				=> $LNG['pl_dermetal'],
							'pl_dercrystal'				=> $LNG['pl_dercrystal'],
							'al_goto_chat'				=> $LNG['al_goto_chat'],
							'al_continue'				=> $LNG['al_continue'],
							'al_leave_alliance'			=> $LNG['al_leave_alliance'],
							'al_leave_ally'				=> $LNG['al_leave_ally'],
							'totalfight'				=> $StatsData['wons'] + $StatsData['loos'] + $StatsData['draws'],
							'fightwon'					=> $StatsData['wons'],
							'fightlose'					=> $StatsData['loos'],
							'fightdraw'					=> $StatsData['draws'],
							'unitsshot'					=> pretty_number($StatsData['desunits']),
							'unitslose'					=> pretty_number($StatsData['lostunits']),
							'dermetal'					=> pretty_number($StatsData['kbmetal']),
							'dercrystal'				=> pretty_number($StatsData['kbcrystal']),
							'isowner'					=> ($ally['ally_owner'] != $USER['id']) ? true : false,
							'rights'					=> $USER['rights'],
						));
						$this->template->show("alliance_frontpage.tpl");
					break;
				}
			break;
		}
		
	}
}
?>