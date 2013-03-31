ALTER TABLE `prefix_config` ADD `sql_revision` INT NOT NULL DEFAULT  '0' AFTER `VERSION`;
INSERT INTO `prefix_cronjobs` (`cronjobID`, `name`, `isActive`, `min`, `hours`, `dom`, `month`, `dow`, `class`, `nextTime`, `lock`)
	VALUES (NULL, 'tracking', '1', FLOOR(RAND() * 60), FLOOR(RAND() * 24), '*', '*', '0', 'TrackingCronjob', NULL, NULL);