<?php

##############################################################################
# *                                                                          #
# * 2MOONS                                                                   #
# *                                                                          #
# * @copyright Copyright (C) 2010 By ShadoX from titanspace.de               #
# *                                                                          #
# *	                                                                         #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.                                     #
# *	                                                                         #
# *  This program is distributed in the hope that it will be useful,         #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of          #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           #
# *  GNU General Public License for more details.                            #
# *                                                                          #
##############################################################################



class ShowNotesPage
{
	private function InsertNotes()
	{
		global $db, $LNG, $USER;
		$priority 	= request_var('priority',2);
		$title 		= request_var('title', '', true);
		$text 		= request_var('text', '', true);
		$id			= request_var('id', 0);	
		$title 		= !empty($title) ? $title : $LNG['nt_no_title'];
		$text 		= !empty($text) ? $text : $LNG['nt_no_text'];
		$sql 		= ($id == 0) ? "INSERT INTO ".NOTES." SET owner = '".$USER['id']."', time = '".TIMESTAMP."', priority = '".$db->sql_escape($priority)."', title = '".$db->sql_escape($title)."', text = '".$db->sql_escape($text)."';" : "UPDATE ".NOTES." SET time = '".TIMESTAMP."', priority = '".$db->sql_escape($priority)."', title = '".$db->sql_escape($title)."', text = '".$db->sql_escape($text)."' WHERE id = '".$db->sql_escape($id)."';";
		$db->query($sql);
		$this->ShowIndexPage();
	}
	
	private function DeleteNotes()
	{
		global $db, $USER;
		if(isset($_POST['delmes']) && is_array($_POST['delmes']))
		{
			$SQLWhere = array();
			foreach($_POST['delmes'] as $id => $b)
			{
				$SQLWhere[] = "`id` = '".(int) $id."'";
			}
			
			$db->query("DELETE FROM ".NOTES." WHERE (".implode(" OR ",$SQLWhere).") AND owner = '".$USER['id']."';");
		}
		$this->ShowIndexPage();
	}
	
	private function CreateNotes()
	{
		global $LNG;
		$template	= new template();
		$template->isPopup(true);
		
		$template->assign_vars(array(	
			'nt_create_note'	=> $LNG['nt_create_note'],
			'nt_priority'		=> $LNG['nt_priority'],
			'nt_important'		=> $LNG['nt_important'],
			'nt_normal'			=> $LNG['nt_normal'],
			'nt_unimportant'	=> $LNG['nt_unimportant'],
			'nt_subject_note'	=> $LNG['nt_subject_note'],
			'nt_reset'			=> $LNG['nt_reset'],
			'nt_save'			=> $LNG['nt_save'],
			'nt_note'			=> $LNG['nt_note'],
			'nt_characters'		=> $LNG['nt_characters'],
			'nt_back'			=> $LNG['nt_back'],
		));
		
		$template->show('notes_send_form.tpl');
	}

	private function ShowNotes()
	{
		global $LNG, $db, $USER;

		$NotesID	= request_var('id', 0);
		$Note 		= $db->uniquequery("SELECT * FROM ".NOTES." WHERE id = '".$NotesID."' AND owner = '".$USER['id']."';");

		(!$Note) ? 
			redirectTo("game.php?page=notes") : '';
		
		$template	= new template();
		$template->isPopup(true);
		$template->execscript("$('#cntChars').text($('#text').val().length);");
		$template->assign_vars(array(	
			'nt_edit_note'		=> $LNG['nt_edit_note'],
			'nt_priority'		=> $LNG['nt_priority'],
			'nt_important'		=> $LNG['nt_important'],
			'nt_normal'			=> $LNG['nt_normal'],
			'nt_unimportant'	=> $LNG['nt_unimportant'],
			'nt_subject_note'	=> $LNG['nt_subject_note'],
			'nt_reset'			=> $LNG['nt_reset'],
			'nt_save'			=> $LNG['nt_save'],
			'nt_note'			=> $LNG['nt_note'],
			'nt_characters'		=> $LNG['nt_characters'],
			'nt_back'			=> $LNG['nt_back'],
			'PriorityList'		=> array(2 => $LNG['nt_important'], 1 => $LNG['nt_normal'], 0 => $LNG['nt_unimportant']),
			'priority'			=> $Note['priority'],
			'id'				=> $Note['id'],
			'ntitle'			=> $Note['title'],
			'ntext'				=> $Note['text'],
		));
		
		$template->show('notes_edit_form.tpl');

	}
	
	private function ShowIndexPage()
	{
		global $LNG, $db, $USER;

		$template	= new template();
		$template->isPopup(true);				
		$NotesRAW 	= $db->query("SELECT * FROM ".NOTES." WHERE owner = ".$USER['id']." ORDER BY time DESC;");
		$NoteList	= array();
		while($Note = $db->fetch_array($NotesRAW))
		{
			$NoteList[]	= array(
				'id'		=> $Note['id'],
				'time'		=> date("d. M y H:i:s", $Note['time']),
				'title'		=> $Note['title'],
				'size'		=> strlen($Note['text']),
				'priority'	=> $Note['priority'],
			);
		}
		
		$template->assign_vars(array(	
			'NoteList'					=> $NoteList,
			'nt_priority'				=> $LNG['nt_you_dont_have_notes'],
			'nt_size_note'				=> $LNG['nt_size_note'],
			'nt_date_note'				=> $LNG['nt_date_note'],
			'nt_notes'					=> $LNG['nt_notes'],
			'nt_create_new_note'		=> $LNG['nt_create_new_note'],
			'nt_subject_note'			=> $LNG['nt_subject_note'],
			'nt_dlte_note'				=> $LNG['nt_dlte_note'],
			'nt_you_dont_have_notes'	=> $LNG['nt_you_dont_have_notes'],
		));
		
		$template->show('notes_body.tpl');
	}
				
	public function __construct()
	{

		$action	= request_var('action','');

		switch($action)
		{
			case "create":
				$this->CreateNotes();
			break;
			case "send":
				$this->InsertNotes();
			break;
			case "show":
				$this->ShowNotes();
			break;
			case "delete":
				$this->DeleteNotes();
			break;
			default:
				$this->ShowIndexPage();
			break;
		}
	}

}
?>