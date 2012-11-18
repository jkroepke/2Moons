ALTER TABLE prefix_config CHANGE `ts_server` `ts_server` VARCHAR( 15 ) NOT NULL ,
CHANGE `smtp_host` `smtp_host` VARCHAR( 32 ) NOT NULL ,
CHANGE `smtp_user` `smtp_user` VARCHAR( 32 ) NOT NULL ,
CHANGE `smtp_pass` `smtp_pass` VARCHAR( 32 ) NOT NULL ,
CHANGE `smtp_sendmail` `smtp_sendmail` VARCHAR( 32 ) NOT NULL ,
CHANGE `ftp_server` `ftp_server` VARCHAR( 32 ) NOT NULL ,
CHANGE `ftp_user_name` `ftp_user_name` VARCHAR( 32 ) NOT NULL ,
CHANGE `ftp_user_pass` `ftp_user_pass` VARCHAR( 32 ) NOT NULL ,
CHANGE `ftp_root_path` `ftp_root_path` VARCHAR( 32 ) NOT NULL 