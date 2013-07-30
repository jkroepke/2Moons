<?PHP
/**
 *                         ts3admin.class.php
 *                         ------------------                    
 *   begin                : 18. December 2009
 *   copyright            : (C) 2009-2013 Par0noid Solutions
 *   email                : contact@ts3admin.info
 *   version              : 0.6.8.1
 *   last modified        : 03. March 2013
 *
 *
 *  This file is a powerful library for querying TeamSpeak3 servers.
 *  
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *  
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *  
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/** 
 * The ts3admin.class.php is a powerful library that offers functions to communicate with Teamspeak 3 Servers from your website!
 * 
 * You can do everything, your creativity knows no bounds!
 * That library is faster than all other librarys because its optimized to find the shortest way to your information.
 * No unneeded PHP 5 OOP Stuff, just the basics!
 * There are a lot of professional developers and some big companys using my library.
 * The best thing is that you can use it for free under the terms of the GNU General Public License v3.
 * Take a look on the project website where you can find code examples, a manual and some other stuff.
 * 
 * @author      Par0noid Solutions <contact@ts3admin.info>
 * @version     0.6.8.1
 * @copyright   Copyright (c) 2009-2013, Stefan Z.
 * @package		ts3admin
 * @link        http://ts3admin.info
 */

class ts3admin {

//*******************************************************************************************	
//****************************************** Vars *******************************************
//*******************************************************************************************

/**
  * runtime is an private handle and configuration storage
  *
  * @author     Par0noid Solutions
  * @access		private
  */
	private $runtime = array('socket' => '', 'selected' => false, 'host' => '', 'queryport' => '10011', 'timeout' => 2, 'debug' => array(), 'fileSocket' => '');


//*******************************************************************************************	
//************************************ Public Functions *************************************
//******************************************************************************************

/**
  * banAddByIp
  *
  * Adds a new ban rule on the selected virtual server.
  *
  *	<b>Output:</b>
  * <code>
  * Array
  * {
  *  [banid] => 109
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string	$ip			clientIp
  * @param		integer	$time		bantime in seconds (0=unlimited)
  * @param		string	$banreason	Banreason [optional]
  * @return     array banId
  */
	function banAddByIp($ip, $time, $banreason = NULL) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		
		if(!empty($banreason)) { $msg = ' banreason='.$this->escapeText($banreason); } else { $msg = NULL; }

		return $this->getData('array', 'banadd ip='.$ip.' time='.$time.$msg);
	}

/**
  * banAddByUid
  *
  *	Adds a new ban rule on the selected virtual server.
  *
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [banid] => 110
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string	$uid		clientUniqueId
  * @param		integer	$time		bantime in seconds (0=unlimited)
  * @param		string	$banreason	Banreason [optional]
  * @return     array banId
  */
	function banAddByUid($uid, $time, $banreason = NULL) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		
		if(!empty($banreason)) { $msg = ' banreason='.$this->escapeText($banreason); } else { $msg = NULL; }
		
		return $this->getData('array', 'banadd uid='.$uid.' time='.$time.$msg);
	}

/**
  * banAddByName
  *
  *	Adds a new ban rule on the selected virtual server.
  *
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [banid] => 111
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string	$name		clientName
  * @param		integer	$time		bantime in seconds (0=unlimited)
  * @param		string	$banreason	Banreason [optional]
  * @return     array banId
  */
	function banAddByName($name, $time, $banreason = NULL) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		
		if(!empty($banreason)) { $msg = ' banreason='.$this->escapeText($banreason); } else { $msg = NULL; }
										
		return $this->getData('array', 'banadd name='.$this->escapeText($name).' time='.$time.$msg);
	}

/**
  * banClient
  * 
  * Bans the client specified with ID clid from the server. Please note that this will create two separate ban rules for the targeted clients IP address and his unique identifier.
  *
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [1] => 129
  *  [2] => 130
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $clid		clientId
  * @param		integer $time		bantime in seconds (0=unlimited)
  * @param		string	$banreason	Banreason [optional]
  * @return     array banIds
  */
	function banClient($clid, $time, $banreason = NULL) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		
		if(!empty($banreason)) { $msg = ' banreason='.$this->escapeText($banreason); } else { $msg = ''; }
		
		$result = $this->getData('plain', 'banclient clid='.$clid.' time='.$time.$msg);
		
		if($result['success']) {
			return $this->generateOutput(true, $result['errors'], $this->splitBanIds($result['data']));
		}else{
			return $this->generateOutput(false, $result['errors'], false);
		}
	}

/**
  * banDelete
  * 
  * Deletes the ban rule with ID banid from the server.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $banID	banID
  * @return     boolean success
  */
	function banDelete($banID) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('boolean', 'bandel banid='.$banID);
	}

/**
  * banDeleteAll
  * 
  * Deletes all active ban rules from the server.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @return     boolean success
  */
	function banDeleteAll() {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('boolean', 'bandelall');
	}

/**
  * banList
  * 
  * Displays a list of active bans on the selected virtual server.
  * 
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [banid] => 131
  *  [ip] => 1.2.3.4
  *  [name] => eugen
  *  [uid] => IYAntAcZHgVC7s3n3DNWmuJB/aM=
  *  [created] => 1286660391
  *  [duration] => 0
  *  [invokername] => Par0noid
  *  [invokercldbid] => 2086
  *  [invokeruid] => nUixbsq/XakrrmbqU8O30R/D8Gc=
  *  [reason] => insult
  *  [enforcements] => 0
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @return     array banlist
  */
	function banList() {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }		
		return $this->getData('multi', 'banlist');
	}

/**
  * bindingList
  * 
  * Displays a list of IP addresses used by the server instance on multi-homed machines.
  *
  * <b>Output:</b><br>
  * <code>
  * Array
  * {
  *  [ip] => 0.0.0.0
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @return     array bindingList
  */
	function bindingList() {
		return $this->getData('multi', 'bindinglist');
	}

/**
  * channelAddPerm
  * 
  * Adds a set of specified permissions to a channel. Multiple permissions can be added by providing the two parameters of each permission. A permission can be specified by permid or permsid.
  * 
  * <b>Input-Array like this:</b>
  * <code>
  * $permissions = array();
  * $permissions['permissionID'] = 'permissionValue';
  * //or you could use Permission Name
  * $permissions['permissionName'] = 'permissionValue';
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer	$cid			channelId
  * @param		array	$permissions	permissions
  * @return     boolean success
  */
	function channelAddPerm($cid, $permissions) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		
		if(count($permissions) > 0) {
			//Permissions given
			
			//Errorcollector
			$errors = array();
			
			//Split Permissions to prevent query from overload
			$permissions = array_chunk($permissions, 50, true);
			
			//Action for each splitted part of permission
			foreach($permissions as $permission_part)
			{
				//Create command_string for each command that we could use implode later
				$command_string = array();
				
				foreach($permission_part as $key => $value)
				{
					$command_string[] = (is_numeric($key) ? "permid=" : "permsid=").$this->escapeText($key).' permvalue='.$value;
				}
				
				$result = $this->getData('boolean', 'channeladdperm cid='.$cid.' '.implode('|', $command_string));
				
				if(!$result['success'])
				{
					foreach($result['errors'] as $error)
					{
						$errors[] = $error;
					}
				}
			}
			
			if(count($errors) == 0)
			{
				return $this->generateOutput(true, array(), true);
			}else{
				return $this->generateOutput(false, $errors, false);
			}
			
		}else{
			// No permissions given
			$this->addDebugLog('no permissions given');
			return $this->generateOutput(false, array('Error: no permissions given'), false);
		}
	}

/**
  * channelClientAddPerm
  * 
  * Adds a set of specified permissions to a client in a specific channel. Multiple permissions can be added by providing the three parameters of each permission. A permission can be specified by permid or permsid.
  * 
  * <b>Input-Array like this:</b>
  * <code>
  * $permissions = array();
  * $permissions['permissionID'] = 'permissionValue';
  * //or you could use Permission Name
  * $permissions['permissionName'] = 'permissionValue';
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer		$cid			channelID
  * @param		integer		$cldbid			clientDBID
  * @param		array		$permissions	permissions
  * @return     boolean success
  */
	function channelClientAddPerm($cid, $cldbid, $permissions) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		
		if(count($permissions) > 0) {
			//Permissions given
				
			//Errorcollector
			$errors = array();
				
			//Split Permissions to prevent query from overload
			$permissions = array_chunk($permissions, 50, true);
				
			//Action for each splitted part of permission
			foreach($permissions as $permission_part)
			{
				//Create command_string for each command that we could use implode later
				$command_string = array();
		
				foreach($permission_part as $key => $value)
				{
					$command_string[] = (is_numeric($key) ? "permid=" : "permsid=").$this->escapeText($key).' permvalue='.$value;
				}
		
				$result = $this->getData('boolean', 'channelclientaddperm cid='.$cid.' cldbid='.$cldbid.' '.implode('|', $command_string));
		
				if(!$result['success'])
				{
					foreach($result['errors'] as $error)
					{
						$errors[] = $error;
					}
				}
			}
				
			if(count($errors) == 0)
			{
				return $this->generateOutput(true, array(), true);
			}else{
				return $this->generateOutput(false, $errors, false);
			}
				
		}else{
			// No permissions given
			$this->addDebugLog('no permissions given');
			return $this->generateOutput(false, array('Error: no permissions given'), false);
		}
	}

/**
  * channelClientDelPerm
  * 
  * Removes a set of specified permissions from a client in a specific channel. Multiple permissions can be removed at once. A permission can be specified by permid or permsid.
  *
  * <b>Input-Array like this:</b>
  * <code>
  * $permissions = array();
  * $permissions[] = 'permissionID';
  * $permissions[] = 'permissionName';
  * //or
  * $permissions = array('permissionID', 'permissionName', 'permissionID');
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer		$cid				channelID
  * @param		integer		$cldbid				clientDBID
  * @param		array		$permissions		permissions
  * @return     boolean success
  */
	function channelClientDelPerm($cid, $cldbid, $permissions) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		$permissionArray = array();
		
		if(count($permissionIds) > 0) {
			foreach($permissionIds AS $value) {
				$permissionArray[] = is_numeric($value) ? 'permid='.$value : 'permsid='.$value;
			}
			return $this->getData('boolean', 'channelclientdelperm cid='.$cid.' cldbid='.$cldbid.' '.implode('|', $permissionArray));
		}else{
			$this->addDebugLog('no permissions given');
			return $this->generateOutput(false, array('Error: no permissions given'), false);
		}
	}

/**
  * channelClientPermList
  * 
  * Displays a list of permissions defined for a client in a specific channel.
  *
  * <b>Output:</b><br>
  * <code>
  * Array
  * {
  *  [cid] => 250 (only in first result)
  *  [cldbid] => 2086 (only in first result)
  *  [permid] => 12876 (if permsid = false)
  *  [permsid] => b_client_info_view (if permsid = true)
  *  [permvalue] => 1
  *  [permnegated] => 0
  *  [permskip] => 0
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer		$cid		channelID
  * @param		integer		$cldbid		clientDBID
  * @param		boolean		$permsid	displays permissionName instead of permissionID
  * @return     array	channelclientpermlist
  */
	function channelClientPermList($cid, $cldbid, $permsid = false) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }		
		return $this->getData('multi', 'channelclientpermlist cid='.$cid.' cldbid='.$cldbid.($permsid ? ' -permsid' : ''));
	}

/**
  * channelCreate
  * 
  * Creates a new channel using the given properties and displays its ID. Note that this command accepts multiple properties which means that you're able to specifiy all settings of the new channel at once.
  * 
  * <b style="color:red">Hint:</b> don't forget to set channel_flag_semi_permanent = 1 or channel_flag_permanent = 1
  * 
  * <b style="color:red">Hint:</b> you'll get an error if you want to create a channel without channel_name
  * 
  * <b>Input-Array like this:</b>
  * <code>
  * $data = array();
  * 
  * $data['setting'] = 'value';
  * $data['setting'] = 'value';
  * </code>
  * 
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [cid] => 257
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		array $data properties
  * @return     array channelInfo
  */
	function channelCreate($data) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		
		$propertiesString = '';
		
		foreach($data as $key => $value) {
			$propertiesString .= ' '.$key.'='.$this->escapeText($value);
		}
		
		return $this->getData('array', 'channelcreate '.$propertiesString);
	}

/**
  * channelDelete
  * 
  * Deletes an existing channel by ID. If force is set to 1, the channel will be deleted even if there are clients within. The clients will be kicked to the default channel with an appropriate reason message.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $cid channelID
  * @param		integer $force {1|0} (default: 1)
  * @return     boolean success
  */
	function channelDelete($cid, $force = 1) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('boolean', 'channeldelete cid='.$cid.' force='.$force);
	}

/**
  * channelDelPerm
  * 
  * Removes a set of specified permissions from a channel. Multiple permissions can be removed at once. A permission can be specified by permid or permsid.
  *
  * <b>Input-Array like this:</b>
  * <code>
  * $permissions = array();
  * $permissions[] = 'permissionID';
  * //or you could use
  * $permissions[] = 'permissionName';
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer		$cid				channelID
  * @param		array		$permissions		permissions
  * @return     boolean	success
  */
	function channelDelPerm($cid, $permissions) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		$permissionArray = array();
		
		if(count($permissions) > 0) {
			foreach($permissions AS $value) {
				$permissionArray[] = (is_numeric($value) ? 'permid=' : 'permsid=').$value;
			}
			return $this->getData('boolean', 'channeldelperm cid='.$cid.' '.implode('|', $permissionArray));
		}else{
			$this->addDebugLog('no permissions given');
			return $this->generateOutput(false, array('Error: no permissions given'), false);
		}
	}

/**
  * channelEdit
  * 
  * Changes a channels configuration using given properties. Note that this command accepts multiple properties which means that you're able to change all settings of the channel specified with cid at once.
  *
  * <b>Input-Array like this:</b>
  * <code>
  * $data = array();
  *	
  * $data['setting'] = 'value';
  * $data['setting'] = 'value';
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer	$cid	$channelID
  * @param		array	$data	edited settings
  * @return     boolean success
  */
	function channelEdit($cid, $data) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		
		$settingsString = '';
		
		foreach($data as $key => $value) {
			$settingsString .= ' '.$key.'='.$this->escapeText($value);
		}

		return $this->getData('boolean', 'channeledit cid='.$cid.$settingsString);
	}

/**
  * channelFind
  * 
  * displays a list of channels matching a given name pattern.
  *
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [cid] => 2
  *  [channel_name] => Lobby
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string	$pattern	channelName
  * @return     array channelList 
  */
	function channelFind($pattern) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('multi', 'channelfind pattern='.$this->escapeText($pattern));
	}

