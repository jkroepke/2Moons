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

$parse['info'] 		= $_SERVER['SERVER_SOFTWARE'];
$parse['vPHP'] 		= PHP_VERSION;
$parse['vGame'] 	= VERSION;
$parse['vMySQLc'] 	= $db->getVersion();
$parse['vMySQLs'] 	= $db->getServerVersion();
$parse['root'] 		= $_SERVER["SERVER_NAME"];
$parse['gameroot'] 	= $_SERVER["SERVER_NAME"] . str_replace("/adm/GameInfos.php", "",$_SERVER["PHP_SELF"]);
$parse['json']		= function_exists('json_encode') ? "Ja" : "Nein";

display(parsetemplate(gettemplate('adm/InfoMessagesBody'), $parse), false, '', true, false);

?>