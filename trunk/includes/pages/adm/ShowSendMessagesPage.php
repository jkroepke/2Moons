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
 * @version 1.3 (2011-01-21)
 * @link http://code.google.com/p/2moons/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) exit;

function ShowSendMessagesPage() {
	global $USER, $LNG, $db, $CONF;

	if ($_GET['action'] == 'send')
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
		
		$Subject	= request_var('subject', '', true);
		$Message 	= makebr(request_var('text', '', true));
		$Mode	 	= request_var('mode', 0);

		if (!empty($Message) && !empty($Subject))
		{
			require_once(ROOT_PATH.'includes/functions/BBCode.php');
			if($Mode == 0 || $Mode == 2) {
				$Time    	= TIMESTAMP;
				$From    	= '<span style="color:'.$color.';">'.$LNG['user_level'][$USER['authlevel']].' '.$USER['username'].'</span>';
				$Subject 	= '<span style="color:'.$color.';">'.$Subject.'</span>';
				$Message 	= '<span style="color:'.$color.';font-weight:bold;">'.bbcode($Message).'</span>';

				SendSimpleMessage(0, $USER['id'], TIMESTAMP, 50, $From, $Subject, $Message, 0, $_SESSION['adminuni']);
				$db->query("UPDATE ".USERS." SET `new_gmessage` = `new_gmessage` + '1', `new_message` = `new_message` + '1' WHERE `universe` = '".$_SESSION['adminuni']."';");
			}
			if($Mode == 1 || $Mode == 2) {
				require_once(ROOT_PATH.'includes/classes/class.phpmailer.php');
				$mail             	= new PHPMailer(true);
				$mail->IsHTML(true);
				if($CONF['mail_use'] == 2) {
					$mail->IsSMTP();  
					$mail->SMTPAuth   	= true; 
					$mail->SMTPSecure 	= $CONF['smtp_ssl'];  						
					$mail->Host      	= $CONF['smtp_host'];
					$mail->Port      	= $CONF['smtp_port'];
					$mail->Username  	= $CONF['smtp_user'];
					$mail->Password  	= $CONF['smtp_pass'];
					$mail->SMTPDebug  	= ($CONF['debug'] == 1) ? 2 : 0;   
				} elseif($CONF['mail_use'] == 1) {
					$mail->IsSendmail();
					$mai->Sendmail		= $CONF['smail_path'];
				} else {
					$mail->IsMail();
				}
				$mail->CharSet		= 'UTF-8';		
				$mail->Subject   	= $Subject;
				$mail->Body   		= bbcode($Message);
				$mail->SetFrom($CONF['smtp_sendmail'], $CONF['game_name']);
				$mail->AddAddress($CONF['smtp_sendmail'], $CONF['game_name']);
				$USERS	= $db->query("SELECT `username`, `email` FROM ".USERS." WHERE `universe` = '".$_SESSION['adminuni']."';");
				while($UserData = $db->fetch_array($USERS)) {
					$mail->AddBCC($UserData['email'], $UserData['username']);
				}
				$mail->Send();				
			}
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
		'ma_modes'		 			=> $LNG['ma_modes'],
		'button_submit' 			=> $LNG['button_submit'],
	));
	
	$template->show('adm/SendMessagesPage.tpl');
}
?>