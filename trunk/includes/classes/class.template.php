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

class template
{
	function __construct()
	{	
		$this->jsscript				= array();
		$this->script				= array();
		$this->page					= array();
		$this->vars					= array();
		$this->cache				= false;
		$this->cachedir				= ROOT_PATH.'cache/';
		$this->file					= '';
		$this->template_dir			= ROOT_PATH.TEMPLATE_DIR;
		$this->cachefile			= '';
	}

	public function render()
	{
		global $CONF;
		require(ROOT_PATH.'includes/libs/Smarty/Smarty.class.php');
		$TMP						= new Smarty();
		$TMP->allow_php_templates	= true;
		$TMP->allow_php_tag 		= true;
		$TMP->force_compile 		= false;
		$TMP->caching 				= false;
		$TMP->compile_check			= true; #Set false for production!
		$TMP->php_handling			= SMARTY_PHP_QUOTE;
		$TMP->template_dir 			= $this->template_dir;
		$TMP->compile_dir 			= $this->cachedir;
		$TMP->assign($this->vars);
		$PAGE						= $TMP->fetch($this->file);
		if($this->cache && $CONF['debug'] == 0)
		{
			file_put_contents($this->cachefile, $PAGE);
		}
		return $PAGE;
	}
	
	public function getplanets()
	{
		global $USER;
		$this->UserPlanets			= SortUserPlanets($USER);
	}
	
	public function loadscript($script)
	{
		$this->jsscript[]			= substr($script, 0, -3);
	}
	
	public function execscript($script)
	{
		$this->script[]				= $script;
	}
		
	public function assign_vars($assign)
	{
		$this->vars	= array_merge($this->vars, $assign);
	}
	
