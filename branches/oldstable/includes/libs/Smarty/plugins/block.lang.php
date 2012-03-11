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
 * @version 1.5 (2011-05-04)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */
 
function smarty_block_lang($params, $content, $template, &$repeat)
{ 
	if(empty($content))
		return '';
	
	if(strpos($content, '.') === false)
		return isset($GLOBALS['LNG'][$content]) ? $GLOBALS['LNG'][$content] : $content;
			
	$_TMP	= explode('.', $content);
	if(count($_TMP) == 2)
		return isset($GLOBALS['LNG'][$_TMP[0]][$_TMP[1]]) ? $GLOBALS['LNG'][$_TMP[0]][$_TMP[1]] : $content;
	else
		return isset($GLOBALS['LNG'][$_TMP[0]][$_TMP[1]][$_TMP[2]]) ? $GLOBALS['LNG'][$_TMP[0]][$_TMP[1]][$_TMP[2]] : $content;
}

?>