/**
  * channelGroupAdd
  * 
  * Creates a new channel group using a given name and displays its ID. The optional type parameter can be used to create ServerQuery groups and template groups.
  *
  * <b>groupDbTypes:</b>
  *	<ol start="0">
  *		<li>template group (used for new virtual servers)</li>
  *		<li>regular group (used for regular clients)</li>
  *		<li>global query group (used for ServerQuery clients)</li>
  *	</ol>
  *
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [cgid] => 86
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer	$name	groupName
  * @param		integer	$type   groupDbType [optional] (default: 1)
  * @return     boolean success
  */
	function channelGroupAdd($name, $type = 1) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('array', 'channelgroupadd name='.$this->escapeText($name).' type='.$type);
	}

/**
  * channelGroupAddPerm
  * 
  * Adds a set of specified permissions to a channel group. Multiple permissions can be added by providing the two parameters of each permission. A permission can be specified by permid or permsid.
  *
  * <b>Input-Array like this:</b>
  * <code>
  * $permissions = array();
  * $permissions['permissionID'] = 'permissionValue';
  * //or you could use:
  * $permissions['permissionName'] = 'permissionValue';
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer		$cgid			channelGroupID
  * @param		array		$permissions	permissions
  * @return     boolean success
  */
	function channelGroupAddPerm($cgid, $permissions) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		
		if(count($permissions) > 0) {
			//Permissions given
		
			//Errorcollector
			$errors = array();
		
			//Split Permissions to prevent query from overload
			$permissions = array_chunk($permissions, 50, true);
		
			//Action for each splitted part of permission
			foreach($permissions as $permission_part)
			{
				//Create command_string for each command that we could use implode later
				$command_string = array();
		
				foreach($permission_part as $key => $value)
				{
					$command_string[] = (is_numeric($key) ? "permid=" : "permsid=").$this->escapeText($key).' permvalue='.$value;
				}
		
				$result = $this->getData('boolean', 'channelgroupaddperm cgid='.$cid.' '.implode('|', $command_string));
		
				if(!$result['success'])
				{
					foreach($result['errors'] as $error)
					{
						$errors[] = $error;
					}
				}
			}
		
			if(count($errors) == 0) {
				return $this->generateOutput(true, array(), true);
			}else{
				return $this->generateOutput(false, $errors, false);
			}
		
		}else{
			// No permissions given
			$this->addDebugLog('no permissions given');
			return $this->generateOutput(false, array('Error: no permissions given'), false);
		}
	}

/**
  * channelGroupClientList
  * 
  * Displays all the client and/or channel IDs currently assigned to channel groups. All three parameters are optional so you're free to choose the most suitable combination for your requirement
  *
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [cid] => 2
  *  [cldbid] => 9
  *  [cgid] => 9
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $cid		channelID [optional]
  * @param		integer $cldbid		clientDBID [optional]
  * @param		integer $cgid		channelGroupID [optional]
  * @return     array channelGroupClientList
  */
	function channelGroupClientList($cid = NULL, $cldbid = NULL, $cgid = NULL) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		
		return $this->getData('multi', 'channelgroupclientlist'.(!empty($cid) ? ' cid='.$cid : '').(!empty($cldbid) ? ' cldbid='.$cldbid : '').(!empty($cgid) ? ' cgid='.$cgid : ''));
	}

/**
  * channelGroupCopy
  * 
  * Creates a copy of the channel group specified with scgid. If tcgid is set to 0, the server will create a new group. To overwrite an existing group, simply set tcgid to the ID of a designated target group. If a target group is set, the name parameter will be ignored. The type parameter can be used to create ServerQuery groups and template groups.
  *
  * <b>groupDbTypes:</b>
  *	<ol start="0">
  *		<li>template group (used for new virtual servers)</li>
  *		<li>regular group (used for regular clients)</li>
  *		<li>global query group (used for ServerQuery clients)</li>
  *	</ol>
  *
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [cgid] => 86
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer	$scgid	sourceChannelGroupID
  * @param		integer	$tcgid	targetChannelGroupID 
  * @param		integer $name	groupName
  * @param		integer	$type	groupDbType
  * @return     array groupId
  */
	function channelGroupCopy($scgid, $tcgid, $name, $type = 1) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('array', 'channelgroupcopy scgid='.$scgid.' tcgid='.$tcgid.' name='.$this->escapeText($name).' type='.$type);
	}

/**
  * channelGroupDelete
  * 
  * Deletes a channel group by ID. If force is set to 1, the channel group will be deleted even if there are clients within.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $cgid	channelGroupID
  * @param		integer $force	forces deleting channelGroup (default: 1)
  * @return     boolean success
  */
	function channelGroupDelete($cgid, $force = 1) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('boolean', 'channelgroupdel cgid='.$cgid.' force='.$force);
	}

/**
  * channelGroupDelPerm
  * 
  * Removes a set of specified permissions from the channel group. Multiple permissions can be removed at once. A permission can be specified by permid or permsid.
  *
  * <b>Input-Array like this:</b>
  * <code>
  * $permissions = array();
  * $permissions[] = 'permissionID';
  * $permissions[] = 'permissionName';
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer		$cgid				channelGroupID
  * @param		array		$permissions		permissions
  * @return     boolean success
  */
	function channelGroupDelPerm($cgid, $permissions) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		$permissionArray = array();
		
		if(count($permissionIds) > 0) {
			foreach($permissionIds AS $value) {
				$permissionArray[] = (is_numeric($value) ? 'permid=' : 'permsid=').$value;
			}
			return $this->getData('boolean', 'channelgroupdelperm cgid='.$cgid.' '.implode('|', $permissionArray));
		}else{
			$this->addDebugLog('no permissions given');
			return $this->generateOutput(false, array('Error: no permissions given'), false);
		}
	}

/**
  * channelGroupList
  * 
  * Displays a list of channel groups available on the selected virtual server.
  * 
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [cgid] => 3
  *  [name] => Testname
  *  [type] => 0
  *  [iconid] => 100
  *  [savedb] => 1
  *  [sortid] => 0
  *  [namemode] => 0
  *  [n_modifyp] => 75
  *  [n_member_addp] => 50
  *  [n_member_removep] => 50
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @return     array channelGroupList
  */
	function channelGroupList() {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		
		return $this->getData('multi', 'channelgrouplist');
	}

/**
  * channelGroupPermList
  * 
  * Displays a list of permissions assigned to the channel group specified with cgid.
  * If the permsid option is specified, the output will contain the permission names instead of the internal IDs.
  * 
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [permid] => 8471 (displayed if permsid is false)
  *  [permsid] => i_channel_create_modify_with_codec_latency_factor_min (displayed if permsid is true)
  *  [permvalue] => 1
  *  [permnegated] => 0
  *  [permskip] => 0
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer		$cgid		channelGroupID
  * @param		boolean		$permsid	permsid
  * @return		array	channelGroupPermlist
  */
  	function channelGroupPermList($cgid, $permsid = false) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }		
		return $this->getData('multi', 'channelgrouppermlist cgid='.$cgid.($permsid ? ' -permsid' : ''));
	}

/**
  * channelGroupRename
  * 
  * Changes the name of a specified channel group.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $cgid groupID
  * @param		integer $name groupName
  * @return     boolean success
  */
	function channelGroupRename($cgid, $name) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('boolean', 'channelgrouprename cgid='.$cgid.' name='.$this->escapeText($name));
	}

/**
  * channelInfo
  *
  *	Displays detailed configuration information about a channel including ID, topic, description, etc.

  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [pid] => 0
  *  [channel_name] => Test
  *  [channel_topic] => 
  *  [channel_description] => 
  *  [channel_password] => cc97Pm4oOYq0J9fXDAgiWv/qScQ=
  *  [channel_codec] => 2
  *  [channel_codec_quality] => 7
  *  [channel_maxclients] => -1
  *  [channel_maxfamilyclients] => -1
  *  [channel_order] => 1
  *  [channel_flag_permanent] => 1
  *  [channel_flag_semi_permanent] => 0
  *  [channel_flag_default] => 0
  *  [channel_flag_password] => 0
  *  [channel_codec_latency_factor] => 1
  *  [channel_codec_is_unencrypted] => 1
  *  [channel_flag_maxclients_unlimited] => 1
  *  [channel_flag_maxfamilyclients_unlimited] => 0
  *  [channel_flag_maxfamilyclients_inherited] => 1
  *  [channel_filepath] => files\\virtualserver_1\\channel_2
  *  [channel_needed_talk_power] => 0
  *  [channel_forced_silence] => 0
  *  [channel_name_phonetic] => 
  *  [channel_icon_id] => 0
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $cid channelID
  * @return     array channelInfo
  */
	function channelInfo($cid) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('array', 'channelinfo cid='.$cid);
	}

/**
  * channelList
  * 
  * Displays a list of channels created on a virtual server including their ID, order, name, etc. The output can be modified using several command options.
  *
  * <br><b>Possible parameters:</b> [-topic] [-flags] [-voice] [-limits] [-icon]<br><br>
  *
  * <b>Output: (without parameters)</b>
  * <code>
  * Array
  * {
  *  [cid] => 2
  *  [pid] => 0
  *  [channel_order] => 1
  *  [channel_name] => Test
  *  [total_clients] => 0
  *  [channel_needed_subscribe_power] => 0
  * }
  * </code><br>
  * <b>Output: (from parameters)</b>
  * <code>
  * Array
  * {
  *  [-topic] => [channel_topic] => Default Channel has no topic
  *  [-flags] => [channel_flag_default] => 1
  *  [-flags] => [channel_flag_password] => 0
  *  [-flags] => [channel_flag_permanent] => 1
  *  [-flags] => [channel_flag_semi_permanent] => 0
  *  [-voice] => [channel_codec] => 2
  *  [-voice] => [channel_codec_quality] => 7
  *  [-voice] => [channel_needed_talk_power] => 0
  *  [-limits] => [total_clients_family] => 1
  *  [-limits] => [channel_maxclients] => -1
  *  [-limits] => [channel_maxfamilyclients] => -1
  *  [-icon] => [channel_icon_id] => 0
  * }
  * </code><br>
  * <b>Usage:</b>
  * <code>
  * $ts3->channelList(); //No parameters
  * $ts3->channelList("-flags"); //Single parameter
  * $ts3->channelList("-topic -flags -voice -limits -icon"); //Multiple parameters / all
  * </code><br>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string		$params		additional parameters [optional]
  * @return		array	channelList
  */
	function channelList($params = null) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		if(!empty($params)) { $params = ' '.$params; }
		
		return $this->getData('multi', 'channellist'.$params);
	}

/**
  * channelMove
  * 
  * Moves a channel to a new parent channel with the ID cpid. If order is specified, the channel will be sorted right under the channel with the specified ID. If order is set to 0, the channel will be sorted right below the new parent.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $cid	channelID
  * @param		integer $cpid	channelParentID
  * @param		integer $order	channelSortOrder
  * @return     boolean success
  */
	function channelMove($cid, $cpid, $order = null) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }		
		return $this->getData('boolean', 'channelmove cid='.$cid.' cpid='.$cpid.($order != null ? ' order='.$order : ''));
	}

/**
  * channelPermList
  * 
  * Displays a list of permissions defined for a channel.
  *
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [cid] => 2 (only in first result)
  *  [permid] => 8471 (if permsid = false)
  *  [permsid] => i_channel_needed_delete_power (if permsid = true)
  *  [permvalue] => 1
  *  [permnegated] => 0
  *  [permskip] => 0
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer		$cid		channelID
  * @param		boolean		$permsid	displays permissionName instead of permissionID [optional]
  * @return     array channelpermlist
  */
	function channelPermList($cid, $permsid = false) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }	
		return $this->getData('multi', 'channelpermlist cid='.$cid.($permsid ? ' -permsid' : ''));
	}

/**
  * clientAddPerm
  * 
  * Adds a set of specified permissions to a client. Multiple permissions can be added by providing the three parameters of each permission. A permission can be specified by permid or permsid.
  *
  * <b>Input-Array like this:</b>
  * <code>
  * $permissions = array();
  * $permissions['permissionID'] = 'permissionValue';
  * //or you could use Permission Name
  * $permissions['permissionName'] = 'permissionValue';
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer	$cldbid			clientDBID
  * @param		array	$permissions	permissions
  * @return     boolean success
  */
	function clientAddPerm($cldbid, $permissions) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		
		if(count($permissions) > 0) {
			//Permissions given
				
			//Errorcollector
			$errors = array();
				
			//Split Permissions to prevent query from overload
			$permissions = array_chunk($permissions, 50, true);
				
			//Action for each splitted part of permission
			foreach($permissions as $permission_part)
			{
				//Create command_string for each command that we could use implode later
				$command_string = array();
		
				foreach($permission_part as $key => $value)
				{
					$command_string[] = (is_numeric($key) ? "permid=" : "permsid=").$this->escapeText($key).' permvalue='.$value;
				}
		
				$result = $this->getData('boolean', 'clientaddperm cldbid='.$cldbid.' '.implode('|', $command_string));
		
				if(!$result['success'])
				{
					foreach($result['errors'] as $error)
					{
						$errors[] = $error;
					}
				}
			}
				
			if(count($errors) == 0)
			{
				return $this->generateOutput(true, array(), true);
			}else{
				return $this->generateOutput(false, $errors, false);
			}
		}else{
			// No permissions given
			$this->addDebugLog('no permissions given');
			return $this->generateOutput(false, array('Error: no permissions given'), false);
		}
	}

/**
  * clientDbDelete
  * 
  * Deletes a clients properties from the database.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $cldbid	clientDBID
  * @return     boolean success
  */
	function clientDbDelete($cldbid) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('boolean', 'clientdbdelete cldbid='.$cldbid);
	}

/**
  * clientDbEdit
  * 
  * Changes a clients settings using given properties.
  *
  * <b>Input-Array like this:</b><br>
  * <br><code>
  * $data = array();
  * 
  * $data['property'] = 'value';
  * $data['property'] = 'value';
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer		$cldbid		clientDBID
  * @param		array		$data	 	clientProperties
  * @return     boolean success
  */
	function clientDbEdit($cldbid, $data) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		
		$settingsString = '';
		
		foreach($data as $key => $value) {
			$settingsString .= ' '.$key.'='.$this->escapeText($value);
		}
		
		return $this->getData('boolean', 'clientdbedit cldbid='.$cldbid.$settingsString);
	}

/**
  * clientDbFind
  * 
  * Displays a list of client database IDs matching a given pattern. You can either search for a clients last known nickname or his unique identity by using the -uid option.
  *
  * <b>Output:</b><br>
  * <code>
  * Array
  * {
  *  [cldbid] => 2
  * }
  *	</code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string	$pattern	clientName
  * @param		boolean	$uid		set true to add -uid param [optional]
  * @return     array clientList 
  */
	function clientDbFind($pattern, $uid = false) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('multi', 'clientdbfind pattern='.$this->escapeText($pattern).($uid ? ' -uid' : ''));
	}

