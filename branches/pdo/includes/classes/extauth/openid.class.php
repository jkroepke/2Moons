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

require 'includes/libs/OpenID/openid.php';

class OpenIDAuth implements externalAuth
{
	private $oidObj	= NULL;

	public function __construct()
	{
		$this->oidObj	= new LightOpenID(PROTOCOL.HTTP_HOST);
		if(!$this->oidObj->mode)
		{
			if(isset($_REQUEST['openid_identifier']))
			{
				$this->oidObj->identity = $_REQUEST['openid_identifier'];
				$this->oidObj->required = array('contact/email');
				$this->oidObj->optional = array('namePerson', 'namePerson/friendly');

				HTTP::sendHeader('Location', $this->oidObj->authUrl());
				exit;
			} else {
				HTTP::redirectTo('index.php?code=4');
			}
		}
	}

	public function isActiveMode()
	{
		return false;
	}

	public function isValid()
	{
		return $this->oidObj->mode && $this->oidObj->mode != 'cancel';
	}

	public function getAccount()
	{
		$user	= $this->oidObj->getAttributes();
		
		if(!empty($user['contact/email']))
		{
			return $user['contact/email'];
		}
		
		if(!empty($user['namePerson/friendly']))
		{
			return $user['namePerson/friendly'];
		}
		
		if(!empty($user['namePerson']))
		{
			return $user['namePerson'];
		}		
		
		HTTP::redirectTo('index.php?code=4');

		return false;
	}
	
	public function register()
	{
		$uid	= $this->getAccount();
		$user	= $this->oidObj->getAttributes();
		
		if(empty($user['contact/email']))
		{
			HTTP::redirectTo('index.php?code=4');
		}

		$sql	= 'SELECT cle FROM %%USERS_VALID%% WHERE universe = :universe AND email = :email;';

		$registerToken	= Database::get()->selectSingle($sql, array(
			':universe'	=> Universe::current(),
			':email'	=> $user['contact/email']
		), 'cle');

		if(!empty($registerToken))
		{
			HTTP::redirectTo(sprintf('index.php?uni=%d&page=reg&action=valid&clef=%s', Universe::current(), $registerToken));
		}

		$sql	= 'INSERT INTO %%USERS_AUTH%% SET
		id = (SELECT id FROM %%USERS%% WHERE email = :email OR email_2 = :email),
		account = :accountId
		mode = :mode;';

		Database::get()->insert($sql, array(
			':email'		=> $user['contact/email'],
			':accountId'	=> $uid,
			':mode'			=> $this->oidObj->identity,
		));
	}

	public function getLoginData()
	{
		$user	= $this->oidObj->getAttributes();

		$sql	= 'SELECT
		user.id, user.username, user.dpath, user.authlevel, user.id_planet
		FROM %%USERS_AUTH%%
		INNER JOIN %%USERS%% user ON auth.id = user.id AND user.universe = :universe
		WHERE auth.account = :email AND mode = :mode;';
		
		return Database::get()->select($sql, array(
			':universe'	=> Universe::current(),
			':email'	=> $user['contact/email'],
			':mode'		=> $this->oidObj->identity
		));
	}
}