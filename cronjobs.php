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

define('MODE', 'CRON');

define('ROOT_PATH', str_replace('\\', '/',dirname(__FILE__)).'/');
require(ROOT_PATH . 'includes/common.php');

if(!$SESSION->IsUserLogin()) exit;

// Output transparent gif
HTTP::sendHeader('Cache-Control', 'no-cache');
HTTP::sendHeader('Content-type', 'image/gif');
HTTP::sendHeader('Content-length', '43');
HTTP::sendHeader('Expires', '0');
echo("\x47\x49\x46\x38\x39\x61\x01\x00\x01\x00\x80\x00\x00\x00\x00\x00\x00\x00\x00\x21\xF9\x04\x01\x00\x00\x00\x00\x2C\x00\x00\x00\x00\x01\x00\x01\x00\x00\x02\x02\x44\x01\x00\x3B");


$cron = HTTP::_GP('cron','');

switch($cron) 
{
	case "stats":
		if (TIMESTAMP >= ($CONF['stat_last_update'] + (60 * $CONF['stat_update_time'])))
		{
			update_config(array('stat_last_update' => TIMESTAMP));
			require_once(ROOT_PATH . 'includes/classes/class.statbuilder.php');
			$stat			= new Statbuilder();
			$result			= $stat->MakeStats();
		}
	break;
	case "daily":
		if (TIMESTAMP >= ($CONF['stat_last_db_update'] + (60 * 60 * 24)))
		{
			// Optimize Database
			update_config(array('stat_last_db_update' => TIMESTAMP));
			$prueba = $GLOBALS['DATABASE']->query("SHOW TABLE STATUS from ".DB_NAME.";");
			$table = "";
			while($pru = $GLOBALS['DATABASE']->fetch_array($prueba)){
				$compprefix = explode("_",$pru["Name"]);  
				
				if($compprefix[0].'_' == DB_PREFIX && $compprefix[1] != 'session')
				{
					$table .= "".$pru["Name"].", ";
				}
			}
			$GLOBALS['DATABASE']->query("OPTIMIZE TABLE ".substr($table, 0, -2).";");
			
			// Clear Cache
			ClearCache();
			
			// Clear old Stuff
			
			
			$del_before 	= TIMESTAMP - ($CONF['del_oldstuff'] * 86400);
			$del_inactive 	= TIMESTAMP - ($CONF['del_user_automatic'] * 86400);
			$del_deleted 	= TIMESTAMP - ($CONF['del_user_manually'] * 86400);

			$GLOBALS['DATABASE']->multi_query("DELETE FROM ".MESSAGES." WHERE message_time < '". $del_before ."';
			DELETE FROM ".ALLIANCE." WHERE ally_members = '0';
			DELETE FROM ".PLANETS." WHERE destruyed < ".TIMESTAMP." AND destruyed != 0;
			DELETE FROM ".SESSION." WHERE lastonline < ".(TIMESTAMP - SESSION_LIFETIME).";
			DELETE FROM ".LOG_FLEETS." WHERE fleet_end_time < ".(TIMESTAMP - FLEETLOG_AGE).";
			UPDATE ".USERS." SET email_2 = email WHERE setmail < ".TIMESTAMP.";
			UPDATE ".USERS." SET banaday = '0', bana = '0' WHERE banaday <= ".TIMESTAMP.";");

			$ChooseToDelete = $GLOBALS['DATABASE']->query("SELECT id FROM ".USERS." WHERE authlevel = '".AUTH_USR."' 
			AND ((db_deaktjava != 0 AND db_deaktjava < '".$del_deleted."')".($del_inactive == TIMESTAMP ? "" : " OR onlinetime < '".$del_inactive."'").");");

			if(isset($ChooseToDelete))
			{
				include_once(ROOT_PATH.'includes/functions/DeleteSelectedUser.php');
				while($delete = $GLOBALS['DATABASE']->fetch_array($ChooseToDelete))
				{
					DeleteSelectedUser($delete['id']);
				}	
			}
			
			$GLOBALS['DATABASE']->free_result($ChooseToDelete);
			
			$Universe	= array($CONF['uni']);
			$Query		= $GLOBALS['DATABASE']->query("SELECT uni FROM ".CONFIG." WHERE uni != '".$CONF['uni']."' ORDER BY uni ASC;");
			while($Uni = $GLOBALS['DATABASE']->fetch_array($Query)) {
				$Universe[]	= $Uni['uni'];
			}
			
			foreach($Universe as $Uni)
			{
				$TopKBLow		= $GLOBALS['DATABASE']->countquery("SELECT units FROM ".TOPKB." WHERE universe = ".$Uni." ORDER BY units DESC LIMIT 99,1;");
				if(isset($TopKBLow)) {
					$GLOBALS['DATABASE']->query("DELETE ".TOPKB.", ".TOPKB_USERS." FROM ".TOPKB." INNER JOIN ".TOPKB_USERS." USING (rid) WHERE universe = ".$Uni." AND units < ".$TopKBLow.";");
				}
			}

			$GLOBALS['DATABASE']->query("DELETE FROM ".RW." WHERE time < ". $del_before ." AND rid NOT IN (SELECT rid FROM ".TOPKB.");");
			
			// Set Bonus for RefLink
			if($CONF['ref_active'] == 1) {
				$Users	= $GLOBALS['DATABASE']->query("SELECT username, ref_id, id, lang FROM ".USERS." WHERE ref_bonus = 1 AND (SELECT total_points FROM ".STATPOINTS." as s WHERE s.id_owner = id AND s.stat_type = '1') >= ".$CONF['ref_minpoints'].";");
				$LANG->setDefault($CONF['lang']);
				while($User	= $GLOBALS['DATABASE']->fetch_array($Users)) {
					$LANG->setUser($User['lang']);	
					$LANG->includeLang(array('INGAME', 'TECH'));
					$GLOBALS['DATABASE']->multi_query("UPDATE ".USERS." SET darkmatter = darkmatter + ".$CONF['ref_bonus']." WHERE id = ".$User['ref_id'].";
													   UPDATE ".USERS." SET ref_bonus = '0' WHERE id = ".$User['id'].";");
					$Message	= sprintf($LNG['sys_refferal_text'], $User['username'], pretty_number($CONF['ref_minpoints']), $CONF['ref_bonus'],$LNG['tech'][921]);
					SendSimpleMessage($User['ref_id'], '', TIMESTAMP, 4, $LNG['sys_refferal_from'], sprintf($LNG['sys_refferal_title'], $User['username']), $Message);
				}
			}
			
			// Send inactive Players Mails
			if($CONF['sendmail_inactive'] == 1 && $CONF['mail_active'] == 1) {
				$Users	= $GLOBALS['DATABASE']->query("SELECT id, username, lang, email, onlinetime FROM ".USERS." WHERE inactive_mail = '0' AND onlinetime < '".(TIMESTAMP - 86400 * $CONF['del_user_sendmail'])."';");
				while($User	= $GLOBALS['DATABASE']->fetch_array($Users)) {
					$LANG->setUser($User['lang']);	
					$LANG->includeLang(array('L18N', 'INGAME', 'PUBLIC'));
					$MailSubject	= sprintf($LNG['reg_mail_reg_done'], $CONF['game_name']);
					$MailRAW		= file_get_contents("./language/".$User['lang']."/email/email_inactive.txt");
					$MailContent	= sprintf($MailRAW, $User['username'], $CONF['game_name'].' - '.$CONF['uni_name'], date($LNG['php_tdformat'], $User['onlinetime']), PROTOCOL.$_SERVER['HTTP_HOST'].HTTP_ROOT);	
					MailSend($User['email'], $User['username'], $MailSubject, $MailContent);
					$GLOBALS['DATABASE']->query("UPDATE ".USERS." SET inactive_mail = '1' WHERE id = '".$User['id']."';");
				}
			}
			
			// Backup Database
			if(ENABLE_DATABASE_BACKUP && function_exists('shell_exec') && strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
				shell_exec("mysqldump -h ".$database['host']." --user=".$database['user']." --password=".$database['userpw']." ".$database['databasename']." > ".STORAGE_BACKUP_TO_DIR.date("d.m.Y")."_backup.sql");
			}
		}
	break;
	case "teamspeak":
		if ($CONF['ts_modon'] == 1 && TIMESTAMP >= ($CONF['ts_cron_last'] + 60 * $CONF['ts_cron_interval']))
		{
			update_config(array('ts_cron_last' => TIMESTAMP));
			if($CONF['ts_version'] == 2)
			{
				include_once(ROOT_PATH.'includes/libs/teamspeak/class.teamspeak2.php');
				$ts = new cyts();
				if($ts->connect($CONF['ts_server'], $CONF['ts_tcpport'], $CONF['ts_udpport'], $CONF['ts_timeout'])) {
					file_put_contents(ROOT_PATH.'cache/teamspeak_cache.php', serialize(array($ts->info_serverInfo(), $ts->info_globalInfo())));
					$ts->disconnect();
				}
			} elseif($CONF['ts_version'] == 3){
				require_once(ROOT_PATH . "includes/libs/teamspeak/class.teamspeak3.php");
				$tsAdmin 	= new ts3admin($CONF['ts_server'], $CONF['ts_udpport'], $CONF['ts_timeout']);
				$Active		= $tsAdmin->connect();
				if($Active['success']) {
					$tsAdmin->selectServer($CONF['ts_tcpport'], 'port', true);
					$tsAdmin->login($CONF['ts_login'], $CONF['ts_password']);
					file_put_contents(ROOT_PATH.'cache/teamspeak_cache.php', serialize($tsAdmin->serverInfo()));
					$tsAdmin->logout();
				}
			}
		}
	break;
}
?>