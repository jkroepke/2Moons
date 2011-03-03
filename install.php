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

define('INSTALL', true);
define('ROOT_PATH', str_replace('\\', '/',dirname(__FILE__)).'/');

ignore_user_abort(true);
error_reporting(E_ALL ^ E_NOTICE);
header('Content-Type: text/html; charset=UTF-8');
define('TIMESTAMP',	$_SERVER['REQUEST_TIME']);

require_once(ROOT_PATH . 'includes/GeneralFunctions.php');
set_exception_handler('exception_handler');

require_once(ROOT_PATH . 'includes/classes/class.Lang.php');
require_once(ROOT_PATH . 'includes/classes/class.theme.php');
require_once(ROOT_PATH . 'includes/classes/class.template.php');
	
$THEME	= new Theme();	
$THEME->setUserTheme('gow');	
$LANG	= new Language();	
$LANG->GetLangFromBrowser();
$LANG->includeLang(array('INGAME', 'INSTALL'));

$Mode     = request_var('mode', 'intro');
$Page     = request_var('page', 1);
$phpself  = $_SERVER['PHP_SELF'];
$nextpage = $Page + 1;
$template = new template();
$template->assign_vars(array(
	'lang'			=> $LANG->GetUser(),
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
			'Selector'		=> $LANG->getAllowedLangs(false),
			'intro_text'	=> $LNG['intro_text'],
			'intro_welcome'	=> $LNG['intro_welcome'],
			'intro_install'	=> $LNG['intro_install'],
			'intro_lang'	=> $LNG['intro_lang'],
		));
		$template->show('install/ins_intro.tpl');
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
			if(is_writable(ROOT_PATH."includes/config.php")){
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
		$directories = array('cache/', 'cache/sessions/', 'raports/', 'includes/');
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
			$done = "<tr><td colspan=\"2\" class=\"transparent\"><a href=\"?mode=ins&page=1&amp;lang=".$LANG->GetUser()."\">".$LNG['continue']."</a></td></tr>";
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
	case 'ajax':
		$action	= request_var('action', '');
		switch($action) {
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
				
				$CHMOD	= (php_sapi_name() == 'apache2handler') ? 0666 : 0755;		
				$ftp->chmod('cache', $CHMOD);
				$ftp->chmod('cache/sessions', $CHMOD);
				$ftp->chmod('raports', $CHMOD);
				$ftp->chmod('includes', $CHMOD);
				exit;
			break;
			case 'install':
				$database['host']			= request_var('host', '');
				$database['port']			= request_var('port', 0);
				$database['user']			= request_var('user', '', true);
				$database['userpw']			= request_var('passwort', '', true);
				$database['databasename']	= request_var('db', '', true);
				$prefix						= request_var('prefix', '', true);
				@touch(ROOT_PATH."includes/config.php");
				if (!is_writable(ROOT_PATH."includes/config.php"))
					exit(json_encode(array('msg' => $LNG['step2_conf_op_fail'], 'error' => true)));
				
				require_once(ROOT_PATH . 'includes/classes/class.MySQLi.php');
				$db = new DB_MySQLi(false);
				if (mysqli_connect_error())
					exit(json_encode(array('msg' => sprintf($LNG['step2_db_con_fail'], mysqli_connect_error()), 'error' => true)));
					
				@touch(ROOT_PATH."includes/error.log");
				ob_start();
				$db->multi_query(str_replace("prefix_", $prefix, file_get_contents('install.sql')));
				$MSG	= ob_get_clean();
				
				if (!empty($MSG))
					exit(sprintf($LNG['step2_db_error'], $MSG));

				file_put_contents(ROOT_PATH."includes/config.php", sprintf(file_get_contents(ROOT_PATH."includes/config.sample.php"), $database['host'], $database['port'], $database['user'], $database['userpw'], $database['databasename'], $prefix, mt_rand(1000, 9999999999)));

				@chmod(ROOT_PATH."includes/config.php", 0444);
				exit(json_encode(array('msg' => implode("\r\n", array($LNG['step2_db_connet_ok'], $LNG['step2_db_create_ok'], $LNG['step2_conf_create'])), 'error' => false)));
			break;
		}
	break;
	case 'ins':
		switch($Page) {
			case 1:
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
			break;
			case 2:
				$template->assign_vars(array(
					'step3_create_admin'	=> $LNG['step3_create_admin'],
					'step3_admin_name'		=> $LNG['step3_admin_name'],
					'step3_admin_pass'		=> $LNG['step3_admin_pass'],
					'step3_admin_mail'		=> $LNG['step3_admin_mail'],
					'continue'				=> $LNG['continue'],
				));
				$template->show('install/ins_acc.tpl');
			break;
			case 3:
				$adm_user   = $_POST['adm_user'];
				$adm_pass   = $_POST['adm_pass'];
				$adm_email  = $_POST['adm_email'];
				$md5pass    = md5($adm_pass);

				if (empty($_POST['adm_user']) && empty($_POST['adm_pas']) && empty($_POST['adm_email']))
					exit($template->message($LNG['step4_need_fields'],"?mode=ins&page=3&lang=".$LANG->GetUser(), 3, true));
					
				require_once(ROOT_PATH . 'includes/config.php');
				require_once(ROOT_PATH . 'includes/constants.php');	
				require_once(ROOT_PATH . 'includes/classes/class.MySQLi.php');
				$db = new DB_MySQLi();
								
				$SQL  = "INSERT INTO ".USERS." SET ";
				$SQL .= "`id`                = '1', ";
				$SQL .= "`username`          = '". $adm_user ."', ";
				$SQL .= "`email`             = '". $adm_email ."', ";
				$SQL .= "`email_2`           = '". $adm_email ."', ";
				$SQL .= "`ip_at_reg`         = '". $_SERVER['REMOTE_ADDR'] . "', ";
				$SQL .= "`ip_at_reg`         = '". $LANG->GetUser() . "', ";
				$SQL .= "`authlevel`         = '3', ";
				$SQL .= "`rights` 			 = '', ";
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
				$SQL .= "UPDATE ".CONFIG." SET `lang` = '".$LANG->GetUser()."';";
				$db->multi_query($SQL);

				ini_set('session.save_path', ROOT_PATH.'cache/sessions');
				ini_set('upload_tmp_dir', ROOT_PATH.'cache/sessions');
				ini_set('session.use_cookies', '1');
				ini_set('session.use_only_cookies', '1');
				session_set_cookie_params(SESSION_LIFETIME, '/');
				session_cache_limiter('nocache');
				session_name($dbsettings["secretword"]);
				ini_set('session.use_trans_sid', 0);
				ini_set('session.auto_start', '0');
				ini_set('session.serialize_handler', 'php');  
				ini_set('session.gc_maxlifetime', SESSION_LIFETIME);
				ini_set('session.gc_probability', '1');
				ini_set('session.gc_divisor', '1000');
				ini_set('session.bug_compat_warn', '0');
				ini_set('session.bug_compat_42', '0');
				ini_set('session.cookie_httponly', true);
				require_once(ROOT_PATH . 'includes/classes/class.Session.php');
				session_start();
				$SESSION       	= new Session();
				$SESSION->CreateSession(1, $adm_user, 1, 1, 3);
				$_SESSION['admin_login']	= $md5pass;
				redirectTo('admin.php');
			break;
		}
	break;
}
?>