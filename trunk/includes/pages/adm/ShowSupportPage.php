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

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) exit;
		
class ShowSupportPage
{
	private $ticketObj;
	
	function __construct() 
	{
		require(ROOT_PATH.'includes/classes/class.SupportTickets.php');
		$this->ticketObj	= new SupportTickets;
		$this->tplObj		= new template();
		// 2Moons 1.7TO1.6 PageClass Wrapper
		$ACTION = HTTP::_GP('mode', 'show');
		if(!is_callable(array($this, $mode))) {
			$this->{$ACTION}();
		} else {
			$this->show();
        }
	}
	
	public function show()
	{
		global $USER, $LNG;
				
		$ticketResult	= $GLOBALS['DATABASE']->query("SELECT t.*, u.username, COUNT(a.ticketID) as answer FROM ".TICKETS." t INNER JOIN ".TICKETS_ANSWER." a USING (ticketID) INNER JOIN ".USERS." u ON u.id = t.ownerID WHERE t.universe = ".$_SESSION['adminuni']." GROUP BY a.ticketID ORDER BY t.ticketID DESC;");
		$ticketList		= array();
		
		while($ticketRow = $GLOBALS['DATABASE']->fetch_array($ticketResult)) {
			$ticketRow['time']	= _date($LNG['php_tdformat'], $ticketRow['time'], $USER['timezone']);

			$ticketList[$ticketRow['ticketID']]	= $ticketRow;
		}
		
		$GLOBALS['DATABASE']->free_result($ticketResult);
		
		$this->tplObj->assign_vars(array(	
			'ticketList'	=> $ticketList
		));
			
		$this->tplObj->show('page.ticket.default.tpl');
	}
	
	function send() 
	{
		global $USER, $UNI, $LNG;
				
		$ticketID	= HTTP::_GP('id', 0);
		$category	= HTTP::_GP('category', 0);
		$message	= HTTP::_GP('message', '', true);
		$change		= HTTP::_GP('change_status', '', true);
		
		$ticketDetail	= $GLOBALS['DATABASE']->uniquequery("SELECT ownerID, subject, status FROM ".TICKETS." WHERE ticketID = ".$ticketID.";");
		$status = ($change ? ($ticketDetail['status'] <= 1 ? 2 : 1) : $ticketDetail['status']);
		if(empty($message)) {
			if ($status == 2 && $change) {
				$message = $LNG['ti_admin_close'];
			} elseif ($status == 1 && $change) {
				$message = $LNG['ti_admin_open'];
			} else {
				HTTP::redirectTo('admin.php?page=support&mode=view&id='.$ticketID);
			}
		}
		$subject		= "RE: ".$ticketDetail['subject'];
		
		$this->ticketObj->createAnswer($ticketID, $USER['id'], $USER['username'], $subject, $message, $status);
		
		SendSimpleMessage($ticketDetail['ownerID'], $USER['id'], TIMESTAMP, 4, $USER['username'], sprintf($LNG['sp_answer_message_title'], $ticketID), sprintf($LNG['sp_answer_message'], $ticketID)); 
		HTTP::redirectTo('admin.php?page=support&mode=view&id='.$ticketID);
	}
	
	function view() 
	{
		global $USER, $LNG;
				
		$ticketID			= HTTP::_GP('id', 0);
		$answerResult		= $GLOBALS['DATABASE']->query("SELECT a.*, t.categoryID, t.status FROM ".TICKETS_ANSWER." a INNER JOIN ".TICKETS." t USING(ticketID) WHERE a.ticketID = ".$ticketID." ORDER BY a.answerID;");
		$answerList			= array();
		
		while($answerRow = $GLOBALS['DATABASE']->fetch_array($answerResult)) {
			if (empty($ticket_status))
				$ticket_status = $answerRow['status'];
			$answerRow['time']	= _date($LNG['php_tdformat'], $answerRow['time'], $USER['timezone']);
			
			$answerList[$answerRow['answerID']]	= $answerRow;
		}
		
		$GLOBALS['DATABASE']->free_result($answerResult);
			
		$categoryList	= $this->ticketObj->getCategoryList();
		
		$this->tplObj->assign_vars(array(
			'ticketID'		=> $ticketID,
			'ticket_status' => $ticket_status,
			'categoryList'	=> $categoryList,
			'answerList'	=> $answerList,
		));
			
		$this->tplObj->show('page.ticket.view.tpl');		
	}
}	
?>