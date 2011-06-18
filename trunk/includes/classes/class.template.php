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
 * @version 1.3.5 (2011-04-22)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */
 
class template
{
	function __construct()
	{	
		$this->jsscript				= array();
		$this->script				= array();
		$this->vars					= array();
		$this->cache				= false;
		$this->cachedir				= is_writable(ROOT_PATH.'cache/') ? ROOT_PATH.'cache/' : sys_get_temp_dir();
		$this->file					= '';
		$this->cachefile			= '';
		$this->phpself				= '';
		$this->Popup				= false;
		$this->Dialog				= false;
	}
	
	public function render()
	{
		global $CONF;
		require(ROOT_PATH.'includes/libs/Smarty/Smarty.class.php');
		$TMP						= new Smarty();
		$TMP->force_compile 		= false;
		$TMP->compile_dir 			= $this->cachedir;
		$TMP->caching 				= false;
		$TMP->compile_check			= true; #Set false for production!
		$TMP->template_dir 			= $this->template_dir;
		$TMP->assign($this->vars);
		$PAGE						= $TMP->fetch($this->file);
		if($this->cache && $CONF['debug'] == 0)
		{
			file_put_contents($this->cachefile, $PAGE);
		}
		return $PAGE;
	}
	
	public function loadscript($script)
	{
		$this->jsscript[]			= substr($script, 0, -3);
	}
	
	public function execscript($script)
	{
		$this->script[]				= $script;
	}
		
	public function assign_vars($var = array()) 
	{		
		$this->vars	= array_merge($this->vars, $var);
	}
	
