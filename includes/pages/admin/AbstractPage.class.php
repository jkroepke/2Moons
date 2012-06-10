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
 * @version 2.0.$Revision$ (2012-11-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

abstract class AbstractPage
{
	protected $tplObj;
	protected $ecoObj;
	protected $window;
	protected $disableEcoSystem = false;
	
	public function __construct() {
		
		if(!AJAX_REQUEST)
		{
			$this->setWindow('full');
			$this->initTemplate();
		} else {
			$this->setWindow('ajax');
		}
	}
	
	protected function initTemplate() {
		if(isset($this->tplObj))
			return true;
			
		$this->tplObj	= new Template;
		
		list($tplDir)	= $this->tplObj->getTemplateDir();
		$this->tplObj->setTemplateDir($tplDir.'admin/');
		return true;
	}
	
	protected function setWindow($window) {
		$this->window	= $window;
	}
		
	protected function getWindow() {
		return $this->window;
	}
	
	protected function getNavigationData() 
    {
		global $ADMINUNI, $uniAllConfig;
		
		$AvailableUnis	= array();
		foreach($uniAllConfig as $uniID => $config)
		{
			$AvailableUnis[$uniID]	= $config['uniName'];
		}
		
		ksort($AvailableUnis);
		
		$this->assign(array(
			'ticketNotify'	=> $GLOBALS['DATABASE']->countquery("SELECT COUNT(*) FROM ".TICKETS." WHERE universe = ".$ADMINUNI." AND status = 0;"),
			'SID'			=> session_id(),
			'AvailableUnis'	=> $AvailableUnis,
		));
	}
	
	protected function getPageData() 
    {
		global $gameConfig, $uniConfig, $USER, $ADMINUNI;
		if($this->getWindow() === 'full') {
			$this->getNavigationData();
		}
		
		$this->assign(array(
			'date'		=> explode("|", date('Y\|n\|j\|G\|i\|s\|Z', TIMESTAMP)),
			'authlevel'	=> $USER['authlevel'],
			'userID'	=> $USER['id'],
            'game_name'	=> $gameConfig['gameName'],
            'uni_name'	=> $uniConfig['uniName'],
			'VERSION'	=> $gameConfig['version'],
			'REV'		=> substr($gameConfig['version'], -4),
			'UNI'		=> $ADMINUNI,
		));
	}
	
	protected function printMessage($message, $redirect = NULL, $redirectButtons = NULL, $fullSide = true)
	{
		$this->assign(array(
			'messages'			=> $message,
			'redirectButtons'	=> $redirectButtons,
		));
		
		if(isset($redirect)) {
			$this->gotoside($redirect[0], $redirect[1]);
		}
		
		if(!$fullSide) {
			$this->setWindow('popup');
		}
		
		$this->render('error.default.tpl');
	}
	
	protected function save() {	}
	
	protected function assign($var) {
		$this->tplObj->assign($var);
	}
	
	protected function loadscript($file) {
		$this->tplObj->loadscript($file);
	}
	
	protected function execscript($file) {
		$this->tplObj->execscript($file);
	}
	
	protected function render($file) {
		global $LNG, $LANG, $THEME;
		
		$this->save();
		
		if($this->getWindow() !== 'ajax') {
			$this->getPageData();
		}
		
		$this->assign(array(
            'lang'    		=> $LANG->getUser(),
            'dpath'			=> $THEME->getTheme(),
			'scripts'		=> $this->tplObj->jsscript,
			'execscript'	=> implode("\n", $this->tplObj->script),
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
}