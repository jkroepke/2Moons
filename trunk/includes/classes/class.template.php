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

include_once("class.Smarty.".PHP_EXT);

class template extends Smarty
{
	function __construct()
	{	
		parent::__construct();
		$this->allow_php_templates	= true;
		$this->force_compile 		= false;
		$this->caching 				= false;
		$this->compile_check		= true;
		$this->template_dir 		= ROOT_PATH . TEMPLATE_DIR."smarty/";
		$this->compile_dir 			= ROOT_PATH ."cache/";
		
		$this->planet				= (isset($GLOBALS['planetrow'])) ? $GLOBALS['planetrow'] : NULL;
		$this->player				= (isset($GLOBALS['user'])) ? $GLOBALS['user'] : NULL;;
		$this->db					= $GLOBALS['db'];
		$this->GameConfig			= $GLOBALS['game_config'];
		$this->lang					= $GLOBALS['lang'];
		$this->addmenu				= $GLOBALS['addmenu'];
		$this->script				= array();
		$this->page					= array();
		$this->setheader();
	}
	
	public function getstats()
	{
		$this->player['rank']		= $this->db->fetch_array($this->db->query("SELECT `total_rank`,`total_points` FROM ".STATPOINTS." WHERE `stat_code` = '1' AND `stat_type` = '1' AND `id_owner` = '". $this->player['id'] ."';"));
	}
	
	public function getplanets()
	{
		$this->playerplanets		= SortUserPlanets($this->player);
	}
	
	public function loadscript($script)
	{
		$this->script[]				= $script;
	}
	
	public function set_vars($CurrentUser, $CurrentPlanet)
	{
		$this->planet				= $CurrentPlanet;
		$this->player				= $CurrentUser;
	}
	
	public function assign_vars($assign)
	{
		foreach($assign as $AssignName => $AssignContent) {
			$this->assign($AssignName, $AssignContent);
		}
	}
	
	private function planetmenu()
	{
		if(empty($this->playerplanets))
			$this->getplanets();
		
		foreach($this->playerplanets as $PlanetQuery)
		{
			if(!empty($PlanetQuery['b_building_id']))
			{
				$QueueArray	= explode ( ";", $PlanetQuery['b_building_id']);
				$BuildArray	= explode (",", $QueueArray[0]);
			}
			
			$Planetlist[$PlanetQuery['id']]	= array(
				'url'		=> $this->phpself."&amp;cp=".$PlanetQuery['id']."&amp;re=0",
				'name'		=> $PlanetQuery['name'].(($PlanetQuery['planet_type'] == 3) ? " (".$this->lang['fcm_moon'].")":""),
				'image'		=> $PlanetQuery['image'],
				'galaxy'	=> $PlanetQuery['galaxy'],
				'system'	=> $PlanetQuery['system'],
				'planet'	=> $PlanetQuery['planet'],
				'ptype'		=> $PlanetQuery['planet_type'],
				'Buildtime'	=> (!empty($PlanetQuery['b_building_id']) && $BuildArray[3] - time() > 0) ? pretty_time($BuildArray[3] - time()) : false,
			);
		}
		
		$this->assign_vars(array(	
			'PlanetMenu' 		=> $Planetlist,
			'show_planetmenu' 	=> $this->lang['show_planetmenu'],
			'current_pid'		=> $this->player['current_planet'],
		));
	}
	
