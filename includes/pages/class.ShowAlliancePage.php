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

if(!defined('INSIDE')){ die(header("location:../../"));}

class ShowAlliancePage
{
	private function bbcode($string)
	{
		$pattern = array(
		    '/\\r/',
		    '/\[list\](.*?)\[\/list\]/ise',
		    '/\[b\](.*?)\[\/b\]/is',
		    '/\[strong\](.*?)\[\/strong\]/is',
		    '/\[i\](.*?)\[\/i\]/is',
		    '/\[u\](.*?)\[\/u\]/is',
		    '/\[s\](.*?)\[\/s\]/is',
		    '/\[del\](.*?)\[\/del\]/is',
		    '/\[url=(.*?)\](.*?)\[\/url\]/ise',
		    '/\[email=(.*?)\](.*?)\[\/email\]/is',
		    '/\[img](.*?)\[\/img\]/ise',
		    '/\[color=(.*?)\](.*?)\[\/color\]/is',
		    '/\[quote\](.*?)\[\/quote\]/ise',
		    '/\[code\](.*?)\[\/code\]/ise',
		    '/\[font=(.*?)\](.*?)\[\/font\]/ise',
		    '/\[bg=(.*?)\](.*?)\[\/bg\]/ise',
		    '/\[size=(.*?)\](.*?)\[\/size\]/ise'
		);

		$replace = array(
		    '',
		    '$this->sList(\'\\1\')',
		    '<b>\1</b>',
		    '<strong>\1</strong>',
		    '<i>\1</i>',
		    '<span style="text-decoration: underline;">\1</span>',
		    '<span style="text-decoration: line-through;">\1</span>',
		    '<span style="text-decoration: line-through;">\1</span>',
		    '$this->urlfix(\'\\1\',\'\\2\')',
		    '<a href="mailto:\1" title="\1">\2</a>',
		    '$this->imagefix(\'\\1\')',
		    '<span style="color: \1;">\2</span>',
		    '$this->sQuote(\'\1\')',
		    '$this->sCode(\'\1\')',
		    '$this->fontfix(\'\\1\',\'\\2\')',
		    '$this->bgfix(\'\\1\',\'\\2\')',
		    '$this->sizefix(\'\\1\',\'\\2\')'
		);

		return preg_replace($pattern, $replace, makebr($string));
	}

	private function sCode($string)
	{
		$pattern =  '/\<img src=\\\"(.*?)img\/smilies\/(.*?).png\\\" alt=\\\"(.*?)\\\" \>/s';
		$string = preg_replace($pattern, '\3', $string);
		return '<pre style="color: #DDDD00; background-color:gray ">' . trim($string) . '</pre>';
	}

	private function sQuote($string)
	{
		$pattern =  '/\<img src=\\\"(.*?)img\/smilies\/(.*?).png\\\" alt=\\\"(.*?)\\\" \>/s';
		$string = preg_replace($pattern, '\3', $string);
		return '<blockquote><p style="color: #000000; font-size: 10pt; background-color:55AACC; font-family: Arial">' . trim($string) . '</p></blockquote>';
	}

	private function sList($string)
	{
		$tmp = explode('[*]', stripslashes($string));
		$out = null;
		foreach($tmp as $list) {
			if(strlen(str_replace('', '', $list))> 0) {
				$out .= '<li>' . trim($list) . '</li>';
			}
		}
		return '<ul>' . $out . '</ul>';
	}

	private function imagefix($img)
	{
		if(substr($img, 0, 7) != 'http://')
		{
			$img = './images/' . $img;
		}
		return '<img src="' . $img . '" alt="' . $img . '" title="' . $img . '">';
	}

	private function urlfix($url, $title)
	{
		$title = stripslashes($title);
		return '<a href="' . $url . '" title="' . $title . '">' . $title . '</a>';
	}

	private function fontfix($font, $title)
	{
		$title = stripslashes($title);
		return '<span style="font-family:' . $font . '">' . $title . '</span>';
	}

	private function bgfix($bg, $title)
	{
		$title = stripslashes($title);
		return '<span style="background-color:' . $bg . '">' . $title . '</span>';
	}

	private function sizefix($size, $text)
	{
		$title = stripslashes($text);
		return '<span style="font-size:' . $size . 'px">' . $title . '</span>';
	}

	private function MessageForm($Title, $Message, $Goto = '', $Button = ' ok ', $TwoLines = false)
	{
		$Form .= "<div id=\"content\"><form action=\"". $Goto ."\" method=\"post\">";
		$Form .= "<table width=\"519\" align=\"center\">";
		$Form .= "<tr>";
		$Form .= "<td class=\"c\" colspan=\"2\">". $Title ."</td>";
		$Form .= "</tr><tr>";
		if ($TwoLines == true)
		{
			$Form .= "<th colspan=\"2\">". $Message ."</th>";
			$Form .= "</tr><tr>";
			$Form .= "<th colspan=\"2\" align=\"center\"><input type=\"submit\" value=\"". $Button ."\"></th>";
		}
		else
			$Form .= "<th colspan=\"2\">". $Message ."<input type=\"submit\" value=\"". $Button ."\"></th>";
		$Form .= "</tr>";
		$Form .= "</table>";
		$Form .= "</form>";
		$Form .= "</div>";

		return $Form;
	}

	private function ainfo($ally, $CurrentUser, $CurrentPlanet) 
	{
		global $lang, $db;
		
		if ($ally['ally_stats'] == 1)
		{
			$StatsData 					= $db->fetch_array($db->query("SELECT SUM(wons) as wons, SUM(loos) as loos, SUM(draws) as draws, SUM(kbmetal) as kbmetal, SUM(kbcrystal) as kbcrystal, SUM(lostunits) as lostunits, SUM(desunits) as desunits FROM ".USERS." WHERE ally_id='" . $ally['id'] . "';"));

			$this->template->assign_vars(array(
				'al_Allyquote'	=> $lang['al_Allyquote'],
				'pl_totalfight'	=> $lang['pl_totalfight'],
				'pl_fightwon'	=> $lang['pl_fightwon'],
				'pl_fightlose'	=> $lang['pl_fightlose'],
				'pl_fightdraw'	=> $lang['pl_fightdraw'],
				'pl_unitsshot'	=> $lang['pl_unitsshot'],
				'pl_unitslose'	=> $lang['pl_unitslose'],
				'pl_dermetal'	=> $lang['pl_dermetal'],
				'pl_dercrystal'	=> $lang['pl_dercrystal'],
				'totalfight'	=> pretty_number($StatsData['wons'] + $StatsData['loos'] + $StatsData['draws']),
				'fightwon'		=> pretty_number($StatsData['wons']),
				'fightlose'		=> pretty_number($StatsData['loos']),
				'fightdraw'		=> pretty_number($StatsData['draws']),
				'unitsshot'		=> pretty_number($StatsData['desunits']),
				'unitslose'		=> pretty_number($StatsData['lostunits']),
				'dermetal'		=> pretty_number($StatsData['kbmetal']),
				'dercrystal'	=> pretty_number($StatsData['kbcrystal']),
			));
		}
		$this->template->assign_vars(array(
			'al_ally_info_members'		=> $lang['al_ally_info_members'],
			'al_ally_info_name'			=> $lang['al_ally_info_name'],
			'al_ally_info_tag'			=> $lang['al_ally_info_tag'],
			'al_ally_information'		=> $lang['al_ally_information'],
			'al_description_message'	=> $lang['al_description_message'],
			'al_web_text'				=> $lang['al_web_text'],
			'al_click_to_send_request'	=> $lang['al_click_to_send_request'],
			'al_request'				=> $lang['al_request'],
			'ally_description' 			=> $this->bbcode($ally['ally_description']),
			'ally_id'	 				=> $ally['id'],
			'ally_image' 				=> $ally['ally_image'],
			'ally_web'					=> $ally['ally_web'],
			'ally_member_scount' 		=> $ally['ally_members'],
			'ally_name' 				=> $ally['ally_name'],
			'ally_tag' 					=> $ally['ally_tag'],
			'ally_request'				=> ($CurrentUser['ally_id'] == 0 && $ally['ally_request_notallow'] == 1) ? true : false,
		));
		
		$this->template->show("alliance_ainfo.tpl");
	}
	
