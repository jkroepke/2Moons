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
 * @version 1.6.1 (2011-11-19)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) exit;

function ShowChatConfigPage()
{
	global $CONF, $LNG, $USER, $LANG;
	if (!empty($_POST))
	{
		$config_before = array(	
			'chat_closed'			=> $CONF['chat_closed'],
			'chat_allowchan'		=> $CONF['chat_allowchan'],
			'chat_allowmes'			=> $CONF['chat_allowmes'],
			'chat_allowdelmes'		=> $CONF['chat_allowdelmes'],
			'chat_logmessage'		=> $CONF['chat_logmessage'],
			'chat_nickchange'		=> $CONF['chat_nickchange'],
			'chat_botname'			=> $CONF['chat_botname'],
			'chat_channelname'		=> $CONF['chat_channelname'],
		);
		
		$CONF['chat_allowchan']			= isset($_POST['chat_allowchan']) && $_POST['chat_allowchan'] == 'on' ? 1 : 0;
		$CONF['chat_allowmes']			= isset($_POST['chat_allowmes']) && $_POST['chat_allowmes'] == 'on' ? 1 : 0;
		$CONF['chat_allowdelmes']		= isset($_POST['chat_allowdelmes']) && $_POST['chat_allowdelmes'] == 'on' ? 1 : 0;
		$CONF['chat_logmessage']		= isset($_POST['chat_logmessage']) && $_POST['chat_logmessage'] == 'on' ? 1 : 0;
		$CONF['chat_nickchange']		= isset($_POST['chat_nickchange']) && $_POST['chat_nickchange'] == 'on' ? 1 : 0;
		$CONF['chat_closed']			= isset($_POST['chat_closed']) && $_POST['chat_closed'] == 'on' ? 1 : 0;
		
		$CONF['chat_channelname']		= HTTP::_GP('chat_channelname', '', true);
		$CONF['chat_botname']			= HTTP::_GP('chat_botname', '', true);
		
		$config_after = array(	
			'chat_closed'			=> $CONF['chat_closed'],
			'chat_allowchan'		=> $CONF['chat_allowchan'],
			'chat_allowmes'			=> $CONF['chat_allowmes'],
			'chat_allowdelmes'		=> $CONF['chat_allowdelmes'],
			'chat_logmessage'		=> $CONF['chat_logmessage'],
			'chat_nickchange'		=> $CONF['chat_nickchange'],
			'chat_botname'			=> $CONF['chat_botname'],
			'chat_channelname'		=> $CONF['chat_channelname'],
		);
		
		update_config($config_after);
		
		$LOG = new Log(3);
		$LOG->target = 3;
		$LOG->old = $config_before;
		$LOG->new = $config_after;
		$LOG->save();
				
	}

	$template	= new template();

	$template->assign_vars(array(
		'chat_closed'			=> $CONF['chat_closed'],
		'chat_allowchan'		=> $CONF['chat_allowchan'],
		'chat_allowmes'			=> $CONF['chat_allowmes'],
		'chat_logmessage'		=> $CONF['chat_logmessage'],
		'chat_nickchange'		=> $CONF['chat_nickchange'],
		'chat_botname'			=> $CONF['chat_botname'],
		'chat_channelname'		=> $CONF['chat_channelname'],
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

?>