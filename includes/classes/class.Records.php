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
 * @version 1.5 (2011-07-31)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

class records
{
	public static $File	= "cache/CacheRecords.php";
	public $maxinfos	= array();
	
	function SetIfRecord($ID, $Data)
	{
		global $CONF, $resource;
		if(($CONF['stat'] == 1 && $Data['authlevel'] >= $CONF['stat_level']) || !empty($Data['bana']))
			return;
		
		if(!isset($this->maxinfos[$Data['universe']]))
			$this->maxinfos[$Data['universe']] = array();
			
		if(!isset($this->maxinfos[$Data['universe']][$ID]))
			$this->maxinfos[$Data['universe']][$ID] = array('maxlvl' => 0, 'username' => '');
		
		if($Data[$resource[$ID]] == 0)
			return;
			
		if($this->maxinfos[$Data['universe']][$ID]['maxlvl'] < $Data[$resource[$ID]])
			$this->maxinfos[$Data['universe']][$ID] = array('maxlvl' => $Data[$resource[$ID]], 'username' => $this->GetPlayerCardLink($Data));
		elseif($this->maxinfos[$Data['universe']][$ID]['maxlvl'] == $Data[$resource[$ID]] && strpos($this->maxinfos[$Data['universe']][$ID]['username'], '>'.$Data['username'].'<') === false)
			$this->maxinfos[$Data['universe']][$ID]['username'] = implode(array($this->maxinfos[$Data['universe']][$ID]['username'], $this->GetPlayerCardLink($Data)), '<br>');
	}

	function GetPlayerCardLink($Data) 
	{
		return '<a href="#" onclick="return Dialog.Playercard('.(isset($Data['id_owner']) ? $Data['id_owner'] : $Data['id']).', \\\''.$Data['username'].'\\\');">'.$Data['username'].'</a>';
	}

	function BuildRecordCache() 
	{
		$Elements	= array_merge($GLOBALS['reslist']['build'], $GLOBALS['reslist']['tech'], $GLOBALS['reslist']['fleet'], $GLOBALS['reslist']['defense']);
		$PHP		= "<?php \n//The File is created on ".date('d. M Y, H:i:s', TIMESTAMP)."\n$"."RecordsArray = array(\n";
		foreach($this->maxinfos as $Uni	=> $Records) {
			$PHP	.= "\t".$Uni." => array(\n";
			foreach($Elements as $ElementID) {
				$PHP	.= "\t\t".$ElementID." => array('username' => '".(isset($Records[$ElementID]['username']) ? $Records[$ElementID]['username'] : '')."', 'maxlvl' => '".(isset($Records[$ElementID]['maxlvl']) ? pretty_number($Records[$ElementID]['maxlvl']) : '0')."'),\n";
			}
			$PHP		.= "\t),\n";
		}
		$PHP		.= "\n);\n?>";
		file_put_contents(ROOT_PATH.self::$File, $PHP);
	}
	
	function GetRecords($Uni)
	{
		if(!file_exists(ROOT_PATH.self::$File))
			return array();
		
		require(ROOT_PATH.self::$File);
		return $RecordsArray[$Uni];
	}
}

?>