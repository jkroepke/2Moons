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


function ShowPhalanxPage()
{
	global $USER, $PLANET, $LNG, $db;

	include_once(ROOT_PATH.'includes/functions/InsertJavaScriptChronoApplet.' . PHP_EXT);
	include_once(ROOT_PATH.'includes/classes/class.FlyingFleetsTable.' . PHP_EXT);
	include_once(ROOT_PATH.'includes/classes/class.GalaxyRows.' . PHP_EXT);

	$FlyingFleetsTable 	= new FlyingFleetsTable();
	$GalaxyRows 		= new GalaxyRows();

	$template			= new template();
	$template->page_header();
	$template->page_footer();	
	
	$PhRange 		 	= $GalaxyRows->GetPhalanxRange($PLANET['phalanx']);
	$Galaxy 			= request_var('galaxy', 0);
	$System 			= request_var('system', 0);
	$Planet  			= request_var('planet', 0);
	
	if($Galaxy != $PLANET['galaxy'] || $System > ($PLANET['system'] + $PhRange) || $System < max(1, $PLANET['system'] - $PhRange))
	{
		$template->message($LNG['px_out_of_range'], false, 0, true);
		exit;	
	}
	
	if ($PLANET['deuterium'] < 5000)
	{
		$template->message($LNG['px_no_deuterium'], false, 0, true);
		exit;
	}

	$PLANET['deuterium'] -= 5000;
	$db->query("UPDATE ".PLANETS." SET `deuterium` = `deuterium` - '5000' WHERE `id` = '".$PLANET['id']."';");
	$TargetInfo = $db->uniquequery("SELECT name, id_owner FROM ".PLANETS." WHERE `galaxy` = '".$Galaxy."' AND `system` = '".$System."' AND `planet` = '".$Planet."' AND `planet_type` = '1';");

	$SQL  = "SELECT * FROM ".FLEETS." ";
	$SQL .= "WHERE ( ";
	$SQL .= "`fleet_start_galaxy` = '". $Galaxy ."' AND ";
	$SQL .= "`fleet_start_system` = '". $System ."' AND ";
	$SQL .= "`fleet_start_planet` = '". $Planet ."' AND ";
	$SQL .= "`fleet_start_type` = '1' ";
	$SQL .= ") OR ( ";
	$SQL .= "`fleet_end_galaxy` = '". $Galaxy ."' AND ";
	$SQL .= "`fleet_end_system` = '". $System ."' AND ";
	$SQL .= "`fleet_end_planet` = '". $Planet ."' AND ";
	$SQL .= "`fleet_end_type` = '1' ";
	$SQL .= ") ORDER BY `fleet_start_time`;";

	$FleetToTarget  = $db->query($SQL);
		
	while ($FleetRow = $db->fetch_array($FleetToTarget))
	{
		$Record++;
	
		$IsOwner	= ($FleetRow['fleet_owner'] == $TargetInfo['id_owner']) ? true : false;

		$FleetRow['fleet_resource_metal']     	= 0;
		$FleetRow['fleet_resource_crystal']   	= 0;
		$FleetRow['fleet_resource_deuterium'] 	= 0;
		$FleetRow['fleet_resource_darkmatter'] 	= 0;

		if ($FleetRow['fleet_mess'] == 0 && $FleetRow['fleet_start_time'] > TIMESTAMP)
			$fpage[$FleetRow['fleet_start_time'].$FleetRow['fleet_id']]	= $FlyingFleetsTable->BuildFleetEventTable($FleetRow, 0, $IsOwner, 'fs', $Record);

		if ($FleetRow['fleet_mission'] == 4)
			continue;
			
		if ($FleetRow['fleet_mess'] != 1 && $FleetRow['fleet_end_stay'] > TIMESTAMP)
			$fpage[$FleetRow['fleet_end_stay'].$FleetRow['fleet_id']]	= $FlyingFleetsTable->BuildFleetEventTable($FleetRow, 2, $IsOwner, 'ft', $Record);

		if ($IsOwner == false)
			continue;
		
		if ($FleetRow['fleet_end_time'] > TIMESTAMP)
			$fpage[$FleetRow['fleet_end_time'].$FleetRow['fleet_id']]	= $FlyingFleetsTable->BuildFleetEventTable($FleetRow, 1, $IsOwner, 'fe', $Record);
	}
	
	$db->free_result($FleetToTarget);
	
	if(isset($fpage))
		ksort($fpage);

	$template->assign_vars(array(
		'phl_pl_galaxy'  	=> $Galaxy,
		'phl_pl_system'  	=> $System,
		'phl_pl_place'   	=> $Planet,
		'phl_pl_name'    	=> $TargetInfo['name'],
		'fleets'		 	=> $fpage,
		'px_scan_position'	=> $LNG['px_scan_position'],
		'px_no_fleet'		=> $LNG['px_no_fleet'],
		'px_fleet_movement'	=> $LNG['px_fleet_movement'],
	));
	
	$template->show('phalax_body.tpl');			
}
?>