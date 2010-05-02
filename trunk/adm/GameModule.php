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
define('IN_ADMIN', true);

define('ROOT_PATH', './../');
include(ROOT_PATH . 'extension.inc');
include(ROOT_PATH . 'common.' . PHP_EXT);


if ($ConfigGame != 1) die();

if($_GET['mode']) {
	$game_config['moduls'][request_var('id', 0)]	= ($_GET['mode'] == 'aktiv') ? 1 : 0;
	update_config('moduls', implode(";", $game_config['moduls']));
}

foreach($lang['modul'] as $ID => $Name) { 
	if($game_config['moduls'][$ID] == 1) {
		$parse['modulos'] .= "<tr>";
		$parse['modulos'] .= "<th>".$Name."</th>";
		$parse['modulos'] .= "<th style=\"color:green\"><b>".$lang['ative']."</b></th>";
		$parse['modulos'] .= "<th><a href=\"?mode=deaktiv&amp;id=".$ID."\">Deaktivieren</a></th>";
		$parse['modulos'] .= "</tr>";
    } else {
		$parse['modulos'] .= "<tr>";
		$parse['modulos'] .= "<th>".$Name."</th>";
		$parse['modulos'] .= "<th style=\"color:red\"><b>".$lang['deative']."</b></th>";
		$parse['modulos'] .= "<th><a href=\"?mode=aktiv&amp;id=".$ID."\">Aktivieren</a></th>";
		$parse['modulos'] .= "</tr>";
    }
}

display(parsetemplate(gettemplate('adm/GameModule'), $parse), false, '' , true, false);
?> 