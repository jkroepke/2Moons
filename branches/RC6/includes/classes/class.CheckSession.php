<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
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

class CheckSession
{
	function CheckUser()
	{
		global $CONF, $db;

		if(empty($_SESSION['id']))
			return false;
		
		$SelectPlanet  = request_var('cp',0);
		if(!empty($SelectPlanet))
			$IsPlanetMine =	$db->uniquequery("SELECT `id` FROM ".PLANETS." WHERE `id` = '". $SelectPlanet ."' AND `id_owner` = '".$_SESSION['id']."';");
		
		
		$_SESSION['oldpath']	= $_SESSION['path'];
		$_SESSION['path']		= basename($_SERVER['SCRIPT_NAME']).(!empty($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : '');
		
		$Qry  = "UPDATE ".USERS." SET ";
		$Qry .= "`onlinetime` = '".TIMESTAMP."', ";
		$Qry .= "`current_page` = '".$db->sql_escape($_SESSION['path']) ."', ";
		$Qry .= "`user_lastip` = '".$_SERVER['REMOTE_ADDR'] ."', ";
		
		if(isset($IsPlanetMine))
			$Qry .= "`current_planet` = '".$IsPlanetMine['id']."', ";
			
		$Qry .= "`user_agent` = '".$db->sql_escape($_SERVER['HTTP_USER_AGENT'])."' ";
		$Qry .= "WHERE ";
		$Qry .= "`id` = '".$_SESSION['id']."' LIMIT 1;";
		$db->query($Qry);

		return true;
	}
}
?>