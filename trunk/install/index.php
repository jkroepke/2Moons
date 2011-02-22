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
 * @copyright 2009 Lucky <douglas@crockford.com> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.3 (2011-01-21)
 * @link http://code.google.com/p/2moons/
 */

if(!function_exists('spl_autoload_register'))
	exit("PHP is missing <a href=\"http://php.net/spl\">Standard PHP Library (SPL)</a> support");
	
define('INSIDE'  			, true);
define('INSTALL' 			, true);

define('ROOT_PATH', str_replace('\\', '/',dirname(dirname(__FILE__))).'/');

include(ROOT_PATH . 'common.php');
if(isset($dbsettings))
	redirectTo('../index.php');

$LANG->GetLangFromBrowser();
$LANG->includeLang(array('INGAME', 'INSTALL'));
$Mode     = $_GET['mode'];
$Page     = $_GET['page'];
$phpself  = $_SERVER['PHP_SELF'];
$nextpage = $Page + 1;

if (empty($Mode)) { $Mode = 'intro'; }
if (empty($Page)) { $Page = 1;       }

$template	= new template();


switch ($Mode) {
	case 'license':
		$template->show('install/ins_license.tpl');
	break;
	case 'intro':
		$template->assign_vars(array(
			'Selector'		=> $LANG->getAllowedLangs(false),
			'intro_text'	=> $LNG['intro_text'],
			'intro_welcome'	=> $LNG['intro_welcome'],
			'intro_install'	=> $LNG['intro_install'],
			'intro_lang'	=> $LNG['intro_lang'],
		));
		$template->show('install/ins_intro.tpl');
	break;
	case 'ftp':
		require_once(ROOT_PATH.'includes/libs/ftp/ftp.class.php');
		require_once(ROOT_PATH.'includes/libs/ftp/ftpexception.class.php');
		$LANG->includeLang(array('ADMIN'));
		$CONFIG = array("host" => $_GET['host'], "username" => $_GET['user'], "password" => $_GET['pass'], "port" => 21); 
		try
		{
			$ftp = FTP::getInstance(); 
			$ftp->connect($CONFIG);
		}
		catch (FTPException $error)
		{
			exit($LNG['up_ftp_error']);
		}	
					
		if(!$ftp->changeDir($_GET['path']))
			exit($LNG['up_ftp_change_error']);
			
		$ftp->chmod('cache', 0777);
		$ftp->chmod('cache/UserBanner', 0777);
		$ftp->chmod('cache/sessions', 0777);
		$ftp->chmod('raports', 0777);
		$ftp->chmod('includes', 0777);
		exit;
	break;
	case 'req':
		$error = 0;
		$ftp = 0;
		if(version_compare(PHP_VERSION, "5.2.5", ">=")){
			$PHP = "<span class=\"yes\">".$LNG['reg_yes'].", ".PHP_VERSION."</span>";
		} else {
			$PHP = "<span class=\"no\">".$LNG['reg_no'].", ".PHP_VERSION."</span>";
			$error++;
		}
		
		if(class_exists('mysqli')){
			$mysqli = "<span class=\"yes\">".$LNG['reg_yes']."</span>";
		} else {
			$mysqli = "<span class=\"no\">".$LNG['reg_no']."</span>";
			$error++;
		}
				
		if(function_exists('json_encode')){
			$json = "<span class=\"yes\">".$LNG['reg_yes']."</span>";
		} else {
			$json = "<span class=\"no\">".$LNG['reg_no']."</span>";
			$error++;
		}
		
		if(extension_loaded('bcmath'))
			$bcmath = "<span class=\"yes\">".$LNG['reg_yes']."</span>";
		else
			$bcmath	= "<span class=\"ok\">".$LNG['reg_no']."</span>";
	
		if(function_exists('ini_set')){
			$iniset = "<span class=\"yes\">".$LNG['reg_yes']."</span>";
		} else {
			$iniset = "<span class=\"no\">".$LNG['reg_no']."</span>";
			$error++;
		}

		if(!extension_loaded('gd')) {
			$gdlib = "<span class=\"no\">".$LNG['reg_no']."</span>";
		} else {
			$Info	= gd_info();
			if(!$Info['PNG Support']) {
				$gdlib = "<span class=\"no\">".$LNG['reg_no']."</span>";
				$error++;
			} else {
				$gdlib = "<span class=\"yes\">".$LNG['reg_yes'].", ".$Info['GD Version']."</span>";
			}
		}

		if(file_exists(ROOT_PATH."includes/config.php") || @touch(ROOT_PATH."includes/config.php")){
			if(is_writable(ROOT_PATH."includes/config.php") || @chmod(ROOT_PATH."includes/config.php", 0777)){
				$chmod = "<span class=\"yes\"> - ".$LNG['reg_writable']."</span>";
			} else {
				$chmod = " - <span class=\"no\">".$LNG['reg_not_writable']."</span>";
				$error++;
				$ftp++;
			}
			$config = "<tr><td class=\"transparent\">".$LNG['reg_file']." - includes/config.php</td><td class=\"transparent\"><span class=\"yes\">".$LNG['reg_found']."</span>".$chmod."</td></tr>";
		} else {
			$config = "<tr><td class=\"transparent\">".$LNG['reg_file']." - includes/config.php</td><td class=\"transparent\"><span class=\"no\">".$LNG['reg_not_found']."</span></td></tr>";
			$error++;
			$ftp++;
		}
		$directories = array('cache/', 'cache/UserBanner/', 'cache/sessions/', 'raports/', 'includes/');
		$dirs = "";
		foreach ($directories as $dir)
		{
			if(is_dir(ROOT_PATH . $dir) || @mkdir(ROOT_PATH . $dir, 0777)){
				if(is_writable(ROOT_PATH . $dir) || @chmod(ROOT_PATH . $dir, 0777)){
						$chmod = "<span class=\"yes\"> - ".$LNG['reg_writable']."</span>";
					} else {
						$chmod = " - <span class=\"no\">".$LNG['reg_not_writable']."</span>";
						$error++;
						$ftp++;
					}
				$dirs .= "<tr><td class=\"transparent\">".$LNG['reg_dir']." - ".$dir."</th><td class=\"transparent\"><span class=\"yes\">".$LNG['reg_found']."</span>".$chmod."</td></tr>";

			} else {
				$dirs .= "<tr><td class=\"transparent\">".$LNG['reg_dir']." - ".$dir."</td><td class=\"transparent\"><span class=\"no\">".$LNG['reg_not_found']."</span></td></tr>";
				$error++;
				$ftp++;
			}
		}

		if($error == 0){
			$done = "<tr><td colspan=\"2\" class=\"transparent\"><a href=\"index.php?mode=ins&page=1&amp;lang=".$LANG->GetUser()."\">".$LNG['continue']."</a></td></tr>";
		}

		$template->assign_vars(array(
			'dir'					=> $dirs,
			'json'					=> $json,
			'done'					=> $done,
			'config'				=> $config,
			'gdlib'					=> $gdlib,
			'PHP'					=> $PHP,
			'mysqli'				=> $mysqli,
			'ftp'					=> $ftp,
			'bcmath'				=> $bcmath,
			'iniset'				=> $iniset,
			'req_php_need'			=> $LNG['req_php_need'],
			'reg_mysqli_active'		=> $LNG['reg_mysqli_active'],
			'reg_gd_need'			=> $LNG['reg_gd_need'],
			'reg_json_need'			=> $LNG['reg_json_need'],
			'reg_iniset_need'		=> $LNG['reg_iniset_need'],
			'reg_bcmath_need'		=> $LNG['reg_bcmath_need'],
			'req_ftp'				=> $LNG['req_ftp'],
			'req_ftp_info'			=> $LNG['req_ftp_info'],
			'req_ftp_host'			=> $LNG['req_ftp_host'],
			'req_ftp_username'		=> $LNG['req_ftp_username'],
			'req_ftp_password'		=> $LNG['req_ftp_password'],
			'req_ftp_dir'			=> $LNG['req_ftp_dir'],
			'req_ftp_send'			=> $LNG['req_ftp_send'],
			'req_ftp_pass_info'		=> $LNG['req_ftp_pass_info'],
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
		} elseif ($Page == 2) {
			$GLOBALS['database']['host']			= request_var('host', '');
			$GLOBALS['database']['port']			= request_var('port', 0);
			$GLOBALS['database']['user']			= request_var('user', '', true);
			$GLOBALS['database']['userpw']			= request_var('passwort', '', true);
			$prefix 								= request_var('prefix', '', true);
			$GLOBALS['database']['databasename']    = request_var('db', '', true);

			$connection = new DB_MySQLi(true);

			if (mysqli_connect_errno()) {
				exit($template->message(sprintf($LNG['step2_db_con_fail'], mysqli_connect_error()),"?mode=ins&page=1&lang=".$LANG->GetUser(), 3, true));
			}

			@chmod("../includes/config.php", 0777);
			if (!is_writable('../includes/config.php'))
				exit($template->message($LNG['step2_conf_op_fail'], "?mode=ins&page=1&lang=".$LANG->GetUser(), 3, true));
			touch("../includes/error.log");
			$connection->multi_query(str_replace("prefix_", $prefix, file_get_contents('install.sql')));

			file_put_contents("../includes/config.php", "<?php\n".
			"//### Database access ###//\n\n".
			"\$database['host']          = '".$GLOBALS['database']['host']."';\n".
			"\$database['port']          = '".$GLOBALS['database']['port']."';\n".
			"\$database['user']          = '".$GLOBALS['database']['user']."';\n".
			"\$database['userpw']        = '".$GLOBALS['database']['userpw']."';\n".
			"\$database['databasename']  = '".$GLOBALS['database']['databasename']."';\n".
			"\$database['tableprefix']   = '".$prefix."';\n".
			"\$dbsettings['secretword']  = '2Moons_".mt_rand(1000, 9999999999)."';\n\n".
			"//### Do not change beyond here ###//\n".
			"?>");
			@chmod("../includes/config.php", 0444);

			$template->assign_vars(array(
				'first'					=> $LNG['step2_db_connet_ok'],
				'second'				=> $LNG['step2_db_create_ok'],
				'third'					=> $LNG['step2_conf_create'],
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
				exit($template->message($LNG['step4_need_fields'],"?mode=ins&page=3&lang=".$LANG->GetUser(), 3, true));
				
			require_once(ROOT_PATH . 'includes/config.php');
			$db = new DB_MySQLi();
							
			$SQL  = "INSERT INTO ".USERS." SET ";
			$SQL .= "`id`                = '1', ";
			$SQL .= "`username`          = '". $adm_user ."', ";
			$SQL .= "`email`             = '". $adm_email ."', ";
			$SQL .= "`email_2`           = '". $adm_email ."', ";
			$SQL .= "`ip_at_reg`         = '". $_SERVER['REMOTE_ADDR'] . "', ";
			$SQL .= "`authlevel`         = '3', ";
			$SQL .= "`rights` 			 = 'a:28:{s:19:\"ShowAccountDataPage\";i:1;s:21:\"ShowAccountEditorPage\";i:1;s:14:\"ShowActivePage\";i:1;s:11:\"ShowBanPage\";i:1;s:18:\"ShowClearCachePage\";i:1;s:14:\"ShowConfigPage\";i:1;s:15:\"ShowCreatorPage\";i:1;s:16:\"ShowFacebookPage\";i:1;s:19:\"ShowFlyingFleetPage\";i:1;s:19:\"ShowInformationPage\";i:1;s:13:\"ShowLoginPage\";i:1;s:19:\"ShowMessageListPage\";i:1;s:18:\"ShowModVersionPage\";i:1;s:14:\"ShowModulePage\";i:1;s:15:\"ShowMultiIPPage\";i:1;s:12:\"ShowNewsPage\";i:1;s:21:\"ShowPassEncripterPage\";i:1;s:19:\"ShowQuickEditorPage\";i:1;s:13:\"ShowResetPage\";i:1;s:14:\"ShowRightsPage\";i:1;s:14:\"ShowSearchPage\";i:1;s:20:\"ShowSendMessagesPage\";i:1;s:18:\"ShowStatUpdatePage\";i:1;s:13:\"ShowStatsPage\";i:1;s:15:\"ShowSupportPage\";i:1;s:17:\"ShowTeamspeakPage\";i:1;s:16:\"ShowUniversePage\";i:1;s:14:\"ShowUpdatePage\";i:1;}', ";
			$SQL .= "`id_planet`         = '1', ";
			$SQL .= "`universe`          = '1', ";
			$SQL .= "`galaxy`            = '1', ";
			$SQL .= "`system`            = '1', ";
			$SQL .= "`planet`            = '1', ";
			$SQL .= "`register_time`     = '". TIMESTAMP ."', ";
			$SQL .= "`password`          = '". $md5pass ."';";
			$SQL .= "INSERT INTO ".PLANETS." SET ";
			$SQL .= "`id_owner`          = '1', ";
			$SQL .= "`id_level`          = '0', ";
			$SQL .= "`universe`          = '1', ";
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
			$SQL .= "INSERT INTO ".STATPOINTS." (`id_owner`, `id_ally`, `stat_type`, `tech_rank`, `tech_old_rank`, `tech_points`, `tech_count`, `build_rank`, `build_old_rank`, `build_points`, `build_count`, `defs_rank`, `defs_old_rank`, `defs_points`, `defs_count`, `fleet_rank`, `fleet_old_rank`, `fleet_points`, `fleet_count`, `total_rank`, `total_old_rank`, `total_points`, `total_count`) VALUES ('1', '0', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');";
			$db->multi_query($SQL);

			session_start();
			$SESSION       	= new Session();
			$SESSION->CreateSession(1, $adm_user, 1, 1, 3);
			$_SESSION['admin_login']	= $md5pass;
			header("Location: ../admin.php");
		}
		break;
	case 'convert':
		if(!file_exists(ROOT_PATH . 'includes/config.php'))
			exit($template->message($LNG['convert_install'],"?lang=".$LANG->GetUser(), 3, true));

		if($_POST) {
			require_once(ROOT_PATH . 'includes/config.php');
			$db = new DB_MySQLi();
			$GLOBALS['database']['host']			= $_POST['host'];
			$GLOBALS['database']['port']			= $_POST['port'];
			$GLOBALS['database']['user']			= $_POST['user'];
			$GLOBALS['database']['userpw']			= $_POST['passwort'];
			$GLOBALS['database']['databasename']    = $_POST['db'];
			require_once('class.convert.php');
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