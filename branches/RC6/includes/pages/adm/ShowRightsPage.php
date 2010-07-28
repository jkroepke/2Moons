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

if ($USER['authlevel'] < AUTH_ADM || $_GET['sid'] != session_id()) exit;

function ShowRightsPage()
{
	global $LNG, $CONF, $db;
	$mode	= request_var('mode', '');
	switch($mode)
	{
		case 'rights':
			if ($_POST) 
			{
				$view_m 	= ($_POST['view_m'] == 'on') ? 1 : 0;
				$edit_m 	= ($_POST['edit_m'] == 'on') ? 1 : 0;
				$CONF_m 	= ($_POST['config_m'] == 'on') ? 1 : 0;
				$tools_m 	= ($_POST['tools_m'] == 'on') ? 1 : 0;
				$log_m		= ($_POST['log_m'] == 'on') ? 1 : 0;
				
				$view_o 	= ($_POST['view_o'] == 'on') ? 1 : 0;
				$edit_o 	= ($_POST['edit_o'] == 'on') ? 1 : 0;
				$CONF_o 	= ($_POST['config_o'] == 'on') ? 1 : 0;
				$tools_o	= ($_POST['tools_o'] == 'on') ? 1 : 0;
				$log_o		= ($_POST['log_o'] == 'on') ? 1 : 0;
				
				$log_a		= ($_POST['log_a'] == 'on') ? 1 : 0;

				update_config('moderation', $view_m.','.$edit_m.','.$CONF_m.','.$tools_m.','.$log_m.';'.$view_o.','.$edit_o.','.$CONF_o.','.$tools_o.','.$log_o.';'.$log_a.';');
			}
			
			$QueryModeration	= $CONF['moderation'];
			$QueryModerationEx	= explode(";", $QueryModeration);
			$Moderator			= explode(",", $QueryModerationEx[0]);
			$Operator			= explode(",", $QueryModerationEx[1]);
			$Administrator		= explode(",", $QueryModerationEx[2]);

			$template	= new template();
			$template->page_header();
			$template->assign_vars(array(	
				'mods'				=> $LNG['rank'][1],
				'oper'				=> $LNG['rank'][2],
				'adm'				=> $LNG['rank'][3],
				'button_submit'		=> $LNG['button_submit'],
				'mod_title'			=> $LNG['mod_title'],
				'mod_power_config'	=> $LNG['mod_power_config'],
				'mod_range'			=> $LNG['mod_range'],
				'mod_power_edit'	=> $LNG['mod_power_edit'],
				'mod_power_view'	=> $LNG['mod_power_view'],
				'mod_power_tools'	=> $LNG['mod_power_tools'],
				'mod_power_loog'	=> $LNG['mod_power_loog'],
				'view_m'			=> ($Moderator[0] == 1) ? true : false,
				'edit_m'			=> ($Moderator[1] == 1) ? true : false,
				'config_m'			=> ($Moderator[2] == 1) ? true : false,
				'tools_m'			=> ($Moderator[3] == 1) ? true : false,
				'log_m'				=> ($Moderator[4] == 1) ? true : false,
				'view_o'			=> ($Operator[0] == 1) ? true : false,
				'edit_o'			=> ($Operator[1] == 1) ? true : false,
				'config_o'			=> ($Operator[2] == 1) ? true : false,
				'tools_o'			=> ($Operator[3] == 1) ? true : false,
				'log_o'				=> ($Operator[4] == 1) ? true : false,
				'log_a'				=> ($Administrator[0] == 1) ? true : false,
			));
	
			$template->show('adm/ModerrationRightsPage.tpl');
		break;
		case 'users':

			$template	= new template();
			$template->page_header();
			$template->loadscript('filterlist.js');
			
			if ($_POST)
			{
				$id			= request_var('id_1', 0);
				$authlevel	= request_var('authlevel', 0);
				
				if($id == 0)
					$id	= request_var('id_2', 0);
					
				if($id == 1) {
					$template->message($LNG['ad_authlevel_error_3'], '?page=rights&mode=users&sid='.session_id());
					exit;
				}	
				
				$db->multi_query("UPDATE ".USERS." SET `authlevel` = '".$_POST['authlevel']."' WHERE `id` = '".$id."';UPDATE ".PLANETS." SET `id_level` = '".$_POST['authlevel']."' WHERE `id_owner` = '".$id."';");
				$template->message($LNG['ad_authlevel_succes'], '?page=rights&mode=users&sid='.session_id());
				exit;
			}
							
			if ($_GET['get'] == 'adm')
				$WHEREUSERS	=	"WHERE `authlevel` = '3'";
			elseif ($_GET['get'] == 'ope')
				$WHEREUSERS	=	"WHERE `authlevel` = '2'";
			elseif ($_GET['get'] == 'mod')
				$WHEREUSERS	=	"WHERE `authlevel` = '1'";
			elseif ($_GET['get'] == 'pla')
				$WHEREUSERS	=	"WHERE `authlevel` = '0'";			
				
				
			$QueryUsers	=	$db->query("SELECT `id`, `username`, `authlevel` FROM ".USERS." ".$WHEREUSERS.";");
				
			$UserList	= "";
			while ($List = $db->fetch_array($QueryUsers)) {
				$UserList	.=	'<option value="'.$List['id'].'">'.$List['username'].'&nbsp;&nbsp;('.$LNG['rank'][$List['authlevel']].')</option>';
			}	

			$template->assign_vars(array(	
				'Selector'					=> array(0 => $LNG['rank'][0], 1 => $LNG['rank'][1], 2 => $LNG['rank'][2], 3 => $LNG['rank'][3]), 
				'UserList'					=> $UserList, 
				'ad_authlevel_title'		=> $LNG['ad_authlevel_title'], 
				'bo_select_title'			=> $LNG['bo_select_title'], 
				'button_submit'				=> $LNG['button_submit'], 
				'button_deselect'			=> $LNG['button_deselect'], 
				'button_filter'				=> $LNG['button_filter'], 
				'ad_authlevel_insert_id'	=> $LNG['ad_authlevel_insert_id'], 
				'ad_authlevel_auth'			=> $LNG['ad_authlevel_auth'], 
				'ad_authlevel_aa'			=> $LNG['ad_authlevel_aa'], 
				'ad_authlevel_oo'			=> $LNG['ad_authlevel_oo'], 
				'ad_authlevel_mm'			=> $LNG['ad_authlevel_mm'], 
				'ad_authlevel_jj'			=> $LNG['ad_authlevel_jj'], 
				'ad_authlevel_tt'			=> $LNG['ad_authlevel_tt'], 
				'sid'						=> session_id(), 
			));
	
			$template->show('adm/ModerrationUsersPage.tpl');
		break;
	}
}
?>