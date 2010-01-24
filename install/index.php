<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
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

define('INSIDE'  , true);
define('INSTALL' , true);

$xgp_root = './../';
include($xgp_root . 'extension.inc.php');
include($xgp_root . 'common.'.$phpEx);
include_once('databaseinfos.'.$phpEx);

$Mode     = $_GET['mode'];
$Page     = $_GET['page'];
$phpself  = $_SERVER['PHP_SELF'];
$nextpage = $Page + 1;

	
if (empty($Mode)) { $Mode = 'intro'; }
if (empty($Page)) { $Page = 1;       }

switch ($Mode) {
	case'license':
		$frame  = parsetemplate(gettemplate('install/ins_license'), false);
	break;
	case 'intro':
		$frame  = parsetemplate(gettemplate('install/ins_intro'), false);
	break;
	case 'req':
		$error = 0;
		if(version_compare(PHP_VERSION, "5.2.11", ">=")){
			if(version_compare(PHP_VERSION, "5.3.0", ">="))
				$parse['PHP'] = "<span class=\"yes\">Ja, ".PHP_VERSION."</span>";
			else
				$parse['PHP'] = "<span class=\"yellow\">Ja, ".PHP_VERSION."<br>Bitte bringe deine PHP Version in n&auml;chster Zeit auf 5.3.0+</span>";
		} else {
			$parse['PHP'] = "<span class=\"no\">Nein, ".PHP_VERSION."</span>";
			$error++;	
		}
		if(@ini_get('safe_mode') == 0){
			$parse['safemode'] = "<span class=\"yes\">Nicht aktiv</span>";
		} else {
			$parse['safemode'] = "<span class=\"no\">Aktiv</span>";
			$parse['done'] = "<tr><th colspan=\"2\">Safemode muss f&uuml;r XNova ausgeschaltet sein!</th></tr>";
			$error++;
		}
		if(!extension_loaded('mysqli')){
			$parse['mysqli'] = "<span class=\"no\">Nicht vorhanden</span>";
			$error++;
		} else {
			$parse['mysqli'] = "<span class=\"yes\">Vorhanden</span>";
		}
		if(ini_get('display_errors') == 0){
			$parse['error'] = "<span class=\"yellow\">Aus - Bitte &auml;ndern</span>";
		} else {
			$parse['error'] = "<span class=\"yes\">Aktiv</span>";
		}
		if(file_exists($xgp_root."config.php")){
			if(is_writable($xgp_root."config.php") || @chmod($xgp_root."config.php", 0777)){
					$chmod = "<span class=\"yes\"> - Beschreibbar</span>";
				} else {
					$chmod = " - <span class=\"no\">Nicht beschreibbar</span>";
					$error++;
				}
			$parse['config'] = "<tr><th>Datei - config.php</th></th><th><span class=\"yes\">Gefunden</span>".$chmod."</th></tr>";		
		} else {
			$parse['config'] = "<tr><th>Datei - config.php</th></th><th><span class=\"no\">Nicht Gefunden</span>";
			$error++;
		}
		$directories = array('adm/logs/', 'cache/', 'cache/UserBanner/');
		$dirs = "";
		foreach ($directories as $dir)
		{
			if(is_dir($xgp_root . $dir) ||  @mkdir($xgp_root . $dir, 0777)){
				if(is_writable($xgp_root . $dir) || @chmod($xgp_root . $dir, 0777)){
						$chmod = "<span class=\"yes\"> - Beschreibbar</span>";
					} else {
						$chmod = " - <span class=\"no\">Nicht beschreibbar</span>";
						$error++;
					}
				$dirs .= "<tr><th>Ordner - ".$dir."</th></th><th><span class=\"yes\">Gefunden</span>".$chmod."</th></tr>";
				
			} else {
				$dirs .= "<tr><th>Ordner - ".$dir."</th></th><th><span class=\"no\">Nicht Gefunden</span>";
				$error++;
			}
		}
		
		if($error == 0){
			$parse['done'] = "<tr><th colspan=\"2\"><a href=\"index.php?mode=ins&page=1\">Weiter</a></th></tr>";
		}
		$parse['dir'] = $dirs;
		$frame = parsetemplate(gettemplate('install/ins_req'), $parse);
	break;
	case 'ins':
		if ($Page == 1) {
			if ($_GET['error'] == 1) {
				message ("Keiner Verbindung der Datenbank","?mode=ins&page=1", 3, false, false);
			}
			elseif ($_GET['error'] == 2) {
				message ("config.php wurde nicht auf CHMOD 777 eingestellt!","?mode=ins&page=1", 3, false, false);
			}

			$frame  = parsetemplate(gettemplate('install/ins_form'), false);
		}
		elseif ($Page == 2) {
			$host   = $_POST['host'];
			$port   = $_POST['port'];
			$user   = $_POST['user'];
			$pass   = $_POST['passwort'];
			$prefix = $_POST['prefix'];
			$db     = $_POST['db'];

			$connection = new DB_MySQLi($host, $user, $pass, $db, $port);

			if (mysqli_connect_errno()) {
				header("Location: ?mode=ins&page=1&error=1");
				exit();
			}

			$numcookie = mt_rand(1000, 1234567890);
			$dz = fopen("../config.php", "w");
			if (!$dz)
			{
				header("Location: ?mode=ins&page=1&error=2");
				exit();
			}

			$parse[first]	= "Verbindung er Datenbank erfolgreich...";

			fwrite($dz, "<?php \n");
			fwrite($dz, "if(!defined(\"INSIDE\")){ header(\"location:".$xgp_root."\"); } \n\n");
			fwrite($dz, "//### Database access ###//\n\n");
			fwrite($dz, "\$database[\"host\"]          = \"".$host."\";\n");
			fwrite($dz, "\$database[\"port\"]          = \"".$port."\";\n");
			fwrite($dz, "\$database[\"user\"]          = \"".$user."\";\n");
			fwrite($dz, "\$database[\"userpw\"]        = \"".$pass."\";\n");
			fwrite($dz, "\$database[\"databasename\"]  = \"".$db."\";\n");
			fwrite($dz, "\$database[\"tableprefix\"]   = \"".$prefix."\";\n");
			fwrite($dz, "\$database[\"type\"]          = \"DB_MySQLi\";\n");
			fwrite($dz, "\$dbsettings[\"secretword\"]  = \"RNFramework".$numcookie."\";\n\n");
			fwrite($dz, "//### Do not change beyond here ###//\n");
			fwrite($dz, "?>");
			fclose($dz);
			@chmod("../config.php",0444);
			$parse['second']	= "config.php erfolgreich erstellt...";
			$connection->multi_query(str_replace("prefix_", $prefix, $QryTableAks.$QryTableAlliance.$QryTableBanned.$QryTableBuddy.$QryTableChat.$QryTableConfig.$QryInsertConfig.$QryTableErrors.$QryTableFleets.$QryTableLoteria.$QryTableMessages.$QryTableModulos.$QryInsertModulos.$QryTableNews.$QryTableNotes.$QryTablePlanets.$QryTableRw.$QryTableStatPoints.$QryTableSupp.$QryTableTopKB.$QryTableUsers.$QryTableUsersTemp));
			$parse['third']	= "Datenbank Tabellen erfolgreich erstellt....";
			$frame  = parsetemplate(gettemplate('install/ins_form_done'), $parse);
		}
		elseif ($Page == 3)
		{
			if ($_GET['error'] == 3)
				message ("Sie müssen alle Felder ausfüllen!","?mode=ins&page=3", 2, false, false);

			$frame  = parsetemplate(gettemplate('install/ins_acc'), false);
		}
		elseif ($Page == 4)
		{
			$adm_user   = $_POST['adm_user'];
			$adm_pass   = $_POST['adm_pass'];
			$adm_email  = $_POST['adm_email'];
			$md5pass    = md5($adm_pass);

			if (!$_POST['adm_user'])
			{
				header("Location: ?mode=ins&page=3&error=3");
				exit();
			}
			if (!$_POST['adm_pass'])
			{
				header("Location: ?mode=ins&page=3&error=3");
				exit();
			}
			if (!$_POST['adm_email'])
			{
				header("Location: ?mode=ins&page=3&error=3");
				exit();
			}
			
			$QryInsertAdm  = "INSERT INTO ".USERS." SET ";
			$QryInsertAdm .= "`id`                = '1', ";
			$QryInsertAdm .= "`username`          = '". $adm_user ."', ";
			$QryInsertAdm .= "`email`             = '". $adm_email ."', ";
			$QryInsertAdm .= "`email_2`           = '". $adm_email ."', ";
			$QryInsertAdm .= "`authlevel`         = '3', ";
			$QryInsertAdm .= "`id_planet`         = '1', ";
			$QryInsertAdm .= "`galaxy`            = '1', ";
			$QryInsertAdm .= "`system`            = '1', ";
			$QryInsertAdm .= "`planet`            = '1', ";
			$QryInsertAdm .= "`current_planet`    = '1', ";
			$QryInsertAdm .= "`register_time`     = '". time() ."', ";
			$QryInsertAdm .= "`password`          = '". $md5pass ."';";
			$QryInsertAdm .= "INSERT INTO ".PLANETS." SET ";
			$QryInsertAdm .= "`id_owner`          = '1', ";
			$QryInsertAdm .= "`id_level`          = '0', ";
			$QryInsertAdm .= "`galaxy`            = '1', ";
			$QryInsertAdm .= "`system`            = '1', ";
			$QryInsertAdm .= "`name`              = 'Hauptplanet', "; 
			$QryInsertAdm .= "`planet`            = '1', ";
			$QryInsertAdm .= "`last_update`       = '". time() ."', ";
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
			$QryInsertAdm .= "INSERT INTO ".STATPOINTS." (`id_owner`, `id_ally`, `stat_type`, `stat_code`, `tech_rank`, `tech_old_rank`, `tech_points`, `tech_count`, `build_rank`, `build_old_rank`, `build_points`, `build_count`, `defs_rank`, `defs_old_rank`, `defs_points`, `defs_count`, `fleet_rank`, `fleet_old_rank`, `fleet_points`, `fleet_count`, `total_rank`, `total_old_rank`, `total_points`, `total_count`, `stat_date`) VALUES ('1', '0', '1', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '".time()."');";
			$QryInsertAdm .= "UPDATE ".CONFIG." SET `config_value` = '1' WHERE `config_name` = 'LastSettedGalaxyPos';";
			$QryInsertAdm .= "UPDATE ".CONFIG." SET `config_value` = '1' WHERE `config_name` = 'LastSettedSystemPos';";
			$QryInsertAdm .= "UPDATE ".CONFIG." SET `config_value` = '1' WHERE `config_name` = 'LastSettedPlanetPos';";
			$QryInsertAdm .= "UPDATE ".CONFIG." SET `config_value` = `config_value` + '1' WHERE `config_name` = 'users_amount' LIMIT 1;";
			$db->multi_query($QryInsertAdm);
			$frame  = parsetemplate(gettemplate('install/ins_acc_done'), $parse);
		}
		break;
	case'upgrade':
		if ($_POST)
		{
			function makedirs($directories)
			{
				foreach ($directories as $dir)
				{
					mkdir($xgp_root . $dir, 0777);
				}
			}
			$Qry1 = "UPDATE ".CONFIG." SET `config_value` = '5.0' WHERE `config_name` = 'VERSION' LIMIT 1;";
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
			switch($_POST['version'])
			{	
				case '4.0':
					makedirs(array('cache/', 'cache/UserBanner/'));
					$QrysArray = $Qry1.$Qry2.$Qry3.$Qry4.$Qry5.$Qry6.$Qry7.$Qry8.$Qry9.$Qry10.$Qry11;
				break;	
				case '4.2':
					$QrysArray = $Qry1.$Qry2.$Qry5.$Qry6.$Qry7.$Qry8.$Qry9.$Qry10.$Qry11;
				break;
			}	
			$db->multi_query($QrysArray);
			
			message("Upgrade zu 2Moons RC5.0 erfolgreich!<br><br><a href=\"../index.php\">Zur Startseite</a>", "", "", false, false);
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