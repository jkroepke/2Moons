ALTER TABLE %PREFIX%config ADD `message_delete_behavior` tinyint(1) unsigned NOT NULL DEFAULT '0' AFTER `resource_multiplier`;
ALTER TABLE %PREFIX%config ADD `message_delete_days` tinyint(3) unsigned NOT NULL DEFAULT '7' AFTER `message_delete_behavior`;
ALTER TABLE %PREFIX%messages ADD `message_deleted` int(11) unsigned NULL DEFAULT NULL AFTER `message_universe`;
ALTER TABLE %PREFIX%messages DROP INDEX `message_owner`, ADD INDEX `message_owner` (`message_owner`, `message_type`, `message_unread`, `message_deleted`) USING BTREE;
ALTER TABLE %PREFIX%messages ADD INDEX `message_deleted` (`message_deleted`);