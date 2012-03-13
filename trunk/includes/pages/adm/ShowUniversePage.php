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

if ($USER['authlevel'] != AUTH_ADM || $_GET['sid'] != session_id()) exit;
@set_time_limit(0);

function ShowUniversePage() {
	global $CONF, $LNG, $UNI, $USER;
	$template	= new template();

	if($_REQUEST['action'] == 'delete' && !empty($_REQUEST['id']) && $_REQUEST['id'] != ROOT_UNI) {
		$ID	= (int) $_REQUEST['id'];
		if($UNI != $ID) {
			$GLOBALS['DATABASE']->multi_query("DELETE FROM ".ALLIANCE." WHERE `ally_universe` = ".$ID.";
			DELETE FROM ".BANNED." WHERE `universe` = ".$ID.";
			DELETE FROM ".BUDDY." WHERE `universe` = ".$ID.";
			DELETE FROM ".CONFIG." WHERE `uni` = ".$ID.";
			DELETE FROM ".DIPLO." WHERE `universe` = ".$ID.";
			DELETE FROM ".FLEETS." WHERE `fleet_universe` = ".$ID.";
			DELETE FROM ".MESSAGES." WHERE `message_universe` = ".$ID.";
			DELETE FROM ".NOTES." WHERE `universe` = ".$ID.";
			DELETE FROM ".PLANETS." WHERE `universe` = ".$ID.";
			DELETE FROM ".STATPOINTS." WHERE `universe` = ".$ID.";
			DELETE FROM ".TICKETS." WHERE `universe` = ".$ID.";
			DELETE FROM ".TOPKB." WHERE `universe` = ".$ID.";
			DELETE FROM ".USERS." WHERE `universe` = ".$ID.";
			DELETE FROM ".USERS_VALID." WHERE `universe` = ".$ID.";");	
			if($_SESSION['adminuni'] == $ID)
				$_SESSION['adminuni']	= $UNI;
		}
	} elseif($_REQUEST['action'] == 'create') {
		$ID	= (int) $_REQUEST['id'];
		$GLOBALS['DATABASE']->query("INSERT INTO ".CONFIG." (`uni`, `VERSION`, `uni_name`, `game_name`, `close_reason`, `OverviewNewsText`) VALUES
		(NULL, '".$CONF['VERSION']."', 'Uni', '".$CONF['game_name']."', '', '');");
		$UniID	= $GLOBALS['DATABASE']->GetInsertID();
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
		$GLOBALS['DATABASE']->query("INSERT INTO ".USERS." SET
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
		$UserID	= $GLOBALS['DATABASE']->countquery("SELECT `id` FROM ".USERS." WHERE `universe` = '".$UniID."';");
		$GLOBALS['DATABASE']->query("INSERT INTO ".PLANETS." SET
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
		$PlanetID	= $GLOBALS['DATABASE']->countquery("SELECT `id` FROM ".PLANETS." WHERE `universe` = '".$UniID."';");
		$GLOBALS['DATABASE']->query("UPDATE ".USERS." SET `id_planet` = '".$PlanetID."' WHERE `id` = '".$UserID."';");
		$GLOBALS['DATABASE']->query("INSERT INTO ".STATPOINTS." (`id_owner`, `id_ally`, `stat_type`, `universe`, `tech_rank`, `tech_old_rank`, `tech_points`, `tech_count`, `build_rank`, `build_old_rank`, `build_points`, `build_count`, `defs_rank`, `defs_old_rank`, `defs_points`, `defs_count`, `fleet_rank`, `fleet_old_rank`, `fleet_points`, `fleet_count`, `total_rank`, `total_old_rank`, `total_points`, `total_count`) VALUES ('".$UserID."', '0', '1', '".$UniID."', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');");
		update_config(array('users_amount' => 1), $UniID);
	} elseif($_REQUEST['action'] == 'download' && !empty($_REQUEST['id'])) {
		header("Content-type: application/force-download");
		header("Content-Transfer-Encoding: Binary");
		
		$Backup	= serialize(array(
			'AKS'			=> $GLOBALS['DATABASE']->fetchquery("SELECT * FROM ".AKS.";"),
			'ALLIANCE'		=> $GLOBALS['DATABASE']->fetchquery("SELECT * FROM ".ALLIANCE." WHERE `ally_universe` = ".$_REQUEST['id'].";", array('ally_description', 'ally_text', 'ally_request', 'ally_request_waiting')),
			'BANNED'		=> $GLOBALS['DATABASE']->fetchquery("SELECT * FROM ".BANNED." WHERE `universe` = ".$_REQUEST['id'].";", array('theme')),
			'BUDDY'			=> $GLOBALS['DATABASE']->fetchquery("SELECT * FROM ".BUDDY." WHERE `universe` = ".$_REQUEST['id'].";", array('text')),
			'CONFIG'		=> $GLOBALS['DATABASE']->fetchquery("SELECT * FROM ".CONFIG." WHERE `uni` = ".$_REQUEST['id'].";", array('close_reason', 'OverviewNewsText')),
			'DIPLO'			=> $GLOBALS['DATABASE']->fetchquery("SELECT * FROM ".DIPLO." WHERE `universe` = ".$_REQUEST['id'].";", array('accept_text')),
			'FLEETS'		=> $GLOBALS['DATABASE']->fetchquery("SELECT * FROM ".FLEETS." WHERE `fleet_universe` = ".$_REQUEST['id'].";"),
			'MESSAGES'		=> $GLOBALS['DATABASE']->fetchquery("SELECT * FROM ".MESSAGES." WHERE `message_universe` = ".$_REQUEST['id'].";", array('message_text')),
			'NOTES'			=> $GLOBALS['DATABASE']->fetchquery("SELECT * FROM ".NOTES." WHERE `universe` = ".$_REQUEST['id'].";", array('text')),
			'PLANETS'		=> $GLOBALS['DATABASE']->fetchquery("SELECT * FROM ".PLANETS." WHERE `universe` = ".$_REQUEST['id'].";"),
			'STATPOINTS'	=> $GLOBALS['DATABASE']->fetchquery("SELECT * FROM ".STATPOINTS." WHERE `universe` = ".$_REQUEST['id'].";"),
			'SUPP'			=> $GLOBALS['DATABASE']->fetchquery("SELECT * FROM ".SUPP." WHERE `universe` = ".$_REQUEST['id'].";", array('text')),
			'TOPKB'			=> $GLOBALS['DATABASE']->fetchquery("SELECT * FROM ".TOPKB." WHERE `universe` = ".$_REQUEST['id'].";"),
			'USERS'			=> $GLOBALS['DATABASE']->fetchquery("SELECT * FROM ".USERS." WHERE `universe` = ".$_REQUEST['id'].";", array('fleet_shortcut')),
			'USERS_VALID'	=> $GLOBALS['DATABASE']->fetchquery("SELECT * FROM ".USERS_VALID." WHERE `universe` = ".$_REQUEST['id'].";"),
		));
		
		$File	= gzdeflate($Backup); 		
		header("Content-length: ".strlen($File));
		header("Content-Disposition: attachment; filename=Uni_".$_REQUEST['id']."_".date('d.m.y').".2moons");
		echo $File;
		exit;
	}
	$Unis				= array();
	$Unis[$CONF['uni']]	= $CONF;
	$Query	= $GLOBALS['DATABASE']->query("SELECT * FROM ".CONFIG." WHERE `uni` != '".$UNI."' ORDER BY `uni` ASC;");
	while($Uni	= $GLOBALS['DATABASE']->fetch_array($Query)) {
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
	
	$template->show('UniversePage.tpl');
}

?>