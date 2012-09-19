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
 * @copyright 2009 Lucky <lucky@xgproyect.net> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.6.1 (2011-11-19)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

class ShowSettingsPage extends AbstractPage
{
	public static $requireModule = 0;

	function __construct() 
	{
		parent::__construct();
	}
	
	public function show()
	{
		global $USER, $LNG, $LANG, $CONF;
		if($USER['urlaubs_modus'] == 1)
		{
			$this->tplObj->assign_vars(array(	
				'vacationUntil'			=> _date($LNG['php_tdformat'], $USER['urlaubs_until'], $USER['timezone']),
				'delete'				=> $USER['db_deaktjava'],
				'canVacationDisbaled'	=> $USER['urlaubs_until'] < TIMESTAMP,
			));
			
			$this->display('page.settings.vacation.tpl');
		}
		else
		{
			$this->tplObj->assign_vars(array(				
				'Selectors'			=> array(
					'timezones' => get_timezone_selector(), 
					'Sort' => array(
						0 => $LNG['op_sort_normal'], 
						1 => $LNG['op_sort_koords'],
						2 => $LNG['op_sort_abc']), 
					'SortUpDown' => array(
						0 => $LNG['op_sort_up'], 
						1 => $LNG['op_sort_down']
					), 
					'Skins' => Theme::getAvalibleSkins(), 
					'lang' => $LANG->getAllowedLangs(false)
					),
				'adminProtection'	=> $USER['authattack'],	
				'userAuthlevel'		=> $USER['authlevel'],
				'changeNickTime'	=> ($USER['uctime'] + USERNAME_CHANGETIME) - TIMESTAMP,
				'username'			=> $USER['username'],
				'email'				=> $USER['email'],
				'permaEmail'		=> $USER['email_2'],
				'userLang'			=> $USER['lang'],
				'theme'				=> substr($USER['dpath'], 13, -1),
				'planetSort'		=> $USER['planet_sort'],
				'planetOrder'		=> $USER['planet_sort_order'],
				'spycount'			=> $USER['spio_anz'],
				'fleetActions'		=> $USER['settings_fleetactions'],
				'timezone'			=> $USER['timezone'],
				'delete'			=> $USER['db_deaktjava'],
				'queueMessages'		=> $USER['hof'],
				'spyMessagesMode'	=> $USER['spyMessagesMode'],
				'galaxySpy' 		=> $USER['settings_esp'],
				'galaxyBuddyList' 	=> $USER['settings_bud'],
				'galaxyMissle' 		=> $USER['settings_mis'],
				'galaxyMessage' 	=> $USER['settings_wri'],
				'userid'		 	=> $USER['id'],
				'ref_active'		=> $CONF['ref_active'],
			));
			
			$this->display('page.settings.default.tpl');
		}
	}
	
	private function CheckVMode()
	{
		global $USER, $PLANET;

		if(!empty($USER['b_tech']) || !empty($PLANET['b_building']) || !empty($PLANET['b_hangar']))
			return false;
					
		$query = $GLOBALS['DATABASE']->query("SELECT * FROM ".PLANETS." WHERE id_owner = ".$USER['id']." AND id != ".$PLANET['id']." AND destruyed = 0;");
		
		while($CPLANET = $GLOBALS['DATABASE']->fetch_array($query))
		{
			list($USER, $CPLANET)	= $this->ecoObj->CalcResource($USER, $CPLANET, true);
		
			if(!empty($CPLANET['b_building']) || !empty($CPLANET['b_hangar']))
				return false;
			
			unset($CPLANET);
		}

		$GLOBALS['DATABASE']->free_result($query);
		
		return true;
	}
	
	public function send()
	{
		global $USER;
		if($USER['urlaubs_modus'] == 1) {
			$this->sendVacation();
		} else {
			$this->sendDefault();
		}
	}
	
