ALTER TABLE `prefix_users` DROP `current_planet`, DROP `user_agent`, DROP `current_page`;
CREATE TABLE `prefix_session` (
`sess_id` VARCHAR( 32 ) NOT NULL ,
`user_id` INT( 11 ) UNSIGNED NOT NULL ,
`user_ua` VARCHAR( 80 ) NOT NULL ,
`user_ip` INT( 4 ) UNSIGNED NOT NULL ,
`user_side` VARCHAR( 50 ) NOT NULL ,
`user_method` VARCHAR( 4 ) NOT NULL ,
`user_lastactivity` INT( 11 ) NOT NULL ,
PRIMARY KEY ( `sess_id` ) ,
INDEX ( `user_ip` , `user_lastactivity` ) ,
UNIQUE ( `user_id` )
) ENGINE = MEMORY CHARACTER SET utf8 COLLATE utf8_general_ci;