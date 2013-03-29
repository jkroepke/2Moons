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

class autoload
{
	const CLASS_SUFFIX 		= '.class.php';

    private static $classes = array();

    /**
     * Initialisiert eine Klasse
     *
     * @param string $class
     * @param array $params
     */
	public static function get($class, $params = array())
    {
        if(is_string($class) === false)
        {
            self::error('class name not allowed.');
        }

        $split 		 = explode('::', $class);
        $class_name  = array_pop($split);

        if(empty(self::$classes[$class_name]))
        {
            $file =  $class.self::CLASS_SUFFIX;

            require $file;

            try{
                self::$classes[$class_name] = new $class_name();
            }catch(Exception $e){
                echo __CLASS__ .' error: '. $e->getMessage();
            }
        }

        return self::$classes[$class_name];
    }


    /**
     * Wirft einen Fehler aus
	 *
	 * @param String
	 * @param int
	 * @return void
     */
    public static function error($message, $code = 0)
    {
    	throw new Exception($message, $code);
    }
}