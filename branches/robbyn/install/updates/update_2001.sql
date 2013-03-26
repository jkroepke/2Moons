DROP TABLE `prefix_rw`;
DROP TABLE `prefix_topkb`;
CREATE TABLE `prefix_raports` (
 `rid` int(11) unsigned NOT NULL AUTO_INCREMENT,
 `raport` text NOT NULL,
 `time` int(11) NOT NULL,
 PRIMARY KEY (`rid`),
 KEY `time` (`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `prefix_topkb` (
 `rid` int(11) unsigned NOT NULL,
 `attackers` varchar(32) NOT NULL,
 `defenders` varchar(32) NOT NULL,
 `units` double(50,0) unsigned NOT NULL,
 `result` varchar(1) NOT NULL,
 `time` int(11) NOT NULL,
 `universe` tinyint(3) unsigned NOT NULL,
 KEY `time` (`universe`,`time`,`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;