/**
  * clientDbInfo
  *
  * Displays detailed database information about a client including unique ID, creation date, etc.
  *
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [client_unique_identifier] => nUixbsq/XakrrmbqU8O30R/D8Gc=
  *  [client_nickname] => par0noid
  *  [client_database_id] => 2
  *  [client_created] => 1361027850
  *  [client_lastconnected] => 1361027850
  *  [client_totalconnections] => 1
  *  [client_flag_avatar] => 
  *  [client_description] => 
  *  [client_month_bytes_uploaded] => 0
  *  [client_month_bytes_downloaded] => 0
  *  [client_total_bytes_uploaded] => 0
  *  [client_total_bytes_downloaded] => 0
  *  [client_icon_id] => 0
  *  [client_base64HashClientUID] => jneilbgomklpfnkjclkoggokfdmdlhnbbpmdpagh
  *  [client_lastip] => 127.0.0.1
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer		$cldbid		clientDBID
  * @return     array	clientDbInfo
  */
	function clientDbInfo($cldbid) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('array', 'clientdbinfo cldbid='.$cldbid);
	}

/**
  * clientDbList
  * 
  * Displays a list of client identities known by the server including their database ID, last nickname, etc.
  *
  * <br><b>Possible params:</b> [start={offset}] [duration={limit}] [-count]<br><br>
  *
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [count] => 1 (if count parameter is set)
  *  [cldbid] => 2
  *  [client_unique_identifier] => nUixbsq/XakrrmbqU8O30R/D8Gc=
  *  [client_nickname] => par0noid
  *  [client_created] => 1361027850
  *  [client_lastconnected] => 1361027850
  *  [client_totalconnections] => 1
  *  [client_description] => 
  *  [client_lastip] => 127.0.0.1
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer	$start		offset [optional] (Default: 0)
  * @param		integer	$duration	limit [optional] (Default: -1)
  * @param		boolean	$count		set true to add -count param [optional]
  * @return     array clientdblist
  */
	function clientDbList($start = 0, $duration = -1, $count = false) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('multi', 'clientdblist start='.$start.' duration='.$duration.($count ? ' -count' : ''));
	}

/**
  * clientDelPerm
  * 
  * Removes a set of specified permissions from a client. Multiple permissions can be removed at once. A permission can be specified by permid or permsid.
  *
  * <b>Input-Array like this:</b>
  * <code>
  * $permissions = array();
  * $permissions['permissionID'] = 'permissionValue';
  * //or you could use Permission Name
  * $permissions['permissionName'] = 'permissionValue';
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer		$cldbid				clientDBID
  * @param		array		$permissionIds		permissionIDs
  * @return     boolean success
  */
	function clientDelPerm($cldbid, $permissionIds) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		
		$permissionArray = array();
		
		if(count($permissionIds) > 0) {
			foreach($permissionIds AS $value) {
				$permissionArray[] = (is_numeric($value) ? 'permid=' : 'permsid=').$value;
			}
			return $this->getData('boolean', 'clientdelperm cldbid='.$cldbid.' '.implode('|', $permissionArray));
		}else{
			$this->addDebugLog('no permissions given');
			return $this->generateOutput(false, array('Error: no permissions given'), false);
		}
	}

/**
  * clientEdit
  * 
  * Changes a clients settings using given properties.
  *
  * <b>Input-Array like this:</b>
  * <code>
  * $data = array();
  *	
  * $data['property'] = 'value';
  * $data['property'] = 'value';
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer	$clid 			clientID
  * @param		array	$data			clientProperties
  * @return     boolean success
  */
	function clientEdit($clid, $data) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		
		$settingsString = '';
		
		foreach($data as $key => $value) {
			$settingsString .= ' '.$key.'='.$this->escapeText($value);
		}
		
		return $this->getData('boolean', 'clientedit clid='.$clid.$settingsString);
	}

/**
  * clientFind
  * 
  * Displays a list of clients matching a given name pattern.
  *
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [clid] => 18
  *  [client_nickname] => par0noid
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string	$pattern	clientName
  * @return     array clienList
  */
	function clientFind($pattern) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('multi', 'clientfind pattern='.$this->escapeText($pattern));
	}

/**
  * clientGetDbIdFromUid
  * 
  * Displays the database ID matching the unique identifier specified by cluid.
  *
  *	<b>Output:</b>
  * <code>
  * Array
  * {
  *  [cluid] => nUixbsq/XakrrmbqU8O30R/D8Gc=
  *  [cldbid] => 2
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string	$cluid	clientUID
  * @return     array clientInfo
  */
	function clientGetDbIdFromUid($cluid) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('array', 'clientgetdbidfromuid cluid='.$cluid);
	}

/**
  * clientGetIds
  * 
  * Displays all client IDs matching the unique identifier specified by cluid.
  *
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [cluid] => nUixbdf/XakrrmsdffO30R/D8Gc=
  *  [clid] => 7
  *  [name] => Par0noid
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string	$cluid	clientUID
  * @return     array clientList 
  */
	function clientGetIds($cluid) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('multi', 'clientgetids cluid='.$cluid);
	}

/**
  * clientGetNameFromDbid
  * 
  * Displays the unique identifier and nickname matching the database ID specified by cldbid.
  *
  *	<b>Output:</b>
  * <code>
  * Array
  * {
  *  [cluid] => nUixbsq/XakrrmbqU8O30R/D8Gc=
  *  [cldbid] => 2
  *  [name] => Par0noid
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer	$cldbid	clientDBID
  * @return     array clientInfo
  */
	function clientGetNameFromDbid($cldbid) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('array', 'clientgetnamefromdbid cldbid='.$cldbid);
	}
	
/**
  * clientGetNameFromUid
  * 
  * Displays the database ID and nickname matching the unique identifier specified by cluid.
  *
  *	<b>Output:</b>
  * <code>
  * Array
  * {
  *  [cluid] => nUixbsq/XakrrmbqU8O30R/D8Gc=
  *  [cldbid] => 2
  *  [name] => Par0noid
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string	$cluid	clientUID
  * @return     array clientInfo
  */
	function clientGetNameFromUid($cluid) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('array', 'clientgetnamefromuid cluid='.$cluid);
	}

/**
  * clientInfo
  * 
  * Displays detailed configuration information about a client including unique ID, nickname, client version, etc.
  *
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [cid] => 2
  *  [client_idle_time] => 4445369
  *  [client_unique_identifier] => nUixbsq/XakrrmbqU8O30R/D8Gc=
  *  [client_nickname] => par0noid
  *  [client_version] => 3.0.9.2 [Build: 1351504843]
  *  [client_platform] => Windows
  *  [client_input_muted] => 1
  *  [client_output_muted] => 1
  *  [client_outputonly_muted] => 0
  *  [client_input_hardware] => 1
  *  [client_output_hardware] => 1
  *  [client_default_channel] => 
  *  [client_meta_data] => 
  *  [client_is_recording] => 0
  *  [client_login_name] => 
  *  [client_database_id] => 2
  *  [client_channel_group_id] => 5
  *  [client_servergroups] => 6
  *  [client_created] => 1361027850
  *  [client_lastconnected] => 1361027850
  *  [client_totalconnections] => 1
  *  [client_away] => 0
  *  [client_away_message] => 
  *  [client_type] => 0
  *  [client_flag_avatar] => 
  *  [client_talk_power] => 75
  *  [client_talk_request] => 0
  *  [client_talk_request_msg] => 
  *  [client_description] => 
  *  [client_is_talker] => 0
  *  [client_month_bytes_uploaded] => 0
  *  [client_month_bytes_downloaded] => 0
  *  [client_total_bytes_uploaded] => 0
  *  [client_total_bytes_downloaded] => 0
  *  [client_is_priority_speaker] => 0
  *  [client_nickname_phonetic] => 
  *  [client_needed_serverquery_view_power] => 75
  *  [client_default_token] => 
  *  [client_icon_id] => 0
  *  [client_is_channel_commander] => 0
  *  [client_country] => 
  *  [client_channel_group_inherited_channel_id] => 2
  *  [client_base64HashClientUID] => jneilbgomklpfnkjclkoggokfdmdlhnbbpmdpagh
  *  [connection_filetransfer_bandwidth_sent] => 0
  *  [connection_filetransfer_bandwidth_received] => 0
  *  [connection_packets_sent_total] => 12130
  *  [connection_bytes_sent_total] => 542353
  *  [connection_packets_received_total] => 12681
  *  [connection_bytes_received_total] => 592935
  *  [connection_bandwidth_sent_last_second_total] => 82
  *  [connection_bandwidth_sent_last_minute_total] => 92
  *  [connection_bandwidth_received_last_second_total] => 84
  *  [connection_bandwidth_received_last_minute_total] => 88
  *  [connection_connected_time] => 5908749
  *  [connection_client_ip] => 127.0.0.1
  * } 
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer	$clid	clientID
  * @return     array	clientInformation
  */
	function clientInfo($clid) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('array', 'clientinfo clid='.$clid);
	}

/**
  * clientKick
  * 
  * Kicks one or more clients specified with clid from their currently joined channel or from the server, depending on reasonid. The reasonmsg parameter specifies a text message sent to the kicked clients. This parameter is optional and may only have a maximum of 40 characters.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $clid		clientID
  * @param		string	$kickMode	kickMode (server or channel) (Default: servera)
  * @param		string	$kickmsg 	kick reason [optional]
  * @return     boolean success
  */
	function clientKick($clid, $kickMode = "server", $kickmsg = "") {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		
		if(in_array($kickMode, array('server', 'channel'))) {
		
			if($kickMode == 'server') { $from = '5'; }
			if($kickMode == 'channel') { $from = '4'; }
			
			if(!empty($kickmsg)) { $msg = ' reasonmsg='.$this->escapeText($kickmsg); } else{ $msg = ''; }
			
			return $this->getData('boolean', 'clientkick clid='.$clid.' reasonid='.$from.$msg);
		}else{
			$this->addDebugLog('invalid kickMode');
			return $this->generateOutput(false, array('Error: invalid kickMode'), false);
		}
	}

/**
  * clientList
  * 
  * Displays a list of clients online on a virtual server including their ID, nickname, status flags, etc. The output can be modified using several command options. Please note that the output will only contain clients which are currently in channels you're able to subscribe to.
  *
  * <br><b>Possible params:</b> [-uid] [-away] [-voice] [-times] [-groups] [-info] [-icon] [-country] [-ip]<br><br>
  *
  * <b>Output: (without parameters)</b>
  * <code>
  * Array
  * {
  *  [clid] => 1
  *  [cid] => 1
  *  [client_database_id] => 2
  *  [client_nickname] => Par0noid
  *  [client_type] => 0
  *  [-uid] => [client_unique_identifier] => nUixbsq/XakrrmbqU8O30R/D8Gc=
  *  [-away] => [client_away] => 0
  *  [-away] => [client_away_message] => 
  *  [-voice] => [client_flag_talking] => 0
  *  [-voice] => [client_input_muted] => 0
  *  [-voice] => [client_output_muted] => 0
  *  [-voice] => [client_input_hardware] => 0
  *  [-voice] => [client_output_hardware] => 0
  *  [-voice] => [client_talk_power] => 0
  *  [-voice] => [client_is_talker] => 0
  *  [-voice] => [client_is_priority_speaker] => 0
  *  [-voice] => [client_is_recording] => 0
  *  [-voice] => [client_is_channel_commander] => 0
  *  [-times] => [client_idle_time] => 1714
  *  [-times] => [client_created] => 1361027850
  *  [-times] => [client_lastconnected] => 1361042955
  *  [-groups] => [client_servergroups] => 6,7
  *  [-groups] => [client_channel_group_id] => 8
  *  [-groups] => [client_channel_group_inherited_channel_id] => 1
  *  [-info] => [client_version] => 3.0.9.2 [Build: 1351504843]
  *  [-info] => [client_platform] => Windows
  *  [-icon] => [client_icon_id] => 0
  *  [-country] => [client_country] => 
  *  [-ip] => [connection_client_ip] => 127.0.0.1
  * }
  * </code><br>
  * <b>Usage:</b>
  * <code>
  * $ts3->clientList(); //No parameters
  * $ts3->clientList("-uid"); //Single parameter
  * $ts3->clientList("-uid -away -voice -times -groups -info -country -icon -ip"); //Multiple parameters
  * </code><br>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string	$params	additional parameters [optional]
  * @return     array clientList 
  */
	function clientList($params = null) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		
		if(!empty($params)) { $params = ' '.$params; }
		
		return $this->getData('multi', 'clientlist'.$params);
	}

/**
  * clientMove
  * 
  * Moves one or more clients specified with clid to the channel with ID cid. If the target channel has a password, it needs to be specified with cpw. If the channel has no password, the parameter can be omitted.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $clid	clientID
  * @param		integer $cid	channelID
  * @param		string	$cpw	channelPassword [optional]
  * @return     boolean success
  */
	function clientMove($clid, $cid, $cpw = null) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('boolean', 'clientmove clid='.$clid.' cid='.$cid.(!empty($cpw) ? ' cpw='.$this->escapeText($cpw) : ''));
	}

/**
  * clientPermList
  * 
  * Displays a list of permissions defined for a client.
  *
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [permid] => 20654 //with permsid = false
  *  [permsid] => b_client_ignore_bans //with permsid = true
  *  [permvalue] => 1
  *  [permnegated] => 0
  *  [permskip] => 0
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		intege		$cldbid 	clientDBID
  * @param		boolean		$permsid	set true to add -permsid param [optional]
  * @return     array clientPermList
  */
	function clientPermList($cldbid, $permsid = false) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }		
		return $this->getData('multi', 'clientpermlist cldbid='.$cldbid.($permsid ? ' -permsid' : ''));
	}

/**
  * clientPoke
  * 
  * Sends a poke message to the client specified with clid.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $clid	clientID
  * @param		string 	$msg 	pokeMessage
  * @return     boolean success
  */
	function clientPoke($clid, $msg) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('boolean', 'clientpoke clid='.$clid.' msg='.$this->escapeText($msg));
	}

/**
  * clientSetServerQueryLogin
  * 
  * Updates your own ServerQuery login credentials using a specified username. The password will be auto-generated.
  * 
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [client_login_password] => +r\/TQqvR
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string	$username	username
  * @return     array userInfomation
  */
	function clientSetServerQueryLogin($username) {
		return $this->getData('array', 'clientsetserverquerylogin client_login_name='.$this->escapeText($username));
	}

