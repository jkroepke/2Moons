<?php
/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
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
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.2 (2013-03-18)
 * @info $Id$
 * @link http://2moons.cc/
 */

class installer extends load_functions
{

	/**
	 * Step 8
	 * Trägt die Admin Daten in die Datenbank ein
	 *
	 * @return void
	 */
	protected function step8Install()
	{
		$AdminUsername	= HTTP::_GP('username', '', UTF8_SUPPORT);
		$AdminPassword	= HTTP::_GP('password', '', UTF8_SUPPORT);
		$AdminMail		= HTTP::_GP('email', '');

		$hashPassword	= $this->GeneralFunctions->cryptPassword($AdminPassword);

		$this->tmp->assign(array(
			'username'	=> $AdminUsername,
			'email'		=> $AdminMail,
		));

		if(empty($AdminUsername) || empty($AdminPassword) || empty($AdminMail))
		{
			$this->tmp->assign(array(
				'message'	=> $this->LNG['step4_need_fields'],
			));
			$this->tmp->show('ins_step8error.tpl');
			exit;
		}

		$insertAdmin	=	$this->db->insert(USERS, array(
			'username'		=>	$AdminUsername,
			'password'		=>	$hashPassword,
			'email'			=>	$AdminMail,
			'email_2'		=>	$AdminMail,
			'ip_at_reg'		=>	$_SERVER['REMOTE_ADDR'],
			'lang'			=>	$this->lang->getLanguage(),
			'authlevel'		=>	AUTH_ADM,
			'dpath'			=>	DEFAULT_THEME,
			'rights'		=>	'',
			'id_planet'		=>	1,
			'universe'		=>	1,
			'galaxy'		=>	1,
			'system'		=>	1,
			'planet'		=>	2,
			'register_time'	=>	TIMESTAMP,
		));

		Config::init($this->db);

		$planetID	=	$this->createOnePlanetRecord(1, 1, 1, 1, 1, '', true, AUTH_ADM);

		$this->SESSION->DestroySession($this->db);
		$this->SESSION->CreateSession(1, $AdminUsername, $planetID, 1, 3, DEFAULT_THEME, $this->db);

		$_SESSION['admin_login']	=	$hashPassword;

		@unlink(ROOT.'includes'.SEP.'FIRST_INSTALL');

		$this->tmp->show('ins_step8.tpl');
	}

	/**
	 * Step 7
	 * Admin Account anlegen
	 *
	 * @return void
	 */
	protected function step7Install()
	{
		$this->tmp->show('ins_acc.tpl');
	}


	/**
	 * Step 6
	 * Fügt die Datenbanktabellen ein
	 *
	 * @return void
	 */
	protected function step6Install()
	{
		$installSQL				= file_get_contents(ROOT.SEP.'install'.SEP.'install.sql');
		$installVersion			= file_get_contents(ROOT.SEP.'install'.SEP.'VERSION');
		$installRevision		= 0;

		preg_match('!\$'.'Id: install.sql ([0-9]+)!', $installSQL, $match);

		$installVersion		= explode('.', $installVersion);
		if(isset($match[1]))
		{
			$installRevision	= (int) $match[1];
			$installVersion[2]	= $installRevision;
		}
		else
		{
			$installRevision	= (int) $installVersion[2];
		}

		$installVersion		= 	implode('.', $installVersion);
		$installSQL			=	str_replace(array('%PREFIX%', '%VERSION%', '%REVISION%'), array($this->database['tableprefix'], $installVersion, $installRevision), $installSQL);

		try{

			$this->db->multi_query($installSQL);

			unset($installSQL, $installRevision, $installVersion);

			Config::init($this->db);
			Config::update(array(
				'timezone'			=> @date_default_timezone_get(),
				'lang'				=> $this->lang->getLanguage(),
				'OverviewNewsText'	=> $this->LNG['sql_welcome'].'1.7',
				'uni_name'			=> $this->LNG['fcm_universe'].' 1',
				'close_reason'		=> $this->LNG['sql_close_reason'],
				'moduls'			=> implode(';', array_fill(0, MODULE_AMOUNT - 1, 1))
			), 1, $this->db);


			HTTP::redirectTo('index.php?mode=install&step=7');

		}catch(Exception $e){
			unlink(ROOT.'includes'.SEP.'config.php');

			$error	= $e->getMessage();

			$this->tmp->assign(array(
				'host'		=> $this->database['host'],
				'port'		=> $this->database['port'],
				'user'		=> $this->database['user'],
				'dbname'	=> $this->database['databasename'],
				'prefix'	=> $this->database['tableprefix'],
				'class'		=> 'fatalerror',
				'message'	=> $this->LNG['step3_db_error'].'</p><p>'.$error,
			));
			$this->tmp->show('ins_step4.tpl');
			exit;
		}
	}

