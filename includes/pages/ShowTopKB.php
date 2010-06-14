<?php

##############################################################################
# *                                                                          #
# * 2MOONS                                                                   #
# *                                                                          #
# * @copyright Copyright (C) 2010 By ShadoX from titanspace.de               #
# *                                                                          #
# *	                                                                         #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.                                     #
# *	                                                                         #
# *  This program is distributed in the hope that it will be useful,         #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of          #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           #
# *  GNU General Public License for more details.                            #
# *                                                                          #
##############################################################################

if(!defined('INSIDE')) die('Hacking attempt!');

function ShowTopKB()
{
	global $USER, $PLANET, $LNG, $db;
	$mode = request_var('mode','');

	$template	= new template();
	
	switch($mode){
		case "showkb":
			$template->page_header();
			$template->page_footer();
			
			$ReportID 	= request_var('rid','');
			if(file_exists(ROOT_PATH.'raports/topkb_'.$RID.'.php')) {
				require_once(ROOT_PATH.'raports/topkb_'.$RID.'.php');
			} else {
				
				$RaportRAW 	= $db->uniquequery("SELECT * FROM ".TOPKB." WHERE `rid` = '".$db->sql_escape($ReportID)."';");

				$raport = stripslashes($raportrow["raport"]);
				foreach ($LNG['tech_rc'] as $id => $s_name)
				{
					$str_replace1  	= array("[ship[".$id."]]");
					$str_replace2  	= array($s_name);
					$raport 		= str_replace($str_replace1, $str_replace2, $report);
				}
			}
			
			foreach ($LNG['tech_rc'] as $id => $s_name)
			{
				$ship[]  		= "[ship[".$id."]]";
				$shipname[]  	= $s_name;
			}

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

			$template->page_header();
			$template->page_topnav();
			$template->page_leftmenu();
			$template->page_planetmenu();
			$template->page_footer();
			
			$top = $db->query("SELECT * FROM ".TOPKB." ORDER BY gesamtunits DESC LIMIT 100;");
			while($data = $db->fetch_array($top)) {
				$TopKBList[]	= array(
					'result'	=> $data['fleetresult'],
					'time'		=> date("D d M H:i:s", $data['time']),
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