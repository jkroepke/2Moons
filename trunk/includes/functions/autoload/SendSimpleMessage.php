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

if(!defined('INSIDE')){ die(header("location:../../"));}

	function SendSimpleMessage($Owner, $Sender, $Time, $Type, $From, $Subject, $Message)
	{
		global $db;
		if (empty($Time))
			$Time = time();

		$QryInsertMessage  = "INSERT INTO ".MESSAGES." SET ";
		$QryInsertMessage .= "`message_owner` = '". $Owner ."', ";
		$QryInsertMessage .= "`message_sender` = '". $Sender ."', ";
		$QryInsertMessage .= "`message_time` = '" . $Time . "', ";
		$QryInsertMessage .= "`message_type` = '". $Type ."', ";
		$QryInsertMessage .= "`message_from` = '". $db->sql_escape($From) ."', ";
		$QryInsertMessage .= "`message_subject` = '". $db->sql_escape($Subject) ."', ";
		$QryInsertMessage .= "`message_text` = '". $db->sql_escape($Message) ."';";
		$QryInsertMessage .= "UPDATE `".USERS."` SET ";
		$QryInsertMessage .= "`new_message` = `new_message` + 1 ";
		if($Owner == 0)
			$QryInsertMessage .= ";";
		else
			$QryInsertMessage .= "WHERE  `id` = '". $Owner ."';";
		
		$db->multi_query($QryInsertMessage);
	}

?>