	private function sendVacation() 
	{
		global $USER, $PLANET, $CONF, $LNG;
		
		$delete		= HTTP::_GP('delete', 0);
		$vacation	= HTTP::_GP('vacation', 0);
		
		$SQL		= "";
		
		if($vacation == 1 && $USER['urlaubs_until'] <= TIMESTAMP) {
			$SQL	.= "UPDATE ".USERS." SET 
						urlaubs_modus = '0', 
						urlaubs_until = '0' 
						WHERE id = ".$USER['id'].";
						UPDATE ".PLANETS." SET 
						last_update = ".TIMESTAMP.", 
						energy_used = '10', 
						energy = '10', 
						metal_mine_porcent = '10', 
						crystal_mine_porcent = '10', 
						deuterium_sintetizer_porcent = '10', 
						solar_plant_porcent = '10', 
						fusion_plant_porcent = '10', 
						solar_satelit_porcent = '10' 
						WHERE id_owner = ".$USER["id"].";";
		}
		
		if($delete == 1) {
			$SQL	.= "UPDATE ".USERS." SET db_deaktjava = ".TIMESTAMP." WHERE id = ".$USER['id'].";";
		} else {
			$SQL	.= "UPDATE ".USERS." SET db_deaktjava = 0 WHERE id = ".$USER['id'].";";
		}
		
		$GLOBALS['DATABASE']->multi_query($SQL);
		
		$this->printMessage($LNG['op_options_changed'], array('game.php?page=settings', 3));
	}
	
