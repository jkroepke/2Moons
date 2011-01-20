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

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) exit;

function ShowMultiIPPage()
{
	global $LNG, $db;
	$Query	= $db->query("SELECT id, username, user_lastip FROM ".USERS," WHERE (user_lastip) IN (SELECT user_lastip FROM uni1_users GROUP BY user_lastip HAVING COUNT(*)>1) ORDER BY user_lastip ASC;");
	$IPs	= array();
	while($Data = $db->fetch_array($Query)) {
		if(!isset($IPs[$Data['user_lastip']]))
			$IPs[$Data['user_lastip']]	= array();
		
		$IPs[$Data['user_lastip']][]	= array($Data['username'], $Data['id']);
	}
	$template	= new template();
	$template->assign_vars(array(
		'IPs'	=> $IPs
	));
	$template->show('adm/MultiIPs.tpl');
}


?>