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

require(ROOT_PATH.'includes/classes/class.Records.php');	

function ShowRecordsPage()
{
	global $USER, $PLANET, $LNG, $resource, $db, $CONF, $UNI;
		
	$PlanetRess = new ResourceUpdate();
	$PlanetRess->CalcResource();
	$PlanetRess->SavePlanetToDB();

	$template	= new template();
	$template->page_header();
	$template->page_topnav();
	$template->page_leftmenu();
	$template->page_planetmenu();
	$template->page_footer();
	
	$Records		= new records();
	$RecordsArray	= $Records->GetRecords($UNI);
	
	foreach($RecordsArray as $ElementID => $ElementIDArray) {
		if ($ElementID >=   1 && $ElementID <=  39 || $ElementID == 44) {
			$Builds[$LNG['tech'][$ElementID]]	= array(
				'winner'	=> ($ElementIDArray['maxlvl'] != 0) ? $ElementIDArray['username'] : $LNG['rec_rien'],
				'count'		=> ($ElementIDArray['maxlvl'] != 0) ? pretty_number( $ElementIDArray['maxlvl'] ) : $LNG['rec_rien'],
			);
		} elseif ($ElementID >=  41 && $ElementID <= 99 && $ElementID != 44) {
			$MoonsBuilds[$LNG['tech'][$ElementID]]	= array(
				'winner'	=> ($ElementIDArray['maxlvl'] != 0) ? $ElementIDArray['username'] : $LNG['rec_rien'],
				'count'		=> ($ElementIDArray['maxlvl'] != 0) ? pretty_number( $ElementIDArray['maxlvl'] ) : $LNG['rec_rien'],
			);
		} elseif ($ElementID >= 101 && $ElementID <= 199) {
			$Techno[$LNG['tech'][$ElementID]]	= array(
				'winner'	=> ($ElementIDArray['maxlvl'] != 0) ? $ElementIDArray['username'] : $LNG['rec_rien'],
				'count'		=> ($ElementIDArray['maxlvl'] != 0) ? pretty_number( $ElementIDArray['maxlvl'] ) : $LNG['rec_rien'],
			);
		} elseif ($ElementID >= 201 && $ElementID <= 399) {
			$Fleet[$LNG['tech'][$ElementID]]	= array(
				'winner'	=> ($ElementIDArray['maxlvl'] != 0) ? $ElementIDArray['username'] : $LNG['rec_rien'],
				'count'		=> ($ElementIDArray['maxlvl'] != 0) ? pretty_number( $ElementIDArray['maxlvl'] ) : $LNG['rec_rien'],
			);
		} elseif ($ElementID >= 401 && $ElementID <= 599) {
			$Defense[$LNG['tech'][$ElementID]]	= array(
				'winner'	=> ($ElementIDArray['maxlvl'] != 0) ? $ElementIDArray['username'] : $LNG['rec_rien'],
				'count'		=> ($ElementIDArray['maxlvl'] != 0) ? pretty_number( $ElementIDArray['maxlvl'] ) : $LNG['rec_rien'],
			);
		}
	}
	
	$Records	= array(
		$LNG['rec_build']	=> $Builds,
		$LNG['rec_specb']	=> $MoonsBuilds,
		$LNG['rec_techn']	=> $Techno,
		$LNG['rec_fleet']	=> $Fleet,
		$LNG['rec_defes']	=> $Defense,
	);
	
	$template->assign_vars(array(	
		'Records'	 	=> $Records,
		'update'		=> sprintf($LNG['rec_last_update_on'],date("d. M Y, H:i:s",$CONF['stat_last_update'])),
		'level'			=> $LNG['rec_level'],
		'player'		=> $LNG['rec_playe'],
	));
	
	$template->show("records_overview.tpl");
}

?> 