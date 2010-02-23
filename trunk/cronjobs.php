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

$xgp_root = './';
include($xgp_root . 'extension.inc.php');
include($xgp_root . 'common.'.$phpEx);

if (!$IsUserChecked) die(header('Location: index.php'));

// Output transparent gif
header('Cache-Control: no-cache');
header('Content-type: image/gif');
header('Content-length: 43');

$cron = request_var('cron','');
switch($cron) 
{
	case "stats":
		if (time() >= ($game_config['stat_last_update'] + (60 * $game_config['stat_update_time'])))
		{
			require_once($xgp_root . 'includes/classes/class.statfunctions.php');
			$stat			= new Statbuilder();
			$result			= $stat->MakeStats();
			update_config('stat_last_update', $result['stats_time']);
		}
	break;
	case "opdb":
		if (time() >= ($game_config['stat_last_db_update'] + (60 * 60 * 24)))
		{
			require($xgp_root . 'config.' . $phpEx);
			$prueba = $db->query("SHOW TABLE STATUS from ".DB_NAME.";");
			$table = "";
			while($pru = $db->fetch($prueba)){
				$compprefix = explode("_",$pru["Name"]);  
				
				if(($compprefix[0]."_") == $database["tableprefix"])
				{
					$table .= "`".$pru["Name"]."`, ";
				}
			}
			$db->query("OPTIMIZE TABLE ".substr($table, 0, -2).";");
			update_config('stat_last_db_update', time());
			unset($database);
		}
	break;
}
?>