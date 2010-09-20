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

function ShowAccountEditorPage() 
{
	global $USER, $db, $LNG, $reslist, $resource;
	$template 	= new template();
	$template->page_header();
	switch($_GET['edit'])
	{
		case 'resources':
			$id         = request_var('id', 0);
			$id_dark    = request_var('id_dark', 0);
			$metal      = floattostring(round(abs(request_var('metal', 0.0)), 0));
			$cristal    = floattostring(round(abs(request_var('cristal', 0.0)), 0));
			$deut       = floattostring(round(abs(request_var('deut', 0.0)), 0));
			$dark		= request_var('dark', 0);

			if ($_POST)
			{
				if ($_POST['add'])
				{
					$SQL  = "UPDATE ".PLANETS." SET ";
					$SQL .= "`metal` = `metal` + '".$metal."', ";
					$SQL .= "`crystal` = `crystal` + '".$cristal."', ";
					$SQL .= "`deuterium` = `deuterium` + '".$deut ."' ";
					$SQL .= "WHERE ";
					$SQL .= "`id` = '". $id ."';";
					$db->query($SQL);

					if (!empty($id_dark)) {
						$SQL  = "UPDATE ".USERS." SET ";
						$SQL .= "`darkmatter` = `darkmatter` + '". $dark ."' ";
						$SQL .= "WHERE ";
						$SQL .= "`id` = '". $id_dark ."' ";
						$db->query($SQL);
					}
					$template->message($LNG['ad_add_sucess'], '?page=accounteditor&edit=resources');
				}
				elseif ($_POST['delete'])
				{
					$SQL  = "UPDATE ".PLANETS." SET ";
					$SQL .= "`metal` = `metal` - '". $metal ."', ";
					$SQL .= "`crystal` = `crystal` - '". $cristal ."', ";
					$SQL .= "`deuterium` = `deuterium` - '". $deut ."' ";
					$SQL .= "WHERE ";
					$SQL .= "`id` = '".$id."';";
					$db->query($SQL);

					if (!empty($id_dark)) {
						$SQL  = "UPDATE ".USERS." SET ";
						$SQL .= "`darkmatter` = `darkmatter` - '". $dark ."' ";
						$SQL .= "WHERE ";
						$SQL .= "`id` = '". $id_dark ."';";
						$db->query($SQL);
					}
					$template->message($LNG['ad_delete_sucess'], '?page=accounteditor&edit=resources');
				}
				exit;
			}
			
			
			$template->assign_vars(array(
				'button_reset'		=> $LNG['button_reset'],
				'button_delete'		=> $LNG['button_delete'],
				'button_add'		=> $LNG['button_add'],
				'Metal'				=> $LNG['Metal'],
				'Crystal'			=> $LNG['Crystal'],
				'Deuterium'			=> $LNG['Deuterium'],
				'Darkmatter'		=> $LNG['Darkmatter'],
				'ad_back_to_menu'	=> $LNG['ad_back_to_menu'],
				'input_id_user'		=> $LNG['input_id_user'],
				'resources_title'	=> $LNG['resources_title'],
				'input_id_p_m'		=> $LNG['input_id_p_m'],
			));
						
			$template->show('adm/AccountEditorPageResources.tpl');
		break;
		case 'ships':
			if($_POST)
			{
				if ($_POST['add'])
				{
					$SQL  = "UPDATE ".PLANETS." SET ";
					foreach($reslist['fleet'] as $ID)
					{
						$QryUpdate[]	= "`".$resource[$ID]."` = `".$resource[$ID]."` + '".floattostring(round(abs(request_var($resource[$ID], 0.0)), 0))."'";
					}
					$SQL .= implode(", ", $QryUpdate);
					$SQL .= "WHERE ";
					$SQL .= "`id` = '".request_var('id', 0)."';";
					$db->query($SQL);

					$template->message($LNG['ad_add_sucess_ships'], '?page=accounteditor&edit=ships');
				}
				elseif ($_POST['delete'])
				{
					$SQL  = "UPDATE ".PLANETS." SET ";
					foreach($reslist['fleet'] as $ID)
					{
						$QryUpdate[]	= "`".$resource[$ID]."` = `".$resource[$ID]."` - '".floattostring(round(abs(request_var($resource[$ID], 0.0)), 0))."'";
					}
					$SQL .= implode(", ", $QryUpdate);
					$SQL .= "WHERE ";
					$SQL .= "`id` = '".request_var('id', 0)."';";
					$db->query($SQL);
					
					$template->message($LNG['ad_delete_sucess_ships'], '?page=accounteditor&edit=ships');
				}
				exit;
			}

			$parse['ships']	= "";
			foreach($reslist['fleet'] as $ID)
			{
				$INPUT[$ID]	= array(
					'name'	=> $LNG['tech'][$ID],
					'type'	=> $resource[$ID],
				);
			}

			$template->assign_vars(array(
				'inputlist'			=> $INPUT,
				'button_reset'		=> $LNG['button_reset'],
				'button_delete'		=> $LNG['button_delete'],
				'button_add'		=> $LNG['button_add'],
				'ad_back_to_menu'	=> $LNG['ad_back_to_menu'],
				'input_id_p_m'		=> $LNG['input_id_p_m'],
				'ships_title'		=> $LNG['ad_ships_title'],
				'ad_number'			=> $LNG['ad_number'],
				'ships_count'		=> $LNG['ad_count'],
			));
						
			$template->show('adm/AccountEditorPageShips.tpl');
		break;

		case 'defenses':
			if($_POST)
			{
				if ($_POST['add'])
				{
					$SQL  = "UPDATE ".PLANETS." SET ";
					foreach($reslist['defense'] as $ID)
					{
						$QryUpdate[]	= "`".$resource[$ID]."` = `".$resource[$ID]."` + '".floattostring(round(abs(request_var($resource[$ID], 0.0)), 0))."'";
					}
					$SQL .= implode(", ", $QryUpdate);
					$SQL .= "WHERE ";
					$SQL .= "`id` = '".request_var('id', 0)."';";
					$db->query($SQL);

					$template->message($LNG['ad_add_defenses_succes'], '?page=accounteditor&edit=defenses');
				}
				elseif ($_POST['delete'])
				{
					$SQL  = "UPDATE ".PLANETS." SET ";
					foreach($reslist['defense'] as $ID)
					{
						$QryUpdate[]	= "`".$resource[$ID]."` = `".$resource[$ID]."` - '".floattostring(round(abs(request_var($resource[$ID], 0.0)), 0))."'";
					}
					$SQL .= implode(", ", $QryUpdate);
					$SQL .= "WHERE ";
					$SQL .= "`id` = '".request_var('id', 0)."';";
					$db->query( $SQL);
					$Name	=	$LNG['log_nomoree'];
					$template->message($LNG['ad_delete_defenses_succes'], '?page=accounteditor&edit=defenses');
				}
				exit;
			}
			
			foreach($reslist['defense'] as $ID)
			{
				$INPUT[$ID]	= array(
					'name'	=> $LNG['tech'][$ID],
					'type'	=> $resource[$ID],
				);
			}

			$template->assign_vars(array(
				'inputlist'			=> $INPUT,
				'button_reset'		=> $LNG['button_reset'],
				'button_delete'		=> $LNG['button_delete'],
				'button_add'		=> $LNG['button_add'],
				'ad_back_to_menu'	=> $LNG['ad_back_to_menu'],
				'input_id_p_m'		=> $LNG['input_id_p_m'],
				'defenses_title'	=> $LNG['ad_defenses_title'],
				'ad_number'			=> $LNG['ad_number'],
				'defenses_count'	=> $LNG['ad_count'],
			));
						
			$template->show('adm/AccountEditorPageDefenses.tpl');
		break;
		break;

		case 'buildings':
			if($_POST)
			{
				$PlanetData	= $db->uniquequery("SELECT `planet_type` FROM ".PLANETS." WHERE `id` = '".request_var('id', 0)."';");
				if ($_POST['add'])
				{
					$SQL  = "UPDATE ".PLANETS." SET ";
					foreach($reslist['allow'][$PlanetData['planet_type']] as $ID)
					{
						$QryUpdate[]	= "`".$resource[$ID]."` = `".$resource[$ID]."` + '".floattostring(round(abs(request_var($resource[$ID], 0.0)), 0))."'";
					}
					$SQL .= implode(", ", $QryUpdate);
					$SQL .= "WHERE ";
					$SQL .= "`id` = '".request_var('id', 0)."';";
					$db->query($SQL);

					$template->message($LNG['ad_add_succes'], '?page=accounteditor&edit=buildings');
				}
				elseif ($_POST['delete'])
				{
					$SQL  = "UPDATE ".PLANETS." SET ";
					foreach($reslist['allow'][$PlanetData['planet_type']] as $ID)
					{
						$QryUpdate[]	= "`".$resource[$ID]."` = `".$resource[$ID]."` - '".floattostring(round(abs(request_var($resource[$ID], 0.0)), 0))."'";
					}
					$SQL .= implode(", ", $QryUpdate);
					$SQL .= "WHERE ";
					$SQL .= "`id` = '".request_var('id', 0)."';";
					$db->query($SQL);
					
					$template->message($LNG['ad_delete_succes'], '?page=accounteditor&edit=buildings');
				}
				exit;
			}
			
			foreach($reslist['build'] as $ID)
			{
				$INPUT[$ID]	= array(
					'name'	=> $LNG['tech'][$ID],
					'type'	=> $resource[$ID],
				);
			}

			$template->assign_vars(array(
				'inputlist'			=> $INPUT,
				'button_reset'		=> $LNG['button_reset'],
				'button_delete'		=> $LNG['button_delete'],
				'button_add'		=> $LNG['button_add'],
				'ad_back_to_menu'	=> $LNG['ad_back_to_menu'],
				'input_id_p_m'		=> $LNG['input_id_p_m'],
				'buildings_title'	=> $LNG['ad_buildings_title'],
				'ad_number'			=> $LNG['ad_number'],
				'ad_levels'			=> $LNG['ad_levels'],
			));
						
			$template->show('adm/AccountEditorPageBuilds.tpl');
		break;

		case 'researchs':
			if($_POST)
			{
				if ($_POST['add'])
				{
					$SQL  = "UPDATE ".USERS." SET ";
					foreach($reslist['tech'] as $ID)
					{
						$QryUpdate[]	= "`".$resource[$ID]."` = `".$resource[$ID]."` + '".floattostring(round(abs(request_var($resource[$ID], 0.0)), 0))."'";
					}
					$SQL .= implode(", ", $QryUpdate);
					$SQL .= "WHERE ";
					$SQL .= "`id` = '".request_var('id', 0)."';";
					$db->query($SQL);

					$template->message($LNG['ad_add_succes'], '?page=accounteditor&edit=researchs');
				}
				elseif ($_POST['delete'])
				{
					$SQL  = "UPDATE ".USERS." SET ";
					foreach($reslist['tech'] as $ID)
					{
						$QryUpdate[]	= "`".$resource[$ID]."` = `".$resource[$ID]."` - '".floattostring(round(abs(request_var($resource[$ID], 0.0)), 0))."'";
					}
					$SQL .= implode(", ", $QryUpdate);
					$SQL .= "WHERE ";
					$SQL .= "`id` = '".request_var('id', 0)."';";
					$db->query($SQL);
	
					$template->message($LNG['ad_delete_succes'], '?page=accounteditor&edit=researchs');
				}
				exit;
			}
			
			foreach($reslist['tech'] as $ID)
			{
				$INPUT[$ID]	= array(
					'name'	=> $LNG['tech'][$ID],
					'type'	=> $resource[$ID],
				);
			}

			$template->assign_vars(array(
				'inputlist'			=> $INPUT,
				'button_reset'		=> $LNG['button_reset'],
				'button_delete'		=> $LNG['button_delete'],
				'button_add'		=> $LNG['button_add'],
				'ad_back_to_menu'	=> $LNG['ad_back_to_menu'],
				'input_id_user'		=> $LNG['input_id_user'],
				'research_title'	=> $LNG['ad_research_title'],
				'ad_number'			=> $LNG['ad_number'],
				'research_count'	=> $LNG['ad_count'],
			));
						
			$template->show('adm/AccountEditorPageResearch.tpl');
		break;
		case 'personal':
			if ($_POST)
			{
				$id			= request_var('id', 0);				
				$username	= request_var('username', '', UTF8_SUPPORT);				
				$password	= request_var('password', '', true);				
				$email		= request_var('email', '');				
				$email_2	= request_var('email_2', '');				
				$vacation	= request_var('vacation', '');				
				
				$PersonalQuery    =    "UPDATE ".USERS." SET ";

				if(!empty($username) && $id != 1)
					$PersonalQuery    .= "`username` = '".$db->sql_escape($username)."', ";
				
				if(!empty($email) && $id != 1)
					$PersonalQuery    .= "`email` = '".$db->sql_escape($email)."', ";

				if(!empty($email_2) && $id != 1)
					$PersonalQuery    .= "`email_2` = '".$db->sql_escape($email_2)."', ";

				if(!empty($password) && $id != 1)
					$PersonalQuery    .= "`password` = '".$db->sql_escape(md5($password))."', ";

					
				$Answer		= 0;
				$TimeAns	= 0;
				
				if ($vacation == 'yes') {
					$Answer		= 1;
					$TimeAns    = TIMESTAMP + $_POST['d'] * 86400 + $_POST['h'] * 3600 + $_POST['m'] * 60 + $_POST['s'];
				}
				
				$PersonalQuery    .=  "`urlaubs_modus` = '".$Answer."', `urlaubs_until` = '".$TimeAns."' ";			
				$PersonalQuery    .= "WHERE `id` = '".$id."'";
				$db->query($PersonalQuery);
				
				$template->message($LNG['ad_personal_succes'], '?page=accounteditor&edit=personal');

				exit;
			}
			
			$template->assign_vars(array(
				'button_submit'			=> $LNG['button_submit'],
				'ad_back_to_menu'		=> $LNG['ad_back_to_menu'],
				'input_id'				=> $LNG['input_id'],
				'ad_personal_vacat'		=> $LNG['ad_personal_vacat'],
				'ad_personal_email2'	=> $LNG['ad_personal_email2'],
				'ad_personal_email'		=> $LNG['ad_personal_email'],
				'ad_personal_pass'		=> $LNG['ad_personal_pass'],
				'ad_personal_name'		=> $LNG['ad_personal_name'],
				'ad_personal_title'		=> $LNG['ad_personal_title'],
				'time_seconds'			=> $LNG['time_seconds'],
				'time_minutes'			=> $LNG['time_minutes'],
				'time_hours'			=> $LNG['time_hours'],
				'time_days'				=> $LNG['time_days'],
				'Selector'				=> array(''	=> $LNG['select_option'], 'yes' => $LNG['one_is_yes'][1], 'no' => $LNG['one_is_yes'][0]),
			));
						
			$template->show('adm/AccountEditorPagePersonal.tpl');
		break;

		case 'officiers':
			if($_POST)
			{
				if ($_POST['add'])
				{
					$SQL  = "UPDATE ".USERS." SET ";
					foreach($reslist['officier'] as $ID)
					{
						$QryUpdate[]	= "`".$resource[$ID]."` = `".$resource[$ID]."` + '".floattostring(round(abs(request_var($resource[$ID], 0.0)), 0))."'";
					}
					$SQL .= implode(", ", $QryUpdate);
					$SQL .= "WHERE ";
					$SQL .= "`id` = '".request_var('id', 0)."';";
					$db->query($SQL);
					
					$template->message($LNG['ad_offi_succes_add'], '?page=accounteditor&edit=officiers');
				}
				elseif ($_POST['delete'])
				{
					$SQL  = "UPDATE ".USERS." SET ";
					foreach($reslist['officier'] as $ID)
					{
						$QryUpdate[]	= "`".$resource[$ID]."` = `".$resource[$ID]."` - '".floattostring(round(abs(request_var($resource[$ID], 0.0)), 0))."'";
					}
					$SQL .= implode(", ", $QryUpdate);
					$SQL .= "WHERE ";
					$SQL .= "`id` = '".request_var('id', 0)."';";
					$db->query($SQL);
					
					$template->message($LNG['ad_offi_succes_delete'], '?page=accounteditor&edit=officiers');
				}
				
				exit;
			}
			
			foreach($reslist['officier'] as $ID)
			{
				$INPUT[$ID]	= array(
					'name'	=> $LNG['tech'][$ID],
					'type'	=> $resource[$ID],
				);
			}

			$template->assign_vars(array(
				'inputlist'			=> $INPUT,
				'button_reset'		=> $LNG['button_reset'],
				'button_delete'		=> $LNG['button_delete'],
				'button_add'		=> $LNG['button_add'],
				'ad_back_to_menu'	=> $LNG['ad_back_to_menu'],
				'input_id_user'		=> $LNG['input_id_user'],
				'officiers_title'	=> $LNG['ad_offi_title'],
				'ad_number'			=> $LNG['ad_number'],
				'officiers_count'	=> $LNG['ad_count'],
			));
						
			$template->show('adm/AccountEditorPageOfficiers.tpl');
		break;

		case 'planets':
			if ($_POST)
			{
				$id				= request_var('id', 0);
				$name			= request_var('name', '', UTF8_SUPPORT);
				$diameter		= request_var('diameter', 0);
				$fields			= request_var('fields', 0);
				$buildings		= request_var('0_buildings', '');
				$ships			= request_var('0_ships', '');
				$defenses		= request_var('0_defenses', '');
				$c_hangar		= request_var('0_c_hangar', '');
				$c_buildings	= request_var('0_c_buildings', '');
				$change_pos		= request_var('change_position', '');
				$galaxy			= request_var('g', 0);
				$system			= request_var('s', 0);
				$planet			= request_var('p', 0);

				if (!empty($name))
					$db->query("UPDATE ".PLANETS." SET `name` = '".$db->sql_escape($name)."' WHERE `id` = '".$id."';");
						
				if ($buildings == 'on')
				{
					foreach($reslist['build'] as $ID) {
						$BUILD[]	= "`".$resource[$ID]."` = '0'";
					}
						
					$db->query("UPDATE ".PLANETS." SET ".implode(', ',$BUILD)." WHERE `id` = '".$id."';");
				}
					
				if ($ships == 'on')
				{
					foreach($reslist['fleet'] as $ID) {
						$SHIPS[]	= "`".$resource[$ID]."` = '0'";
					}
					
					$db->query("UPDATE ".PLANETS." SET ".implode(', ',$SHIPS)." WHERE `id` = '".$id."';");
				}
						
				if ($defenses == 'on')
				{
					foreach($reslist['defense'] as $ID) {
						$DEFS[]	= "`".$resource[$ID]."` = '0'";
					}
				
					$db->query("UPDATE ".PLANETS." SET ".implode(', ',$DEFS)." WHERE `id` = '".$id."';");
				}

				if ($c_hangar == 'on')
					$db->query("UPDATE ".PLANETS." SET `b_hangar` = '0', `b_hangar_plus` = '0', `b_hangar_id` = '' WHERE `id` = '".$id."';");

				if ($c_buildings == 'on')
					$db->query("UPDATE ".PLANETS." SET `b_building` = '0', `b_building_id` = '' WHERE `id` = '".$id."';");

				if (!empty($diameter))
					$db->query("UPDATE ".PLANETS." SET `diameter` = '".$diameter."' WHERE `id` = '".$id."';");

				if (!empty($fields))
					$db->query("UPDATE ".PLANETS." SET `field_max` = '".$fields."' WHERE `id` = '".$id."';");
						
				if ($change_pos == 'on' && $galaxy > 0 && $system > 0 && $planet > 0 && $galaxy <= MAX_GALAXY_IN_WORLD && $system <= MAX_SYSTEM_IN_GALAXY && $planet <= MAX_PLANET_IN_SYSTEM)
				{
					$P	=	$db->uniquequery("SELECT galaxy,system,planet,planet_type FROM ".PLANETS." WHERE `id` = '".$id."';");
					if ($P['planet_type'] == '1')
					{
						if (CheckPlanetIfExist($galaxy, $system, $planet, $P['planet_type']))
						{
							$template->message($LNG['ad_pla_error_planets3'], '?page=accounteditor&edit=planets');
							exit;
						}

						$db->query ("UPDATE ".PLANETS." SET `galaxy` = '".$galaxy."', `system` = '".$system."', `planet` = '".$planet."' WHERE `id` = '".$id."';");

					} else {
						if(CheckPlanetIfExist($galaxy, $system, $planet, $P['planet_type']))
						{
							$template->message($LNG['ad_pla_error_planets5'], '?page=accounteditor&edit=planets');
							exit;
						}
						
						$Target	= $db->uniquequery("SELECT id_luna FROM ".PLANETS." WHERE `galaxy` = '".$galaxy."' AND `system` = '".$system."' AND `planet` = '".$planet."' AND `planet_type` = '1';");
								
						if ($Target['id_luna'] != '0')
						{
							$template->message($LNG['ad_pla_error_planets4'], '?page=accounteditor&edit=planets');
							exit;
						}
							
						$db->query("UPDATE ".PLANETS." SET `id_luna` = '0' WHERE `galaxy` = '".$P['galaxy']."' AND `system` = '".$P['system']."' AND `planet` = '".$P['planet']."' AND `planet_type` = '1';");
						$db->query("UPDATE ".PLANETS." SET `id_luna` = '".$id."'  WHERE `galaxy` = '".$galaxy."' AND `system` = '".$system."' AND `planet` = '".$planet."' AND planet_type = '1';");
						$db->query("UPDATE ".PLANETS." SET `galaxy` = '".$galaxy."', `system` = '".$system."', `planet` = '".$planet."' WHERE `id` = '".$id."';");
						
						$QMOON2	=	$db->uniquequery("SELECT id_level, id_owner FROM ".PLANETS." WHERE `galaxy` = '".$galaxy."' AND `system` = '".$system."' AND `planet` = '".$planet."';");
						$db->query("UPDATE ".PLANETS." SET `galaxy` = '".$galaxy."', `system` = '".$system."', `planet` = '".$planet."', `id_owner` = '".$QMOON2['id_owner']."', `id_level` = '".$QMOON2['id_level']."' WHERE `id` = '".$id."' AND `planet_type` = '3';");
					}
				}

				$template->message($LNG['ad_pla_succes'], '?page=accounteditor&edit=planets');
				exit;
			}
			
			$template->assign_vars(array(
				'button_submit'			=> $LNG['button_submit'],
				'button_reset'			=> $LNG['button_reset'],
				'ad_back_to_menu'		=> $LNG['ad_back_to_menu'],
				'ad_pla_title'			=> $LNG['ad_pla_title'],
				'input_id_p_m'			=> $LNG['input_id_p_m'],
				'ad_pla_edit_name'		=> $LNG['ad_pla_edit_name'],
				'ad_pla_edit_diameter'	=> $LNG['ad_pla_edit_diameter'],
				'ad_pla_edit_fields'	=> $LNG['ad_pla_edit_fields'],
				'ad_pla_delete_b'		=> $LNG['ad_pla_delete_b'],
				'ad_pla_delete_s'		=> $LNG['ad_pla_delete_s'],
				'ad_pla_delete_d'		=> $LNG['ad_pla_delete_d'],
				'ad_pla_delete_hd'		=> $LNG['ad_pla_delete_hd'],
				'ad_pla_delete_cb'		=> $LNG['ad_pla_delete_cb'],
				'ad_pla_title_l'		=> $LNG['ad_pla_title_l'],
				'ad_pla_change_p'		=> $LNG['ad_pla_change_p'],
				'ad_pla_change_pp'		=> $LNG['ad_pla_change_pp'],
			));
						
			$template->show('adm/AccountEditorPagePlanets.tpl');
		break;

		case 'alliances':
			if ($_POST)
			{
				$id				=	request_var('id', 0);
				$name			=	request_var('name', '', UTF8_SUPPORT);
				$changeleader	=	request_var('changeleader', 0);
				$tag			=	request_var('tag', '', UTF8_SUPPORT);
				$externo		=	request_var('externo', '', true);
				$interno		=	request_var('interno', '', true);
				$solicitud		=	request_var('solicitud', '', true);
				$delete			=	request_var('delete', '');
				$delete_u		=	request_var('delete_u', '');

				$QueryF	=	$db->uniquequery("SELECT * FROM ".ALLIANCE." WHERE `id` = '".$id."';");

				if (!empty($name))
					$db->multi_query("UPDATE ".ALLIANCE." SET `ally_name` = '".$name."' WHERE `id` = '".$id."';UPDATE ".USERS." SET `ally_name` = '".$name."' WHERE `ally_id` = '".$id."';");

				if (!empty($tag))
					$db->query("UPDATE ".ALLIANCE." SET `ally_tag` = '".$tag."' WHERE `id` = '".$id."';");

				$QueryF2	=	$db->uniquequery("SELECT ally_id FROM ".USERS." WHERE `id` = '".$changeleader."';");
				$db->multi_query("UPDATE ".ALLIANCE." SET `ally_owner` = '".$changeleader."' WHERE `id` = '".$id."';UPDATE ".USERS." SET `ally_rank_id` = '0' WHERE `id` = '".$changeleader."';");
						
				if (!empty($externo))
					$db->query("UPDATE ".ALLIANCE." SET `ally_description` = '".$externo."' WHERE `id` = '".$id."';");
				
				if (!empty($interno))
					$db->query("UPDATE ".ALLIANCE." SET `ally_text` = '".$interno."' WHERE `id` = '".$id."';");
					
				if (!empty($solicitud))
					$db->query("UPDATE ".ALLIANCE." SET `ally_request` = '".$solicitud."' WHERE `id` = '".$id."';");
				
				if ($delete == 'on')
				{
					$db->query("DELETE FROM ".ALLIANCE." WHERE `id` = '".$id."';");
					$db->query("UPDATE ".USERS." SET `ally_id` = '0', `ally_name` = '', `ally_request` = '0', `ally_rank_id` = '0', `ally_register_time` = '0', `ally_request` = '0' WHERE `ally_id` = '".$id."';");
				}

				if (!empty($delete_u))
				{
					$db->query("UPDATE ".ALLIANCE." SET `ally_members` = ally_members - 1 WHERE `id` = '".$id."';");
					$db->query("UPDATE ".USERS." SET `ally_id` = '0', `ally_name` = '', `ally_request` = '0', `ally_rank_id` = '0', `ally_register_time` = '0', `ally_request` = '0' WHERE `id` = '".$delete_u."' AND `ally_id` = '".$id."';");			
				}


				$template->message($LNG['ad_ally_succes'], '?page=accounteditor&edit=alliances');
				exit;
			}
			
			$template->assign_vars(array(
				'button_submit'		=> $LNG['button_submit'],
				'ad_back_to_menu'	=> $LNG['ad_back_to_menu'],
				'ad_pla_title'		=> $LNG['ad_pla_title'],
				'ad_ally_title'		=> $LNG['ad_ally_title'],
				'input_id_ally'		=> $LNG['input_id_ally'],
				'ad_ally_change_id'	=> $LNG['ad_ally_change_id'],
				'ad_ally_name'		=> $LNG['ad_ally_name'],
				'ad_ally_tag'		=> $LNG['ad_ally_tag'],
				'ad_ally_delete_u'	=> $LNG['ad_ally_delete_u'],
				'ad_ally_user_id'	=> $LNG['ad_ally_user_id'],
				'ad_ally_delete'	=> $LNG['ad_ally_delete'],
				'ad_ally_text1'		=> $LNG['ad_ally_text1'],
				'ad_ally_text2'		=> $LNG['ad_ally_text2'],
				'ad_ally_text3'		=> $LNG['ad_ally_text3'],
			));
						
			$template->show('adm/AccountEditorPageAlliance.tpl');
		break;

		default:
			$template->assign_vars(array(
				'ad_editor_personal'	=> $LNG['ad_editor_personal'],
				'ad_editor_alliances'	=> $LNG['ad_editor_alliances'],
				'ad_editor_planets'		=> $LNG['ad_editor_planets'],
				'ad_editor_resources'	=> $LNG['ad_editor_resources'],
				'ad_editor_officiers'	=> $LNG['ad_editor_officiers'],
				'ad_editor_researchs'	=> $LNG['ad_editor_researchs'],
				'ad_editor_defenses'	=> $LNG['ad_editor_defenses'],
				'ad_editor_ships'		=> $LNG['ad_editor_ships'],
				'ad_editor_buildings'	=> $LNG['ad_editor_buildings'],
				'ad_editor_title'		=> $LNG['ad_editor_title'],
			));
							
			$template->show('adm/AccountEditorPageMenu.tpl');
		break;
	}
}
?>