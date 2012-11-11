<?php

/**
 *  2Moons
 *  Copyright (C) 2011 Jan Kröpke
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
 * @copyright 2009 Lucky
 * @copyright 2011 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.0 (2011-12-10)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

class InactiveMailCronjob
{
	function run()
	{
		global $LNG, $LANG;
		
		$CONFIG	= Config::getAll(NULL);
		$CONF	= $CONFIG[ROOT_UNI];
		
		if($CONF['mail_active'] == 1) {
			$Users	= $GLOBALS['DATABASE']->query("SELECT `id`, `username`, `lang`, `email`, `onlinetime`, `universe` FROM ".USERS." WHERE `inactive_mail` = '0' AND `onlinetime` < '".(TIMESTAMP - $CONF['del_user_sendmail'])."';");
			while($User	= $GLOBALS['DATABASE']->fetch_array($Users)) {
				$LANG->setUser($User['lang']);	
				$LANG->includeLang(array('L18N', 'INGAME', 'PUBLIC'));
				$MailSubject	= sprintf($LNG['spec_mail_inactive_title'], $CONF['game_name'].' - '.$CONFIG[$User['universe']]['uni_name']);
				$MailRAW		= file_get_contents("./language/".$User['lang']."/email/email_inactive.txt");
				$MailContent	= sprintf($MailRAW, $User['username'], $CONF['game_name'].' - '.$CONFIG[$User['universe']]['uni_name'], _date($LNG['php_tdformat'], $User['onlinetime']), PROTOCOL.$_SERVER['HTTP_HOST'].HTTP_ROOT);	
				
				require ROOT_PATH.'includes/classes/Mail.class.php';		
				Mail::send($User['email'], $User['username'], $MailSubject, $MailContent);
				$GLOBALS['DATABASE']->query("UPDATE ".USERS." SET `inactive_mail` = '1' WHERE `id` = '".$User['id']."';");
			}
		}
	}
}
?>