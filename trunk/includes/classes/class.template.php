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

require(ROOT_PATH.'includes/libs/Smarty/Smarty.class.php');
		
class template extends Smarty
{
	protected $window	= 'full';
	protected $jsscript	= array();
	protected $script	= array();
	
	function __construct()
	{	
		parent::__construct();
		$this->smartySettings();
	}
	
	function smartySettings()
	{	
		$this->force_compile 			= false;
		$this->caching 					= false; #Set true for production!
		$this->merge_compiled_includes	= true;
		$this->compile_check			= true; #Set false for production!
		$this->php_handling				= Smarty::PHP_REMOVE;
		
		$this->setCompileDir(is_writable(ROOT_PATH.'cache/') ? ROOT_PATH.'cache/' : $this->getTempPath());
		$this->setCacheDir(ROOT_PATH.'cache/templates');
		$this->setTemplateDir(ROOT_PATH.'styles/templates/');
		#$this->loadFilter('output', 'trimwhitespace');
	}
	
	public function loadscript($script)
	{
		$this->jsscript[]			= substr($script, 0, -3);
	}
	
	public function execscript($script)
	{
		$this->script[]				= $script;
	}
	
	public function getTempPath()
	{
		$this->force_compile 		= true;
		include(ROOT_PATH.'includes/libs/wcf/BasicFileUtil.class.php');
		return BasicFileUtil::getTempFolder();
	}
		
	public function assign_vars($var, $nocache = true) 
	{		
		parent::assign($var, NULL, $nocache);
	}
	
	private function adm_main()
	{
		global $LNG, $CONF, $LANG, $USER;
		
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
		
		$this->assign_vars(array(
			'scripts'			=> $this->script,
			'title'				=> $CONF['game_name'].' - '.$LNG['adm_cp_title'],
			'fcm_info'			=> $LNG['fcm_info'],
            'lang'    			=> $LANG->getUser(),
			'REV'				=> substr($CONF['VERSION'], -4),
			'date'				=> explode("|", date('Y\|n\|j\|G\|i\|s\|Z', TIMESTAMP)),
			'Offset'			=> $dateTimeUser->getOffset() - $dateTimeServer->getOffset(),
			'VERSION'			=> $CONF['VERSION'],
		));
	}
	
	public function show($file)
	{		
		global $USER, $PLANET, $CONF, $LNG, $THEME, $LANG;

		if($THEME->isCustomTPL($file))
			$this->setTemplateDir($THEME->getTemplatePath());
			
		$tplDir	= $this->getTemplateDir();
			
		if(MODE === 'INSTALL') {
			$this->setTemplateDir($tplDir[0].'install/');
		} elseif(MODE === 'ADMIN') {
			$this->setTemplateDir($tplDir[0].'adm/');
			$this->adm_main();
		}

		$this->assign_vars(array(
			'scripts'		=> $this->jsscript,
			'execscript'	=> implode("\n", $this->script),
		));

		$this->assign_vars(array(
			'LNG'			=> $LNG,
		), false);
		
		$this->compile_id	= $LANG->getUser();
		
		parent::display($file);
	}
	
	public function gotoside($dest, $time = 3)
	{
		$this->assign_vars(array(
			'gotoinsec'	=> $time,
			'goto'		=> $dest,
		));
	}
	
	public function message($mes, $dest = false, $time = 3, $Fatal = false)
	{
		global $LNG, $THEME;
	
		$this->assign_vars(array(
			'mes'		=> $mes,
			'fcm_info'	=> $LNG['fcm_info'],
			'Fatal'		=> $Fatal,
            'dpath'		=> $THEME->getTheme(),
		));
		
		$this->gotoside($dest, $time);
		$this->show('error_message_body.tpl');
	}
	
	public static function printMessage($Message, $fullSide = true, $redirect = NULL) {
		$template	= new self;
		if(!isset($redirect)) {
			$redirect	= array(false, 0);
		}
		
		$template->message($Message, $redirect[0], $redirect[1], !$fullSide);
		exit;
	}
	
    /**
    * Workaround  for new Smarty Method to add custom props...
    */

    public function __get($name)
    {
        $allowed = array(
        'template_dir' => 'getTemplateDir',
        'config_dir' => 'getConfigDir',
        'plugins_dir' => 'getPluginsDir',
        'compile_dir' => 'getCompileDir',
        'cache_dir' => 'getCacheDir',
        );

        if (isset($allowed[$name])) {
            return $this->{$allowed[$name]}();
        } else {
            return $this->{$name};
        }
    }
	
    public function __set($name, $value)
    {
        $allowed = array(
        'template_dir' => 'setTemplateDirgetTemplateDir',
        'config_dir' => 'setConfigDir',
        'plugins_dir' => 'setPluginsDir',
        'compile_dir' => 'setCompileDir',
        'cache_dir' => 'setCacheDir',
        );

        if (isset($allowed[$name])) {
            $this->{$allowed[$name]}($value);
        } else {
            $this->{$name} = $value;
        }
    }
}

?>