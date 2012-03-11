ALTER TABLE prefix_config CHANGE `forum_url` `forum_url` VARCHAR( 128 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE prefix_config CHANGE `smtp_host` `smtp_host` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE prefix_config CHANGE `smtp_sendmail` `smtp_sendmail` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE prefix_config CHANGE `smtp_user` `smtp_user` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE prefix_config CHANGE `ts_server` `ts_server` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE prefix_config CHANGE `ftp_server` `ftp_server` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE prefix_config CHANGE `ftp_user_name` `ftp_user_name` VARCHAR( 128 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE prefix_config CHANGE `ftp_root_path` `ftp_root_path` VARCHAR( 128 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;