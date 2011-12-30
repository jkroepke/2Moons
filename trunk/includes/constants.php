<?php

/**
 *  2Moons
 *  Copyright (C) 2011  Slaver
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
 * @author Slaver <slaver7@gmail.com>
 * @copyright 2009 Lucky <lucky@xgproyect.net> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.6.1 (2011-11-19)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

//SET TIMEZONE (if Server Timezone are not correct)
//date_default_timezone_set('America/Chicago');
//TEMPLATES DEFAULT SETTINGS
define('DEFAULT_THEME'	 		    , 'gow');
define('HTTPS'						, isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"]  == 'on');
define('PROTOCOL'					, HTTPS ? 'https://' : 'http://');
define('HTTP_ROOT'					, str_replace('\\', '/', str_replace(basename($_SERVER['SCRIPT_FILENAME']), '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))));
define('HTTP_HOST'					, $_SERVER['HTTP_HOST']);
define('HTTP_PATH'					, PROTOCOL.HTTP_HOST.HTTP_ROOT);

defined('AJAX_CHAT_PATH') || define('AJAX_CHAT_PATH', ROOT_PATH.'/chat/');

define('DEFAULT_LANG'             , "de"); // For Fatal Errors!
define('PHPEXT'                   , "php");

// SUPPORT WILDCAST DOMAINS
define('UNIS_WILDCAST'			  , false);

// SUPPORT MULTIPLY UNIVERSE VIA HTACCESS (BETA; COMMENT OUT THE REWRITE SELECTION)
define('UNIS_HTACCESS'			  , false);

// SUPPORT OWN vars.php / UNIVERSE | NOTE: make a COPY of vars.php and rename it to vars_uni1.php,  vars_uni2.php, etc...
define('UNIS_MULTIVARS'			  , false);

// NUMBER OF COLUMNS FOR SPY REPORTS
define('SPY_REPORT_ROW'           , 2);

// FIELDS FOR EACH LEVEL OF THE LUNAR BASE
define('FIELDS_BY_MOONBASIS_LEVEL', 3);

// FIELDS FOR EACH LEVEL OF THE TERRAFORMER
define('FIELDS_BY_TERRAFORMER'	  , 5);

// TIME IN SECONDS, TO (i) APPEAR ON GALAXY
define('INACTIVE'				  , 604800);

// TIME IN SECONDS, TO (i I) APPEAR ON GALAXY
define('INACTIVE_LONG'			  , 2419200);

// FEE FOR CANCEL QUEUE IN SHIPYARD
define('FACTOR_CANCEL_SHIPYARD'	  , 0.6);

// ADDED PLANET PRO 2 TECH LEVELS
define('PLANETS_PER_TECH' 		  , 1);	

// MINIMUM FLEET TIME
define('MIN_FLEET_TIME' 		  , 5);	

// Time of changable nick after changing nick.
define('USERNAME_CHANGETIME'	  , 604800);

// Factor for Metal/Crystal and Deuterium Storages
define('STORAGE_FACTOR'			  , 1.0);

// Max Results in Searchpage (-1 = disable)
define('SEARCH_LIMIT'	  	 	  , 25);

// How much IP Block ll be checked
// 1 = (AAA); 2 = (AAA.BBB); 3 = (AAA.BBB.CCC)
define('COMPARE_IP_BLOCKS'	  	  , 2);

// Max Round on Combats
define('MAX_ATTACK_ROUNDS'		  , 6);

// Enable the one-Click SImulation on Spy-Raports
define('ENABLE_SIMULATOR_LINK'    , true);

// Planetrows on overview
define('PLANET_ROWS_ON_OVERVIEW'  , 2);

// Max. User Session in Seconds
define('SESSION_LIFETIME'		  , 43200);

// DISCLAMER INFOS
define('DICLAMER_NAME'            , "Edit constans.php!");
define('DICLAMER_ADRESS1'         , "Edit constans.php!");
define('DICLAMER_ADRESS2'         , "Edit constans.php!");
define('DICLAMER_TEL'     		  , "Edit constans.php!");
define('DICLAMER_EMAIL'    		  , "Edit constans.php!");

// UTF-8 Support for Names (Requried for non-english Chars!)
define('UTF8_SUPPORT'          	  , true);

// Bash Settings
define('BASH_ON'        	  	  , false);	
define('BASH_COUNT'          	  , 6);	
define('BASH_TIME'          	  , 86400);	

// Invisible Missions for Phalanx
// Exsample: 1,4,7,10

define('INV_PHALANX_MISSIONS'		, "8");	

// Root IDs
define('ROOT_UNI'					, 1);	
define('ROOT_USER'					, 1);	

// AdminAuthlevels
define('AUTH_ADM'					, 3);
define('AUTH_OPS'					, 2);
define('AUTH_MOD'					, 1);
define('AUTH_USR'					, 0);

// Moduls
define('MODUL_AMOUNT'				, 42);

define('MODUL_ALLIANCE'				, 0);
define('MODUL_BANLIST'				, 21);
define('MODUL_BANNER'				, 37);
define('MODUL_BATTLEHALL'			, 12);
define('MODUL_BUDDYLIST'			, 6);
define('MODUL_BUILDING'				, 2);
define('MODUL_CHAT'					, 7);
define('MODUL_DMEXTRAS'				, 8);
define('MODUL_FLEET_EVENTS'			, 10);
define('MODUL_FLEET_TABLE'			, 9);
define('MODUL_FLEET_TRADER'			, 38);
define('MODUL_GALAXY'				, 11);
define('MODUL_IMPERIUM'				, 15);
define('MODUL_INFORMATION'			, 14);
define('MODUL_MESSAGES'				, 16);
define('MODUL_MISSILEATTACK'		, 40);
define('MODUL_MISSION_ATTACK'		, 1);
define('MODUL_MISSION_ACS'			, 42);
define('MODUL_MISSION_COLONY'		, 35);
define('MODUL_MISSION_DARKMATTER'	, 31);
define('MODUL_MISSION_DESTROY'		, 29);
define('MODUL_MISSION_EXPEDITION'	, 30);
define('MODUL_MISSION_HOLD'			, 33);
define('MODUL_MISSION_RECYCLE'		, 32);
define('MODUL_MISSION_SPY'			, 24);
define('MODUL_MISSION_STATION'		, 36);
define('MODUL_MISSION_TRANSPORT'	, 34);
define('MODUL_NOTICE'				, 17);
define('MODUL_OFFICIER'				, 18);
define('MODUL_PHALANX'				, 19);
define('MODUL_PLAYERCARD'			, 20);
define('MODUL_RECORDS'				, 22);
define('MODUL_RESEARCH'				, 3);
define('MODUL_RESSOURCE_LIST'		, 23);
define('MODUL_SEARCH'				, 26);
define('MODUL_SHIPYARD_FLEET'		, 4);
define('MODUL_SHIPYARD_DEFENSIVE'	, 5);
define('MODUL_SHOTCUTS'				, 41);
define('MODUL_SIMULATOR'			, 39);
define('MODUL_STATISTICS'			, 25);
define('MODUL_SUPPORT'				, 27);
define('MODUL_TECHTREE'				, 28);
define('MODUL_TRADER'				, 13);

//Fleet Status

define('FLEET_OUTWARD'				, 0);
define('FLEET_RETURN'				, 1);
define('FLEET_HOLD'					, 2);

?>