/**
  * clientUpdate
  * 
  * Change your ServerQuery clients settings using given properties.
  * 
  * <b>Input-Array like this:</b>
  * <code>
  * $data = array();
  * $data['property'] = 'value';
  * $data['property'] = 'value';
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		array	$data	clientProperties
  * @return     boolean success
  */
	function clientUpdate($data) {
		$settingsString = '';
		
		foreach($data as $key => $value) {
			$settingsString .= ' '.$key.'='.$this->escapeText($value);
		}
		
		return $this->getData('boolean', 'clientupdate '.$settingsString);
	}

/**
  * complainAdd
  *
  * Submits a complaint about the client with database ID tcldbid to the server.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $tcldbid	targetClientDBID
  * @param		string	$msg		complainMessage
  * @return     boolean success
  */
	function complainAdd($tcldbid, $msg) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('boolean', 'complainadd tcldbid='.$tcldbid.' message='.$this->escapeText($msg));
	}

/**
  * complainDelete
  * 
  * Deletes the complaint about the client with ID tcldbid submitted by the client with ID fcldbid from the server.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $tcldbid targetClientDBID
  * @param		integer $fcldbid fromClientDBID
  * @return     boolean success
  */
	function complainDelete($tcldbid, $fcldbid) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('boolean', 'complaindel tcldbid='.$tcldbid.' fcldbid='.$fcldbid);
	}

/**
  * complainDeleteAll
  * 
  * Deletes all complaints about the client with database ID tcldbid from the server.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $tcldbid targetClientDBID
  * @return     boolean success
  */
	function complainDeleteAll($tcldbid) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('boolean', 'complaindelall tcldbid='.$tcldbid);
	}

/**
  * complainList
  * 
  * Displays a list of complaints on the selected virtual server. If tcldbid is specified, only complaints about the targeted client will be shown.
  *
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [tcldbid] => 2
  *  [tname] => par0noid
  *  [fcldbid] => 1
  *  [fname] => serveradmin from 127.0.0.1:6814
  *  [message] => Steals crayons
  *  [timestamp] => 1361044090
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string $tcldbid	targetClientDBID [optional]
  * @return     array complainList
  */
	function complainList($tcldbid = null) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		if(!empty($tcldbid)) { $tcldbid = ' tcldbid='.$tcldbid; }
		return $this->getData('multi', 'complainlist'.$tcldbid);
	}

/**
  * execOwnCommand
  * 
  * executes a command that isn't defined in class and returns data like your propose
  * 
  * <b>Modes:</b>
  * <ul>
  * 	<li><b>0:</b> execute -> return boolean</li>
  * 	<li><b>1:</b> execute -> return normal array</li>
  * 	<li><b>2:</b> execute -> return multidimensional array</li>
  * 	<li><b>3:</b> execute -> return plaintext serverquery</li>
  * </ul>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string	$mode		executionMode
  * @param		string	$command	command
  * @return     mixed result
  */
	function execOwnCommand($mode, $command) {
		if($mode == '0') {
			return $this->getData('boolean', $command);
		}
		if($mode == '1') {
			return $this->getData('array', $command);
		}
		if($mode == '2') {
			return $this->getData('multi', $command);
		}
		if($mode == '3') {
			return $this->getData('plain', $command);
		}
	}

/**
  * ftCreateDir
  * 
  * Creates new directory in a channels file repository.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string	$cid		channelId
  * @param		string	$cpw		channelPassword (leave blank if not needed)
  * @param		string	$dirname	dirPath
  * @return     boolean success
  */
	function ftCreateDir($cid, $cpw = null, $dirname) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('boolean', 'ftcreatedir cid='.$cid.' cpw='.$this->escapeText($cpw).' dirname='.$this->escapeText($dirname));
	}

/**
  * ftDeleteFile
  * 
  * Deletes one or more files stored in a channels file repository.
  *
  * <b>Input-Array like this:</b>
  * <code>
  * $files = array();
  *	
  * $files[] = '/pic1.jpg';
  * $files[] = '/dokumente/test.txt';
  * $files[] = '/dokumente';
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string	$cid	channelID
  * @param		string	$cpw	channelPassword (leave blank if not needed)
  * @param		array	$files	files
  * @return     boolean success
  */
	function ftDeleteFile($cid, $cpw = '', $files) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		$fileArray = array();
		
		if(count($files) > 0) {
			foreach($files AS $file) {
				$fileArray[] = 'name='.$this->escapeText($file);
			}
			return $this->getData('boolean', 'ftdeletefile cid='.$cid.' cpw='.$this->escapeText($cpw).' '.implode('|', $fileArray));
		}else{
			$this->addDebugLog('no files given');
			return $this->generateOutput(false, array('Error: no files given'), false);
		}
	}

/**
  * ftDownloadFile
  * 
  * Ddownloads a file and returns its contents
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		array	$data	return of ftInitDownload
  * @return     array downloadedFile
  */
	function ftDownloadFile($data) {
  		$this->runtime['fileSocket'] = @fsockopen($this->runtime['host'], $data['data']['port'], $errnum, $errstr, $this->runtime['timeout']);
  		if($this->runtime['fileSocket']) {
  			$this->ftSendKey($data['data']['ftkey']);
  			$content = $this->ftRead($data['data']['size']);
  			@fclose($this->runtime['fileSocket']);
  			$this->runtime['fileSocket'] = '';
  			return $content;
  		}else{
  			$this->addDebugLog('fileSocket returns '.$errnum. ' | '.$errstr);
  			return $this->generateOutput(false, array('Error in fileSocket: '.$errnum. ' | '.$errstr), false);
  		}
	}
	
/**
  * ftGetFileInfo
  * 
  * Displays detailed information about one or more specified files stored in a channels file repository.
  *
  * <b>Input-Array like this:</b>
  * <code>
  * $files = array();
  *	
  * $files[] = '/pic1.jpg';
  * $files[] = '/dokumente/test.txt';
  * $files[] = '/dokumente';
  * </code><br>
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [cid] => 231
  *  [name] => /dfsdfsdf.txt
  *  [size] => 1412
  *  [datetime] => 1286634258
  * }
  * </code>
  * 
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string	$cid	channelID
  * @param		string	$cpw	channelPassword (leave blank if not needed)
  * @param		array	$files	files
  * @return     boolean success
  */
	function ftGetFileInfo($cid, $cpw = '', $files) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		$fileArray = array();
		
		if(count($files) > 0) {
			foreach($files AS $file) {
				$fileArray[] = 'name='.$this->escapeText($file);
			}
			return $this->getData('multi', 'ftgetfileinfo cid='.$cid.' cpw='.$this->escapeText($cpw).' '.implode('|', $fileArray));
		}else{
			$this->addDebugLog('no files given');
			return $this->generateOutput(false, array('Error: no files given'), false);
		}
	}

/**
  * ftGetFileList
  *
  * Displays a list of files and directories stored in the specified channels file repository.
  *
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [cid] => 231
  *  [path] => /
  *  [name] => Documents
  *  [size] => 0
  *  [datetime] => 1286633633
  *  [type] => 0
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string	$cid	channelID
  * @param		string	$cpw	channelPassword (leave blank if not needed)
  * @param		string	$path	filePath
  * @return     array	fileList
  */
	function ftGetFileList($cid, $cpw = '', $path) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('multi', 'ftgetfilelist cid='.$cid.' cpw='.$this->escapeText($cpw).' path='.$this->escapeText($path));
	}
	
/**
  * ftInitDownload
  * 
  * Initializes a file transfer download. clientftfid is an arbitrary ID to identify the file transfer on client-side. On success, the server generates a new ftkey which is required to start downloading the file through TeamSpeak 3's file transfer interface.
  *
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [clientftfid] => 89
  *  [serverftfid] => 3
  *  [ftkey] => jSzWiRmFGdZnoJzW7BSDYJRUWB2WAUhb
  *  [port] => 30033
  *  [size] => 94
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string	$name			filePath
  * @param		string	$cid			channelID
  * @param		string	$cpw			channelPassword (leave blank if not needed)
  * @param		integer	$seekpos		seekpos (default = 0) [optional]
  * @return     array	initDownloadFileInfo
  */	
	function ftInitDownload($name, $cid, $cpw = '', $seekpos = 0) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('array', 'ftinitdownload clientftfid='.rand(1,99).' name='.$this->escapeText($name).' cid='.$cid.' cpw='.$this->escapeText($cpw).' seekpos='.$seekpos);
	}

/**
  * ftInitUpload
  * 
  * Initializes a file transfer upload. clientftfid is an arbitrary ID to identify the file transfer on client-side. On success, the server generates a new ftkey which is required to start uploading the file through TeamSpeak 3's file transfer interface.
  *
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [clientftfid] => 84
  *  [serverftfid] => 41
  *  [ftkey] => HCnXpunOdAorqj3dGqfiuLszX18O0PHP
  *  [port] => 30033
  *  [seekpos] => 0
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string	$filename	filePath
  * @param		string	$cid		channelID
  * @param		integer	$size		fileSize in bytes
  * @param		string	$cpw		channelPassword (leave blank if not needed)
  * @param		boolean	$overwrite	overwrite	[optional] (default = 0)
  * @param		boolean	$resume		resume		[optional] (default = 0)
  * @return     array	initUploadFileInfo
  */	
	function ftInitUpload($filename, $cid, $size, $cpw = '', $overwrite = false, $resume = false) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		
		if($overwrite) { $overwrite = ' overwrite=1'; }else{ $overwrite = ' overwrite=0'; }
		if($resume) { $resume = ' resume=1'; }else{ $resume = ' resume=0'; }
		
		return $this->getData('array', 'ftinitupload clientftfid='.rand(1,99).' name='.$this->escapeText($filename).' cid='.$cid.' cpw='.$this->escapeText($cpw).' size='.($size + 1).$overwrite.$resume);
	}
	
/**
  * ftList
  * 
  * Displays a list of running file transfers on the selected virtual server. The output contains the path to which a file is uploaded to, the current transfer rate in bytes per second, etc
  *
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [clid] => 1
  *  [cldbid] => 2019
  *  [path] => files/virtualserver_11/channel_231
  *  [name] => 1285412348878.png
  *  [size] => 1161281
  *  [sizedone] => 275888
  *  [clientftfid] => 15
  *  [serverftfid] => 52
  *  [sender] => 0
  *  [status] => 1
  *  [current_speed] => 101037.4453
  *  [average_speed] => 101037.4453
  *  [runtime] => 2163
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @return     array	fileTransferList
  */
	function ftList() {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('multi', 'ftlist');
	}

/**
  * ftRenameFile
  * 
  * Renames a file in a channels file repository. If the two parameters tcid and tcpw are specified, the file will be moved into another channels file repository.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer	$cid		channelID
  * @param		string	$cpw		channelPassword (leave blank if not needed)
  * @param		string	$oldname	oldFilePath
  * @param		string	$newname	newFilePath
  * @param		string  $tcid		targetChannelID [optional]
  * @param		string  $tcpw		targetChannelPassword [optional]
  * @return     boolean success
  */
	function ftRenameFile($cid, $cpw = null, $oldname, $newname, $tcid = null,  $tcpw = null) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		$newTarget = ($tcid != null ? ' tcid='.$tcid.' '.$tcpw : '');
		return $this->getData('boolean', 'ftrenamefile cid='.$cid.' cpw='.$cpw.' oldname='.$this->escapeText($oldname).' newname='.$this->escapeText($newname).$newTarget);
	}

/**
  * ftStop
  * 
  * Stops the running file transfer with server-side ID serverftfid.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer	$serverftfid	serverFileTransferID
  * @param		boolean	$delete			delete incomplete file [optional] (default: true) 
  * @return     boolean success
  */
	function ftStop($serverftfid, $delete = true) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }		
		return $this->getData('boolean', 'ftstop serverftfid='.$serverftfid.' delete='.($delete ? '1' : '0'));
	}

/**
  * ftUploadFile
  * 
  * Uploads a file to server
  * To check if upload was successful, you have to search for this file in fileList after
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		array	$data			return of ftInitUpload
  * @param		string	$uploadData		data which should be uploaded
  * @return     array response
  */
	function ftUploadFile($data, $uploadData) {
  		$this->runtime['fileSocket'] = @fsockopen($this->runtime['host'], $data['data']['port'], $errnum, $errstr, $this->runtime['timeout']);
  		if($this->runtime['fileSocket']) {
  			$this->ftSendKey($data['data']['ftkey'], "\n");
  			$this->ftSendData($uploadData);
  			@fclose($this->runtime['fileSocket']);
  			$this->runtime['fileSocket'] = '';
  			return $this->generateOutput(true, array(), true);
  		}else{
  			$this->addDebugLog('fileSocket returns '.$errnum. ' | '.$errstr);
  			return $this->generateOutput(false, array('Error in fileSocket: '.$errnum. ' | '.$errstr), false);
  		}
	}

/**
  * gm
  * 
  * Sends a text message to all clients on all virtual servers in the TeamSpeak 3 Server instance.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string	$msg	message
  * @return     boolean success
  */
	function gm($msg) {
		if(empty($msg)) {
			$this->addDebugLog('empty message given');
			return $this->generateOutput(false, array('Error: empty message given'), false);
		}
		return $this->getData('boolean', 'gm msg='.$this->escapeText($msg));
	}

/**
  * hostInfo
  * 
  * Displays detailed connection information about the server instance including uptime, number of virtual servers online, traffic information, etc.
  *
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [instance_uptime] => 19038
  *  [host_timestamp_utc] => 1361046825
  *  [virtualservers_running_total] => 1
  *  [virtualservers_total_maxclients] => 32
  *  [virtualservers_total_clients_online] => 1
  *  [virtualservers_total_channels_online] => 2
  *  [connection_filetransfer_bandwidth_sent] => 0
  *  [connection_filetransfer_bandwidth_received] => 0
  *  [connection_filetransfer_bytes_sent_total] => 0
  *  [connection_filetransfer_bytes_received_total] => 0
  *  [connection_packets_sent_total] => 24853
  *  [connection_bytes_sent_total] => 1096128
  *  [connection_packets_received_total] => 25404
  *  [connection_bytes_received_total] => 1153918
  *  [connection_bandwidth_sent_last_second_total] => 82
  *  [connection_bandwidth_sent_last_minute_total] => 81
  *  [connection_bandwidth_received_last_second_total] => 84
  *  [connection_bandwidth_received_last_minute_total] => 87
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @return     array hostInformation
  */
	function hostInfo() {
		return $this->getData('array', 'hostinfo');
	}

