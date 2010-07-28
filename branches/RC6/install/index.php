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

if(!function_exists('spl_autoload_register'))
	exit("PHP is missing <a href=\"http://php.net/spl\">Standard PHP Library (SPL)</a> support");

if(!class_exists('mysqli'))
	exit("PHP is missing <a href=\"http://php.net/mysqli\">MySQL Improved Extension</a> support");

if(!is_writable('../cache'))
	exit("Set Cache Dir to CHMOD 777!");

define('INSIDE'  			, true);
define('INSTALL' 			, true);
define('RCINSTALL_VERSION' 	, "6.0");
define('REVISION' 			, "874");

define('ROOT_PATH', './../');
include(ROOT_PATH . 'extension.inc');
include(ROOT_PATH . 'common.'.PHP_EXT);
define('DEFAULT_LANG'	, (empty($_REQUEST['lang'])) ? 'deutsch' : $_REQUEST['lang']);
includeLang('INSTALL');
$Mode     = $_GET['mode'];
$Page     = $_GET['page'];
$phpself  = $_SERVER['PHP_SELF'];
$nextpage = $Page + 1;

if (empty($Mode)) { $Mode = 'intro'; }
if (empty($Page)) { $Page = 1;       }

$template	= new template();
$template->assign_vars(array(
	'scripts'		=> $template->script,
	'lang'			=> 'lang='.DEFAULT_LANG,
	'title'			=> 'Installer &bull; 2Moons',
	'intro_instal'	=> $LNG['intro_instal'],
	'menu_intro'	=> $LNG['menu_intro'],
	'menu_install'	=> $LNG['menu_install'],
	'menu_license'	=> $LNG['menu_license'],
	'menu_convert'	=> $LNG['menu_convert'],
));

