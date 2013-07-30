ALTER TABLE  `prefix_config` DROP  `max_player_planets` ,
ADD  `planets_tech` TINYINT NOT NULL AFTER  `min_player_planets` ,
ADD  `planets_officier` TINYINT NOT NULL AFTER  `planets_tech` ,
ADD  `planets_per_tech` FLOAT( 2, 1 ) NOT NULL DEFAULT  '0.5' AFTER  `planets_officier` ;