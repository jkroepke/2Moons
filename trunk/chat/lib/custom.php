<?php
/*
 * @package AJAX_Chat
 * @author Sebastian Tschan
 * @copyright (c) Sebastian Tschan
 * @license GNU Affero General Public License
 * @link https://blueimp.net/ajax/
 */

// Include custom libraries and initialization code here


define('INSIDE', true );
define('AJAX', true );

define('ROOT_PATH', str_replace('\\', '/',dirname(AJAX_CHAT_PATH)).'/');
require(ROOT_PATH . 'includes/common.php');
$SESSION       	= new Session();

if(!$SESSION->IsUserLogin() || ($CONF['game_disable'] == 0 && $_SESSION['authlevel'] == AUTH_USR))
	redirectTo('index.php?code=3');
	
if(CheckModule(7))
	message($LNG['sys_module_inactive'],"?page=overview", 3, true, true);
?>