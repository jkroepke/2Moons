ALTER TABLE prefix_config
	ADD energySpeed SMALLINT unsigned NOT NULL DEFAULT '1',
	ADD disclamerAddress TEXT NOT NULL,
	ADD disclamerPhone TEXT NOT NULL,
	ADD disclamerMail TEXT NOT NULL,
	ADD disclamerNotice TEXT NOT NULL;

ALTER TABLE prefix_vars
	ADD speed2Tech INT UNSIGNED NULL DEFAULT NULL AFTER speed2,
	ADD speed2onLevel INT UNSIGNED NULL DEFAULT NULL AFTER speed2Tech,
	ADD speed3Tech INT UNSIGNED NULL DEFAULT NULL AFTER speed2onLevel,
	ADD speed3onLevel INT UNSIGNED NULL DEFAULT NULL AFTER speed3Tech,
	ADD bonusSpyPower FLOAT(4,2) NOT NULL DEFAULT '0' AFTER bonusPlanets,
	ADD bonusExpedition FLOAT(4,2) NOT NULL DEFAULT '0' AFTER bonusSpyPower,
	ADD bonusGateCoolTime FLOAT(4,2) NOT NULL DEFAULT '0' AFTER bonusExpedition,
	ADD bonusMoreFound FLOAT(4,2) NOT NULL DEFAULT '0' AFTER bonusGateCoolTime,
	ADD bonusAttackUnit SMALLINT(1) NOT NULL DEFAULT '0' AFTER bonusMoreFound,
	ADD bonusDefensiveUnit SMALLINT(1) NOT NULL DEFAULT '0' AFTER bonusAttackUnit,
	ADD bonusShieldUnit SMALLINT(1) NOT NULL DEFAULT '0' AFTER bonusDefensiveUnit,
	ADD bonusBuildTimeUnit SMALLINT(1) NOT NULL DEFAULT '0' AFTER bonusShieldUnit,
	ADD bonusResearchTimeUnit SMALLINT(1) NOT NULL DEFAULT '0' AFTER bonusBuildTimeUnit,
	ADD bonusShipTimeUnit SMALLINT(1) NOT NULL DEFAULT '0' AFTER bonusResearchTimeUnit,
	ADD bonusDefensiveTimeUnit SMALLINT(1) NOT NULL DEFAULT '0' AFTER bonusShipTimeUnit,
	ADD bonusResourceUnit SMALLINT(1) NOT NULL DEFAULT '0' AFTER bonusDefensiveTimeUnit,
	ADD bonusEnergyUnit SMALLINT(1) NOT NULL DEFAULT '0' AFTER bonusResourceUnit,
	ADD bonusResourceStorageUnit SMALLINT(1) NOT NULL DEFAULT '0' AFTER bonusEnergyUnit,
	ADD bonusShipStorageUnit SMALLINT(1) NOT NULL DEFAULT '0' AFTER bonusResourceStorageUnit,
	ADD bonusFlyTimeUnit SMALLINT(1) NOT NULL DEFAULT '0' AFTER bonusShipStorageUnit,
	ADD bonusFleetSlotsUnit SMALLINT(1) NOT NULL DEFAULT '0' AFTER bonusFlyTimeUnit,
	ADD bonusPlanetsUnit SMALLINT(1) NOT NULL DEFAULT '0' AFTER bonusFleetSlotsUnit,
	ADD bonusSpyPowerUnit SMALLINT(1) NOT NULL DEFAULT '0' AFTER bonusPlanetsUnit,
	ADD bonusExpeditionUnit SMALLINT(1) NOT NULL DEFAULT '0' AFTER bonusSpyPowerUnit,
	ADD bonusGateCoolTimeUnit SMALLINT(1) NOT NULL DEFAULT '0' AFTER bonusExpeditionUnit,
	ADD bonusMoreFoundUnit SMALLINT(1) NOT NULL DEFAULT '0' AFTER bonusGateCoolTimeUnit,
	ADD speedFleetFactor FLOAT(4,2) NULL DEFAULT NULL AFTER bonusMoreFoundUnit;
	
