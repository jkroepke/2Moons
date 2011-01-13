<?php

##############################################################################
# *																			 #
# * RN FRAMEWORK															 #
# *  																		 #
# * @copyright Copyright (C) 2009 By ShadoX from xnova-reloaded.de	    	 #
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

if ($USER['rights'][str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__)] != 1) exit;

function ShowNewsPage(){
	global $LNG, $db, $USER;

	if($_GET['action'] == 'send') {
		$edit_id 	= request_var('id', 0);
		$title 		= $db->sql_escape(request_var('title', '', true));
		$text 		= $db->sql_escape(request_var('text', '', true));
		$query		= ($_GET['mode'] == 2) ? "INSERT INTO ".NEWS." (`id` ,`user` ,`date` ,`title` ,`text`) VALUES ( NULL , '".$USER['username']."', '".TIMESTAMP."', '".$title."', '".$text."');" : "UPDATE ".NEWS." SET `title` = '".$title."', `text` = '".$text."', `date` = '".TIMESTAMP."' WHERE `id` = '".$edit_id."' LIMIT 1;";
		
		$db->query($query);
	} elseif($_GET['action'] == 'delete' && isset($_GET['id'])) {
		$db->query("DELETE FROM ".NEWS." WHERE `id` = '".request_var('id', 0)."';");
	}

	$query = $db->query("SELECT * FROM ".NEWS." ORDER BY id ASC");

	while ($u = $db->fetch_array($query)) {
		$NewsList[]	= array(
			'id'		=> $u['id'],
			'title'		=> $u['title'],
			'date'		=> date("d.m.Y H:i:s",$u['date']),
			'user'		=> $u['user'],
			'confirm'	=> sprintf($LNG['nws_confirm'], $u['title']),
		);
	}
	
	$template	= new template();

	if($_GET['action'] == 'edit' && isset($_GET['id'])) {
		$News = $db->uniquequery("SELECT id, title, text FROM ".NEWS." WHERE id = '".$db->sql_escape($_GET['id'])."';");
		$template->assign_vars(array(	
			'mode'			=> 1,
			'nws_head'		=> sprintf($LNG['nws_head_edit'], $News['title']),
			'news_id'		=> $News['id'],
			'news_title'	=> $News['title'],
			'news_text'		=> $News['text'],
		));
	} elseif($_GET['action'] == 'create') {
		$template->assign_vars(array(	
			'mode'			=> 2,
			'nws_head'		=> $LNG['nws_head_create'],
		));
	}
	
	$template->assign_vars(array(	
		'NewsList'		=> $NewsList,
		'button_submit'	=> $LNG['button_submit'],
		'nws_total'		=> sprintf($LNG['nws_total'], count($NewsList)),
		'nws_news'		=> $LNG['nws_news'],
		'nws_id'		=> $LNG['nws_id'],
		'nws_title'		=> $LNG['nws_title'],
		'nws_date'		=> $LNG['nws_date'],
		'nws_from'		=> $LNG['nws_from'],
		'nws_del'		=> $LNG['nws_del'],
		'nws_create'	=> $LNG['nws_create'],
		'nws_content'	=> $LNG['nws_content'],
	));
	
	$template->show('adm/NewsPage.tpl');
}
?>