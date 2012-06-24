<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan
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
 * @author Jan <info@2moons.cc>
 * @copyright 2006 Perberos <ugamela@perberos.com.ar> (UGamela)
 * @copyright 2008 Chlorel (XNova)
 * @copyright 2009 Lucky (XGProyecto)
 * @copyright 2012 Jan <info@2moons.cc> (2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 2.0.$Revision: 2242 $ (2012-11-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

class ShowMessagePage extends AbstractPage
{
	private $categoryTypes   = array( 0, 1, 2, 3, 4, 5, 15, 50, 99, 100, 999);
	
	function __construct() 
	{
		parent::__construct();
	}
	
	function unlock()
	{
		setConfig(array('lockMessagelist' => 0));
		HTTP::redirectTo("admin.php?page=message");
	}
	
	function show()
	{
		global $gameConfig, $LNG, $ADMINUNI;
		
		if($gameConfig['lockMessagelist'] == 1)
		{
			$this->printMessage($LNG['ml_warn'], NULL, array($LNG['common_continue'] => 'admin.php?page=message&mode=unlock', $LNG['common_leave'] => 'admin.php?page=dashboard'));
		}
				
		$orderBy		= HTTP::_GP('orderBy', 'date');
		$orderDirection	= HTTP::_GP('orderDirection', 'desc');
		$filter			= HTTP::_GP('filter', array());
		$site			= HTTP::_GP('site', 1);
		$count			= HTTP::_GP('count', 10);
		$filterSql		= "";
		$orderBySql		= "";
		
		switch($orderBy)
		{
			case 'date':
				$orderBySql	.= "message_time";
			break;
			case 'subject':
				$orderBySql	.= "message_subject";
			break;
			case 'type':
				$orderBySql	.= "message_type";
			break;	
			case 'id':
				$orderBySql	.= "message_id";
			break;				
		}
		
		switch($orderDirection)
		{
			case 'desc':
				$orderBySql .= " DESC";
			break;
			case 'asc':
				$orderBySql .= " ASC";
			break;			
		}
		
		if(!empty($orderBySql))
		{
			$orderBySql	= "ORDER BY ".$orderBySql;
		}
		
		$messageCount	= $GLOBALS['DATABASE']->countquery("SELECT COUNT(*) FROM ".MESSAGES." WHERE message_universe = ".$ADMINUNI.";");
		
		$maxSite		= min(1, ceil($messageCount / $count));
		
		$messageResult	= $GLOBALS['DATABASE']->query("SELECT 
			message_id,
			IF(message_sender = 0, message_from, CONCAT(su.username, '&nbsp;(#', message_sender, ')')) as sender,
			CONCAT(ou.username, '&nbsp;(#', message_owner, ')') as owner,
			message_time,
			message_subject
			FROM ".MESSAGES." 
			LEFT JOIN ".USERS." su ON message_sender != 0 AND message_sender = su.id
			LEFT JOIN ".USERS." ou ON message_owner = ou.id
			WHERE message_universe = ".$ADMINUNI." ".$orderBySql.";");
			
		$messageList	= array();
		
		while($messageRow = $GLOBALS['DATABASE']->fetchArray($messageResult))
		{
			$messageList[$messageRow['message_id']] = array(
				'sender'	=> $messageRow['sender'],
				'owner'		=> $messageRow['owner'],
				'date'		=> DateUtil::formatDate($LNG['php_tdformat'], $messageRow['message_time']),
				'subject'	=> strlen($messageRow['message_subject']) > 30 ? substr($messageRow['message_subject'], 0, 27).'...' : $messageRow['message_subject'],
			);
		}
		
		$this->assign(array(
			'categoryTypes'	=> $this->categoryTypes,
			'messageList'	=> $messageList,
			'maxSite'		=> $maxSite,
			'site'			=> $site,
		));
		
		$this->render('page.message.default.tpl');
	}
}