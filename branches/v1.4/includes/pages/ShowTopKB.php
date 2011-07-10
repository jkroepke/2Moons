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
 * @version 1.3.5 (2011-04-22)
 * @info $Id$
 * @link http://code.google.com/p/2moons/
 */

function ShowTopKB()
{
	global $USER, $PLANET, $LNG, $UNI, $db, $LANG;
	$mode = request_var('mode','');

	$template	= new template();
	
	switch($mode){
		case "showkb":
			$template->isPopup(true);

			$LANG->includeLang(array('FLEET'));
			
			$ReportID 	= request_var('rid','');
			if(file_exists(ROOT_PATH.'raports/topkb_'.$ReportID.'.php')) {
				require_once(ROOT_PATH.'raports/topkb_'.$ReportID.'.php');
				$RaportRAW 	= $db->uniquequery("SELECT `angreifer`, `defender` FROM ".TOPKB." WHERE `rid` = '".$db->sql_escape($ReportID)."';");
			}
			
			foreach ($LNG['tech_rc'] as $id => $s_name)
			{
				$ship[]  		= "[ship[".$id."]]";
				$shipname[]  	= $s_name;
			}
			
			$raport			= preg_replace("/\[\d+\:\d+\:\d+\]/i", "[X:X:X]", $raport);
	
			$template->assign_vars(array(
				'attacker'	=> $RaportRAW['angreifer'],
				'defender'	=> $RaportRAW['defender'],
				'report'	=> $raport,
			));
			
			$template->show("topkb_report.tpl");
		break;
		default:
			$PlanetRess = new ResourceUpdate();
			$PlanetRess->CalcResource();
			$PlanetRess->SavePlanetToDB();
			
			$top = $db->query("SELECT * FROM ".TOPKB." WHERE `universe` = '".$UNI."' ORDER BY gesamtunits DESC LIMIT 100;");
			while($data = $db->fetch_array($top)) {
				$TopKBList[]	= array(
					'result'	=> $data['fleetresult'],
					'time'		=> date(TDFORMAT, $data['time']),
					'units'		=> pretty_number($data['gesamtunits']),
					'rid'		=> $data['rid'],
					'attacker'	=> $data['angreifer'],
					'defender'	=> $data['defender'],
					'result'	=> $data['fleetresult'],
				);
			}
			
			$db->free_result($top);
			
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
		break;
	}
}
?>