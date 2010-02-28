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

if ($ConfigGame != 1) die();

if($_GET['mode']) {

	$db->query("UPDATE ".MODULE." SET estado = '".(($_GET['mode'] == "aktiv") ? 1 : 0 )."' WHERE id = '".$db->sql_escape($_GET['id'])."';");
}

$consulta = $db->query("SELECT id,modulo,estado FROM ".MODULE." ORDER BY modulo ASC");
while ($resultado = $db->fetch_array($consulta)) { 
    if($resultado['estado'] == "1") {
		$parse['modulos'] .= "<tr>";
		$parse['modulos'] .= "<th>".$resultado['modulo']."</th>";
		$parse['modulos'] .= "<th class=\"c\" style=\"color:green\"><b>AKTIV</b></th>";
		$parse['modulos'] .= "<th class=\"c\" width=\"20px\"><a href=\"?mode=deaktiv&amp;id=".$resultado['id']."\">Deaktivieren</a></th>";
		$parse['modulos'] .= "</tr>";
    } else {
		$parse['modulos'] .= "<tr>";
		$parse['modulos'] .= "<th>".$resultado['modulo']."</th>";
		$parse['modulos'] .= "<th class=\"c\" style=\"color:red\"><b>NICHT AKTIV</b></th>";
		$parse['modulos'] .= "<th class=\"c\" width=\"20px\"><a href=\"?mode=aktiv&amp;id=".$resultado['id']."\">Aktivieren</a></th>";
		$parse['modulos'] .= "</tr>";
    }
}

display(parsetemplate(gettemplate('adm/GameModule'), $parse), false, '' , true, false);
?> 