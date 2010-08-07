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

function ShowBuddyPage()
{
	global $USER, $PLANET, $LNG, $db;

	$template	= new template();
	$bid		= request_var('bid', 0);
	$uid		= request_var('u',0);
	$mode		= request_var('mode', 0);
	$sm			= request_var('sm', 0);
	
	
	switch($mode)
	{
		case 1:
			switch($sm)
			{
				case 1:
					$db->query("DELETE FROM ".BUDDY." WHERE `id`='".$bid."';");
					header("Location: ?page=buddy");
				break;

				case 2:
					$db->query("UPDATE ".BUDDY." SET `active` = '1' WHERE `id` ='".$bid."';");
					header("Location: ?page=buddy");
				break;

				case 3:
					$test = $db->fetch_array($db->query("SELECT `id` FROM ".BUDDY." WHERE (`sender`='".$USER['id']."' AND `owner`='".$uid."') OR (`owner`='".$USER['id']."' AND `sender`='".$uid."');"));
					if(!isset($test))
					{
						$text = request_var('text', '', UTF8_SUPPORT);
						$db->query("INSERT INTO ".BUDDY." SET `sender` = '".$USER['id']."', `owner` = '".$uid."', `active` = '0', `text` = '".$db->sql_escape($text)."';");
						exit($LNG['bu_request_send']);
					}
					else
					{
						exit($LNG['bu_request_exists']);
					}
				break;
			}
		break;

		case 2:
			if($u == $USER['id'])
			{
				$template->message($LNG['bu_cannot_request_yourself'],'game.php?page=buddy', 2, true);
			}
			else
			{
				$template->page_header();
				$template->page_footer();

				$Player = $db->uniquequery("SELECT `username` FROM ".USERS." WHERE `id`='".$uid."';");

				$template->assign_vars(array(
					'bu_player'				=> $LNG['bu_player'],
					'bu_request_message' 	=> $LNG['bu_request_message'],
					'bu_back'				=> $LNG['bu_back'],
					'bu_send'				=> $LNG['bu_send'],
					'username'				=> $Player['username'],
					'id'					=> $uid,
				));
				
				$template->show("buddy_send_form.tpl");
			}
		break;
		default:
			$PlanetRess = new ResourceUpdate();
			$PlanetRess->CalcResource();
			$PlanetRess->SavePlanetToDB();

			$template->page_header();
			$template->page_topnav();
			$template->page_leftmenu();
			$template->page_planetmenu();
			$template->page_footer();
			$BuddyListRAW	= $db->query("SELECT a.`active`, a.`sender`, a.`id` as buddyid, a.`text`, b.`id`, b.`username`, b.`onlinetime`, b.`galaxy`, b.`system`, b.`planet`, b.`ally_id`, b.`ally_name` FROM ".BUDDY." as a, ".USERS." as b WHERE (a.`sender` = '".$USER['id']."' AND b.`id` = a.`owner`) OR (a.`owner` = '".$USER['id']."' AND b.`id` = a.`sender`);");

						
			while($BuddyList = $db->fetch_array($BuddyListRAW))
			{
				if($BuddyList['active']	== 0)
				{
					if($BuddyList['sender'] == $USER['id'])
					{
						$MyRequestList[]	= array(
							'playerid'		=> $BuddyList['id'],
							'name'			=> $BuddyList['username'],
							'allyid'		=> $BuddyList['ally_id'],
							'allyname'		=> $BuddyList['ally_name'],
							'text'			=> $BuddyList['text'],
							'galaxy'		=> $BuddyList['galaxy'],
							'system'		=> $BuddyList['system'],
							'planet'		=> $BuddyList['planet'],
							'buddyid'		=> $BuddyList['buddyid'],
						);
					}
					else
					{
						$OutRequestList[]	= array(
							'playerid'		=> $BuddyList['id'],
							'name'			=> $BuddyList['username'],
							'allyid'		=> $BuddyList['ally_id'],
							'allyname'		=> $BuddyList['ally_name'],
							'text'			=> $BuddyList['text'],
							'galaxy'		=> $BuddyList['galaxy'],
							'system'		=> $BuddyList['system'],
							'planet'		=> $BuddyList['planet'],
							'buddyid'		=> $BuddyList['buddyid'],
						);
					}
				}
				else
				{
					$MyBuddyList[]	= array(
						'playerid'		=> $BuddyList['id'],
						'name'			=> $BuddyList['username'],
						'allyid'		=> $BuddyList['ally_id'],
						'allyname'		=> $BuddyList['ally_name'],
						'onlinetime'	=> floor((TIMESTAMP - $BuddyList['onlinetime']) / 60),
						'galaxy'		=> $BuddyList['galaxy'],
						'system'		=> $BuddyList['system'],
						'planet'		=> $BuddyList['planet'],
						'buddyid'		=> $BuddyList['buddyid'],
					);
				}
			}
			
			$db->free_result($BuddyListRAW);
		
			$template->assign_vars(array(	
				'MyBuddyList'		=> $MyBuddyList,
				'MyRequestList'		=> $MyRequestList,
				'OutRequestList'	=> $OutRequestList,
				'bu_buddy_list'		=> $LNG['bu_buddy_list'],
				'bu_requests'		=> $LNG['bu_requests'],
				'bu_player'			=> $LNG['bu_player'],
				'bu_alliance'		=> $LNG['bu_alliance'],
				'bu_coords'			=> $LNG['bu_coords'],
				'bu_text'			=> $LNG['bu_text'],
				'bu_action'			=> $LNG['bu_action'],
				'bu_my_requests'	=> $LNG['bu_my_requests'],
				'bu_partners'		=> $LNG['bu_partners'],
				'bu_estate'			=> $LNG['bu_estate'],
				'bu_no_request'		=> $LNG['bu_no_request'],
				'bu_no_buddys'		=> $LNG['bu_no_buddys'],
				'bu_no_buddys'		=> $LNG['bu_no_buddys'],
				'bu_minutes'		=> $LNG['bu_minutes'],
				'bu_accept'			=> $LNG['bu_accept'],
				'bu_decline'		=> $LNG['bu_decline'],
				'bu_cancel_request'	=> $LNG['bu_cancel_request'],
				'bu_disconnected'	=> $LNG['bu_disconnected'],
				'bu_delete'			=> $LNG['bu_delete'],
				'bu_online'			=> $LNG['bu_online'],
				'bu_connected'		=> $LNG['bu_connected'],
			));
			
			$template->show("buddy_overview.tpl");
		break;
	}
}
?>