/**
  * instanceEdit
  * 
  * Changes the server instance configuration using given properties.
  *
  * <b>Input-Array like this:</b>
  * <code>
  * $data = array();
  *	
  * $data['setting'] = 'value';
  * $data['setting'] = 'value';
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		array	$data	instanceProperties
  * @return     boolean success
  */
	function instanceEdit($data) {
		if(count($data) > 0) {
			$settingsString = '';
			
			foreach($data as $key => $val) {
				$settingsString .= ' '.$key.'='.$this->escapeText($val);
			}
			return $this->getData('boolean', 'instanceedit '.$settingsString);
		}else{
			$this->addDebugLog('empty array entered');
			return $this->generateOutput(false, array('Error: You can \'t give an empty array'), false);
		}
	}

/**
  * instanceInfo
  * 
  * Displays the server instance configuration including database revision number, the file transfer port, default group IDs, etc.
  *
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [serverinstance_database_version] => 20
  *  [serverinstance_filetransfer_port] => 30033
  *  [serverinstance_max_download_total_bandwidth] => 18446744073709551615
  *  [serverinstance_max_upload_total_bandwidth] => 18446744073709551615
  *  [serverinstance_guest_serverquery_group] => 1
  *  [serverinstance_serverquery_flood_commands] => 10
  *  [serverinstance_serverquery_flood_time] => 3
  *  [serverinstance_serverquery_ban_time] => 600
  *  [serverinstance_template_serveradmin_group] => 3
  *  [serverinstance_template_serverdefault_group] => 5
  *  [serverinstance_template_channeladmin_group] => 1
  *  [serverinstance_template_channeldefault_group] => 4
  *  [serverinstance_permissions_version] => 15
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @return     array instanceInformation
  */
	function instanceInfo() {
		return $this->getData('array', 'instanceinfo');
	}

/**
  * logAdd
  * 
  * Writes a custom entry into the servers log. Depending on your permissions, you'll be able to add entries into the server instance log and/or your virtual servers log. The loglevel parameter specifies the type of the entry.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer	$logLevel	loglevel between 1 and 4
  * @param		string	$logMsg		logMessage
  * @return     boolean success
  */
	function logAdd($logLevel, $logMsg) {
		if($logLevel >=1 and $logLevel <= 4) { 
			if(!empty($logMsg)) {
				return $this->getData('boolean', 'logadd loglevel='.$logLevel.' logmsg='.$this->escapeText($logMsg));
			}else{
				$this->addDebugLog('logMessage empty!');
				return $this->generateOutput(false, array('Error: logMessage empty!'), false);
			}
		}else{
			$this->addDebugLog('invalid logLevel!');
			return $this->generateOutput(false, array('Error: invalid logLevel!'), false);
		}
	}

/**
  * login
  * 
  * Authenticates with the TeamSpeak 3 Server instance using given ServerQuery login credentials.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string	$username	username
  * @param		string	$password	password
  * @return     boolean success
  */
	function login($username, $password) {
		return $this->getData('boolean', 'login '.$this->escapeText($username).' '.$this->escapeText($password));
	}

/**
  * logout
  * 
  * Deselects the active virtual server and logs out from the server instance.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @return     boolean success
  */
	function logout() {
		$this->runtime['selected'] = false;
		return $this->getData('boolean', 'logout');
	}

/**
  * logView
  * 
  * Displays a specified number of entries from the servers log. If instance is set to 1, the server will return lines from the master logfile (ts3server_0.log) instead of the selected virtual server logfile.
  * 
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [last_pos] => 0
  *  [file_size] => 1085
  *  [l] => 2012-01-10 20:34:31.379260|INFO    |ServerLibPriv |   | TeamSpeak 3 Server 3.0.1 (2011-11-17 07:34:30)
  * }
  * {
  *  [l] => 2012-01-10 20:34:31.380260|INFO    |DatabaseQuery |   | dbPlugin name:    SQLite3 plugin, Version 2, (c)TeamSpeak Systems GmbH
  * }
  * {
  *  [l] => 2012-01-10 20:34:31.380260|INFO    |DatabaseQuery |   | dbPlugin version: 3.7.3
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer	$lines	between 1 and 100
  * @param		integer	$reverse	{1|0} [optional]
  * @param		integer	$instance	{1|0} [optional]
  * @param		integer	$begin_pos	{1|0} [optional]
  * @return     multidimensional-array logEntries
  */
	function logView($lines, $reverse = 0, $instance = 0, $begin_pos = 0) {		
		if($lines >=1 and $lines <=100) {
			return $this->getData('multi', 'logview lines='.$lines.' reverse='.($reverse == 0 ? '0' : '1').' instance='.($instance == 0 ? '0' : '1').' begin_pos='.($begin_pos == 0 ? '0' : '1'));
		}else{
			$this->addDebugLog('please choose a limit between 1 and 100');
			$this->generateOutput(false, array('Error: please choose a limit between 1 and 100'), false);
		}
	}

/**
  * permIdGetByName
  * 
  * Displays the database ID of one or more permissions specified by permsid.
  *
  * <b>Input-Array like this:</b>
  * <code>
  * $permissions = array();
  * $permissions[] = 'permissionName';
  * </code><br>
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [permsid] => b_serverinstance_help_view
  *  [permid] => 4353
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string	$permsids		permNames
  * @return     array	permissionList 
  */
	function permIdGetByName($permsids) {
		$permissionArray = array();
		
		if(count($permsids) > 0) {
			foreach($permsids AS $value) {
				$permissionArray[] = 'permsid='.$value;
			}
			return $this->getData('multi', 'permidgetbyname '.$this->escapeText(implode('|', $permissionArray)));
		}else{
			$this->addDebugLog('no permissions given');
			return $this->generateOutput(false, array('Error: no permissions given'), false);
		}
		
	}


/**
  * permissionList
  * 
  * Displays a list of permissions available on the server instance including ID, name and description.
  * If the new parameter is set the permissionlist will return with the new output format.
  *
  * <b>Output: (with new parameter)</b>
  * <code>
  * [0] => Array
  *     (
  *         [num] => 1
  *         [group_id_end] => 0
  *         [pcount] => 0
  *     )

  * [1] => Array
  *     (
  *         [num] => 2
  *         [group_id_end] => 7
  *         [pcount] => 7
  *         [permissions] => Array
  *             (
  *                 [0] => Array
  *                     (
  *                         [permid] => 1
  *                         [permname] => b_serverinstance_help_view
  *                         [permdesc] => Retrieve information about ServerQuery commands
  *                         [grantpermid] => 32769
  *                     )

  *                 [1] => Array
  *                     (
  *                         [permid] => 2
  *                         [permname] => b_serverinstance_version_view
  *                         [permdesc] => Retrieve global server version (including platform and build number)
  *                         [grantpermid] => 32770
  *                     )

  *                 [2] => Array
  *                     (
  *                         [permid] => 3
  *                         [permname] => b_serverinstance_info_view
  *                         [permdesc] => Retrieve global server information
  *                         [grantpermid] => 32771
  *                     )

  *                 [3] => Array
  *                     (
  *                         [permid] => 4
  *                         [permname] => b_serverinstance_virtualserver_list
  *                         [permdesc] => List virtual servers stored in the database
  *                         [grantpermid] => 32772
  *                     )
  *
  *                 [4] => Array
  *                     (
  *                         [permid] => 5
  *                         [permname] => b_serverinstance_binding_list
  *                         [permdesc] => List active IP bindings on multi-homed machines
  *                         [grantpermid] => 32773
  *                     )
  *
  *                [5] => Array
  *                     (
  *                         [permid] => 6
  *                         [permname] => b_serverinstance_permission_list
  *                         [permdesc] => List permissions available available on the server instance
  *                         [grantpermid] => 32774
  *                     )
  *
  *                 [6] => Array
  *                     (
  *                         [permid] => 7
  *                         [permname] => b_serverinstance_permission_find
  *                         [permdesc] => Search permission assignments by name or ID
  *                         [grantpermid] => 32775
  *                     )
  *
  *             )
  *
  *     )
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		boolean		$new		[optional] add new parameter
  * @return     array permissionList
  */
	function permissionList($new = false) {
		if($new === true) {
			$groups = array();
			$permissions = array();
			
			$response = $this->getElement('data', $this->getData('multi', 'permissionlist -new'));
			
			$gc = 1;
			
			foreach($response as $field) {
				if(isset($field['group_id_end'])) {
					$groups[] = array('num' => $gc, 'group_id_end' => $field['group_id_end']);
					$gc++;
				}else{
					$permissions[] = $field;
				}
			}
			
			$counter = 0;
			
			for($i = 0; $i < count($groups); $i++) {
				$rounds = $groups[$i]['group_id_end'] - $counter;
				$groups[$i]['pcount'] = $rounds;
				for($j = 0; $j < $rounds; $j++) {
					$groups[$i]['permissions'][] = array('permid' => ($counter + 1), 'permname' => $permissions[$counter]['permname'], 'permdesc' => $permissions[$counter]['permdesc'], 'grantpermid' => ($counter + 32769));
					$counter++;
				}
			}
			
			return $groups;
			
		}else{
			return $this->getData('multi', 'permissionlist');
		}
	}

/**
  * permOverview
  * 
  * Displays all permissions assigned to a client for the channel specified with cid. If permid is set to 0, all permissions will be displayed. A permission can be specified by permid or permsid.
  *
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [t] => 0
  *  [id1] => 2
  *  [id2] => 0
  *  [p] => 16777
  *  [v] => 1
  *  [n] => 0
  *  [s] => 0
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer		$cid		cchannelId
  * @param		integer 	$cldbid		clientDbId
  * @param		integer 	$permid		permId (Default: 0)
  * @param		string	 	$permsid	permName
  * @return     array permOverview
  */
	function permOverview($cid, $cldbid, $permid='0', $permsid=false ) { 
        if(!$this->runtime['selected']) { return $this->checkSelected(); } 
        if($permsid) { $additional = ' permsid='.$permsid; }else{ $additional = ''; } 
         
        return $this->getData('multi', 'permoverview cid='.$cid.' cldbid='.$cldbid.' permid='.$permid.$additional); 
    }
 
/**
  * quit closes the connection to host 
  *
  * @author     Par0noid Solutions
  * @access		private
  * @return 	none
  */
	private function quit() {
		$this->logout();
		@fputs($this->runtime['socket'], "quit\n");
		@fclose($this->runtime['socket']);
	}

/**
  * selectServer
  * 
  * Selects the virtual server specified with sid or port to allow further interaction. The ServerQuery client will appear on the virtual server and acts like a real TeamSpeak 3 Client, except it's unable to send or receive voice data. If your database contains multiple virtual servers using the same UDP port, use will select a random virtual server using the specified port.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer	$value		Port or ID
  * @param		string	$type		value type ('port', 'serverId') (default='port')
  * @param		boolean	$virtual	set true to add -virtual param [optional]
  * @return     boolean success
  */
	function selectServer($value, $type = 'port', $virtual = false) { 
        if(in_array($type, array('port', 'serverId'))) { 
            if($type == 'port') { 
                if($virtual) { $virtual = ' -virtual'; }else{ $virtual = ''; } 
                $res = $this->getData('boolean', 'use port='.$value.$virtual); 
                if($res['success']) { 
                    $this->runtime['selected'] = true; 
                } 
                return $res; 
            }else{ 
                if($virtual) { $virtual = ' -virtual'; }else{ $virtual = ''; } 
                $res = $this->getData('boolean', 'use sid='.$value.$virtual); 
                if($res['success']) { 
                    $this->runtime['selected'] = true; 
                } 
                return $res; 
            } 
        }else{ 
            $this->addDebugLog('wrong value type'); 
            return $this->generateOutput(false, array('Error: wrong value type'), false); 
        } 
    }

/**
  * sendMessage
  * 
  * Sends a text message a specified target. The type of the target is determined by targetmode while target specifies the ID of the recipient, whether it be a virtual server, a channel or a client.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $mode	{3: server| 2: channel|1: client}
  * @param		integer $target	{serverID|channelID|clientID}
  * @param		string	$msg	message
  * @return     boolean	success
  */
	function sendMessage($mode, $target, $msg) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }

		return $this->getData('boolean', 'sendtextmessage targetmode='.$mode.' target='.$target.' msg='.$this->escapeText($msg));
	}

/**
  * serverCreate
  * 
  * Creates a new virtual server using the given properties and displays its ID, port and initial administrator privilege key. If virtualserver_port is not specified, the server will test for the first unused UDP port. The first virtual server will be running on UDP port 9987 by default. Subsequently started virtual servers will be running on increasing UDP port numbers.
  * 
  * <b>Input-Array like this:</b>
  * <code>
  * $data = array();
  *	
  * $data['setting'] = 'value';
  * $data['setting'] = 'value';
  * </code><br>
  *
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [sid] => 2
  *  [virtualserver_port] => 9988
  *  [token] => eKnFZQ9EK7G7MhtuQB6+N2B1PNZZ6OZL3ycDp2OW
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		array	$data	serverSettings	[optional]
  * @return     array serverInfo
  */
	function serverCreate($data = array()) {
		$settingsString = '';
		
		if(count($data) == 0) {	$data['virtualserver_name'] = 'Teamspeak 3 Server'; }
		
		
		foreach($data as $key => $value) {
			if(!empty($value)) { $settingsString .= ' '.$key.'='.$this->escapeText($value); }
		}
		
		return $this->getData('array', 'servercreate'.$settingsString);
	}

/**
  * serverDelete
  * 
  * Deletes the virtual server specified with sid. Please note that only virtual servers in stopped state can be deleted.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer	$sid	serverID
  * @return     boolean success
  */
	function serverDelete($sid) {
		$this->serverStop($sid);
		return $this->getdata('boolean', 'serverdelete sid='.$sid);
	}

/**
  * serverEdit
  * 
  * Changes the selected virtual servers configuration using given properties. Note that this command accepts multiple properties which means that you're able to change all settings of the selected virtual server at once.
  *
  * <b>Input-Array like this:</b>
  * <code>
  * $data = array();
  *	
  * $data['setting'] = 'value';
  * $data['setting'] = 'value';
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		array	$data	serverSettings
  * @return     boolean success
  */
	function serverEdit($data) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		
		$settingsString = '';
		
		foreach($data as $key => $value) {
			$settingsString .= ' '.$key.'='.$this->escapeText($value);
		}
		
		return $this->getData('boolean', 'serveredit'.$settingsString);
	}

/**
  * serverGroupAdd
  * 
  * Creates a new server group using the name specified with name and displays its ID. The optional type parameter can be used to create ServerQuery groups and template groups. For detailed information, see
  *
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [sgid] => 86
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $name	groupName
  * @param		integer	$type	groupDbType (0 = template, 1 = normal, 2 = query | Default: 1)
  * @return     array groupId
  */
	function serverGroupAdd($name, $type = 1) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('array', 'servergroupadd name='.$this->escapeText($name).' type='.$type);
	}

