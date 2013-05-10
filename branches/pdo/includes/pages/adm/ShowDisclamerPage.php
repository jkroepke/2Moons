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

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) throw new Exception("Permission error!");

function ShowDisclamerPage()
{
	global $LNG;


	$config = Config::get(Universe::getEmulated());

	if (!empty($_POST))
	{
		$config_before = array(	
			'disclamerAddress'	=> $config->disclamerAddress,
			'disclamerPhone'	=> $config->disclamerPhone,
			'disclamerMail'	=> $config->disclamerMail,
			'disclamerNotice'	=> $config->disclamerNotice,
		);
		
		$disclaimerAddress	= HTTP::_GP('disclaimerAddress', '', true);
		$disclaimerPhone	= HTTP::_GP('disclaimerPhone', '', true);
		$disclaimerMail		= HTTP::_GP('disclaimerMail', '', true);
		$disclaimerNotice	= HTTP::_GP('disclaimerNotice', '', true);
		
		$config_after = array(	
			'disclamerAddress'	=> $disclaimerAddress,
			'disclamerPhone'	=> $disclaimerPhone,
			'disclamerMail'		=> $disclaimerMail,
			'disclamerNotice'	=> $disclaimerNotice,
		);

		foreach($config_after as $key => $value)
		{
			$config->$key	= $value;
		}
		$config->save();
		
		$LOG = new Log(3);
		$LOG->target = 5;
		$LOG->old = $config_before;
		$LOG->new = $config_after;
		$LOG->save();
	}

	$template	= new template();
	$template->loadscript('../base/jquery.autosize-min.js');
	$template->execscript('$(\'textarea\').autosize();');

	$template->assign_vars(array(
		'disclaimerAddress'		=> $config->disclamerAddress,
		'disclaimerPhone'		=> $config->disclamerPhone,
		'disclaimerMail'		=> $config->disclamerMail,
		'disclaimerNotice'		=> $config->disclamerNotice,
		'se_server_parameters'	=> $LNG['mu_disclaimer'],
		'se_save_parameters'	=> $LNG['se_save_parameters'],
		'se_disclaimerAddress'	=> $LNG['se_disclaimerAddress'],
		'se_disclaimerPhone'	=> $LNG['se_disclaimerPhone'],
		'se_disclaimerMail'		=> $LNG['se_disclaimerMail'],
		'se_disclaimerNotice'	=> $LNG['se_disclaimerNotice'],
	));
	
	$template->show('DisclamerConfigBody.tpl');
}
