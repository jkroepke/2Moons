
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
 * @version 1.7.0 (2012-12-31)
 * @info $Id$
 * @link http://2moons.cc/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) throw new Exception("Permission error!");


function ShowSendMessagesPage() {
	global $USER, $LNG, $CONF, $LANG;
	
	$ACTION	= HTTP::_GP('action', '');
	if ($ACTION == 'send')
	{
		switch($USER['authlevel'])
		{
			case AUTH_MOD:
				$class = 'mod';
			break;
			case AUTH_OPS:
				$class = 'ops';
			break;
			case AUTH_ADM:
				$class = 'admin';
			break;
		}

		$Subject	= HTTP::_GP('subject', '', true);
		$Message 	= HTTP::_GP('text', '', true);
		$Mode	 	= HTTP::_GP('mode', 0);
		$Lang	 	= HTTP::_GP('lang', '');

		if (!empty($Message) && !empty($Subject))
		{
			require_once(ROOT_PATH.'includes/functions/BBCode.php');
			if($Mode == 0 || $Mode == 2) {
				$Time    	= TIMESTAMP;
				$From    	= '<span class="'.$class.'">'.$LNG['user_level'][$USER['authlevel']].' '.$USER['username'].'</span>';
				$pmSubject 	= '<span class="'.$class.'">'.$Subject.'</span>';
				$pmMessage 	= '<span class="'.$class.'">'.bbcode($Message).'</span>';
				$USERS		= $GLOBALS['DATABASE']->query("SELECT `id`, `username` FROM ".USERS." WHERE `universe` = '".$_SESSION['adminuni']."'".(!empty($Lang) ? " AND `lang` = '".$GLOBALS['DATABASE']->sql_escape($Lang)."'": "").";");
				while($UserData = $GLOBALS['DATABASE']->fetch_array($USERS))
				{
					$sendMessage = str_replace('{USERNAME}', $UserData['username'], $pmMessage);
					SendSimpleMessage($UserData['id'], $USER['id'], TIMESTAMP, 50, $From, $pmSubject, $sendMessage);
				}
			}
			if($Mode == 1 || $Mode == 2) {
				require ROOT_PATH.'includes/classes/Mail.class.php';
				$userList	= array();
				
				$USERS		= $GLOBALS['DATABASE']->query("SELECT `email`, `username` FROM ".USERS." WHERE `universe` = '".$_SESSION['adminuni']."'".(!empty($Lang) ? " AND `lang` = '".$GLOBALS['DATABASE']->sql_escape($Lang)."'": "").";");
				while($UserData = $GLOBALS['DATABASE']->fetch_array($USERS))
				{				
					$userList[$UserData['email']]	= array(
						'username'	=> $UserData['username'],
						'body'		=> bbcode(str_replace('{USERNAME}', $UserData['username'], $Message))
					);
				}
				
				Mail::multiSend($userList, strip_tags($Subject));
			}
			exit($LNG['ma_message_sended']);
		} else {
			exit($LNG['ma_subject_needed']);
		}
	}
	
	$template	= new template();
	$template->assign_vars(array(
		'langSelector' => array_merge(array('' => $LNG['ma_all']), $LANG->getAllowedLangs(false)),
		'modes' => $LNG['ma_modes'],
	));
	$template->show('SendMessagesPage.tpl');
}
?>