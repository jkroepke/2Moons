<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
 *
 * For the full copyright and license information, please view the LICENSE
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
 * @licence MIT
 * @version 1.7.2 (2013-03-18)
 * @info $Id$
 * @link http://2moons.cc/
 */

if (isset($_POST['GLOBALS']) || isset($_GET['GLOBALS'])) {
	exit('You cannot set the GLOBALS-array from outside the script.');
}

$composerAutoloader = __DIR__.'/../vendor/autoload.php';

if (file_exists($composerAutoloader)) {
    require $composerAutoloader;
}

function isCommandLineInterface()
{
    return (php_sapi_name() === 'cli');
}

// Magic Quotes work around.
// http://www.php.net/manual/de/security.magicquotes.disabling.php#91585
if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc() == 1) {
    function stripslashes_gpc(&$value)
    {
        $value = stripslashes($value);
    }
    array_walk_recursive($_GET, 'stripslashes_gpc');
    array_walk_recursive($_POST, 'stripslashes_gpc');
    array_walk_recursive($_COOKIE, 'stripslashes_gpc');
    array_walk_recursive($_REQUEST, 'stripslashes_gpc');
}

if (function_exists('mb_internal_encoding')) {
	mb_internal_encoding("UTF-8");
}

ignore_user_abort(true);
error_reporting(E_ALL & ~E_STRICT);

// If date.timezone is invalid
date_default_timezone_set(@date_default_timezone_get());

ini_set('display_errors', 1);

if (!isCommandLineInterface()) {
	header('Content-Type: text/html; charset=UTF-8');
}

define('TIMESTAMP',	time());
	
require 'includes/constants.php' ;

ini_set('log_errors', 'On');
ini_set('error_log', 'includes/error.log');

require 'includes/GeneralFunctions.php';

set_exception_handler('exceptionHandler');
set_error_handler('errorHandler');

require 'includes/classes/ArrayUtil.class.php';
require 'includes/classes/Cache.class.php';
require 'includes/classes/Database.class.php';
require 'includes/classes/Config.class.php';
require 'includes/classes/class.FleetFunctions.php';
require 'includes/classes/HTTP.class.php';
require 'includes/classes/Language.class.php';
require 'includes/classes/PlayerUtil.class.php';
require 'includes/classes/Session.class.php';
require 'includes/classes/Universe.class.php';

require 'includes/classes/class.theme.php';
require 'includes/classes/class.template.php';

// Say Browsers to Allow ThirdParty Cookies (Thanks to morktadela)
HTTP::sendHeader('P3P', 'CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
define('AJAX_REQUEST', HTTP::_GP('ajax', 0));

$THEME		= new Theme();

if (MODE === 'INSTALL')
{
	return;
}

if(!file_exists('includes/config.php')) {
	HTTP::redirectTo('install/index.php');
}

if(defined('DATABASE_VERSION') && DATABASE_VERSION === 'OLD')
{
	/* For our old Admin panel */
	require 'includes/classes/Database_BC.class.php';
	$DATABASE	= new Database_BC();
	
	$dbTableNames	= Database::get()->getDbTableNames();
	$dbTableNames	= array_combine($dbTableNames['keys'], $dbTableNames['names']);
	
	foreach($dbTableNames as $dbAlias => $dbName)
	{
		define(substr($dbAlias, 2, -2), $dbName);
	}	
}

$config = Config::get();
date_default_timezone_set($config->timezone);

if (MODE === 'INGAME' || MODE === 'ADMIN' || MODE === 'CRON')
{
	$session	= Session::load();

	if(!$session->isValidSession())
	{
	    $session->delete();
		HTTP::redirectTo('index.php?code=3');
	}

	require 'includes/vars.php';
	require 'includes/classes/class.BuildFunctions.php';
	require 'includes/classes/class.PlanetRessUpdate.php';
	
	if(!AJAX_REQUEST && MODE === 'INGAME' && isModuleAvailable(MODULE_FLEET_EVENTS)) {
		require('includes/FleetHandler.php');
	}
	
	$db		= Database::get();

	$sql	= "SELECT 
	user.*,
	COUNT(message.message_id) as messages
	FROM %%USERS%% as user
	LEFT JOIN %%MESSAGES%% as message ON message.message_owner = user.id AND message.message_unread = :unread
	WHERE user.id = :userId
	GROUP BY message.message_owner;";
	
	$USER	= $db->selectSingle($sql, array(
		':unread'	=> 1,
		':userId'	=> $session->userId
	));
	
	if(empty($USER))
	{
		HTTP::redirectTo('index.php?code=3');
	}
	
	$LNG	= new Language($USER['lang']);
	$LNG->includeData(array('L18N', 'INGAME', 'TECH', 'CUSTOM'));
	$THEME->setUserTheme($USER['dpath']);
	
	if($config->game_disable == 0 && $USER['authlevel'] == AUTH_USR) {
		ShowErrorPage::printError($LNG['sys_closed_game'].'<br><br>'.$config->close_reason, false);
	}

	if($USER['bana'] == 1) {
		ShowErrorPage::printError("<font size=\"6px\">".$LNG['css_account_banned_message']."</font><br><br>".sprintf($LNG['css_account_banned_expire'], _date($LNG['php_tdformat'], $USER['banaday'], $USER['timezone']))."<br><br>".$LNG['css_goto_homeside'], false);
	}
	
	if (MODE === 'INGAME')
	{
		$universeAmount	= count(Universe::availableUniverses());
		if(Universe::current() != $USER['universe'] && $universeAmount > 1)
		{
			HTTP::redirectToUniverse($USER['universe']);
		}

		$session->selectActivePlanet();

		$sql	= "SELECT * FROM %%PLANETS%% WHERE id = :planetId;";
		$PLANET	= $db->selectSingle($sql, array(
			':planetId'	=> $session->planetId,
		));

		if(empty($PLANET))
		{
			$sql	= "SELECT * FROM %%PLANETS%% WHERE id = :planetId;";
			$PLANET	= $db->selectSingle($sql, array(
				':planetId'	=> $USER['id_planet'],
			));
			
			if(empty($PLANET))
			{
				throw new Exception("Main Planet does not exist!");
			}
			else
			{
				$session->planetId = $USER['id_planet'];
			}
		}
		
		$USER['factor']		= getFactors($USER);
		$USER['PLANETS']	= getPlanets($USER);
	}
	elseif (MODE === 'ADMIN')
	{
		error_reporting(E_ERROR | E_WARNING | E_PARSE);
		
		$USER['rights']		= unserialize($USER['rights']);
		$LNG->includeData(array('ADMIN', 'CUSTOM'));
	}
}
elseif(MODE === 'LOGIN')
{
	$LNG	= new Language();
	$LNG->getUserAgentLanguage();
	$LNG->includeData(array('L18N', 'INGAME', 'PUBLIC', 'CUSTOM'));
}
elseif(MODE === 'CHAT')
{
	$session	= Session::load();

	if(!$session->isValidSession())
	{
		HTTP::redirectTo('index.php?code=3');
	}
}
elseif(MODE === 'CLI-CRON')
{
	require 'includes/vars.php';
	require 'includes/classes/class.BuildFunctions.php';
	require 'includes/classes/class.PlanetRessUpdate.php';
}
