<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
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
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.0 (2012-12-31)
 * @info $Id$
 * @link http://2moons.cc/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) throw new Exception("Permission error!");

function ShowConfigUniPage()
{
	global $LNG, $USER, $LANG;
	
	$CONF	= Config::getAll(NULL, $_SESSION['adminuni']);
	
	if (!empty($_POST))
	{
		$config_before = array(
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
			'energySpeed'			=> $CONF['energySpeed'],
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
			'deuterium_cost_galaxy'	=> $CONF['deuterium_cost_galaxy'],
			'ref_active'			=> $CONF['ref_active'],
			'ref_bonus'				=> $CONF['ref_bonus'],
			'ref_minpoints'			=> $CONF['ref_minpoints'],
			'ref_max_referals'		=> $CONF['ref_max_referals'],
			'silo_factor'			=> $CONF['silo_factor'],
			'max_dm_missions'		=> $CONF['max_dm_missions'],
		);
		
		$game_disable			= isset($_POST['closed']) && $_POST['closed'] == 'on' ? 1 : 0;
		$noobprotection 		= isset($_POST['noobprotection']) && $_POST['noobprotection'] == 'on' ? 1 : 0;
		$debug 					= isset($_POST['debug']) && $_POST['debug'] == 'on' ? 1 : 0;
		$adm_attack 			= isset($_POST['adm_attack']) && $_POST['adm_attack'] == 'on' ? 1 : 0;		
		$OverviewNewsFrame  	= isset($_POST['newsframe']) && $_POST['newsframe'] == 'on' ? 1 : 0;
		$reg_closed 			= isset($_POST['reg_closed']) && $_POST['reg_closed'] == 'on' ? 1 : 0;
		$user_valid				= isset($_POST['user_valid']) && $_POST['user_valid'] == 'on' ? 1 : 0;
		$debris_moon			= isset($_POST['debris_moon']) && $_POST['debris_moon'] == 'on' ? 1 : 0;
		$ref_active				= isset($_POST['ref_active']) && $_POST['ref_active'] == 'on' ? 1 : 0;
		
		$OverviewNewsText		= $_POST['NewsText'];
		$close_reason			= HTTP::_GP('close_reason', '', true);
		$uni_name				= HTTP::_GP('uni_name', '', true);
		$forum_url 				= HTTP::_GP('forum_url', '', true);
		$game_speed 			= (2500 * HTTP::_GP('game_speed', 0.0));
		$fleet_speed 			= (2500 * HTTP::_GP('fleet_speed', 0.0));
		$resource_multiplier	= HTTP::_GP('resource_multiplier', 0.0);
		$halt_speed				= HTTP::_GP('halt_speed', 0.0);
		$energySpeed			= HTTP::_GP('energySpeed', 0.0);
		$initial_fields			= HTTP::_GP('initial_fields', 0);
		$metal_basic_income		= HTTP::_GP('metal_basic_income', 0);
		$crystal_basic_income	= HTTP::_GP('crystal_basic_income', 0);
		$deuterium_basic_income	= HTTP::_GP('deuterium_basic_income', 0);
		$lang					= HTTP::_GP('lang', '');
		$Defs_Cdr				= HTTP::_GP('Defs_Cdr', 0);
		$Fleet_Cdr				= HTTP::_GP('Fleet_Cdr', 0);
		$noobprotectiontime		= HTTP::_GP('noobprotectiontime', 0);
		$noobprotectionmulti	= HTTP::_GP('noobprotectionmulti', 0);
		$min_build_time			= HTTP::_GP('min_build_time', 0);
		$trade_allowed_ships	= HTTP::_GP('trade_allowed_ships', '');
		$trade_charge			= HTTP::_GP('trade_charge', 0.0);
		$max_galaxy				= HTTP::_GP('max_galaxy', 0);
		$max_system				= HTTP::_GP('max_system', 0);
		$max_planets			= HTTP::_GP('max_planets', 0);
		$min_player_planets		= HTTP::_GP('min_player_planets', 0);
		$max_player_planets		= HTTP::_GP('max_player_planets', 0);
		$planet_factor			= HTTP::_GP('planet_factor', 0.0);
		$max_elements_build		= HTTP::_GP('max_elements_build', 0);
		$max_elements_tech		= HTTP::_GP('max_elements_tech', 0);
		$max_elements_ships		= HTTP::_GP('max_elements_ships', 0);
		$max_overflow			= HTTP::_GP('max_overflow', 0);
		$moon_factor			= HTTP::_GP('moon_factor', 0.0);
		$moon_chance			= HTTP::_GP('moon_chance', 0);
		$darkmatter_cost_trader	= HTTP::_GP('darkmatter_cost_trader', 0);
		$factor_university		= HTTP::_GP('factor_university', 0);
		$max_fleets_per_acs		= HTTP::_GP('max_fleets_per_acs', 0);
		$vmode_min_time			= HTTP::_GP('vmode_min_time', 0);
		$gate_wait_time			= HTTP::_GP('gate_wait_time', 0);
		$metal_start			= HTTP::_GP('metal_start', 0);
		$crystal_start			= HTTP::_GP('crystal_start', 0);
		$deuterium_start		= HTTP::_GP('deuterium_start', 0);
		$darkmatter_start		= HTTP::_GP('darkmatter_start', 0);
		$deuterium_cost_galaxy	= HTTP::_GP('deuterium_cost_galaxy', 0);
		$max_fleet_per_build	= max(0, round(HTTP::_GP('max_fleet_per_build', 0.0)));
		$ref_bonus				= HTTP::_GP('ref_bonus', 0);
		$ref_minpoints			= HTTP::_GP('ref_minpoints', 0);
		$silo_factor			= HTTP::_GP('silo_factor', 0);
		$ref_max_referals		= HTTP::_GP('ref_max_referals', 0);
		$max_dm_missions		= HTTP::_GP('max_dm_missions', 1);
			
		$config_after = array(
			'noobprotectiontime'	=> $noobprotectiontime,
			'noobprotectionmulti'	=> $noobprotectionmulti,
			'noobprotection'		=> $noobprotection,
			'Defs_Cdr'				=> $Defs_Cdr,
			'Fleet_Cdr'				=> $Fleet_Cdr,
			'game_disable'			=> $game_disable,
			'close_reason'			=> $close_reason,
			'OverviewNewsFrame'		=> $OverviewNewsFrame,
			'reg_closed'			=> $reg_closed,
			'OverviewNewsText'		=> $OverviewNewsText,
			'uni_name'				=> $uni_name,
			'forum_url'				=> $forum_url,
			'game_speed'			=> $game_speed,
			'fleet_speed'			=> $fleet_speed,
			'resource_multiplier'	=> $resource_multiplier,
			'halt_speed'			=> $halt_speed,
			'energySpeed'			=> $energySpeed,
			'initial_fields'		=> $initial_fields,
			'metal_basic_income'	=> $metal_basic_income,
			'crystal_basic_income'	=> $crystal_basic_income,
			'deuterium_basic_income'=> $deuterium_basic_income,
			'debug'					=> $debug,
			'adm_attack'			=> $adm_attack,
			'lang'					=> $lang,
			'min_build_time'		=> $min_build_time,
			'user_valid'			=> $user_valid,
			'trade_charge'			=> $trade_charge,
			'trade_allowed_ships'	=> $trade_allowed_ships,
			'max_galaxy'			=> $max_galaxy,
			'max_system'			=> $max_system,
			'max_planets'			=> $max_planets,
			'min_player_planets'	=> $min_player_planets,
			'max_player_planets'	=> $max_player_planets,
			'planet_factor'			=> $planet_factor,
			'max_elements_build'	=> $max_elements_build,
			'max_elements_tech'		=> $max_elements_tech,
			'max_elements_ships'	=> $max_elements_ships,
			'max_overflow'			=> $max_overflow,
			'moon_factor'			=> $moon_factor,
			'moon_chance'			=> $moon_chance,
			'darkmatter_cost_trader'=> $darkmatter_cost_trader,
			'factor_university'		=> $factor_university,
			'max_fleets_per_acs'	=> $max_fleets_per_acs,
			'vmode_min_time'		=> $vmode_min_time,
			'gate_wait_time'		=> $gate_wait_time,
			'metal_start'			=> $metal_start,
			'crystal_start'			=> $crystal_start,
			'deuterium_start'		=> $deuterium_start,
			'darkmatter_start'		=> $darkmatter_start,
			'debris_moon'			=> $debris_moon,
			'deuterium_cost_galaxy'	=> $deuterium_cost_galaxy,
			'ref_active'			=> $ref_active,
			'ref_bonus'				=> $ref_bonus,
			'ref_minpoints'			=> $ref_minpoints,
			'ref_max_referals'		=> $ref_max_referals,
			'silo_factor'			=> $silo_factor,
			'max_dm_missions'		=> $max_dm_missions,
		);
		
		Config::update($config_after, $_SESSION['adminuni']);
		$CONF	= Config::getAll(NULL, $_SESSION['adminuni']);
		
		$LOG = new Log(3);
		$LOG->target = 1;
		$LOG->old = $config_before;
		$LOG->new = $config_after;
		$LOG->save();

		if($CONF['adm_attack'] == 0)
			$GLOBALS['DATABASE']->query("UPDATE ".USERS." SET `authattack` = '0' WHERE `universe` = '".$_SESSION['adminuni']."';");
	}
	
	$template	= new template();
	$template->loadscript('../base/jquery.autosize-min.js');
	$template->execscript('$(\'textarea\').autosize();');

	$template->assign_vars(array(
		'se_server_parameters'			=> $LNG['se_server_parameters'],
		'se_game_name'					=> $LNG['se_game_name'],
		'se_uni_name'					=> $LNG['se_uni_name'],
		'se_cookie_advert'				=> $LNG['se_cookie_advert'],
		'se_lang'						=> $LNG['se_lang'],
		'se_general_speed'				=> $LNG['se_general_speed'],
		'se_fleet_speed'				=> $LNG['se_fleet_speed'],
		'se_energy_speed'				=> $LNG['se_energy_speed'],
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
		'Deuterium'						=> $LNG['tech'][903],
		'Darkmatter'					=> $LNG['tech'][921],
		'se_ref'						=> $LNG['se_ref'],
		'se_ref_active'					=> $LNG['se_ref_active'],
		'se_ref_active_info'			=> $LNG['se_ref_active_info'],
		'se_ref_max_referals'			=> $LNG['se_ref_max_referals'],
		'se_ref_max_referals_info'		=> $LNG['se_ref_max_referals_info'],
		'se_ref_bonus'					=> $LNG['se_ref_bonus'],
		'se_ref_bonus_info'				=> $LNG['se_ref_bonus_info'],
		'se_ref_minpoints'				=> $LNG['se_ref_minpoints'],
		'se_ref_minpoints_info'			=> $LNG['se_ref_minpoints_info'],
		'se_silo_factor'				=> $LNG['se_silo_factor'],
		'se_silo_factor_info'			=> $LNG['se_silo_factor_info'],
		'se_max_dm_missions'			=> $LNG['se_max_dm_missions'],
		'game_name'						=> $CONF['game_name'],
		'uni_name'						=> $CONF['uni_name'],
		'game_speed'					=> ($CONF['game_speed'] / 2500),
		'fleet_speed'					=> ($CONF['fleet_speed'] / 2500),
		'resource_multiplier'			=> $CONF['resource_multiplier'],
		'halt_speed'					=> $CONF['halt_speed'],
		'energySpeed'					=> $CONF['energySpeed'],
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
		'trade_allowed_ships'        	=> $CONF['trade_allowed_ships'],
		'trade_charge'		        	=> $CONF['trade_charge'],
		'Selector'						=> array(
			'langs' => $LANG->getAllowedLangs(false), 
			'mail' => $LNG['se_mail_sel'], 
			'encry' => array('' => $LNG['se_smtp_ssl_1'], 'ssl' => $LNG['se_smtp_ssl_2'], 'tls' => $LNG['se_smtp_ssl_3'])
		),
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
		'deuterium_cost_galaxy'			=> $CONF['deuterium_cost_galaxy'],
		'ref_active'					=> $CONF['ref_active'],
		'ref_bonus'						=> $CONF['ref_bonus'],
		'ref_minpoints'					=> $CONF['ref_minpoints'],
		'ref_max_referals'				=> $CONF['ref_max_referals'],
		'silo_factor'					=> $CONF['silo_factor'],
		'max_dm_missions'				=> $CONF['max_dm_missions'],
	));
	
	$template->show('ConfigBodyUni.tpl');
}

?>