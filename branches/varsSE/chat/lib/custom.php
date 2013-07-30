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
define('ROOT_PATH', str_replace('\\', '/', dirname(AJAX_CHAT_PATH)).'/');
set_include_path(ROOT_PATH);
chdir(ROOT_PATH);

require 'includes/pages/game/AbstractPage.class.php';
require 'includes/pages/game/ShowErrorPage.class.php';
require 'includes/common.php';

$session	= Session::load();

if(!$session->isValidSession() || (Config::get()->game_disable == 0 && isset($USER['authlevel']) && $USER['authlevel'] == AUTH_USR))
{
	HTTP::redirectTo('index.php?code=3');
}
	
if(!isModulAvalible(MODULE_CHAT))
{
	/** @var $LNG array */
	ShowErrorPage::printError($LNG['sys_module_inactive']);
}