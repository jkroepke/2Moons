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

$QueryModerationEx	=	explode(";", $CONF['moderation']);
$Moderator			=	explode(",", $QueryModerationEx[0]);
$Operator			=	explode(",", $QueryModerationEx[1]);
$Administrator		=	explode(",", $QueryModerationEx[2]);

switch($USER['authlevel'])
{
	case AUTH_MOD:
		$USER['rights']['Observation']	= $Moderator[0];
		$USER['rights']['EditUsers']	= $Moderator[1];
		$USER['rights']['CONFGame']		= $Moderator[2];
		$USER['rights']['ToolsCanUse']	= $Moderator[3];
		$USER['rights']['LogCanWork']	= $Moderator[4];
	break;
	case AUTH_OPS:
		$USER['rights']['Observation']	= $Operator[0];
		$USER['rights']['EditUsers']	= $Operator[1];
		$USER['rights']['CONFGame']		= $Operator[2];
		$USER['rights']['ToolsCanUse']	= $Operator[3];
		$USER['rights']['LogCanWork']	= $Operator[4];
	break;
	case AUTH_ADM:
		$USER['rights']['Observation']	= 1;
		$USER['rights']['EditUsers']	= 1;
		$USER['rights']['CONFGame']		= 1;
		$USER['rights']['ToolsCanUse']	= 1;
		$USER['rights']['LogCanWork']	= $Administrator[0];
	break;
}
?>