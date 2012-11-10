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
		$referralID		= HTTP::_GP('ref', 0);
		if(!empty($referralID))
		{
			$this->redirectTo('index.php?page=register&referralID='.$referralID);
		}
	
		$universeSelect	= array();		
		$uniAllConfig	= Config::getAll('universe');
		
		foreach($uniAllConfig as $uniID => $uniConfig)
		{
			$universeSelect[$uniID]	= $uniConfig['uni_name'].($uniConfig['game_disable'] == 0 ? t('uni_closed') : '');
		}
		
		$Code	= HTTP::_GP('code', 0);
		try
		{
			$this->assign(array(
				'code'	=> t('login_error_'.$Code),
			));
		} catch(Exception $e) { }

		$referralUniversum	= 0;
		$referralUserID		= 0;
					
		if(Config::get('ref_active'))
		{
			$referralUserID		= HTTP::_GP('ref', 0);
			if(!empty($referralUserID))
			{
				$referralUniversum	= $GLOBALS['DATABASE']->getFirstRow("SELECT universe FROM ".USERS." WHERE id = ".$referralUserID.";");
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
			'descHeader'			=> t('loginWelcome', Config::get('game_name')),
			'descText'				=> t('loginServerDesc', Config::get('game_name')),
			'loginInfo'				=> t('loginInfo', '<a href="index.php?page=rules">'.t('menu_rules').'</a>')
		));
		
		$this->render('page.index.default.tpl');
	}
}