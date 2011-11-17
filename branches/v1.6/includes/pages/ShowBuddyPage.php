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
 * @version 1.6 (2011-11-17)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

function ShowBuddyPage()
{
	global $USER, $PLANET, $LNG, $db, $UNI;

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
					$db->multi_query("DELETE FROM ".BUDDY." WHERE `id`='".$bid."';DELETE FROM ".BUDDY_REQUEST." WHERE `id`='".$bid."';");
					redirectTo("game.php"."?page=buddy");
				break;

				case 2:
					$db->query("DELETE FROM ".BUDDY_REQUEST." WHERE `id`='".$bid."';");
					redirectTo("game.php"."?page=buddy");
				break;

				case 3:
					$test = $db->uniquequery("SELECT `id` FROM ".BUDDY." WHERE (`sender`='".$USER['id']."' AND `owner`='".$uid."') OR (`owner`='".$USER['id']."' AND `sender`='".$uid."');");
					if(!isset($test))
					{
						$text = request_var('text', '', UTF8_SUPPORT);
						$db->query("INSERT INTO ".BUDDY." SET 
						`sender` = '".$USER['id']."', 
						`owner` = '".$uid."', 
						`universe` = ".$UNI.";");
						
						$NewBuddy = $db->GetInsertID();
						$db->query("INSERT INTO ".BUDDY_REQUEST." SET 
						`id` = '".$NewBuddy."', 
						`text` = '".$db->sql_escape($text)."';");
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
			if($uid == $USER['id'])
			{
				$template->message($LNG['bu_cannot_request_yourself'],'game.php?page=buddy', 2, true);
			}
			else
			{
				$template->isPopup(true);

				$Player = $db->countquery("SELECT `username` FROM ".USERS." WHERE `id`='".$uid."';");

				$template->assign_vars(array(
					'username'				=> $Player,
					'id'					=> $uid,
				));
				
				$template->show("buddy_send_form.tpl");
			}
		break;
		default:
			$PlanetRess = new ResourceUpdate();
			$PlanetRess->CalcResource();
			$PlanetRess->SavePlanetToDB();

			$BuddyListRAW	= $db->query("SELECT 
			a.`sender`, a.`id` as buddyid, 
			b.`id`, b.`username`, b.`onlinetime`, b.`galaxy`, b.`system`, b.`planet`, b.`ally_id`,
			c.`ally_name`,
			d.`text`
			FROM (".BUDDY." as a, ".USERS." as b) 
			LEFT JOIN ".ALLIANCE." as c ON c.`id` = b.`ally_id`
			LEFT JOIN ".BUDDY_REQUEST." as d ON a.`id` = d.`id`
			WHERE 
			(a.`sender` = '".$USER['id']."' AND a.`owner` = b.id) OR 
			(a.`owner` = '".$USER['id']."' AND a.`sender` = b.`id`);
			");
			
			$MyRequestList	= array();
			$OutRequestList	= array();
			$MyBuddyList	= array();		
			
			while($BuddyList = $db->fetch_array($BuddyListRAW))
			{
				if(isset($BuddyList['text']))
				{
					if($BuddyList['sender'] == $USER['id'])
						$MyRequestList[]	= $BuddyList;
					else
						$OutRequestList[]	= $BuddyList;
				}
				else
				{
					$BuddyList['onlinetime']	= floor((TIMESTAMP - $BuddyList['onlinetime']) / 60);
					$MyBuddyList[]	= $BuddyList;
				}
			}
			
			$db->free_result($BuddyListRAW);
		
			$template->assign_vars(array(	
				'MyBuddyList'		=> $MyBuddyList,
				'MyRequestList'		=> $MyRequestList,
				'OutRequestList'	=> $OutRequestList,
			));
			
			$template->show("buddy_overview.tpl");
		break;
	}
}
?>