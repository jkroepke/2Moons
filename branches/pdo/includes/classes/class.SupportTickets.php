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
 
class SupportTickets
{
	public function createTicket($ownerID, $categoryID, $subject)
	{
		$sql 	= 'INSERT INTO %%TICKETS%% SET
		ownerID		= :ownerId"
		universe	= :universe,
		categoryID	= :categoryId,
		subject		= :subject
		time = ".TIMESTAMP.";';

		Database::get()->insert($sql, array(
			':ownerId'		=> $ownerID,
			':universe'		=> Universe::current(),
			':categoryId'	=> $categoryID,
			':subject'		=> $subject,
		));
		
		return Database::get()->lastInsertId();
	}

	public function createAnswer($ticketID, $ownerID, $ownerName, $subject, $message, $status)
	{
		$sql = 'INSERT INTO %%TICKETS_ANSWER%% SET
		ticketID	= :ticketId,
		ownerID		= :ownerId,
		ownerName	= :ownerName,
		subject		= :aubjwct,
		message		= :message,
		time		= :time;';

		Database::get()->insert($sql, array(
			':ticketId'		=> $ticketID,
			':ownerId'		=> $ownerID,
			':ownerName'	=> $ownerName,
			':subject'		=> $subject,
			':message'		=> $message,
			':time'			=> TIMESTAMP
		));

		$answerId = Database::get()->lastInsertId();

		$sql	= 'UPDATE %%TICKETS%% SET status = :status WHERE ticketID = :ticketId;';

		Database::get()->update($sql, array(
			':status'	=> $status,
			':ticketId'	=> $ticketID
		));
		
		return $answerId;
	}

	public function getCategoryList()
	{
		$sql	= 'SELECT * FROM %%TICKETS_CATEGORY%%;';

		$categoryResult		= Database::get()->select($sql);
		$categoryList		= array();

		foreach($categoryResult as $categoryRow)
		{
			$categoryList[$categoryRow['categoryID']]	= $categoryRow['name'];
		}
		
		return $categoryList;
	}
}
