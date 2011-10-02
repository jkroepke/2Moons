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
 * @version 1.4 (2011-07-10)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

//SET TIMEZONE (if Server Timezone are not correct)
#date_default_timezone_set('Europe/Berlin');
 
//TEMPLATES DEFAULT SETTINGS
define('DEFAULT_THEME'	 		  , 'gow');

define('PROTOCOL'				  , (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"]  == 'on') ? 'https://' : 'http://');
define('HTTP_ROOT'				  , str_replace(basename($_SERVER["PHP_SELF"]), '', $_SERVER["PHP_SELF"]));

define('AJAX_CHAT_PATH'			  , ROOT_PATH.'/chat/');

define('DEFAULT_LANG'             , "de"); // For Fatal Errors!
define('PHPEXT'                   , "php");

// SUPPORT WILDCAST DOMAINS
define('UNIS_WILDCAST'			  , false);

// SUPPORT OWN vars.php / UNIVERSE | NOTE: make a COPY of vars.php and rename it to vars_uni1.php,  vars_uni2.php, etc...
define('UNIS_MULTIVARS'			  , false);

// NUMBER OF COLUMNS FOR SPY REPORTS
define('SPY_REPORT_ROW'           , 2);

// FIELDS FOR EACH LEVEL OF THE LUNAR BASE
define('FIELDS_BY_MOONBASIS_LEVEL', 3);

// FIELDS FOR EACH LEVEL OF THE TERRAFORMER
define('FIELDS_BY_TERRAFORMER'	  , 5);

// ADDED PLANET PRO 2 TECH LEVELS
define('PLANETS_PER_TECH' 		  , 1);	

// Time of changable nick after changing nick.
define('USERNAME_CHANGETIME'	  , 604800);

// Factor for Metal/Crystal and Deuterium Storages
define('STORAGE_FACTOR'			  , 1.0);

// How much IP Block ll be checked
// 1 = (AAA); 2 = (AAA.BBB); 3 = (AAA.BBB.CCC)
define('COMPARE_IP_BLOCKS'	  	  , 2);

// DEBUG LOG
define('DEBUG_EXTRA'	  	 	  , false);

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

// EventHandler Settings. Not in use!
define('EH_ACTIVE_ECO' 		 	  , BETA);
define('EH_ACTIVE_FLEETS'   	  , BETA);

// Root IDs
define('ROOT_UNI'        	  	  , 1);	
define('ROOT_USER'          	  , 1);	

// AdminAuthlevels
define('AUTH_ADM'                 , 3);
define('AUTH_OPS'                 , 2);
define('AUTH_MOD'                 , 1);
define('AUTH_USR'                 , 0);

// Data Tabells
define('DB_NAME'				  , $database['databasename']);
define('DB_PREFIX'			  	  , $database['tableprefix']);

define('AKS'				  	  , $database['tableprefix'].'aks');
define('ALLIANCE'			  	  , $database['tableprefix'].'alliance');
define('ALLIANCE_REQUEST'	  	  , $database['tableprefix'].'alliance_request');
define('BANNED'				  	  , $database['tableprefix'].'banned');
define('BUDDY'				  	  , $database['tableprefix'].'buddy');
define('BUDDY_REQUEST'		  	  , $database['tableprefix'].'buddy_request');
define('CHAT_ON'			  	  , $database['tableprefix'].'chat_online');
define('CHAT_MES'			  	  , $database['tableprefix'].'chat_messages');
define('CHAT_BAN'			  	  , $database['tableprefix'].'chat_bans');
define('CHAT_INV'			  	  , $database['tableprefix'].'chat_invitations');
define('CONFIG'				  	  , $database['tableprefix'].'config');
define('DIPLO'				  	  , $database['tableprefix'].'diplo');
define('FLEETS'				  	  , $database['tableprefix'].'fleets');
define('LOG'				  	  , $database['tableprefix'].'log');
define('NEWS'				  	  , $database['tableprefix'].'news');
define('NOTES'				  	  , $database['tableprefix'].'notes');
define('MESSAGES'			  	  , $database['tableprefix'].'messages');
define('PLANETS'	              , $database['tableprefix'].'planets');
define('RW'			              , $database['tableprefix'].'raports');
define('SESSION'				  , $database['tableprefix'].'session');
define('STATPOINTS'				  , $database['tableprefix'].'statpoints');
define('SUPP'					  , $database['tableprefix'].'supp');
define('TOPKB'					  , $database['tableprefix'].'topkb');
define('USERS'				  	  , $database['tableprefix'].'users');
define('USERS_VALID'		  	  , $database['tableprefix'].'users_valid');



// MOD-TABLES
	
	
?>