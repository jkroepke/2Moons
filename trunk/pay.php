<?php

##############################################################################
# *                                                                          #
# * 2MOONS                                                                   #
# *                                                                          #
# * @copyright Copyright (C) 2010 By ShadoX from titanspace.de               #
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

define('INSIDE', true );
define('INSTALL', false );
define('AJAX', true );

define('ROOT_PATH', str_replace('\\', '/',dirname(__FILE__)).'/');
	
include_once(ROOT_PATH . 'extension.inc');
include_once(ROOT_PATH . 'common.php');
$SESSION   	= new Session();

$mode		= request_var('mode', '');
switch($mode)
{
	case 'out':
		echo "<html><head></head><body onload=\"document.forms['form'].submit();\"><form name='form' method='POST' action='http://pay.2moons.cc/pay.php'><input type='hidden' name='key' value='".$CONF['paymentkey']."'><input type='hidden' name='user' value='".$_SESSION['USER']['username']."'><input type='hidden' name='email' value='".$_SESSION['USER']['email_2']."'><input type='submit'></form></body></html>";
	break;
	case 'ipn':
		$CODE	= file_get_contents('http://pay.2moons.cc/useripn.php?key='.$CONF['paymentkey'].'&id='.$_POST['id']);
		if($CODE !== 'OK')
			exit;
		
		$db->query("UPDATE ".USERS." SET `darkmatter` = `darkmatter` + '".(int)$_POST['amount']."' WHERE `email_2` = '".$db->sql_escape(reqeust_var('email_2', '')).";");
		
		exit('OK');
	break;
}

