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

		$db->multi_query("INSERT INTO ".MESSAGES." SET 
							  `message_owner` = '". $Owner ."', 
							  `message_sender` = '". $Sender ."', 
							  `message_time` = '" . $Time . "', 
							  `message_type` = '". $Type ."', 
							  `message_from` = '". $db->sql_escape($From) ."', 
							  `message_subject` = '". $db->sql_escape($Subject) ."', 
							  `message_text` = '". $db->sql_escape($Message) ."';
							  UPDATE `".USERS."` SET 
							  `new_message` = `new_message` + 1 ".(($Owner == 0) ? ";" : "WHERE  `id` = '". $Owner ."';"));
	}

?>