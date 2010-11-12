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

if ($USER['authlevel'] != AUTH_ADM || $_GET['sid'] != session_id()) exit;

function ShowUniversePage() {
	global $CONF, $LNG, $db, $UNI;
	$template	= new template();
	$template->page_header();
	if($_REQUEST['action'] == 'delete' && !empty($_REQUEST['id']) && $_REQUEST['id'] != 1) {
		$ID	= (int) $_REqUEST['id'];
		$db->multi_query("DELETE FROM ".AKS." WHERE `universe` = ".$ID.";
		DELETE FROM ".ALLICANCE." WHERE `ally_universe` = ".$ID.";
		DELETE FROM ".BANNED." WHERE `universe` = ".$ID.";
		DELETE FROM ".CHAT." WHERE `universe` = ".$ID.";
		DELETE FROM ".CONFIG." WHERE `uni` = ".$ID.";
		DELETE FROM ".FLEETS." WHERE `fleet_universe` = ".$ID.";
		DELETE FROM ".PLANETS." WHERE `universe` = ".$ID.";
		DELETE FROM ".STATPOINTS." WHERE `universe` = ".$ID.";
		DELETE FROM ".TOPKB." WHERE `universe` = ".$ID.";
		DELETE FROM ".USERS." WHERE `universe` = ".$ID.";
		DELETE FROM ".USERS_VALLD." WHERE `universe` = ".$ID.";");
		
		if($_SESSION['adminuni'] == $ID)
			$_SESSION['adminuni']	= $ID;
	}elseif($_REQUEST['action'] == 'create') {
		$ID	= (int) $_REqUEST['id'];
		$db->multi_query("DELETE FROM ".AKS." WHERE `universe` = ".$ID.";
		DELETE FROM ".ALLICANCE." WHERE `ally_universe` = ".$ID.";
		DELETE FROM ".BANNED." WHERE `universe` = ".$ID.";
		DELETE FROM ".CHAT." WHERE `universe` = ".$ID.";
		DELETE FROM ".CONFIG." WHERE `uni` = ".$ID.";
		DELETE FROM ".FLEETS." WHERE `fleet_universe` = ".$ID.";
		DELETE FROM ".PLANETS." WHERE `universe` = ".$ID.";
		DELETE FROM ".STATPOINTS." WHERE `universe` = ".$ID.";
		DELETE FROM ".TOPKB." WHERE `universe` = ".$ID.";
		DELETE FROM ".USERS." WHERE `universe` = ".$ID.";
		DELETE FROM ".USERS_VALLD." WHERE `universe` = ".$ID.";");
		
		if($_SESSION['adminuni'] == $ID)
			$_SESSION['adminuni']	= $ID;
	}
	$Unis				= array();
	$Unis[$CONF['uni']]	= $CONF;
	$Query	= $db->query("SELECT * FROM ".CONFIG." WHERE `uni` != '".$UNI."';");
	while($Uni	= $db->fetch_array($Query)) {
		$Unis[$Uni['uni']]	= $Uni;
	}
	$template->assign_vars(array(	
		'button_submit'			=> $LNG['button_submit'],
		'Unis'					=> $Unis,
		'SID'					=> session_id(),
	));
	
	$template->show('adm/UniversePage.tpl');
}

?>