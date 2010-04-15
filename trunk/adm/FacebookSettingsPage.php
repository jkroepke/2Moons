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

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

define('ROOT_PATH', './../');
include(ROOT_PATH . 'extension.inc');
include(ROOT_PATH . 'common.' . PHP_EXT);


if ($ConfigGame != 1) die();

if ($_POST)
{
	if (isset($_POST['fb_apikey'])) {
		$game_config['fb_apikey'] = $_POST['fb_apikey'];
	}
	if (isset($_POST['fb_skey'])) {
		$game_config['fb_skey'] = $_POST['fb_skey'];
	}
	if (isset($_POST['fb_on']) && $_POST['fb_on'] == 'on' && !empty($_POST['fb_skey']) && !empty($_POST['fb_apikey'])) {
		$game_config['fb_on'] = 1;
	} else {
		$game_config['fb_on'] = 0;
	}
	update_config('fb_on'		, $game_config['fb_on']     );
	update_config('fb_apikey'	, $game_config['fb_apikey'] );
	update_config('fb_skey'		, $game_config['fb_skey']   );
}
$parse							= $lang;
$parse['fb_on']              	= ($game_config['fb_on'] == 1)   ? "checked = 'checked' ":"";
$parse['fb_apikey']             = $game_config['fb_apikey'];
$parse['fb_skey']          	  	= $game_config['fb_skey'];

display (parsetemplate(gettemplate('adm/FBSettingsBody'),  $parse), false, '', true, false);

?>