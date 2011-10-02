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
 * @version 1.4 (2011-07-10)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

function ShowTopKB()
{
	global $USER, $PLANET, $LNG, $UNI, $db, $LANG;
	$mode = request_var('mode','');

	$PlanetRess = new ResourceUpdate();
	$PlanetRess->CalcResource();
	$PlanetRess->SavePlanetToDB();
	
	$top = $db->query("SELECT * FROM ".TOPKB." WHERE `universe` = '".$UNI."' ORDER BY units DESC LIMIT 100;");
	while($data = $db->fetch_array($top)) {
		$TopKBList[]	= array(
			'result'	=> $data['fleetresult'],
			'time'		=> tz_date($data['time']),
			'units'		=> pretty_number($data['gesamtunits']),
			'rid'		=> $data['rid'],
			'attacker'	=> $data['angreifer'],
			'defender'	=> $data['defender'],
			'result'	=> $data['fleetresult'],
		);
	}
	
	$db->free_result($top);

	$template	= new template();
	$template->assign_vars(array(	
		'tkb_units'		=> $LNG['tkb_units'],
		'tkb_datum'		=> $LNG['tkb_datum'],
		'tkb_owners'	=> $LNG['tkb_owners'],
		'tkb_platz'		=> $LNG['tkb_platz'],
		'tkb_top'		=> $LNG['tkb_top'],
		'tkb_gratz'		=> $LNG['tkb_gratz'],
		'tkb_legende'	=> $LNG['tkb_legende'],
		'tkb_gewinner'	=> $LNG['tkb_gewinner'],
		'tkb_verlierer'	=> $LNG['tkb_verlierer'],
		'TopKBList'		=> $TopKBList,
	));
	
	$template->show("topkb_overview.tpl");
}
?>