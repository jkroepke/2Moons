<?php

##############################################################################
# *																			 #
# * RN FRAMEWORK															 #
# *  																		 #
# * @copyright Copyright (C) 2009 By ShadoX from xnova-reloaded.de	    	 #
# *																			 #
# *																			 #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.									 #
# *																			 #
# *  This program is distributed in the hope that it will be useful,		 #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of			 #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 #
# *  GNU General Public License for more details.							 #
# *																			 #
##############################################################################

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

define('ROOT_PATH', './../');
include(ROOT_PATH . 'extension.inc');
include(ROOT_PATH . 'common.' . PHP_EXT);
include('AdminFunctions/Autorization.' . PHP_EXT);

if ($ConfigGame != 1) die();

function DisplayGameSettingsPage ( $CurrentUser )
{
	global $game_config, $lang;

	if ($_POST['opt_save'] == "1")
	{

		if (isset($_POST['closed']) && $_POST['closed'] == 'on') {
		$game_config['game_disable']         = 1;
		$game_config['close_reason']         = addslashes( $_POST['close_reason'] );
		} else {
		$game_config['game_disable']         = 0;
		$game_config['close_reason']         = addslashes( $_POST['close_reason'] );
		}

		if (isset($_POST['debug']) && $_POST['debug'] == 'on') {
		$game_config['debug'] = 1;
		} else {
		$game_config['debug'] = 0;
		}

		if (isset($_POST['game_name']) && $_POST['game_name'] != '') {
		$game_config['game_name'] = $_POST['game_name'];
		}

		if (isset($_POST['forum_url']) && $_POST['forum_url'] != '') {
		$game_config['forum_url'] = $_POST['forum_url'];
		}

		if (isset($_POST['game_speed']) && is_numeric($_POST['game_speed'])) {
		$game_config['game_speed'] = (2500 * $_POST['game_speed']);
		}

		if (isset($_POST['fleet_speed']) && is_numeric($_POST['fleet_speed'])) {
		$game_config['fleet_speed'] = (2500 * $_POST['fleet_speed']);
		}

		if (isset($_POST['resource_multiplier']) && is_numeric($_POST['resource_multiplier'])) {
		$game_config['resource_multiplier'] = $_POST['resource_multiplier'];
		}

		if (isset($_POST['initial_fields']) && is_numeric($_POST['initial_fields'])) {
		$game_config['initial_fields'] = $_POST['initial_fields'];
		}

		if (isset($_POST['metal_basic_income']) && is_numeric($_POST['metal_basic_income'])) {
		$game_config['metal_basic_income'] = $_POST['metal_basic_income'];
		}

		if (isset($_POST['crystal_basic_income']) && is_numeric($_POST['crystal_basic_income'])) {
		$game_config['crystal_basic_income'] = $_POST['crystal_basic_income'];
		}

		if (isset($_POST['deuterium_basic_income']) && is_numeric($_POST['deuterium_basic_income'])) {
		$game_config['deuterium_basic_income'] = $_POST['deuterium_basic_income'];
		}

		if (isset($_POST['ftp_server']) && is_numeric($_POST['ftp_server'])) {
		$game_config['ftp_server'] = $_POST['ftp_server'];
		}

		if (isset($_POST['ftp_user_name']) && is_numeric($_POST['ftp_user_name'])) {
		$game_config['ftp_user_name'] = $_POST['ftp_user_name'];
		}

		if (isset($_POST['ftp_user_pass']) && is_numeric($_POST['ftp_user_pass'])) {
		$game_config['ftp_user_pass'] = $_POST['ftp_user_pass'];
		}

		if (isset($_POST['ftp_root_path']) && is_numeric($_POST['ftp_root_path'])) {
		$game_config['ftp_root_path'] = $_POST['ftp_root_path'];
		}

		if (isset($_POST['adm_attack']) && $_POST['adm_attack'] == 'on') {
			$game_config['adm_attack'] = 1;
		} else {
			$game_config['adm_attack'] = 0;
		}

		if (isset($_POST['language'])) {
			$game_config['lang'] = $_POST['language'];
		} else {
			$game_config['lang'];
		}
		
		if (isset($_POST['cookie_name']) && $_POST['game_name'] != '') {
			$game_config['COOKIE_NAME'] = $_POST['cookie_name'];
		}
		
		if (isset($_POST['Defs_Cdr']) && is_numeric($_POST['Defs_Cdr'])) {
			if ($_POST['Defs_Cdr'] > 100)
				$game_config['Defs_Cdr'] = 100;
			elseif ($_POST['Defs_Cdr'] < 0)
				$game_config['Defs_Cdr'] = 0;
			else
				$game_config['Defs_Cdr'] = $_POST['Defs_Cdr'];
		}
		
		if (isset($_POST['Fleet_Cdr']) && is_numeric($_POST['Fleet_Cdr'])) {
			if ($_POST['Fleet_Cdr'] > 100)
				$game_config['Fleet_Cdr'] = 100;
			elseif ($_POST['Fleet_Cdr'] < 0)
				$game_config['Fleet_Cdr'] = 0;
			else
				$game_config['Fleet_Cdr'] = $_POST['Fleet_Cdr'];
		}
		
		if (isset($_POST['capaktiv']) && $_POST['capaktiv'] == 'on') {
			$game_config['capaktiv'] = 1;
		} else {
			$game_config['capaktiv'] = 0;
		}
		
		if (isset($_POST['capprivate'])) {
			$game_config['capprivate'] = $_POST['capprivate'];
		}

		if (isset($_POST['cappublic'])) {
			$game_config['cappublic'] = $_POST['cappublic'];
		}
		
		if (isset($_POST['min_build_time']) && is_numeric($_POST['min_build_time'])){
			if ($_POST['min_build_time'] < 0) {
				$game_config['min_build_time'] = 0;
			} else {
				$game_config['min_build_time'] = $_POST['min_build_time'];			
			}
		}
		
		if (isset($_POST['newsframe']) && $_POST['newsframe'] == 'on') {
			$game_config['OverviewNewsFrame']     = "1";
			$game_config['OverviewNewsText']      = $_POST['NewsText'];
        } else {
			$game_config['OverviewNewsFrame']     = "0";
			$game_config['OverviewNewsText']      = "";
        }
		
		if (isset($_POST['reg_closed']) && $_POST['reg_closed'] == 'on') {
			$game_config['reg_closed'] = 1;
		} else {
			$game_config['reg_closed'] = 0;
		}		
		if (isset($_POST['noobprotection']) && $_POST['noobprotection'] == 'on') {
			$game_config['noobprotection'] = 1;
		} else {
			$game_config['noobprotection'] = 0;
		}
		
		if (isset($_POST['noobprotectiontime']) && is_numeric($_POST['noobprotectiontime'])) {
			$game_config['noobprotectiontime'] = $_POST['noobprotectiontime'];
		}
		
		if (isset($_POST['noobprotectionmulti']) && is_numeric($_POST['noobprotectionmulti'])) {
			$game_config['noobprotectionmulti'] = $_POST['noobprotectionmulti'];
		}
		if (isset($_POST['user_valid']) && $_POST['user_valid'] == 'on') {
			$game_config['user_valid'] = 1;
		} else {
			$game_config['user_valid'] = 0;
		}
		
		if (isset($_POST['smtp_host'])) {
			$game_config['smtp_host'] = $_POST['smtp_host'];
		}
		
		if (isset($_POST['smtp_port']) && is_numeric($_POST['smtp_port'])) {
			$game_config['smtp_port'] = $_POST['smtp_port'];
		}
		
		if (isset($_POST['smtp_user'])) {
			$game_config['smtp_user'] = $_POST['smtp_user'];
		}
		
		if (isset($_POST['smtp_pass'])) {
			$game_config['smtp_pass'] = $_POST['smtp_pass'];
		}		
		if (isset($_POST['smtp_ssl'])) {
			$game_config['smtp_ssl'] = $_POST['smtp_ssl'];
		}	
		
		$fp = fopen('logs/adminlog_'.date('d.m.Y').'.txt','a');
		fwrite($fp,date("d.m.Y H:i:s",time())." - ".$CurrentUser['username']." - ".$CurrentUser['user_lastip']." - ".__FILE__." - changed game values. UserID: ".$CurrentUser['id']."\n");
		fclose($fp);
		update_config('noobprotectiontime'		, $game_config['noobprotectiontime']	 );
		update_config('noobprotectionmulti'		, $game_config['noobprotectionmulti']	 );
		update_config('noobprotection'			, $game_config['noobprotection']		 );
		update_config('Defs_Cdr'				, $game_config['Defs_Cdr']				 );
		update_config('Fleet_Cdr'				, $game_config['Fleet_Cdr']              );
		update_config('game_disable'			, $game_config['game_disable']           );
		update_config('close_reason'			, $game_config['close_reason']           );
        update_config('OverviewNewsFrame'		, $game_config['OverviewNewsFrame']      );
		update_config('reg_closed'				, $game_config['reg_closed']           	 );
        update_config('OverviewNewsText'		, $game_config['OverviewNewsText']		 );
		update_config('game_name'				, $game_config['game_name']            	 );
		update_config('forum_url'				, $game_config['forum_url']              );
		update_config('game_speed'				, $game_config['game_speed']             );
		update_config('fleet_speed'				, $game_config['fleet_speed']            );
		update_config('resource_multiplier'		, $game_config['resource_multiplier']    );
		update_config('initial_fields'			, $game_config['initial_fields']         );
		update_config('metal_basic_income'		, $game_config['metal_basic_income']     );
		update_config('COOKIE_NAME'				, $game_config['COOKIE_NAME']		     );
		update_config('crystal_basic_income'	, $game_config['crystal_basic_income']   );
		update_config('deuterium_basic_income'	, $game_config['deuterium_basic_income'] );
		update_config('energy_basic_income'		, $game_config['energy_basic_income']    );
		update_config('debug'					, $game_config['debug']                  );
		update_config('adm_attack'				, $game_config['adm_attack']             );
		update_config('lang'					, $game_config['lang']             	  	 );
		update_config('capaktiv'				, $game_config['capaktiv']               );
		update_config('capprivate'				, $game_config['capprivate']             );
		update_config('cappublic'				, $game_config['cappublic']              );
		update_config('min_build_time'			, $game_config['min_build_time']         );
		update_config('smtp_host'				, $game_config['smtp_host']              );
		update_config('smtp_port'				, $game_config['smtp_port']       	  	 );
		update_config('smtp_user'				, $game_config['smtp_user']              );
		update_config('smtp_pass'				, $game_config['smtp_pass']	             );
		update_config('smtp_ssl'				, $game_config['smtp_ssl']	             );
		update_config('user_valid'				, $game_config['user_valid']             );
		update_config('ftp_server'				, (isset($_POST['ftp_server'])) ? $_POST['ftp_server']:$game_config['ftp_server']         );
		update_config('ftp_user_name'			, (isset($_POST['ftp_user_name'])) ? $_POST['ftp_user_name']:$game_config['ftp_user_name']      );
		update_config('ftp_user_pass'			, (isset($_POST['ftp_user_pass'])) ? $_POST['ftp_user_pass']:$game_config['ftp_user_pass']      );
		update_config('ftp_root_path'			, (isset($_POST['ftp_root_path'])) ? $_POST['ftp_root_path']:$game_config['ftp_root_path']      );

		header("location:SettingsPage.php");
	}
	else
	{
		$parse								= $lang;
		$parse['game_name']              	= $game_config['game_name'];
		$parse['game_speed']             	= ($game_config['game_speed'] / 2500);
		$parse['fleet_speed']            	= ($game_config['fleet_speed'] / 2500);
		$parse['resource_multiplier']    	= $game_config['resource_multiplier'];
		$parse['forum_url']              	= $game_config['forum_url'];
		$parse['initial_fields']         	= $game_config['initial_fields'];
		$parse['metal_basic_income']     	= $game_config['metal_basic_income'];
		$parse['crystal_basic_income']   	= $game_config['crystal_basic_income'];
		$parse['deuterium_basic_income'] 	= $game_config['deuterium_basic_income'];
		$parse['closed']                 	= ($game_config['game_disable'] == 1) ? " checked = 'checked' ":"";
		$parse['close_reason']           	= $game_config['close_reason'];
		$parse['debug']                  	= ($game_config['debug'] == 1)        ? " checked = 'checked' ":"";
		$parse['reg_closed']                = ($game_config['reg_closed'] == 1) ? " checked = 'checked' ":"";
		$parse['adm_attack']             	= ($game_config['adm_attack'] == 1)   ? " checked = 'checked' ":"";
        $parse['newsframe']                 = ($game_config['OverviewNewsFrame'] == 1) ? " checked = 'checked' ":"";
        $parse['NewsTextVal']               = $game_config['OverviewNewsText'];  
		$parse['capprivate'] 				= $game_config['capprivate'];
		$parse['cappublic']    				= $game_config['cappublic'];
		$parse['capaktiv']                 	= ($game_config['capaktiv'] == 1) ? " checked = 'checked' ":"";
		$parse['min_build_time']            = $game_config['min_build_time'];
		$parse['cookie'] 					= $game_config['COOKIE_NAME'];
		$parse['defenses'] 					= $game_config['Defs_Cdr'];
		$parse['shiips'] 					= $game_config['Fleet_Cdr'];
		$parse['noobprot']            	 	= ($game_config['noobprotection'] == 1)   ? " checked = 'checked' ":"";
		$parse['noobprot2'] 				= $game_config['noobprotectiontime'];
		$parse['noobprot3'] 				= $game_config['noobprotectionmulti'];
		$parse['smtp_host'] 				= $game_config['smtp_host'];
		$parse['smtp_port'] 				= $game_config['smtp_port'];
		$parse['smtp_user'] 				= $game_config['smtp_user'];
		$parse['smtp_pass'] 				= $game_config['smtp_pass'];
		$parse['smtp_ssl0']					= ($game_config['smtp_ssl'] == "")	 ? "selected" : "";
		$parse['smtp_ssl1']					= ($game_config['smtp_ssl'] == "ssl")? "selected" : "";
		$parse['smtp_ssl2']					= ($game_config['smtp_ssl'] == "tls")? "selected" : "";
		$parse['user_valid']           	 	= ($game_config['user_valid'] == 1)  ? " checked = 'checked' ":"";
		#$parse['ftp_server']          		= $game_config['ftp_server'];
		#$parse['ftp_user_name']           	= $game_config['ftp_user_name'];
		#$parse['ftp_user_pass']           	= $game_config['ftp_user_pass'];
		#$parse['ftp_root_path']           	= $game_config['ftp_root_path'];
		
		$LangFolder = opendir("./../" . 'language');

		while (($LangSubFolder = readdir($LangFolder)) !== false)
		{
			if($LangSubFolder != '.' && $LangSubFolder != '..' && $LangSubFolder != '.htaccess' && $LangSubFolder != '.svn')
			{
				$parse['language_settings'] .= "<option ";

				if($game_config['lang'] == $LangSubFolder)
					$parse['language_settings'] .= "selected = selected";

				$parse['language_settings'] .= " value=\"".$LangSubFolder."\">".$LangSubFolder."</option>";
			}
		}

		return display (parsetemplate(gettemplate('adm/SettingsBody'),  $parse), false, '', true, false);
	}
}

DisplayGameSettingsPage($user);
?>