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
 * @copyright 2009 Lucky (XGProyecto)
 * @copyright 2012 Jan <info@2moons.cc> (2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.0 (2012-05-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
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
		global $LNG, $uniAllConfig, $gameConfig;
			
		foreach($uniAllConfig as $uniID => $config)
		{
			$AvailableUnis[$uniID]	= $config['uniName'].($config['disabled'] == 1 ? $LNG['uni_closed'] : '');
			$RegClosed[$uniID]		= $config['disableRegistration'];
		}
		ksort($AvailableUnis);
		
		$Code	= HTTP::_GP('code', 0);
		if(!empty($Code))
		{
			$this->assign(array(
				'code'					=> $LNG['login_error_'.$Code],
			));
		}

		$RefID		= 0;
		$RefUser	= 0;
					
		if($gameConfig['referralEnable'])
		{
			$RefID		= HTTP::_GP('ref', 0);
			if(!empty($RefID))
			{
				$RefUser	= $GLOBALS['DATABASE']->countquery("SELECT universe FROM ".USERS." WHERE id = ".$RefID.";");
				if(!isset($RefUser))
				{
					$RefUser	= 0;
				}
			}
		}
		
		$this->assign(array(
			'ref_id'				=> $RefID,
			'ref_uni'				=> $RefUser,
			'contentbox'			=> false,
			'AvailableUnis'			=> $AvailableUnis,
			'RegClosedUnis'			=> json_encode($RegClosed),
			'server_description'	=> sprintf($LNG['server_description'], $gameConfig['gameName']),
		));
		
		$this->render('page.index.default.tpl');
	}
}