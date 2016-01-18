<?php

/**
 *  2Moons
 *  Copyright (C) 2011 Jan Kröpke
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2009 Lucky
 * @copyright 2011 Jan Kröpke <info@2moons.cc>
 * @licence MIT
 * @version 1.5 (2011-07-31)
 * @info $Id$
 * @link http://2moons.cc/
 */

define('DB_NAME'			, $database['databasename']);
define('DB_PREFIX'			, $database['tableprefix']);

// Data Tabells
$dbTableNames	= array(
	'AKS'				=> DB_PREFIX.'aks',
	'ALLIANCE'			=> DB_PREFIX.'alliance',
	'ALLIANCE_RANK'		=> DB_PREFIX.'alliance_ranks',
	'ALLIANCE_REQUEST'	=> DB_PREFIX.'alliance_request',
	'BANNED'			=> DB_PREFIX.'banned',
	'BUDDY'				=> DB_PREFIX.'buddy',
	'BUDDY_REQUEST'		=> DB_PREFIX.'buddy_request',
	'CHAT_BAN'			=> DB_PREFIX.'chat_bans',
	'CHAT_INV'			=> DB_PREFIX.'chat_invitations',
	'CHAT_MES'			=> DB_PREFIX.'chat_messages',
	'CHAT_ON'			=> DB_PREFIX.'chat_online',
	'CONFIG'			=> DB_PREFIX.'config',
	'CRONJOBS'			=> DB_PREFIX.'cronjobs',
	'CRONJOBS_LOG'		=> DB_PREFIX.'cronjobs_log',
	'DIPLO'				=> DB_PREFIX.'diplo',
	'FLEETS'			=> DB_PREFIX.'fleets',
	'FLEETS_EVENT'		=> DB_PREFIX.'fleet_event',
	'LOG'				=> DB_PREFIX.'log',
	'LOG_FLEETS'		=> DB_PREFIX.'log_fleets',
	'LOSTPASSWORD'		=> DB_PREFIX.'lostpassword',
	'NEWS'				=> DB_PREFIX.'news',
	'NOTES'				=> DB_PREFIX.'notes',
	'MESSAGES'			=> DB_PREFIX.'messages',
	'MULTI'				=> DB_PREFIX.'multi',
	'PLANETS'			=> DB_PREFIX.'planets',
	'RW'				=> DB_PREFIX.'raports',
	'RECORDS'			=> DB_PREFIX.'records',
	'SESSION'			=> DB_PREFIX.'session',
	'SHORTCUTS'			=> DB_PREFIX.'shortcuts',
	'STATPOINTS'		=> DB_PREFIX.'statpoints',
	'TICKETS'			=> DB_PREFIX.'ticket',
	'TICKETS_ANSWER'	=> DB_PREFIX.'ticket_answer',
	'TICKETS_CATEGORY'	=> DB_PREFIX.'ticket_category',
	'TOPKB'				=> DB_PREFIX.'topkb',
	'TOPKB_USERS'		=> DB_PREFIX.'users_to_topkb',
	'USERS'				=> DB_PREFIX.'users',
	'USERS_ACS'			=> DB_PREFIX.'users_to_acs',
	'USERS_AUTH'		=> DB_PREFIX.'users_to_extauth',
	'USERS_VALID'	 	=> DB_PREFIX.'users_valid',
	'VARS'	 			=> DB_PREFIX.'vars',
	'VARS_RAPIDFIRE'	=> DB_PREFIX.'vars_rapidfire',
	'VARS_REQUIRE'	 	=> DB_PREFIX.'vars_requriements',
);
// MOD-TABLES