	private function Menus()
	{
		global $PLANET, $LNG, $USER, $CONF, $resource;
		
		//PlanetMenu
		if(isset($USER['PLANETS']))
			$USER['PLANETS']	= getPlanets($USER);
		
		if($PLANET[$resource[43]] > 0)
			$this->loadscript("gate.js");
		
		$this->loadscript("topnav.js");
		$this->loadscript("planetmenu.js");
		$this->phpself	= "?page=".request_var('page', '')."&amp;mode=".request_var('mode', '');
		$PlanetSelect	= array();
		$Scripttime		= array();
		foreach($USER['PLANETS'] as $CurPlanetID => $PlanetQuery)
		{
			if(!empty($PlanetQuery['b_building_id']))
			{
				$QueueArray						= unserialize($PlanetQuery['b_building_id']);
				foreach($QueueArray as $ListIDArray)
				{
					if($ListIDArray[3] > TIMESTAMP)
						$Scripttime[$PlanetQuery['id']][]	= $ListIDArray[3];
				}
			}
			$Planetlist[$PlanetQuery['id']]	= array(
				'url'		=> $this->phpself."&amp;cp=".$PlanetQuery['id'],
				'name'		=> $PlanetQuery['name'].(($PlanetQuery['planet_type'] == 3) ? " (".$LNG['fcm_moon'].")":""),
				'image'		=> $PlanetQuery['image'],
				'galaxy'	=> $PlanetQuery['galaxy'],
				'system'	=> $PlanetQuery['system'],
				'planet'	=> $PlanetQuery['planet'],
				'ptype'		=> $PlanetQuery['planet_type'],
			);
			
			$PlanetSelect[$this->phpself."&amp;cp=".$PlanetQuery['id']]	= $PlanetQuery['name'].(($PlanetQuery['planet_type'] == 3) ? " (" . $LNG['fcm_moon'] . ")":"")."&nbsp;[".$PlanetQuery['galaxy'].":".$PlanetQuery['system'].":".$PlanetQuery['planet']."]&nbsp;&nbsp;";
		}
		
		if($USER['urlaubs_modus'] == 1) {
			$CONF['metal_basic_income']     = 0;
			$CONF['crystal_basic_income']   = 0;
			$CONF['deuterium_basic_income'] = 0;
		}
		
		$Messages	= $USER['new_message_0'] + $USER['new_message_1'] + $USER['new_message_2'] + $USER['new_message_3'] + $USER['new_message_4'] + $USER['new_message_5'] + $USER['new_message_15'] + $USER['new_message_50'] + $USER['new_message_99'];
		
		$this->assign_vars(array(	
			'PlanetMenu' 		=> $Planetlist,
			'show_planetmenu' 	=> $LNG['show_planetmenu'],
			'current_pid'		=> $PLANET['id'],
			'Scripttime'		=> json_encode($Scripttime),	
			'new_message' 		=> $Messages,
			'forum_url'			=> $CONF['forum_url'],
			'topnav'			=> true,
			'metal'				=> $PLANET['metal'],
			'crystal'			=> $PLANET['crystal'],
			'deuterium'			=> $PLANET['deuterium'],
			'energy'			=> (($PLANET['energy_max'] + $PLANET['energy_used']) < 0) ? colorRed(shortly_number($PLANET['energy_max'] + $PLANET['energy_used']).'/'.shortly_number($PLANET['energy_max'])) : shortly_number($PLANET['energy_max'] + $PLANET['energy_used']) . '/' . shortly_number($PLANET['energy_max']),
			'energy_alt'		=> pretty_number($PLANET['energy_max'] + $PLANET['energy_used']).'/'.pretty_number($PLANET['energy_max']),
			'darkmatter'		=> $USER['darkmatter'],
			'metal_max'			=> $PLANET['metal_max'],
			'crystal_max'		=> $PLANET['crystal_max'],
			'deuterium_max' 	=> $PLANET['deuterium_max'],
			'js_metal_max'		=> floattostring($PLANET['metal_max']),
			'js_crystal_max'	=> floattostring($PLANET['crystal_max']),
			'js_deuterium_max' 	=> floattostring($PLANET['deuterium_max']),
			'js_metal_hr'		=> $PLANET['planet_type'] == 1 ? floattostring($PLANET['metal_perhour'] + $CONF['metal_basic_income'] * $CONF['resource_multiplier']) : 0,
			'js_crystal_hr'		=> $PLANET['planet_type'] == 1 ? floattostring($PLANET['crystal_perhour'] + $CONF['crystal_basic_income'] * $CONF['resource_multiplier']) : 0,
			'js_deuterium_hr'	=> $PLANET['planet_type'] == 1 ? floattostring($PLANET['deuterium_perhour'] + $CONF['deuterium_basic_income'] * $CONF['resource_multiplier']) : 0,
			'current_planet'	=> $this->phpself."&amp;cp=".$PLANET['id'],
			'tn_vacation_mode'	=> $LNG['tn_vacation_mode'],
			'closed'			=> !$CONF['game_disable'] ? $LNG['ov_closed'] : false,
			'vacation'			=> $USER['urlaubs_modus'] ? date(TDFORMAT,$USER['urlaubs_until']) : false,
			'delete'			=> $USER['db_deaktjava'] ? sprintf($LNG['tn_delete_mode'], date(TDFORMAT, strtotime("+7 day", $USER['db_deaktjava']))) : false,
			'image'				=> $PLANET['image'],
			'settings_tnstor'	=> $USER['settings_tnstor'],
			'PlanetSelect'		=> $PlanetSelect,
			'Metal'				=> $LNG['Metal'],
			'Crystal'			=> $LNG['Crystal'],
			'Deuterium'			=> $LNG['Deuterium'],
			'Darkmatter'		=> $LNG['Darkmatter'],
			'Energy'			=> $LNG['Energy'],
		));
	}
	
    private function main()
    {
		global $USER, $CONF, $LANG, $LNG, $THEME;
        $this->assign_vars(array(
            'title'				=> $CONF['game_name'],
            'uni_name'			=> $CONF['uni_name'],
            'dpath'				=> $THEME->getTheme(),
            'vmode'				=> $USER['urlaubs_modus'],
            'is_pmenu'			=> $USER['settings_planetmenu'],
			'authlevel'			=> $USER['authlevel'],
            'lang'    			=> $LANG->getUser(),
            'ready'    			=> $LNG['ready'],
			'date'				=> explode("|", date('Y\|n\|j\|G\|i\|s\|Z', TIMESTAMP)),
			'cron'				=> GetCrons(),
			'ga_active'			=> $CONF['ga_active'],
			'ga_key'			=> $CONF['ga_key'],
			'debug'				=> $CONF['debug'],
			'fcm_info'			=> $LNG['fcm_info'],
			'VERSION'			=> $CONF['VERSION'],
			'REV'				=> substr($CONF['VERSION'], -4),
			'js_days'			=> json_encode($LNG['js_days']),
			'js_month' 			=> json_encode($LNG['js_month']),
		));
	}
	
