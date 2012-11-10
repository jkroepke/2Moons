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
 * @version 1.7.0 (2012-12-31)
 * @info $Id$
 * @link http://2moons.cc/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) throw new Exception("Permission error!");

function ShowDisclamerPage()
{
	global $LNG, $USER, $LANG;
	
	$CONF	= Config::getAll(NULL, $_SESSION['adminuni']);
	if (!empty($_POST))
	{
		$config_before = array(	
			'disclamerAddress'	=> $CONF['disclamerAddress'],
			'disclamerPhone'	=> $CONF['disclamerPhone'],
			'disclamerMail'		=> $CONF['disclamerMail'],
			'disclamerNotice'	=> $CONF['disclamerNotice'],
		);
		
		$disclamerAddress	= HTTP::_GP('disclamerAddress', '', true);
		$disclamerPhone		= HTTP::_GP('disclamerPhone', '', true);
		$disclamerMail		= HTTP::_GP('disclamerMail', '', true);
		$disclamerNotice	= HTTP::_GP('disclamerNotice', '', true);
		
		$config_after = array(	
			'disclamerAddress'	=> $disclamerAddress,
			'disclamerPhone'	=> $disclamerPhone,
			'disclamerMail'		=> $disclamerMail,
			'disclamerNotice'	=> $disclamerNotice,
		);
		
		Config::update($config_after);
		$CONF	= Config::getAll(NULL, $_SESSION['adminuni']);
		
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
		'disclamerAddress'		=> $CONF['disclamerAddress'],
		'disclamerPhone'		=> $CONF['disclamerPhone'],
		'disclamerMail'			=> $CONF['disclamerMail'],
		'disclamerNotice'		=> $CONF['disclamerNotice'],
		'se_server_parameters'	=> $LNG['mu_disclamer'],
		'se_save_parameters'	=> $LNG['se_save_parameters'],
		'se_disclamerAddress'	=> $LNG['se_disclamerAddress'],
		'se_disclamerPhone'		=> $LNG['se_disclamerPhone'],
		'se_disclamerMail'		=> $LNG['se_disclamerMail'],
		'se_disclamerNotice'	=> $LNG['se_disclamerNotice'],
	));
	
	$template->show('DisclamerConfigBody.tpl');
}

?>