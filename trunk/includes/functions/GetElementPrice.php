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
 * @version 1.3 (2011-01-21)
 * @link http://code.google.com/p/2moons/
 */

function GetElementPrice ($USER, $PLANET, $Element, $USERfactor = true) { 
     global $pricelist, $resource, $LNG; 
		if ($USERfactor)
			$level = (isset($PLANET[$resource[$Element]])) ? $PLANET[$resource[$Element]] : $USER[$resource[$Element]];

		$array = array(
			'metal'      => $LNG['Metal'],
			'crystal'    => $LNG['Crystal'],
			'deuterium'  => $LNG['Deuterium'],
			'energy_max' => $LNG['Energy'],
		    'darkmatter' => $LNG['Darkmatter'],
		);
		$text = "";
		foreach ($array as $ResType => $ResTitle)
		{
			if ($pricelist[$Element][$ResType] != 0)
			{
				$text .= $ResTitle . ": ";
				$cost  = $USERfactor ? floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level)) : floor($pricelist[$Element][$ResType]);
				$text .= (isset($PLANET[$ResType]) && $cost > $PLANET[$ResType]) || (isset($USER[$ResType]) && $cost > $USER[$ResType]) ? "<b style=\"color:red;\" id=\"".$ResType."_".$Element."\">" . pretty_number($cost) . "</b> " : "<b style=\"color:lime;\" id=\"".$ResType."_".$Element."\">" . pretty_number($cost) . "</b> ";
			}
		}
    return $text; 
}  
?>