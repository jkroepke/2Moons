ALTER TABLE prefix_users_valid ADD `ref_id` INT( 11 ) NOT NULL DEFAULT '0';
ALTER TABLE prefix_users ADD `ref_id` INT( 11 ) NOT NULL DEFAULT '0', ADD `ref_bonus` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0';
ALTER TABLE prefix_users ADD INDEX ( `register_time` );
ALTER TABLE prefix_users ADD INDEX ( `ref_bonus` );
