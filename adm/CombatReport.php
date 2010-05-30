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

define('INSIDE'  , true);
define('INSTALL' , false);

define('ROOT_PATH', './../');
include(ROOT_PATH . 'extension.inc');
include(ROOT_PATH . 'common.'.PHP_EXT);

includeLang('INGAME');

$raportrow 	= $db->fetch_array($db->query("SELECT * FROM ".RW." WHERE `rid` = '".($db->sql_escape($_GET["raport"]))."';"));
if (($raportrow["owners"] == $USER["id"]) && ($raportrow["a_zestrzelona"] == 1))
{
	$Page .= "<td>".$LNG['cr_lost_contact']."<br>";
	$Page .= $LNG['cr_first_round']."</td>";
}
else
{
	$report = stripslashes($raportrow["raport"]);
	foreach ($LNG['tech_rc'] as $id => $s_name)
	{
		$str_replace1  	= array("[ship[".$id."]]");
		$str_replace2  	= array($s_name);
		$report 		= str_replace($str_replace1, $str_replace2, $report);
	}
	$no_fleet 		= "<table border=1 align=\"center\"><tr><th>".$LNG['cr_type']."</th></tr><tr><th>".$LNG['cr_total']."</th></tr><tr><th>".$LNG['cr_weapons']."</th></tr><tr><th>".$LNG['cr_shields']."</th></tr><tr><th>".$LNG['cr_armor']."</th></tr></table>";
	$destroyed 		= "<table border=1 align=\"center\"><tr><th><font color=\"red\"><strong>".$LNG['cr_destroyed']."</strong></font></th></tr></table>";
	$str_replace1  	= array($no_fleet);
	$str_replace2  	= array($destroyed);
	$report 		= str_replace($str_replace1, $str_replace2, $report);
	$Page 		   .= $report;
}

display($Page, false, '', false, false);
?>