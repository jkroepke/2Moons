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

abstract class AbstractPage 
{
	protected $tplObj;
	protected $ecoObj;
	protected $window;
	protected $disableEcoSystem = false;
	
	protected function __construct() {
		
		if(!AJAX_REQUEST)
		{
			$this->setWindow('full');
			if(!$this->disableEcoSystem)
			{
				$this->ecoObj	= new ResourceUpdate();
				$this->ecoObj->CalcResource();
			}
			$this->initTemplate();
		} else {
			$this->setWindow('ajax');
		}
	}
	
	protected function initTemplate() {
		if(isset($this->tplObj))
			return true;
			
		$this->tplObj	= new template;
		list($tplDir)	= $this->tplObj->getTemplateDir();
		$this->tplObj->setTemplateDir($tplDir.'game/');
		return true;
	}
	
	protected function setWindow($window) {
		$this->window	= $window;
	}
		
	protected function getWindow() {
		return $this->window;
	}
	
	protected function getQueryString() {
		$queryString	= array();
		$page			= HTTP::_GP('page', '');
		
		if(!empty($page)) {
			$queryString['page']	= $page;
		}
		
		$mode			= HTTP::_GP('mode', '');
		if(!empty($mode)) {
			$queryString['mode']	= $mode;
		}
		
		return http_build_query($queryString);
	}
	
	protected function getNavigationData() 
    {
		global $PLANET, $LNG, $USER, $CONF, $resource;
		
		if($PLANET[$resource[43]] > 0) {
			$this->tplObj->loadscript("gate.js");
		}
		
		$this->tplObj->loadscript("topnav.js");
			
		$PlanetSelect	= array();
		
		if(isset($USER['PLANETS'])) {
			$USER['PLANETS']	= getPlanets($USER);
		}
		
		foreach($USER['PLANETS'] as $CurPlanetID => $PlanetQuery)
		{
			$PlanetSelect[$PlanetQuery['id']]	= $PlanetQuery['name'].(($PlanetQuery['planet_type'] == 3) ? " (" . $LNG['fcm_moon'] . ")":"")." [".$PlanetQuery['galaxy'].":".$PlanetQuery['system'].":".$PlanetQuery['planet']."]";
		}
		
		if($USER['urlaubs_modus'] == 1) {
			$CONF['metal_basic_income']     = 0;
			$CONF['crystal_basic_income']   = 0;
			$CONF['deuterium_basic_income'] = 0;
		}
		
		$this->tplObj->assign_vars(array(	
			'PlanetSelect'		=> $PlanetSelect,
			'new_message' 		=> $USER['messages'],
			'vacation'			=> $USER['urlaubs_modus'] ? _date($LNG['php_tdformat'], $USER['urlaubs_until'], $USER['timezone']) : false,
			'delete'			=> $USER['db_deaktjava'] ? sprintf($LNG['tn_delete_mode'], _date($LNG['php_tdformat'], $USER['db_deaktjava'] + ($CONF['del_user_manually'] * 86400)), $USER['timezone']) : false,
			'darkmatter'		=> $USER['darkmatter'],
			'current_pid'		=> $PLANET['id'],
			'image'				=> $PLANET['image'],
			'metal'				=> $PLANET[$resource[901]],
			'crystal'			=> $PLANET[$resource[902]],
			'deuterium'			=> $PLANET[$resource[903]],
			'energy'			=> $PLANET[$resource[911]],
			'energy_used'		=> $PLANET['energy_used'],
			'metal_max'			=> $PLANET[$resource[901].'_max'],
			'crystal_max'		=> $PLANET[$resource[902].'_max'],
			'deuterium_max' 	=> $PLANET[$resource[903].'_max'],
			'js_metal_max'		=> $PLANET['metal_max'],
			'js_crystal_max'	=> $PLANET['crystal_max'],
			'js_deuterium_max' 	=> $PLANET['deuterium_max'],
			'js_metal_hr'		=> $PLANET['metal_perhour'] + $CONF['metal_basic_income'] * $CONF['resource_multiplier'],
			'js_crystal_hr'		=> $PLANET['crystal_perhour'] + $CONF['crystal_basic_income'] * $CONF['resource_multiplier'],
			'js_deuterium_hr'	=> $PLANET['deuterium_perhour'] + $CONF['deuterium_basic_income'] * $CONF['resource_multiplier'],
			'shortlyNumber'		=> false,
			'closed'			=> !$CONF['game_disable'] ? $LNG['ov_closed'] : false,
			'forum_url'			=> $CONF['forum_url'],
			'hasAdminAccess'	=> isset($_SESSION['admin_login']),
		));
	}
	
	protected function getPageData() 
    {
		global $USER, $CONF, $LANG, $LNG, $THEME;
		
		if($this->getWindow() === 'full') {
			$this->getNavigationData();
		}
		
		$dateTimeServer		= new DateTime("now");
		if(isset($USER['timezone'])) {
			try {
				$dateTimeUser	= new DateTime("now", new DateTimeZone($USER['timezone']));
			} catch (Exception $e) {
				$dateTimeUser	= $dateTimeServer;
			}
		} else {
			$dateTimeUser	= $dateTimeServer;
		}
        $this->tplObj->assign_vars(array(
            'vmode'				=> $USER['urlaubs_modus'],
			'authlevel'			=> $USER['authlevel'],
			'userID'			=> $USER['id'],
            'game_name'			=> $CONF['game_name'],
            'uni_name'			=> $CONF['uni_name'],
			'ga_active'			=> $CONF['ga_active'],
			'ga_key'			=> $CONF['ga_key'],
			'debug'				=> $CONF['debug'],
			'VERSION'			=> $CONF['VERSION'],
			'date'				=> explode("|", date('Y\|n\|j\|G\|i\|s\|Z', TIMESTAMP)),
			'cron'				=> GetCrons(),
			'REV'				=> substr($CONF['VERSION'], -4),
			'Offset'			=> $dateTimeUser->getOffset() - $dateTimeServer->getOffset(),
			'queryString'		=> $this->getQueryString(),
			'themeSettings'		=> $THEME->getStyleSettings(),
		));
	}
	
	protected function printMessage($Message, $fullSide = true, $redirect = NULL) {
		$this->tplObj->assign_vars(array(
			'mes'		=> $Message,
		));
		
		if(isset($redirect)) {
			$this->tplObj->gotoside($redirect[0], $redirect[1]);
		}
		
		if(!$fullSide) {
			$this->setWindow('popup');
		}
		
		$this->display('error.default.tpl');
	}
	
	protected function save() {		
		if(isset($this->ecoObj)) {
			$this->ecoObj->SavePlanetToDB();
		}
	}
	
	protected function display($file) {
		global $LNG, $LANG, $THEME;
		
		$this->save();
		
		if($this->getWindow() !== 'ajax') {
			$this->getPageData();
		}
		
		$this->tplObj->assign_vars(array(
            'lang'    		=> $LANG->getUser(),
            'dpath'			=> $THEME->getTheme(),
			'scripts'		=> $this->tplObj->jsscript,
			'execscript'	=> implode("\n", $this->tplObj->script),
		));

		$this->tplObj->assign_vars(array(
			'LNG'			=> $LNG,
		), false);
		
		$this->tplObj->display('extends:layout.'.$this->getWindow().'.tpl|'.$file);
		exit;
	}
	
	protected function sendJSON($data) {
		$this->save();
		echo json_encode($data);
		exit;
	}
	
	protected function redirectTo($url) {
		$this->save();
		HTTP::redirectTo($url);
		exit;
	}
}