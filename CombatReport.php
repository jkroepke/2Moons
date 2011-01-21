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

define('INSIDE'  , true);
define('INSTALL' , false);

define('ROOT_PATH', './');
include(ROOT_PATH . 'common.php');

$LANG->includeLang(array('FLEET', 'TECH'));
	
$RID	= request_var('raport', '');

if(file_exists(ROOT_PATH.'raports/raport_'.$RID.'.php'))
	require_once(ROOT_PATH.'raports/raport_'.$RID.'.php');

$template	= new template();

$template->isPopup(true);
$template->execscript('</script><script type="text/javascript" src="http://savekb.2moons.cc/js.php">');

$template->assign_vars(array('raport' => $raport));
$template->show('raport.tpl');

?>