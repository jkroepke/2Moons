ALTER TABLE `prefix_config` ADD `trade_allowed_ships` VARCHAR(50) NOT NULL;
ALTER TABLE `prefix_config` ADD `trade_charge` VARCHAR(5) NOT NULL;
UPDATE `prefix_config` SET `trade_allowed_ships` = '221,222,223,224,225,226,227,228';
UPDATE `prefix_config` SET `trade_charge` = '0.7';