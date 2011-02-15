<?PHP
/**
 *                            ts3admin.class.php							<br />
 *                            ------------------							<br />
 *   begin                : Saturday, Dec 19, 2009							<br />
 *   copyright            : (C) 2009-2010 Par0nid Solutions					<br />
 *   email                : par0noid@gmx.de									<br />
 *   version              : 0.5.9											<br />
 *   last modified        : Tuesday, Nov 02, 2010							<br />
 *   build				  : 5124364											<br />
 * 

    This file is a powerful library for querying TeamSpeak3 servers.<br />																			
    
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/

/**
 * @author		Par0noid Solutions <par0noid@gmx.de>
 * @package		ts3admin
 * @version		0.5.9
 * @copyright	Copyright (c) 2009-2010, Stefan Z.
 * @link		http://ts3admin.6x.to
 */
class ts3admin {

//*******************************************************************************************	
//****************************************** Vars *******************************************
//*******************************************************************************************

	//ts3admin runtime values
	private $runtime = array('socket' => '', 'selected' => false, 'host' => '', 'queryport' => '10011', 'timeout' => 2, 'debug' => array(), 'fileSocket' => '');

	
//*******************************************************************************************	
//************************************ Public Functions *************************************
//******************************************************************************************

/**
  * banAddByIp bans a client from the selected server by ip<br><br><br>
  *
  * <b>Output:</b><br>
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
  * @param		string	$banreason	banreason [optional]
  * @return     array banId/s
  */
	function banAddByIp($ip, $time, $banreason = '') {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		
		if(!empty($banreason)) { $msg = ' banreason='.$this->escapeText($banreason); } else { $msg = ''; }

		return $this->getData('array', 'banadd ip='.$ip.' time='.$time.$msg);
	}

/**
  * banAddByUid bans a client from the selected server by uid<br><br><br>
  *
  * <b>Output:</b><br>
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
  * @param		string	$banreason	Banreason (optional)
  * @return     array banId/s
  */
	function banAddByUid($uid, $time, $banreason = "") {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		if(!empty($banreason)) { $msg = ' banreason='.$this->escapeText($banreason); } else { $msg = ''; }
		
		return $this->getData('array', 'banadd uid='.$uid.' time='.$time.$msg);
	}

/**
  * banAddByName bans a client from the selected server by name<br><br><br>
  *
  * <b>Output:</b><br>
  * <code>
  * Array
  * {
  *  [banid] => 110
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string	$name		clientName
  * @param		integer	$time		bantime in seconds (0=unlimited)
  * @param		string	$banreason	Banreason [optional]
  * @return     array banId/s
  */
	function banAddByName($name, $time, $banreason = "") {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		if(!empty($banreason)) { $msg = ' banreason='.$this->escapeText($banreason); } else { $msg = ''; }
										
		return $this->getData('array', 'banadd name='.$this->escapeText($name).' time='.$time.$msg);
	}

/**
  * banClient bans a client from the selected server<br><br><br>
  *
  * <b>Output:</b><br>
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
  * @param		string	$banreason	Kick reason [optional]
  * @return     array banId/s
  */
	function banClient($clid, $time, $banreason = '') {
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
  * banDelete deletes a ban from banlist
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
  * banDeleteAll deletes all bans from banlist
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
  * banList returns all bans on selected server<br><br><br>
  *
  * <b>Output:</b><br>
  * <code>
  * Array
  * {
  *  [banid] => 131
  *  [ip] => 63\.54\.78\.14
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
  * @param		string	$params	additional parameters [optional]
  * @return     array banList
  */
	function banList($params = '') {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		
		if(!empty($params)) { $params = ' '.$params; }
		
		return $this->getData('multi', 'banlist'.$params);
	}

/**
  * bindingList displays a list of IP addresses used by the server instance on multi-homed machines<br><br><br>
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
  * @return     multidimensional-array bindingList
  */
	function bindingList() {
		return $this->getData('multi', 'bindinglist');
	}

/**
  * channelAddPerm adds a set of specified permissions to a channel<br><br><br>
  * 
  * <b>Input-Array like this:</b><br>
  * <code>
  * <?PHP
  * $permissions = array();
  * $permissions['permissionID'] = 'permissionValue';
  * ?>
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
    				$permissionArray[] = 'permid='.$key.' permvalue='.$value;
    			}
				$result = $this->getData('boolean', 'channeladdperm cid='.$cid.' '.implode('|', $permissionArray));
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
        }
	}

/**
  * channelClientAddPerm adds a set of specified permissions to a client in a specific channel<br><br><br>
  * 
  * <b>Input-Array like this:</b><br>
  * <code>
  * <?PHP
  * $permissions = array();
  * $permissions['permissionID'] = 'permissionValue';
  * ?>
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer		$cid			channelID
  * @param		integer		$cldbid			clientDatabaseId
  * @param		array		$permissions	permissions
  * @return     boolean success
  */
	function channelClientAddPerm($cid, $cldbid, $permissions) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
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
    				$permissionArray[] = 'permid='.$key.' permvalue='.$value;
    			}
				$result = $this->getData('boolean', 'channelclientaddperm cid='.$cid.' cldbid='.$cldbid.' '.implode('|', $permissionArray));
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
        }
	}

/**
  * channelClientDelPerm removes a set of specified permissions from a client in a specific channel<br><br><br>
  *
  * <b>Input-Array like this:</b><br>
  * <code>
  * <?PHP
  * $permissions = array();
  * $permissions[] = 'permissionID';
  * ?>
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer		$cid				channelID
  * @param		integer		$cldbid				clientDatabaseID
  * @param		array		$permissionIds		permissionIDs
  * @return     boolean success
  */
	function channelClientDelPerm($cid, $cldbid, $permissionIds) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		$permissionArray = array();
		
		if(count($permissionIds) > 0) {
			foreach($permissionIds AS $value) {
				$permissionArray[] = 'permid='.$value;
			}
			return $this->getData('boolean', 'channelclientdelperm cid='.$cid.' cldbid='.$cldbid.' '.implode('|', $permissionArray));
		}else{
			$this->addDebugLog('no permissions given');
			return $this->generateOutput(false, array('Error: no permissions given'), false);
		}
	}

/**
  * channelClientPermList displays a list of permissions defined for a client in a specific channel<br><br><br>
  *
  * <b>Output:</b><br>
  * <code>
  * Array
  * {
  *  [cid] => 250
  *  [cldbid] => 2086
  *  [permid] => 12876
  *  [permvalue] => 1
  *  [permnegated] => 0
  *  [permskip] => 0
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer		$cid		channelID
  * @param		integer		$cldbid		clientDatabaseID
  * @param		boolean		$permsid	set true to add -permsid param [optional]
  * @return     multidimensional-array	channelclientpermlist
  */
	function channelClientPermList($cid, $cldbid, $permsid = false) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		if($permsid) { $additional = ' -permsid'; }else{ $additional = ''; }
		
		return $this->getData('multi', 'channelclientpermlist cid='.$cid.' cldbid='.$cldbid.$additional);
	}

