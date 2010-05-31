<?PHP
/**
 *                            ts3admin.class.php							<br />
 *                            ------------------							<br />
 *   begin                : Saturday, Dec 19, 2009							<br />
 *   copyright            : (C) 2009-2010 Par0nid Solutions					<br />
 *   email                : webmaster@par0noid.de							<br />
 *   version              : 0.1.4											<br />
 *   last modified        : Monday, Dec 28, 2009							<br />
 *
 * @author	Par0noid Solutions <webmaster@par0noid.de>
 * @copyright	Copyright (c) 2009-2010, Stefan Z.
 * @version	0.1.4
 

    This file is a powerful library for querying TeamSpeak3 servers.<br />																			
    Ts3Admin is free software; you can redistribute it and/or modify			
    it under the terms of the GNU General Public License as published by	
    the Free Software Foundation version 1.3.										

*/
/**/

/**
 * @package TS3Admin
 */

class ts3admin{

//*******************************************************************************************	
//****************************************** Vars *******************************************
//*******************************************************************************************

	// The Teamspeak-Host Socket
	private $socket;
	
	// Boolean to check if the user has selected as virtual server
	private $selected = false;
		
	// The teamspeak host
	private $host;
	
	// The teamspeak host-queryport
	private $queryport;
	
	// Socket timeout in seconds
	private $timeout;
	
