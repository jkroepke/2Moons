<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan
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
 * @copyright 2006 Perberos <ugamela@perberos.com.ar> (UGamela)
 * @copyright 2008 Chlorel (XNova)
 * @copyright 2009 Lucky (XGProyecto)
 * @copyright 2012 Jan <info@2moons.cc> (2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.0 (2012-05-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

abstract class AbstractPage 
{
	protected $tplObj;
	protected $ecoObj;
	protected $window;
	protected $disableEcoSystem = false;
	
	protected function __construct()
	{
		if(!AJAX_REQUEST)
		{
			$this->setWindow('normal');
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
		$this->tplObj->setTemplateDir($tplDir.'index/');
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
	
	protected function getPageData() 
    {
		global$gameConfig, $LANG, $UNI;
		$this->tplObj->assign_vars(array(
			'game_captcha'		=> $gameConfig['recaptchaEnable'],
			'cappublic'			=> $gameConfig['recaptchaPublicKey'],
			'servername' 		=> $gameConfig['gameName'],
			'forum_url' 		=> $gameConfig['boardAddress'],
			'fb_active'			=> $gameConfig['facebookEnable'],
			'fb_key' 			=> $gameConfig['facebookAPIKey'],
			'mail_active'		=> $gameConfig['mailEnable'],
			'ref_active'		=> $gameConfig['referralEnable'],
			'ga_active'			=> $gameConfig['analyticsEnbale'],
			'ga_key'			=> $gameConfig['analyticsUID'],
			'getajax'			=> HTTP::_GP('getajax', 0),
			'lang'				=> $LANG->getUser(),
			'UNI'				=> $UNI,
			'VERSION'			=> $gameConfig['version'],
			'REV'				=> substr($gameConfig['version'], -4),
			'langs'				=> json_encode(Language::getAllowedLangs(false)),
			'htaccess'			=> (int) (UNIS_HTACCESS === true),
		));
	}
	
	protected function printMessage($Message, $fullSide = true, $redirect = NULL) {
		$this->tplObj->assign_vars(array(
			'mes'		=> $Message,
		));
		
		if(isset($redirect)) {
			$this->tplObj->gotoside($redirect[0], $redirect[1]);
		}
		
		$this->display('error.default.tpl');
	}
	
	protected function save() {	
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