/**
  * channelCreate creates a new channel using the given properties and displays its ID<br><br><br>
  * 
  * <b>Hint:</b> don't forget to set channel_flag_semi_permanent = 0 and channel_flag_permanent = 1<br><br><br>
  * 
  * <b>Input-Array like this:</b><br>
  * <code>
  * <?PHP 
  * $data = array();
  * 
  * $data['setting'] = 'value';
  * $data['setting'] = 'value';
  * ?>
  * </code><br><br><br>
  * 
  * <b>Output:</b><br>
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
  * channelDelete deletes an existing channel by ID. If force is set to 1, the channel will be deleted even if there are clients within
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $cid channelID
  * @param		integer $force forces deleting channel (default: 1)
  * @return     boolean success
  */
	function channelDelete($cid, $force = 1) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('boolean', 'channeldelete cid='.$cid.' force='.$force);
	}

/**
  * channelDelPerm removes a set of specified permissions from a channel<br><br><br>
  *
  * <b>Input-Array like this:</b><br>
  * <code>
  * <?PHP
  * $permissions = array();
  * $permissions[] = 'permissionID';
  * ?>
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer		$cid				channelID
  * @param		array		$permissionIds		permissionIDs
  * @return     boolean	success
  */
	function channelDelPerm($cid, $permissionIds) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		$permissionArray = array();
		
		if(count($permissionIds) > 0) {
			foreach($permissionIds AS $value) {
				$permissionArray[] = 'permid='.$value;
			}
			return $this->getData('boolean', 'channeldelperm cid='.$cid.' '.implode('|', $permissionArray));
		}else{
			$this->addDebugLog('no permissions given');
			return $this->generateOutput(false, array('Error: no permissions given'), false);
		}
	}

/**
  * channelEdit changes a channels configuration using given properties<br><br><br>
  *
  * <b>Input-Array like this:</b><br>
  * <br><code>
  * <?PHP
  * $data = array();
  *	
  * $data['setting'] = 'value';
  * $data['setting'] = 'value';
  * ?>
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer	$cid	$channelId
  * @param		array	$data	newSettings
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
  * channelFind displays a list of channels matching a given name pattern.<br><br><br>
  *
  * <b>Output:</b><br>
  * <code>
  * Array
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
  * @return     multidimensional-array channelList 
  */
	function channelFind($pattern) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('multi', 'channelfind pattern='.$this->escapeText($pattern));
	}

/**
  * channelGroupAdd creates a new channel group using a given name and displays its ID<br><br><br>
  *
  * <b>Output:</b><br>
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
  * @return     boolean success
  */
	function channelGroupAdd($name) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('array', 'channelgroupadd name='.$this->escapeText($name));
	}

/**
  * channelGroupAddPerm adds a set of specified permissions to a channel group<br><br><br>
  *
  * <b>Input-Array like this:</b><br>
  * <code>
  * <?PHP
  * $permissions = array();
  * $permissions['permissionID'] = 'permissionValue';
  * ?>
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
    				$permissionArray[] = 'permid='.$key.' permvalue='.$value;
    			}
				$result = $this->getData('boolean', 'channelgroupaddperm cgid='.$cgid.' '.implode('|', $permissionArray));
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
        }
	}

/**
  * channelGroupClientList displays all the client and/or channel IDs currently assigned to channel groups<br><br><br>
  *
  * <b>Output:</b><br>
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
  * @param		integer $cid channelID [optional]
  * @param		integer $clid clientID [optional]
  * @param		integer $cgid groupID [optional]
  * @return     multidimensional-array channelGroupClientList
  */
	function channelGroupClientList($cid = '', $clid = '', $cgid = '') {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		
		if(!empty($cid)) { $cid = ' cid='.$cid; }
		if(!empty($clid)) { $clid = ' clid='.$clid; }
		if(!empty($cgid)) { $cgid = ' cgid='.$cgid; }
		
		return $this->getData('multi', 'channelgroupclientlist '.$cid.$clid.$cgid);
	}

/**
  * channelGroupCopy creates a copy of the channel group specified with scgid. If tcgid is set to 0, the server will create a new group. To overwrite an existing group, simply set tcgid to the ID of a designated target group. If a target group is set, the name parameter will be ignored.<br><br><br>
  *
  * <b>Output:</b><br>
  * <code>
  * Array
  * {
  *  [cgid] => 86
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer	$scgid	sourceChannelGroupId
  * @param		integer	$tcgid	targetChannelGroupId 
  * @param		integer $name	groupName
  * @param		integer	$type	groupDbType (0 = template, 1 = normal, 2 = query | Default: 1)
  * @return     array groupId
  */
	function ChannelGroupCopy($scgid, $tcgid, $name, $type = 1) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('array', 'channelgroupcopy scgid='.$scgid.' tcgid='.$tcgid.' name='.$this->escapeText($name).' type='.$type);
	}

/**
  * channelGroupDelete deletes a channel group by ID. If force is set to 1, the channel group will be deleted even if there are clients within.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $cgid	groupID
  * @param		integer $force	forces deleting channelGroup (default: 1)
  * @return     boolean success
  */
	function channelGroupDelete($cgid, $force = 1) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('boolean', 'channelgroupdel cgid='.$cgid.' force='.$force);
	}

/**
  * channelGroupDelPerm removes a set of specified permissions from a channel group<br><br><br>
  *
  * <b>Input-Array like this:</b><br>
  * <code>
  * <?PHP
  * $permissions = array();
  * $permissions[] = 'permissionID';
  * ?>
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer		$cgid				channelGroupID
  * @param		array		$permissionIds		permissionIds
  * @return     boolean success
  */
	function channelGroupDelPerm($cgid, $permissionIds) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		$permissionArray = array();
		
		if(count($permissionIds) > 0) {
			foreach($permissionIds AS $value) {
				$permissionArray[] = 'permid='.$value;
			}
			return $this->getData('boolean', 'channelgroupdelperm cgid='.$cgid.' '.implode('|', $permissionArray));
		}else{
			$this->addDebugLog('no permissions given');
			return $this->generateOutput(false, array('Error: no permissions given'), false);
		}
	}

/**
  * channelGroupList displays a list of channel groups available on the selected virtual server<br><br><br>
  *
  * <b>Output:</b><br>
  * <code>
  * Array
  * {
  *  [cgid] => 3
  *  [name] => Testname
  *  [type] => 0
  *  [iconid] => 300
  *  [savedb] => 1
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @return     multidimensional-array channelGroupList
  */
	function channelGroupList() {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		
		return $this->getData('multi', 'channelgrouplist');
	}

/**
  * channelGroupPermList displays a list of permissions assigned to the channel group specified with cgid<br><br><br>
  *
  * <b>Output:</b><br>
  * <code>
  * Array
  * {
  *  [permid] => 8471
  *  [permvalue] => 1
  *  [permnegated] => 0
  *  [permskip] => 0
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer		$cgid		groupID
  * @param		boolean		$permsid	set true to add -permsid param [optional]
  * @return     multidimensional-array channelGroupPermlist
  */
	function channelGroupPermList($cgid, $permsid = false) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		if($permsid) { $additional = ' -permsid'; }else{ $additional = ''; }
		
		return $this->getData('multi', 'channelgrouppermlist cgid='.$cgid.$additional);
	}

