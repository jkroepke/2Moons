ALTER TABLE `prefix_fleets` CHANGE `fleet_busy` `fleet_busy` ENUM( '0', '1' ) NOT NULL DEFAULT '0';
ALTER TABLE `prefix_news` CHANGE `text` `text` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `prefix_notes` CHANGE `priority` `priority` ENUM( '0', '1', '2' ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '1';
ALTER TABLE `prefix_users` ADD `new_gmessage` INT( 11 ) NOT NULL DEFAULT '0' AFTER `new_message`;
ALTER TABLE `prefix_users` DROP `current_luna`;