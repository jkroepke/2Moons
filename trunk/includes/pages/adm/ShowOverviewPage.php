<?php

##############################################################################
# *                                                                          #
# * 2MOONS                                                                   #
# *                                                                          #
# * @copyright Copyright (C) 2010 By ShadoX from titanspace.de               #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
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

function ShowOverviewPage()
{
	global $LNG, $USER, $CONF;
	
	$Message	= array();

	if ($USER['authlevel'] >= AUTH_ADM)
	{
		if(is_writable(ROOT_PATH.'includes/config.php'))
			$Message[]	= $LNG['ow_config_file_writable'];
		
		if(!is_writable(ROOT_PATH.'includes'))
			$Message[]	= sprintf($LNG['ow_dir_not_writable'], 'includes');
			
		if(!is_writable(ROOT_PATH.'raports'))
			$Message[]	= sprintf($LNG['ow_dir_not_writable'], 'raports');
		
		if($CONF['user_valid'] == 1 && (empty($CONF['smtp_host']) || empty($CONF['smtp_port']) || empty($CONF['smtp_user']) || empty($CONF['smtp_pass'])))
			$Message[]	= $LNG['ow_smtp_errors'];
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
		'Messages'			=> $Message,
		'date'				=> date('m\_Y', TIMESTAMP),
	));
	
	$template->show('adm/OverviewBody.tpl');
}

?>