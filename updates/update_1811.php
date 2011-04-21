<?

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

define('INSIDE', true );
define('INSTALL', false );
define('LOGIN', true );
define('ROOT_PATH'	,'./');
include_once(ROOT_PATH . 'includes/common.php');
$Qry	= $db->query("SELECT id, b_tech_queue  FROM ".USERS.";");

while($CUser = $db->fetch_array($Qry))
{
	$NewQueue	= array();
	$Queue		= explode(';', $CUser['b_tech_queue ']);
	foreach($Queue as $QueueID) {
		$NewQueue[]	= explode(',', $QueueID);
	}
	$db->query("UPDATE ".USERS." SET `b_tech_queue` = '".(empty($NewQueue)?'':serialize($NewQueue))."' WHERE `id` = ".$CUser['id'].";");
}

$Qry	= $db->query("SELECT id, b_building_id, b_hangar_id FROM ".PLANETS.";");

while($CUser = $db->fetch_array($Qry))
{
	$NewHQueue	= array();
	$HQueue		= explode(';', $CUser['b_hangar_id']);
	foreach($HQueue as $QueueID) {
		$NewHQueue[]	= explode(',', $QueueID);
	}
	$NewBQueue	= array();
	$BQueue		= explode(';', $CUser['b_building_id']);
	foreach($BQueue as $QueueID) {
		$NewBQueue[]	= explode(',', $QueueID);
	}
	$db->query("UPDATE ".PLANETS." SET `b_building_id` = '".(empty($NewBQueue)?'':serialize($NewBQueue))."', `b_hangar_id` = '".(empty($NewHQueue)?'':serialize($NewHQueue))."' WHERE `id` = ".$CUser['id'].";");
}

?>