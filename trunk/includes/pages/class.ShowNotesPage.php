<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
# *																			 #
# *																			 #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.									 #
# *																			 #
# *  This program is distributed in the hope that it will be useful,		 #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of			 #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 #
# *  GNU General Public License for more details.							 #
# *																			 #
##############################################################################

if(!defined('INSIDE')){ die(header("location:../../"));}

class ShowNotesPage
{
	private function InsertNotes($CurrentUserID)
	{
		global $db;
		$priority 	= request_var('priority',2);
		$title 		= request_var('title', "Kein Titel", true);
		$text 		= request_var('text', "Kein Text", true);
		$id			= request_var('id', 0);		
		$sql 		= ($id == 0) ? "INSERT INTO ".NOTES." SET owner = '".$CurrentUserID."', time = '".time()."', priority = '".$db->sql_escape($priority)."', title = '".$db->sql_escape($title)."', text = '".$db->sql_escape($text)."';" : "UPDATE ".NOTES." SET time = '".time()."', priority = '".$db->sql_escape($priority)."', title = '".$db->sql_escape($title)."', text = '".$db->sql_escape($text)."' WHERE id = '".$db->sql_escape($id)."';";
		$db->query($sql);
		header("location:game.php?page=notes");
	}
	
	private function DeleteNotes($CurrentUserID)
	{
		global $db;
		$sql = "";
		foreach($_POST as $a => $b)
		{
			if(preg_match("/delmes/i",$a) && $b == "y")
			{
				$id = str_replace("delmes","",$a);
				$sql .= "DELETE FROM ".NOTES." WHERE `id` = '".$id."' AND owner = '".$CurrentUserID."';";
			}
		}
		$db->multi_query($sql);
		header("Location:game.php?page=notes");
	}
	
	private function CreateNotes()
	{
		global $lang;
		$template	= new template();

		$template->page_header();
		$template->page_footer();
		
		$template->assign_vars(array(	
			'nt_create_note'	=> $lang['nt_create_note'],
			'nt_priority'		=> $lang['nt_priority'],
			'nt_important'		=> $lang['nt_important'],
			'nt_normal'			=> $lang['nt_normal'],
			'nt_unimportant'	=> $lang['nt_unimportant'],
			'nt_subject_note'	=> $lang['nt_subject_note'],
			'nt_reset'			=> $lang['nt_reset'],
			'nt_save'			=> $lang['nt_save'],
			'nt_note'			=> $lang['nt_note'],
			'nt_characters'		=> $lang['nt_characters'],
			'nt_back'			=> $lang['nt_back'],
		));
		
		$template->display('notes_send_form.tpl');
	}

	private function ShowNotes($CurrentUserID)
	{
		global $lang, $db;

		$NotesID	= request_var('id', 0);
		$Note 		= $db->fetch_array($db->query("SELECT * FROM ".NOTES." WHERE id = '".$NotesID."' AND owner = '".$CurrentUserID."';"));

		if(!$Note)
			die(header("Location: game.php?page=notes"));
		
		$template	= new template();

		$template->page_header();
		$template->page_footer();

		$template->assign_vars(array(	
			'nt_edit_note'		=> $lang['nt_edit_note'],
			'nt_priority'		=> $lang['nt_priority'],
			'nt_important'		=> $lang['nt_important'],
			'nt_normal'			=> $lang['nt_normal'],
			'nt_unimportant'	=> $lang['nt_unimportant'],
			'nt_subject_note'	=> $lang['nt_subject_note'],
			'nt_reset'			=> $lang['nt_reset'],
			'nt_save'			=> $lang['nt_save'],
			'nt_note'			=> $lang['nt_note'],
			'nt_characters'		=> $lang['nt_characters'],
			'nt_back'			=> $lang['nt_back'],
			'PriorityList'		=> array(2 => $lang['nt_important'], 1 => $lang['nt_normal'], 0 => $lang['nt_unimportant']),
			'priority'			=> $Note['priority'],
			'id'				=> $Note['id'],
			'title'				=> $Note['title'],
			'text'				=> $Note['text'],
		));
		
		$template->display('notes_edit_form.tpl');

	}
	
	private function ShowIndexPage($CurrentUserID)
	{
		global $lang, $db;

		$template	= new template();

		$template->page_header();
		$template->page_footer();
		
		$NotesRAW = $db->query("SELECT * FROM ".NOTES." WHERE owner = ".$CurrentUserID." ORDER BY time DESC;");

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
			'nt_priority'				=> $lang['nt_you_dont_have_notes'],
			'nt_size_note'				=> $lang['nt_size_note'],
			'nt_date_note'				=> $lang['nt_date_note'],
			'nt_notes'					=> $lang['nt_notes'],
			'nt_create_new_note'		=> $lang['nt_create_new_note'],
			'nt_subject_note'			=> $lang['nt_subject_note'],
			'nt_dlte_note'				=> $lang['nt_dlte_note'],
			'nt_you_dont_have_notes'	=> $lang['nt_you_dont_have_notes'],
		));
		
		$template->display('notes_body.tpl');
	}
				
	public function ShowNotesPage($CurrentUser)
	{

		$action	= request_var('action','');

		switch($action)
		{
			case "create":
				$this->CreateNotes();
			break;
			case "send":
				$this->InsertNotes($CurrentUser['id']);
			break;
			case "show":
				$this->ShowNotes($CurrentUser['id']);
			break;
			case "delete":
				$this->DeleteNotes($CurrentUser['id']);
			break;
			default:
				$this->ShowIndexPage($CurrentUser['id']);
			break;
		}
	}

}
?>