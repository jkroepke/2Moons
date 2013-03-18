ALTER TABLE prefix_planets CHANGE `mondbasis` `mondbasis` TINYINT( 3 ) UNSIGNED NOT NULL DEFAULT '0',
CHANGE `phalanx` `phalanx` TINYINT( 3 ) UNSIGNED NOT NULL DEFAULT '0',
CHANGE `sprungtor` `sprungtor` TINYINT( 3 ) UNSIGNED NOT NULL DEFAULT '0',
CHANGE `lune_noir` `lune_noir` BIGINT( 11 ) UNSIGNED NOT NULL DEFAULT '0',
CHANGE `ev_transporter` `ev_transporter` BIGINT( 11 ) UNSIGNED NOT NULL DEFAULT '0',
CHANGE `star_crasher` `star_crasher` BIGINT( 11 ) UNSIGNED NOT NULL DEFAULT '0',
CHANGE `giga_recykler` `giga_recykler` BIGINT( 11 ) UNSIGNED NOT NULL DEFAULT '0'