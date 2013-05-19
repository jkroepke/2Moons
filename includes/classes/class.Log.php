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
 * @version 1.3 (2011-01-21)
 * @link http://2moons.cc/
 */
 
class Log
{
	private $mode;
	private $data	= array();
	private static $db = null;

	function __construct($mode) {
		$this->data['mode']		= $mode;
		$this->data['admin']	= $_SESSION['id'];
		$this->data['uni']		= $_SESSION['adminuni'];
	}
	public function __set($key, $value){
		$this->data[$key] = $value;
	}
	public function __get($key){
        return $this->__isset($key) ? $this->data[$key] : null;
    }
	public function __isset($key){
        return isset($this->data[$key]);
    }
	function save() {
		$data = serialize(array($this->data['old'], $this->data['new']));
		$uni = (empty($this->data['universe']) ? $this->data['uni'] : $this->data['universe']);
		$GLOBALS['DATABASE']->query("INSERT INTO ".LOG." (`id`,`mode`,`admin`,`target`,`time`,`data`,`universe`) VALUES 
		(NULL , ".$GLOBALS['DATABASE']->sql_escape($this->data['mode']).", ".$GLOBALS['DATABASE']->sql_escape($this->data['admin']).", '".$GLOBALS['DATABASE']->sql_escape($this->data['target'])."', ".TIMESTAMP." , '".$GLOBALS['DATABASE']->sql_escape($data)."', '".$uni."');");
	}
}
