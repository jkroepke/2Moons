ALTER TABLE prefix_config 
	CHANGE ts_tcpport ts_tcpport SMALLINT( 5 ) UNSIGNED NOT NULL DEFAULT '0',
	CHANGE ts_udpport ts_udpport SMALLINT( 5 ) UNSIGNED NOT NULL DEFAULT '0';