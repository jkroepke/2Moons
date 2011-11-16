/**
 *  2Moons
 *  Copyright (C) 2010  Slaver
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
 * @version 1.5 (2011-07-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */



SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
CREATE TABLE `prefix_aks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `target` int(11) unsigned NOT NULL,
  `ankunft` int(11) DEFAULT NULL,
  `eingeladen` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `prefix_alliance` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ally_name` varchar(50) DEFAULT '',
  `ally_tag` varchar(20) DEFAULT '',
  `ally_owner` int(11) unsigned NOT NULL DEFAULT '0',
  `ally_register_time` int(11) NOT NULL DEFAULT '0',
  `ally_description` text,
  `ally_web` varchar(255) DEFAULT '',
  `ally_text` text,
  `ally_image` varchar(255) DEFAULT '',
  `ally_request` varchar(1000) DEFAULT NULL,
  `ally_request_notallow` enum('0','1') NOT NULL DEFAULT '0',
  `ally_owner_range` varchar(32) DEFAULT '',
  `ally_ranks` text,
  `ally_members` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ally_stats` enum('0','1') NOT NULL DEFAULT '1',
  `ally_diplo` enum('0','1') NOT NULL DEFAULT '1',
  `ally_universe` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ally_tag` (`ally_tag`),
  KEY `ally_name` (`ally_name`),
  KEY `ally_universe` (`ally_universe`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE `prefix_alliance_request` (
  `id` int(11) unsigned NOT NULL,
  `text` text NOT NULL,
  `userid` int(11) unsigned NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`userid`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `prefix_banned` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `who` varchar(64) NOT NULL DEFAULT '',
  `theme` varchar(500) NOT NULL,
  `time` int(11) NOT NULL DEFAULT '0',
  `longer` int(11) NOT NULL DEFAULT '0',
  `author` varchar(64) NOT NULL DEFAULT '',
  `email` varchar(64) NOT NULL DEFAULT '',
  `universe` tinyint(3) unsigned NOT NULL,
  KEY `ID` (`id`),
  KEY `universe` (`universe`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `prefix_buddy` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sender` int(11) unsigned NOT NULL DEFAULT '0',
  `owner` int(11) unsigned NOT NULL DEFAULT '0',
  `universe` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `universe` (`universe`),
  KEY `sender` (`sender`),
  KEY `owner` (`owner`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE `prefix_buddy_request` (
  `id` int(11) unsigned NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `prefix_chat_bans` (
  `userID` int(11) NOT NULL,
  `userName` varchar(64) COLLATE utf8_bin NOT NULL,
  `dateTime` datetime NOT NULL,
  `ip` varbinary(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `prefix_chat_invitations` (
  `userID` int(11) NOT NULL,
  `channel` int(11) NOT NULL,
  `dateTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `prefix_chat_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `userName` varchar(64) COLLATE utf8_bin NOT NULL,
  `userRole` int(1) NOT NULL,
  `channel` int(11) NOT NULL,
  `dateTime` datetime NOT NULL,
  `ip` varbinary(16) NOT NULL,
  `text` text COLLATE utf8_bin,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `prefix_chat_online` (
  `userID` int(11) NOT NULL,
  `userName` varchar(64) COLLATE utf8_bin NOT NULL,
  `userRole` int(1) NOT NULL,
  `channel` int(11) NOT NULL,
  `dateTime` datetime NOT NULL,
  `ip` varbinary(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `prefix_config` (
  `name` varchar(32) NOT NULL,
  `value` text NOT NULL,
  `universe` tinyint(3) unsigned NOT NULL,
  KEY (`universe`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

INSERT INTO `prefix_config` (`name`, `value`, `universe`) VALUES
('version', '1.5.2051', 0),
('game_name', '2Moons', 0),
('forum_url', './', 0),
('stat', '0', 0),
('stat_level', '2', 0),
('stat_settings', '1000', 0),
('stat_update_time', '25', 0),
('ts_modon', '0', 0),
('ts_server', '', 0),
('ts_tcpport', '0', 0),
('ts_udpport', '0', 0),
('ts_timeout', '1', 0),
('ts_version', '2', 0),
('ts_cron_last', '0', 0),
('ts_cron_interval', '5', 0),
('ts_login', '', 0),
('ts_password', '', 0),
('capaktiv', '0', 0),
('cappublic', '', 0),
('capprivate', '', 0),
('mail_active', '0', 0),
('mail_use', '0', 0),
('smtp_host', '', 0),
('smtp_port', '0', 0),
('smtp_user', '', 0),
('smtp_pass', '', 0),
('smtp_ssl', '', 0),
('smtp_sendmail', '', 0),
('smail_path', '/usr/sbin/sendmail', 0),
('user_valid', '0', 0),
('fb_on', '0', 0),
('fb_apikey', '', 0),
('fb_skey', '', 0),
('ga_active', '0', 0),
('ga_key', '', 0),
('chat_closed', '0', 0),
('chat_allowchan', '1', 0),
('chat_allowmes', '1', 0),
('chat_allowdelmes', '1', 0),
('chat_logmessage', '1', 0),
('chat_nickchange', '1', 0),
('chat_botname', '2Moons', 0),
('chat_channelname', '2Moons', 0),
('chat_socket_active', '0', 0),
('chat_socket_host', '', 0),
('chat_socket_ip', '', 0),
('chat_socket_port', '0', 0),
('chat_socket_chatid', '1', 0),
('timezone', '0', 0),
('dst', '2', 0),
('users_amount', '1', 1),
('game_speed', '2500', 1),
('fleet_speed', '2500', 1),
('resource_multiplier', '1', 1),
('halt_speed', '1', 1),
('Fleet_Cdr', '30', 1),
('Defs_Cdr', '0', 1),
('initial_fields', '163', 1),
('uni_name', '[LANG]universum[/LANG] 1', 1),
('game_disable', '1', 1),
('close_reason', '[LANG]close_reason[/LANG]', 1),
('metal_basic_income', '20', 1),
('crystal_basic_income', '10', 1),
('deuterium_basic_income', '0', 1),
('energy_basic_income', '0', 1),
('LastSettedGalaxyPos', '1', 1),
('LastSettedSystemPos', '1', 1),
('LastSettedPlanetPos', '1', 1),
('noobprotection', '0', 1),
('noobprotectiontime', '5000', 1),
('noobprotectionmulti', '5', 1),
('adm_attack', '0', 1),
('debug', '0', 1),
('lang', '[LANG]short_name[/LANG]', 1),
('reg_closed', '0', 1),
('news', '[LANG]welcome[/LANG] 2Moons v1.5!', 1),
('min_build_time', '1', 1),
('moduls', '', 1),
('trade_allowed_ships', '202,401', 1),
('trade_charge', '30', 1),
('max_galaxy', '9', 1),
('max_system', '400', 1),
('max_planets', '20', 1),
('planet_factor', '1.0', 1),
('max_elements_build', '5', 1),
('max_elements_tech', '2', 1),
('max_elements_ships', '10', 1),
('min_player_planets', '9', 1),
('max_player_planets', '9', 1),
('max_fleet_per_build', '1000000', 1),
('deuterium_cost_galaxy', '10', 1),
('max_dm_missions', '1', 1),
('max_overflow', '1.0', 1),
('moon_factor', '1.0', 1),
('moon_chance', '1', 1),
('darkmatter_cost_trader', '750', 1),
('factor_university', '8', 1),
('max_fleets_per_acs', '16', 1),
('debris_moon', '1', 1),
('vmode_min_time', '259200', 1),
('gate_wait_time', '3600', 1),
('metal_start', '500', 1),
('crystal_start', '500', 1),
('deuterium_start', '0', 1),
('darkmatter_start', '0', 1),
('ttf_file', 'styles/fonts/DroidSansMono.ttf', 1),
('ref_active', '0', 1),
('ref_bonus', '1000', 1),
('ref_minpoints', '2000', 1),
('ref_max_referals', '5', 1),
('del_oldstuff', '3', 1),
('del_user_manually', '7', 1),
('del_user_automatic', '30', 1),
('del_user_sendmail', '21', 1),
('sendmail_inactive', '0', 1),
('silo_factor', '1', 1);

CREATE TABLE `prefix_diplo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `owner_1` int(11) unsigned NOT NULL,
  `owner_2` int(11) unsigned NOT NULL,
  `level` tinyint(1) unsigned NOT NULL,
  `accept` tinyint(1) unsigned NOT NULL,
  `accept_text` varchar(255) NOT NULL,
  `universe` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `owner_1` (`owner_1`,`owner_2`),
  KEY `universe` (`universe`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `prefix_fleets` (
  `fleet_id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `fleet_owner` int(11) unsigned NOT NULL DEFAULT '0',
  `fleet_mission` tinyint(3) unsigned NOT NULL DEFAULT '3',
  `fleet_amount` bigint(20) unsigned NOT NULL DEFAULT '0',
  `fleet_array` text,
  `fleet_universe` tinyint(3) unsigned NOT NULL,
  `fleet_start_time` int(11) NOT NULL DEFAULT '0',
  `fleet_start_id` int(11) unsigned NOT NULL,
  `fleet_start_galaxy` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `fleet_start_system` smallint(5) unsigned NOT NULL DEFAULT '0',
  `fleet_start_planet` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `fleet_start_type` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `fleet_end_time` int(11) NOT NULL DEFAULT '0',
  `fleet_end_stay` int(11) NOT NULL DEFAULT '0',
  `fleet_end_id` int(11) unsigned NOT NULL,
  `fleet_end_galaxy` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `fleet_end_system` smallint(5) unsigned NOT NULL DEFAULT '0',
  `fleet_end_planet` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `fleet_end_type` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `fleet_target_obj` smallint(3) unsigned NOT NULL DEFAULT '0',
  `fleet_resource_metal` double(50,0) unsigned NOT NULL DEFAULT '0',
  `fleet_resource_crystal` double(50,0) unsigned NOT NULL DEFAULT '0',
  `fleet_resource_deuterium` double(50,0) unsigned NOT NULL DEFAULT '0',
  `fleet_resource_darkmatter` double(50,0) unsigned NOT NULL DEFAULT '0',
  `fleet_target_owner` int(11) unsigned NOT NULL DEFAULT '0',
  `fleet_group` varchar(15) NOT NULL DEFAULT '0',
  `fleet_mess` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `start_time` int(11) DEFAULT NULL,
  `fleet_busy` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`fleet_id`),
  KEY `fleet_mess` (`fleet_mess`),
  KEY `fleet_target_owner` (`fleet_target_owner`),
  KEY `fleet_end_stay` (`fleet_end_stay`),
  KEY `fleet_end_time` (`fleet_end_time`),
  KEY `fleet_start_time` (`fleet_start_time`),
  KEY `fleet_start_id` (`fleet_start_id`),
  KEY `fleet_end_id` (`fleet_end_id`),
  KEY `fleet_universe` (`fleet_universe`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE `prefix_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mode` tinyint(3) unsigned NOT NULL,
  `admin` int(11) unsigned NOT NULL,
  `target` int(11) NOT NULL,
  `time` int(11) unsigned NOT NULL,
  `data` text NOT NULL,
  `universe` tinyint(3) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mode` (`mode`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE `uni1_log_fleets` (
 `fleet_id` bigint(11) unsigned NOT NULL,
 `fleet_owner` int(11) unsigned NOT NULL DEFAULT '0',
 `fleet_mission` tinyint(3) unsigned NOT NULL DEFAULT '3',
 `fleet_amount` bigint(20) unsigned NOT NULL DEFAULT '0',
 `fleet_array` text,
 `fleet_universe` tinyint(3) unsigned NOT NULL,
 `fleet_start_time` int(11) NOT NULL DEFAULT '0',
 `fleet_start_id` int(11) unsigned NOT NULL,
 `fleet_start_galaxy` tinyint(3) unsigned NOT NULL DEFAULT '0',
 `fleet_start_system` smallint(5) unsigned NOT NULL DEFAULT '0',
 `fleet_start_planet` tinyint(3) unsigned NOT NULL DEFAULT '0',
 `fleet_start_type` tinyint(3) unsigned NOT NULL DEFAULT '1',
 `fleet_end_time` int(11) NOT NULL DEFAULT '0',
 `fleet_end_stay` int(11) NOT NULL DEFAULT '0',
 `fleet_end_id` int(11) unsigned NOT NULL,
 `fleet_end_galaxy` tinyint(3) unsigned NOT NULL DEFAULT '0',
 `fleet_end_system` smallint(5) unsigned NOT NULL DEFAULT '0',
 `fleet_end_planet` tinyint(3) unsigned NOT NULL DEFAULT '0',
 `fleet_end_type` tinyint(3) unsigned NOT NULL DEFAULT '1',
 `fleet_target_obj` smallint(3) unsigned NOT NULL DEFAULT '0',
 `fleet_resource_metal` double(50,0) unsigned NOT NULL DEFAULT '0',
 `fleet_resource_crystal` double(50,0) unsigned NOT NULL DEFAULT '0',
 `fleet_resource_deuterium` double(50,0) unsigned NOT NULL DEFAULT '0',
 `fleet_resource_darkmatter` double(50,0) unsigned NOT NULL DEFAULT '0',
 `fleet_target_owner` int(11) unsigned NOT NULL DEFAULT '0',
 `fleet_group` varchar(15) NOT NULL DEFAULT '0',
 `fleet_mess` tinyint(3) unsigned NOT NULL DEFAULT '0',
 `start_time` int(11) DEFAULT NULL,
 `fleet_busy` tinyint(3) unsigned NOT NULL DEFAULT '0',
 `fleet_state` tinyint(3) unsigned NOT NULL,
 PRIMARY KEY (`fleet_id`),
 KEY `BashRule` (`fleet_owner`,`fleet_end_id`,`fleet_start_time`,`fleet_mission`,`fleet_state`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `prefix_messages` (
  `message_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `message_owner` int(11) unsigned NOT NULL DEFAULT '0',
  `message_sender` int(11) unsigned NOT NULL DEFAULT '0',
  `message_time` int(11) NOT NULL DEFAULT '0',
  `message_type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `message_from` varchar(128) DEFAULT NULL,
  `message_subject` varchar(128) DEFAULT NULL,
  `message_text` text,
  `message_unread` enum('0','1') NOT NULL DEFAULT '1',
  `message_universe` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`message_id`),
  KEY `message_owner` (`message_owner`,`message_type`),
  KEY `message_sender` (`message_sender`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE `prefix_news` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(64) NOT NULL,
  `date` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `prefix_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` int(11) unsigned DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `priority` enum('0','1','2') DEFAULT '1',
  `title` varchar(32) DEFAULT NULL,
  `text` text,
  `universe` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `universe` (`universe`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `prefix_planets` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT 'Hauptplanet',
  `id_owner` int(11) unsigned DEFAULT NULL,
  `universe` tinyint(3) unsigned NOT NULL,
  `galaxy` tinyint(3) NOT NULL DEFAULT '0',
  `system` smallint(5) NOT NULL DEFAULT '0',
  `planet` tinyint(3) NOT NULL DEFAULT '0',
  `last_update` int(11) DEFAULT NULL,
  `planet_type` enum('1','3') NOT NULL DEFAULT '1',
  `destruyed` int(11) NOT NULL DEFAULT '0',
  `b_building` int(11) NOT NULL DEFAULT '0',
  `b_building_id` text NOT NULL,
  `b_hangar` int(11) NOT NULL DEFAULT '0',
  `b_hangar_id` text NOT NULL,
  `b_hangar_plus` int(11) NOT NULL DEFAULT '0',
  `image` varchar(32) NOT NULL DEFAULT 'normaltempplanet01',
  `diameter` int(11) unsigned NOT NULL DEFAULT '12800',
  `field_current` smallint(5) unsigned NOT NULL DEFAULT '0',
  `field_max` smallint(5) unsigned NOT NULL DEFAULT '163',
  `temp_min` int(3) NOT NULL DEFAULT '-17',
  `temp_max` int(3) NOT NULL DEFAULT '23',
  `eco_hash` varchar(32) NOT NULL DEFAULT '',
  `metal` double(50,6) unsigned NOT NULL DEFAULT '0',
  `metal_perhour` double(50,6) unsigned NOT NULL DEFAULT '0',
  `metal_max` double(50,0) unsigned DEFAULT '100000',
  `crystal` double(50,6) unsigned NOT NULL DEFAULT '0',
  `crystal_perhour` double(50,6) unsigned NOT NULL DEFAULT '0',
  `crystal_max` double(50,0) unsigned DEFAULT '100000',
  `deuterium` double(50,6) unsigned NOT NULL DEFAULT '0',
  `deuterium_used` int(11) unsigned NOT NULL DEFAULT '0',
  `deuterium_perhour` double(50,6) unsigned NOT NULL DEFAULT '0',
  `deuterium_max` double(50,0) unsigned DEFAULT '100000',
  `energy_used` double(50,0) NOT NULL DEFAULT '0',
  `energy_max` double(50,0) unsigned NOT NULL DEFAULT '0',
  `metal_mine` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `crystal_mine` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `deuterium_sintetizer` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `solar_plant` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `fusion_plant` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `robot_factory` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `nano_factory` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `hangar` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `metal_store` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `crystal_store` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `deuterium_store` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `laboratory` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `terraformer` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `university` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ally_deposit` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `silo` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `mondbasis` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `phalanx` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `sprungtor` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `small_ship_cargo` bigint(20) unsigned NOT NULL DEFAULT '0',
  `big_ship_cargo` bigint(20) unsigned NOT NULL DEFAULT '0',
  `light_hunter` bigint(20) unsigned NOT NULL DEFAULT '0',
  `heavy_hunter` bigint(20) unsigned NOT NULL DEFAULT '0',
  `crusher` bigint(20) unsigned NOT NULL DEFAULT '0',
  `battle_ship` bigint(20) unsigned NOT NULL DEFAULT '0',
  `colonizer` bigint(20) unsigned NOT NULL DEFAULT '0',
  `recycler` bigint(20) unsigned NOT NULL DEFAULT '0',
  `spy_sonde` bigint(20) unsigned NOT NULL DEFAULT '0',
  `bomber_ship` bigint(20) unsigned NOT NULL DEFAULT '0',
  `solar_satelit` bigint(20) unsigned NOT NULL DEFAULT '0',
  `destructor` bigint(20) unsigned NOT NULL DEFAULT '0',
  `dearth_star` bigint(20) unsigned NOT NULL DEFAULT '0',
  `battleship` bigint(20) unsigned NOT NULL DEFAULT '0',
  `lune_noir` bigint(20) unsigned NOT NULL DEFAULT '0',
  `ev_transporter` bigint(20) unsigned NOT NULL DEFAULT '0',
  `star_crasher` bigint(20) unsigned NOT NULL DEFAULT '0',
  `giga_recykler` bigint(20) unsigned NOT NULL DEFAULT '0',
  `dm_ship` bigint(20) NOT NULL DEFAULT '0',
  `orbital_station` bigint(20) unsigned NOT NULL DEFAULT '0',
  `misil_launcher` bigint(20) unsigned NOT NULL DEFAULT '0',
  `small_laser` bigint(20) unsigned NOT NULL DEFAULT '0',
  `big_laser` bigint(20) unsigned NOT NULL DEFAULT '0',
  `gauss_canyon` bigint(20) unsigned NOT NULL DEFAULT '0',
  `ionic_canyon` bigint(20) unsigned NOT NULL DEFAULT '0',
  `buster_canyon` bigint(20) unsigned NOT NULL DEFAULT '0',
  `small_protection_shield` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `planet_protector` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `big_protection_shield` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `graviton_canyon` bigint(20) unsigned NOT NULL DEFAULT '0',
  `interceptor_misil` bigint(20) unsigned NOT NULL DEFAULT '0',
  `interplanetary_misil` bigint(20) unsigned NOT NULL DEFAULT '0',
  `metal_mine_porcent` enum('0','1','2','3','4','5','6','7','8','9','10') NOT NULL DEFAULT '10',
  `crystal_mine_porcent` enum('0','1','2','3','4','5','6','7','8','9','10') NOT NULL DEFAULT '10',
  `deuterium_sintetizer_porcent` enum('0','1','2','3','4','5','6','7','8','9','10') NOT NULL DEFAULT '10',
  `solar_plant_porcent` enum('0','1','2','3','4','5','6','7','8','9','10') NOT NULL DEFAULT '10',
  `fusion_plant_porcent` enum('0','1','2','3','4','5','6','7','8','9','10') NOT NULL DEFAULT '10',
  `solar_satelit_porcent` enum('0','1','2','3','4','5','6','7','8','9','10') NOT NULL DEFAULT '10',
  `last_jump_time` int(11) NOT NULL DEFAULT '0',
  `der_metal` double(50,0) unsigned NOT NULL DEFAULT '0',
  `der_crystal` double(50,0) unsigned NOT NULL DEFAULT '0',
  `id_luna` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_luna` (`id_luna`),
  KEY `id_owner` (`id_owner`),
  KEY `destruyed` (`destruyed`),
  KEY `universe` (`universe`,`galaxy`,`system`,`planet`,`planet_type`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE `prefix_raports` (
  `rid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `raport` text NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`rid`),
  KEY `time` (`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `prefix_session` (
  `sess_id` varchar(32) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `user_ip` varchar(40) NOT NULL,
  `user_side` varchar(50) NOT NULL,
  `user_lastactivity` int(11) NOT NULL,
  PRIMARY KEY (`sess_id`,`user_id`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

CREATE TABLE `prefix_statpoints` (
  `id_owner` int(11) unsigned NOT NULL,
  `id_ally` int(11) unsigned NOT NULL,
  `stat_type` tinyint(1) unsigned NOT NULL,
  `universe` tinyint(3) unsigned NOT NULL,
  `tech_rank` int(11) unsigned NOT NULL,
  `tech_old_rank` int(11) unsigned NOT NULL,
  `tech_points` double(50,0) unsigned NOT NULL,
  `tech_count` int(11) unsigned NOT NULL,
  `build_rank` int(11) unsigned NOT NULL,
  `build_old_rank` int(11) unsigned NOT NULL,
  `build_points` double(50,0) unsigned NOT NULL,
  `build_count` int(11) unsigned NOT NULL,
  `defs_rank` int(11) unsigned NOT NULL,
  `defs_old_rank` int(11) unsigned NOT NULL,
  `defs_points` double(50,0) unsigned NOT NULL,
  `defs_count` int(11) unsigned NOT NULL,
  `fleet_rank` int(11) unsigned NOT NULL,
  `fleet_old_rank` int(11) unsigned NOT NULL,
  `fleet_points` double(50,0) unsigned NOT NULL,
  `fleet_count` int(11) unsigned NOT NULL,
  `total_rank` int(11) unsigned NOT NULL,
  `total_old_rank` int(11) unsigned NOT NULL,
  `total_points` double(50,0) unsigned NOT NULL,
  `total_count` int(11) unsigned NOT NULL,
  KEY `id_owner` (`id_owner`),
  KEY `universe` (`universe`),
  KEY `stat_type` (`stat_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `prefix_supp` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `player_id` int(11) unsigned NOT NULL,
  `time` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `universe` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `player_id` (`player_id`),
  KEY `universe` (`universe`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `prefix_topkb` (
  `rid` int(11) unsigned NOT NULL,
  `units` double(50,0) unsigned NOT NULL,
  `result` varchar(1) NOT NULL,
  `time` int(11) NOT NULL,
  `universe` tinyint(3) unsigned NOT NULL,
  KEY `time` (`universe`, `rid`, `time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `prefix_users_to_topkb` (
 `rid` int(11) NOT NULL,
 `uid` int(11) NOT NULL,
 `role` tinyint(1) NOT NULL,
 KEY `rid` (`rid`,`role`)
) ENGINE=MyISAM;


CREATE TABLE `prefix_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `email` varchar(64) NOT NULL DEFAULT '',
  `email_2` varchar(64) NOT NULL DEFAULT '',
  `lang` varchar(2) NOT NULL DEFAULT 'de',
  `authattack` enum('0','1','2','3') NOT NULL DEFAULT '0',
  `authlevel` enum('0','1','2','3') NOT NULL DEFAULT '0',
  `rights` text NOT NULL,
  `id_planet` int(11) unsigned NOT NULL DEFAULT '0',
  `universe` tinyint(3) unsigned NOT NULL,
  `galaxy` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `system` smallint(5) unsigned NOT NULL DEFAULT '0',
  `planet` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `darkmatter` double(50,0) NOT NULL DEFAULT '0',
  `user_lastip` varchar(40) NOT NULL DEFAULT '',
  `ip_at_reg` varchar(40) NOT NULL DEFAULT '',
  `register_time` int(11) NOT NULL DEFAULT '0',
  `onlinetime` int(11) NOT NULL DEFAULT '0',
  `dpath` varchar(20) NOT NULL DEFAULT 'gow',
  `timezone` float(4, 2) NOT NULL DEFAULT '0',
  `dst` enum('0', '1', '2') NOT NULL DEFAULT '2',
  `design` tinyint(1) NOT NULL DEFAULT '1',
  `noipcheck` tinyint(1) NOT NULL DEFAULT '1',
  `planet_sort` tinyint(1) NOT NULL DEFAULT '0',
  `planet_sort_order` tinyint(1) NOT NULL DEFAULT '0',
  `spio_anz` tinyint(2) NOT NULL DEFAULT '1',
  `settings_tooltiptime` tinyint(1) unsigned NOT NULL DEFAULT '5',
  `settings_fleetactions` tinyint(2) unsigned NOT NULL DEFAULT '3',
  `settings_planetmenu` enum('0','1') NOT NULL DEFAULT '1',
  `settings_esp` enum('0','1') NOT NULL DEFAULT '1',
  `settings_wri` enum('0','1') NOT NULL DEFAULT '1',
  `settings_bud` enum('0','1') NOT NULL DEFAULT '1',
  `settings_mis` enum('0','1') NOT NULL DEFAULT '1',
  `settings_rep` enum('0','1') NOT NULL DEFAULT '0',
  `settings_tnstor` enum('0','1') NOT NULL DEFAULT '1',
  `settings_gview` enum('0','1') NOT NULL DEFAULT '1',
  `urlaubs_modus` enum('0','1') NOT NULL DEFAULT '0',
  `urlaubs_until` int(11) NOT NULL DEFAULT '0',
  `db_deaktjava` int(11) NOT NULL DEFAULT '0',
  `fleet_shortcut` text,
  `b_tech_planet` int(11) unsigned NOT NULL DEFAULT '0',
  `b_tech` int(11) unsigned NOT NULL DEFAULT '0',
  `b_tech_id` smallint(2) unsigned NOT NULL DEFAULT '0',
  `b_tech_queue` text NOT NULL,
  `spy_tech` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `computer_tech` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `military_tech` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `defence_tech` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `shield_tech` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `energy_tech` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `hyperspace_tech` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `combustion_tech` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `impulse_motor_tech` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `hyperspace_motor_tech` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `laser_tech` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ionic_tech` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `buster_tech` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `intergalactic_tech` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `expedition_tech` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `metal_proc_tech` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `crystal_proc_tech` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `deuterium_proc_tech` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `graviton_tech` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ally_id` int(11) unsigned NOT NULL DEFAULT '0',
  `ally_register_time` int(11) NOT NULL DEFAULT '0',
  `ally_rank_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rpg_geologue` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `rpg_amiral` tinyint(2) NOT NULL DEFAULT '0',
  `rpg_ingenieur` tinyint(2) NOT NULL DEFAULT '0',
  `rpg_technocrate` tinyint(2) NOT NULL DEFAULT '0',
  `rpg_espion` tinyint(2) NOT NULL DEFAULT '0',
  `rpg_constructeur` tinyint(2) NOT NULL DEFAULT '0',
  `rpg_scientifique` tinyint(2) NOT NULL DEFAULT '0',
  `rpg_commandant` tinyint(2) NOT NULL DEFAULT '0',
  `rpg_stockeur` tinyint(2) NOT NULL DEFAULT '0',
  `rpg_defenseur` tinyint(2) NOT NULL DEFAULT '0',
  `rpg_destructeur` tinyint(2) NOT NULL DEFAULT '0',
  `rpg_general` tinyint(2) NOT NULL DEFAULT '0',
  `rpg_bunker` tinyint(2) NOT NULL DEFAULT '0',
  `rpg_raideur` tinyint(2) NOT NULL DEFAULT '0',
  `rpg_empereur` tinyint(22) NOT NULL DEFAULT '0',
  `bana` enum('0','1') DEFAULT '0',
  `banaday` int(11) NOT NULL DEFAULT '0',
  `hof` enum('0','1') NOT NULL DEFAULT '1',
  `wons` int(11) unsigned NOT NULL DEFAULT '0',
  `loos` int(11) unsigned NOT NULL DEFAULT '0',
  `draws` int(11) unsigned NOT NULL DEFAULT '0',
  `kbmetal` double(50,0) unsigned NOT NULL DEFAULT '0',
  `kbcrystal` double(50,0) unsigned NOT NULL DEFAULT '0',
  `lostunits` double(50,0) unsigned NOT NULL DEFAULT '0',
  `desunits` double(50,0) unsigned NOT NULL DEFAULT '0',
  `uctime` int(11) NOT NULL DEFAULT '0',
  `setmail` int(11) NOT NULL DEFAULT '0',
  `dm_attack` int(11) NOT NULL DEFAULT '0',
  `dm_defensive` int(11) NOT NULL DEFAULT '0',
  `dm_buildtime` int(11) NOT NULL DEFAULT '0',
  `dm_researchtime` int(11) NOT NULL DEFAULT '0',
  `dm_resource` int(11) NOT NULL DEFAULT '0',
  `dm_energie` int(11) NOT NULL DEFAULT '0',
  `dm_fleettime` int(11) NOT NULL DEFAULT '0',
  `fb_id` bigint(15) unsigned NOT NULL DEFAULT '0',
  `ref_id` int(11) NOT NULL DEFAULT '0',
  `ref_bonus` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fb_id` (`fb_id`),
  KEY `authlevel` (`authlevel`),
  KEY `ref_bonus` (`ref_bonus`),
  KEY `universe` (`universe`,`username`,`password`,`onlinetime`,`authlevel`),
  KEY `ally_id` (`ally_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE `prefix_users_valid` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL DEFAULT '',
  `cle` varchar(30) NOT NULL,
  `password` varchar(64) NOT NULL DEFAULT '',
  `email` varchar(64) NOT NULL DEFAULT '',
  `date` int(11) NOT NULL DEFAULT '0',
  `planet` varchar(64) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `lang` varchar(2) NOT NULL,
  `universe` tinyint(3) unsigned NOT NULL,
  `fb_id` bigint(15) unsigned NOT NULL DEFAULT '0',
  `ref_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `cle` (`cle`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;