/**
  * serverGroupAddClient
  * 
  * Adds a client to the server group specified with sgid. Please note that a client cannot be added to default groups or template groups.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $sgid	serverGroupId
  * @param		integer $cldbid	clientDBID
  * @return     boolean success
  */
	function serverGroupAddClient($sgid, $cldbid) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('boolean', 'servergroupaddclient sgid='.$sgid.' cldbid='.$cldbid);
	}

/**
  * serverGroupAddPerm
  * 
  * Adds a set of specified permissions to the server group specified with sgid. Multiple permissions can be added by providing the four parameters of each permission. A permission can be specified by permid or permsid.
  *
  * <b>Input-Array like this:</b>
  * <code>
  * $permissions = array();
  * $permissions['permissionID'] = array('permissionValue', 'permskip', 'permnegated');
  * //or you could use
  * $permissions['permissionName'] = array('permissionValue', 'permskip', 'permnegated');
  * </code>
  * 
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $sgid	groupID
  * @param		array	$permissions	permissions
  * @return     boolean success
  */
	function serverGroupAddPerm($sgid, $permissions) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		
		if(count($permissions) > 0) {
			//Permissions given
				
			//Errorcollector
			$errors = array();
				
			//Split Permissions to prevent query from overload
			$permissions = array_chunk($permissions, 50, true);
				
			//Action for each splitted part of permission
			foreach($permissions as $permission_part)
			{
				//Create command_string for each command that we could use implode later
				$command_string = array();
		
				foreach($permission_part as $key => $value)
				{
					$command_string[] = (is_numeric($key) ? "permid=" : "permsid=").$this->escapeText($key).' permvalue='.$value[0].' permskip='.$value[1].' permnegated='.$value[2];
				}
		
				$result = $this->getData('boolean', 'servergroupaddperm sgid='.$sgid.' '.implode('|', $command_string));
		
				if(!$result['success'])
				{
					foreach($result['errors'] as $error)
					{
						$errors[] = $error;
					}
				}
			}
				
			if(count($errors) == 0)
			{
				return $this->generateOutput(true, array(), true);
			}else{
				return $this->generateOutput(false, $errors, false);
			}
				
		}else{
			// No permissions given
			$this->addDebugLog('no permissions given');
			return $this->generateOutput(false, array('Error: no permissions given'), false);
		}
		/*
		old code
		
        $error = false;
        $results = array();
        
        if(count($permissions) > 0) {
     		$new = array();
 
    		$i = 0;
    		$k = 0;
    		foreach($permissions as $ke => $va) {
        		if($i > 149){ $i = 0; $k++; }else{ $i++; }
        		$new[$k][$ke] = $va;
    		}
    		
    		foreach($new as $perms) {
    			$permissionArray = array();
    			foreach($perms as $key => $value) {
    				$permissionArray[] = 'permid='.$key.' permvalue='.$value[0].' permskip='.$value[1].' permnegated='.$value[2];
    			}
				$result = $this->getData('boolean', 'servergroupaddperm sgid='.$sgid.' '.implode('|', $permissionArray));
				if(!$result['success']) { $error = true; }
    			$results[] = $result;
    		}
    		
    		if($error) {
    			$returnErrors = array();
    			foreach($results as $errorResult) {
    				if(count($errorResult['errors']) > 0) {
    					foreach($errorResult['errors'] as $errorResultError) {
    						$returnErrors[] = $errorResultError;
    					}
    				}
    			}
    			return $this->generateOutput(false, $returnErrors, false);
    		}else{
    			return $this->generateOutput(true, array(), true);
    		}
        }else{
            $this->addDebugLog('no permissions given');
            return $this->generateOutput(false, array('Error: no permissions given'), false);
        }*/
		
	}

/**
  * serverGroupClientList
  * 
  * Displays the IDs of all clients currently residing in the server group specified with sgid. If you're using the optional -names option, the output will also contain the last known nickname and the unique identifier of the clients.
  *
  * <br><b>Possible params:</b> -names
  *
  * <b>Output: (with -names param)</b>
  * <code>
  * Array
  * {
  *  [cldbid] => 2017
  *  [client_nickname] => Par0noid //with -names parameter
  *  [client_unique_identifier] => nUixbsq/XakrrmbqU8O30R/D8Gc=
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer	$sgid		groupId
  * @param		boolean	$names		set true to add -names param [optional]
  * @return     multidimensional-array	serverGroupClientList
  */
	function serverGroupClientList($sgid, $names = false) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		if($names) { $names = ' -names'; }else{ $names = ''; }
		return $this->getData('multi', 'servergroupclientlist sgid='.$sgid.$names);
	}

/**
  * serverGroupCopy
  * 
  * Creates a copy of the server group specified with ssgid. If tsgid is set to 0, the server will create a new group. To overwrite an existing group, simply set tsgid to the ID of a designated target group. If a target group is set, the name parameter will be ignored.
  *
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [sgid] => 86
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer	$ssgid	sourceGroupID
  * @param		integer	$tsgid	targetGroupID
  * @param		integer $name	groupName
  * @param		integer	$type	groupDbType (0 = template, 1 = normal, 2 = query | Default: 1)
  * @return     array groupId
  */
	function serverGroupCopy($ssgid, $tsgid, $name, $type = 1) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('array', 'servergroupcopy ssgid='.$ssgid.' tsgid='.$tsgid.' name='.$this->escapeText($name).' type='.$type);
	}

/**
  * serverGroupDelete
  * 
  * Deletes the server group specified with sgid. If force is set to 1, the server group will be deleted even if there are clients within.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $sgid	serverGroupID
  * @param		integer $force 	forces deleting group (Default: 1)
  * @return     boolean success
  */
	function serverGroupDelete($sgid, $force = 1) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('boolean', 'servergroupdel sgid='.$sgid.' force='.$force);
	}

/**
  * serverGroupDeleteClient
  * 
  * Removes a client specified with cldbid from the server group specified with sgid.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $sgid	groupID
  * @param		integer $cldbid	clientDBID
  * @return     boolean success
  */
	function serverGroupDeleteClient($sgid, $cldbid) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('boolean', 'servergroupdelclient sgid='.$sgid.' cldbid='.$cldbid);
	}

/**
  * serverGroupDeletePerm
  * 
  * Removes a set of specified permissions from the server group specified with sgid. Multiple permissions can be removed at once. A permission can be specified by permid or permsid.
  *
  * <b>Input-Array like this:</b>
  * <code>
  * $permissions = array();
  * $permissions[] = 'permissionID';
  * //or you could use
  * $permissions[] = 'permissionName';
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer		$sgid				serverGroupID
  * @param		array		$permissionIds		permissionIds
  * @return     boolean success
  */
	function serverGroupDeletePerm($sgid, $permissionIds) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		$permissionArray = array();
		
		if(count($permissionIds) > 0) {
			foreach($permissionIds AS $value) {
				$permissionArray[] = is_numeric($value) ? 'permid='.$value : 'permsid='.$this->escapeText($value);
			}
			return $this->getData('boolean', 'servergroupdelperm sgid='.$sgid.' '.implode('|', $permissionArray));
		}else{
			$this->addDebugLog('no permissions given');
			return $this->generateOutput(false, array('Error: no permissions given'), false);
		}
	}

/**
  * serverGroupList
  * 
  * Displays a list of server groups available. Depending on your permissions, the output may also contain global ServerQuery groups and template groups.
  *
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [sgid] => 1
  *  [name] => Guest Server Query
  *  [type] => 2
  *  [iconid] => 0
  *  [savedb] => 0
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @return     array serverGroupList
  */
	function serverGroupList() {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('multi', 'servergrouplist');
	}

/**
  * serverGroupPermList
  * 
  * Displays a list of permissions assigned to the server group specified with sgid. If the permsid option is specified, the output will contain the permission names instead of the internal IDs.
  *
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [permid] => 12876 (if permsid = false)
  *  [permsid] => b_client_info_view (if permsid = true)
  *  [permvalue] => 1
  *  [permnegated] => 0
  *  [permskip] => 0
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer	$sgid		serverGroupID
  * @param		boolean	$permsid	set true to add -permsid param [optional]
  * @return     array serverGroupPermList
  */
	function serverGroupPermList($sgid, $permsid = false) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		if($permsid) { $additional = ' -permsid'; }else{ $additional = ''; }
		return $this->getData('multi', 'servergrouppermlist sgid='.$sgid.$additional);
	}

/**
  * serverGroupRename
  * 
  * Changes the name of the server group specified with sgid.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $sgid	serverGroupID
  * @param		integer $name	groupName
  * @return     boolean success
  */
	function serverGroupRename($sgid, $name) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('boolean', 'servergrouprename sgid='.$sgid.' name='.$this->escapeText($name));
	}

/**
  * serverGroupsByClientID
  * 
  * Displays all server groups the client specified with cldbid is currently residing in.
  *
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [name] => Guest
  *  [sgid] => 73
  *  [cldbid] => 2
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer	$cldbid	clientDBID
  * @return     array serverGroupsByClientId
  */
	function serverGroupsByClientID($cldbid) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('multi', 'servergroupsbyclientid cldbid='.$cldbid);
	}

/**
  * serverIdGetByPort
  * 
  * Displays the database ID of the virtual server running on the UDP port specified by virtualserver_port.
  * 
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [server_id] => 1
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $port	serverPort
  * @return     array serverInfo
  */
	function serverIdGetByPort($port) {
		return $this->getData('array', 'serveridgetbyport virtualserver_port='.$port);
	}

/**
  * serverInfo
  * 
  * Displays detailed configuration information about the selected virtual server including unique ID, number of clients online, configuration, etc.
  *	
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [virtualserver_unique_identifier] => 2T3SRCPoWKojKlNMx6qxV7gOe8A=
  *  [virtualserver_name] => TeamSpeak ]I[ Server
  *  [virtualserver_welcomemessage] => Welcome to TeamSpeak
  *  [virtualserver_platform] => Windows
  *  [virtualserver_version] => 3.0.6.1 [Build: 1340956745]
  *  [virtualserver_maxclients] => 32
  *  [virtualserver_password] => 
  *  [virtualserver_clientsonline] => 2
  *  [virtualserver_channelsonline] => 2
  *  [virtualserver_created] => 1361027787
  *  [virtualserver_uptime] => 2804
  *  [virtualserver_codec_encryption_mode] => 0
  *  [virtualserver_hostmessage] => 
  *  [virtualserver_hostmessage_mode] => 0
  *  [virtualserver_filebase] => files\\virtualserver_1
  *  [virtualserver_default_server_group] => 8
  *  [virtualserver_default_channel_group] => 8
  *  [virtualserver_flag_password] => 0
  *  [virtualserver_default_channel_admin_group] => 5
  *  [virtualserver_max_download_total_bandwidth] => 18446744073709551615
  *  [virtualserver_max_upload_total_bandwidth] => 18446744073709551615
  *  [virtualserver_hostbanner_url] => 
  *  [virtualserver_hostbanner_gfx_url] => 
  *  [virtualserver_hostbanner_gfx_interval] => 0
  *  [virtualserver_complain_autoban_count] => 5
  *  [virtualserver_complain_autoban_time] => 1200
  *  [virtualserver_complain_remove_time] => 3600
  *  [virtualserver_min_clients_in_channel_before_forced_silence] => 100
  *  [virtualserver_priority_speaker_dimm_modificator] => -18.0000
  *  [virtualserver_id] => 1
  *  [virtualserver_antiflood_points_tick_reduce] => 5
  *  [virtualserver_antiflood_points_needed_command_block] => 150
  *  [virtualserver_antiflood_points_needed_ip_block] => 250
  *  [virtualserver_client_connections] => 1
  *  [virtualserver_query_client_connections] => 6
  *  [virtualserver_hostbutton_tooltip] => 
  *  [virtualserver_hostbutton_url] => 
  *  [virtualserver_hostbutton_gfx_url] => 
  *  [virtualserver_queryclientsonline] => 1
  *  [virtualserver_download_quota] => 18446744073709551615
  *  [virtualserver_upload_quota] => 18446744073709551615
  *  [virtualserver_month_bytes_downloaded] => 0
  *  [virtualserver_month_bytes_uploaded] => 0
  *  [virtualserver_total_bytes_downloaded] => 0
  *  [virtualserver_total_bytes_uploaded] => 0
  *  [virtualserver_port] => 9987
  *  [virtualserver_autostart] => 1
  *  [virtualserver_machine_id] => 
  *  [virtualserver_needed_identity_security_level] => 8
  *  [virtualserver_log_client] => 0
  *  [virtualserver_log_query] => 0
  *  [virtualserver_log_channel] => 0
  *  [virtualserver_log_permissions] => 1
  *  [virtualserver_log_server] => 0
  *  [virtualserver_log_filetransfer] => 0
  *  [virtualserver_min_client_version] => 12369
  *  [virtualserver_name_phonetic] => 
  *  [virtualserver_icon_id] => 0
  *  [virtualserver_reserved_slots] => 0
  *  [virtualserver_total_packetloss_speech] => 0.0000
  *  [virtualserver_total_packetloss_keepalive] => 0.0000
  *  [virtualserver_total_packetloss_control] => 0.0000
  *  [virtualserver_total_packetloss_total] => 0.0000
  *  [virtualserver_total_ping] => 0.0000
  *  [virtualserver_ip] => 
  *  [virtualserver_weblist_enabled] => 1
  *  [virtualserver_ask_for_privilegekey] => 0
  *  [virtualserver_hostbanner_mode] => 0
  *  [virtualserver_status] => online
  *  [connection_filetransfer_bandwidth_sent] => 0
  *  [connection_filetransfer_bandwidth_received] => 0
  *  [connection_filetransfer_bytes_sent_total] => 0
  *  [connection_filetransfer_bytes_received_total] => 0
  *  [connection_packets_sent_speech] => 0
  *  [connection_bytes_sent_speech] => 0
  *  [connection_packets_received_speech] => 0
  *  [connection_bytes_received_speech] => 0
  *  [connection_packets_sent_keepalive] => 2055
  *  [connection_bytes_sent_keepalive] => 84255
  *  [connection_packets_received_keepalive] => 2055
  *  [connection_bytes_received_keepalive] => 86309
  *  [connection_packets_sent_control] => 90
  *  [connection_bytes_sent_control] => 13343
  *  [connection_packets_received_control] => 90
  *  [connection_bytes_received_control] => 9176
  *  [connection_packets_sent_total] => 2145
  *  [connection_bytes_sent_total] => 97598
  *  [connection_packets_received_total] => 2145
  *  [connection_bytes_received_total] => 95485
  *  [connection_bandwidth_sent_last_second_total] => 82
  *  [connection_bandwidth_sent_last_minute_total] => 81
  *  [connection_bandwidth_received_last_second_total] => 84
  *  [connection_bandwidth_received_last_minute_total] => 87
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @return     array serverInformation
  */
	function serverInfo() {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('array', 'serverinfo');
	}

