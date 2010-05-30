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
include(ROOT_PATH . 'common.'.PHP_EXT);


if ($CONFGame != 1) die(message ($LNG['404_page']));

$parse = $LNG;

if (!$_POST)
{
	$Tablas = $db->query("SHOW TABLES");
	while ($row = $db->fetch($Tablas))
	{
		foreach ($row as $opcion => $tabla)
		{
			$parse['tabla'] .= "<tr>";
			$parse['tabla'] .= "<th width=\"50%\">".$tabla."</th><th width=\"50%\"><font color=aqua>".$LNG['od_select_action']."</font></th>";
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
				$Message	=	$LNG['od_opt'];
				$Log	=	"\n".$LNG['log_database_title']."\n".$LNG['log_the_user'].$USER['username'].$LNG['log_database_view'].":\n".$LNG['log_data_optimize']."\n";}
				
			if ($_POST['Repair']){
				$db->query("REPAIR TABLE ".$tabla.";");
				$Message	=	$LNG['od_rep'];
				$Log	=	"\n".$LNG['log_database_title']."\n".$LNG['log_the_user'].$USER['username'].$LNG['log_database_view'].":\n".$LNG['log_data_repair']."\n";}
				
			if ($_POST['Check']){
				$db->query("CHECK TABLE ".$tabla.";");
				$Message	=	$LNG['od_check_ok'];
				$Log	=	"\n".$LNG['log_database_title']."\n".$LNG['log_the_user'].$USER['username'].$LNG['log_database_view'].":\n".$LNG['log_data_check']."\n";}
				
			if ($db->error)
			{
				$parse['tabla'] .= "<tr>";
				$parse['tabla'] .= "<th width=\"50%\">".$tabla."</th>";
				$parse['tabla'] .= "<th width=\"50%\" style=\"color:red\">".$LNG['od_not_opt']."</th>";
				$parse['tabla'] .= "</tr>";
			}
			else
			{
				$parse['tabla'] .= "<tr>";
				$parse['tabla'] .= "<th width=\"50%\">".$tabla."</th>";
				$parse['tabla'] .= "<th width=\"50%\" style=\"color:lime\">".$Message."</th>";
				$parse['tabla'] .= "</tr>";
			}
		}
	}
		
	LogFunction($Log, "GeneralLog", $LogCanWork);
}

display(parsetemplate(gettemplate('adm/DataBaseViewBody'), $parse), false, '', true, false);
?>