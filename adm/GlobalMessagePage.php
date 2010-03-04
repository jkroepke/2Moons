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
include('AdminFunctions/Autorization.' . PHP_EXT);

if ($ToolsCanUse != 1) die();

	$parse 	= $lang;

	if ($_POST && $_GET['mode'] == "change")
	{
		if ($user['authlevel'] == 3)
		{
			$kolor = 'red';
			$ranga = $lang['user_level'][3];
		}

		elseif ($user['authlevel'] == 2)
		{
			$kolor = 'skyblue';
			$ranga = $lang['user_level'][2];
		}

		elseif ($user['authlevel'] == 1)
		{
			$kolor = 'yellow';
			$ranga = $lang['user_level'][1];
		}
		if ((isset($_POST["tresc"]) && $_POST["tresc"] != '') && (isset($_POST["temat"]) && $_POST["temat"] != ''))
		{
			$sq      	= $db->query("SELECT `id`,`username` FROM ".USERS.";");
			$Time    	= time();
			$From    	= "<font color=\"". $kolor ."\">". $ranga ." ".$user['username']."</font>";
			$Subject 	= "<font color=\"". $kolor ."\">".$_POST['temat']."</font>";
			$Message 	= "<font color=\"". $kolor ."\"><b>".makebr($_POST['tresc'])."</b></font>";
			$summery	= 0;

			
			SendSimpleMessage(0, $user['id'], $Time, 50, $From, $Subject, $Message);
			$db->query("UPDATE `".USERS."` SET `new_message` = `new_message` + 1;");
			message($lang['ma_message_sended'], "GlobalMessagePage.".PHP_EXT, 3);
		}
		else
		{
			message($lang['ma_subject_needed'], "GlobalMessagePage.".PHP_EXT, 3);
		}
	}
	else
		display(parsetemplate(gettemplate('adm/GlobalMessageBody'), $parse), false,'', true, false);
?>