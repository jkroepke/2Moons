ALTER TABLE prefix_buddy ADD `universe` TINYINT( 3 ) UNSIGNED NOT NULL, ADD INDEX (`universe`);
ALTER TABLE prefix_diplo ADD `universe` TINYINT( 3 ) UNSIGNED NOT NULL, ADD INDEX (`universe`);
ALTER TABLE prefix_notes ADD `universe` TINYINT( 3 ) UNSIGNED NOT NULL, ADD INDEX (`universe`);
ALTER TABLE prefix_supp ADD `universe` TINYINT( 3 ) UNSIGNED NOT NULL, ADD INDEX (`universe`);
UPDATE prefix_buddy SET `universe` = '1';
UPDATE prefix_diplo SET `universe` = '1';
UPDATE prefix_notes SET `universe` = '1';
UPDATE prefix_supp SET `universe` = '1';