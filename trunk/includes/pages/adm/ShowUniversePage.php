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
 * @version 1.3 (2011-01-21)
 * @link http://code.google.com/p/2moons/
 */

if ($USER['authlevel'] != AUTH_ADM || $_GET['sid'] != session_id()) exit;
@set_time_limit(0);

function ShowUniversePage() {
	global $CONF, $LNG, $db, $UNI, $USER;
	$template	= new template();

	if($_REQUEST['action'] == 'delete' && !empty($_REQUEST['id']) && $_REQUEST['id'] != 1) {
		$ID	= (int) $_REQUEST['id'];
		if($UNI != $ID){
			$db->multi_query("DELETE FROM ".ALLIANCE." WHERE `ally_universe` = ".$ID.";
			DELETE FROM ".BANNED." WHERE `universe` = ".$ID.";
			DELETE FROM ".BUDDY." WHERE `universe` = ".$ID.";
			DELETE FROM ".CONFIG." WHERE `uni` = ".$ID.";
			DELETE FROM ".DIPLO." WHERE `universe` = ".$ID.";
			DELETE FROM ".FLEETS." WHERE `fleet_universe` = ".$ID.";
			DELETE FROM ".MESSAGES." WHERE `message_universe` = ".$ID.";
			DELETE FROM ".NOTES." WHERE `universe` = ".$ID.";
			DELETE FROM ".PLANETS." WHERE `universe` = ".$ID.";
			DELETE FROM ".STATPOINTS." WHERE `universe` = ".$ID.";
			DELETE FROM ".SUPP." WHERE `universe` = ".$ID.";
			DELETE FROM ".TOPKB." WHERE `universe` = ".$ID.";
			DELETE FROM ".USERS." WHERE `universe` = ".$ID.";
			DELETE FROM ".USERS_VALID." WHERE `universe` = ".$ID.";");	
			if($_SESSION['adminuni'] == $ID)
				$_SESSION['adminuni']	= $UNI;
		}
	} elseif($_REQUEST['action'] == 'create') {
		$ID	= (int) $_REQUEST['id'];
		$db->query("INSERT INTO `uni1_config` (`uni`, `VERSION`, `uni_name`, `game_name`, `close_reason`, `OverviewNewsText`) VALUES
		(NULL, '".$CONF['VERSION']."', 'Universum 2', '".$CONF['game_name']."', '', '');");
		$UniID	= $db->GetInsertID();;
		update_config(array('VERSION' => $CONF['VERSION'],
			'game_name' => $CONF['game_name'],
			'stat' => $CONF['stat'],
			'stat_level' => $CONF['stat_level'],
			'stat_last_update' => $CONF['stat_last_update'],
			'stat_settings' => $CONF['stat_settings'],
			'stat_update_time' => $CONF['stat_update_time'],
			'stat_last_db_update' => $CONF['stat_last_db_update'],
			'stats_fly_lock' => $CONF['stats_fly_lock'],
			'cron_lock' => $CONF['cron_lock'],
			'ts_modon' => $CONF['ts_modon'],
			'ts_server' => $CONF['ts_server'],
			'ts_tcpport' => $CONF['ts_tcpport'],
			'ts_udpport' => $CONF['ts_udpport'],
			'ts_timeout' => $CONF['ts_timeout'],
			'ts_version' => $CONF['ts_version'],
			'ts_cron_last' => $CONF['ts_cron_last'],
			'ts_cron_interval' => $CONF['ts_cron_interval'],
			'ts_login' => $CONF['ts_login'],
			'ts_password' => $CONF['ts_password'],
			'capaktiv' => $CONF['capaktiv'],
			'cappublic' => $CONF['cappublic'],
			'capprivate' => $CONF['capprivate'],
			'mail_active' => $CONF['mail_active'],
			'mail_use' => $CONF['mail_use'],
			'smtp_host' => $CONF['smtp_host'],
			'smtp_port' => $CONF['smtp_port'],
			'smtp_user' => $CONF['smtp_user'],
			'smtp_pass' => $CONF['smtp_pass'],
			'smtp_ssl' => $CONF['smtp_ssl'],
			'smtp_sendmail' => $CONF['smtp_sendmail'],
			'smail_path' => $CONF['smail_path'],
			'fb_on' => $CONF['fb_on'],
			'fb_apikey' => $CONF['fb_apikey'],
			'fb_skey' => $CONF['fb_skey'],
			'ga_active' => $CONF['ga_active'],
			'ga_key' => $CONF['ga_key'],
			'chat_closed' => $CONF['chat_closed'],
			'chat_allowchan' => $CONF['chat_allowchan'],
			'chat_allowmes' => $CONF['chat_allowmes'],
			'chat_allowdelmes' => $CONF['chat_allowdelmes'],
			'chat_logmessage' => $CONF['chat_logmessage'],
			'chat_nickchange' => $CONF['chat_nickchange'],
			'chat_botname' => $CONF['chat_botname'],
			'chat_channelname' => $CONF['chat_channelname'],
			'chat_socket_active' => $CONF['chat_socket_active'],
			'chat_socket_host' => $CONF['chat_socket_host'],
			'chat_socket_ip' => $CONF['chat_socket_ip'],
			'chat_socket_port' => $CONF['chat_socket_port'],
			'chat_socket_chatid' => $CONF['chat_socket_chatid'],
			'ttf_file' => $CONF['ttf_file']
		));
		$db->query("INSERT INTO ".USERS." SET
			`id`                = NULL,
			`username`          = '".$USER['username']."',
			`email`             = '".$USER['email']."',
			`email_2`           = '".$USER['email']."',
			`ip_at_reg`         = '".$_SERVER['REMOTE_ADDR']."',
			`authlevel`         = '".AUTH_ADM."',
			`rights` 			= '".serialize($USER['rights'])."',
			`universe`          = '".$UniID."',
			`galaxy`            = '1',
			`system`            = '1',
			`planet`            = '1',
			`register_time`     = '".TIMESTAMP."',
			`onlinetime`        = '".TIMESTAMP."',
			`password`          = '".$USER['password']."';");
		$UserID	= $db->countquery("SELECT `id` FROM ".USERS." WHERE `universe` = '".$UniID."';");
		$db->query("INSERT INTO ".PLANETS." SET
			`id_owner`          = '".$UserID."',
			`universe`          = '".$UniID."',
			`galaxy`            = '1',
			`system`            = '1',
			`name`              = 'Hauptplanet',
			`planet`            = '1',
			`last_update`       = '".TIMESTAMP."',
			`planet_type`       = '1',
			`image`             = 'normaltempplanet02',
			`diameter`          = '12750',
			`field_max`         = '163',
			`temp_min`          = '47',
			`temp_max`          = '87',
			`metal`             = '500',
			`metal_perhour`     = '0',
			`metal_max`         = '1000000',
			`crystal`           = '500',
			`crystal_perhour`   = '0',
			`crystal_max`       = '1000000',
			`deuterium`         = '500',
			`deuterium_perhour` = '0',
			`deuterium_max`     = '1000000';");	
		$PlanetID	= $db->countquery("SELECT `id` FROM ".PLANETS." WHERE `universe` = '".$UniID."';");
		$db->query("UPDATE ".USERS." SET `id_planet` = '".$PlanetID."' WHERE `id` = '".$UserID."';");
		$db->query("INSERT INTO ".STATPOINTS." (`id_owner`, `id_ally`, `stat_type`, `universe`, `tech_rank`, `tech_old_rank`, `tech_points`, `tech_count`, `build_rank`, `build_old_rank`, `build_points`, `build_count`, `defs_rank`, `defs_old_rank`, `defs_points`, `defs_count`, `fleet_rank`, `fleet_old_rank`, `fleet_points`, `fleet_count`, `total_rank`, `total_old_rank`, `total_points`, `total_count`) VALUES ('".$UserID."', '0', '1', '".$UniID."', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');");
		update_config(array('users_amount' => 1), $UniID);
	} elseif($_REQUEST['action'] == 'download' && !empty($_REQUEST['id'])) {
		header("Content-type: application/force-download");
		header("Content-Transfer-Encoding: Binary");
		
		$Backup	= serialize(array(
			'AKS'			=> $db->fetchquery("SELECT * FROM ".AKS.";"),
			'ALLIANCE'		=> $db->fetchquery("SELECT * FROM ".ALLIANCE." WHERE `ally_universe` = ".$_REQUEST['id'].";", array('ally_description', 'ally_text', 'ally_request', 'ally_request_waiting')),
			'BANNED'		=> $db->fetchquery("SELECT * FROM ".BANNED." WHERE `universe` = ".$_REQUEST['id'].";", array('theme')),
			'BUDDY'			=> $db->fetchquery("SELECT * FROM ".BUDDY." WHERE `universe` = ".$_REQUEST['id'].";", array('text')),
			'CHAT'			=> $db->fetchquery("SELECT * FROM ".CHAT." WHERE `universe` = ".$_REQUEST['id'].";", array('message')),
			'CONFIG'		=> $db->fetchquery("SELECT * FROM ".CONFIG." WHERE `uni` = ".$_REQUEST['id'].";", array('close_reason', 'OverviewNewsText')),
			'DIPLO'			=> $db->fetchquery("SELECT * FROM ".DIPLO." WHERE `universe` = ".$_REQUEST['id'].";", array('accept_text')),
			'FLEETS'		=> $db->fetchquery("SELECT * FROM ".FLEETS." WHERE `fleet_universe` = ".$_REQUEST['id'].";"),
			'MESSAGES'		=> $db->fetchquery("SELECT * FROM ".MESSAGES." WHERE `message_universe` = ".$_REQUEST['id'].";", array('message_text')),
			'NOTES'			=> $db->fetchquery("SELECT * FROM ".NOTES." WHERE `universe` = ".$_REQUEST['id'].";", array('text')),
			'PLANETS'		=> $db->fetchquery("SELECT * FROM ".PLANETS." WHERE `universe` = ".$_REQUEST['id'].";"),
			'STATPOINTS'	=> $db->fetchquery("SELECT * FROM ".STATPOINTS." WHERE `universe` = ".$_REQUEST['id'].";"),
			'SUPP'			=> $db->fetchquery("SELECT * FROM ".SUPP." WHERE `universe` = ".$_REQUEST['id'].";", array('text')),
			'TOPKB'			=> $db->fetchquery("SELECT * FROM ".TOPKB." WHERE `universe` = ".$_REQUEST['id'].";"),
			'USERS'			=> $db->fetchquery("SELECT * FROM ".USERS." WHERE `universe` = ".$_REQUEST['id'].";", array('fleet_shortcut')),
			'USERS_VALID'	=> $db->fetchquery("SELECT * FROM ".USERS_VALID." WHERE `universe` = ".$_REQUEST['id'].";"),
		));
		
		$File	= gzdeflate($Backup); 		
		header("Content-length: ".strlen($File));
		header("Content-Disposition: attachment; filename=Uni_".$_REQUEST['id']."_".date('d.m.y').".2moons");
		echo $File;
		exit;
	} elseif ($_REQUEST['action'] == 'import' && isset($_FILES['file']['tmp_name'])) {
		$Data	= unserialize(gzinflate(file_get_contents($_FILES['file']['tmp_name'])));
		
		if(!isset($Data) || !is_array($Data) || empty($Data)) {
			$template->message($LNG['uvs_error'], '?page=universe&sid='.session_id(), 5);
			exit;
		}
		$TABLES	= $db->query("SHOW TABLE STATUS WHERE Name like '".DB_PREFIX."_%';");
		$TABLEINFO	= array();
		while($TABLE = $db->fetch_array($TABLES))
			$TABLEINFO[$TABLE['Name']]	= $TABLE['Auto_increment'] - 1;
	
		$db->free_result($TABLES);
		$Rows	= 0;
		$SQL	= "INSERT INTO ".AKS." (`id`, `name`, `teilnehmer`, `ankunft`, `galaxy`, `system`, `planet`, `planet_type`, `eingeladen`) VALUES ";
		foreach($Data['AKS'] as $Key => $Row)
		{
			$Data['AKS'][$Key]['id']			= $Row['id'] + $TABLEINFO[AKS];
			$Data['AKS'][$Key]['teilnehmer']	= $Row['teilnehmer'] + $TABLEINFO[USERS];
			$Data['AKS'][$Key]['eingeladen']	= array();
			$Temp	= explode(',', $Row['eingeladen']);
			foreach($Temp as $ID) {
				$Data['AKS'][$Key]['eingeladen'][]	= $ID + $TABLEINFO[USERS];
			}
			$Data['AKS'][$Key]['eingeladen']	= implode(',', $Data['AKS'][$Key]['eingeladen']);
			$SQL	.= "(";
			foreach($Data['AKS'][$Key] as $Value)
				$SQL	.= "'".$Value."', ";
			$SQL	= substr($SQL, 0, -2)."),";
			$Rows	= 1;
		}
		if($Rows == 1)
			$db->query(substr($SQL, 0, -1).';');
		$Rows	= 0;
		
		$SQL = "INSERT INTO ".ALLIANCE." (`id`, `ally_name`, `ally_tag`, `ally_owner`, `ally_register_time`, `ally_description`, `ally_web`, `ally_text`, `ally_image`, `ally_request`, `ally_request_waiting`, `ally_request_notallow`, `ally_owner_range`, `ally_ranks`, `ally_members`, `ally_stats`, `ally_diplo`, `ally_universe`) VALUES ";
		foreach($Data['ALLIANCE'] as $Key => $Row)
		{
			$Data['ALLIANCE'][$Key]['id']					= $Row['id'] + $TABLEINFO[ALLIANCE];
			$Data['ALLIANCE'][$Key]['ally_owner']			= $Row['ally_owner'] + $TABLEINFO[USERS];
			$Data['ALLIANCE'][$Key]['ally_universe']		= $TABLEINFO[CONFIG] + 1;
			$Data['ALLIANCE'][$Key]['ally_description']		= base64_decode($Row['ally_description']);
			$Data['ALLIANCE'][$Key]['ally_text']			= base64_decode($Row['ally_text']);
			$Data['ALLIANCE'][$Key]['ally_request']			= base64_decode($Row['ally_request']);
			$Data['ALLIANCE'][$Key]['ally_request_waiting']	= base64_decode($Row['ally_request_waiting']);
			$SQL	.= "(";
			foreach($Data['ALLIANCE'][$Key] as $Value)
				$SQL	.= "'".$Value."', ";
			$SQL	= substr($SQL, 0, -2)."),";
			$Rows	= 1;
		}
		if($Rows == 1)
			$db->query(substr($SQL, 0, -1).';');
		$Rows	= 0;
		
		$SQL = "INSERT INTO ".BANNED." (`id`, `who`, `theme`, `who2`, `time`, `longer`, `author`, `email`, `universe`) VALUES ";
		foreach($Data['BANNED'] as $Key => $Row)
		{
			$Data['BANNED'][$Key]['id']			= $Row['id'] + $TABLEINFO[BANNED];
			$Data['BANNED'][$Key]['theme']		= base64_decode($Row['theme']);
			$Data['BANNED'][$Key]['universe']		= $TABLEINFO[CONFIG] + 1;
			$SQL	.= "(";
			foreach($Data['BANNED'][$Key] as $Value)
				$SQL	.= "'".$Value."', ";
			$SQL	= substr($SQL, 0, -2)."),";
			$Rows	= 1;
		}
		if($Rows == 1)
			$db->query(substr($SQL, 0, -1).';');
		$Rows	= 0;
		
		$SQL = "INSERT INTO ".BUDDY." (`id`, `sender`, `owner`, `active`, `text`, `universe`) VALUES ";

		foreach($Data['BUDDY'] as $Key => $Row)
		{
			$Data['BUDDY'][$Key]['id']			= $Row['id'] + $TABLEINFO[BUDDY];
			$Data['BUDDY'][$Key]['sender']		= $Row['sender'] + $TABLEINFO[USERS];
			$Data['BUDDY'][$Key]['owner']		= $Row['owner'] + $TABLEINFO[USERS];
			$Data['BUDDY'][$Key]['text']		= base64_decode($Row['text']);
			$Data['BUDDY'][$Key]['universe']	= $TABLEINFO[CONFIG] + 1;
			$SQL	.= "(";
			foreach($Data['BUDDY'][$Key] as $Value)
				$SQL	.= "'".$Value."', ";
			$SQL	= substr($SQL, 0, -2)."),";
			$Rows	= 1;
		}
		if($Rows == 1)
			$db->query(substr($SQL, 0, -1).';');
		$Rows	= 0;
		
		$SQL = "INSERT INTO ".CHAT." (`messageid`, `user`, `message`, `timestamp`, `ally_id`, `universe`) VALUES ";
		foreach($Data['CHAT'] as $Key => $Row)
		{
			$Data['CHAT'][$Key]['messageid']	= $Row['messageid'] + $TABLEINFO[CHAT];
			$Data['CHAT'][$Key]['message']		= base64_decode($Row['message']);
			$Data['CHAT'][$Key]['ally_id']		= $Row['ally_id'] + $TABLEINFO[ALLIANCE];
			$Data['CHAT'][$Key]['universe']		= $TABLEINFO[CONFIG] + 1;
			$SQL	.= "(";
			foreach($Data['CHAT'][$Key] as $Value)
				$SQL	.= "'".$Value."', ";
			$SQL	= substr($SQL, 0, -2)."),";
			$Rows	= 1;
		}
		if($Rows == 1)
			$db->query(substr($SQL, 0, -1).';');
		$Rows	= 0;
		
		$SQL = "INSERT INTO ".CONFIG." (`uni`, `VERSION`, `users_amount`, `game_speed`, `fleet_speed`, `resource_multiplier`, `halt_speed`, `Fleet_Cdr`, `Defs_Cdr`, `initial_fields`, `bgm_active`, `bgm_file`, `uni_name`, `game_name`, `game_disable`, `close_reason`, `metal_basic_income`, `crystal_basic_income`, `deuterium_basic_income`, `energy_basic_income`, `LastSettedGalaxyPos`, `LastSettedSystemPos`, `LastSettedPlanetPos`, `noobprotection`, `noobprotectiontime`, `noobprotectionmulti`, `forum_url`, `adm_attack`, `debug`, `lang`, `stat`, `stat_level`, `stat_last_update`, `stat_settings`, `stat_update_time`, `stat_last_db_update`, `stats_fly_lock`, `stat_last_banner_update`, `stat_banner_update_time`, `cron_lock`, `ts_modon`, `ts_server`, `ts_tcpport`, `ts_udpport`, `ts_timeout`, `ts_version`, `ts_cron_last`, `ts_cron_interval`, `ts_login`, `ts_password`, `reg_closed`, `OverviewNewsFrame`, `OverviewNewsText`, `capaktiv`, `cappublic`, `capprivate`, `min_build_time`, `smtp_host`, `smtp_port`, `smtp_user`, `smtp_pass`, `smtp_ssl`, `smtp_sendmail`, `user_valid`, `fb_on`, `fb_apikey`, `fb_skey`, `ga_active`, `ga_key`, `moduls`, `trade_allowed_ships`, `trade_charge`, `mail_active`, `mail_use`, `smail_path`, `chat_closed`, `chat_allowchan`, `chat_allowmes`, `chat_allowdelmes`, `chat_logmessage`, `chat_nickchange`, `chat_botname`, `chat_channelname`, `chat_socket_chatid`, `chat_socket_port`, `chat_socket_ip`, `chat_socket_host`, `chat_socket_active`) VALUES ";
		foreach($Data['CONFIG'] as $Key => $Row)
		{
			$Data['CONFIG'][$Key]['uni']						= $TABLEINFO[CONFIG] + 1;
			$Data['CONFIG'][$Key]['VERSION']					= $CONF['VERSION'];
			$Data['CONFIG'][$Key]['bgm_active']					= $CONF['bgm_active'];
			$Data['CONFIG'][$Key]['uni_name']					= $Data['CONFIG'][$Key]['game_name'];
			$Data['CONFIG'][$Key]['game_name']					= $CONF['game_name'];
			$Data['CONFIG'][$Key]['bgm_file']					= $CONF['bgm_file'];
			$Data['CONFIG'][$Key]['forum_url']					= $CONF['forum_url'];
			$Data['CONFIG'][$Key]['lang']						= $CONF['lang'];
			$Data['CONFIG'][$Key]['stat']						= $CONF['stat'];
			$Data['CONFIG'][$Key]['stat_level']					= $CONF['stat_level'];
			$Data['CONFIG'][$Key]['stat_last_update']			= $CONF['stat_last_update'];
			$Data['CONFIG'][$Key]['stat_settings']				= $CONF['stat_settings'];
			$Data['CONFIG'][$Key]['stat_update_time']			= $CONF['stat_update_time'];
			$Data['CONFIG'][$Key]['stat_last_db_update']		= $CONF['stat_last_db_update'];
			$Data['CONFIG'][$Key]['stats_fly_lock']				= $CONF['stats_fly_lock'];
			$Data['CONFIG'][$Key]['stat_last_banner_update']	= $CONF['stat_last_banner_update'];
			$Data['CONFIG'][$Key]['stat_banner_update_time']	= $CONF['stat_banner_update_time'];
			$Data['CONFIG'][$Key]['ts_modon']					= $CONF['ts_modon'];
			$Data['CONFIG'][$Key]['ts_server']					= $CONF['ts_server'];
			$Data['CONFIG'][$Key]['ts_tcpport']					= $CONF['ts_tcpport'];
			$Data['CONFIG'][$Key]['ts_udpport']					= $CONF['ts_udpport'];
			$Data['CONFIG'][$Key]['ts_timeout']					= $CONF['ts_timeout'];
			$Data['CONFIG'][$Key]['ts_version']					= $CONF['ts_version'];
			$Data['CONFIG'][$Key]['ts_cron_last']				= $CONF['ts_cron_last'];
			$Data['CONFIG'][$Key]['ts_cron_interval']			= $CONF['ts_cron_interval'];
			$Data['CONFIG'][$Key]['ts_login']					= $CONF['ts_login'];
			$Data['CONFIG'][$Key]['ts_password']				= $CONF['ts_password'];
			$Data['CONFIG'][$Key]['capaktiv']					= $CONF['capaktiv'];
			$Data['CONFIG'][$Key]['cappublic']					= $CONF['cappublic'];
			$Data['CONFIG'][$Key]['capprivate']					= $CONF['capprivate'];
			$Data['CONFIG'][$Key]['mail_active']				= $CONF['mail_active'];
			$Data['CONFIG'][$Key]['smail_path']					= $CONF['smail_path'];
			$Data['CONFIG'][$Key]['mail_use']					= $CONF['mail_use'];
			$Data['CONFIG'][$Key]['smtp_host']					= $CONF['smtp_host'];
			$Data['CONFIG'][$Key]['smtp_port']					= $CONF['smtp_port'];
			$Data['CONFIG'][$Key]['smtp_user']					= $CONF['smtp_user'];
			$Data['CONFIG'][$Key]['smtp_pass']					= $CONF['smtp_pass'];
			$Data['CONFIG'][$Key]['smtp_ssl']					= $CONF['smtp_ssl'];
			$Data['CONFIG'][$Key]['smtp_sendmail']				= $CONF['smtp_sendmail'];
			$Data['CONFIG'][$Key]['user_valid']					= $CONF['user_valid'];
			$Data['CONFIG'][$Key]['fb_on']						= $CONF['fb_on'];
			$Data['CONFIG'][$Key]['fb_apikey']					= $CONF['fb_apikey'];
			$Data['CONFIG'][$Key]['fb_skey']					= $CONF['fb_skey'];
			$Data['CONFIG'][$Key]['ga_active']					= $CONF['ga_active'];
			$Data['CONFIG'][$Key]['ga_key']						= $CONF['ga_key'];
			$Data['CONFIG'][$Key]['chat_closed']				= $CONF['chat_closed'];
			$Data['CONFIG'][$Key]['chat_allowchan']				= $CONF['chat_allowchan'];
			$Data['CONFIG'][$Key]['chat_allowmes']				= $CONF['chat_allowmes'];
			$Data['CONFIG'][$Key]['chat_allowdelmes']			= $CONF['chat_allowdelmes'];
			$Data['CONFIG'][$Key]['chat_logmessage']			= $CONF['chat_logmessage'];
			$Data['CONFIG'][$Key]['chat_nickchange']			= $CONF['chat_nickchange'];
			$Data['CONFIG'][$Key]['chat_botname']				= $CONF['chat_botname'];
			$Data['CONFIG'][$Key]['chat_channelname']			= $CONF['chat_channelname'];
			$Data['CONFIG'][$Key]['chat_socket_chatid']			= $CONF['chat_socket_chatid'];
			$Data['CONFIG'][$Key]['chat_socket_port']			= $CONF['chat_socket_port'];
			$Data['CONFIG'][$Key]['chat_socket_ip']				= $CONF['chat_socket_ip'];
			$Data['CONFIG'][$Key]['chat_socket_host']			= $CONF['chat_socket_host'];
			$Data['CONFIG'][$Key]['chat_socket_active']			= $CONF['chat_socket_active'];
			$Data['CONFIG'][$Key]['close_reason']				= base64_decode($Row['close_reason']);
			$Data['CONFIG'][$Key]['OverviewNewsText']			= base64_decode($Row['OverviewNewsText']);
			
			unset($Data['CONFIG'][$Key]['ftp_server']);
			unset($Data['CONFIG'][$Key]['ftp_user_name']);
			unset($Data['CONFIG'][$Key]['ftp_user_pass']);
			unset($Data['CONFIG'][$Key]['ftp_root_path']);
			
			$SQL	.= "(";
			foreach($Data['CONFIG'][$Key] as $Value)
				$SQL	.= "'".$Value."', ";
			$SQL	= substr($SQL, 0, -2)."),";
			$Rows	= 1;
		}
		if($Rows == 1)
			$db->query(substr($SQL, 0, -1).';');
		$Rows	= 0;
		
		$SQL = "INSERT INTO ".DIPLO." (`id`, `owner_1`, `owner_2`, `level`, `accept`, `accept_text`) VALUES ";
		foreach($Data['DIPLO'] as $Key => $Row)
		{
			$Data['DIPLO'][$Key]['id']			= $Row['id'] + $TABLEINFO[DIPLO];
			$Data['DIPLO'][$Key]['owner_1']		= $Row['owner_1'] + $TABLEINFO[USERS];
			$Data['DIPLO'][$Key]['owner_2']		= $Row['owner_2'] + $TABLEINFO[USERS];
			$Data['DIPLO'][$Key]['accept_text']	= base64_decode($Row['accept_text']);
			$Data['DIPLO'][$Key]['universe']	= $TABLEINFO[CONFIG] + 1;
			$SQL	.= "(";
			foreach($Data['DIPLO'][$Key] as $Value)
				$SQL	.= "'".$Value."', ";
			$SQL	= substr($SQL, 0, -2)."),";
			$Rows	= 1;
		}
		if($Rows == 1)
			$db->query(substr($SQL, 0, -1).';');
		$Rows	= 0;
		
		$SQL = "INSERT INTO ".FLEETS." (`fleet_id`, `fleet_owner`, `fleet_mission`, `fleet_amount`, `fleet_array`, `fleet_universe`, `fleet_start_time`, `fleet_start_id`, `fleet_start_galaxy`, `fleet_start_system`, `fleet_start_planet`, `fleet_start_type`, `fleet_end_time`, `fleet_end_stay`, `fleet_end_id`, `fleet_end_galaxy`, `fleet_end_system`, `fleet_end_planet`, `fleet_end_type`, `fleet_target_obj`, `fleet_resource_metal`, `fleet_resource_crystal`, `fleet_resource_deuterium`, `fleet_resource_darkmatter`, `fleet_target_owner`, `fleet_group`, `fleet_mess`, `start_time`, `fleet_busy`) VALUES ";
		foreach($Data['FLEETS'] as $Key => $Row)
		{
	 		$Data['FLEETS'][$Key]['fleet_id']			= $Row['fleet_id'] + $TABLEINFO[FLEETS];
			$Data['FLEETS'][$Key]['fleet_owner']		= $Row['fleet_owner'] + $TABLEINFO[USERS];
			$Data['FLEETS'][$Key]['fleet_start_id']		= $Row['fleet_start_id'] + $TABLEINFO[PLANETS];
			$Data['FLEETS'][$Key]['fleet_end_id']		= $Row['fleet_end_id'] + $TABLEINFO[PLANETS];
			$Data['FLEETS'][$Key]['fleet_target_owner']	= $Row['fleet_target_owner'] + $TABLEINFO[USERS];
			$Data['FLEETS'][$Key]['fleet_group']		= $Row['fleet_group'] + $TABLEINFO[PLANETS];
			$Data['FLEETS'][$Key]['fleet_universe']		= $TABLEINFO[CONFIG] + 1;
			$SQL	.= "(";
			foreach($Data['FLEETS'][$Key] as $Value)
				$SQL	.= "'".$Value."', ";
			$SQL	= substr($SQL, 0, -2)."),";
			$Rows	= 1;
		}
		if($Rows == 1)
			$db->query(substr($SQL, 0, -1).';');
		$Rows	= 0;
		
		$SQL = "INSERT INTO ".MESSAGES." (`message_id`, `message_owner`, `message_sender`, `message_time`, `message_type`, `message_from`, `message_subject`, `message_text`, `message_unread`, `message_universe`) VALUES ";
		foreach($Data['MESSAGES'] as $Key => $Row)
		{
	 		$Data['MESSAGES'][$Key]['message_id']		= $Row['message_id'] + $TABLEINFO[MESSAGES];
			if($Row['message_owner'] != 0)
				$Data['MESSAGES'][$Key]['message_owner']	= $Row['message_owner'] + $TABLEINFO[USERS];
			if($Row['message_sender'] != 0)
				$Data['MESSAGES'][$Key]['message_sender']	= $Row['message_sender'] + $TABLEINFO[USERS];
			
			$Data['MESSAGES'][$Key]['message_text']		= base64_decode($Row['message_text']);
			$Data['MESSAGES'][$Key]['message_universe']	= $TABLEINFO[CONFIG] + 1;
			$SQL	.= "(";
			foreach($Data['MESSAGES'][$Key] as $Value)
				$SQL	.= "'".$Value."', ";
			$SQL	= substr($SQL, 0, -2)."),";
			$Rows	= 1;
		}
		if($Rows == 1)
			$db->query(substr($SQL, 0, -1).';');
		$Rows	= 0;
		
		$SQL = "INSERT INTO ".NOTES." (`id`, `owner`, `time`, `priority`, `title`, `text`, `universe`) VALUES ";
		foreach($Data['NOTES'] as $Key => $Row)
		{
	 		$Data['NOTES'][$Key]['id']			= $Row['id'] + $TABLEINFO[NOTES];
	 		$Data['NOTES'][$Key]['owner']		= $Row['owner'] + $TABLEINFO[USERS];
			$Data['NOTES'][$Key]['text']		= base64_decode($Row['text']);
			$Data['NOTES'][$Key]['universe']	= $TABLEINFO[CONFIG] + 1;
			$SQL	.= "(";
			foreach($Data['NOTES'][$Key] as $Value)
				$SQL	.= "'".$Value."', ";
			$SQL	= substr($SQL, 0, -2)."),";
			$Rows	= 1;
		}
		if($Rows == 1)
			$db->query(substr($SQL, 0, -1).';');
		$Rows	= 0;
		
		$SQL = "INSERT INTO ".PLANETS." (`id`, `name`, `id_owner`, `universe`, `galaxy`, `system`, `planet`, `last_update`, `planet_type`, `destruyed`, `b_building`, `b_building_id`, `b_hangar`, `b_hangar_id`, `b_hangar_plus`, `image`, `diameter`, `field_current`, `field_max`, `temp_min`, `temp_max`, `metal`, `metal_perhour`, `metal_max`, `crystal`, `crystal_perhour`, `crystal_max`, `deuterium`, `deuterium_used`, `deuterium_perhour`, `deuterium_max`, `energy_used`, `energy_max`, `metal_mine`, `crystal_mine`, `deuterium_sintetizer`, `solar_plant`, `fusion_plant`, `robot_factory`, `nano_factory`, `hangar`, `metal_store`, `crystal_store`, `deuterium_store`, `laboratory`, `terraformer`, `university`, `ally_deposit`, `silo`, `small_ship_cargo`, `big_ship_cargo`, `light_hunter`, `heavy_hunter`, `crusher`, `battle_ship`, `colonizer`, `recycler`, `spy_sonde`, `bomber_ship`, `solar_satelit`, `destructor`, `dearth_star`, `battleship`, `supernova`, `bahamut`, `starcatcher`, `ifrit`, `shiva`, `catoblepas`, `oxion`, `odin`, `orbital_station`, `misil_launcher`, `small_laser`, `big_laser`, `gauss_canyon`, `ionic_canyon`, `buster_canyon`, `small_protection_shield`, `planet_protector`, `big_protection_shield`, `graviton_canyon`, `interceptor_misil`, `interplanetary_misil`, `metal_mine_porcent`, `crystal_mine_porcent`, `deuterium_sintetizer_porcent`, `solar_plant_porcent`, `fusion_plant_porcent`, `solar_satelit_porcent`, `mondbasis`, `phalanx`, `sprungtor`, `last_jump_time`, `lune_noir`, `ev_transporter`, `star_crasher`, `giga_recykler`, `dm_ship`, `der_metal`, `der_crystal`, `thriller`, `id_luna`) VALUES ";
		foreach($Data['PLANETS'] as $Key => $Row)
		{
	 		$Data['PLANETS'][$Key]['id']		= $Row['id'] + $TABLEINFO[PLANETS];
	 		$Data['PLANETS'][$Key]['id_owner']	= $Row['id_owner'] + $TABLEINFO[USERS];
			if($Row['id_luna'] != 0)
				$Data['PLANETS'][$Key]['id_luna']	= $Row['id_luna'] + $TABLEINFO[PLANETS];
			$Data['PLANETS'][$Key]['universe']	= $TABLEINFO[CONFIG] + 1;
			$SQL	.= "(";
			foreach($Data['PLANETS'][$Key] as $Value)
				$SQL	.= "'".$Value."', ";
			$SQL	= substr($SQL, 0, -2)."),";
			$Rows	= 1;
		}
		if($Rows == 1)
			$db->query(substr($SQL, 0, -1).';');
		$Rows	= 0;
		
		$SQL = "INSERT INTO ".STATPOINTS." (`id_owner`, `id_ally`, `stat_type`, `universe`, `tech_rank`, `tech_old_rank`, `tech_points`, `tech_count`, `build_rank`, `build_old_rank`, `build_points`, `build_count`, `defs_rank`, `defs_old_rank`, `defs_points`, `defs_count`, `fleet_rank`, `fleet_old_rank`, `fleet_points`, `fleet_count`, `total_rank`, `total_old_rank`, `total_points`, `total_count`) VALUES ";
		foreach($Data['STATPOINTS'] as $Key => $Row)
		{
	 		$Data['STATPOINTS'][$Key]['id_owner']	= $Row['id_owner'] + $TABLEINFO[USERS];
	 		$Data['STATPOINTS'][$Key]['id_ally']	= $Row['id_ally'] + $TABLEINFO[ALLIANCE];
			$Data['STATPOINTS'][$Key]['universe']	= $TABLEINFO[CONFIG] + 1;
			$SQL	.= "(";
			foreach($Data['STATPOINTS'][$Key] as $Value)
				$SQL	.= "'".$Value."', ";
			$SQL	= substr($SQL, 0, -2)."),";
			$Rows	= 1;
		}
		if($Rows == 1)
			$db->query(substr($SQL, 0, -1).';');
		$Rows	= 0;
			
		$SQL = "INSERT INTO ".SUPPORT." (`ID`, `player_id`, `time`, `subject`, `text`, `status`, `universe`) VALUES ";
		foreach($Data['SUPP'] as $Key => $Row)
		{
	 		$Data['SUPP'][$Key]['ID']			= $Row['ID'] + $TABLEINFO[SUPP];
	 		$Data['SUPP'][$Key]['player_id']	= $Row['player_id'] + $TABLEINFO[USERS];
			$Data['SUPP'][$Key]['text']			= base64_decode($Row['text']);
			$Data['SUPP'][$Key]['universe']		= $TABLEINFO[CONFIG] + 1;
			$SQL	.= "(";
			foreach($Data['SUPP'][$Key] as $Value)
				$SQL	.= "'".$Value."', ";
			$SQL	= substr($SQL, 0, -2)."),";
			$Rows	= 1;
		}
		if($Rows == 1)
			$db->query(substr($SQL, 0, -1).';');
		$Rows	= 0;
		
		$SQL = "INSERT INTO ".TOPKB." (`id_owner1`, `angreifer`, `id_owner2`, `defender`, `gesamtunits`, `rid`, `fleetresult`, `time`, `universe`) VALUES ";
		foreach($Data['TOPKB'] as $Key => $Row)
		{
	 		$Data['TOPKB'][$Key]['id_owner1']	= $Row['id_owner1'] + $TABLEINFO[USERS];
	 		$Data['TOPKB'][$Key]['id_owner2']	= $Row['id_owner2'] + $TABLEINFO[USERS];
			$Data['TOPKB'][$Key]['universe']	= $TABLEINFO[CONFIG] + 1;
			$SQL	.= "(";
			foreach($Data['TOPKB'][$Key] as $Value)
				$SQL	.= "'".$Value."', ";
			$SQL	= substr($SQL, 0, -2)."),";
			$Rows	= 1;
		}
		if($Rows == 1)
			$db->query(substr($SQL, 0, -1).';');
		$Rows	= 0;
		
		$SQL = "INSERT INTO ".USERS." (`id`, `username`, `password`, `email`, `email_2`, `lang`, `authlevel`, `rights`, `id_planet`, `universe`, `galaxy`, `system`, `planet`, `user_lastip`, `ip_at_reg`, `register_time`, `onlinetime`, `dpath`, `design`, `noipcheck`, `planet_sort`, `planet_sort_order`, `spio_anz`, `settings_tooltiptime`, `settings_fleetactions`, `settings_planetmenu`, `settings_esp`, `settings_wri`, `settings_bud`, `settings_mis`, `settings_rep`, `settings_tnstor`, `settings_gview`, `urlaubs_modus`, `urlaubs_until`, `db_deaktjava`, `new_message`, `new_gmessage`, `fleet_shortcut`, `b_tech_planet`, `b_tech`, `b_tech_id`, `spy_tech`, `computer_tech`, `military_tech`, `defence_tech`, `shield_tech`, `energy_tech`, `hyperspace_tech`, `combustion_tech`, `impulse_motor_tech`, `hyperspace_motor_tech`, `laser_tech`, `ionic_tech`, `buster_tech`, `intergalactic_tech`, `expedition_tech`, `metal_proc_tech`, `crystal_proc_tech`, `deuterium_proc_tech`, `graviton_tech`, `ally_id`, `ally_name`, `ally_request`, `ally_request_text`, `ally_register_time`, `ally_rank_id`, `rpg_geologue`, `rpg_amiral`, `rpg_ingenieur`, `rpg_technocrate`, `rpg_espion`, `rpg_constructeur`, `rpg_scientifique`, `rpg_commandant`, `rpg_stockeur`, `darkmatter`, `rpg_defenseur`, `rpg_destructeur`, `rpg_general`, `rpg_bunker`, `rpg_raideur`, `rpg_empereur`, `bana`, `banaday`, `hof`, `wons`, `loos`, `draws`, `kbmetal`, `kbcrystal`, `lostunits`, `desunits`, `uctime`, `setmail`, `dm_attack`, `dm_defensive`, `dm_buildtime`, `dm_researchtime`, `dm_resource`, `dm_energie`, `dm_fleettime`, `fb_id`) VALUES ";
		foreach($Data['USERS'] as $Key => $Row)
		{
	 		$Data['USERS'][$Key]['id']				= $Row['id'] + $TABLEINFO[USERS];
	 		$Data['USERS'][$Key]['id_planet']		= $Row['id_planet'] + $TABLEINFO[PLANETS];
	 		$Data['USERS'][$Key]['ally_id']			= $Row['ally_id'] + $TABLEINFO[ALLIANCE];
			$Data['USERS'][$Key]['universe']		= $TABLEINFO[CONFIG] + 1;
			$Data['USERS'][$Key]['fleet_shortcut']	= base64_decode($Row['fleet_shortcut']);
			$SQL	.= "(";
			foreach($Data['USERS'][$Key] as $Value)
				$SQL	.= "'".$Value."', ";
			$SQL	= substr($SQL, 0, -2)."),";
			$Rows	= 1;
		}
		if($Rows == 1)
			$db->query(substr($SQL, 0, -1).';');
		$Rows	= 0;
		
		$SQL = "INSERT INTO ".USERS_VALID." (`id`, `username`, `cle`, `password`, `email`, `date`, `planet`, `ip`, `lang`, `universe`) VALUES ";
		foreach($Data['USERS_VALID'] as $Key => $Row)
		{
	 		$Data['USERS_VALID'][$Key]['id']		= $Row['id'] + $TABLEINFO[USERS_VALID];
			$Data['USERS_VALID'][$Key]['universe']	= $TABLEINFO[CONFIG] + 1;
			$SQL	.= "(";
			foreach($Data['USERS_VALID'][$Key] as $Value)
				$SQL	.= "'".$Value."', ";
			$SQL	= substr($SQL, 0, -2)."),";
			$Rows	= 1;
		}
		if($Rows == 1)
			$db->query(substr($SQL, 0, -1).';');
		$Rows	= 0;
		
		if(UNIS_MULTIVARS)
			copy(ROOT_PATH.'includes/vars.php', ROOT_PATH.'includes/vars_uni'.($TABLEINFO[CONFIG] + 1).'.php');
	}
	$Unis				= array();
	$Unis[$CONF['uni']]	= $CONF;
	$Query	= $db->query("SELECT * FROM ".CONFIG." WHERE `uni` != '".$UNI."' ORDER BY `uni` ASC;");
	while($Uni	= $db->fetch_array($Query)) {
		$Unis[$Uni['uni']]	= $Uni;
	}
	ksort($Unis);
	$template->assign_vars(array(	
		'button_submit'			=> $LNG['button_submit'],
		'Unis'					=> $Unis,
		'SID'					=> session_id(),
		'id'					=> $LNG['uvs_id'],
		'name'					=> $LNG['uvs_name'],
		'speeds'				=> $LNG['uvs_speeds'],
		'players'				=> $LNG['uvs_players'],
		'open'					=> $LNG['uvs_open'],
		'export'				=> $LNG['uvs_export'],
		'delete'				=> $LNG['uvs_delete'],
		'uni_on'				=> $LNG['uvs_on'],
		'uni_off'				=> $LNG['uvs_off'],
		'new_uni'				=> $LNG['uvs_new'],
		'import_uni'			=> $LNG['uvs_import'],
		'upload'				=> $LNG['uvs_upload'],
	));
	
	$template->show('adm/UniversePage.tpl');
}

?>