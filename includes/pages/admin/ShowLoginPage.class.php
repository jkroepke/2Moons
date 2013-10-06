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
 * @version 1.8.0 (2013-03-18)
 * @info $Id: ShowLoginPage.php 2776 2013-08-05 21:30:40Z slaver7 $
 * @link http://2moons.cc/
 */
 
class ShowLoginPage extends AbstractAdminPage
{
	public $requiredAuthLevel	= AUTH_USR;

	function __construct()
	{
		$this->setWindow('light');
		parent::__construct();
	}

	function show()
	{
		global $USER;

		$session	= Session::create();
		if($session->adminAccess == 1)
		{
			HTTP::redirectTo('admin.php');
		}

		$password	= HTTP::_GP('password', '');

		if(!empty($password))
		{
			$password	= PlayerUtil::cryptPassword($password);

			if ($password == $USER['password'])
			{
				$session->adminAccess	= 1;
				HTTP::redirectTo('admin.php');
			}
		}

		$template	= new Template();

		$template->assign_vars(array(
			'bodyclass'	=> 'standalone',
			'username'	=> $USER['username']
		));

		$template->display('page.login.default.tpl');
	}
}