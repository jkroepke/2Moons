ALTER TABLE prefix_planets DROP `id_level`;
ALTER TABLE prefix_users ADD `authattack` ENUM( '0', '1', '2', '3' ) NOT NULL DEFAULT '0' AFTER `authlevel` 