	private function planetmenu()
	{
		global $LNG, $USER;
		if(empty($this->UserPlanets))
			$this->getplanets();
		
		$this->loadscript("planetmenu.js");
		$this->execscript("PlanetMenu();");

		$Scripttime	= array();
		foreach($this->UserPlanets as $PlanetQuery)
		{
			if(!empty($PlanetQuery['b_building_id']))
			{
				$QueueArray						= explode(";", $PlanetQuery['b_building_id']);
				$ActualCount					= count($QueueArray);
				for ($ID = 0; $ID < $ActualCount; $ID++)
				{
					$ListIDArray						= explode(",", $QueueArray[$ID]);
					
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
		}
		
		$this->assign_vars(array(	
			'PlanetMenu' 		=> $Planetlist,
			'show_planetmenu' 	=> $LNG['show_planetmenu'],
			'current_pid'		=> $_SESSION['planet'],
			'Scripttime'		=> json_encode($Scripttime),
		));
	}
	
	private function leftmenu()
	{
		global $CONF, $LNG, $USER;
		$this->assign_vars(array(	
			'lm_overview'		=> $LNG['lm_overview'],
			'lm_empire'			=> $LNG['lm_empire'],
			'lm_buildings'		=> $LNG['lm_buildings'],
			'lm_resources'		=> $LNG['lm_resources'],
			'lm_trader'			=> $LNG['lm_trader'],
			'lm_research'		=> $LNG['lm_research'],
			'lm_shipshard'		=> $LNG['lm_shipshard'],
			'lm_fleet'			=> $LNG['lm_fleet'],
			'lm_technology'		=> $LNG['lm_technology'],
			'lm_galaxy'			=> $LNG['lm_galaxy'],
			'lm_defenses'		=> $LNG['lm_defenses'],
			'lm_alliance'		=> $LNG['lm_alliance'],
			'lm_forums'			=> $LNG['lm_forums'],
			'lm_officiers'		=> $LNG['lm_officiers'],
			'lm_statistics' 	=> $LNG['lm_statistics'],
			'lm_records'		=> $LNG['lm_records'],
			'lm_topkb'			=> $LNG['lm_topkb'],
			'lm_search'			=> $LNG['lm_search'],
			'lm_battlesim'		=> $LNG['lm_battlesim'],
			'lm_messages'		=> $LNG['lm_messages'],
			'lm_notes'			=> $LNG['lm_notes'],
			'lm_buddylist'		=> $LNG['lm_buddylist'],
			'lm_chat'			=> $LNG['lm_chat'],
			'lm_support'		=> $LNG['lm_support'],
			'lm_faq'			=> $LNG['lm_faq'],
			'lm_options'		=> $LNG['lm_options'],
			'lm_banned'			=> $LNG['lm_banned'],
			'lm_rules'			=> $LNG['lm_rules'],
			'lm_logout'			=> $LNG['lm_logout'],
			'new_message' 		=> $USER['new_message'],
			'forum_url'			=> $CONF['forum_url'],
			'lm_administration'	=> $LNG['lm_administration'],
		));
	}
	
	private function topnav()
	{
		global $PLANET, $LNG, $USER, $CONF;
		$this->phpself			= "?page=".request_var('page', '')."&amp;mode=".request_var('mode', '');
		$this->loadscript("topnav.js");
		if(empty($this->UserPlanets))
			$this->getplanets();
		
		foreach($this->UserPlanets as $CurPlanetID => $CurPlanet)
		{
			$SelectorVaules[]	= $this->phpself."&amp;cp=".$CurPlanet['id'];
			$SelectorNames[]	= $CurPlanet['name'].(($CurPlanet['planet_type'] == 3) ? " (" . $LNG['fcm_moon'] . ")":"")."&nbsp;[".$CurPlanet['galaxy'].":".$CurPlanet['system'].":".$CurPlanet['planet']."]&nbsp;&nbsp;";
		}
		
		if($USER['urlaubs_modus'] == 1) {
			$CONF['metal_basic_income']     = 0;
			$CONF['crystal_basic_income']   = 0;
			$CONF['deuterium_basic_income'] = 0;
		}
		
		$this->assign_vars(array(
			'topnav'			=> true,
			'metal'				=> $PLANET['metal'],
			'crystal'			=> $PLANET['crystal'],
			'deuterium'			=> $PLANET['deuterium'],
			'energy'			=> (($PLANET["energy_max"] + $PLANET["energy_used"]) < 0) ? colorRed(pretty_number($PLANET["energy_max"] + $PLANET["energy_used"]) . "/" . pretty_number($PLANET["energy_max"])) : pretty_number($PLANET["energy_max"] + $PLANET["energy_used"]) . "/" . pretty_number($PLANET["energy_max"]),
			'darkmatter'		=> pretty_number($USER["darkmatter"]),
			'metal_max'			=> shortly_number($PLANET["metal_max"]),
			'crystal_max'		=> shortly_number($PLANET["crystal_max"]),
			'deuterium_max' 	=> shortly_number($PLANET["deuterium_max"]),
			'alt_metal_max'		=> pretty_number($PLANET["metal_max"]),
			'alt_crystal_max'	=> pretty_number($PLANET["crystal_max"]),
			'alt_deuterium_max' => pretty_number($PLANET["deuterium_max"]),
			'js_metal_max'		=> floattostring($PLANET["metal_max"]),
			'js_crystal_max'	=> floattostring($PLANET["crystal_max"]),
			'js_deuterium_max' 	=> floattostring($PLANET["deuterium_max"]),
			'js_metal_hr'		=> floattostring($PLANET['metal_perhour'] + $CONF['metal_basic_income'] * $CONF['resource_multiplier']),
			'js_crystal_hr'		=> floattostring($PLANET['crystal_perhour'] + $CONF['crystal_basic_income'] * $CONF['resource_multiplier']),
			'js_deuterium_hr'	=> floattostring($PLANET['deuterium_perhour'] + $CONF['deuterium_basic_income'] * $CONF['resource_multiplier']),
			'current_panet'		=> $this->phpself."&amp;cp=".$_SESSION['planet'],
			'tn_vacation_mode'	=> $LNG['tn_vacation_mode'],
			'closed'			=> !$CONF['game_disable'] ? $LNG['ov_closed'] : false,
			'vacation'			=> $USER['urlaubs_modus'] ? date('d.m.Y H:i:s',$USER['urlaubs_until']) : false,
			'delete'			=> $USER['db_deaktjava'] ? sprintf($LNG['tn_delete_mode'], date('d. M Y\, H:i:s', strtotime("+7 day", $USER['db_deaktjava']))) : false,
			'image'				=> $PLANET['image'],
			'settings_tnstor'	=> $USER['settings_tnstor'],
			'SelectorVaules'	=> $SelectorVaules,
			'SelectorNames'		=> $SelectorNames,
			'Metal'				=> $LNG['Metal'],
			'Crystal'			=> $LNG['Crystal'],
			'Deuterium'			=> $LNG['Deuterium'],
			'Darkmatter'		=> $LNG['Darkmatter'],
			'Energy'			=> $LNG['Energy'],
		));
	}
	
    private function header()
    {
		global $USER, $CONF, $LANG, $LNG;
        $this->assign_vars(array(
            'title'				=> $CONF['game_name'],
            'dpath'				=> (empty($USER['dpath']) ? DEFAULT_SKINPATH : $USER['dpath']),
            'vmode'				=> $USER['urlaubs_modus'],
            'is_pmenu'			=> $USER['settings_planetmenu'],
			'authlevel'			=> $USER['authlevel'],
            'lang'    			=> $LANG,
            'ready'    			=> $LNG['ready'],
			'date'				=> explode("|", date('Y\|n\|j\|G\|i\|s\|Z', TIMESTAMP)),
        ));
    }
	
	private function footer()
	{
		global $CONF;
		$this->assign_vars(array(
			'cron'			=> ((TIMESTAMP >= ($CONF['stat_last_update'] + (60 * $CONF['stat_update_time']))) ? "<img src=\"./cronjobs.php?cron=stats\" alt=\"\" height=\"1\" width=\"1\">" : "").((TIMESTAMP >= ($CONF['stat_last_db_update'] + (60 * 60 * 24))) ? "<img src=\"./cronjobs.php?cron=daily\" alt=\"\" height=\"1\" width=\"1\">" : "").((!CheckModule(37) && TIMESTAMP >= ($CONF['stat_last_banner_update'] + (60 * $CONF['stat_banner_update_time']))) ? "<img src=\"./cronjobs.php?cron=banner\" alt=\"\" height=\"1\" width=\"1\">" : ""),
			'scripts'		=> $this->jsscript,
			'execscript'	=> implode("\n", $this->script),
			'ga_active'		=> $CONF['ga_active'],
			'ga_key'		=> $CONF['ga_key'],
			'debug'			=> $CONF['debug'],
		));
	}
	
	private function adm_header()
	{
		global $LNG, $CONF;
		$this->assign_vars(array(
			'scripts'	=> $this->script,
			'title'		=> $CONF['game_name'].' - '.$LNG['adm_cp_title'],
		));
	}
	
	public function set_index()
	{
		global $USER, $CONF, $LNG, $LANG, $UNI;
		$this->assign_vars(array(
			'cappublic'			=> $CONF['cappublic'],
			'servername' 		=> $CONF['game_name'],
			'forum_url' 		=> $CONF['forum_url'],
			'fb_active'			=> $CONF['fb_on'],
			'fb_key' 			=> $CONF['fb_apikey'],
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
			'music_off'			=> $LNG['music_off'],
			'music_on'			=> $LNG['music_on'],
			'game_captcha'		=> $CONF['capaktiv'],
			'reg_close'			=> $CONF['reg_closed'],
			'ga_active'			=> $CONF['ga_active'],
			'ga_key'			=> $CONF['ga_key'],
			'bgm_active'		=> $CONF['bgm_active'],
			'bgm_file'			=> $CONF['bgm_file'],
			'getajax'			=> request_var('getajax', 0),
			'lang'				=> $LANG,
			'UNI'				=> $UNI,
		));
	}
		
	public function page_header()
	{
		$this->page['header']		= true;
	}
	
	public function page_topnav()
	{
		$this->page['topnav']		= true;
	}
	
	public function page_leftmenu()
	{
		$this->page['leftmenu']		= true;
	}
	
	public function page_planetmenu()
	{
		$this->page['planetmenu']	= true;
	}
	
	public function page_footer()
	{
		$this->page['footer']		= true;
	}
	
	public function show($file)
	{		
		global $USER, $CONF, $LNG, $db;
		if(defined('IN_ADMIN')) {
			if($this->page['header'] == true)
				$this->adm_header();			
		} else {
			if($this->page['header'] == true)
				$this->header();
				
			if($this->page['topnav'] == true)
				$this->topnav();
				
			if($this->page['leftmenu'] == true)
				$this->leftmenu();
				
			if($this->page['planetmenu'] == true)
				$this->planetmenu();
				
			if($this->page['footer'] == true)
				$this->footer();
		}
		
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
		$this->file			= $file;
		$this->cachefile	= $this->cachedir.$this->cacheid.md5(md5_file($this->template_dir.$this->file).implode('', $this->vars)).'.tpl.php';
		if($this->cache && $CONF['debug'] == 0 && file_exists($this->cachefile))
			echo file_get_contents($this->cachefile);
		else
			echo $this->render();
	}
	
	public function message($mes, $dest = false, $time = 3, $Fatal = false)
	{
		global $LNG;
		$this->page_header();
		if(!$Fatal){
			$this->page_topnav();
			$this->page_leftmenu();
			$this->page_planetmenu();
		}
		$this->page_footer();

		$this->assign_vars(array(
			'mes'		=> $mes,
			'fcm_info'	=> $LNG['fcm_info'],
			'Fatal'		=> $Fatal,
		));
		
		if(INSTALL == true) {
			$this->assign_vars(array(
				'cd'		=> '../',
			));	
		} elseif (defined('IN_ADMIN')) {
			$this->assign_vars(array(
				'dpath'		=> './styles/skins/darkness/',
				'isadmin'	=> true,
			));
		}
		
		$this->gotoside($dest, $time);
		$this->show('error_message_body.tpl');
	}
}

?>