	private function adm_main()
	{
		global $LNG, $CONF;
		$this->assign_vars(array(
			'scripts'			=> $this->script,
			'title'				=> $CONF['game_name'].' - '.$LNG['adm_cp_title'],
			'fcm_info'			=> $LNG['fcm_info'],
		));
	}
	
	public function login_main()
	{
		global $USER, $CONF, $LNG, $LANG, $UNI;
		$this->assign_vars(array(
			'cappublic'			=> $CONF['cappublic'],
			'servername' 		=> $CONF['game_name'],
			'forum_url' 		=> $CONF['forum_url'],
			'fb_active'			=> $CONF['fb_on'],
			'fb_key' 			=> $CONF['fb_apikey'],
			'mail_active'		=> $CONF['mail_active'],
			'forum' 			=> $LNG['forum'],
			'register_closed'	=> $LNG['register_closed'],
			'fb_perm'			=> sprintf($LNG['fb_perm'], $CONF['game_name']),
			'menu_index'		=> $LNG['menu_index'],
			'menu_news'			=> $LNG['menu_news'],
			'menu_rules'		=> $LNG['menu_rules'],
			'menu_agb'			=> $LNG['menu_agb'],
			'menu_pranger'		=> $LNG['menu_pranger'],
			'menu_top100'		=> $LNG['menu_top100'],
			'menu_disclamer'	=> $LNG['menu_disclamer'],
			'game_captcha'		=> $CONF['capaktiv'],
			'reg_close'			=> $CONF['reg_closed'],
			'ref_active'		=> $CONF['ref_active'],
			'ga_active'			=> $CONF['ga_active'],
			'ga_key'			=> $CONF['ga_key'],
			'getajax'			=> request_var('getajax', 0),
			'lang'				=> $LANG->getUser(),
			'UNI'				=> $UNI,
			'VERSION'			=> $CONF['VERSION'],
			'REV'				=> substr($CONF['VERSION'], -4),
			'langs'				=> json_encode(Language::getAllowedLangs(false)),
		));
	}
		
	public function isPopup()
	{
		$this->Popup		= true;
	}
		
	public function isDialog()
	{
		$this->Dialog		= true;
	}
		
	public function show($file)
	{		
		global $USER, $PLANET, $CONF, $LNG, $db;
		
		if(!defined('INSTALL')) {
			if(defined('IN_ADMIN')) {
				$this->adm_main();			
			} elseif(defined('LOGIN')) {
				$this->login_main();	
			} elseif(!$this->Dialog) {
				if(!defined('AJAX')) {
					$_SESSION['USER']	= $USER;
					$_SESSION['PLANET']	= $PLANET;
				}
				$this->main();
				if($this->Popup === false)
					$this->Menus();
			}
		}
		$this->assign_vars(array(
			'scripts'			=> $this->jsscript,
			'execscript'		=> implode("\n", $this->script),
		));
		
		$this->display($file);
	}
	
	public function gotoside($dest, $time = 3)
	{
		$this->assign_vars(array(
			'gotoinsec'	=> $time,
			'goto'		=> $dest,
		));
	}
	
	public function display($file)
	{
		global $THEME;
		$this->file			= $file;
		$this->template_dir	= $THEME->getTemplatePath();
		if($this->cache && $GLOBALS['CONF']['debug'] == 0)
		{
			$this->cachefile	= $this->cachedir.md5(filemtime($this->template_dir.$this->file).r_implode('', $this->vars)).'.tpl.php';
			if(file_exists($this->cachefile))
				echo file_get_contents($this->cachefile);
			else
				echo $this->render();
		} else {
			echo $this->render();
		}
	}
	
	public function message($mes, $dest = false, $time = 3, $Fatal = false)
	{
		global $LNG, $THEME;
		if($Fatal)
			$this->isPopup(true);
	
		$this->assign_vars(array(
			'mes'		=> $mes,
			'fcm_info'	=> $LNG['fcm_info'],
			'Fatal'		=> $Fatal,
            'dpath'		=> $THEME->getTheme(),
		));
		
		$this->gotoside($dest, $time);
		if (defined('IN_ADMIN')) {
			$this->show('adm/error_message_body.tpl');
			exit;
		}
		$this->show('error_message_body.tpl');
	}
}

?>