/**
  * serverList
  * 
  * Displays a list of virtual servers including their ID, status, number of clients online, etc. If you're using the -all option, the server will list all virtual servers stored in the database. This can be useful when multiple server instances with different machine IDs are using the same database. The machine ID is used to identify the server instance a virtual server is associated with. The status of a virtual server can be either online, offline, deploy running, booting up, shutting down and virtual online. While most of them are self-explanatory, virtual online is a bit more complicated. Please note that whenever you select a virtual server which is currently stopped, it will be started in virtual mode which means you are able to change its configuration, create channels or change permissions, but no regular TeamSpeak 3 Client can connect. As soon as the last ServerQuery client deselects the virtual server, its status will be changed back to offline.
  *
  * <b>Possible params:</b> [-uid] [-short] [-all] [-onlyoffline]<br>
  *
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [virtualserver_id] => 1 //displayed on -short
  *  [virtualserver_port] => 9987 //displayed on -short
  *  [virtualserver_status] => online //displayed on -short
  *  [virtualserver_clientsonline] => 2
  *  [virtualserver_queryclientsonline] => 1
  *  [virtualserver_maxclients] => 32
  *  [virtualserver_uptime] => 3045
  *  [virtualserver_name] => TeamSpeak ]I[ Server
  *  [virtualserver_autostart] => 1
  *  [virtualserver_machine_id] =>
  *  [-uid] => [virtualserver_unique_identifier] => bYrybKl/APfKq7xzpIJ1Xb6C06U= 
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string		$options		optional parameters
  * @return     array serverList
  */
	function serverList($options = NULL) {
		return $this->getData('multi', 'serverlist'.(!empty($options) ? ' '.$options : ''));
	}

/**
  * serverProcessStop
  * 
  * Stops the entire TeamSpeak 3 Server instance by shutting down the process.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @return     boolean success
  */
	function serverProcessStop() {
		return $this->getData('boolean', 'serverprocessstop');
	}

/**
  * serverRequestConnectionInfo
  * 
  * Displays detailed connection information about the selected virtual server including uptime, traffic information, etc.
  *
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [connection_filetransfer_bandwidth_sent] => 0
  *  [connection_filetransfer_bandwidth_received] => 0
  *  [connection_filetransfer_bytes_sent_total] => 0
  *  [connection_filetransfer_bytes_received_total] => 0
  *  [connection_packets_sent_total] => 3333
  *  [connection_bytes_sent_total] => 149687
  *  [connection_packets_received_total] => 3333
  *  [connection_bytes_received_total] => 147653
  *  [connection_bandwidth_sent_last_second_total] => 123
  *  [connection_bandwidth_sent_last_minute_total] => 81
  *  [connection_bandwidth_received_last_second_total] => 352
  *  [connection_bandwidth_received_last_minute_total] => 87
  *  [connection_connected_time] => 3387
  *  [connection_packetloss_total] => 0.0000
  *  [connection_ping] => 0.0000
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @return     array serverRequestConnectionInfo
  */
	function serverRequestConnectionInfo() {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('array', 'serverrequestconnectioninfo');
	}

/**
  * serverSnapshotCreate
  * 
  * Displays a snapshot of the selected virtual server containing all settings, groups and known client identities. The data from a server snapshot can be used to restore a virtual servers configuration, channels and permissions using the serversnapshotdeploy command.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @return     string snapshot
  */
	function serverSnapshotCreate() {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('plain', 'serversnapshotcreate');
	}

/**
  * serverSnapshotDeploy
  * 
  * Restores the selected virtual servers configuration using the data from a previously created server snapshot. Please note that the TeamSpeak 3 Server does NOT check for necessary permissions while deploying a snapshot so the command could be abused to gain additional privileges.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string	$snapshot	snapshot
  * @return     boolean success
  */
	function serverSnapshotDeploy($snapshot) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('boolean', 'serversnapshotdeploy '.$snapshot);
	}
	
/**
  * serverStart
  * 
  * Starts the virtual server specified with sid. Depending on your permissions, you're able to start either your own virtual server only or all virtual servers in the server instance.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $sid	serverID
  * @return     boolean success
  */
	function serverStart($sid) {
		return $this->getdata('boolean', 'serverstart sid='.$sid);
	}	

/**
  * serverStop
  * 
  * Stops the virtual server specified with sid. Depending on your permissions, you're able to stop either your own virtual server only or all virtual servers in the server instance.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $sid	serverID
  * @return     boolean success
  */
	function serverStop($sid) {
		return $this->getdata('boolean', 'serverstop sid='.$sid);
	}

/**
  * serverTemppasswordAdd
  * 
  * Sets a new temporary server password specified with pw. The temporary password will be valid for the number of seconds specified with duration. The client connecting with this password will automatically join the channel specified with tcid. If tcid is set to 0, the client will join the default channel.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string	$pw				temporary password
  * @param		string	$duration		durations in seconds
  * @param		string	$desc			description [optional]
  * @param		string	$tcid			cid user enters on connect (0 = Default channel) [optional]
  * @param		string	$tcpw			channelPW
  * @return     boolean success
  */
	function serverTempPasswordAdd($pw, $duration, $desc = 'none', $tcid = 0, $tcpw = null) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getdata('boolean', 'servertemppasswordadd pw='.$this->escapeText($pw).' desc='.(!empty($desc) ? $this->escapeText($desc) : 'none').' duration='.$duration.' tcid='.$tcid.(!empty($tcpw) ? ' tcpw='.$this->escapeText($tcpw) : ''));
	}

/**
  * serverTemppasswordDel
  * 
  * Deletes the temporary server password specified with pw.
  * 
  * @author     Par0noid Solutions
  * @access		public
  * @param		string	$pw		temporary password
  * @return     boolean success
  */	
	function serverTempPasswordDel($pw) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getdata('boolean', 'servertemppassworddel pw='.$this->escapeText($pw));
	}

/**
  * serverTemppasswordList
  * 
  * Returns a list of active temporary server passwords. The output contains the clear-text password, the nickname and unique identifier of the creating client.
  *
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [nickname] => serveradmin
  *  [uid] => 1
  *  [desc] => none
  *  [pw_clear] => test
  *  [start] => 1334996838
  *  [end] => 1335000438
  *  [tcid] => 0
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @return     array	serverTemppasswordList
  */
	function serverTempPasswordList() {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('multi', 'servertemppasswordlist');
	}
	

/**
  *	setClientChannelGroup
  *
  * Sets the channel group of a client to the ID specified with cgid.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $cgid	groupID
  * @param		integer $cid	channelID
  * @param		integer $cldbid	clientDBID
  * @return     boolean success
  */
	function setClientChannelGroup($cgid, $cid, $cldbid) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('boolean', 'setclientchannelgroup cgid='.$cgid.' cid='.$cid.' cldbid='.$cldbid);
	}

/**
  * setName
  * 
  * Sets your nickname in server query
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string	$newName	new name in server query
  * @return     boolean success
  */
	function setName($newName) {
		return $this->getData('boolean', 'clientupdate client_nickname='.$this->escapeText($newName));
	}

/**
  * tokenAdd
  * 
  * Create a new token. If tokentype is set to 0, the ID specified with tokenid1 will be a server group ID. Otherwise, tokenid1 is used as a channel group ID and you need to provide a valid channel ID using tokenid2. The tokencustomset parameter allows you to specify a set of custom client properties. This feature can be used when generating tokens to combine a website account database with a TeamSpeak user. The syntax of the value needs to be escaped using the ServerQuery escape patterns and has to follow the general syntax of:<br>
  * ident=ident1 value=value1|ident=ident2 value=value2|ident=ident3 value=value3
  *
  * <b>Input-Array like this:</b>
  * <code>
  * $customFieldSet = array();
  *	
  * $customFieldSet['ident'] = 'value';
  * $customFieldSet['ident'] = 'value';
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer	$tokentype				token type
  * @param		integer	$tokenid1				groupID
  * @param		integer	$tokenid2				channelID
  * @param		string	$description			token description [optional]
  * @param		array	$customFieldSet			customFieldSet [optional]
  * @return     array	tokenInformation
  */
	function tokenAdd($tokentype, $tokenid1, $tokenid2, $description ='', $customFieldSet = array()) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		
		if(!empty($description)) { $description = ' tokendescription=' . $this->escapeText($description); }

		if(count($customFieldSet)) {
			$settingsString = array();
		
			foreach($customFieldSet as $key => $value) {
				$settingsString[] = 'ident='.$this->escapeText($key).' value='.$this->escapeText($value);
			}
			
			$customFieldSet = ' tokencustomset='.implode('|', $settingsString);
		}else{
			$customFieldSet = '';
		}
		
		return $this->getData('array', 'privilegekeyadd tokentype='.$tokentype.' tokenid1='.$tokenid1.' tokenid2='.$tokenid2.$description.$customFieldSet);
	}

/**
  * tokenDelete
  * 
  * Deletes an existing token matching the token key specified with token.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string	$token	token
  * @return     boolean success
  */
	function tokenDelete($token) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }			
		return $this->getData('boolean', 'privilegekeydelete token='.$token);
	}

/**
  * tokenList
  * 
  * Displays a list of privilege keys available including their type and group IDs. Tokens can be used to gain access to specified server or channel groups. A privilege key is similar to a client with administrator privileges that adds you to a certain permission group, but without the necessity of a such a client with administrator privileges to actually exist. It is a long (random looking) string that can be used as a ticket into a specific server group.
  *
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [token] => GdqedxSEDle3e9+LtR3o9dO09bURH+vymvF5hOJg
  *  [token_type] => 0
  *  [token_id1] => 71
  *  [token_id2] => 0
  *  [token_created] => 1286625908
  *  [token_description] => for you
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @return     array tokenListist 
  */
	function tokenList() {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }

		return $this->getData('multi', 'privilegekeylist');
	}

/**
  * tokenUse
  * 
  * Use a token key gain access to a server or channel group. Please note that the server will automatically delete the token after it has been used.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string	$token	token
  * @return     boolean success
  */
	function tokenUse($token) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }			
		return $this->getData('boolean', 'privilegekeyuse token='.$token);
	}

/**
  * version
  * 
  * Displays the servers version information including platform and build number.
  *
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [version] => 3.0.6.1
  *  [build] => 1340956745
  *  [platform] => Windows
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @return     array versionInformation
  */
	function version() {
		return $this->getData('array', 'version');
	}

/**
  * whoAmI
  * 
  * Displays information about your current ServerQuery connection including your loginname, etc.
  *
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [virtualserver_status] => online
  *  [virtualserver_id] => 1
  *  [virtualserver_unique_identifier] => bYrybKl/APfKq7xzpIJ1Xb6C06U=
  *  [virtualserver_port] => 9987
  *  [client_id] => 5
  *  [client_channel_id] => 1
  *  [client_nickname] => serveradmin from 127.0.0.1:15208
  *  [client_database_id] => 1
  *  [client_login_name] => serveradmin
  *  [client_unique_identifier] => serveradmin
  *  [client_origin_server_id] => 0
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @return     array clientinformation
  */
	function whoAmI() {
		return $this->getData('array', 'whoami');
	}

//*******************************************************************************************	
//************************************ Helper Functions ************************************
//*******************************************************************************************

/**
  * checkSelected throws out 2 errors
  *
  * <b>Output:</b><br>
  * <code>
  * Array
  * {
  *  [success] => false
  *  [errors] => Array 
  *  [data] => false
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		private
  * @return     array error
  */
	private function checkSelected() {
		$backtrace = debug_backtrace();
		$this->addDebugLog('you can\'t use this function if no server is selected', $backtrace[1]['function'], $backtrace[0]['line']);
		return $this->generateOutput(false, array('you can\'t use this function if no server is selected'), false);
	}

/**
  * convertSecondsToStrTime
  * 
  * Converts seconds to a strTime (bsp. 5d 1h 23m 19s)
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer	$seconds	time in seconds
  * @return     string strTime
  */
 	public function convertSecondsToStrTime($seconds) {
		$conv_time = $this->convertSecondsToArrayTime($seconds);
    	return $conv_time['days'].'d '.$conv_time['hours'].'h '.$conv_time['minutes'].'m '.$conv_time['seconds'].'s';
	}

/**
  * convertSecondsToArrayTime
  * 
  * Converts seconds to a array: time
  *
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [days] => 3
  *  [hours] => 9
  *  [minutes] => 45
  *  [seconds] => 17
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer	$seconds	time in seconds
  * @return     array time
  */
 	public function convertSecondsToArrayTime($seconds) {
		$conv_time = array();
		$conv_time['days']=floor($seconds / 86400);
		$conv_time['hours']=floor(($seconds - ($conv_time['days'] * 86400)) / 3600);
		$conv_time['minutes']=floor(($seconds - (($conv_time['days'] * 86400)+($conv_time['hours']*3600))) / 60);
		$conv_time['seconds']=floor(($seconds - (($conv_time['days'] * 86400)+($conv_time['hours']*3600)+($conv_time['minutes'] * 60))));
		return $conv_time;
	}

/**
  * getElement
  * 
  * Returns the given associated element from an array<br>
  * This can be used to get a result in a one line operation<br><br>
  * 
  * For example you got this array:
  * <code>
  * Array
  * {
  *  [success] => false
  *  [errors] => Array 
  *  [data] => false
  * }
  * </code><br>
  * Now you can grab the element like this:
  * <code>
  * $ts = new ts3admin('***', '***');
  * 
  * if($ts->getElement('success', $ts->connect())) {
  *  //operation
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string	$element	key of element
  * @param		array	$array		array
  * @return     mixed
  */
	public function getElement($element, $array) {
		return $array[$element];
	}

/**
  * succeeded
  * 
  * Succeeded will check the success element of a return array<br>
  * <code>
  * $ts = new ts3admin('***', '***');
  * 
  * if($ts->succeeded($ts->connect())) {
  *  //operation
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		array	$array	result
  * @return     boolean
  */
	public function succeeded($array) {
		if(isset($array['success'])) {
			return $array['success'];
		}else{
			return false;
		}
	}
	
	

//*******************************************************************************************	
//*********************************** Internal Functions ************************************
//*******************************************************************************************

/**
 * __construct
 * 
 * @ignore
 * @author	Par0noid Solutions
 * @access	private
 * @param	string	$host		ts3host
 * @param	integer	$queryport	ts3queryport
 * @param	integer	$timeout	socket timeout (default = 2) [optional]
 * @return	void
*/
	function __construct($host, $queryport, $timeout = 2) {
		if($queryport >= 1 and $queryport <= 65536) {
			if($timeout >= 1) {
				$this->runtime['host'] = $host;
				$this->runtime['queryport'] = $queryport;
				$this->runtime['timeout'] = $timeout;
			}else{
				$this->addDebugLog('invalid timeout value');
			}
		}else{
			$this->addDebugLog('invalid queryport');
		}
	}

