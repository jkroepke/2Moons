<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package 2Moons
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.2 (2013-03-18)
 * @info $Id$
 * @link http://2moons.cc/
 */

require 'includes/libs/facebook/facebook.php';

class FacebookAuth implements externalAuth
{
	private $fbObj = NULL;

	public function __construct()
	{	
		if($this->isActiveMode())
		{
			$this->fbObj	= new Facebook(array(
				'appId'  => Config::get()->fb_apikey,
				'secret' => Config::get()->fb_skey,
				'cookie' => true,
			));
		}
	}

	public function isActiveMode()
	{
		return Config::get()->fb_on == 1;
	}

	public function isValid()
	{
		if($this->getAccount() != 0)
		{
			return $this->getAccount();
		}
		
		if(!empty($_GET['error_reason']))
		{
			HTTP::redirectTo('index.php');
		}
		
		HTTP::sendHeader('Location', $this->fbObj->getLoginUrl(array(
			'scope'			=> 'publish_stream,publish_actions,user_games_activity',
			'redirect_uri'	=> HTTP_PATH.'index.php?page=externalAuth&method=facebook'
		)));
		exit;
	}

	public function getAccount()
	{
		return $this->fbObj->getUser();
	}

	public function register()
	{
		$uid	= $this->getAccount();
		
		$me		= $this->fbObj->api('/me');

		$sql	= 'SELECT validationID, validationKey FROM %%USERS_VALID%%
		WHERE universe = :universe AND email = :email;';

		$registerData	= Database::get()->selectSingle($sql, array(
			':universe'	=> Universe::current(),
			':email'	=> $me['email']
		));

		if(!empty($registerData))
		{
			$url	= sprintf('index.php?uni=%s&page=reg&action=valid&i=%s&validationKey=%s',
				Universe::current(), $registerData['validationID'], $registerData['validationKey']);

			HTTP::redirectTo($url);
		}

		$sql	= 'INSERT INTO %%USERS_AUTH." SET
		id = (SELECT id FROM %%USERS%% WHERE email = :email OR email_2 = :email),
		account = :accountId
		mode = :mode;';

		Database::get()->insert($sql, array(
			':email'		=> $me['email'],
			':accountId'	=> $uid,
			':mode'			=> 'facebook',
		));
	}

	public function getLoginData()
	{
		$uid	= $this->getAccount();

		$sql	= 'SELECT
		user.id, id_planet
		FROM %%USERS_AUTH%% auth
		INNER JOIN %%USERS%% user ON auth.id = user.id AND user.universe = :universe
		WHERE auth.account = :accountId AND mode = :mode;';

		return Database::get()->selectSingle($sql, array(
			':mode'			=> 'facebook',
			':accountId'	=> $uid,
			':universe'		=> Universe::current()
		));
	}

	public function getAccountData()
	{
		$data	= $this->fbObj->api('/me', array('access_token' => $this->fbObj->getAccessToken()));
		
		return array(
			'id'		=> $data['id'],
			'name'		=> $data['name'],
			'locale'	=> $data['locale']
		);
	}
}