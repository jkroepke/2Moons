<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @licence MIT
 * @version 1.7.2 (2013-03-18)
 * @info $Id$
 * @link http://2moons.cc/
 */

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) throw new Exception("Permission error!");

function ShowFacebookPage() {

	global $LNG;

	$config = Config::get(Universe::getEmulated());

	if ($_POST)
	{
		$fb_on		= isset($_POST['fb_on']) && $_POST['fb_on'] == 'on' && !empty($_POST['fb_skey']) && !empty($_POST['fb_apikey']) ? 1 : 0;
		$fb_apikey	= HTTP::_GP('fb_apikey', '');
		$fb_skey 	= HTTP::_GP('fb_skey', '');


		foreach(array(
					'fb_on'		=> $fb_on,
					'fb_apikey'	=> $fb_apikey,
					'fb_skey'	=> $fb_skey
		) as $key => $value) {
			$config->$key	= $value;
		}
		
		$config->save();
	}
	
	$template	= new template();
	$template->assign_vars(array(
		'se_save_parameters'	=> $LNG['se_save_parameters'],
		'fb_info'				=> $LNG['fb_info'],
		'fb_secrectkey'			=> $LNG['fb_secrectkey'],
		'fb_api_key'			=> $LNG['fb_api_key'],
		'fb_active'				=> $LNG['fb_active'],
		'fb_settings'			=> $LNG['fb_settings'],
		'fb_on'					=> $config->fb_on,
		'fb_apikey'				=> $config->fb_apikey,
		'fb_skey'				=> $config->fb_skey,
		'fb_curl'				=> function_exists('curl_init') ? 1 : 0,
		'fb_curl_info'			=> function_exists('curl_init') ? $LNG['fb_curl_yes'] : $LNG['fb_curl_no'],
	));
	$template->show('FacebookPage.tpl');
}