/**
  * channelGroupRename changes the name of a specified channel group
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
  * channelInfo returns informations about a channel<br><br><br>
  *
  * <b>Output:</b><br>
  * <code>
  * Array
  * {
  *  [pid] => 0
  *  [channel_name] => Lobby
  *  [channel_topic] => 
  *  [channel_description] => 
  *  [channel_password] => lvf8bNFzJBrcgQsODESkvPzlcwo=
  *  [channel_codec] => 2
  *  [channel_codec_quality] => 10
  *  [channel_maxclients] => -1
  *  [channel_maxfamilyclients] => -1
  *  [channel_order] => 230
  *  [channel_flag_permanent] => 1
  *  [channel_flag_semi_permanent] => 0
  *  [channel_flag_default] => 0
  *  [channel_flag_password] => 0
  *  [channel_codec_latency_factor] => 1
  *  [channel_codec_is_unencrypted] => 1
  *  [channel_flag_maxclients_unlimited] => 1
  *  [channel_flag_maxfamilyclients_unlimited] => 0
  *  [channel_flag_maxfamilyclients_inherited] => 1
  *  [channel_filepath] => files/virtualserver_11/channel_231
  *  [channel_needed_talk_power] => 0
  *  [channel_forced_silence] => 0
  *  [channel_name_phonetic] => 
  *  [channel_icon_id] => 0
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $cid channelId
  * @return     array channelInfo
  */
	function channelInfo($cid) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('array', 'channelinfo cid='.$cid);
	}

/**
  * channelList returns information about all channels on the selected server<br><br><br>
  *
  * <b>Possible params:</b> [-topic] [-flags] [-voice] [-limits] [-icon]<br><br><br>
  *
  * <b>Output:</b><br>
  * <code>
  * Array
  * {
  *  [cid] => 1
  *  [pid] => 0
  *  [channel_order] => 0
  *  [channel_name] => Default Channel
  *  [total_clients] => 2
  *  [channel_needed_subscribe_power] => 0
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string $params	additional parameters [optional]
  * @return     multidimensional-array	channelList
  */
	function channelList($params = '') {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		if(!empty($params)) { $params = ' '.$params; }
		
		return $this->getData('multi', 'channellist'.$params);
	}

/**
  * channelMove moves a channel to a new parent channel with the ID cpid
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $cid	channelID
  * @param		integer $cpid	channelParentID
  * @param		integer $order	channelSortOrder
  * @return     boolean success
  */
	function channelMove($cid, $cpid, $order = '') {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		if(!empty($order)) { $order = ' order='.$order; }
		
		return $this->getData('boolean', 'channelmove cid='.$cid.' cpid='.$cpid.$order);
	}

/**
  * channelPermList displays a list of permissions defined for a channel<br><br><br>
  *
  * <b>Output:</b><br>
  * <code>
  * Array
  * {
  *  [permid] => 8471
  *  [permvalue] => 1
  *  [permnegated] => 0
  *  [permskip] => 0
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer		$cid		channelID
  * @param		boolean		$permsid	set true to add -permsid param [optional]
  * @return     multidimensional-array channelpermlist
  */
	function channelPermList($cid, $permsid = false) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		if($permsid) { $additional = ' -permsid'; }else{ $additional = ''; }
		
		return $this->getData('multi', 'channelpermlist cid='.$cid.$additional);
	}

/**
  * clientAddPerm adds a set of specified permissions to a client<br><br><br>
  *
  * <b>Input-Array like this:</b><br>
  * <code>
  * <?PHP
  * $permissions = array();
  * $permissions['permissionID'] = array('permissionValue', 'permskip');
  * ?>
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer					$cldbid			clientDbId
  * @param		multidimensional-array	$permissions	permissions
  * @return     boolean success
  */
	function clientAddPerm($cldbid, $permissions) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
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
    				$permissionArray[] = 'permid='.$key.' permvalue='.$value[0].' permskip='.$value[1];
    			}
				$result = $this->getData('boolean', 'clientaddperm cldbid='.$cldbid.' '.implode('|', $permissionArray));
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
        }
	}

/**
  * clientDbDelete deletes a clients properties from the database
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $cldbid	clientDbId
  * @return     boolean success
  */
	function clientDbDelete($cldbid) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('boolean', 'clientdbdelete cldbid='.$cldbid);
	}

/**
  * clientDbEdit changes a clients settings using given properties<br><br><br>
  *
  * <b>Input-Array like this:</b><br>
  * <br><code>
  * <?PHP
  * $data = array();
  *	
  * $data['setting'] = 'value';
  * $data['setting'] = 'value';
  * ?>
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer 				$cldbid		clientDbId
  * @param		multidimensional-array	$data	 	clientSettings
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
  * clientDbFind displays a list of client database IDs matching a given pattern<br><br><br>
  *
  * <b>Output:</b><br>
  * <code>
  * Array
  * {
  *  [clid] => 18
  *  [client_nickname] => par0noid
  * }
  *	</code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string	$pattern	clientName
  * @param		boolean	$uid		set true to add -uid param [optional]
  * @return     multidimensional-array clientList 
  */
	function clientDbFind($pattern, $uid = false) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		
		if($uid) { $additional = ' -uid'; }else{ $additional = ''; }
		
		return $this->getData('multi', 'clientdbfind pattern='.$this->escapeText($pattern).$additional);
	}

/**
  * clientDbList: returns all clients from db<br><br><br>
  *
  * <b>Possible params:</b> [start={offset}] [duration={limit}] [-count]<br><br><br>
  *
  * <b>Output:</b><br>
  * <code>
  * Array
  * {
  *  [cldbid] => 2
  *  [client_unique_identifier] => nUixbsq/XakrrmbqU8O30R/D8Gc=
  *  [client_nickname] => Par0noid
  *  [client_created] => 1286107981
  *  [client_lastconnected] => 1286107981
  *  [client_totalconnections] => 1
  *  [client_description] => 
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer	$start		offset [optional]
  * @param		integer	$duration	limit [optional]
  * @param		boolean	$count		set true to add -count param [optional]
  * @return     multidimensional-array clientdblist
  */
	function clientDbList($start = '', $duration = '', $count = false) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		
		if(!empty($start) or $start == 0) { $start = ' start='.$start; }
		if(!empty($duration)) { $duration = ' duration='.$duration; }
		if($count) { $count = ' -count'; }else{ $count = ''; }
		
		return $this->getData('multi', 'clientdblist'.$start.$duration.$count);
	}

/**
  * clientDelPerm removes a set of specified permissions from a client<br><br><br>
  *
  * <b>Input-Array like this:</b><br>
  * <code>
  * <?PHP
  * $permissions = array();
  * $permissions[] = 'permissionID';
  * ?>
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer		$cldbid				clientDbId
  * @param		array		$permissionIds		permissionIDs
  * @return     boolean success
  */
	function clientDelPerm($cldbid, $permissionIds) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		
		$permissionArray = array();
		
		if(count($permissionIds) > 0) {
			foreach($permissionIds AS $value) {
				$permissionArray[] = 'permid='.$value;
			}
			return $this->getData('boolean', 'clientdelperm cldbid='.$cldbid.' '.implode('|', $permissionArray));
		}else{
			$this->addDebugLog('no permissions given');
			return $this->generateOutput(false, array('Error: no permissions given'), false);
		}
	}

