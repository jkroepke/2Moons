CREATE TABLE IF NOT EXISTS `uni1_cronjobs` (
  `cronID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `active` tinyint(4) NOT NULL DEFAULT '-1',
  `cronString` varchar(255) CHARACTER SET latin1 NOT NULL,
  `file` varchar(100) CHARACTER SET latin1 NOT NULL,
  `nextRun` int(11) NOT NULL,
  `hasErrors` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`cronID`),
  KEY `active` (`active`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;