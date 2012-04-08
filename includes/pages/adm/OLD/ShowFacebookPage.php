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

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) exit;

function ShowFacebookPage() {
	global $CONF, $LNG;
	if ($_POST)
	{
		$CONF['fb_on']		= isset($_POST['fb_on']) && $_POST['fb_on'] == 'on' && !empty($_POST['fb_skey']) && !empty($_POST['fb_apikey']) ? 1 : 0;
		$CONF['fb_apikey']	= HTTP::_GP('fb_apikey', '');
		$CONF['fb_skey'] 	= HTTP::_GP('fb_skey', '');
	
		update_config(array(
			'fb_on'		=> $CONF['fb_on'],
			'fb_apikey'	=> $CONF['fb_apikey'],
			'fb_skey'	=> $CONF['fb_skey']
		));
	}
	
	$template	= new Template();
	

	$template->assign(array(
		'se_save_parameters'	=> $LNG['se_save_parameters'],
		'fb_info'				=> $LNG['fb_info'],
		'fb_secrectkey'			=> $LNG['fb_secrectkey'],
		'fb_api_key'			=> $LNG['fb_api_key'],
		'fb_active'				=> $LNG['fb_active'],
		'fb_settings'			=> $LNG['fb_settings'],
		'fb_on'					=> $CONF['fb_on'],
		'fb_apikey'				=> $CONF['fb_apikey'],
		'fb_skey'				=> $CONF['fb_skey'],
		'fb_curl'				=> function_exists('curl_init') ? 1 : 0,
		'fb_curl_info'			=> function_exists('curl_init') ? $LNG['fb_curl_yes'] : $LNG['fb_curl_no'],
	));
	$template->show('FacebookPage.tpl');
}
