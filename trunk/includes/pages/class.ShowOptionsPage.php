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
		
		$PlanetRess = new ResourceUpdate($CurrentUser, $CurrentPlanet);
		
		$template	= new template();
		$template->set_vars($CurrentUser, $CurrentPlanet);
		$template->page_header();	
		$template->page_topnav();
		$template->page_leftmenu();
		$template->page_planetmenu();
		$template->page_footer();
		
		switch($mode)
		{
			case "exit":
				if ($exit == 'on' and $CurrentUser['urlaubs_until'] <= time())
					$SQLQuery	.= "UPDATE ".USERS." SET `urlaubs_modus` = '0', `urlaubs_until` = '0' WHERE `id` = '".$CurrentUser['id']."' LIMIT 1;";
				
				if ($db_deaktjava == 'on')
					$SQLQuery	.= "UPDATE ".USERS." SET `db_deaktjava` = '".time()."' WHERE `id` = '".$CurrentUser['id']."' LIMIT 1;";
				else
					$SQLQuery	.= "UPDATE ".USERS." SET `db_deaktjava` = '0' WHERE `id` = '".$CurrentUser['id']."' LIMIT 1;";
				
				$db->multi_query($SQLQuery);
				$template->message($lang['op_options_changed'], "game.php?page=options", 1);
				$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
			break;
			case "change":
				$design 				= request_var('design', '');
				$noipcheck 				= request_var('noipcheck', '');
				$username 				= request_var('db_character', $CurrentUser['username']);
				$db_email 				= request_var('db_email', $CurrentUser['email']);
				$spio_anz 				= request_var('spio_anz', 5);
				$settings_tooltiptime 	= request_var('settings_tooltiptime', 1);
				$settings_fleetactions 	= request_var('settings_fleetactions', 1);
				$settings_planetmenu	= request_var('settings_planetmenu', '');
				$settings_esp 			= request_var('settings_esp', '');
				$settings_wri 			= request_var('settings_wri', '');
				$settings_bud 			= request_var('settings_bud', '');
				$settings_mis 			= request_var('settings_mis', '');
				$settings_rep 			= request_var('settings_rep', '');
				$urlaubs_modus 			= request_var('urlaubs_modus', '');
				$SetSort  				= request_var('settings_sort' , 0);
				$SetOrder 				= request_var('settings_order', 0);
				$dpath    				= request_var('dpath', '');
				$db_password			= request_var('db_password', '');
				$newpass1				= request_var('newpass1', '');
				$newpass2				= request_var('newpass2', '');		
				$hof					= request_var('hof', '');	
				$adm_pl_prot			= request_var('adm_pl_prot', '');	
				
				$design 				= ($design == 'on') ? 1 : 0;
				$hof 					= ($hof == 'on') ? 1 : 0;
				$noipcheck 				= ($noipcheck == 'on') ? 1 : 0;
				$settings_esp			= ($settings_esp == 'on') ? 1 : 0;
				$settings_wri			= ($settings_wri == 'on') ? 1 : 0;
				$settings_bud			= ($settings_bud == 'on') ? 1 : 0;
				$settings_mis			= ($settings_mis == 'on') ? 1 : 0;
				$settings_rep 			= ($settings_rep == 'on') ? 1 : 0;
				$settings_planetmenu	= ($settings_planetmenu == 'on') ? 1 : 0;
				$db_deaktjava 			= ($db_deaktjava == 'on') ? time() : 0;
				
				if ($urlaubs_modus == 'on')
				{
					if($this->CheckIfIsBuilding($CurrentUser))
					{
						$template->message($lang['op_cant_activate_vacation_mode'], "game.php?page=options",1);
						$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
						exit;
					}
					
					$time = time() + 86400;
					$SQLQuery	.= "UPDATE ".USERS." SET `urlaubs_modus` = '1', `urlaubs_until` = '".$time."' WHERE `id` = '".$CurrentUser["id"]."' LIMIT 1;";

					$query = $db->query("SELECT `id` FROM ".PLANETS." WHERE `id_owner` = '".$CurrentUser['id']."';");
					
					while($id = $db->fetch_array($query))
					{
						$SQLQuery	.=  "UPDATE ".PLANETS." SET
										`metal_perhour` = '".$game_config['metal_basic_income']."',
										`crystal_perhour` = '".$game_config['crystal_basic_income']."',
										`deuterium_perhour` = '".$game_config['deuterium_basic_income']."',
										`venergy_used` = '0',
										`energy_max` = '0',
										`metal_mine_porcent` = '0',
										`crystal_mine_porcent` = '0',
										`deuterium_sintetizer_porcent` = '0',
										`solar_plant_porcent` = '0',
										`fusion_plant_porcent` = '0',
										`solar_satelit_porcent` = '0'
										WHERE `id` = '".$id['id']."';";
					}
				}
				else
					$urlaubs_modus = "0";

				$SQLQuery	.=  "UPDATE ".USERS." SET
								`email` = '".$db_email."',
								`dpath` = '".$db->sql_escape($dpath)."',
								`design` = '".$design."',
								`noipcheck` = '".$noipcheck."',
								`planet_sort` = '".$SetSort."',
								`planet_sort_order` = '".$SetOrder."',
								`spio_anz` = '".$spio_anz."',
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
								WHERE `id` = '".$CurrentUser["id"]."' LIMIT 1;";
				
				if ($CurrentUser['authlevel'] > 0)
				{
					if ($adm_pl_prot == 'on')
						$SQLQuery	.= "UPDATE ".PLANETS." SET `id_level` = '".$CurrentUser['authlevel']."' WHERE `id_owner` = '".$CurrentUser['id']."';";
					else
						$SQLQuery	.= "UPDATE ".PLANETS." SET `id_level` = '0' WHERE `id_owner` = '".$CurrentUser['id']."';";
				}
				
				
				if (md5($db_password) == $CurrentUser["password"] && $newpass1 == $newpass2 && !empty($newpass1))
				{
					$newpass 	 = md5($newpass1);
					$SQLQuery	.= "UPDATE ".USERS." SET `password` = '".$newpass."' WHERE `id` = '".$CurrentUser['id']."' LIMIT 1;";
					setcookie($game_config['COOKIE_NAME'], "", time()-100000, "/", "", 0);
					$template->message($lang['op_password_changed'],"index.php",1);
				}
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
							$SQLQuery	.= "UPDATE ".USERS." SET `username` = '".$db->sql_escape($username)."', `uctime` = '".time()."' WHERE `id`= '".$CurrentUser['id']."' LIMIT 1;";
							setcookie($game_config['COOKIE_NAME'], "", time()-100000, "/", "", 0);
							$template->message($lang['op_username_changed'], "index.php", 1);
						}
					}
				}
				else
					$template->message($lang['op_options_changed'], "game.php?page=options", 1);
				
				$db->multi_query($SQLQuery);
				$PlanetRess->SavePlanetToDB($CurrentUser, $CurrentPlanet);
			break;
			default;
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
						'is_deak_vacation'					=> $CurrentUser['urlaubs_until'] <= time() ? true : false,
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
			break;
		}
	}
}
?>