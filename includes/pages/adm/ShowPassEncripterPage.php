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

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) throw new Exception("Permission error!");

function ShowPassEncripterPage()
{
	global $LNG;
	$Password	= HTTP::_GP('md5q', '', true);
	
	$template	= new template();

	$template->assign_vars(array(
		'md5_md5' 			=> $Password,
		'md5_enc' 			=> PlayerUtil::cryptPassword($Password),
		'et_md5_encripter' 	=> $LNG['et_md5_encripter'],
		'et_encript' 		=> $LNG['et_encript'],
		'et_result' 		=> $LNG['et_result'],
		'et_pass' 			=> $LNG['et_pass'],
	));
	
	$template->show('PassEncripterPage.tpl');
}