	private function leftmenu()
	{
		if(empty($this->player['rank']))
			$this->getstats();
			
		if(empty($this->playerplanets))
			$this->getplanets();
		
		foreach($this->playerplanets as $PlanetQuery)
		{
			$SQLQuery[]	= "(`fleet_end_galaxy` = '".$PlanetQuery['galaxy']."' AND `fleet_end_system` = '".$PlanetQuery['system']."' AND `fleet_end_planet` = '".$PlanetQuery['planet']."' AND `fleet_end_type` = '".$PlanetQuery['planet_type']."')";
		}
		$this->player['fleets']	= $this->db->fetch_array($this->db->query("SELECT COUNT(*) as `count` FROM ".FLEETS." WHERE (`fleet_mission` = '1' OR `fleet_mission` = '2' OR `fleet_mission` = '6' OR `fleet_mission` = '9') AND (".implode(' OR ', $SQLQuery).");"));
			
		$BoardURL				= $this->GameConfig['forum_url'].'" target="forum';
		$RulesURL				= 'index.php?page=rules" target="forum';
		$this->Menu					= array(
			"gfx/ogame-produktion.jpg" => array(
				'?page=overview'					=> $this->lang['lm_overview'],
				'?page=imperium'					=> $this->lang['lm_empire'],
				'?page=buildings'					=> $this->lang['lm_buildings'],
				'?page=resources'					=> $this->lang['lm_resources'],
				'?page=trader'						=> $this->lang['lm_trader'],
				'?page=buildings&amp;mode=research'	=> $this->lang['lm_research'],
				'?page=buildings&amp;mode=fleet'	=> $this->lang['lm_shipshard'],
				'?page=fleet'						=> $this->lang['lm_fleet'],
				'?page=techtree'					=> $this->lang['lm_technology'],
				'?page=galaxy&amp;mode=0'			=> $this->lang['lm_galaxy'],
				'?page=buildings&amp;mode=defense'	=> $this->lang['lm_defenses'],
			),
			"gfx/info-help.jpg" => array(
				'?page=alliance'	=> $this->lang['lm_alliance'],
				$BoardURL			=> $this->lang['lm_forums'],
				'?page=officier'	=> $this->lang['lm_officiers'],
				'?page=statistics&amp;range='.$this->player['rank']['total_rank'] => $this->lang['lm_statistics'],
				'?page=records'		=> $this->lang['lm_records'],
				'?page=topkb'		=> $this->lang['lm_topkb'],
				'?page=search'		=> $this->lang['lm_search'],
			),
			"gfx/user-menu.jpg" => array(
				'?page=messages'	=> $this->lang['lm_messages'],
				'javascript:f(\'?page=notes\',\''.$this->lang['lm_notes'].'\');'	=> $this->lang['lm_notes'],
				'?page=buddy'		=> $this->lang['lm_buddylist'],
				'?page=chat'		=> $this->lang['lm_chat'],
				'?page=support'		=> $this->lang['lm_support'],
				'?page=faq'			=> $this->lang['lm_faq'],
				'?page=options' 	=> $this->lang['lm_options'],
				'?page=banned'		=> $this->lang['lm_banned'],
				$RulesURL			=> $this->lang['lm_rules'],
				'?page=logout'		=> $this->lang['lm_logout'],
			),
		);

		$this->assign_vars(array(	
			'authlevel' 		=> $this->player['authlevel'],
			'new_message' 		=> $this->player['new_message'],
			'incoming_fleets'	=> $this->player['fleets']['count'],
			'forum_url'			=> $this->GameConfig['forum_url'],
			'servername'		=> $this->GameConfig['game_name'],
			'menu'				=> array_merge($this->Menu, $this->addmenu),
			'lm_administration'	=> $this->lang['lm_administration'],
		));
	}
	
	private function topnav()
	{
		$this->phpself			= "?page=".request_var('page', '')."&amp;mode=".request_var('mode', '');
		$this->loadscript("topnav.js");
		if(empty($this->playerplanets))
			$this->getplanets();
		
		foreach($this->playerplanets as $CurPlanetID => $CurPlanet)
		{
			$SelectorVaules[]	= $this->phpself."&amp;cp=".$CurPlanet['id']."&amp;re=0";
			$SelectorNames[]	= $CurPlanet['name'].(($CurPlanet['planet_type'] == 3) ? " (" . $this->lang['fcm_moon'] . ")":"")."&nbsp;[".$CurPlanet['galaxy'].":".$CurPlanet['system'].":".$CurPlanet['planet']."]&nbsp;&nbsp;";
		}
		
		$this->assign_vars(array(
			'energy'			=> (($this->planet["energy_max"] + $this->planet["energy_used"]) < 0) ? colorRed(pretty_number($this->planet["energy_max"] + $this->planet["energy_used"]) . "/" . pretty_number($this->planet["energy_max"])) : pretty_number($this->planet["energy_max"] + $this->planet["energy_used"]) . "/" . pretty_number($this->planet["energy_max"]),
			'metal'				=> ($this->planet["metal"] >= $this->planet["metal_max"]) ? colorRed(pretty_number($this->planet["metal"])) : pretty_number($this->planet["metal"]),
			'crystal'			=> ($this->planet["crystal"] >= $this->planet["crystal_max"]) ? colorRed(pretty_number($this->planet["crystal"])) : pretty_number($this->planet["crystal"]),
			'deuterium'			=> ($this->planet["deuterium"] >= $this->planet["deuterium_max"]) ? colorRed(pretty_number($this->planet["deuterium"])) : pretty_number($this->planet["deuterium"]),
			'darkmatter'		=> pretty_number($this->player["darkmatter"]),
			'metal_max'			=> pretty_number($this->planet["metal_max"]),
			'crystal_max'		=> pretty_number($this->planet["crystal_max"]),
			'deuterium_max' 	=> pretty_number($this->planet["deuterium_max"]),
			'js_metal_hr'		=> $this->planet['metal_perhour'] + $this->GameConfig['metal_basic_income'],
			'js_crystal_hr'		=> $this->planet['crystal_perhour'] + $this->GameConfig['crystal_basic_income'],
			'js_deuterium_hr'	=> $this->planet['deuterium_perhour'] + $this->GameConfig['deuterium_basic_income'],
			'js_res_multiplier'	=> $this->GameConfig['resource_multiplier'],
			'current_panet'		=> $this->phpself."&amp;cp=".$this->player['current_planet']."&amp;re=0",
			'tn_vacation_mode'	=> $this->lang['tn_vacation_mode'],
			'vacation'			=> $this->player['urlaubs_modus'] ? date('d.m.Y H:i:s',$this->player['urlaubs_until']) : false,
			'delete'			=> $this->player['db_deaktjava'] ? sprintf($this->lang['tn_delete_mode'], date('d. M Y\, h:i:s',$this->player['db_deaktjava'] + (60 * 60 * 24 * 7))) : false,
			'image'				=> $this->planet['image'],
			'SelectorVaules'	=> $SelectorVaules,
			'SelectorNames'		=> $SelectorNames,
			'Metal'				=> $this->lang['Metal'],
			'Crystal'			=> $this->lang['Crystal'],
			'Deuterium'			=> $this->lang['Deuterium'],
			'Darkmatter'		=> $this->lang['Darkmatter'],
			'Energy'			=> $this->lang['Energy'],
		));
	}
	
