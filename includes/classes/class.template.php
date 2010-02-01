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

include_once("class.Smarty.".$phpEx);

class template extends Smarty
{
	function __construct()
	{	
		global $xgp_root;
		parent::__construct();
		$this->allow_php_templates	= true;
		$this->force_compile 		= false;
		$this->caching 				= false;
		$this->compile_check		= false;
		$this->template_dir 		= $xgp_root . TEMPLATE_DIR."smarty/";
		$this->compile_dir 			= $xgp_root ."cache/";
		$this->config_dir 			= $xgp_root ."includes/classes/configs/";
		$this->cache_dir 			= $xgp_root ."cache/"; 
		
		$this->planet				= $GLOBALS['planetrow'];
		$this->player				= $GLOBALS['user'];
		$this->lang					= $GLOBALS['lang'];
		$this->db					= $GLOBALS['db'];
		$this->GameConfig			= $GLOBALS['game_config'];
		
		$this->script				= array();
		
		$this->setheader();
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
	
	public function assign_vars($assign){
		foreach($assign as $AssignName => $AssignContent) {
			$this->assign($AssignName, $AssignContent);
		}
	}
	
	public function page_planetmenu()
	{
		foreach($this->playerplanets as $PlanetQuery)
		{
			$Planetlist[$PlanetQuery['id']]	= array(
				'url'		=> "?page=".$this->phpself."&amp;cp=".$PlanetQuery['id']."&amp;re=0",
				'name'		=> $PlanetQuery['name'].(($PlanetQuery['planet_type'] == 3) ? " (".$this->lang['fcm_moon'].")":""),
				'image'		=> $PlanetQuery['image'],
				'galaxy'	=> $PlanetQuery['galaxy'],
				'system'	=> $PlanetQuery['system'],
				'planet'	=> $PlanetQuery['planet'],
				'Buildtime'	=> ($PlanetQuery['b_building'] != 0 && $PlanetQuery['b_building'] - time() > 0) ? pretty_time($PlanetQuery['b_building'] - time()) : false,
			);
		}
		
		$this->assign_vars(array(	
			'PlanetMenu' 	=> $Planetlist,
			'current_pid'	=> $this->player['current_planet'],
		));
	}
	
	public function page_leftmenu()
	{
		$Playerrank 			= $this->db->fetch_array($this->db->query("SELECT `total_rank` FROM ".STATPOINTS." WHERE `stat_code` = '1' AND `stat_type` = '1' AND `id_owner` = '". $this->player['id'] ."';"));
		$this->player['total_rank'] = $Playerrank['total_rank'];
		$forum_url				= $this->GameConfig['forum_url'];
		$Menu					= array(
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
				$forum_url			=> $this->lang['lm_forums'],
				'?page=officier'	=> $this->lang['lm_officiers'],
				'?page=statistics&amp;range='.$this->player['total_rank'] => $this->lang['lm_statistics'],
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
				'?page=logout'		=> $this->lang['lm_logout'],
			),
		);

		$this->assign_vars(array(	
			'authlevel' 		=> $this->player['authlevel'],
			'new_message' 		=> $this->player['new_message'],
			'user_rank'			=> $rank['total_rank'],
			'forum_url'			=> $this->GameConfig['forum_url'],
			'servername'		=> $this->GameConfig['game_name'],
			'menu'				=> $Menu,
			'lm_administration'	=> $this->lang['lm_administration'],
			'version'			=> VERSION,
		));
	}
	
	public function page_topnav()
	{
		$this->playerplanets	= SortUserPlanets($this->player);
		$this->phpself			= request_var('page', '');
		
		foreach($this->playerplanets as $CurPlanetID => $CurPlanet)
		{
			$SelectorVaules[]	= "?page=".$this->phpself."&amp;cp=".$CurPlanet['id']."&amp;re=0";
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
			'current_panet'		=> "?page=".$this->phpself."&amp;cp=".$this->player['current_planet']."&amp;re=0",
			'tn_vacation_mode'	=> $this->lang['tn_vacation_mode'],
			'vacation'			=> $this->player['urlaubs_modus'] ? date('d.m.Y h:i:s',$this->player['urlaubs_until']) : false,
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
	
	public function page_header()
	{
		global $dpath;
		$this->assign_vars(array(
			'title'		=> $this->GameConfig['game_name'],
			'dpath'		=> (isset($dpath)) ? $dpath : DEFAULT_SKINPATH,
			'is_pmenu'	=> $this->player['settings_planetmenu'],
			'scripts'	=> $this->script,
		));
	}
	
	public function page_footer()
	{
		$this->assign_vars(array(
			'cron'		=> ((time() >= ($this->GameConfig['stat_last_update'] + (60 * $this->GameConfig['stat_update_time']))) ? "<img src=\"cronjobs.php?cron=stats\" alt=\"\" height=\"1\" width=\"1\">" : "").((time() >= ($this->GameConfig['stat_last_db_update'] + (60 * 60 * 24))) ? "<img src=\"cronjobs.php?cron=opdb\" alt=\"\" height=\"1\" width=\"1\">" : ""),
		));
	}
	
	public function setheader()
	{
		if (!headers_sent()) {
			header('Last-Modified: '.date('D, d M Y H:i:s T'));
			header('Expires: 0');
			header('Pragma: no-cache');
			header('Cache-Control: private, no-store, no-cache, must-revalidate, max-age=0');
			header('Cache-Control: post-check=0, pre-check=0', false); 
		}
	}
	public function show($file)
	{
		$this->assign_vars(array(
			'sql_num'	=> ((!defined('INSTALL') || !defined('IN_ADMIN')) && $this->player['authlevel'] == 3 && $this->GameConfig['debug'] == 1) ? "<center><div id=\"footer\">SQL Abfragen:". $this->db->get_sql()." - Seiten generiert in ".round(microtime(true) - STARTTIME, 4)." Sekunden</div></center>" : "",
		));
		$this->display($file);
	}
	
	public function message ($mes, $dest = false, $time = 3)
	{
		$this->assign_vars(array(
			'mes'		=> $mes,
			'gotoinsec'	=> $time,
			'goto'		=> $dest,
		));
		
		$this->show('error_message_body.tpl');
	}
}

?>