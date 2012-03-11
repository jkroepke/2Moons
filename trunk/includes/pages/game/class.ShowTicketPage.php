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
 * @version 1.6.1 (2011-11-19)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

class ShowTicketPage extends AbstractPage 
{
	public static $requireModule = MODULE_SUPPORT;

	private $ticketObj;
	
	function __construct() 
	{
		parent::__construct();
		require(ROOT_PATH.'includes/classes/class.SupportTickets.php');
		$this->ticketObj	= new SupportTickets;
	}
	
	public function show()
	{
		global $USER, $LNG;
				
		$ticketResult	= $GLOBALS['DATABASE']->query("SELECT t.*, COUNT(a.ticketID) as answer FROM ".TICKETS." t INNER JOIN ".TICKETS_ANSWER." a USING (ticketID) WHERE t.ownerID = ".$USER['id']." GROUP BY a.ticketID ORDER BY t.ticketID DESC;");
		$ticketList		= array();
		
		while($ticketRow = $GLOBALS['DATABASE']->fetch_array($ticketResult)) {
			$ticketRow['time']	= _date($LNG['php_tdformat'], $ticketRow['time'], $USER['timezone']);

			$ticketList[$ticketRow['ticketID']]	= $ticketRow;
		}
		
		$GLOBALS['DATABASE']->free_result($ticketResult);
		
		$this->tplObj->assign_vars(array(	
			'ticketList'	=> $ticketList
		));
			
		$this->display('page.ticket.default.tpl');
	}
	
	function create() 
	{
		global $USER, $LNG;
		
		$categoryList	= $this->ticketObj->getCategoryList();
		
		$this->tplObj->assign_vars(array(	
			'categoryList'	=> $categoryList,
		));
			
		$this->display('page.ticket.create.tpl');		
	}
	
	function send() 
	{
		global $USER, $UNI, $LNG;
				
		$ticketID	= HTTP::_GP('id', 0);
		$categoryID	= HTTP::_GP('category', 0);
		$message	= HTTP::_GP('message', '', true);
		$subject	= HTTP::_GP('subject', '', true);
		
		if(empty($message)) {
			if(empty($ticketID)) {
				$this->redirectTo('game.php?page=ticket&mode=create');
			} else {
				$this->redirectTo('game.php?page=ticket&mode=view&id='.$ticketID);
			}
		}
		
		if(empty($ticketID)) {
			$ticketID	= $this->ticketObj->createTicket($USER['id'], $categoryID, $subject);
		}
		
		$ticketDetail	= $GLOBALS['DATABASE']->countquery("SELECT subject, ownerID FROM ".TICKETS." WHERE ticketID = ".$ticketID.";");
		$subject		= "RE: ".$subject;
		
		$this->ticketObj->createAnswer($ticketID, $USER['id'], $USER['username'], $subject, $message, 0);
		$this->redirectTo('game.php?page=ticket&mode=view&id='.$ticketID);
	}
	
	function view() 
	{
		global $USER, $LNG;
				
		$ticketID			= HTTP::_GP('id', 0);
		$answerResult		= $GLOBALS['DATABASE']->query("SELECT a.*, t.categoryID, t.status FROM ".TICKETS_ANSWER." a INNER JOIN ".TICKETS." t USING(ticketID) WHERE a.ticketID = ".$ticketID." ORDER BY a.answerID;");
		$answerList			= array();

		if($GLOBALS['DATABASE']->numRows($answerResult) == 0) {
			$this->printMessage(sprintf($LNG['ti_not_exist'], $ticketID));
		}
		
		while($answerRow = $GLOBALS['DATABASE']->fetch_array($answerResult)) {
			$answerRow['time']	= _date($LNG['php_tdformat'], $answerRow['time'], $USER['timezone']);
			$answerList[$answerRow['answerID']]	= $answerRow;
			if (empty($ticket_status))
				$ticket_status = $answerRow['status'];
		}
		$GLOBALS['DATABASE']->free_result($answerResult);
			
		$categoryList	= $this->ticketObj->getCategoryList();
		
		$this->tplObj->assign_vars(array(
			'ticketID'		=> $ticketID,
			'categoryList'	=> $categoryList,
			'answerList'	=> $answerList,
			'status'		=> $ticket_status,
		));
			
		$this->display('page.ticket.view.tpl');		
	}
}
?>