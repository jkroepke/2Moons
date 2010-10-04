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

if ($USER['rights'][str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__)] != 1) exit;
function ShowRightsPage()
{
	global $LNG, $CONF, $db, $USER;
	$mode	= request_var('mode', '');
	switch($mode)
	{
		case 'rights':

			$template	= new template();
			$template->page_header();
			$template->loadscript('filterlist.js');
			
			if ($_POST)
			{
				$id			= request_var('id_1', 0);
				
				if($USER['id'] != 1 && $id == 1) {
					$template->message($LNG['ad_authlevel_error_3'], '?page=rights&mode=rights&sid='.session_id());
					exit;
				}
				
				if($_POST['action'] == 'send') {
					$db->query("UPDATE ".USERS." SET `rights` = '".serialize(array_map('intval', $_POST['rights']))."' WHERE `id` = '".$id."';");
				}
				
				$Rights	= $db->uniquequery("SELECT rights FROM ".USERS." WHERE `id` = '".$id."';");
				if(($Rights['rights'] = unserialize($Rights['rights'])) === false)
					$Rights['rights']	= array();
				
				$Files	= array_map('prepare', array_diff(scandir(ROOT_PATH.'includes/pages/adm/'), array('.', '..', '.svn', 'index.html', '.htaccess', 'ShowIndexPage.php', 'ShowOverviewPage.php', 'ShowMenuPage.php', 'ShowTopnavPage.php')));
				
				$template->assign_vars(array(	
					'Files'						=> $Files, 
					'Rights'					=> $Rights['rights'], 
					'id'						=> $id, 
					'yesorno'					=> $LNG['one_is_yes'], 
					'ad_authlevel_title'		=> $LNG['ad_authlevel_title'], 
					'button_submit'				=> $LNG['button_submit'],  
					'sid'						=> session_id(), 
				));
				
				$template->show('adm/ModerrationRightsPostPage.tpl');		
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
					
				if($USER['id'] != 1 && $id == 1) {
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

function prepare($val)
{
	return str_replace('.php', '', $val);
}
?>