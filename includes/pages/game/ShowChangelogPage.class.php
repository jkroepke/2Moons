<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @licence MIT
 * @version 1.7.2 (2013-03-18)
 * @info $Id$
 * @link http://2moons.cc/
 */


class ShowChangelogPage extends AbstractGamePage
{
	public static $requireModule = 0;

	function __construct() 
	{
		parent::__construct();
	}
	
	function show() 
	{
		global $LNG;

        $LNG->includeData(array('CHANGELOG'));
		$this->assign(array(
			'ChangelogList'	=> array_map('makebr', $LNG['changelog']),
		));
		
		$this->display('page.changelog.default.tpl');
	}
}