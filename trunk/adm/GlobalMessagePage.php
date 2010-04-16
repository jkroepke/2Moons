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


if ($ToolsCanUse != 1) die(message ($lang['404_page']));

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
		$Subject	= makebr(request_var('temat', '', true));
		$Message 	= makebr(request_var('tresc', '', true));
		if (!empty($Message) && !empty($Subject))
		{
			$Time    	= time();
			$From    	= "<font color=\"". $kolor ."\">". $ranga ." ".$user['username']."</font>";
			$Subject 	= "<font color=\"". $kolor ."\">".$Subject."</font>";
			$Message 	= "<font color=\"". $kolor ."\"><b>".$Message."</b></font>";
			$summery	= 0;

			SendSimpleMessage ( $u['id'], $user['id'], $Time, 50, $From, $Subject, $Message);
			
			
			$Log	.=	"\n".$lang['log_circular_message']."\n";
			$Log	.=	$lang['log_the_user'].$user['username'].$lang['log_message_specify'].":\n";
			$Log	.=	$lang['log_mes_subject'].": ".$_POST["temat"]."\n";
			$Log	.=	$lang['log_mes_text'].": ".$_POST["tresc"]."\n";
				
			LogFunction($Log, "GeneralLog", $LogCanWork);
		
			$parse['display']	=	"<tr><th colspan=5><font color=lime>".$lang['ma_message_sended']."</font></th></tr>";
		}
		else
		{
			$parse['display']	=	"<tr><th colspan=5><font color=red>".$lang['ma_subject_needed']."</font></th></tr>";
		}
	}
	
	
display(parsetemplate(gettemplate('adm/GlobalMessageBody'), $parse), false,'', true, false);
?>