/**
  * clientEdit changes client settings using given properties<br><br><br>
  *
  * <b>Input-Array like this:</b><br>
  * <br><code>
  * <?PHP
  * $data = array();
  *	
  * $data['setting'] = 'value';
  * $data['setting'] = 'value';
  * ?>
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
  * clientFind displays a list of clients matching a given name pattern<br><br><br>
  *
  * <b>Output:</b><br>
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
  * @return     multidimensional-array clienList 
  */
	function clientFind($pattern) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('multi', 'clientfind pattern='.$this->escapeText($pattern));
	}

/**
  * clientGetDbIdFromUid displays the database ID matching the unique identifier specified by cluid<br><br><br>
  *
  *	<b>Output:</b><br>
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
  * @param		string	$cluid	clientUniqueId
  * @return     array clientInfo
  */
	function clientGetDbIdFromUid($cluid) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('array', 'clientgetdbidfromuid cluid='.$cluid);
	}

/**
  * clientGetIds displays all client IDs matching the unique identifier specified by cluid<br><br><br>
  *
  * <b>Output:</b><br>
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
  * @param		string	$cluid	clientUniqueId
  * @return     multidimensional-array clientList 
  */
	function clientGetIds($cluid) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('multi', 'clientgetids cluid='.$cluid);
	}

/**
  * clientGetNameFromDbid displays the database ID matching the unique identifier specified by cluid<br><br><br>
  *
  *	<b>Output:</b><br>
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
  * @param		integer	$cldbid	clientDatabaseId
  * @return     array clientInfo
  */
	function clientGetNameFromDbid($cldbid) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('array', 'clientgetnamefromdbid cldbid='.$cldbid);
	}
	
/**
  * clientGetNameFromUid displays the database ID and nickname matching the unique identifier specified by cluid<br><br><br>
  *
  *	<b>Output:</b><br>
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
  * @param		string	$cluid	clientUniqueId
  * @return     array clientInfo
  */
	function clientGetNameFromUid($cluid) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('array', 'clientgetnamefromuid cluid='.$cluid);
	}

/**
  * clientInfo returns all information about a client<br><br><br>
  *
  * <b>Output:</b><br>
  * <code>
  * Array
  * {
  *  [cid] => 1
  *  [client_idle_time] => 45211
  *  [client_unique_identifier] => nUixbsq/XakrrmbqU8O30R/D8Gc=
  *  [client_nickname] => Par0noid
  *  [client_version] => 3.0.0-beta31 [Build: 12451]
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
  *  [client_channel_group_id] => 8
  *  [client_servergroups] => 6
  *  [client_created] => 1263833443
  *  [client_lastconnected] => 1286589112
  *  [client_totalconnections] => 656
  *  [client_away] => 0
  *  [client_away_message] => 
  *  [client_type] => 0
  *  [client_flag_avatar] => e892266b06ffd7249014bd077bd4d90c
  *  [client_talk_power] => 75
  *  [client_talk_request] => 0
  *  [client_talk_request_msg] => 
  *  [client_description] => 
  *  [client_is_talker] => 0
  *  [client_month_bytes_uploaded] => 4323682
  *  [client_month_bytes_downloaded] => 17366
  *  [client_total_bytes_uploaded] => 4558572
  *  [client_total_bytes_downloaded] => 1420306
  *  [client_is_priority_speaker] => 0
  *  [client_unread_messages] => 0
  *  [client_nickname_phonetic] => 
  *  [client_needed_serverquery_view_power] => 75
  *  [client_default_token] => 
  *  [client_icon_id] => 0
  *  [client_is_channel_commander] => 0
  *  [client_country] => DE
  *  [client_base64HashClientUID] => jneilbgomklpfnkjclkoggokfdmdlhnbbpmdpagh
  *  [connection_filetransfer_bandwidth_sent] => 0
  *  [connection_filetransfer_bandwidth_received] => 0
  *  [connection_packets_sent_total] => 150
  *  [connection_bytes_sent_total] => 25325
  *  [connection_packets_received_total] => 150
  *  [connection_bytes_received_total] => 6941
  *  [connection_bandwidth_sent_last_second_total] => 81
  *  [connection_bandwidth_sent_last_minute_total] => 533
  *  [connection_bandwidth_received_last_second_total] => 83
  *  [connection_bandwidth_received_last_minute_total] => 147
  *  [connection_connected_time] => 46145
  *  [connection_client_ip] => 87.147.35.23
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
  * clientKick kicks a client from the selected server
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $clid		clientId
  * @param		string	$kickMode	kickMode (server or channel)
  * @param		string	$kickmsg 	kick reason [optional]
  * @return     boolean success
  */
	function clientKick($clid, $kickMode, $kickmsg = "") {
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
  * clientList returns all online clients on the selected virtual server<br><br><br>
  *
  * <b>Possible params:</b> [-uid] [-away] [-voice] [-times] [-groups] [-info] [-icon]<br><br><br>
  *
  * <b>Output:</b><br>
  * <code>
  * Array
  * {
  *  [clid] => 1
  *  [cid] => 1
  *  [client_database_id] => 2
  *  [client_nickname] => Par0noid
  *  [client_type] => 0
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string	$params	additional parameters [optional]
  * @return     multidimensional-array clientList 
  */
	function clientList($params = '') {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		
		if(!empty($params)) { $params = ' '.$params; }
		
		return $this->getData('multi', 'clientlist'.$params);
	}

/**
  * clientMove moves a client on the selected server
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $clid	clientID
  * @param		integer $cid	channelID
  * @return     boolean success
  */
	function clientMove($clid, $cid) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('boolean', 'clientmove clid='.$clid.' cid='.$cid);
	}

/**
  * clientPermList displays a list of permissions defined for a client<br><br><br>
  *
  * <b>Output:</b><br>
  * <code>
  * Array
  * {
  *  [permid] => 13690
  *  [permvalue] => 1000
  *  [permnegated] => 0
  *  [permskip] => 0
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		intege		$cldbid 	clientDbId
  * @param		boolean		$permsid	set true to add -permsid param [optional]
  * @return     multidimensional-array clientPermList
  */
	function clientPermList($cldbid, $permsid = false) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }

		if($permsid) { $additional = ' -permsid'; }else{ $additional = ''; }
		
		return $this->getData('multi', 'clientpermlist cldbid='.$cldbid.$additional);
	}

/**
  * clientPoke pokes a client on the selected server
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
  * clientSetServerQueryLogin updates your own ServerQuery login credentials using a specified username<br>
  * The password will be auto-generated<br><br><br>
  * 
  * <b>Output:</b><br>
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
  * complainAdd submits a complaint about the client with database ID tcldbid to the server
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $tcldbid	targetClientDbId
  * @param		string	$msg		complainMessage
  * @return     boolean success
  */
	function complainAdd($tcldbid, $msg) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('boolean', 'complainadd tcldbid='.$tcldbid.' message='.$this->escapeText($msg));
	}

