<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package   2Moons
 * @author    Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @license   http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version   1.7.2 (2013-03-18)
 * @info $Id$
 * @link      http://2moons.cc/
 */
class Config
{
	protected $configData = array();
	protected $updateRecords = array();
	protected static $instances = array();


	// Global configkeys
	protected static $globalConfigKeys	= array('VERSION', 'game_name', 'stat', 'stat_level', 'stat_last_update',
										   'stat_settings', 'stat_update_time', 'stat_last_db_update', 'stats_fly_lock',
										   'cron_lock', 'ts_modon', 'ts_server', 'ts_tcpport', 'ts_udpport', 'ts_timeout',
										   'ts_version', 'ts_cron_last', 'ts_cron_interval', 'ts_login', 'ts_password',
										   'capaktiv', 'cappublic', 'capprivate', 'mail_active', 'mail_use', 'smtp_host',
										   'smtp_port', 'smtp_user', 'smtp_pass', 'smtp_ssl', 'smtp_sendmail',
										   'smail_path', 'fb_on', 'fb_apikey', 'fb_skey', 'ga_active', 'ga_key',
										   'chat_closed', 'chat_allowchan', 'chat_allowmes', 'chat_allowdelmes',
										   'chat_logmessage', 'chat_nickchange', 'chat_botname', 'chat_channelname',
										   'chat_socket_active', 'chat_socket_host', 'chat_socket_ip', 'chat_socket_port',
										   'chat_socket_chatid', 'ttf_file', 'sendmail_inactive', 'del_user_sendmail',
										   'del_user_automatic', 'del_oldstuff', 'del_user_manually', 'ref_max_referals',
										   'disclamerAddress','disclamerPhone','disclamerMail','disclamerNotice');

	public static function getGlobalConfigKeys()
	{
		return self::$globalConfigKeys;
	}

	/**
	 * Return an config object for the requested universe
	 *
	 * @param int $universe Universe ID
	 *
	 * @return Config
	 */

	static public function get($universe = 0)
	{
		if (empty(self::$instances)) {
			self::generateInstances();
		}

		if($universe === 0)
		{
			$universe = Universe::current();
		}

		if(!isset(self::$instances[$universe]))
		{
			throw new Exception("Unknown universe id: ".$universe);
		}

		return self::$instances[$universe];
	}

	static public function reload()
	{
		self::generateInstances();
	}

	static private function generateInstances()
	{
		$db     = Database::get();
		$configResult = $db->nativeQuery("SELECT * FROM %%CONFIG%%;");
		foreach ($configResult as $configRow)
		{
			self::$instances[$configRow['uni']] = new self($configRow);
			Universe::add($configRow['uni']);
		}
	}

	public function __construct($configData)
	{
		$this->configData = $configData;
	}

	public function __get($key)
	{
		if (!isset($this->configData[$key])) {
			throw new UnexpectedValueException(sprintf("Unknown configuration key %s!", $key));
		}

		return $this->configData[$key];
	}

	public function __set($key, $value)
	{
		if (!isset($this->configData[$key])) {
			throw new UnexpectedValueException(sprintf("Unknown configuration key %s!", $key));
		}
		$this->updateRecords[]  = $key;
		$this->configData[$key] = $value;
	}

	public function __isset($key)
	{
		return isset($this->configData[$key]);
	}

	public function save($options = NULL)
	{
		if (empty($this->updateRecords)) {
			// Do nothing here.
			return true;
		}
		
		if(is_null($options))
		{
			$options	= array();
		}
		
		$options	+= array(
			'noGlobalSave' => false
		);
		
		$updateData = array();
		$params     = array();
		foreach ($this->updateRecords as $columnName) {
			$updateData[]             = '`' . $columnName . '` = :' . $columnName;
			$params[':' . $columnName] = $this->configData[$columnName];

			//TODO: find a better way ...
			if(!$options['noGlobalSave'] && in_array($columnName, self::$globalConfigKeys))
			{
				foreach(Universe::availableUniverses() as $universeId)
				{
					if($universeId != $this->configData['uni'])
					{
						$config = Config::get();
						$config->$columnName = $this->configData[$columnName];
						$config->save(array('noGlobalSave' => true));
					}
				}
			}
		}

		$sql = 'UPDATE %%CONFIG%% SET '.implode(', ', $updateData).' WHERE `UNI` = :universe';
		$params[':universe'] = $this->configData['uni'];
		$db     = Database::get();
		$db->update($sql, $params);
		
		$this->updateRecords = array();
		return true;
	}

	static function getAll()
	{
		throw new Exception("Config::getAll is deprecated!");
	}
}
