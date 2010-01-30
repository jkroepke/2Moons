<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
# *																			 #
# *																			 #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.									 #
# *																			 #
# *  This program is distributed in the hope that it will be useful,		 #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of			 #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 #
# *  GNU General Public License for more details.							 #
# *																			 #
##############################################################################

if(!defined('INSIDE')){ die(header("location:../../"));}

function ShowRecordsPage($CurrentUser, $CurrentPlanet)
{
	global $lang, $resource, $db, $game_config;

	require_once($xgp_root."cache/CacheRecords.php");
	
	$PlanetRess = new ResourceUpdate($CurrentUser, $CurrentPlanet);

	$template	= new template();
	$template->page_header();
	$template->page_topnav();
	$template->page_leftmenu();
	$template->page_planetmenu();
	$template->page_header();
	$template->page_footer();
	
	foreach($RecordsArray as $ElementID => $ElementIDArray) {
		if ($ElementID >=   1 && $ElementID <=  39 || $ElementID == 44) {
			$Builds[$lang['tech'][$ElementID]]	= array(
				'winner'	=> ($ElementIDArray['maxlvl'] != 0) ? $ElementIDArray['username'] : $lang['rec_rien'],
				'count'		=> ($ElementIDArray['maxlvl'] != 0) ? pretty_number( $ElementIDArray['maxlvl'] ) : $lang['rec_rien'],
			);
		} elseif ($ElementID >=  41 && $ElementID <=  99 && $ElementID != 44) {
			$MoonsBuilds[$lang['tech'][$ElementID]]	= array(
				'winner'	=> ($ElementIDArray['maxlvl'] != 0) ? $ElementIDArray['username'] : $lang['rec_rien'],
				'count'		=> ($ElementIDArray['maxlvl'] != 0) ? pretty_number( $ElementIDArray['maxlvl'] ) : $lang['rec_rien'],
			);
		} elseif ($ElementID >= 101 && $ElementID <= 199) {
			$Techno[$lang['tech'][$ElementID]]	= array(
				'winner'	=> ($ElementIDArray['maxlvl'] != 0) ? $ElementIDArray['username'] : $lang['rec_rien'],
				'count'		=> ($ElementIDArray['maxlvl'] != 0) ? pretty_number( $ElementIDArray['maxlvl'] ) : $lang['rec_rien'],
			);
		} elseif ($ElementID >= 201 && $ElementID <= 399) {
			$Fleet[$lang['tech'][$ElementID]]	= array(
				'winner'	=> ($ElementIDArray['maxlvl'] != 0) ? $ElementIDArray['username'] : $lang['rec_rien'],
				'count'		=> ($ElementIDArray['maxlvl'] != 0) ? pretty_number( $ElementIDArray['maxlvl'] ) : $lang['rec_rien'],
			);
		} elseif ($ElementID >= 401 && $ElementID <= 599) {
			$Defense[$lang['tech'][$ElementID]]	= array(
				'winner'	=> ($ElementIDArray['maxlvl'] != 0) ? $ElementIDArray['username'] : $lang['rec_rien'],
				'count'		=> ($ElementIDArray['maxlvl'] != 0) ? pretty_number( $ElementIDArray['maxlvl'] ) : $lang['rec_rien'],
			);
		}
	}
	
	$Records	= array(
		$lang['rec_build']	=> $Builds,
		$lang['rec_specb']	=> $MoonsBuilds,
		$lang['rec_techn']	=> $Techno,
		$lang['rec_fleet']	=> $Fleet,
		$lang['rec_defes']	=> $Defense,
	);
	
	$template->assign_vars(array(	
		'Records'	 	=> $Records,
		'update'		=> sprintf($lang['rec_last_update_on'],date("d. M Y, H:i:s",$game_config['stat_last_update'])),
		'level'			=> $lang['rec_level'],
		'player'		=> $lang['rec_playe'],
	));
	
	$template->show("records_overview.tpl");
	$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
}

?> 