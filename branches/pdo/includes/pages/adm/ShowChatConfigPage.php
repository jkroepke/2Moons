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
 * @version 1.7.2 (2013-03-18)
 * @info $Id$
 * @link http://2moons.cc/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) throw new Exception("Permission error!");

function ShowChatConfigPage()
{
	global $LNG;

	$config = Config::get($_SESSION['adminuni']);

	if (!empty($_POST))
	{
		$config_before = array(	
			'chat_closed'			=> $config->chat_closed,
			'chat_allowchan'		=> $config->chat_allowchan,
			'chat_allowmes'			=> $config->chat_allowmes,
			'chat_allowdelmes'		=> $config->chat_allowdelmes,
			'chat_logmessage'		=> $config->chat_logmessage,
			'chat_nickchange'		=> $config->chat_nickchange,
			'chat_botname'			=> $config->chat_botname,
			'chat_channelname'		=> $config->chat_channelname,
		);
		
		$chat_allowchan			= isset($_POST['chat_allowchan']) && $_POST['chat_allowchan'] == 'on' ? 1 : 0;
		$chat_allowmes			= isset($_POST['chat_allowmes']) && $_POST['chat_allowmes'] == 'on' ? 1 : 0;
		$chat_allowdelmes		= isset($_POST['chat_allowdelmes']) && $_POST['chat_allowdelmes'] == 'on' ? 1 : 0;
		$chat_logmessage		= isset($_POST['chat_logmessage']) && $_POST['chat_logmessage'] == 'on' ? 1 : 0;
		$chat_nickchange		= isset($_POST['chat_nickchange']) && $_POST['chat_nickchange'] == 'on' ? 1 : 0;
		$chat_closed			= isset($_POST['chat_closed']) && $_POST['chat_closed'] == 'on' ? 1 : 0;
		
		$chat_channelname		= HTTP::_GP('chat_channelname', '', true);
		$chat_botname			= HTTP::_GP('chat_botname', '', true);
		
		$config_after = array(	
			'chat_closed'			=> $chat_closed,
			'chat_allowchan'		=> $chat_allowchan,
			'chat_allowmes'			=> $chat_allowmes,
			'chat_allowdelmes'		=> $chat_allowdelmes,
			'chat_logmessage'		=> $chat_logmessage,
			'chat_nickchange'		=> $chat_nickchange,
			'chat_botname'			=> $chat_botname,
			'chat_channelname'		=> $chat_channelname,
		);

		foreach($config_after as $key => $value)
		{
			$config->$key	= $value;
		}
		$config->save();
		
		$LOG = new Log(3);
		$LOG->target = 3;
		$LOG->old = $config_before;
		$LOG->new = $config_after;
		$LOG->save();
	}

	$template	= new template();

	$template->assign_vars(array(
		'chat_closed'			=> $config->chat_closed,
		'chat_allowchan'		=> $config->chat_allowchan,
		'chat_allowmes'			=> $config->chat_allowmes,
		'chat_logmessage'		=> $config->chat_logmessage,
		'chat_nickchange'		=> $config->chat_nickchange,
		'chat_botname'			=> $config->chat_botname,
		'chat_channelname'		=> $config->chat_channelname,
		'se_server_parameters'	=> $LNG['se_server_parameters'],
		'se_save_parameters'	=> $LNG['se_save_parameters'],
		'ch_closed'				=> $LNG['ch_closed'],
		'ch_allowchan'			=> $LNG['ch_allowchan'],
		'ch_allowmes'			=> $LNG['ch_allowmes'],
		'ch_allowdelmes'		=> $LNG['ch_allowdelmes'],
		'ch_logmessage'			=> $LNG['ch_logmessage'],
		'ch_nickchange'			=> $LNG['ch_nickchange'],
		'ch_botname'			=> $LNG['ch_botname'],
		'ch_channelname'		=> $LNG['ch_channelname'],
	));
	
	$template->show('ChatConfigBody.tpl');
}
