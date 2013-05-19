ALTER TABLE prefix_config ADD `chat_closed` TINYINT( 1 ) NOT NULL, ADD `chat_allowchan` TINYINT( 1 ) NOT NULL, ADD `chat_allowmes` TINYINT( 1 ) NOT NULL, ADD `chat_allowdelmes` TINYINT( 1 ) NOT NULL, ADD `chat_logmessage` TINYINT( 1 ) NOT NULL, ADD `chat_nickchange` TINYINT( 1 ) NOT NULL, ADD `chat_botname` VARCHAR( 15 ) NOT NULL, ADD `chat_channelname` VARCHAR( 15 ) NOT NULL, ADD `chat_socket_active` TINYINT( 1 ) NOT NULL,ADD `chat_socket_host` VARCHAR( 64 ) NOT NULL, ADD `chat_socket_ip` VARCHAR( 40 ) NOT NULL, ADD `chat_socket_port` SMALLINT( 5 ) NOT NULL, ADD `chat_socket_chatid` TINYINT( 1 ) NOT NULL;
DROP TABLE IF EXISTS prefix_chat;
CREATE TABLE prefix_chat_online (
	userID INT(11) NOT NULL,
	userName VARCHAR(64) NOT NULL,
	userRole INT(1) NOT NULL,
	channel INT(11) NOT NULL,
	dateTime DATETIME NOT NULL,
	ip VARBINARY(16) NOT NULL
) DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE prefix_chat_messages (
	id INT(11) NOT NULL AUTO_INCREMENT,
	userID INT(11) NOT NULL,
	userName VARCHAR(64) NOT NULL,
	userRole INT(1) NOT NULL,
	channel INT(11) NOT NULL,
	dateTime DATETIME NOT NULL,
	ip VARBINARY(16) NOT NULL,
	text TEXT,
	PRIMARY KEY (id)
) DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE prefix_chat_bans (
	userID INT(11) NOT NULL,
	userName VARCHAR(64) NOT NULL,
	dateTime DATETIME NOT NULL,
	ip VARBINARY(16) NOT NULL
) DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE prefix_chat_invitations (
	userID INT(11) NOT NULL,
	channel INT(11) NOT NULL,
	dateTime DATETIME NOT NULL
) DEFAULT CHARSET=utf8 COLLATE=utf8_bin;