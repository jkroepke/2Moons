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
include(ROOT_PATH . 'common.'.PHP_EXT);

if (empty($_SESSION)) exit;

// Output transparent gif
header('Cache-Control: no-cache');
header('Content-type: image/gif');
header('Content-length: 43');
header('Expires: 0');
			
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
				
				if(($compprefix[0]."_") == DB_PREFIX)
				{
					$table .= "`".$pru["Name"]."`, ";
				}
			}
			$db->query("OPTIMIZE TABLE ".substr($table, 0, -2).";");
			ClearCache();
		}
	break;
	case "banner":
		if (!CheckModule(37) && TIMESTAMP >= ($CONF['stat_last_banner_update'] + (60 * $CONF['stat_banner_update_time'])))
		{
			update_config(array('stat_last_banner_update' => TIMESTAMP), true);
			require_once(ROOT_PATH . 'includes/classes/class.StatBanner.php');
			$banner	= new StatBanner();
			$banner->BuildIMGforAll();
		}
	break;
}
?>