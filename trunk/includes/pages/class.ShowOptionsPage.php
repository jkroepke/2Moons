<?php

##############################################################################
# *                                                                          #
# * 2MOONS                                                                   #
# *                                                                          #
# * @copyright Copyright (C) 2010 By ShadoX from titanspace.de               #
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

class ShowOptionsPage
{
	private function CheckIfIsBuilding($CurrentUser)
	{
		global $db;
		$query = $db->query("SELECT b_building,b_tech,b_hangar FROM ".PLANETS." WHERE id_owner = '".$CurrentUser['id']."';");
		
		$this->ClearBuildHanger($CurrentUser['id']);
		
		while($id = $db->fetch_array($query))
		{
			if($id['b_building'] != 0)
			{
				if($id['b_building'] != "")
					return true;
			}
			elseif($id['b_tech'] != 0)
			{
				if($id['b_tech'] != "")
					return true;
			}
			elseif($id['b_hangar'] != 0)
			{
				if($id['b_hangar'] != "")
					return true;
			}
		}
		$fleets = $db->fetch_array($db->query("SELECT * FROM ".FLEETS." WHERE `fleet_owner` = '{$CurrentUser['id']}';"));
		if($fleets != 0)
			return true;

		return false;
	}


	private function ClearBuildHanger($userid)
	{
		global $db;
		$QrySelectPlanet  = "SELECT `id`, `id_owner`, `b_hangar`, `b_hangar_id` ";
		$QrySelectPlanet .= "FROM ".PLANETS." ";
		$QrySelectPlanet .= "WHERE ";
		$QrySelectPlanet .= "`b_hangar_id` != '0' AND ";
		$QrySelectPlanet .= "`id_owner` = '".$userid."';";
		$AffectedPlanets  = $db->query ($QrySelectPlanet);
		$DeletedQueues    = 0;
		while($ActualPlanet = $db->fetch($AffectedPlanets) ) {
			$HangarQueue = explode (";", $ActualPlanet['b_hangar_id']);
			$bDelQueue   = false;
			if (count($HangarQueue)) {
				for ( $Queue = 0; $Queue < count($HangarQueue); $Queue++) {
					$InQueue = explode (",", $HangarQueue[$Queue]);
					if ($InQueue[1] > MAX_FLEET_OR_DEFS_PER_ROW) {
						$bDelQueue = true;
					}
				}
			}
			if ($bDelQueue) {
				$QryUpdatePlanet  = "UPDATE ".PLANETS." ";
				$QryUpdatePlanet .= "SET ";
				$QryUpdatePlanet .= "`b_hangar` = '0', ";
				$QryUpdatePlanet .= "`b_hangar_id` = '0' ";
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`id` = '".$ActualPlanet['id']."';";
				$db->query ($QryUpdatePlanet);
				$DeletedQueues += 1;
			}
		}
	}
	
