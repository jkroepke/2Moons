<?php

/**
 *  2Moons
 *  Copyright (C) 2011  Slaver
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
 * @author Slaver <slaver7@gmail.com>
 * @copyright 2009 Lucky <lucky@xgproyect.net> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.3 (2011-01-21)
 * @link http://code.google.com/p/2moons/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) exit;

function ShowConfigUniPage()
{
	global $CONF, $LNG, $USER, $LANG, $db;
	if (!empty($_POST))
	{
		$CONF['game_disable']			= isset($_POST['closed']) && $_POST['closed'] == 'on' ? 1 : 0;
		$CONF['noobprotection'] 		= isset($_POST['noobprotection']) && $_POST['noobprotection'] == 'on' ? 1 : 0;
		$CONF['debug'] 					= isset($_POST['debug']) && $_POST['debug'] == 'on' ? 1 : 0;
		$CONF['adm_attack'] 			= isset($_POST['adm_attack']) && $_POST['adm_attack'] == 'on' ? 1 : 0;		
		$CONF['OverviewNewsFrame']  	= isset($_POST['newsframe']) && $_POST['newsframe'] == 'on' ? 1 : 0;
		$CONF['reg_closed'] 			= isset($_POST['reg_closed']) && $_POST['reg_closed'] == 'on' ? 1 : 0;
		$CONF['user_valid']				= isset($_POST['user_valid']) && $_POST['user_valid'] == 'on' ? 1 : 0;
		$CONF['debris_moon']			= isset($_POST['debris_moon']) && $_POST['debris_moon'] == 'on' ? 1 : 0;
		
		$CONF['OverviewNewsText']		= $_POST['NewsText'];
		$CONF['close_reason']			= request_var('close_reason', '', true);
		$CONF['uni_name']				= request_var('uni_name', '', true);
		$CONF['forum_url'] 				= request_var('forum_url', '', true);
		$CONF['game_speed'] 			= (2500 * request_var('game_speed', 0.0));
		$CONF['fleet_speed'] 			= (2500 * request_var('fleet_speed', 0.0));
		$CONF['resource_multiplier']	= request_var('resource_multiplier', 0.0);
		$CONF['halt_speed']				= request_var('halt_speed', 0.0);
		$CONF['initial_fields']			= request_var('initial_fields', 0);
		$CONF['metal_basic_income']		= request_var('metal_basic_income', 0);
		$CONF['crystal_basic_income']	= request_var('crystal_basic_income', 0);
		$CONF['deuterium_basic_income']	= request_var('deuterium_basic_income', 0);
		$CONF['lang']					= request_var('lang', '');
		$CONF['Defs_Cdr']				= request_var('Defs_Cdr', 0);
		$CONF['Fleet_Cdr']				= request_var('Fleet_Cdr', 0);
		$CONF['noobprotectiontime']		= request_var('noobprotectiontime', 0);
		$CONF['noobprotectionmulti']	= request_var('noobprotectionmulti', 0);
		$CONF['min_build_time']			= request_var('min_build_time', 0);
		$CONF['trade_allowed_ships']	= request_var('trade_allowed_ships', '');
		$CONF['trade_charge']			= request_var('trade_charge', 0.0);
		$CONF['max_galaxy']				= request_var('max_galaxy', 0);
		$CONF['max_system']				= request_var('max_system', 0);
		$CONF['max_planets']			= request_var('max_planets', 0);
		$CONF['min_player_planets']		= request_var('min_player_planets', 0);
		$CONF['max_player_planets']		= request_var('max_player_planets', 0);
		$CONF['planet_factor']			= request_var('planet_factor', 0.0);
		$CONF['max_elements_build']		= request_var('max_elements_build', 0);
		$CONF['max_elements_tech']		= request_var('max_elements_tech', 0);
		$CONF['max_elements_ships']		= request_var('max_elements_ships', 0);
		$CONF['max_overflow']			= request_var('max_overflow', 0);
		$CONF['moon_factor']			= request_var('moon_factor', 0.0);
		$CONF['moon_chance']			= request_var('moon_chance', 0.0);
		$CONF['darkmatter_cost_trader']	= request_var('darkmatter_cost_trader', 0);
		$CONF['factor_university']		= request_var('factor_university', 0);
		$CONF['max_fleets_per_acs']		= request_var('max_fleets_per_acs', 0);
		$CONF['vmode_min_time']			= request_var('vmode_min_time', 0);
		$CONF['gate_wait_time']			= request_var('gate_wait_time', 0);
		$CONF['metal_start']			= request_var('metal_start', 0);
		$CONF['crystal_start']			= request_var('crystal_start', 0);
		$CONF['deuterium_start']		= request_var('deuterium_start', 0);
		$CONF['darkmatter_start']		= request_var('darkmatter_start', 0);
		$CONF['deuterium_cost_galaxy']	= request_var('deuterium_cost_galaxy', 0);
		$CONF['max_fleet_per_build']	= request_outofint('max_fleet_per_build');
		
		update_config(array(
			'noobprotectiontime'	=> $CONF['noobprotectiontime'],
			'noobprotectionmulti'	=> $CONF['noobprotectionmulti'],
			'noobprotection'		=> $CONF['noobprotection'],
			'Defs_Cdr'				=> $CONF['Defs_Cdr'],
			'Fleet_Cdr'				=> $CONF['Fleet_Cdr'],
			'game_disable'			=> $CONF['game_disable'],
			'close_reason'			=> $CONF['close_reason'],
			'OverviewNewsFrame'		=> $CONF['OverviewNewsFrame'],
			'reg_closed'			=> $CONF['reg_closed'],
			'OverviewNewsText'		=> $CONF['OverviewNewsText'],
			'uni_name'				=> $CONF['uni_name'],
			'forum_url'				=> $CONF['forum_url'],
			'game_speed'			=> $CONF['game_speed'],
			'fleet_speed'			=> $CONF['fleet_speed'],
			'resource_multiplier'	=> $CONF['resource_multiplier'],
			'halt_speed'			=> $CONF['halt_speed'],
			'initial_fields'		=> $CONF['initial_fields'],
			'metal_basic_income'	=> $CONF['metal_basic_income'],
			'crystal_basic_income'	=> $CONF['crystal_basic_income'],
			'deuterium_basic_income'=> $CONF['deuterium_basic_income'],
			'debug'					=> $CONF['debug'],
			'adm_attack'			=> $CONF['adm_attack'],
			'lang'					=> $CONF['lang'],
			'min_build_time'		=> $CONF['min_build_time'],
			'user_valid'			=> $CONF['user_valid'],
			'trade_charge'			=> $CONF['trade_charge'],
			'trade_allowed_ships'	=> $CONF['trade_allowed_ships'],
			'game_name'				=> $CONF['game_name'],
			'mail_active'			=> $CONF['mail_active'],
			'mail_use'				=> $CONF['mail_use'],
			'smail_path'			=> $CONF['smail_path'],
			'smtp_host'				=> $CONF['smtp_host'],
			'smtp_port'				=> $CONF['smtp_port'],
			'smtp_user'				=> $CONF['smtp_user'],
			'smtp_pass'				=> $CONF['smtp_pass'],
			'smtp_ssl'				=> $CONF['smtp_ssl'],
			'smtp_sendmail'			=> $CONF['smtp_sendmail'],
			'ga_active'				=> $CONF['ga_active'],
			'ga_key'				=> $CONF['ga_key'],
			'capaktiv'				=> $CONF['capaktiv'],
			'capprivate'			=> $CONF['capprivate'],
			'cappublic'				=> $CONF['cappublic'],
			'max_galaxy'			=> $CONF['max_galaxy'],
			'max_system'			=> $CONF['max_system'],
			'max_planets'			=> $CONF['max_planets'],
			'min_player_planets'	=> $CONF['min_player_planets'],
			'max_player_planets'	=> $CONF['max_player_planets'],
			'planet_factor'			=> $CONF['planet_factor'],
			'max_elements_build'	=> $CONF['max_elements_build'],
			'max_elements_tech'		=> $CONF['max_elements_tech'],
			'max_elements_ships'	=> $CONF['max_elements_ships'],
			'max_overflow'			=> $CONF['max_overflow'],
			'moon_factor'			=> $CONF['moon_factor'],
			'moon_chance'			=> $CONF['moon_chance'],
			'darkmatter_cost_trader'=> $CONF['darkmatter_cost_trader'],
			'factor_university'		=> $CONF['factor_university'],
			'max_fleets_per_acs'	=> $CONF['max_fleets_per_acs'],
			'vmode_min_time'		=> $CONF['vmode_min_time'],
			'gate_wait_time'		=> $CONF['gate_wait_time'],
			'metal_start'			=> $CONF['metal_start'],
			'crystal_start'			=> $CONF['crystal_start'],
			'deuterium_start'		=> $CONF['deuterium_start'],
			'darkmatter_start'		=> $CONF['darkmatter_start'],
			'debris_moon'			=> $CONF['debris_moon'],
			'deuterium_cost_galaxy'	=> $CONF['deuterium_cost_galaxy']
		));
		
		if($CONF['adm_attack'] == 0)
			$db->query("UPDATE ".USERS." SET `authattack` = '0' WHERE `uni` = '".$_SESSION['adminuni']."");
	}
	
	$template	= new template();

	$template->assign_vars(array(
		'se_server_parameters'			=> $LNG['se_server_parameters'],
		'se_game_name'					=> $LNG['se_game_name'],
		'se_uni_name'					=> $LNG['se_uni_name'],
		'se_cookie_advert'				=> $LNG['se_cookie_advert'],
		'se_lang'						=> $LNG['se_lang'],
		'se_general_speed'				=> $LNG['se_general_speed'],
		'se_fleet_speed'				=> $LNG['se_fleet_speed'],
		'se_halt_speed'					=> $LNG['se_halt_speed'],
		'se_normal_speed'				=> $LNG['se_normal_speed'],
		'se_normal_speed_fleet'			=> $LNG['se_normal_speed_fleet'],
		'se_resources_producion_speed'	=> $LNG['se_resources_producion_speed'],
		'se_normal_speed_resoruces'		=> $LNG['se_normal_speed_resoruces'],
		'se_normal_speed_halt'			=> $LNG['se_normal_speed_halt'],
		'se_forum_link'					=> $LNG['se_forum_link'	],
		'se_server_op_close'			=> $LNG['se_server_op_close'],
		'se_server_status_message'		=> $LNG['se_server_status_message'],
		'se_server_planet_parameters'	=> $LNG['se_server_planet_parameters'],
		'se_initial_fields'				=> $LNG['se_initial_fields'],
		'se_metal_production'			=> $LNG['se_metal_production'],
		'se_admin_protection'			=> $LNG['se_admin_protection'],
		'se_crystal_production'			=> $LNG['se_crystal_production'],
		'se_deuterium_production'		=> $LNG['se_deuterium_production'],
		'se_several_parameters'			=> $LNG['se_several_parameters'],
		'se_min_build_time'				=> $LNG['se_min_build_time'],
		'se_reg_closed'					=> $LNG['se_reg_closed'],
		'se_verfiy_mail'				=> $LNG['se_verfiy_mail'],
		'se_min_build_time_info'		=> $LNG['se_min_build_time_info'],
		'se_verfiy_mail_info'			=> $LNG['se_verfiy_mail_info'],
		'se_fields'						=> $LNG['se_fields'],
		'se_per_hour'					=> $LNG['se_per_hour'],
		'se_debug_mode'					=> $LNG['se_debug_mode'],
		'se_title_admins_protection'	=> $LNG['se_title_admins_protection'],
		'se_debug_message'				=> $LNG['se_debug_message'],
		'se_ships_cdr_message'			=> $LNG['se_ships_cdr_message'],
		'se_def_cdr_message'			=> $LNG['se_def_cdr_message'],
		'se_ships_cdr'					=> $LNG['se_ships_cdr'],
		'se_def_cdr'					=> $LNG['se_def_cdr'],
		'se_noob_protect'				=> $LNG['se_noob_protect'],
		'se_noob_protect3'				=> $LNG['se_noob_protect3'],
		'se_noob_protect2'				=> $LNG['se_noob_protect2'],
		'se_noob_protect_e2'			=> $LNG['se_noob_protect_e2'],
		'se_noob_protect_e3'			=> $LNG['se_noob_protect_e3'],
		'se_trader_head'				=> $LNG['se_trader_head'],
		'se_trader_ships'				=> $LNG['se_trader_ships'],
		'se_trader_charge'				=> $LNG['se_trader_charge'],
		'se_news_head'					=> $LNG['se_news_head'],
		'se_news_active'				=> $LNG['se_news_active'],
		'se_news_info'					=> $LNG['se_news_info'],
		'se_news'						=> $LNG['se_news'],
		'se_news_limit'					=> $LNG['se_news_limit'],
		'se_recaptcha_head'				=> $LNG['se_recaptcha_head'],
		'se_recaptcha_active'			=> $LNG['se_recaptcha_active'],
		'se_recaptcha_desc'				=> $LNG['se_recaptcha_desc'],
		'se_recaptcha_public'			=> $LNG['se_recaptcha_public'],
		'se_recaptcha_private'			=> $LNG['se_recaptcha_private'],
		'se_smtp'						=> $LNG['se_smtp'],
		'se_mail_active'				=> $LNG['se_mail_active'],
		'se_mail_use'					=> $LNG['se_mail_use'],
		'se_smail_path'					=> $LNG['se_smail_path'],
		'se_smtp_info'					=> $LNG['se_smtp_info'],
		'se_smtp_host'					=> $LNG['se_smtp_host'],
		'se_smtp_host_info'				=> $LNG['se_smtp_host_info'],
		'se_smtp_ssl'					=> $LNG['se_smtp_ssl'],
		'se_smtp_ssl_info'				=> $LNG['se_smtp_ssl_info'],
		'se_smtp_port'					=> $LNG['se_smtp_port'],
		'se_smtp_port_info'				=> $LNG['se_smtp_port_info'],
		'se_smtp_user'					=> $LNG['se_smtp_user'],
		'se_smtp_pass'					=> $LNG['se_smtp_pass'],
		'se_smtp_sendmail'				=> $LNG['se_smtp_sendmail'],
		'se_smtp_sendmail_info'			=> $LNG['se_smtp_sendmail_info'],
		'se_google'						=> $LNG['se_google'],
		'se_google_active'				=> $LNG['se_google_active'],
		'se_google_info'				=> $LNG['se_google_info'],
		'se_google_key'					=> $LNG['se_google_key'],
		'se_google_key_info'			=> $LNG['se_google_key_info'],
		'se_google_key_info'			=> $LNG['se_google_key_info'],
		'se_save_parameters'			=> $LNG['se_save_parameters'],
		'se_max_galaxy'					=> $LNG['se_max_galaxy'],
		'se_max_galaxy_info'			=> $LNG['se_max_galaxy_info'],
		'se_max_system'					=> $LNG['se_max_system'],
		'se_max_system_info'			=> $LNG['se_max_system_info'],
		'se_max_planets'				=> $LNG['se_max_planets'],
		'se_max_planets_info'			=> $LNG['se_max_planets_info'],
		'se_min_player_planets'			=> $LNG['se_min_player_planets'],
		'se_max_player_planets_info'	=> $LNG['se_max_player_planets_info'],
		'se_max_player_planets'			=> $LNG['se_max_player_planets'],
		'se_min_player_planets_info'	=> $LNG['se_min_player_planets_info'],
		'se_planet_factor'				=> $LNG['se_planet_factor'],
		'se_planet_factor_info'			=> $LNG['se_planet_factor_info'],
		'se_max_elements_build'			=> $LNG['se_max_elements_build'],
		'se_max_elements_build_info'	=> $LNG['se_max_elements_build_info'],
		'se_max_elements_tech'			=> $LNG['se_max_elements_tech'],
		'se_max_elements_tech_info'		=> $LNG['se_max_elements_tech_info'],
		'se_max_elements_ships'			=> $LNG['se_max_elements_ships'],
		'se_max_elements_ships_info'	=> $LNG['se_max_elements_ships_info'],
		'se_max_fleet_per_build'		=> $LNG['se_max_fleet_per_build'],
		'se_max_fleet_per_build_info'	=> $LNG['se_max_fleet_per_build_info'],
		'se_max_overflow'				=> $LNG['se_max_overflow'],
		'se_max_overflow_info'			=> $LNG['se_max_overflow_info'],
		'se_moon_factor'				=> $LNG['se_moon_factor'],
		'se_moon_factor_info'			=> $LNG['se_moon_factor_info'],
		'se_moon_chance'				=> $LNG['se_moon_chance'],
		'se_moon_chance_info'			=> $LNG['se_moon_chance_info'],
		'se_darkmatter_cost_trader'		=> $LNG['se_darkmatter_cost_trader'],
		'se_darkmatter_cost_trader_info'=> $LNG['se_darkmatter_cost_trader_info'],
		'se_factor_university'			=> $LNG['se_factor_university'],
		'se_factor_university_info'		=> $LNG['se_factor_university_info'],
		'se_max_fleets_per_acs'			=> $LNG['se_max_fleets_per_acs'],
		'se_max_fleets_per_acs_info'	=> $LNG['se_max_fleets_per_acs_info'],
		'se_vmode_min_time'				=> $LNG['se_vmode_min_time'],
		'se_vmode_min_time_info'		=> $LNG['se_vmode_min_time_info'],
		'se_gate_wait_time'				=> $LNG['se_gate_wait_time'],
		'se_gate_wait_time_info'		=> $LNG['se_gate_wait_time_info'],
		'se_metal_start'				=> $LNG['se_metal_start'],
		'se_metal_start_info'			=> $LNG['se_metal_start_info'],
		'se_crystal_start'				=> $LNG['se_crystal_start'],
		'se_crystal_start_info'			=> $LNG['se_crystal_start_info'],
		'se_deuterium_start'			=> $LNG['se_deuterium_start'],
		'se_deuterium_start_info'		=> $LNG['se_deuterium_start_info'],
		'se_darkmatter_start'			=> $LNG['se_darkmatter_start'],
		'se_darkmatter_start_info'		=> $LNG['se_darkmatter_start_info'],
		'se_debris_moon'				=> $LNG['se_debris_moon'],
		'se_debris_moon_info'			=> $LNG['se_debris_moon_info'],
		'se_deuterium_cost_galaxy'		=> $LNG['se_deuterium_cost_galaxy'],
		'se_deuterium_cost_galaxy_info'	=> $LNG['se_deuterium_cost_galaxy_info'],
		'se_buildlist'					=> $LNG['se_buildlist'],
		'Deuterium'						=> $LNG['Deuterium'],
		'Darkmatter'					=> $LNG['Darkmatter'],
		'game_name'						=> $CONF['game_name'],
		'uni_name'						=> $CONF['uni_name'],
		'game_speed'					=> ($CONF['game_speed'] / 2500),
		'fleet_speed'					=> ($CONF['fleet_speed'] / 2500),
		'resource_multiplier'			=> $CONF['resource_multiplier'],
		'halt_speed'					=> $CONF['halt_speed'],
		'forum_url'						=> $CONF['forum_url'],
		'initial_fields'				=> $CONF['initial_fields'],
		'metal_basic_income'			=> $CONF['metal_basic_income'],
		'crystal_basic_income'			=> $CONF['crystal_basic_income'],
		'deuterium_basic_income'		=> $CONF['deuterium_basic_income'],
		'game_disable'					=> $CONF['game_disable'],
		'close_reason'					=> $CONF['close_reason'],
		'debug'							=> $CONF['debug'],
		'adm_attack'					=> $CONF['adm_attack'],
		'defenses'						=> $CONF['Defs_Cdr'],
		'shiips'						=> $CONF['Fleet_Cdr'],
		'noobprot'						=> $CONF['noobprotection'],
		'noobprot2'						=> $CONF['noobprotectiontime'],
		'noobprot3'						=> $CONF['noobprotectionmulti'],
		'mail_active'					=> $CONF['mail_active'],
		'mail_use'						=> $CONF['mail_use'],
		'smail_path'					=> $CONF['smail_path'],
		'smtp_host' 					=> $CONF['smtp_host'],
		'smtp_port' 					=> $CONF['smtp_port'],
		'smtp_user' 					=> $CONF['smtp_user'],
		'smtp_pass' 					=> $CONF['smtp_pass'],
		'smtp_sendmail' 				=> $CONF['smtp_sendmail'],
		'smtp_ssl'						=> $CONF['smtp_ssl'],
		'user_valid'           	 		=> $CONF['user_valid'],
	    'newsframe'                 	=> $CONF['OverviewNewsFrame'],
        'reg_closed'                	=> $CONF['reg_closed'],
        'NewsTextVal'               	=> $CONF['OverviewNewsText'],  
		'capprivate' 					=> $CONF['capprivate'],
		'cappublic' 	   				=> $CONF['cappublic'],
		'capaktiv'      	           	=> $CONF['capaktiv'],
		'min_build_time'    	        => $CONF['min_build_time'],
        'ga_active'               		=> $CONF['ga_active'],
		'ga_key'           				=> $CONF['ga_key'],
        'bgm_active'               		=> $CONF['bgm_active'],
		'bgm_file'           			=> $CONF['bgm_file'],
		'trade_allowed_ships'        	=> $CONF['trade_allowed_ships'],
		'trade_charge'		        	=> $CONF['trade_charge'],
		'Selector'						=> array('langs' => $LANG->getAllowedLangs(false), 'mail' => $LNG['se_mail_sel'], 'encry' => array('' => $LNG['se_smtp_ssl_1'], 'ssl' => $LNG['se_smtp_ssl_2'], 'tls' => $LNG['se_smtp_ssl_3'])),
		'lang'							=> $CONF['lang'],
		'max_galaxy'					=> $CONF['max_galaxy'],
		'max_system'					=> $CONF['max_system'],
		'max_planets'					=> $CONF['max_planets'],
		'min_player_planets'			=> $CONF['min_player_planets'],
		'max_player_planets'			=> $CONF['max_player_planets'],
		'planet_factor'					=> $CONF['planet_factor'],
		'max_elements_build'			=> $CONF['max_elements_build'],
		'max_elements_tech'				=> $CONF['max_elements_tech'],
		'max_elements_ships'			=> $CONF['max_elements_ships'],
		'max_fleet_per_build'			=> $CONF['max_fleet_per_build'],
		'max_overflow'					=> $CONF['max_overflow'],
		'moon_factor'					=> $CONF['moon_factor'],
		'moon_chance'					=> $CONF['moon_chance'],
		'darkmatter_cost_trader'		=> $CONF['darkmatter_cost_trader'],
		'factor_university'				=> $CONF['factor_university'],
		'max_fleets_per_acs'			=> $CONF['max_fleets_per_acs'],
		'vmode_min_time'				=> $CONF['vmode_min_time'],
		'gate_wait_time'				=> $CONF['gate_wait_time'],
		'metal_start'					=> $CONF['metal_start'],
		'crystal_start'					=> $CONF['crystal_start'],
		'deuterium_start'				=> $CONF['deuterium_start'],
		'darkmatter_start'				=> $CONF['darkmatter_start'],
		'debris_moon'					=> $CONF['debris_moon'],
		'deuterium_cost_galaxy'			=> $CONF['deuterium_cost_galaxy']
	));
	
	$template->show('adm/ConfigBodyUni.tpl');
}

?>