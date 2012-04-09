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
 * @version 1.3 (2011-01-21)
 * @link http://code.google.com/p/2moons/
 */
 
class AdminLog
{
	private $mode;
	private $data	= array();
	private static $db = null;
	
	const PLAYER	= 1;
	const PLANET	= 2;
	const SETTINGS	= 3;
	const PRESENTS	= 4;

	function __construct() {
		$this->data['admin']	= $_SESSION['id'];
		$this->data['uni']		= $_SESSION['adminuni'];
	}
	
	function setMode($mode) {
		$this->data['mode']		= $mode;
		
		return $this;
	}
	
	function setTarget($id) {
		$this->data['target'] = $id;
		
		return $this;
	}
	
	function setOldData(array $data) {
		$this->data['old'] = $data;
		
		return $this;
	}
	
	function setNewData(array $data) {
		$this->data['new'] = $data;
		
		return $this;
	}
	
	function save() {
		$data = serialize(array($this->data['old'], $this->data['new']));
		$uni = ($this->data['universe'] == NULL ? $this->data['uni'] : $this->data['universe']);
		$GLOBALS['DATABASE']->query("INSERT INTO ".LOG." (`id`,`mode`,`admin`,`target`,`time`,`data`,`universe`) VALUES 
		(NULL , ".$GLOBALS['DATABASE']->sql_escape($this->data['mode']).", ".$GLOBALS['DATABASE']->sql_escape($this->data['admin']).", '".$GLOBALS['DATABASE']->sql_escape($this->data['target'])."', ".TIMESTAMP." , '".$GLOBALS['DATABASE']->sql_escape($data)."', '".$uni."');");
	}
}
