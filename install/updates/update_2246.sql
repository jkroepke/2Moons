CREATE TABLE `prefix_multi` (
 `multiID` int(11) NOT NULL AUTO_INCREMENT,
 `userID` int(11) NOT NULL,
 PRIMARY KEY (`multiID`),
 KEY `userID` (`userID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;