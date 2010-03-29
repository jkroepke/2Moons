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
include('AdminFunctions/Autorization.' . PHP_EXT);

if ($ConfigGame != 1) die(message ($lang['404_page']));

	if ($_POST['save'] == $lang['cs_save_changes'])
	{
		$Log	.=	"\n".$lang['log_the_user'].$user['username'].$lang['log_change_stats'].":\n";
		if (isset($_POST['stat']) && $_POST['stat'] != $game_config['stat'])
		{
			update_config('stat' , $_POST['stat']);
			$game_config['stat'] = $_POST['stat'];
			$ASD3	=	$_POST['stat'];
			$Log	.=	$lang['log_stats_value_5'].": ".$lang['log_viewmod2'][$ASD3]."\n";
		}
		if (isset($_POST['stat_level']) &&  is_numeric($_POST['stat_level']) && $_POST['stat_level'] != $game_config['stat_level'])
		{
			update_config('stat_level',  $_POST['stat_level']);
			$game_config['stat_level'] = $_POST['stat_level'];
			$ASD1	=	$_POST['stat_level'];
			$Log	.=	$lang['log_stats_value_6'].": ".$lang['rank'][$ASD1]."\n";
		}
		if (isset($_POST['stat_flying']) && $_POST['stat_flying'] != $game_config['stat_flying'])
		{
			update_config('stat_flying',  $_POST['stat_flying']);
			$game_config['stat_flying']	= $_POST['stat_flying'];
			$ASD2	=	$_POST['stat_flying'];
			$Log	.=	$lang['log_stats_value_4'].": ".$lang['log_viewmod'][$ASD2]."\n";
		}
		if (isset($_POST['stat_settings']) &&  is_numeric($_POST['stat_settings']) && $_POST['stat_settings'] != $game_config['stat_settings'])
		{
			update_config('stat_settings',  $_POST['stat_settings']);
			$game_config['stat_settings'] = $_POST['stat_settings'];
			$Log	.=	$lang['log_stats_value'].": ".$_POST['stat_settings']."\n";
		}
		if (isset($_POST['stat_amount']) &&  is_numeric($_POST['stat_amount']) && $_POST['stat_amount'] != $game_config['stat_amount'] && $_POST['stat_amount'] >= 10)
		{
			update_config('stat_amount',  $_POST['stat_amount']);
			$game_config['stat_amount']	= $_POST['stat_amount'];
			$Log	.=	$lang['log_stats_value_3'].": ".$_POST['stat_amount']."\n";
		}
		if (isset($_POST['stat_update_time']) &&  is_numeric($_POST['stat_update_time']) && $_POST['stat_update_time'] != $game_config['stat_update_time'])
		{
			update_config('stat_update_time',  $_POST['stat_update_time']);
			$game_config['stat_update_time'] = $_POST['stat_update_time'];
			$Log	.=	$lang['log_stats_value_2'].": ".$_POST['stat_update_time']."\n";
		}
		LogFunction($Log, "ConfigLog", $LogCanWork);
		header("location:ConfigStatsPage.php");
	}
	else
	{
		$selected					=	"selected=\"selected\"";
		$stat						=	(($game_config['stat'] == 0)?'sel_sta0':(($game_config['stat'] == 1)?'sel_sta1':'sel_sta2'));
		$lang[$stat]				=	$selected;
		$stat_fly					=	(($game_config['stat_flying'] == 1)? 'sel_sf1':'sel_sf0');
		$lang[$stat_fly]			=	$selected;
		$lang['stat_level']			=	$game_config['stat_level'];
		$lang['stat_settings']		=	$game_config['stat_settings'];
		$lang['stat_amount']		=	$game_config['stat_amount'];
		$lang['stat_update_time']	=	$game_config['stat_update_time'];
		$lang['timeact']			=	gmdate("d. M y H:i:s T", $game_config['stat_last_update']);

		$lang['yes']	=	$lang['one_is_yes'][1];
		$lang['no']		=	$lang['one_is_yes'][0];
		$admin_settings = parsetemplate(gettemplate('adm/ConfigStatsBody'), $lang);
		display($admin_settings, false, '', true, false);
	}
?>