switch ($Mode) {
	case 'license':
		$template->show('install/ins_license.tpl');
	break;
	case 'intro':
		$template->assign_vars(array(
			'Selector'		=> GetLangs(),
			'intro_text'	=> $LNG['intro_text'],
			'intro_welcome'	=> $LNG['intro_welcome'],
			'intro_install'	=> $LNG['intro_install'],
			'intro_lang'	=> $LNG['intro_lang'],
		));
		$template->show('install/ins_intro.tpl');
	break;
	case 'req':
		$error = 0;
		if(version_compare(PHP_VERSION, "5.2.5", ">=")){
			$PHP = "<span class=\"yes\">".$LNG['reg_yes'].", ".PHP_VERSION."</span>";
		} else {
			$PHP = "<span class=\"no\">".$LNG['reg_no'].", ".PHP_VERSION."</span>";
			$error++;	
		}
		if(@ini_get('safe_mode') == 0){
			$safemode = "<span class=\"yes\">".$LNG['reg_yes']."</span>";
		} else {
			$safemode = "<span class=\"no\">".$LNG['reg_no']."</span>";
			$error++;
		}
		
		if(!extension_loaded('gd')){
			$gdlib = "<span class=\"no\">".$LNG['reg_no']."</span>";
		} else {
			$Info	= gd_info();
			if(!$Info['PNG Support'])
				$gdlib = "<span class=\"no\">".$LNG['reg_no']."</span>";
			else
				$gdlib = "<span class=\"yes\">".$LNG['reg_yes'].", ".$Info['GD Version']."</span>";
		}
		
		if(file_exists(ROOT_PATH."config.php") || ($res = @fopen(ROOT_PATH."config.php","w+") === true)){
			if(is_writable(ROOT_PATH."config.php") || @chmod(ROOT_PATH."config.php", 0777)){
					$chmod = "<span class=\"yes\"> - ".$LNG['reg_writable']."</span>";
				} else {
					$chmod = " - <span class=\"no\">".$LNG['reg_not_writable']."</span>";
					$error++;
				}
			$config = "<tr><th>".$LNG['reg_file']." - config.php</th></th><th><span class=\"yes\">".$LNG['reg_found']."</span>".$chmod."</th></tr>";		
			@fclose($res);
		} else {
			$config = "<tr><th>".$LNG['reg_file']." - config.php</th></th><th><span class=\"no\">".$LNG['reg_not_found']."</span>";
			$error++;
		}
		$directories = array('cache/', 'cache/UserBanner/', 'raports/');
		$dirs = "";
		foreach ($directories as $dir)
		{
			if(is_dir(ROOT_PATH . $dir) || @mkdir(ROOT_PATH . $dir, 0777)){
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
			$done = "<tr><th colspan=\"2\"><a href=\"index.php?mode=ins&page=1&amp;lang=".DEFAULT_LANG."\">".$LNG['continue']."</a></th></tr>";
		}
		
		$template->assign_vars(array(
			'safemode'			=> $safemode,
			'dir'				=> $dirs,
			'done'				=> $done,
			'config'			=> $config,
			'gdlib'				=> $gdlib,
			'PHP'				=> $PHP,
			'req_php_need'		=> $LNG['req_php_need'],
			'req_smode_active'	=> $LNG['req_smode_active'],
			'reg_gd_need'		=> $LNG['reg_gd_need'],
		));
		$template->show('install/ins_req.tpl');
	break;
	case 'ins':
		if ($Page == 1) {

			$template->assign_vars(array(
				'step1_notice_chmod'	=> $LNG['step1_notice_chmod'],
				'step1_mysql_server'	=> $LNG['step1_mysql_server'],
				'step1_mysql_port'		=> $LNG['step1_mysql_port'],
				'step1_mysql_dbname'	=> $LNG['step1_mysql_dbname'],
				'step1_mysql_dbuser'	=> $LNG['step1_mysql_dbuser'],
				'step1_mysql_dbpass'	=> $LNG['step1_mysql_dbpass'],
				'step1_mysql_prefix'	=> $LNG['step1_mysql_prefix'],
				'continue'				=> $LNG['continue'],
			));
			$template->show('install/ins_form.tpl');
			
		}
		elseif ($Page == 2) {
			$GLOBALS['database']['host']			= request_var('host', '');
			$GLOBALS['database']['port']			= request_var('port', 0);
			$GLOBALS['database']['user']			= request_var('user', '', true);
			$GLOBALS['database']['userpw']			= request_var('passwort', '', true);
			$prefix 								= request_var('prefix', '', true);
			$GLOBALS['database']['databasename']    = request_var('db', '', true);
			
			$connection = new DB_MySQLi();
			
			if (mysqli_connect_errno()) {
				exit($template->message(sprintf($LNG['step2_db_con_fail'], mysqli_connect_error()),"?mode=ins&page=1&lang=".DEFAULT_LANG));
			}

			@chmod("../config.php",0777);
			$dz = @fopen("../config.php", "w");
			if (!$dz)
			{
				exit($template->message($LNG['step2_conf_op_fail'],"?mode=ins&page=1&lang=".DEFAULT_LANG));
			}

			$first		= "Verbindung zur Datenbank erfolgreich...";
			$connection->multi_query(str_replace("prefix_", $prefix, file_get_contents('install.sql'))); 
			
			$second	= $LNG['step2_db_ok'];
			
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
			
			$third	= "config.php erfolgreich erstellt...";
			$template->assign_vars(array(
				'first'					=> $first,
				'second'				=> $second,
				'third'					=> $third,
				'continue'				=> $LNG['continue'],
			));
			$template->show('install/ins_form_done.tpl');
		}
		elseif ($Page == 3)
		{
			$template->assign_vars(array(
				'step3_create_admin'	=> $LNG['step3_create_admin'],
				'step3_admin_name'		=> $LNG['step3_admin_name'],
				'step3_admin_pass'		=> $LNG['step3_admin_pass'],
				'step3_admin_mail'		=> $LNG['step3_admin_mail'],
				'continue'				=> $LNG['continue'],
			));
			$template->show('install/ins_acc.tpl');
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
			
			$SQL  = "INSERT INTO ".USERS." SET ";
			$SQL .= "`id`                = '1', ";
			$SQL .= "`username`          = '". $adm_user ."', ";
			$SQL .= "`email`             = '". $adm_email ."', ";
			$SQL .= "`email_2`           = '". $adm_email ."', ";
			$SQL .= "`ip_at_reg`         = '". $_SERVER['REMOTE_ADDR'] . "', ";
			$SQL .= "`authlevel`         = '3', ";
			$SQL .= "`id_planet`         = '1', ";
			$SQL .= "`galaxy`            = '1', ";
			$SQL .= "`system`            = '1', ";
			$SQL .= "`planet`            = '1', ";
			$SQL .= "`current_planet`    = '1', ";
			$SQL .= "`register_time`     = '". TIMESTAMP ."', ";
			$SQL .= "`password`          = '". $md5pass ."';";
			$SQL .= "INSERT INTO ".PLANETS." SET ";
			$SQL .= "`id_owner`          = '1', ";
			$SQL .= "`id_level`          = '0', ";
			$SQL .= "`galaxy`            = '1', ";
			$SQL .= "`system`            = '1', ";
			$SQL .= "`name`              = 'Hauptplanet', "; 
			$SQL .= "`planet`            = '1', ";
			$SQL .= "`last_update`       = '". TIMESTAMP ."', ";
			$SQL .= "`planet_type`       = '1', ";
			$SQL .= "`image`             = 'normaltempplanet02', ";
			$SQL .= "`diameter`          = '12750', ";
			$SQL .= "`field_max`         = '163', ";
			$SQL .= "`temp_min`          = '47', ";
			$SQL .= "`temp_max`          = '87', ";
			$SQL .= "`metal`             = '500', ";
			$SQL .= "`metal_perhour`     = '0', ";
			$SQL .= "`metal_max`         = '1000000', ";
			$SQL .= "`crystal`           = '500', ";
			$SQL .= "`crystal_perhour`   = '0', ";
			$SQL .= "`crystal_max`       = '1000000', ";
			$SQL .= "`deuterium`         = '500', ";
			$SQL .= "`deuterium_perhour` = '0', ";
			$SQL .= "`deuterium_max`     = '1000000';";
			$SQL .= "INSERT INTO ".STATPOINTS." (`id_owner`, `id_ally`, `stat_type`, `stat_code`, `tech_rank`, `tech_old_rank`, `tech_points`, `tech_count`, `build_rank`, `build_old_rank`, `build_points`, `build_count`, `defs_rank`, `defs_old_rank`, `defs_points`, `defs_count`, `fleet_rank`, `fleet_old_rank`, `fleet_points`, `fleet_count`, `total_rank`, `total_old_rank`, `total_points`, `total_count`, `stat_date`) VALUES ('1', '0', '1', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '".TIMESTAMP."');";
			$db->multi_query($SQL);
			@session_start();
			$_SESSION['id']			= '1';
			$_SESSION['username']	= $adm_user;
			$_SESSION['authlevel']	= 3;	
		
			header("Location: ../admin.php");		
		}
		break;
	case 'convert':
		if(!file_exists(ROOT_PATH.'config.php') || filesize(ROOT_PATH.'config.php') == 0)
			message($LNG['convert_install'], '?', 3);
		
		if($_POST) {
			$GLOBALS['database']['host']			= $_POST['host'];
			$GLOBALS['database']['port']			= $_POST['port'];
			$GLOBALS['database']['user']			= $_POST['user'];
			$GLOBALS['database']['userpw']			= $_POST['passwort'];
			$GLOBALS['database']['databasename']    = $_POST['db'];
			require_once('class.convert.'.PHP_EXT);
			new convert($_POST['version'], $_POST['prefix']);
			$template->message($LNG['convert_done'], '?', 3);
			
		} else {
			$template->assign_vars(array(
				'step1_mysql_server'	=> $LNG['step1_mysql_server'],
				'step1_mysql_port'		=> $LNG['step1_mysql_port'],
				'step1_mysql_dbname'	=> $LNG['step1_mysql_dbname'],
				'step1_mysql_dbuser'	=> $LNG['step1_mysql_dbuser'],
				'step1_mysql_dbpass'	=> $LNG['step1_mysql_dbpass'],
				'step1_mysql_prefix'	=> $LNG['step1_mysql_prefix'],
				'convert_version'		=> $LNG['convert_version'],
				'convert_submit'		=> $LNG['convert_submit'],
			));
			
			$template->show('install/ins_convert.tpl');
		}
	default:
}
?>