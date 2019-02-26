<?php

/**
 *  SteemNova
 *   by mys 2018
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package Steemnova
 * @author mys <miccelinski@gmail.com>
 * @licence MIT
 */

class ShowSteemconnectPage extends AbstractLoginPage
{
	public static $requireModule = 0;

	function __construct() 
	{
		parent::__construct();
	}
	
	function show() 
	{
		$session	= Session::create();

		require 'includes/classes/extauth/externalAuth.interface.php';
		require 'includes/classes/extauth/steemconnect.class.php';
		
		$methodClass	= 'SteemconnectAuth';

		/** @var $authObj externalAuth */
		$authObj		= new $methodClass;
		
		if(!$authObj->isActiveMode())
		{
			$session->delete();
			$this->redirectTo('index.php?code=5');
		}
		
		if(!$authObj->isValid())
		{
			$session->delete();
			$this->redirectTo('index.php?code=4');
		}
		
		$loginData	= $authObj->getLoginData();
		
		if(empty($loginData))
		{
			// create account
			// $session->delete();
			$authObj->register();
			$loginData = $authObj->getLoginData();
		}

		$session->userId		= (int) $loginData['id'];
		$session->adminAccess	= 0;
		$session->data			= $authObj->getAccountData();
		$session->save();
		$this->redirectTo("game.php");	
	}
}