/**
  * clientUpdate changes your ServerQuery clients settings using given properties<br><br><br>
  *
  * <b>Input-Array like this:</b><br>
  * <br><code>
  * <?PHP
  * $data = array();
  *	
  * $data['propertie'] = 'value';
  * $data['propertie'] = 'value';
  * ?>
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
  * complainDelete deletes the complaint about the client with ID tcldbid submitted by the client with ID fcldbid from the server
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
  * complainDeleteAll deletes all complaints about the client with database ID tcldbid from the server
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
  * complainList displays a list of complaints on the selected virtual server<br>
  * If "tcldbid" is specified, only complaints about the targeted client will be shown<br><br><br>
  *
  * <b>Output:</b><br>
  * <code>
  * Array
  * {
  *  [tcldbid] => 2
  *  [tname] => Par0noid
  *  [fcldbid] => 1
  *  [fname] => serveradmin
  *  [message] => insult
  *  [timestamp] => 1286591073
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string $tcldbid	targetClientDbId [optional]
  * @return     multidimensional-array complainList
  */
	function complainList($tcldbid = '') {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		if(!empty($tcldbid)) { $tcldbid = ' tcldbid='.$tcldbid; }
		return $this->getData('multi', 'complainlist'.$tcldbid);
	}

/**
  * execOwnCommand executes a command and returns data if you want<br><br><br>
  * 
  * <b>Mods:</b>
  * <ul>
  * 	<li><b>0:</b> execute -> return boolean</li>
  * 	<li><b>1:</b> execute -> return normal array</li>
  * 	<li><b>2:</b> execute -> return multidimensional array</li>
  * 	<li><b>3:</b> execute -> return plaintext serverquery)</li>
  * </ul>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string	$mode		execMode
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
  * ftCreateDir creates new directory in a channels file repository
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string	$cid		channelId
  * @param		string	$cpw		channelPassword (leave blank if not needed)
  * @param		string	$dirname	dirPath
  * @return     boolean success
  */
	function ftCreateDir($cid, $cpw = '', $dirname) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('boolean', 'ftcreatedir cid='.$cid.' cpw='.$this->escapeText($cpw).' dirname='.$this->escapeText($dirname));
	}

/**
  * ftDeleteFile deletes one or more files stored in a channels file repository<br><br><br>
  *
  * <b>Input-Array like this:</b><br>
  * <br><code>
  * <?PHP
  * $files = array();
  *	
  * $files[] = '/pic1.jpg';
  * $files[] = '/dokumente/test.txt';
  * $files[] = '/dokumente';
  * ?>
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		string	$cid	channelId
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
  * ftDownloadFile downloads a file and return its contents
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
  * ftGetFileInfo displays detailed information about one or more specified files stored in a channels file repository<br><br><br>
  *
  * <b>Input-Array like this:</b><br>
  * <br><code>
  * <?PHP
  * $files = array();
  *	
  * $files[] = '/pic1.jpg';
  * $files[] = '/dokumente/test.txt';
  * $files[] = '/dokumente';
  * ?>
  * </code><br><br><br>
  * 
  * <b>Output:</b><br>
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
  * @param		string	$cid	channelId
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
  * ftGetFileList displays a list of files and directories stored in the specified channels file repository<br><br><br>
  *
  * <b>Output:</b><br>
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
  * @param		string	$cid	channelId
  * @param		string	$cpw	channelPassword (leave blank if not needed)
  * @param		string	$path	filePath
  * @return     multidimensional-array	fileList
  */
	function ftGetFileList($cid, $cpw = '', $path) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('multi', 'ftgetfilelist cid='.$cid.' cpw='.$this->escapeText($cpw).' path='.$this->escapeText($path));
	}
	
/**
  * ftInitDownload initializes a file transfer download<br><br><br>
  *
  * <b>Output:</b><br>
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
  * @param		string	$filename	filePath
  * @param		string	$cid		channelId
  * @param		string	$cpw		channelPassword (leave blank if not needed)
  * @param		integer	$seekpos	seekpos (default = 0) [optional]
  * @return     array	initDownloadFileInfo
  */	
	function ftInitDownload($filename, $cid, $cpw = '', $seekpos = 0) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('array', 'ftinitdownload clientftfid='.rand(1,99).' name='.$this->escapeText($filename).' cid='.$cid.' cpw='.$this->escapeText($cpw).' seekpos='.$seekpos);
	}

/**
  * ftInitUpload initializes a file transfer upload<br><br><br>
  *
  * <b>Output:</b><br>
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
  * @param		string	$cid		channelId
  * @param		integer	$size		fileSize in byte
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
  * ftList displays a list of running file transfers on the selected virtual server<br>
  * The output contains the path to which a file is uploaded to, the current transfer rate in bytes per second, etc.<br><br><br>
  *
  * <b>Output:</b><br>
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
  * @return     multidimensional-array	fileTransferList
  */
	function ftList() {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('multi', 'ftlist');
	}

/**
  * ftRenameFile renames a file in a channels file repository
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer	$cid		channelId
  * @param		string	$cpw		channelPassword (leave blank if not needed)
  * @param		string	$oldname	oldFilePath
  * @param		string	$newname	newFilePath
  * @return     boolean success
  */
	function ftRenameFile($cid, $cpw = '', $oldname, $newname) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }

		return $this->getData('boolean', 'ftrenamefile cid='.$cid.' cpw='.$cpw.' oldname='.$this->escapeText($oldname).' newname='.$this->escapeText($newname));
	}

/**
  * ftStop stops the running file transfer with server-side ID serverftfid
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer	$sftid	serverFileTransferID
  * @param		boolean	$delete	delete incomplete file (default = true) [optional]
  * @return     boolean success
  */
	function ftStop($sftid, $delete = true) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		
		if($delete) { $delete = '1'; }else{ $delete = '0'; } 
		
		return $this->getData('boolean', 'ftstop serverftfid='.$sftid.' delete='.$delete);
	}

