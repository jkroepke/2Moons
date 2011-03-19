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

function ShowChatConfigPage()
{
	global $CONF, $LNG, $USER, $LANG;
	if (!empty($_POST))
	{
		$CONF['chat_allowchan']			= isset($_POST['chat_allowchan']) && $_POST['chat_allowchan'] == 'on' ? 1 : 0;
		$CONF['chat_allowmes']			= isset($_POST['chat_allowmes']) && $_POST['chat_allowmes'] == 'on' ? 1 : 0;
		$CONF['chat_allowdelmes']		= isset($_POST['chat_allowdelmes']) && $_POST['chat_allowdelmes'] == 'on' ? 1 : 0;
		$CONF['chat_logmessage']		= isset($_POST['chat_logmessage']) && $_POST['chat_logmessage'] == 'on' ? 1 : 0;
		$CONF['chat_socket_active']		= isset($_POST['chat_socket_active']) && $_POST['chat_socket_active'] == 'on' ? 1 : 0;
		$CONF['chat_nickchange']		= isset($_POST['chat_nickchange']) && $_POST['chat_nickchange'] == 'on' ? 1 : 0;
		$CONF['chat_closed']			= isset($_POST['chat_closed']) && $_POST['chat_closed'] == 'on' ? 1 : 0;
		
		$CONF['chat_socket_host']		= request_var('chat_socket_host', '', true);
		$CONF['chat_socket_ip']			= request_var('chat_socket_ip', '');
		$CONF['chat_socket_port']		= request_var('chat_socket_port', '', 0);
		$CONF['chat_socket_chatid']		= request_var('chat_socket_chatid', 0);
		$CONF['chat_channelname']		= request_var('chat_channelname', '', true);
		$CONF['chat_botname']			= request_var('chat_botname', '', true);
		
		update_config(array(	
			'chat_closed'			=> $CONF['chat_closed'],
			'chat_allowchan'		=> $CONF['chat_allowchan'],
			'chat_allowmes'			=> $CONF['chat_allowmes'],
			'chat_allowdelmes'		=> $CONF['chat_allowdelmes'],
			'chat_logmessage'		=> $CONF['chat_logmessage'],
			'chat_nickchange'		=> $CONF['chat_nickchange'],
			'chat_botname'			=> $CONF['chat_botname'],
			'chat_channelname'		=> $CONF['chat_channelname'],
			'chat_socket_chatid'	=> $CONF['chat_socket_chatid'],
			'chat_socket_port'		=> $CONF['chat_socket_port'],
			'chat_socket_ip'		=> $CONF['chat_socket_ip'],
			'chat_socket_host'		=> $CONF['chat_socket_host'],
			'chat_socket_active'	=> $CONF['chat_socket_active'],
		), true);
	}

	$template	= new template();
	$template->assign_vars(array(
		'chat_socket_chatid'	=> $CONF['chat_socket_chatid'],
		'chat_socket_port'		=> $CONF['chat_socket_port'],
		'chat_socket_ip'		=> $CONF['chat_socket_ip'],
		'chat_socket_host'		=> $CONF['chat_socket_host'],
		'chat_socket_active'	=> $CONF['chat_socket_active'],
		'chat_closed'			=> $CONF['chat_closed'],
		'chat_allowchan'		=> $CONF['chat_allowchan'],
		'chat_allowmes'			=> $CONF['chat_allowmes'],
		'chat_logmessage'		=> $CONF['chat_logmessage'],
		'chat_nickchange'		=> $CONF['chat_nickchange'],
		'chat_botname'			=> $CONF['chat_botname'],
		'chat_channelname'		=> $CONF['chat_channelname'],
		'se_server_parameters'	=> $LNG['se_server_parameters'],
		'se_save_parameters'	=> $LNG['se_save_parameters'],
		'ch_socket_chatid_info'	=> $LNG['ch_socket_chatid_info'],
		'ch_socket_port_info'	=> $LNG['ch_socket_port_info'],
		'ch_socket_ip_info'		=> $LNG['ch_socket_ip_info'],
		'ch_socket_host_info'	=> $LNG['ch_socket_host_info'],
		'ch_socket_chatid'		=> $LNG['ch_socket_chatid'],
		'ch_socket_port'		=> $LNG['ch_socket_port'],
		'ch_socket_ip'			=> $LNG['ch_socket_ip'],
		'ch_socket_host'		=> $LNG['ch_socket_host'],
		'ch_socket_active'		=> $LNG['ch_socket_active'],
		'ch_socket'				=> $LNG['ch_socket'],
		'ch_closed'				=> $LNG['ch_closed'],
		'ch_allowchan'			=> $LNG['ch_allowchan'],
		'ch_allowmes'			=> $LNG['ch_allowmes'],
		'ch_allowdelmes'		=> $LNG['ch_allowdelmes'],
		'ch_logmessage'			=> $LNG['ch_logmessage'],
		'ch_nickchange'			=> $LNG['ch_nickchange'],
		'ch_botname'			=> $LNG['ch_botname'],
		'ch_channelname'		=> $LNG['ch_channelname'],
	));
	
	$template->show('adm/ChatConfigBody.tpl');
}

?>