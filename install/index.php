<?php

/**
 *  2Moons
 *   by Jan-Otto Kröpke 2009-2016
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan-Otto Kröpke <slaver7@gmail.com>
 * @copyright 2009 Lucky
 * @copyright 2016 Jan-Otto Kröpke <slaver7@gmail.com>
 * @licence MIT
 * @version 1.8.0
 * @link https://github.com/jkroepke/2Moons
 */

define('MODE', 'INSTALL');
define('ROOT_PATH', str_replace('\\', '/', dirname(dirname(__FILE__))) . '/');
set_include_path(ROOT_PATH);
chdir(ROOT_PATH);

require 'includes/common.php';
$THEME->setUserTheme('gow');
$LNG = new Language;
$LNG->getUserAgentLanguage();
$LNG->includeData(array('L18N', 'INGAME', 'INSTALL', 'CUSTOM'));

$mode = HTTP::_GP('mode', '');

$template = new template();
$template->setCaching(false);
$template->assign(array(
	'lang'       => $LNG->getLanguage(),
	'Selector'   => $LNG->getAllowedLangs(false),
	'title'      => $LNG['title_install'] . ' &bull; 2Moons',
	'header'     => $LNG['menu_install'],
	'canUpgrade' => file_exists('includes/config.php') && filesize('includes/config.php') !== 0
));

$enableInstallToolFile = 'includes/ENABLE_INSTALL_TOOL';
$quickStartFile        = 'includes/FIRST_INSTALL';
// If include/FIRST_INSTALL is present and can be deleted, automatically create include/ENABLE_INSTALL_TOOL
if (is_file($quickStartFile) && is_writeable($quickStartFile) && unlink($quickStartFile)) {
	@touch($enableInstallToolFile);
}
// Only allow Install Tool access if the file "include/ENABLE_INSTALL_TOOL" is found
if (is_file($enableInstallToolFile) && (time() - filemtime($enableInstallToolFile) > 3600)) {
	$content      = file_get_contents($enableInstallToolFile);
	$verifyString = 'KEEP_FILE';
	if (trim($content) !== $verifyString) {
		// Delete the file if it is older than 3600s (1 hour)
		unlink($enableInstallToolFile);
	}
}
if (!is_file($enableInstallToolFile)) {

    switch ($mode) {
        case 'upgrade':
            $message = $LNG->getTemplate('locked_upgrade');
        break;
        default:
            $message = $LNG->getTemplate('locked_install');
        break;
    }
    $template->message($message, false, 0, true);
	exit;
}
$language = HTTP::_GP('lang', '');

if (!empty($language) && in_array($language, $LNG->getAllowedLangs())) {
	setcookie('lang', $language);
}

