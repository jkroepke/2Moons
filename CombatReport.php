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
 * @copyright 2009 Lucky <lucky@xgproyect.net> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.6 (2011-11-17)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

define('INSIDE'  , true);
define('AJAX', true );

define('ROOT_PATH', str_replace('\\', '/',dirname(__FILE__)).'/');
require(ROOT_PATH . 'includes/common.php');
require(ROOT_PATH . 'includes/classes/class.template.php');

if(isset($_SESSION['USER']))
	$LANG->setUser($_SESSION['USER']['lang']);	
else
	$LANG->GetLangFromBrowser();
	
$LANG->includeLang(array('L18N', 'FLEET', 'TECH'));
	
$RID		= request_var('raport', 0);
$Fame		= request_var('fame', 0);
if($Fame == 1) {
	$Raport		= $db->uniquequery("SELECT 
									`raport`, `time`,
									(
										SELECT 
										GROUP_CONCAT(username SEPARATOR ' & ') as attacker
										FROM ".USERS." 
										WHERE `id` IN (SELECT `uid` FROM ".TOPKB_USERS." WHERE ".TOPKB_USERS.".`rid` = ".RW.".`rid` AND `role` = 1)
									) as `attacker`,
									(
										SELECT 
										GROUP_CONCAT(username SEPARATOR ' & ') as defender
										FROM ".USERS." 
										WHERE `id` IN (SELECT `uid` FROM ".TOPKB_USERS." WHERE ".TOPKB_USERS.".`rid` = ".RW.".`rid` AND `role` = 2)
									) as `defender`
									FROM ".RW."
									WHERE `rid` = ".$RID.";");
	$Info		= array($Raport["attacker"], $Raport["defender"]);
} else {
	$Raport		= $db->uniquequery("SELECT `raport` FROM ".RW." WHERE `rid` = ".$RID.";");
	$Info		= array();
}

$template	= new template();
if(!isset($Raport)) {
	$template->message($LNG['sys_raport_not_found'], 0, false, true);
	exit;
}
$template->isPopup(true);
$template->assign_vars(array(
	'Raport'	=> unserialize($Raport["raport"]),
	'Info'		=> $Info,
	'fame'		=> $Fame
));
$template->show('CombatRaport.tpl');

?>