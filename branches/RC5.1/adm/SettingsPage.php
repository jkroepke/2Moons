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
$AreLog	=	$LogCanWork;

function DisplayGameSettingsPage ( $CurrentUser )
{
	global $CONF, $LNG, $AreLog;

	if ($_POST['opt_save'] == "1")
	{
		$Log	.=	"\n".$LNG['log_the_user'].$USER['username'].$LNG['log_sett_no1'].":\n";


		if (isset($_POST['closed']) && $_POST['closed'] == 'on') {
		$CONF['game_disable']         = 1;
		$CONF['close_reason']         = addslashes( $_POST['close_reason'] );
		$Log	.=	$LNG['log_sett_close'].": ".$LNG['log_viewmod2'][1]."\n";
		} else {
		$CONF['game_disable']         = 0;
		$CONF['close_reason']         = addslashes( $_POST['close_reason'] );
		$Log	.=	$LNG['log_sett_close'].": ".$LNG['log_viewmod2'][0]."\n";
		$Log	.=	$LNG['log_sett_close_rea'].": ".$_POST['close_reason']."\n";
		}

		if (isset($_POST['debug']) && $_POST['debug'] == 'on') {
		$CONF['debug'] = 1;
		$Log	.=	$LNG['log_sett_debug'].": ".$LNG['log_viewmod'][1]."\n";
		} else {
		$CONF['debug'] = 0;
		$Log	.=	$LNG['log_sett_debug'].": ".$LNG['log_viewmod'][0]."\n";
		}

		if (isset($_POST['game_name']) && $_POST['game_name'] != '') {
		$CONF['game_name'] = $_POST['game_name'];
		$Log	.=	$LNG['log_sett_name_game'].": ".$_POST['game_name']."\n";
		}

		if (isset($_POST['forum_url']) && $_POST['forum_url'] != '') {
		$CONF['forum_url'] = $_POST['forum_url'];
		$Log	.=	$LNG['log_sett_forum_url'].": ".$_POST['forum_url']."\n";
		}

		if (isset($_POST['game_speed']) && is_numeric($_POST['game_speed'])) {
		$CONF['game_speed'] = (2500 * $_POST['game_speed']);
		$Log	.=	$LNG['log_sett_velo_game'].": x".$_POST['game_speed']."\n";
		}

		if (isset($_POST['fleet_speed']) && is_numeric($_POST['fleet_speed'])) {
		$CONF['fleet_speed'] = (2500 * $_POST['fleet_speed']);
		$Log	.=	$LNG['log_sett_velo_flottes'].": x".$_POST['fleet_speed']."\n";
		}

		if (isset($_POST['resource_multiplier']) && is_numeric($_POST['resource_multiplier'])) {
		$CONF['resource_multiplier'] = $_POST['resource_multiplier'];
		$Log	.=	$LNG['log_sett_velo_prod'].": x".$_POST['resource_multiplier']."\n";
		}

		if (isset($_POST['initial_fields']) && is_numeric($_POST['initial_fields'])) {
		$CONF['initial_fields'] = $_POST['initial_fields'];
		$Log	.=	$LNG['log_sett_fields'].": ".$_POST['initial_fields']."\n";
		}

		if (isset($_POST['metal_basic_income']) && is_numeric($_POST['metal_basic_income'])) {
		$CONF['metal_basic_income'] = $_POST['metal_basic_income'];
		$Log	.=	$LNG['log_sett_basic_m'].": ".$_POST['metal_basic_income']."\n";
		}

		if (isset($_POST['crystal_basic_income']) && is_numeric($_POST['crystal_basic_income'])) {
		$CONF['crystal_basic_income'] = $_POST['crystal_basic_income'];
		$Log	.=	$LNG['log_sett_basic_c'].": ".$_POST['crystal_basic_income']."\n";
		}

		if (isset($_POST['deuterium_basic_income']) && is_numeric($_POST['deuterium_basic_income'])) {
		$CONF['deuterium_basic_income'] = $_POST['deuterium_basic_income'];
		$Log	.=	$LNG['log_sett_basic_d'].": ".$_POST['deuterium_basic_income']."\n";
		}

		if (isset($_POST['adm_attack']) && $_POST['adm_attack'] == 'on') {
			$CONF['adm_attack'] = 1;
			$Log	.=	$LNG['log_sett_adm_protection'].": ".$LNG['log_viewmod'][1]."\n";
		} else {
			$CONF['adm_attack'] = 0;
			$Log	.=	$LNG['log_sett_adm_protection'].": ".$LNG['log_viewmod'][0]."\n";
		}

		if (isset($_POST['language'])) {
			$CONF['lang'] = $_POST['language'];
			$Log	.=	$LNG['log_sett_language'].": ".$_POST['language']."\n";
		} else {
			$CONF['lang'];
		}

		if (isset($_POST['cookie_name']) && ctype_alnum($_POST['game_name'])) {
			$CONF['COOKIE_NAME'] = $_POST['cookie_name'];
			$Log	.=	$LNG['log_sett_name_cookie'].": ".$_POST['cookie_name']."\n";
		}

		if (isset($_POST['Defs_Cdr']) && is_numeric($_POST['Defs_Cdr'])) {
			if ($_POST['Defs_Cdr'] < 0){
				$CONF['Defs_Cdr'] = 0;
				$Number	=	0;}
			else{
				$CONF['Defs_Cdr'] = $_POST['Defs_Cdr'];
				$Number	=	$_POST['Defs_Cdr'];}

			$Log	.=	$LNG['log_sett_debris_def'].": ".$Number."%\n";
		}

		if (isset($_POST['Fleet_Cdr']) && is_numeric($_POST['Fleet_Cdr'])) {
			if ($_POST['Fleet_Cdr'] < 0){
				$CONF['Fleet_Cdr'] = 0;
				$Number2	=	0;}
			else{
				$CONF['Fleet_Cdr'] = $_POST['Fleet_Cdr'];
				$Number2	=	$_POST['Fleet_Cdr'];}

			$Log	.=	$LNG['log_sett_debris_flot'].": ".$Number2."%\n";
		}

		if (isset($_POST['noobprotection']) && $_POST['noobprotection'] == 'on') {
			$CONF['noobprotection'] = 1;
			$Log	.=	$LNG['log_sett_act_noobs'].": ".$LNG['log_viewmod'][1]."\n";
		} else {
			$CONF['noobprotection'] = 0;
			$Log	.=	$LNG['log_sett_act_noobs'].": ".$LNG['log_viewmod'][0]."\n";
		}

		if (isset($_POST['noobprotectiontime']) && is_numeric($_POST['noobprotectiontime'])) {
			$CONF['noobprotectiontime'] = $_POST['noobprotectiontime'];
			$Log	.=	$LNG['log_sett_noob_time'].": ".$_POST['noobprotectiontime']."\n";
		}

		if (isset($_POST['noobprotectionmulti']) && is_numeric($_POST['noobprotectionmulti'])) {
			$CONF['noobprotectionmulti'] = $_POST['noobprotectionmulti'];
			$Log	.=	$LNG['log_sett_noob_multi'].": ".$_POST['noobprotectionmulti']."\n";
		}
	
		if (isset($_POST['newsframe']) && $_POST['newsframe'] == 'on') {
			$CONF['OverviewNewsFrame']     = "1";
			$CONF['OverviewNewsText']      = $_POST['NewsText'];
        } else {
			$CONF['OverviewNewsFrame']     = "0";
			$CONF['OverviewNewsText']      = "";
        }
	
		if (isset($_POST['capaktiv']) && $_POST['capaktiv'] == 'on') {
			$CONF['capaktiv'] = 1;
		} else {
			$CONF['capaktiv'] = 0;
		}
		
		if (isset($_POST['capprivate'])) {
			$CONF['capprivate'] = $_POST['capprivate'];
		}

		if (isset($_POST['cappublic'])) {
			$CONF['cappublic'] = $_POST['cappublic'];
		}
		
		if (isset($_POST['min_build_time']) && is_numeric($_POST['min_build_time'])){
			if ($_POST['min_build_time'] < 0) {
				$CONF['min_build_time'] = 0;
			} else {
				$CONF['min_build_time'] = $_POST['min_build_time'];			
			}
		}
		
		if (isset($_POST['reg_closed']) && $_POST['reg_closed'] == 'on') {
			$CONF['reg_closed'] = 1;
		} else {
			$CONF['reg_closed'] = 0;
		}
		
		if (isset($_POST['user_valid']) && $_POST['user_valid'] == 'on') {
			$CONF['user_valid'] = 1;
		} else {
			$CONF['user_valid'] = 0;
		}
		
		if (isset($_POST['ga_active']) && $_POST['ga_active'] == 'on') {
			$CONF['ga_active'] = 1;
		} else {
			$CONF['ga_active'] = 0;
		}
		
		if (isset($_POST['ga_key'])) {
			$CONF['ga_key'] = $_POST['ga_key'];
		}
		
		if (isset($_POST['smtp_host'])) {
			$CONF['smtp_host'] = $_POST['smtp_host'];
		}
		
		if (isset($_POST['smtp_port']) && is_numeric($_POST['smtp_port'])) {
			$CONF['smtp_port'] = $_POST['smtp_port'];
		}
		
		if (isset($_POST['smtp_user'])) {
			$CONF['smtp_user'] = $_POST['smtp_user'];
		}
		
		if (isset($_POST['smtp_sendmail'])) {
			$CONF['smtp_sendmail'] = $_POST['smtp_sendmail'];
		}
		
		if (isset($_POST['smtp_pass'])) {
			$CONF['smtp_pass'] = $_POST['smtp_pass'];
		}		
		if (isset($_POST['smtp_ssl'])) {
			$CONF['smtp_ssl'] = $_POST['smtp_ssl'];
		}
		
		if (isset($_POST['ftp_server'])) {
			$CONF['ftp_server'] = $_POST['ftp_server'];
		}
		if (isset($_POST['ftp_user_name'])) {
			$CONF['ftp_user_name'] = $_POST['ftp_user_name'];
		}		
		if (isset($_POST['ftp_user_pass']) && $_POST['ftp_user_pass'] != str_pad("", strlen($CONF['ftp_user_pass']), "x")) {
			$CONF['ftp_user_pass'] = $_POST['ftp_user_pass'];
		}		
		if (isset($_POST['ftp_root_path'])) {
			$CONF['ftp_root_path'] = $_POST['ftp_root_path'];
		}	

		LogFunction($Log, "ConfigLog", $AreLog);
		var_dump($CONF['ftp_user_pass']);
		update_config('noobprotectiontime'		, $CONF['noobprotectiontime']	 );
		update_config('noobprotectionmulti'		, $CONF['noobprotectionmulti']	 );
		update_config('noobprotection'			, $CONF['noobprotection']		 );
		update_config('Defs_Cdr'				, $CONF['Defs_Cdr']				 );
		update_config('Fleet_Cdr'				, $CONF['Fleet_Cdr']              );
		update_config('game_disable'			, $CONF['game_disable']           );
		update_config('close_reason'			, $CONF['close_reason']           );
        update_config('OverviewNewsFrame'		, $CONF['OverviewNewsFrame']      );
		update_config('reg_closed'				, $CONF['reg_closed']           	 );
        update_config('OverviewNewsText'		, $CONF['OverviewNewsText']		 );
		update_config('game_name'				, $CONF['game_name']            	 );
		update_config('forum_url'				, $CONF['forum_url']              );
		update_config('game_speed'				, $CONF['game_speed']             );
		update_config('fleet_speed'				, $CONF['fleet_speed']            );
		update_config('resource_multiplier'		, $CONF['resource_multiplier']    );
		update_config('initial_fields'			, $CONF['initial_fields']         );
		update_config('metal_basic_income'		, $CONF['metal_basic_income']     );
		update_config('COOKIE_NAME'				, $CONF['COOKIE_NAME']		     );
		update_config('crystal_basic_income'	, $CONF['crystal_basic_income']   );
		update_config('deuterium_basic_income'	, $CONF['deuterium_basic_income'] );
		update_config('debug'					, $CONF['debug']                  );
		update_config('adm_attack'				, $CONF['adm_attack']             );
		update_config('lang'					, $CONF['lang']             	  	 );
		update_config('capaktiv'				, $CONF['capaktiv']               );
		update_config('capprivate'				, $CONF['capprivate']             );
		update_config('cappublic'				, $CONF['cappublic']              );
		update_config('min_build_time'			, $CONF['min_build_time']         );
		update_config('smtp_host'				, $CONF['smtp_host']              );
		update_config('smtp_port'				, $CONF['smtp_port']       	  	 );
		update_config('smtp_user'				, $CONF['smtp_user']              );
		update_config('smtp_pass'				, $CONF['smtp_pass']	             );
		update_config('smtp_ssl'				, $CONF['smtp_ssl']	             );
		update_config('smtp_sendmail'			, $CONF['smtp_sendmail']	         );
		update_config('user_valid'				, $CONF['user_valid']             );
		update_config('ftp_server'				, $CONF['ftp_server']             );
		update_config('ftp_user_name'			, $CONF['ftp_user_name']          );
		update_config('ftp_user_pass'			, $CONF['ftp_user_pass']     	 );
		update_config('ftp_root_path'			, $CONF['ftp_root_path']   		 );
		update_config('ga_active'				, $CONF['ga_active']   		  	 );
		update_config('ga_key'					, $CONF['ga_key']   				 );

		header("location:SettingsPage.php");
	}
	else
	{
		$parse								= $LNG;
		$parse['game_name']              	= $CONF['game_name'];
		$parse['game_speed']             	= ($CONF['game_speed'] / 2500);
		$parse['fleet_speed']            	= ($CONF['fleet_speed'] / 2500);
		$parse['resource_multiplier']    	= $CONF['resource_multiplier'];
		$parse['forum_url']              	= $CONF['forum_url'];
		$parse['initial_fields']         	= $CONF['initial_fields'];
		$parse['metal_basic_income']     	= $CONF['metal_basic_income'];
		$parse['crystal_basic_income']   	= $CONF['crystal_basic_income'];
		$parse['deuterium_basic_income'] 	= $CONF['deuterium_basic_income'];
		$parse['closed']                 	= ($CONF['game_disable'] == 1) ? " checked = 'checked' ":"";
		$parse['close_reason']           	= stripslashes($CONF['close_reason']);
		$parse['debug']                  	= ($CONF['debug'] == 1)        ? " checked = 'checked' ":"";
		$parse['adm_attack']             	= ($CONF['adm_attack'] == 1)   ? " checked = 'checked' ":"";
		$parse['cookie'] 					= $CONF['COOKIE_NAME'];
		$parse['defenses'] 					= $CONF['Defs_Cdr'];
		$parse['shiips'] 					= $CONF['Fleet_Cdr'];
		$parse['noobprot']            	 	= ($CONF['noobprotection'] == 1)   ? " checked = 'checked' ":"";
		$parse['noobprot2'] 				= $CONF['noobprotectiontime'];
		$parse['noobprot3'] 				= $CONF['noobprotectionmulti'];
		$parse['smtp_host'] 				= $CONF['smtp_host'];
		$parse['smtp_port'] 				= $CONF['smtp_port'];
		$parse['smtp_user'] 				= $CONF['smtp_user'];
		$parse['smtp_pass'] 				= $CONF['smtp_pass'];
		$parse['smtp_sendmail'] 			= $CONF['smtp_sendmail'];
		$parse['smtp_ssl0']					= ($CONF['smtp_ssl'] == "")	 ? "selected" : "";
		$parse['smtp_ssl1']					= ($CONF['smtp_ssl'] == "ssl")? "selected" : "";
		$parse['smtp_ssl2']					= ($CONF['smtp_ssl'] == "tls")? "selected" : "";
		$parse['user_valid']           	 	= ($CONF['user_valid'] == 1)  ? " checked = 'checked' ":"";
	    $parse['newsframe']                 = ($CONF['OverviewNewsFrame'] == 1) ? " checked = 'checked' ":"";
        $parse['reg_closed']                = ($CONF['reg_closed'] == 1) ? " checked = 'checked' ":"";
        $parse['NewsTextVal']               = $CONF['OverviewNewsText'];  
		$parse['capprivate'] 				= $CONF['capprivate'];
		$parse['cappublic']    				= $CONF['cappublic'];
		$parse['capaktiv']                 	= ($CONF['capaktiv'] == 1) ? " checked = 'checked' ":"";
		$parse['min_build_time']            = $CONF['min_build_time'];
		$parse['ftp_server']          		= $CONF['ftp_server'];
		$parse['ftp_user_name']           	= $CONF['ftp_user_name'];
		$parse['ftp_user_pass']           	= str_pad("", strlen($CONF['ftp_user_pass']), "x");
		$parse['ftp_root_path']           	= $CONF['ftp_root_path'];
        $parse['ga_active']               	= ($CONF['ga_active'] == 1) ? " checked = 'checked' ":"";
		$parse['ga_key']           			= $CONF['ga_key'];
		$LangFolder = opendir("./../" . 'language');

		while (($LangSubFolder = readdir($LangFolder)) !== false)
		{
			if($LangSubFolder != '.' && $LangSubFolder != '..' && $LangSubFolder != '.htaccess' && $LangSubFolder != '.svn')
			{
				$parse['language_settings'] .= "<option ";

				if($CONF['lang'] == $LangSubFolder)
					$parse['language_settings'] .= "selected = selected";

				$parse['language_settings'] .= " value=\"".$LangSubFolder."\">".$LangSubFolder."</option>";
			}
		}

		return display (parsetemplate(gettemplate('adm/SettingsBody'),  $parse), false, '', true, false);
	}
}

DisplayGameSettingsPage($USER);
?>