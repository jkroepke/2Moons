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

 
class ShowNotesPage extends AbstractPage
{
	public static $requireModule = MODULE_NOTICE;

	function __construct() 
	{
		parent::__construct();
		$this->setWindow('popup');
		$this->initTemplate();
	}
	
	function show()
	{
		global $LNG, $USER;
		
		$notesResult 	= $GLOBALS['DATABASE']->query("SELECT * FROM ".NOTES." WHERE owner = ".$USER['id']." ORDER BY priority DESC, time DESC;");
		$notesList		= array();
		
		while($notesRow = $GLOBALS['DATABASE']->fetch_array($notesResult))
		{
			$notesList[$notesRow['id']]	= array(
				'time'		=> _date($LNG['php_tdformat'], $notesRow['time'], $USER['timezone']),
				'title'		=> $notesRow['title'],
				'size'		=> strlen($notesRow['text']),
				'priority'	=> $notesRow['priority'],
			);
		}
		
		$GLOBALS['DATABASE']->free_result($notesResult);
		
		$this->tplObj->assign_vars(array(
			'notesList'	=> $notesList,
		));
		
		$this->display('page.notes.default.tpl');
	}
	
	function detail()
	{
		global $LNG, $USER;

		$noteID		= HTTP::_GP('id', 0);
		
		if(!empty($noteID)) {
			$noteDetail	= $GLOBALS['DATABASE']->uniquequery("SELECT * FROM ".NOTES." WHERE id = ".$noteID." AND owner = ".$USER['id'].";");
		} else {
			$noteDetail	= array(
				'id'		=> 0,
				'priority'	=> 1,
				'text'		=> '',
				'title'		=> ''
			);
		}
		
		$this->tplObj->execscript("$('#cntChars').text($('#text').val().length);");
		$this->tplObj->assign_vars(array(
			'PriorityList'	=> array(2 => $LNG['nt_important'], 1 => $LNG['nt_normal'], 0 => $LNG['nt_unimportant']),
			'noteDetail'	=> $noteDetail,
		));
		
		$this->display('page.notes.detail.tpl');
	}
	
	public function insert()
	{
		global $LNG, $USER;
		$priority 	= HTTP::_GP('priority', 1);
		$title 		= HTTP::_GP('title', '', true);
		$text 		= HTTP::_GP('text', '', true);
		$id			= HTTP::_GP('id', 0);	
		$title 		= !empty($title) ? $title : $LNG['nt_no_title'];
		$text 		= !empty($text) ? $text : $LNG['nt_no_text'];
		
		if($id == 0) {
			$SQL	= "INSERT INTO ".NOTES." SET owner = ".$USER['id'].", time = ".TIMESTAMP.", priority = ".$priority.", title = '".$GLOBALS['DATABASE']->sql_escape($title)."', text = '".$GLOBALS['DATABASE']->sql_escape($text)."', universe = ".$UNI.";";		
		} else {
			$SQL	= "UPDATE ".NOTES." SET time = ".TIMESTAMP.", priority = ".$priority.", title = '".$GLOBALS['DATABASE']->sql_escape($title)."', text = '".$GLOBALS['DATABASE']->sql_escape($text)."' WHERE id = ".$id.";";
		}
		
		$GLOBALS['DATABASE']->query($SQL);
		$this->redirectTo('game.php?page=notes');
	}
	
	function delete()
	{
		global $USER;
		if(isset($_POST['delmes']) && is_array($_POST['delmes']))
		{
			$SQLWhere = array();
			foreach($_POST['delmes'] as $id => $b)
			{
				$SQLWhere[] = "id = '".(int) $id."'";
			}
			
			$GLOBALS['DATABASE']->query("DELETE FROM ".NOTES." WHERE (".implode(" OR ",$SQLWhere).") AND owner = '".$USER['id']."';");
		}
		$this->redirectTo('game.php?page=notes');
	}

}
?>