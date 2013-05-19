ALTER TABLE `prefix_users` ADD `timezone` FLOAT(4, 2) NOT NULL DEFAULT '0' AFTER `dpath`,
ADD `dst` ENUM( '0', '1', '2' ) NOT NULL DEFAULT '2' AFTER `timezone`;
ALTER TABLE `prefix_config` ADD `timezone` FLOAT(4, 2) NOT NULL DEFAULT '0';