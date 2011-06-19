ALTER TABLE `prefix_users` 
ADD `new_message_0` TINYINT( 3 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `onlinetime`, 
ADD `new_message_1` TINYINT( 3 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `new_message_0`, 
ADD `new_message_2` TINYINT( 3 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `new_message_1`, 
ADD `new_message_3` TINYINT( 3 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `new_message_2`, 
ADD `new_message_4` TINYINT( 3 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `new_message_3`, 
ADD `new_message_5` TINYINT( 3 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `new_message_4`, 
ADD `new_message_15` TINYINT( 3 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `new_message_5`, 
ADD `new_message_50` TINYINT( 3 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `new_message_15`, 
ADD `new_message_99` TINYINT( 3 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `new_message_50`;
ALTER TABLE `prefix_users` 
DROP `new_message`, 
DROP `new_gmessage`;
ALTER TABLE `prefix_users` 
CHANGE `kbmetal` `kbmetal` DECIMAL( 65 ) UNSIGNED NOT NULL DEFAULT '0', 
CHANGE `kbcrystal` `kbcrystal` DECIMAL( 65 ) UNSIGNED NOT NULL DEFAULT '0', 
CHANGE `lostunits` `lostunits` DECIMAL( 65 ) UNSIGNED NOT NULL DEFAULT '0', 
CHANGE `desunits` `desunits` DECIMAL( 65 ) UNSIGNED NOT NULL DEFAULT '0';
ALTER TABLE `prefix_users` 
DROP INDEX `authlevel`, 
DROP INDEX `dm_fleettime`, 
DROP INDEX `register_time`, 
DROP INDEX `universe`, 
ADD INDEX `universe` ( `universe` , `username` , `password` , `onlinetime` , `authlevel` );