CREATE TABLE prefix_lostpassword (
 userID int(10) unsigned NOT NULL,
 `key` varchar(32) NOT NULL,
 time int(10) unsigned NOT NULL,
 hasChanged tinyint(1) NOT NULL DEFAULT '0',
 fromIP varchar(40) NOT NULL,
 PRIMARY KEY (`key`),
 UNIQUE KEY userID (userID,`key`,time,hasChanged),
 KEY time (time)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE prefix_cronjobs (
  `cronjobID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '1',
  `min` varchar(32) NOT NULL,
  `hours` varchar(32) NOT NULL,
  `dom` varchar(32) NOT NULL,
  `month` varchar(32) NOT NULL,
  `dow` varchar(32) NOT NULL,
  `class` varchar(32) NOT NULL,
  `nextTime` int(11) DEFAULT NULL,
  `lock` varchar(32) DEFAULT NULL,
  UNIQUE KEY `cronjobID` (`cronjobID`),
  KEY `isActive` (`isActive`,`nextTime`,`lock`,`cronjobID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO prefix_cronjobs (`cronjobID`, `name`, `isActive`, `min`, `hours`, `dom`, `month`, `dow`, `class`, `nextTime`, `lock`) VALUES
(1, 'referral', 1, '0,30', '*', '*', '*', '*', 'ReferralCronjob', 0, NULL),
(2, 'statistic', 1, '0,30', '*', '*', '*', '*', 'StatisticCronjob', 0, NULL),
(3, 'daily', 1, '25', '2', '*', '*', '*', 'DailyCronjob', 0, NULL),
(4, 'cleaner', 1, '45', '2', '*', '*', '6', 'CleanerCronjob', 0, NULL),
(5, 'inactive', 1, '30', '1', '*', '*', '0,3,6', 'InactiveMailCronjob', 0, NULL),
(6, 'teamspeak', 0, '*/3', '*', '*', '*', '*', 'TeamSpeakCronjob', 0, NULL);

ALTER TABLE prefix_raports CHANGE rid  rid VARCHAR( 32 ) NOT NULL;
ALTER TABLE prefix_users_to_topkb CHANGE `rid` `rid` VARCHAR( 32 ) NOT NULL;
ALTER TABLE prefix_topkb CHANGE rid rid VARCHAR( 32 ) NOT NULL;
ALTER TABLE prefix_users_to_topkb ADD username VARCHAR( 128 ) NOT NULL AFTER uid;

ALTER TABLE prefix_config CHANGE `ttf_file`  `ttf_file` VARCHAR( 128 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'styles/resource/fonts/DroidSansMono.ttf';
UPDATE prefix_config SET `ttf_file` = 'styles/resource/fonts/DroidSansMono.ttf';

UPDATE prefix_vars SET `bonusAttack` = '0.00', `bonusDefensive` = '0.00' WHERE `elementID` = 603;
UPDATE prefix_vars SET `bonusFlyTime` =  '-0.10' WHERE `elementID` = 613;

ALTER TABLE prefix_users_valid
	ADD `externalAuthUID` VARCHAR(128) NULL DEFAULT NULL,
	ADD `externalAuthMethod` VARCHAR(32) NULL DEFAULT NULL,
	CHANGE `id` `validationID` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, 
	CHANGE `username` `userName` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	CHANGE `cle` `validationKey` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	CHANGE `password` `password` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	CHANGE `email` `email` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	CHANGE `date` `date` INT(11) NOT NULL,
	CHANGE `ip` `ip` VARCHAR(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	CHANGE `lang` `language` VARCHAR(3) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	CHANGE `universe` `universe` TINYINT(3) UNSIGNED NOT NULL,
	CHANGE `ref_id` `referralID` INT( 11 ) NULL DEFAULT NULL,
	DROP `planet`,
	DROP INDEX `cle`,
	DROP PRIMARY KEY,
	ADD PRIMARY KEY (  `validationID` ,  `validationKey` );