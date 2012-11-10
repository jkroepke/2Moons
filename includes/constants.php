<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
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
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.0 (2012-12-31)
 * @info $Id$
 * @link http://2moons.cc/
 */

//SET TIMEZONE (if Server Timezone are not correct)
//date_default_timezone_set('America/Chicago');

//TEMPLATES DEFAULT SETTINGS
define('DEFAULT_THEME'	 		    , 'gow');
define('HTTPS'						, isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"]  == 'on');
define('PROTOCOL'					, HTTPS ? 'https://' : 'http://');
define('HTTP_BASE'					, str_replace('\\', '/', str_replace(basename($_SERVER['SCRIPT_FILENAME']), '', parse_url($_SERVER['SCRIPT_NAME'], PHP_URL_PATH))));
define('HTTP_ROOT'					, str_replace('\\', '/', str_replace(basename($_SERVER['SCRIPT_FILENAME']), '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))));
define('HTTP_FILE'					, str_replace(HTTP_ROOT, '', $_SERVER['REQUEST_URI']));
define('HTTP_HOST'					, $_SERVER['HTTP_HOST']);
define('HTTP_PATH'					, PROTOCOL.HTTP_HOST.HTTP_ROOT);

if(!defined('AJAX_CHAT_PATH')) {
	define('AJAX_CHAT_PATH', ROOT_PATH.'/chat/');
}

if(!defined('CACHE_PATH')) {
	define('CACHE_PATH', ROOT_PATH.'/cache/');
}

// For Fatal Errors!
define('DEFAULT_LANG'				, 'de');

// SUPPORT WILDCAST DOMAINS
define('UNIS_WILDCAST'				, false);

// FIELDS FOR EACH LEVEL OF THE LUNAR BASE
define('FIELDS_BY_MOONBASIS_LEVEL'	, 3);

// FIELDS FOR EACH LEVEL OF THE TERRAFORMER
define('FIELDS_BY_TERRAFORMER'		, 5);

// TIME IN SECONDS, TO (i) APPEAR ON GALAXY
define('INACTIVE'					, 604800);

// TIME IN SECONDS, TO (i I) APPEAR ON GALAXY
define('INACTIVE_LONG'				, 2419200);

// FEE FOR CANCEL QUEUE IN SHIPYARD
define('FACTOR_CANCEL_SHIPYARD'		, 0.6);

// ADDED PLANET PRO 2 TECH LEVELS
define('PLANETS_PER_TECH'			, 2);	

// MINIMUM FLEET TIME
define('MIN_FLEET_TIME'				, 5);	

// PHALANX COST'S
define('PHALANX_DEUTERIUM'			, 5000);	

// Time of changable nick after changing nick.
define('USERNAME_CHANGETIME'		, 604800);

// Factor for Metal/Crystal and Deuterium Storages
define('STORAGE_FACTOR'				, 1.0);

// Max Results in Searchpage (-1 = disable)
define('SEARCH_LIMIT'				, 25);

// Messages per page at message list
define('MESSAGES_PER_PAGE'			, 10);

// banned users per page at ban list
define('BANNED_USERS_PER_PAGE'		, 25);

// How much IP Block ll be checked
// 1 = (AAA); 2 = (AAA.BBB); 3 = (AAA.BBB.CCC)
define('COMPARE_IP_BLOCKS'			, 2);

// Max Round on Combats
define('MAX_ATTACK_ROUNDS'			, 6);

// Enable the one-Click SImulation on Spy-Raports
define('ENABLE_SIMULATOR_LINK'		, true);

// Max. User Session in Seconds
define('SESSION_LIFETIME'			, 43200);

// ENABLE Mutlialert on sending fleets
define('ENABLE_MULTIALERT'			, true);

// UTF-8 support for names (required for non-english chars!)
define('UTF8_SUPPORT'				, true);

// Bash Settings
define('BASH_ON'					, false);	
define('BASH_COUNT'					, 6);	
define('BASH_TIME'					, 86400);	

// Bash rule on wars:
// 0 = NORMAL
// 1 = ON WAR, BASH RULE IS DEACTIVE
define('BASH_WAR'					, 0);

// MINIMUM FLEET TIME MUST HIGHER THEN BASH_TIME
define('FLEETLOG_AGE'				, 86400);	

// EXPERIMENAL FUNCTION: DATABASE UPDATE
define('ENABLE_DATABASE_BACKUP'		, false);
// IT'S REQUIRED TO CHANGE TO DIR.
// ADDIONALLY, ITS REQUIRED, PHP CAN WRITE INTO THIS DIR.
// ALSO, ITS HIGHLY RECOMMEND TO FORBIDDEN THE DIR FOR HTTP USERS (.htaccess Protection)	
define('STORAGE_BACKUP_TO_DIR'		, '/tmp/');

// Root IDs
define('ROOT_UNI'					, 1);	
define('ROOT_USER'					, 1);	

// AUTHLEVEL
define('AUTH_ADM'					, 3);
define('AUTH_OPS'					, 2);
define('AUTH_MOD'					, 1);
define('AUTH_USR'					, 0);

// Modules
define('MODULE_AMOUNT'				, 43);
define('MODULE_ALLIANCE'			, 0);
define('MODULE_BANLIST'				, 21);
define('MODULE_BANNER'				, 37);
define('MODULE_BATTLEHALL'			, 12);
define('MODULE_BUDDYLIST'			, 6);
define('MODULE_BUILDING'			, 2);
define('MODULE_CHAT'				, 7);
define('MODULE_DMEXTRAS'			, 8);
define('MODULE_FLEET_EVENTS'		, 10);
define('MODULE_FLEET_TABLE'			, 9);
define('MODULE_FLEET_TRADER'		, 38);
define('MODULE_GALAXY'				, 11);
define('MODULE_IMPERIUM'			, 15);
define('MODULE_INFORMATION'			, 14);
define('MODULE_MESSAGES'			, 16);
define('MODULE_MISSILEATTACK'		, 40);
define('MODULE_MISSION_ATTACK'		, 1);
define('MODULE_MISSION_ACS'			, 42);
define('MODULE_MISSION_COLONY'		, 35);
define('MODULE_MISSION_DARKMATTER'	, 31);
define('MODULE_MISSION_DESTROY'		, 29);
define('MODULE_MISSION_EXPEDITION'	, 30);
define('MODULE_MISSION_HOLD'		, 33);
define('MODULE_MISSION_RECYCLE'		, 32);
define('MODULE_MISSION_SPY'			, 24);
define('MODULE_MISSION_STATION'		, 36);
define('MODULE_MISSION_TRANSPORT'	, 34);
define('MODULE_NOTICE'				, 17);
define('MODULE_OFFICIER'			, 18);
define('MODULE_PHALANX'				, 19);
define('MODULE_PLAYERCARD'			, 20);
define('MODULE_RECORDS'				, 22);
define('MODULE_RESEARCH'			, 3);
define('MODULE_RESSOURCE_LIST'		, 23);
define('MODULE_SEARCH'				, 26);
define('MODULE_SHIPYARD_FLEET'		, 4);
define('MODULE_SHIPYARD_DEFENSIVE'	, 5);
define('MODULE_SHORTCUTS'			, 41);
define('MODULE_SIMULATOR'			, 39);
define('MODULE_STATISTICS'			, 25);
define('MODULE_SUPPORT'				, 27);
define('MODULE_TECHTREE'			, 28);
define('MODULE_TRADER'				, 13);

// FLEET STATE
define('FLEET_OUTWARD'				, 0);
define('FLEET_RETURN'				, 1);
define('FLEET_HOLD'					, 2);

// ELEMENT FLAGS
define('ELEMENT_BUILD'				, 1); # ID 0 - 99
define('ELEMENT_TECH'				, 2); # ID 101 - 199
define('ELEMENT_FLEET'				, 4); # ID 201 - 399
define('ELEMENT_DEFENSIVE'			, 8); # ID 401 - 599
define('ELEMENT_OFFICIER'			, 16); # ID 601 - 699
define('ELEMENT_BONUS'				, 32); # ID 701 - 799
define('ELEMENT_RACE'				, 64); # ID 801 - 899
define('ELEMENT_PLANET_RESOURCE'   , 128); # ID 901 - 949
define('ELEMENT_USER_RESOURCE'     , 256); # ID 951 - 999

// .. 512, 1024, 2048, 4096, 8192, 16384, 32768

define('ELEMENT_PRODUCTION'			, 65536);
define('ELEMENT_STORAGE'			, 131072);
define('ELEMENT_ONEPERPLANET'		, 262144);
define('ELEMENT_BOUNS'				, 524288);
define('ELEMENT_BUILD_ON_PLANET'	, 1048576);
define('ELEMENT_BUILD_ON_MOONS'		, 2097152);
define('ELEMENT_RESOURCE_ON_TF'		, 4194304);
define('ELEMENT_RESOURCE_ON_FLEET'	, 8388608);
define('ELEMENT_RESOURCE_ON_STEAL'	, 16777216);
