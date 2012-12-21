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
include_once(ROOT_PATH . 'common.php');
$Qry	= $db->query("SELECT b_tech, b_tech_id, id_owner FROM ".PLANETS." WHERE b_tech_id != '0';");

while($CUser = $db->fetch_array($Qry))
{
	$db->query("UPDATE ".USERS." SET `b_tech` = '".$CUser['b_tech']."', `b_tech_id` = '".$CUser['b_tech_id']."' WHERE `id` = '".$CUser['id_owner']."';");
}

$db->query("ALTER TABLE ".PLANETS." DROP `b_tech`, DROP `b_tech_id`;");