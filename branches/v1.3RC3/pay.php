<?php

/**
 *  2Moons
 *  Copyright (C) 2011  Slaver
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
 * @author Slaver <slaver7@gmail.com>
 * @copyright 2009 Lucky <douglas@crockford.com> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.3 (2011-01-21)
 * @link http://code.google.com/p/2moons/
 */

exit;
define('INSIDE', true );
define('INSTALL', false );
define('AJAX', true );

define('ROOT_PATH', str_replace('\\', '/',dirname(__FILE__)).'/');
	
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

