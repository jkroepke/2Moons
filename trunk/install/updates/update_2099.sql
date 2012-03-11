ALTER TABLE `prefix_chat_online` ADD INDEX `dateTime` ( `dateTime` , `channel` );

CREATE TABLE `prefix_users_to_extauth` (
 `id` int(11) NOT NULL,
 `account` varchar(64) NOT NULL,
 `mode` varchar(32) NOT NULL,
 PRIMARY KEY (`id`),
 KEY `id` (`id`),
 KEY `account` (`account`,`mode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO prefix_users_to_extauth (id, account, mode) (SELECT id, fb_id, 'facebook' FROM prefix_users WHERE fb_id != 0);

ALTER TABLE `prefix_users` DROP `fb_id`;
ALTER TABLE `prefix_users_valid` DROP `fb_id`;