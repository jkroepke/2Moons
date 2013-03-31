INSERT INTO prefix_config (`config_name`, `config_value`) VALUES ('fb_on', '0'), ('fb_apikey', ''), ('fb_skey', '');
ALTER TABLE prefix_users ADD `fb_id` VARCHAR( 15 ) NOT NULL DEFAULT '0';
ALTER TABLE prefix_users ADD INDEX (`fb_id`);