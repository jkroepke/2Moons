<?php

/**
 *  2Moons
 *  Copyright (C) 2012 Jan Kröpke
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
 * @author Jan Kröpke <info@2moons.cc>
 * @copyright 2012 Jan Kröpke <info@2moons.cc>
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.7.2 (2013-03-18)
 * @info $Id$
 * @link http://2moons.cc/
 */


class ShowTechtreePage extends AbstractGamePage
{
	public static $requireModule = MODULE_TECHTREE;

	function __construct() 
	{
		parent::__construct();
	}
	
	function show()
	{
		global $USER, $PLANET;

        $techTreeList   = array();

        $elementList    = array(
            Vars::CLASS_BUILDING,
            Vars::CLASS_TECH,
            Vars::CLASS_FLEET,
            Vars::CLASS_DEFENSE,
            Vars::CLASS_MISSILE,
            Vars::CLASS_PERM_BONUS
        );
			
		foreach($elementList as $classId)
		{
            $techTreeList[$classId] = $classId;
            $elementIds = Vars::getElements($classId);

            foreach($elementIds as $elementId => $elementObj)
            {
				$requirements   = array();
                foreach($elementObj->requirements as $requireElementId => $requiredLevel)
                {
                    $requireElementName = Vars::getElement($requireElementId)->name;

                    $requirements[$requireElementId]	= array(
                        'count' => $requiredLevel,
                        'own'   => isset($PLANET[$requireElementName]) ? $PLANET[$requireElementName] : $USER[$requireElementName]
                    );
                }
				
				$techTreeList[$elementId]	= $requirements;
			}
		}
		
		$this->assign(array(
			'TechTreeList'		=> $techTreeList,
		));

		$this->display('page.techtree.default.tpl');
	}
}