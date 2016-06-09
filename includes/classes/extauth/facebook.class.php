<?php

/**
 *  2Moons 
 *   by Jan-Otto Kröpke 2009-2016
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan-Otto Kröpke <slaver7@gmail.com>
 * @copyright 2009 Lucky
 * @copyright 2016 Jan-Otto Kröpke <slaver7@gmail.com>
 * @licence MIT
 * @version 1.8.0
 * @link https://github.com/jkroepke/2Moons
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
			'scope'			=> 'public_profile,email',
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

		$sql	= 'SELECT user.id, id_planet
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