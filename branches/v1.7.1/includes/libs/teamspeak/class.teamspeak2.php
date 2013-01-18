<?php
/**
 *                              cyts.class.php								<br />
 *                            ------------------							<br />
 *   begin                : Saturday, Oct 16, 2004							<br />
 *   copyright            : (C) 2004-2005 Steven Barth						<br />
 *   email                : phpdev@midlink.org								<br />
 *   version              : 2.4.1										<br />
 *   last modified        : Saturday, Sep 10, 2005							<br />
 *
 * @package	CYTS-DELTA
 * @author	Steven Barth <phpdev@midlink.org>
 * @copyright	Copyright (c) 2004-2005, Steven Barth
 * @version	2.4.1
 

    This file is part of CyTS2 - A PHP library for querying TeamSpeak2 servers.<br />																			
    CyTS2 is free software; you can redistribute it and/or modify			
    it under the terms of the GNU General Public License as published by	
    the Free Software Foundation; either version 2 of the License, or		
    (at your option) any later version.										
																			
    CyTS2 is distributed in the hope that it will be useful,				
    but WITHOUT ANY WARRANTY; without even the implied warranty of			
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			
    GNU General Public License for more details.							
																			
    You should have received a copy of the GNU General Public License		
    along with CyTS2; if not, write to the Free Software					
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/
/**/

//Version
define("CYTS_VERSION", "2.4.1");
define("CYTS_BUILD", "DELTA");

/**
 * @package CYTS-DELTA
 */
