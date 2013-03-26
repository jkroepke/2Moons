<?php
/*
 * @package AJAX_Chat
 * @author Sebastian Tschan
 * @copyright (c) Sebastian Tschan
 * @license GNU Affero General Public License
 * @link https://blueimp.net/ajax/
 */

// Include custom libraries and initialization code here


define('MODE', 'CHAT');
define('ROOT_PATH', str_replace('\\', '/',dirname(AJAX_CHAT_PATH)).'/');
set_include_path(ROOT_PATH);

require 'includes/pages/game/class.AbstractPage.php';
require 'includes/pages/game/class.ShowErrorPage.php';
require 'includes/common.php';

if(!$SESSION->IsUserLogin() || (Config::get('game_disable') == 0 && $USER['authlevel'] == AUTH_USR))
{
	HTTP::redirectTo('index.php?code=3');
}
	
if(!isModulAvalible(MODULE_CHAT))
{
	ShowErrorPage::printError($LNG['sys_module_inactive']);
}