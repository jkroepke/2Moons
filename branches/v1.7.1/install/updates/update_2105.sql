ALTER TABLE `prefix_planets` CHANGE `energy_max` `energy` DOUBLE( 50, 0 ) UNSIGNED NOT NULL DEFAULT '0';

CREATE TABLE `prefix_fleet_event` (
 `fleetID` int(11) NOT NULL,
 `time` int(11) NOT NULL,
 `lock` varchar(32) DEFAULT NULL,
 PRIMARY KEY (`fleetID`),
 KEY `lock` (`lock`,`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `prefix_users_to_acs` (
 `userID` int(10) unsigned NOT NULL,
 `acsID` int(10) unsigned NOT NULL,
 KEY `userID` (`userID`),
 KEY `acsID` (`acsID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE prefix_fleets DROP INDEX fleet_mess;
ALTER TABLE prefix_fleets DROP INDEX fleet_target_owner;
ALTER TABLE prefix_fleets DROP INDEX fleet_universe;
ALTER TABLE prefix_fleets DROP INDEX fleet_end_id;
ALTER TABLE prefix_fleets DROP INDEX fleet_start_id;
ALTER TABLE prefix_fleets DROP INDEX fleet_start_time;
ALTER TABLE prefix_fleets DROP INDEX fleet_end_time;
ALTER TABLE prefix_fleets DROP INDEX fleet_end_stay;
ALTER TABLE prefix_fleets ADD INDEX ( `fleet_owner`, `fleet_mission` );
ALTER TABLE prefix_fleets ADD INDEX ( `fleet_target_owner`, `fleet_mission` );
ALTER TABLE prefix_fleets ADD INDEX ( `fleet_group` );

ALTER TABLE prefix_fleets CHANGE `fleet_group` `fleet_group` INT UNSIGNED NOT NULL DEFAULT '0';
ALTER TABLE prefix_aks DROP `eingeladen`;