	// Debug String
	private $debug = "";


//*******************************************************************************************	
//************************************ Public Functions *************************************
//*******************************************************************************************

/**
  * login: verifies your logindata and grant additional access if true
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string	$username	username
  * @param		string	$password	password
  * @return     boolean success
  */
	function login($username, $password) {
		$bool = $this->executeWithoutFetch("login $username $password");
		return $bool;
	}

/**
  * logout: deselects the selected virtual server and log out the user
  *
  * @author     Par0noid Solutions
  * @access		public
  * @return     boolean success
  */
	function logout() {
		$bool = $this->executeWithoutFetch("logout");
		if($bool) {
			$this->selected = false;
		}else{
			$this->selected = false;
		}
		return $bool;
	}

/**
  * quit: closes the connection to host 
  *
  * @author     Par0noid Solutions
  * @access		public
  */
	function quit() {
		@fclose($this->socket);
	}

/**
  * selectServer: selects a virtual server
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer	$serverID	ServerID
  * @return     boolean success
  */
	function selectServer($serverID) {
		$bool = $this->executeWithoutFetch("use $serverID");
		if($bool) {
			$this->selected = true;
		}else{
			$this->selected = false;
		}
		return $this->selected;
	}

/**
  * selectServerByPort: selects a virtual server
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer	$port	Serverport
  * @return     boolean success
  */
	function selectServerByPort($port) {
		$bool = $this->executeWithoutFetch("use port=$port");
		if($bool) {
			$this->selected = true;
		}else{
			$this->selected = false;
		}
		return $this->selected;
	}

/**
  * serverInfo: returns all information about the selected virtual server
  *	
  *	Output:<br />
  *
  *	Array<br />
  *   (<br />
  *    [virtualserver_unique_identifier] => *REMOVED*<br />
  *    [virtualserver_name] => MyTeamspeak<br />
  *    [virtualserver_welcomemessage] => <br />
  *    [virtualserver_platform] => Linux<br />
  *    [virtualserver_version] => 3.0.0-beta2 [Build: 9398]<br />
  *    [virtualserver_maxclients] => 32<br />
  *    [virtualserver_password] => <br />
  *    [virtualserver_clientsonline] => 14<br />
  *    [virtualserver_channelsonline] => 16<br />
  *    [virtualserver_created] => 1261227506<br />
  *    [virtualserver_uptime] => 5137922<br />
  *    [virtualserver_hostmessage] => <br />
  *    [virtualserver_hostmessage_mode] => 0<br />
  *    [virtualserver_filebase] => files/virtualserver_1<br />
  *    [virtualserver_default_server_group] => 13<br />
  *    [virtualserver_default_channel_group] => 9<br />
  *    [virtualserver_flag_password] => 0<br />
  *    [virtualserver_default_channel_admin_group] => 9<br />
  *    [virtualserver_max_download_total_bandwidth] => 1<br />
  *    [virtualserver_max_upload_total_bandwidth] => 1<br />
  *    [virtualserver_hostbanner_url] => http://par0noid.de<br />
  *    [virtualserver_hostbanner_gfx_url] => http://par0niod.de/ts.jpg<br />
  *    [virtualserver_hostbanner_gfx_interval] => 0<br />
  *    [virtualserver_complain_autoban_count] => 5<br />
  *    [virtualserver_complain_autoban_time] => 1200<br />
  *    [virtualserver_complain_remove_time] => 3600<br />
  *    [virtualserver_min_clients_in_channel_before_forced_silence] => 100<br />
  *    [virtualserver_priority_speaker_dimm_modificator] => -18.0000<br />
  *    [virtualserver_id] => 1<br />
  *    [virtualserver_antiflood_points_tick_reduce] => 5<br />
  *    [virtualserver_antiflood_points_needed_warning] => 150<br />
  *    [virtualserver_antiflood_points_needed_kick] => 250<br />
  *    [virtualserver_antiflood_points_needed_ban] => 350<br />
  *    [virtualserver_antiflood_ban_time] => 300<br />
  *    [virtualserver_client_connections] => 21<br />
  *    [virtualserver_query_client_connections] => 44<br />
  *    [virtualserver_hostbutton_tooltip] => <br />
  *    [virtualserver_hostbutton_url] => <br />
  *    [virtualserver_queryclientsonline] => 1<br />
  *    [virtualserver_download_quota] => 18446744073709551615<br />
  *    [virtualserver_upload_quota] => 18446744073709551615<br />
  *    [virtualserver_month_bytes_downloaded] => 0<br />
  *    [virtualserver_month_bytes_uploaded] => 0<br />
  *    [virtualserver_total_bytes_downloaded] => 0<br />
  *    [virtualserver_total_bytes_uploaded] => 0<br />
  *    [virtualserver_port] => 9987<br />
  *    [virtualserver_autostart] => 1<br />
  *    [virtualserver_machine_id] => <br />
  *    [virtualserver_needed_identity_security_level] => 8<br />
  *    [virtualserver_status] => online<br />
  *    [connection_filetransfer_bandwidth_sent] => 0<br />
  *    [connection_filetransfer_bandwidth_received] => 0<br />
  *    [connection_packets_sent_total] => 939644<br />
  *    [connection_bytes_sent_total] => 149550373<br />
  *    [connection_packets_received_total] => 524892<br />
  *    [connection_bytes_received_total] => 53636234<br />
  *    [connection_bandwidth_sent_last_second_total] => 39674<br />
  *    [connection_bandwidth_sent_last_minute_total] => 35271<br />
  *    [connection_bandwidth_received_last_second_total] => 17416<br />
  *    [connection_bandwidth_received_last_minute_total] => 15143<br />
  * }
  *
  * @author     Par0noid Solutions
  * @access		public
  * @return     array server information
  */
	function serverInfo() {
		if(!$this->selected) {
			$this->debug .= "Error in serverInfo(): you have to select a server befor using serverInfo()<br>";
			return false;
		}
		return $this->getSimpleData("serverinfo");
	}
	
/**
  * instanceInfo: returns all information about the teamspeak instance
  *
  * Output:<br>
  *
  * Array<br>
  *   {<br>
  *    [serverinstance_database_version] => 11<br>
  *    [serverinstance_filetransfer_port] => 30033<br>
  *    [serverinstance_guest_serverquery_group] => 1<br>
  *    [serverinstance_template_serveradmin_group] => 3<br>
  *    [serverinstance_max_download_total_bandwidth] => 3<br>
  *    [serverinstance_max_upload_total_bandwidth] => 3<br>
  * }
  *
  * @author     Par0noid Solutions
  * @access		public
  * @return     array instance information
  */
	function instanceInfo() {
		return $this->getSimpleData("instanceinfo");
	}
	
/**
  * hostInfo: returns all information about the connected host
  *
  * Output:<br>
  *
  * Array<br>
  *   {<br>
  *    [instance_uptime] => 6234055<br>
  *    [host_timestamp_utc] => 1261342807<br>
  *    [virtualservers_running_total] => 1<br>
  *    [connection_filetransfer_bandwidth_sent] => 0<br>
  *    [connection_filetransfer_bandwidth_received] => 0<br>
  *    [connection_packets_sent_total] => 1054187<br>
  *    [connection_bytes_sent_total] => 169055523<br>
  *    [connection_packets_received_total] => 610407<br>
  *    [connection_bytes_received_total] => 61447430<br>
  *    [connection_bandwidth_sent_last_second_total] => 25003<br>
  *    [connection_bandwidth_sent_last_minute_total] => 12657<br>
  *    [connection_bandwidth_received_last_second_total] => 14636<br>
  *    [connection_bandwidth_received_last_minute_total] => 5541<br>
  * }
  *
  * @author     Par0noid Solutions
  * @access		public
  * @return     array host information
  */
	function hostInfo() {
		return $this->getSimpleData("hostinfo");
	}

/**
  * clientInfo: returns all information about a client
  *
  * Output:<br>
  *
  * Array<br>
  * {<br>
  *  [client_unique_identifier] => *REMOVED*<br>
  *  [client_nickname] => Par0noid<br>
  *  [client_version] => 3.0.0-beta2 [Build: 9400]<br>
  *  [client_platform] => Windows<br>
  *  [client_input_muted] => 0<br>
  *  [client_output_muted] => 0<br>
  *  [client_outputonly_muted] => 0<br>
  *  [client_input_hardware] => 1<br>
  *  [client_output_hardware] => 1<br>
  *  [client_default_channel] => <br>
  *  [client_meta_data] => <br>
  *  [client_is_recording] => 0<br>
  *  [client_login_name] => <br>
  *  [client_database_id] => 2<br>
  *  [client_channel_group_id] => 5<br>
  *  [client_servergroups] => 6<br>
  *  [client_created] => 1261227544<br>
  *  [client_lastconnected] => 1261336673<br>
  *  [client_totalconnections] => 43<br>
  *  [client_away] => 0<br>
  *  [client_away_message] =><br> 
  *  [client_type] => 0<br>
  *  [client_flag_avatar] => *REMOVED*<br>
  *  [client_talk_power] => 75<br>
  *  [client_talk_request] => 0<br>
  *  [client_talk_request_msg] => <br>
  *  [client_description] => <br>
  *  [client_is_talker] => 0<br>
  *  [client_month_bytes_uploaded] => 0<br>
  *  [client_month_bytes_downloaded] => 0<br>
  *  [client_total_bytes_uploaded] => 0<br>
  *  [client_total_bytes_downloaded] => 0<br>
  *  [client_is_priority_speaker] => 0<br>
  *  [client_unread_messages] => 0<br>
  *  [client_nickname_phonetic] => <br>
  *  [client_needed_serverquery_view_power] => 75<br>
  *  [client_base64HashClientUID] => *REMOVED*<br>
  *  [connection_filetransfer_bandwidth_sent] => 0<br>
  *  [connection_filetransfer_bandwidth_received] => 0<br>
  *  [connection_packets_sent_total] => 67402<br>
  *  [connection_bytes_sent_total] => 8956475<br>
  *  [connection_packets_received_total] => 51658<br>
  *  [connection_bytes_received_total] => 6359284<br>
  *  [connection_bandwidth_sent_last_second_total] => 79<br>
  *  [connection_bandwidth_sent_last_minute_total] => 80<br>
  *  [connection_bandwidth_received_last_second_total] => 81<br>
  *  [connection_bandwidth_received_last_minute_total] => 81<br>
  * }
  *
  * @author     Par0noid Solutions
  * @access		public
  * @return     array client information
  */
	function clientInfo($cid) {
		if(!$this->selected) { 
			$this->debug .= "Error in clientInfo(): you have to select a server befor using clientInfo()<br>";
			return false;
		}
		return $this->getSimpleData("clientinfo clid=$cid");
	}
	
/**
  * clientList: returns all online clients on the selected virtual server
  *
  * Output:<br>
  *
  * Array<br>
  * {<br>
  *  [clid] => 1<br>
  *	 [cid] => 8<br>
  *	 [client_database_id] => 18<br>
  *	 [client_nickname] => par0noid<br>
  *	 [client_type] => 0<br>
  * }
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string $params Additional parameters (optional)
  * @return     multidimensional array clientlist 
  */
	function clientList($params = "") {
		if(!$this->selected) { 
			$this->debug .= "Error in clientList(): you have to select a server befor using clientList()<br>"; 
			return false;
		}
		if(!empty($params)) { $params = ' '.$params; }
		return $this->getExtendData("clientlist".$params);
	}
	
/**
  * clientDbList: returns all clients from db<br>
  *		Note: login needed
  *
  * Output:<br>
  *
  * Array<br>
  * {<br>
  *  [cldbid] => 2<br>
  *  [client_unique_identifier] => *REMOVED*<br>
  *  [client_nickname] => Par0noid<br>
  *  [client_created] => 1261227544<br>
  *  [client_lastconnected] => 1261336673<br>
  *  [client_description] => <br>
  * }
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string $params Additional parameters (optional)
  * @return     multidimensional array clientdblist
  */
	function clientDbList($params = "") {
		if(!$this->selected) { 
			$this->debug .= "Error in clientDbList(): you have to select a server befor using clientDbList()<br>";
			return false;
		}
		if(!empty($params)) { $params = ' '.$params; }
		return $this->getExtendData("clientdblist".$params);
	}

/**
  * clientPoke: pokes a client on the selected server<br>
  *		Note: login needed
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $clid The clientID
  * @param		string $msg The Message
  * @return     boolean success
  */
	function clientPoke($clid, $msg) {
		if(!$this->selected) { 
			$this->debug .= "Error in clientPoke(): you have to select a server befor using clientPoke()<br>";
			return false;
		}
		return $this->executeWithoutFetch("clientpoke clid=$clid msg=".$this->implodeText($msg));
	}

/**
  * clientMove: moves a client on the selected server<br>
  *		Note: login needed
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $clid The clientID
  * @param		integer $cid The channelID
  * @return     boolean success
  */
	function clientMove($clid, $cid) {
		if(!$this->selected) { 
			$this->debug .= "Error in clientMove(): you have to select a server befor using clientMove()<br>";
			return false;
		}
		return $this->executeWithoutFetch("clientmove clid=$clid cid=$cid");
	}

/**
  * clientKick: kicks a client from the selected server<br>
  *		Note: login needed
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $clid The clientID
  * @param		integer $from From "server"=5 or "channel"=4
  * @param		string $kickmsg Kick reason (optional)
  * @return     boolean success
  */
	function clientKick($clid, $from, $kickmsg = "") {
		if(!$this->selected) { 
			$this->debug .= "Error in clientKick(): you have to select a server befor using clientKick()<br>";
			return false;
		}
		if($from == 5 or $from == 4) {
			if(!empty($kickmsg)) { $msg = ' reasonmsg='.$this->implodeText($kickmsg); } else{ $msg = ''; }
			return $this->executeWithoutFetch("clientkick clid=$clid reasonid=".$from.$msg);
		}else{
			return false;
		}
	}

/**
  * clientBan: bans a client from the selected server<br>
  *		Note: login needed
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $clid The clientID
  * @param		integer $time Bantime in seconds (0=unlimited)
  * @param		string $banreason Kick reason (optional)
  * @return     boolean success
  */
	function clientBan($clid, $time, $banreason = "") {
		if(!$this->selected) { 
			$this->debug .= "Error in clientBan(): you have to select a server befor using clientBan()<br>";
			return false;
		}
		if(!empty($banreason)) { $msg = ' banreason='.$this->implodeText($banreason); } else{ $msg = ''; }
		fputs($this->socket, "banclient clid=$clid time=$time".$msg."\n");
		if(strpos(fgets($this->socket), 'banid=') !== false) {
			return true;
		}else{
			return false;
		}
	}

/**
  * setName: sets your nickname in server query
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string $newName Your new name
  * @return     boolean success
  */
	function setName($newName) {
		return $this->executeWithoutFetch("clientupdate client_nickname=".$this->implodeText($newName));
	}

/**
  * channelList: returns information about all channels on the selected server
  *
  * Output:<br>
  *
  * Array<br>
  * {<br>
  *  [cid] => 3<br>
  *  [pid] => 0<br>
  *  [channel_order] => 1<br>
  *  [channel_name] => ==>Lobby <==<br>
  *  [total_clients] => 0<br>
  *  [channel_needed_subscribe_power] => 0<br>
  * }
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string $params Additional parameters (optional)
  * @return     multidimensional array data
  */
	function channelList($params = "") {
		if(!$this->selected) { 
			$this->debug .= "Error in channelList(): you have to select a server befor using channelList()<br>";
			return false;
		}
		if(!empty($params)) { $params = ' '.$params; }
		return $this->getExtendData("channellist".$params);
	}
	
/**
  * channelInfo: returns informations about a channel
  *
  * Output:<br>
  *
  * Array<br>
  * {<br>
  *  [channel_name] => .# Talk 2<br>
  *  [channel_topic] => <br>
  *  [channel_description] => <br>
  *  [channel_password] => *REMOVED*<br>
  *  [channel_codec] => 2<br>
  *  [channel_codec_quality] => 10<br>
  *  [channel_maxclients] => -1<br>
  *  [channel_maxfamilyclients] => -1<br>
  *  [channel_order] => 7<br>
  *  [channel_flag_permanent] => 1<br>
  *  [channel_flag_semi_permanent] => 0<br>
  *  [channel_flag_default] => 0<br>
  *  [channel_flag_password] => 0<br>
  *  [channel_flag_maxclients_unlimited] => 1<br>
  *  [channel_flag_maxfamilyclients_unlimited] => 0<br>
  *  [channel_flag_maxfamilyclients_inherited] => 1<br>
  *  [channel_filepath] => files/virtualserver_1/channel_8<br>
  *  [channel_needed_talk_power] => 0<br>
  *  [channel_forced_silence] => 0<br>
  *  [channel_name_phonetic] => <br>
  * }
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $cid channelID
  * @return     array channelinformation
  */
	function channelInfo($cid) {
		if(!$this->selected) { 
			$this->debug .= "Error in channelInfo(): you have to select a server befor using channelInfo()<br>";
			return false;
		}
		return $this->getSimpleData("channelinfo cid=$cid");
	}
	
/**
  * whoAmI: returns informations about you
  *
  * Output:<br>
  *
  * Array<br>
  * {<br>
  *  [virtualserver_status] => online<br>
  *  [virtualserver_id] => 1<br>
  *  [virtualserver_unique_identifier] => *REMOVED*<br>
  *  [client_channel_id] => 1<br>
  *  [client_nickname] => par0noid from 127.0.0.1:52884<br>
  *  [client_database_id] => 2<br>
  *  [client_login_name] => par0noid<br>
  *  [client_unique_identifier] => *REMOVED*<br>
  * }
  *
  * @author     Par0noid Solutions
  * @access		public
  * @return     array clientinformation
  */
	function whoAmI() {
		return $this->getSimpleData("whoami");
	}

/**
  * banList: returns all bans on selected server
  *
  * Output:<br>
  *
  * Array<br>
  * {<br>
  * [banid] => 19<br>
  * [ip] => 1.2.3.4<br>
  * [created] => 1261363073<br>
  * [invokername] => Par0noid<br>
  * [invokercldbid] => 2<br>
  * [invokeruid] => *REMOVED*<br>
  * [reason] => insult<br>
  * [enforcements] => 0<br>
  * }
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string $params Additional parameters (optional)
  * @return     multidimensional array banliste
  */
	function banList($params = "") {
		if(!$this->selected) { 
			$this->debug .= "Error in banList(): you have to select a server befor using banList()<br>";
			return false;
		}
		if(!empty($params)) { $params = ' '.$params; }
		return $this->getExtendData("banlist".$params);
	}

/**
  * banDelete: deletes a ban from banlist<br>
  *		Note: login needed
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $banID The banID
  * @return     boolean success
  */
	function banDelete($banID) {
		if(!$this->selected) { 
			$this->debug .= "Error in banDelete(): you have to select a server befor using banDelete()<br>";
			return false;
		}
		return $this->executeWithoutFetch("bandel banid=$banID");
	}

/**
  * banDeleteAll: deletes all bans from banlist<br>
  *		Note: login needed
  *
  * @author     Par0noid Solutions
  * @access		public
  * @return     boolean success
  */
	function banDeleteAll() {
		if(!$this->selected) { 
			$this->debug .= "Error in banDeleteAll(): you have to select a server befor using BanDeleteAll()<br>";
			return false;
		}
		return $this->executeWithoutFetch("bandelall");
	}
	
/**
  * serverList: returns all server data from selected instance
  *
  * Output:<br>
  *
  * Array<br>
  * {<br>
  *  [virtualserver_id] => 2<br>
  *  [virtualserver_port] => 9988<br>
  *  [virtualserver_status] => online<br>
  *  [virtualserver_clientsonline] => 0<br>
  *  [virtualserver_queryclientsonline] => 0<br>
  *  [virtualserver_maxclients] => 32<br>
  *  [virtualserver_uptime] => 150<br>
  *  [virtualserver_name] => Testserver<br>
  *  [virtualserver_autostart] => 1<br>
  *  [virtualserver_machine_id] => <br>
  * }
  *
  * @author     Par0noid Solutions
  * @access		public
  * @return     multidimensional array serverlist
  */
	function serverList($params = "") {
		if(!empty($params)) { $params = ' '.$params; }
		return $this->getExtendData("serverlist".$params);
	}

/**
  * serverCreate: creates a server on the selected instance<br>
  *		Note: superAdmin login needed
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string $server_name Name of the virtual Server
  * @param		integer $maxslots Slots
  * @param		integer $port Virutalserver Port
  * @return     string token
  */
	function serverCreate($server_name, $maxslots, $port) {
		$ret = $this->getSimpleData("servercreate virtualserver_name=".$this->implodeText($server_name)." virtualserver_maxclients=$maxslots virtualserver_port=$port");
		if($ret !== false) {
			return $ret['token'];
		}else{
			return false;
		}
	}
	
/**
  * serverDelete: deletes a server on the selected instance<br>
  *		Note: superAdmin login needed
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $sid The serverID
  * @return     boolean success
  */
	function serverDelete($sid) {
		$this->serverStop($sid);
		return $this->executeWithoutFetch("serverdelete sid=$sid");
	}
	
/**
  * serverStart: starts a server on the selected instance<br>
  *		Note: superAdmin login needed
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $sid The serverID
  * @return     boolean success
  */
	function serverStart($sid) {
		return $this->executeWithoutFetch("serverstart sid=$sid");
	}	

/**
  * serverStop: stops a server on the selected instance<br>
  *		Note: superAdmin login needed
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $sid The serverID
  * @return     boolean success
  */
	function serverStop($sid) {
		return $this->executeWithoutFetch("serverstop sid=$sid");
	}

/**
  * getServerIdByPort: returns the serverID which has the selected port
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $port Virutalserver Port
  * @return     integer serverID
  */
	function getServerIdByPort($port) {
		$ret = $this->getSimpleData("serveridgetbyport virtualserver_port=$port");
		if($ret !== false) {
			return $ret['server_id'];
		}else{
			return false;
		}
	}
	
/**
  * serverEdit: edits serversettings on selected virtualserver<br>
  *		Note: login needed / for some settings superAdmin login
  *
  *	Howto edit:<br>
  *	<br>
  *	$newSettings = array();<br>
  *	<br>
  * $newSettings[] = array('setting', 'value');<br>
  * $newSettings[] = array('setting', 'value');<br>
  *	<br>
  * serverEdit($newSettings);<br>
  * <br>
  * server must be selected serverSelect();<br>
  * <br>
  * <br>
  * <br>
  * Possible:<br>
  * <br>
  * name<br>
  * welcomemessage<br>
  * maxclients<br>
  * password<br>
  * default_servergroup<br>
  * default_channelgroup<br>
  * default_channeladmingroup<br>
  * ft_settings<br>
  * ft_quotas<br>
  * channel_forced_silence<br>
  * complain<br>
  * antiflood<br>
  * hostmessage<br>
  * hostbanner<br>
  * hostbutton<br>
  * port<br>
  * autostart<br>
  * needed_identity_security_level
  *
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		multiarray $newSettings Server setting
  * @return     boolean success
  */
	function serverEdit($newSettings) {
		if(!$this->selected) { 
			$this->debug .= "Error in serverEdit(): you have to select a server befor using serverEdit()<br>";
			return false;
		}
		
		$settingsString = '';
		
		foreach($newSettings as $setting) {
			$settingsString .= ' virtualserver_'.$setting[0].'='.$this->implodeText($setting[1]);
		}
		
		return $this->executeWithoutFetch("serveredit".$settingsString);
	}

/**
  * serverRequestConnectionInfo: displays detailed connection information about the selected virtual server
  *
  * Output:<br>
  *
  * Array<br>
  * {<br>
  *  [connection_filetransfer_bandwidth_sent] => 0<br>
  *  [connection_filetransfer_bandwidth_received] => 0<br>
  *  [connection_packets_sent_total] => 136821<br>
  *  [connection_bytes_sent_total] => 22294391<br>
  *  [connection_packets_received_total] => 203748<br>
  *  [connection_bytes_received_total] => 18779824<br>
  *  [connection_bandwidth_sent_last_second_total] => 3727<br>
  *  [connection_bandwidth_sent_last_minute_total] => 5242<br>
  *  [connection_bandwidth_received_last_second_total] => 971<br>
  *  [connection_bandwidth_received_last_minute_total] => 2712<br>
  *  [connection_connected_time] => 8038331<br>
  * }
  *
  * @author     Par0noid Solutions
  * @access		public
  * @return     array serverrequestconnectioninfo
  */
	function serverRequestConnectionInfo() {
		if(!$this->selected) { 
			$this->debug .= "Error in serverRequestConnectionInfo(): you have to select a server befor using serverRequestConnectionInfo()<br>";
			return false;
		}
		return $this->getSimpleData("serverrequestconnectioninfo");
	}
	
/**
  * sendMessage: sends a text message a specified target
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $mode 3-1 {3: server| 2: channel|1: client}
  * @param		integer $target {serverID|channelID|clientID}
  * @param		string $msg The message
  * @return     boolean success
  */
	function sendMessage($mode, $target, $msg) {
		if($mode != "3" && !$this->selected) {
			$this->debug .= "Error in sendMessage(): you have to select a server befor using sendMessage() in mode 1 or 2<br>";
			return false;
		}
		return $this->executeWithoutFetch("sendtextmessage targetmode=$mode target=$target msg=".$this->implodeText($msg));
	}

/**
  * gm: sends a text message to all clients on all virtual servers in the TeamSpeak 3 Server instance
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string $msg The message
  * @return     boolean success
  */
	function gm($msg) {
		return $this->executeWithoutFetch("gm msg=".$this->implodeText($msg));
	}
	
/**
  * version: displays the servers version information including platform and build number
  *
  * Output:<br>
  *
  * Array<br>
  * {<br>
  *  [version] => 3.0.0-beta9<br>
  *  [build] => 9527<br>
  *  [platform] => Linux<br>
  * }
  *
  * @author     Par0noid Solutions
  * @access		public
  * @return     array versioninformation
  */
	function version() {
		return $this->getSimpleData("version");
	}

/**
  * permissionlist: displays a list of permissions available on the server instance including ID, name and description
  *
  * Output:<br>
  *
  * Array<br>
  * {<br>
  *  [permid] => 4353<br>
  *  [permname] => b_serverinstance_help_view<br>
  *  [permdesc] => Read ServerQuery help files<br>
  * }
  *
  * @author     Par0noid Solutions
  * @access		public
  * @return     array versioninformation
  */
	function permissionlist() {
		if(!$this->selected) { 
			$this->debug .= "Error in permissionlist(): you have to select a server befor using permissionlist()<br>";
			return false;
		}
		return $this->getExtendData("permissionlist");
	}

/**
  * complainList: displays a list of complaints on the selected virtual server<br>
  *				  If "tcldbid" is specified, only complaints about the targeted client will be shown.
  *
  * Output:<br>
  *
  * Array<br>
  * {<br>
  *  [tcldbid] => 28<br>
  *  [tname] => Testuser<br>
  *  [fcldbid] => 2<br>
  *  [fname] => Par0noid<br>
  *  [message] => insult<br>
  *  [timestamp] => 1262028871<br>
  * }
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string $params Additional parameters (optional)
  * @return     multidimensional array complainlist
  */
	function complainList($params = "") {
		if(!$this->selected) { 
			$this->debug .= "Error in complainList(): you have to select a server befor using complainList()<br>";
			return false;
		}
		if(!empty($params)) { $params = ' '.$params; }
		return $this->getExtendData("complainlist".$params);
	}

/**
  * complainAdd: submits a complaint about the client with database ID tcldbid to the server<br>
  *		Note: login needed
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $tcldbid targetClientDBID
  * @param		string $msg Complainmessage
  * @return     boolean success
  */
	function complainAdd($tcldbid, $msg) {
		if(!$this->selected) { 
			$this->debug .= "Error in complainAdd(): you have to select a server befor using complainAdd()<br>";
			return false;
		}
		return $this->executeWithoutFetch("complainadd tcldbid=$tcldbid message=".$this->implodeText($msg));
	}

/**
  * complainDelete: deletes the complaint about the client with ID tcldbid submitted by the client with ID fcldbid from the server<br>
  *		Note: login needed
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $tcldbid targetClientDBID
  * @param		integer $fcldbid fromClientDBID
  * @return     boolean success
  */
	function complainDelete($tcldbid, $fcldbid) {
		if(!$this->selected) { 
			$this->debug .= "Error in complainDelete(): you have to select a server befor using complainDelete()<br>";
			return false;
		}
		return $this->executeWithoutFetch("complaindel tcldbid=$tcldbid fcldbid=$fcldbid");
	}

/**
  * complainDeleteAll: deletes all complaints about the client with database ID tcldbid from the server.<br>
  *		Note: login needed
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $tcldbid targetClientDBID
  * @return     boolean success
  */
	function complainDeleteAll($tcldbid) {
		if(!$this->selected) { 
			$this->debug .= "Error in complainDeleteAll(): you have to select a server befor using complainDeleteAll()<br>";
			return false;
		}
		return $this->executeWithoutFetch("complaindelall tcldbid=$tcldbid");
	}

/**
  * serverGroupList: displays a list of server groups available<br>
  *				     Depending on your permissions, the output may also contain global ServerQuery groups and template groups.<br><br>
  *		Note: login needed
  *
  * Output:<br>
  *
  * Array<br>
  * {<br>
  *  [sgid] => 3<br>
  *  [name] => Server Admin<br>
  *  [type] => 0<br>
  *  [iconid] => 300<br>
  *  [savedb] => 1<br>
  * }
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string $params Additional parameters (optional)
  * @return     multidimensional array servergrouplist
  */
	function serverGroupList($params = "") {
		if(!$this->selected) { 
			$this->debug .= "Error in serverGroupList(): you have to select a server befor using serverGroupList()<br>";
			return false;
		}
		if(!empty($params)) { $params = ' '.$params; }
		return $this->getExtendData("servergrouplist".$params);
	}

/**
  * serverGroupAdd: creates a new server group using the name specified with name and displays its ID<br>
  *		Note: login needed
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $name groupName
  * @return     boolean success
  */
	function serverGroupAdd($name) {
		if(!$this->selected) { 
			$this->debug .= "Error in serverGroupAdd(): you have to select a server befor using serverGroupAdd()<br>";
			return false;
		}
		$exec = $this->getSimpleData("servergroupadd name=".$this->implodeText($name));
		if($exec !== false) {
			return true;
		}else{
			return false;
		}
	}

/**
  * serverGroupDelete: Deletes the server group specified with sgid<br>
  *					   If force is set to 1, the server group will be deleted even if there are clients within.<br><br>
  *		Note: login needed
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $sgid groupID
  * @param		integer $force delete if clients are in there 1|0
  * @return     boolean success
  */
	function serverGroupDelete($sgid, $force) {
		if(!$this->selected) { 
			$this->debug .= "Error in serverGroupDelete(): you have to select a server befor using serverGroupDelete()<br>";
			return false;
		}
		return $this->executeWithoutFetch("servergroupdel sgid=$sgid force=$force");
	}

/**
  * serverGroupRename: changes the name of the server group specified with sgid<br>
  *		Note: login needed
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $sgid groupID
  * @param		integer $name groupName
  * @return     boolean success
  */
	function serverGroupRename($sgid, $name) {
		if(!$this->selected) { 
			$this->debug .= "Error in serverGroupRename(): you have to select a server befor using serverGroupRename()<br>";
			return false;
		}
		return $this->executeWithoutFetch("servergrouprename sgid=$sgid name=".$this->implodeText($name));
	}

/**
  * serverGroupPermList: displays a list of permissions assigned to the server group specified with sgid<br>
  *		Note: login needed
  *
  * Output:<br>
  *
  * Array<br>
  * {<br>
  *  [permid] => 8471<br>
  *  [permvalue] => 1<br>
  *  [permnegated] => 0<br>
  *  [permskip] => 0<br>
  * }
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $sgid groupID
  * @param		string $params Additional parameters (optional)
  * @return     boolean success
  */
	function serverGroupPermList($sgid, $params = "") {
		if(!$this->selected) { 
			$this->debug .= "Error in serverGroupPermList(): you have to select a server befor using serverGroupPermList()<br>";
			return false;
		}
		if(!empty($params)) { $params = ' '.$params; }
		return $this->getExtendData("servergrouppermlist sgid=$sgid".$params);
	}

/**
  * serverGroupAddPerm: adds a set of specified permissions to the server group specified with sgid<br>
  *		Note: login needed
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $sgid	groupID
  * @param		integer $permid	permID
  * @param		integer $permvalue	permValue
  * @param		integer $permnegated	{1|0}
  * @param		integer $permskip	{1|0}
  * @return     boolean success
  */
	function serverGroupAddPerm($sgid, $permid, $permvalue, $permnegated, $permskip) {
		if(!$this->selected) { 
			$this->debug .= "Error in serverGroupAddPerm(): you have to select a server befor using serverGroupAddPerm()<br>";
			return false;
		}
		return $this->executeWithoutFetch("servergroupaddperm sgid=$sgid permid=$permid permvalue=$permvalue permnegated=$permnegated permskip=$permskip");
	}

/**
  * serverGroupDeletePerm: removes a set of specified permissions from the server group specified with sgid<br>
  *		Note: login needed
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $sgid groupID
  * @param		integer $permid permID
  * @return     boolean success
  */
	function serverGroupDeletePerm($sgid, $permid) {
		if(!$this->selected) { 
			$this->debug .= "Error in serverGroupDeletePerm(): you have to select a server befor using serverGroupDeletePerm()<br>";
			return false;
		}
		return $this->executeWithoutFetch("servergroupdelperm sgid=$sgid permid=$permid");
	}

/**
  * serverGroupAddClient: adds a client to the server group specified with sgid<br>
  *						  Please note that a client cannot be added to default groups or template groups.<br><br>
  *		Note: login needed
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $sgid	groupID
  * @param		integer $cldbid	clientDBID
  * @return     boolean success
  */
	function serverGroupAddClient($sgid, $cldbid) {
		if(!$this->selected) { 
			$this->debug .= "Error in serverGroupAddClient(): you have to select a server befor using serverGroupAddClient()<br>";
			return false;
		}
		return $this->executeWithoutFetch("servergroupaddclient sgid=$sgid cldbid=$cldbid");
	}

/**
  * serverGroupDeleteClient: removes a client from the server group specified with sgid<br>
  *		Note: login needed
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $sgid	groupID
  * @param		integer $cldbid	clientDBID
  * @return     boolean success
  */
	function serverGroupDeleteClient($sgid, $cldbid) {
		if(!$this->selected) { 
			$this->debug .= "Error in serverGroupDeleteClient(): you have to select a server befor using serverGroupDeleteClient()<br>";
			return false;
		}
		return $this->executeWithoutFetch("servergroupdelclient sgid=$sgid cldbid=$cldbid");
	}

/**
  * serverGroupClientList: displays the IDs of all clients currently residing in the server group specified with sgid<br>
  * If you're using the -names option, the output will also contain the last known nickname and the unique identifier of the clients<br><br>
  *		Note: login needed
  *
  * Output:<br>
  *
  * Array<br>
  * {<br>
  *  [cldbid] => 101<br>
  * }
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $sgid groupID
  * @param		string $params Additional parameters (optional)
  * @return     multidimensional array servergroupclientlist
  */
	function serverGroupClientList($sgid, $params = "") {
		if(!$this->selected) { 
			$this->debug .= "Error in serverGroupClientList(): you have to select a server befor using serverGroupClientList()<br>";
			return false;
		}
		if(!empty($params)) { $params = ' '.$params; }
		return $this->getExtendData("servergroupclientlist sgid=$sgid".$params);
	}

/**
  * serverGroupsByClientID: displays all server groups the client specified with cldbid is currently residing in<br>
  *		Note: login needed
  *
  * Output:<br>
  *
  * Array<br>
  * {<br>
  *  [name] => Server Admin<br>
  *  [sgid] => 71<br>
  *  [cldbid] => 101<br>
  * }
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer	cldbid	clientDBID
  * @return     multidimensional array servergroupsbyclientid
  */
	function serverGroupsByClientID($sgid) {
		if(!$this->selected) { 
			$this->debug .= "Error in serverGroupsByClientID(): you have to select a server befor using serverGroupsByClientID()<br>";
			return false;
		}
		return $this->getExtendData("servergroupsbyclientid cldbid=$sgid");
	}

//*******************************************************************************************	
//*********************************** Internal Functions ************************************
//*******************************************************************************************
/**
 *
 * @access private
*/
	function __construct($host, $queryport, $timeout = 2) {
		$this->host = $host;
		$this->queryport = $queryport;
		$this->timeout = $timeout;
	}

/**
 *
 * @access private
*/
	function __destruct() {
		if(!empty($socket)) {
			$this->logout();
			$this->quit();
		}
	}

/**
  * connect: connects to host
  *
  * @author     Par0noid Solutions
  * @access		public
  * @return		boolean success
  */
	function connect() {
		$this->socket = @fsockopen($this->host, $this->queryport, $errnum, $errstr, $this->timeout);
		if(!$this->socket) {
			return false;
		}else{
			if(strpos(fgets($this->socket), 'TS3') !== false) {
				return true;
			}else{
				return false;
			}
		}
	}

/**
  * executeCommand: executes a command and fetches the response
  *
  * @author     Par0noid Solutions
  * @access		private
  * @return     boolean if false or data if success
  */
	private function executeCommand($command) {
		$data = '';
		fputs($this->socket, $command."\n");
		do {
			$data .= fgets($this->socket);
		} while(strpos($data, 'msg=') === false or strpos($data, 'error id=') === false);

		if(strpos($data, 'error id=0') === false) {
			$this->debug .= "Error while fetching: '".str_replace(array("\t", "\v", "\r", "\n", "\f", "\s", "\p", "\/"), array('', '', '', '', '', ' ', '|', '/'), $data)."'<br>";
			return false;
		}else{
			return $data;
		}
	}

/**
  * getSimpleData: returns non piped server data
  *
  * @author     Par0noid Solutions
  * @param		string	$command	command
  * @return     array data
  */
	private function getSimpleData($command) {
		$fetchedUnfilteredData = $this->executeCommand($command);
		if($fetchedUnfilteredData !== false) {
			
			$fetchedUnfilteredData = str_replace('error id=0 msg=ok', '', $fetchedUnfilteredData);
			$fetchedUnfilteredData = str_replace('\/', '/', $fetchedUnfilteredData);
			$fetchedUnfilteredData = str_replace(array("\t", "\v", "\r", "\n", "\f"), '', $fetchedUnfilteredData);
			
			$data = array();
			
			$splitedKeys = explode(' ', $fetchedUnfilteredData);
			
			foreach($splitedKeys as $key) {
				$equalCount = substr_count($key, '=');
				if($equalCount > 1) {
					$keyVals = explode('=', $key);
					$val = $keyVals[1];
					for($i=2; $i<=$equalCount; $i++) {
						if(!empty($keyVals[$i])) {
							$val .= '='.$keyVals[$i];
						}else{
							$val .= '=';
						}
					}
					$data[$keyVals[0]] = str_replace('\s', ' ', str_replace('\p', '|', $val));
				}else{
					$keyVals = explode('=', $key);
					$data[$keyVals[0]] = str_replace('\s', ' ', str_replace('\p', '|', $keyVals[1]));
				}
			}
			return $data;
		}else{
			return false;
		}
	}

/**
  * getExtendData: returns piped server data
  *
  * @author     Par0noid Solutions
  * @param		string	$command	command
  * @return     multidimensional array data
  */
	private function getExtendData($command) {
		$fetchedUnfilteredData = $this->executeCommand($command);
		if($fetchedUnfilteredData !== false) {

			$fetchedUnfilteredData = str_replace('error id=0 msg=ok', '', $fetchedUnfilteredData);
			$fetchedUnfilteredData = str_replace('\/', '/', $fetchedUnfilteredData);
			$fetchedUnfilteredData = str_replace(array("\t", "\v", "\r", "\n", "\f"), '', $fetchedUnfilteredData);
			
			$data = array();
			$pipeSplittedData = explode('|', $fetchedUnfilteredData);
			
			if(empty($fetchedUnfilteredData)) { return $data; }
			
			foreach($pipeSplittedData as $channelString) {
				$splittedKeys = explode(' ', $channelString);
				
				$keyArray = array();
				
				foreach($splittedKeys as $key) {
					$equalCount = substr_count($key, '=');
					if($equalCount > 1) {
						$keyVal = explode('=', $key);
						$val = $keyVal[1];
						for($i=2; $i<=$equalCount; $i++) {
							if(!empty($keyVal[$i])) {
								$val .= '='.$keyVal[$i];
							}else{
								$val .= '=';
							}
						}
						$keyArray[$keyVal[0]] = str_replace('\s', ' ', str_replace('\p', '|', $val));
					}else{
						$keyVal = explode('=', $key);
						$keyArray[$keyVal[0]] = str_replace('\s', ' ', str_replace('\p', '|', $keyVal[1]));
					}
				}
				
				$data[] = $keyArray;
				
			}
			return $data;
		}else{
			return false;
		}
	}

/**
  * executeWithoutFetch: executes a command but dont fetches the response
  *
  * @author     Par0noid Solutions
  * @param		string	$command	command
  * @return     boolean success
  */
	private function executeWithoutFetch($command) {
		fputs($this->socket, $command."\n");
		$data = fgets($this->socket);
		if(strpos($data, 'id=0') !== false) {
			return true;
		}else{
			$this->debug .= "Error while fetching: '".str_replace(array("\t", "\v", "\r", "\n", "\f", "\s", "\p", "\/"), array('', '', '', '', '', ' ', '|', '/'), $data)."'<br>";
			return false;
		}
	}

/**
  * implodeText: implode special chars
  *
  * @author     Par0noid Solutions
  * @param		string	$text	Text which should be imploded
  * @return     string imploded Text
  */
 	private function implodeText($text) {
		$text = str_replace(' ', '\s', $text);
		$text = str_replace('|', '\p', $text);
		$text = str_replace('/', '\/', $text);
		return $text;
	}

/**
  * convertMillisecondsToStrTime: converts ms to a strtime (bsp. 1h 23m)
  *
  * @author     Par0noid Solutions
  * @param		integer	$ms	Time in milliseconds
  * @return     string strtime
  */
 	public function convertMillisecondsToStrTime($ms) {
    	$minutes = $ms / 60000;
		$hours = floor($minutes / 60);
		$realMinutes = $minutes - ($hours * 60);
    	return $hours.'h '.floor($realMinutes).'min';
	}

/**
  * getDebugLog: returns the debug log
  *
  * @author     Par0noid Solutions
  * @return     string debuglog
  */
 	public function getDebugLog() {
		return $this->debug;
	}

}
?>