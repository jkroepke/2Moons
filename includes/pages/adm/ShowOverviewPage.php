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

function ShowOverviewPage()
{
	global $LNG, $USER;
	
	$Message	= array();

	if ($USER['authlevel'] >= AUTH_ADM)
	{
		if(file_exists(ROOT_PATH.'update.php'))
			$Message[]	= sprintf($LNG['ow_file_detected'], 'update.php');
			
		if(file_exists(ROOT_PATH.'webinstall.php'))
			$Message[]	= sprintf($LNG['ow_file_detected'], 'webinstall.php');
			
		if(file_exists('includes/ENABLE_INSTALL_TOOL'))
			$Message[]	= sprintf($LNG['ow_file_detected'], 'includes/ENABLE_INSTALL_TOOL');
					
		if(!is_writable(ROOT_PATH.'cache'))
			$Message[]	= sprintf($LNG['ow_dir_not_writable'], 'cache');
			
		if(!is_writable('includes'))
			$Message[]	= sprintf($LNG['ow_dir_not_writable'], 'includes');
	}
	
	$template	= new template();


	$template->assign_vars(array(	
		'ow_none'			=> $LNG['ow_none'],
		'ow_overview'		=> $LNG['ow_overview'],
		'ow_welcome_text'	=> $LNG['ow_welcome_text'],
		'ow_credits'		=> $LNG['ow_credits'],
		'ow_special_thanks'	=> $LNG['ow_special_thanks'],
		'ow_translator'		=> $LNG['ow_translator'],
		'ow_proyect_leader'	=> $LNG['ow_proyect_leader'],
		'ow_support'		=> $LNG['ow_support'],
		'ow_title'			=> $LNG['ow_title'],
		'ow_forum'			=> $LNG['ow_forum'],
		'ow_donate'			=> $LNG['ow_donate'],
		'Messages'			=> $Message,
		'date'				=> date('m\_Y', TIMESTAMP),
	));
	
	$template->show('OverviewBody.tpl');
}