/**
  * ftUploadFile uploads a file to server<br><br><br>
  *
  * To check if upload was successful, you have to search for this file in fileList after
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		array	$data		return of ftInitUpload
  * @param		string	$uploadData	data which should be uploaded
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
  * gm sends a text message to all clients on all virtual servers in the TeamSpeak 3 Server instance
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
  * hostInfo returns all information about the connected host<br><br><br>
  *
  * <b>Output:</b><br>
  * <code>
  * Array
  * {
  *  [instance_uptime] => 571
  *  [host_timestamp_utc] => 1286631700
  *  [virtualservers_running_total] => 7
  *  [virtualservers_total_maxclients] => 481
  *  [virtualservers_total_clients_online] => 23
  *  [virtualservers_total_channels_online] => 126
  *  [connection_filetransfer_bandwidth_sent] => 0
  *  [connection_filetransfer_bandwidth_received] => 0
  *  [connection_packets_sent_total] => 149750
  *  [connection_bytes_sent_total] => 27297156
  *  [connection_packets_received_total] => 58848
  *  [connection_bytes_received_total] => 7457688
  *  [connection_bandwidth_sent_last_second_total] => 1886
  *  [connection_bandwidth_sent_last_minute_total] => 33270
  *  [connection_bandwidth_received_last_second_total] => 1932
  *  [connection_bandwidth_received_last_minute_total] => 9043
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
  * instanceEdit changes the server instance configuration using given properties<br><br><br>
  *
  * <b>Input-Array like this:</b><br>
  * <br><code>
  * <?PHP
  * $data = array();
  *	
  * $data['setting'] = 'value';
  * $data['setting'] = 'value';
  * ?>
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
			return $this->generateOutput(false, array('empty array entered'), false);
		}
	}

/**
  * instanceInfo returns all information about the teamspeak instance<br><br><br>
  *
  * <b>Output:</b><br>
  * <code>
  * Array
  * {
  *  [serverinstance_database_version] => 15
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
  *  [serverinstance_permissions_version] => 8
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
  * logAdd writes a custom entry into the servers log
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
  * login verifies your login data and grant additional access
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
  * logout deselects the selected virtual server and log out the user
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
  * logView displays a specified number of entries from the servers log<br><br><br>
  * 
  * <b>Output:</b><br>
  * <code>
  * Array
  * {
  *  [timestamp] => 1286147873
  *  [level] => 4
  *  [channel] => ServerParser
  *  [msg] => deleted VirtualServer(2)
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer	$limit	between 1 and 500
  * @param		string	$comparator	{<|>|=} [optional]
  * @param		string	$timestamp	YYYY-MM-DD\shh:mm:ss [optional]
  * @return     multidimensional-array logEntries
  */
	function logView($limit, $comparator = '', $timestamp = '') {
		if(!empty($comparator)) { $comparator = ' comparator='.$this->escapeText($comparator); }
		if(!empty($timestamp)) { $timestamp = ' timestamp='.$this->escapeText($timestamp); }
		if($limit >=1 and $limit <=500) {
			return $this->getData('multi', 'logview limitcount='.$limit.$comparator.$timestamp);
		}else{
			$this->addDebugLog('please choose a limit between 1 and 500');
			$this->generateOutput(false, array('Error: please choose a limit between 1 and 500'), false);
		}
	}

/**
  * permIdGetByName displays the database ID of one or more permissions specified by permsid<br><br><br>
  *
  * <b>Input-Array like this:</b><br>
  * <code>
  * <?PHP
  * $permissions = array();
  * $permissions[] = 'permissionName';
  * ?>
  * </code>
  *
  * <b>Output:</b><br>
  * <code>
  * Array
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
  * @return     multidimensional-array	permissionList 
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
  * permissionList displays a list of permissions available on the server instance including ID, name and description<br><br><br>
  *
  * <b>Output:</b><br>
  * <code>
  * Array
  * {
  *  [permid] => 4353
  *  [permname] => b_serverinstance_help_view
  *  [permdesc] => Retrieve information about ServerQuery commands
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @return     multidimensonal-array permissionList
  */
	function permissionList() {
		return $this->getData('multi', 'permissionlist');
	}

/**
  * permOverview Displays all permissions assigned to a client for the channel specified with cid<br>
  * If permid is set to 0, all permissions will be displayed. A permission can be specified by permid or permsid<br><br><br>
  *
  * <b>Output:</b><br>
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
  * @param		integer 	$permid		permId
  * @param		string	 	$permsid	permName
  * @return     multidimensonal-array permOverview
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
  * selectServer selects a server by port or serverId
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer	$value		clientIP
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
				$res = $this->getData('boolean', 'use sid='.$value);
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
  * sendMessage sends a text message a specified target
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
  * serverCreate creates a server on the selected instance<br><br><br>
  *
  * <b>Input-Array like this:</b><br>
  * <br><code>
  * <?PHP
  * $data = array();
  *	
  * $data['setting'] = 'value';
  * $data['setting'] = 'value';
  * ?>
  * </code><br><br><br>
  *
  * <b>Output:</b><br>
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
  * @param		array	$data	serverSettings
  * @return     array serverInfo
  */
	function serverCreate($data) {
		$settingsString = '';
		
		foreach($data as $key => $value) {
			if(!empty($value)) { $settingsString .= ' '.$key.'='.$this->escapeText($value); }
		}
		return $this->getData('array', 'servercreate'.$settingsString);
	}

/**
  * serverDelete deletes a server on the selected instance
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
  * serverEdit edits server settings on selected virtualserver<br><br><br>
  *
  * <b>Input-Array like this:</b><br>
  * <br><code>
  * <?PHP
  * $data = array();
  *	
  * $data['setting'] = 'value';
  * $data['setting'] = 'value';
  * ?>
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
  * serverGroupAdd creates a new server group using the name specified with name and displays its ID<br><br><br>
  *
  * <b>Output:</b><br>
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
  * serverGroupAddClient adds a client to the server group specified with sgid<br>
  *	Please note that a client cannot be added to default groups or template groups
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $sgid	serverGroupId
  * @param		integer $cldbid	clientDbId
  * @return     boolean success
  */
	function serverGroupAddClient($sgid, $cldbid) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('boolean', 'servergroupaddclient sgid='.$sgid.' cldbid='.$cldbid);
	}

/**
  * serverGroupAddPerm adds a set of specified permissions to the server group specified with sgid<br><br><br>
  *
  * <b>Input-Array like this:</b><br>
  * <code>
  * <?PHP
  * $permissions = array();
  * $permissions['permissionID'] = array('permissionValue', 'permskip', 'permnegated');
  * ?>
  * </code>
  * 
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $sgid	groupID
  * @param		multidimensional-array	$permissions	permissions
  * @return     boolean success
  */
	function serverGroupAddPerm($sgid, $permissions) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		
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
        }
	}

/**
  * serverGroupClientList displays the IDs of all clients currently residing in the server group specified with sgid<br>
  * If you're using the -names option, the output will also contain the last known nickname and the unique identifier of the clients<br><br><br>
  *
  * <b>Possible params:</b> -names<br><br><br>
  *
  * <b>Output: (with -names param)</b><br>
  * <code>
  * Array
  * {
  *  [cldbid] => 2017
  *  [client_nickname] => Par0noid
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
  * serverGroupCopy creates a copy of the server group specified with ssgid. If tsgid is set to 0, the server will create a new group. To overwrite an existing group, simply set tsgid to the ID of a designated target group. If a target group is set, the name parameter will be ignored.<br><br><br>
  *
  * <b>Output:</b><br>
  * <code>
  * Array
  * {
  *  [sgid] => 86
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer	$ssgid	sourceServerGroupId
  * @param		integer	$tsgid	targetServerGroupId 
  * @param		integer $name	groupName
  * @param		integer	$type	groupDbType (0 = template, 1 = normal, 2 = query | Default: 1)
  * @return     array groupId
  */
	function serverGroupCopy($ssgid, $tsgid, $name, $type = 1) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('array', 'servergroupcopy ssgid='.$ssgid.' tsgid='.$tsgid.' name='.$this->escapeText($name).' type='.$type);
	}

