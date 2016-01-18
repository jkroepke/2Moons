
<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @licence MIT
 * @version 1.7.2 (2013-03-18)
 * @info $Id$
 * @link http://2moons.cc/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) throw new Exception("Permission error!");


function ShowSendMessagesPage() {
	global $USER, $LNG;
	
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
			default:
				$class = '';
			break;
		}

		$Subject	= HTTP::_GP('subject', '', true);
		$Message 	= HTTP::_GP('text', '', true);
		$Mode	 	= HTTP::_GP('mode', 0);
		$Lang	 	= HTTP::_GP('lang', '');

		if (!empty($Message) && !empty($Subject))
		{
			require 'includes/classes/BBCode.class.php';
			if($Mode == 0 || $Mode == 2) {
				$From    	= '<span class="'.$class.'">'.$LNG['user_level'][$USER['authlevel']].' '.$USER['username'].'</span>';
				$pmSubject 	= '<span class="'.$class.'">'.$Subject.'</span>';
				$pmMessage 	= '<span class="'.$class.'">'.BBCode::parse($Message).'</span>';
				$USERS		= $GLOBALS['DATABASE']->query("SELECT `id`, `username` FROM ".USERS." WHERE `universe` = '".Universe::getEmulated()."'".(!empty($Lang) ? " AND `lang` = '".$GLOBALS['DATABASE']->sql_escape($Lang)."'": "").";");
				while($UserData = $GLOBALS['DATABASE']->fetch_array($USERS))
				{
					$sendMessage = str_replace('{USERNAME}', $UserData['username'], $pmMessage);
					PlayerUtil::sendMessage($UserData['id'], $USER['id'], $From, 50, $pmSubject, $sendMessage, TIMESTAMP, NULL, 1, Universe::getEmulated());
				}
			}

			if($Mode == 1 || $Mode == 2) {
				require 'includes/classes/Mail.class.php';
				$userList	= array();
				
				$USERS		= $GLOBALS['DATABASE']->query("SELECT `email`, `username` FROM ".USERS." WHERE `universe` = '".Universe::getEmulated()."'".(!empty($Lang) ? " AND `lang` = '".$GLOBALS['DATABASE']->sql_escape($Lang)."'": "").";");
				while($UserData = $GLOBALS['DATABASE']->fetch_array($USERS))
				{				
					$userList[$UserData['email']]	= array(
						'username'	=> $UserData['username'],
						'body'		=> BBCode::parse(str_replace('{USERNAME}', $UserData['username'], $Message))
					);
				}
				
				Mail::multiSend($userList, strip_tags($Subject));
			}
			exit($LNG['ma_message_sended']);
		} else {
			exit($LNG['ma_subject_needed']);
		}
	}
	
	$sendModes	= $LNG['ma_modes'];
	
	if(Config::get()->mail_active == 0)
	{
		unset($sendModes[1]);
		unset($sendModes[2]);
	}
	
	$template	= new template();
	$template->assign_vars(array(
		'langSelector' => array_merge(array('' => $LNG['ma_all']), $LNG->getAllowedLangs(false)),
		'modes' => $sendModes,
	));
	$template->show('SendMessagesPage.tpl');
}