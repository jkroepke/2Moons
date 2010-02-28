<?php

##############################################################################
# *																			 #
# * RN FRAMEWORK															 #
# *  																		 #
# * @copyright Copyright (C) 2009 By ShadoX from xnova-reloaded.de	    	 #
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

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

define('ROOT_PATH', './../');
include(ROOT_PATH . 'extension.inc');
include(ROOT_PATH . 'common.' . PHP_EXT);
include('AdminFunctions/Autorization.' . PHP_EXT);

if ($Observation != 1) die();

	$parse	= $lang;
	$query 	= $db->query("SELECT * FROM ".PLANETS." WHERE `planet_type` = '3';");
	$i 		= 0;

	while ($u = $db->fetch_row($query))
	{
		$parse['moon'] .= "<tr>"
		. "<th>" . $u[0] . "</th>"
		. "<th>" . $u[1] . "</th>"
		. "<th>" . $u[2] . "</th>"
		. "<th>" . $u[4] . "</th>"
		. "<th>" . $u[5] . "</th>"
		. "<th>" . $u[6] . "</th>"
		. "</tr>";
		$i++;
	}

	if ($i == "1")
		$parse['moon'] .= "<tr><th class=b colspan=6>".$lang['mt_only_one_moon']."</th></tr>";
	else
		$parse['moon'] .= "<tr><th class=b colspan=6>". $lang['mt_there_are'] . $i . $lang['mt_moons'] ."</th></tr>";

	display(parsetemplate(gettemplate('adm/MoonListBody'), $parse), false, '', true, false);
?>