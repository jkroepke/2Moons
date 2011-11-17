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
 * @version 1.4 (2011-07-10)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

define('INSIDE', true );
define('INSTALL', false );
define('LOGIN', true );
define('ROOT_PATH', './');
require_once(ROOT_PATH . 'includes/config.php');
require_once(ROOT_PATH . 'includes/constants.php');
require_once(ROOT_PATH . 'includes/classes/class.MySQLi.php');
$db = new DB_MySQLi();
$CONF = $db->uniquequery("SELECT HIGH_PRIORITY * FROM `".CONFIG."`;");
$db->query("DROP TABLE ".CONFIG.";");
$db->query("CREATE TABLE `".CONFIG."` (
 `uni` int(11) NOT NULL,
 `VERSION` varchar(8) NOT NULL,
 `users_amount` int(11) NOT NULL,
 `game_speed` int(11) NOT NULL,
 `fleet_speed` int(11) NOT NULL,
 `resource_multiplier` int(11) NOT NULL,
 `halt_speed` int(11) NOT NULL,
 `Fleet_Cdr` int(11) NOT NULL,
 `Defs_Cdr` int(11) NOT NULL,
 `initial_fields` int(11) NOT NULL,
 `bgm_active` int(11) NOT NULL,
 `bgm_file` varchar(100) NOT NULL,
 `game_name` varchar(30) NOT NULL,
 `game_disable` int(11) NOT NULL,
 `close_reason` text NOT NULL,
 `metal_basic_income` int(11) NOT NULL,
 `crystal_basic_income` int(11) NOT NULL,
 `deuterium_basic_income` int(11) NOT NULL,
 `energy_basic_income` int(11) NOT NULL,
 `LastSettedGalaxyPos` int(11) NOT NULL,
 `LastSettedSystemPos` int(11) NOT NULL,
 `LastSettedPlanetPos` int(11) NOT NULL,
 `noobprotection` int(11) NOT NULL,
 `noobprotectiontime` int(11) NOT NULL,
 `noobprotectionmulti` int(11) NOT NULL,
 `forum_url` varchar(40) NOT NULL,
 `adm_attack` int(11) NOT NULL,
 `debug` int(11) NOT NULL,
 `lang` varchar(10) NOT NULL,
 `stat` int(11) NOT NULL,
 `stat_level` int(11) NOT NULL,
 `stat_last_update` int(11) NOT NULL,
 `stat_settings` int(11) NOT NULL,
 `stat_update_time` int(11) NOT NULL,
 `stat_last_db_update` int(11) NOT NULL,
 `stats_fly_lock` int(11) NOT NULL,
 `stat_last_banner_update` int(11) NOT NULL,
 `stat_banner_update_time` int(11) NOT NULL,
 `cron_lock` int(11) NOT NULL,
 `ts_modon` int(11) NOT NULL,
 `ts_server` int(11) NOT NULL,
 `ts_tcpport` int(11) NOT NULL,
 `ts_udpport` int(11) NOT NULL,
 `ts_timeout` int(11) NOT NULL,
 `ts_version` int(11) NOT NULL,
 `reg_closed` int(11) NOT NULL,
 `OverviewNewsFrame` int(11) NOT NULL,
 `OverviewNewsText` text NOT NULL,
 `capaktiv` int(11) NOT NULL,
 `cappublic` varchar(42) NOT NULL,
 `capprivate` varchar(42) NOT NULL,
 `min_build_time` int(11) NOT NULL,
 `smtp_host` int(11) NOT NULL,
 `smtp_port` int(11) NOT NULL,
 `smtp_user` int(11) NOT NULL,
 `smtp_pass` int(11) NOT NULL,
 `smtp_ssl` int(11) NOT NULL,
 `smtp_sendmail` int(11) NOT NULL,
 `user_valid` int(11) NOT NULL,
 `ftp_server` int(11) NOT NULL,
 `ftp_user_name` int(11) NOT NULL,
 `ftp_user_pass` int(11) NOT NULL,
 `ftp_root_path` int(11) NOT NULL,
 `fb_on` int(11) NOT NULL,
 `fb_apikey` varchar(42) NOT NULL,
 `fb_skey` varchar(42) NOT NULL,
 `ga_active` varchar(42) NOT NULL,
 `ga_key` varchar(42) NOT NULL,
 `moduls` varchar(100) NOT NULL,
 PRIMARY KEY (`uni`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

$db->query("INSERT INTO ".CONFIG." (`uni`, `VERSION`, `users_amount`, `game_speed`, `fleet_speed`, `resource_multiplier`, `halt_speed`, `Fleet_Cdr`, `Defs_Cdr`, `initial_fields`, `bgm_active`, `bgm_file`, `game_name`, `game_disable`, `close_reason`, `metal_basic_income`, `crystal_basic_income`, `deuterium_basic_income`, `energy_basic_income`, `LastSettedGalaxyPos`, `LastSettedSystemPos`, `LastSettedPlanetPos`, `noobprotection`, `noobprotectiontime`, `noobprotectionmulti`, `forum_url`, `adm_attack`, `debug`, `lang`, `stat`, `stat_level`, `stat_last_update`, `stat_settings`, `stat_update_time`, `stat_last_db_update`, `stats_fly_lock`, `stat_last_banner_update`, `stat_banner_update_time`, `cron_lock`, `ts_modon`, `ts_server`, `ts_tcpport`, `ts_udpport`, `ts_timeout`, `ts_version`, `reg_closed`, `OverviewNewsFrame`, `OverviewNewsText`, `capaktiv`, `cappublic`, `capprivate`, `min_build_time`, `smtp_host`, `smtp_port`, `smtp_user`, `smtp_pass`, `smtp_ssl`, `smtp_sendmail`, `user_valid`, `ftp_server`, `ftp_user_name`, `ftp_user_pass`, `ftp_root_path`, `fb_on`, `fb_apikey`, `fb_skey`, `ga_active`, `ga_key`, `moduls`) VALUES 
('1', '".$CONF['VERSION']."', '".$CONF['users_amount']."', '".$CONF['game_speed']."', '".$CONF['fleet_speed']."', '".$CONF['resource_multiplier']."', '".$CONF['halt_speed']."', '".$CONF['Fleet_Cdr']."', '".$CONF['Defs_Cdr']."', '".$CONF['initial_fields']."', '".$CONF['bgm_active']."', '".$CONF['bgm_file']."', '".$CONF['game_name']."', '".$CONF['game_disable']."', '".$CONF['close_reason']."', '".$CONF['metal_basic_income']."', '".$CONF['crystal_basic_income']."', '".$CONF['deuterium_basic_income']."', '".$CONF['energy_basic_income']."', '".$CONF['LastSettedGalaxyPos']."', '".$CONF['LastSettedSystemPos']."', 
'".$CONF['LastSettedPlanetPos']."', '".$CONF['noobprotection']."', '".$CONF['noobprotectiontime']."', '".$CONF['noobprotectionmulti']."', '".$CONF['forum_url']."', '".$CONF['adm_attack']."', '".$CONF['debug']."', '".$CONF['lang']."', '".$CONF['stat']."', '".$CONF['stat_level']."', '".$CONF['stat_last_update']."', '".$CONF['stat_settings']."', '".$CONF['stat_last_update']."', '".$CONF['stat_last_db_update']."', '".$CONF['stats_fly_lock']."', '".$CONF['stat_last_banner_update']."', '".$CONF['stat_banner_update_time']."', '".$CONF['cron_lock']."', '".$CONF['ts_modon']."', '".$CONF['ts_server']."', '".$CONF['ts_tcpport']."', '".$CONF['ts_udpport']."', '".$CONF['ts_timeout']."', '".$CONF['ts_version']."', '".$CONF['reg_closed']."', '".$CONF['OverviewNewsFrame']."', '".$CONF['OverviewNewsText']."', '".$CONF['capaktiv']."', '".$CONF['cappublic']."', '".$CONF['capprivate']."', '".$CONF['min_build_time']."', '".$CONF['smtp_host']."', '".$CONF['smtp_port']."', '".$CONF['smtp_user']."', '".$CONF['smtp_pass']."', '".$CONF['smtp_ssl']."', '".$CONF['smtp_sendmail']."', '".$CONF['user_valid']."', '".$CONF['ftp_server']."', '".$CONF['ftp_user_name']."', '".$CONF['ftp_user_pass']."', '".$CONF['ftp_root_path']."', '".$CONF['fb_on']."', '".$CONF['fb_apikey']."', '".$CONF['fb_skey']."', '".$CONF['ga_active']."', '".$CONF['ga_key']."', '".$CONF['moduls']."');");

exit('OK');
?>