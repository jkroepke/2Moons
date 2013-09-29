CREATE TABLE `prefix_queue` (
 `taskId` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `queueId` int(10) unsigned NOT NULL,
 `userId` int(10) unsigned NOT NULL,
 `planetId` int(10) unsigned NOT NULL,
 `elementId` int(10) unsigned NOT NULL,
 `buildTime` int(10) unsigned NOT NULL,
 `endBuildTime` int(10) unsigned NOT NULL,
 `amount` int(10) unsigned NOT NULL,
 `taskType` tinyint(1) unsigned NOT NULL,
 PRIMARY KEY (`taskId`),
 KEY `userId` (`userId`,`planetId`,`endBuildTime`,`queueId`),
 KEY `elementId` (`elementId`),
 KEY `queueId` (`queueId`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

CREATE TABLE `prefix_vars_queue_blocker` (
 `queueId` int(11) NOT NULL,
 `elementId` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `prefix_fleet_elements`  (
 `fleetId` int(10) unsigned NOT NULL,
 `elementId` int(10) unsigned NOT NULL,
 `amount` bigint(20) unsigned NOT NULL,
 KEY `fleetId` (`fleetId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `prefix_planets` CHANGE `destruyed` `destroyed` INT( 11 ) NOT NULL DEFAULT '0';

RENAME TABLE `prefix_vars_requriements` TO `prefix_vars_requirements`;

INSERT INTO `prefix_vars_queue_blocker` (`queueId`, `elementId`) VALUES
('1002',  '6'),
('1002',  '31'),
('1003',  '15'),
('1003',  '21');

ALTER TABLE `prefix_vars`
	ADD `flagBuildOnPlanet` ENUM( '0', '1' ) NOT NULL DEFAULT '0' AFTER `bonusMoreFoundUnit`,
	ADD `flagBuildOnMoon` ENUM( '0', '1' ) NOT NULL DEFAULT '0' AFTER `flagBuildOnPlanet`,
	ADD `flagDebris` ENUM( '0', '1' ) NOT NULL DEFAULT '0' AFTER `flagBuildOnMoon`,
	ADD `flagTransport` ENUM( '0', '1' ) NOT NULL DEFAULT '0' AFTER `flagDebris`,
	ADD `flagSteal` ENUM( '0', '1' ) NOT NULL DEFAULT '0' AFTER `flagTransport`,
	ADD `flagTopNav` ENUM( '0', '1' ) NOT NULL DEFAULT '0' AFTER `flagSteal`,
	ADD `flagAttackMissile` ENUM( '0', '1' ) NOT NULL DEFAULT '0' AFTER `flagTopNav`,
	ADD `flagDefendMissile` ENUM( '0', '1' ) NOT NULL DEFAULT '0' AFTER `flagAttackMissile`,
	ADD `flagSpy` ENUM( '0', '1' ) NOT NULL DEFAULT '0' AFTER `flagAttackMissile`,
	ADD `flagCollect` ENUM( '0', '1' ) NOT NULL DEFAULT '0' AFTER `flagSpy`,
	ADD `flagColonize` ENUM( '0', '1' ) NOT NULL DEFAULT '0' AFTER `flagCollect`,
	ADD `flagDestroy` ENUM( '0', '1' ) NOT NULL DEFAULT '0' AFTER `flagColonize`,
	ADD `flagSpecExpedition` ENUM( '0', '1' ) NOT NULL DEFAULT '0' AFTER `flagDestroy`,
	ADD `flagTrade` ENUM( '0', '1' ) NOT NULL DEFAULT '0' AFTER `flagSpecExpedition`,
	ADD `flagOnEcoOverview` ENUM( '0', '1' ) NOT NULL DEFAULT '0' AFTER `flagTrade`,
	ADD `flagCalculateBuildTime` ENUM( '0', '1' ) NOT NULL DEFAULT '0' AFTER `flagOnEcoOverview`,
	ADD `flagCalculateFleetStructure` ENUM( '0', '1' ) NOT NULL DEFAULT '0' AFTER `flagOnEcoOverview`,
	ADD `resourceMode` ENUM( 'planet', 'user', 'energy' ) NULL DEFAULT NULL AFTER `flagCalculateFleetStructure`,
	ADD `bonusResource901` FLOAT( 4, 2 ) NOT NULL DEFAULT '0' AFTER `bonusResource`,
	ADD `bonusResource902` FLOAT( 4, 2 ) NOT NULL DEFAULT '0' AFTER `bonusResource901`,
	ADD `bonusResource903` FLOAT( 4, 2 ) NOT NULL DEFAULT '0' AFTER `bonusResource902`,
	ADD `bonusResource911` FLOAT( 4, 2 ) NOT NULL DEFAULT '0' AFTER `bonusResource903`,
	ADD `bonusResource901Unit` ENUM( '0', '1' ) NOT NULL DEFAULT '0' AFTER `bonusResourceUnit`,
	ADD `bonusResource902Unit` ENUM( '0', '1' ) NOT NULL DEFAULT '0' AFTER `bonusResource901Unit`,
	ADD `bonusResource903Unit` ENUM( '0', '1' ) NOT NULL DEFAULT '0' AFTER `bonusResource902Unit`,
	ADD `bonusResource911Unit` ENUM( '0', '1' ) NOT NULL DEFAULT '0' AFTER `bonusResource903Unit`,
	ADD `queueId` INT UNSIGNED NULL DEFAULT NULL AFTER `maxLevel`;
	
ALTER TABLE `prefix_vars` 
	CHANGE `consumption1` `consumption1903` INT UNSIGNED NULL DEFAULT NULL,
	CHANGE `consumption2` `consumption2903` INT UNSIGNED NULL DEFAULT NULL,
	CHANGE `speedTech` `speed1Tech` INT UNSIGNED NULL DEFAULT NULL,
	CHANGE `speed1` `speed1` INT UNSIGNED NULL DEFAULT NULL,
	CHANGE `speed2` `speed2` INT UNSIGNED NULL DEFAULT NULL,
	CHANGE `capacity` `capacity` INT UNSIGNED NULL DEFAULT NULL,
	CHANGE `timeBonus` `timeBonus` INT UNSIGNED NULL DEFAULT NULL,
	CHANGE `bonusAttackUnit` `bonusAttackUnit` ENUM('0','1') NOT NULL DEFAULT '0',
	CHANGE `bonusDefensiveUnit` `bonusDefensiveUnit` ENUM('0','1') NOT NULL DEFAULT '0',
	CHANGE `bonusShieldUnit` `bonusShieldUnit` ENUM('0','1') NOT NULL DEFAULT '0',
	CHANGE `bonusBuildTimeUnit` `bonusBuildTimeUnit` ENUM('0','1') NOT NULL DEFAULT '0',
	CHANGE `bonusResearchTimeUnit` `bonusResearchTimeUnit` ENUM('0','1') NOT NULL DEFAULT '0',
	CHANGE `bonusShipTimeUnit` `bonusShipTimeUnit` ENUM('0','1') NOT NULL DEFAULT '0',
	CHANGE `bonusDefensiveTimeUnit` `bonusDefensiveTimeUnit` ENUM('0','1') NOT NULL DEFAULT '0',
	CHANGE `bonusResourceUnit` `bonusResourceUnit` ENUM('0','1') NOT NULL DEFAULT '0',
	CHANGE `bonusEnergyUnit` `bonusEnergyUnit` ENUM('0','1') NOT NULL DEFAULT '0',
	CHANGE `bonusResourceStorageUnit` `bonusResourceStorageUnit` ENUM('0','1') NOT NULL DEFAULT '0',
	CHANGE `bonusShipStorageUnit` `bonusShipStorageUnit` ENUM('0','1') NOT NULL DEFAULT '0',
	CHANGE `bonusFlyTimeUnit` `bonusFlyTimeUnit` ENUM('0','1') NOT NULL DEFAULT '0',
	CHANGE `bonusFleetSlotsUnit` `bonusFleetSlotsUnit` ENUM('0','1') NOT NULL DEFAULT '0',
	CHANGE `bonusPlanetsUnit` `bonusPlanetsUnit` ENUM('0','1') NOT NULL DEFAULT '0',
	CHANGE `bonusSpyPowerUnit` `bonusSpyPowerUnit` ENUM('0','1') NOT NULL DEFAULT '0',
	CHANGE `bonusExpeditionUnit` `bonusExpeditionUnit` ENUM('0','1') NOT NULL DEFAULT '0',
	CHANGE `bonusGateCoolTimeUnit` `bonusGateCoolTimeUnit` ENUM('0','1') NOT NULL DEFAULT '0',
	CHANGE `bonusMoreFoundUnit` `bonusMoreFoundUnit` ENUM('0','1') NOT NULL DEFAULT '0';
	
ALTER TABLE prefix_vars 
	ADD `consumption1901` INT UNSIGNED NULL DEFAULT NULL AFTER `cost921`,
	ADD `consumption1902` INT UNSIGNED NULL DEFAULT NULL AFTER `consumption1901`,
	ADD `consumption1921` INT UNSIGNED NULL DEFAULT NULL AFTER `consumption1903`,
	ADD `consumption2901` INT UNSIGNED NULL DEFAULT NULL AFTER `consumption1921`,
	ADD `consumption2902` INT UNSIGNED NULL DEFAULT NULL AFTER `consumption2901`,
	ADD `consumption2921` INT UNSIGNED NULL DEFAULT NULL AFTER `consumption2903`,
	ADD `consumption3901` INT UNSIGNED NULL DEFAULT NULL AFTER `consumption2921`,
	ADD `consumption3902` INT UNSIGNED NULL DEFAULT NULL AFTER `consumption3901`,
	ADD `consumption3903` INT UNSIGNED NULL DEFAULT NULL AFTER `consumption3902`,
	ADD `consumption3921` INT UNSIGNED NULL DEFAULT NULL AFTER `consumption3903`;
	
ALTER TABLE prefix_vars MODIFY COLUMN `speed1Tech` INT( 10 ) UNSIGNED NULL DEFAULT NULL AFTER speed1;
UPDATE prefix_vars SET `flagBuildOnPlanet` = '1', `flagBuildOnMoon` = '1' WHERE onPlanetType = '1,3';
UPDATE prefix_vars SET `flagBuildOnPlanet` = '1' WHERE onPlanetType = '1';
UPDATE prefix_vars SET `flagBuildOnMoon` = '1' WHERE onPlanetType = '3';
UPDATE prefix_vars SET `maxLevel` = '1' WHERE onePerPlanet = '1';
UPDATE prefix_vars SET `maxLevel` = '0' WHERE `maxLevel` = '255';
UPDATE prefix_vars SET `queueId` = '1001' WHERE `class` = '0';
UPDATE prefix_vars SET `queueId` = '1002' WHERE `class` = '100';
UPDATE prefix_vars SET `queueId` = '1003' WHERE `class` = '200';
UPDATE prefix_vars SET `queueId` = '1003' WHERE `class` = '400';
UPDATE prefix_vars SET `queueId` = '1003' WHERE `class` = '500';
UPDATE prefix_vars SET `bonusResource901` = '0.02' WHERE `elementID` = '131';
UPDATE prefix_vars SET `bonusResource902` = '0.02' WHERE `elementID` = '132';
UPDATE prefix_vars SET `bonusResource903` = '0.02' WHERE `elementID` = '133';
UPDATE prefix_vars SET `flagColonize` = '1' WHERE `elementID` = '208';
UPDATE prefix_vars SET `flagCollect` = '1' WHERE `elementID` = '209';
UPDATE prefix_vars SET `flagSpy` = '1' WHERE `elementID` = '210';
UPDATE prefix_vars SET `flagCollect` = '1' WHERE `elementID` = '219';
UPDATE prefix_vars SET `flagSpecExpedition` = '1' WHERE `elementID` = '220';
UPDATE prefix_vars SET `flagTrade` = '1' WHERE elementID IN (202, 401);
	
ALTER TABLE `prefix_vars` 
	DROP `onePerPlanet`,
	DROP `onPlanetType`,
	DROP `speedFleetFactor`,
	DROP `bonusEnergy`,
	DROP `bonusEnergyUnit`;
	
	
INSERT INTO `prefix_vars` SET 
	`elementID` = '901', `name` = 'metal', `class` = '900',
	`factor` = '0', `flagDebris` = '1', `flagTransport` = '1',
	`flagSteal` = '1', `flagTopNav` = '1', `resourceMode` = 'planet',
	`flagTrade` = '1', `flagOnEcoOverview` = '1', `flagCalculateBuildTime` = '1',
	`flagCalculateFleetStructure` = '1';
	
INSERT INTO `prefix_vars` SET 
	`elementID` = '902', `name` = 'crystal', `class` = '900',
	`factor` = '0', `flagDebris` = '1', `flagTransport` = '1',
	`flagSteal` = '1', `flagTopNav` = '1', `resourceMode` = 'planet',
	`flagTrade` = '1', `flagOnEcoOverview` = '1', `flagCalculateBuildTime` = '1',
	`flagCalculateFleetStructure` = '1';
	
INSERT INTO `prefix_vars` SET 
	`elementID` = '903', `name` = 'deuterium', `class` = '900',
	`factor` = '0', `flagDebris` = '0', `flagTransport` = '1',
	`flagSteal` = '1', `flagTopNav` = '1', `resourceMode` = 'planet',
	`flagTrade` = '1', `flagOnEcoOverview` = '1', `flagCalculateBuildTime` = '0';
	
INSERT INTO `prefix_vars` SET 
	`elementID` = '911', `name` = 'energy', `class` = '900',
	`factor` = '0', `flagTopNav` = '1', `resourceMode` = 'energy',
	`flagOnEcoOverview` = '1';
	
INSERT INTO `prefix_vars` SET 
	`elementID` = '921', `name` = 'darkmatter', `class` = '900',
	`factor` = '0', `flagTopNav` = '1', `resourceMode` = 'user',
	`flagOnEcoOverview` = '1';
	
INSERT INTO `prefix_vars` SET 
	`elementID` = '1001', `name` = 'buildQueue', `class` = '1000',
	`factor` = '0', `maxLevel` = '5';
	
INSERT INTO `prefix_vars` SET 
	`elementID` = '1002', `name` = 'techQueue', `class` = '1000',
	`factor` = '0', `maxLevel` = '2';
	
INSERT INTO `prefix_vars` SET 
	`elementID` = '1003', `name` = 'shipyardQueue', `class` = '1000',
	`factor` = '0', `maxLevel` = '10';