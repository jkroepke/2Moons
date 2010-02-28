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

ROOT_PATH = '../';
include(ROOT_PATH . 'extension.inc');
include(ROOT_PATH . 'common.' . PHP_EXT);
include('AdminFunctions/Autorization.' . PHP_EXT);

if ($ConfigGame != 1) die();

$parse = $lang;

if (!$_POST)
{
	$Tablas = $db->query("SHOW TABLES");
	while ($row = $db->fetch($Tablas))
	{
		foreach ($row as $opcion => $tabla)
		{
			$parse['tabla'] .= "<tr>";
			$parse['tabla'] .= "<th width=\"50%\">".$tabla."</th><th width=\"50%\"><font color=aqua>".$lang['od_select_action']."</font></th>";
			$parse['tabla'] .= "</tr>";
		}
	}
}
else
{
	$Tablas = $db->query("SHOW TABLES");
	while ($row = $db->fetch($Tablas))
	{
		foreach ($row as $opcion => $tabla)
		{
			if ($_POST['Optimize']){
				$db->query("OPTIMIZE TABLE ".$tabla.";");
				$Message	=	$lang['od_opt'];}
				
			if ($_POST['Repair']){
				$db->query("REPAIR TABLE ".$tabla.";");
				$Message	=	$lang['od_rep'];}
				
			if ($_POST['Check']){
				$db->query("CHECK TABLE ".$tabla.";");
				$Message	=	$lang['od_check_ok'];}
				
			$parse['tabla'] .= "<tr>";
			$parse['tabla'] .= "<th width=\"50%\">".$tabla."</th>";
			$parse['tabla'] .= "<th width=\"50%\" style=\"color:lime\">".$Message."</th>";
			$parse['tabla'] .= "</tr>";
		}
	}
}

display(parsetemplate(gettemplate('adm/DataBaseViewBody'), $parse), false, '', true, false);
?>