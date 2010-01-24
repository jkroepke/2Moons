<?php
##############################################################################
# *                    #
# * XG PROYECT                 #
# *                     #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar  #
# *                    #
# *                    #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.          #
# *                    #
# *  This program is distributed in the hope that it will be useful,   #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of    #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the    #
# *  GNU General Public License for more details.        #
# *                    #
##############################################################################

if(!defined('INSIDE')){ die(header("location:../../"));}

function ShowTopKB($CurrentUser, $CurrentPlanet)
{
	global $lang, $db;
	$mode = request_var('mode','');

	$template	= new template();
	
	switch($mode){
		case "showkb":
			$template->page_header();
			$template->page_footer();
			
			$ReportID 	= request_var('rid','');
			$RaportRAW 	= $db->fetch_array($db->query("SELECT * FROM ".TOPKB." WHERE `rid` = '".$db->sql_escape($ReportID)."';"));
			
			foreach ($lang['tech_rc'] as $id => $s_name)
			{
				$ship[]  		= "[ship[".$id."]]";
				$shipname[]  	= $s_name;
			}

			$template->assign_vars(array(
				'attacker'	=> $RaportRAW['angreifer'],
				'defender'	=> $RaportRAW['defender'],
				'report'	=> stripslashes(str_replace($ship, $shipname, $RaportRAW["raport"])),
			));
			
			$template->display("topkb_report.tpl");
		break;
		default:
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
			
			$template->assign_vars(array(	
				'tkb_units'		=> $lang['tkb_units'],
				'tkb_datum'		=> $lang['tkb_datum'],
				'tkb_owners'	=> $lang['tkb_owners'],
				'tkb_platz'		=> $lang['tkb_platz'],
				'tkb_top'		=> $lang['tkb_top'],
				'tkb_gratz'		=> $lang['tkb_gratz'],
				'tkb_legende'	=> $lang['tkb_legende'],
				'tkb_gewinner'	=> $lang['tkb_gewinner'],
				'tkb_verlierer'	=> $lang['tkb_verlierer'],
				'TopKBList'		=> $TopKBList,
			));
			
			$template->display("topkb_overview.tpl");
		break;
	}
}
?>