/**
  * serverGroupDelete Deletes the server group specified with sgid<br>
  *	If force is set to 1, the server group will be deleted even if there are clients within.
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $sgid	serverGroupID
  * @param		integer $force 	forces deleting group (default: 1)
  * @return     boolean success
  */
	function serverGroupDelete($sgid, $force = 1) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('boolean', 'servergroupdel sgid='.$sgid.' force='.$force);
	}

/**
  * serverGroupDeleteClient removes a client from the server group specified with sgid
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $sgid	groupID
  * @param		integer $cldbid	clientDbId
  * @return     boolean success
  */
	function serverGroupDeleteClient($sgid, $cldbid) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('boolean', 'servergroupdelclient sgid='.$sgid.' cldbid='.$cldbid);
	}

/**
  * serverGroupDeletePerm removes a set of specified permissions from the server group specified with sgid<br><br><br>
  *
  * <b>Input-Array like this:</b><br>
  * <code>
  * <?PHP
  * $permissions = array();
  * $permissions[] = 'permissionID';
  * ?>
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
				$permissionArray[] = 'permid='.$value;
			}
			return $this->getData('boolean', 'servergroupdelperm sgid='.$sgid.' '.implode('|', $permissionArray));
		}else{
			$this->addDebugLog('no permissions given');
			return $this->generateOutput(false, array('Error: no permissions given'), false);
		}
	}

/**
  * serverGroupList displays a list of server groups available<br>
  * Depending on your permissions, the output may also contain global ServerQuery groups and template groups.<br><br><br>
  *
  * <b>Output:</b><br>
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
  * @return     multidimensional-array serverGroupList
  */
	function serverGroupList() {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('multi', 'servergrouplist');
	}

/**
  * serverGroupPermList displays a list of permissions assigned to the server group specified with sgid<br><br><br>
  *
  * <b>Output:</b><br>
  * <code>
  * Array
  * {
  *  [permid] => 8470
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
  * @return     multidimensional-array serverGroupPermList
  */
	function serverGroupPermList($sgid, $permsid = false) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		if($permsid) { $additional = ' -permsid'; }else{ $additional = ''; }
		return $this->getData('multi', 'servergrouppermlist sgid='.$sgid.$additional);
	}

/**
  * serverGroupRename changes the name of the server group specified with sgid
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
  * serverGroupsByClientID displays all server groups the client specified with cldbid is currently residing in<br><br><br>
  *
  * <b>Output:</b><br>
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
  * @param		integer	$cldbid	clientDbId
  * @return     multidimensional-array serverGroupsByClientId
  */
	function serverGroupsByClientID($cldbid) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('multi', 'servergroupsbyclientid cldbid='.$cldbid);
	}

/**
  * serverIdGetByPort displays the database ID of the virtual server running on the UDP port specified by virtualserver_port<br><br><br>
  * 
  * <b>Output:</b><br>
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
  * serverInfo returns all information about the selected virtual server<br><br><br>
  *	
  * <b>Output:</b><br>
  * <code>
  * Array
  * {
  *  [virtualserver_unique_identifier] => 2T3SRCPoWKojKlNMx6qxV7gOe8A=
  *  [virtualserver_name] => testii
  *  [virtualserver_welcomemessage] => Welcome to TeamSpeak, check [URL]www.teamspeak.com[/URL] for latest infos.
  *  [virtualserver_platform] => Linux
  *  [virtualserver_version] => 3.0.0-beta29 [Build: 12473]
  *  [virtualserver_maxclients] => 32
  *  [virtualserver_password] => 
  *  [virtualserver_clientsonline] => 2
  *  [virtualserver_channelsonline] => 1
  *  [virtualserver_created] => 1286622661
  *  [virtualserver_uptime] => 2503
  *  [virtualserver_codec_encryption_mode] => 0
  *  [virtualserver_hostmessage] => 
  *  [virtualserver_hostmessage_mode] => 0
  *  [virtualserver_filebase] => files/virtualserver_11
  *  [virtualserver_default_server_group] => 73
  *  [virtualserver_default_channel_group] => 49
  *  [virtualserver_flag_password] => 0
  *  [virtualserver_default_channel_admin_group] => 46
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
  *  [virtualserver_id] => 11
  *  [virtualserver_antiflood_points_tick_reduce] => 5
  *  [virtualserver_antiflood_points_needed_warning] => 150
  *  [virtualserver_antiflood_points_needed_kick] => 250
  *  [virtualserver_antiflood_points_needed_ban] => 350
  *  [virtualserver_antiflood_ban_time] => 300
  *  [virtualserver_client_connections] => 1
  *  [virtualserver_query_client_connections] => 11
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
  *  [virtualserver_port] => 44413
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
  *  [virtualserver_total_ping] => 30.0000
  *  [virtualserver_ip] => 
  *  [virtualserver_weblist_enabled] => 1
  *  [virtualserver_status] => online
  *  [connection_filetransfer_bandwidth_sent] => 0
  *  [connection_filetransfer_bandwidth_received] => 0
  *  [connection_packets_sent_total] => 5160
  *  [connection_bytes_sent_total] => 291275
  *  [connection_packets_received_total] => 5147
  *  [connection_bytes_received_total] => 217247
  *  [connection_bandwidth_sent_last_second_total] => 81
  *  [connection_bandwidth_sent_last_minute_total] => 81
  *  [connection_bandwidth_received_last_second_total] => 83
  *  [connection_bandwidth_received_last_minute_total] => 83
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
  * serverList: returns all server data from selected instance<br><br><br>
  *
  * <b>Possible params:</b> [-uid] [-short] [-all]<br><br><br>
  *
  * <b>Output:</b><br>
  * <code>
  * Array
  * {
  *  [virtualserver_id] => 1
  *  [virtualserver_port] => 9987
  *  [virtualserver_status] => online
  *  [virtualserver_clientsonline] => 2
  *  [virtualserver_queryclientsonline] => 0
  *  [virtualserver_maxclients] => 100
  *  [virtualserver_uptime] => 28342
  *  [virtualserver_name] => DSO-Gaming Teamspeak
  *  [virtualserver_autostart] => 1
  *  [virtualserver_machine_id] => 
  * }
  * </code>
  *
  * @author     Par0noid Solutions
  * @access		public
  * @return     multidimensional-array serverList
  */
	function serverList($params = "") {
		if(!empty($params)) { $params = ' '.$params; }
		return $this->getData('multi', 'serverlist'.$params);
	}

/**
  * serverProcessStop stops the entire TeamSpeak 3 Server instance by shutting down the process
  *
  * @author     Par0noid Solutions
  * @access		public
  * @return     boolean success
  */
	function serverProcessStop() {
		return $this->getData('boolean', 'serverprocessstop');
	}

