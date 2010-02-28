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
include(ROOT_PATH . 'includes/classes/class.FlyingFleetsTable.' . PHP_EXT);
include('AdminFunctions/Autorization.' . PHP_EXT);

if ($Observation != 1) die();

$parse				= $lang;
$FlyingFleetsTable 	= new FlyingFleetsTable();
$parse['flt_table'] = $FlyingFleetsTable->BuildFlyingFleetTable();

display(parsetemplate(gettemplate('adm/fleet_body'), $parse), false, '', true, false);
?>