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