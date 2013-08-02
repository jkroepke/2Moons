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
 * @info $Id: Universe.class.php 2768 2013-07-24 17:20:01Z slaver7 $
 * @link http://2moons.cc/
 */

class Vars
{
    static private $data = array();

    const CLASS_BUILDING    = 0;
    const CLASS_TECH        = 100;
    const CLASS_FLEET       = 200;
    const CLASS_DEFENSE     = 400;
    const CLASS_MISSILE     = 500;
    const CLASS_PERM_BONUS  = 600;
    const CLASS_TEMP_BONUS  = 700;
    const CLASS_RACE        = 800;
    const CLASS_RESOURCE    = 900;

    const FLAG_BUILD_ON_PLANET  = 1;
    const FLAG_BUILD_ON_MOON    = 2;
    const FLAG_RESOURCE_PLANET  = 4;
    const FLAG_RESOURCE_USER    = 8;
    const FLAG_ENERGY           = 16;
    const FLAG_DEBRIS           = 32;
    const FLAG_TRANSPORT        = 64;
    const FLAG_STEAL            = 128;
    const FLAG_TOPNAV           = 256;
    const FLAG_PRODUCTION       = 512;
    const FLAG_STORAGE          = 1024;
    const FLAG_BONUS            = 2048;
    const FLAG_SPY              = 4096;
    const FLAG_COLLECT          = 8192;
    const FLAG_COLONIZE         = 16384;
    const FLAG_DESTROY          = 32768;
    const FLAG_SPEC_EXPEDITION  = 65536;
    const FLAG_ATTACK_MISSILE   = 131072;
    const FLAG_DEFEND_MISSILE   = 262144;
    const FLAG_TRADE            = 524288;
    const FLAG_ON_ECO_OVERVIEW  = 1048576;


    static function init()
    {
        $cache	= Cache::get();
        $cache->add('vars', 'VarsBuildCache');
        self::$data = $cache->getData('vars');
    }

    static function generateCache()
    {
        $db         	= Database::get();
        $data           = array('elements' => array(), 'list' => array('classes' => array(), 'flags' => array()));
        $rapidFire      = array();
        $requirements   = array();

        $rapidResult    = $db->nativeQuery('SELECT * FROM %%VARS_RAPIDFIRE%%;');
        foreach($rapidResult as $rapidRow)
        {
            $rapidFire[$rapidRow['elementID']][$rapidRow['rapidfireID']]    = $rapidRow['shoots'];
        }

        $reqResult      = $db->nativeQuery('SELECT * FROM %%VARS_REQUIRE%%;');
        foreach($reqResult as $reqRow)
        {
            $requirements[$reqRow['elementID']][$reqRow['requireID']]    = $reqRow['requireLevel'];
        }

        // resources needs preloaded.
        $varsResult		= $db->nativeQuery('SELECT * FROM %%VARS%% WHERE class = '.self::CLASS_RESOURCE.';');
        foreach($varsResult as $varsRow)
        {
            $elementId      = $varsRow['elementID'];
            $elementData    = $varsRow;
            $elementData['rapidFire']       = array();
            $elementData['requirements']    = array();
            $data['elements'][$elementId]   = new Element($varsRow);

            if(!isset($data['list']['classes'][$data['elements'][$elementId]->class]))
            {
                $data['list']['classes'][$data['elements'][$elementId]->class] = array();
            }

            $data['list']['classes'][$data['elements'][$elementId]->class][$elementId] =& $data['elements'][$elementId];

            foreach($data['elements'][$elementId]->flags as $flag)
            {
                if(!isset($data['list']['flags'][$flag]))
                {
                    $data['list']['flags'][$flag] = array();
                }

                $data['list']['flags'][$flag][$elementId] =& $data['elements'][$elementId];
            }
        }

        $varsResult		= $db->nativeQuery('SELECT * FROM %%VARS%% WHERE class != '.self::CLASS_RESOURCE.';');
        foreach($varsResult as $varsRow)
        {
            $elementId      = $varsRow['elementID'];
            $elementData    = $varsRow;
            $elementData['rapidFire']       = isset($rapidFire[$elementId]) ? $rapidFire[$elementId] : array();
            $elementData['requirements']    = isset($requirements[$elementId]) ? $requirements[$elementId] : array();

            $data['elements'][$elementId]   = new Element($varsRow, array(
                $data['list']['flags'][self::FLAG_RESOURCE_PLANET],
                $data['list']['flags'][self::FLAG_RESOURCE_USER],
                $data['list']['flags'][self::FLAG_ENERGY]
            ));

            if(!isset($data['list']['classes'][$data['elements'][$elementId]->class]))
            {
                $data['list']['classes'][$data['elements'][$elementId]->class] = array();
            }

            $data['list']['classes'][$data['elements'][$elementId]->class][$elementId] =& $data['elements'][$elementId];

            foreach($data['elements'][$elementId]->flags as $flag)
            {
                if(!isset($data['list']['flags'][$flag]))
                {
                    $data['list']['flags'][$flag] = array();
                }

                $data['list']['flags'][$flag][$elementId] =& $data['elements'][$elementId];
            }
        }

        return $data;
    }

    /**
     * Get a Element Object by ID
     *
     * @return Element
     */

    static function getElement($elementId)
    {
        return self::$data['elements'][$elementId];
    }

    /**
     * Get Elements by class and flags
     *
     * @return Element[]
     */

    static function getElements($class = NULL, $flags = array())
    {
        if(!is_array($flags))
        {
            $flags  = array($flags);
        }

        $elements   = array();

        foreach($flags as $flag)
        {
            if(!isset(self::$data['list']['flags'][$flag]))
            {
                throw new Exception("Unknown element flag '$flag'!");
            }

            $elements   += self::$data['list']['flags'][$flag];
        }

        if(!is_null($class) && isset(self::$data['list']['classes'][$class]))
        {
            $elements   = array_intersect_key($elements, self::$data['list']['classes'][$class]);
        }

        return $elements;
    }
}