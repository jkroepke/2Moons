<?php

##############################################################################
# *                                                                          #
# * 2MOONS                                                                   #
# *                                                                          #
# * @copyright Copyright (C) 2010 By ShadoX from titanspace.de               #
# *                                                                          #
# *	                                                                         #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.                                     #
# *	                                                                         #
# *  This program is distributed in the hope that it will be useful,         #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of          #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           #
# *  GNU General Public License for more details.                            #
# *                                                                          #
##############################################################################

define('INSIDE'  			, true);
define('INSTALL' 			, true);
define('RCINSTALL_VERSION' 	, "5.0");
define('REVISION' 			, "571");

define('ROOT_PATH', './../');
include(ROOT_PATH . 'extension.inc');
include(ROOT_PATH . 'common.'.PHP_EXT);
define('DEFAULT_LANG'	, (empty($_REQUEST['lang'])) ? 'deutsch' : $_REQUEST['lang']);
includeLang('INSTALL');
$Mode     = $_GET['mode'];
$Page     = $_GET['page'];
$phpself  = $_SERVER['PHP_SELF'];
$nextpage = $Page + 1;
$parse = $LNG;
$parse['lang']	= 'lang='.DEFAULT_LANG;	
if (empty($Mode)) { $Mode = 'intro'; }
if (empty($Page)) { $Page = 1;       }

		
switch ($Mode) {
	case'license':
		$frame  = parsetemplate(gettemplate('install/ins_license'), false);
	break;
	case 'intro':
		$LangFolder = opendir(ROOT_PATH.'language');
		while (($LangSubFolder = readdir($LangFolder)) !== false)
		{
			if($LangSubFolder == '.' || $LangSubFolder == '..' || $LangSubFolder == '.htaccess' || $LangSubFolder == '.svn')
				continue;
			
			$parse['language_settings'] .= "<option ";

			if(DEFAULT_LANG == $LangSubFolder)
				$parse['language_settings'] .= "selected = selected";

			$parse['language_settings'] .= " value=\"".$LangSubFolder."\">".ucwords($LangSubFolder)."</option>";
		}
		$frame  = parsetemplate(gettemplate('install/ins_intro'), $parse);
	break;
	case 'req':
		$error = 0;
		if(version_compare(PHP_VERSION, "5.2.5", ">=")){
			$parse['PHP'] = "<span class=\"yes\">".$LNG['reg_yes'].", ".PHP_VERSION."</span>";
		} else {
			$parse['PHP'] = "<span class=\"no\">".$LNG['reg_no'].", ".PHP_VERSION."</span>";
			$error++;	
		}
		if(@ini_get('safe_mode') == 0){
			$parse['safemode'] = "<span class=\"yes\">".$LNG['reg_yes']."</span>";
		} else {
			$parse['safemode'] = "<span class=\"no\">".$LNG['reg_no']."</span>";
			$error++;
		}
		if(!extension_loaded('mysqli')){
			$parse['mysqli'] = "<span class=\"no\">".$LNG['reg_no']."</span>";
			$error++;
		} else {
			$parse['mysqli'] = "<span class=\"yes\">".$LNG['reg_yes']."</span>";
		}
		if(!extension_loaded('gd')){
			$parse['error'] = "<span class=\"no\">".$LNG['reg_no']."</span>";
		} else {
			$Info	= gd_info();
			if(!$Info['PNG Support'])
				$parse['gdlib'] = "<span class=\"no\">".$LNG['reg_no']."</span>";
			else
				$parse['gdlib'] = "<span class=\"yes\">".$LNG['reg_yes'].", ".$Info['GD Version']."</span>";
		}
		if(file_exists(ROOT_PATH."config.php") || ($res = @fopen(ROOT_PATH."config.php","w+") === true)){
			if(is_writable(ROOT_PATH."config.php") || @chmod(ROOT_PATH."config.php", 0777)){
					$chmod = "<span class=\"yes\"> - ".$LNG['reg_writable']."</span>";
				} else {
					$chmod = " - <span class=\"no\">".$LNG['reg_not_writable']."</span>";
					$error++;
				}
			$parse['config'] = "<tr><th>".$LNG['reg_file']." - config.php</th></th><th><span class=\"yes\">".$LNG['reg_found']."</span>".$chmod."</th></tr>";		
			@fclose($res);
		} else {
			$parse['config'] = "<tr><th>".$LNG['reg_file']." - config.php</th></th><th><span class=\"no\">".$LNG['reg_not_found']."</span>";
			$error++;
		}
		$directories = array('adm/logs/', 'cache/', 'cache/UserBanner/');
		$dirs = "";
		foreach ($directories as $dir)
		{
			if(is_dir(ROOT_PATH . $dir) ||  @mkdir(ROOT_PATH . $dir, 0777)){
				if(is_writable(ROOT_PATH . $dir) || @chmod(ROOT_PATH . $dir, 0777)){
						$chmod = "<span class=\"yes\"> - ".$LNG['reg_writable']."</span>";
					} else {
						$chmod = " - <span class=\"no\">".$LNG['reg_not_writable']."</span>";
						$error++;
					}
				$dirs .= "<tr><th>".$LNG['reg_dir']." - ".$dir."</th></th><th><span class=\"yes\">".$LNG['reg_found']."</span>".$chmod."</th></tr>";
				
			} else {
				$dirs .= "<tr><th>".$LNG['reg_dir']." - ".$dir."</th></th><th><span class=\"no\">".$LNG['reg_not_found']."</span>";
				$error++;
			}
		}
		
		if($error == 0){
			$parse['done'] = "<tr><th colspan=\"2\"><a href=\"index.php?mode=ins&page=1&amp;".$parse['lang']."\">".$LNG['continue']."</a></th></tr>";
		}
		$parse['dir'] = $dirs;
		$frame = parsetemplate(gettemplate('install/ins_req'), $parse);
	break;
	case 'ins':
		if ($Page == 1) {
			$frame  = parsetemplate(gettemplate('install/ins_form'), $parse);
		}
		elseif ($Page == 2) {
			$GLOBALS['database']['host']	= $_POST['host'];
			$GLOBALS['database']['port']	= $_POST['port'];
			$GLOBALS['database']['user']	= $_POST['user'];
			$GLOBALS['database']['userpw']	= $_POST['passwort'];
			$prefix 						= $_POST['prefix'];
			$GLOBALS['database']['databasename']    = $_POST['db'];
			
			$connection = new DB_MySQLi();
			
			if (mysqli_connect_errno()) {
				message(sprintf($LNG['step2_db_con_fail'], mysqli_connect_error()), "?mode=ins&page=1&".$parse['lang'], 3, false, false);exit;
			}

			@chmod("../config.php",0777);
			$dz = @fopen("../config.php", "w");
			if (!$dz)
			{
				message ($LNG['step2_conf_op_fail'],"?mode=ins&page=1&".$parse['lang'], 3, false, false);exit;
			}

			$parse['first']		= "Verbindung zur Datenbank erfolgreich...";
			$connection->multi_query(str_replace("prefix_", $prefix, file_get_contents('install.sql'))); 
			$parse['second']	= $LNG['step2_db_ok'];
			
			$numcookie = mt_rand(1000, 9999999999);
			fwrite($dz, "<?php \n");
			fwrite($dz, "if(!defined(\"INSIDE\")){ header(\"location:".ROOT_PATH."\"); } \n\n");
			fwrite($dz, "//### Database access ###//\n\n");
			fwrite($dz, "\$database[\"host\"]          = \"".$GLOBALS['database']['host']."\";\n");
			fwrite($dz, "\$database[\"port\"]          = \"".$GLOBALS['database']['port']."\";\n");
			fwrite($dz, "\$database[\"user\"]          = \"".$GLOBALS['database']['user']."\";\n");
			fwrite($dz, "\$database[\"userpw\"]        = \"".$GLOBALS['database']['userpw']."\";\n");
			fwrite($dz, "\$database[\"databasename\"]  = \"".$GLOBALS['database']['databasename']."\";\n");
			fwrite($dz, "\$database[\"tableprefix\"]   = \"".$prefix."\";\n");
			fwrite($dz, "\$dbsettings[\"secretword\"]  = \"2Moons_".$numcookie."\";\n\n");
			fwrite($dz, "//### Do not change beyond here ###//\n");
			fwrite($dz, "?>");
			fclose($dz);
			@chmod("../config.php",0444);
			
			$parse['third']	= "config.php erfolgreich erstellt...";
			$frame  = parsetemplate(gettemplate('install/ins_form_done'), $parse);
		}
		elseif ($Page == 3)
		{
			$frame  = parsetemplate(gettemplate('install/ins_acc'), $parse);
		}
		elseif ($Page == 4)
		{
			$adm_user   = $_POST['adm_user'];
			$adm_pass   = $_POST['adm_pass'];
			$adm_email  = $_POST['adm_email'];
			$md5pass    = md5($adm_pass);

			if (empty($_POST['adm_user']) && empty($_POST['adm_pas']) && empty($_POST['adm_email']))
			{
				message($LNG['step4_need_fields'],"?mode=ins&page=3&".$parse['lang'], 2, false, false);
				exit();
			}
			
			$QryInsertAdm  = "INSERT INTO ".USERS." SET ";
			$QryInsertAdm .= "`id`                = '1', ";
			$QryInsertAdm .= "`username`          = '". $adm_user ."', ";
			$QryInsertAdm .= "`email`             = '". $adm_email ."', ";
			$QryInsertAdm .= "`email_2`           = '". $adm_email ."', ";
			$QryInsertAdm .= "`ip_at_reg`         = '". $_SERVER['REMOTE_ADDR'] . "', ";
			$QryInsertAdm .= "`authlevel`         = '3', ";
			$QryInsertAdm .= "`id_planet`         = '1', ";
			$QryInsertAdm .= "`galaxy`            = '1', ";
			$QryInsertAdm .= "`system`            = '1', ";
			$QryInsertAdm .= "`planet`            = '1', ";
			$QryInsertAdm .= "`current_planet`    = '1', ";
			$QryInsertAdm .= "`register_time`     = '". TIMESTAMP ."', ";
			$QryInsertAdm .= "`password`          = '". $md5pass ."';";
			$QryInsertAdm .= "INSERT INTO ".PLANETS." SET ";
			$QryInsertAdm .= "`id_owner`          = '1', ";
			$QryInsertAdm .= "`id_level`          = '0', ";
			$QryInsertAdm .= "`galaxy`            = '1', ";
			$QryInsertAdm .= "`system`            = '1', ";
			$QryInsertAdm .= "`name`              = 'Hauptplanet', "; 
			$QryInsertAdm .= "`planet`            = '1', ";
			$QryInsertAdm .= "`last_update`       = '". TIMESTAMP ."', ";
			$QryInsertAdm .= "`planet_type`       = '1', ";
			$QryInsertAdm .= "`image`             = 'normaltempplanet02', ";
			$QryInsertAdm .= "`diameter`          = '12750', ";
			$QryInsertAdm .= "`field_max`         = '163', ";
			$QryInsertAdm .= "`temp_min`          = '47', ";
			$QryInsertAdm .= "`temp_max`          = '87', ";
			$QryInsertAdm .= "`metal`             = '500', ";
			$QryInsertAdm .= "`metal_perhour`     = '0', ";
			$QryInsertAdm .= "`metal_max`         = '1000000', ";
			$QryInsertAdm .= "`crystal`           = '500', ";
			$QryInsertAdm .= "`crystal_perhour`   = '0', ";
			$QryInsertAdm .= "`crystal_max`       = '1000000', ";
			$QryInsertAdm .= "`deuterium`         = '500', ";
			$QryInsertAdm .= "`deuterium_perhour` = '0', ";
			$QryInsertAdm .= "`deuterium_max`     = '1000000';";
			$QryInsertAdm .= "INSERT INTO ".STATPOINTS." (`id_owner`, `id_ally`, `stat_type`, `stat_code`, `tech_rank`, `tech_old_rank`, `tech_points`, `tech_count`, `build_rank`, `build_old_rank`, `build_points`, `build_count`, `defs_rank`, `defs_old_rank`, `defs_points`, `defs_count`, `fleet_rank`, `fleet_old_rank`, `fleet_points`, `fleet_count`, `total_rank`, `total_old_rank`, `total_points`, `total_count`, `stat_date`) VALUES ('1', '0', '1', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '".TIMESTAMP."');";
			$db->multi_query($QryInsertAdm);
			@session_start();
			$_SESSION['id']			= '1';
			$_SESSION['username']	= $adm_user;
			$_SESSION['authlevel']	= 3;	
		
			header("Location: ../adm/index.php");		
		}
		break;
	case'upgrade':
		if ($_POST)
		{
			function makedirs($directories)
			{
				foreach ($directories as $dir)
				{
					mkdir(ROOT_PATH . $dir, 0777);
				}
			}
			$Qry1 = "UPDATE ".CONFIG." SET `config_value` = '".RCINSTALL_VERSION."' WHERE `config_name` = 'VERSION' LIMIT 1;";
			$Qry2 = "ALTER TABLE ".PLANETS." CHANGE `der_metal` `der_metal` BIGINT( 11 ) UNSIGNED NOT NULL DEFAULT '0', CHANGE `der_crystal` `der_crystal` BIGINT( 11 ) UNSIGNED NOT NULL DEFAULT '0';";
			$Qry3 = "INSERT INTO ".CONFIG." (`config_name`, `config_value`) VALUES ('smtp_host', ''),('smtp_port', ''),('smtp_user', ''),('smtp_pass', ''),('smtp_ssl', ''),('user_valid', '');";
			$Qry4 = "ALTER TABLE ".ALLIANCE." CHANGE `ally_text` `ally_text` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;";
			$Qry5 = "INSERT INTO ".CONFIG." (`config_name`, `config_value`) VALUES ('ts_version', '2');";
			$Qry6 = "ALTER TABLE ".MESSAGES." CHANGE `message_text` `message_text` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL;";
			$Qry7 = "DROP TABLE ".LOTERIA.";";
			$Qry8 = "ALTER TABLE ".USERS." DROP `loteria_sus`";
			$Qry9 = "DELETE FROM ".CONFIG." WHERE `uni1_config`.`config_name` = 'configloteria' LIMIT 1;";
			$Qry10 = "DELETE FROM ".CONFIG." WHERE `uni1_config`.`config_name` = 'Loteria' LIMIT 1;";
			$Qry11 = "ALTER TABLE ".PLANETS." CHANGE `metal` `metal` DOUBLE(132,8) UNSIGNED NOT NULL DEFAULT '0.00000000', CHANGE `metal_perhour` `metal_perhour` INT(11) UNSIGNED NOT NULL DEFAULT '0', CHANGE `metal_max` `metal_max` BIGINT(20) UNSIGNED NULL DEFAULT '100000', CHANGE `crystal` `crystal` DOUBLE(132,8) UNSIGNED NOT NULL DEFAULT '0.00000000', CHANGE `crystal_perhour` `crystal_perhour` INT(11) UNSIGNED NOT NULL DEFAULT '0', CHANGE `crystal_max` `crystal_max` BIGINT(20) UNSIGNED NULL DEFAULT '100000', CHANGE `deuterium` `deuterium` DOUBLE(132,8) UNSIGNED NOT NULL DEFAULT '0.00000000', CHANGE `deuterium_perhour` `deuterium_perhour` INT(11) UNSIGNED NOT NULL DEFAULT '0', CHANGE `deuterium_max` `deuterium_max` BIGINT(20) UNSIGNED NULL DEFAULT '100000'";
			$Qry12 = "ALTER TABLE ".SUPP." CHANGE `text` `text` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL";
			$Qry13 = "ALTER TABLE ".USERS." CHANGE `settings_allylogo` `settings_planetmenu` TINYINT( 4 ) NOT NULL DEFAULT '1';";
			$Qry14 = "ALTER TABLE ".ALLIANCE." CHANGE `ally_name` `ally_name` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL , CHANGE `ally_tag` `ally_tag` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;";
			$Qry15 = "ALTER TABLE ".ALLIANCE." CHANGE `ally_ranks` `ally_ranks` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL;";
			$Qry16 = "ALTER TABLE ".USERS." ADD `dm_attack` INT NOT NULL, ADD `dm_defensive` INT NOT NULL, ADD `dm_buildtime` INT NOT NULL, ADD `dm_researchtime` INT NOT NULL, ADD `dm_resource` INT NOT NULL, ADD `dm_energie` INT NOT NULL, ADD `dm_fleettime` INT NOT NULL;";
			$Qry17 = "INSERT INTO ".MODULE."(`id`, `modulo`, `estado`) VALUES (NULL, 'DM-Bank', '1');";
			$Qry18 = "CREATE TABLE ".PLUGINS."` (`status` tinyint(11) NOT NULL DEFAULT '0',`plugin` varchar(32) NOT NULL) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
			$Qry19 = "UPDATE ".PLANETS." SET `field_max` = '1' WHERE `planet_type` = 3;";
			$Qry20 = "ALTER TABLE ".PLANETS." ADD `bahamut` BIGINT( 11 ) NOT NULL DEFAULT '0';;";
			$Qry21 = "ALTER TABLE ".PLANETS." ADD `orbital_station` BIGINT( 11 ) NOT NULL DEFAULT '0';";
			$Qry22 = "ALTER TABLE ".PLANETS." ADD `thriller` BIGINT( 11 ) NOT NULL DEFAULT '0';";
			$Qry23 = "CREATE TABLE ".DIPLO." ( `id` int(11) NOT NULL AUTO_INCREMENT, `owner_1` int(11) NOT NULL, `owner_2` int(11) NOT NULL, `level` tinyint(1) NOT NULL, `accept` tinyint(1) NOT NULL, `accept_text` varchar(255) NOT NULL, PRIMARY KEY (`id`), KEY `owner_1` (`owner_1`,`owner_2`)) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
			$Qry24 = "ALTER TABLE ".ALLIANCE." ADD `ally_diplo` TINYINT( 1 ) NOT NULL DEFAULT '1';";
			$Qry25 = "ALTER TABLE ".USERS." ADD `settings_tnstor` TINYINT( 1 ) NOT NULL DEFAULT '1' AFTER `settings_rep`;";
			$Qry26 = "ALTER TABLE ".USERS." CHANGE `design` `design` TINYINT( 1 ) NOT NULL DEFAULT '1', CHANGE `noipcheck` `noipcheck` TINYINT( 1 ) NOT NULL DEFAULT '1', CHANGE `spio_anz` `spio_anz` TINYINT( 2 ) NOT NULL DEFAULT '1', CHANGE `settings_tooltiptime` `settings_tooltiptime` TINYINT( 1 ) NOT NULL DEFAULT '5', CHANGE `settings_fleetactions` `settings_fleetactions` TINYINT( 1 ) NOT NULL DEFAULT '0', CHANGE `settings_planetmenu` `settings_planetmenu` TINYINT( 1 ) NOT NULL DEFAULT '1', CHANGE `settings_esp` `settings_esp` TINYINT( 1 ) NOT NULL DEFAULT '1', CHANGE `settings_wri` `settings_wri` TINYINT( 1 ) NOT NULL DEFAULT '1', CHANGE `settings_bud` `settings_bud` TINYINT( 1 ) NOT NULL DEFAULT '1';";
			$Qry27 = "ALTER TABLE ".PLANETS." ADD `university` BIGINT( 11 ) NOT NULL DEFAULT '0';";
			$Qry28 = "INSERT INTO ".CONFIG." (`config_name`, `config_value`) VALUES ('fb_on', '0'), ('fb_apikey', ''), ('fb_skey', '');";
			$Qry29 = "ALTER TABLE ".USERS." ADD `fb_id` VARCHAR( 15 ) NOT NULL DEFAULT '0';";
			$Qry30 = "ALTER TABLE ".USERS." ADD INDEX (`fb_id`);";
			$Qry31 = "INSERT INTO ".CONFIG." (`config_name`,`config_value`) VALUES ('ga_active', '0'), ('ga_key', '');";
			switch($_POST['version'])
			{	
				case '4.0':
					makedirs(array('cache/', 'cache/UserBanner/'));
					$QrysArray = $Qry1.$Qry2.$Qry3.$Qry4.$Qry5.$Qry6.$Qry7.$Qry8.$Qry9.$Qry10.$Qry11.$Qry12.$Qry13.$Qry14.$Qry15.$Qry16.$Qry17.$Qry18.$Qry19.$Qry20.$Qry21.$Qry22.$Qry23.$Qry24.$Qry25.$Qry26.$Qry27.$Qry28.$Qry29.$Qry30.$Qry30.$Qry31;
				break;	
				case '4.2':
					$QrysArray = $Qry1.$Qry2.$Qry5.$Qry6.$Qry7.$Qry8.$Qry9.$Qry10.$Qry11.$Qry12.$Qry13.$Qry14.$Qry15.$Qry16.$Qry17.$Qry18.$Qry19.$Qry20.$Qry21.$Qry22.$Qry23.$Qry24.$Qry25.$Qry26.$Qry27.$Qry28.$Qry29.$Qry30.$Qry30.$Qry31;
				break;	
				case '4.3':
					$QrysArray = $Qry1.$Qry12.$Qry13.$Qry14.$Qry15.$Qry16.$Qry17.$Qry18.$Qry19.$Qry20.$Qry21.$Qry22.$Qry23.$Qry24.$Qry25.$Qry26.$Qry27.$Qry28.$Qry29.$Qry30.$Qry30.$Qry31;
				break;	
				case '5.0b1':
					$QrysArray = $Qry1.$Qry14.$Qry15.$Qry16.$Qry17.$Qry18.$Qry19.$Qry20.$Qry21.$Qry22.$Qry23.$Qry24.$Qry25.$Qry26.$Qry27.$Qry28.$Qry29.$Qry30.$Qry30.$Qry31;
				break;	
				case '5.0b2':
					$QrysArray = $Qry1.$Qry14.$Qry15.$Qry16.$Qry17.$Qry18.$Qry19.$Qry20.$Qry21.$Qry22.$Qry23.$Qry24.$Qry25.$Qry26.$Qry27.$Qry28.$Qry29.$Qry30.$Qry30.$Qry31;
				break;
				case '5.0b3':
					$QrysArray = $Qry1.$Qry18.$Qry19.$Qry20.$Qry21.$Qry22.$Qry23.$Qry24.$Qry25.$Qry26.$Qry27.$Qry28.$Qry29.$Qry30.$Qry30.$Qry31;
				break;
				case '5.0b5':
					$QrysArray = $Qry1.$Qry19.$Qry20.$Qry21.$Qry22.$Qry23.$Qry24.$Qry25.$Qry26.$Qry27.$Qry28.$Qry29.$Qry30.$Qry31;
				break;
				case '5.0b6':
					$QrysArray = $Qry31;
				break;
			}	
			$db->multi_query($QrysArray);
			
			message("Upgrade zu 2Moons RC".RCINSTALL_VERSION." erfolgreich!<br><br><a href=\"../index.php\">Zur Startseite</a>", "", "", false, false);
		}
		else
			$frame = parsetemplate(gettemplate('install/ins_update'), false);
		break;
	default:
}
$parse['ins_state']    = $Page;
$parse['ins_page']     = $frame;
$parse['dis_ins_btn']  = "?mode=$Mode&amp;page=$nextpage";
display (parsetemplate (gettemplate('install/ins_body'), $parse), false, '', true, false);
?>