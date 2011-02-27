ALTER TABLE prefix_planets CHANGE `energy_used` `energy_used` BIGINT( 20 ) UNSIGNED NOT NULL DEFAULT '0',
CHANGE `energy_max` `energy_max` BIGINT( 20 ) UNSIGNED NOT NULL DEFAULT '0'