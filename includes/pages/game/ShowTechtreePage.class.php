<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan
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
 * @author Jan <info@2moons.cc>
 * @copyright 2006 Perberos <ugamela@perberos.com.ar> (UGamela)
 * @copyright 2008 Chlorel (XNova)
 * @copyright 2009 Lucky (XGProyecto)
 * @copyright 2012 Jan <info@2moons.cc> (2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.0 (2012-05-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */


class ShowTechtreePage extends AbstractPage
{
	public static $requireModule = MODULE_TECHTREE;

	function __construct() 
	{
		parent::__construct();
	}
	
	function show()
	{
		global $resource, $requeriments, $LNG, $reslist, $USER, $PLANET;

		$TechTreeList	= array();
		
		$elementIDs	= array_keys($GLOBALS['VARS']['ELEMENT']);
		
		foreach($elementIDs as $elementID)
		{
			if(elementHasFlag($elementID, ELEMENT_BUILD)) {
				$class	= 0;
			} elseif(elementHasFlag($elementID, ELEMENT_TECH)) {
				$class	= 100;
			} elseif(elementHasFlag($elementID, ELEMENT_FLEET)) {
				$class	= 200;
			} elseif(elementHasFlag($elementID, ELEMENT_DEFENSIVE)) {
				$class	= 400;
			} elseif(elementHasFlag($elementID, ELEMENT_OFFICIER)) {
				$class	= 600;
			} else {
				continue;
			}
			
			$TechTreeList[$class][$elementID]	= array();
			
			if(isset($GLOBALS['VARS']['ELEMENT'][$elementID]['require']))
			{
				foreach($GLOBALS['VARS']['ELEMENT'][$elementID]['require'] as $requireID => $RedCount)
				{
					$TechTreeList[$class][$elementID][$requireID]	= array('count' => $RedCount, 'own' => (isset($PLANET[$GLOBALS['VARS']['ELEMENT'][$requireID]['name']])) ? $PLANET[$GLOBALS['VARS']['ELEMENT'][$requireID]['name']] : $USER[$GLOBALS['VARS']['ELEMENT'][$requireID]['name']]);
				}
			}
		}
		
		$this->assign_vars(array(
			'TechTreeList'		=> $TechTreeList,
		));

		$this->render('page.techtree.default.tpl');
	}
}