/**
 * __destruct
 * 
 * @ignore
 * @author	Par0noid Solutions
 * @access	private
 * @return	void
*/
	function __destruct() {
		$this->quit();
	}

/**
 * __call
 * 
 * prevents your website from php errors if you want to execute a method which doesn't exists
 * 
 * @ignore
 * @author	Par0noid Solutions
 * @access	private
 * @param	string	$name	method name
 * @param	array	$args	method arguments
 * @return	void
*/
	function __call($name, $args) {
		$this->addDebugLog('Method '.$name.' doesn\'t exist', $name, 0);
		return $this->generateOutput(false, array('Method '.$name.' doesn\'t exist'), false);
	}

/**
  * isConnected
  * 
  * Checks if the connection is established
  *
  * @author     Par0noid Solutions
  * @access		private
  * @return     boolean connected
  */
	private function isConnected() {
		if(empty($this->runtime['socket'])) {
			return false;
		}else{
			return true;
		}
	}

/**
  * generateOutput
  * 
  * Builds a method return as array
  *
  * @author     Par0noid Solutions
  * @access		private
  * @param		boolean		$success	true/false
  * @param		array		$errors		all errors which occured while executing a method
  * @param		mixed		$data		parsed data from server
  * @return     array output
  */
	private function generateOutput($success, $errors, $data) {
		return array('success' => $success, 'errors' => $errors, 'data' => $data);
	}

/**
  * unEscapeText
  * 
  * Turns escaped chars to normals
  *
  * @author     Par0noid Solutions
  * @access		private
  * @param		string	$text	text which should be escaped
  * @return     string	text
  */
 	private function unEscapeText($text) {
 		$escapedChars = array("\t", "\v", "\r", "\n", "\f", "\s", "\p", "\/");
 		$unEscapedChars = array('', '', '', '', '', ' ', '|', '/');
		$text = str_replace($escapedChars, $unEscapedChars, $text);
		return $text;
	}

/**
  * escapeText
  * 
  * Escapes chars that we can use it in the query
  *
  * @author     Par0noid Solutions
  * @access		private
  * @param		string	$text	text which should be escaped
  * @return     string	text
  */
 	private function escapeText($text) {
 		$text = str_replace("\t", '\t', $text);
		$text = str_replace("\v", '\v', $text);
		$text = str_replace("\r", '\r', $text);
		$text = str_replace("\n", '\n', $text);
		$text = str_replace("\f", '\f', $text);
		$text = str_replace(' ', '\s', $text);
		$text = str_replace('|', '\p', $text);
		$text = str_replace('/', '\/', $text);
		return $text;
	}

/**
  * splitBanIds
  * 
  * Splits banIds to array
  *
  * @author     Par0noid Solutions
  * @access		private
  * @param		string	$text	plain text server response
  * @return     string	text
  */
 	private function splitBanIds($text) {
		$data = array();
		$text = str_replace(array("\n", "\r"), '', $text);
		$ids = explode("banid=", $text);
		unset($ids[0]);
		return $ids;
	}

//*******************************************************************************************	
//************************************ Network Functions ************************************
//*******************************************************************************************

/**
  * connect
  * 
  * Connects to a ts3instance query port
  *
  * @author     Par0noid Solutions
  * @access		public
  * @return		boolean success
  */
	function connect() {
		if($this->isConnected()) { 
			$this->addDebugLog('Error: you are already connected!');
			return $this->generateOutput(false, array('Error: the script is already connected!'), false);
		}
		$socket = @fsockopen($this->runtime['host'], $this->runtime['queryport'], $errnum, $errstr, $this->runtime['timeout']);

		if(!$socket) {
			$this->addDebugLog('Error: connection failed!');
			return $this->generateOutput(false, array('Error: connection failed!', 'Server returns: '.$errstr), false);
		}else{
			if(strpos(fgets($socket), 'TS3') !== false) {
				$tmpVar = fgets($socket);
				$this->runtime['socket'] = $socket;
				return $this->generateOutput(true, array(), true);
			}else{
				$this->addDebugLog('host isn\'t a ts3 instance!');
				return $this->generateOutput(false, array('Error: host isn\'t a ts3 instance!'), false);
			}
		}
	}

/**
  * executeCommand
  * 
  * Executes a command and fetches the response
  *
  * @author     Par0noid Solutions
  * @access		private
  * @param		string	$command	command which should be executed
  * @param		array	$tracert	array with information from first exec
  * @return     mixed data
  */
	private function executeCommand($command, $tracert) {
		if(!$this->isConnected()) {
			$this->addDebugLog('script isn\'t connected to server', $tracert[1]['function'], $tracert[0]['line']);
			return $this->generateOutput(false, array('Error: script isn\'t connected to server'), false);
		}
		
		$data = '';

		
		$splittedCommand = str_split($command, 1024);
		
		$splittedCommand[(count($splittedCommand) - 1)] .= "\n";
		
		foreach($splittedCommand as $commandPart) {
			fputs($this->runtime['socket'], $commandPart);
		}

		do {
			$data .= fgets($this->runtime['socket'], 4096);
			
			if(strpos($data, 'error id=3329 msg=connection') !== false) {
				$this->runtime['socket'] = '';
				$this->addDebugLog('You got banned from server. Socket closed.', $tracert[1]['function'], $tracert[0]['line']);
				return $this->generateOutput(false, array('You got banned from server. Connection closed.'), false);
			}
			
		} while(strpos($data, 'msg=') === false or strpos($data, 'error id=') === false);

		if(strpos($data, 'error id=0 msg=ok') === false) {
			$splittedResponse = explode('error id=', $data);
			$chooseEnd = count($splittedResponse) - 1;
			
			$cutIdAndMsg = explode(' msg=', $splittedResponse[$chooseEnd]);
			
			$this->addDebugLog('ErrorID: '.$cutIdAndMsg[0].' | Message: '.$this->unEscapeText($cutIdAndMsg[1]), $tracert[1]['function'], $tracert[0]['line']);
			
			return $this->generateOutput(false, array('ErrorID: '.$cutIdAndMsg[0].' | Message: '.$this->unEscapeText($cutIdAndMsg[1])), false);
		}else{
			return $this->generateOutput(true, array(), $data);
		}
	}

/**
 * getData
 * 
 * Parses data from query and returns an array
 * 
 * @author		Par0noid Solutions
 * @access		private
 * @param		string	$mode		select return mode ('boolean', 'array', 'multi', 'plain')
 * @param		string	$command	command which should be executed
 * @return		mixed data
 */
	private function getData($mode, $command) {
	
		$validModes = array('boolean', 'array', 'multi', 'plain');
	
		if(!in_array($mode, $validModes)) {
			$this->addDebugLog($mode.' is an invalid mode');
			return $this->generateOutput(false, array('Error: '.$mode.' is an invalid mode'), false);
		}
		
		if(empty($command)) {
			$this->addDebugLog('you have to enter a command');
			return $this->generateOutput(false, array('Error: you have to enter a command'), false);
		}
		
		$fetchData = $this->executeCommand($command, debug_backtrace());
		
		
		$fetchData['data'] = str_replace(array('error id=0 msg=ok', chr('01')), '', $fetchData['data']);
		
		
		if($fetchData['success']) {
			if($mode == 'boolean') {
				return $this->generateOutput(true, array(), true);
			}
			
			if($mode == 'array') {
				if(empty($fetchData['data'])) { return $this->generateOutput(true, array(), array()); }
				$datasets = explode(' ', $fetchData['data']);
				
				$output = array();
				
				foreach($datasets as $dataset) {
					$dataset = explode('=', $dataset);
					
					if(count($dataset) > 2) {
						for($i = 2; $i < count($dataset); $i++) {
							$dataset[1] .= '='.$dataset[$i];
						}
						$output[$this->unEscapeText($dataset[0])] = $this->unEscapeText($dataset[1]);
					}else{
						if(count($dataset) == 1) {
							$output[$this->unEscapeText($dataset[0])] = '';
						}else{
							$output[$this->unEscapeText($dataset[0])] = $this->unEscapeText($dataset[1]);
						}
						
					}
				}
				return $this->generateOutput(true, array(), $output);
			}
			if($mode == 'multi') {
				if(empty($fetchData['data'])) { return $this->generateOutput(true, array(), array()); }
				$datasets = explode('|', $fetchData['data']);
				
				$output = array();
				
				foreach($datasets as $datablock) {
					$datablock = explode(' ', $datablock);
					
					$tmpArray = array();
					
					foreach($datablock as $dataset) {
						$dataset = explode('=', $dataset);
						if(count($dataset) > 2) {
							for($i = 2; $i < count($dataset); $i++) {
								$dataset[1] .= '='.$dataset[$i];
							}
							$tmpArray[$this->unEscapeText($dataset[0])] = $this->unEscapeText($dataset[1]);
						}else{
							if(count($dataset) == 1) {
								$tmpArray[$this->unEscapeText($dataset[0])] = '';
							}else{
								$tmpArray[$this->unEscapeText($dataset[0])] = $this->unEscapeText($dataset[1]);
							}
						}					
					}
					$output[] = $tmpArray;
				}
				return $this->generateOutput(true, array(), $output);
			}
			if($mode == 'plain') {
				return $fetchData;
			}
		}else{
			return $this->generateOutput(false, $fetchData['errors'], false);
		}
	}

/**
  * ftSendKey
  * 
  * Sends down/upload-key to ftHost
  * 
  * @author     Par0noid Solutions
  * @access		private
  * @param		string	$key
  * @param		string $additional
  * @return     none
 */
	private function ftSendKey($key, $additional = NULL) {
		fputs($this->runtime['fileSocket'], $key.$additional);
	}

/**
  * ftSendData
  * 
  * Sends data to ftHost
  * 
  * @author     Par0noid Solutions
  * @access		private
  * @param		mixed	$data
  * @return     none
 */
	private function ftSendData($data) {
		$data = str_split($data, 4096);
		foreach($data as $dat) {
			fputs($this->runtime['fileSocket'], $dat);
		}
	}

/**
  * ftRead
  * 
  * Reads data from ftHost
  * 
  * @author     Par0noid Solutions
  * @access		private
  * @param		int	$size
  * @return     string data
 */
	private function ftRead($size) {
		$data = '';
		while(strlen($data) < $size) {		
			$data .= fgets($this->runtime['fileSocket'], 4096);
		}
		return $data;
	}

//*******************************************************************************************	
//************************************* Debug Functions *************************************
//*******************************************************************************************

/**
  * getDebugLog
  * 
  * Returns the debug log
  *
  * <b>Output:</b>
  * <code>
  * Array
  * {
  *  [0] => Error in login() on line 1908: ErrorID: 520 | Message: invalid loginname or password
  *  [1] => Error in selectServer() on line 2044: ErrorID: 1540 | Message: convert error
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @return     array debugLog
  */
 	public function getDebugLog() {
		return $this->runtime['debug'];
	}

/**
  * addDebugLog
  * 
  * Adds an entry to debugLog
  *
  * @author     Par0noid Solutions
  * @access		private
  * @param		string	$text			text which should added to debugLog
  * @param		string	$methodName		name of the executed method [optional]
  * @param		string	$line			line where error triggered [optional]
  * @return     array debugLog
  */
	private function addDebugLog($text, $methodName = '', $line = '') {
		if(empty($methodName) and empty($line)) {
			$backtrace = debug_backtrace();
			$methodName = $backtrace[1]['function'];
			$line = $backtrace[0]['line'];
		}
		$this->runtime['debug'][] = 'Error in '.$methodName.'() on line '.$line.': '.$text;	
	}
}


/*///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

TTTTTTTTTTTTTTTTTTTTTTTHHHHHHHHH     HHHHHHHHHEEEEEEEEEEEEEEEEEEEEEE     EEEEEEEEEEEEEEEEEEEEEENNNNNNNN        NNNNNNNNDDDDDDDDDDDDD        
T:::::::::::::::::::::TH:::::::H     H:::::::HE::::::::::::::::::::E     E::::::::::::::::::::EN:::::::N       N::::::ND::::::::::::DDD     
T:::::::::::::::::::::TH:::::::H     H:::::::HE::::::::::::::::::::E     E::::::::::::::::::::EN::::::::N      N::::::ND:::::::::::::::DD   
T:::::TT:::::::TT:::::THH::::::H     H::::::HHEE::::::EEEEEEEEE::::E     EE::::::EEEEEEEEE::::EN:::::::::N     N::::::NDDD:::::DDDDD:::::D  
TTTTTT  T:::::T  TTTTTT  H:::::H     H:::::H    E:::::E       EEEEEE       E:::::E       EEEEEEN::::::::::N    N::::::N  D:::::D    D:::::D 
        T:::::T          H:::::H     H:::::H    E:::::E                    E:::::E             N:::::::::::N   N::::::N  D:::::D     D:::::D
        T:::::T          H::::::HHHHH::::::H    E::::::EEEEEEEEEE          E::::::EEEEEEEEEE   N:::::::N::::N  N::::::N  D:::::D     D:::::D
        T:::::T          H:::::::::::::::::H    E:::::::::::::::E          E:::::::::::::::E   N::::::N N::::N N::::::N  D:::::D     D:::::D
        T:::::T          H:::::::::::::::::H    E:::::::::::::::E          E:::::::::::::::E   N::::::N  N::::N:::::::N  D:::::D     D:::::D
        T:::::T          H::::::HHHHH::::::H    E::::::EEEEEEEEEE          E::::::EEEEEEEEEE   N::::::N   N:::::::::::N  D:::::D     D:::::D
        T:::::T          H:::::H     H:::::H    E:::::E                    E:::::E             N::::::N    N::::::::::N  D:::::D     D:::::D
        T:::::T          H:::::H     H:::::H    E:::::E       EEEEEE       E:::::E       EEEEEEN::::::N     N:::::::::N  D:::::D    D:::::D 
      TT:::::::TT      HH::::::H     H::::::HHEE::::::EEEEEEEE:::::E     EE::::::EEEEEEEE:::::EN::::::N      N::::::::NDDD:::::DDDDD:::::D  
      T:::::::::T      H:::::::H     H:::::::HE::::::::::::::::::::E     E::::::::::::::::::::EN::::::N       N:::::::ND:::::::::::::::DD   
      T:::::::::T      H:::::::H     H:::::::HE::::::::::::::::::::E     E::::::::::::::::::::EN::::::N        N::::::ND::::::::::::DDD     
      TTTTTTTTTTT      HHHHHHHHH     HHHHHHHHHEEEEEEEEEEEEEEEEEEEEEE     EEEEEEEEEEEEEEEEEEEEEENNNNNNNN         NNNNNNNDDDDDDDDDDDDD

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/
?>