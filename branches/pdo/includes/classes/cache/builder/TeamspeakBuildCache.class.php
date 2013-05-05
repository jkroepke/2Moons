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


class TeamspeakBuildCache implements BuildCache
{
	function buildCache()
	{		
		$teamspeakData	= array();
		$config	= Config::get();
		
		switch($config->ts_version)
		{
			case 2:
				require 'includes/libs/teamspeak/cyts/cyts.class.php';
				$ts = new cyts();

				if($ts->connect($config->ts_server, $config->ts_tcpport, $config->ts_udpport, $config->ts_timeout)) {
					$serverInfo	= $ts->info_serverInfo();
					$teamspeakData	= array(
						'password'	=> '', // NO Server-API avalible.
						'current'	=> $serverInfo["server_currentusers"],
						'maxuser'	=> $serverInfo["server_maxusers"],
					);
					$ts->disconnect();
				} else {
					$error	= $ts->debug();
					throw new Exception('Teamspeak-Error: '.implode("<br>\r\n", $error));
				}
			break;
			case 3:
				require 'includes/libs/teamspeak/ts3admin/ts3admin.class.php';
				$tsAdmin 	= new ts3admin($config->ts_server, $config->ts_udpport, $config->ts_timeout);
				$connected	= $tsAdmin->connect();				
				if(!$connected['success'])
				{
					throw new Exception('Teamspeak-Error: '.implode("<br>\r\n", $connected['errors']));
				}
				
				$selected	= $tsAdmin->selectServer($config->ts_tcpport, 'port', true);
				if(!$selected['success'])
				{
					throw new Exception('Teamspeak-Error: '.implode("<br>\r\n", $selected['errors']));
				}
					
				$loggedIn	= $tsAdmin->login($config->ts_login, $config->ts_password);
				if(!$loggedIn['success'])
				{
					throw new Exception('Teamspeak-Error: '.implode("<br>\r\n", $loggedIn['errors']));
				}
				
				$serverInfo = $tsAdmin->serverInfo();
				if(!$serverInfo['success'])
				{
					throw new Exception('Teamspeak-Error: '.implode("<br>\r\n", $serverInfo['errors']));
				}
				
				$teamspeakData	= array(
					'password'	=> $serverInfo['data']['virtualserver_password'],
					'current'	=> $serverInfo['data']['virtualserver_clientsonline'] - 1, 
					'maxuser'	=> $serverInfo['data']['virtualserver_maxclients'],
				);
				
				$tsAdmin->logout();
			break;
		}
		
		return $teamspeakData;
	}
}