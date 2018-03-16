CREATE TABLE `%PREFIX%trades` (
  `seller_fleet_id`  bigint(11) unsigned NOT NULL DEFAULT 0,
  `buyer_fleet_id`  bigint(11) unsigned DEFAULT NULL,
	`buy_time` datetime,
	`transaction_type` tinyint(1) unsigned NOT NULL DEFAULT 0,
	`filter_visibility` tinyint(1) unsigned NOT NULL DEFAULT 0,
	`filter_flighttime` mediumint unsigned NOT NULL DEFAULT 0,
	`ex_resource_type` tinyint(1) unsigned NOT NULL DEFAULT 0,
	`ex_resource_amount` double(50,0) unsigned NOT NULL DEFAULT '0',
	PRIMARY KEY (`seller_fleet_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

INSERT INTO `%PREFIX%trades` (`seller_fleet_id`, `ex_resource_type`,`ex_resource_amount`)
SELECT fleet_id, fleet_wanted_resource, fleet_wanted_resource_amount
FROM %PREFIX%fleets
WHERE `fleet_mission` = 16;

ALTER TABLE %PREFIX%fleets DROP COLUMN `fleet_wanted_resource`;
ALTER TABLE %PREFIX%fleets DROP COLUMN `fleet_wanted_resource_amount`;
ALTER TABLE %PREFIX%log_fleets DROP COLUMN `fleet_wanted_resource`;
ALTER TABLE %PREFIX%log_fleets DROP COLUMN `fleet_wanted_resource_amount`;
