<?php

##############################################################################
# *                                                                          #
# * 2MOONS                                                                   #
# *                                                                          #
# * @copyright Copyright (C) 2010 By ShadoX from titanspace.de               #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
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
			$Time    	= TIMESTAMP;
			$From    	= '<span style="color:'.$color.';">'.$LNG['user_level'][$USER['authlevel']].' '.$USER['username'].'</span>';
			$Subject 	= '<span style="color:'.$color.';">'.$Subject.'</span>';
			$Message 	= '<span style="color:'.$color.';font-weight:bold;">'.$Message.'</span>';

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