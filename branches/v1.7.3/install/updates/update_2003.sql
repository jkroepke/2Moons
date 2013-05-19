TRUNCATE TABLE `prefix_topkb`;
ALTER TABLE `prefix_topkb` DROP `attackers`, DROP `defenders`;

CREATE TABLE `prefix_users_to_topkb` (
 `rid` int(11) NOT NULL,
 `uid` int(11) NOT NULL,
 `role` tinyint(1) NOT NULL,
 KEY `rid` (`rid`,`role`)
) ENGINE=MyISAM;