<?php

##############################################################################
# *																			 #
# * RN FRAMEWORK															 #
# *  																		 #
# * @copyright Copyright (C) 2009 By ShadoX from xnova-reloaded.de	    	 #
# *																			 #
# *																			 #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.									 #
# *																			 #
# *  This program is distributed in the hope that it will be useful,		 #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of			 #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 #
# *  GNU General Public License for more details.							 #
# *																			 #
##############################################################################

if ($USER['rights'][str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__)] != 1) exit;

function ShowFacebookPage() {
	global $CONF, $LNG;
	if ($_POST)
	{
		if (isset($_POST['fb_on']) && $_POST['fb_on'] == 'on' && !empty($_POST['fb_skey']) && !empty($_POST['fb_apikey'])) {
			$CONF['fb_on'] = 1;
		} else {
			$CONF['fb_on'] = 0;
		}
		$CONF['fb_apikey']	= request_var('fb_apikey', '');
		$CONF['fb_skey'] 	= request_var('fb_skey', '');
	
		update_config('fb_on'		, $CONF['fb_on']);
		update_config('fb_apikey'	, $CONF['fb_apikey']);
		update_config('fb_skey'		, $CONF['fb_skey']);
	}
	
	$template	= new template();
	
	$template->page_header();
	$template->assign_vars(array(
		'se_save_parameters'	=> $LNG['se_save_parameters'],
		'fb_info'				=> $LNG['fb_info'],
		'fb_secrectkey'			=> $LNG['fb_secrectkey'],
		'fb_api_key'			=> $LNG['fb_api_key'],
		'fb_active'				=> $LNG['fb_active'],
		'fb_settings'			=> $LNG['fb_settings'],
		'fb_on'					=> $CONF['fb_on'],
		'fb_apikey'				=> $CONF['fb_apikey'],
		'fb_skey'				=> $CONF['fb_skey'],
	));
	$template->show('adm/FacebookPage.tpl');
}

?>