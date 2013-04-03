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

class ShowBuddyListPage extends AbstractPage
{
	public static $requireModule = MODULE_BUDDYLIST;

	function __construct() 
	{
		parent::__construct();
	}
	
	function request()
	{
		global $USER, $LNG;
		
		$this->initTemplate();
		$this->setWindow('popup');
		
		$id	= HTTP::_GP('id', 0);
		
		if($id == $USER['id'])
		{
			$this->printMessage($LNG['bu_cannot_request_yourself']);
		}
		
		$db = Database::get();

        $sql = "SELECT COUNT(*) as count FROM %%BUDDY%% WHERE (sender = :userID AND owner = :friendID) OR (owner = :userID AND sender = :friendID);";
        $exists = $db->selectSingle($sql, array(
            ':userID'	=> $USER['id'],
            ':friendID'  => $id
        ), 'count');

		if($exists != 0)
		{
			$this->printMessage($LNG['bu_request_exists']);
		}
		
		$sql = "SELECT username, galaxy, system, planet FROM %%USERS%% WHERE id = :friendID;";
        $userData = $db->selectSingle($sql, array(
            ':friendID'  => $id
        ));

		$this->tplObj->assign_vars(array(
			'username'	=> $userData['username'],
			'galaxy'	=> $userData['galaxy'],
			'system'	=> $userData['system'],
			'planet'	=> $userData['planet'],
			'id'		=> $id,
		));
		
		$this->display('page.buddyList.request.tpl');
	}
	
	function send()
	{
		global $USER, $LNG;
		
		$this->initTemplate();
		$this->setWindow('popup');
		$this->tplObj->execscript('window.setTimeout(parent.$.fancybox.close, 2000);');
		
		$id		= HTTP::_GP('id', 0);
		$text	= HTTP::_GP('text', '', UTF8_SUPPORT);

		if($id == $USER['id'])
		{
			$this->printMessage($LNG['bu_cannot_request_yourself']);
		}

        $db = Database::get();

        $sql = "SELECT COUNT(*) as count FROM %%BUDDY%% WHERE (sender = :userID AND owner = :friendID) OR (owner = :userID AND sender = :friendID);";
        $exists = $db->selectSingle($sql, array(
            ':userID'	=> $USER['id'],
            ':friendID'  => $id
        ), 'count');

        if($exists != 0)
		{
			$this->printMessage($LNG['bu_request_exists']);
		}

        $sql = "INSERT INTO %%BUDDY%% SET sender = :userID,	owner = :friendID, universe = :universe;";
        $db->insert($sql, array(
            ':userID'	=> $USER['id'],
            ':friendID'  => $id,
            ':universe' => Universe::current()
        ));

        $buddyID	= $db->lastInsertId();

        $GLOBALS['DATABASE']->multi_query("INSERT INTO %%BUDDY_REQUEST%% SET id = :buddyID, text = :text;");
        $db->insert($sql, array(
            ':buddyID'  => $buddyID,
            ':text' => $text
        ));

        $sql = "SELECT username FROM %%USERS%% WHERE id = :friendID;";
        $username = $db->selectSingle($sql, array(
            ':friendID'  => $id,
        ), 'username');

        PlayerUtil::sendMessage($id, $USER['id'], TIMESTAMP, 4, $USER['username'], $LNG['bu_new_request_title'], sprintf($LNG['bu_new_request_body'], $username, $USER['username']));

		$this->printMessage($LNG['bu_request_send']);
	}
	
	function delete()
	{
		global $USER, $LNG;
		
		$id	= HTTP::_GP('id', 0);
		$db = Database::get();

        $sql = "SELECT COUNT(*) as count FROM %%BUDDY%% WHERE id = :id AND (sender = :userID OR owner = :userID);";
        $isAllowed = $db->selectSingle($sql, array(
            ':id'  => $id,
            ':userID' => $USER['id']
        ), 'count');

		if($isAllowed)
		{
			$sql = "SELECT COUNT(*) as count FROM %%BUDDY_REQUEST%% WHERE :id;";
            $isRequest = $db->selectSingle($sql, array(
                ':id'  => $id
            ), 'count');
			
			if($isRequest)
			{
                $sql = "SELECT u.username, u.id FROM %%BUDDY%% b INNER JOIN %%USERS%% u ON u.id = IF(b.sender = :userID,b.owner,b.sender) WHERE b.id = :id;";
                $requestData = $db->selectSingle($sql, array(
                    ':id'       => $id,
                    'userID'    => $USER['id']
                ));

                PlayerUtil::sendMessage($requestData['id'], $USER['id'], TIMESTAMP, 4, $USER['username'], $LNG['bu_rejected_request_title'], sprintf($LNG['bu_rejected_request_body'], $requestData['username'], $USER['username']));
			}

            $sql = "DELETE b.*, r.* FROM %%BUDDY%% b LEFT JOIN %%BUDDY_REQUEST%% r USING (id) WHERE b.id = :id;";
            $db->delete($sql, array(
                ':id'       => $id,
            ));
        }
		$this->redirectTo("game.php?page=buddyList");
	}
	
	function accept()
	{
		global $USER, $LNG;
		
		$id	= HTTP::_GP('id', 0);
		$db = Database::get();

        $sql = "DELETE FROM %%BUDDY_REQUEST%% WHERE id = :id;";
        $db->delete($sql, array(
            ':id'       => $id
        ));

        $sql = "SELECT sender, u.username FROM %%BUDDY%% b INNER JOIN %%USERS%% u ON sender = u.id WHERE b.id = :id;";
        $sender = $db->selectSingle($sql, array(
            ':id'       => $id
        ));

		PlayerUtil::sendMessage($sender['sender'], $USER['id'], TIMESTAMP, 4, $USER['username'], $LNG['bu_accepted_request_title'], sprintf($LNG['bu_accepted_request_body'], $sender['username'], $USER['username']));
		
		$this->redirectTo("game.php?page=buddyList");
	}
	
	function show()
	{
		global $USER;
		
		$db = Database::get();
        $sql = "SELECT a.sender, a.id as buddyid, b.id, b.username, b.onlinetime, b.galaxy, b.system, b.planet, b.ally_id, c.ally_name, d.text
		FROM (%%BUDDY%% as a, %%USERS%% as b) LEFT JOIN %%ALLIANCE%% as c ON c.id = b.ally_id LEFT JOIN %%BUDDY_REQUEST%% as d ON a.id = d.id
		WHERE (a.sender = ".$USER['id']." AND a.owner = b.id) OR (a.owner = :userID AND a.sender = b.id);";
        $BuddyListResult = $db->select($sql, array(
            'userID'    => $USER['id']
        ));

        $myRequestList		= array();
		$otherRequestList	= array();
		$myBuddyList		= array();		
				
		foreach($BuddyListResult as $BuddyList)
		{
			if(isset($BuddyList['text']))
			{
				if($BuddyList['sender'] == $USER['id'])
					$myRequestList[$BuddyList['buddyid']]		= $BuddyList;
				else
					$otherRequestList[$BuddyList['buddyid']]	= $BuddyList;
			}
			else
			{
				$BuddyList['onlinetime']			= floor((TIMESTAMP - $BuddyList['onlinetime']) / 60);
				$myBuddyList[$BuddyList['buddyid']]	= $BuddyList;
			}
		}
		
		$this->tplObj->assign_vars(array(
			'myBuddyList'		=> $myBuddyList,
			'myRequestList'			=> $myRequestList,
			'otherRequestList'	=> $otherRequestList,
		));
		
		$this->display('page.buddyList.default.tpl');
	}
}