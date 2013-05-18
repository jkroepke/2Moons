<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan
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
 * @author Jan <info@2moons.cc>
 * @copyright 2006 Perberos <ugamela@perberos.com.ar> (UGamela)
 * @copyright 2008 Chlorel (XNova)
 * @copyright 2012 Jan <info@2moons.cc> (2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 2.0.$Revision: 2242 $ (2012-11-31)
 * @info $Id$
 * @link http://2moons.cc/
 */

class ShowExternalAuthPage extends AbstractPage
{
	public static $requireModule = 0;

	function __construct() 
	{
		parent::__construct();
	}
	
	function show() 
	{
		$method			= HTTP::_GP('method', '');
		$method			= strtolower(str_replace(array('_', '\\', '/', '.', "\0"), '', $method));
		$path			= 'includes/classes/extauth/'.$method.'.class.php';
		
		if(!file_exists($path)) {
			HTTP::redirectTo('index.php');			
		}

		$session	= Session::create();

		require 'includes/classes/extauth/externalAuth.interface.php';
		require $path;
		
		$methodClass	= ucwords($method).'Auth';

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
			$session->delete();
			$this->redirectTo('index.php?page=register&externalAuth[account]='.$authObj->getAccount().'&externalAuth[method]=facebook');
		}

		$session->userId		= (int) $loginData['id'];
		$session->adminAccess	= 0;
		$session->save();
		$this->redirectTo("game.php");	
	}
}