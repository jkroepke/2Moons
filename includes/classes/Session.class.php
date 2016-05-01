<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan <info@2moons.cc>
 * @copyright 2006 Perberos <ugamela@perberos.com.ar> (UGamela)
 * @copyright 2008 Chlorel (XNova)
 * @copyright 2012 Jan <info@2moons.cc> (2Moons)
 * @licence MIT
 * @version 2.0 (2012-11-31)
 * @info $Id$
 * @link http://2moons.cc/
 */

class Session
{
	static private $obj = NULL;
	static private $iniSet	= false;
	private $data = NULL;

	/**
	 * Set PHP session settings
	 *
	 * @return bool
	 */

	static public function init()
	{
		if(self::$iniSet === true)
		{
			return false;
		}
		self::$iniSet = true;

		ini_set('session.use_cookies', '1');
		ini_set('session.use_only_cookies', '1');
		ini_set('session.use_trans_sid', 0);
		ini_set('session.auto_start', '0');
		ini_set('session.serialize_handler', 'php');  
		ini_set('session.gc_maxlifetime', SESSION_LIFETIME);
		ini_set('session.gc_probability', '1');
		ini_set('session.gc_divisor', '1000');
		ini_set('session.bug_compat_warn', '0');
		ini_set('session.bug_compat_42', '0');
		ini_set('session.cookie_httponly', true);
		ini_set('session.save_path', CACHE_PATH.'sessions');
		ini_set('upload_tmp_dir', CACHE_PATH.'sessions');
		
		$HTTP_ROOT = MODE === 'INSTALL' ? dirname(HTTP_ROOT) : HTTP_ROOT;
		
		session_set_cookie_params(SESSION_LIFETIME, $HTTP_ROOT, NULL, HTTPS, true);
		session_cache_limiter('nocache');
		session_name('2Moons');

		return true;
	}

	static private function getTempPath()
	{
		require_once 'includes/libs/wcf/BasicFileUtil.class.php';
		return BasicFileUtil::getTempFolder();
	}


	/**
	 * Create an empty session
	 *
	 * @return String
	 */

	static public function getClientIp()
    {
		if(!empty($_SERVER['HTTP_CLIENT_IP']))
        {
            $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
        }
		elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
			$ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        elseif(!empty($_SERVER['HTTP_X_FORWARDED']))
        {
			$ipAddress = $_SERVER['HTTP_X_FORWARDED'];
        }
        elseif(!empty($_SERVER['HTTP_FORWARDED_FOR']))
        {
			$ipAddress = $_SERVER['HTTP_FORWARDED_FOR'];
        }
        elseif(!empty($_SERVER['HTTP_FORWARDED']))
        {
			$ipAddress = $_SERVER['HTTP_FORWARDED'];
        }
        elseif(!empty($_SERVER['REMOTE_ADDR']))
        {
			$ipAddress = $_SERVER['REMOTE_ADDR'];
        }
        else
        {
			$ipAddress = 'UNKNOWN';
        }
        return $ipAddress;
	}

	/**
	 * Create an empty session
	 *
	 * @return Session
	 */

	static public function create()
	{
		if(!self::existsActiveSession())
		{
			self::$obj	= new self;
			register_shutdown_function(array(self::$obj, 'save'));

			@session_start();
		}

		return self::$obj;
	}

	/**
	 * Wake an active session
	 *
	 * @return Session
	 */

	static public function load()
	{
		if(!self::existsActiveSession())
		{
			self::init();
			session_start();
			if(isset($_SESSION['obj']))
			{
				self::$obj	= unserialize($_SESSION['obj']);
				register_shutdown_function(array(self::$obj, 'save'));
			}
			else
			{
				self::create();
			}
		}

		return self::$obj;
	}

	/**
	 * Check if an active session exists
	 *
	 * @return bool
	 */

	static public function existsActiveSession()
	{
		return isset(self::$obj);
	}

	public function __construct()
	{
		self::init();
	}

	public function __sleep()
	{
		return array('data');
	}

	public function __wakeup()
	{

	}

	public function __set($name, $value)
	{
		$this->data[$name]	= $value;
	}

	public function __get($name)
	{
		if(isset($this->data[$name]))
		{
			return $this->data[$name];
		}
		else
		{
			return NULL;
		}
	}

