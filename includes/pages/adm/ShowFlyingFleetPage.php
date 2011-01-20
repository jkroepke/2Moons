<?php

##############################################################################
# *                                                                          #
# * 2MOONS                                                                   #
# *                                                                          #
# * @copyright Copyright (C) 2010 By ShadoX from titanspace.de               #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
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

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) exit;

require_once(ROOT_PATH. 'includes/classes/class.FlyingFleetsTable.php');

function ShowFlyingFleetPage()
{
	global $LNG, $db;
	
	$id	= request_var('id', 0);
	if(!empty($id)){
		$db->query("UPDATE ".FLEETS." SET `fleet_busy` = '".request_var('lock', 0)."' WHERE `fleet_id` = '".$id."' AND `fleet_universe` = '".$_SESSION['adminuni']."';;");
	} 

	$FlyingFleetsTable 	= new FlyingFleetsTable();
	$template			= new template();
	

	$template->assign_vars(array(
		'FleetList'			=> $FlyingFleetsTable->BuildFlyingFleetTable(),
		'ff_id'				=> $LNG['ff_id'],
		'ff_ammount'		=> $LNG['ff_ammount'],
		'ff_mission'		=> $LNG['ff_mission'],
		'ff_beginning'		=> $LNG['ff_beginning'],
		'ff_departure'		=> $LNG['ff_departure'],
		'ff_departure_hour'	=> $LNG['ff_departure_hour'],
		'ff_objective'		=> $LNG['ff_objective'],
		'ff_arrival'		=> $LNG['ff_arrival'],
		'ff_arrival_hour'	=> $LNG['ff_arrival_hour'],
		'ff_hold_position'	=> $LNG['ff_hold_position'],
		'ff_lock'			=> $LNG['ff_lock'],
		'ff_no_fleets'		=> $LNG['ff_no_fleets'],
	));
	$template->show('adm/FlyingFleetPage.tpl');
}
?>