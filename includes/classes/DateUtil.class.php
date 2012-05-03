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

class DateUtil
{
	static function localeNamesDateFormat($format, $time, $LNG = NULL)
	{
		//Workaound for locale Names.

		if(!isset($LNG)) {
			$LNG	= $GLOBALS['LNG'];		
		}
		
		$weekDay	= date('w', $time);
		$months		= date('n', $time) - 1;
		
		$format     = str_replace(array('D', 'M'), array('$D$', '$M$'), $format);
		$format		= str_replace('$D$', addcslashes($LNG['week_day'][$weekDay], 'A..z'), $format);
		$format		= str_replace('$M$', addcslashes($LNG['months'][$months], 'A..z'), $format);
		
		return $format;
	}

	static function format($format, $time = null, $toTimeZone = null, $LNG = NULL)
	{
		if(!isset($time)) {
			$time	= TIMESTAMP;
		}
		
		if(isset($toTimeZone))
		{
			$date = new DateTime();
			if(method_exists($date, 'setTimestamp'))
			{	// PHP > 5.3			
				$date->setTimestamp($time);
			} else {
				// PHP < 5.3
				$tempDate = getdate((int) $time);
				$date->setDate($tempDate['year'], $tempDate['mon'], $tempDate['mday']);
				$date->setTime($tempDate['hours'], $tempDate['minutes'], $tempDate['seconds']);
			}
			
			$time	-= $date->getOffset();
			try {
				$date->setTimezone(new DateTimeZone($toTimeZone));
			} catch (Exception $e) {
				
			}
			$time	+= $date->getOffset();
		}
		
		$format	= locale_date_format($format, $time, $LNG);
		return date($format, $time);
	}
	
	static function getTimezones() {
		global $LNG;
		
		// New Timezone Selector, better support for changes in tzdata (new russian timezones, e.g.)
		// http://www.php.net/manual/en/datetimezone.listidentifiers.php
		
		$timezones = array();
		$timezone_identifiers = DateTimeZone::listIdentifiers();

		foreach($timezone_identifiers as $value)
		{
			if (preg_match('/^(America|Antartica|Arctic|Asia|Atlantic|Europe|Indian|Pacific)\//', $value ) )
			{
				$ex = explode('/',$value); //obtain continent,city
				$city = isset($ex[2])? $ex[1].' - '.$ex[2]:$ex[1]; //in case a timezone has more than one
				$timezones[$ex[0]][$value] = str_replace('_', ' ', $city);
			}
		}
		return $timezones; 
	}
}