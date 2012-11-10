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
 * @version 1.7.0 (2012-12-31)
 * @info $Id$
 * @link http://2moons.cc/
 */

abstract class AbstractPage 
{
	protected $tplObj;
	protected $window;
	public $defaultWindow = 'normal';
	
	protected function __construct() {
		
		if(!AJAX_REQUEST)
		{
			$this->setWindow($this->defaultWindow);
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
		$this->tplObj->setTemplateDir($tplDir.'login/');
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
		global $USER, $CONF, $LNG, $LANG, $UNI;
		
		$dateTimeServer	= new DateTime("now");
		$dateTimeUser	= $dateTimeServer;
		
        $this->tplObj->assign_vars(array(
			'recaptchaEnable'		=> Config::get('capaktiv'),
			'recaptchaPublicKey'	=> Config::get('cappublic'),
			'gameName' 				=> Config::get('game_name'),
			'facebookEnable'		=> Config::get('fb_on'),
			'fb_key' 				=> Config::get('fb_apikey'),
			'mailEnable'			=> Config::get('mail_active'),
			'reg_close'				=> Config::get('reg_closed'),
			'referralEnable'		=> Config::get('ref_active'),
			'analyticsEnable'		=> Config::get('ga_active'),
			'analyticsUID'			=> Config::get('ga_key'),
			'lang'					=> $LANG->getUser(),
			'UNI'					=> $UNI,
			'VERSION'				=> Config::get('VERSION'),
			'REV'					=> substr(Config::get('VERSION'), -4),
			'languages'				=> Language::getAllowedLangs(false),
		));
	}
	
	protected function printMessage($message, $redirect = NULL, $redirectButtons = NULL, $fullSide = true)
	{
		$this->assign(array(
			'message'			=> $message,
			'redirectButtons'	=> $redirectButtons,
		));
		
		if(isset($redirect)) {
			$this->tplObj->gotoside($redirect[0], $redirect[1]);
		}
		
		if(!$fullSide) {
			$this->setWindow('popup');
		}
		
		$this->render('error.default.tpl');
	}
	
	protected function save() {
		
	}
	
	protected function assign($array) {
		$this->tplObj->assign_vars($array);
	}
	
	protected function render($file) {
		global $LNG, $LANG, $CONFIG;
		
		$this->save();
		
		if($this->getWindow() !== 'ajax') {
			$this->getPageData();
		}
		
		$this->assign(array(
            'lang'    			=> $LANG->getUser(),
			'scripts'			=> $this->tplObj->jsscript,
			'execscript'		=> implode("\n", $this->tplObj->script),
			'bodyclass'			=> $this->getWindow(),
			'basepath'			=> PROTOCOL.HTTP_HOST.HTTP_BASE,
			'isMultiUniverse'	=> count($CONFIG) > 1,
		));

		$this->assign(array(
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
	
	protected function redirectPost($url, $postFields) {
		$this->save();
		$this->assign(array(
            'url'    		=> $url,
			'postFields'	=> $postFields,
		));
		
		$this->render('info.redirectPost.tpl');
	}
}