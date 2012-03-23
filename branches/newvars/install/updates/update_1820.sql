ALTER TABLE `prefix_config` CHANGE `trade_allowed_ships` `trade_allowed_ships` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '202,401';
ALTER TABLE `prefix_config` CHANGE `ref_minpoints` `ref_minpoints` bigint(20) UNSIGNED NOT NULL DEFAULT '2000';
