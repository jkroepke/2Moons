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
 * @version 2.0.$Revision$ (2012-11-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) exit;

function ShowNewsPage(){
	global $LNG, $USER;

	if($_GET['action'] == 'send') {
		$edit_id 	= HTTP::_GP('id', 0);
		$title 		= $GLOBALS['DATABASE']->escape(HTTP::_GP('title', '', true));
		$text 		= $GLOBALS['DATABASE']->escape(HTTP::_GP('text', '', true));
		$query		= ($_GET['mode'] == 2) ? "INSERT INTO ".NEWS." (`id` ,`user` ,`date` ,`title` ,`text`) VALUES ( NULL , '".$USER['username']."', '".TIMESTAMP."', '".$title."', '".$text."');" : "UPDATE ".NEWS." SET `title` = '".$title."', `text` = '".$text."', `date` = '".TIMESTAMP."' WHERE `id` = '".$edit_id."' LIMIT 1;";
		
		$GLOBALS['DATABASE']->query($query);
	} elseif($_GET['action'] == 'delete' && isset($_GET['id'])) {
		$GLOBALS['DATABASE']->query("DELETE FROM ".NEWS." WHERE `id` = '".HTTP::_GP('id', 0)."';");
	}

	$query = $GLOBALS['DATABASE']->query("SELECT * FROM ".NEWS." ORDER BY id ASC");

	while ($u = $GLOBALS['DATABASE']->fetchArray($query)) {
		$NewsList[]	= array(
			'id'		=> $u['id'],
			'title'		=> $u['title'],
			'date'		=> DateUtil::formatDate($LNG['php_tdformat'], $u['date'], $USER['timezone']),
			'user'		=> $u['user'],
			'confirm'	=> sprintf($LNG['nws_confirm'], $u['title']),
		);
	}
	
	$template	= new Template();


	if($_GET['action'] == 'edit' && isset($_GET['id'])) {
		$News = $GLOBALS['DATABASE']->getFirstRow("SELECT id, title, text FROM ".NEWS." WHERE id = '".$GLOBALS['DATABASE']->escape($_GET['id'])."';");
		$template->assign(array(	
			'mode'			=> 1,
			'nws_head'		=> sprintf($LNG['nws_head_edit'], $News['title']),
			'news_id'		=> $News['id'],
			'news_title'	=> $News['title'],
			'news_text'		=> $News['text'],
		));
	} elseif($_GET['action'] == 'create') {
		$template->assign(array(	
			'mode'			=> 2,
			'nws_head'		=> $LNG['nws_head_create'],
		));
	}
	
	$template->assign(array(	
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
	
	$template->show('NewsPage.tpl');
}