	public function ShowAlliancePage($CurrentUser, $CurrentPlanet)
	{
		global $dpath, $lang, $db;

		$parse 		= $lang;

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
		$show     	= request_var('show'  		, '');
		$sendmail 	= request_var('sendmail'  	, '');
		$t        	= request_var('t'  			, 1 );
		$tag      	= request_var('tag' 		, '');

		if (empty($sort2))	unset($sort2);
		if (empty($a))		unset($a);
		if (empty($mode)) 	unset($mode);
		if (empty($sort1))	unset($sort1);
		if (empty($edit))	unset($edit);
		if (empty($rank))	unset($rank);
		if (empty($kick))	unset($kick);
		if (empty($id))		unset($id);
		
		$this->PlanetRess = new ResourceUpdate($CurrentUser, $CurrentPlanet);
		$this->template	= new template();
		$this->template->loadscript("trader.js");
		$this->template->set_vars($CurrentUser, $CurrentPlanet);
		$this->template->page_topnav();
		$this->template->page_header();
		$this->template->page_leftmenu();
		$this->template->page_planetmenu();
		$this->template->page_footer();

		if ($CurrentUser['ally_id'] != 0 && $CurrentUser['ally_request'] != 0)
		{
			$db->query("UPDATE `".USERS."` SET `ally_id` = 0 WHERE `id` = ".$CurrentUser['id'].";");
			header("location:game.". PHP_EXT . "?page=alliance");
		}
		
		switch($CurrentUser['ally_id'])
		{
			case 0:
				switch($mode){
					case 'ainfo':
						$allyrow = $db->fetch_array($db->query("SELECT * FROM ".ALLIANCE." WHERE ally_tag='".$db->sql_escape($tag)."' OR id='".$db->sql_escape($a)."';"));

						if (!$allyrow) die(header("Location: game.". PHP_EXT . "?page=alliance"));
						
						$this->ainfo($allyrow, $CurrentUser, $CurrentPlanet);					
					break;
					case 'make':
						if($CurrentUser['ally_request'] == 0)
						{	
							if ($action == "send")
							{
								$atag	= request_var('atag' , '', UTF8_SUPPORT);
								$aname	= request_var('aname', '', UTF8_SUPPORT);
								
								if (empty($atag))
								{
									$this->template->message($lang['al_tag_required'], "?page=alliance&mode=make", 3);
									$this->PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
									exit;
								}

								if (empty($aname))
								{
									$this->template->message($lang['al_name_required'], "?page=alliance&mode=make", 3);
									$this->PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
									exit;
								}
								
								if (!CheckName($aname) || !CheckName($atag))
								{
									$this->template->message((UTF8_SUPPORT) ? $lang['al_newname_no_space'] : $lang['al_newname_alphanum'], "?page=alliance&mode=make", 3);
									$this->PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
									exit;
								}
								
								$tagquery = $db->fetch_array($db->query("SELECT `id` FROM `".ALLIANCE."` WHERE ally_tag = '".$db->sql_escape($atag)."' OR ally_name = '".$db->sql_escape($aname)."';"));

								if (isset($tagquery))
								{
									$this->template->message(sprintf($lang['al_already_exists'], $aname), "?page=alliance&mode=make", 3);
									$this->PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
									exit;
								}
								
								$db->multi_query("INSERT INTO ".ALLIANCE." SET
								`ally_name`='".$db->sql_escape($aname)."',
								`ally_tag`='".$db->sql_escape($atag)."' ,
								`ally_owner`='".$CurrentUser['id']."',
								`ally_owner_range`='Leader',
								`ally_members`='1',
								`ally_register_time`='" . time()."';
								UPDATE ".USERS." SET
								`ally_id`= (SELECT `id` FROM ".ALLIANCE." WHERE ally_name = '".$db->sql_escape($aname)."'),
								`ally_name` = '".$db->sql_escape($aname)."',
								`ally_register_time` = '" . time() . "'
								WHERE `id` = '".$CurrentUser['id']."';");
											
								$this->template->message(sprintf($lang['al_created'], $atag),"?page=alliance", 3);
							} else {
								$this->template->assign_vars(array(
									'al_make_alliance'				=> $lang['al_make_alliance'],
									'al_make_ally_tag_required'		=> $lang['al_make_ally_tag_required'],
									'al_make_ally_name_required'	=> $lang['al_make_ally_name_required'],
									'al_make_submit'				=> $lang['al_make_submit'],
								));	
								$this->template->show("alliance_make.tpl");
							}		
						
						} else {
							header("Location: game.". PHP_EXT . "?page=alliance");
						}
					break;
					case 'search';
						if($CurrentUser['ally_request'] == 0)
						{
							$searchtext	= request_var('searchtext', '', UTF8_SUPPORT);

							if (!empty($searchtext))
							{
								$Search = $db->query("SELECT id, ally_tag, ally_name, ally_members FROM ".ALLIANCE." WHERE ally_name LIKE '%".$db->sql_escape($searchtext)."%' OR ally_tag LIKE '%".$db->sql_escape($searchtext)."%' LIMIT 30;");
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
								'al_find_submit'					=> $lang['al_find_submit'],
								'al_find_text'						=> $lang['al_find_text'],
								'al_find_alliances'					=> $lang['al_find_alliances'],
								'al_make_submit'					=> $lang['al_make_submit'],
								'al_find_no_alliances'				=> $lang['al_find_no_alliances'],
								'al_ally_info_members'				=> $lang['al_ally_info_members'],
								'al_ally_info_name'					=> $lang['al_ally_info_name'],
								'al_ally_info_tag'					=> $lang['al_ally_info_tag'],
							));	
							
							$this->template->show("alliance_searchform.tpl");
						} else {
							header("Location: ?page=alliance");
						}
					break;
					case 'apply':
						if($CurrentUser['ally_request'] == 0)
						{
							$text	= request_var('text'  , '');
							
							$allyrow = $db->fetch_array($db->query("SELECT `ally_tag`, `ally_request`, `ally_request_notallow` FROM ".ALLIANCE." WHERE id='".$db->sql_escape($allyid)."';"));

							if (!$allyrow)
								header("Location: ?page=alliance");
									
							if($allyrow['ally_request_notallow'] == 1)
							{
								$this->template->message($lang['al_alliance_closed']);
								$this->PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
								exit;
							}
							else
							{
								if ($action == "send")
								{
									$db->query("UPDATE ".USERS." SET `ally_request`='".$db->sql_escape($allyid)."', ally_request_text='" .$db->sql_escape($text). "', ally_register_time='" . time() . "' WHERE `id`='" . $CurrentUser['id'] . "';");

									$this->template->message($lang['al_request_confirmation_message'], "?page=alliance");
								} else {
									$this->template->assign_vars(array(
										'allyid'					=> $allyid,
										'al_your_request_title'		=> $lang['al_your_request_title'],
										'applytext'					=> ($ally_request) ? $ally_request : $lang['al_default_request_text'],
										'al_write_request'			=> sprintf($lang['al_write_request'], $allyrow['ally_tag']),
										'al_applyform_reload'		=> $lang['al_applyform_reload'],
										'al_applyform_send'			=> $lang['al_applyform_send'],
										'al_message'				=> $lang['al_message'],
									));	
									
									$this->template->show("alliance_applyform.tpl");
								}
							}
						} else {
							header("Location: ?page=alliance");
						}
					break;
					default:
						if ($CurrentUser['ally_request'] != 0) 
						{
							$allyquery 	= $db->fetch_array($db->query("SELECT ally_tag FROM ".ALLIANCE." WHERE id = '".$CurrentUser['ally_request']. "' ORDER BY `id`;"));
							$bcancel	= request_var('bcancel', '');
							
							if ($bcancel)
							{
								$db->query("UPDATE ".USERS." SET `ally_request`= 0 WHERE `id`='".$CurrentUser['id']."';");
								$this->template->assign_vars(array(
									'al_your_request_title'			=> $lang['al_your_request_title'],
									'button_text'					=> $lang['al_continue'],
									'request_text'					=> sprintf($lang['al_request_deleted'], $allyquery['ally_tag']),
									'al_make_submit'				=> $lang['al_continue'],
								));	
							}
							else
							{								
								$this->template->assign_vars(array(
									'al_your_request_title'			=> $lang['al_your_request_title'],
									'button_text'					=> $lang['al_delete_request'],
									'request_text'					=> sprintf($lang['al_request_wait_message'], $allyquery['ally_tag']),
									'al_make_submit'				=> $lang['al_make_submit'],
								));	
							}

							$this->template->show("alliance_apply_waitform.tpl");
						}
						else
						{
							$this->template->assign_vars(array(
								'al_alliance_search'			=> $lang['al_alliance_search'],
								'al_alliance_make'				=> $lang['al_alliance_make'],
								'al_alliance'					=> $lang['al_alliance'],
							));	
							$this->template->show("alliance_defaultmenu.tpl");
						}
					break;
				}
			break;
			default:

				$ally = $db->fetch_array($db->query("SELECT * FROM ".ALLIANCE." WHERE id='".$CurrentUser['ally_id']."';"));
				$ally_ranks = unserialize($ally['ally_ranks']);

				if ($ally_ranks[$CurrentUser['ally_rank_id']-1]['onlinestatus'] == 1 || $ally['ally_owner'] == $CurrentUser['id'])
					$user_can_watch_memberlist_status = true;
				else
					$user_can_watch_memberlist_status = false;

				if ($ally_ranks[$CurrentUser['ally_rank_id']-1]['memberlist'] == 1 || $ally['ally_owner'] == $CurrentUser['id'])
					$user_can_watch_memberlist = true;
				else
					$user_can_watch_memberlist = false;

				if ($ally_ranks[$CurrentUser['ally_rank_id']-1]['mails'] == 1 || $ally['ally_owner'] == $CurrentUser['id'])
					$user_can_send_mails = true;
				else
					$user_can_send_mails = false;

				if ($ally_ranks[$CurrentUser['ally_rank_id']-1]['kick'] == 1 || $ally['ally_owner'] == $CurrentUser['id'])
					$user_can_kick = true;
				else
					$user_can_kick = false;

				if ($ally_ranks[$CurrentUser['ally_rank_id']-1]['rechtehand'] == 1 || $ally['ally_owner'] == $CurrentUser['id'])
					$user_can_edit_rights = true;
				else
					$user_can_edit_rights = false;

				if ($ally_ranks[$CurrentUser['ally_rank_id']-1]['delete'] == 1 || $ally['ally_owner'] == $CurrentUser['id'])
					$user_can_exit_alliance = true;
				else
					$user_can_exit_alliance = false;

				if ($ally_ranks[$CurrentUser['ally_rank_id']-1]['bewerbungen'] == 1 || $ally['ally_owner'] == $CurrentUser['id'])
					$user_bewerbungen_einsehen = true;
				else
					$user_bewerbungen_einsehen = false;

				if ($ally_ranks[$CurrentUser['ally_rank_id']-1]['bewerbungenbearbeiten'] == 1 || $ally['ally_owner'] == $CurrentUser['id'])
					$user_bewerbungen_bearbeiten = true;
				else
					$user_bewerbungen_bearbeiten = false;

				if ($ally_ranks[$CurrentUser['ally_rank_id']-1]['administrieren'] == 1 || $ally['ally_owner'] == $CurrentUser['id'])
					$user_admin = true;
				else
					$user_admin = false;

				if ($ally_ranks[$CurrentUser['ally_rank_id']-1]['onlinestatus'] == 1 || $ally['ally_owner'] == $CurrentUser['id'])
					$user_onlinestatus = true;
				else
					$user_onlinestatus = false;

				if (!$ally)
				{
					$db->query("UPDATE `".USERS."` SET `ally_id` = 0 WHERE `id` = ".$CurrentUser['id'].";");
					header("location:game.". PHP_EXT . "?page=alliance");
				}
				switch($mode){
					case 'ainfo':
						$allyrow = $db->fetch_array($db->query("SELECT * FROM ".ALLIANCE." WHERE ally_tag='".$db->sql_escape($tag)."' OR id='".$db->sql_escape($a)."';"));

						if (!$allyrow) die(header("location:game.". PHP_EXT . "?page=alliance"));
						
						$this->ainfo($allyrow, $CurrentUser, $CurrentPlanet);	
					break;
					case 'exit':
						if ($ally['ally_owner'] == $CurrentUser['id'])
							message($lang['al_founder_cant_leave_alliance'],"game.php?page=alliance");

						if ($_GET['yes'] == 1)
						{
							$db->query("UPDATE ".USERS." SET `ally_id` = 0, `ally_name` = '', ally_rank_id = 0 WHERE `id`='".$CurrentUser['id']."';");
							$db->query("UPDATE ".ALLIANCE." SET `ally_members` = `ally_members` - 1 WHERE `id`='".$ally['id']."';");

							$lang['Go_out_welldone'] = str_replace("%s", $ally_name, $lang['al_leave_sucess']);
							$page = $this->MessageForm($lang['Go_out_welldone'], "<br>", $PHP_SELF, $lang['al_continue']);
						}
						else
						{
							$lang['Want_go_out'] = str_replace("%s", $ally_name, $lang['al_do_you_really_want_to_go_out']);
							$page = $this->MessageForm($lang['Want_go_out'], "<br>", "game.php?page=alliance&mode=exit&yes=1", $lang['al_go_out_yes']);
						}
						display($page);
					break;
					case 'memberslist':
						if ($ally['ally_owner'] != $CurrentUser['id'] && !$user_can_watch_memberlist)
							header("location:game.". PHP_EXT . "?page=alliance");

						if ($sort2 && $sort1)
						{
							if ($sort1 == 1) {
							$sort = " ORDER BY `username`";
							} elseif ($sort1 == 2) {
							$sort = " ORDER BY `ally_rank_id`";
							} elseif ($sort1 == 3) {
							$sort = " ORDER BY `total_points`";
							} elseif ($sort1 == 4) {
							$sort = " ORDER BY `ally_register_time`";
							} elseif ($sort1 == 5) {
							$sort = " ORDER BY `onlinetime`";
							} else {
							$sort = " ORDER BY `id`";
							}

							if ($sort2 == 1) {
							$sort .= " DESC;";
							} elseif ($sort2 == 2) {
							$sort .= " ASC;";
							}
							$listuser = $db->query("SELECT * FROM `".USERS."` inner join `".STATPOINTS."` on `".USERS."`.`id`=`".STATPOINTS."`.`id_owner` WHERE ally_id='".$CurrentUser['ally_id']."' AND STAT_type=1 ".$sort.";");
						}
						else
							$listuser = $db->query("SELECT * FROM `".USERS."` WHERE ally_id='".$CurrentUser['ally_id']."';");

						$i = 0;

						while ($u = $db->fetch_array($listuser))
						{
							$UserPoints = $db->fetch_array($db->query("SELECT total_points FROM ".STATPOINTS." WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '".$u['id'] . "';"));

							$i++;
							$u['i'] = $i;

							if ($u["onlinetime"] + 60 * 4 >= time() && $user_can_watch_memberlist_status)
								$u["onlinetime"] = "\"lime\">".$lang['al_memberlist_on']."<";
							elseif (time() - $u["onlinetime"] >= 60 * 4 && $user_can_watch_memberlist_status)
								$u["onlinetime"] = "\"yellow\">".round((time() - $u["onlinetime"])/60)." ".$lang['al_memberlist_min']."<";
							elseif ($user_can_watch_memberlist_status)
								$u["onlinetime"] = "\"red\">".$lang['al_memberlist_off']."<";
							else
								$u["onlinetime"] = "\"orange\">-<";

							if ($ally['ally_owner'] == $u['id'])
								$u["ally_range"] = ($ally['ally_owner_range'] == '')?$lang['al_founder_rank_text']:$ally['ally_owner_range'];
							elseif ($u['ally_rank_id'] == 0 )
								$u["ally_range"] = $lang['al_new_member_rank_text'];
							else
								$u["ally_range"] = $ally_ranks[$u['ally_rank_id']-1]['name'];

							$u["dpath"] 	= $dpath;
							$u['points'] 	= "" . pretty_number($UserPoints['total_points']) . "";

							if ($u['ally_register_time']> 0)
								$u['ally_register_time'] = date("Y-m-d h:i:s", $u['ally_register_time']);
							else
								$u['ally_register_time'] = "-";

							$page_list .= parsetemplate(gettemplate('alliance/alliance_memberslist_row'), $u);
						}

						if ($sort2 == 1) {$s = 2;}
						elseif ($sort2 == 2) {$s = 1;}
						else {$s = 1;}

						if ($i != $ally['ally_members'])
							$db->query("UPDATE ".ALLIANCE." SET `ally_members`='".$i."' WHERE `id`='".$ally['id']."';");
						$parse['i'] = $i;
						$parse['s'] = $s;
						$parse['list'] = $page_list;

						display(parsetemplate(gettemplate('alliance/alliance_memberslist_table'), $parse));
					break;
					case 'circular':
					
						if ($ally['ally_owner'] != $CurrentUser['id'] && !$user_can_send_mails)
							header("location:game.". PHP_EXT . "?page=alliance");

						if ($sendmail == 1)
						{
							$r 		= request_var('r','');
							$text 	= request_var('text','');

							if ($_POST['r'] == 0)
								$sq = $db->query("SELECT id,username FROM ".USERS." WHERE ally_id='".$CurrentUser['ally_id']."';");
							else
								$sq = $db->query("SELECT id,username FROM ".USERS." WHERE ally_id='".$CurrentUser['ally_id']."' AND ally_rank_id='".$db->sql_escape($r)."';");

							$list = '';

							while ($u = $db->fetch_array($sq))
							{
								SendSimpleMessage($u['id'],$CurrentUser['id'],'',2,"Allianz ".$ally['ally_tag'],$CurrentUser['username'],$text);

								$list .= "\n".$u['username'];
							}

							exit($lang['al_circular_sended'].$list);
						}

						$lang['r_list'] = "<option value=\"0\">".$lang['al_all_players']."</option>";

						if ($ally_ranks)
						{
							foreach($ally_ranks as $id => $array)
							{
								$lang['r_list'] .= "<option value=\"" . ($id + 1) . "\">" . $array['name'] . "</option>";
							}
						}

						display(parsetemplate(gettemplate('alliance/alliance_circular'), $lang),false,'',false,false);
					break;
					case 'admin':
						switch($edit) {
							case 'rights':
								if ($ally['ally_owner'] != $CurrentUser['id'] && !$user_can_edit_rights){ header("location:game.". PHP_EXT . "?page=alliance");exit;}
								
								$rankname 	= request_var('newrangname', '');
								$pid 		= $_POST['id'];			
								$d    		= request_var('d', 1337 );
								if ($rankname != '')
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

									$goto = $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'];

									header("Location: " . $goto);
									exit();
								}
								elseif (is_array($pid))
								{
									$ally_ranks_new = array();
									foreach ($pid as $id)
									{
										$ally_ranks_new[$id]['name'] 					= $ally_ranks[$id]['name'];
										$ally_ranks_new[$id]['delete'] 					= (isset($_POST['u' . $id . 'r0']) && $ally['ally_owner'] == $CurrentUser['id']) ? 1 : 0;
										$ally_ranks_new[$id]['kick'] 					= (isset($_POST['u' . $id . 'r1']) && $ally['ally_owner'] == $CurrentUser['id']) ? 1 : 0;
										$ally_ranks_new[$id]['bewerbungen'] 			= (isset($_POST['u' . $id . 'r2'])) ? 1 : 0;
										$ally_ranks_new[$id]['memberlist'] 				= (isset($_POST['u' . $id . 'r3'])) ? 1 : 0;
										$ally_ranks_new[$id]['bewerbungenbearbeiten'] 	= (isset($_POST['u' . $id . 'r4'])) ? 1 : 0;
										$ally_ranks_new[$id]['administrieren'] 			= (isset($_POST['u' . $id . 'r5'])) ? 1 : 0;
										$ally_ranks_new[$id]['onlinestatus'] 			= (isset($_POST['u' . $id . 'r6'])) ? 1 : 0;
										$ally_ranks_new[$id]['mails'] 					= (isset($_POST['u' . $id . 'r7'])) ? 1 : 0;
										$ally_ranks_new[$id]['rechtehand'] 				= (isset($_POST['u' . $id . 'r8'])) ? 1 : 0;
									}

									$ranks = serialize($ally_ranks_new);

									$db->query("UPDATE ".ALLIANCE." SET `ally_ranks`='" . $ranks . "' WHERE `id`='" . $ally['id'] ."';");
									header("Location: " . $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING']);
									exit;

								}
								elseif(isset($ally_ranks[$d]))
								{
									unset($ally_ranks[$d]);
									$db->query("UPDATE ".ALLIANCE." SET `ally_ranks`='".serialize($ally_ranks)."' WHERE `id`='".$ally['id']."';");
								}
					
								
								if (count($ally_ranks) == 0 || $ally_ranks == '')
								{
									$list = "<th>".$lang['al_no_ranks_defined']."</th>";
								}
								else
								{
									$list = parsetemplate(gettemplate('alliance/alliance_admin_laws_head'), $lang);
									$i = 0;
									foreach($ally_ranks as $a => $b)
									{
										$lang['id'] = $a;
										$lang['r0'] = $b['name'];
										$lang['delete'] = "<a href=\"game.php?page=alliance&mode=admin&edit=rights&d={$a}\"><img src=\"{$dpath}pic/abort.gif\" alt=\"".$lang['Delete_range']."\" border=\"0\"></a>";
										$lang['a'] = $a;
										$lang['r1'] = ($ally['ally_owner'] == $CurrentUser['id']) ? "<input type=checkbox name=\"u{$a}r0\"" . (($b['delete'] == 1)?' checked="checked"':'') . ">" : "<b>-</b>";
										$lang['r2'] = "<input type=checkbox name=\"u{$a}r1\"" . (($b['kick'] == 1)?' checked="checked"':'') . ">";
										$lang['r3'] = "<input type=checkbox name=\"u{$a}r2\"" . (($b['bewerbungen'] == 1)?' checked="checked"':'') . ">";
										$lang['r4'] = "<input type=checkbox name=\"u{$a}r3\"" . (($b['memberlist'] == 1)?' checked="checked"':'') . ">";
										$lang['r5'] = "<input type=checkbox name=\"u{$a}r4\"" . (($b['bewerbungenbearbeiten'] == 1)?' checked="checked"':'') . ">";
										$lang['r6'] = "<input type=checkbox name=\"u{$a}r5\"" . (($b['administrieren'] == 1)?' checked="checked"':'') . ">";
										$lang['r7'] = "<input type=checkbox name=\"u{$a}r6\"" . (($b['onlinestatus'] == 1)?' checked="checked"':'') . ">";
										$lang['r8'] = "<input type=checkbox name=\"u{$a}r7\"" . (($b['mails'] == 1)?' checked="checked"':'') . ">";
										$lang['r9'] = "<input type=checkbox name=\"u{$a}r8\"" . (($b['rechtehand'] == 1)?' checked="checked"':'') . ">";

										$list .= parsetemplate(gettemplate('alliance/alliance_admin_laws_row'), $lang);
									}
									
									$list .= parsetemplate(gettemplate('alliance/alliance_admin_laws_feet'), $lang);
								}

								$lang['list'] 	= $list;
								$lang['dpath'] 	= $dpath;
								display(parsetemplate(gettemplate('alliance/alliance_admin_laws'), $lang));
							break;
							case 'members':
								if ($ally['ally_owner'] != $CurrentUser['id'] && $user_admin == false)
									header("location:game.". PHP_EXT . "?page=alliance");

								if (isset($kick))
									{
									if ($ally['ally_owner'] != $CurrentUser['id'] && !$user_can_kick)
										header("location:game.". PHP_EXT . "?page=alliance");

									$u = $db->fetch_array($db->query("SELECT ally_id,id FROM ".USERS." WHERE id='".$db->sql_escape($kick)."' LIMIT 1;"));

									if ($u['ally_id'] == $ally['id'] && $u['id'] != $ally['ally_owner'])
										$db->query("UPDATE ".USERS." SET `ally_id`='0', `ally_name`='', `ally_rank_id` = 0 WHERE `id`='".$db->sql_escape($u['id'])."' LIMIT 1;");
								}
								elseif (isset($_POST['newrang']))
								{
									$q = $db->fetch_array($db->query("SELECT id FROM ".USERS." WHERE id='".$db->sql_escape($u)."' LIMIT 1;"));

									if ((isset($ally_ranks[$_POST['newrang']-1]) || $_POST['newrang'] == 0) && $q['id'] != $ally['ally_owner'])
										$db->query("UPDATE ".USERS." SET `ally_rank_id`='" . $db->sql_escape(strip_tags($_POST['newrang'])) . "' WHERE `id`='".$db->sql_escape($id) . "';");
								}

								if ($sort2)
								{
									$sort1 		= request_var('sort1', '');
									$sort2 		= request_var('sort2', '');

									if ($sort1 == 1) {
										$sort = " ORDER BY `username`";
									} elseif ($sort1 == 2) {
										$sort = " ORDER BY `ally_rank_id`";
									} elseif ($sort1 == 3) {
										$sort = " ORDER BY `total_points`";
									} elseif ($sort1 == 4) {
										$sort = " ORDER BY `ally_register_time`";
									} elseif ($sort1 == 5) {
										$sort = " ORDER BY `onlinetime`";
									} else {
										$sort = " ORDER BY `id`";
									}

									if ($sort2 == 1) {
										$sort .= " DESC;";
									} elseif ($sort2 == 2) {
										$sort .= " ASC;";
									}
									$listuser = $db->query("SELECT * FROM `".USERS."` inner join `".STATPOINTS."` on `".USERS."`.`id`=`".STATPOINTS."`.`id_owner` WHERE ally_id='".$CurrentUser['ally_id']."' AND STAT_type=1 ".$sort.";");
								}
								else
								{
									$listuser = $db->query("SELECT * FROM ".USERS." WHERE ally_id='".$CurrentUser['ally_id']."';");
								}

								$i 				= 0;
								$r				= $lang;
								$s				= $lang;
								$lang['i'] 		= $db->num_rows($listuser);

								while ($u = $db->fetch_array($listuser))
								{
									$UserPoints = $db->fetch_array($db->query("SELECT * FROM ".STATPOINTS." WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '".$u['id'] . "';"));

									$i++;
									$u['i'] = $i;

									$u['points'] = "" . pretty_number($UserPoints['total_points']) . "";

									$days = floor(round(time() - $u["onlinetime"]) / 3600 % 24);

									$u["onlinetime"] = str_replace("%s", $days, "%s d");

									if ($ally['ally_owner'] == $u['id'])
										$ally_range = ($ally['ally_owner_range'] == '')?$lang['al_founder_rank_text']:$ally['ally_owner_range'];
									elseif ($u['ally_rank_id'] == 0 || !isset($ally_ranks[$u['ally_rank_id']-1]['name']))
										$ally_range = $lang['al_new_member_rank_text'];
									else
										$ally_range = $ally_ranks[$u['ally_rank_id']-1]['name'];

									if ($ally['ally_owner'] == $u['id'] || $rank == $u['id'])
										$u["acciones"] = '-';
									elseif ($ally_ranks[$CurrentUser['ally_rank_id']-1]['kick'] == 1  &&  $ally_ranks[$CurrentUser['ally_rank_id']-1]['administrieren'] == 1 || $ally['ally_owner'] == $CurrentUser['id'])
										$u["acciones"] = "<a href=\"game.php?page=alliance&mode=admin&edit=members&kick=$u[id]\" onclick=\"javascript:return confirm('¿Estás seguro que deseas expulsar a $u[username]?');\"><img src=\"".$dpath."pic/abort.gif\" border=\"0\"></a> <a href=\"game.php?page=alliance&mode=admin&edit=members&rank=$u[id]\"><img src=\"".$dpath."pic/key.gif\" border=\"0\"></a>";
									elseif ($ally_ranks[$CurrentUser['ally_rank_id']-1]['administrieren'] == 1 )
										$u["acciones"] = "<a href=\"game.php?page=alliance&mode=admin&edit=members&kick=$u[id]\" onclick=\"javascript:return confirm('¿Estás seguro que deseas expulsar a $u[username]?');\"><img src=\"".$dpath."pic/abort.gif\" border=\"0\"></a> <a href=\"game.php?page=alliance&mode=admin&edit=members&rank=$u[id]\"><img src=\"".$dpath."pic/key.gif\" border=\"0\"></a>";
									else
										$u["acciones"] = '-';
										
									$u["dpath"] = $dpath;
									$u['ally_register_time'] = date("Y-m-d h:i:s", $u['ally_register_time']);
									if ($rank == $u['id'])
									{
											$r['Rank_for'] = str_replace("%s", $u['username'], $lang['Rank_for']);
											$r['options'] .= "<option onclick=\"document.editar_usu_rango.submit();\" value=\"0\">".$lang['al_new_member_rank_text']."</option>";

											if($ally_ranks != null )
											{
												foreach($ally_ranks as $a => $b)
												{
													$r['options'] 	.= "<option onclick=\"document.editar_usu_rango.submit();\" value=\"" . ($a + 1) . "\"";

												if ($u['ally_rank_id']-1 == $a)
												{
													$r['options'] .= ' selected=selected';
												}

												$r['options'] .= ">".$b['name']."</option>";
											}
										}
										$r['id'] = $u['id'];

										$editar_miembros = parsetemplate(gettemplate('alliance/alliance_admin_members_row_edit'), $r);
									}

									if ($rank != $u['id'])
										$u['ally_range'] = $ally_range;
									else
										$u['ally_range'] = $editar_miembros;

									$page_list .= parsetemplate(gettemplate('alliance/alliance_admin_members_row'), $u);

								}
								if ($sort2 == 1) {$s = 2;}
								elseif ($sort2 == 2) {$s = 1;}
								else {$s = 1;}

								if ($i != $ally['ally_members'])
									$db->query("UPDATE ".ALLIANCE." SET `ally_members`='".$i."' WHERE `id`='".$ally['id']."'", 'alliance');

								$lang['memberslist'] = $page_list;
								$lang['s'] = $s;

								display(parsetemplate(gettemplate('alliance/alliance_admin_members_table'), $lang));
							break;
							case 'requests':
								if ($ally['ally_owner'] != $CurrentUser['id'] && !$user_bewerbungen_bearbeiten)
									header("location:game.". PHP_EXT . "?page=alliance");

								if ($_POST['action'] == $lang['al_acept_request'])
								{
									$_POST['text']  = makebr(request_var('text', ''));

									$db->query("UPDATE ".ALLIANCE." SET `ally_members` = `ally_members` + 1 WHERE id='".$ally['id']."';");

									$db->query("UPDATE ".USERS." SET
									ally_name='".$ally['ally_name']."',
									ally_request_text='',
									ally_request='0',
									ally_id='".$ally['id']."'
									WHERE id='".$db->sql_escape($show)."'", 'users');

									SendSimpleMessage($show,$CurrentUser['id'],'', 2,$ally['ally_tag'],$lang['al_you_was_acceted'] . $ally['ally_name'], $lang['al_hi_the_alliance'] . $ally['ally_name'] . $lang['al_has_accepted'] . $_POST['text']);

									exit(header('Location:game.php?page=alliance&mode=admin&edit=ally'));
								}
								elseif($_POST['action'] == $lang['al_decline_request'] && $_POST['action'] != '')
								{
									$_POST['text']  = makebr(request_var('text', ''));

									$db->query("UPDATE ".USERS." SET ally_request_text='',ally_request='0',ally_id='0' WHERE id='".$db->sql_escape($show)."';");

									SendSimpleMessage($show,$CurrentUser['id'],'', 2,$ally['ally_tag'],$lang['al_you_was_declined'] . $ally['ally_name'], $lang['al_hi_the_alliance'] . $ally['ally_name'] . $lang['al_has_declined'] . $_POST['text']);

									exit(header('Location:game.php?page=alliance&mode=admin&edit=ally'));
								}

								$i = 0;

								$query = $db->query("SELECT id,username,ally_request_text,ally_register_time FROM ".USERS." WHERE ally_request='".$ally['id']."';");

								while ($r = $db->fetch_array($query))
								{
									$s = $lang;
									if (isset($show) && $r['id'] == $show)
									{
										$s['username'] 			= $r['username'];
										$s['ally_request_text'] = makebr($r['ally_request_text']);
										$s['id'] 				= $r['id'];
									}

									$r['time'] 		= date("Y-m-d h:i:s", $r['ally_register_time']);
									$parse['list'] .= parsetemplate(gettemplate('alliance/alliance_admin_request_row'), $r);
									$i++;
								}

								if ($parse['list'] == '')
								{
									$parse['list'] = "<tr><th colspan=2>".$lang['al_no_requests']."</th></tr>";
								}

								if (isset($show) && $show != 0 && $parse['list'] != '')
								{
									$s['Request_from'] 	= str_replace('%s', $s['username'], $lang['al_request_from']);
									$parse['request'] 	= parsetemplate(gettemplate('alliance/alliance_admin_request_form'), $s);
								}
								else
									$parse['request'] = '';

								$parse['ally_tag'] 					= $ally['ally_tag'];
								$parse['There_is_hanging_request'] 	= str_replace('%n', $i, $lang['al_no_request_pending']);

								display(parsetemplate(gettemplate('alliance/alliance_admin_request_table'), $parse));
							break;
							case 'tag':
								if ($ally['ally_owner'] != $CurrentUser['id'] && !$user_admin)
									header("location:game.". PHP_EXT . "?page=alliance");

									$al_tag = request_var($lang['al_tag'], '', UTF8_SUPPORT);
								if ($al_tag != '')
								{
									$db->query("UPDATE ".ALLIANCE." SET `ally_tag` = '". $db->sql_escape($al_tag) ."' WHERE `id` = '". $CurrentUser['ally_id'] ."';");
								}

								$parse["caso"] 			= $lang['al_tag'];
								$parse["caso_titulo"]	= $lang['al_new_tag'];

								display(parsetemplate(gettemplate('alliance/alliance_admin_rename'), $parse));
							break;
							case 'name':
								if ($ally['ally_owner'] != $CurrentUser['id'] && !$user_admin)
									header("location:game.". PHP_EXT . "?page=alliance");
									
								$al_name = request_var($lang['al_name'], '', UTF8_SUPPORT);
								
								if ($al_name != '') {
									$db->multi_query("UPDATE ".ALLIANCE." SET `ally_name` = '". $db->sql_escape($al_name) ."' WHERE `id` = '". $CurrentUser['ally_id'] ."';UPDATE ".USERS." SET `ally_name` = '". $db->sql_escape($al_name) ."' WHERE `ally_id` = '". $ally['id'] ."';");
								}
								$parse["caso"] 		= $lang['al_name'];
								$parse["caso_titulo"]	= $lang['al_new_name'];

								display(parsetemplate(gettemplate('alliance/alliance_admin_rename'), $parse));
							break;
							case 'exit':
								if ($ally['ally_owner'] != $CurrentUser['id'] && !$user_can_exit_alliance)
									header("location:game.". PHP_EXT . "?page=alliance");

								$BorrarAlianza = $db->query("SELECT id FROM ".USERS." WHERE `ally_id`='".$ally['id']."';");

								while ($v = $db->fetch_array($BorrarAlianza))
								{	
									$db->query("UPDATE ".USERS." SET `ally_name` = '', `ally_id`='0' WHERE `id`='".$v['id']."';");
								}

								$db->query("DELETE FROM ".ALLIANCE." WHERE id='".$ally['id']."' LIMIT 1;");

								exit(header("location:game.". PHP_EXT . "?page=alliance"));
							break;
							case 'transfer':
								$postleader = request_var('newleader','');
								if ($postleader != '')
								{
									$db->multi_query("UPDATE ".USERS." SET `ally_rank_id`='0' WHERE `id`='".$CurrentUser['id'].";UPDATE ".ALLIANCE." SET `ally_owner`='" . $db->sql_escape($postleader) . "' WHERE `id`='".$CurrentUser['ally_id'].";UPDATE ".USERS." SET `ally_rank_id`='0' WHERE `id`='" . $db->sql_escape($postleader) . "';");
									exit(header("location:game.". PHP_EXT . "?page=alliance"));
								}
								if ($ally['ally_owner'] != $CurrentUser['id'])
									header("location:game.". PHP_EXT . "?page=alliance");
								else
								{
									$listuser 		= $db->query("SELECT id,ally_rank_id,username FROM ".ALLIANCE." WHERE ally_id = '".$CurrentUser['ally_id']."';");
									$righthand		= $lang;

									while ($u = $db->fetch_array($listuser))
									{
										if ($ally['ally_owner'] != $u['id'])
										{
											if ($u['ally_rank_id'] != 0 )
											{
											if ($ally_ranks[$u['ally_rank_id']-1]['rechtehand'] == 1)
												{
													$righthand['righthand'] .= "\n<option value=\"" . $u['id'] . "\"";
													$righthand['righthand'] .= ">";
													$righthand['righthand'] .= "".$u['username'];
													$righthand['righthand'] .= "&nbsp;[".$ally_ranks[$u['ally_rank_id']-1]['name'];
													$righthand['righthand'] .= "]&nbsp;&nbsp;</option>";
												}
											}
										}
										$righthand["dpath"] = $dpath;
									}

									$page_list 	   .= parsetemplate(gettemplate('alliance/alliance_admin_transfer_row'), $righthand);
									$parse['s'] 	= $s;
									$parse['list'] 	= $page_list;

									display(parsetemplate(gettemplate('alliance/alliance_admin_transfer'), $parse));
								}
							break;
							default:
								if ($_POST)
								{
									if (!get_magic_quotes_gpc())
									{
										$_POST['owner_range'] 	= request_var('owner_range','',true);
										$_POST['web'] 			= request_var('web','');
										$_POST['image'] 		= request_var('image','');
										$_POST['text'] 			= request_var('text','',true);
									}
								}

								if ($_POST['options'])
								{

									$ally['ally_owner_range'] 		= request_var('owner_range','');
									$ally['ally_web'] 				= request_var('web','');
									$ally['ally_image'] 			= request_var('image','');
									$ally['ally_request_notallow'] 	= request_var('request_notallow','');

									if ($ally['ally_request_notallow'] != 0 && $ally['ally_request_notallow'] != 1)
										exit(header("location:game.". PHP_EXT . "?page=alliance?mode=admin&edit=ally",2));

									$db->query("UPDATE ".ALLIANCE." SET
									`ally_owner_range`='".$db->sql_escape($ally['ally_owner_range'])."',
									`ally_image`='".$db->sql_escape($ally['ally_image'])."',
									`ally_web`='".$db->sql_escape($ally['ally_web'])."',
									`ally_request_notallow`='".$db->sql_escape($ally['ally_request_notallow'])."'
									WHERE `id`='".$ally['id']."';");
								}
								elseif(isset($_POST['text']))
								{
									$text = $db->sql_escape($_POST['text']);
									$QryText = "UPDATE ".ALLIANCE." SET ";
									if ($t == 3)
									{
										$QryText .= "`ally_request`='".$text."' ";
									}
									elseif ($t == 2)
									{
										$QryText .= "`ally_text`='".$text. "' ";
									}
									else
									{
										$QryText .= "`ally_description`='".$text."' ";
									}
									$QryText .= "WHERE `id`='".$ally['id']."';";
									$db->query($QryText);
								}

									$lang['dpath'] = $dpath;

								if ($t == 2){
									if(isset($_POST['text'])){
										$lang['text'] = $_POST['text'];
									} else {
										$lang['text'] = $ally['ally_text'];
									}
									$lang['request_type'] = $lang['al_inside_text'];				
								} elseif ($t == 3){
									if(isset($_POST['text'])){
										$lang['text'] = $_POST['text'];
									} else {
										$lang['text'] = $ally['ally_request'];
									}
									$lang['request_type'] = $lang['al_request_text'];				
								} else {
									if(isset($_POST['text'])){
										$lang['text'] = $_POST['text'];
									} else {
										$lang['text'] = $ally['ally_description'];
									}
									$lang['request_type'] = $lang['al_outside_text'];
								}
								$lang['t'] 							= $t;
								$lang['ally_web'] 					= $ally['ally_web'];
								$lang['ally_image'] 				= $ally['ally_image'];
								$lang['ally_request_notallow_0'] 	= (($ally['ally_request_notallow'] == 1) ? ' SELECTED' : '');
								$lang['ally_request_notallow_1'] 	= (($ally['ally_request_notallow'] == 0) ? ' SELECTED' : '');
								$lang['ally_owner_range'] 			= $ally['ally_owner_range'];
								display(parsetemplate(gettemplate('alliance/alliance_admin'), $lang));
							break;
						}
					break;
					default:
						// IMAGEN
						if ($ally['ally_ranks'] != '')
							$ally['ally_ranks'] = "<tr><td colspan=2><img src=\"".$ally['ally_image']."\"></td></tr>";

						//RANGOS
						if ($ally['ally_owner'] == $CurrentUser['id'])
							$range = ($ally['ally_owner_range'] != '') ? $ally['ally_owner_range'] : $lang['al_founder_rank_text'];
						elseif ($CurrentUser['ally_rank_id'] != 0 && isset($ally_ranks[$CurrentUser['ally_rank_id']-1]['name']))
							$range = $ally_ranks[$CurrentUser['ally_rank_id']-1]['name'];
						else
							$range = $lang['al_new_member_rank_text'];

						// LISTA DE MIEMBROS
						if ($ally['ally_owner'] == $CurrentUser['id'] || $ally_ranks[$CurrentUser['ally_rank_id']-1]['memberlist'] != 0)
							$lang['members_list'] = " (<a href=\"game.php?page=alliance&mode=memberslist\">".$lang['al_user_list']."</a>)";
						else
							$lang['members_list'] = '';

						// ADMINISTRAR ALIANZA
						if ($ally['ally_owner'] == $CurrentUser['id'] || $ally_ranks[$CurrentUser['ally_rank_id']-1]['administrieren'] != 0)
							$lang['alliance_admin'] = " (<a href=\"game.php?page=alliance&mode=admin&edit=ally\">".$lang['al_manage_alliance']."</a>)";
						else
							$lang['alliance_admin'] = '';

						// CORREO CIRCULAR
						if ($ally['ally_owner'] == $CurrentUser['id'] || $ally_ranks[$CurrentUser['ally_rank_id']-1]['mails'] != 0)
							$lang['send_circular_mail'] = "<tr><th>".$lang['al_circular_message']."</th><th><a href=\"javascript:f('game.php?page=alliance&mode=circular','');\">".$lang['al_send_circular_message']."</a></th></tr>";
						else
							$lang['send_circular_mail'] = '';

						// SOLICITUDES
						$request_count = $db->num_rows($db->query("SELECT id FROM ".USERS." WHERE ally_request='".$ally['id']."';"));

						if ($request_count != 0)
						{
							if ($ally['ally_owner'] == $CurrentUser['id'] || $ally_ranks[$CurrentUser['ally_rank_id']-1]['bewerbungen'] != 0)
								$lang['requests'] = "<tr><th>".$lang['al_requests']."</th><th><a href=\"game.php?page=alliance&mode=admin&edit=requests\">{$request_count} ".$lang['al_new_requests']."</a></th></tr>";
						}
						// SALIR DE LA ALIANZA
						if ($ally['ally_owner'] != $CurrentUser['id'])
						{
							$lang['ally_owner'] .= "<table width=\"519\">";
							$lang['ally_owner'] .= "<tr><td class=\"c\">".$lang['al_leave_alliance']."</td>";
							$lang['ally_owner'] .= "</tr><tr>";
							$lang['ally_owner'] .= "<th><input type=\"button\" onclick=\"javascript:location.href='game.php?page=alliance&mode=exit';\" value=\"".$lang['al_continue']."\"></th>";
							$lang['ally_owner'] .= "</tr></table>";
						}
						else
							$lang['ally_owner'] .= '';

						// IMAGEN DEL LOGO
						$lang['ally_image'] 		= ($ally['ally_image'] != '')?"<tr><th colspan=2><img src=\"".$ally['ally_image']."\"></td></tr>":'';
						$lang['range'] 				= $range;

						$lang['ally_description'] 	= $this->bbcode($ally['ally_description']);
						$lang['ally_text'] 			= $this->bbcode($ally['ally_text']);

						if($ally['ally_web'] != '')
							$lang['ally_web'] 		= $ally['ally_web'];
						else
							$lang['ally_web']		= "-";

						$lang['ally_tag'] 			= $ally['ally_tag'];
						$lang['ally_members'] 		= $ally['ally_members'];
						$lang['ally_name'] 			= $ally['ally_name'];
						$membercount    = 0;
						$gesamtkaempfe  = 0;
						$gesamtwins        = 0;
						$gesamtdraw        = 0;
						$gesamtloos     = 0;
						$gesamtmetal    = 0;
						$gesamtkbcrystal= 0;
						$gesamtlostunits= 0;
						$gesamtdesunits = 0;
						$allymember = $db->query("SELECT * FROM ".USERS." WHERE ally_id='" . $ally['id'] . "';");
						while($usid = $db->fetch_array($allymember)){
								$gesamtkaempfe      = $gesamtkaempfe + $usid['wons'] + $usid['loos'] +  $usid['draws'];
								$gesamtwins         = $gesamtwins + $usid['wons'];
								$gesamtdraw         = $gesamtdraw + $usid['draws'];
								$gesamtloos         = $gesamtloos + $usid['loos'];
								$gesamtmetal        = $gesamtmetal + $usid['kbmetal'];
								$gesamtkbcrystal    = $gesamtkbcrystal + $usid['kbcrystal'];
								$gesamtlostunits    = $gesamtlostunits + $usid['lostunits'];
								$gesamtdesunits     = $gesamtdesunits + $usid['desunits']; 
								$membercount++;
						}
						if ($gesamtkaempfe  == 0 ) {
							$siegprozent            = 0;
							$loosprozent            = 0;
							$drawsprozent           = 0;
						}
						else {
							$siegprozent            = 100 / $gesamtkaempfe * $gesamtwins;
							$loosprozent            = 100 / $gesamtkaempfe * $gesamtloos;
							$drawsprozent           = 100 / $gesamtkaempfe * $gesamtdraw;
						}                               
						$lang['allystat'] = "<tr><td class=\"c\" colspan=\"2\">".$lang['al_Allyquote']."</th></tr><tr><th>".$lang['pl_totalfight']."</th><th align=\"right\">" . pretty_number( $gesamtkaempfe ) . "</th></tr>
						<tr><th>".$lang['pl_fightwon']."</th><th>" . pretty_number( $gesamtwins ) . " (" . round($siegprozent, 2) . " % )</th></tr>
						<tr><th>".$lang['pl_fightlose']."</th><th>" . pretty_number( $gesamtloos ) . " (" . round($loosprozent, 2) . " % )</th></tr>
						<tr><th>".$lang['pl_fightdraw']."</th><th>" . pretty_number( $gesamtdraw ) . " (" . round($drawsprozent, 2) . " % )</th></tr>
						<tr><th>".$lang['pl_unitsshot']."</th><th>" . pretty_number( $gesamtdesunits     ) . "</th></tr>
						<tr><th>".$lang['pl_unitslose']."</th><th>" . pretty_number( $gesamtlostunits ) . "</th></tr>
						<tr><th>".$lang['pl_dermetal']."</th><th>" . pretty_number( $gesamtmetal ) . "</th></tr>
						<tr><th>".$lang['pl_dercrystal']."</th><th>" . pretty_number( $gesamtkbcrystal ) . "</th></tr>";
						display(parsetemplate(gettemplate('alliance/alliance_frontpage'), $lang));
					break;
				}
			break;
		}
		$this->PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
	}
}
?>