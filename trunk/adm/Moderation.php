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


if ($user['authlevel'] < 3) die(message ($lang['404_page']));


$parse	=	$lang;

if ($_GET['moderation'] == '1')
{
	$QueryModeration	=	$game_config['moderation'];
	$QueryModerationEx	=	explode(";", $QueryModeration);
	$Moderator			=	explode(",", $QueryModerationEx[0]);
	$Operator			=	explode(",", $QueryModerationEx[1]);
	$Administrator		=	explode(",", $QueryModerationEx[2]); // Solo sirve para el historial


	// MODERADORES
	if($Moderator[0] == 1){$parse['view_m'] = 'checked = "checked"';}
	if($Moderator[1] == 1){$parse['edit_m'] = 'checked = "checked"';}
	if($Moderator[2] == 1){$parse['config_m'] = 'checked = "checked"';}
	if($Moderator[3] == 1){$parse['tools_m'] = 'checked = "checked"';}
	if($Moderator[4] == 1){$parse['log_m'] = 'checked = "checked"';}


	// OPERADORES
	if($Operator[0] == 1){$parse['view_o'] = 'checked = "checked"';}
	if($Operator[1] == 1){$parse['edit_o'] = 'checked = "checked"';}
	if($Operator[2] == 1){$parse['config_o'] = 'checked = "checked"';}
	if($Operator[3] == 1){$parse['tools_o'] = 'checked = "checked"';}
	if($Operator[4] == 1){$parse['log_o'] = 'checked = "checked"';}
	
	// ADMINISTRADOR (SOLO PARA EL HISTORIAL)
	if($Administrator[0] == 1){$parse['log_a'] = 'checked = "checked"';}



	$parse['mods']	=	$lang['rank'][1];
	$parse['oper']	=	$lang['rank'][2];
	$parse['adm']	=	$lang['rank'][3];

	if ($_POST['mode'])
	{
		if($_POST['view_m'] == 'on') $view_m = 1; else $view_m = 0; 
		if($_POST['edit_m'] == 'on') $edit_m = 1; else $edit_m = 0; 
		if($_POST['config_m'] == 'on') $config_m = 1; else $config_m = 0;
		if($_POST['tools_m'] == 'on') $tools_m = 1; else $tools_m = 0;
		if($_POST['log_m'] == 'on') $log_m = 1; else $log_m = 0;
		
		if($_POST['view_o'] == 'on') $view_o = 1; else $view_o = 0;
		if($_POST['edit_o'] == 'on') $edit_o = 1; else $edit_o = 0;
		if($_POST['config_o'] == 'on') $config_o = 1; else $config_o = 0;
		if($_POST['tools_o'] == 'on') $tools_o = 1; else $tools_o = 0;
		if($_POST['log_o'] == 'on') $log_o = 1; else $log_o = 0;
		
		if($_POST['log_a'] == 'on') $log_a = 1; else $log_a = 0;
	
	
	
		$QueryEdit	=	$view_m.",".$edit_m.",".$config_m.",".$tools_m.",".$log_m.";".
						$view_o.",".$edit_o.",".$config_o.",".$tools_o.",".$log_o.";".$log_a.";";


		$Log	.=	"\n".$lang['log_system_mod_title']."\n";
		$Log	.=	$lang['log_the_user'].$user['username']." ".$lang['log_modify_personal'].":\n";
		$Log	.=	$lang['log_can_view_mod']."\n";
		$Log	.=	$lang['log_tools'].":     ".$lang['log_viewmod'][$tools_m]."\n";
		$Log	.=	$lang['log_edit'].":     ".$lang['log_viewmod'][$edit_m]."\n";
		$Log	.=	$lang['log_view'].":     ".$lang['log_viewmod'][$view_m]."\n";
		$Log	.=	$lang['log_config'].":     ".$lang['log_viewmod'][$config_m]."\n\n";
		$Log	.=	$lang['log_can_view_ope']."\n";
		$Log	.=	$lang['log_tools'].":     ".$lang['log_viewmod'][$tools_o]."\n";
		$Log	.=	$lang['log_edit'].":     ".$lang['log_viewmod'][$edit_o]."\n";
		$Log	.=	$lang['log_view'].":     ".$lang['log_viewmod'][$view_o]."\n";
		$Log	.=	$lang['log_config'].":     ".$lang['log_viewmod'][$config_o]."\n";
				
		LogFunction($Log, "ModerationLog", $LogCanWork);
		
		
		update_config('moderation', $QueryEdit);
		header("Location: Moderation.php?moderation=1");
	}
	
	display(parsetemplate(gettemplate('adm/ModerationBody'), $parse), false, '' , true, false);
}
elseif ($_GET['moderation'] == '2')
{
		for ($i	= 0; $i < 4; $i++)
		{
			$parse['authlevels']	.=	"<option value=\"".$i."\">".$lang['rank'][$i]."</option>";
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
			
			
		while ($List	=	$db->fetch_array($QueryUsers))
		{
			$parse['List']	.=	"<option value=\"".$List['id']."\">".$List['username']."&nbsp;&nbsp;(".$lang['rank'][$List['authlevel']].")</option>";
		}

		
		if ($_POST)
		{
			if ($_POST['id_1'] != NULL && $_POST['id_2'] != NULL)
			{
				$parse['display']	=	'<tr><th colspan="3"><font color=red>'.$lang['ad_authlevel_error_2'].'</font></th></tr>';
			}
			elseif(!$_POST['id_1'] && !$_POST['id_2'])
			{
				$parse['display']	=	'<tr><th colspan="3"><font color=red>'.$lang['ad_forgiven_id'].'</font></th></tr>';
			}
			elseif(!$_POST['id_1'] && !is_numeric($_POST['id_2']))
			{
				$parse['display']	=	'<tr><th colspan="3"><font color=red>'.$lang['only_numbers'].'</font></th></tr>';
			}
			elseif($_POST['id_1'] == '1' || $_POST['id_2'] == '1')
			{
				$parse['display']	=	'<tr><th colspan="3"><font color=red>'.$lang['ad_authlevel_error_3'].'</font></th></tr>';
			}
			else
			{
				if ($_POST['id_1'] != NULL)
					$id	=	$_POST['id_1'];
				else
					$id	=	$_POST['id_2'];

				
				$QueryFind	=	$db->fetch_array($db->query("SELECT `authlevel` FROM ".USERS." WHERE `id` = '".$id."';"));
				
				if($QueryFind['authlevel'] != $_POST['authlevel'])
				{						
					$db->query("UPDATE ".USERS." SET `authlevel` = '".$_POST['authlevel']."' WHERE `id` = '".$id."';");
					$db->query("UPDATE ".PLANETS." SET `id_level` = '".$_POST['authlevel']."' WHERE `id_owner` = '".$id."';");
					
					
					$ASD	=	$_POST['authlevel'];
					$Log	.=	"\n".$lang['log_system_auth_title']."\n";
					$Log	.=	$lang['log_the_user'].$user['username']." ".$lang['log_change_auth_1'].$id.",\n";
					$Log	.=	$lang['log_change_auth_2'].$lang['ad_authlevel'][$ASD]."\n";
				
					LogFunction($Log, "ModerationLog", $LogCanWork);
					
					header ("Location: Moderation.php?moderation=2&succes=yes");
				}
				else
				{
					$parse['display']	=	'<tr><th colspan="3"><font color=red>'.$lang['ad_authlevel_error'].'</font></th></tr>';
				}
			}
		}
		
		if ($_GET['succes']	==	'yes')
			$parse['display']	=	'<tr><th colspan="3"><font color=lime>'.$lang['ad_authlevel_succes'].'</font></th></tr>';
			
			
		display (parsetemplate(gettemplate("adm/AuthlevelBody"), $parse), false, '', true, false);
}
else
{
	die();
}
?>