	/**
	 * Step 5
	 * Hinweis zum befüllen der Datenbank
	 *
	 * @return void
	 */
	protected function step5Install()
	{
		$this->tmp->show('ins_step5.tpl');
	}


	/**
	 * Step 4
	 * Kontrolle der Datenbankdaten
	 *
	 * @return void
	 */
	protected function step4Install()
	{
		$type	= HTTP::_GP('dbTyp', '');
		$host	= HTTP::_GP('host', '');
		$port	= HTTP::_GP('port', 3306);
		$user	= HTTP::_GP('user', '', true);
		$userpw	= HTTP::_GP('passwort', '', true);
		$dbname	= HTTP::_GP('dbname', '', true);
		$prefix	= HTTP::_GP('prefix', 'uni1_');

		$this->tmp->assign(array(
			'host'		=> $host,
			'port'		=> $port,
			'user'		=> $user,
			'dbname'	=> $dbname,
			'prefix'	=> $prefix,
		));

		if(empty($dbname))
		{
			$this->tmp->assign(array(
				'class'		=> 'fatalerror',
				'message'	=> $this->LNG['step2_db_no_dbname'],
			));
			$this->tmp->show('ins_step4.tpl');
			exit;
		}

		if(strlen($prefix) > 36)
		{
			$this->tmp->assign(array(
				'class'		=> 'fatalerror',
				'message'	=> $this->LNG['step2_db_too_long'],
			));
			$this->tmp->show('ins_step4.tpl');
			exit;
		}

		if(strspn($prefix, '-./\\') !== 0)
		{
			$this->tmp->assign(array(
				'class'		=> 'fatalerror',
				'message'	=> $this->LNG['step2_prefix_invalid'],
			));
			$this->tmp->show('ins_step4.tpl');
			exit;
		}

		if(preg_match('!^[0-9]!', $prefix) !== 0)
		{
			$this->tmp->assign(array(
				'class'		=> 'fatalerror',
				'message'	=> $this->LNG['step2_prefix_invalid'],
			));
			$this->tmp->show('ins_step4.tpl');
			exit;
		}

		if(is_file(ROOT.'includes'.SEP.'config.php') === true && filesize(ROOT.'includes'.SEP.'config.php') != 0)
		{
			$this->tmp->assign(array(
				'class'		=> 'fatalerror',
				'message'	=> $this->LNG['step2_config_exists'],
			));
			$this->tmp->show('ins_step4.tpl');
			exit;
		}

		@touch(ROOT.'includes'.SEP.'config.php');

		if(!is_writable(ROOT.'includes'.SEP.'config.php'))
		{
			$this->tmp->assign(array(
				'class'		=> 'fatalerror',
				'message'	=> $this->LNG['step2_conf_op_fail'],
			));
			$this->tmp->show('ins_step4.tpl');
			exit;
		}

		$database					= array();
		$database['typ']			= $type;
		$database['host']			= $host;
		$database['port']			= $port;
		$database['user']			= $user;
		$database['userpw']			= $userpw;
		$database['databasename']	= $dbname;
		$database['tableprefix']	= $prefix;

		try{
			parent::setDatabaseClass($database);
		}catch(Exception $e) {
			$this->tmp->assign(array(
				'class'		=> 'fatalerror',
				'message'	=> $this->LNG['step2_db_con_fail'].'</p><p>'.$e->getMessage(),
			));
			$this->tmp->show('ins_step4.tpl');
			exit;
		}

		@touch(ROOT.'includes'.SEP.'error.log');

		$blowfish	= substr(str_shuffle('./0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 22);

		file_put_contents(ROOT.'includes'.SEP.'config.php', sprintf(file_get_contents(ROOT.'includes'.SEP.'config.sample.php'), $host, $port, $user, $userpw, $dbname, $prefix, $type, $blowfish));

		$this->tmp->assign(array(
			'class'		=> 'noerror',
			'message'	=> $this->LNG['step2_db_done'],
		));
		$this->tmp->show('ins_step4.tpl');
	}


	/**
	 * Step 3
	 * Eintragen der Datenbankdaten
	 *
	 * @return void
	 */
	protected function step3Install()
	{
		$this->tmp->assign(array(
		'pdoDrivers'	=>	PDO::getAvailableDrivers(),
		));
		$this->tmp->show('ins_form.tpl');
	}


	/**
	 * Step 2
	 * Kontrolle alle Libs/Extensions/Funktionen
	 *
	 * @return void
	 */
	protected function step2Install()
	{
		$dirs	=	'';
		$json	=	'';
		$done	=	'';
		$config	=	'';
		$gdlib	=	'';
		$PHP	=	'';
		$dbTyp	=	'';
		$iniset	=	'';
		$global	=	'';

		$pdoDriver	=	array();

		$error	=	false;
		$ftp	=	false;

		//PHP Version prüfen
		if(version_compare(PHP_VERSION, "5.2.5", ">="))
		{
			$PHP 	= '<span class="yes">'.$this->LNG['reg_yes'].', v'.PHP_VERSION.'</span>';
		}
		else
		{
			$PHP 	= '<span class="no">'.$this->LNG['reg_no'].', v'.PHP_VERSION.'</span>';
			$error	= true;
		}

		//PDO Treiber vorhanden
		$pdoDriver	=	PDO::getAvailableDrivers();

		if(count($pdoDriver) > 0 && is_array($pdoDriver) === true)
		{
			$dbTyp	=	'<span class="yes">'.$this->LNG['reg_yes'].', ('.implode(',', $pdoDriver).')</span>';
		}
		else
		{
			$dbTyp	=	'<span class="no">'.$this->LNG['reg_no'].'</span>';
			$error	=	true;
		}

		// Funktion json_encode vorhanden
		if(function_exists('json_encode') === true)
		{
			$json 	= '<span class="yes">'.$this->LNG['reg_yes'].'</span>';
		}
		else
		{
			$json 	= '<span class="no">'.$this->LNG['reg_no'].'</span>';
			$error	= true;
		}

		// Funktion ini_set vorhanden
		if(function_exists('ini_set'))
		{
			$iniset = '<span class="yes">'.$this->LNG['reg_yes'].'</span>';
		}
		else
		{
			$iniset = '<span class="no">'.$this->LNG['reg_no'].'</span>';
			$error	= true;
		}


		//Funktion register_globals aktiv
		if(ini_get('register_globals') === false)
		{
			$global = '<span class="yes">'.$this->LNG['reg_yes'].'</span>';
		}
		else
		{
			$global = '<span class="no">'.$this->LNG['reg_no'].'</span>';
			$error	= true;
		}


		// Ist die Extension GDLib installiert
		if(extension_loaded('gd') === false)
		{
			$gdlib = '<span class="no">'.$this->LNG['reg_no'].'</span>';
		}
		else
		{
			$gdVerion = '0.0.0';

			if(function_exists('gd_info') === true)
			{
				$temp 	= gd_info();
				$match 	= array();
				if(preg_match('!([0-9]+\.[0-9]+(?:\.[0-9]+)?)!', $temp['GD Version'], $match))
				{
					if(preg_match('/^[0-9]+\.[0-9]+$/', $match[1]))
					{
						$match[1] .= '.0';
					}

					$gdVerion = $match[1];
				}
			}

			$gdlib = '<span class="yes">'.$this->LNG['reg_yes'].', v'.$gdVerion.'</span>';
		}


		clearstatcache();

		//Kontrolliert ob die config.php vorghanden/beschreibbar ist und ob man Zugriff darauf hat
		if(is_file(ROOT.'includes'.SEP.'config.php') === true || @touch(ROOT.'includes'.SEP.'config.php') === true)
		{
			if(is_writable(ROOT.'includes'.SEP.'config.php'))
			{
				$chmod = '<span class="yes"> - '.$this->LNG['reg_writable'].'</span>';
			}
			else
			{
				$chmod = ' - <span class="no">'.$this->LNG['reg_not_writable'].'</span>';

				$error	= true;
				$ftp	= true;
			}

			$config = '<tr><td class="transparent left"><p>'.sprintf($this->LNG['reg_file'], 'includes'.SEP.'config.php').'</p></td><td class="transparent"><span class="yes">'.$this->LNG['reg_found'].'</span>'.$chmod.'</td></tr>';
		}
		else
		{
			$config = '<tr><td class="transparent left"><p>'.sprintf($this->LNG['reg_file'], 'includes'.SEP.'config.php').'</p></td><td class="transparent"><span class="no">'.$this->LNG['reg_not_found'].'</span></td></tr>';
			$error	= true;
			$ftp	= true;
		}


		//Kontrollieren ob bestimmte Ordner beschreibar sind
		$directories 	= array('cache'.SEP, 'cache'.SEP.'templates'.SEP, 'includes'.SEP);
		$dirs 			= '';

		foreach($directories as $dir)
		{
			if(is_writable(ROOT.$dir) === true)
			{
				$chmod = '<span class="yes"> - '.$this->LNG['reg_writable'].'</span>';
			}
			else
			{
				$chmod = ' - <span class="no">'.$this->LNG['reg_not_writable'].'</span>';
				$error	= true;
				$ftp	= true;
			}

			$dirs .= '<tr><td class="transparent left"><p>'.sprintf($this->LNG['reg_dir'], $dir).'</p></td><td class="transparent"><span class="yes">'.$this->LNG['reg_found'].'</span>'.$chmod.'</td></tr>';
		}


		//Sind Fehler aufgetreten, darf nicht weiter geschaltet werden
		if($error === false)
		{
			$done = '<tr class="noborder"><td colspan="2" class="transparent"><a href="'.HTTP_PATH.'index.php?mode=install&step=3"><button style="cursor: pointer;">'.$this->LNG['continue'].'</button></a></td></tr>';
		}
		else
		{
			$done = '';
		}


		$this->tmp->assign(array(
		'dir'					=> $dirs,
		'json'					=> $json,
		'done'					=> $done,
		'config'				=> $config,
		'gdlib'					=> $gdlib,
		'PHP'					=> $PHP,
		'mysqli'				=> $dbTyp,
		'ftp'					=> $ftp,
		'iniset'				=> $iniset,
		'global'				=> $global
		));
		$this->tmp->show('ins_req.tpl');
	}

	/**
	 * Step 1
	 * Lizenz bestätigung einhollen
	 *
	 * @return void
	 */
	protected function step1Install()
	{
		if(isset($_POST['accept']) === true)
		{
			HTTP::redirectTo('index.php?mode=install&step=2');
		}


		$this->tmp->assign(array(
			'accept'	=> false,
		));
		$this->tmp->show('ins_license.tpl');
	}


	/**
	 * Installations Schema erkennen und weiterleiten
	 *
	 * @return void
	 */
	public function install()
	{
		$step	  = HTTP::_GP('step', 0);

		switch($step)
		{
			case 1:

				//Lizenz bestätigen
				$this->step1Install();

			break;
			case 2:

				//Kontrolle alle Libs/Extensions/Funktionen
				$this->step2Install();

			break;
			case 3:

				//Eintragen der Datenbankdaten
				$this->step3Install();

			break;
			case 4:

				//Kontrolle der eingegebenen Datenbankdaten
				$this->step4Install();

			break;
			case 5:

				//Hinweis zum befüllen der Datenbank
				$this->step5Install();

			break;
			case 6:

				//Fügt die Datenbanktabellen ein
				$this->step6Install();

			break;
			case 7:

				//Admin Account anlegen
				$this->step7Install();

			break;
			case 8:

				//Admin Account in der Datenbank eintragen
				$this->step8Install();

			break;
		}
	}

	/**
	 * Initialisiert den ersten Schritt bei der Installation
	 *
	 * @return void
	 */
	public function overview()
	{
		$this->tmp->assign(array(
			'intro_text'	=> $this->LNG['intro_text'],
			'intro_welcome'	=> $this->LNG['intro_welcome'],
			'intro_install'	=> $this->LNG['intro_install'],
		));
		$this->tmp->show('ins_intro.tpl');
	}
}