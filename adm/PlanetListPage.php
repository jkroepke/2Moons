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

$xgp_root = './../';
include($xgp_root . 'extension.inc.php');
include($xgp_root . 'common.' . $phpEx);
include('AdminFunctions/Autorization.' . $phpEx);

if ($EditUsers != 1) die();

	$parse = $lang;
	$query = $db->query("SELECT `id`, `id_owner`, `name`,  `field_current`, `field_max`, `galaxy`, `system`, `planet` FROM ".PLANETS." WHERE planet_type=1 ORDER BY id ASC");
	$i = 0;
	while ($u = $db->fetch_array($query)) {
		$parse['planetes'] .= "<tr>"
		. "<td class=b><center><b><a href='?action=edit&id=".$u['id'] ."'>" . $u['id'] . "</a></center></b></td>"
		. "<td class=b><center><b><a href='?action=edit&id=".$u['id'] ."'>" . $u['id_owner'] . "</a></center></b></td>"
		. "<td class=b><center><b><a href='?action=edit&id=".$u['id'] ."'>" . $u['name'] . "</a></center></b></td>"
		. "<td class=b><center><b><a href='?action=edit&id=".$u['id'] ."'>" . $u['field_max'] . "</a></center></b></td>"
		. "<td class=b><center><b><a href='?action=edit&id=".$u['id'] ."'>" . $u['field_current'] . "</a></center></b></td>"
		. "<td class=b><center><b><a href='?action=edit&id=".$u['id'] ."'>" . $u['galaxy'] . "</a></center></b></td>"
		. "<td class=b><center><b><a href='?action=edit&id=".$u['id'] ."'>" . $u['system'] . "</a></center></b></td>"
		. "<td class=b><center><b><a href='?action=edit&id=".$u['id'] ."'>" . $u['planet'] . "</a></center></b></td>"
		. "</tr>";
		$i++;
	}

	if ($i == "1")
	$parse['planetes'] .= "<tr><th class=b colspan=8>Insgesamt 1 Planet</th></tr>";
	else
	$parse['planetes'] .= "<tr><th class=b colspan=8>Insgesamt {$i} Planeten</th></tr>";

	display(parsetemplate(gettemplate('adm/PlanetListBody'), $parse), false, '', true, false);

// Created by e-Zobar. All rights reversed (C) XNova Team 2008
?>