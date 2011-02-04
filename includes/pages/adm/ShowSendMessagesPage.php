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
 * @copyright 2009 Lucky <douglas@crockford.com> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.3 (2011-01-21)
 * @link http://code.google.com/p/2moons/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) exit;

function ShowSendMessagesPage() {
	global $USER, $LNG, $db;

	if ($_GET['mode'] == 'send')
	{
		switch($USER['authlevel'])
		{
			case AUTH_MOD:
				$color = 'yellow';
			break;
			case AUTH_OPS:
				$color = 'skyblue';
			break;
			case AUTH_ADM:
				$color = 'red';
			break;
		}
		
		$Subject	= makebr(request_var('subject', '', true));
		$Message 	= makebr(request_var('text', '', true));

		if (!empty($Message) && !empty($Subject))
		{
			require_once(ROOT_PATH.'includes/functions/BBCode.php');
			$Time    	= TIMESTAMP;
			$From    	= '<span style="color:'.$color.';">'.$LNG['user_level'][$USER['authlevel']].' '.$USER['username'].'</span>';
			$Subject 	= '<span style="color:'.$color.';">'.$Subject.'</span>';
			$Message 	= '<span style="color:'.$color.';font-weight:bold;">'.bbcode($Message).'</span>';

			SendSimpleMessage(0, $USER['id'], TIMESTAMP, 50, $From, $Subject, $Message, 0, $_SESSION['adminuni']);
			$db->query("UPDATE ".USERS." SET `new_gmessage` = `new_gmessage` + '1', `new_message` = `new_message` + '1' WHERE `universe` = '".$_SESSION['adminuni']."';");
			exit($LNG['ma_message_sended']);
		} else {
			exit($LNG['ma_subject_needed']);
		}
	}
	
	$template	= new template();

	$template->assign_vars(array(
		'mg_empty_text' 			=> $LNG['mg_empty_text'],
		'ma_subject' 				=> $LNG['ma_subject'],
		'ma_none' 					=> $LNG['ma_none'],
		'ma_message' 				=> $LNG['ma_message'],
		'ma_send_global_message' 	=> $LNG['ma_send_global_message'],
		'ma_characters' 			=> $LNG['ma_characters'],
		'button_submit' 			=> $LNG['button_submit'],
	));
	
	$template->show('adm/SendMessagesPage.tpl');
}
?>