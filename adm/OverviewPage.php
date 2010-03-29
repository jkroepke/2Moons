<?php

##############################################################################
# *                                                                          #
# * 2MOONS                                                                   #
# *                                                                          #
# * @copyright Copyright (C) 2010 By ShadoX from titanspace.de               #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
# *                                                                          #
# *	                                                                         #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.                                     #
# *	                                                                         #
# *  This program is distributed in the hope that it will be useful,         #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of          #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           #
# *  GNU General Public License for more details.                            #
# *                                                                          #
##############################################################################

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

define('ROOT_PATH', './../');
include(ROOT_PATH . 'extension.inc');
include(ROOT_PATH . 'common.'.PHP_EXT);

if ($user['authlevel'] < 1) die(message ($lang['404_page']));

$parse	=	$lang;

if(file_exists(ROOT_PATH.'install/') && defined('IN_ADMIN'))
{
	$Message	.= "<font color=\"red\">".$lang['ow_install_file_detected']."</font><br/><br/>";
	$error++;
}

if ($user['authlevel'] >= 3)
{
	if(@fopen("./../config.php", "a"))
	{
		$Message	.= "<font color=\"red\">".$lang['ow_config_file_writable']."</font><br/><br/>";
		$error++;
	}
	if($game_config['stats_fly_lock'] != 0)
	{
		$Message	.= "<font color=\"red\">Der Fleet-Handler hatte ein Fehler! - Letzter Start: ".date("d. M y H:i:s" ,$game_config['stats_fly_lock'])." - N&auml;chster Start: ".date("d. M y H:i:s", $game_config['stats_fly_lock'] + 5 * 60)."</font><br/><br/>";
		$error++;
	}
	
	if(($game_config['smtp_host'] == '' || $game_config['smtp_port'] == '' || $game_config['smtp_user'] == '' || $game_config['smtp_pass'] == '') && $game_config['user_valid'] == 1)
	{
		$Message	.= "<font color=\"red\">&Uuml;berpr&uuml;fe deine SMTP-Einstellunden! - Momentan k&ouml;nen keine Mails gesendet werden!</font><br/><br/>";
		$error++;
	}

}

if($error != 0)
{
	$parse['error_message']		=	$Message;
	$parse['color']				=	"red";}
else
{
	$parse['error_message']		= 	$lang['ow_none'];
	$parse['color']				=	"lime";
}


display( parsetemplate(gettemplate('adm/OverviewBody'), $parse), false, '', true, false);
?>