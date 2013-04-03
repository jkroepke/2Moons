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

class ShowIndexPage extends AbstractPage
{
	function __construct() 
	{
		parent::__construct();
		$this->setWindow('light');
	}
	
	function show() 
	{
		global $LNG;
		
		$referralID		= HTTP::_GP('ref', 0);
		if(!empty($referralID))
		{
			$this->redirectTo('index.php?page=register&referralID='.$referralID);
		}
	
		$universeSelect	= array();
		
		foreach(Universe::availableUniverses() as $uniId)
		{
			$config = Config::get($uniId);
			$universeSelect[$uniId]	= $config->uni_name.($config->game_disable == 0 ? $LNG['uni_closed'] : '');
		}
		
		$Code	= HTTP::_GP('code', 0);
		$loginCode	= false;
		if(isset($LNG['login_error_'.$Code]))
		{
			$loginCode	= $LNG['login_error_'.$Code];
		}

		$referralUniversum	= 0;
		$referralUserID		= 0;

		$config				= Config::get();

		if($config->ref_active)
		{
			$referralUserID		= HTTP::_GP('ref', 0);
			if(!empty($referralUserID))
			{
				$db = Database::get();

				$sql = "SELECT universe FROM %%USERS%% WHERE id = :refID;";
				$referralUniversum = $db->selectSingle($sql, array(
					':refID'	=> $referralUserID
				));

				if(!isset($referralUniversum))
				{
					$referralUniversum	= 0;
					$referralUserID		= 0;
				}
			}
		}
		
		$this->assign(array(
			'referralUserID'		=> $referralUserID,
			'referralUniversum'		=> $referralUniversum,
			'universeSelect'		=> $universeSelect,
			'code'					=> $loginCode,
			'descHeader'			=> t('loginWelcome', $config->game_name),
			'descText'				=> t('loginServerDesc', $config->game_name),
			'loginInfo'				=> t('loginInfo', '<a href="index.php?page=rules">'.t('menu_rules').'</a>')
		));
		
		$this->render('page.index.default.tpl');
	}
}