<?php

##############################################################################
# *                                                                          #
# * 2MOONS                                                                   #
# *                                                                          #
# * @copyright Copyright (C) 2010 By ShadoX from titanspace.de               #
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

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_CRON' , true);

define('ROOT_PATH', './');
include(ROOT_PATH . 'extension.inc');
include(ROOT_PATH . 'common.php');

if (empty($_SESSION)) exit;

// Output transparent gif
header('Cache-Control: no-cache');
header('Content-type: image/gif');
header('Content-length: 43');
header('Expires: 0');
echo("\x47\x49\x46\x38\x39\x61\x01\x00\x01\x00\x80\x00\x00\x00\x00\x00\x00\x00\x00\x21\xF9\x04\x01\x00\x00\x00\x00\x2C\x00\x00\x00\x00\x01\x00\x01\x00\x00\x02\x02\x44\x01\x00\x3B");
$cron = request_var('cron','');
switch($cron) 
{
	case "stats":
		if (TIMESTAMP >= ($CONF['stat_last_update'] + (60 * $CONF['stat_update_time'])))
		{
			update_config(array('stat_last_update' => TIMESTAMP), true);
			require_once(ROOT_PATH . 'includes/classes/class.statbuilder.php');
			$stat			= new Statbuilder();
			$result			= $stat->MakeStats();
		}
	break;
	case "daily":
		if (TIMESTAMP >= ($CONF['stat_last_db_update'] + (60 * 60 * 24)))
		{
			update_config(array('stat_last_db_update' => TIMESTAMP), true);
			$prueba = $db->query("SHOW TABLE STATUS from ".DB_NAME.";");
			$table = "";
			while($pru = $db->fetch_array($prueba)){
				$compprefix = explode("_",$pru["Name"]);  
				
				if($compprefix[0].'_' == DB_PREFIX && $compprefix[1] != 'session')
				{
					$table .= "`".$pru["Name"]."`, ";
				}
			}
			$db->query("OPTIMIZE TABLE ".substr($table, 0, -2).";");
			ClearCache();
		}
	break;
	case "teamspeak":
		if ($CONF['ts_modon'] == 1 && TIMESTAMP >= ($CONF['ts_cron_last'] + 60 * $CONF['ts_cron_interval']))
		{
			update_config(array('ts_cron_last' => TIMESTAMP), true);
			if($CONF['ts_version'] == 2)
			{
				include_once(ROOT_PATH.'includes/libs/teamspeak/class.teamspeak2.'.PHP_EXT);
				$ts = new cyts();
				if($ts->connect($CONF['ts_server'], $CONF['ts_tcpport'], $CONF['ts_udpport'], $CONF['ts_timeout'])) {
					file_put_contents(ROOT_PATH.'cache/teamspeak_cache.php', serialize(array($ts->info_serverInfo(), $ts->info_globalInfo())));
					$ts->disconnect();
				}
			} elseif($CONF['ts_version'] == 3){
				require_once(ROOT_PATH . "includes/libs/teamspeak/class.teamspeak3.".PHP_EXT);
				$tsAdmin 	= new ts3admin($CONF['ts_server'], $CONF['ts_udpport'], $CONF['ts_timeout']);
				$Active		= $tsAdmin->connect();
				if($Active['success']) {
					$tsAdmin->selectServer($CONF['ts_tcpport'], 'port', true);
					$tsAdmin->login($CONF['ts_login'], $CONF['ts_password']);
					file_put_contents(ROOT_PATH.'cache/teamspeak_cache.php', serialize($tsAdmin->serverInfo()));
					$tsAdmin->logout();
				}
				var_dump($tsAdmin->getDebugLog());
			}
		}
	break;
}
?>