	public function __isset($name)
	{
		return isset($this->data[$name]);
	}

	public function save()
	{
	    // do not save an empty session
	    $sessionId = session_id();

	    if(empty($sessionId)) {
	        return;
	    }

	    // sessions require an valid user.
	    if(empty($this->data['userId'])) {
	        $this->delete();
	        return;
	    }

        $userIpAddress = self::getClientIp();

		$sql	= 'REPLACE INTO %%SESSION%% SET
		sessionID	= :sessionId,
		userID		= :userId,
		lastonline	= :lastActivity,
		userIP		= :userAddress;';

		$db		= Database::get();

		$db->replace($sql, array(
			':sessionId'	=> $sessionId,
			':userId'		=> $this->data['userId'],
			':lastActivity'	=> TIMESTAMP,
			':userAddress'	=> $userIpAddress,
		));

		$sql = 'UPDATE %%USERS%% SET
		onlinetime	= :lastActivity,
		user_lastip = :userAddress
		WHERE
		id = :userId;';

		$db->update($sql, array(
		   ':userAddress'	=> $userIpAddress,
		   ':lastActivity'	=> TIMESTAMP,
		   ':userId'		=> $this->data['userId'],
		));

		$this->data['lastActivity']  = TIMESTAMP;
		$this->data['sessionId']	 = session_id();
		$this->data['userIpAddress'] = $userIpAddress;
		$this->data['requestPath']	 = $this->getRequestPath();

		$_SESSION['obj']	= serialize($this);

		@session_write_close();
	}

	public function delete()
	{
		$sql	= 'DELETE FROM %%SESSION%% WHERE sessionID = :sessionId;';
		$db		= Database::get();

		$db->delete($sql, array(
			':sessionId'	=> session_id(),
		));

		@session_destroy();
	}

	public function isValidSession()
	{
		if($this->compareIpAddress($this->data['userIpAddress'], self::getClientIp(), COMPARE_IP_BLOCKS) === false)
		{
			return false;
		}

		if($this->data['lastActivity'] < TIMESTAMP - SESSION_LIFETIME)
		{
			return false;
		}

		$sql = 'SELECT COUNT(*) as record FROM %%SESSION%% WHERE sessionID = :sessionId;';
		$db		= Database::get();

		$sessionCount = $db->selectSingle($sql, array(
			':sessionId'	=> session_id(),
		), 'record');

		if($sessionCount == 0)
		{
			return false;
		}

		return true;
	}

	public function selectActivePlanet()
	{
		$httpData	= HTTP::_GP('cp', 0);

		if(!empty($httpData))
		{
			$sql	= 'SELECT id FROM %%PLANETS%% WHERE id = :planetId AND id_owner = :userId;';

			$db	= Database::get();
			$planetId	= $db->selectSingle($sql, array(
				':userId'	=> $this->data['userId'],
				':planetId'	=> $httpData,
			), 'id');

			if(!empty($planetId))
			{
				$this->data['planetId']	= $planetId;
			}
		}
	}

	private function getRequestPath()
	{
		return HTTP_ROOT.(!empty($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : '');
	}
	
	private function compareIpAddress($ip1, $ip2, $blockCount)
	{
		if (strpos($ip2, ':') !== false && strpos($ip1, ':') !== false)
		{
			$s_ip = $this->short_ipv6($ip1, $blockCount);
			$u_ip = $this->short_ipv6($ip2, $blockCount);
		}
		else
		{
			$s_ip = implode('.', array_slice(explode('.', $ip1), 0, $blockCount));
			$u_ip = implode('.', array_slice(explode('.', $ip2), 0, $blockCount));
		}
		
		return ($s_ip == $u_ip);
	}

	private function short_ipv6($ip, $length)
	{
		if ($length < 1)
		{
			return '';
		}

		$blocks = substr_count($ip, ':') + 1;
		if ($blocks < 9)
		{
			$ip = str_replace('::', ':' . str_repeat('0000:', 9 - $blocks), $ip);
		}
		if ($ip[0] == ':')
		{
			$ip = '0000' . $ip;
		}
		if ($length < 4)
		{
			$ip = implode(':', array_slice(explode(':', $ip), 0, 1 + $length));
		}

		return $ip;
	}
}