/**
  * serverRequestConnectionInfo displays detailed connection information about the selected virtual server<br><br><br>
  *
  * <b>Output:</b><br>
  * <code>
  * Array
  * {
  *  [connection_filetransfer_bandwidth_sent] => 0
  *  [connection_filetransfer_bandwidth_received] => 0
  *  [connection_packets_sent_total] => 5886
  *  [connection_bytes_sent_total] => 323662
  *  [connection_packets_received_total] => 5873
  *  [connection_bytes_received_total] => 247881
  *  [connection_bandwidth_sent_last_second_total] => 82
  *  [connection_bandwidth_sent_last_minute_total] => 100
  *  [connection_bandwidth_received_last_second_total] => 84
  *  [connection_bandwidth_received_last_minute_total] => 89
  *  [connection_connected_time] => 2857
  *  [connection_packetloss_total] => 0.0000
  *  [connection_ping] => 32.0000
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
  * serverSnapshotCreate starts a server on the selected instance
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
  * serverSnapshotDeploy restores the selected virtual servers configuration<br>
  * using the data from a previously created server snapshot.<br>
  * Please note that the TeamSpeak 3 Server does NOT check for necessary permissions while deploying a snapshot<br>
  * so the command could be abused to gain additional privileges
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
  * serverStart starts a server on the selected instance
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
  * serverStop stops a server on the selected instance
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
  * setclientchannelgroup sets the channel group of a client to the ID specified with cgid
  *
  * @author     Par0noid Solutions
  * @access		public
  * @param		integer $cid	channelID
  * @param		integer $clid	clientID
  * @param		integer $cgid	groupID
  * @return     boolean success
  */
	function setClientChannelGroup($cgid, $cid, $cldbid) {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }
		return $this->getData('boolean', 'setclientchannelgroup cgid='.$cgid.' cid='.$cid.' cldbid='.$cldbid);
	}

/**
  * setName sets your nickname in server query
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
  * tokenAdd creates a new token. If tokentype is set to 0, the ID specified with tokenid1 will be a server group ID<br>
  * Otherwise, tokenid1 is used as a channel group ID and you need to provide a valid channel ID using tokenid2
  *
  * <b>Input-Array like this:</b><br>
  * <br><code>
  * <?PHP
  * $customFieldSet = array();
  *	
  * $customFieldSet['ident'] = 'value';
  * $customFieldSet['ident'] = 'value';
  * ?>
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
		
			foreach($data as $key => $value) {
				$settingsString[] = 'ident='.$this->escapeText($key).' value='.$this->escapeText($value);
			}
			$customFieldSet = ' '.implode('|', $settingsString);
		}else{
			$customFieldSet = '';
		}
		
		return $this->getData('array', 'privilegekeyadd tokentype='.$tokentype.' tokenid1='.$tokenid1.' tokenid2='.$tokenid2.$description.$customFieldSet);
	}

/**
  * tokenDelete deletes an existing token matching the token key specified with token
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
  * tokenList displays a list of tokens available including their type and group IDs<br><br><br>
  *
  * <b>Output:</b><br>
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
  * @return     multidimensional-array tokenListist 
  */
	function tokenList() {
		if(!$this->runtime['selected']) { return $this->checkSelected(); }

		return $this->getData('multi', 'privilegekeylist');
	}

/**
  * tokenUse uses a token key gain access to a server or channel group<br>
  * Please note that the server will automatically delete the token after it has been used
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
  * version displays the servers version information including platform and build number<br><br><br>
  *
  * <b>Output:</b><br>
  * <code>
  * Array
  * {
  *  [version] => 3.0.0-beta29
  *  [build] => 12473
  *  [platform] => Linux
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
  * whoAmI returns informations about you<br><br><br>
  *
  * <b>Output:</b><br>
  * <code>
  * Array
  * {
  *  [virtualserver_status] => online
  *  [virtualserver_id] => 1
  *  [virtualserver_unique_identifier] => 4L0HyB3rUZ1EsU43QaB+XFEs30o=
  *  [virtualserver_port] => 9987
  *  [client_id] => 7
  *  [client_channel_id] => 1
  *  [client_nickname] => serveradmin from 89.147.30.25:52914
  *  [client_database_id] => 1
  *  [client_login_name] => serveradmin
  *  [client_unique_identifier] => serveradmin
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
  * convertSecondsToStrTime converts seconds to a strTime (bsp. 5d 1h 23m 19s)
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
  * convertSecondsToArrayTime converts seconds to a array: time<br><br><br>
  *
  * <b>Output:</b><br>
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
  * getElement returns a special element from array<br><br>
  * 
  * This can be used to get a result in a one line operation<br><br>
  * 
  * Example, you got this array:
  * <code>
  * Array
  * {
  *  [success] => false
  *  [errors] => Array 
  *  [data] => false
  * }
  * </code><br><br><br>
  * 
  * Now you can grab the element like this:<br>
  * <code>
  * <?PHP
  * $ts = new ts3admin('***', '***');
  * 
  * if($ts->getElement('success', $ts->connect())) {
  *  //operation
  * }
  * ?>
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

//*******************************************************************************************	
//*********************************** Internal Functions ************************************
//*******************************************************************************************

/**
 * @author	Par0noid Solutions
 * @access	private
 * @param	string	$host		ts3host
 * @param	integer	$queryport	ts3queryport
 * @param	integer	$timeout	socket timeout (default = 2) [optional]
 * @return	none
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
 * @author	Par0noid Solutions
 * @access	private
 * @return	none
*/
	function __destruct() {
		$this->quit();
	}

/**
 * __call prevents your website from php errors if you want to execute
 * a method which doesn't exists
 * 
 * @author	Par0noid Solutions
 * @access	private
 * @param	string	$name	method name
 * @param	array	$args	method arguments
 * @return	none
*/
	function __call($name, $args) {
		$this->addDebugLog('Method '.$name.' doesn\'t exist', $name, 0);
		return $this->generateOutput(false, array('Method '.$name.' doesn\'t exist'), false);
	}

/**
  * isConnected checks if the connection is established
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
  * generateOutput builds a method return as array
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
  * unEscapeText turns escaped chars to normals
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
  * escapeText escapes chars that we can use it in the query
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
  * splitBanIds splits banIds to array
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
  * connect connects to ts3instance
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
  * executeCommand executes a command and fetches the response
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
 * parse data from query and returns an array
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
 * ftSendKey sends down/upload-key to ftHost
 * 
  * @author     Par0noid Solutions
  * @access		private
  * @return     none
 */
	private function ftSendKey($key, $additional = "") {
		fputs($this->runtime['fileSocket'], $key.$additional);
	}

/**
 * ftSendData sends data to ftHost
 * 
  * @author     Par0noid Solutions
  * @access		private
  * @return     none
 */
	private function ftSendData($data) {
		$data = str_split($data, 4096);
		foreach($data as $dat) {
			fputs($this->runtime['fileSocket'], $dat);
		}
	}

/**
 * ftRead reads data from ftHost
 * 
  * @author     Par0noid Solutions
  * @access		private
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
  * getDebugLog returns the debug log<br><br><br>
  *
  * <b>Output:</b><br>
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
  * addDebugLog adds an entry to debugLog
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
?>