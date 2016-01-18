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

function ShowIndexPage()
{
	global $LNG;
	$template	= new template();

	$template->assign_vars(array(	
		'game_name'		=> Config::get()->game_name,
		'adm_cp_title'	=> $LNG['adm_cp_title'],
	));
	
	$template->display('adm/ShowIndexPage.tpl');
}