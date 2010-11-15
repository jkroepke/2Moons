<?php

##############################################################################
# *																			 #
# * RN FRAMEWORK															 #
# *  																		 #
# * @copyright Copyright (C) 2009 By ShadoX from xnova-reloaded.de	    	 #
# *																			 #
# *																			 #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.									 #
# *																			 #
# *  This program is distributed in the hope that it will be useful,		 #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of			 #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 #
# *  GNU General Public License for more details.							 #
# *																			 #
##############################################################################

if ($USER['authlevel'] != AUTH_ADM || $_GET['sid'] != session_id()) exit;

function ShowUniversePage() {
	global $CONF, $LNG, $db, $UNI, $USER;
	$template	= new template();
	$template->page_header();
	if($_REQUEST['action'] == 'delete' && !empty($_REQUEST['id']) && $_REQUEST['id'] != 1) {
		$ID	= (int) $_REQUEST['id'];
		$db->multi_query("DELETE FROM ".ALLIANCE." WHERE `ally_universe` = ".$ID.";
		DELETE FROM ".BANNED." WHERE `universe` = ".$ID.";
		DELETE FROM ".CHAT." WHERE `universe` = ".$ID.";
		DELETE FROM ".CONFIG." WHERE `uni` = ".$ID.";
		DELETE FROM ".FLEETS." WHERE `fleet_universe` = ".$ID.";
		DELETE FROM ".PLANETS." WHERE `universe` = ".$ID.";
		DELETE FROM ".STATPOINTS." WHERE `universe` = ".$ID.";
		DELETE FROM ".TOPKB." WHERE `universe` = ".$ID.";
		DELETE FROM ".USERS." WHERE `universe` = ".$ID.";
		DELETE FROM ".USERS_VALID." WHERE `universe` = ".$ID.";");
		
		if($_SESSION['adminuni'] == $ID)
			$_SESSION['adminuni']	= $ID;
	} elseif($_REQUEST['action'] == 'create') {
		$ID	= (int) $_REQUEST['id'];
		$db->query("INSERT INTO ".CONFIG." (`uni`, `VERSION`, `users_amount`, `game_speed`, `fleet_speed`, `resource_multiplier`, `halt_speed`, `Fleet_Cdr`, `Defs_Cdr`, 
		`initial_fields`, `bgm_active`, `bgm_file`, `game_name`, `game_disable`, `close_reason`, `metal_basic_income`, `crystal_basic_income`, `deuterium_basic_income`, `energy_basic_income`, `LastSettedGalaxyPos`, `LastSettedSystemPos`, `LastSettedPlanetPos`, `noobprotection`, `noobprotectiontime`, `noobprotectionmulti`, `forum_url`, `adm_attack`, `debug`, `lang`, `stat`, `stat_level`, `stat_last_update`, `stat_settings`, `stat_update_time`, `stat_last_db_update`, `stats_fly_lock`, `stat_last_banner_update`, `stat_banner_update_time`, `cron_lock`, `ts_modon`, `ts_server`, `ts_tcpport`, `ts_udpport`, `ts_timeout`, `ts_version`, `reg_closed`, `OverviewNewsFrame`, `OverviewNewsText`, `capaktiv`, `cappublic`, `capprivate`, `min_build_time`, `smtp_host`, `smtp_port`, `smtp_user`, `smtp_pass`, `smtp_ssl`, `smtp_sendmail`, `user_valid`, `ftp_server`, `ftp_user_name`, `ftp_user_pass`, `ftp_root_path`, `fb_on`, `fb_apikey`, `fb_skey`, `ga_active`, `ga_key`, `moduls`) VALUES 
		(NULL, '".$CONF['VERSION']."', 0, 2500, 2500, 1, 1, 30, 30, 163, ".$CONF['bgm_active'].", '".$CONF['bgm_file']."', '2Moons', 1, 'Game ist zurzeit geschlossen', 20, 10, 0, 0, 1, 1, 1, 0, 0, 0, '".$CONF['forum_url']."', 1, 0, '".$CONF['lang']."', ".$CONF['stat'].", ".$CONF['stat_level'].", ".$CONF['stat_last_update'].", ".$CONF['stat_settings'].", ".$CONF['stat_update_time'].", ".$CONF['stat_last_db_update'].", ".$CONF['stats_fly_lock'].", ".$CONF['stat_last_banner_update'].", ".$CONF['stat_banner_update_time'].", 0, ".$CONF['ts_modon'].", '".$CONF['ts_server']."', ".$CONF['ts_tcpport'].", ".$CONF['ts_udpport'].", ".$CONF['ts_timeout'].", ".$CONF['ts_version'].", 0, 1, 'Herzlich Willkommen bei 2Moons v1.3!', ".$CONF['capaktiv'].", '".$CONF['cappublic']."', '".$CONF['capprivate']."', 1, ".$CONF['smtp_host'].", ".$CONF['smtp_port'].", ".$CONF['smtp_user'].", ".$CONF['smtp_pass'].", ".$CONF['smtp_ssl'].", ".$CONF['smtp_sendmail'].", ".$CONF['user_valid'].", '".$CONF['ftp_server']."', '".$CONF['ftp_user_name']."', '".$CONF['ftp_user_pass']."', '".$CONF['ftp_root_path']."', ".$CONF['fb_on'].", '".$CONF['fb_apikey']."', '".$CONF['fb_skey']."', '".$CONF['ga_active']."', '".$CONF['ga_key']."', '1;1;1;1;1;1;1;1;1;1;1;1;1;1;1;1;1;1;1;1;1;1;1;1;1;1;1;1;1;1;1;1;1;1;1;1;1;1');");
		$UniID	= $db->countquery("SELECT `uni` FROM ".CONFIG." WHERE `users_amount` = 0;");
		$db->query("INSERT INTO ".USERS." SET
			`id`                = NULL,
			`username`          = '".$USER['username']."',
			`email`             = '".$USER['email']."',
			`email_2`           = '".$USER['email']."',
			`ip_at_reg`         = '".$_SERVER['REMOTE_ADDR']."',
			`authlevel`         = '3',
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
			`id_level`          = '0',
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
		update_config(array('users_amount' => 1), false, $UniID);
	} elseif($_REQUEST['action'] == 'download' && !empty($_REQUEST['id']) && $_REQUEST['id'] >= 1) {
		header("Content-type: application/force-download");
		header("Content-Transfer-Encoding: Binary");
		
		$Backup	= serialize(array(
			'AKS'			=> $db->fetchquery("SELECT * FROM ".AKS." ORDER BY `id` ASC;"),
			'ALLIANCE'		=> $db->fetchquery("SELECT * FROM ".ALLIANCE." ORDER BY `id` ASC;"),
			'BANNED'		=> $db->fetchquery("SELECT * FROM ".BANNED." ORDER BY `id` ASC;"),
			'BUDDY'			=> $db->fetchquery("SELECT * FROM ".BUDDY." ORDER BY `id` ASC;"),
			'CHAT'			=> $db->fetchquery("SELECT * FROM ".CHAT." ORDER BY `messageid` ASC;"),
			'CONFIG'		=> $db->fetchquery("SELECT * FROM ".CONFIG." WHERE `uni` = ".$_REQUEST['id'].";"),
			'DIPLO'			=> $db->fetchquery("SELECT * FROM ".DIPLO." ORDER BY `id` ASC;"),
			'FLEETS'		=> $db->fetchquery("SELECT * FROM ".FLEETS." ORDER BY `fleet_id` ASC;"),
			'MESSAGES'		=> $db->fetchquery("SELECT * FROM ".MESSAGES." ORDER BY `message_id` ASC;"),
			'NOTES'			=> $db->fetchquery("SELECT * FROM ".NOTES." ORDER BY `id` ASC;"),
			'PLANETS'		=> $db->fetchquery("SELECT * FROM ".PLANETS." ORDER BY `id` ASC;"),
			'STATPOINTS'	=> $db->fetchquery("SELECT * FROM ".STATPOINTS.";"),
			'SUPP'			=> $db->fetchquery("SELECT * FROM ".SUPP." ORDER BY `id` ASC;"),
			'TOPKB'			=> $db->fetchquery("SELECT * FROM ".TOPKB." ORDER BY `rid` ASC;"),
			'USERS'			=> $db->fetchquery("SELECT * FROM ".USERS." ORDER BY `id` ASC;"),
			'USERS_VALID'	=> $db->fetchquery("SELECT * FROM ".USERS_VALID." ORDER BY `id` ASC;"),
		));
		
		header("Content-length: ".strlen($Backup));
		header("Content-Disposition: attachment; filename=Uni_".$_REQUEST['id']."_".date('d.m.y').".2moons");
		echo $Backup;
		exit;
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
	));
	
	$template->show('adm/UniversePage.tpl');
}

?>