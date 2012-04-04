<?php

/**
 *  2Moons
 *  Copyright (C) 2011 Jan
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
 * @author Jan <info@2moons.cc>
 * @copyright 2009 Lucky
 * @copyright 2011 Jan <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.5 (2011-07-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

if(!function_exists('spl_autoload_register')) {
	exit("PHP is missing <a href=\"http://php.net/spl\">Standard PHP Library (SPL)</a> support");
}

define('MODE', 'INSTALL');
define('ROOT_PATH', str_replace('\\', '/', dirname(dirname(__FILE__))).'/');

require(ROOT_PATH . 'includes/common.php');

$THEME->setUserTheme('gow');

$LANG->GetLangFromBrowser();
$LANG->includeLang(array('INGAME', 'INSTALL'));

$UNI	= 1;

$template = new template();

$template->assign(array(
	'lang'			=> $LANG->GetUser(),
	'Selector'		=> $LANG->getAllowedLangs(false),
	'intro_lang'	=> $LNG['intro_lang'],
	'title'			=> $LNG['title_install'].' &bull; 2Moons',
	'menu_intro'	=> $LNG['menu_intro'],
	'menu_install'	=> $LNG['menu_install'],
	'menu_license'	=> $LNG['menu_license'],
));

$enableInstallToolFile	= ROOT_PATH.'includes/ENABLE_INSTALL_TOOL';
$quickstartFile			= ROOT_PATH.'includes/FIRST_INSTALL';

// If include/FIRST_INSTALL is present and can be deleted, automatically create include/ENABLE_INSTALL_TOOL
if (is_file($quickstartFile) && is_writeable($quickstartFile) && unlink($quickstartFile)) {
	@touch($enableInstallToolFile);
}

// Only allow Install Tool access if the file "include/ENABLE_INSTALL_TOOL" is found
if (is_file($enableInstallToolFile) && (time() - filemtime($enableInstallToolFile) > 3600)) {
	$content = file_get_contents($enableInstallToolFile);
	$verifyString = 'KEEP_FILE';

	if (trim($content) !== $verifyString) {
		// Delete the file if it is older than 3600s (1 hour)
		unlink($enableInstallToolFile);
	}
}

if (!is_file($enableInstallToolFile)) {
	$template->message($LANG->getExtra('locked_install'), false, 0, true);
	exit;
}

$Language	= HTTP::_GP('lang', '');
if(!empty($Language) && in_array($Language, $LANG->getAllowedLangs())) {
	setcookie('lang', $Language);
}

$step	  = HTTP::_GP('step', 0);
$mode	  = HTTP::_GP('mode', '');

if($mode == 'ajax') {
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
				HTTP::redirectTo('index.php?step=2');
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
		if(version_compare(PHP_VERSION, '5.3.2', ">=")){
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
		
		$directories = array('cache/', 'cache/templates/', 'includes/');
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
			$done = '<tr class="noborder"><td colspan="2" class="transparent"><a href="index.php?step=3"><button style="cursor: pointer;">'.$LNG['continue'].'</button></a></td></tr>';
		} else {
			$done = '';
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
		$host	= HTTP::_GP('host', '');
		$port	= HTTP::_GP('port', 3306);
		$user	= HTTP::_GP('user', '', true);
		$userpw	= HTTP::_GP('passwort', '', true);
		$dbname	= HTTP::_GP('dbname', '', true);
		$prefix	= HTTP::_GP('prefix', 'uni1_');
		
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
		
		if (strspn($prefix, '-./\\') !== 0) {
			$template->assign(array(
				'class'		=> 'fatalerror',
				'message'	=> $LNG['step2_prefix_invalid'],
			));
			$template->show('ins_step4.tpl');
			exit;
		}
		
		if (is_file(ROOT_PATH."includes/config.php") && filesize(ROOT_PATH."includes/config.php") != 0) {
			$template->assign(array(
				'class'		=> 'fatalerror',
				'message'	=> $LNG['step2_config_exists'],
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
		
		require_once(ROOT_PATH . 'includes/classes/class.Database.php');
		
		try {
			$DATABASE = new Database();
		} catch (Exception $e) {
			$template->assign(array(
				'class'		=> 'fatalerror',
				'message'	=> $LNG['step2_db_con_fail'].'</p><p>'.$e->getMessage(),
			));
			$template->show('ins_step4.tpl');
			exit;
		}
		
		@touch(ROOT_PATH."includes/error.log");
		
		$blowfish	= substr(str_shuffle('./0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 22);
		
		file_put_contents(ROOT_PATH."includes/config.php", sprintf(file_get_contents(ROOT_PATH."includes/config.sample.php"), $host, $port, $user, $userpw, $dbname, $prefix, $blowfish));
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
		require_once(ROOT_PATH . 'includes/classes/class.Database.php');
		$GLOBALS['DATABASE']	= new Database();
		try {
			$SQL	= file_get_contents('install.sql');
			$SQL	= str_replace('$PREFIX$', $database['tableprefix'], $SQL);
			
			$GLOBALS['DATABASE']->multi_query($SQL);
			
			$gameConfig	= array(
				'version'		=> '',
				'language'		=> '',
				'timezone'		=> '',
			);
			
			$uniConfig	= array(
				'newsEnable	'	=> '',
				'newsText'		=> '',
				'uniName'		=> '',
				'enableReason'	=> '',
			);
			
			setConfig(array(
				'version'		=> file_get_contents('VERSION'),
				'language'		=> @date_default_timezone_get(),
				'timezone'		=> $LANG->GetUser(),
				'newsEnable	'	=> 1,
				'newsText'		=> $LNG['sql_welcome'].'1.7',
				'uniName'		=> $LNG['fcm_universe'].' 1',
				'enableReason'	=> $LNG['sql_close_reason'],
			), 1);
			
			HTTP::redirectTo('index.php?step=7');
		} catch (Exception $e) {
			$error	= !empty($GLOBALS['DATABASE']->error) ? $GLOBALS['DATABASE']->error : $e->getMessage();
			
			$template->assign(array(
				'class'		=> 'fatalerror',
				'message'	=> $LNG['step3_db_error'].'</p><p>'.$error,
				'host'		=> $database['host'],
				'port'		=> $database['port'],
				'user'		=> $database['user'],
				'dbname'	=> $database['databasename'],
				'prefix'	=> $database['tableprefix'],
			));
			$template->show('ins_step4.tpl');

			unlink(ROOT_PATH."includes/config.php");
			exit;
		}
	break;
	case 7:
		$template->show('ins_acc.tpl');
	break;
	case 8:
		$AdminUsername		= HTTP::_GP('username', '', UTF8_SUPPORT);
		$AdminPassword		= HTTP::_GP('password', '', UTF8_SUPPORT);
		$AdminMail			= HTTP::_GP('email', '');

		require_once(ROOT_PATH . 'includes/config.php');
		require_once(ROOT_PATH . 'includes/dbtables.php');
		$DATABASE	= new Database();
			
		$CACHE->add('config', 'ConfigBuildCache');
		$CACHE->add('configuni', 'ConfigUniverseBuildCache');
		$CACHE->add('universe', 'UniverseBuildCache');
		$CACHE->add('vars', 'VarsBuildCache');
		$CACHE->flushAll();
		
		$VARS				= $CACHE->get('vars');
		$gameConfig			= $CACHE->get('config');
		$uniAllConfig		= $CACHE->get('configuni');
		
		$encryptPassword	= PlayerUntl::cryptPassword($AdminPassword);
		
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
		
		list($userID, $planetID) = PlayerUntl::createPlayer(1, $AdminUsername, $encryptPassword, $AdminMail, 1, 1, 2, NULL, AUTH_ADM, $LANG->GetUser());
						
		Session::Create($userID, $planetID);
		
		$_SESSION['admin_login']	= $encryptPassword;
		
		@unlink($enableInstallToolFile);
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
