<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
# *																			 #
# *																			 #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.									 #
# *																			 #
# *  This program is distributed in the hope that it will be useful,		 #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of			 #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 #
# *  GNU General Public License for more details.							 #
# *																			 #
##############################################################################

if(!defined('INSIDE')){ die(header("location:../../"));}

function ShowBuddyPage($CurrentUser)
{
	global $lang, $db;

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
					header("Location:game.php?page=buddy");
				break;

				case 2:
					$db->query("UPDATE ".BUDDY." SET `active` = '1' WHERE `id` ='".$bid."';");
					header("Location:game.php?page=buddy");
				break;

				case 3:
					$test = $db->fetch_array($db->query("SELECT `id` FROM ".BUDDY." WHERE `sender`='".$CurrentUser['id']."' AND `owner`='".$uid."' OR `owner`='".$CurrentUser['id']."' AND `sender`='".$uid."';"));
					if(!isset($test))
					{
						$text = request_var('text','');
						$db->query("INSERT INTO ".BUDDY." SET `sender` = '".$CurrentUser['id']."', `owner` = '".$uid."', `active` = '0', `text` = '".$db->sql_escape($text)."';");
						exit($lang['bu_request_send']);
					}
					else
					{
						exit($lang['bu_request_exists']);
					}
				break;
			}
		break;

		case 2:
			if($u == $CurrentUser['id'])
			{
				message($lang['bu_cannot_request_yourself'],'game.php?page=buddy',2);
			}
			else
			{
				$template->page_header();
				$template->page_footer();

				$Player = $db->fetch_array($db->query("SELECT `username` FROM ".USERS." WHERE `id`='".$uid."';"));

				$template->assign_vars(array(
					'bu_player'				=> $lang['bu_player'],
					'bu_request_message' 	=> $lang['bu_request_message'],
					'bu_back'				=> $lang['bu_back'],
					'bu_send'				=> $lang['bu_send'],
					'username'				=> $Player['username'],
					'id'					=> $uid,
				));
				
				$template->show("buddy_send_form.tpl");
			}
		break;
		default:

			$PlanetRess = new ResourceUpdate($CurrentUser, $CurrentPlanet);
		
			$template->set_vars($CurrentUser, $CurrentPlanet);
			$template->page_header();
			$template->page_topnav();
			$template->page_leftmenu();
			$template->page_planetmenu();
			$template->page_footer();
			$BuddyListRAW	= $db->query("SELECT a.`active`, a.`sender`, a.`id` as buddyid, a.`text`, b.`id`, b.`username`, b.`onlinetime`, b.`galaxy`, b.`system`, b.`planet`, b.`ally_id`, b.`ally_name` FROM ".BUDDY." as a, ".USERS." as b WHERE (a.`sender` = '".$CurrentUser['id']."' AND b.`id` = a.`owner`) OR (a.`owner` = '".$CurrentUser['id']."' AND b.`id` = a.`sender`);");

						
			while($BuddyList = $db->fetch_array($BuddyListRAW))
			{
				if($BuddyList['active']	== 0)
				{
					if($BuddyList['sender'] == $CurrentUser['id'])
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
						'onlinetime'	=> floor((time() - $BuddyList['onlinetime'] / 60)),
						'galaxy'		=> $BuddyList['galaxy'],
						'system'		=> $BuddyList['system'],
						'planet'		=> $BuddyList['planet'],
						'buddyid'		=> $BuddyList['buddyid'],
					);
				}
			}
		
			$template->assign_vars(array(	
				'MyBuddyList'		=> $MyBuddyList,
				'MyRequestList'		=> $MyRequestList,
				'OutRequestList'	=> $OutRequestList,
				'bu_buddy_list'		=> $lang['bu_buddy_list'],
				'bu_requests'		=> $lang['bu_requests'],
				'bu_player'			=> $lang['bu_player'],
				'bu_alliance'		=> $lang['bu_alliance'],
				'bu_coords'			=> $lang['bu_coords'],
				'bu_text'			=> $lang['bu_text'],
				'bu_action'			=> $lang['bu_action'],
				'bu_my_requests'	=> $lang['bu_my_requests'],
				'bu_partners'		=> $lang['bu_partners'],
				'bu_estate'			=> $lang['bu_estate'],
				'bu_no_request'		=> $lang['bu_no_request'],
				'bu_no_buddys'		=> $lang['bu_no_buddys'],
				'bu_no_buddys'		=> $lang['bu_no_buddys'],
				'bu_minutes'		=> $lang['bu_minutes'],
				'bu_accept'			=> $lang['bu_accept'],
				'bu_decline'		=> $lang['bu_decline'],
				'bu_cancel_request'	=> $lang['bu_cancel_request'],
				'bu_disconnected'	=> $lang['bu_disconnected'],
				'bu_delete'			=> $lang['bu_delete'],
				'bu_online'			=> $lang['bu_online'],
			));
			
			$template->show("buddy_overview.tpl");
			$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
		break;
	}
}
?>