	public function ShowOptionsPage($CurrentUser, $CurrentPlanet)
	{
		global $game_config, $dpath, $lang, $db;

		$mode 			= request_var('mode', '');
		$exit 			= request_var('exit_modus', '');
		$db_deaktjava 	= request_var('db_deaktjava', '');
		
		if ($mode == "exit")
		{
			if ($exit == 'on' and $CurrentUser['urlaubs_until'] <= time())
				$db->query("UPDATE ".USERS." SET `urlaubs_modus` = '0', `urlaubs_until` = '0' WHERE `id` = '".$CurrentUser['id']."' LIMIT 1;");
			
			if ($db_deaktjava == 'on')
				$db->query("UPDATE ".USERS." SET `db_deaktjava` = '".time()."' WHERE `id` = '".$CurrentUser['id']."' LIMIT 1;");
			else
				$db->query("UPDATE ".USERS." SET `db_deaktjava` = '0' WHERE `id` = '".$CurrentUser['id']."' LIMIT 1;");
			
			die(header("location:game.php?page=options"));
		}
		
		$PlanetRess = new ResourceUpdate($CurrentUser, $CurrentPlanet);
		
		$template	= new template();
		$template->set_vars($CurrentUser, $CurrentPlanet);
		$template->page_header();	
		$template->page_topnav();
		$template->page_leftmenu();
		$template->page_planetmenu();
		$template->page_footer();
		
		if ($mode == "change")
		{
			if ($CurrentUser['authlevel'] > 0)
			{
				if (request_var('adm_pl_prot', '') == 'on')
					$db->query ("UPDATE ".PLANETS." SET `id_level` = '".$CurrentUser['authlevel']."' WHERE `id_owner` = '".$CurrentUser['id']."';");
				else
					$db->query ("UPDATE ".PLANETS." SET `id_level` = '0' WHERE `id_owner` = '".$CurrentUser['id']."';");
			}
			// < ------------------------------------------------------------------- EL SKIN ------------------------------------------------------------------- >
			$design 				= request_var('design', '');
			$noipcheck 				= request_var('noipcheck', '');
			$username 				= request_var('db_character', $CurrentUser['username']);
			$db_email 				= request_var('db_email', $CurrentUser['email']);
			$spio_anz 				= request_var('spio_anz', 5);
			$settings_tooltiptime 	= request_var('settings_tooltiptime', '');
			$settings_fleetactions 	= request_var('settings_fleetactions', '');
			$settings_planetmenu	= request_var('settings_planetmenu', '');
			$settings_esp 			= request_var('settings_esp', '');
			$settings_wri 			= request_var('settings_wri', '');
			$settings_bud 			= request_var('settings_bud', '');
			$settings_mis 			= request_var('settings_mis', '');
			$settings_rep 			= request_var('settings_rep', '');
			$urlaubs_modus 			= request_var('urlaubs_modus', '');
			$SetSort  				= request_var('settings_sort' , '');
			$SetOrder 				= request_var('settings_order', '');
			$dpath    				= request_var('dpath', '');
			$db_password			= request_var('db_password', '');
			$newpass1				= request_var('newpass1', '');
			$newpass2				= request_var('newpass2', '');		
			$hof					= request_var('hof', '');	
			
			if ($design == 'on')
			{
				$design = "1";
			}
			else
			{
				$design = "0";
			}

			if ($hof == 'on')
			{
				$hof = "1";
			}
			else
			{
				$hof = "0";
			}
			// < ------------------------------------------------------------- COMPROBACION DE IP ------------------------------------------------------------- >
			if ($noipcheck == 'on')
			{
				$noipcheck = "1";
			}
			else
			{
				$noipcheck = "0";
			}

			// < ------------------------------------------------------------- CANTIDAD DE SONDAS ------------------------------------------------------------- >
			if (!is_numeric($spio_anz))
			{
				$spio_anz = "1";
			}
			// < ------------------------------------------------------------- TIEMPO TOOLTIP ------------------------------------------------------------- >
			if (!is_numeric($settings_tooltiptime))
			{
				$settings_tooltiptime = "1";
			}
			// < ------------------------------------------------------------- MENSAJES DE FLOTAS ------------------------------------------------------------- >
			if (!is_numeric($settings_fleetactions))
			{
				$settings_fleetactions = "1";
			}
			// < ------------------------------------------------------------ SONDAS DE ESPIONAJE ------------------------------------------------------------ >
			if ($settings_esp == 'on')
			{
				$settings_esp = "1";
			}
			else
			{
				$settings_esp = "0";
			}
			// < ------------------------------------------------------------ ESCRIBIR MENSAJE ------------------------------------------------------------ >
			if ($settings_wri == 'on')
			{
				$settings_wri = "1";
			}
			else
			{
				$settings_wri = "0";
			}
			// < ------------------------------------------------------------ AÑADIR A LISTA DE AMIGOS ------------------------------------------------------------ >
			if ($settings_bud == 'on')
			{
				$settings_bud = "1";
			}
			else
			{
				$settings_bud = "0";
			}
			// < ------------------------------------------------------------ ATAQUE CON MISILES ------------------------------------------------------------ >
			if ($settings_mis == 'on')
			{
				$settings_mis = "1";
			}
			else
			{
				$settings_mis = "0";
			}
			// < ------------------------------------------------------------ VER REPORTE ------------------------------------------------------------ >
			if ($settings_rep == 'on')
			{
				$settings_rep = "1";
			}
			else
			{
				$settings_rep = "0";
			}

			if ($settings_planetmenu == 'on')
			{
				$settings_planetmenu = "1";
			}
			else
			{
				$settings_planetmenu = "0";
			}
			// < ------------------------------------------------------------ MODO VACACIONES ------------------------------------------------------------ >
			if ($urlaubs_modus == 'on')
			{
				if($this->CheckIfIsBuilding($CurrentUser))
				{
					$template->message($lang['op_cant_activate_vacation_mode'], "game.php?page=options",1);
				}

				$urlaubs_modus = "1";
				$time = time() + 86400;
				$db->query("UPDATE ".USERS." SET
				`urlaubs_modus` = '".$urlaubs_modus."',
				`urlaubs_until` = '".$time."'
				WHERE `id` = '".$CurrentUser["id"]."' LIMIT 1", "users");

				$query = $db->query("SELECT id FROM ".PLANETS." WHERE id_owner = '".$CurrentUser['id']."';");

				while($id = $db->fetch_array($query))
				{
					$db->query("UPDATE ".PLANETS." SET
					metal_perhour = '".$game_config['metal_basic_income']."',
					crystal_perhour = '".$game_config['crystal_basic_income']."',
					deuterium_perhour = '".$game_config['deuterium_basic_income']."',
					energy_used = '0',
					energy_max = '0',
					metal_mine_porcent = '0',
					crystal_mine_porcent = '0',
					deuterium_sintetizer_porcent = '0',
					solar_plant_porcent = '0',
					fusion_plant_porcent = '0',
					solar_satelit_porcent = '0'
					WHERE id = '".$id['id']."' AND `planet_type` = 1;");
				}
			}
			else
				$urlaubs_modus = "0";

			// < ------------------------------------------------------------ BORRAR CUENTA ------------------------------------------------------------ >
			if ($db_deaktjava == 'on')
			{
				$db_deaktjava = time();
			}
			else
			{
				$db_deaktjava = "0";
			}

			// < ---------------------------------------------------- ACTUALIZAR TODO LO SETEADO ANTES ---------------------------------------------------- >
			$db->query("UPDATE ".USERS." SET
			`email` = '".$db_email."',
			`dpath` = '".$db->sql_escape($dpath)."',
			`design` = '".$design."',
			`noipcheck` = '".$noipcheck."',
			`planet_sort` = '".$db->sql_escape($SetSort)."',
			`planet_sort_order` = '".$db->sql_escape($SetOrder)."',
			`spio_anz` = '".$db->sql_escape($spio_anz)."',
			`settings_tooltiptime` = '".$settings_tooltiptime."',
			`settings_fleetactions` = '".$settings_fleetactions."',
			`settings_planetmenu` = '".$settings_planetmenu."',
			`settings_esp` = '".$settings_esp."',
			`settings_wri` = '".$settings_wri."',
			`settings_bud` = '".$settings_bud."',
			`settings_mis` = '".$settings_mis."',
			`hof` = '".$hof."',
			`settings_rep` = '".$settings_rep."',
			`urlaubs_modus` = '".$urlaubs_modus."',
			`db_deaktjava` = '".$db_deaktjava."'
			WHERE `id` = '".$CurrentUser["id"]."' LIMIT 1;");
			// < ------------------------------------------------------------- CAMBIO DE CLAVE ------------------------------------------------------------- >
			if (md5($db_password) == $CurrentUser["password"] && $newpass1 == $newpass2 && !empty($newpass1))
			{
				$newpass = md5($newpass1);
				$db->query("UPDATE ".USERS." SET `password` = '".$newpass."' WHERE `id` = '".$CurrentUser['id']."' LIMIT 1;");
				setcookie($game_config['COOKIE_NAME'], "", time()-100000, "/", "", 0);
				$template->message($lang['op_password_changed'],"index.php",1);
			}
			// < ------------------------------------------------------- CAMBIO DE NOMBRE DE USUARIO ------------------------------------------------------ >
			elseif ($CurrentUser['username'] != $username)
			{
				if (!ctype_alnum($username))
					$template->message($lang['op_user_name_no_alphanumeric'], "game.php?page=options", 1);
				elseif($CurrentUser['uctime'] >= time() - (60 * 60 * 24 * 7))
					$template->message($lang['op_change_name_pro_week'], "game.php?page=options", 1);
				else
				{
					$query = $db->fetch_array($db->query("SELECT id FROM ".USERS." WHERE username='".$db->sql_escape($username)."';"));
					
					if (!empty($query))
						$template->message($lang['op_change_name_exist'], "game.php?page=options", 1);
					else 
					{
						$db->query("UPDATE ".USERS." SET `username` = '".$db->sql_escape($username)."', `uctime` = '".time()."' WHERE `id`= '".$CurrentUser['id']."' LIMIT 1;");
						setcookie($game_config['COOKIE_NAME'], "", time()-100000, "/", "", 0);
						$template->message($lang['op_username_changed'], "index.php", 1);
					}
				}
			}
			else
				$template->message($lang['op_options_changed'], "game.php?page=options", 1);
			
			$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
		}
		else
		{
			if($CurrentUser['urlaubs_modus'] == 1)
			{
				$template->assign_vars(array(	
					'vacation_until'					=> date("d.m.Y G:i:s",$CurrentUser['urlaubs_until']),
					'op_save_changes'					=> $lang['op_save_changes'],
					'op_end_vacation_mode'				=> $lang['op_end_vacation_mode'],
					'op_vacation_mode_active_message'	=> $lang['op_vacation_mode_active_message'],
					'op_dlte_account_descrip'			=> $lang['op_dlte_account_descrip'],
					'op_dlte_account'					=> $lang['op_dlte_account'],
					'opt_delac_data'					=> $CurrentUser['db_deaktjava'],
				));
				$template->show("options_overview_vmode.tpl");
			}
			else
			{
				$template->assign_vars(array(	
					'opt_usern_data'					=> $CurrentUser['username'],
					'opt_mail1_data'					=> $CurrentUser['email'],
					'opt_mail2_data'					=> $CurrentUser['email_2'],
					'opt_dpath_data'					=> $CurrentUser['dpath'],
					'opt_probe_data'					=> $CurrentUser['spio_anz'],
					'opt_toolt_data'					=> $CurrentUser['settings_tooltiptime'],
					'opt_fleet_data'					=> $CurrentUser['settings_fleetactions'],
					'opt_sskin_data'					=> $CurrentUser['design'],
					'opt_noipc_data'					=> $CurrentUser['noipcheck'],
					'opt_allyl_data'					=> $CurrentUser['settings_planetmenu'],
					'opt_delac_data'					=> $CurrentUser['db_deaktjava'],
					'user_settings_rep' 				=> $CurrentUser['settings_rep'],
					'user_settings_esp' 				=> $CurrentUser['settings_esp'],
					'user_settings_wri' 				=> $CurrentUser['settings_wri'],
					'user_settings_mis' 				=> $CurrentUser['settings_mis'],
					'user_settings_bud' 				=> $CurrentUser['settings_bud'],
					'opt_hof'							=> $CurrentUser['hof'],
					'db_deaktjava'						=> $CurrentUser['db_deaktjava'],
					'adm_pl_prot_data'					=> $CurrentPlanet['id_level'],					
					'user_authlevel'					=> $CurrentUser['authlevel'],					
					'Selectors'							=> array('Sort' => array(0 => $lang['op_sort_normal'], 1 => $lang['op_sort_koords'], 2 => $lang['op_sort_abc']), 'SortUpDown' => array(0 => $lang['op_sort_up'], 1 => $lang['op_sort_down'])),
					'planet_sort'						=> $CurrentUser['planet_sort'],
					'planet_sort_order'					=> $CurrentUser['planet_sort_order'],
					'uctime'							=> (time() - $CurrentUser['uctime'] >= (60 * 60 * 24 * 7)) ? true : false,
					'op_admin_planets_protection'		=> $lang['op_admin_planets_protection'],
					'op_admin_title_options'			=> $lang['op_admin_title_options'],
					'op_user_data'						=> $lang['op_user_data'],
					'op_username'						=> $lang['op_username'],
					'op_old_pass'						=> $lang['op_old_pass'],
					'op_new_pass'						=> $lang['op_new_pass'],
					'op_repeat_new_pass'				=> $lang['op_repeat_new_pass'],
					'op_email_adress_descrip'			=> $lang['op_email_adress_descrip'],
					'op_email_adress'					=> $lang['op_email_adress'],
					'op_permanent_email_adress'			=> $lang['op_permanent_email_adress'],
					'op_general_settings'				=> $lang['op_general_settings'],
					'op_sort_planets_by'				=> $lang['op_sort_planets_by'],
					'op_sort_kind'						=> $lang['op_sort_kind'],
					'op_skin_example'					=> $lang['op_skin_example'],
					'op_show_skin'						=> $lang['op_show_skin'],
					'op_active_build_messages'			=> $lang['op_active_build_messages'],
					'op_deactivate_ipcheck_descrip'		=> $lang['op_deactivate_ipcheck_descrip'],
					'op_deactivate_ipcheck'				=> $lang['op_deactivate_ipcheck'],
					'op_galaxy_settings'				=> $lang['op_galaxy_settings'],
					'op_spy_probes_number_descrip'		=> $lang['op_spy_probes_number_descrip'],
					'op_spy_probes_number'				=> $lang['op_spy_probes_number'],
					'op_seconds'						=> $lang['op_seconds'],
					'op_toolt_data'						=> $lang['op_toolt_data'],
					'op_max_fleets_messages'			=> $lang['op_max_fleets_messages'],
					'op_show_planetmenu'				=> $lang['op_show_planetmenu'],
					'op_shortcut'						=> $lang['op_shortcut'],
					'op_show'							=> $lang['op_show'],
					'op_spy'							=> $lang['op_spy'],
					'op_write_message'					=> $lang['op_write_message'],
					'op_add_to_buddy_list'				=> $lang['op_add_to_buddy_list'],
					'op_missile_attack'					=> $lang['op_missile_attack'],
					'op_send_report'					=> $lang['op_send_report'],
					'op_vacation_delete_mode'			=> $lang['op_vacation_delete_mode'],
					'op_activate_vacation_mode_descrip'	=> $lang['op_activate_vacation_mode_descrip'],
					'op_activate_vacation_mode'			=> $lang['op_activate_vacation_mode'],
					'op_dlte_account_descrip'			=> $lang['op_dlte_account_descrip'],
					'op_dlte_account'					=> $lang['op_dlte_account'],
					'op_save_changes'					=> $lang['op_save_changes'],
				));
				
				$template->show("options_overview.tpl");
			}
		}
	}
}
?>