	private function header()
	{
		global $dpath;
		$this->assign_vars(array(
			'title'		=> $this->GameConfig['game_name'],
			'dpath'		=> (!empty($dpath)) ? $dpath : DEFAULT_SKINPATH,
			'is_pmenu'	=> $this->player['settings_planetmenu'],
		));
	}
	
	private function footer()
	{
		$this->assign_vars(array(
			'cron'		=> ((time() >= ($this->GameConfig['stat_last_update'] + (60 * $this->GameConfig['stat_update_time']))) ? "<img src=\"".ROOT_PATH."cronjobs.php?cron=stats\" alt=\"\" height=\"1\" width=\"1\">" : "").((time() >= ($this->GameConfig['stat_last_db_update'] + (60 * 60 * 24))) ? "<img src=\"".ROOT_PATH."cronjobs.php?cron=opdb\" alt=\"\" height=\"1\" width=\"1\">" : ""),
			'scripts'	=> $this->script,
		));
	}
	
	public function set_index()
	{
		$this->assign_vars(array(
			'cappublic'			=> $this->GameConfig['cappublic'],
			'servername' 		=> $this->GameConfig['game_name'],
			'forum_url' 		=> $this->GameConfig['forum_url'],
			'forum' 			=> $this->lang['forum'],
			'register_closed'	=> $this->lang['register_closed'],
			'menu_index'		=> $this->lang['menu_index'],
			'menu_news'			=> $this->lang['menu_news'],
			'menu_rules'		=> $this->lang['menu_rules'],
			'menu_agb'			=> $this->lang['menu_agb'],
			'menu_pranger'		=> $this->lang['menu_pranger'],
			'menu_top100'		=> $this->lang['menu_top100'],
			'menu_disclamer'	=> $this->lang['menu_disclamer'],
			'game_captcha'		=> $this->GameConfig['capaktiv'],
			'reg_close'			=> $this->GameConfig['reg_closed'],
			'getajax'			=> request_var('getajax', 0),
		));
	}
	
	public function index_footer()
	{
		$this->assign_vars(array(
			'cron'		=> ((time() >= ($this->GameConfig['stat_last_update'] + (60 * $this->GameConfig['stat_update_time']))) ? "<img src=\"cronjobs.php?cron=stats\" alt=\"\" height=\"1\" width=\"1\">" : "").((time() >= ($this->GameConfig['stat_last_db_update'] + (60 * 60 * 24))) ? "<img src=\"cronjobs.php?cron=opdb\" alt=\"\" height=\"1\" width=\"1\">" : ""),
		));
	}
	
	public function setheader()
	{
		if (!headers_sent()) {
			header('Expires: 0');
			header('Pragma: no-cache');
			header('Cache-Control: private, no-store, no-cache, must-revalidate, max-age=0');
			header('Cache-Control: post-check=0, pre-check=0', false); 
			header('X-UA-Compatible: IE=100');
			isBuggyIe() || header('Content-Encoding: '.zlib_get_coding_type()); 
		}
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

		$this->assign_vars(array(
			'sql_num'	=> ((!defined('INSTALL') || !defined('IN_ADMIN')) && $this->player['authlevel'] == 3 && $this->GameConfig['debug'] == 1) ? "<center><div id=\"footer\">SQL Abfragen:".(1 + $this->db->get_sql())." - Seiten generiert in ".round(microtime(true) - STARTTIME, 4)." Sekunden</div></center>" : "",
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
	
	public function message($mes, $dest = false, $time = 3)
	{
		$this->assign_vars(array(
			'mes'		=> $mes,
			'fcm_info'	=> $this->lang['fcm_info'],
		));
		$this->gotoside($dest, $time);
		$this->show('error_message_body.tpl');
	}
}

?>