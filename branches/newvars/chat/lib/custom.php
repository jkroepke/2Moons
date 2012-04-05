<?php
/*
 * @package AJAX_Chat
 * @author Sebastian Tschan
 * @copyright (c) Sebastian Tschan
 * @license GNU Affero General Public License
 * @link https://blueimp.net/ajax/
 */

// Include custom libraries and initialization code here


define('MODE', 'INGAME');
define('ROOT_PATH', str_replace('\\', '/', dirname(AJAX_CHAT_PATH)).'/');

require(ROOT_PATH.'includes/common.php');

if(!$SESSION->IsUserLogin() || ($uniConfig['enable'] == 0 && $USER['authlevel'] != AUTH_ADM)) {
	HTTP::redirectTo('index.php?code=3');
}

if(!isModulAvalible(MODULE_CHAT)) {
	ShowErrorPage::printError($LNG['sys_module_inactive']);
}