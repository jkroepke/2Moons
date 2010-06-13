<?php

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

define('INSIDE'  , true);
define('INSTALL' , false);

define('ROOT_PATH', './');
include(ROOT_PATH . 'extension.inc');
include(ROOT_PATH . 'common.'.PHP_EXT);

includeLang('TECH');	
includeLang('FLEET');	
	
$RID	= request_var('raport', '');

if(file_exists(ROOT_PATH.'raports/raport_'.$RID.'.php')) {
	require_once(ROOT_PATH.'raports/raport_'.$RID.'.php');
} else {
	
	$raportrow 	= $db->uniquequery("SELECT * FROM ".RW." WHERE `rid` = '".$db->sql_escape($RID)."';");

	$raport = stripslashes($raportrow["raport"]);
	foreach ($LNG['tech_rc'] as $id => $s_name)
	{
		$str_replace1  	= array("[ship[".$id."]]");
		$str_replace2  	= array($s_name);
		$raport 		= str_replace($str_replace1, $str_replace2, $report);
	}
}

$template	= new template();

$template->page_header();
$template->page_footer();

$template->assign('raport', $raport);
$template->show('raport.tpl');

?>