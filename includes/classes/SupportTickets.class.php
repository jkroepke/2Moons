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
 * @version 1.7.0 (2012-05-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */
 
class SupportTickets
{	
	function __construct()
	{	
		
	}
	
	function createTicket($ownerID, $categoryID, $subject) {
		global $UNI;
		
		$GLOBALS['DATABASE']->query("INSERT INTO ".TICKETS." SET ownerID = ".$ownerID.", universe = ".$UNI.", categoryID = ".$categoryID.", subject = '".$GLOBALS['DATABASE']->escape($subject)."', time = ".TIMESTAMP.";");
		
		return $GLOBALS['DATABASE']->GetInsertID();
	}
	
	function createAnswer($ticketID, $ownerID, $ownerName, $subject, $message, $status) {
				
		$GLOBALS['DATABASE']->query("INSERT INTO ".TICKETS_ANSWER." SET ticketID = ".$ticketID.",
		ownerID = ".$ownerID.", 
		ownerName = '".$GLOBALS['DATABASE']->escape($ownerName)."', 
		subject = '".$GLOBALS['DATABASE']->escape($subject)."', 
		message = '".$GLOBALS['DATABASE']->escape($message)."', 
		time = ".TIMESTAMP.";");
		$GLOBALS['DATABASE']->query("UPDATE ".TICKETS." SET status = ".$status." WHERE ticketID = ".$ticketID.";");
		
		return $GLOBALS['DATABASE']->GetInsertID();
	}
	
	function getCategoryList() {
				
		$categoryResult		= $GLOBALS['DATABASE']->query("SELECT * FROM ".TICKETS_CATEGORY.";");
		$categoryList		= array();
		
		while($categoryRow = $GLOBALS['DATABASE']->fetchArray($categoryResult)) {
			$categoryList[$categoryRow['categoryID']]	= $categoryRow['name'];
		}
		
		$GLOBALS['DATABASE']->free_result($categoryResult);
		
		return $categoryList;
	}
}
