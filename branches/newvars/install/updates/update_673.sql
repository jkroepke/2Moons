ALTER TABLE `prefix_users` ADD `b_tech` INT( 11 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `b_tech_planet`, ADD `b_tech_id` TINYINT( 3 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `b_tech`;
-- ALTER TABLE `uni1_planets` DROP `b_tech`, DROP `b_tech_id`; 
-- Update_673.php ausführen!