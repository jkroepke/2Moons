CREATE TABLE IF NOT EXISTS `prefix_log` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `mode` tinyint(3) unsigned NOT NULL,
  `admin` int(11) unsigned NOT NULL,
  `target` int(11) NOT NULL,
  `time` int(11) unsigned NOT NULL,
  `data` text NOT NULL,
  `universe` tinyint(3) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `mode` (`mode`,`admin`,`time`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;