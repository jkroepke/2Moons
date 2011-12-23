<?php

/**
 *  2Moons
 *  Copyright (C) 2011 Jan Kröpke
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
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2009 Lucky
 * @copyright 2011 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.5 (2011-07-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

if(!function_exists('spl_autoload_register'))
	exit("PHP is missing <a href=\"http://php.net/spl\">Standard PHP Library (SPL)</a> support");

define('INSTALL', true);
define('ROOT_PATH', str_replace('\\', '/', dirname(dirname(__FILE__))).'/');

ignore_user_abort(true);
error_reporting(E_ALL ^ E_NOTICE);
header('Content-Type: text/html; charset=UTF-8');
define('TIMESTAMP',	$_SERVER['REQUEST_TIME']);

define('PROTOCOL', (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"]  == 'on') ? 'https://' : 'http://');
define('HTTP_ROOT', str_replace(basename($_SERVER["PHP_SELF"]), '', $_SERVER["PHP_SELF"]));

require_once(ROOT_PATH . 'includes/constants.php');
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

$UNI	= 1;

$template = new Template();

$template->assign(array(
	'lang'			=> $LANG->GetUser(),
	'Selector'		=> $LANG->getAllowedLangs(false),
	'intro_lang'	=> $LNG['intro_lang'],
	'title'			=> $LNG['title_install'].' &bull; 2Moons',
	'intro_instal'	=> $LNG['intro_instal'],
	'menu_intro'	=> $LNG['menu_intro'],
	'menu_install'	=> $LNG['menu_install'],
	'menu_license'	=> $LNG['menu_license'],
	'menu_convert'	=> $LNG['menu_convert'],
));

if(!file_exists(ROOT_PATH.'includes/ENABLE_INSTALL_TOOL')) {
	$template->message($LANG->getExtra('locked_install'), false, 0, true);
	exit;
}

$Language	= request_var('lang', '');
if(!empty($Language) && in_array($Language, $LANG->getAllowedLangs())) {
	setcookie('lang', $Language);
}

$step	  = request_var('step', 0);

if($Mode == 'ajax') {
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
		exit($LNG['req_ftp_error_data']);
	}	
				
	if(!$ftp->changeDir($_GET['path']))
		exit($LNG['req_ftp_error_dir']);

	$CHMOD	= (php_sapi_name() == 'apache2handler') ? 0777 : 0755;		
	$ftp->chmod('cache', $CHMOD);
	$ftp->chmod('cache/sessions', $CHMOD);
	$ftp->chmod('includes', $CHMOD);
	$ftp->chmod('install', $CHMOD);
	exit;
}

switch ($step) {
	case 1:
		if(isset($_POST['post'])) {
			if(isset($_POST['accept'])) {
				redirectTo('index.php?step=2');
			} else {
				$template->assign(array(
					'accept'	=> false,
				));
			}
		}
		$template->show('ins_license.tpl');
	break;
	case 2:
		$error 	= false;
		$ftp 	= false;
		if(version_compare(PHP_VERSION, "5.2.5", ">=")){
			$PHP = "<span class=\"yes\">".$LNG['reg_yes'].", v".PHP_VERSION."</span>";
		} else {
			$PHP = "<span class=\"no\">".$LNG['reg_no'].", v".PHP_VERSION."</span>";
			$error	= true;
		}
		
		if(class_exists('mysqli')){
			$mysqli = "<span class=\"yes\">".$LNG['reg_yes']."</span>";
		} else {
			$mysqli = "<span class=\"no\">".$LNG['reg_no']."</span>";
			$error	= true;
		}
				
		if(function_exists('json_encode')){
			$json = "<span class=\"yes\">".$LNG['reg_yes']."</span>";
		} else {
			$json = "<span class=\"no\">".$LNG['reg_no']."</span>";
			$error	= true;
		}
		
		if(function_exists('ini_set')){
			$iniset = "<span class=\"yes\">".$LNG['reg_yes']."</span>";
		} else {
			$iniset = "<span class=\"no\">".$LNG['reg_no']."</span>";
			$error	= true;
		}
	
		if(!ini_get('register_globals')){
			$global = "<span class=\"yes\">".$LNG['reg_yes']."</span>";
		} else {
			$global = "<span class=\"no\">".$LNG['reg_no']."</span>";
			$error	= true;
		}

		if(!extension_loaded('gd')) {
			$gdlib = "<span class=\"no\">".$LNG['reg_no']."</span>";
		} else {
			$gdVerion = '0.0.0';
			if (function_exists('gd_info')) {
				$temp = gd_info();
				$match = array();
				if (preg_match('!([0-9]+\.[0-9]+(?:\.[0-9]+)?)!', $temp['GD Version'], $match)) {
					if (preg_match('/^[0-9]+\.[0-9]+$/', $match[1])) $match[1] .= '.0';
						$gdVerion = $match[1];
				}
			}
			$gdlib = "<span class=\"yes\">".$LNG['reg_yes'].", v".$gdVerion."</span>";
		}
		
		clearstatcache();
		
		if(file_exists(ROOT_PATH."includes/config.php") || @touch(ROOT_PATH."includes/config.php")){
			if(is_writable(ROOT_PATH."includes/config.php")){
				$chmod = "<span class=\"yes\"> - ".$LNG['reg_writable']."</span>";
			} else {
				$chmod = " - <span class=\"no\">".$LNG['reg_not_writable']."</span>";
				$error	= true;
				$ftp	= true;
			}
			$config = "<tr><td class=\"transparent left\"><p>".sprintf($LNG['reg_file'], 'includes/config.php')."</p></td><td class=\"transparent\"><span class=\"yes\">".$LNG['reg_found']."</span>".$chmod."</td></tr>";
		} else {
			$config = "<tr><td class=\"transparent left\"><p>".sprintf($LNG['reg_file'], 'includes/config.php')."</p></td><td class=\"transparent\"><span class=\"no\">".$LNG['reg_not_found']."</span></td></tr>";
			$error	= true;
			$ftp	= true;
		}
		$directories = array('cache/', 'cache/sessions/', 'includes/');
		$dirs = "";
		foreach ($directories as $dir)
		{
			if(is_writable(ROOT_PATH . $dir)) {
					$chmod = "<span class=\"yes\"> - ".$LNG['reg_writable']."</span>";
				} else {
					$chmod = " - <span class=\"no\">".$LNG['reg_not_writable']."</span>";
					$error	= true;
					$ftp	= true;
				}
			$dirs .= "<tr><td class=\"transparent left\"><p>".sprintf($LNG['reg_dir'], $dir)."</p></td><td class=\"transparent\"><span class=\"yes\">".$LNG['reg_found']."</span>".$chmod."</td></tr>";
		}

		if($error == false){
			$done = '<tr class="noborder"><td colspan="2" class="transparent"><a href="index.php?step=3"><button style="cursor: pointer;">'.$LNG['continue'].'</button<</a></td></tr>';
		}
		$template->assign(array(
			'dir'					=> $dirs,
			'json'					=> $json,
			'done'					=> $done,
			'config'				=> $config,
			'gdlib'					=> $gdlib,
			'PHP'					=> $PHP,
			'mysqli'				=> $mysqli,
			'ftp'					=> $ftp,
			'iniset'				=> $iniset,
			'global'				=> $global
		));
		$template->show('ins_req.tpl');
	break;
	case 3:
		$template->show('ins_form.tpl');
	break;
	case 4:
		$host	= request_var('host', '');
		$port	= request_var('port', 3306);
		$user	= request_var('user', '', true);
		$userpw	= request_var('passwort', '', true);
		$dbname	= request_var('dbname', '', true);
		$prefix	= request_var('prefix', 'uni1_');
		
		$template->assign(array(
			'host'		=> $host,
			'port'		=> $port,
			'user'		=> $user,
			'dbname'	=> $dbname,
			'prefix'	=> $prefix,
		));
		
		if (empty($dbname)) {
			$template->assign(array(
				'class'		=> 'fatalerror',
				'message'	=> $LNG['step2_db_no_dbname'],
			));
			$template->show('ins_step4.tpl');
			exit;
		}
		
		if (strlen($prefix) > 36) {
			$template->assign(array(
				'class'		=> 'fatalerror',
				'message'	=> $LNG['step2_db_too_long'],
			));
			$template->show('ins_step4.tpl');
			exit;
		}
		
		if (strspn($table_prefix, '-./\\') !== 0) {
			$template->assign(array(
				'class'		=> 'fatalerror',
				'message'	=> $LNG['step2_prefix_invalid'],
			));
			$template->show('ins_step4.tpl');
			exit;
		}

		@touch(ROOT_PATH."includes/config.php");
		if (!is_writable(ROOT_PATH."includes/config.php")) {
			$template->assign(array(
				'class'		=> 'fatalerror',
				'message'	=> $LNG['step2_conf_op_fail'],
			));
			$template->show('ins_step4.tpl');
			exit;
		}
		
		$database					= array();
		$database['host']			= $host;
		$database['port']			= $port;
		$database['user']			= $user;
		$database['userpw']			= $userpw;
		$database['databasename']	= $dbname;
		$database['tableprefix']	= $prefix;
		
		require_once(ROOT_PATH . 'includes/classes/class.MySQLi.php');
		
		try {
			$db = new DB_MySQLi();
		} catch (Exception $e) {
			$template->assign(array(
				'class'		=> 'fatalerror',
				'message'	=> $LNG['step2_db_con_fail'].'</p><p>'.$e->getMessage(),
			));
			$template->show('ins_step4.tpl');
			exit;
		}
		
		@touch(ROOT_PATH."includes/error.log");
		file_put_contents(ROOT_PATH."includes/config.php", sprintf(file_get_contents(ROOT_PATH."includes/config.sample.php"), $host, $port, $user, $userpw, $dbname, $prefix));
		$template->assign(array(
			'class'		=> 'noerror',
			'message'	=> $LNG['step2_db_done'],
		));
		$template->show('ins_step4.tpl');
		exit;
	break;
	case 5:
		$template->show('ins_step5.tpl');
	break;
	case 6:
		require_once(ROOT_PATH . 'includes/config.php');
		require_once(ROOT_PATH . 'includes/dbtables.php');	
		require_once(ROOT_PATH . 'includes/classes/class.MySQLi.php');
		$db = new DB_MySQLi();
		try {
			$db->multi_query(str_replace("prefix_", $database['tableprefix'], file_get_contents('install.sql')));
			$GLOBALS['CONF']	= array(
				'timezone'			=> 0,
				'lang'				=> '',
				'OverviewNewsText'	=> '',
				'uni_name'			=> '',
				'close_reason'		=> '',
			);
			
			update_config(array(
				'timezone'			=> ((int) date("Z") / 3600) - (int) date("I"),
				'lang'				=> $LANG->GetUser(),
				'OverviewNewsText'	=> $LNG['sql_welcome'].'1.7',
				'uni_name'			=> $LNG['sql_universe'].' 1',
				'close_reason'		=> $LNG['sql_close_reason'],
			), 1);
			redirectTo('index.php?step=7');
		} catch (Exception $e) {
				$template->assign(array(
				'class'		=> 'fatalerror',
				'message'	=> $LNG['step3_db_error'].'</p><p>'.$db->error,
			));
			$template->show('ins_step4.tpl');
			exit;
		}
	break;
	case 7:
		$template->show('ins_acc.tpl');
	break;
	case 8:
		$AdminUsername	= request_var('username', '', true);
		$AdminPassword	= request_var('password', '', true);
		$AdminMail		= request_var('email', '');
		$MD5Password	= md5($AdminPassword);
		
		$template->assign(array(
			'username'	=> $AdminUsername,
			'email'		=> $AdminMail,
		));
		
		if (empty($AdminUsername) && empty($AdminPassword) && empty($AdminMail)) {
			$template->assign(array(
				'message'	=> $LNG['step4_need_fields'],
			));
			$template->show('ins_step8error.tpl');
			exit;
		}
			
		require_once(ROOT_PATH . 'includes/config.php');
		require_once(ROOT_PATH . 'includes/dbtables.php');	
		require_once(ROOT_PATH . 'includes/classes/class.MySQLi.php');
		$db = new DB_MySQLi();
						
		$SQL  = "INSERT INTO ".USERS." SET ";
		$SQL .= "`id`                = '1', ";
		$SQL .= "`username`          = '".$AdminUsername."', ";
		$SQL .= "`password`          = '".$MD5Password."', ";
		$SQL .= "`email`             = '".$AdminMail."', ";
		$SQL .= "`email_2`           = '".$AdminMail."', ";
		$SQL .= "`ip_at_reg`         = '".$_SERVER['REMOTE_ADDR']. "', ";
		$SQL .= "`lang` 	         = '".$LANG->GetUser(). "', ";
		$SQL .= "`authlevel`         = '".AUTH_ADM."', ";
		$SQL .= "`rights` 			 = '', ";
		$SQL .= "`id_planet`         = 1, ";
		$SQL .= "`universe`          = 1, ";
		$SQL .= "`galaxy`            = 1, ";
		$SQL .= "`system`            = 1, ";
		$SQL .= "`planet`            = 1, ";
		$SQL .= "`register_time`     = ". TIMESTAMP .";";
		$db->query($SQL);
				
		require_once(ROOT_PATH.'includes/functions/CreateOnePlanetRecord.php');
		require_once(ROOT_PATH.'includes/classes/class.Session.php');
		CreateOnePlanetRecord(1, 1, 1, 1, 1, '', true, AUTH_ADM);
		$SESSION       	= new Session();
		$SESSION->CreateSession(1, $AdminUsername, 1, 1, 3);
		$template->show('ins_step8.tpl');
	break;
	default:
		$template->assign(array(
			'intro_text'	=> $LNG['intro_text'],
			'intro_welcome'	=> $LNG['intro_welcome'],
			'intro_install'	=> $LNG['intro_install'],
		));
		$template->show('ins_intro.tpl');
	break;
}
?>