	private function sendDefault()
	{
		global $USER, $PLANET, $CONF, $LNG, $LANG, $UNI, $SESSION, $THEME;
		
		$adminprotection	= HTTP::_GP('adminprotection', 0);
		
		$username			= HTTP::_GP('username', $USER['username'], UTF8_SUPPORT);
		$password			= HTTP::_GP('password', '');
		
		$newpassword		= HTTP::_GP('newpassword', '');
		$newpassword2		= HTTP::_GP('newpassword2', '');
		
		$email				= HTTP::_GP('email', $USER['email']);
		
		$timezone			= HTTP::_GP('timezone', '');	
		$language			= HTTP::_GP('language', '');	
		
		$planetSort			= HTTP::_GP('planetSort', 0);	
		$planetOrder		= HTTP::_GP('planetOrder', 0);
				
		$theme				= HTTP::_GP('theme', $THEME->getThemeName());	
	
		$queueMessages		= HTTP::_GP('queueMessages', 0);	
		$spyMessagesMode	= HTTP::_GP('spyMessagesMode', 0);

		$spycount			= HTTP::_GP('spycount', 1);	
		$fleetactions		= HTTP::_GP('fleetactions', 5);	
		
		$galaxySpy			= HTTP::_GP('galaxySpy', 0);	
		$galaxyMessage		= HTTP::_GP('galaxyMessage', 0);	
		$galaxyBuddyList	= HTTP::_GP('galaxyBuddyList', 0);	
		$galaxyMissle		= HTTP::_GP('galaxyMissle', 0);
		
		$vacation			= HTTP::_GP('vacation', 0);	
		$delete				= HTTP::_GP('delete', 0);
		
		// Vertify
		
		$adminprotection	= ($adminprotection == 1 && $USER['authlevel'] != AUTH_USR) ? $USER['authlevel'] : 0;
		$spycount			= max($spycount, 1);
		$language			= array_key_exists($language, $LANG->getAllowedLangs(false)) ? $language : $LANG->getUser();		
		$theme				= array_key_exists($theme, Theme::getAvalibleSkins()) ? $theme : $THEME->getThemeName();
		
		$SQL				= "";
		
		$redirectTo			= 'game.php?page=settings';
		
		if (!empty($username) && $USER['username'] != $username)
		{
			if (!CheckName($username)) {
				$this->printMessage($LNG['op_user_name_no_alphanumeric']);
			} elseif($USER['uctime'] >= TIMESTAMP - USERNAME_CHANGETIME) {
				$this->printMessage($LNG['op_change_name_pro_week']);
			} else {
				$Count 	= $GLOBALS['DATABASE']->countquery("SELECT (SELECT COUNT(*) FROM ".USERS." WHERE `universe` = ".$UNI." AND `username` = '".$GLOBALS['DATABASE']->sql_escape($username)."') + (SELECT COUNT(*) FROM ".USERS_VALID." WHERE `universe` = ".$UNI." AND `username` = '".$GLOBALS['DATABASE']->sql_escape($username)."')");
				
				if (!empty($Count)) {
					$this->printMessage(sprintf($LNG['op_change_name_exist'], $username));
				} else {
					$SQL		.= "UPDATE ".USERS." SET username = '".$GLOBALS['DATABASE']->sql_escape($username)."', uctime = ".TIMESTAMP." WHERE id = ".$USER['id'].";";
					$redirectTo	= 'index.php';
					$SESSION->DestroySession();
				}
			}
		}
		
		if (!empty($newpassword) && cryptPassword($password) == $USER["password"] && $newpassword == $newpassword2)
		{
			$newpass 	 = cryptPassword($newpassword);
			$SQL		.= "UPDATE ".USERS." SET password = '".$newpass."' WHERE id = ".$USER['id'].";";
			$redirectTo	= 'index.php';
			$SESSION->DestroySession();
		}

		if (!empty($email) && $email != $USER['email'])
		{
			if(cryptPassword($newpassword) != $USER['password']) {
				$this->printMessage($LNG['op_need_pass_mail']);
			} elseif(!ValidateAddress($email)) {
				$this->printMessage($LNG['op_not_vaild_mail']);
			} else {
				$Count 	= $GLOBALS['DATABASE']->countquery("SELECT (SELECT COUNT(*) FROM ".USERS." WHERE id != ".$USER['id']." AND universe = ".$UNI." AND (email = '".$GLOBALS['DATABASE']->sql_escape($email)."' OR email_2 = '".$GLOBALS['DATABASE']->sql_escape($email)."')) + (SELECT COUNT(*) FROM ".USERS_VALID." WHERE universe = ".$UNI." AND email = '".$GLOBALS['DATABASE']->sql_escape($email)."')");
				if (!empty($Count)) {
					$this->printMessage(sprintf($LNG['op_change_mail_exist'], $email));
				} else {
					$SQL	.= "UPDATE ".USERS." SET email = '".$GLOBALS['DATABASE']->sql_escape($email)."', setmail = ".(TIMESTAMP + 604800)." WHERE id = ".$USER['id'].";";
				}
			}
		}		
			
		
		if ($vacation == 1)
		{
			if(!$this->CheckVMode())
			{
				$this->printMessage($LNG['op_cant_activate_vacation_mode']);
			}
			else
			{
				$SQL	.= "UPDATE ".USERS." SET 
							urlaubs_modus = '1',
							urlaubs_until = ".(TIMESTAMP + $CONF['vmode_min_time'])."
							WHERE id = ".$USER["id"].";							
							UPDATE ".PLANETS." SET
							energy_used = '0',
							energy = '0',
							metal_mine_porcent = '0',
							crystal_mine_porcent = '0',
							deuterium_sintetizer_porcent = '0',
							solar_plant_porcent = '0',
							fusion_plant_porcent = '0',
							solar_satelit_porcent = '0',
							metal_perhour = '0',
							crystal_perhour = '0',
							deuterium_perhour = '0'
							WHERE id_owner = ".$USER["id"].";";
			}
		}
		
		if($delete == 1) {
			$SQL	.= "UPDATE ".USERS." SET db_deaktjava = ".TIMESTAMP." WHERE id = ".$USER['id'].";";
		} else {
			$SQL	.= "UPDATE ".USERS." SET db_deaktjava = 0 WHERE id = ".$USER['id'].";";
		}
		
		$SQL	.=  "UPDATE ".USERS." SET
					dpath = '".$GLOBALS['DATABASE']->sql_escape($theme)."',
					timezone = '".$timezone."',
					planet_sort = ".$planetSort.",
					planet_sort_order = ".$planetOrder.",
					spio_anz = ".$spycount.",
					settings_fleetactions = ".$fleetactions.",
					settings_esp = ".$galaxySpy.",
					settings_wri = ".$galaxyMessage.",
					settings_bud = ".$galaxyBuddyList.",
					settings_mis = ".$galaxyMissle.",
					authattack = ".$adminprotection.",
					lang = '".$language."',
					hof = ".$queueMessages.",
					spyMessagesMode = ".$spyMessagesMode."
					WHERE id = '".$USER["id"]."';";
		
		$GLOBALS['DATABASE']->multi_query($SQL);
		
		$this->printMessage($LNG['op_options_changed']);
	}
}
?>