class cyts {
/**
  * connect: Connects to a given TS-Server
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param      string	$sIP	  The server's IP-Adress
  * @param		integer	$sTCP	  The server's TCP-Queryport
  * @param		integer $sUDP	  The subserver's UDP-Port (optional)
  * @param		integer $sTimeout Socket timeout in seconds
  * @return     boolean status
  */
	function connect($sIP, $sTCP, $sUDP = false, $sTimeout = 3) {
		$this->__construct();
		if (!$this->sCon = @fsockopen($sIP, $sTCP, $errNo, $errStr, $sTimeout)) {
			$this->debug[] = array("cmd" => "", "rpl" => $errStr);
			return false;
		}
		
		$this->server = $sIP;
		$this->tcp    = $sTCP;
		
		if ($this->_fastcall() != CYTS_SYN) {
			$this->disconnect();
			return false;
		}
			
		if ($sUDP && !$this->select($sUDP)) {
			$this->disconnect();
			return false;
		}
		$this->udp = $sUDP;
		return true;
	}
	
/**
  * disconnect: Closes any open connection
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  */
	function disconnect() {
		if (is_resource($this->sCon))
			fclose($this->sCon);
		$this->__construct();
	}
	
/**
  * login: Authenticates with the server
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		string $sUser		Username
  * @param		string $sPass		Password
  * @return		boolean success
  */	
	function login($sUser, $sPass) {
		if ($this->_fastcall("LOGIN $sUser $sPass") != CYTS_OK)
			return false;
		if ($this->_fastcall("REMOVECLIENT") == CYTS_INVALID_PARAM)
			$this->isAdmin = true;
		else
			$this->isAdmin = false;
		$this->user = $sUser;
		$this->pass = $sPass;
		return true;
	}

/**
  * slogin: Authenticates with the server as superadmin
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		string $sUser		Username
  * @param		string $sPass		Password
  * @return		boolean success
  */	
	function slogin($sUser, $sPass) {
		if ($this->_fastcall("SLOGIN $sUser $sPass") != CYTS_OK)
			return false;
		$this->isAdmin  = true;
		$this->isSAdmin = true;
		$this->user = $sUser;
		$this->pass = $sPass;
		return true;
	}
	
/**
  * wi_login: Authenticates with the webinterface as admin
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		string $wiPort		WebInterface-Port
  * @return		boolean success
  */	
	function wi_login($wiPort=14534, $sTimeout=3) {
		if ($this->isSAdmin) {
			$this->wiCookie = false;
			$this->wiPort   = $wiPort;
			$sRet = $this->_wipost("/login.tscmd", array("username" => $this->user, "password" => $this->pass, "superadmin" => 1), $sTimeout);
			if (!$sRet || !isset($sRet[0]["Location"]) || $sRet[0]["Location"] != "index.html" || !isset($sRet[0]["Set-Cookie"])) {
				$this->wiPort = false;
				return false;
			} else {
				$this->wiCookie = strtr($sRet[0]["Set-Cookie"], "; path=/", "");
				if ($this->udp)  {
					$this->wi_select();
				}
				return true;
			}	
		} elseif ($this->isAdmin) {
			$this->wiCookie = false;
			$this->wiPort   = $wiPort;
			$sRet = $this->_wipost("/login.tscmd", array("username" => $this->user, "password" => $this->pass, "serverport" => $this->udp), $sTimeout);
			if (!$sRet || !isset($sRet[0]["Location"]) || $sRet[0]["Location"] != "index.html" || !isset($sRet[0]["Set-Cookie"])) {
				$this->wiPort = false;
				return false;
			} else {
				$this->wiCookie = strtr($sRet[0]["Set-Cookie"], "; path=/", "");
				return true;
			}
		} else {
			return false;
		}
	}

/**
  * wi_select: Selects a server through Webinterface
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		string $sID		ServerID
  * @return		boolean success
  */
  	function wi_select($sID=NULL) {
		if (!$this->wiPort) return false;
		if ($sID === NULL && $this->udp) {
			$sData = $this->info_serverInfo();
			$sID = $sData['server_id'];
		}
		$this->_wiget("/select_server.tscmd?serverid=$sID");
	}
	
/**
  * fastcall: Executes a command on the server
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		string $sCall		Command string
  * @return		string Server reply
  */
  	function fastcall($sCall) {
		return $this->_fastcall($sCall);
	}
	
/**
  * extendcall: Executes a command on the server and resets channel and user
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		string $sCall		Command string
  * @return		string Server reply
  */
  	function extendcall($sCall) {
		return $this->_extendcall($sCall);
	}

/**
  * debug: Returns all replies sent by the server
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @return		array replies
  */
  	function debug() {
		return $this->debug;
	}
	
/**
  * debug_lastreply: Returns last reply form TS2-Server
  *
  * @author		Steven Barth
  * @version	2.0
  *	@access		public
  * @return		string reply
  */
  	function debug_lastreply() {
		$lastcmd = array_pop($this->debug);
		$this->debug[] = $lastcmd;
		return $lastcmd["rpl"];
	}

/**
  * select: Select a TeamSpeak subserver
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param 		integer $sUDP	The subserver UDP-Port
  * @return		boolean success
  */
  	function select($sUDP) {
		if ($this->_extendcall("SEL $sUDP") == CYTS_OK) {
			$this->udp = $sUDP;
			return true;
			if ($this->wiPort)
				$this->wi_login($this->wiPort);
		} else return false;
	}

/**
  * info_playerList: Returns a list of players that are connected to the server
  * 			array:<br />
  *				[0], [unparsed]		=> Unparsed playerstring<br />
  *				[1], [p_id]			=> PlayerID<br />
  *             [2], [c_id]			=> ChannelID<br />
  *				[3], [ps]			=> Packets sent by server<br />
  * 			[4], [bs]			=> Bytes sent by server<br />
  * 			[5], [pr]			=> Packets received by server<br />
  * 			[6], [br]			=> Bytes received by server<br />
  *         	[7], [pl]			=> Packet Loss<br />
  *             [8], [ping]			=> Ping<br />
  *             [9], [logintime]	=> Seconds since Login<br />
  *        		[10], [idletime]	=> Idletime in seconds<br />
  *             [11], [cprivs] 		=> Channelflags (1 - CA, 2 - O, 4 - V, 8 - AO, 16 - AV)<br />
  *         	[12], [pprivs] 		=> Serverflags (1 - SA, 2 - Allowed To Register(AR), 4 - R, 8 - ???, 16 - Sticky) <br />
  *         	[13], [pflags] 		=> Playerflags (1 - Channel Commander(CC), 2 - Voice Request(VR), 4 - No Whisper(NW), 8 - Away(AW), 16 - Mic Muted(MM), 32 - Snd Muted(SM), 64 - Rec(RC))<br />
  *         	[14], [ip]			=> IP-Adress (Note: This will be 0.0.0.0 for all players if you are not logged in as a server admin)<br />
  *             [15], [nick]		=> Nickname<br />
  *         	[16], [loginname]	=> Loginname (empty if user is not registered)<br />
  *
  * @author     Steven Barth
  * @version    2.0
  * @see		info_translateFlag(), for converting flags to arrays
  * @access		public
  * @return     array multi-dimensional array with player data
  */
	function info_playerList() {
		if (is_array($this->uList)) return $this->uList;
		if (!$sRes = $this->_fastcall("PL")) return false;
		if ($sRes == CYTS_INVALID_PARAM) return false;
		$sList = explode("\r\n", $sRes); 
		array_shift($sList);
		$uList = array();
		$uKeys = array('unparsed', 'p_id', 'c_id', 'ps', 'bs', 'pr', 'br', 'pl', 'ping', 'logintime', 'idletime', 'cprivs', 'pprivs', 'pflags', 'ip', 'nick', 'loginname');
		foreach ($sList as $row)
			if (strstr($row, "\t")) {
				$res = explode("\t", $row);
				array_unshift($res, $row);
				array_pop($res);
				foreach ($res as $key => $val) {
					if ($key == 14 || $key == 15 || $key == 16) {
						$val = substr($val, 1, strlen($val) - 2);
						$res[$key] = $val;
					}
					$res["{$uKeys[$key]}"] = $val;
				}
				$uList[] = $res;
			}
		$this->uList = $uList;
		return $uList;
	}
	
/**
  * info_playerNameList: Returns a list of players with their IDs and Names
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @return     array array (playerId => playerName)
  */
	function info_playerNameList() {
		if (!$pList = $this->info_playerList()) return false;
		$nList = array();
		foreach ($pList as $player) {
			$pID = $player[1];
			$pNAME = $player[15];
			$nList[$pID] = $pNAME;
		}
		return $nList;
	}

/**
  * info_channelList: Returns a list of channels that are available on the server
  * 			array:<br />
  *				[0], [unparsed]	=> Unparsed channelstring<br />
  *				[1], [id]		=> ChannelID<br />
  *             [2], [codec]	=> Codec (from 0 to 13):<br />
  *				[3], [parent]	=> Parent ChannelID (-1 if no Subchannel)<br />
  * 			[4], [order]	=> Channel Order<br />
  * 			[5], [maxusers]	=> Max Users<br />
  * 			[6], [name]		=> Name<br />
  *         	[7], [flags]	=> Flags (1 - Unregistered(U), 2 - Moderated(M), 4 - Private(P), 8 - Subchannels(S), 16 - Default(D))<br />
  *             [8], [password]	=> Passworded (1 - True, 0 - False)<br />
  *             [9], [topic]	=> Topic<br />
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @see		info_translateFlag(), for converting flags to arrays
  * @see		info_getCodec(), for getting a codecs name by its id
  * @return     array multi-dimensional array with channel data
  */
	function info_channelList() {
		if (is_array($this->cList)) return $this->cList;
		if (!$sRes = $this->_fastcall("CL")) return false;
		if ($sRes == CYTS_INVALID_PARAM) return false;
		$sList = explode("\r\n", $sRes);
		array_shift($sList);
		$cList = array();
		$cKeys = array('unparsed', 'id', 'codec', 'parent', 'order', 'maxusers', 'name', 'flags', 'password', 'topic');
		foreach ($sList as $row)
			if (strstr($row, "\t")) {
				$res = explode("\t", $row);
				array_unshift($res, $row);
				foreach ($res as $key => $val) {
					if ($key == 6 || $key == 9) {
						$val = substr($val, 1, strlen($val) - 2);
						$res[$key] = $val;
					}
					$res["{$cKeys[$key]}"] = $val;
				}
				$cList[] = $res;
			}
		$this->cList = $cList;
		return $cList;
	}
	
/**
  * info_channelNameList: Returns a list of channels with their IDs
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @return     array array (channelId => channelName)
  */
	function info_channelNameList() {
		if (!$cList = $this->info_channelList()) return false;
		$nList = array();
		foreach ($cList as $channel) {
			$cID = $channel[1];
			$cNAME = $channel[6];
			$nList[$cID] = $cNAME;
		}
		return $nList;
	}

/**
  * info_getPlayerByName: Returns the PlayerID of the player with the name $pName or -1 if no user $pName is online
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param      string	$pName	The Player name
  * @return     integer PlayerID, -1 at failure
  */
	function info_getPlayerByName($pName) {
		if (!$uList = $this->info_playerList()) return -1;
		foreach ($uList as $player) {
			if ($player[15] == $pName) return $player[1];
		}
		return -1;
	}
	
/**
  * info_getChannelByName: Returns the ChannelID of the channel with the name $cName or -1 if no channel $cName is existing
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param      string	$cName	The Channel name
  * @return     integer ChannelID, -1 at failure
  */
	function info_getChannelByName($cName) {
		if (!$cList = $this->info_channelList()) return -1;
		foreach ($cList as $channel) {
			if ($channel[3] != "-1") continue;
			if ($channel[6] == $cName) return $channel[1];
		}
		return -1;
	}
	
/**
  * info_channelInfo: Returns the channel data of $cID or false at any error
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param      integer	$cID	The Channel ID 
  * @see		info_channelList(), for array description
  * @return     array channel data, false at failure
  */
	function info_channelInfo($cID) {
		if (!$cList = $this->info_channelList()) return false;
		foreach ($cList as $channel)
			if ($channel[1] == $cID)
				return $channel;
		return false;
	}
	
/**
  * info_playerInfo: Returns the player data of $pID or false at any error
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param      integer	$pID	The Player ID 
  * @return     array player data, false at failure
  */
	function info_playerInfo($pID) {
		if (!$pList = $this->info_playerList()) return false;
		foreach ($pList as $player)
			if ($player[1] == $pID)
				return $player;
		return false;
	}
	
/**
  * info_playerImage: Returns the Image that the player has in the TeamSpeak Client
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param      integer	$pID	The Player ID 
  * @return     away, sndmuted, micmuted, chancmd, player or false at failure
  */
	function info_playerImage($pID) {
		if (!$pList = $this->info_playerList()) return false;
		$pPFlag = false;
		foreach ($pList as $player)
			if ($player[1] == $pID)
				$pPFlag = $this->info_translateFlag($player[13], 3);
		if (!$pPFlag)
			return false;
			
		if ($pPFlag["AW"])
			return "away";
		elseif ($pPFlag["SM"])
			return "sndmuted";
		elseif ($pPFlag["MM"])
			return "micmuted";
		elseif ($pPFlag["CC"])
			return "chancmd";
		else
			return "player";
	}

/**
  * info_getCodec: Returns the Codec by its name
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param      integer	$cID	The Codec ID 
  * @return     codecname or false at failure
  */
	function info_getCodec($cID) {
		$codec = array();
		$codec[] = "CELP 5.1 Kbit";
		$codec[] = "CELP 6.3 Kbit";
		$codec[] = "GSM 14.8 Kbit";
		$codec[] = "GSM 16.4 Kbit";
		$codec[] = "CELP Windows 5.2 Kbit";
		$codec[] = "Speex 3.4 Kbit";
		$codec[] = "Speex 5.2 Kbit";
		$codec[] = "Speex 7.2 Kbit";
		$codec[] = "Speex 9.3 Kbit";
		$codec[] = "Speex 12.3 Kbit";
		$codec[] = "Speex 16.3 Kbit";
		$codec[] = "Speex 19.5 Kbit";
		$codec[] = "Speex 25.9 Kbit";
		if (isset($codec[$cID]))
			return $codec[$cID];
	}
	
/**
  * info_serverList: Returns all known subservers of a TeamSpeak Server
  *
  * @author		Steven Barth
  * @version	2.0
  * @access		public
  * @return		array server list, false at failure
  */
  	function info_serverList() {  
		if (!$sRead = $this->_fastcall("SL")) return false;
		$sRead = explode("\r\n", $sRead);
		$sList = array();
		foreach ($sRead as $rLine) {
			if (preg_match('/([0-9]+)/', $rLine, $match)) {
				$sID = $match[1];
				$sList[] = $sID;
			}
		}
		return $sList;
	}
	
/**
  * info_extendServerList: Returns all known subservers of a TeamSpeak Server with their server info
  *
  * @author		Steven Barth
  * @version	2.0
  * @access		public
  * @return		array server list, false at failure
  */
	function info_extendServerList() {
		if (!$sList = $this->info_serverList()) return false;
		if ($this->udp)
			$sUDP = $this->udp;
		$sData = array();
		$sQry  = '';
		foreach ($sList as $sID) {
			$this->select($sID);
			$sData[$sID] = $this->info_serverInfo();
		}
		if ($this->udp)
			$this->select($sUDP);
		return $sData;
	}

/**
  * info_serverInfo: Returns some information about the sub-server<br />
  * array:<br />
  * [server_id] => Server ID (not UDP-Port)<br />
  * [server_name] => Server name<br />
  * [server_platform] => Server OS<br />
  * [server_welcomemessage] => Server welcome message<br />
  * [server_webpost_linkurl] => Server webpost linkurl<br />
  * [server_webpost_posturl] => Server webpost posturl<br />
  * [server_password] => Server passworded (1 - True, 0 - False)<br />
  * [server_clan_server] => Clan server (1 - True, 0 - False)<br />
  * [server_udpport] => UDP-Port<br />
  * [server_maxusers] => Slots<br />
  * [server_packetssend] => Packets sent by sub-server<br />
  * [server_bytessend] => Bytes sent by sub-server<br />
  * [server_packetsreceived] => Packets received by sub-server<br />
  * [server_bytesreceived] => Bytes received by sub-server<br />
  * [server_uptime] => Server uptime in seconds<br />
  * [server_currentusers] => Connected players<br />
  * [server_currentchannels] => Existing channels<br />
  * [server_bwinlastsec] => Incoming bandwith (last second)<br />
  * [server_bwoutlastsec] => Outgoing bandwith (last second)<br />
  * [server_bwinlastmin] => Incoming bandwith (last minute)<br />
  * [server_bwoutlastmin] => Outgoing bandwith (last minute)<br />
  * [average_packet_loss] => Average Packet Loss<br />
  * 
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @return     array serverinformation
  */
	function info_serverInfo() {
		if (!$sRead = $this->_fastcall("SI")) return false;
		$sRead .= $this->_fastcall("GAPL");
		$sRead = explode("\r\n", $sRead);
		$sInfo = array();
		foreach ($sRead as $rLine) {
			if (strstr($rLine, "=")) {
				$match = explode("=", trim($rLine), 2);
				$key = $match[0];
				$val = $match[1];
				$sInfo[$key] = $val;
			}
		}
		return $sInfo;
	}

/**
  * info_globalInfo: Returns some information about the server<br />
  * array:<br />
  * [total_server_uptime] => Server uptime (String)<br />
  * [total_server_version] => Server version<br />
  * [total_server_platform] => Server OS<br />
  * [total_servers] => Total sub-servers<br />
  * [total_users_online] => Total users online on all sub-servers<br />
  * [total_users_maximal] => Users maximum on all sub-servers<br />
  * [total_channels] => Total channels on all servers<br />
  * [total_bytesreceived] => Total bytes received by server<br />
  * [total_bytessend] => Total bytes sent by server<br />
  * [total_packetssend] => Total packets sent by server<br />
  * [total_packetsreceived] => Total bytes received by server<br />
  * [total_bwoutlastmin] => Outgoing bandwith (last minute)<br />
  * [total_bwoutlastsec] => Outgoing bandwith (last second)<br />
  * [total_bwinlastmin] => Incoming bandwith (last minute)<br />
  * [total_bwinlastsec] => Incoming bandwith (last second)<br />
  * [isp_ispname] => Server ISP<br />
  * [isp_linkurl] => Server ISP - Homepage<br />
  * [isp_adminemail] => Server ISP - Admin E-Mail<br />
  * [isp_countrynumber] => Server ISP - Contrynumber<br />
  * 
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @return     array serverinformation
  */
	function info_globalInfo() {
		if (!$sRead = $this->_fastcall("GI")) return false;
		$sRead = explode("\r\n", $sRead);
		$sInfo = array();
		foreach ($sRead as $line) {
			if (preg_match('/([a-z_]+)=(.*)/', $line, $match)) {
				$key = $match[1];
				$val = $match[2];
				$sInfo[$key] = $val;
			}
		}
		return $sInfo;
	}
	
/**
  * info_defaultChannel: Returns the default channel of the sub-server or false at any error
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @return     integer ChannelID, false at failure
  */	
	function info_defaultChannel() {
		if (!$cList = $this->info_channelList()) return false;
		foreach ($cList as $channel)
			if ($channel[7] >= 16)
				return $channel[1];
		return false;
	}
	
/**
  * info_channelUser: Returns all users in the target channel in an array
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param      integer	$cID	The Channel ID
  * @see		getChannelByName(), for converting a channel name to an ID
  * @see		getPlayers(), for an array description
  * @return     array user list, false at failure
  */	
	function info_channelUser($cID) {
		if (!$pList = $this->info_playerList()) return false;
		$cList = array();
		foreach ($pList as $user) {
			if ($user[2] == $cID) $cList[] = $user;
		}
		return $cList;
	}

/**
  * info_translateFlag: Translates given flags to arrays
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param      integer	$vFlag	The given flag
  * @param		integer $fType	The type of the flag (1 - Player-Channel-Flag, 2 - Player-Server-Flag, 3 - Player-Player-Flag, 4 - Channel-Channel-Flag)
  * @param		boolean $oStr	Output as a string, if not as an array
  * @return     array array flags, false at failure
  */	
	function info_translateFlag($vFlag, $fType = 1, $oStr = false) {
		if ($fType != 1 && $fType != 2 && $fType != 3 && $fType != 4 && $fType != 5) return false;
		$decode = array();
		$decode[1] = array("CA", "O", "V", "AO", "AV");							//1 - See getPlayers() [11]
		$decode[2] = array("SA", "AR", "R", "", "ST");							//2 - See getPlayers() [12]
		$decode[3] = array("CC", "VR", "NW", "AW", "MM", "SM", "RC");			//3 - See getPlayers() [13]
		$decode[4] = array("U", "M", "P", "S", "D");							//4 - See getChannels() [7]
		$decode[5] = array("UU", "RU", "UC", "RC");								//5 - Internal for KickIdler
		$uDec = $decode[$fType];
		$cFlags = array();
		$cnt = 0;
		while ($vFlag > 0) {
			$nKey = $uDec[$cnt];
			$nVal = ($vFlag & 1 == 1) ? true : false;
			$cFlags[$nKey] = $nVal;
			$vFlag >>= 1;
			$cnt++;
		}
		foreach ($decode[$fType] as $val) {
			if (!isset($cFlags[$val]))
				$cFlags[$val] = false;
		}
		
		if (!$oStr)
			return $cFlags;
		
		$rFlag = array();
		if ($fType == 4 && !$cFlags["U"])
			$rFlag[] = "R";
		foreach ($cFlags as $key => $val) {
			if ($val)
				$rFlag[] = $key;
		}
		return implode(" ", $rFlag);
	}

/**
  * admin_kickFromChannel: Moves the target player from his/her current channel to the default channel<br />
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param      integer	$pID	The player ID
  * @see		info_getPlayerByName(), to get a player's id from its username
  * @return     boolean True at success, False at failure
  */
	function admin_kickFromChannel($pID) {
		if (!$cID = $this->info_defaultChannel()) return false;
		return ($this->_extendcall("MPTC $cID $pID") == CYTS_OK);
	}

/**
  * admin_kick: Kicks the target player from the server<br />
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param      integer	$pID The player ID
  * @param      string	$reason	Reason for kick
  * @see		info_getPlayerByName(), to get a player's id from its username
  * @return     boolean True at success, False at failure
  */
	function admin_kick($pID, $reason="") {
		return ($this->_extendcall("KICK $pID $reason") == CYTS_OK);
	}
	
/**
  * admin_remove: Silently removes the target player from the server<br />
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param      integer	$pID	The player ID
  * @see		info_getPlayerByName(), to get a player's id from its username
  * @return     boolean True at success, False at failure
  */
	function admin_remove($pID) {
		return ($this->_extendcall("REMOVECLIENT $pID") == CYTS_OK);
	}
	
/**
  * admin_move: Moves the target player $pID to the target channel $cID<br />
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param      integer	$pID	The Player ID
  * @param      integer	$cID	The Channel ID
  * @see		info_getPlayerByName(), to get a player's id from its username
  * @see		info_getChannelByName(), to get a channel's id from its name
  * @return     boolean True at success, False at failure
  */
	function admin_move($pID, $cID) {
		return ($this->_extendcall("MPTC $cID $pID") == CYTS_OK);
	}
	
/**
  * admin_clearChannel: Removes all players from the target Channel	<br />
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param      integer	$cID	The Channel ID
  * @param		integer $kMode	(1 - Move To Channel $param, 2 - Kick From Server with reason $param, 3 - Remove From Server)
  * @param      mixed	$param	The target channel id if $kMode = 1 or the reason if $kMode = 2
  * @see		info_getChannelByName(), to get a channel's id from its name
  * @return		boolean success
  */
	function admin_clearChannel($cID, $kMode = 1, $param = NULL) {
		$cList = $this->info_channelUser($cID);
		if ((!$param || !is_array($this->info_channelUser($param))) && $kMode == 1) {
			if (!$param = $this->info_defaultChannel()) return false; //Use the default channel if $param is invalid
		}
		$cmd = "";
		$cStat = true;
		foreach ($cList as $user) {
			if ($kMode == 1) {
				if ($this->_extendcall("MPTC $param $user[1]") != CYTS_OK)
					$cStat = false;
			} elseif ($kMode == 2) {
				if ($this->_extendcall("KICK $user[1] $param") != CYTS_OK)
					$cStat = false;
			} elseif ($kMode == 3) {
				if ($this->_extendcall("REMOVECLIENT $user[1]") != CYTS_OK)
					$cStat = false;
			}
		}
		return $cStat;
	}

/**
  * admin_kickIdler: Removes the target idle players (Evaluates the KI function)<br />
  *		  Note: If you want to use two or more flags, sum them (e.g. 7 for Unregistered & Registered Users in Unregistered Channels)
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		float	$tIdle	Idle time in minutes
  * @param      integer	$tFlag	Target Flag (1 - Unregistered Users, 2 - Registered User, 4 - Unregistered Channels, 8 - Registered Channels)
  * @param		integer $kMode	(1 - Move To Channel $param, 2 - Kick From Server, 3 - Remove From Server)
  * @param      mixed	$param	The target channel ID if $kMode = 1 or the reason if $kMode = 2
  * @return		integer affected users, 0 at failure
  */
	function admin_kickIdler($tIdle, $tFlag, $kMode = 1, $param = NULL) {
		if (!$uList = $this->info_playerList()) return false;
		
		if ((!$param || !$this->info_channelInfo($param)) && $kMode == CYTS_MOVE) {
			if (!$param = $this->info_defaultChannel()) return false; //Use the default channel if $param is invalid
		}
		
		$mFlag = $this->info_translateFlag($tFlag, 5);

		$cStat = 0;
		foreach ($uList as $user) {
		
			$cData = $this->info_channelInfo($user['c_id']);		
			$cFlag = $this->info_translateFlag($cData['flags'], 4);
			$uFlag = $this->info_translateFlag($user['pprivs'], 2);
			
			if ($cFlag["U"] && !$mFlag["UC"]) continue;
			if (!$cFlag["U"] && !$mFlag["RC"]) continue;						
			if ($uFlag["R"] && !$mFlag["RU"]) continue;
			if (!$uFlag["R"] && !$mFlag["UU"]) continue;		
			if ($user['idletime'] / 60 < $tIdle) continue;		
			
			if ($kMode == 1) {
				if ($this->admin_move($user['p_id'], $param))
					$cStat++;
			} elseif ($kMode == 2) {
				if ($this->admin_kick($user['p_id'], $param))
					$cStat++;
			} elseif ($kMode == 3) {
				if ($this->admin_remove($user['p_id']))
					$cStat++;
			}
		}
		return $cStat;
	}
	
/**
  * admin_dbUserList: Returns a list of all known users in the database<br />
  * 	  array:<br />
  *       [0] => Unparsed DB-Row<br />
  *       [1] => Userid<br />
  *       [2] => Serveradmin (0 - False, -1 - True)<br />
  *		  [3] => Account created<br />
  *       [4] => Last Login<br />
  *		  [5] => Username<br />
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @return     array user list
  */	
	function admin_dbUserList() {
		if (!$uRead = $this->_fastcall("DBUSERLIST")) return false;
		$uPattern = '/^([0-9]+)\t(.*)\t(.*)\t(.*)\t"(.*)"$/';
		$uRead = explode("\r\n", $uRead);
		$cList = array();
		foreach ($uRead as $row) {
			if (preg_match($uPattern, $row, $match))
				$cList[] = $match;
		}
		return $cList;
	}
	
/**
  * admin_getDBUserByName: Returns the ID of the user $uName<br />
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		string $uName User Name
  * @return     integer UserID, -1 at failure
  */	
	function admin_getDBUserByName($uName) {
		if (!$uRead = $this->admin_dbUserList()) return -1;
		foreach ($uRead as $row) {
			if ($row[5] == $uName) return $row[1];
		}
		return -1;
	}
	
/**
  * admin_getDBUserData: Returns the data of the user $uID<br />
  *
  * @author     Steven Barth
  * @version    1.0
  * @access		public
  * @param		integer $uID UserID
  * @return     array user data, false at failure
  */	
	function admin_getDBUserData($uID) {
		if (!$uRead = $this->admin_dbUserList()) return false;
		foreach ($uRead as $row) {
			if ($row[1] == $uID) return $row;
		}
		return false;
	}
	
/**
  * admin_dbUserAdd: Adds a user to the UserDB<br />
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		string	$lName	Username
  * @param		string	$lPass	Password
  * @param		boolean	$lSA	Server Admin
  * @return     boolean success
  */	
	function admin_dbUserAdd($lName, $lPass, $lSA = false) {
		$lSA = ($lSA) ? 1 : 0;
		return ($this->_fastcall("DBUSERADD $lName $lPass $lPass $lSA") == CYTS_OK);
	}
	
/**
  * admin_dbUserDel: Deletes a user ftom the UserDB
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		integer	$uID	UserID
  * @return     boolean success
  */	
	function admin_dbUserDel($uID) {
		return ($this->_fastcall("DBUSERDEL $uID") == CYTS_OK);
	}
	
/**
  * admin_dbUserChangePW: Changes the password of user $uID to $uPW
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		integer	$uID	UserID
  * @param		string	$uPW	User password
  * @return     boolean success
  */	
	function admin_dbUserChangePW($uID, $uPW) {
		return ($this->_fastcall("DBUSERCHANGEPW $uID $uPW $uPW") == CYTS_OK);
	}

/**
  * admin_dbUserChangeSA: Changes the Server Admin status of a user<br />
  *       Note: This function requires a login with a server admin account
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		integer	$uID	UserID
  * @param		boolean	$uSA	Server admin status (1 - True, 0 - False)
  * @return     boolean success
  */	
	function admin_dbUserChangeSA($uID, $uSA = false) {
		$uSA = ($uSA) ? 1 : 0;
		return ($this->_fastcall("DBUSERCHANGEATTRIBS $uID $uSA") == CYTS_OK);
	}

/**
  * sadmin_dbSUserList: Returns a list of all known users in the database<br />
  * 	  array:<br />
  *       [0] => Unparsed DB-Row<br />
  *       [1] => Userid<br />
  *		  [2] => Account created<br />
  *       [3] => Last Login<br />
  *		  [4] => Username<br />
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @return     array user list
  */	
	function sadmin_dbSUserList() {
		if (!$uRead = $this->_fastcall("DBSUSERLIST")) return false;
		$uPattern = '/^([0-9]+)\t(.*)\t(.*)\t"(.*)"$/';
		$uRead = explode("\r\n", $uRead);
		$cList = array();
		foreach ($uRead as $row) {
			if (preg_match($uPattern, $row, $match))
				$cList[] = $match;
		}
		return $cList;
	}
	
/**
  * sadmin_getDBSUserByName: Returns the ID of the user $uName<br />
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		string $uName User Name
  * @return     integer UserID, -1 at failure
  */	
	function sadmin_getDBSUserByName($uName) {
		if (!$uRead = $this->sadmin_dbSUserList()) return -1;
		foreach ($uRead as $row) {
			if ($row[4] == $uName) return $row[1];
		}
		return -1;
	}
	
/**
  * sadmin_getDBSUserData: Returns the data of the user $uID<br />
  *
  * @author     Steven Barth
  * @version    1.0
  * @access		public
  * @param		integer $uID UserID
  * @return     array user data, false at failure
  */	
	function sadmin_getDBSUserData($uID) {
		if (!$uRead = $this->sadmin_dbSUserList()) return false;
		foreach ($uRead as $row) {
			if ($row[1] == $uID) return $row;
		}
		return false;
	}
	
/**
  * sadmin_dbSUserAdd: Adds a user to the UserDB<br />
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		string	$lName	Username
  * @param		string	$lPass	Password
  * @param		boolean	$lSA	Server Admin
  * @return     boolean success
  */	
	function sadmin_dbSUserAdd($lName, $lPass) {
		return ($this->_fastcall("DBSUSERADD $lName $lPass $lPass") == CYTS_OK);
	}
	
/**
  * sadmin_dbSUserDel: Deletes a user from the UserDB
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		integer	$uID	UserID
  * @return     boolean success
  */	
	function sadmin_dbSUserDel($uID) {
		return ($this->_fastcall("DBSUSERDEL $uID") == CYTS_OK);
	}
	
/**
  * sadmin_dbSUserChangePW: Changes the password of user $uID to $uPW
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		integer	$uID	UserID
  * @param		string	$uPW	User password
  * @return     boolean success
  */	
	function sadmin_dbSUserChangePW($uID, $uPW) {
		return ($this->_fastcall("DBSUSERCHANGEPW $uID $uPW $uPW") == CYTS_OK);
	}
	
/**
  * sadmin_messageServer: Sends a Message to a Subserver
  *       Note: This function requires a login with a super admin account
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		string	$sMsg	Message
  * @param		boolean	$uHide	Hide Loginname
  * @return     boolean success
  */	
	function sadmin_messageServer($sMsg, $uHide = false) {
		$sMsg = ($uHide) ? "@".$sMsg : $sMsg;
		return ($this->_fastcall("MSG $sMsg") == CYTS_OK);
	}

/**
  * sadmin_messageUser: Sends a Message to a User
  *       Note: This function requires a login with a super admin account
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		integer $uID	UserID
  * @param		string	$sMsg	Message
  * @param		boolean	$uHide	Hide Loginname
  * @return     boolean success
  */	
	function sadmin_messageUser($uID, $sMsg, $uHide = false) {
		$sMsg = ($uHide) ? "@".$sMsg : $sMsg;
		return ($this->_fastcall("MSGU $uID $sMsg") == CYTS_OK);
	}
	
/**
  * sadmin_messageUser: Sends a Message to a all Subserver
  *       Note: This function requires a login with a super admin account
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		string	$sMsg	Message
  * @param		boolean	$uHide	Hide Loginname
  * @return     boolean success
  */	
	function sadmin_messageAll($sMsg, $uHide = false) {
		$sMsg = ($uHide) ? "@".$sMsg : $sMsg;
		return ($this->_fastcall("MSGALL $sMsg") == CYTS_OK);
	}
	
/**
  * sadmin_findChannel: Finds a channel based on a string
  *       Note: This function requires a login with a super admin account
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		string	$sQuery	Suchstring
  * @return     array search matches
  */	
	function sadmin_findChannel($sQuery) {
		if (!$uRead = $this->_fastcall("FC $sQuery")) return false;
		$uPattern = '/^([0-9]+)\t([0-9]+)\t(.*)$/';
		$uRead = explode("\r\n", $uRead);
		$cList = array();
		foreach ($uRead as $row) {
			if (preg_match($uPattern, $row, $match))
				$cList[] = $match;
		}
		return $cList;		
	}
	
/**
  * sadmin_findPlayer: Finds a player based on a string
  *       Note: This function requires a login with a super admin account
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		string	$sQuery	Suchstring
  * @return     array search matches
  */	
	function sadmin_findPlayer($sQuery) {
		if (!$uRead = $this->_fastcall("FP $sQuery")) return false;
		$uPattern = '/^([0-9]+)\t([0-9]+)\t([0-9]+)\t"(.*)"\t"(.*)"\t"(.*)"\t$/';
		$uRead = explode("\r\n", $uRead);
		$cList = array();
		foreach ($uRead as $row) {
			if (preg_match($uPattern, $row, $match))
				$cList[] = $match;
		}
		return $cList;		
	}
	
/**
  * sadmin_channelInfo: Returns several information about a Channel and its Users
  *       Note: This function requires a login with a super admin account
  *		  Output: 
  * [0] => Array (
  *		[0], [unparsed] 		=> Unparsed Channelstring
  *		[1], [c_id]				=> Channel-ID
  *		[2], [c_pid]			=> Parent Channel
  *		[3], [c_dbid]			=> Channel-DBID
  *		[4], [c_name]			=> Channel-Name
  *		[5], [c_fU]				=> Channel Flag Unregistered
  *		[6], [c_fM]				=> Channel Flag Moderated
  *		[7], [c_fP]				=> Channel Flag Private
  *		[8], [c_fH]				=> Channel Flag Subchannels
  *		[9], [c_fD]				=> Channel Flag Default
  *		[10], [c_codec]			=> Channel Codec
  *		[11], [c_order]			=> Channel Order
  *		[12], [c_maxusers]		=> Channel MaxUsers
  *		[13], [c_created]		=> Channel Creation Date/Time
  *		[14], [c_topic]			=> Channel Topic
  *		[15], [c_desctiption]	=> Channel Description
  * )
  * [1, 2, 3, ...] => Array (
  *		[0], [unparsed]		=> Unparsed User String
  *		[1], [p_id]			=> PlayerID
  *		[2], [p_nick]		=> Nickname
  *		[3], [sa]			=> Server-Admin
  *		[4], [ca]			=> Channel-Admin
  *		[5], [o]			=> Operator
  *		[6], [ao]			=> Auto-Operator
  *		[7], [v]			=> Voice
  *		[8], [av]			=> Auto-Voice
  *		[9], [cst]			=> Channel Sticky
  *		[10], [reg]			=> Registriert
  * )
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		integer	$cID	Channel ID
  * @return     array channel information
  */	
	function sadmin_channelInfo($cID) {
		if (!$uRead = $this->_fastcall("CI $cID")) return false;
		$cPattern = '/^([0-9]+)\t(.*)\t([0-9]+)\t"(.*)"\t([0-9]+)\t([0-9]+)\t([0-9]+)\t([0-9]+)\t([0-9]+)\t([0-9]+)\t([0-9]+)\t([0-9]+)\t(.*)\t"(.*)"\t"(.*)"\t$/';
		$uPattern = '/^([0-9]+)\t"(.*)"\t([0-9]+)\t([0-9]+)\t([0-9]+)\t([0-9]+)\t([0-9]+)\t([0-9]+)\t([0-9]+)\t([0-9]+)\t$/';
		$cKeys = array('unparsed', 'c_id', 'c_pid', 'c_dbid', 'c_name', 'c_fU', 'c_fM', 'c_fP', 'c_fH', 'c_fD', 'c_codec', 'c_order', 'c_maxusers', 'c_created', 'c_topic', 'c_description');
		$uKeys = array('unparsed', 'p_id', 'p_nick', 'sa', 'ca', 'o', 'ao', 'v', 'av', 'cst', 'reg');
		$uRead = explode("\r\n", $uRead);
		$cList = array();
		foreach ($uRead as $row) {
			if (preg_match($cPattern, $row, $match)) {
				foreach ($match as $key => $val)
					$match["{$cKeys[$key]}"] = $val;
				$cList[] = $match;
			} elseif (preg_match($uPattern, $row, $match)) {
				foreach ($match as $key => $val)
					$match["{$uKeys[$key]}"] = $val;
				$cList[] = $match;
			}
		}
		return $cList;		
	}
	
/**
  * sadmin_playerInfo: Returns several information about a User and the server and channel rights of him
  *       Note: This function requires a login with a super admin account
  *		  Output: 
  * [0] => Array (
  *				[0], [unparsed]		=> Unparsed playerstring<br />
  *				[1], [p_id]			=> PlayerID<br />
  *             [2], [p_dbid]		=> Player Database ID<br />
  *				[3], [c_id]			=> Channel ID<br />
  * 			[4], [nickname]		=> Nickname<br />
  * 			[5], [loginname]	=> Loginname<br />
  * 			[6], [sa]			=> Server Administrator<br />

  *         	[7], [st]			=> Channel Sticky<br />
  *             [8], [ip]			=> IP<br />
  * )
  * [1, 2, 3, ...] => Array (
  *		[0], [unparsed] 		=> Unparsed Channelstring
  *		[1], [p_id]				=> Channel-ID
  *		[2], [p_dbpid]			=> Parent Channel
  *		[3], [c_id]				=> Channel-DBID
  *		[4], [nicknae]			=> Channel-Name
  *		[5], [loginname]		=> Channel Flag Unregistered
  *		[6], [sa]				=> Channel Flag Moderated
  *		[7], [st]				=> Channel Flag Private
  *		[8], [ip]				=> Channel Flag Subchannels
  * )
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		integer	$cID	Channel ID
  * @return     array channel information
  */	
	function sadmin_playerInfo($cID) {
		if (!$uRead = $this->_fastcall("PI $cID")) return false;
		$uPattern = '/^([0-9]+)\t([0-9]+)\t([0-9]+)\t"(.*)"\t"(.*)"\t([0-9]+)\t([0-9]+)\t"(.*)"\t$/';
		$uKeys = array('unparsed', 'p_id', 'p_dbid', 'c_id', 'nickname', 'loginname', 'sa', 'st', 'ip');
		$cPattern = '/^([0-9]+)\t"(.*)"\t([0-9]+)\t([0-9]+)\t([0-9]+)\t([0-9]+)\t([0-9]+)\t$/';
		$cKeys = array('unparsed', 'p_id', 'p_nick', 'sa', 'ca', 'o', 'ao', 'v', 'av');
		$uRead = explode("\r\n", $uRead);
		$cList = array();
		foreach ($uRead as $row) {
			if (preg_match($cPattern, $row, $match)) {
				foreach ($match as $key => $val)
					$match["{$cKeys[$key]}"] = $val;
				$cList[] = $match;
			} elseif (preg_match($uPattern, $row, $match)) {
				foreach ($match as $key => $val)
					$match["{$uKeys[$key]}"] = $val;
				$cList[] = $match;
			}
		}
		return $cList;		
	}
	
/**
  * sadmin_dbChannelInfo: Returns several information about a channels and its saved flags (kind of dbuserlist for channels)
  *       Note: This function requires a login with a super admin account
  *		  Output: 
  * [0] => Array (
  *		[0], [unparsed] 		=> Unparsed Channelstring
  *		[1], [c_dbid]			=> Channel Database ID
  *		[2], [c_dbpid]			=> Parent Channel Database ID
  *		[3], [c_name]			=> Channel-Name
  *		[4], [c_fU]				=> Channel Flag Unregistered
  *		[5], [c_fM]				=> Channel Flag Moderated
  *		[6], [c_fP]				=> Channel Flag Private
  *		[7], [c_fH]				=> Channel Flag Subchannels
  *		[8], [c_fD]				=> Channel Flag Default
  *		[9], [c_codec]			=> Channel Codec
  *		[10], [c_order]			=> Channel Order
  *		[11], [c_maxusers]		=> Channel MaxUsers
  *		[12], [c_created]		=> Channel Creation Date/Time
  *		[13], [c_topic]			=> Channel Topic
  *		[14], [c_desctiption]	=> Channel Description
  * )
  * [1, 2, 3, ...] => Array (
  *		[0], [unparsed]		=> Unparsed User String
  *		[1], [p_dbid]		=> Player Database ID
  *		[2], [loginname]	=> Nickname
  *		[3], [ca]			=> Server-Admin
  *		[4], [ao]			=> Channel-Admin
  *		[5], [av]			=> Operator
  * )
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		integer	$cID	Channel Database ID
  * @return     array channel information
  */	
	function sadmin_dbChannelInfo($cID) {
		if (!$uRead = $this->_fastcall("DBCI $cID")) return false;
		$cPattern = '/^([0-9]+)\t(.*)\t"(.*)"\t([0-9]+)\t([0-9]+)\t([0-9]+)\t([0-9]+)\t([0-9]+)\t([0-9]+)\t([0-9]+)\t([0-9]+)\t(.*)\t"(.*)"\t"(.*)"\t$/';
		$uPattern = '/^([0-9]+)\t(.*)\t([0-9]+)\t([0-9]+)\t([0-9]+)$/';
		$cKeys = array('unparsed', 'c_dbid', 'c_dbpid', 'c_name', 'c_fU', 'c_fM', 'c_fP', 'c_fH', 'c_fD', 'c_codec', 'c_order', 'c_maxusers', 'c_created', 'c_topic', 'c_description');
		$uKeys = array('unparsed', 'p_dbid', 'loginname', 'ca', 'ao', 'av');
		$uRead = explode("\r\n", $uRead);
		$cList = array();
		foreach ($uRead as $row) {
			if (preg_match($cPattern, $row, $match)) {
				foreach ($match as $key => $val)
					$match["{$cKeys[$key]}"] = $val;
				$cList[] = $match;
			} elseif (preg_match($uPattern, $row, $match)) {
				foreach ($match as $key => $val)
					$match["{$uKeys[$key]}"] = $val;
				$cList[] = $match;
			}
		}
		return $cList;		
	}
	
/**
  * sadmin_dbFindPlayer: Finds a player in the database based on a string
  *       Note: This function requires a login with a super admin account
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		string	$sQuery	Suchstring
  * @return     array search matches
  */	
	function sadmin_dbFindPlayer($sQuery) {
		if (!$uRead = $this->_fastcall("DBFP $sQuery")) return false;
		$uPattern = '/^([0-9]+)\t"(.*)"\t(.*)\t(.*)\t(.*)$/';
		$uRead = explode("\r\n", $uRead);
		$cList = array();
		foreach ($uRead as $row) {
			if (preg_match($uPattern, $row, $match))
				$cList[] = $match;
		}
		return $cList;		
	}
	
/**
  * sadmin_dbServerList: Lists all servers, there UDP-Port, ID, Name and Status
  *       Note: This function requires a login with a super admin account
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @return     array server list
  */	
	function sadmin_dbServerList() {
		if (!$uRead = $this->_fastcall("DBSERVERLIST")) return false;
		$uRead = explode("\r\n", $uRead);
		array_shift($uRead);
		$cList = array();
		foreach ($uRead as $row) {
			if (!strstr($row, "\t"))
				continue;
			$entry = explode("\t", $row);
			array_unshift($entry, $row);
			$entry[3] = substr($entry[3], 1, strlen($entry[3]) - 2);
			$cList[] = $entry;
		}
		return $cList;		
	}
	
/**
  * sadmin_dbServerInfo: Returns the data of a specified server
  *       Note: This function requires a login with a super admin account
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		integer $sID	serverid
  * @param		array	$sList	serverlist (optional)
  * @return     array server list
  */	
	function sadmin_dbServerInfo($sID, $sList=false) {
		if (!is_array($sList) && !$sList = $this->sadmin_dbServerList())
			return false;
		foreach ($sList as $key => $val) {
			if ($val[1] == $sID)
				return $val;
		}
		return false;
	}
	
/**
  * sadmin_serverStart: Starts the server
  *       Note: This function requires a login with a super admin account
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		integer $sID serverid
  * @return     boolean status
  */	
	function sadmin_serverStart($sID) {
		return ($this->_fastcall("SERVERSTART $sID") == CYTS_OK);	
	}
	
/**
  * sadmin_serverStop: Stops the server
  *       Note: This function requires a login with a super admin account
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @return     boolean status
  */	
	function sadmin_serverStop() {
		return ($this->_fastcall("SERVERSTOP") == CYTS_OK);	
	}
	
/**
  * sadmin_serverDelete: Deletes the server
  *       Note: This function requires a login with a super admin account
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		integer $sID serverid
  * @return     boolean status
  */	
	function sadmin_serverDelete($sID) {
		return ($this->_fastcall("SERVERDEL $sID") == CYTS_OK);	
	}
	
/**
  * sadmin_serverAdd: Adds a server
  *       Note: This function requires a login with a super admin account
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		integer $sUDP udp-port
  * @return     boolean status
  */	
	function sadmin_serverAdd($sUDP) {
		return ($this->_fastcall("SERVERADD $sUDP") == CYTS_OK);	
	}
	
/**
  * sadmin_serverSet: Sets a server variable
  *       Note: This function requires a login with a super admin account
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		string $sVar config-variable
  * @param		string $sVal config-value
  * @return     boolean status
  */	
	function sadmin_serverSet($sVar, $sVal) {
		return ($this->_fastcall("SERVERSET $sVar $sVal") == CYTS_OK);	
	}
	
/**
  * sadmin_logRead: Reads serverlog entries
  *       Note: This function requires a login with a super admin account
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		integer $lNum number of lines
  * @return     array logdata
  */	
	function sadmin_logRead($lNum) {
		$log = explode("\r\n", $this->_fastcall("LOG $lNum"));	
		array_pop($log);
		array_pop($log);
		return $log;
	}
	
/**
  * sadmin_logFind: Finds serverlog entries
  *       Note: This function requires a login with a super admin account
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		string $lQuery search querystring
  * @return     array logdata
  */	
	function sadmin_logFind($lQuery) {
		$log = explode("\r\n", $this->_fastcall("LOGFIND $lQuery"));	
		array_pop($log);
		array_pop($log);
		return $log;
	}
	
/**
  * sadmin_logWrite: Writes a line to logfile
  *       Note: This function requires a login with a super admin account
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		string $lLine line
  * @return     array logdata
  */	
	function sadmin_logWrite($lLine) {
		return ($this->_fastcall("LOGMARK $lLine") == CYTS_OK);	
	}
	
/**
  * sadmin_banPlayer: Bans a target Player
  *       Note: This function requires a login with a super admin account
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		integer	$pID	payerid
  * @param		integer	$bTime	bantime in minutes
  * @return     boolean success
  */	
	function sadmin_banPlayer($pID, $bTime) {
		return ($this->_fastcall("BANPLAYER $pID $bTime") == CYTS_OK);	
	}
	
/**
  * sadmin_banIP: Bans a target IP
  *       Note: This function requires a login with a super admin account
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		integer	$pIP	IP-Adress
  * @param		integer	$bTime	bantime in minutes
  * @return     boolean success
  */	
	function sadmin_banIP($pIP, $bTime) {
		return ($this->_fastcall("BANADD $pIP $bTime") == CYTS_OK);	
	}
	
/**
  * sadmin_banDel: Deletes a banentry
  *       Note: This function requires a login with a super admin account
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		integer	$bID	banid
  * @return     boolean success
  */	
	function sadmin_banDel($bID) {
		return ($this->_fastcall("BANDEL $bID") == CYTS_OK);	
	}
	
/**
  * sadmin_banClear: Deletes the banlist
  *       Note: This function requires a login with a super admin account
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		integer	$bID	banid
  * @return     boolean success
  */	
	function sadmin_banClear() {
		return ($this->_fastcall("BANCLEAR") == CYTS_OK);	
	}
	
/**
  * sadmin_banList: Lists current IP-Bans
  *       Note: This function requires a login with a super admin account
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @return     array banlist
  */	
	function sadmin_banList() {
		if (!$uRead = $this->_fastcall("BANLIST")) return false;
		$uRead = explode("\r\n", $uRead);
		array_shift($uRead);
		$cList = array();
		foreach ($uRead as $row) {
			if (!strstr($row, "\t"))
				continue;
			$entry = explode("\t", $row);
			array_unshift($entry, $row);
			$entry[5] = substr($entry[5], 1, strlen($entry[5]) - 2);
			$cList[] = $entry;
		}
		return $cList;				
	}
	
/**
  * sadmin_sppriv: Sets server privileges
  *       Note: This function requires a login with a super admin account
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		integer	$pID	payerid
  * @param		string	$sPriv	privilege
  * @param		string	$pVal	value
  * @return     boolean success
  */	
	function sadmin_sppriv($pID, $sPriv, $pVal) {
		return ($this->_fastcall("SPPRIV $pID $sPriv $pVal") == CYTS_OK);	
	}

/**
  * wi_readServerSettings: Reads the server settings from the webinterface
  *       Note: This function requires a login with a webinterface-activated admin account
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @return     array server vars
  */	
	function wi_readServerSettings() {
		if (!$sRead = $this->_wiget("/server_manager_settings.html")) return false;
		$pattern = '/<input.*?name="([a-zA-Z0-9]+)".*?value="(.*?)".*?>/im';
		$pattern2 = '/<input.*?name="serverudpport".*?value="(.*?)">*/im';
		if (!preg_match_all($pattern, $sRead[1], $matches)) return false;
		$data = array();
		foreach ($matches[1] as $key => $val) {
			if (strstr($matches[0][$key], 'type="checkbox"')) {
				$data[$val] = (strstr($matches[0][$key], "checked")) ? 1 : 0;
			} else {
				$data[$val] = $matches[2][$key];
			}
		}
		if (preg_match($pattern2, $sRead[1], $matches))
			$data["serverudpport"] = $matches[1];
		$data["servertype"] = (strstr($sRead[1], '<option selected value="1" >')) ? 1 : 2;
		return $data;
	}
	
/**
  * wi_writeServerSettings: Writes the server settings to the webinterface
  *       Note: This function requires a login with a webinterface-activated admin account
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		array $sData data to set [key => val]
  * @return     boolean success
  */		
	function wi_writeServerSettings($sData = array()) {
		if (!$cData = $this->wi_readServerSettings()) return false;
		$sData = array_merge($cData, $sData);
		$sKeys  = array("servername", "serverwelcomemessage", "serverpassword", "servertype", "serverwebpostposturl", "serverwebpostlinkurl");
		$ssKeys = array("servermaxusers", "CODECCelp51", "CODECSPEEX2150", "CODECCelp63", "CODECSPEEX3950", "CODECGSM148", "CODECSPEEX5950", "serverudpport",
						"CODECGSM164", "CODECSPEEX8000", "CODECWindowsCELP52", "CODECSPEEX11000", "CODECSPEEX15000", "CODECSPEEX18200", "CODECSPEEX24600");
		foreach ($sData as $key => $val) {
			if ((!in_array($key, $sKeys) && !in_array($key, $ssKeys) && $this->isSAdmin) || 
				(!in_array($key, $sKeys) && !$this->isSAdmin) || !$this->isAdmin)
				unset($sData[$key]);
		}
		if (!$this->_wipost("/settings_server.tscmd", $sData)) return false;
		if (!$cData = $this->wi_readServerSettings()) return false;
		foreach ($sData as $key => $val)
			if ($cData[$key] != $val)
				return false;
		return true; 
	}
	
/**
  * wi_readHostSettings: Reads the host settings from the webinterface
  *       Note: This function requires a login with a webinterface-activated admin account
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @return     array server vars
  */	
	function wi_readHostSettings() {
		if (!$sRead = $this->_wiget("/server_basic_settings.html")) return false;
		$pattern = '/<input.*?name="([a-zA-Z0-9_]+)".*?value="(.*?)".*?>/im';
		$pattern2 = '/<option value="(.*?)" selected>/im';
		if (!preg_match_all($pattern, $sRead[1], $matches)) return false;
		$data = array();
		foreach ($matches[1] as $key => $val) {
			if (strstr($matches[0][$key], 'type="checkbox"')) {
				$data[$val] = (strstr($matches[0][$key], "checked")) ? 1 : 0;
			} else {
				$data[$val] = $matches[2][$key];
			}
		}
		if (preg_match($pattern2, $sRead[1], $matches))
			$data["basic_country"] = $matches[1];
		return $data;
	}
	
/**
  * wi_writeHostSettings: Writes the host settings to the webinterface
  *       Note: This function requires a login with a webinterface-activated admin account
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param		array $sData data to set [key => val]
  * @return     boolean success
  */		
	function wi_writeHostSettings($sData = array()) {
		if (!$cData = $this->wi_readServerSettings()) return false;
		$sData = array_merge($cData, $sData);
		$ssKeys = array("basic_ispname", "basic_adminemail", "basic_isplinkurl", "basic_country", "basic_listpublic",
			"webpost_posturl", "webpost_enabled", "spam_maxcommands", "spam_inseconds");
		foreach ($sData as $key => $val) {
			if (!in_array($key, $ssKeys))
				unset($sData[$key]);
		}
		if (!$this->_wipost("/settings_basic.tscmd", $sData)) return false;
		if (!$cData = $this->wi_readHostSettings()) return false;
		foreach ($sData as $key => $val)
			if ($cData[$key] != $val)
				return false;
		return true; 
	}
	
/**
  * wi_readGroupPermissions: Reads the group permissions of the specified usergroup
  *       Note: This function requires a login with a webinterface-activated admin account
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param      string $class (sa | ca | op | v | r | u)
  * @return     array group permissions (permission => 0|1)
  */	
	function wi_readGroupPermissions($class) {
		$class = strtolower($class);
		$classes = array('sa', 'ca', 'op', 'v', 'r', 'u');
		if (!in_array($class, $classes, true)) return false;
		if (!$sRead = $this->_wiget("/server_manager_permission_$class.html")) return false;
		$pattern = '/<input.*?name="([a-zA-Z_]+)".*?value="1"(checked)*>/im';
		if (!preg_match_all($pattern, $sRead[1], $matches)) return false;
		$data = array();
		foreach ($matches[1] as $key => $val) {
			if ($matches[2][$key] == "checked")
				$matches[2][$key] = 1;
			else
				$matches[2][$key] = 0;
			$data[$val] = $matches[2][$key];
		}
		return $data;
	}
	
/**
  * wi_writeGroupPermissions: Writes the group permissions of the specified usergroup
  *       Note: This function requires a login with a webinterface-activated admin account
  *
  * @author     Steven Barth
  * @version    2.0
  * @access		public
  * @param      string	$class (sa | ca | op | v | r | u)
  * @param      array	$sData	group permissions (permission => 0|1)
  * @return		boolean success
  */	
	function wi_writeGroupPermissions($class, $sData = array()) {
		$class = strtolower($class);
		$classes = array('sa', 'ca', 'op', 'v', 'r', 'u');
		if (!in_array($class, $classes, true)) return false;
		if (!$cData = $this->wi_readGroupPermissions($class)) return false;
		foreach ($cData as $key => $val)
			if (isset($sData[$key]) && ($sData[$key] == 1 || $sData[$key] == 0))
				$cData[$key] = $sData[$key];
		if (!$this->_wipost("/permissions_server.tscmd", $cData)) return false;
		if (!$nData = $this->wi_readGroupPermissions($class)) return false;
		foreach ($cData as $key => $val)
			if ($nData[$key] != $val)
				return false;
		return true; 
	}
	
/**
 *
 * @access private
*/
	function __construct() {
		if (!defined("CYTS_OK")) {
		//You can use the following constants to determinate any encountered errors or returns
		define("CYTS_INVALID_ID", "ERROR, invalid id\r\n");
		define("CYTS_INVALID_PID", "ERROR, Playerid does not exist\r\n");
		define("CYTS_INVALID_CID", "ERROR, Channelid does not exist\r\n");
		define("CYTS_INVALID_AUTH", "ERROR, not logged in\r\n");
		define("CYTS_INVALID_PARAM", "ERROR, invalid paramcount\r\n");
		define("CYTS_INVALID_PERMS", "ERROR, invalid permissions\r\n");
		define("CYTS_INVALID_LOGIN", "ERROR, invalid login\r\n");
		define("CYTS_INVALID_SERVER", "ERROR, no server selected\r\n");
		define("CYTS_INVALID_NUMBER", "ERROR, invalid number format\r\n");
		define("CYTS_INVALID_PASSWD", "ERROR, passwort dont match\r\n");
		define("CYTS_SYN", "[TS]\r\n");
		define("CYTS_OK", "OK\r\n");

		//You can use the following constants as parameters in some functions
		define("CYTS_MOVE", 1);
		define("CYTS_KICK", 2);
		define("CYTS_REMOVE", 3);
		define("CYTS_UNREGUSER", 1);
		define("CYTS_REGUSER", 2);
		define("CYTS_UNREGCHANNEL", 4);
		define("CYTS_REGCHANNEL", 8);
		}

		$this->sCon     = false;
		$this->debug    = array();
		$this->isAdmin  = false;
		$this->isSAdmin = false;
		$this->cList    = false;
		$this->uList    = false;
		$this->server   = false;
		$this->user     = false;
		$this->pass     = false;
		$this->udp      = false;
		$this->tcp      = false;
		$this->wiPort   = false;
		$this->wiCookie = false;
	}
	
/**
 *
 * @access private
*/
	function __destruct() {
		$this->disconnect();
	}

/**
  * _fastcall: Executes a command
  *
  * @access		private
  * @author     Steven Barth
  * @param		string $sCall Command
  * @version    2.0
  * @return     string returns the server's return data
  */  	
	function _fastcall($sCall = "") {
		if (!is_resource($this->sCon))
			return false;
		$sCall = chop($sCall);
		if (strstr($sCall, "\n"))
			return false;
		if (!is_array($sCall)) {
			fwrite($this->sCon, "$sCall\n");
			$sRead = $this->_readcall();
			$this->debug[] = array("cmd" => $sCall, "rpl" => $sRead);
		} else {
			$sRead = array();
			foreach ($sCall as $sCmd) {
				fwrite($this->sCon, "$sCmd\n");
				$cRes = $this->_readcall();
				$this->debug[] = array("cmd" => $sCmd, "rpl" => $cRes);
				$sRead[] = $cRes;
				unset($cRes);
			}
		}
		return $sRead;
	}
	
/**
  * _extendcall: Executes a command and restes the channel & user lists
  *
  * @access		private
  * @author     Steven Barth
  * @param		string $sCall Command
  * @version    2.0
  * @return     string returns the server's return data
  */  	
	function _extendcall($sCall = "") {
		$sRead = $this->_fastcall($sCall);
		$this->cList = false;
		$this->uList = false;
		return $sRead;	
	}
	
/**
  * _readcall: Reads data from the socket
  *
  * @access		private
  * @author     Steven Barth
  * @version    2.0
  * @return     string returns the server's return data
  */ 
	function _readcall() {
		if (!is_resource($this->sCon))
			return false;
		$sRead = '';
		do {
			$cRead = fgets($this->sCon);
			$sRead .= $cRead;
		} while ($cRead != CYTS_SYN && $cRead != CYTS_OK && strtoupper(substr($cRead, 0, 5)) != "ERROR");
		return $sRead;
	}
	
/**
  * _wipost: Sends a Request to the Webinterface using HTTP POST Method
  *
  * @access		private
  * @author     Steven Barth
  * @version    2.0
  * @return     string returns the server's return data
  */ 
	function _wipost($sFile, $sCall=array(), $sTimeout = 3) {
		if (!$this->wiPort) return false;
		$pCall = array();
		foreach ($sCall as $key => $val) {
			$pCall[] = "$key=".urlencode($val);
		}
		$sCall = implode("&", $pCall);
 		$fp = @fsockopen($this->server, $this->wiPort, $errno, $errstr, $sTimeout);
		if (!$fp) return false;
		fputs($fp, "POST $sFile HTTP/1.1\r\n");
		fputs($fp, "Host: $this->server\r\n");
		fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
		if ($this->wiCookie)
			fputs($fp, "Cookie: ".$this->wiCookie."\r\n");
		fputs($fp, "Content-length: ". strlen($sCall) ."\r\n");
		fputs($fp, "Connection: close\r\n\r\n");
		fputs($fp, $sCall);
		$hPattern = '/([A-Za-z0-9_-]+): *(.*)\r\n/i';		
		$header = array();
		do {
			$cRead = fgets($fp);
			if (preg_match($hPattern, $cRead, $content))
				$header["{$content[1]}"] = $content[2];
			elseif (trim($cRead) != "")
				$header[] = trim($cRead);
		} while($cRead != "\r\n");
		if (!isset($header["Content-Length"])) {
			$content = "";
		} else {
			$dLen =	$header["Content-Length"];
			$content = '';
			while ($dLen >= 1024) {
				$content .= fread($fp, 1024);
				$dLen -= 1024;
			}
			if ($dLen > 0)
				$content .= fread($fp, $dLen);
		}
		fclose($fp);
		return array($header, $content);
	}
	
/**
  * _wiget: Sends a Request to the Webinterface using HTTP GET Method
  *
  * @access		private
  * @author     Steven Barth
  * @version    2.0
  * @return     string returns the server's return data
  */ 
	function _wiget($sFile, $sTimeout = 3) {
		if (!$this->wiPort) return false;
 		$fp = @fsockopen($this->server, $this->wiPort, $errno, $errstr, $sTimeout);
		if (!$fp) return false;
		fputs($fp, "GET $sFile HTTP/1.1\r\n");
		fputs($fp, "Host: $this->server\r\n");
		if ($this->wiCookie)
			fputs($fp, "Cookie: ".$this->wiCookie."\r\n");
		fputs($fp, "Connection: close\r\n\r\n");
		$hPattern = '/([A-Za-z0-9_-]+): *(.*)\r\n/i';		
		$header = array();
		do {
			$cRead = fgets($fp);
			if (preg_match($hPattern, $cRead, $content))
				$header["{$content[1]}"] = $content[2];
			elseif (trim($cRead) != "")
				$header[] = trim($cRead);
		} while($cRead != "\r\n");
		if (!isset($header["Content-Length"])) {
			$content = "";
		} else {
			$dLen =	$header["Content-Length"];
			$content = '';
			while ($dLen >= 1024) {
				$content .= fread($fp, 1024);
				$dLen -= 1024;
			}
			if ($dLen > 0)
				$content .= fread($fp, $dLen);
		}
		fclose($fp);
		return array($header, $content);
	}
}
?>