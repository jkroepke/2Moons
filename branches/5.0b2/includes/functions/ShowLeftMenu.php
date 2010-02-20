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

function ShowLeftMenu ($Level)
{
	global $game_config, $dpath, $user, $lang, $db;

	$parse					= $lang;
	$parse['dpath']			= $dpath;
	$parse['version']   	= VERSION;
	$parse['servername']	= $game_config['game_name'];
	$parse['lm_tx_serv']	= $game_config['resource_multiplier'];
	$parse['lm_tx_game']    = $game_config['game_speed'] / 2500;
	$parse['lm_tx_fleet']   = $game_config['fleet_speed'] / 2500;
	$parse['lm_tx_queue']   = MAX_FLEET_OR_DEFS_PER_ROW;
	$parse['forum_url']     = $game_config['forum_url'];
	$parse['servername']   	= $game_config['game_name'];
	$rank                   = $db->fetch_array($db->query("SELECT `total_rank` FROM ".STATPOINTS." WHERE `stat_code` = '1' AND `stat_type` = '1' AND `id_owner` = '". $user['id'] ."';"));
	$parse['user_rank']     = $rank['total_rank'];

	if ($Level > 0)
		$parse['admin_link']	="<tr><td><div align=\"center\"><a href=\"javascript:top.location.href='adm/index.php'\"> <font color=\"lime\">" . $lang['lm_administration'] . "</font></a></div></td></tr>";
	else
		$parse['admin_link']  	= "";




	return parsetemplate(gettemplate('global/left_menu'), $parse);
}
?>