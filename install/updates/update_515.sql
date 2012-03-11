CREATE TABLE `prefix_diplo` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `owner_1` int(11) NOT NULL,
 `owner_2` int(11) NOT NULL,
 `level` tinyint(1) NOT NULL,
 `accept` tinyint(1) NOT NULL,
 `accept_text` varchar(255) NOT NULL,
 PRIMARY KEY (`id`),
 KEY `owner_1` (`owner_1`,`owner_2`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
ALTER TABLE `prefix_alliance` ADD `ally_diplo` TINYINT( 1 ) NOT NULL DEFAULT '1';
ALTER TABLE `prefix_users` ADD `settings_tnstor` TINYINT( 1 ) NOT NULL DEFAULT '1' AFTER `settings_rep`;
ALTER TABLE `prefix_users` CHANGE `design` `design` TINYINT( 1 ) NOT NULL DEFAULT '1',
CHANGE `noipcheck` `noipcheck` TINYINT( 1 ) NOT NULL DEFAULT '1',
CHANGE `spio_anz` `spio_anz` TINYINT( 2 ) NOT NULL DEFAULT '1',
CHANGE `settings_tooltiptime` `settings_tooltiptime` TINYINT( 1 ) NOT NULL DEFAULT '5',
CHANGE `settings_fleetactions` `settings_fleetactions` TINYINT( 1 ) NOT NULL DEFAULT '0',
CHANGE `settings_planetmenu` `settings_planetmenu` TINYINT( 1 ) NOT NULL DEFAULT '1',
CHANGE `settings_esp` `settings_esp` TINYINT( 1 ) NOT NULL DEFAULT '1',
CHANGE `settings_wri` `settings_wri` TINYINT( 1 ) NOT NULL DEFAULT '1',
CHANGE `settings_bud` `settings_bud` TINYINT( 1 ) NOT NULL DEFAULT '1';