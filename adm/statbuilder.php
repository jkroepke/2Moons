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

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

define('ROOT_PATH', './../');
include(ROOT_PATH . 'extension.inc');
include(ROOT_PATH . 'common.'.PHP_EXT);


if ($USER['authlevel'] < 2) die(message ($LNG['not_enough_permissions']));

	require_once(ROOT_PATH.'includes/classes/class.statbuilder.php');
	$stat			= new statbuilder();
	$result			= $stat->MakeStats();
	$memory_p		= str_replace(array("%p", "%m"), $result['memory_peak'], $LNG['sb_top_memory']);
	$memory_e		= str_replace(array("%e", "%m"), $result['end_memory'], $LNG['sb_final_memory']);
	$memory_i		= str_replace(array("%i", "%m"), $result['initial_memory'], $LNG['sb_start_memory']);
	$stats_end_time	= str_replace("%t", $result['totaltime'], $LNG['sb_stats_update']);
	$stats_sql		= sprintf($LNG['sb_sql_counts'], $result['sql_count']);

	update_config('stat_last_update', $result['stats_time']);


	message($LNG['sb_stats_updated'].$stats_end_time.$memory_i.$memory_e.$memory_p.$stats_sql);


?>