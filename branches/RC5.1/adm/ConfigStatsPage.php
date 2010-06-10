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


if ($CONFGame != 1) die(message ($LNG['404_page']));

	if ($_POST['save'] == $LNG['cs_save_changes'])
	{
		$Log	.=	"\n".$LNG['log_the_user'].$USER['username'].$LNG['log_change_stats'].":\n";
		if (isset($_POST['stat']) && $_POST['stat'] != $CONF['stat'])
		{
			update_config('stat' , $_POST['stat']);
			$CONF['stat'] = $_POST['stat'];
			$ASD3	=	$_POST['stat'];
			$Log	.=	$LNG['log_stats_value_5'].": ".$LNG['log_viewmod2'][$ASD3]."\n";
		}
		if (isset($_POST['stat_level']) &&  is_numeric($_POST['stat_level']) && $_POST['stat_level'] != $CONF['stat_level'])
		{
			update_config('stat_level',  $_POST['stat_level']);
			$CONF['stat_level'] = $_POST['stat_level'];
			$ASD1	=	$_POST['stat_level'];
			$Log	.=	$LNG['log_stats_value_6'].": ".$LNG['rank'][$ASD1]."\n";
		}
		if (isset($_POST['stat_flying']) && $_POST['stat_flying'] != $CONF['stat_flying'])
		{
			update_config('stat_flying',  $_POST['stat_flying']);
			$CONF['stat_flying']	= $_POST['stat_flying'];
			$ASD2	=	$_POST['stat_flying'];
			$Log	.=	$LNG['log_stats_value_4'].": ".$LNG['log_viewmod'][$ASD2]."\n";
		}
		if (isset($_POST['stat_settings']) &&  is_numeric($_POST['stat_settings']) && $_POST['stat_settings'] != $CONF['stat_settings'])
		{
			update_config('stat_settings',  $_POST['stat_settings']);
			$CONF['stat_settings'] = $_POST['stat_settings'];
			$Log	.=	$LNG['log_stats_value'].": ".$_POST['stat_settings']."\n";
		}
		if (isset($_POST['stat_amount']) &&  is_numeric($_POST['stat_amount']) && $_POST['stat_amount'] != $CONF['stat_amount'] && $_POST['stat_amount'] >= 10)
		{
			update_config('stat_amount',  $_POST['stat_amount']);
			$CONF['stat_amount']	= $_POST['stat_amount'];
			$Log	.=	$LNG['log_stats_value_3'].": ".$_POST['stat_amount']."\n";
		}
		if (isset($_POST['stat_update_time']) &&  is_numeric($_POST['stat_update_time']) && $_POST['stat_update_time'] != $CONF['stat_update_time'])
		{
			update_config('stat_update_time',  $_POST['stat_update_time']);
			$CONF['stat_update_time'] = $_POST['stat_update_time'];
			$Log	.=	$LNG['log_stats_value_2'].": ".$_POST['stat_update_time']."\n";
		}
		LogFunction($Log, "ConfigLog", $LogCanWork);
		header("location:ConfigStatsPage.php");
	}
	else
	{
		$selected					=	"selected=\"selected\"";
		$stat						=	(($CONF['stat'] == 0)?'sel_sta0':(($CONF['stat'] == 1)?'sel_sta1':'sel_sta2'));
		$LNG[$stat]				=	$selected;
		$stat_fly					=	(($CONF['stat_flying'] == 1)? 'sel_sf1':'sel_sf0');
		$LNG[$stat_fly]			=	$selected;
		$LNG['stat_level']			=	$CONF['stat_level'];
		$LNG['stat_settings']		=	$CONF['stat_settings'];
		$LNG['stat_amount']		=	$CONF['stat_amount'];
		$LNG['stat_update_time']	=	$CONF['stat_update_time'];
		$LNG['timeact']			=	gmdate("d. M y H:i:s T", $CONF['stat_last_update']);

		$LNG['yes']	=	$LNG['one_is_yes'][1];
		$LNG['no']		=	$LNG['one_is_yes'][0];
		$admin_settings = parsetemplate(gettemplate('adm/ConfigStatsBody'), $LNG);
		display($admin_settings, false, '', true, false);
	}
?>