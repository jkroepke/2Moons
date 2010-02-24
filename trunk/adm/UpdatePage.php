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

if ($user['authlevel'] != 3) die();
	
	$Patchlevel	= explode(".",VERSION);
	$opts = array(
	  'http'=>array(
		'method'=> "GET",
		'header'=> "Patchlevel: ".(($_REQUEST['history'] == 1) ? 0 : $Patchlevel[2])."\r\n"
	  )
	);

	$context 		= stream_context_create($opts);
	$UpdateArray 	= unserialize(file_get_contents("http://update.jango-online.de/index.php?action=update",FALSE,$context));
	$func 			= function($value) { return str_replace("/trunk/", "", $value); };
	foreach($UpdateArray as $Rev => $RevInfo) 
	{
		$parse['planetes'] .= "<tr>
		".(($Patchlevel[2] == $Rev)?"<td class=c colspan=5>Momentane Version</td></tr><tr>":((($Patchlevel[2] - 1) == $Rev)?"<td class=c colspan=5>Alte Updates</td></tr><tr>":""))."
		<th>".(($Patchlevel[2] == $Rev)?"<font color=\"red\">":"")."Revision " . $Rev . " ".date("d. M y H:i:s", $RevInfo['timestamp'])." von ".$RevInfo['author'].(($Patchlevel[2] == $Rev)?"</font>":"")."</th></tr>
		".((!empty($RevInfo['add']))?"<tr><td class=b>ADD:<br>".implode("<br>\n", array_map($func, $RevInfo['add']))."</b></td></tr>":"")."
		".((!empty($RevInfo['edit']))?"<tr><td class=b>EDIT:<br>".implode("<br>\n", array_map($func, $RevInfo['edit']))."</b></td></tr>":"")."
		".((!empty($RevInfo['del']))?"<tr><td class=b>DEL:<br>".implode("<br>\n", array_map($func, $RevInfo['del']))."</b></td></tr>":"")."
		</tr>";
		$i++;
	}
	display(parsetemplate(gettemplate('adm/update_body'), $parse), false, '', true, false);

// Created by e-Zobar. All rights reversed (C) XNova Team 2008
?>