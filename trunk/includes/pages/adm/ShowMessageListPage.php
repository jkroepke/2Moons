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
 * @version 1.7.0 (2012-12-31)
 * @info $Id$
 * @link http://2moons.cc/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) throw new Exception("Permission error!");

function ShowMessageListPage()
{
	global $LNG;
	$page		= HTTP::_GP('side', 1);
	$type		= HTTP::_GP('type', 100);
	$sender		= HTTP::_GP('sender', '', UTF8_SUPPORT);
	$receiver	= HTTP::_GP('receiver', '', UTF8_SUPPORT);
	$dateStart	= HTTP::_GP('dateStart', array());
	$dateEnd	= HTTP::_GP('dateEnd', array());
	
	$perSide	= 50;

	$messageList	= array();
	$userWhereSQL	= '';
	$dateWhereSQL	= '';
	$countJoinSQL	= '';
	
	$categories	= $LNG['mg_type'];
	unset($categories[999]);
	
	$dateStart	= array_filter($dateStart, 'is_numeric');
	$dateEnd	= array_filter($dateEnd, 'is_numeric');
	
	$useDateStart	= count($dateStart) == 3;
	$useDateEnd		= count($dateEnd) == 3;
	
	if($useDateStart && $useDateEnd)
	{
		$dateWhereSQL	= ' AND message_time BETWEEN '.mktime(0, 0, 0, (int) $dateStart['month'], (int) $dateStart['day'], (int) $dateStart['year']).' AND '.mktime(23, 59, 59, (int) $dateEnd['month'], (int) $dateEnd['day'], (int) $dateEnd['year']);
	}
	elseif($useDateStart)
	{
		$dateWhereSQL	= ' AND message_time > '.mktime(0, 0, 0, (int) $dateStart['month'], (int) $dateStart['day'], (int) $dateStart['year']);
	}
	elseif($useDateStart)
	{
		$dateWhereSQL	= ' AND message_time < '.mktime(23, 59, 59, (int) $dateEnd['month'], (int) $dateEnd['day'], (int) $dateEnd['year']);
	}
	
	if(!empty($sender))
	{
		$countJoinSQL	.= ' LEFT JOIN '.USERS.' as us ON message_sender = us.id';
		$userWhereSQL	.= ' AND us.username = "'.$GLOBALS['DATABASE']->escape($sender).'"';
	}
	
	if(!empty($receiver))
	{
		$countJoinSQL	.= ' LEFT JOIN '.USERS.' as u ON message_owner = u.id';
		$userWhereSQL	.= ' AND u.username = "'.$GLOBALS['DATABASE']->escape($receiver).'"';
	}
	
	if ($type != 100)
	{
		$MessageCount	= $GLOBALS['DATABASE']->getFirstCell("SELECT COUNT(*) FROM ".MESSAGES.$countJoinSQL." WHERE message_type = ".$type." AND message_universe = ".$_SESSION['adminuni'].$dateWhereSQL.$userWhereSQL.";");
	}
	else
	{
		$MessageCount	= $GLOBALS['DATABASE']->getFirstCell("SELECT COUNT(*) FROM ".MESSAGES.$countJoinSQL." WHERE message_universe = ".$_SESSION['adminuni'].$dateWhereSQL.$userWhereSQL.";");
	}
	
	$maxPage	= max(1, ceil($MessageCount / $perSide));
	$page		= max(1, min($page, $maxPage));
	
	$sqlLimit	= (($page - 1) * $perSide).", ".($perSide - 1);
	
	if ($type == 100)
	{
		$messageRaw	= $GLOBALS['DATABASE']->query("SELECT u.username, us.username as senderName, m.* 
		FROM ".MESSAGES." as m 
		LEFT JOIN ".USERS." as u ON m.message_owner = u.id 
		LEFT JOIN ".USERS." as us ON m.message_sender = us.id
		WHERE m.message_universe = ".$_SESSION['adminuni']." 
		".$dateWhereSQL."
		".$userWhereSQL."
		ORDER BY message_time DESC, message_id DESC
		LIMIT ".$sqlLimit.";");
	} else {
		$messageRaw	= $GLOBALS['DATABASE']->query("SELECT u.username, us.username as senderName, m.* 
		FROM ".MESSAGES." as m
		LEFT JOIN ".USERS." as u ON m.message_owner = u.id
		LEFT JOIN ".USERS." as us ON m.message_sender = us.id
		WHERE m.message_type = ".$type." AND message_universe = ".$_SESSION['adminuni']."
		".$dateWhereSQL."
		".$userWhereSQL."
		ORDER BY message_time DESC, message_id DESC
		LIMIT ".$sqlLimit.";");
	}
	
	while($messageRow = $GLOBALS['DATABASE']->fetch_array($messageRaw))
	{
		$messageList[$messageRow['message_id']]	= array(
			'sender'	=> empty($messageRow['senderName']) ? $messageRow['message_from'] : $messageRow['senderName'].' (ID:&nbsp;'.$messageRow['message_sender'].')',
			'receiver'	=> $messageRow['username'].' (ID:&nbsp;'.$messageRow['message_owner'].')',
			'subject'	=> $messageRow['message_subject'],
			'text'		=> $messageRow['message_text'],
			'type'		=> $messageRow['message_type'],
			'time'		=> str_replace(' ', '&nbsp;', _date($LNG['php_tdformat'], $messageRow['message_time']), $USER['timezone']),
		);
	}	
	
	$template 	= new template();

	$template->assign_vars(array(
		'categories'	=> $categories,
		'maxPage'		=> $maxPage,
		'page'			=> $page,
		'messageList'	=> $messageList,
		'type'			=> $type,
		'dateStart'		=> $dateStart,
		'dateEnd'		=> $dateEnd,
		'sender'		=> $sender,
		'receiver'		=> $receiver,
	));
				
	$template->show('MessageList.tpl');
}
?>