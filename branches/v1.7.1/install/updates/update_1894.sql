CREATE TABLE `prefix_buddy_request` (
`id` INT( 11 ) UNSIGNED NOT NULL ,
`text` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
CREATE TABLE `prefix_alliance_request` (
 `id` int(11) unsigned NOT NULL,
 `userid` int(11) unsigned NOT NULL,
 `text` text NOT NULL,
 PRIMARY KEY (`id`),
 UNIQUE KEY `userid` (`userid`)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

ALTER TABLE `prefix_aks` DROP `galaxy`, DROP `system`, DROP `planet`, DROP `planet_type`;
ALTER TABLE `prefix_aks` ADD `target` INT( 11 ) UNSIGNED NOT NULL AFTER `name`;
ALTER TABLE `prefix_alliance` DROP `ally_request_waiting`;
ALTER TABLE `prefix_banned` DROP `who2`;
ALTER TABLE `prefix_buddy` DROP `active`;
ALTER TABLE `prefix_buddy` DROP `text`;
ALTER TABLE `prefix_buddy` ADD INDEX `sender` (`sender`);
ALTER TABLE `prefix_buddy` ADD INDEX `owner` (`owner`);
ALTER TABLE `prefix_fleets` CHANGE `fleet_resource_metal` `fleet_resource_metal` FLOAT( 50, 0 ) UNSIGNED NOT NULL DEFAULT '0', CHANGE `fleet_resource_crystal` `fleet_resource_crystal` FLOAT( 50, 0 ) UNSIGNED NOT NULL DEFAULT '0', CHANGE `fleet_resource_deuterium` `fleet_resource_deuterium` FLOAT( 50, 0 ) UNSIGNED NOT NULL DEFAULT '0', CHANGE `fleet_resource_darkmatter` `fleet_resource_darkmatter` FLOAT( 50, 0 ) UNSIGNED NOT NULL DEFAULT '0';
ALTER TABLE `prefix_log` DROP INDEX `mode` , ADD INDEX `mode` ( `mode` );
ALTER TABLE `prefix_messages` DROP INDEX `message_universe`;
ALTER TABLE `prefix_messages` DROP INDEX `message_owner`;
ALTER TABLE `prefix_messages` DROP INDEX `message_type`;
ALTER TABLE `prefix_messages` DROP INDEX `message_sender`;
ALTER TABLE `prefix_messages` DROP INDEX `message_unread`;
ALTER TABLE `prefix_messages` ADD INDEX ( `message_owner` , `message_type` );
ALTER TABLE `prefix_messages` ADD INDEX ( `message_sender` );
ALTER TABLE `prefix_messages` CHANGE `message_id` `message_id` BIGINT( 20 ) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `prefix_planets` DROP INDEX universe`;
ALTER TABLE `prefix_planets` DROP INDEX `galaxy`, ADD INDEX `universe` ( `universe` , `galaxy` , `system` , `planet` , `planet_type` );
ALTER TABLE `prefix_planets` CHANGE `metal` `metal` FLOAT(50,0) UNSIGNED NOT NULL DEFAULT '0', CHANGE `metal_perhour` `metal_perhour` FLOAT(50,0) UNSIGNED NOT NULL DEFAULT '0', CHANGE `metal_max` `metal_max` FLOAT(50,0) UNSIGNED NULL DEFAULT '100000', CHANGE `crystal` `crystal` FLOAT(50,0) UNSIGNED NOT NULL DEFAULT '0', CHANGE `crystal_perhour` `crystal_perhour` FLOAT(50,0) UNSIGNED NOT NULL DEFAULT '0', CHANGE `crystal_max` `crystal_max` FLOAT(50,0) UNSIGNED NULL DEFAULT '100000', CHANGE `deuterium` `deuterium` FLOAT(50,0) UNSIGNED NOT NULL DEFAULT '0', CHANGE `deuterium_perhour` `deuterium_perhour` FLOAT(50,0) UNSIGNED NOT NULL DEFAULT '0', CHANGE `deuterium_max` `deuterium_max` FLOAT(50,0) UNSIGNED NULL DEFAULT '100000', CHANGE `energy_used` `energy_used` FLOAT(50,0) NOT NULL DEFAULT '0', CHANGE `energy_max` `energy_max` FLOAT(50,0) UNSIGNED NOT NULL DEFAULT '0', CHANGE `interceptor_misil` `interceptor_misil` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0', CHANGE `interplanetary_misil` `interplanetary_misil` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0', CHANGE `der_metal` `der_metal` FLOAT(50,0) UNSIGNED NOT NULL DEFAULT '0', CHANGE `der_crystal` `der_crystal` FLOAT(50,0) UNSIGNED NOT NULL DEFAULT '0';
ALTER TABLE `prefix_session` DROP `user_ua`, DROP `user_method`;
ALTER TABLE `prefix_session` DROP INDEX `user_ip`, ADD INDEX `user_lastactivity` ( `user_lastactivity` );
ALTER TABLE `prefix_session` DROP PRIMARY KEY, ADD PRIMARY KEY ( `sess_id` , `user_id` );
ALTER TABLE `prefix_statpoints` CHANGE `tech_points` `tech_points` FLOAT( 50, 0 ) UNSIGNED NOT NULL, CHANGE `build_points` `build_points` FLOAT( 50, 0 ) UNSIGNED NOT NULL, CHANGE `defs_points` `defs_points` FLOAT( 50, 0 ) UNSIGNED NOT NULL, CHANGE `fleet_points` `fleet_points` FLOAT( 50, 0 ) UNSIGNED NOT NULL, CHANGE `total_points` `total_points` FLOAT( 50, 0 ) UNSIGNED NOT NULL;
ALTER TABLE `prefix_topkb` DROP INDEX universe;
ALTER TABLE `prefix_topkb` DROP INDEX gesamtunits;
ALTER TABLE `prefix_topkb` ADD INDEX `universe` ( `universe` , `gesamtunits` );
ALTER TABLE `prefix_users` CHANGE `darkmatter` `darkmatter` FLOAT( 50, 0 ) NOT NULL DEFAULT '0';
ALTER TABLE `prefix_users` CHANGE `dpath` `dpath` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'gow';
ALTER TABLE `prefix_users` DROP `ally_request`, DROP `ally_request_text`;
ALTER TABLE `prefix_users` ADD INDEX ( `ally_id` );
ALTER TABLE `prefix_users` DROP `ally_name`;
ALTER TABLE `prefix_users` CHANGE `kbmetal` `kbmetal` FLOAT( 50, 0 ) UNSIGNED NOT NULL DEFAULT '0', CHANGE `kbcrystal` `kbcrystal` FLOAT( 50, 0 ) UNSIGNED NOT NULL DEFAULT '0', CHANGE `lostunits` `lostunits` FLOAT( 50, 0 ) UNSIGNED NOT NULL DEFAULT '0', CHANGE `desunits` `desunits` FLOAT( 50, 0 ) UNSIGNED NOT NULL DEFAULT '0';ALTER TABLE `prefix_aks` DROP `teilnehmer`;