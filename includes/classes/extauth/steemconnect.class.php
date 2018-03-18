<?php

/**
 *  SteemNova
 *   by @steemnova 2018
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package SteemNova
 * @author @mys <miccelinski@gmail.com>
 * @copyright 2017 @mys <miccelinski@gmail.com>
 * @licence MIT
 * @version 1.8.0
 * @link https://github.com/steemnova/steemnova
 */

require 'includes/libs/steemconnect/steemconnect.php';

class SteemconnectAuth implements externalAuth
{
	private $scObj = NULL;
	
	public function __construct()
	{
		if($this->isActiveMode())
		{
			if (isset($_REQUEST['access_token']) and isset($_REQUEST['expires_in'])) {	
				$this->scObj = new Steemconnect(array(
					'access_token'	=> $_REQUEST['access_token'],
					'expires_in'	=> $_REQUEST['expires_in']
				));
			}
		}
	}
	
	public function isActiveMode()
	{
		return TRUE; //Config::get()->steemconnect_on == 1;
	}
	
	public function isValid()
	{
		if($this->getAccount() != false)
		{
			return $this->getAccount();
		}
		
		error_log('SteemconnectAuth.isValid() not valid');
		HTTP::redirectTo('index.php');
		exit;
	}
	
	public function getAccount()
	{
		return $this->scObj->getUser();
	}
	
	public function register()
	{
		global $LNG;
		
		list($userId, $planetId) = PlayerUtil::createPlayer(
			Universe::current(),
			$this->scObj->getUser(),
			'',
			'',
			$LNG->getLanguage());
		
		return $userId;
	}
	
	public function getLoginData()
	{
		$username = $this->getAccount();
		
		$sql = 'SELECT id, username, id_planet
		FROM %%USERS%%
		WHERE username = :username and universe = :universe;';
		
		return Database::get()->selectSingle($sql, array(
			':username'		=> $username,
			':universe'	=> Universe::current()
		));
	}
	
	public function getAccountData()
	{
		return $this->scObj->getData();
	}
}