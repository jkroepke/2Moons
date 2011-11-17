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
 * @version 1.6 (2011-11-17)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

require(ROOT_PATH.'includes/classes/class.Records.php');	

function ShowRecordsPage()
{
	global $USER, $PLANET, $LNG, $resource, $db, $CONF, $UNI;
		
	$PlanetRess = new ResourceUpdate();
	$PlanetRess->CalcResource();
	$PlanetRess->SavePlanetToDB();

	$template	= new template();
	
	$Records		= new records();
	$RecordsArray	= $Records->GetRecords($UNI);
	
	foreach($RecordsArray as $ElementID => $ElementIDArray) {
		if ($ElementID >=   1 && $ElementID <=  39 || $ElementID == 44) {
			$Builds[$ElementID]	= array(
				'winner'	=> ($ElementIDArray['maxlvl'] != 0) ? $ElementIDArray['username'] : $LNG['rec_empty'],
				'count'		=> ($ElementIDArray['maxlvl'] != 0) ? $ElementIDArray['maxlvl']   : $LNG['rec_empty'],
			);
		} elseif ($ElementID >=  41 && $ElementID <= 99 && $ElementID != 44) {
			$MoonsBuilds[$ElementID]	= array(
				'winner'	=> ($ElementIDArray['maxlvl'] != 0) ? $ElementIDArray['username'] : $LNG['rec_empty'],
				'count'		=> ($ElementIDArray['maxlvl'] != 0) ? $ElementIDArray['maxlvl']   : $LNG['rec_empty'],
			);
		} elseif ($ElementID >= 101 && $ElementID <= 199) {
			$Techno[$ElementID]	= array(
				'winner'	=> ($ElementIDArray['maxlvl'] != 0) ? $ElementIDArray['username'] : $LNG['rec_empty'],
				'count'		=> ($ElementIDArray['maxlvl'] != 0) ? $ElementIDArray['maxlvl']   : $LNG['rec_empty'],
			);
		} elseif ($ElementID >= 201 && $ElementID <= 399) {
			$Fleet[$ElementID]	= array(
				'winner'	=> ($ElementIDArray['maxlvl'] != 0) ? $ElementIDArray['username'] : $LNG['rec_empty'],
				'count'		=> ($ElementIDArray['maxlvl'] != 0) ? $ElementIDArray['maxlvl']   : $LNG['rec_empty'],
			);
		} elseif ($ElementID >= 401 && $ElementID <= 599) {
			$Defense[$ElementID]	= array(
				'winner'	=> ($ElementIDArray['maxlvl'] != 0) ? $ElementIDArray['username'] : $LNG['rec_empty'],
				'count'		=> ($ElementIDArray['maxlvl'] != 0) ? $ElementIDArray['maxlvl']   : $LNG['rec_empty'],
			);
		}
	}
	
	$Records	= array(
		'build'	=> $Builds,
		'specb'	=> $MoonsBuilds,
		'techn'	=> $Techno,
		'fleet'	=> $Fleet,
		'defes'	=> $Defense,
	);
	
	$template->assign_vars(array(	
		'Records'	 	=> $Records,
		'update'		=> tz_date($CONF['stat_last_update']),
	));
	
	$template->show("records_overview.tpl");
}

?> 