switch ($mode) {
	case 'ajax':
		require 'includes/libs/ftp/ftp.class.php';
		require 'includes/libs/ftp/ftpexception.class.php';
		$LNG->includeData(array('ADMIN'));
		$connectionConfig = array(
			"host"     => $_GET['host'],
			"username" => $_GET['user'],
			"password" => $_GET['pass'],
			"port"     => 21
		);

		try {
			$ftp = FTP::getInstance();
			$ftp->connect($connectionConfig);
		}
		catch (FTPException $error) {
			exit($LNG['req_ftp_error_data']);
		}
		if (!$ftp->changeDir($_GET['path'])) {
			exit($LNG['req_ftp_error_dir']);
		}

		$CHMOD = (php_sapi_name() == 'apache2handler') ? 0777 : 0755;
		$ftp->chmod('cache', $CHMOD);
		$ftp->chmod('includes', $CHMOD);
		$ftp->chmod('install', $CHMOD);
		break;
	case 'upgrade':
		// Willkommen zum Update page. Anzeige, von und zu geupdatet wird. Informationen, dass ein backup erstellt wird.

        try {
            $sql    = "SELECT dbVersion FROM %%SYSTEM%%;";

            $dbVersion  = Database::get()->selectSingle($sql, array(), 'dbVersion');
        } catch (Exception $e) {
            $dbVersion  = 0;
        }

        $updates = array();

        $fileRevision = 0;

		$directoryIterator = new DirectoryIterator(ROOT_PATH . 'install/migrations/');
		/** @var $fileInfo DirectoryIterator */
		foreach ($directoryIterator as $fileInfo) {
			if (!$fileInfo->isFile() || !preg_match('/^migration_\d+/', $fileInfo->getFilename())) {
				continue;
			}

			$fileRevision = substr($fileInfo->getFilename(), 10, -4);

            if ($fileRevision <= $dbVersion || $fileRevision > DB_VERSION_REQUIRED) {
                continue;
            }

            $updates[$fileInfo->getPathname()] = makebr(str_replace('%PREFIX%', DB_PREFIX, file_get_contents($fileInfo->getPathname())));
		}

		$template->assign_vars(array(
			'file_revision' => min(DB_VERSION_REQUIRED, $fileRevision),
			'sql_revision'  => $dbVersion,
            'updates'       => $updates,
			'header'        => $LNG['menu_upgrade']
		));

		$template->show('ins_update.tpl');
		break;
	case 'doupgrade':
		// TODO:Need a rewrite!
		require 'includes/config.php';

		// Create a Backup
        $sqlTableRaw  = Database::get()->nativeQuery("SHOW TABLE STATUS FROM `" . DB_NAME . "`;");
		$prefixCounts = strlen(DB_PREFIX);
		$dbTables     = array();
		foreach($sqlTableRaw as $table)
		{
			if (DB_PREFIX == substr($table['Name'], 0, $prefixCounts)) {
				$dbTables[] = $table['Name'];
			}
		}

		if (empty($dbTables))
		{
			throw new Exception('No tables found for dump.');
		}

        @set_time_limit(600);

		$fileName = '2MoonsBackup_' . date('Y_m_d_H_i_s', TIMESTAMP) . '.sql';
		$filePath = 'includes/backups/' . $fileName;
		require 'includes/classes/SQLDumper.class.php';
		$dump = new SQLDumper;
		$dump->dumpTablesToFile($dbTables, $filePath);

        try {
            $sql	= "SELECT dbVersion FROM %%SYSTEM%%;";

            $dbVersion	= Database::get()->selectSingle($sql, array(), 'dbVersion');
        } catch (Exception $e) {
            $dbVersion  = 0;
        }

		$httpRoot = PROTOCOL . HTTP_HOST . str_replace(array('\\', '//'), '/', dirname(dirname($_SERVER['SCRIPT_NAME'])) . '/');
		$revision = $dbVersion;
		$fileList = array();
		$directoryIterator = new DirectoryIterator(ROOT_PATH . 'install/migrations/');
		/** @var $fileInfo DirectoryIterator */
		foreach ($directoryIterator as $fileInfo) {
			if (!$fileInfo->isFile()) {
				continue;
			}
			$fileRevision = substr($fileInfo->getFilename(), 10, -4);
			if ($fileRevision > $revision && $fileRevision <= DB_VERSION_REQUIRED) {
				$fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
				$key           = $fileRevision . ((int)$fileExtension === 'php');
				$fileList[$key] = array(
					'fileName'      => $fileInfo->getFilename(),
					'fileRevision'  => $fileRevision,
					'fileExtension' => $fileExtension
				);
			}
		}
		ksort($fileList);
        foreach ($fileList as $fileInfo) {
            switch ($fileInfo['fileExtension']) {
                case 'php':
                    copy(ROOT_PATH.'install/migrations/' . $fileInfo['fileName'], ROOT_PATH.$fileInfo['fileName']);
                    $ch = curl_init($httpRoot . $fileInfo['fileName']);
                    curl_setopt($ch, CURLOPT_HEADER, false);
                    curl_setopt($ch, CURLOPT_NOBODY, true);
                    curl_setopt($ch, CURLOPT_MUTE, true);
                    curl_exec($ch);
                    if (curl_errno($ch)) {
                        $errorMessage = 'CURL-Error on update ' . basename($fileInfo['filePath']) . ':' . curl_error($ch);
                        try {
                            $dump->restoreDatabase($filePath);
                            $message = 'Update error.<br><br>' . $errorMessage . '<br><br><b><i>Backup restored.</i></b>';
                        }
                        catch (Exception $e) {
                            $message = 'Update error.<br><br>' . $errorMessage . '<br><br><b><i>Can not restore backup. Your game is maybe broken right now.</i></b><br><br>Restore error:<br>' . $e->getMessage();
                        }
                        throw new Exception($message);
                    }
                    curl_close($ch);
                    unlink($fileInfo['fileName']);
                    break;
                case 'sql';
                    $data = file_get_contents(ROOT_PATH . 'install/migrations/' . $fileInfo['fileName']);
                    try {
                        $queries	= explode(";\n", str_replace('%PREFIX%', DB_PREFIX, $data));
                        $queries	= array_filter($queries);
                        foreach($queries as $query)
                        {
							try {
								// alter table IF NOT EXISTS
								Database::get()->nativeQuery(trim($query));
							}
							catch (Exception $e) {
								error_log('Query: [' . $query . '] failed. Error: ' . $e->getMessage() . '. Skipped');
							}
                        }
                    }
                    catch (Exception $e) {
                        $errorMessage = $e->getMessage();
                        try {
                            $dump->restoreDatabase($filePath);
                            $message = 'Update error.<br><br>' . $errorMessage . '<br><br><b><i>Backup restored.</i></b>';
                        }
                        catch (Exception $e) {
                            $message = 'Update error.<br><br>' . $errorMessage . '<br><br><b><i>Can not restore backup. Your game is maybe broken right now.</i></b><br><br>Restore error:<br>' . $e->getMessage();
                        }
                        throw new Exception($message);
                    }
                    break;
            }
        }
        $revision = end($fileList);
        $revision = $revision['fileRevision'];

        Database::get()->update("UPDATE %%SYSTEM%% SET dbVersion = " . DB_VERSION_REQUIRED . ";");

        ClearCache();

		$template->assign_vars(array(
			'update'   => !empty($fileList),
			'revision' => $revision,
			'header'   => $LNG['menu_upgrade'],
        ));
		$template->show('ins_doupdate.tpl');
        unlink($enableInstallToolFile);
		break;
	case 'install':
		$step = HTTP::_GP('step', 0);
		switch ($step) {
			case 1:
				if (isset($_POST['post'])) {
					if (isset($_POST['accept'])) {
						HTTP::redirectTo('index.php?mode=install&step=2');
					}
					else {
						$template->assign(array(
							'accept' => false
                        ));
					}
				}
				$template->show('ins_license.tpl');
				break;
			case 2:
				$error = false;
				$ftp   = false;
				if (version_compare(PHP_VERSION, "5.3.0", ">=")) {
					$PHP = "<span class=\"yes\">" . $LNG['reg_yes'] . ", v" . PHP_VERSION . "</span>";
				}
				else {
					$PHP   = "<span class=\"no\">" . $LNG['reg_no'] . ", v" . PHP_VERSION . "</span>";
					$error = true;
				}

				if (class_exists('PDO') && in_array('mysql', PDO::getAvailableDrivers())) {
					$pdo = "<span class=\"yes\">" . $LNG['reg_yes'] . "</span>";
				}
				else {
					$pdo   = "<span class=\"no\">" . $LNG['reg_no'] . "</span>";
					$error = true;
				}
				if (function_exists('json_encode')) {
					$json = "<span class=\"yes\">" . $LNG['reg_yes'] . "</span>";
				}
				else {
					$json  = "<span class=\"no\">" . $LNG['reg_no'] . "</span>";
					$error = true;
				}
				if (function_exists('ini_set')) {
					$iniset = "<span class=\"yes\">" . $LNG['reg_yes'] . "</span>";
				}
				else {
					$iniset = "<span class=\"no\">" . $LNG['reg_no'] . "</span>";
					$error  = true;
				}
				if (!ini_get('register_globals')) {
					$global = "<span class=\"yes\">" . $LNG['reg_yes'] . "</span>";
				}
				else {
					$global = "<span class=\"no\">" . $LNG['reg_no'] . "</span>";
					$error  = true;
				}
				if (!extension_loaded('gd')) {
					$gdlib = "<span class=\"no\">" . $LNG['reg_no'] . "</span>";
				}
				else {
					$gdVerion = '0.0.0';
					if (function_exists('gd_info')) {
						$temp  = gd_info();
						$match = array();
						if (preg_match('!([0-9]+\.[0-9]+(?:\.[0-9]+)?)!', $temp['GD Version'], $match)) {
							if (preg_match('/^[0-9]+\.[0-9]+$/', $match[1])) {
								$match[1] .= '.0';
							}
							$gdVerion = $match[1];
						}
					}
					$gdlib = "<span class=\"yes\">" . $LNG['reg_yes'] . ", v" . $gdVerion . "</span>";
				}
				clearstatcache();
				if (file_exists(ROOT_PATH . "includes/config.php") || @touch(ROOT_PATH . "includes/config.php")) {
					if (is_writable(ROOT_PATH . "includes/config.php")) {
						$chmod = "<span class=\"yes\"> - " . $LNG['reg_writable'] . "</span>";
					}
					else {
						$chmod = " - <span class=\"no\">" . $LNG['reg_not_writable'] . "</span>";
						$error = true;
						$ftp   = true;
					}
					$config = "<tr><td class=\"transparent left\"><p>" . sprintf($LNG['reg_file'], 'includes/config.php') . "</p></td><td class=\"transparent\"><span class=\"yes\">" . $LNG['reg_found'] . "</span>" . $chmod . "</td></tr>";
				}
				else {
					$config = "<tr><td class=\"transparent left\"><p>" . sprintf($LNG['reg_file'], 'includes/config.php') . "</p></td><td class=\"transparent\"><span class=\"no\">" . $LNG['reg_not_found'] . "</span></td></tr>";
					$error  = true;
					$ftp    = true;
				}
				$directories = array('cache/', 'cache/templates/', 'cache/sessions/', 'includes/');
				$dirs        = "";
				foreach ($directories as $dir) {
					if (file_exists(ROOT_PATH . $dir) || @mkdir(ROOT_PATH . $dir)) {
						if (is_writable(ROOT_PATH . $dir)) {
							$chmod = "<span class=\"yes\"> - " . $LNG['reg_writable'] . "</span>";
						} else {
							$chmod = " - <span class=\"no\">" . $LNG['reg_not_writable'] . "</span>";
							$error = true;
							$ftp = true;
						}
						$dirs .= "<tr><td class=\"transparent left\"><p>" . sprintf($LNG['reg_dir'], $dir) . "</p></td><td class=\"transparent\"><span class=\"yes\">" . $LNG['reg_found'] . "</span>" . $chmod . "</td></tr>";
					}
					else {
						$dirs .= "<tr><td class=\"transparent left\"><p>" . sprintf($LNG['reg_dir'], $dir) . "</p></td><td class=\"transparent\"><span class=\"no\">" . $LNG['reg_not_found'] . "</span></td></tr>";
					}
				}
				if ($error == false) {
					$done = '<tr class="noborder"><td colspan="2" class="transparent"><a href="index.php?mode=install&step=3"><button style="cursor: pointer;">' . $LNG['continue'] . '</button></a></td></tr>';
				}
				else {
					$done = '';
				}
				$template->assign(array(
					'dir'    => $dirs,
					'json'   => $json,
					'done'   => $done,
					'config' => $config,
					'gdlib'  => $gdlib,
					'PHP'    => $PHP,
					'pdo'    => $pdo,
					'ftp'    => $ftp,
					'iniset' => $iniset,
					'global' => $global));
				$template->show('ins_req.tpl');
				break;
			case 3:
                $template->assign(array(
                    'host'     => getenv('DB_HOST'),
                    'user'     => getenv('DB_USER'),
                    'password' => getenv('DB_PASSWORD'),
                    'dbname'   => getenv('DB_NAME'),
                ));
				$template->show('ins_form.tpl');
				break;
			case 4:
				$host   = HTTP::_GP('host', '');
				$port   = HTTP::_GP('port', 3306);
				$user   = HTTP::_GP('user', '', true);
				$userpw = HTTP::_GP('passwort', '', true);
				$dbname = HTTP::_GP('dbname', '', true);
				$prefix = HTTP::_GP('prefix', 'uni1_');
				$template->assign(array(
					'host'   => $host,
					'port'   => $port,
					'user'   => $user,
					'dbname' => $dbname,
					'prefix' => $prefix,));
				if (empty($dbname)) {
					$template->assign(array(
						'class'   => 'fatalerror',
						'message' => $LNG['step2_db_no_dbname'],));
					$template->show('ins_step4.tpl');
					exit;
				}
				if (strlen($prefix) > 36) {
					$template->assign(array(
						'class'   => 'fatalerror',
						'message' => $LNG['step2_db_too_long'],));
					$template->show('ins_step4.tpl');
					exit;
				}
				if (strspn($prefix, '-./\\') !== 0) {
					$template->assign(array(
						'class'   => 'fatalerror',
						'message' => $LNG['step2_prefix_invalid'],));
					$template->show('ins_step4.tpl');
					exit;
				}
				if (preg_match('!^[0-9]!', $prefix) !== 0) {
					$template->assign(array(
						'class'   => 'fatalerror',
						'message' => $LNG['step2_prefix_invalid'],));
					$template->show('ins_step4.tpl');
					exit;
				}
				if (is_file(ROOT_PATH . "includes/config.php") && filesize(ROOT_PATH . "includes/config.php") != 0) {
					$template->assign(array(
						'class'   => 'fatalerror',
						'message' => $LNG['step2_config_exists'],));
					$template->show('ins_step4.tpl');
					exit;
				}
				@touch(ROOT_PATH . "includes/config.php");
				if (!is_writable(ROOT_PATH . "includes/config.php")) {
					$template->assign(array(
						'class'   => 'fatalerror',
						'message' => $LNG['step2_conf_op_fail'],));
					$template->show('ins_step4.tpl');
					exit;
				}
				$database                 = array();
				$database['host']         = $host;
				$database['port']         = $port;
				$database['user']         = $user;
				$database['userpw']       = $userpw;
				$database['databasename'] = $dbname;
				$database['tableprefix']  = $prefix;
				$blowfish = substr(str_shuffle('./0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 22);
				file_put_contents(ROOT_PATH . 'includes/config.php', sprintf(file_get_contents('includes/config.sample.php'), $host, $port, $user, $userpw, $dbname, $prefix, $blowfish));
				try {
					Database::get();
				}
				catch (Exception $e) {
					$template->assign(array(
						'class'   => 'fatalerror',
						'message' => $LNG['step2_db_con_fail'] . '</p><p>' . $e->getMessage(),));
					$template->show('ins_step4.tpl');

					unlink(ROOT_PATH . 'includes/config.php');
					exit;
				}
				@touch(ROOT_PATH . "includes/error.log");
				$template->assign(array(
					'class'   => 'noerror',
					'message' => $LNG['step2_db_done'],));
				$template->show('ins_step4.tpl');
				exit;
				break;
			case 5:
				$template->show('ins_step5.tpl');
				break;
			case 6:
				$db = Database::get();
				$installSQL      = file_get_contents('install/install.sql');
				$installVersion  = file_get_contents('install/VERSION');
				$installRevision = 0;
				preg_match('!\$' . 'Id: install.sql ([0-9]+)!', $installSQL, $match);
				$installVersion = explode('.', $installVersion);

				if (isset($match[1]))
				{
					$installRevision   = (int)$match[1];
					$installVersion[2] = $installRevision;
				}
				else
				{
					$installRevision = (int)$installVersion[2];
				}

				$installVersion = implode('.', $installVersion);
				try {
					$db->query(str_replace(array(
						'%PREFIX%',
						'%VERSION%',
						'%REVISION%',
                        '%DB_VERSION%'
					), array(
						DB_PREFIX,
						$installVersion,
						$installRevision,
                        DB_VERSION_REQUIRED
					), $installSQL));

					$config = Config::get(Universe::current());
					$config->timezone			= @date_default_timezone_get();
					$config->lang	 			= $LNG->getLanguage();
					$config->OverviewNewsText	= $LNG['sql_welcome'] . $installVersion;
					$config->uni_name			= $LNG['fcm_universe'] . ' ' . Universe::current();
					$config->close_reason		= $LNG['sql_close_reason'];
					$config->moduls				= implode(';', array_fill(0, MODULE_AMOUNT - 1, 1));

					unset($installSQL, $installRevision, $installVersion);

					$config->save();

					HTTP::redirectTo('index.php?mode=install&step=7');
				}
				catch (Exception $e) {
					require 'includes/config.php';
					@unlink('includes/config.php');
					$error = $e->getMessage();
					$template->assign(array(
						'host'    => $database['host'],
						'port'    => $database['port'],
						'user'    => $database['user'],
						'dbname'  => $database['databasename'],
						'prefix'  => $database['tableprefix'],
						'class'   => 'fatalerror',
						'message' => $LNG['step3_db_error'] . '</p><p>' . $error,
					));
					$template->show('ins_step4.tpl');
					exit;
				}
				break;
			case 7:
                $template->assign(array(
                    'name'     => getenv('ADMIN_NAME'),
                    'password' => getenv('ADMIN_PASSWORD'),
                    'mail'     => getenv('ADMIN_MAIL'),
                ));
				$template->show('ins_acc.tpl');
				break;
			case 8:
				$username	= HTTP::_GP('username', '', UTF8_SUPPORT);
				$password	= HTTP::_GP('password', '', true);
				$mail		= HTTP::_GP('email', '');
				// Get Salt.
				require 'includes/config.php';
				require 'includes/vars.php';

				$hashPassword = PlayerUtil::cryptPassword($password);

				if (empty($username) || empty($password) || empty($mail)) {
					$template->assign(array(
						'message' 	=> $LNG['step8_need_fields'],
						'username'	=> $username,
						'mail'		=> $mail,
					));
					$template->show('ins_step8error.tpl');
					exit;
				}

				list($userId, $planetId) = PlayerUtil::createPlayer(Universe::current(), $username, $hashPassword, $mail, $LNG->getLanguage(), 1, 1, 2, NULL, AUTH_ADM);

				$session	= Session::create();
				$session->userId		= $userId;
				$session->adminAccess	= 1;

				@unlink($enableInstallToolFile);
				$template->show('ins_step8.tpl');
				break;
		}
		break;
	default:
		$template->assign(array(
			'intro_text'    => $LNG['intro_text'],
			'intro_welcome' => $LNG['intro_welcome'],
			'intro_install' => $LNG['intro_install'],));
		$template->show('ins_intro.tpl');
		break;
}
